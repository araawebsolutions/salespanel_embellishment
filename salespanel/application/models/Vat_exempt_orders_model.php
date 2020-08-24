<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vat_exempt_orders_model extends CI_Model{

    ////////////////////////////Save Product/////////////////

    function getOrder($post){
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

          $this->db->select('*');
          $this->db->from('orders')->where('vat_exempt', 'yes')->order_by('OrderID', 'desc');
          $this->db->join('customers', 'orders.UserID = customers.UserID', 'left');
          if(!empty(trim($post['start_date'])) || !empty(trim($post['end_date']))){
            if(empty($post['start_date'])){
             $post['start_date'] = date('d/m/Y');
            }
            if(empty($post['end_date'])){
              $post['end_date'] = date('d/m/Y');
            }
            $c=0;
            $start =  $start_date;
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
      $this->db->group_by('orders.OrderID');
      $query = $this->db->get();
      return $query->result();

    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
      $date_aux = date_create_from_format($from_format, $date);
      return date_format($date_aux,$to_format);
    } 
}

?>