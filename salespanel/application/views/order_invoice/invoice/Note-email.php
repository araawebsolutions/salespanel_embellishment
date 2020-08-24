<?php   



foreach ($OrderInfo as $Order) {
} 
?>
<style type="text/css">

body {
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
tr {
	font-size:14px;
	font-weight:bold;
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
td {
	font-size:14px;
	font-weight:bold;
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
</style><center>





<table cellspacing="0" cellpadding="0" width="980">
<tbody>
<tr>
<td>

<table width="100%">
<tbody>
</tbody>
</table>

<table width="980">
<tbody>

<tr>
      <td width="50%">  
      <? if($Order->Domain=="PLO"){?>
	    <img src="<?=PLOGO?>" border="0" width="200" height="70" />.
      <? }else{?>
        <img src="<?php echo base_url();?>saleoperator/images/logo_n.png" border="0" width="200" height="70" />
      <? } ?>  
    </td>
    
    <td width="50%"><img src="<?php echo base_url();?>saleoperator/images/logo_n.png" border="0" width="200" height="70" /></td>
   
    
   <td width="50%" style=" FONT-SIZE: 14px;color:red;" align="left"></td>
    <td width="50%" style=" FONT-SIZE: 14px;color:red;" align="left"><B>Credit Note:  <?php echo $invoice; ?></B></td>
</tr>



<tr>
<td align="left" valign="top" style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">

<table width="100%" border="0" cellspacing="0" cellpadding="2">

 
 <? if($Order->Domain=="PLO"){?> 
<tr>
<td align="left" style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">Printed Labels Online, 23 Wainman Road</td>
</tr>
<? }else{ ?>     
 <tr>
<td align="left" style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">AA Labels, 23 Wainman Road</td>
</tr>     
<? } ?>


<tr>
<td style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">Peterborough,</td>
</tr>
<tr>
<td style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">Cambs,</br></td>
</tr>
<tr>
<td style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px"> PE2 7BU,</td>
</tr>
<tr>
<td style=" FONT-SIZE: 12px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px">United Kingdom</td>
</tr>
</table>

</td>
<td align="right" valign="top">

<table width="100%" border="0">
<tr>
<td align="right" style=" FONT-SIZE: 12px;">Phone: </td>
</tr>
<!--<tr>
<td align="right" valign="top" style="FONT-SIZE:12px;">Fax: </td>
</tr>-->
<tr>
<td align="right" valign="top" style="FONT-SIZE:12px;">Email: </td>
</tr>
<tr>
<td align="right" valign="top" style="FONT-SIZE:12px;">VAT No: </td>
</tr>
</table></td>
<td align="left" valign="top"><table width="100%" border="0">
<tr>
<td align="left" style="FONT-SIZE:12px;">
   <? if($Order->Domain=="PLO"){ echo PLOPHONE; ?>
   <? }else{ ?> 01733 588 390 <? } ?> 
</td>
</tr>
<!--<tr>
<td align="left" valign="top" style="FONT-SIZE:12px;">01733 425 106 </td>
</tr>-->
<tr>
<td align="left" valign="top">

 <? if($Order->Domain=="PLO"){?>
   <a href="mailto:customercare@printedlabelsonline.com" style=" font-size:12px; text-decoration:none; color:#000000;">customercare@printedlabelsonline.com</a></td> 
  <? }else{ ?>  
   <a href="mailto:customercare@aalabels.com" style=" font-size:12px; text-decoration:none; color:#000000;">customercare@aalabels.com</a></td> 
 <? } ?>  
 
</tr>
<tr>
<td align="left" valign="top" style="FONT-SIZE:12px;">GB 945 0286 20</td>
</tr>
</table></td>
</tr>
<tr>
<td valign="top" align="left">

<table style="BORDER-RIGHT: #cccccc 1px solid; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; WIDTH: 320px; BORDER-BOTTOM: #cccccc 1px solid; HEIGHT: 	250px" cellspacing="0" cellpadding="0">
<tbody>


<tr style="BACKGROUND-COLOR:#17b1e3; height:25px; border-bottom:#CCCCCC 1px solid;">
<td style="FONT-WEIGHT: bold; FONT-SIZE: 14px;color:#fff !important;" align="center"  colspan="2">Invoice Information </td>
</tr>



<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 120px; PADDING-TOP: 0px; HEIGHT: 30px"><strong>Invoice Number:</strong></td>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 200px; PADDING-TOP: 0px; HEIGHT: 30px"><p>
<?php echo $invoice; ?></p></td>
</tr>



<tr>
<td width="120" nowrap style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 100px; PADDING-TOP: 0px; HEIGHT: 30px"><strong>Order Number:</strong></td>
<td width="210" style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 200px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->OrderNumber; ?></td>
</tr>


<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 120px; PADDING-TOP: 0px; HEIGHT: 30px"><strong>Time:</strong></td>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 200px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo date('h:i:s A', $Order->OrderTime); ?></td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 120px; PADDING-TOP: 0px; HEIGHT: 30px"><strong>Date:</strong></td>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH:200px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo date('jS F Y', $Order->OrderDate); ?></td>
</tr>
<tr style="height:30px">
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 120px; PADDING-TOP: 0px; HEIGHT: 30px"><strong> </strong></td>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; WIDTH: 200px; PADDING-TOP: 0px; HEIGHT: 30px">
 
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">

<table style="BORDER-RIGHT: #cccccc 1px solid; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; WIDTH: 320px; BORDER-BOTTOM: #cccccc 1px solid; HEIGHT: 250px" cellspacing="0" cellpadding="0">
<tbody>
<tr style="BACKGROUND-COLOR:#17b1e3; height:30px; border-bottom:#CCCCCC 1px solid;">
<td height="25" align="center" style="FONT-WEIGHT: bold; FONT-SIZE: 14px;color:#fff !important;">Billing Address </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->BillingTitle.' ' .$Order->BillingFirstName . ' ' . $Order->BillingLastName; ?>  </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->BillingCompanyName; ?>  </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->BillingAddress1.' '.$Order->BillingAddress2; ?></td>
</tr>
<tr>
<td style="PADDING-RIGHT:0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->BillingTownCity.' '.$Order->BillingCountyState; ?></td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"> <?php echo $Order->BillingPostcode; ?> </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->BillingCountry; ?> </td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">

<table style="BORDER-RIGHT: #cccccc 1px solid; BORDER-TOP: #cccccc 1px solid; BORDER-LEFT: #cccccc 1px solid; WIDTH: 320px; BORDER-BOTTOM: #cccccc 1px solid; HEIGHT: 250px" cellspacing="0" cellpadding="0">
<tbody>
<tr style="BACKGROUND-COLOR:#17b1e3; height:30px; border-bottom:#CCCCCC 1px solid;">
<td style="FONT-WEIGHT: bold; FONT-SIZE: 14px;color:#fff !important;" align="center">Delivery Address </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->DeliveryTitle.' '.$Order->DeliveryFirstName.' '.$Order->DeliveryLastName; ?></td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->DeliveryCompanyName; ?></td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"><?php echo $Order->DeliveryAddress1.' '.$Order->DeliveryAddress2; ?> </td>
</tr>
<tr>
<td style="PADDING-RIGHT:0px; PADDING-LEFT:10px; FONT-SIZE:11px; PADDING-BOTTOM:0px; PADDING-TOP: 0px; HEIGHT: 30px"> <?php echo $Order->DeliveryTownCity.' '.$Order->DeliveryCountyState; ?> </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"> <?php echo $Order->DeliveryPostcode; ?> </td>
</tr>
<tr>
<td style="PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px"> <?php echo $Order->DeliveryCountry; ?> </td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>
			
<table width="100%" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid;">
<tr style="BACKGROUND-COLOR:#17b1e3; height:30px;">
<td width="13%" style="PADDING-LEFT: 10px; FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid;color:#fff !important;"><b>Product Code</b></td>
<td width="56%" style="PADDING-LEFT: 10px; FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid;color:#fff !important;"><b>Description</b></td>
<td width="13%" style="text-align:center; FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid;color:#fff !important; border-left:#CCCCCC 1px solid;"><b>Unit Price</b></td>
<td width="8%" style="text-align:center; FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid;color:#fff !important; border-left:#CCCCCC 1px solid;"><b>Qty</b></td>
<td width="10%" align="center" style="FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid; color:#fff !important;border-left:#CCCCCC 1px solid;"><b>Line total</b></td>
</tr>
 <?php 
 
                   $Order->currency       = (isset($Order->currency) && $Order->currency!='')?$Order->currency:'GBP';
				   $Order->exchange_rate  = (isset($Order->exchange_rate) && $Order->exchange_rate!=0)?$Order->exchange_rate:1;
				   $symbol                = $this->orderModal->get_currecy_symbol($Order->currency); 
			 
                    $total_exvat=0;
                    $total_invat=0;
					$print_incvat=0;
					$print_exvat=0;
  
  
  foreach ($OrderDetails as $AccountDetail) {
                          
						if($AccountDetail->ProductID==0){
        $ManufactureID= $AccountDetail->ManufactureID;
      }else{
        $ManufactureID= $this->accountmodel->manufactureid($Order->Domain,$AccountDetail->ProductID);
      }
                      $serialNo = $AccountDetail->SerialNumber;
  ?>

<tr bgcolor="#f7faff" height="25">
 
 <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"><?php echo $ManufactureID; ?></td>
     
     
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
	      <?php $prod_name = $this->orderModal->ReplaceHtmlToString_($AccountDetail->ProductName);
	      echo $prod_name;
       
	   if($ManufactureID=="SCO1"){
		$custominfo = $this->quoteModel->fetch_custom_die_order($AccountDetail->SerialNumber); 
	?>
   -   <b>Format:</b>
      <?=$custominfo['format']?>&nbsp;&nbsp;  <b>Shape:</b> <?=$custominfo['shape']?>&nbsp;&nbsp; <b>Width:</b><?=$custominfo['width']?> mm
     <? if($custominfo['shape']!="Circle"){?>  
       &nbsp;&nbsp; <b>Height:</b> <?=$custominfo['height']?> mm&nbsp;&nbsp;
     <? } ?> 
               
     <b>No. labels / Die:</b> <?=$custominfo['labels']?> &nbsp;&nbsp; <b>Euro Die:</b><?=($custominfo['iseuro']==1)?"Yes":"No";?>
            
    <? } ?> 
          
          
    </td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
     
     <?php  $price = number_format($AccountDetail->Price/$AccountDetail->Quantity,3,'.',''); ?> 
     <?php echo $symbol."".number_format($price*$Order->exchange_rate,3,'.',''); ?> 
     
     </td>
                        <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
						<?php echo $AccountDetail->Quantity; ?></td>
                        
                        <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
                           <?php  $exvat = $AccountDetail->Price; ?>
                           <?php echo $symbol."".number_format($exvat*$Order->exchange_rate,2,'.',''); ?> 
                         </td>
                    

    </tr>
<?php   
$invat   = $exvat *1.2;
$exvat   = $exvat;
$incvat  = $invat;



$stylo = "";
//if($AccountDetail->Printing=="Y" && preg_match('/A4/is',$AccountDetail->ProductName)){
if($AccountDetail->Printing=="Y" ){?>


       <!-- -----------------------------------PRINTINT SHEETS HTML--------------------------------------------------->

      <tr bgcolor="#f7faff" height="25">
 
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
    
    
     <?php $print_style='text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;'; 
	 	   //include('print_line_txt.php'); ?>
           
           
     
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
    <?  $price = number_format($AccountDetail->Print_UnitPrice,2,'.',''); ?>
 <?php echo $symbol."".number_format($price*$Order->exchange_rate,2,'.',''); ?> 
     </td>
                        <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
						<?php echo $AccountDetail->Print_Qty; ?></td>
                        
                        
                        <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
                         <?  $print_exvat = $AccountDetail->Print_Total;?>
                         <? $print_incvat = $AccountDetail->Print_Total*1.2;?>
                         <?php echo $symbol."".number_format($print_exvat*$Order->exchange_rate,2,'.',''); ?> 

                        </td>
                    

    </tr>
<? } ?>
     <!-- -----------------------------------PRINTINT SHEETS HTML--------------------------------------------------->
<? $stylo_prl = "";
if($ManufactureID=="PRL1"){
$resultu = $this->quoteModel->get_details_roll_quotation($AccountDetail->Prl_id); ?>   
     
     
  <tr bgcolor="#f7faff" height="25">
 
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
	        <?=$resultu['shape']?>
            &nbsp;&nbsp; <b>Size:</b>
            <?=$resultu['size']?>
            &nbsp;&nbsp; <b>Material:</b>
            <?=$resultu['material']?>
            &nbsp;&nbsp; <b>Printing:</b>
            <?=$resultu['printing']?>
            &nbsp;&nbsp; <b>Finishing:</b>
            <?=$resultu['finishing']?>
            &nbsp;&nbsp; <b>No. Designs:</b>
            <?=$resultu['no_designs']?>
            &nbsp;&nbsp; <b>No. Rolls:</b>
            <?=$resultu['no_rolls']?>
            &nbsp;&nbsp; <b>No. labels:</b>
            <?=$resultu['no_labels']?>
            &nbsp;&nbsp; <b>Core Size:</b>
            <?=$resultu['coresize']." mm"?>
            &nbsp;&nbsp; <b>Wound:</b>
            <?=$resultu['wound']?>
            &nbsp;&nbsp;<b>Notes:</b>
            <?=$resultu['notes']?>
            &nbsp;&nbsp; 
     </td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
                    
  </tr>    
 <? } ?>    
      
      <!-- -----------------------------------PRINTINT SHEETS HTML--------------------------------------------------->
      
      
      <tr bgcolor="#f7faff" height="25">
 
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;color:#17b1e3"><b>Line Total :</b></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;"></td>
     <td style="text-align:center; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;color:#17b1e3">
	 <? $linetotalexvat = $print_exvat  + $exvat; ?>
     <?php echo $symbol."".number_format($linetotalexvat*$Order->exchange_rate,2,'.',''); ?> 
     </td>
     <? $linetotalinvat = $print_incvat + $incvat;?>                  

    </tr>
      
                                    <?   
			         		        $total_exvat += $linetotalexvat;
		                            $total_invat += $linetotalinvat;
									$print_exvat=0;
									$print_incvat=0;
								}	?>
      
      
      
       <!-- -----------------------------------PRINTINT SHEETS HTML--------------------------------------------------->
      
      
      
 
<tr height="40px;">
<td colspan="2">&nbsp;</td>

<td align="right" colspan="2" style="PADDING-RIGHT:10px; FONT-SIZE:14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">Delivery:</td>

<td align="center" style="FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
<?php $ship_exvat = number_format($Order->OrderShippingAmount/vat_rate,2,'.',''); ?>
<?php echo $symbol."".number_format($ship_exvat*$Order->exchange_rate,2,'.',''); ?> 
</td>

</tr><?php  $ship_invat = number_format($Order->OrderShippingAmount,2,'.',''); ?>


<tr height="40px;">
<td colspan="2">&nbsp;</td>
<td align="right" colspan="2"  style="PADDING-RIGHT:10px; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">Grand Total(ExVAT):</td>
<td align="center"  style="FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
<?php $gt_exvat = number_format($ship_exvat+$total_exvat,2,'.','');  ?>
<?php echo $symbol."".number_format($gt_exvat*$Order->exchange_rate,2,'.',''); ?> 
</td>
</tr><?php $gt_invat = number_format($ship_invat+$total_invat,2,'.','');?>


<tr height="40px;">
<td colspan="2">&nbsp;</td>
<td align="right" colspan="2" style="PADDING-RIGHT:10px; FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">VAT @ 20.00%</td>
<td align="center" style="FONT-SIZE: 14px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">
<?php 
if($Order->vat_exempt=='yes'){
$gt_vat=0.00;
}else{
$gt_vat=number_format($gt_invat-$gt_exvat,2,'.','');
}
 echo $symbol."".number_format($gt_vat*$Order->exchange_rate,2,'.',''); ?> 
</td>
</tr>



<!--[voucherDiscount] -->
<? 
if($Order->voucherOfferd=='Yes'){
			$voucherDiscount = $Order->voucherDiscount;
			echo  '<tr height="20px;"><td colspan="2">&nbsp;</td><td align="right" colspan="2" bgcolor="#edf5ff"  style="PADDING-RIGHT:10px; FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">Voucher Discount: </td> <td bgcolor="#edf5ff" align="center" style="FONT-SIZE: 12px; border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid;">'.$symbol." ".number_format($voucherDiscount*$Order->exchange_rate,2).'</td></tr>';
		}
		else{
			 $voucherDiscount = 0.00;
			 $voucher_code ='';
		}
?>


<!--[voucherDiscount] -->
<tr height="40px;">
<td colspan="2" align="right" style="PADDING-RIGHT:10px; FONT-SIZE: 14px;"><strong> </strong></td>
<td align="right" colspan="2" style="PADDING-RIGHT:10px; FONT-SIZE: 14px; border-left:#CCCCCC 1px solid;color:red;"><b>Grand Credit Total(Inc VAT):</b></td>
<td align="center" style="FONT-SIZE: 14px; border-left:#CCCCCC 1px solid;color:red;"><b> -
 <?php 
 if($Order->vat_exempt=='yes'){
 $gct = $gt_exvat - $voucherDiscount ;	 
 }else{
 $gct = $gt_invat - $voucherDiscount ;
 }
  echo $symbol."".number_format($gct*$Order->exchange_rate,2,'.',''); ?> 
  </b></td>
</tr>
</table>
			
<!--[OrderItems]-->

</td>
</tr>
</tbody>
</table>
</center>