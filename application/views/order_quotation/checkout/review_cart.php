<? $currency_options = $this->cartModal->get_currecy_options();
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';
$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>
    <div class="tab-content">
      <div class="tab-pane show active" id="home1">
        <div class="card-box no-padding">
            <div class="table-responsive">
                <input type="hidden" id="l_q_n">
                <table class="table table-bordered table-striped" id="tabhidden">
                    <thead>
                    <tr class="card-heading-title">
                        <th class="text-center invoice-heading-text"></th>
                        <th class="text-center invoice-heading-text">Manufacturer ID</th>
                        <th class="text-center invoice-heading-text">Description</th>
                        <th class="text-center invoice-heading-text">Unit Price</th>
                        <th class="text-center invoice-heading-text">Quantity</th>
                        <th class="text-center invoice-heading-text">Ext.VAT</th>

                    </tr>
                    </thead>
                    <tbody id="main_checkout_trs">
                    <?php
           
                    $subtotal = 0;
                    $iscustomdie ='no';
                    foreach ($records as $key => $record) {
                        $subtotal = $subtotal + $record->TotalPrice + $record->Print_Total;
                        ?>
                   <?php if ($record->p_code == 'SCO1') {
                            $carRes = $this->user_model->getCartData($record->ID);
                            

                            ?>
            <tr id="line<?= $key ?>">
              <td class="text-center"> 
               <?php if ($record->p_code != 'SCO1') { ?> <img src="<?=ARTWORKS?>theme/images/images_products/Matt_White_Opaque_Permanent_Adhesive.gif"> <? } ?>
              </td>
              <td class="text-center"><?= $record->p_code ?>
                </td>
                <?php
                $mm = '';
                if($carRes[0]->height != null) {
                $mm=' x';
                }?>
              <td><b>Shape: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?>
                | <b>Format: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->format : '' ?>
                | <b>Size: </b>
                  <?= (isset($carRes[0])) ? $carRes[0]->width.'mm'.$mm  : '' .' x' ?>
                  <?= ((isset($carRes[0])) && $carRes[0]->height != null) ? (isset($carRes[0]) && $carRes[0]->width!="") ? $carRes[0]->width : '' : ($carRes[0]->height!="" && $carRes[0]->height!="NULL") ? $carRes[0]->height.'mm': '' ?>
                | <b>No.labels/Die: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?>
               
                <b>Across: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->across : '' ?>
                | <b>Around: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
                | <b>Corner Radious: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
                | <b>Perforation: </b>
                <?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>
              
                <br/></td>
                            
              <td class="text-center" id="checkout_unit_price<?= $key ?>"><?=$symbol ?><?= number_format($record->TotalPrice * $exchange_rate,3 ) ?>
                  
              </td>
              <td class="text-center" >
                <?php echo $record->Quantity ?>
                
            <?php
                  if($record->p_code != 'SCO1'){
              if($carRes[0]->format == 'Roll'){
                echo ($record->Quantity > 1)?"Rolls":"Roll";
             }else{
              echo ($record->Quantity > 1)?"Sheets":"Sheet";
               }
            ?>
              <br>
       <?php if($carRes[0]->format =='Roll'){ echo $carRes[0]->rolllabels.' labels';} else { echo ((($carRes[0]->across * $carRes[0]->around) * $record->Quantity) * $exchange_rate).' labels';} ?>
                
                <?php 
                        } ?>
                
              </td>
              <td class="text-center" id="checkout_price<?= $key ?>"><?=$symbol ?><?= number_format($record->TotalPrice * $exchange_rate, 2) ?></td>
                <input type="hidden"  id="is_customDie" value="<?= $record->p_code?>" />

            </tr>
            <?php    
              $iscustomdie = 'yes';
                            if (isset($carRes[0]) && $carRes[0]->ID != "") {
                                include('payment_cart_material.php');
                            }


                            ?>
            <?php } else { ?>
            <tr id="line<?= $key ?>">
               <?php
                                $minRoll = ($record->calculations['minRoll'] != '') ? $record->calculations['minRoll'] : 0;
                                $minLabels = ($record->calculations['minLabels'] != '') ? $record->calculations['minLabels'] : 0;
                                $maxRoll = ($record->calculations['maxRoll'] != '') ? $record->calculations['maxRoll'] : 0;
                                $maxLabels = ($record->calculations['maxLabels'] != '') ? $record->calculations['maxLabels'] : 0;
                                $labelPerSheet = ($record->calculations['labelPerSheet'] != '') ? $record->calculations['labelPerSheet'] : 0;
                                $printType = ($record->Printing == 'Y') ? $record->Printing : 'N';
                                $digitalCheck = ($record->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';

                ?>
              <td class="text-center"><img src="<?=ARTWORKS?>theme/images/images_products/material_images/<?= $record->Image1 ?>" ></td>
              <td class="text-center"><b>
                <?= ($record->ManufactureID != null) ? $record->ManufactureID : $record->p_code ?>
                </b><br>
                <input type="hidden" id="print<?= $key ?>" value="<?= $record->Printing ?>"></td>
              <td><?php if(preg_match("/Roll Labels/i",$record->ProductBrand)) {?>
                
                
                <?php   $ci =& get_instance();
                                
                    $reordercode = $this->shopping_model->product_reordercode($record->ProductID);
                    $reordercode = $reordercode[0]['ReOrderCode'];
                    $passvalue = ($record->Printing=="Y")?"":"plain";
					 
					if($record->Printing=="Y" and $record->regmark != 'Y'){
  echo $prodName =  $ci->orderModal->Printed_desc($record->wound,$record->Print_Type,$record->ProductCategoryName,$record->orientation,$record->FinishType);
}else{
  echo $prodName =  $ci->orderModal->customize_product_name($record->is_custom,$record->ProductCategoryName,$record->LabelsPerRoll,($record->orignalQty /$record->Quantity),$reordercode,$record->ManufactureID,$record->ProductBrand,$record->wound,$record->OrderData,$passvalue);
}             
                    //echo $prodName =  $ci->orderModal->customize_product_name($record->is_custom,$record->ProductCategoryName,$record->LabelsPerRoll,($record->orignalQty /$record->Quantity),$reordercode,$record->ManufactureID,$record->ProductBrand,$record->wound,$record->OrderData,$passvalue); ?>
                
                <?php } else { ?>
                
               
                <?= ($record->p_name != null) ? $record->p_name : $record->ProductCategoryName ?>
                
                
                <?php } ?>
             
              <?php if($record->regmark == 'Y'){ ?>
              <b>Printing Service (Black Registration Mark on Reverse)</b>
              <?php }?>
                <div class="btn-span"
                                         id="artwork_section<?= $key ?>" <? if ($record->Printing != 'Y') { ?> style="display: none" <? } ?>> &nbsp;&nbsp; </div>
              </td>
              
              <td class="text-center" id="checkout_unit_price<?= $key ?>">
                <?=$symbol ?><?= number_format(($record->TotalPrice /$record->orignalQty) * $exchange_rate, 3) ?>
              <br> 
              <?php 
               if($record->ManufactureID != '')
                echo "Per Label";
              ?>
                
              <td class="text-center"><?= $record->Quantity ?>&nbsp;
                <?php if($record->ProductBrand == 'Roll Labels' ){ echo 'Rolls';?>
                <br>
                <?php 
                if($record->is_custom == 'No' ){
                   echo $record->orignalQty; 
                }else{
                   echo $record->LabelsPerRoll * $record->Quantity;
                }

                ?>
                 
             <? }else{
                 if($record->ManufactureID != ''){
                  echo "Sheets".'<br>';
                  echo $record->calculations['labelPerSheet'] * $record->Quantity.'&nbsp' ;
                 }
             }
                          
             if($record->ManufactureID != '')
             echo "Labels";
            ?>

             </td>
              <td class="text-center" id="checkout_price<?= $key ?>"><?=$symbol ?><?= number_format($record->TotalPrice * $exchange_rate, 2) ?></td>

            </tr>
            <?php if ($record->Printing == 'Y' && $record->regmark != 'Y') { ?>
            <tr>
              <td></td>
              <td></td>
            <td>
                  <i class="mdi mdi-check"></i><span>
                                  <?php 
                                  
                                  if($record->Printing=="Fullcolour"){ ?>
									                             <?php $record->Print_Type = "4 Colour Digital Process"; ?>
                                    <?php } ?>
                                    <?= $record->Print_Type ?>
                                    </span>
                                    <?php if ($record->Print_Qty > 0) { ?>
                                    <i class="mdi mdi-check"></i> <span>
                                    <?= $record->Print_Qty . '  Design' ?>
                                    </span>
                                    <?php } ?>
                                    <?php 
                                    
                                    if ($digitalCheck == 'roll') { ?>
                                    <span class="invoice-bold"><strong
                                                                                    style="font-size:12px;">Wound:</strong>
                                    <?php if(!empty($record->Wound)) echo $record->Wound;?>
                                    </span> <span class="invoice-bold"><strong
                                                                                    style="font-size:12px;">Orientation:</strong>
                                    <?php if(!empty($record->Orientation)) echo $record->Orientation; ?>
                                    </span> 
              <?php if(!empty($record->FinishType)){ ?>
              <span class="invoice-bold">
                <strong  style="font-size:12px;">Finishs:</strong>
                <?= $record->FinishType ?>
              </span> 
              <?php } ?>
              
              
              <span class="invoice-bold"><strong
                                                                                    style="font-size:12px;">Press Proof:</strong>
                                    <?= ($record->pressproof == 1) ? 'Yes' : 'No' ?>
                                    </span>
                                    <?php } ?>

              </td>
               <?php
               // if ($record->Printing == 'Y' && $digitalCheck != 'roll') { ?>
              <td class="text-center"> 
                
                <?php 
                if ($digitalCheck != 'roll'){
                ?>
                <?=$symbol ?>5.32
                <br>
                Per Design
                <?php } ?>
             </td>
              <td class="text-center">
             <?php 
                if($record->regmark != 'Y'){ 
                echo $record->Print_Qty;
                
            ?>
                &nbsp; Design
                <?
            }?>
               <br>
            <?php
            if ($digitalCheck != 'roll'){
                  if($record->Quantity <= 99 ){
                    echo "(1 Design Free)";
                  }elseif ($record->Quantity <= 199){
                     echo "(2 Designs Free)";
                 }elseif ($record->Quantity <= 299) {
                     echo "(3 Designs Free)";
                 }elseif ($record->Quantity <= 399) {
                     echo "(4 Designs Free)";
                 }elseif ($record->Quantity <= 499) {
                    echo "(5 Designs Free)";
                 }elseif ($record->Quantity <= 999) {
                     echo "(6 Designs Free)";
                 }elseif ($record->Quantity <= 2499) {
                      echo "(7 Designs Free)";
                 }elseif ($record->Quantity <= 4999) {
                      echo "(8 Designs Free)";
                 }elseif ($record->Quantity <= 9999) {
                     echo "(9 Designs Free)";
                 }elseif ($record->Quantity <= 14999) {
                      echo "(10 Designs Free)";
                 }elseif ($record->Quantity <= 19999) {
                      echo "(11 Designs Free)";
                 }elseif ($record->Quantity <= 29999) {
                      echo "(12 Designs Free)";
                 }elseif ($record->Quantity <= 39999) {
                      echo "(13 Designs Free)";
                 }elseif ($record->Quantity <= 40000) {
                      echo "(14 Designs Free)";    
                 }
             }

                ?>
              </td>
        
              <td class="text-center"><?=$symbol ?><?= number_format(($record->Print_Total * $exchange_rate), 2) ?></td>
              <?
                //}
             ?>
            </tr>
            <?php
                }
                 }
                    } ?>
                        <input type="hidden" id="id_custom" value="<?php echo $iscustomdie ?>">
          </tbody>
          <tr>
            <td colspan="5" class="text-right"><strong>SUB TOTAL</strong></td>
            <td colspan="5"><strong id="sub_total">
              <?=$symbol ?><?= number_format($subtotal*$exchange_rate, 2) ?>
              </strong> Ex. Vat </td>
          </tr>
<? 
 $BasicCharges = $this->session->userdata('BasicCharges');
 $disuntoffer = $this->cartModal->checkwtpDiscount($subtotal);
?>          
          
         
          <tr>
            <td colspan="5" class="text-right"><strong>Voucher Discount:</strong></td>
            <td colspan="5">
              <strong> <?=$symbol?><?= number_format($disuntoffer * $exchange_rate, 2) ?></strong></td>
          </tr>
          
           <tr>
           <td colspan="5" class="text-right"><strong>DELIVERY</strong></td>
            <td colspan="5"><strong id="sub_total">
              <?php 
                 $BasicCharges = $BasicCharges/1.2;
                 $delivery_charges = $BasicCharges * $exchange_rate;
                 echo $symbol . number_format(($delivery_charges), 2) ?> 
              </strong> Ex. Vat </td>
          </tr>
          
                  

<?
$subtotal = $subtotal - $disuntoffer;
$totalexvat  =   $subtotal + $BasicCharges;
$totalincvat =  ($subtotal*1.2) + ($BasicCharges*1.2);
$vat = $totalincvat - $totalexvat;
?>          
          <tr>
           <td colspan="5" class="text-right"><strong>VAT @20%</strong></td>
            <td colspan="5"><strong id="sub_total">
              <?php 
                 echo $symbol . number_format($vat*$exchange_rate, 2) ?> 
                      
              </strong>  </td>
          </tr>
          
          <tr>
            <td colspan="5" class="text-right"><strong>GRAND TOTAL</strong></td>
            <td colspan="5"><strong id="grand_total">
              <?=$symbol ?><?= number_format($totalincvat*$exchange_rate, 2) ?>
              </strong> In. Vat </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>