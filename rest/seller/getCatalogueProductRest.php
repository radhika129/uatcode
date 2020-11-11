<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['username'])&&$_REQUEST['username']!='')
{
	$start=0;
	$end=0;
	$query=query("select status,user_id,business_name,mobile FROM users where username='".$_REQUEST['username']."'");
	confirm($query);
	$userid='';
	$business_name='';
	$mobile='';
	while($row1=fetch_array($query))
	{
		$userid=$row1['user_id'];
		$business_name=$row1['business_name'];
		$mobile=$row1['mobile'];
		$status=$row1['status'];
	}
	if($status!='A')
	{
		$temp=array();
		$temp['response_code']=405;
		$temp['response_desc']="This Collection Page is temporary disabled. Please contact product seller for additional information";
 		echo json_encode(array("getproducts"=>$temp));
 		close();
 		exit();

	}
	if(isset($_REQUEST['cid'])&&$_REQUEST['cid']!='')
	{
		$query='';
	$query=query("select catalogue_id,catalogue_name FROM product_catalogue where catalogue_status='Active' and catalogue_seller_id='".$userid."' and catalogue_id='".$_REQUEST['cid']."'");
	confirm($query);
	$rows=mysqli_num_rows($query);

	if($rows!=0)	// Valid Request, Data Found.
	{
		$rows=0;
		$temp=array();
		while($row=fetch_array($query))
		{	
			$query1=query("select product_id,
								product_seller_id,
								productimage,
								product_name,
								product_price,
								product_price_currency,
								product_category,
								product_sub_category,
								product_description,
								product_catalogue_id,
								warranty_duration,
								warranty_days_mon_yr,
								warrant_type,
								valid_from,
								product_model,
								product_offer_price,
								tax_type,
								tax_percent,
								free_shipping,
								cancellation_available,
								cash_on_delivery,
								return_available,
								product_inventory,
								product_unit,
								product_status,
								discount_type,
								discount,
								delivery_charge,
								delivery_free_above,
								accept_online_payments,
								logistics_integrated 
								FROM seller_details,product_details,delivery_charges where product_seller_id='".$userid."' and product_catalogue_id ='".$row['catalogue_id']."' and seller_details.seller_id=product_seller_id and product_status='Active' and product_price>0");
			confirm($query1);
			

			while($row1=fetch_array($query1))
			{   $row1['cataloguename']=$row['catalogue_name'];
				$row1['catalogue_id']=$row1['product_catalogue_id'];
				$temp[]=$row1;
				$rows+1;
			}

		}
		
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['business_name']=$business_name;
		$temp['mobile'] =$mobile;
		$temp['user_id'] =$userid;
		$temp['rows']=$rows;
		//print_r($temp);
 		echo json_encode(array("getproducts"=>$temp));

 	}
	
 	else
	{
		$temp['response_code']=404;
		$temp['response_desc']="No Results Found";
 		echo json_encode(array("getproducts"=>$temp));
	}
	}
	else if(isset($_REQUEST['pid'])&&$_REQUEST['pid']!='')
	{
		$query1=query("select product_id,
								product_seller_id,
								productimage,
								product_name,
								product_price,
								product_price_currency,
								product_category,
								product_sub_category,
								product_description,
								product_catalogue_id,
								warranty_duration,
								warranty_days_mon_yr,
								warrant_type,
								valid_from,
								product_model,
								product_offer_price,
								tax_type,
								tax_percent,
								free_shipping,
								cancellation_available,
								cash_on_delivery,
								return_available,
								product_inventory,
								product_unit,
								product_status,
								discount_type,
								discount,
								delivery_charge,
								delivery_free_above,
								accept_online_payments,
								logistics_integrated 
								FROM seller_details,product_details,product_catalogue,delivery_charges where product_seller_id='".$userid."'and catalogue_id=product_catalogue_id and product_id ='".$_REQUEST['pid']."'and seller_details.seller_id=product_seller_id and product_status='Active'and product_price>0");
			confirm($query1);
			$rows=mysqli_num_rows($query);
			while($row1=fetch_array($query1))
			{   
				$row1['catalogue_id']=$row1['product_catalogue_id'];
				$temp[]=$row1;
				
			}
			$temp['response_code']=200;
			$temp['response_desc']="success";
			$temp['business_name']=$business_name;
			$temp['mobile'] =$mobile;
			$temp['user_id'] =$userid;
			$temp['rows']=$rows;
			
			echo json_encode(array("getproducts"=>$temp));
	}
	else
	{
	$query='';
	$query=query("select catalogue_id,catalogue_name FROM product_catalogue where catalogue_status='Active' and catalogue_seller_id='".$userid."'");
	confirm($query);
	$rows=mysqli_num_rows($query);

	if($rows!=0)	// Valid Request, Data Found.
	{
		$rows=0;
		$temp=array();
		while($row=fetch_array($query))
		{	
			
			$query1=query("select product_id,
								product_seller_id,
								productimage,
								product_name,
								product_price,
								product_price_currency,
								product_category,
								product_sub_category,
								product_description,
								product_catalogue_id,
								warranty_duration,
								warranty_days_mon_yr,
								warrant_type,
								valid_from,
								product_model,
								product_offer_price,
								tax_type,
								tax_percent,
								free_shipping,
								cancellation_available,
								cash_on_delivery,
								return_available,
								product_inventory,
								product_unit,
								product_status,
								discount_type,
								discount,
								delivery_charge,
								delivery_free_above,
								accept_online_payments,
								logistics_integrated 
								FROM seller_details,product_details,delivery_charges where product_seller_id='".$userid."' and product_catalogue_id ='".$row['catalogue_id']."'and seller_details.seller_id=product_seller_id and product_status='Active'and product_price>0");
			confirm($query1);

			while($row1=fetch_array($query1))
			{   $row1['cataloguename']=$row['catalogue_name'];
				$row1['catalogue_id']=$row1['product_catalogue_id'];
				$temp[]=$row1;
				$rows+=1;
			}

		}
		$temp['business_name']=$business_name;
		$temp['mobile'] =$mobile;
		$temp['user_id'] =$userid;
		$temp['rows']=$rows;
		$temp['response_code']=200;
		$temp['response_desc']="success";
		//print_r($temp);

 		echo json_encode(array("getproducts"=>$temp));

 	}
	
 	else
	{
		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']="No Results Found";
 		echo json_encode(array("getproducts"=>$temp));
	}
}

}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
 	echo json_encode(array("getproducts"=>$temp));
}
close();
?>
