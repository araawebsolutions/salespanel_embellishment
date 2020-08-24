<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class foreign_currency_model extends CI_Model{

    ////////////////////////////Save Product/////////////////

    function getOrder($post= ''){
       $start = $post['start_date'];
       $end = $post['end_date'];
        if($start != NULL){
            $start =  $this->reformatDate($start);
        }
        else
        {
            $start = NULL;
        }
        if( $end != NULL){
           $end = $this->reformatDate($end);
        }
        else
        {
            $end = NULL;
        }
          $start = $start.' '.'00:00:00';
          $end =  $end.' '.'23:59:59';
          $start_date =  strtotime($start);
          $end_date =   strtotime($end);

      $this->db->select('*, (OrderTotal/Balance) coversion_rate');
      $this->db->from('orders');
      if(!empty(trim($post['currency']))){
        if($post['currency'] == 'ALL')
        {
          $this->db->where_in('currency', array('EUR','USD'));
        }
        else
        {
          $this->db->where('currency', $post['currency']);
        }
      }
      else
      {
        $this->db->where_in('currency', array('EUR','USD'));
      }
      if(!empty(trim($post['start_date'])) && !empty(trim($post['end_date']))){
       $c=0;
       $start = $start_date;
       $end =  $end_date;
        if($start > $end){
            $c = $start;
            $start = $end;
            $end = $c;
        }
           $this->db->where('OrderDate BETWEEN "'.$start.'" AND "'.$end.'"', '',false);
      }
      else
      if(!empty(trim($post['start_date']))){
        $this->db->where('OrderDate >=', $start_date);
      }
      else
      if(!empty(trim($post['end_date']))){
        $this->db->where('OrderDate <=', $end_date);
      }
      $this->db->where('PaymentMethods','creditCard');
      $this->db->where('OrderStatus!=',6);
      $this->db->where('OrderStatus!=' ,27);
      $this->db->order_by('OrderNumber','desc');
      
      $query = $this->db->get();
      return $query->result();
    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
      $date_aux = date_create_from_format($from_format, $date);
      return date_format($date_aux,$to_format);
    }

    function updateExchangeRate($update, $where ){
      $this->db->where('OrderID', $where);
      return $this->db->update('orders',$update);
    }
}

?>