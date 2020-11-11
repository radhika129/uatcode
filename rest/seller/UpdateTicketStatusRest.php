<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=''&&isset($_REQUEST['ticket_id']) && $_REQUEST['ticket_id']!=''&&isset($_REQUEST['status']) && $_REQUEST['status']!='')
{

	$user_id=$_REQUEST['user_id'];
	$ticket_id=$_REQUEST['ticket_id'];
	$query="update tickets set 
					status='".$_REQUEST['status']."'
					where 
						seller_id='".$user_id."' 
					and 
						ticket_id='".$ticket_id."'" ;
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
 		echo json_encode(array("updateticket"=>$temp));
 	}
 	else
 	{
 		rollback();
 		$temp=array();
		$temp['response_code']=404;
		$temp['response_desc']="Invalid Operation";
		echo json_encode(array("updateticket"=>$temp));
 	}
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updateticket"=>$temp));
}
close();
?>
