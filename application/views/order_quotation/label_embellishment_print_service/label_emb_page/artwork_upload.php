<!-- Popup For Artwork Upload & Artwork to follow Start -->
<div   id="" class="white-screen upload_artwork_loader"
       style="    position: absolute;
    top: 99%;
    right: 35%;
    width: 67%;
    z-index: 9999;
    height: 49%;
    display: none;
    background: #FFF;
    opacity: 0.8;">
    <div class="text-center"
         style="   margin: 23% auto!important;
             background: rgba(255,255,255,.9) none repeat scroll 0 0;
             padding: 10px;
             border-radius: 5px;
             width: 27%;
             border: solid 1px #CCC;">
        <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
             style="width:139px; height:29px; " alt="AA Labels Loader">
    </div>
</div>
<input type="file" id="desingservice_artwork_file" class="artwork_file" style="display:none;">
<div class="modal left fade" id="artworkuploadpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <a href="#" class="artwork-upload-popup" data-dismiss="modal" aria-label="Close"><i class="fa fa-chevron-left"></i> Close</a>
                </div>
            </div>
            <div class="modal-body">
                <div class="panel panel-default rowflexdiv fullheightview">
                    <div id="headingOne" class="panel-title_blue">
                        <div>UPLOAD PRINT FILES</div>
                    </div>
                    <div class="row padding-20">
                        <p class="text-details-artwork-upload">Please upload and attach your artwork for this order. You can include up to 50 separate artworks. If the number of artworks exceeds this, then amend the number of designs to be printed on the next page to include these in your order and send the additional files, not uploaded, via email to: customercare@aalabels.com and these will be assigned to your order for production.</p>
                        <div class="col-md-4 float-left modal-checkbox-option-bg artwork_container">
                            <p class="bold-checbox-text">Would you like to upload all your artwork now, or email them to our Customer Care Team after placing your order?
                            </p>

                            <div class="row artwork_row">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-6  artwork_inner_col">Upload Artwork now</div>
                                <div class="col-md-6 artwork_inner_col">
                                    <input type="radio" id="test2" class="upload_artwork_radio artwork_option" value="upload_artwork_now" name="upload_artwork">
                                    <label for="test2" class="margin-left-20"></label>
                                </div>
                            </div>

                            <div class="row mt-10 artwork_row">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-6 artwork_inner_col">Artwork to follow</div>
                                <div class="col-md-6 artwork_inner_col">
                                    <input type="radio" class="upload_artwork_radio artwork_option" value="artwork_to_follow" name="upload_artwork" id="test3">
                                    <label for="test3" class="margin-left-20"></label>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3"></div>

                        <div class="col-md-5 float-right modal-checkbox-option-bg roll_upload_options">
                            <p class="bold-checbox-text">Please select one of the options below:
                            <p>
                            <div class="row">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-9">Produce my order with the most cost effective number of rolls and labels per roll.</div>
                                <div class="col-md-1">
                                    <input type="radio" name="upload_artwork_option" value="cost_effective" class="upload_artwork_option_radio artwork_option" id="test4">
                                    <label for="test4" class="margin-left-20"></label>
                                </div>
                                <div class="bold-checbox-text label-text-adjustemnts col-md-2">
                                    +£0.00

                                </div>
                            </div>

                            <div class="row mt-10">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-9">I would like to specify the number of rolls and labels per roll for my order.</div>
                                <div class="col-md-1">
                                    <input type="radio" name="upload_artwork_option" value="custom_roll_and_label" class="upload_artwork_option_radio artwork_option" id="test5">
                                    <label for="test5" class="margin-left-20"></label>
                                </div>
                                <div class="bold-checbox-text label-text-adjustemnts col-md-2">
                                    +£20.00
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-b-20">
                        <p class="number-design-template-text">Please enter number of designs</p>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                            <input type="number" name="quantity" id="user_entered_lines_qty" class="required numeric numbr-design-template-input " aria-required="true">
                        </div>
                        <div class="col-md-4"></div>
                    </div>

                    <a href="#" class="artwork-number-proceed-cta"  id="proceed_artwork_btn" data-toggle="modal" data-target="#artworkuploadpopup1">Proceed <i class="fa fa-chevron-right"></i></a>
                </div>

            </div>
            <div class="modal-footer">
                <div>
                    <a href="#" class="artwork-upload-popup" id="artwork-upload-popup" data-dismiss="modal" aria-label="Close"><i class="fa fa-chevron-left"></i> Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Popup For Artwork Upload & Artwork to follow End -->

<!-- Popup For Artwork Upload & Artwork to follow Start 1 -->
<!--<div class="modal left fade" id="artworkuploadpopup1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" >-->
<div class="modal left fade" id="artworkuploadpopup1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <!--                    <a href="#" class="artwork-upload-popup proceed_to_checkout" data-dismiss="modal" aria-label="Close">Save and Close <i class="fa fa-chevron-right"></i></a>-->
                    <a href="javascript:void(0);" class="artwork-upload-popup proceed_to_checkout" aria-label="Close">Save and Close <i class="fa fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="modal-body">

                <div class="panel panel-default rowflexdiv fullheightview">
                    <div id="headingOne" class="panel-title_blue">
                        <div>UPLOAD PRINT FILES</div>
                    </div>
                    <div class="row padding-20">
                        <p class="text-details-artwork-upload">Please upload and attach your artwork for this order. You can include up to 50 separate artworks. If the number of artworks exceeds this, then amend the number of designs to be printed on the next page to include these in your order and send the additional files, not uploaded, via email to: customercare@aalabels.com and these will be assigned to your order for production.</p>
                        <div class="col-md-4 float-left modal-checkbox-option-bg artwork_container">
                            <p class="bold-checbox-text">Would you like to upload all your artwork now, or email them to our Customer Care Team after placing your order?
                            </p>

                            <div class="row artwork_row">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-6 artwork_inner_col">Upload Artwork now</div>
                                <div class="col-md-6 artwork_inner_col">
                                    <input type="radio" id="test2_2" name="upload_artwork_2" data-upload_option="upload_option" value="upload_artwork_now"  class="artwork_option_inner artwork_upload_selection_change">
                                    <label for="test2_2" class="margin-left-20"></label>
                                </div>
                            </div>

                            <div class="row mt-10 artwork_row">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-6 artwork_inner_col">Artwork To Follow</div>
                                <div class="col-md-6 artwork_inner_col ">
                                    <input type="radio" id="test3_3" name="upload_artwork_2" data-upload_option="email_artwork" value="artwork_to_follow"  class="artwork_option_inner artwork_upload_selection_change">
                                    <label for="test3_3" class="margin-left-20"></label>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3"></div>

                        <div class="col-md-5 float-right modal-checkbox-option-bg roll_upload_options">
                            <p class="bold-checbox-text">Please select one of the options below:
                            <p>
                            <div class="row">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-9">Produce my order with the most cost effective number of rolls and labels per roll.</div>
                                <div class="col-md-1">
                                    <input type="radio" name="upload_artwork_option_2" id="test4_4" class="artwork_option_inner artwork_upload_selection_change" value="cost_effective" >
                                    <label for="test4_4" class="margin-left-20"></label>
                                </div>
                                <div class="bold-checbox-text label-text-adjustemnts col-md-2">
                                    +£0.00

                                </div>
                            </div>

                            <div class="row mt-10">
                                <div class="bold-checbox-text label-text-adjustemnts col-md-9">I would like to specify the number of rolls and labels per roll for my order.</div>
                                <div class="col-md-1">
                                    <input type="radio" name="upload_artwork_option_2" id="test5_5" class="artwork_option_inner artwork_upload_selection_change" value="custom_roll_and_label">
                                    <label for="test5_5" class="margin-left-20"></label>
                                </div>
                                <div class="bold-checbox-text label-text-adjustemnts col-md-2">
                                    +£20.00
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-b-20 ovFl table-responsive" id="upload_artwork_table">
                        <div class="upload_artwork" style="display:none;">

                            <?php //include_once(APPPATH . '/views/label_embellishment_print_service/upload/upload_artwork_files.php'); ?>
                            <?php include_once(APPPATH . 'views/order_quotation/label_embellishment_print_service/upload/upload_artwork_files.php'); ?>
                        </div>
                    </div>
                    <div class="artwok-guidelines-text-box">Please note uploaded files must be no larger than 2Mb and to achieve the best results for your finished labels you will need a professional standard of artwork. We require scaled, print-ready studio artwork, supplied in editable PDF or EPS format, with a minimum resolution of 300dpi. No original artwork e.g. hand drawn images, can be amended and if you only have image files e.g. JPEG these also cannot be easily amended and need to be print ready as explained in our guidelines.
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div>
                    <a href="javascript:void(0);" class="artwork-upload-popup proceed_to_checkout" aria-label="Close">Save and Close <i class="fa fa-chevron-right"></i></a>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Popup For Artwork Upload & Artwork to follow End 1 -->