<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 

class payment_sales_audit_model extends CI_Model{

    ////////////////////////////Save Product/////////////////



  function getPaymentMethodsCurrency(){

     $sql = "SELECT * from paymentmethods join currency where Active = 1 and currency.status = 1 order by `PaymentMethodName` , currency_name asc";

     $query = $this->db->query($sql);

     return $query->result();

  }


  function getOrderCount($payment=NULL, $vat_exempt=NULL, $user_type=NULL, $start_date=NULL, $end_date=NULL){
    $sql = "SELECT `currency`.`currency_name`, `paymentmethods`.`PaymentMethodName`, (SELECT sum(OrderTotal) as OrderTotal FROM `orders` JOIN `customers` ON `orders`.`UserID` = `customers`.`UserID` 

    WHERE 

    `orders`.`PaymentMethods` = `paymentmethods`.`PaymentMethodName` 

    AND `orders`.`currency` = `currency`.`currency_name`"; 

    

    if($payment != 'y')

    {

      $sql .= " AND `orders`.`Payment` != '0'";

    }

    elseif($payment == 'y')

    {

      $sql .= " AND `orders`.`Payment` = '0'";

    } 



    if($vat_exempt == 'n')

        $sql .= " AND `vat_exempt` != 'yes'";

      elseif($vat_exempt == 'y')

        $sql .= " AND `vat_exempt` = 'yes'";



    if($user_type == 'credit')

        $sql .= " AND customers.user_type = '".$user_type."'";

      elseif($user_type == 'payment')

        $sql .= " AND customers.user_type = '".$user_type."'";



    if($start_date != NULL)

      {

        $sql .= " AND `orders`.`OrderDate` >= '".$start_date."'";

      }

      if($end_date != NULL)

      {

        $sql .= " AND `orders`.`OrderDate` <= '".$end_date."'";

      }

    $sql .= " ORDER BY `orders`.`PaymentMethods` ASC) as OrderTotal 

    from paymentmethods 

    join currency 

    WHERE paymentmethods.Active =  1 

    AND currency.`status` =  1 

    order by `PaymentMethodName` , currency_name asc";



    //echo $sql;

    $query  = $this->db->query($sql);

    $result = $query->result();

    //echo "<pre>";

    //print_r($result);
    //die();

    return $result;
  }

    function getOrder($paymentmethod, $currency, $payment=NULL, $vat_exempt=NULL, $user_type=NULL, $start_date=NULL, $end_date=NULL,$status= NULL){
      $start = $start_date.' '.'00:00:00';
      $end =  $end_date.' '.'23:59:59';
      $start_date =  strtotime($start);
      $end_date =   strtotime($end);
    
      $this->db->select('sum(OrderTotal * exchange_rate) as OrderTotal , OrderStatus');
      $this->db->from('orders');
      $this->db->join('customers', 'orders.UserID = customers.UserID');
      /*$this->db->where('orders.PaymentMethods <>', '');

      $this->db->where('orders.PaymentMethods <>', '0');*/

      //$payment_methods = array('Bacs' , 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');
      $this->db->where('orders.PaymentMethods', $paymentmethod);
      $this->db->where('orders.currency', $currency);
      if($payment != 'y')
      {
        $this->db->where('orders.Payment <>', '0');
      }

      elseif($payment == 'y')
      {
        $this->db->where('orders.Payment', '0');
      }

      if($vat_exempt == 'n')
        $this->db->where('vat_exempt !=', 'yes');
      elseif($vat_exempt == 'y')
        $this->db->where('vat_exempt', 'yes');

      if($user_type == 'credit')
        $this->db->where('customers.user_type', $user_type);
      elseif($user_type == 'payment')

        $this->db->where('customers.user_type', $user_type);
      if($start_date != NULL)
      {
        $this->db->where('`orders`.`OrderDate` >=', $start_date);
      }
     
   
      if($end_date != NULL)
      {
        $this->db->where('orderDate <=', $end_date);
      }
        if(($status != "" || $status != '0') && $status != 'not' )
      {
        $this->db->where('orders.OrderStatus',6);
       // $this->db->or_where('orders.OrderStatus',27);
      }else{
        if($status =='not'){
          $this->db->where('orders.OrderStatus!=',6);
          $this->db->where('orders.OrderStatus!=',27);
        }
      }
      $this->db->order_by('`orders`.`PaymentMethods`', 'asc');
      $query = $this->db->get();
      $re = $query->row();
      return $re;
    }



    function getOrderDetail($paymentMethod, $currency, $payment=NULL, $vat_exempt=NULL, $user_type=NULL, $start_date=NULL, $end_date=NULL,$status= NULL){
      $start = $start_date.' '.'00:00:00';
      $end =  $end_date.' '.'23:59:59';
      $start_date =  strtotime($start);
      $end_date =   strtotime($end);
      
      $this->db->select('*');
      $this->db->from('orders');
      $this->db->join('customers', 'orders.UserID = customers.UserID');
      $this->db->where_in('orders.PaymentMethods', array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay'));
     
      if($payment != 'y')
      {
        $this->db->where('orders.Payment <>', '0');
      }
      elseif($payment == 'y')
      {
        $this->db->where('orders.Payment', '0');
      }
      $this->db->where('orders.currency', $currency);
      $this->db->where('orders.PaymentMethods', $paymentMethod);
      if($vat_exempt == 'n')
        $this->db->where('vat_exempt !=', 'yes');
      elseif($vat_exempt == 'y')
        $this->db->where('vat_exempt', 'yes');
      if($user_type == 'credit')
        $this->db->where('customers.user_type', $user_type);
      elseif($user_type == 'payment')
        $this->db->where('customers.user_type', $user_type);
      if($start_date != NULL)
      {
        $this->db->where('orderDate >=', $start_date);
      }
      if($end_date != NULL)
      {
        $this->db->where('orderDate <=', $end_date);
      }
      if(($status != "" || $status != '0') && $status != 'not')
      {
        $this->db->where('orders.OrderStatus',6);
      }else{
        if($status =='not'){
          $this->db->where('orders.OrderStatus!=',6);
           $this->db->where('orders.OrderStatus!=',27);
        }
      }
      $this->db->order_by('`orders`.`PaymentMethods`', 'asc');
      $query = $this->db->get();
      $result =  $query->result();
      return $result;
    }



    function updateExchangeRate($update, $where ){
      $this->db->where('OrderID', $where);
      return $this->db->update('order',$update);
    } 

}

?>