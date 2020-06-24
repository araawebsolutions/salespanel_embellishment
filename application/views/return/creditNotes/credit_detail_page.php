

<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card enquiry-card enquiry-card-bix-box-second">
                                    <div class="card-header card-heading-text-two">Credit Note Information</div>
                                    <div class="card-body">
                                        <?php 
        
                                        //echo '<pre>';print_r($note); echo '</pre>';
    
                                        $note =$note[0];
                                        $all_orderno = $note->all_orderno;
                                        
                                        $all_orderno = explode(',',$all_orderno);
                                        $all_orderno = implode(' , ',$all_orderno);
                                            
                                        //echo '<pre>';print_r(explode(',',$all_orderno)); echo '</pre>';            
                                        $arr= [];
                                        
                                        foreach(explode(',',$all_orderno) as $d){
                                            array_push($arr,"'".$d."'");
                                        }
                                        
                                        $arr =implode(',',$arr);
                                          
                                        $this->db->select('*');
                                        $this->db->from('orders');
                                        $this->db->where_in('OrderNumber',$arr,false);
                                        $allServiceId = $this->db->get()->result_array();
                                        ?>
                                        
                                        
                                      
                                        <dl class="row">
                                            <dt class="col-sm-4">Ticket No#: </dt>
                                            <dd class="col-sm-8"><?= $note->ticketSrNo ?></dd>

                                            <dt class="col-sm-4">Order No#: </dt>
                                                <dd class="col-sm-8"><?= $all_orderno ?></dd>
                                            
                                           <dt class="col-sm-4">Date</dt>
                                           <dd class="col-sm-8"><?= date('jS F Y', $note->OrderDate) ?></dd>

                                           <dt class="col-sm-4 text-truncate">Time:</dt>
                                           <dd class="col-sm-8"> <?= date('h:i:s A', $note->OrderTime) ?></dd>
                                        </dl>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card enquiry-card enquiry-card-bix-box-second">
                                    <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                                    <div class="card-body">
                                       
                                        
                                       <dl class="row">
                                           <dt class="col-sm-4">Company: </dt>
                                           <dd class="col-sm-8"><?= $note->BillingCompanyName ?></dd>

                                           <dt class="col-sm-4">Name: </dt>
                                           <dd class="col-sm-8">
                                               <?= $note->BillingFirstName . ' ' . $note->BillingLastName ?>
                                           </dd>

                                           <dt class="col-sm-4">Address 1:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingAddress1 ?></dd>

                                           <dt class="col-sm-4 text-truncate">Address 2:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingAddress2 ?></dd>

                                           <dt class="col-sm-4">Town/City:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingTownCity ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">County:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingCountyState ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Country:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingCountry ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Post Code:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingPostcode ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Email:</dt>
                                           <dd class="col-sm-8"><?= $note->Billingemail ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Phone:</dt>
                                           <dd class="col-sm-8"><?= $note->Billingtelephone ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Mobile:</dt>
                                           <dd class="col-sm-8"><?= $note->BillingMobile ?></dd>
                                        </dl>


                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card enquiry-card enquiry-card-bix-box-second">
                                    <div class="card-header card-heading-text-two">Delivery ADDRESS</div>
                                    <div class="card-body">
                                        
                                        <dl class="row">
                                           <dt class="col-sm-4">Company: </dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryCompanyName ?></dd>

                                           <dt class="col-sm-4">Name: </dt>
                                           <dd class="col-sm-8">
                                               <?= $note->DeliveryFirstName . ' ' . $note->DeliveryLastName ?>
                                           </dd>

                                           <dt class="col-sm-4">Address 1:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryAddress1 ?></dd>

                                           <dt class="col-sm-4 text-truncate">Address 2:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryAddress2 ?></dd>

                                           <dt class="col-sm-4">Town/City:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryTownCity ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">County:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryCountyState ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Country:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryCountry ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Post Code:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryPostcode ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Email:</dt>
                                           <dd class="col-sm-8"><?= $note->Deliveryemail ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Phone:</dt>
                                           <dd class="col-sm-8"><?= $note->Deliverytelephone ?></dd>
                                           
                                           <dt class="col-sm-4 text-truncate">Mobile:</dt>
                                           <dd class="col-sm-8"><?= $note->DeliveryMobile ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        
                        
                        <?php
                            $CI =& get_instance();
                            $CI->load->model('cart/cartModal');
                        ?>
                        
                        <span class="float-right p-23">
                             <? $currency_options = $CI->cartModal->get_currecy_options();
                                         $currency = $note->currency;
                                        if($currency=='EUR'){
                                            $symbol = '&euro;';
                                        }else if($currency=='USD'){
                                            $symbol = '$;';
                                        }else{
                                            $symbol ='&pound;';
                                        }

                                        //$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
                                        $exchange_rate = $CI->cartModal->get_exchange_rate($currency);
                             ?>

                        </span><?php  ?>

                        
                        <div class="card-box">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr class="card-heading-title">
                                        <th width="10%" class="text-center invoice-heading-text">Manufacturer ID</th>
                                        <th width="55%" class="text-center invoice-heading-text">Description</th>
                                        <th width="10%" class="text-center invoice-heading-text">Labels</th>
                                        <th width="5%" class="text-center invoice-heading-text">Quantity</th>
                                        <th width="9%" class="text-center invoice-heading-text">Ext.VAT</th>
                                        <th width="9%" class="text-center invoice-heading-text">Incl. Vat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php
                                   //echo '<pre>';print_r($noteDetails); echo '</pre>';
                                    $extPrice = 0;
                                        
                                    $total_exvat=0;
                                    $total_invat=0;
                                    $dis = '0.00';   
                                        
                                    foreach ($noteDetails as $key => $quotationDetail) {
                                        
                                        
                                        
                                        
                                        $this->db->select('OrderTotal,voucherOfferd,voucherDiscount');
                                        $ords =     $this->db->get_where('orders',array('OrderNumber'=>$quotationDetail->OrderNumber))->result_Array();
                                        
                                        //echo '<pre>';print_r($ords); echo '</pre>';
                                        
                                        
                                        
                                        foreach($ords as $oo){
                                            
                                            $this->db->select('SerialNumber,ProductTotal');
                                            $ordsdete = $this->db->get_where('orderdetails',array('OrderNumber'=>$quotationDetail->OrderNumber))->result_Array();
                                            
                                            
                                            if($oo['voucherOfferd']=='Yes'){
                                              
                                                foreach($ordsdete as $od){
                                                    if($quotationDetail->SerialNumber == $od['SerialNumber']){
                                                        
                                                        $total_amount = number_format($oo['OrderTotal']+$oo['voucherDiscount'],2,'.',''); 
                                                        
                                                        $disPer = number_format(100-($oo['OrderTotal']/$total_amount*100),2,'.',''); 
                                                            
                                                        $calculateDis = number_format(($od['ProductTotal']*$disPer/100),2,'.','');          
                                                        
                                                    }
                                                }
                                                
                                                $dis += $calculateDis;
                                            }
                                        }
                                        
                                        
                                        
                                        $print_exvat = $quotationDetail->Print_Total * $exchange_rate;
                                        $print_incvat = number_format(($quotationDetail->Print_Total *$exchange_rate)*1.2,2,'.','');
                                            
                                        $exvat= number_format($quotationDetail->Price,2,'.','');
                                        $invat = number_format($exvat* 1.2,2,'.','');
                           
                                        $sub_exvat =  $print_exvat +  $exvat;
                                        $sul_invat =  ($invat * 1.2);

                                        $total_exvat += $sub_exvat ;
                                        $total_invat += ($sub_exvat * 1.2) ;
                         
                                        $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
                                        
                                        if ($quotationDetail->ManufactureID == 'SCO1') {
                                            $carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);

                                            ?>
                                            <tr id="line<?= $key ?>">

                                                <td>
                                                    <div class="checkbox checkbox-custom"><input class="hider hideprice"
                                                                                                 id="hide"
                                                                                                 type="checkbox"
                                                                                                 name="hideprice">
                                                        <label for="hide"> </label>
                                                    </div>
                                                </td>

                                                <td><?= $quotationDetail->ManufactureID ?>
                                                </td>
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
                                                    <br/><br/>
                                                    <button type="button" class="custom-die-cta"
                                                            onclick="editCustomDie(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>)">
                                                        Edit
                                                        Custom Die
                                                    </button>
                                                    <input type="hidden" id="quo" value="quo">
                                                    <input type="hidden" id="serlno"
                                                           value="<?= $quotationDetail->SerialNumber ?>">
                                                    <?php if ((isset($carRes[0])) && $carRes[0]->discount == 0) { ?>
                                                        <button id="applydis<?= $key ?>" type="button"
                                                                class="custom-die-cta"
                                                                onclick="changeDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>)">
                                                            Check Discount
                                                        </button>
                                                        <button id="deletedis<?= $key ?>" type="button"
                                                                class="custom-die-cta"
                                                                style="display: none"
                                                                onclick="deleteDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>)">
                                                            Delete Discount
                                                        </button>
                                                    <?php } else { ?>
                                                        <button id="deletedis<?= $key ?>" type="button"
                                                                class="custom-die-cta"
                                                                onclick="deleteDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>)">
                                                            Delete Discount
                                                        </button>
                                                        <button id="applydis<?= $key ?>" style="display: none"
                                                                class="custom-die-cta"
                                                                type="button"
                                                                onclick="changeDisVal(<?= $key ?>,<?= $quotationDetail->SerialNumber ?>)">
                                                            Check Discount
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td id="checkout_unit_price<?= $key ?>"><?= $quotationDetail->Quantity * $quotationDetail->LabelsPerRoll ?></td>
                                                <td><input type="text" id="1" value="<?= $quotationDetail->Quantity ?>"
                                                           class="form-control input-number text-center allownumeric"
                                                           name="quant1">
                                                </td>
                                                <td id="checkout_price<?= $key ?>"><?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2) ?></td>
                                                <td class="padding-6 icon-tablee">
                                                    <i class="mdi mdi-delete"
                                                       onclick="deletenode(<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->Prl_id ?>','<?= $quotationDetail->ManufactureID ?>')"
                                                       id="deletenode1"></i>


                                                </td>
                                            </tr>
                                            <?php
                                            if (!empty($carRes)) {
                                                include(APPPATH . 'views/order_quotation/checkout/cart_material.php');
                                            }
                                            ?>


                                        <?php } else { ?>
                                            <tr>
                                               
                                                <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?>
                                                    <br>
                                                        
                                                    <?php if ($quotationDetail->Printing != 'Y' || $quotationDetail->Printing != 'Yes') { ?>
                                                        <?php  echo 'Plain'; ?>    
                                                    <?php } else if($quotationDetail->Printing == 'Y' || $quotationDetail->Printing ==    'Yes'){ ?>
                                                      <?php   echo 'Printed'; ?>
                                                <?php } ?>
                                                    
                                                       
                                                </td>
                                                <td><?= $quotationDetail->ProductName ?></td>
                                                <td id="labels">
                                                    <?= @$quotationDetail->labels  ?>
                                                </td>
                                                <td>
                                                    <?= @$quotationDetail->Quantity  ?>
                                                </td>
                                                <td><?= $symbol ?><?= round($sub_exvat * $exchange_rate,2); ?></td>
                                                <td><?= $symbol ?><?= $sul_invat; ?></td>
                                                
                                            </tr>
                                            <?php

//                                            /include(APPPATH . 'views/order_quotation/checkout/die_material.php');
                                            ?>
                                        <?php }
                                    } ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pull-left">
                                
                                 
                                  
                                    
                                </div>
                                <div class="col-md-6 6ull-right">
                                    <table class="table table-bordered quote-price-details details-cart-table" >
                                        <tr>
                                            <td>Total of Goods:</td>
                                            <td><?= $symbol ?><?= number_format($total_exvat * $exchange_rate, 2) ?></td>
                                            <td><?= $symbol ?><?= number_format($total_invat * $exchange_rate, 2) ?></td>
                                        </tr>
                                        
                                        <?php
                                               
                                                $service = $note->ShippingServiceID;    
                                                $county = $this->creditNotes_model->getShipingServiceName($service);
                                                $ShipingService = $this->creditNotes_model->getShipingService($county['CountryID']);
                                                     
                                                //echo '<pre>';    print_r($ShipingService); echo '</pre>';
                                        
                                                $deliveryChrg1;
                                                $deliveryChrg2;
                                        ?>
                                      
                                        <tr>
                                            <?php if($note->isShip=='yes'){ ?>
                                            
                                            <?php $d=0; foreach ($allServiceId as $allShop) {  ?>
                                            <?php $basiccharges = 0.00;

                                            foreach ($ShipingService as $res) {
                                                            
                                                if ($res['ServiceID'] == $allShop['ShippingServiceID']) {
                                                    $basiccharges = $res['BasicCharges'];
                                                }

                                                if ($extPrice < 25.00 && $res['ServiceID'] == 20) {
                                                    $basiccharges = 6.00;

                                                } else { ?>
                                            
                                            <?php
                                                    if ($res['BasicCharges'] == '0.00') {
                                                        
                                                        $deliveryChrg =  '0.00';
                                                    } else {
                                                        $deliveryChrg = round($res['BasicCharges'] * $exchange_rate, 2);
                                                    }
                                            ?>
                                            <?php 
                                                    if ($res['ServiceID'] == $allShop['ShippingServiceID']) {
                                                        $d = $d  + $deliveryChrg; 
                                                        break;
                                                    }
                                            ?>
                                                        
                                            <?php  }     } ?>
                                            
                                            
                                            
                                            <?php  } ?>
                                            <?php
                                              $d=   $note->OrderShippingAmount/1.2 ;

                                            } else {?>
                                                    <?php $d=0; ?>
                                            <?php } ?>
                                            
                                            <td>Delivery Service:</td>
                                            <td><?= $symbol ?><?= number_format($d * $exchange_rate, 2) ?></td>
                                            <td><?= $symbol ?><?= number_format(($d * $exchange_rate ) * 1.2,2,'.','' ) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sub Total:</td>
                                            <td><?= $symbol ?><?php $grandPrice = $total_exvat + ($d);       echo number_format($grandPrice * $exchange_rate, 2) ?>
                                            </td>
                                            
                                            <td><?= $symbol ?><?php $grandPrice2 = $total_invat + ($d * 1.2) ;      echo number_format($grandPrice2 *
                                                    $exchange_rate, 2) ?></td>
                                        </tr>
                                        
                                       
                                        
                                        
                                        <?php
                                                $discount_applied_in = $dis;
                                                $discount_applied_ex = $dis/1.2;
                                              
                                 
                                            $discountEx=number_format($discount_applied_ex,2,'.','');
                                            $discountIn=number_format($discount_applied_in,2,'.','');
                                        
                                            $grandPrice = number_format($grandPrice - $discountEx,2,'.','');
                                            $grandPrice2 = number_format($grandPrice2 - $discountIn,2,'.','');
                                        ?>                 
              
                                        
                                        <tr>
                                            <td>Discount:</td>
                                            <td style="color:red">- <?php echo $symbol.number_format($discount_applied_ex,2,'.',''); ?></td>
                                            <td style="color:red">- <?php echo $symbol.number_format($discount_applied_in,2,'.',''); ?></td>
                                            
                                        </tr>
                                        
                                         
                                        <?php if ($note->vat_exempt == 'yes') { ?>

                                            <?php //echo ($grandPrice * $exchange_rate); echo '<br>';  echo ($grandPrice2 * $exchange_rate);?>
                                            <tr><td>VAT @ 20%:</td><td></td><td style="color:red">
                                                    - <?php echo $symbol;?> <?php echo  number_format(($grandPrice2 * $exchange_rate) - ($grandPrice * $exchange_rate), 2,'.','')
                                                    ?></td></tr>
                                        <?php  } ?>
                                        

                                        <tr>
                                            <td>Grand Total: </td>
                                            <td><?= $symbol ?><?= number_format(($grandPrice * $exchange_rate), 2,'.','') ?></td>
                                            
                                            <?php if ($note->vat_exempt == 'yes') { ?>
                                            <td><?= $symbol ?><?= number_format(($grandPrice * $exchange_rate), 2,'.','') ?></td>
                                            <?php  } else{?>
                                            <td><?= $symbol ?><?= number_format(($grandPrice2 * $exchange_rate), 2,'.','') ?></td>
                                            <?php } ?>
                                        </tr>
                                        
                                        <tr>
                                      
                                        
                                        <td colspan="3">   
                                            <input class="pull-right btn btn-outline-info waves-light waves-effect p-6-10" type="button" id="pr" data-pr="<?php echo $note->cr_id ?>" value="Print Credit Note"> 
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
      

    </div>
    <!-- Label Layout Popup Start -->
   
<script type="text/javascript"> 

    $('#pr').click(function(){
       var d =  $(this).attr('data-pr');
        //alert(d);
        window.location.href='<?=main_url; ?>tickets/creditNotes/printnote/'+d;

    //alert(<?=main_url; ?>'tickets/creditNotes/printnote/'+d);
    });

</script> 
  
