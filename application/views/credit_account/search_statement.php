<div id="imp_view_statement">

<div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-body account-body">


<div class="row">


                <div class="col-md-12 text-center"><h3 style="font-size: 20px;    font-weight: bold;    color: #006ca5!important;line-height: normal;margin-top: 0px;">View Customer Account Statement</h3></div>
                
                <button style="right: 8px; top: 8px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></button>

            </div>


                <form method="post" id="searchfrm" class="labels-form " enctype="multipart/form-data" action="">

                <div class="tab-content ">

                    

                        <div class="row" style="margin-bottom: 10px;">





                            <div class="col-md-5">

                                <label class="select">

                                    <select name="search_by" id="search_by" class="required">

                                        <option value="">Select Field</option>

                                        <option value="Id">Customer ID</option>

                                        <option value="Name">Name</option>

                                        <option value="Email">Email</option>

                                        <option value="Company">Company</option>

                                    </select>

                                    <i></i> </label>

                            </div>

                            <div class="col-md-2"></div>



                            <div class="col-md-5">



                                <label class="input"> <i class="icon-append  fa-user"></i>

                                    <input type="text" name="search" placeholder="Enter Detail" id="search" class="required"

                                           aria-required="true">

                                </label>



                            </div>

                        </div>





                        <div class="row" style="margin-bottom: 10px;">





                            <div class="col-md-5">



                                <!-- <label class="input"> <i class="icon-append  fa-calendar"></i>

                                    <input type="date" name="start_date" placeholder="Start Date" id="start_date" class="required"

                                           aria-required="true">

                                </label> -->



                                <div class=" labels-form">

                <label class="input"> <i class="icon-append fa fa-calendar"></i>

                <!-- <input type="date" name="rep_from" id="rep_from" required>-->

                <input type="text" value="" name="start_date" id="start_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false">

                </label>

            </div>



                            </div>

                            <div class="col-md-2"></div>



                            <div class="col-md-5">



                                <!-- <label class="input"> <i class="icon-append  fa-calendar"></i>

                                    <input type="date" name="end_date" placeholder="End Date" id="end_date" class="required"

                                           aria-required="true">

                                </label> -->

                            <div class=" labels-form">

                <label class="input"> <i class="icon-append fa fa-calendar"></i>

                <!-- <input type="date" name="rep_from" id="rep_from" required>-->

                <input type="text" value="" name="end_date" id="end_date" class="form-control" data-toggle="datepicker" placeholder="dd/mm/yyy" required onkeydown="return false">

                </label>

            </div>



                            </div>





                        </div>





                        <label class="select" style="margin-bottom: 10px;">



                            <select name="statement" id="statement" class="required">

                                <option value="Outstanding">All Outstanding Invoices</option>

                                <option value="Full" selected="selected">Full Statement</option>

                            </select>

                            <i></i> </label>





                    

                </div>



                <div class="text-center">

                    <div>

                    <span class=" m-r-10"><button type="button"

                                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal">CLOSE</button></span>

                        <span><button type="submit"

                                      class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" >VIEW STATEMENT</button></span>

                    </div>

                </div>

                </form>

            </div>

        </div>

    </div>

</div>

    <script type="text/javascript">

            $(document).ready(function () {





 $('#searchfrm').submit(function(e){

       //alert('fdsfsdfsdf === '+$('#customer').val());

        var formData = {

            "statement" : $('#statement').val(),

            "start_date" : $('#start_date').val(),

            "end_date" : $('#end_date').val(),

            "search_by" : $('#search_by').val(),

            "search" : $('#search').val(),

            

        }

        $.ajax({

                    type: "post",

                    url: mainUrl+"credit_accounts/view_statement",

                    cache: false,               

                    data: formData,

                    dataType: 'html',

                    success: function(data)

                    {                        

                        //$('#exampleModal').html(data);

                        //$('#exampleModal').modal('hide');

                        $('#imp_view_statement').html(data);

                        

                    },

            error: function(){                      

            alert('Error while request..');

        }

                    

        });



         e.preventDefault();

        

    });

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