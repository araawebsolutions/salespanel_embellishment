<?php
error_reporting(1);
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2); ?>

<meta charset="utf-8" />
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
            <?php echo '<b><span style="color: #999999">Note de crédit:</span> <font color="#000000"> '.$ticketMains['ticketSrNo']. '</font></b>';
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
                    <td align="left" class="print_address"><strong style="margin-left:80px;">Téléphone: </strong></td>
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
                    <td align="left" valign="top" class="print_address"><strong style="margin-left:80px;">numéro de TVA: </strong></td>
                    <td align="left" valign="top" class="print_address"><span class="phone_right">
                  FR 21 851063453
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
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px;white-space:nowrap; text-align:left;color:#fff;">&nbsp;&nbsp;Détail de la note de crédit</h3></td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding-top:10px;padding-left:5px">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0">
                            <tr >
                                <td><b>Numéro de Note de Crédit:  </b></td>
                                <td><?php echo $ticketMains['ticketSrNo'];   ?></td>
                            </tr>
                            <tr>
                                <td><b> Date: </b></td>
                                <td><?php echo date('jS F Y', strtotime($ticketMains['create_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><b> Heure: </b></td>
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
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px;white-space:nowrap; text-align:left;color:#fff;">&nbsp;&nbsp;Adresse de facturation</h3></td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding-top:10px;padding-left:5px">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0">
                            <tr >
                                <td align="left" style="width: 30%"><b>Compagnie: </b></td>
                                <td style="width: 70%"><?php echo $ticketMains['BillingCompanyName']?></td>
                            </tr>
                            <tr>
                                <td><b> prénom: </b></td>
                                <td><?php echo $ticketMains['BillingFirstName'].' '.$ticketMains['BillingLastName']?></td>
                            </tr>
                            <tr>
                                <td><b> Email: </b></td>
                                <td><?php echo $ticketMains['BillingEmail']?></td>
                            </tr>
                            <tr>
                                <td><b> Adresse: </b></td>
                                <td><?php echo $ticketMains['BillingAddress1']?>
                                    &nbsp;
                                    <?php echo $ticketMains['BillingAddress2']?></td>
                            </tr>
                            <tr>
                                <td><b>Ville: </b></td>
                                <td><?php echo $ticketMains['BillingTownCity']?></td>
                            </tr>
                            <tr>
                                <td><b> Pays: </b></td>
                                <td><?php echo $ticketMains['BillingCountry']?></td>
                            </tr>
                            <tr>
                                <td ><b>Code postal: </b></td>
                                <td><?php echo $ticketMains['BillingPostcode']?></td>
                            </tr>
                            <tr>
                                <td><b>Téléphone: </b></td>
                                <td><?php echo $ticketMains['BillingTelephone']?></td>
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
                    <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:0px;height:30px" valign="middel" width="50%"><h3 style="padding-top:7px; white-space:nowrap; text-align:left;color:#fff;"><span style="white-space:nowrap;">&nbsp;&nbsp;Adresse de livraison</span></h3></td>
                </tr>


                <tr>
                    <td align="left" valign="top" style="padding-top:10px; padding-left:5px;">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0">
                            <tr style="padding-top:10px; padding-left:5px;">
                                <td align="left" style="width:30%;"><b>Compagnie: </b></td>
                                <td style="width: 70%"><?php echo $ticketMains['DeliveryCompanyName']?></td>
                            </tr>
                            <tr>
                                <td><b> prénom: </b></td>
                                <td><?php echo $ticketMains['DeliveryFirstName'].' '.$ticketMains['DeliveryLastName']?></td>
                            </tr>
                            <tr>
                                <td><b> Email: </b></td>
                                <td><?php echo $ticketMains['BillingEmail']?></td>
                            </tr>
                            <tr>
                                <td><b> Adresse: </b></td>
                                <td><?php echo $ticketMains['DeliveryAddress1']?>
                                    &nbsp;
                                    <?php echo $ticketMains['DeliveryAddress2']?></td>
                            </tr>
                            <tr>
                                <td><b>Ville: </b></td>
                                <td><?php echo $ticketMains['DeliveryTownCity']?></td>
                            </tr>
                            <tr>
                                <td><b> Pays: </b></td>
                                <td><?php echo $ticketMains['DeliveryCountry']?></td>
                            </tr>
                            <tr>
                                <td ><b>Code postal: </b></td>
                                <td><?php echo $ticketMains['DeliveryPostcode']?></td>
                            </tr>
                            <tr>
                                <td><b>Téléphone: </b></td>
                                <td><?php echo $ticketMains['Deliverytelephone']?></td>
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
        <td class="invoicetable_bgBlue" width="15%">Code produit</td>
        <td class="invoicetable_bgBlue" width="55%">Description</td>
        <td class="invoicetable_bgBlue" width="15%">Quantité</td>
        <td class="invoicetable_bgBlue" width="15%">Total de ligne</td>
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
            <?php
            if($ticketDetail['ManufactureID']){
                $ManufactureID = $ticketDetail['ManufactureID'];
            }else{
                $ManufactureID = 'Ligne personnalisée';
            }
            ?>
            <td class="invoicetable_tabel_border"><?php echo $ManufactureID ?></td>
            <td class="invoicetable_tabel_border" style="width:360px !important;">
                <?php //echo $ticketDetail['productDescription']?>


                <?php

                if($ticketDetail['ManufactureID']) {
                    if ($ticketDetail['ProductID'] == 0) {
                        $prod_name = $this->home_model->ReplaceHtmlToString_($ticketDetail['ProductName']);
                        echo $prod_name;
                    } else {
                        $prod = $this->home_model->show_product($ticketDetail['ProductID']);
                        $merge = array_merge($prod, $ticketDetail);
                        $prod_name = $this->home_model->fetch_product_name($merge);
                        echo $this->home_model->ReplaceHtmlToString_($prod_name);
                    }
                    ?>
                    <? if ($ticketDetail['ManufactureID'] == "SCO1") {
                        $custominfo = $this->home_model->fetch_custom_die_order($ticketDetail['SerialNumber']);
                        include(APPPATH . 'views/old_pdf_views/fr/assc_die.php');
                    }
                }else{
                    echo $ticketDetail['productDescription'];
                }
                ?>


            </td>

            <td align="center" class="invoicetable_tabel_border"><?php echo $ticketDetail['returnQty']; ?></td>
            <td align="center" class="invoicetable_tabel_border">
                <?php   $line_total = number_format($ticketDetail['returnUnitPrice'],2,'.','');
                echo  $symbol." ".$line_total;
                ?>
            </td>
        </tr>


        <?php if($ticketDetail['Printing'] == 'Y'){

            if ($ticketDetail['Print_Type'] == "Monochrome - Black Only" || $ticketDetail['Print_Type'] == "Mono") {
                $type = $typeshow = $desntype = 'Monochrome - Noir seulement';
            } else {
                $frprnttype = $ticketDetail['productDescriptionPrint'];
                $type = $typeshow = $desntype = $this->user_model->get_db_column('digital_printing_process', 'name_fr', 'name', trim($frprnttype));
                /*print_r('hhhhhhhhhhhh');
                print_r(trim($frprnttype)); exit;*/
                $type = $typeshow = $desntype = $this->user_model->ReplaceHtmlToString_($type);
            }

            ?>
            <tr>
                <td class="invoicetable_tabel_border"></td>
                <td class="invoicetable_tabel_border" style="width:360px !important;">

                    <?php if($ticketDetail['returnQtyPrint'] > 0){
                        $returnQtyPrint = $ticketDetail["returnQtyPrint"]. "<span><!--plusieurs--> Conception</span>";
                    }else{
                        $returnQtyPrint = '';
                    } ?>
                    <?php if($ticketDetail['ProductBrand'] != 'Roll Labels'){ ?>
                        <?php echo $typeshow; ?>
                        <?php echo $returnQtyPrint; ?>
                    <?php }else{ ?>
                        <span><?php echo $typeshow; ?></span>
                        <?php echo $returnQtyPrint; ?>
                        <strong style="font-size:12px;"> Blessure: </strong><span><?php echo $ticketDetail['Wound']; ?></span>,
                        <strong style="font-size:12px;"> Orientation: </strong><span><?php echo $ticketDetail['Orientation']; ?></span>,
                        <strong style="font-size:12px;"> Finition: </strong>

                        <?
                        $finish_type_fr = '';
                        if($ticketDetail['FinishType'] == "Gloss Lamination"){
                            $finish_type_fr = 'Lamination Gloss';
                        }else if($ticketDetail['FinishType'] == "Matt Lamination"){
                            $finish_type_fr = 'Matt Lamination';
                        }else if($ticketDetail['FinishType'] =="Matt Varnish"){
                            $finish_type_fr = 'Vernis mat';
                        }else if($ticketDetail['FinishType'] == "Gloss Varnish"){
                            $finish_type_fr = 'Vernis brillant';
                        }else if($ticketDetail['FinishType'] == "High Gloss Varnish"){
                            $finish_type_fr = 'Vernis a haute brillance';
                        }else{
                            $finish_type_fr == 'No Finish';
                        }
                        ?>
                        <span><?php echo $finish_type_fr; ?></span>,
                        <strong style="font-size:12px;"> Epreuve de presse: </strong><span><?php echo ($ticketDetail['pressproof']==1)?"Oui":"Non"; ?></span>
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
            <td class="invuice_subtotal"><b>Livraison: </b></td>
            <td align="center" class="invuice_subtotal_price"> <?php echo $curr_symbol." ".number_format($delivery_charges, 2, '.', '') ?> </td>
        </tr>
    <?php } ?>

    <tr class="totals">
        <td colspan="2"></td>
        <td class="invuice_subtotal"><b>Sous total: </b></td>
        <td align="center" class="invuice_subtotal_price"><? echo $curr_symbol." ".number_format($sub_total, 2, '.', '');?></td>
    </tr>
    <?php if($proceeded_without_order == 0){
        if ($vat_exempt == 'yes') {
            ?>
            <tr class="totals">
                <td colspan="2"></td>
                <td class="invuice_subtotal"><b>Hors TVA:</b></td>
                <td align="center" class="invuice_subtotal_price"><? echo  "-".$curr_symbol." ".number_format($vat, 2,'.', '');?></td>
            </tr>

        <?php }else{ ?>

            <tr class="totals">
                <td colspan="2"></td>
                <td class="invuice_subtotal"><b>TVA @ (20.00)%:</b></td>
                <td align="center" class="invuice_subtotal_price"><? echo $curr_symbol." ".number_format($vat, 2,'.', '');?></td>
            </tr>
        <?php }} ?>
    <tr class="totals">
        <td colspan="2"></td>
        <td class="invuice_subtotal"><b>Somme finale:</b></td>
        <td align="center" class="invuice_subtotal_price"><b><? echo $symbol." ".(number_format($grand_total, 2,'.',''));?></b></td>
    </tr>
</table>
