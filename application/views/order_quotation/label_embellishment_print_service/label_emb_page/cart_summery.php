<!--  Cart Summary Starts -->
<?php

if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
        
    $attachments_count = count($IA_data);
    if( $attachments_count > 0 ) {
        $artwork_now_or_follow = "upload_artwork_now";
    } else {
        $artwork_now_or_follow = "artwork_to_follow";
    }


    $cost_effective = "";
    $custom_roll_and_label = "";

    $cost_effective_custom_rolls = "";

    if( $cart_and_product_data['custom_roll_and_label'] == "cost_effective" ) {
        $cost_effective = true;
        $cost_effective_custom_rolls = "cost_effective";
    } else if( $cart_and_product_data['custom_roll_and_label'] == "custom_roll_and_label" ) {
        $custom_roll_and_label = true;
        $cost_effective_custom_rolls = "custom_roll_and_label";
    } else {
        $cost_effective_custom_rolls = "cost_effective";
    }

}

$assets = Assets;?>
<div   id="cart_summery_loader" class="white-screen"
       style="position: absolute;top: 7%;right: 0;width: 25%;z-index: 999;height: 49%;display: none;background: #FFF;opacity: 0.8;">
    <div class="text-center"
         style="    margin: 68% auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 60%;border: solid 1px #CCC;">
        <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
             style="width:139px; height:29px; " alt="AA Labels Loader">
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
            <div class="row padding-20">
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
                                    <?php }  ?>

                                    <?php if (isset($product_details) and $product_details != '' && $product_type == "roll") {
                                        $image = explode('.', $product_details->CategoryImage);
                                        $img_chgr = $image[0];
                                        $imagename = $image[0];
                                        $imagecode = substr($product_details->ManufactureID, 0, -1);



                                        if (isset($preferences['coresize']) && !empty($preferences['coresize'] && !empty($preferences['wound_roll']))) {
                                            $core = substr($preferences['coresize'], -1, 1);
                                            $wound = strtolower($preferences['wound_roll']);
                                            $img_src = $assets . "images/categoryimages/RollLabels/" . $wound . "/" . $imagecode . $core . ".jpg";

                                        } else {
                                            $img_src = $assets . "images/categoryimages/RollLabels/outside/" . $imagecode . "4.jpg";
                                        }
                                        ?>


                                        <input type="hidden" id="product_code"
                                               value="<?= $imagecode; ?>">
                                        <?php
                                        //$img_src = Assets."images/categoryimages/RollLabels/outside/".$product_details['ManufactureID'].".jpg";

                                        if (!getimagesize($img_src)) {
                                            $img_src = $assets . "images/categoryimages/RollLabels/" . $imagename . ".jpg";
                                        }
                                        if (!getimagesize($img_src)) {
                                            $img_src = $assets . "images/categoryimages/roll_desc/" . $imagename . 'R4' . ".jpg";
                                        }
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
                                                        $SID = $this->shopping_model->sessionid();
                                                        $cartid = $this->home_model->get_db_column('temporaryshoppingbasket', 'id', 'SessionID', $SID);
                                                        if(!$cartid){
                                                            $SID = $this->shopping_model->sessionid() . '-PRJB';
                                                            $cartid = $this->home_model->get_db_column('temporaryshoppingbasket', 'id', 'SessionID', $SID);
                                                        }
                                                    }

                                                    $acutal_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
                                                    $acutal_sheets = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
                                                }



                                                $total_labels = 0;
                                                $total_emb_and_plate_cost =  $prices['label_finish'] + $total_emb_plate_price;

                                                ?>
                                                <input type="hidden" id="cartid" value="<?= $cartid ?>"/>
                                                <!--    <input type="hidden" id="cartproductid" value="--><?//= $rolldetails['ProductID'] ?><!--"/>-->
                                                <input type="hidden" id="cartunitqty" value="<?= $unitqty ?>"/>
                                                <!--    <div class="panel panel-default">-->
                                                <!--        <div id="headingOne" class="panel-title_blue">-->
                                                <!--            <div>Cart Summary</div>-->
                                                <?php $total_ex_vat = 0;
                                                $total_finish_emb_cost_and_plate_price = 0;
                                                $total_finish_emb_cost_and_plate_price= $total_emb_plate_price;
                                                $total_finish_emb_cost_and_plate_price += $prices['label_finish'];
                                                //             $total_ex_vat += $total_finish_emb_cost_and_plate_price;
                                                ?>
                                                <!--        </div>-->



                                                <div class="font-13x" style="margin-top: 85px;">
                                                    <div class="row">
                                                        <div class="col-md-7">Quantity</div>
                                                        <div class="col-md-5 text-right" >  <?php
                                                            if (!empty($labels) && $labels >0){
                                                                echo   $labels;
                                                                $total_labels = $labels;
                                                            } else{
                                                                $total_labels =  $sheetdetails['LabelsPerSheet']*$preferences['labels_a4'];
                                                                echo $sheetdetails['LabelsPerSheet']*$preferences['labels_a4'];
                                                            }
                                                            ?> (Labels)</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-7">Plain Labels Price </div>
                                                        <div class="col-md-5 text-right">

                                                            <?php
                                                            if ($producttype == 'sheet'){
                                                                echo symbol.$prices['plainprice'];
                                                                $total_ex_vat+= $prices['plainprice'];
                                                            }else{
                                                                echo symbol.$prices['plainlabelsprice'];
                                                                $total_ex_vat+= $prices['plainlabelsprice'];
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-7">Print Labels (<?php echo $labeltype; ?>)</div>
                                                        <div class="col-md-5 text-right">
                                                            <?php
                                                            if ($producttype == 'sheet'){
//                        for sheet *2 to display half price promotion and in case of rolls its already multiplied in function result
                                                                $print_price = $prices['printprice']*2;
                                                                $print_price = number_format(($print_price), 2, '.', '');
                                                                echo symbol.$print_price;

                                                            }else{
                                                                echo symbol.$prices['onlyprintprice'];
                                                            }
                                                            ?>

                                                        </div>
                                                        <div class="row">

                                                            <div class="col-md-9"><strong>Half Print Price Promotion</strong></div>
                                                            <div class="col-md-3 text-right"><strong>-

                                                                    <?php
                                                                    if ($producttype == 'sheet'){
                                                                        echo symbol.$prices['printprice'];
                                                                        $total_ex_vat+= $prices['printprice'];

                                                                    }else{
                                                                        echo symbol.$prices['halfprintprice'];
                                                                        $total_ex_vat+= $prices['halfprintprice'];

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
                <?php if (isset($prices['label_finish_individual_cost_array']) && !empty($prices['label_finish_individual_cost_array'])){ ?>
                    <div class="panel panel-default" style="margin-top: 10px;">

                        <div class="padding-10-px font-13x" >

                            <div class="row">

                                <?php
                                foreach ($prices['label_finish_individual_cost_array'] as $label_finish_individual_cost_array) { ?>


                                    <div class="col-md-9"><?php echo  ucwords(str_replace('_',' ' ,$label_finish_individual_cost_array->finish_parsed_title) ); ?></div>
                                    <?php


                                    $label_finish_individual_cost= $label_finish_individual_cost_array->finish_price+$label_finish_individual_cost_array->plate_cost;
                                    $label_finish_individual_cost = number_format($label_finish_individual_cost, 2, '.', '');
                                    $total_ex_vat +=$label_finish_individual_cost;

                                    ?>
                                    <div class="col-md-3 text-right"><span id=" "> <?php echo symbol.$label_finish_individual_cost; ?> </span></div>
                                <?php    }
                                ?>
                            </div>

                        </div>

                    </div>
                <?php } ?>


                <!--   Label finish and embellishment cost and plae price section end -->


                <!--already purchased plate section start-->
                <?php if (isset($minus_plate_cost) && !empty($minus_plate_cost)){ ?>
                    <div class="panel panel-default" style="margin-top: -10px;">

                        <div class="padding-10-px font-13x" >

                            <!--                Show each emb & finish cost saperately-->


                            <!--Block that shows already purchased plate prices if any start-->
                            <div class="row">

                                <?php
                                foreach ($minus_plate_cost as $minus_plate_cost_single) { ?>

                                    <div class="col-md-9"><?php echo  ucwords(str_replace('_',' ' ,$minus_plate_cost_single->parsed_title) ); ?>(Existing Plate)</div>
                                    <?php



                                    $label_finish_individual_cost_minus = number_format($minus_plate_cost_single->plate_cost, 2, '.', '');
//                        update total emb and plate price and substract already purchased price in it if any
                                    $total_emb_and_plate_cost -= $minus_plate_cost_single->plate_cost;
                                    $total_ex_vat -= $minus_plate_cost_single->plate_cost;


                                    ?>
                                    <div class="col-md-3 text-right"><span id=" "> <?php echo symbol. '-'.$label_finish_individual_cost_minus; ?> </span></div>
                                <?php    }
                                ?>
                            </div>

                        </div>

                    </div>
                <?php } ?>
                <!--already purchased plate section end-->


                <!--    Extra roll charges in case of rolls and extra design charges in case of sheet start -->
                <?php
                if (($producttype == 'sheet' && $prices['designprice'] > 0) || $producttype != 'sheet' && $prices['additional_cost'] > 0 ){ ?>
                    <div class="panel panel-default" style="margin-top: 125px;">

                        <div class="padding-10-px font-13x" >

                            <div class="row">
                                <?php
                                if ($producttype == 'sheet' && $prices['designprice'] > 0 ){ ?>
                                    <div class="row">
                                        <div class="col-md-7">Additional Design Price </div>
                                        <div class="col-md-5 text-right">

                                            <?php
                                            if ($producttype == 'sheet'){
                                                echo symbol.$prices['designprice'];
                                                $total_ex_vat+= $prices['designprice'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($producttype != 'sheet' && $prices['additional_cost'] > 0 ){ ?>
                                    <div class="row">
                                        <div class="col-md-7">Additional Roll Charges </div>
                                        <div class="col-md-5 text-right">

                                            <?php
                                            if ($producttype != 'sheet'){
                                                echo symbol.$prices['additional_cost'];
                                                $total_ex_vat+= $prices['additional_cost'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>

                    </div>
                <?php } ?>
                <!--    Extra roll charges in case of rolls and extra design charges in case of sheet end -->



                <!--Total price and price per label cost section start-->
                <div class="row">
                    <div class="col-md-7 total-font-size">Total (<?=vatoption;?> VAT)</div>
                    <?php $total_ex_vat+= $prices['presproof_charges'];?>
                    <div class="col-md-5 text-right total-font-price " id="cart_summery_total_price"><?php
                        $total_ex_vat = number_format($total_ex_vat, 2, '.', '');

                        echo symbol. $total_ex_vat; ?></div>
                </div>
                <input type="hidden" value="<?= $total_ex_vat ?>" id="summary_total_price"/>
                <input type="hidden" value="<?= $acutal_labels ?>" id="acutal_labels"/>
                <input type="hidden" value="<?= $acutal_sheets ?>" id="acutal_qty"/>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <?php
                        if ($producttype == 'sheet'){

                            $perlabel = $total_ex_vat/$total_labels;
//                        $perlabel = round($perlabel, 4);
                            $perlabel = number_format($perlabel, 2, '.', '');

//                        $perlabel = explode(',',$prices['labelprice']); ?>


                            <!--                    (--><?php //echo $perlabel[1]; ?><!--)-->
                            (<?php echo symbol.$perlabel. ' per label'; ?>)

                        <?php }else{
                            $perlabel = $total_ex_vat/$total_labels;
                            $perlabel = round($perlabel, 4);

//                        $perlabel = explode(',',$prices['labelprice']); ?>

                            <!--                        (--><?php //echo $perlabel[1]; ?><!--)-->
                            (<?php echo symbol.$perlabel. ' per label'; ?>)
                        <?php  }
                        ?>

                    </div>
                </div>
                <!--Total price and price per label cost section end-->
                <!--Proceed button CTA and Calculate Price CTA start-->
                <div>
                    <a href="javascript:;" class="label-embellishement-cta " id="label-embellishement-cta" onclick="proceedToCart(this)">Proceed with printed labels on <span  id="brandName"><?php echo  ucfirst($producttype);?> </span></a>
                    <a href="javascript:;" class="label-embellishement-cta " id="label-embellishement-calculate-price-cta" style="display: none ;" onclick="reCaculate(this)">Calculate Price <i class='fa fa-calculator'></i></a>

                </div>
                <!--Proceed button CTA and Calculate Price CTA end-->

                <!--  Cart Summary Ends -->






