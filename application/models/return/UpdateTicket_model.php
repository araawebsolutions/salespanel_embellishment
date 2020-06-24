<?php
class updateTicket_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->model('return/addTicket_model');
	}
    
	function fetchTicketDetails($id){
        
		$customerDetails = $this->getCustomerDetails($id);
		$ticket = $this->getTicket($id);
		$ticket_details = $this->getTicketDetails($id);
        
		$ticket_images = $this->getTicketimages($id,'ticketImage');   
		$ticket_email_img = $this->getTicketimages($id,'ticketEmail');   
		$ticket_audio = $this->getTicketimages($id,'ticketAudio');   
		$ticketReturn = $this->getTicketimages($id,'ticketReturn');   
        
        
		$res = array("ticket"=>$ticket,"ticketDetails"=>$ticket_details,"ticket_images"=>$ticket_images,"ticketEmail"=>$ticket_email_img,"ticketAudio"=>$ticket_audio,'ticketReturn'=>$ticketReturn,'customerDetails'=>$customerDetails);
        
		if($id){
			$order_data['updateStatus'] =  0;
			$this->db->where('ticket_id',$id);
			$this->db->update('tickets',$order_data);
		}    
		return $res;
	}
  	  
	function getTicket($id){
		
		$query = "select * from tickets as t where t.ticket_id='".$id."'"; 
		return $this->db->query($query)->result_array();
	}
    
	function getTicketCustomvalues($id){
     
		$query = "select pre_action_taken,pre_investigation,pre_finding,pre_outcome,ac_outcome,ac_action,areaResponsible,ac_area_resp_c,exp_reffNo,exp_courier,exp_collectionDate,exp_deliveryDate,exp_booking_notes,contact_type,contact_reason,ticketStatus,re_received_date,re_boxes,re_condition,re_refund,re_notes,isShip,reffTo,reffDate,reff_for from tickets as t where t.ticket_id='".$id."'"; 
		return $this->db->query($query)->result_array();
		}
	
	function getTicketDetails($id){
		
		$query = "select sc.ID as 	Country_id,od.SerialNumber,od.Printing,od.Print_Type,od.LabelsPerRoll,od.FinishType,od.UserID,od.OrderNumber,o.BillingFirstName, o.BillingLastName, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, o.BillingPostcode, o.BillingCountry, od.ManufactureID, od.ProductName, od.Quantity,od.Price, od.ProductTotal,o.Billingtelephone,o.Billingemail,concat(o.BillingAddress1,',', o.BillingPostcode) as address,o.currency,td.* from ticket_details as td
     inner join orders as o on  o.OrderNumber=td.orderNumber
     left join shippingcountries as sc on sc.name=o.DeliveryCountry
     inner join orderdetails as od on od.SerialNumber=td.SerialNumber
     where td.ticket_id='".$id."'"; 
		return $this->db->query($query)->result_array();
	}
    
	function getTicketimages($id,$type){
	
		$this->db->select('*');
		$this->db->from('ticket_images');
		$this->db->where(array('ticketID'=>$id,'img_type'=>$type));
		return  $res = $this->db->get()->result_array();
	}
   	 
	function getCustomerDetails($id){
  	      
		$TicketDetails =  $this->getTicketDetails($id);
		$Order_Number = $TicketDetails[0]['orderNumber'];
        
		$Row = $this->getOrderNumberRow($Order_Number);
		return $Row;
	}
    
	function getOrderNumberRow($serialNumber){
		$query = "select o.OrderNumber,o.Billingemail,o.Billingtelephone, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, concat(o.BillingAddress1,',', o.BillingPostcode) as address from orders as o inner join customers as c on c.UserID=o.UserID where o.OrderNumber='".$serialNumber."'"; 
		return $this->db->query($query)->result_array();
	}
    

	function fetch_top_counter(){
		$from = date('Y-m-d');
		$query1 = $this->db->query("select count(*) as total_open from tickets where ticketStatus=0")->row_array();
		$open = $query1['total_open'];
		
		$query2 = $this->db->query("select count(*) as total_overdue from tickets where create_date < '".$from."'")->row_array();
		$overdue= $query2['total_overdue'];
        
		$total_artworks =  $this->fetchtickets(0,100);
		$total_artworks = count($total_artworks);
   	     
		return array('open'=>$open,'overdue'=>$overdue,'total_tickets'=>$total_artworks);
	}
    
	function getDbFormateDate($date){
		$str = str_replace('/', '-', $date); 
		return $newDate = strtotime($str);  
	}
    
	function getDatesVal($date){
		$return_date = NULL;
		if($date!=""){
			$return_date = $this->getDbFormateDate($date);
		}
		return $return_date;
	}
    
    
    
function updateTicket($ticket_id,$ac_outcome,$ac_action,$exp_reff_no,$exp_courier,$exp_collection_date,$exp_delivery_date,$booking_notes,$contact_type,$contact_reason,$pre_action_taken,$pre_investigation,$pre_finding,$pre_outcome,$re_received_date,$re_boxes,$re_condition,$re_refund,$re_notes,$isShip,$reffTo,$reff_for,$ac_area_resp,$ac_resp_com,$token){
        
		$exp_date = $this->getDatesVal($exp_collection_date);
		$exp_delivery = $this->getDatesVal($exp_delivery_date);
		$re_date = $this->getDatesVal($re_received_date);
           
		$tick = $this->getTicketCustomvalues($ticket_id);
        
		$order_data['pre_action_taken'] =  $pre_action_taken;
		$order_data['pre_investigation'] =  $pre_investigation;
		$order_data['pre_finding'] =  $pre_finding;
		$order_data['pre_outcome'] = $pre_outcome;
        
		$order_data['ac_outcome'] = $ac_outcome;
		$order_data['ac_action'] = $ac_action;
        
        
		$order_data['areaResponsible'] = $ac_area_resp;
		$order_data['ac_area_resp_c'] = $ac_resp_com;
                
		$order_data['exp_reffNo'] = $exp_reff_no;
		$order_data['exp_courier'] = $exp_courier;
		$order_data['exp_collectionDate'] = $exp_date;
		$order_data['exp_deliveryDate'] = $exp_delivery; 
		$order_data['exp_booking_notes'] = $booking_notes;
                  
		$order_data['contact_type'] =  $contact_type;
		$order_data['contact_reason'] =  $contact_reason;
		$newStatus =  $this->getTicketStatus($ticket_id,$pre_outcome,$ac_outcome,$exp_reff_no);
		$order_data['ticketStatus'] =  $newStatus;
        
		$order_data['re_received_date'] =  $re_date;
		$order_data['re_boxes'] =  $re_boxes;
		$order_data['re_condition'] =  $re_condition;
		$order_data['re_refund'] =  $re_refund;
		$order_data['re_notes'] =  $re_notes;
        
		$order_data['isShip'] =  $isShip;
		$order_data['reffTo'] =  $reffTo;
    	    
		if($order_data['reffTo']){
			$order_data['reffDate'] = date('Y-m-d');
		}else{
			$order_data['reffDate'] = NULL;
		}
		$order_data['reff_for'] =  $reff_for;
           
        
		if($ticket_id){
			$this->db->where('ticket_id',$ticket_id);
			$this->db->update('tickets',$order_data);
			
			$this->getAllTempImages($token,$ticket_id);
			
			
		}
		
        
		$arr = [];
		array_push($arr,$order_data);
    	        
		sort($tick);
		sort($order_data);
        
		
        
		if ($tick==$arr) {
		} else{
			$this->updateTicketStatus($ticket_id);
		}
        		
	}
	
	
	public function getAllTempImages($token,$ticket_id){
		$res = $this->db->get_where('temp_images',array('token'=>$token))->result_array();
		
		if(count($res) > 0){
			foreach($res as $r){
				$data['ticketID'] = $ticket_id;
				$data['img_name'] = $r['img_name'];
				$data['img_type'] = $r['img_type'];
				$this->db->insert('ticket_images',$data);
			}
		}
	}
	
    
    
	function updateTicketStatus($ticket_id){
		$order_datad['updateStatus'] =  1;
		if($ticket_id){
			$this->db->where('ticket_id',$ticket_id);
			$this->db->update('tickets',$order_datad);
		}
        
	}
    
	function getTicketStatus($ticket_id,$pre_outcome,$ac_outcome,$exp_reff_no){
		$tick = $this->getTicket($ticket_id);
		$newStatus;
		$currStatus = $tick[0]['ticketStatus'];
        
		if($currStatus==0){
    	        
			if($pre_outcome!=""){
				$newStatus= 2;
			}
            
			else if($pre_outcome==""){
				$newStatus= 0;
			}
		}
        
		else if($currStatus==2 && $this->session->userdata('UserTypeID')=='50'){
    	        
			if($ac_outcome!=""){
				$newStatus= 3;
			}
            
			else if($ac_outcome==""){
				$newStatus= 0;
			}
		}
        
		else if(($currStatus==3) && ($ac_outcome=="Collect & Refund" || $ac_outcome=="Refund Only")){
    	        
			if($exp_reff_no!=""){
				$newStatus= 1;
			}else{
				$newStatus = 3;
			}
		}
		else{
			$newStatus = $currStatus;
		}
         
		return $newStatus;
                
	}
    
    
    
   function creatReplacementOrder($id,$serviceID){

	$this->CopyOrderRow2($id);
	$this->getOrdersDetails($OrderNo,$id); //Set 2 Days + in ExpectedDeliveryDate
        
	$close_date = date('Y-m-d');
	$order_data['ticketStatus'] =  4;
	$order_data['closed_date'] =  $close_date;
	$order_data['shipServiceID'] =  $serviceID;
    	    
	if($id){
		$this->db->where('ticket_id',$id);
		$this->db->update('tickets',$order_data);
	}
}

    
    
	function getOrderDetails($id){
		$this->db->select('o.OrderID,td.ticket_id');
		$this->db->from('ticket_details as td');
		$this->db->join('orders as o','o.OrderNumber = td.orderNumber');
		$this->db->where(array('td.ticket_id'=>$id));
		$this->db->limit(1);
		$res = $this->db->get()->result_array();
		return $res[0]['OrderID'];
	}
    
    

	public function getOrderNum() {

		$sessionid = $this->session->userdata('session_id');
		$this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
		$order_num = $this->db->insert_id();
		return $order_num;

	}
    

	function getOrdersDetails($orderNo,$id){
  	      
		$res= $this->db->get_where('orders',array('OrderNumber'=>$orderNo))->result_array();
    	
		$date='';
		if($res[0]['expectedDispatchDate']!=""){
			$order_date = date('Y-m-d',$res[0]['expectedDispatchDate']);
			$order_date = strtotime($order_date);
      	  
			$date = strtotime( '+2 day', $order_date);
        
			$up['exp_collectionDate'] = $date;
            
			if($id){
				$this->db->where('ticket_id',$id);
				$this->db->update('tickets',$up);
			}
           
		}
		return $date;
	}
    
	function creatCreditNote($id){
		$order_id = $this->getOrderDetails($id);
		$res = $this->createCreditRow($order_id,$id);
		$ticket_details = $this->getTicketDetails($id);
        
		$des = $this->copyCreditDetailsRow($ticket_details,$id);
		//$this->ticketClosed($id);
	}
    
    
	function createCreditRow($order_id,$id){
        
		 $this->db->query("CREATE TEMPORARY TABLE temp_table AS SELECT 
     OrderID,Label,picking,editing,OrderNumber,additional_check,SessionID,OrderDate,OrderTime,UserID,designer,assigny,DeliveryStatus,OrderDeliveryCourier,DeliveryTrackingNumber,PaymentMethods,DispatchedDate,DispatchedTime,HowDidYouHearAboutUs,OrderLines,OrderShippingAmount,OrderTotal,OrderTotalWeight,TrackingIP,TrackingReferralURL,PurchaseOrderNumber,BillingTitle,SecondaryEmail,BillingFirstName,BillingLastName,BillingCompanyName,BillingAddress1,BillingAddress2,BillingTownCity,BillingCountyState,BillingPostcode,BillingCountry,Billingtelephone,BillingMobile,Billingfax,Billingemail,BillingResCom,DeliveryTitle,DeliveryFirstName,DeliveryLastName,DeliveryCompanyName,DeliveryAddress1,DeliveryAddress2,DeliveryTownCity,DeliveryCountyState,DeliveryPostcode,DeliveryCountry,Deliverytelephone,DeliveryMobile,Deliveryfax,Deliveryemail,DeliveryResCom,Registered,OrderComments,ReturnComments,OrderStatus,Old_OrderStatus,ShippingServiceID,ServiceID,courier_id,ReturnTotal,ProcessedBy,printPicked,StockReport,OpenOrder,manifest_date,PackID,YourRef,ContactPerson,ExportedToSage,CustomOrder,Production,ProductionCompleted,Source,Payment,typeold,prevOrder,DiscountRate,DiscountedPrice,DiscountInPounds,Domain,M2HOrderNumber,voucherOfferd,voucherDiscount,vat_exempt,currency,exchange_rate,po_attachment,site,format,OperatorID,callback_status,reference_no,pieces,weight,type,consign,CallbackDate,expectedDispatchDate,is_archive,is_upload,pod_image,pod_user_name,PaymentType,PaymentDate,BankName,Account,Cheque,order_type FROM orders WHERE OrderID='".$order_id."'");
		
		
		
		
        
		$this->db->query("ALTER TABLE temp_table ADD COLUMN  cr_id BIGINT(50) FIRST") ;
		$this->db->query("ALTER TABLE temp_table ADD COLUMN  ticketID BIGINT(50) AFTER cr_id");
		$this->db->query("UPDATE temp_table SET cr_id=NULL, ticketID='".$id."'  WHERE OrderID='".$order_id."'");
        
					
		/*$res = $this->db->query("SELECT * FROM temp_table")->result_Array();
		$ccccc = $this->db->query("SELECT * from credit_notes")->result_array();
		
		$on = array();
		$to = array();
		foreach($res[0] as $one => $key){
			array_push($on,$one); 
			
		}
		
		foreach($ccccc[0] as $two => $key){
			array_push($to,$two); 
			
		}
			
		
			echo '<pre>'; print_r(count($on)); echo '</pre>';
		echo '<pre>'; print_r(count($to)); echo '</pre>';
		
		echo '<pre>'; print_r($on); echo '</pre>';
		echo '<pre>'; print_r($to); echo '</pre>';
		
		$resultw = array_diff($on,$to);
			
			exit;*/
	
   
        $this->db->query("INSERT INTO credit_notes SELECT * FROM temp_table");
        $this->db->query("DROP TEMPORARY TABLE temp_table");
        //return $res;
		
	}
    
    
	function getOrderTotal($id){
		$q = "select ROUND(sum(ticket_details.returnUnitPrice),2) as total_amount from ticket_details where ticket_details.ticket_id='".$id."'"; 
	}
    
    
	function copyCreditDetailsRow($ticket_details,$id){
        
		foreach($ticket_details as $td){
            
			$SR = $td['SerialNumber'];
			$qty = $td['returnQty'];
			$Wovat = $td['returnUnitPrice'];
			$Wvat = $td['returnPrice'];
            
			$this->db->query("CREATE TEMPORARY TABLE temp_tables AS SELECT 
            SerialNumber,OrderNumber,UserID,ProductID,labels,ManufactureID,ProductName,Product_detail,Quantity,LabelsPerRoll,is_custom,ProductOption,ProductionOptionDate,Price,ProductTotalVAT,ProductTotal,ProductQuantityShipped,ProductQuantityBackOrdered,Linescompleted,ProductWeight,Returnrequesttime,ReturnReason,Returnstatus,ReturnComments,ReturnDispatchedTime,ReturnOrderDeliveryCourier,ReturnDeliveryTrackingNumber,PackedQuantity,ReturnQuantity,CustomQuoteNumber,Production,CustomLabelID,ProductionStatus,is_stock,PrintingStatus,old_product,Printing,Print_Type,FinishType,Print_Design,Print_Qty,Free,Print_UnitPrice,Print_Total,user_project_id,Prl_id,machine,eta_time,qc_status,qc_id,scope,source,colorcode,custom_pdf,custom_thumb,Wound,Orientation,Distortion,CuttingEdge,repeat_length,label_per_frame,width_reg,pressproof,design_service,design_service_charge,design_file,qc_print,page_location,regmark
            
            FROM orderdetails WHERE SerialNumber='".$SR."'");
            
			$this->db->query("ALTER TABLE temp_tables ADD COLUMN  cr_details_id BIGINT(50) FIRST") ;
			$this->db->query("ALTER TABLE temp_tables ADD COLUMN  ticketID BIGINT(50) AFTER cr_details_id");
            
			$this->db->query("UPDATE temp_tables SET cr_details_id=NULL, ticketID='".$id."', Price='".$Wovat."',ProductTotal='".$Wvat."',Quantity='".$qty."' WHERE SerialNumber='".$SR."'");
			
			
			
		/*$res = $this->db->query("SELECT * FROM temp_tables")->result_Array();
		$ccccc = $this->db->query("SELECT * from credit_details ")->result_array();
	
		
		$on = array();
		$to = array();
		foreach($res[0] as $one => $key){
			array_push($on,$one); 
			
		}
		
		foreach($ccccc[0] as $two => $key){
			array_push($to,$two); 
			
		}
			
			echo '<pre>'; print_r(count($on)); echo '</pre>';
		echo '<pre>'; print_r(count($to)); echo '</pre>';
		
		echo '<pre>'; print_r($on); echo '</pre>';
		echo '<pre>'; print_r($to); echo '</pre>';
		
		$resultw = array_diff($on,$to);
			
			exit;*/
            
			$this->db->query("INSERT INTO credit_details SELECT * FROM temp_tables");
			$this->db->query("DROP TEMPORARY TABLE temp_tables");
	}
}
    
    
	function ticketClosed($id){
		$close_date = date('Y-m-d');
		$order_data['ticketStatus'] =  4;
		$order_data['closed_date'] =  $close_date;
        
		if($id){
			$this->db->where('ticket_id',$id);
			$this->db->update('tickets',$order_data);
		}
        
	}
    
    
	function getRefferppl(){
		$res = $this->db->get_where('customers',array('IsReffTicket'=>true))->result_array();
		return $res;
        
	}
    
	public function getShipingService($conID){
		$sql = $this->db->query("select * from shippingservices where CountryID='".$conID."' or CountryID='0' order by ServiceID ASc ");
		$service = $sql->result_array();

		return $service;
	}
    
	public function refuseTicket($id){
        
		if($id){
		    $data['closed_date'] =  date('Y-m-d');
			$data['ticketStatus'] = 4;
			$this->db->where('ticket_id',$id);
			$this->db->update('tickets',$data);
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
	
	function CopyOrderRow2($id)
{
	$order_id = $this->getOrderDetails($id);
	$this->db->last_query();
		
	$order= $this->db->query("SELECT * FROM orders WHERE OrderID='".$order_id."'")->result();
	$OrdNo = $this->getOrderNum();
	$orderNo = 'AA'.$OrdNo;

	$insert = array(
		'OrderNumber'   		=> 	$orderNo,
		'SessionID'     		=>	$this->session->userdata('session_id'),
		'OrderDate'    	 		=>  time(),
		'OrderTime'     		=>  time(),
		'UserID'        		=>  $order[0]->UserID,
		'DeliveryStatus' 		=>	'',
		'PaymentMethods'    	=>	$order[0]->PaymentMethods,
		'OrderShippingAmount' 	=>	'0.00',
		'OrderTotal'          	=> 	'0.00',
		'BillingTitle'        	=>	$order[0]->BillingTitle,
		'BillingFirstName'    	=>	$order[0]->BillingFirstName,
		'BillingLastName'     	=>	$order[0]->BillingLastName,
		'BillingCompanyName'  	=>	$order[0]->BillingCompanyName,
		'BillingAddress1'     	=>	$order[0]->BillingAddress1,
		'BillingAddress2'     	=>	$order[0]->BillingAddress2,
		'BillingTownCity'     	=>	$order[0]->BillingTownCity,
		'BillingCountyState'  	=>	$order[0]->BillingCountyState,
		'BillingPostcode'    	=>	$order[0]->BillingPostcode,
		'BillingCountry'     	=>	$order[0]->BillingCountry,
		'Billingtelephone'   	=>	$order[0]->Billingtelephone,
		'Billingmobile'      	=>	$order[0]->BillingMobile,
		'Billingfax'         	=>	$order[0]->Billingfax,
		'SecondaryEmail'     	=>	$order[0]->SecondaryEmail,
		'Billingemail'       	=>	$order[0]->Billingemail,
		'BillingResCom'			=>	$order[0]->BillingResCom,
		'DeliveryTitle'      	=>	$order[0]->DeliveryTitle,
		'DeliveryFirstName'     =>	$order[0]->DeliveryFirstName,
		'DeliveryLastName'      =>	$order[0]->DeliveryLastName,
		'DeliveryCompanyName'   =>	$order[0]->DeliveryCompanyName,
		'DeliveryAddress1'      =>	$order[0]->DeliveryAddress1,
		'DeliveryAddress2'   	=>	$order[0]->DeliveryAddress2,
		'DeliveryTownCity'    	=>	$order[0]->DeliveryTownCity,
		'DeliveryCountyState'   =>	$order[0]->DeliveryCountyState,
		'DeliveryPostcode'      =>	$order[0]->DeliveryPostcode,
		'DeliveryCountry'   	=>	$order[0]->DeliveryCountry,
		'Deliverytelephone'   	=>	$order[0]->Deliverytelephone,
		'DeliveryMobile'   	  	=>	$order[0]->DeliveryMobile,
		'Deliveryfax'   	  	=>	$order[0]->Deliveryfax,
		'Deliveryemail'   		=>	$order[0]->Deliveryemail,
		'DeliveryResCom'		=>	$order[0]->DeliveryResCom,
		'Registered'            =>	'Yes',
		'CustomOrder'       	=>	$order[0]->CustomOrder,
		'ShippingServiceID'  	=>	$order[0]->ShippingServiceID,
		'printPicked'       	=>	'No',
		'PurchaseOrderNumber'   =>	'',
		'YourRef'   			=>	'',
		'PackID'    			=>	'',
		'Domain'         		=>	'backoffice',
		'vat_exempt'	 		=>	$order[0]->vat_exempt,
		'currency'	     		=>	$order[0]->currency,
		'exchange_rate'	 		=>	$order[0]->exchange_rate,
		'ContactPerson'  		=>	$order[0]->UserID,
		'OrderStatus'    		=>	'32',
		'Label'    				=>	$order[0]->Label,
		'site'    				=>	$order[0]->site,
		'voucherOfferd'  		=> 	'No',
		'voucherDiscount'		=>	'0.00');
			
	$this->db->insert('orders',$insert);
	$order_detail = $this->getTicketDetailsObject($id);
				 
		
	foreach($order_detail as $order_detail){
		$insert_detail= array(
			'OrderNumber'   	 =>	$orderNo,
			'UserID'   	 		 =>	$order_detail->UserID,
			'labels' 			 => $order_detail->labels,
			'ProductID'   	 	 =>	$order_detail->ProductID,
			'ManufactureID'  	 => $order_detail->ManufactureID,
			'ProductName'   	 =>	$order_detail->ProductName,
			'Quantity'   	 	 =>	$order_detail->returnQty,
			'LabelsPerRoll'		 => $order_detail->LabelsPerRoll,
			'is_custom'			 => $order_detail->is_custom,
			'Price'   	 		 =>	'0.00',
			'ProductTotalVAT' 	 =>	'0.00',
			'ProductTotal'   	 =>	'0.00',
			'Printing'			 => $order_detail->Printing,
			'Print_Type'		 => $order_detail->Print_Type,
			'Print_Design'		 => $order_detail->Print_Design,
			'Print_Qty'			 => $order_detail->Print_Qty,
			'Free'				 => $order_detail->Free,
			'Print_UnitPrice'	 => '0.00',
			'Print_Total'		 => '0.00',
			'Prl_id'			 =>	$order_detail->Prl_id,
			'colorcode'			 =>	$order_detail->colorcode,
			'Wound'				 =>	$order_detail->Wound,
			'Orientation'		 =>	$order_detail->Orientation,
			'pressproof'		 =>	$order_detail->pressproof,
			'FinishType'		 =>	$order_detail->FinishType,
			'Product_detail'	 =>	$order_detail->Product_detail,
			'design_service'	 =>	$order_detail->design_service,
			'design_service_charge'	=>$order_detail->design_service_charge,
			'design_file'		 =>	$order_detail->design_file,
			'regmark'			 =>	$order_detail->regmark,
			'sample'			 =>	$order_detail->sample,
		);

		$this->db->insert('orderdetails',$insert_detail);
		$order_serail = $this->db->insert_id();
        
		$artowrks = $this->db->get_where('order_attachments_integrated',array('Serial'=>$order_detail->OrRowSerialNumber))->result();
		if(count($artowrks) > 0){
			foreach($artowrks  as $int_row){
				$attach_array = array(
					'UserID'=>$order_detail->UserID,
					'OrderNumber'=>$orderNo,
					'Serial'=>$order_serail,
					'ProductID'=>$int_row->ProductID,
					'diecode'=>$int_row->diecode,
					'file'=>$int_row->file,
					'status'=>64,
					'Brand'=>$int_row->Brand,
					'source'=>$int_row->source,
					'design_type'=>$int_row->design_type,
					'qty'=>$int_row->qty,
					'labels'=>$int_row->labels,
					'name'=>$int_row->name,
					'CO' =>$int_row->CO,
					'version' =>1);
				$this->db->insert('order_attachments_integrated',$attach_array);
			}
		}
	 }
  }
	
	
function getTicketDetailsObject($id){
		
	$query = "select sc.ID as 	Country_id,od.*,o.OrderID,o.BillingFirstName, o.BillingLastName, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, o.BillingPostcode, o.BillingCountry,o.Billingtelephone,o.Billingemail,concat(o.BillingAddress1,',', o.BillingPostcode) as address,o.currency,td.*,td.SerialNumber as OrRowSerialNumber from ticket_details as td
	inner join orders as o on  o.OrderNumber=td.orderNumber
	left join shippingcountries as sc on sc.name=o.DeliveryCountry
	inner join orderdetails as od on od.SerialNumber=td.SerialNumber
	where td.ticket_id='".$id."'"; 
	return $this->db->query($query)->result();
}
	



	
}




