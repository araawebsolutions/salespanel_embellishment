<?php

class Shopping_model extends CI_Model{

	

	function __construct(){

		parent::__construct();
        $this->load->model('order_quotation/orderModal');
		

	}

	function sessionid()

	{

		return $this->session->userdata('session_id');

	}

function show_quotation_basket(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');
		
		
		$qry = $this->db->query("SELECT * FROM tempquotationbasket WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ORDER BY `tempquotationbasket`.`ID`  ASC");

		return $qry->result();

   }

	function total_order(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');
		
		
		$price = $this->db->query("SELECT sum(`TotalPrice`+`Print_Total`) as amount FROM temporaryshoppingbasket WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		$res = $price->result();

		return $res[0]->amount;

	}

	function cart_count(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');
		 
		$qry = $this->db->query("SELECT count(*) as total FROM temporaryshoppingbasket WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ORDER BY `temporaryshoppingbasket`.`ID`  ASC");

		$row = $qry->row_array();

		return $row ['total'];

	}

	

	function show_cart(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');

		$qry = $this->db->query("SELECT * FROM temporaryshoppingbasket WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ORDER BY `temporaryshoppingbasket`.`ID`  ASC");

		return $qry->result();

	}



	public function emptcart(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
		
		$del = $this->db->query("Delete from temporaryshoppingbasket WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )");
		$this->session->unset_userdata("userid");
		$this->session->unset_userdata('payment_redirection');

    }

	function show_product($pid){

		$qry = $this->db->query("SELECT * FROM products WHERE ProductID  = ".$pid."");

		return $qry->result_array();

	}

   function delete_product_cart($id){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
	   

		$qry = $this->db->query("DELETE FROM temporaryshoppingbasket WHERE ID = $id AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		if($qry){
           $qry = $this->db->query("DELETE FROM integrated_attachments WHERE CartID = $id AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

			return true;

		}

	}

	

	function get_deliveryCharges($id){

         $qry = $this->db->query("select `BasicCharges` from `shippingservices` where `ServiceID` = '".$id."'");

         $res = $qry->result();

         return $res[0]->BasicCharges;

        }

	

	function delevery($offshore=NULL){

	

		$amount = $this->total_order();

		$amount = $amount*1.2; 

        $xmass = $this->shopping_model->is_xmass_labels();

		$printing = $this->printing_count_items();

		$sample = $this->is_order_sample();

		$lba = $this->calculate_lba_in_cart();

		$integrated = $this->is_order_integrated();

		if(($sample=='sample' || $lba =='lba' ) || ($printing > 0 && $offshore['status']==false)){

	
			// AA27 STARTS
				$qry = $this->db->query("select * from shippingservices where ServiceID=20  order by sorting asc");
			// AA27 ENDS

			// AA21 STARTS
            $delivery = $qry->result_array();
            $delivery = $this->getCourierDeliveryCharges($delivery);
            return $delivery;
            // AA21 ENDS

		}

		if($integrated > 0)

		{

			$delivery_charges = $this->shopping_model->get_integrated_delivery_charges();

		}

		if($xmass > 0){
			// AA27 STARTS
				$qry = $this->db->query("select * from shippingservices where ServiceID=12  order by sorting asc");
			// AA27 ENDS

			return $qry->result_array();

		}

		else if($offshore['status']==true){

			

			$condtion = '';

			$serviceid = $offshore['serviceid'];

			$countryid = $this->session->userdata('countryid');

			

		    if(isset($serviceid) and ($serviceid==13 || $serviceid==14 || $serviceid==15)){

					if($serviceid==15){$freeorder_over = 100;} //UK Exception Postcodes

					else if($serviceid==13 || $serviceid==14){ 	$freeorder_over = 75;} //Offshore postcodes

			}

			else{	

					$freeorder_over = $this->home_model->get_db_column('shippingcountries','freeorder_over', 'ID', $serviceid);

			}

			if($amount < $freeorder_over || $integrated > 0){

					$condtion = ' AND BasicCharges > 0 ';

			}

			$qry = $this->db->query("select * from shippingservices where CountryID=$serviceid $condtion order by BasicCharges asc");

			$result = $qry->result_array();

			return $result;

			//$countryid = $this->session->userdata('countryid');

		}

		else if($amount < 25.00 ){
			// AA27 STARTS
				$qry = $this->db->query("select * from shippingservices where ServiceID!=20 AND CountryID = '1'  order by sorting asc");
			// AA27 ENDS

			// AA21 STARTS
            $delivery = $qry->result_array();
            $delivery = $this->getCourierDeliveryCharges($delivery);
            return $delivery;
            // AA21 ENDS

		}

		else{

			$printing = $this->printing_count_items();

			$lba = $this->calculate_lba_in_cart();

			if($printing > 0 || $lba =='lba'){
				// AA27 STARTS
					$qry = $this->db->query("select * from shippingservices where ServiceID=20  order by sorting asc");
				// AA27 ENDS

				// AA21 STARTS
	            $delivery = $qry->result_array();
	            $delivery = $this->getCourierDeliveryCharges($delivery);
	            return $delivery;
	            // AA21 ENDS

			}else{
				// AA27 STARTS
					$qry = $this->db->query("select * from shippingservices where CountryID = '1' and ServiceID !=19  order by sorting asc");
				// AA27 ENDS

			    // AA21 STARTS
	            $delivery = $qry->result_array();
	            $delivery = $this->getCourierDeliveryCharges($delivery);
	            return $delivery;
	            // AA21 ENDS

			}

		}

	}
	
	// AA21 STARTS
        function getCourierDeliveryCharges($delivery)
        {
            $courier = $this->session->userdata('courier');
            if( (isset($courier) && $courier == 'DPD') && count($delivery) > 0)
            {
                foreach ($delivery as $key => $eachDelivery)
                {
                    if($delivery[$key]['BasicCharges'] > 0){
                        $delivery[$key]['BasicCharges'] = number_format( ($eachDelivery['BasicCharges']+1) , 2);
                    }else{
                        $delivery[$key]['BasicCharges'] = number_format( ($eachDelivery['BasicCharges']) , 2);
                    }
                }
            }
            return $delivery;
        }
    // AA21 ENDS
    
    

	function delevery_old($offshore=NULL){

	

		$amount = $this->total_order();

		$amount = $amount*1.2; 

        $xmass = $this->shopping_model->is_xmass_labels();

		$printing = $this->printing_count_items();

		$sample = $this->is_order_sample();

		$lba = $this->calculate_lba_in_cart();

		$integrated = $this->is_order_integrated();

		if(($sample=='sample' || $lba =='lba' ) || ($printing > 0 && $offshore['status']==false)){

	

			$qry = $this->db->query("select * from shippingservices where ServiceID=20");

			return $qry->result_array();

		}

		if($integrated > 0)

		{

			$delivery_charges = $this->shopping_model->get_integrated_delivery_charges();

		}

		if($xmass > 0){

			$qry = $this->db->query("select * from shippingservices where ServiceID=12");

			return $qry->result_array();

		}

		else if($offshore['status']==true){

			

			$condtion = '';

			$serviceid = $offshore['serviceid'];

			$countryid = $this->session->userdata('countryid');

			

		    if(isset($serviceid) and ($serviceid==13 || $serviceid==14 || $serviceid==15)){

					if($serviceid==15){$freeorder_over = 100;} //UK Exception Postcodes

					else if($serviceid==13 || $serviceid==14){ 	$freeorder_over = 75;} //Offshore postcodes

			}

			else{	

					$freeorder_over = $this->home_model->get_db_column('shippingcountries','freeorder_over', 'ID', $serviceid);

			}

			if($amount < $freeorder_over || $integrated > 0){

					$condtion = ' AND BasicCharges > 0 ';

			}

			$qry = $this->db->query("select * from shippingservices where CountryID=$serviceid $condtion order by BasicCharges asc");

			$result = $qry->result_array();

			return $result;

			//$countryid = $this->session->userdata('countryid');

		}

		else if($amount < 25.00 ){

			$qry = $this->db->query("select * from shippingservices where ServiceID!=20 AND CountryID = '1' order by ServiceID asc");

			return $qry->result_array();

		}

		else{

			$printing = $this->printing_count_items();

			$lba = $this->calculate_lba_in_cart();

			if($printing > 0 || $lba =='lba'){

				$qry = $this->db->query("select * from shippingservices where ServiceID=20");

				return $qry->result_array();

			

			}else{

				$qry = $this->db->query("select * from shippingservices where CountryID = '1' order by ServiceID asc");

				return $qry->result_array();

			}

		}

	}

	function delevery_txt(){

		

		$amount = $this->total_order();

		$amount = $amount*1.2; 

		if($amount < 25.00 ){

			

			//$delivery_txt = 'Delivery Free over &pound;25.00 ';

			$price = $this->home_model->currecy_converter(25, 'no');

            $delivery_txt = 'Delivery Free over '.symbol.$price.' (inc. VAT) 3 - 5 working day service.';                        

		}

		else{

			

			$delivery_txt = ' Free delivery available ';

		}

		

		return $delivery_txt;

		

	}

	

	function order($orderNum){

		

		$result_qry = $this->db->query("SELECT * FROM orders  WHERE OrderNumber = '$orderNum'  ");

		$result = $result_qry->row_array();

		return $result;

	}

	

	function order_detail($orderNum){

		

	    $result_qry = $this->db->query(" SELECT * FROM orderdetails  WHERE  ( OrderNumber = '$orderNum' OR OrderNumber LIKE '".$orderNum."-S' ) ");

		$result = $result_qry->result_array();

		return $result;

	}

	

 function customize_image_name($pid){

		$qry = $this->db->query("SELECT Image1 FROM products WHERE ProductID  = ".$pid."");

		return $qry->result_array();

		 

	}

	

 function get_shipping($id){

		$qry = $this->db->query("SELECT * FROM shippingservices WHERE ServiceID  = ".$id."");

		return $qry->row_array();

		 

	}

	

	

	function last_order($userId){

		$qry = $this->db->query("SELECT `OrderNumber` FROM `orders` WHERE `UserID` = $userId ORDER BY `OrderDate` DESC Limit 0,1");

		$res = $qry->result();

		return $res;

	}

	

	function user_email(){

			$id=	$this->session->userdata('userid');

			$qry = $this->db->query("select UserEmail from customers where UserID='".$id."'");

			$res = $qry->result();

			return $res[0]->UserEmail;

	}

	function product_name($pid)

	{

		$qry = $this->db->query("SELECT ProductCategoryName FROM `products` WHERE `ProductID` = '$pid'");

		return $qry->result_array();

	}

	

	function add_order(){

		$usrid=$this->session->userdata('userid');

		if(isset($usrid) && $usrid!=''){ 
			$b_email = $this->user_email();
		}else{
			$b_email = $this->input->post('email');
		}

		$newsletter = $this->input->post('newslwtter_value');
		if(isset($newsletter) and  $newsletter =='on'){
			$this->home_model->newsletter($b_email);
		}
		$b_pcode = strtoupper($this->input->post('b_pcode'));
		$d_pcode = strtoupper($this->input->post('d_pcode'));
		$b_first_name = ucwords($this->input->post('b_first_name'));
		$b_last_name  = ucwords($this->input->post('b_last_name'));
		$b_add1 	  = ucwords($this->input->post('b_add1'));
		$b_add2 	  = ucwords($this->input->post('b_add2'));
		$b_city 	  = ucwords($this->input->post('b_city'));
		$b_organization = ucwords($this->input->post('b_organization'));
		$b_county 		= ucwords($this->input->post('b_county'));
		$d_first_name = ucwords($this->input->post('d_first_name'));
		$d_last_name = ucwords($this->input->post('d_last_name'));
		$d_organization = ucwords($this->input->post('d_organization'));
		$d_add1 = ucwords($this->input->post('d_add1'));
		$d_add2 = ucwords($this->input->post('d_add2'));
		$d_city = ucwords($this->input->post('d_city'));
		$d_county = ucwords($this->input->post('d_county'));
		$billing_title = $this->input->post('billing_title');
		$b_phone_no = $this->input->post('b_phone_no');
		$b_fax = $this->input->post('b_fax');
		$b_ResCom = $this->input->post('b_ResCom');
		$delivery_val = $this->input->post('delivery_val');
		$delivery_title = $this->input->post('title_d');
		$d_email = $this->input->post('d_email');
		$d_phone_no = $this->input->post('d_phone_no');
		$d_fax = $this->input->post('d_fax');
		$d_ResCom = $this->input->post('d_ResCom');
		$paymentway = $this->input->post('paymentway');
		$country = $this->input->post('country');
		$dcountry = $this->input->post('dcountry');
		$second_email = $this->input->post('second_email');
		$b_mobile = $this->input->post('b_mobile');
		$d_mobile_no = $this->input->post('d_mobile_no');
		/* IF set when user already login */

		if(isset($usrid)  and $usrid!=''){
			$data = array(
				'BillingTitle' => $billing_title,
				'BillingFirstName' => $b_first_name,
				'BillingLastName' => $b_last_name,
				'BillingAddress1' => $b_add1,
				'BillingTownCity' => $b_city,
				'BillingCountyState' => $b_county,
				'BillingPostcode' => $b_pcode,
				'BillingResCom'=>$b_ResCom,
				'DeliveryTitle' => $delivery_title,
				'DeliveryFirstName' => $d_first_name,
				'DeliveryLastName' => $d_last_name,
				'DeliveryAddress1' => $d_add1,
				'DeliveryTownCity' => $d_city,
				'DeliveryCountyState' => $d_county,
				'DeliveryPostcode' => $d_pcode,
				'DeliveryResCom'=>$d_ResCom,
				'Deliveryemail' => $d_email,
				'BillingCountry'=>$country,
				'DeliveryCountry'=>$dcountry,
				'DeliveryAddress2'=>$d_add2,
				'BillingAddress2'=>$b_add2);

			if($b_fax){
				$data = array_merge($data,array('Billingfax'=>$b_fax));
			}	
			if($b_organization){
				$data = array_merge($data,array('BillingCompanyName'=>$b_organization));
			}

			if($b_phone_no){
				$data = array_merge($data,array('Billingtelephone'=>$b_phone_no));
			}

			if($d_fax){
				$data = array_merge($data,array('Deliveryfax'=>$d_fax));
			}	

			if($d_organization){
				$data = array_merge($data,array('DeliveryCompanyName'=>$d_organization));
			}

			if($d_phone_no){
				$data = array_merge($data,array('Deliverytelephone'=>$d_phone_no));
			}

			if($second_email){
				$data = array_merge($data,array('SecondaryEmail' => $second_email));
			}

			if($b_mobile){
				$data = array_merge($data,array('BillingMobile' => $b_mobile));
			}

			if($d_mobile_no){
				$data = array_merge($data,array('DeliveryMobile' => $d_mobile_no));
			}

			$this->db->where('UserID',$usrid);
			$this->db->update('customers', $data);
		}
		else{
			$password = trim($this->input->post('re_customer_password'));
			$data = array( 'UserTypeID'=>'14',
										'UserEmail'=>$b_email,
										'UserName'=>$b_first_name,
										'BillingTitle' => $billing_title,
										'BillingFirstName' => $b_first_name,
										'BillingLastName' => $b_last_name,
										'BillingCompanyName' => $b_organization,
										'BillingAddress1' => $b_add1,
										'BillingAddress2' => $b_add2,
										'BillingTownCity' => $b_city,
										'BillingCountyState' => $b_county,
										'BillingPostcode' => $b_pcode,
										'Billingtelephone' => $b_phone_no,
										'Billingfax' => $b_fax,
										'BillingResCom'=>$b_ResCom,
										'DeliveryTitle' => $delivery_title,
										'DeliveryFirstName' => $d_first_name,
										'DeliveryLastName' => $d_last_name,
										'DeliveryCompanyName' => $d_organization,
										'DeliveryAddress1' => $d_add1,
										'DeliveryAddress2' => $d_add2,
										'DeliveryTownCity' => $d_city,
										'DeliveryCountyState' => $d_county,
										'DeliveryPostcode' => $d_pcode,
										'Deliverytelephone' => $d_phone_no,
										'Deliveryfax' => $d_fax,
										'DeliveryResCom'=>$d_ResCom,
										'Deliveryemail' => $d_email,
										'UserPassword'=>md5($password),
										'RegisteredDate'=>date('Y-m-d'),
										'RegisteredTime'=>date('H:i:s'),
										'BillingCountry' => $country,
										'DeliveryCountry' => $dcountry,
										'SecondaryEmail' => $second_email,
										'DeliveryMobile' => $d_mobile_no,
										'BillingMobile' => $b_mobile
									 );
			$this->db->insert('customers', $data);
			$uid=$this->db->insert_id();
			$newdata = array('userid'  => $uid,'UserName'  => $b_first_name,'logged_in' => true);
			$this->session->set_userdata($newdata);
			//new code
			$session_id = $this->session->userdata('session_id');
			$this->db->update('flash_user_design',array('UserID'=>$userid), array('SID'=>$session_id,'UserID'=>0));
		}
		$sessionid = $this->session->userdata('session_id');
		$this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
		$order_num = $this->db->insert_id();
		$user_type = $this->session->userdata('user_type');

		if($user_type == 'trade'){
			$OrderNumber = 'AT'.$order_num;
		}else{
			$OrderNumber = 'AA'.$order_num;
		}

		$userid = $this->session->userdata('userid');
		$sessionid = $this->session->userdata('session_id');
		$ServiceID = $this->session->userdata('ServiceID');
		$date = time();
		if(isset($userid) && !empty($userid)){ $userid = $userid; } else { $userid = ""; }
		if(isset($ServiceID) && !empty($ServiceID)){ $ServiceID = $ServiceID; } else { $ServiceID = "21"; }
		if(isset($BasicCharges) && !empty($BasicCharges)){ $BasicCharges = $BasicCharges; } else { $BasicCharges = "6.00"; }
		$amount = $this->total_order();
		$amount = $amount*1.2;
		$ip_add = $this->input->ip_address();
		$lo = $this->last_order($this->session->userdata('userid'));
		$last_order ='FIRST';
		if(count($lo)>0){
				$last_order = $lo[0]->OrderNumber;
		}
							
		$BasicCharges = $this->session->userdata('BasicCharges');
		$billing_email=$this->user_email();
               

    /**********-Voucher Code task changes Start-**************/

	  $black_friday =  $this->shopping_model->check_black_friday_offer($amount);

		if($black_friday['status']==false){
			$wtp_discount = $this->wtp_discount_applied_on_order();
			$voucher = $this->order_discount_applied();
		 } 

		if($black_friday['status']==true){
		     $discount_offer = $black_friday['discount_offer'];
		     $voucherOfferd = 'Yes';
				 $del = $this->db->delete('voucherofferd_temp', array('SessionID' => $sessionid,'UserID'=>$userid,'vc_type'=>'BF'));
				 $this->db->insert('black_friday',array('userid'=>$userid,'ordernumber'=>$OrderNumber));
		}
		else if($voucher){
		    $discount_offer = $voucher['discount_offer'];
		    $voucherOfferd = 'Yes';
		    $del = $this->db->delete('voucherofferd_temp', array('SessionID' => $sessionid,'UserID'=>$userid));
		}

		else if($wtp_discount){

			$discount_offer = $wtp_discount['discount_offer'];
			$voucherOfferd = 'Yes';
			$del = $this->db->delete('voucherofferd_temp', array('SessionID' => $sessionid));
		}
		else{
			$discount_offer = 0.00;
			$voucherOfferd = 'No';
		}
		$amount = $amount - $discount_offer;
		/**********-Voucher Code task changes End-**************/

		if($BasicCharges=="5.00"){$BasicCharges="6.00";}
		  /******************Sample Order implementation***********************/

				$sample = $this->shopping_model->is_order_sample();
				//$courier = "Fedex";
					$courier = "Parcelforce";
				

				if($sample=='sample'){
				    $courier = "";
				    $status = 33;
				    $paymentway =  'Sample Order';
				    $OrderNumber = $OrderNumber.'-S';
				    $BasicCharges = 0.00;
				    $ServiceID = 20;
				    $amount = $amount + $discount_offer;
				    $discount_offer = 0.00;
				    $voucherOfferd = 'No';


				}else{
						$status = 6;
						 $offshore = $this->product_model->offshore_delviery_charges_WPC($d_pcode, $dcountry);
		                if( ($dcountry == 'France') || ($dcountry == 'Luxembourg') || ($dcountry == 'Switzerland') || ($dcountry == 'Belgium') )
		                {
		                    $courier = "DPD";
		                }
		                else if( ($offshore['status'] != true) && ($dcountry == 'United Kingdom') )
		                {
		                    if($this->input->post('courier') != '')
		                    {
		                        $courier = $this->input->post('courier');
		                    }
		                }
				}

		 /******************Sample Order implementation***********************/

		 
		 $billing_postcode  =  strtoupper(substr($b_pcode,0,2));
		 $delivery_postcode  =   strtoupper(substr($d_pcode,0,2));
		 $PurchaseOrderNumber = ''; $Customer_VAT = '';
		 $vatnumber = 0;
		 $vat_exempt ='no';
		 $PurchaseOrderNumber = $this->input->post('PurchaseOrderNumber');
		 $VALIDVAT =  $this->session->userdata('vat_exemption');
		
		 if(isset($VALIDVAT) and $VALIDVAT=='yes' and $dcountry!='United Kingdom'){
		     $vatnumber = ($this->input->post('vatnumber') !=null)?$this->input->post('vatnumber'):0 ;
		     $vat_exempt ='yes';
		 }
		 else if($billing_postcode==$delivery_postcode and (strtoupper($delivery_postcode)=='JE' || strtoupper($delivery_postcode)=='GY')){
		     $vat_exempt ='yes';
		 }
		 $this->session->unset_userdata(array('vat_exemption'=>''));
		 $currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';
         $symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
         $exchange_rate =  $this->cartModal->get_exchange_rate($currency);
		 //$exchange_rate  = $this->home_model->get_exchange_rate(currency);
		/************************** Plain Packaging **********************/

		$plainpack=0;
		$plainpackaging = $this->home_model->get_db_column('customers', 'Label', 'UserID', $userid);

		if(isset($plainpackaging) and $plainpackaging==1){
		    //$plainpack=1;
			} 
	
		if($this->input->post('plain_labels')){
			$plainpack = $this->input->post('plain_labels');
		}
		
		
		/*****************************************************************/
		$data = array(  'OrderNumber' => $OrderNumber,
		                            'OrderDeliveryCourier' => $courier,
						            'OrderDeliveryCourierCustomer' => $courier,
									'SessionID' => $sessionid,
									'OrderDate' => $date,
									'OrderTime' => $date,
									'UserID' => $userid,
									'Label'=>$plainpack,
									'PaymentMethods' => $paymentway,
									'OrderShippingAmount' => $BasicCharges,
									'OrderTotal' => $amount,
									'TrackingIP' => $ip_add,
									'BillingTitle' => $billing_title,
									'BillingFirstName' => $b_first_name,
									'BillingLastName' => $b_last_name,
									'BillingCompanyName' => $b_organization,
									'BillingAddress1' => $b_add1,
									'BillingAddress2' => $b_add2,
									'BillingTownCity' => $b_city,
									'BillingCountyState' => $b_county,
									'BillingPostcode' => $b_pcode,
									'BillingCountry' => $country,
									'Billingtelephone' => $b_phone_no,
									'Billingfax' => ($b_fax !=null)?$b_fax:'',
									'Billingemail' => $b_email,
									'DeliveryTitle' => $delivery_title,
									'DeliveryFirstName' => $d_first_name,
									'DeliveryLastName' => $d_last_name,
									'DeliveryCompanyName' => $d_organization,
									'DeliveryAddress1' => $d_add1,
									'DeliveryAddress2' => $d_add2,
									'DeliveryTownCity' => $d_city,
									'DeliveryCountyState' => $d_county,
									'DeliveryPostcode' => $d_pcode,
									'DeliveryCountry' => $dcountry,
									'Deliverytelephone' => $d_phone_no,
									'DeliveryMobile' => $d_mobile_no,
									'BillingMobile' => $b_mobile,
									'Deliveryfax' => ($d_fax !=null)?$d_fax:'',
									'Deliveryemail' => $d_email,
									'Source' => $this->session->userdata('UserID'),
									'prevOrder' => $last_order,
									'ShippingServiceID'=>$ServiceID,
									'BillingResCom' =>($b_ResCom !=null)?$b_ResCom:'',
									'DeliveryResCom' =>($d_ResCom !=null)?$d_ResCom:'',
									'ServiceID'=> $ServiceID,
									'OrderStatus'=> $status,
									'voucherOfferd'=> $voucherOfferd,
									'voucherDiscount'=>$discount_offer,
									'CustomOrder'=>$vatnumber,
									'vat_exempt'=>$vat_exempt,
									'PurchaseOrderNumber'=>$PurchaseOrderNumber,
									'SecondaryEmail' => $second_email,
									'exchange_rate'=>$exchange_rate,
									'currency'=>$currency);

									$this->db->insert('orders', $data);
									$this->home_model->save_logs('save_order',$data);  //SAVE LOG

			//        $error = $this->db->error();

			//        if (isset($error['message'])) {

			//            print_r($error['message']);exit;

			//        }

		  /******************Sample Order implementation***********************/

				if($sample=='mixed'){
				    $courier = "";
					$status = 33;
					$paymentway =  'Sample Order';
					$OrderNumberSample = $OrderNumber.'-S';
					$BasicCharges = 0.00;
					$ServiceID = 20;
					$amount = 0.00;
					$discount_offer = 0.00;
					$voucherOfferd = 'No';
			

					$mixed_array = array('voucherOfferd'=>$voucherOfferd,
										 'voucherDiscount'=>$discount_offer,
										 'OrderDeliveryCourier' => $courier,
						                 'OrderDeliveryCourierCustomer' => $courier,
										 'OrderStatus'=>$status,
										 'ServiceID'=>$ServiceID,
										 'OrderNumber'=>$OrderNumberSample,
										 'PaymentMethods'=>$paymentway,
										 'OrderTotal'=>$amount,
										 'OrderShippingAmount'=>$BasicCharges);
					$data = array_merge($data, $mixed_array);
					$this->db->insert('orders', $data);	
				}




		/******************Sample Order implementation***********************/

		$cart = $this->show_cart();
		/*echo '<pre>';
		print_r('h = ');
		print_r($cart);
		exit;*/
        foreach($cart as $c)
        {
            $print_type = '';
            $pname = $this->product_name($c->ProductID);
            $prodName = $pname[0]['ProductCategoryName'];
            $totalP = $c->TotalPrice*1.2;
            $menu=$this->menufacture($c->ProductID);
            $manf_id = $menu[0]->ManufactureID;
            $reordercode = $this->product_reordercode($c->ProductID);
            $reordercode = $reordercode[0]['ReOrderCode'];
            $ProductBrand = $this->GetProductBrand($c->ProductID);
            $designedlabels = '';
            if($c->source=='printing' && preg_match("/Roll Labels/i",$ProductBrand['ProductBrand'])){
                $designedlabels = $this->home_model->get_total_printed_labels($c->ID, $c->ProductID);
            }
            $orignalQty = (isset($c->orignalQty) && $c->orignalQty!="")?$c->orignalQty:'';
			
		
			$passvalue = ($c->Printing=="Y")?"":"plain";  
			if(preg_match('/Roll Labels/is',$ProductBrand['ProductBrand']) && $c->Printing=="Y" and $c->regmark != 'Y') {
              $prodName =  $this->orderModal->Printed_desc($c->wound,$c->Print_Type,$prodName,$c->orientation,$c->FinishType);
           }else{
            $prodName =  $this->orderModal->customize_product_name($c->is_custom,$prodName,$c->LabelsPerRoll,$ProductBrand['LabelsPerSheet'],$reordercode,$manf_id,$ProductBrand['ProductBrand'],$c->wound,$c->OrderData,$passvalue);
           }

			//$prodName =  $this->orderModal->customize_product_name($c->is_custom,$prodName,$c->LabelsPerRoll,$ProductBrand['LabelsPerSheet'],$reordercode,$manf_id,$ProductBrand['ProductBrand'],$c->wound,$c->OrderData,$passvalue);
			
           if(preg_match('/Integrated Labels/is',$ProductBrand['ProductBrand'])){
		      $print_type = $c->OrderData;
            }
            if($c->OrderData=='Sample'){
				$print_type = $c->OrderData;
			}
            /************** new code for total labels calculations **********************/

            if($c->is_custom=='Yes'){
                $labelspersheet = $c->LabelsPerRoll;
						}
					else{
						$labelspersheet = $ProductBrand['LabelsPerSheet'];
					}
					$totallabelsused = $c->Quantity*$labelspersheet;
					
            if($c->Printing=='Y'){
                $printedlabelscount = $this->home_model->get_total_printed_labels($c->ID, $c->ProductID);
                if(isset($printedlabelscount) and $printedlabelscount > 0 and $printedlabelscount!=''){
                    $totallabelsused = $printedlabelscount;
								}
						}

            /************** new code for total labels calculations **********************/

					if(preg_match('/Integrated Labels/is',$ProductBrand['ProductBrand'])){
						$extra_int_text = ($c->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)";	
						$prodName.= $extra_int_text;
						$totallabelsused  = $c->orignalQty;
					}

   if(empty($prodName)){
       $prodName = $c->p_name;
  }
            if(empty($manf_id)){
                $manf_id = $c->p_code;
            }
            $data_ins = array(
                'UserID' => $userid,
                'ProductID' => $c->ProductID,
                'ProductName' => $prodName,
                'Quantity' => $c->Quantity,
                'Price' => $c->TotalPrice,
                'LabelsPerRoll' => $c->LabelsPerRoll,
                'is_custom' => $c->is_custom,
                'Print_Type'=>$print_type,
                'ProductTotal' => $totalP,
                'ManufactureID' => $manf_id,
                'colorcode'=>$c->colorcode,
                'Product_detail'=>$c->Product_detail,
                'labels'=>$totallabelsused);



            /******************Sample Order implementation***********************/
					
            if($c->OrderData=='Sample'){
                $data_ins = array_merge($data_ins, array('ProductionStatus'=>3));
            }
            if($sample=='mixed' && $c->OrderData=='Sample'){
                $data_ins = array_merge($data_ins, array('OrderNumber' => $OrderNumberSample));
						}
            else{
                $data_ins = array_merge($data_ins, array('OrderNumber' => $OrderNumber));
						}
            if($manf_id=='AADS001'){
                $data_ins = array_merge($data_ins, array('ProductionStatus'=>3,'ProductOption'=>$order_serail));
            }

            if($c->Printing=='Y'){



                $source ='';



                if($c->source=='flash'){



                    $source ='flash';

                }

                if($c->source=='LBA'){



                    $source ='LBA';

                }



                if($c->source=='printing' && !preg_match("/Roll Labels/i",$ProductBrand['ProductBrand'])){



                    $c->Print_Type = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $c->Print_Type);

                }

                $c->Print_Design = '1 Design';



                if($c->Print_Qty > 1){



                    $c->Print_Design = 'Multiple Designs';

                }



                $A4Printing = array( 
					'Printing'=>$c->Printing,
                    'Print_Type'=>$c->Print_Type,
                    'Print_Design'=>$c->Print_Design,
                    'Print_Qty'=>$c->Print_Qty,
                    'Free'=>$c->Free,
                    'Print_UnitPrice'=>$c->Print_UnitPrice,
                    'Print_Total'=>$c->Print_Total,
                    'user_project_id'=>$c->user_project_id,
                    'source'=>$source,
                    'Wound'=>$c->wound,
                    'Orientation'=>$c->orientation,
                    'pressproof'=>$c->pressproof,
                    'FinishType'=>$c->FinishType,
                    'design_service'=>$c->design_service,
                    'design_service_charge'=>$c->design_service_charge,
                    'design_file'=>$c->design_file,
                    'FinishTypePrintedLabels' => $c->FinishTypePrintedLabels,
                    'FinishTypePricePrintedLabels' => $c->FinishTypePricePrintedLabels,
                    'page_location'=>$c->page_location);
				
				if($c->regmark == "Y")
				{
					$A4Printing['regmark'] = "Y";
				}
				$data_ins = array_merge($data_ins, $A4Printing);
//----------------------------purchased plates history algo Starts -------------------------------
//                Algo overview
//                purpose is to determine user-purchased plates from user selected finish and embellishment options according
//                to shopping cart that is converting in order.
//                Some Rules
//               1:- if user choose embellishment plate from already purchased plates then it'll not update in customer's
//                purchased plate section
//               2:- if user choose embellishment option that requires plate/tool and its not present in his purchased plate
//                history then it'll update in it's current purchased plates history column alongwith existing plates.
//                3:- if user select plate from purchased history & also has new plate from embellishment option then existing plate will
//                be ignored & new plate will be added in already purchased list of plates
                //add finish plates in customer purchased history for fututre use these plates in order
                $emb_option_values = json_decode($c->FinishTypePrintedLabels);
                $use_old_plate = json_decode($c->use_old_plate);
                $user_purchased_plates = $this->home_model->get_db_column("customers", "purchased_plate_history", "UserID", $userid);
                if (empty($user_purchased_plates)) {
                    $user_purchased_plates = array();
                }
//               get all emb options that required plates to proceed (have plate cost from label_embellishment table for matching)
                $this->db->select('parsed_title');
                $this->db->where('plate_cost !=', 0);
                $embellishment_plate_parsed_title_all_db = $this->db->get('label_embellishment')->result_array();
                //convert 2d array into 1d array
                $embellishment_plate_parsed_title_all_db = array_column($embellishment_plate_parsed_title_all_db, 'parsed_title');
                if (isset($emb_option_values) && !empty($emb_option_values)) {
                    //determine those options that requires plate from user selected embellishment options and compare it to array of all available plates in system
                    $new_plates = array_intersect($embellishment_plate_parsed_title_all_db, $emb_option_values);
//                    if user selected some plate from already purchased history then remove this to prevent addition in user purchased plate history
                    if (isset($new_plates) && !empty($new_plates)) {

                        $attach_q = $this->db->query("select * from integrated_attachments 
									WHERE ProductID LIKE '" . $c->ProductID . "' AND CartID LIKE '" . $c->ID . "' AND status LIKE 'confirm' LIMIT 15 ");
                        $attach_q = $attach_q->result();
                        $order_attach_file = '';
                        $order_attach_name = '';
                        if (isset($use_old_plate) && !empty($use_old_plate)) {
                            $new_plates_merged = array_diff($new_plates, $use_old_plate);

                            if (isset($new_plates_merged) && !empty($new_plates_merged)){

                                foreach ($new_plates_merged as $purchased_plate) {
                                    $loop_count =1;
                                    if (count($attach_q) >0) {

                                        foreach ($attach_q as $key => $attach) {
                                            if ($loop_count == 1){

                                                $new_plate_obj = new stdClass();
                                                $new_plate_obj->order_number = $OrderNumber;
                                                $new_plate_obj->purchased_plate = $purchased_plate;
                                                $new_plate_obj->order_attach_file = $attach->file;
                                                $new_plate_obj->order_attach_name = $attach->name;
                                                $new_plates_final[] = $new_plate_obj;
                                                $order_attach_file = $attach->file;
                                                $order_attach_name = $attach->name;
                                                unset($attach_q[$key]);
                                                $loop_count++;
                                            }
                                        }
                                    }else{
                                        $new_plate_obj = new stdClass();
                                        $new_plate_obj->order_number = $OrderNumber;
                                        $new_plate_obj->purchased_plate = $purchased_plate;
                                        $new_plate_obj->order_attach_file = $order_attach_file;
                                        $new_plate_obj->order_attach_name = $order_attach_name;
                                        $new_plates_final[] = $new_plate_obj;

                                    }
                                }
                            }
                        } else {
                            $new_plates_merged = $new_plates;

                            foreach ($new_plates_merged as $purchased_plate) {
                                $loop_count =1;
                                if (count($attach_q) >0){
                                    foreach ($attach_q as $key=> $attach){
                                        if ($loop_count == 1){


                                            $new_plate_obj = new stdClass();
                                            $new_plate_obj->order_number = $OrderNumber;
                                            $new_plate_obj->purchased_plate = $purchased_plate;
                                            $new_plate_obj->order_attach_file = $attach->file;
                                            $new_plate_obj->order_attach_name = $attach->name;
                                            $new_plates_final[] = $new_plate_obj;
                                            $order_attach_file = $attach->file;
                                            $order_attach_name = $attach->name;
                                            unset($attach_q[$key]);
                                            $loop_count++;
                                        }
                                    }
                                }else{


                                    $new_plate_obj = new stdClass();
                                    $new_plate_obj->order_number = $OrderNumber;
                                    $new_plate_obj->purchased_plate = $purchased_plate;
                                    $new_plate_obj->order_attach_file = $order_attach_file;
                                    $new_plate_obj->order_attach_name = $order_attach_name;
                                    $new_plates_final[] = $new_plate_obj;
                                }

                            }
//                            foreach ($new_plates_merged as $purchased_plate) {
//                                $new_plate_obj = new stdClass();
//                                $new_plate_obj->order_number = $OrderNumber;
//                                $new_plate_obj->purchased_plate = $purchased_plate;
//                                $new_plates_final[] = $new_plate_obj;
//                            }
                        }

                        // if user has already 'purchased plates history' then update it & add new plates in it.
//                 $plates_add_to_user_existing_plates = array_diff($new_plates_final, json_decode($user_purchased_plates));
                        if (!empty(json_decode($user_purchased_plates))) {
                            if (isset($new_plates_final) && !empty($new_plates_final)) {

                                $user_purchased_plates_merged = array_merge(json_decode($user_purchased_plates), $new_plates_final);
                            }else{
                                $user_purchased_plates_merged = json_decode($user_purchased_plates);
                            }

                        } else {
//                        if user does'nt have any plate then add plates in his purchased plate history
                            $user_purchased_plates_merged = $new_plates_final;

                        }

                        $update_data = array();
                        $update_data['purchased_plate_history'] = json_encode($user_purchased_plates_merged);
                        $this->db->update('customers', $update_data, array('UserID' => $userid));
                    }
//                    print_r($new_plates);echo"gfdfgdfgfd";die;
                }
                //----------------------------purchased plates history Algo ends -------------------------------


//                echo"<pre>";print_r(json_decode($user_purchased_plates));
//                 print_r( ($emb_option_values));
//                 var_dump( ($user_purchased_plates_merged));
//                 print_r( ($use_old_plate));
//                echo $userid;echo"<br>";
//                echo $order_num;die;

            }


            /******************Sample Order implementation***********************/

            $this->db->insert('orderdetails', $data_ins);
			$order_serail = $this->db->insert_id();
			$this->home_model->save_logs('save_orderdetails',$data_ins);  //SAVE LOG
            
            if(preg_match('/Integrated Labels/is',$ProductBrand['ProductBrand']) || $c->Printing=='Y'){
                if($c->OrderData=='Black' || $c->OrderData=='Printed' || $c->Printing=='Y'){

                    $query = $this->db->query("select count(*) as total from integrated_attachments WHERE ProductID LIKE '".$c->ProductID."' AND CartID LIKE '".$c->ID."' AND status LIKE 'confirm' ");
                    $query = $query->row_array();
                    if($query['total'] > 0 || $c->regmark == "Y"){
                        $attach_q = $this->db->query("select * from integrated_attachments WHERE ProductID LIKE '".$c->ProductID."' AND CartID LIKE '".$c->ID."' AND status LIKE 'confirm' LIMIT 15 ");
                        $attach_q = $attach_q->result();

                        if(preg_match("/SRA3/i",$ProductBrand['ProductBrand'])){
                            $brand = 'SRA3';
                        }
                        else if(preg_match("/A3/i",$ProductBrand['ProductBrand'])){
                            $brand = 'A3';
                        }
                        else if(preg_match("/Roll/i",$ProductBrand['ProductBrand'])){
                            $brand = 'Rolls';
                        }
                        else if(preg_match("/Integrated/i",$ProductBrand['ProductBrand'])){
                            $brand = 'Integrated';
                        }

                        else if(preg_match("/A5/i",$ProductBrand['ProductBrand'])){
                            $brand = 'A5';
                        }
                        else{
                            $brand = 'A4';
                        }

                        $fakearray = array();
                        if(!$attach_q and $c->regmark == "Y")

                        {

                            $PDF = $this->db->query("Select PDF from products p INNER JOIN category c on  SUBSTRING_INDEX(p.CategoryID, 'R', 1) = c.CategoryID where SUBSTRING_INDEX(p.CategoryID, 'R', 1) = c.CategoryID and p.ProductID = '".$c->ProductID."' LIMIT 1")->row()->PDF;



                            $ex = explode(".",$PDF);



                            $filename = $ex[0]."_rev.".$ex[1];



                            $fakearray['OrderNumber'] = $OrderNumber;



                            $fakearray['Serial'] = $order_serail;



                            $fakearray['ProductID'] = $c->ProductID;



                            $fakearray['file'] = $filename;



                            $fakearray['print_file'] = $filename;



                            $fakearray['UserID'] = $userid;



                            $fakearray['name'] = $manf_id;



                            $fakearray['diecode'] = $manf_id;



                            $fakearray['qty'] = $c->Quantity;



                            $fakearray['labels'] = $c->orignalQty;



                            $fakearray['status'] = 70;



                            $fakearray['source'] = 'Backoffice';



                            $fakearray['version'] = 1;



                            $fakearray['approved'] = 1;



                            $fakearray['checklist'] = 1;



                            $fakearray['CO'] = 1;



                            $fakearray['SP'] = 1;



                            $fakearray['CA'] = 1;



                            $fakearray['PF'] = 1;



                            $fakearray['action'] = 0;



                            $fakearray['design_type'] = $c->Print_Type;



                            $fakearray['Brand'] = $brand;



                            $this->db->insert('order_attachments_integrated',$fakearray);
                        }



                        foreach($attach_q  as $int_row){

                            //new code
                            $checked = ($int_row->source=='flash')?'1':'0';
                            $des_source = ($int_row->source=='flash')?'flash':'web';
                            $job_status = ($int_row->source=='flash')?70:64;
                            $approve_date_field = ($int_row->source=='flash')?time():0;
                            $attach_array = array('OrderNumber'=>$OrderNumber,
                                'UserID'=>$userid,
                                'Serial'=>$order_serail,
                                'ProductID'=>$int_row->ProductID,
                                'file'=>$int_row->file,
                                'Thumb'=>$int_row->Thumb,
                                'source'=>$des_source,
                                'diecode'=>$manf_id,
                                'status'=>$job_status,
                                'design_type' =>$c->Print_Type,
                                'qty'=>$int_row->qty,
                                'labels'=>$int_row->labels,
                                'name'=>$int_row->name,
                                'version'=>1,
                                'CO'=>1,
                                'Brand'=>$brand,
                                'approve_date'=>$approve_date_field,
                                'checked'=>$checked);
													$this->db->insert('order_attachments_integrated',$attach_array);
                        }
                    }
                }
            }

            //new code

            if($c->Printing!='Y' && $c->source=='flash'){
							$attach_plain = $this->db->query("select * from integrated_attachments	WHERE ProductID LIKE '".$c->ProductID."' AND CartID LIKE '".$c->ID."' AND status LIKE 'plain'");
							$attach_plain = $attach_plain->row_array();
							$array_plain = array('OrderNumber'=>$OrderNumber,
																	 'Serial'=>$order_serail,
																	 'ProductID'=>$attach_plain['ProductID'],
																	 'file'=>$attach_plain['file'],
																	 'Thumb'=>$attach_plain['Thumb'],
																	 'source'=>'plain');
							$this->db->insert('order_attachments_integrated',$array_plain);
						}
				}
		
         $Order['OrderNumber'] = $OrderNumber;
        $this->session->set_userdata($Order);

        /*if($sample=='sample') {
            //echo 'in';
            $OrderNumberSamples = $OrderNumber;
            $this->custom->assign_dispatch_date($OrderNumberSamples, TRUE);
        }*/


        /***-------- code start for voucher implementations------****/

        if($last_order=="FIRST" &&  $sample!='sample'){
            $first_order_offer = $this->db->query("Select  count(UserID) as count from tbl_first_order_offer WHERE Email LIKE '".$b_email."'");
            $first_order_offer = $first_order_offer->row_array();
            if(isset($first_order_offer['count']) and $first_order_offer['count']==0){
                $first_time_array = array('UserID'=>$this->session->userdata('userid'),'Email'=>$b_email,'Date'=>time(),'firstorder'=>$OrderNumber,'Name'=>$b_first_name);
                $this->db->insert('tbl_first_order_offer',$first_time_array);
						}
				}



        if($paymentway=='purchaseOrder'){

            $imagename = '';
            if(isset($_FILES['file_up']) and $_FILES['file_up']!=''){
                $config['upload_path'] = PATH;
                $config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif';
                $config['max_size']	= '10000';
                $this->load->library('upload', $config);
                $field_name = "file_up";
							if ( $this->upload->do_upload($field_name)){
								$data = array('upload_data' => $this->upload->data());
								$imagename=$data['upload_data']['file_name'];
								$this->db->update('orders', array('po_attachment'=>$imagename), array('OrderNumber'=>$OrderNumber));
							}
						}
					
            $parameters = array('OrderNumber'=>$OrderNumber,
                'name'=>$b_first_name,
                'email'=>$b_email,
                'telephone'=>$b_phone_no,
                'mobile'=>$b_mobile,
                'attachemt'=>$imagename);
					$this->send_purcasheorder_attachemts($parameters);
        }
         //$this->session->set_userdata("changeDrop","0");
//		$this->session->unset_userdata("userid");
//		$this->session->unset_userdata('payment_redirection');
//        $this->emptcart();
	}



	function menufacture($id){



		$query=$this->db->query("select  ManufactureID from products  where ProductID='".$id."'");



		$res=$query->result();



		return $res;

	}

	function product_reordercode($pid){

		$qry = $this->db->query("SELECT ReOrderCode FROM `products` WHERE `ProductID` = '$pid'");

		return $qry->result_array();

	}

	function GetProductBrand($id){

		$query=$this->db->query("select  ProductBrand,LabelsPerSheet from products  where ProductID='".$id."'");

		$res=$query->row_array();

		return $res;

	}

	function emptycartafterConfirm(){

    	$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
		
		$del = $this->db->query("Delete from temporaryshoppingbasket WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )");
		
		$del = $this->db->query("Delete from integrated_attachments WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )");
		
		
	}

	/*----------Order confirm email-----------------*/

	function order_confirmation_email(){

		

		$userid = $this->session->userdata('userid');

		$OrderNumber = $this->session->userdata('OrderNumber'); 

		$query = $this->db->get_where('orders', array('OrderNumber' => $OrderNumber));

		$res = $query->result_array();

		$res = $res[0];

	



		$FirstName 		= 	$res['BillingFirstName'];

		$EmailAddress 	=	$res['Billingemail'];	

		$date  			= 	$res['OrderDate'];

		$time			=	$res['OrderTime'];	

		$OrderDate 		= 	date("d/m/Y",$date);

		$OrderTime 		= 	date("H:i",$time);

		$PaymentMethod1 =	$res['PaymentMethods'];

        $PONUMBER ='';

        if($res['PurchaseOrderNumber']){

          $PONUMBER = "<strong>Your PO No : </strong>".$res['PurchaseOrderNumber'];

        }   

		

		if($PaymentMethod1 == 'chequePostel'){

			$PaymentMethod = "Pending payment" ;

			$pamentOrder='Via Cheque ';

		}

		

		if($PaymentMethod1 == 'creditCard'){

			$pamentOrder='Via Credit card';

			$PaymentMethod = "Pending processing" ;

		}

		

		if($PaymentMethod1 == 'purchaseOrder'){

			$pamentOrder='Via Purchase order';

			$PaymentMethod = "Pending payment" ;

		}

		

		if($PaymentMethod1 == 'paypal'){

			$pamentOrder='Via PayPal';

			$PaymentMethod = "Completed";

		}

                if($PaymentMethod1=='Sample Order')

		{

			$pamentOrder='Sample Order';

			$PaymentMethod = "Sample Order";

		}          

		

			$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is being processed for production. Upon completion of your order you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";

		         

		

		if ($PaymentMethod1=='purchaseOrder')

		{

			$purchase_order_txt = '';

			if($res['PurchaseOrderNumber']){

         		 $purchase_order_txt = "(PO No. ".$res['PurchaseOrderNumber'].")";

        	}  

			$paymentMethod='Via Purchase Orders';

			$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending approval of your purchase order ".$purchase_order_txt.". Upon acceptance of payment by PO your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";

		}

		elseif ($PaymentMethod1=='chequePostel')

		{

			$paymentMethod='Via Bank Transfer';

			$customer_message = "<p>Thank you for purchasing from AA Labels and we confirm that your order has been received and is pending payment by bank transfer. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.<br /><br /><b style='color:#006da4'>Payment Details</b><br />BACS TRANSFER<br />";

			$customer_message .= '<table style="font-size:12px; padding-bottom:10px;" width="100%" border="0" cellspacing="0" cellpadding="0"><tr>	

    		<td width="15%;">Account Name:</td><td width="70%;">Green Technologies Limited T/A AA Labels</td></tr><tr><td width="15%;">Sort Code:</td><td width="70%;">40-36-15</td></tr><tr><td width="15%;">A/C No:</td><td width="70%;">52385724</td></tr><tr><td width="15%;">IBAN:</td><td width="70%;">GB87MIDL40361552385724</td></tr><tr><td width="15%;">SWIFT/BIC:</td><td width="70%;">HBUKGB4108R</td></tr></table>';

			

		}

		elseif ($PaymentMethod1=='creditCard')

		{

			$paymentMethod='Via Credit Card';

		}

		elseif($PaymentMethod1=='paypal')

		{

			$paymentMethod='Via Pay pal';

		}

		elseif($PaymentMethod1=='PayPal eCheque')

		{

			$paymentMethod='Via PayPal eCheque';

			

			$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending confirmation of your e-cheque payment from PayPal. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";

		}

		elseif($PaymentMethod1=='Sample Order')

		{

			$paymentMethod='Sample Order';

		}

		

			$websiteOrders="Backoffice";

			

			

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

			//$EmailAddress 		=	$res3['Billingemail'];		

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

		

		

		

		$vatRate 				= "20.00";

		$DeliveryOption 		=	$this->session->userdata('ServiceName');

		

		$res['OrderShippingAmount'] =  $this->home_model->currecy_converter($res['OrderShippingAmount'],'no');

		$deliveryChargesExVat 	=	number_format($res['OrderShippingAmount']/(($vatRate+100)/100),2,'.','');

			

		



		if($deliveryChargesExVat){

			  $DeliveryExVatCost 		=	$deliveryChargesExVat;	

		}else{

			  $DeliveryExVatCost 		=	'0.00';

		}

		

		if($res['OrderShippingAmount']){

			

			$DeliveryIncVatCost 	=	number_format($res['OrderShippingAmount'],2,'.','');	

		}

		else

		{

			$DeliveryIncVatCost ='0.00';

		}	

		$OrderTotalExVAT 		=	number_format($res['OrderTotal']/1.2,2);	

		$OrderTotalIncVAT 		= 	number_format($res['OrderTotal'],2);

		$CompanyName 			= 	"AALABELS";

		

		//$orderecords = $this->db->get_where('orderdetails', array('OrderNumber' => $OrderNumber));

		//$num_row = $orderecords->num_rows();

		//$info_order = $orderecords->result_array();

		

		$info_order =  $this->order_detail($OrderNumber);

			

			

		$TotalQuantity = "";

		$SubTotalExVat1 = "";

		$SubTotalIncVat1 = "";

		$rows = "";

		$i = 0;$bgcolor='';				

		foreach($info_order as $rec)

		{

                        

             

			 if($rec['Printing']=='Y'){

			  	$rec['Price'] = $rec['Price']+$rec['Print_Total'];

				$rec['ProductTotal'] = $rec['ProductTotal']+($rec['Print_Total']*1.2);

				$A4Printing = $this->home_model->get_printing_service_name($rec['Print_Type']);

				$rec['ProductName'] = $rec['ProductName'].' - '.$A4Printing;

			}

			

			 

			$rec['Price'] =  $this->home_model->currecy_converter($rec['Price'],'no');

			$rec['ProductTotal'] =  $this->home_model->currecy_converter($rec['ProductTotal'],'no');

			           

        	$ProductName = 	$rec['ProductName'];

 			$PriceExVat1	 = $rec['Price'];

			$PriceExVat = $PriceExVat1;

			$UnitPrice	 =	number_format(round(($rec['Price']/$rec['Quantity']), 4),4,'.','');	

			$PriceIncVat = number_format(($rec['ProductTotal']),2,'.','');		

			

			$Quantity	 =  $rec['Quantity'];

			$TotalQuantity	+=  $Quantity;

			

			$ProductCode =	$rec['ProductID'];

			$ManufacturerId  = $this->menufacture($ProductCode);

			$ManufacturerId = $ManufacturerId[0]->ManufactureID; 

			

			if($bgcolor==''){

				$bgcolor = '#F5F5F5';

			}else{

				$bgcolor = '';

			}

			

			

			

			

			if($rec['is_custom']=='Yes'){

					$labelspersheet = $rec['LabelsPerRoll'];

			}else{

					$ProductBrand = $this->GetProductBrand($rec['ProductID']);

					$labelspersheet = $ProductBrand['LabelsPerSheet'];

			}

			

			

			$totallabelsused = $Quantity*$labelspersheet;

			

			if($rec['Printing']=="Y"){ 

					$attached_files = $this->db->query(" SELECT SUM(labels) AS total from order_attachments_integrated 

					WHERE Serial LIKE '".$rec['SerialNumber']."'  ");

					$attached_files = $attached_files->row_array();	

					if(isset($attached_files['total']) and $attached_files['total'] > 0 and $attached_files['total']!=''){

						 $totallabelsused = $attached_files['total'];

					}

			}

			

		    if( $PaymentMethod == "Sample Order" ){

				$totallabelsused = " - ";

		    }	

			

			/*

			$rows .='<tr bgcolor="'.$bgcolor.'" height="25">

						<td valign="top">'.$ManufacturerId.'</td>

						<td valign="top">'.$ProductName.'</td>

						<td align="center" valign="top">'.$totallabelsused.'</td>

						<td align="center" valign="top">'.symbol.number_format($UnitPrice,4).'</td>

						<td align="center" valign="top">'.$Quantity.'</td>

						<td valign="top">'.symbol.$PriceExVat.'</td>

				     </tr>';

				     

			*/	     

			 $rows .='<tr>

					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ManufacturerId.'</td>

					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ProductName.'</td>

					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$Quantity.'</td>

					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.symbol.number_format($UnitPrice,4).'</td>

					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:1; border-top:0;">'.symbol.$PriceExVat.'</td>

				   </tr>';

					 

					 

			/*$rows .='<tr bgcolor="'.$bgcolor.'" height="25">

						<td valign="top">

							'.$ManufacturerId.'

						</td>

						<td valign="top">



							'.$ProductName.'

						</td>

						<td valign="top">

							'.symbol.number_format($UnitPrice,4).'

						</td>

						<td valign="top">

							

							'.$Quantity.'

						</td>

						<td valign="top">

							'.symbol.$PriceExVat.'

						</td></tr>';*/

			

			

			 $SubTotalExVat1 += $PriceExVat;

			 $SubTotalIncVat1 +=$PriceIncVat;

			

		$i++;

		}

		

		$SubTotalExVat	=	number_format($SubTotalExVat1,2,'.','');	

		$SubTotalIncVat	=	number_format($SubTotalIncVat1,2,'.','');	

		$OrderTotalExVAT1	=	$DeliveryExVatCost+$SubTotalExVat;

		

		$OrderTotalExVAT	 =	number_format($OrderTotalExVAT1,2,'.','');	

		$OrderTotalIncVAT	=	number_format(($DeliveryIncVatCost+$SubTotalIncVat1),2,'.','');	

		

			$exvatSubtotalExVat=symbol.$SubTotalExVat;

			$exvatSubtotalIncVat=symbol.$SubTotalIncVat;

			

			$deliveryExVat=symbol.$DeliveryExVatCost;

			$deliveryIncVat=symbol.$DeliveryIncVatCost;

			

			$gtotalExVat=symbol.$OrderTotalExVAT;

			$gtotalIncVat=symbol.$OrderTotalIncVAT;

			$vatTotal=number_format($OrderTotalIncVAT-$OrderTotalExVAT,2,'.','');	

			

			$bill_rc=$res['BillingCompanyName'];

			$del_rc=$res['DeliveryCompanyName'];

			$email = $res['Billingemail'];

	

	

		$sql = $this->db->get_where(Template_Table, array('MailID' =>'3'));

		$result = $sql->result_array();

		$result = $result[0];

		$mailTitle = $result['MailTitle'];

		$mailName = $result['Name'];

		$from_mail = $result['MailFrom'];

		$mailSubject = $result['MailSubject'] .' : '.$OrderNumber;



		$mailText = $result['MailBody'];

		

		$getfile = FCPATH.'system/libraries/en/order-confirmation.html';

	   	$mailText = file_get_contents($getfile);

	   	

	   	

		

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

	  "[styleDeliveryConpnay]","[vatprice]","[pamentOrder]","[weborder]","[BillingResCom]","[DeliveryResCom]","[voucherDiscount]","[PONUMBER]","[customer_message]");

  

  		$webroot = base_url(). "theme/";

        //----------------------------------------------------------------------------------------------

                $qry1 = "select `UserID` from `orderdetails` where `OrderNumber` = '".$OrderNumber."'";

                $exe1 = mysql_query($qry1);

                $res1 = mysql_fetch_array($exe1);

                $qry2 = "select * from `customers` where `UserID` = '".$res1['UserID']."'";

                $exe2 = mysql_query($qry2);

                $res2 = mysql_fetch_array($exe2);

	  //-----------------------------------------------------------------------------------------------                



           $vatTotal=number_format($OrderTotalIncVAT-$OrderTotalExVAT,2,'.','');	

           /*--------------------------Voucher Code--------------------*/

			if($res['voucherOfferd']=='Yes'){

		  	    $voucherDiscount =  $this->home_model->currecy_converter($res['voucherDiscount'],'no');

				$voucher_code = '<tr><td align="right">Discount:</td><td style="color: #006da4; padding-left:10px;" align="right">'.symbol.$voucherDiscount.'</td></tr>';

			}

			else{

				 $voucherDiscount = 0.00;

				 $voucher_code ='';

			}

		$gtotalIncVat = number_format($OrderTotalIncVAT - $voucherDiscount,2,'.','');

		$gtotalIncVat = symbol.$gtotalIncVat;

		

		 /*--------------------------Voucher Code--------------------*/





	  $strInDB  = array($webroot,$BillingFirstName, $OrderNumber, $OrderDate, $OrderTime, $PaymentMethod, $BillingTitle,

	  $BillingFirstName, $BillingLastName, 

	  $BillingCompanyName, $BillingAddress1, $BillingAddress2, $BillingTownCity, $BillingCountyState, 

	  $BillingPostcode, $BillingCountry, $Billingtelephone, $BillingMobile1, $Billingfax, $EmailAddress, 

	  $DeliveryTitle, $DeliveryFirstName, $DeliveryLastName,$res2['DeliveryCompanyName'], $DeliveryAddress1, 

	  $DeliveryAddress2, $DeliveryTownCity, $DeliveryCountyState, $DeliveryPostcode, $DeliveryCountry, 

	  $ManufacturerId, $ProductName, $Quantity, $PriceExVat, $PriceIncVat, $SubTotalExVat, $SubTotalIncVat, 

	  '', $DeliveryOption, symbol.$DeliveryExVatCost,$DeliveryIncVatCost, $OrderTotalExVAT, 

	  $OrderTotalIncVAT, $rows,symbol, '',$exvatSubtotalIncVat,$exvatSubtotalExVat,$deliveryExVat,$deliveryIncVat,

	  $DeliveryOption,$gtotalExVat,$gtotalIncVat,$PaymentMethod,$styleBillingCompnay,$styleDeliveryCompany,symbol.$vatTotal,

	  $pamentOrder,$websiteOrders,$bill_rc,$del_rc,$voucher_code,$PONUMBER,$customer_message);

	  

	  $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);

	  			$this->load->library('email');

				$email=$this->user_email();		

				$this->email->from($from_mail, 'AALABELS');

				$this->email->to($email); 

				$this->email->bcc('php.aalabels@gmail.com'); 

				$this->email->subject($mailSubject);

				$this->email->message($newPhrase);

				$this->email->set_mailtype("html");

		

		

		if($PaymentMethod1 == "chequePostel"){

			$this->load->model('accountModel');

			$data['OrderDetails'] = $this->accountModel->OrderDetails($OrderNumber);

			$OrderInfo = $this->accountModel->OrderInfo($OrderNumber); 

			$OrderInfo = (array)$OrderInfo[0];

		

			$site = $OrderInfo['site'];

			$language = ($site=="" || $site=="en")?"en":"fr"; 

			$page = ($language=="en")?"user/orderconfirm.php":"user/orderconfirm.php";

			

			$data['OrderInfo'] = $OrderInfo;

			$data['invoice'] = $this->home_model->get_db_column('invoice','InvoiceNumber','OrderNumber',$orderID);

			

			$this->load->library('pdf');

			$this->pdf->load_view($page, $data);

			$this->pdf->render();

			$output	= $this->pdf->output();

			$file_location = "pdfs/Order-No-".$OrderNumber.".pdf";

	

			$filename = $file_location;

			$fp = fopen($filename, "a");

			file_put_contents($file_location,$output);

			

			$file = FCPATH.$filename;

		}

		

		if($PaymentMethod1 == "chequePostel"){

			if(file_exists($file)) {

				$this->email->attach($file);

			}

		}

		

		

		

				$this->email->send();

				

				if(($res['vat_exempt']=='no') and ($res['OrderStatus']==2 || $res['OrderStatus']==32)){

						 //$this->email->send();

				}

				if($res['OrderStatus']==2 || $res['OrderStatus']==32){

					 $res['OrderStatus'] = $this->check_printable_order($OrderNumber, $res['OrderStatus']);

				}

		        

		        if($res['OrderStatus']==2 || $res['OrderStatus']==32){

				  $this->load->library('Custom');

				  $this->custom->assign_dispatch_date($OrderNumber);

				}

		

	 		

			$parameters = array('OrderNumber'=>$OrderNumber,

								'name'=>$BillingFirstName,

								'email'=>$email,

								'telephone'=>$Billingtelephone,

								'mobile'=>$BillingMobile1,

								'OrderStatus'=>$res['OrderStatus'],

								);

	 		$this->send_printing_attachemts($parameters);

			

			$dele['ServiceID'] = "";

			$dele['ServiceName'] = "";

			$dele['BasicCharges'] = "";

			//$dele['OrderNumber'] = "";

			$dele['valid_voucher'] = "";

			$dele['voucherCode'] = ""; 

			$dele['off_postcode'] = ""; 

		    $dele['countryid'] = ""; 

			$dele['vat_exemption'] = ""; 

						

			$this->session->unset_userdata($dele);

			$this->emptycartafterConfirm();

			

			if($PaymentMethod1 == "chequePostel"){

    			if(file_exists($file)) {

    				@unlink($file);

    			}

		    }

		

	}

	

	function check_printable_order($ordernumber, $OrderStatus=NULL){

		 

		$query = $this->db->query(" select count(*) as total from orderdetails where OrderNumber LIKE '".$ordernumber."' AND Printing LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels' ");	

				$row = $query->row_array();

				if($row['total'] > 0){

					$this->db->update('orders', array('OrderStatus'=>55), array('OrderNumber'=>$ordernumber));

					$status_log = array('OrderNumber'=>$ordernumber,

							'OrderStatus_new'=>55,

							'OrderStatus_old'=>$OrderStatus,

							'Oprator'=>'AALabels Server',

							'Date'=>time());

		            $this->db->insert('status_change_log',$status_log);

		            $OrderStatus =  55;

				}

				return $OrderStatus;

	}

	

	function get_status_id($status_text){

		

		switch($status_text){	
		case 'ABORT':
			  $content = 35;
			  break;

		case 'OK':
			  $content = 32;
			  break;

		case 'MALFORMED':
			  $content = 20;
			  break;

		case 'INVALID':
			  $content = 21;
			  break;

	    case 'NOTAUTHED':
			  $content = 22;
			  break;

		case 'REJECTED':

			  $content = 23;

			  break;

		case 'REGISTERED':

			  $content = 24;

			  break;

		case 'ERROR':

			  $content = 25;

			  break;

		case 'Pending':

			  $content = 6;

			  break;

		case 'Completed':

			  $content = 2;

			  break;

		case 'FAILED':

			  $content = 26;

			  break;

		case 'Refunded': /*Case is not covered yet, but for future use only--Nov 03_2011*/

			  $content = 131;

			  break;

		case 'Reversed': /*Case is not covered yet, but for future use only--Nov 03_2011*/

			  $content = 132;

			  break;

	    case 'Processed': /*Case is not covered yet, but for future use only--Nov 03_2011*/

			  $content = 133;

			  break;

	    case  'Voided' :/*Case is not covered yet, but for future use only--Nov 03_2011*/

	    	  $content=134;

	    	  break;

	    case  'Expired' :/*Case is not covered yet, but for future use only--Nov 03_2011*/

	    	  $content=135;

	    	  break;

	    case  'Denied' :/*Case is not covered yet, but for future use only--Nov 03_2011*/

	    	  $content=136;

	    	  break;

	    case  'Canceled_Reversal' :/*Case is not covered yet, but for future use only--Nov 03_2011*/

	    	  $content=137;

	    	  break;

	    default:

	    	  $content=138;

	    	  break;	  

	}

	return $content;

}

	

	/**************** first order oucher code ***************/

	function check_discount_applied($newGrandTotal, $perentage=NULL){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		$userid = $this->session->userdata('userid');

		$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		$res   = $qry->row_array();

		if($res){

			if($res['grandtotal']!=$newGrandTotal){
               $this->update_discount_applied($newGrandTotal, $perentage);
           	}

			$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		    $res   = $qry->row_array();

		}

			

		return $res;  

	}

	function update_discount_applied($GrandTotal, $perentage=NULL){

	

				if(isset($perentage) and $perentage!=NULL){ 

					$discout_perct =  number_format($perentage/100,2);

				}else{

					$discout_perct =  number_format(10/100,2);

				}

			

				$DsountOff = $GrandTotal * $discout_perct;

				$session_id = $this->session->userdata('session_id');

				

				$data = array(

						   'discount_offer' => $DsountOff,

						   'grandtotal' => $GrandTotal,

						);

			

			$update = $this->db->update('voucherofferd_temp', $data, array('SessionID' => $this->sessionid()));

	}

	

	function order_discount_applied()

	{

		$userid = $this->session->userdata('userid');

		$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$this->sessionid()."' AND UserID = ".$userid." ");

		$res   = $qry->row_array();

		return $res;  

	}

	function expire_used_voucher($orderNumber=NULL){

		

		$valid_voucher = $this->session->userdata('valid_voucher'); 

		if($valid_voucher=='yes' and $orderNumber!=NULL){

			

			$query = $this->db->query("SELECT voucherOfferd FROM `orders` WHERE  OrderNumber LIKE '".$orderNumber."' ");

			$row = $query->row_array();

			if($row['voucherOfferd']=='Yes'){

				$userid = $this->session->userdata('userid');

				$data = array('Used' => '1', 'OrderNumber' => $orderNumber ,'ApplyDate' => time());

				$this->db->where('UserID',$userid);

				$this->db->update('tbl_first_order_offer',$data);

			}

		

			$array_items = array('valid_voucher' => '', 'voucherCode' => '');

			$this->session->unset_userdata($array_items);

			

			

		}

	}

	

	

	

/*----------------------------------WTP OFFERS---------------------------------------*/	

   

   function wtp_discount_applied_on_order(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');
		
		
		$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		$res   = $qry->row_array();

		return $res;  

	}

   function check_wtp_voucher_applied($newGrandTotal){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');
		

		$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		$res   = $qry->row_array();

		if($res){

			if($res['grandtotal']!=$newGrandTotal){

				

						$amount = $this->calculate_total_wtp_amount();	

						$this->update_wtp_discount_voucher($amount);

							 

			}

			 //$update = $this->db->delete('voucherofferd_temp',array('SessionID' => $this->sessionid(),'UserID'=>''));

		    // $res   = $qry->row_array();

			$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		    $res   = $qry->row_array();

		}

			

		return $res;  

	}

	

	

	function update_wtp_discount_voucher($GrandTotal){



				$discout_perct =  number_format(15/100,2);

				$DsountOff = $GrandTotal * $discout_perct;

				$session_id = $this->session->userdata('session_id');

				$data = array(

						   'discount_offer' => $DsountOff,

						   'grandtotal' => $GrandTotal,

						);

			$update = $this->db->update('voucherofferd_temp', $data, array('SessionID' => $this->sessionid()));

	}

	

	function check_wtp_offer_voucher(){

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');

		$query = $this->db->query(" SELECT count(temporaryshoppingbasket.ProductID) AS total from products INNER JOIN temporaryshoppingbasket ON 

		      						products.ProductID=temporaryshoppingbasket.ProductID WHERE ManufactureID LIKE '%WTP' AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND 

			   						temporaryshoppingbasket.Quantity >= 10000 AND  (ProductBrand LIKE 'A4 Labels') AND Printing NOT LIKE 'Y' ");

		$row = $query->row_array();	

		

		

		if(isset($row['total']) and $row['total'] > 0){

				return true;

		}else{

                        $update = $this->db->delete('voucherofferd_temp',array('SessionID' => $this->sessionid(),'UserID'=>0,'vc_type'=>'wtp'));

                       //$update = $this->db->delete('voucherofferd_temp',array('SessionID' => $this->sessionid()));

				return false;

		}

	}

	

	function calculate_total_wtp_amount(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		$query = $this->db->query(" SELECT SUM(TotalPrice) AS total from products INNER JOIN temporaryshoppingbasket ON 

									products.ProductID=temporaryshoppingbasket.ProductID WHERE ManufactureID LIKE '%WTP' AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND 

									temporaryshoppingbasket.Quantity >= 10000 AND  (ProductBrand LIKE 'A4 Labels')");

		$row = $query->row_array();	

		if(isset($row['total']) and $row['total']!=''){

			return $row['total']*1.2;

		}else{

			return 0.00;	

		}

  }

    function is_xmass_labels(){

		$session_id = $this->session->userdata('session_id');

		$query = $this->db->query(" SELECT COUNT(*) AS total from products INNER JOIN temporaryshoppingbasket ON 

									products.ProductID=temporaryshoppingbasket.ProductID WHERE ManufactureID LIKE '%-XS' AND SessionID = '".$session_id."' 

									AND (ProductBrand LIKE 'A4 Labels')");

		$row = $query->row_array();	

		return $row['total'];

  }







/************************* Black Friday Offer **********************************/

  function calculate_plain_order_total(){

			$total = 0.00;

			$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
			$cookie = stripslashes($cookie);
			$cookie = @unserialize($cookie);
			$cisess_session_id = $cookie['session_id'];
			$session_id = $this->session->userdata('session_id');

			$query = $this->db->query(" SELECT SUM(TotalPrice) AS total from products INNER JOIN temporaryshoppingbasket ON 

					products.ProductID=temporaryshoppingbasket.ProductID WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND 

					temporaryshoppingbasket.Printing NOT LIKE 'Y' AND  (ProductBrand LIKE 'Roll Labels' || ProductBrand LIKE 'A4 Labels')");

			$row = $query->row_array();

			

			$total = $row['total']*1.2;

			if($total > 0){ return $total;}else{return 0;}

  }

  function check_black_friday_offer($GrandTotal){

  	

		//$current = date("Y-m-d",time()+(3600*24*30));

		$current    =   date('Y-m-d');

		$current    =   date('Y-m-d', strtotime($current));;

		$DateBegin  =   date('Y-m-d', strtotime("11/24/2017"));

		$DateEnd    =   date('Y-m-d', strtotime("11/26/2017"));

	    $response   =   array('status'=>false);

	    return $response; 

	    

	    $userid = $this->session->userdata('userid');

	    	

		if(($current >= $DateBegin) && ($current <= $DateEnd)){

			  

			  $GrandTotal =  $this->calculate_plain_order_total();

			  $wpep =  $this->is_wpep_disocunt_applied(); 		

			  if($wpep > 0){

			  	 return $response;

			  }

                          $bf_user = 0;

			  $bf_count = $this->b_friday_count();

			  if(isset($userid) and $userid!=''){

			  		$bf_user = $this->b_friday_user_count($userid);

			  }

			  

			  if($bf_count < 100 and $bf_user < 2){

				  		$disount_applied = $this->apply_black_friday($GrandTotal);

				  		$response = array('status'=>true,'discount_offer'=>$disount_applied['discount_offer']);

			  }else{

			 	 		$update = $this->db->delete('voucherofferd_temp',array('SessionID' => $this->sessionid(),'vc_type'=>'BF'));	

			  }  	

				//$update = $this->db->update('voucherofferd_temp', $data, array('SessionID' => $this->sessionid()));

		}else{

				 $update = $this->db->delete('voucherofferd_temp',array('SessionID' => $this->sessionid(),'vc_type'=>'BF'));	

		}

		return $response;

  }

  function apply_black_friday($GrandTotal){

		 	

			$count = $this->wtp_discount_applied_on_order();

			if($count){

					$disount_applied = $this->check_discount_applied($GrandTotal, 25);

			}else{

				    $userid = $this->session->userdata('userid');

					$discout_perct =  number_format(25/100,2);

					$DisountOff = $GrandTotal * $discout_perct;

					$New_grand = number_format(round(($GrandTotal - $DisountOff),2),2);

					$date = time();

					$session_id = $this->session->userdata('session_id');

					$GrandTotal = number_format($GrandTotal,2);

					

					$feilds = array('vc_type'=>'BF',

									'SessionID'=>$session_id,

									'DateLogged'=>$date,

									'UserID'=>$userid,

									'discount_offer'=>$DisountOff,

									'grandtotal'=>$GrandTotal);

					$this->db->insert('voucherofferd_temp',$feilds);

					$disount_applied['discount_offer'] = number_format($DisountOff,2);

			}

			return $disount_applied;

  }

  function b_friday_count(){

  		$now = date("Y-m-d", time());

		$query = $this->db->query("select count(*) as total from black_friday WHERE DATE(`date`) = '".$now."'");

		$row = $query->row_array();

		return $row['total'];

  }

   function b_friday_user_count($userid){

    $query = $this->db->query("select count(*) as total from black_friday WHERE userid LIKE '".$userid."' AND DATE(`date`) > DATE('2017-11-24')");

    $row = $query->row_array();

    return $row['total'];

  }

  function is_wpep_disocunt_applied(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
     	$session_id = $this->session->userdata('session_id');

		$query = $this->db->query(" SELECT COUNT(*) AS total from products INNER JOIN temporaryshoppingbasket ON 

		products.ProductID=temporaryshoppingbasket.ProductID 

                WHERE (ManufactureID LIKE '%WPEP' OR ManufactureID LIKE '%-XS') AND 

                (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND (ProductBrand LIKE 'A4 Labels')");

		$row = $query->row_array();	

		return $row['total'];

		

  }

  /******************************************************************/

  

  

  function data_layer(){

  

  	  $class = $this->router->fetch_class();

	  $method = $this->router->fetch_method();

	  if($class=='shopping' and $method=='orderConfirmation'){

	  		

			$orderNum = $this->session->userdata('OrderNumber');

			$data = '';

			

			$order = $this->data_order_total($orderNum);

			$lines = $this->data_order_details($orderNum);

			

			$googleproductinfo = '';

			foreach($lines as $pro){

				$googleproductinfo .=  "{  'sku': '".$pro->ManufactureID."',

							   			   'name': '".$pro->ProductName."',

									       'price': ".$pro->ProductTotal.",

									       'quantity': '".$pro->Quantity."',  },";

									 

			}

			

			$tax = '';

			$tax = $order['OrderTotal']-($order['OrderTotal']/1.2);

			$data = "dataLayer = [{ 'transactionId': '".$orderNum."',

									'transactionAffiliation': 'aalabels',

									'transactionTotal': ".number_format($order['OrderTotal']-$tax,2).",

									'transactionTax': ".number_format($tax,2).",

									'transactionShipping': ".$order['OrderShippingAmount'].",

									'transactionProducts': [".$googleproductinfo."]

								}];";

			

		    $dele['OrderNumber'] = "";

			$this->session->unset_userdata($dele);

			

			return $data;

				 

	  }

  }

  

  function data_order_total($order){

  		$row = $this->db->query("select OrderTotal,OrderShippingAmount from orders WHERE OrderNumber LIKE '".$order."'");	

		return $row->row_array();  

		

		

  }

  function data_order_details($order){

  		$row = $this->db->query("select  ManufactureID,ProductName,ProductTotal,Quantity from orderdetails WHERE OrderNumber LIKE '".$order."'");	

		return $row->result(); 

  }





   /********** Top cash Back script ********/

     function calculate_topcashback($order_number){

		

		$query = $this->db->query("SELECT SUM(ProductTotal) as total FROM `orderdetails` Inner JOIN products ON 

		products.ProductID = orderdetails.ProductID WHERE ( ProductBrand LIKE 'A4 Labels' OR ProductBrand LIKE 'A3 Label' OR ProductBrand LIKE 'SRA3 Label' ) AND Printing NOT LIKE 'Y' AND OrderNumber LIKE '".$order_number."' ");

		$row = $query->row_array();

		if(isset($row['total']) and $row['total'] > 0 ){

				return ($row['total']/1.2);	

		}else{

				return 0;

		}

  }	

  

  /********** Top cash Back script ********/

  

  

  

  

  /******************Sample Order implementation***********************/

  

  function is_order_sample(){
    		 $sample = $this->sample_count_items();
    		 $other = $this->standard_count_items();
		if($sample > 0 and $other==0){
			return "sample";
    	}
		else if($sample > 0 and $other > 0){
			return "mixed";
		}
		else{
			return "other";
		}
    }

	function sample_count_items(){

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');
		

		$result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE OrderData LIKE 'Sample' 

		AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )  ");

		$row = $result->row_array();

		return $row['total'];

		

	}

	function standard_count_items(){

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		$result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE OrderData NOT LIKE 'Sample' 

		AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )  ");

		$row = $result->row_array();

		//echo $this->db->last_query(); echo '<br>';

		return $row['total'];

	}

       function printing_count_items(){

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		$result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE  Printing LIKE 'Y' 

		AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		$row = $result->row_array();

		return $row['total'];

	}

	

	function send_printing_attachemts($parameters){
      return true;
    }

	/******************Sample Order implementation***********************/

	function country_code($country){

			 $countrucode = array('Ireland'=>'IE',
								  'Belgium'=>'BE',
								  'Denmark'=>'DK',
								  'France'=>'FR',
								  'Holland'=>'NL',
								  'Germany'=>'DE',
								  'Sweden'=>'SE',
								  'Spain'=>'ES',
								  'Switzerland'=>'CH',
								  'Luxembourg'=>'LU',
								  'United Kingdom'=>'GB');

			//return 'GB';

			return $countrucode[$country];					  

	}

	

	function calculate_lba_in_cart(){

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		

		$total = $this->standard_count_items();

		$SID  =  $this->sessionid();

		$result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE  

		(Select ProductBrand From products WHERE temporaryshoppingbasket.ProductID = products.ProductID) LIKE 'Application Labels' 

		AND (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )  ");

		$row = $result->row_array();

		if($total == $row['total'])return "lba";

		else return "mixed";

			

 	}

	

	

	function send_purcasheorder_attachemts($parameters){
         return true;

	}

	

	/********************* 10% dicounts on Printed Roll Labels ********************/

  	

   function printedroll_discount_applied_on_order(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');
		
		$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )  ");

		$res   = $qry->row_array();

		return $res;  

	}

   function check_printedroll_voucher_applied($newGrandTotal){

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		$res   = $qry->row_array();

		if($res){

			if($res['grandtotal']!=$newGrandTotal){

				

						$amount = $this->calculate_total_printedroll_amount();	

						$this->update_printedroll_discount_voucher($amount);

							 

			}

			$qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

		    $res   = $qry->row_array();

		}

		return $res;  

	}

	

	

	function update_printedroll_discount_voucher($GrandTotal){



				$discout_perct =  number_format(10/100,2);

				$DsountOff = $GrandTotal * $discout_perct;

				$session_id = $this->session->userdata('session_id');

				$data = array(

						   'discount_offer' => $DsountOff,

						   'grandtotal' => $GrandTotal,

						);

			$update = $this->db->update('voucherofferd_temp', $data, array('SessionID' => $this->sessionid()));

	}

	

	function check_printedroll_offer_voucher(){

		return false;

		$session_id = $this->session->userdata('session_id');

		$query = $this->db->query(" SELECT count(temporaryshoppingbasket.ProductID) AS total from products INNER JOIN temporaryshoppingbasket ON 

		      						products.ProductID=temporaryshoppingbasket.ProductID WHERE SessionID = '".$session_id."' AND 

			   						temporaryshoppingbasket.Printing LIKE 'Y' AND  (ProductBrand LIKE 'Roll Labels')");

		$row = $query->row_array();	

		

		

		if(isset($row['total']) and $row['total'] > 0){

				return true;

		}else{

            $update = $this->db->delete('voucherofferd_temp',array('SessionID' => $this->sessionid(),'UserID'=>0,'vc_type'=>'printedroll'));

           	return false;

		}

	}

	function calculate_total_printedroll_amount(){

	    return 0.00;	

		$session_id = $this->session->userdata('session_id');

		$query = $this->db->query(" SELECT SUM(TotalPrice) AS total from products INNER JOIN temporaryshoppingbasket ON 

									products.ProductID=temporaryshoppingbasket.ProductID WHERE SessionID = '".$session_id."' AND 

									temporaryshoppingbasket.Printing LIKE 'Y' AND  (ProductBrand LIKE 'Roll Labels')");

		$row = $query->row_array();	

		if(isset($row['total']) and $row['total']!=''){

			return $row['total']*1.2;

		}else{

			return 0.00;	

		}

  }

  /*************************************************/

	function grouped_country_list($type){

		$query = $this->db->query("SELECT * FROM `shippingcountries` WHERE `status` = 'active' AND 

		`country_group` LIKE '".$type."' ORDER BY name ASC ")->result();

		return $query;	

	}

    function get_country_Id($type){

        $query = $this->db->query("SELECT ID FROM `shippingcountries` WHERE `status` = 'active' AND 

		`name` LIKE '".$type."' ORDER BY name ASC ")->result();

        return $query;

    }

	function is_order_integrated()

	{

		$cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id');

		$result = $this->db->query("select COUNT(*) as total from temporaryshoppingbasket temp JOIN products pro on temp.ProductID = pro.ProductID WHERE (temp.SessionID = '".$session_id."' OR temp.SessionID ='".$cisess_session_id."' )  AND pro.ProductBrand = 'Integrated Labels' and OrderData != 'Sample'");

		$row = $result->row_array();

		return $row['total'];

	}	

	function get_integrated_delivery_charges(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
		$session_id = $this->session->userdata('session_id'); 

		$int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `temporaryshoppingbasket` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and (t.SessionID = '".$session_id."' OR t.SessionID ='".$cisess_session_id."' ) and t.p_name != 'Delivery Charges'")->row_array();

		

		

		$dpd = $this->home_model->get_integrated_delivery($int_sheets['qty']);

		$dpd = $dpd['dpd'];

		return $dpd;

		

		/*$qry = $this->db->query("SELECT * FROM temporaryshoppingbasket WHERE SessionID = '".$this->sessionid()."' AND p_name ='Delivery Charges'");

		return $qry->result();*/

	}

	

	

	

	/****************** Trade Print Functions***********************/

	

	function split_trade_order($orderNum)

	{

		$redirect_from = $this->session->userdata('redirect_from');

		if($redirect_from)

		{

			$orderDetails = $this->shopping_model->order($orderNum);

			$orderLines = $this->shopping_model->order_detail($orderNum);

			

			$serials_array = array();

			foreach ($orderLines as $line)

			{

				if($line['page_location'] == "Trade Print")

				{

				}

				else

				{

					$serials_array[] = $line['SerialNumber'];

				}

			}

			

			if($serials_array)

			{

				$sessionid = $this->session->userdata('session_id');

				$this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));

				$order_num = $this->db->insert_id();

				$OrderNumber = 'AA'.$order_num;

				

				$orderTotal = 0;

				foreach($serials_array as $serial)

				{

					$orderTotal += $this->home_model->get_db_column('orderdetails','ProductTotal','SerialNumber',$serial);

					

					$this->db->set('OrderNumber', $OrderNumber);

					$this->db->where('SerialNumber', $serial);

					$this->db->update('orderdetails');

					

					$this->db->set('OrderNumber', $OrderNumber);

					$this->db->where('Serial', $serial);

					$this->db->update('order_attachments_integrated');

				}

				

				$orderDetails['OrderTotal'] = $orderDetails['OrderTotal'] - $orderTotal;

				

				$this->db->where('OrderNumber',$orderDetails['OrderNumber']);

				$this->db->update('orders',$orderDetails);

				

				$AAOrder = $orderDetails;

				

				unset($AAOrder['OrderID']);

				$AAOrder['OrderNumber'] = $OrderNumber;

				$AAOrder['OrderTotal'] = $orderTotal;

				$this->db->insert('orders',$AAOrder);

				

				//if order status == 2/32 then check if the line is plain, then change the status to 55.

				if(($AAOrder['OrderStatus'] == 2) || ($AAOrder['OrderStatus'] == 32))

				{

					$this->change_order_status_confirmation($OrderNumber);

				}

			}

		}

	}

	

	function change_order_status_confirmation($orderNum)

	{

		

		$plain_query = "select count(*) as total from orderdetails where OrderNumber LIKE '".$orderNum."' AND Printing NOT LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels'";



		$printed_query = "select count(*) as total from orderdetails where OrderNumber LIKE '".$orderNum."' AND Printing LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels'";

		

		//$plain_order = $this->db->query($plain_query)->row()->total;

		$printed_order = $this->db->query($printed_query)->row()->total;

		if(!$printed_order)

		{

			$this->db->set('OrderStatus', 2);

			$this->db->where('OrderNumber', $orderNum);

			$this->db->update('orders');

		}

	}

	
	




// End of Class

}