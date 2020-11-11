<?php include("../config/config.php"); ?>

<?php
  if(isset($_COOKIE['payment-complete']) && $_COOKIE['payment-complete']==1)
  {
    if(isset($_SESSION['cartdetails']))
      unset($_SESSION['cartdetails']);

    if(isset($_SESSION['sellerdomain_delivery_charge']))
      unset($_SESSION['sellerdomain_delivery_charge']);

    if(isset($_SESSION['sellerdomain_delivery_free_above']))
      unset($_SESSION['sellerdomain_delivery_free_above']);

    if(isset($_SESSION['sellerdomain_user_id']))
      unset($_SESSION['sellerdomain_user_id']);
  }

  if(isset($_POST['add_to_cart']))
  {
     $_SESSION['cartdetails'][] = array(
        'product_id'      => $_POST['product_id'],
        'catalogue_id'    => $_POST['catalogue_id'],
        'price'           =>$_POST['price'],
        'quantity'        => $_POST['quantity'],
        'product_name'    => $_POST['product_name'],
        'seller_id'       => $_POST['seller_id'],
        'product_image'   => $_POST['product_image'],
        'tax_percent'     => $_POST['tax_percent']
    );
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo APP; ?> - Customer Page</title>
  <link rel="stylesheet" href="../public/font-awesome/css/fontawesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../public/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    
  <link rel="stylesheet" href="../public/css/bootstrap/bootstrap.min.css">
  <script src="../public/js/jquery.min.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="card.css">
  <link href="../public/css/mystyles.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
  if(isset($_REQUEST['s']))
  {
    $data['username']=$_REQUEST['s'];
  }
  else
    $data['username']='ram12';
  
  $url=DOMAIN.'/rest/seller/getCatalogueProductRest.php';
  $output=getRestApiResponse($url,$data);

  if(isset($output['getproducts']) && $output['getproducts']['response_code']==200)
  {
    setcookie('sellerdomain',$_REQUEST['s']);
    
    $_SESSION['sellerdomain']=$_REQUEST['s'];
    $_SESSION['sellerdomain_delivery_charge']=$output['getproducts'][0]['delivery_charge'];
    $_SESSION['sellerdomain_delivery_free_above']=$output['getproducts'][0]['delivery_free_above'];
    $_SESSION['sellerdomain_user_id']=$output['getproducts']['user_id'];

    if(!isset($_SESSION['cartdetails']))
    {
      $_SESSION['cartdetails']=array();
    }
 ?>

  <nav class="navbar navbar-light fixed-bottom pl-5 bg-primary">
    <a class="navbar-brand" href="#">
      <img src="https://i.imgur.com/xdbHo4E.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">&nbsp;
      <?php echo APP; ?>
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form action="cartdetails.php" method="post">
          <button type="submit" name="cart_details" class="bg-transparent border-0">
            <?php 
              if(count($_SESSION['cartdetails'])>0)
                echo count($_SESSION['cartdetails']);
              else
                echo 0;
            ?>
          <i class="fas fa-shopping-basket fa-2x"></i>
          </button>
        </form>
      </li>
    </ul>
</nav>

<div class="container">

<?php
  $catalogue_array = array();

  for($i=0; $i < $output['getproducts']['rows']; $i++) 
  {
    $catalogue_array[$i] = $output['getproducts'][(string)$i]['cataloguename'];
  }
  $unique_cat_array = array();
  $unique_cat_array = array_unique($catalogue_array);
  $unique_cat_array = array_values($unique_cat_array);


  for($k=0;$k<count($unique_cat_array);$k++) 
  {
?>
    <div class="mt-4 <?php echo $unique_cat_array[$k]; ?>">
      <i class="fas fa-plus-square close <?php  echo $unique_cat_array[$k].'_collapse';  ?>"></i>
      <p class="Catalogue_name <?php echo $unique_cat_array[$k].'_name';  ?>" ><?php  echo $unique_cat_array[$k];  ?></p>
       <div class="row <?php echo $unique_cat_array[$k].'_row';  ?>">
          <?php
          for ($i=0; $i <$output['getproducts']['rows']; $i++) 
          {
             $catalogue_name = $output['getproducts'][(string)$i]['cataloguename'];

             if($output['getproducts'][(string)$i]['cataloguename'] == $unique_cat_array[$k] )
             {
                $product_image = $output['getproducts'][(string)$i]['productimage'];
                $product_name = $output['getproducts'][(string)$i]['product_name'];
                $product_id = $output['getproducts'][(string)$i]['product_id'];
                $catalogue_id = $output['getproducts'][(string)$i]['catalogue_id'];
                $product_price = $output['getproducts'][(string)$i]['product_price'];
                $product_category = $output['getproducts'][(string)$i]['product_category'];
                $product_sub_category = $output['getproducts'][(string)$i]['product_sub_category'];
                $tax_percent=$output['getproducts'][(string)$i]['tax_percent'];
                $product_price_currency = $output['getproducts'][(string)$i]['product_price_currency'];
                $product_offer_price = $output['getproducts'][(string)$i]['product_offer_price'];
                $cart_price=0;

                if($product_price!=$product_offer_price)
                  $cart_price=$product_offer_price;
                else
                  $cart_price=$product_price;

                $product_discount_type = $output['getproducts'][(string)$i]['discount_type'];
                $product_discount = $output['getproducts'][(string)$i]['discount'];
          ?>

          <div class="productt-card">
            <?php
              if($product_discount_type=="Flat")
                echo '<div class="badge ml-2">Flat <i class="fas fa-rupee-sign"></i>&nbsp;'.$product_discount.' Off</div>';
              else
              if($product_discount_type=="Percentage")
                echo '<div class="badge ml-2">'.$product_discount.' <i class="fas fa-percent"></i> Off</div>';
              else
                echo '<div class="badge ml-2">HOT</div>';
            ?>
            <div class="product-tumb">
              <img src="..<?php echo $product_image ; ?>" alt="">
            </div>
            <div class="product-details">
              <span class="product-catagory"><?php echo $product_category ; echo ","; echo $product_sub_category ;  ?></span>
              <h4><a href=""><?php echo $product_name;  ?></a></h4>
              <div class="product-bottom-details">
                <div class="product-price">
                  <?php 
                    if($product_price_currency=="INR")
                      echo '<i class="fas fa-rupee-sign"></i> ';
                    if($product_price!=$product_offer_price)
                      echo '<s>'.$product_price.'</s> '.$product_offer_price;
                    else
                      echo $product_price;
                  ?>
                </div>
                <div class="product-links">
                  <form class="" action="" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="hidden" name="catalogue_id" value="<?php echo $catalogue_id; ?>">
                    <input type="hidden" name="price" value="<?php echo $cart_price; ?>">
                    <input type="hidden" name="quantity" value="<?php echo "1"; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
                    <input type="hidden" name="seller_id" value="<?php echo $output['getproducts']['user_id']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $product_image; ?>">
                    <input type="hidden" name="tax_percent" value="<?php echo $tax_percent; ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to <i class="fa fa-shopping-cart"></i></button>
                  </form>
                </div>
              </div>
            </div>
          </div>
  <?php
          }
        }
  ?>
</div>
</div>
<?php
    }
}
else
{
?>
<div class="container">
  <div class="row text-center mt-5">
    <div class="col-12 text-danger mt-5">
      <?php
        if(isset($output['getproducts']) && $output['getproducts']['response_code']==404)
          echo '<h4>Seller does not have any products to sell!</h4>';
        else
        if(isset($output['getproducts']) && $output['getproducts']['response_code']==405)
          echo '<h4>'.$output['getproducts']['response_desc'].'</h4>';
        else
          echo '<h4>Seller domain not found!</h4>';
      ?>
    </div>
  </div>
</div>
<?php
}
?>

<script type="text/javascript">
  $(".<?php echo $unique_cat_array[$k].'_collapse'; ?>").click(function() {
    $(".<?php echo $unique_cat_array[$k].'_row'; ?>").slideToggle().toggleClass('active');
    if ($(".<?php echo $unique_cat_array[$k]; ?>").hasClass('active')) {
      $('.<?php echo $unique_cat_array[$k].'_collapse'; ?>').text('Expand');
    } else {
     $('.close').text('');
    }
  });
  $(".<?php echo $unique_cat_array[$k].'_name'; ?>").click(function(){
	$("..<?php echo $unique_cat_array[$k].'_collapse'; ?>").trigger('click');
})
</script>

</div>

</body>
</html>