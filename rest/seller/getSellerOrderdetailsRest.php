<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='')
{		
	if(isset($_REQUEST['start']))
		$start=$_REQUEST['start'];
	else
		$start=0;

	if(isset($_REQUEST['end']))
		$end=$_REQUEST['end'];
	else
		$end=10;

	$user_id=$_REQUEST['user_id'];
	$query='';
	if(isset($_REQUEST['order_date']) && $_REQUEST['order_date']!='')
	{
		$query="SELECT basket_order_id,order_type,order_date,basket_order.customer_name,total_items,net_amount,basket_order.order_status FROM basket_order where basket_order.seller_id='".$user_id."'  and order_date like '%".$_REQUEST['order_date']."%' and order_status not in('Draft','deleted') order by id desc";
	}
	else if(isset($_REQUEST['order_id']) && $_REQUEST['order_id']!='')
	{
		$query="SELECT basket_order_id,order_type,order_date,basket_order.customer_name,total_items,net_amount,basket_order.order_status FROM basket_order where basket_order.seller_id='".$user_id."' and basket_order_id='".$_REQUEST['order_id']."' and order_status not in('Draft','deleted') order by id desc";
	}
	else if(isset($_REQUEST['order_status']) && $_REQUEST['order_status']!='')
	{
		$query="SELECT basket_order_id,order_type,order_date,basket_order.customer_name,total_items,net_amount,basket_order.order_status FROM basket_order where basket_order.seller_id='".$user_id."' and order_status='".$_REQUEST['order_status']."' and order_status not in('Draft','deleted') order by id desc";
	}
	else if(isset($_REQUEST['customer_name']) && $_REQUEST['customer_name']!='')
	{
		$query="SELECT basket_order_id,order_type,order_date,basket_order.customer_name,total_items,net_amount,basket_order.order_status FROM basket_order where basket_order.seller_id='".$user_id."' and customer_name like '%".$_REQUEST['customer_name']."%' and order_status not in('Draft','deleted') order by id desc";
	}
	else if(isset($_REQUEST['customer_mobile']) && $_REQUEST['customer_mobile']!='')
	{
		$query="SELECT basket_order_id,order_type,order_date,basket_order.customer_name,total_items,net_amount,basket_order.order_status FROM basket_order where basket_order.seller_id='".$user_id."' and customer_mobile='".$_REQUEST['customer_mobile']."' and order_status not in('Draft','deleted')  order by id desc";
	}
	else
	{
		$query="SELECT basket_order_id,order_type,order_date,basket_order.customer_name,total_items,net_amount,basket_order.order_status FROM basket_order where basket_order.seller_id='".$user_id."' and order_status not in('Draft','deleted') order by id desc limit ".$start.",".$end."";
	}

	$query=query($query);
	confirm($query);
	$rows=mysqli_num_rows($query);
	if($rows!=0)
	{
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp[]=$row;
		}
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=$rows;
 		echo json_encode(array("getorders"=>$temp));
 	}		
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getorders"=>$temp));
}
close();
?>
