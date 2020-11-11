<?php

header("Content-Type:application/json");
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=""&&isset($_REQUEST['password']) && $_REQUEST['password']!="")
{	
	
	
	$query="select * from users where user_id='".$_REQUEST['user_id']."' and password='".$_REQUEST['password']."'";
	$query=query($query);
	confirm($query);
	if(mysqli_num_rows($query)!=0)
	{
		
		
		$temp=array();
		$temp['response_code']=200;			
		$temp['response_desc']="success";
		echo json_encode(array("verifypassword"=>$temp));

	}
	else
	{	
		
		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']="Password is Not Match";
		echo json_encode(array("verifypassword"=>$temp));
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("verifyverifypassword"=>$temp));
}
close();	
?>
