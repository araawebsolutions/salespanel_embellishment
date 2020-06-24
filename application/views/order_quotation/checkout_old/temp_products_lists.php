<?php $currency_options = $this->cartModal->get_currecy_options();
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>
<div class=" labels-form">
    <label class="select ">
    <select class="currency-convert-input"
        style="color:#000 !important;width:80px !important; float:right;margin-bottom: 20px;"
        onchange="set_currency(this.value);">
  <?php foreach ($currency_options as $row) { ?>
  <option class="curency"
                value="<?= $row->currency_code ?>" <?= ($row->currency_code == $currency) ? 'selected="selected"' : '' ?>>
  <?= $row->currency_code ?>
  (
  <?= $row->symbol ?>
  ) </option>
  <?php } ?>
</select>
        <i></i>
    </label>
</div>
<div class="tab-content">
  <div class="tab-pane show active" id="home1">
    <div class="card-box no-padding">
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="card-heading-title">
              <th class="text-center invoice-heading-text"></th>
              <th class="text-center invoice-heading-text">Manufacturer ID</th>
              <th class="text-center invoice-heading-text">Description</th>
              <th class="text-center invoice-heading-text">Unit Price</th>
              <th class="text-center invoice-heading-text">Quantity</th>
              <th class="text-center invoice-heading-text">Ext.VAT</th>
              <th class="text-center invoice-heading-text">Action</th>
            </tr>
          </thead>
          <tbody id="main_checkout_trs">
          <input type="hidden" value="<?=count($records)?>" id="to_rec">
          <?php
                    $extPrice = 0;
								 

                    foreach ($records as $key => $record) {
// 					
                      $extPrice = $extPrice + $record->TotalPrice + $record->Print_Total;
                    
                        ?>
                          <?php if ($record->p_code == 'SCO1') {
                            $carRes = $this->user_model->getCartData($record->ID);
                            //echo '<pre>'; print_r($carRes); echo '</pre>';
                            ?>
          <tr id="line<?= $key ?>">
            <td class="text-center">
							<!--<img src="<?=ARTWORKS?>theme/images/images_products/Matt_White_Opaque_Permanent_Adhesive.gif" width="38" height="54" alt="Product Image">-->
						</td>
            <td class="text-center"><?= $record->p_code ?></td>

            <?php
            $mm = '';
            if($carRes[0]->height != null) {
                $mm=' x';
            }

            ?>
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
              <br/>
              <br/>
              <button class="custom-die-cta" type="button" onclick="editCustomDie(<?= $key ?>,<?= $record->ID ?>)">Edit
              Custom Die </button>
              <?php if ((isset($carRes[0])) && $carRes[0]->discount == 0) { ?>
              <button class="custom-die-cta" id="applydis<?= $key ?>" type="button"
                                                onclick="changeDisVal(<?= $key ?>,<?= $record->ID ?>)" style="cursor:pointer">Check Discount </button>
              <button class="custom-die-cta" id="deletedis<?= $key ?>" type="button" style="display: none"
                                                onclick="deleteDisVal(<?= $key ?>,<?= $record->ID ?>)" style="cursor:pointer">Delete Discount </button>
              <?php } else { ?>
              <button class="custom-die-cta" id="deletedis<?= $key ?>" type="button"
                                                onclick="deleteDisVal(<?= $key ?>,<?= $record->ID ?>)" style="cursor:pointer">Delete Discount </button>
              <button class="custom-die-cta" id="applydis<?= $key ?>" style="display: none" type="button"
                                                onclick="changeDisVal(<?= $key ?>,<?= $record->ID ?>)" style="cursor:pointer">Check Discount </button>
              <?php } ?></td>
            <td id="checkout_unit_price<?= $key ?>"><?=$symbol?><?= $record->TotalPrice ?></td>
            <td><input type="text" id="1" value="1"
                                           class="form-control input-number text-center allownumeric" name="quant1" readonly></td>
            <td id="checkout_price<?= $key ?>"><?=$symbol ?><?= number_format($record->TotalPrice * $exchange_rate, 2) ?></td>
            <td class="padding-6 icon-tablee"><span class="btn-span"> <i class="fa fa-trash-o bt-delete" onclick="deleteLineFromCart(<?= $key ?>,<?= $record->ID ?>)"></i> </span></td>
          </tr>
          <?php
                            if (isset($carRes[0]) && $carRes[0]->ID != "") {
                                include('cart_material.php');
                            }


                            ?>
          <?php }
                        else { ?>
          <?php if ($record->ProductID == 0) { ?>
          <tr id="tr_for_update_line">
            <td></td>
            <td><input class="form-control input-number text-center" type="text"
                                               id="update_line_man<?= $key ?>" value="<?= $record->p_code ?>"></td>
            <td><textarea class="form-control input-number text-center"
                                                  style="height: 35px;"
                                                  id="update_line_des<?= $key ?>"><?= $record->p_name ?>
</textarea></td>
            <td><input class="form-control input-number text-center" type="text"
                                               id="update_line_price<?= $key ?>"
                                               value="<?=$symbol ?><?= number_format($record->orignalQty / $record->Quantity,2,'.','') ?>"></td>
            <td>
							<input class="form-control input-number text-center allownumeric" type="text"
                                               id="update_line_qty<?= $key ?>" value="<?= $record->Quantity ?>">
						</td>
            <td><?=$symbol ?><?= number_format($record->TotalPrice * $exchange_rate, 2) ?></td>
            <td class="padding-6 icon-tablee">
								<i class="fa fa-floppy-o bt-save"  onclick="updateNewLine(<?= $record->ID ?>,<?= $key ?>)"></i>
							<i class="fa fa-trash-o bt-delete" id="delete<?= $key ?>"
                                           onclick="deleteLineFromCart(<?= $key ?>,<?= $record->ID ?>)"></i> 
						</td>
          </tr>
          <?php }

                            else {
                                ?>
          <tr id="line<?= $key ?>">
            <?php
                                    $minRoll = ($record->calculations['minRoll'] != '') ? $record->calculations['minRoll'] : 0;
                                    $minLabels = ($record->calculations['minLabels'] != '') ? $record->calculations['minLabels'] : 0;
                                    $maxRoll = ($record->calculations['maxRoll'] != '') ? $record->calculations['maxRoll'] : 0;
                                    $maxLabels = ($record->calculations['maxLabels'] != '') ? $record->calculations['maxLabels'] : 0;
                                    $labelPerSheet = ($record->calculations['labelPerSheet'] != '') ? $record->calculations['labelPerSheet'] : 0;
                                    $printType = ($record->Printing == 'Y') ? $record->Printing : 'N';
                                    $digitalCheck = ($record->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';
                                    $calco = $this->home_model->getProductCalculation($record->ProductID, $record->ManufactureID);
                                    ?>
            <input type="hidden" id="minroll<?= $key ?>"
                                           value="<?= $calco['minRoll'] ?>">
            <input type="hidden" id="maxroll<?= $key ?>"
                                           value="<?= $calco['maxRoll'] ?>">
            <input type="hidden" id="minlabel<?= $key ?>"
                                           value="<?= $calco['minLabels'] ?>">
            <input type="hidden" id="maxlabel<?= $key ?>"
                                           value="<?= $calco['maxLabels'] ?>">
            <td class="text-center"><img src="<?=ARTWORKS?>/theme/images/images_products/material_images/<?= $record->Image1 ?>"></td>
            <td class="text-center"><b>
              <?= $record->ManufactureID ?>
              </b><br>
              <?php if ($record->ManufactureID != null && $record->regmark != 'Y' && ($record->OrderData != 'Sample' || $record->OrderData != 'sample') ) { ?>
                <div class=" labels-form">
                    <label class="select ">
              <select class="form-control"
                                                    onchange="changeLineType(this,<?= $key ?>,<?= $record->ID ?>,'<?= $printType ?>','<?= $record->ProductBrand ?>','<?= $record->ManufactureID ?>',<?= $record->ProductID ?>,'<?= $record->ProductBrand ?>')">
                <option value="N" <?php if ($record->Printing == '' || $record->Printing == 'N') {
                                                    echo 'selected';
                                                } ?>>Plain </option>
                <option value="Y" <?php if ($record->Printing == 'Y') {
                                                    echo 'selected';
                                                } ?>>Printed </option>
              </select>
                        <i></i>
                    </label></div>
              <?php } ?>
              <input type="hidden" id="print<?= $key ?>" value="<?= $record->Printing ?>"></td>
            <td>
				<?php if(preg_match("/Roll Labels/i",$record->ProductBrand)) {?>
				
				
				<?php 	$ci =& get_instance();
								
					$reordercode = $this->shopping_model->product_reordercode($record->ProductID);
            		$reordercode = $reordercode[0]['ReOrderCode'];
								
					echo $prodName =  $ci->orderModal->customize_product_name($record->is_custom,$record->ProductCategoryName,$record->LabelsPerRoll,$record->calculations['labelPerSheet'],$reordercode,$record->ManufactureID,$record->ProductBrand,$record->wound,$record->OrderData); ?>
				
				<?php } else { ?>
				
				<?= ($record->ProductCategoryName != null) ? $record->ProductCategoryName : $record->p_name ?>
				<?php } ?>
				
			
             
              <?php if($record->regmark == 'Y'){ ?>
              <b>Printing Service (Black Registration Mark on Reverse)</b>
              <?php }?>

              </div>
			
			</td>
            <td id="checkout_unit_price<?= $key ?>"><?=$symbol ?><?= number_format(($record->TotalPrice /$record->Quantity) * $exchange_rate, 2) ?></td>
            <td><input type="text"
                                               onchange="changelabels(this.value,<?= $record->LabelsPerRoll ?>,<?= $key ?>)"
                                               id="qty<?= $key ?>"
                                               value="<?= $record->Quantity ?>" <?php if ($record->Printing == 'Y'  || $record->OrderData == 'Sample' || $record->OrderData == 'sample'){ ?>
                                               readonly
                                               <?php } ?>class="form-control input-number text-center allownumeric"
                                               name="qty<?= $key ?>">
                                               
                                               
              <input type="hidden" id="totalLabels<?= $key ?>" value="<?= $record->orignalQty ?>">
              <?php
                                        $artworkCount = $this->orderModal->countArtworkStatus($record->ID);
                                        ?>
              <input type="hidden" id="arwtork_qty<?= $key ?>" value="<?=$artworkCount[0]->count?>">
              <input type="hidden" id="artwork_labels<?= $key ?>" value="<?=$artworkCount[0]->totalQuantity?>"></td>
            <td id="checkout_price<?= $key ?>"><?=$symbol ?><?= number_format($record->TotalPrice * $exchange_rate, 2) ?></td>
            <td class="padding-6 icon-tablee">
							<i class="fa fa-plus bt-plus" id="update<?= $key ?>" onclick="noteForCart(<?= $key ?>,'<?= $record->ID ?>')"></i>
                                                           
						<?php	if( ($record->OrderData != 'Sample' || $record->OrderData != 'sample') && $record->regmark != 'Y') {?>
							<i class="fa fa-floppy-o bt-save updateMe<?= $key ?>" id="updateMe"
                                           onclick="updateLinePrice('<?= $key ?>','<?= $record->ID ?>','<?= $printType ?>','<?= $record->ProductBrand ?>','<?= $record->ManufactureID ?>','<?= $record->ProductID ?>','<?= $record->pressproof ?>','<?= $record->UserID ?>','<?= $record->regmark ?>','<?= $record->calculations['labelPerSheet']?>','<?= $record->orignalQty ?>')"></i> 
							<?php } ?>
							<i class="fa fa-trash-o bt-delete" id="delete<?= $key ?>" onclick="deleteLineFromCart(<?= $key ?>,<?= $record->ID ?>)"></i>
							<input type="hidden" id="totalQty<?= $key ?>" value="<?= $record->orignalQty?>">
							</td>
          </tr>
          <?php if ($record->Printing == 'Y' &&  $record->regmark != 'Y') { ?>
          <tr>
            <td></td>
            <td></td>
            <td> 
							<div class="btn-span"
                      id="artwork_section<?= $key ?>" <?php if ($record->Printing != 'Y') { ?> style="display: none" <?php } ?>>
                    <?php if ($record->Printing == 'Y' && $record->regmark != 'Y') {  //echo '<pre>'; print_r($digitalis); echo '</pre>';?>

                        <div class=" labels-form">
                            <label class="select ">
                                <select id="digital<?= $key ?>" class="form-control no-padding"
                                        name="digital">
                                    <option value="">Please Select Digital Process </option>
                                    <?php foreach ($digitalis as $digital) {

                                        if ($digital->type == $digitalCheck || $digital->type == 'both') { ?>
																	
                                            <?php if($record->ProductBrand!='Roll Labels'){?>
                                            <option value="<?= $digital->name ?>"
                                            <?php if ($digital->name == $record->Print_Type || $digital->Print_Type == $record->Print_Type) {
                                            echo 'selected';
                                            } ?>>
                                            
                                            <?=$digital->name?>
                                            <?//$digital->name.'=sheet=='.$digitalCheck."------".$digital->Print_Type."----".$record->Print_Type."--".$record->ProductBrand; ?>
                                            
                                            </option>
                                            <?php } else{?>
                                            <option value="<?= $digital->name ?>"
                                            <?php if ($digital->name == $record->Print_Type || $digital->Print_Type == $record->Print_Type) {
                                            echo 'selected';
                                            } ?>>
                                            <?=$digital->name?>
                                            </option>
                                            <?php } ?>
																	
                                        <?php }
                                    } ?>
                                </select>
                                <i></i>
                            </label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <?php if ($record->ProductBrand == 'Roll Labels' && $record->Printing == 'Y' && $record->regmark != 'Y') { ?>
                        <div class=" labels-form" style="margin-right: 10px;">
                            <label class="select ">
                                <select id="Orientation<?= $key ?>"  class="form-control no-padding">
                                    <option value="">Please Select Orientation</option>
                                    <option value="1"<?php if ($record->orientation == '1') {
                                        echo 'selected';
                                    } ?>>Orientation 01 </option>
                                    <option value="2"<?php if ($record->orientation == '2') {
                                        echo 'selected';
                                    } ?>>Orientation 02 </option>
                                    <option value="3"<?php if ($record->orientation == '3') {
                                        echo 'selected';
                                    } ?>>Orientation 03 </option>
                                    <option value="4"<?php if ($record->orientation == '4') {
                                        echo 'selected';
                                    } ?>>Orientation 04 </option>
                                </select>
                                <i></i>
                                &nbsp;&nbsp;</label></div>
                        <div class=" labels-form" style="margin-right: 10px;">
                            <label class="select ">
                                <select id="wound<?= $key ?>" class="form-control no-padding">
                                    <option selected="selected" value="">Select Wound Type</option>
                                    <option value="Outside"<?php if ($record->wound == 'Outside') {
                                        echo 'selected';
                                    } ?>>Out Side Wound</option>
                                    <option value="Inside"<?php if ($record->wound == 'Inside') {
                                        echo 'selected';
                                    } ?>>Inside Wound </option>
                                </select>
                                <i></i>
                                &nbsp;&nbsp;</label></div>
                        <div class=" labels-form">
                            <label class="select ">
                                <select id="finish<?= $key ?>" class="form-control no-padding">
                                    <option selected="selected" value="">Select Label Finish</option>
                                    <option value="No Finish"<?php if ($record->FinishType == 'No Finish') {
                                        echo 'selected';
                                    } ?>>No Finish </option>
                                    <option value="Gloss Lamination"<?php if ($record->FinishType == 'Gloss Lamination') {
                                        echo 'selected';
                                    } ?>>Gloss Lamination </option>
                                    <option value="Matt Lamination"<?php if ($record->FinishType == 'Matt Lamination') {
                                        echo 'selected';
                                    } ?>>Matt Lamination </option>
                                    <option value="Gloss Varnish"<?php if ($record->FinishType == 'Gloss Varnish') {
                                        echo 'selected';
                                    } ?>>Gloss Varnish </option>
                                    <option value="High Gloss Varnish"<?php if ($record->FinishType == 'High Gloss Varnish') {
                                        echo 'selected';
                                    } ?>>High Gloss Varnish (Not Over-Printable) </option>
                                    <option value="Matt Varnish"<?php if ($record->FinishType == 'Matt Varnish') {
                                        echo 'selected';
                                    } ?>>Matt Varnish </option>
                                </select>
                                <i></i>
                            </label></div>
                        &nbsp;&nbsp;
                        <?php if ($digitalCheck == 'roll') { ?>
                            	<span class="no-padding m-10">
                            	<input type="checkbox" id="pressProf<?= $key ?>" <?php if ($record->pressproof == 1){ echo 'checked'; }?> name="pressprof"  value="1">
                            	<p style="font-size: 11px;color: #666;text-align: center">Pressproof</p>
                            	</span>
                           <?php } ?>

                    <?php } ?>
                    <?php if ($record->Printing == 'Y' && $record->regmark != 'Y') { ?>
                        <button type="button" id="artworki_for_cart<?=$key?>" style="padding-right: 10px"  onclick="getTempProductsArtworks(<?= $key ?>,<?= $record->ID ?>,'<?= $record->ProductBrand ?>','<?= $record->ManufactureID ?>',<?= $record->ProductID ?>)"
                                class="btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork"  data-toggle="modal" data-target=".bs-example-modal-lga"><i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;
                            Click here to Upload Your Artwork </button>
                    <?php } ?>
                    <input type="hidden" id="artworkNeeded"
                           value="<?php echo ($record->Printing == 'Y') ? 'Yes' : 'NO' ?>"></td>
            <td></td>
            <td>
				<?php 	
					$qt = $record->Print_Qty;
					if($record->ProductBrand == 'Integrated Labels') {
						$qt = $this->db->get_where('integrated_attachments',array('CartID'=>$record->ID))->num_rows();
					}
										 
					 ?>
							
			<input class="form-control input-number text-center allownumeric" type="text" id="design<?= $key ?>"readonly="readonly" value="<?= $qt ?>">
						
			</td>
            <td><?=$symbol ?><?= number_format($record->Print_Total * $exchange_rate, 2) ?></td>
            <td></td>
          </tr>
          <?php }
                            }
                        }
                ?>
                
                
            <tr id="order_note_line<?= $key ?>" <?php if ($record->Product_detail == null) { ?> style="display: none;" <?php } ?>>
		  	<td></td>
			<td></td>
			<td><input type="text" required id="note_for_od<?= $key ?>"
							 value="<?= $record->Product_detail ?>"
							 class="form-control input-number  allownumeric"></td>
			<td></td>
			<td class="text-center"></td>
			<td></td>
			<td class="padding-6 icon-tablee">
				<i class="fa fa-trash-o bt-delete"
                	onclick="deleteNoteForCart(<?= $key ?>,<?= $record->ID ?>)"> </i> <i class="fa fa-floppy-o bt-save"
                    onclick="insertNoteForCart(<?= $key ?>,<?= $record->ID ?>)"></i>
			</td>
          </tr>    
                
                <?    } ?>
          <tr style="display: none" id="tr_for_nw_line">
            <td></td>
            <td><input class="form-control input-number text-center" type="text"
                                   id="new_line_man"></td>
            <td><textarea class="form-control input-number text-center "
                                      style="height: 35px;" id="new_line_des"></textarea></td>
            <td><input class="form-control input-number text-center allownumeric" placeholder="unit price"
                                   type="text" id="new_line_price"></td>
            <td><input class="form-control input-number text-center allownumeric" placeholder="quantity"
                                   type="text" id="new_line_qty"></td>
            <td></td>
            <td class="padding-6 icon-tablee"><i class="fa fa-floppy-o bt-save" onclick="addNewLine()"></i>
                <i class="fa fa-trash-o bt-delete" id="delete<?= $key ?>"
                   onclick="deleteLineFromCart()"></i>
            </td>
          </tr>
            </tbody>
          
          <tr>
            <td colspan="5" class="text-right"><strong>SUB TOTAL</strong></td>
            <td colspan="5"><strong
                                    id="sub_total">
              <?=$symbol?><?= number_format($extPrice * $exchange_rate, 2) ?>
              </strong> Ex. Vat </td>
          </tr>
          <tr>
            <td colspan="5" class="text-right"><strong>GRAND TOTAL</strong></td>
            <td colspan="5"><strong
                                    id="grand_total">
              <?=$symbol ?><?= number_format(($extPrice * $exchange_rate) * vat_rate, 2) ?>
              </strong> In. Vat </td>
          </tr>
        </table>
      </div>

      <div class="row m-t-t-10" id="onlypayment">
        <div class="col-md-12 pull-left margin-left-10"> 
					<span id="showNwLine">
          <button type="button" onclick="showNwLine()" class="btn btn-successs waves-light waves-effect">ADD NEW LINE</button>
          </span> <span style="display: none" id="hideNwLine">
          <button type="button" onclick="hideNwLine()" class="btn btn-successs waves-light waves-effect">Hide LINE</button>
          </span> <span>
          <button type="button" onclick="setUpCharge('cancel')" class="btn btn-info waves-light waves-effect">SET-UP CHARGE</button>
          </span> <span class="pull-right margin-right-31">
          <button type="button" onclick="showMyPaymentSection()" class="btn btn-outline-dark waves-light waves-effect btn-countinue">CHECKOUT <i class="mdi mdi-arrow-right-bold-circle"></i> </button>
          </span> </div>
      </div>

    </div>
  </div>
</div>
</div>
</div>
