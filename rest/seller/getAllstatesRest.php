<?php
	header("Content-Type:application/json");
	include('../../config/config.php');
	if(isset($_REQUEST['countrycode']) && $_REQUEST['countrycode']!='')
	{
		$query = "select id,name from allstates where country_id='".$_REQUEST['countrycode']."'";
		$query = query($query);
		//confirm($query);
		$temp = array();
		$rows=mysqli_num_rows($query);
		while($row = fetch_array($query))
		{
			$temp[$row['id']]=$row['name'];
		}
		$temp['response_code']=200;
		$temp['response_desc']="success";
		$temp['rows']=$rows;
 		echo json_encode(array("getallstates"=>$temp));
	}
	else
	{
		$temp['response_code']=400;
		$temp['response_desc']="Invalid Request";
		echo json_encode(array("getallstates"=>$temp));

	}
			
close();	
?>
