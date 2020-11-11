<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
require('getSellerWalletBalanceRest.php');
$flag = true;
$connection->autocommit(FALSE);

 $orderId = $_REQUEST["orderId"];
 $orderAmount = $_REQUEST["orderAmount"];
 $referenceId = $_REQUEST["referenceId"];
 $txStatus = $_REQUEST["txStatus"];
 $paymentMode = $_REQUEST["paymentMode"];
 $txMsg = $_REQUEST["txMsg"];
 $txTime = $_REQUEST["txTime"];
 $signature = $_REQUEST["signature"];
 $secretkey = "e16b50357d2fa3971bd0ffdd9708f9e330cef047";
 $data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
 $hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;
// echo "Mahesh";
//echo $signature;
 $computedSignature = base64_encode($hash_hmac);
//echo $signature."  ".$computedSignature;
 if ($txStatus=='SUCCESS') 
 {
    if($signature==$computedSignature)
    {	
    	$query="update basket_order set payment_reference='".$referenceId."',order_status='Pending',payment_method='".$paymentMode."',amount_received='".$orderAmount."',payment_gateway_status='".$txStatus."',payment_transaction_time='".$txTime."' where basket_order_id='".$orderId."'";
    	//echo $query;
    	$query=query($query);
    	$result=confirm($query);
    	if(!$result)
		{
			$flag = false;
			rollback();
			$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Results";
			echo json_encode(array("checkout"=>$temp));
			close();
			exit();
	
		}
		//echo $flag."\n";
		$query ="select order_type,seller_id,order_date from basket_order where basket_order_id='".$orderId."'";
		//echo $query;
		$query=query($query);
		$result=confirm($query);
		$row=fetch_array($query);
		//print_r($row);
		$user_id=$row['seller_id'];
		$order_type=$row['order_type'];
		$order_date=date('Y-m-d',strtotime($row['order_date']));
		$query="select status,logistics_integrated,kyc_completed,waive_platform_fees,accept_online_payments	 from users,seller_details where user_id='".$user_id."' and users.user_id=seller_details.seller_id";

		//echo $query;
		$query=query($query);
		confirm($query);

		if(mysqli_num_rows($query)==0)
		{
			rollback();
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="No records Found";
			echo json_encode(array("checkout"=>$temp));
			close();
			exit();
		}
		$row=fetch_array($query);
		if($row['status']!="A")
		{
				rollback();
				$temp=array();
				$temp['response_code']=405;
				$temp['response_desc']="Please Contact CustomerCare to Activate Your Account";
				echo json_encode(array("checkout"=>$temp));
				close();
				exit();
		}
		if($order_type=='Prepaid')
		{
			if($row['kyc_completed']!='1')
			{
				rollback();
				$temp=array();
				$temp['response_code']=405;
				$temp['response_desc']="Please Complete KYC";
				echo json_encode(array("checkout"=>$temp));
				close();
				exit();
			}
			if($row['accept_online_payments']!='1')
			{
				rollback();
				$temp=array();
				$temp['response_code']=405;
				$temp['response_desc']="Please Accept Online Payments";
				echo json_encode(array("checkout"=>$temp));
				close();
				exit();
			}
						
			$walletbalance = new Wallet();
			$walletbalance->getWalletDetails($user_id);
			$valuedate =$walletbalance->value_date;
			//$openingbalance=$walletbalance->opening_balance;
			//$closingbalance=$walletbalance->closing_balance;
			$openingbalance=0;
			$closingbalance=0;

			//echo $openingbalance."\n".$closingbalance."\n";
			$newclosingbalance=0;
			$paymentrefernce=$referenceId;
		//$newclosingbalance=$closingbalance-$net_platform_fees;
		//$flag=true;
		//;
			if($orderAmount>0)
			{
				$cashmovementid=$user_id+date("YmdHis").rand(100,1000);
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
										$query.='"'.$orderId.'",';
										$query.='"'.$user_id.'",';
										$query.='"seller",';
										$query.='"'.$closingbalance.'",';
										$query.='"'.$orderAmount.'",';
										$query.='"INR",';
										$query.='"C",';
										$query.='"'.$newclosingbalance.'",';
										$query.='1,';
										$query.='0,';
										$query.='"'.$paymentrefernce.'",';
										$query.='1,';
										$query.='NOW(),';
										$query.='NOW(),';
										$query.='CURDATE(),';
										$query.='0.00,';
										$query.='0.00,';
										$query.='"'.$order_date.'",';
										$query.='"'.$txTime.'"
										
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
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("checkout"=>$temp));
					close();
					exit();
				}
					
				$cashmovementid1=$user_id+date("YmdHis").rand(100,1000);
				$query='insert into cash_movements (
									cash_movement_id,
									order_id,
									linked_movement,
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
									$query.='"'.$orderId.'",';
									$query.='"'.$cashmovementid.'",';
									$query.='"'.$user_id.'",';
									$query.='"offset",';
									$query.='"'.$openingbalance.'",';
									$query.='"'.$orderAmount*(-1).'",';
									$query.='"INR",';
									$query.='"D",';
									$query.='"'.$closingbalance.'",';
									$query.='1,';
									$query.='0,';
									$query.='"'.$paymentrefernce.'",';
									$query.='1,';
									$query.='NOW(),';
									$query.='NOW(),';
									$query.='CURDATE(),';
									$query.='0.00,';
									$query.='0.00,';
									$query.='"'.$order_date.'",';
									$query.='"'.$txTime.'"
									
								)';
				$query=query($query);
				$result=confirm($query);
				if(!$result)
				{
					$flag = false;
					rollback();
					$temp=array();
					$temp['response_code']=404;
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("checkout"=>$temp));
					close();
					exit();
				}
					
				$query=query("select comission_percentage,tax_on_commission from commission_charges where comission_type ='GATEWAY_CHARGES'");
				$row=fetch_array($query);
				$comission_percentage=round($row['comission_percentage'],2);
				$tax_on_commission=round($row['tax_on_commission'],2);
				//echo $query;
				$gross_platform_fees;
				$net_platform_fees=0;
				if(mysqli_num_rows($query)!=0)
				{
					$gross_platform_fees = round(($comission_percentage*$orderAmount)/100,2);
					$net_platform_fees = round($gross_platform_fees + ($gross_platform_fees  * $tax_on_commission)/100,2);
				}
				$openingbalance=round($walletbalance->opening_balance,2);
				$closingbalance=round($walletbalance->closing_balance,2);
				$newclosingbalance=0;
				$newclosingbalance = round($closingbalance-$net_platform_fees,2);
				$cashmovementid=$user_id+date("YmdHis").rand(100,1000);
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
									$query.='"'.$orderId.'",';
									$query.='"'.$user_id.'",';
									$query.='"seller",';
									$query.='"'.$closingbalance.'",';
									$query.='"'.$net_platform_fees*(-1).'",';
									$query.='"INR",';
									$query.='"D",';
									$query.='"'.$newclosingbalance.'",';
									$query.='4,';
									$query.='"'.$orderAmount.'",';
									$query.='"'.$paymentrefernce.'",';
									$query.='2,';
									$query.='NOW(),';
									$query.='NOW(),';
									$query.='CURDATE(),';
									$query.='0.00,';
									$query.='0.00,';
									$query.='"'.$order_date.'",';
									$query.='"Gateway Charges",';
									$query.='"'.$txTime.'"
									
								)';
									//echo $query;
				$query=query($query);
				//$flag = true;
				$result=confirm($query);
				if(!$result)
				{
					$flag = false;
					rollback();
					$temp=array();
					$temp['response_code']=404;
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("checkout"=>$temp));
					close();
					exit();
				}
										//echo $flag."\n";
				$openingbalance=0;
				$closingbalance=0;
				$cashmovementid1=$user_id+date("YmdHis").rand(100,1000);
				$query='insert into cash_movements (
									cash_movement_id,
									order_id,
									linked_movement,
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
									$query.='"'.$orderId.'",';
									$query.='"'.$cashmovementid.'",';
									$query.='"'.$user_id.'",';
									$query.='"offset",';
									$query.='"'.$openingbalance.'",';
									$query.='"'.$net_platform_fees.'",';
									$query.='"INR",';
									$query.='"C",';
									$query.='"'.$closingbalance.'",';
									$query.='4,';
									$query.='"'.$orderAmount.'",';
									$query.='"'.$paymentrefernce.'",';
									$query.='2,';
									$query.='NOW(),';
									$query.='NOW(),';
									$query.='CURDATE(),';
									$query.='0.00,';
									$query.='0.00,';
									$query.='"'.$order_date.'",';
									$query.='"Gateway Charges",';
									$query.='"'.$txTime.'"
									
								)';
				
				//echo $query;
								//echo $flag."\n";
				$query=query($query);
				$result=confirm($query);
				if(!$result)
				{
					$flag = false;
					rollback();
					$temp=array();
					$temp['response_code']=404;
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("checkout"=>$temp));
					close();
					exit();
				}
					//echo $flag."\n";
				$openingbalance=$walletbalance->closing_balance;
				$closingbalance=$newclosingbalance;
			
				$result=$walletbalance->upadteWalletDetails($user_id,$openingbalance,$closingbalance,$valuedate);
				//echo $flag;
				if(!$result)
				{
					$flag=false;
					rollback();
					$temp=array();
					$temp['response_code']=404;
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("checkout"=>$temp));
					close();
					exit();
				}
				//echo $flag;
				if($flag)
				{
					commit();
					$temp=array();
					$temp['response_code']=200;
					$temp['response_desc']="Sucess";
					echo json_encode(array("checkout"=>$temp));
				}
				else
				{
					rollback();
					$temp=array();
					$temp['response_code']=404;
					$temp['response_desc']="Invalid Results";
					echo json_encode(array("checkout"=>$temp));
					close();
					exit();
				}
				
		}	
		else
		{	
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="Please Enter Amount greater then Zero";
			echo json_encode(array("checkout"=>$temp));
		}	
			
		}				

    }
    //print_r($_REQUEST);
}
 
else 
{
// Reject this call
	$query="update basket_order set payment_reference='".$referenceId."',payment_gateway_status='".$txStatus."',payment_method='".$paymentMode."',amount_received='".$orderAmount."',payment_transaction_time='".$txTime."' where basket_order_id='".$orderId."'";
	//echo $query;
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
		$temp['response_code']=400;
		$temp['response_desc']="$txStatus";
		echo json_encode(array("checkout"=>$temp));
		close();
		exit();
	}
	else
	{
		rollback();
		$temp=arry();
		$temp['response_code']=404;
		$temp['response_desc']="Invalid Results";
		echo json_encode(array("checkout"=>$temp));
		close();
		exit();
	}
    	
 }
close();	
?>
