<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	function __construct(){
	 parent::__construct();	
	 $this->load->database();
 	 $this->load->model('dashboardModel');
 	 $this->home_model->user_login_ajax();
	 error_reporting(E_ALL);
    }
   
   
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
  public function index(){
         $UserTypeID = $this->session->userdata('UserTypeID');
         $UserID = $this->session->userdata('UserID');
        
       	 if($UserTypeID == 88) {
	       redirect(base_url().'index.php/Artworks');
         }
           
       
    $data['counts'] = $this->dashboardModel->getCounts();
   	$data['main_content'] = "dashboard";	
	$this->load->view('page',$data);	
  }

  public function getFollowUp(){
      print_r($this->dashboardModel->getFollowUpCount());
  }
  public function getEnquiry(){
      print_r( $this->dashboardModel->getEnquiryCount());
  }


  public function getToProducts(){


     $data['products'] = $this->dashboardModel->getToProducts();
     $data['countries'] = $this->dashboardModel->getToCountries();
     $data['weeklyOrders'] = $this->dashboardModel->weeklyOrders();
     $data['MonthlyOrders'] = $this->dashboardModel->MonthlyOrders();

     //echo '<pre>';
     //print_r($data['countries']);exit;

     $this->output->set_content_type('application/json');
     $this->output->set_output(json_encode($data));
  }

  public function knowledgeResource(){
	  $pdfName = $this->input->get('name').'.pdf';
      $data['pdfName'] = $pdfName;
	  $data['main_content']="knowledge_resource";

      $this->load->view('page',$data);
  }

   function generate_pdf(){
      $data['main_content'] = "designer_pdf";
      $this->load->view('page', $data);   
      
     }
      function generate_pdf_roll(){
      $data['main_content'] = "designer_pdf_roll";
      $this->load->view('page', $data);   
      
     }	
	
}
