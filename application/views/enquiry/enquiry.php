<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-headset"></i> ALL ENQUIRIES</span> <span class="pull-right">
                    <a href="<?= main_url ?>addEnquiry"
                       class="btn btn-primary waves-light waves-effect">Add New Enquiry</a>
                    </span></div>
                    <div class="card-body">
                        <table id="responsive-enquiry" class="table table-bordered table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Refno</th>
                                <th>Date / Time</th>
                                <th>Description</th>
                                <th>QTY</th>
                                <th>Customer</th>
                                <th>Phone#</th>
                                <th>Email Address</th>
                                <th>Source</th>
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
<!-- Footer -->
<script type="text/javascript">

    $(document).ready(function () {


        //Buttons examples

        $('#responsive-enquiry').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": true,
            "pageLength": 25,
            "sPaginationType": "simple_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>enquiry/Enquiry/getAllEnquires',

            "aoColumns": [
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return '<a href="<?= main_url?>getEnquiryDetail/' + row[0] + '" ><b>' + row[0] + '</b></a>';
                    }
                },

                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        return row[9];
                    }
                },
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    "render": function (data, type, row) {
                        if (row[8] == 11) {
                            return 'Required Action <div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>';
                        } else if (row[8] == 12) {
                            return 'Awaiting Reply <div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>';
                        }
                        else if (row[8] == 13) {
                            return 'Completed <div class="sk-spinner sk-spinner-pulse green-artwork-pulse"></div>';
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
    });
</script>