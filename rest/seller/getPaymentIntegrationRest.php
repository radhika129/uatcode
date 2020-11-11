<?php
header("Content-Type:application/json");
include('../../config/config.php');
class CashMovement
{
	public $cash_movement_id;
	public $linked_movement;
	public $order_id;
	public $seller_id;
	public $entry_side;
	public $opening_balance;
	public $amount;
	public $amount_currency;	
	public $dr_cr_indicator;
	public $closing_balance;
	public $movement_type;
	public $payment_reference;
	public $movement_status;
	public $created_date_time;
	public $order_date;
	public $value_date;
	public $status;
	public $
  // Methods
  function get_details($user_id) {
    $query="select * from reviews where seller_id='".$user_id."'";
    $query=query($query);
    confirm($query);
    $row=array();
    while($row1=fetch_array($query))
		{
				
			$row=$row1;
			
		}
	$this->seller_id=$row['seller_id'];
	$this->review_title=$row['review_title'];
	$this->review=$row['review'];
	$this->rating=$row['rating'];
	$this->creation_date_time=$row['creation_date_time'];
  }
  function upadte_details() {
	 
    $query="update reviews set review_title='".$this->review_title."',review='".$this->review."',rating='".$this->rating."',creation_date_time=".$this->creation_date_time." where seller_id='".$this->seller_id."'";
    //echo $query;
    query($query);
    confirm($query);
  }
}

?>
