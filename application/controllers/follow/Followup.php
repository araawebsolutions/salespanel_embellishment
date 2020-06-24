<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Followup extends CI_Controller {

	
	 function __construct(){
	 parent::__construct();	
	 $this->load->database();
     $this->load->model('follow/FollowModal');
	 $this->home_model->user_login_ajax();
    }
   
   
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
  /*public function index(){
        $data['main_content'] = "follow/follow_list";
        $data['operators'] =$this->FollowModal->getOperator();
        $data['notifications'] = $this->FollowModal->get_remainder();
        $data['remainder']= $this->db->query("select count(*) as total_remaind  from callback_comment where remainder > unix_timestamp(CURDATE()) AND remainder < UNIX_TIMESTAMP(CURDATE()+1) order by remainder asc")->row_array();
        $this->load->view('page',$data);
  }*/
  
  
  public function index(){
        $data['main_content'] = "follow/follow_listoo";
        $data['operators'] =$this->FollowModal->getOperator();
        $data['notifications'] = $this->FollowModal->get_remainder();
        $data['remainder']= $this->db->query("select count(*) as total_remaind  from callback_comment where remainder > unix_timestamp(CURDATE()) AND remainder < UNIX_TIMESTAMP(CURDATE()+1) order by remainder asc")->row_array();
        $this->load->view('page',$data);
  }
    
    
    
    
    public function getQuotations($opretor = NULL){
        $this->FollowModal->getQuotations($opretor);
    }
    
    
    
    public function getorders($opretor = NULL){
        $this->FollowModal->getorders($opretor);
    }    
    
    
    

  public function getFollowUpData($opretor){

	     $this->FollowModal->getFollowUpData($opretor);
  }

  public function completeJobPage(){
      $data['main_content'] = "follow/complete_job";
      $data['operators'] = $this->FollowModal->getOperator();
      $this->load->view('page',$data);
  }

  public function completeJobRecords($filter=NULL){
      $this->FollowModal->completedJobs($filter);

    }

  public function date_insert()
  {
      $text=  $this->input->post("time");

      $refno = $this->input->post("refno");
      $stat = $this->input->post("status");
      $date = $this->input->post("date").' '.$this->input->post("time");
      $user_comment = $this->input->post("ord_Place");
      $orderno = '';
      $comment_type = "system";
      $arr = array(7 => "Ordered with another supplier", 10 => "Price", 11 => "Prduct no Available", 12 => "Third party order not recieved", 13 => "No longer required", 14 => "Other");


      $this->db->where("OrderNumber", $refno);
      $this->db->update("callback_comment", array("remainder" => 0));
      $UserID = $this->session->userdata('login_user_id');
      $UserName = $this->db->query('select UserName from customers where UserID = "' . $UserID . '"')->row_array();
      $time = time();
      $remainder = 0;
      if ($stat == 1) {
          $comment = "Pending Contact";
      } else if ($stat == 3) {
          if (substr($refno, 2, 1) == "Q") {
              $table = "quotations";
              $variable = "QuotationNumber";
          } else {
              $table = "orders";
              $variable = "OrderNumber";
          }
          $time = strtotime($date);
          $remainder = strtotime($date);
          $detail = $this->db->query("select `BillingFirstName`, `BillingLastName` from $table where $variable LIKE '$refno'")->row_array();
          $comment = $UserName['UserName'] . " Call Back to " . $detail['BillingFirstName'] . " " . $detail['BillingLastName'] . " of Refno. " . $refno . " at " . date("d/m/Y h:i a ", $time) . ".";
      } else if ($stat == 2 || $stat == 5) {
          $comment = $this->input->post("ord_Place");
          $orderno = $this->input->post("ord_no");
          $comment_type = "manual";
      } else if ($stat == 6) {
          $comment = "Customer Away";
      } else if ($stat == 4) {
          $option = $this->input->post("option");
          $note = $this->input->post("note");

          $comment = $arr[$option];
          $orderno = $comment;
          $comment = $comment . " " . $note;
          $comment_type = "manual";
      } else if ($stat == 7) {
          $comment = $this->input->post("ord_Place");
          $comment_type = "manual";
      } else if ($stat == 8) {
          $comment = "Samples Sent";
      } else if ($stat == 9) {
          $comment = "Quotation Sent";
      }

          if (isset($user_comment) and $user_comment != '') {
              /*if ($stat == 3) {
                  $times = $time;
              }else {
                  $times = time();
              }*/
          $this->db->insert("callback_comment", array('OrderNumber' => $refno,
              'comment' => $comment,
              'Operator' => $UserID,
              'Time' => $time,
              "remainder" => $remainder,
              "comment_type" => 'manual'));
      } else {
          $this->db->insert("callback_comment", array('OrderNumber' => $refno,
              'comment' => $comment,
              'Operator' => $UserID,
              'Time' => $time,
              "remainder" => $remainder,
              "comment_type" => $comment_type));
      }


        if(substr($refno, 2, 1) == "Q"){
            $field='QuotationNumber';
            $table='quotations';
            $array=array("callback_status"=>$stat, "reference_no"=>$orderno);
            if($stat==5){
                $array = array("callback_status"=>10, "reference_no"=>$orderno, "QuotationStatus"=>13, "CallbackDate"=>time());
            }else if($stat==4){
                $array = array("callback_status"=>$stat, "reference_no"=>$orderno, "QuotationStatus"=>13, "CallbackDate"=>time());
            }else if($stat==2){
                $array = array("callback_status"=>$stat, "QuotationStatus"=>13, "CallbackDate"=>time());
            }else if($stat==7){
                $array = array("callback_status"=>$stat, "QuotationStatus"=>13, "CallbackDate"=>time());
            }
        }else{
            $field='OrderNumber';
            $table='orders';
            $array = array("callback_status"=>$stat, "CallbackDate"=>time());
        }

        $this->db->where($field, $refno);
        $this->db->update($table, $array);
        if($stat == 4 || $stat == 2 || $stat == 5 || $stat == 7){
            if($UserID == SUPER_ADMIN){
                $userID = $this->db->query("select OperatorID from $table where $field like '".$refno."'")->row_array();
                $UserID = $userID['OperatorID'];
            }
            $t_assign = $this->db->query("select total_assigns from customers where UserID = '".$UserID."'")->row_array();
            $this->db->where("UserID", $UserID);
            $this->db->update("customers", array("total_assigns"=>($t_assign['total_assigns']-1)));
        }


        $data  = $this->db->query("select count(*) as cRow from callback_comment where OrderNumber = '".$refno."' order by ID Desc")->result();

        $json_data = array('count'=>$data[0]->cRow, "callback"=>$stat);
        if($stat == 3 || $stat == 6 || $stat == 8 || $stat == 9 || $stat == 4 ){//|| $stat == 4 || $stat == 5 || $stat == 7){
            $data['notifications'] = $this->FollowModal->get_remainder();
            //$remaind = $this->takeHtmlAndPrintData('follow/notification',$data);
             $remaind = '0';
            $json_data = array('count'=>$data[0]->cRow, 'date'=>date("d/m/Y h:i:a", $time), "callback"=>$stat, "remain_view"=>$remaind);
        }
        echo json_encode($json_data);

    }

  public function fetchComments(){
        $order = $this->input->post('order');
        $table = "callback_comment";
        $data['order']  = $order;
        $data['comments'] =  $this->FollowModal->fetch_order_comments($table,$order);
        $result['html'] = $this->takeHtmlAndPrintData('follow/follow_comment',$data);
        $result['count'] = count($this->FollowModal->fetch_order_comments($table,$order));
        echo json_encode($result);
    }

  public function deleteComment(){
        $commentId = $this->input->post('commentId');
        $orderNumber = $this->input->post('orderNumber');
        $table = "callback_comment";
        $data['comments'] =  $this->FollowModal->deleteComment($table,$commentId);
        $data['count'] = count($this->FollowModal->fetch_order_comments($table,$orderNumber));
        echo json_encode($data);

    }

  public function saveComment(){
        $this->FollowModal->saveComment();
        echo $this->fetchComments();
    }

  public function getRemainderLoad(){
       $data['notifications'] = $this->FollowModal->get_remainder();
       $result['html'] = $this->takeHtmlAndPrintData('follow/notification',$data);
       echo json_encode($result);
    }

  public function getStatusPopUp(){
        $status = $this->input->get('status');
        $refno = $this->input->get('refno');

        if($status ==1){
            $data['title'] = 'Are you sure to move forward.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/pending_contect',$data);
          echo json_encode($result);
        }if($status ==2){
            $data['title'] = 'Please enter Detail Reason.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/completed',$data);
          echo json_encode($result);
        }if($status ==3){
            $data['title'] = 'Please enter Estimated Date & Time';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/call_back',$data);
          echo json_encode($result);
        }if($status ==4){
            $data['title'] = 'Change Status of Line to:';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/rejected',$data);
          echo json_encode($result);
        }if($status ==5){
            $data['title'] = 'Please enter Order Number against this Quotation / Enquiry.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/order_placed',$data);
          echo json_encode($result);
        }if($status ==6){
            $data['title'] = 'Are you sure to move forward.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/customer_away',$data);
          echo json_encode($result);
        }if($status ==7){
            $data['title'] = 'Please enter Detail Reason.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/order_with_other_supelier',$data);
          echo json_encode($result);
        }if($status ==8){
            $data['title'] = 'Are you sure to move forward.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/sample_sent',$data);
          echo json_encode($result);
        }if($status ==9){
            $data['title'] = 'Are you sure to move forward.';
            $data['status'] = $status;
            $data['refno'] = $refno;
          $result['html'] = $this->takeHtmlAndPrintData('follow/status_popup/quotation_sent',$data);
          echo json_encode($result);
        }
    }




























}
