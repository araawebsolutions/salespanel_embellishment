<?php
//
//  if($this->router->fetch_method() == 'getOrderDetail'){
//      echo 'do';exit;
//  }else{
//      echo 'dfd';exit;
//  }
//$this->session->set_userdata('session_id', session_id());
// $this->session->set_userdata('UserTypeID','88');


$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

$ab = 1;
$cd = 2;


if( $this->session->userdata('login_ip') != $_SERVER['REMOTE_ADDR'] && $segment1!='Auth' && $segment2!='AuthenticateUser' ){

    $this->session->set_userdata('login_ip',$_SERVER['REMOTE_ADDR']);

    $this->session->set_userdata('ip_address',$_SERVER['REMOTE_ADDR']);

    $this->session->unset_userdata('UserName');

    $this->session->unset_userdata('UserID');

    $this->session->unset_userdata('OPERATOR_AA');

    $this->session->unset_userdata('SALE_ID');

    $this->session->unset_userdata('UserTypeID');

    $this->session->unset_userdata('login_user_id');

    return redirect('index.php/Auth');
}

if ($this->session->userdata('login_user_id') == null || $this->session->userdata('login_user_id') == "") {
    return redirect('index.php/Auth');
}



//$this->session->set_userdata('login_user_id', '616100');
//$this->session->set_userdata('UserName', 'test');
//$this->session->set_userdata('session_id', 'k0brk5nbl7qq266c9thccvhcuqkmhju9');
//$this->session->unset_userdata('session_id');
//echo ;exit;
//echo CI_VERSION ;exit;
//echo  $this->session->userdata('session_id');exit;
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>AA Back Office | Plain and Printed Labels to Buy Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://www.aalabels.com/theme/site/images/favicon.png"/>
    <!-- Main css -->
    <link href="<?= ASSETS ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ASSETS ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ASSETS ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
    <!-- DataTables -->
    <link href="<?= ASSETS ?>assets/js/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="<?= ASSETS ?>assets/js/datatable/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <!-- Spinkit css -->
    <link href="<?= ASSETS ?>assets/css/spinkit.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ASSETS ?>assets/css/slider.css" rel="stylesheet" type="text/css"/>
    <script src="<?= ASSETS ?>assets/js/jquery.min.js"></script>
    <script src="<?= ASSETS ?>assets/js/sweet-alert.js"></script>
    <!-- Search js and css -->
    <link href="<?= ASSETS ?>assets/css/label-finder.css" rel="stylesheet">
    <script src="<?= ASSETS ?>assets/js/jquery-ui.js"></script>
    <link href="<?= ASSETS ?>assets/css/datepicker.css" rel="stylesheet" type="text/css"/>



</head>
<style>
    .swal-button--confirm {
        background-color: #17b1e3;
    }

    .swal-button--cancel {
        background-color: #fd4913;
    }
</style>
<script>
    var mainUrl = "<?php echo main_url?>";
    var symbel = "<?php echo symbol?>";

    function imgError(image) {
        image.onerror = "";
        image.src = "<?php echo Assets; ?>images/place-holder.jpg";
        width = image.clientWidth;
        if(width == '208')
        {
            image.clientWidth = 130;
        }
        return true;
    }
</script>

<!-- Loader Start -->
<div class="loader" style="display: none">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<!-- Loader End -->


<div id="aa_loader" class="white-screen" style="display:none ;position: fixed;  z-index: 2; left: 42%; right: 40%; top:50%">
    <div class="loading-gif text-center" style="z-index: 1;padding-top: 0;">
        <img src="https://www.aalabels.com/theme/site/images/loader.gif" class="image" style="width:160px; height:43px; "></div>
</div>

<!--<script>-->
<!--    $(window).on("load", function() {-->
<!--        $('.loader').show();-->
<!--    });-->
<!--</script>-->
<!-- Navigation Bar-->
<?php

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$is_dashboard = false;
$is_enquiry = false;
$is_follow = false;
$is_qout = false;
$is_order = false;
$is_order_setting = false;
$is_add_order = false;
$is_artwork = false;
$is_artRejected = false;

$is_active = false;
$is_return = false;
$is_credit_note = false;
$is_account = false;
$is_fcOrders = false;
$is_vat_ex_or = false;
$is_pay_sales = false;

$is_active_dies = false;
$is_process_dies = false;

$is_new_follow = false;

@$result = explode('index.php', rtrim($actual_link, '/'));
@$part2 = @$result[1];


if (@$part2 == "") {
    $is_dashboard = true;
}

if (strpos($actual_link, 'enquiry') !== false) {
    $is_enquiry = true;
}
if (strpos($actual_link, 'addEnquiry') !== false) {
    $is_enquiry = true;
}

if (strpos($actual_link, 'follow') !== false) {
    $is_follow = true;
}

if (strpos($actual_link, 'followups') !== false) {
    $is_new_follow = true;

    $is_follow = false;
}


if (strpos($actual_link = str_replace("/", "_", $actual_link), 'quotation_quotation') !== false) {
    $is_qout = true;
}
if (strpos($actual_link, 'orderDetailList') !== false || strpos($actual_link, 'getOrderDetail') !== false) {
    $is_order = true;
}
if (strpos($actual_link, 'orderSetting') !== false) {
    $is_order_setting = true;
}
if (strpos($actual_link, 'orderQuotationPage') !== false) {
    $is_add_order = true;
}


if (strpos($actual_link, 'Artworks') !== false) {
    $is_artwork = true;
}
if (strpos($actual_link, 'rejectedArtwork') !== false) {
    $is_artRejected = true;
}

if (strpos($actual_link, 'tickets') !== false) {
    $is_active = true;
}
if (strpos($actual_link, 'returns') !== false) {
    $is_return = true;
}
if (strpos($actual_link, 'updateTicket') !== false) {
    $is_return = true;
}
if (strpos($actual_link, 'creditNotes') !== false) {
    $is_credit_note = true;
}

if (strpos($actual_link, 'credit_accounts') !== false) {
    $is_account = true;
}
if (strpos($actual_link, 'foreign_currency_orders') !== false) {
    $is_fcOrders = true;
    $is_account = true;
}
if (strpos($actual_link, 'vat_exempt_orders') !== false) {
    $is_vat_ex_or = true;
    $is_account = true;
}
if (strpos($actual_link, 'payment_sales_audit') !== false) {
    $is_pay_sales = true;
    $is_account = true;
}


if (@end(@$this->uri->segment_array()) == "dies") {
    $is_active_dies = true;
}

if (@end(@$this->uri->segment_array()) == "process_dies") {
    $is_process_dies = true;
}

$is_invoice = false;

if (strpos($actual_link, 'invoice') !== false) {
    $is_invoice = true;
}

?>

<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="logo"><a href="<?= main_url ?>Dashboard" class="logo">
                            <img src="<?= ASSETS ?>assets/images/logo_sm.png" alt="" class="logo-small">
                            <img src="<?= ASSETS ?>assets/images/logo.png" alt="" class="logo-large"> </a></div>
                </div>
                <!-- End Logo container-->
                <!-- Time & Date Container Start -->
                <div class="col-md-4 mobile-hidden-special-class">
                    <div class="logo clock-adjst"><i class="mdi mdi-clock white-color"></i></div>
                    <div class="logo time-date"> <span class="month-date"><?= date('l jS F Y') ?><br>
                    </span> <span class="real-time" id="timer"></span></div>
                </div>
                <!-- Time & Date Container Ends -->
                <div class="menu-extras topbar-custom col-md-5 mobile-width-special-class">
                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
                        <li class="menu-item">
                        </li>
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                               role="button" aria-haspopup="false" aria-expanded="false">
                                <i class=" icon-docs file-icon"></i> <span class="ml-1 pro-user-name">Knowledge Resource <i
                                            class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                                <div class="slimscroll pdf-scroller">
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=inbound_enquiry"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">In Pathway</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=outbound"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Out Pathway</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=printed_roll_pathway"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Printed Rolls</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=outbound_delivery_problem"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Delivery Pathway</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=email_spec"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Email Specification</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=label_faq"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Label FAQ's</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=thermal_labels"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Thermal Labels</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=artwork_checklist_customer"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Artwork Preparation Checklist
                                            Customer</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=artwork_checklist_Internal"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Artwork Preparation Checklist
                                            Internal</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=sheet_sizes"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Paper Sizes</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=epson_sure_press"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Datasheet for the Epson Sure
                                            Press</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=surface_energy_bonding"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">The Effect Surface Energy on Bonding
                                            Properties</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=labelling_guidance"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">FSA Food Labelling Guidelines
                                            2008</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=labelling_regulations"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">The Food Labelling Regulations
                                            1996</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=iso_certificates"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">ISO Certificates</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=customer_care_knowledge"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Customer Care Knowledge Resource</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=regulations_for_labeling"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Regulations for labeling hazardous
                                            goods</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=chemical_labels"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Chemical labels are changing</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=bartender_guide"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Bartender Seagull Scientific User
                                            Guide</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=Illustrator_guide"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Adobe Illustrator CS3 User Guide</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=photoshop_guide"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Adobe Photoshop Reference Guide</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=InDesign_guide"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Adobe InDesign Reference Guide</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=coreldraw_guide"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Corel Draw 2017 Reference Guide</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=serif_guide"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Serif PagePlusx6 UK Reference
                                            Guide</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=hP_indigo_ws6800_press"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">HP Indigo WS6800 Press</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=versant_180"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Xerox Versant 180</p>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= main_url ?>Dashboard/knowledgeResource?name=organic_logo-faq_en"
                                       class="dropdown-item notify-item">
                                        <p class="text-muted font-13 mb-0 user-msg">Organic Logo FAQ English</p>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#"
                               role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fa fa-user-circle-o file-icon"></i> <span
                                        class="ml-1 pro-user-name">Welcome <?= $this->session->userdata('UserName') ?>
                                    <i
                                            class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item"> <i class="fi-head"></i>
                                    <span>My Account</span> </a>
                                <!-- item-->
                                <a href="<?= main_url ?>Auth/logout" class="dropdown-item notify-item">
                                    <i class="fi-power"></i> <span>Logout</span> </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- end menu-extras -->
                <div class="clearfix"></div>
            </div>
            <!-- end container -->
        </div>
    </div>
    <!-- end topbar-main -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->







                <? if($this->session->userdata('UserTypeID') == 23){?>



                    <ul class="navigation-menu">
                        <li class="has-submenu text-center main-menu-text active">
                            <a href="<?= main_url ?>Artworks"><i class=" mdi mdi-grease-pencil"></i>
                                <p>ARTWORK</p>
                            </a>
                        </li>
                        <li class="has-submenu text-center main-menu-text <?php if ($is_active_dies == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>orderDetailList"><i class="fa fa-dot-circle-o fa-2x"></i>
                                <p>ORDERS</p>
                            </a>
                        </li>

                    </ul>






                <? } else if ($this->session->userdata('UserTypeID') == 88) { ?>

                    <ul class="navigation-menu">
                        <li class="has-submenu text-center main-menu-text active">
                            <a href="<?= main_url ?>Artworks"><i class=" mdi mdi-grease-pencil"></i>
                                <p>ARTWORK</p>
                            </a>
                        </li>
                        <li class="has-submenu text-center main-menu-text <?php if ($is_active_dies == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>dies"><i class="fa fa-dot-circle-o fa-2x"></i>
                                <p>ACTIVE DIES</p>
                            </a>
                        </li>

                    </ul>




                <? } else if ($this->session->userdata('UserTypeID') == 22) { ?>

                    <ul class="navigation-menu">

                        <li class="has-submenu text-center main-menu-text <?php if ($is_active_dies == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>dies"><i class="fa fa-dot-circle-o fa-2x"></i>
                                <p>ACTIVE DIES</p>
                            </a>
                        </li>

                    </ul>



                <?php } else { ?>


                    <ul class="navigation-menu">
                        <li class="has-submenu text-center main-menu-text <?php if ($is_dashboard == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>Dashboard"><i class="icon-speedometer"></i>
                                <p>DASHBOARD </p>
                            </a></li>
                        <li class="has-submenu text-center main-menu-text <?php if ($is_enquiry == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>enquiry/Enquiry"><i class="mdi mdi-headset"></i>
                                <p>ENQUIRIES </p>
                            </a></li>
                        <li class="has-submenu text-center main-menu-text <?php if ($is_follow == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>follow/Followup/"><i class="mdi mdi-account"></i>
                                <p>FOLLOW UPS </p>
                            </a></li>
                        <li class="has-submenu text-center main-menu-text <?php if ($is_qout == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>order_quotation/quotation/index"><i class="mdi mdi-book-open"></i>
                                <p>QUOTATIONS </p>
                            </a></li>
                        <li class="has-submenu text-center main-menu-text <?php if ($is_order == true || $is_order_setting == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>orderDetailList"><i class=" mdi mdi-cart"></i>
                                <p>ORDERS </p></a>
                            <ul class="submenu">
                                <li><a class="<?php if ($is_order_setting == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>orderSetting">Amendment Setting </a></li>

                                <li><a class="<?php if ($is_invoice  == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>invoice">INVOICES</a></li>

                            </ul>
                        </li>



                        <li class="has-submenu text-center main-menu-text <?php if ($is_add_order == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>orderQuotationPage"><i class=" mdi mdi-cart-plus"></i>
                                <p>ADD ORDER / QUOTE </p>
                            </a>
                        </li>

                        <li class="has-submenu text-center main-menu-text <?php if ($is_artwork == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>Artworks"><i class=" mdi mdi-grease-pencil"></i>
                                <p>ARTWORK</p>
                            </a>
                            <ul class="submenu">
                                <li><a class="<?php if ($is_order_setting == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>Artworks/rejected">REJECTED ARTWORK</a></li>


                            </ul>
                        </li>


                        <li class="has-submenu text-center main-menu-text <?php if ($is_active == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>tickets/returns"><i class=" mdi mdi-grease-pencil"></i>
                                <p>RETURN / COMPLAINTS</p>
                            </a>
                            <ul class="submenu">
                                <li><a class="<?php if ($is_credit_note == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>tickets/creditNotes">CREDIT NOTE</a></li>


                            </ul>
                        </li>


                        <li class="has-submenu text-center main-menu-text <?php if ($is_account == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>credit_accounts"><i class=" mdi mdi-grease-pencil"></i>
                                <p>ACCOUNTS</p>
                            </a>

                            <ul class="submenu">
                                <li><a class="<?php if ($is_fcOrders == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>foreign_currency_orders"> FOREIGN CURRENCY ORDERS </a>
                                </li>

                                <li><a class="<?php if ($is_vat_ex_or == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>vat_exempt_orders"> VAT EXEMPT ORDERS </a></li>

                                <li>
                                    <a class="<?php if ($is_account == true && $is_vat_ex_or == false && $is_fcOrders == false && $is_pay_sales == false) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>credit_accounts"> CREDIT ACCOUNTS </a></li>

                                <li><a class="<?php if ($is_pay_sales == true) {
                                        echo 'bset';
                                    } else {
                                        echo 'bunset';
                                    } ?>" href="<?= main_url ?>payment_sales_audit"> PAYMENT SALES AUDIT </a></li>
                            </ul>

                        </li>

                        <li class="has-submenu text-center main-menu-text <?php if ($is_active_dies == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>dies"><i class="fa fa-dot-circle-o fa-2x"></i>
                                <p>ACTIVE DIES</p>
                            </a>
                        </li>

                        <li class="has-submenu text-center main-menu-text <?php if ($is_process_dies == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>dies/dies/process_dies"><i class="fa fa-dot-circle-o fa-2x"></i>
                                <p>PROCESS DIES</p>
                            </a>
                        </li>

                        <!-- <li class="has-submenu text-center main-menu-text <?php if ($is_new_follow == true) {
                            echo 'active';
                        } ?>">
                            <a href="<?= main_url ?>follow/followups"><i class="mdi mdi-account"></i>
                                <p>Follow Up Quote</p>
                            </a>
                        </li>-->

                    </ul>




                <?php } ?>
                <!-- End navigation menu -->
            </div>
            <!-- end #navigation -->
        </div>
        <!-- end container -->
    </div>
    <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->


