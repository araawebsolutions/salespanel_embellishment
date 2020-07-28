<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Invoice extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->model('order_quotation/OrderModal');
    $this->load->model('accountmodel');
    $this->load->model('quoteModel');
    $this->load->model('home_model');
    $this->load->model('order_quotation/QuotationModal');
    $this->home_model->user_login_ajax();

  }
	
	
	
  ////////////////////////////index ////////////////////////////////
  
  public function index(){
    $data['main_content'] = "order_invoice/order_invoice_list";
    $this->load->view('page',$data);
  }
  
  
  public function getAllinvoice(){
      $this->load->model('invoice_model');
      echo $this->invoice_model->getAllinvoice();
  }  
  
  
  
  
  public function printnote($invoice) {
      $this->load->model('invoice_model');
		
    $data['invoice']      = $invoice;
    $data['OrderDetails'] = $this->invoice_model->OrderDetails($invoice);
    $data['OrderInfo']    = $this->invoice_model->OrderInfo($invoice);
		 //echo '<pre>';print_r($data['OrderDetails']); echo '</pre>';
    $Orderline    = $this->orderModal->OrderInfo($data['OrderInfo'][0]->OrderNumber);
    $site = $Orderline[0]->site;
    $language = ($site=="" || $site=="en")?"en":"fr"; 
    $page =  ($language=="fr")?"order_invoice/invoice/fr/Note-print":"order_invoice/invoice/Note-print"; 
		
    $this->load->library('pdf');
     //$f = $this->load->view($page,$data);
    //print_r($f);
    $this->pdf->load_view($page, $data);
		//exit;
    $this->pdf->render();
    $output	= $this->pdf->output();
		
    $file_location ="pdf/creditnote_".$invoice.".pdf"; 
		
    $filename = $file_location;
    $fp = fopen($filename, "a");
    file_put_contents($file_location,$output); 
    $this->pdf->stream("Credit Note : ".$invoice.".pdf");
  }
  
  

  
  public function printinvoice($invoice) {

    $orderID = $this->getinvoicenumber($invoice); 	
		
    $data['invoice']      = $invoice;
    $data['OrderDetails'] = $this->orderModal->OrderDetails($orderID);
    $OrderInfo    = $this->orderModal->OrderInfo($orderID);
	//	echo '<pre>'; print_r($data['OrderDetails']);
    $site = $OrderInfo[0]->site;
		  //$site = 'fr';
    $language = ($site=="" || $site=="en")?"en":"fr"; 
    $page =  ($language=="fr")?"order_invoice/invoice/fr/Invoice-print":"order_invoice/invoice/Invoice-print";
		 
    $data['OrderInfo'] = $OrderInfo;
    //echo $this->load->view($page, $data,TRUE); exit;
    $this->load->library('pdf');
    $this->pdf->load_view($page, $data,TRUE);
    $this->pdf->render();

    $output	= $this->pdf->output();
    $file_location = "pdf/invoice_".$invoice.".pdf";
    $filename = $file_location;
    $fp = fopen($filename, "a");
    file_put_contents($file_location,$output);

      /*$f;
      $l;
      if(headers_sent($f,$l))
      {
          echo $f,'<br/>',$l,'<br/>';
          die('now detect line');
      }*/

      $this->pdf->stream("Invoice No : ".$invoice.".pdf");



  }
  
  
  

    function viewinvoice($invoice){
       
         $orderID = $this->getinvoicenumber($invoice);
        $data['AccountDetails'] = $this->OrderModal->OrderDetails($orderID);
        $data['AccountInfo'] = $this->OrderModal->OrderInfo($orderID);
      
        $data['invoice'] = $invoice;
        $data['main_content'] = 'order_invoice/invoice_detail_page';
        $this->load->view('page', $data);
    }



  function getinvoicenumber($invoice){
    $sql = $this->db->query("select OrderNumber from invoice where InvoiceNumber LIKE '$invoice' and InvoiceType = 'Invoice'");
    $result = $sql->row_array();
    return $result['OrderNumber']; 	
  }
	






}