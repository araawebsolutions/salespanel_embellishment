<style>

    .chzn-container {
        display: block;
        font-size: 13px;
        position: relative;
    }
    .chzn-container-active .chzn-single-with-drop {
        background-color: #eee;
        background-image: -moz-linear-gradient(center bottom , white 0px, #eee 17%);
        border: 1px solid #aaa;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        box-shadow: 0 1px 0 #fff inset;
    }

    .chzn-container-single .chzn-single {

        color: #444;
        display: block;
        height: 26px;
        line-height: 26px;
        overflow: hidden;
        padding: 0 0 0 8px;
        position: relative;
        text-decoration: none;
        white-space: nowrap;
    }
    .chzn-container-active .chzn-single-with-drop div b {
        background-position: -18px 1px;
    }
    .chzn-container-single .chzn-single div b {
        display: block;
        height: 100%;
        width: 100%;
    }
    .chzn-container-active .chzn-single-with-drop div {
        background: none repeat scroll 0 0 transparent;
        border-left: medium none;
    }

</style>
<?php foreach ($AccountInfo as $Order) {

}?>

<?php

$symbol        = $this->quotationModal->get_currecy_symbol($Order->currency);
$exchange_rate = $Order->exchange_rate;

?>
<div role=main class=container_12 id=content-wrapper>
    <div id=main_content>
        <h2 class=grid_14> Check Out</h2>
        <div class=clean></div>
    </div>
    <div class="clear 10"></div>




    <fieldset class="mainField" >
        <?php $QuoteNumber = end($this->uri->segments) ?>
        <div class="enquiryFieldset" >

            <table class="table" id="table-example">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Product </th>
                    <th>Description</th>
                    <th>Labels</th>
                    <th>Quantity</th>
                    <th>Ex. Vat</th>
                    <th>Incl. Vat</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $total_exvat=0;
                $total_invat=0;
                $i=0;
                foreach ($AccountDetails as $AccountDetail) {
                    $i++;
                    $print_exvat = $print_incvat = 0;
                    $LabelsPerSheet = 1;
                    $colorcode = (isset($AccountDetail->colorcode) and $AccountDetail->colorcode!='')?'-'.$AccountDetail->colorcode:'';

                    if($AccountDetail->ProductID==0){
                        $ManufactureID= $AccountDetail->ManufactureID;
                        $disabled = "true";
                    }else{
                        $ManufactureID= $this->quotationModal->manufactureid("",$AccountDetail->ProductID);
                        $LabelsPerSheet= $this->quotationModal->LabelsPerSheet($AccountDetail->ProductID);
                        if(isset($AccountDetail->is_custom) and $AccountDetail->is_custom=='Yes'){
                            $LabelsPerSheet = $AccountDetail->LabelsPerRoll;
                        }
                        $disabled = "false";

                    }


                    $total_labels = $LabelsPerSheet*$AccountDetail->Quantity;
                    if($AccountDetail->Printing == 'Y'){
                        $labels = $this->quotationModal->calculate_total_printed_labels($AccountDetail->SerialNumber);
                        if($labels > 0){ $total_labels =$labels;}

                        if($AccountDetail->orignalQty !="" && $AccountDetail->orignalQty !=0){
                            $total_labels = $AccountDetail->orignalQty;
                        }
                    }



                    $img = $this->quotationModal->getproductimg($AccountDetail->ProductID, $colorcode);

                    $serialNo = $AccountDetail->SerialNumber;



                    if($i%2==0){
                        $sty = 'style="background-color:#efefef;"';
                        $classes = "greyer";
                    }else{

                        $sty = 'style="background-color:#fff;"';
                        $classes = "whiter";
                    }
                    ?>

                    <tr class="gradeA odd">

                        <td><img src="<?=$img?>" width="30"  border="0"/></td>
                        <td>
                            <?php

                            echo $ManufactureID;

                            ?>

                        </td>

                        <?
                        $extra_int_text = '';
                        $prodinfo = $this->quotationModal->getproductdetail($AccountDetail->ProductID);
                        if(preg_match('/Integrated Labels/',$prodinfo['ProductBrand'])){
                            $extra_int_text = ($AccountDetail->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)";
                        }

                        ?>


                        <td><?php echo $AccountDetail->ProductName.$extra_int_text; ?>
                            <?   if($ManufactureID=="SCO1"){
                                $custominfo = $this->quotationModal->fetch_custom_die_quote($AccountDetail->SerialNumber);
                               // print_r($custominfo);exit;
                                include('includes/assc_die.php');
                            }
                            ?>
                        </td>
                        <!-- <td>
                      <?php
                        $price=number_format($AccountDetail->Price,2,'.','');




                        ?></td>  -->

                        <td><?=$total_labels?> </td>
                        <td><?php

                            echo $AccountDetail->Quantity ;

                            ?></td>

                        <?
                        $exvat = number_format($AccountDetail->ProductTotalVAT,2,'.','');
                        $invat = number_format($AccountDetail->ProductTotal,'2','.','');
                        ?>
                        <td><? echo $symbol."".(number_format($exvat * $exchange_rate,2)); ?></td>
                        <td><? echo $symbol."".(number_format($invat * $exchange_rate,2)); ?></td>



                    </tr>







                    <?
                    $stylo = "";
                    if($AccountDetail->Printing =="Y"){
                    }else{
                        $stylo = "style='display:none;'";
                    }
                    ?>

                    <style>
                        .greyer{background-color:#efefef;}.whiter{background-color:#fff;}
                    </style>

                    <tr <?=$stylo?> class="<?=$classes?>">
                        <td colspan="2"></td>
                        <?php 	   $showartowrks ='Yes';$AccountDetail->Wound =$AccountDetail->wound; include('order_quotation/quotation/print_line_txt.php');  ?>
                        <td>&nbsp;</td>

                        <td><?php echo $AccountDetail->Print_Qty; ?></td>

                        <?  $print_exvat  = $AccountDetail->Print_Total;
                        $print_incvat = $AccountDetail->Print_Total*1.2;
                        ?>
                        <td><? echo $symbol."".(number_format($print_exvat*$exchange_rate,2)); ?></td>
                        <td><? echo $symbol."".(number_format($print_incvat*$exchange_rate,2)); ?></td>

                    </tr>




                    <? $stylo_prl = "";
                    if($ManufactureID=="PRL1"){
                        $result = $this->quotationModal->get_details_roll_quotation($AccountDetail->Prl_id);
                    }else{
                        $stylo_prl = "style='display:none;'";
                    }
                    ?>

                    <tr <?=$stylo_prl?>>
                        <td colspan="2"></td>

                        <td style="border-left:none !important;">
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>

                    <? $Excus = $Inccus = 0;
                    if($ManufactureID=="SCO1"){
                        include('includes/scoline2.php');
                    }
                    ?>

                    <?php
                    $toexvat =  $print_exvat + $exvat + $Excus;
                    $toncvat =  $print_incvat + $invat + $Inccus;


                    $total_exvat  += $toexvat ;
                    $total_invat += $toncvat ;
                }
                ?>
                </tbody>
            </table>

            <div class="grid_8">
                <?  $disuntoffer = 0.00;
                $wtp_offer =  $this->quotationModal->check_wtp_quotation_offer_voucher($QuoteNumber);
                if($wtp_offer==true){


                    $disount_applied = $this->quotationModal->check_wtp_voucher_applied_quotation($QuoteNumber, $total_invat);
                    if($disount_applied){
                        $disuntoffer = $disount_applied['discount_offer']; ?>

                        <div class="colm-3">

                            <a style="margin-top:20px; float:left; margin-left:16px; font-size:20px;color:#0077cf; text-decoration:underline !important; "
                               href="javascript:hide_wtp_voucher_box();">
                                <i class="fa fa-minus-circle" style=" color:#0077cf;"></i>
                                Remove Voucher Code?
                            </a>
                        </div>

                    <? }else{?>
                        <div class="row" style="margin-top:20px;">
                            <div class="colm-1">Voucher Code : </div>

                            <div class="colm-2">
                                <input id="voucher_code" class="input-text" type="text" value="WTP10"  style=" float:left; margin-left:0px; width:88px; height:18px; margin-top:5px;">
                                <button onclick="check_wtp_voucher();" style="width:67px;margin-top:5px; float:left;margin-left:10px;" class="actions-right" type="button"> Apply</button>
                            </div>
                        </div>


                    <?	} ?>


                <? }else{

                    $voucher = $this->quotationModal->calculate_total_printedroll_amount($QuoteNumber);
                    if($voucher > 0){
                        $disuntoffer = $voucher;
                    }



                } ?>


            </div>

            <ul class="stats-list">
                <li> Sub Total:
                    <span ><?php echo $symbol."".number_format($total_invat*$exchange_rate,2,'.','');?></span>
                    <span> <?php echo $symbol."".number_format($total_exvat*$exchange_rate,2,'.',''); ?></span>
                </li>
                </tr>
                <?
                $ship_invat = number_format($Order->QuotationShippingAmount,2,'.','');
                $ship_exvat = number_format($Order->QuotationShippingAmount/vat_rate,2,'.','');
                ?>

                <style>
                    #seldelchrg .chzn-container-single .chzn-single span{overflow: visible !important;float:left !important; padding-left:0px  !important; background:none  !important; }
                    #seldelchrg .chzn-container .chzn-results .highlighted{ background:none;}
                    #seldelchrg .stats-list li{ height:20px;}
                </style>
                <div class="colm-4" style="border:1px solid #e0e0e0;">
                    <div class="colm-4" id="seldelchrg" style="width:272px; margin-left:60px; font-size:12px !important; font-weight:normal !important;">
                        <select id="c1" class="shipid" name="shippingcharges"  onChange="update_shiping(this.value);">
                            <?php  $basiccharges = 0.00;
                            $county = $this->quotationModal->getShipingServiceName($Order->ShippingServiceID);
                            $ShipingService = $this->quotationModal->getShipingService($county['CountryID']);

                            foreach($ShipingService as $res){
                                $selected = '';
                                if($res['ServiceID'] == $Order->ShippingServiceID ){
                                    $basiccharges = $res['BasicCharges'];
                                    $selected =  ' selected="selected" '; }

                                if ( $total_invat < 25.00 && $res['ServiceID']==20)
                                {
                                    continue;

                                } else{
                                    ?>
                                    <option value="<?=$res['ServiceID']?>"  <?=$selected?> >
                                        <?php
                                        if($res['BasicCharges']=='0.00'){
                                            echo $res['ServiceName'];
                                        }
                                        else
                                        {
                                            echo $res['ServiceName'].' &nbsp;'.$symbol.number_format($res['BasicCharges']* $exchange_rate, 2, '.', '');
                                        }
                                        ?>
                                    </option>

                                <?php } }  ?>
                            <option value="11"  <? if(11 == $Order->ShippingServiceID ){echo " selected ";} ?>> Collection In Person</option>
                            <option value="33"  <? if(33 == $Order->ShippingServiceID ){echo " selected ";} ?>> SWAPIT</option>
                        </select>
                    </div>

                </div>
                <li>Delivery Total:

                    <span> <?php echo $symbol."".number_format($ship_invat*$exchange_rate,2,'.',''); ?></span>
                    <span><?php echo  $symbol."".number_format($ship_exvat*$exchange_rate,2,'.',''); ?> </span>

                </li>
                <li>Discount:

                    <span> <?php echo $symbol."".number_format($disuntoffer*$exchange_rate,2,'.',''); ?> </span>
                </li>
                <?
                $ship_invat = number_format($ship_invat+$total_invat-$disuntoffer,2,'.','');
                $ship_exvat = number_format($ship_exvat+$total_exvat,2,'.','');
                $vat_Exempt = $ship_invat - $ship_exvat;

                ?>



                <? if($Order->vat_exempt=='yes'){?>
                    <li>Vat Exempt:

                        <span> -  <?php echo $symbol."".number_format($vat_Exempt*$exchange_rate,2,'.',''); ?> </span>
                    </li>

                    <? $ship_invat = $ship_exvat;

                } ?>




                <li>
                    Grand Total:

                    <span> <?php echo $symbol."".number_format($ship_invat*$exchange_rate,2); ?></span>
                    <span> <?php echo $symbol."".number_format($ship_exvat*$exchange_rate,2);  ?> </span>

                </li>


                <input id="grand_total_voucher" type="hidden" value="<?=$total_invat-$disuntoffer?>" />
                <input id="quotenumber" type="hidden" value="<?=$QuoteNumber?>" />

            </ul>

            <div class="clear 10"></div>
            <div style="margin-left:10%">  <h2> Customer information</h2> </div>


            <div style="margin-bottom:20px;margin-left:10%;" class="grid_5">
                <div class="box">

                    <div class="header">
                        <img src="http://gtserver/latest_ci/aalabels/img/ui-tab.png" height="16" width="16">
                        <h3>Billing Address </h3>
                    </div>

                    <div class="content" style="min-height:320px;">
                        <div class="row" style="margin-top:20px;"></div>


                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Title &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingTitle ; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                First Name &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingFirstName ; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Last Name &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo  $Order->BillingLastName; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Address 1 &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingAddress1; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Address 2 &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingAddress2; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                City &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingTownCity; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                County /State &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingCountyState; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Country &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo 'United Kingdom'; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Postcode &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingPostcode; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Telephone &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->Billingtelephone; ?>                        </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Fax &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->Billingfax; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Company Name &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->BillingCompanyName; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Residential/Commercial  :
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php
                                if($Order->BillingResCom==1){echo "Residential";}
                                if($Order->BillingResCom==2){echo "Commercial";}

                                ?>                        </div>
                        </div>




                    </div>
                </div>
            </div>
            <div style="margin-bottom:20px;" class="grid_5">
                <div class="box">

                    <div class="header">
                        <img src="http://gtserver/latest_ci/aalabels/img/ui-tab.png" height="16" width="16">
                        <h3>Delivery Address </h3>
                    </div>

                    <div class="content" style="min-height:320px;">
                        <div class="row" style="margin-top:20px;"></div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Title &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryTitle ; ?>                        </div>
                        </div>


                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                First Name &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryFirstName; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Last Name &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryLastName; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Address 1 &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryAddress1; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Address 2 &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryAddress2; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                City &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryTownCity; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                County / State &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryCountyState; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Postcode &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryPostcode; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Fax &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php
                                if(!empty($Order->Deliveryfax)){
                                    echo  $Order->Deliveryfax;} ?>                       </div>
                        </div>


                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Phone &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->Deliverytelephone; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Company Name &nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->DeliveryCompanyName; ?>                        </div>
                        </div>
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Residential/Commercial&nbsp;:
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php
                                if($Order->DeliveryResCom==1){echo "Residential";}
                                if($Order->DeliveryResCom==2){echo "Commercial";}

                                ?>                       </div>
                        </div>




                    </div>
                </div>
            </div>
            <?php
            $attributes = array('name' => 'myquote', 'id' => 'myquote' ,'onsubmit'=>'return checkpayment();' );

            echo form_open(base_url().'new_saleoperator/index.php/quotation/saveorder',$attributes); ?>


            <input type="hidden" value="AA" name="QuoteWebsite" id="QuoteWebsite" />



            <!--<div style="  margin-left:10%;" class="grid_3">
            <div class="box">
                <div class="header">
                    <img src="http://gtserver/latest_ci/aalabels/img/ui-tab.png" height="16" width="16">
                    <h3>Web Site: </h3>
                </div>
                 <div class="content" style="min-height:25px;">
                <div class="row">


                        <div style="width:100%;" class="colm-2">
                           <select name="QuoteWebsite" id="QuoteWebsite" style=" width:130px;">
                            <option value=""> -- Select Site -- </option>
                            <option value="AA"  >AA-Labels</option>
                            <option value="123">123-labels</option>
            </select>                   </div>
                    </div>
                 </div>
            </div>
            </div>-->
            <div class="clear 2"></div>

            <div style="margin-bottom:10px; margin-left:10%;" class="grid_3">
                <div class="box">
                    <div class="header">
                        <img src="http://gtserver/latest_ci/aalabels/img/ui-tab.png" height="16" width="16">
                        <h3>Payment Method: </h3>
                    </div>
                    <div class="content" style="min-height:65px;">
                        <div class="row">


                            <div style="width:100%;" class="colm-2">
                                <?php
                                $data = array(
                                    'name'        => 'quoteNo',
                                    'id'          => 'quoteNo',
                                    'value'		=> $Order->QuotationNumber,
                                    'type' => 'hidden'
                                );
                                echo form_input($data);
                                $option = array(
                                    ''  =>'-- Select Payment Option --',
                                    'creditCard' =>'Pay by credit / debit card',
                                    'paypal' =>'Pay by PayPal Account',
                                    'chequePostel' =>'Pay by cheque or BACS',
                                    'purchaseOrder' =>'purchaseOrder'
                                );
                                echo form_dropdown('payment',$option,'','id="payment" onchange=chagestatus(this.value,"'.$Order->QuotationID.'")');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <? if($Order->DeliveryCountry!='United Kingdom' || $Order->BillingCountry!='United Kingdom'){?>
                <div style="margin-bottom:10px; margin-left:20px;" class="grid_4">
                    <div class="box">
                        <div class="header"> <img src="<?=base_url()?>aalabels/img/ui-tab.png" height="16" width="16">
                            <h3>VAT number validation </h3>
                        </div>
                        <div class="content" style="min-height:65px;">
                            <div class="row">
                                <div class="colm-11 "> &nbsp;</div>
                                <div class="colm-3" style="">
                                    <input id="Vat" name="Vat" type="text" placeholder="Enter Vat Number" class="text" style="width:200px; float:left;"
                                           onkeydown="$('#vat_pass').val('N');">
                                    <input type="hidden" value="N" id="vat_pass" name="vat_pass"/>
                                    <input style="float: left;width: 80px; margin-left:20px;" id="vat_validator" value="Verify Now" type="button">
                                </div>
                                <div class="colm-3" id="vat_info" style="display:none;">
                                    <p style="margin-top:8px; float:left;"> <span id="vat_name"></span><br />
                                        <span id="vat_address"></span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>




            <div style="float :left;display: inline-flex;margin-top: 7%">
                <input style="float: right;width: 120px;" type="button" onclick="" value="Back"> &nbsp; &nbsp;

                <input style="float: right;width: 110px;margin-right:10%" type="submit"   value="Finish">
                <?php    echo form_close();?>
            </div>
        </div>
    </fieldset>
</div>
<script>

    $(document).on("click", "#vat_validator", function(e) {
        var vatnumber = $('#Vat').val();
        var country = '<?=$Order->DeliveryCountry?>';
        if(vatnumber.length > 0){
            $("#dvLoading").css('display','block');
            $.ajax({
                url:"<?php echo backoffice_url();?>quotation/validate_vat",
                type:"POST",
                async:"false",
                data: {  country: country,vatNumber: vatnumber},
                dataType: "json",
                success: function(data){
                    if(data.status=='valid'){
                        $('#vat_pass').val('Y');
                        $('#vat_name').html('<strong>Name: </strong>'+data.name);
                        $('#vat_address').html('<strong>Address: </strong>'+data.address);
                        $('#vat_info').show();
                        $("#dvLoading").css('display','none');
                        //getpagedelivery('yes');
                    }else{
                        $('#vat_pass').val('N');
                        $('#vat_name').html('');
                        $('#vat_address').html('');
                        $('#vat_info').hide();
                        $("#dvLoading").css('display','none');
                        alert(data.message);

                    }
                }
            });
        }else{
            VATNumber = 'invalid';
            $('#vat_name').html('');
            $('#vat_address').html('');
            $('#vat_pass').val('N');
            $('#vat_info').hide();
            $("#dvLoading").css('display','none');
            alert("Please Enter a VAT number");

        }
    });


    function check_wtp_voucher(){

        var voucher = $.trim($("#voucher_code").val());
        var grand_total = $("#grand_total_voucher").val();
        var quotenumber = $("#quotenumber").val();


        $("#notify").css("left","35%");
        $("#notify").css("top","37%");

        if(voucher!=='' && voucher!==' '){
            var ajaxURL ='<?php echo backoffice_url();?>quotation/apply_wtp_vouvher_quotation/';

            $.ajax({
                url: ajaxURL,
                type:"POST",
                async:"false",
                data:{'voucher':voucher,'GrandTotal':grand_total,'quotenumber':quotenumber},
                dataType: "json",
                success: function(data){
                    if(data.is_error=='no'){
                        window.location.reload();

                    }else{

                        $.fallr("show",{buttons:{button1:{text:"OK",onclick:$.fallr("hide")}},content:"Please Enter a valid voucher code"});

                    }
                }
            });


        }


    }
    function hide_wtp_voucher_box(){

        var ajaxURL ='<?php echo backoffice_url();?>quotation/remove_wtp_voucher_offer/';
        $.ajax({
            url: ajaxURL,
            type:"POST",
            async:"false",
            dataType: "json",
            success: function(data){
                if(data.is_error=='no'){
                    window.location.reload();

                }
            }
        });
    }


    function checkpayment(id){
        var payment  = document.getElementById('payment').value;
        var QuoteWebsite  = document.getElementById('QuoteWebsite').value;
        if(payment==""){
            alert("Please Select Payment Method");
            return false;
        }
        if(QuoteWebsite==""){
            alert("Please Select Website");
            return false;
        }
    }
    // function chagestatus(val,id){
    //
    //
    //
    //     $.ajax({
    //
    //
    //
    //         url: '../changepayment',
    //
    //         data:{
    //
    //             method:val,
    //
    //             id:id
    //
    //         },
    //
    //         datatype:'json',
    //
    //         success:function(data){
    //
    //             //  location.reload();
    //
    //         }
    //
    //
    //
    //
    //
    //     });
    //
    // }


    function addnewline(quoteNo,userid){

        $.ajax({

            url: '../addnewitem',
            data:{
                quoteNo:quoteNo,
                userid:userid
            },
            datatype:'json',
            success:function(data){
                location.reload();
            }


        });
    }
    function update(val,id){
        if(val=="0"){
            var p_code  =  $('#p_code'+id).val();
            var p_name  =  $('#p_name'+id).val();
        }
        var p_qty  = $('#p_qty'+id).val();
        var p_price = $('#p_price'+id).val();

        $.ajax({

            url: '../updatequoteitem',
            data:{
                status:val,
                id:id,
                p_code: p_code,
                p_name:p_name,
                p_qty :p_qty,
                p_price : p_price,

            },
            datatype:'json',
            success:function(data){
                location.reload();
            }


        });
    }

    function generateorder(id){

        exit();
        $.ajax({

            url: '../generateorder',
            data:{

                id:id
            },
            datatype:'json',
            success:function(data){
                location.reload();
            }


        });
    }


    function update_shiping(ID){

        if(ID!=''){
            $.ajax({
                type: "post",
                url: "<?php echo backoffice_url();?>quotation/updateShipping",
                cache: false,
                data:{'ShippingID': ID,'quoteID':'<?=$Order->QuotationNumber?>'},
                dataType: 'html',
                success: function(data){
                    window.location.reload();
                }
            });
        }
    }
</script>