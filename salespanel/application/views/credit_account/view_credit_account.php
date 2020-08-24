<div class="modal-dialog account-modal-dialog" role="document">
    <div class="modal-content account-modal-content">
        <div class="modal-header account-header">
            <ul class="nav nav-tabs">
                <li>
                    <a href="#1" class="active" data-toggle="tab">Customer Record</a>
                </li>
                <li>
                    <a href="#2" data-toggle="tab">Payment Allocation</a>
                </li>
                <li>
                    <a href="#3" data-toggle="tab">Activity</a>
                </li>
                <li>
                    <a href="#4" data-toggle="tab">Statement</a>
                </li>
            </ul>
        </div>
        <div class="modal-body account-body">
            <div class="tab-content ">
                <div class="tab-pane active " id="1">
                    <form id="validationID" action="'.main_url.'credit_accounts/add_credit_account" method="post"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12" id="message-alert"><?php echo validation_errors(); ?></div>
                            <div class="col-md-4 account-details">
                                <h3 class="account-title">Account Details</h3>
                                <label>
                                    <span class="account-form-title">A/C *</span>
                                    <input type="text" name="c_account_number"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->AccountNumber.'" placeholder="123456"
                                           aria-controls="responsive-datatable">
                                    <input type="hidden" name="c_account_id"
                                           class="form-control form-control-sm account-input" value="'.$UserID.'"
                                           placeholder="123456" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Company Name</span>
                                    <input type="text" name="c_account_company"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingCompanyName.'"
                                           placeholder="ABC LTD" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Balance</span>
                                    <input type="text" name="c_account_balance"
                                           class="form-control form-control-sm account-input"
                                           placeholder="£ 1500.00" value="'.$customer_account->Balance.'"
                                           aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Account limit</span>
                                    <input type="text" name="c_account_limit"
                                           class="form-control form-control-sm account-input"
                                           placeholder="£ 2000.00" aria-controls="responsive-datatable"
                                           value="'.$customer_account->Account_Limit.'">
                                </label>
                            </div>
                            <div class="col-md-4 contact-info">
                                <h3 class="account-title">Contact Information</h3>
                                <label>
                                    <span class="account-form-title">Contact Name</span>
                                    <input type="text" name="c_account_contact_name"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingFirstName.'"
                                           placeholder="Alan Walker" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Trade Name</span>
                                    <input type="text" name="c_account_trade_name"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->TradingName.'"
                                           placeholder="Walker & Sons" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Telephone</span>
                                    <input type="text" name="c_account_telephone"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingTelephone.'"
                                           placeholder="123 4567 890 12" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Website</span>
                                    <input type="text" name="c_account_website"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->Website.'"
                                           placeholder="www.abc.com" aria-controls="responsive-datatable">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <h3 class="account-title">Email Settings</h3>
                                <label>
                                    <span class="account-form-title">Primary Email</span>
                                    <input type="email" name="c_account_primary_email"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->UserEmail.'"
                                           placeholder="alan.walker1@gmail.com" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Secondary Email</span>
                                    <input type="text" name="c_account_secondary_email"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->SecondaryEmail.'"
                                           placeholder="alan.walker1@gmail.com" aria-controls="responsive-datatable">
                                </label>
                            </div>
                        </div>
                        <div class="row ac-line-2">
                            <div class="col-md-4 account-details">
                                <h3 class="account-title">Address</h3>
                                <label>
                                    <span class="account-form-title">Address 1</span>
                                    <input type="text" name="c_account_address1"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingAddress1.'"
                                           placeholder="3 Hardwick Court" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Address 2</span>
                                    <input type="text" name="c_account_address2"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingAddress2.'"
                                           placeholder="Court" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Town / City</span>
                                    <input type="text" name="c_account_city"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingTownCity.'" placeholder="Petersborough"
                                           aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">County / State</span>
                                    <input type="text" name="c_account_state"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingCountyState.'" placeholder="Cambs"
                                           aria-controls="responsive-datatable">
                                </label>
                            </div>
                            <div class="col-md-4 contact-info">
                                <h3 class="account-title">Contact Information</h3>
                                <label>
                                    <span class="account-form-title">Country</span>
                                    <input type="text" name="c_account_country"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingCountry.'"
                                           placeholder="United Kingdom" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Post Code</span>
                                    <input type="text" name="c_account_post_code"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->BillingPostcode.'"
                                           placeholder="PE3 9PW" aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">VAT No</span>
                                    <input type="text" name="c_account_vat_no"
                                           class="form-control form-control-sm account-input"
                                           value="'.$customer_account->VATNumber.'"
                                           placeholder="AA123 4567 89" aria-controls="responsive-datatable">
                                </label>

                            </div>
                            <div class="col-md-4">
                                <h3 class="account-title">Account Settings</h3>
                                <label>
                                    <span class="account-form-title">Account Status</span>
                                    <div class="checkbox checkbox-info ac-status-check-box">
                                        <input id="checkbox4" name="c_account_on_hold" value="yes" type="checkbox"
                                            <?php
                                            if ($customer_account->on_hold == 'yes') {
                                                ?>
                                                checked="checked"
                                                <?php
                                            }
                                            ?>
                                        />
                                        <label for="checkbox4"></label>
                                        <span>On Hold</span>
                                    </div>

                                </label>
                            </div>
                        </div>
                        <div class="modal-footer ac-footer">
                            <div class="ac-buttons">
                    <span class=" m-r-10"><button type="button"
                                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue"
                                                  data-dismiss="modal">CLOSE</button></span>
                                <span><button id="btnSubmit" type="submit"
                                              class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">SAVE</button></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane " id="2" style="padding-left: 15px; padding-right: 15px;">
                    <div class="row">
                        <table id="responsive-datatable-order"
                               class="table table-bordereds taable-bordered payment-tables">
                            <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Company Name</th>
                                <th>Invoice #</th>

                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <div class="tab-pane " id="3" style="padding-left: 15px; padding-right: 15px;">

                    <table id="responsive-datatable-payment"
                           class="table table-bordereds taable-bordered payment-tables" style="width:100%;">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Due on</th>
                            <th>Ref</th>
                            <th>Exchange Rate</th>
                            <th>Details</th>
                            <th>Amount £</th>
                            <th>O/S £</th>
                            <th>Debit £</th>
                            <th>Credit £</th>
                        </tr>
                        </thead>

                    </table>

                    <!--<div class="row">
                        <div class="col-md-4 text-left p-t-15">Showing 1 to 10 of 260 entries</div>
                        <div class="col-md-4 text-center"></div>
                        <div class="col-md-4 text-right">
                            <nav class="pull-right m-t-t-10 m-r-10">
                                <ul class="pagination pagination-split">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#"
                                                             style="font-weight: normal;">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#"
                                                                    style="background: #00b7f1;border-color: #00b7f1;">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#"
                                                             style="font-weight: normal;">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#"
                                                             style="font-weight: normal;">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#"
                                                             style="font-weight: normal;">5</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>-->


                    <table class="table table-bordereds taable-bordered payment-tables">
                        <thead class="collapse-trr">
                        <tr>
                            <th>Future £</th>
                            <th>Current £</th>
                            <th>30 Days £</th>
                            <th>60 Days £</th>
                            <th>90 Days £</th>
                            <th>Older £</th>

                        </tr>
                        </thead>
                        <tbody class="payment-tables-tbody">
                        <tr>
                            <td><input type="email" class="form-control text-center" placeholder="£500.00"></td>
                            <td><input type="email" class="form-control text-center" placeholder="£0.00"></td>
                            <td><input type="email" class="form-control text-center" placeholder="£0.00"></td>
                            <td><input type="email" class="form-control text-center" placeholder="£0.00"></td>
                            <td><input type="email" class="form-control text-center" placeholder="£0.00"></td>
                            <td><input type="email" class="form-control text-center" placeholder="£0.00"></td>
                        </tr>
                        </tbody>
                    </table>


                </div>
                <div class="tab-pane " id="4">
                    <div class="row">
                        <table style="width:100%" id="responsive-datatable-statement"
                               class="table table-bordereds taable-bordered payment-tables">
                            <thead>
                            <tr>
                                <th>Order Reference</th>
                                <th>Date</th>
                                <th>Order Details</th>
                                <th>Debited Amount</th>
                                <th>Credit Amount</th>
                                <th>Balance</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                    <h2 class="statement-note"><b>Note:</b> All values are shown in sterling pounds.</h2>
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <table class="table table-bordereds taable-bordered payment-tables-2" width="60%">
                                <thead>
                                <tr>
                                    <th>Current</th>
                                    <th>Period 1</th>
                                    <th>Period 2</th>
                                    <th>Period 3</th>
                                    <th>Older</th>
                                </tr>
                                </thead>
                                <tbody class="payment-tables-tbody">
                                <tr>
                                    <td> £500.00</td>
                                    <td> £0.00</td>
                                    <td> £0.00</td>
                                    <td> £0.00</td>
                                    <td> £0.00</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-md-4">
                        </div>

                        <div class="col-md-2 p-0">
                            <table class="table table-bordereds taable-bordered payment-tables-3 pull-right">
                                <thead>
                                <tr>
                                    <th>Older</th>
                                </tr>
                                </thead>
                                <tbody class="payment-tables-tbody">
                                <tr>
                                    <td> £0.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        var datatable = $("#responsive-datatable-order").DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": mainUrl + "credit_accounts/order_list",
                "type": "POST",
                "data": {
                    "UserID": "'.$UserID.'",
                    "Balance": "'.$customer_account->Balance.'",
                    "Account_limit": "'.$customer_account->Account_Limit.'"
                }
            },
            "columnDefs": [{}]
        });


        var datatable = $("#responsive-datatable-payment").DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": mainUrl + "credit_accounts/payment_activity",
                "type": "POST",
                "data": {
                    "UserID": "'.$UserID.'",
                    "Balance": "'.$customer_account->Balance.'",
                    "Account_limit": "'.$customer_account->Account_Limit.'"
                }
            },
            "columnDefs": [{}]
        });


        var datatable = $("#responsive-datatable-statement").DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": mainUrl + "credit_accounts/statement",
                "type": "POST",
                "data": {
                    "UserID": "'.$UserID.'",
                    "Balance": "'.$customer_account->Balance.'",
                    "Account_limit": "'.$customer_account->Account_Limit.'"
                }
            },
            "columnDefs": [{}]
        });

        $("#responsive-datatable-statement_processing").hide();
        $("#responsive-datatable-payment_processing").hide();
        $("#responsive-datatable-order_processing").hide();
        $(".dataTables_empty").hide();

        $.fn.dataTable.ext.errMode = "none";

        $("#responsive-datatable, #responsive-datatable-statement, #responsive-datatable-payment, #responsive-datatable-order").on("error.dt", function (e, settings, techNote, message) {
            console.log("An error has been reported by DataTables: ", message);
        });

        $("form").submit(function (event) {
            var formData = {
                "AccountNumber": $("input[name=c_account_number]").val(),
                "BillingCompanyName": $("input[name=c_account_company]").val(),
                "Balance": $("input[name=c_account_balance]").val(),
                "Account_Limit": $("input[name=c_account_limit]").val(),
                "BillingFirstName": $("input[name=c_account_contact_name]").val(),
                "TradingName": $("input[name=c_account_trade_name]").val(),
                "BillingTelephone": $("input[name=c_account_telephone]").val(),
                "Website": $("input[name=c_account_website]").val(),
                "UserEmail": $("input[name=c_account_primary_email]").val(),
                "SecondaryEmail": $("input[name=c_account_secondary_email]").val(),
                "BillingAddress1": $("input[name=c_account_address1]").val(),
                "BillingAddress2": $("input[name=c_account_address2]").val(),
                "BillingTownCity": $("input[name=c_account_city]").val(),
                "BillingCountyState": $("input[name=c_account_state]").val(),
                "BillingCountry": $("input[name=c_account_country]").val(),
                "BillingPostcode": $("input[name=c_account_post_code]").val(),
                "VATNumber": $("input[name=c_account_vat_no]").val(),
                "on_hold": $("input[name=c_account_on_hold]").val(),
                "UserID": $("input[name=c_account_id]").val()
            };
            $.ajax({
                type: "post",
                url: mainUrl + "credit_accounts/update_credit_account",
                cache: false,
                data: formData,
                dataType: "html",
                success: function (data) {
                    $("#message-alert").html(data);
                    $("input[name=c_account_company]").val("");
                    $("input[name=c_account_balance]").val("");
                    $("input[name=c_account_limit]").val("");
                    $("input[name=c_account_contact_name]").val("");
                    $("input[name=c_account_trade_name]").val("");
                    $("input[name=c_account_telephone]").val("");
                    $("input[name=c_account_website]").val("");
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
                },
                error: function () {
                    alert("Error while request..");
                }
            });
            event.preventDefault();
        });
    });

    function pay_in_full(v) {

        $.ajax({
            type: "POST",
            url: mainUrl + "credit_accounts/update_caccount_balance",
            data: "OrderID=" + v + "&PaymentMethods=" + $("#payment_" + v).val() + "&action_amount=" + $("#exchange_" + v).val() + "&UserID=" + $("#customer_" + v).val() + "&amount=" + $("#amount_" + v).val() + "&status=yes",
            success: function (data) {
                alert("Value successfully added.");

            },
            error: function () {
                // alert("Error while request..");
            }
        });

    }

    function update(v) {

        $.ajax({
            type: "POST",
            url: mainUrl + "credit_accounts/update_caccount_balance",
            data: "OrderID=" + v + "&PaymentMethods=" + $("#payment_" + v).val() + "&action_amount=" + $("#exchange_" + v).val() + "&UserID=" + $("#customer_" + v).val() + "&amount=" + $("#amount_" + v).val() + "&status=no",
            success: function (data) {
                alert("Value successfully added.");

            },
            error: function () {
                /*alert("Error while request..");*/
            }
        });


    }
</script>