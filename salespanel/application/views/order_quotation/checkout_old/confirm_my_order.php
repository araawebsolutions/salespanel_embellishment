<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <div class="card-box ">

                    <div class="row m-t-t-10">

<!--                        <div class="col-md-6"><img src="../assets/images/logo.png" width="162" height="65"-->
<!--                                                   alt="Quotation Logo">-->
<!--                            <p class="adress-delivery">AA Labels, 23 Wainman Road, Peterborough, PE2 7BU</p>-->
<!--                        </div>-->
<!---->
<!---->
<!--                        <div class="col-md-6 delivery-info">-->
<!--                            <li><strong>Quotation #: AAQ12345</strong></li>-->
<!--                            <li>Phone Number: 01733 588 390</li>-->
<!--                            <li>Email Address: customercare@aalabels.com</li>-->
<!--                            <li>VAT #: GB 945 028 620</li>-->
<!--                        </div>-->


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
                    <?= $order[0]->BillingCompanyName ?>
                    </br>
                    <?= $order[0]->BillingFirstName . ' ' . $order[0]->BillingLastName ?>
                    </br>
                    <?= $order[0]->BillingAddress1 ?>
                    </br>
                    <?= $order[0]->BillingAddress2 ?>
                    </br>
                    <?= $order[0]->BillingTownCity ?>
                    </br>
                    <?= $order[0]->BillingCountyState ?>
                    </br>
                    <?= $order[0]->BillingCountry ?>
                    </br>
                    <?= $order[0]->BillingPostcode ?>
                    </br>
                    Email:
                    <?= $order[0]->Billingemail ?>
                    </br>
                    T:
                    <?= $order[0]->Billingtelephone ?>
                    | M:
                    <?= $order[0]->BillingMobile ?>
                    </br>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display: flex">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                  <div class="card-body">
                    <?= $order[0]->DeliveryCompanyName ?>
                    </br>
                    <?= $order[0]->DeliveryFirstName . ' ' . $order[0]->DeliveryLastName ?>
                    </br>
                    <?= $order[0]->DeliveryAddress1 ?>
                    </br>
                    <?= $order[0]->DeliveryAddress2 ?>
                    </br>
                    <?= $order[0]->DeliveryTownCity ?>
                    </br>
                    <?= $order[0]->DeliveryCountyState ?>
                    </br>
                    <?= $order[0]->DeliveryCountry ?>
                    </br>
                    <?= $order[0]->DeliveryPostcode ?>
                    </br>
                    Email:
                    <?= $order[0]->Deliveryemail ?>
                    </br>
                    T:
                    <?= $order[0]->Deliverytelephone ?>
                    | M:
                    <?= $order[0]->DeliveryMobile ?>
                    </br>
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
                                    <th class="text-center invoice-heading-text">Unit Price</th>
                                    <th class="text-center invoice-heading-text">Quantity</th>
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
                                		foreach ($orderDetails as $orderDetail) {

                                    $lineTotal = $lineTotal + number_format($orderDetail->Price * $exchange_rate, 2) + number_format($orderDetail->Print_Total * $exchange_rate, 2);
                                    ?>
                                    <tr>
                                        <td class="text-center"><strong><?= $orderDetail->ManufactureID ?></strong></td>
                                        <td><!--<strong><?/*= $orderDetail->pn */?></strong>--> <?= $orderDetail->ProductName.' '.$this->quoteModel->txt_for_plain_labels($order[0]->Label); ?>
                                        </td>
                                        <td class="text-center"><?=$symbol?><?= number_format(number_format($orderDetail->Price * $exchange_rate, 2) / $orderDetail->Quantity,2) ?></td>
                                        <td class="text-center"><?= $orderDetail->Quantity ?></td>
                                        <td class="text-center"><?=$symbol?><?= number_format($orderDetail->Price * $exchange_rate, 2) ?>
											<?php //$lineTotal +=  number_format($orderDetail->Price * $exchange_rate, 2);?>
										
										
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
                      <td class="text-center"><?= $rowp->qty ?></td>
                     <td class="text-center"><?=$symbol?><? echo number_format($materialprice * $exchange_rate, 2); ?>
												<?php $lineTotal +=  number_format($materialprice * $exchange_rate, 2);?>
												</td>
										
                      </tr>
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
                                                <?php if($orderDetail->ProductName =='Roll Labels'){?>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Wound:</strong> <?= $orderDetail->Wound ?></span>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Orientation:</strong><?= $orderDetail->Orientation ?></span>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Finish:</strong> <?= $orderDetail->FinishType ?></span>
                                                <span class="invoice-bold"><strong
                                                            style="font-size:12px;;">Press Proof:</strong> <?= ($orderDetail->pressproof == 0)?'No':'Yes' ?></span>
                                            <?php }?>
                                            </td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"><?=$symbol?><?=$orderDetail->Print_Total?></td>
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
																	$delive = 0;
																	 $delive =  number_format($order[0]->OrderShippingAmount / vat_rate, 2,'.','');
													
																	?>
                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>LINE TOTAL</td>
                                    <td><?=$symbol?><?=number_format($lineTotal,2,'.','');?></td>
                                </tr>
                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>DELIVERY</td>
                                    <td><?=$symbol?><?= number_format( $delive * $exchange_rate, 2,'.','') ?></td>
                                </tr>
                                <tr class="text-bold">
                                    <td colspan="3"></td>
                                    <td>SUBTOTAL</td>
                                    <td><?=$symbol?><?= number_format(($lineTotal = $lineTotal + number_format( $delive * $exchange_rate, 2)), 2,'.','') ?></td>
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
																		<td><?=$symbol?><?php echo number_format(((($lineTotal * vat_rate) - $lineTotal) 	),2,'.','') ?>
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






