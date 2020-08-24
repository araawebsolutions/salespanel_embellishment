<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class addTickets extends CI_Controller {

	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		$this->load->model('return/addTicket_model');
		$this->load->model('return/MyPriceModels');
		$this->home_model->user_login_ajax();
    // $this->load->model('return/quotemodel');
        
    

     
	}


//------------------------------------------------MAIN LISTING----------------------------------------------------------


	public function index(){
		$data['start'] = 0;
		//$orders = "AA173413,AA173407";
		$data['result'] = '';
		$data['order_numbers'] = '';	
		$data['main_content'] = "return/getOrderNumber";	
		$this->load->view('page',$data);
	}

	function findOrders(){
		$orders_ids = $this->input->post('orderNumber');
  	   
		$arr = [];
		$arrWithOutQ = [];
		$or = explode(',',$orders_ids);
      
      
		$for_one = "'$or[0]'";
      
		foreach($or as $o){
			if($o){
				$os = $o;
				$o = "'".$o."'";
				array_push($arr,$o);
				array_push($arrWithOutQ,$os);
			}
		}
		
		$orders_ids =  implode(',',$arr);
		$arrWithOutQ =  implode(',',$arrWithOutQ);
        
		$data['start'] = 0;
		
		
		$chk_out_order = false;
		if($orders_ids){

			$allOrd =  $this->addTicket_model->getAllString($orders_ids);
			$chk_out_order = $this->IsUni($allOrd);
	
			if($chk_out_order==true){
				$data['result'] = '';
			}else{
				$data['result'] = $this->addTicket_model->findOrders($orders_ids,$for_one);
			}	
		}else{
			redirect(main_url."tickets/addTickets");
		}
      
		$data['chk_out_order'] = $chk_out_order;
		$data['order_numbers'] = $arrWithOutQ;
		$data['main_content'] = "return/addTicket";
		$this->load->view('page',$data);
	}
	
	function IsUni($allOrd){
		$chk_out_order =false;
		$Fid = '';	
		$ar_chk = [];
		if(count($allOrd) > 0){
			$i = 0;
			foreach($allOrd as $alo){
				if($i==0){$Fid = $alo['UserID'];}
				if($Fid==$alo['UserID']){
					array_push($ar_chk,$alo['OrderNumber']);
				}else{
					$chk_out_order = true;
				}
				$i++;
			}
		}
		return $chk_out_order;	
	}
     
	function findCustomersOrders(){
        
		$customer_name = $this->input->post('customer_name');
		$email_address = $this->input->post('email_address');
		$ph_no = $this->input->post('ph_no');
		$duration = $this->input->post('duration');
		$orders_ids = $this->input->post('orderNumber');
		$orders_ids = array_filter($orders_ids);
		//print_r($orders_ids); exit;
     
		$arr = [];
		$arrWithOutQ = [];
		$or = array_filter($orders_ids);
    	  
		foreach($or as $o){
			if($o){
				$os = $o;
				$o = "'".$o."'";
				array_push($arr,$o);
				array_push($arrWithOutQ,$os);
			}
		}
        
		$orders_ids =  implode(',',$arr);
		//print_r($arrWithOutQ);
    	 
		$data['rec'] = array('name'=>$customer_name,'email'=>$email_address,'ph_no'=>$ph_no,'duration'=>$duration);
			$data['start'] = 0;
		if($orders_ids){
			$data['result'] = $this->addTicket_model->findOrdersCust($orders_ids);
		}else{
			//redirect('index.php/tickets/addTickets?form=customer');
			redirect(main_url."tickets/addTickets?form=customer");
		}
        
		$data['select_numbers'] = $arrWithOutQ;
		$data['order_numbers'] = json_decode($this->addTicket_model->getAllOrders($customer_name,$email_address,$ph_no,$duration),true);
		$data['main_content'] = "return/addTicketWithCustomers";
		$this->load->view('page',$data);
	}

    
	function getPrice(){
     
		$Productbrand = $this->input->post('ProductBrand');
		$mID = $this->input->post('ManufactureID');
		$qty = $this->input->post('newQty');
		$batch = $this->input->post('batch');
     
		$labels = $this->input->post('labels');
		$Print_Type = $this->input->post('Print_Type');
		$FinishType = $this->input->post('FinishType');
		$Printing = $this->input->post('Printing');
		$SerialNumber = $this->input->post('SerialNumber');
    	 
		$this->addTicket_model->get_price($Productbrand,$mID,$qty,$batch,$labels,$Print_Type,$FinishType,$Printing,$SerialNumber);
		//$this->MyPriceModel->getPrice($Productbrand,$mID,'');
	}
    
	function mget(){
        
		$Productbrand =     "Roll Labels";
		$ManufactureID = 	"RR152221MWP4";
		$newQty =	        "2";
        $batch	=           "250";
		$labels	=           "50";
		//echo $labels = $newQty * $labels;
		$Print_Type =	    "Mono";
		$FinishType =	    "No Finish";
		$Printing =	        "Y";
		$SerialNumber=	    "45";
    
		$this->addTicket_model->get_price($Productbrand,$ManufactureID,$newQty,$batch,$labels,$Print_Type,$FinishType,$Printing,$SerialNumber);
		//echo $this->quotemodel->getPrize($newQty,$ManufactureID,'','');
	}
    
    
	function getPriceddd(){
		$data['qty'] = '23';
		$this->MyPriceModels->getPrice('AA173734','RR152221MWP4',$data);
	}
    
	function createTicket(){
		$order_details_data  = $this->input->post('orders_details');
        
		$contact_type = $this->input->post('contact_type');
		$contact_reason = $this->input->post('contact_reason');
		$pre_action_taken = $this->input->post('pre_action_taken');
		$pre_investigation = $this->input->post('pre_investigation');
		$pre_finding = $this->input->post('pre_finding');
		$pre_outcome = $this->input->post('pre_outcome');
		$token = $this->input->post('token');
		
		$userID = $this->session->userdata('UserID');
        
        if($userID){
		 $this->addTicket_model->createTicket($order_details_data,$contact_type,$contact_reason,$pre_action_taken,$pre_investigation,$pre_finding,$pre_outcome,$token);
        }
        
		//redirect('index.php/tickets/returns');
		redirect(main_url."tickets/returns");
	}
	
  public function fetchOrdersBycustomer(){
		$uname = $this->input->post('name');
		$email  = $this->input->post('email_address');
		$phone = $this->input->post('ph_no');
		$duration  = $this->input->post('duration');
		
        
		//$email = 'ali.fayyaz@yahoo.com';
		//$phone = '03215415241';
		//$duration = '180';
    //$data['result'] = 0;
		echo $data['getOrderNumber'] =  $this->addTicket_model->getAllOrders($uname,$email,$phone,$duration);
		//$data['main_content'] = "return/addTicket";
		//$this->load->view('page',$data);
		//$this->addTicket_model->getUserId($email,$phone);
	}
    
  function sendTicketEmail(){
		$this->addTicket_model->sendTicketEmail();
	}
    
	function getmaterialcode($text){
		preg_match('/(\d+)\D*$/', $text, $m);
		$lastnum = $m[1];
		$mat_code = explode($lastnum,$text);
		return strtoupper($mat_code[1]);
	}
    
   
	public function addpix(){
        
		$TicketImage = count(array_filter($_FILES['ticketImage']['name']));
		$TicketEmail  =  count(array_filter($_FILES['ticketEmail']['name']));
		$TicketAudio  =  count(array_filter($_FILES['ticketAudio']['name']));
        
		if($TicketImage > 0){
			$this->addTicket_model->multiple_files('ticketImage',5);
		}
        
		if($TicketEmail > 0){
			$this->addTicket_model->multiple_files('ticketEmail',5);
		}
      	  
		if($TicketAudio > 0){
			$this->addTicket_model->multiple_files('ticketAudio',5);
		}
        
	}
    
    
	public function multiple_files(){
		$this->load->library('upload');
		$image = array();
		$ImageCount = count($_FILES['image_name']['name']);
		for($i = 0; $i < $ImageCount; $i++){
			$_FILES['file']['name']       = $_FILES['image_name']['name'][$i];
			$_FILES['file']['type']       = $_FILES['image_name']['type'][$i];
			$_FILES['file']['tmp_name']   = $_FILES['image_name']['tmp_name'][$i];
			$_FILES['file']['error']      = $_FILES['image_name']['error'][$i];
			$_FILES['file']['size']       = $_FILES['image_name']['size'][$i];

			// File upload configuration
			//$uploadPath = './assets/images/profiles/';
			$uploadPath = ticket_img_path;
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png|gif';

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// Upload file to server
			if($this->upload->do_upload('file')){
				// Uploaded file data
				$imageData = $this->upload->data();
				$uploadImgData[$i]['image_name'] = $imageData['file_name'];

			}
		}
		if(!empty($uploadImgData)){
			// Insert files data into the database
			$this->pages_model->multiple_images($uploadImgData);              
		}
	}	
	
	
	public function upload_printing_files() {
		
		if (!empty($_FILES)) {
			$token = $this->input->post('token');
			$type = $this->input->post('type');
							
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			
			$response = $this->upload_dropzone_images('file',$type );
			if($response!='error'){
				$this->db->insert('temp_images',array('token'=>$token,'img_name'=>$response,'img_type'=>$type));
				echo $response;
			}else{
				echo $response;
			}
		}
	}
	

	function upload_dropzone_images($field_name,$type){
		
		
		$split = explode("/",$_FILES['file']['type']);
		$_FILES['file']['name']  = $type.'_'.time().'.'.$split[1];
		
		$uploadPath = ticket_img_path;
		$config['upload_path'] = $uploadPath;
		
		$config['allowed_types'] = '*';
		$config['max_size']	= '10000';
		$config['max_width']  = '10240';
		$config['max_height']  = '7680';
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload($field_name))
		{
			return "error";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data['upload_data']['file_name'];
		}
	}
	
	function delete_from_printing_files(){
		$file_name = $this->input->post('file');
		$token = $this->input->post('token');
		
		$this->db->where(array('token'=>$token,'img_name'=>$file_name));
		$query = $this->db->delete('temp_images');
		 if($query){
		  @unlink(ticket_img_path.$file_name);
		}
	}


//------------------------------------------------STAR OF FILE----------------------------------------------------------	   
	
}
