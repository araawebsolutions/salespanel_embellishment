<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EmailModel extends CI_Model {

   	public function __construct($config = array()){ 
	 
	  $this->load->library('email');
	  $this->load->library('pdf');
	  $this->load->model('oldmodels/accountModel');
	  $this->EPATH = '/home/aalabels/public_html/';
	}
	
	
		public function order_confirmation($OrderNumber){
	    //$getfile ='http://gtserver/newlabels/system/libraries/en/order-confirmation.html';	
	   	 
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
        
		$language = ($res['site']=="" || $res['site']=="en")?"en":"fr"; 
		$viewlink = ($language=="en")?base_url()."english-version/".md5($OrderNumber):base_url()."version-anglaise/".md5($OrderNumber);
		$getfile =  $this->EPATH.'system/libraries/'.$language.'/order-confirmation.html';
	    $mailText = file_get_contents($getfile);
		
	    $PONUMBER ='';
		if($res['PurchaseOrderNumber']){
          $PONUMBER = "<strong>Your PO No : </strong>".$res['PurchaseOrderNumber'];
        } 
		
		
		$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is being processed for production. Upon completion of your order you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";
	
	
	
		if($PaymentMethod1 == 'chequePostel'){ $PaymentMethod = "Pending payment" ; $pamentOrder='Via Cheque';
		    $customer_message = "<p>Thank you for purchasing from AA Labels and we confirm that your order has been received and is pending payment by bank transfer. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.<br /><br /><b style='color:#006da4'>Payment Details</b><br />BACS TRANSFER<br />";
			$customer_message .= '<table style="font-size:12px; padding-bottom:10px;" width="100%" border="0" cellspacing="0" cellpadding="0"><tr>	
    		<td width="15%;">Account Name:</td><td width="70%;">Green Technologies Limited T/A AA Labels</td></tr><tr><td width="15%;">Sort Code:</td><td width="70%;">40-36-15</td></tr><tr><td width="15%;">A/C No:</td><td width="70%;">52385724</td></tr><tr><td width="15%;">IBAN:</td><td width="70%;">GB87MIDL40361552385724</td></tr><tr><td width="15%;">SWIFT/BIC:</td><td width="70%;">HBUKGB4108R</td></tr></table>';
		
		}
		if($PaymentMethod1 == 'creditCard'){   $PaymentMethod = "Pending processing" ;   $pamentOrder='Credit card';}
		if($PaymentMethod1 == 'purchaseOrder'){ $PaymentMethod = "Pending payment" ; $pamentOrder='Via Purchase order';
		    	$purchase_order_txt = '';
            			if($res['PurchaseOrderNumber']){
                     		 $purchase_order_txt = "(PO No. ".$res['PurchaseOrderNumber'].")";
                    	} 
        	
		    		$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending approval of your purchase order ".$purchase_order_txt.". Upon acceptance of payment by PO your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";
	
		}
		if($PaymentMethod1 == 'paypal'){ $PaymentMethod = "Completed" ; $pamentOrder='Via PayPal';}
		if($PaymentMethod1 == 'Sample Order'){ $PaymentMethod = "Sample Order" ; $pamentOrder='Sample Order';}
		if($PaymentMethod1=='PayPal eCheque')
		{
			$PaymentMethod='Via PayPal eCheque';
			
			$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending confirmation of your e-cheque payment from PayPal. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";
		}
		
		
		
		
		
		
		$BillingTitle 		=	$res['BillingTitle'];	    $BillingFirstName 	=	$res['BillingFirstName'];	
		$BillingLastName 	=	$res['BillingLastName'];	$BillingCompanyName =	$res['BillingCompanyName'];		
		$BillingAddress1 	=	$res['BillingAddress1'];	$BillingAddress2 	=	$res['BillingAddress2'];	
		$BillingTownCity 	=	$res['BillingTownCity'];	$BillingCountyState =	$res['BillingCountyState'];	
		$BillingPostcode 	=	$res['BillingPostcode'];	$BillingCountry 	=	$res['BillingCountry'];		
		$Billingtelephone 	=	$res['Billingtelephone'];	$BillingMobile1 	=	$res['BillingMobile'];	
		$Billingfax 		=	$res['Billingfax'];         $BillingResCom 		=	$res['BillingResCom'];
		$DeliveryTitle 		=	$res['DeliveryTitle'];		$DeliveryFirstName 	=	$res['DeliveryFirstName'];	
		$DeliveryLastName 	=	$res['DeliveryLastName'];	$DeliveryCompanyName=	$res['DeliveryCompanyName'];	 
		$DeliveryAddress1  	=	$res['DeliveryAddress1'];	$DeliveryAddress2 	=	$res['DeliveryAddress2'];	
		$DeliveryTownCity 	=	$res['DeliveryTownCity'];	$DeliveryCountyState=	$res['DeliveryCountyState'];	 
		$DeliveryPostcode 	=	$res['DeliveryPostcode'];	$DeliveryCountry 	=	$res['DeliveryCountry'];
		$DeliveryResCom 	=	$res['DeliveryResCom'];
		
		$styleBillingCompnay = ""; $styleDeliveryCompany = ""; $styleBillingCompnay = ""; $styleDeliveryCompany = "";
		
		
		if($BillingCompanyName!=''){		
			$styleBillingCompnay="<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>";
			$styleBillingCompnay.=$BillingCompanyName."</td></tr>";
		}
		
		if($DeliveryCompanyName!=''){
			$styleDeliveryCompany="<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>".
			$styleDeliveryCompany.=$DeliveryCompanyName."</td></tr>";
		}
		
		
		
		$websiteOrders  = $res['Source'];
		$vatRate 	    = "20.00";
		$DeliveryOption = "";
		   
		$deliveryChargesExVat =	number_format($res['OrderShippingAmount']/(($vatRate+100)/100),2,'.','');
		$DeliveryExVatCost    = ($deliveryChargesExVat)?$deliveryChargesExVat:'0.00';
		$DeliveryIncVatCost   = ($res['OrderShippingAmount'])?number_format($res['OrderShippingAmount'],2,'.',''):'0.00';
			
		$OrderTotalExVAT 	=	number_format($res['OrderTotal']/1.2,2);	
		$OrderTotalIncVAT 	= 	number_format($res['OrderTotal'],2);
		$CompanyName 		= 	"AALABELS";
		
		$orderecords = $this->db->get_where('orderdetails', array('OrderNumber' => $OrderNumber));
		$num_row = $orderecords->num_rows();
		$info_order = $orderecords->result_array();
		$TotalQuantity = "";
		$SubTotalExVat1 = "";
		$SubTotalIncVat1 = "";
		$rows = "";
		$i = 0;
		$bgcolor='';
		
		 foreach($info_order as $rec){ //error_reporting(E_ALL);
		    $prl   =   $rec['Prl_id'];          
			
			if($language=="fr" && $rec['ProductID']!=0){ 
			 $this->lang->load('genral');	
			 $prod = $this->quoteModel->show_product($rec['ProductID']);
			 $merger = array_merge($prod,$rec);
		     $ProductName = $this->quoteModel->fetch_product_name($merger);
			}else{ $ProductName  = 	$rec['ProductName']; }
			
			
			//********************************************************************//
			
			 if($rec['ManufactureID']=="SCO1" && $language=="fr"){
				 
			    $custominfo = $this->quoteModel->fetch_custom_die_order($rec['SerialNumber']); 
				     $ProductName.= ' pour ';
					 $ProductName.= ($custominfo['format'] == 'Roll')?$custominfo['format'].' etiquettes ':$custominfo['format'].' Feuilles ';
					 $ProductName.= $custominfo['width'];
						 
					 if($custominfo['shape']!="Circle"){
					  $ProductName.= 'x'.$custominfo['height'].' mm ';
					 }
					 
					 if($custominfo['shape'] != ''){
					  $ProductName.= ' '.$custominfo['shape'].', ';
					 }
					 
					 if($custominfo['format']=="Roll"){
						 $ProductName.= "bord d'attaque ".$custominfo['width'].' mm, ';
					 }
					 
					 $ProductName.= "Rayon d'angle ".$custominfo['cornerradius'].' mm';
			
			}else if($rec['ManufactureID']=="SCO1"){
					 $custominfo = $this->quoteModel->fetch_custom_die_order($rec['SerialNumber']); 
					 $ProductName.= ' for ';
					 $ProductName.= ($custominfo['format'] == 'Roll')?$custominfo['format'].' Labels ':$custominfo['format'].' Sheets ';
					 $ProductName.= $custominfo['width'];
						 
					 if($custominfo['shape']!="Circle"){
						  $ProductName.= 'x'.$custominfo['height'].' mm ';
					 }
					 
					 if($custominfo['shape'] != ''){
						 $ProductName.= ' '.$custominfo['shape'].', ';
					 }
					 
					 if($custominfo['format']=="Roll"){
						 $ProductName.= 'Leading Edge '.$custominfo['width'].' mm, ';
					 }
					 
					 $ProductName.= 'Corner radius '.$custominfo['cornerradius'].' mm';
			
			}
			
			
			//********************************************************************//
	       
	       
		    if($rec['Printing']=='Y'){
			  	$rec['Price'] = $rec['Price']+$rec['Print_Total'];
				$rec['ProductTotal'] = $rec['ProductTotal']+($rec['Print_Total']*1.2);
				
			  if($language=="fr"){	
			      if($rec['Print_Type']=="Monochrome - Black Only" || $rec['Print_Type']=="Mono"){
				     $A4Printing = "Service d'impression ( Monochrome - Noir seulement )";
				  }else{
				     $frprnttype = $this->orderModel->get_printing_service_name($rec['Print_Type']);
				     $frprint = $this->orderModel->get_db_column('digital_printing_process','name_fr','name',trim($frprnttype));
				     $A4Printing = "Service d'impression ( ".$frprint." )";
				  }
			  }else{
			    $frprint = $this->orderModel->get_printing_service_name($rec['Print_Type']);
				$A4Printing = "Printing Service ( ".$frprint." )";
			  }
				
				$ProductName = $ProductName.' - <b>'.$A4Printing.'</b>';
			 }
	
			$PriceExVat1	 =   $rec['Price'];
			$PriceExVat      =   $PriceExVat1;
			$UnitPrice	     =	 number_format(round(($rec['Price']/$rec['Quantity']), 4),4,'.','');	
			$PriceIncVat     =   number_format(($rec['ProductTotal']),2,'.','');	
				
			$Quantity	     =   $rec['Quantity'];
			$TotalQuantity	+=   $Quantity;
			$ProductCode     =	 $rec['ProductID'];
			$exchange_rate   =   $res['exchange_rate'];  
			
			//
//			if($rec['ManufactureID']=="PRL1"){
//			 $ManufacturerId = $rec['ManufactureID'];
//			}else{
//			 $ManufacturerId  = $this->menufacture($ProductCode);
//			 $ManufacturerId = $ManufacturerId[0]->ManufactureID; 
//			}
			 $ManufacturerId = $rec['ManufactureID'];
			 $bgcolor = ($bgcolor=='')?'#F5F5F5':'';
			 
			 
			 if($rec['Printing']=='Y'){
			    $lbpr = $this->orderModel->calculate_total_printed_labels($rec['SerialNumber']);
	            $LabelsPerSheet = $lbpr / $rec['Quantity'];
			 }else{
		        $LabelsPerSheet = ($rec['is_custom'] == 'Yes')?$rec['LabelsPerRoll']:$this->accountModel->LabelsPerSheet($rec['ProductID']);
			 }
			
			
			 $rows .='<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ManufacturerId.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ProductName.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$Quantity.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.symbol.number_format($UnitPrice*$exchange_rate,4).'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.symbol.number_format($PriceExVat*$exchange_rate,2,'.','').'</td>
				     </tr>';
					 
					 if($ManufacturerId=="PRL1"){
					   $result = $this->quoteModel->get_details_roll_quotation($prl);
					    $rows .='<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">
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
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;"></td>
				      </tr>';
				    }
			 
		//********************************************************************//	 
			 if($ManufacturerId=="SCO1" && $rec['Linescompleted']==0){
				 
				 $assoc = $this->quoteModel->fetch_custom_die_association($custominfo['ID']);
				 
				  if($language=="fr"){
					  
					foreach($assoc as $rowp){  
					 $assmatername='';
					 $fr_printing = ($rowp->labeltype=="printed")?"imprimé":"plaine";
					 $materilaname_fr = $this->quoteModel->get_mat_name_fr($rowp->material);
					 $assmatername.= $materilaname_fr.' - '.$rowp->labeltype.' etiquettes' ;
						  
						  ///********///////********///////********///////********////
						  if($rowp->labeltype=="printed"){  
						    
							if($rowp->printing=="Monochrome - Black Only" || $rowp->printing=="Mono"){
							  $fr_prnt_type = "Monochrome - Noir seulement";
							 }else{
							  $fr_prnt_type  = $this->orderModel->get_db_column('digital_printing_process', 'name_fr', 'name',trim($rowp->printing));
							  $rowpprinting  = $this->orderModel->ReplaceHtmlToString_($fr_prnt_type);
							 }
							 
							 $assmatername.=' - '.$rowpprinting.' - '.$rowp->designs.' Conceptions ';
							   if($custominfo['format']=="Roll"){
							     if($rowp->finish == "Gloss Lamination"){
									$finish_type_fr = 'Lamination Gloss';
								  }else if($rowp->finish == "Matt Lamination"){
									$finish_type_fr = 'Matt Lamination';
								  }else if($rowp->finish =="Matt Varnish"){
									$finish_type_fr = 'Vernis mat';
								  }else if($rowp->finish == "Gloss Varnish"){
									$finish_type_fr = 'Vernis brillant';
								  }else if($rowp->finish == "High Gloss Varnish"){
									$finish_type_fr = 'Vernis a haute brillance';
								  }else{
									$finish_type_fr == 'No Finish';
								  }
								   $assmatername.='<br> with label finish '.$finish_type_fr;
						       }
						  }
						  ///********///////********///////********///////********///////********////
				          if($custominfo['format']=="Roll"){
							$assmatername.=' - '.$rowp->rolllabels.' etiquettes - taille de noyau '.$rowp->core.' mm - '.$rowp->wound.' blessure';
						  }
				
				          $cuspriceexvat = $rowp->plainprice+$rowp->printprice;
						  $unitmaterialprice = $cuspriceexvat/$rowp->qty;
						  
					  $rows .='<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"><b>'.$rowp->material.'</b> - '.$assmatername.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$rowp->qty.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.symbol.number_format($unitmaterialprice*$exchange_rate,2,'.','').'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.symbol.number_format($cuspriceexvat*$exchange_rate,2,'.','').'</td>
				      </tr>';
						$cuspriceincvat = $cuspriceexvat*1.2; 
						$PriceExVat+= $cuspriceexvat;
						$PriceIncVat+= $cuspriceincvat;	
					}
				  }else{
				  
				   foreach($assoc as $rowp){
					 $assmatername='';  
					 $materilaname_en = $this->quoteModel->get_mat_name($rowp->material);
					 $assmatername.= $materilaname_en.' - '.$rowp->labeltype.' labels' ;
						  
						  if($rowp->labeltype=="printed"){  
						     $assmatername.=' - '.$rowp->printing.' - '.$rowp->designs.' Designs ';
							 if($custominfo['format']=="Roll"){
							  $assmatername.='<br> with label finish '.$rowp->finish;
							 }
						  }
				          if($custominfo['format']=="Roll"){
							$assmatername.=' - '.$rowp->rolllabels.' labels - core size '.$rowp->core.' mm - '.$rowp->wound.' wound';
						  }
				
				          $cuspriceexvat = $rowp->plainprice+$rowp->printprice;
						  $unitmaterialprice = $cuspriceexvat/$rowp->qty;
						  
				  $rows .='<tr>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"><b>'.$rowp->material.'</b> - '.$assmatername.'</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$rowp->qty.'</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.symbol.number_format($unitmaterialprice*$exchange_rate,2,'.','').'</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.symbol.number_format($cuspriceexvat*$exchange_rate,2,'.','').'</td>
				  </tr>';
						$cuspriceincvat = $cuspriceexvat*1.2; 
						$PriceExVat+= $cuspriceexvat;
						$PriceIncVat+= $cuspriceincvat;	
					}
				
				}	
			
			}
			
			
			//********************************************************************//
			
					 
			   $SubTotalExVat1 += $PriceExVat;
			   $SubTotalIncVat1 +=$PriceIncVat;
			   $i++;
		 
		 }
		    $SubTotalExVat	=	number_format($SubTotalExVat1,2,'.','');	
			$SubTotalIncVat	=	number_format($SubTotalIncVat1,2,'.','');	
			$OrderTotalExVAT1 = $SubTotalExVat;
			
			$OrderTotalExVAT	 =	number_format($OrderTotalExVAT1,2,'.','');	
			$OrderTotalIncVAT	=	number_format(($DeliveryIncVatCost+$SubTotalIncVat1),2,'.','');	
		
			$exvatSubtotalExVat=symbol.$SubTotalExVat;
			$exvatSubtotalIncVat=symbol.$SubTotalIncVat;
			
			$deliveryExVat=symbol.$DeliveryExVatCost;
			$deliveryIncVat=symbol.$DeliveryIncVatCost;
			
		//	$gtotalExVat= $OrderTotalExVAT + $DeliveryExVatCost;
		//	$gtotalExVat=symbol.$gtotalExVat;
	        
	        $OrderTotalExVAT = $OrderTotalExVAT + $DeliveryExVatCost;
	        $gtotalExVat=symbol.$OrderTotalExVAT;
		
			$gtotalIncVat=symbol.$OrderTotalIncVAT;
			$vatTotal=number_format($OrderTotalIncVAT-$OrderTotalExVAT,2,'.','');	
			
			$bill_rc=$res['BillingCompanyName'];
			$del_rc=$res['DeliveryCompanyName'];
			$email = $res['Billingemail'];
	
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
	  "[styleDeliveryConpnay]","[vatprice]","[pamentOrder]","[weborder]","[BillingResCom]","[DeliveryResCom]","[voucherDiscount]","[PONUMBER]","[VIEWLINK]","[customer_message]");
  
  		$webroot = base_url(). "theme/";
        //----------------------------------------------------------------------------------------------
                $qry1 = "select `UserID` from `orderdetails` where `OrderNumber` = '".$OrderNumber."'";
                $exe1 = mysql_query($qry1);
                $res1 = mysql_fetch_array($exe1);
                $qry2 = "select * from `customers` where `UserID` = '".$res1['UserID']."'";
                $exe2 = mysql_query($qry2);
                $res2 = mysql_fetch_array($exe2);
	  //-----------------------------------------------------------------------------------------------                

       
		   
		   $di_ver = ($language=="en")?"Discount":"Remise";
		   $em_sub = ($language=="en")?"ORDER CONFIRMATION ":"CONFIRMATION DE COMMANDE"; 
		
           /*--------------------------Voucher Code--------------------*/
		 if($res['voucherOfferd']=='Yes'){
				$voucherDiscount =  $this->reportsmodel->currecy_converter($res['voucherDiscount'],'no');
				$voucher_code = '<tr><td align="right">'.$di_ver.':</td><td style="color: #006da4; padding-left:10px;" align="right">'.symbol.$voucherDiscount.'</td></tr>';
			}
			else{
			  $voucherDiscount = 0.00;
			  $voucher_code = '';
			}
			
			    $gtotalIncVat = number_format($OrderTotalIncVAT - $voucherDiscount,2,'.','');
		       
			    if($res['vat_exempt']=='yes'){
				  $gtotalIncVat  = number_format($gtotalIncVat / 1.2,2,'.','');	
				  $vatTotal=0.00;
			    }else{
			     $vatTotal =  symbol.number_format($vatTotal*$exchange_rate,2);			
			    }	
		
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
	  $DeliveryOption,$gtotalExVat,$gtotalIncVat,$PaymentMethod,$styleBillingCompnay,$styleDeliveryCompany,$vatTotal,
	  $pamentOrder,$websiteOrders,$bill_rc,$del_rc,$voucher_code,$PONUMBER,$viewlink,$customer_message);
	  
	  $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
	  die($newPhrase);
			$this->email->from('customercare@aalabels.com', 'AALABELS');
			$this->email->to($EmailAddress); 
			//$this->email->bcc('Web.Development@aalabels.com');  
			$this->email->subject($em_sub);
			$this->email->message($newPhrase);
			$this->email->set_mailtype("html");
			
		//if(($res['vat_exempt']=='no') and ($res['OrderStatus']==2 || $res['OrderStatus']==32)){
//			   $this->email->send();
//			}

            // if($res['vat_exempt']=='no'){
			   $this->email->send();
			//}
			
			if($res['OrderStatus']==2 || $res['OrderStatus']==32){
			   $res['OrderStatus'] = $this->check_printable_order($OrderNumber, $res['OrderStatus']);
			}
		
	 }
	 
	 function check_printable_order($ordernumber, $OrderStatus=NULL){
		 
		$query = $this->db->query(" select count(*) as total from orderdetails where OrderNumber LIKE '".$ordernumber."' AND Printing LIKE 'Y' AND regmark = 'N' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels' ");	
				$row = $query->row_array();
				if($row['total'] > 0){
					$this->db->update('orders', array('OrderStatus'=>55), array('OrderNumber'=>$ordernumber));
					$OrderStatus =  55;
				}
				return $OrderStatus;
	}
	
	
	function menufacture($id){
      $query=$this->db->query("select  ManufactureID from products  where ProductID='".$id."'");

		$res=$query->result();

		return $res;

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

?>
