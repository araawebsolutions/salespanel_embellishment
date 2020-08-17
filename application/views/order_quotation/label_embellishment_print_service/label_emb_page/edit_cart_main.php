<link rel='stylesheet' href='<?= Assets ?>css/label_embellishment.css'>

<link rel="stylesheet" href="<?= Assets_path ?>css/dropzone.css">
<link rel='stylesheet' href='<?= Assets ?>css/in_house_design.css'>
<script src="<?= Assets ?>labelfinder/js/jquery-ui.js"></script>
<script src="<?= Assets_path ?>js/dropzone.js"></script>
<script src="<?= Assets_path ?>js/jquery.validate.js"></script>

<style>

    .checkmark {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        height: 12px !important;
        width: 12px !important;
        border-radius: unset !important;
        background-color: #fff !important;
    }

    /*.modal-body{*/
    /*    height: auto !important;*/
    /*}*/
    .sweet-alert {
        left: 35% !important;
        box-shadow: 0 0 20px;
    }

    .tooltip.left .tooltip-arrow {
        border-left-color: #FEF7D8 !important;
    }

    .tooltip.right .tooltip-arrow {
        border-right-color: #FEF7D8 !important;
    }

    .tooltip.top .tooltip-arrow {
        border-top-color: #FEF7D8 !important;
    }

    .tooltip.bottom .tooltip-arrow {
        border-bottom-color: #FEF7D8 !important;
    }

    .tooltip-inner {
        background-color: #FEF7D8;
        border-radius: 4px;
        color: #454545;
        max-width: 381px;
        padding: 8px 15px;
        text-align: justify;
        text-decoration: none;
        font-style: italic;
    }

    .tooltip.in {
        opacity: 1;
    }


    .labels-form .tooltip {
        font-size: 13px !important;
        width: 290px;
    }

    .dm-row .dm-box .thumbnail {
        display: inline-block !important;
    }

    .dm-row .dm-box .thumbnail .dm-selector .dropdown-menu a img {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #e5e5e5;
        border-radius: 4px;
        box-shadow: 0px 6px 6px rgba(0, 0, 0, 0.176);
        display: none;
        padding: 5px;
        position: absolute;
        left: -605px;
        top: -25px;
        width: 119px !important;
    }

    .dm-row .dm-box .thumbnail .dm-selector .dropdown-menu .insideorientation {
        display: none;
    }

    .labels-form .tooltip {
        font-size: 13px !important;
        width: 290px;
    }

    .dm-row .dm-box .thumbnail .dm-selector .btn {
        font-size: 13px;
    }

    .sequential_scroll {
        max-height: 340px;
        overflow-y: scroll;
    }




    /********* LABEL EMBELLISHMENT SALESPANEL STYLING START *********/
    .f12 {
        font-size: 12px;
        width: 210px;
    }
     .btn-block {
         display: block;
         width: 100%;
     }

     .btn {
         display: inline-block;
         margin-bottom: 0;
         font-weight: 400;
         text-align: center;
         vertical-align: middle;
         -ms-touch-action: manipulation;
         touch-action: manipulation;
         cursor: pointer;
         border: 1px solid transparent;
         white-space: nowrap;
         padding: 6px 12px;
         font-size: 14px;
         line-height: 1.42857143;
         border-radius: 4px;
         -webkit-user-select: none;
         -moz-user-select: none;
         -ms-user-select: none;
         user-select: none;
     }
    .blue2 {
        border: #17b1e3 solid 1px!important;
        background-color: transparent!important;
        color: #17b1e3!important;
    }
    .blue2:hover {
        border: #17b1e3 solid 1px !important;
        background-color: #17b1e3 !important;
        color: #fff !important;
    }

     .btn {
         box-shadow: none;
         padding: 8px 9px!important;
     }

     a {
         background-color: transparent;
         -webkit-text-decoration-skip: objects;
     }

     a {
         color: #337ab7;
         text-decoration: none;
     }
    .padding-20 {
        padding: 20px;
    }

    .panel-default {
        border-color: #ececec !important;
    }

     .margin-bottom {
         margin-bottom: 0px !important;
     }

     .panel-default {
         border-color: #ddd;
     }

     .panel {
         margin-bottom: 20px;
         background-color: #fff;
         border: 1px solid transparent;
         border-radius: 4px;
         background: #FFF;
         /* -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05); */
         /* box-shadow: 0 1px 1px rgba(0,0,0,.05); */
     }

    .padding-15 {
        padding: 15px !important;
    }
    .labels-form .button, .labels-form .checkbox, .labels-form .input, .labels-form .radio, .labels-form .select, .labels-form .textarea, .labels-form .toggle {
        display: block;
        position: relative;
        font-weight: 400!important;
    }
    .labels-form label {
        margin-bottom: 15px;
    }

    .labels-form * {
        margin: 0;
        padding: 0;
    }

    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
    }






    /*.modal-dialog {
        width: 400px;
    }
    .modal-content {
        width: 400px;
    }*/

    /*@media (min-width: 768px) {
        .modal-content {
            margin-left: -35px;
        }
        .modal-dialog {
            width: 400px;
        }
        .modal-sm {
            width: 300px;
        }
    }*/


    .checkmark {
        padding: 5px 0;
    }



    /********* LABEL EMBELLISHMENT SALESPANEL STYLING ENDS *********/


</style>

<?php $assets = 'https://www.aalabels.com/theme/site/'; ?>
<div id="full_page_loader" class="white-screen"
     style=" position: absolute; top: 27%;  right: 0px;  width: 100%;  z-index: 999; height: 20%;  background: rgb(255, 255, 255);  opacity: 1;">
    <div class="text-center"
         style="margin: 5% 42% !important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 18%;border: solid 1px #CCC;">
        <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
             style="width:139px; height:29px; " alt="AA Labels Loader">
    </div>
</div>
<div class="container m-t-b-8 ">

    <div class="row">
        <div class="col-xs-12  col-sm-6 col-md-8">
            <ol class="breadcrumb  m0">
                <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i></a></li>
                <li class="active">Specialist Label Materials</li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 "></div>
    </div>
</div>
<div class="bgGray">
    <div class="container" style="margin-top: 100px">
        <!-- start -->
        <div class="row">
            <div class="bg-n-border-radius SpecialLabelContainer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-3">

                        <a class="btn-block btn blue2 step-back f12 gotoMaterialPage" data-value="1" role="button"> <i
                                    class="fa fa-chevron-left"></i> Back to Material & Quantity </a>
                    </div>
                </div>


                <div id="product_content">
                </div>
                <!--               --><?php //include('printing_process_and_product.php') ?>

                <!-- Label Finishes & Embellishments & Cart Summary Starts -->

                <section>
                    <div class="row">
                        <div id="finish_content" class="col-md-9 col-xs-12">
                        </div>
                        <!--                        --><?php //include('label_finish_and_embellishment.php') ?>

                        <div id="cart_summery" class="col-md-3 col-xs-6">
                        </div>

                        <!--                        --><?php //include('cart_summery.php') ?>


                    </div>
                    <div class="row padding-8">
                        <hr>
                        <div class="col-md-3 float-left no-padding">
                            <a href="#" class="label-embellishment-cta gotoMaterialPage"><i
                                        class="fa fa-chevron-left"></i> Back to
                                Material & Quantity</a>
                        </div>
                        <div class="col-md-3 no-padding" style="float: right">
                            <!--        <a href="javascript:;" class="label-embellishement-cta proceed_to_checkout" id="label-embellishement-cta" onclick="proceedToCart(this)">Proceed with printed labels on <span  id="brandName">-->
                            <?php //echo  ucfirst($producttype);?><!-- </span></a>-->
                            <a href="javascript:;" class="label-embellishement-cta proceed_to_checkout"
                               id="label-embellishement-cta">Proceed with printed labels on <span
                                        id="brandName"><?php echo ucfirst($producttype); ?> </span></a>
                            <a href="javascript:;" class="label-embellishement-cta "
                               id="label-embellishement-calculate-price-cta" style="display: none ;"
                               onclick="reCaculate(this)">Calculate Price <i class='fa fa-calculator'></i></a>

                        </div>
                    </div>
                </section>
                <!-- Label Finishes & Embellishments & Cart Summary End -->
            </div>
        </div>
        <!-- Sheets Superior Quality Starts -->
        <div id="alternate_option">
        </div>
        <!--        --><?php //include('alternate_option.php') ?>

        <!-- Sheets Superior Quality End -->
        <!-- end -->
        <div class="printed-lba-call ">
            <div class="container ">
                <div class="col-md-8 col-sm-8 col-lg-9">
                    <h2>INFORMATION &amp; ADVICE<br>
                        <small>We’re here to help</small></h2>
                    <p class="text-justify">If you need assistance or advice regarding our delivery and shipping
                        options. Please contact our customer care team via the live chat facility on the page, our
                        website contact form, telephone, or email and they will be happy to discuss your delivery
                        requirements.</p>
                </div>
                <div class="col-md-4 col-sm-4 col-lg-3"><img onerror='imgError(this);' class="img-responsive"
                                                             src="<?= Assets ?>images/header/call_opr_1.png"></div>
            </div>
        </div>


        <!-- end -->


        <!-- Combination Conflicting Popup start -->

        <!-- Modal -->

        <a href="#" style="display: none;" class="emb_modal" id=" "
           data-toggle="modal" data-target="#combination_conflict_modal"
           data-original-title="Label Embellishment Conflict"> Material Specification&nbsp;<i
                    class="fa fa-info-circle" aria-hidden="true"></i> </a>


        <div class="modal fade in combination_conflict_modal_close" tabindex="-1" data-keyboard="false"
             id="combination_conflict_modal" data-backdrop="static" role="dialog" style="margin-top: 12%;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="margin-bottom: 0 !important;">
                        <!--                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span-->
                        <!--                                    aria-hidden="true">×</span></button>-->
                        <h4 id="myModalLabel" class="modal-title"
                            style="color: #17b1e3;border-bottom: 1px solid#e6e6e6;">Please Select One Option </h4>
                    </div>
                    <div class="">
                        <div>

                            <div class="col-md-12">
                                <div id="specs_loader" class="white-screen hidden-xs" style="display: none;">
                                    <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                                onerror="imgError(this);"
                                                src="https://www.aalabels.com/theme/site/images/loader.gif"
                                                class="image" style="width:139px; height:29px; "></div>
                                </div>
                                <div id="ajax_tecnial_specifiacation" class="specifiacation">
                                    <div>

                                    </div>
                                </div>
                                <div class="" id="base_conflict_desc">
                                </div>
                                <div id="conflict_modl_msg_container">


                                </div>

                            </div>
                            <div class="badge badge-danger conflict_selection_remove_and_base_change_note"
                                 style="padding: 8px;">
                                <p style="line-height: 1.5;padding-bottom: 0;margin-bottom: 0;"> Note:- Your previous
                                    selections will be disabled<br> if select this option</p>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer " id="base_conflict_footer" style="padding: 15px !important;">

                    </div>
                </div>
            </div>
        </div>
        <!-- Combination Conflicting Popup  end -->


    </div>
</div>

<input type="hidden" name="edit_cart_flag" value="<?=$edit_cart_flag?>" id="edit_cart_flag">
<input type="hidden" name="temp_basket_id" value="<?=$temp_basket_id?>" id="temp_basket_id">

<!-- Popup For Artwork Upload & Artwork to follow Start -->
<div id="artwork_upload_view">
</div>

<!-- Popup For Artwork Upload & Artwork to follow Start -->
<div id="in_house_design_service_popup">
</div>

<!-- --><?php
//echo"<pre>";print_r($details);
//
//include('artwork_upload.php') ?>


<!-- Popup For Artwork Upload & Artwork to follow End  -->


<!-- JS For Label Embellishement Accordion Starts -->
<script>
    var Tabs = {

        init: function () {
            this.bindUIfunctions();
            this.pageLoadCorrectTab();
        },

        bindUIfunctions: function () {

            // Delegation
            $(document)
                .on("click", ".transformer-tabs a[href^='#']:not('.active')", function (event) {
                    Tabs.changeTab(this.hash);
                    event.preventDefault();
                })
                .on("click", ".transformer-tabs a.active", function (event) {
                    Tabs.toggleMobileMenu(event, this);
                    event.preventDefault();
                });

        },

        changeTab: function (hash) {

            var anchor = $('[href="' + hash + '"]');
            // var anchor = "#";

            var div = $(hash);

            // activate correct anchor (visually)
            anchor.addClass("active").parent().siblings().find("a").removeClass("active");

            // activate correct div (visually)
            div.addClass("active").siblings().removeClass("active");

            // update URL, no history addition
            // You'd have this active in a real situation, but it causes issues in an <iframe> (like here on CodePen) in Firefox. So commenting out.
            // window.history.replaceState("", "", hash);

            // Close menu, in case mobile
            anchor.closest("ul").removeClass("open");

        },

        // If the page has a hash on load, go to that tab
        pageLoadCorrectTab: function () {
            this.changeTab(document.location.hash);
        },

        toggleMobileMenu: function (event, el) {
            $(el).closest("ul").toggleClass("open");
        }

    }

    Tabs.init();
    <!--  JS For Label Embellishement Accordion End -->

    var conflict_id_unchecked = 0;
    // global variable to check which option is seleced by user in conflict modal
    var checked_id = '';
    // variable to verify if one option is selected from conflict modal then add close modal on it otherwise modal
    // can't close
    var option_clicked = '';
    // global var to base ids of selected option from conflict modal to change
    // combination_base in case of hot_foil embossing etc as their base id instead child id
    // as thier all child will disable if parent disable
    var embellishment_id = '';
    //Get sub title under hot_foil,embossing etc to Show as Base title in case of these options
    var embellishment_base_title = '';
    //global variable for plate price
    var total_emb_plate_price = 0;
    //cart id for upload artwork modal
    var cartid = '';


    $('.conflict_selection_remove_and_base_change_note').hide();

    //function run on emb_conflict option selection on conflict modal
    $(document).on("click", ".emb_conflict_option", function (e) {
        var clicked_id = $(this).data('embellishment_conflict_id');
        //show conflict_selection_remove_and_base_change_note if user select other option instead of current
        // combination_base
        if (combination_base != clicked_id) {
            $('.conflict_selection_remove_and_base_change_note').fadeIn();

        } else {
            $('.conflict_selection_remove_and_base_change_note').fadeOut();

        }


        $('.emb_conflict_option').each(function (i, obj) {
            var conflict_id = $(this).data('embellishment_conflict_id');
            var option_title = $(this).data('embellishment_base_title');


            if ($(this).is(":checked")) {
                //update global checked variable value
                checked_id = conflict_id;
                //update global embellishment_id variable value
                embellishment_id = $(this).data('embellishment_id');
                //update global option_clicked variable value
                option_clicked = 1;
            } else {
                //getting uncheck option id from conflict modal after user selection  to uncheck embellishment option
                conflict_id_unchecked = conflict_id;
                embellishment_id = $(this).data('embellishment_id');


                // $('.emb_option').data('embellishment_id').

            }

        });


    });

    //function to close conflict modal on continue button if and only if one option is selected from conflict modal


    $(document).on("click", ".continue_conflict_modal", function (e) {
        var modal_type = $(this).data('modal_type');

        //conflict modal when user wants to unselect base this will show when he selects option from modal to
        //yes as continue and no as not continue

        if (modal_type == 'base_uncheck_by_user') {
            var uncheck_val = $(this).data('uncheck_val');
            var comb_base = $(this).data('comb_base');
            var emb_selection_id = $(this).data('emb_selection_id');
            if (uncheck_val == 'yes') {
                // alert('uncheck yes');
                //check this val >0 to close conflict modal after value selection from modal
                option_clicked = 1;
                $('.emb_option , already_plates').each(function (i, obj) {
                    var option_embellishment_id = $(this).data('embellishment_id');
                    var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
                    //uncheck all selected options from Label Finishes & Embellishments section

                    // $('#uncheck' + option_embellishment_selection_id).attr('checked', false);
                    $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                    //also add same functionality to purchased plate section
                    $('#uncheck_purchased_plate' + option_embellishment_selection_id).prop("checked", false);
                    //also reset plate cost price total val
                    total_emb_plate_price = 0;
                    //use to remove new selected value from global selected_already_plates array if user retain its selection from conflict combination modal


                });
                //reset selected and combination_base after uncheck all options from above loop
                selected = [];
                selected_already_plates = [];
                selected_already_plates_composite_array = [];
                combination_base = '';

            } else {

                // reset total_emb_plate_price and add it according to base option selected
                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                    console.log(embellishment_plate_price_single);
                    // Reset total_emb_plate_price and then set it according to selected base value if it has any plate cost
                    if (emb_selection_id == embellishment_plate_price_single.id) {
                        total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                    }
                });


                console.log(comb_base);
                //check this val >0 to close conflict modal after value selection from modal

                option_clicked = 1;
                // if (combination_base == 2 || combination_base == 3 || combination_base == 4 || combination_base == 5) {
                //
                //     var emb_selection_id = $("#uncheck" + user_selected_embellishment_actual_id);
                //     var emb_id = $(emb_selection_id).data('embellishment_id');
                //
                //     if (emb_id == combination_base) {
                //     }
                // }
                //also add same functionality to purchased plate section
                if ($(this).data('tirggered_source')) {

                    $('#uncheck_purchased_plate' + emb_selection_id).prop("checked", true);
                    $('#uncheck' + emb_selection_id).prop("checked", true);
                    selected_already_plates.push(emb_selection_id);

                    // var composite_array = [];
                    // composite_array['plate_order_no'] = $(this).data('plate_order_no');
                    // composite_array['already_used_plate_id'] = $(this).data('embellishment_selection_id') ;

                    var composite_obj = {already_used_plate_id: emb_selection_id, plate_order_no: plate_order_no_last};
                    var lenght = selected_already_plates_composite_array.length;
                    selected_already_plates_composite_array[lenght] = JSON.stringify(composite_obj);


                } else {
                    $('#uncheck' + emb_selection_id).prop("checked", true);

                }


                // var index = selected_already_plates.indexOf(emb_selection_id);
                // if (index !== -1) selected_already_plates.splice(index, 1);
                combination_base = comb_base;
            }
            if (option_clicked > 0) {
                $('.combination_conflict_modal_close').modal('toggle');
                //once modal close then set it to 0 to re-apply all checks related to close modal
                option_clicked = 0;

            }
            //    Execute else if its label combination conflict modal
        } else {
            if (option_clicked > 0) {
                //add toggle to modal to close it as default close and keyboard esc button options are disabled to
                //force user to only close modal after one option selection
                $('.combination_conflict_modal_close').modal('toggle');
                //once modal close then set it to 0 to re-apply all checks related to close modal
                option_clicked = 0;

            }
            // if user select other option from conflict modal other then its current combination base then uncheck users all selections and
            //change its combination_base on run time
            if (combination_base != checked_id) {

                $('.emb_option, .already_plates').each(function (i, obj) {
                    var option_embellishment_id = $(this).data('embellishment_id');
                    var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
                    //uncheck all options other then selected option from conflict modal
                    if (option_embellishment_selection_id != checked_id && checked_id != '') {

                        $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                        $('#uncheck_purchased_plate' + option_embellishment_selection_id).prop('checked', false);
                        selected_already_plates = [];
                        selected_already_plates_composite_array = [];

                        selected_already_plates.push(checked_id);

                        //  this issue needs to be resolved as due to his entry its showing already purchase price section
                        //commenting these lines as it will require in case of conflict popup in already purchased plate modal so will consider it in last
                        // commenting it to prevent error in case of Label Finishes & Embellishments options price calculation (to prevent already purchased plate price section)
                        // var composite_obj = {already_used_plate_id: checked_id, plate_order_no: plate_order_no_last};
                        // selected_already_plates_composite_array[0] = JSON.stringify(composite_obj);

                        var composite_obj = {already_used_plate_id:checked_id, plate_order_no:plate_order_no_last};
                        selected_already_plates_composite_array[0] =  JSON.stringify(composite_obj);
                    }

                });
                //if user selects hot_foil,embossing,silk screen or sequential date from conflict modal then change its combination_base to
                // emb parent id as he can't select more then one child from these parents and if parent is disable
                // then their all childs will also be disabled.
                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                    // Reset total_emb_plate_price and then set it according to selected base value if it has any plate cost
                    if (checked_id == embellishment_plate_price_single.id) {
                        total_emb_plate_price = 0;
                        total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                    }
                });
                if (embellishment_id == 2 || embellishment_id == 3 || embellishment_id == 4 || embellishment_id == 5) {
                    // reset total_emb_plate_price and add it according to base option selected


                    combination_base = embellishment_id;
                    //    its execute in case of lamination & varnishes as they have separate values in combination_array and can be selected
                    //    more then one value
                } else {
                    // Reset total_emb_plate_price and then set it according to selected base value if it has any plate cost



                    // make combination_base to current selection id as user can select more then one value
                    // from lamination and varnish section
                    combination_base = checked_id;

                }
            } else {
                // Remove plate cost price if any if user select retain its selection from conflict combination modal
                var i = 0;
                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                    // console.log(embellishment_plate_price_single);
                    if (conflict_id_unchecked == embellishment_plate_price_single.id) {
                        total_emb_plate_price -= parseInt(embellishment_plate_price_single.plate_cost);
                    }
                });
                //uncheck user option that is not selected from combination conflict modal
                // when user selects same combination_base
                $('#uncheck' + conflict_id_unchecked).prop('checked', false);
                $('#uncheck_purchased_plate' + conflict_id_unchecked).prop('checked', false);
                //use to remove new selected value from global selected_already_plates array if user retain its selection from conflict combination modal
                var index = selected_already_plates.indexOf(conflict_id_unchecked);
                if (index !== -1) selected_already_plates.splice(index, 1);

                //maintain composite array with order no to select purchased plate of exact order if user has same plate more then one in different order with different softproof.
                // var index_composite = selected_already_plates_composite_array.indexOf(conflict_id_unchecked);
                // if (index !== -1) selected_already_plates_composite_array.splice(index_composite, 1);

                // selected_already_plates = [];
                selected_already_plates_composite_array = [];
                $('.already_plates:checked').each(function () {
                    var  id_uncheck =  $(this).data('embellishment_selection_id');
                    //use t uncheck conflicted plate from purchased history modal if user has more then one plates of same type in different orders
                    if(id_uncheck == conflict_id_unchecked){
                        $(this).prop('checked', false);

                    }

                    //maintain user selected option array
                    // selected[i++] = $(this).data('embellishment_selection_id')+'_plateHistory';
                    // var composite_array = [];
                    // composite_array['plate_order_no'] = $(this).data('plate_order_no');
                    // composite_array['already_used_plate_id'] = $(this).data('embellishment_selection_id') ;
                    var composite_obj = {already_used_plate_id:$(this).data('embellishment_selection_id'), plate_order_no:$(this).data('plate_order_no')};


                    selected_already_plates_composite_array[i] =  JSON.stringify(composite_obj) ;

                    // selected_already_plates[i] = $(this).data('embellishment_selection_id');
                    i++;
                });


            }
        }
        // show/update emb plate cost price total value in cart summery section
        $('#embellishment_plate_total_cost').html(total_emb_plate_price);
        //hide base change modal if showing
        $('.conflict_selection_remove_and_base_change_note').hide();
        $('#uncheck' + conflict_id_unchecked).prop('checked', false);
        $('#uncheck_purchased_plate' + conflict_id_unchecked).prop('checked', false);

        // alert(checked_id);
        // alert(total_emb_plate_price);

    });

    //used to check matched options on label finish & embellishments section on click of already purchased plate selection
    // $(document).on('click','.already_plates', function(event) {
    //     var embellishment_selection_id = $(this).data('embellishment_selection_id');
    //     if (!$("#uncheck" + embellishment_selection_id).is(":checked") ) {
    //         $('#uncheck' + embellishment_selection_id).trigger('click');
    //
    //     }else{
    //         $('#uncheck' + embellishment_selection_id).attr('checked', false);
    //
    //         // $('#uncheck' + embellishment_selection_id).trigger('click');
    //
    //     }
    //
    //     // alert("dsfsdfsd");
    // });

    var combination_base = '';
    var selected_already_plates = [];
    var selected_already_plates_composite_array = [];
    //function to check combinations start
    var plate_order_no_last = '';
    $(document).on("click", ".already_plates", function (e) {

        console.log(combination_base);
        //use to get plate no  against order number in conflict pop up if user retain his previous selection (using at combination_conflict_modal function)
        plate_order_no_last = $(this).data('plate_order_no');
        var user_selected_id = $(this).data('embellishment_id');
        var user_selected_title = $(this).data('embellishment_selected_title');
        var user_selected_embellishment_actual_id = $(this).data('embellishment_selection_id');
        // var selected = [];
        // used to sync check & uncheck behaviour of embellishment and finishes & purchased plate history modal

        //will execute when select already purchased plate
        if (!$("#uncheck" + user_selected_embellishment_actual_id).is(":checked")) {
            // alert("uncheck id if");
            $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
            //will execute when base already selected from main embellishment & finishes and then select same base and same element from select already purchased plate

        }else{
            if (user_selected_id == 2 || user_selected_id == 3 || user_selected_id == 4 || user_selected_id == 5) {
                // alert("base=2");
                // alert(plate_order_no_last);
                // alert($("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).data('plate_order_no'));
                if ($("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked") ) {
                    if ($("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).data('plate_order_no') == plate_order_no_last){
                        // alert("above if");

                        $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                        $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
                        $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
                    }else{
                        // alert("above else");

                        $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                        $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', true);
                        $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
                    }

                    // $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);

                }else{
                    if ($("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).data('plate_order_no') == plate_order_no_last){
                        $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                        $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
                        $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
                    }else{
                        $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                        $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', true);
                        $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
                    }
                    // alert("gfdgfd");
                    // $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                    // $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
                    // $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
                    // $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
                    // $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
                }
            }else{
                if ($("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
                    // alert("above2");
                    // $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                    $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
                }else{
                    // alert("gfdgfd2");
                    $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
                    $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
                    $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
                    // $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);

                }
            }



        }
        // if (!$("#uncheck" + user_selected_embellishment_actual_id).is(":checked") && !$("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
        //     $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //
        // } else if(!$("#uncheck" + user_selected_embellishment_actual_id).is(":checked") && $("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
        //
        //     $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //     $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //     $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
        // }else if ($("#uncheck" + user_selected_embellishment_actual_id).is(":checked") && $("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
        //
        //     $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
        //
        // }

        //     if (!$("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
        //
        //         $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //         // $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //         $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
        //     } else {
        //         if (!$("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
        //             $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //             $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //             $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
        //         } else {
        //             alert("2");
        //
        //             // $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //             // $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //             $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
        //         }
        //
        //     }
        // }













        //
        // if (!$("#uncheck" + user_selected_embellishment_actual_id).is(":checked")) {
        //     $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //
        // } else {
        //     if (!$("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")){
        //
        //         $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //         // $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //         $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
        //     }else{
        //         if (!$("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")) {
        //             $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //             $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //             $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', false);
        //         }else{
        //             alert("2");
        //
        //             // $('#uncheck' + user_selected_embellishment_actual_id).trigger('click');
        //             // $('#uncheck' + user_selected_embellishment_actual_id).prop('checked', false);
        //             $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
        //         }
        //
        //     }
        //
        //
        //     // $('#uncheck' + embellishment_selection_id).trigger('click');
        //
        // }

        //global variable for plate price
        // total_emb_plate_price = 0;
        var i = 0;
        // if hot_foil,embossing,silk screen, sequential then do nothing as user can't unselect its base
        // as all options/childs under it have same base id according to each parent and all these are radio
        // so can be check just one option at a time from respected parent decesendent child options
        if (combination_base == 2 || combination_base == 3 || combination_base == 4 || combination_base == 5) {

            var emb_selection_id = $("#uncheck" + user_selected_embellishment_actual_id);
            var emb_id = $(emb_selection_id).data('embellishment_id');

            if (emb_id == combination_base) {
                // if(!$("#uncheck_purchased_plate" + user_selected_embellishment_actual_id).is(":checked")){

                // if( $("#uncheck" + user_selected_embellishment_actual_id).is(":checked")){

                //     $('#uncheck_purchased_plate' + user_selected_embellishment_actual_id).prop('checked', true);
                //     selected_already_plates.push(user_selected_embellishment_actual_id);
                //
                //
                // }else
                if (!$("#uncheck" + user_selected_embellishment_actual_id).is(":checked") && user_selected_embellishment_actual_id != '') {
                    // alert("inside if");

                    var conflict_selection_remove_and_base_change_note = '';
                    var conflict_modl_msg_container = '';
                    var conflict_data_desc = '';
                    var conflict_data_footer = '';
                    conflict_data_desc += '<p> If You Uncheck this option your ';
                    conflict_data_desc += 'previous selections will be reset <br><br> ';
                    conflict_data_desc += 'Do you want to continue?</p>';

                    conflict_data_footer += '<div class="modal-footer row " style="padding: 15px !important;">';
                    conflict_data_footer += '<button data-toggle="modal" style="margin-left: -6% !important;" data-tirggered_source="purchased_plate_modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-uncheck_val="no" data-emb_selection_id = "'+user_selected_embellishment_actual_id+'" data-comb_base="' + combination_base + '" class=" m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-4" type="button">No';
                    conflict_data_footer += ' </button>';

                    conflict_data_footer += '<button data-toggle="modal" style="float:right ;" data-tirggered_source="purchased_plate_modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-uncheck_val="yes" data-emb_selection_id = "'+user_selected_embellishment_actual_id+'" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton float-right col-sm-4  "  type="button">Yes';
                    conflict_data_footer += '</button>';

                    conflict_data_footer += '</div>';

                    $('#base_conflict_desc').html(conflict_data_desc);
                    //hide base change message that is made for combination conflict modal not for this
                    $('.conflict_selection_remove_and_base_change_note').hide();
                    $('#conflict_modl_msg_container').html(conflict_modl_msg_container);
                    $('#base_conflict_footer').html(conflict_data_footer);
                    // add trigger event to click modal <a> to show modal
                    if (!$('.emb_modal').hasClass('in')){
                        $('.emb_modal').trigger("click");
                    }
                    // $('.emb_modal').trigger("click");

                }
            }


            //    execute if user unselect its base and also create conflict modal layout and options
            //    using same modal (with class .emb_modal) for both base unselect and combination conflict modal
            //    each creates its modal body data dynamically
        } else {
            if (!$("#uncheck" + combination_base).is(":checked") && combination_base != '') {
                // alert("inside if");

                var conflict_selection_remove_and_base_change_note = '';
                var conflict_modl_msg_container = '';
                var conflict_data_desc = '';
                var conflict_data_footer = '';
                conflict_data_desc += '<p> If You Uncheck this option your ';
                conflict_data_desc += 'previous selections will be reset <br><br> ';
                conflict_data_desc += 'Do you want to continue?</p>';

                conflict_data_footer += '<div class="modal-footer row " style="padding: 15px !important;">';
                conflict_data_footer += '<button data-toggle="modal" style="margin-left: -6% !important;" data-tirggered_source="purchased_plate_modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-emb_selection_id = "'+user_selected_embellishment_actual_id+'" data-uncheck_val="no" data-comb_base="' + combination_base + '" class=" m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-4" type="button">No';
                conflict_data_footer += ' </button>';

                conflict_data_footer += '<button data-toggle="modal" style="float:right ;" data-tirggered_source="purchased_plate_modal"  data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-emb_selection_id = "'+user_selected_embellishment_actual_id+'" data-uncheck_val="yes" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton float-right col-sm-4  " type="button">Yes';
                conflict_data_footer += '</button>';

                conflict_data_footer += '</div>';

                $('#base_conflict_desc').html(conflict_data_desc);
                //hide base change message that is made for combination conflict modal not for this
                $('.conflict_selection_remove_and_base_change_note').hide();
                $('#conflict_modl_msg_container').html(conflict_modl_msg_container);
                $('#base_conflict_footer').html(conflict_data_footer);
                // add trigger event to click modal <a> to show modal
                // $('.emb_modal').trigger("click");

            }
        }

        //get user selected element values
        selected_already_plates = [];
        selected_already_plates_composite_array = [];
        $('.already_plates:checked').each(function () {
            //maintain user selected option array
            // selected[i++] = $(this).data('embellishment_selection_id')+'_plateHistory';
            // var composite_array = [];
            // composite_array['plate_order_no'] = $(this).data('plate_order_no');
            // composite_array['already_used_plate_id'] = $(this).data('embellishment_selection_id') ;
            var composite_obj = {already_used_plate_id:$(this).data('embellishment_selection_id'), plate_order_no:$(this).data('plate_order_no')};


            selected_already_plates_composite_array[i] =  JSON.stringify(composite_obj) ;

            selected_already_plates[i] = $(this).data('embellishment_selection_id');
            i++;
        });
        console.log('selected_already_plates[i]' + selected_already_plates);
        console.log('selected_already_plates_composite_array[i]' + selected_already_plates_composite_array);
        // set combination base on user selection on first element selection
        if (selected_already_plates.length == 1 && combination_base == '') {
            //main array with base data and array of its child options
            $.each(parent_child_global, function (key, parent_value_array) {
                // console.log(parent_value_array);
                $.each(parent_value_array.child_options, function (k, child_single_data) {
                    if (selected_already_plates[0] == child_single_data.id) {
                        //set parent id as base in case of hot_foil,embossing,silk print, sequential
                        if (parent_value_array.id == 2 || parent_value_array.id == 3 || parent_value_array.id == 4 || parent_value_array.id == 5) {
                            combination_base = parent_value_array.id;
                            // total_emb_plate_price += parseInt(child_single_data.plate_cost);

                        } else {
                            // total_emb_plate_price += parseInt(child_single_data.plate_cost);
                            //set actual selected id  as base in case of lamination and varnishes as their all childs
                            //has its separate entry in combination table

                            combination_base = selected_already_plates[0];
                        }
                    }
                });
            });

        }
        if (selected_already_plates.length > 1 || combination_base != '') {

            // console.log(parent_child_global);
            //combination array  with parent_id and title as key and its valid combination array as value according to
            // parent id and has valid combinations of every value against parent id
            $.each(combination_global, function (array_key_with_id_name, specific_comb_array) {
                var specific_combination_id = array_key_with_id_name.split('_');
                //get combination array of user selected element from arrays of all combinations in combination_global array

                if (combination_base == specific_combination_id[0]) {

                    $.each(specific_comb_array, function (key1, value) {
                        $.each(selected_already_plates, function (key2, user_selection_prev_val) {
                            // check if combination base is compatible with user selection or not
                            if (combination_base != value.label_embellishment_agianst_id) {
                                //if found conflict then make conflict combination modal and check
                                //for hot_foil,embossing,silk screen , sequential
                                //show user selected option on first position and base is at second position
                                if (user_selected_id == 2 || user_selected_id == 3 || user_selected_id == 4 || user_selected_id == 5) {
                                    // specific_combination_id[1] = value.label_embellishment_title;
                                    // $('.emb_option ').each(function(i, obj) {
                                    //
                                    // });
                                    if (user_selected_id == value.label_embellishment_agianst_id && value.label_condition != 1) {

                                        var conflict_data = '';
                                        var conflict_data_desc = '';
                                        var conflict_data_footer = '';
                                        conflict_data_desc += '<p> These 2 options are not available together<br>';
                                        conflict_data_desc += 'Please select 1 of following</p>';
                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + user_selected_title + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + user_selected_embellishment_actual_id + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';


                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + specific_combination_id[1] + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + specific_combination_id[0] + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';

                                        conflict_data_footer += '<button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_conflict_option_modal" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-offset-3 col-sm-6" type="button">  Continue ';
                                        conflict_data_footer += '     <i class="fa fa-arrow-circle-right"></i>';
                                        conflict_data_footer += '    </button>';

                                        $('#base_conflict_desc').html(conflict_data_desc);
                                        $('#conflict_modl_msg_container').html(conflict_data);
                                        $('#base_conflict_footer').html(conflict_data_footer);

                                        if(selected_already_plates.length ==1){
                                            if (!$('.emb_modal').hasClass('in')){
                                                $('.emb_modal').trigger("click");
                                            }
                                        }


                                        // $('.emb_modal').trigger("click");

                                        // alert( value.label_embellishment_title);
                                        user_selected_id = 0;
                                    }
                                } else {
                                    //show conflict modal for Label Finishes & Embellishments section and show user selected option
                                    //at 1st position and base at second
                                    if (user_selection_prev_val == value.label_embellishment_agianst_id && value.label_condition != 1) {


                                        var conflict_data = '';
                                        var conflict_data_desc = '';
                                        var conflict_data_footer = '';

                                        conflict_data_desc += '<p> These 2 options are not available together<br>';
                                        conflict_data_desc += 'Please select 1 of following</p>';
                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + user_selected_title + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + user_selected_embellishment_actual_id + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';


                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + specific_combination_id[1] + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + specific_combination_id[0] + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';

                                        conflict_data_footer += '<button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_conflict_option_modal" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-offset-3 col-sm-6" type="button">  Continue ';
                                        conflict_data_footer += '     <i class="fa fa-arrow-circle-right"></i>';
                                        conflict_data_footer += '    </button>';

                                        $('#base_conflict_desc').html(conflict_data_desc);
                                        $('#conflict_modl_msg_container').html(conflict_data);
                                        $('#base_conflict_footer').html(conflict_data_footer);

                                        // alert( value.label_embellishment_title);
                                        // alert(specific_combination_id[1]);

                                        // $('.emb_modal').trigger("click");

                                    }
                                }
                                //    this execute if user
                            } else {
                                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                                    // console.log(embellishment_plate_price_single);
                                    if (user_selection_prev_val == embellishment_plate_price_single.id) {
                                        // total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                                    }
                                });
                                // console.log(selected);
                            }

                        });
                    });
                    // console.log(specific_comb_array);
                }
            });

        }
        //update emb plate cost price total value in cart summery
        // $('#embellishment_plate_total_cost').html(total_emb_plate_price);

        console.log(total_emb_plate_price);


        // alert(id);
    });

    //function to check combinations end


    // var combination_base = '';
    //function to check combinations start
    $(document).on("click", ".emb_option", function (e) {
// alert(combination_base);
        var user_selected_id = $(this).data('embellishment_id');
        var user_selected_title = $(this).data('embellishment_selected_title');
        var user_selected_embellishment_actual_id = $(this).data('embellishment_selection_id');
        var selected = [];


        //global variable for plate price
        total_emb_plate_price = 0;
        var i = 0;
        // if hot_foil,embossing,silk screen, sequential then do nothing as user can't unselect its base
        // as all options/childs under it have same base id according to each parent and all these are radio
        // so can be check just one option at a time from respected parent decesendent child options
        if (combination_base == 2 || combination_base == 3 || combination_base == 4 || combination_base == 5) {

            //    execute if user unselect its base and also create conflict modal layout and options
            //    using same modal (with class .emb_modal) for both base unselect and combination conflict modal
            //    each creates its modal body data dynamically
        } else {
            if (!$("#uncheck" + combination_base).is(":checked") && combination_base != '') {
                // alert("inside if");

                var conflict_selection_remove_and_base_change_note = '';
                var conflict_modl_msg_container = '';
                var conflict_data_desc = '';
                var conflict_data_footer = '';
                conflict_data_desc += '<p> If You Uncheck this option your ';
                conflict_data_desc += 'previous selections will be reset <br><br> ';
                conflict_data_desc += 'Do you want to continue?</p>';

                conflict_data_footer += '<div class="modal-footer row " style="padding: 15px !important;">';
                conflict_data_footer += '<button data-toggle="modal" style="margin-left: -6% !important;" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-uncheck_val="no" data-emb_selection_id = "'+user_selected_embellishment_actual_id+'" data-comb_base="' + combination_base + '" class=" m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-4" type="button">No';
                conflict_data_footer += ' </button>';

                conflict_data_footer += '<button data-toggle="modal" style="float:right ;" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-uncheck_val="yes" data-emb_selection_id = "'+user_selected_embellishment_actual_id+'" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton float-right col-sm-4  " type="button">Yes';
                conflict_data_footer += '</button>';

                conflict_data_footer += '</div>';

                $('#base_conflict_desc').html(conflict_data_desc);
                //hide base change message that is made for combination conflict modal not for this
                $('.conflict_selection_remove_and_base_change_note').hide();
                $('#conflict_modl_msg_container').html(conflict_modl_msg_container);
                $('#base_conflict_footer').html(conflict_data_footer);
                // add trigger event to click modal <a> to show modal
                if (!$('.emb_modal').hasClass('in')){
                    $('.emb_modal').trigger("click");
                }
                // $('.emb_modal').trigger("click");

            }
        }

        //get user selected element values
        $('.emb_option:checked').each(function () {
            // alert("inside emb_option_loop");
            //maintain user selected option array
            selected[i++] = $(this).data('embellishment_selection_id');
        });
        console.log(selected);
        // set combination base on user selection on first element selection
        if (selected.length == 1) {
            //main array with base data and array of its child options
            $.each(parent_child_global, function (key, parent_value_array) {
                // console.log(parent_value_array);
                $.each(parent_value_array.child_options, function (k, child_single_data) {
                    if (selected[0] == child_single_data.id) {
                        //set parent id as base in case of hot_foil,embossing,silk print, sequential
                        if (parent_value_array.id == 2 || parent_value_array.id == 3 || parent_value_array.id == 4 || parent_value_array.id == 5) {
                            combination_base = parent_value_array.id;
                            total_emb_plate_price += parseInt(child_single_data.plate_cost);

                        } else {
                            total_emb_plate_price += parseInt(child_single_data.plate_cost);
                            //set actual selected id  as base in case of lamination and varnishes as their all childs
                            //has its separate entry in combination table

                            combination_base = selected[0];
                        }
                    }
                });
            });

        }
        if (selected.length > 1) {
            // console.log(parent_child_global);
            //combination array  with parent_id and title as key and its valid combination array as value according to
            // parent id and has valid combinations of every value against parent id
            $.each(combination_global, function (array_key_with_id_name, specific_comb_array) {
                var specific_combination_id = array_key_with_id_name.split('_');
                //get combination array of user selected element from arrays of all combinations in combination_global array

                if (combination_base == specific_combination_id[0]) {

                    $.each(specific_comb_array, function (key1, value) {
                        $.each(selected, function (key2, user_selection_prev_val) {
                            // check if combination base is compatible with user selection or not
                            if (combination_base != value.label_embellishment_agianst_id) {
                                //if found conflict then make conflict combination modal and check
                                //for hot_foil,embossing,silk screen , sequential
                                //show user selected option on first position and base is at second position
                                if (user_selected_id == 2 || user_selected_id == 3 || user_selected_id == 4 || user_selected_id == 5) {
                                    // specific_combination_id[1] = value.label_embellishment_title;
                                    // $('.emb_option ').each(function(i, obj) {
                                    //
                                    // });
                                    if (user_selected_id == value.label_embellishment_agianst_id && value.label_condition != 1) {

                                        var conflict_data = '';
                                        var conflict_data_desc = '';
                                        var conflict_data_footer = '';
                                        conflict_data_desc += '<p> These 2 options are not available together<br>';
                                        conflict_data_desc += 'Please select 1 of following</p>';
                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + user_selected_title + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + user_selected_embellishment_actual_id + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';


                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + specific_combination_id[1] + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + specific_combination_id[0] + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';

                                        conflict_data_footer += '<button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_conflict_option_modal" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-offset-3 col-sm-6" type="button">  Continue ';
                                        conflict_data_footer += '     <i class="fa fa-arrow-circle-right"></i>';
                                        conflict_data_footer += '    </button>';

                                        $('#base_conflict_desc').html(conflict_data_desc);
                                        $('#conflict_modl_msg_container').html(conflict_data);
                                        $('#base_conflict_footer').html(conflict_data_footer);

                                        if (!$('.emb_modal').hasClass('in')){
                                            $('.emb_modal').trigger("click");
                                        }
                                        // $('.emb_modal').trigger("click");

                                        // alert( value.label_embellishment_title);
                                        user_selected_id = 0;
                                    }
                                } else {
                                    //show conflict modal for Label Finishes & Embellishments section and show user selected option
                                    //at 1st position and base at second
                                    if (user_selection_prev_val == value.label_embellishment_agianst_id && value.label_condition != 1) {
                                        // alert(array_key_with_id_name);


                                        var conflict_data = '';
                                        var conflict_data_desc = '';
                                        var conflict_data_footer = '';

                                        conflict_data_desc += '<p> These 2 options are not available together<br>';
                                        conflict_data_desc += 'Please select 1 of following</p>';
                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + user_selected_title + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + user_selected_embellishment_actual_id + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';


                                        conflict_data += '<div class="row">';
                                        conflict_data += '    <div class="col-sm-offset-1 col-sm-7">';
                                        conflict_data += '    <p>' + specific_combination_id[1] + '</p>';
                                        conflict_data += '</div>';
                                        conflict_data += '<div class="col-sm-offset-2 col-sm-1">';
                                        conflict_data += '    <label class="containerr left-no-margin">';
                                        conflict_data += '    <input type="radio" data-embellishment_id="' + user_selected_id + '" data-user_selected_title="' + user_selected_title + '" data-embellishment_conflict_id="' + specific_combination_id[0] + '" class="emb_conflict_option" name="label_embellishment["laminations_and_varnishes"][]">';
                                        conflict_data += '    <span class="checkmark"></span>';

                                        conflict_data += '    </label>';
                                        conflict_data += '    </div>';
                                        conflict_data += '    <div class="col-sm-1"></div>';
                                        conflict_data += '    </div>';

                                        conflict_data_footer += '<button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-modal_type="base_conflict_option_modal" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-offset-3 col-sm-6" type="button">  Continue ';
                                        conflict_data_footer += '     <i class="fa fa-arrow-circle-right"></i>';
                                        conflict_data_footer += '    </button>';

                                        $('#base_conflict_desc').html(conflict_data_desc);
                                        $('#conflict_modl_msg_container').html(conflict_data);
                                        $('#base_conflict_footer').html(conflict_data_footer);

                                        // alert( value.label_embellishment_title);
                                        // alert(specific_combination_id[1]);

                                        // $('.emb_modal').trigger("click");
                                        if (!$('.emb_modal').hasClass('in')){
                                            $('.emb_modal').trigger("click");
                                        }
                                    }
                                }
                                //    this execute if user
                            } else {
                                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                                    // console.log(embellishment_plate_price_single);
                                    if (user_selection_prev_val == embellishment_plate_price_single.id) {
                                        total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                                    }
                                });
                                // console.log(selected);
                            }

                        });
                    });
                    // console.log(specific_comb_array);
                }
            });

        }
        //update emb plate cost price total value in cart summery
        $('#embellishment_plate_total_cost').html(total_emb_plate_price);

        // console.log(total_emb_plate_price);


        // alert(id);
    });

    //function to check combinations end


    $(document).on("click", ".next_tab", function (e) {
        var val = $('.transformer-tabs a.active').attr('href');
        $(val).removeClass('active');
        var value = val.split('-');

        if (value[1] == 1) {
            $(".prev_tab").css("color", "black");
            $(".prev_tab").css("pointer-events", "none");
        }
        if (value[1] < 5) {
            val_next = ++value[1];
            $(".next_tab").css("color", "#17b1e3");
            $(".next_tab").css("pointer-events", "");
            $(".prev_tab").css("color", "#17b1e3");
            $(".prev_tab").css("pointer-events", "");
        } else {
            $(".next_tab").css("color", "black");
            $(".next_tab").css("pointer-events", "none");
        }

        var anchor = $('[href="' + value[0] + '-' + val_next + '"]');
        anchor.addClass("active").parent().siblings().find("a").removeClass("active");
        $(value[0] + '-' + val_next).addClass('active');

    });


    $(document).on("click", ".prev_tab", function (e) {
        var val = $('.transformer-tabs a.active').attr('href');
        $(val).removeClass('active');
        var value = val.split('-');
        if (value[1] == 1) {
            $(".prev_tab").css("color", "black");
            $(".prev_tab").css("pointer-events", "none");
        }
        if (value[1] <= 5 && value[1] != 1) {
            val_prev = --value[1];
            $(".next_tab").css("color", "#17b1e3");
            $(".next_tab").css("pointer-events", "");
            $(".prev_tab").css("color", "#17b1e3");
            $(".prev_tab").css("pointer-events", "");
        }
        var anchor = $('[href="' + value[0] + '-' + val_prev + '"]');
        anchor.addClass("active").parent().siblings().find("a").removeClass("active");
        $(value[0] + '-' + val_prev).addClass('active');

    });

    $(document).ready(function (e) {
        check_prefs();
        $('.dm-selector').find('.dropdown-menu').find("[data-toggle=tooltip-orintation]").tooltip('destroy');
        $('.dm-selector').find('.dropdown-menu').find("[data-toggle=tooltip-orintation]").tooltip();
    });

    var preferences_global = "";
    var combination_global = "";
    var embellishment_plate_price_global = "";
    var parent_child_global = "";
    var backtomaterial_ype = "roll-labels";


    function check_prefs(email) {
        $("#full_page_loader").show();
        var contentbox = $('#product_content');
        var finish_content = $('#finish_content');
        var cart_summery = $('#cart_summery');
        var edit_cart_flag = $('#edit_cart_flag').val();
        var temp_basket_id = $('#temp_basket_id').val();
        
        $.ajax({
            url: mainUrl + 'ajax/material_load_preferences',
            type: "POST",
            async: "false",
            dataType: "html",
            data: { email: email, edit_cart_flag:edit_cart_flag, temp_basket_id:temp_basket_id},
            success: function (data) {
                data = $.parseJSON(data);

                if (data.response == 'yes') {


                    // if (data.preferences.source != "material_page") {
                    //     document.location = "<?php //echo base_url() . 'printed-labels/';?>";
                    // }

                    preferences = data.preferences;
                    preferences_global = preferences;
                    combination_global = data.data.combination_array;
                    parent_child_global = data.data.label_embellishments;
                    embellishment_plate_price_global = data.data.embellishment_plate_price;

                    if (preferences.available_in == 'A4') {
                        $(".name_print_type").html("sheets");
                        backtomaterial_ype = "a4-sheets-printed";

                    } else if (preferences.available_in == 'A3') {
                        $(".name_print_type").html("sheets");
                        backtomaterial_ype = "a3-sheets-printed";
                    } else if (preferences.available_in == 'SRA3') {
                        $(".name_print_type").html("sheets");
                        backtomaterial_ype = "sra3-sheets-printed";
                    } else if (preferences.available_in == 'A5') {
                        $(".name_print_type").html("sheets");
                        backtomaterial_ype = "a5-sheets-printed";
                    } else {
                        $(".name_print_type").html("rolls");
                        backtomaterial_ype = "roll-labels-printed";
                    }

                    if (data.preferences.selected_size == null) {
                        return false;
                    }
                    // $('.preferences').modal('show');

                    //$(".gotoMaterialPage").attr("href", "../" + backtomaterial_ype + "/" + (preferences.shape).toLowerCase() + "/" + (preferences.selected_size).toLowerCase());
                    $(".gotoMaterialPage").attr("href", "../order_quotation/order/index");
                    //window.location.href = '<?php echo SAURL ?>order_quotation/order/index';
                    contentbox.html(data.data.printing_process_content);
                    finish_content.html(data.data.finish_content);
                    cart_summery.html(data.data.cart_summery);





                    combination_base =  data.data.cart_and_product_data['combination_base'];
                    console.log("Combination base : "+combination_base);
                    var wound = data.data.cart_and_product_data['wound'];
                    var label_application = data.data.cart_and_product_data['label_application'];
                    var orientation = "Orientation"+data.data.cart_and_product_data['orientation'];

                    console.log("Wound : "+wound);
                    console.log("Label Application : "+label_application);
                    console.log("Orientation : "+orientation);
                    console.log("Available In: "+preferences.available_in);
                    
                    $("#woundoption select").val(wound);
                    $('#label_application option[value='+label_application+']').attr('selected','selected');
                    
                    if(preferences.available_in == "Roll")
                    {
                        if(wound == 'Inside')
                        {
                            $('.insideorientation').show();
                            $('.outsideorientation').hide();
                        } else {
                            $('.insideorientation').hide();
                            $('.outsideorientation').show();
                        }

                        if(orientation != '' && orientation != null)
                        {
                            if(wound == 'Outside')
                            {
                                $('.field_containers').find('.dropdown-toggle').html((orientation).substr(0,1).toUpperCase()+(orientation).substr(1)+' <i class="fa fa-unsorted"></i>');
                                $('#label_orientation').val(orientation);
                            }
                            else
                            {

                                $('.field_containers').find('.dropdown-toggle').html((orientation).substr(0,1).toUpperCase()+(orientation).substr(1)+' <i class="fa fa-unsorted"></i>');
                                $('#label_orientation').val(orientation);
                            }
                        }
                        else
                        {
                            if(wound == 'Inside')
                            {
                                $('.field_containers').find('.dropdown-toggle').html('Orientation 5 <i class="fa fa-unsorted"></i>');
                                $('#label_orientation').val("orientation1");
                            }
                            else
                            {
                                $('.field_containers').find('.dropdown-toggle').html('Orientation 5 <i class="fa fa-unsorted"></i>');
                                $('#label_orientation').val('orientation5');
                            }

                        }
                    }

                    var orientatoin = $('#label_orientation').val();
                    $('.insideorientation').find('.popup_orientation').val(orientatoin);
                    $('.outsideorientation').find('.popup_orientation').val(orientatoin);


                    // $('#label_coresize').html(data.data.roll_cores);
                    $('#purchased_plate_section').html(data.data.hostory_plates_content);
                    $("#brandName").text(preferences.available_in);

                    checkedSelectedLemOptions($.parseJSON(data.data.cart_and_product_data['FinishTypePricePrintedLabels']));
                    
                    
                    $('.sheet_section_radio_main_container').hide();
                    $('#standerd_inner_section_options').hide();
                    
                    // return;
                    pre_load_apply_preferences(preferences);

                    // $('#premium_inner_section_options').hide();
                    // $('#premium_inner_section_description').hide();
                    // $('.printing_process_selection_inner_container').hide();

                    //disable click on page load on emb option tabs
                    if (preferences.available_in != "Roll"){
                        // $('#tab-1').css('pointer-events','none');
                        // $('#tab-2').css('pointer-events','none');
                        // $('#tab-3').css('pointer-events','none');
                        // $('#tab-4').css('pointer-events','none');
                        // $('#purchased_plate_cta').css('pointer-events','none');

                    }



                } else {
                    document.location = "<?php echo base_url() . 'orderQuotationPage/';?>";
                }
            }
        });
    }


    function pre_load_apply_preferences(data) {

        /*
        setTimeout(function () {

            if (data.available_in == "Roll") {
                if (data.wound_roll == 'Inside') {
                    $('.insideorientation').show();
                    $('.outsideorientation').hide();
                } else {
                    $('.insideorientation').hide();
                    $('.outsideorientation').show();
                }

                if (data.orientation != '' && data.orientation != null) {
                    if (data.orientation != null) {
                        var orient = parseInt(data.orientation.replace(/[^\d.]/g, ''));
                        var orientation = "Orientation 0" + orient;
                        // $("#roll_block").find('.orientation').html(orientation);
                    }
                    if (data.wound_roll == 'Outside') {

                        $('.roll_sheets_block').find('.dropdown-toggle').html((data.orientation).substr(0, 1).toUpperCase() + (data.orientation).substr(1) + ' <i class="fa fa-unsorted"></i>');
                        $('.roll_sheets_block').find('.dropdown-toggle').html(orientation + ' <i class="fa fa-unsorted"></i>');
                        $('#label_orientation').val(data.orientation);
                    } else {
                        $('.roll_sheets_block').find('.dropdown-toggle').html((data.orientation).substr(0, 1).toUpperCase() + (data.orientation).substr(1) + ' <i class="fa fa-unsorted"></i>');
                        $('.roll_sheets_block').find('.dropdown-toggle').html(orientation + ' <i class="fa fa-unsorted"></i>');
                        $('#label_orientation').val(data.orientation);
                    }
                } else {
                    if (data.wound_roll == 'Inside') {
                        $('.roll_sheets_block').find('.dropdown-toggle').html('Orientation 05 <i class="fa fa-unsorted"></i>');
                        $('#label_orientation').val("orientation5");
                    } else {
                        $('.roll_sheets_block').find('.dropdown-toggle').html('Orientation 01 <i class="fa fa-unsorted"></i>');
                        $('#label_orientation').val('orientation1');
                    }

                }
            }

        }, 1000);


        setTimeout(function () {
            if (data.coresize != '' && data.coresize != null) {
                $(".roll_sheets_block #label_coresize").val(data.coresize);
            }
            if (data.wound_roll != '' && data.wound_roll != null) {
                $(".roll_sheets_block #woundoption").val(data.wound_roll);
            }
            if (data.orientation != '' && data.orientation != null) {

                $(".roll_sheets_block #label_orientation").val(data.orientation);
                var text = $(".roll_sheets_block .labels-form .dm-selector li a[data-id='" + data.orientation + "']").text();
                $(".roll_sheets_block .labels-form .dm-selector a:first").html(text + " <i class='fa fa-unsorted'></i>");
                $(".roll_sheets_block .labels-form .dm-selector li a[data-id='" + data.orientation + "']").trigger("click");
            }
        }, 4500);

        */
        pre_load_add_item(data);
        $("#full_page_loader").hide();

    }

    //use to disable finishes & laminations section and show error msg in case of sheet 'standerd selection' or empty digital process
    $(document).on("change", "#woundoption,#label_coresize", function (e) {
        var woundoption = $('#woundoption').val();
        var coreid = $('#label_coresize').val();
        var element = $(this).attr('id');
        if (element == 'label_coresize') {
            var productcode = $('.roll_sidebar').find('[name="productcode_text"]').text();
            $.post('<?=base_url()?>ajax/product_details', {code: productcode, core: coreid}).then(function (returned) {
                returned = $.parseJSON(returned);
                if (returned.productcode) {
                    $('.roll_sidebar').find('[name="productcode_text"]').text(returned.productcode);
                }
                if (returned.shortcode) {
                    $('.roll_sheets_block').find('[name="productcode_text"]').text(returned.shortcode);
                }
            }, 'json');
            $('.roll_sheets_block').find('[name="productcode_text"]').text();
            $('.roll_sidebar').find('[name="productcode_text"]').text();
        }
        if (woundoption == 'Inside') {
            $('.insideorientation').show();
            $('.outsideorientation').hide();
            if ($(this).attr('id') == 'woundoption') {
                $('.roll_sheets_block').find('.dropdown-toggle').html(' Orientation 05 <i class="fa fa-unsorted"></i>');
                $('.roll_sheets_block_popup').find('.dropdown-toggle').html(' Orientation 05 <i class="fa fa-unsorted"></i>');
                $('#label_orientation').val('orientation5');
            }
        } else {
            $('.insideorientation').hide();
            $('.outsideorientation').show();
            if ($(this).attr('id') == 'woundoption') {
                $('.roll_sheets_block').find('.dropdown-toggle').html(' Orientation 01 <i class="fa fa-unsorted"></i>');
                $('.roll_sheets_block_popup').find('.dropdown-toggle').html(' Orientation 01 <i class="fa fa-unsorted"></i>');
                $('#label_orientation').val('orientation1');
            }
        }
        var orientatoin = $('#label_orientation').val();
        $('.insideorientation').find('.popup_orientation').val(orientatoin);
        $('.outsideorientation').find('.popup_orientation').val(orientatoin);
        $('#popup_woundoption').val(woundoption);
        $('#popup_coresize').val(coreid);
    });


    $(document).on("mouseover", ".dropdown-menu li a", function (e) {
        var selText = $(this).text();
        var orientation = $(this).attr('data-id');
        var woundoption = $('#woundoption').val();
        if (typeof orientation != 'undefined') {
            var imagepath = '<?=Assets?>images/categoryimages/winding/' + woundoption + '/' + orientation + '.png';
            $(this).find('img').attr('src', imagepath);
        }
    });

    $(document).on("click", ".roll_sheets_block .dm-selector li a", function (e) {
        var selText = $(this).text();
        var orientation = $(this).attr('data-id');
        if (typeof orientation !== "undefined") {
            //$(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <i class="fa fa-unsorted"></i>');
            $(this).parents('.btn-group').find('.dropdown-toggle').attr('data-value', orientation);
            $('.roll_sheets_block').find('.dropdown-toggle').html(selText + ' <i class="fa fa-unsorted"></i>');
            $('#label_orientation').val(orientation);
        }
    });


    $(document).on("change", "#popup_coresize,#popup_woundoption", function (e) {
        var woundoption = $('#popup_woundoption').val();
        var coreid = $('#popup_coresize').val();
        //var orientatoin = $('.popup_orientation').val();
        if (woundoption == 'Inside') {
            $('.insideorientation').show();
            $('.outsideorientation').hide();
            if ($(this).attr('id') == 'popup_woundoption') {
                $('.roll_sheets_block').find('.dropdown-toggle').html(' Orientation 05 <i class="fa fa-unsorted"></i>');
                $('#label_orientation').val('orientation1');
            }
        } else {
            $('.insideorientation').hide();
            $('.outsideorientation').show();
            if ($(this).attr('id') == 'popup_woundoption') {
                $('.roll_sheets_block').find('.dropdown-toggle').html(' Orientation 01 <i class="fa fa-unsorted"></i>');
                $('#label_orientation').val('orientation1');
            }
        }
        var orientatoin = $('#label_orientation').val();
        $('#woundoption').val(woundoption);
        $('#label_coresize').val(coreid);
        $('.insideorientation').find('.popup_orientation').val(orientatoin);
        $('.outsideorientation').find('.popup_orientation').val(orientatoin);
    });
    var uploaded_file_names = [];
    var has_files = 0;
    var all_files_uploaded = 0;

    function pre_load_add_item(allPreferences, page_reload) {
        var press_proof = 0;
        if ($('#press_proof').is(":checked")) {
            press_proof = 1;
        }
        var id = allPreferences.ProductID;
        // console.log(allPreferences);
        var menuid = allPreferences.ManufactureID;
        var rollfinish = '';
        var coresize = '';
        var woundoption = '';
        var orientation = '';
        var type = $('#producttype' + id).val();
        var unitqty = $('#calculation_unit' + id).val();
        //get user selected element values
        var laminations_and_varnishes = [];
        var laminations_and_varnishes_childs = [];
        var i = 0;
        // artwork upload section view appen container
        var artwork_upload_view = $('#artwork_upload_view');

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i] = $(this).data('embellishment_parsed_title');
            laminations_and_varnishes_childs[i] = $(this).data('embellishment_parsed_title_child');
            i++;
        });


        var qty = allPreferences.labels_a4;
        if (type == 'roll') {

            var rollfinish = $('#rollfinish' + id).val();
            var coresize = allPreferences.coresize;
            $('#woundoption option[value="' + allPreferences.wound_roll + '"]').prop('selected', true);
            var woundoption = $('#woundoption').val();

            // var woundoption = allPreferences.wound_roll;

            var orientation = $('#label_orientation').val();
            var qty = allPreferences.labels_roll;
        }else{
            var sheet_product_quality =  $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');

        }
        var digital_process_plus_white =  $('.digital_process_plus_white:checked').data('add_white');


        // var printing = $('#digital_printing_process' + id).val();
        var printing = $(".digital_process:checked").parents().data("printing_process");
        // var printing = "Monochrome_Black_Only";

        var labels = $('#labels_p_sheet' + id).val();
        var min_qty = parseInt($('#min_qty' + id).val());
        var max_qty = parseInt($('#max_qty' + id).val());

        var cartid = $('#cartid').val();
        //var pressproof = $('#pressproof').val();
        // show_loader('80', '27');
        var _this = $("#add_btn" + id);
        // change_btn_state(_this, 'disable', 'proceed-print');

        //get qty from preferences first after that take it from most updated qty
        var qty = $('.current_qty').text();

        if (!qty || qty == 0 || qty == 'NaN') {
            if (type == 'roll') {
                qty = allPreferences.labels_roll;

            } else {
                qty = allPreferences.labels_a4;

            }
        } else {
            if (type == 'roll') {
                qty = parseInt(qty);

            } else {
                qty = Math.ceil(qty / labels);


            }
        }

        //unselect already purchased plate of same base when user select another from laminations and varnish section(new plate in case of hot_foil,emboss/deboss as they have same base->parent for is child)

        //get user selected element values

        $('.emb_option:checked').each(function () {
            current_emb_id = $(this).data('embellishment_id');
            current_emb_selection_id = $(this).data('embellishment_selection_id');
            $('.already_plates:checked').each(function () {
                history_selected_emb_id = $(this).data('embellishment_id');
                history_emb_selection_id = $(this).data('embellishment_selection_id');
                if(current_emb_id == history_selected_emb_id &&  current_emb_selection_id != history_emb_selection_id){
                    $('#uncheck_purchased_plate' + history_emb_selection_id).prop('checked', false);


                    var index = selected_already_plates.indexOf(history_emb_selection_id);
                    if (index !== -1) selected_already_plates.splice(index, 1);

                    //maintain composite array with order no to select purchased plate of exact order if user has same plate more then one in different order with different softproof.
                    $.each(selected_already_plates_composite_array, function (a, b) {
                        // return string so convert it into object
                        var c =  JSON.parse(b);

                        if (c.already_used_plate_id == history_emb_selection_id) {
                            //get index of obj after matching and delete it from objects of objects global 'selected_already_plates_composite_array'
                            //splice function can't use as its for arrays only.
                            delete selected_already_plates_composite_array[a];
                        }
                    });
                }
            });
        });

        var remaing = parseInt($('#upload_remaining_labels').val());
        // console.log("1");
        var designs_remain = parseInt($('#upload_remaining_designs').val());
        if (designs_remain < 1) {
            var limit_exceed_designs = 'yes';
        } else {
            var limit_exceed_designs = 'no';
        }
        if (remaing <= 0) {
            var limit_exceed_sheet = 'yes';
            var artwork_uploaded_for_rolls = true;
        } else {
            var artwork_uploaded_for_rolls = false;
        }

        var label_application = $('#label_application').val();

        // selected_already_plates_composite_array.serializeArray()
        $('#cart_summery_loader').show();


        var edit_cart_flag = $('#edit_cart_flag').val();
        var temp_basket_id = $('#temp_basket_id').val();
        
        var custom_roll_and_label = $('#custom_roll_and_label').val();
        // var upload_artwork_radio = $('input[name="upload_artwork_2"]:checked').val();
        // var upload_artwork_option_radio = $('input[name="upload_artwork_option_2"]:checked').val();
        

        $.ajax({
            url: mainUrl + 'ajax/material_continue_with_product_printed_labels',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                page_reload: page_reload,
                label_application: label_application,
                combination_base: combination_base,
                artwork_uploaded_for_rolls: artwork_uploaded_for_rolls,
                limit_exceed_designs: limit_exceed_designs,
                limit_exceed_sheet: limit_exceed_sheet,
                digital_process_plus_white: digital_process_plus_white,
                sheet_product_quality: sheet_product_quality,
                qty: qty,
                menuid: menuid,
                prd_id: id,
                labelspersheets: labels,
                labeltype: printing,
                rollfinish: rollfinish,
                coresize: coresize,
                woundoption: woundoption,
                orientation: orientation,
                
                upload_artwork_option_radio: custom_roll_and_label,

                edit_cart_flag: edit_cart_flag,
                temp_basket_id: temp_basket_id,

                producttype: type,
                cartid: cartid,
                unitqty: unitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
                laminations_and_varnishes_childs: laminations_and_varnishes_childs,
                selected_already_plates: selected_already_plates,
                selected_already_plates_composite_array: selected_already_plates_composite_array,
                upload_artwork_radio: upload_artwork_radio


            },
            success: function (data) {

                // console.log(data);
                if (!data == '') {
                    data = $.parseJSON(data);
                    if (data.response == 'yes') {

                        if (data.data.prices && data.data.premium_prices) {
                            $('#standerd_section_price').html(data.data.prices.printprice * 2);
                            $('#premium_section_price').html(data.data.premium_prices.printprice * 2);

                        }

                        change_btn_state(_this, 'enable', 'sample');

                        // $('#Printing_Step_4').find('.show_selected_product').html(data.content);
                        $('#cart_summery').html(data.data.content);
                        artwork_upload_view.html(data.data.artwork_upload_view);

                        //append inhouse design services and also initialize dropzone for file upload START
                        $('#in_house_design_service_popup').html(data.data.in_house_design_service);
                        if ($('#ddropzone').length) {
                            Dropzone.autoDiscover = false;
                            var fileList = new Array;


                            $("#ddropzone").dropzone({
                                addRemoveLinks: true,
                                // autoProcessQueue: false,
                                // uploadMultiple:true,
                                parallelUploads: 30, // Number of files process at a time (default 2)
                                acceptedFiles: 'image/png  , image/jpg , image/gif , image/jpeg  , application/pdf  , application/postscript',
                                url: mainUrl + 'ajax/upload_file_custom_design_label_emb',
                                maxFiles: 30,

                                maxfilesexceeded: function (file) {
                                    this.removeFile(file);

                                },
                                sending: function (file, xhr, formData) {
                                    formData.append('cartid', cartid);
                                },
                                success: function (file, serverFileName) {

                                    fileList[i] = {
                                        "serverFileName": serverFileName,
                                        "fileName": file.name,
                                        "fileId": i
                                    };
                                    //console.log(fileList);
                                    i++;


                                    var args = Array.prototype.slice.call(arguments);
                                    uploaded_file_names.push(args[1]);
                                    // alert("inside success");
                                    // Look at the output in you browser console, if there is something interesting
                                    console.log(args[1]);
                                },
                                addedfiles: function (file) {
                                    has_files = 1;
                                },
                                queuecomplete: function (file) {
                                    all_files_uploaded = 1;
                                },

                                removedfile: function (file) {
                                    var rmvFile = "";
                                    for (f = 0; f < fileList.length; f++) {

                                        if (fileList[f].fileName == file.name) {
                                            rmvFile = fileList[f].serverFileName;

                                        }

                                    }

                                    if (rmvFile) {
                                        $.ajax({
                                            url: mainUrl + 'ajax/upload_file_custom_design_label_emb',
                                            type: "POST",
                                            data: {name: rmvFile, request: 2},
                                        });
                                        var _ref;
                                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                                    }
                                },

                                // removedfile: function (file) {
                                //     var name = file.name;
                                //
                                //     $.ajax({
                                //         type: 'POST',
                                //         url: mainUrl + 'ajax/upload_file_custom_design_label_emb',
                                //         data: {name: name, request: 2},
                                //         sucess: function (data) {
                                //             console.log('success: ' + data);
                                //         }
                                //     });
                                //     var _ref;
                                //     return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                                // },

                                error: function (file, message) {
                                    $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(message);
                                }
                            });
                            // other code here
                        }
                        //append inhouse design services and also initialize dropzone for file upload END

                        $('#alternate_option').html(data.data.alternate_option);

                        // $('#Printing_Step_2').find('#product_summary_overview_home').html(data.content_home);

                        $("[data-toggle=tooltip-orintation_popup]").tooltip('destroy');
                        $("[data-toggle=tooltip-orintation_popup]").tooltip();
                        // clear_uploaded_artworks();
                        // $('#aa_loader').hide();
                        // intialize_progressbar();

                        // $(".printed_total_pricing").parents('#product_summary_overview_home').find('.printed_total_pricing').hide();
                    }
                }
                $('#cart_summery_loader').hide();
                if (page_reload) {
                    $('#a4_material_selection').css('margin-top', '-183px');

                }

            }
        });
    }

    $(document).on("click", ".digital_process, .emb_option, .save_qty_btn, .product_quality, #press_proof", function (e) {

        $('#label-embellishement-calculate-price-cta').show("slide", {direction: "up"}, 400);
        $('#label-embellishement-cta').hide();

    });
    var is_finish_pref_dropbox_valid = 0;

    function reCaculate(_this) {


        var label_coresize = $('#label_coresize').val();
        var woundoption = $('#woundoption').val();
        var label_orientation = $('#label_orientation').val();
        var label_application = $('#label_application').val();

        var prdid = $('#cartproductid').val();
        var type = $('#producttype' + prdid).val();
        if (type == 'roll') {

                if (is_finish_pref_dropbox_valid == 0) {
                if (label_coresize == '' || label_coresize == undefined) {
                    $('#label_coresize').css('border', '2px solid red');
                    // show_faded_popover($('#label_coresize'), 'Select one of the option to proceed.');
                    is_finish_pref_dropbox_valid=0;
                    // return false;
                } else {
                    is_finish_pref_dropbox_valid++;

                }

                if (woundoption == '' || woundoption == undefined) {
                    $('#woundoption').css('border', '2px solid red');
                    // show_faded_popover($('#woundoption'), 'Select one of the option to proceed.');
                    is_finish_pref_dropbox_valid=0;

                    // return false;
                } else {
                    is_finish_pref_dropbox_valid++;

                }
                if (label_orientation == '' || label_orientation == undefined) {
                    $('#label_orientation').css('border', '2px solid red');
                    // show_faded_popover($('#label_orientation'), 'Select one of the option to proceed.');
                    is_finish_pref_dropbox_valid=0;

                    // return false;
                }
                else {
                    is_finish_pref_dropbox_valid++;

                }
                if (label_application == '' || label_application == undefined) {
                    $('#label_application').css('border', '2px solid red');
                    // show_faded_popover($('#label_application'), 'Select one of the option to proceed.');
                    is_finish_pref_dropbox_valid=0;

                    // return false;
                } else {
                    is_finish_pref_dropbox_valid++;

                }

                if(is_finish_pref_dropbox_valid <= 0){
                    // $('#toTop').trigger('click');
                    $('html, body').animate({ scrollTop: 0 },  "slow");
                    return false;
                }


            }
        }

        $('#label-embellishement-cta').show("slide", {direction: "up"}, 400);
        $('#label-embellishement-calculate-price-cta').hide();
        pre_load_add_item(preferences_global);
        // var radioValue = $(".digital_process:checked").parents().data("printing_process");
        //  console.log(_this);
        // calculatePrices(_this);

    }

    function proceedToCart(_this) {
        // $('#label-embellishement-cta').show("slide", { direction: "up" }, 400);
        // $('#label-embellishement-calculate-price-cta').hide();
        // console.log(_this);
        // calculatePrices(_this);

    }

    $(document).on("click", ".digital_process", function (e) {
        var id = $('.matselector').attr('id');
        // var sizeimagepath = $(_this).parents('.thumbnail').find('.lbl_img_size').attr('src');

        var digital_printing_process = $(this).parents().data("printing_process");

        update_material_selection(id, digital_printing_process);

    });

    $(document).on("click", ".dm-selector li a", function (e) {
        var id = $('.matselector').attr('id');
        update_material_selection(id);

    });


    $(document).on("change", ".printing_options", function (e) {
        var id = $('.matselector').attr('id');

        update_material_selection(id);
    });

    function update_material_selection(container, digital_printing_process = 0) {
// if (digital_printing_process){
//     var digital_printing_process  = digital_printing_process;
//
// }
        var edit_cart_flag = $('#edit_cart_flag').val();
        var temp_basket_id = $('#temp_basket_id').val();
        var core_size = $('#label_coresize').val();
        var wound_option = $('#woundoption').val();
        var label_orientation = $('#label_orientation').val();
        var label_application = $('#label_application').val();

        digital_printing_process = $('input[name="digital_printing_process"]:checked').parents().data("printing_process");
        // var digital_printing_process = $('#label_orientation').val();
        $('#finish_process_loader').show();
        $.ajax({
            url: mainUrl + 'ajax/update_embellishment_printing_options',
            type: "POST",
            data: {
                container: container,
                email: $("#email").val(),
                // digital_proccess: digital_proccess,
                core_size: core_size,
                wound_option: wound_option,
                edit_cart_flag: edit_cart_flag,
                label_application: label_application,
                temp_basket_id: temp_basket_id,
                
                digital_process: digital_printing_process,
                label_orientation: label_orientation
            },
            success: function (data) {
                $('#finish_process_loader').hide();

            }

        });

    }


    $(document).on("change", "#woundoption,#label_coresize", function (e) {
        var woundoption = $('#woundoption').val();
        var coreid = $('#label_coresize').val();
        var element = $(this).attr('id');
        if (element == 'label_coresize') {
            var productcode = $('.roll_sidebar').find('[name="productcode_text"]').text();
            $.post('<?=base_url()?>ajax/product_details', {code: productcode, core: coreid}).then(function (returned) {
                returned = $.parseJSON(returned);
                if (returned.productcode) {
                    $('.roll_sidebar').find('[name="productcode_text"]').text(returned.productcode);
                }
                if (returned.shortcode) {
                    $('.roll_sheets_block').find('[name="productcode_text"]').text(returned.shortcode);
                }
                // console.log(returned);
            }, 'json');
            $('.roll_sheets_block').find('[name="productcode_text"]').text();
            $('.roll_sidebar').find('[name="productcode_text"]').text();
        }
        if (woundoption == 'Inside') {
            $('.insideorientation').show();
            $('.outsideorientation').hide();
            if ($(this).attr('id') == 'woundoption') {
                $('.roll_sheets_block').find('.dropdown-toggle').html(' Orientation 05 <i class="fa fa-unsorted"></i>');
                $('.roll_sheets_block_popup').find('.dropdown-toggle').html(' Orientation 05 <i class="fa fa-unsorted"></i>');
                $('#label_orientation').val('orientation1');
            }
        } else {
            $('.insideorientation').hide();
            $('.outsideorientation').show();
            if ($(this).attr('id') == 'woundoption') {
                $('.roll_sheets_block').find('.dropdown-toggle').html(' Orientation 01 <i class="fa fa-unsorted"></i>');
                $('.roll_sheets_block_popup').find('.dropdown-toggle').html(' Orientation 01 <i class="fa fa-unsorted"></i>');
                $('#label_orientation').val('orientation1');
            }
        }
        var orientatoin = $('#label_orientation').val();
        $('.insideorientation').find('.popup_orientation').val(orientatoin);
        $('.outsideorientation').find('.popup_orientation').val(orientatoin);
        $('#popup_woundoption').val(woundoption);
        $('#popup_coresize').val(coreid);
        update_roll_images();
    });


    function update_roll_images() {
        orientation_text();
        var coreid = $('#label_coresize').val();
        var imagename = $('#wound_image').attr('data-imagename');
        var orientatoin = $('#label_orientation').val();
        var val = $('#woundoption').val();
        if (val == 'Inside') {

            //var path = '<?=$assets?>images/categoryimages/inner_roll/';
            var path = '<?=$assets?>images/categoryimages/RollLabels/inside/';
            var windingpath = '<?=$assets?>images/categoryimages/winding/Inside';
        } else {
            //var path = '<?=$assets?>images/categoryimages/roll_desc/';
            var path = '<?=$assets?>images/categoryimages/RollLabels/outside/';
            var windingpath = '<?=$assets?>images/categoryimages/winding/Outside';
        }
        $('.roll_sheets_block').find('.display_sheets').focus();
        //path +=imagename+coreid+'.jpg';
        var productcode = $('#product_code').val();
        // productcode = productcode.replace(/\s/g, '').slice(0, -1);
        coreid = coreid.replace(/[^\d.]/g, '');

        var img_code = productcode + coreid;

        path += img_code + '.jpg';
        windingpath += '/' + orientatoin + '.png';
        $('#wound_image').attr('src', path);
        $('.windingimage').attr('src', windingpath);
    }

    function orientation_text() {
        var orientation = $.trim($('.roll_sheets_block').find('.dropdown-toggle').text());
        if (orientation == "Orientation 01") {
            var orientation_text = 'Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first.';
        } else if (orientation == "Orientation 02") {
            var orientation_text = 'Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first.';
        } else if (orientation == "Orientation 03") {
            var orientation_text = 'Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first.';
        } else if (orientation == "Orientation 04") {
            var orientation_text = 'Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label off first.';
        } else if (orientation == "Orientation 05") {
            var orientation_text = 'Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first.';
        } else if (orientation == "Orientation 06") {
            var orientation_text = 'Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first.';
        } else if (orientation == "Orientation 07") {
            var orientation_text = 'Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first.';
        } else if (orientation == "Orientation 08") {
            var orientation_text = 'Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first.';
        }
        $('#roll_orientation_text').html('<b>' + orientation + ': </b><br /><span>' + orientation_text + '</span>');
    }

    var sequential_line_counter = 1;

    $(document).on("click", ".add_another_line", function (e) {
        var content = '';
        var append_div = $('.add_line');
        content += ' <div class="labels-form" id="seq-line' + sequential_line_counter + '">';

        content += '<label class="select col-sm-5 input">';
        content += '   <input type="text" id="label_coresize" placeholder="Enter The Starting Data"  >';

        content += '  </label>';
        content += '   <label class="select col-sm-5 input">';
        content += '  <input type="text" id="label_coresize" placeholder="Enter The Ending Data" >';

        content += '    </label>';
        content += '<label class="  col-sm-2  "> <button data-seq-id="' + sequential_line_counter + '"   title="Delete Artwork" class="delete_sequential_line  btn btn-danger"> <i class="fa f-10 fa-trash "></i> </button></label> </div>';
        $('.add_line').append(content);
        ++sequential_line_counter;

        // $('#add_another_line').hide();
    });

    $(document).on("click", ".delete_sequential_line", function (event) {
        var id = $(this).data('seq-id');


        swal({
                title: "Are you sure you want to delete this line",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn orangeBg",
                confirmButtonText: "Yes",
                cancelButtonClass: "btn blueBg m-r-10",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $('#seq-line' + id).remove();
                    return;

                }
            });
    });
    var product_type = '';
    var proceed_next_screen = '';
    var upload_artwork_radio_old_selection = '';
    var upload_artwork_option_radio_old_selection = '';
    $(document).on("click", "#about_your_artwork_cta", function (event) {
        upload_artwork_radio_old_selection = upload_artwork_radio;
        upload_artwork_option_radio_old_selection = upload_artwork_option_radio;
        var id = preferences_global.ProductID;

        var type = $('#producttype' + id).val();
        if (type != 'roll') {
            var sheet_product_quality = $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');
            if (!sheet_product_quality || sheet_product_quality == '' || sheet_product_quality == undefined) {
                // $(this).css('pointer-events','none');

                $(this).removeAttr('data-target');


                swal("Something Missing", "Please Select Digital Process To Continue", "error");
                return;

            } else {
                $("#about_your_artwork_cta").attr("data-target", "#artworkuploadpopup");


                // $(this).css('pointer-events','unset');

            }
        }

        //recheck radio buttons when user click on about artwork cta according to most recent value
        $("input[value='" + upload_artwork_radio + "']").prop("checked", true);
        $("input[value='" + upload_artwork_option_radio + "']").prop("checked", true);
        /////////////////////////////////////////////////////////////////////////////////////////
        cartid = $('#cartid').val();
        var lines_to_enter = $('#user_entered_lines_qty').val();
        if (lines_to_enter && lines_to_enter > 0) {
            $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");

        } else {
            $("#proceed_artwork_btn").removeAttr("data-target");

        }
        if ((preferences_global.available_in == "A4" || preferences_global.available_in == "A3" || preferences_global.available_in == "SRA3" || preferences_global.available_in == "A5") && preferences_global.categorycode_a4 != '') {
            //for sheet change/hide roll upload options of 20 pound and lpr & no of rolls
            $('.roll_upload_options').hide();
            $('.artwork_container').removeClass('col-md-4');
            $('.artwork_container').addClass('col-md-12');
            $('.artwork_row').removeClass('row');
            $('.artwork_inner_col').removeClass('col-md-6');
            $('.artwork_inner_col').addClass('col-md-3');
            product_type = 'sheet';
        } else {
            product_type = 'roll';
        }
        $('.modal-body').css("height", "88%");

    });
    $(document).on("keyup", "#user_entered_lines_qty", function (e) {
        var lines_to_enter = $('#user_entered_lines_qty').val();
        var upload_artwork_radio = $('.upload_artwork_radio:checked').val();
        var upload_artwork_option_radio = $('.upload_artwork_option_radio:checked').val();

        if (product_type == 'roll') {
            if (lines_to_enter && lines_to_enter > 0 && upload_artwork_radio && upload_artwork_radio !== 'undefined'
                && upload_artwork_radio !== '' && upload_artwork_option_radio && upload_artwork_option_radio !== 'undefined'
                && upload_artwork_option_radio !== '') {

                proceed_next_screen = 1;
            }
        } else {

            if (lines_to_enter && lines_to_enter > 0 && upload_artwork_radio && upload_artwork_radio !== 'undefined'
                && upload_artwork_radio !== '') {

                proceed_next_screen = 1;
            }

        }

        if (proceed_next_screen === 1) {

            if (lines_to_enter > 50) {
                $("#proceed_artwork_btn").removeAttr("data-target");

                swal({
                        title: "Maximum limit exceeded",
                        text: "Would You Like To Amend It To 50?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Yes",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#user_entered_lines_qty').val('50');
                            $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");
                            // $('#seq-line' + id).remove();
                            return;

                        }
                    });
            } else {
                $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");
                // $("#proceed_artwork_btn").trigger("click");
            }

        } else {
            swal("Something Missing", "Please Select Above Options To Continue", "error");
        }

    });


    $(document).on("click", ".artwork_upload_selection_change", function (event) {
        swal({
                title: "Your Previous Artwork options/files will be removed",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn orangeBg",
                confirmButtonText: "Yes",
                cancelButtonClass: "btn blueBg m-r-10",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    // update_cart_with_upload();
                    // if (upload_artwork_radio !== $(this).val() || upload_artwork_option_radio !==  $(this).val()){
                    //     $(this).attr('checked','checked');
                    upload_artwork_radio = $('input[name=upload_artwork_2]:checked').val();
                    upload_artwork_option_radio = $('input[name=upload_artwork_option_2]:checked').val();
                    // alert(upload_artwork_radio+'-'+upload_artwork_option_radio);
                    $('.upload_artwork_loader').show();
                    clear_uploaded_artworks('clear');
                    // }
                    return;

                }else{

                    // $("input[name=background][value='some value']").prop("checked",true);
                    $("input[value='" + upload_artwork_radio + "']").prop("checked", true);
                    $("input[value='" + upload_artwork_option_radio + "']").prop("checked", true);
                    // $("input[value='"+upload_artwork_radio+"']").attr("checked","checked");
                    // $("input[value='"+upload_artwork_option_radio+"']").attr("checked","checked");

                }
            });
    });

    var upload_artwork_radio = '';
    var upload_artwork_option_radio = '';
    var lines_to_populate = '';
    /*$(document).on("click", "#proceed_artwork_btn", function (e) {
// setup and run this function to clear artworks if user switch to other option after artwork upload option workflow
        // if (upload_option !== 'upload_artwork') {
        //     clear_uploaded_artworks();
        // }
        cartid = $('#cartid').val();

        //set height for inner modal to auto for full height with upload options
        $('.modal-body').css("height","auto");

        var lines_to_enter = $('#user_entered_lines_qty').val();
        upload_artwork_radio = $('.upload_artwork_radio:checked').val();
        upload_artwork_option_radio = $('.upload_artwork_option_radio:checked').val();
        // $('#upload_artwork_table').empty();
        var content = '';
        if (product_type == 'roll'){

            if (lines_to_enter && lines_to_enter > 0 && upload_artwork_radio && upload_artwork_radio !== 'undefined'
                && upload_artwork_radio !== '' && upload_artwork_option_radio && upload_artwork_option_radio !== 'undefined'
                && upload_artwork_option_radio !== '') {

                proceed_next_screen = 1;
            }
        }else{

            if (lines_to_enter && lines_to_enter > 0 && upload_artwork_radio && upload_artwork_radio !== 'undefined'
                && upload_artwork_radio !== '' ) {

                proceed_next_screen = 1;
            }

        }
        if (upload_artwork_radio !== "upload_artwork_now") {
            $('.upload_artwork_loader').show();
            clear_uploaded_artworks();

        }
        //check radio on previous selection on proceed click to next modal
        $('.artwork_option_inner').each(function (i, obj) {

            if (upload_artwork_radio == $(this).val() || upload_artwork_option_radio ==  $(this).val()){
                $(this).prop('checked','checked');
            }

        });
        //proceed to next (inner) modal if all checks fulfilled otherwise show error
        if (proceed_next_screen == 1) {
            $('#artworkuploadpopup').hide( );
            $('#artwork-upload-popup').trigger('click');

            if (lines_to_enter && lines_to_enter <= 50) {

                $('.upload_artwork').show();

                content += '<table class="table table-striped ">';
                content += ' <thead class="">';
                content += ' <tr>';
                content += ' <td align="center">No. of Designs</td>';
                if (upload_artwork_radio == "upload_artwork_now"){
                    content += ' <td align="center">Artworks</td>';

                }
                content += '   <td align="center">Design Name</td>';
                content += ' <td align="center">No. Labels</td>';
                if (upload_artwork_option_radio == "custom_roll_and_label" && product_type == "roll"){
                    content += '   <td align="center">Labels Per Roll</td>';
                    content += '  <td align="center">No. Rolls</td>';

                }

                content += '    <td align="center">Action</td>';
                if ( product_type == "roll") {

                    content += '     <td align="center">Additional Cost</td>';
                }
                content += '  </tr>';
                content += '   </thead>';
                content += '  <tbody>';

                for (var i = 1; i <= lines_to_enter; i++) {
                    content += '  <tr class="upload_row uploadsavesection">';
                    content += '   <td class="text-center" width="12.5%">6</td>';
                    if (upload_artwork_radio == "upload_artwork_now"){

                        content += ' <td width="12.5%" class="text-center">';
                        content += '<img onerror="imgError(this);" width="20" class="img-circle preview_po_img preview_po_img_selected'+i+'"  data-artwork_id = "'+i+'" style="display:none;" title="Click here to remove this file" id="   " src="http://localhost/newlabels/theme/site/images/place-holder.jpg" height="0">';
                        content += '   <input type="file" name="artwork_file" data-artwork-id="'+i+'" class="artwork_file  selected_artwork'+i+'" style="display:none;">';
                        content += ' <button class=" btn btn-primary browse_btn browse_btn_selected'+i+'"> <i class="fa fa-cloud-upload"></i> Browse File</button></td>';

                    }
                    content += '  <td width="12.5%">';
                    content += '   <input class="form-control artwork_name" placeholder="Artwork Name" type="text">';
                    content += '  </td>';
                    content += '   <td width="12.5%">';
                    content += '   <input class="form-control roll_labels_input allownumeric" placeholder="Enter Labels" type="text">';
                    content += '  </td>';
                    if (upload_artwork_option_radio == "custom_roll_and_label" && product_type == "roll"){
                        content += '  <td width="12.5%">';
                        content += '  <input class="form-control artwork_name" placeholder="Enter LPR" type="text">';
                        content += '  </td>';

                        content += ' <td width="12.5%" align="center">';
                        content += '  <input class="form-control artwork_name" placeholder="Enter No. of Rolls" type="text">';
                        content += ' </td>';

                    }
                    content += '  <td width="12.5%" align="center">';
                    content += '  <button data-value="roll" class=" btn btn-success save_artwork_file">';
                    content += '  <i class="fa fa-save"></i> Save';
                    content += '  </button>';
                    content += '    </td>';
                    if ( product_type == "roll") {

                        content += '   <td width="12.5%" align="center">';
                        content += '   </td>';
                    }
                    content += '    </tr>';

                }

                content += '   <tr>';
                content += '   <td colspan="6" class="text-left" style="vertical-align:middle;"> You have <b class="remaing_user_sheets">100 </b> labels remaining</td>';
                content += ' <td colspan="2" style="vertical-align:middle;" class="text-center" align="center">';
                content += '    1 Design , 150 Labels on 5 Rolls';
                content += ' </td>';
                content += ' </tr>';
                content += ' <tr style="background:none;">';
                content += '    <td colspan="8">';
                content += '   <p>In order to upload your artwork you must complete the line e.g. File name and the number of labels required. Upon which the file will be uploaded.</p>';
                content += '  </td>';
                content += '  </tr>';

                content += ' </tbody>';
                $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");

            } else {
                $("#proceed_artwork_btn").removeAttr("data-target");

                swal({
                        title: "Maximum limit exceeded",
                        text: "Would You Like To Amend It To 50?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Yes",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#user_entered_lines_qty').val('50');
                            $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");
                            // $('#seq-line' + id).remove();
                            return;

                        }
                    });
            }
        }else{
            $("#proceed_artwork_btn").removeAttr("data-target");
            swal("Something Missing", "Please Select Above Options To Continue", "error");

        }

        //$('#upload_artwork_table').append(content);
        // alert(lines_to_enter);

    });*/

    $(document).on("click", "#proceed_artwork_btn", function (e) {
// setup and run this function to clear artworks if user switch to other option after artwork upload option workflow
        // if (upload_option !== 'upload_artwork') {
        //     clear_uploaded_artworks();
        // }
        // $('.save_and_close_popup_checks').attr('data-dismiss', '');

        cartid = $('#cartid').val();
        var id = preferences_global.ProductID;
        var menuid = preferences_global.ManufactureID;
        var type = $('#producttype' + id).val();
        var unitqty = $('#calculation_unit' + id).val();
        var qty = preferences_global.labels_a4;
        var printing = $(".digital_process:checked").parents().data("printing_process");
        var labels = $('#labels_p_sheet' + id).val();
        var artwork_upload_view = $('#upload_artwork_table');


        if (type == 'roll') {

            var qty = preferences_global.labels_roll;
        }
        //set height for inner modal to auto for full height with upload options
        $('.modal-body').css("height", "auto");

        var lines_to_enter = $('#user_entered_lines_qty').val();

        lines_to_populate = lines_to_enter;
        upload_artwork_radio = $('.upload_artwork_radio:checked').val();
        upload_artwork_option_radio = $('.upload_artwork_option_radio:checked').val();
        // $('#upload_artwork_table').empty();
        var content = '';
        if (product_type == 'roll') {

            if (lines_to_enter && lines_to_enter !== '' && lines_to_enter > 0 && upload_artwork_radio && upload_artwork_radio !== 'undefined'
                && upload_artwork_radio !== '' && upload_artwork_option_radio && upload_artwork_option_radio !== 'undefined'
                && upload_artwork_option_radio !== '') {

                proceed_next_screen = 1;
            }
        } else {

            if (lines_to_enter && lines_to_enter > 0 && upload_artwork_radio && upload_artwork_radio !== 'undefined'
                && upload_artwork_radio !== '') {

                proceed_next_screen = 1;
            }

        }
        if (upload_artwork_radio != upload_artwork_radio_old_selection || upload_artwork_option_radio != upload_artwork_option_radio_old_selection) {
            // $('.upload_artwork_loader').show();
            // clear_uploaded_artworks();

        }
        //check radio on previous selection on proceed click to next modal
        $('.artwork_option_inner').each(function (i, obj) {
            if (upload_artwork_radio == $(this).val()) {
                $(this).prop('checked', 'checked');
            }
            if (upload_artwork_option_radio == $(this).val()) {
                $(this).prop('checked', 'checked');
            }

        });

        var id = preferences_global.ProductID;
        var type = $('#producttype' + id).val();
        var labels = $('#labels_p_sheet' + id).val();


//get qty from preferences first after that take it from most updated qty
        var qty = $('.current_qty').text();

        if (!qty || qty == 0 || qty == 'NaN') {
            if (type == 'roll') {
                qty = preferences_global.labels_roll;

            } else {
                qty = preferences_global.labels_a4;

            }
        } else {
            if (type == 'roll') {
                qty = parseInt(qty);

            } else {
                qty = Math.ceil(qty / labels);


            }
        }

        //proceed to next (inner) modal if all checks fulfilled otherwise show error
        if (proceed_next_screen == 1) {

            if (lines_to_enter && lines_to_enter <= 50) {
                
                var custom_roll_and_label = $("#custom_roll_and_label").val();
                
                var edit_cart_flag = $("#edit_cart_flag").val();
                var temp_basket_id = $('#temp_basket_id').val();

                $('#artwork-upload-popup').trigger('click');
                $('#artworkuploadpopup').hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                $('.upload_artwork').show();
                clear_uploaded_artworks();
                $.ajax({
                    url: mainUrl + 'ajax/material_populate_artwork_upload_table_printed_labels',
                    type: "POST",
                    async: "false",
                    dataType: "html",
                    data: {
                        qty: qty,
                        cartid: cartid,
                        menuid: menuid,
                        prd_id: id,
                        labelspersheets: labels,
                        labeltype: printing,
                        producttype: type,
                        edit_cart_flag : edit_cart_flag,
                        temp_basket_id : temp_basket_id,
                        
                        upload_artwork_radio: upload_artwork_radio,
                        upload_artwork_option_radio: upload_artwork_option_radio,
                        lines_to_populate: lines_to_populate,
                        unitqty: unitqty
                    },
                    success: function (data) {
                        if (!data == '') {
                            data = $.parseJSON(data);
                            if (data.response == 'yes') {
                                artwork_upload_view.empty();
                                artwork_upload_view.html(data.data.artwork_upload_view);
                                $('.upload_artwork').show();
                                clear_uploaded_artworks();
                                // console.log(data.data.artwork_upload_view);
                                //
                                // setTimeout(function(){
                                //
                                //     alert("fdgdfgdf");
                                //     // change_btn_state(_this, 'enable', 'sample');
                                //
                                //
                                // }, 2000);


                            }
                        }
                        // $('#cart_summery_loader').hide();

                    }
                });


                content += '<table class="table table-striped ">';
                content += ' <thead class="">';
                content += ' <tr>';
                content += ' <td align="center">No. of Designs</td>';
                if (upload_artwork_radio == "upload_artwork_now") {
                    content += ' <td align="center">Artworks</td>';

                }
                content += '   <td align="center">Design Name</td>';
                content += ' <td align="center">No. Labels</td>';
                if (upload_artwork_option_radio == "custom_roll_and_label" && product_type == "roll") {
                    content += '   <td align="center">Labels Per Roll</td>';
                    content += '  <td align="center">No. Rolls</td>';

                }

                content += '    <td align="center">Action</td>';
                if (product_type == "roll") {

                    content += '     <td align="center">Additional Cost</td>';
                }
                content += '  </tr>';
                content += '   </thead>';
                content += '  <tbody>';

                for (var i = 1; i <= lines_to_enter; i++) {
                    content += '  <tr class="upload_row uploadsavesection">';
                    content += '   <td class="text-center" width="12.5%">6</td>';
                    if (upload_artwork_radio == "upload_artwork_now") {

                        content += ' <td width="12.5%" class="text-center">';
                        content += '<img onerror="imgError(this);" width="20" class="img-circle preview_po_img preview_po_img_selected' + i + '"  data-artwork_id = "' + i + '" style="display:none;" title="Click here to remove this file" id="   " src="http://localhost/newlabels/theme/site/images/place-holder.jpg" height="0">';
                        content += '   <input type="file" name="artwork_file" data-artwork-id="' + i + '" class="artwork_file  selected_artwork' + i + '" style="display:none;">';
                        content += ' <button class=" btn btn-primary browse_btn browse_btn_selected' + i + '"> <i class="fa fa-cloud-upload"></i> Browse File</button></td>';

                    }
                    content += '  <td width="12.5%">';
                    content += '   <input class="form-control artwork_name" placeholder="Artwork Name" type="text">';
                    content += '  </td>';
                    content += '   <td width="12.5%">';
                    content += '   <input class="form-control roll_labels_input allownumeric" placeholder="Enter Labels" type="text">';
                    content += '  </td>';
                    if (upload_artwork_option_radio == "custom_roll_and_label" && product_type == "roll") {
                        content += '  <td width="12.5%">';
                        content += '  <input class="form-control artwork_name" placeholder="Enter LPR" type="text">';
                        content += '  </td>';

                        content += ' <td width="12.5%" align="center">';
                        content += '  <input class="form-control artwork_name" placeholder="Enter No. of Rolls" type="text">';
                        content += ' </td>';

                    }
                    content += '  <td width="12.5%" align="center">';
                    content += '  <button data-value="roll" class=" btn btn-success save_artwork_file">';
                    content += '  <i class="fa fa-save"></i> Save';
                    content += '  </button>';
                    content += '    </td>';
                    if (product_type == "roll") {

                        content += '   <td width="12.5%" align="center">';
                        content += '   </td>';
                    }
                    content += '    </tr>';

                }

                content += '   <tr>';
                content += '   <td colspan="6" class="text-left" style="vertical-align:middle;"> You have <b class="remaing_user_sheets">100 </b> labels remaining</td>';
                content += ' <td colspan="2" style="vertical-align:middle;" class="text-center" align="center">';
                content += '    1 Design , 150 Labels on 5 Rolls';
                content += ' </td>';
                content += ' </tr>';
                content += ' <tr style="background:none;">';
                content += '    <td colspan="8">';
                content += '   <p>In order to upload your artwork you must complete the line e.g. File name and the number of labels required. Upon which the file will be uploaded.</p>';
                content += '  </td>';
                content += '  </tr>';

                content += ' </tbody>';
                $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");

            }else if (lines_to_enter == '') {
                $("#proceed_artwork_btn").removeAttr("data-target");
                swal("Something Missing", "Please Select Above Options To Continue", "error");
            }else {
                $("#proceed_artwork_btn").removeAttr("data-target");

                swal({
                        title: "Maximum limit exceeded",
                        text: "Would You Like To Amend It To 50?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Yes",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#user_entered_lines_qty').val('50');
                            $("#proceed_artwork_btn").attr("data-target", "#artworkuploadpopup1");
                            // $('#seq-line' + id).remove();
                            return;

                        }
                    });
            }
        } else {
            $("#proceed_artwork_btn").removeAttr("data-target");
            swal("Something Missing", "Please Select Above Options To Continue", "error");

        }

        //$('#upload_artwork_table').append(content);
        // alert(lines_to_enter);

    });
    $(document).on("click", ".browse_btn", function (e) {

        $(this).parents('.upload_row').find('.artwork_file').click();
    });

    function isFloat(n) {
        return Number(n) === n && n % 1 !== 0;
    }

    function is_numeric(mixed_var) {
        var whitespace =
            " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
        return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
            1)) && mixed_var !== '' && !isNaN(mixed_var);
    }

    var timer = '';


    //test scripts


    function intialize_progressbar() {
        $("#progressbar").progressbar({
            value: 0,
            create: function (event, ui) {
                $(this).removeClass("ui-corner-all").addClass('progress').find(">:first-child").removeClass("ui-corner-left").addClass('progress-bar progress-bar-success');
            }
        });
    }


    $(document).on("change", ".artwork_file", function (e) {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (ext == 'docx' || ext == 'doc') {
                $('#preview_po_img').attr('src', '<?=Assets?>images/doc.png');
                $('#preview_po_img').show();
                $('.browse_btn').hide();
            } else if (ext == 'pdf') {
                $('#preview_po_img').attr('src', '<?=Assets?>images/pdf.png');
                $('#preview_po_img').show();
                $('.browse_btn').hide();
            } else if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview_po_img').attr('src', e.target.result);
                    $('#preview_po_img').show();
                    $('.browse_btn').hide();
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#preview_po_img').attr('src', '<?=Assets?>images/no-image.png');
                $('#preview_po_img').show();
                $('.browse_btn').hide();
            }
        }
    }

    $(document).on("click", "#preview_po_img", function (e) {
        swal({
                title: 'Are you sure you want to delete this file?',
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn orangeBg",
                confirmButtonText: "No",
                cancelButtonClass: "btn blueBg m-r-10",
                cancelButtonText: "Yes",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    // console.log('cancel');
                } else {
                    $('.browse_btn').show();
                    $('#preview_po_img').hide();
                }
            });
    });


    $(document).on("blur", ".labels_input", function (e) {
        var prdid = $('#cartproductid').val();
        var min_qty = parseInt($('#labels_p_sheet' + prdid).val());
        var unitqty = $('#cartunitqty').val();
        var labels = parseInt($(this).val());
        if (!is_numeric(labels)) {
            //alert_box("please enter only numbers ");
            show_faded_popover(this, "please enter only numbers ");
            $(this).val('');
            //$(this).focus();
            return false;
        } else if (labels == 0 && unitqty == 'sheets') {
            //alert_box("Minimum 1 sheet required ");
            show_faded_popover(this, "Minimum 1 sheet required ");
            $(this).val('');
            //$(this).focus();
            return false;
        } else if ((labels == 0 || labels < min_qty) && unitqty == 'labels') {
            //alert_box("Minimum "+min_qty+" labels are required ");
            show_faded_popover(this, "Minimum " + min_qty + " labels are required ");
            $(this).val('');
            //$(this).focus();
            return false;
        } else if (labels % min_qty != 0 && unitqty == 'labels') {
            var multipyer = min_qty * parseInt(parseInt(labels / min_qty) + 1);
            $(this).val(multipyer);
            total_upload_labels();
            show_faded_popover(this, "Quantity has been amended for production as " + multipyer + " Labels.");
            //alert_box("Please enter a quantity based on multiples of "+min_qty+" labels per sheet.");
            $(this).focus();
            return false;
        } else {
            total_upload_labels();
        }
    });

    function total_upload_labels() {
        var total_labels = 0;
        var total_sheets = 0;
        var prdid = $('#cartproductid').val();
        var min_qty = $('#labels_p_sheet' + prdid).val();
        var unitqty = $('#cartunitqty').val();
        $(".labels_input").each(function (index) {
            if ($(this).val() !== '') {
                if (unitqty == 'labels') {
                    var labels = parseInt($(this).val());
                    var sheets = parseInt(labels / min_qty);
                    $(this).parents('.upload_row').find('.displaysheets').text(sheets);
                } else {
                    var sheets = parseInt($(this).val());
                    var labels = parseInt(sheets * min_qty);
                    $(this).parents('.upload_row').find('.displaysheets').text(labels);
                }
                total_labels += labels;
                total_sheets += sheets;
            }
        });
        if (total_sheets != 'NaN') {
            if (unitqty == 'labels') {
                $('.total_user_labels').html(total_sheets);
                $('.total_user_sheet').html(total_labels);
            } else {
                $('.total_user_labels').html(total_labels);
                $('.total_user_sheet').html(total_sheets);
            }
            var labels = parseInt($('#acutal_labels').val());
            var acutal_qty = parseInt($('#acutal_qty').val());
            var prdid = $('#cartproductid').val();
            var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
            var reaming = parseInt(acutal_qty) - parseInt(total_sheets);
            if (reaming < 0) {
                $('.remaing_user_sheets').html('0');
                $('.remaing_user_labels').html('0');
            } else {
                if (unitqty == 'labels') {
                    $('.remaing_user_sheets').html(reaming * labelspersheets);
                    $('.remaing_user_labels').html(reaming);
                } else {
                    $('.remaing_user_sheets').html(reaming);
                    $('.remaing_user_labels').html(reaming * labelspersheets);
                }
            }
            // console.log("remaining"+reaming);

            $('#upload_remaining_labels').val(reaming);
        }
    }
    /*$(document).on("click", ".save_artwork_file", function (e) {
        var _this = this;
        // var cartid = $('#cartid').val();
        // alert(cartid);
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
        var file = $(_this).parents('.upload_row').find('.artwork_file').val();
        var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        var response = '';
        alert(type);
        if (type == 'roll') {
            response = verify_labels_or_rolls_qty(_this);
            if (response == false) {
                return false;
            }
            var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
            var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();
            var lb_txt = 'labels';
        } else {
            if (cartunitqty == 'labels') {
                var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                if (labels.length == 0) {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum " + labelpersheets + " labels are required ");
                    }
                    return false;
                }
                var sheets = parseInt(labels / labelpersheets);
                var lb_txt = 'labels';
            } else {
                var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
                if (sheets.length == 0) {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum 1 sheet required ");
                    }
                    return false;
                }
                var labels = parseInt(sheets * labelpersheets);
                var lb_txt = 'sheets';
            }
        }
        if (file.length == 0) {
            alert_box("Please upload a file before saving. ");
        } else if (labels == 0 || labels == '') {
            alert_box("Please complete line ");
        } else if (artworkname.length == 0) {
            alert_box("please enter artwork name! ");
        } else {
            var press_proof = 0;
            if ($('#press_proof').is(":checked")) {
                press_proof = 1;
            }
//get user selected element values
            var laminations_and_varnishes = [];
            var i = 0;

            $('.emb_option:checked').each(function () {
                //maintain user selected option array
                laminations_and_varnishes[i++] = $(this).data('embellishment_parsed_title');
            });

            var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
            var form_data = new FormData();
            form_data.append("file", uploadfile);
            form_data.append("cartid", cartid);
            form_data.append("productid", prdid);
            form_data.append("labels", labels);
            form_data.append("sheets", sheets);
            form_data.append("artworkname", artworkname);
            form_data.append("persheet", labelpersheets);
            form_data.append("type", type);
            form_data.append("unitqty", cartunitqty);
            form_data.append("total_emb_plate_price", total_emb_plate_price);
            form_data.append("press_proof", press_proof);
            form_data.append("laminations_and_varnishes", laminations_and_varnishes);

            // console.log(type);
            type = uploadfile.type;
            if (type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript') {
                swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");
                return false;
            }
            var type = $('#producttype' + prdid).val();
            var remaing = parseInt($('#upload_remaining_labels').val());
            var designs_remain = parseInt($('#upload_remaining_designs').val());
            if (designs_remain < 1) {
                form_data.append("limit_exceed_designs", 'yes');
                var msg = 'You have entered extra designs, click here to update your basket.';
            }
            if (remaing < 0) {
                form_data.append("limit_exceed_sheet", 'yes');
                var msg = 'You have entered extra ' + lb_txt + ', click here to update your basket.';
            }
            if (remaing < 0 || (designs_remain < 1 && type != 'roll')) {
                swal({
                        title: msg,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Update Basket",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            upload_printing_artworks(form_data);
                        }
                    });
            } else {
                upload_printing_artworks(form_data);
            }
        }
    });*/

    $(document).on("click", ".save_artwork_file", function (e) {
        var _this = this;
        // var cartid = $('#cartid').val();
        // alert(cartid);
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
        if (upload_artwork_radio == "upload_artwork_now") {

            var file = $(_this).parents('.upload_row').find('.artwork_file').val();
            var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];
        }
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        var response = '';
        if (type == 'roll') {
            response = verify_labels_or_rolls_qty(_this);
            if (response == false) {
                return false;
            }
            var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
            var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();
            var lb_txt = 'labels';
            var free_roll_allowed = $('.free_roll_allowed').val();

            var no_of_rolls = $('#final_uploaded_rolls').val();


        } else {
            if (cartunitqty == 'labels') {
                var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                if (labels.length == 0) {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum " + labelpersheets + " labels are required ");
                    }
                    return false;
                }
                var sheets = parseInt(labels / labelpersheets);
                var lb_txt = 'labels';
            } else {
                var sheet_product_quality =  $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');

                var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
                if (sheets.length == 0) {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum 1 sheet required ");
                    }
                    return false;
                }
                var labels = parseInt(sheets * labelpersheets);
                var lb_txt = 'sheets';
            }
        }
        if (upload_artwork_radio == "upload_artwork_now") {
            if (file.length == 0) {
                alert_box("Please upload a file before saving. ");
            } else if (labels == 0 || labels == '') {
                alert_box("Please complete line ");
            } else if (artworkname.length == 0) {
                alert_box("please enter artwork name! ");
            } else {
                var press_proof = 0;
                if ($('#press_proof').is(":checked")) {
                    press_proof = 1;
                }
//get user selected element values
                var laminations_and_varnishes = [];
                var laminations_and_varnishes_childs = [];
                var i = 0;

                $('.emb_option:checked').each(function () {
                    //maintain user selected option array
                    laminations_and_varnishes[i] = $(this).data('embellishment_parsed_title');
                    laminations_and_varnishes_childs[i] = $(this).data('embellishment_parsed_title_child');
                    i++;
                });
                if (upload_artwork_radio == "upload_artwork_now") {

                    var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
                }
                var form_data = new FormData();
                if (upload_artwork_radio == "upload_artwork_now") {

                    form_data.append("file", uploadfile);
                }
                var digital_process_plus_white =  $('.digital_process_plus_white:checked').data('add_white');
                var label_application = $('#label_application').val();
                var edit_cart_flag = $("#edit_cart_flag").val();
                var temp_basket_id = $('#temp_basket_id').val();

                form_data.append("digital_process_plus_white", digital_process_plus_white);
                form_data.append("sheet_product_quality", sheet_product_quality);
                form_data.append("cartid", cartid);
                form_data.append("productid", prdid);
                form_data.append("labels", labels);
                form_data.append("sheets", sheets);
                form_data.append("artworkname", artworkname);
                form_data.append("persheet", labelpersheets);
                form_data.append("type", type);
                form_data.append("unitqty", cartunitqty);
                form_data.append("total_emb_plate_price", total_emb_plate_price);
                form_data.append("press_proof", press_proof);
                form_data.append("laminations_and_varnishes", laminations_and_varnishes);
                form_data.append("laminations_and_varnishes_childs", laminations_and_varnishes_childs);
                form_data.append("upload_artwork_radio", upload_artwork_radio);
                form_data.append("upload_artwork_option_radio", upload_artwork_option_radio);
                form_data.append("edit_cart_flag", edit_cart_flag);
                form_data.append("temp_basket_id", temp_basket_id);

                
                form_data.append("selected_already_plates_composite_array", JSON.stringify(selected_already_plates_composite_array));
                form_data.append("lines_to_populate", lines_to_populate);
                form_data.append("label_application", label_application);

                // console.log(type);
                if (upload_artwork_radio == "upload_artwork_now") {

                    type = uploadfile.type;
                    if (type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript') {
                        swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");
                        return false;
                    }
                }
                var type = $('#producttype' + prdid).val();
                // console.log("qty 4");
                var remaing = parseInt($('#upload_remaining_labels').val());
                // console.log("1");
                var designs_remain = parseInt($('#upload_remaining_designs').val());
                if (designs_remain < 1) {
                    form_data.append("limit_exceed_designs", 'yes');
                    var msg = 'You have entered extra designs, click here to update your basket.';
                } else {
                    form_data.append("limit_exceed_designs", 'no');
                }
                if (remaing < 0) {
                    form_data.append("limit_exceed_sheet", 'yes');
                    var msg = 'You have entered extra ' + lb_txt + ', click here to update your basket.';
                }
                if (no_of_rolls > free_roll_allowed) { console.log('I am here');
                    form_data.append("limit_exceed_sheet", 'yes');
                    var msg = 'You have entered extra ' + lb_txt + ', click here to update your basket.';
                }
                console.log(designs_remain);
                console.log(remaing);
                console.log(no_of_rolls);
                console.log(free_roll_allowed);
                console.log(msg+"====");

                if (remaing < 0 || (designs_remain < 1 && type != 'roll')) {
                    swal({
                            title: msg,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn orangeBg",
                            confirmButtonText: "Update Basket",
                            cancelButtonClass: "btn blueBg m-r-10",
                            cancelButtonText: "Cancel",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                upload_printing_artworks(form_data);
                            }
                        });
                } else {
                    upload_printing_artworks(form_data);
                }
            }
        } else {
            if (labels == 0 || labels == '') {
                alert_box("Please complete line ");
            } else if (artworkname.length == 0) {
                alert_box("please enter artwork name! ");
            } else {
                var press_proof = 0;
                if ($('#press_proof').is(":checked")) {
                    press_proof = 1;
                }
//get user selected element values
                var laminations_and_varnishes = [];
                var laminations_and_varnishes_childs = [];

                var i = 0;

                $('.emb_option:checked').each(function () {
                    //maintain user selected option array
                    laminations_and_varnishes[i] = $(this).data('embellishment_parsed_title');
                    laminations_and_varnishes_childs[i] = $(this).data('embellishment_parsed_title_child');
                    i++;
                });
                if (upload_artwork_radio == "upload_artwork_now") {

                    var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
                }
                var form_data = new FormData();
                if (upload_artwork_radio == "upload_artwork_now") {

                    form_data.append("file", uploadfile);
                }
                var digital_process_plus_white = $('.digital_process_plus_white:checked').data('add_white');
                var label_application = $('#label_application').val();

                form_data.append("digital_process_plus_white", digital_process_plus_white);
                var edit_cart_flag = $("#edit_cart_flag").val();
                var temp_basket_id = $('#temp_basket_id').val();
                form_data.append("sheet_product_quality", sheet_product_quality);
                form_data.append("upload_artwork_radio", upload_artwork_radio);
                form_data.append("upload_artwork_option_radio", upload_artwork_option_radio);
                form_data.append("lines_to_populate", lines_to_populate);
                form_data.append("cartid", cartid);
                form_data.append("productid", prdid);
                form_data.append("labels", labels);
                form_data.append("sheets", sheets);
                form_data.append("artworkname", artworkname);
                form_data.append("persheet", labelpersheets);
                form_data.append("type", type);
                form_data.append("unitqty", cartunitqty);
                form_data.append("total_emb_plate_price", total_emb_plate_price);
                form_data.append("press_proof", press_proof);
                form_data.append("edit_cart_flag", edit_cart_flag);
                form_data.append("temp_basket_id", temp_basket_id);
                
                form_data.append("laminations_and_varnishes", laminations_and_varnishes);
                form_data.append("laminations_and_varnishes_childs", laminations_and_varnishes_childs);
                form_data.append("selected_already_plates_composite_array", JSON.stringify(selected_already_plates_composite_array));
                form_data.append("label_application", label_application);

                // console.log(type);
                if (upload_artwork_radio == "upload_artwork_now") {

                    type = uploadfile.type;
                    if (type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript') {
                        swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");
                        return false;
                    }
                }
                var type = $('#producttype' + prdid).val();
                // console.log("qty 4");
                var remaing = parseInt($('#upload_remaining_labels').val());
                // console.log("1");
                var designs_remain = parseInt($('#upload_remaining_designs').val());
                if (designs_remain < 1) {
                    form_data.append("limit_exceed_designs", 'yes');
                    var msg = 'You have entered extra designs, click here to update your basket.';
                } else {
                    form_data.append("limit_exceed_designs", 'no');
                }
                if (remaing < 0) {
                    form_data.append("limit_exceed_sheet", 'yes');
                    var msg = 'You have entered extra ' + lb_txt + ', click here to update your basket.';
                }
                if (remaing < 0 || (designs_remain < 1 && type != 'roll')) {
                    swal({
                            title: msg,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn orangeBg",
                            confirmButtonText: "Update Basket",
                            cancelButtonClass: "btn blueBg m-r-10",
                            cancelButtonText: "Cancel",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                upload_printing_artworks(form_data);
                            }
                        });
                } else {
                    upload_printing_artworks(form_data);
                }
            }
        }

    });

    function progress(e) {
        if (e.lengthComputable) {
            var max = e.total;
            var current = e.loaded;
            var Percentage = Math.ceil((current * 100) / max);
            $("#progressbar").progressbar("option", "value", Percentage);
            $("#upload_pecentage").html(' &nbsp;' + Percentage + '%');
            if (Percentage >= 100) {
                $("#progressbar").progressbar("option", "value", 100);
                $("#upload_pecentage").html(' &nbsp;100%');
            }
        }
    }

    $(document).on("click", ".delete_artwork_file", function (event) {
        var id = $(this).attr('id');
        var additional_cost = $(this).data('additional_cost');
        var cartid = $('#cartid').val();

        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();

        var edit_cart_flag = $('#edit_cart_flag').val();
        var temp_basket_id = $('#temp_basket_id').val();
        swal({
                title: "Are you sure you want to delete this line",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn orangeBg",
                confirmButtonText: "Yes",
                cancelButtonClass: "btn blueBg m-r-10",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: mainUrl + 'ajax/delete_printing_artworks_label_emb',
                        type: "POST",
                        async: "false",
                        dataType: "html",
                        data: {
                            fileid: id,
                            cartid: cartid,
                            prdid: prdid,
                            persheet: labelpersheets,
                            type: type,
                            edit_cart_flag: edit_cart_flag,
                            temp_basket_id: temp_basket_id,
                            
                            unitqty: cartunitqty,
                            additional_cost: additional_cost,
                            upload_artwork_radio: upload_artwork_radio,
                            upload_artwork_option_radio: upload_artwork_option_radio
                        },
                        success: function (data) {
                            data = $.parseJSON(data);
                            if (!data == '') {
                                $('#ajax_upload_content').html(data.content);
                                intialize_progressbar();
                            }
                        }
                    });
                }
            })
    });

    $(document).on("click", ".add_another_art", function (e) {
        $('.upload_row').show();
        $(this).hide();
        $('#add_another_line').hide();
    });
    $(document).on("blur", ".roll_labels_input,input_label_p_roll ", function (e) {
        verify_labels_or_rolls_qty(this);
        $(this).parents('.upload_row').find('.quantity_updater').hide();
    });
    $(document).on("click", ".quantity_updater", function (e) {

        verify_labels_or_rolls_qty(this);
        $(this).parents('.upload_row').find('.quantity_updater').hide();
    });
    $(document).on("click", ".quantity_editor", function (e) {
        $(this).hide();
        $(this).parents('.upload_row').find('.quantity_labels').hide();
        $(this).parents('.upload_row').find('.input_rolls').show();
    });
    //backup function of 3 input of labels before my work
    // function verify_labels_or_rolls_qty(id) {
    //      var prdid = $('#cartproductid').val();
    //     var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
    //     var min_qty = parseInt($('#min_qty' + prdid).val());
    //     var min_rolls = parseInt($('#min_rolls' + prdid).val());
    //     var max_qty = parseInt($('#max_qty' + prdid).val());
    //     var dieacross = parseInt($('#min_rolls' + prdid).val());
    //     var minlabels = parseInt(min_qty / dieacross);
    //     var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
    //     var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());
    //     var perroll = parseFloat(total_labels / rolls);
    //     if (isFloat(perroll)) {
    //         perroll = Math.ceil(perroll);
    //     }
    //     var roll_text = 'roll';
    //     if (rolls > 1) {
    //         var roll_text = 'rolls';
    //     }
    //     if (!is_numeric(total_labels)) {
    //         //alert_box("Please enter number of labels ");
    //         var _this = $(id).parents('.upload_row').find('.roll_labels_input');
    //         show_faded_popover(_this, "Please enter number of labels.");
    //         $(id).parents('.upload_row').find('.roll_labels_input').val('');
    //         update_remaing_labels();
    //         return false;
    //     } else if (total_labels == 0) {
    //         //alert_box("Minimum Label quantity is "+minlabels+" Labels per roll.");
    //         var _this = $(id).parents('.upload_row').find('.roll_labels_input');
    //         show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
    //         $(id).parents('.upload_row').find('.roll_labels_input').val('');
    //         update_remaing_labels();
    //         return false;
    //     } else if (!is_numeric(rolls) || rolls == 0) {
    //         //alert_box("Minimum roll quantity is 1 roll.");
    //         var _this = $(id).parents('.upload_row').find('.input_rolls');
    //         show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
    //         $(id).parents('.upload_row').find('.input_rolls').val('');
    //         update_remaing_labels();
    //         return false;
    //     } else if (perroll < minlabels) {
    //         var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');
    //         if (roll_input_display == 'block') {
    //             var requiredlabels = minlabels * rolls
    //             //alert_box("Minimum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
    //             var _this = $(id).parents('.upload_row').find('.roll_labels_input');
    //             show_faded_popover(_this, "Quantity has been amended for production as " + requiredlabels + " Labels.");
    //             $(id).parents('.upload_row').find('.show_labels_per_roll').text(minlabels);
    //             $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
    //             update_remaing_labels();
    //             return false;
    //         } else {
    //             if (total_labels > labelspersheets) {
    //                 var expectedrolls = parseFloat(total_labels / labelspersheets);
    //                 if (isFloat(expectedrolls)) {
    //                     expectedrolls = Math.ceil(expectedrolls);
    //                 }
    //                 labelspersheets = parseInt(total_labels / expectedrolls);
    //                 var _this = $(id).parents('.upload_row').find('.input_rolls');
    //                 show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
    //                 //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
    //                 //alert_box(expectedrolls+" rolls are allowed on "+total_labels+" labels");
    //                 $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
    //                 $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
    //                 $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
    //                 update_remaing_labels();
    //                 return false;
    //             } else {
    //                 if (total_labels < minlabels) {
    //                     total_labels = minlabels;
    //                     var _this = $(id).parents('.upload_row').find('.roll_labels_input');
    //                     show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
    //                 } else {
    //                     var _this = $(id).parents('.upload_row').find('.roll_labels_input');
    //                     show_faded_popover(_this, "Quantity has been amended for production as 1 Roll.");
    //                 }
    //                 // alert_box("1 roll allowed on "+total_labels+" labels");
    //                 $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
    //                 $(id).parents('.upload_row').find('.quantity_labels').text(1);
    //                 $(id).parents('.upload_row').find('.input_rolls').val(1);
    //                 $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
    //                 update_remaing_labels();
    //                 return false;
    //             }
    //         }
    //     } else if (perroll > labelspersheets) {
    //         var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
    //         var total_labels = response['total_labels'];
    //         var expectedrolls = response['rolls'];
    //         var labelspersheets = parseInt(total_labels / expectedrolls);
    //         //var expectedrolls = parseFloat(total_labels/labelspersheets);
    //         //if(isFloat(expectedrolls)){  expectedrolls = Math.ceil(expectedrolls);}
    //         //total_labels = parseInt(labelspersheets*expectedrolls);
    //         var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
    //         show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
    //         //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
    //         $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
    //         $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
    //         $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
    //         $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
    //         update_remaing_labels();
    //         return false;
    //         /*var requiredlabels = labelspersheets*rolls
    // 			alert_box("Maximum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
    // 			$(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
    // 			$(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
    // 			update_remaing_labels();
    // 			return false;*/
    //     } else {
    //         var total_labels = parseInt(perroll) * parseInt(rolls);
    //         $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
    //         $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
    //         update_remaing_labels();
    //     }
    //     $(id).parents('.upload_row').find('.quantity_updater').hide();
    // }

    function verify_labels_or_rolls_qty(id) {
        // $(id).parents('.upload_row').find('.input_rolls').val()
        var current_input_selected_element = $(id).data('current-element');
        var prdid = $('#cartproductid').val();
        var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
        var min_qty = parseInt($('#min_qty' + prdid).val());
        // var min_rolls = parseInt($('#min_rolls' + prdid).val());
        var min_rolls = 1;
        var max_qty = parseInt($('#max_qty' + prdid).val());
        var dieacross = parseInt($('#min_rolls' + prdid).val());
        //for free(cost effective) option set minlabels as 100/6 = 16 labels if die across 6 and minimum label is 100
        if ((upload_artwork_option_radio) && upload_artwork_option_radio == "cost_effective") {
            var minlabels = parseInt(min_qty / dieacross);
        } else {
            //for 20 pound option user can get minimum 1 label also
            var minlabels = 1;
        }

        var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
        var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());

        var perroll = parseFloat(total_labels / rolls);
        if (isFloat(perroll)) {
            perroll = Math.ceil(perroll);
        }

        //Run for free cost effective options to calculate label/roll and num of rolls on the basis of total labels entered qty
        if ((upload_artwork_option_radio) && upload_artwork_option_radio == "cost_effective") {
            var roll_text = 'roll';
            if (rolls > 1) {
                var roll_text = 'rolls';
            }
            if (!is_numeric(total_labels)) {
                //alert_box("Please enter number of labels ");
                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Please enter number of labels.");
                $(id).parents('.upload_row').find('.roll_labels_input').val('');
                update_remaing_labels();
                return false;
            } else if (total_labels == 0) {
                //alert_box("Minimum Label quantity is "+minlabels+" Labels per roll.");
                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
                $(id).parents('.upload_row').find('.roll_labels_input').val('');
                update_remaing_labels();
                return false;
            } else if (!is_numeric(rolls) || rolls == 0) {
                //alert_box("Minimum roll quantity is 1 roll.");
                var _this = $(id).parents('.upload_row').find('.input_rolls');
                show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
                $(id).parents('.upload_row').find('.input_rolls').val('');
                update_remaing_labels();
                return false;
            } else if (perroll < minlabels) {
                var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');
                if (roll_input_display == 'block') {
                    var requiredlabels = minlabels * rolls;
                    //alert_box("Minimum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                    show_faded_popover(_this, "Quantity has been amended for production as " + requiredlabels + " Labels.");
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(minlabels);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                    update_remaing_labels();
                    return false;
                } else {
                    if (total_labels > labelspersheets) {
                        var expectedrolls = parseFloat(total_labels / labelspersheets);
                        if (isFloat(expectedrolls)) {
                            expectedrolls = Math.ceil(expectedrolls);
                        }
                        labelspersheets = parseInt(total_labels / expectedrolls);
                        var _this = $(id).parents('.upload_row').find('.input_rolls');
                        show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                        //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                        //alert_box(expectedrolls+" rolls are allowed on "+total_labels+" labels");
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                        $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                        $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                        update_remaing_labels();
                        return false;
                    } else {
                        if (total_labels < minlabels) {
                            total_labels = minlabels;
                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                        } else {
                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            show_faded_popover(_this, "Quantity has been amended for production as 1 Roll.");
                        }
                        // alert_box("1 roll allowed on "+total_labels+" labels");
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
                        $(id).parents('.upload_row').find('.quantity_labels').text(1);
                        $(id).parents('.upload_row').find('.input_rolls').val(1);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                        update_remaing_labels();
                        return false;
                    }
                }
            } else if (perroll > labelspersheets) {
                var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
                var total_labels = response['total_labels'];
                var expectedrolls = response['rolls'];
                var labelspersheets = parseInt(total_labels / expectedrolls);
                //var expectedrolls = parseFloat(total_labels/labelspersheets);
                //if(isFloat(expectedrolls)){  expectedrolls = Math.ceil(expectedrolls);}
                //total_labels = parseInt(labelspersheets*expectedrolls);
                var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
                show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
                //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                update_remaing_labels();
                return false;
                /*var requiredlabels = labelspersheets*rolls
                    alert_box("Maximum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                    update_remaing_labels();
                    return false;*/
            } else {
                var total_labels = parseInt(perroll) * parseInt(rolls);
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                update_remaing_labels();
            }
            $(id).parents('.upload_row').find('.quantity_updater').hide();
        }
        //run for 20 pound paid option to calculate user desired label/roll,no of labels & no of rolls
        else if ((upload_artwork_option_radio) && upload_artwork_option_radio == "custom_roll_and_label") {
            //get value of label/roll input field
            var input_label_p_roll = parseInt($(id).parents('.upload_row').find('.input_label_p_roll').val());
            //set perroll qty if user added qty in this input field
            if (is_numeric(input_label_p_roll) || input_label_p_roll == 0) {
                if (input_label_p_roll == 0) {
                    //alert_box("Minimum Label quantity is "+minlabels+" Labels per roll.");
                    var _this = $(id).parents('.upload_row').find('.input_label_p_roll');
                    show_faded_popover(_this, "Minimum Label/Roll quantity is " + minlabels + " Labels per roll.");
                    $(id).parents('.upload_row').find('.roll_labels_input').val('');
                    update_remaing_labels();
                    return false;
                } else {
                    var perroll = parseFloat(input_label_p_roll);
                    if (isFloat(perroll)) {
                        perroll = Math.ceil(perroll);
                    }
                }

            }

            // var total_labels = parseFloat(perroll * rolls);
            // if (isFloat(total_labels)) {
            //     total_labels = Math.ceil(total_labels);
            // }
            // alert(total_labels);
            //make calculation scenarios when user enter value in no of labels field
            if (current_input_selected_element == "input_no_of_labels") {

                var perroll = parseFloat(total_labels / rolls);
                if (isFloat(perroll)) {
                    perroll = Math.ceil(perroll);
                }


                var roll_text = 'roll';
                if (rolls > 1) {
                    var roll_text = 'rolls';
                }
                if (!is_numeric(total_labels)) {
                    //alert_box("Please enter number of labels ");
                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                    show_faded_popover(_this, "Please enter number of labels.");
                    $(id).parents('.upload_row').find('.roll_labels_input').val('');
                    update_remaing_labels();
                    return false;
                } else if (total_labels == 0) {
                    //alert_box("Minimum Label quantity is "+minlabels+" Labels per roll.");
                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                    show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
                    $(id).parents('.upload_row').find('.roll_labels_input').val('');
                    update_remaing_labels();
                    return false;
                } else if (!is_numeric(rolls) || rolls == 0) {
                    //alert_box("Minimum roll quantity is 1 roll.");
                    var _this = $(id).parents('.upload_row').find('.input_rolls');
                    show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
                    $(id).parents('.upload_row').find('.input_rolls').val('');
                    update_remaing_labels();
                    return false;
                } else if (perroll < minlabels) {
                    var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');
                    if (roll_input_display == 'block') {
                        var requiredlabels = minlabels * rolls;
                        //alert_box("Minimum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                        var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                        show_faded_popover(_this, "Quantity has been amended for production as " + requiredlabels + " Labels.");
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(minlabels);
                        $(id).parents('.upload_row').find('.input_label_p_roll').val(minlabels);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                        update_remaing_labels();
                        return false;
                    } else {
                        if (total_labels > labelspersheets) {
                            var expectedrolls = parseFloat(total_labels / labelspersheets);
                            if (isFloat(expectedrolls)) {
                                expectedrolls = Math.ceil(expectedrolls);
                            }
                            labelspersheets = parseInt(total_labels / expectedrolls);
                            var _this = $(id).parents('.upload_row').find('.input_rolls');
                            show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                            //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                            //alert_box(expectedrolls+" rolls are allowed on "+total_labels+" labels");
                            $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                            $(id).parents('.upload_row').find('.input_label_p_roll').val(labelspersheets);
                            $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                            $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                            update_remaing_labels();
                            return false;
                        } else {
                            if (total_labels < minlabels) {
                                total_labels = minlabels;
                                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                                show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                            } else {
                                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                                show_faded_popover(_this, "Quantity has been amended for production as 1 Roll.");
                            }
                            // alert_box("1 roll allowed on "+total_labels+" labels");
                            $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
                            $(id).parents('.upload_row').find('.input_label_p_roll').val(total_labels);
                            $(id).parents('.upload_row').find('.quantity_labels').text(1);
                            $(id).parents('.upload_row').find('.input_rolls').val(1);
                            $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                            update_remaing_labels();
                            return false;
                        }
                    }
                } else if (perroll > labelspersheets) {
                    var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
                    var total_labels = response['total_labels'];
                    var expectedrolls = response['rolls'];
                    var labelspersheets = parseInt(total_labels / expectedrolls);
                    //var expectedrolls = parseFloat(total_labels/labelspersheets);
                    //if(isFloat(expectedrolls)){  expectedrolls = Math.ceil(expectedrolls);}
                    //total_labels = parseInt(labelspersheets*expectedrolls);
                    var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
                    show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
                    //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.input_label_p_roll').val(labelspersheets);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                    $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                    update_remaing_labels();
                    return false;
                    /*var requiredlabels = labelspersheets*rolls
                        alert_box("Maximum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                        update_remaing_labels();
                        return false;*/
                } else {
                    var total_labels = parseInt(perroll) * parseInt(rolls);
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                    $(id).parents('.upload_row').find('.input_label_p_roll').val(perroll);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    update_remaing_labels();
                }
                $(id).parents('.upload_row').find('.quantity_updater').hide();

            }
            //make calculation scenarios when user enter value in labels per roll field

            else if (current_input_selected_element == "input_label_p_roll") {
                var roll_text = 'roll';
                if (rolls > 1) {
                    var roll_text = 'rolls';
                }
                if (!is_numeric(rolls) || rolls == 0) {
                    //alert_box("Minimum roll quantity is 1 roll.");
                    var _this = $(id).parents('.upload_row').find('.input_rolls');
                    show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
                    $(id).parents('.upload_row').find('.input_rolls').val('');
                    update_remaing_labels();
                    return false;
                }


                //   else if (perroll < minlabels) {
                //     var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');
                //     if (roll_input_display == 'block') {
                //         var requiredlabels = minlabels * rolls;
                //         //alert_box("Minimum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                //         var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                //         show_faded_popover(_this, "Quantity has been amended for production as " + requiredlabels + " Labels.");
                //         $(id).parents('.upload_row').find('.show_labels_per_roll').text(minlabels);
                //         $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                //         update_remaing_labels();
                //         return false;
                //     } else {
                //         if (total_labels > labelspersheets) {
                //             var expectedrolls = parseFloat(total_labels / labelspersheets);
                //             if (isFloat(expectedrolls)) {
                //                 expectedrolls = Math.ceil(expectedrolls);
                //             }
                //             labelspersheets = parseInt(total_labels / expectedrolls);
                //             var _this = $(id).parents('.upload_row').find('.input_rolls');
                //             show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                //             //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                //             //alert_box(expectedrolls+" rolls are allowed on "+total_labels+" labels");
                //             $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                //             $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                //             $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                //             update_remaing_labels();
                //             return false;
                //         } else {
                //             if (total_labels < minlabels) {
                //                 total_labels = minlabels;
                //                 var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                //                 show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                //             } else {
                //                 var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                //                 show_faded_popover(_this, "Quantity has been amended for production as 1 Roll.");
                //             }
                //             // alert_box("1 roll allowed on "+total_labels+" labels");
                //             $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
                //             $(id).parents('.upload_row').find('.quantity_labels').text(1);
                //             $(id).parents('.upload_row').find('.input_rolls').val(1);
                //             $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                //             update_remaing_labels();
                //             return false;
                //         }
                //     }
                // }

                else if (perroll > labelspersheets) {
                    var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);

                    //  var rolls = parseFloat(parseInt(perroll) / labelspersheets);
                    // if (isFloat(rolls)) {
                    //     rolls = Math.ceil(rolls);
                    // }
                    var perroll = labelspersheets;
                    if (isFloat(perroll)) {
                        perroll = Math.ceil(perroll);
                    }

                    var total_labels = parseFloat(parseInt(perroll) * rolls);
                    if (isFloat(total_labels)) {
                        total_labels = Math.ceil(total_labels);
                    }

                    // var total_labels = response['total_labels'];
                    var expectedrolls = rolls;
                    var labelspersheets = perroll;
                    //var expectedrolls = parseFloat(total_labels/labelspersheets);
                    //if(isFloat(expectedrolls)){  expectedrolls = Math.ceil(expectedrolls);}
                    //total_labels = parseInt(labelspersheets*expectedrolls);
                    var infotxt = 'Quantity has been amended for production as ' + labelspersheets + ' labels/roll and ' + total_labels + ' labels';
                    show_faded_popover($(id).parents('.upload_row').find('.input_label_p_roll'), infotxt);
                    //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.input_label_p_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.input_label_p_roll').val(labelspersheets);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    // $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                    $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                    update_remaing_labels();
                    return false;
                    /*var requiredlabels = labelspersheets*rolls
                        alert_box("Maximum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                        update_remaing_labels();
                        return false;*/
                } else {
                    var rolls = parseInt(total_labels) / parseInt(perroll);
                    if (isFloat(rolls)) {
                        rolls = Math.ceil(rolls);
                    }

                    var total_labels = parseInt((perroll * rolls));
                    var infotxt = 'Quantity has been amended for production as ' + perroll + ' labels/roll and ' + rolls + ' rolls';
                    show_faded_popover($(id).parents('.upload_row').find('.input_label_p_roll'), infotxt);
                    // var total_labels = parseInt(perroll) * parseInt(rolls);
                    $(id).parents('.upload_row').find('.input_rolls').val(rolls);
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    update_remaing_labels();
                }
                $(id).parents('.upload_row').find('.quantity_updater').hide();
            }
            //make calculation scenarios when user enter value in no of rolls field
            //calculate on the basis of no of labels will same and calculate label/roll and no of rolls

            else if (current_input_selected_element == "input_no_of_rolls") {

                var perroll = parseFloat(total_labels / rolls);
                if (isFloat(perroll)) {
                    perroll = Math.ceil(perroll);
                }
                var roll_text = 'roll';
                if (rolls > 1) {
                    var roll_text = 'rolls';
                }
                if (!is_numeric(total_labels)) {
                    //alert_box("Please enter number of labels ");
                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                    show_faded_popover(_this, "Please enter number of labels.");
                    $(id).parents('.upload_row').find('.roll_labels_input').val('');
                    update_remaing_labels();
                    return false;
                } else if (total_labels == 0) {
                    //alert_box("Minimum Label quantity is "+minlabels+" Labels per roll.");
                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                    show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
                    $(id).parents('.upload_row').find('.roll_labels_input').val('');
                    update_remaing_labels();
                    return false;
                } else if (!is_numeric(rolls) || rolls == 0) {
                    //alert_box("Minimum roll quantity is 1 roll.");
                    var _this = $(id).parents('.upload_row').find('.input_rolls');
                    show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
                    $(id).parents('.upload_row').find('.input_rolls').val('');
                    update_remaing_labels();
                    return false;
                } else if (perroll > labelspersheets) {
// alert("gfdfdg");
                    var perroll = labelspersheets;
                    if (isFloat(perroll)) {
                        perroll = Math.ceil(perroll);
                    }

                    var rolls = parseFloat((total_labels) / perroll);
                    if (isFloat(rolls)) {
                        rolls = Math.ceil(rolls);
                    }

                    var perroll = parseFloat((total_labels) / rolls);
                    if (isFloat(perroll)) {
                        perroll = Math.ceil(perroll);
                    }
                    var total_labels = parseFloat(parseInt(perroll) * rolls);
                    if (isFloat(total_labels)) {
                        total_labels = Math.ceil(total_labels);
                    }


                    // var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
                    var total_labels = total_labels;
                    var expectedrolls = rolls;
                    var labelspersheets = perroll;
                    //var expectedrolls = parseFloat(total_labels/labelspersheets);
                    //if(isFloat(expectedrolls)){  expectedrolls = Math.ceil(expectedrolls);}
                    //total_labels = parseInt(labelspersheets*expectedrolls);
                    var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + labelspersheets + ' labels/roll';
                    show_faded_popover($(id).parents('.upload_row').find('.input_rolls'), infotxt);
                    //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.input_label_p_roll').val(labelspersheets);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                    $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                    update_remaing_labels();
                    return false;
                    /*var requiredlabels = labelspersheets*rolls
                        alert_box("Maximum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                        update_remaing_labels();
                        return false;*/
                } else {
                    var total_labels = parseInt(perroll) * parseInt(rolls);

                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                    $(id).parents('.upload_row').find('.input_label_p_roll').val(perroll);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    update_remaing_labels();
                }
                $(id).parents('.upload_row').find('.quantity_updater').hide();
            }


        }


    }


    function update_remaing_labels() {
        var actual_qty = $('#actual_labels_qty').val();
        var total_qty = 0;
        $(".roll_labels_input").each(function (index) {
            if ($(this).val()) {
                total_qty = parseInt(total_qty) + parseInt($(this).val());
            }
        });
        // console.log("before qty 2");

        if (total_qty != 'NaN') {
            var prdid = $('#cartproductid').val();
            var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
            var reaming = parseInt(actual_qty) - parseInt(total_qty);
            if (reaming < 0) {
                $('.remaing_user_sheets').html('0');
                $('.remaing_user_labels').html('0');
            } else {
                $('.remaing_user_sheets').html(reaming);
                $('.remaing_user_labels').html(reaming * labelspersheets);
            }
            // console.log(" qty 2");

            $('#upload_remaining_labels').val(reaming);
            // console.log('Actual: ' + actual_qty);
            // console.log('Remaing: ' + reaming);
        }

    }


    function rolls_calculation(die_across, max_labels, total_labels, rolls) {
        if (rolls == 0) {
            rolls = parseInt(die_across);
        } else {
            rolls = parseInt(rolls) + parseInt(die_across);
        }
        var per_roll = parseFloat(parseInt(total_labels) / rolls);
        if (per_roll > parseInt(max_labels)) {
            response = rolls_calculation(die_across, max_labels, total_labels, rolls);
            per_roll = response['per_roll'];
            rolls = response['rolls'];
        }
        var data = {per_roll: Math.ceil(per_roll), total_labels: Math.ceil(per_roll) * rolls, rolls: rolls};
        return data;
    }

    //already copied
    function show_faded_popover(_this, text) {
        $(_this).attr('data-content', '');
        $(_this).popover('hide');
        $(_this).popover('destroy');
        $(_this).popover({'placement': 'top'});
        $(_this).attr('data-content', text);
        $(_this).popover('show');
        clearTimeout(timer);
        timer = setTimeout(function () {
            $(_this).attr('data-content', '');
            $(_this).popover('hide');
            $(_this).popover('destroy');
        }, 5000);
    }


    function upload_printing_artworks(form_data) {
        $('#cart_summery_loader').show();
        
        $.ajax({
            url: mainUrl + 'ajax/material_upload_printing_artworks_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            beforeSend: function () {
                intialize_progressbar();
                $("#upload_pecentage").html(' &nbsp;0%');
                $("#upload_progress").show();
                $('.save_artwork_file').prop('disabled', true);
            },
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', progress, false);
                }
                return myXhr;
            },
            error: function (data) {
                swal('Some error occured please try again');
                intialize_progressbar();
                $("#upload_progress").hide();
                $('.save_artwork_file').prop('disabled', false);
            },
            success: function (data) {
                $('.save_artwork_file').prop('disabled', false);
                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    $('#ajax_upload_content').html(data.content);
                    if (data.cart_summery != '' && data.cart_summery != null) {
                        $('#cart_summery').html(data.cart_summery);
                        // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        // $('#cal_btn'+prdid).click();
                    }
                    intialize_progressbar();
                    $("#upload_progress").hide();
                    $('#cart_summery_loader').hide();
                    $('#a4_material_selection').css('margin-top', '-217px');
                    $('.save_and_close_popup_checks').attr('data-dismiss', 'modal');

                } else {
                    swal('upload failed', data.message, 'error');
                    intialize_progressbar();
                    $("#upload_progress").hide();
                    $('.save_artwork_file').prop('disabled', false);
                }
            }
        });
    }


    //$(document).on("click", ".proceed_to_checkout", function (e) {
    //    var prdid = $('#cartproductid').val();
    //    var upload_option = $('input[name=upload_option]:checked').val();
    //    var type = $('#producttype' + prdid).val();
    //    var labelpersheets = $('#labels_p_sheet' + prdid).val();
    //    var cartunitqty = $('#cartunitqty').val();
    //    if (type == 'roll') {
    //        var remaing = parseInt($('#upload_remaining_labels').val());
    //        var msg_text = 'labels';
    //        var uploaded_sheets = parseInt($('#final_uploaded_rolls').val());
    //        var uploaded_labels = parseInt($('#final_uploaded_labels').val());
    //        var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Rolls\n';
    //    } else {
    //        var actual_sheets = parseInt($('#actual_sheets').val());
    //        var uploaded_sheets = parseInt($('#uploaded_sheets').val());
    //        var uploaded_labels = parseInt(uploaded_sheets * labelpersheets);
    //        var remaing = actual_sheets - uploaded_sheets;
    //        var msg_text = 'sheets';
    //        if (cartunitqty == 'labels') {
    //            var msg_text = 'labels';
    //        }
    //        var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Sheets\n';
    //    }
    //    var remaing_designs = parseInt($('#upload_remaining_designs').val());
    //    var designservice = $('input[name=print_designservice]:checked').val();
    //    var exceed = '';
    //    //var message = 'Do you want to continue without uploading artworks.?';
    //    var message = 'Have you uploaded all your artworks.?';
    //    var actual_designs = parseInt($('#actual_designs_qty').val());
    //    if ($('.UploadMainSelection').css('display') == 'block' && upload_option != 'email_artwork') {
    //        alert_box("Please click to  Proceed before checkout ");
    //        return false;
    //    } else if (upload_option == 'design_services' && typeof designservice == 'undefined') {
    //        alert_box("Please select no of design against design service");
    //        return false;
    //    } else if (type == 'sheet' && uploaded_sheets < 25 && upload_option == 'upload_artwork') {
    //        var minqty = 25;
    //        if (cartunitqty == 'labels') {
    //            var minqty = 25 * parseInt(labelpersheets);
    //        }
    //        alert_box("Minimum " + minqty + " " + cartunitqty + " required, please adjust remaining sheets in your artworks");
    //        return false;
    //    } else if (actual_designs == remaing_designs && upload_option == 'upload_artwork') {
    //        alert_box("Please upload your artworks before proceeding to checkout ");
    //        return false;
    //    } else if ($('.uploadsavesection').css('display') == 'table-row' && upload_option == 'upload_artwork') {
    //        swal({
    //                title: 'Please complete  or delete the incomplete line.',
    //                type: "warning",
    //                showCancelButton: true,
    //                confirmButtonClass: "btn orangeBg",
    //                confirmButtonText: "Continue",
    //                cancelButtonClass: "btn blueBg m-r-10",
    //                cancelButtonText: "Delete",
    //                closeOnConfirm: true,
    //                closeOnCancel: true
    //            },
    //            function (isConfirm) {
    //                if (isConfirm) {
    //                    return false;
    //                } else {
    //                    $('.uploadsavesection').hide();
    //                    $('#add_another_line').show();
    //                    $('.add_another_art').show();
    //                    return false;
    //                }
    //            });
    //        //alert_box("Please complete the file upload process to continue.");
    //        //return false;
    //    } else {
    //
    //        var showArtWorkMessage = true;
    //        if($('.upload_artwork:visible').length == 0) {
    //            showArtWorkMessage = false;
    //        }
    //
    //        if ( upload_option == 'email_artwork' || upload_option == 'design_services' ) {
    //
    //            if( showArtWorkMessage )
    //            {
    //                swal({
    //                        title: 'Do you want to continue without uploading artworks?',
    //                        type: "warning",
    //                        showCancelButton: true,
    //                        confirmButtonClass: "btn orangeBg",
    //                        confirmButtonText: "No",
    //                        cancelButtonClass: "btn blueBg m-r-10",
    //                        cancelButtonText: "Yes",
    //                        closeOnConfirm: true,
    //                        closeOnCancel: true
    //                    },
    //                    function (isConfirm) {
    //                        if (isConfirm) {
    //                            console.log('cancel');
    //                        } else {
    //                            add_to_car_product();
    //                        }
    //                    });
    //            } else {
    //                swal({
    //                        title: 'Are you sure to continue with custom Design Service?',
    //                        type: "warning",
    //                        showCancelButton: true,
    //                        confirmButtonClass: "btn orangeBg",
    //                        confirmButtonText: "No",
    //                        cancelButtonClass: "btn blueBg m-r-10",
    //                        cancelButtonText: "Yes",
    //                        closeOnConfirm: true,
    //                        closeOnCancel: true
    //                    },
    //                    function (isConfirm) {
    //                        if (isConfirm) {
    //                            console.log('cancel');
    //                        } else {
    //                            add_to_car_product();
    //                        }
    //                    });
    //            }
    //
    //
    //
    //        } else if ((remaing > 0 || remaing_designs > 0) && upload_option == 'upload_artwork') {
    //            if (remaing > 0) {
    //                var text = msg_text;
    //            } else {
    //                var text = 'designs';
    //            }
    //            swal({
    //                    title: 'You have reduced the number of ' + text + ' please confirm to recalculate the price.',
    //                    type: "warning",
    //                    showCancelButton: true,
    //                    confirmButtonClass: "btn orangeBg",
    //                    confirmButtonText: "Confirm",
    //                    cancelButtonClass: "btn blueBg m-r-10",
    //                    cancelButtonText: "Cancel",
    //                    closeOnConfirm: true,
    //                    closeOnCancel: true
    //                },
    //                function (isConfirm) {
    //                    if (isConfirm) {
    //                        update_cart_with_upload();
    //                    }
    //                });
    //        } else {
    //            //Have you uploaded all your artworks?
    //            var summary_price = $('.summary_price:eq(1)').text();
    //            var artwork_text = actual_designs + ' Artworks uploaded\n';
    //            var total_price_text = "Total £" + summary_price + "\n <?//=vatoption?>//. VAT\n";
    //            var free_delivery_text = ' Free Delivery.';
    //            var finaltext = artwork_text + '' + lables_qty_text + '' + total_price_text + '' + free_delivery_text;
    //            swal({
    //                    title: finaltext,
    //                    type: "",
    //                    showCancelButton: true,
    //                    confirmButtonClass: "btn orangeBg m-t-10",
    //                    confirmButtonText: "Continue to Checkout",
    //                    cancelButtonClass: "btn blueBg m-r-10 m-t-10",
    //                    cancelButtonText: "Upload Further Artworks",
    //                    closeOnConfirm: true,
    //                    closeOnCancel: true
    //                },
    //                function (isConfirm) {
    //                    if (isConfirm) {
    //                        add_to_car_product();
    //                    }
    //                });
    //        }
    //    }
    //});


    function update_cart_with_upload() {
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        var press_proof = 0;
        if ($('#press_proof').is(":checked")) {
            press_proof = 1;
        }
//get user selected element values
        var laminations_and_varnishes = [];
        var laminations_and_varnishes_childs = [];
        var i = 0;

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i] = $(this).data('embellishment_parsed_title');
            laminations_and_varnishes_childs[i] = $(this).data('embellishment_parsed_title_child');
            i++;
        });
        if (type == 'sheet') {
            var sheet_product_quality =  $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');

        }
        var digital_process_plus_white =  $('.digital_process_plus_white:checked').data('add_white');
        var label_application = $('#label_application').val();
        var edit_cart_flag = $("#edit_cart_flag").val();
        var temp_basket_id = $('#temp_basket_id').val();

        $('#cart_summery_loader').show();
        $.ajax({
            url: mainUrl + 'ajax/material_update_cart_with_upload_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                label_application: label_application,
                combination_base: combination_base,
                digital_process_plus_white: digital_process_plus_white,
                sheet_product_quality: sheet_product_quality,
                cartid: cartid,
                prdid: prdid,
                persheet: labelpersheets,
                type: type,
                edit_cart_flag: edit_cart_flag,
                temp_basket_id: temp_basket_id,
                
                
                unitqty: cartunitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
                laminations_and_varnishes_childs: laminations_and_varnishes_childs,
                selected_already_plates_composite_array: selected_already_plates_composite_array,
                upload_artwork_radio: upload_artwork_radio,
                upload_artwork_option_radio: upload_artwork_option_radio,
                lines_to_populate: lines_to_populate
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    $('#cart_summery').html(data.cart_summery);
                    $('#ajax_upload_content').html(data.content);

                    intialize_progressbar();
                    $('.save_and_close_popup_checks').attr('data-dismiss', 'modal');

                }
                $('#cart_summery_loader').hide();
                $('#a4_material_selection').css('margin-top', '-217px');

            }

        });
    }


    function show_loader(top, left) {
        // $('.loading-gif').css('top', top + '%');``
        // $('.loading-gif').css('left', left + '%');
        $('#aa_loader').show();
    }

    var checkoutconfirm = false;

    function add_to_car_product() {
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var edit_cart_flag = $('#edit_cart_flag').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var actual_qty = parseInt($('#sheet_qty_' + prdid).val());
        var coresize = $('#label_coresize').val();
        var woundoption = $('#woundoption').val();
        var orientation = $('#label_orientation').val();
        var desingsservice = $('input[name=print_designservice]:checked').val();
        var comments = $('#comments').val();
        var uploadfile = $('#desingservice_artwork_file')[0].files[0];
        if (upload_artwork_radio ==  "upload_artwork_now") {
            var upload_option = "upload_artwork";
        } else if (upload_artwork_radio ==  "artwork_to_follow") {
            var  upload_option = "email_artwork";
        }
        // var upload_option = $('input[name=upload_option]:checked').val();
        var form_data = new FormData();
        form_data.append("cartid", cartid);
        form_data.append("prdid", prdid);
        form_data.append("actual", actual_qty);
        form_data.append("coresize", coresize);
        form_data.append("woundoption", woundoption);
        form_data.append("orientation", orientation);
        form_data.append("edit_cart_flag", edit_cart_flag);
        form_data.append("upload_option", upload_option);
        form_data.append("persheet", labelpersheets);
        form_data.append("comments", comments);
        form_data.append("desingsservice", desingsservice);
        if (upload_option == 'design_services' && typeof uploadfile != 'undefined') {
            var filetype = uploadfile.type;
            if (filetype != 'image/png' && filetype != 'image/jpg' && filetype != 'image/gif' && filetype != 'image/jpeg' && filetype != 'application/pdf' && filetype != 'application/postscript') {
                swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");
                return false;
            }
            form_data.append("file", uploadfile);
        }
        show_loader('80', '27');
        $.ajax({
            url: mainUrl + 'ajax/add_printing_tocart_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data) {
                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    ecommerce_add_to_cart();
                    checkoutconfirm = true;
                    window.location.href = '<?php echo SAURL ?>order_quotation/order/index';
                    $('#aa_loader').hide();
                }
            }
        });
    }

    function ecommerce_add_to_cart() {
        <? if(SITE_MODE == 'live'){ ?>
        var prdid = $('#cartproductid').val();
        var quantity = parseInt($('#sheet_qty_' + prdid).val());
        var type = $('#producttype' + prdid).val();
        var price = parseFloat($('.summary_price').text());
        if (type == 'sheet') {
            var category = 'Printed A4 Sheets';
            var product_name = $.trim($('.a4_sheets_block').find('.title > b').text());
        } else {
            var category = 'Printed Roll Labels';
            var product_name = $.trim($('.roll_sheets_block').find('.title > b').text());
        }
        dataLayer.push({
            'event': 'addToCart',
            'ecommerce': {
                'add': {
                    'products': [{
                        'name': product_name,
                        'id': prdid,
                        'price': price,
                        'brand': 'AALABELS',
                        'category': category,
                        'quantity': quantity,
                    }]
                }
            }
        });
        <? } ?>
    }

    var old_labels_input;
    var old_roll_labels_input;
    var old_roll_input;
    var old_label_p_roll_input;
    $(document).on("focus", ".labels_input", function (e) {
        old_labels_input = $(this).val();
    });
    $(document).on("focus", ".roll_labels_input", function (e) {
        old_roll_labels_input = $(this).val();
    });

    $(document).on("focus", ".input_label_p_roll", function (e) {
        old_label_p_roll_input = $(this).val();
    });
    $(document).on("focus", ".input_rolls", function (e) {
        old_roll_input = $(this).val();
    });
    $(document).on("keypress keyup blur", ".labels_input", function (e) {
        if ($(this).val() != old_labels_input) {
            $(this).parents('.upload_row').find('.sheet_updater').show();
        }
    });
    $(document).on("keypress keyup blur", ".roll_labels_input", function (e) {
        var rolls = $(this).parents('.upload_row').find('.input_rolls').val();
        if ($(this).val() != old_roll_labels_input && rolls.length > 0) {
            $(this).parents('.upload_row').find('.roll_updater').show();
            $(this).parents('.upload_row').find('.no_of_labels_field').show();
        }
    });
    //my code to apply update functionality on label/roll
    $(document).on("keypress keyup blur", ".input_label_p_roll", function (e) {
        var rolls = $(this).parents('.upload_row').find('.input_rolls').val();
        if ($(this).val() != old_label_p_roll_input && rolls.length > 0) {
            $(this).parents('.upload_row').find('.roll_updater').show();
            $(this).parents('.upload_row').find('.labels_per_roll_field').show();
        }
    });
    $(document).on("keypress keyup blur", ".input_rolls", function (e) {
        var labels = $(this).parents('.upload_row').find('.roll_labels_input').val();
        if ($(this).val() != old_roll_input && labels.length > 0) {
            $(this).parents('.upload_row').find('.roll_updater').show();
            $(this).parents('.upload_row').find('.no_of_rolls_field').show();
        }
    });
    $(document).on("click", ".roll_updater,.sheet_updater", function (event) {
        var id = $(this).attr('data-id');
        var _this = this;
        // var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        if (type == 'roll') {
            var response = verify_labels_or_rolls_qty(_this);
            if (response == false) {
                return false;
            }
            var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
            var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();
        } else {
            var sheet_product_quality =  $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');

            if (cartunitqty == 'labels') {
                var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                if (labels.length == 0 || labels == 0 || labels == '') {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum " + labelpersheets + " labels are required ");
                    }
                    return false;
                }
                var sheets = parseInt(labels / labelpersheets);
            } else {
                var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
                if (sheets.length == 0 || sheets == 0 || sheets == '') {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum 1 sheet required ");
                    }
                    return false;
                }
                var labels = parseInt(sheets * labelpersheets);
            }
            /*if(cartunitqty == 'labels'){
							var labels = $(_this).parents('.upload_row').find('.labels_input').val();
							var sheets = parseInt(labels/labelpersheets);
						}else{
								var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
								var labels = parseInt(sheets*labelpersheets);
						}*/
        }

        var press_proof = 0;
        if ($('#press_proof').is(":checked")) {
            press_proof = 1;
        }
//get user selected element values
        var laminations_and_varnishes = [];
        var laminations_and_varnishes_childs = [];
        var i = 0;

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i] = $(this).data('embellishment_parsed_title');
            laminations_and_varnishes_childs[i] = $(this).data('embellishment_parsed_title_child');
            i++;
        });
        var digital_process_plus_white =  $('.digital_process_plus_white:checked').data('add_white');

        // console.log("before qty 3");
        var label_application = $('#label_application').val();

        var remaing = parseInt($('#upload_remaining_labels').val());
        // alert(remaing);
        var exceed = '';
        if (remaing < 0) {
            exceed = 'yes';
        }
        $('#cart_summery_loader').show();
        
        var edit_cart_flag = $("#edit_cart_flag").val();
        var temp_basket_id = $('#temp_basket_id').val();
        
        var upload_artwork_radio = $('input[name="upload_artwork_2"]:checked').val();
        var upload_artwork_option_radio = $('input[name="upload_artwork_option_2"]:checked').val();

        
        $.ajax({
            url: mainUrl + 'ajax/material_update_printing_artworks_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                digital_process_plus_white: digital_process_plus_white,
                label_application: label_application,
                combination_base: combination_base,
                sheet_product_quality: sheet_product_quality,
                id: id,
                cartid: cartid,
                productid: prdid,
                labels: labels,
                sheets: sheets,
                persheet: labelpersheets,
                edit_cart_flag : edit_cart_flag,
                temp_basket_id : temp_basket_id,

                type: type,
                limit_exceed_sheet: exceed,
                updater: 'update',
                unitqty: cartunitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
                laminations_and_varnishes_childs: laminations_and_varnishes_childs,
                selected_already_plates_composite_array: selected_already_plates_composite_array,
                upload_artwork_radio: upload_artwork_radio,
                upload_artwork_option_radio: upload_artwork_option_radio,
                lines_to_populate: lines_to_populate
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (!data == '') {
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                    if (data.cart_summery != '' && data.cart_summery != null) {
                        $('#cart_summery').html(data.cart_summery);
                        var prdid = $('#cartproductid').val();
                        // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        //$('#cal_btn'+prdid).click();
                        $('.save_and_close_popup_checks').attr('data-dismiss', 'modal');

                    }
                    $('#cart_summery_loader').hide();
                    $('#a4_material_selection').css('margin-top', '-217px');


                }
            }
        });
    });

    function clear_uploaded_artworks(remove_artworks = null) {

        var remove_artworks = remove_artworks;

        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        var press_proof = 0;
        if ($('#press_proof').is(":checked")) {
            press_proof = 1;
        }
//get user selected element values
        var laminations_and_varnishes = [];
        var laminations_and_varnishes_childs = [];
        var i = 0;

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i] = $(this).data('embellishment_parsed_title');
            laminations_and_varnishes_childs[i] = $(this).data('embellishment_parsed_title_child');
            i++;
        });
        if (type == 'sheet') {
            var sheet_product_quality =  $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');

        }




        var digital_process_plus_white =  $('.digital_process_plus_white:checked').data('add_white');
        var label_application = $('#label_application').val();

        // var upload_artwork_radio = $('#artwork_now_or_follow').val();
        // var upload_artwork_option_radio = $('#custom_roll_and_label').val();

        if( remove_artworks == "clear" ) {
            var upload_artwork_radio = $('input[name="upload_artwork_2"]:checked').val();
        var upload_artwork_option_radio = $('input[name="upload_artwork_option_2"]:checked').val();
        } else {
            var upload_artwork_radio = $('#artwork_now_or_follow').val();
            var upload_artwork_option_radio = $('#custom_roll_and_label').val();
        }
        
        $('#cart_summery_loader').show();
        
        var edit_cart_flag = $("#edit_cart_flag").val();
        var temp_basket_id = $('#temp_basket_id').val();

        $.ajax({
            url: mainUrl + 'ajax/material_update_printing_artworks_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                digital_process_plus_white: digital_process_plus_white,
                label_application: label_application,
                combination_base: combination_base,
                sheet_product_quality: sheet_product_quality,
                cartid: cartid,
                productid: prdid,
                persheet: labelpersheets,
                type: type,
                edit_cart_flag: edit_cart_flag,
                temp_basket_id: temp_basket_id,
                
                
                updater: remove_artworks,
                unitqty: cartunitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
                laminations_and_varnishes_childs: laminations_and_varnishes_childs,
                selected_already_plates_composite_array: selected_already_plates_composite_array,
                upload_artwork_radio: upload_artwork_radio,
                upload_artwork_option_radio: upload_artwork_option_radio,
                lines_to_populate: lines_to_populate
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (!data == '') {
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                    if (data.cart_summery != '' && data.cart_summery != null) {
                        $('#cart_summery').html(data.cart_summery);
                        var prdid = $('#cartproductid').val();
                        $("#artwork_now_or_follow").val(upload_artwork_radio);
                        $("#custom_roll_and_label").val(upload_artwork_option_radio);
                        
                        // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        //$('#cal_btn'+prdid).click();

                    }
                    $('#cart_summery_loader').hide();
                    $('.upload_artwork_loader').hide();
                    $('#a4_material_selection').css('margin-top', '-217px');


                }
            }
        });
    }


    $(document).on("click", ".proceed_to_checkout", function (e) {

        var prdid = $('#cartproductid').val();
        if (upload_artwork_radio == "upload_artwork_now") {
            var upload_option = "upload_artwork";
        } else if (upload_artwork_radio == "artwork_to_follow") {
            var  upload_option = "email_artwork";
        }
        // var upload_option = $('input[name=upload_artwork_2]').data('upload_option');
        // var upload_option = $('input[name=upload_artwork_2]:checked').val();
        var type = $('#producttype' + prdid).val();
// alert(upload_option);
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        if (type == 'roll') {
            var remaing = parseInt($('#upload_remaining_labels').val());
            var msg_text = 'labels';
            var uploaded_sheets = parseInt($('#final_uploaded_rolls').val());
            var uploaded_labels = parseInt($('#final_uploaded_labels').val());
            var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Rolls\n';
        } else {
            var actual_sheets = parseInt($('#actual_sheets').val());
            var uploaded_sheets = parseInt($('#uploaded_sheets').val());
            var uploaded_labels = parseInt(uploaded_sheets * labelpersheets);
            var remaing = actual_sheets - uploaded_sheets;
            var msg_text = 'sheets';
            if (cartunitqty == 'labels') {
                var msg_text = 'labels';
            }
            var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Sheets\n';
        }
        var remaing_designs = parseInt($('#upload_remaining_designs').val());
        var designservice = $('input[name=print_designservice]:checked').val();
        var exceed = '';
        //var message = 'Do you want to continue without uploading artworks.?';
        var message = 'Have you uploaded all your artworks.?';
        var actual_designs = parseInt($('#actual_designs_qty').val());
        if ($('.UploadMainSelection').css('display') == 'block' && upload_option != 'email_artwork') {
            alert_box("Please click to  Proceed before checkout ");
            return false;
        } else if (upload_option == 'design_services' && typeof designservice == 'undefined') {
            alert_box("Please select no of design against design service");
            return false;
        } else if (type == 'sheet' && uploaded_sheets < 25 && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {
            var minqty = 25;
            if (cartunitqty == 'labels') {
                var minqty = 25 * parseInt(labelpersheets);
            }
            alert_box("Minimum " + minqty + " " + cartunitqty + " required, please adjust remaining sheets in your artworks");
            return false;
        } else if ((actual_designs == remaing_designs && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) || actual_designs == remaing_designs || uploaded_sheets == 0) {
            alert_box("Please upload your artworks before proceeding to checkout ");
            return false;
        } else if ($('.uploadsavesection').css('display') == 'table-row' && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {
            swal({
                    title: 'Please complete  or delete the incomplete line.',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn orangeBg",
                    confirmButtonText: "Continue",
                    cancelButtonClass: "btn blueBg m-r-10",
                    cancelButtonText: "Delete",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {

                    if (isConfirm) {
                        return false;
                    } else {
                        $('.uploadsavesection').hide();
                        $('#add_another_line').show();
                        $('.add_another_art').show();
                        return false;
                    }
                });
            //alert_box("Please complete the file upload process to continue.");
            //return false;
        } else {
            // if (upload_option == 'email_artwork' || upload_option == 'design_services') {
            if (upload_option == 'design_services') {
                swal({
                        title: 'Do you want to continue without uploading artworks.?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "No",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Yes",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            console.log('cancel');
                        } else {
                            add_to_car_product();
                        }
                    });
                // } else if ((remaing > 0 || remaing_designs > 0) && upload_option == 'upload_artwork') {
            } else if ((remaing > 0 || remaing_designs > 0) && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {
                if (remaing > 0) {
                    var text = msg_text;
                } else {
                    var text = 'designs';
                }
                        var count = 0;
                        $('.upload_row').each(function () {
                    if (!($(this).hasClass('uploadsavesection'))) {
                                // alert("inside if");
                                count++;

                            }
                        });
                        // alert(count);
                        lines_to_populate = count;
                            update_cart_with_upload();
                // swal({
                //         title: 'You have reduced the number of ' + text + ' please confirm to recalculate the price.',
                //         type: "warning",
                //         showCancelButton: true,
                //         confirmButtonClass: "btn orangeBg",
                //         confirmButtonText: "Confirm",
                //         cancelButtonClass: "btn blueBg m-r-10",
                //         cancelButtonText: "Cancel",
                //         closeOnConfirm: true,
                //         closeOnCancel: true
                //     },
                //     function (isConfirm) {
                //         var count = 0;
                //         $('.upload_row').each(function () {
                //             if(!($(this).hasClass('uploadsavesection'))){
                //                 // alert("inside if");
                //                 count++;
                //
                //             }
                //         });
                //         // alert(count);
                //         lines_to_populate = count;
                //         if (isConfirm) {
                //             update_cart_with_upload();
                //         }
                //     });
            } else {
                //Have you uploaded all your artworks?
                var summary_price = $('#cart_summery_total_price').text();
                var artwork_text = actual_designs + ' Artworks uploaded\n';
                var total_price_text = "Total " + summary_price + "\n <?=vatoption?>. VAT\n";
                var free_delivery_text = ' Free Delivery.';
                var finaltext = artwork_text + '' + lables_qty_text + '' + total_price_text + '' + free_delivery_text;
                swal({
                        title: finaltext,
                        type: "",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg m-t-10",
                        confirmButtonText: "Continue to Checkout",
                        cancelButtonClass: "btn blueBg m-r-10 m-t-10",
                        cancelButtonText: "Upload Further Artworks",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            add_to_car_product();
                        }
                    });
            }
        }
    });


    $(document).on("click", "#purchased_plate_cta", function (event) {
        console.log(selected_already_plates);


        //unselect already purchased plate of same base when user select another from laminations and varnish section(new plate)

        //get user selected element values
        $('.emb_option:checked').each(function () {
            current_emb_id = $(this).data('embellishment_id');
            current_emb_selection_id = $(this).data('embellishment_selection_id');
            $('.already_plates:checked').each(function () {
                history_selected_emb_id = $(this).data('embellishment_id');
                history_emb_selection_id = $(this).data('embellishment_selection_id');
                if(current_emb_id == history_selected_emb_id &&  current_emb_selection_id != history_emb_selection_id){
                    $('#uncheck_purchased_plate' + history_emb_selection_id).prop('checked', false);
                    var index = selected_already_plates.indexOf(history_emb_selection_id);
                    if (index !== -1) selected_already_plates.splice(index, 1);

                    //maintain composite array with order no to select purchased plate of exact order if user has same plate more then one in different order with different softproof.

                    $.each(selected_already_plates_composite_array,function (a,b) {
                        //return string so convert it in object form
                        var c =  JSON.parse(b);

                        if (c.already_used_plate_id == history_emb_selection_id ){
                            //get index of obj after matching and delete it from objects of objects global 'selected_already_plates_composite_array'
                            //splice function can't use as its for arrays only.
                            delete selected_already_plates_composite_array[a];
                        }
                    });

                    // console.log(selected_already_plates_composite_array);
                }
            });
        });


        var user_id = $('#user_id').val();
        $('#purchased_plate_history_loader').show();
        $('#purchased_plate_section').html('');


        $.ajax({
            url: mainUrl + 'ajax/purchased_plate_history',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                user_id: user_id,
                selected_already_plates: selected_already_plates,

                selected_already_plates_composite_array: selected_already_plates_composite_array

            },
            error: function (data) {
                swal('Some error occured please try again');
                $('#purchased_plate_history_loader').hide();

            },
            success: function (data) {

                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    $('#purchased_plate_section').html(data.content);

                    $('#purchased_plate_history_loader').hide();

                } else {
                    swal('Plates Order History', data.message, 'error');
                    $('#purchased_plate_history_loader').hide();

                }
            }
        });
    });



    $(document).on("click", ".sheet_section_radio_main", function (event) {
        // alert("radio_selection");
        var radio_selection =   $(this).data('product_quality_selection');
        $('#a4_material_selection').css('margin-top', '-369px');

        if (radio_selection == "standerd") {

            // alert('uncheck yes');
            //Reset embelisment & Finish selections And Arrays start
            option_clicked = 1;
            $('.emb_option , already_plates').each(function (i, obj) {
                var option_embellishment_id = $(this).data('embellishment_id');
                var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
                //uncheck all selected options from Label Finishes & Embellishments section

                // $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                //also add same functionality to purchased plate section
                $('#uncheck_purchased_plate' + option_embellishment_selection_id).prop("checked", false);
                //also reset plate cost price total val
                total_emb_plate_price = 0;
                //use to remove new selected value from global selected_already_plates array if user retain its selection from conflict combination modal


            });
            //reset selected and combination_base after uncheck all options from above loop
            selected = [];
            selected_already_plates = [];
            selected_already_plates_composite_array = [];
            combination_base = '';
            //Reset embelisment & Finish selections And Arrays end

            $('.alternate_option_section').show();

            $('#standerd_inner_section_options').show();
            $('#premium_inner_section_options').hide();

            $('.printing_process_default_check').trigger("click");
            $('#sheet_inner_section_radio_id_standerd').attr("checked", true);
            $('#sheet_inner_section_radio_id_premium').attr("checked", false);
            $('#tab-1').css('pointer-events', 'none');
            $('#tab-2').css('pointer-events', 'none');
            $('#tab-3').css('pointer-events', 'none');
            $('#tab-5').css('pointer-events', 'none');
            $('#purchased_plate_cta').css('pointer-events', 'none');
        } else if (radio_selection == "premium") {

            $('.alternate_option_section').hide();
            $('#standerd_inner_section_options').hide();
            $('#premium_inner_section_options').show();

            $('.printing_process_default_check').trigger("click");
            $('#sheet_inner_section_radio_id_premium').attr("checked", true);
            $('#sheet_inner_section_radio_id_standerd').attr("checked", false);

            $('#tab-1').css('pointer-events', 'unset');
            $('#tab-2').css('pointer-events', 'unset');
            $('#tab-3').css('pointer-events', 'unset');
            $('#tab-5').css('pointer-events', 'unset');
            $('#purchased_plate_cta').css('pointer-events', 'unset');


        }
        $('.sheet_section_radio_main_container').hide();
        $('.printing_process_selection_inner_container').fadeIn(2000);
        // product_quality sheet_inner_section_radio

    });
    $(document).on("click", ".sheet_inner_section_radio", function (event) {
        var radio_selection =   $(this).data('product_quality_selection_inner');
        if (radio_selection == "standerd") {


            //Reset embelisment & Finish selections And Arrays start
            option_clicked = 1;
            $('.emb_option , already_plates').each(function (i, obj) {
                var option_embellishment_id = $(this).data('embellishment_id');
                var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
                //uncheck all selected options from Label Finishes & Embellishments section

                // $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                //also add same functionality to purchased plate section
                $('#uncheck_purchased_plate' + option_embellishment_selection_id).prop("checked", false);
                //also reset plate cost price total val
                total_emb_plate_price = 0;
                //use to remove new selected value from global selected_already_plates array if user retain its selection from conflict combination modal


            });
            //reset selected and combination_base after uncheck all options from above loop
            selected = [];
            selected_already_plates = [];
            selected_already_plates_composite_array = [];
            combination_base = '';
            //Reset embelisment & Finish selections And Arrays start

            $('.alternate_option_section').show();

            $('#standerd_inner_section_options').show();
            $('#premium_inner_section_options').hide();
            $('.printing_process_default_check').trigger('click');


            $('#standerd_inner_section_description').show();
            $('#premium_inner_section_description').hide();
            //Enable finishes & emb options for premium sheet selection
            $('#tab-1').css('pointer-events', 'none');
            $('#tab-2').css('pointer-events', 'none');
            $('#tab-3').css('pointer-events', 'none');
            $('#tab-5').css('pointer-events', 'none');
            $('#purchased_plate_cta').css('pointer-events', 'none');

        } else if (radio_selection == "premium") {

            $('#printing_process_default_check_premium').trigger('click');

            $('.alternate_option_section').hide();

            $('#standerd_inner_section_options').hide();
            $('#premium_inner_section_options').show();

            $('#premium_inner_section_description').show();
            $('#standerd_inner_section_description').hide();
            //Enable finishes & emb options for premium sheet selection
            $('#tab-1').css('pointer-events', 'unset');
            $('#tab-2').css('pointer-events', 'unset');
            $('#tab-3').css('pointer-events', 'unset');
            $('#tab-5').css('pointer-events', 'unset');
            $('#purchased_plate_cta').css('pointer-events', 'unset');

        }


    });

    $(document).on("click", ".digital_process_plus_white", function (e) {
        if (!$('.pre_select_for_white').is(':checked')) {
            var msg = 'Check At Least one Option From Digital Process To Add White';

            swal("Select Digital Printing Process First", msg, "error");
            $('.digital_process_plus_white').prop('checked',false);

        }


    });
    $(document).on("click", ".alternate_option_proceed_click", function (e) {
        $('.sheet_section_radio_main').each(function (i, item) {
            var sheet_section_radio_main_val =  $(this).data('product_quality_selection');
            $('#a4_material_selection').css('margin-top', '-220px');
            if (sheet_section_radio_main_val == 'premium') {
                // alert("inside if");
                $(this).trigger('click');
                $('#sheet_inner_section_radio_id_premium').trigger('click');
                $('#printing_process_default_check_premium').trigger('click');
                pre_load_add_item(preferences_global);

            }

        });

    });
    $(document).on("click", ".tab-swal", function (e) {
        var sheet_product_quality =  $('.sheet_inner_section_radio:checked').data('product_quality_selection_inner');
        var msg_count = $(this).data('swal_msg');
        var id = preferences_global.ProductID;

        var type = $('#producttype' + id).val();

        if (type == 'sheet') {


            if (!sheet_product_quality) {
                var msg = 'Select Digital Printing Process First';

                swal("Something Missing", msg, "error");

            } else if (sheet_product_quality && sheet_product_quality == 'standerd') {
                var msg = '';

                if (msg_count == 5) {
                    msg = 'Finishes are not available from the Standard Quality Print option. Please select from the Premium Quality Print option.';
                    msg_count = '';
                    swal("Something Missing", msg, "error");

                } else if (msg_count == 2) {
                    var msg = 'Foils are not available from the Standard Quality Print option. Please select from the Premium Quality Print option. ';
                    msg_count = '';
                    swal("Something Missing", msg, "error");

                } else if (msg_count == 1) {
                    var msg = 'Debossing and embossing are not available from the Standard Quality Print option. Please select from the Premium Quality Print option.';
                    msg_count = '';
                    swal("Something Missing", msg, "error");

                } else if (msg_count == 3) {
                    var msg = 'Silk-screen print is not available from the Standard Quality Print option. Please select from the Premium Quality Print option.';
                    msg_count = '';
                    swal("Something Missing", msg, "error");

                }

            }

        }
    });
    //Embellishment qty updation before artwork upload and also  once artworks uploaded and user go back to emb page
    $(document).on("click", ".save_qty_btn", function (event) {

        var unitqty = 'Labels';
        // alert(unitqty);
        var labels = $('.LabelsPerSheet').val();
        var printingType = $('.product_type').val();
        var min_qty = $('.minimum_quantities').val();
        var max_qty = $('.maximum_quantities').val();
        var input_id = $('.inpu_qty_edit');


        var qty = parseInt(input_id.val());


        if (printingType == 'Sheets') {
            if (unitqty == 'Labels') {
                min_qty = parseInt(labels) * min_qty;
                max_qty = parseInt(labels) * max_qty;
            }

        } else {
            min_qty = 0;
            max_qty = parseInt(labels) * max_qty;

        }
        if (!is_numeric(qty) || qty == '' || qty < min_qty) {
            input_id.val(min_qty);
            if (unitqty == "Labels") {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' labels.');
            } else {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' sheets.');
            }
            qty = parseInt(input_id.val());
        }

        if (qty > max_qty) {
            input_id.val(max_qty);
            if (unitqty == 'Labels') {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' labels.');
            } else {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' sheets.');

            }
            qty = parseInt(input_id.val());
        }

        if (qty % labels != 0 && unitqty == 'Labels') {
            var multipyer = parseInt(labels) * parseInt(parseInt(qty / labels) + 1);
            input_id.val(multipyer);
            var qty = multipyer;
        }
        if (unitqty == 'Labels') {
            qty = parseInt(qty / labels);
        }

        $('.current_qty').text($('.inpu_qty_edit').val());
        $('.MaterialProductPriceMain_container').hide();
        $('.product_details_container').show();
        $('.emb_option_price_container').show();

        reCaculate(this);

    });
    $(document).on("click", "#emb_qty_edit", function (event) {
        // alert("dsfsd");

        // var sheets = $('.upload_row').find('.labels_input').val();
        var sheets = $('.total_user_sheet').text();


        // if (sheets.length == 0 || sheets == 0 || sheets == '') {
        //     var id = $('.upload_row').find('.labels_input');
        //     var popover = $('.upload_row').find('.popover').length;
        //     if (popover == 0) {
        //         show_faded_popover(id, "Minimum 1 sheet required ");
        //     }
        //
        //     return false;
        // }
        var prdid = $('#cartproductid').val();
        var type = $('#producttype' + prdid).val();
        if (type == 'sheet' && sheets >= 25) {
            var uploaded_sheets = parseInt($('#uploaded_sheets').val());
            var actual_sheets = parseInt($('#actual_sheets').val());
            var upload_remaining_designs = parseInt($('#upload_remaining_designs').val());
            if (upload_remaining_designs == 0) {

                $(".label-embellishment-cta-adjusted").trigger("click");

                // alert('inside roll if');
                //run before artwork upload edit option
            } else {
                $('.inpu_qty_edit').val($('.current_qty').text());
                $('.product_details_container').hide();
                $('.MaterialProductPriceMain_container').show();
                $('.emb_option_price_container').hide();

                // alert('inside roll else');

            }
            //  $('#product_content').css('pointer-events','none');
            // $('#finish_content').css('pointer-events','none');

            // $('#product_content').css('pointer-events','none');
            // $('.about_artwork_and_inhouse_service_section').css('pointer-events','none');
            // $('.already_purchase_plate_section').css('pointer-events','none');
            // $('.label_embelishemnt_pressproof_section').css('pointer-events','none');
            //
            // $('#tab-1').css('pointer-events','none');
            // $('#tab-2').css('pointer-events','none');
            // $('#tab-3').css('pointer-events','none');
            // $('#tab-5').css('pointer-events','none');

        } else if (type == 'roll') {
            var no_of_rolls = $('#final_uploaded_rolls').val();
            //run when artwork uploaded and user go back to emb page
            if (no_of_rolls > 0) {

                $(".label-embellishment-cta-adjusted").trigger("click");

                // alert('inside roll if');
                //run before artwork upload edit option
            } else {
                $('.inpu_qty_edit').val($('.current_qty').text());
                $('.product_details_container').hide();
                $('.MaterialProductPriceMain_container').show();
                $('.emb_option_price_container').hide();

                // alert('inside roll else');

            }
            // alert(type);
            // $('#product_content').css('pointer-events','none');
            // $('#finish_content').css('pointer-events','none');
        }

    });
    //all checks of proceed_to_checkout function except checkout rather to go checkout it closes the pop up
    $(document).on("click", ".save_and_close_popup_checks", function (e) {

        var prdid = $('#cartproductid').val();
        if (upload_artwork_radio == "upload_artwork_now") {
            var upload_option = "upload_artwork";
        } else if (upload_artwork_radio == "artwork_to_follow") {
            var upload_option = "email_artwork";
        }
        // var upload_option = $('input[name=upload_artwork_2]').data('upload_option');
        // var upload_option = $('input[name=upload_artwork_2]:checked').val();
        var type = $('#producttype' + prdid).val();
// alert(upload_option);
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        if (type == 'roll') {
            var remaing = parseInt($('#upload_remaining_labels').val());
            var msg_text = 'labels';
            var uploaded_sheets = parseInt($('#final_uploaded_rolls').val());
            var uploaded_labels = parseInt($('#final_uploaded_labels').val());
            var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Rolls\n';
        } else {
            var actual_sheets = parseInt($('#actual_sheets').val());
            var uploaded_sheets = parseInt($('#uploaded_sheets').val());
            var uploaded_labels = parseInt(uploaded_sheets * labelpersheets);
            var remaing = actual_sheets - uploaded_sheets;
            var msg_text = 'sheets';
            if (cartunitqty == 'labels') {
                var msg_text = 'labels';
            }
            var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Sheets\n';
        }
        var remaing_designs = parseInt($('#upload_remaining_designs').val());
        var designservice = $('input[name=print_designservice]:checked').val();
        var exceed = '';
        //var message = 'Do you want to continue without uploading artworks.?';
        var message = 'Have you uploaded all your artworks.?';
        var actual_designs = parseInt($('#actual_designs_qty').val());
        if ($('.UploadMainSelection').css('display') == 'block' && upload_option != 'email_artwork') {
            alert_box("Please click to  Proceed before checkout ");
            return false;
        } else if (upload_option == 'design_services' && typeof designservice == 'undefined') {
            alert_box("Please select no of design against design service");
            return false;
        } else if (type == 'sheet' && uploaded_sheets < 25 && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {
            var minqty = 25;
            if (cartunitqty == 'labels') {
                var minqty = 25 * parseInt(labelpersheets);
            }
            alert_box("Minimum " + minqty + " " + cartunitqty + " required, please adjust remaining sheets in your artworks");
            return false;
        } else if (actual_designs == remaing_designs && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {
            alert_box("Please upload your artworks before proceeding to checkout ");
            return false;
        } else if ($('.uploadsavesection').css('display') == 'table-row' && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {

            swal({
                    title: 'Please complete  or delete the incomplete line.',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn orangeBg",
                    confirmButtonText: "Continue",
                    cancelButtonClass: "btn blueBg m-r-10",
                    cancelButtonText: "Delete",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {

                    if (isConfirm) {
                        return false;
                    } else {
                        $('.uploadsavesection').hide();
                        $('#add_another_line').show();
                        $('.add_another_art').show();
                        return false;
                    }
                });
            //alert_box("Please complete the file upload process to continue.");
            //return false;
        } else {
            // if (upload_option == 'email_artwork' || upload_option == 'design_services') {
            if (upload_option == 'design_services') {
                swal({
                        title: 'Do you want to continue without uploading artworks.?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "No",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Yes",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            console.log('cancel');
                        } else {
                            add_to_car_product();
                            $('.save_and_close_popup_checks').attr('data-dismiss', 'modal');

                        }
                    });
                // } else if ((remaing > 0 || remaing_designs > 0) && upload_option == 'upload_artwork') {
            } else if ((remaing > 0 || remaing_designs > 0) && (upload_option == 'upload_artwork' || upload_option == 'email_artwork')) {
                if (remaing > 0) {
                    var text = msg_text;
                } else {
                    var text = 'designs';
                }
                var count = 0;
                $('.upload_row').each(function () {
                    if (!($(this).hasClass('uploadsavesection'))) {
                        // alert("inside if");
                        count++;

                    }
                });
                // alert(count);
                lines_to_populate = count;
                // $('#product_content').css('pointer-events','none');
                // $('.about_artwork_and_inhouse_service_section').css('pointer-events','none');
                // $('.already_purchase_plate_section').css('pointer-events','none');
                // $('.label_embelishemnt_pressproof_section').css('pointer-events','none');
                //
                // $('#tab-1').css('pointer-events','none');
                // $('#tab-2').css('pointer-events','none');
                // $('#tab-3').css('pointer-events','none');
                // $('#tab-5').css('pointer-events','none');
                update_cart_with_upload();

                // swal({
                //         title: 'You have reduced the number of ' + text + ' please confirm to recalculate the price.',
                //         type: "warning",
                //         showCancelButton: true,
                //         confirmButtonClass: "btn orangeBg",
                //         confirmButtonText: "Confirm",
                //         cancelButtonClass: "btn blueBg m-r-10",
                //         cancelButtonText: "Cancel",
                //         closeOnConfirm: true,
                //         closeOnCancel: true
                //     },
                //     function (isConfirm) {
                //         var count = 0;
                //         $('.upload_row').each(function () {
                //             if(!($(this).hasClass('uploadsavesection'))){
                //                 // alert("inside if");
                //                 count++;
                //
                //             }
                //         });
                //         // alert(count);
                //         lines_to_populate = count;
                //         if (isConfirm) {
                //             update_cart_with_upload();
                //         }
                //     });
            }
        }
        $('.save_and_close_popup_checks').attr('data-dismiss', 'modal');


    });

    function design_service_additional_version(_this) {
        // this = _this;
        var additional_version = $(_this).data("additional-version");
        var selected_package = $(_this).data("package");
        //reset additional version btn value other then current selection
        var count = 0;
        $('.additional_ver_btn').each(function () {
            var package = ($(this).data('package-btn'));
            if (package != selected_package) {
                $(this).find('strong').text('Select');

            }

            // $('.design_service_form_container').fadeOut(500);

        });
        //make current value selection on current additional version btn
        $('#' + selected_package).find('strong').text(additional_version);
    }

    $(document).on("click", ".proceed_pkg_btn", function (e) {
        var show_error = 1;

        var selected_package = $(this).data("package-bn");
        $('.additional_ver_btn').each(function () {
            var package = ($(this).data('package-btn'));
            // if (package != selected_package){
            var text = $(this).find('strong').text();
            if (text != 'Select') {
                var additional_version = $(this).data("additional-version");
                var selected_package = $(this).data("package");
                show_error = 0;
            }

            // }
        });
        if (show_error == 1) {
            // $(this).css('border','1px solid red');
            show_faded_popover($('#custom_label'), 'Select one of the option to proceed.');
        } else {
            $('.design_service_form_container').fadeIn(1000);

        }
    });


    $(".specialvalidation").keypress(function (e) {
        var keyCode = e.which;
        if (!((keyCode >= 48 && keyCode <= 57)
            || (keyCode >= 65 && keyCode <= 90)
            || (keyCode >= 97 && keyCode <= 122))
            && keyCode != 8 && keyCode != 32) {
            return false;
        }
    });
    $(document).on("keypress", ".emailspecialvalidation", function (e) {

        var keyCode = e.which;

        if (keyCode == 46 || keyCode == 64 || keyCode == 95 || keyCode == 45) {
            return true;
        } else if (!((keyCode >= 48 && keyCode <= 57)
            || (keyCode >= 65 && keyCode <= 90)
            || (keyCode >= 97 && keyCode <= 122))
            && keyCode != 8 && keyCode != 32) {
            return false;
        }

    });


    $(document).on("keypress keyup blur", ".numeric", function (e) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((e.which < 48 || e.which > 57)) {
            e.preventDefault();
        }
    });

    $(document).on("keypress keyup blur", ".letters", function (e) {
        return (e.charCode > 64 && e.charCode < 91) || (e.charCode > 96 && e.charCode < 123);
    });

    /*var form = $("#design_service_form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.after(error);
        },
        rules: {

            email: {
                required: true,
                email: true,

            },
            captcha: {
                required: true,
                onkeyup: false,
                remote: mainUrl + "ajax/is_valid_captcha"
            }
        },
        messages: {
            captcha: {
                remote: " please enter a valid word! "
            }
        },

        submitHandler: function (form) {
            form.submit();
            return false;
        }

    });
*/

    function submit_design_service_form(e) {
        // alert(has_files);
        // var cartid = $('#cartid').val();
        //
        // Dropzone.autoDiscover = false;
        //
        // var myDropzone = Dropzone.forElement(".dropzone");
        // myDropzone.on('sending', function (file, xhr, formData) {
        //     formData.append('caerid', cartid);
        // });
        // myDropzone.on('success', function () {
        //
        //     var args = Array.prototype.slice.call(arguments);
        //     uploaded_file_names.push(args[1]);
        //     alert("inside success");
        //     // Look at the output in you browser console, if there is something interesting
        //     console.log(typeof args[1]);
        // });
        //
        //
        //
        //
        // if (myDropzone.processQueue()) {
        //     alert(all_files_uploaded);
        //
        // }


        var proceed = 0;
        if (has_files == 1 && all_files_uploaded == 1) {
            proceed = 1;
        } else if (has_files == 0) {
            proceed = 1;
        }
        if (proceed == 1) {

            setTimeout(function () {
                var design_brief = $('#design_brief').val();
                var full_name = $('#full_name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var additional_version = '';
                var selected_package = '';
                $('.additional_ver_btn').each(function () {
                    var package = ($(this).data('package-btn'));
                    // if (package != selected_package){
                    var text = $(this).find('strong').text();
                    if (text != 'Select') {

                        additional_version = parseInt(text);
                        selected_package = $(this).data("package-btn");
                    }
                });


                var form_data = new FormData();
                form_data.append("uploaded_file_names", uploaded_file_names);
                form_data.append("selected_package", selected_package);
                form_data.append("additional_version", additional_version);
                form_data.append("design_brief", design_brief);
                form_data.append("full_name", full_name);
                form_data.append("email", email);
                form_data.append("phone", phone);
                form_data.append("cartid", cartid);

                // $('#inhouse_design_loader').show();
                // $('#inhouse_design_modal').css('pointer-events', 'none');

                $.ajax({
                    url: mainUrl + 'ajax/add_custom_design_to_cart_label_emb',
                    type: "POST",
                    async: "false",
                    dataType: "html",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (data) {
                        data = $.parseJSON(data);
                        if (data.status == 'yes'){
                            var finaltext = 'Custon design Service Product is added to your basket';
                            //$("#cart").html(data.top_cart);
                            swal({
                                    title: finaltext,
                                    type: "",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn orangeBg m-t-10",
                                    confirmButtonText: "Continue to Checkout",
                                    cancelButtonClass: "btn blueBg m-r-10 m-t-10",
                                    cancelButtonText: "Add More",
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        window.location.href = '<?php echo SAURL ?>order_quotation/order/index';
                                    }
                                });
                        }

                        $('#inhouse_design_modal').modal('toggle');
                        $('#inhouse_design_loader').hide();
                    }
                });
            }, 500);

        }


    }


    // $(document).on("keyup", "#captcha", function (e) {
    //
    //     $.ajax({
    //         url: mainUrl + "ajax/is_valid_captcha",
    //         type: "GET",
    //
    //         success: function (data) {
    // 
    //         }
    //     });
    //
    // });
    $(document).on("click", ".design_service_form_submit", function (e) {


        if ($("#design_service_form").valid()) {
            $('#inhouse_design_loader').show();
            // $('#inhouse_design_modal').css('pointer-events', 'none');
            submit_design_service_form();
        }
    });



    function checkedSelectedLemOptions(lem_options){ // This is to show preselected label embellishment options

        var selected_digital_process = $('#selected_digital_process').val();
        var selected_line_type = $('#selected_line_type').val();

        $('.digital_process').prop('checked', false);

        if(selected_line_type != 'Roll Labels'){
            $('#sheet_inner_section_radio_id_premium').trigger('click');
        }

        var str_digital = selected_digital_process.split("+");


        var digital_process = $.trim(str_digital[0]);

        
        var plus_white = $.trim(str_digital[1]);

        

        $('.digital_process').each(function(i, obj){

            var digital_process_parent = $(this).parents().data("printing_process");

            // console.log("11111= "+digital_process_parent);
            // console.log("22222= "+digital_process);
            if (digital_process_parent == 'Monochrome_Black_Only' && (digital_process == 'Mono' || digital_process == 'Monochrome - Black Only' || digital_process == 'Monochrome Black Only')) {
                // console.log("I am INNINIIn");
                $(this).prop('checked', true);
            }
            if (digital_process_parent == '4_Colour_Digital_Process' && (digital_process == 'Fullcolour' || digital_process == '4 Colour Digital Process')) {
                $(this).prop('checked', true);
            }
            if (digital_process_parent == '4_Colour_Digital_Process_White' && (digital_process == 'Fullcolour+White' || digital_process == '4 Colour Digital Process + White')) {
                $(this).prop('checked', true);
            }
            if (digital_process_parent == '6_Colour_Digital_Process' && (digital_process == 'Fullcolour' || digital_process == '6 Colour Digital Process')) {
                $(this).prop('checked', true);
            }
            if (digital_process_parent == 'Rich_Black_White' && (digital_process == 'Fullcolour+White' || digital_process == 'Rich Black + White' || digital_process == 'Rich Black') ) {
                $(this).prop('checked', true);
            }

            if (digital_process_parent == 'Rich_Black' && (digital_process == 'Fullcolour+White' || digital_process == 'Rich Black + White' || digital_process == 'Rich Black') ) {
                $(this).prop('checked', true);
            }

            if (digital_process_parent == '6_Colour_Digital_Process_White' && (selected_digital_process == 'Fullcolour+white' || selected_digital_process == '6 Colour Digital Process + White')) {
                $(this).prop('checked', true);
            }

        });

        $('.emb_option').each(function (i, obj) {
            var option_embellishment_id = $(this).data('embellishment_id');
            var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
            var parsed_title = $(this).data('embellishment_parsed_title_child');

            $.each(lem_options, function( i, value ) {
                var selected_parsed_title = value.finish_parsed_title;
                if (selected_parsed_title == parsed_title) {
                    $('#uncheck' + option_embellishment_selection_id).prop('checked', true);
                }
            });
        });

        combination_base = $('#selected_combination_base').val();

        selected_already_plates = [];
        selected_already_plates_composite_array = [];
        var i = 0;
        $('.already_plates:checked').each(function () {
            var composite_obj = {already_used_plate_id:$(this).data('embellishment_selection_id'), plate_order_no:$(this).data('plate_order_no')};
            selected_already_plates_composite_array[i] =  JSON.stringify(composite_obj) ;
            selected_already_plates[i] = $(this).data('embellishment_selection_id');
            i++;
        });


    }
    // $(document).on("click",".delete_item",function(e){
    //     var t= $(this).attr("id");
    //     swal({title:"Are you sure you want to Delete.?",
    //         type:"warning",
    //         showCancelButton:!0,
    //         confirmButtonClass:"btn orangeBg",
    //         confirmButtonText:"Cancel",
    //         cancelButtonClass:"btn blueBg",
    //         cancelButtonText:"OK",
    //         closeOnConfirm:!0,closeOnCancel:!0},
    //         function(e){e?console.log("cancel"):
    //             $.ajax({url:base+"ajax/delete_product_cart",
    //                 type:"POST",
    //                 async:"false",
    //                 data:{serial:t},
    //                 dataType:"json",
    //                 success:function(e){$("#aja_cart").html(e.cart_data),
    //                     $("#cart").html(e.top_cart),
    //                     $("#ajax_delivery").html(e.delivey),$("#ajax_order_summary").html(e.orderSummary)}})})})

</script>
