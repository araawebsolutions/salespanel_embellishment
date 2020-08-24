<style type="text/css">
    .frmAlert{
        clear: both;
        background-color: red;
        padding: 5px;
        color: #fff !important;
        margin-top: 32px;
        border-radius: 5px;
    }
    .frmSuccessAlert{
        clear: both;
        background-color: green;
        padding: 5px;
        color: #fff !important;
        margin-top: 32px;
        border-radius: 5px;

    }
    .mt-6{
        margin-top:1.5rem; 
    }
    .mb-6{
        margin-bottom:1.5rem; 
    }
</style>
<div class="modal-dialog account-modal-dialog" role="document">
        <div class="modal-content account-modal-content">
<div class="modal-body account-body">
<div class="row">
<div class="col-md-12" id="success"></div>
<div class="col-md-12" id="error"></div>
<div class="col-md-12 text-center"><h3>ADD NEW CUSTOMER</h3></div>
<div class="col-md-12 mt-6 mb-6">
<form id="searchCustomer" method="post">
<div class="row">
    <div class="col-md-2 col-sm-2">
        <select class="form-control form-control-sm account-input" style="float: left;" name="search_by" id="search_by">
            <option value="">Select Field</option>
            <option value="Id">Account Number</option>
            <option value="Name">First Name</option>
            <option value="Email">Email</option>
            <option value="Company">Company</option>
        </select>
        <div id="alert_search_by"></div>
    </div>
    <div class="col-md-2 col-sm-2">
       <input type="text" name="search" id="search" class="form-control form-control-sm account-input" style="float: left;" value="" placeholder="Search" aria-controls="responsive-datatable"> 
       <div id="alert_search"></div>
    </div>
    <div class="col-md-2 col-sm-2">
        <button id="btnSearch" type="submit"
                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="float: left;">Search</button>
    </div>
</div>
</form>
</div>
</div>
<form id="validationID" action="<?php echo main_url; ?>credit_accounts/save_credit_account" method="post" enctype="multipart/form-data">
                        <div class="row">
                            
                            <div class="col-md-4 account-details">
                                <h3 class="account-title">Account Details</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">A/C *</span>
                                    <input type="hidden" name="c_account_id" id="c_account_id" class="form-control form-control-sm account-input" value="" placeholder="" aria-controls="responsive-datatable">
                                    <input type="text" name="c_account_number" class="form-control form-control-sm account-input" value="<?php echo $c_account_number; ?>" aria-controls="responsive-datatable">
                                    </div>
                                    <div id="AccountNumber">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Company Name</span>
                                    <input type="text" name="c_account_company" class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">Balance *</span>
                                    <input type="text" name="c_account_balance" required class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">

                                    </div>
                                    <div id="Balance">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Account limit</span>
                                    <input type="text" name="c_account_limit" required class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                </label>
                            </div>
                            <div class="col-md-4 contact-info">
                                <h3 class="account-title">Contact Information</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">First Name *</span>
                                    <input type="text" name="c_account_contact_name" required  class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingFirstName">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Last Name</span>
                                    <input type="text" name="c_account_last_name" class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Trade Name</span>
                                    <input type="text" name="c_account_trade_name" class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Telephone</span>
                                    <input type="text" name="c_account_telephone" class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                </label>
                                
                            </div>
                            <div class="col-md-4">
                                <h3 class="account-title">Email Settings</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">Primary Email *</span>
                                    <input type="email" name="c_account_primary_email" required class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                    </div>
                                    <div id="UserEmail">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Secondary Email</span>
                                    <input type="text" name="c_account_secondary_email" class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                </label>
                            </div>
                        </div>
                        <div class="row ac-line-2">
                            <div class="col-md-4 account-details">
                                <h3 class="account-title">Address *</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">Address 1</span>
                                    <input type="text" name="c_account_address1" required  class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingAddress1">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Address 2</span>
                                    <input type="text" name="c_account_address2" class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">Town / City *</span>
                                    <input type="text" name="c_account_city" required class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingTownCity">

                                    </div>
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">County / State *</span>
                                    <input type="text" name="c_account_state" required class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingCountyState">

                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4 contact-info">
                                <h3 class="account-title">Contact Information</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">Country *</span>
                                    <input type="text" name="c_account_country" required class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingCountry">

                                    </div>
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">Post Code *</span>
                                    <input type="text" name="c_account_post_code" required class="form-control form-control-sm account-input"
                                           aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingPostcode">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">VAT No</span>
                                    <input type="text" name="c_account_vat_no" class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable">
                                </label>

                            </div>
                            <div class="col-md-4">
                                <h3 class="account-title">Account Settings</h3>
                                <label>
                                    <span class="account-form-title">Account Status</span>
                                    <div class="checkbox checkbox-info ac-status-check-box">
                                        <input id="checkbox4" name="c_account_on_hold" value="yes" type="checkbox">
                                        <label for="checkbox4"></label>
                                        <span>On Hold</span>
                                    </div>

                                </label>
                            </div>
                        </div>
                        <div class="modal-footer ac-footer">
                <div class="ac-buttons">
                    <span class=" m-r-10"><button type="button"
                                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal" onclick="location.reload(true);">CLOSE</button></span>
                    <span><button id="btnSubmit" type="submit"
                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">SAVE</button></span>
                </div>
            </div>
            </form>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $("#searchCustomer").submit(function(event) {
        if($('#search_by').val() == '')
        {
             $('#alert_search_by').show();
            $('#alert_search_by').html('<div class="frmAlert">The search by field is required.</div>');
            setTimeout(function(){ 
                $('#alert_search_by').hide();
                   
                  }, 1500);
        }
        else
        if($('#search').val() == '')
        {
            $('#alert_search').show();
            $('#alert_search').html('<div class="frmAlert">The search field is required.</div>');
            setTimeout(function(){ 
                $('#alert_search').hide();
            }, 1500);
        }
        else
        {
            var formData = {
            "search_by"          : $('#search_by').val(),
            "search"         : $('#search').val()
        };
             $.ajax({
            type: "post",
            url: mainUrl+"credit_accounts/search_customer",
            cache: false,               
            data: formData,
            dataType: "html",
            success: function(data)
            {
                customer = JSON.parse(data);
                $("input[name=c_account_id]").val(customer.UserID); 
                $("input[name=c_account_number]").val(customer.AccountNumber);   
                $("input[name=c_account_company]").val(customer.BillingCompanyName);
                $("input[name=c_account_balance]").val(customer.Balance);
                $("input[name=c_account_limit]").val(customer.Account_Limit);
                $("input[name=c_account_contact_name]").val(customer.BillingFirstName);
                $("input[name=c_account_trade_name]").val(customer.TradingName);
                $("input[name=c_account_telephone]").val(customer.BillingTelephone);
                $("input[name=c_account_last_name]").val(customer.BillingLastName);
                $("input[name=c_account_primary_email]").val(customer.UserEmail);
                $("input[name=c_account_secondary_email]").val(customer.SecondaryEmail);
                $("input[name=c_account_address1]").val(customer.BillingAddress1);
                $("input[name=c_account_address2]").val(customer.BillingAddress2);
                $("input[name=c_account_city]").val(customer.BillingTownCity);
                $("input[name=c_account_state]").val(customer.BillingCountyState);
                $("input[name=c_account_country]").val(customer.BillingCountry);
                $("input[name=c_account_post_code]").val(customer.BillingPostcode);
                $("input[name=c_account_vat_no]").val(customer.VATNumber);
                
            },
            error: function(){                      
                alert("Error while request..");
            }            
        });
        }

        event.preventDefault();
    });
    $("#validationID").submit(function(event) {

        if($("input[name=c_account_on_hold]").prop("checked") == true){
            c_account_on_hold = 'yes';
        }
        else if($("input[name=c_account_on_hold]").prop("checked") == false){
            c_account_on_hold = 'no';
        }
        var formData = {

            "UserID"           : $("input[name=c_account_id]").val(),
            "AccountNumber"          : $("input[name=c_account_number]").val(),
            "BillingCompanyName"         : $("input[name=c_account_company]").val(),
            "Balance"         : $("input[name=c_account_balance]").val(),
            "Account_Limit"           : $("input[name=c_account_limit]").val(),
            "BillingFirstName"    : $("input[name=c_account_contact_name]").val(),
            "TradingName"      : $("input[name=c_account_trade_name]").val(),
            "BillingTelephone"       : $("input[name=c_account_telephone]").val(),
            "BillingLastName"         : $("input[name=c_account_last_name]").val(),
            "UserEmail"   : $("input[name=c_account_primary_email]").val(),
            "SecondaryEmail" : $("input[name=c_account_secondary_email]").val(),
            "BillingAddress1"        : $("input[name=c_account_address1]").val(),
            "BillingAddress2"        : $("input[name=c_account_address2]").val(),
            "BillingTownCity"            : $("input[name=c_account_city]").val(),
            "BillingCountyState"           : $("input[name=c_account_state]").val(),
            "BillingCountry"         : $("input[name=c_account_country]").val(),
            "BillingPostcode"       : $("input[name=c_account_post_code]").val(),
            "VATNumber"          : $("input[name=c_account_vat_no]").val(),
            "on_hold"          : c_account_on_hold,
        };

        vv = $("input[name=c_account_on_hold]").prop("checked", false);
        var c_account_id = $('#c_account_id').val();
        if(c_account_id != ''){
            reurl = mainUrl+"credit_accounts/update_credit_account";
        }
        else
        {
           reurl = mainUrl+"credit_accounts/save_credit_account"; 
        }

        $.ajax({
            type: "post",
            url: reurl,
            cache: false,               
            data: formData,
            dataType: "html",
            success: function(data)
            {   
                var re=data.split("__"); 
                if(re[0] == 'success')
                {
                    $("input[name=c_account_company]").val("");
                    $("input[name=c_account_balance]").val("");
                    $("input[name=c_account_limit]").val("");
                    $("input[name=c_account_contact_name]").val("");
                    $("input[name=c_account_trade_name]").val("");
                    $("input[name=c_account_telephone]").val("");
                    $("input[name=c_account_last_name]").val("");
                    $("input[name=c_account_primary_email]").val("");
                    $("input[name=c_account_secondary_email]").val("");
                    $("input[name=c_account_address1]").val("");
                    $("input[name=c_account_address2]").val("");
                    $("input[name=c_account_city]").val("");
                    $("input[name=c_account_state]").val("");
                    $("input[name=c_account_country]").val("");
                    $("input[name=c_account_post_code]").val("");
                    $("input[name=c_account_vat_no]").val("");
                    $("input[name=c_account_on_hold]").prop("checked", false);    
                }
                
                $("#"+$.trim(re[0])).html($.trim(re[1])); 
                setTimeout(function(){ 
                     $("#"+$.trim(re[0])).find('.frmAlert').hide();
                  }, 1500
                  );

                swal('Success','Customer Account added Successfully ','success');
             $('#exampleModal').modal('hide');
             window.location.reload();
               
            },
            error: function(){                      
                swal("Error while request..");
            }            
        });
        event.preventDefault();
    });
});
</script>