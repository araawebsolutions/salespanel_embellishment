<?php
if ($this->session->userdata('userid')) {
    $user_email = $this->home_model->get_db_column('customers', 'UserEmail', 'UserID', $this->session->userdata('userid'));
} else if ($this->session->userdata('email') != '') {
    $user_email = $this->session->userdata('email');
} else {
    $user_email = "";
}
?>
<link href="<?= Assets ?>labelfinder/css/filters.css" rel="stylesheet">
<link href="<?= Assets ?>css/mat-sep-2017.css" rel="stylesheet">
<script src="<?= Assets ?>labelfinder/js/jquery-ui.js"></script>
<style>
    #preview_po_img {
        cursor: pointer;
    }
    #index_printing > .thumbnail h4 {
        text-transform: uppercase;
        font-size: 18px !important;
        color: #fd4913;
    }
    .prMatDC table.price {
        line-height: 21px;
    }
    .printSt {
        min-height: 340px;
        margin-bottom: 15px;
        width: 100%;
    }
    .printSt i {
        background-color: #fd4913;
        border-radius: 100px;
        color: #fff;
        font-size: 50px;
        padding: 30px;
    }
    .printSt h2 {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        padding: 10px;
        text-align: center;
        text-transform: uppercase;
        margin: 0px;
    }
    .printSt h2 small {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .printSt p {
        color: #fff;
        font-size: 14px;
    }
    .btnLg {
        -moz-user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 18px;
        font-weight: bold;
        line-height: 1.42857;
        margin-bottom: 0;
        /* padding: 12px 45px !important;*/
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }
    .btnLg b {
        font-size: 22px;
        line-height: 22px;
    }
    .btnLg .nxt-img {
        margin-top: 7px;
    }
    .btnLg .vch-img {
        margin-top: 2px;
    }
    .titleX b {
        color: #17b1e3;
    }
    .printedBgHome h2 {
        background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
        border-radius: 8px;
        color: #fff;
        font-size: 26px;
        font-weight: bold;
        padding: 10px;
        text-align: center;
        text-transform: uppercase;
    }
    .printedBgHome h2 small {
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .printedBgHome p {
        color: #fff;
        font-size: 17px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .btnLgHome {
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        line-height: 1.42857;
        margin-bottom: 0;
        padding: 10px 14px !important;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        left: -10px;
        position: absolute;
        top: 140px;
        text-transform: uppercase;
    }
    /*.orderStep li {
    border-right: 0 solid rgba(0, 0, 0, 0.5);
    display: inline-block;
    float: left;
    height: auto;
    margin: 0;
    padding: 0;
    text-align: center !important;
    width: 20%;
}*/
    .slidecarousel_height {
        height: 210px;
    }
    .slidecarousel_height #quote-carousel .carousel-indicators {
        bottom: 0;
        right: 50%;
        top: 180px;
    }
    .slidecarousel_height .carousel-indicators .active {
        background-color: #fd4913 !important;
    }
    .slidecarousel_height #quote-carousel .carousel-indicators li {
        border: 2px solid #fff;
    }
    .loading-gif {
        left: 45%;
    }
    .prLbMatTabs .fa-check-circle {
        color: #5cb85c;
    }
    .thumb_p15 {
        padding: 15px;
    }
    .blue_box {
        background-color: #e9f7fe;
        border: solid 1px #34b6e4;
        border-radius: 4px;
        margin-bottom: 5px;
        padding: 15px 5px;
    }
    .blue_box .labels-form label {
        padding: 11px 30px 5px;
        margin: 0px;
        color: #34b6e4;
        font-weight: 700;
    }
    .blue_box h3 {
        color: #34b6e4;
        font-size: 16px;
        font-style: italic;
        font-weight: 700;
        margin: 0 0 0 10px;
        padding: 4px 0;
    }
    .sfr .price {
        border-top: none; /*solid 1px #f94812;*/
    }
    .sfr .price p b {
        padding: 5px 0;
        color: #f94812;
    }
    .sfr .priceB {
        border-top: solid 1px #CCC;
        margin: 0px;
    }
    .sfr .priceB p {
        padding: 5px 0;
    }
    .sfr .priceB p b {
        padding: 2px 0 2px 1px;
        color: #f94812;
        font-size: large;
    }
    .sfr .m-t-5 {
        margin-top: 3px;
    }
    .lSumR .title {
        background: #17b1e3 none repeat scroll 0 0;
        border-radius: 4px;
        color: #fff;
        display: inline-block;
        font-size: 14px;
        padding: 10px;
        width: 100%;
    }
    .lSumR_img {
        border: solid 1px #CCC;
        border-radius: 4px;
        width: 100%;
        height: 90%;
    }
    .delete_item i {
        text-align: center;
        color: #cccccc;
        margin-left: 10px;
    }
    .ovFl h5 {
        color: #f94812;
        font-size: large;
        padding: 2px 0 2px 1px;
    }
    .ovFl thead {
        background: #17b1e3;
    }
    .ovFl thead tr {
        color: #fff;
        border-radius: 2px;
        font-size: 12px;
        vertical-align: middle;
        font-weight: bold;
    }
    .alert-warning p {
        font-size: 12px;
        padding: 0 10px;
    }
    .prMatDC table.price .total td {
        border: none;
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
        left: -524px;
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
    .mega-print-dd-menu {
        min-width: 530px;
    }
    .dm-row .dm-box .thumbnail .dm-selector .btn {
        font-size: 13px;
    }
    .print-ads {
        background: url(<?=Assets?>images/ld-img-5.png) no-repeat scroll 0 0 / cover;
        border-radius: 6px;
        display: inline-block;
        height: 297px;
        padding: 10px !important;
        width: 100%;
        box-shadow: 0 4px 0 #848484;
    }
    .printed_voucher {
        background: #fff;
        border-radius: 4px;
        display: inline-block;
        padding: 2px;
    }
    .printed_voucher p {
        color: #000;
        font-weight: bold;
        font-size: 14px;
        margin-top: 4px;
    }
    .pr-fl {
        padding-bottom: 19px;
        padding-top: 30px;
    }
    .btn-u-lg, a.btn-u-lg {
        padding: 8px 25px !important;
    }
    .pr-thumb-cont {
        /*min-height: 425px;*/
    }
    .a4_sheets_block .input-group .form-control {
        height: 38px !important;
    }
    .popupmodel .dm-box .thumbnail .dm-selector .dropdown-menu a img {
        left: -704px !important;
    }
    .ourTeam .btn-danger {
        width: auto !important;
    }
    .design_services .labels-form .radio i {
        top: -10px;
    }
    .popover {
        width: 215px !important;
        background-color: #fefeec !important;
    }
    .popover.top > .arrow::after {
        border-right-color: #fefeec;
    }
    .mat-sep-2017 .selected-product .pr-detail p {
        margin-bottom: 3px;
    }
    .preferences .panel-body p {
        font-size: 13px !important;
    }
    .mat-sep-2017 .selected-product .pr-title {
        font-size: 18px;
        margin: 0px 0 5px 0;
    }
    @media (max-width: 1920px) {
        .col-lg-2.col-md-3.col-sm-3.col-xs-12.no-padding.step-1.prLbSteps-step-active.prLbSteps-step-selected {
            text-align: right;
        }
        .col-lg-2.col-md-3.col-sm-3.col-xs-12.no-padding.step-1.prLbSteps-step-active {
            text-align: right;
        }
        .roll-and-sheet-ads img {
            width: 80%;
        }
        .lSum .text-right {
            margin-top: 15px;
        }
    }
    @media (max-width: 1200px) {
        .btnLg .nxt-img {
            margin-left: 0px;
        }
        .roll-and-sheet-ads img {
            width: 90%;
            height: auto;
        }
        .col-lg-2.col-md-3.col-sm-3.col-xs-12.no-padding.step-1.prLbSteps-step-active.prLbSteps-step-selected {
            text-align: left;
        }
        .col-lg-2.col-md-3.col-sm-3.col-xs-12.no-padding.step-1.prLbSteps-step-active {
            text-align: left;
        }
        .printed_voucher p {
            font-size: 12px;
        }
        .lSum .text-right {
            margin-top: 0px;
        }
    }
    @media (max-width: 1024px) {
        .printed_voucher p {
            font-size: 12px;
            margin-left: 0px;
            margin-top: 7px;
        }
        .printed_voucher {
            padding: 5px;
        }
        .btn-u-lg, a.btn-u-lg {
            padding: 8px 10px !important;
            font-size: 15px;
        }
        .btnLg .nxt-img {
            margin-left: 0px;
        }
        .printSt h2 {
            font-size: 16px;
        }
        .prLbSteps-nav ul li a .cnt {
            background: #cac9c9 none repeat scroll 0 0;
            border-radius: 100%;
            color: #fff;
            display: table;
            float: none !important;
            font-size: 12px;
            font-weight: bold;
            height: 20px;
            line-height: 20px;
            margin: 29px auto auto auto;
            text-align: center;
            width: 20px;
        }
        .prLbSteps-nav a.stepText .fa {
            float: none;
        }
        .roll-and-sheet-ads img {
            width: 60%;
            height: auto;
        }
        .nav-justified > li > a {
            padding: 10px 2px;
        }
        .btnLg b {
            font-size: 16px !important;
            margin-left: 30px;
        }
    }
    @media (max-width: 1023px) {
        .printed_voucher p {
            text-align: left;
            margin-left: 30px;
            font-size: 10px;
            margin-top: 0px;
        }
    }
    @media (max-width: 768px) {
        .printed_voucher p {
            text-align: left;
            margin-left: 30px;
            font-size: 10px;
            margin-top: 0px;
        }
        .printed_voucher img {
            margin: 0 auto;
            display: block;
        }
        .text-right {
            text-align: center;
        }
        .lSum .text-right {
            text-align: right;
            margin-top: 15px;
        }
        .printStbg2 {
            padding: 10px !important;
        }
        .printStbg3 {
            padding: 10px !important;
        }
        .nav > li > a {
            padding: 10px 2px;
        }
        .nav.orderStep li a {
            font-size: 11px !important;
        }
        .roll-and-sheet-ads img {
            width: 60%;
            height: auto;
        }
        .nav-justified > li {
            float: left;
        }
        .nav-justified.orderStep li {
            width: 16%;
        }
        .nav-justified.orderStep li a {
            font-size: 10px !important;
        }
        .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            margin: 0 auto;
        }
        .prLbSteps-nav ul li a .cnt {
            margin: 20px auto auto auto;
        }
    }
    @media (max-width: 767px) {
        .printed_voucher p {
            text-align: center;
            margin-left: 0px;
            font-size: 12px;
            margin-top: 0px;
        }
        .col-xs-10.no-padding.stepText.uac {
            margin-top: 20px;
        }
        .roll_sheets_block .delvStatus.text-right {
            text-align: right;
        }
    }
    @media (max-width: 570px) {
        .nav.orderStep li {
            width: 100%;
        }
        .nav.orderStep li a {
            font-size: 12px !important;
        }
        .roll-and-sheet-ads img {
            width: 90%;
            height: auto;
        }
        .btnLg b {
            margin-left: 0px;
        }
    }
    @media (max-width: 400px) {
        .btn-u-lg, a.btn-u-lg {
            padding: 8px 10px !important;
            font-size: 12px;
        }
        .btnLg b {
            font-size: 12px !important;
        }
        .roll-and-sheet-ads img {
            width: 90%;
            height: auto;
        }
        .a4_sheets_block .btn {
            font-size: 11px;
        }
        .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
            height: 38px;
        }
        .lSum .text-right {
            margin-top: 0px;
        }
    }
    @media (max-width: 320px) {
        .labels-form .dropdown-menu {
            font-size: 11px;
        }
        .dm-row .dm-box .thumbnail .dm-selector .btn {
            font-size: 11px;
        }
    }
    @media (max-width: 340px) {
        .modal-footer .btn {
            padding: 8px 8px !important;
        }
        .sweet-alert.showSweetAlert .m-t-10 {
            margin-right: 0px !important;
        }
        .sweet-alert.showSweetAlert .m-r-10 {
            margin-right: 0px !important;
        }
    }
    .lSum .thumb {
        overflow: hidden;
    }
    .dm-row .dm-box .thumbnail .dm-selector .dropdown-menu a {
        font-size: 11px;
    }
    /************* NEW FILTER **************/
    .LabelWidthMain, .LabelHeightMain {
        height: auto;
    }
    #width_min, #width_max, #height_min, #height_max {
        padding: 6px 6px;
        background-color: #fff;
        height: 30px;
        border: 1px solid #17b1e3;
        border-radius: 0;
    }
    .slider {
        height: 5px;
        margin-left: 0;
        margin-right: 0;
    }
    .slider .ui-slider-range {
        height: 5px;
        background: #17b1e3 !important;
        padding: 0 10px;
        margin: 0 -5px;
    }
    .ui-slider-horizontal .ui-slider-handle {
        width: 9px;
        top: -10px;
        border-radius: 0;
        margin-left: -5px;
        background: #fd4913 !important;
        border-color: #fd4913 !important;
    }
    .lablefilterslider {
        padding-left: 5px;
        padding-right: 16px;
        width: 100%;
        margin: 0 auto;
        border-radius: 0;
        background: #ededed;
        box-shadow: 0 0 2px #ededed;
    }
    .opposite_dimension .check input:checked ~ i {
        background-color: #d6f5ff;
    }
    .opposite_dimension .radio i, .opposite_dimension .checkbox i {
        background: #d6f5ff;
        border-color: #d6f5ff !important;;
        border-radius: 0;
        padding: 9px !important;
    }
</style>
<style>
    @media (min-width: 768px) and (max-width: 768px) {
        .image_section_top {
            margin-top: 70px;
        }
    }
    @media (max-width: 768px) {
        #height_box {
            /*margin-top: 20px !important;*/
        }
        .proceed_upload {
            margin-top: 0 !important;
        }
        .price_promise_div_print [class*='col-'] {
            min-width: 200px;
            padding: 0 10px;
        }
        .priceB .col-sm-8, .priceB .col-sm-4 {
            padding: 0;
        }
    }
</style>

<div id="aa_loader" class="white-screen" style=" display:none;">
    <div class="loading-gif text-center" style="top:135%; z-index:150;"><img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif" class="image" style="width:139px; height:29px;" alt="AA Labels Loader"></div>
</div>

<div id="ab_loader" class="white-screen" style=" display:none;">
    <div class="loading-gif text-center" style="top:135%; z-index:150;"><img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif" class="image" style="width:139px; height:29px;" alt="AA Labels Loader"></div>
</div>

<div>
    <div class="container m-t-b-8 ">
        <div class="col-md-8">
            <ol class="breadcrumb  m0">
                <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i></a></li>
                <li>Printed Labels</li>
            </ol>
        </div>
    </div>
</div>

<div class="printedBg">
    <div class="container">
        <div id="bg-index">
            <div class="col-sm-7 m-t-20 image_section_top"><img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/epson-print-2.png" alt="Epson Printer"/></div>
            <div class="pr-fl labelFinder col-sm-5 col-xs-12 alpha60">
                <!-- Reg-Form -->
                <div class="col-sm-12 labels-form">
                    <!-- Reg-Form -->
                    <fieldset>
                        <div class="m-b-10 m-t-10">
                            <label class="input"> <i class="icon-append fa fa-user"></i>
                                <input type="email" placeholder="Enter Email address" name="email" id="email" class="required" aria-required="true" value="<?= $user_email;?>">
                            </label>
                        </div>
                        <div class="m-b-10 m-t-10">
                            <label class="select">
                                <select id="shape_sel">
                                    <option value=""> Label Shape</option>
                                    <option value="Rectangle">Rectangle</option>
                                    <option value="Square">Square</option>
                                    <option value="Circular">Circular</option>
                                    <option value="Oval">Oval</option>
                                    <option value="Star">Star</option>
                                    <option value="Heart">Heart</option>
                                    <option value="Triangle">Triangle</option>
                                    <option value="Perforated">Perforated</option>
                                    <option value="Irregular">Irregular</option>
                                    <option value="Anti-Tamper">Anti-Tamper</option>
                                </select>
                                <i></i> </label>
                        </div>
                        <!--<div class="m-b-10 m-t-10">
              <div class="input-group">
                    <input class="form-control filter_search_box" placeholder="Enter Product Code (If known)" type="text">
                    <input type="hidden" id="searchtype" name="searchtype" value="filter"  />
                    <span class="input-group-addon">
                        <button type="button" style="background: transparent; border: 0px" class="filter_search_handler">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </span>
                </div>
        </div>-->
                    </fieldset>
                    <footer>
                        <button id="home_finder" class="btn-block m-b-10 btn-u btn-u-lg text-uppercase" type="button"><i
                                    class="fa fa-search"></i> SEARCH SHAPE & SIZE <br/>
                            <small  >Buy online to take advantage of the half-price<br> print offer. </small></button>
                        <div class="col-xs-12 printed_voucher"><img onerror='imgError(this);' class="img-responsive"
                                                                    src="<?= Assets ?>images/mkt_offer_ad_03en123.jpg"
                                                                    alt="Half Price Printed Labels"/></div>
                    </footer>
                    <!-- End Reg-Form -->
                </div>
            </div>
        </div>
        <div class="row" id="bg-step-1" style="display:none;">
            <div class="col-sm-5 m-t-20 image_section_top"><img onerror='imgError(this);' class=""
                                                                src="<?= Assets ?>images/epson-print.png" width="100%"
                                                                alt="Epson Printer"/></div>
            <div class="col-sm-7 m-t-10">
                <div class="prBdec m-t-20">
                    <h4>THE IMPORTANCE OF PROFESSIONALLY PRINTED LABELS</h4>
                    <p>Your labels can be just as important as the brand, or product itself to gain and retain
                        customers. A consumers purchasing intention, affiliation or loyalty is influenced by numerous
                        factors, one of which is the product label. Which is also the marketing communication closest to
                        the decision making process, or point of purchase. Therefore the quality of material, design,
                        image, layout and finish are all critical factors in creating high quality labels that work for
                        your business.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="printedBg ">
  <div class="row ">
    <div class="col-md-6 col-md-offset-3 text-center">
      <h2>SPECIAL OFFER <br>
        <small style="font-size:15px;">10% REDUCTION ON PRINTED ROLL LABEL ORDERS PLACED ONLINE. </small> </h2>
     	<p>Design your own using Label Designer<br>
        or provide print ready artwork for fast turnaround</p>
    </div>
  </div>
</div>-->
<div class="ourTeam" id="index_printing"  style="display: none;">
    <div class="container">
        <div class="clear30"></div>
        <div class="">
            <div class="">
                <div class="thumbnail">
                    <div class="clear10"></div>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <div class="col-md-12 ">
                            <h1 style="font-size:16px; font-weight:bold;">Order Online for High Quality Digitally
                                Printed Labels</h1>
                            <p class="no-margin text-justify">Your labels are as important as your brand, product or
                                organisational image, in communicating your chosen values. Because the medium becomes
                                the message and the label quality you choose says a lot about you, but a poor quality
                                label can say even more!<br>
                                <br>
                                We understand that the combination of label material, adhesive, design, print and finish
                                are all critical elements in a labels appearance and performance. Delivering the highest
                                quality standards in label production and customer care is a collective responsibility
                                at AA Labels, ensuring that you receive a high quality label for your application. </p>
                        </div>
                    </div>
                    <div class="hidden-xs col-md-4 col-sm-6 slidecarousel_height">
                        <div id="quote-carousel" data-ride="carousel" class="slide carousel">
                            <div class="carousel-inner" style="margin-top:10px;">
                                <!-- Quote 1 -->
                                <div class="item active"><img onerror='imgError(this);' class=""
                                                              src="<?= Assets ?>images/categoryimages/labelShapes/slide01.png"
                                                              alt="Epson Printer"></div>
                                <!-- Quote 2 -->
                                <div class="item"><img onerror='imgError(this);' class=""
                                                       src="<?= Assets ?>images/categoryimages/labelShapes/slide02.png"
                                                       alt="Printed Labels"></div>
                                <!-- Quote 3 -->
                                <div class="item "><img onerror='imgError(this);' class=""
                                                        src="<?= Assets ?>images/categoryimages/labelShapes/slide03.png"
                                                        alt="ISO Certified"></div>
                                <!-- Quote 4 -->
                                <div class="item"><img onerror='imgError(this);' class=""
                                                       src="<?= Assets ?>images/categoryimages/labelShapes/slide04.png"
                                                       alt="Labels Printer"></div>
                                <!-- Quote 5 -->
                                <div class="item"><img onerror='imgError(this);' class=""
                                                       src="<?= Assets ?>images/categoryimages/labelShapes/slide05.png"
                                                       alt="Labels on Difficult Surface"></div>
                                <ol class="carousel-indicators hidden-sm">
                                    <li data-slide-to="0" data-target="#quote-carousel"></li>
                                    <li data-slide-to="1" data-target="#quote-carousel"></li>
                                    <li data-slide-to="2" data-target="#quote-carousel"></li>
                                    <li data-slide-to="3" data-target="#quote-carousel"></li>
                                    <li class="active" data-slide-to="4" data-target="#quote-carousel"></li>
                                </ol>
                            </div>
                            <!-- Bottom Carousel Indicators -->
                            <!-- Carousel Slides / Quotes -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4  col-sm-4"><a href="javascript:void(0);" class="get_started_btn">
                    <div class="printSt printStbg1">
                        <div class="clear30"></div>
                        <i class="fa fa-desktop" aria-hidden="true"></i>
                        <div class="clear30"></div>
                        <div class="text-center">
                            <h2>1. SELECT LABELS</h2>
                            <p>Start by using the filters to select the shape, size, material, colour and adhesive type
                                of the label that you require. </p>
                        </div>
                    </div>
                </a></div>
            <div class="col-xs-12 col-md-4  col-sm-4"><a href="javascript:void(0);" class="get_started_btn">
                    <div class="printSt printStbg2  ">
                        <div class="clear30"></div>
                        <i class="fa fa-calculator" aria-hidden="true"></i>
                        <div class="clear30"></div>
                        <div class="text-center">
                            <h2>2. Quantity &amp; Prices</h2>
                            <p>After selecting the label you can decide the format e.g. rolls or sheets, the number of
                                labels and price.</p>
                        </div>
                    </div>
                </a></div>
            <div class="col-xs-12 col-md-4  col-sm-4"><a href="javascript:void(0);" class="get_started_btn">
                    <div class="printSt printStbg3 ">
                        <div class="clear30"></div>
                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                        <div class="clear30"></div>
                        <div class="text-center">
                            <h2>3. UPLOAD ARTWORK &amp; ORDER ONLINE</h2>
                            <p>Finally upload the artwork and place your order to receive high quality digitally printed
                                labels. </p>
                        </div>
                    </div>
                </a></div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="thumbnail prLbMatTabs">
                    <div class="clear10"></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 col-xs-12">
                        <div class="col-xs-12 text-center col-xs-offset-0">
                            <!-- <button class="btn btnLg orangeBg get_started_btn">
             	 COPY VOUCHER & BUY ONLINE <br /><small>Proceed to Select Labels</small>
              </button> -->
                            <a href="javascript:void(0);" class="get_started_btn"> <img onerror='imgError(this);'
                                                                                        class="img-responsive"
                                                                                        src="<?= Assets ?>images/search-shape-n-size.jpg"
                                                                                        alt="Get Half Price Printed Labels"/>
                            </a>
                            <!-- <button class="btn btnLg orangeBg get_started_btn btn-block">
              <div class="col-xs-12 col-sm-3"><img onerror='imgError(this);' class="vch-img" src="<?= Assets ?>images/voucher-btn.png"></div>
              <div class="col-xs-12 col-sm-8 text-center m-t-15"> <b> Search Online Now  </b> </div>
              <div class="hidden-xs col-sm-1"><img onerror='imgError(this);' class="nxt-img" src="<?= Assets ?>images/voucher-btn-con.png"></div>
              </button>-->
                            <div class="clear5"></div>
                            <!--<small>This offer is for Printed Labels on Rolls only and will be applied automatically at checkout.</small>-->
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="clear15"></div>
                    <div class="col-md-12 text-justify ">
                        <div class="col-md-12 ">
                            <p>In addition to regular, repeat volume label orders from large customer organisations, we
                                also have many SME customers with a number of first-time orders being placed daily. </p>
                            <p>Our customer care team are experienced and skilled in assisting start-up businesses to
                                produce the labels required and are happy to provide advice on everything to do with
                                labelling. So if you are looking for a labelling specialist that values short-run label
                                business, then you have come to the right place. </p>
                            <p>Additional information about our printed label service is available by opening the tabs
                                below.</p>
                            <div class="clear15"></div>
                        </div>
                    </div>
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav  orderStep setup-panel" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_artwork" aria-controls="" role="tab"
                                                                      data-toggle="tab">Artwork</a></li>
                            <li role="presentation"><a href="#tab_studio_prepress" aria-controls="" role="tab"
                                                       data-toggle="tab">Studio Pre-Press</a></li>
                            <li role="presentation"><a href="#tab_production" aria-controls="" role="tab"
                                                       data-toggle="tab">Production</a></li>
                            <li role="presentation"><a href="#tab_order_fulfillment" aria-controls="" role="tab"
                                                       data-toggle="tab">Order fulfillment</a></li>
                            <li role="presentation"><a href="#tab_samples" aria-controls="" role="tab"
                                                       data-toggle="tab">Samples</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab_artwork">
                                <div class="clear10"></div>
                                <div class="col-md-12 text-justify">
                                    <div class="col-sm-12">
                                        <p>If you already have artwork prepared in a file saved format, then this can be
                                            uploaded with your order and remember that all artwork amendments are likely
                                            to be chargeable by your graphic designer, so its best practice to only
                                            commission professional design services once all the elements of your design
                                            are finalised. For a small charge we can design artwork for you based on any
                                            existing packaging you have, your logo or brand aspirations. (Include an
                                            image of files e.g. EPS, PDF)</p>
                                    </div>
                                    <div class="clear10"></div>
                                    <div class="col-sm-9 col-md-10">
                                        <div class="titleX"><b>Upload your File Artwork</b></div>
                                        <p> Please note uploaded files must be no larger than 2Mb and to achieve the
                                            best results for your finished labels you will need a professional standard
                                            of artwork. We require scaled, print-ready studio artwork, supplied in
                                            editable PDF or EPS format, with a minimum resolution of 200dpi. No original
                                            artwork e.g. hand drawn images, can be amended and if you only have image
                                            files e.g. JPEG these also cannot be easily amended and need to be print
                                            ready as explained in our <a href="#" data-toggle="modal"
                                                                         data-target=".artwork_help">guidelines</a></p>
                                    </div>
                                    <div class="col-sm-3 col-md-2 text-center"><img onerror='imgError(this);' class=""
                                                                                    src="<?= Assets ?>images/categoryimages/labelShapes/artwork-upload.png"
                                                                                    alt="Upload Icon"></div>
                                </div>
                            </div>
                            <!--material end -->
                            <div role="tabpanel" class="tab-pane" id="tab_studio_prepress">
                                <div class="clear10"></div>
                                <div class="col-md-12 text-justify">
                                    <p>Upon placement of order and submission of artwork our studio designers will
                                        prepare a print ready file for label production. Prior to proceeding to print we
                                        will first send you an electronic soft-proof for approval, via email. </p>
                                    <div class="col-md-12"><img onerror='imgError(this);'
                                                                class="img-responsive width-100-p"
                                                                src="<?= Assets ?>images/categoryimages/labelShapes/softprint01.png"
                                                                alt="Softproof Template"></div>
                                    <div class="clear10"></div>
                                    <p>If you also require an additional press-proof/s for approval, prior to
                                        production, then this can also be provided and our customer care team will be
                                        able to provide you with details of the cost of this service for your
                                        artworks.</p>
                                    <div class="clear10"></div>
                                </div>
                            </div>
                            <!--color end -->
                            <div role="tabpanel" class="tab-pane " id="tab_production">
                                <div class="col-md-12 text-justify">
                                    <div class="clear10"></div>
                                    <div class="col-sm-8 col-md-9">
                                        <div class="titleX"><b>Professionally Produced Printed Labels</b>
                                            <p> Our 7 colour inkjet digital label press, with white ink, delivers
                                                exceptional print quality and accurate colour reproduction on a variety
                                                of standard label substrates. Ideal for high quality short to medium–run
                                                label printing. </p>
                                            <b>Professionally Produced Printed Labels</b> <b>Colours</b>
                                            <p>Cyan, Magenta, Yellow, Black, Green, Orange & White.</p>
                                            <p>The inclusion of white ink for solid, opaque white printing on materials
                                                such as clear film and metallic substrates. Facilitates the production
                                                of metallic colours and finishes, white text and panels on clear labels
                                                and the flexibility of printing white first or last e.g. window
                                                stickers. </p>
                                            <b>Resolution</b>
                                            <p>We will select and print to the highest best optimal resolution for the
                                                label image required e.g. 720 x 720DPI; 720 x 1,080DPI; 1,440 x 720DPI
                                                (for paper) & 720 x 1,440DPI (for film) </p>
                                            <b>Web Width </b>
                                            <p>80mm – 330.2mm adjustable to support any width within this range. </p>
                                            <b>Image Size </b>
                                            <p>Up to 315.2mm x 914.4mm maximum. <br>
                                                Label Face-Stock/Substrate Matt, gloss and semi-gloss paper,
                                                Polyethylene & Polypropylene. </p>
                                            <b>Total Substrate Thickness </b>
                                            <p>100 µm – 320 µm </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-3 text-center"><img onerror='imgError(this);' class=""
                                                                                    src="<?= Assets ?>images/categoryimages/labelShapes/white-colour.png"
                                                                                    alt="White Colour"></div>
                                    <div class="clear10"></div>
                                </div>
                            </div>
                            <!--finish end -->
                            <div role="tabpanel" class="tab-pane " id="tab_order_fulfillment">
                                <div class="col-md-9 col-xs-12 col-sm-7  text-justify titleX">
                                    <div class="clear10"></div>
                                    <b>Press Scheduling </b>
                                    <p>Orders are added to the print queue following final approval of artwork from the
                                        soft-proof provided. We commit to print, finishing and conversion within 4
                                        working days from this point. </p>
                                    <p>Despatch Deliveries are made the following working day in mainland UK (other than
                                        exception postcodes and offshore). Delivery times outside of the UK vary, please
                                        refer to "Delivery & Shipping" under "SITE LINKS" in the footer of this
                                        page. </p>
                                    <b>Delivery </b>
                                    <p>You can therefore expect to receive your printed labels within 3 – 5 working days
                                        in the UK. Outside of the UK delivery times vary. </p>
                                </div>
                                <div class="col-xs-12 col-sm-5 col-md-3"><img onerror='imgError(this);'
                                                                              class="img-responsive"
                                                                              src="<?= Assets ?>images/categoryimages/labelShapes/delivery.png"
                                                                              alt="AA Labels Delivery Van"></div>
                            </div>
                            <!--adhesive end -->
                            <div role="tabpanel" class="tab-pane titleX " id="tab_samples">
                                <div class="col-md-8 col-xs-12 col-sm-7  text-justify">
                                    <div class="clear10"></div>
                                    <b>Material Samples</b>
                                    <p>Samples of label materials can be provided (FOC) for evaluation of the
                                        application suitability , but will not be a label size sample. These can be
                                        ordered from the website, or by <a target="_blank"
                                                                           href="<?= base_url() ?>contact-us/"><span
                                                    class="glyphicon glyphicon-new-window"></span> contacting customer
                                            care.</a></p>
                                    <b>Press-Proofs </b>
                                    <p>In addition to soft-proof artwork for approval, should you require a physical
                                        print sample of your label to assess and approve the print quality, layout and
                                        finish. Please contact our customer care team who will be able to advise of the
                                        cost of this service for your order.</p>
                                </div>
                                <div class="col-xs-12 col-sm-5 col-md-4">
                                    <div class="clear10"></div>
                                    <img onerror='imgError(this);' class="img-responsive"
                                         src="<?= Assets ?>images/categoryimages/labelShapes/roll-sheet.png"
                                         alt="Printed Labels"></div>
                            </div>
                            <!--printing end -->
                            <!--delivery end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ourTeam" id="start_with_printing" style="display:block;">
    <div class="container">
        <div class="clear30"></div>
        <nav class="prLbSteps-nav">
            <ul>
                <!-- <li class="col-lg-2 col-md-3 col-sm-3 col-xs-12 no-padding step-1">
                    <a class="col-xs-12 no-padding" data-value="1" tabindex="-1">
                        <div class="col-xs-2 no-padding-left"><span class="cnt">1</span></div>
                        <div class="col-xs-9 no-padding stepText" style="padding-left: 10px !important;"> Shape &amp;
                            Size &nbsp;<i class="fa fa-chevron-right"></i></div>
                    </a></li> -->
                <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 step-2 no-padding prLbSteps-step-active prLbSteps-step-selected "><a class="col-xs-12 no-padding"
                                                                                       data-value="2" tabindex="-1">
                        <div class="col-xs-2 no-padding-left"><span class="cnt">2</span></div>
                        <div class="col-xs-10 no-padding stepText"> Material &amp; Finish &nbsp;<i
                                    class="fa fa-chevron-right"></i></div>
                    </a></li>
                <li class="col-lg-3 col-md-3 col-sm-3 col-xs-12 step-3 no-padding"><a class="col-xs-12 no-padding"
                                                                                      data-value="3" tabindex="-1">
                        <div class="col-xs-2 no-padding-left"><span class="cnt">3</span></div>
                        <div class="col-xs-10 no-padding stepText"> Quantity &amp; Prices &nbsp;<i
                                    class="fa fa-chevron-right"></i></div>
                    </a></li>
                <li class="col-lg-4 col-md-3 col-sm-3 col-xs-12 step-4 no-padding"><a class="col-xs-12 no-padding"
                                                                                      data-value="4" tabindex="-1">
                        <div class="col-xs-2 no-padding-left"><span class="cnt">4</span></div>
                        <div class="col-xs-10 no-padding stepText  uac"> Upload Artwork &amp; Checkout &nbsp;<i
                                    class="fa fa-chevron-right"></i></div>
                    </a></li>
            </ul>
        </nav>
        <!-- <div id="Printing_Step_1" class="StepContent" style="display:none;"> -->
            <? //include('Step1.php') ?>
        <!-- </div> -->

        <input type="hidden" value="" id="product_count"/>
        <input type="hidden" value="" id="category_id"/>
        <input type="hidden" value="" id="available_in"/>
        <input id="shape" value="rectangle" type="hidden">

        <div id="Printing_Step_2" class="StepContent" style="display:block;">
            <? include('Step2.php') ?>
        </div>
        <div id="Printing_Step_3" class="StepContent" style="display:none;">
            <div class="show_selected_product"></div>
        </div>
        <div id="Printing_Step_4" class="StepContent" style="display:none;">
            <div class="show_selected_product"></div>
        </div>
    </div>
</div>
<div class="modal fade artwork_help aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content no-padding">
            <div class="panel no-margin">
                <div class="panel-heading">
                    <h4 class="pull-left no-margin"><b>Guidelines for producing print-ready digital artwork</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-times-circle"></i></button>
                    <div class="clear"></div>
                </div>
                <div class="panel-body">
                    <div>
                        <?php include(APPPATH . '/views/print_service/upload/help.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade layout aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content no-padding">
            <div class="panel no-margin">
                <div class="panel-heading">
                    <h3 class="pull-left no-margin"><b>Label Layout</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-times-circle"></i></button>
                    <div class="clear"></div>
                </div>
                <div class="panel-body">
                    <div id="ajax_layout_spec"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade preferences aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content no-padding">
            <div class="panel no-margin">
                <div class="panel-heading">
                    <h3 class="pull-left no-margin"><b>Preferences Found</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-times-circle"></i></button>
                    <div class="clear"></div>
                </div>
                <div class="panel-body">
                    <div id="preferences_found">You previously viewed the labels shown, would you like to reopen this
                        search, or start a new one?
                    </div>
                    <div class="mat-sep-2017">
                        <div class="selected-product">
                            <div id="a4_block">
                                <div class="row">
                                    <div class="col-lg-3 col-md-2 col-sm-3 col-xs-3 pr-thumb img-responsive"><img
                                                onerror='imgError(this);'
                                                src="<?= Assets ?>images/categoryimages/A4Sheets/AAS176.png"
                                                alt="AAS176 Sheet"/></div>
                                    <!-- end col-->
                                    <div class="col-lg-9 col-md-10 col-sm-9 col-xs-9">
                                        <h2 class="pr-title">Sheet Labels</h2>
                                        <div class="pr-detail">
                                            <p><b>Product Code: <span class="pr-code productcode_a4"></span></b></p>
                                            <p><b>Material:</b> <span class="material_a4"></span></p>
                                            <p><b>Colour:</b> <span class="color_a4"></span></p>
                                            <p><b>Adhesive:</b> <span class="adhesive_a4"></span></p>
                                            <p><b>Digital Process:</b> <span class="digital_proccess_a4"></span></p>
                                            <p><b>Quantity:</b> <span class="sheets_a4"></span><span class="labels_a4">()</span>
                                            </p>
                                            <p><b>Finish:</b> N/A</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end a4_block-->
                            <div id="roll_block" class="m-t-60">
                                <div class="row">
                                    <div class="col-lg-3 col-md-2 col-sm-3 col-xs-3 pr-thumb img-responsive"><img
                                                onerror='imgError(this);' src="<?= Assets ?>images/outside_25.jpg">
                                    </div>
                                    <!-- end col-->
                                    <div class="col-lg-9 col-md-10 col-sm-9 col-xs-9">
                                        <h2 class="pr-title">Roll Labels</h2>
                                        <div class="pr-detail">
                                            <p><b>Product Code: <span class="pr-code productcode_roll"></span></b></p>
                                            <p><b>Material:</b> <span class="material_roll"></span></p>
                                            <p><b>Colour:</b> <span class="color_roll"></span></p>
                                            <p><b>Adhesive:</b> <span class="adhesive_roll"></span></p>
                                            <p><b>Digital Process:</b> <span class="digital_proccess_roll"></span></p>
                                            <p><b>Finish:</b> <span class="finish_roll"></span></p>
                                            <p><b>Quantity:</b> <span class="labels_roll"></span></p>
                                            <p><b>Core Size:</b> <span class="coresize"></span></p>
                                            <p><b>Wound Option:</b> <span class="wound_roll"></span></p>
                                            <p><b>Orientation:</b> <span class="orientation"> </span></p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end roll_block-->
                        </div>
                        <!-- end selected-->
                    </div>
                    <!--end mat-sep-->
                    <div id="preferences_values"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn blueBg reject_pref btn-xs">Start New Search</button>
                    <button type="button" class="btn orangeBg confirm_pref btn-xs">Open Preferences Found</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var contentbox = $('#ajax_finder_content');
    var default_min_h = 0;
    var default_max_h = 0;
    var default_min_w = 0;
    var default_max_w = 0;
    var request = null;
    var preferences = null;
    function alert_box(text) {
        swal({
            title: "",
            text: text,
            confirmButtonColor: "#17b1e3",
            confirmButtonText: "Continue",
            type: "",
        });
    }
    var timer = '';
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
    
    
    $(document).on("click", "#home_finder", function (e) {
        var shape_sel = $('#shape_sel').val();
        var email = $('#email').val();
        if (email.length < 1) {
            alert_box('Please enter your email');
            return false;
        } else if (shape_sel.length < 1) {
            alert_box('Please select label shape');
            return false;
        } else {
            //preferences = get_printing_preferences();
            $.ajax({
                url: base + 'ajax/load_preferences',
                type: "POST",
                async: "false",
                dataType: "html",
                data: {
                    email: email
                },
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.response == 'yes' && data.preferences.selected_size != null) {
                        preferences = data.preferences;
                        $('.preferences').modal('show');
                        return false;
                        /*swal({
										  title: 'Preferences Found',
										  type: "success",
										  text: "Do you want to load old preferences?",
										  showCancelButton: true,
										  confirmButtonClass: "btn blueBg m-r-10",
										  confirmButtonText: "No",
										  cancelButtonClass: "btn orangeBg",
										  cancelButtonText: "Yes",
										  closeOnConfirm: true,
										  closeOnCancel: true
										 },
											function(isConfirm) {
											  if (isConfirm) {
													var shape = $('#shape_sel').val();
													$('#index_printing').hide();
													$('#bg-index').hide();
													$('#bg-step-1').show();
													$('#start_with_printing').show();
													$('.btn_shape').removeClass('active');
													$('[data-val="'+shape+'"]').addClass('active');
													$('#shape').val(shape);
													filter_size_data('shape');
											  } else {
												    $("#aa_loader").show();
												    apply_preferences(data.preferences);
											 }
										  });
										  */
                    } else {
                        var shape = $('#shape_sel').val();
                        $('#index_printing').hide();
                        $('#bg-index').hide();
                        $('#bg-step-1').show();
                        $('#start_with_printing').show();
                        $('.btn_shape').removeClass('active');
                        $('[data-val="' + shape + '"]').addClass('active');
                        $('#shape').val(shape);
                        filter_size_data('shape');
                    }
                }
            });
        }
    });
    $(document).on("click", ".btn_shape", function (e) {
        $('.btn_shape').removeClass('active');
        var shape = $(this).attr('data-val');
        $(this).addClass('active');
        $('#shape').val(shape);
        filter_size_data('shape');
    });
    $(document).on("click", ".layout_specs", function (e) {
        var id = $(this).attr('id');
        $('#ajax_layout_spec').html('');
        $('#specs_loader').show();
        var imgpath = $(this).attr('imgpath');
        $.ajax({
            url: base + 'ajax/layout_popup/' + id,
            type: "POST",
            async: "false",
            dataType: "html",
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    $('#specs_loader').hide();
                    $('#ajax_layout_spec').html(data.html);
                    if (typeof imgpath !== 'undefined' && imgpath !== '') {
                        $('#ajax_layout_spec').find('.design-image').attr('src', imgpath);
                    }
                }
            }
        });
    });
    $(document).on("click", ".proceed_upload", function (e) {
        var upload_option = $('input[name=upload_option]:checked').val();
        /******** Remove any uploaded artowrk files ***************/
        if (upload_option !== 'upload_artwork') {
            clear_uploaded_artworks();
        }
        /******** Remove any uploaded artowrk files ***************/
        if (upload_option == 'email_artwork') {
            $('.proceed_to_checkout').click();
        } else {
            $('.UploadMainSelection').hide();
            $('.' + upload_option).show();
            $('.print_option_box').show();
        }
        remarketting_trigger_step(5);
    });
    $(document).on("click", ".backtouploadwindow", function (e) {
        $('.upload_artwork').hide();
        $('.email_artwork').hide();
        $('.design_services').hide();
        $('.print_option_box').hide();
        $('.UploadMainSelection').show();
    });
    /*$(document).on("click", ".designservicecharge", function(e) {
		var designservice = $('input[name=print_designservice]:checked').val();
		var price = $('input[name=print_designservice]:checked').attr('data-val');
		var charges = parseFloat(price).toFixed(2);
		$('.printservicecharges_price').html('<b><?=symbol?>'+charges+'</b>').show();
		var total =  parseFloat($('#summary_total_price').val());
		total = parseFloat(total)+parseFloat(charges);
		$('#summary_price').text(parseFloat(total).toFixed(2))
		$('.printservicecharges_txt').show();
});*/
    /***** calculation prices *****/
    $(document).on("keypress keyup", ".input-quantities", function (e) {
        var id_array = $(this).attr('id').split('_');
        var id = id_array[2];
        var sheetqty = $('#sheet_qty_' + id).val();
        //var designqty = $('#design_qty_'+id).val();
        var type = $('#producttype' + id).val();
        var min_qty = $('#min_qty' + id).val();
        if (type == 'roll') {
            //if(!is_numeric(designqty) ||  designqty == 0){ var designqty = 1;}
            var min_qty = min_qty;
            //$('.roll_sheets_block').find('.display_sheets').text('Min '+min_qty+' Labels').show();
            //$('.roll_sheets_block').find('.display_sheets').attr('placeholder', min_qty+'+');
            //$('.roll_sheets_block').find('.display_sheets').next('small').text('Minimum '+ min_qty + ' labels');
        }
    });
    function show_calculate_btn(id) {
        $('#cal_btn' + id).show();
        $('#add_btn' + id).hide();
        $('#price_box_' + id).hide();
        var sheetqty = $('#sheet_qty_' + id).val();
        //var designqty = $('#design_qty_'+id).val();
        if (sheetqty.length > 0) {
            $('#cal_btn' + id).switchClass('orange', 'orangeBg');
        } else {
            $('#cal_btn' + id).switchClass('orangeBg', 'orange');
        }
        var type = $('#producttype' + id).val();
        if (type != 'roll') {
            $('.a4_sheets_block').find('.oQty').html('');
            $('.a4_sheets_block').find('.basepricetext').hide();
        } else {
            $('.roll_sheets_block').find('.basepricetext').hide();
        }
    }
    function add_item(id, menuid) {
        var rollfinish = '';
        var coresize = '';
        var woundoption = '';
        var orientation = '';
        var pressproof = '';
        var type = $('#producttype' + id).val();
        var unitqty = $('#calculation_unit' + id).val();
        if (type == 'roll') {
            var rollfinish = $('#rollfinish' + id).val();
            var coresize = $('#label_coresize').val();
            var woundoption = $('#woundoption').val();
            var orientation = $('#label_orientation').val();
        }
        var qty = $('#sheet_qty_' + id).val();
        var printing = $('#digitalprocess' + id).val();
        var labels = $('#labels_p_sheet' + id).val();
        var min_qty = parseInt($('#min_qty' + id).val());
        var max_qty = parseInt($('#max_qty' + id).val());
        if (unitqty == 'labels' && type == 'sheet') {
            var min_qty = parseInt(labels) * 25;
            var max_qty = parseInt(labels) * 50000;
        }
        if (!is_numeric(qty) || qty == '' || qty < min_qty) {
            if (type == 'sheet') {
                if (unitqty == "labels") {
                    // alert_box('The minimum order quantity is 25 sheets ('+min_qty+' labels) please re-enter the number of labels required, in multiples of '+labels);
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + min_qty + ' labels.');
                } else {
                    //alert_box('The minimum order quantity is 25 sheets please re-enter the number of sheets required');
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as 25 sheets');
                }
            } else {
                //alert_box('Minimum quantity allowed from '+min_qty+' to '+max_qty+' Labels');
                alert_box('Please add quantity between ' + min_qty + ' and ' + max_qty);
            }
            return false;
        } else if (qty > max_qty) {
            $('#sheet_qty_' + id).val(max_qty);
            if (type == 'sheet') {
                if (unitqty == 'labels') {
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + max_qty + ' labels.');
                    // alert_box('The Maximum order quantity is 50000 sheets ('+max_qty+' labels) please re-enter the number of labels required, in multiples of '+labels);
                } else {
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as 50000 sheets');
                    // alert_box('The Maximum order quantity is 50000 sheets ('+max_qty+' labels) please re-enter the number of sheets required');
                }
            } else {
                //alert_box('Maximum quantity allowed '+max_qty+' Labels');
                show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + max_qty + ' labels.');
            }
            return false;
        } else {
            if (unitqty == 'labels' && type == 'sheet') {
                var qty = parseInt(qty / labels);
            }
            var cartid = $('#cartid').val();
            //var pressproof = $('#pressproof').val();
            show_loader('80', '27');
            var _this = $("#add_btn" + id);
            change_btn_state(_this, 'disable', 'proceed-print');
            $.ajax({
                url: base + 'ajax/continue_with_product',
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
                    pressproof: pressproof,
                    unitqty: unitqty,
                },
                success: function (data) {
                    if (!data == '') {
                        data = $.parseJSON(data);
                        if (data.response == 'yes') {
                            change_btn_state(_this, 'enable', 'sample');
                            $('#Printing_Step_4').find('.show_selected_product').html(data.content);
                            $("[data-toggle=tooltip-orintation_popup]").tooltip('destroy');
                            $("[data-toggle=tooltip-orintation_popup]").tooltip();
                            activate_steps(4);
                            $('#aa_loader').hide();
                            intialize_progressbar();
                        }
                    }
                }
            });
        }
        //alert_box('Please wait functionality is under development');
    }
    function intialize_progressbar() {
        $("#progressbar").progressbar({
            value: 0,
            create: function (event, ui) {
                $(this).removeClass("ui-corner-all").addClass('progress').find(">:first-child").removeClass("ui-corner-left").addClass('progress-bar progress-bar-success');
            }
        });
    }
    function calculate_sheet_price(id, menuid) {
        var rollfinish = '';
        var coresize = '';
        var woundoption = '';
        var orientation = '';
        var pressproof = '';
        var email = '';
        var type = $('#producttype' + id).val();
        var unitqty = $('#calculation_unit' + id).val();
        var qty = parseInt($('#sheet_qty_' + id).val());
        //var designs = parseInt($('#design_qty_'+id).val());
        var printing = $('#digitalprocess' + id).val();
        var labels = $('#labels_p_sheet' + id).val();
        var min_qty = parseInt($('#min_qty' + id).val());
        var max_qty = parseInt($('#max_qty' + id).val());
        if (unitqty == 'labels' && type == 'sheet') {
            var min_qty = parseInt(labels) * min_qty;
            var max_qty = parseInt(labels) * max_qty;
        }
        if (type == 'roll') {
            var rollfinish = $('#rollfinish' + id).val();
            var coresize = $('#label_coresize').val();
            var woundoption = $('#woundoption').val();
            var orientation = $('#label_orientation').val();
        }
        if (!is_numeric(qty) || qty == '' || qty < min_qty) {
            $('#sheet_qty_' + id).val(min_qty);
            if (type == 'sheet') {
                if (unitqty == "labels") {
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + min_qty + ' labels.');
                    // alert_box('The minimum order quantity is 25 sheets ('+min_qty+' labels) please re-enter the number of labels required, in multiples of '+labels);
                } else {
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + min_qty + ' sheets.');
                    // alert_box('The minimum order quantity is 25 sheets please re-enter the number of sheets required');
                }
            } else {
                //alert_box('Minimum quantity allowed from '+min_qty+' to '+max_qty+' Labels');
                show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + min_qty + ' labels.');
            }
            //$('#sheet_qty_'+id).val(min_qty);
        } else if (qty > max_qty) {
            $('#sheet_qty_' + id).val(max_qty);
            if (type == 'sheet') {
                if (unitqty == 'labels') {
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + max_qty + ' labels.');
                    // alert_box('The Maximum order quantity is 50000 sheets ('+max_qty+' labels) please re-enter the number of labels required, in multiples of '+labels);
                } else {
                    show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + max_qty + ' sheets.');
                    // alert_box('The Maximum order quantity is 50000 sheets ('+max_qty+' labels) please re-enter the number of sheets required');
                }
            } else {
                show_faded_popover($('#sheet_qty_' + id), 'Quantity has been amended for production as ' + max_qty + ' labels.');
                //alert_box('Maximum quantity allowed '+max_qty+' Labels');
            }
        } else {
            if (qty % labels != 0 && type != 'roll' && unitqty == 'labels') {
                var multipyer = parseInt(labels) * parseInt(parseInt(qty / labels) + 1);
                $('#sheet_qty_' + id).val(multipyer);
                var qty = multipyer;
            }
            if (unitqty == 'sheets' && type != 'roll') {
                $('.a4_sheets_block').find('.oQty').html(' ( ' + parseInt(labels * qty) + ' Labels )');
            } else if (unitqty == 'labels' && type != 'roll') {
                $('.a4_sheets_block').find('.oQty').html(' ( ' + parseInt(qty / labels) + ' Sheets )');
            }
            if (unitqty == 'sheets') {
                var qty = parseInt(qty * labels);
            }
            show_loader('80', '27');
            var _this = $("#cal_btn" + id);
            change_btn_state(_this, 'disable', 'printed-labels');
            $.ajax({
                url: base + 'ajax/calculate_printing_prices',
                type: "POST",
                async: "false",
                dataType: "html",
                data: {
                    qty: qty,
                    email: $("#email").val(),
                    designs: 1,
                    menuid: menuid,
                    prd_id: id,
                    labelspersheets: labels,
                    labeltype: printing,
                    rollfinish: rollfinish,
                    coresize: coresize,
                    woundoption: woundoption,
                    orientation: orientation,
                    producttype: type,
                    pressproof: pressproof,
                },
                success: function (data) {
                    if (!data == '') {
                        data = $.parseJSON(data);
                        if (data.response == 'yes') {
                            change_btn_state(_this, 'enable', 'printed-labels');
                            $('#cal_btn' + id).hide();
                            $('#add_btn' + id).show();
                            $('#save_txt' + id).html(data.save_txt);
                            $('#delivery_txt' + id).html(data.delivery_txt).show();
                            $('#price_' + id).html('<b class="color-orange"> ' + data.symbol + data.price + '</b>');
                            $('#priceText_' + id).html(data.labelprice);
                            $('#total' + id).find('.phead').html('<strong>Line Total (' + data.vatoption + ' VAT)</strong>');
                            if (type == 'roll') {
                                if (printing == 'Monochrome – Black Only') {
                                    var ptypetxt = 'Black Only ';
                                } else if (printing == '6 Colour Digital Process + White') {
                                    var ptypetxt = '6 Colour + White ';
                                } else {
                                    var ptypetxt = '6 Colour ';
                                }
                                //Monochrome – Black Only
                                //6 Colour Digital Process
                                $('#sheet_qty_' + id).val(data.labels);
                                //$('.roll_sheets_block').find('.display_sheets').text(data.sheets+' Rolls').show();
                                //$('.roll_sheets_block').find('.freedesigns').text(data.artworks+' Designs Free').show();
                                //$('.roll_sheets_block').find('.pressproof').html('<b class="pr-sm">'+data.symbol+data.pressproof+'</b>');
                                //$('#desginprice'+id).find('.numberdesign').html('Studio Charge Free');
                                $('#desginprice' + id).hide();
                                //$('#fullprintprice'+id).find('.phead').text(printing );
                                $('#fullprintprice' + id).find('.printprice').html('<b class="pr-sm">' + data.symbol + data.plainlabelsprice + '</b>');
                                $('#printprice' + id).find('.phead').text(ptypetxt);
                                $('#printprice' + id).find('.printprice').html('<b class="pr-sm">' + data.symbol + data.onlyprintprice + '</b>');
                                $('#promoprice' + id).find('.promoprice').html('<b class="pr-sm"> - ' + data.symbol + data.halfprintprice + '</b>');
                                $('#finishprice' + id).find('.phead').text(rollfinish);
                                $('#finishprice' + id).find('.finishprice').html('<b class="pr-sm">' + data.symbol + data.label_finish + '</b>');
                                var labelsperroll = parseInt(data.labels / data.sheets);
                                var basedtext = 'Price based on ' + data.sheets + ' Rolls x ' + labelsperroll + ' labels per Rolls';
                                $('.roll_sheets_block').find('.basepricetext').text(basedtext).show();
                            } else {
                                $('#plainprice' + id).find('.plainprice').html('<b class="pr-sm">' + data.symbol + data.plainprice + '</b>');
                                $('#printprice' + id).find('.phead').html(printing);
                                $('#printprice' + id).find('.printprice').html('<b class="pr-sm">' + data.symbol + data.promo + '</b>');
                                $('#promoprice' + id).find('.promoprice').html('<b class="pr-sm"> - ' + data.symbol + data.printprice + '</b>');
                                $('#desginprice' + id).find('.numberdesign').html('Studio (' + data.artworks + ' Design Free) ');
                                $('#desginprice' + id).find('.desginprice').html('<b class="pr-sm">' + data.symbol + data.designprice + '</b>');
                                $('#desginprice' + id).show();
                                $('#no_design' + id).show();
                                var basedtext = 'Price based on ' + data.sheets + ' Sheets ( ' + data.labels + ' labels )';
                                $('.a4_sheets_block').find('.basepricetext').text(basedtext).show();
                                //$('.a4_sheets_block').find('.display_sheets').text(data.sheets+' Sheets').show();
                                //$('.a4_sheets_block').find('.freedesigns').text(data.artworks+' Designs Free').show();
                                //$('#desginprice'+id).find('.numberdesign').html('Studio Charge X '+parseInt((data.nodesing-data.artworks)));
                                //$('#no_design'+id).find('.phead').html(' Studio Charge '+data.artworks+' FREE');
                            }
                            $('#penceperlabels' + id).find('.phead').text('( ' + data.priceperlabels + ' pence per label ) ');
                            $('#plainprice' + id).show();
                            $('#printprice' + id).show();
                            $('#price_box_' + id).show();
                        }
                        $('#aa_loader').hide();
                    }
                }
            });
        }
    }
    $(document).on("click", ".prLbSteps-step-active a", function (e) {
    });
    /***** calculation prices *****/
    function activate_steps(step) {
        step = parseInt(step);
        remarketting_trigger_step(step);
        $('.prLbSteps-nav').find('li').removeClass('prLbSteps-step-selected');
        $('.step-' + step).addClass('prLbSteps-step-active prLbSteps-step-selected');
        $('.StepContent').hide();
        $('#Printing_Step_' + step).show();
        var scrollPos = $('#Printing_Step_' + step).offset().top;
        $(window).scrollTop(scrollPos - 150);
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
    $(document).on("mouseover", ".dropdown-menu li a", function (e) {
        var selText = $(this).text();
        var orientation = $(this).attr('data-id');
        var woundoption = $('#woundoption').val();
        if (typeof orientation != 'undefined') {
            var imagepath = '<?=Assets?>images/categoryimages/winding/' + woundoption + '/' + orientation + '.png';
            $(this).find('img').attr('src', imagepath);
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
        update_roll_images();
    });
    function update_roll_images() {
        orientation_text();
        var coreid = $('#label_coresize').val();
        var imagename = $('#wound_image').attr('data-imagename');
        var orientatoin = $('#label_orientation').val();
        var val = $('#woundoption').val();
        if (val == 'Inside') {
            //var path = '<?=Assets?>images/categoryimages/inner_roll/';
            var path = '<?=Assets?>images/categoryimages/RollLabels/inside/';
            var windingpath = '<?=Assets?>images/categoryimages/winding/Inside';
        } else {
            //var path = '<?=Assets?>images/categoryimages/roll_desc/';
            var path = '<?=Assets?>images/categoryimages/RollLabels/outside/';
            var windingpath = '<?=Assets?>images/categoryimages/winding/Outside';
        }
        $('.roll_sheets_block').find('.display_sheets').focus();
        //path +=imagename+coreid+'.jpg';
        var productcode = $('.roll_sidebar').find('span[name="productcode_text"]').text();
        productcode = productcode.replace(/\s/g, '').slice(0, -1);
        coreid = coreid.replace(/[^\d.]/g, '');
        var img_code = productcode + coreid;
        path += img_code + '.jpg';
        windingpath += '/' + orientatoin + '.png';
        $('#wound_image').attr('src', path);
        $('.windingimage').attr('src', windingpath);
    }
    $(document).on("click", ".prLbSteps-step-active a", function (e) {
        var step = $(this).attr('data-value');
        activate_steps(step);
    });
    $(document).on("click", ".select_size", function (e) {
        select_size('button', $(this));
    });
    function select_size(data, _this) {
        if (data == 'button') {
            $('.matselector').find('.material-d-down > .dropdown-toggle').html('Select Label Material <i class="fa fa-unsorted"></i>');
            $('.matselector').find('.color-d-down > .dropdown-toggle').html('Select Label Colour <i class="fa fa-unsorted"></i>');
            $('.matselector').find('.adhesive-d-down > .dropdown-toggle').html('Select Label Adhesive <i class="fa fa-unsorted"></i>');
            $('.matselector').find('input[name="material"]').val('');
            $('.matselector').find('input[name="color"]').val('');
            $('.matselector').find('input[name="adhesive"]').val('');
            $('.labelsummary').html('');
            var available_in = $(_this).attr('data-size');
            $('#available_in').val(available_in);
            $('#a4_material_selection').find('select').val('');
            $('#roll_material_selection').find('select').val('');
            $('.a4_material_selection').find('span').text('');
            $('.roll_material_selection').find('span').text('');
            if (available_in == 'A4') {
                var category_id = $(_this).attr('data-a4');
                $('#category_id').val(category_id);
                $('.a4_material_selection').show();
                $('.roll_material_selection').hide();
                $('#a4_material_selection').show();
                $('#empty_material_selection').show();
                $('#roll_material_selection').hide();
                filter_material_data('size', 'a4_material_selection', 'A4');
            } else if (available_in == 'Roll') {
                var category_id = $(_this).attr('data-roll');
                $('#category_id').val(category_id);
                $('.a4_material_selection').hide();
                $('.roll_material_selection').show();
                $('#a4_material_selection').hide();
                $('#roll_material_selection').show();
                $('#empty_material_selection').show();
                filter_material_data('size', 'roll_material_selection', 'Roll');
            } else if (available_in == 'both') {
                var category_a4 = $(_this).attr('data-a4');
                var category_roll = $(_this).attr('data-roll');
                $('#category_id').val(category_a4 + ',' + category_roll);
                $('.a4_material_selection').show();
                $('.roll_material_selection').show();
                $('#a4_material_selection').show();
                $('#roll_material_selection').show();
                $('#empty_material_selection').hide();
                filter_material_data('size', 'roll_material_selection', 'Roll');
                filter_material_data('size', 'a4_material_selection', 'A4');
            }
            var sizeimagepath = $(_this).parents('.thumbnail').find('.lbl_img_size').attr('src');
            $('.labelsummary').find('.lbl_img_size').attr('src', sizeimagepath);
            //$('.prLbSteps-nav').find('li').removeClass('prLbSteps-step-selected');
            //$('.prLbSteps-nav').find('li').removeClass('prLbSteps-step-active');
            $('.step-3').removeClass('prLbSteps-step-active');
            $('.step-4').removeClass('prLbSteps-step-active');
        } else {
            var available_in = $('#available_in').val();
            $('#a4_material_selection').find('select').val(data.finish_a4);
            $('#roll_material_selection').find('select').val(data.finish_roll);
            $('.a4_material_selection').find('span').text('');
            $('.roll_material_selection').find('span').text('');
            if (available_in == 'A4') {
                var category_id = $('#category_id').val();
                $('.a4_material_selection').show();
                $('.roll_material_selection').hide();
                $('#a4_material_selection').show();
                $('#empty_material_selection').show();
                $('#roll_material_selection').hide();
                filter_material_data('size', 'a4_material_selection', 'A4');
            } else if (available_in == 'Roll') {
                var category_id = $('#category_id').val();
                $('.a4_material_selection').hide();
                $('.roll_material_selection').show();
                $('#a4_material_selection').hide();
                $('#roll_material_selection').show();
                $('#empty_material_selection').show();
                filter_material_data('size', 'roll_material_selection', 'Roll');
            } else if (available_in == 'both') {
                $('.a4_material_selection').show();
                $('.roll_material_selection').show();
                $('#a4_material_selection').show();
                $('#roll_material_selection').show();
                $('#empty_material_selection').hide();
                filter_material_data('size', 'roll_material_selection', 'Roll');
                filter_material_data('size', 'a4_material_selection', 'A4');
            }
            var sizeimagepath = $(_this).parents('.thumbnail').find('.lbl_img_size').attr('src');
            $('.labelsummary').find('.lbl_img_size').attr('src', sizeimagepath);
            $('.step-3').removeClass('prLbSteps-step-active');
            $('.step-4').removeClass('prLbSteps-step-active');
        }
        activate_steps(2);
        //var hidevalue = "6 Colour Digital Process + White";
        //	$(".digital_proccess-d-down").find("[data-value='"+hidevalue+"']").parent("li").hide();
    }
    $(document).on("click", ".matselector .dm-selector li a", function (e) {
        var selText = $(this).text();
        var filter = $(this).attr('data-id');
        var id = $(this).parents('.matselector').attr('id');
        if (id == 'roll_material_selection') {
            var type = 'Roll';
            var ddtext = ' (Rolls) ';
        } else {
            var type = 'A4';
            var ddtext = ' (Sheets) ';
        }
        var value = $(this).attr('data-value');
        if (value.length > 0) {
            $(this).parents('.btn-group').find('.dropdown-toggle').html(selText + ' <i class="fa fa-unsorted"></i>');
        } else {
            if (filter == "material") {
                $(this).parents('.btn-group').find('.dropdown-toggle').html('Select Label Material <i class="fa fa-unsorted"></i>');
                $(this).parents('.matselector').find('input[name="' + filter + '"]').val('');
            } else if (filter == "adhesive") {
                $(this).parents('.btn-group').find('.dropdown-toggle').html('Select Label Adhesive <i class="fa fa-unsorted"></i>');
                $(this).parents('.matselector').find('input[name="' + filter + '"]').val('');
            } else if (filter == "color") {
                $(this).parents('.btn-group').find('.dropdown-toggle').html('Select Label Colour <i class="fa fa-unsorted"></i>');
                $(this).parents('.matselector').find('input[name="' + filter + '"]').val('');
            } else if (filter == "digital") {
                $(this).parents('.btn-group').find('.dropdown-toggle').html('Select Digital Print Process ' + ddtext + '<i class="fa fa-unsorted"></i>');
                $(this).parents('.matselector').find('input[name="' + filter + '"]').val('');
            }
        }
        $(this).parents('.matselector').find('input[name="' + filter + '"]').val(value);
        if (filter == 'digital') {
            update_material_selection(id);
        } else {
            filter_material_data(filter, id, type);
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
            update_roll_images();
        }
    });
    $(document).on("change", ".nlabelfilter", function (e) {
        var allchecked = true;
        var filter = $(this).attr('name');
        var id = $(this).parents('.matselector').attr('id');
        if (id == 'roll_material_selection') {
            var type = 'Roll';
            $("#roll_material_selection .nlabelfilter").each(function (index) {
                if ($(this).val().length == 0) {
                    rollflag = 'active';
                    allchecked = false;
                }
            });
        } else {
            var type = 'A4';
            $("#a4_material_selection .nlabelfilter").each(function (index) {
                if ($(this).val().length == 0) {
                    a4flag = 'active';
                    allchecked = false;
                }
            });
        }
        if (filter == 'digital' || filter == 'finish') {
            update_material_selection(id);
        } else {
            filter_material_data(filter, id, type);
        }
        if (allchecked == true) {
            $('#Printing_Step_2').find('.step-forward').addClass('orangeBg');
        } else {
            $('#Printing_Step_2').find('.step-forward').removeClass('orangeBg');
        }
    });
    function filter_material_data(trigger, container, type) {
        var category_id = $('#category_id').val();
        var available_in = $('#available_in').val();
        var email = $('#email').val();
        var material = $('#' + container).find('input[name="material"]').val();
        var color = $('#' + container).find('input[name="color"]').val();
        var adhesive = $('#' + container).find('input[name="adhesive"]').val();
        var finish = $('#' + container).find('select[name="finish"]').val();
        $element = $('.nlabelfilter');
        $element.prop('disabled', true);
        $element.attr('disabled', true);
        show_loader('100', '27');
        var request = $.ajax({
            url: base + 'ajax/printingmaterials',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                email: email,
                category_id: category_id,
                available_in: available_in,
                material: material,
                color: color,
                adhesive: adhesive,
                type: type
            },
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    if (data.response == 'yes') {
                        if (trigger != 'material') {
                            //$('#material').html(data.material);
                            //$('#'+container).find('select[name="material"]').html(data.material);
                            $('#' + container).find('.material-d-down > .dropdown-menu').html(data.material);
                            $('#' + container).find('.material-d-down').find("[data-toggle=tooltip-material]").tooltip('destroy');
                            $('#' + container).find('.material-d-down').find("[data-toggle=tooltip-material]").tooltip();
                        }
                        if (trigger != 'color') {
                            ///$('#color').html(data.color);
                            //$('#'+container).find('select[name="color"]').html(data.color);
                            $('#' + container).find('.color-d-down > .dropdown-menu').html(data.color);
                            $('#' + container).find('.color-d-down').find("[data-toggle=tooltip-material]").tooltip('destroy');
                            $('#' + container).find('.color-d-down').find("[data-toggle=tooltip-material]").tooltip();
                        }
                        if (trigger != 'adhesive') {
                            //$('#adhesive').html(data.adhesive);
                            //$('#'+container).find('select[name="adhesive"]').html(data.adhesive);
                            $('#' + container).find('.adhesive-d-down > .dropdown-menu').html(data.adhesive);
                            $('#' + container).find('.adhesive-d-down').find("[data-toggle=tooltip-material]").tooltip('destroy');
                            $('#' + container).find('.adhesive-d-down').find("[data-toggle=tooltip-material]").tooltip();
                        }
                        //$("[data-toggle=tooltip-material]").tooltip('destroy');
                        //$("[data-toggle=tooltip-material]").tooltip();
                        if (trigger != 'size') {
                            update_material_selection(container);
                        }
                        $('.' + container).find('span[name="productcode_text"]').html(data.categorycode);
                        if (trigger == 'size') {
                            $('.labelsummary').append(data.image);
                        }
                        $('.labelsize').text(data.labelsize);
                    }
                    $element = $('.nlabelfilter');
                    $element.prop('disabled', false);
                    $element.attr('disabled', false);
                    $('#aa_loader').hide();
                }
            }
        });
    }
    function show_loader(top, left) {
        $('.loading-gif').css('top', top + '%');
        $('.loading-gif').css('left', left + '%');
        $('#aa_loader').show();
    }
    function update_material_selection(container) {
        var material = $('#' + container).find('input[name="material"]').val();
        var color = $('#' + container).find('input[name="color"]').val();
        var adhesive = $('#' + container).find('input[name="adhesive"]').val();  // option:selected
        var finish = $('#' + container).find('select[name="finish"]').val();
        var digital_proccess = $('#' + container).find('input[name="digital"]').val();  // option:selected
        if (container == "roll_material_selection") {
            var hidevalue = "6 Colour Digital Process + White";
            //if(material == "Polypropylene" && color == "Matt White Polypropylene")
            if (material == "Polypropylene" && color == "Gloss Clear") {
                $('#' + container + " .digital_proccess-d-down").find("[data-value='" + hidevalue + "']").parent("li").siblings("li").hide();
            } else {
                if ($("#" + container + " .digital_proccess-d-down").find("[data-value='" + hidevalue + "']").parent("li").siblings("li").css("display") == "none" && $('#' + container).find('input[name="digital"]').val() != hidevalue) {
                    var digital_proccess = ' ';
                    $('#' + container + " input[name='digital']").val('');
                    $('#' + container + " .digital_proccess-d-down a.dropdown-toggle").html('Select Digital Print Process (Rolls) <i class="fa fa-unsorted"></i>');
                }
                $('#' + container + " .digital_proccess-d-down").find("[data-value='" + hidevalue + "']").parent("li").siblings("li").show();
            }
            if ($("#" + container + " .digital_proccess-d-down").find("[data-value='" + hidevalue + "']").parent("li").siblings("li").css("display") == "none" && $('#' + container).find('input[name="digital"]').val() != hidevalue) {
                var digital_proccess = ' ';
                $('#' + container + " input[name='digital']").val('');
                $('#' + container + " .digital_proccess-d-down a.dropdown-toggle").html('Select Digital Print Process (Rolls) <i class="fa fa-unsorted"></i>');
            }
            if ((material == "Polyethylene") && ((color.match(/Matt White/)) || (color.match(/Heat Resistant/)) || (color.match(/Temperature Resistant/)) || (color.match(/Cryogenic/))) && ((adhesive == "Cryogenic") || (adhesive == "Heat Resistant") || (adhesive == "Permanent"))) {
                $("#roll_material_selection").find("select[name='finish']").find("option[value='Gloss Lamination']").hide();
                $("#roll_material_selection").find("select[name='finish']").find("option[value='Matt Lamination']").hide();
                if (finish == "Gloss Lamination" || finish == "Matt Lamination") {
                    var finish = '';
                    $("#roll_material_selection").find("select[name='finish']").val('');
                }
            } else {
                $("#roll_material_selection").find("select[name='finish']").find("option").show();
            }
        }
        $.ajax({
            url: base + 'ajax/update_printing_options',
            type: "POST",
            data: {
                container: container,
                email: $("#email").val(),
                digital_proccess: digital_proccess,
                color: color,
                adhesive: adhesive,
                finish: finish,
                material: material,
            }
        });
        $('.' + container).find('span[name="material_text"]').html(material);
        $('.' + container).find('span[name="color_text"]').html(color);
        $('.' + container).find('span[name="finish_text"]').html(finish);
        $('.' + container).find('span[name="adhesive_text"]').html(adhesive);
        $('.' + container).find('span[name="digital_proccess_text"]').html(digital_proccess);
    }
    function update_material_selection_old(container) {
        var material = $('#' + container).find('input[name="material"]').val();
        var color = $('#' + container).find('input[name="color"]').val();
        var adhesive = $('#' + container).find('input[name="adhesive"]').val();  // option:selected
        var finish = $('#' + container).find('select[name="finish"]').val();
        var digital_proccess = $('#' + container).find('input[name="digital"]').val();  // option:selected
        $('.' + container).find('span[name="material_text"]').html(material);
        $('.' + container).find('span[name="color_text"]').html(color);
        $('.' + container).find('span[name="finish_text"]').html(finish);
        $('.' + container).find('span[name="adhesive_text"]').html(adhesive);
        $('.' + container).find('span[name="digital_proccess_text"]').html(digital_proccess);
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
    $(document).on("click", ".step-forward", function (e) {
        var step = $(this).attr('data-value');
        var validation = '';
        if (step == 3) {
            var available_in = $('#available_in').val();
            if (available_in == 'A4') {
                var validation = check_material_validations('a4_material_selection');
            } else if (available_in == 'Roll') {
                var validation = check_material_validations('roll_material_selection');
            } else if (available_in == 'both') {
                var a4flag = '';
                var rollflag = '';
                $("#a4_material_selection .nlabelfilter").each(function (index) {
                    if ($(this).val()) {
                        a4flag = 'active';
                    }
                });
                $("#roll_material_selection .nlabelfilter").each(function (index) {
                    if ($(this).val()) {
                        rollflag = 'active';
                    }
                });
                if (rollflag == 'active') {
                    var rollvalidation = check_material_validations('roll_material_selection');
                }
                if (a4flag == 'active') {
                    var a4validation = check_material_validations('a4_material_selection');
                } else if (a4flag == '' && rollflag == '') {
                    var validation = check_material_validations('roll_material_selection');
                }
                //console.log(rollvalidation);
                //console.log(a4validation);
                if (rollvalidation == 'false' || a4validation == 'false') {
                    //alert('in step');
                    var validation = 'false';
                    //var validation = check_material_validations('roll_material_selection');
                }
            }
            if (validation != 'false') {
                $('.step-4').removeClass('prLbSteps-step-active');
                get_actual_products();
            }
        } else {
            activate_steps(step);
        }
    });
    function get_actual_products() {
        var email = $('#email').val();
        var available_in = $('#available_in').val();
        var category_id = $('#category_id').val();
        var material_roll = $('#roll_material_selection').find('input[name="material"]').val();
        var color_roll = $('#roll_material_selection').find('input[name="color"]').val();
        var adhesive_roll = $('#roll_material_selection').find('input[name="adhesive"]').val();
        var finish_roll = $('#roll_material_selection').find('select[name="finish"]').val();
        var digital_proccess_roll = $('#roll_material_selection').find('input[name="digital"]').val();
        var material_a4 = $('#a4_material_selection').find('input[name="material"]').val();
        var color_a4 = $('#a4_material_selection').find('input[name="color"]').val();
        var adhesive_a4 = $('#a4_material_selection').find('input[name="adhesive"]').val();
        var digital_proccess_a4 = $('#a4_material_selection').find('input[name="digital"]').val();
        show_loader('80', '27');
        var _this = $(".step-forward[data-value=3]");
        change_btn_state(_this, 'disable', 'step-forward');
        $.ajax({
            url: base + 'ajax/getfinalproducts',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                material_a4: material_a4,
                color_a4: color_a4,
                adhesive_a4: adhesive_a4,
                digital_proccess_a4: digital_proccess_a4,
                material_roll: material_roll,
                color_roll: color_roll,
                adhesive_roll: adhesive_roll,
                finish_roll: finish_roll,
                digital_proccess_roll: digital_proccess_roll,
                category_id: category_id,
                available_in: available_in,
                email: email
            },
            success: function (data) {
                change_btn_state(_this, 'enable', 'step-forward');
                data = $.parseJSON(data);
                $('#Printing_Step_3').find('.show_selected_product').html(data.content);
                $('#Printing_Step_3').find('.show_selected_product').find("[data-toggle=tooltip-orintation]").tooltip('destroy');
                $('#Printing_Step_3').find('.show_selected_product').find("[data-toggle=tooltip-orintation]").tooltip();
                /*$('.roll_material_selection').find('span[name="productcode_text"]').html(data.rollcode);
								$('.a4_material_selection').find('span[name="productcode_text"]').html(data.a4code);
								$('.roll_sheets_block').find('span[name="productcode_text"]').html(data.rollcode);
								$('.a4_sheets_block').find('span[name="productcode_text"]').html(data.a4code);
								$('#label_coresize').html(data.rollcores);*/
                activate_steps(3);
                $('#aa_loader').hide();
            }
        });
    }
    function check_material_validations(container) {
        var material = $('#' + container).find('input[name="material"]').val();
        var color = $('#' + container).find('input[name="color"]').val();
        var adhesive = $('#' + container).find('input[name="adhesive"]').val();
        var finish = $('#' + container).find('select[name="finish"]').val();
        var digital_proccess = $('#' + container).find('input[name="digital"]').val();
        var type = 'Sheets';
        if (container == 'roll_material_selection') {
            var type = 'Rolls';
        }
        if (material.length == 0) {
            swal({
                title: "Please Select",
                text: "Product Material (" + type + ") ",
                confirmButtonText: "Continue",
                type: "",
            });
            return 'false';
        } else if (color.length == 0) {
            swal({
                title: "Please Select",
                text: "Product Colour (" + type + ") ",
                confirmButtonText: "Continue",
                type: "",
            });
            return 'false';
        } else if (adhesive.length == 0) {
            swal({
                title: "Please Select",
                text: "Product Adhesive (" + type + ") ",
                confirmButtonText: "Continue",
                type: "",
            });
            return 'false';
        } else if (typeof digital_proccess != 'undefined' && digital_proccess.length == 0) {
            swal({
                title: "Please Select",
                text: "Digital Print Process (" + type + ") ",
                confirmButtonText: "Continue",
                type: "",
            });
            return 'false';
        } else if (typeof finish != 'undefined' && finish.length == 0) {
            swal({
                title: "Please Select",
                text: "Product Finish (" + type + ") ",
                confirmButtonText: "Continue",
                type: "",
            });
            return 'false';
        } else {
            return 'true';
        }
    }
    $(document).on("click", ".step-back", function (e) {
        var step = $(this).attr('data-value');
        activate_steps(step);
    });
    $(document).on("change", "#opposite_dimension", function (e) {
        filter_size_data('dimension');
    });
    function toCamelCase(str) {
        return str.substr(0, 1).toUpperCase() + str.substr(1);
    }
    $(document).on("click", ".filter_search_handler", function (e) {
        var value = $(this).parents('.input-group').find('.filter_search_box').val();
        if (value.length < 1) {
            alert_box('Please enter Product code to search');
            return false;
        }
        var filter = $(this).parents('.input-group').find('#searchtype').val();
        if (typeof filter != 'undefined' && filter == 'filter') {
            $('#index_printing').hide();
            $('#bg-index').hide();
            $('#bg-step-1').show();
            $('#start_with_printing').show();
        }
        $('.filter_search_box').val(value);
        show_loader('73', '25');
        $.ajax({
            url: base + 'ajax/search_printed_dies',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {diecode: value},
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    if (data.response == 'yes') {
                        if (data.count == 0) {
                            swal('Product not found', 'Please use scroll bar to find nearest sizes', 'warning');
                            disable_slider_option('enable');
                            $('#aa_loader').hide();
                            return false;
                        }
                        contentbox.html(data.html);
                        $('#aa_loader').hide();
                    }
                }
            }
        });
    });
    
    function disable_slider_option(method) {
        if (method == 'disabled') {
            $("#width_slider").slider("option", "disabled", true);
            $("#height_slider").slider("option", "disabled", true);
            $('#width_min').prop('disabled', true);
            $('#width_max').prop('disabled', true);
            $('#height_min').prop('disabled', true);
            $('#height_max').prop('disabled', true);
        } else {
            $("#width_slider").slider("option", "disabled", false);
            $("#height_slider").slider("option", "disabled", false);
            $('#width_min').prop('disabled', false);
            $('#width_max').prop('disabled', false);
            $('#height_min').prop('disabled', false);
            $('#height_max').prop('disabled', false);
        }
    }
    function update_width_values(min, max) {
        $("#width_slider").slider("option", "values", [min, max]);
    }
    function update_height_values(min, max) {
        $("#height_slider").slider("option", "values", [min, max]);
    }
    function update_width_range(min, max) {
        $("#width_slider").slider("option", "min", min);
        $("#width_slider").slider("option", "max", max);
    }
    function update_height_range(min, max) {
        $("#height_slider").slider("option", "min", min);
        $("#height_slider").slider("option", "max", max);
    }
    function intialize_width_slider() {
        var width_min = document.getElementById('width_min');
        var width_max = document.getElementById('width_max');
        $("#width_slider").slider({
            range: true,
            step: 1,
            slide: function (event, ui) {
                width_max.value = ui.values[1];
                width_min.value = ui.values[0];
            },
            change: function (event, ui) {
                width_max.value = ui.values[1];
                width_min.value = ui.values[0];
                var option = $("#width_slider").slider("option");
                if (option.disabled == false) {
                    filter_size_data('width', '');
                }
            }
        });
        width_min.addEventListener('change', function () {
            $("#width_slider").slider("values", 0, parseInt(this.value));
        });
        width_max.addEventListener('change', function () {
            $("#width_slider").slider("values", 1, parseInt(this.value));
        });
    }
    function intialize_height_slider() {
        var height_min = document.getElementById('height_min');
        var height_max = document.getElementById('height_max');
        $("#height_slider").slider({
            range: true,
            step: 1,
            slide: function (event, ui) {
                height_max.value = ui.values[1];
                height_min.value = ui.values[0];
            },
            change: function (event, ui) {
                height_max.value = ui.values[1];
                height_min.value = ui.values[0];
                var option = $("#height_slider").slider("option");
                if (option.disabled == false) {
                    filter_size_data('height', '');
                }
            }
        });
        height_min.addEventListener('change', function () {
            $("#height_slider").slider("values", 0, parseInt(this.value));
        });
        height_max.addEventListener('change', function () {
            $("#height_slider").slider("values", 1, parseInt(this.value));
        });
    }
    function apply_hover_effect() {
        $('.thumbnail').hover(
            function () {
                $(this).find('.zoom').slideDown(250); //.fadeIn(250)
            },
            function () {
                $(this).find('.zoom').slideUp(250); //.fadeOut(205)
            }
        );
    }
    /*$(document).on("click", ".pagination_btn", function(e) {
		var page = $(this).attr('data-value');
		show_paging(page);
});
*/
    $(document).on("click", ".pagination a", function (e) {
        var page = $(this).attr("data-page"); //get page number from link
        if (typeof page != 'undefined' && page.length > 0) {
            show_paging(page);
        }
    });
    function show_paging(start) {
        var shape = $('#shape').val();
        var height_min = $('#height_min').val();
        var height_max = $('#height_max').val();
        var width_min = $('#width_min').val();
        var width_max = $('#width_max').val();
        var total = parseInt($('#product_count').val());
        var opposite = 'false';
        if ($('#opposite_dimension').is(':checked')) {
            var opposite = 'true';
        }
        $('#aa_loader').show();
        $.ajax({
            url: base + 'ajax/printingfilters',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                shape: shape,
                email: $("#email").val(),
                width_min: width_min,
                width_max: width_max,
                height_min: height_min,
                height_max: height_max,
                opposite: opposite,
                start: start,
                count: total
            },
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    if (data.response == 'yes') {
                        $('#aa_loader').hide();
                        contentbox.html(data.html);
                        apply_hover_effect();
                        //$('[data-toggle="tooltip"]').tooltip();
                    }
                }
            }
        });
    }
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
            $('#upload_remaining_labels').val(reaming);
        }
    }
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
    $(document).on("click", ".quantity_updater", function (e) {
        verify_labels_or_rolls_qty(this);
        $(this).parents('.upload_row').find('.quantity_updater').hide();
    });
    $(document).on("click", ".quantity_editor", function (e) {
        $(this).hide();
        $(this).parents('.upload_row').find('.quantity_labels').hide();
        $(this).parents('.upload_row').find('.input_rolls').show();
    });
    $(document).on("blur", ".roll_labels_input", function (e) {
        /*var prdid = $('#cartproductid').val();
	var min_qty = parseInt($('#min_qty'+prdid).val());
	var dieacross = parseInt($('#min_rolls'+prdid).val());
	var minlabels = parseInt(min_qty/dieacross);
	var rolls = parseInt($(this).parents('.upload_row').find('.input_rolls').val());
	var total_labels = parseInt($(this).parents('.upload_row').find('.roll_labels_input').val());
	if(!is_numeric(total_labels) || total_labels == 0){
		alert_box("Minimum "+minlabels+" labels are allowed ");
	}
	if(is_numeric(rolls)){
			verify_labels_or_rolls_qty(this);
	}*/
    });
    $(document).on("blur", ".input_rolls", function (e) {
        /*var prdid = $('#cartproductid').val();
	var min_qty = parseInt($('#min_qty'+prdid).val());
	var dieacross = parseInt($('#min_rolls'+prdid).val());
	var minlabels = parseInt(min_qty/dieacross);
	var rolls = parseInt($(this).parents('.upload_row').find('.input_rolls').val());
	var total_labels = parseInt($(this).parents('.upload_row').find('.roll_labels_input').val());
	if(!is_numeric(rolls) || rolls == 0){
		alert_box("Minimum 1 roll allowed ");
	}
	if(is_numeric(total_labels)){
		verify_labels_or_rolls_qty(this);
	}*/
    });
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
    function isFloat(n) {
        return Number(n) === n && n % 1 !== 0;
    }
    $(document).on("click", ".browse_btn", function (e) {
        $(this).parents('.upload_row').find('.artwork_file').click();
    });
    $(document).on("click", ".save_artwork_file", function (e) {
        var _this = this;
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
        var file = $(_this).parents('.upload_row').find('.artwork_file').val();
        var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];
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
        if (file.length == 0) {
            alert_box("Please upload a file before saving. ");
        } else if (labels == 0 || labels == '') {
            alert_box("Please complete line ");
        } else if (artworkname.length == 0) {
            alert_box("please enter artwork name! ");
        } else {
            var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
            var form_data = new FormData();
            form_data.append("file", uploadfile)
            form_data.append("cartid", cartid);
            form_data.append("productid", prdid);
            form_data.append("labels", labels);
            form_data.append("sheets", sheets);
            form_data.append("artworkname", artworkname);
            form_data.append("persheet", labelpersheets);
            form_data.append("type", type);
            form_data.append("unitqty", cartunitqty);
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
    function upload_printing_artworks(form_data) {
        $.ajax({
            url: base + 'ajax/upload_printing_artworks',
            type: "POST",
            async: "false",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            beforeSend: function () {
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
                    if (data.sidebar != '') {
                        $('#product_summary_overview').html(data.sidebar);
                        // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        // $('#cal_btn'+prdid).click();
                    }
                    intialize_progressbar();
                    $("#upload_progress").hide();
                } else {
                    swal('upload failed', data.message, 'error');
                    intialize_progressbar();
                    $("#upload_progress").hide();
                    $('.save_artwork_file').prop('disabled', false);
                }
            }
        });
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
        var cartid = $('#cartid').val();
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
        var remaing = parseInt($('#upload_remaining_labels').val());
        var exceed = '';
        if (remaing < 0) {
            var exceed = 'yes';
        }
        $.ajax({
            url: base + 'ajax/update_printing_artworks',
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
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (!data == '') {
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                    if (data.sidebar != '') {
                        $('#product_summary_overview').html(data.sidebar);
                        var prdid = $('#cartproductid').val();
                        // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        //$('#cal_btn'+prdid).click();
                    }
                }
            }
        });
    });
    function clear_uploaded_artworks() {
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        $.ajax({
            url: base + 'ajax/update_printing_artworks',
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
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (!data == '') {
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                    if (data.sidebar != '') {
                        $('#product_summary_overview').html(data.sidebar);
                        var prdid = $('#cartproductid').val();
                        //$('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        // $('#cal_btn'+prdid).click();
                    }
                }
            }
        });
    }
    $(document).on("click", ".delete_artwork_file", function (event) {
        var id = $(this).attr('id');
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
                        url: base + 'ajax/delete_printing_artworks',
                        type: "POST",
                        async: "false",
                        dataType: "html",
                        data: {
                            fileid: id,
                            cartid: cartid,
                            prdid: prdid,
                            persheet: labelpersheets,
                            type: type,
                            unitqty: cartunitqty
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
    $(document).on("keypress keyup", ".additional_designs", function (e) {
        var val = $(this).val();
        if (is_numeric(val)) {
            $('.additional_designs_updatebtn').show();
        } else {
            $('.additional_designs_updatebtn').hide();
        }
    });
    $(document).on("click", ".additional_designs_updatebtn", function (e) {
        var designs = parseInt($('.additional_designs').val());
        update_additional_designs(designs);
    });
    $(document).on("click", ".otherdesigns_updatebtn", function (e) {
        var designs = parseInt($('#otherdesigns').val());
        update_additional_designs(designs);
    });
    $(document).on("change", "#otherdesigns", function (e) {
        $('.otherdesigns_updatebtn').show();
    });
    $(document).on("click", "#pressproof", function (e) {
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
        update_additional_designs('nodesign');
        //$('.roll_sheets_block').find('.cal_btn').click();
    });
    function update_additional_designs(designs) {
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var upload_option = $('input[name=upload_option]:checked').val();
        var pressproof = $('#pressproof').val();
        var cartunitqty = $('#cartunitqty').val();
        //otherdesigns_updatebtn
        if (designs > 0 || designs == 'nodesign') {
            if (designs == 'nodesign') {
                designs = 0;
            }
            $.ajax({
                url: base + 'ajax/update_additional_designs',
                type: "POST",
                async: "false",
                dataType: "html",
                data: {
                    cartid: cartid,
                    prdid: prdid,
                    persheet: labelpersheets,
                    designs: designs,
                    type: type,
                    upload_option: upload_option,
                    pressproof: pressproof,
                    unitqty: cartunitqty,
                },
                success: function (data) {
                    data = $.parseJSON(data);
                    if (!data == '') {
                        if (data.content != '') {
                            $('#product_summary_overview').html(data.content);
                            var prdid = $('#cartproductid').val();
                            //$('#design_qty_'+prdid).val(parseInt(data.design));
                            // $('#cal_btn'+prdid).click();
                            $('.additional_designs_updatebtn').hide();
                            $('.otherdesigns_updatebtn').hide();
                            $('.additional_designs').val('');
                            $('#otherdesigns').val('');
                        }
                    }
                }
            });
        } else {
            alert_box("please enter number of additional designs! ");
        }
    }
    function is_numeric(mixed_var) {
        var whitespace =
            " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
        return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
            1)) && mixed_var !== '' && !isNaN(mixed_var);
    }
    $(document).on("click", ".desingservice_btn", function (e) {
        $('#desingservice_artwork_file').click();
    });
    $(document).on("click", ".proceed_to_checkout", function (e) {
        var prdid = $('#cartproductid').val();
        var upload_option = $('input[name=upload_option]:checked').val();
        var type = $('#producttype' + prdid).val();
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
                var summary_price = $('#summary_price').text();
                var artwork_text = actual_designs + ' Artworks uploaded\n';
                var total_price_text = "Total £" + summary_price + "\n <?=vatoption?>. VAT\n";
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
    function update_cart_with_upload() {
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        show_loader('80', '27');
        $.ajax({
            url: base + 'ajax/update_cart_with_upload',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                cartid: cartid,
                prdid: prdid,
                persheet: labelpersheets,
                type: type,
                unitqty: cartunitqty
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    $('#product_summary_overview').html(data.sidebar);
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                }
                $('#aa_loader').hide();
            }
        });
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
        var upload_option = $('input[name=upload_option]:checked').val();
        var form_data = new FormData();
        form_data.append("cartid", cartid)
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
            url: base + 'ajax/add_printing_tocart',
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
                    $('#aa_loader').hide();
                    checkoutconfirm = true;
                    window.location.href = '<?=SAURL?>transactionregistration.php';
                }
            }
        });
    }
    function ecommerce_add_to_cart() {
        <? if(SITE_MODE == 'live'){ ?>
        var prdid = $('#cartproductid').val();
        var quantity = parseInt($('#sheet_qty_' + prdid).val());
        var type = $('#producttype' + prdid).val();
        var price = parseFloat($('#summary_price').text());
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
    /*window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (checkoutconfirm) {
            return undefined;
        }
        var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';
        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
    });
};*/
    function readURL(input) {
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
    $(document).on("change", ".artwork_file", function (e) {
        readURL(this);
    });
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
    $(document).on("click", ".a4_sheets_block .calculation_unit li a", function (e) {
        var id_array = $('.a4_sheets_block').find('.display_sheets').attr('id').split('_');
        var id = id_array[2];
        var labelspersheet = $('#labels_p_sheet' + id).val();
        var selText = $(this).text();
        if (selText == 'Labels') {
            $('.a4_sheets_block').find('.display_sheets').attr('placeholder', 'Minimum ' + parseInt(labelspersheet * 25));
            //$('.a4_sheets_block').find('.oQty').html('Minimum '+parseInt(labelspersheet*25)+' Labels');
            $('#calculation_unit' + id).val('labels');
        } else {
            $('.a4_sheets_block').find('.display_sheets').attr('placeholder', 'Minimum 25 ');
            // $('.a4_sheets_block').find('.oQty').html('Minimum 25 Sheets');
            $('#calculation_unit' + id).val('sheets');
        }
        $(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
        $('.a4_sheets_block').find('.display_sheets').val('');
        $('.a4_sheets_block').find('.display_sheets').focus();
    });
    
    
    $('.preferences').on('show.bs.modal', function (e) {
        if (preferences.cat_desc_a4 != null || preferences.cat_desc_a4 != '') {
            $("#a4_block").find('.pr-title').html(preferences.cat_desc_a4)
        }
        if (preferences.cat_desc_roll != null || preferences.cat_desc_roll != '') {
            $("#roll_block").find('.pr-title').html(preferences.cat_desc_roll)
        }
        if (preferences.available_in != null && preferences.available_in == "A4") {
            $("#a4_block").show();
            $("#roll_block").hide();
        } else if (preferences.available_in != null && preferences.available_in == "both") {
            $("#a4_block").show();
            $("#roll_block").show();
        } else if (preferences.available_in != null && preferences.available_in == "Roll") {
            $("#a4_block").hide();
            $("#roll_block").show();
        } else if (preferences.available_in == null || preferences.available_in == '') {
            $("#a4_block").hide();
            $("#roll_block").hide();
        }
        $.each(preferences, function (key, value) {
            $('.preferences').find('.' + key).html(value);
        });
        if (preferences.productcode_a4 == '' || preferences.productcode_a4 == null) {
            $("#a4_block").find('.productcode_a4').html(preferences.categorycode_a4);
        }
        if (preferences.productcode_roll == '' || preferences.productcode_roll == null) {
            $("#roll_block").find('.productcode_roll').html(preferences.categorycode_roll);
        }
        var img_a4 = '<?=Assets?>images/categoryimages/A4Sheets/' + preferences.categorycode_a4 + '.png';
        //var img_roll = '<?=Assets?>images/categoryimages/roll_desc/'+preferences.categorycode_roll+'.jpg';
        if (preferences.category_code_roll != null) {
            var codee = preferences.categorycode_roll.slice(0, -2);
        } else {
            var codee = preferences.categorycode_roll;
        }
        var img_roll = '<?=Assets?>images/categoryimages/RollLabels/outside/' + codee + 'WTP1.jpg';
        $("#a4_block img").attr("src", img_a4);
        $("#roll_block img").attr("src", img_roll);
        if (preferences.labels_roll != null) {
            $(".labels_roll").append(" Labels");
        }
        if (preferences.labels_a4 != null) {
            var persheet = parseInt(preferences.categorycode_a4.replace(/[^\d.]/g, ''));
            var sheets = Math.ceil(preferences.labels_a4 / persheet);
            $('.preferences').find('.sheets_a4').html(sheets).append(" Sheets ");
            $('.preferences').find('.labels_a4').prepend("(").append(" Labels)")
        }
        if (preferences.productcode_roll != '' || preferences.productcode_roll != null) {
            var img_roll = '<?=Assets?>images/categoryimages/RollLabels/outside/' + preferences.productcode_roll + '.jpg';
            $("#roll_block img").attr("src", img_roll);
        }
        if (preferences.coresize == "R1") {
            $("#roll_block").find('.coresize').html("1'' (25mm)");
        } else if (preferences.coresize == "R2") {
            $("#roll_block").find('.coresize').html("1½'' (38mm)");
        } else if (preferences.coresize == "R3") {
            $("#roll_block").find('.coresize').html("1¾'' (44.5mm)");
        } else if (preferences.coresize == "R4") {
            $("#roll_block").find('.coresize').html("3'' (76mm)");
        }
        if (preferences.orientation != null) {
            var orient = parseInt(preferences.orientation.replace(/[^\d.]/g, ''));
            var orientation = "Orientation 0" + orient;
            $("#roll_block").find('.orientation').html(orientation);
        }
        if ($("#a4_block").css("display") == 'none') {
            $("#roll_block").removeClass('m-t-60');
        }
    });


    
    
    $(document).on("click", ".reject_pref", function (e) {
        reset_preferences($('#email').val());
        var shape = $('#shape_sel').val();
        if (shape == '') {
            shape = 'Rectangle';
        }
        $('#index_printing').hide();
        $('#bg-index').hide();
        $('#bg-step-1').show();
        $('#start_with_printing').show();
        $('.btn_shape').removeClass('active');
        $('[data-val="' + shape + '"]').addClass('active');
        $('#shape').val(shape);
        filter_size_data('shape');
        $('.preferences').modal('hide');
    });
    
    function reset_preferences(email) {
        $.ajax({
            url: base + 'ajax/reset_preferences',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                email: email
            },
            success: function (data) {
            }
        });
    }
    $(document).ready(function (e) {
        <?php
        $shape_sel = ucwords($this->uri->segment(2));
        if(isset($shape_sel) and $shape_sel != "")
        {
        if ($shape_sel == "Anti-tamper") {
            $shape_sel = "Anti-Tamper";
        }
        ?>
        intialize_width_slider();
        intialize_height_slider();
        <?php if(in_array($shape_sel, $shapes_plain)):?>
        $("#shape_sel").val('<?=$shape_sel?>');
        $("#shape").val('<?=$shape_sel?>');
        $('.prLbMatTabs').find('.get_started_btn').click();
        $(".btn_shape").removeClass("active");
        $(".btn_shape[data-val='<?=$shape_sel?>']").addClass("active");
        history.pushState(null, null, '<?=base_url()?>printed-labels/<?=strtolower($shape_sel)?>');
        <?php else:?>
        history.pushState(null, null, '<?=base_url()?>printed-labels/');
        <?php endif;?>
        <?php
        }
        ?>
    });
    function remarketting_trigger_step(step) {
        <? if(SITE_MODE == 'live'){ ?>
        step = step + 1;
        if (step < 6) {
            var page_name = '';
            if (step == 2) {
                page_name = 'shape-and-size/';
            } else if (step == 3) {
                page_name = 'material-and-finish/';
            } else if (step == 4) {
                page_name = 'quantity-and-prices/';
            } else if (step == 5) {
                page_name = 'upload-artworks/';
            }
            if (page_name != '') {
                <?php if ($shape_sel != '') {
                if (in_array($shape_sel, $shapes_plain)) {
                    $shapeURL = strtolower($shape_sel) . '/';
                } else {
                    $shapeURL = '';
                }
            }
                ?>
                history.pushState(null, null, '<?=base_url()?>printed-labels/<?=$shapeURL?>' + page_name);
            }
            dataLayer.push({'event': 'printedlabels', 'step': step});
        }
        <?  } ?>
    }


















    // NEW MATERIAL PAGE DESIGNING STARTS FROM HERE

    var preferences = "";
    $(document).ready(function (e) {
        check_prefs($("#email").val());
    });
    function check_prefs(email)
    {
        $.ajax({
            url: base + 'ajax/load_preferences',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {email: email},
            success: function (data) {
                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    preferences = data.preferences;
                    if (data.preferences.selected_size == null) {
                        return false;
                    }
                    apply_preferences(preferences);
                    activate_steps(2);

                }
            }
        });
    }

    $(document).on("click", ".get_started_btn", function (e) {
        remarketting_trigger_step(1);
        $('#index_printing').hide();
        $('#bg-index').hide();
        $('#bg-step-1').show();
        $('#start_with_printing').show();
        filter_size_data('shape');
    });

    function apply_preferences(data) {
        var shape = data.shape;
        $('#index_printing').hide();
        $('#bg-index').hide();
        $('#bg-step-1').show();
        $('#start_with_printing').show();
        $('.btn_shape').removeClass('active');
        $('[data-val="' + shape + '"]').addClass('active');
        $('#shape').val(shape);
        filter_size_data('shape');
        if (data.selected_size == null) {
            filter_size_data('shape');
        } else {
            $("#category_id").val(data.selected_size);
            $("#available_in").val(data.available_in);
            select_size('not_button');
            activate_steps(2);
            $("#aa_loader").show();
            setTimeout(function () {
                if (data.material_a4 != '' && data.material_a4 != null) {
                    $("#a4_material_selection input[name='material']").val(data.material_a4);
                    $("#a4_material_selection .material-d-down a:first").html(data.material_a4 + "<i class='fa fa-unsorted'>");
                    $("#a4_material_selection .material-d-down li a[data-value='" + data.material_a4 + "']").trigger("click");
                    $('.a4_material_selection').find('span[name="material_text"]').html(data.material_a4);
                }
                if (data.color_a4 != '' && data.color_a4 != null) {
                    $("#a4_material_selection input[name='color']").val(data.color_a4);
                    $("#a4_material_selection .color-d-down a:first").html(data.color_a4 + "<i class='fa fa-unsorted'>");
                    $("#a4_material_selection .color-d-down li a[data-value='" + data.color_a4 + "']").trigger("click");
                    $('.a4_material_selection').find('span[name="color_text"]').html(data.color_a4);
                }
                if (data.adhesive_a4 != '' && data.adhesive_a4 != null) {
                    $("#a4_material_selection input[name='adhesive']").val(data.adhesive_a4);
                    $("#a4_material_selection .adhesive-d-down a:first").html(data.adhesive_a4 + "<i class='fa fa-unsorted'>");
                    $("#a4_material_selection .adhesive-d-down li a[data-value='" + data.adhesive_a4 + "']").trigger("click");
                    $('.a4_material_selection').find('span[name="adhesive_text"]').html(data.adhesive_a4);
                }
                if (data.digital_proccess_a4 != '' && data.digital_proccess_a4 != null) {
                    $("#a4_material_selection input[name='digital']").val(data.digital_proccess_a4);
                    $("#a4_material_selection .digital_proccess-d-down a:first").html(data.digital_proccess_a4 + "<i class='fa fa-unsorted'>");
                    $("#a4_material_selection .digital_proccess-d-down li a[data-value='" + data.digital_proccess_a4 + "']").trigger("click");
                    $('.a4_material_selection').find('span[name="digital_proccess_text"]').html(data.digital_proccess_a4);
                }
                if (data.color_roll != '' && data.color_roll != null) {
                    $("#roll_material_selection input[name='color']").val(data.color_roll);
                    $("#roll_material_selection .color-d-down a:first").html(data.color_roll + "<i class='fa fa-unsorted'>");
                    $("#roll_material_selection .color-d-down li a[data-value='" + data.color_roll + "']").trigger("click");
                    $('.roll_material_selection').find('span[name="color_text"]').html(data.color_roll);
                }
                if (data.finish_roll != '' && data.finish_roll != null) {
                    $("#roll_material_selection select").val(data.finish_roll);
                    $('.roll_material_selection').find('span[name="finish_text"]').html(data.finish_roll);
                }
                if (data.material_roll != '' && data.material_roll != null) {
                    $("#roll_material_selection input[name='material']").val(data.material_roll);
                    $("#roll_material_selection .material-d-down a:first").html(data.material_roll + "<i class='fa fa-unsorted'>");
                    $("#roll_material_selection .material-d-down li a[data-value='" + data.material_roll + "']").trigger("click");
                    $('.roll_material_selection').find('span[name="material_text"]').html(data.material_roll);
                }
                if (data.adhesive_roll != '' && data.adhesive_roll != null) {
                    $("#roll_material_selection input[name='adhesive']").val(data.adhesive_roll);
                    $("#roll_material_selection .adhesive-d-down a:first").html(data.adhesive_roll + "<i class='fa fa-unsorted'>");
                    $("#roll_material_selection .adhesive-d-down li a[data-value='" + data.adhesive_roll + "']").trigger("click");
                    $('.roll_material_selection').find('span[name="adhesive_text"]').html(data.adhesive_roll);
                }
                if (data.digital_proccess_roll != '' && data.digital_proccess_roll != null) {
                    $("#roll_material_selection input[name='digital']").val(data.digital_proccess_roll);
                    $("#roll_material_selection .digital_proccess-d-down a:first").html(data.digital_proccess_roll + "<i class='fa fa-unsorted'>");
                    $("#roll_material_selection .digital_proccess-d-down li a[data-value='" + data.digital_proccess_roll + "']").trigger("click");
                    $('.roll_material_selection').find('span[name="digital_proccess_text"]').html(data.digital_proccess_roll);
                }
                $("#ab_loader").hide();
            }, 1000);
            //if((data.available_in == 'both' && (data.productcode_roll != '' || data.labels_roll != null) && data.productcode_a4 != '') && (data.orientation != null || data.coresize != null || data.wound_roll != null) || data.labels_a4 != null)
            if (data.available_in == 'both') {
                if ((data.productcode_a4 == '' || data.productcode_a4 == null) && (data.productcode_roll == '' || data.productcode_roll == null)) {
                    return false;
                }
            } else if (data.available_in == 'Roll') {
                if (data.productcode_roll == '' || data.productcode_roll == null) {
                    return false;
                }
            } else {
                if (data.productcode_a4 == '' || data.productcode_a4 == null) {
                    return false;
                }
            }
            setTimeout(function () {
                $("#ab_loader").show();
                //$(".step-forward[data-value='3']").trigger("click");
                get_actual_products();
                //activate_steps(3);
                //$('#Printing_Step_3').show();
            }, 1500);
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
            setTimeout(function () {
                //if(data.labels_roll != null)
                //{
                $(".roll_sheets_block .display_sheets").val(data.labels_roll);
                //$(".roll_sheets_block .cal_btn").trigger("click");
                //}
                //if(data.labels_a4 != null)
                //{
                var persheet = parseInt($(".a4_sheets_block .caption h2").text());
                var sheets = Math.ceil(data.labels_a4 / persheet);
                $(".a4_sheets_block .input-quantities").val(sheets);
                //$(".a4_sheets_block .cal_sheet").trigger("click");
                //}
                $("#ab_loader").hide();
            }, 6000);
            /*if((data.available_in == 'both' && ) || (data.available_in != 'both' && (data.productcode_a4 != '' || data.productcode_roll != '')))
        {
        }*/
        }
    }

    function filter_size_data(trigger) {
        if (trigger == 'shape') {
            $('#height_min').val('');
            $('#height_max').val('');
            $('#width_min').val('');
            $('#width_max').val('');
            $('#ajax_model_desc').html('');
            $('#width_box_text').html(' Label Width <small>(mm)</small>');
            $('#height_box').css('visibility', '');
        }
        var shape = $('#shape').val();
        shape = toCamelCase(shape);
        if (shape == 'Circular' || shape == 'Square') {
            if (shape == 'Circular') {
                $('#width_box_text').html('Label Diameter <small>(mm)</small>');
            } else {
                $('#width_box_text').html('Label Width <small>(mm)</small>');
            }
            $('#height_box').css('visibility', 'hidden');
        } else {
            $('#height_box').css('visibility', '');
            $('#width_box_text').html('Label Width <small>(mm)</small>');
        }
        var height_min = $('#height_min').val();
        var height_max = $('#height_max').val();
        var width_min = $('#width_min').val();
        var width_max = $('#width_max').val();
        if (trigger == 'shape') {
            height_min = '';
            height_max = '';
            width_min = '';
            width_max = '';
        }
        var opposite = 'false';
        if ($('#opposite_dimension').is(':checked')) {
            var opposite = 'true';
        }
        if (shape.length < 1) {
            alert_box('Please select label shape first ');
        } else {
            $('.filter_search_box').val('');
            // disable_slider_option('disabled');
            $('#shapes_box').find('.btn_shape').prop('disabled', true);
            //$('#aa_loader').show();
            show_loader('73', '25');
            var request = $.ajax({
                url: base + 'ajax/printingfilters',
                type: "POST",
                async: "false",
                dataType: "html",
                data: {
                    shape: shape,
                    email: $("#email").val(),
                    width_min: width_min,
                    width_max: width_max,
                    height_min: height_min,
                    height_max: height_max,
                    opposite: opposite
                },
                success: function (data) {
                    if (!data == '') {
                        $('#shapes_box').find('.btn_shape').prop('disabled', false);
                        data = $.parseJSON(data);
                        if (data.response == 'yes') {
                            if (data.count == 0 && (trigger != 'shape')) {
                                swal('Label size not available', 'Please readjust scroll bar to find nearest sizes', 'warning');
                                // disable_slider_option('enable');
                                $('#aa_loader').hide();
                                return false;
                            }
                            $('#start_limit').val(0);
                            contentbox.html(data.html);
                            if (trigger == 'shape') {
                                if (shape == 'Circular' || shape == 'Square') {
                                    if (trigger != 'width') {
                                        if (data.min_width && data.max_width) {
                                            update_width_range(parseFloat(data.min_width), parseFloat(data.max_width));
                                            update_width_values(parseFloat(data.min_width), parseFloat(data.max_width));
                                        }
                                    }
                                } else {
                                    if (trigger != 'width') {
                                        if (data.min_width && data.max_width) {
                                            update_width_range(parseFloat(data.min_width), parseFloat(data.max_width));
                                            update_width_values(parseFloat(data.min_width), parseFloat(data.max_width));
                                        }
                                    }
                                    if (trigger != 'height') {
                                        if (data.min_height && data.max_height) {
                                            update_height_range(parseFloat(data.min_height), parseFloat(data.max_height));
                                            update_height_values(parseFloat(data.min_height), parseFloat(data.max_height));
                                        }
                                    }
                                }
                            }
                            $('#product_count').val(data.count)
                            // disable_slider_option('enable');
                            apply_hover_effect();
                            //$('[data-toggle="tooltip"]').tooltip();
                            $('#aa_loader').hide();
                        }
                    }
                }
            });
        }
    }


</script> 
