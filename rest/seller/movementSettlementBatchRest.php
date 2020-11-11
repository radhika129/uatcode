<?php
header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
require('getSellerWalletBalanceRest.php');
//confirm($query);
$connection->autocommit(FALSE);
$flag=true;

$url="https://test.cashfree.com/api/v1/settlement";
$data['appId']='387161a63257ae89517b9817561783';
$data['secretKey']='e16b50357d2fa3971bd0ffdd9708f9e330cef047';
//$data['orderId']='2020103012042083423';
$data['startDate']='2020-10-01';
$date['endDate']='';
$data['lastId']='';
$data['count']='50';
$output = getRestApiResponse($url,$data);
$lastId=$output['lastId'];
foreach ($output['settlements'] as $key) {
	# code...
	$settlement_id=$key['id'];
	$url1="https://test.cashfree.com/api/v1/settlement";
	$data1['appId']='387161a63257ae89517b9817561783';
	$data1['secretKey']='e16b50357d2fa3971bd0ffdd9708f9e330cef047';
	//$data['orderId']='2020103012042083423';
	$data1['settlementId']=$settlement_id;
	$date1['endDate']='';
	$data1['lastId']='';
	$data1['count']='50';
	
	$output1=getRestApiResponse($url1,$data1);
	$query="select
					seller_id,
					cash_movement_id,
					movement_status,
					payment_reference,
					amount,
					amount_currency,
					order_id
				FROM
					cash_movements
				WHERE
					movement_status in (4)    
					AND
					entry_side = 'seller'
					AND
					order_id='".$output1['orderId']."'
				order by
					cash_movement_id";

					//echo $query;
	$query=query($query);
	$row=fetch_array($query);
	$amount=$row['amount'];
	$seller_id=$row['seller_id'];
	if($row['movement_status']==4)
	{
		if($key['settlementAmount']>0)
		{
			$walletbalance = new Wallet();
			$walletbalance->getWalletDetails($seller_id);
			$valuedate =$walletbalance->value_date;
			$openingbalance=$walletbalance->opening_balance;
			$closingbalance=$walletbalance->closing_balance;
			$newclosingbalance=0;
			$newclosingbalance =$closingbalance+$amount;
			$query="update 
					cash_movements 
						set 
					opening_balance='".$closingbalance."',
					closing_balance='".$newclosingbalance."',
					value_date='".$key['txTime']."',
					movement_status='5',
					service_charge='".$key['serviceCharge']."',
					service_tax='".$key['serviceTax']."',
					settlement_id='".$settlement_id."',
					settled_amount='".$key['settlementAmount']."' 
						where 
					cash_movement_id='".$row['cash_movement_id']."'";
						
			$query=query($query);
			
			$result=confirm($query);
			if(!result)
			{
				$flag=false;
			}
			$query="update 
					cash_movements 
						set 
					opening_balance='".$closingbalance."',
					closing_balance='".$newclosingbalance."',
					value_date='".$key['txTime']."',
					movement_status='5',
					service_charge='".$key['serviceCharge']."',
					service_tax='".$key['serviceTax']."',
					settlement_id='".$settlement_id."',
					settled_amount='".$key['settlementAmount']."' 
						where 
					linked_amount='".$row['cash_movement_id']."'
						AND
					entry_side='offset'
						AND
					movement_type=1";
			$query=query($query);	
			$result=confirm($query);
			$result=$walletbalance->upadteWalletDetails($seller_id,$openingbalance,$newclosingbalance,$closingbalance);
					if(!result)
					{
						$flag=false;
					}
			if(!result)
			{
				$flag=false;
			}
			if($flag)
			{
				commit();
			}
			else
			{
				rollback();
			}

		}
	}


}
		//print_r($output);
		// $curl = curl_init();
	 //    curl_setopt_array($curl, array(
	 //    CURLOPT_URL =>"https://test.cashfree.com/api/v1/order/info/status" ,
	 //    CURLOPT_RETURNTRANSFER => true,
	 //    CURLOPT_ENCODING => "",
	 //    CURLOPT_MAXREDIRS => 10,
	 //    CURLOPT_TIMEOUT => 30,
	 //    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	 //    CURLOPT_CUSTOMREQUEST => "POST",
	 //    CURLOPT_POSTFIELDS => "appId=387161a63257ae89517b9817561783&secretKey=e16b50357d2fa3971bd0ffdd9708f9e330cef047&orderId=2020103012042083423",
	 //    CURLOPT_HTTPHEADER => array(
	 //        "cache-control: no-cache",
	 //        "content-type: application/x-www-form-urlencoded"
	 //    ),
	 //    ));

	 //    $response = curl_exec($curl);
	 //    $err = curl_error($curl);

	 //    curl_close($curl);
	 //    print_r($response);
	 //    if ($err) {
	 //    echo "cURL Error #:" . $err;
	 //    } else {
	 //    echo $response;
	 //     } 
	
?>