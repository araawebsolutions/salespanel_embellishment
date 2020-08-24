<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row">
        <div class="thumbnail">
            <div class="clear10"></div>
            <div class="col-md-7 col-sm-7 text-justify">
                <div>
                    <form class="labels-form labels-filters-form">
                        <input type="hidden" value="" id="product_count"/>
                        <input type="hidden" value="" id="category_id"/>
                        <input type="hidden" value="" id="available_in"/>
                        <div class="">
                            <div class="col-lg-12 col-md-12 col-sm-12 p0 m0">
                                <p>Select the label shape and size required using the shape icons and size filters
                                    below. Sizes can be filtered using the sliders or by free typing in the boxes
                                    provided and you can also see size options with the dimensions switched by ticking
                                    the box beneath the size sliders.
                                    <!--Alternatively if you know the product code for the label enter it  in the box below.--></p>
                                <div class="clear15"></div>
                                <div id="shape_text" class="labelF "> Label Shapes</div>
                                <input id="shape" value="rectangle" type="hidden">
                                <div id="shapes_box">
                                    <?= $shapes ?>
                                </div>
                            </div>
                            <div class="clear15"></div>
                            <div id="width_box" class="col-lg-6 col-md-6 col-sm-6">
                                <div id="width_box_text" class="labelF m0"> Label Width <small>(mm)</small></div>
                                <div class="">
                                    <div class="clear15"></div>
                                    <label class="input pull-left" style="width:45%; margin-bottom:20px;">
                                        <input type="text" class="control_input allowdecimal" placeholder="Min width" id="width_min" name="width_min">
                                    </label>
                                    <label class="input pull-right" style="width:45%; margin-bottom:20px;">
                                        <input type="text" class="control_input allowdecimal" placeholder="Max width" id="width_max" name="width_max">
                                    </label>
                                </div>
                                <div class="lablefilterslider" style="clear:left;">
                                    <div id="width_slider" class="slider sliderRange sliderBlue"></div>
                                </div>
                            </div>
                            <div id="height_box" class="col-lg-6 col-md-6 col-sm-6">
                                <div class="labelF m0"> Label Height <small>(mm)</small></div>
                                <div class="">
                                    <div class="clear15"></div>
                                    <label class="input pull-left" style="width:45%; margin-bottom:20px;">
                                        <input type="text" class="control_input allowdecimal" placeholder="Min height" id="height_min" name="height_min">
                                    </label>
                                    <label class="input pull-right" style="width:45%; margin-bottom:20px;">
                                        <input type="text" class="control_input allowdecimal" placeholder="Max height" id="height_max" name="height_max">
                                    </label>
                                </div>
                                <div class="lablefilterslider" style="clear:left;">
                                    <div id="height_slider" class="slider sliderRange sliderBlue"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 m-t-15 opposite_dimension"
                                 style="margin-top: 20px;margin-bottom: 10px;">
                                <label class="checkbox">
                                    <input type="checkbox" id="opposite_dimension" checked="checked"
                                           name="opposite_dimension" value="0" class="textOrange">
                                    <i></i> Include opposite dimensions in the search criteria e.g. Height for Width
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="roll-and-sheet-ads  col-sm-12">
                    <div class="text-center">
                        <h2>Choose from 1000’s <br>
                            <small style=" font-size:14px;">of Shapes and Sizes in Roll and Sheet Format for your
                                Printed Labels.</small></h2>
                    </div>
                    <img onerror='imgError(this);'
                         src="<?= Assets ?>images/categoryimages/labelShapes/ws-banner-new.png"
                         alt="Printed Labels on Sheets and Rolls" class="img-responsive"/></div>
                <div class="clear10"></div>

                <!--<div class="m-b-10 m-t-10">
                          <div class="input-group">
                                <input class="form-control filter_search_box" placeholder="Enter Product Code (If known)" type="text">
                                <span class="input-group-addon">
                                    <button type="button" style="background: transparent; border: 0px" class="filter_search_handler">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </div>-->

            </div>
            <div class="clear10"></div>
            <div class="col-xs-12">
                <div class="alert alert-warning no-margin " style="padding: 10px !important;"><small>The label choices
                        e.g. size, material, adhesive etc. selected could be available in both roll and sheet formats
                        and if so both options will be displayed on the page here. Allowing you to select the most
                        suitable for your application and budget. If the label is not available in both formats you will
                        see only one or the other displayed, not both.</small></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="ajax_finder_content"></div>
</div>
