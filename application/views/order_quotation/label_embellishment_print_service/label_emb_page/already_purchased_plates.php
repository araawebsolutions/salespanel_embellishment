<!--<div class="label-embellishment-small-container-bg mt-10">
    <div class="row">
        <div class="col-md-8">
                                        <span class="label-embellishment-small-text">
                                                    If you have already paid for the setup of Spot UV and / or label embellishments
                                                    and wish to place a repeat order please click here.
                                                </span>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3"><a href="#" class="label-embellishment-cta">View and Select <i class="fa fa-chevron-right"></i></a></div>
    </div>
</div>-->

<div   id="purchased_plate_history_loader" class="white-screen"
       style="position: absolute;top: 25%;right: 12%;width: 124%; height: 137%;display: none;background: #FFF;opacity: 0.8;    z-index: 9999;">
    <div class="text-center"
         style="    margin: 33% auto!important;background: rgba(255,255,255,.9) none repeat scroll 0 0;padding: 10px;border-radius: 5px;width: 25%;border: solid 1px #CCC;">
        <img onerror="imgError(this);" src="<?= Assets ?>images/loader.gif" class="image"
             style="width:139px; height:29px; " alt="AA Labels Loader">
    </div>
</div>
<div class="label-embellishment-small-container-bg mt-10">
    <div class="row">
        <?php

        $usrid = $this->session->userdata('customer_id');
       /* echo "<pre>";
        print_r($this->session->all_userdata());
        echo "<pre>";

        echo $usrid."-----asdasd";*/
        //        $UserName = ucfirst($this->session->userdata('UserName'));

        if (isset($usrid) and $usrid != '') { ?>
            <input type="hidden" id="user_id" value="<?php echo $usrid;?>">
            <div class="col-md-8">
                                        <span class="label-embellishment-small-text">
                                                    If you have already paid for the setup of Spot UV and / or label embellishments
            and wish to place a repeat order please click here.
                                                </span>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <a href="#" id="purchased_plate_cta" class="label-embellishment-cta" data-toggle="modal"
                   data-target="#purchased_platepopup">
                    View and Select <i class="fa fa-chevron-right">
                    </i>
                </a>
                <!--            <a href="#" class="label-embellishment-cta">View and Select <i class="fa fa-chevron-right"></i></a>-->

            </div>
        <?php } else { ?>

            <div class="col-md-8">
               <span class="label-embellishment-small-text">
            To view any label embellishments plates
            in your order history please click here.
                                                </span>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <a href="javascript:void(0);" id="about_your_artwork_cta"
                   class="login_modal_link label-embellishment-cta">
                    Login <i class="fa fa-chevron-right">

                    </i>
                </a>
                <!--                <a href="javascript:void(0);" class="login_modal_link">Login</a>-->

                <!--            <a href="#" class="label-embellishment-cta">View and Select <i class="fa fa-chevron-right"></i></a>-->

            </div>
        <?php } ?>

    </div>
</div>


<div class="modal left fade" id="purchased_platepopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <small style="font-size: 18px;  color: #00b7f1;  font-weight: bold;  margin-bottom: 10px;"> Plates
                        Order History</small>
                    <a href="#" class="artwork-upload-popup" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-chevron-left"></i> Close</a>
                </div>
            </div>
            <hr>
            <div class="modal-body" style="padding-top:0 !important; ">
                <div class="container ">
                    <div id="purchased_plate_section">

                    </div>

                </div>
            </div>
        </div>


        <div class="modal-footer">
            <div>
                <a href="#" class="artwork-upload-popup" id="artwork-upload-popup" data-dismiss="modal"
                   aria-label="Close"><i class="fa fa-chevron-left"></i> Close</a>
            </div>
        </div>
    </div>
</div>

