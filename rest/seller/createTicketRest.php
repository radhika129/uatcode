<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=''&&isset($_REQUEST['description']) && $_REQUEST['description']!=''&&isset($_REQUEST['subject']) && $_REQUEST['subject']!='')
{
	$user_id=$_REQUEST['user_id'];
	$query="select mobile from users where user_id='".$user_id."'";
	$query=query($query);
	confirm($query);
	$row=fetch_array($query);
	
	$mobile=$row['mobile'];
	

	$query='insert into tickets(
							seller_id,
							mobile,
							subject,
							description,
							status,
							created_date
						)
						values
						(';
							$query.='"'.$user_id.'",';
							$query.='"'.$mobile.'",';
							$query.='"'.$_REQUEST['subject'].'",';
							$query.='"'.$_REQUEST['description'].'",';
							$query.='"1",';
							$query.='NOW()
						)';
						
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
		$temp['response_desc']="success";
		echo json_encode(array("createticket"=>$temp));
	}
	else
	{
		rollback();
		$temp=array();
		$temp['response_code']=404;			
		$temp['response_desc']="Invalid Operation";
		echo json_encode(array("createticket"=>$temp));
	}
}
else
{
	$temp=array();
	$temp['response_code']=400;			
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("createticket"=>$temp));
}
close();
?>
