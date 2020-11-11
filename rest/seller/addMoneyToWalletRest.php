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
 $secretkey = SECREATKEY;
 $data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
 $hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;

 $computedSignature = base64_encode($hash_hmac);
//echo $signature."  ".$computedSignature;
 //$txStatus=="SUCCESS"
 //$signature==$computedSignature
 if ($signature==$computedSignature) {
    if($txStatus=="SUCCESS")
    {	
    	
		$query="select seller_id,wallet_opening_balance,order_id,created_date_time from wallet_order where order_id='".$orderId."' and order_status='Draft'";
		//echo $query;
		$query=query($query);
		$row=fetch_array($query);
		$user_id=$row['seller_id'];
		$order_date=date("Y-m-d",strtotime($row['created_date_time']));
		$query="select status,logistics_integrated,kyc_completed,waive_platform_fees,accept_online_payments	 from users,seller_details where user_id='".$user_id."' and users.user_id=seller_details.seller_id";

		//echo $query;
		$query=query($query);
		confirm($query);

		if(mysqli_num_rows($query)!=0)
		{
			$row=fetch_array($query);
			//print_r($row);
			if($row['status']=="A")
			{
				if($row['accept_online_payments']=='1')
				{
				

					$walletbalance = new Wallet();
					$walletbalance->getWalletDetails($user_id);
					$valuedate =$walletbalance->value_date;
					$openingbalance=$walletbalance->opening_balance;
					$closingbalance=$walletbalance->closing_balance;
					//$openingbalance=0;
					//$closingbalance=0;

					//echo $openingbalance."\n".$closingbalance."\n";
					$newclosingbalance=$closingbalance+$orderAmount;
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
												movement_description,
												settled_amount,
												payment_reference,
												movement_status,
												created_date_time,
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
												$query.='5,';
												$query.='"Wallet Recharge Credit",';
												$query.='"'.$orderAmount.'",';
												$query.='"'.$paymentrefernce.'",';
												$query.='2,';
												$query.='NOW(),';
												$query.='"'.$order_date.'",';
												$query.='"'.$txTime.'"
												
											)';
												//echo $query;
												$query=query($query);
												
												$result=confirm($query);
												if(!$result)
												{
													$flag = false;
												}
												//echo $flag;
							
							$cashmovementid1=$user_id+date("YmdHis").rand(100,1000);
							$query='insert into cash_movements (
												cash_movement_id,
												Linked_movement,
												order_id,
												seller_id,
												entry_side,
												opening_balance,
												amount,
												amount_currency,
												dr_cr_indicator,
												closing_balance,
												movement_type,
												movement_description,
												settled_amount,
												payment_reference,
												movement_status,
												created_date_time,
												order_date,
												value_date
											) values
											(';
												$query.='"'.$cashmovementid1.'",';
												$query.='"'.$cashmovementid.'",';
												$query.='"'.$orderId.'",';
												$query.='"'.$user_id.'",';
												$query.='"offset",';
												$query.='"'.$closingbalance.'",';
												$query.='"'.$orderAmount*(-1).'",';
												$query.='"INR",';
												$query.='"D",';
												$query.='"'.$newclosingbalance.'",';
												$query.='5,';
												$query.='"Wallet Recharge Credit",';
												$query.='"'.$orderAmount.'",';
												$query.='"'.$paymentrefernce.'",';
												$query.='2,';
												$query.='NOW(),';
												$query.='"'.$order_date.'",';
												$query.='"'.$txTime.'"
												
											)';
											$query=query($query);
											$result=confirm($query);
											//echo $result;
											if (!$result) {
												$flag=false;
											}
											
								
						// echo $flag;
							//$closingbalance=$newclosingbalance;
						$result=$walletbalance->upadteWalletDetails($user_id,$openingbalance,$newclosingbalance,$closingbalance,$valuedate);
						echo $result;

						if(!$result)
						{
							$flag=false;
						}
						//echo $result."md\n";
						
						$query="update wallet_order set wallet_closing_balance='".$newclosingbalance."',payment_reference='".$paymentrefernce."',order_status='Completed',gateway_response_status='".$txStatus."',payment_date_time='".$txTime."' where order_id='".$orderId."'";
						//echo $query;
						$query=query($query);
						$result=confirm($query);
						//echo $result;
						//echo $flag;
						if(!$result)
						{
							$flag=false;
						}
						if($flag)
						{
							commit();
							$temp=array();
							$temp['response_code']=200;
							$temp['response_desc']="Sucess";
							echo json_encode(array("addwallet"=>$temp));
						}
						else
						{
							rollback();
							$temp['response_code']=404;
							$temp['response_desc']="Invalid Results";
							echo json_encode(array("addwallet"=>$temp));
						}
					}
				}
			}			

    }
    //print_r($_REQUEST);
  }
  } 
  else {
   // Reject this call
  		//What should I do if payment was Pening,cancelled etc
    	
 }
close();	
?>
