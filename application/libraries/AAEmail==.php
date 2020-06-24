<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Class
 *
 * Permits email to be sent using Mail, Sendmail, or SMTP.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/email.html
 */
class CI_AAEmail {

	
	public function __construct($config = array()){ 
	  $CI =& get_instance();
	  $backoffice_path = FCPATH.'aa_saleoperator\application\model';
	  include($backoffice_path.'\orderModel');
	  include($backoffice_path.'\quoteModel');
	  include($backoffice_path.'\accountModel');
	  include($backoffice_path.'\reportsmodel');
	  
	  $CI->load->library('email');
	  $CI->load->library('pdf');
	  $this->ci = $CI;
	}
	
	
	public function order_confirmation($OrderNumber){
	    $CI =& get_instance();
	    //$getfile ='http://gtserver/newlabels/system/libraries/en/order-confirmation.html';	
	   	 
		$query = $CI->db->get_where('orders', array('OrderNumber' => $OrderNumber));
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
		$getfile = base_url().'system/libraries/'.$language.'/order-confirmation.html';
	    $mailText = file_get_contents($getfile);
	
	    $PONUMBER ='';
		if($res['PurchaseOrderNumber']){
          $PONUMBER = "<strong>Your PO No : </strong>".$res['PurchaseOrderNumber'];
        } 
		
		if($PaymentMethod1 == 'chequePostel'){ $PaymentMethod = "Pending payment" ; $pamentOrder='Via Cheque';}
		if($PaymentMethod1 == 'creditCard'){   $PaymentMethod = "Pending processing" ;   $pamentOrder='Credit card';}
		if($PaymentMethod1 == 'purchaseOrder'){ $PaymentMethod = "Pending payment" ; $pamentOrder='Via Purchase order';}
		if($PaymentMethod1 == 'paypal'){ $PaymentMethod = "Completed" ; $pamentOrder='Via PayPal';}
		if($PaymentMethod1 == 'Sample Order'){ $PaymentMethod = "Sample Order" ; $pamentOrder='Sample Order';}
		
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
		
		$orderecords = $CI->db->get_where('orderdetails', array('OrderNumber' => $OrderNumber));
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
			 $CI->lang->load('genral');	
			 $prod = $CI->quoteModel->show_product($rec['ProductID']);
			 $merger = array_merge($prod,$rec);
		     $ProductName = $CI->quoteModel->fetch_product_name($merger);
			}else{ $ProductName  = 	$rec['ProductName']; }
			
			
			//********************************************************************//
			
			 if($rec['ManufactureID']=="SCO1" && $language=="fr"){
				 
			    $custominfo = $CI->quoteModel->fetch_custom_die_order($rec['SerialNumber']); 
				     $ProductName.= ' pour ';
					 $ProductName.= ($custominfo['format'] == 'Roll')?$custominfo['format'].' etiquettes ':$custominfo['format'].' Feuilles ';
					 $ProductName.= $custominfo['width'];
						 
					 if($custominfo['shape']!="Circle"){
					  $ProductName.= 'x'.$custominfo['height'].' mm ';
					 }
					 
					 if($custominfo['shape'] != ''){
					  $ProductName.= $custominfo['shape'].', ';
					 }
					 
					 if($custominfo['format']=="Roll"){
						 $ProductName.= "bord d'attaque ".$custominfo['width'].' mm, ';
					 }
					 
					 $ProductName.= "Rayon d'angle ".$custominfo['cornerradius'].' mm';
			
			}else if($rec['ManufactureID']=="SCO1"){
					 $custominfo = $CI->quoteModel->fetch_custom_die_order($rec['SerialNumber']); 
					 $ProductName.= ' for ';
					 $ProductName.= ($custominfo['format'] == 'Roll')?$custominfo['format'].' Labels ':$custominfo['format'].' Sheets ';
					 $ProductName.= $custominfo['width'];
						 
					 if($custominfo['shape']!="Circle"){
						  $ProductName.= 'x'.$custominfo['height'].' mm ';
					 }
					 
					 if($custominfo['shape'] != ''){
						 $ProductName.= $custominfo['shape'].', ';
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
				     $frprnttype = $CI->orderModel->get_printing_service_name($rec['Print_Type']);
				     $frprint = $CI->orderModel->get_db_column('digital_printing_process','name_fr','name',trim($frprnttype));
				     $A4Printing = "Service d'impression ( ".$frprint." )";
				  }
			  }else{
			    $frprint = $CI->orderModel->get_printing_service_name($rec['Print_Type']);
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
			    $lbpr = $CI->orderModel->calculate_total_printed_labels($rec['SerialNumber']);
	            $LabelsPerSheet = $lbpr / $rec['Quantity'];
			 }else{
		        $LabelsPerSheet = ($rec['is_custom'] == 'Yes')?$rec['LabelsPerRoll']:$CI->accountModel->LabelsPerSheet($rec['ProductID']);
			 }
			
			
			 $rows .='<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ManufacturerId.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ProductName.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$Quantity.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.symbol.number_format($UnitPrice*$exchange_rate,4).'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.symbol.number_format($PriceExVat*$exchange_rate,2,'.','').'</td>
				     </tr>';
					 
					 if($ManufacturerId=="PRL1"){
					   $result = $CI->quoteModel->get_details_roll_quotation($prl);
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
				 
				 $assoc = $CI->quoteModel->fetch_custom_die_association($custominfo['ID']);
				 
				  if($language=="fr"){
					  
					foreach($assoc as $rowp){  
					 $assmatername='';
					 $fr_printing = ($rowp->labeltype=="printed")?"imprimé":"plaine";
					 $materilaname_fr = $CI->quoteModel->get_mat_name_fr($rowp->material);
					 $assmatername.= $materilaname_fr.' - '.$rowp->labeltype.' etiquettes' ;
						  
						  ///********///////********///////********///////********////
						  if($rowp->labeltype=="printed"){  
						    
							if($rowp->printing=="Monochrome - Black Only" || $rowp->printing=="Mono"){
							  $fr_prnt_type = "Monochrome - Noir seulement";
							 }else{
							  $fr_prnt_type  = $CI->orderModel->get_db_column('digital_printing_process', 'name_fr', 'name',trim($rowp->printing));
							  $rowpprinting  = $CI->orderModel->ReplaceHtmlToString_($fr_prnt_type);
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
					 $materilaname_en = $CI->quoteModel->get_mat_name($rowp->material);
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
	  "[styleDeliveryConpnay]","[vatprice]","[pamentOrder]","[weborder]","[BillingResCom]","[DeliveryResCom]","[voucherDiscount]","[PONUMBER]","[VIEWLINK]");
  
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
		   
		   $di_ver = ($language=="en")?"Discount":"Remise";
		   $em_sub = ($language=="en")?"ORDER CONFIRMATION ":"CONFIRMATION DE COMMANDE"; 
		
           /*--------------------------Voucher Code--------------------*/
		 if($res['voucherOfferd']=='Yes'){
				$voucherDiscount =  $CI->reportsmodel->currecy_converter($res['voucherDiscount'],'no');
				$voucher_code = '<tr><td align="right">'.$di_ver.':</td><td style="color: #006da4; padding-left:10px;" align="right">'.symbol.$voucherDiscount.'</td></tr>';
			}
			else{
			  $voucherDiscount = 0.00;
			  $voucher_code = '';
			}
			
			    $gtotalIncVat = number_format($OrderTotalIncVAT - $voucherDiscount,2,'.','');
		       
			    if($websiteOrders != 'Website' && $res['vat_exempt']=='yes'){
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
	  $pamentOrder,$websiteOrders,$bill_rc,$del_rc,$voucher_code,$PONUMBER,$viewlink);
	  
	  $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
	  die($newPhrase);
			$CI->email->from('customercare@aalabels.com', 'AALABELS');
			$CI->email->to($EmailAddress); 
			$CI->email->subject($em_sub);
			$CI->email->message($newPhrase);
			$CI->email->set_mailtype("html");
			
		//if(($res['vat_exempt']=='no') and ($res['OrderStatus']==2 || $res['OrderStatus']==32)){
//			   $CI->email->send();
//			}

            // if($res['vat_exempt']=='no'){
			   $CI->email->send();
			//}
			
			if($res['OrderStatus']==2 || $res['OrderStatus']==32){
			   $res['OrderStatus'] = $this->check_printable_order($OrderNumber, $res['OrderStatus']);
			}
		
	 }
	 
	 function check_printable_order($ordernumber, $OrderStatus=NULL){
		$CI =& get_instance(); 
		$query = $CI->db->query(" select count(*) as total from orderdetails where OrderNumber LIKE '".$ordernumber."' AND Printing LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels' ");	
				$row = $query->row_array();
				if($row['total'] > 0){
					$CI->db->update('orders', array('OrderStatus'=>55), array('OrderNumber'=>$ordernumber));
					$OrderStatus =  55;
				}
				return $OrderStatus;
	}
	
	
	function menufacture($id){
        $CI =& get_instance();
		$query=$CI->db->query("select  ManufactureID from products  where ProductID='".$id."'");

		$res=$query->result();

		return $res;

	}
	
	//************************************-----ORDER EMAIL-------**************************************
	
	function order_pdf($order,$language,$type){
	     $CI =& get_instance();
		 if($type==0){ 
		  $page = ($language=="en")?"quotation/orderconfirm.php":"quotation/fr/orderconfirm.php"; }else{
		  $page = ($language=="en")?"quotation/orderhide.php":"quotation/fr/orderhide.php";
		 }
		//echo $page;exit;
		 $query = $CI->db->get_where('orders', array('OrderNumber' => $order));
		 $res = $query->result_array();
		 $res = $res[0];
	     
		 $data['type'] = $type;
		 $data['OrderInfo'] = $res; 
	     $data['OrderDetails'] = $CI->orderModel->OrderDetails($order);
		 
		 $CI->pdf->load_view($page,$data,TRUE);  
		 $CI->pdf->render();
		 $output = $CI->pdf->output();
		 $file_location = "pdf/orderconfirmation_".$order.".pdf";
		 $filename = $file_location;
		 $fp = fopen($filename, "a");
		 file_put_contents($file_location,$output);
		 $CI->pdf->stream("Order No : ".$order.".pdf");
		 
	}
	
	
	
	       //************************************-----QUOTATION EMAIL-------**************************************
	function quotation_pdf($QuotationNo,$language,$type){

	     $CI =& get_instance(); 
		 if($type=="show"){
		  $page = ($language=="en")?"quotation/quoteconfirm.php":"quotation/fr/quoteconfirm.php"; }
		  else{
		  $page = ($language=="en")?"quotation/quotehide.php":"quotation/fr/quotehide.php";
		 }
	     
		 $query = $CI->db->get_where('quotations', array('QuotationNumber' => $QuotationNo));
		 $res = $query->result_array();
		 $res = $res[0];
		 $data['type'] = $type;
		 $data['OrderInfo'] = $res; 
	     $data['OrderDetails'] = $CI->quoteModel->quoteDetails($QuotationNo);
		 
		 $CI->pdf->load_view($page,$data,TRUE);  
		 $CI->pdf->render();
		 $output = $CI->pdf->output();
		 $file_location = "pdf/QuoteConfirmation_".$QuotationNo.".pdf";
		 $filename = $file_location;
		 $fp = fopen($filename, "a");
		 file_put_contents($file_location,$output);
	}
	
	function quote_confirmation($QuotationNo){
	    $CI =& get_instance(); 
	   // error_reporting(E_ALL);
		$query = $CI->db->get_where('quotations', array('QuotationNumber' => $QuotationNo));
		$res = $query->result_array();
		$res = $res[0];
		$data['OrderInfo'] = $res;	
		$mailto = $res['Billingemail'];
		
		$language = ($res['site']=="" || $res['site']=="en")?"en":"fr"; 
	    $getfile = base_url().'system/libraries/'.$language.'/quote-confirmation.html';
	    $mailText = file_get_contents($getfile);
		
		$strINTemplate   = array("[FirstName]", "[quoteNumber]", "[OrderDate]", "[OrderTime]");
	    $strInDB  = array($res['BillingFirstName'], $QuotationNo, date("d.m.Y",$res['QuotationDate']), date("g:i A",$res['QuotationTime']));
	    $body = str_replace($strINTemplate, $strInDB, $mailText);
		
		             //*****-----*****-----*****-----****----ATTACHMENT PDF CODE*****-----*****-----*****-----****---- 
		 $this->quotation_pdf($QuotationNo,$language,'show');
		 $file_location = "pdf/QuoteConfirmation_".$QuotationNo.".pdf";
		 
		 $mailsubject = ($language=="en")?"QUOTATION CONFIRMATION  :".$QuotationNo:"CONFIRMATION DE QUOTATION:".$QuotationNo;
		 
		 $CI->email->initialize(array( 'mailtype' => 'html', ));
		 $CI->email->subject($mailsubject);
		 $CI->email->from('customercare@aalabels.com','aalabels');
		 $CI->email->to($mailto);
		 $CI->email->message($body);  
		 $CI->email->attach($file_location);
		 $CI->email->send();  
		 unlink($file_location);
	  
	}
	
	//************************************-----ARTWORK APPROVAL EMAIL-------**************************************
	
	function artwork_approval($ordernumber){ 
	   $CI =& get_instance(); 
	   $res = $CI->db->query("select * from orders where OrderNumber LIKE  '".$ordernumber."'")->row_array();

	  
	     $language = ($res['site']=="" || $res['site']=="en")?"en":"fr"; 
	     $subject =  ($language=="fr")?"DESIGN SOFT PROOF":"Artwork Approval"; 
		 $link = ($language=="fr")?base_url().'approbation-dauvres-dart/'.md5($ordernumber):base_url().'artwork-approval/'.md5($ordernumber); 
	    
	     $getfile = base_url().'system/libraries/'.$language.'/artwork-approval.html';
		 $mailText = file_get_contents($getfile);
	   
         $strINTemplate   = array("[FirstName]", "[orderNumber]", "[OrderDate]", "[OrderTime]", "[link]");
	     $strInDB  = array($res['BillingFirstName'], $ordernumber, date("d.m.y"),date("H:i"),$link);
	     $body = str_replace($strINTemplate, $strInDB, $mailText);
		
		 
		 $CI->email->initialize(array('mailtype' =>'html',));
		 $CI->email->subject($subject);
		 $CI->email->from('customercare@aalabels.com','Aalabels');
		 $CI->email->to($res['Billingemail']); 
		 $CI->email->message($body); 
		 $CI->email->send();
	}
	
	
	//************************************-----ARTWORK SUMMARY EMAIL-------**************************************
	
	 function get_all_artwork_jobs($order){
	   $CI =& get_instance();
	   $sql = $CI->db->query("select * from order_attachments_integrated WHERE OrderNumber LIKE '".$order."'")->result();
	   return $sql;
	  }
	  
	  function get_en_status_text($status,$version){
	     if($status == 64){
	        $status_text = ' PENDING APPROVAL ';
		 }else if($status == 65 && $version > 1){
		    $status_text = ' Customer Amendment requested. New Soft-Proof being produced.  ';
		 }else if($status == 65){
            $status_text = ' Customer soft-proof being produced by design studio ';
		 }else if($status == 68){
		    $status_text = ' Customer Approval received. Press-File in production ';
		 }else if($status == 70){
	       $status_text = ' Customer Approval received. Press-File in production ';
		 }
		return $status_text;
	  }
	  
	  function get_fr_status_text($status,$version){
	      if($status == 64){
	        $status_text = ' validation en attente ';
		  }else if($status == 65 && $version > 1){
		    $status_text = ' MODIFICATION NÉCESSAIRE  ';
		  }else if($status == 65){
            $status_text = ' ATTENDRE SOFTPROOF ';
		  }else if($status == 68){
		    $status_text = ' AVERTISSEMENT IMPRIMER LE FICHIER ';
		  }else if($status == 70){
	       $status_text = ' APPROUVÉ POUR IMPRIMER  ';
		 }
		return $status_text;
	  }
	  
	function artwork_summary($ordernumber){
	 $CI =& get_instance();  
	 $res = $CI->db->query("select * from orders where OrderNumber LIKE '".$ordernumber."'")->row_array();
	 $language = ($res['site']=="" || $res['site']=="en")?"en":"fr"; 
	 
	 $getfile = base_url().'system/libraries/'.$language.'/artwork-summary.html';
	 $mailText = file_get_contents($getfile);
	 
	 $result = $this->get_all_artwork_jobs($ordernumber);
	 $table=""; $i=0;
	 
	       foreach($result as $row){
			   $i++;
			   $status_text = ($res['site']=="" || $res['site']=="en")?$this->get_en_status_text($row->status,$row->version):$this->get_fr_status_text($row->status,$row->version);
			    
		      $table.= '<tr>
						<td style="padding:3px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$i.'</td>
						<td style="padding:3px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$row->name.' 01</td>
						<td style="padding:3px; font-family:Arial; font-size:12px; color: #333;" align="center">PJ'.$row->ID.'</td>
						<td style="padding:3px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$row->labels.'</td>
						<td style="padding:3px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$row->qty.'</td>
						<td style="padding:3px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$status_text.'</td>
					  </tr>
					  ';
		       }
	   
	     $strINTemplate   = array("[FirstName]", "[orderNumber]", "[OrderDate]", "[OrderTime]", "[details]");
	     $strInDB  = array($res['BillingFirstName'], $ordernumber, date("d.m.y"),date("H:i"),$table);
	     $body = str_replace($strINTemplate, $strInDB, $mailText);
	     $subject =  ($language=="fr")?"Resume de leuvre":"Artwork Summary"; 
		 
		 $CI->email->initialize(array('mailtype' =>'html',));
		 $CI->email->subject($subject);
		 $CI->email->from('customercare@aalabels.com','Aalabels');
		 $CI->email->to($res['Billingemail']); 
		 $CI->email->cc('customercare@aalabels.com');
		 $CI->email->bcc('kami.ramzan77@gmail.com');
		 $CI->email->message($body); 
		 $CI->email->send();
	}
	
	
     //************************************-----ARTWORK SUMMARY EMAIL-------**************************************
function send_activation_email($userid){ 
	   $CI =& get_instance(); 
	   $res = $CI->db->query("select * from customers where UserID = $userid ")->row_array();
       $subject =  "Registration Confirmation"; 
	   $getfile = $this->EPATH.'system/libraries/plo/account-activation.html';
	   $mailText = file_get_contents($getfile);
		
		 $strINTemplate = array("[FirstName]", "[EMAIL]", "[OrderDate]", "[OrderTime]");
		 $strInDB  = array($res['BillingFirstName'], $res['UserEmail'], date("d.m.y"),date("H:i"));
		 $body = str_replace($strINTemplate, $strInDB, $mailText);
		 
		 $CI->email->initialize(array('mailtype' =>'html',));
		 $CI->email->subject($subject);
		 $CI->email->from('customercare@aalabels.com','Aalabels');
		 $CI->email->to($res['Billingemail']); 
		 $CI->email->message($body);
		 $CI->email->send();
     }


 
}
// END CI_Email class
/* End of file Email.php */
/* Location: ./system/libraries/Email.php */