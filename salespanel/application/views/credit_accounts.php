<style type="text/css">
  .remove_border_bg{
    border: 0 !important;
    background: transparent !important;
  }
    .editable{
        cursor: pointer !important;
    }
    .edit{
        color: #666 !important;
font-size: 13px !important;
    }
</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text">ACCOUNT CUSTOMERS

                    <span
                            class="pull-right pull-right-datatable"></span>

                        <span class="pull-right"><button type="button" class="btn btn-primary waves-light waves-effect" onclick="search_statement();">View Customer Account Statement</button></span>
                        <span class="pull-right m-r-20"><button type="button"
                                                                class="btn btn-primary waves-light waves-effect" onclick="add_new_customer();">Add New Customer Record</button></span>

                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable"
                               class="table table-bordered table-bordered dt-responsive nowrap text-center dataTable no-footer"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company Name</th>
                                <th>Country</th>
                                <th>Post Code</th>
                                <th>Phone Number</th>
                                <th>VAT No</th>
                                <th>Credit limit</th>
                                <th>On Hold</th>
                                <th>Sage Account</th>
                                <th>Balance Due A/C</th>
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


<!-- User Record Modal Starts -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    
</div>
<!-- User Record Modal End -->
<script type="text/javascript">

function add_new_customer(){

        $.ajax({
                    type: "post",
                    url: mainUrl+"credit_accounts/add_new_customer",
                    cache: false,               
                    data: '',
                    dataType: 'html',
                    success: function(data)
                    {                        
                        $('#exampleModal').html(data);
                        $('#exampleModal').modal('show');
                        
                    },
            error: function(){                      
            alert('Error while request..');
        }
                    
        });
        
    }
function search_statement(){

        $.ajax({
                    type: "post",
                    url: mainUrl+"credit_accounts/search_statement",
                    cache: false,               
                    data: '',
                    dataType: 'html',
                    success: function(data)
                    {                        
                        $('#exampleModal').html(data);
                        $('#exampleModal').modal('show');
                        
                    },
            error: function(){                      
            alert('Error while request..');
        }
                    
        });
        
    }


function update_new_customer(id){
        //alert("AAAAAAAAAAAA === "+id);
         var formData = {
            "UserID" : id,
        }
        $.ajax({
                    type: "post",
                    url: mainUrl+"credit_accounts/view_credit_account",
                    cache: false,               
                    data: formData,
                    dataType: 'html',
                    success: function(data)
                    {                        
                        $('#exampleModal').html(data);
                        $('#exampleModal').modal('show');
                        
                    },
            error: function(){                      
            alert('Error while request..');
        }
                    
        });
        
    }



    $(document).ready(function () {







             var datatable = $('#responsive-datatable').DataTable({
        "destroy": true,
         "processing": true,
         "serverSide": false,
         "ajax": mainUrl+"credit_accounts/credit_account_list",
         "columnDefs": [{ orderable: false } ]


        });
             $("#responsive-datatable_processing").show();
              $(".dataTables_empty").hide();

             $.fn.dataTable.ext.errMode = "none";

      $("#responsive-datatable, #responsive-datatable-statement, #responsive-datatable-payment, #responsive-datatable-order").on( "error.dt", function ( e, settings, techNote, message ) {
      console.log( "An error has been reported by DataTables: ", message );
      } ) ;

         });


</script>

