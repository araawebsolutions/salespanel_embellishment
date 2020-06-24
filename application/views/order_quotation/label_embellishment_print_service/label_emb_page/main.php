<link rel='stylesheet' href='<?= Assets ?>css/label_embellishment.css'>



<!--<link rel='stylesheet' href='<?/*= Assets */?>css/main-unminify.css'>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css'>


<link rel='stylesheet' href='<?= Assets ?>css/11custom.css'>
<script src="<?= Assets ?>labelfinder/js/jquery-ui.js"></script>

<style>
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
     style="position: absolute;top: 30%;right: 0;width: 100%;z-index: 999;height: 110%;display: none;background: #FFF;opacity: 0.8;">
    <div class="text-center"
         style="margin: 20% 43% !important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 18%;border: solid 1px #CCC;">
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
                <!--               --><?php //include('printing_process.php') ?>

                <!-- Label Finishes & Embellishments & Cart Summary Starts -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
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
                            <a href="#" class="label-embellishment-cta"><i class="fa fa-chevron-left"></i> Back to
                                Material & Quantity</a>
                        </div>
                    </div>
                </section>
                <!-- Label Finishes & Embellishments & Cart Summary End -->
            </div>
        </div>
        <!-- Sheets Superior Quality Starts -->
        <?php include('alternate_option.php') ?>

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


<!-- Popup For Artwork Upload & Artwork to follow Start -->
<div id="artwork_upload_view">
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


    $('.conflict_selection_remove_and_base_change_note').hide();

    //function run on emb_conflict option selection on conflict modal
    $(document).on("click", ".emb_conflict_option", function (e) {
        //alert('kk');
        var clicked_id = $(this).data('embellishment_conflict_id');
        //show conflict_selection_remove_and_base_change_note if user select other option instead of current
        // combination_base
        if (combination_base != clicked_id) {
            $('.conflict_selection_remove_and_base_change_note').fadeIn();

            //alert('11');
        } else {
            $('.conflict_selection_remove_and_base_change_note').fadeOut();
            //alert(clicked_id);
            //alert(combination_base);
        }


        $('.emb_conflict_option').each(function (i, obj) {
            var conflict_id = $(this).data('embellishment_conflict_id');
            var option_title = $(this).data('embellishment_base_title');

            //alert(conflict_id);
            //alert(option_title);

            if ($(this).is(":checked")) {
                //alert('checkd');
                //update global checked variable value
                checked_id = conflict_id;
                //update global embellishment_id variable value
                embellishment_id = $(this).data('embellishment_id');
                //update global option_clicked variable value
                option_clicked = 1;
            } else {
                //alert('un checkd');
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
        //alert(modal_type);

        //conflict modal when user wants to unselect base this will show when he selects option from modal to
        //yes as continue and no as not continue

        if (modal_type == 'base_uncheck_by_user') {

            var uncheck_val = $(this).data('uncheck_val');
            var comb_base = $(this).data('comb_base');
            //alert(uncheck_val);
            //alert(comb_base);
            if (uncheck_val == 'yes') {
                //check this val >0 to close conflict modal after value selection from modal
                option_clicked = 1;
                $('.emb_option ').each(function (i, obj) {
                    var option_embellishment_id = $(this).data('embellishment_id');
                    var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
                    //uncheck all selected options from Label Finishes & Embellishments section

                    // $('#uncheck' + option_embellishment_selection_id).attr('checked', false);
                    $('#uncheck' + option_embellishment_selection_id).prop('checked', false);
                    //also reset plate cost price total val
                    total_emb_plate_price = 0;


                });
                //reset selected and combination_base after uncheck all options from above loop
                selected = [];
                combination_base = '';

            } else {

                // reset total_emb_plate_price and add it according to base option selected
                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                    // Reset total_emb_plate_price and then set it according to selected base value if it has any plate cost
                    if (comb_base == embellishment_plate_price_single.id) {
                        total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                    }
                });


                console.log(comb_base);
                //check this val >0 to close conflict modal after value selection from modal

                option_clicked = 1;

                $('#uncheck' + comb_base).prop("checked", true);
                combination_base = comb_base;
            }
            if (option_clicked > 0) {
                $('.combination_conflict_modal_close').modal('toggle');
                //once modal close then set it to 0 to re-apply all checks related to close modal
                option_clicked = 0;

            }
            //    Execute else if its label combination conflict modal
        } else {
            //alert(option_clicked);
            if (option_clicked > 0) {
                //add toggle to modal to close it as default colose and keyboard esc button options are disabled to
                //force user to only close modal after one option selection
                $('.combination_conflict_modal_close').modal('toggle');
                //once modal close then set it to 0 to re-apply all checks related to close modal
                option_clicked = 0;

            }
            // if user select other option from conflict modal other then its current combination base then uncheck users all selections and
            //change its combination_base on run time
            //alert(combination_base);
            //alert('checked_id = '+checked_id);
            if (combination_base != checked_id) {

                $('.emb_option ').each(function (i, obj) {
                    var option_embellishment_id = $(this).data('embellishment_id');
                    var option_embellishment_selection_id = $(this).data('embellishment_selection_id');
                    //uncheck all options other then selected option from conflict modal
                    if (option_embellishment_selection_id != checked_id && checked_id != '') {

                        $('#uncheck' + option_embellishment_selection_id).prop('checked', false);

                    }

                });
                //if user selects hot_foil,embossing,silk screen or sequential date from conflict modal then change its combination_base to
                // emb parent id as he can't select more then one child from these parents and if parent is disable
                // then their all childs will also be disabled.

                if (embellishment_id == 2 || embellishment_id == 3 || embellishment_id == 4 || embellishment_id == 5) {
                    // reset total_emb_plate_price and add it according to base option selected
                    $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                        // Reset total_emb_plate_price and then set it according to selected base value if it has any plate cost
                        if (checked_id == embellishment_plate_price_single.id) {
                            total_emb_plate_price = 0;
                            total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                        }
                    });

                    combination_base = embellishment_id;
                    //    its execute in case of lamination & varnishes as they have separate values in combination_array and can be selected
                    //    more then one value
                } else {
                    // Reset total_emb_plate_price and then set it according to selected base value if it has any plate cost

                    $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                        // console.log(embellishment_plate_price_single);
                        if (checked_id == embellishment_plate_price_single.id) {
                            total_emb_plate_price = 0;
                            total_emb_plate_price += parseInt(embellishment_plate_price_single.plate_cost);
                        }
                    });

                    // make combination_base to current selection id as user can select more then one value
                    // from lamination and varnish section
                    combination_base = checked_id;

                }

            } else {
                //alert('jj0');
                // Remove plate cost price if any if user select retain its selection from conflict combination modal

                $.each(embellishment_plate_price_global, function (k, embellishment_plate_price_single) {
                    // console.log(embellishment_plate_price_single);
                    if (conflict_id_unchecked == embellishment_plate_price_single.id) {
                        total_emb_plate_price -= parseInt(embellishment_plate_price_single.plate_cost);
                    }
                });
                //uncheck user option that is not selected from combination conflict modal
                // when user selects same combination_base
                //alert(conflict_id_unchecked);
                $('#uncheck' + conflict_id_unchecked).prop('checked', false);

            }
        }
        // show/update emb plate cost price total value in cart summery section
        $('#embellishment_plate_total_cost').html(total_emb_plate_price);
        //hide base change modal if showing
        $('.conflict_selection_remove_and_base_change_note').hide();

        // alert(checked_id);
        // alert(total_emb_plate_price);

    });

    var combination_base = '';
    //function to check combinations start
    $(document).on("click", ".emb_option", function (e) {
        var user_selected_id = $(this).data('embellishment_id');
        var user_selected_title = $(this).data('embellishment_selected_title');
        var user_selected_embellishment_actual_id = $(this).data('embellishment_selection_id');
        var selected = [];
        //global variable for plate price
        total_emb_plate_price = 0;
        var i = 0;
        //alert(combination_base);
        // if hot_foil,embossing,silk screen, sequential then do nothing as user can't unselect its base
        // as all options/childs under it have same base id according to each parent and all these are radio
        // so can be check just one option at a time from respected parent decesendent child options
        if (combination_base == 2 || combination_base == 3 || combination_base == 4 || combination_base == 5) {

            //    execute if user unselect its base and also create conflict modal layout and options
            //    using same modal (with class .emb_modal) for both base unselect and combination conflict modal
            //    each creates its modal body data dynamically
        } else {
            if (!$("#uncheck" + combination_base).is(":checked") && combination_base != '') {
                 //alert("inside if");
                var conflict_selection_remove_and_base_change_note = '';
                var conflict_modl_msg_container = '';
                var conflict_data_desc = '';
                var conflict_data_footer = '';
                conflict_data_desc += '<p> If You Uncheck this option your ';
                conflict_data_desc += 'previous selections will be reset <br><br> ';
                conflict_data_desc += 'Do you want to continue?</p>';

                conflict_data_footer += '<div class="modal-footer row " style="padding: 15px !important;">';
                conflict_data_footer += '<button data-toggle="modal" style="margin-left: -6% !important;" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-uncheck_val="no" data-comb_base="' + combination_base + '" class=" m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton col-sm-4" type="button">No';
                conflict_data_footer += ' </button>';

                conflict_data_footer += '<button data-toggle="modal" style="float:right ;" data-backdrop="static" data-keyboard="false" data-modal_type="base_uncheck_by_user" data-uncheck_val="yes" class="m-t-10 m-b-30 continue_conflict_modal btn orange cal_btn MaterialModalButton float-right col-sm-4  " type="button">Yes';
                conflict_data_footer += '</button>';

                conflict_data_footer += '</div>';

                $('#base_conflict_desc').html(conflict_data_desc);
                //hide base change message that is made for combination conflict modal not for this
                $('.conflict_selection_remove_and_base_change_note').hide();
                $('#conflict_modl_msg_container').html(conflict_modl_msg_container);
                $('#base_conflict_footer').html(conflict_data_footer);
                // add trigger event to click modal <a> to show modal
                $('.emb_modal').trigger("click");

            }
        }


        //get user selected element values
        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            selected[i++] = $(this).data('embellishment_selection_id');
        });
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
// alert(combination_base);
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


                                        $('.emb_modal').trigger("click");

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

                                        conflict_data_desc += '<p> These 2 options are not available togethers<br>';
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

                                        $('.emb_modal').trigger("click");

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

        $.ajax({
            url: mainUrl + 'ajax/material_load_preferences',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                email: email
            },
            success: function (data) {
                data = $.parseJSON(data);

                if (data.response == 'yes') {


                    if (data.preferences.source != "material_page") {
                        document.location = "<?php echo base_url() . 'printed-labels/';?>";
                    }

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
                    // $('#label_coresize').html(data.data.roll_cores);
                    $("#brandName").text(preferences.available_in);
                    // if (preferences.available_in == 'Roll') {
                    //     $("#labels_qty").text(preferences.labels_roll);
                    // } else {
                    //     $("#labels_qty").text(preferences.labels_a4);
                    // }

                    // if(preferences.available_in == 'Roll'){
                    //     $("#product_color").text(preferences.color_roll);
                    // }else{
                    //     $("#product_color").text(preferences.color_a4);
                    // }
                    // if(preferences.available_in == 'Roll'){
                    //     $("#product_material").text(preferences.material_roll);
                    // }else{
                    //     $("#product_material").text(preferences.material_a4);
                    // }
                    // if(preferences.available_in == 'Roll'){
                    //     $("#product_code").text(preferences.categorycode_roll);
                    // }else{
                    //     $("#product_code").text(preferences.categorycode_a4);
                    // }
                    //
                    // $("#label_size").text(data.data.label_size);
                    // $("#product_shape").text(preferences.shape);
                    //
                    // if(preferences.available_in == 'Roll'){
                    //     $("#product_material_text").text(preferences.material_roll);
                    // }else{
                    //     $("#product_material_text").text(preferences.material_a4);
                    // }
                    // if(preferences.available_in == 'Roll'){
                    //     $("#product_color_text").text(preferences.color_roll);
                    // }else{
                    //     $("#product_color_text").text(preferences.color_a4);
                    // }
                    // if(preferences.available_in == 'Roll'){
                    //     $("#product_adhesive").text(preferences.adhesive_roll);
                    // }else{
                    //     $("#product_adhesive").text(preferences.adhesive_a4);
                    // }


                    pre_load_apply_preferences(preferences);

                } else {
                    document.location = "<?php echo base_url() . 'printed-labels/';?>";
                }
            }
        });
    }


    function pre_load_apply_preferences(data) {


        setTimeout(function () {

            //alert(data.wound_roll);
            //alert(data.orientation);
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
        pre_load_add_item(data);
        $("#full_page_loader").hide();

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

    function pre_load_add_item(allPreferences) {
        var press_proof = 0;
        if ($('#press_proof').is(":checked")) {
            press_proof = 1;
        }
        var id = allPreferences.ProductID;
        var menuid = allPreferences.ManufactureID;
        var rollfinish = '';
        var coresize = '';
        var woundoption = '';
        var orientation = '';
        var pressproof = '';
        var type = $('#producttype' + id).val();
        //alert(type);
        //alert($('#producttype' + id).val());
        //var type = $('#producttype').val();
        var unitqty = $('#calculation_unit' + id).val();
        //get user selected element values
        var laminations_and_varnishes = [];
        var laminations_and_varnishes_childs = [];
        var i = 0;
        // artwork upload section view appen container
        var artwork_upload_view = $('#artwork_upload_view');

        $('.emb_option:checked').each(function () {
            //alert('k');
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
        }

        // var printing = $('#digital_printing_process' + id).val();
        var printing = $(".digital_process:checked").parents().data("printing_process");

        var labels = $('#labels_p_sheet' + id).val();
        //var labels = $('#labels_p_sheet').val();
        var min_qty = parseInt($('#min_qty' + id).val());
        var max_qty = parseInt($('#max_qty' + id).val());

        var cartid = $('#cartid').val();
        //var pressproof = $('#pressproof').val();
        // show_loader('80', '27');
        var _this = $("#add_btn" + id);
        // change_btn_state(_this, 'disable', 'proceed-print');
        $('#cart_summery_loader').show();

        $.ajax({
            url: mainUrl + 'ajax/material_continue_with_product_printed_labels',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                qty: qty,
                menuid: menuid,
                prd_id: id,
                labelspersheets: labels,
                labeltype: printing,
                rollfinish: rollfinish,
                coresize: coresize,
                woundoption: woundoption,
                orientation: orientation,
                producttype: type,
                cartid: cartid,
                unitqty: unitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
                laminations_and_varnishes_childs: laminations_and_varnishes_childs
            },
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    if (data.response == 'yes') {
                        change_btn_state(_this, 'enable', 'sample');

                        // $('#Printing_Step_4').find('.show_selected_product').html(data.content);
                        $('#cart_summery').html(data.data.content);
                        artwork_upload_view.html(data.data.artwork_upload_view);

                        // $('#Printing_Step_2').find('#product_summary_overview_home').html(data.content_home);

                        $("[data-toggle=tooltip-orintation_popup]").tooltip('destroy');
                        $("[data-toggle=tooltip-orintation_popup]").tooltip();

                        // $('#aa_loader').hide();
                        // intialize_progressbar();

                        // $(".printed_total_pricing").parents('#product_summary_overview_home').find('.printed_total_pricing').hide();
                    }
                }
                $('#cart_summery_loader').hide();

            }
        });
    }

    $(document).on("click", ".digital_process, .emb_option, #press_proof", function (e) {

        $('#label-embellishement-calculate-price-cta').show("slide", {direction: "up"}, 400);
        $('#label-embellishement-cta').hide();

    });

    function reCaculate(_this) {
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
        //console.log(_this);
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
        var core_size = $('#label_coresize').val();
        var wound_option = $('#woundoption').val();
        var label_orientation = $('#label_orientation').val();
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
                console.log(returned);
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
    $(document).on("click", "#about_your_artwork_cta", function (event) {
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
        if ((preferences_global.available_in  == "A4" || preferences_global.available_in  == "A3" || preferences_global.available_in  == "SRA3" || preferences_global.available_in == "A5") && preferences_global.categorycode_a4 != '')
        {
            //for sheet change/hide roll upload options of 20 pound and lpr & no of rolls
            $('.roll_upload_options').hide();
            $('.artwork_container').removeClass('col-md-4');
            $('.artwork_container').addClass('col-md-12');
            $('.artwork_row').removeClass('row');
            $('.artwork_inner_col').removeClass('col-md-6');
            $('.artwork_inner_col').addClass('col-md-3');
            product_type = 'sheet';
        }else{
            product_type = 'roll';
        }
        $('.modal-body').css("height","88%");

    });
    $(document).on("keyup", "#user_entered_lines_qty", function (e) {
        var lines_to_enter = $('#user_entered_lines_qty').val();
        var upload_artwork_radio = $('.upload_artwork_radio:checked').val();
        var upload_artwork_option_radio = $('.upload_artwork_option_radio:checked').val();

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

        }else{
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

                    // if (upload_artwork_radio !== $(this).val() || upload_artwork_option_radio !==  $(this).val()){
                    //     $(this).attr('checked','checked');
                    upload_artwork_radio = $('input[name=upload_artwork_2]:checked').val();
                    upload_artwork_option_radio = $('input[name=upload_artwork_option_2]:checked').val();
                    // alert(upload_artwork_radio+'-'+upload_artwork_option_radio);
                    $('.upload_artwork_loader').show();
                    clear_uploaded_artworks();
                    // }
                    return;

                }else{

                    // $("input[name=background][value='some value']").prop("checked",true);
                    $("input[value='"+upload_artwork_radio+"']").prop("checked",true);
                    $("input[value='"+upload_artwork_option_radio+"']").prop("checked",true);
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

        //set height for inner moal to auto for full height with upload options
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
                $(this).attr('checked','checked');
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
        //set height for inner moal to auto for full height with upload options
        $('.modal-body').css("height","auto");

        var lines_to_enter = $('#user_entered_lines_qty').val();
        lines_to_populate = lines_to_enter;
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
            if (upload_artwork_radio == $(this).val()) {
                $(this).attr('checked', 'checked');
            }
            if (upload_artwork_option_radio == $(this).val()) {
                $(this).attr('checked', 'checked');
            }

        });
        //proceed to next (inner) modal if all checks fulfilled otherwise show error
        if (proceed_next_screen == 1) {
            $('#artworkuploadpopup').hide( );
            $('#artwork-upload-popup').trigger('click');

            if (lines_to_enter && lines_to_enter <= 50) {

                $('.upload_artwork').show();

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

    });

    /*$(document).on("click", ".browse_btn", function (e) {
        alert(111);
        //e.preventDefault();
        $(this).parents('.upload_row').find('.artwork_file').click();
    });*/
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
        //alert(1);
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
                    console.log('cancel');
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
                var i = 0;

                $('.emb_option:checked').each(function () {
                    //maintain user selected option array
                    laminations_and_varnishes[i++] = $(this).data('embellishment_parsed_title');
                });
                if (upload_artwork_radio == "upload_artwork_now") {

                    var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
                }
                var form_data = new FormData();
                if (upload_artwork_radio == "upload_artwork_now") {

                    form_data.append("file", uploadfile);
                }
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
                form_data.append("upload_artwork_radio", upload_artwork_radio);
                form_data.append("upload_artwork_option_radio", upload_artwork_option_radio);
                form_data.append("lines_to_populate", lines_to_populate);

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
                }else{
                    form_data.append("limit_exceed_designs", 'no');
                }
                alert(remaing);
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
        }else{
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
                var i = 0;

                $('.emb_option:checked').each(function () {
                    //maintain user selected option array
                    laminations_and_varnishes[i++] = $(this).data('embellishment_parsed_title');
                });
                if (upload_artwork_radio == "upload_artwork_now") {

                    var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
                }
                var form_data = new FormData();
                if (upload_artwork_radio == "upload_artwork_now") {

                    form_data.append("file", uploadfile);
                }
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
                form_data.append("laminations_and_varnishes", laminations_and_varnishes);

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
                }else{
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
    $(document).on("click", ".quantity_editor", function (e) {
        $(this).hide();
        $(this).parents('.upload_row').find('.quantity_labels').hide();
        $(this).parents('.upload_row').find('.input_rolls').show();
    });
    function verify_labels_or_rolls_qty(id) {
        var prdid = $('#cartproductid').val();
        var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
        var min_qty = parseInt($('#min_qty' + prdid).val());
        var min_rolls = parseInt($('#min_rolls' + prdid).val());
        var max_qty = parseInt($('#max_qty' + prdid).val());
        var dieacross = parseInt($('#min_rolls' + prdid).val());
        var minlabels = parseInt(min_qty / dieacross);
        var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
        var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());
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
                var requiredlabels = minlabels * rolls
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


    function update_remaing_labels() {
        var actual_qty = $('#actual_labels_qty').val();
        var total_qty = 0;
        $(".roll_labels_input").each(function (index) {
            if ($(this).val()) {
                total_qty = parseInt(total_qty) + parseInt($(this).val());
            }
        });
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
            $('#upload_remaining_labels').val(reaming);
            console.log('Actual: ' + actual_qty);
            console.log('Remaing: ' + reaming);
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
        var i = 0;

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i++] = $(this).data('embellishment_parsed_title');
        });

        $('#cart_summery_loader').show();
        $.ajax({
            url: mainUrl + 'ajax/material_update_cart_with_upload_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                cartid: cartid,
                prdid: prdid,
                persheet: labelpersheets,
                type: type,
                unitqty: cartunitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
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
                }
                $('#cart_summery_loader').hide();
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
        }else if (upload_artwork_radio ==  "artwork_to_follow"){
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
                    //alert('transactionregistration.php');
                    //window.location.reload(true);
                    //window.location.href = 'https://www.aalabels.com/transactionregistration.php';
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
    $(document).on("focus", ".labels_input", function (e) {
        old_labels_input = $(this).val();
    });
    $(document).on("focus", ".roll_labels_input", function (e) {
        old_roll_labels_input = $(this).val();
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
            $(this).parents('.upload_row').find('.quantity_updater').show();
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
            $(this).parents('.upload_row').find('.quantity_updater').show();
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
        var i = 0;

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i++] = $(this).data('embellishment_parsed_title');
        });

        // console.log("before qty 3");

        var remaing = parseInt($('#upload_remaining_labels').val());
        // alert(remaing);
        var exceed = '';
        if (remaing < 0) {
            exceed = 'yes';
        }
        $('#cart_summery_loader').show();
        $.ajax({
            url: mainUrl + 'ajax/material_update_printing_artworks_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                id: id,
                cartid: cartid,
                productid: prdid,
                labels: labels,
                sheets: sheets,
                persheet: labelpersheets,
                type: type,
                limit_exceed_sheet: exceed,
                updater: 'update',
                unitqty: cartunitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
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

                    }
                    $('#cart_summery_loader').hide();


                }
            }
        });
    });

    function clear_uploaded_artworks() {

        console.log("HERE HERE");

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
        var i = 0;

        $('.emb_option:checked').each(function () {
            //maintain user selected option array
            laminations_and_varnishes[i++] = $(this).data('embellishment_parsed_title');
        });
        $.ajax({
            url: mainUrl + 'ajax/material_update_printing_artworks_label_emb',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                cartid: cartid,
                productid: prdid,
                persheet: labelpersheets,
                type: type,
                updater: 'clear',
                unitqty: cartunitqty,
                total_emb_plate_price: total_emb_plate_price,
                press_proof: press_proof,
                laminations_and_varnishes: laminations_and_varnishes,
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

                    }
                    $('#cart_summery_loader').hide();

                }
            }
        });
    }



    $(document).on("click", ".proceed_to_checkout", function (e) {
        var prdid = $('#cartproductid').val();
        if (upload_artwork_radio ==  "upload_artwork_now") {
            var upload_option = "upload_artwork";
        }else if (upload_artwork_radio ==  "artwork_to_follow"){
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
        } else if (type == 'sheet' && uploaded_sheets < 25 && upload_option == 'upload_artwork') {
            var minqty = 25;
            if (cartunitqty == 'labels') {
                var minqty = 25 * parseInt(labelpersheets);
            }
            alert_box("Minimum " + minqty + " " + cartunitqty + " required, please adjust remaining sheets in your artworks");
            return false;
        } else if (actual_designs == remaing_designs && upload_option == 'upload_artwork') {
            alert_box("Please upload your artworks before proceeding to checkout ");
            return false;
        } else if ($('.uploadsavesection').css('display') == 'table-row' && upload_option == 'upload_artwork') {
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
            if (upload_option == 'email_artwork' || upload_option == 'design_services') {
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
            } else if ((remaing > 0 || remaing_designs > 0) && upload_option == 'upload_artwork') {
                if (remaing > 0) {
                    var text = msg_text;
                } else {
                    var text = 'designs';
                }
                swal({
                        title: 'You have reduced the number of ' + text + ' please confirm to recalculate the price.',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Confirm",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            update_cart_with_upload();
                        }
                    });
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

</script>
