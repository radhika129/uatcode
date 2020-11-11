<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	
	if(isset($_REQUEST['product_id'])&&$_REQUEST['product_id']!=''&&isset($_REQUEST['discount_type'])&&$_REQUEST['discount_type']!='')
	{
		
		$productofferprice=0;
		if($_REQUEST['discount_type']=='None')
		{
			$productofferprice=$_REQUEST['product_price'];
		}
		else if($_REQUEST['discount_type']=='Flat')
		{
			$productofferprice=$_REQUEST['product_price']-$_REQUEST['discount'];
		}
		else if($_REQUEST['discount_type']=='Percentage')
		{
			$productofferprice=$_REQUEST['product_price']-(($_REQUEST['product_price']/100)*$_REQUEST['discount']);

		}
		$discount=0;
		if($_REQUEST['discount_type']=='None')
		{
		
			$discount=0;
		}
		else
		{
			$discount=$_REQUEST['discount'];
			
		}
		$product_id=$_REQUEST['product_id'];
		$query="update  product_details set 
				updatedby='".$_REQUEST['user_id']."',
				discount_type='".$_REQUEST['discount_type']."',
				discount='".$discount."',
				product_offer_price=".$productofferprice.",
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
