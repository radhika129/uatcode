<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=''&&isset($_REQUEST['ticket_id']) && $_REQUEST['ticket_id']!='')
{

	$user_id=$_REQUEST['user_id'];
	$ticket_id=$_REQUEST['ticket_id'];
	$query="select * 
					from 
					tickets 
					where 
						seller_id='".$user_id."' and ticket_id='".$ticket_id."'";
	$query=query($query);
	confirm($query);
	$row='';
	$mobile='';
	$temp=array();
	while($row=fetch_array($query))
	{	
		$temp[]=$row;
	}

	$temp['response_code']=200;
	$temp['response_desc']="success";
	echo json_encode(array("viewticket"=>$temp));
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("viewticket"=>$temp));
}
close();
?>
