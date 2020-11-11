<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$array = unserialize($_POST['data']);
$connection->autocommit(FALSE);
$flag=true;
if($array['order_type']!='' && $array['customer_name']!='' &&$array['customer_mobile']!=''&&$array['customer_email']!=''&&$array['total_items']!=''&&$array['net_amount']!=''&&$array['user_id']!=''&&$array['delivery_address1']!='')
{
	$basket_order_id=date("YmdHis").rand(10000,100000);
	//  	//echo json_encode($_RESQUEST['0']['user_id']);
	// // }
		//echo json_encode($array['payment_method']);
 	if($array['order_type']=='Prepaid')
 	{
 		$order_status='Draft';
 	}
 	if($array['order_type']=='COD')
 	{
 		$order_status='Pending';
 	}
	$time='NOW()';
	$query='insert into basket_order (
										basket_order_id,
										order_type,
										customer_name,
										customer_mobile,
										customer_email,
										total_items,
										tax_amount,
										net_amount,
										order_date,
										seller_id,
										delivery_address1,
										delivery_address2,
										city,
										state,
										pincode,
										country,
										payment_method,
										order_status,
										discount,
										delivery_charge,
										created_datetime,
										updated_datetime
									) values
									(';
										$query.=''.$basket_order_id.',';
										$query.='"'.$array['order_type'].'",';
										$query.='"'.$array['customer_name'].'",';
										$query.='"'.$array['customer_mobile'].'",';
										$query.='"'.$array['customer_email'].'",';
										$query.='"'.$array['total_items'].'",';
										$query.='"'.$array['tax_amount'].'",';
										$query.='"'.round($array['net_amount'],2).'",';
										$query.='NOW(),';
										$query.='"'.$array['user_id'].'",';
										$query.='"'.$array['delivery_address1'].'",';
										$query.='"'.$array['delivery_address2'].'",';
										$query.='"'.$array['city'].'",';
										$query.='"'.$array['state'].'",';
										$query.='"'.$array['pincode'].'",';
										$query.='"'.$array['country'].'",';
										$query.='"'.$array['payment_method'].'",';
										$query.='"'.$order_status.'",';
										$query.='"'.$array['discount'].'",';
										$query.='"'.$array['delivery_charge'].'",';
										$query.='NOW(),';
										$query.='NOW()
									)';

	$query=query($query);
	$result=confirm($query);
	//echo json_encode($query);
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
	
	for ($i=0;$i<sizeof($array)-17;$i++)
	{		
			
			
		$query='insert into orders (
								order_id,
								order_quantity,
								tax_amount,
								order_amount_total,
								order_date,
								seller_id,
								product_id,
								catalogue_id,
								created_datetime,
								updated_datetime
							) values
							 (';
								$query.=''.$basket_order_id.',';
							$query.='"'.$array[$i]['order_quantity'].'",';
								$query.='"'.$array[(string)$i]['tax_amount'].'",';
								$query.='"'.round($array[(string)$i]['order_amount_total'],2).'",';
								$query.='NOW(),';
								$query.='"'.$array[(string)$i]['user_id'].'",';
								$query.='"'.$array[(string)$i]['product_id'].'",';
								$query.='"'.$array[(string)$i]['catalogue_id'].'",';
								$query.='NOW(),';
								$query.='NOW()
							)';
				
		//echo json_encode($query);
		//echo json_decode($query);
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

		
	}

	if($array['order_type']=='Prepaid')
	{
		  $secretKey =SECREATKEY;
		  $postData = array( 
		  "secretKey" => SECREATKEY,
		  "appId" => APPID, 
		  "orderId" => $basket_order_id, 
		  "orderAmount" => round($array['net_amount'],2), 
		  "orderCurrency" => "INR", 
		  "orderNote" => "Test", 
		  "customerName" => $array['customer_name'], 
		  "customerPhone" => $array['customer_mobile'], 
		  "customerEmail" => $array['customer_email'],
		  "returnUrl" => "https://91f30bd2ab17.ngrok.io/dev1/app/seller/order.php", 
		  "notifyUrl" => "https://91f30bd2ab17.ngrok.io/dev1/rest/seller/updateBasketOrderRest.php",);

			$apiEndpoint = "https://test.cashfree.com";
		    $opUrl = $apiEndpoint."/api/v1/order/create";
			$timeout = 10;
		   
		   $request_string = "";
		   foreach($postData as $key=>$value) {
		     $request_string .= $key.'='.rawurlencode($value).'&';
		   }
		   
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL,"$opUrl?");
		   curl_setopt($ch,CURLOPT_POST, count($postData));
		   curl_setopt($ch,CURLOPT_POSTFIELDS, $request_string);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		   $curl_result=curl_exec ($ch);
		   curl_close ($ch);
		   $jsonResponse = json_decode($curl_result);
		   //$d=array($curl_result);
		   //echo json_encode($jsonResponse->{'status'});
		    $paymentLink='';
		    
		    if (isset($jsonResponse)&&$jsonResponse->{'status'} == "OK") {
		    $paymentLink = $jsonResponse->{"paymentLink"}; 
		   // echo json_encode($jsonResponse->{'status'});
		   }
		   else
		   {
		   	$flag=false;
		   	rollback();
			$temp=array();
			$temp['order_type']='Prepaid';
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Results";
			echo json_encode(array("checkout"=>$temp));
			close();
			exit();
		   }
		   //echo json_encode($flag);
	 	   if($flag)
			{

				commit();
				$temp=array();
				$temp['order_type']='Prepaid';
				$temp['paymentLink']=$paymentLink;
				$temp['response_code']=200;			
				$temp['response_desc']="Success";
				echo json_encode(array("checkout"=>$temp));
				close();
				exit();
			}
			else
			{
				rollback();
				$temp=array();
				$temp['order_type']='Prepaid';
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Results";
				echo json_encode(array("checkout"=>$temp));
				close();
				exit();
			}
	 	   //echo json_decode($flag);
	}
	if($array['order_type']=='COD')		
	{
		if($flag)
			{
				commit();
				$temp=array();
				$temp['order_type']='COD';
				$temp['response_code']=200;			
				$temp['response_desc']="Success";
				echo json_encode(array("checkout"=>$temp));
				close();
				exit();
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
											
 }
else
{
	$temp=array();
	$temp['response_code']=400;			
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("checkout"=>$temp));
	close();
	exit();
}
close();
	
?>
