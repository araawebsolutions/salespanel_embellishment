<?
$UserTypeID = $this->session->userdata('UserTypeID');
if ($TotalHold > 0) {
    $hold_count = " ( " . $TotalHold . ' ) ' . '<img border="0" src="../theme/saleoperater/status_lights.gif">';
} else {
    $hold_count = " ( " . $TotalHold . " ) ";
}
?>
<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text"><span><i class="mdi mdi-cart"></i> ALL ORDERS</span>
                        <span class="pull-right"></span>
                        <span class="pull-right labels-form" style="width: 180px;margin-left: 20px;">
                <div class="form-group margin-none">
                    <label class="select">
                 <select class="form-control" id="order_filter">
                    <option value="all">Order Filters</option>
                    <option value="offshore">Export Sales</option>
                    <option value="holdedorder">Hold Orders
                        <?= $hold_count ?>
                    </option>
                    <option value="lba">LBA Orders</option>
                    <option value="designer">Label Designer Orders</option>
                    <option value="artwork">Pending Artwork Approval (&nbsp;
                        <?= $pending ?>
                        &nbsp;)</option>
                    <option value="pko">Plain Packaging Orders</option>
                    <option value="rollprint">Printed Rolls Order</option>
                    <option value="printed">Printed Sheets Orders</option>
                    <option value="xmass">Sample Orders</option>
                  </select>
                        <i></i>
                    </label>
                </div>
                        </span>


                        <span class="pull-right labels-form" style="width: 180px;margin-left: 20px;">
                <div id="new_select" style=" display:none" class="form-group margin-none">
                    <label class="select">
                  <select class="form-control" id="order_filter_country">
                    <option value="offshore">All</option>
                    <option value="Austria">Austria</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="Germany">Germany</option>
                    <option value="Holland">Holland</option>
                    <option value="Italy">Italy</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Norway">Norway</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Spain">Spain</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Other">Other</option>
                  </select>
                        <i></i></label>
                </div>
               </span>


                        <span class="pull-right labels-form" style="width: 180px;margin-left: 20px;">
                <div class="form-group margin-none">
                     <label class="select">
                  <select class="form-control" id="date_filter" aria-controls="my_table">
                      <option value="7">Last 7 Days</option>
                      <option value="30" selected="selected">Last 30 Days</option>
                      <option value="90">Last 3 Months</option>
                      <option value="180">Last 6 Months</option>
                      <option value="all">Show All</option>
                  </select>
                         <i></i>
                     </label>
                </div>

                </span> <span class="pull-right labels-form" style="width: 180px;">
                <div class="form-group margin-none">
                    <label class="select">
                  <select class="form-control" id="status_filter" aria-controls="my_table">
                      <option value="all">All Orders</option>
                      <option value="35">ABORT</option>
                      <option value="27">Cancel</option>
                      <option value="7">Completed</option>
                      <option value="52">Custom Line</option>
                      <option value="25">ERROR</option>
                      <option value="26">FAILED</option>
                      <option value="10">Hold</option>
                      <option value="21">INVALID</option>
                      <option value="20">MALFORMED</option>
                      <option value="22">NOTAUTHED</option>
                      <option value="36">OK</option>
                      <option value="37">Pending Approval</option>
                      <option value="55">Pending Artwork Approval</option>
                      <option value="6">Pending Payment</option>
                      <option value="78">Pending Part Payment</option>
                      <!--<option value="2">Pending processing</option>-->
                      <option value="32">Pending Production</option>
                      <option value="33">Production</option>
                      <option value="23">Rejected</option>
                      <option value="38">Roll Label Print</option>
                      <option value="51">Stock Item</option>
                      <option value="34">Un Hold</option>
                      <option value="57">With Customer Awaiting Approval</option>
                  </select>
                        <i></i></label>
                </div>
                </span></div>
                    <div class="card-body">
                        <table id="responsive-datatable"
                               class="table table-bordered table-bordered dt-responsive nowrap text-center"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th>Order No</th>
                                <th>Date / Time</th>
                                <th>Order Value</th>
                                <th>Customer</th>
                                <th>Pcode</th>
                                <th>Delivery Pcode</th>
                                <th>Billing Country</th>
                                <th>Source</th>
                                <th>Payment Method</th>
                                <th>VAT Rate</th>
                                <th>Status</th>
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
        $(document).on('change', '#order_filter', function () {
            var value = $(this).val();
            var date = $("#date_filter").val();
            var status = $("#status_filter").val();
            if (value == 'offshore') {
                $("#new_select").show();
            }
            else {
                $("#new_select").hide();
            }
            record(value, status, date);
        });

        $(document).on('change', '#status_filter, #date_filter', function () {
            var status = $("#status_filter").val();
            var date = $("#date_filter").val();
            var order = $("#order_filter").val();
            record(order, status, date);
        });


        $(document).on('change', '#order_filter_country', function () {
            var value = $(this).val();
            var status = $("#status_filter").val();
            var date = $("#date_filter").val();
            record(value, status, date);
        });

        record('all', 'all', '30');


    });

    function record(order, status, date) {
         $('#aa_loader').show();
        $('#responsive-datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "full_numbers",
            "pageLength": 25,
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>order_quotation/order/getAllOrders/' + order + '/' + status + '/' + date,

            "aoColumns": [

                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return '<a href="' + mainUrl + 'order_quotation/order/getOrderDetail/' + row[1] + '" <b>' + row[1] + '</b></a>';
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return row[18];
                    }
                },
                {
                    "render": function (data, type, row) {
                        var symbol = row[24];
                        var sym = '&pound;';
                        var val = row[25];

                        if (symbol == "EUR") {
                            var sym = '&euro;';
                        }
                        if (symbol == "USD") {
                            var sym = '$';
                        }
                        if (symbol == "") {
                            var val = 1;
                        }

                        var total = val * row[3];
                        return sym+total.toFixed(2);
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return row[4];
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return row[5];
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return row[6];
                    }
                },
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return row[7];
                    }
                },
                {
                    "render": function (data, type, row) {
                       
																
                  if(row[8] == "Website" || row[8] =="website"){
					if(row[7]=="Sample Order"){
						 return 'Website - Sample Order';
					 }else{
						return "Website";
					}
                  }else if(row[8].indexOf("Quotation") > -1){
                            return "Quotation";
                   }
                   else if(row[8].indexOf("Q-") > -1){
                            return row[8];
                  }else{
                            if(row[7]=="Sample Order"){
								 return row[17]+' - Sample Order';
							}else{
								 return row[17];
							}
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        var payment = row[15];
                        if (payment == "paypal" || payment == "creditCard") {
                            return '<a  href="#" onmouseover="RollPing('+row[0]+',this);" data-title="'+row[19]+'" data-placement="top">'+row[15]+'</a>';
                        } else if (row[15] == "chequePostel") {
                            return "Cheque or BACS";
                        } else {
                            return row[15];
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        if (row[26] != 'Exempt') {
                            var symbol = row[24];
                            var sym = '&pound;';
                            var val = row[25];

                            if (symbol == "EUR") {
                                var sym = '&euro;';
                            }
                            if (symbol == "USD") {
                                var sym = '$';
                            }
                            if (symbol == "") {
                                var val = 1;
                            }

                            return sym+(row[26] * val).toFixed(2);
                        }
                        else {
                            return row[26];
                        }
                    }
                },
                {
                    "render": function (data, type, row) {
                        if (row[20] == "Pending Production" || row[20] == "Pending processing" || row[20] == "Production") {

                            if (row[28] != '01/01/1970') {
                                var ExpectedDispatchedDate = row[28];
                                var status = '<span style="text-align:left;width:133px;float:left;">' + row[20] + '<br>' + ExpectedDispatchedDate + '</span>';
                            } else {
                                var image = '&nbsp;&nbsp;&nbsp;<div class="sk-spinner sk-spinner-pulse green-artwork-pulse"></div>';
                                var status = '<span style="text-align:left;width:125px;float:left;">' + row[20] + image + '</span>';
                            }

                        } else {
                            if ((row[21] == 7 || row[21] == 8) && row[27] != '') {
                                var DispatchedDate = row[27];
                                var status = '<span style="text-align:left;width:133px;float:left;">' + row[20] + DispatchedDate + '</span>';
                            }
                            else {
                                var status = '<span style="text-align:left;width:133px;float:left;">' + row[20] + '</span>';
                            }
                        }
                        return status;
                    }
                },

            ],
            "fnInitComplete": function () {
                $('#aa_loader').hide();
            },
            'fnServerData': function (sSource, aoData, fnCallback) {
                //$('#aa_loader').show();
               // alert(fnCallback);
                $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                    
                   
                }
        );
                
                
           
                
                
                 //$('#aa_loader').show();
            },


        });
    }
    
    function RollPing(id,j) {
	 $(j).tooltip('show');
  }	
</script>