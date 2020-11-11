<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!='')
{
	
	$query="select user_id from users where mobile='".$_REQUEST['mobile']."'";
	$query=query($query);
	confirm($query);
	$row=fetch_array($query);
	$user=$row['user_id'];
	$query="delete from users where user_id='".$user."'";
	$query=query($query);
	confirm($query);
	$query="delete from promocodes where seller_id='".$user."'";
	$query=query($query);
	confirm($query);
	$query="delete from product_catalogue where catalogue_seller_id='".$user."'";
	$query=query($query);
	confirm($query);
	$query="delete from delivery_charges where seller_id='".$user."'";
	$query=query($query);
	confirm($query);
	$query="delete from product_default_settings where seller_id='".$user."'";
	$query=query($query);
	confirm($query);
	$query="delete from product_details where product_seller_id='".$user."'";
	$query=query($query);
	confirm($query);
	$query="delete from reviews where seller_id='".$user."'";
	$query=query($query);
	$result=confirm($query);
	if(!$result)
	{
		$flag=false;
	}
	$query="delete from seller_details where seller_id='".$user."'";
	$query=query($query);
	$result=confirm($query);
	if(!$result)
	{
		$flag=false;
	}
	$query="delete from shipping_charges where seller_id='".$user."'";
	$query=query($query);
	$result=confirm($query);
	if(!$result)
	{
		$flag=false;
	}
	$query="delete from tickets where seller_id='".$user."'";
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
		$temp['response_desc']="success";
		echo json_encode(array("delete"=>$temp));
	}
	else
	{
		rollback();
		$temp=array();
		$temp['response_code']=404;			
		$temp['response_desc']="Invalid Operation";
		echo json_encode(array("delete"=>$temp));
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;			
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("delete"=>$temp));
}
close();
?>
