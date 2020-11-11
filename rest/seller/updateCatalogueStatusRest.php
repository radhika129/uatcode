<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='' && isset($_REQUEST['catalogue_id'])&&$_REQUEST['catalogue_id']!='')
{	
	$user_id=$_REQUEST['user_id'];
	
	if(isset($_REQUEST['catalogue_status'])&&$_REQUEST['catalogue_status']!='')
	{
		$query="update product_catalogue set 
					catalogue_status ='".$_REQUEST['catalogue_status']."'
					where 
						catalogue_seller_id='".$user_id."' 
					and 
						catalogue_id='".$_REQUEST['catalogue_id']."'";
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
	 		echo json_encode(array("updatecatalogue"=>$temp));
		}
		else
		{
			rollback();
			$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("updatecatalogue"=>$temp));
		}
	}
	else
	{
		$temp=array();
		$temp['response_code']=405;
		$temp['response_desc']="Not Allowed";
 		echo json_encode(array("updatecatalogue"=>$temp));
	}	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatecatalogue"=>$temp));
}
close();
?>
