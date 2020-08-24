<link href="<?php echo ASSETS ?>assets/css/dropzone.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo ASSETS ?>assets/js/dropzone.js"></script>
<style>
    .byCustName {
        display: none;
    }
    .hiden {
        display: none;
    }
    .hide_div {
        display: none;
        opacity: 0;
    }

    #slider-container {
        width:350px;
        margin-left:30px;
    }
    .erss {
        display: none;
        color: crimson;
    }

    .checkbox input[type="checkbox"]{
        top:0px !important;
        left: 0px !important;
        height: 21px;
        width: 19px;
    }

    #ticketImage{
        cursor: pointer;
    }
    .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
        display: block;
        height: 25px;
        width: 25px;
    }
    .dz-preview dz-processing dz-image-preview dz-success dz-complete{ width:15%;}
    .dropzone .btn { margin-top:10px; cursor:pointer;}
    .mat-ch .detail .cont .dropzone .dz-message .fa-upload {
        color: #fd4913;
        font-size: 33px;
    }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
        cursor: pointer;
    }
    .btn-outline-dark:hover {
        border-color: #fd4913;
        background: transparent;
        color: #fd4913;
    }
    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }

</style>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg text-center">
                        <div class="col-md-6 center-page m-t-t-10">
                            <span class="returns-title">CREDIT NOTE FORM</span>
                            <hr>
                            <span class="return-title-text">Please Fill This Form To Add Enquiry</span>
                        </div>
                    </div>

                    <?php
                    $date = strtotime(date('Y-m-d h:i:s'));
                    $token =  md5(uniqid($date, true));
                    ?>

                    <div class="card-body">
                        <?/*= main_url */?><!--tickets/addTickets/findOrders"-->

                        <form method="post" id="search-form" class="labels-form" role="form" novalidates>
                            <div class="row order_search_div" id="" style="margin-bottom: 20px !important;">
                                <div class="col-md-3">
                                    <div class="input-margin-10">
                                        <label class="input "> <i class="icon-append mdi mdi-cart-plus icon-appendss"></i>
                                            <input type="text" placeholder="Search Order Numbers e.g AA00,AA11" value="" name="orderNumber" id="orderNumber" class="required input-border-blue" title="e.g. Order Numbers AA173536,AA173536,AA173536" multiple required autocomplete="false">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <button type="submit" class="btn btn-outline-info waves-light waves-effect p-6-10 do_submit">
                                        Search <i class="fa fa-arrow-right"></i></button>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-margin-10">
                                        <button type="button" id="searchByCustomerName" onclick="search_by_customer('cus')" class="btn btn-outline-info waves-light waves-effect p-6-10 ">Search by Customer Name </button>
                                    </div>
                                </div>
                            </div>

                            <div class="customer_search_div" style="margin-bottom: 20px !important; display: none">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                                <input type="text" placeholder="Customer Name" name="customer_name"
                                                       id="customer_name" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                                <input type="email" placeholder="Email Address" name="email_address"
                                                       id="email_address" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                                <input type="text" placeholder="Phone" name="ph_no"
                                                       id="ph_no" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="input-margin-10">
                                            <label class="select">
                                                <select name="duration" id="duration" class="required input-border-blue" required>
                                                    <option value="">Select Duration</option>
                                                    <option value="7">Last 7 Days</option>
                                                    <option value="30" >Last 30 Days</option>
                                                    <option value="90" >Last 3 Months</option>
                                                    <option value="180">Last 6 Months</option>
                                                    <option value="All">Show All</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="select ">
                                                <select class="js-example-basic-single required input-border-blue" id="ordernumOpt"  name="orderNumber[]" required multiple="multiple">
                                                </select>
                                                <i></i>

                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="input-margin-10">
                                            <button id="sub_id" class="btn btn-outline-info waves-light waves-effect p-6-27 do_submit" type="submit">Search <i class="fa fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="input-margin-10">
                                            <button onclick="search_by_customer('ord')" class="btn btn-outline-info waves-light waves-effect p-6-27 " ><i class="fa fa-arrow-left"></i> Back </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <button type="button" id="proceedWithoutOrder" class="btn btn-outline-info waves-light waves-effect p-6-10">Proceed Without Order </button>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row" style="margin-top: 10px">
                                    <div class="col-md-10"></div>

                                </div>-->
                                <!--</form>-->
                                <input type="hidden" name="order_search_type" id="order_search_type" value="ord">
                                <input type="hidden" name="order_search_type_cus" id="order_search_type_cus" value="1">
                                <input type="hidden" id="proceeded_without_order_val" value="-1">
                                <input type="hidden" id="vat_exempt_val" value="-1">
                            </div>
                        </form>


                        <div id="whole_add_section" class="">
                            <div class="customer_info_div alert alerts-custom alert-dismissible fade show sweet-alert" role="alert" style="margin-bottom: 20px; display: none">
                                <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>-->
                                <div id="customer_info">

                                </div>
                            </div>

                            <?php if ($this->session->flashdata('error_msg') != "") { ?>
                                <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <b style="color: red"><?php echo $this->session->flashdata('error_msg') ?></b>
                                </div>
                            <?php } ?>


                            <?php if ($this->session->flashdata('success_msg') != "") { ?>
                                <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <b style="color: #32CD32"><?php echo $this->session->flashdata('success_msg') ?></b>
                                </div>
                            <?php } ?>



                            <table class="table table-bordered mb-0 returns-table dataTable list_data">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox checkbox-info  spedic">
                                            <input id="main_checkbox" type="checkbox" class="">
                                            <label for="main_checkbox"></label>
                                        </div>
                                    </th>
                                    <th>Order #</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Post Code</th>
                                    <th>Country</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody class="list_data_tbody">
                                </tbody>
                                <tbody class="custom_line">
                                </tbody>
                                <tfoot>
                                <!--<tr>
                                    <td colspan="7"></td>
                                    <td><strong>Grand Total</strong></td>
                                    <td><span id="sub_total_currency">£</span> <span id="sub_total">0</span></td>
                                </tr>-->






                                    <tr class="totals delivery_vat_row">
                                        <td colspan="7"></td>
                                        <td class="invuice_subtotal"><b>Delivery: </b></td>
                                        <td align="" class="invuice_subtotal_price">
                                            <span class="deliver_charges_curr"></span>
                                            <span class="deliver_charges_val">0</span> </td>
                                        <td></td>
                                    </tr>


                                <tr class="totals">
                                    <td colspan="7"></td>
                                    <td class="invuice_subtotal"><b>Sub Total: </b></td>
                                    <td align="" class="invuice_subtotal_price">
                                        <span id="sub_total_currency">£</span>
                                        <span id="sub_total"> 0</span>
                                    </td>
                                    <td></td>
                                </tr>






                                <tr class="totals delivery_vat_row">
                                    <td colspan="7"></td>
                                    <td class="invuice_subtotal"><b>VAT @ (20.00)%:</b></td>
                                    <td align="" class="invuice_subtotal_price">
                                        <span class="deliver_charges_curr"></span>
                                        <span id="vat_total"> 0</span>
                                    </td>
                                    <td></td>
                                </tr>


                                <tr class="totals">
                                    <td colspan="7"></td>
                                    <td class="invuice_subtotal"><b>Grand Total:</b></td>
                                    <td align="" class="invuice_subtotal_price">
                                        <b><span class="deliver_charges_curr"></span>
                                            <span id="grand_total">0</span>
                                        </b>
                                    </td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                            <br>
                            <br>


                            <div class="row">
                                <div class="input-margin-10">
                                    <button type="button" onclick="add_custom_line()" class="btn btn-outline-info waves-light waves-effect p-6-27 " ><i class="fa fa-plus"></i> ADD CUSTOM LINE </button>
                                </div>
                                <button type="button" class="btn btn-outline-info waves-light waves-effect hintsbtn"
                                        data-toggle="modal" data-target=".add_new_notes_modal"><i class="fa fa-plus"></i> ADD NEW NOTES
                                </button>
                            </div>



                            <form method="post" id="checkout_form" class="labels-form " enctype="multipart/form-data"
                                  action="<?php echo main_url ?>credit-notes/create-ticket"
                                  onsubmit="return getAllValues();">

                                <input type="hidden" id="token" name="token" value="<?php echo $token?>">
                                <input type="hidden" id="order_details_data" name="orders_details">
                                <input type="hidden" id="total_delivery" name="total_delivery" value="0">
                                <input type="hidden" id="total_vat" name="total_vat" value="0">
                                <input type="hidden" id="operator_additional_notes_data" name="operator_additional_notes_data">

                                <br>
                                <div class="row float-right">
                                    <a href="<?php echo main_url ?>credit-notes" id="back" class="btn btn-info waves-light waves-effect btn-countinue">
                                        BACK
                                    </a>

                                    <button type="submit" id="sub"
                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                        CREATE TICKET
                                    </button>
                                </div>
                                <input type="hidden" id="UserID" name="UserID" value="0">
                            </form>


                        </div>





                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>

<!-- en wrapper -->







<!-- Designer Checklist Popup Start -->

<div class="modal fade add_new_notes_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel" style="text-align: center !important;">Sale Operator Notes</h4>
                    <p class="timeline-detail text-center">Please enter your notes here</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-0 dataTable">
                        <thead class="notes-table-header">
                        <tr>
                            <td>Operator</td>
                            <td>Comments</td>
                            <td>Time</td>
                            <td>Action</td>
                        </tr>
                        </thead>

                        <tbody id="additional_note_tbody">
                        </tbody>
                    </table>
                    <!--<table class="table table-bordered taable-bordered f-14">
                        <tbody id="additional_note_tbody">
                        </tbody>
                    </table>-->



                    <form method="post" id="add_new_notes_form" class="labels-form " enctype="multipart/form-data">
                        <input type="hidden" id="token" name="token" value="<?php echo $token?>">
                        <br>

                        <textarea class="form-control" placeholder=" Operator note here:" name="operator_note" id="operator_note"></textarea>
                        <span class="m-t-t-10 pull-right">
                            <button type="button" class="btn btn-outline-dark btn-outline-dark-close waves-light waves-effect btn-countinue btn-print1 p-6-27" data-dismiss="modal">
                                CLOSE
                            </button>
                            <button type="submit" id="add_new_notes_btn" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                SUBMIT
                            </button>
                        </span>
                        <div class="operator_note_val_div"></div>
                        <input type="hidden" name="cr_note_id" id="cr_note_id">
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script type="text/javascript">
    function add_custom_line() {
        /*if($('#order_search_type').val() == 'pwo'){
            var UserID = $("#UserID").val();
        }else{
            var UserID = $("#UserID").val();
        }*/

        var tbody = $(".custom_line");
        if (tbody.children().length == 0) {
            var UserID = $("#UserID").val();
            if (UserID > 0) {
                $.ajax({
                    "url": mainUrl + "credits/Credits/addCustomLine",
                    type: 'post',
                    dataType: "json",
                    data: '_token={{ Session::token() }}&UserID=' + UserID,
                    success: function (data) {
                        //var i = 150;
                        var i = $(".list_data").find("tr").length + 1;
                        var html = '';
                        html += '<tr role="row" class="odd">' +
                            '<td class="sorting_1"><div class="checkbox checkbox-info status-check-box spedic">' +
                            '<input id="checkbox' + i + '" checked data-rowno="' + i + '" type="checkbox" class="chBox" onclick="chBox(' + i + ')">' +
                            '<label for="checkbox' + i + '"></label>' +
                            '</div></td>' +
                            '<td>Custom Line</td>' +
                            '<td>' + data.BillingFirstName + '</td>' +
                            '<td>' + data.BillingLastName + '</td>' +
                            '<td>' + data.BillingPostcode + '</td>' +
                            '<td>' + data.BillingCountry + '</td>' +
                            '<td>' +
                            '<input data-description="' + i + '" type="text" class="form-control form-control-sm return-input" id="descriptionInput' + i + '" placeholder="Product Description" aria-controls="responsive-datatable">' +
                            '<input data-ManufactureID="' + i + '" type="hidden" id="ManufactureID' + i + '" value="0">' +
                            '<input data-ProductID="' + i + '" type="hidden" id="ProductID' + i + '" value="0">' +
                            '</td>' +
                            '<td>' +
                            '<input data-qty="' + i + '" type="number" class="qty_price_change form-control form-control-sm return-input qty" id="qtyInput' + i + '" placeholder="Enter Qty" min="1" value="" aria-controls="responsive-datatable">' +
                            '</td>' +
                            '<td>' +
                            '<div class="input-group " style="flex-wrap: unset; height: 2rem;">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text" style="background-color: #ffffff; border: 1px solid #d0effa;" id="basic-addon' + i + '">£</span>' +
                            '</div>' +
                            '<input data-inputPrice="' + i + '" type="text" value="0" id="total_price_with_vat' + i + '" placeholder="Enter Price" name="searchByCustomerName" class="qty_price_change form-control input-border-blue inputPrice" required></div>' +
                            '<input type="hidden" id="total_price_with_vat_old' + i + '" value="0">' +
                            '</td>' +
                            '<td>' +
                            '<button id="price_change_btn' + i + '" onclick="price_change_func(' + i + ', -1)" class="btn btn-outline-dark btn-sm">' +
                            'Calculate' +
                            '</button>' +
                            '</td>' +
                            '</tr>';

                        $('.custom_line').append(html);
                    },
                    error: function () {
                        swal("", "Please select user or an order first", "warning");
                        return false;
                    }
                });
            } else {
                swal("", "Please select a user or an order first", "warning");
                return false;
            }
        }
    }







    $(document).ready(function () {
        var Otable = $('.list_data').DataTable({
            dom: '<"clear">lrtip',
            processing: true,
            serverSide: true,
            /*"bPaginate": false,*/
            "pageLength": 100,
            "paging": false,
            "info": false,
            language: {
                "zeroRecords": " "
            },
            ajax: {
                "url": mainUrl + "credit-notes/orders-list",
                "type": "POST",
                data: function (d) {
                    if($('#order_search_type').val() == 'ord'){
                        d.orderNumber = $("input[name=orderNumber]").val();
                    }else if($('#order_search_type').val() == 'pwo'){
                        d.orderNumber = '';
                        //$('#whole_add_section').removeClass('hide_div');
                    }else{
                        var option_all = $(".js-example-basic-single option:selected").map(function () {
                            return $(this).text();
                        }).get().join(',');
                        d.orderNumber = option_all;
                    }
                },
                "dataSrc": function (response) {
                    if(response && response.responseError==1){
                        swal("", response.errorMessage, "warning");
                        $('#whole_add_section').addClass('hide_div');
                    }
                    if(response.data!=''){
                        $('#whole_add_section').removeClass('hide_div');
                    }
                    if($('#order_search_type').val() == 'pwo'){
                        $('#whole_add_section').removeClass('hide_div');
                        $('.table').css('width', '');
                    }
                    if(response/* && response.delivery_charges*/){
                        $('#sub_total').text(parseFloat(response.delivery_charges).toFixed(2));
                        $('#vat_total').text(parseFloat(response.initial_vat_total).toFixed(2));
                        $('#grand_total').text(parseFloat(response.initial_grand_total).toFixed(2));

                        $('.deliver_charges_val').text(parseFloat(response.delivery_charges).toFixed(2));
                        $('.deliver_charges_curr').text(response.deliver_charges_curr);


                        if(response.proceeded_without_order == 0){
                            $('.delivery_vat_row').show();
                        }else{
                            $('.delivery_vat_row').hide();
                        }
                        $('#proceeded_without_order_val').val(response.proceeded_without_order);
                        $('#vat_exempt_val').val(response.vat_exempt);

                    }

                    return response.data;
                }
            },
            columns: [
                {data: 'Check', orderable: false},
                {data: 'OrderNumber', orderable: false},
                {data: 'BillingFirstName', orderable: false},
                {data: 'BillingLastName', orderable: false},
                {data: 'BillingPostcode', orderable: false},
                {data: 'BillingCountry', orderable: false},
                {data: 'Description', orderable: false},
                {data: 'Quantity', orderable: false},
                {data: 'Price', orderable: false},
                {data: 'Action', orderable: false},
            ],
        });








        $('#whole_add_section').addClass('hide_div');

        $('.do_submit').on('click',function(e){
            if($(this).val()=='Export'){
                $('#search-form').submit( function(e) {
                    $(this).unbind('submit').submit();
                    Otable.draw();
                });
            }else{
                $('#search-form').submit(function(e) {
                    $('#main_checkbox').prop('checked', false);
                    $('#sub_total').text(0);
                    $('.custom_line').html('');
                    //$('#whole_add_section').removeClass('hide_div');
                    $('.table').css('width', '');
                    if($('#order_search_type').val() == 'pwo'){
                        $('#order_search_type').val('cus');
                        $('.custom_line').html('');
                    }
                    Otable.draw();

                    e.preventDefault();

                    var cn = $('#customer_name').val();
                    var ea = $('#email_address').val();
                    var pn = $('#ph_no').val();
                    var d = $('#duration option:selected').val();
                    var o = $('#ordernumOpt').val();
                    if(o=="" && cn!="" && pn!="" &&  ea!="" && d!="" ){
                        swal("", "Please Choose at-least one order", "warning");
                        return false;
                    }
                    get_order_customer_info();
                });
            }
        });




        $('#main_checkbox').click(function() {
            if ($(this).is(':checked')) {
                $('.chBox:checkbox').prop('checked', true);
            } else {
                $('.chBox:checkbox').prop('checked', false);
            }


            if($('.deliver_charges_val').text() > 0 && $('.deliver_charges_val').text() != undefined && $('.deliver_charges_val').text() != "" && $('.deliver_charges_val').text() != null) {
                var deliver_charges_val = $('.deliver_charges_val').text();
            }else{
                var deliver_charges_val = 0;
            }

            $('#sub_total').text(parseFloat(deliver_charges_val).toFixed(2));
            $('#vat_total').text(parseFloat(deliver_charges_val).toFixed(2));
            $('#grand_total').text(parseFloat(deliver_charges_val).toFixed(2));

            $(".chBox:checkbox").each(function(){
                var $this = $(this);
                var rowNo = $this.attr('data-rowno');

                    if($('#total_price_with_vat'+rowNo).val() && $('#total_price_with_vat'+rowNo).val() > 0){
                        var newTotalPrice = $('#total_price_with_vat'+rowNo).val();
                    }else{
                        var newTotalPrice = 0;
                    }

                    if($('#total_price_with_vat_print'+rowNo).val() && $('#total_price_with_vat_print'+rowNo).val() > 0){
                        var newTotalPricePrint = $('#total_price_with_vat_print'+rowNo).val();
                    }else{
                        var newTotalPricePrint = 0;
                    }

                    var sub_total = parseFloat($('#sub_total').text());


                    if($this.is(":checked")) {
                        $('[data-report=' + rowNo + ']').attr('disabled', false);
                        $('[data-qty=' + rowNo + ']').attr('disabled', false);
                        $('[data-qtyPrint=' + rowNo + ']').attr('disabled', false);
                        $('[data-inputPrice=' + rowNo + ']').attr('disabled', false);
                        $('[data-inputPricePrint=' + rowNo + ']').attr('disabled', false);
                        /*if($('#price_change_btn'+rowNo).hasClass('disabledbutton')){*/



                            var deliver_charges_val = $('.deliver_charges_val').val();

                            //var new_sub_total = sub_total + parseFloat(newTotalPrice) + parseFloat(newTotalPricePrint);
                            if (sub_total + parseFloat(newTotalPrice) + parseFloat(newTotalPricePrint) > 0) {
                                new_sub_total = sub_total + parseFloat(newTotalPrice) + parseFloat(newTotalPricePrint);
                            } else {
                                new_sub_total = 0;
                            }

                            $('#sub_total').text(new_sub_total.toFixed(2));
                            $('#sub_total_currency').text($('#basic-addon' + rowNo).text());


                            //alert($('#proceeded_without_order_val').val());
                            //alert($('#vat_exempt_val').val());
                            var vat_total = 0;
                            if ($('#proceeded_without_order_val').val() == 0) {
                                if ($('#vat_exempt_val').val() != 'yes') {
                                    var vat_rate = '<?php echo vat_rate; ?>';
                                    var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                                }
                            }

                            $('#vat_total').text(vat_total.toFixed(2));

                            var grand_total = (vat_total + new_sub_total);

                            $('#grand_total').text(grand_total.toFixed(2));
                        /*}*/
                }else{
                        $('[data-report=' + rowNo + '] :selected').prop('selected', false);
                        $('[data-report=' + rowNo + ']').attr('disabled', true);
                        $('[data-qty=' + rowNo + ']').attr('disabled', true);
                        $('[data-qtyPrint=' + rowNo + ']').attr('disabled', true);
                        $('[data-inputPrice=' + rowNo + ']').attr('disabled', true);
                        $('[data-inputPricePrint=' + rowNo + ']').attr('disabled', true);
                    /*if($('#price_change_btn'+rowNo).hasClass('disabledbutton')) {*/



                        if ((sub_total - parseFloat(newTotalPrice) - parseFloat(newTotalPricePrint)) > 0) {
                            var new_sub_total = (sub_total - parseFloat(newTotalPrice) - parseFloat(newTotalPricePrint));
                        } else {
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text((new_sub_total).toFixed(2));


                        var vat_total = 0;
                        if ($('#proceeded_without_order_val').val() == 0) {
                            if ($('#vat_exempt_val').val() != 'yes') {
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }
                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));
                    /*}*/
                }
            });






            var chk_len = $('input.chBox:checkbox:checked').length;
            var countselect = $("select.fault option[value!='']:selected").length;
        });




        $('.js-example-basic-single').select2({
            tags: true,
            placeholder: "Select Orders",
            allowClear: true
        });



        function get_order_customer_info() {
            if($('#order_search_type').val() == 'ord'){
                var orderNumber = $("input[name=orderNumber]").val();
            }else{
                var option_all = $(".js-example-basic-single option:selected").map(function () {
                    return $(this).text();
                }).get().join(',');
                var orderNumber = option_all;
            }


            $.ajax({
                "url": mainUrl + "credits/Credits/getOrderCustomerInfo",
                type: 'post',
                dataType: "json",
                data: '_token={{ Session::token() }}&orderNumber='+orderNumber,
                success: function (data) {
                    var html = '';
                    html += "<span><b>Customer Name:</b> " +data.Name+"</span>" +
                        " | <span><b>Address:</b> " +data.address+"</span>" +
                        " | <span><b>Email Address:</b> " +data.BillingEmail+"</span>" +
                        " | <span><b>Phone Number:</b> " +data.BillingTelephone+"</span>"
                    ;
                    $('.customer_info_div').show();
                    $('#customer_info').html('');
                    $('#customer_info').html(html);
                    $('#UserID').val(data.UserID);

                }
            });
        }


        $('#email_address,#ph_no,#duration,#customer_name').change(function () {

            var name = $('#customer_name').val();
            var email_address = $('#email_address').val();
            var ph_no = $('#ph_no').val();
            var duration = $('#duration').val();
            if (name!="" && email_address != "" && ph_no != "" && duration != "") {
                getCustOrders(name,email_address, ph_no, duration);
            }
        });

        function getCustOrders(name,email_address,ph_no,duration){


            $.ajax({
                type: "post",
                async:"false",
                url: mainUrl+"credits/Credits/fetchOrdersBycustomer",
                cache: false,
                data:{
                    name:name,
                    email_address:email_address,
                    ph_no:ph_no,
                    duration:duration
                },
                success: function(data){
                    $('#ordernumOpt').empty();
                    $('#ordernumOpt').val('');
                    $('#ordernumOpt').append("<option value='' disabled>Please Choose</option>");

                    if(data){
                        data = $.parseJSON(data);
                        appendOrderNum(data);
                    }else{
                        swal("", "Sorry, this user have no orders", "warning");
                    }
                },
                error: function(){
                    alert('Error while request..');
                }
            });
        }

        function appendOrderNum(data){

            //$('.dropdown ul').append("<li><option value='sd'>sadsad</option></li>");
            data.forEach(function(item, index, array) {

                var orderNumber =  array[index]['OrderNumber'];
                $('#ordernumOpt').append("<option value="+orderNumber+">"+orderNumber+"</option>");

                //$('.dropdown ul').html("<li><a role='option' class='dropdown-item' aria-disabled='false' tabindex='0' aria-selected='false'><span class='bs-ok-default check-mark'></span><span class='text'>"+orderNumber+"</span></a></li>");
            });
        }


        $('#sub_id').click(function(){

            var cn = $('#customer_name').val();
            var ea = $('#email_address').val();
            var pn = $('#ph_no').val();
            var d = $('#duration option:selected').val();
            var o = $('#ordernumOpt').val();


            if(o=="" && cn!="" && pn!="" &&  ea!="" && d!="" ){
                swal("", "Please Choose atleast one order", "warning");
                return false;
            }
        });

        $('#proceedWithoutOrder').click(function () {
            /*$('#UserID').val('');
            $('#search-form').trigger("reset");*/
            $('.js-example-basic-single').select2();
            $('.custom_line').html('');

            $('#order_search_type').val('pwo');
            Otable.draw();

            var cn = $('#customer_name').val();
            var ea = $('#email_address').val();
            var pn = $('#ph_no').val();
            if(ea==""){
                $('.customer_info_div').hide();
                swal("", "Please enter customer email", "warning");
                return false;
            }else{
                $('#proceeded_without_order_val').val(-1);
                $('#vat_exempt_val').val(-1);
            }




            $.ajax({
                "url": mainUrl + "credits/Credits/searchForCustomer",
                type: 'post',
                dataType: "json",
                data: '_token={{ Session::token() }}&email_address='+ea,
                success: function (data) {
                    var html = '';
                    html += "<span><b>Customer Name:</b> " +data.Name+"</span>" +
                        " | <span><b>Address:</b> " +data.address+"</span>" +
                        " | <span><b>Email Address:</b> " +data.UserEmail+"</span>" +
                        " | <span><b>Phone Number:</b> " +data.BillingTelephone+"</span>"
                    ;
                    $('.customer_info_div').show();
                    $('#customer_info').html('');
                    $('#customer_info').html(html);
                    $('#UserID').val(data.UserID);

                }
            });
        });

        search_by_customer('ord');
    });


    function search_by_customer(type){
        $('#whole_add_section').addClass('hide_div');
        $('.custom_line').html('');
        if(type == 'cus'){
            $('.customer_search_div').show();
            $('.order_search_div').hide();


            $('#orderNumber').prop('disabled', true);
            $('#ordernumOpt').prop('disabled', false);
            $(".customer_search_div :input").attr("disabled", false);
            $('#order_search_type').val('cus');
        }else if (type == 'pwo'){
            $('.customer_search_div').show();
            $('.order_search_div').hide();


            $(".customer_search_div :input").attr("disabled", false);
            $('#orderNumber').prop('disabled', true);
            $('#ordernumOpt').prop('disabled', false);
            $('#order_search_type').val('pwo');
        }else{
            $('.customer_search_div').hide();
            $('.order_search_div').show();


            $(".customer_search_div :input").attr("disabled", true);
            $('#orderNumber').prop('disabled', false);
            $('#ordernumOpt').prop('disabled', true);
            $('#order_search_type').val('ord');
        }
        $('#search-form').trigger("reset");
    }


    function additionalNote() {
        var operator_note = '';
        if($('#operator_note').val()){
            operator_note = $('#operator_note').val();
        }else{
            swal("", "Please enter note", "warning");
            return false;
        }
        $('#additional_note_tbody').append(
            "<tr>" +
            "<td>"+ operator_note + "</td>" +
            "</tr>"
        );
        var html = '';
        html+='<input type="hidden" name="operator_note_val[]" class="operator_note_val" value="'+operator_note+'">';
        $('.operator_note_val_div').append(html);

        $('#operator_note').val('');
    }


    function getAllValues() {
        var chk_box_chk = $('input.chBox:checked').length;
        //alert(chk_box_chk);
        if (0 == chk_box_chk) {
            $(this).attr('type', 'button');
            swal("", "Please Choose at-least one record", "warning");
            $('#focu').focus();
            return false;
        } else {

            var is_disabled = 0;

            $('input.chBox:checkbox:checked').each(function () {
                var sThisVal = $(this).attr('data-rowno');
                if($('#price_change_btn'+sThisVal).hasClass("disabledbutton") == false){
                    is_disabled = 1;
                }
                if($('#price_change_btn_print'+sThisVal).length > 0){
                    if($('#price_change_btn_print'+sThisVal).hasClass("disabledbutton") == false){
                        is_disabled = 1;
                    }
                }

                var reportedFault = $('[data-report=' + sThisVal + '] :selected').attr('value');

                if (reportedFault == "") {
                    $('html, body').animate({
                        scrollTop: $('#report_' + sThisVal).offset().top - 225
                    }, 'slow', function () {
                        $('#report_' + sThisVal).focus();
                    });
                    $('#report_err' + sThisVal).show();
                    return false;
                }
            });
        }


        if(is_disabled != 0){
            swal("", "Please calculate the grand total first", "warning");
            return false;
        }else{
            $('#total_delivery').val($('.deliver_charges_val').text());
            $('#total_vat').val($('#vat_total').text());
            getTicketDetails();
            var vals = $('#order_details_data').val();
            if (vals) {
                return true;
            } else {
                return false;
            }
        }


    }

    function getTicketDetails() {
        var images = [];
        var desc_req = 0;
        var qty_req = 0;
        $('input.chBox:checkbox:checked').each(function () {

            var sThisVal = $(this).attr('data-rowno');
            var reportedFault = $('[data-report=' + sThisVal + '] :selected').attr('value');

            if (reportedFault == "") {
                var offset = $(this).attr('data-scroll-offset') * 1 || 0;
                $('html, body').animate({
                    scrollTop: $('#report_' + sThisVal).offset().top + offset
                }, 'slow', function () {
                    $('#report_' + sThisVal).focus();
                });
                $('#report_err' + sThisVal).show();
                return false;
            }
            var OrderNumber = $('[data-OrderNumber=' + sThisVal + ']').attr('value');
            var Serialnumber = $('[data-SerialNumber=' + sThisVal + ']').attr('value');
            var returnQty = $('#qtyInput'+sThisVal).val();
            var returnQtyPrint = $('#qtyInputPrint'+sThisVal).val();

            var productDescription = '';
            if($('#descriptionInput'+sThisVal).val()){
                productDescription = $('#descriptionInput'+sThisVal).val();
            }else if($('#descriptionInput'+sThisVal).text()){
                productDescription = $('#descriptionInput'+sThisVal).text();
            }

            var productDescriptionPrint = '';
            if($('#descriptionInputPrint'+sThisVal).val()){
                productDescriptionPrint = $('#descriptionInputPrint'+sThisVal).val();
            }else if($('#descriptionInputPrint'+sThisVal).text()){
                productDescriptionPrint = $('#descriptionInputPrint'+sThisVal).text();
            }

            var ManufactureID = '';
            if($('#ManufactureID'+sThisVal).val()){
                ManufactureID = $('#ManufactureID'+sThisVal).val();
            }else if($('#ManufactureID'+sThisVal).text()){
                ManufactureID = $('#ManufactureID'+sThisVal).text();
            }

            var ProductID = '';
            if($('#ProductID'+sThisVal).val()){
                ProductID = $('#ProductID'+sThisVal).val();
            }else if($('#ProductID'+sThisVal).text()){
                ProductID = 0;
            }



            //var newUnitPrice = $('[data-newUnitPrice=' + sThisVal + ']').attr('value');
            var newUnitPrice = $('#total_price_with_vat'+sThisVal).val();
            if($('[data-newTotalPrice=' + sThisVal + ']').attr('value') != undefined){
                var newTotalPrice = $('[data-newTotalPrice=' + sThisVal + ']').attr('value');
            }else{
                var newTotalPrice = $('#total_price_with_vat'+sThisVal).val();
            }


            var newUnitPricePrint = $('#total_price_with_vat_print'+sThisVal).val();

            if($('[data-currency=' + sThisVal + ']').attr('value') != undefined){
                var currency = $('[data-currency=' + sThisVal + ']').attr('value');
            }else{
                var currency = 'GBP';
            }

            if($('[data-Printing=' + sThisVal + ']').attr('value') != undefined){
                var Printing = $('[data-Printing=' + sThisVal + ']').attr('value');
            }else{
                var Printing = '';
            }
            if(productDescription == ''){
                swal("", "Please enter description", "warning");
                return false;
            }
            if(returnQty == 0){
                swal("", "Please enter the quantity", "warning");
                return false;
                //qty_req = 1;
            }


            images.push({
                'orderNumber': OrderNumber,
                'SerialNumber': Serialnumber,
                'qty': returnQty,
                'reportedFault': reportedFault,
                'unitPrice': newUnitPrice,
                'TotalPrice': newTotalPrice,
                'currency': currency,
                'productDescription' : productDescription,
                'ManufactureID' : ManufactureID,
                'ProductID' : ProductID,
                'Printing' : Printing,
                'returnQtyPrint': returnQtyPrint,
                'TotalPricePrint': newUnitPricePrint,
                'productDescriptionPrint': productDescriptionPrint
            });
            var myJSON = JSON.stringify(images);

            $('#order_details_data').empty("");
            $('#order_details_data').val(myJSON);
        });


        var arrNumber = new Array();
        $('.operator_note_val').each(function(){
            if($(this).val()){
                arrNumber.push($(this).val());
            }
        });
        var myJSON1 = JSON.stringify(arrNumber);
        $('#operator_additional_notes_data').empty("");
        $('#operator_additional_notes_data').val(myJSON1);

    }


    function removeOperatorAdditionalNote(sr){
        swal(
            "Are You Sure You Want To Delete This Note",
            {
                buttons: {
                    cancel: "No",
                    catch: {
                        text: "Yes",
                        value: "catch",
                    },
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        ).then((value) => {
            switch (value) {
                case "catch":
                    /*var arr = $('#operator_note_val'+sr).val();
                    var idx = arr.indexOf(operator_note);

                    if (idx != -1) arr.splice(idx, 1);*/

                    //$('#operator_note_val'+sr).val()
                    $('#operator_note_val'+sr).val("");
                    //$('#operator_note_val'+sr).attr("disabled", true);

                    $('#notes_table_row'+sr).remove();
                    return true;
            }
        });
    }
    $(document).ready(function () {
        $('#add_new_notes_form').submit(function(e)
        {
            e.preventDefault();
            var operator_note = '';
            if($('#operator_note').val()){
                operator_note = $('#operator_note').val();
            }else{
                swal("", "Please enter note", "warning");
                return false;
            }

            $.ajax({
                url: mainUrl + 'credits/Credits/addOperatorAdditionalNoteBeforeSave',
                type:"POST",
                data:  new FormData(this),
                contentType: false,
                processData:false,
                dataType: 'json',
                success: function(data){
                    $('#additional_note_tbody').append(
                        "<tr id='notes_table_row"+data.sr+"'>" +
                        "<td>"+ data.created_by + "</td>" +
                        "<td>"+ data.operator_note + "</td>" +
                        "<td>"+ data.created_at + "</td>" +
                        "<td>" +
                        "<button onclick='removeOperatorAdditionalNote("+data.sr+")' class='btn btn-outline-dark btn-sm'>Delete </button>"+
                        "</td>" +
                        "</tr>"
                    );

                    var html = '';
                    html+='<input type="hidden" name="operator_note_val[]" class="operator_note_val" id="operator_note_val'+data.sr+'" value="'+operator_note+'">';
                    $('.operator_note_val_div').append(html);
                    $('#operator_note').val('');
                }
            });
        });



        var $chk_out_order = $('#is_another').val();
        if($chk_out_order){
            swal("", "You have entered another customer order No#!", "warning");
        }

        var email = $('#email_address').val();
        if (email) {
            $('#byOrderNum').hide();
            $('#byCustName').removeClass('byCustName');
        }

        //Buttons examples

        /* var table = $('#datatable-buttons').DataTable({
             lengthChange: false,
             buttons: ['copy', 'excel', 'pdf']
         });

         // Responsive Datatable
         $('#responsive-datatable').DataTable();
         table.buttons().container()
             .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');*/
    });



    $('#orderNumber').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9,-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $('#orderNumber').change(function () {
        var vals = $(this).val();
    });





    function price_change_func(i,p) {
        var rowNo = i;
        var brake = 0;

        //$('#price_change_btn'+rowNo).addClass('disabledbutton');

        if(p == 1 || p == 0){
            if(p==1){
                if($('#total_price_with_vat_print'+rowNo).val()){
                    var newTotalPrice = parseFloat($('#total_price_with_vat_print'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    $('#price_change_btn_print'+rowNo).removeClass('disabledbutton');
                    brake = 1;
                    var newTotalPrice = 0;
                }
                if($('#total_price_with_vat_print_old'+rowNo).val()){
                    var newTotalPrice_old = parseFloat($('#total_price_with_vat_print_old'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    $('#price_change_btn_print'+rowNo).removeClass('disabledbutton');
                    brake = 1;
                    var newTotalPrice_old = 0;
                }



                if($('#qtyInputPrint'+i).val()){
                    var qty = parseFloat($('#qtyInputPrint'+i).val());
                }else{
                    swal("", "Please enter quantity in numbers only", "warning");
                    $('#price_change_btn_print'+dataNo).removeClass('disabledbutton');
                    brake = 1;
                    var qty = 0;
                }
            }else{
                if($('#total_price_with_vat'+rowNo).val()){
                    var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    brake = 1;
                    $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                    var newTotalPrice = 0;
                }
                if($('#total_price_with_vat_old'+rowNo).val()){
                    var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    brake = 1;
                    $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                    var newTotalPrice_old = 0;
                }





                if($('#qtyInput'+i).val()){
                    var qty = parseFloat($('#qtyInput'+i).val());
                }else{
                    swal("", "Please enter quantity in numbers only", "warning");
                    $('#price_change_btn'+dataNo).removeClass('disabledbutton');
                    brake = 1;
                    var qty = 0;
                }
            }





            var price = newTotalPrice;
            var dataNo = i;
            var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');
            checkMaxPrice(price, newTotalPrice_old, dataNo, SerialNumber, p, brake);
        }else{
            if(brake == 1) {
                $('#price_change_btn' + rowNo).removeClass('disabledbutton');
            }else{
                $('#price_change_btn' + rowNo).addClass('disabledbutton');
            }

            if($('#total_price_with_vat_old'+rowNo).val()){
                var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
            }else{
                swal("", "Please enter price in numbers only", "warning");
                brake = 1;
                $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                var newTotalPrice_old = 0;
            }

            if($('#total_price_with_vat'+rowNo).val()){
                var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
            }else{
                swal("", "Please enter price in numbers only", "warning");
                brake = 1;
                $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                var newTotalPrice = 0;
            }

            if(parseFloat($('#sub_total').text()) > 0){
                var sub_total = parseFloat($('#sub_total').text());
            }else{
                var sub_total = 0;
            }

            //$('#sub_total').text((sub_total - newTotalPrice_old + newTotalPrice).toFixed(2));



            if((sub_total - newTotalPrice_old + newTotalPrice) > 0){
                var new_sub_total = (sub_total - newTotalPrice_old + newTotalPrice);
            }else{
                var new_sub_total = 0;
            }
            $('#sub_total').text(new_sub_total.toFixed(2));


            var vat_total = 0;
            if($('#proceeded_without_order_val').val() == 0){
                if($('#vat_exempt_val').val() != 'yes'){
                    var vat_rate = '<?php echo vat_rate; ?>';
                    var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                }
            }
            $('#vat_total').text(vat_total.toFixed(2));

            var grand_total = (vat_total + new_sub_total);
            $('#grand_total').text(grand_total.toFixed(2));


            $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
        }







        if(p == 1 || p == 0){


            var dataNo = i;
            var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');
            var print = p;




            $.ajax({
                type: "post",
                async: "true",
                url: mainUrl + "credits/Credits/checkMaxQty",
                cache: false,
                data: {
                    SerialNumber: SerialNumber
                },

                dataType: 'html',
                success: function (data) {
                    data = $.parseJSON(data);


                    if(print == 1){
                        order_qty = data.Print_Qty;
                        if(qty > order_qty){
                            $('#qtyInputPrint' + dataNo).val(order_qty);
                            swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                        }
                    }else{
                        order_qty = data.Quantity;
                        if(qty > parseInt(order_qty)){
                            $('#qtyInput' + dataNo).val(order_qty);
                            swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                        }
                    }
                    //me.data('requestRunning', false);

                },
                error: function () {
                    swal("Error!", "Error while request..", "error");
                    //me.data('requestRunning', false);
                }
            });
            var newQty = $('#qtyInput'+i).val();
        }else{
            if($('#qtyInput'+i).val()){
                var qty = parseFloat($('#qtyInput'+i).val());
            }else{
                swal("", "Please enter quantity in numbers only", "warning");

                $('#price_change_btn'+i).removeClass('disabledbutton');
                var qty = 0;
            }

            if($('#descriptionInput'+i).val()){
                var sadadsasdsa = parseFloat($('#descriptionInput'+i).val());
            }else{
                swal("", "Please enter description", "warning");
            }
        }

    }


    function checkMaxPrice(price, price_old, dataNo, SerialNumber, print, brake) {
        var me = $(this);
        if ( me.data('requestRunning') ) {
            return;
        }
        me.data('requestRunning', true);

        var val = 0;
        $.ajax({
            type: "post",
            async: "false",
            url: mainUrl + "credits/Credits/checkMaxPrice",
            cache: false,
            data: {
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                if(print == 1){
                    order_price = data.Print_Total * data.exchange_rate;
                    if(price > parseFloat(order_price)){
                        $('#total_price_with_vat_print' + dataNo).val(order_price);
                        //$('#total_price_with_vat_print_old' + dataNo).val(order_price);
                        swal("", "Sorry, max price you can credit is " + order_price+"", "warning");


                        var rowNo = dataNo;
                        var newTotalPrice_old = order_price;
                        var newTotalPrice = order_price;

                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        if((sub_total - price_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - price_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }

                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));




                        $('#total_price_with_vat_print_old'+rowNo).val(newTotalPrice);
                    }else{
                        var rowNo = dataNo;

                        if(brake == 1) {
                            $('#price_change_btn_print' + rowNo).removeClass('disabledbutton');
                        }else{
                            $('#price_change_btn_print' + rowNo).addClass('disabledbutton');
                        }

                        if($('#total_price_with_vat_print_old'+rowNo).val()){
                            var newTotalPrice_old = parseFloat($('#total_price_with_vat_print_old'+rowNo).val());
                        }else{
                            var newTotalPrice_old = 0;
                        }
                        if($('#total_price_with_vat_print'+rowNo).val()){
                            var newTotalPrice = parseFloat($('#total_price_with_vat_print'+rowNo).val());
                        }else{
                            var newTotalPrice = 0;
                        }
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        if((sub_total - newTotalPrice_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - newTotalPrice_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }

                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));


                        $('#total_price_with_vat_print_old'+rowNo).val(newTotalPrice);
                    }
                    me.data('requestRunning', false);
                }else{
                    order_price = data.Price * data.exchange_rate;
                    if(price > parseFloat(order_price)){
                        $('#total_price_with_vat' + dataNo).val(order_price);
                        //$('#total_price_with_vat_old' + dataNo).val(order_price);
                        swal("", "Sorry, max price you can credit is " + order_price+"", "warning");


                        var rowNo = dataNo;
                        var newTotalPrice_old = order_price;
                        var newTotalPrice = order_price;
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }

                        if((sub_total - price_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - price_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }

                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));



                        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                    }else{
                        var rowNo = dataNo;
                        if(brake == 1){
                            $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                        }else{
                            $('#price_change_btn'+rowNo).addClass('disabledbutton');
                        }



                        if($('#total_price_with_vat_old'+rowNo).val()){
                            var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                        }else{
                            var newTotalPrice_old = 0;
                        }
                        if($('#total_price_with_vat'+rowNo).val()){
                            var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                        }else{
                            var newTotalPrice = 0;
                        }
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        if((sub_total - newTotalPrice_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - newTotalPrice_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }
                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));


                        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                    }
                    me.data('requestRunning', false);
                }
            },
            error: function () {
                swal("Error!", "Error while request..", "error");
                me.data('requestRunning', false);
            }
        });

    }



    /*function price_change_func(i,p) {
        var rowNo = i;

        if(p==1){
            if($('#total_price_with_vat_print'+rowNo).val()){
                var newTotalPrice = parseFloat($('#total_price_with_vat_print'+rowNo).val());
            }else{
                var newTotalPrice = 0;
            }
        }else{
            if($('#total_price_with_vat'+rowNo).val()){
                var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
            }else{
                var newTotalPrice = 0;
            }
        }
        var price = newTotalPrice;
        var dataNo = i;
        var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');
        checkMaxPrice(price, dataNo, SerialNumber, p);


        if(p == -1){
            if($('#total_price_with_vat_old'+rowNo).val()){
                var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
            }else{
                var newTotalPrice_old = 0;
            }

            if($('#total_price_with_vat'+rowNo).val()){
                var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
            }else{
                var newTotalPrice = 0;
            }

            if(parseFloat($('#sub_total').text()) > 0){
                var sub_total = parseFloat($('#sub_total').text());
            }else{
                var sub_total = 0;
            }

            $('#sub_total').text((sub_total - newTotalPrice_old + newTotalPrice).toFixed(2));
            $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
        }

    }*/


    /*function checkMaxPrice(price, dataNo, SerialNumber, print) {
        var val = 0;
        $.ajax({
            type: "post",
            async: "false",
            url: mainUrl + "credits/Credits/checkMaxPrice",
            cache: false,
            data: {
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                if(print == 1){
                    order_price = data.Print_Total * data.exchange_rate;
                    if(price > parseFloat(order_price)){
                        $('#total_price_with_vat_print' + dataNo).val(order_price);
                        $('#total_price_with_vat_print_old' + dataNo).val(order_price);
                        swal("", "Sorry, max price you can credit is " + order_price+"", "warning");
                        val = 1;
                    }else{
                        val = 0;
                    }
                    if(val == 1){
                        var rowNo = dataNo;
                        var newTotalPrice_old = order_price;
                        var newTotalPrice = order_price;

                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }

                        var new_sub_total = sub_total - newTotalPrice_old + newTotalPrice;
                        if(new_sub_total > 0){
                            $('#sub_total').text((new_sub_total).toFixed(2));
                        }else{
                            $('#sub_total').text(0);
                        }

                        $('#total_price_with_vat_print_old'+rowNo).val(newTotalPrice);
                    }else{
                        var rowNo = dataNo;
                        if($('#total_price_with_vat_print_old'+rowNo).val()){
                            var newTotalPrice_old = parseFloat($('#total_price_with_vat_print_old'+rowNo).val());
                        }else{
                            var newTotalPrice_old = 0;
                        }
                        if($('#total_price_with_vat_print'+rowNo).val()){
                            var newTotalPrice = parseFloat($('#total_price_with_vat_print'+rowNo).val());
                        }else{
                            var newTotalPrice = 0;
                        }
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }
                        var new_sub_total = sub_total - newTotalPrice_old + newTotalPrice;
                        if(new_sub_total > 0){
                            $('#sub_total').text((new_sub_total).toFixed(2));
                        }else{
                            $('#sub_total').text(0);
                        }

                        $('#total_price_with_vat_print_old'+rowNo).val(newTotalPrice);
                    }
                }else{
                    order_price = data.Price * data.exchange_rate;
                    if(price > parseFloat(order_price)){
                        $('#total_price_with_vat' + dataNo).val(order_price);
                        $('#total_price_with_vat_old' + dataNo).val(order_price);
                        swal("", "Sorry, max price you can credit is " + order_price+"", "warning");
                        val = 1;
                    }else{
                        val = 0;
                    }

                    if(val == 1){
                        var rowNo = dataNo;
                        var newTotalPrice_old = order_price;
                        var newTotalPrice = order_price;
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        var new_sub_total = sub_total - newTotalPrice_old + newTotalPrice;
                        if(new_sub_total > 0){
                            $('#sub_total').text((new_sub_total).toFixed(2));
                        }else{
                            $('#sub_total').text(0);
                        }

                        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                    }else{
                        var rowNo = dataNo;
                        if($('#total_price_with_vat_old'+rowNo).val()){
                            var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                        }else{
                            var newTotalPrice_old = 0;
                        }
                        if($('#total_price_with_vat'+rowNo).val()){
                            var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                        }else{
                            var newTotalPrice = 0;
                        }
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        var new_sub_total = sub_total - newTotalPrice_old + newTotalPrice;
                        if(new_sub_total > 0){
                            $('#sub_total').text((new_sub_total).toFixed(2));
                        }else{
                            $('#sub_total').text(0);
                        }
                        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                    }
                }
            },
            error: function () {
                swal("Error!", "Error while request..", "error");
            }
        });

        return val;
    }*/


    function chBox(i) {
        var rowNo = i;
        //var newTotalPrice = $('#total_price_with_vat'+rowNo).val();
        if($('#total_price_with_vat'+rowNo).val() && $('#total_price_with_vat'+rowNo).val() > 0){
            var newTotalPrice = $('#total_price_with_vat'+rowNo).val();
        }else{
            var newTotalPrice = 0;
        }

        if($('#total_price_with_vat_print'+rowNo).val() && $('#total_price_with_vat_print'+rowNo).val() > 0){
            var newTotalPricePrint = $('#total_price_with_vat_print'+rowNo).val();
        }else{
            var newTotalPricePrint = 0;
        }

        var sub_total = parseFloat($('#sub_total').text());


        if ($('#checkbox'+i).is(':checked')) {
            //$('#price_change_btn'+rowNo).removeClass('disabledbutton');

            $('[data-report=' + rowNo + ']').attr('disabled', false);
            $('[data-qty=' + rowNo + ']').attr('disabled', false);
            $('[data-qtyPrint=' + rowNo + ']').attr('disabled', false);
            $('[data-inputPrice=' + rowNo + ']').attr('disabled', false);
            $('[data-inputPricePrint=' + rowNo + ']').attr('disabled', false);
            /*if($('#price_change_btn'+rowNo).hasClass('disabledbutton')){*/
                var deliver_charges_val = $('.deliver_charges_val').val();
                //var new_sub_total = sub_total + parseFloat(newTotalPrice) + parseFloat(newTotalPricePrint);


                if ((sub_total + parseFloat(newTotalPrice) + parseFloat(newTotalPricePrint)) > 0) {
                    new_sub_total = sub_total + parseFloat(newTotalPrice) + parseFloat(newTotalPricePrint);
                } else {
                    new_sub_total = 0;
                }

                $('#sub_total').text(new_sub_total.toFixed(2));
                $('#sub_total_currency').text($('#basic-addon' + rowNo).text());


                var vat_total = 0;
                if ($('#proceeded_without_order_val').val() == 0) {
                    if ($('#vat_exempt_val').val() != 'yes') {
                        var vat_rate = '<?php echo vat_rate; ?>';
                        var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                    }
                }


                $('#vat_total').text(vat_total.toFixed(2));

                var grand_total = (vat_total + new_sub_total);
                $('#grand_total').text(grand_total.toFixed(2));
            /*}*/

        } else {
            $('[data-report=' + rowNo + '] :selected').prop('selected', false);
            $('[data-report=' + rowNo + ']').attr('disabled', true);
            $('[data-qty=' + rowNo + ']').attr('disabled', true);
            $('[data-qtyPrint=' + rowNo + ']').attr('disabled', true);
            $('[data-inputPrice=' + rowNo + ']').attr('disabled', true);
            $('[data-inputPricePrint=' + rowNo + ']').attr('disabled', true);
            /*if($('#price_change_btn'+rowNo).hasClass('disabledbutton')){*/




                if((sub_total - parseFloat(newTotalPrice) - parseFloat(newTotalPricePrint)) > 0){
                    var new_sub_total = (sub_total - parseFloat(newTotalPrice) - parseFloat(newTotalPricePrint));
                }else{
                    var new_sub_total = 0;
                }
                $('#sub_total').text((new_sub_total).toFixed(2));


                var vat_total = 0;
                if($('#proceeded_without_order_val').val() == 0){
                    if($('#vat_exempt_val').val() != 'yes'){
                        var vat_rate = '<?php echo vat_rate; ?>';
                        var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                    }
                }
                $('#vat_total').text(vat_total.toFixed(2));

                var grand_total = (vat_total + new_sub_total);
                $('#grand_total').text(grand_total.toFixed(2));
            /*}*/



            //$('#price_change_btn'+rowNo).addClass('disabledbutton');
        }

    }

    function qtyChangePrint (i) {
        var qty = $('#qtyInputPrint'+i).val();
        var dataNo = i;
        var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');
        if (qty < 1) {
            $('#qtyInputPrint'+i).val(1);
        }

        var p=1;
        checkMaxQty(qty, dataNo, SerialNumber, p);
        var newQty = $('#qtyInputPrint'+i).val();
        //getPrice(ProductBrand, ManufactureID, newQty, batch, dataNo, labels, Print_Type, FinishType, Printing, SerialNumber, p);
    }
    function qtyChange(i,p) {
        if(p==0){
            var qty = $('#qtyInput'+i).val();
            /*if (qty < 1) {
                $('#qtyInput'+i).val(1);
            }*/
        }else{
            var qty = $('#qtyInputPrint'+i).val();
            /*if (qty < 1) {
                $('#qtyInputPrint'+i).val(1);
            }*/
        }
        var dataNo = i;
        var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');


        checkMaxQty(qty, dataNo, SerialNumber, p);
        var newQty = $('#qtyInput'+i).val();
        //getPrice(ProductBrand, ManufactureID, newQty, batch, dataNo, labels, Print_Type, FinishType, Printing, SerialNumber, p);
    }

    function checkMaxQty(qty, dataNo, SerialNumber, print) {
        $.ajax({
            type: "post",
            async: "true",
            url: mainUrl + "credits/Credits/checkMaxQty",
            cache: false,
            data: {
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);


                if(print == 1){
                    order_qty = data.Print_Qty;
                    if(qty > order_qty){
                        $('#qtyInputPrint' + dataNo).val(order_qty);
                        swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                    }
                }else{
                    order_qty = data.Quantity;
                    if(qty > parseInt(order_qty)){
                        $('#qtyInput' + dataNo).val(order_qty);
                        swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                    }
                }


            },
            error: function () {
                swal("Error!", "Error while request..", "error");
            }
        });
    }


    function getPrice(ProductBrand, ManufactureID, newQty, batch, dataNo, labels, Print_Type, FinishType, Printing, SerialNumber, p) {
        $.ajax({
            type: "post",
            async: "false",
            url: mainUrl + "tickets/addTickets/getPrice",
            cache: false,
            data: {
                ProductBrand: ProductBrand,
                ManufactureID: ManufactureID,
                newQty: newQty,
                batch: batch,
                labels: labels,
                Print_Type: Print_Type,
                FinishType: FinishType,
                Printing: Printing,
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                //console.log(data);
                if(p==1){
                    var UnitPrice = data.UnitPrice;
                    var TotalPrice = data.TotalPrice;
                    UnitPrice = parseFloat(UnitPrice).toFixed(2);
                    TotalPrice = parseFloat(TotalPrice).toFixed(2);
                    var curr = $('[data-currency=' + dataNo + ']').attr('value');
                    var sym;

                    if (curr == "GBP") {
                        sym = '&pound;';
                    }
                    else if (curr == "EUR") {
                        sym = '&euro;';
                    }
                    else if (curr == "USD") {
                        sym = '$';
                    }

                    $('[data-inputPrice=' + dataNo + ']').val(UnitPrice);
                    $('[data-newUnitPrice=' + dataNo + ']').attr('value', UnitPrice);
                    $('[data-newTotalPrice=' + dataNo + ']').attr('value', TotalPrice);
                    var rowNo = dataNo;
                    if($('#total_price_with_vat_old'+rowNo).val()){
                        var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                    }else{
                        var newTotalPrice_old = 0;
                    }

                    if($('#total_price_with_vat'+rowNo).val()){
                        var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                    }else{
                        var newTotalPrice = 0;
                    }

                    if(parseFloat($('#sub_total').text()) > 0){
                        var sub_total = parseFloat($('#sub_total').text());
                    }else{
                        var sub_total = 0;
                    }

                    $('#sub_total').text((sub_total - newTotalPrice_old + newTotalPrice).toFixed(2));
                    $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                }else{
                    var UnitPrice = data.UnitPrice;
                    var TotalPrice = data.TotalPrice;
                    UnitPrice = parseFloat(UnitPrice).toFixed(2);
                    TotalPrice = parseFloat(TotalPrice).toFixed(2);
                    var curr = $('[data-currency=' + dataNo + ']').attr('value');
                    var sym;

                    if (curr == "GBP") {
                        sym = '&pound;';
                    }
                    else if (curr == "EUR") {
                        sym = '&euro;';
                    }
                    else if (curr == "USD") {
                        sym = '$';
                    }

                    $('[data-inputPrice=' + dataNo + ']').val(UnitPrice);
                    $('[data-newUnitPrice=' + dataNo + ']').attr('value', UnitPrice);
                    $('[data-newTotalPrice=' + dataNo + ']').attr('value', TotalPrice);
                    var rowNo = dataNo;
                    if($('#total_price_with_vat_old'+rowNo).val()){
                        var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                    }else{
                        var newTotalPrice_old = 0;
                    }

                    if($('#total_price_with_vat'+rowNo).val()){
                        var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                    }else{
                        var newTotalPrice = 0;
                    }

                    if(parseFloat($('#sub_total').text()) > 0){
                        var sub_total = parseFloat($('#sub_total').text());
                    }else{
                        var sub_total = 0;
                    }

                    $('#sub_total').text((sub_total - newTotalPrice_old + newTotalPrice).toFixed(2));
                    $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                }

            },
            error: function () {
                swal("Error!", "Error while request..", "error");
            }
        });
    }


    $('.fault').change(function () {
        var dr = $(this).attr('data-report');
        $('#report_err' + dr).hide();
        var chk_len = $('input.chBox:checkbox:checked').length;
        var countselect = $("select.fault option[value!='']:selected").length;
        if (chk_len == countselect) {
            $('#sub').attr('type', 'submit');
        }
    });


    var filesArray = [];
    function ck(input,placeToInsertImagePreview){

        var filesLength = input.files.length;

        for (var i = 0; i < filesLength; i++) {
            var fileReader = new FileReader();
            var fc = 0;
            fileReader.onload = function(e) {

                $($.parseHTML('<span class="pip"><img class="imageThumb" id="cld'+fc+'"  src=""><br><span class="remove" data-del="'+fc+'">Remove image</span></span>')).appendTo(placeToInsertImagePreview);
                $('#cld'+fc).attr('src', e.target.result);
                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });

                fc++;
            }

            filesArray.push(input.files[i]);
            fileReader.readAsDataURL(input.files[i]);
        }
        $('#vmb').removeClass('erss');
    }

    function removeFile( index ){
        filesArray.splice(index, 1);
    }

    $(document).on('click', '.remove',function(e){

        var image = $(this).attr('data-del');
        //console.log(image+' Image id');
        //console.log(image.index());
        // Remove the image from the array by getting it's index.
        // NOTE: The order of the filesArray will be the same as you see it displayed, therefore
        //       you simply need to get the file's index to "know" which item from the array to delete.

        //console.log('Files:' ,filesArray);
        removeFile(image);
        //console.log('Files:' ,filesArray);
        $(this).remove();
        $('#ticketImage').val(filesArray);
    });




    $('.inputPrice').change(function () {
        var data_id = $(this).attr('data-inputPrice');
        var newPr = $(this).val();
        var UnitPrice = parseFloat(newPr);
        UnitPrice = UnitPrice.toFixed(2);
        var TotalPrice = parseFloat(newPr) * parseFloat(1.2);
        TotalPrice = TotalPrice.toFixed(2);
        $('[data-newUnitPrice=' + data_id + ']').attr('value', UnitPrice);
        $('[data-newTotalPrice=' + data_id + ']').attr('value', TotalPrice);
    });






    $("#ticketImage").on("change", "input", function(event){
        $('#ticketImageC').append('<input id="ticketImage" type="file" name="ticketImage[]"/>')
    });



</script>

<script>










    function delete_from_lisiting(file,token,id){

        var conf =confirm("You are about to delete photo?");
        if(conf){
            $.ajax({
                url: mainUrl + 'tickets/addTickets/delete_from_printing_files/',
                type:"POST",
                async:"false",
                dataType: "html",
                data: {
                    file:file,
                    token:token
                },
                success: function(data){
                    if(id!=''){
                        $('#image_box_'+id).remove();
                    }
                }

            });
        }
    }




    $("#phototab-dropzone1").dropzone({

        url: mainUrl + "tickets/addTickets/upload_printing_files",
        acceptedFiles: 'image/*',
        init: function() {


            this.on('sending', function(file, xhr, formData){
                var token = $('#token').val();
                formData.append('token', token);
                formData.append('type','ticketImage');
            });

            this.on("success", function(file, responseText) {

                if(responseText!='error'){
                    var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span></div>');

                    var _this = this;
                    removeButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var token = $('#token').val();
                        delete_from_lisiting(responseText,token);
                        _this.removeFile(file);
                    });
                    file.previewElement.appendChild(removeButton);
                }
            });
        },

    });

    $("#phototab-dropzone2").dropzone({
        acceptedFiles: 'image/*',
        url: mainUrl + "tickets/addTickets/upload_printing_files",
        init: function() {



            this.on('sending', function(file, xhr, formData){
                var token = $('#token').val();
                formData.append('token', token);
                formData.append('type','ticketEmail');
            });

            this.on("success", function(file, responseText) {

                if(responseText!='error'){
                    var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span></div>');

                    var _this = this;
                    removeButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var token = $('#token').val();
                        delete_from_lisiting(responseText,token);
                        _this.removeFile(file);
                    });
                    file.previewElement.appendChild(removeButton);
                }
            });
        },

    });

    $("#phototab-dropzone3").dropzone({

        url: mainUrl + "tickets/addTickets/upload_printing_files",
        acceptedFiles: 'audio/*',
        init: function() {

            this.on('sending', function(file, xhr, formData){
                var token = $('#token').val();
                formData.append('token', token);
                formData.append('type','ticketAudio');
            });



            this.on("success", function(file, responseText) {

                if(responseText!='error'){
                    var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span></div>');

                    var _this = this;
                    removeButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var token = $('#token').val();
                        delete_from_lisiting(responseText,token);
                        _this.removeFile(file);
                    });
                    file.previewElement.appendChild(removeButton);
                }
            });
        },

    });


    $(document).ready(function () {

        $(document).on('change', '.qty_price_change', function(e) {
            e.preventDefault();
            if($(this).attr('data-qty')){
                var rowNo = $(this).attr('data-qty');
            }else{
                var rowNo = $(this).attr('data-inputPrice');
            }
            $('#price_change_btn'+rowNo).removeClass('disabledbutton');

            var total_price_with_vat = $('#total_price_with_vat'+rowNo).val();

            if(total_price_with_vat > 0){
                total_price_with_vat = total_price_with_vat;
            }else{
                total_price_with_vat = 0;
            }
            $('#total_price_with_vat'+rowNo).val(parseFloat(total_price_with_vat).toFixed(2));
        });


        $(document).on('change', '.qty_price_change_print', function(e) {
            e.preventDefault();
            if($(this).attr('data-qtyPrint')){
                var rowNo = $(this).attr('data-qtyPrint');
            }else{
                var rowNo = $(this).attr('data-inputPricePrint');
            }
            $('#price_change_btn_print'+rowNo).removeClass('disabledbutton');

            var total_price_with_vat_print = $('#total_price_with_vat_print'+rowNo).val();

            if(total_price_with_vat_print > 0){
                total_price_with_vat_print = total_price_with_vat_print;
            }else{
                total_price_with_vat_print = 0;
            }
            $('#total_price_with_vat_print'+rowNo).val(parseFloat(total_price_with_vat_print).toFixed(2));
        });
    });


</script>





<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>