
<!-- Sheets Superior Quality Starts -->
<section class="alternate_option_section">
    <div class="row">
        <div class="bg-n-border-radius SpecialLabelContainer col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row alternative-sheet-header">
                ALTERNATIVE OPTION
            </div>
            <div class="row mt-15">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-product-image col-xs-2">
                            <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/sample-product-detail-image-sheet.jpg">
                        </div>
                        <div class="col-md-10 col-xs-10">
                            <p class="alternative-product-heading">

                                <span
                                        id="product_color"> <?php echo ($preferences['color_roll']) ? ($preferences['color_roll']) : ($preferences['color_a4']) ?></span> <span
                                        id="product_material"> </span><?php echo ($preferences['material_roll']) ? ($preferences['material_roll']) : ($preferences['material_a4']) ?> :</span>

                            </p>
                            <p class="alternative-product-details">A4 Sheet Labels
                                <br> <span class="product-details-description">Product Code: <span
                                            id="product_code"><?php echo ($preferences['categorycode_roll']) ? ($preferences['categorycode_roll']) : ($preferences['categorycode_a4']) ?></span>,
                                            Label Size (mm): <span id="label_size"><?php echo $label_size; ?> </span>,
                                <br>
                                    <span id="product_shape"><?php echo $preferences['shape']; ?> </span>,
                                            <span id="product_material_text"> <?php echo ($preferences['material_roll']) ? ($preferences['material_roll']) : ($preferences['material_a4']) ?></span>,
                                            <span id="product_color_text"><?php echo ($preferences['color_roll']) ? ($preferences['color_roll']) : ($preferences['color_a4']) ?> </span>

                                <br><span id="product_adhesive"><?php echo ($preferences['adhesive_roll']) ? ($preferences['adhesive_roll']) : ($preferences['adhesive_a4']) ?> </span> Adhesive.</p>








                            <div class="MaterialContentInlineListing">
                                <div class="alternative-li-style">
                                    <img onerror="imgError(this);" src="https://www.aalabels.com/theme/site/images/check-circle.png" class="TickSVG alternative-image-icon">
                                    <div class="MaterialContentProductDescriptionss">
                                        <p class="MaterialContentBottomBoldd">SUPERIOR QUALITY</p>
                                        <p class="MaterialContentBottomNormals">ELECTROSTATIC INK</p>
                                        <p class="MaterialContentBottomNormalsblack">PRINTED ON HP INDIGO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="padding-15 font-13x">
                        <div class="row">
                            <div class="col-md-7">Quantity</div>
                            <div class="col-md-5 text-right">
                                <?php
                                if (!empty($labels) && $labels >0){
                                    echo   $labels;
                                    $total_labels = $labels;
                                } else{
                                    $total_labels =  $sheetdetails['LabelsPerSheet']*$preferences['labels_a4'];
                                    echo $sheetdetails['LabelsPerSheet']*$preferences['labels_a4'];
                                }
                                ?> (Labels)

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">Print</div>
                            <div class="col-md-5 text-right">
                                <?php

                                //                        for sheet *2 to display half price promotion and in case of rolls its already multiplied in function result
                                $print_price = $premium_prices['printprice']*2;
                                $print_price = number_format(($print_price), 2, '.', '');
                                echo symbol.$print_price;


                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9"><strong>Half Price Promotion</strong></div>
                            <div class="col-md-3 text-right"><strong>-
                                    <?php
                                    echo symbol.$premium_prices['printprice'];
                                    ?>
                                </strong></div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 total-font-size">Total (<?=vatoption;?> VAT)</div>
                            <div class="col-md-5 text-right total-font-price">
                                <?php
                                echo symbol.$premium_prices['printprice'];
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <?php
                                $perlabel = $premium_prices['printprice']/$total_labels;
                                //                        $perlabel = round($perlabel, 4);
                                $perlabel = number_format($perlabel, 2, '.', '');
                                ?>

                                (<?php echo symbol.$perlabel. ' per label'; ?>)


                                <!--                                (0.083 pence per label)-->
                            </div>
                        </div>
                        <div>
                            <a href="javascript:;" class="alternative-cart-cta alternate_option_proceed_click">Proceed with printed labels on Sheet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sheets Superior Quality End -->