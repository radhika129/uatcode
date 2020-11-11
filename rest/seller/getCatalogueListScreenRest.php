<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!="")
{		
	if(isset($_REQUEST['start']))
		$start=$_REQUEST['start'];

	if(isset($_REQUEST['end']))
		$end=$_REQUEST['end'];

	$user_id=$_REQUEST['user_id'];
	
	$name="";
	$status="";

	if(isset($_REQUEST['cataloguename']))
		$name=$_REQUEST['cataloguename'];

	if(isset($_REQUEST['cataloguestatus']))
		$status=$_REQUEST['cataloguestatus'];

	$query="";

	if(isset($name) && $name!="")
	{
		$query=query("SELECT * FROM product_catalogue where catalogue_seller_id='".$user_id."' and catalogue_Name like '%".$name."%' order by catalogue_id desc");
	}
	else if(isset($_REQUEST['all']) && $_REQUEST['all']=="ALL")
	{
		$query=query("SELECT * FROM product_catalogue where catalogue_seller_id='".$user_id."' order by catalogue_id desc");
	}
	else if(isset($_REQUEST['catalogueid']) && $_REQUEST['catalogueid']!='')
	{
		$query=query("SELECT * FROM product_catalogue where catalogue_seller_id='".$user_id."' catalogue_id='".$catalogueid."' order by catalogue_id desc");
	}
	else if(isset($status) && $status!="")
	{
		$query=query("SELECT * FROM product_catalogue where catalogue_seller_id='".$user_id."' and catalogue_status='".$status."' order by catalogue_id desc");
	}
	else
	{
		$query=query("SELECT * FROM product_catalogue where catalogue_seller_id='".$user_id."' order by catalogue_id desc limit ".$start.",".$end);
	}
		
	confirm($query);
	$rows=mysqli_num_rows($query);

	if($rows!=0)	// Valid Request, Data Found.
	{
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp[]=$row;
		}
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=$rows;
 		echo json_encode(array("getcatalogue"=>$temp));
 	}
	else
	{
		$temp['response_code']=404;
		$temp['response_desc']="No Results Found";
 		echo json_encode(array("getcatalogue"=>$temp));
	}
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getcatalogue"=>$temp));
}
close();
?>
