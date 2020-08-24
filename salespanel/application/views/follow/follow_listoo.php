<style>
    #responsive-follow_info{
        font-weight: normal !important;
        font-size: 0.8125rem;
    }
    #responsive-follow_paginate{
     font-weight: normal !important;
     font-size: 0.8125rem;   
    }
    #responsive-follow_last{
            display: none;
    }
    #responsive-follow_first{
        display: none;
    }
    
    
    #responsive-follow-order_info{
        font-weight: normal !important;
        font-size: 0.8125rem;
    }
    #responsive-follow-order_paginate{
     font-weight: normal !important;
     font-size: 0.8125rem;   
    }
    #responsive-follow-order_last{
            display: none;
    }
    #responsive-follow-order_first{
        display: none;
    }
</style>
<div class="grid_14" style="display:inline-flex;"><b style="margin-left:10px; font-size:14px">
        <? $red = '<div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>' ?>

        <? $green = '<div class="sk-spinner sk-spinner-pulse green-artwork-pulse"></div>' ?>

        <? $yellow = '<div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>' ?>
</div>
<style>

    .ui-timepicker-div .ui-widget-header {
        margin-bottom: 8px;
    }

    .ui-timepicker-div dl {
        text-align: left;
    }

    .ui-timepicker-div dl dt {
        float: left;
        clear: left;
        padding: 0 0 0 5px;
    }

    .ui-timepicker-div dl dd {
        margin: 0 10px 10px 40%;
    }

    .ui-timepicker-div td {
        font-size: 90%;
    }

    .ui-tpicker-grid-label {
        background: none;
        border: none;
        margin: 0;
        padding: 0;
    }

    .ui-timepicker-div .ui_tpicker_unit_hide {
        display: none;
    }

    .ui-timepicker-div .ui_tpicker_time .ui_tpicker_time_input {
        background: none;
        color: inherit;
        border: none;
        outline: none;
        border-bottom: solid 1px #555;
        width: 95%;
    }

    .ui-timepicker-div .ui_tpicker_time .ui_tpicker_time_input:focus {
        border-bottom-color: #aaa;
    }

    .ui-timepicker-rtl {
        direction: rtl;
    }

    .ui-timepicker-rtl dl {
        text-align: right;
        padding: 0 5px 0 0;
    }

    .ui-timepicker-rtl dl dt {
        float: right;
        clear: right;
    }

    .ui-timepicker-rtl dl dd {
        margin: 0 40% 10px 10px;
    }

    /* Shortened version style */
    .ui-timepicker-div.ui-timepicker-oneLine {
        padding-right: 2px;
    }

    .ui-timepicker-div.ui-timepicker-oneLine .ui_tpicker_time, .ui-timepicker-div.ui-timepicker-oneLine dt {
        display: none;
    }

    .ui-timepicker-div.ui-timepicker-oneLine .ui_tpicker_time_label {
        display: block;
        padding-top: 2px;
    }

    .ui-timepicker-div.ui-timepicker-oneLine dl {
        text-align: right;
    }

    .ui-timepicker-div.ui-timepicker-oneLine dl dd, .ui-timepicker-div.ui-timepicker-oneLine dl dd > div {
        display: inline-block;
        margin: 0;
    }

    .ui-timepicker-div.ui-timepicker-oneLine dl dd.ui_tpicker_minute:before, .ui-timepicker-div.ui-timepicker-oneLine dl dd.ui_tpicker_second:before {
        content: ':';
        display: inline-block;
    }

    .ui-timepicker-div.ui-timepicker-oneLine dl dd.ui_tpicker_millisec:before, .ui-timepicker-div.ui-timepicker-oneLine dl dd.ui_tpicker_microsec:before {
        content: '.';
        display: inline-block;
    }

    .ui-timepicker-div.ui-timepicker-oneLine .ui_tpicker_unit_hide, .ui-timepicker-div.ui-timepicker-oneLine .ui_tpicker_unit_hide:before {
        display: none;
    }

    edit_time, .set_time, .make_seq {
        padding: 2px !important;
        margin: 3px 10px !important;
    }

    .time_box {
        width: 60px;
        margin-left: 5px;
        float: left;
        text-align: center;
    }

    .hide {
        display: none;
    }
    .bb{
        color: #666;
        background: #fff;
        border-radius: 50%;
        font-size: 12px;
        position: absolute;
        padding: 4px 7px;
        margin-top: -7px;
        margin-left: 65px;
        z-index: 2 !important;
        font-weight: bold;
    }
</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-account"></i> FOLLOW UP QUOTE & CALL-BACK QUOTE</span>
                        
                        
                        
                         <span class="pull-right labels-form" style="width: 180px;margin-left: 20px;">
                            <div class="form-group margin-none">
                                <label class="select">
                                    <select class="form-control" id="qt_fillter" aria-controls="my_table">
                                       
                                         <option value="qfu" selected="selected">FOLLOW UP QUOTATIONS  </option>
                                         <option value="qcb" >CALL-BACK QUOTATIONS </option>
                                    </select>
                                    <i></i>
                                </label>
                            </div>
                        </span>
                        
                        
                        
                       
                        
                       
                        
                        
                        
                        
                        
                        
                          
                    </div>
                      <div class="card-body">
                        <table id="responsive-follow" class="table table-bordered table-bordered dt-responsive"
                               cellspacing="0" width="100%" style="font-weight: normal;">
                            <thead>

                            <tr>
                                <th>Refno</th>
                                <th>Placed<br>
                                    Date / Time
                                </th>
                                <th>Assigned<br>
                                    Date / Time
                                </th>

                                <th>Country / Post Code</th>
                                <th>Price</th>
                                <th>Customer Name</th>
                                <th>Phone #</th>
                                <th>Email</th>
                                <th width="15%">Type</th>
                                <th width="15%">Status</th>
                                <th>View</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        
        
           <br><br>
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-account"></i> FOLLOW UP ORDERS & CALL-BACK ORDERS & SAMPLE ORDERS  </span>
                        
                        
                        
                        <span class="pull-right labels-form" style="width: 180px;margin-left: 20px;">
                            <div class="form-group margin-none">
                                <label class="select">
                                    <select class="form-control" id="ord_fillter" aria-controls="my_table">
                                       
                                        <option value="ocb" selected="selected">CALL-BACK ORDERS</option>
                                        <option value="ofu" >FOLLOW UP ORDERS  </option>
                                       
                                    </select>
                                    <i></i>
                                </label>
                            </div>
                        </span>
                        
                        
                         
                        <input type="hidden" value="<?= $this->session->userdata('login_user_id') ?>" id="hidden">
                          <span class="pull-right">
                              <span class="badge bb"><?php echo $remainder['total_remaind'];?></span>
                            <li class="dropdown notification-list datatable-notification">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect datatable-notification" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">

                                <i class="fi-bell noti-icon"></i> </a>
                              <div class="dropdown-menu dropdown-menu-right dropdown-lg" style="position: absolute;right:0px;z-index:1111">

                                <!-- item-->
                                <?php include('notification.php');?>
                                  <!-- All-->
                            </div>
                            </li>
                          </span>
                          
                          
                           <!--<span class="pull-right">
                                        <a href="<?= main_url ?>follow/Followup/completeJobPage" class="btn btn-primary waves-light waves-effect">Completed Jobs</a>
                            </span>-->
                         
                        
                        
                    </div>
                    
                    
                    <div class="card-body">
                        <table id="responsive-follow-order" class="table table-bordered table-bordered dt-responsive"
                               cellspacing="0" width="100%" style="font-weight: normal;">
                            <thead>

                                <tr>
                                <th width="6%">Refno</th>
                                <th>Placed<br>Date / Time</th>
                                <th>Assigned<br>Date / Time</th>
                                <th>Country / Post Code</th>
                                <th>Price</th>
                                <th>Customer Name</th>
                                <th>Phone #</th>
                                <th>Email</th>
                                <th width="15%">Type</th>
                                <th width="15%">Status</th>
                                <th>View</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
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
<!-- Artwork Comment Popup Start -->
<div class="modal fade bs-example-modal-lg" id="comment_popup" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="comment_body">

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Artwork Comment Popup End -->

<!-- Artwork Comment Popup Start -->
<div class="modal fade bs-example-modal-md" id="show_status_modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content blue-background">

            <div class="modal-body p-t-0" id="show_status_pop">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Artwork Comment Popup End -->

<script type="text/javascript">

    $(document).ready(function () {

        $(document).on('change', '#user_follow_up', function () {
            var UserID = $("#user_follow_up").val();
            records(UserID);
        });

        <?php
        $userID = $this->session->userdata('login_user_id');
        $userType = $this->session->userdata('UserTypeID');

        $value = '';                                     
        if ($userType == 50) {
            $value = 'all';
        } else {
            $value = $userID;
        }
        $value = 'all'; // all records to show for all operators
       
      ?>
      
      records('<?=$value ?>','qfu');
      records_orders('<?=$value ?>', 'ocb');
        
        //getNotification();

    });
    
    
   
    
    $(document).on('change', '#qt_fillter', function () {
            var sta = $(this).val();
            records('all', sta);
        });

    

    function records(userId,state) {
        
        var sort_no = 0;
        var sort_val = 0;
        if(state=='qfu'){
            sort_no = 2;
            sort_val = 'desc';
        }else{
            sort_no = 9 ;
            sort_val = 'asc';
        }
        
        
        $('#responsive-follow').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[sort_no, sort_val]],
            //'sAjaxSource': '<?php echo main_url?>follow/Followup/getFollowUpData/' + userId,
            'sAjaxSource': '<?php echo main_url?>follow/Followups/getQuotations/' + userId + '?status=' + state,

            "aoColumns": [
                {


                    "render": function (data, type, row) {

                        var str = row[0];
                        var refno = null;
                        if (str.substr(0, 3) == "AAE") {
                            refno = str.replace("AA", "");
                            refno = "<a href='" + mainUrl + "order_quotation/order/getOrderDetail/" + refno + "' target='_blank'>" + refno + "</a>";
                        } else if (str.substr(0, 2) == "DD") {
                            refno = str.replace("DD", "AA");
                            refno = "<a href='" + mainUrl + "order_quotation/order/getOrderDetail/" + refno + "' target='_blank'>" + refno + "</a>";
                        } else if (str.substr(0, 3) == "AAQ" || str.substr(0, 3) == "ATQ") {
                            refno = str;
                            refno = "<a href='" + mainUrl + "order_quotation/quotation/getQuotationDetail/" + refno + "' target='_blank'>" + refno + "</a>";
                        }
                        return refno;
                    }
                },
                null,
                null,

                null,
                {
                    "render": function (data, type, row) {

                        var total = row[4] * row[11];
                        return row[12] + "" + total.toFixed(2);
                    }
                },
                null,
                null,
                null,
                {

                    "render": function (data, type, row) {
                        var str = row[8];
                        
                        if (str == "first" || str == "FIRST") {
                            var type = "New Customer - Curtsey Call";
                        } else if (row[16].substr(0, 1) == "E") {
                            var type = "Enquiry - Contact Customer";
                        } else if (row[16].substr(0, 3) == "AAQ") {
                            var type = "Quotation - Contact Customer";
                        } else if (str != "first" || str != "FIRST") {
                            var type = "Repeat Customer - Curtsey Call";
                        }
                        if (row[15] == "Sample Order") {
                            var type = "Sample Order - Contact Customer";
                        }
                        return type;
                    }
                },
                {
                    "render": function (data, type, row) {

                        var refno = row[16];
                     
                        if(row[17]==0){
                           var head = "";
                        }else{
                           var head = "<p id='stat_" + refno + "'>" + convert(row[17]) + "</p>";
                        }
                        
                        
                        
                        optionList = ['', 'Pending Contact', 'Completed', 'Call Back', 'Rejected', 'Ordered Placed', 'Customer Away', 'Ordered with another Supplier', 'Samples Sent', 'Quotation Sent'];
                        var option = "";
                       
                        for (i = 1; i < optionList.length; i++) {
                            
                           
                             var selected = "";

                            if (row[15] == 3 || row[15] == 15) {
                                
                                if(row[17]==0){
                                      var head = "";
                                }else{
                                    var head = "<p id='stat_" + refno + "'>" + convert(row[17]) + "</p>";
                                        if(row[15] == i){
                                       var selected = "selected";
                                  }
                                }
                                
                            } else {
                                var head = "<p id='stat_" + refno + "'>" + optionList[row[15]] + "</p>";
                                
                                if(row[15] == i){
                                    var selected = "selected";
                                }
                            }
                            
                            
                            option += "<option " + selected + " value= '" + i + "'>" + optionList[i] + "</option>";
                        }
                        
                        
                        var full_sel = head + "<div style=align='center'> " +
                            "<span class='labels-form'><label class='select'><select class='form-control' id='select_" + refno + "' onchange=show_fallr(this.value,'" + refno + "')> <option value= ''>Select Status</option>" + option + "</select><i></i></label></span>";


                        return full_sel;
                    }
                },
                {
                    "render": function (data, type, row) {

                        var refno = row[16];

                        return '<a class="comments" style="cursor:pointer;" data-id="' + refno + '"> <i id="comments_' + refno + '">' + row[13] + '</i><i> Comments</i></a>';
                    }
                },
                {
                    "render": function (data, type, row) {

                        if (row[15] == 3 || row[15] == 8 || row[15] == 9) {
                            return '<div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>';
                        } else if (row[15] == 5) {
                            return '<div class="sk-spinner sk-spinner-pulse green-artwork-pulse"></div>';
                        } else {
                            return '<div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>';
                        }


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


        });
    }
    
    
    
    function getNotification() {
        $.ajax({
            type: "post",
            url: mainUrl + "follow/Followup/getRemainderLoad",
            cache: false,
            data: {},
            dataType: 'json',
            success: function (data) {
                $('#print_notification').html(data.html);

            },
            error: function () {
                alert('Error while request..');
            }
        });
    }

    function show_fallr(status, refno) {

        $.ajax({
            type: "get",
            url: mainUrl + "follow/Followup/getStatusPopUp/" + status,
            cache: false,
            data: {status: status, refno: refno},
            dataType: 'json',
            success: function (data) {
                $('#show_status_pop').html(data.html);
                $('#show_status_modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });

    }

    $(document).on("click", ".comments", function (e) {
        $('#foollow_comments').modal('show');

        var order = $(this).attr('data-id');

        $("#dvLoading").css('display', 'block');
        var value = "callback";

        $.ajax({
            type: "post",
            url: mainUrl + "follow/Followup/fetchComments/",
            cache: false,
            data: {order: order, value: value},
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                $('#comment_body').html(data.html);
                $('#comment_popup').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });

    function saveComment() {

        var comment = $('#new_comment').val();
        var order = $('#comment_orderno').val();

        if (comment == "" || comment == " " || comment == "  " || comment == "   " || comment == "    ") {
            swal("", "Enter Comment First", "warning");
            return false;
        }

        $.ajax({
            type: "post",
            url: mainUrl + "follow/Followup/saveComment",
            cache: false,
            data: {comment: comment, order: order},
            dataType: 'json',
            success: function (data) {
                $('#comment_body').html(data.html);
                $('#comments_' + order).text(data.count);
            },
            error: function () {
                alert('Error while request..');
            }
        });

    }

    function deleteComment(key, commentId, orderNumber) {
        swal("Are you sure ?", {
            icon: 'warning',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "CONTINUE",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $.ajax({
                            type: 'POST',
                            url: mainUrl + "follow/Followup/deleteComment",
                            data: {commentId: commentId, orderNumber: orderNumber},
                            cache: false,
                            dataType: 'json',
                            success: function (data) {
                                $('#comments_' + orderNumber).text(data.count);
                                $('#comment' + key).remove();
                            },
                            error: function (data) {
                                console.log("error");
                            }
                        });

                        break;
                    default:
                        break;
                }
            });
    }

    function hideCommentModal() {
        $('#comment_popup').modal('hide');
    }

    function hidestatusModal() {
        $('#show_status_modal').modal('hide');
    }

    function changeStatus(status, refno) {
        var ord_Place = $('#order_place').val();
        var note = $('#note').val();
        var option = $('#option').val();
        var ord_no = $('#ord_no').val();
        var date = $('#date').val();
        var time = $('#time').val();
        $.ajax({
            type: "post",
            url: mainUrl + "follow/Followup/date_insert/",
            cache: false,
            data: {status: status, refno: refno, ord_Place: ord_Place, note: note, option: option, ord_no: ord_no, date: date, time:time},
            dataType: 'json',
            success: function (data) {
                $('#print_notification').html(data.remain_view);
                $('#show_status_modal').modal('hide');
                
                 var sta = $("#qt_fillter option:selected").val();
                records('all', sta);
                     //location.reload();
            },
            error: function () {
                alert('Error while request..');
            }
        });
    }

  function convert(unixtimestamp){
            // Months array
            var months_arr = ['01','02','03','04','05','06','07','08','09','10','11','12'];

            // Convert timestamp to milliseconds
            var date = new Date(unixtimestamp*1000);
            // Year
            var year = date.getFullYear();
            // Month (month+1 because the index starts from 0)
            var month = date.getMonth()+1;
            //var month = months_arr[date.getMonth()];
            // Day
            var day = date.getDate();
            // Hours
            var hours = date.getHours();

            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12;

            // Minutes
            var minutes = "0" + date.getMinutes();
            // Seconds
            var seconds = "0" + date.getSeconds();

            // Display date time in MM-dd-yyyy h:m:s format
            var convdataTime = day+'-'+month+'-'+year+' \n'+hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2) +' '+ampm;
            return convdataTime;
        }
        
        
        
            $(document).on('change', '#ord_fillter', function () {
            var sta = $(this).val();
            records_orders('all', sta);
    });
    
    
    
    function records_orders(userId,state) {
        
          var sort_no = 0;
          var sort_val = 0;
          if(state=='ofu'){
              sort_no = 2;
               sort_val = 'desc';
            }else{
              sort_no = 9 ;
              sort_val = 'asc';
         }
        
        
        $('#responsive-follow-order').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[sort_no, sort_val]],
            //'sAjaxSource': '<?php echo main_url?>follow/Followup/getFollowUpData/' + userId,
            'sAjaxSource': '<?php echo main_url?>follow/Followups/getorders/' + userId + '?status=' + state,

            "aoColumns": [
                {


                    "render": function (data, type, row) {

                        var str = row[0];
                        var refno = null;
                        if (str.substr(0, 3) == "AAE") {
                            refno = str.replace("AA", "");
                            refno = "<a href='" + mainUrl + "order_quotation/order/getOrderDetail/" + refno + "' target='_blank'>" + refno + "</a>";
                        } else if (str.substr(0, 2) == "DD") {
                            refno = str.replace("DD", "AA");
                            refno = "<a href='" + mainUrl + "order_quotation/order/getOrderDetail/" + refno + "' target='_blank'>" + refno + "</a>";
                        } else if (str.substr(0, 3) == "AAQ" || str.substr(0, 3) == "ATQ") {
                            refno = str;
                            refno = "<a href='" + mainUrl + "order_quotation/quotation/getQuotationDetail/" + refno + "' target='_blank'>" + refno + "</a>";
                        }else {
                                refno = "<a href='" + mainUrl + "order_quotation/order/getOrderDetail/" + row[0] + "' target='_blank'>" + row[0] + "</a>";
                        }
                        return refno;
                    }
                },
                null,
                null,

                null,
                {
                    "render": function (data, type, row) {

                        var total = row[12] * row[4];
                        return row[13] + "" + total.toFixed(2);
                    }
                },
                null,
                null,
                null,
                {

                    "render": function (data, type, row) {
                        var str = row[8];
                        
                        if (str == "first" || str == "FIRST") {
                            var type = "New Customer - Curtsey Call";
                        } else if (row[18].substr(0, 1) == "E") {
                            var type = "Enquiry - Contact Customer";
                        } else if (row[18].substr(0, 3) == "AAQ") {
                            var type = "Quotation - Contact Customer";
                        } else if (str != "first" || str != "FIRST") {
                            var type = "Repeat Customer - Curtsey Call";
                        }
                        
                        if (row[15] == "Sample Order") {
                            var type = "Sample Order - Contact Customer";
                        }
                        return type;
                    }
                },
                {
                    "render": function (data, type, row) {

                        var refno = row[18];
                     
                        if(row[16]==0){
                           var head = "";
                        }else{
                           var head = "<p id='stat_" + refno + "'>" + convert(row[16]) + "</p>";
                        }
                        
                        
                        
                        optionList = ['', 'Pending Contact', 'Completed', 'Call Back', 'Rejected', 'Ordered Placed', 'Customer Away', 'Ordered with another Supplier', 'Samples Sent', 'Quotation Sent'];
                        var option = "";
                       
                        for (i = 1; i < optionList.length; i++) {
                            
                           
                             var selected = "";

                            if (row[17] == 3 || row[17] == 15) {
                                
                                if(row[16]==0){
                                      var head = "";
                                }else{
                                    var head = "<p id='stat_" + refno + "'>" + convert(row[16]) + "</p>";
                                        if(row[17] == i){
                                       var selected = "selected";
                                  }
                                }
                                
                            } else {
                                var head = "<p id='stat_" + refno + "'>" + optionList[row[17]] + "</p>";
                                
                                if(row[17] == i){
                                    var selected = "selected";
                                }
                            }
                            
                            
                            option += "<option " + selected + " value= '" + i + "'>" + optionList[i] + "</option>";
                        }
                        
                        
                        var full_sel = head + "<div style=align='center'> " +
                            "<span class='labels-form'><label class='select'><select class='form-control' id='select_" + refno + "' onchange=show_fallr(this.value,'" + refno + "')> <option value= ''>Select Status</option>" + option + "</select><i></i></label></span>";


                        return full_sel;
                    }
                },
                {
                    "render": function (data, type, row) {

                        var refno = row[18];

                        return '<a class="comments" style="cursor:pointer;" data-id="' + refno + '"> <i id="comments_' + refno + '">' + row[14] + '</i><i> Comments</i></a>';
                    }
                },
                {
                    "render": function (data, type, row) {

                        if (row[17] == 3 || row[17] == 8 || row[17] == 9) {
                            return '<div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>';
                        } else if (row[17] == 5) {
                            return '<div class="sk-spinner sk-spinner-pulse green-artwork-pulse"></div>';
                        } else {
                            return '<div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>';
                        }


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


        });
    }

</script>
