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
} else {
    $countryID = $this->quoteModel->get_db_column('shippingcountries', 'ID', 'name', $country);
}



$subtotal_incvat = $order->inctotal_for_page;
$subtotal_exvat = $order->extotal_for_page;

// AA35 STARTS
    // FOR FREE DELIVERY DROPDOWN SHOW, WHEN ORDER INC VAT PRICE IS HIGHER OR EQUAL TO 25.00 STARTS
        // $subtotal_incvat *= 1.2;
    // FOR FREE DELIVERY DROPDOWN SHOW, WHEN ORDER INC VAT PRICE IS HIGHER OR EQUAL TO 25.00 ENDS
// AA35 ENDS

/************ ----------------------- *********/
$condtion = '';
$printinglines = $this->home_model->printing_order_items($order->OrderNumber);

$result = $this->db->query("select count(*) as total from orderdetails 
			 WHERE OrderNumber = '".$order->OrderNumber."'");
			 $row = $result->row_array();
			 $total = $row['total'];

$productstypeQuery = $this->db->query("select count(*) as total from orderdetails WHERE  
			 (Select ProductBrand From products WHERE orderdetails.ProductID = products.ProductID) LIKE 'Application Labels' 
			 AND OrderNumber ='".$order->OrderNumber."'");
			$row = $productstypeQuery->row_array();

$productstypeQueryIntegrated = $this->db->query("select count(*) as total from orderdetails WHERE  
			 (Select ProductBrand From products WHERE orderdetails.ProductID = products.ProductID) LIKE 'Integrated Labels' 
			 AND OrderNumber ='".$order->OrderNumber."'");
			 
			 $rowInt = $productstypeQueryIntegrated->row_array();

			 
			 if($total == $row['total']){
				 $productstype= "lba";
			 }
			 else{
				 $productstype= "mixed";
			 }


if ($productstype == 'lba' || ($printinglines > 0 && $countryID == 1)) {
    $condtion = ' AND ServiceID = 20 ';
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
        //$condtion = ' AND BasicCharges > 0 ';
    }
}
/************ ----------------------- *********/


	$sql = $this->db->query("select * from shippingservices where CountryID ='" . $countryID . "' $condtion or ServiceID='11' order by ServiceID ASc ");


$ShipingService = $sql->result_array();

//echo $this->db->last_query();

//echo '<pre>'; print_r($ShipingService); echo '</pre>';
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
            
            <!-- AA21 STARTS -->
            <?php
            $html = "";
            $fedex_selected = "";
            $DPD_selected = "";
            $offshore = $this->product_model->offshore_delviery_charges_WPC($order->DeliveryPostcode , $order->DeliveryCountry);
            $courier = $order->OrderDeliveryCourier;
            $selected = '';
            if($order->DeliveryCountry == 'United Kingdom' && ($offshore['status'] != true))
            {
                if($courier == 'DPD'){
                    $DPD_selected = "selected = 'selected' ";
                }
                else {
                    $fedex_selected = "selected = 'selected' ";
                }
                $html = '<option value="">Select Courier Service</option>';
                $html .= '<option value="Parcelforce" '.$fedex_selected.'>Parcelforce</option>';
                $html .= '<option value="DPD" '.$DPD_selected.'>DPD</option>';
            }
            else if( ($order->DeliveryCountry == 'France') || ($order->DeliveryCountry == 'Luxembourg') || ($order->DeliveryCountry == 'Switzerland') || ($order->DeliveryCountry == 'Belgium') )
            {
                if($courier == 'DPD'){
                    $selected = "selected = 'selected' ";
                }
                $html = '<option value="">Select Courier Service</option>';
                $html .= '<option value="DPD" '.$selected.'>DPD</option>';
            }
            else
            {
                if($courier == 'Parcelforce'){
                    $selected = "selected = 'selected' ";
                }
                $html = '<option value="">Select Courier Service</option>';
                $html .= '<option value="Parcelforce" '.$selected.' >Parcelforce</option>';
            }
            ?>
            
        <!-- AA21 ENDS -->


        <?php
        $width = " width: 88%; margin-left:0px;";
        if($order->PaymentMethods != 'Sample Order')
        {
            $width = " width: 70%; margin-left:10px;";
        ?>
            <select id="deliveryCourier" class="" name="deliveryCourier" style="width: 17%; float: left;">
                <?php echo $html;?>
            </select>
        <?php
        }
        ?>

         <select id="c1" class="shipid" name="shippingcharges" style="<?php echo $width;?> float: left;">
              
            <option value="">Select Delivery</option>
            <?php $i = 0;
					$ck = 'no';
           foreach ($ShipingService as $res) {
				$if_less_25 = 'no';
				$if_great_25 = 'no';
				$if_printLine = 'no';
				
				
                $i++;
				///print_r($res);
				
                if ($subtotal_incvat <= 25.00 && $res['ServiceID'] == 20 && $printinglines == 0) {                
					$if_less_25 = 'yes';
                    //continue;
                }
				
				if ($subtotal_incvat >= 25.00 && $res['ServiceID'] == 19 && $printinglines == 0) {                
					$if_great_25 = 'yes';
                }
				
				if ($subtotal_incvat >= 25.00) {                
					$if_printLine = 'yes';
                }

                if (empty($serviceID) || ($subtotal_incvat < 25.00 and $serviceID == 20 && $printinglines == 0)) {
                    $shippingextra = $res['BasicCharges'];
                    $serviceID = $res['ServiceID'];
                }
                ?>
			<?php if (($res['ServiceID'] == 20 and $rowInt['total'] > 0 and $if_printLine=='yes') ||  ($res['ServiceID'] == 19 and $rowInt['total'] > 0 and $if_printLine=='no')) { ?>
			
				<option value="<?= $res['ServiceID'] ?>" <? if ($res['ServiceID'] == $serviceID) {
                    echo " selected ";
                } ?>>
                    <?php echo "Delivery 3-5 Days (Integrated Labels)"; ?>
                </option>
			<?php } else{?>
			
			<?php if(($if_less_25!="yes") && ($if_great_25!="yes")){ ?>
				<option value="<?= $res['ServiceID'] ?>" <? if ($res['ServiceID'] == $serviceID) { echo " selected "; } ?> >
                    <?php echo $res['ServiceName'] . " ( " . $res['ServiceDescription'] . " ) "; ?>
                </option>
					<?php } ?>
			
			<?php } ?>
                
			
			
			
            <?php } ?>
			
            	<option value="33" <? if (33 == $serviceID) {
                	echo " selected ";
            	} ?>> SWAPIT
            	</option>
			
			
        </select>
            <button class="btn btn-secondary waves-light waves-effect enquiry-save-button col-md-3 float-right"  onclick="getShipingservic();" style="height:36px;width:71px;">Update</button>
        </label>
    </div>

<? } else {

   

} ?>
    <? $info = $this->quoteModel->getShipingServiceName($order->ShippingServiceID);
        // AA26 STARTS
         echo "Delivery Service: " . $info['ServiceName'];
         if($order->PaymentMethods != 'Sample Order')
         {
            echo ' - '.$order->OrderDeliveryCourier;
         }
         // AA26 ENDS
         
  ?>
