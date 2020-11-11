<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='' && isset($_REQUEST['beneficiary_name']) && $_REQUEST['beneficiary_name']!=''&& isset($_REQUEST['account_number']) && $_REQUEST['account_number']!=''&& isset($_REQUEST['ifsc_code']) && $_REQUEST['ifsc_code']!='')
{

	$user_id=$_REQUEST['user_id'];
	$beneficiary_name=$_REQUEST['beneficiary_name'];
	$account_number = $_REQUEST['account_number'];
	$ifsc_code = $_REQUEST['ifsc_code'];
	$check_status='';
	$chequeimage='';
	if($_REQUEST['imagestatus']=='1')
	{
			$cheque=$_REQUEST['cheque_image'];
			$chequeimage=$_REQUEST['image_name'];
			$date=date('Ymd').rand(10000,100000);
			if($cheque=='defaultpic.jpg'||$cheque=='defaultpic.png')
			{
				$chequeimage='cheques'.DS.'cheque'.$date.$user_id.'.png';
			}
			
			$chequeimage1=UPLOAD_DIRECTORY_CHEQUE.$date.$user_id.'.png';
			//echo $chequeimage1;
			$check_status=imageupload($cheque,$chequeimage1);
	}
	else
	{
		$chequeimage=$_REQUEST['image_name'];
	}
	
	if($check_status=="Invalid")
	{
		$chequeimage="defaultpic.png";
	}
	$query="update seller_details set 
					beneficiary_name = '".$beneficiary_name."',
					account_number = '".$account_number."',
					cheque_image='".$chequeimage."',
					bank_account_verified='No',
					ifsc_code = '".$ifsc_code."'
					where 
						seller_id='".$user_id."' " ;
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
			$temp['response_code']=200;
			$temp['response_desc']="Success";
	 		echo json_encode(array("updatebankdetails"=>$temp));

		}
		else
		{
			rollback();
			$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("updatebankdetails"=>$temp));
		}
	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatebankdetails"=>$temp));
}
close();
?>
