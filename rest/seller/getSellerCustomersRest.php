<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!='')
{		
	

	$user_id=$_REQUEST['user_id'];
	$query='';
	if(isset($_REQUEST['customer_name']) && $_REQUEST['customer_name']!='')
	{
			$query="select sum(net_amount) as amount, customer_name, customer_mobile 
								from 
						basket_order
								where seller_id = '".$user_id."' 
								and 
						customer_name = '".$_REQUEST['customer_name']."'
						group by 
						customer_name, customer_mobile
						order by id desc";
	}
	else
	{
			$query="select sum(net_amount) as amount, customer_name, customer_mobile 
								from 
						basket_order
								where seller_id = '".$user_id."' 
						group by 
						customer_name, customer_mobile
						order by id desc";
	}
	
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
 		echo json_encode(array("getsellercustomers"=>$temp));
 	}		
}
else
{
	$temp['response_code']=400;
	$temp['response_desc']="Invalid Request";
	echo json_encode(array("getsellercustomers"=>$temp));
}
close();
?>
