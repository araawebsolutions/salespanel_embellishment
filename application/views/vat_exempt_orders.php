
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">
                        <span class="text-left">RECEIVED THROUGH MERCHANT SERVICE</span>
                        <span class="pull-right" style="display: inline-flex;">


                        <form method="post" id="checkout_form" class="labels-form " enctype="multipart/form-data"
                              action="">

     <span class="pull-right" style="display: inline-flex;">

         <label class="input m-r-b-0"> 
            <!-- <i class="icon-append  fa-calendar"></i>
            <input type="date" name="start_date" placeholder="Start Date" id="start_date" class="required" aria-required="true" onchange="search();"> -->

            <div class=" labels-form">
                <label class="input"> <i class="icon-append fa fa-calendar"></i>
                <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                <input type="text" value="" name="start_date" id="start_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" onchange="search();">
                </label>
            </div>
        

        </label>



         <label class="input m-r-b-0"> 
            <!-- <i class="icon-append  fa-calendar"></i>
            <input type="date" name="end_date" placeholder="End Date" id="end_date" class="required" aria-required="true" onchange="search();"> -->

            <div class=" labels-form">
                <label class="input"> <i class="icon-append fa fa-calendar"></i>
                <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                <input type="text" value="" name="end_date" id="end_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" onchange="search();">
                </label>
            </div>
        </label>
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
                                            <a class="dropdown-item" href="#" onclick="exportFile('<?php echo main_url ?>vat_exempt_orders/exportExcel');">Export Excel</a>
                                            <a class="dropdown-item" href="#" onclick="exportFile('<?php echo  main_url ?>vat_exempt_orders/exportPDF')">Export PDF</a>
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
                                <th>Order No</th>
                                <th>Date
                                </th>
                                <th>Payment Date
                                </th>
                                <th>Company Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Country</th>
                                <th>Customer VAT No</th>
                                <th>Currency</th>
                                <th>Order Value</th>
                                <th>Vat Exempt Value</th>
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
    function exportFile(url){
        document.getElementById('checkout_form').action=url;
        document.getElementById('checkout_form').method = 'POST';
        document.getElementById('checkout_form').submit();
    }

    function search(){
        var formData = {
        "start_date" : $('#start_date').val(),
        "end_date" : $('#end_date').val()

       } 

       //alert($('#start_date').val()+' === '+$('#end_date').val());
        var datatable = $('#responsive-datatable').DataTable({
         "destroy": true,
         "processing": true,
         "serverSide": false,
         "pageLength": 25,
         "iDisplayStart" : 0,
         "iDisplayLength": 10,
         "order": [[ 0, "desc" ]],
         "ajax": {
                    "url": mainUrl+"vat_exempt_orders/getOrder",
                    "type": "POST",
                    "data": formData
                },
         "columnDefs": [{
 
       
 
            } ]
        });
        $("#responsive-datatable_processing").show();
        $(".dataTables_empty").hide();
    }

    $(document).ready(function () {

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf']
        });

        // Responsive Datatable
        //$('#responsive-datatable').DataTable();
        search();

        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(function() {
      $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2000,
         format: 'dd/mm/yyyy'
      });
    });
  </script>