<?php require_once("../../config/config.php"); ?>

<?php
	if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2 && isset($_GET['search']))
	{
 		$sid=$_SESSION['user_id'];

		$data['sid']=$sid;
		$data['name']=$_GET['search'];

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
							if($output['promos'][$i]['discount_type'] == 'yes')
							{
								$record.=<<< record
								<td>
									<input type="checkbox" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="secondary" checked class="setstock" value="{$output['promos'][$i]['discount_type']}">
									</td>
			record;
							}
							else
							{
								$record.=<<< record
								<td>
									<input type="checkbox" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="secondary" class="setstock" value="{$output['promos'][$i]['discount_type']}">
									 </td>
			record;
							}
								$record.=<<< record

							<td>
								<form action="displaySellerPromocode.php" method="post">
									<input type="hidden" name="pid" value="{$output['promos'][$i]['id']}">
									<button type="submit" name="edit_promocode_form" class="btn btn-primary">Edit  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								</form>
							</td>
							<td>
								<form action="displaySellerPromocode.php" method="post">
									<input type="hidden" name="pid" value="{$output['promos'][$i]['id']}">
									<button type="submit" name="delete_promocode" class="btn btn-danger" onclick="return confirm('Do You Really Want To Delete This Promocode')"><i class="fa fa-trash"></i></button>
								</form>
							</td>
						</tr>
record;
				}
				echo $record;
			}
		}
	}
?>
