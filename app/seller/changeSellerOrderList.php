<?php require_once("../../config/config.php"); ?>

<?php
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
{
	if(isset($_GET['start']) && isset($_GET['end']))
	{
    $data['user_id']=$_SESSION['user_id'];
    $data['start']=$_GET['start'];
    $data['end']=$_GET['end'];

    $url=DOMAIN.'/rest/seller/getSellerOrderdetailsRest.php';

    $output=getRestApiResponse($url,$data);

    if(isset($output['getorders']) && count($output['getorders'])>2)
    {
      if(isset($output['getorders']['rows']) && $output['getorders']['rows']!=0)
      {
        $record="";

        for($i=0;$i<$output['getorders']['rows'];$i++)
        {
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
        }
        echo $record;
      }
    }
  }
}
?>