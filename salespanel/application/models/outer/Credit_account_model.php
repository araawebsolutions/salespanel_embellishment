<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class credit_account_model extends CI_Model{
    ////////////////////////////Save Product/////////////////
	function addCreditCustomer($insert)
	{
		$this->db->insert('customers',$insert);
		$insert_id = $this->db->insert_id();
		return  $insert_id;  
	}

	function updateCreditCustomer($update, $where)
	{   return true;
		$this->db->where('UserID', $where);
		return $this->db->update('customers',$update);
    	   
	}

	function addCreditBalance($insert)
	{
		$logs_arr = array('result'=>$insert);
		$this->save_logs('addCreditBalance',$logs_arr);
			
		return $this->db->insert('c_payment',$insert);
       
	}

	function checkPaymentBalance($searchFrom){
		$this->db->from('c_payment')->where('OrderID', $searchFrom);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function editCreditBalance($update, $where)
	{
				
		$logs_arr = array('result'=>$update);
		$this->save_logs('editCreditBalance',$logs_arr);
			
			
		$this->db->where('OrderID', $where);
		return $this->db->update('c_payment',$update);
       
	}

	function save_logs($activity,$log_arr){
		$arr = json_encode($log_arr);
			
		$arr_ins['SessionID'] = $this->session->userdata('session_id');
		$arr_ins['Activity']  = $activity;
		$arr_ins['Record'] 	  = $arr;
		$this->db->insert('websitelog',$arr_ins);
	}
	
	function getPaymentBalance($UserID){
		$this->db->select('`orders`.`OrderNumber`, `orders`.`OrderDate`, `orders`.`BillingCompanyName`, `orders`.`OrderID`, `orders`.`PaymentDate`, `orders`.`OrderTotal`, `orders`.`UserID`, `customers`.`Balance`, `orders`.`paidAmt`, `orders`.`amount`, `orders`.`remaining_amount`, `orders`.`currency`,`orders`.`order_type`,`orders`.`exchange_rate`, `customers`.`Balance` as customer_balance, `invoice`.`InvoiceNumber`');
		$this->db->from('orders');
		$this->db->join('customers', 'customers.UserID = orders.UserID');
		$this->db->join('invoice', '`invoice`.`OrderNumber` = `orders`.`OrderNumber`');
		$this->db->where('orders.UserID', $UserID);
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit();
		return $query->result();
	}

	function getPaymentBalanceStatement($statement = '', $start = '', $end = '', $search= '', $search_by = ''){
        $start_date =  date('Y-m-d',strtotime($start)).' '.'00:00:00';
        $end_date =   date('Y-m-d',strtotime($end)).' '.'23:59:59';
        $where = "OrderDate BETWEEN UNIX_TIMESTAMP('".$start_date."') and UNIX_TIMESTAMP('".$end_date."')";
		$this->db->select('`orders`.`OrderNumber`, `orders`.`OrderDate`, `orders`.`BillingCompanyName`, `orders`.`OrderID`, `orders`.`PaymentDate`, `orders`.`OrderTotal`, `orders`.`UserID`, `customers`.`Balance`, `orders`.`paidAmt`, `orders`.`amount`, `orders`.`remaining_amount`, `orders`.`currency`,`orders`.`order_type`,`orders`.`exchange_rate`,`orders`.`PayFull`,`customers`.`Balance` as customer_balance');
		$this->db->from('orders');
		$this->db->join('customers', 'customers.UserID = orders.UserID');
		if($statement != 'Full')
		{
			$this->db->where('orders.PaymentMethods', '');
		}
		if($search_by != '' && $search != '')
		{
			if($search_by == 'Id'){
				$this->db->where('customers.AccountNumber', $search);        
			}
			if($search_by == 'Name'){
				$this->db->like('customers.BillingFirstName', $search);
				//$this->db->or_like('customers.UserName', $search);
			}
			if($search_by == 'Email'){
				$this->db->where('customers.UserEmail', $search);        
			}
			if($search_by == 'Company'){
				$this->db->where('customers.BillingCompanyName', $search);        
			}
		}
		if($start_date != NULL)
        {
         $this->db->where($where);
        }
		$query = $this->db->get();
      //  echo $this->db->last_query();
		//exit();
		return $query->result();
	}

	function editOrder($update, $where)
	{
		$this->db->where('OrderID', $where);
		return $this->db->update('orders',$update);
       
	}

	function checkCACustomer($searchFrom){
		$this->db->from('customers')->where('AccountNumber', $searchFrom);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function getLatestInvoiceNumber(){
		$this->db->from('c_account_balance')->order_by('c_account_balance_id', 'desc');
		$query = $this->db->get();
		$re = $query->row();
		return 1+$re->c_account_balance_id;
	}

	function getAccountNo($searchFrom){
		
		$this->db->from('customers')->like('AccountNumber', $searchFrom, 'after');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return     $rowcount + 2;
	}

	function getCustomerAccount(){
		/*SELECT `BillingFirstName`, `BillingLastName`,`BillingCompanyName`,`BillingCountry`,`BillingPostcode`,`BillingTelephone`,`VATNumber`,`Account_Limit`,`sageNumber`,
NULL FROM `customers` WHERE 1*/
		$this->db->select('`UserID`,`BillingFirstName`, `BillingLastName`,`BillingCompanyName`,`BillingCountry`,`BillingPostcode`,`BillingTelephone`,`VATNumber`,`Account_Limit`,`sageNumber`, `Balance`,`on_hold`');
		$this->db->from('customers');
		$this->db->where('BillingFirstName <>', '');
		$this->db->where('BillingFirstName <>', '0'); 
		$this->db->where('user_type', 'credit');
		$this->db->order_by('Balance', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	function getCreditCustomerAccount($id){
		$this->db->from('customers')->where('UserID', $id);
		$query = $this->db->get();
		return $query->row();
	}

function search_credit_account($qr){  $this->db->query($qr); echo $this->db->last_query();}

	function getCreditCustomerAccounBalance($account_number){
		$this->db->select('`orders`.`OrderNumber`, `orders`.`OrderDate`, `orders`.`BillingCompanyName`, `orders`.`OrderID`, `orders`.`PaymentDate`, `orders`.`OrderTotal`, `orders`.`UserID`, `customers`.`Balance`, `orders`.`paidAmt`, `orders`.`amount`, `orders`.`remaining_amount`, `orders`.`currency`, `orders`.`PayFull`,`customers`.`on_hold`, `invoice`.`InvoiceNumber`');
		$this->db->from('orders');
		$this->db->join('customers', '`customers`.`UserID` = `orders`.`UserID`');
		$this->db->join('invoice', '`invoice`.`OrderNumber` = `orders`.`OrderNumber`');
		$this->db->where('`orders`.`PayFull`', 'no');
		$this->db->where('`orders`.`UserID`', $account_number);
		$this->db->order_by('`orders`.`OrderID`', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function getCreditCustomerAccounBalanceActivity($account_number){
		$this->db->from('orders')->where('UserID', $account_number);
      
		$this->db->order_by('OrderID', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function getCurrentCreditCustomerAccount($userId, $fromdate, $todate){
		$this->db->select('sum(paidAmt) as paidAmt');
		$this->db->from('orders');
		if(!empty($userId))
			$this->db->where('`orders`.`UserID`', $userId);
			$this->db->where('`orders`.`PaymentDate` >=', $fromdate);
		if($todate != '')
			$this->db->where('`orders`.`PaymentDate` <=', $todate);
		$query = $this->db->get();
		$re = $query->row();
		return $re->paidAmt;
	}

	function getStatementOrderCount($userId, $fromdate, $todate)
	{

		$this->db->select('*, `customers`.`Balance` as customer_balance');
		$this->db->from('orders');
		$this->db->join('customers', 'customers.UserID = orders.UserID');
		if(!empty($userId))
			$this->db->where('`orders`.`UserID`', $userId);
		$this->db->where('`orders`.`PaymentDate` >=', $fromdate);
		if($todate != '')
			$this->db->where('`orders`.`PaymentDate` <=', $todate);
		$query = $this->db->get();
		//echo $this->db->last_query();
		//die();
		$re = $query->result();
		$balance = 0;
		foreach ($re as $key => $paid) {
			$credit = $paid->amount;
			$dabit = $paid->paidAmt;
			if($key ==  0)
			{
				$balance = ((int)$balance + (int)$paid->customer_balance - (int)$dabit);
			}
			else
			{
				$balance = $balance - $dabit;
			}
      	    
			if($paid->show_amt == 'Y')
			{
				//$balance = $balance + $credit;
				$balance = $credit ;	
			}
		}
		return $balance;
	}

	function getCustomerOrderCount($userId){
		$this->db->select('sum(`orders`.`OrderTotal`) as OrderTotal');
		$this->db->from('orders');
		$this->db->join('customers', '`customers`.`UserID` = `orders`.`UserID`');
		$this->db->where('`orders`.`PayFull`', 'no');
		$this->db->where('`orders`.`UserID`', $userId);
		$this->db->order_by('`customers`.`balance`', 'asc');
		$query = $this->db->get();
		$re = $query->row();
		return $re->OrderTotal;
	}

	function getSearchCustomer($search, $search_by){
  	    
		$this->db->select('*');
		$this->db->from('customers');

		if($search_by != '' && $search != '')
		{
			if($search_by == 'Id'){
				$this->db->where('customers.UserID', $search);        
			}
			if($search_by == 'Name'){
				$this->db->like('customers.BillingFirstName', $search);
				$this->db->or_like('customers.UserName', $search);
			}
			if($search_by == 'Email'){
				$this->db->where('customers.UserEmail', $search);        
			}
			if($search_by == 'Company'){
				$this->db->where('customers.BillingCompanyName', $search);        
			}
		}
      
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

}
?>