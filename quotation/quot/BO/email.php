<?php
class Email extends CI_Controller{
	
	function __construct()
	{	
		parent::__construct();
   
   //$this->load->model('quoteModel');
		
	}

	public function order_confirm($ordernumber,$language){
		 
		$data['OrderInfo']   = $this->db->query("select * from orders where MD5(OrderNumber) LIKE '".$ordernumber."'")->row_array();
	    $data['OrderDetails'] = $this->db->query("select * from orderdetails where MD5(OrderNumber) LIKE '".$ordernumber."'")->result();
		$this->load->view('emails/order-confirmation',$data);
	 }
		 
	
	function pay_now_for_quotation($quotationNumner){
      
   $result   = $this->db->query("select QuotationNumber from quotations where MD5(QuotationNumber) LIKE '".$quotationNumner."'")->row_array();
   $quotationNumner = $result['QuotationNumber'];
   $data['quotation'] = $this->getQuotation($quotationNumner);
   $data['quotationDetails'] = $this->getQuotationDetail($quotationNumner);
   $data['title'] = 'QUOTATION NUMBER '.$data['quotation'][0]->QuotationNumber;
   $data['mainTitle'] = 'Quotation Detail ';
   
   
   $this->last_activity($quotationNumner);
      
   $data['main_content'] = 'emails/confirm_quotation';
   $this->load->View('page',$data);
 }
   
    public function getQuotation($quotationNumber){
        $results = $this->db->select("q.*,st.StatusTitle as status")
            ->select("FROM_UNIXTIME(q.QuotationTime) as time")
            ->select("FROM_UNIXTIME(q.QuotationTime) as date")
            ->from('quotations as q')
            ->join('dropshipstatusmanager as st','q.QuotationStatus = st.StatusID','left')
            ->where('q.QuotationNumber',$quotationNumber)
            ->get()->result();
        return $results;
    }
    
    public function getQuotationDetail($quotationNumber){
        $results = $this->db->select("qd.*,p.ProductName as pn,p.ProductBrand,p.LabelsPerSheet")
            ->from('quotationdetails as qd')
            ->join('products as p', 'qd.ProductID = p.ProductID','left')
            ->where('qd.QuotationNumber',$quotationNumber)
            ->get()->result();
        return $results;
    }
    
    public function get_all_QuotationDetail($quotationNumber){
        $results = $this->db->select("qd.*,p.ProductName as pn,p.ProductBrand,p.LabelsPerSheet")
            ->from('quotationdetails as qd')
            ->join('products as p', 'qd.ProductID = p.ProductID','left')
            ->where('qd.QuotationNumber',$quotationNumber)
            ->where('qd.active','N')
            ->get()->result();
        return $results;
    }

  
          function quotationToCart(){   
        
            $qty = $this->input->post('Quantity');
            $PrintTotal = $this->input->post('Print_Total');
            $price = $this->input->post('Price');
            $TotalPrice = $this->input->post('TotalPrice');
            $pr = number_format($price + $PrintTotal,2,'.','');
            $SerialNumber = $this->input->post('SerialNumber');
            $QuotationNumber = $this->input->post('QuotationNumber');
            
        
            $printedArray = array(
                'SessionID'=>$this->session->userdata('session_id'),
                'ProductID'=>$this->input->post('ProductID'),
                'UserID'=>$this->input->post('UserID'),
                'OrderTime'=>$this->input->post('OrderTime'),
                'Quantity'=>$qty,
                'orignalQty'=>$this->input->post('orignalQty'),
                'UnitPrice'=>number_format($price / $qty,2,'.',''),
                'TotalPrice'=>$price,
                'OrderData'=>$this->input->post('OrderData'),
                'LabelsPerRoll'=>$this->input->post('LabelsPerRoll'),
                'colorcode'=>$this->input->post('colorcode'),
                'is_custom'=>$this->input->post('is_custom'),
                'wound'=>$this->input->post('wound'),
                'Printing'=>$this->input->post('Printing'),
                'Print_Total'=>$this->input->post('Print_Total'),
                'Print_Type'=>$this->input->post('Print_Type'),
                'FinishType'=>$this->input->post('FinishType'),
                'Print_Design'=>$this->input->post('Print_Design'),
                'Print_Qty'=>$this->input->post('Print_Qty'),
                'Free'=>$this->input->post('Free'),
                'source'=>$this->input->post('source'),
                'orientation'=>$this->input->post('orientation'),
                'regmark'=>$this->input->post('regmark'),
                'page_location'=>'Page Pay Now',
                'tempQNoApprovel'=>$QuotationNumber
             );
            $this->db->insert('temporaryshoppingbasket',$printedArray);
           
           
            if(isset($SerialNumber)){ 
              $paramss = array('active'=>'c');
              $this->db->where('SerialNumber',$SerialNumber);
              $this->db->update('quotationdetails',$paramss);
              
              $param2 = array('view_status'=>'Accepted Pending Payment');
              $this->db->where('QuotationNumber',$QuotationNumber);
              $this->db->update('quotations',$param2);
              
              
              
            }
            
            
            
          }


    function ConvertAllQoutation(){
        $quotationNumner = $this->input->post('quotationid');
        $quotation = $this->getQuotation($quotationNumner);
        $quotationDetails = $this->get_all_QuotationDetail($quotationNumner);
        
        $sess_id = $this->session->userdata('session_id');
        $tm = date('Y-m-d h:m:i'); 
        $dates = date('Y-m-d');

    foreach($quotationDetails as $key => $quotationDetail){
    
        $printedArray = array(
            'SessionID'	=>	$sess_id,
            'ProductID'	=> $quotationDetail->ProductID,
            'UserID'	=>	$quotation[0]->UserID,
            'OrderTime'	=>	$tm,
            'Quantity'	=>	$quotationDetail->Quantity,
            'orignalQty'	=>	$quotationDetail->orignalQty,
            'UnitPrice'	=>	number_format($quotationDetail->Price / $$quotationDetail->Quantity,2,'.',''),
            'TotalPrice'	=>	$quotationDetail->Price,
            'OrderData'	=>	$dates,
            'LabelsPerRoll'	=>	$quotationDetail->LabelsPerRoll,
            'colorcode'	=>	$quotationDetail->colorcode,
            'is_custom'	=>	$quotationDetail->is_custom,
            'wound'	=>	$quotationDetail->wound,
            'Printing'	=>	$quotationDetail->Printing,
            'Print_Total'	=>	$quotationDetail->Print_Total,
            'Print_Type'	=>	$quotationDetail->Print_Type,
            'FinishType'	=>	$quotationDetail->FinishType,
            'Print_Design'	=>	$quotationDetail->Print_Design,
            'Print_Qty'	=>	$quotationDetail->Print_Qty,
            'Free'	=>	$quotationDetail->Free,
            'source'	=>	$quotation[0]->Source,
            'orientation'	=>	$quotationDetail->Orientation,
            'page_location'	=>	'Page Pay Now'
            );
        $this->db->insert('temporaryshoppingbasket',$printedArray);
    }
        $paramss = array('QuotationStatus'=>'62');
		$this->db->where('QuotationNumber',$quotationNumner);
		$this->db->update('quotations',$paramss);
  }
	
  public function addDeclineNote(){
    $title =  $this->input->post('title');
    $note =  $this->input->post('note');
    $refNumber =  $this->input->post('orderNumber');
    $qNumber =  $this->input->post('qNumber');
    
    $typ =  $this->input->post('typ');


    $params = array('order_number'=>$qNumber,'title'=>$title,'description'=>$note);
    $this->db->insert('decline_with_note',$params);
		
		
    
    if($qNumber!=""){
      
      $paramss = '';
      $ro_st = '';
      
      if($typ=='requote'){
        $time = date('Y-m-d H:i:s');  
        $time = strtotime($time); 
        
        $paramss = array('view_status'=>'Requoted','requote_time'=>$time);
        $ro_st = 'r';
        
        
      }
      
      
      if($typ=='decline'){
        $decline_type = 'Declined with feedback';
        if($note==""){
          $decline_type = 'Declined without feedback';
        }
        
        $paramss = array('view_status'=>$decline_type);
        $ro_st = 'd';
      }
      
      if($title!="Requirement changed. New quote required." || $title!="Requirement changed. No quote required."){
      
        $this->db->where('QuotationNumber',$qNumber);
        $this->db->update('quotations',$paramss);
        
        $rows_line = array('view_row_status'=>$ro_st);
        $this->db->where('SerialNumber',$refNumber);
        $this->db->update('quotationdetails',$rows_line);
      }
    }
    
		  
    
    
    return true;
  }
    
  public function accept_pay(){
    $refNumber =  $this->input->post('orderNumber');

    $paramss = array('QuotationStatus'=>'17');
    $this->db->where('QuotationNumber',$refNumber);
    $this->db->update('quotations',$paramss);
    return true;
  }
  
  
  function last_activity($refNumber){
    
    $time = date('Y-m-d H:i:s');  
    $time = strtotime($time); 
    
    if($refNumber){
      $this->db->query("UPDATE quotations SET view_count = view_count + 1, view_time = '".$time."'   WHERE QuotationNumber = '".$refNumber."'");
    }
    
  }
  
  
  public function chekclist(){
    $data['types'] = 'Decline'; 
    $theHTMLResponse = $this->load->view('emails/popups/checklist',$data,true);
    $json_data = array('html'=>$theHTMLResponse);
    $this->output->set_content_type('application/json');	
    $this->output->set_output(json_encode($json_data));
  }
  
  public function requotes(){
    $data['types'] = 'Requote'; 
    $theHTMLResponse = $this->load->view('emails/popups/requote',$data,true);
    $json_data = array('html'=>$theHTMLResponse);
    $this->output->set_content_type('application/json');	
    $this->output->set_output(json_encode($json_data));
  }

    

}