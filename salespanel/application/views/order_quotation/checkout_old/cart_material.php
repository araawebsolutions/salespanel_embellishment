<style>
    .cursor {
        margin-left: 10px;
        color: blue;
        cursor: pointer;
    }

    .matstyle {
        width: 150px;
        margin-left: 5px;
    }

    .hide {
        display: none;
    }

    .err {
        color: crimson;
        font-size: 10px;
        display: none;
    }

    .no-ioffdeign {
        -moz-appearance: none;
        background: #fff;
        border-radius: 5px;
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
        display: block;
        height: 35px !important;
        outline: 0;
        padding: 8px 10px;
        width: 100%;
        font-weight: 400 !important;
        border-color: #bababa;
        color: #817d7d;
        font-size: 11px;
    }
</style>



<?
$scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);

$assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
$asformat = ($scorecord['format'] == "Roll") ? "roll" : "sheet";
$ci =& get_instance();

?>


<? $cc = 1;
//echo '<pre>'; print_r($assoc); echo '</pre>';

	



foreach ($assoc as $rowp) {
	
    $eprintoption = ($rowp->labeltype == "printed") ? "display:block" : "display:none"; 
	
	$matInfo = $ci->cartModal->fetchmaterinfo($rowp->ID);
	$records = $ci->cartModal->fetchdierecordinfo($matInfo['OID']);
	
	//echo '<pre>'; print_r($records); echo '</pre>';
	
	$matInfo_size = $matInfo['core'];
	
	if($matInfo_size == 25){ $matInfo_size =  1; }else if($matInfo_size == 38){ $matInfo_size =  2; }else if($matInfo_size == 44.5){ 
		$matInfo_size =  3; }else if($matInfo_size == 76){ $matInfo_size =  4; }
	
	
	$cors = 1;
	if($matInfo_size!=""){
		$cors = $matInfo_size;
	}
	
	
	 $productCode = $records['die_code'] . $matInfo['material'];
	
	if($asformat=="sheet"){
		$productCode = 'AA'.$productCode;
	}
	
	
	$min_qty = $ci->home_model->min_qty_roll($productCode.$cors); 
	$max_qty_rol = $ci->home_model->max_qty_roll($productCode.$cors); 
	
	$product = $this->cartModal->getProductId($productCode);
    $max_qty = $product['LabelsPerSheet'];
	
	
	if (preg_match("/A3/", $records['format'])) {
        $min_qtys = '100';
        $max_qtys = '50000';
        $type = 'A3';
    } else if (preg_match("/SRA3/", $records['format'])) {
        $min_qtys = '100';
        $max_qtys = '20000';
        $type = 'SRA3';
    } else {
        $min_qtys = '25';
        $max_qtys = '50000';
        $type = 'A4';
    }
	
	if (preg_match("/PETC/", $matInfo['material']) || preg_match("/PETH/", $matInfo['material']) || preg_match("/PVUD/", $matInfo['material'])) {
		//$min_qty = '25';
		$min_qtys= '5';
		$max_qtys = '5000';
	}


?>


    <!-- --------------------------------------------------->  <!-- --------------------------------------------------->



    <tr id="asscomat<?= $rowp->ID ?>">

        <td>
            <input type="hidden" id="row_id<?= $key ?>" value="<?= $rowp->ID ?>">
            <input type="hidden" id="format<?= $key ?>" value="<?= $asformat ?>">
            <input type="hidden" id="label_type<?= $key ?>" value="<?= $rowp->labeltype ?>">
			
			<input type="hidden" id="max_roll<?= $rowp->ID ?>" value="<?= $min_qty ?>">
            <input type="hidden" id="max_lb<?= $rowp->ID ?>" value="<?= $max_qty ?>">
			<input type="hidden" id="max_roll_qty<?= $rowp->ID ?>" value="<?= $max_qty_rol ?>">
			
			<input type="hidden" id="min_sheet<?= $rowp->ID ?>" value="<?= $min_qtys ?>" />
			
			<input type="hidden" id="die_code<?= $rowp->ID ?>" value="<?= $productCode ?>" />
			<input type="hidden" id="productid<?= $rowp->ID ?>" value="<?= $product['ProductID'] ?>" />
			
			<input type="hidden" id="width_die<?= $rowp->ID ?>" value="<?= $records['width'] ?>" />
			<input type="hidden" id="height_die<?= $rowp->ID ?>" value="<?= $records['height'] ?>" />
			<input type="hidden" id="shape<?= $rowp->ID ?>" value="<?= $records['shape'] ?>" />
			
			
		</td>
		
        <td>
			<!--<b class="text-center"><?= $rowp->material ?></b><br/>-->
            <input type="hidden" id="matName<?= $rowp->ID ?>" value="">
            <div class="labels-form">
                <label class="select">
                    <select onchange="changelabeltype(<?= $rowp->ID ?>,this,'refresh')" id="mat_print<?= $rowp->ID ?>"
                            class="form-control">
                        <option value="plain" <? if ($rowp->labeltype == "plain") { ?> selected="selected" <? } ?>>Plain
                        </option>
                        <option value="printed" <? if ($rowp->labeltype == "printed") { ?> selected="selected" <? } ?>>
                            Printed
                        </option>
                    </select>
                    <i></i>
                </label>
            </div>
        </td>

        <td>
            <b class="text-center"><?= $rowp->material ?> - </b>
            <?= $this->user_model->get_mat_name($rowp->material); ?> - <?= $rowp->labeltype ?> labels

            <? /*if ($rowp->labeltype == "printed" || $asformat == "roll") { ?>
                <a class="cursor toggler2 custom-die-cta" id="mat_show_dtl" onclick="showDetail(<?= $rowp->ID ?>)"
                   type="button" data-id="<?= $rowp->ID ?>">Show Details</a>
                <a class="cursor toggler2 custom-die-cta" id="mat_hide_dtl" style="display: none"
                   onclick="hideDetail(<?= $rowp->ID ?>)" type="button" data-id="<?= $rowp->ID ?>">Hide Details</a>
            <? } */?>

        </td>
        <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
        <? $materialpriceinc = $materialprice * 1.2;

        if (isset($extPrice)) {
            $extPrice = $extPrice + $materialprice;
        }

        if (isset($lineTotal)) {
            $lineTotal = $lineTotal + $materialprice;
        }

        ?>
        <?php if ($rowp->qty == 0 || $materialprice == 0) { ?>
            <td id="mat_unit_price" class="text-center">0.00</td>
        <?php } else { ?>
            <td id="mat_unit_price" class="text-center">
				<?=$symbol?><?= (number_format(($materialprice * $exchange_rate)  / ($rowp->qty * $rowp->rolllabels) , 3)); 
				
				
				
				?>
		</td>
        <?php } ?>
        <td>
            <input type="number" min="0" id="matqty<?= $rowp->ID ?>"
                   onchange="$('#matqty<?= $rowp->ID ?>').popover('hide');" value="<?= $rowp->qty ?>"
                   class="form-control input-number text-center allownumeric" name="quant1">
            <span class="err" id="err_qty<?= $rowp->ID ?>">Please Choose Qty</span>


        </td>

        <td id="mat_price"
            class="text-center"><?= $symbol ?><? echo(number_format($materialprice * $exchange_rate, 2)); ?></td>


		<td class="padding-6 icon-tablee">
            <i class="fa fa-trash-o bt-delete"
               onclick="deleteLineFromMaterial(<?= $key ?>,<?= $rowp->ID ?>)"
               id="deletenode1"></i>

			<?php if($carRes[0]->format!="Roll"){ ?>
            <i class="fa fa-floppy-o bt-save"
               onclick="updateNewMaterialSheets(<?= $key ?>,<?= $carRes[0]->ID ?>,<?= $rowp->ID ?>,'<?= $carRes[0]->format ?>')"></i>
			<?php } else{ ?>
			<i class="fa fa-floppy-o bt-save"
               onclick="updateMaterialPriceRolls(<?= $key ?>,<?= $carRes[0]->ID ?>,<?= $rowp->ID ?>,'<?= $carRes[0]->format ?>')"></i>
			<?php } ?>
			
        </td>


    </tr>


    <!-- --------------------------------------------------->  <!-- --------------------------------------------------->

    <tr id="assco<?= $rowp->ID ?>" class="<?php if($rowp->labeltype != "printed" && $asformat != "roll"){echo 'hide';}?>" >
        <td colspan="1"></td>
        <td></td>
        <td>
            <div class="mainloop" style="display: inline-flex;">
                <? if ($asformat == "roll" && $rowp->labeltype == "printed") { ?>

                    <div style="margin-right: 15px;" class="divstyle">
                        <span class="labels-form">
                            <label class="select">
                        			<select id="prnt_dropdown_<?= $rowp->ID ?>"
                                onchange="$('#prnt_dropdown_<?= $rowp->ID ?>').popover('hide');" class="form-control">
                            		<option value="">Select Printing</option>
                            		<option value="Mono" <? if ($rowp->printing == "Mono") { ?> selected="selected" <? } ?>>
                                	Black Only
                            		</option>
                            		<option value="6 Colour Digital Process" <? if ($rowp->printing == "6 Colour Digital Process") { ?> selected="selected" <? } ?> >
                                6 Colour Digital Process
                            		</option>
                            		<option value="6 Colour Digital Process + White" <? if ($rowp->printing == "6 Colour Digital Process + White") { ?> selected="selected" <? } ?>
                                    class="">6 Colour Digital Process + White
                            		</option>
                        				</select>
                                <i></i>
                                </label>
                            </span>
                    </div>

                    <span class="err" id="err_printeds<?= $rowp->ID ?>">Please Select Printing</span>


                <? } else if ($rowp->labeltype == "printed") { ?>


                    <div style="margin-right: 15px;" class="divstyle">
                        <span class="labels-form">
                            <label class="select">
                        <select onchange="$('#prnt_dropdown_<?= $rowp->ID ?>').popover('hide');"
                                id="prnt_dropdown_<?= $rowp->ID ?>" class="form-control">
                            <option value="">Select Printing</option>
                            <option value="Mono" <? if ($rowp->printing == "Mono") { ?> selected="selected" <? } ?>>
                                Black Only
                            </option>
                            <option value="4 Colour Digital Process" <? if ($rowp->printing == "4 Colour Digital Process") { ?> selected="selected" <? } ?> >
                                4 Colour Digital Process
                            </option>
                        </select>
                                <i></i></label></span>
                    </div>

                    <span class="err" id="err_printed_sheet<?= $rowp->ID ?>">Please Select Printing</span>
                    
                    
                      <div <?= $eprintoption ?>
                        class="eprintoption<?= $rowp->ID ?>" style="margin-right: 15px;">
                    <input id="designmat<?= $rowp->ID ?>" class="joiner no-ioffdeign" type="number"
                           placeholder="No. Designs"
                           value="<? if($rowp->designs==0 || $rowp->designs==""){ echo '';}else{ echo $rowp->designs;} ?>"
                           onchange="$('#designmat<?= $rowp->ID ?>').popover('hide');">
                </div>

                <span class="err" id="err_no_designs<?= $rowp->ID ?>">Please Choose no of Designs</span>

                <? } ?>


                <!-- --------------------------------------------------->

                <? if ($asformat == "roll" && $rowp->labeltype == "printed") { ?>

                    <div style="margin-right: 15px;" class="divstyle">
                        <span class="labels-form">
                            <label class="select">
                        <select id="finishdropdown_<?= $rowp->ID ?>"
                                onchange="$('#finishdropdown_<?= $rowp->ID ?>').popover('hide');"
                                class="form-control">
                            <option value="">Select finishing</option>
                            <option value="No Finishing" <? if ($rowp->finish == "No Finishing") { ?> selected="selected" <? } ?>>
                                No Finishing
                            </option>
                            <option value="Gloss Lamination" <? if ($rowp->finish == "Gloss Lamination") { ?> selected="selected" <? } ?>>
                                Gloss Lamination
                            </option>
                            <option value="Matt Lamination" <? if ($rowp->finish == "Matt Lamination") { ?> selected="selected" <? } ?>>
                                Matt Lamination
                            </option>
                            <option value="Matt Varnish" <? if ($rowp->finish == "Matt Varnish") { ?> selected="selected" <? } ?>>
                                Matt Varnish
                            </option>
                            <option value="Gloss Varnish" <? if ($rowp->finish == "Gloss Varnish") { ?> selected="selected" <? } ?>>
                                Gloss Varnish
                            </option>
                            <option value="High Gloss Varnish" <? if ($rowp->finish == "High Gloss Varnish") { ?> selected="selected" <? } ?>>
                                High Gloss Varnish
                            </option>
                        </select>
                                <i></i></label></span>
                    </div>
                    <span class="err" id="err_finish_roll<?= $rowp->ID ?>">Please choose Finish</span>
                    
                   

                <? } ?>

                <!-- --------------------------------------------------->


                <? if ($asformat == "roll") { ?>
                    <div style="margin-right: 15px;" class="divstyle">
                        <span class="labels-form">
                            <label class="select">
                        <select id="core_<?= $rowp->ID ?>"
                                class="form-control" class="form-control"
                                onchange="$('#core_<?= $rowp->ID ?>').popover('hide');">
                            <option value="">Select Core Size</option>
                            <option value="25" <? if ($rowp->core == "25") { ?> selected="selected" <? } ?>>25 mm
                            </option>
                            <option value="38" <? if ($rowp->core == "38") { ?> selected="selected" <? } ?>>38 mm
                            </option>
                            <option value="44.5" <? if ($rowp->core == "44.5") { ?> selected="selected" <? } ?>>44.5
                                mm
                            </option>
                            <option value="76" <? if ($rowp->core == "76") { ?> selected="selected" <? } ?>>76 mm
                            </option>
                        </select>
                                <i></i></label></span>
                    </div>

                    <span class="err" id="err_core_roll<?= $rowp->ID ?>">Please provide Core</span>


                    <div style="margin-right: 15px;" class="divstyle">
                        <span class="labels-form">
                            <label class="select">
                        <select id="wound_<?= $rowp->ID ?>"
                                class="form-control" onchange="$('#wound_<?= $rowp->ID ?>').popover('hide');">
                            <option value="">Select Wound</option>
                            <option value="Outside" <? if ($rowp->wound == "Outside") { ?> selected="selected" <? } ?>>
                                Outside Wound
                            </option>
                            <option value="Inside" <? if ($rowp->wound == "Inside") { ?> selected="selected" <? } ?>>
                                Inside Wound
                            </option>
                        </select>
                                <i></i></label></span>
                    </div>

                    <span class="err" id="err_wound_roll<?= $rowp->ID ?>">Please provide  Wound</span>
                <? } ?>


               
							
							
				<div>
					<?  if ($asformat == "roll") {  ?>
					<div class="divstyle">
						<input id="labelsmat<?= $rowp->ID  ?>" class="joiner no-ioffdeign" type="number"
                               placeholder="No. Labels on Rolls" value="<? if($rowp->rolllabels==0 || $rowp->rolllabels==""){ echo '';}else{ echo $rowp->rolllabels;} ?>"
                               onchange="$('#labelsmat<?= $rowp->ID ?>').popover('hide');">
					</div>
					<span class="err" id="err_no_labels<?= $rowp->ID ?>">Please Choose Total Labels</span>
					<?  }  ?>
				</div>

							


            </div>


            <!-- --------------------------------------------------->
            <!-- --------------------------------------------------->


          

        </td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>

    </tr>


    <? $cc++;
} ?>


<tr class="">
    <td>
    </td>
    <td>

        <input type="hidden" value="<?php echo count($assoc); ?>" name="all_mat" id="all_mat<?= $key ?>">

        <?php $materials = $this->user_model->getMaterialCodeParam($carRes[0]->format) ?>
        <span class="labels-form">
        <label class="select">

            <select onchange="selectedMaterial(this,<?= $carRes[0]->ID ?>,<?= $key ?>)" id="add_materials<?= $key ?>"
                    class="form-control">
            <option value="">Add Material</option>
                <?php foreach ($materials as $material) { ?>
                    <option value="<?= $material->material ?>"><?= $material->material ?></option>
                <?php } ?>
        </select>
            <i></i>
            </label>

            </>


        <span class="err" id="err<?= $key ?>">Please add Material</span>

    </td>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td colspan="2"></td>
</tr>