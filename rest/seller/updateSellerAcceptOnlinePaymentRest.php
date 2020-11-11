<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='' && isset($_REQUEST['acceptonlinepayment'])&&$_REQUEST['acceptonlinepayment']!='' )
{	
	
		$query="select 	beneficiary_id,beneficiary_name,account_number,bank_account_verified,ifsc_code,seller_email,mobile,seller_address1,seller_city,seller_pin,seller_state from 
						 seller_details,users where seller_id='".$_REQUEST['user_id']."' and user_id=seller_id";
		$query=query($query);
		$row=fetch_array($query);
		$benificiary_id='';
		if($row['seller_email'=='' or $row['seller_email'=='null'])
		{
			$email='contactuatcode@gmail.com';
		}
		else
		{
			$email=$row['seller_email'];
		}
		$benificiary_id=$row['benificiary_id'];
		if(($row['benificiary_id']=='' or $row['benificiary_id']=='null') and $row['bank_account_verified']='Yes')
		{
			$benificiary_id='BEN'.date('YmdHis').random(100,1000).'S'.$_REQUEST['user_id'];
			//$check=0;
			//while($check==0)
			//{
				//check benificiatprsent in cashfree if not then make check=1 else regenerate benificiary id

			//}
			//inserat benificiary record in cashfree using apis
			$data=array("beneId"=> $benificiary_id,
		    "name"=> $row['beneficiary_name'],
		    "email"=> $email,
		    "phone"=> $row['mobile'],
		    "bankAccount": $row['account_number'],
		    "ifsc"=> $row['ifsc_code'],
		    "address1"=> $row['seller_address1'],
		    "city"=> $row['seller_city'],
		    "state"=> $row['seller_state'],
		    "pincode"=> $row['seller_pin'])

		    //send data to api
		}
		$query="update seller_details set 
							accept_online_payments ='".$_REQUEST['acceptonlinepayment']."',
							benificiary_id='".$benificiary_id."'
						where  
							seller_id='".$_REQUEST['user_id']."' and bank_account_verified='Yes' and kyc_completed='1'";
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
			$temp['response_code']=200;
			$temp['response_desc']="Success";
	 		echo json_encode(array("updateonlinepaymentstatus"=>$temp));

		}
		else
		{
			rollback();
			$temp=array();
			$temp['response_code']=405;
			$temp['response_desc']="Your Bank Account details are not verified , hence online payments cannot be enabled";
			echo json_encode(array("updateonlinepaymentstatus"=>$temp));
		}
	
	
	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updateonlinepaymentstatus"=>$temp));
}
close();	
?>
