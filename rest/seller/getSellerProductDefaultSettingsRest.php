<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{	

		$query="select * from product_default_settings		
						where  
						seller_id='".$_REQUEST['user_id']."'";
		$query=query($query);
		confirm($query);
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp[]=$row;
		}
		$temp['response_code']=200;
		$temp['response_desc']="Success";
 		echo json_encode(array("getproductdefault"=>$temp));
}
else
{
	$temp=array();
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getproductdefault"=>$temp));
}
close();	
?>
