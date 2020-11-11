<?php

header("Content-Type:application/json");
include('../../config/config.php');

if(isset($_REQUEST['username']) && $_REQUEST['username']!="")
{	
	
	
	$query="select * from users where username='".$_REQUEST['username']."'";
	$query=query($query);
	confirm($query);
	if(mysqli_num_rows($query)==0)
	{
		

		$temp=array();
		$temp['response_code']=200;			
		$temp['response_desc']="success";
		echo json_encode(array("verifyusername"=>$temp));

	}
	else
	{	
		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']="Alreay User Name Exists";
		echo json_encode(array("verifyusername"=>$temp));
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("verifyusername"=>$temp));
}
close();	
?>
