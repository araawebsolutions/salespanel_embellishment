<?php

$countryID = 0; 
$bgroup = $this->quoteModel->getcountry_new($order->BillingCountry);
$dgroup = $this->quoteModel->getcountry_new($order->DeliveryCountry);
$bgroup = (isset($bgroup['country_group']) and $bgroup['country_group'] != '') ? $bgroup['country_group'] : '';
$dgroup = (isset($dgroup['country_group']) and $dgroup['country_group'] != '') ? $dgroup['country_group'] : '';


 $country = $order->DeliveryCountry;
 $serviceID = $order->ShippingServiceID;

if ($country == "United Kingdom" || $country == "") {
    $countryID = 1;
} else if ($bgroup == 'ROW' and $dgroup == 'ROW' and $country != "United Kingdom") {
    $countryID = $this->quoteModel->get_db_column('shippingcountries', 'ID', 'name', $country);
}

$subtotal_incvat = $order->inctotal_for_page;
$subtotal_exvat = $order->extotal_for_page;


/************ ----------------------- *********/
$condtion = '';
$printinglines = $this->home_model->printing_order_items($order->OrderNumber);
$productstype = "mixed";

if ($productstype == 'lba' || ($printinglines > 0 && $countryID == 1)) {
   // $condtion = ' AND ServiceID = 20 ';
} else {
    if (isset($countryID) and ($countryID == 13 || $countryID == 14 || $countryID == 15)) {
        if ($countryID == 15) {
            $freeorder_over = 100;
        } //UK Exception Postcodes
        else if ($countryID == 13 || $countryID == 14) {
            $freeorder_over = 75;
        } //Offshore postcodes
    } else {
        $freeorder_over = $this->home_model->get_db_column('shippingcountries', 'freeorder_over', 'ID', $countryID);
    }
    if ($countryID != 1 and $subtotal_incvat < $freeorder_over) {
        $condtion = ' AND BasicCharges > 0 ';
    }
}
/************ ----------------------- *********/


$sql = $this->db->query("select * from shippingservices where CountryID ='" . $countryID . "' $condtion order by ServiceID ASc ");
$ShipingService = $sql->result_array();
//echo $this->db->last_query();

/************ print charges if less than 25 *********/
if ($subtotal_incvat < 25 && $printinglines > 0) {
    $ShipingService[0]['ServiceName'] = '3-5 working days delivery';
    $ShipingService[0]['ServiceDescription'] = str_replace("Free", " ", $ShipingService[0]['ServiceDescription']);
}
/************ print charges if less than 25 *********/
?>





<?
if ($order->OrderStatus != 7 && $order->OrderStatus != 8) {
    ?>


    <div class="labels-form">
        <label class="select">
        <select id="c1" class="shipid PrinterCopier nlabelfilter" name="shippingcharges" onChange="getShipingservic();"
                style="width: 100%">
            <?php $i = 0;
            foreach ($ShipingService as $res) {
                $i++;
                if ($subtotal_incvat < 25.00 && $res['ServiceID'] == 20 && $printinglines == 0) {
                    continue;
                }

                if (empty($serviceID) || ($subtotal_incvat < 25.00 and $serviceID == 20 && $printinglines == 0)) {
                    $shippingextra = $res['BasicCharges'];
                    $serviceID = $res['ServiceID'];
                }
                ?>
                <option value="<?= $res['ServiceID'] ?>" <? if ($res['ServiceID'] == $serviceID) {
                    echo " selected ";
                } ?>>
                    <?php echo $res['ServiceName'] . " ( " . $res['ServiceDescription'] . " ) "; ?>
                </option>
            <?php } ?>

            <option value="11" <? if (11 == $serviceID) {
                echo " selected ";
            } ?>> Collection In Person
            </option>
            <option value="33" <? if (33 == $serviceID) {
                echo " selected ";
            } ?>> SWAPIT
            </option>
        </select>
            <i></i>
        </label>
    </div>

<? } else {

    $info = $this->quoteModel->getShipingServiceName($order->ShippingServiceID);
    echo "Delivery Service: " . $info['ServiceName'];

} ?>


