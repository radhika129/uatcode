<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');
$query='';
if(isset($_REQUEST['collection_id'])&&$_REQUEST['collection_id'])
{
	
	$query="select * FROM product_library where collection_id='".$_REQUEST['collection_id']."'";
}
else
{
	$query="select * FROM product_library";

}	

	$query=query($query);
	confirm($query);
	$rows=mysqli_num_rows($query);
	
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp[]=$row;
		}
		//print_r($temp);
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=$rows;
 		echo json_encode(array("getcollections"=>$temp));
 close();	
?>
