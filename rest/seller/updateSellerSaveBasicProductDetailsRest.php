<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	
	if(isset($_REQUEST['product_id'])&&$_REQUEST['product_id']!='')
	{
		$product_id=$_REQUEST['product_id'];
		$productimage="";
		$check_status='';
		if($_REQUEST['imagestatus']=='1')
		{
			$data=$_REQUEST['productimage'];
			$productimage=$_REQUEST['image_name'];

			if($productimage=='defaultpic.jpg'||$productimage=='defaultpic.png'||strpos($productimage,'/images/product_library/'))
			{
				$date=date('Ymd').rand(10000,100000);
				$productimage="/images/products/".$_REQUEST['product_name'].$_REQUEST['user_id'].$date.'.png';
			}
			$productimage1=UPLOAD_DIRECTORY.$productimage;
			$check_status=imageupload($data,$productimage1);
		}
		else
		{
			$productimage=$_REQUEST['image_name'];
		}
		if($check_status=="Invalid")
		{
		$productimage="defaultpic.jpg";
		}
		$query="select discount_type,discount from product_details where product_seller_id='".$_REQUEST['user_id']."' and product_id='".$product_id."'";
		$query=query($query);
		confirm($query);
		$row=fetch_array($query);
		$productofferprice=0;
		if($row['discount_type']=='None')
		{
			$productofferprice=$_REQUEST['product_price'];
		}
		else if($row['discount_type']=='Flat')
		{
			$productofferprice=$_REQUEST['product_price']-$row['discount'];
		}
		else if($row['discount_type']=='Percentage')
		{
			$productofferprice=$_REQUEST['product_price']-(($_REQUEST['product_price']/100)*$row['discount']);

		}
			$query="update  product_details set 
							updatedby='".$_REQUEST['user_id']."',
							product_catalogue_id='".$_REQUEST['product_catalogue_id']."',
							product_seller_id='".$_REQUEST['user_id']."',
							product_name='".$_REQUEST['product_name']."',
							product_price='".$_REQUEST['product_price']."',
							product_offer_price='".$productofferprice."',
							product_unit='".$_REQUEST['product_unit']."',
							product_price_currency='INR',
							product_description='".$_REQUEST['product_description']."',
							productimage='".$productimage."',
							product_modification_datetime=NOW()
							 
							where 	
								product_id='".$product_id."'";
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
		 		echo json_encode(array("updateproduct"=>$temp));
		 	}
		 	else
		 	{
		 		rollback();
		 		$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Operation";
				echo json_encode(array("updateproduct"=>$temp));
		 	}
	}
		
	else
	{
		$temp=array();
		$temp['response_code']=405;
		$temp['response_desc']="Not Allowed";
		
 		echo json_encode(array("updateproduct"=>$temp));
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updateproduct"=>$temp));
}
close();	
?>
