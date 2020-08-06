<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class quotationModal extends CI_Model
{

        public function getAllQuotations(){
        $ordby = $_POST['sSortDir_0'];
        $this->datatables->select('quotations.QuotationNumber as c')

            ->select('concat(FROM_UNIXTIME(quotations.QuotationDate, "%d/%m/%Y"),"<br>",FROM_UNIXTIME(quotations.QuotationTime, "%h:%i %p"))')
					
            ->select('(select sum(quotationdetails.Quantity) as qty  from quotationdetails where  quotationdetails.QuotationNumber=quotations.QuotationNumber)')
					
            ->select("if( quotations.vat_exempt LIKE 'yes', round((quotations.QuotationTotal),2), round(quotations.QuotationTotal,2) ) AS QuotationTotal")

					 
					
            ->select('concat(quotations.BillingFirstName," ",quotations.BillingLastName),
                                    quotations.BillingPostcode,
                                    quotations.DeliveryPostcode,
                                    CONCAT(quotations.Source," - ",(if(quotations.Source LIKE "Website", "Wholesale",quotations.ProcessedBy))) AS Source,
									
									quotations.QuotationStatus,
									quotations.currency,
									
									quotations.exchange_rate,
         view_count,
         view_status,
									
									 
									')
          
          ->select('concat(FROM_UNIXTIME(quotations.view_time, " %d/%m/%Y")," ",FROM_UNIXTIME(quotations.view_time, "%h:%i %p"))')
          ->select('concat(FROM_UNIXTIME(quotations.requote_time, " %d/%m/%Y")," ",FROM_UNIXTIME(quotations.requote_time, "%h:%i %p"))')
          ->select('quotations.qOrderNo')

            //->edit_column('quotations.QuotationID','$2','quotations.QuotationID,quotations.QuotationNumber')
            //->edit_column('quotations.QuotationNumber','$1','quotations.QuotationStatus,quotations.QuotationNumber')

            //->unset_column('quotations.QuotationStatus')
            ->from('quotations')
            ->order_by("quotations.QuotationDate  $ordby")
            ->where('quotations.BillingFirstName !=','0')
            ->where('quotations.PaymentMethods !=','SampleOrder  ');

         echo $this->datatables->generate();
    }





      public function saveQuotation(){
          //print_r('ji88'); exit;
         $record = $this->insertQuotation($this->getParams());
         $qutationDetail = $this->insertQuotationDetail($record);

         if($qutationDetail['res']){

            $this->deleteCart();
            return $qutationDetail;
         }
   }

    public function getParams(){

        $currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';
        $symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';

        $exchange_rate =  $this->cartModal->get_exchange_rate($currency);
        //$exchange_rate  = $this->get_exchange_rate($currency);

        $customer = $this->getCustomer($this->session->userdata('customer_id'));

        $tempCart = $this->getCartOrders();

        $count = 0;
        $status = 0;
        foreach ($tempCart as $temp){
            if($temp->regmark == 'Y'){
                $status = $count +1;
            }

            if($temp->Printing == 'Y'){
                $status = $count +1;
            }
        }

			$pl_pr = 0;
			if($this->input->post('plain_labels')){
				$pl_pr = $this->input->post('plain_labels');
			}
			
			 // AA21 STARTS
                $courier = "Parcelforce";
                if( ($this->input->post('dcountry') == 'France') || ($this->input->post('dcountry') == 'Luxembourg') || ($this->input->post('dcountry') == 'Switzerland') || ($this->input->post('dcountry') == 'Belgium') )
                {
                    $courier = "Parcelforce";
                }
                else
                {
                    if($this->input->post('courier') != '')
                    {
                        $courier = $this->input->post('courier');
                    }
                }
            // AA21 ENDS

            
        return array(

            'QuotationNumber'=>'AAQ'.$this->getQuoteNum(),
            'SessionID'=>$this->session->userdata('session_id'),
            'UserID'=>$this->session->userdata('customer_id'),
            'QuotationDate' => time(),
            'QuotationTime' => time(),
            'quotationCourier'=> $courier,
            'quotationCourierCustomer'=> $courier,
            'BillingTitle'=>$this->input->post('billing_title'),
            'BillingFirstName'=>$this->input->post('b_first_name'),
            'BillingLastName'=>$this->input->post('b_last_name'),
            'BillingCompanyName'=>$this->input->post('b_organization'),
            'BillingAddress1'=>$this->input->post('b_add1'),
            'BillingAddress2'=>$this->input->post('b_add2'),
            'BillingTownCity'=>$this->input->post('b_city'),
            'BillingCountyState'=>$this->input->post('b_county'),
            'BillingCountry'=>$this->input->post('country'),
            'BillingPostcode'=>$this->input->post('b_pcode'),
            'SecondaryEmail'=>$this->input->post('second_email'),
            'Billingtelephone'=>$this->input->post('b_phone_no'),
            'Billingfax'=>$this->input->post('b_phone_no'),
            'Billingemail'=>$this->input->post('email_valid'),

            'DeliveryTitle'=>$this->input->post('title_d'),
            'DeliveryFirstName'=>$this->input->post('d_first_name'),
            'DeliveryLastName'=>$this->input->post('d_last_name'),
            'DeliveryCompanyName'=>$this->input->post('d_organization'),
            'DeliveryAddress1'=>$this->input->post('d_add1'),
            'DeliveryAddress2'=>$this->input->post('d_add2'),
            'DeliveryTownCity'=>$this->input->post('d_city'),
            'DeliveryCountyState'=>$this->input->post('d_county'),
            'DeliveryCountry'=>$this->input->post('dcountry'),
            'DeliveryPostcode'=>$this->input->post('d_pcode'),
            'Deliverytelephone'=>$this->input->post('d_phone_no'),
            'DeliveryMobile'=>$this->input->post('d_mobile_no'),
            'ShippingServiceID'=>$this->input->post('delivery_option'),
            'QuotationShippingAmount'=>$this->input->post('shippingCharges'),
            'QuotationTotal'=>(($this->getCartTotalPrice()[0]->price  + ($this->input->post('shippingCharges') / 1.2)) * 1.2),
            //'ProcessedBy'=>$customer->UserName,
			'ProcessedBy'=>$this->session->userdata('UserName'),
            'Source'=>'AA',
            //'QuotationStatus'=>($status >0)?'2':'6',
			'QuotationStatus'=>'37',
            'Q2OStatus'=>($status >0)?'6':'6',
            'vat_exempt'=>$this->getVatNumber($this->input->post('b_pcode'),$this->input->post('d_pcode'),$this->input->post('dcountry')),
            'currency'=>$currency,
            'exchange_rate'=>$exchange_rate,
            'Label'=>$pl_pr,
            'OperatorID'=>$this->session->userdata('UserID'),
            'CallbackDate'=>time()+86400,
            'callback_status'=>15,
            'order_person'=>$this->session->userdata('customer_id'),
            'ws_applied'=>($customer->wholesale == 'wholesale')?'1':'0',
            'user_domain'=>0,
            'module'=>'customer'

        );
    }
    public function insertQuotation($params){

        $this->db->insert('quotations', $params);
        /*echo $this->db->insert_id();
        exit();*/
        $quotationId = $this->db->insert_id();
        //$quotationId = 14939;
        /*$query = $this->db->query('SELECT LAST_INSERT_ID()');
        $row = $query->row_array();
        $quotationId = $row['LAST_INSERT_ID()'];*/


        //print_r($quotationId); exit;


				$this->home_model->save_logs('save_quotation',$params);  //SAVE LOG
        $params['id'] = $quotationId;
        return $params;
    }
	
	
    public function insertQuotationDetail($params){

        $tempCart = $this->getCartOrders();
        //print_r('hi ');

        $quote_serail ="";
        foreach( $tempCart as $cartdata)
        {
            $print_type = '';


            $ExVat = round($cartdata->TotalPrice,2);
            $IncVat = round($cartdata->TotalPrice * vat_rate,2);

            //$prodinfo = $this->orderModel->getproductdetail($cartdata->ProductID);
            $prodcompletename = $this->customize_product_name($cartdata->is_custom,$cartdata->ProductCategoryName,$cartdata->LabelsPerRoll,
                ($cartdata->orignalQty / $cartdata->Quantity),$cartdata->ReOrderCode,$cartdata->ManufactureID,$cartdata->ProductBrand,$cartdata->wound,$cartdata->OrderData);

            if($cartdata->ProductID==0){
                $prodcompletename = $cartdata->p_name;
                $p_code=$cartdata->p_code;
            }else{
                $p_code = $cartdata->ManufactureID;
            }


            /*echo '<pre>';
            print_r($prodcompletename); exit;*/

            //if(preg_match('/Integrated Labels/is',$cartdata->ProductBrand)){
              //  $print_type = $cartdata->OrderData;
            //}else{
                $print_type = $cartdata->Print_Type;
        //    }


            
            if($p_code=="PRL1"){
                $query = $this->db->query("SELECT SerialNumber from roll_print_basket WHERE id = '$cartdata->ID' ");
                $row = $query->row_array();
                $PRL_detail =  $row['SerialNumber'];
                
               
            } else{
                $PRL_detail = "";
            }
            
            if($PRL_detail==""){
                     $PRL_detail = 0;
            }





            $product = $this->db->query("select * from products where ProductID = '".$cartdata->ProductID."' ")->row_array();
            $orignalQty = $cartdata->LabelsPerRoll * $cartdata->Quantity;
            if(preg_match('/Integrated Labels/is',$cartdata->ProductBrand)){
                $orignalQty = $cartdata->orignalQty;
            }

				
			$prodinfo = $this->getproductdetail($cartdata->ProductID);
			//echo $cartdata->source;
			//echo $prodinfo['ProductBrand'];
            if($cartdata->Printing=='Y' and preg_match('/Roll Labels/is',$prodinfo['ProductBrand'])){

                if($cartdata->wound=='Y' || $cartdata->wound=='Inside'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}
                $labeltype = $this->get_printing_service_name($cartdata->Print_Type);
                $productname  = explode("-",$cartdata->ProductCategoryName);
                $productname[1] = str_replace("(","",$productname[1]);
                $productname[1] = str_replace(")","",$productname[1]);
                $productname[0] = str_replace("roll labels","",$productname[0]);
                $productname[0] = str_replace("Roll Labels","",$productname[0]);
                $productname = "Printed Labels on Rolls - ".str_replace("roll label","",$productname[0]).' - '.$productname[1];
                $completeName = ucfirst($productname).' '. $wound_opt.' - Orientation '.$cartdata->orientation.', ';
                if($cartdata->FinishType == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
                else{  $labelsfinish = ' With Label finish : '.$cartdata->FinishType; }
                $prodcompletename =$completeName.' '.$labeltype.' '.$labelsfinish;

                $orignalQty = $cartdata->LabelsPerRoll*$cartdata->Quantity;
                if($cartdata->orignalQty !="" && $cartdata->orignalQty !=0){
                    $orignalQty = $cartdata->orignalQty;
                }
				
            }
			
			
            //echo $orignalQty;exit;
            $QDetail =  array('Prl_id' =>$PRL_detail,
                'QuotationNumber' => $params['QuotationNumber'],
                'CustomerID' => $params['UserID'],
                'ProductID' => $cartdata->ProductID,
                'ManufactureID'=>$p_code,
                'ProductName' => $prodcompletename,
                'Quantity' => $cartdata->Quantity,
                'LabelsPerRoll'=> $cartdata->LabelsPerRoll,
                'orignalQty'=>$orignalQty,
                'is_custom'=> $cartdata->is_custom,
                'Price' => $ExVat,
                'ProductTotalVAT' => $ExVat,
                'ProductTotal' => $IncVat,
                'Printing'=> $cartdata->Printing,
                'Print_Type'=> $print_type,
                'Print_Design'=> $cartdata->Print_Design,
                'Print_Qty'=> $cartdata->Print_Qty,
                'Free'=> $cartdata->Free,
                'Print_UnitPrice'=> $cartdata->Print_UnitPrice,
                'Print_Total'=> $cartdata->Print_Total,
                'colorcode'=> $cartdata->colorcode,
                'active'=>'N',


                'wound'=>$cartdata->wound,
                'Orientation'=>$cartdata->orientation,
                'pressproof'=>$cartdata->pressproof,
                'FinishType'=>$cartdata->FinishType,
                'Product_detail'=>$cartdata->Product_detail,
                'design_service'=>$cartdata->design_service,
                'design_service_charge'=>$cartdata->design_service_charge,
                'design_file'=>$cartdata->design_file,
                'regmark'=>$cartdata->regmark,
                'sample'=>$cartdata->OrderData,
                'custom_roll_and_label' => $cartdata->custom_roll_and_label,
                'FinishTypePrintedLabels' => $cartdata->FinishTypePrintedLabels,
                'FinishTypePricePrintedLabels' => $cartdata->FinishTypePricePrintedLabels,
                'sequential_and_variable_data' => $cartdata->sequential_and_variable_data,
                'total_emb_cost' => $cartdata->total_emb_cost
            );



            $this->db->insert('quotationdetails', $QDetail);
            $quote_serail = $this->db->insert_id();

			$this->home_model->save_logs('save_quotationdetail',$QDetail);  //SAVE LOG

            if($p_code=="SCO1"){
                $this->db->where('CartID',$cartdata->ID);
                $this->db->update('flexible_dies_info',array('QID'=>$quote_serail));
                //$this->customdie_alert($QuotationNo);
            }


            if(preg_match('/Integrated Labels/is',$cartdata->ProductBrand) || $cartdata->Printing=='Y'){
                if($cartdata->OrderData=='Black' || $cartdata->OrderData=='Printed' || $cartdata->Printing=='Y'){

                    $query = $this->db->query("select count(*) as total from integrated_attachments 
								WHERE ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."' AND status LIKE 'confirm' ");
                    $query = $query->row_array();
                    if($query['total'] > 0){
                        $attach_q = $this->db->query("select * from integrated_attachments WHERE 
									ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."' 
									AND status LIKE 'confirm' ");

                        $attach_q = $attach_q->result();

                        foreach($attach_q  as $int_row){

                            $attach_array = array(
                                'UserID'=>$params['UserID'],
                                'QuotationNumber'=>$params['QuotationNumber'],
                                'Serial'=>$quote_serail,
                                'ProductID'=>$int_row->ProductID,
                                'file'=>$int_row->file,
                                'diecode'=>$p_code,
                                'status'=>55,
                                'source'=>$int_row->source,
                                'design_type'=>$cartdata->Print_Type,
                                'qty'=>$int_row->qty,
                                'labels'=>$int_row->labels,
                                'name'=>$int_row->name);

                            $this->db->insert('quotation_attachments_integrated',$attach_array);
														$this->home_model->save_logs('save_quote_attachment',$attach_array);  //SAVE LOG
							

                        }
                    }
                }
            }


           if($p_code=="SCO1"){


                $this->db->where('CartID',$cartdata->ID);
                $this->db->update('flexible_dies_info',array('QID'=>$quote_serail));
                $flexDetail = $this->db->query("select * from flexible_dies_info where QID = '".$quote_serail."'")->row_array();
                //print_r($flexDetail);exit;
				
				
				$pName ='<b>Format:</b> '.$flexDetail['format'].'&nbsp;|&nbsp;'.
						'<b>Shape:</b> '.$flexDetail['shape'] .'&nbsp;|&nbsp;'.
						'<b>Width:</b> '.$flexDetail['width'].'mm'.'&nbsp;|&nbsp;';
				
				if($flexDetail['shape']!="Circle"){
					$flexDetail['height'] = ($flexDetail['height']!=null)?($flexDetail['height']):($flexDetail['width']);
					$pName .='<b>Height:</b> '.$flexDetail['height'].'mm'.'&nbsp;|&nbsp;';
     			 } 
				
				
				$pName .='<b>Size:</b> '.$flexDetail['width'].'mm '.'x '.$flexDetail['height'].'mm'.'&nbsp;|&nbsp;'.
						 '<b>Across:</b> '.$flexDetail['across'].'&nbsp;|&nbsp;';
				

				if($flexDetail['labels']){
						$pName .='<b>No.labels/Die:</b> '.$flexDetail['labels'].'&nbsp;|&nbsp;';
				}
				
				if($flexDetail['around']){
						$pName .='<b>Around:</b> '.$flexDetail['around'].'&nbsp;|&nbsp;';
				}
				
				 if(($flexDetail['shape'] != 'Circle') && ($flexDetail['shape'] !='Oval')){
					 $pName.='<b>Corner radius:</b> '.$flexDetail['cornerradius'].'mm'.'&nbsp;|&nbsp;';
				 }
				
				if($flexDetail['format']=="Roll"){
						 $pName.='<b>Leading Edge:</b> '.$flexDetail['width'].'mm'.'&nbsp;|&nbsp;';
       			}
				
				$pName .='<b>Perforation:</b> '.$flexDetail['perforation'];
				
				

                $dieDetail['ProductName'] = $pName;
				
				
				
                $dieDetail['die_approve'] = $this->checkPrice($quote_serail);
                $dieDetail['discount'] = $flexDetail['discount'];
                $dieDetail['discount_val'] = $flexDetail['discount_val'];
                $dieDetail['temp_dis'] = $flexDetail['temp_dis'];

                $this->db->where('SerialNumber',$quote_serail);
                $this->db->update('quotationdetails',$dieDetail);

            }


        }
        $params['serialNumber'] = $quote_serail;
        $params['res'] = true;
        return $params;
    }
    public function getQuoteNum() {

        $this->db->select_max('QuotationID');
        $highValue = $this->db->get('quotations')->result();
        $highestValue = $highValue[0]->QuotationID;
        if ($highestValue) {
            $highestValue++;
            $newEntry = array('Quotation' => $highestValue);
            //$this->db->insert('customlabelsnumber', $newEntry);
        }
        return $newEntry['Quotation'];
    }
    public function getCustomer($customerId){
        return  $this->db->select("*")
            ->from('customers')
            ->where('UserID',$customerId)
            ->get()->row();
    }
    public function getVatNumber($billing_postcode,$delivery_postcode,$dcountry){
        $vat_exempt ="no";
        $VALIDVAT =  $this->session->userdata('vat_exemption');
        if(isset($VALIDVAT) and $VALIDVAT=='yes' and $dcountry!='United Kingdom'){
            $vatnumber = $this->input->post('vatnumber');
            $vat_exempt ='yes';
        }
        else if($billing_postcode==$delivery_postcode and (strtoupper($delivery_postcode)=='JE' || strtoupper($delivery_postcode)=='GY')){
            $vat_exempt ='yes';
        }
        $this->session->unset_userdata(array('vat_exemption'=>''));
        return ($vat_exempt == 'yes')?$vat_exempt:'no';
    }
    public function getTotalCounts(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
        
        $qry = $this->db->query("SELECT sum(Quantity * LabelsPerRoll) as labels FROM temporaryshoppingbasket  WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' )  ");
        $res  = $qry->result();
        return  $res;
    }
    function get_exchange_rate($code){

        $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['rate'];
    }

    public function getCartTotalPrice(){
        $this->load->model('cart/cartModal');

        return $this->cartModal->getCarTotalPrice();
    }

    public function deleteCart(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';

        $cookie = stripslashes($cookie);

        $cookie = @unserialize($cookie);

        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');
        $where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";

        $this->db->where($where);

        $this->db->delete('temporaryshoppingbasket');
        return true;
    }
    public function getCartOrders(){
        $this->load->model('cart/cartModal');

        return $this->cartModal->getCartOrders();
    }
    function customize_product_name($custom,$ProductCategoryName,$LabelsPerRoll,$LabelsPerSheet,$ReOrderCode,$manuid,$ProductBrand,$wound=NULL, $printed=NULL)
    {

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
    public function checkPrice_old($serial){
        $flxDieInfo = $this->db->query("select ID,CartID from flexible_dies_info where QID = '".$serial."'")->row_array();
        $tempShoping = $this->db->query("select * from temporaryshoppingbasket where ID = '".$flxDieInfo['CartID']."'")->row_array();
        $this->db->insert('flexible_pricing',array('serial'=>$serial,'Operator'=>616100,'supplier'=>'custom_die','price'=>$tempShoping['TotalPrice'],'sprice'=>$tempShoping['TotalPrice'],'status'=>'1'));
        $flxDieMats = $this->db->query("select * from flexible_dies_mat where OID = '".$flxDieInfo['ID']."'")->result_array();
        //print_r($tempShoping['UnitPrice']);exit;
        if($tempShoping['UnitPrice'] > 0){
            if(!empty($flxDieMats)){
                foreach ($flxDieMats as $mat){
                    // print_r($mat['plainprice']);exit;
                    if(($mat['plainprice'] <= 0) && ($mat['printprice'] <= 0)){
                        return "N";
                    }
                }
            }

            return 'N';
        }
        return 'N';

    }
    
    public function checkPrice($serial){
        $flxDieInfo = $this->db->query("select ID,CartID,shape,perforation,format from flexible_dies_info where QID = '".$serial."'")->row_array();
        $tempShoping = $this->db->query("select * from temporaryshoppingbasket where ID = '".$flxDieInfo['CartID']."'")->row_array();
        $this->db->insert('flexible_pricing',array('serial'=>$serial,'Operator'=>616100,'supplier'=>'custom_die','price'=>$tempShoping['TotalPrice'],'sprice'=>$tempShoping['TotalPrice'],'status'=>'1'));
        // $flxDieMats = $this->db->query("select * from flexible_dies_mat where OID = '".$flxDieInfo['ID']."'")->result_array();
        //print_r($tempShoping['UnitPrice']);exit;
        
        $flxDieMats = $this->db->query("SELECT COUNT(ID) as count FROM flexible_dies_mat WHERE plainprice =0 and OID = '".$flxDieInfo['ID']."'")->result();
        
        $materials = $this->db->query("SELECT COUNT(ID) as material FROM flexible_dies_mat WHERE OID = '".$flxDieInfo['ID']."'")->result();
        
        
        if($flxDieInfo['shape'] !='Irregular' &&  $flxDieInfo['perforation'] !="2mm Cut 1mm Tie" && $flxDieInfo['format'] !='A3' && $flxDieInfo['format'] !='SRA3'){ 
            if($materials[0]->material >0){
                if(($flxDieMats[0]->count >0))
                {
                         return 'N';
                }
                else{
                        return 'Y';
                    }
                }

            else{
                if($tempShoping['TotalPrice'] >0){
                    return 'Y';
                }else{
                    return 'N';
                }

            }
        }else{
            return 'N';
         }

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

    public function getQuotation($quotationNumber){
        $results = $this->db->select("q.*,st.StatusTitle as status")
            ->select("FROM_UNIXTIME(q.QuotationTime, '%h : %i %p') as time")
            ->select("FROM_UNIXTIME(q.QuotationTime, '%d/%m/%Y') as date")
            ->from('quotations as q')
            ->join('dropshipstatusmanager as st','q.QuotationStatus = st.StatusID','left')
            ->where('q.QuotationNumber',$quotationNumber)
            ->get()->result();
        return $results;
    }
    /*public function getQuotationDetail($quotationNumber){
        $results = $this->db->select("qd.*,p.ProductName as pn,p.ProductBrand,p.LabelsPerSheet,p.ProductCategoryName")
            ->from('quotationdetails as qd')
            ->join('products as p', 'qd.ProductID = p.ProductID','left')
            ->where(array('qd.QuotationNumber'=>$quotationNumber,'qd.sample!='=>'Sample'))
            ->get()->result();
        return $results;
    }*/
  
  
  
    public function getQuotationDetailForOrder($quotationNumber){
        $results = $this->db->select("qd.*,p.ProductName as pn,p.ProductBrand,p.LabelsPerSheet")
            ->from('quotationdetails as qd')
            ->join('products as p', 'qd.ProductID = p.ProductID','left')
            ->where('qd.QuotationNumber',$quotationNumber)
            ->where('qd.active','Y')
            ->get()->result(); 
			//echo $this->db->last_query();exit;
        return $results;
    }

   
  
 public function updateCategory(){
		
		$serialNo = $this->input->post('serialNumber');
		$getQuote = $this->getQuotationDetailBySerialNumber($serialNo);
		$get_quote_detail = $this->getQuotationDetailforChng($serialNo);
		//print_r($get_quote_detail); exit;
		
	
		 $desc = $get_quote_detail[0]->ProductCategoryName;
    
		if($this->input->post('val')=='N'){
			
			$param = array('Printing'=>$this->input->post('val'),'Print_Type'=>'','Print_Design'=>'','Print_Qty'=>'','wound'=>'','FinishType'=>'','Orientation'=>'','ProductName'=>$get_quote_detail[0]->ProductName);

			if($serialNo!="" && $serialNo!=0){


			$this->db->where(array('Serial'=>$serialNo));
			$this->db->delete('quotation_attachments_integrated');
            }

		}else{
			$param = array('Printing'=>$this->input->post('val'),'Print_Type'=>'','Print_Design'=>'','Print_Qty'=>'','wound'=>'','FinishType'=>'','Orientation'=>'','ProductName'=>$desc);
		}
		
		
		if($serialNo){
			$this->db->where('SerialNumber',$serialNo);
			$this->db->update('quotationdetails',$param);
		}
		return true;
    }
    
    public function getQuotationDetailBySerialNumber($serila){
        $results = $this->db->select("qd.*")
            ->from('quotationdetails as qd')
            ->where('qd.SerialNumber',$serila)
            ->get()->result();
        return $results;
    }

    public function updateQuotationDetail(){
       if($this->input->post('brand') == 'Integrated Labels'){
            $quotation = $this->getQuotationDetailBySerialNumber($_POST['serialNumber']);
            $originalQty = $quotation[0]->orignalQty;
            $lb_rol = $_POST['LabelsPerSheet'];
        }else{
           
           if($this->input->post('brand') == 'Roll Labels'){
             $originalQty = ($_POST['qty'] * $_POST['labelperRoll']);
             $lb_rol = $_POST['labels'] / $_POST['qty'];   
           
          }else{
            $originalQty = ($_POST['qty'] * $_POST['LabelsPerSheet']);
            $lb_rol = $_POST['LabelsPerSheet'];
         }
      }
        
        


        if($_POST['printing'] == 'Y'){

            if($_POST['regmark'] == 'Y'){
                $param = array(
                    'Quantity'=>$_POST['qty'],
                    'orignalQty'=>$originalQty,
                    'LabelsPerRoll'=>$_POST['labels'] / $_POST['qty'] ,
                );
            }else{
                $param = array(
                    'Quantity'=>$_POST['qty'],
                    'orignalQty'=>$originalQty,
                    'Print_Type'=>$_POST['digital'],
                    'pressproof'=>$_POST['pressProff'],
                    'Print_Design'=>($_POST['design'] >1)?'Multiple Designs':'1 Designs',
                    'Print_Qty'=>(isset($_POST['design']))?$_POST['design']:'',
                    'wound'=>(isset($_POST['wound']))?$_POST['wound']:'',
                    'FinishType'=>(isset($_POST['finish']))?$_POST['finish']:'',
                    'Orientation'=>(isset($_POST['Orientation']))?$_POST['Orientation']:'',
                     'LabelsPerRoll'=> $lb_rol,
                );
            }


        }else{

            $param = array(
                'Quantity'=>$_POST['qty'],
                'orignalQty'=>$originalQty,
                'LabelsPerRoll'=>$_POST['labels'] / $_POST['qty'],
            );
        }


       $this->db->where('serialNumber',$_POST['serialNumber']);
       $this->db->update('quotationdetails',$param);
	     //$this->home_model->save_logs('update_quotation',$param);  //SAVE LOG
		
       return true;
    }

    public function getShipingServiceName($serviceID){
        $sql = $this->db->query("select * from shippingservices where ServiceID='".$serviceID."'");
        $service = $sql->row_array();

        return $service;
    }
    public function getShipingService($conID){
        $sql = $this->db->query("select * from shippingservices where CountryID='".$conID."' order by ServiceID ASc ");
        $service = $sql->result_array();

        return $service;
    }

    function is_quotation_integrated($quoteNo){
        $result = $this->db->query("select COUNT(*) as total from quotationdetails temp JOIN products pro on temp.ProductID = pro.ProductID WHERE temp.QuotationNumber LIKE '".$quoteNo."' AND pro.ProductBrand = 'Integrated Labels'");
        $row = $result->row_array();
        return $row['total'];
    }
    function delivery_quotation_integrated($quoteNo){
        $intdata= "";
        $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `quotationdetails` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and QuotationNumber LIKE '".$quoteNo."' ")->row_array();

        $country_code = $this->get_db_column('quotations','DeliveryCountry', 'QuotationNumber', $quoteNo);
        $dpd = $this->get_integrated_delivery($int_sheets['qty'],$country_code);
        $dpd = $dpd['dpd'];
        $productid = $int_sheets['ProductID'];
        $intdata['BasicCharges'] += $dpd;
        if($int_sheets['qty'] == '' || $int_sheets['ProductID'] == ''){
            $intdata['BasicCharges'] -= $dpd;
        }

        $delivery_exvat  = $delivery_exvat  + $intdata['BasicCharges'];
        $delivery_incvat = $delivery_exvat*1.2;
        return $delivery_incvat;
    }
    function get_db_column($table, $column, $key, $value){
        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '".$value."' LIMIT 1 ")->row_array();
        return (isset($row[$column]) and $row[$column]!='')?$row[$column]:'';
    }
    function get_integrated_delivery($qty,$country = '')
    {
        $prices = array();
        $prices['dpd'] = '';
        $prices['batch_qty'] = '';
        $prices['pallets'] = '';
        if($country == 'United Kingdon'){
            $qry = "SELECT * FROM integrated_labels_delivery Order By batch_qty ASC";
            $query = $this->db->query($qry);
            $result = $query->result_array();
            foreach($result as $key => $row){
                if($qty<=4000){
                    $prices = $result[0];
                }
                else if($qty == $row['batch_qty']){
                    $prices = $result[$key];
                }
                else if(($qty > $row['batch_qty'] and isset($result[$key+1]['batch_qty']) and $qty < $result[$key+1]['batch_qty'])){
                    $prices = $result[$key+1];
                }
                else if($qty>100000){
                    $prices = end($result);
                }
            }
        }else{
            $box = ceil($qty/1000);
            $prices = $this->integrated_delivery_offshore($box,$country);
            if($prices['dpd'] == 0){
                $prices = $this->get_integrated_delivery($qty,'United Kingdon');
            }
        }
        return $prices;
    }
    function integrated_delivery_offshore($box,$country){
        $sql = "Select * From integrated_delivery_offshore Where country LIKE '$country'";
        $result = $this->db->query($sql)->result_array();
        $min_qty = $result[0]['box'];
        $max_qty = end($result);
        $max_qty = $max_qty['box'];

        foreach($result as $key => $row){
            if($box<=$min_qty){
                $prices = $result[0];
            }
            else if($box == $row['box']){
                $prices = $result[$key];
            }
            else if(($box > $row['box'] and isset($result[$key+1]['box']) and $box < $result[$key+1]['box'])){
                $prices = $result[$key+1];
            }
            else if($box>$max_qty){
                $prices = end($result);
            }
        }

        $prices['dpd'] = $box * $prices['perbox'];
        if($box < 50 and ($prices['dpd'] > $prices['half_pallet']))
        {
            $prices['dpd'] = $prices['half_pallet'];
        }
        if($box >= 50 and ($prices['dpd'] > $prices['full_pallet']))
        {
            $prices['dpd'] = $prices['full_pallet'];
        }
        return $prices;
    }
    public function quoteDetails($quoteID) {

        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }

        //$query = $this->db->get_where('quotationdetails', array('QuotationNumber' => $quoteID));
      
      $this->db->select('q.*,p.ProductBrand');
      $this->db->from('quotationdetails as q');
      $this->db->join('products as p','p.ProductID=q.ProductID');
      //$this->db->where(array('QuotationNumber' => $quoteID));
      $this->db->where(array('QuotationNumber'=>$quoteID));
      $query = $this->db->get();
      
       return $query->result();
    }

    public function statusdropdown($id)
    {
        if($id==37){
            $in_array = "37,39,17,23,56,62";
        }else if($id==10){

            $in_array = "10,34";
        }else{
            $in_array = "37,39,17,23,56,62,8";
        }
        $row = $this->statusdropdowna($in_array);

        foreach ($row  as $row){

            $option[$row->StatusID] = $row->StatusTitle;
        }
        return $option;
    }
    public function statusdropdowna($in_array)
    {
        $query ="select * from dropshipstatusmanager where StatusID IN ($in_array) order by SortID asc";
        $row =$this->db->query($query);
        return $row->result();

    }
    public function changestatus($id,$update){


        $this->db->where('QuotationID',$id);
        $this->db->update('quotations',$update);

    }
    public function quoteDetails111($quoteID) {

        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }

        $query = $this->db->get_where('quotationdetails', array('QuotationNumber' => $quoteID,'active'=>"Y"));
        return $query->result();
    }

    public function quoteDetailsRecord($quoteID) {

        $query = $this->db->get_where('quotationdetails', array('QuotationNumber' => $quoteID,'active'=>"Y"));
        return $query->result_array();
    }

    public function quoteInfo($quoteID) {
        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }
        $query = $this->db->get_where('quotations', array('QuotationNumber' => $quoteID));
        return $query->result();
    }
    function get_currecy_symbol($code){
        $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['symbol'];
    }
    public function manufactureid($domain,$id)
    {
        if($domain=='123'){$ManufactureID='123ManufactureID';}else{$ManufactureID='ManufactureID';}
        $this->db->select($ManufactureID);
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->$ManufactureID;
    }
    public function LabelsPerSheet($id){
        $this->db->select('LabelsPerSheet');
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->LabelsPerSheet;
    }
    function calculate_total_printed_labels($serial){

        $query = $this->db->query(" SELECT SUM(labels) AS total from quotation_attachments_integrated WHERE Serial LIKE '".$serial."'  ");
        $row = $query->row_array();
        return $row['total'];
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

    public function getproductdetail($id){



        $query = $this->db->select('*')

            ->where('ProductID',$id)

            ->get('products');



        return $query->row_array();

    }
    public function fetch_custom_die_quote($id){
        $query = $this->db->query("SELECT * from flexible_dies_info WHERE QID = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    function get_details_roll_quotation($id){
        $query = $this->db->query("SELECT * from roll_print_basket WHERE SerialNumber = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    function check_wtp_quotation_offer_voucher($quotenumber){



        $query = $this->db->query(" SELECT count(quotationdetails.ProductID) AS total from products INNER JOIN quotationdetails ON 
										products.ProductID=quotationdetails.ProductID WHERE products.ManufactureID LIKE '%WTP' AND
										QuotationNumber LIKE '".$quotenumber."'  AND quotationdetails.Quantity >= 10000 
										AND quotationdetails.active LIKE 'Y'
										AND  (ProductBrand NOT LIKE 'Roll Labels' AND ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label' AND ProductBrand NOT LIKE 'Integrated Labels')");
        $row = $query->row_array();

        if(isset($row['total']) and $row['total'] > 0){
            return true;
        }else{
            $session_id = $this->session->userdata('session_id');
            $update = $this->db->delete('voucherofferd_temp',array('SessionID' => $session_id));
            return false;
        }
    }
    function check_wtp_voucher_applied_quotation($QuoteNumber,$newGrandTotal){
        $session_id = $this->session->userdata('session_id');
        $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
        $res   = $qry->row_array();
        if($res){
            if($res['grandtotal']!=$newGrandTotal){

                $amount = $this->calculate_quotation_total_wtp_amount($QuoteNumber);
                $this->update_wtp_discount_voucher($amount);

            }
            $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
            $res   = $qry->row_array();
        }

        return $res;
    }
    function calculate_quotation_total_wtp_amount($quotenumber){

        $query = $this->db->query(" SELECT SUM(quotationdetails.Price) AS total from products INNER JOIN quotationdetails ON 
										products.ProductID=quotationdetails.ProductID WHERE products.ManufactureID LIKE '%WTP' AND
										QuotationNumber LIKE '".$quotenumber."'  AND quotationdetails.Quantity >= 10000 
										AND quotationdetails.active LIKE 'Y' AND  (ProductBrand NOT LIKE 'Roll Labels' 
										AND ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label')");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total']!=''){
            return $row['total']*1.2;
        }else{
            return 0.00;
        }
    }
    function update_wtp_discount_voucher($GrandTotal){

        $discout_perct =  number_format(15/100,2);
        $DsountOff = $GrandTotal * $discout_perct;
        $session_id = $this->session->userdata('session_id');
        $data = array(
            'discount_offer' => $DsountOff,
            'grandtotal' => $GrandTotal,
        );
        $update = $this->db->update('voucherofferd_temp', $data, array('SessionID' => $session_id));
    }
    function calculate_total_printedroll_amount($quotenumber){
        return false;
        $query = $this->db->query(" SELECT SUM(quotationdetails.Price) AS total from products INNER JOIN quotationdetails ON 
									products.ProductID=quotationdetails.ProductID WHERE 
									QuotationNumber LIKE '".$quotenumber."'  AND quotationdetails.Printing LIKE 'Y' 
									AND  (ProductBrand LIKE 'Roll Labels')");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total']!=''){
            return ($row['total']*1.2) * 0.1;

        }else{
            return false;
        }
    }

    function get_printed_files($serial){
        $q = $this->db->query(" select * from quotation_attachments_integrated  WHERE Serial LIKE '".$serial."'  ");
        return $q->result();
    }

    public function deletequoteitem($id){
        $quoteNo = $this->db->select('QuotationNumber')->get_where('quotationdetails', array('SerialNumber' => $id));
        $quoteNo = $quoteNo->result();
        $quoteNo = $quoteNo[0]->QuotationNumber;

        $this->db->where('SerialNumber',$id);
        $this->db->delete('quotationdetails');

        $quotetotal = $this->db->select_sum('ProductTotal')->get_where('quotationdetails', array('QuotationNumber' => $quoteNo));
        $quotetotal = $quotetotal->result();
        $quotetotal = $quotetotal[0]->ProductTotal;
        $shiptotal =$this->db->select('QuotationShippingAmount')->get_where('quotations', array('QuotationNumber' => $quoteNo));
        $shiptotal = $shiptotal->result();
        $shiptotal = $shiptotal[0]->QuotationShippingAmount;
        $quotetotal_amount = number_format($quotetotal + $shiptotal,'2','.','');
        $update =  array('QuotationTotal' =>$quotetotal_amount);
        $this->db->where('QuotationNumber',$quoteNo);
        $this->db->update('quotations',$update);

    }
    function Deletroll_print_quote($id){

        $query = $this->db->query("DELETE  from roll_print_basket WHERE SerialNumber = '$id' ");
    }


    function wtp_discount_applied_on_order(){
        $session_id = $this->session->userdata('session_id');
        $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
        $res   = $qry->row_array();
        return $res;
    }



    function last_order($userId){
        $qry = $this->db->query("SELECT `OrderNumber` FROM `orders` WHERE `UserID` = '".$userId."' ORDER BY `OrderDate` DESC ");
        $res = $qry->row_array();
        return $res;
    }
    function is_backoffice_product($productid){
        $row = $this->db->query("SELECT displayin FROM  `products` WHERE  ProductID LIKE '".$productid."' ")->row_array();
        return (isset($row['displayin']) and $row['displayin']=='backoffice')?1:0;
    }

    public function saveorder($quoteID,$paymentmethod)
    {
		
		$totally = 0;
        $order_detail = $this->quoteDetails111($quoteID);
       
        $order = $this->quoteInfo($quoteID);
		
		
        $OrdWebsite = $this->input->post('QuoteWebsite');
        $OrdWebsite = ($OrdWebsite == null)?'backoffice':$this->input->post('QuoteWebsite');

        $OrdNo = $this->user_model->getOrderNum();

        if($OrdWebsite=='123')
        {
            $orderNo = '123-'.$OrdNo;
        }
        else
        {
            $orderNo = 'AA'.$OrdNo;
        }


        $this->session->set_userdata("OrderNo",$orderNo);

        if($order[0]->BillingMobile==NULL){$order[0]->BillingMobile='';}
        if($order[0]->Billingtelephone==NULL){$order[0]->Billingtelephone='';}
        if($order[0]->Billingfax==NULL){$order[0]->Billingfax='';}
        if($order[0]->Billingemail==NULL){$order[0]->Billingemail='';}
        if($order[0]->Deliverytelephone==NULL){$order[0]->Deliverytelephone='';}
        if($order[0]->DeliveryMobile==NULL){$order[0]->DeliveryMobile='';}
        if($order[0]->Deliveryfax==NULL){$order[0]->Deliveryfax='';}
        if($order[0]->Deliveryemail==NULL){$order[0]->Deliveryemail='';}
        if($order[0]->BillingAddress2==NULL){$order[0]->BillingAddress2='';}
        if($order[0]->DeliveryAddress2==NULL){$order[0]->DeliveryAddress2='';}


           $discount_offer = 0.00;
           $voucherOfferd = 'No';
           $Ordtotal = $order[0]->QuotationTotal;
      

        $lastorder = $this->last_order($order[0]->UserID);
        $lastorder = (isset($lastorder) && $lastorder['OrderNumber']!='')?$lastorder['OrderNumber']:'FIRST';

        
        $order[0]->Q2OStatus = 6;

        $insert = array(
            'OrderNumber'   => $orderNo,
            'SessionID'     =>$this->session->userdata('session_id'),
            'OrderDate'     =>  time(),
            'OrderTime'     =>  time(),
            'UserID'        =>  $order[0]->UserID,
            'OrderDeliveryCourier'     =>  $order[0]->quotationCourier,
            'OrderDeliveryCourierCustomer'     =>  $order[0]->quotationCourierCustomer,
            'DeliveryStatus' =>'',
            'PaymentMethods'    =>$paymentmethod,
            'OrderShippingAmount' =>$order[0]->QuotationShippingAmount,
            'OrderTotal'          => number_format($Ordtotal - $order[0]->QuotationShippingAmount,2,'.',''),
            'BillingTitle'        =>$order[0]->BillingTitle,
            'BillingFirstName'    =>$order[0]->BillingFirstName,
            'BillingLastName'     =>$order[0]->BillingLastName,
            'BillingCompanyName'  =>$order[0]->BillingCompanyName,
            'BillingAddress1'     =>$order[0]->BillingAddress1,
            'BillingAddress2'     =>$order[0]->BillingAddress2,
            'BillingTownCity'     =>$order[0]->BillingTownCity,
            'BillingCountyState'  =>$order[0]->BillingCountyState,
            'BillingPostcode'    =>$order[0]->BillingPostcode,
            'BillingCountry'     =>$order[0]->BillingCountry,
            'Billingtelephone'   =>$order[0]->Billingtelephone,
            'Billingmobile'      =>$order[0]->BillingMobile,
            'Billingfax'         =>$order[0]->Billingfax,
            'SecondaryEmail'     =>$order[0]->SecondaryEmail,
            'Billingemail'       =>$order[0]->Billingemail,
            'BillingResCom'		=>$order[0]->BillingResCom,
            'DeliveryTitle'      =>$order[0]->DeliveryTitle,
            'DeliveryFirstName'      =>$order[0]->DeliveryFirstName,
            'DeliveryLastName'       =>$order[0]->DeliveryLastName,
            'DeliveryCompanyName'    =>$order[0]->DeliveryCompanyName,
            'DeliveryAddress1'           =>$order[0]->DeliveryAddress1,
            'DeliveryAddress2'   	  =>$order[0]->DeliveryAddress2,
            'DeliveryTownCity'    =>$order[0]->DeliveryTownCity,
            'DeliveryCountyState'    =>$order[0]->DeliveryCountyState,
            'DeliveryPostcode'          =>$order[0]->DeliveryPostcode,
            'DeliveryCountry'   	 =>$order[0]->DeliveryCountry,
            'Deliverytelephone'   	 =>$order[0]->Deliverytelephone,
            'DeliveryMobile'   	  =>$order[0]->DeliveryMobile,
            'Deliveryfax'   	=>$order[0]->Deliveryfax,
            'Deliveryemail'   	=>$order[0]->Deliveryemail,
            'DeliveryResCom'	=>$order[0]->DeliveryResCom,
            'Registered'        =>'Yes',
            'CustomOrder'        =>$order[0]->CustomOrder,
            'ShippingServiceID'  =>$order[0]->ShippingServiceID,
            'printPicked'        =>'No',
            'PurchaseOrderNumber'   =>'',
            'YourRef'        =>'',
            'PackID'         =>'',
            'Source'         =>'Q-'.$this->session->userdata('UserName'),
            'Domain'         =>$OrdWebsite,
            'vat_exempt'	 =>$order[0]->vat_exempt,
            'currency'	     =>$order[0]->currency,
            'exchange_rate'	 =>$order[0]->exchange_rate,
            'ContactPerson'  =>$order[0]->UserID,
            'OrderStatus'    =>$order[0]->Q2OStatus,
            'Label'    =>$order[0]->Label,
            'site'    =>$order[0]->site,
            'voucherOfferd'  => $voucherOfferd,
            'voucherDiscount'=>$discount_offer,);
		
			$this->db->insert('orders',$insert);
			
			//$this->orderModal->order_confirmation_new($OrderNo);
			$this->home_model->save_logs('quote_to_order',$insert);  //SAVE LOG
		
     
         //$totally = 0;
      
		
        foreach($order_detail as $order_detail){
            $cuspriceexvat = 0;
            $sno = $order_detail->SerialNumber;
            $Print_Type = $order_detail->Print_Type;

            $prodinfo = $this->getproductdetail($order_detail->ProductID);
            if(preg_match('/Integrated Labels/',$prodinfo['ProductBrand'])){
                $extra_int_text = ($order_detail->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)";
                $order_detail->ProductName.= $extra_int_text;
            }



            $insert_detail= array(
                'OrderNumber'   	 =>$orderNo,
                'UserID'   	 =>$order_detail->CustomerID,
                'labels' => $order_detail->orignalQty,
                'ProductID'   	 =>$order_detail->ProductID,
                'ManufactureID'  => $order_detail->ManufactureID,
                'ProductName'   	 =>$order_detail->ProductName,
                'Quantity'   	 =>$order_detail->Quantity,
                'LabelsPerRoll'=> $order_detail->LabelsPerRoll,
                'is_custom'=> $order_detail->is_custom,
                'Price'   	 =>$order_detail->Price,
                'ProductTotalVAT' =>$order_detail->ProductTotalVAT,
                'ProductTotal'   	=>$order_detail->ProductTotal,
                'Printing'=> $order_detail->Printing,
                'Print_Type'=> $Print_Type,
                'Print_Design'=> $order_detail->Print_Design,
                'Print_Qty'=> $order_detail->Print_Qty,
                'Free'=> $order_detail->Free,
                'Print_UnitPrice'=> $order_detail->Print_UnitPrice,
                'Print_Total'=> $order_detail->Print_Total,
                'Prl_id'=>$order_detail->Prl_id,
                'old_product'=>$this->is_backoffice_product($order_detail->ProductID),
                'colorcode'=>$order_detail->colorcode,

                'Wound'=>$order_detail->wound,
                'Orientation'=>$order_detail->Orientation,
                'pressproof'=>$order_detail->pressproof,
                'FinishType'=>$order_detail->FinishType,
                'Product_detail'=>$order_detail->Product_detail,
                'design_service'=>$order_detail->design_service,
                'design_service_charge'=>$order_detail->design_service_charge,
                'design_file'=>$order_detail->design_file,
                'regmark'=>$order_detail->regmark,
                'sample'=>$order_detail->sample,
              
                'odp_proof'=>$order_detail->qp_proof,
                'odp_qty'=>$order_detail->qp_qty,
                'odp_price'=>$order_detail->qp_price,
                'odp_foc'=>$order_detail->qp_foc,
                'custom_roll_and_label' => $order_detail->custom_roll_and_label,
                'FinishTypePrintedLabels' => $order_detail->FinishTypePrintedLabels,
                'FinishTypePricePrintedLabels' => $order_detail->FinishTypePricePrintedLabels,
                'sequential_and_variable_data' => $order_detail->sequential_and_variable_data,
                'total_emb_cost' => $order_detail->total_emb_cost

            );

               if($order_detail->ManufactureID=='AADS001'){
                 $insert_detail = array_merge($insert_detail, array('ProductionStatus'=>3,'ProductOption'=>$order_serail));
               }else if($order_detail->ManufactureID=='SCO1'){
                 $insert_detail = array_merge($insert_detail, array('machine'=>'die'));
               }

            $this->db->insert('orderdetails',$insert_detail);
		    $order_serail = $this->db->insert_id();
		    $this->home_model->save_logs('quote_to_orderdetail',$insert_detail);  //SAVE LOG


            //******___________*********
            $cuspriceincvat = 0;
            if($order_detail->ManufactureID == 'SCO1'){
                $custom_die = array(
                    'OrderNumber'=>$orderNo,
                    'SerialNumber'=>$order_serail,
                    'diecode'=>$order_detail->ManufactureID,
                    'Time'=>time(),
                    'Status'=>37,
                    'SA'=>0,'CA'=>0,'OD'=>0,'S_SA'=>0,'OL'=>0,'version'=>1,'type'=>'custom'
                );
                $this->db->insert('flexible_dies',$custom_die);

                $this->db->where('QID',$order_detail->SerialNumber);
                $this->db->update('flexible_dies_info',array('OID'=>$order_serail));


                $custominfo = $this->fetch_custom_die_order($order_serail);
                $cuspriceexvat = $this->calculateamountmaterils($custominfo['ID']);
                

            }
            //******___________*********

            if( $order_detail->Printing=='Y' && $order_detail->regmark !='Y'){
                $artowrks = $this->get_printed_files($order_detail->SerialNumber);
                if(count($artowrks) > 0){
                    foreach($artowrks  as $int_row){
                        $brand = $this->is_ProductBrand_roll($order_detail->ManufactureID);
                        $brand = $this->make_productBrand_condtion($brand['ProductBrand']);

                        $attach_array = array(
                            'UserID'=>$order_detail->CustomerID,
                            'OrderNumber'=>$orderNo,
                            'Serial'=>$order_serail,
                            'ProductID'=>$order_detail->ProductID,
                            'diecode'=>$order_detail->ManufactureID,
                            'file'=>$int_row->file,
                            'status'=>64,
                            'Brand'=>$brand,
                            'source'=>$int_row->source,
                            'design_type'=>$int_row->design_type,
                            'qty'=>$int_row->qty,
                            'labels'=>$int_row->labels,
                            'name'=>$int_row->name,
                            'CO' =>1,
                            'version' =>1);
                        $this->db->insert('order_attachments_integrated',$attach_array);
                    }
                }
            }elseif($order_detail->regmark =='Y'){



                        $brand = $this->is_ProductBrand_roll($order_detail->ManufactureID);
                        $brand = $this->make_productBrand_condtion($brand['ProductBrand']);

                        $attach_array = array('OrderNumber'=>$orderNo,
                            'Serial'=>$order_serail,
                            'ProductID'=>$order_detail->ProductID,
                            'diecode'=>$order_detail->ManufactureID,
                            'file'=>$this->home_model->getdiecode($order_detail->ManufactureID),
                            'status'=>70,
                            'Brand'=>$brand,
                            'source'=>'backoffice',
                            'design_type'=>$order_detail->Print_Type,
                            'qty'=>$order_detail->Quantity,
                            'labels'=>$order_detail->orignalQty,
                            'name'=>$order_detail->ManufactureID,
                            'CO' =>1,
                            'SP' =>1,
                            'CA' =>1,
                            'PF' =>1,
                            'action' =>0,
                            'version' =>1);
                        $this->db->insert('order_attachments_integrated',$attach_array);
                        //print_r($this->db->error());exit;


            }

               
		    //$order_detail->Print_Total."----".$order_detail->Price."----".$cuspriceexvat;
		    //"<br>----------------------------------------";

		    /*$ordergrandtotal = $order_detail->Print_Total + $order_detail->Price + $cuspriceexvat;
            $totally += $ordergrandtotal;*/
          
          $pp_price = 0;
          if($order_detail->qp_proof == 'Y'){
            $pp_price = $order_detail->qp_price;
          }
          $ordergrandtotal = $order_detail->Print_Total + $order_detail->Price + $cuspriceexvat + $pp_price;
          $totally += $ordergrandtotal;
            $this->db->query("update quotationdetails set active ='c' where SerialNumber = '$sno'");
        }
        
        
      
		
			
			 $tos = 0;
			 //$totally = $totally + ($order[0]->QuotationShippingAmount/1.2);
		     $finalorder_total = $totally*1.2; 
             $this->db->where('OrderNumber',$orderNo)->update('orders',array('OrderTotal'=>number_format($finalorder_total,2,'.','')));
			//$this->db->where('OrderNumber',$orderNo)->update('orders',array('OrderTotal'=>$totally));

  
        $query = $this->db->query("Select count(*) as total from quotationdetails WHERE active = 'N'  AND QuotationNumber LIKE '".$quoteID."'");
        $row = $query->row_array();
        if($row['total'] == 0){
            $update_status = array(
                'QuotationStatus' => 13,
            );
        }else{
            $update_status = array(
                'QuotationStatus' => 8,
            );
        }


        $this->db->where('QuotationNumber',$quoteID)
            ->update('quotations',$update_status);

        $quoteto_order = array(
            'QuotationNumber' =>$quoteID,
            'OrderNumber' =>$orderNo
        );
        $this->db->insert('quotation_to_order',$quoteto_order);

        $check = $this->db->query("select count(*) as total from orderdetails where ManufactureID LIKE 'SCO1' and  OrderNumber LIKE '".$orderNo."'")->row_array();
        $customdiecheck = $check['total'];
        if($customdiecheck>0){

            $this->customdie_order_alert($orderNo);
        }

        $this->session->set_userdata('OrderNo',$orderNo);

        return $orderNo;
    }
	
    function customdie_order_alert($orderNo){
        if(MODE == 'live'){
            $body = 'Order No '.$orderNo.' with custom die is generated. Please Review Backoffice for further Instructions.';
            $this->load->library('email');
            $this->email->initialize(array('mailtype' =>'html',));
            $this->email->subject('Custom-Die Order');
            $this->email->from('customercare@aalabels.com','Aalabels');
            $this->email->to("steve@aalabels.com");
            //$this->email->bcc("kami.ramzan77@gmail.com");
            $this->email->message($body);
            $this->email->send();
        }
    }
	
    public function fetch_custom_die_order($id){
        $query = $this->db->query("SELECT * from flexible_dies_info WHERE OID = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    function calculateamountmaterils($id){
        $query = $this->db->query("select SUM(plainprice+printprice) as price from flexible_dies_mat where OID = $id")->row_array();
        return $query['price'];
    }
    function is_ProductBrand_roll($id){

        $query=$this->db->query("select  ProductBrand,LabelsPerSheet from products  where ManufactureID='".$id."'");
        $res=$query->row_array();

        if(preg_match("/Roll Labels/i",$res['ProductBrand'])){
            $roll = 'yes';
        }else{ $roll = 'No';}
        return array('Roll'=>$roll,'LabelsPersheet'=>$res['LabelsPerSheet'],'ProductBrand'=>$res['ProductBrand']);

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
        }
        else if(preg_match("/A5/i",$type)){
            $brand = 'A5';
        }

        else{
            $brand = 'A4';
        }
        return $brand;
    }

    public function quotationNewLine($record){
        $price = $record['new_line_qty'] * $record['new_line_unit_price'];
        $param = array(
            'ManufactureID'=>$record['new_line_man'],
            'ProductName'=>$record['new_line_des'],
            'Quantity'=>$record['new_line_qty'],
            'orignalQty'=>$record['new_line_qty'],
            'Price'=>$price,
            'ProductTotalVAT'=>$price,
            'ProductTotal'=>$price,
            'QuotationNumber'=>$record['quoNumber'],
            'CustomerID'=>$record['CustomerID'],
        );

        $this->db->insert('quotationdetails',$param);
        return true;

    }

    public function updateQuotationNewLine($record){
        $price = $record['update_line_qty'] * $record['update_line_unit_price'];
        $param = array(
            'ManufactureID'=>$record['update_line_man'],
            'ProductName'=>$record['update_line_des'],
            'Quantity'=>$record['update_line_qty'],
            'Price'=>$price,
            'ProductTotalVAT'=>$price,
            'ProductTotal'=>$price *vat_rate,
            'CustomerID'=>$record['userId'],
        );
        $this->db->where('SerialNumber',$record['serialNumber']);
        $this->db->update('quotationdetails',$param);
        return true;

    }

    public function updatequoteitem($id,$update){

        $this->db->where('SerialNumber',$id);
        $this->db->update('quotationdetails',$update);
        $this->updatequotetotal($id);

    }
    public function updatequotetotal($id)
    {
        $quoteNo = $this->db->select('QuotationNumber')->get_where('quotationdetails', array('SerialNumber' => $id));
        $quoteNo = $quoteNo->result();
        $quoteNo = $quoteNo[0]->QuotationNumber;

        $quotetotal = $this->db->select_sum('ProductTotal')->get_where('quotationdetails', array('QuotationNumber' => $quoteNo));
        $quotetotal = $quotetotal->result();
        $quotetotal = $quotetotal[0]->ProductTotal;

        $quoteprint = $this->db->select_sum('Print_Total')->get_where('quotationdetails', array('QuotationNumber' => $quoteNo));
        $quoteprint = $quoteprint->result();
        $quoteprint = $quoteprint[0]->Print_Total;

        $quotetotal = $quotetotal + ($quoteprint * 1.2);

        $shiptotal =$this->db->select('QuotationShippingAmount,vat_exempt')->get_where('quotations', array('QuotationNumber' => $quoteNo));
        $shiptotal = $shiptotal->result();
        $shiptotal = $shiptotal[0]->QuotationShippingAmount;

        $integrated = $this->is_quotation_integrated($quoteNo);
        if($integrated > 0){
            $shiptotal = $this->delivery_quotation_integrated($quoteNo);
        }


        $quotetotal_amount = number_format($quotetotal + $shiptotal,'2','.','');


        $update =  array('QuotationTotal' =>$quotetotal_amount,'QuotationShippingAmount' =>$shiptotal);
        $this->db->where('QuotationNumber',$quoteNo);
        $this->db->update('quotations',$update);
    }

   public function getQuotationDetail($quotationNumber){
    
    
    $where = '(qd.sample!="Sample" or qd.sample IS NULL)';
    $results = $this->db->select("qd.*,p.ProductName as pn,p.ProductBrand,p.LabelsPerSheet,p.ProductCategoryName")
    ->from('quotationdetails as qd')
    ->join('products as p', 'qd.ProductID = p.ProductID','left')
    ->where($where)
    ->where(array('qd.QuotationNumber'=>$quotationNumber))
    ->get()->result();
    return $results;
    }

    public function checkQuotationDetailByOrderNumber($quotationNumber){
        $results = $this->db->select("qd.*")
            ->from('quotationdetails as qd')
            ->where('qd.QuotationNumber',$quotationNumber)
            ->where('active != ','c')

            ->get()->result();
        return $results;
    }

    public function checkAllDetails(){
            $quotations = $this->checkQuotationDetailByOrderNumber($this->input->post('quotationNumber'));

           // print_r($quotations);exit;
            //$value = ($this->input->post('val') == 'N')?'':$this->input->post('val');
            foreach ($quotations as $quotation){
                $update = array(
                    'active'=>$this->input->post('val')
                );

                $this->db->where('SerialNumber',$quotation->SerialNumber);
                $this->db->update('quotationdetails',$update);
            }

            return true;
    }

    public function getAllCheck($quoNumber){
        $results = $this->db->select("count(*) as count")
            ->from('quotationdetails as qd')
            ->where('qd.QuotationNumber',$quoNumber)
            ->where('active','Y')
            ->get()->result();

        if($results[0]->count >0){
            return 'Y';
        }else{
            return 'N';
        }
    }
	
	 function apply_discount($userID,$manufature,$final_price,$type){
   
    
	   	$wholesale = $this->home_model->get_db_column('customers','wholesale','UserID',$userID);
		if($wholesale == "wholesale"){
			
			$this->load->model('discount_model');
			if($type == "roll")
			{
				$discount_percent = $this->discount_model->check_ws_discount_rolls($userID,$manufature);
				$discount_percent = $discount_percent['print_discount'];
			}
			else
			{
				$discount_percent = $this->discount_model->check_ws_discount_print($userID,$manufature);
			}
			if(!empty($discount_percent))
			{
				$discount = ($discount_percent/100)*$final_price;
				$final_price = round($final_price - $discount,2);
			}
			else
			{
				$global_discount = $this->discount_model->get_global_discount_print($userID);
				$discount = ($global_discount/100)*$final_price;
				$final_price = round($final_price - $discount,2);
			}
			
			$this->session->set_userdata(array('ws_applied'=>'yes'));
		 }
		  return $final_price;
	 }
	
	function update_discount($userID,$table){
		   $result = $this->fetchroll_products();
		   foreach($result as $row){
			  $min_qty = $this->home_model->min_qty_roll($row->ManufactureID); 
			  
			  $response = $this->home_model->rolls_calculation($min_qty,$row->LabelsPerSheet,$row->orignalQty);
			  $labels           = $response['total_labels'];
              $labels_per_rolls = $response['per_roll'];
              $sheets           = $response['rolls'];
			  
			  $collection['labels'] 	= $labels;
			  $collection['manufature'] = $row->ManufactureID;
			  $collection['finish']     = $row->FinishType;
			  $collection['rolls']      = $sheets;
			  $collection['labeltype']  = $row->Print_Type;
			  
			  $price_res = $this->home_model->calculate_printing_price($collection);
              $promotiondiscount  = $price_res['promotiondiscount'];
              $plainlabelsprice   = $price_res['plainprice'];
              $label_finish       = $price_res['label_finish'];
			  
			  $price = $plainprice = $price_res['final_price'];
			  $printprice = $designprice = 0.00;
			  $pressproofprice = ($row->pressproof == 1)?50.00:0;
			  
			   if($row->Quantity>$response['rolls']){
			     $add_rolls = $row->Quantity - $response['rolls'];	 
			     $additional_cost = $this->home_model->additional_charges_rolls($add_rolls);
			     $price = $price + $additional_cost;
			   }
	 
       $price = $this->quotationModal->apply_discount($userID,$row->ManufactureID,$price,'roll');
       $price = $designprice+$printprice+$price+$pressproofprice;
       $price = number_format($price,2,'.','');
			  
       $this->update_db_column("temporaryshoppingbasket","TotalPrice",$price,"ID",$row->ID);
       $this->update_db_column("temporaryshoppingbasket","UnitPrice",$price/$row->Quantity,"ID",$row->ID);
			 
     } // foreach
		   
	 }
	
	 function fetchroll_products(){
		$cookie = @$_COOKIE['ci_session'];
		$cookie = stripslashes($cookie);
		$cookie = @unserialize($cookie);
		$cisess_session_id = $cookie['session_id'];  
		$session_id = $this->session->userdata('session_id');
			
		$qry = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) and prd.ProductBrand LIKE 'Roll Labels' and tsb.Printing = 'Y'");
			
		$res  = $qry->result();
		return $res;
	}
	
	function update_db_column($table, $column, $data, $key, $value){
		$sql = "UPDATE $table SET $column = $data WHERE $key LIKE '".$value."' LIMIT 1";
		$row = $this->db->query($sql);
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	 function ProductBrand($id){
		$query=$this->db->query("select  ProductBrand from products  where ManufactureID LIKE '".$id."'");
		$res=$query->row_array();
		return $res['ProductBrand'];
	}
	
	
	public function check_product_extra_detail($ManufactureID,$ProductBrand=NULL){
	   
	   $code = 'AAAAAAAAA';
	   if(isset($ProductBrand) && $ProductBrand !=""){}else{
	    $ProductBrand = $this->ProductBrand($ManufactureID);
	   }
		if(isset($ProductBrand) and  $ProductBrand == 'Roll Labels'){ 
				$ManufactureID = substr($ManufactureID,0,-1);
		}
		if(isset($ProductBrand) and  $ProductBrand != ''){ 
				$code = $this->getmaterialcode($ManufactureID);
		}
		
		if(isset($ProductBrand) and  $ProductBrand != ''){ 
				$pdiecode = str_replace($code,"",$ManufactureID);
		}
		
		$query = "select * from product_info where  ManufactureID LIKE '$ManufactureID' AND p_brand LIKE '$ProductBrand'";							
		$productcode = $this->db->query($query);
		if($productcode->num_rows() == 1){
				$productcode = $productcode->row_array();
				$product_info = $productcode['Detail'];
		}
		
		$query = "select * from product_info where  ManufactureID LIKE '$code' AND p_brand LIKE '$ProductBrand'";							
		$material = $this->db->query($query);
		if($material->num_rows() == 1){
				$material = $material->row_array();
				if($product_info){ $product_info .= ', ';}
				$product_info .= ' '.$material['Detail'];
		}
		
		$query = "select * from product_info where  ManufactureID LIKE '$pdiecode' AND p_brand LIKE '$ProductBrand'";							
		$diecode = $this->db->query($query);
		if($diecode->num_rows() == 1){
			$diecode = $diecode->row_array();
			if($product_info){ $product_info .= ', ';}
			$product_info .= ' '.$diecode['Detail'];
		}
		
		$detail_view = 'no';
		if(isset($product_info) and $product_info!=''){
			$detail_view = 'yes';
		}
		$data = array('prompt'=>$detail_view,'detail'=>$product_info);	
		return $data;
		
   
   } 
   
       public function updateBilling($id)
     {  
        if($_POST){
            $BEmail = $this->input->post('BEmail');
            $BFirstName = $this->input->post('FirstName');
            $BLastname = $this->input->post('Lastname');
            $BAddress1 = $this->input->post('Address1');
            $BAddress2 = $this->input->post('Address2');
            $BState = $this->input->post('CountyState');
            $BCity = $this->input->post('TownCity');
            $BPcode = $this->input->post('pcode');
            $BCountry = $this->input->post('bill_country');
            $BTelephone = $this->input->post('Telephone');
            $BMobile = $this->input->post('Mobile');
            $company=$this->input->post('Company');
            $data = array( 
                'Billingemail' => $BEmail,
                'BillingFirstName' => $BFirstName,
                'BillingLastName' => $BLastname,
                'BillingAddress1' => $BAddress1,
                'BillingAddress2' => $BAddress2,
                'BillingCountyState' => $BState,
                'BillingTownCity' =>$BCity,
                'BillingCountry' => $BCountry,
                'BillingPostcode' =>$BPcode,
                'BillingTelephone' => $BTelephone,
                'BillingMobile'=> $BMobile,
                'BillingCompanyName'=>$company
            );
            $this->db->where('QuotationNumber',$id);
            $this->db->update('quotations', $data);
            return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
       } 
    }  

    public function updateDelivery($id)
    { 
        if($_POST){
            $DEmail = $this->input->post('DEmail');
            $DFirstName = $this->input->post('DFirstName');
            $DLastname = $this->input->post('DLastname');
            $DAddress1 = $this->input->post('DAddress1');
            $DAddress2 = $this->input->post('DAddress2');
            $DState = $this->input->post('DCountyState');
            $DCity = $this->input->post('DTownCity');
            $DPcode = $this->input->post('Dpcode');
            $DCountry = $this->input->post('Dbill_country');
            $DTelephone = $this->input->post('DTelephone');
            $DMobile = $this->input->post('DMobile');
            $Dcompany=$this->input->post('DCompany');
            $data = array( 
                'Deliveryemail' => $DEmail,
                'DeliveryFirstName' => $DFirstName,
                'DeliveryLastName' => $DLastname,
                'DeliveryAddress1' => $DAddress1,
                'DeliveryAddress2' => $DAddress2,
                'DeliveryCountyState' => $DState,
                'DeliveryTownCity' =>$DCity,
                'DeliveryCountry' => $DCountry,
                'DeliveryPostcode' =>$DPcode,
                'Deliverytelephone' => $DTelephone,
                'DeliveryMobile'=> $DMobile,
                'DeliveryCompanyName'=>$Dcompany
            );
            $this->db->where('QuotationNumber',$id);
            $this->db->update('quotations', $data);
            return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        } 
    }


    public function getQuotationDetailforChng($quotationNumber){
        $results = $this->db->select("qd.*,p.ProductName as pn,p.ProductBrand,p.LabelsPerSheet,p.ProductCategoryName")
            ->from('quotationdetails as qd')
            ->join('products as p', 'qd.ProductID = p.ProductID','left')
            ->where('qd.SerialNumber',$quotationNumber)
            ->get()->result();
        return $results;
    }
    
    
    
    public function all_custom_lines($q){
        $q = "select count(*) as sums from quotationdetails where QuotationNumber = '".$q."' and ProductID = 0";
        return $res = $this->db->query($q)->row();
    }
    
    public function all_normal_lines($q){
        $q = "select count(*) as sums from quotationdetails where QuotationNumber = '".$q."' and ProductID != 0";
        return $res = $this->db->query($q)->row();
    }
   
   
}