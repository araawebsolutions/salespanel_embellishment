
<div class="tab-content">
    <div class="tab-pane show active" id="home1">
        <div class="card-box no-padding">

            <div class="row m-t-t-10">

                <div class="col-md-6"><img src="../assets/images/logo.png" width="162" height="65" alt="Quotation Logo">
                    <p class="adress-delivery">AA Labels, 23 Wainman Road, Peterborough, PE2 7BU</p>
                </div>


                <div class="col-md-6 delivery-info">
                    <li><strong>Order Number #: <?=$order[0]->OrderNumber?></strong></li>
                    <li>Phone Number: 01733 588 390</li>
                    <li>Email Address: customercare@aalabels.com</li>
                    <li>VAT #: GB 945 028 620</li>
                </div>


            </div>



            <div class="row m-t-t-10">
                <div class="col-md-4">
                    <div class="card enquiry-card ">
                        <div class="card-header card-heading-text-two">Invoice INFORMATION</div>
                        <div class="card-body">
                            <div class="col-sm-12 m-t-20 card-space-text">
                                <dl class="row">

                                    <dt class="col-sm-5">Order Number:</dt>
                                    <dd class="col-sm-7"><?=$order[0]->OrderNumber?></dd>
                                    <dt class="col-sm-5">Date:</dt>
                                    <dd class="col-sm-7"><?=date('jS F Y',$order[0]->OrderDate)?></dd>
                                    <dt class="col-sm-5 text-truncate">Time:</dt>
                                    <dd class="col-sm-7"><?=date('h:m:s',$order[0]->OrderDate)?> PM</dd>
                                    <dt class="col-sm-5">Dispatch Date:</dt>
                                    <dd class="col-sm-7">10-03-2018</dd>
                                    <dt class="col-sm-5">Dispatch Time:</dt>
                                    <dd class="col-sm-7">01:15:14 PM</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card enquiry-card">
                        <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                        <div class="card-body">
                            <div class="col-sm-12 m-t-20 card-space-text">
                                <dl class="row">

                                    <dt class="col-sm-5">Order Number:</dt>
                                    <dd class="col-sm-7"><?=$order[0]->OrderNumber?></dd>
                                    <dt class="col-sm-5">Date:</dt>
                                    <dd class="col-sm-7"><?=date('jS F Y',$order[0]->OrderDate)?></dd>
                                    <dt class="col-sm-5 text-truncate">Time:</dt>
                                    <dd class="col-sm-7"><?=date('h:m:s',$order[0]->OrderDate)?> PM</dd>
                                    <dt class="col-sm-5">Tracking Number:</dt>
                                    <dd class="col-sm-7"></dd>
                                    <dt class="col-sm-5">Dispatch Date:</dt>
                                    <dd class="col-sm-7"></dd>
                                    <dt class="col-sm-5">Dispatch Time:</dt>
                                    <dd class="col-sm-7"></dd>
                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card enquiry-card">
                        <div class="card-header card-heading-text-two">Delivery ADDRESS</div>
                        <div class="card-body">
                            <div class="col-sm-12 m-t-20 card-space-text">
                                <dl class="row">
                                    <dt class="col-sm-5">Invoice Number:</dt>
                                    <dt class="col-sm-7"></dt>
                                    <dt class="col-sm-5">Order Number:</dt>
                                    <dd class="col-sm-7"><?=$order[0]->OrderNumber?></dd>
                                    <dt class="col-sm-5">Date:</dt>
                                    <dd class="col-sm-7"><?=date('jS F Y',$order[0]->OrderDate)?></dd>
                                    <dt class="col-sm-5 text-truncate">Time:</dt>
                                    <dd class="col-sm-7"><?=date('h:m:s',$order[0]->OrderDate)?>PM</dd>
                                    <dt class="col-sm-5">Tracking Number:</dt>
                                    <dd class="col-sm-7"></dd>
                                    <dt class="col-sm-5">Dispatch Date:</dt>
                                    <dd class="col-sm-7"></dd>
                                    <dt class="col-sm-5">Dispatch Time:</dt>
                                    <dd class="col-sm-7"></dd>
                                </dl>
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
                        $lineTotal = 0;
                        foreach ($orderDetails as $orderDetail){

                            $lineTotal = $orderDetail->Price + $lineTotal;
                            ?>
                        <tr>
                            <td class="text-center"><strong><?=$orderDetail->ManufactureID?></strong></td>
                            <td><strong><?=$orderDetail->pn?></strong> <?=$orderDetail->ProductName?> </td>
                            <td class="text-center"><?=($orderDetail->Price / $orderDetail->Quantity)?></td>
                            <td class="text-center"><?=$orderDetail->Quantity?></td>
                            <td class="text-center">£<?=$orderDetail->Price?></td>

                        </tr>
                        <?php if($orderDetail->Printing == 'Y'){?>
                        <tr>
                            <td class="text-center"></td>
                            <td>
                                <i class="mdi mdi-check"></i> <span><?=$orderDetail->Print_Type?></span>
                                <i class="mdi mdi-check"></i> <span><?=$orderDetail->Print_Design?></span>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Wound:</strong> <?=$orderDetail->Wound?></span>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Orientation:</strong><?=$orderDetail->Orientation?></span>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Finish:</strong> <?=$orderDetail->FinishType?></span>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Press Proof:</strong> <?=$orderDetail->pressproof?></span>
                            </td>
                            <!--<td class="text-center">£0.00</td>
                            <td class="text-center">0</td>
                            <td class="text-center">£0.00</td>-->
                        </tr>
                        <?php }}?>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>LINE TOTAL</td>
                            <td>£<?=$lineTotal?></td>
                        </tr>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>DELIVERY</td>
                            <td>£<?=$order[0]->OrderShippingAmount?></td>
                        </tr>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>SUBTOTAL</td>
                            <td>£<?=number_format(($lineTotal +$order[0]->OrderShippingAmount) ,2)?></td>
                        </tr>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>VAT @ 20%</td>
                            <td>£<?php echo number_format((($lineTotal *1.2) - $lineTotal),2) ?></td>
                        </tr>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>GRAND TOTAL</td>
                            <td>£<?=number_format(($lineTotal *1.2),2)?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-12 m-t-t-10">
                    <span class="pull-right">
                    <a href="<?=main_url?>order_quotation/order/pay_now/<?=$order[0]->OrderNumber?>" class="btn btn-outline-dark waves-dark waves-effect btn-countinue btn-print1">PAY NOW <i class="mdi mdi-book-open"></i></a>
                    </span> </div>
</div>
    </div>
</div>

