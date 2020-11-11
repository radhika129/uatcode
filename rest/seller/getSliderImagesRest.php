<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['application']) && $_REQUEST['application']!=''&&isset($_REQUEST['purpose']) && $_REQUEST['purpose']!=''&&isset($_REQUEST['placeholder']) && $_REQUEST['placeholder']!='')
{		

			$query="select image_name 
								from 
						slider
								where application = '".$_REQUEST['application']."' 
								and 
						purpose = '".$_REQUEST['purpose']."'
								and 
						placeholder = '".$_REQUEST['placeholder']."'";
						
	
	$query=query($query);
	confirm($query);
	$rows=mysqli_num_rows($query);
	if($rows!=0)
	{
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp[]=$row;
		}
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=$rows;
 		echo json_encode(array("getsliderimages"=>$temp));
 	}		
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getsliderimages"=>$temp));
}
close();
?>
