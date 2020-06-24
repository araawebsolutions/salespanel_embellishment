<style>

	.f_err{
		display: none;
	}
</style>
<?
$currency = $quotation->currency;
$exchange_rate = $quotation->exchange_rate;

$fetch_symbol = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$quotation->currency."'")->row_array();
$symbol = $fetch_symbol['symbol'];
?>
<input type="hidden" id="order_number" value="<?= $quotation->QuotationNumber ?>">
<input type="hidden" id="method_on_page" value="quotation">

<input type="hidden" id="useer_id" value="<?= $quotation->UserID ?>">
<input type="hidden" id="od_dt_price" value="">
<input type="hidden" id="od_dt_printed" value="">
<input type="hidden" id="mypageName" value="quotation">
<!-- End Navigation Bar-->
<div class="wrapper">
  <div class="container-fluid">
    <div class="">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-body">
            <div class="row">

              <div class="col-md-4">
                <div class="card enquiry-card enquiry-card-bix-box-second">
                  <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                  <div class="card-body">
                    <?= $quotation->BillingCompanyName ?><br>
                    <?= $quotation->BillingFirstName . ' ' . $quotation->BillingLastName ?><br>
                    <?= $quotation->BillingAddress1 ?><br>
                    <?= $quotation->BillingAddress2 ?><br>
                    <?= $quotation->BillingTownCity ?><br>
                    <?= $quotation->BillingCountyState ?><br>
                    <?= $quotation->BillingCountry ?><br>
                    <?= $quotation->BillingPostcode ?><br>
                    Email:<?= $quotation->Billingemail ?><br>
                    T: <?= $quotation->Billingtelephone ?> |
                    M: <?= $quotation->BillingMobile ?><br>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card enquiry-card enquiry-card-bix-box-second">
                  <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                  <div class="card-body">
                    <?= $quotation->DeliveryCompanyName ?><br>
                    <?= $quotation->DeliveryFirstName . ' ' . $quotation->DeliveryLastName ?><br>
                    <?= $quotation->DeliveryAddress1 ?><br>
                    <?= $quotation->DeliveryAddress2 ?><br>
                    <?= $quotation->DeliveryTownCity ?><br>
                    <?= $quotation->DeliveryCountyState ?><br>
                    <?= $quotation->DeliveryCountry ?><br>
                    <?= $quotation->DeliveryPostcode ?><br>
                    Email:<?= $quotation->Deliveryemail ?><br>
                    T: <?= $quotation->Deliverytelephone ?> |
                    M: <?= $quotation->DeliveryMobile ?><br>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card enquiry-card enquiry-card-bix-box-second">
                  <div class="card-header card-heading-text-two">PAYMENT METHOD</div>
                  <div class="card-body">

                    <form action="<?=main_url?>order_quotation/Quotation/generateQuotationToOrder" method="post" onsubmit="return ifnullss();" >
                      <div class="row">
                        <div class="col-md-11  labels-form" style="margin: 0px auto">
                          <label class="select">
                            <?php
  $data = array(
  'name'        => 'quoteNo',
  'id'          => 'quoteNo',
  'value'		=> $quotation->QuotationNumber,
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
       echo form_dropdown('payment',$option,'','id="payment" name="payment" onchange=chagePayment(this.value,"'.$quotation->QuotationID.'")');
                            ?>
                            <i></i>
                          </label>
                          <span style="color:crimson; font-size:12px"  id="f_err" class="f_err">Please Choose</span>
                        </div>
                      </div>


                      <div class="row" style="margin: 10px 0px;">
                        <?php if($quotation->vat_exempt == 'yes'){?>
                        <div class="col-md-8 labels-form"
                             style="padding-left: 16px;">

                          <input type="text" id="vatnumber" class="form-control input-number text-center allownumeric"  style="height: 35px;text-align: left !important; padding: 14px;">
                          <input type="hidden" id="vat_cat" value="<?= $quotation->BillingCountry ?>">
                        </div>
                        <div class="col-md-2" style="margin-left: 17px;">
                          <input  class="btn waves-light waves-effect addnewline"  id="vat_validator"  value="Verify" type="button">
                        </div>
                        <?php }?>
                        <input type="hidden" id="dcountry" value="<?= $quotation->DeliveryCountry ?>">
																					
                        <input type="hidden" id="email_valid" value="<?= $quotation->Deliveryemail ?>">
                        <input type="hidden" value="N" id="vat_pass" name="vat_pass"/>
                        <input type="hidden" name="quoteNo" value="<?=$quotation->QuotationNumber?>">
                        <input type="hidden" value="AA" name="QuoteWebsite" id="QuoteWebsite" />
                      </div>
                      <div class="row">
                        <div class="col-md-6" style="margin-left: 16px;">
                          <input  class="btn btn-success waves-light waves-effect" value="Finish" type="submit" >
                        </div>
                      </div>
                    </form>
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
                <table class="table table-bordered table-striped text-center">
                  <thead>
                    <tr class="card-heading-title">
                      <th width="10%" class="text-center invoice-heading-text">Manufacturer ID</th>
                      <th width="55%" class="text-center invoice-heading-text">Description</th>
                      <th width="10%" class="text-center invoice-heading-text">Labels</th>
                      <th width="10%" class="text-center invoice-heading-text">Quantity</th>
                      <th width="5%" class="text-center invoice-heading-text">Ext.VAT</th>
                    </tr>
                  </thead>
                  <tbody>


                    <?php //echo '<pre>'; print_r($quotationDetails); echo '</pre>'; ?>
                    <?php
                    $extPrice = 0;
								   								 $to_goods = 0;
                               
                               
                               
																  	
                               foreach ($quotationDetails as $key => $quotationDetail) {
                                 
                                 $format = 'Sheets';
                                 $regex  = "/Roll/";

                                 if(preg_match($regex, $quotationDetail->ProductBrand, $match)){
                                   $format =($quotationDetail->Quantity > 1)?'Rolls':'Roll';
                                 } 
            
                      
                                 $Total_labels ='';
                                 $per_print = '';
                      
                                 if($quotationDetail->ProductBrand=='Integrated Labels'){ 
                                   $Total_labels = $quotationDetail->Quantity;
                                 } else{
                                   $Total_labels = $quotationDetail->orignalQty;
                                 } 
                                 
                                 
                                 
                                 $per_print = $Total_labels / $quotationDetail->Quantity;
                                     
                                 $lbss = 'Label';
                                 if($Total_labels > 1){
                                   $lbss = 'Labels';
                                 }
                                      
                                 $row_total_line = 0;
                                      

                                 if($quotationDetail->ProductBrand == 'Roll Labels' && $quotationDetail->Printing == 'Y'){
                                   $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
                                 }
                                 else if($quotationDetail->ProductBrand != 'Roll Labels' && $quotationDetail->Printing == 'Y'){
                                   
                                   $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
                                 }
                                 else{
																				
                                   $extPrice = $extPrice + ($quotationDetail->Price );
                                 }

                                 if ($quotationDetail->ManufactureID == 'SCO1') {
                                   $carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);
                    ?>
                    <tr>
                      <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?></td>
                      <td class="text-left">
                        <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?>|
                        <b>Format: </b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?>|
                        <b>Size: </b><?= (isset($carRes[0])) ? $carRes[0]->width : '' . ' mm *' ?><?= (isset($carRes[0]) && $carRes[0]->height == null) ? $carRes[0]->width . ' mm' : (isset($carRes[0])) ? $carRes[0]->height : '' . ' mm' ?>
                        |
                        <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?>
                        <b>Across: </b><?= (isset($carRes[0])) ? $carRes[0]->across : '' ?>
                          |
                        <b>Around: </b><?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
                        | <b>Corner
                        Radious: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
                        |
                        <b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>

                      </td>
                      <td><?= $quotationDetail->Quantity ?></td>
                      <td><?= $quotationDetail->Quantity ?></td>
                      <td><?= $symbol ?><?=number_format($quotationDetail->Price * $exchange_rate, 2) ?>
                        
                        <?php $row_total_line += ($quotationDetail->Price * $exchange_rate);?>
                        <? $to_goods += $quotationDetail->Price ?>
                      </td>

                    </tr>
                    <?php
                      $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);


                                   $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                                  // echo '<pre>'; print_r($assoc); echo '</pre>';
                                   foreach ($assoc as $rowp){
                    ?>
                    <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
                    <? $materialpriceinc = $materialprice * 1.2; 
                    
                    
                    ?>
                    
                      <?php $sho = ''; if($carRes[0]->format =='Roll'){ $sho =  $rowp->rolllabels;} else { $sho =  ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate);} ?>
                    
                    <tr>
                      <td class="text-center labels-form"><?=$rowp->material?></td>
                      <td class="text-left"><i class="mdi "></i><?= $this->user_model->get_mat_name($rowp->material); ?></td>
                      
                      <td id="labels0"><?=$symbol ?><?= number_format(($materialprice / $sho) * $exchange_rate,3 ) ?></td>
                      <td>
                        
                        <?= $rowp->qty ?>
                        
                        <?php 
                        if($carRes[0]->format=="Roll"){
                          echo ($rowp->qty > 1)?'Rolls':'Roll';
                        }else{
                          echo ($rowp->qty > 1)?'Sheets':'Sheet';
                        }
                        ?>
                 
                        <br>
                        <?php if($carRes[0]->format =='Roll'){ echo $rowp->rolllabels.' labels';} else { echo ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate).' labels';} ?>
                      
                      </td>
                      <td><?=$symbol?><? echo number_format($materialprice * $exchange_rate, 2,'.',''); ?>
                        <?php  $to_goods += $materialprice; ?>
                      </td>

                    </tr>
                    
                    
                    
                     <?php if(($rowp->labeltype == 'printed' && $carRes[0]->format != 'Roll') || ($carRes[0]->format == 'Roll' )){ ?>   

                    <?php //echo '<pre>'; print_r($assoc);  ?>

                    <tr>
                      <td class="invoicetable_tabel_border"></td>
                      <td class="invoicetable_tabel_border" align="left">
                        <i class="mdi mdi-check"></i>
                        <span>
                          <?php 
                                       
                          if($rowp->printing=="Mono"){ ?>
                          <?php $rowp->printing = "Monochrome - Black Only"; ?>
                          <?php } ?>
    
                          <?= $rowp->printing ?>
                        </span>
                        <?php if ($rowp->designs > 0) { ?>
                        <i class="mdi mdi-check"></i> 
                        <span>
                          <?php $des = ($rowp->designs > 1 )?"Designs":"Design"; ?>
                          <?= $rowp->designs .' '. $des ?>
                        </span>
                        <?php } ?>
                        <?php 
                      
                          if ($carRes[0]->format == 'Roll') { ?>
                        <span class="invoice-bold">
                          <strong style="font-size:12px;">Wound:</strong>
                          <?php if(!empty($assoc[0]->wound)) echo $assoc[0]->wound;?>
                        </span> 
                        <span class="invoice-bold">
                          <strong style="font-size:12px;">Orientation:</strong>
                          <?php if(!empty($assoc[0]->core)) echo $assoc[0]->core; ?>
                        </span> 
                        
                        <?php if($rowp->finish!=""){ ?>
                        <span class="invoice-bold">
                          <strong style="font-size:12px;">Finish:</strong>
                          <?= $rowp->finish ?>
                        </span> 
   <?php } ?>
                        <?php } ?>

                      </td>
               
                      <td class="text-center invoicetable_tabel_border" > 
                        <?php 
                          if ($carRes[0]->format != 'Roll'){
                        ?>
                        <?=$symbol ?>5.32
                        <br>
                        Per Design
                        <?php } ?>
                      </td>
    
                      <td class="text-center invoicetable_tabel_border">
                        <?php 
                          if($quotationDetail->regmark != 'Y' && $carRes[0]->format != 'Roll'){ 
                            $des=  ($rowp->designs > 1 )?"Designs":"Design";
                            echo $rowp->designs.' '.$des;
                        ?>
                        <?  }?>
                        <br>
                      </td>
          
  
                      <td class="text-center invoicetable_tabel_border" align="center"><?=$symbol ?><?= number_format(($quotationDetail->Print_Total * $exchange_rate), 2) ?></td>
             
                    </tr>
                    <?php } ?>
                    
                    
                    <?php }?>
                    
                   
                          
                    
                     
                    <?php } else{?>
                    <tr>
                      <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?></td>
                      <td class="text-left"><?=   $quotationDetail->ProductName ?></td>
                      <td id="labels0">
                       
                        
                        <?=$symbol?><?= number_format(($quotationDetail->Price / $Total_labels) * $exchange_rate, 3,'.','')?> 
                        <?php if($quotationDetail->ProductID != '0'){ ?>
                        <br>
                        Per Label
                        <?php } ?> 
                      </td>
                      
                      <td>
                        <?php if($quotationDetail->ProductID == '0'){ ?>
                        <?=$quotationDetail->Quantity;?><br>
                        <?php } else{?>
                        
                        <?=$quotationDetail->Quantity.' '.$format?><br>
                        
                        <?php if($quotationDetail->sample=='Sample'){?>
                        
                        <?php if($quotationDetail->ProductBrand != 'Roll Labels'){?>
                          <?=$quotationDetail->LabelsPerSheet.' Labels'?>
                        <?php } ?>
                        
                        
                        <?php } else{ ?>
                        
                        
                        <?=$Total_labels.' '.$lbss?>
                        
                        <?php } }?>
                      </td>
                      
                      <td><?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2) ?>
                        <?php $row_total_line += ($quotationDetail->Price * $exchange_rate);?>
                        <? $to_goods += $quotationDetail->Price ?></td>

                    </tr>
                    
                    
                    <?php 
                                   if($quotationDetail->qp_proof=="Y"){
                                     include(APPPATH . 'views/order_quotation/quotation/pp_line_no_edit.php'); 
                                     $row_total_line += number_format($quotationDetail->qp_price * $quotation->exchange_rate,2);
                                     $to_goods +=   number_format($quotationDetail->qp_price * $exchange_rate , 2);
                                     
                                   }
                    
                    ?>
                    
                    
                    <?php if($quotationDetail->Printing == 'Y' && $quotationDetail->regmark !='Y'){?>
                    <tr>
                      <td class="text-center labels-form"></td>
                      <?php include('generate_text_line.php'); ?>
                      <td id="labels0">
                                      <?= $symbol ?><?php echo number_format(5.32 * $exchange_rate, 2)?><br>
                                      Per Design
                      </td>
                      <td><?php 
      $des_gn = '';                           
      if($quotationDetail->Print_Qty > 1){
        $des_gn ='Designs';
      }else{
        $des_gn ='Design';
      }
                                                             
      $des_free = '';                           
      if($quotationDetail->Free > 1){
        $des_free ='Designs';
      }else{
        $des_free ='Design';
      }
        ?>
        
        <?= $quotationDetail->Print_Qty.' '.$des_gn?> <br>
                      
        <?php if(!preg_match($regex, $quotationDetail->ProductBrand, $match)){ ?>
        (<?= $quotationDetail->Free.' '.$des_free?> Free)
        <?php } ?></td>
                      <td><?= $symbol ?><?=number_format($quotationDetail->Print_Total * $exchange_rate, 2);
                            $to_goods +=   number_format($quotationDetail->Print_Total, 2);?>
                        
                        <?php $row_total_line += ($quotationDetail->Print_Total * $quotation->exchange_rate);?>
                      </td>

                    </tr>
                    <?php }elseif($quotationDetail->Printing == 'Y' && $quotationDetail->regmark =='Y'){?>
                    <tr>
                      <td></td>
                      <td align="left"><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                    

                    <?php     } ?>
                    
                                                         
                                     
 <tr>
              <td colspan="3"></td>
              <td class="text-center" colspan=""><b>Line Total</b></td>
              <td class="text-center" colspan=""><b><?=$symbol.number_format($row_total_line,2,'.','')?></b></td>
            </tr>                                                          
                             
                                <?php     }
                               }?>

                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6 pull-left"></div>
                <div class="col-md-6 pull-right">
                  <table class="table table-bordered quote-price-details details-cart-table">
                    <tr>
                      <td>Total of Goods:</td>
                      <td><?= $symbol ?><?= number_format($to_goods * $exchange_rate ,2,'.','') ?></td>
                    </tr>
                    <?php
                        $service = $quotation->ShippingServiceID;
                        $county = $this->quotationModal->getShipingServiceName($service);
                        $ShipingService = $this->quotationModal->getShipingService($county['CountryID']);
												
                        //echo '<pre>'; print_r($county); echo '</pre>';
                        //echo '<pre>'; print_r($ShipingService); echo '</pre>';
                    ?>
                  <?php /* ?>  <tr>
                      <td>Choose Delivery Option:</td>
                      <td class="labels-form labels-filters-form">


                        <label class="select margin-bottom-0">
                            
                    <!-- AA21 STARTS -->
                          <?php
                          $this->session->set_userdata("countryid",$quotation->DeliveryCountry);
                          $this->session->set_userdata("off_postcode",$quotation->DeliveryPostcode);
                          $offshore = $this->product_model->offshore_delviery_charges();
                          $delivery_width = "100%;";
                          if($quotation->DeliveryCountry == 'United Kingdom' && ($offshore['status'] != true))
                          {
                              $delivery_width = "82%";
                          ?>
                              <select id="deliveryCourier" class="" name="deliveryCourier"  onChange="updateCourier('<?php echo $quotation->QuotationNumber;?>');"  style="width: 17%; float: left;">
                                  <option value="" <?php if($quotation->quotationCourier == ''){echo "selected='selected'";}?>>Select Courier Service</option>
                                  <option value="Parcelforce" <?php if($quotation->quotationCourier == 'Parcelforce'){echo "selected='selected'";}?>>Parcelforce</option>
                                  <option value="DPD" <?php if($quotation->quotationCourier == 'DPD'){echo "selected='selected'";}?>>DPD</option>
                              </select>
                          <?php
                          }
                          ?>
                          <!-- AA21 ENDS -->
                          
                          
                          
                            <!-- AA21 STARTS -->
                          <select name="printer" onChange="update_shiping(this.value,'<?= $quotation->QuotationNumber ?>');" class="PrinterCopier nlabelfilter" tabindex="10" style='width:<?php echo $delivery_width; ?>'>
                          <!-- AA21 ENDS -->
                          
                          
                                  onChange="update_shiping(this.value,'<?= $quotation->QuotationNumber ?>');"
                                  class="PrinterCopier nlabelfilter" tabindex="10">
														<?php $basiccharges = 0.00;

                                  foreach ($ShipingService as $res) {
                                    $selected = '';
															
															
                                    if ($res['ServiceID'] == $quotation->ShippingServiceID) {
                                      echo $quotation->ShippingServiceID.'----'.$res['ServiceID'];
                                      $basiccharges = $res['BasicCharges'];
                                      $selected = ' selected="selected" ';
                                    }
                                    
                                    if ($total_invat < 25.00 && $res['ServiceID'] == 20) {
                                      $basiccharges = 6.00;
                                    } else {?>
														
														
														
                            <?php } ?>
														
                            <option value="<?= $res['ServiceID'] ?>" <?= $selected ?> >
                              <?php
                                      if ($res['BasicCharges'] == '0.00') {
                                        echo $res['ServiceName'];
                                      } else {
                                        echo $res['ServiceName'] . ' &nbsp;' . $symbol . number_format(($res['BasicCharges']  / 1.2) * $exchange_rate, 2, '.', '');
                                                                    }
                                                                    ?>
                            </option>
														
                            <?php }?>
								   						
														
                          </select>
                          <i></i>
                        </label>
                        

                      </td>
                    </tr><?php */ ?>
                    <tr>
                     <?php
                      $delive = 0;

                      // AA21 STARTS
                        $delive =  number_format($quotation->QuotationShippingAmount / vat_rate, 2,'.','');
                        // if($OrderInfo['PaymentMethods'] != 'Sample Order')
                        // {
                            if( ($quotation->quotationCourier == 'DPD') && ($quotation->quotationCourierCustomer == 'Parcelforce') ){
                                $delive =  number_format( (($quotation->QuotationShippingAmount)+1) / 1.2, 2,'.','');
                            }
                            else if( ($quotation->quotationCourier == 'Parcelforce') && ($quotation->quotationCourierCustomer == 'DPD') ){
                                $delive =  number_format( (($quotation->QuotationShippingAmount)-1) / 1.2, 2,'.','');
                            }
                            else
                            {
                                $delive =  number_format( ($quotation->QuotationShippingAmount) / 1.2, 2,'.','');
                            }
                        // }
                      // AA21 ENDS

                      ?>
                      
                      
                      <td>Delivery Service:</td>
                      <td><?= $symbol ?><?= number_format($delive * $exchange_rate, 2) ?></td>
                    </tr>
                    <tr>
                      <?php $grandPrice =  $to_goods  + $delive;?>
                      <td>Sub Total:</td>
                      <td><?= $symbol.number_format($grandPrice * $exchange_rate, 2) ?></td>
                    </tr>
																			
                    <?php if ($quotation->vat_exempt == 'yes') { ?>
                    <tr>
                      <td>VAT EXEMPT:</td>
                      <td>-<?= $symbol ?><?php echo number_format((($grandPrice * vat_rate) - $grandPrice) * $exchange_rate, 2,'.','') ?></td>
                    </tr>
                    <?php } else { ?>
																			
																			
                    <tr>
                      <td>VAT @ 20%:</td>
                      <td> <?  $vatvalue = (($grandPrice*1.2) - $grandPrice);
                                  echo number_format($vatvalue* $exchange_rate, 2,'.',''); ?>
                      </td>
                    </tr>
                    <?php } ?>
                      
                    
                    <tr>
                      <td>Grand Total:</td> <? $grandtotalfinal = $grandPrice * 1.2; ?>
                      <td><?= $symbol ?><?= number_format($grandtotalfinal* $exchange_rate,2,'.','') ?></td>
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
  <div class="row">
    <div class="row" id="placeSearch">

    </div>
  </div>
  <!-- en row -->
  <!-- Label Finder Ends  -->
  <!-- Products View Start  -->
  <div class="row">
    <div class="row " id="ajax_material_sorting">

    </div>
  </div>
  <div class="row" id="order_detail_material">

  </div>
  <!-- Products View End  -->

</div>


<script>
  function confirmVat(){
    let vatNumber = $('#vatnumber').val();
    let vatCountry = $('#vat_cat').val();

    $.ajax({
      url: mainUrl+'order_quotation/Quotation/validate_vat',
      type:"POST",

      dataType: "json",
      data: {  vatNumber: vatNumber,country:vatCountry},
      success: function(data){

      }
    });
  }
  
   // AA21 STARTS
    function updateCourier(QNumber)
    {
        $('#aa_loader').show();
        var QNumber = QNumber;
        var deliveryCourier = $("#deliveryCourier option:selected").val();
        if(QNumber)
        {
          $.ajax({
              type: "post",
              url: "<?php echo main_url;?>order_quotation/Order/updateQuotationDetail",
              cache: false,
              data: {"QNumber": QNumber,"deliveryCourier":deliveryCourier},
              success: function (data) {
                  $('#aa_loader').hide();
                  window.location.reload(true);
              }
          });
        }
    }
  // AA21 ENDS
  
  
  
</script>