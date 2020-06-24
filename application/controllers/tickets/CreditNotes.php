<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class creditNotes extends CI_Controller {

	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		$this->load->model('return/creditNotes_model');
        $this->load->model('quoteModel');
//        /$this->load->model('orderModel');
		$this->home_model->user_login_ajax();
        
		//$this->load->model('Rejected_artwork_model');
		//	error_reporting(E_ALL);
		//$this->session->set_userdata('UserName','kamran');
		//$this->session->set_userdata('UserID','640847'); //640847 // 641147
		$this->session->set_userdata('UserTypeID','50');



	}


//------------------------------------------------MAIN LISTING----------------------------------------------------------


	public function index(){
		$data['start'] = 0;
		$data['result'] = '';
		$data['order_numbers'] = '';
		$data['main_content'] = "return/creditNotes/creditNoteListing";
		$this->load->view('page',$data);
	}
    
	public function allCreditNotes(){
		echo $this->creditNotes_model->allCreditNotes();
	}
    
	public function d(){
		$q = 'SELECT concat((CASE WHEN (credit_notes.currency = "GBP") THEN "£" WHEN (credit_notes.currency = "EUR") THEN "€" WHEN (credit_notes.currency = "USD") THEN "$" END),",",sum(credit_details.ProductPrice)) as amount FROM `credit_notes` inner join  credit_details on credit_details.ticketID=credit_notes.ticketID WHERE credit_notes.ticketID=71';
		$res = $this->db->query($q)->result_Array();
		//print_r($res);
		return $res;
	}
    
	public function viewDetails($id){
		$data['start'] = 0;
		$data['result'] = '';
		$data['note'] = $this->creditNotes_model->OrderDetails($id);
		$data['noteDetails'] = $this->creditNotes_model->noteDetails($id);
		$data['main_content'] = "return/creditNotes/credit_detail_page";
		$this->load->view('page',$data);
	}
      
	public function printnote($invoice) {
		  		
		$data['invoice']      = $invoice;
		$data['noteDetails'] = $this->creditNotes_model->noteDetailsPdf($invoice);
		$data['note'] = $this->creditNotes_model->OrderDetailsPdf($invoice);
		$data['OrderDetails'] = $this->creditNotes_model->noteDetailsPdf($invoice);
		$data['OrderInfo']    = $this->creditNotes_model->OrderDetailsPdf($invoice);
    	     
		//echo '<pre>'; print_r($data['OrderInfo']); echo '</pre>';
	     	
		$site = $data['OrderInfo'][0]->site;
		$language = ($site=="" || $site=="en")?"en":"fr"; 
		//$language = 'en';
		$page =  ($language=="fr")?"return/creditNotes/invoice/fr/Note-print":"return/creditNotes/invoice/Note-print";
        //echo $this->load->view($page, $data,true); exit;
		$this->load->library('pdf');
		$this->pdf->load_view($page, $data);

			
		$this->pdf->render();
		$output	= $this->pdf->output();
		
		$file_location ="pdf/creditnote_".$invoice.".pdf"; 
		
		$filename = $file_location;
		$fp = fopen($filename, "a");
		file_put_contents($file_location,$output); 
		$this->pdf->stream("Credit Note : ".$invoice.".pdf");
	}
    
//------------------------------------------------STAR OF FILE----------------------------------------------------------	 
}
