<?php

//error_reporting(E_ALL);
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

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
        /*border-left: 1px solid #cccccc;*/
        color: #000000;
        font-size: 12px;
        padding: 5px 0 5px 10px;
        text-align: left;
    }

    /* DivTable.com */
    .divTable{
        display: table;
        width: 100%;
    }
    .divTableRow {
        display: table-row;
    }
    .divTableHeading {
        background-color: #EEE;
        display: table-header-group;
    }
    .divTableCell, .divTableHead {
        border-bottom: 1px solid #cccccc;
        display: table-cell;
        padding: 3px 10px;
        font-size: 10px;
    }
    .borderRight{
        border-right:1px solid #cccccc !important;
    }
    .borderBottomN{
        border-bottom:none;
    }
    .borderBottom{
        border-bottom:1px solid #cccccc !important;
    }
    .borderLeft{
        border-left:1px solid #cccccc !important;
    }
    .divTableHeading {
        background-color: #EEE;
        display: table-header-group;
        font-weight: bold;
    }
    .divTableFoot {
        background-color: #EEE;
        display: table-footer-group;
        font-weight: bold;
    }
    .divTableBody {
        display: table-row-group;
    }


</style>

<table width="750px" border="0" cellspacing="10" style="margin-left:-28px;">
    <tr>
        <?php if($OrderInfo[0]->Domain=='123'){ ?>
            <td width="30%"><img src="http://www.123-labels.co.uk/images/email_logo.png" ></td>
        <?php }else{ ?>
            <td width="30%"><img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>/theme/site/images/logo.png" border="0" width="200" height="70" /></td>
        <?php } ?>
        <td width="30%">&nbsp;</td>
        <td width="30%" align="left" valign="middle"><h3 style="color:#999999;">
                <?php


                //$invoice = $this->notemodel->getinvoicenumber($OrderInfo[0]->OrderNumber);
                echo 'Invoice : <font color="#000000"> '.$invoice. '</font>';
                ?>





            </h3></td>
    </tr>
    <tr>
       
    <td align="left" valign="top" class="print_address">
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
    </td>
        
        <td align="right" valign="top"><table width="100%" border="0">
                <tr>
                    <td align="right" class="print_address">Phone: </td>
                </tr>
                <!-- <tr>
                   <td align="right" valign="top" class="print_address">Fax: </td>
                 </tr>-->
                <tr>
                    <td align="right" valign="top" class="print_address">Email: </td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="print_address">VAT No: </td>
                </tr>
            </table></td>
        <td align="left" valign="top"><table width="100%" border="0">
                <tr>
                    <td align="left" class="print_address"><span class="phone_right">01733 588 390</span></td>
                </tr>
                <!--   <tr>
                     <td align="left" valign="top" class="print_address">01733 425 106 </td>
                   </tr>-->
                <tr>
                    <td align="left" valign="top" class="print_address"><span class="phone_right">
            <?php if($OrderInfo[0]->Domain=='123'){ ?>
                <a href="helpdesk@123-labels.co.uk" style="text-decoration:none; color:#000000;">helpdesk@123-labels.co.uk</a>
            <?php }else{ ?>
                <a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#000000;">customercare@aalabels.com</a>
            <?php } ?>
            </span></td>
                </tr>
                <tr>
                    <td align="left" valign="top" class="print_address"><span class="phone_right">
                       <?php
                if(isset($OrderInfo[0]->BillingCountry) && $OrderInfo[0]->BillingCountry == 'France'){
                    echo "FR 21 851063453";
                } else{
                    echo "GB 945 028 620";
                }
              ?> 
                    </span></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;">Invoice Information</h3></td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding-top:10px;"><table width="100%" border="0" cellspacing="3" cellpadding="0">


                            <tr>
                                <td class="print_address"><b>Invoice Number:</b></td>
                                <td class="print_address"><?php echo $invoice;   ?></td>
                            </tr>

                            <tr>
                                <td class="print_address"><b>Order Number:</b></td>
                                <td class="print_address"><?php echo $OrderInfo[0]->OrderNumber;   ?></td>
                            </tr>

                            <!-- <tr>
           <td class="print_address"><b>Order:</b></td>
           <td class="print_address"><?
                            if($OrderInfo[0]->PaymentMethods == "specialOrders" ){echo "Special orders";}elseif($OrderInfo[0]->Source =="website"){echo "Website";}
                            elseif($OrderInfo[0]->PaymentMethods=="SampleOrder")
                            {
                                echo "Request Samples";
                            }
                            ?></td>
         </tr> -->



                            <? if($OrderInfo[0]->CustomOrder!="" and $OrderInfo[0]->CustomOrder!=""){?>
                                <tr>
                                    <td class="print_address"><b> VAT Number:</b></td>
                                    <td class="print_address"><?php echo $OrderInfo[0]->CustomOrder; ?>
                                    </td>
                                </tr>
                            <? } ?>


                            <tr>
                                <td class="print_address"><b>Date:</b></td>
                                <td class="print_address"><?php echo date('jS F Y', $OrderInfo[0]->OrderDate); ?></td>
                            </tr>
                            <tr>
                                <td class="print_address"><b>Time:</b></td>
                                <td class="print_address"><?php echo date('h:i:s A', $OrderInfo[0]->OrderTime); ?></td>
                            </tr>

                            <? if($OrderInfo[0]->PurchaseOrderNumber!=""){?>
                                <tr>
                                    <td class="print_address"><b>PO Number:</b></td>
                                    <td class="print_address"><?php echo $OrderInfo[0]->PurchaseOrderNumber; ?>
                                    </td>
                                </tr>
                            <? } ?>






                            <? if($OrderInfo[0]->OrderStatus==7 || $OrderInfo[0]->OrderStatus==8 ){?>
                                <tr>
                                    <td class="print_address"><b>Tracking No:</b></td>
                                    <td class="print_address">  <?php echo $OrderInfo[0]->DeliveryTrackingNumber; ?>        </td>
                                </tr>

                                <tr>
                                    <td class="print_address"><b>Dispatch Date:</b></td>
                                    <td class="print_address"> <?php if($OrderInfo[0]->DispatchedDate) { echo date("d-m-Y",$OrderInfo[0]->DispatchedDate); }?></td>
                                </tr>

                                <tr>
                                    <td class="print_address"><b>Dispatch Time:</b></td>
                                    <td class="print_address"> <?php if($OrderInfo[0]->DispatchedTime) { echo date("h:i:s A",$OrderInfo[0]->DispatchedTime); }?> </td>
                                </tr>
                            <? } ?>


                            <? //$objOrders->getStatusTitle($OrderInfo[0]['OrderStatus']) ?></td>
                            </tr>
                        </table></td>
                </tr>
            </table></td>

        <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;">Billing address</h3></td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding-top:10px; padding-left:5px;"><div class="print_address">
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

                        <!--<div class="print_address">BillingCountry<? //$OrderInfo[0]['BillingCountry']?></div>-->

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
                        </div></td>
                </tr>
            </table></td>
        <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;"><span style="white-space:nowrap;">Delivery address</span></h3></td>
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

                        <!--<div class="print_address">BillingCountry<?=$OrderInfo[0]->BillingCountry?></div>-->

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
                        </div></td>
                </tr>
            </table></td>



    </tr>



</table>


            <div     style="width:750px; margin-left:-28px; border: 0; " class="divTable">
                <div class="divTableBody"  >
                    <div class="divTableRow"  >


                        <div class="invoicetable_PCode divTableCell borderBottomN " style="width: 100px;" >Product Code</div>
                        <div class="invoicetable_description divTableCell borderBottomN"style="width: 300px;">Description</div>
                        <div class="invoicetable_sml_headings divTableCell borderBottomN"style="width: 50px;">Unit Price</div>
                        <div class="invoicetable_Qty divTableCell borderBottomN" style="width: 50px;">Qty</div>
                        <div class="invoicetable_sml_headings divTableCell borderBottomN" style="width: 50px;">Price</div>
                    </div>
                    <?php


                    $exvat=0;
                    $incvat=0;
                    $exVatPrice = 0;
                    $incVatPrice = 0;
                    $currencySymbol = "&pound;";
                    $i=0;
                    foreach ($OrderDetails as $AccountDetail) {
                        $i++;
                        //                for($i=0;$i<count($OrderDetails);$i++)
                        //                {
                        if($i%2==0)
                        {
                            $css="class='table_blue_bar'";
                        }
                        else
                        {
                            $css="class='table_white_bar'";
                        }

                        if($AccountDetail->ProductID == 0)
                        {

                            $ManufactureID=$AccountDetail->ManufactureID;
                            $productName=$AccountDetail->ProductCategoryName;
                            $Price=$AccountDetail->Price;
                            $Quantity=$AccountDetail->Quantity;
                            $Btndisplays='display:inline;';

                        }
                        else
                        {

                            $ManufactureID= $this->accountmodel->manufactureid("",$AccountDetail->ProductID);
                            $productName=$AccountDetail->ProductCategoryName;
                            $Price=$AccountDetail->Price;
                            $Quantity=$AccountDetail->Quantity;
                            $Btndisplays='display:none;';

                        }

                        if($AccountDetail->Quantity!=0)
                        {
                            ?>



                            <?
                            //                        $Order->currency       = (isset($OrderInfo[0]->currency) && $OrderInfo[0]->currency!='')?$OrderInfo[0]->currency:'GBP';
                            $exchange_rate         = (isset($OrderInfo[0]->exchange_rate) && $OrderInfo[0]->exchange_rate!=0)?$OrderInfo[0]->exchange_rate:1;
                            $symbol                = $this->orderModal->get_currecy_symbol($OrderInfo[0]->currency);
                            ?>


                            <div class="divTableRow" style="width:750px;">
                                <div class="divTableCell borderLeft" style="width: 100px;"><?=$ManufactureID?></div>
                                <div class="divTableCell   borderLeft" style="width: 300px;"> <?php $productname =  $this->orderModal->ReplaceHtmlToString_($AccountDetail->ProductCategoryName); echo $productname; ?></div>
                                <div class="divTableCell   borderLeft" style="width: 50px;"><? echo  $symbol."".round(($Price/$Quantity)*$exchange_rate,4)?></div>
                                <div class="divTableCell   borderLeft" style="width: 50px;text-align: center;"><?=$Quantity?></div>
                                <div class="divTableCell borderRight borderLeft " style="width: 50px;text-align: center;"><?php
                                    if($OrderInfo[0]->PaymentMethods == 'SampleOrder'){
                                        $exvat ='0.00';
                                    } else{
                                        $exvat = $AccountDetail->Price;
                                    }
                                    ?>
                                    <?  echo $symbol."".(number_format($exvat*$exchange_rate,2));?></div>
                            </div>

                            <?php
                            $incvat = number_format($exvat*vat_rate,'2','.','');

                            $stylo = "";
                            //if($AccountDetail->Printing=="Y" && preg_match('/A4/is',$AccountDetail->ProductName)){}else{
                            if($AccountDetail->Printing=="Y"){}else{
                                $stylo = "style='display:none;'";
                            }
                            ?>


                            <div class="divTableRow borderLeft" <?=$stylo?>>
                                <div class="divTableCell borderLeft borderBottom"  >&nbsp;</div>

                                <?php $print_style='font-size: 8px;'; $AccountDetail = $AccountDetail; include('print_line_txt.php');  ?>


                                <div class="divTableCell borderRight borderLeft" >
                                    <? //$price = number_format($AccountDetail->Print_UnitPrice,3,'.',''); ?>
                                    <?  //echo $symbol." ".(number_format($price*$exchange_rate,2));?>

                                </div>
                                <div class="divTableCell borderRight" style="text-align: center;">

                                    <?php echo $print_qty =  $AccountDetail->Print_Qty; ?>

                                </div>
                                <div class="divTableCell borderRight" style="text-align: center;">

                                    <? $print_exvat = $AccountDetail->Print_Total;?>
                                    <? $print_incvat = $AccountDetail->Print_Total*1.2;?>

                                    <?php
                                    if ($AccountDetail->FinishTypePricePrintedLabels != '' && $AccountDetail->total_emb_cost != 0){
                                        echo $symbol."".(number_format(($print_exvat*$exchange_rate)-$AccountDetail->total_emb_cost,2));
                                    } else {
                                        echo $symbol."".(number_format($print_exvat*$exchange_rate,2));
                                    }
                                    ?>

                                </div>
                            </div>

                            <? $stylo_prl = "";
                            if($ManufactureID=="PRL1"){
                                $result = $this->quoteModel->get_details_roll_quotation($AccountDetail->Prl_id);
                            }else{
                                $stylo_prl = "style='display:none;'";
                            }
                            ?>


                            <div class="divTableRow" <?=$stylo_prl?>>
                                <div class="divTableCell">&nbsp;</div>
                                <div class="divTableCell"><strong>Shape:</strong>

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
                                    &nbsp;&nbsp;


                                </div>
                                <div class="divTableCell">&nbsp;</div>
                                <div class="divTableCell">&nbsp;</div>
                                <div class="divTableCell">&nbsp;</div>
                            </div>

                            <?php
                            if ($AccountDetail->Printing == 'Y' && $AccountDetail->FinishTypePricePrintedLabels != '') { ?>

                                <div class="divTableRow borderLeft" <?=$stylo?>>
                                    <div class="divTableCell borderLeft borderBottom"  >&nbsp;</div>
                                    <div class="divTableCell borderLeft borderBottom"  >Finish</div>
                                    <div class="divTableCell borderRight borderLeft" ></div>
                                    <div class="divTableCell borderRight" style="text-align: center;"></div>
                                    <div class="divTableCell borderRight" style="text-align: center;"> </div>
                                </div>


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

                                            <div class="divTableRow borderLeft" <?=$stylo?>>
                                                <div class="divTableCell borderLeft borderBottom"  >&nbsp;</div>
                                                <div class="divTableCell borderLeft borderBottom"  ><?= "<b>".$parsed_parent_title." : </b>".$parsed_child_title?></div>
                                                <div class="divTableCell borderRight borderLeft" >
                                                    <?= $symbol." ".number_format((($parsed_title_price+$plate_cost) / $Quantity) * $exchange_rate, 2, '.', '') ?>
                                                </div>
                                                <div class="divTableCell borderRight" style="text-align: center;"></div>
                                                <div class="divTableCell borderRight" style="text-align: center;">
                                                    <?php echo $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2) ;?>
                                                </div>
                                            </div>

                                            <?php
                                        }

                                    } else if($parent_id != 1 && $parent_id != 5) { //For other than varnish and sequen
                                        $parsed_parent_title = ucwords(str_replace("_", " ", $parsed_parent_title));
                                        $parsed_child_title = $parsed_title;
                                        $parsed_title_price = $lem_option->finish_price+$plate_cost;
                                        ?>

                                        <div class="divTableRow borderLeft" <?=$stylo?>>
                                            <div class="divTableCell borderLeft borderBottom"  >&nbsp;</div>
                                            <div class="divTableCell borderLeft borderBottom"  ><?= "<b>".$parsed_parent_title." : </b>".$parsed_child_title?></div>
                                            <div class="divTableCell borderRight borderLeft" >
                                                <?= $symbol." ".number_format((($parsed_title_price+$plate_cost) / $Quantity) * $exchange_rate, 2, '.', '') ?>
                                            </div>
                                            <div class="divTableCell borderRight" style="text-align: center;"></div>
                                            <div class="divTableCell borderRight" style="text-align: center;">
                                                <?php echo $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2); ?>
                                            </div>
                                        </div>

                                    <?php } else { //For Sequential Data ?>

                                        <tr>
                                            <td></td>
                                            <td>Sequential Variable Data</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php
                                                echo $symbol." ".number_format((sequential_price * $exchange_rate), 2) ;

                                                ?>
                                            </td>
                                        </tr>

                                        <div class="divTableRow borderLeft" <?=$stylo?>>
                                            <div class="divTableCell borderLeft borderBottom"  >&nbsp;</div>
                                            <div class="divTableCell borderLeft borderBottom"  >Sequential Variable Data</div>
                                            <div class="divTableCell borderRight borderLeft" >
                                                <?= $symbol." ".number_format((sequential_price / $Quantity) * $exchange_rate, 2, '.', '') ?>
                                            </div>
                                            <div class="divTableCell borderRight" style="text-align: center;"></div>
                                            <div class="divTableCell borderRight" style="text-align: center;">
                                                <?php echo $symbol." ".number_format((sequential_price * $exchange_rate), 2) ; ?>
                                            </div>
                                        </div>

                                    <?php  }
                                    $index++;
                                } ?>
                            <?php } ?>


                            <div class="divTableRow ">
                                <div class="divTableCell borderLeft">&nbsp;</div>
                                <div class="divTableCell" >&nbsp;</div>
                                <div class="divTableCell invoicetable_sml_headings"  style="padding:0px !important;">
                                    <div><b>Line Total :</b></div>
                                </div>
                                <div class="divTableCell" ></div>
                                <div class="divTableCell invoicetable_sml_headings" >
                                    <? $linetotalexvat = $print_exvat + $exvat;?>
                                    <?  echo $symbol."".(number_format($linetotalexvat*$exchange_rate,2));?>



                                </div>
                                <? $linetotalinvat = $print_incvat + $incvat;?>
                            </div>



                            <?

                            $exVatPrice += $linetotalexvat;
                            $incVatPrice += $linetotalinvat;

                        }
                        //$incvat = number_format($AccountDetail->Price*$AccountDetail->Quantity,2,'.','');




                    }

                    $incVatPrice  = $exVatPrice * 1.2;
                    if($OrderInfo[0]->voucherOfferd=='Yes'){

                        $discount = $OrderInfo[0]->voucherDiscount;
                    }else
                        if($OrderInfo[0]->DiscountInPounds != 0.00){
                            $discount = $OrderInfo[0]->DiscountInPounds;
                        }else{

                            $discount = 0.00;
                        }



                    $vatRate = vat_rate;

                    $exdelivery = number_format($OrderInfo[0]->OrderShippingAmount/$vatRate,2,'.','');

                    $deliveryExVatAmount = $OrderInfo[0]->OrderShippingAmount - $exdelivery;

                    $ship_invat  = $OrderInfo[0]->OrderShippingAmount;
                    $gt_invat    = $ship_invat+$incVatPrice;


                    $gt_invat = $gt_invat-$discount;
                    $discount = $discount/$vatRate;


                    ?>









                    <div class="divTableRow " >
                        <div class="divTableCell borderLeft borderBottomN" >&nbsp;</div>
                        <div class="divTableCell borderBottomN"  >&nbsp;</div>
                        <div class="divTableCell invuice_subtotal borderRight  "    >Delivery:</div>

                        <div class="divTableCell borderRight  "  >&nbsp;</div>
                        <div class="divTableCell invuice_subtotal_price borderRight  "  >

                            <?
                            if($exdelivery > 0){
                                $exdelivery = number_format($OrderInfo[0]->OrderShippingAmount/$vatRate,2,'.','');
                                echo $symbol."".(number_format($exdelivery*$exchange_rate,2));
                            }else{
                                echo " Free Delivery";
                            }
                            ?>

                        </div>
                    </div>
                    <? if($discount > 0){?>

                        <div class="divTableRow">
                            <div class="divTableCell borderLeft borderBottomN">&nbsp;</div>
                            <div class="divTableCell invuice_subtotal borderRight borderBottomN">Discount:</div>
                            <div class="divTableCell borderRight  "><? echo $symbol."".(number_format($discount*$exchange_rate,2));?></div>
                        </div>
                    <? } ?>
                    <div class="divTableRow">
                        <div class="divTableCell borderLeft borderBottomN">&nbsp;</div>
                        <div class="divTableCell borderBottomN">&nbsp;</div>
                        <div class="divTableCell invuice_subtotal borderRight  ">Sub total:</div>
                        <div class="divTableCell borderRight  ">&nbsp;</div>

                        <div class="divTableCell borderRight">

                            <?php
                            if($OrderInfo[0]->PaymentMethods=='SampleOrder'){
                                $SubTotal ='0.00';
                                $SubTotal ;
                            } else{
                                $SubTotal = number_format($exVatPrice-$discount+$exdelivery,2,'.','');
                            } ?>

                            <?  echo $symbol."".(number_format($SubTotal*$exchange_rate,2));?>

                        </div>
                    </div>
                    <div class="divTableRow">
                        <div class="divTableCell borderLeft borderBottomN">&nbsp;</div>
                        <div class="divTableCell borderBottomN">&nbsp;</div>
                        <div class="divTableCell invuice_subtotal borderRight  ">VAT @ (20.00)%</div>
                        <div class="divTableCell borderRight  ">&nbsp;</div>

                        <div class="divTableCell invuice_subtotal_price borderRight ">
                            <?

                            if($OrderInfo[0]->vat_exempt=='yes'){
                                $vat = 0.00;
                            }else{
                                $vat = $gt_invat - $SubTotal;
                            }
                            echo $symbol."".(number_format($vat*$exchange_rate,2));?>

                        </div>
                    </div>

                    <?php

                    if($OrderInfo[0]->DiscountInPounds=='0.00'){
                        $incVat = number_format($incVatPrice,2,'.','');
                        $show_price_incvat = number_format(($gt_invat),2,'.','');
                    }else{
                        $incVat = number_format($OrderInfo[0]->DiscountedPrice,2,'.','');
                        $show_price_incvat = $OrderInfo[0]->DiscountedPrice;
                    }
                    ?>

                    <?
                    if($OrderInfo[0]->vat_exempt=='yes'){
                        $show_price_incvat = $SubTotal;
                    }
                    ?>

                    <div class="divTableRow">
                        <div class="divTableCell borderLeft">&nbsp;</div>
                        <div class="divTableCell">&nbsp;</div>
                        <div class="divTableCell invuice_subtotal borderRight"><strong>Grand Total:</strong></div>
                        <div class="divTableCell borderRight">&nbsp;</div>

                        <div class="divTableCell invuice_subtotal_price borderRight">
                            <b>
                                <? echo $symbol."".(number_format($show_price_incvat*$exchange_rate,2));?>
                            </b>

                        </div>
                    </div>
                </div>
            </div>


<div class="adminsp_space"></div>





