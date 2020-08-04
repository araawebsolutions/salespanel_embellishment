<?php
//echo '<pre>'; print_r($quotationDetail); echo '</pre>';
$digitalCheck = ($quotationDetail->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';

if ($quotationDetail->regmark != 'Y') {

    ?>

    <tr <? if ($quotationDetail->Printing != 'Y') { ?> style="display: none" <? } ?> class="<?=$clr_class?>">

        <td></td>
        <td></td>

        <td colspan="1">

            <div class="btn-span"

                 id="artwork_section<?= $key ?>">



                <span class="labels-form" style="margin-right:25px !important;">

                <label class="select">

                <select id="digital<?= $key ?>" class="form-control no-padding m-10" name="digital">



                    <?php foreach ($digitalis as $digital) {



                        if ($digital->type == $digitalCheck || $digital->type == 'both') { ?>

                            <option value="<?= $digital->name ?>" <?php if ($digital->name == $quotationDetail->Print_Type) {

                                echo 'selected';

                            } ?>><?= $digital->name ?></option>

                        <?php }

                    } ?>

                </select>

                    <i></i>

                    </label>

                    </span>

                <?php if ($quotationDetail->ProductBrand == 'Roll Labels') { ?>
                    <span class="labels-form" style="margin-right:25px !important;">

                    <label class="select">

                    <select id="Orientation<?= $key ?>" class="form-control no-padding m-10">



                        <option value="1"<?php if ($quotationDetail->Orientation == '1') {

                            echo 'selected';

                        } ?>>Orientation 01

                        </option>

                        <option value="2"<?php if ($quotationDetail->Orientation == '2') {

                            echo 'selected';

                        } ?>>Orientation 02

                        </option>

                        <option value="3"<?php if ($quotationDetail->Orientation == '3') {

                            echo 'selected';

                        } ?>>Orientation 03

                        </option>

                        <option value="4"<?php if ($quotationDetail->Orientation == '4') {

                            echo 'selected';

                        } ?>>Orientation 04

                        </option>

                    </select>
                    <i></i>
                </label>

</span>

<span class="labels-form" style="margin-right:25px !important;">

                    <label class="select">

                    <select id="finish<?= $key ?>" class="form-control no-padding m-10">

                        <option value="No Finish"<?php if ($quotationDetail->FinishType == 'No Finish') {

                            echo 'selected';

                        } ?>>No Finish

                        </option>

                        <option value="Gloss Lamination"<?php if ($quotationDetail->FinishType == 'Gloss Lamination') {

                            echo 'selected';

                        } ?>>Gloss Lamination

                        </option>

                        <option value="Matt Lamination"<?php if ($quotationDetail->FinishType == 'Matt Lamination') {

                            echo 'selected';

                        } ?>>Matt Lamination

                        </option>

                        <option value="Gloss Varnish"<?php if ($quotationDetail->FinishType == 'Gloss Varnish') {

                            echo 'selected';

                        } ?>>Gloss Varnish

                        </option>

                        <option value="High Gloss Varnish"<?php if ($quotationDetail->FinishType == 'High Gloss Varnish') {

                            echo 'selected';

                        } ?>>High Gloss Varnish (Not Over-Printable)

                        </option>

                        <option value="Matt Varnish"<?php if ($quotationDetail->FinishType == 'Matt Varnish') {

                            echo 'selected';

                        } ?>>Matt Varnish

                        </option>

                    </select>
                    <i></i>
                </label></span>



              <span class="labels-form" style="margin-right:25px !important;">
                <label class="select">
                  <select id="wound<?= $key ?>" class="form-control no-padding m-10">
                    <option value="Outside" <? if ($quotationDetail->wound == "Outside") { ?> selected="selected"<? } ?>>
                      Outside Wound
                    </option>
                    <option value="Inside" <? if ($quotationDetail->wound == "Inside") { ?> selected="selected"<? } ?>>
                      Inside Wound
                    </option>
                  </select>
                  <i></i>
                </label>
              </span>

                    
              <span class="labels-form" style="margin-right:25px !important;">
                <input type="text" readonly value="<?= $quotationDetail->orignalQty ?>"class="form-control text-center allownumeric">
                <p>No of labels</p>
              </span>

              <!--<span class="no-padding m-10"><input type="checkbox" id="pressProf<?= $key ?>"

                        <?php if ($quotationDetail->pressproof == 1){ ?>checked
                        <?php } ?>name="pressprof" value="1"> <p
              style="font-size: 11px;color: #666;">Pressproof</p> </span>-->

              <?php } ?>

                <button id="artworki_for_quotat<?= $key ?>"

                        onclick="addToCart('<?= $quotationDetail->ManufactureID ?>',<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->Printing ?>',<?= $quotationDetail->ProductID ?>,'<?= $quotationDetail->QuotationNumber ?>','<?= $quotationDetail->ProductBrand ?>','quotaton_detail',<?= $key ?>)"

                        type="button"

                        class="m-10 btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork"

                        data-toggle="modal" data-target=".bs-example-modal-lga"><i

                            class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Upload Artwork

                </button>

                <span style="margin-left: 10px;">

                    <a id="edit_order_line" href="<?php echo main_url.'order_quotation/order/edit_emb_options/quotation_detail/'.$quotationDetail->QuotationNumber.'/'.$quotationDetail->SerialNumber; ?>" class="m-20 btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork" >&nbsp; Embellishment </a>

                </span>



            </div>

        </td>

        

        <?php if ($quotationDetail->Printing == 'Y'){ ?>

        <td align="center">   <?php
            if ($digitalCheck != 'Roll'){
                ?>
                <?=$symbol ?>5.32
                <br>
                Per Design
                <?php
            }
            ?></td>

        <td style="text-align:center">
					
				<?php 	
							$qt = $quotationDetail->Print_Qty;
							if($quotationDetail->ProductBrand == 'Integrated Labels') {
         $qt = $this->db->get_where('quotation_attachments_integrated',array('serial'=>$quotationDetail->SerialNumber))->num_rows();
         
         if($quotationDetail->Print_Qty!="0"){
           $qt = $quotationDetail->Print_Qty;
         }
							}
																										 
					 ?>
          
          
          <?php 
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
                      
        <?php if($digitalCheck=="A4"){ ?>
        (<?= $quotationDetail->Free.' '.$des_free?> Free)
        <?php } ?>

            <input class="form-control input-number text-center allownumeric " type="<?php if ($quotationDetail->Printing == 'Y') { echo 'hidden'; } ?>" id="design<?= $key ?>" value="<?php echo $qt ?>" <?php if ($quotationDetail->Printing == 'Y') {?> readonly <?php } ?>>
			</td>

        <!--<td><?php /*echo ($digitalCheck == 'roll')?$quotationDetail->Price:$quotationDetail->Print_Total*/ ?></td>-->

        <td class="text-center">

            <?php
            if ($quotationDetail->FinishTypePricePrintedLabels != '' && $quotationDetail->total_emb_cost != 0){
                if (!preg_match("/Roll Labels/i", $quotationDetail->ProductBrand)){
                    echo $symbol . (number_format(($quotationDetail->Print_Total * $exchange_rate)-$quotationDetail->total_emb_cost, 2, '.', ''));
                    $row_total_line += ($quotationDetail->Print_Total * $exchange_rate)-$quotationDetail->total_emb_cost;
                } else {
                    echo $symbol . (number_format(($quotationDetail->Print_Total * $exchange_rate), 2, '.', ''));
                    $row_total_line += ($quotationDetail->Print_Total * $exchange_rate)-$quotationDetail->total_emb_cost;
                }

            } else {
                echo $symbol . (number_format($quotationDetail->Print_Total * $exchange_rate, 2, '.', ''));
                $row_total_line += ($quotationDetail->Print_Total * $exchange_rate);
            }
            ?>
        </td>

        <td>

            <?php } ?>

        </td>

    </tr>

<?php } ?>