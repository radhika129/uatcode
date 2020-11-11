<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='' && isset($_REQUEST['businessname'])&&$_REQUEST['businessname']!=''&& isset($_REQUEST['alt_number'])&&$_REQUEST['alt_number']!='' )
{	
	
		$query="update users set 
					business_name ='".$_REQUEST['businessname']."'
					where  
						user_id='".$_REQUEST['user_id']."'";
		//echo $query;
		$query=query($query);
		
		$result=confirm($query);
		if(!$result)
		{
			$flag=false;
		}
		$query="update seller_details set 
						seller_business_name ='".$_REQUEST['businessname']."',
						seller_email ='".$_REQUEST['email']."',
						alternate_contact_verified='".$_REQUEST['alt_number_status']."',
						seller_alternate_number ='".$_REQUEST['alt_number']."'
						where  
							seller_id='".$_REQUEST['user_id']."'";
		//echo $query;
		$query=query($query);
		$result=confirm($query);
		if(!$result)
		{
			$flag=false;
		}
		if($flag)
		{
			commit();
			$temp=array();
			$temp['response_code']=200;
			$temp['response_desc']="Success";
	 		echo json_encode(array("updatebusinessname"=>$temp));

		}
		else
		{
			rollback();
			$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("updatebusinessname"=>$temp));
		}
	
	
	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatebusinessname"=>$temp));
}
	close();
?>
