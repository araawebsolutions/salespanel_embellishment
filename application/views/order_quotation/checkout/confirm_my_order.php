<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <div class="card-box ">

                  <div class="row m-t-t-10">


                  </div>
                  <?php //echo '<pre>'; print_r($order); echo '</pre>'; ?>

                  <div class="card">
                    <div class="card-body">
            <div class="row">
              <div class="col-md-4" style="display: flex">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">ORDER INFORMATION</div>
                
                  <div class="card-body"> 
                    Order: <Number><?= $order[0]->OrderNumber ?></Number><br>
                    <span>Source: 
                     <? 
                         if($order[0]->Source =="website" || $order[0]->Source =="Website"){
                            echo "Website ";
                          }
                          elseif($order[0]->PaymentMethods == "SampleOrder"){
                           echo "Request Samples ";
                          }else{
                            echo "Back office ";
                          }
                                                                          
                           if($order[0]->PaymentMethods=="chequePostel")  $order[0]->PaymentMethods="Cheque or BACS";
                           echo ' '.$order[0]->PaymentMethods;
                    
                    ?>
                    
                    </span> <br>
                    Date & Time:
                    <?= date('jS F Y', $order[0]->OrderDate) ?>
                    <?= $order[0]->time ?>
                   <!-- <hr>
                    <p class="labels-form" style="display: inline-flex"> <span style="margin-top: 7px;margin-right: 7px;">Status :</span>
                      <label class="select">
                        <select class="select-design-adjst form-control"
                                                        onchange="chageMyStatus(this.value,'<?= $order[0]->OrderID ?>')">
                          <?php foreach ($status as $key => $state) { ?>
                          <option value="<?= $key ?>" <?php if ($order[0]->OrderStatus == $key) { ?> selected <?php } ?>>
                          <?= $state ?>
                          </option>
                          <?php } ?>
                        </select>
             
                        <i></i> </label>
             <?php //echo '<pre>'; print_r($status); echo '</pre>'; ?>
                    </p>-->
      
                  
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display: flex;">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                  <div class="card-body">
                      <b>Company Name:</b> <?= $order[0]->BillingCompanyName ?>
                      </br>
                      <b> Name:</b> <?= $order[0]->BillingFirstName . ' ' . $order[0]->BillingLastName ?>
                      </br>
                      <b>Address 1:</b> <?= $order[0]->BillingAddress1 ?>
                      </br>
                      <b>Address 2:</b> <?= $order[0]->BillingAddress2 ?>
                      </br>
                      <b>City:</b> <?= $order[0]->BillingTownCity ?>
                      </br>
                      <b>County/State:</b> <?= $order[0]->BillingCountyState ?>
                      </br>
                      <b>Country:</b>  <?= $order[0]->BillingCountry ?>
                      </br>
                      <b>Postcode:</b>  <?= $order[0]->BillingPostcode ?>
                      </br>
                      <b>Email:</b>
                      <?= $order[0]->Billingemail ?>
                      </br>
                      <b>T:</b>
                      <?= $order[0]->Billingtelephone ?>
                      <b>M:</b>
                      <?= $order[0]->BillingMobile ?>
                      </br>

                      <br>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display: flex">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                  <div class="card-body">
                      <b>Company Name:</b>  <?= $order[0]->DeliveryCompanyName ?>
                      </br>
                      <b>Name:</b> <?= $order[0]->DeliveryFirstName . ' ' . $order[0]->DeliveryLastName ?>
                      </br>
                      <b>Address 1:</b> <?= $order[0]->DeliveryAddress1 ?>
                      </br>
                      <b>Address 2:</b> <?= $order[0]->DeliveryAddress2 ?>
                      </br>
                      <b>City:</b> <?= $order[0]->DeliveryTownCity ?>
                      </br>
                      <b>County/State:</b> <?= $order[0]->DeliveryCountyState ?>
                      </br>
                      <b>Country:</b> <?= $order[0]->DeliveryCountry ?>
                      </br>
                      <b>Postcode:</b>  <?= $order[0]->DeliveryPostcode ?>
                      </br>
                      <b>Email:</b>
                      <?= $order[0]->Deliveryemail ?>
                      </br>
                      <b>T:</b>
                      <?= $order[0]->Deliverytelephone ?>
                      <b> | M:</b>
                      <?= $order[0]->DeliveryMobile ?>
                      </br>

                      <br>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


                    <?php


                    ?>

                    <div class="row m-t-t-10">
                        <div class="col-12">

                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr class="card-heading-title">
                                    <th class="text-center invoice-heading-text">Manufacturer ID</th>
                                    <th class="text-center invoice-heading-text">Description</th>
                                    <th class="text-center invoice-heading-text" width="10%">Unit Price</th>
                                    <th class="text-center invoice-heading-text" width="10%">Quantity</th>
                                    <th class="text-center invoice-heading-text">Ext.VAT</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php
  $exchange_rate = $order[0]->exchange_rate;
                    $symbol = $this->orderModal->get_currecy_symbol($order[0]->currency); 
                                    //echo '<pre>'; print_r($order); echo '</pre>';
                                    $lineTotal = 0;
                      $totalPrice = 0;
                    //  echo "<pre>";
                     // print_r($orderDetails);

                                    foreach ($orderDetails as $orderDetail) {

                                    $lineTotal = $lineTotal + number_format($orderDetail->Price * $exchange_rate, 2,'.','') + number_format
                                        ($orderDetail->Print_Total * $exchange_rate, 2,'.','');
                                    ?>
                                    <tr>
                                        <td class="text-center"><strong><?= $orderDetail->ManufactureID ?></strong></td>
                                       <td>
                                            
                                            <?php if ($orderDetail->ManufactureID == 'SCO1') {
                                             $carRes = $this->user_model->getCartOrderData($orderDetail->SerialNumber);
                                        
                                        
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
                                            

                                            
                                            <?php } else{?>
                                            <?= $orderDetail->ProductName.' '.$this->quoteModel->txt_for_plain_labels($order[0]->Label); ?>
                                            <?php } ?>
                                        
                                        
                                            
                                            
                                            
                                            
                                        </td>
                                        <td class="text-center">
                                          
                                      <?=$symbol?>
                                       <?php if($orderDetail->ProductID == '0' || $orderDetail->ManufactureID == 'SCO1'){ ?>
                                          <?= number_format( ($orderDetail->Price / $orderDetail->Quantity) * $exchange_rate,3,'.',''); ?>
                                       <?php } else{?>
                                           <?= number_format( ($orderDetail->Price / $orderDetail->labels) * $exchange_rate,3,'.','');?>
                                       <?php  } ?>
                                      
                                        
                                        <br>
                                        <?php
                                         if($orderDetail->ProductID != '0')
                                              echo "Per Labels"; ?>
                                          
                                        </td>
                                        <td class="text-center"><?= $orderDetail->Quantity ?>
                                          <?php if($orderDetail->ProductBrand == 'Roll Labels' ){ 
                                               echo 'Rolls'.'<br>';
                                               echo $orderDetail->labels.'&nbsp;Labels';
                                         }else{
                                                if($orderDetail->ProductID != '0'){
                                                  echo "Sheets".'<br>';
                                                  if($orderDetail->ProductBrand == 'Integrated Labels' ){ 
                                                    echo $orderDetail->Quantity.'&nbsp;Labels';
                                                  }else{
                                                     echo $orderDetail->labels.'&nbsp;Labels';
                                                  }
                                                }
                                              }
                                          ?>
                                      </td>
                                      <td class="text-center"><?=$symbol?><?= number_format($orderDetail->Price * $exchange_rate, 3,'.','') ?>
                                      </td>
                                  </tr>
                                  
                                 
                                  
                                                                    
                                  <?php if ($orderDetail->ManufactureID == 'SCO1') {
                                           $carRes = $this->user_model->getCartOrderData($orderDetail->SerialNumber);
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
                                    <td class=""><?= $this->user_model->get_mat_name($rowp->material); ?></td>
                                    <td class="text-center" id="labels0">-</td>
                                    <td class="text-center"><?= $rowp->qty ?>
                                      <?php 
                                    if($carRes[0]->format == 'Roll'){
                                      echo ($rowp->qty > 1)?"Rolls":"Roll";
                                    }else{
                                      echo ($rowp->qty > 1)?"Sheets":"Sheet";
                                    }
                                      ?>
                                      <br>
                                      <?php if($carRes[0]->format == 'Roll'){ ?>
                                      <?= $rowp->rolllabels ?> Labels
                                      <?php } else{?>
                                       <?= ($carRes[0]->around * $carRes[0]->across)  * $rowp->qty?> Labels
                                      <?php } ?>
                                      
                                    </td>
                                    <td class="text-center"><?=$symbol?><? echo number_format($materialprice * $exchange_rate, 2,'.',''); ?>
                                      <?php $lineTotal +=  number_format($materialprice * $exchange_rate, 2,'.','');?>
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
                                  <?php } ?>
                                  
                            
                                  
                                    <?php if ($orderDetail->Printing == 'Y' && $orderDetail->regmark !='Y') { ?>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td>
                                                <i class="mdi mdi-check"></i>
                                                <span>
                                                     <?php if($orderDetail->Print_Type == "Fullcolour"){ 
                                                              $orderDetail->Print_Type = "4 Colour Digital Process"; 
                                                           } ?>
                                                      
                                                      <?= $orderDetail->Print_Type ?></span>
                                                <i class="mdi mdi-check"></i>
                                                <span><?= $orderDetail->Print_Design ?></span>
                                                <?php if($orderDetail->ProductBrand =='Roll Labels'){?>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Wound:</strong> <?= $orderDetail->Wound ?></span>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Orientation:</strong><?= $orderDetail->Orientation ?></span>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Finish:</strong> <?= $orderDetail->FinishType ?></span>
                                                <!--<span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Press Proof:</strong> <?= ($orderDetail->pressproof == 0)?'No':'Yes' ?></span>-->
                                            <?php }?>
                                            </td>
                                            <td class="text-center"> 
                                            <?php 
                                                  if($orderDetail->ProductBrand =='Roll Labels'){echo '---'; } 
                                                  else { echo $symbol.'5.32';}
                                            ?>
                                              <?php if($orderDetail->ProductBrand !='Roll Labels'){ ?>
                                            <br>
                                            Per Design
                                              <?php } ?>
                                             
                                             </td>
                                            <td class="text-center">
                                              
                                              
                                              
                                              
                                                <?php 
      $des_gn = '';                           
      if($orderDetail->Print_Qty > 1){
        $des_gn ='Designs';
      }else{
        $des_gn ='Design';
      }
                                                             
      $des_free = '';                           
      if($orderDetail->Free > 1){
        $des_free ='Designs';
      }else{
        $des_free ='Design';
      }
          ?>
        
        <?= $orderDetail->Print_Qty.' '.$des_gn?> <br>
                      
        <?php if($orderDetail->ProductBrand != "Roll Labels" ){ ?>
        (<?= $orderDetail->Free.' '.$des_free?> Free)
        <?php } ?>
                                              
                                              
                                            </td>
                                            <td class="text-center"><?=$symbol?><?= number_format(($orderDetail->Print_Total * $exchange_rate), 2,'.','')?></td>
                                        </tr>
                                    <?php }elseif($orderDetail->Printing == 'Y' && $orderDetail->regmark =='Y'){ ?>

                                        <tr>
                                            <td></td>
                                            <td><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td> 
                                        </tr>
                                <?php } }?>
                                  
                                  
                                   <?php 
                                           if($orderDetail->odp_proof=="Y"){
                                             include(APPPATH . 'views/order_quotation/order_detail/pp_line_no_edit.php'); 
                                             
                                             $lineTotal +=  number_format($orderDetail->odp_price * $exchange_rate , 2,'.','');
                                     
                                           }
                    
                    ?>
                                   
                                  
                                  <?php
                                  $delive = 0;
                                    
                                    // AA21 STARTS
                                    if($order[0]->PaymentMethods != 'Sample Order')
                                    {
                                        $delive =  number_format($order[0]->OrderShippingAmount / vat_rate, 2,'.','');
                                        if( ($order[0]->OrderDeliveryCourier == 'DPD') && ($order[0]->OrderDeliveryCourierCustomer == 'Parcelforce') ){
                                            $delive =  number_format( (($order[0]->OrderShippingAmount)+1) / 1.2, 2,'.','');
                                        }
                                        else if( ($order[0]->OrderDeliveryCourier == 'Parcelforce') && ($order[0]->OrderDeliveryCourierCustomer == 'DPD') ){
                                          $delive =  number_format( (($order[0]->OrderShippingAmount)-1) / 1.2, 2,'.','');
                                        }
                                        else
                                        {
                                          $delive =  number_format( ($order[0]->OrderShippingAmount) / 1.2, 2,'.','');
                                        }
                                    }
                                    // AA21 ENSD
                                  ?>
                                  
                                  
                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>LINE TOTAL</td>
                                    <td><?=$symbol?><?=number_format($lineTotal,2,'.','');?></td>
                                </tr>
                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>
                                      <!-- AA21 STARTS -->
                                        DELIVERY 
                                        <?php
                                        if( isset($order[0]->OrderDeliveryCourier) && $order[0]->OrderDeliveryCourier != '' )
                                        {
                                            echo "(".$order[0]->OrderDeliveryCourier.")";
                                        }
                                        ?>
                                        <!-- AA21 ENDS -->    
                                    </td>
                                    <td><?=$symbol?><?= number_format( $delive * $exchange_rate, 2,'.','') ?></td>
                                </tr>

                                  <?php
                                  if ($order[0]->voucherOfferd == 'Yes') {
                                      $discount_applied_in = $order[0]->voucherDiscount;
                                      $discount_applied_ex = $order[0]->voucherDiscount / 1.2;
                                  }else{
                                      $discount_applied_in = 0.00;
                                      $discount_applied_ex = 0.00;
                                  }
                                  $lineTotal = $lineTotal - $discount_applied_ex;

                                  ?>
                                  <tr class="text-bold">
                                      <td colspan="3"></td>
                                      <td>Discount:</td>
                                      <td><?php $discount = $discount_applied_in; ?>
                                          <? echo $symbol . (number_format($discount_applied_ex * $order[0]->exchange_rate, 2, '.', '')); ?>
                                      </td>
                                  </tr>


                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>SUBTOTAL</td>
                                    <td><?=$symbol?><?= number_format(($lineTotal = $lineTotal + $delive * $exchange_rate), 2,'.','')
                                        ?></td>
                                </tr>
                                  <?php if($order[0]->vat_exempt=="yes"){ ?>
                                  <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>VAT EXEMPT</td>
                                    <td>-<?=$symbol?><?php echo number_format((($lineTotal * vat_rate) - $lineTotal) ,2,'.','') ?></td>
                                  </tr>
                                  <?php } else{ ?>
                                  <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>VAT @ 20%</td>
                                    <td><?=$symbol?><?php echo number_format(((($lineTotal * vat_rate) - $lineTotal)  ),2,'.','') ?>
                                      <?php //$lineTotal = $lineTotal +  number_format((($lineTotal * vat_rate - $lineTotal) ),2) ?>
                                    </td>
                                  </tr>
                                  <?php } ?>
                                  
                                  <?php
                                  if($order[0]->vat_exempt=="no"){
                                    $lineTotal = number_format(($lineTotal * vat_rate),2,'.','');
                                  }
                                  ?>
                                  
                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>GRAND TOTAL</td>
                                    <td><?=$symbol?><?=number_format($lineTotal,2,'.','');?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 m-t-t-10">
                    <span class="pull-right">
                    <a style="margin-right: 10px;" href="<?= main_url ?>order_quotation/order/getOrderDetail/<?= $order[0]->OrderNumber ?>"
                       class="btn btn-outline-dark waves-dark waves-effect btn-countinue btn-print1">View Order <i
                                class="mdi mdi-book-open"></i></a>
                    </span></div>
                    </div>




                </div>


            </div>


        </div>


    </div>

</div>






