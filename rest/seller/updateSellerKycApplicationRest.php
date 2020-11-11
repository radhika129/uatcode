<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='')
{

	$user_id=$_REQUEST['user_id'];
	$check_status='';
	$date=date('Ymd').rand(10000,100000);
	$pancard='';
	$address='';
	
	if($_REQUEST['imagestatus']=='1')
	{
		$pancard=$_REQUEST['image_name'];
		$pan=$_REQUEST['pan_card_image'];
		if($pancard=='defaultpic.jpg'||$pancard=='defaultpic.png')
			{
				$pancard="/images/pancards/"."pancard".$_REQUEST['user_id'].$date.'.png';
			}
		$pancard1=UPLOAD_DIRECTORY.$pancard;
		$check_status=imageupload($pan,$pancard1);
	}
	else
	{
		$pancard=$_REQUEST['image_name'];
	}
	if($check_status=="Invalid")
	{
		$pancard="defaultpic.png";
	}
	
	if($_REQUEST['imagestatus1']=='1')
	{
		$address = $_REQUEST['image_name1'];
		$add=$_REQUEST['address_proof_image'];
		if($address=='defaultpic.jpg'||$address=='defaultpic.png')
			{
				$address="addressproofs".DS."address".$date.$user_id.'.png';
			}
		
		$address1=UPLOAD_DIRECTORY_ADDRESSPROOF."address".$date.$user_id.'.png';
		$check_status=imageupload($add,$address1);
	}
	else
	{
		$address = $_REQUEST['image_name'];
	}
	

	if($check_status=="Invalid")
	{
		$address="defaultpic.png";
	}
	$query="update seller_details set 
					address_proof_image ='".$address."',
					pan_card_image = '".$pancard."',
					kyc_application_status = 'Submitted'
					where 
						seller_id='".$user_id."'";
	$query=query($query);
	$result=confirm($query);
	if($result)
	{
		$flag=false;
	}
	if($flag)
	{
		commit();
		$temp=array();
		$temp['status']="Submitted";
		$temp['response_code']=200;
		$temp['response_desc']="success";
		echo json_encode(array("updatekyc"=>$temp));
	}
	else
	{
		rollback();
		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']="Invalid Operation";
		echo json_encode(array("updatekyc"=>$temp));	
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatekyc"=>$temp));
}
close();
?>
