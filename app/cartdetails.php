<?php include("../config/config.php"); ?>

<?php

  $showinformation=0;
  $message="";

  $promocode_minimum_order_amount=0;
  $promocode_discount_type="";
  $promocode_discount_value=0;
  $promo_code="";

  if(isset($_POST['apply_promocode']))
  {
    $data['user_id']=$_SESSION['sellerdomain_user_id'];
    $data['promocode']=$_POST['promocode'];

    $url=DOMAIN.'/rest/seller/getPromocodeDetailsRest.php';
    $output=getRestApiResponse($url,$data);
    
    if(isset($output['getpromocode']) && $output['getpromocode']['response_code']==200)
    {
      $promocode_minimum_order_amount=$output['getpromocode'][0]['minimum_order_amount'];
      $promocode_discount_type=$output['getpromocode'][0]['discount_type'];
      $promocode_discount_value=$output['getpromocode'][0]['discount_value'];
      $promo_code=$output['getpromocode'][0]['promo_code'];
    }
    else
    if(isset($output['getpromocode']) && $output['getpromocode']['response_code']==404)
    {
      $showinformation=1;
      $message='<p class="text-danger">Invalid promocode!</p>';
    }
    else
    if(isset($output['getpromocode']) && $output['getpromocode']['response_code']==405)
    {
      $showinformation=1;
      $message='<p class="text-danger">This promocode is expired!</p>';
    }
  }
  else
  if(isset($_POST['inc_qty_product_in_cart']))
  {
    if(count($_SESSION["cartdetails"])!=0)
    {
      foreach($_SESSION['cartdetails'] as $key => $value)
      {
        if(intval($value['product_id'])==intval($_POST['product_id']))
        {
          $_SESSION['cartdetails'][$key]['quantity']=intval($value['quantity'])+1;
          break;
        }
      }
    }
  }
  else
  if(isset($_POST['dec_qty_product_in_cart']))
  {
    if(count($_SESSION["cartdetails"])!=0)
    {
      foreach($_SESSION['cartdetails'] as $key => $value)
      {
        if(intval($value['product_id'])==intval($_POST['product_id']))
        {
          $_SESSION['cartdetails'][$key]['quantity']=intval($value['quantity'])-1;
          break;
        }
      }
    }
  }
  else
  if(isset($_POST["delete_product_from_cart"]))
  {
      if(count($_SESSION["cartdetails"])!=0)
      {
        $index=-1;
        foreach($_SESSION['cartdetails'] as $key => $value)
        {
          if(intval($value['product_id'])==intval($_POST['product_id']))
          {
            $index=$key;
            break;
          }
        }

        if($index!=-1)
          unset($_SESSION['cartdetails'][$index]);
      }
  }
  else
  if(isset($_POST['checkout_form']))
  {
    $data=array();

    foreach($_POST['cart_products_array'] as $key => $value) 
    {
      array_push($data,array(
            'user_id' => $_POST['user_id'],
            'catalogue_id' => $value['catalogue_id'], 
            'product_id' => $value['product_id'],
            'order_quantity' => $value['order_quantity'],
            'order_amount_total' => $value['order_amount_total'],
            'tax_amount' => $value['tax_percent']
      ));
    }

    if(isset($_POST['order_type']))
    {
      if($_POST['order_type']=="online")
        $data['order_type']="Prepaid";
      else
      if($_POST['order_type']=="COD")
        $data['order_type']="COD";
    }

    $data['payment_method']=$_POST['order_type'];
    
    $data['user_id']=$_POST['user_id'];
    $data['customer_name']=$_POST['customer_name'];
    $data['customer_email']=$_POST['customer_email'];
    $data['customer_mobile']=$_POST['customer_mobile'];
    $data['delivery_address1']=$_POST['customer_address1'];
    $data['delivery_address2']=$_POST['customer_address2'];
    $data['country']=$_POST['country'];
    $data['state']=$_POST['state'];
    $data['city']=$_POST['city'];
    $data['pincode']=$_POST['pincode'];

    $data['total_items']=$_POST['total_items'];
    $data['net_amount']=$_POST['net_amount'];
    $data['delivery_charge']=$_POST['delivery_charge'];
    $data['discount']=$_POST['discount'];

    $data['tax_amount']=0;

    print_r($data);  echo "<br><br>";

    $url =DOMAIN."/rest/seller/cartCheckoutCreateOrdersRest.php";
    $defaults = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_BINARYTRANSFER => TRUE,
    CURLOPT_POSTFIELDS => array('data'=>serialize($data)),
    );

    $client=curl_init();
    curl_setopt_array($client,$defaults);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);

    $output=curl_exec($client);
    curl_close($client);
    $output = json_decode($output,JSON_FORCE_OBJECT);

    print_r($output);

    if(isset($output['checkout']) && $output['checkout']['response_code']==200 && $output['checkout']['order_type']=="Prepaid" && isset($output['checkout']['paymentLink']))
    {
        unset($_SESSION['cartdetails']);
        unset($_SESSION['sellerdomain_delivery_charge']);
        unset($_SESSION['sellerdomain_delivery_free_above']);
        unset($_SESSION['sellerdomain_user_id']);
        header("Location: ".$output['checkout']['paymentLink']);
        exit();
    }
    else
    if(isset($output['checkout']) && $output['checkout']['response_code']==404 && $output['checkout']['order_type']=="Prepaid")
    {
      // what to show
    }
    else
    if(isset($output['checkout']) && $output['checkout']['response_code']==200 && $output['checkout']['order_type']=="COD")
    {
        unset($_SESSION['cartdetails']);
        unset($_SESSION['sellerdomain_delivery_charge']);
        unset($_SESSION['sellerdomain_delivery_free_above']);
        unset($_SESSION['sellerdomain_user_id']);
    }
  }

// unset($_SESSION["cartdetails"][]);
// $customer_details = array(
//  $code=>array('name'=>$name,'code'=>$code,'price'=>$price,'quantity'=>1,'image'=>$image)
// );
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo APP; ?> - Customer Cart Checkout</title>

    <link rel="stylesheet" href="../public/font-awesome/css/fontawesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../public/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">  
    <link rel="stylesheet" href="../public/css/bootstrap/bootstrap.min.css">
    <script src="../public/js/jquery.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
  </head>
  <body>

<div class="modal fade" id="information-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <i class="fas fa-bell fa-2x text-warning"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="information">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<?php
  if($showinformation==1)
    echo '<script>
        $("#information").html(\''.$message.'\');
        $("#information-modal").modal("show");
      </script>';
?>

<?php
  if(isset($_SESSION['cartdetails']) && count($_SESSION['cartdetails'])!=0)
  {
?>
  <!--Main layout-->
  <main class="mt-5 pt-4">
    <div class="container wow fadeIn">
      <!-- Heading -->
      <h3 class="my-5 h3 text-center">Checkout Form</h3>

        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-12 col-md-6 mb-4">

              <!-- Heading -->
              <h4 class="d-flex justify-content-between align-items-center mb-3">
               <span class="text-muted">Your Cart</span>
               <span class="badge badge-secondary badge-pill"><?php echo count($_SESSION['cartdetails']); ?></span>
              </h4>

              <!-- Cart -->
              <ul class="list-group mb-3 z-depth-1">
              <?php
                $total_indivisual_price=0;
                $total_price = 0;
                $delivery_charge=0;
                $discount=0;
                $k=0;

                $cart_products_array=array();

                foreach($_SESSION['cartdetails'] as $key => $value)
                {
              ?>
                <li class="list-group-item">
                 <div class="row item">
                   <div class="col-4 align-self-center">
                    <img class="img-fluid" src="..<?php echo $value['product_image']; ?>">
                   </div>
                   <div class="col-8">
                        <div class="row">
                          <div class="col-4"><b>Name :</b></div>
                          <div class="col-8 text-right"><?php echo $value['product_name']; ?></div>
                        </div>
                        <div class="row mt-3">
                          <div class="col-5 col-md-4">
                            <b>Quantity : </b>
                          </div>
                          <div class="col-2 border border-secondary text-center">
                            <?php echo $value['quantity']; ?>
                          </div>
                          <div class="col-5 col-md-6">
                            <div class="row">
                              <div class="offset-md-2"></div>
                              <div class="col-4 col-md-3">
                                 <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?> ">
                                    <button class="btn btn-warning btn-sm" type="submit" name="dec_qty_product_in_cart"><i class="fas fa-minus"></i></button>
                                 </form>
                               </div>
                              <div class="col-4 col-md-3">
                                 <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?> ">
                                    <button class="btn btn-success btn-sm" type="submit" name="inc_qty_product_in_cart"><i class="fas fa-plus"></i></button>
                                 </form>
                               </div>
                              <div class="col-4 col-md-3">
                                 <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?> ">
                                    <button class="btn btn-danger btn-sm" type="submit" name="delete_product_from_cart"><i class="fas fa-trash"></i></button>
                                 </form>
                               </div>
                            </div>
                          </div>
                        </div>
                       <div class="row mt-3">
                        <div class="col-6"><b>Net Price : </b></div>
                        <div class="col-6 text-right"><i class="fas fa-rupee-sign text-muted"></i>&nbsp;<?php echo $value['price']; ?>&nbsp;<i class="fa-lg">&times;</i>&nbsp;<?php echo $value['quantity']; ?></div>
                       </div>
                       <div class="row mt-3">
                        <div class="col-6"></div>
                        <div class="col-6 text-right"><i class="fas fa-rupee-sign text-muted"></i>&nbsp;<?php echo $value['price'] * $value['quantity'] ; ?></div>
                        </div>
                      <?php 
                        $total_indivisual_price=$value['price'] * $value['quantity'];
                        $total_price += $value['price'] * $value['quantity'];  
                      ?>
                   </div>
                 </div>
                </li>
              <?php
                  array_push($cart_products_array,
                    array(  'user_id' => 1, 
                            'catalogue_id' => $value['catalogue_id'], 
                            'product_id' => $value['product_id'],
                            'order_quantity' => $value['quantity'],
                            'order_amount_total' => $total_indivisual_price,
                            'tax_percent' => $value['tax_percent']
                          ));
                }
              ?>

              <?php
                if($promocode_discount_type=="Flat" || $promocode_discount_type=="Percentage")
                {
                  if($total_price>=$promocode_minimum_order_amount)
                  {
                    if($promocode_discount_type=="Flat")
                    {
                      $total_price-=$promocode_discount_value;
                      $discount=$promocode_discount_value;
                      echo '<li class="list-group-item row bg-light">
                             <div class="col-12 text-success">
                               <h6 class="my-0">Discount</h6>
                               <span><i class="fas fa-minus"></i>&nbsp;&nbsp;<i class="fas fa-rupee-sign"></i>&nbsp;<b>'.$promocode_discount_value.'</b></span>
                              </div>
                              <div class="col-12">
                              <form action="" method="post">
                                <button type="submit" name="remove_promocode" class="btn bg-transparent border-0">
                                  <p class="mt-3"><span class="badge badge-success badge-pill">'.$promo_code.'</span><sup><span class="badge badge-pill badge-danger ml-0"><i class="fa-2x">&times;</i></span></sup></p>
                                </button>
                              </form>
                             </div>
                           </li>';

                      $message='<p class="text-success">Promocode applied successfully!</p>';
                      echo '<script>
                        $("#information").html(\''.$message.'\');
                        $("#information-modal").modal("show");
                      </script>';
                    }
                    else
                    if($promocode_discount_type=="Percentage")
                    {
                      $per_discount=($total_price/100)*$promocode_discount_value;
                      $per_discount=round($per_discount,2);
                      $discount=$per_discount;
                      $total_price-=$per_discount;
                      echo '<li class="list-group-item d-flex justify-content-between bg-light">
                             <div class="text-success">
                               <h6 class="my-0">Discount</h6>
                               <span class="badge badge-secondary badge-pill"><small>'.$promo_code.'</small></span>
                             </div>
                             <span class="text-success"><i class="fas fa-minus"></i>&nbsp;&nbsp;<i class="fas fa-rupee-sign"></i>&nbsp;<b>'.$per_discount.'</b></span>
                           </li>';

                      $message='<p class="text-success">Promocode applied successfully!</p>';
                      echo '<script>
                        $("#information").html(\''.$message.'\');
                        $("#information-modal").modal("show");
                      </script>';
                    }
                  }
                  else
                  {
                    $promo_code="";
                    $message='<p class="text-danger">This promocode is only applicable on order greater than '.$promocode_minimum_order_amount.'</p>';
                    echo '<script>
                      $("#information").html(\''.$message.'\');
                      $("#information-modal").modal("show");
                    </script>';
                  }
                }
              ?>
               <li class="list-group-item">
                  <div class="row">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-6">
                          <span>Delivery Charge (INR)</span>
                        </div>
                        <div class="col-6 text-right">
                          <strong><i class="fas fa-rupee-sign"></i>&nbsp;
                            <?php
                              if($total_price>$_SESSION['sellerdomain_delivery_free_above'])
                              {
                                $delivery_charge=0;
                                echo $delivery_charge;
                              }
                              else
                              {
                                $total_price+=$_SESSION['sellerdomain_delivery_charge'];
                                $delivery_charge=$_SESSION['sellerdomain_delivery_charge'];
                                echo $delivery_charge;
                              }
                            ?>
                          </strong>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mt-2">
                      <div class="row">
                        <div class="col-6">
                          <span>Total (INR)</span>
                        </div>
                        <div class="col-6 text-right">
                          <strong><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $total_price; ?></strong>
                        </div>
                      </div>
                    </div>
                  </div>
               </li>
              </ul>

         <!-- Promo code -->
         <?php
          if($promo_code=="")
          {
         ?>
         <form action="" method="post" class="card p-2">
           <div class="input-group">
             <input type="text" name="promocode" class="form-control" placeholder="Promocode" oninput="this.value=this.value.toUpperCase();" required>
             <div class="input-group-append">
               <input type="submit" name="apply_promocode" class="btn btn-success btn-md waves-effect m-0" value="Apply">
             </div>
           </div>
         </form>
         <!-- Promo code -->
         <?php
            }
          ?>

       </div>
       <!--Grid column-->

           <!--Grid column-->
           <div class="col-12 col-md-6 mb-4">
            <h4 class="d-flex justify-content-end mb-3">
               <span class="text-muted">Chekout Details</span>
              </h4>
             <!--Card-->
             <div class="card">
               <!--Card content-->
                <form class="card-body" method="post" action="">

                  <div class="row mt-3">
                    <label for="yourname" class="col-5 col-form-label">Your Name</label>
                    <div class="col-7">
                      <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                       </div>
                       <input type="text" class="form-control" name="customer_name" placeholder="Your Name"  id="yourname" required>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <label for="email" class="col-5 col-form-label">Email</label>
                    <div class="col-7">
                      <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                       </div>
                       <input type="email" id="email" class="form-control" name="customer_email" placeholder="xyz@example.com">
                      </div>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <label for="mobile" class="col-5 col-form-label">Mobile Number</label>
                      <div class="col-7">
                        <div class="input-group">
                         <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">+91</span>
                         </div>
                         <input type="text" id="mobile" class="form-control" name="customer_mobile" placeholder="Your Mobile Number" required minlength="10" maxlength="10">
                       </div>
                      </div>
                  </div>

                  <div class="row mt-3">
                    <label for="address1" class="col-5 col-form-label">Address Line 1</label>
                      <div class="col-7">
                        <div class="input-group">
                         <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon4"><i class="fas fa-home"></i></span>
                         </div>
                         <input type="text" id="address1" class="form-control" name="customer_address1" placeholder="Your Flat/Building No." required>
                       </div>
                      </div>
                  </div>

                  <div class="row mt-3">
                    <label for="address2" class="col-5 col-form-label">Address Line 2</label>
                      <div class="col-7">
                        <div class="input-group">
                         <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5"><i class="fas fa-home"></i></span>
                         </div>
                         <input type="text" id="address2" class="form-control" name="customer_address2" placeholder="Your Area/Locality/Sector">
                       </div>
                      </div>
                  </div>

                  <div class="row mt-4">
                   <div class="col-4">
                     <label for="country">Country</label>
                     <select class="custom-select d-block w-100" name="country" id="country" required>
                       <option value="101">India</option>
                     </select>
                   </div>

                   <div class="col-4">
                     <label for="state">State</label>
                     <select class="custom-select d-block w-100" name="state" id="state" required>
                        <?php getStates(""); ?>
                     </select>
                     <div class="invalid-feedback">
                       Please provide a valid state.
                     </div>
                   </div>

                   <div class="col-4">
                     <label for="zip">Zip</label>
                     <input type="text" class="form-control" name="pincode" id="zip" placeholder="Pincode" required>
                     <div class="invalid-feedback">
                       Zip code required.
                     </div>
                   </div>
                  </div>

                  <div class="row mt-3">
                    <label for="city" class="col-5 col-form-label">City</label>
                      <div class="col-7">
                        <div class="input-group">
                         <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5"><i class="fas fa-home"></i></span>
                         </div>
                         <input type="text" id="city" class="form-control" name="city" placeholder="Your City" required>
                       </div>
                      </div>
                  </div>

                  <div class="row mt-4">
                    <label for="order_type" class="col-4 form-check-label">Payment Type</label>
                      <div class="col-5 border border-primary">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="order_type" value="online" required>&nbsp;Pay Now (Online)
                          </label>
                        </div>
                      </div>
                      <div class="col-3 border border-primary">
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="order_type" value="COD" required>&nbsp;COD
                          </label>
                        </div>
                      </div>
                  </div>

                  <div class="row mt-5">
                    <div class="col-12">
                      <input type="hidden" name="delivery_charge" value="<?php echo $delivery_charge; ?>">
                      <input type="hidden" name="discount" value="<?php echo $discount; ?>">
                      <input type="hidden" name="total_items" value="<?php echo count($_SESSION['cartdetails']); ?>">
                      <input type="hidden" name="net_amount" value="<?php echo $total_price; ?>">
                      <input type="hidden" name="user_id" value="<?php echo $_SESSION['sellerdomain_user_id']; ?>">

                      <?php
                        foreach($cart_products_array as $key1 => $value1)
                        {
                          foreach($value1 as $key2 => $value2)
                          {
                            echo '<input type="hidden" name="cart_products_array['.$key1.']['.$key2.']" value="'.$value2.'">';
                          }
                        }
                      ?>
                      <button class="btn btn-primary btn-lg btn-block" name="checkout_form">Checkout</button>
                    </div>
                  </div>
                </form>
              </div>
              <!--/.Card-->
            </div>
            <!--Grid column-->
     </div>
     <!--Grid row-->
   </div>
 </main>
 <!--Main layout-->

<?php
}
else
{
?>
  <div class="container">
    <div class="row text-center mt-5">
      <div class="col-12 mt-5">
        <p style="font-size:100px;"><i class="fas fa-shopping-cart"></i></p>
      </div>
      <div class="col-12 text-danger mt-2">
        <h4>Oops! You don't have any products in your cart</h4>
      </div>
      <div class="col-12 text-danger mt-5">
        <a href="generateBuyerPage.php?s=<?php echo $_SESSION['sellerdomain']; ?>" class="btn btn-primary">Back To Customer Page</a>
      </div>
    </div>
  </div>
<?php
}
?>

 </body>
</html>
