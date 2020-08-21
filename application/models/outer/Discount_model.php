<?php

class discount_model extends CI_Model{
	function __construct(){
		parent::__construct();
	
	}
	function check_ws_discount_plain($userID, $manuID, $qty = NULL)
	{
		if($qty>=1 && $qty<=25)    		  		{$col='Price_25';} 
		else if($qty>25 && $qty<=50)      		{$col='Price_50';} 
		else if($qty>50 && $qty<=100)     		{$col='Price_100';} 
		else if($qty>100 && $qty<=300)    		{$col='Price_300';} 
		else if($qty>300 && $qty<=500)    		{$col='Price_500';}
		else if($qty>500 && $qty<=1000)    		{$col='Price_1000';}
		else if($qty>1000 && $qty<=2500)    	{$col='Price_2500';}
		else if($qty>2500 && $qty<=5000)    	{$col='Price_5000';}
		else if($qty>5000 && $qty<=7500)    	{$col='Price_7500';}
		else if($qty>7500 && $qty<=10000)    	{$col='Price_10000';}
		else if($qty>10000 && $qty<=15000)   	{$col='Price_15000';}
		else if($qty>15000 && $qty<=20000)		{$col='Price_20000';}
		else if($qty>20000)						{$col='Price_50000';}
		else{$col='Price_25';}
		
		$this->db->select($col);
		$this->db->where('userID', $userID);
		$this->db->where('ManufactureID', $manuID);
		$result = $this->db->get('ws_plain_sheet_discounts');
        $row = $result->row_array();
		
		if(!empty($row))
		{
        	return $row[$col];
        }
		return false;
	}
	
	function check_ws_discount_print($userID, $manuID, $qty = 25)
	{
		if($qty>=1 && $qty<=25)    		  		{$col='Price_25';} 
		else if($qty>25 && $qty<=50)      		{$col='Price_50';} 
		else if($qty>50 && $qty<=100)     		{$col='Price_100';} 
		else if($qty>100 && $qty<=300)    		{$col='Price_300';} 
		else if($qty>300 && $qty<=500)    		{$col='Price_500';}
		else if($qty>500 && $qty<=1000)    		{$col='Price_1000';}
		else if($qty>1000 && $qty<=2500)    	{$col='Price_2500';}
		else if($qty>2500 && $qty<=5000)    	{$col='Price_5000';}
		else if($qty>5000 && $qty<=7500)    	{$col='Price_7500';}
		else if($qty>7500 && $qty<=10000)    	{$col='Price_10000';}
		else if($qty>10000 && $qty<=15000)   	{$col='Price_15000';}
		else if($qty>15000 && $qty<=20000)		{$col='Price_20000';}
		else if($qty>20000)						{$col='Price_50000';}
		else{$col='Price_25';}
		
		$this->db->select($col);
		$this->db->where('userID', $userID);
		$this->db->where('ManufactureID', $manuID);
		$result = $this->db->get('ws_printed_sheet_discounts');
        $row = $result->row_array();
		if(!empty($row))
		{
        	return $row[$col];
        }
		return false;
	}
	
	function get_global_discount_plain($customerID)
	{
		$this->db->select("plain_discount");
		$this->db->where("userID",$customerID);
		$result = $this->db->get("customers")->row_array();
		if(!empty($result))
		{
			return $result['plain_discount'];
		}
		else
		{
			return false;
		}
	}

	function get_global_discount_print($customerID)
	{
		$this->db->select("printed_discount");
		$this->db->where("userID",$customerID);
		$result = $this->db->get("customers")->row_array();
		if(!empty($result))
		{
			return $result['printed_discount'];
		}
		else
		{
			return false;
		}
	}
	
	function check_ws_discount_rolls($userID, $manuID)
	{
		$this->db->where('userID', $userID);
		$this->db->where('ManufactureID', $manuID);
		$result = $this->db->get('ws_roll_discounts');
        $row = $result->row_array();
		
		if(!empty($row))
		{
        	return $row;
        }
		return false;
	}
// end of discount Model
}