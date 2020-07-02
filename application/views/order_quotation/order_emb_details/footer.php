<!-- Label Layout Popup Start -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" id="lay_pop_up" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="panel-heading blue-background" style="background-color: #006da4 !important;">
                <h3 class="pull-left no-margin" style="color: #ffff !important;line-height: 5px !important;"><b style="font-size: 20px !important;
color: #fff !important;">Label Layout</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                            class="fa fa-times-circle"></i></button>
                <div class="clear"></div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">

                    <div id="layout_up" class="row">

                    </div>


                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Label Layout Popup End -->


<!-- Custom Die Popup Start -->
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="myLargeModalLabelss"
     aria-hidden="true" id="customdiepopup">
    <div class="modal-dialog modal-md">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabelss">Set-up Charge Calculation</h4>
                    <p class="timeline-detail text-center">Please enter the requirements for custom die</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">


                    <style>
                        .custom-die-input {
                            width: 200px;
                            border: 1px solid #a3e8ff;
                            border-radius: 4px;
                            height: 35px;
                            color: #666666;
                            margin-bottom: 8px;
                            padding-left: 6px;
                        }

                        .blue-text-field {
                            border: 1px solid #a3e8ff !important;
                            width: 97%;
                        }

                        .m-r-3 {
                            margin-right: 3%;
                        }
                    </style>


                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" id="last_cart_id">
                            <input type="hidden" id="last_Qid">
                            <input type="hidden" id="key">
                            <input type="hidden" id="condition" value="true">


                            <div class="divstyle "><b class="label2" id="die_format_lb">Select Format</b>
                                <div class=" labels-form">
                                    <label class="select ">

                                <select class="cust_die custom-die-input" use="die_format" id="die_format" style="border: 1px solid #a3e8ff;">
                                    <option value=""></option>
                                    <option value="A4">A4</option>
                                    <option value="A3">A3</option>
                                    <option value="SRA3">SRA3</option>
                                    <option value="A5">A5</option>
                                    <option value="Roll">Roll</option>
                                </select>
                                        <i></i></label></div>
                            </div>
                            <div class="divstyle"><b class="label2" id="die_shape_lb">Select Shape</b>
                                <div class=" labels-form">
                                    <label class="select ">
                                <select class="cust_die custom-die-input" use="die_shape" id="die_shape" style="border: 1px solid #a3e8ff;">
                                    <option value=""></option>
                                    <option value="Rectangle">Rectangle</option>
                                    <option value="Square">Square</option>
                                    <option value="Circle">Circle</option>
                                    <option value="Oval">Oval</option>
                                    <option value="Irregular">Irregular</option>
                                </select>
                                        <i></i></label></div>
                            </div>
                            <div class="divstyle"><b class="label">Enter Label Width</b>
                                <input type="text" placeholder="" class="cust_die custom-die-input"
                                       use="die_width"
                                       data-id="width" data-cart-id="" value="" id="die_width">

                            </div>
                            <div id="myheigh" class="divstyle shapeoption"><b class="label" id="die_height_lb">Enter Label Height</b>
                                <input type="text" placeholder="" class="cust_die custom-die-input"
                                       use="die_height"
                                       data-id="height" data-cart-id="" value="" id="die_height">
                            </div>

                            <div id="car"><b class="label2" id="die_cornerradius_lb">Corner Radius</b>
                                <input data-cart-id="" id="die_cornerradius" use="die_cornerradius"
                                       data-id="cornerradius" class="cust_die joiner custom-die-input" type="text"
                                       placeholder="" value="">
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="divstyle" id="perporation"><b class="label2" id="die_perforate_lb">Select Perforation</b>
                                <div class=" labels-form">
									<label class="select ">
                                <select class="cust_die custom-die-input" data-id="perforation"
                                        data-cart-id="" use="die_perforate"
                                        id="die_perforate" style="border: 1px solid #a3e8ff;">
                                    <option value=""></option>
                                    <option value="None">None</option>
                                    <option value="2mm Cut 1mm Tie">2mm Cut 1mm Tie</option>
                                </select>
                                        <i></i></label></div>
                            </div>




                            <div class="rolloptions"><b class="label2" id="die_ldeg_lb">Leading Edge</b>
                                <input id="die_ldeg" data-id="ldeg" class="cust_die joiner custom-die-input"
                                       use="die_ldeg" readonly type="text"
                                       placeholder="" value="">
                            </div>
                            <div><b class="label2" id="die_across_lb">Label Across</b>
                                <input data-cart-id="" id="die_across" use="die_across"
                                       class="cust_die custom-die-input" type="text"
                                       placeholder="" value="">

                            </div>
                            <div><b class="label2" id="die_around_lb">Label Around</b>
                                <input data-cart-id="" id="die_around" use="die_around"
                                       class="cust_die custom-die-input" type="text"
                                       placeholder="" value="">

                            </div>
                            <div><b class="label2" id="die_no_of_labels_lb">Enter Label Quantity</b>
                                <input type="text" placeholder="" class="cust_die custom-die-input"
                                       readonly data-id="labels"
                                       value="" use="die_no_of_labels" id="die_no_of_labels" style="font-size:12px">
                            </div>
                        </div>
                    </div>


                    <div style="width: 103%;margin-left: 0px;">
						<b class="label2">Enter special notes here</b>
                        <textarea class="form-control blue-text-field cust_die" rows="5" use="die_note" id="die_notee"
                                  placeholder=""></textarea>
                    </div>


                    <span class="m-t-t-10 pull-right m-r-3">
                        <button id="add_cart" type="button" onclick="getCustomDiePrice()"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="margin-right: -13px;">Add to Cart</button></span>
                    <span class="m-t-t-10 pull-right m-r-3">
                        <button style="display: none" id="update_cart" type="button" onclick="updateCustomDiePrice()"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="margin-right: -26px;">Update Cart</button>
                    </span>
                    <span class="m-t-t-10 pull-right m-r-3">
                        <button style="display: none" id="cancal_cart" type="button" onclick="cancaelCartValue()"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Cancel</button>
                    </span>


                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Custom Die End -->

<!-- REGISTRATION MARK MODAL -->
<style type="text/css">
    .red-border {
        border: 1px solid red !important;
    }

    .plain-tooltip {
        opacity: 1 !important;
        right: 1px !important;
        left: auto !important;
        margin-top: 5px !important;
    }

    .printed-lba-a4 h1 {
        color: #fff;
        font-size: 26px;
        font-weight: bold;
    }
</style>
<style>
    @media (min-width: 768px) and (max-width: 768px) {
        .right_column {
            margin-top: 45px;
        }

        #ajax_material_sorting {
            margin-top: 0 !important;
        }
    }
</style>
<style>
    @media (min-width: 768px) {
        .modal-dialog {

        }
    }

    .registration_modal_link {
        text-decoration: underline;
    }

    .close_reg {
        color: #fd4913;
    }

    .registration_mark .panel-heading {
        background: #fff !important;
    }

    .registration_mark h4 {
        line-height: 35px;
    }

    .registration_mark h4 b {
        margin-left: 10px;
        font-size: 17px;
    }

    .image_container {
        border: 1px solid #e9e9e9;
        padding: 10px 0;
        margin-bottom: 15px;
    }

    .image_container p {
        font-size: 13px !important;
    }
</style>


<div id="popupdiv"></div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center"> Copyright © 2019. AA Labels.com - <?=$this->session->userdata('login_ip')?> </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
<!-- Boostrap & Basic Jquery  -->


<script src="<?= ASSETS ?>assets/js/popper.min.js"></script>

<!--<script src="<?/*= ASSETS */?>assets/js/bootstrap.min.js"></script>-->
<script src="<?= ASSETS ?>assets/js/datatable/js/dataTables.bootstrap4.min.js"></script>



<script src="<?= Assets ?>js/footer_section.js"></script>
<script src="<?= Assets ?>labelfinder/js/jquery-ui.js"></script>

<script src="<?= ASSETS ?>assets/js/newlabelfinder.js"></script>
<script src="<?= ASSETS ?>assets/js/custom.js?v=<?=time()?>"></script>
<script src="<?= ASSETS ?>assets/js/tab.js?v=<?=time()?>"></script>
<script src="<?= ASSETS ?>assets/js/countDown.js"></script>


<!--// charts-->


<script>

    setInterval(function () {

        var currentTime = new Date();

        var currentHours = currentTime.getHours();

        var currentMinutes = currentTime.getMinutes();

        var currentSeconds = currentTime.getSeconds();

        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;

        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

        var timeOfDay = (currentHours < 12) ? "AM" : "PM";

        currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

        currentHours = (currentHours == 0) ? 12 : currentHours;

        var currentTimeString = currentHours + " : " + currentMinutes + " : " + currentSeconds + " " + timeOfDay;

        //document.getElementById("timer").innerHTML = currentTimeString;

        $('#timer').html(currentTimeString);

    }, 1000);


    setInterval(function () {
			if ($.isFunction(window.timerGo)) {
				timerGo();
			}
		}, 1000);


	$(document).ready(function () {
		$('.loader').hide();
	});
</script>

<style>
 #aa_loader{
 top:40%;
}
 .artwork_uploader{
        background: #337ab7 !important;
        border-color: #337ab7 !important;
        color: #fff !important;
     }
</style>


</body>
</html>