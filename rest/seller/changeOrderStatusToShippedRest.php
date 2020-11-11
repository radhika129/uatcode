<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
require('getSellerWalletBalanceRest.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['order_status'])&&$_REQUEST['order_status']!=''&&isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	

	$query="select order_status from basket_order where basket_order_id='".$_REQUEST['order_id']."' and seller_id='".$_REQUEST['user_id']."'";
	//echo $query;
	$query=query($query);
	$row=fetch_array($query);
	if($row['order_status']=='Accepted'&&$_REQUEST['order_status']=='Shipped')
	{
		
		$query=query("select status,logistics_integrated,kyc_completed from users,seller_details where user_id='".$_REQUEST['user_id']."' and users.user_id=seller_details.seller_id");
		

		if(mysqli_num_rows($query)==0)
		{
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="No records Found";
			echo json_encode(array("changestatustoshipped"=>$temp));
			exit();
		}
		$row=fetch_array($query);
		
		if($row['status']!="A")
		{
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="Operation not allowed";
			echo json_encode(array("changestatustoshipped"=>$temp));
			exit();
		}
		if($_REQUEST['order_type']=='Prepaid')
		{
			if($row['logistics_integrated']=='Yes')
			{
				if($row['kyc_completed']!='1')
				{
					$temp=array();
					$temp['response_code']=405;
					$temp['response_desc']="Seller KYC is not complete but logistics is integrated. Turn off logistics integration to proceed";
					echo json_encode(array("changestatustoshipped"=>$temp));
					exit();
				}
				$query=query("select id,shipping_amount,seller_id from shipping_charges where seller_id='".$_REQUEST['user_id']."'");
				confirm($query);
				$rows=mysqli_num_rows($query);
				if($_REQUEST['net_amount']>0)
				{
				
					$row=fetch_array($query);
					$walletbalance = new Wallet();
					$walletbalance->getWalletDetails($_REQUEST['user_id']);
					$valuedate =$walletbalance->value_date;
					$openingbalance=$walletbalance->opening_balance;
					$closingbalance=$walletbalance->closing_balance;
					$newclosingbalance=0;
					$newclosingbalance=round($closingbalance-round($row['shipping_amount'],2),2);
					$cashmovementid=$_REQUEST['user_id']+date("YmdHis").rand(100,1000);
					
					$query='insert into cash_movements (
											cash_movement_id,
											order_id,
											seller_id,
											entry_side,
											opening_balance,
											amount,
											amount_currency,
											dr_cr_indicator,
											closing_balance,
											movement_type,
											settled_amount,
											payment_reference,
											movement_status,
											created_date_time,
											last_modification_datetime,
											movement_date,
											service_charge,
											service_tax,
											order_date,
											value_date
										) values
										(';
											$query.='"'.$cashmovementid.'",';
											$query.='"'.$_REQUEST['order_id'].'",';
											$query.='"'.$_REQUEST['user_id'].'",';
											$query.='"seller",';
											$query.='"'.$closingbalance.'",';
											$query.='"'.$row['shipping_amount']*(-1).'",';
											$query.='"INR",';
											$query.='"D",';
											$query.='"'.$newclosingbalance.'",';
											$query.='2,';
											$query.='"'.round($row['shipping_amount'],2).'",';
											$query.='"null",';
											$query.='2,';
											$query.='NOW(),';
											$query.='NOW(),';
											$query.='CURDATE(),';
											$query.='0.00,';
											$query.='0.00,';
											$query.='"'.$_REQUEST['order_date'].'",';
											$query.='NOW()
											
										)';
										
										$query=query($query);
										$result=confirm($query);
										if(!$result)
										{
											$flag = false;
											rollback();
											$temp['response_code']=404;
											$temp['response_desc']="Invalid Results";
											echo json_encode(array("changestatustoshipped"=>$temp));
											close();
											exit();
										}
						
					$cashmovementid1=$_REQUEST['user_id']+date("YmdHis").rand(100,1000);
					$query='insert into cash_movements (
										cash_movement_id,
										order_id,
										Linked_movement,
										seller_id,
										entry_side,
										opening_balance,
										amount,
										amount_currency,
										dr_cr_indicator,
										closing_balance,
										movement_type,
										settled_amount,
										payment_reference,
										movement_status,
										created_date_time,
										last_modification_datetime,
										movement_date,
										service_charge,
										service_tax,
										order_date,
										value_date
									) values
									(';
										$query.='"'.$cashmovementid1.'",';
										$query.='"'.$_REQUEST['order_id'].'",';
										$query.='"'.$cashmovementid.'",';
										$query.='"'.$_REQUEST['user_id'].'",';
										$query.='"offset",';
										$query.='"'.$closingbalance.'",';
										$query.='"'.$row['shipping_amount'].'",';
										$query.='"INR",';
										$query.='"C",';
										$query.='"'.$newclosingbalance.'",';
										$query.='2,';
										$query.='"'.round($row['shipping_amount'],2).'",';
										$query.='"null",';
										$query.='2,';
										$query.='NOW(),';
										$query.='NOW(),';
										$query.='CURDATE(),';
										$query.='0.00,';
										$query.='0.00,';
										$query.='"'.$_REQUEST['order_date'].'",';
										$query.='NOW()
										
									)';
										$query=query($query);
										$result=confirm($query);
										if(!$result)
										{
											$flag = false;
											rollback();
											$temp['response_code']=404;
											$temp['response_desc']="Invalid Results";
											echo json_encode(array("changestatustoshipped"=>$temp));
											close();
											exit();
										}
					$openingbalance=round($closingbalance,2);
					$closingbalance=$newclosingbalance;
					$result=$walletbalance->upadteWalletDetails($_REQUEST['user_id'],$openingbalance,$closingbalance,$valuedate);
					if(!$result)
					{
						$flag=false;
						rollback();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Results";
						echo json_encode(array("changestatustoshipped"=>$temp));
						close();
						exit();
					}
					$query="update basket_order set order_status='".$_REQUEST['order_status']."' where basket_order_id='".$_REQUEST['order_id']."' and seller_id='".$_REQUEST['user_id']."'";
					$query=query($query);
					$result=confirm($query);
					if(!$result)
					{
						$flag=false;
						rollback();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Results";
						echo json_encode(array("changestatustoshipped"=>$temp));
						close();
						exit();
					}

					if($flag)
					{
						commit();
						$temp=array();
						$temp['response_code']=200;
						$temp['response_desc']="Sucess";
						echo json_encode(array("changestatustoshipped"=>$temp));
						close();
						exit();
					}
					else
					{
						rollback();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Results";
						echo json_encode(array("changestatustoshipped"=>$temp));
						close();
						exit();
					}
				}
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
				echo json_encode(array("changestatustoshipped"=>$temp));
				close();
				exit();
			}

			if($flag)
			{
				commit();
				$temp=array();
				$temp['response_code']=200;
				$temp['response_desc']="Sucess";
				echo json_encode(array("changestatustoshipped"=>$temp));
			}
			else
			{
				rollback();
				$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Request";
				echo json_encode(array("changestatustoshipped"=>$temp));
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
	echo json_encode(array("changestatustoshipped"=>$temp));
	close();
	exit();
}

?>
