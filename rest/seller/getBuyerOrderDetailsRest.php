<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='' && isset($_REQUEST['order_id']) && $_REQUEST['order_id']!='')
{		
	// if(isset($_REQUEST['start']))
	// 	$start=$_REQUEST['start'];

	// if(isset($_REQUEST['end']))
	// 	$end=$_REQUEST['end'];

	$order_id=$_REQUEST['order_id'];
	$user_id = $_REQUEST['user_id'];
	
	$query="SELECT 
		orders.order_id,
		basket_order.order_date,
		basket_order.discount,
		orders.order_amount_total,
		orders.order_quantity,
		basket_order.customer_mobile,
		basket_order.customer_email,
		basket_order.delivery_charge,
		basket_order.order_type,
		basket_order.customer_name,
		basket_order.delivery_address1,
		basket_order.delivery_address2,
		basket_order.city,
		basket_order.state,
		basket_order.country,
		basket_order.pincode,
		basket_order.payment_method,
		basket_order.total_items,
		basket_order.net_amount,
		basket_order.order_status, 
		product_details.product_name,
		product_details.product_price,
		product_details.productimage
		 
		FROM 
			orders,
			basket_order,
			product_details 
		where 
			basket_order.seller_id='".$user_id."' 
			and 
			product_details.product_seller_id='".$user_id."' 
			and 
			basket_order.basket_order_id='".$order_id."' 
			and
			basket_order.basket_order_id=orders.order_id  
			and 
			orders.product_id=product_details.product_id
			and
			basket_order.order_status!='deleted' 
			order by basket_order.id desc";
	
	//echo $query;
	$query=query($query);
	confirm($query);

	$sum=0;
	$discount=0;
	$delivery_charge=0;
	$total_amount=0;
	$order_id=0;
	$customer_name="";
	$customer_mobile="";
	$customer_email="";
	$order_date="";
	$order_type="";
	$payment_method="";
	$delivery_address1="";
	$delivery_address2="";
	$order_status="";
	$city='';
	$state='';
	$pincode='';
	$country='';
	$rows=mysqli_num_rows($query);

	if($rows!=0)
	{
		$temp=array();
		
		while($row=fetch_array($query))
		{	
			$sum+=$row['order_amount_total'];
			$discount=$row['discount'];
			$delivery_charge=$row['delivery_charge'];
			$total_amount=$row['net_amount'];

			$order_id=$row['order_id'];
			$customer_name=$row['customer_name'];
			$customer_mobile=$row['customer_mobile'];
			$customer_email=$row['customer_email'];
			$order_date=$row['order_date'];
			$order_type=$row['order_type'];
			$payment_method=$row['payment_method'];
			$delivery_address1=$row['delivery_address1'];
			$delivery_address2=$row['delivery_address2'];
			$city=$row['city'];
			$state=$row['state'];
			$pincode=$row['pincode'];
			$country=$row['country'];
			$order_status=$row['order_status'];

			$temp[]=$row;
		}

		$temp['item_total']=$sum;
		$temp['discount']=$discount;
		$temp['delivery_charge']=$delivery_charge;
		$temp['total_amount'] =$total_amount;

		$temp['order_id']=$order_id;
		$temp['customer_name']=$customer_name;
		$temp['customer_mobile']=$customer_mobile;
		$temp['customer_email']=$customer_email;
		$temp['order_date']=$order_date;
		$temp['order_type']=$order_type;
		$temp['payment_method']=$payment_method;
		$temp['delivery_address']=$delivery_address1;
		$temp['delivery_address1']=$delivery_address1;
		$temp['delivery_address2']=$delivery_address2;
		$temp['order_status']=$order_status;
		$temp['city']=$city;
		$temp['state']=$state;
		$temp['pincode']=$pincode;
		$temp['country']=$country;
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
