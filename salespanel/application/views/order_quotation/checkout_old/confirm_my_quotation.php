<?php $currency_options = $this->cartModal->get_currecy_options();
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>
<div class="tab-content">
    <div class="tab-pane show active" id="home1">
        <div class="card-box no-padding">





            <div class="row m-t-t-10">
                <div class="col-md-4">
                    <div class="card enquiry-card ">
                        <div class="card-header card-heading-text-two">QUOTATION INFORMATION</div>
                        <div class="card-body">
                            <div class="col-sm-12 card-space-text">
                                <dl class="row">

                                    <dt class="col-sm-5">Quotation Number:</dt>
                                    <dd class="col-sm-7"><?=$quotation[0]->QuotationNumber?></dd>
                                    <dt class="col-sm-5">Date:</dt>
                                    <dd class="col-sm-7"><?=date('jS F Y',$quotation[0]->QuotationDate)?></dd>
                                    <dt class="col-sm-5 text-truncate">Time:</dt>
                                    <dd class="col-sm-7"><?=$quotation[0]->time?> </dd>
                                    
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card enquiry-card">
                        <div class="card-header card-heading-text-two">BILLING ADDRESS</div>
                        <div class="card-body">
                            <div class="col-sm-12  card-space-text">
                                <dl class="row">
                                   
                                    <dt class="col-sm-5">Quotation Number:</dt>
                                    <dd class="col-sm-7"><?=$quotation[0]->QuotationNumber?></dd>
                                    <dt class="col-sm-5">Date:</dt>
                                    <dd class="col-sm-7"><?=date('jS F Y',$quotation[0]->QuotationDate)?></dd>
                                    <dt class="col-sm-5 text-truncate">Time:</dt>
                                    <dd class="col-sm-7"><?=$quotation[0]->time?> </dd>
                                
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card enquiry-card">
                        <div class="card-header card-heading-text-two">DELIVERY ADDRESS</div>
                        <div class="card-body">
                            <div class="col-sm-12  card-space-text">
                                <dl class="row">
                                    
                                    
                                    <dt class="col-sm-5">Order Number:</dt>
                                    <dd class="col-sm-7"><?=$quotation[0]->QuotationNumber?></dd>
                                    <dt class="col-sm-5">Date:</dt>
                                    <dd class="col-sm-7"><?=date('jS F Y',$quotation[0]->QuotationDate)?></dd>
                                    <dt class="col-sm-5 text-truncate">Time:</dt>
                                    <dd class="col-sm-7"><?=$quotation[0]->time?> </dd>
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
                        foreach ($quotationDetails as $key=>$quotationDetail){

                            $lineTotal = $quotationDetail->Price + $lineTotal + $quotationDetail->Print_Total;
                            ?>
                        <tr>
                            <td class="text-center"><strong><?=$quotationDetail->ManufactureID?></strong></td>
                            <td><strong><?/*=$quotationDetail->pn*/?></strong> <?=$quotationDetail->ProductName?> </td>
                            <td class="text-center"><?=$symbol?><?=number_format($quotationDetail->Price / $quotationDetail->Quantity,2,'.','')?></td>
                            <td class="text-center"><?=$quotationDetail->Quantity?></td>
                            <td class="text-center"><?=$symbol?><?=number_format($quotationDetail->Price,2,'.','')?></td>

                        </tr>
                        <?php
                            if ($quotationDetail->ManufactureID == 'SCO1') {
                                @$carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);
                                $scorecord = $this->user_model->fetch_custom_die_info(@$carRes[0]->ID);

                                $assoc = $this->user_model->getCartMaterial(@$carRes[0]->ID);
                                 foreach ($assoc as $rowp) {
                                      $materialprice = $rowp->plainprice + $rowp->printprice;
                                     $lineTotal = $lineTotal +$materialprice;
                            ?>

													<tr>
														<td class="text-center"><?= $rowp->material ?> </td>
														<td class="text-center"><p style="margin-left:35px;float:left"><b class="text-center"><?= $rowp->material ?> - </b>
															<?= $this->user_model->get_mat_name($rowp->material); ?> - <?=$rowp->labeltype?> labels></td>
														<td class="text-center"></td>
														<td class="text-center"><?= $rowp->qty ?></td>
														<td class="text-center"><?=$symbol?><? echo(number_format($materialprice * $exchange_rate, 2,'.','')); ?></td>
													</tr>
                        	<?php }}elseif($quotationDetail->Printing == 'Y' && $quotationDetail->regmark !='Y'){
													?>
													
                        <tr>
                            <td class="text-center"></td>
                            <td>
                                <i class="mdi mdi-check"></i> <span><?=$quotationDetail->Print_Type?></span>

                                <i class="mdi mdi-check"></i> <span><?=$quotationDetail->Print_Design?></span>

                                <?php if($quotationDetail->wound !=null && $quotationDetail->wound !="" && $quotationDetail->ProductBrand == 'Roll Labels'){?>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Wound:</strong> <?=$quotationDetail->wound?></span>
                                <?php }?>
                            <?php if($quotationDetail->Orientation !=null && $quotationDetail->Orientation !="" && $quotationDetail->ProductBrand == 'Roll Labels'){?>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Orientation:</strong><?=$quotationDetail->Orientation?></span>
                            <?php }?>
                                <?php if($quotationDetail->FinishType !=null && $quotationDetail->FinishType !="" && $quotationDetail->ProductBrand == 'Roll Labels'){?>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Finish:</strong> <?=$quotationDetail->FinishType?></span>
                            <?php }?>
                                <?php if($quotationDetail->pressproof !=null && $quotationDetail->pressproof !="" && $quotationDetail->ProductBrand == 'Roll Labels'){?>
                                <span class="invoice-bold"><strong style="font-size:12px;;">Press Proof:</strong> <?=($quotationDetail->pressproof == 0)?'No':'Yes'?></span>
                                <?php }?>

                            </td>
                            <?php if($quotationDetail->ProductBrand != 'Roll Labels'){?>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><?=$symbol?><?=$quotationDetail->Print_Total?></td>
                            <?php }?>
                        </tr>
                        <?php }

                            elseif($quotationDetail->Printing == 'Y' && $quotationDetail->regmark =='Y'){?>
                        <tr>
                            <td></td>
                            <td><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                        </tr>
                        <?php }}?>
													
													<?php
													 $delive = 0;
													 $delive =  number_format($quotation[0]->QuotationShippingAmount / vat_rate, 2,'.','');
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
                            <td><?=$symbol?><?=number_format(($lineTotal = $lineTotal+ $delive) ,2)?></td>
                        </tr>
												<?php if($quotation[0]->vat_exempt=="yes"){ ?>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>VAT EXEMPT</td>
                            <td>-<?=$symbol?><?php echo number_format((($lineTotal * vat_rate) - $lineTotal) ,2,'.','') ?></td>
                        </tr>
												<?php } else{ ?>
												<tr class="text-bold">
                            <td colspan="3"></td>
                            <td>VAT @ 20%</td>
                            <td><?=$symbol?><?php echo number_format(((($lineTotal * vat_rate) - $lineTotal) ),2,'.','') ?>
															<?php //$lineTotal = $lineTotal +  number_format((($lineTotal * vat_rate - $lineTotal) ),2) ?>
													</td>
                        </tr>
													<?php } ?>
													
													<?php
															
															if($quotation[0]->vat_exempt=="no"){
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
            </div>

            <div class="col-md-12 m-t-t-10" style="padding-right: 0px;">
                    <span class="pull-right">
                    <a href="#" onclick="printpdf('<?=$quotation[0]->QuotationNumber?>','en')" class="btn btn-outline-dark waves-dark waves-effect btn-countinue btn-print1">Print Quotation <i class="mdi mdi-book-open"></i></a>
                    </span>&nbsp;&nbsp;
                <span class="pull-right" style="margin-right:20px;">
                    <a href="<?=main_url?>order_quotation/quotation/getQuotationDetail/<?=$quotation[0]->QuotationNumber?>" class="btn btn-outline-dark waves-dark waves-effect btn-countinue btn-print1">View Quotation <i class="mdi mdi-book-open"></i></a>

                    </span>

            </div>











        </div>
    </div>
</div>

