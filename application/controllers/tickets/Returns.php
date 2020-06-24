<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends CI_Controller {

	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		$this->load->model('return/Return_model');
		$this->load->helper('download');
		$this->home_model->user_login_ajax();
		
		//$this->load->model('Rejected_artwork_model');
		//error_reporting(E_ALL);
		//$this->session->set_userdata('UserName','kamran');
		//$this->session->set_userdata('UserID','640847'); //640847 // 641147
		//$this->session->set_userdata('UserTypeID','88');
	}
//------------------------------------------------MAIN LISTING----------------------------------------------------------


	public function index(){
		$data['start'] = 0;
		$data['formats'] = $this->Return_model->getformats();
		$data['result'] = $this->Return_model->fetchtickets($data['start'],1);
		$data['main_content'] = "return/return-listing";
		$this->load->view('page',$data);
	}

  
	public function fetch_top_counter(){
		$result = $this->Return_model->fetch_top_counter();
		echo json_encode($result);
	}
    
    
	public function fetch_tickets(){
		$start = $this->input->post('start');
		$data['start'] = $start;
		$data['result'] = $this->Return_model->fetchtickets($start,1);
		$theHTMLResponse = $this->load->view('return/ajax/fetch_tickets',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		echo json_encode($json_data);
	}

	public function getAllTicketsData(){
			echo $this->Return_model->getAllTicketsData();
	}
    
	function getDbFormateDate($date){
		$str = str_replace('/', '-', $date); 
		return $newDate = date('Y-m-d',strtotime($str));  
	}
    
	public function cr(){
  	      
		$res =$this->Return_model->getReturnReport("2019-03-01","2019-03-22",$format="",$status="".$areaResponsible="");
		echo '<pre>'; print_r($res); echo '</pre>'; exit;
	}
    
	public function make_csv(){
		$this->load->dbutil();
    	    
        
		$to = $this->input->post('rep_to');       
		$from = $this->input->post('rep_from'); 
    	    
		$to= $this->getDbFormateDate($to);
		$from =  $this->getDbFormateDate($from); 
       
		$format = $this->input->post('rep_format'); 
		$status = $this->input->post('rep_status'); 
		$areaResponsible = $this->input->post('rep_area'); 
        
		$res =$this->Return_model->getReturnReport($to,$from,$format,$status,$areaResponsible);
		//echo '<pre>'; print_r($res); echo '</pre>'; exit;
           
		if ($res->num_rows() ==0 ) {

			$this->session->set_flashdata('msg','Record not found');
			//redirect('index.php/tickets/returns');
			redirect(main_url."tickets/returns");
					
		} else { 
              
			$delimiter = ",";
			$newline = "\r\n";
			$enclosure = '"';
        
			$csvData = $this->dbutil->csv_from_result($res,$delimiter, $newline, $enclosure);
			$csvData =  mb_convert_encoding($csvData, "ISO-8859-1", "UTF-8");
      	  
			$filename="Ticketreport.csv";
			force_download($filename,$csvData);
			//redirect('index.php/tickets/returns');
			redirect(main_url."tickets/returns");
			//exit;
		}
	}
     
	public function comment_controller(){  
		$tid = $this->input->post('tid');
		$data['data']   = $this->Return_model->fetch_ticket_comments($tid); 
		$theHTMLResponse = $this->load->view('return/ajax/comments',$data,true);
        
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
    
	public function re_comment_controller(){  
		$tid = $this->input->post('tid');
		$data['data']   = $this->Return_model->fetch_ticket_comments($tid); 
		$theHTMLResponse = $this->load->view('return/ajax/re_comments',$data,true);
    	    
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
    
	public function area_comment_controller(){  
		$tid = $this->input->post('tid');
		$data['data']   = $this->Return_model->fetch_ticket_comments($tid); 
		$theHTMLResponse = $this->load->view('return/ajax/area_comments',$data,true);
    	    
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
	
}
