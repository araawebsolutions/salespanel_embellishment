<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class SettingModel extends CI_Model {
	
	function __construct(){
		parent::__construct();      
	}
	
	
	//******************************************************************************************************************************
	
	 function getAmendmentSettings(){
	  return $this->db->query(" select * from order_setting order by ID asc")->result_array(); 
	 }
	
	function updateAmendmentSettings($options = array()){
		extract($options);
		$update_setting_query = $this->db->query("update order_setting set ".$field." = ".$setting." where ID = $ID "); 
		if($this->db->affected_rows() > 0){
		 echo  TRUE;
		}else{
		 echo FALSE;
		}
	}
	
	//******************************************************************************************************************************
	
	 function update_line($serailnumber,$update){
		$this->db->where('SerialNumber',$serailnumber);
		$this->db->update('orderdetails', $update); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;	
     }
  
	//******************************************************************************************************************************


	function get_printed_files($serial, $ProductID){
	  $q = $this->db->query(" select * from order_attachments_integrated WHERE ProductID =$ProductID AND 
	  Serial=$serial ORDER BY ID ASC ");
	  return $q->result(); 
	}
	
	function getdesigntotal($serial){
		 
		 $row  = $this->db->select('Print_Qty')
		 ->where('SerialNumber',$serial)
		 ->get('orderdetails');
		 $row = $row->row_array();
		 return $row['Print_Qty'];
   }
   
   function get_labels_and_brand_from_cart($id){
		$row = $this->db->query(" SELECT products.LabelsPerSheet FROM `orderdetails`
		INNER JOIN products ON products.`ProductID` = `orderdetails`.`ProductID` WHERE orderdetails.SerialNumber = $id ")->row_array();
		if(isset($row['LabelsPerSheet']) and $row['LabelsPerSheet']!=''){
			return $row['LabelsPerSheet'];
		}else{
			return 0;
		}
	}
 
   function update_order_total($ordernumber){

	  if(isset($ordernumber) && $ordernumber!='' && $ordernumber!= '0'){   
	    
	    $ordercheck = $this->OrderInfo($ordernumber); 
          
	    if(isset($ordercheck[0]->OrderNumber) && $ordercheck[0]->OrderNumber!=""){  
	      
	     $query = $this->db->query("select SUM(Price+Print_Total) as total from orderdetails where OrderNumber LIKE '".$ordernumber."' ")->row_array();
		 $total = $query['total']*1.2;
		 $total = number_format($total,2,'.','');

		   $shiptotal = $this->calculate_shipping($ordernumber,0,$total); 
		   
		     // discount section<br />
		    $orderInfo1 = $this->OrderInfo($ordernumber);
            if($orderInfo1[0]->voucherOfferd =='Yes'){
			 $total = $total - $orderInfo1[0]->voucherDiscount;
			}
			
			
			// AA21 STARTS
             $query = $this->db->query("Select DeliveryPostcode, OrderDeliveryCourier, DeliveryCountry from orders WHERE OrderNumber = '".$ordernumber."' ");
             $row = $query->row_array();
             if( (isset($row['DeliveryPostcode']) && $row['DeliveryPostcode'] != '') && (isset($row['DeliveryCountry']) && $row['DeliveryCountry'] != '') )
             {
                $D_postcode = $row['DeliveryPostcode'];
                $deliveryCourier = $row['OrderDeliveryCourier'];
                $DeliveryCountry = $row['DeliveryCountry'];
                $offshore = $this->product_model->offshore_delviery_charges_WPC($D_postcode, $DeliveryCountry); 


                if( ($offshore['status'] != true) && ($DeliveryCountry == 'United Kingdom') && ($shiptotal > 0) && ($deliveryCourier == 'DPD') )
                {
                    $shiptotal = $shiptotal + 1;
                }
             }

             // $shiptotal = $shiptotal * vat_rate;
            // AA21 ENDS
            
            
		  
		   $array = array('OrderTotal'=>$total,'OrderShippingAmount'=>$shiptotal,'method'=>'update_order_total','loginuser'=>$this->session->userdata('UserName'),'runtime'=>date('Y-m-d H:i:s'));	
		   $this->db->where('OrderNumber',$ordernumber);
		   $this->db->update('orders',$array);

		   // VAT EXEMPT & SYMBOL
		   $finaltotal = $total+$shiptotal;

		   $orderInfo = $this->OrderInfo($ordernumber);
		   $finaltotal = ($orderInfo[0]->vat_exempt=="yes")?$finaltotal/1.2:$finaltotal;
		   $symbol = $this->home_model->get_currecy_symbol( $orderInfo[0]->currency);
		   $finaltotal =  $symbol."".(number_format($finaltotal* $orderInfo[0]->exchange_rate,2,'.',''));
								   
		   $this->add_activity("Order Total updated to ".$finaltotal,$ordernumber,'---','');
	    }  
	  } 
	   
	  // $this->settingmodel->add_logs('order_total','',$total+$shiptotal,$ordernumber,'');
  }
    public function OrderInfo($orderID) {
        if(empty($orderID)){

            $orderID = end($this->uri->segments);

        }

        $query = $this->db->get_where('orders', array('OrderNumber' => $orderID));

        return $query->result();

    }
   function calculate_shipping($ordernumber,$service=NULL,$ordertotal=NULL){

	   $shiptotal = $delivery = 0;
	   $orderInfo = $this->OrderInfo($ordernumber);
	   $delivery_country = $orderInfo[0]->DeliveryCountry;
	   $service = (isset($service) && $service!=0)?$service:$orderInfo[0]->ShippingServiceID;

	   if($delivery_country == 'United Kingdom'){
		   if($ordertotal < 25 && $service==20){
			$service = 19;
		   }
	     $result = $this->db->query("select BasicCharges from shippingservices where ServiceID = '".$service."'")->row_array(); 
		 $delivery = $result['BasicCharges'];
	   }else{
	     $result = $this->db->query("select charges, freeorder_over, additional_charge from shippingcountries where name = '".$delivery_country."'")->row_array(); 
		   if(!empty($result)){
		     $delivery = ($ordertotal > $result['freeorder_over'])?0.00:$result['charges'] + $result['additional_charge'];
		   }
	   }
	   
	  //***//*****************//********//********
	   $delivery = ($service==11 || $service==33)?0.00:number_format($delivery,2);
	  //***//*****************//********//********

	  $integrated = $this->is_order_integrated($ordernumber);

	  if($integrated > 0){
	   $shiptotal = $this->delivery_order_integrated($ordernumber);	  
	  }

	 $shipping_total = 	$shiptotal + $delivery;
     return $shipping_total;
   }
  
   //************************************//**************************************//	
		
	 // function delivery_order_integrated($ordernumber){
//		 $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `orderdetails` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and OrderNumber LIKE '".$ordernumber."' ")->row_array();
//	
//	        $country_code = $this->home_model->get_db_column('orders','DeliveryCountry', 'OrderNumber', $ordernumber);
//
//			$dpd = $this->quoteModel->get_integrated_delivery($int_sheets['qty'],$country_code);
//
//			$dpd = $dpd['dpd'];
//			$productid = $int_sheets['ProductID'];
//			$intdata['BasicCharges'] += $dpd;
//			if($int_sheets['qty'] == '' || $int_sheets['ProductID'] == ''){
//			  $intdata['BasicCharges'] -= $dpd;
//			}
//			
//			  $delivery_exvat  = $delivery_exvat  + $intdata['BasicCharges'];
//			  $delivery_incvat = $delivery_exvat*1.2;
//		      return $delivery_incvat;
//	 }


       function delivery_order_integrated($ordernumber){
		 $delivery_exvat = 0;
		 $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `orderdetails` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and OrderNumber LIKE '".$ordernumber."' ")->row_array();
	
	        $country_code = $this->home_model->get_db_column('orders','DeliveryCountry', 'OrderNumber', $ordernumber);

			$dpd = $this->quoteModel->get_integrated_delivery($int_sheets['qty'],$country_code);

			$dpd = $dpd['dpd'];
		    $intdata = 0;
			$productid = $int_sheets['ProductID'];
			$intdata += $dpd;
			if($int_sheets['qty'] == '' || $int_sheets['ProductID'] == ''){
			  $intdata -= $dpd;
			}
			
			  $delivery_exvat  = $delivery_exvat  + $intdata;
			  $delivery_incvat = $delivery_exvat*1.2;
		      return $delivery_incvat;
	 }
	
	 function is_order_integrated($ordernumber){
		$result = $this->db->query("select COUNT(*) as total from orderdetails temp JOIN products pro on temp.ProductID = pro.ProductID WHERE temp.OrderNumber LIKE '".$ordernumber."' AND pro.ProductBrand = 'Integrated Labels'");
		$row = $result->row_array();
		return $row['total'];
	}
	
	  //************************************//**************************************//
	
	

  
  function get_orderEdit_logs($orderno){
			$query  = $this->db->query("select *,DATE_FORMAT(datetime,'%d-%m-%Y %h:%i %p') as log_date from order_edit_logs where order_number = '".$orderno."' ORDER BY id DESC ");
			return $query->result();	
	}

  function payment_recieved($ordernumber){
   $query = $this->db->query("select SUM(payment) as total from order_payment_log where OrderNumber LIKE '".$ordernumber."' and situation LIKE 'taken' ")->row_array();
   return $query['total'];
  }
   function payment_refunded($ordernumber){
   $query = $this->db->query("select SUM(payment) as total from order_payment_log where OrderNumber LIKE '".$ordernumber."' and situation LIKE 'refund' ")->row_array();
   return $query['total'];
  }
  
   function payments_log($ordernumber){
    return $this->db->query("select * from order_payment_log where OrderNumber LIKE '".$ordernumber."' order by ID desc ")->result();
  }
	
		
   // *******************************************PERMISSIONS MODULE*************************************************
		
	function add_logs($case, $parameter1, $parameter2,$OrderNumber, $serail_number = NULL){
		$extra_info = '';
		$linedetails = $this->db->query("select * from orderdetails where SerialNumber = '".$serail_number."' ")->row_array();
		if($OrderNumber ==null || $OrderNumber ==""){
			$OrderNumber = $linedetails['OrderNumber'];
		}

		$ManufactureID = $linedetails['ManufactureID'];
		
		if($case == 'diecode_changed'){
		    $message = $parameter1. " Changed to ".$parameter2;
		}
		else if($case == 'quantity_changed'){
		    $message = $ManufactureID."Roll Quantity Changed From <b> ".$parameter1." </b> to <b> ".$parameter2." </b>";
		}
		else if($case == 'labels_changed'){
		    $message = $ManufactureID." Labels Quantity Changed From <b> ".$parameter1." </b> to <b> ".$parameter2." </b>";
		}
		else if($case == 'Delivery_changed'){
			$message = "Order Delivery Service has Changed From <b> ".$parameter1." </b> to <b> ".$parameter2." </b>";
		}
		else if($case == 'line_changed'){
		   $message = $ManufactureID." Changed From <b>".$parameter1."</b> to <b>".$parameter2."</b>";
		}
		else if($case == 'print_charges'){
		   $message = $ManufactureID." Changed to <b>".$parameter1."</b>";
		}
		else if($case == 'print_delete'){
		   $message = $ManufactureID." changed from Printed to Plain";
		}
		else if($case == 'order_total'){
		   $message = "Order Total updated to ".$parameter2;
		}
		else if($case == 'line_updated'){
		  $message = "Line information updated to ".$parameter1;
		  $extra_info = $parameter1;
		}
		else if($case == 'removed_stock'){
		  $message = $ManufactureID." has been removed from stock and stock is adjusted , Order status Changed to Pending Prodcution.";
		
		}else if($case == 'line_deleted'){
		  $message = $ManufactureID." has been deleted from this order.";
		}
		else if($case == 'plain_to_print'){
			$message = $ManufactureID." Print Type change.";
		}
		else if($case == 'line_added'){
			$message = $ManufactureID." added to the order.";
		}
		else if($case == 'Orientation' || $case == 'Wound'){
			$message = $ManufactureID." - ".$case." updated to ".$parameter1;
		}
		else if($case == 'zero_delivery'){
			$message = "Zero Down Delivery Charges";
		}
		else if($case == 'changeorderlabel'){
			$ordertype = ($parameter1==1)?"Plain Cover Order":"Standard Order";
			$message = "Order Type changed to ".$ordertype;
		}
	
		$this->add_activity($message,$OrderNumber,$serail_number,$extra_info);
	    //$this->email_to_kiran($OrderNumber,$message);
	
	}
	
  public function add_activity($message,$OrderNumber,$serail_number,$extra_info){
	$operator_name = $this->session->userdata('UserName');
	$time = date('Y-m-d H:i:s');
	
	 $options = array(
	   'operator_name'=>$operator_name,
	   'message'=>$message,
	   'datetime'=>$time,
	   'order_number'=>$OrderNumber,
	   'serial_number'=>$serail_number,
	   'extra_info'=>$extra_info
	   );
	   
	  $this->db->insert('order_edit_logs',$options);
  }	
  
    public function email_to_kiran($orderNumber,$message)
	{
		$this->load->library('email');
	 	$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject('Order Edited - '.$orderNumber);
		$this->email->from('customercare@aalabels.com','Aalabels');
	 	$this->email->to("kiran@aalabels.com");
		//$this->email->to("kami.ramzan77@gmail.com"); 
		//$this->email->bcc("kami.ramzan77@gmail.com");
		$this->email->message($message); 
		$this->email->send();  
	}
	
	
  
   // *******************************************PERMISSIONS MODULE*************************************************

  
  function get_permissions($id){
   return $this->db->query("select * from order_setting where ID = $id")->row_array();
  }
  function check_artwork($serial){
   $row = $this->db->query("select count(*) as total from order_attachments_integrated where Serial = $serial")->row_array();
   return ($row['total']==0)?1:0;
  }
  function check_allocation($serial){
   $row = $this->db->query("select * from production_sequence where SerialNumber = $serial")->row_array();
   return (empty($row) || $row['squence']>6)?1:0;
  }
  function check_allocation_roll($serial){
   $row = $this->db->query("select * from production_sequence where SerialNumber = $serial")->row_array();
   return (empty($row))?1:0;
  }
   function check_order_allocation($ordernumber,$SerialNumber){
    $row = $this->db->query("select * from orderdetails where OrderNumber LIKE  '".$ordernumber."' and SerialNumber != '$SerialNumber' ")->result();
    $allow = 0;
    if(count($row)==0){ $allow = 1;}
    foreach($row as $rowp){
	  $check = $this->check_allocation($rowp->SerialNumber);
	  if($check==1){ $allow = 0; }
	}
	return $allow;
  }
  
 function check_order_roll_allocation($ordernumber,$SerialNumber){
   $row = $this->db->query("select * from orderdetails where OrderNumber LIKE  '".$ordernumber."' and SerialNumber != '$SerialNumber' ")->result();
   $allow = 0;
   if(count($row)==0){ $allow = 1;}
    foreach($row as $rowp){
	  $check = $this->check_allocation_roll($rowp->SerialNumber);
	  if($check==1){ $allow = 0; }
	}
	return $allow;
  }
  
   function checkpermissions($serial,$productdetails,$orderstatus,$editcheck){
    $linedetails = $this->db->query("select * from orderdetails where SerialNumber = $serial")->row_array();
	   $order_data = $this->db->select('picking_status')
		   ->where('OrderNumber', $linedetails['OrderNumber'])
		   ->get('orders')
		   ->row();

   if(($linedetails['ProductionStatus']==3 && $order_data->picking_status == 1) || $orderstatus==7 || $orderstatus==33 || $orderstatus==8 || $orderstatus==27 || $linedetails['ManufactureID']=='SCO1' || $linedetails['ProductionStatus']==10 || $linedetails['ProductionStatus']==11 || $linedetails['ProductionStatus']==12 || $linedetails['source']=="LBA"  || $editcheck=="no"){
	 
	 $allow_die_change = $allow_mat_change = $allow_qty_change = $allow_remove_product = $allow_add_remove_print = $allow_add_remove_artwork = 0;

   }else if($orderstatus==6){
  
    $allow_die_change = $allow_mat_change = $allow_qty_change = $allow_remove_product = $allow_add_remove_print = $allow_add_remove_artwork = 1;
  
  }else if($productdetails['ProductID']==0){
  
    if($orderstatus==2 || $orderstatus==32){
	  $allow_die_change = $allow_mat_change = $allow_qty_change = $allow_remove_product = $allow_add_remove_print = $allow_add_remove_artwork = 0;
    }else{
      $get_permissions          = $this->get_permissions(5);
	  $allow_die_change         = ($get_permissions['die']==1)?1:0;
	  $allow_mat_change         = ($get_permissions['mat']==1)?1:0;
	  $allow_qty_change         = ($get_permissions['qty']==1)?1:0;
	  $allow_remove_product     = ($get_permissions['add_rem_pro']==1)?1:0;
	  $allow_add_remove_print   = $allow_add_remove_artwork = 0;
	}
   }else if(preg_match('/Roll Labels/is',$productdetails['ProductBrand'])){
     if($linedetails['Printing']=="Y"){
	  $get_permissions          = $this->get_permissions(4);
	  $allow_die_change         = ($get_permissions['die']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?1:0;
	  $allow_mat_change         = ($get_permissions['mat']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?1:0;
	  $allow_qty_change         = ($get_permissions['qty']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?1:0;
	  $allow_remove_product     = ($get_permissions['add_rem_pro']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?$this->check_artwork($serial):0;
	  $allow_add_remove_print   = ($get_permissions['add_rem_prnt']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?1:0;
	  $allow_add_remove_artwork = ($get_permissions['add_rem_art']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?$this->check_artwork($serial):0;
	}else{
	  $get_permissions          = $this->get_permissions(2);
	  $allow_die_change         = ($get_permissions['die']==1)?$this->check_allocation_roll($serial):0;
	  $allow_mat_change         = ($get_permissions['mat']==1)?$this->check_allocation_roll($serial):0;
	  $allow_qty_change         = ($get_permissions['qty']==1)?$this->check_allocation_roll($serial):0;
	  $allow_remove_product     = ($get_permissions['add_rem_pro']==1)?$this->check_allocation_roll($serial):0;
	  $allow_add_remove_print   = $this->check_order_roll_allocation($linedetails['OrderNumber'],$serial);  $allow_add_remove_artwork = 0;
	}
 
  }else{
    if($linedetails['Printing']=="Y"){
	  $get_permissions          = $this->get_permissions(3);
	  $allow_die_change         = ($get_permissions['die']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?1:0;
	  $allow_mat_change         = ($get_permissions['mat']==1)?$this->check_allocation($serial):0;
	  $allow_qty_change         = ($get_permissions['qty']==1)?$this->check_allocation($serial):0;
	  $allow_remove_product     = ($get_permissions['add_rem_pro']==1  && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?$this->check_artwork($serial):0;
	  $allow_add_remove_print   = ($get_permissions['add_rem_prnt']==1 && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?1:0;
	  $allow_add_remove_artwork = ($get_permissions['add_rem_art']==1  && ($orderstatus==55 || $orderstatus==6 || $orderstatus==78))?$this->check_artwork($serial):0;
	}else{
	  $get_permissions          = $this->get_permissions(1);
	  $allow_die_change         = ($get_permissions['die']==1)?$this->check_allocation($serial):0;
	  $allow_mat_change         = ($get_permissions['mat']==1)?$this->check_allocation($serial):0;
	  $allow_qty_change         = ($get_permissions['qty']==1)?$this->check_allocation($serial):0;
	  $allow_remove_product     = ($get_permissions['add_rem_pro']==1)?$this->check_allocation($serial):0;
	  $allow_add_remove_print   = $this->check_order_allocation($linedetails['OrderNumber'],$serial); $allow_add_remove_artwork = 0;
	}
  }
          
			$array =  array('die'=>$allow_die_change,'mat'=>$allow_mat_change,'qty'=>$allow_qty_change,'add_rem_pro'=>$allow_remove_product,'add_rem_prnt' =>$allow_add_remove_print,'add_rem_art'=>$allow_add_remove_artwork); 
			  //echo "<pre>"; print_r($array);
			   return $array;
  }



  function adjust_stock_level($serial,$ordernumber){
     $stock = $this->db->query("select * from stock_produced where serial_no = $serial")->result();
	  foreach($stock as $row){
		 $barcode = $this->db->query("select * from stock where barcode LIKE '".$row->barcode."'")->row_array();
	     if($row->dispatch==1){
			 $newqty = $barcode['qty'] + $row->qty;
		     $array = (array('qty'=>$newqty));
		 }else{
			 $newqty = $barcode['qty'] + $row->qty;  $newalloc = $barcode['allocated'] - $row->qty;
		     $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
		 }
		 $this->db->where('barcode',$row->barcode);
		 $this->db->update('stock',$array);
	   }
	      $where = "serial_no = '$serial'";
		  $this->db->where($where);
		  $this->db->delete('stock_produced'); 
		  
		  $this->db->where('SerialNumber',$serial);
		  $this->db->update('orderdetails',array('ProductionStatus'=>1,'is_stock'=>2)); 
		  
		   $qry = $this->db->query("select count(*) as total from orderdetails where OrderNumber LIKE  '".$ordernumber."' and is_stock = 1 ")->row_array();
		   
	      $picking = ($qry['total']==0)?0:1;
		  $this->db->where('OrderNumber',$ordernumber);
		  $this->db->update('orders',array('OrderStatus'=>32,'picking'=>$picking)); 
		  
		  $this->add_logs('removed_stock',$stock[0]->manufactureid,'',$ordernumber,$serial);
		  echo 'updated';
	}
	
	
	public function email_to_kiran_and_umer($orderNumber,$message){

	$this->load->library('email');
    $this->email->initialize(array('mailtype' =>'html',));
    $this->email->subject('On Hold Notification - '.$orderNumber);
    $this->email->from('customercare@aalabels.com','AAlabels');
    
    $emails = array('kiran@aalabels.com', 'umer@aalabels.com');
    //$emails = array('shoaib.aalabels@gmail.com', 'waqar.aalabels@gmail.com');
    $this->email->to($emails);
    
    
    $this->email->message($message); 
    $this->email->send();  
}
  

}

?>
