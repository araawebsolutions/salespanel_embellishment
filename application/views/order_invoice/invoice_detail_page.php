<!-- for autoload-->
<script src="<?= ASSETS ?>assets/js/datepicker.js"></script>
<script>(function(n,t,i,r){var u,f;n[i]=n[i]||{},n[i].initial={accountCode:"AALAB11111",host:"AALAB11111.pcapredict.com"},n[i].on=n[i].on||function(){(n[i].onq=n[i].onq||[]).push(arguments)},u=t.createElement("script"),u.async=!0,u.src=r,f=t.getElementsByTagName("script")[0],f.parentNode.insertBefore(u,f)})(window,document,"pca","//AALAB11111.pcapredict.com/js/sensor.js")</script>    
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
</style>
<!-- End Navigation Bar-->
<?php //echo '<pre>'; print_r($order); ?>
<input type="hidden" id="method_on_page" value="order">
<input type="hidden" id="order_number" value="<?= $AccountDetails[0]->OrderNumber ?>">
<input type="hidden" id="useer_id" value="<?= $AccountDetails[0]->UserID ?>">
<?php
$this->session->set_userdata('userid', $AccountDetails[0]->UserID);
?>
<input type="hidden" id="od_dt_price" value="">
<input type="hidden" id="od_dt_printed" value="">
<input type="hidden" id="designPrice" value="">
<input type="hidden" id="mypageName" value="order">
<input type="hidden" id="custId" value="<?= $AccountDetails[0]->UserID ?>">
<div class="wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
<?php 
    //print_r($AccountInfo);

foreach ($AccountInfo as $order) 
{
   $OrderNumber = $order->OrderNumber; 

 ?>

  <div class="col-md-4" style="display: flex">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">INVOICE INFORMATION</div>
                  <?php //echo '<pre>'; print_r($order); echo '</pre>'; ?>
                  <div class="card-body"> Invoice No :
                      <Number>
                    <?php echo $invoice; ?> 
                    </Number>
                    <br>                
                    <span>Order No:
                    <Number>
                      <?= $order->OrderNumber ?>
                    </Number>
                  </span>
                    <br>
                    
                  
                    <span>Source:
                    <? 
                                if($order->Source =="website" || $order->Source =="Website"){
                                    echo "Website ";
                                  }
                                  elseif($order->PaymentMethods == "SampleOrder"){
                                   echo "Request Samples ";
                                  }else{
                                    echo "Back office ";
                                  }
                                                                                  
                                   if($order->PaymentMethods=="chequePostel")  $order->PaymentMethods="Cheque or BACS";
                                    echo ' '.$order->PaymentMethods;
                    
                    ?>
                    </span> <br>
                   <span>Date:
                    <?php echo date('jS F Y', $order->OrderDate); ?> 
                  </span>
                    <br>
                    <span>Time:<?php echo date('h:i:s A', $order->OrderDate); ?></span>
                    <br>
                    <? if($order->OrderStatus==7 || $order->OrderStatus==8 ){?>
                    Tracking No: <?php echo $order->OrderDeliveryCourier;?> <?php echo $order->DeliveryTrackingNumber; ?> <br>
                    Dispatch Date:
                    <?php if($order->DispatchedDate) { echo date("d-m-Y",$order->DispatchedDate); }?>
                    <br>
                    Dispatch Time:
                    <?php if($order->DispatchedTime) { echo date("h:i:s A",$order->DispatchedTime); }?>
                    <? } ?>
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
                    <b>Country:</b> <?= $order->BillingCountyState ?>
                    </br>
                   <b>Postcode:</b>  <?= $order->BillingCountry ?>
                    </br>
                   <b>Postcode:</b>  <?= $order->BillingPostcode ?>
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
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display: flex">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                  <div class="card-body">
                   <b>Company Name:</b>  <?= $order->DeliveryCompanyName ?>
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
                   <b>Postcode:</b>  <?= $order->DeliveryPostcode ?>
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
                  </div>
                </div>
              </div>
                     
             
      <?php }?>
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
                      <th class="text-center invoice-heading-text" width="50%">Description</th>
                      <th class="text-center invoice-heading-text text-center" width="5%">Labels</th>
                      <th class="text-center invoice-heading-text" width="10%">Quantity</th>
                      <th class="text-center invoice-heading-text text-center" width="5%">Ext.VAT</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                <?php 

     //echo '<pre>';
     //print_r($AccountDetails);
      $totalPrice = 0;
                                
               $exchange_rate = $order->exchange_rate;
                $symbol = $this->orderModal->get_currecy_symbol($order->currency);

    foreach ($AccountDetails as $detail) {
       
    $product_detail = $this->user_model->getproductdetail($detail->ProductID);
                                        $permissions = $this->settingmodel->checkpermissions($detail->SerialNumber, $product_detail, $order->OrderStatus, $order->editing);
                                        $totalPrice = $totalPrice + ($detail->Price + $detail->Print_Total);
                                        $product = $this->user_model->getproductdetail($detail->ProductID);

                                        $digitalCheck = ($detail->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';
                                        ?>

                   <tr>
                      
                     
                      <td class="text-center labels-form"> 
                        <?php echo $detail->ManufactureID;?>
                          </td>
                           <td><?= $detail->orderProductName .' '.$this->quoteModel->txt_for_plain_labels($order->Label);?>
                      <?  $files = $this->quoteModel->get_integrated_attachments($detail->SerialNumber);   
                            if(count($files) > 0){ ?>
                           
                           <table>
            <tr>
              <td><? foreach($files as $row){ ?>
                <span style="float:left; margin-left:10px; padding:2px;"> <a href="https://www.aalabels.com/theme/integrated_attach/<?=$row->file?>" target="_blank">
                <?
                if($detail->source=='flash' || $row->source=='plain'){?>
                <img width="30" height="" id="prod_image" src="https://www.aalabels.com/designer/media/thumb/<?=$row->Thumb?>" />
                <? }else if(preg_match('/.pdf/is',$row->file)){?>
                <img width="30" height="" id="prod_image" src="https://www.aalabels.com/theme/site/images/pdf.png" />
                <?  }else{ ?>
                <img width="30" height="" id="prod_image" src="https://www.aalabels.com/theme/integrated_attach/<?=$row->file?>" />
                <?  } ?>
                </a>
                
                <p class="ellipsis">
                  <? if(preg_match("/Roll Labels/i",$detail->ProductBrand)){ $type = 'Rolls';}else{$type = 'Sheets';}?>
                  <? if($row->qty > 0){?>
                  <small>
                  <?=$type?>
                  :</small> <small>
                  <?=$row->qty?>
                  </small><br />
                  <? }?>
                  <? if($row->labels > 0){?>
                  <small>Labels:</small> <small>
                  <?=$row->labels?>
                  </small>
                  <? }?>
                </p>
                </span>
                <? }?></td>
            </tr>
          </table>
          <? } ?>
                        <?php if ($detail->regmark == 'Y') { ?>
                        <br/>
                        <b>Printing Service (Black Registration Mark on Reverse)</b>
                        <?php } ?></td>
                      <td class="text-center"><?php if($detail->labels == 0){
                            echo $detail->Quantity;
                        }else{
                          echo  $detail->labels;
                        }
                      ?></td>
                      <td  class="text-center"><?= $detail->Quantity ?>
                       </td>
                     
                    
                      <td class="text-center"><? echo $symbol . (number_format($detail->Price * $order->exchange_rate, 2, '.', '')); ?></td>
                      
                    </tr>
                     <? $detail_view = @$this->QuotationModal->check_product_extra_detail($detail->ManufactureID);
                      if($detail_view['prompt']=='yes'){?>
                    <tr>
                      
                      <td class="text-center"><b style="color:green;font-size:12px;">Product Note</b></td>
                      <td><b style="color:green;font-size:12px;">
                        <?=$detail_view['detail']?>
                        </b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      
                    </tr>
                    
                    
                    <? } ?>
                    <?php if ($detail->Printing == 'Y' && $detail->regmark != 'Y') { ?>
                    <tr>
                      <td class="text-center"></td>
                      
                      <td><i class="mdi mdi-check"></i><span>
                        <?php if($detail->Print_Type=="Fullcolour"){ ?>
                        <?php $detail->Print_Type = "4 Colour Digital Process"; ?>
                        <?php } ?>
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
                      <td class="text-center">
                          <?
                        if ($detail->FinishTypePricePrintedLabels != '' && $detail->total_emb_cost != 0){
                            echo $symbol . (number_format(($detail->Print_Total * $order->exchange_rate)-$detail->total_emb_cost, 2, '.', ''));
                        } else {
                            echo $symbol . (number_format($detail->Print_Total * $order->exchange_rate, 2, '.', ''));
                        }
                          ?>
                      </td>
                      
                    </tr>
                    <?php } ?>

                <?php
                if ($detail->Printing == 'Y' && $detail->FinishTypePricePrintedLabels != '') { 
                ?>
                    <tr>
                        <td></td>
                        <td colspan="4"><b> Finish </b></td>
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
                                    <td class="text-center"></td>
                                    <td></td>
                                    <td class="text-center">
                                        <?php
                                        echo $symbol." ".number_format(($parsed_title_price+$plate_cost1 * $exchange_rate), 2) ;
                                        ?>
                                    </td>
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
                                <td class="text-center"></td>
                                <td></td>
                                <td class="text-center">
                                    <?php
                                    echo $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2);
                                    ?>
                                </td>
                            </tr>

                        <?php } else { //For Sequential Data ?>

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
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <?= $symbol." ".number_format(($parsed_title_price * $exchange_rate), 2) ?>
                                </td>
                            </tr>

                        <?php  }
                        $index++;
                    } ?>
                <?php } ?>
                    
            <?php } ?>
                  </tbody>
                </table>
                </div>
                <div class= "row">
                <div class="col-md-6"></div>
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
                      <td>Delivery Total: </td>
                      <td><? echo $symbol .(number_format(($order->OrderShippingAmount / vat_rate) * $order->exchange_rate, 2, '.', '')); 
                      $totalPrice = $totalPrice + number_format(($order->OrderShippingAmount / vat_rate) * $order->exchange_rate, 2, '.', '');
                        
                        
                        ?></td>
                    </tr>
                    <?php $grandTotal = $totalSubs + ($order->OrderShippingAmount / vat_rate); ?>
                  
                  <?php 
                  if ($order->voucherOfferd == 'Yes') {
                    $discount_applied_in = $order->voucherDiscount;
                    $discount_applied_ex = $order->voucherDiscount / 1.2;
                  }else{
                    $discount_applied_in = 0.00;
                    $discount_applied_ex = 0.00;
                  }
                  ?>
                  <tr>
                    <td>Discount:</td>
                    <td><?php $discount = $discount_applied_in; ?>
                    <? echo $symbol . (number_format($discount * $order->exchange_rate, 2, '.', '')); ?>
                    </td>
                  </tr>

                  <? if($order->vat_exempt == 'yes') { ?>
                  <tr>
                    <td>VAT Exempt:</td>
                    <td>- <? $vatvalue = ($totalPrice * vat_rate) - $totalPrice;     
                    echo $symbol . (number_format($vatvalue * $order->exchange_rate, 2, '.', '')); ?>
                    </td>
                  </tr>

                  <? }else{ ?>

                  <tr>
                    <td>VAT @20%:</td>
                    <td><? $vatvalue = ($totalPrice * vat_rate) - $totalPrice;     
                    echo $symbol . (number_format($vatvalue * $order->exchange_rate, 2, '.', '')); ?>
                    </td>
                  </tr>
                  <?php } ?>


                  <tr>
                  <td>Grand Total:</td>
                  <td><?php  $grandTotal = ($grandTotal* vat_rate) - $discount;
                  if($order->vat_exempt == 'yes') { 
                  $grandTotal = $grandTotal/1.2;   
                    
                  }else{
                  $grandTotal = number_format($grandTotal,2,'.',''); 
                  }
                  $finalAmount = $grandTotal;
                  echo $symbol . (number_format($grandTotal * $order->exchange_rate, 2, '.', ''));
                  ?>
                  <input type="hidden" id="gtTotal" value="<?php echo (number_format($grandTotal * $order->exchange_rate, 2, '.', '')) ?>"></td>
                  </tr>
                  
                      </tbody>
                  </table>
                  <br>
                  <tr>
                      <td><button type="button" onclick="printinvoice('<?= $invoice ?>');" class="btn btn-info waves-light waves-effect pull-right"> Print Invoice </button></td>
                      <br>
                  </tr>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row --> 
      </div>
    </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row --> 
      </div>
    </div>
    <!-- end row --> 
     
    </div>
  

  <!-- end container --> 
</div>




<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script> 
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

  
  <script  type="text/javascript">
    
    function printinvoice(id) {

        window.location.href = '<?=main_url ?>Invoice/printinvoice/'+ id;
    }
  </script>
    