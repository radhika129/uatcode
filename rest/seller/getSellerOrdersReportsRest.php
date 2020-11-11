<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id'])&&$_REQUEST['user_id']!='')
{		
	$date = date("y-m-d");
	$user_id=$_REQUEST['user_id'];
	$query="SELECT count(*) as count,date(order_date) as date FROM basket_order WHERE order_date  BETWEEN date(DATE_SUB(date(NOW()), INTERVAL 6 DAY)) AND date(NOW())  and seller_id='".$_REQUEST['user_id']."' and order_status not in('Draft') Group by DATE(order_date)";
	//echo $query;
	$query=query($query);
	confirm($query);
	
	$temp=array();	
	$date = date('Y-m-d');
	$temp[$date]=0;
	$j=1;
	while($j<7)
	{
					
		$date=$date;
		$date = strtotime($date);
		$date = strtotime("-1 day", $date);
		$date = date('Y-m-d', $date);
		$temp[$date]=0;
		$j++;
	}
	$i=0;
	while($row=fetch_array($query))
		{
				
			$temp[$row['date']]=$row['count'];
			
		}
	ksort($temp);
	$temp1=array();
	foreach ($temp as $key => $value){
		$date = strtotime($key);
		$date = date('d-M', $date);
		$temp1[$date]= $temp[$key];
		}
	$temp1['response_code']=200;
	$temp1['response_desc']="success";
 	echo json_encode(array("getdashboard"=>$temp1));
 }
		
	
	else
	{
		$temp['response_code']=400;
		$temp['response_desc']="Invalid Request";
 		echo json_encode(array("getdashboard"=>$temp));
	}
close();
?>
