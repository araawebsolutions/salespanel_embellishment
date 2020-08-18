
<style type="text/css">
    /*Css for Material Price section on lemb page Start*/
    .MaterialWhiteBg {
        background: #fff;
        padding: 10px;
        width: 69%;
        position: relative;
    }
    .MaterialProductPriceMain {
        float: right;
        /*width: 30.2%;*/
        position: absolute;
        right: -2px;
        top: -125px;
        z-index: 5;
        /*display: none; */
        padding: 10px;
    }
    .MaterialProductPrice {
        width: 100%;
        float: left;
        border-radius: 4px;
        border: 1px solid #00b7f1;
        display: none;
    }

    .MaterialProductPriceDescription {
        margin-left: 3px;
        float: left;
    }

    .MaterialProductPriceTitle {
        font-size: 14px;
        color: #17b0e2;
        word-spacing: -1px;
    }

    .MaterialProductPriceNormal {
        font-weight: normal;
        font-size: 12px;
        color: #333333;
        margin-top: 2px;
        float: left;
    }
    .MaterialProductLowestPrice {
        float: left;
        width: 100%;
    }

    .MaterialProductLowestPriceInner {
        float: right;
    }
    .MaterialProductLowestPriceInner svg{
        width: 30px;
        float: left;
    }
    .MaterialPriceQtyDropdownRoll {
        width: 100%;
        float: left;
        margin-top: 10px;
        border: 1px solid #e5e5e5;
        border-radius: 4px;
        height: 45px;
        position: relative;
    }

    .MaterialPriceQtyDropdownRoll label {
        float: left;
        width: 92%;
        font-weight: normal;
        padding: 0 0 0 10px;
    }

    .MaterialPriceQtyDropdownRoll label span {
        font-size: 10px;
        color: #000;
        padding-top: 5px;
        float: left;
    }

    .MaterialPriceQtyDropdownRoll label input {
        border: none;
        margin-top: 2px;
        font-size: 18px;
        font-weight: lighter;
        width: 100%;
        outline: none;
    }
    .MaterialPriceQtyDropdownRoll label input.qty-minus {
        border: none;
        line-height: 0.8;
        font-size: 23px;
        font-weight: lighter;
        width: 10%;
        background: transparent;
        float: right;
        position: absolute;
        right: 0px;
        bottom: 3px;
        text-align: center;
        padding: 0;
    }
    .MaterialPriceQtyDropdownRoll label input.qty-plus {
        border: none;
        line-height: 0.8;
        font-size: 23px;
        font-weight: lighter;
        width: 10%;
        background: transparent;
        float: right;
        position: absolute;
        padding: 0;
        right: 0px;
        top: 0px;
        text-align: center;
    }
    .MaterialPriceQtyRollDividTwo {
        width: 48.5%;
        margin-top: 10px;
        border: 1px solid #e5e5e5;
        border-radius: 4px;
        height: 45px;
        position: relative;
    }

    .MaterialPriceQtyRollDividTwo label {
        float: left;
        width: 80%;
        font-weight: normal;
        padding: 0 0 0 10px;
    }

    .MaterialPriceQtyRollDividTwo label span {
        font-size: 10px;
        color: #000;
        padding-top: 5px;
        float: left;
    }

    .MaterialPriceQtyRollDividTwo label input {
        border: none;
        margin-top: 2px;
        font-size: 18px;
        font-weight: lighter;
        width: 100%;
        outline: none;
    }
    .MaterialPriceQtyRollDividTwo label input.qty-minus {
        border: none;
        line-height: 0.8;
        font-size: 23px;
        font-weight: lighter;
        width: 15%;
        background: transparent;
        float: right;
        position: absolute;
        right: 2px;
        bottom: 3px;
        text-align: center;
        padding: 0;
    }
    .MaterialPriceQtyRollDividTwo label input.qty-plus {
        border: none;
        line-height: 0.8;
        font-size: 23px;
        font-weight: lighter;
        width: 15%;
        background: transparent;
        float: right;
        position: absolute;
        padding: 0;
        right: 2px;
        top: 0px;
        text-align: center;
    }
    .MaterialPriceMiniumBreaks {
        float: left;
        width: 100%;
        font-size: 9px;
        margin-top: 10px;
    }

    .MaterialPriceMiniumBreaks span.pull-left {
        color: #999;
    }

    .MaterialPriceMiniumBreaks span.pull-right {
        color: #006ca5;
        text-decoration: underline;
        cursor: pointer;
    }

    .MaterialPriceMiniumBreaks span {
        float: left !important;
        font-size: 11px;
        padding-bottom: 5px;
    }

    .MaterialPriceMiniumBreaks {
        margin-top: 5px;
    }
    .MaterialAddToBasketButton {
        float: left;
        width: 100%;
        margin-top: 20px;
    }

    .MaterialAddToBasketButton a {
        background: #fd4913;
        border: 1px solid #df3c0b;
        border-radius: 4px;
        color: #fff;
    }

    .MaterialAddToBasketButton a:hover, .MaterialAddToBasketButton a:focus {
        color: #fff;
    }
    .MaterialAddToBasketButton {
        margin-top: 10px;
    }
    .MaterialPriceData {
        float: left;
        width: 100%;
        text-align: right;
        margin-top: 20px;
    }

    .MaterialPriceData p {
        margin-bottom: 0;
        font-size: 12px;
        font-weight: bold;
        color: #333;
        margin-bottom: 2px;
    }

    .MaterialPriceData p {
        font-size: 10px;
    }
    .MaterialPriceData {
        margin-top: 10px;
    }

    .MaterialCollectionAvail {
        font-weight: bold;
        font-size: 15px !important;
        margin-top: 5px;
    }

    .MaterialCollectionAvail i {
        color: #339900;
    }
    /*Css for Material Price section on lemb page End*/
</style>

<!--  Cart Summary Starts -->
<?php
//echo "<pre>";var_dump($prices['rolls']);
if (preg_match("/SRA3/", $details['ProductBrand'])) {

    $min_qty = '100';
//    $min_qty = '1';
    $min_qty_threshold = '100';
    $max_qty = '20000';
    $type = 'SRA3';
} else if (preg_match("/A5/", $details['ProductBrand'])) {

    $min_qty = '25';
    $min_qty_threshold = '25';
//    $min_qty = '1';
    $max_qty = '50000';
    $type = 'A5';
} else if (preg_match("/A3/", $details['ProductBrand'])) {

    $min_qty = '100';
    $min_qty_threshold = '100';
//    $min_qty = '1';
    $max_qty = '50000';
    $type = 'A3';
} else {

    $min_qty = '25';
    $min_qty_threshold = '25';
    // $min_qty = '1';
    $max_qty = '50000';
    $type = 'A4';
}

if (preg_match("/PETC/", $details['ManufactureID']) || preg_match("/PETA/", $details['ManufactureID']) || preg_match("/PETH/", $details['ManufactureID']) || preg_match("/PVUD/", $details['ManufactureID'])) {
    $min_qty = '5';
    $min_qty_threshold = '5';
//    $min_qty = '1';
    $max_qty = '5000';
}


?>

<input type="hidden" value="<?= $prices['rolls'] ?>" class="free_roll_allowed"/>
<input type="hidden" value="<?= $details['type'] ?>" class="product_type"/>
<input type="hidden" value="<?= $details['LabelsPerSheet'] ?>" class="LabelsPerSheet"/>
<input type="hidden" value="<?= $min_qty ?>" class="minimum_quantities"/>
<input type="hidden" value="<?= $min_qty_threshold ?>" class="minimum_quantities_threshold"/>
<input type="hidden" value="<?= $max_qty ?>" class="maximum_quantities"/>

<?php
if (isset($edit_cart_flag) && $edit_cart_flag != '') {

    $attachments_count = count($IA_data);
    if ($attachments_count > 0) {
        $artwork_now_or_follow = "upload_artwork_now";
    } else {
        $artwork_now_or_follow = "artwork_to_follow";
    }


    $cost_effective = "";
    $custom_roll_and_label = "";

    $cost_effective_custom_rolls = "";

    if ($cart_and_product_data['custom_roll_and_label'] == "cost_effective") {
        $cost_effective = true;
        $cost_effective_custom_rolls = "cost_effective";
    } else if ($cart_and_product_data['custom_roll_and_label'] == "custom_roll_and_label") {
        $custom_roll_and_label = true;
        $cost_effective_custom_rolls = "custom_roll_and_label";
    } else {
        $cost_effective_custom_rolls = "cost_effective";
    }

}
$assets = Assets; ?>
<div id="cart_summery_loader" class="white-screen"
     style="position: absolute;top: 6%;right: 0;width: 26%;z-index: 999;height: 92%;display: none;background: #FFF;opacity: 0.8;">
    <div class="text-center"
         style="    margin: 68% auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 60%;border: solid 1px #CCC;">
        <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
             style="width:139px; height:29px; " alt="AA Labels Loader">
    </div>
</div>

<!--style="display: none;float: right;  width: 22.8%;  position: absolute;  right: 21px;  top: 111px;"-->
<div class="MaterialProductPriceMain MaterialProductPriceMain_container" style="display: none;">

    <div class="aa_loader" class="white-screen"
         style="position: absolute;top: 0;right: 0;width: 100%;z-index: 999;height: 100%; display: none;background: #FFF; opacity: 0.8">
        <div class="text-center"
             style="margin: 80px auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;border: solid 1px #CCC;">
            <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
                 style="width:139px; height:29px; " alt="AA Labels Loader">
        </div>
    </div>

    <div class="MaterialWhiteBg MaterialProductPrice productdetails" style="display: block; border: none !important;"
         id="add_to_cart_<?php echo $materialCounter; ?>">

        <!-- <div class="RollMaterialWhiteBgDisabled disablePopup">
            <p class="selectWoundCoreerror">
                Select Core Size & Wound Options First from top of this page
            </p>
        </div> -->

        <div class="MaterialProductLowestPrice">
            <div class="">
                <a href="javascript:void(0);" class="price_breaks" data-target=".pbreaks" data-toggle="modal"
                   data-original-title="Volume Price Breaks">
                    <img src="<?= Assets ?>images/price-breaks-icon.png" class="float-left"
                         alt="30 Days Moneyback Guarantee" style=" width: 25px;"></a>
            </div>

            <div class="MaterialProductLowestPriceInner">
                <svg id="f7781957-f958-4943-8fa1-6aa48e9850c7" class="LowestPrice" data-name="Layer 1"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"><title>tick-01</title>
                    <polygon points="22.47 1.72 25 4.09 10.84 17.67 4.91 12.11 7.44 9.74 10.84 12.93 22.47 1.72"
                             style="fill:#17b0e2"/>
                    <path d="M21.38,9.3a9.79,9.79,0,1,1-3.4-5l1.65-1.59A12,12,0,1,0,24,12a12.13,12.13,0,0,0-.84-4.44Z"
                          style="fill:#17b0e2"/>
                </svg>
                <div class="MaterialProductPriceDescription">
                    <span class="MaterialProductPriceTitle">LOWEST PRICE</span><br>
                    <span class="MaterialProductPriceNormal">GUARANTEED ONLINE &nbsp;<a href="javascript:void(0);"
                                                                                        data-toggle="tooltip-product"
                                                                                        data-html="true"
                                                                                        data-placement="top" class=""
                                                                                        title=""
                                                                                        data-original-title="If within 7 days of buying this Dry Edge product sheet from us, you find the same product cheaper to purchase online at any other UK label website, we will refund 100% of the difference."><i
                                    class="fa fa-info-circle"></i></a> </span>
                </div>
            </div>
        </div>
        <div class="MaterialPriceQtyDropdownRoll enterNoOfLabels">
            <label>

                <span>Enter Number of Labels</span>
                <!-- <input type="button" value="-" class="qty-minus" onclick="increement_decreement(this, 'enterNoOfLabels', 'plainsheet_input', '<?php echo $min_qty * $min_labels_per_roll; ?>', '<?php echo $product->LabelsPerSheet * $max_qty; ?>', 'decreement', 10);"> -->
                <input type="text" value="<?php echo $min_qty * $min_labels_per_roll; ?>"
                       class="qty allownumeric plainsheet_input inpu_qty_edit">
                <input type="hidden" value="<?php echo $min_qty * $min_labels_per_roll; ?>"
                       class="qty allownumeric plainsheet_input_min">
                <!-- <input type="button" value="+" class="qty-plus" onclick="increement_decreement(this, 'enterNoOfLabels', 'plainsheet_input', '<?php echo $min_qty * $min_labels_per_roll; ?>', '<?php echo $product->LabelsPerSheet * $max_qty; ?>', 'increement', 10);"> -->
            </label>
        </div>
        <div class="MaterialPriceQtyRollDividTwo pull-left  labelsPerRolls" style="display: none;">
            <label>
                <span>Labels Per Roll</span>
                <input type="button" value="-" class="qty-minus"
                       onclick="increement_decreement(this, 'labelsPerRolls', 'plainlabels', '<?php echo $min_labels_per_roll; ?>', '<?php echo $product->LabelsPerSheet; ?>', 'decreement', 10);">
                <input type="text" value="<?= $product->LabelsPerSheet ?>" class="qty allownumeric plainlabels">
                <input type="button" value="+" class="qty-plus"
                       onclick="increement_decreement(this, 'labelsPerRolls', 'plainlabels', '<?php echo $min_labels_per_roll; ?>', '<?php echo $product->LabelsPerSheet; ?>', 'increement', 10);">
            </label>
        </div>
        <div class="MaterialPriceQtyRollDividTwo pull-right mainRolls" style="display: none;">
            <label>
                <span>Number of Rolls</span>
                <input type="button" value="-" class="qty-minus"
                       onclick="increement_decreement(this, 'mainRolls', 'plainrolls', '<?php echo $min_qty; ?>', '<?php echo $max_qty; ?>', 'decreement', '<?php echo $min_qty; ?>');">
                <input type="text" value="<?= $min_qty ?>" class="qty allownumeric plainrolls">
                <input type="button" value="+" class="qty-plus"
                       onclick="increement_decreement(this, 'mainRolls', 'plainrolls', '<?php echo $min_qty; ?>', '<?php echo $max_qty; ?>', 'increement', '<?php echo $min_qty; ?>');">

            </label>
        </div>
        <div class="MaterialPriceMiniumBreaks">
            <span class="pull-left"
                  style="width: 47%;">Type <?= $min_labels_per_roll ?> - <?= $product->LabelsPerSheet ?> Label per roll</span>
            <span class="pull-left" style="width: 47%; margin-left: 15px;">Multiples of <?= $min_qty ?> only</span>
        </div>

        <div style="clear:both;"></div>

        <div class="calculations">

            <div class="row">
                <div class="MaterialPriceExVat text-right">
                    <div class="col-md-12">

                        <div class="plainprice_box">
                            <div class="MaterialPrintPriceMain hideSection">

                                <?php
                                if (($type == "Rolls") && ($product->Printable == "Y")) {
                                    ?>

                                    <table>
                                        <tr>
                                            <td style="text-align: left;font-size: 13px;">Print Price</td>
                                            <td align="right" class="printing_offer_text_full"
                                                style="font-size: 13px;"></td>
                                        </tr>
                                        <tr class="HalfPricePromotion MaterialCollectionAvail">
                                            <td style="text-align: left;font-size: 15px;">Half Price Promotion</td>
                                            <td align="right" style="font-size: 15px !important;"
                                                class="printing_offer_text AddPrintPrice"></td>
                                        </tr>
                                        <tr class="addprintHead">
                                            <td>&nbsp;</td>
                                            <td align="right"><small class="vat_option_printed">Ex VAT</small></td>
                                        </tr>
                                        <tr>

                                        </tr>

                                    </table>

                                <?php } ?>
                            </div>

                            <!--                                <div class="text-right plainprice_text priceplain">&nbsp;</div>-->
                            <div class="clear"></div>
                            <div class="clear"></div>
                            <span class="pull-right plainperlabels_text text-right">&nbsp;</span>
                            <div class="clear"></div>
                        </div>

                    </div>

                    <div class="col-md-12" style="margin-top: 8px;">
                        <div style="display: none;" class="rollLable_icon no-margin diamterinfo">Roll Diameter <span
                                    style="display: block;"></span></div>
                    </div>
                </div>

            </div>


            <div class="MaterialPriceData" style="margin-top: 8px;">
                <p style="font-size: 10px;">Order before 16:00 for next working day delivery.</p>
                <div class="freeDeliveryMessageAppear"></div>
                <p class="MaterialCollectionAvail"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Collection
                    service available</p>
            </div>

        </div>


        <div class="MaterialAddToBasketButton">


            <?php
            $categorycodea4 = array($details['CategoryImage']);
            $categorycoderoll = '';
            $rollcode = '';
            $A4code = '';
            $code = explode('.', $details['CategoryImage']);
            $userData = $this->user_model->get_data();
            $selected_size = $details['CategoryID'];
            $type = $type;
            $email = $userData['UserEmail'];
            $material = $product->ColourMaterial_upd;
            $color = $product->Material1;
            $adhesive = $adhesive;
            $shape = $details['Shape_upd'];
            $min_width = floor($details['Width']);
            $max_width = ceil($details['Width']);
            $min_height = floor($details['Height']);
            $max_height = ceil($details['Height']);
            $dieCode = explode(".", $details['PDF']);
            $dieCode = $dieCode[0]; ?>

            <input type="hidden" name="shape" class="shape" value="<?php echo $shape; ?>">
            <input type="hidden" name="min_width" class="min_width" value="<?php echo $min_width; ?>">
            <input type="hidden" name="max_width" class="max_width" value="<?php echo $max_width; ?>">
            <input type="hidden" name="min_height" class="min_height" value="<?php echo $min_height; ?>">
            <input type="hidden" name="max_height" class="max_height" value="<?php echo $max_height; ?>">
            <input type="hidden" name="available_in" class="available_in" value="Roll">
            <input type="hidden" name="type" class="type" value="<?php echo $type; ?>">
            <input type="hidden" name="email" class="email" value="<?php echo $email; ?>">
            <input type="hidden" name="source" class="source" value="material_page">
            <input type="hidden" name="material" class="material" value="<?php echo $material; ?>">
            <input type="hidden" name="color" class="color" value="<?php echo $color; ?>">
            <input type="hidden" name="adhesive" class="adhesive" value="<?php echo $adhesive; ?>">
            <input type="hidden" name="dieCode" class="dieCode" value="<?php echo $dieCode; ?>">
            <input type="hidden" name="selected_size" class="selected_size" value="<?php echo $selected_size; ?>">

            <?php if (preg_match('/WTDP/', $product->ManufactureID)): ?>

                <a class="btn btn-block get_a_quote_plain" data-toggle="modal" data-target="#get_a_quote"
                   data-printing="N"> Get a Quote</a>

                <a href="javascript:;" class="btn btn-block reCalculatePrices" onclick="reCaculate(this)"
                   style="display: none;"> Calculate Price <i class='fa fa-calculator'></i> </a>

            <?php else: ?>
                <!-- <a href="javascript:;" class="btn btn-block add_plain" onclick="addPlain(this)"> Add to Basket </a> -->
                <!--            <a href="javascript:;" class="btn btn-block addprintBtn add_plain save_qty_btn" onclick="printed_labels(this);">Save</a>-->
                <a href="javascript:;" class="btn btn-block save_qty_btn">Save</a>
                <a href="javascript:;" class="btn btn-block reCalculatePrices" onclick="reCaculate(this)"
                   style="display: none;"> Calculate Price <i class='fa fa-calculator'></i> </a>
            <?php endif; ?>


        </div>
        <!--        <div class="aa_loader_sample" class="white-screen"-->
        <!--             style="position: absolute;top: 360px;right: 0;width: 100%;z-index: 999;height: 67%; display: none;background: #FFF; opacity: 0.8">-->
        <!--            <div class="text-center"-->
        <!--                 style="margin: 80px auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;border: solid 1px #CCC;">-->
        <!--                <img onerror="imgError(this);" src="-->
        <? //= Assets ?><!--images/loader.gif" class="image"-->
        <!--                     style="width:139px; height:29px; " alt="AA Labels Loader">-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class=" ">-->
        <!--             <a href="javascript:void(0);" onclick="rsampleEmbellishmentRoll(this)">-->
        <!--                <img style="    margin-top:41% ;    margin-left: -0.6%;-->
        <!--    position: absolute;-->
        <!--    left: 2px;-->
        <!--    width: 100%;" src="--><? //= Assets ?><!--images/label-embellishment-sample-order-banner.png"-->
        <!--                     alt="label-embellishment-sample-order-banner">-->
        <!--            </a>-->
        <!---->
        <!--        </div>-->

    </div>
</div>


<?php if ($availabel_in == 'Roll') { ?>

<div class="mt-15 col-md-12 col-xs-12   matselector" id="roll_material_selection" style="margin-top: -290px;">
    <?php }else{ ?>

    <div class="  col-md-12 col-xs-12   matselector" id="a4_material_selection" style="margin-top: -183px;">
        <?php } ?>
        <div class="panel panel-default  ">
            <div id="headingOne" class="panel-title_blue">
                <div>Your Product(s) Detail</div>
            </div>

            <div class="row padding-20 product_details_container">


                <?php if ($availabel_in == 'Roll') { ?>
                <div class="col-md-5">
                    <?php }else{

                    if (preg_match("/a3/i", $availabel_in)) { ?>

                    <div class="col-md-5">
                        <?php }elseif (preg_match("/sra3/i", $availabel_in)) { ?>
                        <div class="col-md-5">

                            <?php }elseif (preg_match("/a5/i", $availabel_in)) { ?>
                            <div class="col-md-4">

                                <?php } elseif (preg_match("/a4/i", $availabel_in)) {
                                ?>
                                <div class="col-md-3">

                                    <?php } ?>
                                    <?php }

                                    ?>

                                    <?php if (isset($details) and $details != '' && $availabel_in == "Roll") {
                                        $image = explode('.', $details['CategoryImage']);
                                        $img_chgr = $image[0];
                                        $imagename = $image[0];
                                        $imagecode = substr($details['ManufactureID'], 0, -1);


                                        if (isset($preferences['coresize']) && !empty($preferences['coresize'] && !empty($preferences['wound_roll']))) {
                                            $core = substr($preferences['coresize'], -1, 1);
                                            $wound = strtolower($preferences['wound_roll']);
                                            $img_src = $assets . "images/categoryimages/RollLabels/" . $wound . "/" . $imagecode . $core . ".jpg";

                                        } else {
                                            $img_src = $assets . "images/categoryimages/RollLabels/outside/" . $imagecode . "4.jpg";

                                        }
//                                        print_r($img_src);
                                        ?>


                                        <input type="hidden" id="product_code"
                                               value="<?= $imagecode; ?>">
                                        <?php
                                        //$img_src = Assets."images/categoryimages/RollLabels/outside/".$product_details['ManufactureID'].".jpg";

//                                        if (!getimagesize($img_src)) {
//                                            $img_src = $assets . "images/categoryimages/RollLabels/" . $imagename . ".jpg";
//                                        }
//                                        if (!getimagesize($img_src)) {
//                                            $img_src = $assets . "images/categoryimages/roll_desc/" . $imagename . 'R4' . ".jpg";
//                                        }
//                                        var_dump($img_src);

                                    } else {

                                        $img_src = $assets . "images/categoryimages/" . $availabel_in . "Sheets/colours/" . $preferences['productcode_a4'] . ".png";
                                    }
                                    //                                    print_r($assets);

                                    ?>


                                    <img onerror='imgError(this);' src="<?= $img_src ?>"
                                         data-core="R1"
                                         data-imagename="<?= $imagename ?>"
                                         alt="AA Labels Printed Labels"
                                         id="wound_image" class="img-responsive">
                                    <div class="clear"></div>


                                    <!--                            <img onerror='imgError(this);' class="img-responsive"-->
                                    <!--                                 src="--><? //= Assets
                                    ?><!--images/new-printed-labels/sample-product-detail-image.jpg">-->
                                </div>
                                <?php if ($availabel_in == 'Roll') { ?>
                                <div class="col-md-7 p-0">
                                    <?php }else{


                                    if (preg_match("/a3/i", $availabel_in)) { ?>

                                    <div class="col-md-7">
                                        <?php }elseif (preg_match("/sra3/i", $availabel_in)) { ?>
                                        <div class="col-md-7">

                                            <?php }elseif (preg_match("/a5/i", $availabel_in)) { ?>
                                            <div class="col-md-8">

                                                <?php } elseif (preg_match("/a4/i", $availabel_in)) { ?>
                                                <div class="col-md-9">

                                                    <?php } ?>

                                                    <?php } ?>
                                                    <span class="product-details-title"><span
                                                                id="product_color"> <?php echo ($preferences['color_roll']) ? ($preferences['color_roll']) : ($preferences['color_a4']) ?></span> <span
                                                                id="product_material"> </span><?php echo ($preferences['material_roll']) ? ($preferences['material_roll']) : ($preferences['material_a4']) ?> :</span><br>
                                                    <span class="product-details-description">Product Code: <span
                                                                id="product_code"><?php echo ($preferences['categorycode_roll']) ? ($preferences['categorycode_roll']) : ($preferences['categorycode_a4']) ?></span>,<br>
                                            Label Size (mm): <span id="label_size"><?php echo $label_size; ?> </span>,
                                            <span id="product_shape"><?php echo $preferences['shape']; ?> </span>,
                                            <span id="product_material_text"> <?php echo ($preferences['material_roll']) ? ($preferences['material_roll']) : ($preferences['material_a4']) ?></span>,
                                            <span id="product_color_text"><?php echo ($preferences['color_roll']) ? ($preferences['color_roll']) : ($preferences['color_a4']) ?> </span>,
                                        <span id="product_adhesive"><?php echo ($preferences['adhesive_roll']) ? ($preferences['adhesive_roll']) : ($preferences['adhesive_a4']) ?> </span> Adhesive.</span>


                                                </div>


                                                <!--                                    plain print price section start-->
                                                <?php
                                                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                                                    if ($flag == 'order_detail') {
                                                        $table = 'orderdetails';
                                                        $where_coumn = 'SerialNumber';
                                                        $acutal_labels = $this->home_model->get_db_column($table, 'labels', $where_coumn, $lineNumber);
                                                    } elseif ($flag == 'quotation_detail') {
                                                        $table = 'quotationdetails';
                                                        $where_coumn = 'SerialNumber';
                                                        $acutal_labels = $this->home_model->get_db_column($table, 'orignalQty', $where_coumn, $lineNumber);
                                                    }
                                                    $cartid = '';

                                                    $acutal_sheets = $this->home_model->get_db_column($table, 'Quantity', $where_coumn, $lineNumber);

                                                } else {

                                                    if( $edit_cart_flag ) {?>
                                                        <input type="hidden" id="selected_digital_process" value="<?= $cart_and_product_data['Print_Type'];?>" />
                                                        <input type="hidden" id="selected_line_type" value="<?= $cart_and_product_data['ProductBrand'];?>" />
                                                        <input type="hidden" id="selected_combination_base" value="<?= $cart_and_product_data['combination_base'];?>" />
                                                        <input type="hidden" id="custom_roll_and_label" value="<?= $cost_effective_custom_rolls;?>" />
                                                        <input type="hidden" id="artwork_now_or_follow" value="<?= $artwork_now_or_follow;?>" />

                                                        <?php $cartid = $cart_and_product_data['ID'];
                                                    } else {
                                                        $SID = $this->shopping_model->sessionid() . '-PRJB';
                                                        $cartid = $this->home_model->get_db_column('temporaryshoppingbasket', 'id', 'SessionID', $SID);
                                                    }

                                                    $acutal_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
                                                    $acutal_sheets = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
                                                }



                                                $total_labels = 0;
                                                $total_emb_and_plate_cost =  $prices['label_finish'] + $total_emb_plate_price;

                                                ?>
                                                <input type="text" id="cartid" value="<?= $cartid ?>"/>
                                                <!--    <input type="hidden" id="cartproductid" value="-->
                                                <? //= $rolldetails['ProductID'] ?><!--"/>-->
                                                <input type="hidden" id="cartunitqty" value="<?= $unitqty ?>"/>
                                                <!--    <div class="panel panel-default">-->
                                                <!--        <div id="headingOne" class="panel-title_blue">-->
                                                <!--            <div>Cart Summary</div>-->
                                                <?php $total_ex_vat = 0;
                                                $total_finish_emb_cost_and_plate_price = 0;
                                                $total_finish_emb_cost_and_plate_price = $total_emb_plate_price;
                                                $total_finish_emb_cost_and_plate_price += $prices['label_finish'];
                                                //             $total_ex_vat += $total_finish_emb_cost_and_plate_price;
                                                ?>
                                                <!--        </div>-->


                                                <div class="font-13x" style="margin-top: 125px;">
                                                    <div class="row">
                                                        <div class="col-md-3">Quantity</div>
                                                        <div class="col-md-4"><a href="javascript:;" id="emb_qty_edit"
                                                                                 style="text-decoration: underline">Edit</a>
                                                        </div>
                                                        <div class="col-md-5 text-right">  <?php
                                                            if (!empty($labels) && $labels > 0) { ?>
                                                                <span class="current_qty"><?php echo $labels; ?></span>
                                                                <?php $total_labels = $labels;
                                                            } else {
                                                                $total_labels = $sheetdetails['LabelsPerSheet'] * $preferences['labels_a4'];
                                                                echo $sheetdetails['LabelsPerSheet'] * $preferences['labels_a4'];
                                                            }
                                                            ?> (Labels)
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-7">Plain Labels Price</div>
                                                        <div class="col-md-5 text-right">

                                                            <?php
                                                            if ($producttype == 'sheet') {
                                                                echo symbol . $prices['plainprice'];
                                                                $total_ex_vat += $prices['plainprice'];
                                                            } else {
                                                                echo symbol . $prices['plainlabelsprice'];
                                                                $total_ex_vat += $prices['plainlabelsprice'];
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-7">Print Labels (<?php echo $labeltype; ?>)
                                                        </div>
                                                        <div class="col-md-5 text-right">
                                                            <?php
                                                            if ($producttype == 'sheet') {
//                        for sheet *2 to display half price promotion and in case of rolls its already multiplied in function result
                                                                $print_price = $prices['printprice'] * 2;
                                                                $print_price = number_format(($print_price), 2, '.', '');
                                                                echo symbol . $print_price;

                                                            } else {
                                                                echo symbol . $prices['onlyprintprice'];
                                                            }
                                                            ?>

                                                        </div>
                                                        <div class="row">

                                                            <div class="col-md-9"><strong>Half Print Price
                                                                    Promotion</strong></div>
                                                            <div class="col-md-3 text-right"><strong>-

                                                                    <?php
                                                                    if ($producttype == 'sheet') {
                                                                        $prices['printprice'] = number_format(($prices['printprice']), 2, '.', '');

                                                                        echo symbol . $prices['printprice'];
                                                                        $total_ex_vat += $prices['printprice'];

                                                                    } else {
                                                                        $prices['halfprintprice'] = number_format(($prices['halfprintprice']), 2, '.', '');

                                                                        echo symbol . $prices['halfprintprice'];
                                                                        $total_ex_vat += $prices['halfprintprice'];

                                                                    }
                                                                    ?>

                                                                </strong></div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!--                                    plain print price section end-->


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>






            <div class="col-md-12 col-xs-12">




                <!--</div>-->

                <!--   Label finish and embellishment saperate cost and plate price section start -->
                <?php if (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array'])) { ?>
                    <div  style=" margin-top: 10px;min-height: 378px;max-height: 378px;">
                        <div class="panel panel-default">


                            <div class="padding-10-px font-13x">

                                <div class="row">

                                    <?php
                                    foreach ($prices['label_finish_individual_cost_array'] as $label_finish_individual_cost_array) { ?>


                                        <div class="col-md-9"><?php echo ucwords(str_replace('_', ' ', $label_finish_individual_cost_array->finish_parsed_title)); ?></div>
                                        <?php


                                        $label_finish_individual_cost = $label_finish_individual_cost_array->finish_price + $label_finish_individual_cost_array->plate_cost;
                                        $label_finish_individual_cost = number_format($label_finish_individual_cost, 2, '.', '');
                                        $total_ex_vat += $label_finish_individual_cost;

                                        ?>
                                        <div class="col-md-3 text-right"><span
                                                    id=" "> <?php echo symbol . $label_finish_individual_cost; ?> </span>
                                        </div>
                                    <?php }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>


                <!--   Label finish and embellishment cost and plae price section end -->


                <!--already purchased plate section start-->
                <?php if (isset($minus_plate_cost) && !empty($minus_plate_cost)) { ?>
                    <div class="panel panel-default" style="margin-top: -10px;min-height: 78px;">

                        <div class="padding-10-px font-13x">

                            <!--                Show each emb & finish cost saperately-->


                            <!--Block that shows already purchased plate prices if any start-->
                            <div class="row">

                                <?php
                                foreach ($minus_plate_cost as $minus_plate_cost_single) { ?>

                                    <div class="col-md-9"><?php echo ucwords(str_replace('_', ' ', $minus_plate_cost_single->parsed_title)); ?>
                                        (Existing Plate)
                                    </div>
                                    <?php


                                    $label_finish_individual_cost_minus = number_format($minus_plate_cost_single->plate_cost, 2, '.', '');
//                        update total emb and plate price and substract already purchased price in it if any
                                    $total_emb_and_plate_cost -= $minus_plate_cost_single->plate_cost;
                                    $total_ex_vat -= $minus_plate_cost_single->plate_cost;


                                    ?>
                                    <div class="col-md-3 text-right"><span
                                                id=" "> <?php echo symbol . '-' . $label_finish_individual_cost_minus; ?> </span>
                                    </div>
                                <?php }
                                ?>
                            </div>

                        </div>

                    </div>
                <?php } ?>
                <!--already purchased plate section end-->


                <!--    Extra roll charges in case of rolls and extra design charges in case of sheet start -->
                <?php
                if (($producttype == 'sheet' && $prices['designprice'] > 0) || $producttype != 'sheet' && $prices['additional_cost'] > 0) { ?>
                    <div class="panel panel-default" style="min-height: 67px;">

                        <div class="padding-10-px font-13x">

                            <div class="row ">
                                <?php
                                if ($producttype == 'sheet' && $prices['designprice'] > 0) { ?>
                                    <div class="row">
                                        <div class="col-md-7">Additional Design Price</div>
                                        <div class="col-md-5 text-right">

                                            <?php
                                            if ($producttype == 'sheet') {
                                                echo symbol . $prices['designprice'];
                                                $total_ex_vat += $prices['designprice'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($producttype != 'sheet' && $prices['additional_cost'] > 0) { ?>
                                    <div class="row">
                                        <div class="col-md-7">Additional Roll Charges</div>
                                        <div class="col-md-5 text-right">

                                            <?php
                                            echo symbol . $prices['additional_cost'];
                                            $total_ex_vat += $prices['additional_cost'];
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>


                            </div>

                        </div>

                    </div>
                <?php }


                //                print_r($prices['presproof_charges']);
                if (isset($prices['presproof_charges']) && $prices['presproof_charges'] > 0) { ?>
                    <div class="panel panel-default" style="margin-top: 30px;min-height: 44px;">

                        <div class="padding-10-px font-13x">
                            <div class="col-md-7">Press Proof</div>
                            <div class="col-md-5 text-right">

                                <?php
                                echo symbol . $prices['presproof_charges'];
                                $total_ex_vat += $prices['presproof_charges'];
                                ?>
                            </div>
                        </div>
                    </div>

                <?php } ?>


                <!--    Extra roll charges in case of rolls and extra design charges in case of sheet end -->


                <input type="hidden" value="<?= $total_ex_vat ?>" id="summary_total_price"/>
                <input type="hidden" value="<?= $acutal_labels ?>" id="acutal_labels"/>
                <input type="hidden" value="<?= $acutal_sheets ?>" id="acutal_qty"/>
                <!--Total price and price per label cost section start-->
                <!--section that determin total price container margin top according to selection-->
                <?php if (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array']) && !isset($prices['presproof_charges'])) { ?>

                <div class="total_price_container" style="margin-top:99%">

                    <?php }
                    if (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array']) &&
                    isset($prices['presproof_charges']) && $prices['presproof_charges'] > 0 && isset($prices['additional_cost'])  && empty($minus_plate_cost)&& $prices['additional_cost'] > 0)  { ?>
                    <div class="total_price_container" style="margin-top:48%">
                        <?php
                        }elseif (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array']) &&
                        isset($prices['presproof_charges']) && $prices['presproof_charges'] > 0 && empty($minus_plate_cost) ||
                        isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array']) && empty($minus_plate_cost) &&
                        isset($prices['additional_cost']) && $prices['additional_cost'] > 0) { ?>
                        <div class="total_price_container" style="margin-top:80%">
                            <?php
                            }elseif (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array']) &&
                            isset($prices['presproof_charges']) && $prices['presproof_charges'] > 0  && isset($minus_plate_cost) && !empty($minus_plate_cost)
                            && isset($prices['designprice']) && $prices['designprice'] > 0 ||
                            isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array'])
                            && isset($prices['presproof_charges']) && $prices['presproof_charges'] > 0 &&
                            isset($prices['additional_cost'])  && $prices['additional_cost'] > 0 && isset($minus_plate_cost) && !empty($minus_plate_cost)) { ?>
                            <div class="total_price_container" style="margin-top:20%">

                                <?php }elseif (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array']) &&
                                !isset($prices['presproof_charges'])   && isset($minus_plate_cost) && !empty($minus_plate_cost)
                                && isset($prices['designprice']) && $prices['designprice'] > 0 ||
                                isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array'])
                                &&  ($prices['presproof_charges']) <=0   &&
                                isset($prices['additional_cost'])  && $prices['additional_cost'] > 0 && isset($minus_plate_cost) && !empty($minus_plate_cost)) { ?>
                                <div class="total_price_container" style="margin-top:48%">

                                    <?php }elseif ((!isset($prices['label_finish_individual_cost_array']) || empty($prices['label_finish_individual_cost_array'])) &&
                                    isset($prices['presproof_charges'])  && $prices['presproof_charges'] > 0  && (!isset($minus_plate_cost) || empty($minus_plate_cost))
                                    && (!isset($prices['designprice']) ||  ($prices['designprice'] <=0)) && (!isset($prices['additional_cost'])||  ($prices['additional_cost'] <=0))) { ?>
                                    <div class="total_price_container" style="margin-top:218%">

                                        <?php }elseif ((isset($prices['label_finish_individual_cost_array']) &&  !empty($prices['label_finish_individual_cost_array']))
                                        && (!isset($prices['presproof_charges']) ||  ($prices['presproof_charges']) <= 0)   && (isset($minus_plate_cost) && !empty($minus_plate_cost))
                                        && (!isset($prices['designprice']) ||  ($prices['designprice'] <=0)) && (!isset($prices['additional_cost']) ||  ($prices['additional_cost'] <=0))) {
                                        //                        echo"<pre>";print_r($minus_plate_cost);echo "</pre>";
                                        ?>
                                        <div class="total_price_container" style="margin-top:73%">

                                            <?php }elseif ((isset($prices['label_finish_individual_cost_array']) &&  !empty($prices['label_finish_individual_cost_array']))
                                            && (!isset($prices['presproof_charges']) ||  ($prices['presproof_charges']) <= 0)   && (!isset($minus_plate_cost) || empty($minus_plate_cost))
                                            && (!isset($prices['designprice']) ||  ($prices['designprice'] <=0)) && (!isset($prices['additional_cost']) ||  ($prices['additional_cost'] <=0))) { ?>
                                            <div class="total_price_container" style="margin-top:105%">

                                                <?php }elseif ((isset($prices['label_finish_individual_cost_array']) &&  !empty($prices['label_finish_individual_cost_array']))
                                                && (isset($prices['presproof_charges']) ||  ($prices['presproof_charges']) > 0)   && (isset($minus_plate_cost) && !empty($minus_plate_cost))
                                                && (!isset($prices['designprice']) ||  ($prices['designprice'] <=0)) && (!isset($prices['additional_cost']) ||  ($prices['additional_cost'] <=0))) { ?>
                                                <div class="total_price_container" style="margin-top:48%">

                                                    <?php }else { ?>
                                                    <div class="total_price_container" style="margin-top:242%">

                                                        <?php } ?>

                                                        <div class="row">
                                                            <div class="col-md-7 total-font-size">Total (<?= vatoption; ?> VAT)</div>
                                                            <!--        --><?php //$total_ex_vat+= $prices['presproof_charges'];?>
                                                            <div class="col-md-5 text-right total-font-price " id="cart_summery_total_price"><?php
                                                                $total_ex_vat = number_format($total_ex_vat, 2, '.', '');

                                                                echo symbol . $total_ex_vat; ?></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 text-right">
                                                                <?php
                                                                if ($producttype == 'sheet') {

                                                                    $perlabel = $total_ex_vat / $total_labels;
//                        $perlabel = round($perlabel, 4);
                                                                    $perlabel = number_format($perlabel, 4, '.', '');

//                        $perlabel = explode(',',$prices['labelprice']);
                                                                    ?>


                                                                    <!--                    (--><?php //echo $perlabel[1];
                                                                    ?><!--)-->
                                                                    (<?php echo symbol . $perlabel . ' per label'; ?>)

                                                                <?php } else {
                                                                    $perlabel = $total_ex_vat / $total_labels;
                                                                    $perlabel = round($perlabel, 4);

//                        $perlabel = explode(',',$prices['labelprice']);
                                                                    ?>

                                                                    <!--                        (--><?php //echo $perlabel[1];
                                                                    ?><!--)-->
                                                                    (<?php echo symbol . $perlabel . ' per label'; ?>)
                                                                <?php }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--Total price and price per label cost section end-->
                                                    <!--Proceed button CTA and Calculate Price CTA start-->
                                                    <div>
                                                        <!--        <a href="javascript:;" class="label-embellishement-cta proceed_to_checkout" id="label-embellishement-cta" onclick="proceedToCart(this)">Proceed with printed labels on <span  id="brandName">-->
                                                        <?php //echo  ucfirst($producttype);?><!-- </span></a>-->
                                                        <!--        <a href="javascript:;" class="label-embellishement-cta proceed_to_checkout" id="label-embellishement-cta" >Proceed with printed labels on <span  id="brandName">-->
                                                        <?php //echo  ucfirst($producttype);?><!-- </span></a>-->
                                                        <!--        <a href="javascript:;" class="label-embellishement-cta " id="label-embellishement-calculate-price-cta" style="display: none ;" onclick="reCaculate(this)">Calculate Price <i class='fa fa-calculator'></i></a>-->

                                                    </div>
                                                    <!--Proceed button CTA and Calculate Price CTA end-->

                                                    <!--  Cart Summary Ends -->






