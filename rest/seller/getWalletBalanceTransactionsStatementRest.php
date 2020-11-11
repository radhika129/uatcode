<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
require('getSellerWalletBalanceRest.php');
//include('../../config/config.php');
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=''&&isset($_REQUEST['interval']) && $_REQUEST['interval']!='')
	{
		$start='';
		//$end=10;
		$end='';
		if(isset($_REQUEST['start']) && $_REQUEST['start']!='')
		{
			$start=$_REQUEST['start'];
		}		
		if(isset($_REQUEST['end']) && $_REQUEST['end']!='')
		{
			$end=$_REQUEST['end'];
		}
		// if(isset($_REQUEST['end']) && $_REQUEST['end']!='')
		// {
		// 	$end=$_REQUEST['end'];
		// }
		$walletbalance = new Wallet();
		$temp=array();
		$temp=$walletbalance->getWalletTransactionStatement($_REQUEST['user_id'],$_REQUEST['interval'],$start,$end);
		$temp['response_code']=200;
		$temp['response_desc']="Sucess";
	
 		echo json_encode(array("getwalletbalance"=>$temp));
	}
else
	{
		$temp=array();
		$temp['response_code']=400;
		$temp['response_desc']="Invalid Request";
		echo json_encode(array("getwalletbalance"=>$temp));
	}

close();
?>
