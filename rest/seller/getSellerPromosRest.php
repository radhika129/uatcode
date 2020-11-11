<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['sid']))
{
	$sid=$_REQUEST['sid'];
	
	$name="";
	if(isset($_REQUEST['start']))
		$start=$_REQUEST['start'];
	else
		$start=0;

	if(isset($_REQUEST['end']))
		$end=$_REQUEST['end'];
	else
		$end=10;
	if(isset($_REQUEST['name']))
		$name=$_REQUEST['name'];
	if(isset($_REQUEST['status']))
		$status=$_REQUEST['status'];
	$query='';

	if(isset($name) && $name!="")
	{
		$query=query("SELECT promocodes.id,promocodes.seller_id,minimum_order_amount,discount_type,discount_value,is_active,expiry_date,promocodes.promo_code,count(basket_order.promo_code) promos_applied FROM promocodes LEFT JOIN basket_order on promocodes.promo_code=basket_order.promo_code where promocodes.seller_id=".$sid." and promocodes.promo_code like '%".$name."%' group by promocodes.promo_code order by id desc");
	}
	else if(isset($status) && $status!="")
	{
		$query=query("SELECT promocodes.id,promocodes.seller_id,minimum_order_amount,discount_type,discount_value,is_active,expiry_date,promocodes.promo_code,count(basket_order.promo_code) promos_applied FROM promocodes LEFT JOIN basket_order on promocodes.promo_code=basket_order.promo_code where promocodes.seller_id= ".$sid." and promocodes.is_active='".$status."' group by promocodes.promo_code order by id desc");
	}
	else
	{
		$query="SELECT promocodes.id,promocodes.seller_id,minimum_order_amount,discount_type,discount_value,is_active,expiry_date,promocodes.promo_code,count(basket_order.promo_code) as promos_applied FROM promocodes LEFT JOIN basket_order on promocodes.promo_code=basket_order.promo_code where promocodes.seller_id=".$sid." group by promocodes.promo_code  order by promocodes.id limit ".$start.",".$end."";
		//echo $query;
		$query=query($query);
	}
	
	confirm($query);
	$rows=0;
	if(mysqli_num_rows($query)!=0)		// Valid Request, Data Found.
	{
		$temp=array();
		while($row=fetch_array($query))
		{
			
			$row['expiry_date']=date('d-M-Y',strtotime($row['expiry_date']));
			$temp[]=$row;
		}
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=mysqli_num_rows($query);
		//print_r($temp);
 		echo json_encode(array("promos"=>$temp));
 	}
 	else
 	{
 		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']="Record Not Found";
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
