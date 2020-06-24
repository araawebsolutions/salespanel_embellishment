<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class updateTicket extends CI_Controller {

	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		$this->load->model('return/updateTicket_model');
		$this->home_model->user_login_ajax();
		//$this->load->model('Rejected_artwork_model');
		//$this->session->set_userdata('UserName','kamran');
		//$this->session->set_userdata('UserID','640847'); //640847 // 641147
		$this->session->set_userdata('UserTypeID','50');

         /*error_reporting(-1);
      ini_set('display_errors', 1);
   error_reporting(E_ALL);*/
    }


//------------------------------------------------MAIN LISTING----------------------------------------------------------


	public function index($id){
		$data['start'] = 0;
		$data['result'] = $this->updateTicket_model->fetchTicketDetails($id);
		$data['reffers'] = $this->updateTicket_model->getRefferppl($id);
		$data['main_content'] = "return/updateTicket";
		$this->load->view('page',$data);
	}
    
    
	function updateTicket(){
  	       
		$ac_outcome  = $this->input->post('ac_outcome');
		$ticket_id  = $this->input->post('ticket_id');
		$ac_action  = $this->input->post('ac_action');
        
		$ac_area_resp  = $this->input->post('area_resp'); 
		$ac_area_resp = implode(',',$ac_area_resp); 
		$ac_resp_com  = $this->input->post('area_resp_com');
         
		$contact_type = $this->input->post('contact_type');
		$contact_reason = $this->input->post('contact_reason');
		$pre_action_taken = $this->input->post('pre_action_taken');
		$pre_investigation = $this->input->post('pre_investigation');
		$pre_finding = $this->input->post('pre_finding');
		$pre_outcome = $this->input->post('pre_outcome');
            
		$exp_reff_no = $this->input->post('exp_reff_no');
		$exp_courier = $this->input->post('exp_courier');
		$exp_collection_date = $this->input->post('exp_collection_date');
		$exp_delivery_date = $this->input->post('exp_delivery_date');
		$booking_notes= $this->input->post('booking_notes');
        
		$re_received_date= $this->input->post('re_received_date');
		$re_boxes= $this->input->post('re_boxes');
		$re_condition= $this->input->post('re_condition');
		$re_refund= $this->input->post('re_refund');
		$re_notes= $this->input->post('re_notes');
    	    
		$isShip= $this->input->post('isShip');
    	    
		$reffTo= $this->input->post('reffTo');
		$reff_for= $this->input->post('reff_for');
		
		$token = $this->input->post('token');
            
		if($ticket_id){
			$this->updateTicket_model->updateTicket($ticket_id,$ac_outcome,$ac_action,$exp_reff_no,$exp_courier,$exp_collection_date,$exp_delivery_date,$booking_notes,$contact_type,$contact_reason,$pre_action_taken,$pre_investigation,$pre_finding,$pre_outcome,$re_received_date,$re_boxes,$re_condition,$re_refund,$re_notes,$isShip,$reffTo,$reff_for,$ac_area_resp,$ac_resp_com,$token);
		}
        
		//redirect('index.php/tickets/returns');
		redirect(main_url."tickets/returns");
		//redirect('tickets/updateTicket/index/'.$ticket_id);
	}
    
    
	function creatReplacementOrder($id){
		$serviceID = $this->input->post('shipDel');
		$this->updateTicket_model->creatReplacementOrder($id,$serviceID);
		//redirect('index.php/tickets/updateTicket/index/'.$id);
		redirect(main_url."tickets/updateTicket/index/".$id);
	}
    
	function creatCreditNote($id){
		$this->updateTicket_model->creatCreditNote($id);
		//redirect('index.php/tickets/creditNotes');
		redirect(main_url."tickets/creditNotes/viewDetails/".$id);
	}
  
	function refuseTicket($id){
		$this->updateTicket_model->refuseTicket($id);
		//redirect('index.php/tickets/updateTicket/index/'.$id);
		redirect(main_url."tickets/updateTicket/index/".$id);
	}

//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
	
}
