<div id="aa_loader" class="white-screen" style="display:none ;position: absolute;z-index: 1;left: 0;right: 0;">
    <div class="loading-gif text-center" style="z-index: 1;padding-top: 7%;">
        <img src="https://www.aalabels.com/theme/site/images/loader.gif" class="image"
             style="width:160px; height:43px; ">
    </div>
</div>

<link rel="stylesheet" href="<?= ASSETS ?>assets/css/newstyles.css">
<link rel="stylesheet" href="<?= ASSETS ?>assets/css/jquery.mCustomScrollbar.css">
<script src="<?= ASSETS ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>


<?php $category = $type; ?>
<!-- Label Finder Starts  -->
<style>
    .labels-form label {
        margin-bottom: 10px !important;
    }

    .input-group > .custom-select:not(:last-child), .input-group > .form-control:not(:last-child) {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }
</style>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="lf-pos">
                <form class="labels-form labels-filters-form" id="filter-form" style="display: block;">
                    <input type="hidden" value="finder" id="page_type">
                    <input type="hidden" value="" id="view">
                    <input type="hidden" value="" id="printer_width">
                    <div class="FilterMain">
                        <input type="hidden" id="newcategory" name="newcategory" value="<?= $category ?>"
                               class="nlabelfilter">
                        <input type="hidden" id="LabelPerDie" name="LabelPerDie" value="" class="nlabelfilter"/>
                        <div class="ProductThumbnailsMain" id="categorybox">
                            <label for="A5" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="A5" data-value="A5"
                                           name="category" <? if ($category == 'A5') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg">
                                    <img src="<?PHP ECHO Assets ?>labelfinder/img/a5-thumb.jpg"
                                         class="img-responsive" alt="A5 Sheets" style="width:75px;"></div>
                                <div class="ProductName text-center"> A5 Sheets <br>
                                    Plain &amp; Printed
                                </div>
                            </label>
                            <label for="A4" class="ProductThumbnail Thumb1">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="A4" data-value="A4"
                                           name="category" <? if ($category == 'A4') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="https://www.aalabels.com/theme/site//labelfinder/img/a4-thumb.jpg"
                                            class="img-responsive" alt="A4 Sheets"></div>
                                <div class="ProductName text-center"> A4 Sheets <br>
                                    Plain &amp; Printed
                                </div>
                            </label>
                            <label for="A3" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="A3" data-value="A3"
                                           name="category" <? if ($category == 'A3') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="https://www.aalabels.com/theme/site/labelfinder/img/a3-thumb.jpg"
                                            class="img-responsive" alt="A3 Sheets"></div>
                                <div class="ProductName text-center"> A3 Sheets <br>
                                    Plain &amp; Printed
                                </div>
                            </label>
                            <label for="SRA3" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="SRA3" data-value="SRA3"
                                           name="category" <? if ($category == 'SRA3') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="https://www.aalabels.com/theme/site/labelfinder/img/a3-thumb.jpg"
                                            class="img-responsive" alt="SRA3 Sheets"></div>
                                <div class="ProductName text-center"> SRA3 Sheets <br>
                                    Plain &amp; Printed
                                </div>
                            </label>
                            <label for="Integrated" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="Integrated" data-value="Integrated"
                                           name="category" <? if ($category == 'Integrated') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="https://www.aalabels.com/theme/site/labelfinder/img/Integrated-thumb.jpg"
                                            class="img-responsive" alt="Integrated Labels"></div>
                                <div class="ProductName text-center"> Integrated <br>
                                    Labels
                                </div>
                            </label>

                            <label for="Roll" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="Roll" data-value="Roll"
                                           name="category" <? if ($category == 'Roll') {
                                        echo 'checked="checked"';
                                    } ?> >
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="https://www.aalabels.com/theme/site/labelfinder/img/roll-thumb.jpg"
                                            class="img-responsive" alt="Roll Labels"></div>
                                <div class="ProductName text-center"> Roll Labels <br>
                                    Plain &amp; Printed
                                </div>
                            </label>
                            <label for="thermal" class="ProductThumbnail" data-trigger="manual"
                                   data-toggle="category-tooltip" data-placement="right" title=""
                                   data-original-title="Please select category first">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="thermal" data-value="thermal"
                                           name="category" <? if ($category == 'thermal') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="https://www.aalabels.com/theme/site/labelfinder/img/thermal-printer.jpg"
                                            class="img-responsive" style="border:1px solid #d9d9d9"
                                            alt="Thermal Printer"></div>
                                <div class="ProductName text-center">Search Label by<br>
                                    Thermal Printer
                                </div>
                            </label>
                            <div class="ThermalPrinterMain thermaloptions">
                                <div class="ThermalPrinter">
                                    <div class="ThermalManufactureMain">
                                        <label class="select">
                                            <select name="manufaturer" id="manufaturer"
                                                    class="ThermalManufacture Manufacture1" tabindex="10">
                                                <option value=""> Select Manufacturer</option>
                                                <? if (isset($make_option) and $make_option != '') echo $make_option; ?>
                                            </select>
                                            <i></i> </label>
                                        <label class="select">
                                            <select name="model" id="model" class="nlabelfilter ThermalManufacture"
                                                    tabindex="10">
                                                <option value=""> Select Model</option>
                                                <? if (isset($model_option) and $model_option != '') echo $model_option; ?>
                                            </select>
                                            <i></i> </label>
                                    </div>
                                </div>
                                <div class="ProductName searchtext text-center" style="top: 10px;"> Search Label by
                                    Thermal Printer Model.
                                </div>
                            </div>

                        </div>

                        <div class="clear"></div>

                        <div class="ChooseShapesMain no-padding" style="margin-bottom: 1rem;">
                            <div class="ChooseShapes">
                                <h4>Choose a Shape :</h4>
                                <input type="hidden" id="shape" value="<?= ($shape) ? $shape : '' ?>">
                                <div id="shapes_box">
                                    <button type="button" class="btn_shape anti-tamper" data-val="Anti-Tamper"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Anti-Tamper"
                                    =""=""></button>
                                    <button type="button" class="btn_shape circular" data-val="Circular"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Circular"
                                    =""=""></button>
                                    <button type="button" class="btn_shape heart" data-val="Heart" data-toggle="tooltip"
                                            data-placement="top" title="" data-original-title="Heart"
                                    =""=""></button>
                                    <button type="button" class="btn_shape irregular" data-val="Irregular"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Irregular"
                                    =""=""></button>
                                    <button type="button" class="btn_shape oval active" data-val="Oval"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Oval"
                                    =""=""></button>
                                    <button type="button" class="btn_shape perforated" data-val="Perforated"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Perforated"
                                    =""=""></button>
                                    <button type="button" class="btn_shape rectangle" data-val="Rectangle"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Rectangle"
                                    =""=""></button>
                                    <button type="button" class="btn_shape square" data-val="Square"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Square"
                                    =""=""></button>
                                    <button type="button" class="btn_shape star" data-val="Star" data-toggle="tooltip"
                                            data-placement="top" title="" data-original-title="Star"
                                    =""=""></button>
                                    <button type="button" class="btn_shape triangle" data-val="Triangle"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Triangle"
                                    =""=""></button>
                                </div>
                            </div>


                            <!--<div class="PrinterCopierMain PrinterCopierMains col-xs-12" data-trigger="manual"
                                          data-toggle="printer-tooltip" data-placement="right"
                                          title="Please select printer manufacturer and model first."
                                          data-original-title="Please select printer manufacturer and model first.">
                                <label class="select">
                                    <select name="printer" id="printer" class="PrinterCopier nlabelfilter" tabindex="10">
                                        <option value=""> Printer / Copier Type</option>
                                    </select>
                                    <i></i> </label>
                            </div>-->


                        </div>
                        <div class="clear"></div>
                        <!-- Shapes End -->
                        <!-- Label Width + Height Dropdown Start -->


                        <div class="col-md-12 SectionThreeMain">
                            <div class="row">
                                <div class="col-md-1 button_column">

                                    <div class="button_triggers">
                                        <a href="javascript:void(0);" data-val="labels_by_size"
                                           class="labels_by_size btn_trigger" data-role="button" style="display:none;">
                                            <img style="margin: 0 auto;"
                                                 src="<?= Assets ?>images/finder/label-by-size-new.png"
                                                 class="img-responsive"/>
                                            <span class="trigger_label">Filter by Label Size</span>
                                        </a>
                                        <a href="javascript:void(0);" data-val="labels_per_sheet"
                                           class="labels_per_sheet btn_trigger" data-role="button">
                                            <img style="margin: 0 auto;"
                                                 src="<?= Assets ?>images/finder/label-per-sheet-new.png"
                                                 class="img-responsive"/>
                                            <span class="trigger_label">Filter by<br/>Labels per Sheet</span>
                                        </a>
                                    </div>
                                </div>


                                <div class="col-md-8 slider_column">
                                    <div id="width_height_triggers">
                                        <div class="LabelWidthMain" id="width_box">
                                            <div class="LabelWidthHeader text-center" id="width_box_text">Label Width
                                                <small>(mm)</small>
                                            </div>
                                            <div class="LabelMain">
                                                <div data-role="page" class="Range">
                                                    <div class="">
                                                        <label class="input pull-left" style="width:46%">
                                                            <input type="text" class="control_input allowdecimal"
                                                                   placeholder="Min width" id="width_min"
                                                                   name="width_min">
                                                        </label>
                                                        <label class="input pull-right" style="width:46%">
                                                            <input type="text" class="control_input allowdecimal"
                                                                   placeholder="Max width" id="width_max"
                                                                   name="width_max">
                                                        </label>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="clearfix" style="margin-bottom:20px"></div>
                                                    <div class="lablefilterslider" style="clear:left;">
                                                        <div id="width_slider"
                                                             class="slider sliderRange sliderBlue"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix rangelimit">
                                                    <div class="col-xs-6 pull-left">
                                                        <small class="width_lowerlimit">14</small>
                                                    </div>
                                                    <div class="col-xs-6 text-right">
                                                        <small class="width_upperlimit">100</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="LabelHeightMain" id="height_box">
                                            <div class="LabelWidthHeader text-center"> Label Height (mm)</div>
                                            <div class="LabelMain">
                                                <div data-role="page" class="Range">
                                                    <div class="">
                                                        <label class="input pull-left" style="width:46%">
                                                            <input type="text" class="control_input allowdecimal"
                                                                   placeholder="Min height" id="height_min"
                                                                   name="height_min">
                                                        </label>
                                                        <label class="input pull-right" style="width:46%">
                                                            <input type="text" class="control_input allowdecimal"
                                                                   placeholder="Max height" id="height_max"
                                                                   name="height_max">
                                                        </label>
                                                    </div>
                                                    <div class="clearfix" style="margin-bottom:20px"></div>
                                                    <div class="lablefilterslider" style="clear:left;">
                                                        <div id="height_slider"
                                                             class="slider sliderRange sliderBlue"></div>
                                                    </div>
                                                </div>
                                                <div class="clearfix rangelimit">
                                                    <div class="col-xs-6 pull-left">
                                                        <small class="height_lowerlimit">12</small>
                                                    </div>
                                                    <div class="col-xs-6 text-right">
                                                        <small class="height_upperlimit">235</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="WidthHightCheckbox">
                                            <label class="check" style="position:inherit !important;">
                                                Include opposite dimensions in the search criteria e.g. Height for Width
                                                <input type="checkbox" checked="checked" name="opposite_dimension"
                                                       id="opposite_dimension"> <span class="checkmark"
                                                                                      style="    margin-left: 13px;"></span>
                                            </label>
                                        </div>

                                    </div>
                                    <div id="label_per_sheet_triggers" style="display:none">
                                        <div class="container_of_labels mCustomScrollbar" id="container_of_labels">
                                            <div class="datadata"></div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-3 pull-right">


                                    <!--<div class="PrinterCopierMain PrinterCopierMains col-xs-12" data-trigger="manual"
                                              data-toggle="printer-tooltip" data-placement="right"
                                              title="Please select printer manufacturer and model first."
                                              data-original-title="Please select printer manufacturer and model first.">
                                    <label class="select">
                                        <select name="printer" id="printer" class="PrinterCopier nlabelfilter" tabindex="10">
                                            <option value=""> Printer / Copier Type</option>
                                        </select>
                                        <i></i> </label>
                                </div>-->


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="template_search  template_search_new input-group"
                                                 style="margin-left: 15px; width: 96%;">
                                                <input class="form-control" placeholder="Know your Product Code?"
                                                       type="text" id="filter_search_box" autocomplete="off"
                                                       style="padding-left:10px;">
                                                <span class="input-group-addon"
                                                      style="z-index: 10;padding: 4px 7px; background: white; border: none; position:  absolute; right: 3px; top: 3px;">
													 <button type="button" style="background: transparent; border: 0;"
                                                             id="filter_search_handler"> <i class="fa fa-search"
                                                                                            aria-hidden="true"></i> </button>
												 </span>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="select col-xs-6" style="margin-left:15px;">
                                                <select name="material" id="material" class="nlabelfilter"
                                                        tabindex="10">
                                                    <option value="">Select Material</option>
                                                </select>
                                                <i></i> </label>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="select col-xs-6" style="margin-left:15px;">
                                                <select name="color" id="color" class="nlabelfilter" tabindex="10">
                                                    <option value="">Label Colour</option>
                                                </select>
                                                <i></i> </label>
                                        </div>

                                    </div>

                                    <!-- <div class="row">
                                         <div class="col-md-6">
                                             <label class=" select col-xs-6" style="margin-left:15px;">
                                                 <select name="adhesive" id="adhesive" class="nlabelfilter" tabindex="10">
                                                     <option value="">Select Adhesive Type</option>
                                                 </select>
                                                 <i></i> </label>
                                         </div>
                                         <div class="col-md-6 pull-right">
                                             <label class="select col-xs-6" style="margin-left:10px;">
                                                 <select name="finish" id="finish" class="nlabelfilter" tabindex="10">
                                                     <option value="">Select Finish</option>
                                                 </select>
                                                 <i></i> </label>
                                         </div>
                                     </div>-->


                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                         </div>
                                         <div class="col-md-6">
                                             <div class="template_search  template_search_new input-group" style="margin-left:10px; width:97%">
                                                     <input class="form-control" placeholder="Know your Product Code?" type="text" id="filter_search_box" autocomplete="off" style="padding-left:10px;">
                                                     <span class="input-group-addon" style="z-index: 10;padding: 4px 7px; background: white; border: none; position:  absolute; right: 3px; top: 3px;">
                                                         <button type="button" style="background: transparent; border: 0;" id="filter_search_handler"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                                     </span>
                                             </div>





                                         </div>
                                    </div>-->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="ProductsFound sizefound"><span id="label_counter1">0</span>
                                                <h4>Products found</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <div class="ResetBtn"><a href="javascript:void(0);"
                                                                     class="btn ResetButton reset_button" role="button">
                                                    <i
                                                            class="fa fa-refresh"></i>&nbsp;&nbsp;Reset Filter</a></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Label Width + Height Dropdown End -->


                        </div>
                        <div class="clear"></div>
                        <input type="hidden" value="0" id="product_count">
                        <input type="hidden" value="0" id="start_limit">

                </form>
            </div>


        </div>
    </div>
</div>

<!-- end row -->
<!-- Label Finder Ends  -->

<!-- Products View Start  -->
<!--<div id="ajax_material_sorting"></div>-->
<!-- Products View End  -->
<style>
    /**CSS BY JAWAD 15-05-2019 **/
    .ui-slider-horizontal .ui-slider-handle:nth-child(3) {
        margin-left: 7px !important;
    }

    .ui-slider-horizontal .ui-slider-handle:nth-child(2) {
        margin-left: -7px !important;
    }


</style>

<script>
    var contentbox = $('#ajax_material_sorting');
    var shape_list = [];
    <?php $shapes = $this->filter_model->generate_category_shapes();?>
    shape_list = <?=$shapes?>;


    /** New Filter **/

    /*** NEW JS LABEL FINDER 01-04-2019 ***/
    $(document).on("click", "#filter_search_handler", function (e) {
        var val = $("#filter_search_box").val();
        if (val == '') {
            swal("Please type the code");
            $("#filter_search_box").css("border", "1px solid red");
            return false;
        } else {
            $("#filter_search_box").css("border", "1px solid #a9a9a9");
        }
        $('.nlabelfilter:not("#newcategory")').val('');
        $('#shape').val('');
        $('.btn_shape').removeClass('active');
        filter_data('search', '');
    });

    /* LABEL PER SHEET IMPLEMENTATION */

    $(document).on("click", ".lps_item_box ", function (e) {
        var labelperdie = $(this).data('labelperdie');
        if (labelperdie != '' && labelperdie != 'undefined') {
            $(".lps_item_box").removeClass("active");
            $(this).addClass("active");
            $("#LabelPerDie").val(labelperdie);
            $("#LabelPerDie").trigger('change');
        }
    });

</script>

<script type="text/javascript">
    $(document).on("click", ".btn_trigger", function (e) {
        /*$(".btn_trigger").removeClass("active");
        $(this).addClass("active");*/

        $(".btn_trigger").show();
        $(this).hide();

        var trigger_type = $(this).data('val');
        if (trigger_type == "labels_by_size") {
            $("#width_height_triggers").show();
            $("#label_per_sheet_triggers").hide();
            $(".slider_column").removeClass("labels_per_sheet_row");
        } else if (trigger_type == "labels_per_sheet") {
            $("#label_per_sheet_triggers").show();
            $("#width_height_triggers").hide();
            $(".slider_column").addClass("labels_per_sheet_row");
        }
    });
    (function ($) {
        $(".container_of_labels").mCustomScrollbar({
            axis: 'y',
            theme: 'rounded-dark'
        });
    })(jQuery);
</script>
