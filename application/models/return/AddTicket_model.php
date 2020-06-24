<?php
class addTicket_model extends CI_Model{
	
	function __construct(){
		parent::__construct();                       
		$this->load->model('return/ReturnGetPrice_model');
		$this->load->model('email/EmailModal');
	}
	
function findOrders($orders_ids,$for_one){
		$query = "SELECT od.SerialNumber,od.Printing,od.Print_Type,od.labels,od.LabelsPerRoll,od.FinishType,od.Price,p.ProductBrand,od.UserID,od.OrderNumber,o.BillingFirstName, o.BillingLastName, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, o.BillingPostcode, o.BillingCountry, od.ManufactureID, od.ProductName, od.Quantity, od.ProductTotal,o.Billingtelephone,o.Billingemail,concat(o.BillingAddress1,',', o.BillingPostcode) as address,o.currency ,o.OrderStatus, 
        
				(select oo.UserID
        				
				
				from `orders` as oo 
        inner join orderdetails as odd on odd.OrderNumber=oo.OrderNumber 
        where (o.OrderStatus=7 || o.OrderStatus=8) && odd.OrderNumber IN (".$for_one.") limit 1 ) as first 
        
        FROM `orders` as o 
       
        inner join orderdetails as od on od.OrderNumber=o.OrderNumber
        inner join products as p on p.ProductID=od.ProductID
        
        where (o.OrderStatus=7 || o.OrderStatus=8) && od.ManufactureID!='SCO1' && od.OrderNumber IN (".$orders_ids.")"; 
        
		$res = $this->db->query($query)->result_array();
        
		//echo $this->db->last_query();  echo '<br><br>';exit;
		return $res;
        
		//echo '<pre>'; print_r($res); echo '</pre>'; exit;
	}
    
	function findOrdersCust($orders_ids){
		$query = "SELECT od.SerialNumber,od.Printing,od.Print_Type,od.labels,od.LabelsPerRoll,od.FinishType,od.Price,p.ProductBrand,od.UserID,od.OrderNumber,o.BillingFirstName, o.BillingLastName, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, o.BillingPostcode, o.BillingCountry, od.ManufactureID, od.ProductName, od.Quantity, od.ProductTotal,o.Billingtelephone,o.Billingemail,concat(o.BillingAddress1,',', o.BillingPostcode) as address,o.currency , 
        
				(select oo.UserID from `orders` as oo 
        
				inner join orderdetails as odd on odd.OrderNumber=oo.OrderNumber 
        
        where odd.OrderNumber IN (".$orders_ids.") limit 1 ) as first FROM `orders` as o 
     
        inner join orderdetails as od on od.OrderNumber=o.OrderNumber
        inner join products as p on p.ProductID=od.ProductID
        where od.ManufactureID!='SCO1' && od.OrderNumber IN (".$orders_ids.")"; 
        
		$res = $this->db->query($query)->result_array();
		return $res;
	}
	
	function  getAllString($orders_ids){
		$query = "SELECT od.UserID,od.OrderNumber        
		FROM `orders` as o 
     
		 inner join orderdetails as od on od.OrderNumber=o.OrderNumber
		 inner join products as p on p.ProductID=od.ProductID
		 where od.OrderNumber IN (".$orders_ids.") group by od.OrderNumber"; 
        
		return $res = $this->db->query($query)->result_array();
	}
    
    
	function get_price($Productbrand,$ManufactureID,$Quantity,$batch,$labels,$Print_Type,$FinishType,$Printing,$SerialNumber){
  	      
		if(preg_match("/Integrated Labels/i",$Productbrand)){
				
			$newqty = $this->ReturnGetPrice_model->calculate_integrated_qty($ManufactureID,$Quantity);
			$price = $this->ReturnGetPrice_model->single_box_price($ManufactureID,$newqty,$batch);
			$total = $price['PlainPrice'];
        				
			if($Quantity != $price['Sheets']) {
				$perbox = $price['PlainPrice']/$price['Box'];
				$acc_boxes = $Quantity/$batch;
				$calculated_price = $acc_boxes*$perbox;
				$price['PlainPrice'] = $calculated_price;
				$total = $price['PlainPrice'];
			}
        				
			$unitPrice = $total/$Quantity;
			$UnitPrice = number_format(round($unitPrice,2),2,'.','');
             
			$vat = round(($total*20)/100,2);
			$vat = $vat + $total;
			$arr = array('UnitPrice'=>$total,'TotalPrice'=>$vat);
			echo json_encode($arr);
		}
		else{
			echo  $status = $this->ReturnGetPrice_model->UpdateItem($SerialNumber,$Productbrand,$ManufactureID,$Quantity,$Printing,$labels,$Print_Type,$FinishType);
		}	                            
	}
    
    
	function createTicket($order_details_data,$contact_type,$contact_reason,$pre_action_taken,$pre_investigation,$pre_finding,$pre_outcome,$token){
        
		$SrNo = $this->getTicketNo();
		$order_data['ticketSrNo	'] = $SrNo;
		$order_data['UserID'] = $this->session->userdata('UserID');
		//$order_data['reffTo'] = '5757';
    	    
		/*if($order_data['reffTo']){
		//$order_data['reffDate'] = date('Y-m-d');
		}*/
        
		//$order_data['areaResponsible'] = 'areaResponsible';
		$order_data['followUpDate'] = date('Y-m-d');
		$order_data['create_date'] = date('Y-m-d');
        
		$order_data['contact_type'] =  $contact_type;
		$order_data['contact_reason'] =  $contact_reason;
        
		$order_data['pre_action_taken'] =  $pre_action_taken;
		$order_data['pre_investigation'] =  $pre_investigation;
		$order_data['pre_finding'] =  $pre_finding;
		$order_data['pre_outcome'] = $pre_outcome;
    	    
		$this->db->insert('tickets',$order_data);
		$tick_id= $this->db->insert_id();
		
		if($tick_id){
			$this->getAllTempImages($token,$tick_id);
		}
        
		if($SrNo==""){
			$updata['ticketSrNo	'] = $this->getTicketNoCurr();
			$this->db->where('ticket_id',$tick_id);
			$this->db->update('tickets',$updata);
		}
        
		$order_details_data = json_decode($order_details_data,true);
        
		foreach($order_details_data as $ord){
    	        
			$order_details['ticket_id'] = $tick_id;
			$order_details['orderNumber'] = $ord['orderNumber'];
			$order_details['serialNumber'] =$ord['SerialNumber'];
			$order_details['reportedFault'] = $ord['reportedFault'];
			$order_details['returnQty'] = $ord['qty'];
			$order_details['returnUnitPrice'] = $ord['unitPrice'];
			$order_details['returnPrice'] = $ord['TotalPrice'];
			$order_details['returnCurrency'] = $ord['currency'];
			$this->db->insert('ticket_details',$order_details);
		}    

	
	}
  	
  	public function getAllTempImages($token,$ticket_id){
		$res = $this->db->get_where('temp_images',array('token'=>$token))->result_array();
		
		if(count($res) > 0){
			foreach($res as $r){
				$data['ticketID'] = $ticket_id;
				$data['img_name'] = $res['img_name'];
				$data['img_type'] = $res['img_type'];
				$this->db->insert('ticket_images',$data);
			}
		}
	}
	
	function sendTicketEmail($tick_id){
		$this->EmailModal->sendTicketEmail($tick_id);
	}
    
	function getTicketNo(){
		$q = "select lpad(max(ticket_id)+1,4,'0') as ticket_idss from tickets";
		$res = $this->db->query($q)->result_array();
		return $res[0]['ticket_idss'];
	}
    
	function getTicketNoCurr(){
		$q = "select lpad(max(ticket_id),4,'0') as ticket_idss from tickets";
		$res = $this->db->query($q)->result_array();
		return $res[0]['ticket_idss'];
	}
    
    
	public function multiple_files($InputName,$tick_id){
  	      
		$this->load->library('upload');
		$image = array();
		$ImageCount = count($_FILES[$InputName]['name']);
		for($i = 0; $i < $ImageCount; $i++){
			$_FILES['file']['name']       = $_FILES[$InputName]['name'][$i];
			$_FILES['file']['type']       = $_FILES[$InputName]['type'][$i];
			$_FILES['file']['tmp_name']   = $_FILES[$InputName]['tmp_name'][$i];
			$_FILES['file']['error']      = $_FILES[$InputName]['error'][$i];
			$_FILES['file']['size']       = $_FILES[$InputName]['size'][$i];
            
			$split = explode("/",$_FILES['file']['type']);
			//echo '<pre>'; print_r($split); echo '</pre>'; 
            
			$_FILES['file']['name']  = $InputName.'_'.time().$i.'.'.$split[1];
			//echo '<pre>'; print_r($_FILES); echo '</pre>'; 

			// File upload configuration
			//$uploadPath = './assets/images/profiles/';
			$uploadPath = ticket_img_path;
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = '*';

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			// Upload file to server
			if($this->upload->do_upload('file')){
				// Uploaded file data
				$imageData = $this->upload->data();
                
				//print_r($imageData); //exit;
				$uploadImgData[$i]['img_name'] = $imageData['file_name'];
				$uploadImgData[$i]['ticketID'] = $tick_id;
				$uploadImgData[$i]['img_type'] = $InputName;
				
			}else{
				print_r($this->upload->display_errors());
			}
		}
      	  
		if(!empty($uploadImgData)){
			// Insert files data into the database
			$this->multiple_images($uploadImgData);              
		}
	}
    
    
	public function multiple_images($image = array()){
		return $this->db->insert_batch('ticket_images',$image);
	}
    
    
	/* public function getUserId($email,$phone){
	$res = $this->db->get_where('customers',array('UserEmail'=>$email,''=>$phone))->result_Array();
	return $res[0][''];
	}*/
    
	public function getAllOrders($name,$email, $phone, $duration){
		$where = ' 1=1 ';

		$UserId = $this->getUserID($name,$email,$phone);
          
		if(isset($duration) and $duration !='all')
		{
			if($duration == 7)
			{
				$where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY )) AND UNIX_TIMESTAMP(NOW())";
			}
			else if($duration == 30)
			{
				$where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 MONTH )) AND UNIX_TIMESTAMP(NOW())";
			}
			else if($duration == 90)
			{
				$where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 MONTH )) AND UNIX_TIMESTAMP(NOW())";
			}
			else if($duration == 180)
			{
				$where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 6 MONTH )) AND UNIX_TIMESTAMP(NOW())";
			}
            
		}
          
		$wh = "(orders.OrderStatus = 7 or orders.OrderStatus = 8)";
		
		$this->db->select("OrderNumber");
		$this->db->from('orders');
		$this->db->where($where);
		$this->db->where(array('UserID'=>$UserId));
		$this->db->where($wh);
    	      
		$res = $this->db->get()->result_Array();
          
		// echo $this->db->last_query();echo '<br>';echo '<br>';echo '<br>';
          
		$r = false;
		if(count($res) > 0){
			$r = json_encode($res);
		}
      	    
		if($UserId){
			return  $r;
		}else{
			return $r;
		}
          
	}
    
   function getUserID($name ,$email, $phone){
		$this->db->select("UserID");
		$this->db->from('customers');
		$this->db->like('BillingTelephone',$phone);
		$this->db->like(array('CONCAT_WS(" ",BillingFirstName,BillingLastName)'=>$name));
		$this->db->like(array('UserEmail'=>$email));
		
		$res = $this->db->get();
		//echo $this->db->last_query();
        
		$count = $res->num_rows();
		$res = $res->result_array();
		if($count > 0){
			return $res[0]['UserID'];
      	      
		}else{
			return '002001';
		} 
	}
	
	function save_logs($activity,$log_arr){
		$arr = json_encode($log_arr);
		
		$arr_ins['SessionID'] = $this->session->userdata('session_id');
		$arr_ins['Activity']  = $activity;
		$arr_ins['Record'] 	  = $arr;
    $arr_ins['Website'] 	  = 'BK';
		$this->db->insert('websitelog',$arr_ins);
	}
	
	
}




