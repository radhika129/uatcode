<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='')
{

	$user_id=$_REQUEST['user_id'];
	$gst_number=$_REQUEST['gst_number'];
	$check_status='';
	$gstimage='';
	if($_REQUEST['imagestatus']=='1')
	{
			$gst=$_REQUEST['gst_certificate_image'];
			$date=date('Ymd').rand(10000,100000);
			$gstimage=$_REQUEST['image_name'];
			if($gstimage=='defaultpic.jpg'||$gstimage=='defaultpic.png')
			{
				$gstimage="/images/gst/".'gst'.$date.$user_id.'.png';
			}
			$gstimage1=UPLOAD_DIRECTORY.$gstimage;
			$check_status=imageupload($gst,$gstimage1);
	}
	else
	{
		$gstimage=$_REQUEST['image_name'];
	}
	if($check_status=="Invalid")
	{
		$gstimage="defaultpic.png";
	}
	$query="update seller_details set 
					seller_gst = '".$gst_number."',
					gst_certificate_image = '".$gstimage."',
					gst_verified = 'No'
					where 
						seller_id='".$user_id."'";
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
	 		echo json_encode(array("updategst"=>$temp));

		}
		else
		{
			rollback();
			$temp=array();
			$temp['response_code']=404;
			$temp['response_desc']="Invalid Operation";
			echo json_encode(array("updategst"=>$temp));
		}
	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updategst"=>$temp));
}
close();
?>
