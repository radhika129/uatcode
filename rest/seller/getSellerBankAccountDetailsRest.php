<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='')
{		
	

	$user_id=$_REQUEST['user_id'];
	$query="select benificiary_name,benificiary_id,account_number,bank_account_verified,ifsc_code from seller_details where seller_id='".$_REQUEST['user_id']."'";
	$query=query($query);
	$row=fetch_array($query);
	if($row['bank_account_verified']=='Yes')
	{
		$temp=array();
		$temp[]=row;
		$temp['response_code']=200;
		$temp['response_desc']="success";
 		echo json_encode(array("getsellerbankdetails"=>$temp));
	}
	if($row['bank_account_verified']!='Yes')
	{
		$temp=array();
		$temp[]=row;
		$temp['response_code']=404;
		$temp['response_desc']="No Results Found";
 		echo json_encode(array("getsellerbankdetails"=>$temp));
	}		
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getsellercustomers"=>$temp));
}
close();
?>
