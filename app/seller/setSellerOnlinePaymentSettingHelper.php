<?php require_once("../../config/config.php"); ?>

<?php
	if(isset($_SESSION['user_id']))
	{
		if(isset($_POST['onlinepayment']))
		{
			$data['user_id']=$_SESSION['user_id'];
			$data['acceptonlinepayment']=$_POST['onlinepayment'];

			$url=DOMAIN.'/rest/seller/updateSellerAcceptOnlinePaymentRest.php';
			$output=getRestApiResponse($url,$data);
		
			if(isset($output['updateonlinepaymentstatus']) && $output['updateonlinepaymentstatus']['response_code']==200)
			{
				$response['status']=1;
				echo json_encode($response);
			}
			else
			{
				$response['status']=0;
				echo json_encode($response);
			}
		}
	}
?>