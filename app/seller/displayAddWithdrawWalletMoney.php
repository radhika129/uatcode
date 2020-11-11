<?php include("navigation.php"); ?>

<?php
  if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2))
    redirect("login.php");
?>

<?php 
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
{
	if(isset($_POST['add-money']))
	{
		$data['user_id']=$_SESSION['user_id'];
		$data['wallet_opening_balance']=$_POST['opening_balance'];
		$data['amount']=$_POST['amount'];
		$data['customer_name']=$_SESSION['username'];
		$data['customer_mobile']=$_SESSION['mobile'];
		$data['customer_email']='data123@gmail.com';

		$url=DOMAIN.'/rest/seller/addWalletPaymentGatewayRest.php';
		$output=getRestApiResponse($url,$data);
		//print_r($output);
		//print_r($output);
		if(isset($output['changestatustorefund']) && $output['changestatustorefund']['response_code']==200)
		{
			redirect($output['changestatustorefund']['paymentlink']);
		}
		else
		{
			// $showinformation=1;
			// $message='<p class="text-danger">Unable to update collection status</p>';
		}
	}

	// $sid=$_SESSION['user_id'];

	// if(isset($_POST['save_catalogue']) && $_POST['save_catalogue']=="savecatalogue")
	// {
	// 	$data['user_id']=$_SESSION['user_id'];
	// 	$data['catalogue_Name']=$_POST['catalogue_Name'];

	// 	$image=$_FILES['catalogue_image']['tmp_name'];

	// 	if(empty($image) || $image=="")
	// 		$data['imagestatus']=0;
	// 	else
	// 	{
	// 		$data['imagestatus']=1;
	// 		$image = file_get_contents($image);
	// 		$image= base64_encode($image);
	// 		$data['image']=$image;
	// 	}

	// 	$url=DOMAIN.'/rest/seller/CreateCatalogueDetailsScreenRest.php';
	// 	$output=getRestApiResponse($url,$data);
		
	// 	// If status code is 200 then successful.
	// 	if(isset($output['catalogue']) && $output['catalogue']['response_code']==200)
	// 	{
	// 		$showinformation=1;
	// 		$message='<p class="text-success">Collection added successfully</p>';
	// 	}
	// 	else
	// 	{
	// 		$showinformation=1;
	// 		$message='<p class="text-danger">Unable to add collection</p>';
	// 	}
	// }
	// else
	// if(isset($_POST['edit_catalogue']))
	// {
	// 	$data['user_id']=$_SESSION['user_id'];
	// 	$data['catalogue_Name']=$_POST['catalogue_Name'];
	// 	$data['catalogue_id']=$_POST['catalogue_id'];

	// 	$image=$_FILES['catalogue_image']['tmp_name'];

	// 	if(empty($image) || $image=="")
	// 	{
	// 		$data['imagestatus']=0;
	// 		$data['image_name']=$_POST['hidden_catalogue_image'];
	// 	}
	// 	else
	// 	{
	// 		$data['imagestatus']=1;
	// 		$data['image_name']=$_POST['hidden_catalogue_image'];
	// 		$image = file_get_contents($image);
	// 		$image= base64_encode($image);
	// 		$data['image']=$image;
	// 	}

	// 	$url=DOMAIN.'/rest/seller/UpdateCatalogueDetailsRest.php';
	// 	$output=getRestApiResponse($url,$data);
		
	// 	// If status code is 200 then successful.
	// 	if(isset($output['updatecatalogue']) && $output['updatecatalogue']['response_code']==200)
	// 	{
	// 		$showinformation=1;
	// 		$message='<p class="text-success">Collection updated successfully</p>';
	// 	}
	// 	else
	// 	{
	// 		$showinformation=1;
	// 		$message='<p class="text-danger">Unable to update collection</p>';
	// 	}
	// }	
	// else
	// if(isset($_POST['delete_catalogue']))
	// {
	// 	$data['user_id']=$_SESSION['user_id']; 
	// 	$data['catalogue_id']=$_POST['cid'];
	// 	$data['confirm']="ok";

	// 	$url=DOMAIN.'/rest/seller/DeleteCatalogueDetailsRest.php';
	// 	$output=getRestApiResponse($url,$data);

	// 	// If status code is 200 then successful.
	// 	if(isset($output['deletecatalogue']) && $output['deletecatalogue']['response_code']==200)
	// 	{
	// 		$showinformation=1;
	// 		$message='<p class="text-danger">Collection deleted successfully</p>';
	// 	}
	// 	else
	// 	{
	// 		$showinformation=1;
	// 		$message='<p class="text-danger">Unable to delete collection</p>';
	// 	}
	// }
?>

<div class="container">
	<div class="row mt-3">
		<div class="offset-md-2 col-12 col-md-8">
			<div class="card">
				<?php
					$data1['user_id']=$_SESSION['user_id'];

					$url=DOMAIN.'/rest/seller/getWalletBalanceRest.php';
					$output=getRestApiResponse($url,$data1);
					
					$wallet_balance=0.00;
					if(isset($output['getwalletbalance']) && count($output['getwalletbalance'])>2)
					{
						$wallet_balance=$output['getwalletbalance']['walletbalance'];
					}

					if(isset($_GET['addmoney']))
					{
				?>	
				<div class="card-header pt-1 pb-1 bg-info text-center text-white">Add Money</div>
				<div class="card-body">
				<form action="" method="post">
				  	<div class="row mt-5">
				  		<div class="col-12">
				  			<div class="row">
				  				<div class="col-6">
				  					<p>Current Wallet Balance</p>
				  				</div>
				  				<div class="col-6 text-right">
				  					<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $wallet_balance; ?>
				  				</div>
				  			</div>
				  		</div>
				  		<div class="col-12">
				      		<div class="input-group">
		                      <div class="input-group-prepend">
		                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
		                      </div>
		                      <input type="hidden" name="opening_balance" value="<?php echo $wallet_balance; ?>">
		                      <input type="number" class="form-control text-right" name="amount" placeholder="Enter Amount Here">
		                    </div>
				   		</div>
				  	</div>

					<div class="row mt-3">
						<div class="col-12 text-center">
						    <div class="form-group">
						      <button type="submit" name="add-money" class="btn btn-info btn-md">Continue</button>
						    </div>
						</div>
					</div>
				</form>
				</div>
				<?php
					}
					else
					if(isset($_GET['withdrawmoney']))
					{
				?>
				<div class="card-header pt-1 pb-1 bg-info text-center text-white">Withdraw Money</div>
				<div class="card-body">
				<form action="" method="post">
				  	<div class="row mt-5">
				  		<div class="col-12">
				  			<div class="row">
				  				<div class="col-6">
				  					<p>Current Wallet Balance</p>
				  				</div>
				  				<div class="col-6 text-right">
				  					<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $wallet_balance; ?>
				  				</div>
				  			</div>
				  		</div>
				  		<div class="col-12">
				  			<div class="row">
				  				<div class="col-1">
				  					<i class="fas fa-university fa-2x text-danger"></i>
				  				</div>
				  				<div class="col-11">
				  					<p class="mt-1">Transfer money to your Bank A/C</p>
				  				</div>
				  			</div>
				  		</div>
				  		<div class="col-12 mt-3">
				      		<div class="input-group">
		                      <div class="input-group-prepend">
		                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
		                      </div>
		                      <input type="number" class="form-control text-right" name="amount" placeholder="Enter Amount to Withdraw">
		                    </div>
				   		</div>
				  	</div>

					<div class="row mt-3">
						<div class="col-12 text-center">
						    <div class="form-group">
						      <button type="submit" name="withdraw-money" class="btn btn-info btn-md">Continue</button>
						    </div>
						</div>
					</div>
				</form>
				</div>
				<?php
					}
					else
					{
						echo '<div class="row">
								<div class="col-12 text-center text-danger">
									<h5>Invalid Request</h5>
								</div>
							</div>';
					}
				?>
			</div>	
		</div>

		<div class="offset-md-2 col-12 col-md-8 mt-3">
			<a href="javascript:history.go(-1)" class="btn btn-success">Back</a>
		</div>
	</div>
</div>

<?php
}
else
	echo "Login First";
?>

</div>
    <!-- Main Col END -->
</div>
<!-- body-row END -->

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</body>
</html>
