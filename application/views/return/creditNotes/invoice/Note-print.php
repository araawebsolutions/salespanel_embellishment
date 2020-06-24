<?php

//$segment1 = $this->uri->segment(1);
//$segment2 = $this->uri->segment(2);

?>
<style>
body {
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
tr {
	font-size:11px;
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
td {
	font-size:11px;
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
tr.table_blue_bar {
	background-color: #edf5ff;
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
tr.table_white_bar {
	background-color: #ffffff;
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
.invoicetable_PCode_loop {
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 100px;
}
.invoicetable_description_loop {
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 60%;
}
.invoicetable_sml_headings_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 70px;
}
.invoicetable_Qty_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 35px;
}
.line_total_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 0 5px 10px;
	text-align: left;
	width: 70px;
}
.invoicetable_PCode {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 100px;
	color:#fff;
}
.invoicetable_description {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 60%;
	color:#fff;
}
.invoicetable_sml_headings {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 70px;
	color:#fff;
}
.invoicetable_Qty {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 35px;
	color:#fff;
}
.invuice_subtotal {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	padding: 5px 10px 5px 0;
	text-align: right;
}
.invuice_subtotal_price {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	padding: 5px 0 5px 10px;
	text-align: left;
}
</style>

<table width="750px" border="0" cellspacing="10" style="margin-left:-5px;">
    <tr>
        <td width="30%">  
            <? if($OrderInfo[0]->Domain=="PLO"){?>  
                          
            <img src="<?php echo base_url();?>theme/assets/images/logo.png" border="0" width="200" height="70" />.
            <? }else{?>
            <img src="<?php echo base_url();?>theme/assets/images/logo.png" border="0" width="200" height="70" />
            <? } ?>  
        </td>
    
        <td width="30%">&nbsp;</td>
        <td width="30%" align="left" valign="middle"><h3 style="color:#999999;">
            <?php
            //$invoice = $this->notemodel->getinvoicenumber($OrderInfo[0]->OrderNumber);
            echo '<font color="red"> Credit Note :  '.$invoice. '</font>';
            ?>
            </h3>
        </td>
    </tr>
    <tr>
        <? if($OrderInfo[0]->Domain=="PLO"){?>  
        <td align="left" valign="top" class="print_address"> Printed Labels Online,</br>
    <?php }else{ ?>
    <td align="left" valign="top" class="print_address"> AA Labels,</br>
<?php } ?>
23 Wainman Road,</br>
Peterborough,</br>
PE2 7BU </td>
<td align="right" valign="top"><table width="100%" border="0">
    <tr>
        <td align="right" class="print_address">Phone: </td>
    </tr>
    <tr>
        <td align="right" valign="top" class="print_address">Email: </td>
    </tr>
    <tr>
        <td align="right" valign="top" class="print_address">VAT No: </td>
    </tr>
    </table></td>
<td align="left" valign="top">
    
    <table width="100%" border="0">
        <tr>
            <td align="left" class="print_address"><span class="phone_right">
                <? if($OrderInfo[0]->Domain=="PLO"){ echo PLOPHONE; ?>
                <? }else{ ?> 01733 588 390 <? } ?> 
                </span></td>
        </tr>
        <tr>
            <td align="left" valign="top" class="print_address"><span class="phone_right">
                <? if($OrderInfo[0]->Domain=="PLO"){?>  
                <a href="customercare@printedlabelsonline.com" style="text-decoration:none; color:#000000;">customercare@printedlabelsonline.com</a>
                <?php }else{ ?>
                <a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#000000;">customercare@aalabels.com</a>
                <?php } ?>
                </span></td>
        </tr>
        <tr>
            <td align="left" valign="top" class="print_address"><span class="phone_right">GB 945 028 620</span></td>
        </tr>
    </table>
</td>
</tr>
<tr>
    <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;">Invoice Information</h3></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="padding-top:10px;"><table width="100%" border="0" cellspacing="3" cellpadding="0">
                    
                    <tr>
                        <td class="print_address"><b>Invoice Number:</b></td>
                        <td class="print_address"><?php echo $invoice;   ?></td>
                    </tr>
              
                    <?php 
                    $note =$note[0];
                    $all_orderno = $note->all_orderno;
                                        
                    $all_orderno = explode(',',$all_orderno);
                    $all_orderno = implode(' , ',$all_orderno);
                    ?>
              
                    <tr>
                  <td class="print_address"><b>Order Number:</b></td>
                  <td class="print_address"><?php echo $all_orderno;   ?></td>
                    </tr>
              
                    <tr>
                        <td class="print_address"><b>Date:</b></td>
                        <td class="print_address"><?php echo date('jS F Y', $OrderInfo[0]->OrderDate); ?></td>
                    </tr>
                    <tr>
                        <td class="print_address"><b>Time:</b></td>
                        <td class="print_address"><?php echo date('h:i:s A', $OrderInfo[0]->OrderTime); ?></td>
                    </tr>
           
                    </table>
                </td>
            </tr>
        </table>
    </td>
    
    <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;">
        <table width="100%" border="0"     cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;">Billing address</h3></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="padding-top:10px; padding-left:5px;">
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingCompanyName?>
                    </div>
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingFirstName.' '.$OrderInfo[0]->BillingLastName?>
                    </div>
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingAddress1?>
                    </div>
                    <? 
                    if($OrderInfo[0]->BillingAddress2){?>
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingAddress2?>
                    </div>
                    <? } ?>
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingTownCity?>
                    </div>
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingCountyState?>
                    </div>
                    <div class="print_address">
                        <?=$OrderInfo[0]->BillingPostcode?>
                    </div>
            
            
                    <div class="print_address">
                        <?=$OrderInfo[0]->Billingtelephone?>
                    </div>
                    <div class="print_address">
                        <?=$OrderInfo[0]->Billingfax?>
                    </div>
                    <div class="print_address">
                        <?=$OrderInfo[0]->Billingemail?>
                    </div>
                    <div class="print_address">
                        <?
                        if($OrderInfo[0]->BillingResCom == 1)
                        {
                            echo "Residential";
                        }
                        else
                        {
                            echo "Commercial";
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </td>
    <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0"     cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3   style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;"><span style="white-space:nowrap;">Delivery address</span></h3></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="padding-top:10px; padding-left:5px;"><div class="print_address">
                <?=$OrderInfo[0]->DeliveryCompanyName?>
                </div>
                <div class="print_address">
                    <?=$OrderInfo[0]->DeliveryFirstName.' '.$OrderInfo[0]->DeliveryLastName?>
                </div>
                <div class="print_address">
                <?=$OrderInfo[0]->DeliveryAddress1?>
                </div>
                <? if($OrderInfo[0]->DeliveryAddress2){?>
                <div class="print_address">
                    <?=$OrderInfo[0]->DeliveryAddress2?>
                </div>
                <? } ?>
                <div class="print_address">
                    <?=$OrderInfo[0]->DeliveryTownCity?>
                </div>
                <div class="print_address">
                    <?=$OrderInfo[0]->DeliveryCountyState?>
                </div>
                <div class="print_address">
                    <?=$OrderInfo[0]->DeliveryPostcode?>
                </div>
                
                <div class="print_address">
                    <?=$OrderInfo[0]->DeliveryTownCity?>
                </div>
                <div class="print_address">
                    <?=$OrderInfo[0]->Deliverytelephone?>
                </div>
                <div class="print_address">
                    <?=$OrderInfo[0]->Deliveryfax?>
                </div>
                <div class="print_address">
                <?=$OrderInfo[0]->Billingemail?>
                </div>
                <div class="print_address">
                    <?
                if($OrderInfo[0]->DeliveryResCom == 1)
                {
                    echo "Residential";
                }
                    else
                    {
                        echo "Commercial";
                    }
                    ?>
                </div>
            </td>
        </tr>
        </table>
    </td>
</tr>

<tr>
    <td colspan="3" align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="1043px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="invoicetable_PCode">Product Code</td>
          <td class="invoicetable_description">Description</td>
          <td class="invoicetable_sml_headings">Unit Price</td>
          <td class="invoicetable_Qty">Qty</td>
          <td class="invoicetable_sml_headings" style="padding:5px 0 5px 10px; text-align:left;">Line total</td>
        </tr>
        <?php
        $exvat=0;
        $incvat=0;
        $exVatPrice = 0;
        $incVatPrice = 0;
        $currencySymbol = "&pound;";
        //echo '<pre>'; print_r($noteDetails); echo '</pre>'; 
            
        $i = 0;
        $dis = '0.00';   
        foreach ($noteDetails as $key => $notes) {
            
          //echo $notes->OrderNumber;
            $this->db->select('OrderTotal,voucherOfferd,voucherDiscount');
            $ords =     $this->db->get_where('orders',array('OrderNumber'=>$notes->OrderNumber))->result();
            
            //echo '<pre>';print_r($ords); echo '</pre>';
            
            foreach($ords as $oo){
                //for($i=0;$i<count($ords);$i++){
                //echo $i;
               
                $this->db->select('SerialNumber,ProductTotal');
                $ordsdete = $this->db->get_where('orderdetails',array('OrderNumber'=>$notes->OrderNumber))->result_array();
                                            
               if($oo->voucherOfferd=='Yes'){
                                                  
                   foreach($ordsdete as $od){
                       if($notes->SerialNumber == $od['SerialNumber']){
                                                         
                           $total_amount = number_format($oo->OrderTotal+$oo->voucherDiscount,2,'.',''); 
                                                        
                           $disPer = number_format(100-($oo->OrderTotal/$total_amount*100),2,'.',''); 
                                                            
                           $calculateDis = number_format(($od['ProductTotal']*$disPer/100),2,'.','');          
                       }
                   }
                   $dis += $calculateDis;
               }
               
                }
             
		       	if($i%2==0)
				{
					$css="class='table_blue_bar'";
				}
				else
				{
					$css="class='table_white_bar'";
				}
				
               
           
               $currency = $note->currency;
               if($currency=='EUR'){
                   $symbol = '&pound;';
               }else if($currency=='USD'){
                   $symbol = '$;';
               }else{
                   $symbol ='&pound;';
               } 
				
                   //$Order->currency       = (isset($quotationDetail->currency) && $quotationDetail->currency!='')?$quotationDetail->currency:'GBP';
               
				  $exchange_rate         = (isset($notes->exchange_rate) && $notes->exchange_rate!=0)?$notes->exchange_rate:1;
               
				  // $symbol                = $this->reportsmodel->get_currecy_symbol($OrderInfo[0]->currency);

            $symbol                = $this->creditNotes_model->get_currecy_symbol($OrderInfo[0]->currency);
               
				   
               
               
             	if($notes->ProductID == 0)
				{

					$ManufactureID=$notes->ManufactureID;
					$productName=$notes->ProductName;
					$Price=$notes->Price;
					$Quantity=$notes->Quantity;
					$Btndisplays='display:inline;';
					
				}
				else
				{
                    $CI =& get_instance();
                    $CI->load->model('return/creditNotes_model');

					$ManufactureID= $CI->creditNotes_model->manufactureid("",$notes->ProductID);
					$productName=$notes->ProductName;
					$Price=$notes->Price;
					$Quantity=$notes->Quantity;
					$Btndisplays='display:none;';
					
				}

               if($notes->Quantity!=0)
               {
		       ?>
                 
                  
        <tr>
            <td class="invoicetable_PCode_loop"><?=$ManufactureID?></td>
            <td class="invoicetable_description_loop"><?php    //$productname  = $OrderDetails[$i]->ProductName; 
                   $productname =  $this->creditNotes_model->ReplaceHtmlToString_($notes->ProductName); echo $productname; ?>
          
                <? if($ManufactureID=="SCO1"){
                   $custominfo = $this->creditNotes_model->fetch_custom_die_order($notes->SerialNumber); 
                ?>
 		    for <?php if($custominfo['format'] == 'Roll'){echo $custominfo['format'].' Labels';}else{echo $custominfo['format'].' Sheets';}?> <?=$custominfo['width']?><? if($custominfo['shape']!="Circle"){?>x<?=$custominfo['height']?><? } ?>  mm <?php if($custominfo['shape'] != ''){echo $custominfo['shape'].',';}?>  <? if($custominfo['format']=="Roll"){?>Leading Edge <?=$custominfo['width']?> mm, <? } ?> Corner radius <?=$custominfo['cornerradius']?> mm
            
   <? } ?>
          
          </td>
          <td class="invoicetable_sml_headings_loop">&pound;
            <?=round($Price/$Quantity,4)?></td>
          <td class="invoicetable_Qty_loop"><?=$Quantity?></td>
          
          <td class="line_total_loop">
              <?php
                   if(@$notes->PaymentMethods == 'SampleOrder'){
                       $exvat ='0.00';
                   }
                   else{
                       $exvat = $notes->Price;
                   }
              ?>
              <?  echo $symbol."".(number_format($exvat*$exchange_rate,2));?>      
            </td>
          
        </tr>
                     <?php
                     $incvat = number_format($exvat*vat_rate,'2','.','');
					   
					 $stylo = "";
					if($notes->Printing=="Y"){}else{
						$stylo = "style='display:none;'";
					}
                    ?>
                    
                    
        <tr <?=$stylo?>>
            <td class="invoicetable_PCode_loop"></td>
          
            <?php $print_style='font-size: 8px;'; $AccountDetail = $notes; include('print_line_txt.php'); ?>
          
            <td class="invoicetable_sml_headings_loop">&pound;<? echo $price=number_format($notes->Print_UnitPrice,3,'.',''); ?></td>
            <td class="invoicetable_Qty_loop"><?php echo $notes->Print_Qty; ?></td>
          
            <td class="line_total_loop">
                <?  $print_exvat = $notes->Print_Total;
                   $print_incvat = $notes->Print_Total*1.2;
                   $print_incvat = $notes->Print_Total*1.2;
                ?>
                <?  echo $symbol."".(number_format($print_exvat*$exchange_rate,2));?>     
            </td>
          
          
        </tr>
        <? $stylo_prl = "";
                   if($ManufactureID=="PRL1"){
                       $result = $this->creditNotes_model->get_details_roll_quotation($notes->Prl_id); 
                   }else{
                       $stylo_prl = "style='display:none;'";	
                   }
        ?>
                    
        <tr <?=$stylo_prl?>>
          <td class="invoicetable_PCode_loop"></td>
          <td class="invoicetable_description_loop"><b>Shape:</b>
            <?=$result['shape']?>
            &nbsp;&nbsp; <b>Size:</b>
            <?=$result['size']?>
            &nbsp;&nbsp; <b>Material:</b>
            <?=$result['material']?>
            &nbsp;&nbsp; <b>Printing:</b>
            <?=$result['printing']?>
            &nbsp;&nbsp; <b>Finishing:</b>
            <?=$result['finishing']?>
            &nbsp;&nbsp; <b>No. Designs:</b>
            <?=$result['no_designs']?>
            &nbsp;&nbsp; <b>No. Rolls:</b>
            <?=$result['no_rolls']?>
            &nbsp;&nbsp; <b>No. labels:</b>
            <?=$result['no_labels']?>
            &nbsp;&nbsp; <b>Core Size:</b>
            <?=$result['coresize']." mm"?>
            &nbsp;&nbsp; <b>Wound:</b>
            <?=$result['wound']?>
            &nbsp;&nbsp;<b>Notes:</b>
            <?=$result['notes']?>
            &nbsp;&nbsp; </td>
          <td class="invoicetable_sml_headings_loop"></td>
          <td class="invoicetable_Qty_loop"></td>
          <td class="line_total_loop"></td>
        </tr>
        
        <tr style="border:1px solid;">
          <td class="invoicetable_PCode_loop"></td>
          <td class="invoicetable_description_loop"></td>
          <td class="invoicetable_sml_headings" style="padding:0px !important;"><div><b>Line Total :</b></div></td>
          <td class="invoicetable_Qty"><div></td>
          <td class="invoicetable_sml_headings" style="padding:5px 0 5px 10px; text-align:left;"><div>
          <? $linetotalexvat = $print_exvat + $exvat;
		     echo $symbol."".(number_format($linetotalexvat*$exchange_rate,2));
		  ?>
           
           </div>
           </td>
          <? $linetotalinvat = $print_incvat + $incvat;?>
        </tr>
        <?   
                   $exVatPrice += $linetotalexvat;
                   $incVatPrice += $linetotalinvat;

               }
          
            $i++;
        }
        
     
        if($oo->voucherOfferd=='Yes'){
            $discount = $oo->voucherDiscount;
        }else {
            if($notes->DiscountInPounds != 0.00){
                $discount = $notes->DiscountInPounds;
            }else{
		  		
                $discount = 0.00;   
            }
        }
	   	
		

        $vatRate = vat_rate;

        $exdelivery = number_format($notes->OrderShippingAmount/$vatRate,2,'.','');

        $deliveryExVatAmount = $notes->OrderShippingAmount - $exdelivery;
		   
        $ship_invat = number_format($notes->OrderShippingAmount,2,'.','');
        $gt_invat = number_format($ship_invat+$incVatPrice,2,'.','');

	       ?>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2" class="invuice_subtotal">Delivery:</td>
          <? $exdelivery = number_format($notes->OrderShippingAmount/$vatRate,2,'.','');?>
          <td class="invuice_subtotal_price"><?=$symbol."".number_format($exdelivery*$exchange_rate,2,'.','');?></td>
        </tr>
        
        
        
        
        
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2"  class="invuice_subtotal">Grand Credit Total(ExVAT):</td>
          <td class="invuice_subtotal_price">
            <?php
                  if($notes->PaymentMethods=='SampleOrder'){
					 	   $SubTotal ='0.00';
					 	    $SubTotal ;
				  }
                  else{
            	  $SubTotal = number_format($exVatPrice+$exdelivery,2,'.','');
                 }?>
            <? echo $symbol."".number_format($SubTotal*$exchange_rate,2,'.','');?>     
          </td>
        </tr>
        



        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2"  class="invuice_subtotal">VAT @ (20.00)%</td>
          <td class="invuice_subtotal_price">
                <? 
				if($notes->vat_exempt=='yes'){
				$vat = 0.00;
				}else{
				$vat = number_format(( $gt_invat - $SubTotal),2,'.','');
				}
			    echo $symbol."".number_format($vat*$exchange_rate,2,'.','');
				?>     
		</td>
        </tr>
      
        <?php
        $discount_applied_in = $dis;
        $discount_applied_ex = $dis/1.2;
                                                
                                 
        
        $discountIn=number_format($discount_applied_in,2,'.','');
        $discountEx=number_format($discount_applied_ex,2,'.','');
                                             
        //$grandPrice = number_format($grandPrice - $discountEx,2,'.','');
        //$grandPrice2 = number_format($grandPrice2 - $discountIn,2,'.','');
                                        ?>                 
            
            
            
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2" class="invuice_subtotal">Discount:</td>
            <td class="invuice_subtotal_price">
                
                <?php if($notes->vat_exempt=='yes'){?>
                <?=$symbol."".number_format($discountEx*$exchange_rate,2);?>
                <?php } else{?>
                <?=$symbol."".number_format($discountIn*$exchange_rate,2);?>
                <?php } ?>
            
            </td>
        </tr>
        
        
        
        <?php
        if($notes->DiscountInPounds=='0.00'){
            $incVat = number_format($incVatPrice,2,'.','');
            
             if($notes->vat_exempt=='yes'){
                    $show_price_incvat = number_format(($gt_invat-$discountEx),2,'.','');
             } else{
                 $show_price_incvat = number_format(($gt_invat-$discountIn),2,'.','');
             } 
            
        }else{
            $incVat = number_format($incVatPrice,2,'.','');
            //$incVat = number_format($notes->DiscountedPrice,2,'.','');
            $show_price_incvat = $notes->DiscountedPrice;	
        }
        ?>
      
        <?
        if($notes->vat_exempt=='yes'){
            $show_price_incvat = $SubTotal;
        }
        ?>
      
       <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2" class="invuice_subtotal" style="color:red;"><b>Grand Credit Total(IncVAT):</b></td>
          <td class="invuice_subtotal_price" style="color:red;"><b> -
          <?=$symbol."".number_format($show_price_incvat*$exchange_rate,2);?>
          </b>
          </td>
       </tr>
       
       
       
       
      </table>
    
    </td>
  </tr>
</table>
<div class="adminsp_space"></div>
