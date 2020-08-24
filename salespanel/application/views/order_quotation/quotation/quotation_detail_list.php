<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-book-open"></i> ALL QUOTATIONS</span> <span class="pull-right"></span>
                        <span class="pull-right">
                    <a href="<?= main_url ?>order_quotation/order/index"
                       class="btn btn-primary waves-light waves-effect">Add New Quotation</a>
                    </span>
                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable"
                               class="table table-bordered table-bordered dt-responsive nowrap text-center"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Quotation No.</th>
                                <th>Date / Time</th>
                                <th>Qty</th>
                                <th>Total Amount</th>
                                <th>Customer</th>
                                <th>Billing Pcode</th>
                                <th>Delivery Pcode</th>
                                <th>Source</th>
                                <th>Quotation Status</th>
                              <th>Actions</th>
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
<script type="text/javascript">

    $(document).ready(function () {


        //Buttons examples

        $('#responsive-datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "pageLength": 25,
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>order_quotation/Quotation/getAllQuotations',

            "aoColumns": [
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return '<a href="' + mainUrl + 'order_quotation/quotation/getQuotationDetail/' + row[0] + '" <b>' + row[0] + '</b></a>';
                    }
                },
                null,
                null,
                {
                    "render": function (data, type, row) {
                        var symbol = row[9];
                        var sym = '&pound;';
                        var val = row[10];

                        if (symbol == "EUR") {
                            var sym = '&euro;';
                        }
                        if (symbol == "USD") {
                            var sym = '$';
                        }
											
                        if (symbol == "GBP") {
                            var val = 1;
                        }

											
											 if (symbol == "") {
                            var val = 1;
												    sym = '&pound;';
                        }

                        var total = val * row[3];
												//total  = total *  1.2;
                        return sym+total.toFixed(2);
                    }

                },
                null,
                null,
                null,
                null,
                {
                    "render": function (data, type, row) {
                        var cmp = row[8];
                        if (cmp == '37') {
                            return '<span style="color:#820101;"><b>Pending Approval</b></span>';
                        }
                        if (cmp == '13') {
                            return '<span style="color:#2a632e;"><b>Completed</b></span>';
                        }
                        if (cmp == '17') {
                            return '<span style="color:#2a632e;"><b>Approved</b></span>';
                        }
                        if (cmp == '23') {
                            return '<span style="color:#820101;"><b>REJECTED</b></span>';
                        }
                        if (cmp == '39') {
                            return '<span style="color:#2a632e;"><b>Re-quoted</b></span>';
                        }
                        if (cmp == '8') {
                            return '<span style="color:#820101;"><b>Part Complete</b></span>';
                        }
                        if (cmp == '56') {
                            return '<span style="color:#820101;"><b>Completed - Ordered Online</b></span>';
                        }
                        if (cmp == 'Pending processing') {
                            return '<span style="color:#820101;"><b>Pending processing</b></span>';
                        }
                        if (cmp == '2') {
                            return '<span style="color:#820101;"><b>Pending processing</b></span>';
                        }
                        return "";
                    }
                },
              
              
              

    	     {
                    "render": function (data, type, row) {
                      
                      var view_count;
                      var view_status;
                      var view_time;
                      var requote_time;
                      var qorderNo;

                      view_count =  row[11];
                      view_status = row[12];
                      view_time =   row[13];
                      requote_time = row[14];
                      qorderNo = row[15];
                      
                      //(view_count+ ' -- '+ view_status +' -- '+ view_time);
                      
                      if (view_count == '0') {
                        return '<span style="color:#820101;"><b>Link Sent</b></span>';
                      }
                      
                       if(view_count != '0' && view_count != null  && view_time!="" && (view_status=="" || view_status==null)){
                        return '<span style="color:#820101;"><b>Viewed - '+ view_count +'</b> <br> '+view_time+' </span>';
                      }
                        
                      if((view_status!="" && view_status!=null)){
                        
                         if(view_status =='Requoted'){
                           return '<span style="color:#820101;"><b>'+ view_status +'</b> <br> '+requote_time+' </span>';

                         } else if(view_status =='Accepted'){
                           return '<span style="color:#820101;"><b>'+ view_status +'</b> <br>'+qorderNo+' </span>';

                         }
                        else{
                           return '<span style="color:#820101;"><b>'+ view_status +'</b></span>';
                         }
                      }
                        return "---";
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
    });
</script>