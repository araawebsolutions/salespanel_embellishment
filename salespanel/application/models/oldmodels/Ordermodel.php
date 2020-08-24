<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Ordermodel extends CI_Model {


  
    public function showCustomLabel($limit, $offset) {



        if ($offset) {



            $this->db->select('*');

            $this->db->from('orders');

            $this->db->join('orderdetails', "orders.OrderNumber = orderdetails.OrderNumber  ");

            $this->db->join('dropshipstatusmanager', "orders.OrderStatus = dropshipstatusmanager.StatusID where orders.BillingFirstName != '0' and orders.PaymentMethods!='SampleOrder' ");

            $this->db->limit($limit, $offset);

            $this->db->order_by("OrderID", "desc");

            $query = $this->db->get();

        } else {

            $this->db->select('*');

            $this->db->from('orders');

            $this->db->join('orderdetails', "orders.OrderNumber = orderdetails.OrderNumber");

            $this->db->join('dropshipstatusmanager', "orders.OrderStatus = dropshipstatusmanager.StatusID where orders.BillingFirstName != '0' and orders.PaymentMethods!='SampleOrder'");



            $this->db->limit($limit);

            $this->db->order_by("OrderID", "desc");

            $query = $this->db->get();

        }



        return $query->result();

    }



    public function ordersLoad() {

        $search = $_POST['search'];

        $this->db->select('*');

        $this->db->from('orders');

        $this->db->join('orderdetails', "orders.OrderNumber = orderdetails.OrderNumber");

        $this->db->join('dropshipstatusmanager', "orders.OrderStatus = dropshipstatusmanager.StatusID where orders.BillingFirstName != '0' and orders.PaymentMethods!='SampleOrder' and orders.BillingFirstName LIKE '" . '%' . $search . '%' . "'");

        $this->db->order_by("OrderID", "desc");

        $query = $this->db->get();

        return $query;

    }



    public function returnRows() {

        $this->db->select('*');

        $this->db->from('orders');

        $this->db->join('dropshipstatusmanager', "orders.OrderStatus = dropshipstatusmanager.StatusID where orders.BillingFirstName != '0' and orders.PaymentMethods!='SampleOrder'");

        $query = $this->db->get();

        return $query;

    }



    public function OrderDetails($orderID) {
		if(empty($orderID)){

        $orderID = end($this->uri->segments);

         }

        $query = $this->db->get_where('orderdetails', array('OrderNumber' => $orderID));

        return $query->result();

    }



    public function OrderInfo($orderID) {
        if(empty($orderID)){

        $orderID = end($this->uri->segments);

        }

        $query = $this->db->get_where('orders', array('OrderNumber' => $orderID));

        return $query->result();

    }

	

	public function getproductdetail($id){

        

        $query = $this->db->select('*')

                         ->where('ProductID',$id)

                         ->get('products');

      

        return $query->row_array();

    }

	

	

    public function statusdropdowna($in_array)

    {

        $query ="select * from dropshipstatusmanager where StatusID IN ($in_array) order by SortID asc";

        $row =$this->db->query($query);

        return $row->result();

        

    }

    public function statusdropdown($id,$method)

     {
		
		
		

        if($id==6){

            $in_array = "6,32,10,33,8,7,38,27,38,55,62,78";

        }else if($id==10){

            

             $in_array = "10,34";

        }

        else if($id==26){

            

            $in_array = "2,32,10,33,8,7,26,38,27,38,55,62,78";

        }else{

             $in_array = "2,32,10,33,8,7,38,27,38,55,62,78";

        }
		
	if($method=='Sample Order'){
		$in_array = "37,2,32,23,55";
	}
		
        $UserName = $this->session->userdata('UserTypeID');
	    if($UserName!=50){
			if($id==55){
				$in_array = "55,32";
			}if($id==6){
			    $in_array = "10,27";
			}else{
				$in_array = "10";
				if($UserName == 'carol' || $UserName == 'carol_home' ){ $in_array = "10,27";} 
			}
	}           
        $row = $this->statusdropdowna($in_array);

        

        foreach ($row  as $row){

            

        $option[$row->StatusID] = $row->StatusTitle;

        }

        return $option;

     }

     public function changestatus($id,$status){

        $old = $this->getstatus($id);

        $update = array(

            'OrderStatus' => $status,

        );

        

        $this->db->where('OrderID',$id);

        $this->db->update('orders',$update);

        $ordernumber = $this->getordernumber($id);

        $update_log = array(

            'ID'                =>  NULL,

            'OrderNumber'       =>  $ordernumber,

            'OrderStatus_new'   =>  $status,

            'OrderStatus_old'   =>  $old,

            'Oprator'           =>  $this->session->userdata('UserName')  ,

            'SALE_ID'           =>  $this->session->userdata('UserID'),

            'Date'              =>  time()

            

        );

       $this->db->insert('status_change_log',$update_log);
        if($status==27){
		$this->deallocatestock($ordernumber);
	   }
	   
	   $this->custom->assign_dispatch_date($ordernumber,TRUE);

    }

   
     function deallocatestock($ordernumber){
    $stock = $this->db->query("select * from stock_produced where order_no LIKE '".$ordernumber."' and type LIKE 'Stock' ")->result();
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
	 
     $where = "order_no LIKE '".$ordernumber."' AND type LIKE 'Stock'";
	 $this->db->where($where);
	 $this->db->delete('stock_produced'); 
	 
  }
     

    public function getstatus($orderid){

       $query = $this->db->select('OrderStatus')

                         ->where('OrderID',$orderid)

                         ->get('orders');

       $data = $query->row_array();

        return $data['OrderStatus'];        

        

    }

    public function getordernumber($orderid){

       $query = $this->db->select('OrderNumber')

                         ->where('OrderID',$orderid)

                         ->get('orders');

       $data = $query->row_array();

        return $data['OrderNumber'];        

        

    }

    public function getorderId($ordernumber){

       $query = $this->db->select('OrderID')

                         ->where('OrderNumber',$ordernumber)

                         ->get('orders');

       $data = $query->row_array();

        return $data['OrderID'];        

        

    }

    public function holdstatus($ordernumber,$statusid)

    {

        

        $order_id   = $this->getorderId($ordernumber);

        $old_status = $this->getstatus($order_id);

        $hold_status = $this-> getholdstatus($ordernumber);

        if( $statusid==34 || $statusid == 10){

            if(!empty($hold_status)){

                $change_status = $hold_status;

            }else{

                $change_status = $old_status;

            }

        }else{

            $change_status = $statusid;

        }

                if($statusid == 10){ 

                    $update = array(   'OrderStatus' =>$statusid,  );

                }else{

                    $update = array(   'OrderStatus' =>$change_status,  ); 

                }

        $this->db->where('OrderNumber',$ordernumber)

                 ->update('orders',$update);

        if(!empty($hold_status)){

            $update =  array('old_status_id' => $change_status ,'new_status_id'=>$statusid);

            $this->db->where('order_id',$ordernumber)

                     ->update('holdstatushistory',$update);

        }else{

            $insert = array('old_status_id'=>$change_status, 'new_status_id' =>$statusid, 'order_id'=>$ordernumber);

            $this->db->insert('holdstatushistory',$insert);

        }

        

    }

    public function getholdstatus($ordernumber){

        

        $query = $this->db->select('old_status_id')

                         ->where('order_id',$ordernumber)

                         ->get('holdstatushistory');

       $data = $query->row_array();

        return $data['old_status_id'];

    }

     public function getproductimg($id, $colorcode=NULL){
			$query = $this->db->select('Image1,ProductBrand,ManufactureID')
								->where('ProductID',$id)
								->get('products');
		   $data = $query->row_array();
		 
		   if($id==0){
				 $img = "High_Gloss_Permanent_Adhesive.png";
				 return base_url().'theme/images/images_products/material_images/'.$img; 
		   }
		   else if(preg_match('/Application Labels/', $data['ProductBrand'])){
					 $designcode = substr( $data['ManufactureID'], -4); 
					 return Assets."images/application/design/".$designcode.$colorcode.'.png';
		   }
		   else{      
                             //$data['Image1'] = trim(str_replace(".gif",".png",$data['Image1']));
                             $data['Image1'] = str_replace(" ","",$data['Image1']);
                              return base_url().'theme/images/images_products/material_images/'.$data['Image1'];
                   }
       

    }

     public function reorder($ordernumber)

    {

             $cookie = $_COOKIE['ci_session'];

			$cookie = stripslashes($cookie);

			$cookie = unserialize($cookie);

			$cisess_session_id = $cookie['session_id'];  

			$session_id = $this->session->userdata('session_id');

			$where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";

			$this->db->where($where);

			$this->db->delete('temporaryshoppingbasket');

			$order        = $this->OrderInfo($ordernumber);

			$order_detail = $this->OrderDetails($ordernumber);

    

             foreach($order_detail as $order_detail){



			if($order_detail->ManufactureID=='PRL1'){
				
						$quotationData = array(
											'SessionID'  => $this->session->userdata('session_id'),
		                                    'UserID'     => $this->session->userdata('UserID'),
				                            'ProductID'  => $order_detail->ProductID,
		                                    'OrderTime'  => date("Y-m-d h:i:s"),
		                                    'Quantity'   => $order_detail->Quantity,
				                            'UnitPrice'  => $order_detail->Price/$order_detail->Quantity, 
						                    'p_code'      => $order_detail->ManufactureID,
											'p_name'      => $order_detail->ProductName,
											'OrderData'=>$order_detail->Print_Type,
					                        'TotalPrice' =>($order_detail->ProductTotal/1.2),
							                'is_custom'  => $order_detail->is_custom,
									);
						  $this->db->insert('temporaryshoppingbasket', $quotationData);	
						  $carid = $this->db->insert_id();
						  if($carid){
							
							$query = $this->db->query("select * from roll_print_basket WHERE SerialNumber = $order_detail->Prl_id");
							$print_details = $query->row_array();
							
							  $insert = array(	  'id'    => $carid,
												  'shape' => $print_details['shape'],
												  'size'  => $print_details['size'],
												  'material' => $print_details['material'],
												  'printing' => $print_details['printing'],
												  'finishing' =>  $print_details['finishing'],
												  'no_designs' => $print_details['no_designs'],
												  'no_rolls' =>  $print_details['no_rolls'],
												  'no_labels' => $print_details['no_labels'],
												  'coresize' => $print_details['coresize'],
												  'wound' =>  $print_details['wound'],
												  'custom'=> $print_details['custom'],
												  'notes'=>  $print_details['notes'] );
            					$this->db->insert('roll_print_basket', $insert);
						}
			  
			}
			else  if($order_detail->ProductID==0){
				      $quotationData = array(
											'SessionID'  => $this->session->userdata('session_id'),
		                                    'UserID'     => $this->session->userdata('UserID'),
				                            'ProductID'  => $order_detail->ProductID,
		                                    'OrderTime'  => date("Y-m-d h:i:s"),
		                                    'Quantity'   => $order_detail->Quantity,
				                            'UnitPrice'  => $order_detail->Price/$order_detail->Quantity, 
						                    'p_code'      => $order_detail->ManufactureID,
											'p_name'      => $order_detail->ProductName,
											'OrderData'=>$order_detail->Print_Type,
					                       'TotalPrice' =>($order_detail->ProductTotal/1.2),
							                'is_custom'  => $order_detail->is_custom,
											'LabelsPerRoll'=>$order_detail->LabelsPerRoll 
									);
						  $this->db->insert('temporaryshoppingbasket', $quotationData);			
								 
				   
				   
				}else{


      /***********************************//***********************************//***********************************/

				

  $query = $this->db->query("select count(*) as total,ManufactureID,ProductBrand,LabelsPerSheet from products 
										 WHERE ProductID LIKE '".$order_detail->ProductID."' AND (Activate LIKE 'Y' OR displayin = 'backoffice') LIMIT 1");

  $row = $query->row_array();
  
  
  
  if(isset($row['total']) and $row['total'] > 0){
	  
	  if(preg_match("/Roll Labels/i",$row['ProductBrand']) && $order_detail->Printing=='Y'){
		  $order_detail->Price = $order_detail->Price;
		  $order_detail->source = "printing";
	 }else
		if(preg_match("/Roll Labels/i",$row['ProductBrand'])){

			$minroll =  $this->quoteModel->calulate_min_rolls($row['ManufactureID']);	
			if($order_detail->Quantity%$minroll !=0){
			  $order_detail->Quantity = $minroll * (ceil($order_detail->Quantity/$minroll));
			}

			if($order_detail->is_custom=='Yes'){
			 $labelsPerol =  $order_detail->LabelsPerRoll;
			}else{
			 $labelsPerol =  $row['LabelsPerSheet'];
			}

			$custom_price = $this->quoteModel->min_roll_price($row['ManufactureID'],$order_detail->Quantity,$labelsPerol);
			$custom_price	=	 number_format(round($custom_price,2),2,'.','');
			$order_detail->Price =  $custom_price;
			$order_detail->ProductTotalVAT =$custom_price*$order_detail->Quantity;
   
     }else if($type=='Integrated'){
	 }else{
		$data['custom_price']  = $this->quoteModel->getPrize($order_detail->Quantity,$row['ManufactureID']);  
		$data['custom_price']	=	 number_format(round($data['custom_price'],2),2,'.','');
		if((preg_match("/A4 Labels/i",$row['ProductBrand']) and preg_match("/WPEP/i",$row['ManufactureID']))){
			$data['custom_price'] = ($data['custom_price']*1.2);
			$wpep_discount = (($data['custom_price'])*(20/100));
			$total = $data['custom_price']-$wpep_discount;
			$data['custom_price'] = $total/1.2;
		}
		$order_detail->Price = $data['custom_price'];
				
	}	
	
	 if(preg_match("/Inside Wound/", $order_detail->ProductName)){ $wound ='Y';} else { $wound ='N';}
	 
 
	       /***********************************//***********************************//***********************************/

				$quotationData = array(
				
				'SessionID'  => $this->session->userdata('session_id'),
				'UserID'     => $this->session->userdata('UserID'),
				'ProductID'  => $order_detail->ProductID,
				'OrderTime'  => date("Y-m-d h:i:s"),
				'Quantity'   => $order_detail->Quantity,
				'orignalQty'  => $order_detail->labels,
				'UnitPrice'  => $order_detail->Price,
				'OrderData  '=> $order_detail->Print_Type,
				'TotalPrice' => $order_detail->Price,
				'is_custom'  => $order_detail->is_custom,
				'LabelsPerRoll'=>$order_detail->LabelsPerRoll,
				'Printing'=>$order_detail->Printing,
				'Print_Type'=>$order_detail->Print_Type,
				'Print_Design'=>$order_detail->Print_Design,
				'Print_Qty'=>$order_detail->Print_Qty,
				'Free'=>$order_detail->Free,
				'Print_UnitPrice'=>$order_detail->Print_UnitPrice,
				'Print_Total'=>$order_detail->Print_Total,
				'colorcode'=>$order_detail->colorcode,
				'source'=>$order_detail->source,
				
				'wound'=>$order_detail->Wound,
				'orientation'=>$order_detail->Orientation,
				'pressproof'=>$order_detail->pressproof,
				'FinishType'=>$order_detail->FinishType,
				'Product_detail'=>$order_detail->Product_detail,
				'design_service'=>$order_detail->design_service,
				'design_service_charge'=>$order_detail->design_service_charge,
				'design_file'=>$order_detail->design_file 
               );
               $this->db->insert('temporaryshoppingbasket', $quotationData);
			   $cartid = $this->db->insert_id();
         
		  if(preg_match('/Integrated Labels/is',$row['ProductBrand']) || $order_detail->Printing=='Y'){
			  $query = $this->db->query("select * from order_attachments_integrated WHERE Serial LIKE '".$order_detail->SerialNumber."'");
              $query = $query->result();
               if(count($query) > 0){
			    foreach($query  as $int_row){
					$source = ($int_row->source=="web")?"backoffice":$int_row->source;
                    $attach_array = array('SessionID'=>$this->session->userdata('session_id'),
					'CartID'=>$cartid,
					'ProductID'=>$int_row->ProductID,
					'file'=>$int_row->file,
					'status'=>'confirm',
					'source'=>$source,
					'qty'=>$int_row->qty,
					'labels'=>$int_row->labels,
					'name'=>$int_row->name,
					'Date'=>$int_row->Date
					);
					
					$this->db->insert('integrated_attachments',$attach_array);
                 }
			  }
		   }	
				
				
				
		  }
		 }
	   }

      $this->session->set_userdata('Order_person',$order[0]->UserID); 

    }

    public function neworderNo()

    {

        $sessionid = $this->session->userdata('session_id');
		$this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
		$order_num = $this->db->insert_id();
		return $OrderNumber = 'AA'.$order_num;

    }

    public function updateorderdetail($update,$id)

    {

        $this->db->where('SerialNumber',$id)

                    ->update('orderdetails',$update);

        

    }

    public function getordertotal($orderNo)

    {

        $row=    $this->db->select_sum('ProductTotal')

                           ->where('OrderNumber',$orderNo)

                           ->get('orderdetails');

         $row=$row->row_array();

         return $row['ProductTotal'];

    }
	
	  public function getordertotalprint($orderNo)

    {

        $row=    $this->db->select_sum('Print_Total')

                           ->where('OrderNumber',$orderNo)

                           ->get('orderdetails');

         $row=$row->row_array();

         return $row['Print_Total'];

    }

     public function getshipAmount($orderNo)

    {

        $row=    $this->db->select('OrderShippingAmount')

                           ->where('OrderNumber',$orderNo)

                           ->get('orders');

         $row=$row->row_array();

         return $row['OrderShippingAmount'];

    }

    public function getorderincvattotal($orderNo)

    {

        $product_total = $this->getordertotal($orderNo);

        // $ship_total = $this->getshipAmount($orderNo);

         return $total = number_format($product_total,2,'.','');

    }
	
	    public function getorderincvattotalprint($orderNo)

    {

        $product_total = $this->getordertotalprint($orderNo);

        // $ship_total = $this->getshipAmount($orderNo);

         return $total = number_format($product_total,2,'.','');

    }


	 public function getorderincvat($orderNo)

    {

        $product_total = $this->getordertotal($orderNo);

         $ship_total = $this->getshipAmount($orderNo);
		 
		 $print_total = $this->getordertotalprint($orderNo);
		 
		 $print_total =	 $print_total *1.2;

         return $total = number_format($product_total+$ship_total+$print_total,2,'.','');

    }

     public function updateorder($update,$id)

    {

        $this->db->where('OrderNumber',$id)

                    ->update('orders',$update);

        

    }

    public function getadddiscount($orderNo,$discount)

    {
        
        $order_total = $this->getorderincvat($orderNo);
        $ship_total = $this->getshipAmount($orderNo);
		
	    $order_check = $order_total - $discount - $ship_total;
		
        $order_update = array(

                'OrderTotal' =>$order_check, 

            );

       $this->updateorder($order_update,$orderNo);
	   
	  

       return   $order_discount = $order_total - $discount;

    }

    public function insertorderdetails($insert)

    {

        

        $this->db->insert('orderdetails',$insert);

    }

	

	

	

	public function getOrderNum() { 

            $sessionid = $this->session->userdata('session_id');
			$this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
			$order_num = $this->db->insert_id();
			return $order_num;

    }

	public function saverorderNo($highestValue)

        {

            $newEntry = array('OrderNumber' => $highestValue); 

            $this->db->insert('ordernumber', $newEntry);

        }

	public function SaveOrder()
	{
     $currency = currency;
	 $exchange_rate  = $this->reportsmodel->get_exchange_rate($currency);
	 $plain_label_cust = $this->input->post('plain_label_cust');
	
		$cookie = $_COOKIE['ci_session'];

		$cookie = stripslashes($cookie);

		$cookie = unserialize($cookie);

		$cisess_session_id = $cookie['session_id'];  

		$session_id = $this->session->userdata('session_id');

		

		

		$UserName = $this->session->userdata('UserName');

		$Ordshipamount = $this->session->userdata('Qshipamount');

        $VATEXEMPT =  $this->session->userdata('vat_exemption');
		

		$Ordtotal = $this->session->userdata('Qtotal');

		

		$Source = $this->session->userdata('OPERATOR_AA');

		

		$UserID = $this->input->post('UserID');

		$country     = $this->input->post('country');

		$shipservice = $this->input->post('shippingcharges');

		$Ordtotal = $Ordtotal - $Ordshipamount;

		$OrdWebsite = $this->input->post('QuoteWebsite');

		$OrdNo = $this->getOrderNum();

		

		if($OrdWebsite=='123')
		{
			$OrderNo = '123-'.$OrdNo;
		}
		else
		{
			$user_domain = $this->session->userdata('user_domain');
			if(isset($user_domain) and $user_domain == "trade")
			{
				$OrderNo = 'AT'.$OrdNo;
			}
			else
			{
				$OrderNo = 'AA'.$OrdNo;
			}
		}

	
		$payment = $this->input->post('paymentMethod');
				
		if($payment=='Sample Order'){
				$OrderNo = $OrderNo."-S";	
		}		

		$this->session->set_userdata("OrderNo",$OrderNo);
		

		$wtp_discount = $this->quoteModel->wtp_discount_applied_on_order();
		$rollvoucher = $this->orderModel->calculate_total_printedroll_amount();
		
		if($wtp_discount){
				$discount_offer = $wtp_discount['discount_offer'];
				//$Ordtotal = $Ordtotal -$wtp_discount['discount_offer'];
				$voucherOfferd = 'Yes';
				$del = $this->db->delete('voucherofferd_temp', array('SessionID' => $session_id));
		}
		else if($rollvoucher > 0){
				$discount_offer = $rollvoucher;
				$voucherOfferd = 'Yes';
				
				$cisess_session_id = $this->get_website_session_id();
				$session_id = $this->session->userdata('session_id');
				$where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";
				$qry   = $this->db->query("Delete FROM voucherofferd_temp WHERE ".$where);
				
		}
		else{
				$discount_offer = 0.00;
				$voucherOfferd = 'No';
		}

		

		

		/* Billing Form Data */

		$UserEmail = $this->input->post('UserEmail');
        $SecondaryEmail = $this->input->post('SecondaryEmail');
		if(empty($UserEmail))

		{

			$UserEmail = $this->input->post('hideUserEmail');

		}

		$Bpcode 	   = strtoupper($this->input->post('pcode'));
		$BFirstName    = ucwords($this->input->post('FirstName'));
		$BLastname 	   = ucwords($this->input->post('Lastname'));
		$BAddress1 	   = ucwords($this->input->post('Address1'));
		$BAddress2 	   = ucwords($this->input->post('Address2'));
		$BTownCity 	   = ucwords($this->input->post('TownCity'));
		$BCountryState = ucwords($this->input->post('CountryState'));
		$BCompany 	   = ucwords($this->input->post('Company'));
		
		
		
		$BTitle = $this->input->post('BillingTitle');
		$BCountry = $this->input->post('bill_country'); 
		$BTelephone = $this->input->post('Telephone');
		$BFax = $this->input->post('Fax');
		$Bmobile = $this->input->post('mobile');
		$BbillingResCom = $this->input->post('billingResCom_User');

		/****************** Delivery Form Data *********************/
		
		$DTitle = $this->input->post('DTitle');
		
		$Dpcode 		= strtoupper($this->input->post('Dpcode'));
		$DFirstName 	= ucwords($this->input->post('DFirstName'));
		$DLastname 		= ucwords($this->input->post('DLastname'));
		$DAddress1 		= ucwords($this->input->post('DAddress1'));
		$DAddress2 		= ucwords($this->input->post('DAddress2'));
		$DTownCity 		= ucwords($this->input->post('DTownCity'));
		$DCompany 		= ucwords($this->input->post('DCompany'));
	    $DCountryState  = ucwords($this->input->post('DCountryState'));
		
		
		$DCountry = $this->input->post('del_country'); 

		

		$DTelephone = $this->input->post('DTelephone');

		$DFax = $this->input->post('DFax');

		

		$DbillingResCom = $this->input->post('DbillingResCom_User');

		$qemail = $this->input->post('quotationemail');

		$paymentmethod = $this->input->post('paymentMethod');

		$BillingMobile = $this->input->post('Mobile');
		
		$DMobile = $this->input->post('DMobile');
		
        $purchaseno = $this->input->post('pno'); 
		
		$CustomerOrder = $this->input->post('Vat');
      		
        $vatonformation = $this->input->post('vatonformation');
		
	    $vat_pass = $this->input->post('vat_pass');
		
		
		
	
		if($vatonformation=="on" || $vat_pass=="N"){
				 $CustomerOrder=0;
		}	
  

		$Customer = array('UserEmail' => $UserEmail,

            'UserName' => $DFirstName,
			
			'SecondaryEmail'=>$SecondaryEmail,

            'UserPassword' => rand(10, 50),

            'RegisteredDate' => date('Y-m-d'), 

            'RegisteredTime' => date('H:i:s'),

            'BillingTitle' => $BTitle,

            'BillingFirstName' => $BFirstName,

            'BillingLastName' => $BLastname,

            'BillingCompanyName' => $BCompany,

            'BillingAddress1' => $BAddress1,

            'BillingAddress2' => $BAddress2,

            'BillingTownCity' => $BTownCity,

            'BillingCountyState' => $BCountryState,
			
			'BillingCountry' => $BCountry, 

            'BillingPostcode' => $Bpcode,

            'BillingCountry' => $BCountryState,

            'BillingTelephone' => $BTelephone,
            
            'BillingMobile' => $Bmobile, 
			 
            'BillingFax' => $BFax,

			

            'DeliveryTitle' => $DTitle,

            'DeliveryFirstName' => $DFirstName,

            'DeliveryLastName' => $DLastname,

            'DeliveryCompanyName' => $DCompany,

            'DeliveryAddress1' => $DAddress1,

			'DeliveryAddress2' => $DAddress2,

            'DeliveryTownCity' => $DTownCity,

            'DeliveryCountyState' => $DCountryState,
			
			'DeliveryCountry' => $DCountry, 

            'DeliveryPostcode' => $Dpcode,

            'DeliveryTelephone' => $DTelephone,

            'DeliveryFax' => $DFax,
            
	        'DeliveryMobile'=>$DMobile,


            'Active' =>1

        );

		

		

		$last_order = 0;

		if(empty($UserID)){

			$this->db->insert('customers', $Customer);

			$rs = $this->db->get_where('customers',array('UserEmail'=>$UserEmail))->result();

			$CustomerID = $rs[0]->UserID;
			
			$last_order ='FIRST';

		}

		else

		{

			$CustomerID = $UserID;

		}
		
		
$payment = $this->input->post('paymentMethod');
		
if($payment=='Sample Order'){
$orderstatus = "33";
$Ordtotal =0;
$Ordshipamount=0;
$shipservice=20;
}else{
$orderstatus = "6";
}


			$Order = array(

                    'OrderNumber' => $OrderNo,

					'SessionID' => $session_id,

					'OrderDate' => time(),

					'OrderTime' => time(),

					'UserID' => $CustomerID,

					'DeliveryStatus' => '',

					'PaymentMethods' => $paymentmethod,

					'OrderShippingAmount' => $Ordshipamount,

					'OrderTotal' => $Ordtotal,

					'PurchaseOrderNumber' => $purchaseno,
					
					'CustomOrder'=>$CustomerOrder,

					'BillingTitle' => $BTitle,
					
					'SecondaryEmail'=>$SecondaryEmail,

					'BillingFirstName' => $BFirstName,

					'BillingLastName' => $BLastname,

					'BillingCompanyName' => $BCompany,

					'Billingemail'=> $UserEmail,

					'BillingAddress1' => $BAddress1,

					'BillingAddress2' => $BAddress2,

					'BillingTownCity' => $BTownCity,

					'BillingCountyState' => $BCountryState,

					'BillingPostcode' => $Bpcode,

					'BillingCountry' => $BCountry,

					'Billingtelephone' => $BTelephone,
					
					'BillingMobile' => $Bmobile, 

					'Billingfax' => $BFax,

					'Billingemail' => $UserEmail,

					'BillingResCom' => $BbillingResCom,

					

					'DeliveryTitle' => $DTitle,

					'DeliveryFirstName' => $DFirstName,

					'DeliveryLastName' => $DLastname,

					'DeliveryCompanyName' => $DCompany,

					'DeliveryAddress1' => $DAddress1,

					'DeliveryAddress2' => $DAddress2,

					'DeliveryTownCity' => $DTownCity,

					'DeliveryCountyState' => $DCountryState,
					
					'DeliveryCountry' => $DCountry,


					'DeliveryPostcode' => $Dpcode,

					'Deliverytelephone' => $DTelephone,

					'DeliveryMobile' => $DMobile,

					'Deliveryfax' => $DFax,

					'DeliveryResCom' => $DbillingResCom,
					
                    'BillingMobile'=>$BillingMobile,
					
			        'DeliveryMobile'=>$DMobile,
							
                    'Registered' => 'Yes',

					'OrderStatus' => $orderstatus,

					'ShippingServiceID' => $shipservice,

					'printPicked' => 'No',

					'Source' => $Source,

					'Domain' => $OrdWebsite,
					
					'prevOrder'=>$last_order,
					 
                    'vat_exempt'=>$VATEXEMPT,
					 
                    'voucherOfferd'=> $voucherOfferd,

			        'voucherDiscount'=>$discount_offer,
					
					'currency'=>$currency,
					
					'exchange_rate'=>$exchange_rate,
					
					'Label'=>$plain_label_cust
					);

	

		$OrderNumber = array('OrderNumber' => $OrdNo);
      
		$this->db->insert('orders', $Order);
		

		 

		$tempcart =	$this->viewCart();

		foreach( $tempcart as $cartdata)

		{

$print_type = '';


if($payment=='Sample Order'){
$ExVat =0;	  
$IncVat =0;	
$cartdata->Quantity=1;
$cartdata->Print_Type = "Sample";  
}else{	
$ExVat = round($cartdata->TotalPrice,2);
$IncVat = round($cartdata->TotalPrice * vat_rate,2);
}



                    $prodinfo = $this->orderModel->getproductdetail($cartdata->ProductID);

		    $prodcompletename =  $this->orderModel->customize_product_name($cartdata->is_custom,$cartdata->ProductCategoryName,$cartdata->LabelsPerRoll,$prodinfo['LabelsPerSheet'],$prodinfo['ReOrderCode'],$prodinfo['ManufactureID'],$prodinfo['ProductBrand'],$cartdata->wound,$cartdata->OrderData); 

		  if($cartdata->ProductID==0){

                      $prodcompletename = $cartdata->p_name;

                      $p_code=$cartdata->p_code; 

                   }else{

                       $p_code=$prodinfo['ManufactureID'];

                   }

				   

if($payment=='Sample Order'){
    $prodcompletename = $prodcompletename." - Sample ";	
}

if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand'])){

 $extra_int_text = ($cartdata->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)";
 $prodcompletename  = $prodcompletename.$extra_int_text;

}	
$print_type = $cartdata->Print_Type;
			   

				  

					

					 if($p_code=="PRL1"){

					$query = $this->db->query("SELECT SerialNumber from roll_print_basket WHERE id = '$cartdata->ID' ");

	                $row = $query->row_array();  

					$PRL_detail =  $row['SerialNumber'];

					 } else{

					$PRL_detail = "";

				    }	

						
                  if($prodinfo['displayin']=='backoffice'){
			 	$backoffice_detect = 1;
		  }else{
			    $backoffice_detect = 0;
		  }
		  
		  
		  $product = $this->db->query("select * from products where ProductID = '".$cartdata->ProductID."' ")->row_array();
		  $myLabels = $product['LabelsPerSheet'] * $cartdata->Quantity;
					
		  
if($cartdata->source=='printing' and preg_match('/Roll Labels/is',$prodinfo['ProductBrand'])){
			
		///$designedlabels = $this->get_total_printed_labels($cartdata->ID, $cartdata->ProductID);
		//if($designedlabels > 0){ $designedlabels = $designedlabels.' labels, ';}else {$designedlabels = '';}
		if($cartdata->wound=='Y' || $cartdata->wound=='Inside'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}
		
		//if($cartdata->Print_Type == 'Fullcolour'){ $labeltype = 'Full Colour';}
		//else if($cartdata->Print_Type == 'Fullcolour+White'){ $labeltype = 'Full Colour + White';}
		//else if($cartdata->Print_Type == 'Mono'){ $labeltype = 'Black Only';}
		
		$labeltype = $this->get_printing_service_name($cartdata->Print_Type);
			
		$productname  = explode("-",$prodinfo['ProductCategoryName']);
		$productname[1] = str_replace("(","",$productname[1]);
		$productname[1] = str_replace(")","",$productname[1]);
		$productname[0] = str_replace("rolls labels","",$productname[0]);
		$productname[0] = str_replace("roll labels","",$productname[0]);
		$productname[0] = str_replace("Roll Labels","",$productname[0]);
		$productname = "Printed Labels on Rolls - ".str_replace("roll label","",$productname[0]).' - '.$productname[1];
		$completeName = ucfirst($productname).' '. $wound_opt.' - Orientation '.$cartdata->orientation.', ';
		if($cartdata->FinishType == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
		else{  $labelsfinish = ' With Label finish : '.$cartdata->FinishType; }
		$prodcompletename =$completeName.' '.$labeltype.' '.$labelsfinish;
		
	        $myLabels = $cartdata->LabelsPerRoll*$cartdata->Quantity;
			if($cartdata->orignalQty !="" && $cartdata->orignalQty !=0){
			 $myLabels = $cartdata->orignalQty;
		    }
			
	}
	
	        $ProductionStatus = 1;$ProductOption ='';
             if($p_code=='AADS001'){
				 $ProductionStatus = 3;
				 $ProductOption = $order_serail;
			 }
			 
			 if($payment=='Sample Order'){
               $ProductionStatus = 3;
              
              
			 	if(preg_match("/Roll Labels/i",$prodinfo['ProductBrand'])){
					$completeName =  " Label Material  Sample ";
					$type = 'roll';
					$material_code = $this->getmaterialcode(substr($prodinfo['ManufactureID'],0,-1));
				}else{
					$type = 'a4';
					$completeName = " A4 Sheet Label Material  Sample ";
					$material_code = $this->getmaterialcode($prodinfo['ManufactureID']);
				}
				
				if(isset($material_code) and $material_code!=''){
					$res = $this->db->query("select name,adhesive from static_materials where code like '".$material_code."' limit 1");
					$res =$res->row_array();
					$dd = explode("-", $res['name']);
					$name = $dd[1].' - '.$res['adhesive'];
					$prodcompletename = $name.' '.$completeName;
				}
			 }
			 
			

		  $OrdDetail =  array(

		                'Prl_id' =>$PRL_detail,

			     		'OrderNumber' => $OrderNo,

						'UserID' => $CustomerID,
						
						'labels'=> $myLabels,

						'ProductID' => $cartdata->ProductID,

						'ManufactureID'=>$p_code,
                        'Product_detail'=>$cartdata->Product_detail,
						

						'Quantity' => $cartdata->Quantity,

						'LabelsPerRoll'=> $cartdata->LabelsPerRoll,

						'is_custom'=> $cartdata->is_custom,

						'ProductName' => $prodcompletename,

						'Price' => $ExVat,

						'ProductTotalVAT' => $ExVat,

						'ProductTotal' => $IncVat,	
						
						'ProductionStatus'=>$ProductionStatus,
						'ProductOption'=>$ProductOption,

						
						'Printing'=> $cartdata->Printing,
						'Print_Type'=> $print_type,
						'Print_Design'=> $cartdata->Print_Design,
						'Print_Qty'=> $cartdata->Print_Qty,
						'Free'=> $cartdata->Free,
						'Print_UnitPrice'=> $cartdata->Print_UnitPrice,
						'Print_Total'=> $cartdata->Print_Total,	
                        'old_product'=>$backoffice_detect,
						'colorcode'=> $cartdata->colorcode, 
						
						'Wound'=>$cartdata->wound,
						'Orientation'=>$cartdata->orientation,
						'pressproof'=>$cartdata->pressproof,
						'FinishType'=>$cartdata->FinishType,
						'Product_detail'=>$cartdata->Product_detail,
						'design_service'=>$cartdata->design_service,
						'design_service_charge'=>$cartdata->design_service_charge,
						'design_file'=>$cartdata->design_file,
						'page_location'=>$cartdata->page_location,
						'regmark' => $cartdata->regmark
			);
			$this->db->insert('orderdetails', $OrdDetail); 

			$order_serail = $this->db->insert_id();

			

				if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand']) || $cartdata->Printing=='Y'){
					if($cartdata->OrderData=='Black' || $cartdata->OrderData=='Printed' || $cartdata->Printing=='Y'){

		
								$query = $this->db->query("select count(*) as total from integrated_attachments 

								WHERE ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."' AND status LIKE 'confirm' ");

								$query = $query->row_array();

								if($query['total'] > 0 || $cartdata->regmark == "Y"){

									

									$attach_q = $this->db->query("select * from integrated_attachments 

									WHERE ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."'
									 AND status LIKE 'confirm' ");

									$attach_q = $attach_q->result();
									
									$fakearray = array();
									if(!$attach_q and $cartdata->regmark == "Y")
									{
										$brand = $this->make_productBrand_condtion($prodinfo['ProductBrand']);
										$PDF = $this->db->query("Select PDF from products p INNER JOIN category c on  SUBSTRING_INDEX(p.CategoryID, 'R', 1) = c.CategoryID where SUBSTRING_INDEX(p.CategoryID, 'R', 1) = c.CategoryID and p.ProductID = '".$cartdata->ProductID."' LIMIT 1")->row()->PDF;
										$ex = explode(".",$PDF);
										$filename = $ex[0]."_rev.".$ex[1];
										$fakearray['OrderNumber'] = $OrderNo;
										$fakearray['Serial'] = $order_serail;
										$fakearray['ProductID'] = $cartdata->ProductID;
										$fakearray['file'] = $filename;
										$fakearray['print_file'] = $filename;
										$fakearray['name'] = $p_code;
										$fakearray['diecode'] = $p_code;
										$fakearray['qty'] = $cartdata->Quantity;
										$fakearray['labels'] = $cartdata->orignalQty;
										$fakearray['status'] = 70;
										$fakearray['source'] = 'backoffice';
										$fakearray['version'] = 1;
										$fakearray['approved'] = 1;
										$fakearray['checklist'] = 1;
										$fakearray['CO'] = 1;
										$fakearray['SP'] = 1;
										$fakearray['CA'] = 1;
										$fakearray['PF'] = 1;
										$fakearray['action'] = 0;
										$fakearray['design_type'] = $cartdata->Print_Type;
										$fakearray['Brand'] = $brand;
										$this->db->insert('order_attachments_integrated',$fakearray);
										/*CO,sp,ca,pf = 1;
										status = 70
										action = 0;
										file = .pdf;
										print_file = .pdf*/
									}
									
									foreach($attach_q  as $int_row){
                                        $brand = $this->make_productBrand_condtion($prodinfo['ProductBrand']);
										$attach_array = array('OrderNumber'=>$OrderNo,
															  'Serial'=>$order_serail,
															  'ProductID'=>$int_row->ProductID,
															  'file'=>$int_row->file,
															  'diecode'=>$p_code,
															  'status'=>64,
															  'Brand'=>$brand,
															  'source'=>'backoffice',
															  'design_type'=>$cartdata->Print_Type,
															  'qty'=>$int_row->qty,
															  'labels'=>$int_row->labels,
															  'name'=>$int_row->name,
															  'CO' =>1,
															  'version' =>1
															  );

										$this->db->insert('order_attachments_integrated',$attach_array);

											

									}

						}

					}

			}

			  

		}

	

	

	///////////////////////// Tem Cart Empty /////////////////////////////////////////////////////////////

  		

		//mysql_query(" delete from temporaryshoppingbasket where (SessionID = '".session_id()."' OR SessionID = '".$cisess_session_id."')");

		$where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";

		$this->db->where($where);

		$this->db->delete('temporaryshoppingbasket');

			

		

	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;	

	}

	

	 function make_productBrand_condtion($type){
		
		if(preg_match("/SRA3/i",$type)){
		  $brand = 'SRA3';
		}else if(preg_match("/A3/i",$type)){
		  $brand = 'A3';
		}else if(preg_match("/Roll/i",$type)){
		  $brand = 'Rolls';
		}else if(preg_match("/Integrated/i",$type)){
		  $brand = 'Integrated';
		}else{
		  $brand = 'A4';	
		}
		return $brand;	
	}

	

	public function viewCart()

		{

			

			$cookie = $_COOKIE['ci_session'];

			$cookie = stripslashes($cookie);

			$cookie = unserialize($cookie);

	 		$cisess_session_id = $cookie['session_id'];  

			

			$session_id = $this->session->userdata('session_id');

			

			

			$qry = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID WHERE 1=1 and (SessionID = '".$session_id."'  OR SessionID ='".$cisess_session_id."') ");

			

			$res  = $qry->result();

		

		return $res;

		}

	

         public function emailtemplate($id)

         {

            $query = $this->db->get_where(Template_Table, array('MailID' => $id));

            return $query->row_array();

         } 

	

	function calculate_rolls_diamter($manufature=NULL,$label=NULL){

		   

			$query = $this->db->query("SELECT LabelGapAcross,Height FROM products 

			INNER JOIN category ON SUBSTRING_INDEX( products.CategoryID, 'R', 1 ) = category.CategoryID   WHERE ManufactureID like '".$manufature."' LIMIT 1");

			$row = $query->row_array();						   

			$gap =  $row['LabelGapAcross'];	

			$size = $row['Height'];						   

			return $this->get_auto_diameter($manufature,$label,$gap,$size).' mm';



  }

  function get_auto_diameter($manufature,$labels,$gap,$size){

		   

		    $rolldiamter = 0;

		    $coreid = substr($manufature,-1);

		 	$coreid = 'R'.$coreid;

			$gap = round(trim(str_replace("mm","",$gap)));

			$code =  $this->getmaterialcode(substr($manufature,0,-1));

			$size = $size+$gap;

			$labels_p_mtr = round(($size/1000)*$labels,2);

			

			$diammeter = $this->get_diameter_against_meter($code,$coreid,$labels_p_mtr);

			$rolldiamter = floor(($diammeter*0.03)+$diammeter);

			if($rolldiamter > 3){ $rolldiamter = $rolldiamter-3;}

			return $rolldiamter;

  

  }

  

   function get_diameter_against_meter($code=NULL,$coreid=NULL,$meter=NULL){

	

	$qurey = $this->db->query("SELECT mtr,mesure FROM `roll_diameter` Where code LIKE '".$code."' AND core LIKE '".$coreid."'  ORDER BY `roll_diameter`.`mesure` ASC");

  	$result = $qurey->result();

	foreach($result as $key => $row){

			if($meter == $row->mtr){

				return  $row->mesure;

			}

			else if(($meter > $row->mtr and isset($result[$key+1]->mtr) and $meter < $result[$key+1]->mtr)){

				    return  $result[$key+1]->mesure;

			}

		}

  }

  function getmaterialcode($text){

			

			preg_match('/(\d+)\D*$/', $text, $m);

			$lastnum = $m[1];

			$mat_code = explode($lastnum,$text);

			return strtoupper($mat_code[1]);

  }

  

  

	

function calculate_rolls_diamter_old($manufature=NULL,$label=NULL){

	  $qurey = $this->db->query("SELECT Labels,Diameter FROM `tbl_roll_diameter` Where ManufactureID LIKE '".$manufature."' ORDER BY `tbl_roll_diameter`.`Labels` ASC");

		$result = $qurey->result();

		foreach($result as $key => $row){

				if($label == $row->Labels){

					return  $row->Diameter."mm ";

				}

				else if(($label > $row->Labels and isset($result[$key+1]->Labels) and $label < $result[$key+1]->Labels)){

						return  $result[$key+1]->Diameter."mm ";

				}

			}

  }	

  function customize_product_name($custom,$ProductCategoryName,$LabelsPerRoll,$LabelsPerSheet,$ReOrderCode,$manuid,$ProductBrand,$wound=NULL, $printed=NULL){

	   if($wound=='Y'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}

	                  if($custom=='Yes'){

						          $productname  = explode("-",$ProductCategoryName);

						           $completeName = $productname[0].$LabelsPerRoll."  label per roll, ".$wound_opt." - ".$productname[1]; 

								  $diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerRoll);

								  $completeName = $completeName." Roll Diameter ".$diamter;

								

					  }else{

						    if(preg_match('/Roll Labels/is',$ProductBrand)){

								   $productname  = explode("-",$ProductCategoryName);

								   $completeName = $productname[0].$LabelsPerSheet."  label per roll, ".$wound_opt." - ".$productname[1];

								   $diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerSheet); 

								   $completeName = $completeName." Roll Diameter ".$diamter;

							 

							}else{

							    	if(preg_match('/Integrated Labels/is',$ProductBrand)){
                                                $completeName = $ProductCategoryName;

									 }else{
if(substr($manuid,-2,2)=='XS'){
													$completeName = $ProductCategoryName.", Design: ".$printed;
												}else{ $completeName = $ProductCategoryName;}

											//$completeName = $ProductCategoryName;	

                         /**********WPEP Voucher Offer*************/
											 if(preg_match("/A4/i",$ProductBrand) and (preg_match("/WPEP/i",$manuid))){
													$completeName =  $completeName." <span style='color:#fd4913;'>( 20% discount) </span>";
											 }
											/**********WPEP Voucher Offer*************/

									}

				}

		} 

		if($ReOrderCode){ $completeName = $completeName." re-order code ".$ReOrderCode; }
		if(preg_match("/HGP/i",$manuid) and preg_match('/Roll Labels/is',$ProductBrand)){
				$completeName =  $completeName." <span style='color:#fd4913;'>( 30% discount) </span>";
		}

		return $completeName;

  }

  function updBillinginfo($ordNo){

	  

			 $Billinginfo = array(

									'BillingCompanyName' => $this->input->post('BillingCompanyName'),

									'BillingFirstName' 	 => $this->input->post('BillingFirstName'),

									'BillingLastName' 	 => $this->input->post('BillingLastName'),

									'BillingAddress1' 	 => $this->input->post('BillingAddress1'),

									'BillingAddress2' 	 => $this->input->post('BillingAddress2'),

									'BillingTownCity' 	 => $this->input->post('BillingTownCity'),

									'BillingCountyState' => $this->input->post('BillingCountyState'),
									
									'BillingCountry'     => $this->input->post('BillingCountry'),

									'BillingPostcode' 	 => $this->input->post('BillingPostcode'),

									'Billingtelephone' 	 => $this->input->post('Billingtelephone'),
									
									'BillingMobile' 	 => $this->input->post('BillingMobile'),

									'Billingfax' 		 => $this->input->post('Billingfax'),'PurchaseOrderNumber'=> $this->input->post('PurchaseOrderNumber'),

								);

			

			$this->db->where('OrderNumber',$ordNo);

			$this->db->update('orders',$Billinginfo);

			

			

		return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;	

		}

	

	function updDeliveryinfo($ordNo)

	{

		 $Deliveryinfo = array(

									

			'DeliveryCompanyName' => $this->input->post('DeliveryCompanyName'),

			'DeliveryFirstName'   => $this->input->post('DeliveryFirstName'),

			'DeliveryLastName' 	  => $this->input->post('DeliveryLastName'),

			'DeliveryAddress1' 	  => $this->input->post('DeliveryAddress1'),

			'DeliveryAddress2' 	  => $this->input->post('DeliveryAddress2'),

			'DeliveryTownCity' 	  => $this->input->post('DeliveryTownCity'),

			'DeliveryCountyState' => $this->input->post('DeliveryCountyState'),
			'DeliveryCountry'     => $this->input->post('DeliveryCountry'), 

		    'DeliveryPostcode' 	  => $this->input->post('DeliveryPostcode'),

		    'Deliverytelephone'   => $this->input->post('Deliverytelephone'),
            'DeliveryMobile'   => $this->input->post('DeliveryMobile'),

			'Deliveryfax' 		  => $this->input->post('Deliveryfax'),

									

								);

			

			$this->db->where('OrderNumber',$ordNo);

			$this->db->update('orders',$Deliveryinfo);

			

			

		return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;

		 

		 

	}

	

	

	function menufacture($id){

		$query=$this->db->query("select  ManufactureID from products  where ProductID='".$id."'");

		$res=$query->result();

		return $res;

	}

	

	function order_confirmation_email($OrderNumber){

		                
			$query = $this->db->get_where('orders', array('OrderNumber' => $OrderNumber));
			$res = $query->result_array();
			$res = $res[0];
			
					

		
				
				$FirstName 		= 	$res['BillingFirstName'];
				$EmailAddress 	=	$res['Billingemail'];	
				$date  			= 	$res['OrderDate'];
				$time			=	$res['OrderTime'];	
				$OrderDate 		= 	date("d/m/Y",$date);
				$OrderTime 		= 	date("g:i A",$time);
				$PaymentMethod1 =	$res['PaymentMethods'];
				$puchaseorder   =   $res['PurchaseOrderNumber'];

				if($puchaseorder!=''){
				$puchaseorder   =  "<strong>Your PO No : </strong>".$puchaseorder;
				}

				if($PaymentMethod1 == 'chequePostel'){
				$PaymentMethod = "Pending payment" ;
				$pamentOrder='Cheque or BACS';
				}
				
						
				
				if($PaymentMethod1 == 'creditCard'){
				$pamentOrder='Credit card';
				$PaymentMethod = "Pending processing" ;
				}
				
				
				
				if($PaymentMethod1 == 'purchaseOrder'){
				$pamentOrder='Purchase order';
				$PaymentMethod = "Pending payment" ;
				}
				
				
				
				if($PaymentMethod1 == 'paypal'){
				$pamentOrder='PayPal';
				$PaymentMethod = "Completed";
				}



				if ($PaymentMethod1=='purchaseOrder')
				{
				$paymentMethod='Purchase Orders';
				}
				elseif ($PaymentMethod1=='chequePostel')
				{
				$paymentMethod='Cheque or BACS';
				}
				elseif ($PaymentMethod1=='creditCard')
				{
				$paymentMethod='Credit Card';
				}
				elseif($PaymentMethod1=='paypal')
				{
				$paymentMethod='Pay pal';
				}elseif($PaymentMethod1=='account')
				{
				$paymentMethod='Account';
				}
				
				$websiteOrders="Website";


 
			

					$BillingTitle 		=	$res['BillingTitle'];	
					$BillingFirstName 	=	$res['BillingFirstName'];	
					$BillingLastName 	=	$res['BillingLastName'];	
					$BillingCompanyName =	$res['BillingCompanyName'];		
					$BillingAddress1 	=	$res['BillingAddress1'];	
					$BillingAddress2 	=	$res['BillingAddress2'];	
					$BillingTownCity 	=	$res['BillingTownCity'];		
					$BillingCountyState =	$res['BillingCountyState'];	
					$BillingPostcode 	=	$res['BillingPostcode'];	
					$BillingCountry 	=	$res['BillingCountry'];		
					$Billingtelephone 	=	$res['Billingtelephone'];	
					$BillingMobile1 	=	$res['BillingMobile'];	
					$Billingfax 		=	$res['Billingfax'];
					$BillingResCom 		=	$res['BillingResCom'];
					$DeliveryTitle 		=	$res['DeliveryTitle'];		
					$DeliveryFirstName 	=	$res['DeliveryFirstName'];	
					$DeliveryLastName 	=	$res['DeliveryLastName'];	
					$DeliveryCompanyName=	$res['DeliveryCompanyName'];	 
					$DeliveryAddress1  	=	$res['DeliveryAddress1'];	
					$DeliveryAddress2 	=	$res['DeliveryAddress2'];	
					$DeliveryTownCity 	=	$res['DeliveryTownCity'];	
					$DeliveryCountyState=	$res['DeliveryCountyState'];	 
					$DeliveryPostcode 	=	$res['DeliveryPostcode'];	
					$DeliveryCountry 	=	$res['DeliveryCountry'];
					$DeliveryResCom 	=	$res['DeliveryResCom'];
					$styleBillingCompnay = "";
					$styleDeliveryCompany = "";

		

			if($BillingCompanyName!=''){		
			$styleBillingCompnay="<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>";
			$styleBillingCompnay.=$BillingCompanyName."</td></tr>";
			}
			
			
			
			if($DeliveryCompanyName!=''){
			$styleDeliveryCompany="<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>".
			$styleDeliveryCompany.=$DeliveryCompanyName."</td></tr>";
			}

		

		
            $exchange_rate          =   $res['exchange_rate'];  
			$currencySymbol 		= "&pound;";
			$vatRate 				= "20.00";
			$DeliveryOption 		=	"";
			$deliveryChargesExVat 	=	number_format($res['OrderShippingAmount']/(($vatRate+100)/100),2,'.','');	



			if($deliveryChargesExVat){
			$DeliveryExVatCost 	=	$deliveryChargesExVat;	
			}else{
			$DeliveryExVatCost 	=	'0.00';
			}



			if($res['OrderShippingAmount']){
			$DeliveryIncVatCost = number_format($res['OrderShippingAmount'],2,'.','');	
			}
			else
			{
			$DeliveryIncVatCost ='0.00';
			}	

           
			$OrderTotalExVAT 		=	number_format($res['OrderTotal']/1.2,2);	
			$OrderTotalIncVAT 		= 	number_format($res['OrderTotal'],2);
			$CompanyName 				= 	"AALABELS";

		

			$orderecords = $this->db->get_where('orderdetails', array('OrderNumber' => $OrderNumber));
			$num_row = $orderecords->num_rows();
			$info_order = $orderecords->result_array();
			$TotalQuantity = "";
			$SubTotalExVat1 = "";
			$SubTotalIncVat1 = "";
			$rows = "";
			$i = 0;
            $bgcolor='';				

		foreach($info_order as $rec){

                        
				
				$prl             =   $rec['Prl_id'];          
				$ProductName     = 	 $rec['ProductName'];
				$PriceExVat1	 =   $rec['Price'];
				$PriceExVat      =   $PriceExVat1;
				$UnitPrice	     =	 number_format(round(($rec['Price']/$rec['Quantity']), 4),4,'.','');	
				$PriceIncVat     =   number_format(($rec['ProductTotal']),2,'.','');		
				$Quantity	     =   $rec['Quantity'];
				$TotalQuantity	+=   $Quantity;
				$ProductCode     =	 $rec['ProductID'];
				
				

				if($rec['ManufactureID']=="PRL1" || $rec['ManufactureID']=="SCO1"){
				$ManufacturerId = $rec['ManufactureID'];
				}else{
				$ManufacturerId  = $this->menufacture($ProductCode);
				$ManufacturerId = $ManufacturerId[0]->ManufactureID; 
				}

				if($bgcolor==''){
				$bgcolor = '#F5F5F5';
				}else{
				$bgcolor = '';
				}

				 if($rec['Printing']=="Y"){	
				   $totallabelsused = $this->calculate_total_printed_labels($rec['SerialNumber']);
				}else{
					  if(isset($rec['is_custom']) and $rec['is_custom']=='Yes'){
					    $LabelsPerSheet = $rec['LabelsPerRoll'];
				      }else{
					    $LabelsPerSheet = $this->accountModel->LabelsPerSheet($rec['ProductID']);
				      }
					  $totallabelsused = $Quantity*$LabelsPerSheet;
				 }
				
				 
				 if($rec['ManufactureID']=="SCO1"){
				   $custominfo = $this->quoteModel->fetch_custom_die_order($rec['SerialNumber']);
				   $iseuro = ($custominfo['iseuro']==1)?"Yes":"No";
				   
				    $ProductName = '<b>Format:</b> '.$custominfo['format'].'&nbsp;&nbsp;  <b>Shape:</b> '.$custominfo['shape'].'&nbsp;&nbsp; <b>Width:</b> '.$custominfo['width'].' mm  &nbsp;&nbsp;';
			
			if($custominfo['shape']!="Circle"){	   
			  $ProductName.='<b>Height:</b> '.$custominfo['height'].' mm&nbsp;&nbsp;';
			}
		   $ProductName.='<b>No. labels / Die:</b> '.$custominfo['labels'];
	 }



			$rows .='<tr bgcolor="'.$bgcolor.'" height="25">

						<td valign="top">

							'.$ManufacturerId.'

						</td>

						<td valign="top">

							'.$ProductName.'

						</td>
						<td valign="top">

							'.$totallabelsused.'

						</td>
						
						
						<td valign="top">

							'.symbol.number_format($UnitPrice*$exchange_rate,2).'

						</td>
						
						<td valign="top">

							

							'.$Quantity.'

						</td>
						


						

						<td valign="top">

							'.symbol.number_format($PriceExVat*$exchange_rate,2).'

						</td></tr>';

//////////////////////////////////////////////
				 $printexvat =0; $printincvat =0;	
					//if($rec['Printing']=="Y" && preg_match('/A4/is',$rec['ProductName'])){
					if($rec['Printing']=="Y"){		
					$path = base_url()."aalabels/img/blue-tick.png";
					
					
					/*if($rec['Print_Type']=="Mono"){
				  		 $desntype = "Monochrome (Black Only)";
				  		 $typeshow = "Black Text";
					}else
					if($rec['Print_Type']=="Fullcolour+White"){
							$desntype = "Full colour + White";
							$typeshow = "Full colour + White";
					}else
					if($rec['Print_Type']=="Fullcolour"){
							$desntype = "Full colour";	
							$typeshow = "Full colour";	
					}*/
					
					$desntype = $typeshow = $this->orderModel->get_printing_service_name($rec['Print_Type']);
					
					
					
$first =  '<img src="'.$path.'" width="12" height="12"/><b>' .$typeshow.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$second =  '<img src="'.$path.'" width="12" height="12"/><b>' .$rec['Print_Design'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';					
$free = $rec['Print_Qty'] - $rec['Free'];

			        if($rec['Free'] >= $rec['Print_Qty']){
			        $free = 0;
			         }
					 
					 if($rec['Print_Design']=="1 Design"){
$third =  '<img src="'.$path.'" width="12" height="12"/>' .'&nbsp;&nbsp;<b>'.$rec['Print_Qty']." Design ".$desntype.'</b>';	
				
					 } else
		            if($rec['Print_Design']=="Multiple Designs"){
	
$third =  '<img src="'.$path.'" width="12" height="12"/>' .'&nbsp;&nbsp;<b>'.$rec['Print_Qty']." Designs ".$desntype."( ". $free." + ".$rec['Free']." Free )</b>";	
					}
					
				
				
					
		$rows .='<tr bgcolor="'.$bgcolor.'" height="25">
					<td valign="top"></td>
<td valign="top" style="font-size:10px;color:#43a2cb"> '.$first.'  '.$second.'  '.$third.'</td>
<td valign="top"></td>
<td valign="top">'.symbol.' '.number_format($rec['Print_UnitPrice']*$exchange_rate,2).'</td>
<td valign="top">'.$rec['Print_Qty'].'</td>
<td valign="top">'.symbol.' '.number_format($rec['Print_Total']*$exchange_rate,2).'</td></tr>';



                 $printexvat = $rec['Print_Total'];
		         $printincvat = $rec['Print_Total']*1.2;
			}
			
		if($rec['ManufactureID']=="SCO1" && $rec['Linescompleted']==0){
			$cuspriceexvat = $custominfo['plainprice'] + $custominfo['printprice'];
			$cuspriceincvat = $cuspriceexvat*1.2; 
			$printexvat  = $cuspriceexvat;
			$printincvat = $cuspriceincvat;
			
			$setupline='<b>Material:</b> '.$custominfo['material'].'&nbsp;&nbsp;';
			$ldrg = ($custominfo['shape']=="Circle")?$custominfo['width']:$custominfo['width'];
			
			
			if($custominfo['format']=="Roll"){
			  $setupline.='<b>Leading Edge:</b> '.$ldrg.' mm &nbsp;&nbsp;<b>No of Rolls:</b> '.$custominfo['qty'].'&nbsp;&nbsp; <b>Total Labels:</b> '.$custominfo['rolllabels'].'&nbsp;&nbsp; <b>Core Size:</b> '.$custominfo['core'].'&nbsp;&nbsp; <b>Wound:</b> '.$custominfo['wound'];
			}else{
			  $setupline.='<b>No of Sheets:</b> '.$custominfo['qty'].' &nbsp;&nbsp;';
			}
			$setupline.='&nbsp;&nbsp;<b>Corner radius:</b> '.$custominfo['cornerradius'].' mm &nbsp;&nbsp;';
			
			if($custominfo['labeltype']=="printed"){
              $setupline.='<b>Printing:</b> '.$custominfo['printing'].'&nbsp;&nbsp; <b>No. Designs:</b> '.$custominfo['designs'];
			     if($custominfo['format']=="Roll"){
				   $setupline.='&nbsp;&nbsp;<b>Finishing:</b> '.$custominfo['finish'];
				 }
			}
			
			
			
				
		$rows .='<tr bgcolor="'.$bgcolor.'" height="25">
				<td valign="top"></td>
<td valign="top" style="font-size:10px;color:#43a2cb">'.$setupline.'</td>
<td valign="top"></td>
<td valign="top"></td>
<td valign="top">'.symbol.' '.number_format($cuspriceexvat*$exchange_rate,2).'</td>
<td valign="top">'.symbol.' '.number_format($cuspriceexvat*$exchange_rate,2).'</td></tr>';
		
		}	
						
						
	$lineexvat  = $PriceExVat  +  $printexvat;
	$lineincvat = $PriceIncVat +  $printincvat;						
						
						
//////////////////////////////////////////////////	


						

						if($ManufacturerId=="PRL1"){

						$result = $this->quoteModel->get_details_roll_quotation($prl);

						$rows .='<tr bgcolor="'.$bgcolor.'" height="25">

						<td valign="top"></td>	
						

						<td valign="top">

						<b>Shape:</b> '.$result['shape'].' &nbsp;&nbsp;

						<b>Material:</b> '.$result['material'].' &nbsp;&nbsp;

						<b>Printing:</b> '.$result['printing'].' &nbsp;&nbsp;

						<b>Finishing:</b> '.$result['finishing'].' &nbsp;&nbsp;

						<b>No. Designs:</b> '.$result['no_designs'].' &nbsp;&nbsp;

						<b>No. Rolls:</b> '.$result['no_rolls'].' &nbsp;&nbsp;

						<b>No. labels:</b> '.$result['no_labels'].' &nbsp;&nbsp;

						<b>Core Size:</b> '.$result['coresize'].' &nbsp;&nbsp;

						<b>Wound:</b> '.$result['wound'].' &nbsp;&nbsp;

						<b>Notes:</b> '.$result['notes'].' &nbsp;&nbsp;

						

						</td>	

						<td valign="top"></td>	

						<td valign="top"></td>
						<td valign="top"></td>		

						<td valign="top"></td></tr>';

						}

						
$rows .='<tr bgcolor="'.$bgcolor.'" height="25">

			

			<td valign="top"></td>	

			<td valign="top"></td>

			<td valign="top" colspan="2">Line Total:</td>

			<td valign="top"></td>

			<td valign="top">

							'.symbol.number_format($lineexvat*$exchange_rate,2).'

						</td></tr>';

						

			
              $SubTotalExVat1  += $lineexvat;
              $SubTotalIncVat1 += $lineincvat;

			

		$i++;

		}

		 	

				$SubTotalExVat	=	number_format($SubTotalExVat1,2,'.','');	
				$SubTotalIncVat	=	number_format($SubTotalIncVat1,2,'.','');	
				
				$OrderTotalExVAT1	=	$DeliveryExVatCost+$SubTotalExVat;
				
				$OrderTotalExVAT	 =	number_format($OrderTotalExVAT1,2,'.','');	
				$OrderTotalIncVAT	=	number_format(($DeliveryIncVatCost+$SubTotalIncVat1),2,'.','');	

		

				$exvatSubtotalExVat   =  symbol.number_format($SubTotalExVat*$exchange_rate,2);
				$exvatSubtotalIncVat  =  symbol.number_format($SubTotalIncVat*$exchange_rate,2);
				
				
				
				$deliveryExVat   =  symbol.number_format($DeliveryExVatCost*$exchange_rate,2);
				$deliveryIncVat  =  symbol.number_format($DeliveryIncVatCost*$exchange_rate,2);
				
				$gtotalExVat     =  symbol.number_format($OrderTotalExVAT*$exchange_rate,2);
				$gtotalIncVat    =  symbol.number_format($OrderTotalIncVAT*$exchange_rate,2);

			    $vatTotal = number_format($OrderTotalIncVAT-$OrderTotalExVAT,2,'.','');	


                          

			$bill_rc=$res['BillingCompanyName'];

			$del_rc=$res['DeliveryCompanyName'];

			$email = $res['Billingemail'];

	

	    if(isset($res['CustomOrder']) && $res['CustomOrder']!="" && $res['CustomOrder']!=0){
		$mailid=127; 

		}else{
		$mailid=3; 	
		}

		$sql = $this->db->get_where(Template_Table, array('MailID' =>$mailid));
    
		$result = $sql->result_array();

		$result = $result[0];

		$mailTitle = $result['MailTitle'];

		$mailName = $result['Name'];

		$from_mail = $result['MailFrom'];

		$mailSubject = $result['MailSubject'] .' : '.$OrderNumber;

		$mailText = $result['MailBody'];

		

	   $strINTemplate   = array("[WEBROOT]","[FirstName]", "[OrderNumber]", "[OrderDate]", "[OrderTime]", "[PaymentMethod]",

	  "[BillingTitle]", "[BillingFirstName]", "[BillingLastName]",

	  "[BillingCompanyName]", "[BillingAddress1]", "[BillingAddress2]", "[BillingTownCity]", "[BillingCountyState]", 

	  "[BillingPostcode]", "[BillingCountry]", "[Billingtelephone]", "[BillingMobile]", "[Billingfax]", "[EmailAddress]", 

	  "[DeliveryTitle]", "[DeliveryFirstName]", "[DeliveryLastName]" ,"[DeliveryCompanyName]", "[DeliveryAddress1]", 

	  "[DeliveryAddress2]", "[DeliveryTownCity]", "[DeliveryCountyState]", "[DeliveryPostcode]", "[DeliveryCountry]", 

	  "[ProductCode]", "[ProductName]", "[Quantity]", "[PriceExVat]", "[PriceIncVat]", "[SubTotalExVat]", "[SubTotalIncVat]", 

	  "[OrderSubTotal]", "[DeliveryOption]", "[DeliveryExVatCost]","[DeliveryIncVatCost]", "[OrderTotalExVAT]",

	  "[OrderTotalIncVAT]", "[OrderItems]" ,"[Currency]", "[Packaging]","[incvat]","[exvat]","[deliveryexvat]",

	  "[deliveryincvat]","[deliveryoption]","[gtotalExvat]","[gtotalIncvat]","[paymentMethods]","[styleBillingConpnay]",

	  "[styleDeliveryConpnay]","[vatprice]","[pamentOrder]","[weborder]","[BillingResCom]","[DeliveryResCom]","[voucherDiscount]","[VATNUMBER]","[PONUMBER]");

  

  		$webroot = base_url(). "theme/";

        //----------------------------------------------------------------------------------------------

                $qry1 = "select `UserID` from `orderdetails` where `OrderNumber` = '".$OrderNumber."'";

                $exe1 = mysql_query($qry1);

                $res1 = mysql_fetch_array($exe1);

                $qry2 = "select * from `customers` where `UserID` = '".$res1['UserID']."'";

                $exe2 = mysql_query($qry2);

                $res2 = mysql_fetch_array($exe2);

	//-----------------------------------------------------------------------------------------------                



          $DeliveryExVatCost = symbol.number_format($DeliveryExVatCost*$exchange_rate,2);

               
				
				
           /*--------------------------Voucher Code--------------------*/

		if($res['voucherOfferd']=='Yes'){

			$voucherDiscount = $res['voucherDiscount'];

			$voucher_code = '<tr height="20px;"><td colspan="2">&nbsp;</td><td align="right" colspan="3" >Voucher Discount: </td><td align="top">&pound;'.$voucherDiscount.'</td></tr>';

		}

		else{

			 $voucherDiscount = 0.00;

			 $voucher_code ='';

		}

		$gtotalIncVat = number_format($OrderTotalIncVAT - $voucherDiscount,2,'.','');

		
		    if($res['vat_exempt']=='yes'){
				$gtotalIncVat  = number_format($OrderTotalExVAT - $voucherDiscount,2,'.','');	
				$vatTotal=0.00;
			}else{
			    $vatTotal =  symbol.number_format($vatTotal*$exchange_rate,2);			
			 }
		
              $gtotalIncVat    =  symbol.number_format($gtotalIncVat*$exchange_rate,2);
		    

		 /*--------------------------Voucher Code--------------------*/





	  $strInDB  = array($webroot,$BillingFirstName, $OrderNumber, $OrderDate, $OrderTime, $PaymentMethod, $BillingTitle,

	  $BillingFirstName, $BillingLastName, 

	  $BillingCompanyName, $BillingAddress1, $BillingAddress2, $BillingTownCity, $BillingCountyState, 

	  $BillingPostcode, $BillingCountry, $Billingtelephone, $BillingMobile1, $Billingfax, $EmailAddress, 

	  $DeliveryTitle, $DeliveryFirstName, $DeliveryLastName,$DeliveryCompanyName, $DeliveryAddress1, 

	  $DeliveryAddress2, $DeliveryTownCity, $DeliveryCountyState, $DeliveryPostcode, $DeliveryCountry, 

	  $ManufacturerId, $ProductName, $Quantity, $PriceExVat, $PriceIncVat, $SubTotalExVat, $SubTotalIncVat, 

	  '', $DeliveryOption, $DeliveryExVatCost,$DeliveryIncVatCost, $OrderTotalExVAT, 

	  $OrderTotalIncVAT, $rows,$currencySymbol, '',$exvatSubtotalIncVat,$exvatSubtotalExVat,$deliveryExVat,$deliveryIncVat,$DeliveryOption,$gtotalExVat,$gtotalIncVat,$PaymentMethod,$styleBillingCompnay,$styleDeliveryCompany,$vatTotal,$pamentOrder,$websiteOrders,$bill_rc,$del_rc,$voucher_code,$res['CustomOrder'],$puchaseorder);

	 

	  $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
	  

	  			$this->load->library('email');

				$this->email->from($from_mail, 'AALABELS');

				$this->email->to($EmailAddress); 

				$this->email->subject($mailSubject);

				$this->email->message($newPhrase);
                                
				$this->email->set_mailtype("html");

				$this->email->send();

	}
	public function calculate_lba_in_cart(){
			
			
			$cookie = $_COOKIE['ci_session'];
			$cookie = stripslashes($cookie);
			$cookie = unserialize($cookie);
			$cisess_session_id = $cookie['session_id'];  
			$session_id = $this->session->userdata('session_id');
			
			
			 $result = $this->db->query("select count(ID) as total from temporaryshoppingbasket 
			 WHERE (SessionID = '".$session_id."'  OR SessionID ='".$cisess_session_id."') ");
			 $row = $result->row_array();
			 $total = $row['total'];
			 $result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE  
			 (Select ProductBrand From products WHERE temporaryshoppingbasket.ProductID = products.ProductID) LIKE 'Application Labels' 
			 AND (SessionID = '".$session_id."'  OR SessionID ='".$cisess_session_id."') ");
			 $row = $result->row_array();
			 if($total == $row['total'])return "lba";
			 else return "mixed";
	 }
	function printing_count_items(){
			$cookie = $_COOKIE['ci_session'];
			$cookie = stripslashes($cookie);
			$cookie = unserialize($cookie);
			$cisess_session_id = $cookie['session_id'];  
			$session_id = $this->session->userdata('session_id');
				
			$result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE  Printing LIKE 'Y' AND 
			(SessionID = '".$session_id."'  OR SessionID ='".$cisess_session_id."') ");
			$row = $result->row_array();
			return $row['total'];
	}		

	function ReplaceHtmlToString_($text ){

      


		$utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
    );
    return $string =  preg_replace(array_keys($utf8), array_values($utf8), $text);
  
	}

	function printing_order_count($OrderNumber){
		$result = $this->db->query("select count(*) as total from orderdetails WHERE OrderNumber LIKE '".$OrderNumber."' AND  Printing LIKE 'Y' and regmark = 'N' ");
		$row = $result->row_array();
		return $row['total'];
   }
   
   function get_total_printed_labels($cartid, $ProductID){
	 		$labels = $this->db->query(' Select SUM(labels) as labels from integrated_attachments
			WHERE CartID LIKE "'.$cartid.'" AND ProductID LIKE "'.$ProductID.'" ')->row_array();
			return $labels['labels'];
	}
	
	function get_printing_service_name($process){
			
			if($process == 'Fullcolour'){
					$A4Printing = ' 4 Colour Digital Process ';
			}
			else if($process == 'Mono' || $process == 'Monochrome – Black Only'){
					$A4Printing = ' Monochrome &ndash; Black Only ';
			}else{
				
					
					$A4Printing = $process;
			}
			return $A4Printing;
			
	}
	
	function get_printed_files($cartid, $ProductID){
	  $q = $this->db->query(" select * from integrated_attachments WHERE ProductID =$ProductID AND 
	  CartID=$cartid AND status LIKE 'confirm' ORDER BY ID ASC ");
	  return $q->result(); 
	}
	
	function order_discount_applied(){
				
				$cisess_session_id = $this->get_website_session_id();
				$session_id = $this->session->userdata('session_id');
				$where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";
				
				$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE ".$where);
				$res   = $qry->row_array();
				return $res;  
	}
	function get_website_session_id(){
				$cookie = $_COOKIE['ci_session'];
				$cookie = stripslashes($cookie);
				$cookie = unserialize($cookie);
				$cisess_session_id = $cookie['session_id'];  
				return 	$cisess_session_id;
	}
	
	function calculate_total_printedroll_amount(){
			return false;	
		$cisess_session_id = $this->get_website_session_id();
		$session_id = $this->session->userdata('session_id');
		$where = "( SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."' )";
		
		$query = $this->db->query(" SELECT SUM(TotalPrice) AS total from products INNER JOIN temporaryshoppingbasket ON 
									products.ProductID=temporaryshoppingbasket.ProductID WHERE $where AND 
									temporaryshoppingbasket.Printing LIKE 'Y' AND  (ProductBrand LIKE 'Roll Labels')");
		$row = $query->row_array();	
		if(isset($row['total']) and $row['total']!=''){
			return ($row['total']*1.2) * 0.1;
				
		}else{
			return false;	
		}
   }
   
   function calculate_total_printed_labels($serial){
		
		$query = $this->db->query(" SELECT SUM(labels) AS total from order_attachments_integrated WHERE Serial LIKE '".$serial."'  ");
		$row = $query->row_array();	
		return $row['total'];
   }
	
	 public function getdesigntotal($cartid){
     $row  = $this->db->select('Print_Qty')
	 ->where('ID',$cartid)
	 ->get('temporaryshoppingbasket');
	 $row = $row->row_array();
	 return $row['Print_Qty'];
   }
   
   //  *******************------------------------*********************------------------------*******************************
   
   
    public function quotation_design_total($serial){
     $row  = $this->db->select('Print_Qty')
	 ->where('SerialNumber',$serial)
	 ->get('quotationdetails');
	 $row = $row->row_array();
	 return $row['Print_Qty'];
   }
	
	public function get_quotation_files($serial,$ProductID){
	  $q = $this->db->query(" select * from quotation_attachments_integrated WHERE ProductID = $ProductID AND 
	  Serial = $serial ORDER BY ID ASC ");
	  return $q->result(); 
	}
	
		function get_db_column($table, $column, $key, $value){
		$row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '".$value."' LIMIT 1 ")->row_array();		
		return (isset($row[$column]) and $row[$column]!='')?$row[$column]:'';
	}
	
	  function checkforinvoice($order){
		$sql = $this->db->query("select * from invoice where OrderNumber LIKE '$order' and InvoiceType LIKE 'Invoice'");
		$result = $sql->num_rows();
		if($result>0){ return true;}else{ return false; }
	}
	
	public function check_order_placed($email,$date){
		//$yes = "no";
		//$dat = $this->db->query("select * from orders where Billingemail like '".$email."' and BillingPostcode like '".$postcode."' AND `OrderDate`  > '".$date."' ")->result();
		$dat = $this->db->query("select * from orders where Billingemail like '".$email."' AND `OrderDate`  > '".$date."' ")->result();
		$count = count($dat);
		if($count){
			//$yes = "yes";
			return $dat[0]->OrderNumber;
		}else{
			return "no";
		}
	}
	public function check_order_placed_old($postcode,$date){
		$yes = "no";
		$dat = $this->db->query("select * from orders where BillingPostcode like '".$postcode."' AND FROM_UNIXTIME( `OrderDate` ) > FROM_UNIXTIME($date) ")->result();
		$count = count($dat);
		if($count){
			$yes = "yes";
			return $yes;
		}else{
			return $yes;
		}
	}
	
	public function printing_order_items($ordernumber){
	  $row = $this->db->query("select count(*) as total from orderdetails WHERE OrderNumber LIKE '".$ordernumber."' and Printing LIKE 'Y'")->row_array();
      return $row['total'];
     }

  
    public function insert_payment_log($type,$ordermo,$payment,$situation=NULL){
	 $situation = (isset($situation) && $situation=="refund")?"refund":"taken";	
	 $array = array('type'=>$type,'OrderNumber'=>$ordermo,'operator'=>$this->session->userdata('UserName'),'payment'=>$payment,'situation'=>$situation,'time'=>time());
	 $this->db->insert('order_payment_log',$array); 
    }

}



?>
