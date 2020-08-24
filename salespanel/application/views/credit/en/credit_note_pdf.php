<?php
error_reporting(1);
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2); ?>
<style>
    body{
        font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
    }
    .totals {
        color: red !important;
        text-align: center !important;
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
        width: 10px;
        /*width: 10%px;*/
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
            <img src="<?php echo ASSETS;?>assets/images/logo.png" border="0" width="160" height="66" />
        </td>
        <td width="30%" align="left" valign="middle" style="font-size: 14px">
            <?php echo '<b><span style="color: #999999">Credit Note:</span> <font color="#000000"> '.$ticketMains['ticketSrNo']. '</font></b>';
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
                    <td align="left" valign="top" class="print_address">23 Wainman Road,</td>
                </tr>
                <tr>
                    <td align="left" valign="top" class="print_address">Peterborough, </td>
                </tr>
                <tr>
                    <td align="left" valign="top" class="print_address">PE2 7BU <?php echo $data ?></td>
                </tr>
            </table>

            <!-- ------------------------------------->

        </td>
        <td align="left" valign="top" width="50%">

            <table width="100%" border="0">
                <tr>
                    <td align="left" class="print_address"><strong style="margin-left:80px;">Phone: </strong></td>
                    <td align="left" class="print_address"><span class="phone_right">
           01733 588 390
          </span></td>
                </tr>

                <tr>
                    <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">Email: </strong></td>
                    <td align="left" valign="top" class="print_address"><span class="phone_right">
                    <a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#257cac;">customercare@aalabels.com</a></span>

                </tr>
                <tr>
                    <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">VAT No: </strong></td>
                    <td align="left" valign="top" class="print_address"><span class="phone_right">
                  GB 945 028 620
              </span></td>
                </tr>
            </table>
        </td>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:10px;">
    <tr>

        <td width="34%" border="0" cellspacing="0" cellpadding="0" align="left" valign="middel" >

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px;white-space:nowrap; text-align:left;color:#fff;">&nbsp;&nbsp;Credit Note Information</h3></td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding-top:10px;padding-left:5px">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0">
                            <tr >
                                <td><b>Credit Note:  </b></td>
                                <td><?php echo $ticketMains['ticketSrNo'];   ?></td>
                            </tr>
                            <tr>
                                <td><b> Date: </b></td>
                                <td><?php echo date('jS F Y', strtotime($ticketMains['create_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><b> Time: </b></td>
                                <td><?php echo date('h:i:s A', strtotime($ticketMains['create_date'])); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>

        <td width="33%" border="0" cellspacing="0" cellpadding="0" align="left" valign="middel" style="border:#CCCCCC 1px solid; padding-bottom:10px;">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px;white-space:nowrap; text-align:left;color:#fff;">&nbsp;&nbsp;Billing address</h3></td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding-top:10px;padding-left:5px">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0">
                            <tr >
                                <td align="left" style="width: 30%"><b>Company: </b></td>
                                <td style="width: 70%"><?=$ticketMains['BillingCompanyName']?></td>
                            </tr>
                            <tr>
                                <td><b> Name: </b></td>
                                <td><?=$ticketMains['BillingFirstName'].' '.$ticketMains['BillingLastName']?></td>
                            </tr>
                            <tr>
                                <td><b> Email: </b></td>
                                <td><?=$ticketMains['BillingEmail']?></td>
                            </tr>
                            <tr>
                                <td><b> Address: </b></td>
                                <td><?=$ticketMains['BillingAddress1']?>
                                    &nbsp;
                                    <?=$ticketMains['BillingAddress2']?></td>
                            </tr>
                            <tr>
                                <td><b>City: </b></td>
                                <td><?=$ticketMains['BillingTownCity']?></td>
                            </tr>
                            <tr>
                                <td><b> Country: </b></td>
                                <td><?=$ticketMains['BillingCountry']?></td>
                            </tr>
                            <tr>
                                <td ><b>Postcode: </b></td>
                                <td><?=$ticketMains['BillingPostcode']?></td>
                            </tr>
                            <tr>
                                <td><b>Telephone: </b></td>
                                <td><?=$ticketMains['BillingTelephone']?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>


        <!-- -------------------------------------------->

        <td width="33%" border="0" cellspacing="0" cellpadding="0" align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px; white-space:nowrap; text-align:left;color:#fff;"><span style="white-space:nowrap;">&nbsp;&nbsp;Delivery address</span></h3></td>
                </tr>


                <tr>
                    <td align="left" valign="top" style="padding-top:10px; padding-left:5px;">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0">
                            <tr style="padding-top:10px; padding-left:5px;">
                                <td align="left" style="width:30%;"><b>Company: </b></td>
                                <td style="width: 70%"><?=$ticketMains['DeliveryCompanyName']?></td>
                            </tr>
                            <tr>
                                <td><b> Name: </b></td>
                                <td><?=$ticketMains['DeliveryFirstName'].' '.$ticketMains['DeliveryLastName']?></td>
                            </tr>
                            <tr>
                                <td><b> Email: </b></td>
                                <td><?=$ticketMains['BillingEmail']?></td>
                            </tr>
                            <tr>
                                <td><b> Address: </b></td>
                                <td><?=$ticketMains['DeliveryAddress1']?>
                                    &nbsp;
                                    <?=$ticketMains['DeliveryAddress2']?></td>
                            </tr>
                            <tr>
                                <td><b>City: </b></td>
                                <td><?=$ticketMains['DeliveryTownCity']?></td>
                            </tr>
                            <tr>
                                <td><b> Country: </b></td>
                                <td><?=$ticketMains['DeliveryCountry']?></td>
                            </tr>
                            <tr>
                                <td ><b>Postcode: </b></td>
                                <td><?=$ticketMains['DeliveryPostcode']?></td>
                            </tr>
                            <tr>
                                <td><b>Telephone: </b></td>
                                <td><?=$ticketMains['Deliverytelephone']?></td>
                            </tr>
                        </table>

                    </td>
                </tr>

            </table>
        </td>

    </tr>
</table>

<!-- -------------------------------------------->


<table width="527"  bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border:#CCCCCC 1px solid; padding-bottom:0px;table-layout:fixed;">
    <tr >
        <td class="invoicetable_bgBlue" width="15%">Product Code</td>
        <td class="invoicetable_bgBlue" width="55%">Description</td>
        <td class="invoicetable_bgBlue" width="15%">Quantity</td>
        <td class="invoicetable_bgBlue" width="15%">Line Total</td>
    </tr>

    <?php
    $i = 0;

    //$delivery_charges = 0;
    $total = 0;
    $sub_total = 0;
    $grand_total = 0;
    $curr_symbol = '';
    $vat = 0;
    foreach ($ticketDetails as $ticketDetail) {
        $returnCurrency = (isset($ticketDetail['returnCurrency']) && $ticketDetail['returnCurrency'] != '') ? $ticketDetail['returnCurrency'] : 'GBP';
        $symbol = $this->home_model->get_currecy_symbol($returnCurrency);
        $print_exvat=0;  $print_incvat=0;
        if($i%2==0){
            $css="class='table_blue_bar'";
        }else{
            $css="class='table_white_bar'";
        }
        ?>
        <tr>
            <td class="invoicetable_tabel_border"><?=($ticketDetail['ManufactureID']!='0')?$ticketDetail['ManufactureID']:'Custom Line' ?></td>
            <td class="invoicetable_tabel_border" style="width:360px !important;">
                <?=$ticketDetail['productDescription']?>
            </td>

            <td align="center" class="invoicetable_tabel_border"><?php echo $ticketDetail['returnQty']; ?></td>
            <td align="center" class="invoicetable_tabel_border">
                <?php   $line_total = number_format($ticketDetail['returnUnitPrice'],2,'.','');
                echo  $symbol." ".$line_total;
                ?>
            </td>
        </tr>


        <?php if($ticketDetail['Printing'] == 'Y'){ ?>
            <?php if($ticketDetail['returnQtyPrint'] > 0){
                $returnQtyPrint = ' <span>'.$ticketDetail["returnQtyPrint"].' Design</span> ';
            }else{
                $returnQtyPrint = '';
            } ?>
            <tr>
                <td class="invoicetable_tabel_border"></td>
                <td class="invoicetable_tabel_border" style="width:360px !important;">
                    <?php if($ticketDetail['ProductBrand'] != 'Roll Labels'){ ?>
                    <?=$ticketDetail['productDescriptionPrint']?>, <?php echo $returnQtyPrint ?>
                <?php }else{ ?>
                        <span><?php echo $ticketDetail['productDescriptionPrint']; ?></span>
                        <strong style="font-size:12px;"> Wound: </strong><span><?php echo $ticketDetail['Wound']; ?></span>,
                        <strong style="font-size:12px;"> Orientation: </strong><span><?php echo $ticketDetail['Orientation']; ?></span>,
                        <strong style="font-size:12px;"> Finish: </strong><span><?php echo $ticketDetail['FinishType']; ?></span>,
                        <strong style="font-size:12px;"> Press Proof: </strong><span><?php echo ($ticketDetail['pressproof']==1)?"Yes":"No"; ?></span>
                    <?php } ?>
                </td>
                <td align="center" class="invoicetable_tabel_border"><?php echo $ticketDetail['returnQtyPrint']; ?></td>
                <td align="center" class="invoicetable_tabel_border">
                    <?php   $print_total = number_format($ticketDetail['returnPricePrint'],2,'.','');
                    echo  $symbol." ".$print_total;
                    ?>
                </td>
            </tr>
        <?php
            $total += ($line_total+$print_total);
        } else {
            $total += ($line_total);
        }

        $curr_symbol = $symbol;
    } // end foreach

    $sub_total = $total + $delivery_charges;
    $vat = ($sub_total * vat_rate) - $sub_total;

    if ($vat_exempt == 'yes') {
        $grand_total = $sub_total;
    }else{
        $grand_total = $sub_total + $vat;
    }
    ?>




    <?php if($proceeded_without_order == 0){ ?>
        <tr class="totals">
            <td colspan="2"></td>
            <td class="invuice_subtotal"><b>Delivery: </b></td>
            <td align="center" class="invuice_subtotal_price"> <?php echo $curr_symbol." ".number_format($delivery_charges, 2, '.', '') ?> </td>
        </tr>
    <?php } ?>

    <tr class="totals">
        <td colspan="2"></td>
        <td class="invuice_subtotal"><b>Sub Total: </b></td>
        <td align="center" class="invuice_subtotal_price"><? echo $curr_symbol." ".number_format($sub_total, 2, '.', '');?></td>
    </tr>
    <?php if($proceeded_without_order == 0){
        if ($vat_exempt == 'yes') {
        ?>
            <tr class="totals">
                <td colspan="2"></td>
                <td class="invuice_subtotal"><b>VAT Exempt:</b></td>
                <td align="center" class="invuice_subtotal_price"><? echo  "-".$curr_symbol." ".number_format($vat, 2,'.', '');?></td>
            </tr>

        <?php }else{ ?>

            <tr class="totals">
                <td colspan="2"></td>
                <td class="invuice_subtotal"><b>VAT @ (20.00)%:</b></td>
                <td align="center" class="invuice_subtotal_price"><? echo $curr_symbol." ".number_format($vat, 2,'.', '');?></td>
            </tr>
    <?php }} ?>
    <tr class="totals">
        <td colspan="2"></td>
        <td class="invuice_subtotal"><b>Grand Total:</b></td>
        <td align="center" class="invuice_subtotal_price"><b><? echo $symbol." ".(number_format($grand_total, 2,'.',''));?></b></td>
    </tr>




</table>

<!--<table width="280px;" align="right" style="table-layout:fixed; color: red !important;">
    <?php /*if($proceeded_without_order == 0){ */?>
        <tr>
            <td colspan="3"  class="invuice_subtotal" width="65%"><b>Delivery: </b></td>
            <td class="invuice_subtotal_price" width="20%"> <?php /*echo ($delivery_charges > 0)?$delivery_charges:0 */?> </td>
        </tr>
    <?php /*} */?>

    <tr>
        <td colspan="3" class="invuice_subtotal" width="65%"><b>Sub Total: </b></td>
        <td class="invuice_subtotal_price" width="20%"><?/* echo $curr_symbol." ".$sub_total;*/?></td>
    </tr>
    <?php /*if($proceeded_without_order == 0){
    //if ($order->vat_exempt == 'yes') {
        */?>
        <tr>
            <td colspan="3"  class="invuice_subtotal" width="65%"><b>VAT Exempt:</b></td>
            <td class="invuice_subtotal_price" width="20%"><?/* echo $vat;*/?></td>
        </tr>
    <?php /*} */?>
    <tr>
        <td colspan="3" class="invuice_subtotal" width="65%"><b>Grand Total:</b></td>
        <td class="invuice_subtotal_price" width="20%"><b><?/* echo $symbol." ".(number_format($delivery + $sub_total + $vat, 2,'.',''));*/?></b></td>
    </tr>
</table>-->