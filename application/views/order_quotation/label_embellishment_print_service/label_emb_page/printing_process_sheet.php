<!-- Printing Process & Products Details Starts -->
<div id="product_content">


    <?php
//echo "<pre>";print_r($printing_process);
    if (($preferences['available_in'] == "A4" || $preferences['available_in'] == "A3" || $preferences['available_in'] == "SRA3" || $preferences['available_in'] == "A5") and $preferences['categorycode_a4'] != '') {
        $product_details = $details;
        $product_details = $product_details[0];
        $product_type = 'sheet';

        $label_size = str_replace("Label Size:", "", $product_details->specification3 );
        $label_size = ucwords($label_size);
        $label_size = str_replace("Mm", "mm", $label_size);

        $x = explode("per A4", $product_details->CategoryName );
        $label_on_sheets = $x[0];
        $img_src = Assets . "images/categoryimages/A4Sheets/colours/" . $product_details->ManufactureID  . ".png";

        if (preg_match("/PETC/", $product_details->ManufactureID ) || preg_match("/PETH/", $product_details->ManufactureID ) || preg_match("/PVUD/", $product_details->ManufactureID )) {
            $min_qty = '5';
            $max_qty = '5000';
        } else {
            $min_qty = 25;
            $max_qty = 50000;
        }

        //$pname=str_replace('-','',$a4details['ProductName']).' Adhesive '.' '.$label_size.' '.ucfirst($a4details['Shape']);
        $pname = str_replace('-', '', $product_details->ProductName ) . ' Adhesive '; ?>

                        <input type="hidden" id="labels_p_sheet<?= $product_details->ProductID  ?>"
                               value="<?= $product_details->LabelsPerSheet  ?>"/>
                        <input type="hidden" id="min_qty<?= $product_details->ProductID  ?>" value="<?= $min_qty ?>"/>
                        <input type="hidden" id="max_qty<?= $product_details->ProductID  ?>" value="<?= $max_qty ?>"/>
                        <input type="hidden" id="digitalprocess<?= $product_details->ProductID  ?>"
                               value="<?= $product_details->digitalprocess  ?>"/>
                        <input type="hidden" id="producttype<?= $product_details->ProductID  ?>" value="sheet"/>
                        <input type="hidden" id="calculation_unit<?= $product_details->ProductID ?>" value="sheets"/>

<!--                        <input type="hidden" id="cartid" value="--><?//= $cartid ?><!--"/>-->
                          <input type="hidden" id="cartproductid" value="<?= $product_details->ProductID  ?>"/>




 <?php   } ?>

    <section>
        <div id="printing_process_loader" class="white-screen"
             style="position: absolute;top: 70px;right: 0;width: 100%;z-index: 999;height: 28%;display: none;background: #FFF;opacity: 0.8;">
            <div class="text-center"
                 style="margin: 80px auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 18%;border: solid 1px #CCC;">
                <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
                     style="width:139px; height:29px; " alt="AA Labels Loader">
            </div>
        </div>


        </div>

        <div class="row rowflex">


                <div class="mt-15 col-md-9 col-xs-12 rowflex">


                    <div class="panel panel-default rowflexdiv">
                        <div id="headingOne" class="panel-title_blue">
                            <div>Select Digital Printing Process</div>
                        </div>
                        <div>
                            <div class="row sheet_section_radio_main_container">


                                <div class="col-md-6">
                                     <span style=" " class="col-md-6">
                                                    <img onerror="imgError(this);" class="img-responsive" src="<?= Assets ?>images/new-printed-labels/standard-pr-thumbnail.jpg" style="height: 127px;">
                                           </span>
                                    <div class="col-md-6" style="  margin-top: 4% ">
                                        <label class="containerr" data-printing_process="Monochrome_Black_Only" style="  margin-left: 0% !important; "><span style="  margin-top: 31px;">Standerd Quality   <?php echo symbol; ?><span id="standerd_section_price"></span></span>

                                            <input type="radio"  class="product_quality sheet_section_radio_main" data-product_quality_selection="standerd"  name="digital_printing_process">
                                            <span class="checkmark"></span>
                                        </label>
                                        <span class="  product-details-description">

                                            Sheet-fed, digital print quality in 4 standard colours (CMYK). Please note that it is not possible to apply label embellishments and finishes with this process.


                                        </span>
                                    </div>



                                </div>

                                <div class="col-md-6">
                                     <span style=" " class="col-md-6">
                                                           <img onerror="imgError(this);" class="img-responsive" src="<?= Assets ?>images/new-printed-labels/Premium-pr-thumbnail.jpg" style="height: 127px;">
                                           </span>
                                    <div class="col-md-6" style="  margin-top: 4% ">
                                        <label class="containerr" data-printing_process="Monochrome_Black_Only" style="  margin-left: 0% !important; "><span style="  margin-top: 31px;">Premium Quality <?php echo symbol; ?><span id="premium_section_price"> </span></span>

                                            <input type="radio" class="product_quality sheet_section_radio_main  "  data-product_quality_selection="premium"   name="digital_printing_process">
                                            <span class="checkmark"></span>
                                        </label>
                                        <span class="  product-details-description">
                                          Reel-to-reel, digital print in 6  colours, plus white. With enhanced print quality, colour clarity and image registration. Plus label embellishment and finish options.

                                        </span>
                                    </div>



                                </div>

                             </div>

                            <div class="row printing_process_selection_inner_container">


                                <div class="col-md-4">
                                    <!--                                     <span style=" " class="col-md-6">-->
                                    <!--                                                    <img onerror="imgError(this);" class="img-responsive" src="http://localhost/newlabels/theme/site/images/new-printed-labels/printing-process-black-thumbnail.jpg">-->
                                    <!--                                           </span>-->
                                    <div class="col-md-6" style="  margin-top: 10% ">
                                        <label class="containerr" data-printing_process="Monochrome_Black_Only" style="  margin-left: 0% !important; "><span style="  margin-top: 31px;">Standerd Quality </span>

                                            <input type="radio" class="product_quality sheet_inner_section_radio" id="sheet_inner_section_radio_id_standerd"  data-product_quality_selection_inner="standerd"  name="sheet_inner_section_radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6" style="  margin-top: 10% ">
                                        <label class="containerr" data-printing_process="Monochrome_Black_Only" style="  margin-left: 0% !important; "><span style="  margin-top: 31px;">Premium Quality</span>

                                            <input type="radio" class="product_quality sheet_inner_section_radio" id="sheet_inner_section_radio_id_premium" data-product_quality_selection_inner="premium"  name="sheet_inner_section_radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <span class=" col-md-12  product-details-description"  id="standerd_inner_section_description">

                                            Sheet-fed, digital print quality in 4 standard colours (CMYK). Please note that it is not possible to apply label embellishments and finishes with this process.


                                        </span>

                                    <span class=" col-md-12  product-details-description" id="premium_inner_section_description">

                                          Reel-to-reel, digital print in 6  colours, plus white. With enhanced print quality, colour clarity and image registration. Plus label embellishment and finish options.

                                        </span>

                                </div>

                                <div class="col-md-8" id="standerd_inner_section_options">
                                    <?php foreach ($printing_process as $print_process) { ?>

                                        <div class="col-md-4">
                                            <?php if (preg_match("/Monochrome/i", $print_process->name)) { ?>
                                                <span>


                                                    <img onerror='imgError(this);' class="img-responsive"
                                                         src="<?= Assets ?>images/new-printed-labels/printing-process-blackk-thumbnail.jpg" style="height: 127px;">

                                            </span>
                                                <label class="containerr" data-printing_process="Monochrome_Black_Only">Monochrome
                                                    <br>Black Only

                                                    <input type="radio" checked <?php if (($preferences['digital_proccess_roll']) == 'Monochrome_Black_Only') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process" id="printing_process_default_check" name="digital_printing_process">
                                                    <span class="checkmark"></span>
                                                </label>
                                            <?php } elseif (preg_match("/Rich Black/i", $print_process->name)) { ?>
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
                                            <? } elseif (preg_match("/4 Colour Digital Process/i", $print_process->name)) { ?>
                                            <span>
                                                           <img onerror='imgError(this);' class="img-responsive"
                                                                src="<?= Assets ?>images/new-printed-labels/standard-pr-thumbnail.jpg" style="height: 127px;">
                                                          </span>
                                            <label class="containerr"
                                                   data-printing_process="4_Colour_Digital_Process">4 Colour
                                                <br>Digital Process
                                                <input type="radio" <?php if (($preferences['digital_proccess_roll']) == '4_Colour_Digital_Process') {
                                                    echo 'checked';
                                                } else {
                                                } ?> class="digital_process" name="digital_printing_process">
                                                <span class="checkmark"></span>
                                            </label>
                                            <? } ?>

                                        </div>
                                    <? } ?>
                                </div>

                                <div class="col-md-8" id="premium_inner_section_options">
                                    <?php foreach ($printing_process as $print_process) { ?>

                                        <div class="col-md-3">
                                            <?php if (preg_match("/Monochrome/i", $print_process->name)) { ?>
                                                <span>


                                                    <img onerror='imgError(this);' class="img-responsive"
                                                         src="<?= Assets ?>images/new-printed-labels/printing-process-blackk-thumbnail.jpg" style="height: 127px;">

                                            </span>
                                                <label class="containerr" data-printing_process="Monochrome_Black_Only">Monochrome
                                                    <br>Black Only

                                                    <input type="radio" checked <?php if (($preferences['digital_proccess_roll']) == 'Monochrome_Black_Only') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process pre_select_for_white" id="printing_process_default_check_premium" name="digital_printing_process"  >
                                                    <span class="checkmark"></span>
                                                </label>
                                            <?php } elseif (preg_match("/Rich Black/i", $print_process->name)) { ?>
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
                                            <? }elseif (preg_match("/ \+\ white/i", $print_process->name)) { ?>
                                                <span>
                                                <img onerror='imgError(this);' class="img-responsive"
                                                     src="<?= Assets ?>images/new-printed-labels/printing-process-white-thumbnail.jpg" style="height: 127px;">

                                                    </span>
                                                <label class="containerr"
                                                       data-printing_process="6_Colour_Digital_Process_White">Add White
                                                    <input type="checkbox" <?php if ($preferences['digital_proccess_roll'] == '6_Colour_Digital_Process_White') {
                                                        echo 'checked';
                                                    } else {
                                                    } ?> class="digital_process digital_process_plus_white" data-add_white="add_white" name="digital_printing_process_add_white">
                                                    <span class="checkmark"></span>
                                                </label>
                                            <? } elseif (preg_match("/6 Colour Digital Process/i", $print_process->name)) { ?>
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
                                            <?  } ?>

                                        </div>
                                    <? } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

<!--Your product detail section is moved to cart_summery.php file-->
   
    </section>
</div>
<!-- Printing Process & Products Details End -->
                                                   