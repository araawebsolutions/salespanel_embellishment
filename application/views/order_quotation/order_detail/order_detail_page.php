<!-- for autoload-->
<script src="<?= ASSETS ?>assets/js/datepicker.js"></script>
<script>(function (n, t, i, r) {
        var u, f;
        n[i] = n[i] || {}, n[i].initial = {
            accountCode: "AALAB11111",
            host: "AALAB11111.pcapredict.com"
        }, n[i].on = n[i].on || function () {
            (n[i].onq = n[i].onq || []).push(arguments)
        }, u = t.createElement("script"), u.async = !0, u.src = r, f = t.getElementsByTagName("script")[0], f.parentNode.insertBefore(u, f)
    })(window, document, "pca", "//AALAB11111.pcapredict.com/js/sensor.js")</script>
<style>
    .cart-button {
        background: cornflowerblue none repeat scroll 0 0;
        color: #fff;
        font-weight: bold;
        height: 25px;
        margin-top: 10px;
    }

    .pointer {
        cursor: pointer;
    }

    .hide {
        display: none;
    }

    .greyer {
        background-color: #efefef;
    }

    .whiter {
        background-color: #fff;
    }

    .dataTables_filter {
        margin-top: -126px !important;
        margin-right: 5% !important;
    }

    .changediecode {
        display: none;
        color: #00b6f0;
        cursor: pointer;
        font-size: 13px;
    }

    .ui-autocomplete {
        z-index: 1000 !important;
    }

    .btn-upload-artwork {
        width: 100% !important;
    }
</style>
<script>
    jQuery.curCSS = function (element, prop, val) {
        return jQuery(element).css(prop, val);
    }
</script>
<!-- end autolaod-->
<style>
    .m-t-10 {
        margin-top: 10px;
    }

    i {
        cursor: pointer;
    }

    .m-20 {
        padding-right: 10px !important;
    }

    .changediecode {
        display: none;
        font-size: 14px;
        color: red;
        cursor: pointer;
    }

    .select-design-adjst {
        -moz-appearance: none;
        background: #fff;
        border-radius: 5px;
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
        display: block;
        height: 35px;
        outline: 0;
        padding: 8px 10px;
        width: 100%;
        font-weight: 400 !important;
        border-color: #bababa;
        color: #817d7d;
        font-size: 11px;
    }

    .allownumeric {
        height: 35px;
    }

    .addnewline {
        background: #fff;
        color: #666 !important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn-info:hover {
        color: #fff !important;
    }

    .btn-info {
        padding-left: 25px;
        padding-right: 25px;
    }

    #ajax_material_sorting {
        background-color: #ffffff !important;
        margin-bottom: 10px;
        width: 101%;
        margin-left: -10px;
        padding: 15px 30px;
        border-radius: 4px;
        margin-top: 20px;
    }

    #order_detail_material {
        background-color: #ffffff !important;
        margin-bottom: 10px;
        width: 101%;
        margin-left: -10px;
        padding: 15px 30px;
        border-radius: 4px;
        margin-top: 0px;
    }


    .c1 {
        background-color: #fff;
    }

    .c2 {
        background-color: #f4fcff;
    }

</style>
<!-- End Navigation Bar-->

<input type="hidden" id="method_on_page" value="order">
<input type="hidden" id="order_number" value="<?= $order->OrderNumber ?>">
<input type="hidden" id="useer_id" value="<?= $order->UserID ?>">
<input type="hidden" id="od_dt_price" value="">
<input type="hidden" id="od_dt_printed" value="">
<input type="hidden" id="designPrice" value="">
<input type="hidden" id="mypageName" value="order">
<input type="hidden" id="custId" value="<?= $order->UserID ?>">
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4" style="display: flex">
                                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                                    <div class="card-header card-heading-text-two">ORDER INFORMATION</div>
                                    <?php //echo '<pre>'; print_r($order); echo '</pre>'; ?>
                                    <div class="card-body"> Order:
                                        <Number>
                                            <?= $order->OrderNumber ?>
                                        </Number>
                                        <br>
                                        <?php
                                        if (preg_match("/Q-/", $order->Source)) {
                                            $QuoteNumber = $this->db->query("SELECT QuotationNumber FROM quotation_to_order WHERE OrderNumber LIKE '" . $order->OrderNumber . "'")->row_array();
                                            ?>
                                            <span>Quote No:
                      <?php
                      echo $QuoteNumber['QuotationNumber'];
                      ?>
                    </span>
                                            <br>
                                        <? } ?>


                                        <? if ($order->PurchaseOrderNumber != "") { ?>
                                            <span>Purchase Order # &nbsp;:
                      <?php
                      echo $order->PurchaseOrderNumber;
                      ?>
                    </span>
                                            <br>


                                        <? } ?>


                                        <span>Source:
                    <?
                    if ($order->Source == "website" || $order->Source == "Website") {
                        echo "Website ";
                    } elseif ($order->PaymentMethods == "SampleOrder") {
                        echo "Request Samples ";
                    } else {
                        echo "Back office ";
                    }

                    if ($order->PaymentMethods == "chequePostel") $order->PaymentMethods = "Cheque or BACS";
                    echo ' ' . $order->PaymentMethods;

                    ?>
                    </span> <br>
                                        <span>Date:
                     <?= date('jS F Y', $order->OrderDate) ?></span><br>
                                        <span>Time: <?php echo date('h:i A',$order->OrderDate) ?>
                                        
                                        </span>
                                        <br>
                                        <? if ($order->OrderStatus == 7 || $order->OrderStatus == 8) { ?>
                                            Courier & Tracking No: <?php echo $order->OrderDeliveryCourier; ?><?php echo $order->DeliveryTrackingNumber; ?>
                                            <br>
                                            Dispatch Date:
                                            <?php if ($order->DispatchedDate) {
                                                echo date("d-m-Y", $order->DispatchedDate);
                                            } ?>
                                            <br>
                                            Dispatch Time:
                                            <?php if ($order->DispatchedTime) {
                                                echo date("h:i:s A", $order->DispatchedTime);
                                            } ?>
                                        <? } ?>
                                        <hr>

                                        <span>Status: <?
                                            $statusus = $this->orderModal->fetch_order_namestatus($order->OrderStatus);
                                            
                                            /*if ($order->PaymentMethods == "Sample Order") {
                                                echo "Dispatch";
                                            } else {
                                                echo $statusus[0]->StatusTitle;
                                            }*/
                                            
                                            echo $statusus[0]->StatusTitle;
                                            ?>
                                            
                                            </span>
                                        <br>

                                        <?php if ($order->OrderStatus != 7 && $order->OrderStatus != 27) { 
                                             $editOrdersTrue = array('2','32','55','6','78');
                                            if ($order->OrderStatus != 10 && !in_array($order->OrderStatus, $editOrdersTrue)) {
                                                unset($status[10]);
                                            }
                                        
                                        ?>
                                            <p class="labels-form" style="display: inline-flex"><span
                                                        style="margin-top: 7px;margin-right: 7px;">Change Status :</span>
                                                <label class="select">
                                                    <select class="select-design-adjst form-control"
                                                            onchange="chageMyStatus(this.value,'<?= $order->OrderID ?>')">
														<option value="">Please Select Status</option>
                                                        <?php /*if ($order->PaymentMethods == "Sample Order") { ?>
                                                            <option value="" selected>Dispatch</option>
                                                        <?php } */ ?>


                                                        <?php foreach ($status as $key => $state) { ?>
                                                            <option value="<?= $key ?>" <?php if ($order->OrderStatus == $key) { ?> selected <?php } ?>>
                                                                <?= $state ?>
                                                            </option>

                                                        <?php } ?>


                                                    </select>
                                                    <i></i>
                                                </label>
                                            </p>

                                        <? } ?>

                                        <!--<p>Payment : Visa £128.38 GBP Balance : £00.00 GBP</p>-->

                                        <div class="row" style="margin: 0px;">

                                            <?php if ($order->OrderStatus == 6) { ?>
                                                <span id="cr_py">
                                                    <form method="get" action="<?= main_url ?>order_quotation/order/takeCreditCartPayment">
                                                            <input type="hidden" name="orderNumber" value="<?= $order->OrderNumber ?>">
                                                            <input type="hidden" name="type" value="creditCard">
                                                            <button type="submit" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10" style="margin-right: 10px;"> Take Payment </button>
                                                    </form>
                                                </span>
                                            <? } ?>


                                            <?php if ($order->OrderStatus != 7) { ?>

                                                <span style="margin-right: 10px;">
                                                    <button type="button" onclick="makeZeroPrice('<?= $order->OrderNumber ?>')"  class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10"> Make Zero Value </button>
                                                </span>


                                                <span style="margin-right: 10px;">
                                                    <button type="button" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10">
                                                        <a onclick="sendemail_again('<?= $order->OrderNumber ?>')">Send Order Email Again</a></button>
                                                </span>


                                                <? $UserTypeID = $this->session->userdata('UserTypeID');
                                                //if ($UserTypeID == 50) { ?>
                                                    <span style="margin-right: 10px;">
                                                        <button type="button" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10 zerodowndelivery" data-id="<?= $order->OrderNumber ?>">Zero down Delivery</button>
                                                    </span>
                                                <? //}  ?>
                                                
                                                <?php
                                                 $uID = $this->session->userdata('UserID');

                                                if ($UserTypeID == 50 || $uID==653722) { ?>
                                                
                                                <? if ($order->Label == 1) { ?>
                                                    <span style="margin-right: 10px;">
                                                        <button type="button" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10" onclick="changeorderlabel('<?= $order->OrderNumber ?>',0)">Make Standard Order</button>
                                                    </span>
                                                <? } else { ?>
                                                    <span style="margin-right: 10px;">
                                                        <button type="button" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10" onclick="changeorderlabel('<?= $order->OrderNumber ?>',1)">Make Plain Cover Order</button>
                                                    </span>
                                                <? } ?>
                                                <?php } ?>


                                                <? if ($order->PaymentMethods == "purchaseOrder") { ?>
                                                    <span class="" id="pr_py">
                                                        <button type="button" onclick="showpomodel()" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10"> Purchase Order </button>
                                                    </span>
                                                <? } ?>

                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display: flex;">
                                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                                    <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                                    <div class="card-body">
                                        <b>Company Name:</b> <?= $order->BillingCompanyName ?>
                                        </br>
                                        <b> Name:</b> <?= $order->BillingFirstName . ' ' . $order->BillingLastName ?>
                                        </br>
                                        <b>Address 1:</b> <?= $order->BillingAddress1 ?>
                                        </br>
                                        <b>Address 2:</b> <?= $order->BillingAddress2 ?>
                                        </br>
                                        <b>City:</b> <?= $order->BillingTownCity ?>
                                        </br>
                                        <b>County/State::</b> <?= $order->BillingCountyState ?>
                                        </br>
                                        <b>Country:</b> <?= $order->BillingCountry ?>
                                        </br>
                                        <b>Postcode:</b> <?= $order->BillingPostcode ?>
                                        </br>
                                        <b>Email:</b>
                                        <?= $order->Billingemail ?>
                                        </br>
                                        <b>T:</b>
                                        <?= $order->Billingtelephone ?>
                                        <b>M:</b>
                                        <?= $order->BillingMobile ?>
                                        </br>

                                        <br>


                                        <?php
                                        $restofworld_list = $this->shopping_model->grouped_country_list('ROW');
                                        $europeunion_list = $this->shopping_model->grouped_country_list('EUROPEAN UNION');
                                        $europe_list = $this->shopping_model->grouped_country_list('EUROPE');

                                        $country = $order->BillingCountry;
                                        $delivery_country = $order->DeliveryCountry;
                                        ?>

                                        <a href="#"
                                           class="btn btn-secondary waves-light waves-effect enquiry-save-button col-md-3 float-right"
                                           data-toggle="modal" data-target="#myModal_billing"
                                           style="margin-right: 22px;height: 32px;padding-top: 5px;padding-right: 0px;padding-left: 0px;">Edit</a>
                                        <div id="myModal_billing" class="modal fade" tabindex="-1"
                                             data-backdrop="static" data-keyboard="false" role="dialog"
                                             aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <!--<button type="button" class="close" data-dismiss="modal"aria-hidden="true">×
                                  </button>-->
                                                        <h4 class="modal-title" id="myModalLabel">Edit Billing
                                                            Address</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form role="form" method="post" action="">
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Company Name</b>
                                                                        <input type="text" id="Company" name="Company"
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingCompanyName ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>First Name</b>
                                                                        <input type="text" id="FirstName" required
                                                                               name="FirstName" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingFirstName ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Last Name</b>
                                                                        <input type="text" id="Lastname" required
                                                                               name="Lastname" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingLastName ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Address 1</b>
                                                                        <input type="text" id="Address1" name="Address1"
                                                                               required style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingAddress1 ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Address 2</b>
                                                                        <input type="text" id="Address2" name="Address2"
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingAddress2 ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>City</b>
                                                                        <input type="text" id="TownCity" name="TownCity"
                                                                               required style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingTownCity ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>County/State</b>
                                                                        <input type="text" id="CountyState"
                                                                               name="CountyState" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingCountyState ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Country</b>
                                                                        <select name="bill_country" id="bill_country"
                                                                                class="form-control"
                                                                                aria-controls="responsive-datatable">

                                                                            <option value="">Select Country</option>

                                                                            <optgroup label="UK">
                                                                                <option data-value="GB" <?= ($country == 'United Kingdom') ? 'selected="selected"' : '' ?>
                                                                                        value="United Kingdom">United
                                                                                    Kingdom
                                                                                </option>
                                                                            </optgroup>
                                                                            <optgroup label="EUROPEAN UNION">

                                                                                <? foreach ($europeunion_list as $row) { ?>
                                                                                    <option data-value="<?= $row->c_code ?>"
                                                                                            data-vat="EUROPEAN UNION" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                                                            value="<?= $row->name ?>"> <?= $row->name ?>
                                                                                    </option>
                                                                                <? } ?>
                                                                            </optgroup>

                                                                            <optgroup label="EUROPE">
                                                                                <? foreach ($europe_list as $row) { ?>
                                                                                    <option <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                                                            data-vat="EUROPE"
                                                                                            value="<?= $row->name ?>"> <?= $row->name ?>
                                                                                    </option>
                                                                                <? } ?>
                                                                            </optgroup>

                                                                            <optgroup label="ROW">
                                                                                <? foreach ($restofworld_list as $row) { ?>
                                                                                    <option data-value="<?= $row->c_code ?>"
                                                                                            data-vat="ROW" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                                                            value="<?= $row->name ?>"> <?= $row->name ?>
                                                                                    </option>
                                                                                <? } ?>
                                                                            </optgroup>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Post Code</b>
                                                                        <input type="text" id="pcode" name="pcode"
                                                                               required style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingPostcode ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Email</b>
                                                                        <input type="email" name="BEmail" required
                                                                               id="BEmail" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->Billingemail ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Telephone</b>
                                                                        <input type="text" id="Telephone"
                                                                               name="Telephone" required
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->Billingtelephone ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Mobile</b>
                                                                        <input type="text" id="Mobile" name="Mobile"
                                                                               required style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->BillingMobile ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                          
                                        
                                                            </div>
                                                            
                                                            
                                                              <? if ($order->PaymentMethods == "purchaseOrder" || $order->PurchaseOrderNumber!="") { ?>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Purchase Order No</b>
                                                                        <input type="text" id="purchase_o_no"
                                                                               name="purchase_o_no" required
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->PurchaseOrderNumber ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                   
                                                                </div>
                                                            </div>
                                                            <?php } ?>

                                                    </div>
                                                    <div class="modal-footer" style="margin: 0px auto;">
                                                        <button type="button" onclick="closebilling()"
                                                                class="btn btn-pink waves-effect waves-light col-md-12">
                                                            Back
                                                        </button>
                                                        <button type="button"
                                                                onclick="Updatebilling(<?= $order->OrderID ?>)"
                                                                class="btn btn-purple waves-effect waves-light col-md-12">
                                                            Update
                                                        </button>
                                                    </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display: flex">
                                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                                    <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                                    <div class="card-body">
                                        <b>Company Name:</b> <?= $order->DeliveryCompanyName ?>
                                        </br>
                                        <b>Name:</b> <?= $order->DeliveryFirstName . ' ' . $order->DeliveryLastName ?>
                                        </br>
                                        <b>Address 1:</b> <?= $order->DeliveryAddress1 ?>
                                        </br>
                                        <b>Address 2:</b> <?= $order->DeliveryAddress2 ?>
                                        </br>
                                        <b>City:</b> <?= $order->DeliveryTownCity ?>
                                        </br>
                                        <b>County/State:</b> <?= $order->DeliveryCountyState ?>
                                        </br>
                                        <b>Country:</b> <?= $order->DeliveryCountry ?>
                                        </br>
                                        <b>Postcode:</b> <?= $order->DeliveryPostcode ?>
                                        </br>
                                        <b>Email:</b>
                                        <?= $order->Deliveryemail ?>
                                        </br>
                                        <b>T:</b>
                                        <?= $order->Deliverytelephone ?>
                                        <b> | M:</b>
                                        <?= $order->DeliveryMobile ?>
                                        </br>

                                        <br>
                                        <a href="#"
                                           class="btn btn-secondary waves-light waves-effect enquiry-save-button col-md-3 float-right"
                                           data-toggle="modal" data-target="#myModal_del"
                                           style="margin-right: 22px;height: 32px;padding-top: 5px;padding-right: 0px;padding-left: 0px;">Edit</a>

                                        <div id="myModal_del" class="modal fade" tabindex="-1" data-backdrop="static"
                                             data-keyboard="false" role="dialog" aria-labelledby="myModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <!-- <button type="button" class="close" data-dismiss="modal"aria-hidden="true">× </button>-->
                                                        <h4 class="modal-title" id="myModalLabel">Edit Delivery
                                                            Address</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form role="form" method="post" action="">
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Company Name</b>
                                                                        <input type="text" id="DCompany" name="Company"
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryCompanyName ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>First Name</b>
                                                                        <input type="text" id="DFirstName" required
                                                                               name="FirstName" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryFirstName ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Last Name</b>
                                                                        <input type="text" id="DLastname" required
                                                                               name="Lastname" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryLastName ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Address 1</b>
                                                                        <input type="text" id="DAddress1"
                                                                               name="dAddress1" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryAddress1 ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Address 2</b>
                                                                        <input type="text" id="DAddress2"
                                                                               name="dAddress2" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryAddress2 ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>City</b>
                                                                        <input type="text" id="DTownCity"
                                                                               name="dTownCity" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryTownCity ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>County/State</b>
                                                                        <input type="text" id="DCountyState"
                                                                               name="dCountyState" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryCountyState ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Country</b>
                                                                        <select name="Dbill_country" id="Dbill_country"
                                                                                class=" form-control"
                                                                                aria-controls="responsive-datatable">
                                                                            <option value="">Select Country</option>

                                                                            <optgroup label="UK">
                                                                                <option data-value="GB" <?= ($delivery_country == 'United Kingdom') ? 'selected="selected"' : '' ?>
                                                                                        value="United Kingdom">United
                                                                                    Kingdom
                                                                                </option>
                                                                            </optgroup>
                                                                            <optgroup label="EUROPEAN UNION">

                                                                                <? foreach ($europeunion_list as $row) { ?>
                                                                                    <option data-value="<?= $row->c_code ?>"
                                                                                            data-vat="EUROPEAN UNION" <?= ($delivery_country == $row->name) ? 'selected="selected"' : '' ?>
                                                                                            value="<?= $row->name ?>"> <?= $row->name ?>
                                                                                    </option>
                                                                                <? } ?>
                                                                            </optgroup>

                                                                            <optgroup label="EUROPE">
                                                                                <? foreach ($europe_list as $row) { ?>
                                                                                    <option <?= ($delivery_country == $row->name) ? 'selected="selected"' : '' ?>
                                                                                            data-vat="EUROPE"
                                                                                            value="<?= $row->name ?>"> <?= $row->name ?>
                                                                                    </option>
                                                                                <? } ?>
                                                                            </optgroup>

                                                                            <optgroup label="ROW">
                                                                                <? foreach ($restofworld_list as $row) { ?>
                                                                                    <option data-value="<?= $row->c_code ?>"
                                                                                            data-vat="ROW" <?= ($delivery_country == $row->name) ? 'selected="selected"' : '' ?>
                                                                                            value="<?= $row->name ?>"> <?= $row->name ?>
                                                                                    </option>
                                                                                <? } ?>
                                                                            </optgroup>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Post Code</b>
                                                                        <input type="text" id="Dpcode" name="Dpcode"
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryPostcode ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Email</b>
                                                                        <input type="text" name="DEmail" required
                                                                               id="DEmail" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->Deliveryemail ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Telephone</b>
                                                                        <input type="text" id="DTelephone"
                                                                               name="Telephone" style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->Deliverytelephone ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 ">
                                                                    <div class="form-group">
                                                                        <b>Mobile</b>
                                                                        <input type="text" id="DMobile" name="Mobile"
                                                                               required style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?= $order->DeliveryMobile ?>"
                                                                               placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer" style="margin: 0px auto;">
                                                        <button type="button" onclick="closedelivery()"
                                                                class="btn btn-pink waves-effect waves-light col-md-12">
                                                            Back
                                                        </button>
                                                        <button type="button"
                                                                onclick="Updatedelivery(<?= $order->OrderID ?>)"
                                                                class="btn btn-purple waves-effect waves-light col-md-12">
                                                            Update
                                                        </button>
                                                    </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">

      <span class="labels-form">
        <span class="float-right form-group" style="margin-right: 20px;margin-bottom: 20px;">
        <label class="select">
        <? $currency_options = $this->cartModal->get_currecy_options();
        $currency = $order->currency;
        $exchange_rate = $order->exchange_rate;
        $fetch_symbol = $this->db->query("select symbol from exchange_rates where currency_code LIKE '" . $currency . "'")->row_array();
        $symbol = $fetch_symbol['symbol'];
        ?>

          <select class="form-control " onchange="order_currency(this.value,'<?= $order->OrderNumber ?>');">
            <? foreach ($currency_options as $row) { ?>
                <option class="curency"
                        value="<?= $row->currency_code ?>" <?= ($row->currency_code == $currency) ? 'selected="selected"' : '' ?>><?= $row->currency_code ?>
              (<?= $row->symbol ?>)
            </option>
            <? } ?>
          </select>
          <i></i>
        </label>

      </span>
    </span>


                        <div class="card-box">
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr class="card-heading-title">
                                        <th class="text-center invoice-heading-text" width="10%">Manufacturer ID</th>
                                        <th class="text-center invoice-heading-text" width="60%">Description</th>
                                        <th class="text-center invoice-heading-text text-center" width="10%">Labels</th>
                                        <th class="text-center invoice-heading-text" width="10%">Quantity</th>
                                        <th class="text-center invoice-heading-text text-center" width="5%">Ext.VAT</th>
                                        <th class="text-center invoice-heading-text" width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody style="color: #666;">
                                    <?php
                                    $totalPrice = 0;
                                    //echo '<pre>'; print_r($orderDetails); echo '</pre>';
                                    $exchange_rate = $order->exchange_rate;
                                    $symbol = $this->orderModal->get_currecy_symbol($order->currency);
                                    $count = 1;
                                    $clr_class = 'c1';

                                    foreach ($orderDetails as $key => $detail) {


                                        if ($count % 2) {
                                            $clr_class = 'c1';
                                        } else {
                                            $clr_class = 'c2';
                                        }


                                        $format = 'Sheets';
                                        $regex = "/Roll/";

                                        if (preg_match($regex, $detail->ProductBrand, $match)) {

                                            $format = ($detail->Quantity > 1) ? 'Rolls' : 'Roll';
                                        }


                                        $orderDetail = $detail;
                                        $product_detail = $this->user_model->getproductdetail($detail->ProductID);
                                        $permissions = $this->settingmodel->checkpermissions($detail->SerialNumber, $product_detail, $order->OrderStatus, $order->editing);


                                        $totalPrice = $totalPrice + ($detail->Price + $detail->Print_Total);


                                        $product = $this->user_model->getproductdetail($detail->ProductID);

                                        $digitalCheck = ($detail->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';
                                        ?>

                                        <?
                                        if (preg_match('/Roll Labels/is', $detail->ProductBrand) && $detail->Printing == "Y" and $detail->regmark != 'Y') {

                                            if ($detail->Wound == 'Y' || $detail->Wound == 'Inside') {
                                                $wound_opt = 'Inside Wound';
                                            } else {
                                                $wound_opt = 'Outside Wound';
                                            }
                                            $labeltype = $this->home_model->get_printing_service_name($detail->Print_Type);
                                            $productname1 = explode("-", $product_detail['ProductCategoryName']);
                                            $productname1[1] = str_replace("(", "", $productname1[1]);
                                            $productname1[1] = str_replace(")", "", $productname1[1]);
                                            $productname1[0] = str_replace("rolls labels", "", $productname1[0]);
                                            $productname1[0] = str_replace("roll labels", "", $productname1[0]);
                                            $productname1[0] = str_replace("Roll Labels", "", $productname1[0]);

                                            $productname1 = "Printed Labels on Rolls - " . str_replace("roll label", "", $productname1[0]) . ' - ' . $productname1[1];
                                            $completeName = ucfirst($productname1) . ' ' . $wound_opt . ' - Orientation ' . $detail->Orientation . ', ';

                                            if ($detail->FinishType == 'No Finish') {
                                                $labelsfinish = ' With Label finish: None ';
                                            } else {
                                                $labelsfinish = ' With Label finish : ' . $detail->FinishType;
                                            }
                                            $completeName .= $labeltype . ' ' . $labelsfinish;
                                            $detail->ProductName = $completeName;

                                            $this->db->where('SerialNumber', $detail->SerialNumber);
                                            $this->db->update('orderdetails', array('ProductName' => $detail->ProductName));
                                        }
                                        ?>


                                        <?php
                                        $des_gn = '';
                                        if ($detail->Print_Qty > 1) {
                                            $des_gn = 'Designs';
                                        } else {
                                            $des_gn = 'Design';
                                        }
                                        $des_free = '';
                                        if ($detail->Free > 1) {
                                            $des_free = 'Designs';
                                        } else {
                                            $des_free = 'Design';
                                        }
                                        ?>


                                        <input type="hidden" id="brnds<?php echo $detail->SerialNumber ?>"
                                               value="<?= $detail->ProductBrand ?>">
                                        <?php if ($detail->ProductBrand == 'Integrated Labels') {
                                            $miso = (preg_match('/250 Sheet Dispenser Packs/is', $detail->ProductName)) ? 250 : 1000;

                                        } else {
                                            $miso = $this->orderModal->min_qty_integrated($detail->ManufactureID);
                                        }
                                        ?>


                                        <input type="hidden"
                                               data-min_qty_integrated="<?php echo $detail->SerialNumber ?>"
                                               value="<?= $miso ?>">
                                        <input type="hidden"
                                               data-max_qty_integrated="<?php echo $detail->SerialNumber ?>"
                                               value="<?php echo $this->orderModal->max_qty_integrated($detail->ManufactureID); ?>">


                                        <?php if ($order->editing == 'yes') { ?>
                                            <?php if ($detail->ProductID == 0) { ?>
                                                <?php if ($detail->ManufactureID != 'SCO1') { ?>
                                                    <tr class="<?= $clr_class ?>">
                                                        <td>
                                                            <input type="text"
                                                                   class="form-control input-number text-center"
                                                                   id="update_line_man<?= $key ?>"
                                                                   value="<?= $detail->ManufactureID ?>">
                                                        </td>
                                                        <td>
                              <textarea id="update_line_des<?= $key ?>"
                                        class="form-control input-number"
                                        style="height: 25.38px;"><?= $detail->ProductName; ?>
                              </textarea>
                                                        </td>
                                                        <td align="center">

                                                            <?php if ($detail->ProductID == 0) { ?>
                                                                --

                                                            <?php } else { ?>
                                                                <input class="form-control input-number text-center allownumeric"
                                                                       type="text"
                                                                       id="update_line_unit_price<?= $key ?>"
                                                                       value="<?= @number_format($detail->Price / $detail->labels, 3) ?>"
                                                                       placeholder="unit price">
                                                            <?php } ?>
                                                        </td>

                                                        <td>
                                                            <input type="text"
                                                                   class="form-control input-number text-center allownumeric"
                                                                   id="update_line_qty<?= $key ?>"
                                                                   value="<?= $detail->Quantity ?>"
                                                                   placeholder="quanity">
                                                        </td>
                                                        <td><? echo $symbol . (number_format($detail->Price * $order->exchange_rate, 2, '.', '')); ?></td>
                                                        <td class="padding-6 icon-tablee">
                                                            <i class="fa fa-trash-o bt-delete"
                                                               onclick="deleteOrderNode(<?= $detail->SerialNumber ?>,'<?= $order->OrderNumber ?>')"
                                                               id="deletenode1"></i>
                                                            <i class="fa fa-floppy-o bt-save"
                                                               onclick="updateOrderNewLine(<?= $key ?>,<?= $detail->SerialNumber ?>,<?= $detail->UserID ?>)"></i>
                                                        </td>
                                                    </tr>

                                                    <tr class="<?= $clr_class ?>"
                                                        id="order_note_line<?= $key ?>" <?php if ($detail->Product_detail == null && $order->editing == "yes") { ?> style="display: none;" <?php } ?>>
                                                        <td></td>
                                                        <td><input type="text" required id="note_for_od<?= $key ?>"
                                                                   value="<?= $detail->Product_detail ?>"
                                                                   class="form-control input-number  allownumeric"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-center"></td>
                                                        <td class="padding-6 icon-tablee"><i
                                                                    class="fa fa-trash-o bt-delete"
                                                                    onclick="deleteNoteForOrder(<?= $detail->SerialNumber ?>)"> </i>
                                                            <i class="fa fa-floppy-o bt-save"
                                                               onclick="insertNoteForOrder(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i>
                                                        </td>
                                                    </tr>

                                                <?php } else {
                                                    ?>
                                                    <tr class="noneditable" class="<?= $clr_class ?>">
                                                        <td class="text-center">
                                                            <strong><?php echo $detail->ManufactureID ?>   </strong></td>
                                                        <td><?= $detail->pn ?>
                                                        
                                                     <?php   $carRes = $this->user_model->getCartOrderData($detail->SerialNumber);
                                                     
                                                     
                                                      
                                                                    $mm = '';
                                                                    if($carRes[0]->height != null) {
                                                                    $mm=' x';
                                                                    }
													
                                                                    if($carRes[0]->shape!="Circle"){
                                                                         $carRes[0]->height = ($carRes[0]->height!=null)?($carRes[0]->height):($carRes[0]->width); 
                                                                        $mm=' x';
                                                                } 
                                                     ?>
                                                        
                                                         <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?>|
                                                         <b>Format: </b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?>|
                                                         <b>Size: </b>
                                                         <?= (isset($carRes[0])) ? $carRes[0]->width.'mm'.$mm  : '' .' x' ?>
                                                         <?= ((isset($carRes[0])) && $carRes[0]->height != null) ? (isset($carRes[0]) && $carRes[0]->width!="") ? $carRes[0]->width : '' : ($carRes[0]->height!="" && $carRes[0]->height!="NULL") ? $carRes[0]->height.'mm': '' ?>|
													 
                                                         <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?>|
                                                         <b>Across: </b><?= (isset($carRes[0])) ? $carRes[0]->across : '' ?>|
                                                         <b>Around: </b><?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
													
                                                        <?php if(($carRes[0]->shape != 'Circle') && ($carRes[0]->shape !='Oval')){?>
                                                            |<b>Corner Radius: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
                                                        <?php } ?>
                                                            |<b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>
                
                                                            |<b>TempCode: </b><?= (isset($carRes[0])) ? $carRes[0]->tempcode : '' ?>
                                                        
                                                        
                                                        <?php //$detail->ProductName; ?>
                                                        
                                                        
                                                        
                                                        </td>

                                                        <?php if ($detail->ManufactureID == 'SCO1') { ?>
                                                            <td class="text-center"><?= $detail->Quantity ?></td>
                                                        <?php } else { ?>
                                                            <td class="text-center"><?= $unit_price ?></td>
                                                        <?php } ?>

                                                        <td class="text-center"><?= $detail->Quantity ?></td>
                                                        <td class="text-center"><?= $symbol ?>
                                                            <?= number_format($detail->Price * $exchange_rate,2,'.','') ?></td>
                                                        <td style="text-align:center"><i class="fa fa-plus bt-plus"
                                                                                         id="update<?= $key ?>"
                                                                                         onclick="noteForOrder(<?= $key ?>,'<?= $detail->OrderNumber ?>',<?= $detail->SerialNumber ?>)"></i>
                                                        </td>

                                                    </tr>
                                                    <?php if ($detail->ManufactureID == 'SCO1' && $detail->Linescompleted == 0) {

                                                        $carRes = $this->user_model->getCartOrderData($detail->SerialNumber);
                                                        ?>
                                                        <?php
                                                        $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
                                                        $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                                                        foreach ($assoc as $rowp) {
                                                            ?>
                                                            <? $materialprice = ($rowp->plainprice + $rowp->printprice); ?>
                                                            <? $materialpriceinc = $materialprice * 1.2; ?>
                                                            <? if ($carRes[0]->format == 'Roll') {
                                                                $format = ($rowp->qty > 1) ? 'Rolls' : 'Roll';
                                                            } ?>
                                                            <?php $sho = '';
                                                            if ($carRes[0]->format == 'Roll') {
                                                                $sho = $rowp->rolllabels;
                                                            } else {
                                                                $sho = ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate);
                                                            } ?>

                                                            <tr class="<?= $clr_class ?>">
                                                                <td class="text-center labels-form"><?= $rowp->material ?></td>

                                                                <td class="" align="left"><i class="mdi "></i>
                                                                    <?= $this->user_model->get_mat_name($rowp->material); ?>
                                                                    - <?= $rowp->labeltype ?> labels
                                                                </td>
                                                                <td class="text-center"
                                                                    id="labels0"><?= $symbol ?><?= @number_format(($materialprice / $sho) * $exchange_rate, 3) ?></td>
                                                                <td class="text-center">

                                                                    <?= $rowp->qty; ?> <?php echo ucfirst($format); ?>
                                                                    <br>
                                                                    <? if ($scorecord['format'] == 'Roll') {
                                                                        echo $rowp->rolllabels;
                                                                    } else {
                                                                        echo(($scorecord['across'] * $scorecord['around']) * $rowp->qty);
                                                                    }; ?> labels
                                                                </td>
                                                                <td class="text-center"><?= $symbol ?>
                                                                    <? echo number_format($materialprice * $exchange_rate, 2); ?>
                                                                    <?php $totalPrice += $materialprice ; ?></td>
                                                                <td></td>
                                                            </tr>

                                                            <?php if (($rowp->labeltype == 'printed' && $carRes[0]->format != 'Roll') || ($carRes[0]->format == 'Roll')) { ?>

                                                                <?php //echo '<pre>'; print_r($assoc);  ?>

                                                                <tr>
                                                                    <td class="invoicetable_tabel_border"></td>
                                                                    <td class="invoicetable_tabel_border">
                                                                        <i class="mdi mdi-check"></i><span>
    <?php

    if ($rowp->printing == "Mono") { ?>
        <?php $rowp->printing = "Black Only"; ?>
    <?php } ?>

    <?= $rowp->printing ?>
    </span>
                                                                        <?php if ($rowp->designs > 0) { ?>
                                                                            <i class="mdi mdi-check"></i> <span>
    <?php $des = ($assoc[0]->designs > 1) ? "Designs" : "Design"; ?>
    <?= $rowp->designs . ' ' . $des ?>
    </span>
                                                                        <?php } ?>
                                                                        <?php

                                                                        if ($carRes[0]->format == 'Roll') { ?>
                                                                            <span class="invoice-bold">
      <strong style="font-size:12px;">Wound:</strong>
      <?php if (!empty($rowp->wound)) echo $rowp->wound; ?>
    </span>
                                                                            <span class="invoice-bold">
      <strong style="font-size:12px;">Orientation:</strong>
      <?php if (!empty($rowp->core)) echo $rowp->core; ?>
    </span>
                              <?php if($detail->FinishType!=""){ ?>
                                                                            <span class="invoice-bold">
      <strong style="font-size:12px;">Finish:</strong>
      <?= $rowp->finish ?>
    </span>
<?php } ?>
                                                                        <?php } ?>

                                                                    </td>


                                                                    <?php
                                                                    $word = "AAQ";
                                                                    if (strpos($QuoteNumber['QuotationNumber'], $word) !== false) { ?>
                                                                        <td class="text-center invoicetable_tabel_border"></td>
                                                                    <?php } ?>

                                                                    <td class="text-center invoicetable_tabel_border"
                                                                        align="center">
                                                                        <?php
                                                                        if ($carRes[0]->format != 'Roll') {
                                                                            ?>
                                                                            <?= $symbol ?>5.32
                                                                            <br>
                                                                            Per Design
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </td>

                                                                    <td class="text-center invoicetable_tabel_border"
                                                                        align="center"> <?php
                                                                        if ($detail->regmark != 'Y' && $carRes[0]->format != 'Roll') {
                                                                            $des = ($rowp->designs > 1) ? "Designs" : "Design";
                                                                            echo $rowp->designs . ' ' . $des;

                                                                            ?>

                                                                        <? } ?></td>
                                                                    <td class="text-center invoicetable_tabel_border"
                                                                        align="center"><?= $symbol ?><?= number_format(($detail->Print_Total * $exchange_rate), 2) ?></td>
                                                                    <td></td>

                                                                </tr>
                                                            <?php } ?>


                                                        <?php } ?>

                                                        <tr id="order_note_line<?= $key ?>" <?php if ($detail->Product_detail == null && $order->editing == "yes") { ?> style="display: none;" <?php } ?>
                                                            class="<?= $clr_class ?>">
                                                            <td></td>
                                                            <td>
                                                                <input type="text" required id="note_for_od<?= $key ?>"
                                                                       value="<?= $detail->Product_detail ?>"
                                                                       class="form-control input-number  allownumeric">
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center"></td>
                                                            <td class="padding-6 icon-tablee">
                                                                <i class="fa fa-trash-o bt-delete"
                                                                   onclick="deleteNoteForOrder(<?= $detail->SerialNumber ?>)"> </i>
                                                                <i class="fa fa-floppy-o bt-save"
                                                                   onclick="insertNoteForOrder(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i>
                                                            </td>
                                                        </tr>

                                                    <?php }
                                                } ?>
                                            <?php } else {
                                                $calco = $this->home_model->getProductCalculation($detail->ProductID, $detail->ManufactureID);
                                                ?>
                                                <tr class="editAble <?= $clr_class ?>"
                                                    id="od_dt_line<?= $detail->SerialNumber ?>">

                                                    <input type="hidden" id="minroll<?= $key ?>"
                                                           value="<?= $calco['minRoll'] ?>">
                                                    <input type="hidden" id="maxroll<?= $key ?>"
                                                           value="<?= $calco['maxRoll'] ?>">
                                                    <input type="hidden" id="minlabel<?= $key ?>"
                                                           value="<?= $calco['minLabels'] ?>">
                                                    <input type="hidden" id="maxlabel<?= $key ?>"
                                                           value="<?= $calco['maxLabels'] ?>">

                                                    <td class="text-center labels-form">
                                                        <? if ($permissions['die'] == 1 && $permissions['mat'] == 1) {
                                                            ?>
                                                            <input style="margin-bottom: 10px;" type="hidden"
                                                                   id="hide_die_<?= $detail->SerialNumber ?>" value=""
                                                                   class="form-control input-number text-center allownumeric"/>
                                                            <input class=" die form-control input-number text-center allownumeric ui-autocomplete-input"
                                                                   type="text" autocomplete="on"
                                                                   id="die_<?= $detail->SerialNumber ?>"
                                                                   value="<?= $detail->ManufactureID ?>"
                                                                   data-val="<?= $detail->SerialNumber ?>">
                                                            <a id="dis_<?= $detail->SerialNumber ?>"
                                                               data-serial="<?= $detail->SerialNumber ?>"
                                                               data-newcode="" class="changediecode">update</a>
                                                        <? } else if ($permissions['mat'] == 1) {

                                                            $materialcode = $this->quoteModel->getmaterialcode($detail->ManufactureID);
                                                            $die = str_replace($materialcode, "", $detail->ManufactureID);
                                                            ?>
                                                            <input style="margin-bottom: 10px;" type="text"
                                                                   id="hide_die_<?= $detail->SerialNumber ?>"
                                                                   value="<?= $die ?>"
                                                                   class="form-control input-number text-center allownumeric"
                                                                   readonly/>
                                                            <input class="autocomplete_bg die ui-autocomplete-input form-control input-number text-center allownumeric"
                                                                   type="text" autocomplete="on"
                                                                   id="die_<?= $detail->SerialNumber ?>"
                                                                   value="<?= $materialcode ?>"
                                                                   data-val="<?= $detail->SerialNumber ?>">

                                                            <a id="dis_<?= $detail->SerialNumber ?>"
                                                               data-serial="<?= $detail->SerialNumber ?>"
                                                               data-newcode="" class="changediecode">update</a>
                                                        <?php } else {
                                                            echo $detail->ManufactureID;
                                                            if ($detail->source == "LBA") {
                                                                ?>
                                                                <br/>
                                                                <a data-id="<?= $detail->user_project_id ?>"
                                                                   data-serial="<?= $detail->SerialNumber ?>"
                                                                   class="load_flash" style="cursor:pointer"><b>Edit
                                                                        Design</b>
                                                                </a>
                                                            <?php }
                                                        } ?>
                                                        <br/>
                                                        <?php if ($detail->ProductID != 0 && $permissions['add_rem_prnt'] == 1) {
                                                            if ($detail->regmark == 'Y') {
                                                                ?>


                                                            <?php } else {
                                                                ?>
                                                                <label class="select">
                                                                    <select class="form-control"
                                                                            onchange="conPlainOrPrint(this.value,<?= $detail->SerialNumber ?>,<?= $key ?>)">
                                                                        <option value="N" <? if ($detail->Printing != 'Yes' || $detail->Printing != 'Y') { ?> selected <? } ?>>
                                                                            Plain
                                                                        </option>
                                                                        <option value="Y" <? if ($detail->Printing == 'Yes' || $detail->Printing == 'Y') { ?> selected <? } ?>>
                                                                            Printed
                                                                        </option>
                                                                    </select>
                                                                    <i></i> </label>
                                                            <?php }
                                                        } ?>
                                                    </td>

                                                    <td><?= $detail->ProductName . ' ' . $this->quoteModel->txt_for_plain_labels($order->Label); ?>
                                                        <?php if ($detail->regmark == 'Y') { ?>
                                                            <br/>
                                                            <b>Printing Service (Black Registration Mark on Reverse)</b>
                                                        <?php } ?>
                                                    </td>

                                                    <td class="text-center"
                                                        id="labels<?= $key ?>"><?= ($detail->sample == 'sample' || $detail->sample == 'Sample') ? 0.00 : $symbol . @number_format(($detail->Price / $detail->labels) * $exchange_rate, 3, '.', ''); ?>
                                                        <br>
                                                        Per Label
                                                    </td>

                                                    <input type="hidden" id="label_for_orders<?= $key ?>"
                                                           value="<?= ($detail->sample == 'sample' || $detail->sample == 'Sample') ? 0.00 : $detail->labels ?>">

                                                    <td class="text-center">
                                                        <? if ($permissions['qty'] == 1) { ?>




                                                            <?= $detail->Quantity . ' ' . $format ?><br>

                                                            <?php if ($detail->sample == 'Sample') { ?>

                                                                <?php if ($digitalCheck != 'roll') { ?>
                                                                    <?= $detail->LabelsPerSheet; ?><?php echo ($detail->LabelsPerSheet > 0) ? "Labels" : "Label" ?>
                                                                <?php } ?>

                                                            <?php } else { ?>

                                                                <?php if (preg_match("/Integrated Labels/i", $detail->ProductBrand)) { ?>
                                                                    <?= $detail->Quantity; ?><?php echo ($detail->Quantity > 0) ? "Labels" : "Label" ?>
                                                                <?php } else { ?>
                                                                    <?= $detail->labels; ?><?php echo ($detail->labels > 0) ? "Labels" : "Label" ?>
                                                                <?php } ?>

                                                            <?php } ?>


                                                            <input type="<?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') {
                                                                //echo 'hidden';
                                                            } ?>"
                                                                   onchange="updateLabels(<?= $key ?>,<?= $detail->LabelsPerRoll ?>)"
                                                                   id="qty<?= $key ?>"
                                                                   value="<?= $detail->Quantity ?>" <?php if (($detail->Printing == 'Y' && $detail->regmark != 'Y') || ($detail->sample == 'sample' || $detail->sample == "Sample")) { ?> readonly <?php } ?>
                                                                   class="form-control input-number text-center allownumeric">

                                                        <?php } else { ?>

                                                            <?= $detail->Quantity . ' ' . $format ?><br>
                                                            <?php if ($detail->sample == 'Sample') { ?>
                                                                <?php if ($digitalCheck != 'roll') { ?>
                                                                    <?= $detail->LabelsPerSheet; ?><?php echo ($detail->LabelsPerSheet > 0) ? "Labels" : "Label" ?>
                                                                <?php } ?>

                                                            <?php } else { ?>

                                                                <?php if (preg_match("/Integrated Labels/i", $detail->ProductBrand)) { ?>
                                                                    <?= $detail->Quantity; ?><?php echo ($detail->Quantity > 0) ? "Labels" : "Label" ?>
                                                                <?php } else { ?>
                                                                    <?= $detail->labels; ?><?php echo ($detail->labels > 0) ? "Labels" : "Label" ?>
                                                                <?php } ?>
                                                            <?php } ?>

                                                            <?php if ($order->OrderStatus != 7) { ?>
                                                                <input type="text" id="qty<?= $key ?>" readonly
                                                                       value="<?= $detail->Quantity ?>"
                                                                       class="form-control input-number text-center allownumeric">
                                                            <?php } ?>


                                                        <?php } ?>
                                                    </td>

                                                    <input type="hidden" id="previousQty<?= $key ?>"
                                                           value="<?= $detail->Quantity ?>">
                                                    <input type="hidden" id="labelpreviousQty<?= $key ?>" value="<?= $detail->labels ?>">
                                                    <input type="hidden" id="arwtork_qty<?= $key ?>" value="">
                                                    <td class="text-center"><? echo $symbol . (number_format($detail->Price * $order->exchange_rate, 2, '.', '')); ?></td>
                                                    <td class="padding-6 icon-tablee">
                                                        <?php
                                                        $printing = ($detail->Printing == 'Y') ? 'Y' : 'N';
                                                        ?>
                                                        <?php if ($detail->sample != 'sample' && $detail->sample != "Sample") { ?>
                                                            <i class="fa fa-plus bt-plus" id="update<?= $key ?>"
                                                               onclick="noteForOrder(<?= $key ?>,'<?= $detail->OrderNumber ?>',<?= $detail->SerialNumber ?>)"></i>
                                                        <?php } ?>

                                                        <? if ($permissions['add_rem_pro'] == 1) { ?>
                                                            <i class="fa fa-trash-o bt-delete" id="delete<?= $key ?>"
                                                               onclick="delOrderDetail(<?= $key ?>,<?= $detail->SerialNumber ?>,'<?= $detail->OrderNumber ?>')"></i>
                                                        <? } ?>
                                                        <? if ($order->editing == "yes" && $order->OrderStatus != 7 && $order->OrderStatus != 8 && $order->OrderStatus != 33 && $order->OrderStatus != 27) { ?>
                                                            <?php if ($detail->sample != 'sample' && $detail->sample != "Sample") { ?>
                                                                <i class="fa fa-floppy-o bt-save"
                                                                   id="update_one<?= $key ?>"
                                                                   onclick="updateOrder(<?= $key ?>,'<?= $detail->OrderNumber ?>','<?= $detail->ProductBrand ?>','<?= $detail->ManufactureID ?>','<?= $detail->ProductID ?>','<?= $detail->pressproof ?>',<?= $detail->SerialNumber ?>,<?= $order->UserID ?>,'<?= $printing ?>','<?= $detail->LabelsPerRoll ?>','<?= $detail->regmark ?>')"></i>
                                                            <?php } ?>
                                                            <?php if ($order->OrderStatus != 7 && $permissions['qty'] == 0 && ($order->picking_status == 200 || $order->picking_status == 202)) { ?>
                                                                <br>
                                                                <input type="button"
                                                                       style="color:blue;text-decoration:underline;cursor:pointer;font-size: 11px; background:transparent; border: none"
                                                                       onclick="remove_4rm_stock(<?= $detail->SerialNumber ?>,'<?= $detail->OrderNumber ?>')"
                                                                       value="Unlock Line">
                                                            <?php } ?>
                                                        <? } ?>
                                                    </td>
                                                </tr>


                                                <? $detail_view = @$this->quotationModal->check_product_extra_detail($detail->ManufactureID);
                                                if ($detail_view['prompt'] == 'yes') {
                                                    ?>
                                                    <tr class="<?= $clr_class ?>">
                                                        <td class="text-center"><b style="color:green;font-size:12px;">Product
                                                                Note</b></td>
                                                        <td><b style="color:green;font-size:12px;">
                                                                <?= $detail_view['detail'] ?>
                                                            </b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>


                                                <? } ?>
                                                <tr id="order_note_line<?= $key ?>" <?php if ($detail->Product_detail == '') { ?> style="display: none;" <?php } ?>
                                                    class="<?= $clr_class ?>">
                                                    <td></td>
                                                    <td><input type="text" required id="note_for_od<?= $key ?>"
                                                               value="<?= $detail->Product_detail ?>"
                                                               class="form-control input-number  allownumeric"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center"></td>
                                                    <td class="padding-6 icon-tablee"><i class="fa fa-trash-o bt-delete"
                                                                                         onclick="deleteNoteForOrder(<?= $detail->SerialNumber ?>)"> </i>
                                                        <i class="fa fa-floppy-o bt-save"
                                                           onclick="insertNoteForOrder(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i>
                                                    </td>
                                                </tr>
                                                <?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') {  //echo '<pre>'; print_r($detail); echo '</pre>';?>
                                                    <tr class="<?= $clr_class ?>">
                                                        <td></td>
                                                        <td>
                                                            <div class="btn-span"> <span class="labels-form"
                                                                                         style="margin-right: 15px;">
                          <? if (($detail->Printing == 'Yes' || $detail->Printing == 'Y')) { ?>
                          <label class="select" style="margin-bottom: 0px !important;">
                            <select id="digital<?= $key ?>" class="form-control no-padding" name="digital"
                                    onchange="insertLog(this.value,<?= $detail->SerialNumber ?>,'Print_Type')">
                              <option value="">Please Select Digital Process</option>
                              <?php foreach ($digitalis as $digital) {


                                  if ($digital->type == $digitalCheck || $digital->type == 'both') { ?>
                                      <?php if ($detail->ProductBrand != 'Roll Labels') { ?>
                                          <option value="<?= $digital->name ?>"
                                    <?php if ($digital->Print_Type == $detail->Print_Type || $digital->name == $detail->Print_Type) {
                                        echo 'selected';
                                    } ?>>
                              <?= $digital->name; ?>
                              </option>
                                      <?php } else { ?>
                                          <option value="<?= $digital->name ?>" <?php if ($digital->name == $detail->Print_Type || $digital->Print_Type == $detail->Print_Type) {
                                              echo 'selected';
                                          } ?>>
                              <?= $digital->name; ?>
                              </option>
                                      <?php } ?>
                                  <?php }
                              } ?>
                            </select>
                            <i></i> </label>
                          </span>
                                                                <?php if ($detail->ProductBrand == 'Roll Labels') { ?>
                                                                    <span class="m-10 labels-form">
                          <label class="select">
                            <select id="Orientation<?= $key ?>"
                                    onchange="changeorientation(this.value,<?= $detail->SerialNumber ?>,'Orientation')"
                                    class="form-control no-padding">
                              <option value="">Please Select Orientation</option>
                              <option value="1"<?php if ($detail->Orientation == '1') {
                                  echo 'selected';
                              } ?>>Orientation 01 </option>
                              <option value="2"<?php if ($detail->Orientation == '2') {
                                  echo 'selected';
                              } ?>>Orientation 02 </option>
                              <option value="3"<?php if ($detail->Orientation == '3') {
                                  echo 'selected';
                              } ?>>Orientation 03 </option>
                              <option value="4"<?php if ($detail->Orientation == '4') {
                                  echo 'selected';
                              } ?>>Orientation 04 </option>
                            </select>
                            <i></i>
                            </label>
                          </span> <span class="m-10 labels-form">
                          <label class="select">
                            <select id="wound<?= $key ?>"
                                    onchange="changeorientation(this.value,<?= $detail->SerialNumber ?>,'Wound')"
                                    class="form-control no-padding">
                              <option selected="selected" value="">Select Wound Type</option>
                              <option value="Outside"<?php if ($detail->Wound == 'Outside') {
                                  echo 'selected';
                              } ?>>Out Side Wound</option>
                              <option value="Inside"<?php if ($detail->Wound == 'Inside') {
                                  echo 'selected';
                              } ?>>Inside Wound </option>
                            </select>
                            <i></i>
                        </label>
                        </span>


                                                                    <span class="m-10 labels-form">
                        <label class="select">

                          <select id="finish<?= $key ?>"
                                  onchange="insertLog(this.value,<?= $detail->SerialNumber ?>,'FinishType')"
                                  class="labelfinish form-control no-padding">

                            <option selected="selected" value="">Select Label Finish </option>

                            <option value="No Finish"<?php if ($detail->FinishType == 'No Finish') {
                                echo 'selected';
                            } ?>>No Finish </option>

                            <option value="Gloss Lamination"<?php if ($detail->FinishType == 'Gloss Lamination') {
                                echo 'selected';
                            } ?>>Gloss Lamination </option>

                            <option value="Matt Lamination"<?php if ($detail->FinishType == 'Matt Lamination') {
                                echo 'selected';
                            } ?>>Matt Lamination </option>

                            <option value="Gloss Varnish"<?php if ($detail->FinishType == 'Gloss Varnish') {
                                echo 'selected';
                            } ?>>Gloss Varnish </option>

                            <option value="High Gloss Varnish"<?php if ($detail->FinishType == 'High Gloss Varnish') {
                                echo 'selected';
                            } ?>>High Gloss Varnish (Not Over-Printable) </option>

                            <option value="Matt Varnish"<?php if ($detail->FinishType == 'Matt Varnish') {
                                echo 'selected';
                            } ?>>Matt Varnish </option>

                            </select>
                            <i></i>
                        </label>
                          </span>
                                                                <?php } ?>
                                                                <br/>

                                                                <br/>

                                                                <?php if ($permissions['qty'] == 1) { ?>
                                                                    <span>
                            <button id="artworki_for_order<?= $key ?>"
                                  onclick="addToCart('<?= $detail->ManufactureID ?>','<?= $detail->SerialNumber ?>','<?= $detail->Printing ?>','<?= $detail->ProductID ?>','<?= $detail->OrderNumber ?>','<?= $product['ProductBrand'] ?>','order_detail_page',<?= $key ?>)"
                                  type="button"
                                  class="m-20 btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork"
                                  data-toggle="modal" data-target=".bs-example-modal-lga"> <i class="fa fa-cloud-upload"
                                                                                              aria-hidden="true"></i>&nbsp; View Artwork Spec </button>
                            </span>   
                            

                            <span style="margin-left: 10px;">

                                <a id="edit_order_line" href="<?php echo main_url.'order_quotation/order/edit_emb_options/order_detail/'.$detail->OrderNumber.'/'.$detail->SerialNumber; ?>" class="m-20 btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork" >&nbsp; Embellishment </a>

                            </span>
                                                                <? }
                                                                } ?>
                                                                <input type="hidden" id="seril<?= $key ?>"
                                                                       value="<?= $detail->SerialNumber ?>">
                                                                <input type="hidden" id="pproduct<?= $key ?>"
                                                                       value="<?= $detail->ProductID ?>">
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <?php
                                                            if (!preg_match("/Roll Labels/i", $detail->ProductBrand)) {
                                                                ?>
                                                                <?= $symbol ?>5.32
                                                                <br>
                                                                Per Design
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td align="center">

                                                            <?= $detail->Print_Qty . ' ' . $des_gn ?> <br>
                                                            <?php if ($order->OrderStatus != "7") { ?>

                                                                <input type="text" id="design<?= $key ?>"
                                                                       class="text-center form-control input-number text-center allownumeric"
                                                                       readonly value="<?= $detail->Print_Qty ?>">
                                                            <?php } ?>


                                                        </td>


                                                        <td align="center"><? echo $symbol . (number_format($detail->Print_Total * $order->exchange_rate, 2, '.', '')); ?></td>
                                                        <td></td>
                                                    </tr>

                                                    <?php
                                                    if (preg_match("/Roll Labels/i", $detail->ProductBrand) && $order->OrderStatus != 7) {
                                                        include(APPPATH . 'views/order_quotation/order_detail/pp_line.php');
                                                        $totalPrice += $orderDetail->odp_price;
                                                    }
                                                    ?>

                                                <?php } elseif ($detail->Printing == 'Y' && $detail->regmark == 'Y') { ?>
                                                    <tr class="<?= $clr_class ?>">
                                                        <td></td>
                                                        <td><span style="float:left; margin-left:10px; padding:2px;"> <a
                                                                        href="https://www.aalabels.com/theme/integrated_attach/<?= $this->home_model->getdiecode($detail->ManufactureID) ?>_rev.pdf"
                                                                        target="_blank"> <img id="prod_image"
                                                                                              src="http://gtserver/newlabels//theme/site/images/pdf.png"
                                                                                              width="30" height=""> </a>
                        <p class="ellipsis"> <small>Rolls:</small> <small>
                          <?= $detail->Quantity ?>
                          </small><br>
                          <small>Labels:</small> <small>
                          <?= $detail->labels ?>
                          </small> </p>
                        </span></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                <?php }
                                            }
                                        } else {
                                            if (empty($detail->labels) || $detail->labels == 0) {
                                                $unit_price = @number_format($detail->Price / $detail->labels, 3, '.', '');
                                            } else {
                                                $unit_price = $detail->labels;
                                            }
                                            ?>
                                            <tr class="noneditable <?= $clr_class ?>">
                                                <td class="text-center">
                                                    <strong><?php echo $detail->ManufactureID ?></strong></td>
                                                <td>
                                                    <!--<strong>
                        <?= $detail->pn ?>
                        </strong>-->

                                                    
                                                    <?if($detail->ManufactureID == 'SCO1') {?>
                                                    
                                                                      <?php   $carRes = $this->user_model->getCartOrderData($detail->SerialNumber);
                                                     
                                                     
                                                      
                                                                    $mm = '';
                                                                    if($carRes[0]->height != null) {
                                                                    $mm=' x';
                                                                    }
													
                                                                    if($carRes[0]->shape!="Circle"){
                                                                         $carRes[0]->height = ($carRes[0]->height!=null)?($carRes[0]->height):($carRes[0]->width); 
                                                                        $mm=' x';
                                                                } 
                                                     ?>
                                                        
                                                         <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?>|
                                                         <b>Format: </b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?>|
                                                         <b>Size: </b>
                                                         <?= (isset($carRes[0])) ? $carRes[0]->width.'mm'.$mm  : '' .' x' ?>
                                                         <?= ((isset($carRes[0])) && $carRes[0]->height != null) ? (isset($carRes[0]) && $carRes[0]->width!="") ? $carRes[0]->width : '' : ($carRes[0]->height!="" && $carRes[0]->height!="NULL") ? $carRes[0]->height.'mm': '' ?>|
													 
                                                         <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?>|
                                                         <b>Across: </b><?= (isset($carRes[0])) ? $carRes[0]->across : '' ?>|
                                                         <b>Around: </b><?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
													
                                                        <?php if(($carRes[0]->shape != 'Circle') && ($carRes[0]->shape !='Oval')){?>
                                                            |<b>Corner Radius: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
                                                        <?php } ?>
                                                            |<b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>
                
                                                            |<b>TempCode: </b><?= (isset($carRes[0])) ? $carRes[0]->tempcode : '' ?>
                                                            
                                                            <?php } else{?>
                                                            
                                                            
                                                            <?=$detail->ProductName . ' ' . $this->quoteModel->txt_for_plain_labels($order->Label); 
                                                    ?>
                                                            <?php } ?>



                                                    <? $files = $this->quoteModel->get_integrated_attachments($detail->SerialNumber);
                                                    if (count($files) > 0) { ?>

                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <? foreach ($files as $row) { ?>
                                                                        <span style="float:left; margin-left:10px; padding:2px;"> <a
                                                                                    href="https://www.aalabels.com/theme/integrated_attach/<?= $row->file ?>"
                                                                                    target="_blank">
                                   <?
                                   if ($detail->source == 'flash' || $row->source == 'plain') {
                                       ?>
                                       <img width="30" height="" id="prod_image"
                                            src="https://www.aalabels.com/designer/media/thumb/<?= $row->Thumb ?>"/>
                                   <? } else if (preg_match('/.pdf/is', $row->file)) { ?>
                                       <img width="30" height="" id="prod_image"
                                            src="https://www.aalabels.com/theme/site/images/pdf.png"/>
                                   <? } else { ?>
                                       <img width="30" height="" id="prod_image"
                                            src="https://www.aalabels.com/theme/integrated_attach/<?= $row->file ?>"/>
                                   <? } ?>
                                   </a>

                                   <p class="ellipsis">
                                     <? if (preg_match("/Roll Labels/i", $detail->ProductBrand)) {
                                         $type = 'Rolls';
                                     } else {
                                         $type = 'Sheets';
                                     } ?>
                                       <? if ($row->qty > 0) { ?>
                                           <small>
                                       <?= $type ?>
                                       :</small> <small>
                                     <?= $row->qty ?>
                                     </small><br/>
                                       <? } ?>
                                       <? if ($row->labels > 0) { ?>
                                           <small>Labels:</small> <small>
                                     <?= $row->labels ?>
                                     </small>
                                       <? } ?>
                                   </p>
                                 </span>
                                                                    <? } ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    <? } ?>


                                                </td>


                                                <?php if ($detail->ManufactureID == 'SCO1') { ?>
                                                    <td class="text-center"><?= $detail->Quantity ?></td>
                                                <?php } else { ?>

                                                    <td class="text-center">
                                                        <?php if ($detail->ProductID == '0') { ?>
                                                            --
                                                        <?php } else { ?>
                                                            <?= $symbol ?><?= @number_format(($detail->Price / $detail->labels) * $exchange_rate, 3, '.', '') ?>
                                                        <?php } ?>
                                                        <br>

                                                        <?php if ($detail->ManufactureID != 'SCO1' && $detail->ProductID != '0') { ?>
                                                            Per Label
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>


                                                <td class="text-center">
                                                    <?php if ($detail->ManufactureID != 'SCO1' && $detail->ProductID != '0') { ?>
                                                        <?= $detail->Quantity . ' ' . $format ?><br>

                                                        <?php if ($detail->sample == 'Sample') { ?>
                                                            <?php if ($digitalCheck != 'roll') { ?>
                                                                <?= $detail->LabelsPerSheet; ?><?php echo ($detail->LabelsPerSheet > 0) ? "Labels" : "Label" ?>
                                                            <?php } ?>

                                                        <?php } else { ?>

                                                            <?php if (preg_match("/Integrated Labels/i", $detail->ProductBrand)) { ?>
                                                                <?= $detail->Quantity; ?><?php echo ($detail->Quantity > 0) ? "Labels" : "Label" ?>
                                                            <?php } else { ?>
                                                                <?= $detail->labels; ?><?php echo ($detail->labels > 0) ? "Labels" : "Label" ?>
                                                            <?php } ?>

                                                        <?php } ?>

                                                    <?php } else { ?>
                                                        <?= $detail->Quantity; ?><br>
                                                    <?php } ?>
                                                </td>

                                                <td class="text-center"><?= $symbol ?><?= number_format($detail->Price * $exchange_rate, 2) ?></td>
                                                <td style="text-align: center;"><i class="fa fa-plus bt-plus"
                                                                                   id="update<?= $key ?>"
                                                                                   onclick="noteForOrder(<?= $key ?>,'<?= $detail->OrderNumber ?>',<?= $detail->SerialNumber ?>)"></i>
                                                </td>
                                            </tr>

                                            <?php if ($detail->ManufactureID == 'SCO1' && $detail->Linescompleted == 0) {

                                                $carRes = $this->user_model->getCartOrderData($detail->SerialNumber); ?>
                                                <?php
                                                $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
                                                $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                                                foreach ($assoc as $rowp) {
                                                    ?>
                                                    <? $materialprice = ((float)$rowp->plainprice + (float)$rowp->printprice); ?>
                                                    <? $materialpriceinc = $materialprice * 1.2; ?>
                                                    <? if ($carRes[0]->format == 'Roll') {
                                                        $format = ($rowp->qty > 1) ? 'Rolls' : 'Roll';
                                                    } ?>
                                                    <?php $sho = '';
                                                    if ($carRes[0]->format == 'Roll') {
                                                        $sho = $rowp->rolllabels;
                                                    } else {
                                                        $sho = ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate);
                                                    } ?>


                                                    <tr class="<?= $clr_class ?>">
                                                        <td class="text-center labels-form"><?= $rowp->material ?></td>
                                                        <td><i class="mdi "></i>
                                                            <?= $this->user_model->get_mat_name($rowp->material); ?>
                                                        </td>
                                                        <td class="text-center"
                                                            id="labels0"><?= $symbol ?><?= @number_format(($materialprice / $sho) * $exchange_rate, 3) ?></td>
                                                        <td class="text-center">
                                                            <?= $rowp->qty; ?> <?php echo ucfirst($format); ?> <br>
                                                            <? if ($scorecord['format'] == 'Roll') {
                                                                echo $rowp->rolllabels;
                                                            } else {
                                                                echo(($scorecord['across'] * $scorecord['around']) * $rowp->qty);
                                                            }; ?> labels
                                                        </td>
                                                        <td class="text-center"><?= $symbol ?>
                                                            <? echo number_format($materialprice * $exchange_rate, 2); ?>
                                                            <?php $totalPrice += $materialprice ?></td>
                                                        <td></td>
                                                    </tr>


                                                    <?php if (($rowp->labeltype == 'printed' && $carRes[0]->format != 'Roll') || ($carRes[0]->format == 'Roll')) { ?>

                                                        <?php //echo '<pre>'; print_r($assoc);  ?>

                                                        <tr>
                                                            <td class="invoicetable_tabel_border"></td>
                                                            <td class="invoicetable_tabel_border">
                                                                <i class="mdi mdi-check"></i><span>
    <?php

    if ($rowp->printing == "Mono") { ?>
        <?php $rowp->printing = "Black Only"; ?>
    <?php } ?>

    <?= $rowp->printing ?>
    </span>
                                                                <?php if ($rowp->designs > 0) { ?>
                                                                    <i class="mdi mdi-check"></i> <span>
    <?php $des = ($assoc[0]->designs > 1) ? "Designs" : "Design"; ?>
    <?= $rowp->designs . ' ' . $des ?>
    </span>
                                                                <?php } ?>
                                                                <?php

                                                                if ($carRes[0]->format == 'Roll') { ?>
                                                                    <span class="invoice-bold">
      <strong style="font-size:12px;">Wound:</strong>
      <?php if (!empty($rowp->wound)) echo $rowp->wound; ?>
    </span>
                                                                    <span class="invoice-bold">
      <strong style="font-size:12px;">Orientation:</strong>
      <?php if (!empty($rowp->core)) echo $rowp->core; ?>
    </span>
    <?php if($detail->FinishType!=""){ ?>
                                                                    <span class="invoice-bold">
      <strong style="font-size:12px;">Finish:</strong>
      <?= $rowp->finish ?>
    </span>

                                                                <?php } } ?>

                                                            </td>


                                                            <?php
                                                            $word = "AAQ";
                                                            if (strpos($QuoteNumber['QuotationNumber'], $word) !== false) { ?>
                                                                <td class="text-center invoicetable_tabel_border"></td>
                                                            <?php } ?>

                                                            <td class="text-center invoicetable_tabel_border"
                                                                align="center">
                                                                <?php
                                                                if ($carRes[0]->format != 'Roll') {
                                                                    ?>
                                                                    <?= $symbol ?>5.32
                                                                    <br>
                                                                    Per Design
                                                                    <?php
                                                                }
                                                                ?>

                                                            </td>

                                                            <td class="text-center invoicetable_tabel_border"
                                                                align="center"> <?php
                                                                if ($detail->regmark != 'Y' && $carRes[0]->format != 'Roll') {
                                                                    $des = ($rowp->designs > 1) ? "Designs" : "Design";
                                                                    echo $rowp->designs . ' ' . $des;

                                                                    ?>

                                                                <? } ?></td>
                                                            <td class="text-center invoicetable_tabel_border"
                                                                align="center"><?= $symbol ?><?= number_format(($detail->Print_Total * $exchange_rate), 2) ?></td>
                                                            <td></td>

                                                        </tr>
                                                    <?php } ?>

                                                <?php } ?>
                                            <?php } ?>


                                            <tr id="order_note_line<?= $key ?>" <?php if ($detail->Product_detail == null) { ?> style="display: none;" <?php } ?>
                                                class="<?= $clr_class ?>">
                                                <td><b style="color:red;font-size:12px;">Product Note</b></td>
                                                <td><input type="text" required id="note_for_od<?= $key ?>"
                                                           value="<?= $detail->Product_detail ?>"
                                                           class="form-control input-number  allownumeric"></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center"></td>
                                                <td class="padding-6 icon-tablee">
                                                    <i class="fa fa-trash-o bt-delete"
                                                       onclick="deleteNoteForOrder(<?= $detail->SerialNumber ?>)"> </i>
                                                    <i class="fa fa-floppy-o bt-save"
                                                       onclick="insertNoteForOrder(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i>
                                                </td>
                                            </tr>


                                            <? $detail_view = @$this->quotationModal->check_product_extra_detail($detail->ManufactureID);
                                            if ($detail_view['prompt'] == 'yes') {
                                                ?>
                                                <tr class="<?= $clr_class ?>">
                                                    <td class="text-center"><b style="color:green;font-size:12px;">Product
                                                            Note</b></td>
                                                    <td><b style="color:green;font-size:12px;">
                                                            <?= $detail_view['detail'] ?>
                                                        </b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <? } ?>

                                            <?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') { ?>
                                                <tr class="noneditable <?= $clr_class ?>">
                                                    <td class="text-center"></td>
                                                    <td><i class="mdi mdi-check"></i><span>
                                                        <?php if ($detail->Print_Type == "Fullcolour") { ?>
                                                            <?php $detail->Print_Type = "4 Colour Digital Process"; ?>
                                                        <?php } ?>

                                                        <?php if ($detail->Print_Type == "Mono") { ?>
                                                            <?php $detail->Print_Type = "Monochrome - Black Only"; ?>
                                                        <?php } ?>

                                                        <?= $detail->Print_Type ?>
                                                        </span>
                                                        <?php if ($detail->Print_Qty > 0) { ?>
                                                            <i class="mdi mdi-check"></i> <span>
                                                            <?= $detail->Print_Qty . '  Design' ?>
                                                            </span>
                                                        <?php } ?>

                                                        <?php if ($digitalCheck == 'roll') { ?>
                                                            <span class="invoice-bold"> <strong
                                                                        style="font-size:12px;;">Wound:</strong><?= $detail->Wound ?></span>
                                                            <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Orientation:</strong>
                                                            <?= $detail->Orientation ?>
                                                            </span> 
                                                            <?php if($detail->FinishType!=""){ ?>
                                                            <span class="invoice-bold"><strong style="font-size:12px;;">Finish :</strong>
                                                            <?= $detail->FinishType ?>
                                                            </span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>


                                                    <td align="center">
                                                        <?php
                                                        if (!preg_match("/Roll Labels/i", $detail->ProductBrand)) {
                                                            ?>
                                                            <?= $symbol ?>5.32
                                                            <br>
                                                            Per Design
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $detail->Print_Qty . ' ' . $des_gn ?> <br>
                                                        <?php if ($digitalCheck == "A4") { ?>
                                                            (<?= $detail->Free . ' ' . $des_free ?> Free)
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if (!preg_match("/Roll Labels/i", $detail->ProductBrand) && $detail->FinishTypePricePrintedLabels != '' && $detail->total_emb_cost != 0){
                                                            echo $symbol . (number_format(($detail->Print_Total * $order->exchange_rate)-$detail->total_emb_cost, 2, '.', ''));
                                                        } else {
                                                            echo $symbol . (number_format($detail->Print_Total * $order->exchange_rate, 2, '.', ''));
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center"></td>
                                                </tr>

                                                <?php
                                                if ($orderDetail->odp_proof == "Y") {
                                                    include(APPPATH . 'views/order_quotation/order_detail/pp_line_no_edit.php');
                                                    $totalPrice += $orderDetail->odp_price;
                                                }
                                                ?>


                                            <?php } elseif ($detail->Printing == 'Y' && $detail->regmark == 'Y') { ?>
                                                <tr class="<?= $clr_class ?>">
                                                    <td></td>
                                                    <td><b>Printing Service (Black Registration Mark on Reverse)</b>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }


                                            //Labels Embelishment Conditions Start

                                            if ($detail->Printing == 'Y' && $detail->FinishTypePricePrintedLabels != '') { 

                                               
                                                ?>

                                                <tr>
                                                    <td></td>
                                                    <td colspan="5"><b> Finish </b></td>
                                                </tr>

                                                <?php 
                                                $lem_options = json_decode($detail->FinishTypePricePrintedLabels);
                                                $parent_title = '';
                                               
                                               /* echo count($lem_options)."------<br>";
                                                echo "<pre>";
                                                print_r($lem_options);
                                                echo "</pre>";*/

                                                $index = 0;
                                                $parsed_child_title = '';
                                                $parsed_title_price = 0;
                                                $plate_cost1 = 0;
                                                foreach ($lem_options as $lem_option) {

                                                    $parsed_title = ucwords(str_replace("_", " ", $lem_option->finish_parsed_title));
                                                    $parsed_parent_title = $lem_option->parsed_parent_title;
                                                    $parent_id = $lem_option->parent_id;
                                                    $use_old_plate = $lem_option->use_old_plate;

                                                    ($use_old_plate == 1 ?  $plate_cost = 0 : $plate_cost = $lem_option->plate_cost);

                                                    if ($parent_id == 1) { //For Lamination and varnish
                                                        $plate_cost1 += $plate_cost;
                                                        $parsed_child_title .= $parsed_title.", ";
                                                        $parsed_title_price += $lem_option->finish_price; 


                                                        if ($parsed_parent_title != $lem_options[$index+1]->parsed_parent_title || ($index+1) == count($lem_options)) {
                                                            $parsed_parent_title = ucwords(str_replace("_", " ", $parsed_parent_title));
                                                            ?>

                                                            <tr>
                                                                <td></td>
                                                                <td><?= "<b>".$parsed_parent_title." : </b>".$parsed_child_title?></td>
                                                                <td class="text-center">
                                                                    <?= $symbol." ".number_format((($parsed_title_price+$plate_cost1) / $detail->labels) * $exchange_rate, 2, '.', '') ?>
                                                                    <br>
                                                                    Per Label
                                                                </td>
                                                                <td></td>
                                                                <td class="text-center"><?= $symbol." ".number_format(( ($parsed_title_price+$plate_cost1) * $exchange_rate), 2) ?></td>
                                                                <td></td>
                                                            </tr>

                                                        <?php
                                                        }

                                                    } else if($parent_id != 1 && $parent_id != 5) { //For other than varnish and sequen
                                                        $parsed_parent_title = ucwords(str_replace("_", " ", $parsed_parent_title)); 
                                                        $parsed_child_title = $parsed_title;
                                                        $parsed_title_price = $lem_option->finish_price+$plate_cost;
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><?= "<b>".$parsed_parent_title." : </b>".$parsed_child_title?></td>
                                                            <td class="text-center">
                                                                <?= $symbol." ".number_format(($parsed_title_price / $detail->labels) * $exchange_rate, 2, '.', '') ?>
                                                                <br>
                                                                Per Label
                                                            </td>
                                                            <td></td>
                                                            <td class="text-center"><?= $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2) ?></td>
                                                            <td></td>
                                                        </tr>

                                                    <?php } else { //For Sequential Data 
                                                        $parsed_parent_title = ucwords(str_replace("_", " ", $parsed_parent_title)); 
                                                        ?>

                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <?php
                                                                    echo "<b>".$parsed_parent_title." : </b>";
                                                                    
                                                                    if( isset($detail->sequential_and_variable_data) && $detail->sequential_and_variable_data != '' ) {
                                                                      $json_data = json_decode($detail->sequential_and_variable_data);
                                                                      if( gettype($json_data) == "array" ) {
                                                                          foreach ($json_data as $key => $eachData) {
                                                                            if( $key == 0 ) {
                                                                                echo "<b>(Start #: </b>".$eachData->starting_data."<b> -  End #: </b>".$eachData->ending_data."<b>)</b>";
                                                                            } else {
                                                                                echo "<b>,&nbsp; (Start #: </b>".$eachData->starting_data."<b> -  End #: </b>".$eachData->ending_data."<b>)</b>&nbsp;&nbsp;";
                                                                            }
                                                                          }
                                                                      }
                                                                    }

                                                                    $parsed_title_price = count($json_data) * sequential_price;
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $symbol." ".number_format(($parsed_title_price / $detail->labels) * $exchange_rate, 2, '.', '') ?>
                                                                <br>
                                                                Per Label
                                                            </td>
                                                            <td></td>
                                                            <td class="text-center"><?= $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2) ?></td>
                                                            <td></td>
                                                        </tr>

                                                   <?php  }
                                                   $index++;
                                                }
                                            }
                                        }
                                        $count++;
                                    } ?>
                                    <tr style="display: none" id="tr_for_nw_line">
                                        <td><input class="form-control input-number text-center"
                                                   type="text" required id="new_line_man"></td>
                                        <td><textarea class="form-control input-number text-center "
                                                      id="new_line_des" required style="height: 35px;"></textarea></td>
                                        <td><input class="form-control input-number text-center allownumeric"
                                                   type="number" required id="new_line_unit_price"
                                                   placeholder="unit price"></td>
                                        <td><input class="form-control input-number text-center allownumeric"
                                                   type="number" required id="new_line_qty" placeholder="quanity"></td>
                                        <td></td>
                                        <td class="padding-6 icon-tablee"><i class="fa fa-floppy-o bt-save"
                                                                             onclick="orderNewLine('<?= $order->OrderNumber ?>',<?= $order->UserID ?>)"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="row">
                                <div class="col-md-6 pull-left">
                                    <?
                                    if ($order->OrderStatus == 2 || $order->OrderStatus == 32 || $order->OrderStatus == 55 || $order->OrderStatus == 6 || $order->OrderStatus == 78) {
                                        ?>


                                        <?
                                        if (($order->OrderStatus == 55 || $order->OrderStatus == 6 || $order->OrderStatus == 78) && ($order->picking_status != 1)) {
                                            ?>
                                            <span><button type="button" onclick="getSearch()"
                                                          class="btn btn-info waves-light waves-effect addnewline">Add New Product</button>
</span>

                                        <? } ?>

                                        <?php
                                        if ($order->editing == 'no') { ?>
                                            <span>
<button type="button" onclick="editOrderLines('yes','<?= $order->OrderID ?>')"
        class="btn btn-success waves-light waves-effect">Edit Order</button></span>
                                        <?php } else { ?>
                                            <span>
<button type="button" onclick="editOrderLines('no','<?= $order->OrderID ?>')"
        class="btn btn-success waves-light waves-effect">Finish Edit Order</button>
</span>
                                        <?php } ?>


                                    <? } ?>

                                </div>

                                <?php //$order->vat_exempt='yes'; ?>
                                <div class="col-md-6 pull-right">
                                    <table class="table table-bordered quote-price-details table-striped">
                                        <tr>
                                            <td>Sub Total:</td>
                                            <?php $orderTotal ?>
                                            <?php if ($order->vat_exempt == 'yes') {
                                                $totalPrice = $totalPrice;
                                                $totalSubs = $totalPrice;
                                                $grandTotal = $totalPrice;
                                            } else {
                                                $totalSubs = $totalPrice;
                                                //$totalPrice = $totalPrice * vat_rate;
                                                $grandTotal = $totalPrice;
                                            } ?>
                                            <td><? echo $symbol . (number_format($totalSubs * $order->exchange_rate, 2, '.', '')); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Total:</td>
                                            <td>
                                                <?

                                                $OrderShippingAmount = $order->OrderShippingAmount;

                                                // if($order->PaymentMethods != 'Sample Order')
                                                // if($OrderShippingAmount > 0)
                                                // {
                                                if (($order->OrderDeliveryCourier == 'DPD') && ($order->OrderDeliveryCourierCustomer == 'Parcelforce')) {
                                                    $OrderShippingAmount = (($order->OrderShippingAmount) + 1);
                                                } else if (($order->OrderDeliveryCourier == 'Parcelforce') && ($order->OrderDeliveryCourierCustomer == 'DPD')) {
                                                    $OrderShippingAmount = (($order->OrderShippingAmount) - 1);
                                                } else {
                                                    $OrderShippingAmount = ($order->OrderShippingAmount);
                                                }
                                                // }


                                                echo $symbol . (number_format(($order->OrderShippingAmount / vat_rate) * $order->exchange_rate, 2, '.', ''));
                                                $totalPrice = $totalPrice + ($order->OrderShippingAmount / vat_rate) * $order->exchange_rate;


                                                ?></td>
                                        </tr>

                                        <?php $grandTotal = $totalSubs + ($OrderShippingAmount / vat_rate); ?>



                                        <? if ($order->PaymentMethods == "Sample Order") { ?>

                                            <tr>
                                                <td>Choose Delivery Option:</td>
                                                <td><? echo "Delivery Service: Free Delivery 3 –5 Working Days"; ?> </td>
                                            </tr>


                                        <? } else { ?>

                                            <tr>
                                                <td>Choose Delivery Option:</td>
                                                <td><?
                                                    // AA35 STARTS
                                                        // FOR FREE DELIVERY DROPDOWN SHOW, WHEN ORDER INC VAT PRICE IS HIGHER OR EQUAL TO 25.00 STARTS
                                                            $order->inctotal_for_page = $grandTotal * 1.2;
                                                        // FOR FREE DELIVERY DROPDOWN SHOW, WHEN ORDER INC VAT PRICE IS HIGHER OR EQUAL TO 25.00 ENDS
                                                    // AA35 ENDS
                                                    $order->extotal_for_page = $totalPrice; ?>
                                                    <?php $this->load->view('order_quotation/order_detail/shiping', $order); ?></td>
                                            </tr>

                                        <? } ?>






                                        <?php
                                        if ($order->voucherOfferd == 'Yes') {
                                            $discount_applied_in = $order->voucherDiscount;
                                            $discount_applied_ex = $order->voucherDiscount / 1.2;
                                        } else {
                                            $discount_applied_in = 0.00;
                                            $discount_applied_ex = 0.00;
                                        }
                                        ?>
                                        <tr>
                                            <td>Discount:</td>
                                            <td>
                                                <?php $discount = $discount_applied_in; ?>
                                                <? echo $symbol . (number_format($discount_applied_ex * $order->exchange_rate, 2, '.', '')); ?>
                                                
                                                <?php $uTypeID = $this->session->userdata('UserTypeID');
                                                      $uID = $this->session->userdata('UserID');
                                                ?>

                                            <?php if($uTypeID==50 || $uID==653722){ ?>
                                                <? if ($order->voucherOfferd == 'Yes') { ?>
                                                    <button class="btn btn-success waves-light waves-effect col-md-3"
                                                            onclick="applydiscount('<?= $order->OrderNumber ?>','remove')"
                                                            style="margin-left: 8px;">Remove Discount
                                                    </button>

                                                <? } else { ?>
                                                    <a onclick="$('#discounterdiv').show();$('#discountera').hide();"
                                                       id="discountera"
                                                       style="color: red;margin-left: 5%;text-decoration: underline;">Want to Apply Discount ? CLICK HERE</a>

                                                    <div id="discounterdiv" style="display:none">
                                                        <input type="number"
                                                               style="height: 35px;border: none;border: 1px solid #00b6f0;border-radius: 3px;width: 50px;margin-left: 50px;margin-right: 5px;"
                                                               class="numeric" id="discountvalue">%
                                                        <button class="btn btn-danger waves-light waves-effect col-md-3"
                                                                onclick="applydiscount('<?= $order->OrderNumber ?>','add')"
                                                                style="margin-left: 8px;">Apply Discount
                                                        </button>
                                                    </div>

                                                <? } }?>
                                                
                                                

                                            </td>
                                        </tr>


                                        <?
                                       
                                        $subttotal = number_format(($totalSubs - $discount_applied_ex) + ($order->OrderShippingAmount / 1.2), 2, '.', '');
                                        
                                        $totalPrices = $subttotal;
                                        $grandTotal = $totalPrices * 1.2;
                                        $vatvalue = $grandTotal - $totalPrices;

                                        ?>
                                        <tr>
                                            <td>Sub Total:</td>
                                            <td><? echo $symbol . (number_format($subttotal * $order->exchange_rate, 2, '.', '')); ?></td>
                                        </tr>


                                        <? if ($order->vat_exempt == 'yes') {
                                            $grandTotal = $totalPrices;

                                            ?>
                                            <tr>
                                                <td>VAT Exempt:</td>
                                                <td>
                                                    - <? echo $symbol . (number_format($vatvalue * $order->exchange_rate, 2, '.', '')); ?>
                                                    <div class="col-md-12">
                                                        <a id="removevat_validator" type="button"
                                                           style="text-decoration: underline;color:red">Remove Vat
                                                            Exemption</a>
                                                    </div>
                                                </td>
                                            </tr>

                                        <? } else { ?>

                                            <tr>
                                                <td>VAT @20%:</td>
                                                <td><span><? echo $symbol . (number_format($vatvalue * $order->exchange_rate, 2, '.', '')); ?><span>
                                                <div class="row" style="margin: 10px 0px;">

                                                          <div class="col-md-3 no-padding">
                                                            <div class="input-group"><span id="vat_cc"
                                                                                           class="input-group-addon">&nbsp;</span>
                                                              <input type="text" id="ordervatnumber"
                                                                     name="ordervatnumber"
                                                                     placeholder="Enter VAT number" class="form-control"
                                                                     style="padding: 9px;">
                                                            </div>
                                                          </div>

                                                          <div class="col-md-2">
                                                            <button class="btn btn-secondary waves-light waves-effect"
                                                                    id="ordervat_validator" type="button"
                                                                    style="padding: 6px 25px;"> Verify </button>
                                                          </div>
                                                          </div>
                                                </td>
                                            </tr>

                                        <?php } ?>


                                        <tr>
                                            <td>Grand Total:</td>
                                            <td><?php
                                                $finalAmount = floatval($grandTotal);
                                                echo $symbol . (number_format($grandTotal * $order->exchange_rate, 2, '.', ''));
                                                ?>
                                                <input type="hidden" id="gtTotal"
                                                       value="<?php echo(round($grandTotal, 2)) ?>"></td>
                                        </tr>


                                        <? if ($order->PaymentMethods != "purchaseOrder" && $order->PaymentMethods != "PayPal eCheque") {

                                            $total_amount_paid = floatval($paymentReceived);
                                            $payable_amount = round($finalAmount - $total_amount_paid, 2);
                                            $amount_refund = round($total_amount_paid - $finalAmount);


                                            if ($total_amount_paid < $finalAmount && $payable_amount > 0) { ?>

                                                <tr>
                                                    <td>Amount Paid:</td>
                                                    <td><? echo $symbol . (number_format($paymentReceived * $order->exchange_rate, 2, '.', '')); ?>
                                                        <input type="hidden" id="amount_paid"
                                                               value="<?= $paymentReceived ?>"></td>
                                                </tr>
                                                <input type="hidden" id="grand_amount" value="<?= $grandTotal ?>">

                                                <tr>
                                                    <td>Amount Pending:</td>
                                                    <td class="highlighted-price labels-form"><b>
                                                            <? $myfinalAmount = $payable_amount;
                                                            echo $symbol . (number_format($payable_amount * $order->exchange_rate, 2, '.', ''));
                                                            ?>
                                                        </b></td>
                                                </tr>
                                                <tr>
                                                    <td>Pending Payment Procedure:</td>
                                                    <td class="highlighted-price labels-form"><label class="select">
                                                            <select onchange="get_payment(this.value,'<?= $order->OrderNumber ?>')">
                                                                <option value="1">Select Payment Method</option>
                                                                <option value="worldpay">Pay by Creditcard</option>
                                                                <? $UserTypeID = $this->session->userdata('UserTypeID');
                                                                if ($UserTypeID == 50) { ?>
                                                                    <option value="paypalmanual">Pay by Paypal</option>
                                                                    <option value="bacscheque">Pay by BACS/Cheque
                                                                    </option>
                                                                <? } ?>
                                                            </select>
                                                            <i></i> </label></td>
                                                </tr>

                                            <? } else if ($total_amount_paid > $finalAmount && $amount_refund != '-0' && $amount_refund != '0') {
                                                $amount_refund = $total_amount_paid - $finalAmount;
                                                $total_amount_refund = $this->settingmodel->payment_refunded($order->OrderNumber);
                                                $remainamount_refund = trim($amount_refund) - trim($total_amount_refund);

                                                if (trim($remainamount_refund) > 0) { ?>
                                                    <tr>
                                                        <td>Refund Amount:</td>
                                                        <td class="highlighted-price"><?php echo $symbol . "" . (number_format($remainamount_refund * $order->exchange_rate, 2, '.', '')); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="labels-form"><label class="select">
                                                                <select id="refundtype" class="form-control">
                                                                    <option value="1">Select Refund Method</option>
                                                                    <option value="worldpay">Pay by Creditcard</option>
                                                                    <option value="paypal">Pay by Paypal</option>
                                                                    <option value="bacscheque">Pay by BACS/Cheque
                                                                    </option>
                                                                </select>
                                                                <i></i> </label>
                                                        </td>
                                                        <? $refunduser = $this->session->userdata('UserTypeID');
                                                        $refunduser = ($refunduser == 50) ? "yes" : "no";
                                                        ?>
                                                        <td class="highlighted-price">
                                                            <button style="background-color:green;color:white"
                                                                    type="button"
                                                                    onclick="refundamount('<?= $order->OrderNumber ?>',<?= $remainamount_refund ?>,'<?= $refunduser ?>');"
                                                                    class="btn btn-info waves-light waves-effect">
                                                                Refund
                                                            </button>
                                                        </td>
                                                    </tr>

                                                <? } ?>


                                            <? } ?>


                                        <? } ?>


                                        <tr>
                                            <td>Print Order:</td>
                                            <td>
                                                <div class="checkbox checkbox-custom"> Hide Prices:
                                                    <input id="hide" class="hideprice" type="checkbox" name="hideprice">
                                                    <label for="hide"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <? $site = ($order->site == "" || $order->site == "en") ? "English" : "French"; ?>
                                        <tr>
                                            <td class="labels-form"><label class="select">
                                                    <select class="form-control" id="language">
                                                        <option value="en" <? if ($site == "English") { ?> selected="selected" <? } ?>>
                                                            English
                                                        </option>
                                                        <option value="fr" <? if ($site == "French") { ?> selected="selected" <? } ?>>
                                                            French
                                                        </option>
                                                    </select>
                                                    <i></i> </label></td>
                                            <td>
                                                <button type="button"
                                                        onclick="printingorderinvoice('<?= $order->OrderNumber ?>');"
                                                        class="btn btn-info waves-light waves-effect"> Print Invoice
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end row -->
        <!-- Label Finder Starts  -->
        <div id="order_detail_search" style="display:none;">
            <div class="" id="placeSearch"></div>
            <!-- end row -->
            <!-- Label Finder Ends  -->
            <!-- Products View Start  -->
            <div id="ajax_material_sorting" style="background-color: #ffffff !important;margin-bottom: 10px;"></div>
            <div id="order_detail_material" style="background-color: #ffffff !important;margin-bottom: 10px;"></div>
        </div>
        <!-- Products View End  -->
        <div class="row">
            <div class="col-md-6" style="display: flex;padding-left: 3px;">
                <div class="card m-b-30" style="width: 100%">
                    <div class="card-header card-heading-text-three"> <span class="pull-left heading-card-margin">Sale Operator Notes -
            <?= $order->OrderNumber ?>
            </span> <span class="pull-right">
            <button type="button" onclick="showNotePopup()" class="btn btn-primary waves-light waves-effect">Add New Note</button>
            </span></div>
                    <div class="card-body no-padding">
                        <table class="table table-bordered text-center table-striped">
                            <thead>
                            <tr>
                                <th>Note Date</th>
                                <th>Operator</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($notes as $key => $note) { ?>
                                <tr>
                                    <td><?= $note->noteDate ?></td>
                                    <td><?= $note->operator_id ?></td>
                                    <td><?= $note->noteTitle ?>
                                        <input type="hidden" id="note_title<?= $key ?>" value="<?= $note->noteTitle ?>">
                                    </td>
                                    <td><?= $note->noteText ?>
                                        <input type="hidden" id="note_des<?= $key ?>" value="<?= $note->noteText ?>">
                                    </td>
                                    <td>
                                        <button onclick="showUpdatePopup(<?= $key ?>,<?= $note->noteID ?>)"
                                                class="btn btn-default btn-number  add-line-btn fa-2x" type="button"><i
                                                    class="mdi mdi-pencil-box-outline"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pull-right" style=" display: flex;padding-right: 5px;">
                <div class="card m-b-30" style="width: 100%;">
                    <div class="card-header card-heading-text-three"> <span class="pull-left heading-card-margin">Order Logs -
            <?= $order->OrderNumber ?>
            </span> <span class="pull-right">
            <?php $logs = $this->settingmodel->get_orderEdit_logs($order->OrderNumber); ?>
            </span></div>
                    <div class="card-body no-padding">
                        <table class="table table-bordered text-center table-striped">
                            <thead>
                            <tr>
                                <th>Log Date</th>
                                <th>Operator Name</th>
                                <th>Messge</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($logs as $row) { ?>
                                <tr>
                                    <td><?= $row->log_date ?></td>
                                    <td><?= $row->operator_name ?></td>
                                    <? $msg = str_replace('amp;', '', $row->extra_info); ?>
                                    <? $msg = htmlentities($msg); ?>
                                    <td><?= $row->message ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-header card-heading-text-three"> <span class="pull-left heading-card-margin">Order Payment Logs Notes -
            <?= $order->OrderNumber ?>
            </span> <span class="pull-right">
            <?php $paylogs = $this->settingmodel->payments_log($order->OrderNumber); ?>
            </span></div>
                    <div class="card-body no-padding ">
                        <table class="table table-bordered text-center table-striped">
                            <thead>
                            <tr>
                                <th width="20%">Log Date/Time</th>
                                <th width="20%">Type</th>
                                <th width="20%">Operater</th>
                                <th width="20%">Amount</th>
                                <th width="40%">Payment Method</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (count($paylogs) > 0) {
                                foreach ($paylogs as $rowp) {
                                    $orderInfo = $this->user_model->OrderInfo($rowp->OrderNumber);
                                    $symbol = $this->home_model->get_currecy_symbol($orderInfo[0]->currency);

                                    ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> h : i  A</b>', ($rowp->time)); ?></td>
                                        <td><?= ($rowp->situation == "refund") ? "Refund" : "Received" ?></td>
                                        <td><?= $rowp->operator ?></td>
                                        <td>£ <?= number_format($rowp->payment, 2, '.', '') ?></td>
                                        <td><?= $rowp->type ?></td>
                                    </tr>
                                <? }
                            } else { ?>
                                <tr>
                                    <td colspan="5"> No Note(s) found against.</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</div>

<!-- PO Add Popup Start -->
<div class="modal fade bs-example-modal-md" id="po_modl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Add Purchase Order</h4>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <form class="labels-form" enctype="multipart/form-data"
                      action="<?= main_url ?>order_quotation/order/uploadPurchaseOrder" id="upload_po_form">
                    <div class="panel-body">
                        <input type="hidden" name="OrderNumber" value="<?= $order->OrderNumber ?>">
                        <input type="hidden" id="po_attachment" value="<?= $order->po_attachment ?>">
                        <div class="col-12 no-padding">
                            <div class="col-sm-12 ">
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input type="file" name="file_up" id="file_up" value="Aa" class="required"
                                           style="height: auto !important;">
                                </label>
                            </div>
                            <div class="col-sm-12 " style="padding: 1rem 0;">
                                <label class="input"><b>Order total:</b> <?php  echo $symbol . (number_format($grandTotal * $order->exchange_rate, 2, '.', '')) ?>
                                    <input type="hidden" placeholder="Value" name="po_value" id="or_tots"
                                           value="<?= (number_format($grandTotal * $order->exchange_rate, 2, '.', '')) ?>"
                                           required class="required">
                                </label>
                            </div>
                            <div class="col-sm-12">
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input type="text" placeholder="Value" name="po_value" id="po_value"
                                           value="<?= number_format($order->po_value, 2, '.', '') ?>" required
                                           class="required">
                                </label>
                            </div>
                        </div>
                        </br>
                        <div class="m-t-5 text-center"> <span class="m-t-10 m-r-3">
              <button type="button" class="btn btn-outline-info waves-light waves-effect m-l-10"
                      data-toggle="modal" data-target=".bs-example-modal-md"> CANCEL</button>
              <?
              $add_po = 'Add PO';
              if ($order->po_attachment != '') {
                  $add_po = 'Update PO'; ?>
                  <a class="btn btn-outline-dark waves-light waves-effect btn-countinue" style="    margin: 0px 10px;"
                     id="download_img" href="javascript:void(0);">Download PO</a>
              <? } ?>
              <button type="submit"
                      class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
              <?= $add_po ?>
              </button>
              </span></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- PO Add Popup Start End -->
<!-- end wrapper -->
<!-- Note Add Popup Start -->
<div class="modal fade bs-example-modal-md" id="add_note_popup" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Order Notes</h4>
                    <p class="timeline-detail text-center">Please enter the notes here.</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                    <style>
                        .custom-die-input {
                            width: 97% !important;
                            border: 1px solid #a3e8ff;
                            border-radius: 4px;
                            height: 33px;
                            color: #000000 !important;
                            margin-bottom: 4px;
                            font: 12px !important;
                        }

                        .blue-text-field {
                            border: 1px solid #a3e8ff !important;
                            width: 97%;
                        }

                        .m-r-3 {
                            margin-right: 3%;
                        }
                    </style>
                    <div class="col-12 no-padding">
                        <input type="hidden" id="current_note_id">
                        <div class="divstyle"><b class="label"></b>
                            <input type="text" name="die_title" id="die_title" placeholder="Enter Title Here"
                                   class=" custom-die-input">
                        </div>
                    </div>
                    <div class="col-12 no-padding">
            <textarea class="form-control blue-text-field" name="die_note" rows="5" id="die_note"
                      placeholder="Enter Description Here"></textarea>
                    </div>
                    <span class="m-t-t-10 pull-right m-r-3">
          <button id="current_note_id" type="button" data-dismiss="modal"
                  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Cancel</button>
          <button id="ad_nt" type="button" onclick="addNote()"
                  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1"
                  style="margin-right: 10px;">Add Note</button>
          <button id="up_nt" type="button" style="display: none;" onclick="updateNote()"
                  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1"
                  style="margin-right: 10px;">
          Update Note
          </button>
          </span></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Note Add Popup Start End -->
<!-- Compare Popup Start -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" id="compare_modal" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Label Layout</h4>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                    <div id="compare_modal_content"></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Compare Popup End -->
<? include(APPPATH . 'views/order_quotation/artwork/artwork_popup.php') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

    $(document).ready(function () {
        //art_pop_tb();
        //alert('sd');


        var amountPaid = parseInt($('#amount_paid').val(), 10);
        var grandAmout = parseInt($('#grand_amount').val(), 10);

        if (amountPaid == grandAmout) {
            $('#cr_py').hide();
            $('#zro_py').hide();
            $('#pr_py').hide();
        } else {
            $('#cr_py').show();
            $('#zro_py').show();
            $('#pr_py').show();
        }
    });


    function remove_4rm_stock(serial, ordernumber) {
        swal(
            "Are you sure to unlock this product, completed from stock and Adjust Stock?",
            {
                buttons: {
                    cancel: "No",
                    catch: {
                        text: "Yes",
                        value: "catch",
                    },
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        ).then((value) => {
            switch (value) {
                case "catch":
                    $("#dvLoading").css('display', 'block');
                    $.ajax({
                        type: "post",
                        url: "<?php echo main_url;?>order_quotation/Order/remove_from_stock",
                        data: {serial: serial, ordernumber: ordernumber},
                        success: function (data) {
                            $("#dvLoading").css('display', 'none');
                            window.location.reload(true);
                        }
                    });
            }
        });
    }


    function updateLabels(key, labelPerRoll) {
        var qty = parseInt($('#qty' + key).val(), 10);

        $('#label_for_orders' + key).val(qty * labelPerRoll);

    }

    function getShipingservic() {
        
        var ship_id = $("#c1").val();
        var ordernumber = '<?=$order->OrderNumber?>';
        var old_shipping = <?=$order->ShippingServiceID?>;
        var total = '<?=$order->inctotal_for_page?>';
        var deliveryCourier = $("#deliveryCourier option:selected").val();

        $('#dvLoading').show();
        $.ajax({
            type: "post",
            url: "<?php echo main_url;?>order_quotation/Order/getShipService",
            cache: false,
            data: {
                ship_id: ship_id,
                ordernumber: ordernumber,
                old_shipping: old_shipping,
                total: total,
                deliveryCourier: deliveryCourier
            },
            success: function (data) {
                $('#dvLoading').hide();
                 window.location.reload(true);
            }
        });
    }


    // AA21 STARTS
    function updateCourier() {
        $('#aa_loader').show();
        var ordernumber = '<?=$order->OrderNumber?>';
        var deliveryCourier = $("#deliveryCourier option:selected").val();

        $.ajax({
            type: "post",
            url: "<?php echo main_url;?>order_quotation/Order/updateOrderDetail",
            cache: false,
            data: {"ordernumber": ordernumber, "deliveryCourier": deliveryCourier},
            success: function (data) {
                $('#aa_loader').hide();
                window.location.reload(true);
            }
        });
    }

    // AA21 ENDS


    function get_payment(value, ordernumber) {
        if (value == 1) {
            return false;
        }
        window.location.href = '<?php echo main_url;?>order_quotation/order/' + value + '/' + ordernumber + '/partpayment';
    }

    function refundamount(orderno, amount, user) {
        if (user == "no") {
            alert("Only SuperAdmin can refund payments. Please consult SuperAdmin.");
            return false;
        }

        var refundtype = $('#refundtype').val();
        if (refundtype == 1) {
            alert('Select Refund Type');
            return false;
        }
        window.location.href = '<?php echo main_url;?>order_quotation/Order/refundamount/' + orderno + '/' + refundtype + '/' + amount;
    }


    function showpomodel() {
        $('#po_modl').modal('show');
    }


    /*$(".die").each(function () {

        $this = $(this);
        var value = $this.val();

        var serial = $this.attr('data-val');
        var srctxt = $('#die_' + serial).val();
        var diecode = $('#hide_die_' + serial).val();

        $this.autocomplete({
            source: function (request, response) {
                $.getJSON("<?php //echo main_url;?>order_quotation/Order/getdie",
                    {
                        serial: serial,
                        diecode: diecode,
                        term: request.term
                    }, response);
            },
            select: function (evt, ui) {
                $('#dis_' + serial).attr('data-newcode', ui.item.id);
                $('#dis_' + serial).show();
            }
        });
    });*/

    $(document).on("click", ".changediecode", function (event) {
        var serial_no = $(this).attr('data-serial');
        var productid = $(this).attr('data-newcode');
        var isConfirm = confirm('Are you sure you want to change Product?');
        if (isConfirm) {
            $("#dvLoading").css('display', 'block');
            $.ajax({
                type: "post",
                url: "<?php echo main_url;?>order_quotation/Order/changediecode/",
                data: {serial_no: serial_no, productid: productid},
                success: function (data) {
                    $("#dvLoading").css('display', 'none');
                    window.location.reload(true);
                }
            });
        }
    });

    $(document).on("click", ".load_flash", function (e) {
        var design_id = $(this).attr('data-id');
        var serial = $(this).attr('data-serial');
        $.ajax({
            url: '<?=main_url; ?>order_quotation/Order/load_flash_panel',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {design_id: design_id, serial: serial},
            success: function (data) {
                if (data) {
// check the senerio and change it

                    $.fallr('show', {
                        content: data,
                        width: 1000,
                        icon: 'chat',
                        closeOverlay: true,
                        buttons: {button1: {text: 'cancel'}}
                    });
                }
            }
        });
    });

    $(document).on("click", ".zerodowndelivery", function (event) {
        var orderno = $(this).attr('data-id');
        var isConfirm = confirm('Are you sure you want to update delivery?');
        if (isConfirm) {
            $("#dvLoading").css('display', 'block');
            $.ajax({
                type: "post",
                url: "<?php echo main_url;?>order_quotation/Order/zerodowndelivery/" + orderno,
                data: {orderno: orderno},
                success: function (data) {
                    $("#dvLoading").css('display', 'none');
                    window.location.reload(true);
                }
            });
        }
    });

    function changeorderlabel(orderno, value) {
        var isConfirm = confirm('Are you sure you want to change Order Type ?');
        if (isConfirm) {
            $("#dvLoading").css('display', 'block');
            $.ajax({
                type: "post",
                url: "<?php echo main_url;?>order_quotation/Order/changeorderlabel/" + orderno + "/" + value,
                data: {orderno: orderno, value: value},
                success: function (data) {
                    $("#dvLoading").css('display', 'none');
                    window.location.reload(true);
                }
            });
        }

    }


    $(document).on("keypress keyup blur", ".numeric", function (e) {
        var value = $(this).val();
        if (value > 100 || value < 0) {
            alert("Invalid Value ! Value Must be Between 0 & 100");
            $(this).val('');
            return false;
        }

        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    /*function applydiscount(orderno) {
        var discountvalue = $('#discountvalue').val();
        if (discountvalue > 100 || discountvalue < 0 || discountvalue == "") {
            alert("Invalid Discount value");
            $('#discountvalue').val('');
            return false;
        }
        
       
            
    
        $.ajax({
            type: "post",
            url: "<?php echo main_url;?>order_quotation/Order/applydiscount/" + orderno,
            data: {orderno: orderno, discountvalue: discountvalue},
            success: function (data) {
                window.location.reload(true);
            }
        });
    }*/


    function printingorderinvoice(id) {
        var val = $('.hideprice:checked').length;

        var ver = $('#language').val();
        window.location.href = '<?=main_url ?>order_quotation/Order/printOrder/' + id + '/' + val + '/' + ver;
    }


    $(document).ready(function (e) {
        $('#upload_po_form').on('submit', (function (e) {
            var userfile = $("#file_up").val();
            if (userfile.length == 0) {
                alert('Please Select File');
                $("#userfile").focus();
                return false;
            }
            var Top = $('#gtTotal').val();
            var po_value = $('#po_value').val();

            if (Top != po_value) {
                alert('Please Enter Correct order total');
                return false;
            }
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (data) {
                    if (data.file != '') {

                        swal(
                            "Purchase order form is updated against this order.",


                            {

                                buttons: {

                                    cancel: "No",

                                    catch: {

                                        text: "Yes",

                                        value: "catch",

                                    },


                                },

                                icon: "warning",

                                closeOnClickOutside: false,

                            },
                        ).then((value) => {

                            switch (value) {


                                case "catch":

                                    $('#po_attachment').val(data.file);
                                    window.location.reload();

                                    break;


                            }

                        });

                    }
                },
                error: function (data) {
                    console.log("error");
                }
            });
        }));

        $('#download_img').on('click', (function (e) {
            var pofile = $('#po_attachment').val();
            if (pofile.length > 0) {
                window.open('https://www.aalabels.com/theme/integrated_attach/' + pofile);
            }
        }));
    });


    function editOrderLines(val, id) {
        $.ajax({
            type: "post",
            url: mainUrl + "order_quotation/Order/editAbleCheck",
            cache: false,
            data: {val: val, id: id},
            dataType: 'html',
            success: function (data) {
                window.location.reload();
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('Error While Requesting...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }

    function makeZeroPrice(orderNumber) {


        swal(
            "Do you Want To Continue!",
            {

                buttons: {

                    cancel: "No",

                    catch: {

                        text: "Yes",

                        value: "catch",
                    },
                },

                icon: "warning",

                closeOnClickOutside: false,

            },
        ).then((value) => {

            switch (value) {


                case "catch":

                    $.ajax({
                        type: "post",
                        url: mainUrl + "order_quotation/Order/makeZeroPrice",
                        cache: false,
                        data: {orderNumber: orderNumber},
                        dataType: 'html',
                        success: function (data) {
                            window.location.reload();
                        },
                        error: function (jqXHR, exception) {
                            if (jqXHR.status === 500) {
                                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                            } else {
                                alert('Error While Requesting...');
                            }
                        }
                    });
                    break;
            }

        });

    }


    /*$('#download_img').on('click', (function (e) {
        var pofile = $('#po_attachment').val();
        if (pofile.length > 0) {
            window.open('<?=base_url()?>theme/integrated_attach/' + pofile);
        }
    }));*/

    function getSearch() {

        $.ajax({
            type: "post",
            url: mainUrl + "search/search/getSearch",
            cache: false,
            data: {'category': 'A4'},
            dataType: 'html',
            success: function (data) {
                var msg = $.parseJSON(data);

//showAndHideTabs('format_page');
                $('.od_detail').show();
                $('.od_not_detail').hide();
                $('#order_detail_search').show();
                $('#placeSearch').show();
                $('#ajax_material_sorting').show();
                $('#lf-pos').empty()
                $('#placeSearch').html(msg.html);
                filter_data('autoload', '', 'order');
                $('html, body').animate({
                    scrollTop: $("#placeSearch").offset().top
                }, 2000);
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });


    }

    function noteForOrder(id, orderNumber, serialNumber) {
        $('#order_note_line' + id).show();

    }

    function insertNoteForOrder(id, serialNumber) {

        var status = $('#note_for_od' + id).val();

        if (status == null || status == "") {
            show_faded_alert('note_for_od' + id, 'please insert the note first...');
            return false;
        }

        $.ajax({
            type: "get",
            url: mainUrl + "order_quotation/Order/update_note",
            cache: false,
            data: {'Line': serialNumber, 'status': status},
            dataType: 'json',
            success: function (data) {
                if (data.res == 'true') {
                    window.location.reload();
                }
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }

    function insertNoteForOrderStatus(id, serialNumber) {

        var status = $('#note_for_status' + id).val();

        if (status == null || status == "") {
            show_faded_alert('note_for_status' + id, 'please insert the note first...');
            return false;
        }

        $.ajax({
            type: "get",
            url: mainUrl + "order_quotation/Order/update_note",
            cache: false,
            data: {'Line': serialNumber, 'status': status},
            dataType: 'json',
            success: function (data) {
                if (data.res == 'true') {
                    window.location.reload();
                }
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }

    function deleteNoteForOrder(serialNumber) {

        swal(
            "Are You Sure You Want To Delete This Line",


            {

                buttons: {

                    cancel: "No",

                    catch: {

                        text: "Yes",

                        value: "catch",

                    },


                },

                icon: "warning",

                closeOnClickOutside: false,

            },
        ).then((value) => {

            switch (value) {


                case "catch":

                    $.ajax({
                        type: "get",
                        url: mainUrl + "order_quotation/Order/update_note",
                        cache: false,
                        data: {'Line': serialNumber, 'status': 'Delete'},
                        dataType: 'json',
                        success: function (data) {
                            if (data.res == 'true') {
                                window.location.reload();
                            }

                        },
                        error: function (jqXHR, exception) {
                            if (jqXHR.status === 500) {
                                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                            } else {
                                alert('Error While Requesting...');
                            }
                        }
                    });

                    break;


            }

        });

    }


    function chageMyStatus(val, id) {
		
		if(val == ''){
			alert('Please Select Status');
			return false;
		}
		
        $.ajax({

            url: mainUrl + "order_quotation/Order/changeStatus",
            data: {
                status: val,
                id: id
            },
            datatype: 'json',
            success: function (data) {
                location.reload();
            }


        });
    }

    function showupdate(id) {
        var conditon = $('#tpe' + id).val();
        if (conditon == 'update') {
            $('#updp_btn' + id).show();
        }

    }

    function insertLog(value, serialNumber, condition, key = null) {

        if (condition == 'pressproof') {
            if ($('#pressProf' + key).is(':checked')) {
                value = 'Added';
            } else {
                value = 'not Added';
            }
        }

        $.ajax({

            url: mainUrl + "order_quotation/Order/insertLog",
            data: {
                value: value,
                serialNumber: serialNumber,
                condition: condition
            },
            datatype: 'json',
            success: function (data) {

            }


        });
    }


    function art_pop_tb() {

        $("#sbs").dataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": false,
            "bServerSide": false,
            "bDestroy": true,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            // "lengthMenu": [[4, 10, 25, 50, -1], [4, 10, 25, 50, "All"]],
            "iDisplayStart ": 20,
            "iDisplayLength": 4,
            "aaSorting": [[0, 'desc']],
            //"stateSave": true,
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            },
        });
    }

    $(".die").each(function () {

        $this = $(this);
        var value = $this.val();

        var serial = $this.attr('data-val');
        var srctxt = $('#die_' + serial).val();
        var diecode = $('#hide_die_' + serial).val();
        $('#die_' + serial).autocomplete({
            source: function (request, response) {

                var urld = mainUrl + "order_quotation/Order/getdie";

                $.getJSON(urld,
                    {
                        serial: serial,
                        diecode: diecode,
                        term: request.term
                    }, response);
            }
            ,
            select: function (evt, ui) {
                $('#dis_' + serial).attr('data-newcode', ui.item.id);
                $('#dis_' + serial).show();
            }
        });
    });


    function Updatebilling(id) {
        var comp = $("#Company").val();
        var fname = $("#FirstName").val();
        var lname = $("#Lastname").val();
        var add1 = $("#Address1").val();
        var add2 = $("#Address2").val();
        var city = $('#TownCity').val();
        var state = $("#CountyState").val();
        var contry = $("#bill_country").val();
        var pcode = $("#pcode").val();
        var bemail = $('#BEmail').val();
        var telp = $("#Telephone").val();
        var mob = $("#Mobile").val();
        var pur_ord = $("#purchase_o_no").val();
        $.ajax({
            type: "post",
            url: mainUrl + "order_quotation/Order/update_billing",
            cache: false,
            data: {
                OrderID: id,
                Company: comp,
                FirstName: fname,
                Lastname: lname,
                Address1: add1,
                Address2: add2,
                TownCity: city,
                CountyState: state,
                bill_country: contry,
                pcode: pcode,
                BEmail: bemail,
                Telephone: telp,
                Mobile: mob,
                pur_ord: pur_ord,
            },
            dataType: 'html',
            success: function (data) {
                swal('Success', 'Billing Address Updated Successfully ', 'success');
                $('#myModal').modal('hide');
                setTimeout(function () {
                    window.location.reload(1);
                }, 3000);
            },
            error: function () {
                $('#myModal').modal('hide');
                swal('error', 'Error while request..', 'error');
            }
        });
    }

    function Updatedelivery(id) {
        var comp = $("#DCompany").val();
        var fname = $("#DFirstName").val();
        var lname = $("#DLastname").val();
        var add1 = $("#DAddress1").val();
        var add2 = $("#DAddress2").val();
        var city = $('#DTownCity').val();
        var state = $("#DCountyState").val();
        var contry = $("#Dbill_country").val();
        var pcode = $("#Dpcode").val();
        var bemail = $('#DEmail').val();
        var telp = $("#DTelephone").val();
        var mob = $("#DMobile").val();
        $.ajax({
            type: "post",
            url: mainUrl + "order_quotation/Order/update_delivery",
            cache: false,
            data: {
                OrderID: id,
                DCompany: comp,
                DFirstName: fname,
                DLastname: lname,
                DAddress1: add1,
                DAddress2: add2,
                DTownCity: city,
                DCountyState: state,
                Dbill_country: contry,
                Dpcode: pcode,
                DEmail: bemail,
                DTelephone: telp,
                DMobile: mob,
            },
            dataType: 'html',
            success: function (data) {
                swal('Success', 'Delivery Address Updated Successfully ', 'success');
                $('#myModal_del').modal('hide');
                setTimeout(function () {
                    window.location.reload(1);
                }, 3000);
            },
            error: function () {
                $('#myModal_del').modal('hide');
                swal('error', 'Error while request..', 'error');
            }
        });
    }

    function closebilling() {
        window.location.reload();
        //$('#myModal_billing').modal('hide');
    }

    function closedelivery() {

        window.location.reload();
    }

    function changeorientation(value, serial, type) {
        $.ajax({
            type: "post",
            url: mainUrl + "order_quotation/Order/update_orientation_wound",
            data: {value: value, serial: serial, type: type, ordernumber: '<?=$order->OrderNumber?>'},
            datatype: 'json',
            success: function (data) {
                swal('Success', type + ' is Updated', 'success');
                //window.location.reload(true);
            }
        });
    }

    $(document).on("click", ".swal-button--confirm", function (e) {
        window.location.reload(true);
    });


    function order_currency(currency, ordernumber) {
        $.ajax({
            type: "post",
            url: mainUrl + 'order_quotation/quotation/order_currency',
            cache: false,
            data: {'currency': currency, 'ordernumber': ordernumber},
            dataType: 'html',
            success: function (data) {
                window.location.reload(true);
            },
            error: function () {
                alert('Error while request..');
            }
        });

    }

    function sendemail_again(order) {
        $.ajax({
            type: "get",
            url: mainUrl + "order_quotation/Order/orderemail/" + order + "/direct",
            cache: false,
            data: {},
            dataType: 'json',
            success: function (data) {
                swal('Success', 'Order Confirmation Email is  Successfully Sent', 'success');
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    swal('Success', 'Order Confirmation Email is  Successfully Sent', 'success');
                }
            }
        });
    }


    function applydiscount(orderno, apply) {
        var discountvalue = $('#discountvalue').val();
        if (discountvalue > 100 || discountvalue < 0 || discountvalue == "") {
            alert("Invalid Discount value");
            $('#discountvalue').val('');
            return false;
        }
        
         if(<?=$uID?>==653722 && discountvalue > 10){
               show_faded_alert('discountvalue','You can only Discount apply up to 10%');
              return false;
         }
           
          
            

        var check = confirm('Are you sure you want to ' + apply + ' Discount ?');
        if (check) {
            $.ajax({
                type: "post",
                url: "<?php echo main_url;?>order_quotation/Order/applydiscount/" + orderno,
                data: {orderno: orderno, discountvalue: discountvalue, apply: apply},
                success: function (data) {
                    window.location.reload(true);
                }
            });
        }
    }


    $(document).on("click", "#ordervat_validator", function (e) {
        var vatnumber = $('#ordervatnumber').val();
        //var country = $('#Dbill_country').val();
        var country = $('#bill_country').val();
        var email = $('#BEmail').val();
        var userid = $('#custId').val();
        var OrderNumber = '<?=$order->OrderNumber?>';

        if (vatnumber.length > 0) {
            $.ajax({
                url: mainUrl + 'order_quotation/Order/order_vat_validate',
                type: "POST",
                async: "false",
                data: {country: country, vatNumber: vatnumber, email: email, userid: userid, OrderNumber: OrderNumber},
                dataType: "html",
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.status == 'valid') {
                        window.location.reload(true);
                    } else {
                        $('#ordervatnumber').html('');
                        swal("", "please enter a valid VAT number", "warning");
                        VATNumber = 'invalid';
                    }
                }
            });
        } else {
            VATNumber = 'invalid';
            $('#ordervatnumber').html('');
            swal("", "please enter a valid VAT number", "warning");
        }
    });

    $(document).on("click", "#removevat_validator", function (e) {
        var OrderNumber = '<?=$order->OrderNumber?>';
        $.ajax({
            url: mainUrl + 'order_quotation/Order/removevat_validator',
            type: "POST",
            async: "false",
            data: {OrderNumber: OrderNumber},
            dataType: "html",
            success: function (data) {
                data = $.parseJSON(data);
                if (data.status == 'valid') {
                    window.location.reload(true);
                }
            }
        });
    });


</script>

