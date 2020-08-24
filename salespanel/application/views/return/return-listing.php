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
                                            <h3 class="m-b-10 number-listed" id="open_ticket_counter">0</h3>
                                            <p class="text-uppercase m-b-5 number-listed-title">Open Tickets</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-md-4 m-t-t-10">
                                        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
                                            <h3 class="m-b-10 number-listed" id="over_ticket_counter">0</h3>
                                            <p class="text-uppercase m-b-5 number-listed-title">Closed Tickets</p>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-md-4 m-t-t-10">
                                        <a href="<?= main_url ?>tickets/addTickets">
                                            <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
                                                <h3 class="m-b-10 number-listed"><i
                                                            class="mdi mdi-shape-circle-plus"></i>
                                                </h3>
                                                <p class="text-uppercase m-b-5 number-listed-title-1">Add New Ticket</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-7 col-xs-12 pull-right">

                                <table width="100%" border="0" align="right" cellspacing="50px">
                                    <form method="post" class="labels-form"
                                          action="<?= main_url ?>tickets/returns/make_csv">
                                        <tr>
                                            <td colspan="3" class="p-t-10"><b>Report Filters</b></td>
                                        </tr>
                                        <tr>
                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!--<input type="date" name="rep_to" id="rep_to" required>-->
                                                        <input type="text" value="" name="rep_to" id="rep_to"
                                                               class="form-control input input-border-blue"
                                                               data-toggle="datepicker" placeholder="dd/mm/yyy" required
                                                               onkeydown="return false" autocomplete="off"
                                                               style="cursor:pointer">
                                                    </label></div>
                                            </td>
                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                                                        <input type="text" value="" name="rep_from" id="rep_from"
                                                               class="form-control input input-border-blue"
                                                               data-toggle="datepicker" placeholder="dd/mm/yyy" required
                                                               onkeydown="return false" autocomplete="off"
                                                               style="cursor:pointer">
                                                    </label>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="labels-form">
                                                    <label class="select">
                                                        <select name="rep_area" id="rep_area" class="input-border-blue">
                                                            <option value="">Select Area Responsible</option>
                                                            <option value="all">Show All</option>
                                                            <option value="Design Team">Design Team</option>
                                                            <option value="Data Team">Data Team</option>
                                                            <option value="Developement">Developement</option>
                                                            <option value="Printing">Printing</option>
                                                            <option value="Production">Production</option>
                                                            <option value="Despatch and QC">Despatch & QC</option>
                                                            <option value="Courier">Courier</option>
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
                                                    <label class="select ">
                                                        <select name="rep_format" id="rep_format"
                                                                class="input-border-blue">

                                                            <option value="">Select Sheets/Rolls</option>
                                                            <option value="all">Show All</option>
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


                                            <td class="p-t-10-td-r">
                                                <div class=" labels-form">
                                                    <label class="select input-border-blue">
                                                        <select name="rep_status" id="rep_status"
                                                                class="input-border-blue">
                                                            <option value="">Select Status</option>
                                                            <option value="all">Show All</option>
                                                            <option value="0"><b>Open</b> – <p>UnderInvestigation</p>
                                                            </option>
                                                            <option value="1"><b>Open</b> – <p>Awaiting Info from
                                                                    Customer</p></option>
                                                            <option value="2"><b>Open</b> – <p>Reffered for Desicion</p>
                                                            </option>
                                                            <option value="3"><b>Open</b> – <p>Reffered back to
                                                                    Action</p></option>
                                                            <option value="4"><b>Closed</b></option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </div>
                                            </td>
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
                                <th class="no-border">Ticket #</th>
                                <th class="no-border">Order #</th>
                                <!--<th class="no-border">Type</th>-->
                                <th class="no-border">Format</th>
                                <th class="no-border">Created By</th>
                                <th class="no-border">Customer / Country</th>
                                <th class="no-border">Referred to</th>
                                <th class="no-border">Follow Up Date</th>
                                <th class="no-border">Area Responsible</th>
                                <th class="no-border">Price</th>
                                <th class="no-border">Status</th>
                                <th class="no-border">Reason</th>

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
    $(document).ready(function () {
        fetch_top_counter();

        var url_cal1 = mainUrl + 'tickets/returns/getAllTicketsData';
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
            "bFilter": false,
            "bLengthChange": false,
					  


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
                        if (row[12] == 0) {
                            //t_id = "<span class='orange-text'>"+row[11]+" <i class='fa fa-bell red-bell'></i></span>";
                            t_id = '<a class="orange-text" href="' + mainUrl + 'tickets/updateTicket/index/' + row[0] + '"> <b> ' + row[11] + '</b></a>';
                        } else {
                            t_id = '<a   class="orange-text" href="' + mainUrl + 'tickets/updateTicket/index/' + row[0] + '"><b>' + row[11] + '<i class="fa fa-bell red-bell"></i></b></a>';
                            //t_id = "<span class='orange-text'>"+row[11]+"</span>";
                        }
                        return t_id;
                    }
                },
                {
                    "render": function (data, type, row) {

                        var array = row[1];
                        if (array) {
                            //alert(array);
                            array = array.replace(/ *, */g, '<br>');
                            return array;
                        } else {
                            return '---';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        var array = row[2];
                        if (array) {
                            array = array.replace(/ *, */g, '<br>');
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
                        var name = '<p><b>( ' + row[4] + ' )</b></p>';
                        return row[3] + '<br>' + name;
                    }
                },
                {
                    "render": function (data, type, row) {
                        if (row[5]) {
                            var array = row[5].split(",");
                            //array = array.replace(/ *, */g, '<br>');
                            var n = array[0] + '<p>' + '<b>( ' + array[1] + ' )</b><p>';
                            return n;
                        } else {
                            return '--';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        var reffD = row[6];
                        var re_to = row[14];
                        var n;
                        //alert(reffD+"--"+re_to);

                        if ((row[14] == null || row[14] == "") && (row[6] == null || row[6] == "")) {
                            n = "<p><b>--------</b></p>";
                        } else {
                            n = row[14] + "<p><b>( " + reffD + " )</b></p>";
                        }
                        //var n = reffName+"<p><b>( "+reffD+" )</b></p>";
                        return n;
                    }
                },
                {
                    "render": function (data, type, row) {
                        var f_date = false;
                        var is_ex = false;
                        var re_com = '';
                        if (row[16] != "01/01/1970" && row[16] != "" && row[16] != null) {
                            f_date = row[16];
                            is_ex = true;
                        }
                        if (row[17] != "" && row[17] != null) {
                            re_com = row[17];
                        }
                        var n = "";

                        if (is_ex && re_com) {
                            n = "<b>" + f_date + "<p class='re_comments' data-re_tid=" + row[0] + "><b style='cursor:pointer' class='orange-text'>View Comment</b></p>";
                        }
                        else {
                            n = '-------';
                        }
                        return n;
                    }
                },
                {
                    "render": function (data, type, row) {
                        $ar = false;
                        $arc = false;
                        //alert(row[18]);
                        //alert(row[19]);
                        if (row[18] != "" && row['18'] != null) {
                            $ar = true;
                        }
                        if (row[19] != "" && row['19'] != null) {
                            $arc = true;
                        }
                        var n = '';
                        if ($ar && $arc) {
                            n = "<b>" + row[18] + "</b><p style='cursor:pointer' class='area_resp_comments' data-re_tid=" + row[0] + "><b  class='orange-text'>View Notes</b></p>";
                        } else if ($ar) {
                            n = "<b>" + row[18] + "</b>";
                        } else if ($arc) {
                            n = "<p class='area_resp_comments' style='cursor:pointer' data-re_tid=" + row[0] + "><b class='orange-text'>View Notes</b></p>";
                        } else {
                            n = '-----';
                        }

                        return n;

                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        if (row[9]) {
                            var array = row[9].split(",");
                            var sym;
                            if (array[0] == "GBP") {
                                sym = '£';
                            }
                            else if (array[0] == "EUR") {
                                sym = '€';
                            }
                            else if (array[0] == "USD") {
                                sym = '$';
                            }

                            var am = $.trim(array[1]);

                            var n = sym + am

                            //alert(am+'----'+n);

                            return "<span class='comment-text'>" + n + "</span>";
                        } else {
                            return '--';
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        var status = '<b>Open</b> – Under<p>Investigation</p>';
                        if (row[10] == 1) {
                            status = '<b>Open</b> – <p>Awaiting Info from Customer</p>';
                        } else if (row[10] == 2) {
                            status = '<b>Open</b> – <p>Reffered for Desicion</p>';
                        } else if (row[10] == 3) {
                            status = '<b>Open</b> – <p>Reffered back to Action</p>';
                        } else if (row[10] == 4) {
                            status = '<b>Closed<br>( ' + row[13] + ' )</b>';
                        }
                        return "<span>" + status + "</span>";
                    }
                },
                {
                    "render": function (data, type, row) {

                        if (row[15]) {
                            var n = "<p style='cursor:pointer' class='reson_comments' data-re_tid=" + row[0] + "><b class='orange-text'>View Comment</b></p>";
                        } else {
                            var n = "---------";
                        }

                        return n;
                    }
                },
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
            url: mainUrl + "tickets/returns/fetch_top_counter",
            cache: false,
            data: {},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#open_ticket_counter').html(data.open);
                $('#over_ticket_counter').html(data.overdue);
                $('#total_tickects').val(data.total_tickets);
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

