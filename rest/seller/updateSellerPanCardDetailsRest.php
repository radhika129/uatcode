<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	
	
		
		$query="update seller_details set 
						seller_panname='".$_REQUEST['panname']."',
						seller_pannum='".$_REQUEST['pannumber']."'
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
	 		echo json_encode(array("updatepancarddetails"=>$temp));
	 	}
	 	else
	 	{
	 		rollback();
	 		$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("updatepancarddetails"=>$temp));
	 	}
	
	
	
}
else
{
	$temp=array();
	$temp['response_code']=405;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatepancarddetails"=>$temp));
}
close();	
?>
