<?php include("navigation.php"); ?>

<?php
  if(!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2))
    redirect("login.php");
?>

<?php
if(isset($_POST['submitsetting']))
{
    if($_POST['charge']!="" && $_POST['freeabove']!="")
    {
        $data['user_id']=$_SESSION['user_id'];
        $data['delivery_charge']=$_POST['charge'];
        $data['delivery_free_above']=$_POST['freeabove'];

        $url=DOMAIN.'/rest/seller/updateSellerDeliveryChargeRest.php';
        $output=getRestApiResponse($url,$data);
        
        if(isset($output['updatedeliverycharge']) && $output['updatedeliverycharge']['response_code']==200)
            echo '<script>alert("Delivery charge settings updated successfully");</script>';
        else
            echo '<script>alert("Unable to perform this operation");</script>';
    }
    else
        echo '<script>alert("Charge Fields Must Not Be Blank!");</script>';
}
?>

<div class="container">
    <!-- Page Heading -->
    <div class="row mt-4">
        <div class="col-lg-12 text-center">
              <h4>Delivery Charge Settings<h4>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-right">
            <button class="btn btn-primary" id="deliverychargedetails-enabler">Edit</button>
        </div>
        <div class="col-12 mt-3">
            <?php
                $data['user_id']=$_SESSION['user_id'];
                $url=DOMAIN.'/rest/seller/getSellerDeliveryChargeRest.php';
                $output=getRestApiResponse($url,$data);
                $deliverycharge=0;
                $deliveryfreeabove=0;

                if(isset($output['getdeliverycharge']) && count($output['getdeliverycharge'])>2)
                {
                    $deliverycharge=$output['getdeliverycharge'][0]['delivery_charge'];
                    $deliveryfreeabove=$output['getdeliverycharge'][0]['delivery_free_above'];
                }
            ?>
            <form action="" method="post">
                <div class="row mt-3">
                    <label for="charge" class="col-6 col-md-2 col-form-label"><b>Delivery Charge:</b></label>
                    <div class="col-6 col-md-2">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-rupee-sign"></i></span>
                          </div>
                          <input type="number" class="form-control text-right" name="charge" id="charge" value="<?php echo $deliverycharge; ?>" disabled>
                        </div>
                    </div>
                
                    <label for="freeabove" class="col-6 col-md-6 col-form-label text-md-right mt-2 mt-md-0"><b>Free For Orders Above:</b></label>
                    <div class="col-6 col-md-2 mt-2 mt-md-0">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-rupee-sign"></i></span>
                          </div>
                          <input type="number" class="form-control text-right" name="freeabove" id="freeabove" value="<?php echo $deliveryfreeabove; ?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="row mt-5 d-none" id="deliverychargedetails-formbuttons">
                    <div class="offset-md-3 col-6 col-md-3 text-right">
                        <a href="displaySellerDeliveryChargeSettings.php" class="btn btn-danger w-100">Cancel</a>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="form-group">
                          <input type="submit" name="submitsetting" class="btn btn-success btn-md w-100" value="Save Charge Details">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#deliverychargedetails-enabler").on("click",
        function()
        {
            $("#deliverychargedetails-enabler").addClass("d-none");
            $("#charge").attr("disabled",false);
            $("#freeabove").attr("disabled",false);
            $("#deliverychargedetails-formbuttons").removeClass("d-none");
            $("#charge").focus();
        });
</script>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

  </body>
</html>
