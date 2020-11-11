<?php
header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['mobile'])&&$_REQUEST['mobile']!=''&& isset($_REQUEST['text'])&&$_REQUEST['text']!='')
{	
	$api_key = KEY;
	$contacts = $_REQUEST['mobile'];
	$from = SENDER;
	$sms_text = urlencode($_REQUEST['text']);

	//Submit to server

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, SMS_URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=0&routeid=7&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
	$response = curl_exec($ch);
	curl_close($ch);
	if(strpos($response, "SMS-SHOOT-ID") !== false)
	{
		$temp=array();
		$temp['response_code']=200;
		$temp['response_desc']="Success";
		echo json_encode(array("smsstatus"=>$temp));
	} 
	else
	{
		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']=$response;
		echo json_encode(array("smsstatus"=>$temp));
	}
	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("smsstatus"=>$temp));
}
close();
?>
