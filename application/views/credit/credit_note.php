<style>
    .tickets-list a {
        color: #fd4913;
        white-space: nowrap;
    }

    .input {
        color: transparent !important;
        text-shadow: 0 0 0 #817d7d;
    }

    .input:focus {
        outline: none;
    }
</style>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg">
                        <div class="row no-margin">
                            <?php

                            /*echo $actual_link = "http://gtserver/aasalespanel/index.php///"; echo '<br>';

                            echo $actual_link =  rtrim($actual_link,'/');echo '<br>';
                            $result = explode('index.php',$actual_link);
                            print_r($result);
                            $part2 = $result[1];

                            print_r(count($result));*/

                            ?>

                            <div class="col-md-5 col-xs-12 pull-left">
                                <input type="hidden" id="total_tickects"/>
                                <input type="hidden" id="start_limit" value="0"/>
                                <div class="row">

                                    <div class="col-xs-12 col-md-4 m-t-t-10">
                                        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
                                            <h3 class="m-b-10 number-listed" id="total_credits_counter">0</h3>
                                            <p class="text-uppercase m-b-5 number-listed-title">Total Credit Notes</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-md-4 m-t-t-10">
                                        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
                                            <h3 class="m-b-10 number-listed" id="total_pending_credits_counter">0</h3>
                                            <p class="text-uppercase m-b-5 number-listed-title">Pending Credit Notes</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-md-4 m-t-t-10">
                                        <a href="<?php echo main_url ?>credit-notes/add">
                                            <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
                                                <h3 class="m-b-10 number-listed"><i
                                                            class="mdi mdi-shape-circle-plus"></i>
                                                </h3>
                                                <p class="text-uppercase m-b-5 number-listed-title-1">Add New Credit Note</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-7 col-xs-12 pull-right">

                                <table width="100%" border="0" align="right" cellspacing="50px">
                                    <form method="post" class="labels-form" action="<?php echo main_url ?>credits/Credits/make_csv">
                                        <tr>
                                            <td colspan="3" class="p-t-10"><b>Report Filters</b></td>
                                        </tr>
                                        <tr>
                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                                                        <input type="text" value="" name="rep_from" id="rep_from"
                                                               class="form-control input input-border-blue"
                                                               data-toggle="datepicker" placeholder="Select Start Date" required
                                                               onkeydown="return false" autocomplete="off"
                                                               style="cursor:pointer">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!--<input type="date" name="rep_to" id="rep_to" required>-->
                                                        <input type="text" value="" name="rep_to" id="rep_to"
                                                               class="form-control input input-border-blue"
                                                               data-toggle="datepicker" placeholder="Select End Date"
                                                               onkeydown="return false" autocomplete="off"
                                                               style="cursor:pointer">
                                                    </label></div>
                                            </td>
                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="select ">
                                                        <select name="rep_format" id="rep_format" class="input-border-blue">

                                                            <option value="">Select Sheets/Rolls</option>
                                                            <option value="">Show All</option>
                                                            <?php foreach ($formats as $farmat) { ?>
                                                                <?php if (!empty($farmat['ProductBrand'])) { ?>
                                                                    <option value="<?php echo $farmat['ProductBrand'] ?>"><?php echo strtoupper($farmat['ProductBrand']); ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php //echo '<pre>'; print_r($formats); echo '</pre>'; ?>
                                        <tr>



                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="select input-border-blue">
                                                        <select name="rep_status" id="rep_status"
                                                                class="input-border-blue">
                                                            <option value="">Select Status</option>
                                                            <option value="">Show All</option>
                                                            <option value="0">Not Approved</option>
                                                            <option value="1">Approved</option>
                                                            <option value="2">Declined</option>
                                                            <option value="3">Sent</option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <!--<td></td>-->
                                            <td>
                                                <!-- <a href="javascript:void(0);"
                                                    class="btn ResetButton reset_button new-button-style" role="button">Download Reports</a>-->
                                                <button class="btn ResetButton new-button-style btn-block"
                                                        type="submit" style="margin-top: 10px;height: 35px !important;padding: 0 !important;">Download Report
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                </table>

                                <?php if ($this->session->flashdata('msg') != "") { ?>
                                    <div class="alert alerts-custom alert-dismissible fade show sweet-alert"
                                         role="alert"
                                         style="width: 100%; float: right; margin: 0 !important; padding: 12px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <span>Record not found</span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <?php //$total_attach = $this->Return_model->fetch_top_counter(); print_r($total_attach); ?>
                        <table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive  artwork-table-row-adjust return-table"
                               cellspacing="0" width="100%" id="datatable">
                            <thead class="artwork-thead">
                            <tr>
                                <th class="no-border">Credit Note #</th>
                                <th class="no-border">Reference #</th>
                                <th class="no-border">Type</th>
                                <th class="no-border">Amount</th>
                                <th class="no-border">Customer</th>
                                <th class="no-border">Phone</th>
                                <th class="no-border">Operator</th>
                                <th class="no-border">Date / Time</th>
                                <th class="no-border">Print</th>
                                <th class="no-border">Status</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>

<div class="modal fade bs-example-modal-lg comment-modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background" id="comments_modal_data"></div>
    </div>
</div>

<script>
    function creditNoteDetails(id) {
        window.location.href = '<?php echo main_url ?>credits/Credits/changeUpdateStatus/' + id;
        //window.location.href = '<?php echo main_url ?>credit-notes/detail/' + id;
    }
    $(document).ready(function () {
        fetch_top_counter();

        var url_cal1 = mainUrl + 'credits/Credits/getCreditNoteTicketsData';
        $('#datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "sAjaxSource": url_cal1,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            "bFilter": true,
            "bLengthChange": true,

            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            },


            "aoColumns": [

                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        var t_id;
                        if (row[2] == 0) {
                            var bell='';
                        } else {
                            var bell='<i class="fa fa-bell red-bell"></i>';
                        }
                        /*t_id = '<a class="orange-text" href="' + mainUrl + 'credit-notes/detail/' + row[0] + '"><b>'+row[1]+' '+bell+'</b></a>';*/
                        t_id = '<a class="orange-text" onclick="creditNoteDetails('+row[0]+')"><b>'+row[1]+' '+bell+'</b></a>';
                        return t_id;
                    }
                },
                {
                    "render": function (data, type, row) {

                        var array = row[3];
                        if (array) {
                            array = array.replace(/ *, */g, '<br>');
                            array = array.replace('<br>0', '');
                            array = array.replace('0<br>', '');
                            if(array == 0){
                                array='---';
                            }
                            return array;
                        } else {
                            return '---';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        var array = row[11];
                        if (array) {
                            array = array.replace(/ *, */g, '<br>');
                            array = array.replace('<br>0', '');
                            array = array.replace('0<br>', '');
                            //return array;

                            //return 'Printed Sheet<p><b>( '+array+' )</b></p>';
                            return '<p><b>( ' + array + ' )</b></p>';
                        } else {
                            return '--';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        if (row[4]) {
                            var array = row[4].split(",");
                            var sym;
                            if (array[0] == "GBP") {
                                sym = '£ ';
                            }
                            else if (array[0] == "EUR") {
                                sym = '€ ';
                            }
                            else if (array[0] == "USD") {
                                sym = '$ ';
                            }

                            var am = parseFloat($.trim(array[1])) + parseFloat(row[12]);

                            var n = ' '+sym + am.toFixed(2);

                            //alert(am+'----'+n);

                            return "<span class='comment-text'>" + n + "</span>";
                        } else {
                            return '--';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        var name = '<p><b>' + row[5] + '</b></p>';
                        return name;
                    }
                },
                {
                    "render": function (data, type, row) {
                        var name = '<p><b>' + row[6] + '</b></p>';
                        return name;
                    }
                },
                {
                    "render": function (data, type, row) {
                        var name = '<p><b>' + row[7] + '</b></p>';
                        return name;
                    }
                },
                {
                    "render": function (data, type, row) {
                        return row[8];
                    }
                },
                {
                    "render": function (data, type, row) {
                        n='---';
                        if (row[10] > 0 && row[10] != 2) {
                            n = '<a class="orange-text" href="' + mainUrl + 'credits/Credits/printCreditNote/' + row[0] + '" class="btn btn-default btn-number pdf-download-btn fa-2x" rel="nofollow"\n' +
                                '                        data-toggle="tooltip" title="Download PDF Template" role="button"><i class="mdi mdi-file-pdf"></i></a>';
                        }
                        return n;
                    }
                },

                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        var status = '<p>Waiting for Approval</p>';
                        if (row[10] == 1) {
                            status = '<p>Approved and Credit Note Generated</p>';
                        } else if (row[10] == 2) {
                            status = '<p>Declined</p>';
                        } else if (row[10] == 3) {
                            status = '<p>Sent</p>';
                        }
                        return "<span>" + status + "</span>";
                    }
                }
            ],


            "fnInitComplete": function () {

            },

            'fnServerData': function (sSource, aoData, fnCallback) {
                $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },


            'createdRow': function (row, data, dataIndex) {
                $(row).removeClass('odd');
                $(row).addClass('artwork-tr');
            },


        });


    });

    function fetch_top_counter() {
        $.ajax({
            type: "post",
            url: mainUrl + "credits/Credits/fetch_top_counter",
            cache: false,
            data: {},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#total_credits_counter').html(data.total);
                $('#total_pending_credits_counter').html(data.total_pending);
                $('#total_tickects').val(data.total);
            },
            error: function () {
                alert('Error while request..');
            }
        });
    }


    /*setInterval(function(){
   var total = parseInt($('#total_tickects').val());
   var start = parseInt($('#start_limit').val());
   if(start < total ){
     fetch_tickets();
    }
 }, 2000);*/

    function fetch_tickets() {
        var total = parseInt($('#total_tickects').val());
        var start = parseInt($('#start_limit').val());
        start = start + 1;
        $.ajax({
            type: "post",
            url: mainUrl + "tickets/returns/fetch_tickets",
            cache: false,
            data: {start: start},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#ticket-body').append(data.html);
                $('#start_limit').val(start);
            },
            error: function () {
                alert('Error while request..');
            }
        });
    }


    $(document).on("click", ".reson_comments", function (e) {
        var tid = $(this).attr('data-re_tid');
        //alert(tid);

        $('#aa_loader').show();


        $.ajax({
            type: "post",
            url: mainUrl + "tickets/Returns/comment_controller",
            cache: false,
            data: {
                tid: tid
            },
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#comments_modal_data').html(data.html);
                //$('#maked_comments_'+order).hide();
                $('.comment-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });


    $(document).on("click", ".re_comments", function (e) {
        var tid = $(this).attr('data-re_tid');
        //alert(tid);

        $('#aa_loader').show();


        $.ajax({
            type: "post",
            url: mainUrl + "tickets/Returns/re_comment_controller",
            cache: false,
            data: {
                tid: tid
            },
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#comments_modal_data').html(data.html);
                //$('#maked_comments_'+order).hide();
                $('.comment-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });


    $(document).on("click", ".area_resp_comments", function (e) {
        var tid = $(this).attr('data-re_tid');
        //alert(tid);

        $('#aa_loader').show();


        $.ajax({
            type: "post",
            url: mainUrl + "tickets/Returns/area_comment_controller",
            cache: false,
            data: {
                tid: tid
            },
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#comments_modal_data').html(data.html);
                //$('#maked_comments_'+order).hide();
                $('.comment-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });


</script>

<script>
    $(function () {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2000,
            format: 'dd/mm/yyyy'
        });
    });
</script>

