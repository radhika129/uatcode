<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['sid']) && $_REQUEST['sid']!='')
{
	$sid=$_REQUEST['sid'];
	//$sid=2;
	/*$query=query("SELECT * FROM seller_details where seller_id='".$sid."'");
	confirm($query);

	$temp=array();

	if(mysqli_num_rows($query)!=0)
	{
		$row=fetch_array($query);
		$temp[]=$row;
	}
*/
	$temp=array();
	$query1=query("SELECT * FROM seller_details,users where seller_id='".$sid."' and seller_id=user_id");
	confirm($query1);

	if(mysqli_num_rows($query1)!=0)		// Valid Request, Data Found.
	{
		$row1=fetch_array($query1);
		$temp[]=$row1;
 	}
 	else
 	{
 		$temp[1]['store_name']="";
		$temp[1]['store_email']="";
		$temp[1]['store_mobile']="";
		$temp[1]['store_phone']="";
		$temp[1]['store_pin']="";
		$temp[1]['store_address']="";
		$temp[1]['store_city']="";
		$temp[1]['store_state']="";
		$temp[1]['store_country']="";
		$temp[1]['store_status']=0;
		$temp[1]['store_verified']=0;
 	}

 	$temp['response_code']=200;
 	$temp['response_desc']="success";

 	echo json_encode(array("seller"=>$temp));
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("seller"=>$temp));
}
close();
?>
