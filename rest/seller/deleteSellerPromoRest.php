<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=''&&isset($_REQUEST['pname']) && $_REQUEST['pname']!='')
{
		$pid=$_REQUEST['pid'];
		$pname=$_REQUEST['pname'];
		$query="select order_status from  orders,basket_order where promo_code='".$pname."' and order_id=basket_order_id";
		$query=query($query);
		confirm($query);
		$rows=mysqli_num_rows($query);
		//print_r($rows);
		if($rows!=0)
		{
			$temp=array();
			$temp['response_code']=405;			// 405 means 'Not Allowed'
			$temp['response_desc']="Deletion is not allowed please deactivate the Promocard.";
			echo json_encode(array("deleteproduct"=>$temp));
		}
		else
		{
			$query=query("delete from promocodes where id='".$pid."'");
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
