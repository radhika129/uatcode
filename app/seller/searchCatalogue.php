<?php require_once("../../config/config.php"); ?>

<?php
	if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role']==2)
	{
		$data['user_id']=$_SESSION['user_id'];

		if(isset($_GET['cataloguename']))
			$data['cataloguename']=$_GET['cataloguename'];
		else
			if(isset($_GET['cataloguestatus']))
				$data['cataloguestatus']=$_GET['cataloguestatus'];
		

		$url=DOMAIN.'/rest/seller/getCatalogueListScreenRest.php';

		$output=getRestApiResponse($url,$data);

		if(isset($output['getcatalogue']) && count($output['getcatalogue'])>2)
		{
			if(isset($output['getcatalogue']['rows']) && $output['getcatalogue']['rows']!=0)
			{
				$record="";
				$seller_to_root=SELLER_TO_ROOT;
				for($i=0;$i<$output['getcatalogue']['rows'];$i++)
				{
								$collectionurl=DOMAIN."/".$_SESSION['username']."?cid=".$output['getcatalogue'][$i]['catalogue_id'];
								$record.=<<< record
								<tr>
									<td><img src="{$seller_to_root}{$output['getcatalogue'][$i]['catalogue_image']}" class="list-image"></td>
									<td>{$output['getcatalogue'][$i]['catalogue_Name']}</td>
record;

								if($output['getcatalogue'][$i]['catalogue_status']=="Active")
								{
									$record.=<<< record
									<td><p class='text-success'>Active</p></td>
									<td>
										<form action="displaySellerCatalogues.php" method="post">
											<input type="hidden" name="cid" value="{$output['getcatalogue'][$i]['catalogue_id']}">
											<input type="hidden" name="catalogue_status" value="Inactive">
											<button type="submit" name="setcataloguestatus" class="btn btn-warning">Deactivate</button>
										</form>
									</td>
									<td>
										<form action="displaySellerCatalogues.php" method="post">
											<input type="hidden" name="cid" value="{$output['getcatalogue'][$i]['catalogue_id']}">
											<button type="submit" name="edit_catalogue_form" class="btn btn-primary">Edit</button>
										</form>
									</td>
record;
								}
								else
								if($output['getcatalogue'][$i]['catalogue_status']=="Inactive")
								{
									$record.=<<< record
									<td><p class='text-danger'>Inactive</p></td>
									<td>
										<form action="displaySellerCatalogues.php" method="post">
											<input type="hidden" name="cid" value="{$output['getcatalogue'][$i]['catalogue_id']}">
											<input type="hidden" name="catalogue_status" value="Active">
											<button type="submit" name="setcataloguestatus" class="btn btn-info">Activate</button>
										</form>
									</td>
									<td>
										<button class="btn btn-secondary" disabled>Edit</button>
									</td>
record;
								}
									
								if($output['getcatalogue'][$i]['catalogue_status']=="Active")
								{
									$record.=<<< record
									<td>
									<button catid="{$output['getcatalogue'][$i]['catalogue_id']}" catname="{$output['getcatalogue'][$i]['catalogue_Name']}" class="btn btn-primary addproduct">Add Products</button>
									</td>
									<td>
										<form action="displaySellerProducts.php" method="post">
											<input type="hidden" name="cid" value="{$output['getcatalogue'][$i]['catalogue_id']}">
											<button type="submit" name="showproductsbycid" class="btn btn-success">Show Products</button>
										</form>
									</td>
record;
								}
								else
								{
									$record.=<<< record
									<td>
									<button class="btn btn-secondary" disabled>Add Products</button>
									</td>
									<td>
									<button class="btn btn-secondary" disabled>Show Products</button>
									</td>
record;
								}
								$record.=<<< record
									<td>
										<button type="button" class="btn btn-danger enabledeletepopup" cid="{$output['getcatalogue'][$i]['catalogue_id']}"><i class="fa fa-trash"></i></button>
									</td>
record;

								if($output['getcatalogue'][$i]['catalogue_status']=="Active")
								{
									$record.=<<< record
									<td>
										<a href="https://api.whatsapp.com/send?text={$collectionurl}" target="_blank" title="Share Collection Link On Whatsapp"><i class="fab fa-whatsapp text-success fa-2x"></i></a>
									</td>
								</tr>
record;
								}
								else if($output['getcatalogue'][$i]['catalogue_status']=="Inactive")
								{
									$record.=<<< record
									<td>
										<a title="Collection is inactive" disabled><i class="fab fa-whatsapp text-secondary fa-2x"></i></a>
									</td>
								</tr>
record;
								}
					}
					$record.='<script>
		              $(".enabledeletepopup").on("click",
		                function()
		                {
		                  cid=$(this).attr("cid");
		                  $("#setcid").val(cid);
		                  $("#delete-confirmation-modal").modal("show");
		                });

		              $(".addproduct").on("click",
		                function()
		                {
		                  catid=$(this).attr("catid");
		                  catname=$(this).attr("catname");

		                  $("#addproductform")[0].reset();
		                  $("#spcid").val(catid);
		                  $("#spcname").val(catname);

		                  $("#addproductmodal").modal("show");
		                });
		              </script>';
					echo $record;
			}
		}
	}
?>