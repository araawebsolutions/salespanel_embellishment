<?php
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
<?php 
//echo '<pre>';
//print_r($OrderDetails);
?>

<table width="100%" align="center" border="0" cellspacing="0">
  <tr>
    <td>
       <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/theme/site/images/logo.png" border="0" width="160" height="66" />
        
        </td>
    <td width="30%" align="left" valign="middle"><?php
      
      echo "<strong  style='margin-left:80px;'>Quotation :</strong> ";
      echo'<font color="#000000"> '.$OrderInfo['QuotationNumber'].'</font>';
        ?>
        </td>
  </tr>
  </table>
  
  <br><br>
  
  
  
  
<table width="100%" align="center" border="0" cellspacing="0" >


  <tr>
    <td align="left" valign="top" class="print_address" width="50%">
    
    
    <!-- ------------------------------------->
   <table width="100%" border="0">
    <tr>
        <td align="left" class="print_address">AA Labels, </td>
    </tr>
    <tr>
        <td align="left" class="print_address">Trading name of Green Technologies Ltd.</td>
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
          <td align="left" class="print_address"><span class="phone_right">01733 588 390</span></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">Email: </strong></td>
          <td align="left" valign="top" class="print_address"><span class="phone_right"><a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#257cac;">customercare@aalabels.com</a></span></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">VAT No: </strong></td>
          <td align="left" valign="top" class="print_address"><span class="phone_right">
          
             <?php
                if(isset($OrderInfo['BillingCountry']) && $OrderInfo['BillingCountry'] == 'France'){
                    echo "FR 21 851063453";
                } else{
                    echo "GB 945 028 620";
                }
              ?>  
              
          </span></td>
        </tr>
      </table>
    </td>
    
      
      </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:10px;">
    
        <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px;" width="100%"><h3 style="padding-top:-10px; white-space:nowrap;color:#fff;padding-left:5px;">Quotation Detail</h3></td>
        </tr>
        
        <tr>
          <td align="left" valign="top" style="padding-top:10px;" width="100%">
          <table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="print_address"><b>Quotation Number:</b></td>
                <td class="print_address"><b>Date:</b></td>
                <td class="print_address"><b>Time:</b></td>
                <td class="print_address"><b>Status:</b></td>
              </tr>
              <tr>
                <td class="print_address" width="50%"><?php echo $OrderInfo['QuotationNumber'];   ?></td>
                <td class="print_address" width="50%"><?php echo date('jS F Y', $OrderInfo['QuotationDate']); ?></td>
                <td class="print_address" width="50%"><?php echo date('h:i:s A', $OrderInfo['QuotationTime']); ?></td>
                <td class="print_address" width="50%"><?php 
                   $status= $this->user_model->getstatus($OrderInfo['QuotationStatus']);
                   echo $status[0]->StatusTitle;
                  ?>
               </td>
              </tr>
            </table></td>
        </tr>
      </table>
      
      
      
     
    
   
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:10px;">

<tr>  
      
 <td width="50%" border="0" cellspacing="0" cellpadding="0" align="left" valign="middel" >
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px;white-space:nowrap; text-align:left;color:#fff;">&nbsp;&nbsp;Billing address</h3></td>
         </tr>
        
        
        <tr>
          <td align="left" valign="top" style="padding-top:10px;padding-left:5px">
          <table width="100%" border="0" cellspacing="4" cellpadding="0">
              <tr >
                <td align="left" style="width: 30%"><b>Company : </b></td>
                <td style="width: 70%"><?=$OrderInfo['BillingCompanyName']?></td>
              </tr>
              <tr>
                <td><b> Name  : </b></td>
                <td><?=$OrderInfo['BillingFirstName'].' '.$OrderInfo['BillingLastName']?></td>
              </tr>
              <tr>
                <td><b> Email  : </b></td>
                <td><?=$OrderInfo['Billingemail']?></td>
              </tr>
              <tr>
                <td><b> Address :</b></td>
                <td><?=$OrderInfo['BillingAddress1']?>
                  &nbsp;
                  <?=$OrderInfo['BillingAddress2']?></td>
              </tr>
              <tr>
                <td><b>City :</b></td>
                <td><?=$OrderInfo['BillingTownCity']?></td>
              </tr>
              <tr>
                <td><b> Country :</b></td>
                <td><?=$OrderInfo['BillingCountyState']?></td>
              </tr>
              <tr>
                <td ><b>Postcode</b></td>
                <td><?=$OrderInfo['BillingPostcode']?></td>
              </tr>
              <tr>
                <td><b>Telephone</b></td>
                <td><?=$OrderInfo['Billingtelephone']?></td>
              </tr>
            </table>
        </td>
        </tr>
        
         </table> 
</td>        
     
   
    <!-- -------------------------------------------->
      
   <td width="50%" border="0" cellspacing="0" cellpadding="0" align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"> 
 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
   
        <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px; white-space:nowrap; text-align:left;color:#fff;"><span style="white-space:nowrap;">&nbsp;&nbsp;Delivery address</span></h3></td>
        </tr>
        
        
        <tr>
          <td align="left" valign="top" style="padding-top:10px; padding-left:5px;">
          <table width="100%" border="0" cellspacing="4" cellpadding="0">
              <tr style="padding-top:10px; padding-left:5px;">
                <td align="left" style="width:30%;"><b>Company : </b></td>
                <td style="width: 70%"><?=$OrderInfo['DeliveryCompanyName']?></td>
              </tr>
              <tr>
                <td><b> Name  : </b></td>
                <td><?=$OrderInfo['DeliveryFirstName'].' '.$OrderInfo['DeliveryLastName']?></td>
              </tr>
              <tr>
                <td><b> Email  : </b></td>
                <td><?=$OrderInfo['Billingemail']?></td>
              </tr>
              <tr>
                <td><b> Address :</b></td>
                <td><?=$OrderInfo['DeliveryAddress1']?>
                  &nbsp;
                  <?=$OrderInfo['DeliveryAddress2']?></td>
              </tr>
              <tr>
                <td><b>City :</b></td>
                <td><?=$OrderInfo['DeliveryTownCity']?></td>
              </tr>
              <tr>
                <td><b> Country :</b></td>
                <td><?=$OrderInfo['DeliveryCountyState']?></td>
              </tr>
              <tr>
                <td ><b>Postcode</b></td>
                <td><?=$OrderInfo['DeliveryPostcode']?></td>
              </tr>
              <tr>
                <td><b>Telephone</b></td>
                <td><?=$OrderInfo['Deliverytelephone']?></td>
              </tr>
            </table>
            
        </td>
        </tr>
        
         </table>
        </td>
        
 </tr>    
 </table>
 

  
     <!-- -------------------------------------------->

      <? 
         $currency = $OrderInfo['currency'];
         $exchange_rate = $OrderInfo['exchange_rate'];
         
          $fetch_symbol = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$OrderInfo['currency']."'")->row_array();
          $symbol = $fetch_symbol['symbol'];
     ?>
 
 
 
 
 
    
    <table width="100%"  bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:0px;table-layout:fixed;">
  <tr>
   <!-- <td class="invoicetable_bgBlue" width="5%">&nbsp;</td>-->
    <td class="invoicetable_bgBlue" width="20%">Product Code</td>
    <td class="invoicetable_bgBlue" width="40%">Description</td>
    <td class="invoicetable_bgBlue" width="5%"></td>
    <td class="invoicetable_bgBlue" width="15%">Labels</td>
    <td class="invoicetable_bgBlue" width="19%">Quantity</td>
    <td class="invoicetable_bgBlue" width="10%">Ex.vat</td>
  </tr>
   
 
      <?php
      $total_exvat = 0;
      $total_invat = 0;
      $i = 0; 
     
     

      foreach ($OrderDetails as $AccountDetail) {
      
      
        $format = 'Sheets';
        $regex  = "/Roll/";
        $prodinfo = $this->user_model->getproductdetail($AccountDetail->ProductID);
        if(preg_match($regex, $prodinfo['ProductBrand'], $match)){
          $format =($AccountDetail->Quantity > 1)?'Rolls':'Roll';
        }    
                      
        $Total_labels ='';
        $per_print = '';
                      
        if($AccountDetail->ProductBrand=='Integrated Labels'){ 
          $Total_labels = $AccountDetail->Quantity;
        } else{
          $Total_labels = $AccountDetail->orignalQty;
        } 
      
      
        $per_print = $Total_labels / $AccountDetail->Quantity;
                                      
        $lbss = 'Label';
        if($Total_labels > 1){
          $lbss = 'Labels';
        }
      
        $print_exvat = $print_incvat = 0;
      
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
           $ManufactureID= $this->user_model->manufactureid("",$AccountDetail->ProductID);
          $LabelsPerSheet= $this->user_model->LabelsPerSheet($AccountDetail->ProductID);
          if(isset($AccountDetail->is_custom) and $AccountDetail->is_custom=='Yes'){
            $LabelsPerSheet = $AccountDetail->LabelsPerRoll;
          }
        }
        
        
          //********************
    $price_promise = '';
        $euroID = $this->user_model->check_EuroID($AccountDetail->ProductID);
        $line_price_promise = (isset($euroID) &&  $euroID!='')?1:0;  
    
        if(isset($euroID) &&  $euroID!=''){ $price_promise = 1; };  
        $line_price_promise = ($AccountDetail->Printing =="Y")?1:$line_price_promise;
        //********************
        
        
        $total_labels = $LabelsPerSheet*$AccountDetail->Quantity;
    if($AccountDetail->Printing == 'Y'){ 
      $labels = $this->user_model->calculate_total_printed_labels($AccountDetail->SerialNumber);
      if($labels > 0){ $total_labels =$labels;} 
          
                  if($AccountDetail->orignalQty !="" && $AccountDetail->orignalQty !=0){
                $total_labels = $AccountDetail->orignalQty;
              } 
        }
        
        
        
        $img = $this->user_model->getproductimg($AccountDetail->ProductID, $colorcode);
        
    $extra_int_text = '';
      ?>
  <tr>
    <td class="invoicetable_tabel_border" width=""><?=$ManufactureID?></td>
    <td class="invoicetable_tabel_border" width="">
      <?php $prod_name = $this->user_model->ReplaceHtmlToString_($AccountDetail->ProductName);
    if(preg_match('/Integrated Labels/',$prodinfo['ProductBrand'])){
      $extra_int_text = ($AccountDetail->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)"; 
      $prod_name.= $extra_int_text;
    } 
     if($ManufactureID!="SCO1"){
        echo $prod_name; 
    }
      ?>
     
      <? if($ManufactureID=="SCO1"){
        $custominfo = $this->user_model->fetch_custom_die_quote($AccountDetail->SerialNumber);
        $carRes = $this->user_model->getCartQuotationData($AccountDetail->SerialNumber);
       
        $mm = '';
        if($carRes[0]->height != null) {
            $mm=' x';
        }
													
        if($carRes[0]->shape!="Circle"){
            $carRes[0]->height = ($carRes[0]->height!=null)?($carRes[0]->height):($carRes[0]->width); 
            $mm=' x';
														
         } ?>
         
         
          <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?> |
            <b>Format:</b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?> |
            <b>Size:  </b><?= (isset($carRes[0])) ? $carRes[0]->width.'mm'.$mm  : '' .' x' ?>
    <?= ((isset($carRes[0])) && $carRes[0]->height != null) ? (isset($carRes[0]) && $carRes[0]->width!="") ? $carRes[0]->width : '' : ($carRes[0]->height!="" && $carRes[0]->height!="NULL") ? $carRes[0]->height.'mm': '' ?> |
													 
            <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?> |
            <b>Across: </b>       <?= (isset($carRes[0])) ? $carRes[0]->across : '' ?> |
            <b>Around: </b>       <?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
													
            <?php if(($carRes[0]->shape != 'Circle') && ($carRes[0]->shape !='Oval')){?>
        | <b>Corner Radius: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
        <?php } ?>
        | <b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>
         <?php //include(APPPATH . 'views/old_pdf_views/assc_die.php'); ?>
     <?php }?>
      
 </td>
 
     <td align="center" class="invoicetable_tabel_border" width="">
       <? if($line_price_promise==1){?>
       <img style="margin-left:5px;" src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/salespanel/theme/assets/images/blue-tick.png" width="12" height="12"/>
       <? }?>
    </td>
     
    <td align="center" class="invoicetable_tabel_border" width="">
      
      
      <?php if($AccountDetail->ProductID == '0'){ ?>
      <?php echo '----'; ?>
      <?php }  else{?>
      <?=$symbol?><?= number_format(($AccountDetail->Price / $Total_labels) * $exchange_rate, 3,'.','')?> 
      <br> Per Label
      <?php } ?>
      
      
    </td>
    <td align="center" class="invoicetable_tabel_border" width="">
      
      <?php if($AccountDetail->ProductID == '0'){ ?>
         <?=$AccountDetail->Quantity;?><br>
      <?php } else{?>
        <?=$AccountDetail->Quantity.' '.$format?><br><?=$Total_labels.' '.$lbss?>
      <?php }?>
      
      
       
    </td>
    <td align="center" class="invoicetable_tabel_border" width="">
    <?php   $exvat = number_format($AccountDetail->Price,2,'.',''); 
      echo $symbol."".(number_format($exvat*$exchange_rate,2));
  ?>  
    </td>
  </tr>
  
      <?          
    $stylo = "";
    if($AccountDetail->Printing =="Y"){
    }else{
      $stylo = "style='display:none;'"; 
    }
      ?>   
      <?php
    if($AccountDetail->Printing =="Y" && $AccountDetail->regmark !='Y'){ ?>

      <tr <?=$stylo?>>
    <td class="invoicetable_tabel_border">Printing</td>
      <?php 
      $print_style='font-size: 8px';
      include(APPPATH . 'views/old_pdf_views/print_line_txt.php');
    ?>
     
    <td class="invoicetable_tabel_border" align="center" width="">&nbsp;</td>        
    <td class="invoicetable_tabel_border" align="center" width="">
   <?= $symbol ?><?php echo number_format(5.32 * $exchange_rate, 2)?><br>
                                      Per Design
        
        </td>     
      
    <td class="invoicetable_tabel_border" align="center" width="">
      
      <?php echo $AccountDetail->Print_Qty; ?>&nbsp; <?php echo ($AccountDetail->Print_Qty > 1)?"Designs":"Design"; ?>
      <br>
      <?php if(!preg_match($regex, $prodinfo['ProductBrand'], $match)){?>
      
      (<?php echo $AccountDetail->Free; ?>&nbsp; <?php echo ($AccountDetail->Free > 1)?"Designs":"Design"; ?> Free)
        
      <?php }?>
    </td>
    <td class="invoicetable_tabel_border" align="center" width="">
      <?php
        $print_exvat = $AccountDetail->Print_Total;
        if ($AccountDetail->FinishTypePricePrintedLabels != '' && $AccountDetail->total_emb_cost != 0){
            echo $symbol."".(number_format(($print_exvat*$exchange_rate)- $AccountDetail->total_emb_cost,2));
        } else {
            echo $symbol."".(number_format($print_exvat*$exchange_rate,2));
        }

      ?>    
    </td>

  </tr>
      
      
      
      <?php 
                                                                                       
        if($AccountDetail->qp_proof == 'Y'){
        include(APPPATH . 'views/order_quotation/quotation/en/pp_line.php');
        //$linetotalexvat = $linetotalexvat + $AccountDetail->qp_price;
      } 
      ?>
      
      
      
      
 <?php } elseif($AccountDetail->Printing =="Y" && $AccountDetail->regmark =='Y'){?>
                 <tr>
                     <td class="invoicetable_tabel_border">Printing</td>
                     <td class="invoicetable_tabel_border"><b>Printing Service(Black Registration Mark on Reverse)</b></td>
                     <td class="invoicetable_tabel_border"></td>
                     <td class="invoicetable_tabel_border"></td>
                     <td class="invoicetable_tabel_border"></td>
                     <td class="invoicetable_tabel_border"></td>
                 </tr>
                 <?php }?>
    
      <?  if($ManufactureID=="PRL1"){
      $result = $this->quoteModel->get_details_roll_quotation($AccountDetail->Prl_id); ?>
      <tr>
        <td class="invoicetable_tabel_border"></td>
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
        <td class="invoicetable_tabel_border" align="center"></td>
        <td class="invoicetable_tabel_border" align="center"></td>
        <td class="invoicetable_tabel_border" align="center"></td>
        <td class="invoicetable_tabel_border" align="center"></td> 
        <td class="invoicetable_tabel_border" align="center"></td>  
      </tr>
      <? } ?>
 
 
 
    <? if($ManufactureID=="SCO1"){
       $show_price_promise_line = 1; include(APPPATH . 'views/old_pdf_views/assc_material.php');
      }
   ?>   
   
 <!--<tr> 
   <td colspan="2" class="invoicetable_tabel_border"> </td>
   <td colspan="2" class="invoicetable_tabel_border" align="center"><b>Line Total</b></td>
   <td class="invoicetable_tabel_border"> </td>
   <td class="invoicetable_tabel_border" align="center">
     <b>
       <?  
      $pp_price = 0;
      
      if($AccountDetail->qp_proof == 'Y'){
        $pp_price = $AccountDetail->qp_price;
      }
    
      $linetotalexvat =  $print_exvat  + $exvat + $pp_price;
      $linetotalinvat =  number_format($linetotalexvat * 1.2,2,'.','');
    
      echo $symbol."".(number_format($linetotalexvat*$exchange_rate,2));
       ?>
    </b>
  </td>
  </tr>-->

          <?php

          if ($AccountDetail->Printing == 'Y' && $AccountDetail->FinishTypePricePrintedLabels != '') { //Labels Embellishment Options Start
              ?>
              <tr>
                  <td class="invoicetable_tabel_border"></td>
                  <td class="invoicetable_tabel_border" colspan="5"><b> Finish </b></td>
              </tr>
              <?php
              $lem_options = json_decode($AccountDetail->FinishTypePricePrintedLabels);
              $parent_title = '';

              /* echo count($lem_options)."------<br>";
               echo "<pre>";
               print_r($lem_options);
               echo "</pre>";*/

              $index = 0;
              $parsed_child_title = '';
              $parsed_title_price = 0;
              foreach ($lem_options as $lem_option) {

                  $parsed_title = ucwords(str_replace("_", " ", $lem_option->finish_parsed_title));
                  $parsed_parent_title = $lem_option->parsed_parent_title;
                  $parent_id = $lem_option->parent_id;
                  $use_old_plate = $lem_option->use_old_plate;

                  ($use_old_plate == 1 ?  $plate_cost = 0 : $plate_cost = $lem_option->plate_cost);

                  if ($parent_id == 1) { //For Lamination and varnish
                      $parsed_child_title .= $parsed_title.", ";
                      $parsed_title_price += $lem_option->finish_price;


                      if ($parsed_parent_title != $lem_options[$index+1]->parsed_parent_title || ($index+1) == count($lem_options)) {
                          $parsed_parent_title = ucwords(str_replace("_", " ", $parsed_parent_title));
                          ?>

                          <tr>
                              <td class="invoicetable_tabel_border"></td>
                              <td class="invoicetable_tabel_border"><?= "<b>".$parsed_parent_title." : </b>".$parsed_child_title?></td>
                              <td class="invoicetable_tabel_border"></td>
                              <td class="invoicetable_tabel_border" align="center">
                                  <?= $symbol." ".number_format((($parsed_title_price+$plate_cost) / $total_labels) * $exchange_rate, 2, '.', '') ?>
                                  <br>Per Label
                              </td>
                              <td class="invoicetable_tabel_border"></td>
                              <td class="invoicetable_tabel_border" align="center">
                                  <?php
                                  echo $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2) ;
                                  ?>
                              </td>
                          </tr>

                          <?php
                      }

                  } else if($parent_id != 1 && $parent_id != 5) { //For other than varnish and sequen
                      $parsed_parent_title = ucwords(str_replace("_", " ", $parsed_parent_title));
                      $parsed_child_title = $parsed_title;
                      $parsed_title_price = $lem_option->finish_price+$plate_cost;
                      ?>
                      <tr>
                          <td class="invoicetable_tabel_border"></td>
                          <td class="invoicetable_tabel_border"><?= "<b>".$parsed_parent_title." : </b>".$parsed_child_title?></td>
                          <td class="invoicetable_tabel_border"></td>
                          <td class="invoicetable_tabel_border" align="center">
                              <?= $symbol." ".number_format(($parsed_title_price / $total_labels) * $exchange_rate, 2, '.', '') ?>
                              <br>Per Label
                          </td>
                          <td class="invoicetable_tabel_border"></td>
                          <td class="invoicetable_tabel_border" align="center">
                              <?php
                              echo $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2);
                              ?>
                          </td>
                      </tr>

                  <?php } else { //For Sequential Data ?>

                      <tr>
                          <td class="invoicetable_tabel_border"></td>
                          <td class="invoicetable_tabel_border">Sequential Variable Data</td>
                          <td class="invoicetable_tabel_border"></td>
                          <td class="invoicetable_tabel_border" align="center">
                              <?= $symbol." ".number_format((sequential_price / $total_labels) * $exchange_rate, 2, '.', '') ?>
                              <br>Per Label
                          </td>
                          <td class="invoicetable_tabel_border"></td>
                          <td class="invoicetable_tabel_border" align="center">
                              <?php
                              echo $symbol." ".number_format((sequential_price * $exchange_rate), 2) ;
                              ?>
                          </td>
                      </tr>

                  <?php  }
                  $index++;
              } ?>

              <?php
          }  //Labels Embellishment Options Start

      $total_exvat += $linetotalexvat;
      $total_invat += $linetotalinvat;
      $i++;
    } // end foreach
 
         // AA21 STARTS
        if($OrderInfo['PaymentMethods'] != 'Sample Order')
        {
              if( ($OrderInfo['quotationCourier'] == 'DPD') && ($OrderInfo['quotationCourierCustomer'] == 'Parcelforce') ){
                  $ship_invat=number_format( (($OrderInfo['QuotationShippingAmount'])+1) ,2,'.','');
                  $ship_exvat = number_format( (($OrderInfo['QuotationShippingAmount'])+1) /vat_rate,2,'.',''); 
              }
              else if( ($OrderInfo['quotationCourier'] == 'Parcelforce') && ($OrderInfo['quotationCourierCustomer'] == 'DPD') ){
                  $ship_invat=number_format( (($OrderInfo['QuotationShippingAmount'])-1) ,2,'.','');
                  $ship_exvat = number_format( (($OrderInfo['QuotationShippingAmount'])-1) /vat_rate,2,'.',''); 
              }
              else
              {
                  $ship_invat=number_format( $OrderInfo['QuotationShippingAmount'] ,2,'.','');
                  $ship_exvat = number_format( $OrderInfo['QuotationShippingAmount'] /vat_rate,2,'.',''); 
              }
        }
        
        $gt_invat = number_format($ship_invat+$total_invat,2,'.','');
        $gt_exvat  = number_format($ship_exvat+$total_exvat,2,'.','');
        // AA21 ENDS
         ?>
    </table>
    
    
    
    
    
<? if($price_promise == 1){?> 
 
  <table width="280px" align="left" style="table-layout:fixed;">
    <tr>
      <td width="100%"> 
        <img style="margin-left:5px;" src="https://www.aalabels.com/aalabels/img/green-tick.png" width="12" height="12"/>
        &nbsp; 
        <span style="margin-top:5px;">Lowest Prices Guaranteed Online </span>
      </td>
    </tr>
</table>  

<? } ?>
  
  
  
   
<table width="280px;" align="right" style="table-layout:fixed;">
  <?

 $serviceID = $OrderInfo['ShippingServiceID'];
 $service = $this->user_model->getShipingServiceName($serviceID);?>

  <tr>
    <td colspan="5"  class="invuice_subtotal" width="50%">&nbsp;&nbsp;&nbsp;<b><? echo $service['ServiceName'];?>&nbsp; 
      <? echo $symbol."".(number_format($ship_exvat*$exchange_rate,2));
    ?>
      </b></td>
  </tr>
  
   <tr>
    <td colspan="4"  class="invuice_subtotal" width="65%"><b>Delivery 
         <?php 
            if( isset($OrderInfo['quotationCourier']) && ($OrderInfo['quotationCourier'] != '') )
            {
                echo "(".$OrderInfo['quotationCourier'].")";
            }
            ?>
            
    Total</b></td>
    <td  class="invuice_subtotal_price" width="20%"><? echo  $symbol."".(number_format($ship_exvat*$exchange_rate,2));?></td>
  </tr>
  
  <tr>
    <td colspan="4" class="invuice_subtotal" width="65%"><b>Sub Total (Ex. Vat)</b></td>
    <td  class="invuice_subtotal_price" width="20%"><? echo $symbol."".(number_format(($gt_exvat)*$exchange_rate,2));?></td>
  </tr>
  
  
  <? $gt_invat  = number_format($gt_exvat*1.2,2,'.',''); ?>
  
  <?php if($OrderInfo['vat_exempt']=='yes'){
  $final_exempt_price = $gt_invat - $gt_exvat;
  $gt_invat = $gt_exvat; 
  ?>
        
  <tr>
    <td colspan="4" class="invuice_subtotal" width="65%"><b>VAT Exempt:</b></td>
    <td  class="invuice_subtotal_price" width="20%">
      - <?php echo $symbol.number_format(($final_exempt_price)* $exchange_rate,2,'.',''); ?> 
    </td>
  </tr>
  <? } ?>
  
  
  
  <?php
  
  $disuntoffer_inc = 0.00;
  $disuntoffer_ex  = 0.00;
  $voucher = $this->user_model->calculate_total_printedroll_amount($OrderInfo['QuotationNumber']);
  
  if($voucher > 0){
    $disuntoffer_inc = $voucher;
    $disuntoffer_ex  = $voucher/1.2;
    $gt_invat = $gt_invat-$disuntoffer_inc;
  ?> 
  <tr>
    <td colspan="4" class="invuice_subtotal" width="65%"><b>Discount Total:</b></td>
    <td class="invuice_subtotal_price" width="20%">&nbsp;</td>
                 
    <td class="invuice_subtotal_price" width="20%"><b>
      <?php echo $symbol.number_format($voucher* $exchange_rate,2,'.',''); ?>
      </b>
    </td>
  </tr>
  <? } ?>
    
    
    
      <tr>
        <td colspan="4"  class="invuice_subtotal" width="65%"><b>Sub Total (In. Vat)</b></td>
        <td  class="invuice_subtotal_price" width="20%">
        <? echo $symbol."".(number_format($gt_invat*$exchange_rate,2,'.',''));?>
        </td>
      </tr>
          
       <tr>
        <td colspan="4" class="invuice_subtotal" width="65%"><b>Grand Total:</b></td>
        <td class="invuice_subtotal_price" width="20%"><b>  
          <? echo $symbol."".(number_format(($gt_invat*$exchange_rate),2,'.',''));?>
        
         </b></td>
      </tr>
    
     
</table>

<?php if($OrderInfo['DeliveryCountry'] !='United Kingdom'){ ?>
 
<table align="left" width="60%" style="bottom:240px;padding-top:5px;">

<tr>
  <td>* If you are VAT registered please provide your VAT number or your authorised number to apply VAT exemption.</td>
</tr>

</table>

<?php } ?>   















<? if($price_promise == 1){?> 

<style>
  .flyleaf {
    page-break-after: always;
  }
  .footer p{ font-size:13px !important;line-height:15px;margin-top:5px !important;}
  .footer b{ font-size:13px !important;}



</style>

<div class="flyleaf"></div>


<div class="footer">
<img alt="AA Labels" src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/theme/site/images/price-promise-back.png">
<br />
 

<b>Price Promise</b>
<p>When products on the website are included in our price promise, our assurance is that, if within 7 days from date of purchase,
 you find the same product cheaper online at any other UK label website, we will refund 100% of the difference.</p>

<b>Plain Labels</b> 
<p>This applies solely to label sizes and materials on Dry Edge A4 sheets which are clearly identified throughout the website.</p>

<b>Printed Labels on Dry Edge A4 Sheets</b>  
<p>This applies to both the label size, material and print price of a comparable service level.</p>

<b>Printed Labels on Non-Dry Edge A4 Sheets</b>
<p>The price promise applies to the print price only and must be compared with the equivalent pre-press online service level provided for our customers.</p>


<b>Printed Labels on Rolls</b>
<p>The price promise applies to the print price only and must be compared with the equivalent pre-press online service level provided for our customers.</p>


<b>Eligible Period</b>
<p>7 days from the point of order placement and payment.</p>

<b>Eligible Online Purchase Options</b>
<p>The comparative product must be available to order and purchase online from a UK label producer/supplier website and not through e-commerce i.e. Alibaba, Amazon or eBay.</p>



<div class="flyleaf"></div>

<b style="color:#3289b3 !important">LABEL PRINTING</b>
<br />

<b>Order Online for High Quality Digitally Printed Labels on Rolls & Sheets</b>
<p>Your labels are as important as your brand, product or organisational image, in communicating your chosen values. Because the medium becomes the message and the label quality you choose says a lot about you, but a poor quality label can say even more!</p>

<p>We understand that the combination of label material, adhesive, design, print and finish are all critical elements in a labels appearance and performance. Delivering the highest quality standards in label production and service is a collective responsibility at AA Labels, ensuring that you always receive a high quality label for your application.</p>


<b>Artwork Approval</b>
<p>Place your order online and upload artwork, our customer care and studio teams will combine to produce your artwork as a free-of-charge electronic soft-proof for online approval, or amendment by you. Up to 3 amendments are permissible without incurring additional reprographic charges and the whole process is undertaken online, with email notification when a soft-proof of your artwork is available to view.</p>


<b>Press Scheduling</b>
<p>Orders are added to the print queue following final approval of artwork from the soft-proof provided. We commit to print, finishing and conversion within 4 working days from this point.</p>


<b>Despatch</b>
<p>Deliveries are made the following working day in mainland UK (other than exception postcodes and offshore). Delivery times outside of the UK vary, please refer to "Delivery & Shipping" under "SITE LINKS" in the footer of our website.</p>

<b>Order Fulfilment</b>
<p>You can therefore expect to receive your printed labels within 3 – 5 working days, following approval of artwork, in the UK. Outside of the UK delivery times vary.</p>


<b style="color:#3289b3 !important;margin-top:20px;">CUSTOMER CARE</b>
<br />

<p>If you have any questions about your quotation, order, our price promise or label printing, please do not hesitate to contact our customer care team via the website live-chat <a href="www.aalabels.com">www.aalabels.com</a> telephone 01733 588390 or email <a href="mailto:customercare@aalabels.com">customercare@aalabels.com </a> and they will be pleased to help you.
</p>


</div>

<? } ?>