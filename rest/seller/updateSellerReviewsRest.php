<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='' && isset($_REQUEST['review'])&&$_REQUEST['review']!='' && isset($_REQUEST['reviewtitle'])&&$_REQUEST['reviewtitle']!='' )
{	
	$query="SELECT seller_id FROM reviews WHERE seller_id = '".$_REQUEST['user_id']."'";
	$query=query($query);
	confirm($query);
	$rows=mysqli_num_rows($query);

	if($rows!=0)
	{
		$query="update reviews set 
					rating ='".$_REQUEST['rating']."',
					review_title ='".$_REQUEST['reviewtitle']."',
					review ='".$_REQUEST['review']."',
					creation_date_time=NOW()		
					where  
						seller_id='".$_REQUEST['user_id']."'";
		
		
	}
	else
	{
		$query= "insert into reviews (seller_id,rating,review_title,review) values('".$_REQUEST['user_id']."','".$_REQUEST['rating']."','".$_REQUEST['reviewtitle']."','".$_REQUEST['review']."')";
		
		
	}
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
	 		echo json_encode(array("updatereviews"=>$temp));
	 	}
	 	else
	 	{
	 		rollback();
	 		$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("updatereviews"=>$temp));
	 	}
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatereviews"=>$temp));
}
close();	
?>
