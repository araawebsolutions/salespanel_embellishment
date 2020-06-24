<div class="col-sm-4" style="padding: 0px 10px;">
<style>
    .labels-form label{
        margin-bottom: 10px;
    }
</style>
    <div class="panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Shipping Address</div>

        <!-- Table -->
        <table class="table">
            <tbody>
            <tr>
                <td>Address:</td>
                <td id="shippind_address_1">141 Woodhead Road</td>
            </tr>
            <tr>
                <td>City/Town:</td>
                <td id="shippind_city">BRADFORD</td>
            </tr>
            <tr>
                <td>County:</td>
                <td id="shippind_county">West Yorkshire</td>
            </tr>
            <tr>
                <td>Country</td>
                <td id="shipping_country">United Kingdom</td>
            </tr>
            <tr>
                <td>Post Code:</td>
                <td id="shippind_postcode">bd7 2bl</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-sm-4" style="padding: 0px 10px;">
    <div class="panel-default">

        <!-- Default panel contents -->

        <?

        $integrated = $this->shopping_model->is_order_integrated();

        if ($integrated > 0) {

            $delivery_charges = $this->shopping_model->get_integrated_delivery_charges('GB');

            if (isset($delivery_charges) and !empty($delivery_charges)) {

                $delivery_charges = $delivery_charges * 1.2;

            }

        }


        ?>
        <div class="panel-heading">Shipping Method</div>

        <!-- Table -->

        <table class="table">
            <tbody>
            <?php

            $changeDrop = $this->session->userdata('changeDrop');

            $ServiceID = $this->session->userdata('ServiceID');

            $ServiceName = $this->session->userdata('ServiceName');

            $BasicCharges = $this->session->userdata('BasicCharges');

            $offshore = $this->product_model->offshore_delviery_charges();


            $delivery = $this->shopping_model->delevery($offshore);

            $xmass = $this->shopping_model->is_xmass_labels();

            $texvat = $this->shopping_model->total_order();

            $ship = number_format($texvat * 1.2, 2);

            $ship12 = ($texvat * 1.2);


            $sample = $this->shopping_model->is_order_sample();

            $printing = $this->shopping_model->printing_count_items();


            if ($sample == 'sample') {

                $this->session->set_userdata("ServiceName", "Free delivery 3 - 5 working days");
                $this->session->set_userdata("BasicCharges", "0.00");
                $this->session->set_userdata("ServiceID", "20");
                $BasicCharges = '0.00';
                $ServiceID = '20';
            } else if ($xmass > 0) {
                $this->session->set_userdata("ServiceName", "No charge Christmas Special Offer");
                $this->session->set_userdata("BasicCharges", "0.00");
                $this->session->set_userdata("ServiceID", "12");
                $BasicCharges = '0.00';
                $ServiceID = '12';
            } else if ($offshore['status'] == true) {
                /*$this->session->set_userdata("ServiceName", $offshore['type']);
                $this->session->set_userdata("BasicCharges", $offshore['charges']);
                $this->session->set_userdata("ServiceID", $offshore['serviceid']);
                $BasicCharges=$offshore['charges'];
                $ServiceID=$offshore['serviceid'];*/
            } else if ($printing > 0 && $ship12 < 25) {
                $this->session->set_userdata("BasicCharges", 6.00);
                $BasicCharges = 6.00;
                if (isset($delivery[0]) and $delivery[0]['BasicCharges'] == 0) {
                    $delivery[0]['BasicCharges'] = 6.00;
                    $delivery[0]['ServiceName'] = '3-5 working days delivery';
                }
            } else if ($ship12 < 25 && $ServiceID == '20' && $changeDrop != 1) {
                $this->session->set_userdata("ServiceID", "21");
                $basicCharges = $this->shopping_model->get_deliveryCharges("21");
                $this->session->set_userdata("BasicCharges", "$basicCharges");
                $BasicCharges = "$basicCharges";
            } else if ($ship12 < 25 && $ServiceID == '20' && $integrated > 0) {
                $this->session->set_userdata("ServiceID", "20");
            } else if ($ServiceID == '' && $ship12 > 25 && $changeDrop != 1 && $integrated == 0) {
                $this->session->set_userdata("BasicCharges", "0.00");
                $this->session->set_userdata("ServiceID", "20");
                $BasicCharges = '0.00';
                $ServiceID = '20';
            } else if ($ship12 > 25 && $changeDrop != 1) {
                $this->session->set_userdata("BasicCharges", "0.00");
                $this->session->set_userdata("ServiceID", "20");
                $BasicCharges = '0.00';
                $ServiceID = '20';
            } else if ($ship12 < 25 && $ServiceID == '20' && $changeDrop == 1) {
                $this->session->set_userdata("ServiceID", "19");
                $basicCharges = $this->shopping_model->get_deliveryCharges("19");
                $this->session->set_userdata("BasicCharges", $basicCharges);
                $BasicCharges = "$basicCharges";

            } else if ($ship12 > 25 && $ServiceID == '19' && $changeDrop == 1) {
                $this->session->set_userdata("ServiceID", "20");
                $basicCharges = $this->shopping_model->get_deliveryCharges("20");
                $this->session->set_userdata("BasicCharges", $basicCharges);
                $BasicCharges = "$basicCharges";
            } else if ($ServiceID == '' && $ship12 > 25 && $changeDrop == 1) {
                $this->session->set_userdata("BasicCharges", "0.00");
                $this->session->set_userdata("ServiceID", "20");
                $BasicCharges = '0.00';
                $ServiceID = '20';
            }
            if ($integrated > 0 and $ship <= 25 and $offshore['status'] == false) {
                $integrated_delivery = $this->shopping_model->get_shipping(20);
                array_unshift($delivery, $integrated_delivery);
            }
            $ServiceID = $this->session->userdata('ServiceID');
            $i = 0;
            $count = count($delivery);
            foreach ($delivery as $key => $dele) {
                $checked = '';
                if ($dele['ServiceID'] == 20 and $integrated > 0) {
                    $dele['ServiceName'] = 'Delivery 3-5 Days (Integrated Labels)';
                }

                if ($ServiceID == $dele['ServiceID']) {
                    $checked = 'checked="checked"';
                }

                if ($integrated > 0) {

                    $dele['BasicCharges'] += $delivery_charges;

                }


                if ($i == 0) {

                    $basicCharges = $dele['BasicCharges'];

                    if ($BasicCharges == '' || $count == 1) {

                        $this->session->set_userdata("BasicCharges", $basicCharges);

                        $this->session->set_userdata("ServiceID", $dele['ServiceID']);

                        $checked = 'checked="checked"';

                        $BasicCharges = $basicCharges;

                    }

                }


                ?>
                
<?php 
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>                
                
                <tr>
                    <td><label <? if ($dele['ServiceID'] == 21){ ?>data-toggle="tooltip-delivery" data-placement="left"
                               title="During the 3 days of this promotional event we anticipate that our next-day delivery service will be heavily utilised, which may in some cases result in delayed order fulfilment.  We apologise if this is the case and assure you that we will do everything possible to prevent this  and apologise if this effects you order. Normal service will be resumed from Monday 27.11.17" <? } ?>
                               class="radio state-success">
                            <input type="radio" id="delivery<?= $dele['ServiceID'] ?>"
                                   name="delivery_option" <?= $checked ?> value="<?= $dele['ServiceID'] ?>"

                                   class="delivery-group">
                            <i class="rounded-x"></i>
                            <?= ucfirst($dele['ServiceName']) ?>
                            <? if ($offshore['status'] == true || $dele['CountryID'] != 1) { ?>
                                <br/>
                                <small> (
                                    <?= $dele['ServiceDescription'] ?>
                                    )
                                </small>
                            <? } ?>
                        </label></td>
                    <td style="text-align:right; width:12%;"><h4 class="textOrange">
                            <? $dele['BasicCharges'] = $this->home_model->currecy_converter($dele['BasicCharges'], 'no');

                            echo $symbol . number_format( ($dele['BasicCharges']*$exchange_rate), 2); ?>
                        </h4>

                    </td>
                </tr>
                <?php $i++;
            } ?>
            <tr>
                <td colspan="2">
                    <small>Deliveries are made Monday to Friday (excluding Public Holidays) and the above delivery times
                        are therefore working days.
                    </small>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-sm-4" style="padding: 0px 10px;">
    <div class="panel-default">

        <!-- Default panel contents -->

        <div class="panel-heading">Shipping Charges</div>

        <!-- Table -->

        <table class="table">
            <tbody>
            <?php


            $BasicCharges = $this->home_model->currecy_converter($BasicCharges, 'no');

            if ($integrated > 0 and ($BasicCharges == '' || $BasicCharges == 0.00)) {

                $BasicCharges += $delivery_charges;

                $this->session->set_userdata('BasicCharges', $BasicCharges);

            }

            if ($BasicCharges != 0.00 || 1==1) {
                ?>
                <tr>
                    <td>Ex. Vat:
                        <h4 class="textOrange">
                            <?php /*?><?=symbol.number_format($BasicCharges+$IntBasicCharges/1.2,2);?><?php */
                            ?>
                            <? $exvatdelivery = $BasicCharges / 1.2;?>
                            <?=  $symbol . number_format(($exvatdelivery* $exchange_rate), 2); ?>
                        </h4></td>
                    <td style="text-align:right;">Inc. Vat:
                        <h4 class="textOrange">
                            <?php /*?><?=symbol.number_format($BasicCharges+$IntBasicCharges,2);?><?php */
                            ?>
                            <?= $symbol . number_format(($BasicCharges*$exchange_rate), 2); ?>
                        </h4></td>
                </tr>
            <? } ?>
            <tr>
                <td class="bg-info textwhite">Total Shipping Charges:</td>
                <td class="bg-info" style="text-align:right;"><h3 class="textwhite">
                        <?php /*?><?=symbol.number_format($BasicCharges+$IntBasicCharges,2)?><?php */ ?>
                        <?= $symbol . number_format(($BasicCharges*$exchange_rate), 2) ?>
                    </h3></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<?


if (isset($sample) and $sample == 'sample') {

    echo "<script>$('.paymentInputs11').hide();$('#confirmbtn').show(); var paymentoption = 'sample';</script>";

} else {

    echo "<script>var paymentoption = '';</script>";

}


if (isset($offshore['serviceid']) and $offshore['serviceid'] == 14 || $offshore['serviceid'] == 15) {

    echo "<script>$('#delivertimeynote').show();$('#offshoredeliverynote').show();$('.ukvatbox').hide();</script>";

} else if ($offshore['status'] == true) {

    echo "<script>$('#delivertimeynote').hide();$('#offshoredeliverynote').hide();</script>";

} else {

    echo "<script>$('#delivertimeynote').show();$('#offshoredeliverynote').hide();$('.ukvatbox').hide();</script>";

}

$charges = $this->session->userdata('BasicCharges');

if ($integrated > 0 and (!isset($charges) || $charges == 0 || $charges == '')) {


}

?>
<script>

    if (typeof reset_paypal_payments === "function") {

        reset_paypal_payments();

    }

</script>
