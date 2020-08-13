<!-- Printing Process & Products Details Starts -->
<link href="<?= Assets ?>css/custom.css" rel="stylesheet">
<style>
    .panel {
        background: #ffffff;
        color: #000000;
    }
    .f12 {
        font-size: 12px;
        width: 210px;
    }
    .labels-form .row {
        margin: 0 !important;
    }
    .labels-form .input input, .labels-form .select select, .labels-form .textarea textarea {
        height: 40px !important;
    }
    .thumbnail {
        box-shadow: 0 0px 0 #848484 !important;
        border-radius: 0px !important;
    }
</style>
<div id="product_content">

    <?php
    $assets = Assets;


    if (($preferences['available_in'] == "A4" || $preferences['available_in'] == "A3" || $preferences['available_in'] == "SRA3" || $preferences['available_in'] == "A5") and $preferences['categorycode_a4'] != '') {
        $product_details = $details;
        $product_details = $product_details[0];
        $product_type = 'sheet';

        $label_size = str_replace("Label Size:", "", $product_details->specification3 );
        $label_size = ucwords($label_size);
        $label_size = str_replace("Mm", "mm", $label_size);

        $x = explode("per A4", $product_details->CategoryName);
        $label_on_sheets = $x[0];
        $img_src = Assets . "images/categoryimages/A4Sheets/colours/" . $product_details->ManufactureID . ".png";

        if (preg_match("/PETC/", $product_details->ManufactureID) || preg_match("/PETH/", $product_details->ManufactureID) || preg_match("/PVUD/", $product_details->ManufactureID)) {
            $min_qty = '5';
            $max_qty = '5000';
        } else {
            $min_qty = 25;
            $max_qty = 50000;
        }

        //$pname=str_replace('-','',$a4details['ProductName']).' Adhesive '.' '.$label_size.' '.ucfirst($a4details['Shape']);
        $pname = str_replace('-', '', $product_details->ProductName) . ' Adhesive '; ?>

                             <input type="hidden" id="labels_p_sheet<?= $product_details->ProductID ?>"
                               value="<?= $product_details->LabelsPerSheet ?>"/>
                        <input type="hidden" id="min_qty<?= $product_details->ProductID ?>" value="<?= $min_qty ?>"/>
                        <input type="hidden" id="max_qty<?= $product_details->ProductID ?>" value="<?= $max_qty ?>"/>
                        <input type="hidden" id="digitalprocess<?= $product_details->ProductID ?>"
                               value="<?= $product_details->digitalprocess ?>"/>
                        <input type="hidden" id="producttype<?= $product_details->ProductID ?>" value="sheet"/>
                        <input type="hidden" id="calculation_unit<?= $product_details->ProductID ?>" value="sheets"/>

                        <input type="hidden" id="cartproductid" value="<?= $product_details->ProductID  ?>"/>




 <?php   }else{
        $product_details = $details;
        $product_details = $product_details[0];
//        $product_details = (array) $details;
        $product_type = 'roll';



    $min_qty = $this->home_model->min_qty_roll($product_details->ManufactureID);
    $max_qty = $this->home_model->max_total_labels_on_rolls($product_details->LabelsPerSheet);
    $min_labels_per_roll = $this->home_model->min_labels_per_roll($min_qty); ?>

        <!--        <input type="hidden" id="cartid" value="--><?//= $cartid ?><!--"/>-->
        <input type="hidden" id="cartproductid" value="<?= $product_details->ProductID ?>"/>


    <input type="hidden" id="labels_p_sheet<?= $product_details->ProductID ?>"
           value="<?= $product_details->LabelsPerSheet ?>"/>
    <input type="hidden" id="min_rolls<?= $product_details->ProductID ?>" value="<?= $min_qty ?>"/>
    <input type="hidden" id="min_qty<?= $product_details->ProductID ?>"
           value="<?= $min_labels_per_roll ?>"/>
    <input type="hidden" id="max_qty<?= $product_details->ProductID ?>" value="<?= $max_qty ?>"/>
    <input type="hidden" id="digitalprocess<?= $product_details->ProductID ?>"
           value="<?= $product_details->digitalprocess ?>"/>
    <input type="hidden" id="rollfinish<?= $product_details->ProductID ?>"
           value="<?= $product_details->rollfinish ?>"/>
    <input type="hidden" id="producttype<?= $product_details->ProductID ?>" value="<?php echo $product_type; ?>"/>
    <input type="hidden" id="calculation_unit<?= $product_details->ProductID ?>" value="labels"/>

 <?php } ?>

    <section>
        <div id="printing_process_loader" class="white-screen"
             style="position: absolute;top: 70px;right: 0;width: 100%;z-index: 999;height: 28%;display: none;background: #FFF;opacity: 0.8;">
            <div class="text-center"
                 style="margin: 80px auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 18%;border: solid 1px #CCC;">
                <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
                     style="width:139px; height:29px; " alt="AA Labels Loader">
            </div>
        </div>
        <div class="row rowflex">
            <?php if ($availabel_in == 'Roll') { ?>

            <div class="mt-15 col-md-6 col-xs-12 rowflex">
                <?php }else{ ?>
                <div class="mt-15 col-md-7 col-xs-12 rowflex">

                    <?php } ?>
                    <div class="panel panel-default rowflexdiv">
                        <div id="headingOne" class="panel-title_blue">
                            <div>Select Digital Printing Process</div>
                        </div>
                        <div>
                            <div class="row">
                                <?php if ($availabel_in == 'Roll') { ?>
                                    <?php foreach ($printing_process as $print_process) { ?>

                                        <div class="col-md-3">
                                            <?php if (preg_match("/Monochrome/i", $print_process->name)) { ?>
                                                <span>


                                                    <img onerror='imgError(this);' class="img-responsive"
                                                         src="<?= Assets ?>images/new-printed-labels/printing-process-black-thumbnail.jpg" style="height: 127px;">

                                            </span>
                                                <label class="containerr" data-printing_process="Monochrome_Black_Only">Monochrome
                                                    <br>Black Only

                                                    <input type="radio" checked <?php if (($preferences['digital_proccess_roll']) == 'Monochrome_Black_Only') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process pre_select_for_white" name="digital_printing_process">
                                                    <span class="checkmark"></span>
                                                </label>
                                            <?php }elseif (preg_match("/Rich Black/i", $print_process->name)) { ?>
                                                <span>
                                                           <img onerror='imgError(this);' class="img-responsive"
                                                                src="<?= Assets ?>images/new-printed-labels/rich-bl-thumbnail.jpg" style="height: 127px;">
                                                          </span>
                                                <label class="containerr"
                                                       data-printing_process="Rich_Black">Rich Black
                                                    <input type="radio" <?php if (($preferences['digital_proccess_roll']) == 'Rich_Black') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process pre_select_for_white" name="digital_printing_process">
                                                    <span class="checkmark"></span>
                                                </label>
                                            <? } elseif (preg_match("/ \+\ white/i", $print_process->name)) { ?>
                                                <span>
                                                <img onerror='imgError(this);' class="img-responsive"
                                                     src="<?= Assets ?>images/new-printed-labels/printing-process-white-thumbnail.jpg">
                                                    </span>
                                                <label class="containerr"
                                                       data-printing_process="6_Colour_Digital_Process_White">Add White
                                                    <input type="checkbox" <?php if ($preferences['digital_proccess_roll'] == '6_Colour_Digital_Process_White') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process digital_process_plus_white" data-add_white="add_white" name="digital_printing_process_add_white" >
                                                    <span class="checkmark"></span>
                                                </label>
                                            <? } elseif (preg_match("/Colour Digital Process/i", $print_process->name)) { ?>
                                                <span>
                                                           <img onerror='imgError(this);' class="img-responsive"
                                                                src="<?= Assets ?>images/new-printed-labels/HP-pr-thumbnail.jpg" style="height: 127px;">
                                                          </span>
                                                <label class="containerr"
                                                       data-printing_process="6_Colour_Digital_Process">6 Colour
                                                    <br>HP Indigo
                                                    <input type="radio" <?php if (($preferences['digital_proccess_roll']) == '6_Colour_Digital_Process') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process pre_select_for_white" name="digital_printing_process">
                                                    <span class="checkmark"></span>
                                                </label>
                                            <? } ?>
                                        </div>
                                    <? } ?>
                                <? }

                                else{
                                foreach ($printing_process as $print_process) { ?>


                                <?php if (preg_match("/Monochrome/i", $print_process->name)) { ?>
                                <div class="col-md-4 col-md-offset-1">
                                                <span>


                                                    <img onerror='imgError(this);' class="img-responsive"
                                                         src="<?= Assets ?>images/new-printed-labels/printing-process-black-thumbnail.jpg">

                                            </span>
                                    <label class="containerr" data-printing_process="Monochrome_Black_Only">Monochrome
                                        <br>Black Only
                                        <input type="radio" <?php if (($preferences['digital_proccess_a4']) == 'Monochrome_Black_Only') {
                                            echo 'checked';
                                        } else {
                                        } ?> class="digital_process" checked="checked" name="digital_printing_process">
                                        <span class="checkmark"></span>
                                    </label>
                                    <?php }elseif (preg_match("/Rich Black/i", $print_process->name)) { ?>
                                        <span>
                                                           <img onerror='imgError(this);' class="img-responsive"
                                                                src="<?= Assets ?>images/new-printed-labels/rich-bl-thumbnail.jpg" style="height: 127px;">
                                                          </span>
                                        <label class="containerr"
                                               data-printing_process="Rich_Black">Rich Black
                                            <input type="radio" <?php if (($preferences['digital_proccess_roll']) == 'Rich_Black') {
                                                echo 'checked';
                                            } else {
                                            } ?> class="digital_process" name="digital_printing_process">
                                            <span class="checkmark"></span>
                                        </label>
                                    <? }elseif (preg_match("/Colour Digital Process/i", $print_process->name)) { ?>
                                    <div class="col-md-4 col-md-offset-2">
                                                <span>
                                                           <img onerror='imgError(this);' class="img-responsive"
                                                                src="<?= Assets ?>images/new-printed-labels/printing-process-full-color-thumbnail.jpg">
                                                          </span>
                                        <label class="containerr" data-printing_process="4_Colour_Digital_Process">4
                                            Colour
                                            <br>Digital Process
                                            <input type="radio" <?php if (($preferences['digital_proccess_a4']) == '4_Colour_Digital_Process') {
                                                echo 'checked';
                                            } else {
                                            } ?> class="digital_process" name="digital_printing_process">
                                            <span class="checkmark"></span>
                                        </label>
                                        <? } ?>
                                    </div>
                                    <? } ?>
                                    <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($availabel_in == 'Roll') { ?>
                        <div id="finish_process_loader" class="white-screen"
                             style="position: absolute;top: 70px;right: 26%;width: 24%;z-index: 999;height: 28%;display: none;background: #FFF;opacity: 0.8;">
                            <div class="text-center"
                                 style="margin: 80px auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 60%;border: solid 1px #CCC;">
                                <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
                                     style="width:139px; height:29px; " alt="AA Labels Loader">
                            </div>
                        </div>
                        <div class="mt-15 col-md-3 col-xs-6 rowflex">
                            <div class="panel panel-default rowflexdiv">
                                <div id="headingOne" class="panel-title_blue">
                                    <div>Select Finish Preferences</div>
                                </div>
                                <div class="labels-form padding-15">

                                    <div class="labels-form">
                                        <label class="select">
                                            <select id="label_coresize" class="printing_options">

                                                <?= $roll_cores ?>
                                            </select>
                                            <i></i> </label>
                                        <label class="select">
                                            <select id="woundoption" class="printing_options">
                                                <option selected="selected" value="">Please Select Wound</option>

                                                <option <?php if (strtolower($preferences['wound_roll']) == 'outside') {
                                                    echo 'selected';
                                                } else {
                                                } ?> value="Outside">Outside Wound
                                                </option>
                                                <option <?php if (strtolower($preferences['wound_roll']) == 'inside') {
                                                    echo 'selected';
                                                } else {
                                                } ?> value="Inside">Inside Wound
                                                </option>
                                            </select>
                                            <i></i> </label>

                                        <input type="hidden" value="orientation1" id="label_orientation"/>
                                            <div class="row dm-row">
                                            <div class=" dm-box" style="width: 100%">
                                                <div style="margin:0;border: none;display: block; position: relative; font-weight: 400!important"
                                                     class="thumbnail col-lg-12 col-md-7 col-sm-12 col-xs-12">

                                                    <div class="col-xs-12 roll_sheets_block">

                                                        <div class="btn-group btn-block dm-selector"><a
                                                                    class="btn btn-default btn-block dropdown-toggle orientation_style_class"
                                                                    data-toggle="dropdown" data-value="">Orientation
                                                                01<i
                                                                        class="fa fa-unsorted"></i></a>
                                                            <ul class="dropdown-menu btn-block">
                                                                <li class="outsideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                            data-id="orientation1">
                                                                        Orientation 01
                                                                        <img onerror='imgError(this);'
                                                                             src="<?= Assets ?>images/loader.gif">
                                                                    </a></li>
                                                                <li class="outsideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                            data-id="orientation2">
                                                                        Orientation 02
                                                                        <img onerror='imgError(this);'
                                                                             src="<?= Assets ?>images/loader.gif"></a>
                                                                </li>
                                                                <li class="outsideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                            data-id="orientation3">
                                                                        Orientation 03
                                                                        <img onerror='imgError(this);'
                                                                             src="<?= Assets ?>images/loader.gif"></a>
                                                                </li>
                                                                <li class="outsideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label of first."
                                                                            data-id="orientation4">
                                                                        Orientation 04
                                                                        <img onerror='imgError(this);'
                                                                             src="<?= Assets ?>images/loader.gif"></a>
                                                                </li>
                                                                <li class="insideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                            data-id="orientation5"> Orientation
                                                                        05 <img
                                                                                onerror='imgError(this);'
                                                                                src="<?= Assets ?>images/loader.gif"></a>
                                                                </li>
                                                                <li class="insideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                            data-id="orientation6"> Orientation
                                                                        06 <img
                                                                                onerror='imgError(this);'
                                                                                src="<?= Assets ?>images/loader.gif">
                                                                    </a></li>
                                                                <li class="insideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first."
                                                                            data-id="orientation7"> Orientation
                                                                        07 <img
                                                                                onerror='imgError(this);'
                                                                                src="<?= Assets ?>images/loader.gif">
                                                                    </a></li>
                                                                <li class="insideorientation"><a
                                                                            data-toggle="tooltip-orintation"
                                                                            data-trigger="hover"
                                                                            data-placement="right"
                                                                            title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                            data-id="orientation8"> Orientation
                                                                        08 <img
                                                                                onerror='imgError(this);'
                                                                                src="<?= Assets ?>images/loader.gif"></a>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <label class="select margin-bottom">
                                        <select name="label_application" id="label_application" class="required printing_options"
                                                aria-required="true">

                                            <option value="" selected="selected">Please Select Label Application</option>
                                            <option value="by_hand">By Hand</option>
                                            <option value="by_machine">By Machine</option>

                                        </select>
                                        <i></i>
                                    </label>

                                    <br>


                                </div>

                            </div>
                        </div>
                    <?php }
                    //                    $assets = 'https://www.aalabels.com/theme/site/';

                    ?>








    </section>
</div>
<!-- Printing Process & Products Details End -->