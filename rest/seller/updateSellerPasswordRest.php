<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	
	if(isset($_REQUEST['cur_password'])&&$_REQUEST['cur_password']!=''&&isset($_REQUEST['new_password'])&&$_REQUEST['new_password']!='')
	{
		$uid=$_REQUEST['user_id'];
		$query="select password from users where user_id='".$uid."'";
		$query=query($query);
		confirm($query);
		$password='';
		while($row=fetch_array($query))
		{
			$password=$row['password'];
		}
		if($password==$_REQUEST['cur_password'])
		{
		
			$query="update users set 
					password='".$_REQUEST['new_password']."',
					old_password='".$_REQUEST['cur_password']."',
					updated_datetime=NOW()
						where 
					user_id='".$uid."'";
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
		 		echo json_encode(array("updatepassword"=>$temp));
		 	}
		 	else
		 	{
		 		rollback();
		 		$temp=array();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Operation";
				echo json_encode(array("updatepassword"=>$temp));
		 	}
		}
		else
		{
			$temp=array();
			$temp['response_code']=405;			// 405 means Not Allowed
			$temp['response_desc']="Not Allowed";
			echo json_encode(array("updatepassword"=>$temp));
		}
	}
	else
		{
			
			$temp=array();
			$temp['response_code']=400;
			$temp['response_desc']="Invalid Request";
			echo json_encode(array("updatepassword"=>$temp));
		}	
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("updatepassword"=>$temp));
}
close();
?>
