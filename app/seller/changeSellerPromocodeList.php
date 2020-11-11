<?php require_once("../../config/config.php"); ?>

<?php
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
{
	if(isset($_GET['start']) && isset($_GET['end']))
	{
    $data['sid']=$_SESSION['user_id'];
    $data['start']=$_GET['start'];
    $data['end']=$_GET['end'];

    $url=DOMAIN.'/rest/seller/getSellerPromosRest.php';

    $output=getRestApiResponse($url,$data);

    if(isset($output['promos']) && count($output['promos'])>2)
    {
      if(isset($output['promos']['rows']) && $output['promos']['rows']!=0)
      {
        $record="";
        for($i=0;$i<$output['promos']['rows'];$i++)
        {
          $current=date("Y-m-d H:i:s");
          $status="";
          if(new DateTime($output['promos'][$i]['valid_till']) >= new DateTime($current))
            $status="<p class='text-success'>Active</p>";
          else
            $status="<p class='text-danger'>Expired</p>";

          $record.=<<< record
          <tr>
            <td>{$output['promos'][$i]['promo_code']}</td>
            <td>{$output['promos'][$i]['valid_till']}</td>
            <td>{$output['promos'][$i]['catalogue_id']}</td>
            <td>{$output['promos'][$i]['product_id']}</td>
            <td>{$status}</td>
            <td>
              <form action="displaySellerPromocode.php" method="post">
                <input type="hidden" name="pid" value="{$output['promos'][$i]['id']}">
                <button type="submit" name="edit_promocode_form" class="btn btn-primary">Edit</a>
              </form>
            </td>
            <td>
              <form action="displaySellerPromocode.php" method="post">
                <input type="hidden" name="pid" value="{$output['promos'][$i]['id']}">
                <button type="submit" name="delete_promocode" class="btn btn-danger" onclick="return confirm('Do You Really Want To Delete This Promocode')">Delete</a>
              </form>
            </td>
          </tr>
record;
        }
        echo $record;
      }
    }
  }
}
?>