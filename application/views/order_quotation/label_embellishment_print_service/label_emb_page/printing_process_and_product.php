<!-- Printing Process & Products Details Starts -->
<div id="product_content">


    <section>
        <div id="printing_process_loader" class="white-screen"
             style="position: absolute;top: 70px;right: 0;width: 100%;z-index: 999;height: 28%;display: none;background: #FFF;opacity: 0.8;">
            <div class="text-center"
                 style="margin: 80px auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 18%;border: solid 1px #CCC;">
                <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
                     style="width:139px; height:29px; " alt="AA Labels Loader">
            </div>
        </div>

        <div class="row rowflex">
            <div class="mt-15 col-md-6 col-xs-12 rowflex">
                <div class="panel panel-default rowflexdiv">
                    <div id="headingOne" class="panel-title_blue">
                        <div>Select Digital Printing Process</div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                            <span>
                                                <img onerror='imgError(this);' class="img-responsive"
                                                     src="<?= Assets ?>images/new-printed-labels/printing-process-black-thumbnail.jpg">
                                            </span>
                                <label class="containerr">Monochrome
                                    <br>Black Only
                                    <input type="radio" checked="checked" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                            <span>
                                                <img onerror='imgError(this);' class="img-responsive"
                                                     src="<?= Assets ?>images/new-printed-labels/printing-process-full-color-thumbnail.jpg">
                                            </span>
                                <label class="containerr">6 Colour
                                    <br>Digital Process
                                    <input type="radio" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                            <span>
                                                <img onerror='imgError(this);' class="img-responsive"
                                                     src="<?= Assets ?>images/new-printed-labels/printing-process-white-thumbnail.jpg">
                                            </span>
                                <label class="containerr">Add White
                                    <input type="radio" name="radio">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-15 col-md-3 col-xs-6 rowflex">
                <div class="panel panel-default rowflexdiv">
                    <div id="headingOne" class="panel-title_blue">
                        <div>Select Finish Preferences</div>
                    </div>
                    <div class="labels-form padding-15">

                        <div class="labels-form">
                            <label class="select">
                                <select id="label_coresize">
                                    <?= $rollcores ?>
                                </select>
                                <i></i> </label>
                            <label class="select">
                                <select id="woundoption">
                                    <option value="Outside">Outside Wound</option>
                                    <option value="Inside">Inside Wound</option>
                                </select>
                                <i></i> </label>

                            <input type="hidden" value="orientation1" id="label_orientation"/>
                            <div class="row dm-row">
                                <div class=" dm-box">
                                    <div style="margin:0;border: none;display: block; position: relative; font-weight: 400!important"
                                         class="thumbnail col-lg-12 col-md-7 col-sm-12 col-xs-12">

                                        <div class="col-xs-12 roll_sheets_block">

                                            <div class="btn-group btn-block dm-selector"><a
                                                        class="btn btn-default btn-block dropdown-toggle"
                                                        data-toggle="dropdown" data-value="">Orientation 01<i
                                                            class="fa fa-unsorted"></i></a>
                                                <ul class="dropdown-menu btn-block">
                                                    <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                                      data-id="orientation1">
                                                            Orientation 01
                                                            <img onerror='imgError(this);'
                                                                 src="<?= Assets ?>images/loader.gif">
                                                        </a></li>
                                                    <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                      data-id="orientation2">
                                                            Orientation 02
                                                            <img onerror='imgError(this);'
                                                                 src="<?= Assets ?>images/loader.gif"></a>
                                                    </li>
                                                    <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                                      data-id="orientation3">
                                                            Orientation 03
                                                            <img onerror='imgError(this);'
                                                                 src="<?= Assets ?>images/loader.gif"></a>
                                                    </li>
                                                    <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label of first."
                                                                                      data-id="orientation4">
                                                            Orientation 04
                                                            <img onerror='imgError(this);'
                                                                 src="<?= Assets ?>images/loader.gif"></a>
                                                    </li>
                                                    <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                     data-id="orientation5"> Orientation
                                                            05 <img
                                                                    onerror='imgError(this);'
                                                                    src="<?= Assets ?>images/loader.gif"></a></li>
                                                    <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                                     data-id="orientation6"> Orientation
                                                            06 <img
                                                                    onerror='imgError(this);'
                                                                    src="<?= Assets ?>images/loader.gif"> </a></li>
                                                    <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first."
                                                                                     data-id="orientation7"> Orientation
                                                            07 <img
                                                                    onerror='imgError(this);'
                                                                    src="<?= Assets ?>images/loader.gif"> </a></li>
                                                    <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                                     data-id="orientation8"> Orientation
                                                            08 <img
                                                                    onerror='imgError(this);'
                                                                    src="<?= Assets ?>images/loader.gif"></a></li>
                                                </ul>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>

                        <label class="select margin-bottom">
                            <select name="inquiry" id="inquiry" class="required" aria-required="true">
                                <option value="" selected="selected">Label Application</option>
                                <option value="by_hand">By Hand</option>
                                <option value="by_machine">By Machine</option>

                            </select>
                            <i></i>
                        </label>

                        <br>


                    </div>

                </div>
            </div>
            <div class="mt-15 col-md-3 col-xs-6 rowflex">
                <div class="panel panel-default rowflexdiv">
                    <div id="headingOne" class="panel-title_blue">
                        <div>Your Product(s) Detail</div>
                    </div>
                    <div class="row padding-20">
                        <div class="col-md-4">
                            <img onerror='imgError(this);' class="img-responsive"
                                 src="<?= Assets ?>images/new-printed-labels/sample-product-detail-image.jpg">
                        </div>
                        <div class="col-md-8 p-0">
                            <!--                                        <span class="product-details-title">Fluorescent Green Paper:</span>-->
                            <!--                                        <span class="product-details-description">Product Code: RR210297,-->
                            <!--                                            Label Size (mm): 210 x 294-->
                            <!--                                            Rectangular, Paper, White,-->
                            <!--                                        Permanent Adhesive.</span>-->


                            <span class="product-details-title"><span id="product_color"> </span> <span
                                        id="product_material"> </span> :</span><br>
                            <span class="product-details-description">Product Code: <span
                                        id="product_code"> </span>,<br>
                                            Label Size (mm): <span id="label_size"> </span>,
                                            <span id="product_shape"> </span>,
                                            <span id="product_material_text"> </span>,
                                            <span id="product_color_text"> </span>,
                                        <span id="product_adhesive"> </span> Adhesive.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Printing Process & Products Details End -->
