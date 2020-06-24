<input type="hidden" id="order_number" value="<?= $quotation->QuotationNumber ?>">
<input type="hidden" id="method_on_page" value="quotation">

<input type="hidden" id="useer_id" value="<?= $quotation->UserID ?>">
<?php
$this->session->set_userdata('userid', $quotation->UserID);
?>
<input type="hidden" id="od_dt_price" value="">
<input type="hidden" id="od_dt_printed" value="">
<input type="hidden" id="designPrice" value="">
<input type="hidden" id="mypageName" value="quotation">
<input type="hidden" id="custId" value="<?= $quotation->UserID ?>">
<style>
    .btn-info {
        padding-left: 25px;
        padding-right: 25px;
    }

    .addnewline {
        background: #fff;
        background-color: rgb(255, 255, 255);
        color: #666 !important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn-info:hover {
        color: #fff !important;
    }

    .margin-adjust-raw {
        margin-top: 30px !important;
    }
    .btn-upload-artwork{

    }
</style>
<!-- End Navigation Bar-->
<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-body">
						<div class="row">
							<div class="col-md-4" style="display: flex">
								<div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
									<div class="card-header card-heading-text-two">QUOTATION INFORMATION</div>
									<div class="card-body">
										
										Quotation Number : <?= $quotation->QuotationNumber ?></br>
										<span>Source: <?= $quotation->Source.'-'.$quotation->ProcessedBy ?></span> </br>
									Date :<?= date('jS F Y', $quotation->QuotationDate) ?> &
									Time: <?= $quotation->time ?>

									<?
	$check = $this->db->query("select count(*) as total from quotationdetails where ManufactureID LIKE 'SCO1' and die_approve LIKE 'N' 	and  QuotationNumber LIKE '" . $quotation->QuotationNumber . "'")->row_array();
	$customdiecheck = $check['total'];

									?>
									<? if ($customdiecheck == 0) { ?>
									<p>
										Status : <?= $quotation->status ?>
									</p>
									<hr>
									<p class="labels-form" style="display: inline-flex">
										<span style="margin-top: 7px;margin-right: 7px;">Status :</span>
										<label class="select">
											<?php
	
												$option = $this->quotationModal->statusdropdown($quotation->QuotationStatus);
												if ($quotation->QuotationStatus == 13) {
											?>
											<select name="status">
												<?php if ($quotation->QuotationStatus == 13) { ?>
												<option value="">Completed</option>
												<?php } ?>


											</select>
											<?php } else {?>
											
											<?php //echo '<pre>'; print_r($option); echo '</pre>'; ?>
											<select name="status" id="status"
															onchange="chagestatus(this.value,<?= $quotation->QuotationID ?>)">
												<?php foreach ($option as $key => $val) { ?>
												<option value="<?= $key ?>" <?php if ($quotation->QuotationStatus == $key) { ?> selected <?php } ?>><?= $val?>	</option>
												<?php } ?>

											</select>
											<?php } ?>
											<i></i>
										</label>
									</p>

									
									<? } ?>

								</div>
							</div>
						</div>

						<div class="col-md-4" style="display: flex">
							<div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
								<div class="card-header card-heading-text-two">BILLING ADDRESS</div>
								<div class="card-body">
                                        <?= $quotation->BillingCompanyName ?></br>
                                        <?= $quotation->BillingFirstName . ' ' . $quotation->BillingLastName ?></br>
                                        <?= $quotation->BillingAddress1 ?></br>
                                        <?= $quotation->BillingAddress2 ?></br>
                                        <?= $quotation->BillingTownCity ?></br>
                                        <?= $quotation->BillingCountyState ?></br>
                                        <?= $quotation->BillingCountry ?></br>
                                        <?= $quotation->BillingPostcode ?></br>
                                        Email:<?= $quotation->Billingemail ?></br>
                                        T: <?= $quotation->Billingtelephone ?> |
                                        M: <?= $quotation->BillingMobile ?></br>


                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4" style="display: flex">
                                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%;">
                                    <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                                    <div class="card-body">
                                        <?= $quotation->DeliveryCompanyName ?></br>
                                        <?= $quotation->DeliveryFirstName . ' ' . $quotation->DeliveryLastName ?></br>
                                        <?= $quotation->DeliveryAddress1 ?></br>
                                        <?= $quotation->DeliveryAddress2 ?></br>
                                        <?= $quotation->DeliveryTownCity ?></br>
                                        <?= $quotation->DeliveryCountyState ?></br>
                                        <?= $quotation->DeliveryCountry ?></br>
                                        <?= $quotation->DeliveryPostcode ?></br>
                                        Email:<?= $quotation->Deliveryemail ?></br>
                                        T: <?= $quotation->Deliverytelephone ?> |
                                        M: <?= $quotation->DeliveryMobile ?></br>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 ">
                            <span class="labels-form">
                            <span class="float-right form-group" style="margin-right: 20px;margin-bottom: 20px;">
                            <label class="select">
                            <? $currency_options = $this->cartModal->get_currecy_options();
                                 $currency = $quotation->currency;
                                 $exchange_rate = $quotation->exchange_rate;
                                 
                                  $fetch_symbol = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$quotation->currency."'")->row_array();
                                  $symbol = $fetch_symbol['symbol'];
                             ?>

                <select class="form-control " onchange="quotaion_currency(this.value,'<?= $quotation->QuotationNumber ?>');">
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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="card-heading-title">
                                        <th width="5%" style="text-align: center;">

                                            <input type="checkbox" <?php if ($allCheck == 'Y') { ?> checked="checked"<?php } ?>
                                                   onchange="if(this.checked){checkAllDetails('<?= $quotation->QuotationNumber ?>','Y');}else{checkAllDetails('<?= $quotation->QuotationNumber ?>','N');}">

                                        </th>
                                        <th width="10%" class="text-center invoice-heading-text">Manufacturer ID</th>
                                        <th width="55%" class="text-center invoice-heading-text">Description</th>
                                        <th width="10%" class="text-center invoice-heading-text">Unit Price</th>
                                        <th width="10%" class="text-center invoice-heading-text">Quantity</th>
                                        <th width="5%" class="text-center invoice-heading-text">Ext.VAT</th>
                                        <th width="5%" class="text-center invoice-heading-text">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //echo '<pre>'; print_r($quotationDetails); echo '</pre>';
                                    $extPrice = 0;
                                    //                                    if ($quotation->QuotationStatus == 13) {
                                    //                                        include('quotation_lines.php');
                                    //                                    }
                                    //                                    else {
                                    ?>
                                    <?php
                                    foreach ($quotationDetails as $key => $quotationDetail) {
                                      
                                      
                                      $format = 'Sheets';
                                      $regex  = "/Roll/";

                                      if(preg_match($regex, $quotationDetail->ProductBrand, $match)){
                                        $format ='Rolls';
                                      } 
                      
                                      $query = $this->db->query(" SELECT SUM(labels) AS total from quotation_attachments_integrated WHERE Serial LIKE '".$quotationDetail->SerialNumber."'  ");
                                      $row = $query->row_array();	
                                      $no_of_labels =  $row['total'];
                      
                                      $Total_labels ='';
                                      $per_print = '';
                      
                                      $Total_labels = $quotationDetail->LabelsPerSheet * $quotationDetail->Quantity;
                                      if($quotationDetail->is_custom=="Yes"){
                                        $Total_labels = $quotationDetail->LabelsPerRoll * $quotationDetail->Quantity;
                                      }
                      
                                      if($quotationDetail->Printing=="Y" && $quotationDetail->regmark!="Y"){
                                        $Total_labels = $no_of_labels;
                                        if($format=="Rolls"){
                                          $Total_labels = $Total_labels * $quotationDetail->Quantity;
                                        }
                                      }
                                      
                                      $per_print = $Total_labels / $quotationDetail->Quantity;
                                     
                                      $lbss = 'Label';
                                      if($Total_labels > 1){
                                        $lbss = 'Labels';
                                      }
                                      
                                      
                                      
                                      $row_total_line = 0;
                                      
                                      

                                        if ($quotationDetail->ProductBrand == 'Roll Labels' && $quotationDetail->Printing == 'Y') {
                                            $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
                                        } else if ($quotationDetail->ProductBrand != 'Roll Labels' && $quotationDetail->Printing == 'Y') {

                                            $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
                                        } else {
                                            $extPrice = $extPrice + ($quotationDetail->Price);
                                        }

                                        if ($quotationDetail->ManufactureID == 'SCO1') {
                                            $carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);

                                            ?>
                                            <tr id="line<?= $key ?>">

                                                <td style="text-align: center;">
                                                    <div>
														
														 <? if ($quotationDetail->active == "c") { ?>
                                                        <img width="12" height="12"
                                                             src="<?= ASSETS ?>assets/images/blue-tick.png">
                                                    <? } else { ?>
                                                        <input type="checkbox" <?php if ($quotationDetail->active == 'Y'){ ?>
                                                               checked="checked"
                                                               <?php } ?>onchange="if(this.checked){selector(<?= $quotationDetail->SerialNumber ?>,'Y');}else{selector('<?= $quotationDetail->SerialNumber ?>','N');}">
                                                    <? } ?>
														
                                                       <!-- <input type="checkbox" <?php if ($quotationDetail->active == 'Y') { ?>  checked="checked" <?php } ?>
                                                               onchange="if(this.checked){selector(<?= $quotationDetail->SerialNumber ?>,'Y');}else{selector('<?= $quotationDetail->SerialNumber ?>','N');}">-->
														
                                                        <label for="hide"> </label>
                                                    </div>
                                                </td>

                                                <td><?= $quotationDetail->ManufactureID ?>  </td>
                                                <td class="text-left">
													 
                                                  <?php
                                              $mm = '';
                                          if($carRes[0]->height != null) {
                                            $mm=' x';
                                          }
													
                                          if($carRes[0]->shape!="Circle"){?>
                                                  <?php $carRes[0]->height = ($carRes[0]->height!=null)?($carRes[0]->height):($carRes[0]->width); 
                                                                          $mm=' x';
                                                  ?>
														
                                                  <?php } ?>
													
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
													
                                                  <br/><br/>
                                                  <button type="button" class="custom-die-cta"
                                                            onclick="editCustomDie(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,'quo')">
                                                    Edit
                                                    Custom Die
                                                  </button>
                                                  <input type="hidden" id="quo" value="quo">
                                                  <input type="hidden" id="serlno"
                                                           value="<?= $quotationDetail->SerialNumber ?>">
                                                  <?php if ($quotationDetail->discount == 0) { ?>
                                                        <button id="applydis<?= $key ?>" type="button"
                                                                class="custom-die-cta"
                                                                onclick="changeDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,'quo','<?= $quotationDetail->QuotationNumber ?>')">
                                                            Check Discount
                                                        </button>
                                                        <button id="deletedis<?= $key ?>" type="button"
                                                                class="custom-die-cta"
                                                                style="display: none"
                                                                onclick="deleteDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,'quo','<?= $quotationDetail->QuotationNumber ?>')">
                                                            Delete Discount
                                                        </button>
                                                    <?php } else { ?>
                                                        <button id="deletedis<?= $key ?>" type="button"
                                                                class="custom-die-cta"
                                                                onclick="deleteDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,'quo','<?= $quotationDetail->QuotationNumber ?>')">
                                                            Delete Discount
                                                        </button>
                                                        <button id="applydis<?= $key ?>" style="display: none"
                                                                class="custom-die-cta"
                                                                type="button"
                                                                onclick="changeDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,'quo','<?= $quotationDetail->QuotationNumber ?>')">
                                                            Check Discount
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" id="checkout_unit_price<?= $key ?>">-</td>
                                                <td><input type="text" id="1"
                                                           value="<?= $quotationDetail->Quantity ?>"
                                                           class="form-control input-number text-center allownumeric"
                                                           name="quant1">
                                                </td>
                                              <td class="text-center" id="checkout_price<?= $key ?>">
                                                <?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2,'.',''); ?>
                                                <?php $row_total_line += ($quotationDetail->Price * $exchange_rate);?>
                                              </td>
                                              
                                              <td class="padding-6 icon-tablee">
                                                <i class="fa fa-trash-o bt-delete"
                                                       onclick="deletenode(<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->Prl_id ?>','<?= $quotationDetail->ManufactureID ?>')"
                                                       id="deletenode1"></i>


                                                </td>
                                            </tr>
                                            <?php if (!empty($carRes)) { ?>
                                              <?php  include(APPPATH . 'views/order_quotation/checkout/cart_material.php'); ?>
                                            <?php }else{ ?>
                                      
                                             <!-- <tr>
                                                <td colspan="4"></td>
                                                <td class="text-center" colspan=""><b>Line Total</b></td>
                                                <td class="text-center" colspan=""><b><?=$row_total_line?></b></td>
                                                <td colspan=""></td>
                                              </tr>         -->
                                          <?php  } ?>


                                        <?php } elseif ($quotationDetail->ProductID == 0) { ?>

                                            <tr>
                                                <td style="text-align: center;">
													
													<? if ($quotationDetail->active == "c") { ?>
                                                        <img width="12" height="12"
                                                             src="<?= ASSETS ?>assets/images/blue-tick.png">
                                                    <? } else { ?>
                                                        <input type="checkbox" <?php if ($quotationDetail->active == 'Y'){ ?>
                                                               checked="checked"
                                                               <?php } ?>onchange="if(this.checked){selector(<?= $quotationDetail->SerialNumber ?>,'Y');}else{selector('<?= $quotationDetail->SerialNumber ?>','N');}">
                                                    <? } ?>
													
													
                                                 <!--   <input type="checkbox" <?php if ($quotationDetail->active == 'Y'){ ?>
                                                           checked="checked"
                                                           <?php } ?>onchange="if(this.checked){selector(<?= $quotationDetail->SerialNumber ?>,'Y');}else{selector('<?= $quotationDetail->SerialNumber ?>','N');}">--><br>
																									<?php echo $this->quoteModel->txt_for_plain_labels($quotation->Label); ?>
                                                </td>
                                                <td><input type="text"
                                                           class="form-control input-number text-center"
                                                           id="update_line_man<?= $key ?>"
                                                           value="<?= $quotationDetail->ManufactureID ?>"></td>
                                                <td><textarea id="update_line_des<?= $key ?>"
                                                              class="form-control input-number text-center" style="height:35px;"><?= $quotationDetail->ProductName; ?></textarea>
                                                </td>
                                                <td>
                                                    <input class="form-control input-number text-center allownumeric"
                                                           type="text" id="update_line_unit_price<?= $key ?>"
                                                           value="<?= ($quotationDetail->Price / $quotationDetail->Quantity) ?>"
                                                           placeholder="unit price"></td>
                                                <td><input type="text"
                                                           class="form-control input-number text-center allownumeric"
                                                           id="update_line_qty<?= $key ?>"
                                                           value="<?= $quotationDetail->Quantity ?>"
                                                           placeholder="quanity"></td>
                                              <td>
                                                <?= $symbol ?><?= $quotationDetail->Price * $exchange_rate ?>
                                                <?php $row_total_line += ($quotationDetail->Price * $exchange_rate);?>
                                              </td>
                                                <td class="padding-6 icon-tablee">
                                                  <?php if($quotation->QuotationStatus != 13){ ?>
                                                    <i class="fa fa-trash-o bt-delete"
                                                       onclick="deletenode(<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->Prl_id ?>','<?= $quotationDetail->ManufactureID ?>')"
                                                       id="deletenode1"></i>

                                                    <i class="fa fa-floppy-o bt-save"
                                                       onclick="updateQuotationNewLine(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,<?= $quotationDetail->CustomerID ?>)"></i>
                                                  <?php } ?>
                                              </td>

                                            </tr>

                                            <?php
                                        } else {

                                            $calco = $this->home_model->getProductCalculation($quotationDetail->ProductID, $quotationDetail->ManufactureID);
                                            //  print_r($calco);exit;
                                            ?>
                                            <tr>
                                                <input type="hidden" id="minroll<?= $key ?>"
                                                       value="<?= $calco['minRoll'] ?>">
                                                <input type="hidden" id="maxroll<?= $key ?>"
                                                       value="<?= $calco['maxRoll'] ?>">
                                                <input type="hidden" id="minlabel<?= $key ?>"
                                                       value="<?= $calco['minLabels'] ?>">
                                                <input type="hidden" id="maxlabel<?= $key ?>"
                                                       value="<?= $calco['maxLabels'] ?>">
                                                <input type="hidden" id="totalLabels<?= $key ?>"
                                                           value="<?= $quotationDetail->orignalQty ?>">
                                                <input type="hidden" id="totalQty<?= $key ?>" value="">           
                                                           
                                                <td style="text-align: center;">
                                                    <? if ($quotationDetail->active == "c") { ?>
                                                        <img width="12" height="12"
                                                             src="<?= ASSETS ?>assets/images/blue-tick.png">
                                                    <? } else { ?>
                                                        <input type="checkbox" <?php if ($quotationDetail->active == 'Y'){ ?>
                                                               checked="checked"
                                                               <?php } ?>onchange="if(this.checked){selector(<?= $quotationDetail->SerialNumber ?>,'Y');}else{selector('<?= $quotationDetail->SerialNumber ?>','N');}">
                                                    <? } ?>
																									
																									<?php /* <input type="checkbox" <?php if ($quotationDetail->active == 'Y'){ ?>
                                                               checked="checked"
                                                               <?php } ?>onchange="if(this.checked){selector(<?= $quotationDetail->SerialNumber ?>,'Y');}else{selector('<?= $quotationDetail->SerialNumber ?>','N');}"> */ ?>
                                                </td>
                                                <td class="text-center labels-form "><?= $quotationDetail->ManufactureID ?>
                                                    <br>
                                                     
                                                     <?php
        												$totalPerSheet = $quotationDetail->LabelsPerSheet;
        												$perRoll 	   = $quotationDetail->LabelsPerRoll;
        											?>
											
                                                    <?php if ($quotationDetail->regmark != 'Y') { ?>
                                                        <label class="select ">
                                                            <select name="printer" id="printer<?= $key ?>"
                                  onchange="changeCat(this.value,'<?= $quotationDetail->SerialNumber ?>','<?= $key ?>','<?= $quotationDetail->ProductBrand ?>','<?= $quotationDetail->ManufactureID ?>','<?= $totalPerSheet ?>','<?= $quotationDetail->pressproof ?>','<?= $quotation->UserID ?>','<?= $quotationDetail->ProductID ?>','<?= $quotationDetail->regmark ?>')"  tabindex="10" class="form-control">
                                                                <option value="N" <?php if ($quotationDetail->Printing != 'Y' || $quotationDetail->Printing != 'Yes') { ?> selected<? } ?>>
                                                                    Plain
                                                                </option>
                                                                <option value="Y" <?php if ($quotationDetail->Printing == 'Y' || $quotationDetail->Printing == 'Yes') { ?> selected<? } ?>>
                                                                    Printed
                                                                </option>
                                                            </select>
                                                            <i></i>
                                                        </label>
                                                    <?php } elseif ($quotationDetail->regmark == 'Y') { ?>
                                                        <!--<label class="select">
                                                        <!--deliver<label class="select">
                                                            <select name="printer" id="printer<?= $key ?>"
                                                                    tabindex="10">
                                                                <option value="Y">Plain</option>
                                                            </select>
                                                        </label>-->
                                                    <?php } ?>
                                                    <i></i>

                                                </td>
                                                <td>
                               <?
                                   if(preg_match('/Roll Labels/is',$quotationDetail->ProductBrand) && $quotationDetail->Printing=="Y" and $quotationDetail->regmark != 'Y'){
                                       
                                        if($quotationDetail->wound=='Y' || $quotationDetail->wound=='Inside'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}
                                    	 $labeltype = $this->home_model->get_printing_service_name($quotationDetail->Print_Type);
                                    	 $productname1  = explode("-",$quotationDetail->ProductCategoryName);
                                    	 $productname1[1] = str_replace("(","",$productname1[1]);
                                    	 $productname1[1] = str_replace(")","",$productname1[1]);
                                    	 $productname1[0] = str_replace("rolls labels","",$productname1[0]);
                                    	 $productname1[0] = str_replace("roll labels","",$productname1[0]);
                                    	 $productname1[0] = str_replace("Roll Labels","",$productname1[0]);
                                    	
                                    	 $productname1  = "Printed Labels on Rolls - ".str_replace("roll label","",$productname1[0]).' - '.$productname1[1];
                                    	 $completeName = ucfirst($productname1).' '.$wound_opt.' - Orientation '.$quotationDetail->Orientation.', ';
                                    	
                                    	 if($quotationDetail->FinishType == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
                                    	 else{  $labelsfinish = ' With Label finish : '.$quotationDetail->FinishType; }
                                    	 $completeName.= $labeltype.' '.$labelsfinish;
                                    	 $quotationDetail->ProductName = $completeName;
                                    	 
                                    	  $this->db->where('SerialNumber',$quotationDetail->SerialNumber);
                                    	  $this->db->update('quotationdetails',array('ProductName'=>$quotationDetail->ProductName));
                                    }
                                 ?>
                                 
     
     
                                                  <?= $quotationDetail->ProductName.' '.$this->quoteModel->txt_for_plain_labels($quotation->Label); ?>
                                                    <br/>

                                                    <?php if ($quotationDetail->regmark == 'Y') { ?>
                                                        <b>Printing Service (Black Registration Mark on Reverse)</b>
                                                    <?php } ?>

                                                </td>
                                                <!--<td id="labels<?/*= $key */ ?>"><?/*= $quotationDetail->orignalQty */ ?> </td>-->
                                                <td class="text-center" id="unit_price<?= $key ?>">
                                                  <?=$symbol?><?= number_format($quotationDetail->Price / $quotationDetail->Quantity, 2,'.','')?> 
                                                  <br>
                                                  Per 100 Labels
                                              
                                              </td>
                                                <input type="hidden" id="totalLabels<?= $key ?>"
                                                       value="<?= $quotationDetail->orignalQty ?>">
                                                <td style="text-align:center">
                                                    
                                                <input type="hidden" id="ogbatch<?= $key ?>" value="<?= $quotationDetail->orignalQty ?>">
                                                
                                                  <?php
                                                    $totalPerSheets = 0;
                                                    $totalPerSheets = $totalPerSheet = 	$quotationDetail->LabelsPerSheet;
                                                    $perRoll = $quotationDetail->LabelsPerRoll;
								  						
											
                                                    if($quotationDetail->is_custom!="No"){
                                                        $totalPerSheets =  $perRoll;
                                                    }
                                                  ?>
													
                                                  <div>
                                                    <?=$quotationDetail->Quantity.' '.$format?><br>
                                                    <?=$Total_labels.' '.$lbss?>
                                                    
                                                    
                                                    
                                                    <input type="<?php if($quotationDetail->Printing=="Y"){ ?>hidden<?php } ?>" onchange="updateTotalLabels(<?= $key ?>,this.value,<?= $totalPerSheets ?>)" id="qty<?= $key ?>" value="<?=$quotationDetail->Quantity ?>" <?php  if (($quotationDetail->sample == 'Sample' || $quotationDetail->sample == 'sample') ||  ($quotationDetail->ProductBrand == 'Roll Labels' && $quotationDetail->Printing == 'Y') || ($quotationDetail->regmark != 'Y' && $quotationDetail->Printing != 'N' )) { ?> readonly <?} ?> class="form-control input-number text-center allownumeric" name="quant1">
                                                    

                                                  </div>
                                                    <?php
                                                    $artQty = $this->user_model->countArtworkStatusFromQuotationIntegratedBYQuotationNumber($quotationDetail->SerialNumber);

                                                    ?>
                                                    <input type="hidden" id="arwtork_qty<?= $key ?>"
                                                           value="<?= $artQty[0]->totalQuantity ?>">
                                                </td>
                                                <td class="text-center">
                                                  <?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2,'.','') ?>
                                                  <?php $row_total_line += ($quotationDetail->Price * $exchange_rate);?>
                                              </td>

                                                <td class="padding-6 icon-tablee">
                                                    <?php if ($quotationDetail->active != "c") { ?>
                                                        <i class="fa fa-trash-o bt-delete"
                                                           onclick="deletenode(<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->Prl_id ?>','<?= $quotationDetail->ManufactureID ?>')"
                                                           id="deletenode1"></i>
																									<?php if(($quotationDetail->sample != 'Sample' && $quotationDetail->sample != 'sample') && ($quotationDetail->regmark != 'Y')){ ?>
                                                        <i class="fa fa-floppy-o bt-save" id="content_save<?= $key ?>"
                                                           onclick="updateQuotationDetailPrice(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->ProductBrand ?>','<?= $quotationDetail->ManufactureID ?>',<?= $totalPerSheets ?>,<?= $quotationDetail->pressproof ?>,<?= $quotation->UserID ?>,<?= $quotationDetail->ProductID ?>,'<?= $quotationDetail->regmark ?>')"></i>
																									<?php } ?>
																									
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                           
											
									<?php 
											
											$digitalCheck = ($quotationDetail->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';
											if($quotation->QuotationStatus == 13){ ?>
                                            
												      <?php if ($quotationDetail->Printing == 'Y' && $quotationDetail->regmark != 'Y') { ?>
                    <tr class="noneditable">
                      <td class="text-center"></td>
						<td class="text-center"></td>
                      <td><i class="mdi mdi-check"></i><span>
						  <?php if($quotationDetail->Print_Type=="Fullcolour"){ ?>
						  <?php $quotationDetail->Print_Type = "4 Colour Digital Process"; ?>
						  <?php } ?>
						  
                        <?= $quotationDetail->Print_Type ?>
                        </span>
                        <?php if ($quotationDetail->Print_Qty > 0) { ?>
                        <i class="mdi mdi-check"></i> <span>
                        <?= $quotationDetail->Print_Qty . '  Design' ?>
                        </span>
                        <?php } ?>
                        <?php if ($digitalCheck == 'roll') { ?>
                        <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Wound:</strong>
                        <?= $quotationDetail->wound ?>
                        </span> <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Orientation:</strong>
                        <?= $quotationDetail->Orientation ?>
                        </span> <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Finish:</strong>
                        <?= $quotationDetail->FinishType ?>
                        </span> <span class="invoice-bold"><strong
                                                                        style="font-size:12px;;">Press Proof:</strong>
                        <?= ($quotationDetail->pressproof == 1) ? 'Yes' : 'No' ?>
                        </span>
                        <?php } ?></td>
                      <td class="text-center"></td>
                      <td class="text-center"><?= $quotationDetail->Print_Qty ?></td>
                      <td class="text-center">
                        <? echo $symbol . (number_format($quotationDetail->Print_Total * $quotation->exchange_rate, 2, '.', '')); ?>
                        <?php $row_total_line += ($quotationDetail->Print_Total * $quotation->exchange_rate);?>
                      
                      </td>
                      <td class="text-center"></td>
                    </tr>
                    <?php } elseif ($quotationDetail->Printing == 'Y' && $quotationDetail->regmark == 'Y') { ?>
                    <tr>
                      <td></td>
                      <td><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <?php } ?>
												
												
                                      <?php } else{ ?> 
                                      <?php include(APPPATH . 'views/order_quotation/checkout/die_material.php'); ?>
                                      
                                      
                                      <?php if($digitalCheck=='roll' && $quotationDetail->Printing == 'Y' && $quotationDetail->regmark == 'N'){ ?>
                                      
                                      <?php include(APPPATH . 'views/order_quotation/checkout/pp_line.php'); ?>
                                                   
                                      
                                      <?php $row_total_line += $quotationDetail->qp_price;
                                            $extPrice += ($quotationDetail->qp_price);
                                      ?>
                                     <?php } ?>
                                      <?php } } ?>
                                      
                                      
                                      <tr>
                                        <td colspan="4"></td>
                                        <td class="text-center" colspan=""><b>Line Total</b></td>
                                        <td class="text-center" colspan=""><b><?=$symbol.number_format($row_total_line,2,'.','')?></b></td>
                                        <td colspan=""></td>
                                      </tr>                                                          
                                     
                                      
                                      
               <?php   } ?>
                                   
                                      <tr style="display: none" id="tr_for_nw_line">
                                        <td></td>
                                        <td><input class="form-control input-number text-center"
                                                   type="text" required id="new_line_man"></td>
                                        <td><textarea class="form-control input-number text-center allownumeric"
                                                      id="new_line_des" required style="height: 35px;"></textarea>
                                        </td>
                                        <td><input class="form-control input-number text-center allownumeric"
                                                   type="number" required id="new_line_unit_price"
                                                   placeholder="unit price"></td>
                                        <td><input class="form-control input-number text-center allownumeric"
                                                   type="number" required id="new_line_qty" placeholder="quanity"></td>
                                        <td></td>


                                        <td class="padding-6 icon-tablee">
                                          
                                         
                                          
                                            <i class="fa fa-floppy-o bt-save"
                                               onclick="quotationNewLine('<?= $quotationDetail->QuotationNumber ?>',<?= $quotation->UserID ?>)"></i>
                                        </td>
                                    </tr>
                                      
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">

                                <div class="col-md-6 pull-left">
                                    <?php if ($quotation->QuotationStatus != 13) { ?>
                                        <span id="showNwLine"><button type="button" onclick="showNwLine()"
                                                                      class="btn btn-info waves-light waves-effect addnewline">Add New Line</button></span>
                                        <span style="display: none" id="hideNwLine"><button type="button"
                                                                                            onclick="hideNwLine()"
                                                                                            class="btn btn-info waves-light waves-effect addnewline">Hide Line</button>
                                    </span>
                                        <button type="button" onclick="showSearch()"
                                                class="btn btn-info waves-light waves-effect addnewline">Add New Product
                                        </button>
                                        </span>
                                    <?php } ?>
                                </div>

                                <div class="col-md-6 pull-right">
                                    <table class="table table-bordered quote-price-details details-cart-table">
                                        <tr>
                                            <td>Total of Goods:</td>
                                            <td><?= $symbol ?><?= number_format($extPrice * $exchange_rate, 2,'.',''); ?></td>
                                        </tr>
                                        <?php
                                        $service = $quotation->ShippingServiceID;
                                        $county = $this->quotationModal->getShipingServiceName($service);
                                        $ShipingService = $this->quotationModal->getShipingService($county['CountryID']);
                                        ?>
                                        <tr>
                                            <td>Choose Delivery Option:</td>
                                            <td class="labels-form labels-filters-form">


                                               <?php include('Qshiping.php'); ?>


                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Service:</td>
											  <?php
												$delive = 0;
										        $delive =  number_format($quotation->QuotationShippingAmount / 1.2, 2,'.','');
											  ?>
                                            <td><?= $symbol ?><?= number_format( $delive * $exchange_rate, 2,'.','') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sub Total:</td>
                                            <td><?= $symbol ?><?php $grandPrice = $extPrice + $delive;
                                                echo number_format($grandPrice * $exchange_rate, 2,'.','') ?></td>
                                        </tr>
                                        <!--                                        <tr>-->
                                        <!--                                            <td>Discount:</td>-->
                                        <!--                                            <td>--><?php //$voucher = $this->user_model->calculate_total_printedroll_amount($quotation->QuotationNumber);?>
                                        <!--                                                --><?php //echo $symbol.number_format($voucher* $exchange_rate,2,'.',''); ?>
                                        <!--                                            </td>-->
                                        <!--                                        </tr>-->
                                        <?php if ($quotation->vat_exempt == 'yes') { ?>
																				<tr>
																					<td>VAT EXEMPT:</td>
																					<td>-<?= $symbol ?><?php echo number_format((($grandPrice * vat_rate) - $grandPrice) * $exchange_rate, 2,'.','') ?></td>
                                        </tr>
                                     <?php } else { ?>
																			
																			
																				<tr>
																					<td>VAT @ 20%:</td>
																					<td><?= $symbol ?><?php echo number_format((($grandPrice * vat_rate) - $grandPrice)  * $exchange_rate, 2,'.','');?>
																						
																					<?php $grandPrice = $grandPrice + number_format((($grandPrice * vat_rate) - $grandPrice)  , 2,'.','');?>
																					
																					</td>
                                        </tr>
                                       <?php } ?>



                                        <tr>
                                            <td>Grand Total:</td>
                                            <!-- --><?php /*$grandPrice = $grandPrice - $voucher;*/ ?>
                                            <td><?= $symbol ?><?= number_format(($grandPrice) * $exchange_rate, 2,'.','') ?></td>
                                        </tr>
                                        <?php
                                        $subPrice = array('QuotationTotal' => $grandPrice);
                                        $this->db->where('QuotationNumber', $quotation->QuotationNumber);
                                        $this->db->update('quotations', $subPrice);
                                        ?>
                                        <tr>
                                            <td>Print Quotation:</td>
                                            <td>
                                                <div class=""> Hide Prices:
                                                    <input class="hider hideprice" id="hide" type="checkbox"
                                                           name="hideprice">
                                                    <label for="hide"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <? $site = ($quotation->site == "" || $quotation->site == "en") ? "English" : "French"; ?>
                                            <td class="labels-form labels-filters-form">
                                                <label class="select margin-bottom-0">
                                                    <select id="language" class="PrinterCopier" tabindex="10">
                                                        <option value="en" <? if ($site == "English") { ?> selected="selected" <? } ?>>
                                                            English
                                                        </option>
                                                        <option value="fr" <? if ($site == "French") { ?> selected="selected" <? } ?>>
                                                            French
                                                        </option>
                                                    </select>
                                                    <i></i> </label>
                                            </td>
                                            <td>
                                                <button type="button"
                                                        onclick="printpdf('<?= $quotation->QuotationNumber ?>');"
                                                        class="btn btn-info waves-light waves-effect">Print Quotation
                                                </button>
                                                <?
                                                $check2 = $this->db->query("select count(*) as total from quotationdetails where ManufactureID LIKE 'SCO1' and  QuotationNumber LIKE '" . $quotation->QuotationNumber . "'")->row_array();
                                                $customdiecheck2 = $check2['total'];
                                                $allowvalue = ($customdiecheck2 == 0) ? 2 : 1;
                                                ?>

                                                <input type="hidden" value="<?= $allowvalue ?>" id="allow"/>
                                                <?php if ($quotation->QuotationStatus == 17 || $quotation->QuotationStatus == 8) { ?>

                                                    <input class="btn btn-info waves-light waves-effect"
                                                           style="background-color:green;color:white" type="button"
                                                           onclick="generateorder2('<?= $quotation->QuotationNumber ?>');"
                                                           value="Generate Order">


                                                <?php } ?>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- en row -->
            </div>
        </div>
        <!-- en row -->
        <!-- Label Finder Starts  -->
        <div class="">
            <div class="" id="placeSearch">

            </div>
        </div>
        <!-- en row -->
        <!-- Label Finder Ends  -->
        <!-- Products View Start  -->
        <div>
            <div id="ajax_material_sorting"> <!--style="margin: 25px 14px;"-->

            </div>
        </div>
        <div class="" id="order_detail_material" style="background-color: #ffffff !important;margin-bottom: 20px !important;">

        </div>
        <!-- Products View End  -->
        <div class="row" style="margin:0px -25px !important;">
            <div class="col-md-6" style="display: flex;">
                <div class="card m-b-30" style="width: 100%">
                    <div class="card-header card-heading-text-three">
                        <span class="pull-left heading-card-margin">SALE OPERATOR NOTES	 - <?= $quotation->QuotationNumber ?></span>
                        <span class="pull-right">
                <button type="button" onclick="showQuotationNotePopup()"
                        class="btn btn-primary waves-light waves-effect">Add New Note</button>
                </span></div>
                    <div class="card-body no-padding">
                        <table class="table table-bordered">
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
                                        <input type="hidden" id="note_title<?= $key ?>" value="<?= $note->noteTitle ?>">
                                    </td>
                                    <td><?= $note->noteText ?>
                                        <input type="hidden" id="note_des<?= $key ?>" value="<?= $note->noteText ?>">
                                    </td>
                                    <td>
                                        <button onclick="showUpdatePopup(<?= $key ?>,<?= $note->noteID ?>)"
                                                class="btn btn-default btn-number add-line-btn fa-2x" type="button">
                                            <i class="mdi mdi-pencil-box-outline"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-6" style="display: flex;">
                <div class="card m-b-30" style="width: 100%">
                    <div class="card-header card-heading-text-three">
                        <span class="pull-left heading-card-margin">CUSTOMER NOTES	 - <?= $quotation->QuotationNumber ?></span>
                        <!--    <span class="pull-right">
                    <button type="button" onclick="showQuotationNotePopup()"
                            class="btn btn-primary waves-light waves-effect">Add New Note</button>
                    </span>-->
                    </div>
                    <div class="card-body no-padding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Note Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($declineNotes as $key => $note) { ?>
                                <tr>
                                    <td><?= $note->noteDate ?></td>
                                    <td><?= $note->title ?>
                                        <input type="hidden" id="note_title<?= $key ?>" value="<?= $note->title ?>">
                                    </td>
                                    <td><?= $note->description ?>
                                        <input type="hidden" id="note_des<?= $key ?>" value="<?= $note->description ?>">
                                    </td>
                                    <td>
                                        <button onclick="showDeclinePopup(<?= $key ?>,<?= $note->ID ?>)"
                                                class="btn btn-default btn-number add-line-btn fa-2x" type="button">
                                            <i class="mdi mdi-pencil-box-outline"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Note Add Popup Start -->
    <div class="modal fade bs-example-modal-md" id="add_note_popup" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content blue-background">
                <div class="modal-header checklist-header">
                    <div class="col-md-12">
                        <h4 class="modal-title checklist-title" id="myLargeModalLabel">Quotation Notes</h4>
                        <p class="timeline-detail text-center">Please enter the notes here.</p>
                    </div>
                </div>
                <div class="modal-body p-t-0">
                    <div class="panel-body">


                        <style>
                            .custom-die-input {
                                width: 97%;
                                border: 1px solid #a3e8ff;
                                border-radius: 4px;
                                height: 33px;
                                color: #666666;
                                margin-bottom: 4px;
                                padding-left: 6px;
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
                            <div class="divstyle" style="margin-bottom:5px;"><b class="label"></b>
                                <input type="text" name="die_title" id="die_title" required
                                       placeholder="Enter Title Here"
                                       class=" custom-die-input" style="width: 97%;">

                            </div>


                        </div>


                        <div class="col-12 no-padding">
                            <textarea class="form-control blue-text-field" name="die_note" required rows="5"
                                      id="die_note"
                                      placeholder="Enter Description Here"></textarea>
                        </div>


                        <span class="m-t-t-10 pull-right m-r-3">
                            <button  id="current_note_id" type="button"  data-dismiss="modal" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Cancel</button>
                        <button id="ad_nt" type="button" onclick="addNote()"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="margin-right: 10px;">Add Note</button>
                        <button id="up_nt" type="button" style="display: none;" onclick="updateNote()"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="margin-right: 10px;">Update Note</button>

                                
                            
                            
                    </span>


                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Note Add Popup Start End -->
    <!-- Note Add Popup Start -->
    <div class="modal fade bs-example-modal-md" id="decline_note_popup" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content blue-background">
                <div class="modal-header checklist-header">
                    <div class="col-md-12">
                        <h4 class="modal-title checklist-title" id="myLargeModalLabel">Quotation Notes</h4>
                        <p class="timeline-detail text-center">Please enter the notes here.</p>
                    </div>
                </div>
                <div class="modal-body p-t-0">
                    <div class="panel-body">


                        <style>
                            .custom-die-input {
                                width: 97%;
                                border: 1px solid #a3e8ff;
                                border-radius: 4px;
                                height: 33px;
                                color: #666666;
                                margin-bottom: 4px;
                                padding-left: 6px;
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

                            <input type="hidden" id="dec_note_id">
                            <div class="divstyle" style="margin-bottom:5px;"><b class="label"></b>
                                <input type="text" name="dec_title" id="dec_title" required
                                       placeholder="Enter Title Here"
                                       class=" custom-die-input" style="width: 97%;">

                            </div>


                        </div>


                        <div class="col-12 no-padding">
                            <textarea class="form-control blue-text-field" name="dec_note" required rows="5"
                                      id="dec_note"
                                      placeholder="Enter Description Here"></textarea>
                        </div>


                        <span class="m-t-t-10 pull-right m-r-3">

                        <button id="up_nt" type="button" onclick="updateDeclineNote()"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Update Note</button>
                    </span>


                    </div>
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

                        <div id="compare_modal_content">

                        </div>


                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Compare Popup End -->
    <? include(APPPATH . 'views/order_quotation/artwork/artwork_popup.php') ?>

    <script>

        function checkAllDetails(quotationNumber, val) {
            $.ajax({
                type: "post",
                url: mainUrl + "order_quotation/Quotation/checkAllDetails",
                cache: false,
                data: {quotationNumber: quotationNumber, val: val},
                dataType: 'html',
                success: function (data) {
                    window.location.reload();
                }
            });
        }

        function updateTotalLabels(key, value, labelPerRoll) {
            $('#totalLabels' + key).val(value * labelPerRoll);
        }

        function selector(id, val) {
            $.ajax({
                type: "post",
                url: mainUrl + "search/search/selectLine",
                cache: false,
                data: {id: id, val: val},
                dataType: 'html',
                success: function (data) {
                    // window.location.reload();
                }
            });
        }

        function showSearch() {
            $.ajax({
                type: "post",
                url: mainUrl + "search/search/getSearch",
                cache: false,
                data: {'category': 'A4'},
                dataType: 'html',
                success: function (data) {
                    var msg = $.parseJSON(data);

                    //showAndHideTabs('format_page');
                    $('#ajax_material_sorting').show();
                    $('#lf-pos').empty()
                    $('#placeSearch').html(msg.html);
                    $('#placeSearch').show();
                    filter_data('autoload', '', 'quotation');
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
      
      
      

    </script>
