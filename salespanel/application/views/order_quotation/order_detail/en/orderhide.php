<?php
//error_reporting(1);
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

?>


<style>



body{
font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
}
tr {
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
}
td {
font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
	font-size:11px;
     
}
tr.table_blue_bar {
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
tr.table_white_bar {
	background-color: #F0F0F0;
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
.invoicetable_PCode_loop {
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 10%px;
}
.invoicetable_description_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 80%;
}
.invoicetable_sml_headings_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 15%;
}
.invoicetable_Qty_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 10%;
}
.line_total_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 0 5px 5px;
	text-align: center;
	width: 70px;
}
.invoicetable_PCode {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 15%;
      color:#fff;
}
.invoicetable_description {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 50%;color:#fff;
}
.invoicetable_sml_headings {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 15%;color:#fff;
}
.invoicetable_Qty {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 10%;color:#fff;
}
.invoicetable_Qty22 {
	background-color:#17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	width: 4%;
}
.invoicetable_sml_headings2 {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 15%;
}
.invoicetable_Qty2 {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 10%;
}
.invuice_subtotal {
	border-bottom: 1px solid #cccccc;
	border: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 10px 5px 5px;
	text-align: left;
}
.invuice_subtotal_price {
	border-bottom: 1px solid #cccccc;
	border: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 0 5px 5px;
	text-align: left;
}


.invoicetable_bgBlue {
	background-color: #17b1e3;
	border-right: 1px solid #cccccc;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
    color:#fff;
}

.invoicetable_tabel_border {
	border-bottom: 1px solid #cccccc;
	border-right: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
}


</style>


<table width="100%" align="center" border="0" cellspacing="0">
  <tr>
    <td>
     <? if($OrderInfo['Domain']=="PLO"){?>
	    <img src="<?=PLOGO?>" border="0" width="160" height="66" />.
      <? }else{?>
      
        <img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/theme/site/images/logo.png" border="0" width="160" height="66" />
      <? } ?> 
    </td>
    <td width="30%" align="left" valign="middle"><?php
    	
			echo "<strong  style='margin-left:50px;'>Order Number  :</strong> ";
			echo'<font color="#000000"> '.$OrderInfo['OrderNumber'].'</font>';
		    ?>
        </td>
  </tr>
  
  </table>
  
  <br></br>
  
  
  
  
<table width="100%" align="center" border="0" cellspacing="0" >


  <tr>
    <td align="left" valign="top" class="print_address" width="50%">
    
    
    <!-- ------------------------------------->
      <table width="100%" border="0">
        <tr>
          <td align="left" class="print_address">AA Labels, </td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address">Trading name of Green Technologies Ltd.</td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address">23 Wainman Road, Peterborough, PE2 7BU</td>
        </tr>
      
      </table>
      
      <!-- ------------------------------------->
      
     </td>


    <td align="left" valign="top" width="50%">
    
    <table width="100%" border="0">
        <tr>
          <td align="left" class="print_address"><strong style="margin-left:80px;">Phone: </strong></td>
          <td align="left" class="print_address"><span class="phone_right">
           <? if($OrderInfo['Domain']=="PLO"){ echo PLOPHONE; ?>
           <? }else{ ?> 01733 588 390 <? } ?> 
          </span></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">Email: </strong></td>
          <td align="left" valign="top" class="print_address">
            <span class="phone_right">
            <? if($OrderInfo['Domain']=="PLO"){?>  
            <a href="mailto:customercare@printedlabelsonline.com" style="text-decoration:none; color:#257cac;">customercare@printedlabelsonline.com</a>
            <? }else{ ?> 
            <a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#257cac;">customercare@aalabels.com</a>
            <? } ?>    
              </span>
      </td>
      </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">VAT No: </strong></td>
          <td align="left" valign="top" class="print_address"><span class="phone_right">GB 945 028 620</span></td>
        </tr>
      </table>
      </td>
    
      
      </table>
      
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:10px;">
    <tr>
    <td align="left" valign="top" style="padding-bottom:10px;" width="60%">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" style="line-height:5px;height:20px">
            <h3 style="padding-top:30px; white-space:nowrap;color:#17b1e3;">Delivery  address</h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:5px;">
            <table width="50%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="print_address"><b>Order Number:</b></td>
                <td class="print_address"><?=$OrderInfo['OrderNumber']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Date :</b></td>
                <td class="print_address"><?php echo date('jS F Y', $OrderInfo['OrderDate']); ?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Time:</b></td>
                <td class="print_address"><?php echo date('h:i:s A', $OrderInfo['OrderTime']); ?></td>
              </tr>
               <tr>
                <td class="print_address"><b>Status:</b></td>
                <td class="print_address"><?php 
                   $status= $this->home_model->getstatus($OrderInfo['OrderStatus']);
                   echo $status[0]->StatusTitle;
           ?></td>
              </tr>
              
              
            </table></td>
        </tr>
      </table>
      </td>
<td width="40%">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:10px; padding-left: 10px;"> 


<tr>
    <td align="left" valign="top" style="padding-bottom:10px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" style="line-height:5px;height:20px"><h3 style="padding-top:30px; white-space:nowrap;color:#17b1e3;">Delivery address</h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:5px;">
            <table width="80%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="print_address"><b>Company:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryCompanyName']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Name :</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryFirstName'].' '.$OrderInfo['DeliveryLastName']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Email:</b></td>
                <td class="print_address"><?php echo date('h:i:s A', $OrderInfo['QuotationTime']); ?></td>
              </tr>
               <tr>
                <td class="print_address"><b>City:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryTownCity']?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Country:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryCountyState']?></td>
              </tr>
               <tr>
                <td class="print_address"><b>Postcode:</b></td>
                <td class="print_address"><?=$OrderInfo['DeliveryPostcode']?></td>
              </tr>
               <tr>
                <td class="print_address"><b>Telephone:</b></td>
                <td class="print_address"><?=$OrderInfo['Deliverytelephone']?></td>
              </tr>
              
            </table>
          </td>
        </tr>
      </table></td>
    
     
  </tr>
 </table>
      
      
      </td>
  </tr>
     </table> 
      

  
                   <!-- -------------------------------------------->

                  
    
   <table width="100%"  bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:0px;">
   <tr>
    <td class="invoicetable_bgBlue" width="15%">Product Code</td>
    <td class="invoicetable_bgBlue" width="55%">Description</td>
  </tr>
   
 
         <?php
       		 $total_exvat = 0;
             $total_invat = 0;
			 $i = 0;
		foreach ($OrderDetails as $AccountDetail) {
			
			if($i%2==0)
				{
					$css="class='table_blue_bar'";
				}
				else
				{
					$css="class='table_white_bar'";
				}
			
				 $LabelsPerSheet = 1;
				 $colorcode = (isset($AccountDetail->colorcode) and $AccountDetail->colorcode!='')?'-'.$AccountDetail->colorcode:'';
					 
					 	
				if($AccountDetail->ProductID==0){
					$ManufactureID= $AccountDetail->ManufactureID;
				}else{
					 $ManufactureID= $this->home_model->manufactureid("",$AccountDetail->ProductID);
				 	$LabelsPerSheet= $this->home_model->LabelsPerSheet($AccountDetail->ProductID);
				 	if(isset($AccountDetail->is_custom) and $AccountDetail->is_custom=='Yes'){
						$LabelsPerSheet = $AccountDetail->LabelsPerRoll;
				 	}
				}
				
			 	$total_labels = $LabelsPerSheet*$AccountDetail->Quantity;
				if($AccountDetail->Printing == 'Y'){ 
					$labels = $this->user_model->calculate_total_printed_labels($AccountDetail->SerialNumber);
					if($labels > 0){ $total_labels = $labels;}	
				}
				
				
		       	?>
     
     
     
                
                
    <tr>
     <td class="invoicetable_tabel_border"><?=$ManufactureID?></td>
     <td class="invoicetable_tabel_border"><?php $prod_name = $this->home_model->ReplaceHtmlToString_($AccountDetail->ProductName);
     if($ManufactureID!="SCO1"){ 
 echo $prod_name; 
     }
 
    /*if($ManufactureID=="SCO1"){
      $custominfo = $this->quoteModel->fetch_custom_die_order($AccountDetail->SerialNumber); 
      include(APPPATH . 'views/old_pdf_views/assc_die.php');
    }*/
		 ?>	
		 
		 <?php if($ManufactureID=="SCO1"){ ?>
		
		    <?php 
		    
		     $custominfo = $this->home_model->fetch_custom_die_order($AccountDetail->SerialNumber);
			 $carRes = $this->user_model->getCartOrderData($AccountDetail->SerialNumber);

		    $mm = '';
            if($carRes[0]->height != null) {
                $mm=' x';
            }
													
            if($carRes[0]->shape!="Circle"){
                $carRes[0]->height = ($carRes[0]->height!=null)?($carRes[0]->height):($carRes[0]->width); 
                $mm=' x';
														
            }
		  ?>
		    
      <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?> | <b>Format:</b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?> | <b>Size:  </b><?= (isset($carRes[0])) ? $carRes[0]->width.'mm'.$mm  : '' .' x' ?>
      
        <?= ((isset($carRes[0])) && $carRes[0]->height != null) ? (isset($carRes[0]) && $carRes[0]->width!="") ? $carRes[0]->width : '' : ($carRes[0]->height!="" && $carRes[0]->height!="NULL") ? $carRes[0]->height.'mm': '' ?> |
													 
            <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?> |
            <b>Across: </b>       <?= (isset($carRes[0])) ? $carRes[0]->across : '' ?> |
            <b>Around: </b>       <?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
													
            <?php if(($carRes[0]->shape != 'Circle') && ($carRes[0]->shape !='Oval')){?>
        | <b>Corner Radius: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
        <?php } ?>
        | <b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>
         
         
          
         
         
         
     <?php }?>
		 
		 
    </td>
  </tr>
  
  
   <?php if($AccountDetail->Printing =="Y" && $AccountDetail->regmark =='Y'){ ?>
     
     <tr >
        <td class="invoicetable_tabel_border "></td>
        <td class="invoicetable_tabel_border "><b>Printing Service(Black Registration Mark on Reverse)</b></td>
      
    </tr>
  
     <?php } ?>
  
  
 <?   if($AccountDetail->Printing =="Y"){?> 
      <tr>
       <td class="invoicetable_tabel_border">Printing</td>
        <?php $print_style='font-size: 8px;'; include(APPPATH . 'views/old_pdf_views/print_line_txt.php'); ?>
     </tr>
<? } ?>  
    
    
        <?php if($AccountDetail->odp_proof=="Y"){ ?>                                          

  <tr>
  
  <td class="invoicetable_tabel_border ">      
    <?php if ($AccountDetail->odp_foc == 'Y')     {     echo 'Press Proof - Foc';} ?>
    <?php if ($AccountDetail->odp_foc == 'other') {     echo $AccountDetail->odp_foc;} ?>
    <?php if ($AccountDetail->odp_foc != 'Y' && $AccountDetail->odp_foc != 'other') {
     echo 'Up to '.$AccountDetail->odp_qty.' Designs ';} ?>
  </td>
  
  <td colspan="1" class="invoicetable_tabel_border">Physical Press Proof, Pre-Press Approval Required</td>
                                        
  
  
  
  
</tr>  

                                     
                                          <?php }    ?>
     
    
     
      
<? if($ManufactureID=="PRL1"){ 
   $result = $this->quoteModel->get_details_roll_quotation($AccountDetail->Prl_id); 
 ?>
  <tr>
   <td class="invoicetable_tabel_border"></td> 
   <td class="invoicetable_tabel_border">  <b>Shape:</b>
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
            <?=$result['coresize']?>
            &nbsp;&nbsp; <b>Wound:</b>
            <?=$result['wound']?>
            &nbsp;&nbsp;<b>Notes:</b>
            <?=$result['notes']?>
            &nbsp;&nbsp;</td>
 </tr>
<? } ?>


           <? if($ManufactureID=="SCO1" && $AccountDetail->Linescompleted==0){
                   $print_exvat = $print_incvat = 0;
			       include(APPPATH . 'views/old_pdf_views/assc_material_hide.php');
             } ?>

     
<? } ?>
 </tr>
</table>


