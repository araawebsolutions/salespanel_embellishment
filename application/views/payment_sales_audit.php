<style type="text/css">

    table{

        width: 100%;

        margin-bottom: 0.6rem; 

    }
    .audit-table-red, .audit-table-red a{

        color: #ff0000;
    }
    .audit-table a{
        color: #666666;
    }

</style>
<div class="wrapper">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card ">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="card enquiry-card">

                                    <div class="card-header card-heading-text-two">PAYMENTS AUDIT</div>

                                    <div class="card-body">

                                        <form method="post" id="payment-audit-form" class="labels-form "

                                               enctype="multipart/form-data" action="">

                                            <div class="row">

                                                <div class="col-md-5">
                                                    <div class=" labels-form">

                                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>

                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->

                                                        <input type="text" value="" name="start_date" id="pstart_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" />

                                                        </label>

                                                    </div>

                                                </div>



                                                <div class="col-md-2"></div>
                                                <div class="col-md-5">
                                                    <div class=" labels-form">

                                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>

                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->

                                                        <input type="text" value="" name="end_date" id="pend_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" />

                                                        </label>

                                                    </div>

                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="m-t-t-10 col-md-4">
                                                    <button type="reset"
                                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">
                                                        Reset
                                                    </button>
                                                </div>

                                                <div class="col-md-4"></div>
                                                <div class="m-t-t-10 col-md-4 text-right">
                                                    <button type="submit"
                                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save">
                                                        Show Report
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="card enquiry-card">

                                    <div class="card-header card-heading-text-two">SALES AUDIT</div>

                                    <div class="card-body">

                                        <form method="post" id="sale-audit-form" class="labels-form "

                                              enctype="multipart/form-data" action="">

                                            <div class="row">


                                                <div class="col-md-5">
                                                    <div class=" labels-form">

                                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <input type="text" value="" name="start_date" id="sstart_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" />

                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-2"></div>
                                                <div class="col-md-5">
                                                    <div class=" labels-form">
                                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                                                        <input type="text" value="" name="end_date" id="send_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="m-t-t-10 col-md-4">
                                                   <button type="reset"
                                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">
                                                        Reset
                                                    </button>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="m-t-t-10 col-md-4 text-right    ">
                                                    <button type="submit"
                                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save">
                                                        Show Report
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">CREDIT ACCOUNT SALES</div>
                                    <div class="card-body">
                                        <form method="post" id="caccount-audit-form" class="labels-form "
                                              enctype="multipart/form-data" action="">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class=" labels-form">
                                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                                                        <input type="text" value="" name="start_date" id="astart_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-5">
                                                    <div class=" labels-form">
                                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                        <!-- <input type="date" name="rep_from" id="rep_from" required>-->
                                                        <input type="text" value="" name="end_date" id="aend_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="m-t-t-10 col-md-4">
                                                    <button type="reset"
                                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">
                                                        Reset
                                                    </button>
                                                </div>
                                                <div class="col-md-4"></div>

                                                <div class="m-t-t-10 col-md-4 text-right    ">
                                                    <button type="submit" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save">
                                                        Show Report
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div id="payment-div" class="card enquiry-card">
                                    <?php $pvatables = '';?>

                                    <div class="card-header card-heading-text-two">VATABLE</div>

                                        <center><h5> No Record Found</h></center>
                                        <?php echo $pvatables; ?>
                                        <br>
                                        <div class="card-header card-heading-text-two">VAT EXEMPT</div>
                                         <center><h5> No Record Found</h></center>
                                       <?php $avatables = ''; echo $avatables; ?>
                                        <br>
                                        <div class="card-header card-heading-text-two">VATABLE</div>
                                        <center><h5> No Record Found</h></center>
                                        <?php $pnovatables=''; echo $pnovatables; ?>
                                         <br>
                                        <div class="card-header card-heading-text-two">VAT EXEMPT</div>
                                        <center><h5> No Record Found</h></center>
                                        <?php $pnovatexempts =''; echo $pnovatexempts; ?>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div id="sale-div" class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">VATABLE</div>
                                     <center><h5> No Record Found</h></center>
                                         <?php $svatables =''; echo $svatables; ?>
                                      <br>
                                       
                                        <div class="card-header card-heading-text-two">VAT EXEMPT</div>
                                        <center><h5> No Record Found</h></center>
                                         <?php $svatexempts= ''; echo $svatexempts; ?>
                                        <br>
                                        
                                        <div class="card-header card-heading-text-two">VATABLE</div>
                                        <center><h5> No Record Found</h></center>
                                        <?php $snovatables=''; echo $snovatables; ?>
                                         <br>
                                         
                                        <div class="card-header card-heading-text-two">VAT EXEMPT</div>
                                        <center><h5> No Record Found</h></center>
                                        <?php $snovatexempts =''; echo $snovatexempts; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div id="caccount-div" class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">VATABLE</div>
                                    
                                      <center><h5> No Record Found</h></center>
                                        <?php $avatables = ''; echo $avatables; ?>
                                        <br>
                                        <div class="card-header card-heading-text-two">VAT EXEMPT</div>
                                         <center><h5> No Record Found</h></center>
                                       <?php $avatexempts=''; echo $avatexempts; ?>
                                        <br>
                                        <div class="card-header card-heading-text-two">VATABLE</div>
                                         <center><h5> No Record Found</h></center>
                                        <?php $anovatables= ''; echo $anovatables; ?>
                                        <br>
                                        <div class="card-header card-heading-text-two">VAT EXEMPT</div>
                                         <center><h5> No Record Found</h></center>
                                        <?php  $anovatexempts=''; echo $anovatexempts; ?>
                                   </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>

    
</div>
<script type="text/javascript">

$(document).ready(function () {

/* Payment  Form*/    

    $('#payment-audit-form').submit(function(e){
    $('#aa_loader').show();
        e.preventDefault();

       // alert($('#pstart_date').val());

        var formData = {

            "start_date" : $('#pstart_date').val(),

            "end_date" : $('#pend_date').val(),

            "postType" : 'payment'

        }

            $.ajax({

                type: "post",

                    url: mainUrl+"payment_sales_audit/ajax_page",

                    cache: false,               

                    data: formData,

                    dataType: 'html',

                    success: function(data)
                    {
                        $('#payment-div').html(data);
                          $('#aa_loader').hide();

                    },

            error: function(){                      
        }

            });

    });



/* Sale Form */



$('#sale-audit-form').submit(function(e){
        $('#aa_loader').show();
        e.preventDefault();

        var formData = {

            "start_date" : $('#sstart_date').val(),

            "end_date" : $('#send_date').val(),

            "postType" : 'sale'

        }
            $.ajax({

                type: "post",

                    url: mainUrl+"payment_sales_audit/ajax_page",

                    cache: false,               

                    data: formData,

                    dataType: 'html',

                    success: function(data)

                    {                        
                        $('#sale-div').html(data);
                        $('#aa_loader').hide();
                        

                    },

            error: function(){                      

        }

            });

    });


/* C Account Form */

$('#caccount-audit-form').submit(function(e){
        $('#aa_loader').show();
        e.preventDefault();

        var formData = {

            "start_date" : $('#astart_date').val(),

            "end_date" : $('#aend_date').val(),

            "postType" : 'caccount'

        }
            $.ajax({

                type: "post",

                    url: mainUrl+"payment_sales_audit/ajax_page",

                    cache: false,               

                    data: formData,

                    dataType: 'html',

                    success: function(data)

                    {                        

                        $('#caccount-div').html(data);
                        $('#aa_loader').hide();
                    },

            error: function(){                      

        }

            });    

    });

});



function exportExcel(url){

    window.open(url, '_blank');

}

function exportPdf(url){

    window.open(url, '_blank');
}


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