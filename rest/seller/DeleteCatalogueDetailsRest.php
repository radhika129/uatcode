<?php

header("Content-Type:application/json");
include('../../config/config.php');
$connection->autocommit(FALSE);
$flag = true;
if(isset($_REQUEST['catalogue_id']) && $_REQUEST['catalogue_id']!="" &&$_REQUEST['confirm']!='ok')
{							
	$query="select * from  product_details where product_catalogue_id='".$_REQUEST['catalogue_id']."'";
	$query=query($query);
	confirm($query);
	$rows=mysqli_num_rows($query);
	
	if($rows==0)
	{
		$query="select order_status from  orders,basket_order where catalogue_id='".$_REQUEST['catalogue_id']."' and order_id=basket_order_id";
		$query=query($query);
		$result=confirm($query);
		if(!$result)
		{
			$flag=false;
		}
		$rows=mysqli_num_rows($query);
		//print_r($rows);
		if($rows!=0)
		{
			$temp=array();
			$temp['response_code']=405;			// 405 means 'Not Allowed'
			$temp['response_desc']="Deletion is not allowed please deactivate the Catalogue.";
			$temp['rows']=$rows;
			echo json_encode(array("deletecatalogue"=>$temp));
		}
		if($rows==0)
		{
		
			$query="delete from product_catalogue where catalogue_id='".$_REQUEST['catalogue_id']."'";
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
				echo json_encode(array("deletecatalogue"=>$temp));
				close();
				exit();
			}
			else
			{
				rollback();
				$temp=array();
				$temp['response_code']=404;			
				$temp['response_desc']="Invalid Operation";
				echo json_encode(array("deletecatalogue"=>$temp));
				close();
				exit();

			}
		}
	}

		
	
	if($rows>0)
	{
		$temp=array();
		$temp['response_code']=405;			// 405 means 'Not Allowed'
		$temp['response_desc']="Deletion is not allowed because prodcts are available in this collection.Still you need to delete please click on confirm ?";
		echo json_encode(array("deletecatalogue"=>$temp));
		close();
		exit();
	}
}
else
{
	if(isset($_REQUEST['catalogue_id']) && $_REQUEST['catalogue_id']!='' && isset($_REQUEST['confirm'])&&$_REQUEST['confirm']=='ok')
	{					
		$query="select order_status from  orders,basket_order where catalogue_id='".$_REQUEST['catalogue_id']."'  and order_id=basket_order_id";
		//echo $query;
		$query=query($query);
		//confirm($query);
		$rows=mysqli_num_rows($query);
		//print_r($rows);
		if($rows!=0)
		{
			$temp=array();
			$temp['response_code']=405;			// 405 means 'Not Allowed'
			$temp['response_desc']="Deletion is not allowed please deactivate the Catalogue.";
			$temp['rows']=$rows;
			echo json_encode(array("deletecatalogue"=>$temp));
			close();
			exit();
		}
		else
		{
			$query="delete from product_details where product_catalogue_id='".$_REQUEST['catalogue_id']."'";
			$query=query($query);
			$result=confirm($query);
			if(!$result)
			{
				$flag=false;
			}
			$query="delete from product_catalogue where catalogue_id='".$_REQUEST['catalogue_id']."'";
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
				echo json_encode(array("deletecatalogue"=>$temp));
				close();
				exit();
			}
			else
			{
				rollback();
				$temp=array();
				$temp['response_code']=404;			
				$temp['response_desc']="Invalid Operation";
				echo json_encode(array("deletecatalogue"=>$temp));
				close();
				exit();
			}
			
		}
	}
	else
	{
		$temp=array();
		$temp['response_code']=400;			
		$temp['response_desc']="Invalid Request";
		echo json_encode(array("deletecatalogue"=>$temp));
		close();
		exit();
	}
}

?>
