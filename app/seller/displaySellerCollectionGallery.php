<?php include("../../config/config.php"); ?>
<?php include("header.php"); ?>

<?php
  if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2))
    redirect("login.php");
?>

<?php 
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
{
	if(isset($_POST['submitgallery']))
	{
		$data['user_id']=$_SESSION['user_id'];
		$data['products']=$_POST['products'];
		$data['collection']=$_POST['collection'];

		print_r($data);
		
		if(count(array_filter($_POST['products']))!=0)
		{
			$url=DOMAIN.'/rest/seller/createCollectionProductsFromLibraryRest.php';

			$defaults = array(
			CURLOPT_URL => $url,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array('data'=>serialize($data)),
			);

			$client=curl_init();
			curl_setopt_array($client,$defaults);
			curl_setopt($client,CURLOPT_RETURNTRANSFER,true);

			$output=curl_exec($client);
			curl_close($client);

			$output=json_decode($output,JSON_FORCE_OBJECT);
			echo "<br><br>";
			print_r($output);

			if(isset($output['createcollectionproduct']) && $output['createcollectionproduct']['response_code']=200)
				echo '<script>alert("Collection and its products added successfully")</script>';
			else
				echo '<script>alert("Unable to perform this")</script>';
		}
		else
		{
			echo '<script>alert("Cant add this collection because you didnt selected any product!")</script>';
		}
	}
?>
	<div class="container-fluid">
		<div class="row mt-1">
			<div class="col-3">
				<a href="displaySellerCatalogues.php" class="btn btn-success w-100">Back To Collections</a>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-12 text-center">
				<h4>Collection Gallery</h4>
			</div>
		</div>
		<hr>

		<?php 
			$data1=array();

			$url=DOMAIN.'/rest/seller/getCollectionLibraryRest.php';

			$output=getRestApiResponse($url,$data1);
			
			if(isset($output['getcollections']) && count($output['getcollections'])>3)
			{
		?>
			<div class="row mt-4">
				<div class="col-12 col-md-3">
					<div class='row'>
						<div class='col-12 text-center'>
							<h5>Collections</h5>
						</div>
					</div>
					<div class="row mt-3 collection-gallery-scroll">
				<?php 
					for($i=0;$i<$output['getcollections']['rows'];$i++)
					{
				?>
				<div class="col-4 col-md-12 mt-3">
					<div class="card selectcollection" id="collection-box<?php echo $output['getcollections'][$i]['collection_id']; ?>">
						<div class="card-body p-0">
							<img src="<?php echo SELLER_TO_ROOT.$output['getcollections'][$i]['image_name']; ?>" class="collection-gallery-image">
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-6">
									<p class="card-text"><?php echo $output['getcollections'][$i]['collection_name']; ?></p>
								</div>
								<div class="col-6">
									<button class="btn btn-primary btn-sm showproducts" id="<?php echo $output['getcollections'][$i]['collection_id']; ?>" cname="<?php echo $output['getcollections'][$i]['collection_name']; ?>" cimage="<?php echo $output['getcollections'][$i]['image_name']; ?>">Show Products</button>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<?php
					}
				?>
					</div>
				</div>
				<div class="col-12 col-md-9" id="product-gallery">
				</div>
			</div>
		<?php
			}
			else
				echo 'No Items';
		?>
	</div>

<?php
}
?>

<script>
	$(".showproducts").on("click",
		function()
		{
			cid=$(this).attr("id");
			cname=$(this).attr("cname");
			cimage=$(this).attr("cimage");

			$(".selectcollection").css("border","#D3D3D3 1px solid");
			$("#collection-box"+cid).css("border","green 3px solid");

			$.get("changeProductGallery.php?cid="+cid+"&cname="+cname+"&cimage="+cimage,
				function(data)
				{
					$("#product-gallery").html(data);
				});
		});
</script>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</body>
</html>