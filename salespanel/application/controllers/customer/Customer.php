<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {

	
	 function __construct(){
	 parent::__construct();	
	 $this->load->database();
     $this->load->model('dashboardModel');
	 $this->home_model->user_login_ajax();
    }
   
   
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
  public function index(){

      $data['main_content'] = "order_quotation/dashboard";
      $this->load->view('page',$data);
  }
  
   public function changecustomerstate(){
    $userid = $this->input->post('userid');
    $state  = $this->input->post('state');
	$reponse = "no";
	
	if(isset($userid) && $userid!=0){
	  $this->db->where('UserID',$userid);
	  $this->db->update('customers',array('Active'=>$state));
      $reponse =  "yes";
	}
	echo $reponse;
  }

}
