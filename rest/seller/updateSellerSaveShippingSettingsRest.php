<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	
	if(isset($_REQUEST['product_id'])&&$_REQUEST['product_id']!=''&&isset($_REQUEST['free_shipping'])&&$_REQUEST['free_shipping']!=''&&isset($_REQUEST['cash_on_delivery'])&&$_REQUEST['cash_on_delivery']!=''&&isset($_REQUEST['return_available'])&&$_REQUEST['return_available']!='')
	{
		$product_id=$_REQUEST['product_id'];
		$query="update  product_details set 
				free_shipping='".$_REQUEST['free_shipping']."',
				cash_on_delivery='".$_REQUEST['cash_on_delivery']."',
				return_available='".$_REQUEST['return_available']."',
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
