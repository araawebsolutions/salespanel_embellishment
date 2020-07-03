<div class="thumbnail">
    <div class="row">
        <input type="hidden" id="cartid" value="<?= $details['cartid'] ?>"/>
        <input type="hidden" id="cartproductid" value="<?= $details['ProductID'] ?>"/>
        <input type="hidden" id="cartunitqty" value="<?= $unitqty ?>"/>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 UploadMainSelection">
            <div class="clear5"></div>
            <div class="col-xs-12">
                <p class="text-justify">Please upload and attach your artwork for this order. You can include up to 15
                    separate artworks. If the number of artworks exceeds this, then amend the number of designs to be
                    printed on the next page to include these in your order and send the additional files, not uploaded,
                    via email to: <a href="#">customercare@aalabels.com</a> and these will be assigned to your order for
                    production.</p>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 text-justify">
                <div class="blue_box col-md-12 col-xs-12 col-sm-12">
                    <h3>Do you have artwork?</h3>
                    <div class=" labels-form col-md-10">
                        <label class="radio">
                            <input name="upload_option" class="upload_option textOrange" value="upload_artwork"
                                   checked="" type="radio">
                            <i></i>Yes I have artwork for upload now</label>
                        <label class="radio">
                            <input class="upload_option textOrange" name="upload_option" value="email_artwork"
                                   type="radio">
                            <i></i>Yes I have artwork and will send via email. </label>
                        <label class="radio">
                            <input class="upload_option textOrange" name="upload_option" value="design_services"
                                   type="radio">
                            <i></i>I do not have artwork and would like to use your design services</label>
                    </div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <button class="btn orangeBg proceed_upload" style="margin-top:50px"> Continue <i
                                        class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-md-7 col-xs-12 col-sm-7 text-justify">
                    <div class="clear10"></div>
                    <div class="title"><b>Print-Ready Digital Artwork</b></div>
                    <div class="clear10"></div>
                    <p>Producing digital artwork can sometimes seem difficult and poorly produced artwork can also
                        result in disappointment with the printed image. </p>
                    <p>We want to give you the best quality printed graphic we can on your labels and to achieve this we
                        need the best possible source material to work from. </p>
                    <p>So if you are not conversant with the production of artwork, or even if you are, it might still
                        be worth taking the time to read and review our guidelines to get the best image quality for
                        your labels and save time and money in the future.</p>
                </div>
                <div class="hidden-xs col-sm-5 col-md-5 text-center m-t-10">
                    <!--<img onerror='imgError(this);' class="img-responsive lSumR_img" src="<?= Assets ?>images/categoryimages/labelShapes/digital_printing_2.png"> -->
                    <img onerror='imgError(this);' class="lSumR_img" height="249"
                         src="<?= Assets ?>images/categoryimages/labelShapes/digital_printing_2.png"
                         alt="Epson Label Printer"></div>
            </div>
            <div class="clear10"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12"><a href="javascript:void(0);" data-value="2" class="btn-block btn blue2  step-back" role="button"> <i
                                    class="fa fa-arrow-circle-left"></i> Back to Printing</a></div>
                    <div class="clear10 hidden-lg hidden-md hidden-sm"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12"><a class="btn-block btn orange proceed_upload"
                                                                href="javascript:void(0);"> Continue <i
                                    class="fa fa-arrow-circle-right"></i> </a></div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 lSumR print_option_box" style="display:none;">
            <div class="design_services" style="display:none;">
                <?php include_once(APPPATH . '/views/material_print_service/upload/print_designs_service.php'); ?>
            </div>
            <div class="email_artwork1" style="display:none;min-height:520px;">
                <div class="clear5"></div>
                <div class="col-md-12 text-justify">
                    <div class="">
                        <div class="title"><b>Proceed to Checkout (without using our Design Service)</b></div>
                        <div class="clear10"></div>
                        <div class="col-md-12 text-justify">
                            <p>If you do not have your press-ready artwork available for upload, but can provide it at a
                                later date and want to proceed to place your order. You can do so by entering the number
                                of separate designs you will be supplying in the box below and proceed to checkout. </p>
                            <div class="col-lg-3 col-md-3 col-sm-12 p0">
                                <input id="otherdesigns" class="form-control allownumeric" maxlength="5"
                                       placeholder="+1" value="" type="text">
                                <div class="row" style="text-align:center;"><a href="javascript:void(0);"
                                                                               style="display:none;"
                                                                               class="clear_b otherdesigns_updatebtn">
                                        <i class="fa fa-refresh"></i> Update </a></div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12 m-t-15 ">Please enter the number of separate designs
                                to be printed.
                            </div>
                            <div class="clear10"></div>
                            <p>You will subsequently need to provide the artwork as file attachments to <a href="#">customercare@aalabels.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upload_artwork" style="display:none;">
                <?php include_once(APPPATH . '/views/material_print_service/upload/upload_artwork_files.php'); ?>
            </div>
            <div class="clear"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <button class="btn-block btn blue2 backtouploadwindow" role="button"><i
                                    class="fa fa-arrow-circle-left"></i> Back to Artwork
                        </button>
                    </div>
                    <div class="clear10 hidden-lg hidden-md hidden-sm"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <button class="btn-block btn orange proceed_to_checkout">Proceed to Checkout <i
                                    class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="clear10"></div>
            <div class="lSum">
                <div id="product_summary_overview" class="col-xs-12">
                    <?php include_once(APPPATH . '/views/material_print_service/product_overview_sidebar.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content thumb_p15">
            <div class="title">
                <div class="col-md-8">
                    <div class="roll-icon pull-left"><img onerror='imgError(this);' class=""
                                                          src="<?= Assets ?>images/categoryimages/labelShapes/printed_roll.png"
                                                          alt="Roll Icon"></div>
                    <div class="m-t-15"></div>
                    <h4 class="pull-left no-margin"> Selection for Rolls</h4>
                    <div class="labels-form">
                        <div class="clear15"></div>
                        <label class="select">
                            <select id="popup_coresize">
                                <?= $rollcores ?>
                            </select>
                            <i></i> </label>
                        <label class="select">
                            <select id="popup_woundoption">
                                <option <?= ($woundoption == 'Outside') ? 'selected="selected"' : '' ?> value="Outside">
                                    Outside Wound
                                </option>
                                <option <?= ($woundoption == 'Inside') ? 'selected="selected"' : '' ?> value="Inside">
                                    Inside Wound
                                </option>
                            </select>
                            <i></i> </label>

                        <!--<label class="select outsideorientation" style=" <?= ($woundoption == 'Outside') ? '' : 'display:none;' ?>">
                    <select  class="popup_orientation"  >
                      <option <?= ($orientation == 'orientation1') ? 'selected="selected"' : '' ?> value="orientation1">Orientation 01</option>
                      <option <?= ($orientation == 'orientation2') ? 'selected="selected"' : '' ?> value="orientation2">Orientation 02</option>
                      <option <?= ($orientation == 'orientation3') ? 'selected="selected"' : '' ?> value="orientation3">Orientation 03</option>
                      <option <?= ($orientation == 'orientation4') ? 'selected="selected"' : '' ?> value="orientation4">Orientation 04</option>
                    </select>
                    <i></i> 
              </label>
              
              <label class="select insideorientation" style=" <?= ($woundoption == 'Inside') ? '' : 'display:none;' ?>">
                    <select  class="popup_orientation"  >
                      <option  <?= ($orientation == 'orientation5') ? 'selected="selected"' : '' ?> value="orientation1">Orientation 05</option>
                      <option <?= ($orientation == 'orientation6') ? 'selected="selected"' : '' ?> value="orientation2">Orientation 06</option>
                      <option <?= ($orientation == 'orientation7') ? 'selected="selected"' : '' ?> value="orientation3">Orientation 07</option>
                      <option <?= ($orientation == 'orientation8') ? 'selected="selected"' : '' ?> value="orientation4">Orientation 08</option>
                    </select>
                    <i></i> 
              </label>-->

                        <!-- <div class="dm-row popupmodel">
                            <div class="dm-box">
                                <div class="thumbnail" style="border:none; box-shadow:none; background:none;">
                                    <div class="roll_sheets_block">
                                        <div class="btn-group btn-block dm-selector"><a
                                                    class="btn btn-default btn-block dropdown-toggle"
                                                    data-toggle="dropdown" data-value="">Orientation 01<i
                                                        class="fa fa-unsorted"></i></a>
                                            <ul class="dropdown-menu btn-block">
                                                <li class="outsideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                  data-trigger="hover"
                                                                                  data-placement="right"
                                                                                  title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                                  data-id="orientation1"> Orientation 01
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"> </a></li>
                                                <li class="outsideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                  data-trigger="hover"
                                                                                  data-placement="right"
                                                                                  title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                  data-id="orientation2"> Orientation 02
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"></a></li>
                                                <li class="outsideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                  data-trigger="hover"
                                                                                  data-placement="right"
                                                                                  title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                                  data-id="orientation3"> Orientation 03
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"></a></li>
                                                <li class="outsideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                  data-trigger="hover"
                                                                                  data-placement="right"
                                                                                  title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                  data-id="orientation4"> Orientation 04
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"></a></li>
                                                <li class="insideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                 data-trigger="hover"
                                                                                 data-placement="right"
                                                                                 title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                 data-id="orientation5"> Orientation 05
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"></a></li>
                                                <li class="insideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                 data-trigger="hover"
                                                                                 data-placement="right"
                                                                                 title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                                 data-id="orientation6"> Orientation 06
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"> </a></li>
                                                <li class="insideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                 data-trigger="hover"
                                                                                 data-placement="right"
                                                                                 title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first."
                                                                                 data-id="orientation7"> Orientation 07
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"> </a></li>
                                                <li class="insideorientation"><a data-toggle="tooltip-orintation_popup"
                                                                                 data-trigger="hover"
                                                                                 data-placement="right"
                                                                                 title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                                 data-id="orientation8"> Orientation 08
                                                        <img onerror='imgError(this);'
                                                             src="<?= Assets ?>images/loader.gif"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->


                    </div>
                </div>
                <div class="col-md-4  m-t-60"><img onerror='imgError(this);' style="margin-top:24px;margin-left:18px;"
                                                   class="windingimage"
                                                   src="<?= Assets ?>images/categoryimages/winding/<?= $woundoption ?>/<?= $orientation ?>.png"
                                                   alt="Roll Wound Orientation"></div>
            </div>
            <div class="clear10"></div>
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <!--<a class="btn blue2 close" data-dismiss="modal">  Close <i class="fa fa-close" aria-hidden="true"></i></a>-->
                </div>
                <div class="col-md-4"><a class="btn blue2 pull-right" data-dismiss="modal">Close <i class="fa fa-close"
                                                                                                    aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
