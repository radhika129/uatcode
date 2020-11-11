<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['pid']))
{
	$pid=$_REQUEST['pid'];
	$sid=$_REQUEST['sid'];
 	$promo=$_REQUEST['promo_code'];
 	$valid=$_REQUEST['valid_till'];
 	$moa=$_REQUEST['minimum_order_amount'];
	$discounttype=$_REQUEST['discount_type'];
	$discountvalue=$_REQUEST['discount_value'];
	$status = $_REQUEST['status'];
	if($_REQUEST['discount_type']=='None')
		{
			$discountvalue=0;
		}
 	$check=query("select * from promocodes where seller_id='".$sid."'and product_id='".$pid."' and promo_code='".$promo."'");
	confirm($check);

	if(mysqli_num_rows($check)!=0)
	{
	 	

	 	$query=query("update promocodes set promo_code='".$promo."',expiry_date='".$valid."',minimum_order_amount='".$moa."',discount_type='".$discounttype."',discount_value='".$discountvalue."',is_active='".$status."',updated_datetime=NOW() where seller_id='".$sid."' and id='".$pid."'");
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
	 		echo json_encode(array("promos"=>$temp));
	 	}
	 	else
	 	{
	 		rollback();
	 		$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("promos"=>$temp));
	 	}
	}
	else
	{
		$temp=array();

		$temp['response_code']=404;			
		$temp['response_desc']="No Results Found";
		echo json_encode(array("promos"=>$temp));
	}
}
else
{
	$temp=array();

	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("promos"=>$temp));
}
close();
?>
