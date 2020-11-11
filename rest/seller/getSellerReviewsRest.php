<?php

header("Content-Type:application/json");	// setting content as we will convert data in JSON type.
include('../../config/config.php');

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'])
	{
		$query="select rating,
					count(rating) 
						as 
					count from 
						reviews 					
					group by rating";
		$query=query($query);
		confirm($query);
		$total=0;
		$sum=0;
		while($row=fetch_array($query))
		{
			$total+=$row['rating']*$row['count'];
			$sum+=$row['count'];
		}
		$query="select username,
						rating,
						review_title,
						review 
							from 
						users,
						reviews 					
							where  
						users.user_id=reviews.seller_id
							and
						reviews.seller_id='".$_REQUEST['user_id']."'"
							;
		$query=query($query);
		confirm($query);
		$temp=array();
		while($row=fetch_array($query))
		{
			$temp['username']=$row['username'];
			$temp['rating']=$row['rating'];
			$temp['review_title']=$row['review_title'];
			$temp['review']=$row['review'];
		}
		$query="select username,
						rating,
						review_title,
						review,
						DATEDIFF( CURRENT_TIMESTAMP,creation_date_time)  AS day 
							from 
						users,
						reviews 					
							where  
						users.user_id=reviews.seller_id order by creation_date_time desc";
		$query=query($query);
		confirm($query);
		while($row=fetch_array($query))
		{
			if($row['day']==0)
			{
				$row['day']='Today';
			}
			else if($row['day']==1)
			{
				$row['day']='Yesterday';
			}
			else
			{
				$row['day']=$row['day']." days ago";
			}
			$temp[]=$row;
		}
		$rating = round($total/$sum);
		$temp['total_rating']=$rating;
		$temp['rows']=mysqli_num_rows($query);
		$temp['response_code']=200;
		$temp['response_desc']="Success";
		
		//print_r($temp);
 		echo json_encode(array("getreviews"=>$temp));
	}
else
	{
		$temp=array();
		$temp['response_code']=400;
		$temp['response_desc']="Fail";
		echo json_encode(array("login"=>$temp));
	}

close();
?>
