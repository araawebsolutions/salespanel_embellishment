<?php 

$symbol = $this->orderModal->get_currecy_symbol($quotation[0]->currency); 
$exchange_rate = $quotation[0]->exchange_rate;
?>


<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            
            
<div class="tab-content">
    <div class="tab-pane show active" id="home1">
        <div class="card-box ">





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
                    </dl>     
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

            <div class="row m-t-t-10">
                <div class="col-12">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="card-heading-title">
                            <th class="text-center invoice-heading-text" width="10%">Manufacturer ID</th>
                            <th class="text-center invoice-heading-text" width="50%">Description</th>
                            <th class="text-center invoice-heading-text" width="15%">Unit Price</th>
                            <th class="text-center invoice-heading-text" width="15%">Quantity</th>
                            <th class="text-center invoice-heading-text" width="15%">Ext.VAT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $lineTotal = 0;
                         //echo "<pre>";
                        //print_r($quotationDetails);


                        foreach ($quotationDetails as $key=>$quotationDetail){
                          
                          $tots = 0;
                           if($quotationDetail->ProductID !='0'){
                                  
                             if($quotationDetail->ProductBrand != 'Roll Labels'){
                               $tots = $quotationDetail->Quantity *  $quotationDetail->LabelsPerSheet;
                                   
                             }else {
                              
                               $tots =  $quotationDetail->orignalQty; 
                             }
                           }

                            $lineTotal = $quotationDetail->Price + $lineTotal + $quotationDetail->Print_Total;
                            ?>
                        <tr>
                            <td class="text-center"><strong><?=$quotationDetail->ManufactureID?></strong></td>
                            <td><strong><?/*=$quotationDetail->pn*/?></strong> <?=$quotationDetail->ProductName?> </td>
                            <td class="text-center">

                              <?php  if($quotationDetail->ManufactureID != 'SCO1'){            ?>
                                <?=$symbol?><?=number_format( ($quotationDetail->Price / $tots) * $exchange_rate,3,'.','')?>
                              <?php  } else { ?>
                                <?=$symbol?><?=number_format( ($quotationDetail->Price / $quotationDetail->Quantity) * $exchange_rate,3,'.','')?>
                                <?php }?>

                                <br>
                                <?php 
                                if($quotationDetail->ProductID !='0'){
                                ?>
                                Per Label
                                <?}?>
                            </td>
                            <td class="text-center"><?=$quotationDetail->Quantity?>&nbsp;
                                <?php  if($quotationDetail->ProductID !='0'){
                                  
                                  if($quotationDetail->ProductBrand != 'Roll Labels'){
                                    echo "Sheets".'<br>';
                                    echo  $quotationDetail->Quantity *  $quotationDetail->LabelsPerSheet;
                                   
                                  }else {
                                    echo "Rolls<br>";
                                    echo $quotationDetail->orignalQty; 
                                           
                                  }
                              ?>
                           
                              &nbsp;labels
                              <?}?>
                            </td>
                            <td class="text-center"><?=$symbol?><?=number_format($quotationDetail->Price * $exchange_rate,3,'.','')?></td>

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
                          
                        <?php $sho = ''; if($carRes[0]->format =='Roll'){ $sho =  $rowp->rolllabels;} else { $sho =  ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate);} ?>

                          
                          

													<tr>
														<td class="text-center"><?= $rowp->material ?></td>
														<td class="text-center"><p style="margin-left:35px;float:left"><b class="text-center"><?= $rowp->material ?> - </b>
															<?= $this->user_model->get_mat_name($rowp->material);?> - <?=$rowp->labeltype?> labels</td>
													 <td align="center"><?=$symbol ?><?= number_format(($materialprice / $sho) * $exchange_rate,2 ) ?></td>
														<td class="text-center">
                <?= $rowp->qty ?>
                <?php 
                              if($carRes[0]->format == 'Roll'){
                                echo "Roll";
                              }else{
                                echo "Sheet";
                              }
                ?>
                <br>
              
                
                 <?php if($carRes[0]->format =='Roll'){ echo $rowp->rolllabels.' labels';} else { echo ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate).' labels';} ?>

               </td>
               <td class="text-center"><?=$symbol?><? echo(number_format($materialprice * $exchange_rate, 2,'.','')); ?></td>
                          </tr>
                          
                          
                          <?php if(($rowp->labeltype == 'printed' && $carRes[0]->format != 'Roll') || ($carRes[0]->format == 'Roll' ))  { ?>        
                          <tr style="<?=$eprintoptionclass?>">
                            <td></td>
                            <td>
                              <i class="mdi mdi-check"></i><span>
                              <?php 
                                      
                  if($rowp->printing=="Mono"){ ?>
                              <?php $rowp->printing = "Black Only"; ?>
                              <?php } ?>
    
                              <?= $rowp->printing ?>
                              </span>
                              <?php if ($rowp->designs > 0) { ?>
                              <i class="mdi mdi-check"></i> <span>
                              <?php $des = ($rowp->designs > 1 )?"Designs":"Design"; ?>
                              <?= $rowp->designs .' '. $des ?>
                              </span>
                              <?php } ?>
                              <?php 
                      
    if ($carRes[0]->format == 'Roll') { ?>
    <span class="invoice-bold">
      <strong style="font-size:12px;">Wound:</strong>
      <?php if(!empty($rowp->wound)) echo $rowp->wound;?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">Orientation:</strong>
      <?php if(!empty($rowp->core)) echo $rowp->core; ?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">Finish:</strong>
      <?= $rowp->finish ?>
    </span> 
   
    <?php } ?>

  </td>
               
  <td class="text-center"> 
    <?php 
    if ($carRes[0]->format != 'Roll'){
    ?>
    <?=$symbol ?>5.32
    <br>
    Per Design
    <?php
    }
    ?>
  </td>
  <td class="text-center">
    <?php 
    if($quotationDetail->regmark != 'Y' && $carRes[0]->format != 'Roll'){ 
      $des=  ($rowp->designs > 1 )?"Designs":"Design";
      echo $rowp->designs.' '.$des;
                    
    ?>
               
    <?  }?>
    <br>
  </td>
          
  <td class="text-center"><?=$symbol ?><?= number_format(($quotationDetail->Print_Total * $exchange_rate), 2) ?></td>
             
</tr>
                          <?php } ?>
                          
                          
                          
 <?php } ?>
              

                          
                          
                          
                          <?php }elseif($quotationDetail->Printing == 'Y' && $quotationDetail->regmark !='Y'){
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
                                <?php /*if($quotationDetail->pressproof !=null && $quotationDetail->pressproof !="" && $quotationDetail->ProductBrand == 'Roll Labels'){?>
                                <span class="invoice-bold"><strong style="font-size:12px;">Press Proof:</strong> <?=($quotationDetail->pressproof == 0)?'No':'Yes'?></span>
                                <?php }*/?>

                            </td>
                           
                            <td class="text-center">
                            <?php 
                               if($quotationDetail->ProductBrand != 'Roll Labels'){
                                echo $symbol ?>5.32<br>
                                 Per Design
                            <?
                               }
                               ?>
                             <br>
                             </td>
                            <td class="text-center">
                               <?php
                               echo  $quotationDetail->Print_Qty.'&nbsp;Design';
                               ?> 
                               <br> 
                            <?php 
                               if($quotationDetail->ProductBrand != 'Roll Labels'){
                                echo  $quotationDetail->Free.'&nbsp;Designs Free';
                               }?>
                            </td>
                            <td class="text-center"><?=$symbol?><?= number_format(($quotationDetail->Print_Total * $exchange_rate), 2)?></td>
                            
                        </tr>
                          
                          
                          <?php  /*if($quotationDetail->qp_proof=="Y"){ ?>
                          
                          <tr>
                            <td class="invoicetable_tabel_border" >
    
                              <?php if ($quotationDetail->qp_foc == 'Y')     {     echo 'Press Proof - Foc';} ?>
                              <?php if ($quotationDetail->qp_foc == 'other') {     echo $quotationDetail->qp_foc;} ?>
                              <?php if ($quotationDetail->qp_foc != 'Y' && $quotationDetail->qp_foc != 'other') {
                                 echo 'Up to '.$quotationDetail->qp_qty.' Designs';} ?>
          
                            </td>
                            <td class="invoicetable_tabel_border">Physical Press Proof, Pre-Press Approval Required</td>
                            <td class="text-center invoicetable_tabel_border" align="center">
                              <?php if($quotationDetail->qp_price!=0){ ?>
                              <?=$symbol?><?=number_format(($quotationDetail->qp_price / $quotationDetail->qp_qty) * $exchange_rate ,2,'.',''); ?> <br> each
                              <?php } else { ?>
                              <?=$symbol?><?='0.00'; ?>
                              <?php } ?>
                            </td>
  
                            <td class="invoicetable_tabel_border" align="center">
                              <?=$quotationDetail->qp_qty;?> <br>Press Proof 
                            </td>
  
                            <td class="text-center invoicetable_tabel_border" align="center">
                              <?=$symbol?><?=($quotationDetail->qp_price !="")?number_format($quotationDetail->qp_price * $exchange_rate,2,'.','') : '0.00' ?>
                            </td>

                          </tr>  
                          <?php $lineTotal += number_format($quotationDetail->qp_price * $quotation[0]->exchange_rate,2); ?>
                          
                                       
                          <?php  }*/ ?>

                        <?php }

                            elseif($quotationDetail->Printing == 'Y' && $quotationDetail->regmark =='Y'){?>
                        <tr>
                            <td></td>
                            <td><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                          
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <?php }}?>
													
						<?php
                         $delive = 0;
                         $delive =  number_format($quotation[0]->QuotationShippingAmount / vat_rate, 2,'.','');
                        ?>
													
                      <!--   <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>LINE TOTAL</td>
                            <td><?=$symbol?><?=number_format($lineTotal,2,'.','');?></td>
                        </tr> -->
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>DELIVERY</td>
                            <td><?=$symbol?><?= number_format( $delive * $exchange_rate, 2,'.','') ?></td>
                        </tr>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>SUBTOTAL</td> <? $lineTotal = $lineTotal + $delive; ?> 
                            <td><?=$symbol?><?=number_format($lineTotal * $exchange_rate, 2,'.','')?></td>
                        </tr>
                        
                        <? $linegrndTotal = $lineTotal*1.2;?>
                        <? $vattotal = $linegrndTotal - $lineTotal;?>
					
					 <?php if($quotation[0]->vat_exempt=="yes"){ $linegrndTotal = $lineTotal; ?>
                        <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>VAT EXEMPT</td> 
                            <td>-<?=$symbol?><?php echo number_format($vattotal * $exchange_rate,2,'.','') ?></td>
                        </tr>
					<?php } else{ ?>
                    <tr class="text-bold">
                            <td colspan="3"></td>
                            <td>VAT @ 20%</td>
                            <td><?=$symbol?><?php echo number_format($vattotal * $exchange_rate,2,'.','') ?></td>
						  </td>
                        </tr>
					<?php } ?>
						<tr class="text-bold">
                            <td colspan="3"></td>
                            <td>GRAND TOTAL</td>
                            <td><?=$symbol?><?=number_format($linegrndTotal* $exchange_rate,2,'.','');?></td>
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

</div>
    </div>
</div>
</div>
