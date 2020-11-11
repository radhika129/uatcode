<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='' && isset($_REQUEST['ticket_id']) && $_REQUEST['ticket_id']!='' && isset($_REQUEST['description']) && $_REQUEST['description']!='')
{
	$date=date("Y:m:d:");
	$d='';
	$user_id=$_REQUEST['user_id'];
	$ticket_id=$_REQUEST['ticket_id'];
		$query="select description
					from 
					tickets 
					where 
						seller_id='".$user_id."' and ticket_id='".$ticket_id."'";
	//echo $query;
	$query=query($query);
	confirm($query);
	$row='';
	$mobile='';
	$temp=array();
	$d='';
	while($row=fetch_array($query))
	{
	$d=$row['description'];
	$temp[]=$row;
	}
	//echo $d;
	$description = $d."\n  ".$date."\n ".$_REQUEST['description'];
	$query="update tickets set 
					description ='".$description."',
					status='4'
					where 
						seller_id='".$user_id."' 
					and 
						ticket_id='".$ticket_id."'" ;
	//echo $description;
	$query=query($query);
	//echo $query;
	confirm($query);
	
	$temp=array();
	$temp['response_code']=200;			// 405 means 'Not Allowed'
	$temp['response_desc']="success";
	echo json_encode(array("updateticket"=>$temp));
}
else
{
	$temp=array();
	$temp['response_code']=400;			// 405 means 'Not Allowed'
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updateticket"=>$temp));
}
close();
?>
