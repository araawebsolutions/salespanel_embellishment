<link href="https://www.aalabels.com/theme/site/labelfinder/css/newstyles.css?v=1.1" rel="stylesheet">
<div class="row">
    <div class="lf-pos">
        <div>
            <!--<div class="finderNote row fnTop">
                <div class="col-md-12 text-center">
                    <p class="no-margin">The label filter enables you to select and view products that closely match your search criteria through the use of search tools. Click on the “VIEW FILTERS”  button below to begin using.</p>
                </div>
            </div>-->
            <form class="labels-form labels-filters-form" id="filter-form">
                <?php $designer = "";
                if (isset($designer) and $designer == "yes"): ?>
                    <input type="hidden" value="designer" id="page_type"/>
                <?php else: ?>
                    <input type="hidden" value="finder" id="page_type"/>
                <? endif; ?>
                <input type="hidden" value="category" id="view"/>
                <input type="hidden"
                       value="<?= (isset($printer_width) and $printer_width != '') ? $printer_width : '' ?>"
                       id="printer_width"/>
                <div class="FilterMain">
                    <? if (isset($designer) and $designer == "yes"): ?>
                        <input type="hidden" id="newcategory" name="newcategory" value="A4" class="nlabelfilter"/>
                    <? else: ?>
                        <input type="hidden" id="newcategory" name="newcategory" value="<?= $category ?>"
                               class="nlabelfilter"/>
                    <? endif; ?>
                    <? if (!isset($designer) and $designer != "yes"): ?>
                        <div class="ProductThumbnailsMain" id="categorybox">
                            <label for="A4" class="ProductThumbnail Thumb1">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="A4" data-value="A4"
                                           name="category" <? if ($category == 'A4') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img src="<?= Assets ?>/labelfinder/img/a4-thumb.jpg"
                                                                      class="img-responsive" alt="A4 Sheets"/></div>
                                <div class="ProductName text-center"> A4 Sheets <br>
                                    Plain & Printed
                                </div>
                            </label>
                            <label for="A3" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="A3" data-value="A3"
                                           name="category" <? if ($category == 'A3') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img src="<?= Assets ?>labelfinder/img/a3-thumb.jpg"
                                                                      class="img-responsive" alt="A3 Sheets"/></div>
                                <div class="ProductName text-center"> A3 Sheets <br>
                                    Plain & Printed
                                </div>
                            </label>
                            <label for="SRA3" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="SRA3" data-value="SRA3"
                                           name="category" <? if ($category == 'SRA3') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img src="<?= Assets ?>labelfinder/img/a3-thumb.jpg"
                                                                      class="img-responsive" alt="SRA3 Sheets"/></div>
                                <div class="ProductName text-center"> SRA3 Sheets <br>
                                    Plain & Printed
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
                                            src="<?= Assets ?>labelfinder/img/Integrated-thumb.jpg"
                                            class="img-responsive" alt="Integrated Labels"/></div>
                                <div class="ProductName text-center"> Integrated <br>
                                    Labels
                                </div>
                            </label>
                            <div class="IntergratedMain integratedbrands hide" style="display:none;float:left;">
                                <div class="ThermalPrinter">
                                    <label class="ThermalManufactureMain select">
                                        <select id="brands" name="brands" autocomplete="off" class="nlabelfilter">
                                            <option value="">Select Brand</option>
                                            <?php if (isset($compatible) and $compatible == 'yes' and isset($catdata['CategoryName'])) { ?>
                                                <option selected="selected" value="<?= $catdata['CategoryName'] ?>">
                                                    <?= $catdata['CategoryName'] ?>
                                                </option>
                                            <? } ?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <label for="Roll" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="Roll" data-value="Roll"
                                           name="category" <? if ($category == 'Roll') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img src="<?= Assets ?>labelfinder/img/roll-thumb.jpg"
                                                                      class="img-responsive" alt="Roll Labels"/></div>
                                <div class="ProductName text-center"> Roll Labels <br>
                                    Plain & Printed
                                </div>
                            </label>
                            <label for="thermal" class="ProductThumbnail" data-trigger="manual"
                                   data-toggle="category-tooltip" data-placement="right"
                                   title="Please select category first"
                                   data-original-title="Please select category first">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="thermal" data-value="thermal"
                                           name="category" <? if ($category == 'thermal') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img
                                            src="<?= Assets ?>labelfinder/img/thermal-printer.jpg"
                                            class="img-responsive" style="border:1px solid #d9d9d9"
                                            alt="Thermal Printer"/></div>
                                <div class="ProductName text-center">Search Label by<br>
                                    Thermal Printer
                                </div>
                            </label>
                            <label for="A5" class="ProductThumbnail">
                                <div class="ThumbnailsRadio">
                                    <input type="radio" id="A5" data-value="A5"
                                           name="category" <? if ($category == 'A5') {
                                        echo 'checked="checked"';
                                    } ?>>
                                    <span class="checkround"></span></div>
                                <div class="ProductThumbnailImg"><img src="<?= Assets ?>labelfinder/img/A5E048.png"
                                                                      class="img-responsive" alt="Roll Labels"/></div>
                                <div class="ProductName text-center"> A5 Sheets <br>
                                    Plain & Printed
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
                                            <i></i>
                                        </label>
                                        <label class="select">
                                            <select name="model" id="model" class="nlabelfilter ThermalManufacture"
                                                    tabindex="10">
                                                <option value=""> Select Model</option>
                                                <? if (isset($model_option) and $model_option != '') echo $model_option; ?>
                                            </select>
                                            <i></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="ProductName searchtext text-center" style="position: relative;top: 10px;">
                                    Search Label by Thermal Printer Model.
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                    <div class="clear"></div>
                    <div class="ChooseShapesMain">
                        <div class="ChooseShapes">
                            <h4>Choose a Shape :</h4>
                            <input type="hidden" id="shape" value="<?= ($shape) ? $shape : '' ?>"/>
                            <div id="shapes_box">
                                <button type="button" disabled="disabled" class="btn_shape rectangle"
                                        data-toggle="tooltip" title="Rectangle" data-val="Rectangle"></button>
                                <button type="button" disabled="disabled" class="btn_shape square" data-toggle="tooltip"
                                        title="Square" data-val="Square"></button>
                                <button type="button" disabled="disabled" class="btn_shape circular"
                                        data-toggle="tooltip" title="Circular" data-val="Circular"></button>
                                <button type="button" disabled="disabled" class="btn_shape oval" data-toggle="tooltip"
                                        title="Oval" data-val="Oval"></button>
                                <button type="button" disabled="disabled" class="btn_shape star" data-toggle="tooltip"
                                        title="Star" data-val="Star"></button>
                                <button type="button" disabled="disabled" class="btn_shape heart" data-toggle="tooltip"
                                        title="Heart" data-val="Heart"></button>
                                <button type="button" disabled="disabled" class="btn_shape triangle"
                                        data-toggle="tooltip" title="Triangle" data-val="Triangle"></button>
                                <button type="button" disabled="disabled" class="btn_shape perforated"
                                        data-toggle="tooltip" title="Perforated" data-val="Perforated"></button>
                                <button type="button" disabled="disabled" class="btn_shape irregular"
                                        data-toggle="tooltip" title="Irregular" data-val="Irregular"></button>
                                <button type="button" disabled="disabled" class="btn_shape anti-tamper"
                                        data-toggle="tooltip" title="Anti-Tamper" data-val="Anti-Tamper"></button>
                            </div>
                        </div>
                        <div class="PrinterCopierMain col-xs-12" data-trigger="manual" data-toggle="printer-tooltip"
                             data-placement="right" title="Please select printer manufacturer and model first."
                             data-original-title="Please select printer manufacturer and model first.">
                            <label class="select">
                                <select name="printer" id="printer" class="PrinterCopier nlabelfilter" tabindex="10">
                                    <option value=""> Printer / Copier Type</option>
                                </select>
                                <i></i> </label>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <!-- Shapes End -->
                    <!-- Label Width + Height Dropdown Start -->
                    <div class="SectionThreeMain col-md-12">
                        <div class="SectionLeft col-md-6">
                            <div class="LabelWidthMain" id="width_box">
                                <div class="LabelWidthHeader text-center" id="width_box_text"> LABEL WIDTH (mm)</div>
                                <div class="LabelMain">
                                    <div data-role="page" class="Range">
                                        <div class="">
                                            <label class="input pull-left" style="width:40%">
                                                <input type="text" class="control_input allowdecimal"
                                                       placeholder="Min width" id="width_min" name="width_min">
                                            </label>
                                            <label class="input pull-right" style="width:40%">
                                                <input type="text" class="control_input allowdecimal"
                                                       placeholder="Max width" id="width_max" name="width_max">
                                            </label>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="clearfix" style="margin-bottom:20px"></div>
                                        <div class="lablefilterslider" style="clear:left;">
                                            <div id="width_slider" class="slider sliderRange sliderBlue"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix rangelimit">
                                        <div class="col-xs-6 pull-left"><small class="width_lowerlimit">0</small></div>
                                        <div class="col-xs-6 text-right"><small class="width_upperlimit">0</small></div>
                                    </div>
                                </div>
                            </div>
                            <div class="LabelHeightMain" id="height_box">
                                <div class="LabelWidthHeader text-center"> Label Height (mm)</div>
                                <div class="LabelMain">
                                    <div data-role="page" class="Range">
                                        <div class="">
                                            <label class="input pull-left" style="width:40%">
                                                <input type="text" class="control_input allowdecimal"
                                                       placeholder="Min height" id="height_min" name="height_min">
                                            </label>
                                            <label class="input pull-right" style="width:40%">
                                                <input type="text" class="control_input allowdecimal"
                                                       placeholder="Max height" id="height_max" name="height_max">
                                            </label>
                                        </div>
                                        <div class="clearfix" style="margin-bottom:20px"></div>
                                        <div class="lablefilterslider" style="clear:left;">
                                            <div id="height_slider" class="slider sliderRange sliderBlue"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix rangelimit">
                                        <div class="col-xs-6 pull-left"><small class="height_lowerlimit">0</small></div>
                                        <div class="col-xs-6 text-right"><small class="height_upperlimit">0</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="WidthHightCheckbox">
                                <label class="check">Include opposite dimensions in the search criteria e.g. Height for
                                    Width
                                    <input type="checkbox" checked="checked" name="opposite_dimension"
                                           id="opposite_dimension">
                                    <span class="checkmark"></span> </label>
                            </div>
                        </div>
                        <div class="SectionRight col-md-6">
                            <div class="Dropdowns">
                                <? if (isset($designer) and $designer == "yes"): ?>
                                    <div class="template_search col-xs-12">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Have a Product Code ?" type="text"
                                                   id="filter_search_box" autocomplete="off">
                                            <span class="input-group-addon">
                    <button type="button" style="background: transparent; border: 0px" id="filter_search_handler"> <i
                                class="fa fa-search" aria-hidden="true"></i> </button>
                    </span></div>
                                    </div>
                                <?php endif; ?>
                                <label class="SelectColorMain select col-xs-6">
                                    <select name="material" id="material" class="nlabelfilter" tabindex="10">
                                        <option value="">Select Material</option>
                                    </select>
                                    <i></i> </label>
                                <label class="SelectMaterialMain select col-xs-6">
                                    <select name="color" id="color" class="nlabelfilter" tabindex="10">
                                        <option value="">Label Colour</option>
                                    </select>
                                    <i></i> </label>
                                <label class="SelectColorMain select col-xs-6">
                                    <select name="adhesive" id="adhesive" class="nlabelfilter" tabindex="10">
                                        <option value="">Select Adhesive Type</option>
                                    </select>
                                    <i></i> </label>
                                <label class="SelectMaterialMain select col-xs-6">
                                    <select name="finish" id="finish" class="nlabelfilter" tabindex="10">
                                        <option value="">Select Finish</option>
                                    </select>
                                    <i></i> </label>
                                <div class="clear"></div>
                                <div class="P-FoundBtn">
                                    <div class="ProductsFound sizefound"><span id="label_counter1"> 0 </span>
                                        <h4>Products found</h4>
                                    </div>
                                    <div class="ResetBtn"><a href="javascript:void(0);"
                                                             class="btn ResetButton reset_button" role="button"> <i
                                                    class="fa fa-refresh"></i>&nbsp;&nbsp;Reset Filter</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Label Width + Height Dropdown End -->
                </div>
                <div class="clear"></div>
                <input type="hidden" value="0" id="product_count"/>
                <input type="hidden" value="0" id="start_limit"/>
            </form>
        </div>
        <!--<div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <button class="show-h hide_filter"><span><i aria-hidden="true" class="fa fa-bars"></i>
      <div class="clea"></div>
      HIDE FILTERS</span></button>
        </div>-->
    </div>
</div>
<div id="compare_modal" class="modal fade aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content no-padding">
            <div class="panel no-margin">
                <div class="panel-heading">
                    <h3 class="pull-left no-margin"><b>Compare Products</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-times-circle"></i></button>
                    <div class="clear"></div>
                </div>
                <div class="panel-body">
                    <div id="compare_modal_content"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var shape_list = [];
    <?php $shapes = $this->filter_model->generate_category_shapes();?>
    shape_list = <?=$shapes?>;
</script>
