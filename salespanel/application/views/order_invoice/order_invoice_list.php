<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-book-open"></i> ALL INVOICES</span> <span class="pull-right"></span>
                        <!--<span class="pull-right">
                    <a href="<?= main_url ?>order_quotation/order/index"
                       class="btn btn-primary waves-light waves-effect">Create Credie Note</a>
                    </span>-->
                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable"
                               class="table table-bordered table-bordered dt-responsive nowrap text-center"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                              
                              
                              
                                <th>Invoice No</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Refrence no</th>
                                <th>Print</th>
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
            'sAjaxSource': '<?php echo main_url?>invoice/getAllinvoice',

            "aoColumns": [
             
              {
                "render": function (data, type, row) {
                    if(row[1]=='Credit Note'){
                        return '<a href="#" <b>' + row[0] + '</b></a>';
                    }else{
                        return '<a target="_blank" href="' + mainUrl + 'invoice/viewinvoice/' + row[0] + '" <b style="font-weight: 700;">' + row[0] + '</b></a>';
                    }
                }
              },
              
              null,
              null,
              null,
              null,
              null,
              {
                "render": function (data, type, row) {
                  var symbol = row[11];
                  var sym = '&pound;';

                  if (symbol == "EUR") {
                    var sym = '&euro;';
                  }
                  if (symbol == "USD") {
                    var sym = '$';
                  }
											 
                  if (symbol == "GBP") {
                    
                  }

											
                  if (symbol == "") {
                    sym = '&pound;';
                  }

                  var total = row[12] * row[6];
                  return sym+total.toFixed(2);
                }

                },
                null,
               {
                "render": function (data, type, row) {
                  	    if(row[1]=='Credit Note'){
                         var url = 'invoice/printnote/'+row[0];	
                       }else{
                         var url = 'invoice/printinvoice/'+row[0];
                       }
                  
                  
                  return '<a href="'+url+'"<b style="font-weight: 700;">Get PDF</b></a>';
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