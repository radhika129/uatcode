<?php

header("Content-Type:application/json");
include('../../config/config.php');
$flag = true;
$connection->autocommit(FALSE);
//print_r($_REQUEST);
 $output=unserialize($_REQUEST['data']);
 
 $collections=$output['collection'];
 $collections=explode("#",$collections);

 $user_id=$output['user_id'];  
 $id="";
 if($collections[0]!='' && $collections[1]!='')
 {
 	$query='insert into product_catalogue(catalogue_seller_id,catalogue_Name,creation_datetime,modification_datetime,updatedby,catalogue_status,catalogue_image) values("'.$user_id.'","'.$collections[0].'",NOW(),NOW(),"'.$user_id.'","Active","'.$collections[1].'")';
 
 	$query=query($query);
 	$result=confirm($query);
 	if(!$result)
	{
		$flag = false;
	}
 	$id=$connection->insert_id;
 
 

	 foreach($output['products'] as $key => $value)
	 {
	 	if($value!="")
	 	{
	 		if($flag==true)
	 		{
	 		$temp=explode("#",$value);   // 0 1 2
	 		
			$query='insert into product_details (
									updatedby,
									product_catalogue_id,
									product_seller_id,
									product_name,
									product_description,
									product_creation_datetime,
									product_modification_datetime,
									product_status,
									product_price,
									product_offer_price,
									product_price_currency,
									discount_type,
									discount,
									productimage	
									) values(';
			$query.='"'.$user_id.'",';
			$query.='"'.$id.'",';
			$query.='"'.$user_id.'",';
			$query.='"'.$temp[0].'",';
			$query.='"'.$temp[2].'",';
			$query.='NOW(),';
			$query.='NOW(),';
			$query.='"Active",';
			$query.='"0",';
			$query.='"0",';
			$query.='"INR",';
			$query.='"None",';
			$query.='"0",';
			$query.='"'.$temp[1].'"
			)';
			//echo $query;
			$query=query($query);
			$result=confirm($query);
			if(!$result)
			{
				$flag = false;
			}
			
	 		}
	 	}
	 }
	 if($flag)
			{
				commit();
				$temp=array();
				$temp['response_code']=200;
				$temp['response_desc']="Success";
				echo json_encode(array("createcollectionproduct"=>$temp));
			}
			else
			{
				rollback();
				$temp['response_code']=404;
				$temp['response_desc']="Invalid Results";
				echo json_encode(array("createcollectionproduct"=>$temp));
			}
}
 
close();
?>
