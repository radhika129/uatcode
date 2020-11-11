<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='')
{
	$user_id=$_REQUEST['user_id'];
	$start=0;
	$end=10;
	if(isset($_REQUEST['start']) &&$_REQUEST['start']!='')
	{
		$start=$_REQUEST['start'];
	}
	if(isset($_REQUEST['end']) &&$_REQUEST['end']!='')
	{
		$end=$_REQUEST['end'];
	}
	if(isset($_REQUEST['ticket_id'])&&$_REQUEST['ticket_id']!='')
	{
		$query="select * 
						from 
						tickets 
						where 
							seller_id='".$user_id."' and ticket_id='".$_REQUEST['ticket_id']."'";
	}
	else
	{
		$query="select * 
						from 
						tickets 
						where 
							seller_id='".$user_id."' order by ticket_id desc limit ".$start.",".$end."";
	}
	$query=query($query);
	confirm($query);
	$row='';
	$mobile='';
	$temp=array();
	while($row=fetch_array($query))
	{	
	$temp[]=$row;
	}

						
	
	$temp['rows']=mysqli_num_rows($query);
	$temp['response_code']=200;			
	$temp['response_desc']="success";
	echo json_encode(array("ticketlist"=>$temp));
}
else
{
	$temp=array();
	$temp['response_code']=400;			
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("ticketlist"=>$temp));
}
close();
?>
