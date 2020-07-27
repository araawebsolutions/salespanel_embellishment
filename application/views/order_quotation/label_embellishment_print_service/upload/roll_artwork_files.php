<?php
$minroll = $this->home_model->min_qty_roll($details['ManufactureID']);


$ProductID = $details['ProductID'];
$cartid = $details['cartid'];

if(isset($cartid) && !empty($cartid)){

    if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
        $files = $this->home_model->fetch_uploaded_artworks_edit_cart($cartid, $ProductID);
    } else {
        $files = $this->home_model->fetch_uploaded_artworks($cartid, $ProductID);
    }

    if (count($files) > 0){
        if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
            $total_uploaded_rolls = $this->home_model->fetch_uploaded_artworks_total_qty_edit_cart($cartid, $ProductID);
        } else {
            $total_uploaded_rolls = $this->home_model->fetch_uploaded_artworks_total_qty($cartid, $ProductID);
        }
//    print_r($total_uploaded_rolls);die;
        if (isset($total_uploaded_rolls) && !empty($total_uploaded_rolls)   ){

            $additional_cost_per_roll = $prices['additional_cost']/($total_uploaded_rolls[0]->total_roll-$minroll);
//    print_r($additional_cost_per_roll);

        }
    }
}

$total = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
$labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

$flag_minus = false;
$designs = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Qty', 'ID', $cartid);


/* echo $this->db->last_query();
 echo "<br>";
 echo $details['ManufactureID'];
 echo "<br>";
 echo "__/".$minroll."/___";*/

$min_labels_per_roll = $this->home_model->min_labels_per_roll($minroll);


$upload_path = base_url().'theme/assets/images/artworks/';

$uploaded_designs = 0; ?>

<table class="table table-striped">
    <thead class="">
    <tr>
        <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>
            <td>Artworks</td>

        <?php  } ?>
        <td>File Name</td>
        <td>No. Labels</td>
        <?php  if (isset($upload_artwork_option_radio) && $upload_artwork_option_radio != "cost_effective"){ ?>

            <td>Labels per roll</td>
            <td class="text-center">Rolls</td>
        <?php  } ?>
        <td align="center">Action</td>
        <?php  if (isset($details['labelCategory']) && $details['labelCategory'] =='Roll Labels'){ ?>
            <td class="text-center">Additional Cost</td>
        <?php  } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $uploaded_designs = 0;
    $total_labels = 0;
    $total_rolls = 0;
    $show_another_line_button = 0;
    if(count($files) > 0){

        if (count($files) >= $lines_to_populate){
            $show_another_line_button = 1;
        }
        foreach($files as $row){

            $total_labels+= $row->labels;
            $total_rolls+=$row->qty;
            $uploaded_designs++;

            if(preg_match("/.pdf/is",$row->file)){
                $artworkpath = AJAXURL.'theme/site/images/pdf.png';

            }
            else if(preg_match("/.doc/is",$row->file) || preg_match("/.docx/is",$row->file)){
                $artworkpath = AJAXURL.'theme/site/images/doc.png';

            }else{
                $artworkpath = $upload_path.$row->file;

            }

            ?>
            <tr class="upload_row">
                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                    <td width="10%" class="text-center"><img onerror='imgError(this);' class="img-circle" src="<?=$artworkpath?>" width="20" height="" alt="<?=$row->name?>"></td>
                <?php  } ?>

                <td width="26%"><?=$row->name?></td>
                <td width="16%"><input data-toggle="popover" data-content="" class="form-control roll_labels_input allownumeric"
                                       value="<?=$row->labels?>" placeholder="<?=$min_labels_per_roll*$minroll?>+" type="text">
                    <div class="row" style="vertical-align:middle; text-align:center;">
                        <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_labels_field" data-current-element="input_no_of_labels"><i class="fa fa-refresh"></i> Update </a>
                    </div>
                </td>

                <?php  if (isset($upload_artwork_option_radio) && $upload_artwork_option_radio == "cost_effective"){ ?>


                    <input value="<?=$row->qty?>" class="form-control input-number text-center allownumeric  input_rolls" type="hidden">


                <?php  }else{ ?>
                    <td width="16%" style="vertical-align:middle; text-align:center">

                        <input value="<?=$row->labels/$row->qty?> " data-toggle="popover" data-content=""
                               style="display:block;" class="form-control input-number text-center allownumeric show_labels_per_roll input_label_p_roll" type="text">
                        <div class="row" style="vertical-align:middle; text-align:center;">
                            <a href="javascript:void(0);" style="display:none;" class="quantity_updater labels_per_roll_field" data-current-element="input_label_p_roll"><i class="fa fa-refresh"></i> Update </a>
                        </div>
                        <!--                    <small class="show_labels_per_roll">-->
                        <!--                        --><?//=$row->labels/$row->qty?>
                        <!--                    </small>-->
                    </td>
                    <td width="16%" class="text-center"><input value="<?=$row->qty?>" class="form-control input-number text-center allownumeric  input_rolls" type="text">
                        <div class="row" style="vertical-align:middle; text-align:center;">
                            <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_rolls_field" data-current-element="input_no_of_rolls"><i class="fa fa-refresh"></i> Update </a>
                        </div>
                        <!-- <div class="col-xs-12 col-sm-12 col-md-12 p0">
                      	<div class="row" style="vertical-align:middle; text-align:center;">
                           <a data-id="<?=$row->ID?>" data-value="roll" href="javascript:void(0);" style="display:none;"
                           class="clear_b roll_updater"><i class="fa fa-refresh"></i> Update </a>
                       </div>

                     </div>--></td>
                <?php } ?>

                <td width="38%" align="center" class="text-center"><button style="display:none;" data-value="roll" data-id="<?=$row->ID?>" title="Update artwork details" class="roll_updater  btn btn-success" > <i class="fa f-10 fa-save "></i> </button>
                    <button data-value="roll" id="<?=$row->ID?>" title="Delete Artwork" class="delete_artwork_file  btn btn-danger" data-total_uploaded_rolls="<?php echo $total_uploaded_rolls ?>" data-additional_cost="<?php echo $prices['additional_cost'] ?>" > <i class="fa f-10 fa-trash "></i> </button></td>
                <?php  if (isset($details['labelCategory']) && $details['labelCategory'] =='Roll Labels'){  ?>
                    <td class="text-center">
                        <?php
                        if ($files[0]->qty < $minroll){
                            if ($total_rolls > $minroll){
                                $remaining_roll_for_addtional_charges = $total_rolls-$minroll;
//                                $additional_roll =$total_rolls - $minroll;
                                if ($remaining_roll_for_addtional_charges>0){
                                    if ($total_rolls - $row->qty > $minroll){
                                        $additional_cost =   $additional_cost_per_roll * $row->qty;
                                        $additional_cost = number_format($additional_cost, 2, '.', '');
                                        echo '<h6>+'.symbol.$additional_cost. ' <i class="fa fa-info-circle text-info" aria-hidden="true"></i></h6>';
                                    }else{
                                        $additional_cost =   $additional_cost_per_roll * $remaining_roll_for_addtional_charges;
                                        $additional_cost = number_format($additional_cost, 2, '.', '');
                                        echo '<h6>+'.symbol.$additional_cost. ' <i class="fa fa-info-circle text-info" aria-hidden="true"></i></h6>';
                                    }

                                }
                            }


                        }else{
                            $additional_roll = $total_rolls - $minroll;
                            if ($additional_roll>0){
                                if( $flag_minus ) {
                                    $additional_cost =   $additional_cost_per_roll * $row->qty;
                                } else {
                                    $additional_cost =   $additional_cost_per_roll * $additional_roll;
                                }
                                $flag_minus = true;
                                $additional_cost = number_format($additional_cost, 2, '.', '');
                                echo '<h6>+'.symbol.$additional_cost. ' <i class="fa fa-info-circle text-info" aria-hidden="true"></i></h6>';
                            }
                        } 
                        ?>

                    </td>
                <?php  } ?>
            </tr>
        <?php }
        if ($lines_to_populate >= 1){
            $lines_to_populate -=count($files);

        }
        for ( $i = 1; $i <= $lines_to_populate; $i++) {
            ?>
            <tr class="upload_row uploadsavesection"  >
                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                    <td width="10%" class="text-center"><img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" />
                        <input type="file" name="artwork_file" class="artwork_file"  style="display:none;"  />
                        <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button></td>
                <?php  } ?>


                <td  width="30%"><input class="form-control artwork_name" placeholder="Artwork Name" type="text"></td>
                <td  width="20%"><input class="form-control roll_labels_input allownumeric" value="" data-toggle="popover" data-content=""
                                        style="  text-align:center"   placeholder="Enter Labels" type="text">

                    <div class="row" style="vertical-align:middle; text-align:center;">
                        <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_labels_field" data-current-element="input_no_of_labels"><i class="fa fa-refresh"></i> Update </a>
                    </div>
                </td>
                <?php  if (isset($upload_artwork_option_radio) && $upload_artwork_option_radio == "cost_effective"){ ?>

                    <input value="<?=$minroll?>" data-toggle="popover" data-content=""
                           style="display:none;" class="form-control input-number text-center allownumeric input_rolls" type="hidden">

                <?php  }else{ ?>
                    <td  width="20%" style="  text-align:center">
                        <input value="" data-toggle="popover" data-content="" placeholder="Enter Labels/Roll"
                               style="" class="form-control input-number text-center allownumeric show_labels_per_roll input_label_p_roll" type="text">

                        <div class="row" style="vertical-align:middle; text-align:center;">
                            <a href="javascript:void(0);" style="display:none;" class="quantity_updater labels_per_roll_field" data-current-element="input_label_p_roll"><i class="fa fa-refresh"></i> Update </a>
                        </div>
                        <!--                        <small class="show_labels_per_roll"></small>-->

                    </td>
                    <td width="20%" class="text-center">
                        <input value="<?=$minroll?>" data-toggle="popover" data-content="" placeholder="Enter No.Rolls"
                               style="display: block " class="form-control input-number text-center allownumeric input_rolls" type="text">
                        <div class="row" style="vertical-align:middle; text-align:center;">
                            <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_rolls_field" data-current-element="input_no_of_rolls"><i class="fa fa-refresh"></i> Update </a>
                        </div>
                        <!--            <label class="quantity_labels">-->
                        <!--                --><?//=$minroll?>
                        <!--            </label>-->
                        <!--            &nbsp; <a href="javascript:void(0);" class="quantity_editor"><i class="fa fa-pencil"></i> Edit </a>-->

                    </td>
                <?php } ?>

                <td width="28%" align="center">
                    <!--            <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">-->
                    <div class="   m0 p0">
                        <button data-value="roll" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Save</button>
                    </div></td>
                <?php  if (isset($details['labelCategory']) && $details['labelCategory'] =='Roll Labels'){ ?>
                    <td class="text-center">  </td>
                <?php  } ?>
            </tr>
            <tr id="upload_progress" style="display:none;">
                <td colspan="7"><div id="progressbar" class="col-md-11"></div></td>
                <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
            </tr>

        <?php }

        $lines_to_populate = 0;
        $remaingsheets = $labels-$total_labels;
    }
    //echo $lines_to_enter;
    //$expected_labels = $remaingsheets*$details['LabelsPerSheet'];
    //$expected_labels =($expected_labels>0)?$expected_labels:'';
    if (isset($lines_to_populate) && $lines_to_populate > 0){
        for ( $i = 1; $i <= $lines_to_populate; $i++) {
            ?>
            <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                    <td width="10%" class="text-center"><img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" />
                        <input type="file" name="artwork_file" class="artwork_file"  style="display:none;"  />
                        <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button></td>
                <?php  } ?>


                <td  width="30%"><input class="form-control artwork_name" placeholder="Artwork Name" type="text"></td>
                <td  width="20%"><input class="form-control roll_labels_input allownumeric" value="" data-toggle="popover" data-content=""
                                        style="  text-align:center"   placeholder="Enter Labels" type="text">

                    <div class="row" style="vertical-align:middle; text-align:center;">
                        <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_labels_field" data-current-element="input_no_of_labels"><i class="fa fa-refresh"></i> Update </a>
                    </div>
                </td>
                <?php  if (isset($upload_artwork_option_radio) && $upload_artwork_option_radio == "cost_effective"){ ?>

                    <input value="<?=$minroll?>" data-toggle="popover" data-content=""
                           style="display:none;" class="form-control input-number text-center allownumeric input_rolls" type="hidden">

                <?php  }else{ ?>
                    <td  width="20%" style="  text-align:center">
                        <input value="" data-toggle="popover" data-content="" placeholder="Enter Labels/Roll"
                               style="" class="form-control input-number text-center allownumeric show_labels_per_roll input_label_p_roll" type="text">

                        <div class="row" style="vertical-align:middle; text-align:center;">
                            <a href="javascript:void(0);" style="display:none;" class="quantity_updater labels_per_roll_field" data-current-element="input_label_p_roll"><i class="fa fa-refresh"></i> Update </a>
                        </div>
                        <!--                    <small class="show_labels_per_roll"></small>-->

                    </td>
                    <td width="20%" class="text-center">
                        <input value="<?=$minroll?>" data-toggle="popover" data-content="" placeholder="Enter No.Rolls"
                               style="display: block " class="form-control input-number text-center allownumeric input_rolls" type="text">
                        <div class="row" style="vertical-align:middle; text-align:center;">
                            <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_rolls_field" data-current-element="input_no_of_rolls"><i class="fa fa-refresh"></i> Update </a>
                        </div>
                        <!--            <label class="quantity_labels">-->
                        <!--                --><?//=$minroll?>
                        <!--            </label>-->
                        <!--            &nbsp; <a href="javascript:void(0);" class="quantity_editor"><i class="fa fa-pencil"></i> Edit </a>-->

                    </td>
                <?php } ?>

                <td width="28%" align="center">
                    <!--            <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">-->
                    <div class="   m0 p0">
                        <button data-value="roll" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Save</button>
                    </div></td>
                <?php  if (isset($details['labelCategory']) && $details['labelCategory'] =='Roll Labels'){ ?>
                    <td class="text-center">  </td>
                <?php  } ?>
            </tr>
            <tr id="upload_progress" style="display:none;">
                <td colspan="7"><div id="progressbar" class="col-md-11"></div></td>
                <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
            </tr>

        <?php }
        $lines_to_populate = 0;
    }else{ ?>
        <tr class="upload_row uploadsavesection  " style=" <?=(count($files)>0)?'display:none':''?>">
            <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                <td width="10%" class="text-center"><img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" />
                    <input type="file" name="artwork_file" class="artwork_file"  style="display:none;"  />
                    <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button></td>
            <?php  } ?>


            <td  width="30%"><input class="form-control artwork_name" placeholder="Artwork Name" type="text"></td>
            <td  width="20%"><input class="form-control roll_labels_input allownumeric" value="" data-toggle="popover" data-content=""
                                    style="  text-align:center"   placeholder="Enter Labels" type="text">

                <div class="row" style="vertical-align:middle; text-align:center;">
                    <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_labels_field" data-current-element="input_no_of_labels"><i class="fa fa-refresh"></i> Update </a>
                </div>
            </td>
            <?php  if (isset($upload_artwork_option_radio) && $upload_artwork_option_radio == "cost_effective"){ ?>

                <input value="<?=$minroll?>" data-toggle="popover" data-content=""
                       style="display:none;" class="form-control input-number text-center allownumeric input_rolls" type="hidden">

            <?php  }else{ ?>
                <td  width="20%" style="  text-align:center">
                    <input value="" data-toggle="popover" data-content="" placeholder="Enter Labels/Roll"
                           style="" class="form-control input-number text-center allownumeric show_labels_per_roll input_label_p_roll" type="text">

                    <div class="row" style="vertical-align:middle; text-align:center;">
                        <a href="javascript:void(0);" style="display:none;" class="quantity_updater labels_per_roll_field" data-current-element="input_label_p_roll"><i class="fa fa-refresh"></i> Update </a>
                    </div>
                    <!--                <small class="show_labels_per_roll"></small>-->

                </td>
                <td width="20%" class="text-center">
                    <input value="<?=$minroll?>" data-toggle="popover" data-content="" placeholder="Enter No.Rolls"
                           style="display: block " class="form-control input-number text-center allownumeric input_rolls" type="text">
                    <div class="row" style="vertical-align:middle; text-align:center;">
                        <a href="javascript:void(0);" style="display:none;" class="quantity_updater no_of_rolls_field" data-current-element="input_no_of_rolls"><i class="fa fa-refresh"></i> Update </a>
                    </div>
                    <!--            <label class="quantity_labels">-->
                    <!--                --><?//=$minroll?>
                    <!--            </label>-->
                    <!--            &nbsp; <a href="javascript:void(0);" class="quantity_editor"><i class="fa fa-pencil"></i> Edit </a>-->

                </td>
            <?php } ?>

            <td width="28%" align="center">
                <!--            <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">-->
                <div class="   m0 p0">
                    <button data-value="roll" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Save</button>
                </div></td>
            <?php  if (isset($details['labelCategory']) && $details['labelCategory'] =='Roll Labels'){ ?>
                <td class="text-center">  </td>
            <?php  } ?>
        </tr>
        <tr id="upload_progress" style="display:none;">
            <td colspan="7"><div id="progressbar" class="col-md-11"></div></td>
            <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
        </tr>

    <?php }
    ?>
    <? if($uploaded_designs < 50 && $show_another_line_button == 1){ ?>


        <tr style=" <?=(count($files)>0)?'':'display:none;'?>" id="add_another_line">
            <?php  if (isset($upload_artwork_option_radio) && $upload_artwork_option_radio == "cost_effective"){ ?>
            <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>
            <td colspan="5" class=" ">
                <?php }else{ ?>
            <td colspan="4" class=" ">
                <?php   } ?>

                <?php }else{ ?>

                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>
            <td colspan="7" class=" ">
                <?php }else{ ?>
            <td colspan="6" class=" ">
                <?php   } ?>

                <?php   } ?>

                <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                    <button class="btn btn-success add_another_art"> <i class="fa fa-plus"></i> Add another Line</button>
                </div></td>
            <!--            <td>&nbsp;</td>-->
            <!--            <td class="text-center">&nbsp;</td>-->
            <!--            <td align="center">&nbsp;</td>-->
        </tr>
    <? } ?>
    <tr>

        <?php  if ($upload_artwork_radio != "upload_artwork_now"){ ?>
            <td colspan="2" class="text-left" style="vertical-align:middle;"> You have <b class="remaing_user_sheets">
                    <?=$labels-$total_labels?>
                </b> labels remaining </td>
        <?php  }else{ ?>
            <td colspan="3" class="text-left" style="vertical-align:middle;"> You have <b class="remaing_user_sheets">
                    <?=$labels-$total_labels?>
                </b> labels remaining </td>
        <?php  } ?>


        <td colspan="4"  align="center" style="vertical-align:middle;" class="text-center"><!--<p class="total_user_sheet"><?=$total_rolls?></p>-->

            <? if($total_rolls > 0){?>
                <?=$uploaded_designs?>
                <?=($uploaded_designs>1)?'Designs':'Design'?>
                ,
                <?=number_format($total_labels)?>
                Labels on
                <?=$total_rolls?>
                <?=($total_rolls>1)?'Rolls':'Roll'?>
            <? } ?></td>
    </tr>
    <tr style="background:none;">
        <td colspan="6"><p>In order to upload your artwork you must complete the line e.g. File name and the number of labels required. Upon which the file will be uploaded.</p></td>
    </tr>
    </tbody>
</table>
<? if($uploaded_designs >= 50){?>
    <div class="col-md-12" style="">
        <div class="col-md-10">
            <h5><i class="fa fa-info-circle" aria-hidden="true"></i> Upload Limit Exceeded </h5>
            <p>If you have additional artworks that you would like to have printed with this order
                please enter the number and our customer care team will contact you.</p>
        </div>
        <div class="col-md-2">
            <input  class="form-control additional_designs allownumeric" maxlength="5" placeholder="+1" type="text">
            <div class="row" style="text-align:center;"> <a href="javascript:void(0);" style="display:none;"  class="clear_b additional_designs_updatebtn"> <i class="fa fa-refresh"></i> Update </a> </div>
        </div>
    </div>
<? } ?>
<input type="hidden" id="actual_designs_qty" value="<?=$designs?>"  />
<input type="hidden" id="actual_labels_qty" value="<?=$labels?>"  />
<input type="hidden" id="upload_remaining_labels" value="<?=($labels-$total_labels)?>"  />
<input type="hidden" id="upload_remaining_designs" value="<?=($designs-$uploaded_designs)?>"  />
<input type="hidden" id="final_uploaded_rolls" value="<?=$total_rolls?>"  />
<input type="hidden" id="final_uploaded_labels" value="<?=$total_labels?>"  />
