<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class quotation extends CI_Controller {

	
	function __construct(){
		parent::__construct();	
		$this->load->database();

		$this->load->model('order_quotation/CustomDieModal');
		$this->load->model('order_quotation/quotationModal');
		$this->load->model('order_quotation/orderModal');
		$this->load->model('myPriceModel');
		$this->load->model('cart/cartModal');
		$this->load->model('quoteModel');
		$this->home_model->user_login_ajax();
		//error_reporting(E_ALL);


	}
   
   
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   

 public function test(){
     $data['quotation'] = $this->quotationModal->saveorder('dsdasd','dsadsa');
     $this->load->view('page',$data);
 }
 
 public function index(){
     $data['main_content'] = "order_quotation/quotation/quotation_detail_list";
     $this->load->view('page',$data);
 }

 public function getAllQuotations(){
	 echo $this->quotationModal->getAllQuotations();
 }

 public function getQuotationDetail($quotationNumber) {

	 $data['quotation'] = $this->quotationModal->getQuotation($quotationNumber)[0];
	 $data['digitalis'] = $this->cartModal->digitalPrintingProcess();


	 $data['quotationDetails'] = $this->quotationModal->getQuotationDetail($quotationNumber);
	 $data['allCheck'] = $this->quotationModal->getAllCheck($quotationNumber);
	 $data['notes'] = $this->orderModal->getOrderNotes($quotationNumber);
	 $data['declineNotes'] = $this->orderModal->declineNotes($quotationNumber);
	 $data['customerNotes'] = $this->orderModal->getCustomerNotes($quotationNumber);
	 
	 $data['is_custom_lines'] = $this->quotationModal->all_custom_lines($quotationNumber);
	 $data['is_normal_lines'] = $this->quotationModal->all_normal_lines($quotationNumber);
	 
	 $data['main_content'] = "order_quotation/quotation/quotation_detail_page";
	 $this->load->view('page',$data);
 }



 public function calculatePrice(){
    
    if($_REQUEST['shapes']!="Irregular"){
     echo  $res= $this->CustomDieModal->calculatePrice();
    }else if($_REQUEST['shapes']=="Irregular"){
      echo json_encode(array('response'=>'yes','data'=>'Irregular'));
    }
  }
	public function cancelCart(){
		echo $this->CustomDieModal->cancelCart();
	}

	public function  getTempDisVal(){
		echo $this->CustomDieModal->getTempDisVal($this->input->get('id'));
	}

  public function applyDiscount(){

		$id = $this->input->get('id');
		$quotationNumber = $this->input->get('quotationNumber');
		
		if($this->input->get('quo') == 'quo'){
			$this->MakeNewQuoWithApplyDis($id,$quotationNumber);
		}else{
			$record = $this->db->query("select * from flexible_dies_info where CartID = '".$id."'")->result_array();
			$temp = $this->db->query("SELECT * FROM temporaryshoppingbasket where ID = '".$record[0]['CartID']."'")->result_array();
			$price = $temp[0]['TotalPrice'] - $record[0]['discount_val'];
			$price  = number_format($price,2,'.','');
			$temp[0]['UnitPrice'] = $price;
			$temp[0]['TotalPrice'] = $price;
			$record[0]['discount'] = $record[0]['temp_dis'];
			$this->db->update('flexible_dies_info', $record[0], array('CartID' => $id));
			$this->db->update('temporaryshoppingbasket', $temp[0], array('ID' => $record[0]['CartID']));
			$this->load->model('cart/cartModal');
			echo json_encode(array('price'=>$price,'cartPrice'=>$this->cartModal->getCarTotalPrice()));
		}
	}

    public function deleteDiscount(){
			
        $id = $this->input->post('id');
        $quotationNumber = $this->input->post('quotationNumber');
			
        if($this->input->post('quo') == 'quo'){
            $this->MakeNewQuoWithDeleteDis($id,$quotationNumber);
        }else{
            $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$id."'")->result_array();
            $temp = $this->db->query("SELECT * FROM temporaryshoppingbasket where ID = '".$record[0]['CartID']."'")->result_array();
            $actual =  $record[0]['discount_val'];
            $price = $temp[0]['UnitPrice'] + $actual;
					  $price  = number_format($price,2,'.','');
            $temp[0]['UnitPrice'] = $price;
            $temp[0]['TotalPrice'] = $price;
            $record[0]['discount'] = 0;
            $this->db->update('flexible_dies_info', $record[0], array('CartID' => $id));
            $this->db->update('temporaryshoppingbasket', $temp[0], array('ID' => $record[0]['CartID']));
            $this->load->model('cart/cartModal');
            echo json_encode(array('price'=>$price,'cartPrice'=>$this->cartModal->getCarTotalPrice()));
        }
    }
	
    function MakeNewQuoWithApplyDis($id,$quono){
        $quotationDetail = $this->db->query("select * from quotationdetails where QuotationNumber = '".$quono."'")->result_array();
        $quotation = $this->db->query("select * from quotations where QuotationNumber = '".$quono."'")->result_array()[0];
        $nextId = $this->db->query("SELECT MAX(QuotationID) as id FROM quotations")->result_array()[0];

        $quotationNumber = $nextId['id'];
        $quotationNumber = $quotationNumber + 1;
        $quotationNumber =   'AAQ'.$quotationNumber;
        unset($quotation['QuotationID']);
        $quotation['QuotationNumber'] = $quotationNumber;
        $quotation['QuotationDate'] = time();
        $quotation['QuotationTime'] = time();
        $this->db->insert('quotations',$quotation);

        $disVal ='0.00';
        foreach ($quotationDetail as $detail){
            $detail['QuotationNumber'] = $quotationNumber;

            if($id == $detail['SerialNumber']){
                $disVal =  (($detail['Price'] /100)*$detail['temp_dis']);
                $price = $detail['Price'] - $disVal;
                $detail['Price'] = $price;
                $detail['ProductTotalVAT'] = $price;
                $detail['ProductTotal'] = $price;
                $detail['discount'] = $detail['temp_dis'];
                $lastSerialNumber = $detail['SerialNumber'];
                unset($detail['SerialNumber']);

                $this->db->insert('quotationdetails', $detail, array('SerialNumber' => $id));
                $lastId = $this->db->insert_id();


                $flxInfo = $this->db->query("select * from flexible_dies_info where QID = '".$lastSerialNumber."'")->result_array()[0];

                $flxInfo['QID'] = $lastId;
                $flxInfo['discount_val'] = $disVal;
                $flxInfo['discount'] = $detail['temp_dis'];
                $this->db->where('QID',$lastSerialNumber);
                $this->db->update('flexible_dies_info',$flxInfo);
            }else{
                $this->db->insert('quotationdetails', $detail, array('SerialNumber' => $id));
                $lastId = $this->db->insert_id();
            }
        }
        echo json_encode(array('number'=>$quotationNumber));
    }
	
    public function MakeNewQuoWithDeleteDis($id,$quono){
			
        $quotationDetail = $this->db->query("select * from quotationdetails where QuotationNumber = '".$quono."'")->result_array();
        $quotation = $this->db->query("select * from quotations where QuotationNumber = '".$quono."'")->result_array()[0];
        $nextId = $this->db->query("SELECT MAX(QuotationID) as id FROM quotations")->result_array()[0];

        if($this->input->post('quo') == 'quo'){
            $quotationNumber = $nextId['id'];
            $quotationNumber = $quotationNumber + 1;
            $quotationNumber =   'AAQ'.$quotationNumber;
            unset($quotation['QuotationID']);
            $quotation['QuotationNumber'] = $quotationNumber;
            $quotation['QuotationDate'] = time();
            $quotation['QuotationTime'] = time();
            $this->db->insert('quotations',$quotation);


            foreach ($quotationDetail as $detail){

							if($id == $detail['SerialNumber'])
							{
								$actual =  $detail['discount_val'];
								$detail['ProductTotalVAT'] = $detail['ProductTotalVAT']+ $actual;
								$detail['Price'] = $detail['Price'] + $actual;
								$detail['ProductTotal'] = $detail['ProductTotal'] +  $actual;
								$detail['discount'] = '';
								$detail['discount_val'] = '';
								

								$lastSerialNumber = $detail['SerialNumber'];
								$detail['QuotationNumber'] = $quotationNumber;
								unset($detail['SerialNumber']);
								$this->db->insert('quotationdetails', $detail, array('SerialNumber' => $id));
								$lastId = $this->db->insert_id();
								

								$flxInfo = $this->db->query("select * from flexible_dies_info where QID = '".$lastSerialNumber."'")->result_array()[0];
								$flxInfo['QID'] = $lastId;
								$this->db->where('QID',$lastSerialNumber);
								$this->db->update('flexible_dies_info',$flxInfo);
							}else{
								$detail['QuotationNumber'] = $quotationNumber;
									unset($detail['SerialNumber']);
								$this->db->insert('quotationdetails', $detail, array('SerialNumber' => $id));
							}
						}
					echo json_encode(array('number'=>$quotationNumber));
				}
		}
	
	public function updateCategory(){
		echo  $this->quotationModal->updateCategory();
	}

	public function updateDetailPrice(){
	    
	   /* ini_set('display_errors', 1);
	    	error_reporting(E_ALL);*/
	    	
		$this->quotationModal->updateQuotationDetail();
		$this->getPriceAndUpdateIt();
		
		$serial_no = $_POST['serialNumber'];
        $this->setIntegratedDelivery($serial_no);
	}

    public function setIntegratedDelivery($serial){
		$amount = 0;
		$res = $this->quotationModal->getQuotationDetailBySerialNumber($serial);
		$quoteID = $res[0]->QuotationNumber;
		
		
		$qede = $this->quotationModal->getQuotation($quoteID);
		$ShippingID = $qede[0]->ShippingServiceID;
		
		$county = $this->quotationModal->getShipingServiceName($ShippingID);
		$ShipingService = $this->quotationModal->getShipingService($county['CountryID']);
		
		
		$query = $this->db->query("select (QuotationTotal-QuotationShippingAmount) as total,QuotationTotal from quotations where QuotationNumber LIKE '".$quoteID."'");
		$row  = $query->row_array();
		
		$integrated = $this->quotationModal->is_quotation_integrated($quoteID);
		
		if($integrated > 0){
			$amount = $this->quotationModal->delivery_quotation_integrated($quoteID);
		}
		
		$oth = $this->getShoppingCharges($quoteID,$ShippingID,$ShipingService,$row['QuotationTotal'],$amount,$integrated);
		$amount = round($amount,2);
		
		if($ShippingID==11 || $ShippingID==33){
        	$amount = 0.00;
        }
		
		if($integrated > 0){
			$upi =   $amount + $oth;
		}else{
			$upi =   $oth;
		}
		
		if(isset($row['total']) and $row['total'] >0){
			$total = $row['total']+$upi;
		}else{
			$total = $row['QuotationTotal']+$upi;
		}
		//exit;
		
			// AA21 STARTS
	     $query = $this->db->query("Select DeliveryPostcode, quotationCourier, DeliveryCountry from quotations WHERE QuotationNumber = '".$quoteID."' ");
	     $row = $query->row_array();
	     if( (isset($row['DeliveryPostcode']) && $row['DeliveryPostcode'] != '') && (isset($row['DeliveryCountry']) && $row['DeliveryCountry'] != '') )
	     {
	        $D_postcode = $row['DeliveryPostcode'];
	        $deliveryCourier = $row['quotationCourier'];
	        $DeliveryCountry = $row['DeliveryCountry'];
	        $offshore = $this->product_model->offshore_delviery_charges_WPC($D_postcode, $DeliveryCountry); 


	        if( ($offshore['status'] != true) && ($DeliveryCountry == 'United Kingdom') && ($upi > 0) && ($deliveryCourier == 'DPD') )
	        {
	            $upi = $upi + 1;
	        }
	     }
	     // $upi = $upi * vat_rate;
	    // AA21 ENDS
	    
		$this->db->where('QuotationNumber',$quoteID);
		$this->db->update('quotations',array('QuotationTotal'=>$total,'QuotationShippingAmount'=>$upi));

	}
	
	public function getPriceAndUpdateIt(){

		if($_POST['printing'] == 'Y' || $_POST['printing'] == 'Yes'){

			if($_POST['regmark'] == 'Y'){
				$params = array(
					'labeltype'=>'Monochrome - Black Only',
					//'labels'=> $_POST['qty'] * $_POST['LabelsPerSheet'],
					'labels'=> $_POST['labels'],
					'design'=>1,
					'menu'=>$_POST['manfactureID'],
					'persheets'=>$_POST['labels']/$_POST['qty'],
					'producttype'=>($_POST['brand'] == 'Roll Labels')?'Rolls':'sheet',
					'pressproof'=>0,
					'finish'=>'No Finish',
					'brand'=>$_POST['brand'],
					'printing'=>$_POST['printing'],
					'customerId'=>$_POST['customerId'],
					'serialno'=>$_POST['serialNumber'],
					'qty'=>$_POST['qty'],
					'max_lbl' => $_POST['LabelsPerSheet']
				);
			}else{
				$params = array(
					'labeltype'=>$_POST['digital'],
					//'labels'=>$_POST['qty'] * $_POST['LabelsPerSheet'],
					'labels'=> $_POST['labels'],
					'design'=>$_POST['design'],
					'menu'=>$_POST['manfactureID'],
					'persheets'=>$_POST['labels']/$_POST['qty'],
					'producttype'=>($_POST['brand'] == 'Roll Labels')?'Rolls':'sheet',
					'pressproof'=>$_POST['pressProff'],
					'finish'=>(isset($_POST['finish']))?$_POST['finish']:'',
					'brand'=>$_POST['brand'],
					'printing'=>$_POST['printing'],
					'customerId'=>$_POST['customerId'],
					'serialno'=>$_POST['serialNumber'],
					'qty'=>$_POST['qty'],
					'max_lbl' => $_POST['LabelsPerSheet']
				);
			}

		}else{
			$params = array(
				'printing'=>$_POST['printing'],
				'brand'=>$_POST['brand'],
				'qty'=>$_POST['qty'],
				'manfactureId'=>$_POST['manfactureID'],
				'rolls'=>$_POST['qty'],
				'labels'=> $_POST['labels'] / $_POST['qty'],
				//'labels'=>$_POST['qty'] *$_POST['LabelsPerSheet'],
				'labelsPerSheet'=>$_POST['LabelsPerSheet'],
				'serialno'=>$_POST['serialNumber'],
				'qty'=>$_POST['qty']
			);
		}

		//print_r($params);exit;
		$price = $this->myPriceModel->getPriceForQuotation($params,$_POST['productID']);

		//print_r($price);exit;
		$priceParams = array(
			'Price'=>$price['plainPrice'],
			'Print_Total'=>$price['printPrice'],
			'ProductTotalVAT'=>$price['plainPrice'],
			'ProductTotal'=>number_format($price['totalPrice'] ,2,'.',''),
            'Free' => $price['Free']
		);

		$mattpe = ($_POST['brand'] == 'Roll Labels') ? 'Roll' : 'A4';
		if( ($mattpe =='Roll' && $_POST['printing'] != 'Y') || ($mattpe =='A4') ){

            $m_codes = ($mattpe ==Roll) ? substr($_POST['manfactureID'], 0,-1):$_POST['manfactureID'];
            $material_code = $this->home_model->getmaterialcode($m_codes);

            $material_discount = $this->home_model->check_material_discount($material_code, $mattpe);
            if ($material_discount != null) {
                $disRate = ($priceParams['Price'] * $material_discount) / 100;
                $priceParams['Price'] = number_format($priceParams['Price'] - $disRate, 2,'.','');
            }
        }
		
		
		
		$this->db->where('SerialNumber',$_POST['serialNumber']);
		$this->db->update('quotationdetails',$priceParams);
		echo true;
	}
	
	function quotaion_currency(){
		if($_POST){
			$currency = $this->input->post('currency');
			$qnumber = $this->input->post('quotenumber');
			$rate   = $this->get_quote_exchange_rate($currency);
      	      
			$this->db->where('QuotationNumber',$qnumber);
			$this->db->update('quotations',array('currency'=>$currency,'exchange_rate'=>$rate));
			echo 'yes';
		}
	}
	
	function order_currency(){
	   if($_POST){
		 $currency = $this->input->post('currency');
		 $ordernumber = $this->input->post('ordernumber');
		 $rate   = $this->get_quote_exchange_rate($currency);
		
		 if(isset($ordernumber) && $ordernumber!=""){		  
		   $this->db->where('OrderNumber',$ordernumber);
		   $this->db->update('orders',array('currency'=>$currency,'exchange_rate'=>$rate));
		   echo 'yes';
		 }
 	   }
    }
    
     
	function get_quote_exchange_rate($code){
		$sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '".$code."'");
		$sql = $sql->row_array();
		return $sql['rate'];
	}
    
	function set_currency(){
		if($_POST){
			$currency = $this->input->post('currency');
			$symbol   = $this->get_currecy_symbol($currency);
			//echo $symbol;exit;
			//$symbol = $this->input->post('symbol');
			if(isset($currency) and $currency!=''){
				$_SESSION['currency'] = $currency;
				$_SESSION['symbol'] = $symbol;
			}else{
				$_SESSION['currency'] = 'GBP';
				$_SESSION['symbol'] = '&pound;';
			}
		}
		echo 'yes';
	}

	function get_currecy_symbol($code){
		$sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$code."'");
		$sql = $sql->row_array();
		return $sql['symbol'];
	}

	public function updateShipping(){
		$quoteID = $this->input->post('quoteID');
		$ShippingID = $this->input->post('ShippingID');
		$countryID = $this->session->userdata('CID');
		$deliveryCourier = $this->input->post('deliveryCourier');
		
		
		
		if($countryID==2 && $ShippingID!=11 && $ShippingID!=33){
			$offid = $this->session->userdata('offid');
			$amount = $this->quotationModal->charges_list($offid);
		}else{
			$qr = $this->db->query("select BasicCharges from shippingservices where ServiceID = '".$ShippingID."'");
			$qrs  = $qr->row_array();
			$amount = $qrs['BasicCharges'];
		}
		
		$county = $this->quotationModal->getShipingServiceName($ShippingID);
		$ShipingService = $this->quotationModal->getShipingService($county['CountryID']);


		$query = $this->db->query("select (QuotationTotal-QuotationShippingAmount) as total,QuotationTotal from quotations where QuotationNumber LIKE '".$quoteID."'");
		$row  = $query->row_array();
		
		$integrated = $this->quotationModal->is_quotation_integrated($quoteID);
		
		if($integrated > 0){
			$amount = $this->quotationModal->delivery_quotation_integrated($quoteID);
		}
		
		$oth = $this->getShoppingCharges($quoteID,$ShippingID,$ShipingService,$row['QuotationTotal'],$amount,$integrated);
		$amount = round($amount,2);
		
		if($ShippingID==11 || $ShippingID==33){
        	$amount = 0.00;
        }
		
		if($integrated > 0){
			$upi =   $amount + $oth;
		}else{
			$upi =   $oth;
		}
		
		if(isset($row['total']) and $row['total'] >0){
			$total = $row['total']+$upi;
		}else{
			$total = $row['QuotationTotal']+$upi;
		}
		//exit;
		
		// AA21 STARTS
			$query = $this->db->query("Select DeliveryPostcode, DeliveryCountry from quotations WHERE QuotationNumber = '".$quoteID."' ");
	        $row = $query->row_array();

	        if( (isset($row['DeliveryPostcode']) && $row['DeliveryPostcode'] != '') && (isset($row['DeliveryCountry']) && $row['DeliveryCountry'] != '') && ($deliveryCourier == 'DPD') )
	        {
	        	$D_postcode = $row['DeliveryPostcode'];
	            $DeliveryCountry = $row['DeliveryCountry'];

	            $offshore = $this->product_model->offshore_delviery_charges_WPC($D_postcode, $DeliveryCountry); 
	            if( ($offshore['status'] != true) && ($DeliveryCountry == 'United Kingdom') && ( $upi > 0 ) )
	            {
	                $upi = $upi + 1;
	            }
	        }
	        // $upi = $upi * vat_rate;
	    // AA21 ENDS
	    
	    
	    
		$this->db->where('QuotationNumber',$quoteID);
		 // AA21 STARTS
			$this->db->update('quotations',array('QuotationTotal'=>$total,'ShippingServiceID'=>$ShippingID,'ServiceID'=>$ShippingID,'QuotationShippingAmount'=>$upi, "quotationCourier" => $deliveryCourier));
		// AA21 ENDS
		
		echo "updated";
	}

    public function getShoppingCharges($quoteID,$ShippingID,$ShipingService,$amount,$QuotationTotal,$integrated){
		
		$quotation = $this->quotationModal->getQuotation($quoteID);
		//print_r($quotation);
		$currency_options = $this->cartModal->get_currecy_options();
		$currency = $quotation[0]->currency;
		$exchange_rate = $quotation[0]->exchange_rate;
		$deliver = 0;
		
		
		foreach ($ShipingService as $res) {
			$selected = '';
			if ($res['ServiceID'] == $ShippingID) {
				$basiccharges = $res['BasicCharges'];
				$deliver  = number_format(($res['BasicCharges'] * $exchange_rate), 2, '.', '');
			}

			if (($QuotationTotal * vat_rate) < 25.00 && $res['ServiceID'] == 20) {
				$basiccharges = 6.00;
				
			} else {
				
				
				if ($res['BasicCharges'] == '0.00') {
					
				} else {
																		
					/*if($integrated > 0){		
						echo number_format((($res['BasicCharges'] + $amount) * $exchange_rate) / 1.2, 2, '.', 	''); echo '<br>';
					} else {
						echo number_format(($res['BasicCharges'] * $exchange_rate) / 1.2, 2, '.', 	'');echo '<br>';
					}*/
																				
				}
                                                    
			}                           
		} 
		
		return $deliver;
	}
	
	public function showquotepdf($quoteID,$stid,$ver) {

		$type = ($stid==1)?'hide':'show';
		$this->quotation_pdf($quoteID,$ver,$type);
		$this->pdf->stream("Quotation No :".$quoteID.".pdf");
		// $this->pdf->load_view('print-pdf2.php',$data);
	}
	
	function quotation_pdf($QuotationNo,$language,$type){

		$CI =& get_instance();
		if($type=="show"){
			$page = ($language=="en")?"order_quotation/quotation/en/quoteconfirm.php":"order_quotation/quotation/fr/quoteconfirm.php"; }
		else{
			$page = ($language=="en")?"order_quotation/quotation/en/quotehide.php":"order_quotation/quotation/fr/quotehide.php";
		}

		$query = $CI->db->get_where('quotations', array('QuotationNumber' => $QuotationNo));
		$res = $query->result_array();
		$res = $res[0];
		
		$data['type'] = $type;
		$data['OrderInfo'] = $res;
		//print_r($data['OrderInfo']);exit;
		$data['OrderDetails'] = $CI->quotationModal->quoteDetails($QuotationNo);
		//echo $this->load->view($page,$data,TRUE);
		//exit();
		$this->load->library('pdf');
		$this->pdf->load_view($page,$data,TRUE);
		$CI->pdf->render();

		$output = $CI->pdf->output();
		$file_location = "pdf/QuoteConfirmation_".$QuotationNo.".pdf";
		$filename = $file_location;
		$fp = fopen($filename, "a");
		file_put_contents($file_location,$output);
	}

    public function changestatus()
    {
        $status = $this->input->get('status');
        $id = $this->input->get('id');
        $update = array(
            'QuotationStatus' => $status,
        );
        $this->quotationModal->changestatus($id,$update);
    }

    public function generateorder($quotationNumber)
    {


        $data['quotation'] = $this->quotationModal->getQuotation($quotationNumber)[0];
        $data['digitalis'] = $this->cartModal->digitalPrintingProcess();
        $data['quotationDetails'] = $this->quotationModal->getQuotationDetailForOrder($quotationNumber);
        $data['notes'] = $this->orderModal->getOrderNotes($quotationNumber);
        $data['main_content'] = 'generateorder';
        $this->load->view('page',$data);

    }

    function getsituation(){
        $OrderNumber = $this->input->post('id',true);
        $query = $this->db->query("Select count(*) as total from quotationdetails WHERE active = 'Y'  AND QuotationNumber LIKE '".$OrderNumber."'");
        $row = $query->row_array();
        if($row['total'] > 0){

            $data['result']="pass";
            echo json_encode($data);
        }else {
            $data['result']="error";
            echo json_encode($data);
        }


    }

    function selectlineall(){
        $id = $this->input->post('id',true);
        $val = $this->input->post('val',true);

        $this->db->where('QuotationNumber',$id);
        $this->db->update('quotationdetails',array('active'=>$val));
        return true;

    }
    public function deletequoteitem()
    {
        if($this->input->get()==TRUE){
            $id= $this->input->get('id');
            $prl= $this->input->get('prl_id');
            $mid= $this->input->get('mid');
            $this->quotationModal->deletequoteitem($id);
            if($mid=="PRL1"){
                $this->quotationModal->Deletroll_print_quote($prl);
            }
            
			$this->home_model->save_logs('delete_quote',array('id'=>$id));  //SAVE LOG

        }

        echo true;

    }



    public function generateQuotationToOrder(){

        if($this->input->post()==TRUE){

            $quoteNo = $this->input->post('quoteNo');
            $paymentmethod = $this->input->post('payment');
            $vatpass = $this->input->post('vat_pass');

            if(isset($vatpass) and $vatpass=='Y'){
                $this->db->update('quotations', array('vat_exempt'=>'yes'), array('QuotationNumber'=>$quoteNo));
            }


            $OrderNo =  $this->quotationModal->saveorder($quoteNo,$paymentmethod);
					
			//$this->orderModal->order_confirmation_new($OrderNo);



            if($paymentmethod=='creditCard'){
                redirect(main_url. 'order_quotation/Order/worldpay');
            } else  if($paymentmethod=='paypal'){
                redirect(main_url . 'order_quotation/Order/paypal');
            }
            $this->changeQuotationDetailStatus($this->input->post('quoteNo'));
            $data['OrderDetail'] = $this->orderModal->OrderDetails($OrderNo);
            $data['OrderInfo'] = $this->orderModal->OrderInfo($OrderNo);


            // add invoice & send email
            if($paymentmethod=='Sample Order'){
                if(MODE == 'live'){
                   // $this->orderemail($OrderNo);
                }

                // $this->orderModel->addinvoice($OrderNo);
            }
            // add invoice

            $d = $data['order'] = $this->orderModal->getOrder($OrderNo);
            $data['orderDetails'] = $this->orderModal->getOrderDetail($OrderNo);
            $data['status'] = $this->orderModal->statusDropDown($d[0]->OrderStatus,$d[0]->PaymentMethods);
            $data['main_content'] = 'order_quotation/checkout/confirm_my_order';
            $this->load->view('page', $data);


        }
    }

    public function changeQuotationDetailStatus($quoNumber){
        $records = $this->quotationModal->quoteDetailsRecord($quoNumber);

        foreach ($records as $record){
            $record['active'] = 'c';
            $this->db->where('SerialNumber',$record['SerialNumber']);
            $this->db->update('quotationdetails',$record);
        }
        return true;
    }
    
    function orderemail($OrderNo)
    {
        $data['OrderDetail'] = $this->orderModal->OrderDetails($OrderNo);
        $data['OrderInfo'] = $this->orderModal->OrderInfo($OrderNo);

            if(MODE == 'live'){
                $this->orderModal->order_confirmation_new($OrderNo);
            }

            
    }

    public function emailtemplate($id)

    {

        $query = $this->db->get_where(Template_Table, array('MailID' => $id));

        return $query->row_array();

    }

    public function quotationNewLine(){
        $this->quotationModal->quotationNewLine($_POST);
        echo true;
    }

    public function updateQuotationNewLine(){
        $this->quotationModal->updateQuotationNewLine($_POST);
        echo true;
    }

    public function checkAllDetails(){
        $this->quotationModal->checkAllDetails();
        echo true;
    }
    
    function loadregmarkpopup(){
	   $data['reg_diecode'] = $this->input->post('diecode');
	   $data['reg_shape'] = $this->input->post('shape');
	   $data['reg_productID'] = $this->input->post('productID');
	   $data['reg_source'] = $this->input->post('source');
	   $data['compare'] = $this->input->post('compare');
	   $html = $this->load->view('order_quotation/regmarkpop',$data,true);
	   
	   $json_data = array(
			'response' => 'yes',
			'html' => $html
		);
	   $this->output->set_output(json_encode($json_data));
	    
	}
	
	function update_billing(){
     $id = $this->input->post(QuotationNumber);
     $this->quotationModal->updateBilling($id); 
     
    }
    
    function update_delivery(){
     echo  $id = $this->input->post(QuotationNumber);
      $this->quotationModal->updateDelivery($id); 
     
    }
  
   /***************** wtp voucher ******************/
  function get_wtp_vouvher_auth(){
	
    $voucher = $this->input->post('voucher',true);
    $GrandTotal = $this->input->post('GrandTotal',true);
    $voucher = strtolower(trim($voucher));
    $wtp_offer = $this->quoteModel->check_wtp_offer_voucher();	

    if( $wtp_offer==true and $voucher == 'wtp10'){
				
      $amount = $this->quoteModel->calculate_total_wtp_amount();	
      $discout_perct =  number_format(15/100,2);
      $DisountOff = $amount * $discout_perct;
			
					
      $date = time();
      $session_id = $this->session->userdata('session_id');
      $GrandTotal = number_format($GrandTotal,2,'.','');
					
      $this->db->query("INSERT INTO `voucherofferd_temp` (`ID`, `SessionID`, `DateLogged`,`discount_offer`,`grandtotal`)
      VALUES (NULL, '".$session_id."', '".$date."','".$DisountOff."', '".$GrandTotal."')");
      $data = array('is_error'=>'no');
      echo json_encode($data);
    }
    else{
      $data = array('is_error'=>'Yes');
      echo json_encode($data);
    }
	
  }


function apply_wtp_vouvher_quotation(){
	
	$voucher = $this->input->post('voucher',true);
	$GrandTotal = $this->input->post('GrandTotal',true);
	$quotenumber = $this->input->post('quotenumber',true);
	$voucher = strtolower(trim(mysql_real_escape_string($voucher)));
	$wtp_offer = $this->quoteModel->check_wtp_quotation_offer_voucher($quotenumber);	

	if( $wtp_offer==true and $voucher == 'wtp10'){
				
					$amount = $this->quoteModel->calculate_quotation_total_wtp_amount($quotenumber);	
					$discout_perct =  number_format(15/100,2);
					$DisountOff = $amount * $discout_perct;
			
					
					$date = time();
					$session_id = $this->session->userdata('session_id');
					$GrandTotal = number_format($GrandTotal,2);
					
					$this->db->query("INSERT INTO `voucherofferd_temp` (`ID`, `SessionID`, `DateLogged`,`discount_offer`,`grandtotal`)
					VALUES (NULL, '".$session_id."', '".$date."','".$DisountOff."', '".$GrandTotal."')");
					$data = array('is_error'=>'no');
					echo json_encode($data);
	}
	else{
			$data = array('is_error'=>'Yes');
			echo json_encode($data);
	}
	
}
  function remove_wtp_voucher_offer(){
		$session_id = $this->session->userdata('session_id');
		$qry = $this->db->query("DELETE FROM  `voucherofferd_temp` WHERE `SessionID`  = '".$session_id."' ");
		if($qry){
			$data = array('is_error'=>'no');echo json_encode($data);
		}
} 	
  
  
   public function updatePressPrice(){

    $type = $this->input->post('type');
    $qty = $this->input->post('qty');
    $serial = $this->input->post('serial');
    $foc = $this->input->post('foc');
    
    $pagess = $this->input->post('pagess');
    $QNum = $this->input->post('QNum');
    $UseID = $this->input->post('UseID');    
    $ex = $this->input->post('ex');
    
    $price_ten = 0;
    $price_over_ten = 0;
    $price_over_each = '12.90';
    $qty_match = $qty;
    
    $over_ten_qty = 0;
    
    if($qty > 10){
      $over_ten_qty  =  ($qty - 10); 
      $qty_match = 10;
    }
    
    if($qty_match=='2'){ $price_ten = '50.00'; }
    if($qty_match=='4'){ $price_ten = '80.00'; }
    if($qty_match=='6'){ $price_ten = '110.00'; }
    if($qty_match=='8'){ $price_ten = '136.00'; }
    if($qty_match=='10'){ $price_ten = '155.00'; }
      
    
    if($over_ten_qty!=0){
      $price_over_ten = round($over_ten_qty * $price_over_each,2);
    }
    
    $price = number_format( ($price_over_ten + $price_ten)  ,2,'.','');
    
    if($foc=="Y"){
      $price = '0.00';
    }
    
    if($pagess=='order_page'){
      $in_arr = array(
        'odp_proof'       =>'Y',
        'odp_qty'         => $qty,
        'odp_foc'         =>$foc,
        'odp_price' =>$price             
        );
    
      if($serial){
        $this->db->where('SerialNumber',$serial);
        $this->db->update('orderdetails',$in_arr);
      }
    }else{
      $in_arr = array(
        'qp_proof'       =>'Y',
        'qp_qty'         => $qty,
        'qp_foc'         =>$foc,
        'qp_price' =>$price             
      );
      
      if($serial){
      $this->db->where('SerialNumber',$serial);
      $this->db->update('quotationdetails',$in_arr);
      }
      
    }

    
    echo true;
    
    
  }
  
  
  
  public function deletePressproof(){
   
    $serial = $this->input->post('serial');
    $pagess = $this->input->post('pagess');
    
     if($pagess=='order_page'){
       $in_arr = array(
         'odp_proof'       =>'N',
         'odp_qty'         => NULL,
         'odp_foc'         =>'N',
         'odp_price' =>NULL            
       );
     
       if($serial){
         $this->db->where('SerialNumber',$serial);
         $this->db->update('orderdetails',$in_arr);
       }
       
     }else{
       $in_arr = array(
         'qp_proof'       =>'N',
         'qp_qty'         => NULL,
         'qp_foc'         =>'N',
         'qp_price' =>NULL            
       );
     
       if($serial){
         $this->db->where('SerialNumber',$serial);
         $this->db->update('quotationdetails',$in_arr);
       }
     }
    
    echo true;
  }
	
	
	
}
