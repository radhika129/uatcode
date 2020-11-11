
<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	
	$date="";
	if(isset($_REQUEST['date'])&&$_REQUEST['date']!='')
	{
		$date = $_REQUEST['date'];
	}
	else
	{
		$date = date("y-m-d");
	}	

	$user_id=$_REQUEST['user_id'];

	$query="SELECT * FROM basket_order where seller_id='".$user_id."'  and order_status='deleted' and order_date like '%".$date."%' order by id desc";
	$query=query($query);
	confirm($query);
	$deleted=mysqli_num_rows($query);

	$query="SELECT * FROM basket_order where seller_id='".$user_id."'  and order_status='Pending' and order_date like '%".$date."%' order by id  desc";
	$query=query($query);
	confirm($query);
	$pending=mysqli_num_rows($query);

	$query="SELECT * FROM basket_order where seller_id='".$user_id."'  and order_status='Accepted' and order_date like '%".$date."%' order by id  desc";
	$query=query($query);
	confirm($query);
	$accepted=mysqli_num_rows($query);
	$query="SELECT * FROM basket_order where seller_id='".$user_id."'  and order_status='Cancelled' and order_date like '%".$date."%' order by id  desc";
	$query=query($query);
	confirm($query);
	$cancelled=mysqli_num_rows($query);

	$query="SELECT * FROM basket_order where seller_id='".$user_id."'  and order_status='Shipped' and order_date like '%".$date."%' order by id  desc";
	$query=query($query);
	confirm($query);
	$shipped=mysqli_num_rows($query);

	$query="SELECT * FROM basket_order where seller_id='".$user_id."'  and order_status='Delivered' and order_date like '%".$date."%' order by id desc";
	$query=query($query);
	confirm($query);
	$delivered=mysqli_num_rows($query);

	$query="SELECT * FROM product_details where product_seller_id='".$user_id."'";
	$query=query($query);
	confirm($query);
	$products=mysqli_num_rows($query);

	$query="SELECT * FROM product_catalogue where catalogue_seller_id='".$user_id."'";
	$query=query($query);
	confirm($query);
	$catalogues=mysqli_num_rows($query);

	$query="SELECT sum(net_amount) as totalsales FROM basket_order where seller_id='".$user_id."'  and order_date like '%".$date."%' order by id desc";
	$query=query($query);
	confirm($query);
	$total_sales=0;
	while($row=fetch_array($query))
	{
		$total_sales=$row['totalsales'];
	}
	if(!$total_sales)
	{
		$total_sales=0;
	}

	$temp=array();			
	$temp['deleted']=$deleted;
	$temp['pending']=$pending;
	$temp['accepted']=$accepted;
	$temp['cancelled']=$cancelled;
	$temp['shipped']=$shipped;
	$temp['delivered']=$delivered;
	$temp['products']=$products;
	$temp['catalogues']=$catalogues;
	$temp['total_sales']=$total_sales;
	$temp['response_code']=200;
	$temp['response_desc']="success";
 	echo json_encode(array("getdashboard"=>$temp));
}	
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getdashboard"=>$temp));
}
close();
?>
