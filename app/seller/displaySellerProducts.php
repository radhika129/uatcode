<?php include("navigation.php"); ?>

<?php
  if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2))
    redirect("login.php");
?>

<?php 
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
{
	if(isset($_POST['setproductstatus']))
	{
		$data['user_id']=$_SESSION['user_id'];
		$data['product_id']=$_POST['pid'];
		$data['product_status']=$_POST['product_status'];

		$url=DOMAIN.'/rest/seller/updateProductStatusRest.php';
		$output=getRestApiResponse($url,$data);
		
		if(isset($output['updateproduct']) && $output['updateproduct']['response_code']==200)
		{
			if($_POST['product_status']=="Active")
				echo '<script>alert("Product activated successfully");</script>';
			else
				if($_POST['product_status']=="Inactive")
					echo '<script>alert("Product deactivated successfully");</script>';
		}
		else
			echo '<script>alert("Unable to perform this operation");</script>';
	}

	$sid=$_SESSION['user_id'];

	if(isset($_POST['save_product']))
	{
		$data['user_id']=$_SESSION['user_id'];
		$data['product_name']=$_POST['product_name'];
		$data['product_catalogue_id']=$_POST['pcid'];
		$data['product_price']=$_POST['product_price'];
		$data['product_unit']=$_POST['product_unit'];
		$data['product_price_currency']="INR";
		$data['product_description']=$_POST['product_desc'];

		$image=$_FILES['productimage']['tmp_name'];

		if(empty($image) || $image=="")
			$data['imagestatus']=0;
		else
		{
			$data['imagestatus']=1;
			$image = file_get_contents($image);
			$image= base64_encode($image);
			$data['image']=$image;
		}
		
		$url=DOMAIN.'/rest/seller/CreateProductDetailsRest.php';
		$output=getRestApiResponse($url,$data);
		
		if(isset($output['createproduct']) && $output['createproduct']['response_code']==200)
			echo '<script>alert("Product added successfully");</script>';
		else
			echo '<script>alert("Unable to perform this operation");</script>';
	}	
	else
	if(isset($_POST['delete_product']))
	{
		// creating array
		$data['user_id']=$_SESSION['user_id']; 
		$data['product_id']=$_POST['pid'];

		$url=DOMAIN.'/rest/seller/DeleteProductDetailsRest.php';
		$output=getRestApiResponse($url,$data);

		// If status code is 200 then successful.
		if(isset($output['deleteproduct']) && $output['deleteproduct']['response_code']==200)
			echo '<script>alert("Product deleted successfully");</script>';
		else
			echo '<script>alert("Unable to perform this operation");</script>';
	}
?>

<div class="container">
	<div class="row border border-dark rounded">	
		<div class="col-12">
		<form enctype="multipart/form-data" action="" method="post">
		  	<div class="row mt-5">
		  		<div class="col-6 col-md-6">
		    		<div class="form-group">
			      		<label for="pcid"><b>Choose Collection:</b></label>
			      		<select class="form-control border border-top-0 border-left-0 border-right-0" name="pcid" id="pcid" required>
			      			<?php 
			      				if(isset($_POST['showproductsbycid']))
			      					getCatalogues($_POST['cid']);
								else
									getCatalogues(""); 
							?>
			      		</select>
		    		</div>
		   		</div>
		  		<div class="col-6 col-md-6">
		    		<div class="form-group">
		      		<label for="product_name"><b>Product Name:</b></label>
		      		<input type="text" name="product_name" id="product_name" class="form-control border border-top-0 border-left-0 border-right-0" required>
		    		</div>
		   		</div>
		   	</div>
		   	<div class="row">
				<div class="col-12 col-md-6">
					<div class="row">
						<div class="col-5 col-md-6">
						    <div class="form-group">
						        <label for="product_price"><b>Price:</b></label>
						        <input type="number" name="product_price" id="product_price" class="form-control border border-top-0 border-left-0 border-right-0 text-right" required>
						    </div>
						</div>
						<div class="col-1">
							<i class="fas fa-rupee-sign mt-5"></i>
						</div>
						<div class="col-6 col-md-5">
							<div class="form-group">
					      		<label for="product_unit"><b>Unit:</b></label>
					      		<select class="form-control border border-top-0 border-left-0 border-right-0" name="product_unit" id="product_unit" required>
					      			<option value="1">Per Item</option>
					      			<option value="2">Per Kg</option>
					      			<option value="3">Per Litre</option>
					      			<option value="4">Per Pair</option>
					      			<option value="5">Pack Of 4</option>
					      		</select>
				    		</div>
						</div>
						<div class="col-12">
						    <div class="form-group">
						        <label for="product_image"><b>Choose Product Image:</b></label>
						        <input type="file" accept="image/*" name="productimage" id="product_image" class="form-control border border-top-0 border-left-0 border-right-0" title="Upload Product Image" style="overflow:hidden;">
						    </div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
				        <label for="product_desc"><b>Product Description:</b></label>
				        <textarea name="product_desc" id="product_desc" class="form-control" rows="5" cols="15"></textarea>
				    </div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
				    <div class="form-group text-right">
				      <input type="submit" name="save_product" class="btn btn-primary btn-md text-center" value="Add Product" onclick="return confirm('Do you want to save this product?')">
				    </div>
				</div>
			</div>
		</form>
	</div>
	</div>	

<?php 
	// Setting array to pass on end point
	$data1['user_id']=$_SESSION['user_id'];
	$data1['start']=0;

	if(isset($_SESSION['pages']))
		$data1['end']=$_SESSION['pages'];
	else
		$data1['end']=10;

	if(isset($_POST['showproductsbycid']))
	{
		$data1['catalogueid']=$_POST['cid'];
	}

	$url=DOMAIN.'/rest/seller/getProductDetailsRest.php';

	$output=getRestApiResponse($url,$data1);
	
	if(isset($output['getproducts']) && count($output['getproducts'])>2)
	{
?>
	<div class="row mt-5">
		<div class="col-5 col-md-6">
			Show
			<select id="pages" placeholder="">
				<option><?php if(isset($_SESSION['pages']))
								echo $_SESSION['pages']; ?>
				</option>
				<option value="1">1</option>
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			Entries
		</div>
		<div class="col-7 offset-md-2 col-md-4">
			<div class="input-group">
		    	<input type="text" class="form-control" placeholder="Search By Product Name" id="searchfield">
			    <div class="input-group-append">
			      <button class="btn btn-secondary" type="button" id="search">
			        <i class="fa fa-search"></i>
			      </button>
			    </div>
		  	</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-12 table-responsive">
			<table class="table table-hover table-bordered text-center table-sm" width="100%">
				<thead>
					<tr>
						<th>Collection Name</th>
						<th>Product Image</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>In Stock</th>
						<th title="Only active products will be displayed on your website">Status</th>
						<th colspan="3">Action</th>
						<th title="Share Products On Whatsapp">Share</th>
					</tr>
				</thead>
				<tbody id="product_body">
					<?php 
						if(isset($output['getproducts']['rows']) && $output['getproducts']['rows']!=0)
						{
							for($i=0;$i<$output['getproducts']['rows'];$i++)
							{
								$record="";
								$seller_to_root=SELLER_TO_ROOT;
								$producturl=DOMAIN."/".$_SESSION['username']."?pid=".$output['getproducts'][$i]['product_id'];
								$record.=<<< record
								<tr>
									<td>{$output['getproducts'][$i]['catalogue_Name']}</td>
									<td><img src="{$seller_to_root}{$output['getproducts'][$i]['productimage']}" class="list-image">
									</td>
									<td>{$output['getproducts'][$i]['product_name']}</td>
record;
									if($output['getproducts'][$i]['product_price']==$output['getproducts'][$i]['product_offer_price'])
									{
										$record.=<<< record
										<td class="text-right"><i class="fas fa-rupee-sign"></i>&nbsp;{$output['getproducts'][$i]['product_price']}</td>
record;
									}
									else
									{
										$record.=<<< record
										<td class="text-right"><i class="fas fa-rupee-sign"></i>&nbsp;<s>{$output['getproducts'][$i]['product_price']}</s>&nbsp;{$output['getproducts'][$i]['product_offer_price']}</td>
record;
									}
									
									if($output['getproducts'][$i]['product_inventory']==0)
									{
										$record.=<<< record
										<td>
											<input type="checkbox" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="secondary" checked class="setstock" value="{$output['getproducts'][$i]['product_id']}">
									    </td>
record;
									}
									else if($output['getproducts'][$i]['product_inventory']==1)
									{
										$record.=<<< record
										<td>
											<input type="checkbox" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="secondary" class="setstock" value="{$output['getproducts'][$i]['product_id']}">
									     </td>
record;
									}

									if($output['getproducts'][$i]['product_status']=="Active")
									{
										$record.=<<< record
										<td><p class='text-success'>Active</p></td>
										<td>
											<form action="displaySellerProducts.php" method="post">
												<input type="hidden" name="pid" value="{$output['getproducts'][$i]['product_id']}">
												<input type="hidden" name="product_status" value="Inactive">
												<button type="submit" name="setproductstatus" class="btn btn-warning">Deactivate</button>
											</form>
										</td>
										<td>
											<form action="displayUpdateSellerProduct.php" method="post">
												<input type="hidden" name="pid" value="{$output['getproducts'][$i]['product_id']}">
												<button type="submit" name="edit_product" class="btn btn-primary">Edit</button>
											</form>
										</td>
record;
									}
									else if($output['getproducts'][$i]['product_status']=="Inactive")
									{
										$record.=<<< record
										<td><p class='text-danger'>Inactive</p></td>
										<td>
											<form action="displaySellerProducts.php" method="post">
												<input type="hidden" name="pid" value="{$output['getproducts'][$i]['product_id']}">
												<input type="hidden" name="product_status" value="Active">
												<button type="submit" name="setproductstatus" class="btn btn-info">Activate</button>
											</form>
										</td>
										<td>
											<form action="displayUpdateSellerProduct.php" method="post">
												<input type="hidden" name="pid" value="{$output['getproducts'][$i]['product_id']}">
												<button type="submit" name="edit_product" class="btn btn-secondary" disabled>Edit</button>
											</form>
										</td>
record;
									}

									$record.=<<< record
									<td>
										<form action="displaySellerProducts.php" method="post">
											<input type="hidden" name="pid" value="{$output['getproducts'][$i]['product_id']}">
											<button type="submit" name="delete_product" class="btn btn-danger" onclick="return confirm('Do you really want to delete this product')"><i class="fa fa-trash"></i></button>
										</form>
									</td>
record;
									if($output['getproducts'][$i]['product_status']=="Active")
									{
										$record.=<<< record
										<td>
											<a href="https://api.whatsapp.com/send?text={$producturl}" target="_blank" title="Share Product Link On Whatsapp"><i class="fab fa-whatsapp text-success fa-2x"></i></a>
										</td>
									</tr>
record;
									}
									else if($output['getproducts'][$i]['product_status']=="Inactive")
									{
										$record.=<<< record
										<td>
											<a title="Prodcut is inactive" disabled><i class="fab fa-whatsapp text-secondary fa-2x"></i></a>
										</td>
									</tr>
record;
									}
								echo $record;
							}
						}
					?>
<script>
	$('.setstock').change(
    	function(){

	      value=0;
	      pid=$(this).val();

	      if($(this).prop('checked'))
	       value=0;
	      else
	       value=1;

	   	  var tobesend = 'pid='+pid+'&value='+value;

	   		$.ajax({
	            type: 'POST',
	            url: 'setSellerProductInStockHelper.php',
	            data: tobesend,
	            dataType: 'json',
	            success: function(response)
	            { 	
	                if(response.status == 1)
	                {
	                    alert("Product stock updated");
	                }
	                else
	                {
	                    alert("Unable to update product stock");
	                }
	            }
		    });
     	});
</script>
				</tbody>
			</table>
		</div>
	</div>

	<?php 
		// Setting Pagination
		// $sql="select * from promocodes where seller_id='".$sid."'";
		// setupPagination($sql);

		if(isset($_POST['showproductsbycid']))
      		$qp=query("select * from product_details where product_seller_id='".$sid."' and product_catalogue_id='".$_POST['cid']."'");
      	else
      		$qp=query("select * from product_details where product_seller_id='".$sid."'");
        confirm($qp);

        if(mysqli_num_rows($qp)!=0)
        {
            $p=intval(mysqli_num_rows($qp));

            if(isset($_SESSION['pages']))
            	$n=intval($p/$_SESSION['pages']);
            else
            	$n=intval($p/10);

            if(isset($_SESSION['pages']))
            	$rem=intval($p%$_SESSION['pages']);
            else
            	$rem=intval($p%10);

            $pages=$n;

            if($rem!=0)
              $pages+=1;

            $i=1;
            $start=0;

            if(isset($_SESSION['pages']))
            	$end=$_SESSION['pages'];
            else
            	$end=10;
            // Pagination
            echo "<div class='row mt-2'>
                    <div class='col-md-12'>
                      <ul class='pagination justify-content-center'>
                      <li id='prev' class='page-item'><span style='cursor:pointer;' class='page-link'><i class='fa fa-backward'></i></span></li>
                      <li class='page-item active page' start='$start' end='$end' id='button$i'><span style='cursor:pointer;' class='page-link'>$i</span></li>";

            if(isset($_SESSION['pages']))
            	$start+=$_SESSION['pages'];
            else
            	$start+=10;

            for($i=2;$i<=$pages;$i++)
            {
              echo "<li class='page-item page' start='$start' end='$end' id='button$i'><span style='cursor:pointer;' class='page-link'>$i</span></li>";

              if(isset($_SESSION['pages']))
              	$start+=$_SESSION['pages'];
              else
              	$start+=10;
            }
            echo "<li id='next' class='page-item'><span style='cursor:pointer;' class='page-link'><i class='fa fa-forward'></i></span></li>";
            echo '</ul>
                    </div>
                      </div>';
        }
    ?>

    <?php
	}		// if for table
	?>

</div>

<?php
	// }
	// else
	// 	echo "Access Denied!";
}
else
	echo "Login First";
?>

</div>
    <!-- Main Col END -->
</div>
<!-- body-row END -->

<!-- Libraries -->

<script>
  $(".page").on("click",
    function()
    {
      start=$(this).attr("start");
      end=$(this).attr("end");

      $(".page").removeClass("active");
      $(this).addClass("active");
      
      $.get("changeSellerProductList.php?start="+start+"&end="+end,
        function(data,status)
        {
          $("#product_body").html(data);
        });
    });

    pageNumber=5;     // for tracing five pages at a perticular time.
    totalPages=<?php echo $pages; ?>;

    $(".page").css("display","none");           
    $("#prev").css("display","inline-block");
    $("#button1").css("display","inline-block");
    $("#button2").css("display","inline-block");
    $("#button3").css("display","inline-block");
    $("#button4").css("display","inline-block");
    $("#button5").css("display","inline-block");
    $("#next").css("display","inline-block");

   	$("#prev").click(function(){
      if(pageNumber==5) // means no page before page 1 show return will end the script.
        return 0;

   		$(".page").css("display","none"); // again all pages to hide but showing previous five pages
    	pageNumber-=5;
     	$("#button"+(pageNumber-4)).css("display","inline-block");
     	$("#button"+(pageNumber-3)).css("display","inline-block");
     	$("#button"+(pageNumber-2)).css("display","inline-block");
     	$("#button"+(pageNumber-1)).css("display","inline-block");
     	$("#button"+pageNumber).css("display","inline-block");
    });

    $("#next").click(function(){
        //if(pageNumber><?php //echo floor($pages/10)/*-1*/; ?>) // means no page after page ceil($pages/5)-1 to show. return will end the script. devide by 5 because we are showing 5 records in one page
        if(pageNumber>=totalPages)
          return 0;
          
        $(".page").css("display","none");
        $("#button"+(pageNumber+1)).css("display","inline-block");
        $("#button"+(pageNumber+2)).css("display","inline-block");
        $("#button"+(pageNumber+3)).css("display","inline-block");
        $("#button"+(pageNumber+4)).css("display","inline-block");
        $("#button"+(pageNumber+5)).css("display","inline-block");
        pageNumber+=5;
      });
</script>

<script>
	$("#search").on("click",
		function()
		{
			product=$("#searchfield").val();

			$.get("searchProduct.php?search="+product,
				function(data,status)
				{
					$("#product_body").html(data);
				});
		});
</script>

<script>
	$("#pages").change(function()
	{
		pages=$(this).val();
		$.get("../recordperpage.php?pages="+pages,
			function(data,status)
			{

			});
		//location.reload(true);
		location.href="displaySellerProducts.php";
	});
</script>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</body>
</html>
