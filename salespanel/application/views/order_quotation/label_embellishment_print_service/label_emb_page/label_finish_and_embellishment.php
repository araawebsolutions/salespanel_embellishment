<?php //print_r($label_embellishments);die; ?>
<style>
    .sweet-alert {
        left: 45% !important;
        box-shadow: 0 0 20px;
    }
</style>

<!-- Label Finishes & Embellishments & Cart Summary Starts -->

<!--<div class="col-md-9 col-xs-12">-->
<div class="">
                    <div class="panel panel-default margin-bottom">
                        <div id="headingOne" class="panel-title_blue">
                            <div>Label Finishes & Embellishments</div>
                        </div>
                        <div class="tabs padding-20">
                            <nav role='navigation' class="transformer-tabs">
                                <ul>
                                    <?php
                                    $count = 1;
                                    foreach ($label_embellishments as $label_emb){

                                            ?>
                                        <li><a href="#tab-<?= $count ?>" data-swal_msg=" <?php echo $count;?>"
                                               class="tab-swal <?php if($count == 1){ echo "active";  }  ?>"><?= $label_emb['title']; ?></a></li>


<!--                                    <li><a href="#tab-1" class="active">Laminations & Varnishes</a></li>-->
<!--                                    <li><a href="#tab-2">Hot Foil</a></li>-->
<!--                                    <li><a href="#tab-3">Embossing & Debossing</a></li>-->
<!--                                    <li><a href="#tab-4">Silk Screen Print</a></li>-->
<!--                                    <li><a href="#tab-5">Sequential & Variable Data</a></li>-->
                                <?php    $count++;
                                    }
                                    ?>
                                </ul>
                            </nav>
                            <!-- Varnish / Lamination Section Starts -->

                            <?php

                            $count = 1;
                            foreach ($label_embellishments as $label_emb){ ?>
                           <div id="tab-<?=$count;?>" class="<?php if($count == 1){ echo "active";  }  ?>">
                               <div class="row rowflex">
                                   <?php   foreach ($label_emb['child_options'] as $child_options){ ?>

                                       <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets.$child_options['img'] ?>">
                                                </span>
                                           <label class="containerr left-no-margin"> <?= $child_options['title'] ?>
                                               <?   if ($label_emb['parsed_title'] == 'laminations_and_varnishes') {
                                                   ?>
                                                   <input type="checkbox" data-combination_type="checkbox"  data-embellishment_id = "<?= $child_options['id'] ?>" data-embellishment_selection_id = "<?= $child_options['id'] ?>" id="uncheck<?= $child_options['id'] ?>" class="emb_option " data-embellishment_parsed_title_child="<?= $child_options['parsed_title']  ?>"  data-embellishment_parsed_title="<?= $child_options['parsed_title'] ?>"  data-embellishment_selected_title="<?= $child_options['title'] ?>"  name="label_embellishment['<?= $label_emb['parsed_title'] ?>'][]">
                                                   <?php
                                               }else{ ?>
                                                   <input type="radio" data-combination_type="radio" data-embellishment_id = "<?= $label_emb['id'] ?>" data-embellishment_selection_id = "<?= $child_options['id'] ?>" id="uncheck<?= $child_options['id'] ?>" class="emb_option " data-embellishment_parsed_title_child="<?= $child_options['parsed_title']  ?>" data-embellishment_parsed_title="<?= $label_emb['parsed_title']  ?>"  data-embellishment_selected_title="<?= $child_options['title'] ?>"  name="label_embellishment['<?= $label_emb['parsed_title'] ?>'][]">

                                               <?php     }
                                               ?>
                                               <span class="checkmark"></span>

                                           </label>
                                       </div>

                                       <?php

                                   } ?>


                                </div>

                               <?   if ($label_emb['parsed_title'] == 'sequential_and_variable_data') {
                                   ?>

                                   <div class="labels-form add_line">
                                       <label class="select col-sm-5 input">
                                           <input type="text" id="label_embellishment['<?= $label_emb['parsed_title'] ?>']['sequential'][]['start']" placeholder="Enter The Starting Data">

                                       </label>
                                       <label class="select col-sm-5 input">
                                           <input type="text" id="label_embellishment['<?= $label_emb['parsed_title'] ?>']['sequential'][]['end']" placeholder="Enter The Ending Data">

                                       </label>
                                   </div>

                                   <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                                       <button class="btn btn-success add_another_line"> <i class="fa fa-plus"></i> Add another Line</button>
                                   </div>

                                   <?php
                               }
                               ?>

                                <br><div class="row">
                                    <div class="col-md-12">
                                        <?= $label_emb['description'] ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Varnish / Lamination Section End -->

                           <?php
                                $count++;
                            } ?>



                           <? /* <div id="tab-2">
                                <div class="row rowflex">
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/antique-gold.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Antique Gold

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/bight-silver.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Bright Silver

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/classic-bronze.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Classic Bronze


                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/classic-copper.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Classic Copper

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/gold.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Gold

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/rich-gold.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Rich Gold

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/hot_foil/rose-gold.jpg">
                                                </span>
                                        <label class="containerr left-no-margin">Rose Gold

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                 </div>
                                <br> <div class="row">
                                    <div class="col-md-12">
                                <p>Even though very good metallic print can be produced using metallic label substrates, foils have additional applications with heavier and non-metallic label materials. In addition to great metallic finishes, foil also has a tactile element, micro-embossing the label surface.</p>
                                <p>Foils work well on a range of paper, non-paper and Polymer labels, both on their own and with other embellishing techniques, particularly embossing. Choose from our standard range of popular finishes and holographic option, or discuss your requirements with a member of our customer care team who will be happy to discuss your label ideas and provide assistance regarding what is possible, practical and cost-effective for your labels.</p>

                            </div>
                            </div>
                            </div>
                            <div id="tab-3">

                                <div class="row rowflex">
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/emboss_deboss/emboss.png">
                                                </span>
                                        <label class="containerr left-no-margin">Emboss

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/emboss_deboss/deboss.png">
                                                </span>
                                        <label class="containerr left-no-margin">Deboss

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                                <br><div class="row">
                                    <div class="col-md-12">
                                        <p>The embossing and debossing of labels is a very attractive tactile embellishment feature and can significantly enhance a labels attractiveness and product handling experience.</p>
                                        <p>This label embellishment option enhances and changes a labels appearance significantly, whether you use it with our without print and/or in combination with other options i.e. foil and screen.</p>
                                        <p>There are various embossed and debossed options to choose from and our customer care team can help you with material selection to achieve the best results for your label options. If you are unfamiliar with this label feature order a label sample to get a better understanding of the effect.</p>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-4">
                                <div class="row rowflex">
                                     <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/silk_screen/silk-screen.png">
                                                </span>
                                        <label class="containerr left-no-margin">Silk Screen Print

                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                               <br> <div class="row">
                                    <div class="col-md-12">
                                        <p>Screen-printed labels are recognisable by their thick, raised layer of ink. This heavy coat weight of ink is a perfect embellishment for signatures, text and line-drawn illustrations. The speciality inks used are very durable and UV resistant and also produce some interesting effects that are not possible with other printing methods. Also used for creating cost-effective thinner spot-colours.</p>
                                        <p>The heavier layer of ink used are very useful for cost-effectively creating tactile effects, such as Braille on labels and this printing method also creates abrasion resistant image and text with excellent resistance to UV fading from sunlight. Also making silk-screen printed labels a good choice for industrial, commercial and exterior locations.</p>
                                    </div>
                                </div>

                            </div>
                            <div id="tab-5" class="sequential_scroll">

                                <div class="row rowflex">
                                    <div class="col-1-5">
                                                <span>
                                                    <img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/new-printed-labels/variable_data/variable-data.png">
                                                </span>
                                        <label class="containerr left-no-margin">Sequential / Variable Data

                                            <input type="radio"  name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="labels-form add_line">
                                    <label class="select col-sm-5 input">
                                        <input type="text" id="label_coresize" placeholder="Enter The Starting Data"  >

                                          </label>
                                    <label class="select col-sm-5 input">
                                        <input type="text" id="label_coresize" placeholder="Enter The Ending Data" >

                                           </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                                    <button class="btn btn-success add_another_line"> <i class="fa fa-plus"></i> Add another Line</button>
                                </div>

                                <br> <div class="row">
                                     <div class="col-md-12">
                                         <br> <p>Sequential Data Printing, refers to the production of barcodes and individual numbers in an ascending or descending order on labels. As traceability initiatives become increasingly used in all industries, we are seeing greater use of sequential data, for asset protection and item tracking. Sequential numbers on your labels mean that they will be printed and arranged using a numerical sequence, starting with the first number that you provide. For example, if you order sequentially-numbered labels with a starting number of 1001, you would receive labels with the numbers 1001, 1002, 1003, etc. You can also use a prefix to create a set of numbers for a department, or for assets purchased in a year. An example would be 2020-1001 (the “2020” being the year prefix).&nbsp;</p>
                                        <p>Variable Data Printing&nbsp;(VDP), sometimes called Variable Information Printing (VIP), is a printing method which allows the printed content to change within a single press run. In other words, each impression can be printed differently from one piece to the next without having to stop or slow down the press.</p>
                                        <p>Variable Data Printing is produced using digital-printing equipment. An electronic database is created which contains the variable data used to personalize or alter certain elements of each printed label. Special software extracts the variable data and merges it with a layout template to create the unique output files, which are then printed on a digital press. Just about any design element can be created as a variable, from text and headlines to photos and colours.</p>
                                    </div>
                                </div>

                            </div>



                        </div>
                        <div class="row padding-20">
                            <a href="javascript:void(0);" class="col-md-3 float-left blueanchor-tag prev_tab">
                                <i class="fa fa-angle-left prev_tab"></i> Previous</a>
                            <div class="col-xs-6"></div>
                            <a href="javascript:void(0);" class="col-md-3 float-right text-right blueanchor-tag next_tab">
                                Next <i class="fa fa-angle-right"></i></a>
                        </div> */ ?>
                        </div>
                            <div class="row padding-20">
                                <a href="javascript:void(0);" class="col-md-3 float-left blueanchor-tag prev_tab">
                                    <i class="fa fa-angle-left prev_tab"></i> Previous</a>
                                <div class="col-xs-6"></div>
                                <a href="javascript:void(0);" class="col-md-3 float-right text-right blueanchor-tag next_tab">
                                    Next <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>


    <?php

    //     echo"<pre>";print_r($details);


    include('already_purchased_plates.php') ?>

    <?php include('artwork_upload_section.php') ?>


</div>
<!-- Label Finishes & Embellishments & Cart Summary End -->