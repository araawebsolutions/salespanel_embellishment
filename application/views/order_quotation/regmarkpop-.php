<div class="modal fade registration_mark reg-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content no-padding">
            <div class="panel no-margin">
                <div class="panel-heading">
                    <h4 class="pull-left no-margin" style="margin-left: 12px;">
                        <div class="roll-icon pull-left"><img class=""
                                                              src="https://www.aalabels.com/theme/site/images/categoryimages/labelShapes/printed_roll.png"
                                                              alt="Roll Icon"></div>
                        <b>Select Registration Mark Option</b></h4>
                    <button type="button" class="close close_reg" data-dismiss="modal" aria-label="Close" style="right: 11px;"><i
                                class="fa fa-times-circle"></i></button>
                    <div class="clear"></div>
                </div>
                <div class="panel-body" style="padding: 15px;margin-top: 42px;">
                    <div class="image_container">
                        </br>
                        <p class="text-center">Reverse and Face Image of the Roll<br/> (Illustrating the black-bar
                            registration mark)</p>
                        <img src="https://www.aalabels.com/theme/site/images/registration_mark_popup_image.jpg"
                             class="img-responsive center-block" style=" height:200px;margin: 0px auto;"/>
                    </div>
                    <p class="text-justify">If your printer is not fitted with optic-free sensing technology using
                        capacitive or ultrasonic sensors triggered by changes in thickness, not opacity or contrast.
                        Then you may require a black-block registration mark on the reverse of the roll in order to
                        print. If this is the case then please select this option below. If you are unsure please refer
                        to your printer manual, or to the information available on our website <a href="#"
                                                                                                  onclick="printer_model_data('printers')">Search
                            by thermal printer model. <i class="fa fa-external-link"></i></a></p>
                    <p>If you know that your printer does not need a black-block registration mark then please proceed
                        to select your label material. </p>
                    <div class="check_section" style="margin-bottom: 40px;">
                        <label class="check" style="width: 86%;">Select to confirm you require black registration mark.
                            <input type="checkbox" name="registration_mark_option" id="registration_mark_option">
                            <span class="checkmark"></span> </label>
                    </div>
                    <div class="row m-t-15" style="margin-top: 10px;">
                        <div class="col-md-6">
                            <a data-cat-id="" data-prd-id="" id="btn_without_reg" role="button"
                               class="btn-block btn orangeBg  proceed_reg_btn" href="javascript:void(0);"
                               data-regmark="no" style="margin-left: 0px !important;font-size: 12px;"> Proceed without
                                Registration Mark <i class="fa fa-arrow-circle-right"></i></a>
                        </div>

                        <div class="col-md-6">
                            <a data-cat-id="" data-prd-id="" id="btn_with_reg" role="button"
                               class="btn-block btn orangeBg proceed_reg_btn disabled" href="javascript:void(0);"
                               data-regmark="yes" style="margin-left: 0px !important;font-size: 12px;"> Proceed to
                                Material Selection <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                        <input type="hidden" id="reg_diecode" value="<?=$reg_diecode?>"/>
                        <input type="hidden" id="reg_shape" value="<?=$reg_shape?>"/>
                        <input type="hidden" id="reg_productID" value="<?=$reg_productID?>"/>
                        <input type="hidden" id="reg_source" value="<?=$reg_source?>"/>
                        <input type="hidden" id="compare" value="<?=$compare?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REGISTRATION MARK MODAL -->
