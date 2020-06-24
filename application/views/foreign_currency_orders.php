<style type="text/css">

    .conversions-span {

        padding: 0px 10px !important;

    }



    .f-right {

        float: right !important;

    }



    .adjust-calender {

        margin-top: 0.5rem !important;

    }



    .input_field_design {

        border: 1px solid #49d0fe !important;

        background-color: #fff !important;

    }



    .remove_input_field_design {

        border: 0 !important;

        background-color: transparent !important;

    }



    }

    .editable {

        cursor: pointer !important;

    }
    .date-foreign-currency-input{
        margin-right: 0px;
        border: 1px solid #49d0fe !important;
        background-color: #fff !important;
        border-radius: 4px;
        padding: 3px 5px;
        height: 35px;
        color: #666 !important;
    }

</style>

<div class="wrapper">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card table-responsive">

                    <div class="card-header card-heading-text">

                        <span class="text-left">FOREIGN CURRENCY</span>
                        <span class="pull-right" style="display: inline-flex;">
                        <form method="post" id="checkout_form" class="labels-form" enctype="multipart/form-data"

                              action="">

                            <span class="pull-right" style="display: inline-flex;">

         <label class="input m-r-b-0">

         <!-- <i class="icon-append  fa-calendar"></i>

         <input type="date" name="start_date" placeholder="Start Date" id="start_date" class="required" aria-required="true" onchange="search();"> -->

             <div class=" labels-form">

                <label class="input"> <i class="icon-append fa fa-calendar"></i>

                    <!-- <input type="date" name="rep_from" id="rep_from" required>-->

                <input type="text" value="" name="start_date" id="start_date" class="form-control"

                       data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false"

                       onchange="search();">

                </label>

            </div>

         </label>
         <label class="input m-r-b-0"> 

            <!-- <i class="icon-append  fa-calendar"></i>

            <input type="date" name="end_date" placeholder="End Date" id="end_date" class="required" aria-required="true" onchange="search();"> -->

            <div class=" labels-form">

                <label class="input"> <i class="icon-append fa fa-calendar"></i>

                    <!-- <input type="date" name="rep_from" id="rep_from" required>-->

                <input type="text" value="" name="end_date" id="end_date" class="form-control" data-toggle="datepicker"

                       placeholder="dd/mm/yyy" required onkeydown="return false" onchange="search();">

                </label>

            </div>

         </label>
         <label class="select m-r-b-0">

                                <select name="currency" id="currency" class="required" onchange="search();">

                                <option value="ALL">Please Select Currency</option>

                                        <option value="EUR">EUR</option>

                                    <option value="USD">USD</option>

                                </select>

                                <i></i> </label>
         <label class="select m-r-b-0">

                                <select name="filter" id="filter" class="required" onchange="search();">

                                    <option value="0-asc">Order No Ascending</option>

                                    <option value="0-desc">Order No Descending</option>

                                </select>

                                <i></i> </label>

            </span>
        </form>
                            <div class="btn-group-vertical mb-2">
                                        <button type="button"
                                                class="btn btn-orange-download dropdown-toggle waves-effect"
                                                data-toggle="dropdown" aria-expanded="false"> Download Report<span
                                                    class="caret"></span> </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2"
                                             x-placement="bottom-start"
                                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(870px, 1165px, 0px);">
                                            <a class="dropdown-item" href="#"
                                               onclick="exportFile('<?php echo main_url ?>foreign_currency_orders/exportExcel')">Export Excel</a>
                                            <!--  target="_blank"-->
                                            <a class="dropdown-item" href="#"
                                              onclick="exportFile('<?php echo main_url ?>foreign_currency_orders/exportPDF');">Export PDF</a>
                                        </div>
                                    </div>
                            </span>
                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable"
                               class="table table-bordered table-bordered dt-responsive nowrap text-center"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="7.14%">Order No</th>
                                <th style="7.14%">Payment / </br>Refund Date</th>
                                <th style="7.14%">Source</th>
                                <th style="7.14%">Customer</th>
                                <th style="7.14%">Billing </br>PCode</th>
                                <th style="7.14%">Delivery </br>PCode</th>
                                <th style="7.14%">Billing </br>Country</th>
                                <th style="7.14%">Payment </br>Method</th>
                                <th style="7.14%">Currency</th>
                                <th style="7.14%">Order </br>Amount</th>
                                <th style="7.14%">Received </br>Amount (&pound;)</th>
                                <th style="7.14%">Received </br>Date</th>
                                <th style="7.14%">Conversion </br>Rate</th>
                                <th style="7.14%">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>
<!-- en wrapper -->
<script type="text/javascript">

    function exportFile(url) {

        document.getElementById('checkout_form').action = url;

        document.getElementById('checkout_form').method = 'POST';

        document.getElementById('checkout_form').submit();

    }

    function showEditBtn(id, amt, date, edit_id) {
        $('#' + id).show();
        $('#' + amt).addClass('input_field_design').removeClass('remove_input_field_design');
        $('#' + amt).attr("readonly", false);
        $('#' + date).addClass('date-foreign-currency-input').removeClass('remove_input_field_design');
        $('#' + date).attr("disabled", false);
        $('#' + edit_id).hide();
    }

    function search() {
        if ($('#currency').val() != '')
            var currency = $('#currency').val();
        else
            var currency = 'ALL';
        if ($('#filter').val() != '')
            var filter = $('#filter').val();
        else
            var filter = '';
        if ($('#start_date').val() != '')
            var start_date = $('#start_date').val();
        else
            var start_date = '';
        if ($('#end_date').val() != '')
            var end_date = $('#end_date').val();
        else
            var end_date = '';
        var formData = {
            "currency": currency,
            "start_date": start_date,
            "end_date": end_date
        }
        var res = filter.split("-");
        var datatable = $('#responsive-datatable').DataTable({

            "destroy": true,

            "processing": true,

            "serverSide": false,
            "pageLength": 25,

            "iDisplayStart ": 20,

            "iDisplayLength": 10,
           "order": [res[0]],

            "columnDefs": [{}],

            
            "ajax": {

                "url": mainUrl + "foreign_currency_orders/getOrder",

                "type": "POST",

                "data": formData

            } 
        });
      

        $("#responsive-datatable_processing").show();

        $(".dataTables_empty").hide();

    
        $('#responsive-datatable').on('error.dt', function (e, settings, techNote, message) {

            console.log('An error has been reported by DataTables: ', message);

        });

            }



    $(document).ready(function () {

        search();
    
    });

    function sumTotalVal(rate, resultField, val) {

        var re = eval(rate) / eval(val);

        re = re.toFixed(5);

        $("#" + resultField).val(re);
    }

    function updartdata(id) {

        //alert('AAAAAAA');

        if ($("#amount_" + id).val() == '') {

            amt = '';

        }

        else if ($("#amount_" + id).val() == '0') {

            amt = '';

        }

        else if ($("#amount_" + id).val() == '0.00') {

            amt = '';

        }

        else {

            amt = $("#amount_" + id).val();

        }
        if ($("#date_" + id).val() == '') {  

        }
         
        var formData = {

            "OrderID": id,

            "Balance": amt,

            "BalanceDate": $("#date_" + id).val()
        }
        var date = $('#date_' + id).val();
        if (date == '' || date == null) {
            show_popover('#date_' + id,'Please Enter Date');
            return false;
        }
        var balance =  $('#amount_' + id).val();
        if (balance == '' || balance == null || balance == '0.00') {
            show_popover('#amount_' + id,'Please Enter Amount');
            return false;
        }
        $.ajax({

            type: "post",

            url: mainUrl + "foreign_currency_orders/updateOrder",

            cache: false,

            data: formData,

            dataType: 'html',

            success: function (data) {
               
                swal('Success',' Record Updated Successfully ','success');
                $('#aa_loader').hide();

                $("#update_" + id).hide();
                $("#cancel_" + id).hide();

                $('#amount_' + id).addClass('remove_input_field_design').removeClass('input_field_design');

                $('#amount_' + id).attr("readonly", true);

                $('#date_' + id).attr("disabled", true);
                $('#date_' + id).addClass('date-foreign-currency-input').removeClass('date-foreign-currency-input');
                $("#edit_" + id).show();
            },

            error: function () {
                swal('error','Error while request..','error'); 
            }
        });
    }

    $(function () {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2000,
            format: 'dd/mm/yyyy'
        });
    });

</script>