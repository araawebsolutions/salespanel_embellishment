<?php

//error_reporting(1);
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2); ?>

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


    	if($OrderInfo['OrderStatus'] == 6){
    	  echo 'Pro-forma Invoice : <font color="#000000"> '.$quoteID = $OrderInfo['OrderNumber']. '</font>';
    	}else{
           echo 'Order Number : <font color="#000000"> '.$quoteID = $OrderInfo['OrderNumber']. '</font>';
    	}
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
          <td align="left" valign="top" class="print_address"><span class="phone_right">
            <? if($OrderInfo['Domain']=="PLO"){?>
         <a href="mailto:customercare@printedlabelsonline.com" style="text-decoration:none; color:#257cac;">customercare@printedlabelsonline.com</a></span>
          <? }else{ ?>
         <a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#257cac;">customercare@aalabels.com</a>
         <? } ?>

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
              ?>  </span>
          </td>
        </tr>
      </table>
      </td>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:10px;">

        <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px;" width="100%"><h3 style="padding-top:-10px; white-space:nowrap;color:#fff;padding-left:5px;">Order Detail</h3></td>
        </tr>

        <tr>
          <td align="left" valign="top" style="padding-top:10px;" width="100%">
          <table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td class="print_address"><b>Order Number:</b></td>
                <? if($OrderInfo['PurchaseOrderNumber']!=""){?> <td class="print_address"><b>Purchase Order:</b></td> <? } ?>
                <td class="print_address"><b>Date:</b></td>
                <td class="print_address"><b>Time:</b></td>
                <td class="print_address"><b>Status:</b></td>
              </tr>
              <tr>
                <td class="print_address" width="50%"><?php echo $OrderInfo['OrderNumber'];   ?></td>
                <? if($OrderInfo['PurchaseOrderNumber']!=""){?> <td class="print_address" width="50%"><?php echo $OrderInfo['PurchaseOrderNumber']; ?></td> <? } ?>
                <td class="print_address" width="50%"><?php echo date('jS F Y', $OrderInfo['OrderDate']); ?></td>
                <td class="print_address" width="50%"><?php echo date('h:i:s A', $OrderInfo['OrderTime']); ?></td>
                <td class="print_address" width="50%"><?php
                   $status= $this->home_model->getstatus($OrderInfo['OrderStatus']);
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
                <td><?=$OrderInfo['BillingCountry']?></td>
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
                <td><?=$OrderInfo['DeliveryCountry']?></td>
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
       $OrderInfo['currency']  = (isset($OrderInfo['currency']) && $OrderInfo['currency']!='')?$OrderInfo['currency']:'GBP';
	   $exchange_rate   = (isset($OrderInfo['exchange_rate']) && $OrderInfo['exchange_rate']!=0)?$OrderInfo['exchange_rate']:1;
	   $symbol = $this->home_model->get_currecy_symbol($OrderInfo['currency']);
	   if($exchange_rate==0){ $exchange_rate = 1;}
?>

<table width="527"  bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:0px;table-layout:fixed;">
  <tr >
    <td class="invoicetable_bgBlue" width="20%">Product Code</td>
    <td class="invoicetable_bgBlue" width="50%">Description</td>
    <td class="invoicetable_bgBlue" width="20%">Labels</td>
    <td class="invoicetable_bgBlue" width="20%">Quantity</td>
    <td class="invoicetable_bgBlue" width="15%">Ex.vat</td>
  </tr>

  <?php
  $total_exvat = 0;
  $total_invat = 0;
  $i = 0;
        //echo '<pre>'; print_r($OrderDetails); echo '</pre>';
		foreach ($OrderDetails as $AccountDetail) {


			$print_exvat=0;  $print_incvat=0;


    $format = 'Sheets';
    $regex  = "/Roll/";



    if(preg_match($regex, $AccountDetail->ProductBrand, $match)){
      $format =($AccountDetail->Quantity > 1)?'Rolls':'Roll';
    }

          /*if($AccountDetail->ProductBrand == "Roll Labels"){
              $format =($AccountDetail->Quantity > 1)?'Rolls':'Roll';
          }*/



			if($i%2==0){
				$css="class='table_blue_bar'";
			}else{
				$css="class='table_white_bar'";
			}

			 $LabelsPerSheet = 1;
			 $colorcode = (isset($AccountDetail->colorcode) and $AccountDetail->colorcode!='')?'-'.$AccountDetail->colorcode:'';
			 $img = $this->home_model->getproductimg($AccountDetail->ProductID, $colorcode);


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
				$labels = $this->home_model->get_total_labels($AccountDetail->SerialNumber);
				if($labels > 0){ $total_labels = $labels;}

				 if($AccountDetail->labels !="" && $AccountDetail->labels !=0){
				   $total_labels  = $AccountDetail->labels;
				 }
			}
			if($OrderInfo['PaymentMethods'] == 'SampleOrder' || $AccountDetail->ProductID==0){
			  $total_labels = '-';
			}
  ?>
  <tr>
    <td class="invoicetable_tabel_border"><?=$ManufactureID?></td>
    <td class="invoicetable_tabel_border">
	<?php $prod_name = $this->home_model->ReplaceHtmlToString_($AccountDetail->orderProductName);

	if($ManufactureID!="SCO1"){
	      echo $prod_name;

	}
	       /*if($ManufactureID=="SCO1"){
			 $custominfo = $this->home_model->fetch_custom_die_order($AccountDetail->SerialNumber);
			  $carRes = $this->user_model->getCartOrderData($AccountDetail->SerialNumber);

			 //include(APPPATH . 'views/old_pdf_views/assc_die.php');
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

    <td align="center" class="invoicetable_tabel_border">
      <?php
      $is_order_is_sample = $this->home_model->is_Sample_Order($AccountDetail->OrderNumber);

      if($is_order_is_sample == false){ ?>


       <?php if($ManufactureID!="SCO1" && $AccountDetail->ProductID!="0"){ ?>
         <?=$symbol?><?= number_format(($AccountDetail->Price / $total_labels) * $exchange_rate, 3,'.','')?>
         <br>Per Label
      <?php } else{?>
       <?=$symbol?><?= number_format(($AccountDetail->Price / $AccountDetail->Quantity) * $exchange_rate, 3,'.','')?>
      <?php } ?>



     <?php }else{ ?>
      <?php  echo  $is_order_is_sample; ?>
    <?php  }     ?>
    </td>

    <td align="center" class="invoicetable_tabel_border">

      <?php if($ManufactureID!="SCO1" && $AccountDetail->ProductID!="0"){ ?>
      <?php echo $AccountDetail->Quantity.' '.$format; ?><br>


      <?php if($AccountDetail->sample == 'Sample'){ ?>

      <?php if(!preg_match($regex, $AccountDetail->ProductBrand, $match)){ ?>
      <?php echo $total_labels.' ';?><?php echo ($total_labels > 0)?"Labels":"Label";?>
      <?php } ?>

      <?php }else{ ?>
       <?php echo $total_labels.' ';?><?php echo ($total_labels > 0)?"Labels":"Label";?>
      <?php } ?>


      <?php } else{?>
      <?php echo $AccountDetail->Quantity?><br>
      <?php } ?>

    </td>

    <td align="center" class="invoicetable_tabel_border">


	<?php   $exvat = number_format($AccountDetail->Price,2,'.','');
      echo  $symbol."".(number_format($exvat*$exchange_rate,'2','.',''));
	?>
    </td>
</tr>
<?  if($AccountDetail->Printing =="Y" && $AccountDetail->regmark !='Y'){ ?>
		<tr>
            <td class="invoicetable_tabel_border">Printing</td>
            <?php $print_style='font-size: 8px;';include(APPPATH . 'views/old_pdf_views/print_line_txt.php'); ?>
            <td class="invoicetable_tabel_border" align="center">&nbsp;</td>
            <td class="invoicetable_tabel_border" align="center">

              <?php
      $des_gn = '';
      if($AccountDetail->Print_Qty > 1){
        $des_gn ='Designs';
      }else{
        $des_gn ='Design';
      }

      $des_free = '';
      if($AccountDetail->Free > 1){
        $des_free ='Designs';
      }else{
        $des_free ='Design';
      }
          ?>

        <?= $AccountDetail->Print_Qty.' '.$des_gn?> <br>

        <?php if(!preg_match($regex, $AccountDetail->ProductBrand, $match)){ ?>
        (<?= $AccountDetail->Free.' '.$des_free?> Free)
        <?php } ?>

              <?php //echo $AccountDetail->Print_Qty; ?>

    </td>
            <td class="invoicetable_tabel_border" align="center">
            <?
                $print_exvat = $AccountDetail->Print_Total;
                if ($AccountDetail->FinishTypePricePrintedLabels != '' && $AccountDetail->total_emb_cost != 0){
                    echo $symbol."".(number_format(($print_exvat*$exchange_rate)- $AccountDetail->total_emb_cost,2));
                } else {
                    echo $symbol."".(number_format($print_exvat*$exchange_rate,2));
                }

            ?>
            </td>
        </tr>
<?	} elseif($AccountDetail->Printing =="Y" && $AccountDetail->regmark =='Y'){ ?>
    <tr >
        <td class="invoicetable_tabel_border "></td>
        <td class="invoicetable_tabel_border "><b>Printing Service(Black Registration Mark on Reverse)</b></td>
        <td class="invoicetable_tabel_border "></td>
        <td class="invoicetable_tabel_border "></td>
        <td class="invoicetable_tabel_border "></td>
    </tr>


    <?php }?>



    <?php if($AccountDetail->odp_proof=="Y"){ ?>

  <tr>

  <td class="invoicetable_tabel_border ">
    <?php if ($AccountDetail->odp_foc == 'Y')     {     echo 'Press Proof - Foc';} ?>
    <?php if ($AccountDetail->odp_foc == 'other') {     echo $AccountDetail->odp_foc;} ?>
    <?php if ($AccountDetail->odp_foc != 'Y' && $AccountDetail->odp_foc != 'other') {
     echo 'Up to '.$AccountDetail->odp_qty.' Designs';} ?>
  </td>

  <td colspan="1" class="invoicetable_tabel_border">Physical Press Proof, Pre-Press Approval Required</td>

  <td class=" invoicetable_tabel_border" align="center">
    <?php if($AccountDetail->odp_price!=0){ ?>
    <?=$symbol?><?=number_format(($AccountDetail->odp_price / $AccountDetail->odp_qty) * $exchange_rate,2,'.',''); ?> <br> each
    <?php } else { ?>
    <?=$symbol?><?='0.00'; ?>
    <?php } ?>
  </td>

  <td class=" invoicetable_tabel_border" align="center">
    <?=$AccountDetail->odp_qty;?> Press Proof
  </td>

  <td class=" invoicetable_tabel_border" align="center">
    <?=$symbol?><?=($AccountDetail->odp_price !="")?number_format($AccountDetail->odp_price * $exchange_rate,2,'.','') : '0.00' ?>
  </td>


</tr>

  <?php $exvat +=  number_format($AccountDetail->odp_price * $exchange_rate , 2);?>

                                          <?php }    ?>



<?  if($ManufactureID=="PRL1"){
         $result = $this->quoteModel->get_details_roll_quotation($AccountDetail->Prl_id);  ?>
         <tr>
         <td class="invoicetable_tabel_border"></td>
         <td class="invoicetable_tabel_border"></td>
         <td class="invoicetable_tabel_border">
         <b>Shape:</b>
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
       </tr>
     <? } ?>
  <? if($ManufactureID=="SCO1" && $AccountDetail->Linescompleted==0){

   $print_exvat = $print_incvat = 0;
   include(APPPATH . 'views/old_pdf_views/assc_material.php');
 }
  ?>


   <? $linetotalexvat =  ($print_exvat  + $exvat) * $exchange_rate;
      //echo $symbol."".(number_format($linetotalexvat,2));
   ?>
  <?php

        if ($AccountDetail->Printing == 'Y' && $AccountDetail->FinishTypePricePrintedLabels != '') { //Labels Embellishment Options Start
            ?>
            <tr>
                <td class="invoicetable_tabel_border"></td>
                <td class="invoicetable_tabel_border" colspan="4"><b> Finish </b></td>
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
		    $i++;

	    } // end foreach


	   if($OrderInfo['voucherOfferd']=='Yes'){
		  $discount = $OrderInfo['voucherDiscount'];
	   }else if($OrderInfo['DiscountInPounds'] != 0.00){
		  $discount = $OrderInfo['DiscountInPounds'];
	   }else{
		 $discount = 0.00;
	   }

	   $vatRate = vat_rate;
	   $ship_invat = number_format($OrderInfo['OrderShippingAmount']*$exchange_rate,2,'.','');
	   $ordertotal = number_format($OrderInfo['OrderTotal']+$OrderInfo['OrderShippingAmount'],2,'.','');

	     $total_incvat =   ($total_exvat/$exchange_rate) * 1.2;
	     $ordertotal   =   number_format($total_incvat+$OrderInfo['OrderShippingAmount'],2,'.','');

	       ?>
</table>
<table width="280px;" align="right" style="table-layout:fixed;">
	<tr>
	      <!-- AA21 STARTS -->
        <?php
          if($OrderInfo['PaymentMethods'] != 'Sample Order')
          {
              if( ($OrderInfo['OrderDeliveryCourier'] == 'DPD') && ($OrderInfo['OrderDeliveryCourierCustomer'] == 'Parcelforce') ){
                  $ship_invat = number_format((($ship_invat)+1)*$exchange_rate,2,'.','');
              }
              else if( ($OrderInfo['OrderDeliveryCourier'] == 'Parcelforce') && ($OrderInfo['OrderDeliveryCourierCustomer'] == 'DPD') ){
                  $ship_invat = number_format((($ship_invat)-1)*$exchange_rate,2,'.','');
              }
              else
              {
                  $ship_invat = number_format(($ship_invat)*$exchange_rate,2,'.','');
              }
          }

        ?>
      <!-- AA21 ENDS -->


    	<td colspan="4"  class="invuice_subtotal" width="65%">
    	  <b>
            Delivery
            <?php if($OrderInfo['OrderDeliveryCourier'] != '') {echo "(".$OrderInfo['OrderDeliveryCourier'].") ";}?>
            Total
          </b>
    	</td>
    	<td  class="invuice_subtotal_price" width="20%"><? echo $symbol."".(number_format(($ship_invat/1.2),2,'.',''));?></td>
 	</tr>
  	<tr>
    	<td colspan="4" class="invuice_subtotal" width="65%"><b>Sub Total (EX. Vat)</b></td>
   		<td  class="invuice_subtotal_price" width="20%"><? echo $symbol."".(number_format(($total_exvat)+($ship_invat/1.2),2,'.',''));?></td>
    </tr>
<? if($discount>0){
	  $ordertotal = number_format($ordertotal-$discount,2,'.','');
	  $showdiscount = $discount/1.2;
?>
  	<tr>
    	<td colspan="4"  class="invuice_subtotal" width="65%"><b>Discount</b></td>
    	<td  class="invuice_subtotal_price" width="20%"><? echo $symbol."".(number_format($showdiscount*$exchange_rate,2,'.',''));?></td>
    </tr>
<? } ?>
<? if($OrderInfo['vat_exempt']=='yes'){
	   $oldordertotal = $ordertotal;
	   $ordertotal =$ordertotal/1.2;
	   $exemption = $oldordertotal - $ordertotal;
?>

   <tr>
      <td colspan="4"  class="invuice_subtotal" width="65%"><b>VAT Exempt:</b></td>
      <td  class="invuice_subtotal_price" width="20%">- <? echo $symbol."".(number_format($exemption*$exchange_rate,2,'.',''));?></td>
  </tr>

<?  } ?>

	<tr>
    	<td colspan="4" class="invuice_subtotal" width="65%"><b>Sub Total (Inc. Vat)</b></td>
    	<td class="invuice_subtotal_price" width="20%"><? echo $symbol."".(number_format($ordertotal*$exchange_rate,2,'.',''));?></td>
    </tr>
    <tr>
        <td colspan="4" class="invuice_subtotal" width="65%"><b>Grand Total:</b></td>
        <td class="invuice_subtotal_price" width="20%"><b><? echo $symbol."".(number_format($ordertotal*$exchange_rate,2,'.',''));?></b></td>
  </tr>
</table>