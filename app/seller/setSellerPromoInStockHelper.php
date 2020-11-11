<?php require_once("../../config/config.php"); ?>

<?php
	if(isset($_SESSION['user_id']))
	{
		if(isset($_POST['pid']) && isset($_POST['value']))
		{
			$data['user_id']=$_SESSION['user_id'];
			$data['id']=$_POST['pid'];
			$data['status']=$_POST['value'];

			$url=DOMAIN.'/rest/seller/updateSellerPromosActiveStatusRest.php';
			$output=getRestApiResponse($url,$data);

			if(isset($output['updateproduct']) && $output['updateproduct']['response_code']==200)
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
