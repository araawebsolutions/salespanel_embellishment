<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accountmodel extends CI_Model {

    public function unpaidOrders() {

        
            
   
            $query = $this->db->query("select * from orders where (orders.Payment='0' or orders.Payment='2')and ((OrderTotal<>'0.00')and(OrderStatus ='7'or OrderStatus ='8')or(PaymentMethods ='specialOrders'and OrderStatus !='27'))order by OrderID desc ");
        

        return $query->result();
    }

    public function paidOrders($limit, $offset) {
        if ($offset) {
            $query = $this->db->query("select * from orders WHERE Payment=1 AND((OrderTotal<>'0.00')and OrderStatus ='7'or OrderStatus ='8'or PaymentMethods ='specialOrders')order by OrderID desc LIMIT $limit OFFSET $offset");
        } else {
            $query = $this->db->query("select * from orders WHERE Payment=1 AND((OrderTotal<>'0.00')and OrderStatus ='7'or OrderStatus ='8'or PaymentMethods ='specialOrders')order by OrderID desc LIMIT $limit");
        }
        return $query->result();
    }

    public function returnRows() {

        $query = $this->db->query("select * from orders where (orders.Payment='0' or orders.Payment='2')and ((OrderTotal<>'0.00')and(OrderStatus ='7'or OrderStatus ='8')or(PaymentMethods ='specialOrders'and OrderStatus !='27'))");
        return $query;
    }

    public function PaidreturnRows() {

        $query = $this->db->query("select * from orders WHERE Payment=1 AND((OrderTotal<>'0.00')and OrderStatus ='7'or OrderStatus ='8'or PaymentMethods ='specialOrders')order by OrderID desc");
        return $query;
    }

    public function AccountDetails() {
        $orderID = end($this->uri->segments);
        $query = $this->db->get_where('orderdetails', array('OrderNumber' => $orderID));
        return $query->result();
    }

    public function AccountInfo() {
        $orderID = end($this->uri->segments);
        $query = $this->db->get_where('orders', array('OrderNumber' => $orderID));
        return $query->result();
    }
    public function getstatus($id) {
         
        $query = $this->db->get_where('dropshipstatusmanager', array('StatusID' => $id));
        return $query->result();
    }

    public function unpaidOrdersLoad() {
        $search = $_POST['search'];

        $query = $this->db->query("select * from orders where (orders.Payment='0' or orders.Payment='2')and orders.BillingFirstName LIKE '" . '%' . $search . '%' . "' and ((OrderTotal<>'0.00')and(OrderStatus ='7'or OrderStatus ='8')or(PaymentMethods ='specialOrders'and OrderStatus !='27'))order by OrderID desc");
        return $query->result();
    }
	
	
    public function changestatus($id,$status){
        $update = array(
            'Payment' => $status,
        );
        
        $this->db->where('OrderID',$id);
        $this->db->update('orders',$update);
    }
	

    public function manufactureid($domain,$id)
    {
        if($domain=='123'){$ManufactureID='123ManufactureID';}else{$ManufactureID='ManufactureID';}
        $this->db->select($ManufactureID);
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->$ManufactureID;
    }
	
	public function LabelsPerSheet($id){
        $this->db->select('LabelsPerSheet');
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->LabelsPerSheet;
    }
	
	
	 /******************Pending Payment  Order implementation***********************/ 
	 
	 
	 function customer($USERID){
	 $qry = $this->db->query("select * from customers where UserID = '$USERID'");
	 return $qry->row_array();
	 	 
	 }
	 
	 
	 
	 
	 
	 
}

?>
