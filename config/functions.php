<?php
// setting default timezone
date_default_timezone_set("Asia/Kolkata");

// helper functions

// for redirection
function redirect($location)
{
	header("location:$location");
} 

// for query execution
function query($sql)
{
	global $connection;
	return $connection->query($sql);
}

// for error display and terminate further execution
//function confirm($result)
//{
	//global $connection;
	//if(!$result)
	//{
		//die("Query Failed".mysqli_error($connection));
	//}
//}

function confirm($query)
{
	global $connection;
	if(!$query)
	{
		return false;
	}
	return true;
}

function commit()
{
	global $connection;
	$connection->commit();
}
function rollback()
{
	global $connection;
	$connection->rollback();
}
function close()
{
	global $connection;
	$connection->close();
}
// prevent from sql injections
function escape_string($string)
{
	global $connection;
	$string=htmlentities($string);
	return $string;
}

// return a row from result set
function fetch_array($result)
{
	return mysqli_fetch_assoc($result);
}

function setmessage($message)
{
	if(!empty($message))
		$_SESSION['message']=$message;
}

function displaymessage()
{
	if(isset($_SESSION['message']))
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

function image_path_profile($path)
{
	return "..".DS."..".DS."images".DS."seller_profile".DS.$path;
}

function image_path_logo($path)
{
	return "..".DS."..".DS."images".DS."store_logo".DS.$path;
}

function getCountries()
{
// 	$query=query("select * from allcountry");
// 	confirm($query);

// 	$countires="";
// 	while($row=fetch_array($query))
// 	{
// 		$countires.=<<< country
// 		<option value="{$row['id']}">{$row['nicename']}</option>
// country;
// 	}
// 	echo $countires;
	echo "<option value='101'>India</option>";
}

function getStates($sid)
{
	$query=query("select * from allstates where country_id='101'");
	confirm($query);

	$states="";

  if($sid!="")
  {
  	while($row=fetch_array($query))
  	{
      if($row['id']==$sid)
      {
        $states.=<<< state
        <option value="{$row['id']}" selected>{$row['name']}</option>
state;
      }
      else
      {
        $states.=<<< state
        <option value="{$row['id']}">{$row['name']}</option>
state;
      }
  	}
  }
  else
  {
    $states.=<<< state
    <option value="">--Select State--</option>
state;
    
    while($row=fetch_array($query))
    {
      $states.=<<< state
      <option value="{$row['id']}">{$row['name']}</option>
state;
    }
  }
	echo $states;
}

// function states()
// {
// 	$q_s=query("select * from allstates where country_id='101'");
// 	confirm($q_s);

// 	$s="";
// 	while($r_s=fetch_array($q_s))
// 	{
// 		$s.=<<< s
// 		<option value="{$r_s['name']}">{$r_s['name']}</option>
// s;
// 	}
// 	echo $s;
// }

function admin_deactive_seller()
{
	if(isset($_POST['uid']))
	{
		$query=query("update users set status='0' where id='".$_POST['uid']."' and role_id='v'");
		confirm($query);
		echo '<script>alert("Seller Deactivated Successfully")</script>';
	}
}

function getRestApiResponse($url,$data)
{
	$defaults = array(
	CURLOPT_URL => $url,
	CURLOPT_POST => true,
	CURLOPT_POSTFIELDS => $data,
	);

	$client=curl_init();
	curl_setopt_array($client,$defaults);
	curl_setopt($client,CURLOPT_RETURNTRANSFER,true);

	$output=curl_exec($client);
	curl_close($client);			// To close curl.

	return json_decode($output,JSON_FORCE_OBJECT);
}

function setupPagination($sql)
{
	$query=query($sql);
    confirm($query);

    if(mysqli_num_rows($query)!=0)
    {
        $p=intval(mysqli_num_rows($query));

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
        echo "<div class='row'>
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
}

function getCatalogues($cid)
{
  $query=query("select * from product_catalogue where catalogue_seller_id='".$_SESSION['user_id']."'");
  confirm($query);

  $cats="";

  if($cid!="")
  {
    while($row=fetch_array($query))
    {
      if($row['catalogue_id']==$cid)
      {
        $cats.=<<< cat
        <option value="{$row['catalogue_id']}" selected>{$row['catalogue_Name']}</option>
cat;
      }
      else
      {
        $cats.=<<< cat
        <option value="{$row['catalogue_id']}">{$row['catalogue_Name']}</option>
cat;
      }
    }
  }
  else
  {
    while($row=fetch_array($query))
    {
      $cats.=<<< cat
      <option value="{$row['catalogue_id']}">{$row['catalogue_Name']}</option>
cat;
    }
  }
  echo $cats;
}

function displayTransactionsForWalletScreen($output)
{
  $tabdata="";
  for($i=0;$i<$output['getwalletbalance']['rows'];$i++)
  {
    $price="";

    if($output['getwalletbalance'][$i]['dr_cr_Indicator']=="C")
      $price="<p class='text-success'><i class='fas fa-plus'></i>&nbsp;<i class='fas fa-rupee-sign'></i>&nbsp;<b>".$output['getwalletbalance'][$i]['amount']."</b></p>";
    else
    if($output['getwalletbalance'][$i]['dr_cr_Indicator']=="D")
      $price="<p class='text-danger'><i class='fas fa-minus'></i>&nbsp;<i class='fas fa-rupee-sign'></i>&nbsp;<b>".$output['getwalletbalance'][$i]['amount']."</b></p>";

    $tabdata.=<<< tabdata
    <div class="row mt-3">
      <div class="col-12">
        <b>Date:</b>&nbsp;{$output['getwalletbalance'][$i]['date']}
      </div>
      <div class="col-12 mt-3">
        <div class="row">
          <div class="col-6">
            {$output['getwalletbalance'][$i]['time']} / {$output['getwalletbalance'][$i]['movement_description']} / {$output['getwalletbalance'][$i]['customer_name']}
          </div>
          <div class="col-6">
            <div class="row">
              <div class="col-6 text-right">
                <span>{$price}</span>
              </div>
              <div class="col-6">
                <form action="" method="post">
                  <input type="hidden" name="mid" value="{$output['getwalletbalance'][$i]['cash_movement_id']}">
                  <input type="submit" name="seetransactiondetails" class="btn btn-primary" value="Details">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
tabdata;
  }
  echo $tabdata;
}

function displayOrdersInDashboard($output)
{
    echo '
    <div class="row mt-4">
      <div class="col-12 table-responsive">
        <table class="table table-hover table-bordered text-center w-auto table-sm">
          <thead>
            <tr>
              <th>Order Id</th>
              <th>Order Type</th>
              <th>Customer Name</th>
              <th>No. Of Items</th>
              <th>Cart Total</th>
              <th>DateTime</th>
              <th>Status</th>
              <th colspan="3">Action</th>
            </tr>
          </thead>
          <tbody id="order_body">';

      for($i=0;$i<10 && $i<$output['getorders']['rows'];$i++)
      {
        $record="";
        $record.=<<< record
        <tr>
        <td>{$output['getorders'][$i]['basket_order_id']}</td>
        <td>{$output['getorders'][$i]['order_type']}</td>
        <td>{$output['getorders'][$i]['customer_name']}</td>
        <td>{$output['getorders'][$i]['total_items']}</td>
        <td>{$output['getorders'][$i]['net_amount']}</td>
        <td>{$output['getorders'][$i]['order_date']}</td>
record;

        if($output['getorders'][$i]['order_status']=="Pending")
        {
          $record.=<<< record
          <td><p class="text text-warning">{$output['getorders'][$i]['order_status']}</p></td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="orderdate" value="{$output['getorders'][$i]['order_date']}">
              <button type="submit" name="orderitems" class="btn btn-primary">View</button>
            </form>
          </td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="order_status" value="Accepted">
              <button type="submit" name="setorderstatus" class="btn btn-primary" onclick="return confirm('Do You Really Want To Accept This Order')">Accept</button>
            </form>
          </td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="order_status" value="Declined">
              <button type="submit" name="setorderstatus" class="btn btn-danger" onclick="return confirm('Do You Really Want To Reject This Order')">Decline</button>
            </form>
          </td>
record;
        }
        else if($output['getorders'][$i]['order_status']=="Accepted")
        {
          $record.=<<< record
          <td><p class="text text-success">{$output['getorders'][$i]['order_status']}</p></td>
          <td>
          <form action="displaySellerOrders.php" method="post">
            <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
            <input type="hidden" name="orderdate" value="{$output['getorders'][$i]['order_date']}">
            <button type="submit" name="orderitems" class="btn btn-primary">View</button>
          </form>
          </td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="order_status" value="Shipped">
              <button type="submit" name="setorderstatus" class="btn btn-info">Ship</button>
            </form>
          </td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="order_status" value="Declined">
              <button type="submit" name="setorderstatus" class="btn btn-danger" onclick="return confirm('Do You Really Want To Reject This Order')">Decline</button>
            </form>
          </td>
record;
        }
        else if($output['getorders'][$i]['order_status']=="Declined")
        {
          $record.=<<< record
          <td><p class="text text-danger">{$output['getorders'][$i]['order_status']}</p></td>
          <td>
          <form action="displaySellerOrders.php" method="post">
            <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
            <input type="hidden" name="orderdate" value="{$output['getorders'][$i]['order_date']}">
            <button type="submit" name="orderitems" class="btn btn-primary">View</button>
          </form>
          </td>
          <td></td><td></td>
record;
        }
        else if($output['getorders'][$i]['order_status']=="Shipped")
        {
          $record.=<<< record
          <td><p class="text text-info">{$output['getorders'][$i]['order_status']}</p></td>
          <td>
          <form action="displaySellerOrders.php" method="post">
            <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
            <input type="hidden" name="orderdate" value="{$output['getorders'][$i]['order_date']}">
            <button type="submit" name="orderitems" class="btn btn-primary">View</button>
          </form>
          </td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="order_status" value="Delivered">
              <button type="submit" name="setorderstatus" class="btn btn-success">Delivered</button>
            </form>
          </td>
          <td>
            <form action="displaySellerOrders.php" method="post">
              <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
              <input type="hidden" name="order_status" value="Returned">
              <button type="submit" name="setorderstatus" class="btn btn-danger">Returned</button>
            </form>
          </td>
record;
        }
        else if($output['getorders'][$i]['order_status']=="Delivered")
        {
          $record.=<<< record
          <td><p class="text text-success">{$output['getorders'][$i]['order_status']}</p></td>
          <td>
          <form action="displaySellerOrders.php" method="post">
            <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
            <input type="hidden" name="orderdate" value="{$output['getorders'][$i]['order_date']}">
            <button type="submit" name="orderitems" class="btn btn-primary">View</button>
          </form>
          </td>
          <td></td><td></td>
record;
        }
        else
        {
          $record.=<<< record
          <td><p class="text text-danger">{$output['getorders'][$i]['order_status']}</p></td>
          <td>
          <form action="displaySellerOrders.php" method="post">
            <input type="hidden" name="oid" value="{$output['getorders'][$i]['basket_order_id']}">
            <input type="hidden" name="orderdate" value="{$output['getorders'][$i]['order_date']}">
            <button type="submit" name="orderitems" class="btn btn-primary">View</button>
          </form>
          </td>
          <td></td>
record;
        }

        $record.=<<< record
      </tr>
record;
        echo $record;
      }

    echo '
          </tbody>
        </table>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12 text-center">
        <a href="displaySellerOrders.php?orderstatus='.$output["getorders"][0]["order_status"].'" class="btn btn-primary mb-2">Show All</a>
      </div>
    </div>';
}

function readDataFromFile($path)
{
  $file=fopen($path,"r") or die("Unable to open file!");
  
  while(!feof($file)) 
  {
    echo fgets($file)."<br>";
  }
  fclose($file);
}

function imageupload($data,$imgname)
{
  $bin = base64_decode($data);

  // Load GD resource from binary data
  $im = imageCreateFromString($bin);

  // Make sure that the GD library was able to load the image
  // This is important, because you should not miss corrupted or unsupported images
  if (!$im) 
  {
    return "Invalid";
  }

  // Specify the location where you want to save the image
  $img_file = $imgname;
  $width = imagesx($im);
  $height = imagesy($im);
  $percent = 0.5;
  $newwidth = $width * $percent;
  $newheight = $height * $percent;

  $thumb = imagecreatetruecolor($newwidth, $newheight);

  // Resize
  imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


  imagejpeg($thumb, $img_file, 60);
  return "Success";
}

?>