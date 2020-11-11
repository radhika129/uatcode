<?php 
	require_once('../config/config.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo APP; ?> - Order Confirmation</title>
  <link rel="stylesheet" href="../public/font-awesome/css/fontawesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../public/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    
  <link rel="stylesheet" href="../public/css/bootstrap/bootstrap.min.css">
</head>
<body>
<?php
	if(isset($_POST['orderId']) && isset($_POST['orderAmount']) && isset($_POST['txStatus']))	
	{
		if($_POST['txStatus']=="SUCCESS")
		{
?>
			<div class="container">
				<div class="row mt-5">
					<div class="col-12 text-center text-success mt-3">
						<h2>Congratulations</h2>
						<h5>Your Order has been placed Successfully</h5>
					</div>
					<div class="col-12 text-center mt-5">
						<p>Your payment of&nbsp;<b><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $_POST['orderAmount']; ?></b>&nbsp;is Successfull</p>
						<p>Your Order Id is &nbsp;<b><?php echo $_POST['orderId']; ?></b></p>
					</div>
				</div>
				<hr>
				<div class="row mt-5">
					<div class="col-12 text-center">
						<?php 
							$sellerurl="";

							if(isset($_COOKIE['sellerdomain']))
								$sellerurl=DOMAIN.'/app/generateBuyerPage.php?s='.$_COOKIE['sellerdomain'];
						?>
						<a href="<?php echo $sellerurl; ?>" class="btn btn-primary">Continue Shopping</a>
					</div>
				</div>
			</div>

<?php
		}
	}
?>
</body>
</html>