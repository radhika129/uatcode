<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
require('getSellerWalletBalanceRest.php');
$connection->autocommit(FALSE);
$flag=true;
if(isset($_REQUEST['order_status'])&&$_REQUEST['order_status']!=''&&isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!=''&&isset($_REQUEST['order_id'])&&$_REQUEST['order_id']!=''&&isset($_REQUEST['order_type'])&&$_REQUEST['order_type']!='')
{	
	$query="select order_status from basket_order where basket_order_id='".$_REQUEST['order_id']."' and seller_id='".$_REQUEST['user_id']."'";
	$query=query($query);
	$row=fetch_array($query);
	if(($row['order_status']=='Accepted'||$row['order_status']=='Pending')&&$_REQUEST['order_status']=='Declined')
	{
		$query=query("select status,logistics_integrated,kyc_completed,waive_platform_fees from users,seller_details where user_id='".$_REQUEST['user_id']."' and users.user_id=seller_details.seller_id");
		confirm($query);

		if(mysqli_num_rows($query)==0)
		{
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="No records Found";
			echo json_encode(array("changestatustoDeclined"=>$temp));
			exit();
		}
			$row=fetch_array($query);
			
		if($row['status']!="A"  )
		{
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="Operation not allowed";
			echo json_encode(array("changestatustoDeclined"=>$temp));
			exit();
		}

		if($_REQUEST['order_type']=='Prepaid')	
		{

			$query="SELECT cash_movement_id FROM cash_movements where seller_id ='".$_REQUEST['user_id']."' and order_id ='".$_REQUEST['order_id']."' and movement_type = 1";
			$query=query($query);
			while($row=fetch_array($query))
			{
				$query1="update cash_movements set movement_status=3,last_modification_datetime=NOW() where cash_movement_id='".$row['cash_movement_id']."'";
				$query1=query($query1);
				
				$result=confirm($query1);
				if(!$result)
				{
					$flag = false;
					rollback();
					$temp=array();
					$temp['response_code']=404;
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("changestatustoDeclined"=>$temp));
					close();
					exit();
				}
			}
			$query="update basket_order set order_status='".$_REQUEST['order_status']."' where basket_order_id='".$_REQUEST['order_id']."' and seller_id='".$_REQUEST['user_id']."'";
			$query=query($query);
			$result=confirm($query);
			if(!$result)
			{
				$flag=false;
				rollback();
				$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Results";
				echo json_encode(array("changestatustoDeclined"=>$temp));
				close();
				exit();
			}
			if($flag)
			{
				commit();
				$temp=array();
				$temp['response_code']=200;
				$temp['response_desc']="Sucess";
				echo json_encode(array("changestatustoDeclined"=>$temp));
				close();
				exit();
			}
			else
			{
				rollback();
				$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Results";
				echo json_encode(array("changestatustoDeclined"=>$temp));
				close();
				exit();
			}
		}
		if($_REQUEST['order_type']=='COD')
		{
			$query="update basket_order set order_status='".$_REQUEST['order_status']."' where basket_order_id='".$_REQUEST['order_id']."' and seller_id='".$_REQUEST['user_id']."'";
			$query=query($query);
			$result=confirm($query);
			if(!$result)
			{
				$flag=false;
				rollback();
				$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Request";
				echo json_encode(array("changestatustoDeclined"=>$temp));
				close();
				exit();
			}

			if($flag)
			{
				commit();
				$temp=array();
				$temp['response_code']=200;
				$temp['response_desc']="Sucess";
				echo json_encode(array("changestatustoDeclined"=>$temp));
			}
			else
			{
				rollback();
				$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Request";
				echo json_encode(array("changestatustoDeclined"=>$temp));
				close();
				exit();
			}
		}	
	}
		
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("changestatustoDeclined"=>$temp));
	close();
	exit();
}
?>
