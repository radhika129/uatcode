<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{		
	if(isset($_REQUEST['start']))
		$start=$_REQUEST['start'];

	if(isset($_REQUEST['end']))
		$end=$_REQUEST['end'];

	$user_id=$_REQUEST['user_id'];
	
	$name="";
	$cid="";
	$pid="";

	if(isset($_REQUEST['productname']))
	$name=$_REQUEST['productname'];

	if(isset($_REQUEST['catalogueid']))
		$cid=$_REQUEST['catalogueid'];
	if(isset($_REQUEST['productid']))
		$pid=$_REQUEST['productid'];

	$query='';

	if(isset($name) && $name!="" && $cid=='')
	{
		$query=query("SELECT * FROM product_details,product_catalogue where product_seller_id='".$user_id."' and product_name like '%".$name."%' and product_details.product_catalogue_id=product_catalogue.catalogue_id order by product_id desc");
		//$query=query("SELECT * FROM product_details where product_seller_id='".$user_id."' and product_name like '%".$name."%' order by product_id  desc limit ".$start.",".$end);
	}
	else if(isset($cid)  && $cid!="" && $name=="")
	{
		$query=query("SELECT * FROM product_details,product_catalogue where product_seller_id='".$user_id."' and product_details.product_catalogue_id=product_catalogue.catalogue_id and product_catalogue_id = ".$cid);
		//$query=query("SELECT * FROM product_details where product_seller_id='".$user_id."' and product_id = ".$pid);
	}
	else if(isset($pid)  && $pid!="" && $name=="")
	{
		$query=query("SELECT * FROM product_details,product_catalogue where product_seller_id='".$user_id."' and product_details.product_catalogue_id=product_catalogue.catalogue_id and product_id = ".$pid);
		
		//$query=query("SELECT * FROM product_details where product_seller_id='".$user_id."' and product_id = ".$pid);
	}
	else if(isset($name) && $name!="" && $cid!="")
	{
		$query=query("SELECT * FROM product_details,product_catalogue where product_seller_id='".$user_id."' and product_catalogue_id =".$cid." and product_name like '%".$name."%' and product_details.product_catalogue_id=product_catalogue.catalogue_id order by product_id  desc limit ".$start.",".$end);
		//$query=query("SELECT * FROM product_details where product_seller_id='".$user_id."' and product_id =".$pid." and product_name like '%".$name."%' order by product_id  desc limit ".$start.",".$end);
	}
	else if(isset($_REQUEST['catalogueid']) && $_REQUEST['catalogueid']!="" && $name="")
	{
		$query=query("SELECT * FROM product_details,product_catalogue where product_seller_id='".$user_id."' and product_catalogue_id='".$_REQUEST['catalogueid']."' and product_details.product_catalogue_id=product_catalogue.catalogue_id order by product_id  desc limit ".$start.",".$end);
		//$query=query("SELECT * FROM product_details where product_seller_id='".$user_id."' and product_catalogue_id=".$_REQUEST['product_catalogue_id']." order by product_id  desc limit ".$start.",".$end);
	}
	else 
	{
		$query=query("SELECT * FROM product_details,product_catalogue where product_seller_id='".$user_id."' and product_details.product_catalogue_id=product_catalogue.catalogue_id order by product_id  desc limit ".$start.",".$end);
		//$query=query("SELECT * FROM product_details where product_seller_id='".$user_id."' order by product_id desc limit ".$start.",".$end);
		
	}
		
	confirm($query);
	$rows=mysqli_num_rows($query);
	
	if($rows!=0)	
	{
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp[]=$row;
		}
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=$rows;
		
 		echo json_encode(array("getproducts"=>$temp));
 	}	
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getproducts"=>$temp));
}
close();
?>
