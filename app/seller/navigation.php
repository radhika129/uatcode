<?php include("../../config/config.php"); ?>
<?php include("header.php"); ?>
 
<!-- Bootstrap NavBar -->
<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-primary">

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="#">
        <span class="menu-collapsed text-white"><?php echo APP; ?></span>
    </a>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <!-- This menu is hidden in bigger devices with d-sm-none. 
           The sidebar isn't proper for smaller screens imo, so this dropdown menu can keep all the useful sidebar items exclusively for smaller screens  -->
            <li class="nav-item dropdown d-sm-block d-md-none">
                <a class="nav-link text-white" href="displaySellerDashboard.php"><span class="fas fa-tachometer-alt fa-fw mr-2"></span>Dashboard</a>
                <a class="nav-link text-white" href="displaySellerProfile.php"><span class="fas fa-user fa-fw mr-2"></span>Profile</a>

                <a class="nav-link text-white dropdown-toggle" href="#productsmenu"  id="smallerscreenmenu" data-toggle="collapse" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list fa-fw mr-2"></span>
                  Product Management
                </a>
                <div class="collapse" id="productsmenu">
                    <a class="nav-link text-white" href="displaySellerCatalogues.php">Collections</a>
                    <a class="nav-link text-white" href="displaySellerProducts.php">Products</a>
                </div>

                <a class="nav-link text-white dropdown-toggle" href="#ordersmenu" data-toggle="collapse" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list fa-fw mr-2"></span>
                  Order Management
                </a>
                <div class="collapse" id="ordersmenu">
                    <a class="nav-link text-white" href="displaySellerOrders.php">Orders</a>
                    <a class="nav-link text-white" href="#">Returned Orders</a>
                    <a class="nav-link text-white" href="#">Cancelled Orders</a>
                </div>

                <a class="nav-link text-white dropdown-toggle" href="#sellercentralmenu" data-toggle="collapse" aria-haspopup="true" aria-expanded="false"><span class="fas fa-cog fa-fw mr-2"></span>
                  Seller Plus
                </a>
                <div class="collapse" id="sellercentralmenu">
                    <a class="nav-link text-white" href="displaySellerDeliveryChargeSettings.php">Delivery Charge Settings</a>
                    <a class="nav-link text-white" href="displaySellerProductDefaultSettings.php">Product Default Settings</a>
                    <a class="nav-link text-white" href="displaySellerProfile.php">Profile Management</a>
                    <a class="nav-link text-white" href="displaySellerCustomers.php">Customers</a>
                    <a class="nav-link text-white" href="#">Analytics</a>
                    <a class="nav-link text-white" href="displaySellerReview.php">Write A Review & Rate Us</a>
                    <a class="nav-link text-white" href="displayContactUsForSeller.php">Question In Mind <i class="fa fa-question border rounded-circle"></i>Contact Us</a>
                </div>

                <a class="nav-link text-white" href="displaySellerPromocode.php"><span class="fa fa-calendar fa-fw mr-2"></span>Promo Codes</a>
                <a class="nav-link text-white" href="displayContactUsForSeller.php"><span class="fa fa-clipboard fa-fw mr-2"></span>Contact Us</a>
                <a class="nav-link text-white" href="logout.php"><span class="fas fa-sign-out-alt fa-fw mr-2"></span>Logout</a>
            </li>
            <li class="nav-item d-sm-block d-md-none">
                <a class="nav-link text-white">Seller Id - <?php if(isset($_SESSION['user_id']))
                                                        echo $_SESSION['user_id']; ?>
                </a>
            </li>
            <li class="nav-item d-sm-block d-md-none">
                <a class="nav-link text-white">Mobile - <?php if(isset($_SESSION['mobile']))
                                                        echo $_SESSION['mobile']; ?>
                </a>
            </li>
            <li class="nav-item d-sm-block d-md-none">
                <a class="nav-link text-white">Hi,&nbsp;<?php if(isset($_SESSION['business_name']))
                                                        echo $_SESSION['business_name']; ?>
                </a>
            </li>
            <!-- Smaller devices menu END -->
        </ul>
    </div>

    <ul class="navbar-nav mr-2 d-none d-lg-inline-flex">
        <li class="nav-item">
                <a class="nav-link mr-3 text-white">Seller Id - <?php if(isset($_SESSION['user_id']))
                                                        echo $_SESSION['user_id']; ?>
                </a>
        </li>
        <li class="nav-item mr-3">
                <a class="nav-link text-white">Mobile - <?php if(isset($_SESSION['mobile']))
                                                        echo $_SESSION['mobile']; ?>
                </a>
        </li>
        <li class="nav-item">
                <a class="nav-link text-white">Hi,&nbsp;<?php if(isset($_SESSION['business_name']))
                                                        echo $_SESSION['business_name']; ?>
                </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="rightNavOptions" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../../images/sellers/<?php 
                    if(isset($_SESSION['seller_image']))
                        echo $_SESSION['seller_image']; ?>" width="30" height="30" class="rounded-circle" style="border-radius:40%;">
            </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="rightNavOptions">
            <div class="row text-center">
                <div class="col-12">
                <img src="../../images/sellers/<?php if(isset($_SESSION['seller_image']))
                    echo $_SESSION['seller_image']; ?>" width="120" height="120" class="rounded-circle" style="border-radius:40%;">
                </div>
                <div class="col-12 pt-0">
                    <button type="button" class="btn bg-transparent updateprofile">
                        <i class="fas fa-camera fa-lg"></i>
                    </button>
                </div>
            </div>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="displaySellerProfile.php"><span class="fas fa-user fa-fw mr-2"></span>Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="displaySellerChangePassword.php"><span class="fas fa-key fa-fw mr-2"></span>Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php"><span class="fas fa-sign-out-alt fa-fw mr-2"></span>Logout</a>
        </div>
        </li>
    </ul>
</nav>
<!-- NavBar END -->

<div class="row" id="body-row">             <!-- will remain unclosed in every file -->
    <div class="col-12">
        <span id="sidenav-open" class="fas fa-bars fa-2x d-none mt-3"></span>
    </div>
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-lg-block col-3">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group sticky-top sticky-offset">
            <!-- For Hide -->
            <div class="col-12 text-right text-white">
                <span class="fas fa-times fa-2x mt-2" id="sidenav-close"></span>
            </div>
            <!-- Separator with title -->
            <!--<li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>Panel Menu</small>
            </li>-->
            <!-- /END Separator -->
            <a href="displaySellerDashboard.php" class="bg-primary list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-tachometer-alt fa-fw mr-3"></span>
                    <span class="menu-collapsed">Dashboard</span>
                </div>
            </a>

            <a href="displaySellerProfile.php" class="bg-primary list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">Profile</span>
                </div>
            </a>
            <!-- Separator with title -->
            <!--<li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>OPTIONS</small>
            </li>-->
            <!-- /END Separator -->

            <!-- Menu with submenu -->
            <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-primary list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-list fa-fw mr-3"></span>
                    <span class="menu-collapsed">Product Management</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu1" class="collapse sidebar-submenu">
                <a href="displaySellerCatalogues.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Collections</span>
                </a>
                <a href="displaySellerProducts.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Products</span>
                </a>
            </div>

            <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-primary list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-list fa-fw mr-3"></span>
                    <span class="menu-collapsed">Order Management</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu2" class="collapse sidebar-submenu">
                <a href="displaySellerOrders.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Orders</span>
                </a>
             <!--   <a href="#" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Returned Orders</span>
                </a>
                <a href="#" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Cancelled Orders</span>
                </a>-->
            </div>

            <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-primary list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-cog fa-fw mr-3"></span>
                    <span class="menu-collapsed">Seller Plus</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <!-- Submenu content -->
            <div id="submenu3" class="collapse sidebar-submenu">
                <a href="displaySellerDeliveryChargeSettings.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Delivery Charge Settings</span>
                </a>
                <a href="displaySellerProductDefaultSettings.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Product Default Settings</span>
                </a>
                <a href="displaySellerProfile.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Profile Management</span>
                </a>
                <a href="displaySellerCustomers.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Customers</span>
                </a>
                <a href="#" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Analytics</span>
                </a>
                <a href="displaySellerReview.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Write A Review & Rate Us</span>
                </a>
                <a href="displayContactUsForSeller.php" class="bg-primary list-group-item list-group-item-action text-white">
                    <span class="menu-collapsed">Question In Mind <i class="fas fa-question fa-lg"></i> Contact Us</span>
                </a>
            </div>

            <a href="displaySellerPromocode.php" class="bg-primary list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-calendar fa-fw mr-3"></span>
                    <span class="menu-collapsed">Promo Codes</span>
                </div>
            </a>
            <a href="displaySellerWallet.php" class="bg-primary list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-wallet fa-fw mr-3"></span>
                    <span class="menu-collapsed">Your Wallet</span>
                </div>
            </a>
            <!-- Separator without title -->
            <!--<li class="list-group-item sidebar-separator menu-collapsed"></li>-->
            <!-- /END Separator -->
            <a href="displayContactUsForSeller.php" class="bg-primary list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-clipboard fa-fw mr-3"></span>
                    <span class="menu-collapsed">Contact Us</span>
                </div>
            </a>
            <a href="logout.php" class="bg-primary list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fas fa-sign-out-alt fa-fw mr-3"></span>
                    <span class="menu-collapsed">Logout</span>
                </div>
            </a>
        </ul>
        <!-- List Group END-->
    </div>
    <!-- sidebar-container END -->

<!-- Profile Pic Change popup -->
<div class="modal fade" id="updateprofilemodal" tabindex="-1" role="dialog" aria-labelledby="updateprofileforuser" aria-hidden="true">
  <div class="modal-dialog modal-sm w-75 mx-auto" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateprofileforuser">Update Profile Pic</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form enctype="multipart/form-data" action="" method="post" id="updateprofileform">
                <div class="row">
                    <div class="col-12">
                        <input type="file" accept="image/*" name="seller_image" id="seller_image" class="form-control border border-top-0 border-left-0 border-right-0" title="Update Profile Pic" style="overflow: hidden;">
                        <input type="hidden" name="hidden_seller_image" value="<?php if(isset($_SESSION['seller_image'])) echo $_SESSION['seller_image']; else echo "defaultpic.jpg"; ?>">
                    </div>
                    <div class="col-12 text-center mt-3">
                        <div class="form-group">
                          <input type="submit" name="update" class="btn btn-primary btn-md" id="imageuploadbutton" value="Upload" disabled>
                        </div>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Popup for information -->
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

    <!-- MAIN -->
    <div class="col py-3">

        <!-- whatever content/file used, close 2 divs and one body and html tag -->

<script>
    $("#sidenav-close").on("click",function()
    {
       $("#sidebar-container").removeClass("sidebar-expanded d-none d-lg-block col-3").addClass("d-none"); 
       $("#sidenav-open").addClass("d-inline-block");
    });

    $("#sidenav-open").on("click",function()
    {
       $("#sidebar-container").addClass("sidebar-expanded d-none d-lg-block col-3"); 
       $("#sidenav-open").removeClass("d-inline-block");
    });
</script>

<script>
    var a=0;

    $(".updateprofile").on("click",
        function(){
            $("#updateprofileform")[0].reset();
            $("#imageuploadbutton").attr("disabled",true);
            $("#updateprofilemodal").modal('show');
    });

    $("#seller_image").change(
        function()
        {
            filename=$("#seller_image").val();

            if(filename)
                $("#imageuploadbutton").attr("disabled",false);
            else
               $("#imageuploadbutton").attr("disabled",true); 
    });

    $("#updateprofileform").on("submit",
        function(event){
            event.preventDefault();
            console.log($(this).serializeArray());
            $.ajax({
                type: 'POST',
                url: 'editProfilePic.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(response)
                {   
                    if(response.status==1)
                    {
                        $('#updateprofileform')[0].reset();
                        $("#updateprofilemodal").modal('hide');
                        //alert("Profile updated successfully");
                        $("#information").html("<p class='text-success'>Profile updated successfully</p>");
                        $("#information-modal").modal("show");
                    }
                    else
                    if(response.status==0)
                    {
                        $("#updateprofilemodal").modal('hide');
                        $("#information").html("<p class='text-danger'>Unable to update profile</p>");
                        $("#information-modal").modal("show");
                    }
                }
            }); 
            //window.location.reload();
    });

//     $(document).ajaxStop(function(){
//     window.location.reload();
// });
</script>