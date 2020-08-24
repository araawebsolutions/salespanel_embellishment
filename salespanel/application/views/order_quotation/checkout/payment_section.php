<? $currency_options = $this->cartModal->get_currecy_options();
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';
$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>
<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>

<script>(function(n,t,i,r){var u,f;n[i]=n[i]||{},n[i].initial={accountCode:"AALAB11111",host:"AALAB11111.pcapredict.com"},n[i].on=n[i].on||function(){(n[i].onq=n[i].onq||[]).push(arguments)},u=t.createElement("script"),u.async=!0,u.src=r,f=t.getElementsByTagName("script")[0],f.parentNode.insertBefore(u,f)})(window,document,"pca","//AALAB11111.pcapredict.com/js/sensor.js")</script>

<link href="<?= ASSETS ?>assets/css/checkout.css" rel="stylesheet" type="text/css"/>

<div class="wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 card" style="padding: 20px 10px;">
      <? include('cart.php'); ?>
        <!-------------------------------BILLING SECTION------------------------------------------------->

<style>
.panel-heading {
  color: #ffffff;
  background-color: #40778c !important;
}
</style>
 
<?php
$restofworld_list = $this->shopping_model->grouped_country_list('ROW');
$europeunion_list = $this->shopping_model->grouped_country_list('EUROPEAN UNION');
$europe_list = $this->shopping_model->grouped_country_list('EUROPE');

$show_newsletter = 'no';
$userid = $this->session->userdata('userid');

if (isset($userid) and $userid != '') {
    $user = $this->user_model->get_data();
    if(isset($user['UserEmail']) and $user['UserEmail'] != '') {
        $query = $this->db->query("select count(*) AS Total from email_addresses WHERE email LIKE '" . $user['UserEmail'] . "'");
        $query = $query->row_array();
        if (isset($query['Total']) and $query['Total'] > 0) {

        }
    }


    $show_pass = 'No';
    $billing_email = $user['UserEmail'];

    $BillingTitle = $user['BillingTitle'];
    $DeliveryTitle = $user['DeliveryTitle'];


    $billing_fname = ucwords($user['BillingFirstName']);
    $billing_lname = ucwords($user['BillingLastName']);
    $billing_pno = ucwords($user['BillingTelephone']);
    $billing_mno = ucwords($user['BillingMobile']);
    $billing_pcode = ucwords($user['BillingPostcode']);
    $billing_add1 = ucwords($user['BillingAddress1']);
    $billing_add2 = ucwords($user['BillingAddress2']);
    $billing_city = ucwords($user['BillingTownCity']);
    $billing_company = ucwords($user['BillingCompanyName']);
    $billing_county = ucwords($user['BillingCountyState']);
    
   $delivery_email = $user['DeliveryEmail'];
   $delivery_fname = ucwords($user['DeliveryFirstName']);
   $delivery_lname = ucwords($user['DeliveryLastName']);
   $delivery_pno = ucwords($user['DeliveryTelephone']);
   $delivery_mno = ucwords($user['DeliveryMobile']);
   $delivery_pcode = ucwords($user['DeliveryPostcode']);
   $delivery_add1 = ucwords($user['DeliveryAddress1']);
   $delivery_add2 = ucwords($user['DeliveryAddress2']);
   $delivery_city = ucwords($user['DeliveryTownCity']);
   $delivery_company = ucwords($user['DeliveryCompanyName']);
   $delivery_county = ucwords($user['DeliveryCountyState']);
   $plain_label_customer = ucwords($user['Label']);
 
 
   $country      = $user['BillingCountry'];
   $dcountry     = $user['DeliveryCountry'];
   $second_email = $user['SecondaryEmail'];
   $country      = $user['BillingCountry'];
   $second_email = $user['SecondaryEmail'];
}else {

    $show_pass = '';


    $BillingTitle = '';
    $DeliveryTitle = '';


    $billing_email = '';
    $billing_fname = '';
    $billing_lname = '';
    $billing_pno = '';
    $billing_fno = '';
    $billing_mno = '';
    $billing_pcode = '';
    $billing_add1 = '';
    $billing_add2 = '';
    $billing_city = '';
    $billing_company = '';
    $billing_county = '';
    $res_b = '';

    $delivery_email = '';
    $delivery_fname = '';
    $delivery_lname = '';
    $delivery_pno = '';
    $delivery_fno = '';
    $delivery_mno = '';
    $delivery_pcode = '';
    $delivery_add1 = '';
    $delivery_add2 = '';
    $delivery_city = '';
    $delivery_company = '';
    $delivery_county = '';
    $res_d = '';
    $country = '';
    $dcountry = '';
    $second_email = '';


}

?>
<? if (isset($error) and $error != '') {
    if (!isset($errortype)) {
        $billing_email = $this->input->post('email');
        $billing_fname = $this->input->post('b_first_name');
        $billing_lname = $this->input->post('b_last_name');
        $billing_pno = $this->input->post('b_phone_no');
        $billing_fno = $this->input->post('b_fax');
        $billing_pcode = $this->input->post('b_pcode');
        $billing_add1 = $this->input->post('b_add1');
        $billing_add2 = $this->input->post('b_add2');
        $billing_city = $this->input->post('b_city');
        $billing_company = $this->input->post('b_organization');
        $billing_county = $this->input->post('b_county');
        //$res_b = $this->input->post('b_ResCom');

        $delivery_email = $this->input->post('d_email');
        $delivery_fname = $this->input->post('d_first_name');
        $delivery_lname = $this->input->post('d_last_name');
        $delivery_pno = $this->input->post('d_phone_no');
        $delivery_company = $this->input->post('d_organization');

        $delivery_fno = $this->input->post('d_fax');
        $delivery_pcode = $this->input->post('d_pcode');
        $delivery_add1 = $this->input->post('d_add1');
        $delivery_add2 = $this->input->post('d_add2');
        $delivery_city = $this->input->post('d_city');
        $delivery_county = $this->input->post('d_county');
        //$res_d = $this->input->post('d_ResCom');

        $country = $this->input->post('country');
        $dcountry = $this->input->post('dcountry');

        $BillingTitle = $this->input->post('billing_title');
        $DeliveryTitle = $this->input->post('title_d');


        $second_email = $this->input->post('second_email');


    }
    ?>
    
<div class="col-md-12">
  <div id="validation_errors" role="alert" class="alert alert-danger alert-dismissible fade in">
    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span
                        aria-hidden="true">×</span></button>
    <? if (empty($errortype)) { ?>
    <strong>Validation error! </strong> Please fix following error.<br/>
    <? } ?>
    <?= $error ?>
  </div>
</div>
<script>$('html, body').animate({scrollTop: $("#validation_errors").offset().top - 100}, 1000);</script>
<? } ?>



<div id="payment_section">
<input type="hidden" id="isUserExist" value="<?php if ($userid != null || $userid != "") {
        echo 'yes';
    } else {
        echo 'no';
    } ?>">
    
<div>
  
  <input id="l_q_n" type="hidden">    


  <form method="post" id="checkout_form" class="labels-form " enctype="multipart/form-data" action="<?= main_url ?>cart/Cart/paymentPage">
    <ul class="nav orderStep setup-panel">
      <li class="active" id="step-1_tab"><a id="biling" href="#step-1"> <i class="fa fa-envelope f-20 p-t-b"></i>
        <p class="list-group-item-text">Billing</p>
        </a></li>
      <li class="disabled" id="step-2_tab"><a id="delive" href="#step-2"> <i class="fa fa-map-marker p-t-b f-20"></i>
        <p class="list-group-item-text">Delivery</p>
        </a></li>
      <li class="disabled" id="step-3_tab"><a id="shping" href="#step-3"> <i class="fa fa-truck p-t-b f-20"></i>
        <p class="list-group-item-text">Shipping</p>
        </a></li>
      <li class="disabled" id="step-6_tab"><a id="pay" href="#step-6"> <i class="fa fa-gbp p-t-b f-20"></i>
        <p class="list-group-item-text">Review &amp; Pay</p>
        </a></li>
      <li class="disabled" id="step_5_tab"><a id="cnf" href="#"> <i class="fa fa-check-circle p-t-b f-20"></i>
        <p class="list-group-item-text">Confirm</p>
        </a></li>
    </ul>
    
    
    
    
    
    
    <div class="setup-content" id="step-1" style="">
      <div>
        <div class="col-sm-12 p0">
          <h4 class="m-t-b-8 m-l-20 cBlue">Billing Address</h4>
        </div>
        <div class="row">
          <div class="col-sm-4 special-col-sm-4">
                        
			 <? $plain_check = ($plain_label_customer==1)?"checked":"";?>
            <div class="row" style="margin-bottom:0.5rem">
             <div class="col-md-12">
                <label class="checkbox">
                <input type="checkbox" name="plain_labels" class="textOrange" value="<?=$plain_label_customer?>" id="plain_labels" <?=$plain_check?>>
                    <i></i><span style="font-size: 13px; color: #666;">Select for Plain Label</span></label>
                </div>
                
            </div>
                        
                        
                        
            <div class="row">
                            
              <div class="col-md-4 ">
                <label class="select">
                  <select name="billing_title" id="title">
                    <option <?php if ($BillingTitle == 'Mr.') { ?> selected <?php } ?>
                                                    value="Mr."> Mr. </option>
                    <option <?php if ($BillingTitle == 'Mrs.') { ?> selected <?php } ?>
                                                    value="Mrs."> Mrs. </option>
                    <option <?php if ($BillingTitle == 'Ms.') { ?> selected <?php } ?>
                                                    value="Ms."> Ms. </option>
                    <option <?php if ($BillingTitle == 'Miss.') { ?> selected <?php } ?>
                                                    value="Miss."> Miss. </option>
                    <option <?php if ($BillingTitle == 'Dr.') { ?> selected <?php } ?>
                                                    value="Dr."> Dr. </option>
                    <option <?php if ($BillingTitle == 'Prof.') { ?> selected <?php } ?>
                                                    value="Prof."> Ms. </option>
                    <option <?php if ($BillingTitle == 'Rev.') { ?> selected <?php } ?>
                                                    value="Rev."> Rev. </option>
                  </select>
                  <i></i> </label>
              </div>
              <div class="col-md-8 m-l-12">
                <label class="input"> <i class="icon-append fa fa-user"></i>
                  <input type="text" name="b_first_name" placeholder="First Name"
                                               id="b_first_name"
                                               value="<?= $billing_fname ?>" class="required">
                  <b class="tooltip tooltip-bottom-right">Please Enter First Name</b> </label>
              </div>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-user"></i>
                <input type="text" placeholder="Last Name" name="b_last_name" id="b_last_name"
                                           value="<?= $billing_lname ?>" class="required">
                <b class="tooltip tooltip-bottom-right">Please Enter Last Name</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-phone"></i>
                <input type="text" placeholder="Phone Number" name="b_phone_no"
                                           value="<?= $billing_pno ?>" id="b_phone_no" class="required">
                <b class="tooltip tooltip-bottom-right">Please Enter Phone Number</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-phone"></i>
                <input type="text" placeholder="Mobile Number" name="b_mobile"
                                           value="<?= $billing_mno ?>" id="b_mobile">
                <b class="tooltip tooltip-bottom-right">Please Enter Mobile Number</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-user"></i>
                <input type="text" placeholder="Company Name" value="<?= $billing_company ?>"
                                           name="b_organization" id="b_organization">
                <b class="tooltip tooltip-bottom-right">Please Enter Company Name</b> </label>
            </div>
          </div>
          <div class="col-sm-4 special-col-sm-4">
            <div class="col-sm-12 ">
              <label class="select">
                <select name="country" id="country" class="required">
                  <option value="">Select Country</option>
                  <optgroup label="UK">
                  <option data-value="GB" <?= ($country == 'United Kingdom') ? 'selected="selected"' : '' ?>
                                                    value="United Kingdom">United Kingdom </option>
                  </optgroup>
                  <optgroup label="EUROPEAN UNION">
                  <? foreach ($europeunion_list as $row) {  ?>
                  <option data-value="<?= $row->c_code ?>" data-vat="EUROPEAN UNION" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                        value="<?= $row->name ?>">
                  <?= $row->name ?>
                  </option>
                  <? } ?>
                  </optgroup>
                  <optgroup label="EUROPE">
                  <? foreach ($europe_list as $row) { ?>
                  <option <?= ($country == $row->name) ? 'selected="selected"' : '' ?> data-vat="EUROPE" value="<?= $row->name ?>">
                  <?= $row->name ?>
                  </option>
                  <? } ?>
                  </optgroup>
                  <optgroup label="ROW">
                  <?  foreach ($restofworld_list as $row) { ?>
                  <option data-value="<?= $row->c_code ?>" data-vat="ROW" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                        value="<?= $row->name ?>">
                  <?= $row->name ?>
                  </option>
                  <? } ?>
                  </optgroup>
                </select>
                <i></i> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-search"></i>
                <input type="text" placeholder="Postcode" value="<?= $billing_pcode ?>" name="b_pcode" id="b_pcode" class="required is_country_sel">
                <b class="tooltip tooltip-bottom-right">Enter your postcode and select your address
                from
                the locations found, using the drop-down menu.</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="text" placeholder="Address 1" value="<?= $billing_add1 ?>"
                                           name="b_add1" id="b_add1" class="required is_country_sel">
                <b class="tooltip tooltip-bottom-right">Please Enter Address Line</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="text" placeholder="Address 2" value="<?= $billing_add2 ?>"
                                           class="is_country_sel" name="b_add2" id="b_add2">
                <b class="tooltip tooltip-bottom-right">Please Enter Address Line</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-map-marker"></i>
                <input type="text" placeholder="City/Town" value="<?= $billing_city ?>"
                                           name="b_city"
                                           id="b_city" class="required is_country_sel">
                <b class="tooltip tooltip-bottom-right">Please Enter City or Town</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-map-marker"></i>
                <input type="text" placeholder="County " class="is_country_sel"
                                           value="<?= $billing_county ?>" name="b_county" id="b_county">
                <b class="tooltip tooltip-bottom-right">Please Enter County</b> </label>
            </div>
          </div>
          <div class="col-sm-4">
            <? if ($show_pass == 'No') { ?>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="email" placeholder="Email" value="<?= $billing_email ?>"
                                               name="email_valid" id="email_valid">
                <b class="tooltip tooltip-bottom-right">Email</b> </label>
            </div>
            <? } else { ?>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="email" placeholder="Email" value="<?= $billing_email ?>"
                                               name="email"
                                               id="email">
              </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-lock"></i>
                <input type="password" placeholder="Password" id="customer_password"
                                               name="customer_password"/>
              </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-lock"></i>
                <input type="password" placeholder="Confirm Password " id="re_customer_password"
                                               name="re_customer_password"/>
              </label>
            </div>
            <? } ?>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="email" placeholder="Secondary Email" value="<?= $second_email ?>"
                                           name="second_email" id="second_email">
                <small>Please complete if a copy of the VAT invoice is required e.g. accounts dept. </small> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa fa-bank"></i>
                <input type="text" placeholder="Purchase Order Number" name="PurchaseOrderNumber"
                                           id="PurchaseOrderNumber">
              </label>
            </div>
          </div>
        </div>
        <? if ($show_newsletter == 'Yes') { ?>
        <div class="col-sm-12 ">
          <h4 class="BlueHeading m-b-10">Newsletter Sign-Up</h4>
          <label class="checkbox">
            <input type="checkbox" checked="" name="newslwtter_value" class="textOrange"
                                       id="newslwtter_value">
            <i></i>I would like to receive newsletters and information on offers and discount
            vouchers to the email address provided. In agreeing to receive communication from
            time-to-time, AA Labels assures you that your contact details will remain confidential
            and will not be shared with any third-party.</label>
        </div>
        <? } ?>
      </div>
      <div class="col-sm-12 m-t-10">
        <hr>
      </div>
      <br>
      <div class="row ">
        <div class="col-xs-12  col-sm-6 col-md-3 float-left">
          
          <a href="<?=main_url?>orderQuotationPage" class="btn-outline-info waves-light waves-effect width-select "
                               style="padding: 7px;    border: 1px solid;border-radius: 4px;"> <i class="fa fa-arrow-circle-left"></i> Back to Cart </a>
          
        </div>
        <div class="col-md-6"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 float-right">
          <button type="button" id="activate-step-2"
                                class="btn btn-outline-primary waves-light waves-effect width-select"
                                style="padding: 7px;"> Delivery
          Address <i class="fa fa-arrow-circle-right"></i></button>
        </div>
      </div>
    </div>
    
    
    
    
    <div class="setup-content" id="step-2" style="display:none ;">
      <div>
        <div class="col-sm-12 p0">
          <h4 class="m-t-b-8 m-l-20 cBlue">Delivery Address</h4>
        </div>
        <div class="">
          <div class="col-sm-12" style="margin-bottom: 10px;">
            <label class="checkbox">
              <input type="checkbox" name="delivery_val" class="textOrange" id="delivery_val">
              <i></i>Auto Fill Same as Billing Address? </label>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 special-col-sm-4">
            <div class="row">
              <div class="col-md-4">
                <label class="select">
                  <select name="title_d" id="title_d">
                    <option <?php if ($DeliveryTitle == 'Mr.') { ?> selected <?php } ?> value="Mr."> Mr. </option>
                    <option <?php if ($DeliveryTitle == 'Mrs.') { ?> selected <?php } ?>
                                                value="Mrs."> Mrs. </option>
                    <option <?php if ($DeliveryTitle == 'Ms.') { ?> selected <?php } ?> value="Ms."> Ms. </option>
                    <option <?php if ($DeliveryTitle == 'Miss.') { ?> selected <?php } ?>
                                                value="Miss."> Miss. </option>
                    <option <?php if ($DeliveryTitle == 'Dr.') { ?> selected <?php } ?> value="Dr."> Dr. </option>
                    <option <?php if ($DeliveryTitle == 'Prof.') { ?> selected <?php } ?>
                                                value="Prof."> Ms. </option>
                    <option <?php if ($DeliveryTitle == 'Rev.') { ?> selected <?php } ?>
                                                value="Rev."> Rev. </option>
                  </select>
                  <i></i> </label>
              </div>
              <div class="col-md-8 m-l-12">
                <label class="input"> <i class="icon-append fa fa-user"></i>
                  <input type="text" placeholder="First Name" id="d_first_name" name="d_first_name"
                                           value="<?= $delivery_fname ?>" class="required">
                  <b class="tooltip tooltip-bottom-right">Please Enter First Name</b></label>
              </div>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-user"></i>
                <input type="text" placeholder="Last Name" name="d_last_name"
                                       value="<?= $delivery_lname ?>"
                                       id="d_last_name" class="required">
                <b class="tooltip tooltip-bottom-right">Please Enter Last Name</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-phone"></i>
                <input type="text" placeholder="Phone Number" name="d_phone_no"
                                       value="<?= $delivery_pno ?>"
                                       id="d_phone_no" class="required">
                <b class="tooltip tooltip-bottom-right">Please Enter Phone Number</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-phone"></i>
                <input type="text" placeholder="Mobile Number" name="d_mobile_no"
                                       value="<?= $delivery_mno ?>"
                                       id="d_mobile_no">
                <b class="tooltip tooltip-bottom-right">Please Enter Mobile Number</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="email" placeholder="Email" value="<?= $delivery_email ?>" name="d_email"
                                       id="d_email" class="required">
              </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-user"></i>
                <input type="text" placeholder="Company Name" name="d_organization"
                                       value="<?= $delivery_company ?>" id="d_organization">
                <b class="tooltip tooltip-bottom-right">Please Enter Company Name</b> </label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="col-sm-12">
              <label class="select">
                <select name="dcountry" id="dcountry" class="required">
                  <option value="">Select Country</option>
                  <optgroup label="UK">
                  <option data-value="GB" <?= ($dcountry == 'United Kingdom') ? 'selected="selected"' : '' ?>
                                                value="United Kingdom">United Kingdom </option>
                  </optgroup>
                  <optgroup label="EUROPEAN UNION">
                  <?
                                        foreach ($europeunion_list as $row) {
                                            ?>
                  <option data-value="<?= $row->c_code ?>"
                                                    data-vat="EUROPEAN UNION" <?= ($dcountry == $row->name) ? 'selected="selected"' : '' ?>
                                                    value="<?= $row->name ?>">
                  <?= $row->name ?>
                  </option>
                  <? } ?>
                  </optgroup>
                  <optgroup label="EUROPE">
                  <?
                                        foreach ($europe_list as $row) {
                                            ?>
                  <option <?= ($dcountry == $row->name) ? 'selected="selected"' : '' ?>
                                                    data-vat="EUROPE" value="<?= $row->name ?>">
                  <?= $row->name ?>
                  </option>
                  <? } ?>
                  </optgroup>
                  <optgroup label="ROW">
                  <?
                                        foreach ($restofworld_list as $row) {
                                            ?>
                  <option data-value="<?= $row->c_code ?>"
                                                    data-vat="ROW" <?= ($dcountry == $row->name) ? 'selected="selected"' : '' ?>
                                                    value="<?= $row->name ?>">
                  <?= $row->name ?>
                  </option>
                  <? } ?>
                  </optgroup>
                </select>
                <i></i> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-search"></i>
                <input type="text" placeholder="Postcode" name="d_pcode" value="<?= $delivery_pcode ?>"
                                       id="d_pcode" class="required is_dcountry_sel">
                <b class="tooltip tooltip-bottom-right">Enter your postcode and select your address from
                the locations found, using the drop-down menu.</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="text" placeholder="Address 1" name="d_add1" value="<?= $delivery_add1 ?>"
                                       id="d_add1"
                                       class="required is_dcountry_sel">
                <b class="tooltip tooltip-bottom-right">Please Enter Address Line</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                <input type="text" placeholder="Address 2" value="<?= $delivery_add2 ?>"
                                       class="is_dcountry_sel"
                                       name="d_add2" id="d_add2">
                <b class="tooltip tooltip-bottom-right">Please Enter Address Line</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-map-marker"></i>
                <input type="text" placeholder="City/Town" value="<?= $delivery_city ?>" name="d_city"
                                       id="d_city" class="required is_dcountry_sel">
                <b class="tooltip tooltip-bottom-right">Please Enter City or Town</b> </label>
            </div>
            <div class="col-sm-12 ">
              <label class="input"> <i class="icon-append fa fa-map-marker"></i>
                <input type="text" placeholder="County" class="is_dcountry_sel"
                                       value="<?= $delivery_county ?>"
                                       name="d_county" id="d_county">
                <b class="tooltip tooltip-bottom-right">Please Enter County</b> </label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 m-t-10">
        <hr>
      </div>
      <div class="col-sm-12 m-b-10 m-t-20">
        <div class="pull-left m-t-10 m-b-10 m-r-5" style="font-size: 12px !important;"> <small><strong>SMS:</strong> If you would like to receive text messages about your orders despatch
          progress and delivery options, while on route with the courier. Then please do not forget to
          provide
          the mobile phone number, to be used. </small> </div>
      </div>
      <br>
      <br>
      <br>
      <div class="row">
        <div class="col-xs-12  col-sm-6 col-md-3 float-left">
          <button id="biling" type="button"
                            class="btn-outline-info waves-light waves-effect width-select "
                            style="padding: 7px;border: 1px solid;border-radius: 4px;"><i  class="fa fa-arrow-circle-left"></i> Back to Billing </button>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3"> </div>
        <div class="col-xs-12 col-sm-6 col-md-3"> </div>
        <div class="col-xs-12 col-sm-6 col-md-3 float-right">
          <button type="button" id="activate-step-3"
                            class="btn btn-outline-primary waves-light waves-effect width-select "
                            style="padding: 7px;"> Shipping <i
                                class="fa fa-arrow-circle-right"></i></button>
        </div>
      </div>
    </div>
    
    
    
    
    
    <div class="setup-content" id="step-3" style="display: none">
      <div class="">
        <h4 class="m-t-b-8 m-l-20 cBlue">Shipping </h4>
        <div id="ajax_delivery" class="row">
          <?php include('delivery_charges.php'); ?>
        </div>
        <div style="display:none;margin-top: 10px;" class="col-sm-12 ukvatbox">
          <div class="col-md-8">
            <label class="checkbox" style="font-size: 0.8125rem;">
              <input type="checkbox" id="unreg_vat" name="unreg_vat" value="yes" class="textOrange" >
              <i></i>If you have a VAT number and qualify for exemption on this order. Please tick this box,
              enter the number below and verify.</label>
          </div>
          <div class="clearfix"></div>


          <div class="row" style="margin: 10px 0px;">

          <div class="col-md-3 no-padding">
            <div class="input-group"><span id="vat_cc" class="input-group-addon">&nbsp;</span>
              <input type="text" id="vatnumber" disabled="disabled" name="vatnumber"
                               placeholder="Enter VAT number" class="form-control" style="padding: 9px;">
            </div>
          </div>

          <div class="col-md-2">
            <button class="btn btn-outline-primary waves-light waves-effect" disabled="disabled" id="vat_validator" type="button" style="padding: 6px 25px;margin-left: 25px;"> Verify </button>
          </div>
          </div>





          <div class="col-md-12">
            <h5 id="vat_name" style="font-size: 0.8125rem;"></h5>
          </div>
          <div class="clearfix hidden-sm hidden-md hidden-lg"></div>
          <div class="col-md-8 hide" style="font-size: 0.8125rem;"> As you are not a UK customer for the purpose of exempting VAT from your
            purchase, please provide
            a valid VAT number for your business and VAT will be excluded from your order. </div>
        </div>
      </div>
      <div id="delivertimeynote" class="col-sm-12 m-t-10">
        <div>
          <p> <small><strong>Please note:</strong> Orders placed before 16:00 qualify for next day delivery,
            providing this is not a weekend or UK public holiday. Orders received after 16:00 will be
            treated as having been received the next working day after placement, in production planning
            terms and the next working day for delivery will be calculated accordingly. For a Saturday
            delivery the order must also be placed before 16:00 on the Friday before. </small> </p>
        </div>
        <hr>
      </div>
      <div id="offshoredeliverynote" class="col-sm-12 m-t-10" style="display:none;">
        <div>
          <h4>Exception &amp; Offshore Deliveries</h4>
          <p>Please be aware that delivery to an address considered an exception postcode will incur a delivery
            charge of <? echo symbol . $this->home_model->currecy_converter(11.75, 'no'); ?> plus VAT. Postcodes which classify as exception postcodes on mainland UK are decided by our
            couriers. <br/>
          </p>
        </div>
      </div>
      <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12  col-sm-6 col-md-3 float-left">
          <button type="button" id="delive" class="btn-outline-info waves-light waves-effect width-select"
                        style="padding: 7px;border: 1px solid;border-radius: 4px;"><i class="fa fa-arrow-circle-left">             </i> Delivery </button>
         </div>
        <div class="col-xs-12 col-sm-6 col-md-3"> </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
         
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 float-right">
          
          <button type="button" id="activate-step-6"class="btn btn-outline-primary waves-light waves-effect width-select " style="padding: 7px;"> Review & Pay <i class="fa fa-arrow-circle-right"></i></button>
         
        </div>
      </div>
    </div>
    
    
    
    
    
    
    

    <div class="setup-content" id="step-6" style="display:none ;">
      <div class="card">
        <div class="card-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6" style="display: flex;padding: 0px 10px 0px 0px;">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two" 
                  style="padding: 7px;background: #e0e0e0;border-bottom-color: #e0e0e0;color: #333;">BILLING ADDRESS</div>
                  <div class="card-body" style=" padding: 10px;">
                    
                    <b>Company Name:</b> <span id="bc_com_name"></span>
                    <br>
                    <b> Name:</b>         <span id="bc_name"></span>
                    <br>
                    <b>Address 1:</b>     <span id="bc_add1"></span>
                    <br>
                    <b>Address 2:</b>     <span id="bc_add2"></span>
                    <br>
                    <b>City:</b>          <span id="bc_city"></span>
                    <br>
                    <b>County/State:</b>  <span id="bc_county"></span>
                    <br>
                    <b>Country:</b>       <span id="bc_country"></span>
                    <br>
                    <b>Postcode:</b>      <span id="bc_pcode"></span>
                    <br>
                    <b>Email:</b>         <span id="bc_email"></span>
                    <br>
                    <b>T:</b>             <span id="bc_ph"></span>
                    <b> | M:</b>          <span id="bc_mob"></span>
                  </div>
                </div>
              </div>

              <div class="col-md-6" style="display: flex; padding: 0px 0px 0px;">
                <div class="card enquiry-card enquiry-card-bix-box-second" style="width: 100%">
                  <div class="card-header card-heading-text-two"  
                  style="padding: 7px;background: #e0e0e0;border-bottom-color: #e0e0e0;color: #333;">DELIVERY ADDRESS</div>
                  <div class="card-body" style=" padding: 10px;">
                    
                    <b>Company Name:</b>    <span id="dc_com_name"></span>
                    <br>
                    <b> Name:</b>           <span id="dc_name"></span>
                    <br>
                    <b>Address 1:</b>       <span id="dc_add1"></span>
                    <br>
                    <b>Address 2:</b>      <span id="dc_add2"></span>
                    <br>
                    <b>City:</b>            <span id="dc_city"></span>
                    <br>
                    <b>County/State:</b>    <span id="dc_county"></span>
                    <br>
                    <b>Country:</b>         <span id="dc_country"></span>
                    <br>
                    <b>Postcode:</b>        <span id="dc_pcode"></span>
                    <br>
                    <b>Email:</b>           <span id="dc_email"></span>
                    <br>
                    <b>T:</b>               <span id="dc_ph"></span>
                    <b> | M:</b>            <span id="dc_mob"></span>
                    <br>  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
         <br>
          <div class="tab-pane show active" id="home1">
           <div class="card-box no-padding" id="review_cart_div" style="margin-bottom:20px;">
              <? //include('review_cart.php'); ?>
            </div>
          </div>

      <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12  col-sm-6 col-md-3 float-left">
          <button type="button" id="shping" class="btn-outline-info waves-light waves-effect width-select"
                        style="padding: 7px;border: 1px solid;border-radius: 4px;"><i class="fa fa-arrow-circle-left"> </i> Shipping </button>
         </div>
        <div class="col-xs-12 col-sm-6 col-md-3"> </div>
       <div class="col-xs-12 col-sm-6 col-md-3">
          <?php if(isset($sample) and $sample == 'other'){  ?>
          <button type="button" id="save_quotation" onclick="saveQuotation()"
                        class="btn btn-outline-primary waves-light waves-effect" style="padding: 7px;">Save Quotation  </button>
          <?php } ?>
         
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 float-right">
          <?php if($iscustomdie == 'no'){?>
          <button type="button" id="activate-step-4"class="btn btn-outline-primary waves-light waves-effect width-select " style="padding: 7px;"> PROCEED TO ORDER <i class="fa fa-arrow-circle-right"></i></button>
          <?php }?>
        </div>
      </div> 
  </div>

 <div class="setup-content" id="step-4" style="display:none ;">
   <div class="row">
        <div class="col-sm-12 col-xs-12 col-md-7 m-t-30 special-col-sm-4">
          <div class="col-sm-12 m-t-10"><strong class="textBlue">Billing Detail</strong>
            <p id="billing_name_review"></p>
            <span id="billing_address_review"></span></div>
          <div class="col-sm-12 m-t-20"><strong class="textBlue">Delivery Detail </strong>
            <p id="delivery_name_review"></p>
            <span id="delivery_address_review"></span></div>
          <div class="col-sm-12" style="display: none !important;">
            <div class="col-sm-12 paymentInputs11 secure-ssl-seal1 text-center m-t-10 borderRadius"
                         style="display:none;"><img class="img-responsive" src="<?= Assets ?>images/godady_bg.png"
                                                    alt="Godaddy Secure Seal"></div>
          </div>
          <div class="col-sm-12 paymentInputs11"
                     style=" <?= (isset($sample) and $sample == 'sample') ? 'display:none;' : '' ?>">
            <div class="clearfix"></div>
            <div class="textBlue m-b-6 m-t-10"><strong class="">Order Summary</strong></div>
            <div id="ajax_order_summary">
              <? include('order_summary.php'); ?>
            </div>
          </div>
        </div>
        <input type="hidden" value="AA" name="QuoteWebsite" id="QuoteWebsite">
        <div class="col-sm-12 col-xs-12 col-md-5 m-t-20 paymentdiv">
          <div class="paymentInputs11"
                     style=" <?= (isset($sample) and $sample == 'sample') ? 'display:none;' : '' ?>">
            <div class="m-t-10">
              <label class="radio borderRadius " style="margin-bottom: 10px !important;">
                <input type="radio" class="payment_for_ord" id="worldpay" value="creditCard"
                                   name="paymentway">
                <i class="rounded-x m-l-10"></i> <img style="float:right;"src="<?= Assets ?>images/worldpay.png" class="img-responsive hidden-xs hidden-sm"alt="Worldpay Logo"> &nbsp;&nbsp;
                <strong style="font-size:14px; color:#333; ">Pay by Credit / Debit Card </strong> </label>
              <?
                        /*if (isset($userid) and $userid != '') {
                            $cards = $this->user_model->get_user_saved_cards();
                            if (count($cards) > 0) { ?>
              <div class="col-md-7">
                <label class="cardsonfile select m-t-10" style="display:none;margin-bottom:0px;">
                  <select name="creditcard" id="creditcard" class="required">
                    <option selected="selected" value="">Select saved cards</option>
                    <? foreach ($cards as $row) {
                                                //$cardname = $row->maskedCardNumber;
                                                $cardname = explode("_", $row->cardType);
                                                $cardname = $cardname[0] . ' ' . $row->maskedCardNumber;
                                                //$cardname = '( '.str_replace("_"," ",$row->cardType).' ) '.$row->maskedCardNumber;
                                                ?>
                    <option value="<?= $row->token ?>">
                    <?= $cardname ?>
                    </option>
                    <? } ?>
                  </select>
                  <i></i> </label>
              </div>
              <div class="col-md-5">
                <label class="cvcinput input m-t-10" style="display:none; margin-bottom:0px;"> <i
                                                class="icon-append fa fa-key"></i>
                  <input type="text" size="4" placeholder="CVC Number" autocomplete="off" value=""
                                               id="cvcnumb" class="required">
                </label>
              </div>
              <div class="col-md-7 m-t-10 cardsonfile paywithnewcard" style="display:none;"><a
                                            href="javascript:void(0);" class="paywithnewcardbtn"
                                            style="font-size:14px;color:#333;font-weight: bold;">Pay with new card</a> </div>
              <div class="clear"></div>
              <? }
                        } */?>
              <div class="retain_card_opt_notreq m-l-10 m-t-10" style="display:none;">
                <label class="checkbox pull-right"
                                   style=" position:absolute; margin-left:410px; margin-top:15px !important;">
                  <input type="checkbox" value="0" name="retain_cards" id="retain_cards"
                                       class="textOrange">
                  <i></i> </label>
                <p style="font-size:11px;"> Your card details are securely stored with Worldpay enabling
                  future purchases. However if you would prefer not to have your card details retained
                  please tick this box.</p>
              </div>
              <div class="col-md-12 col-sm-12">
                <div class="ps_container">
                  <style>
                                    .mobileBody #_el_input_nameoncard input {
                                        width: 50% !important;
                                    }
                                </style>
                  <script>
                                    var sheet = window.document.styleSheets[0];
                                    sheet.insertRule('.mobileBody #_el_input_nameoncard input { width: 20%!important; }', sheet.cssRules.length);
                                </script>
                  <div id="paymentSection"></div>
                </div>
              </div>
              <div class="col-md-7 m-t-10 paywithexistingcards" style="display:none;">
                <p onclick="showotherPaymentOption()"
                                     class="textBlue "
                                    style="font-size: 14px;color: #333;font-weight: bold;text-decoration: underline;cursor: pointer;">Back to Payment Options.</p>
              </div>
              <div class="col-md-12 m-t-10 " style="display:none;">
                <p class="textBlue paywithexistingcardsbtn" style="font-size: 14px;color: #333;font-weight: bold;text-decoration: underline;cursor: pointer;">Back to Payment Options.</p>
              </div>
              <div class="clear"></div>
            </div>
            <p class="m-t-10 paypal_selection_box">
              <label class="radio borderRadius " style="margin-bottom: 10px !important;">
                <input type="radio" class="payment_for_ord" id="paypal" value="paypal" name="paymentway">
                <i class="rounded-x m-l-10"></i><img style="margin-top: -2px; margin-left:10px; width:96px;"
                                                                 src="<?= Assets ?>images/paypal.png" alt="Paypal Logo"
                                                                 class="pull-left hidden-xs hidden-sm">&nbsp; <strong
                                    class="pull-right" style="font-size:12px; font-weight:500;"> PayPal, Credit &amp;
                Debit Cards </strong> </label>
            <div style="float:left;margin-top:-42px;opacity:1;width:200px;margin-left:11px;"
                         class="paypal_selection_box" id="paypal-button-checkout"></div>
            <div style="display:none;" class="clear paypal-confirm-msg"></div>
            <p class="paypal-confirm-msg" style="padding-left:15px;display:none;">Please click the orange button
              to confirm<br/>
              your PayPal payment.</p>
            </p>
            <p class="m-t-10 backs_selection_box">
              <label class="radio borderRadius " style="margin-bottom: 10px !important;">
                <input type="radio" id="chequePostel" class="payment_for_ord" value="chequePostel"
                                   name="paymentway">
                <i class="rounded-x m-l-10"></i>&nbsp;&nbsp;<strong
                                    style="font-size:15px; color:#333;;"></strong> <img
                                    style="margin-top: -11px; margin-left:-2px; width:72px;"
                                    src="<?= Assets ?>images/bank-transfer-logo.png" alt="Bank Icon"
                                    class="hidden-xs hidden-sm">&nbsp; <span class="pull-right"
                                                                             style="font-size:12px; font-weight:500; float:right;"> BACS, IBAN, SWIFT</span> </label>
            </p>
            <div id="chequePostel_div" style="display:none;">
              <div class="col-md-12">
                <div class="clearfix"></div>
                <p style="font-size:12px; margin:5px 0px;" class="text-left">Once the order is submitted you
                  will receive an automated email with our bank details. When making payment please use
                  the order number as payment reference.</p>
              </div>
              <div class="clear"></div>
            </div>
            <p class="m-t-10 purchaseorder_selection_box">
              <label class="radio borderRadius " style="margin-bottom: 10px !important;">
                <input type="radio" id="pushase" class="payment_for_ord" value="purchaseOrder"
                                   name="paymentway">
                <i class="rounded-x m-l-10"></i>&nbsp; <strong style="font-size:15px; color:#333;;">Purchase
                Order </strong> <span class="pull-right"
                                                      style="font-size:12px; font-weight:500; float:right;"> Government &amp; Public Services</span> </label>
            </p>
            <div id="uploader_po" style="display:none;">
              <div class="col-xs-8 col-sm-4">
                <input class="m-t-15" type="file" style="display:none;" name="file_up" id="file_up">
              </div>
              <div class="clearfix"></div>
              <div class="col-xs-4 col-sm-8  ">
                <button class="btn btn-primary btn btn-info waves-light waves-effect addnewline" style="padding: 10px;margin: 10px 0px;" type="button" onclick="$('#file_up').trigger('click');"><i
                                        class="fa fa-cloud-upload"></i> Upload Purchase Order </button>
              </div>
              <div class="col-xs-4 col-sm-4  "><img style="display:none; width:36px; height:40px;"
                                                              id="preview_po_img" class="preview_po_img"
                                                              src="#" alt="Preview Purchase Order"/> <a
                                    href="javascript:void(0);" style="display:none;" class="preview_po_img"
                                    onclick="$('#file_up').val();$('.preview_po_img').hide();">Remove </a></div>
              <div class="clearfix"></div>
            </div>
            <p style=" display:none;font-size: 12px; " class="m-t-10 purchaseordertxt">* Please note: Your order will not be processed until we receive a signed copy of the
              official Purchase Order via email at <a href="mailto:customercare@aalabels.com">customercare@aalabels.com</a> or post to: AA Labels, 23 Wainman Road, Peterborough PE2 7BU</p>
          </div>
          <div class="clearfix"
                     style=" <?= (isset($sample) and $sample == 'sample') ? '' : 'display:none;' ?>"></div>
          <div class="col-sm-12 normal_checkout m-t-10">
            <div class="col-sm-12 " style="font-size: 12px;margin-top: 0px;padding: 5px;border-radius: 4px;">
              <label class="checkbox">
                <input type="checkbox" required name="agree_term" id="agree_term" class="textOrange"  onclick="termConditionAgreement()">
                <i></i></label>
              &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I have read and agree to the <a target="_blank" href="https://www.aalabels.com/terms-and-conditions"
                                                                                          class="textOrange">Terms &amp; Conditions</a> of sale. </div>
          </div>
          <div class="col-sm-12 no-padding m-t-10">
            <div class="clearfix"
                         style=" <?= (isset($sample) and $sample == 'sample') ? '' : 'display:none;' ?>"></div>
            <button type="submit" id="confirmbtn"
                            style="font-size:16px; padding:12px 0px !important;border-radius: 9px; opacity:0.5;    margin-top: 15px;"
                            class="btn btn-block orangeBg pull-right paymentInputs btn-block"> Confirm Order <i
                                class="fa fa-arrow-circle-right"></i></button>
            <button type="button" id="worlpaybtn"
                            style="font-size:16px; padding:12px 0px !important; display:none;border-radius: 9px;opacity:0.5;"
                            class="btn btn-block orangeBg pull-right btn-block" style="display:none">
            <img id="world_loader_icon" style="display:none;" src="<?= Assets ?>images/ring.gif"/> Pay Now <i class="fa fa-arrow-circle-right"></i>
            </button>
          </div>
        </div>
      </div>
      <br>
      <div class="col-md-3">
        <button type="button" id="pay" style="padding: 7px;border: 1px solid;border-radius: 4px;"
                    class="btn-outline-info waves-light waves-effect width-select "><i
                        class="fa fa-arrow-circle-left"></i> Review </button>
        <button type="button" id="back_to_payment"
                    style="display:none; padding: 7px;border: 1px solid;border-radius: 4px;"
                    class="btn-outline-info waves-light waves-effect width-select "><i
                        class="fa fa-arrow-circle-left"></i> Back
        to
        Payment Method </button>
      </div>
      </div>
    </div>
    </div>
  </form>
  <form action="" id="payment_form" method="post">
    <input data-worldpay="token" id="worldpay_token" type="hidden" value=""/>
    <input data-worldpay="cvc" id="worldpay_cvc" type="hidden" size="4" value=""/>
  </form>
  <form action="" id="worldpay_form" method="post">
    <input type="hidden" id="aaaabbbbbbbbdddd"/>
  </form>
  <input type="hidden" id="WP_Public_KEY" value="<?= WP_Public_KEY ?>">
</div>

</div></div></div></div>

<script>
	termConditionAgreement();

	function termConditionAgreement() {

		if ($('#agree_term:checkbox:checked').length > 0) {
			$("#confirmbtn").css("opacity", 1);
		} else {
			$("#confirmbtn").css("opacity", 0.5);
		}
	}

</script>

<script>
    function showotherPaymentOption() {
         window.location.reload();
        /*$('.paypal_selection_box').show();
        $('.backs_selection_box').show();
        $('.purchaseorder_selection_box').show();
        $('.paypal_selection_box').show();
        $('.paymentSection').hide();*/
    }
    
 $('#plain_labels').change(function(){
  if(this.checked) {
	$(this).val(1);
  }else{
	$(this).val(0);
  }
        
});


$(document).ready(function() {
 <?
   if(isset($errortype) and $errortype=='payment'){ ?>
    	$('#activate-step-4').click();
		$('ul.setup-panel li:eq(1)').removeClass('disabled');
		$('ul.setup-panel li:eq(2)').removeClass('disabled');
		$('ul.setup-panel li:eq(3)').addClass('active');
		$('html, body').animate({scrollTop: $("#step-4").offset().top-100}, 1000);
<? }?>
	
});


</script>