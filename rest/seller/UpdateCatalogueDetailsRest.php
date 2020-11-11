<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['catalogue_id']) && $_REQUEST['catalogue_id']!="" && isset($_REQUEST['user_id']) && $_REQUEST['user_id']!="")
{
		$check_status='';
		$catalogue_image='';
		if($_REQUEST['imagestatus']=='1')
		{
			$data=$_REQUEST['image'];
			$catalogue_image=$_REQUEST['image_name'];
			if($catalogue_image=='defaultpic.jpg'||$catalogue_image=='defaultpic.png'||strpos($catalogue_image,'/images/collection_library/'))
			{
				$date=date('Ymd').rand(10000,100000);
				$catalogue_image="/images/collections/".$_REQUEST['catalogue_Name'].$_REQUEST['user_id'].$date.'.png';
			}
			$catalogue_image1=UPLOAD_DIRECTORY.$catalogue_image;
			$check_status=imageupload($data,$catalogue_image1);
		}
		else
		{
			$catalogue_image=$_REQUEST['image_name'];
		}
		if($check_status=="Invalid")
		{
		$catalogue_image="defaultpic.jpg";
		}
	$query="UPDATE 
			product_catalogue 
				SET 
			catalogue_Name='".$_REQUEST['catalogue_Name']."',
			catalogue_image='".$catalogue_image."',
			modification_datetime=NOW() 
				where 
			catalogue_id='".$_REQUEST['catalogue_id']."'  
				and 
			catalogue_seller_id='".$_REQUEST['user_id']."'";
	$query=query($query);
	$result=confirm($query);
	if(!$result)
	{
		$flag=false;
	}
	if($flag)
	{
		commit();
		$temp=array();
		$temp['response_code']=200;
		$temp['response_desc']="Success";
		echo json_encode(array("updatecatalogue"=>$temp));
	}
	else
	{
		rollaback();
		$temp=array();
		$temp['response_code']=404;			
		$temp['response_desc']="Invalid Operation";
		echo json_encode(array("updatecatalogue"=>$temp));
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;			
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatecatalogue"=>$temp));
}
close();
?>
