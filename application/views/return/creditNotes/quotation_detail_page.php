

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
                                        //echo '<pre>';print_r($arr); echo '</pre>';
                                          
                                        $this->db->select('*');
                                        $this->db->from('orders');
                                        $this->db->where_in('OrderNumber',$arr,false);
                                        $allServiceId = $this->db->get()->result_array();
                                        //echo $this->db->last_query();
                                        //echo '<pre>';print_r($allServiceId); echo '</pre>';    

                                        ?>
                                        Ticket Number  : <?= $note->ticketSrNo ?><br>
                                        Order Number  : <?= $all_orderno ?><br>
                                        Date :<?= date('jS F Y', $note->OrderDate) ?> <br>
                                        Time: <?= date('h:i:s A', $note->OrderTime) ?>
                                        
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card enquiry-card enquiry-card-bix-box-second">
                                    <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                                    <div class="card-body">
                                        <?= $note->BillingCompanyName ?><br>
                                        <?= $note->BillingFirstName . ' ' . $note->BillingLastName ?><br>
                                        <?= $note->BillingAddress1 ?><br>
                                        <?= $note->BillingAddress2 ?><br/>
                                        <?= $note->BillingTownCity ?><br>
                                        <?= $note->BillingCountyState ?><br>
                                        <?= $note->BillingCountry ?><br>
                                        <?= $note->BillingPostcode ?><br>
                                        Email:<?= $note->Billingemail ?><br/>
                                        T: <?= $note->Billingtelephone ?> |
                                        M: <?= $note->BillingMobile ?><br/>


                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card enquiry-card enquiry-card-bix-box-second">
                                    <div class="card-header card-heading-text-two">Delivery ADDRESS</div>
                                    <div class="card-body">
                                        <?= $note->DeliveryCompanyName ?><br>
                                        <?= $note->DeliveryFirstName . ' ' . $note->DeliveryLastName ?><br>
                                        <?= $note->DeliveryAddress1 ?><br>
                                        <?= $note->DeliveryAddress2 ?><br>
                                        <?= $note->DeliveryTownCity ?><br>
                                        <?= $note->DeliveryCountyState ?><br>
                                        <?= $note->DeliveryCountry ?><br>
                                        <?= $note->DeliveryPostcode ?><br>
                                        Email:<?= $note->Deliveryemail ?><br>
                                        T: <?= $note->Deliverytelephone ?> |
                                        M: <?= $note->DeliveryMobile ?><br>
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
                                            $symbol = '&pound;';
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
                                        
                                        
                                        
                                        $print_exvat = $quotationDetail->Print_Total;
                                        $print_incvat = number_format($quotationDetail->Print_Total*1.2,2,'.','');
                                            
                                        $exvat= number_format($quotationDetail->Price,2,'.','');
                                        $invat = number_format($exvat* 1.2,2,'.','');
                           
                                        $sub_exvat =  $print_exvat +  $exvat;
                                        $sul_invat =  $print_incvat + $invat;

                                        $total_exvat += $sub_exvat ;
                                        $total_invat += $sul_invat ;
                         
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
                                                <td><?= $symbol ?><?= $sub_exvat; ?></td>
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
                                            <td><?= $symbol ?><?= number_format($total_exvat, 2) ?></td>
                                            <td><?= $symbol ?><?= number_format($total_invat, 2) ?></td>
                                        </tr>
                                        
                                        <?php
                                               
                                                $service = $note->ShippingServiceID;    
                                                $county = $this->creditNotes_model->getShipingServiceName($service);
                                                $ShipingService = $this->creditNotes_model->getShipingService($county['CountryID']);
                                                     
                                                //echo '<pre>';    print_r($ShipingService); echo '</pre>';
                                        
                                                $deliveryChrg1;
                                                $deliveryChrg2;
                                        ?>
                                       <?php /* ?> <tr>
                                            <td>Delivery Option:</td>
                                            <td class="labels-form labels-filters-form">

                                                <?php //echo '<pre>'; print_r($ShipingService); echo '</pre>'; ?>
                                                <label class="select margin-bottom-0">
                                                    <select  name="printer" class="PrinterCopier nlabelfilter" tabindex="10" >
                                                        <?php $basiccharges = 0.00;

                                                        foreach ($ShipingService as $res) {
                                                            
                                                            $selected = '';
                                                            if ($res['ServiceID'] == $note->ShippingServiceID) {
                                                                $basiccharges = $res['BasicCharges'];
                                                                $selected = ' selected="selected" ';
                                                            }

                                                            if ($extPrice < 25.00 && $res['ServiceID'] == 20) {
                                                                $basiccharges = 6.00;

                                                            } else {
                                                                ?>
                                                                <option value="<?= $res['ServiceID'] ?>" <?= $selected ?> >
                                                                    <?php
                                                                    if ($res['BasicCharges'] == '0.00') {
                                                                        echo $res['ServiceName'];
                                                                        $deliveryChrg =  '0.00';
                                                                    } else {
                                                                        echo $res['ServiceName'] . ' &nbsp;' . $symbol . number_format($res['BasicCharges'] * $exchange_rate, 2, '.', '');
                                                                        $deliveryChrg = round($res['BasicCharges'] * $exchange_rate, 2);
                                                                        
                                                                    }
                                                                    ?>
                                                                    
                                                                </option>
                                                        
                                                        <?php 
                                                         if ($res['ServiceID'] == $note->ShippingServiceID) {
                                                                break;
                                                            }
                                                        ?>
                                                        
                                                        
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                    <i></i>
                                                </label>


                                            </td>
                                        </tr><?php */ ?>
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
                                            <?php } else {?>
                                                    <?php $d=0; ?>
                                            <?php } ?>
                                            
                                            <td>Delivery Service:</td>
                                            <td><?= $symbol ?><?= number_format($d, 2) ?></td>
                                            <td><?= $symbol ?><?= number_format(round($d*1.2), 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sub Total:</td>
                                            <td><?= $symbol ?><?php $grandPrice = $total_exvat + $d;
                                                echo number_format($grandPrice * $exchange_rate, 2) ?></td>
                                            
                                            <td><?= $symbol ?><?php $grandPrice2 = $total_invat + $d;
                                                echo number_format($grandPrice2 * $exchange_rate, 2) ?></td>
                                        </tr>
                                        
                                       
                                        
                                        
                                        <?php
                                                $discount_applied_in = $dis;
                                                $discount_applied_ex = $dis/1.2; ?>
                                              
                                          
                                        <?
                                           
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
                                                <tr><td>VAT @ 20%:</td><td></td><td style="color:red">- £<?php echo  number_format($grandPrice2 - $grandPrice, 2,'.','') ?></td></tr>
                                        <?php  } ?>
                                        

                                        <tr>
                                            <td>Grand Total: </td>
                                            <td><?= $symbol ?><?= number_format($grandPrice, 2,'.','') ?></td>
                                            
                                            <?php if ($note->vat_exempt == 'yes') { ?>
                                            <td><?= $symbol ?><?= number_format($grandPrice, 2,'.','') ?></td>
                                            <?php  } else{?>
                                            <td><?= $symbol ?><?= number_format($grandPrice2, 2,'.','') ?></td>
                                            <?php } ?>
                                        </tr>
                                        
                                        
                                        
                                      <!--  <tr>
                                            <td>Print Quotation:</td>
                                            <td>
                                                <div class=""> Hide Prices:
                                                    <input class="hider hideprice" id="hide" type="checkbox"
                                                           name="hideprice">
                                                    <label for="hide"> </label>
                                                </div>
                                            </td>
                                        </tr>-->
                                        <?php /* ?>
                                        <tr>
                                            <? $site = ($note->site == "" || $note->site == "en") ? "English" : "French"; ?>
                                            <td class="labels-form labels-filters-form">
                                                <label class="select margin-bottom-0">
                                                    <select id="language" class="PrinterCopier nlabelfilter"
                                                            tabindex="10">
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
                                                $allowvalue = ($customdiecheck2 == 0) ? 2 : 1
                                                ?>

                                                <input type="hidden" value="<?= $allowvalue ?>" id="allow"/>
                                                <?php if ($quotation->QuotationStatus == 17 || $quotation->QuotationStatus == 8) { ?>

                                                    <input class="btn btn-info waves-light waves-effect"
                                                           style="background-color:green;color:white" type="button"
                                                           onclick="generateorder2('<?= $quotation->QuotationNumber ?>');"
                                                           value="Generate Order">


                                                <?php }  ?>
                                            </td>

                                        </tr><?php */ ?>

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
        <div class="row">
            <div class="row " id="ajax_material_sorting" style="margin: 25px 14px;">

            </div>
        </div>
        <div class="" id="order_detail_material">

        </div>
        <!-- Products View End  -->
     <?php /* ?>   <div class="row" style="margin:0px -30px !important;">
            <div class="col-md-6">
                <div class="card m-b-30">
                    <div class="card-header card-heading-text-three">
                        <span class="pull-left heading-card-margin">SALE OPERATOR NOTES	 - <?= @$quotation->QuotationNumber ?></span>
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


            <div class="col-md-6">
                <div class="card m-b-30">
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

        </div> <?php */ ?>
    </div>
    <!-- Label Layout Popup Start -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" id="lay_pop_up" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content blue-background">
                <div class="modal-header checklist-header">
                    <div class="col-md-12">
                        <h4 class="modal-title checklist-title" id="myLargeModalLabel">Label Layout</h4>
                    </div>
                </div>
                <div class="modal-body p-t-0">
                    <div class="panel-body">

                        <div id="layout_up" class="row">

                        </div>


                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Label Layout Popup End -->
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
                    </span>


                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Note Add Popup Start End -->

    <? include(APPPATH . 'views/order_quotation/artwork/artwork_popup.php') ?>

    <script>
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
                    filter_data('autoload', '', 'quotation');
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
