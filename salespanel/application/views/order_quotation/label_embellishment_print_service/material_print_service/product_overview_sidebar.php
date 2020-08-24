<style>
    .price p {
        margin-top: 5px;
        margin-bottom: 5px !important;
    }

    #product_summary_overview .orange:hover {
        background-color: #FFF !important;
        border: 1px solid #fd4913 !important;
        color: #fd4913 !important;
    }
</style>
<?

if ($details['Shape_upd'] == "Circular") {
    $label_size = ucwords(str_replace("Label Size:", "", $details['specification3']));
    $label_size = str_replace("Mm", "mm", $label_size);
} else {
    $label_size = $details['LabelWidth'] . " x " . $details['LabelHeight'];
}

if ($details['labelCategory'] == 'Roll Labels') {

    $coresize = "R" . substr($details['ManufactureID'], -1, 1);
    $image = explode('.', $details['CategoryImage']);
    $imagename = $image[0];
    $img_src = Assets . "images/categoryimages/RollLabels/outside/" . $details['ManufactureID'] . ".jpg";
    if (!getimagesize($img_src)) {
        $img_src = Assets . "images/categoryimages/RollLabels/" . $imagename . ".jpg";

    }
    if (!getimagesize($img_src)) {
        $img_src = Assets . "images/categoryimages/roll_desc/" . $imagename . $coresize . ".jpg";
    }
    $icon_src = Assets . 'images/categoryimages/labelShapes/printed_roll.png';

    $category_id = str_replace($coresize, "", $details['CategoryID']);
    $rollcores = $this->home_model->roll_core_sizes($category_id, $coresize);
    $type = 'Rolls';

} else {

    
    if($details['ProductBrand'] == "A3 Label")
    {
        $img_src = Assets . "images/categoryimages/A3Sheets/" . $details['CategoryImage'];
    }
    else if($details['ProductBrand'] == "A4 Labels")
    {
        $img_src = Assets . "images/categoryimages/A4Sheets/" . $details['CategoryImage'];
    }
    else if($details['ProductBrand'] == "SRA3 Label")
    {
        $img_src = Assets . "images/categoryimages/SRA3Sheets/" . $details['CategoryImage'];
    }
    else if($details['ProductBrand'] == "A5 Labels")
    {
        $img_src = Assets . "images/categoryimages/A5Sheets/" . $details['CategoryImage'];
    }
    
    $icon_src = Assets . 'images/categoryimages/labelShapes/printed_sheet.png';
    $rollcores = '';
    $type = 'Sheets';
}

?>

<div class="title text-center <?= (isset($sidebar_class) and $sidebar_class != '') ? $sidebar_class : 'orange' ?>"><b class="col-sm-12 col-xs-12 text-center">
        <?= $labels ?>
        Labels
        <?= $sheets ?>
        <?= $type ?>
    </b> <i class="col-sm-4 col-xs-5 fa-3x m0 fa fa-shopping-cart text-right pull-left"></i> <b
            class="col-sm-8 col-xs-6 text-left  f-30">
        <?= symbol . number_format($prices['price'], 2, '.', '') ?>
    </b></div>
<div class="thumb thumb_p15 text-center"><img onerror='imgError(this);' height="115" class="" src="<?= $img_src ?>">
</div>
<div class="detail">
    <div class="">
        <div class="sfr">
            <div class=" <?= ($type == 'Sheets') ? 'col-md-6 ' : 'col-md-5 ' ?>col-xs-12">
                <div class="title">
                    <div class="roll-icon pull-left"><img onerror='imgError(this);' class="" src="<?= $icon_src ?>"
                                                          alt="Printed Labels on <?= $type ?>"></div>
                    <h4 class="pull-left no-margin">Selection <br>
                        for
                        <?= $type ?>
                    </h4>
                </div>
            </div>
            <? if ($details['labelCategory'] == 'Roll Labels') { ?>
                <div class="col-md-7 col-xs-12">
                    <!-- <div>
                        <button type="button" class="btn-block btn blueBg  f-14" data-toggle="modal" data-target=".bs-example-modal-sm">Edit Label Orientation</button>
                    </div> -->
                </div>
            <? } ?>
            <div class="clear"></div>
            <div class="col-md-12">
                <div class="col-md-6 col-xs-6 ">
                    <div class="clear10"></div>
                    <p><b>Code:</b></p>
                    <p><b>Qty:</b>
                        <?= $sheets ?>
                        <?= $type ?>
                    </p>
                    <p><b>No. of Designs:</b></p>
                    <p><b>Shape:</b></p>
                    <p><b>Label Size:</b></p>
                    <p><b>Material:</b></p>
                    <p><b>Colour: </b></p>
                    <p><b>Adhesive: </b></p>
                    <? if (isset($details['rollfinish']) and $details['rollfinish'] != '') { ?>
                        <p><b>Finish: </b></p>
                    <? } ?>
                    <? if (isset($details['digitalFininsh']) and $details['digitalFininsh'] != '') { ?>
                        <p><b>Finish: </b></p>
                    <? } ?>
                    <p><b>Digital Process: </b></p>

                    <?php
                    /*
                    if(isset($orientation) && $orientation != '')
                    {?>
                        <p class="roll_orientation_text"><?php echo $orientation;?></p>
                    <?php
                    }*/
                    ?>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="clear10"></div>
                    <p>
                        <?= $details['ManufactureID'] ?>
                    </p>
                    <p>
                        <?= $labels ?>
                        Labels</p>
                    <p>
                        <!-- <?= $designs ?> -->
                        <?= $details['design'] ?>
                        
                    </p>
                    <p>
                        <?= $details['Shape'] ?>
                    </p>
                    <p>
                        <?= $label_size ?>
                    </p>
                    <p>
                        <?= $details['ColourMaterial_upd'] ?>
                    </p>
                    <p>
                        <?= $details['LabelColor_upd'] ?>
                    </p>
                    <p>
                        <?= $details['Adhesive'] ?>
                    </p>
                    <? if (isset($details['rollfinish']) and $details['rollfinish'] != '') { ?>
                        <p>
                            <?= $details['rollfinish'] ?>
                        </p>
                    <? } ?>

                    <? if (isset($details['digitalFininsh']) and $details['digitalFininsh'] != '') { ?>
                        <p>
                            <?= $details['digitalFininsh'] ?>
                        </p>
                    <? } ?>

                    <p>
                        <?= $details['digitalprocess'] ?>
                    </p>

                    <?php
                    /*
                    if(isset($orientation) && $orientation != '')
                    {?>
                        <p class="roll_orientation_text_value"></p>
                    <?php
                    }
                    */
                    ?>

                    
                    
                </div>
            </div>
            <div class="Clear"></div>
            
            <div class="col-md-12 printed_total_pricing">
                <div class="price">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <p>Printed Labels</p>
                        <? if (isset($prices['additional_cost']) and $prices['additional_cost'] != '') { ?>
                            <p>Additional Roll Charges</p>
                        <? }
                        if ($details['labelCategory'] != 'Roll Labels') { ?>
                            <p>Additional Designs
                                <?= symbol . DesignPrice ?>
                                each<br/>
                                <small>(
                                    <?= $prices['artworks'] ?>
                                    <?= ($prices['artworks'] > 1) ? 'Designs' : 'Design' ?>
                                    Free )</small></p>
                        <? }
                        if (isset($prices['pressproof']) and $prices['pressproof'] > 0) { ?>
                            <p>Press Proof </p>
                        <? } ?>
                        <p class="printservicecharges_txt" style="display:none;">Design Service</p>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <p><b>
                                <?= symbol . number_format(($prices['plainprint']), 2, '.', '') ?>
                            </b></p>
                        <? if (isset($prices['additional_cost']) and $prices['additional_cost'] != '') { ?>
                            <p><b>
                                    <?= symbol . number_format($prices['additional_cost'], 2, '.', '') ?>
                                </b></p>
                        <? }
                        if ($details['labelCategory'] != 'Roll Labels') { ?>
                            <p><b>
                                    <?= symbol . number_format($prices['designprice'], 2, '.', '') ?>
                                </b></p>
                        <? }
                        if (isset($prices['pressproof']) and $prices['pressproof'] > 0) {
                            ?>
                            <p><b>
                                    <?= symbol . number_format(50, 2, '.', '') ?>
                                </b></p>
                        <? } ?>
                        <p class="printservicecharges_price" style="display:none;"><b>
                                <?= symbol ?>
                                0.00</b></p>
                    </div>
                </div>
            </div>


            <input type="hidden" value="<?= $prices['price'] ?>" id="summary_total_price"/>
            <input type="hidden" value="<?= $labels ?>" id="acutal_labels"/>
            <input type="hidden" value="<?= $sheets ?>" id="acutal_qty"/>
            

            <div class="col-md-12 clear">
                <div class="priceB row" style="clear:both;">
                    

                        <div class="col-md-8 m-t-5 col-sm-8 col-xs-8 printed_total_pricing" >
                            <p>Line Total ( <?= vatoption ?> VAT)</p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 printed_total_pricing">
                            <p><b>
                                    <?= symbol ?>
                                    <span class="summary_price">
                                        <?= number_format($prices['price'], 2, '.', '') ?>
                                    </span>
                                </b>
                            </p>
                        </div>

                    <div class="col-md-12 col-xs-12">
                        <!---------- Price Promise -------------->
                        <div class="price_promise_div_print row">
                            <div class="col-md-12 pull-right col-xs-12">
                                <h5><a data-toggle="tooltip-price-prmoise" data-placement="top" class="" title=""
                                       data-original-title="If within 7 days of buying this product from us, you find the same product cheaper at any other UK online label website, we will refund 100% of the difference."
                                       href="javascript:void(0);"> <img onerror='imgError(this);'
                                                                        src="<?= Assets ?>images/check-circle.png"
                                                                        class="circle-icon"/ alt="Lowest Price
                                        Guaranteed">Lowest Prices<br/>
                                        <span>Online Guaranteed</span><i class="fa fa-info-circle"></i> </a></h5>
                            </div>
                            <script>$('[data-toggle=tooltip-price-prmoise]').tooltip();</script>
                        </div>
                        <!---------- Price Promise end-------------->
                    </div>
                </div>
                <div class="col-md-12 hide">
                    <button class="btn btn-block orangeBg proceed_to_checkout">Select & Proceed to Checkout <i
                                class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>


        </div>
    </div>
</div>
