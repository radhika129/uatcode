<?php 
	require_once('../../config/config.php');
	require_once('header.php');
?>

<?php
	if(isset($_POST['orderId']) && isset($_POST['orderAmount']) && isset($_POST['txStatus']))	
	{
		if($_POST['txStatus']=="SUCCESS")
		{
?>
			<div class="container">
				<div class="row mt-5">
					<div class="col-12 text-center text-info">
						<h3>Congratulations</h3>
						<h6>Payment Successful</h6>
					</div>
					<div class="col-12 text-center mt-3">
						<p><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $_POST['orderAmount']; ?>&nbsp;Added to your Wallet</p>
					</div>
				</div>
				<hr>
				<div class="row mt-5">
					<div class="col-6 text-right">
						<a href="<?php echo DOMAIN.'/app/seller/displayAddWithdrawWalletMoney.php?addmoney'; ?>" class="btn btn-primary">Add More Money to Wallet?</a>
					</div>
					<div class="col-6">
						<a href="<?php echo DOMAIN.'/app/seller/displaySellerWallet.php'; ?>" class="btn btn-primary">Back To Wallet</a>
					</div>
				</div>
			</div>

<?php
			print_r($_SESSION);
		}
	}
?>