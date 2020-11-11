<?php

header("Content-Type:application/json");
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!="")
{	
	$catalogue_Name=$_REQUEST['catalogue_Name'];
	$catalogue_image='';
	$check_status='';
	if($_REQUEST['imagestatus']=='1')
	{
	$data=$_REQUEST['image'];
	$date=date('Ymd').rand(10000,100000);
	$catalogue_image="/images/collections/".$_REQUEST['catalogue_Name'].$_REQUEST['user_id'].$date.'.png';
	$catalogue_image1=UPLOAD_DIRECTORY.$catalogue_image;
	$check_status=imageupload($data,$catalogue_image1);
	}
	else
	{
		$catalogue_image="defaultpic.jpg";
	}
	if($check_status=="Invalid")
	{
		$catalogue_image="defaultpic.jpg";
	}
	$query=query("insert into product_catalogue (catalogue_seller_id,catalogue_Name,updatedby,catalogue_image) values('".$_REQUEST['user_id']."','".$_REQUEST['catalogue_Name']."','".$_REQUEST['user_id']."','".$catalogue_image."')");
	$result=confirm($query);
	if(!$result)
	{
		$flag = false;
	}
	if($flag)
	{
		commit();
		$temp=array();
		$temp['response_code']=200;
		$temp['response_desc']="Success";
		echo json_encode(array("catalogue"=>$temp));
	}
	else
	{
		rollback();
		$temp['response_code']=404;
		$temp['response_desc']="Invalid Operation";
		echo json_encode(array("catalogue"=>$temp));
	}
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("catalogue"=>$temp));
}
close();
?>
