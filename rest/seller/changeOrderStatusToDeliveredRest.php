<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
require('getSellerWalletBalanceRest.php');
$connection->autocommit(FALSE);
$flag = true;

if(isset($_REQUEST['order_status'])&&$_REQUEST['order_status']!=''&&isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!=''&&isset($_REQUEST['order_id'])&&$_REQUEST['order_id']!=''&&isset($_REQUEST['order_type'])&&$_REQUEST['order_type']!='')
{	

	$query="select order_date,net_amount,order_status from basket_order where basket_order_id='".$_REQUEST['order_id']."' and seller_id='".$_REQUEST['user_id']."'";
	//echo $query;
	$query=query($query);
	$row=fetch_array($query);
	$order_date=date('Y-m-d',strtotime($row['order_date']));
	$net_amount=$row['net_amount'];
	if($row['order_status']=='Shipped'&&$_REQUEST['order_status']=='Delivered')
	{
		$query=query("select status,logistics_integrated,kyc_completed,waive_platform_fees from users,seller_details where user_id='".$_REQUEST['user_id']."' and users.user_id=seller_details.seller_id");
		confirm($query);

		if(mysqli_num_rows($query)==0)
		{
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="No records Found";
			echo json_encode(array("changestatustodelivered"=>$temp));
			close();
			exit();
		}
		$row=fetch_array($query);
		
		if($row['status']!="A")
		{
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="Operation not allowed";
			echo json_encode(array("changestatustodelivered"=>$temp));
			close();
			exit();
		}
		if( $_REQUEST['order_type']=='Prepaid')
		{
			if($row['waive_platform_fees']=='No')
			{
				
				$query=query("select comission_percentage,tax_on_commission from commission_charges where comission_type ='PLATFORM_FEES'");
				$row=fetch_array($query);
				$comission_percentage=round($row['comission_percentage'],2);
				$tax_on_commission=round($row['tax_on_commission'],2);
				if(mysqli_num_rows($query)!=0)
				{
					$gross_platform_fees = round(($comission_percentage*$net_amount)/100,2);
					$net_platform_fees = round($gross_platform_fees + ($gross_platform_fees  * $tax_on_commission)/100,2);

					$walletbalance = new Wallet();
					$walletbalance->getWalletDetails($_REQUEST['user_id']);
					$valuedate =$walletbalance->value_date;
					$openingbalance=round($walletbalance->opening_balance,2);
					$closingbalance=round($walletbalance->closing_balance,2);
					//echo $openingbalance."\n".$closingbalance."\n";
					$newclosingbalance=0;
					$newclosingbalance=round($closingbalance-$net_platform_fees,2);
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
											movement_description,
											value_date
										) values
										(';
											$query.='"'.$cashmovementid.'",';
											$query.='"'.$_REQUEST['order_id'].'",';
											$query.='"'.$_REQUEST['user_id'].'",';
											$query.='"seller",';
											$query.='"'.$closingbalance.'",';
											$query.='"'.$net_platform_fees*(-1).'",';
											$query.='"INR",';
											$query.='"D",';
											$query.='"'.$newclosingbalance.'",';
											$query.='3,';
											$query.='"'.$net_platform_fees.'",';
											$query.='"Prepaid",';
											$query.='2,';
											$query.='NOW(),';
											$query.='NOW(),';
											$query.='CURDATE(),';
											$query.='0.00,';
											$query.='0.00,';
											$query.='"'.$order_date.'",';
											$query.='"Platform Fees",';
											$query.='NOW()
											
										)';
											//echo $query;
					$query=query($query);
					$result=confirm($query);
					if(!$result)
					{
						$flag = false;
						rollback();
						$temp=array();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Request";
						echo json_encode(array("changestatustodelivered"=>$temp));
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
										movement_description,
										value_date
									) values
									(';
										$query.='"'.$cashmovementid1.'",';
										$query.='"'.$_REQUEST['order_id'].'",';
										$query.='"'.$cashmovementid.'",';
										$query.='"'.$_REQUEST['user_id'].'",';
										$query.='"offset",';
										$query.='"'.$closingbalance.'",';
										$query.='"'.$net_platform_fees.'",';
										$query.='"INR",';
										$query.='"C",';
										$query.='"'.$newclosingbalance.'",';
										$query.='3,';
										$query.='"'.$net_platform_fees.'",';
										$query.='"Prepaid",';
										$query.='2,';
										$query.='NOW(),';
										$query.='NOW(),';
										$query.='CURDATE(),';
										$query.='0.00,';
										$query.='0.00,';
										$query.='"'.$order_date.'",';
										$query.='"Platform Fees",';
										$query.='NOW()
										
									)';
										//echo $query;
					$query=query($query);
					$result=confirm($query);
					if(!$result)
					{
						$flag = false;
						rollback();
						$temp=array();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Request";
						echo json_encode(array("changestatustodelivered"=>$temp));
						close();
						exit();
					}
					$query="SELECT cash_movement_id FROM cash_movements where seller_id ='".$_REQUEST['user_id']."' and order_id ='".$_REQUEST['order_id']."' and movement_type = 1";
		//echo $query;
					$query=query($query);

					while($row1=fetch_array($query))
					{

						$query1="update cash_movements set movement_status=4,last_modification_datetime=NOW() where cash_movement_id='".$row1['cash_movement_id']."'";
						$query1=query($query1);
						$result=confirm($query1);
						if(!$result)
						{
							$flag = false;
							rollback();
							$temp=array();
							$temp['response_code']=404;
							$temp['response_desc']="Invalid Request";
							echo json_encode(array("changestatustodelivered"=>$temp));
							close();
							exit();
						}
					}
					$openingbalance=round($closingbalance,2);
					$closingbalance=$newclosingbalance;
					$result=$walletbalance->upadteWalletDetails($_REQUEST['user_id'],$openingbalance,$closingbalance,$valuedate);
					if(!$result)
					{
						$flag = false;
						rollback();
						$temp=array();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Request";
						echo json_encode(array("changestatustodelivered"=>$temp));
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
						$temp=array();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Request";
						echo json_encode(array("changestatustodelivered"=>$temp));
						close();
						exit();
					}

					if($flag)
					{
						commit();
						$temp=array();
						$temp['response_code']=200;
						$temp['response_desc']="Sucess";
						echo json_encode(array("changestatustodelivered"=>$temp));
					}
					else
					{
						rollback();
						$temp=array();
						$temp['response_code']=404;
						$temp['response_desc']="Invalid Request";
						echo json_encode(array("changestatustodelivered"=>$temp));
						close();
						exit();
					}
				}
						
			}
			// else
			// {
			// 	//waive
			// }
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
				echo json_encode(array("changestatustodelivered"=>$temp));
				close();
				exit();
			}

			if($flag)
			{
				commit();
				$temp=array();
				$temp['response_code']=200;
				$temp['response_desc']="Sucess";
				echo json_encode(array("changestatustodelivered"=>$temp));
			}
			else
			{
				rollback();
				$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Request";
				echo json_encode(array("changestatustodelivered"=>$temp));
				close();
				exit();
			}
		}

	
		
	}
		// else
		// {
		// 	//deliverd
		// }
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("changestatustodelivered"=>$temp));
	close();
	exit();
}
$connection->autocommit(TRUE);
close();

?>
