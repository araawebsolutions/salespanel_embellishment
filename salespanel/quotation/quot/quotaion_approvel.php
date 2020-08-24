ALTER TABLE `quotations` ADD `view_count` INT NULL DEFAULT NULL AFTER `module`, ADD `view_time` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `quotations` ADD `view_status` VARCHAR(50) NULL DEFAULT NULL;
ALTER TABLE `quotations` ADD `qOrderNo` VARCHAR(50) NULL;
ALTER TABLE `quotations` ADD `requote_time` VARCHAR(50) NULL;

ALTER TABLE `temporaryshoppingbasket` ADD `tempQNoApprovel` VARCHAR(50) NULL;
ALTER TABLE `quotationdetails` ADD `view_row_status` VARCHAR(15) NULL;

ALTER TABLE `quotationdetails` ADD `qp_proof` ENUM('Y','N') NULL DEFAULT 'N' AFTER `view_row_status`, ADD `qp_serial` VARCHAR(50) NULL DEFAULT '';
ALTER TABLE `quotationdetails` ADD `qp_foc` ENUM('Y','N') NULL DEFAULT 'N';


ALTER TABLE `orderdetails` ADD `odp_proof` ENUM('Y','N') NULL DEFAULT 'N' AFTER `DeliveryDate`,
ADD `odp_qty` INT(12) NULL AFTER `odp_proof`, ADD `odp_price` FLOAT(12) NULL AFTER `odp_qty`, ADD `odp_foc` ENUM('Y','N') NOT NULL DEFAULT 'N' AFTER `odp_price`;

qp_price
qp_qty


view emails->confirm-quotation
view--> order_quotation->quotation -> en ->quoteconfirm

view ----> email->popups
	1 checklist
	2 requote

view --> old_pdf->pp_line
view --> order_quotation ->checkout->pp_line 





view -> quotation->detail_list
<th>Actions</th>

    	     {
                    "render": function (data, type, row) {
                      
                      var view_count;
                      var view_status;
                      var view_time;
                      var requote_time;
                      var qorderNo;

                      view_count =  row[11];
                      view_status = row[12];
                      view_time =   row[13];
                      requote_time = row[14];
                      qorderNo = row[15];
                      
                      //(view_count+ ' -- '+ view_status +' -- '+ view_time);
                      
                      if (view_count == '0') {
                        return '<span style="color:#820101;"><b>Link Sent</b></span>';
                      }
                      
                      if((view_count != '0') && (view_time!="") && (view_status=="")){
                        return '<span style="color:#820101;"><b>Viewed - '+ view_count +'</b> <br> '+view_time+' </span>';
                      }
                        
                      if((view_status!="" && view_status!=null)){
                        
                         if(view_status =='Requoted'){
                           return '<span style="color:#820101;"><b>'+ view_status +'</b> <br> '+requote_time+' </span>';

                         } else if(view_status =='Accepted'){
                           return '<span style="color:#820101;"><b>'+ view_status +'</b> '+qorderNo+' </span>';

                         }
                        else{
                           return '<span style="color:#820101;"><b>'+ view_status +'</b></span>';
                         }
                      }
                        return "---";
                    }
                },




controller ------- > Email --------> Full
controller -------------> quotation 


public function updatePressPrice(){
    
    
    $type = $this->input->post('type');
    $qty = $this->input->post('qty');
    $serial = $this->input->post('serial');
    $foc = $this->input->post('foc');
    
    $QNum = $this->input->post('QNum');
    $UseID = $this->input->post('UseID');    
    
    $ex = $this->input->post('ex');
    
    $price_ten = 0;
    $price_over_ten = 0;
    $price_over_each = '12.90';
    
    $over_ten_qty = 0;
    $qty_10 = 0;
    
    if($qty > 10){
      $over_ten_qty  =  ($qty - 10); 
      $qty_10 = 10;
    }
    
    if(10 >= $qty || (10 >= $qty_10)){
      if($qty=='2'){ $price_ten = '50.00'; }
      if($qty=='4'){ $price_ten = '80.00'; }
      if($qty=='6'){ $price_ten = '110.00'; }
      if($qty=='8'){ $price_ten = '136.00'; }
      if($qty=='10'){ $price_ten = '155.00'; }
    }
    
    if($over_ten_qty!=0){
      $price_over_ten = round($over_ten_qty * $price_over_each,2);
    }
    
    $price = number_format( ($price_over_ten + $price_ten)  * $ex,2,'.','');
    
    if($foc=="Y"){
      $price = '0.00';
    }
    
    
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
    echo true;
    
    
  }
  
  
  
  public function deletePressproof(){
   
    $serial = $this->input->post('serial');
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
    echo true;
  }
  	
}


controller -> ORDER -> SENDpaypol


   if($quotationiNumber){
     $param11= array('view_count'=>'0');
     $this->db->where('QuotationNumber',$quotationiNumber);
     $this->db->update('quotations',$param11);
   }

$FirstName 		= 	$quotation[0]->BillingFirstName.' '.$quotation[0]->BillingLastName; 

$strInDB  = array($quotationNo,'GB 945 0286 20',$FirstName,

	function sendEmailForPayPol($quotationiNumber){
		
		$currency_options = $this->cartModal->get_currecy_options();
		$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

		$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
		$exchange_rate = $this->cartModal->get_exchange_rate($currency);
	
		$quotation = $this->quotationModal->getQuotation($quotationiNumber);

   

   if($quotationiNumber){
     $param11= array('view_count'=>'0');
     $this->db->where('QuotationNumber',$quotationiNumber);
     $this->db->update('quotations',$param11);
   }
   
	
		$quotationDetails = $this->quotationModal->getQuotationDetail($quotationiNumber);
			

		$FirstName 		= 	$quotation[0]->BillingFirstName.' '.$quotation[0]->BillingLastName; 
		$EmailAddress 	=	$quotation[0]->Billingemail;	
		$date  			= 	$quotation[0]->QuotationDate;
		$time			=	$quotation[0]->QuotationDate;	
		$OrderDate 		= 	date("d/m/Y",$date);
		$OrderTime 		= 	date("H:i",$time);
		$PaymentMethod1 =	$quotation[0]->PaymentMethods;
			
		$sql = $this->db->get_where(Template_Table, array('MailID' =>'3'));
		$result = $sql->result_array();
		$result = $result[0];
		$mailTitle = $result['MailTitle'];
		$mailName = $result['Name'];
		$from_mail = $result['MailFrom'];
		$mailSubject = $result['MailSubject'] .' : '.$quotationiNumber;

		$mailText = $result['MailBody'];
		
		$getfile = FCPATH.'application/views/order_quotation/checkout/quote-confirm.html';
		$mailText = file_get_contents($getfile);
			
		$extPrice = 0;
		$se = 0;
		$rows = '';
		
		foreach ($quotationDetails as $key => $quotationDetail) {
			$extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
			if ($quotationDetail->ManufactureID == 'SCO1') {
				$carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);
				  
				$rows .='<tr>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'. $quotationDetail->ManufactureID.'</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$quotationDetail->ProductName.'</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$quotationDetail->Quantity.'</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">-</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:1; border-top:0;">'.$symbol.$quotationDetail->Price.'</td>
				   </tr>';
			 
				$scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
				$assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
				foreach ($assoc as $rowp){
        	       
					$materialprice = $rowp->plainprice + $rowp->printprice;
					$materialpriceinc = $materialprice * 1.2;
					$rows .='<tr>
							 <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$rowp->material.'</td>
							 <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$this->user_model->get_mat_name($rowp->material).'</td>
							 <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$rowp->qty.'</td>
							 <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">-</td>
							 <td style="font-size:12px; border:1px solid #b3b3b3; border-top:0;">'.$symbol.number_format($materialprice * $exchange_rate, 2) .'</td>
							 </tr>';
								
					$se +=  $materialprice;
				}
			 
	
	
			}else{
				$rows .='<tr>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$quotationDetail->ManufactureID.'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$quotationDetail->ProductName.'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$quotationDetail->Quantity.'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$symbol.number_format($quotationDetail->Price / $quotationDetail->Quantity,2,'.','').'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0;">'.$symbol.number_format($quotationDetail->Price * 	$exchange_rate, 2,'.','') .'</td>
				</tr>';
			 
			}
		}

		$Delivery = $symbol.number_format($quotation[0]->QuotationShippingAmount / vat_rate * $exchange_rate, 2);
		$grandPrice = $se + $extPrice + number_format($quotation[0]->QuotationShippingAmount / vat_rate * $exchange_rate, 2);
		$gtotalExvat = $symbol.number_format($grandPrice * $exchange_rate, 2);
		
		$vatType = '';
		
		if ($quotation[0]->vat_exempt == 'yes'){
			$vatType = 'VAT Exempt';
			$vatVals = $symbol.number_format(($grandPrice * vat_rate) - $grandPrice  * $exchange_rate, 2);
		} else {
			$grandPrice = $grandPrice;
			$vatType = 'VAT @20%';
			$vatVals = $symbol.number_format((($grandPrice * vat_rate) - $grandPrice  ) * $exchange_rate, 2);
		}
		
		if ($quotation[0]->vat_exempt == 'yes'){
			$gt = $symbol.number_format($grandPrice * $exchange_rate, 2);
		}else{
			$gt = $symbol.number_format(($grandPrice * vat_rate) * $exchange_rate, 2);
		}
			 	 
			
		$urld = 'https://www.aalabels.com/beta/quotation-confirmation/'.md5($quotation[0]->QuotationNumber);
			
	   $strINTemplate   = array("[quotationiNumber]","[vatNo]","[BillingFirstName]","[customer_message]", "[OrderDate]", "[OrderTime]", "[PaymentMethod]","[BillingTitle]", "[BillingFirstName]", "[BillingLastName]","[BillingCompanyName]", "[BillingAddress1]","[BillingAddress2]", "[BillingTownCity]", "[BillingCountyState]","[BillingPostcode]", "[BillingCountry]", "[Billingtelephone]", "[BillingMobile]", "[Billingfax]", "[EmailAddress]","[DeliveryTitle]", "[DeliveryFirstName]", "[DeliveryLastName]" ,"[DeliveryCompanyName]", "[DeliveryAddress1]", "[DeliveryAddress2]", "[DeliveryTownCity]", "[DeliveryCountyState]", "[DeliveryPostcode]", "[DeliveryCountry]","[OrderItems]", "[DeliveryExVatCost]","[gtotalExvat]","[gtotalIncvat]","[vatType]","[vatVals]","[go_url]");
  
		$webroot = base_url(). "theme/";
		//----------------------------------------------------------------------------------------------
		
		$quotationNo 				=	$quotation[0]->QuotationNumber;
		$BillingTitle 			=	$quotation[0]->BillingTitle;	
		$BillingFirstName 	=	$quotation[0]->BillingFirstName;	
		$BillingLastName 		=	$quotation[0]->BillingLastName;	
		$BillingCompanyName =	$quotation[0]->BillingCompanyName;		
		$BillingAddress1 		=	$quotation[0]->BillingAddress1;	
		$BillingAddress2 		=	$quotation[0]->BillingAddress2;	
		$BillingTownCity 		=	$quotation[0]->BillingTownCity;		
		$BillingCountyState =	$quotation[0]->BillingCountyState;	
		$BillingPostcode 		=	$quotation[0]->BillingPostcode;	
		$BillingCountry 		=	$quotation[0]->BillingCountry;		
		$Billingtelephone 	=	$quotation[0]->Billingtelephone;	
		$BillingMobile1 		=	$quotation[0]->BillingMobile;	
		$Billingfax 				=	$quotation[0]->Billingfax;
		$BillingResCom 			=	$quotation[0]->BillingResCom;
		//$EmailAddress 		=	$res3['Billingemail'];		
			$DeliveryTitle 			=	$quotation[0]->DeliveryTitle;		
		$DeliveryFirstName 	= $quotation[0]->DeliveryFirstName;	
		$DeliveryLastName 	=	$quotation[0]->DeliveryLastName;	
		$DeliveryCompanyName=	$quotation[0]->DeliveryCompanyName;	 
		$DeliveryAddress1  	=	$quotation[0]->DeliveryAddress1;	
		$DeliveryAddress2 	=	$quotation[0]->DeliveryAddress2;	
		$DeliveryTownCity 	=	$quotation[0]->DeliveryTownCity;	
		$DeliveryCountyState=	$quotation[0]->DeliveryCountyState;	 
		$DeliveryPostcode 	=	$quotation[0]->DeliveryPostcode;	
		$DeliveryCountry 		=	$quotation[0]->DeliveryCountry;
		$DeliveryResCom 		=	$quotation[0]->DeliveryResCom;
		
		
		

		$strInDB  = array($quotationNo,'GB 945 0286 20',$FirstName,'Hi You are upset',$OrderDate,$OrderTime, $PaymentMethod1,$BillingTitle,
	  $BillingFirstName, $BillingLastName, $BillingCompanyName, $BillingAddress1, $BillingAddress2, $BillingTownCity, $BillingCountyState,$BillingPostcode, $BillingCountry, $Billingtelephone, $BillingMobile1, $Billingfax, $EmailAddress,$DeliveryTitle,$DeliveryFirstName, $DeliveryLastName,$DeliveryCompanyName, $DeliveryAddress1,$DeliveryAddress2,$DeliveryTownCity, $DeliveryCountyState, $DeliveryPostcode,$DeliveryCountry,$rows,$Delivery,$gtotalExvat,$gt,$vatType,$vatVals,$urld);
	  
		$newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
		
		//  print_r($newPhrase); exit;
		$mailfrom  ='customercare@aalabels.com';
		$mailname="AA Labels";
			
		$this->load->library('email');
		$this->email->initialize();
		//$email = $this->user_email();		
		$this->email->from($mailfrom, $mailname);
		//$this->email->to('umair.aalabels@gmail.com'); 
		$this->email->to($quotation[0]->Billingemail); 
		$this->email->bcc('Shoaib.aalabels@gmail.com');
		$this->email->subject('Quotation Approval');
		$this->email->message($newPhrase); 
		$this->email->set_mailtype("html");
		$this->email->send();
	}










views -> emails-> generate_text_line red color comment










quotattion model ----->

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


	         'odp_proof'=>$order_detail->qp_proof,
          'odp_qty'=>$order_detail->qp_qty,
          'odp_price'=>$order_detail->qp_price,
          'odp_foc'=>$order_detail->qp_foc,




        
        $pp_price = 0;
        
        
        if($order_detail->qp_proof == 'Y'){
          $pp_price = $order_detail->qp_price;
        }
        $ordergrandtotal = $order_detail->Print_Total + $order_detail->Price + $cuspriceexvat + $pp_price;
        $totally += $ordergrandtotal;



shopping_model ---->ADD_ORDER BETA WEBSITE

if($c->tempQNoApprovel!=""){
      
      $quoUpdate = array('view_status'=>'Accepted','qOrderNo'=>$OrderNumber);
      $this->db->where('QuotationNumber',$c->tempQNoApprovel);
      $this->db->update('quotations',$quoUpdate);
      
    }
    
   =============================================== 
    
       if($c->tempQNoApprovel!=""){
      
      $quoUpdate = array('view_status'=>'Accepted','qOrderNo'=>$OrderNumber);
      $this->db->where('QuotationNumber',$c->tempQNoApprovel);
      $this->db->update('quotations',$quoUpdate);
      
    }
    
    
    
		  }
		
		$Order['OrderNumber'] = $OrderNumber;
		$Order['orderNumberAGainstPaymentFailed'] = $OrderNumber;
		$this->session->set_userdata($Order);
		
		
 		/***-------- code start for voucher implementations------****/
   
   
   ==============================================


view->quotation-detail-page ->>>>>>> full
view order_quotation -> cartmaterial / diematerial

