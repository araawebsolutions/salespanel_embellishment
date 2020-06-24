<style>
.tickets-list a {
     color: #fd4913; 
    white-space: nowrap;
}
</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-heading-text"><span><i class="mdi mdi-cart"></i> CREDIT NOTE</span>
                    </div>
                    <div class="card-body">
                        <?php  //$total_attach = $this->Return_model->fetch_top_counter(); print_r($total_attach); ?>
                        <table class="table table-hover m-0 tickets-list table-actions-bar artwork-table-row-adjust dt-responsive nowrap return-table"
                               cellspacing="0" width="100%" id="datatable" style="position: relative;">
                            <thead class="artwork-thead">
                            <tr>
                                <th class="no-border">Ticket No</th>
                                <th class="no-border">Customer</th>
                                <th class="no-border">Phone</th>
                                <th class="no-border">Order No</th>
                                <!-- <th class="no-border">Credit Note ID #</th>-->
                                <th class="no-border">Date</th>
                                <th class="no-border">Time</th>
                                <!--<th class="no-border">Amount</th>-->
                                
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

<script>
$( document ).ready(function() {
  //fetch_top_counter();
    //alert('ds');
    
    $('#datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "simple_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>tickets/creditNotes/allCreditNotes',
        
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←' 
                }
            },

            "aoColumns": [
             
                {
                    "render": function (data, type, row) {
                        var t_id;
                        t_id =  '<a class="orange-text !" href="' + mainUrl + 'tickets/creditNotes/viewDetails/' + row[0] + '" <b> ' + row[1] + '</b></a>';
                        return t_id;
                        
                    }
                },
                {
                    "render": function (data, type, row) {
                        return row[5];
                    }
                },
                {
                    "render": function (data, type, row) {
                        return row[6];
                    }
                },
                {
                    "render": function (data, type, row) {
                        
                        var array = row[2];
                        if(array){
                            array = array.replace(/ *, */g, '<br>');
                            return array;
                        }else{
                            return '---';
                        }
                    }
                },
                 
               {
                    "render": function (data, type, row) {
                        return row[3];
                    }
                },
               {
                    "render": function (data, type, row) {
                        return row[4];
                    }
                },
                
              
                /*{
                    "render": function (data, type, row) {
                        return row[7];
                    }
                },*/
            
             

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
                //alert(JSON.stringify(aoData));
            },
            'createdRow': function( row, data, dataIndex ) {
                $(row).removeClass('odd');
                 $(row).removeClass('even');
                $(row).addClass('artwork-tr');
            },


        });
    

    
});


    
    

</script>