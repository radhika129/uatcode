<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
<?php include("navigation.php");  ?>

<?php
  if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2))
    redirect("login.php");
?>

<?php
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
{
	$sid=$_SESSION['user_id'];

	if(isset($_POST['save_promocode']))
	{
		$data['sid']=$_SESSION['user_id'];
		$data['promo_code']=$_POST['promocode'];
    $data['valid_till']=$_POST['valid_till'];
    $data['discount_type'] = $_POST['discounttype'];

    if($_POST['discount_value'] == ""){
      $data['discount_value'] = 0;
    }
    $data['discount_value'] = $_POST['discount_value'];
    $data['minimum_order_amount'] = $_POST['minimum_order_amount'];


		$url=DOMAIN.'/rest/seller/createSellerPromoRest.php';
		$output=getRestApiResponse($url,$data);

		// If status code is 200 then successful.
		if(isset($output['promos']) && $output['promos']['response_code']==200)
			echo '<script>alert("Promocode added successfully");</script>';
		else
		if(isset($output['promos']) && $output['promos']['response_code']==405)
			echo '<script>alert("This promocode is already exist for this product");</script>';
		else
			echo '<script>alert("Unable to perform this operation");</script>';
	}
	else
	if(isset($_POST['edit_promocode']))
	{
		$data['pid']=$_POST['pid'];
		$data['sid']=$_POST['sid'];
		$data['promo_code']=$_POST['promocode'];
		$data['valid_till']=$_POST['valid_till'];
	  $data['discount_type'] = $_POST['discounttype'];
    $data['discount_value'] = $_POST['discount_value'];
    $data['minimum_order_amount'] = $_POST['minimum_order_amount'];
    echo $data['discount_type'];

		$url=DOMAIN.'/rest/seller/updateSellerPromoRest.php';
		$output=getRestApiResponse($url,$data);

		// If status code is 200 then successful.
		if(isset($output['promos']) && $output['promos']['response_code']==200)
			echo '<script>alert("Promocode updated successfully");</script>';
		else
		if(isset($output['promos']) && $output['promos']['response_code']==405)
			echo '<script>alert("This promocode is already exist for this product");</script>';
		else
			echo '<script>alert("Unable to perform this operation");</script>';
	}
	else
	if(isset($_POST['delete_promocode']))
	{
		// creating array
		$data['pid']=$_POST['pid'];
		$data['pname']=$_POST['promocode'];
		$url=DOMAIN.'/rest/seller/deleteSellerPromoRest.php';
		$output=getRestApiResponse($url,$data);
		//print_r($output);
		// If status code is 200 then successful.
		if(isset($output['promos']) && $output['promos']['response_code']==200)
			echo '<script>alert("Promocode deleted successfully");</script>';
		else
			echo '<script>alert("Unable to perform this operation");</script>';
	}
?>

<div class="container">
  <h4 class="text-center pb-3">Promo Codes</h4>
	<div class="row border border-dark rounded">
		<div class="col-12 ">

		<?php
			if(!isset($_POST['edit_promocode_form']))
			{
		?>
		<form method="post" action="">
		  	<div class="row mt-5">
		  		<div class="col-6 col-md-6">
		    		<input type="hidden" name="sid" value="<?php echo $sid; ?>">
		    		<div class="form-group">
		    			<div class="row">
			      		<label for="promocode"><b>Promo Code:</b></label>
			      		<div class="col-6">
			      		<input type="text" name="promocode" id="promocode" class="form-control border border-left-0 border-top-0 border-right-0" required oninput="this.value = this.value.toUpperCase()">
			      	</div>
			      	</div>
			    	</div>
		   		</div>


		   		<div class="col-6 col-md-6">
		    		<div class="form-group">
		    			<div class="row">
			      		<label for="valid_till"><b>Valid Till:</b></label>
			      		<div class="col-10">
			      		<input type="date" class="form-control" name="valid_till" id="valid_till" class="form-control border border-left-0 border-top-0 border-right-0 " required>
	              		<p class="text-warning mb-4" >*(Promo code won't be valid after this date)</p>
		    		</div>
		    	</div>
		    	</div>
		   		</div>


		   		<div class="col-4 col-md-3">
		    		<div class="form-group">
		    			<div class="row">
						<label for="valid_till"><b>Discount Type:</b></label>
						<div class="col-6">
		              	<select name="discounttype" id="discounttype" class="form-control border border-left-0 border-top-0 border-right-0">
			              <!--	<option value="None">None</option>-->
			              	<option value="Percentage">Percentage</option>
			              	<option value="Flat">Flat</option>
		              	</select>
		              	</div>
		              	</div>
		   			</div>
		   		</div>


		   		<div class="col-4 col-md-3">
                		<div class="col-8 col-md-6 pt-1">
                			<div class="row">
                  			<label for="valid_till"><b></b></label>
                  			<div class="col-12">
                    		<input type="number" class="form-control" name="discount_value" id="discount_value" class="form-control border border-left-0 border-top-0 border-right-0"  min="0" style="text-align: right" >
                		</div>
                		<div class="col-4 col-md-6 mt-4">
                    		<span class="fa-lg text-secondary">&#37;</span>
                		</div>
                	</div>
            		</div>
				</div>

				
		        <div class="col-4 col-md-6 pt-3">
		        	<div class="row">
		      		<label for="valid_till" class="col-8"><b>Minimum Order Amount(in <i class="fas fa-rupee-sign"></i>&nbsp;):</b></label>
		      		<div class="col-4">
		         	<input type="number" name="minimum_order_amount" value="" min="1" class="form-control border border-left-0 border-top-0 border-right-0 text-right">
		         	</div>
		         	<p class=" mb-4 text-warning" >*(Will be applied for orders above this amount)</p>
		         	</div>
		        </div>
		  	</div>

			<div class="row">
				<div class="col-12">
				    <div class="form-group text-right">
				      <input type="submit" name="save_promocode" class="btn btn-primary btn-md text-center" value="Add Promocode" onclick="return confirm('Do you really want to save this promocode?')">
				    </div>
				</div>
			</div>
		</form>
		<?php
			}
			else
			{
				$q_e=query("select * from promocodes where id='".$_POST['pid']."'");
				confirm($q_e);
				$r_e=fetch_array($q_e);
    		?>
    		<form method="post" action="">
    		  	<div class="row mt-5">
    		  		<div class="col-md-6 col-sm-12">
    		    		<input type="hidden" name="sid" value="<?php echo $sid; ?>">
    		    		<input type="hidden" name="pid" value="<?php echo $r_e['id']; ?>">
    		    		<div class="form-group">
    		      		<label for="promocode"><b>Promo Code:</b></label>
    		      		<input type="text" name="promocode" id="promocode" class="form-control" value="<?php echo $r_e['promo_code']; ?>" required oninput="this.value = this.value.toUpperCase()">
    		    		</div>
    		   		</div>

    		   		<div class="col-md-6 col-sm-12">
    		    		<div class="form-group">
    		      		<label for="valid_till"><b>Valid Till:</b></label>
    		      		<?php
    			        	$old=$r_e['expiry_date'];
    						$informat = date('Y-m-d\TH:i',strtotime($old));
    			        ?>
    		      		<input type="datetime-local" name="valid_till" id="valid_till" value="<?php echo $informat; ?>" class="form-control" required>
                    <p class="text-warning mb-4" >*(Promo code wont be valid after this date.)</p>
    		    		</div>
    		   		</div>


              <div class="col-6 col-md-3">
                  <br>
    		    		<div class="form-group">
    <label for="valid_till"><b>Discount Type:</b></label>
                  <select name="discounttype" id="discounttype" class="form-control border border-left-0 border-top-0 border-right-0">
                    <?php
                    if( $r_e['discount_type']=="None")
                      echo '<option value="None">Not Applicable</option><option value="Percentage">Percentage</option><option value="Flat">Flat</option>';
                    else
                    if($r_e['discount_type']=="Percentage")
                      echo '<option value="Percentage">Percentage</option><option value="Flat">Flat</option><option value="None">Not Applicable</option>';
                    else
                      echo '<option value="Flat">Flat</option><option value="Percentage">Percentage</option><option value="None">Not Applicable</option>';
                     ?>

                  </select>
    		   			</div>
    		   		</div>
              <div class="col-6 col-md-3">
                <div class="row">
                    <div class="col-8 col-md-4 pt-1">
                      <label for="valid_till"><b></b></label>
                      <br>
                      <br>
                        <input type="number" name="discount_value" id="discount_value" value="<?php echo $r_e['discount_value'] ?>" class="form-control border border-left-0 border-top-0 border-right-0"  min="1" >
                    </div>

                    <div class="col-4 col-md-4">

    <br>
                        <span class="fa-lg text-secondary pt-1"> <br>
                        &#37;</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-6 col-md-6 pt-3">
          <label for="valid_till"><b>Mininmum Order Amount(in <i class="fa fa-inr"></i>&nbsp;):</b></label>
             <input type="number" name="minimum_order_amount" value="<?php echo $r_e['minimum_order_amount'] ?>" min="1" class="form-control border border-left-0 border-top-0 border-right-0" >
             <p class=" mb-4 text-warning" >*(Will be applied for orders above this amount.)</p>
            </div>


    		  	</div>

    			<div class="row">
    				<div class="col-12">
    				    <div class="form-group text-right">
    				      <input type="submit" name="edit_promocode" class="btn btn-primary btn-md text-center" value="Edit Promocode" onclick="return confirm('Do you really want to update this promocode')">
    				    </div>
    				</div>
    			</div>
    		</form>
		<?php
			}
		?>
	</div>
	</div>
<br>
  <hr>
  <br>

<?php
	// Setting array to pass on end point
	$data['sid']=$sid;

	$data['start']=0;

	if(isset($_SESSION['pages']))
		$data['end']=$_SESSION['pages'];
	else
		$data['end']=10;

	$url=DOMAIN.'/rest/seller/getSellerPromosRest.php';

	$output=getRestApiResponse($url,$data);


	if(isset($output['promos']) && count($output['promos'])>2)
	{
?>
	<div class="row mt-3">
		<div class="col-5 col-md-6">
			Show
			<select id="pages">
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
		    	<input type="text" class="form-control" placeholder="Search By Promocode" id="searchfield">
			    <div class="input-group-append">
			      <button class="btn btn-secondary" name="search" type="button" id="search">
			        <i class="fa fa-search"></i>
			      </button>
			    </div>
		  	</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-12 table-responsive">
			<table class="table table-hover table-bordered text-center pl-0" width="100%">
				<thead>
					<tr>
						<th>Promo Code</th>
						<th>Expiry Date</th>
						<th>Minimum Order Amount</th>
						<th>Discount Type</th>
            <th> Discount Value</th>
						<th>Status</th>
            <th>Is Active</th>
            <th>Promo Applied On</th>
						<th colspan="2">Action</th>
					</tr>
				</thead>
				<tbody id="promo_body">
					<?php
          // echo "ss";
						if(isset($output['promos']['rows']) && $output['promos']['rows']!=0)
						{

// echo "string";
              for($i=0;$i<$output['promos']['rows'];$i++)
      				{
                // echo $output['promos'][$i]['promo_code'];

								$current=date("Y-m-d H:i:s");
								$status="";
								if(new DateTime($output['promos'][$i]['expiry_date']) >= new DateTime($current))
									$status="<p class='text-success'>Active</p>";
								else
									$status="<p class='text-danger'>Expired</p>";


								$record="";
								$record=<<< record
								<tr>
									<td>{$output['promos'][$i]['promo_code']}</td>
									<td>{$output['promos'][$i]['expiry_date']}</td>
									<td><i class="fa fa-inr"></i>&nbsp; {$output['promos'][$i]['minimum_order_amount']}</td>
									<td>{$output['promos'][$i]['discount_type']}</td>
									<td>{$output['promos'][$i]['discount_value']}</td>
                  <td>{$status}</td>

record;
									if($output['promos'][$i]['is_active'] == '0')
									{
										$record.=<<< record
										<td>
											<input type="checkbox" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="secondary" checked class="setstock" value="{$output['promos'][$i]['id']}">
									    </td>
record;
									}
									else
									{
										$record.=<<< record
										<td>
											<input type="checkbox" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="secondary" class="setstock" value="{$output['promos'][$i]['id']}">
									     </td>
record;
									}
                  	$record.=<<< record
                  <td>{$output['promos'][$i]['promos_applied']} Products</td>
									<td>
										<form action="displaySellerPromocode.php" method="post">
											<input type="hidden" name="pid" value="{$output['promos'][$i]['id']}">
											<button type="submit" name="edit_promocode_form" class="btn btn-primary">Edit  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
										</form>
									</td>
									<td>
										<form action="displaySellerPromocode.php" method="post">
											<input type="hidden" name="pid" value="{$output['promos'][$i]['id']}">
											<button type="submit" name="delete_promocode" class="btn btn-danger" onclick="return confirm('Do you really want to delete this promocode')"><i class="fa fa-trash"></i></button>
										</form>
									</td>

								</tr>
record;
								echo $record;


              }
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<?php
		// Setting Pagination
		// $sql="select * from promocodes where seller_id='".$sid."'";
		// setupPagination($sql);

      	$qp=query("select * from promocodes where seller_id='".$sid."'");
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

<script>
  $(".page").on("click",
    function()
    {
      start=$(this).attr("start");
      end=$(this).attr("end");

      $(".page").removeClass("active");
      $(this).addClass("active");

      $.get("changeSellerPromocodeList.php?start="+start+"&end="+end,
        function(data,status)
        {
          $("#promo_body").html(data);
        });
    });

    pageNumber=5;
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
      if(pageNumber==5)
        return 0;

   		$(".page").css("display","none");
    	pageNumber-=5;
     	$("#button"+(pageNumber-4)).css("display","inline-block");
     	$("#button"+(pageNumber-3)).css("display","inline-block");
     	$("#button"+(pageNumber-2)).css("display","inline-block");
     	$("#button"+(pageNumber-1)).css("display","inline-block");
     	$("#button"+pageNumber).css("display","inline-block");
    });

    $("#next").click(function(){
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
			promo=$("#searchfield").val();

			$.get("searchPromo.php?search="+promo,
				function(data,status)
				{
					$("#promo_body").html(data);
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
		location.href="displaySellerPromocode.php";
	});
</script>


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
	            url: 'setSellerPromoInStockHelper.php',
	            data: tobesend,
	            dataType: 'json',
	            success: function(response)
	            {
	                if(response.status == 0)
	                {
	                    alert("Promocode updated");
	                }
	                else
	                {
	                    alert("Unable to update promocode");
	                }
	            }
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
