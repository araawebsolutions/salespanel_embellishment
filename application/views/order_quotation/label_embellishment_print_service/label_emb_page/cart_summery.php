<!--  Cart Summary Starts -->

<div   id="cart_summery_loader" class="white-screen"
       style="position: absolute;top: 38%;right: 0;width: 25%;z-index: 999;height: 49%;display: none;background: #FFF;opacity: 0.8;">
    <div class="text-center"
         style="    margin: 68% auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 60%;border: solid 1px #CCC;">
        <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
             style="width:139px; height:29px; " alt="AA Labels Loader">
    </div>
</div>
<!--<div class="col-md-3 col-xs-6">-->
<div class="">
    <?php //echo"<pre>";print_r($details);
    //
    $SID = $this->shopping_model->sessionid() . '-PRJB';
    $cartid = $this->home_model->get_db_column('temporaryshoppingbasket', 'id', 'SessionID', $SID);

    $acutal_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
    $acutal_sheets = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
    $total_labels = 0;
    $total_emb_and_plate_cost =  $prices['label_finish'] + $total_emb_plate_price;

    //    print_r($cartid);echo"<br>";
    //    print_r($cartid);
    // ?>



    <input type="hidden" id="cartid" value="<?= $cartid ?>"/>
    <!--    <input type="hidden" id="cartproductid" value="--><?//= $rolldetails['ProductID'] ?><!--"/>-->
    <input type="hidden" id="cartunitqty" value="<?= $unitqty ?>"/>
    <div class="panel panel-default">
        <div id="headingOne" class="panel-title_blue">
            <div>Cart Summary</div>
            <?php $total_ex_vat = 0;
            $total_finish_emb_cost_and_plate_price = 0;
            $total_finish_emb_cost_and_plate_price= $total_emb_plate_price;
            $total_finish_emb_cost_and_plate_price += $prices['label_finish'];

//            $total_ex_vat += $total_finish_emb_cost_and_plate_price;
            ?>
        </div>
        <div class="padding-15 font-13x">
            <div class="row">
                <div class="col-md-7">Quantity</div>
                <div class="col-md-5 text-right" ><span id="labels_qty"></span> <?php
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

                <!--                Show each emb & finish cost saperately-->

                <div class="row">

                    <?php
                    foreach ($prices['label_finish_individual_cost_array'] as $label_finish_individual_cost_array) { ?>
                        <!--                     --><?php //echo"<pre>";print_r($label_finish_individual_cost_array)?>

                        <!--                        echo ucwords("hello|world", "|");-->


                        <div class="col-md-9"><?php echo  ucwords(str_replace('_',' ' ,$label_finish_individual_cost_array->finish_parsed_title) ); ?></div>
                        <?php


                        $label_finish_individual_cost= $label_finish_individual_cost_array->finish_price+$label_finish_individual_cost_array->plate_cost;
                        $label_finish_individual_cost = number_format($label_finish_individual_cost, 2, '.', '');
                        $total_ex_vat +=$label_finish_individual_cost;

                        ?>
                        <!--                    <div class="col-md-3 text-right"><span id="embellishment_plate_total_cost"> --><?php //echo symbol.$total_emb_and_plate_cost; ?><!-- </span></div>-->
                        <div class="col-md-3 text-right"><span id=" "> <?php echo symbol.$label_finish_individual_cost; ?> </span></div>
                    <?php    }
                    ?>
                </div>
                <!--Block that shows already purchased plate prices if any start-->
                <div class="row">

                    <?php
                    foreach ($minus_plate_cost as $minus_plate_cost_single) { ?>
                        <!--                     --><?php //echo"<pre>";print_r($label_finish_individual_cost_array)?>

                        <!--                        echo ucwords("hello|world", "|");-->


                        <div class="col-md-9"><?php echo  ucwords(str_replace('_',' ' ,$minus_plate_cost_single->parsed_title) ); ?>(Existing Plate)</div>
                        <?php



                        $label_finish_individual_cost_minus = number_format($minus_plate_cost_single->plate_cost, 2, '.', '');
//                        update total emb and plate price and substract already purchased price in it if any
                        $total_emb_and_plate_cost -= $minus_plate_cost_single->plate_cost;
                        $total_ex_vat -= $minus_plate_cost_single->plate_cost;


                        ?>
                        <!--                    <div class="col-md-3 text-right"><span id="embellishment_plate_total_cost"> --><?php //echo symbol.$total_emb_and_plate_cost; ?><!-- </span></div>-->
                        <div class="col-md-3 text-right"><span id=" "> <?php echo symbol. '-'.$label_finish_individual_cost_minus; ?> </span></div>
                    <?php    }
                    ?>
                </div>
                <!--Block that shows already purchased plate prices if any end-->

                <!--                Show each emb & finish cost saperately-->

                <!-- below code is seperate display for both plate cost and emb and finishes prices-->
                <!--            <div class="row">-->
                <!--                <div class="col-md-9"><strong>Half Print Price Promotion test</strong></div>-->
                <!--                <div class="col-md-12 text-right"><strong>-£--><?php //echo "<pre>"; print_r($details['digitalprocess']); ?><!--</strong></div>-->
                <!--            </div>-->
                <!--            <div class="row">-->
                <!--                <div class="col-md-9">Finish & Embellishment Total Cost</div>-->
                <!--                <div class="col-md-3 text-right"><span id="embellishment_plate_total"> --><?php //echo symbol.$prices['label_finish']; ?><!-- </span></div>-->
                <!--            </div>-->
                <!---->
                <!--            <div class="row">-->
                <!--                <div class="col-md-9">Embellishment Plate Total Cost</div>-->
                <!--                <div class="col-md-3 text-right"><span id="embellishment_plate_total_cost"> --><?php //echo symbol.$total_emb_plate_price; ?><!-- </span></div>-->
                <!--            </div>-->
                <?php /*
                <div class="row">
                    <div class="col-md-9">Embellishment Total Cost</div>
                    <?php
                    $total_emb_and_plate_cost = number_format($total_emb_and_plate_cost, 2, '.', '');

                    ?>
<!--                    <div class="col-md-3 text-right"><span id="embellishment_plate_total_cost"> --><?php //echo symbol.$total_emb_and_plate_cost; ?><!-- </span></div>-->
                    <div class="col-md-3 text-right"><span id=" "> <?php echo symbol.$total_emb_and_plate_cost; ?> </span></div>
                </div>
 */ ?>
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
            </div>

        </div>
        <div>
            <a href="javascript:;" class="label-embellishement-cta " id="label-embellishement-cta" onclick="proceedToCart(this)">Proceed with printed labels on <span  id="brandName"><?php echo  ucfirst($producttype);?> </span></a>
            <a href="javascript:;" class="label-embellishement-cta " id="label-embellishement-calculate-price-cta" style="display: none ;" onclick="reCaculate(this)">Calculate Price <i class='fa fa-calculator'></i></a>

        </div>

    </div>
    <?php if ($producttype == 'roll'){ ?>
        <div class="margin-top-20">
            <input type="checkbox"

                <?php if($prices['presproof_charges'] >0){ echo "checked"; } ?> id="press_proof" />
            <label for="press_proof">
                <span class="labels-embelishemnt-pressproof">Do you require a hard copy pre-production press proof? (Cost £50.00) <br></span>
                <span class="labels-embelishemnt-pressproof-detail">You will always automatically receive an electronic free of charge soft proof for approval before your labels
                                            are produced.</span>
            </label>
        </div>
    <?php } ?>
    <!--  Cart Summary Starts -->
