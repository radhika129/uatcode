<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['sid']) && $_REQUEST['sid']!=''&&isset($_REQUEST['promo_code']) && $_REQUEST['promo_code']!='' && isset($_REQUEST['valid_till']) && $_REQUEST['valid_till'] && isset($_REQUEST['minimum_order_amount']) && $_REQUEST['minimum_order_amount'] && isset($_REQUEST['discount_type'])&& $_REQUEST['discount_type']!='' && isset($_REQUEST['discount_value'])&&$_REQUEST['discount_value']!='')
{
	$sid=$_REQUEST['sid'];
	$promo=$_REQUEST['promo_code'];
	$valid=$_REQUEST['valid_till'];
	$moa=$_REQUEST['minimum_order_amount'];
	$discounttype=$_REQUEST['discount_type'];
	$discountvalue=$_REQUEST['discount_value'];
	$check=query("select * from promocodes where seller_id='".$sid."' and promo_code='".$promo."'");
	confirm($check);
	if($_REQUEST['discount_type']=='None')
		{
			$discountvalue=0;
		}
	if(mysqli_num_rows($check)==0)
	{
		$query=query("INSERT into promocodes (seller_id,promo_code,expiry_date,minimum_order_amount,discount_type,discount_value) values('".$sid."','".$promo."','".$valid."','".$moa."','".$discounttype."','".$discountvalue."')");
		//echo $query;
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

		$temp['response_code']=405;			// 405 means 'Not Allowed'
		$temp['response_desc']="Not Allowed";
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
