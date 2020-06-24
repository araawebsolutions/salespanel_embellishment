<!-- for autoload-->
<script src="<?= ASSETS ?>assets/js/datepicker.js"></script>
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
	margin-right : 5% !important;
}

.changediecode {
	display: none;
	color: #00b6f0;
	cursor: pointer;
	font-size: 13px;
    
}
	
	.ui-autocomplete{
		z-index: 1000 !important;
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
</style>
<!-- End Navigation Bar-->

<input type="hidden" id="method_on_page" value="order">
<input type="hidden" id="order_number" value="<?= $order->OrderNumber ?>">
<input type="hidden" id="useer_id" value="<?= $order->UserID ?>">
<?php
$this->session->set_userdata('userid', $order->UserID);
?>
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
								
                  <div class="card-body"> 
										Order: <Number><?= $order->OrderNumber ?></Number><br>
                    <span>Source: <?=$order->Source?></span> <br>
                    Date & Time:
                    <?= date('jS F Y', $order->OrderDate) ?>
                    <?= $order->time ?>
                    <hr>
                    <p class="labels-form" style="display: inline-flex"> <span style="margin-top: 7px;margin-right: 7px;">Status :</span>
                      <label class="select">
                        <select class="select-design-adjst form-control"
                                                        onchange="chageMyStatus(this.value,'<?= $order->OrderID ?>')">
                          <?php foreach ($status as $key => $state) { ?>
                          <option value="<?= $key ?>" <?php if ($order->OrderStatus == $key) { ?> selected <?php } ?>>
                          <?= $state ?>
                          </option>
                          <?php } ?>
                        </select>
                        <i></i> </label>
                    </p>
                    <!--<p>Payment : Visa £128.38 GBP Balance : £00.00 GBP</p>-->
									<?php if($order->OrderStatus !=7){ ?>
                    <div class="row" style="margin: 0px;"> <span id="cr_py">
                      <form method="get" action="<?= main_url ?>order_quotation/order/takeCreditCartPayment">
                        <input type="hidden" name="orderNumber" value="<?= $order->OrderNumber ?>">
                        <input type="hidden" name="type" value="creditCard">
                        <button type="submit" class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10" style="margin-right: 10px;"> Take Payment </button>
                      </form>
                      </span> <span style="margin-right: 10px;">
                      <button type="button" onclick="makeZeroPrice('<?= $order->OrderNumber ?>')"
            class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10"> Make Zero Value </button>
                      </span>
                      <? if ($order->PaymentMethods == "purchaseOrder") { ?>
                      <span class="" id="pr_py">
                      <button type="button" onclick="showpomodel()"
            class="btn btn-outline-info waves-light waves-effect small-details-cta m-t-10"> Purchase Order </button>
                      </span>
                      <? } ?>
                    </div>
									<?php } ?>
									
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display: flex;">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                  <div class="card-body">
                    <?= $order->BillingCompanyName ?>
                    </br>
                    <?= $order->BillingFirstName . ' ' . $order->BillingLastName ?>
                    </br>
                    <?= $order->BillingAddress1 ?>
                    </br>
                    <?= $order->BillingAddress2 ?>
                    </br>
                    <?= $order->BillingTownCity ?>
                    </br>
                    <?= $order->BillingCountyState ?>
                    </br>
                    <?= $order->BillingCountry ?>
                    </br>
                    <?= $order->BillingPostcode ?>
                    </br>
                    Email:
                    <?= $order->Billingemail ?>
                    </br>
                    T:
                    <?= $order->Billingtelephone ?>
                    | M:
                    <?= $order->BillingMobile ?>
                    </br>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display: flex">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                  <div class="card-body">
                    <?= $order->DeliveryCompanyName ?>
                    </br>
                    <?= $order->DeliveryFirstName . ' ' . $order->DeliveryLastName ?>
                    </br>
                    <?= $order->DeliveryAddress1 ?>
                    </br>
                    <?= $order->DeliveryAddress2 ?>
                    </br>
                    <?= $order->DeliveryTownCity ?>
                    </br>
                    <?= $order->DeliveryCountyState ?>
                    </br>
                    <?= $order->DeliveryCountry ?>
                    </br>
                    <?= $order->DeliveryPostcode ?>
                    </br>
                    Email:
                    <?= $order->Deliveryemail ?>
                    </br>
                    T:
                    <?= $order->Deliverytelephone ?>
                    | M:
                    <?= $order->DeliveryMobile ?>
                    </br>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card-box">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr class="card-heading-title">
                      <th class="text-center invoice-heading-text" width="10%">Manufacturer ID</th>
                      <th class="text-center invoice-heading-text" width="60%">Description</th>
                      <th class="text-center invoice-heading-text text-center" width="5%">Labels</th>
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
									
                                    foreach ($orderDetails as $key => $detail) {

                                        $product_detail = $this->user_model->getproductdetail($detail->ProductID);
                                        $permissions = $this->settingmodel->checkpermissions($detail->SerialNumber, $product_detail, $order->OrderStatus, $order->editing);
                                        $totalPrice = $totalPrice + ($detail->Price + $detail->Print_Total);
                                        $product = $this->user_model->getproductdetail($detail->ProductID);

                                        $digitalCheck = ($detail->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';
                                        ?>
                    <?php if ($order->editing == 'yes') { ?>
                    <?php if ($detail->ProductID == 0) { ?>
										 <?php if ($detail->ManufactureID != 'SCO1') { ?>
                    <tr>
                      <td><input type="text"
                                                               class="form-control input-number text-center allownumeric"
                                                               id="update_line_man<?= $key ?>"
                                                               value="<?= $detail->ManufactureID ?>"></td>
                      <td><textarea
                                                                id="update_line_des<?= $key ?>"
                                                                class="form-control input-number text-center allownumeric"
                                                                style="height: 25.38px;"><?= $detail->ProductName.' '.$this->quoteModel->txt_for_plain_labels($order->Label); ?>
</textarea></td>
                      <td><input class="form-control input-number text-center allownumeric"
                                                               type="text" id="update_line_unit_price<?= $key ?>"
                                                               value="<?= ($detail->Price / $detail->Quantity) ?>"
                                                               placeholder="unit price"></td>
                      <td><input type="text"
                                                               class="form-control input-number text-center allownumeric"
                                                               id="update_line_qty<?= $key ?>"
                                                               value="<?= $detail->Quantity ?>"
                                                               placeholder="quanity"></td>
                      <td><? echo $symbol . (number_format($detail->Price * $order->exchange_rate, 2, '.', '')); ?></td>
                      <td class="padding-6 icon-tablee"><i class="mdi mdi-delete"
                                                           onclick="deleteOrderNode(<?= $detail->SerialNumber ?>)"
                                                           id="deletenode1"></i> <i class="mdi mdi-content-save"
                                                           onclick="updateOrderNewLine(<?= $key ?>,<?= $detail->SerialNumber ?>,<?= $detail->UserID ?>)"></i></td>
                    </tr>
						<?php } else{?>
										
										   <tr class="noneditable">
                      <td class="text-center"><strong><?php echo $detail->ManufactureID ?></strong></td>
                      <td><!--<strong>
                        <?= $detail->pn ?>
                        </strong>-->
                        <?= $detail->ProductName.' '.$this->quoteModel->txt_for_plain_labels($order->Label); ?></td>
                      <td class="text-center"><?= ($detail->labels) ?></td>
                      <td class="text-center"><?= $detail->Quantity ?></td>
                      <td class="text-center"><?=$symbol?><?= $detail->Price ?></td>
                      <td></td>
                    </tr>
						
										 <?php if ($detail->ManufactureID == 'SCO1') {
																					
										  $carRes = $this->user_model->getCartOrderData($detail->SerialNumber);
										 ?>
                                       
											<?php
												$scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
												$assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                        foreach ($assoc as $rowp){
                      ?>
                      <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
                      <? $materialpriceinc = $materialprice * 1.2; ?>
                      <tr>
                      <td class="text-center labels-form"><?=$rowp->material?></td>
                      <td class="text-center"><i class="mdi "></i><?= $this->user_model->get_mat_name($rowp->material); ?></td>
                      <td class="text-center" id="labels0">-</td>
                      <td class="text-center"><?= $rowp->qty ?></td>
                      <td class="text-center"><?=$symbol?><? echo number_format($materialprice * $exchange_rate, 2); ?>
												<?php $totalPrice +=  number_format($materialprice * $exchange_rate, 2);?>
												</td>
											<td></td>
                      </tr>
                        <?php }?>
                      <?php } }?>
										
									
                    <?php } else {
                                                $calco = $this->home_model->getProductCalculation($detail->ProductID, $detail->ManufactureID);
                                                ?>
                    <tr class="editAble" id="od_dt_line<?= $detail->SerialNumber ?>">
                      <input type="hidden" id="minroll<?= $key ?>"
                                                           value="<?= $calco['minRoll'] ?>">
                      <input type="hidden" id="maxroll<?= $key ?>"
                                                           value="<?= $calco['maxRoll'] ?>">
                      <input type="hidden" id="minlabel<?= $key ?>"
                                                           value="<?= $calco['minLabels'] ?>">
                      <input type="hidden" id="maxlabel<?= $key ?>"
                                                           value="<?= $calco['maxLabels'] ?>">
                      <td class="text-center labels-form"><? if ($permissions['die'] == 1 && $permissions['mat'] == 1) {
                                                            ?>
                        <input style="margin-bottom: 10px;" type="hidden" id="hide_die_<?= $detail->SerialNumber ?>" value="" class="form-control input-number text-center allownumeric"/>
                        <input class=" die form-control input-number text-center allownumeric ui-autocomplete-input" type="text" autocomplete="on" id="die_<?= $detail->SerialNumber ?>" value="<?= $detail->ManufactureID ?>" data-val="<?= $detail->SerialNumber ?>">
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
                        Design</b></a>
                        <?php }
                                                        } ?>
                        <br/>
                        <?php if ($detail->ProductID != 0 && $permissions['add_rem_prnt'] == 1) {
                                                            if ($detail->regmark == 'Y') {
                                                                ?>
                        
                        <!--                                                                <select class="form-control">--> 
                        <!--                                                                    <option value="N" >   Plain </option>--> 
                        <!--                                                                </select><i></i>-->
                        
                        <?php } else {
                                                                ?>
                        <label class="select">
                          <select class="form-control"
                                                                            onchange="conPlainOrPrint(this.value,<?= $detail->SerialNumber ?>,<?= $key ?>)">
                            <option value="N" <? if ($detail->Printing != 'Yes' || $detail->Printing != 'Y') { ?> selected <? } ?>> Plain </option>
                            <option value="Y" <? if ($detail->Printing == 'Yes' || $detail->Printing == 'Y') { ?> selected <? } ?>> Printed </option>
                          </select>
                          <i></i> </label>
                        <?php }
                                                        } ?></td>
                      <td>
												<?= $detail->ProductName .' '.$this->quoteModel->txt_for_plain_labels($order->Label);?>
												
												
                        <?php if ($detail->regmark == 'Y') { ?>
                        <br/>
                        <b>Printing Service (Black Registration Mark on Reverse)</b>
                        <?php } ?>
                        
                        <!-- <span>
            <i class="mdi mdi-check"><? /*= $detail->Print_Type */ ?></i>
            <i class="mdi mdi-check"><? /*= $detail->Print_Design */ ?></i>
            <i class="mdi mdi-check"><? /*= $detail->Wound */ ?></i>
            <i class="mdi mdi-check"><? /*= $detail->Orientation */ ?></i>
            <i class="mdi mdi-check"><? /*= $detail->FinishType */ ?></i>
            <i class="mdi mdi-check"><? /*= $detail->pressproof */ ?></i>
            <i class="mdi mdi-check"><? /*= $detail->Print_Qty . ' Designs ' . $detail->Print_Type . ' (' . ($detail->Print_Qty - $detail->Free) . '+' . $detail->Free . ' Free )' */ ?></i>
                    <? /*= $detail->Print_Total */ ?>
        </span>--></td>
                      <td class="text-center"
                                                        id="labels<?= $key ?>"><?= ($detail->sample == 'Sample') ? 0.00 : $detail->labels ?></td>
                      <input type="hidden" id="label_for_orders<?= $key ?>"
                                                           value="<?= ($detail->sample == 'Sample') ? 0.00 : $detail->labels ?>">
                      <td><? if ($permissions['qty'] == 1) { ?>
                        <input type="text"
                                                                   onchange="updateLabels(<?= $key ?>,<?= $detail->LabelsPerRoll ?>)"
                                                                   id="qty<?= $key ?>"
                                                                   value="<?= $detail->Quantity ?>" <?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') { ?> readonly <?php } ?>
                                                                   class="form-control input-number text-center allownumeric">
                        <?php if (preg_match("/Roll/i", $detail->ProductBrand)) { ?>
                        <p class="text-center">No of Rolls</p>
                        <?php } else { ?>
                        <p class="text-center">No of Sheets</p>
                        <?php } ?>
                        <?php } else { ?>
                        <input type="text" id="qty<?= $key ?>" readonly
                                                                   value="<?= $detail->Quantity ?>"
                                                                   class="form-control input-number text-center allownumeric">
                        <?php } ?></td>
                      <input type="hidden" id="previousQty<?= $key ?>"
                                                           value="<?= $detail->Quantity ?>">
                      <input type="hidden" id="arwtork_qty<?= $key ?>" value="">
                      <td class="text-center"><? echo $symbol . (number_format($detail->Price * $order->exchange_rate, 2, '.', '')); ?></td>
                      <td class="padding-6 icon-tablee"><?php
                                                        $printing = ($detail->Printing == 'Y') ? 'Y' : 'N';
                                                        ?>
                        <i class="mdi mdi-note-plus" id="update<?= $key ?>"
                                                           onclick="noteForOrder(<?= $key ?>,'<?= $detail->OrderNumber ?>',<?= $detail->SerialNumber ?>)"></i>
                        <? if ($permissions['add_rem_pro'] == 1) { ?>
                        <i class="mdi mdi-delete" id="delete<?= $key ?>"
                                                               onclick="delOrderDetail(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i>
                        <? } ?>
                        <? if ($order->editing == "yes" && $order->OrderStatus != 7 && $order->OrderStatus != 8 && $order->OrderStatus != 33 && $order->OrderStatus != 27) { ?>
                        <i class="mdi mdi-content-save" id="update_one<?= $key ?>" 
                                                               onclick="updateOrder(<?= $key ?>,'<?= $detail->OrderNumber ?>','<?= $detail->ProductBrand ?>','<?= $detail->ManufactureID ?>',<?= $detail->ProductID ?>,<?= $detail->pressproof ?>,<?= $detail->SerialNumber ?>,<?= $order->UserID ?>,'<?= $printing ?>',<?= $detail->LabelsPerRoll ?>,'<?= $detail->regmark ?>')"></i>
                        <?
                                                        } ?></td>
                    </tr>

   <? $detail_view = @$this->quotationModal->check_product_extra_detail($detail->ManufactureID);
      if($detail_view['prompt']=='yes'){?>
      <tr>
       
        <td><b style="color:green;font-size:12px;">Product Note</b></td>
        <td><b style="color:green;font-size:12px;">
          <?=$detail_view['detail']?>
          </b></td> <td></td>
        <td></td><td></td><td></td>
      </tr>
    <? } ?>
                    <tr id="order_note_line<?= $key ?>" <?php if ($detail->Product_detail == null) { ?> style="display: none;" <?php } ?>>
                      <td></td>
                      <td><input type="text" required id="note_for_od<?= $key ?>"
                                                               value="<?= $detail->Product_detail ?>"
                                                               class="form-control input-number text-center allownumeric"></td>
                      <td></td>
                      <td></td>
                      <td class="text-center"></td>
                      <td class="padding-6 icon-tablee"><i class="mdi mdi-delete"
                                                           onclick="deleteNoteForOrder(<?= $detail->SerialNumber ?>)"> </i> <i class="mdi mdi-content-save"
                                                           onclick="insertNoteForOrder(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i></td>
                    </tr>
                    <?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') {  //echo '<pre>'; print_r($detail); echo '</pre>';?>
                    <tr>
                      <td></td>
                      <td><div class="btn-span"> <span class="labels-form" style="margin-right: 15px;">
                          <? if (($detail->Printing == 'Yes' || $detail->Printing == 'Y')) {   ?>
                          <label class="select" style="margin-bottom: 0px !important;"> 
<select id="digital<?= $key ?>" class="form-control no-padding" name="digital"  onchange="insertLog(this.value,<?=$detail->SerialNumber?>,'Print_Type')">                                                          
                            <option value="">Please Select Digital Process</option>
                            <?php foreach ($digitalis as $digital) {
			
	
																				if ($digital->type == $digitalCheck || $digital->type == 'both') { ?>
	
	<?php if($detail->ProductBrand!='Roll Labels'){?>
                            <option value="<?= $digital->name ?>" 
																		<?php if ($digital->Print_Type == $detail->Print_Type || $digital->name == $detail->Print_Type) {  echo 'selected'; } ?>>
															 <?= $digital->name; ?>
                            </option>
															<?php } else{?>
															
															<option value="<?= $digital->name ?>" <?php if ($digital->name == $detail->Print_Type || $digital->Print_Type == $detail->Print_Type) { echo 'selected'; } ?>><?= $digital->name; ?></option>
															<?php } ?>
															
                           
                            <?php }
                                                               }  ?>
                            </select>
                            <i></i> </label>
                          </span>
                          <?php if ($detail->ProductBrand == 'Roll Labels') { ?>
                          <span class="m-10 labels-form">
                          <label class="select">
                            <select id="Orientation<?= $key ?>"
                                                     onchange="insertLog(this.value,<?= $detail->SerialNumber ?>,'Orientation')"
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
                            <i></i> </label>
                          </span> <span class="m-10 labels-form">
                          <label class="select">
                            <select id="wound<?= $key ?>" onchange="insertLog(this.value,<?= $detail->SerialNumber ?>,'Wound')"
                            class="form-control no-padding">
                              <option selected="selected" value="">Select Wound Type</option>
                              <option value="Outside"<?php if ($detail->Wound == 'Outside') {
                            echo 'selected';
                        } ?>>Out Side Wound</option>
                              <option value="Inside"<?php if ($detail->Wound == 'Inside') {
                            echo 'selected';
                        } ?>>Inside Wound </option>
                            </select>
                            <i></i> </label>
                          </span> <span class="m-10 labels-form">
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
                            <i></i> </label>
                          </span>
                          <?php } ?>
                          <br/>
                          <br/>
                          <?php if ($digitalCheck == 'roll') { ?>
                          <span class="no-padding m-10">
                          <input type="checkbox"
                                                                                                         onclick="insertLog(this.value,<?= $detail->SerialNumber ?>,'pressproof',<?= $key ?>)"
                                                                                                         id="pressProf<?= $key ?>"
                                                                                                         <?php if ($detail->pressproof == 1){ ?>checked
                                                                                                         <?php } ?>name="pressprof"
                                                                                                         value="1">
                          <p
                                                                                style="font-size: 11px;color: #666;text-align: center">Pressproof</p>
                          </span>
                          <?php } ?>
                          <?php if ($permissions['qty'] == 1) { ?>
                          <span>
                          <button id="artworki_for_order<?= $key ?>"
                                onclick="addToCart('<?= $detail->ManufactureID ?>','<?= $detail->SerialNumber ?>','<?= $detail->Printing ?>','<?= $detail->ProductID ?>','<?= $detail->OrderNumber ?>','<?= $product['ProductBrand'] ?>','order_detail_page',<?= $key ?>)" 
                                type="button"
                                class="m-20 btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork"
                                data-toggle="modal" data-target=".bs-example-modal-lga"> <i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; View Artwork Spec </button>
                          </span>
                          <? }
                                                                } ?>
                          <input type="hidden" id="seril<?= $key ?>"
                                                                       value="<?= $detail->SerialNumber ?>">
                          <input type="hidden" id="pproduct<?= $key ?>"
                                                                       value="<?= $detail->ProductID ?>">
                        </div></td>
                      <td></td>
                      <td><input type="text" id="design<?= $key ?>"
                                                                   class="text-center form-control input-number text-center allownumeric"
                                                                   readonly value="<?= $detail->Print_Qty ?>">
                        <p class="text-center">No of Design</p></td>
                      <td><? echo $symbol . (number_format($detail->Print_Total * $order->exchange_rate, 2, '.', '')); ?></td>
                      <td></td>
                    </tr>
                    <?php } elseif ($detail->Printing == 'Y' && $detail->regmark == 'Y') { ?>
                    <tr>
                      <td></td>
                      <td><span style="float:left; margin-left:10px; padding:2px;"> <a href="https://www.aalabels.com/theme/integrated_attach/<?= $this->home_model->getdiecode($detail->ManufactureID) ?>_rev.pdf"
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
                                        } else { ?>
                    <tr class="noneditable">
                      <td class="text-center"><strong><?php echo $detail->ManufactureID ?></strong></td>
                      <td><!--<strong>
                        <?= $detail->pn ?>
                        </strong>-->
                        <?= $detail->ProductName.' '.$this->quoteModel->txt_for_plain_labels($order->Label); ?></td>
                      <td class="text-center"><?= ($detail->labels) ?></td>
                      <td class="text-center"><?= $detail->Quantity ?></td>
                      <td class="text-center"><?=$symbol?><?= $detail->Price ?></td>
                      <td></td>
                    </tr>
						
										 <?php if ($detail->ManufactureID == 'SCO1') {
																					
										  $carRes = $this->user_model->getCartOrderData($detail->SerialNumber);
										 ?>
                                       
											<?php
												$scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
												$assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                        foreach ($assoc as $rowp){
                      ?>
                      <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
                      <? $materialpriceinc = $materialprice * 1.2; ?>
                      <tr>
                      <td class="text-center labels-form"><?=$rowp->material?></td>
                      <td class="text-center"><i class="mdi "></i><?= $this->user_model->get_mat_name($rowp->material); ?></td>
                      <td class="text-center" id="labels0">-</td>
                      <td class="text-center"><?= $rowp->qty ?></td>
                      <td class="text-center"><?=$symbol?><? echo number_format($materialprice * $exchange_rate, 2); ?>
												<?php $totalPrice +=  number_format($materialprice * $exchange_rate, 2);?>
												</td>
											<td></td>
                      </tr>
                        <?php }?>
                      <?php } ?>
						
                    <?php if ($detail->Product_detail != null) { ?>
                    <tr>
                      <td><?php if ($order->editing == "no") { ?>
                        <span style="color:green ">Product Note</span>
                        <?php  } ?></td>
                      <td><?php if ($order->editing == "no") { ?>
                        <span style="color:green ">
                        <?= $detail->Product_detail ?>
                        </span>
                        <?php } else{?>
                        <input type="text" required id="note_for_status<?= $key ?>"
                                                               value="<?= $detail->Product_detail ?>"
                                                               class="form-control input-number text-center allownumeric">
                        <?php } ?></td>
                      <td></td>
                      <td></td>
                      <td><i class="mdi mdi-content-save"
                                                           onclick="insertNoteForOrderStatus(<?= $key ?>,<?= $detail->SerialNumber ?>)"></i></td>
                    </tr>
                    <?php } ?>
  <? $detail_view = @$this->quotationModal->check_product_extra_detail($detail->ManufactureID);
      if($detail_view['prompt']=='yes'){?>
      <tr>
        <td><b style="color:green;font-size:12px;">Product Note</b></td>
        <td><b style="color:green;font-size:12px;">
          <?=$detail_view['detail']?>
          </b></td>
        <td></td>
        <td></td><td></td><td></td>
      </tr>
    <? } ?> 
                    <?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') { ?>
                    <tr class="noneditable">
                      <td class="text-center"></td>
                      <td><i class="mdi mdi-check"></i><span>
                        <?= $detail->Print_Type ?>
                        </span>
                        <?php if ($detail->Print_Qty > 0) { ?>
                        <i class="mdi mdi-check"></i> <span>
                        <?= $detail->Print_Qty . '  Design' ?>
                        </span>
                        <?php } ?>
                        <?php if ($digitalCheck == 'roll') { ?>
                        <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Wound:</strong>
                        <?= $detail->Wound ?>
                        </span> <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Orientation:</strong>
                        <?= $detail->Orientation ?>
                        </span> <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Finish:</strong>
                        <?= $detail->FinishType ?>
                        </span> <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Press Proof:</strong>
                        <?= ($detail->pressproof == 1) ? 'Yes' : 'No' ?>
                        </span>
                        <?php } ?></td>
                      <td class="text-center"></td>
                      <td class="text-center"><?= $detail->Print_Qty ?></td>
                      <td class="text-center"><? echo $symbol . (number_format($detail->Print_Total * $order->exchange_rate, 2, '.', '')); ?></td>
                      <td class="text-center"></td>
                    </tr>
                    <?php } elseif ($detail->Printing == 'Y' && $detail->regmark == 'Y') { ?>
                    <tr>
                      <td></td>
                      <td><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
											 <td></td>
                    </tr>
                    <?php
                                            }
                                        }
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
                      <td class="padding-6 icon-tablee"><i class="mdi mdi-content-save"
                                               onclick="orderNewLine('<?= $order->OrderNumber ?>',<?= $order->UserID ?>)"></i></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6 pull-left"> <span id="showNwLine">
                  <button type="button" onclick="showNwLine()"
                              class="btn btn-info waves-light waves-effect addnewline">ADD NEW LINE</button>
                  </span> <span style="display: none" id="hideNwLine">
                  <button type="button"
                                                                                        onclick="hideNwLine()"
                                                                                        class="btn btn-info waves-light waves-effect addnewline">Hide LINE</button>
                  </span> <span>
                  <button type="button" onclick="getSearch()"
        class="btn btn-info waves-light waves-effect addnewline">Add New Product</button>
                  </span>
                  <?php if ($order->editing == 'no') { ?>
                  <span>
                  <button type="button" onclick="editOrderLines('yes','<?= $order->OrderID ?>')"
        class="btn btn-success waves-light waves-effect">Edit Order</button>
                  </span>
                  <?php } else { ?>
                  <span>
                  <button type="button" onclick="editOrderLines('no','<?= $order->OrderID ?>')"
        class="btn btn-success waves-light waves-effect">Finish Edit Order</button>
                  </span>
                  <?php }  ?>
                </div>
								<?php //$order->vat_exempt='yes'; ?>
                <div class="col-md-6 pull-right">
                  <table class="table table-bordered quote-price-details">
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
                      <td><? echo $symbol .(number_format(($order->OrderShippingAmount / vat_rate) * $order->exchange_rate, 2, '.', '')); 
											$totalPrice = $totalPrice +	number_format(($order->OrderShippingAmount / vat_rate) * $order->exchange_rate, 2, '.', '');
												
												
												?></td>
                    </tr>
                    				<?php $grandTotal = $totalSubs + ($order->OrderShippingAmount / vat_rate); ?>
                    <tr>
                      <td>Choose Delivery Option:</td>
                      <td><?

                                                $order->inctotal_for_page = $grandTotal;
                                                $order->extotal_for_page = $totalPrice; ?>
                        <?php $this->load->view('order_quotation/order_detail/shiping', $order); ?></td>
                    </tr>
                    <?php if ($order->voucherOfferd == 'Yes') {
                                            $discount_applied_in = $order->voucherDiscount;
                                            $discount_applied_ex = $order->voucherDiscount / 1.2;
                                        } else {
                                            $discount_applied_in = 0.00;
                                            $discount_applied_ex = 0.00;
                                        }
                                        ?>
                    <tr>
                      <td>Discount:</td>
                      <td><?php $discount = $discount_applied_in; ?>
                        <? echo $symbol . (number_format($discount * $order->exchange_rate, 2, '.', '')); ?></td>
                    </tr>
                    <? if ($order->vat_exempt == 'yes') { ?>
                    <tr>
                      <td>VAT Exempt:</td>
                      <td>-<? $vatvalue = ($totalPrice * vat_rate) - $totalPrice;     
																												 echo $symbol . (number_format($vatvalue * $order->exchange_rate, 2, '.', '')); ?></td>
                    </tr>
                    <? } else { ?>
										
										<tr>
                      <td>VAT @20%:</td>
                      <td><? $vatvalue = ($totalPrice * vat_rate) - $totalPrice;     
																												 echo $symbol . (number_format($vatvalue * $order->exchange_rate, 2, '.', '')); ?></td>
                    </tr>
										<?php } ?>
                    <tr>
                      <td>Grand Total:</td>
                      <td>
												<?php
                         $grandTotal = $grandTotal - $discount;
												
												 if ($order->vat_exempt == 'yes') { 
												
												
												 } else{
													 $grandTotal = number_format($grandTotal * vat_rate,2,'.',''); 
												 }
												$finalAmount = $grandTotal;
												echo $symbol . (number_format($grandTotal * $order->exchange_rate, 2, '.', ''));
												?>
												<input type="hidden" id="gtTotal" value="<?php echo (number_format($grandTotal * $order->exchange_rate, 2, '.', '')) ?>">
											</td>
										</tr>
										<?php
										$subPrice = array('OrderTotal' => $grandTotal);
										$this->db->where('OrderNumber', $order->OrderNumber);
										$this->db->update('orders', $subPrice);
										?>
										<tr>
											<td>Amount Paid:</td>
											<td><? echo $symbol . (number_format($paymentReceived * $order->exchange_rate, 2, '.', '')); ?>
												<input type="hidden" id="amount_paid" value="<?= $paymentReceived ?>"></td>
										</tr>
										<input type="hidden" id="grand_amount" value="<?= $grandTotal ?>">
										
                    <?php
												$refnd = number_format($paymentReceived - $finalAmount, 2);

															 $total_amount_refund = $this->settingmodel->payment_refunded($order->OrderNumber);
															 if ($total_amount_refund > 0) {
																 $grandTotal = $grandTotal + $total_amount_refund;
															 }

															 $myfinalAmount = $finalAmount - $paymentReceived;
															 $fn = number_format($myfinalAmount * $order->exchange_rate, 2, '.', '');
                                        ?>
                    <?php if ($paymentReceived < $finalAmount && $fn != '0.00') { ?>
                    <tr>
                      <td>Amount Pending:</td>
                      <td class="highlighted-price labels-form"><b>
                        <? $myfinalAmount = $finalAmount - $paymentReceived;
                                                        echo $symbol . (number_format($myfinalAmount * $order->exchange_rate, 2, '.', ''));
                                                        ?>
                        </b></td>
                    </tr>
                    <tr>
                      <td>Pending Payment Procedure:</td>
                      <td class="highlighted-price labels-form"><label class="select">
                          <select class="form-control"
                                                                onchange="get_payment(this.value,'<?= $order->OrderNumber ?>')">
                            <option value="1">Select Payment Method</option>
                            <option value="worldpay">Pay by Creditcard</option>
                            <? $UserTypeID = $this->session->userdata('UserTypeID');
                                                            if ($UserTypeID == 50) { ?>
                            <option value="paypalmanual">Pay by Paypal</option>
                            <option value="bacscheque">Pay by BACS/Cheque</option>
                            <? } ?>
                          </select>
                          <i></i> </label></td>
                    </tr>
                    <?php } elseif ($paymentReceived > $grandTotal && $refnd > '0.00') { ?>
                    <tr>
                      <td>Refund Amount:</td>
                      <td class="highlighted-price"><? $mypaymentreceived = $paymentReceived - $totalPrice;
                                                    echo $symbol . (number_format($mypaymentreceived * $order->exchange_rate, 2, '.', ''));
                                                    ?></td>
                    </tr>
                    <tr>
                      <td class="labels-form"><label class="select">
                          <select id="refundtype" class="form-control">
                            <option value="1">Select Refund Method</option>
                            <option value="worldpay">Pay by Creditcard</option>
                            <option value="paypal">Pay by Paypal</option>
                            <option value="bacscheque">Pay by BACS/Cheque</option>
                          </select>
                          <i></i> </label></td>
                      <? $refunduser = $this->session->userdata('UserTypeID');
                                                $refunduser = ($refunduser == 50) ? "yes" : "no";
                                                ?>
                      <td class="highlighted-price"><button style="background-color:green;color:white" type="button"
                                                            onclick="refundamount('<?= $order->OrderNumber ?>',<?= $paymentReceived - $totalPrice ?>,'<?= $refunduser ?>');"
                                                            class="btn btn-info waves-light waves-effect"> Refund </button></td>
                    </tr>
                    <?php } ?>
                      </tr>
                    
                    <tr>
                      <td>Print Quotation:</td>
                      <td><div class="checkbox checkbox-custom"> Hide Prices:
                          <input id="hide" class="hideprice" type="checkbox" name="hideprice">
                          <label for="hide"> </label>
                        </div></td>
                    </tr>
                    <? $site = ($order->site == "" || $order->site == "en") ? "English" : "French"; ?>
                    <tr>
                      <td class="labels-form"><label class="select">
                          <select class="form-control" id="language">
                            <option value="en" <? if ($site == "English") { ?> selected="selected" <? } ?>> English </option>
                            <option value="fr" <? if ($site == "French") { ?> selected="selected" <? } ?>> French </option>
                          </select>
                          <i></i> </label></td>
                      <td>
												<button type="button" onclick="printingorderinvoice('<?= $order->OrderNumber ?>');" class="btn btn-info waves-light waves-effect"> Print Invoice </button>
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
      <div class="" id="placeSearch"> </div>
      <!-- end row --> 
      <!-- Label Finder Ends  --> 
      <!-- Products View Start  -->
      <div class="m-t-26" id="ajax_material_sorting"> </div>
      <div class="m-t-26" id="order_detail_material"> </div>
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
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Note Date</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($notes as $key => $note) { ?>
                <tr>
                  <td><?= $note->noteDate ?></td>
                  <td><?= $note->noteTitle ?>
                    <input type="hidden" id="note_title<?= $key ?>" value="<?= $note->noteTitle ?>"></td>
                  <td><?= $note->noteText ?>
                    <input type="hidden" id="note_des<?= $key ?>" value="<?= $note->noteText ?>"></td>
                  <td><button onclick="showUpdatePopup(<?= $key ?>,<?= $note->noteID ?>)"
                                                class="btn btn-default btn-number  add-line-btn fa-2x" type="button"> <i class="mdi mdi-pencil-box-outline"></i></button></td>
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
            <table class="table table-bordered text-center">
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
          <div class="card-body no-padding">
            <table class="table table-bordered text-center">
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
                  <td><?=$symbol ?>
                    <?= $rowp->payment ?></td>
                  <td><?= $rowp->type ?></td>
                </tr>
                <? }
                            } else { ?>
                <tr>
                  <td colspan="3"> No Note(s) found against.</td>
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
                <label class="input"><b>Order total:</b> <?php echo $symbol . (number_format($grandTotal * $order->exchange_rate, 2, '.', '')) ?>
                  <input type="hidden" placeholder="Value" name="po_value" id="or_tots"
                                           value="<?=(number_format($grandTotal * $order->exchange_rate, 2, '.', '')) ?>" required class="required" >
                </label>
              </div>
							
							
              <div class="col-sm-12">
                <label class="input"> <i class="icon-append fa fa-user"></i>
                  <input type="text" placeholder="Value" name="po_value" id="po_value"
                                           value="<?= number_format($order->po_value,2,'.','') ?>" required class="required">
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
              </span> </div>
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
          <button id="ad_nt" type="button" onclick="addNote()"
        class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Add Note</button>
          <button id="up_nt" type="button" style="display: none;" onclick="updateNote()"
        class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Update Note</button>
          </span> </div>
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
          <div id="compare_modal_content"> </div>
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

    function updateLabels(key, labelPerRoll) {
        var qty = parseInt($('#qty' + key).val(), 10);

        $('#label_for_orders' + key).val(qty * labelPerRoll);

    }

    function getShipingservic() {
        var ship_id = $("#c1").val();
        var ordernumber = '<?=$order->OrderNumber?>';
        var old_shipping = <?=$order->ShippingServiceID?>;
        var total = <?=$order->inctotal_for_page?>;

        $('#dvLoading').show();
        $.ajax({
            type: "post",
            url: "<?php echo main_url;?>order_quotation/Order/getShipService",
            cache: false,
            data: {ship_id: ship_id, ordernumber: ordernumber, old_shipping: old_shipping, total: total},
            success: function (data) {
                $('#dvLoading').hide();
                window.location.reload(true);
            }
        });
    }

    function get_payment(value, ordernumber) {
        if (value == 1) {
            return false;
        }
        window.location.href = '<?php echo main_url;?>order_quotation/Order/' + value + '/' + ordernumber + '/partpayment';
    }

    function refundamount(orderno, amount, user) {
        if (user == "no") {
            alert("Only SuperAdmin can refund payments. Please consult SuperAdmin.");
            return false;
        }

        var refundtype = $('#refundtype').val();
        if (refundtype == 1) {
            alert('Select Refund Amount');
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
					
					if(Top!=po_value){
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
                window.open('<?=URL?>theme/assets/po_attach/' + pofile);
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
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
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
	
	$(".die").each(function() {

		$this = $(this);
		var value = $this.val();
	 
		var serial = $this.attr('data-val');	
		var srctxt = $('#die_'+serial).val();
		var diecode = $('#hide_die_'+serial).val();
		$('#die_'+serial).autocomplete({
			source: function (request, response) {
				
				var urld =  mainUrl +"order_quotation/Order/getdie";
					 
				$.getJSON(urld,
											 {
					serial : serial,
					diecode: diecode,
					term: request.term
				}, response);
			}
			,
			select:function(evt, ui){ 
				$('#dis_'+serial).attr('data-newcode',ui.item.id);
				$('#dis_'+serial).show();
			}
		});
	});
	
	

</script>