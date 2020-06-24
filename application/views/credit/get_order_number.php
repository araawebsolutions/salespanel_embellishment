<style>
    .byCustName{
        display: none;
    }


</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg text-center">
                        <div class="col-md-6 center-page m-t-t-10">
                            <span class="returns-title">CREDIT NOTE FORM</span>
                            <hr>
                            <span class="return-title-text">Please Fill This Form To Add Enquiry</span>

                        </div>
                    </div>
                    <div class="card-body">

                        <!-- <form method="post" id="" class="labels-form " enctype="multipart/form-data" action="<?php echo main_url ?>tickets/addTickets/addpix">
                            <p><input type="file" multiple="multiple" name="ticketImage[]" class="form-control" /></p>
                            <p><input type="file" multiple="multiple" name="ticketEmail[]" class="form-control" /></p>
                            <p><input type="file" multiple="multiple" name="ticketAudio[]" class="form-control" /></p>
                        <button type="submit">go</button>
                        </form>-->


                        <?php if(!@$_GET['form']){ ?>
                            <form method="post" id="byOrderNum" class="labels-form" enctype="multipart/form-data" action="<?php echo main_url ?>credit-notes/find-orders">
                                <div class="row" id="search_by_order_no">
                                    <div class="col-md-3">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append mdi mdi-cart-plus icon-appendss"></i>
                                                <input type="text" placeholder="Search Order Numbers e.g AA00,AA11" name="orderNumber"
                                                       id="orderNumber" value="<?php echo $order_numbers ?>" class="required input-border-blue" title="" multiple required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">

                                            </label>

                                        </div>

                                    </div>

                                    <div class="col-xs-1">
                                        <button type="submit" class="btn btn-outline-info waves-light waves-effect p-6-10">Search <i class="fa fa-arrow-right"></i></button>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-margin-10">
                                            <!--<label class="input ">
                                                <input type="text" placeholder="Search by Customer Name" name="searchByCustomerName"
                                                       id="searchByCustomerName" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" style="cursor:pointer">
                                            </label>-->

                                            <button type="button" id="searchByCustomerName" class="btn btn-outline-info waves-light waves-effect p-6-10 ">Search by Customer Name </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                        <?php //echo '<pre>'; print_r($result); echo '</pre>'; ?>

                        <?php if(@$_GET['form']=='customer'){ ?>
                            <form method="post" id="byCustName" class="labels-form " enctype="multipart/form-data" action="<?php echo main_url ?>tickets/addTickets/findCustomersOrders">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                                <input type="text" placeholder="Customer Name" name="customer_name"
                                                       id="customer_name" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                                <input type="email" placeholder="Email Address" name="email_address"
                                                       id="email_address" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                                <input type="text" placeholder="Phone Number" name="ph_no"
                                                       id="ph_no" value="" class="required input-border-blue"
                                                       data-content="" data-original-title="" title="" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="select">
                                                <select name="duration" id="duration" class="required input-border-blue" required>
                                                    <option value="">Select Duration</option>
                                                    <option value="7">Last 7 Days</option>
                                                    <option value="30" >Last 30 Days</option>
                                                    <option value="90" >Last 3 Months</option>
                                                    <option value="180">Last 6 Months</option>
                                                    <option value="All">Show All</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="input-margin-10">
                                            <label class="select ">

                                                <!-- <select class="required input-border-blue" id="ordernumOpt" name="orderNumber[]" multiple="multiple" required>
                                                      <option value="" disabled>Order Number</option>
                                                  </select>-->

                                                <!--<select class="selectpicker" data-live-search="false" id="ordernumOpt"  name="orderNumber[]" required multiple>
                                                </select>-->


                                                <select class="js-example-basic-single required input-border-blue" id="ordernumOpt"  name="orderNumber[]" required multiple="multiple">
                                                </select>
                                                <i></i>

                                            </label>
                                        </div>
                                    </div>





                                    <div class="col-md-1">
                                        <div class="input-margin-10">
                                            <button id="sub_id" class="btn btn-outline-info waves-light waves-effect p-6-27" type="submit">Search <i class="fa fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="input-margin-10">
                                            <a href="<?php echo main_url ?>tickets/addTickets" class="btn btn-outline-info waves-light waves-effect p-6-27 " ><i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        <?php } ?>




                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>
<!-- en wrapper -->


<!-- Designer Checklist Popup Start -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">HINTS & TIPS</h4>
                    <p class="timeline-detail text-center">Please check following points which can help out to further
                        investigate this case</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">


                    <table class="table table-bordered taable-bordered f-14">
                        <thead>
                        <tr>
                            <th class="text-center">Sr.</th>
                            <th>Questions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Order history reviewed?</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Emails reviewed?</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Live Chats reviewed?</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Phone calls checked & listened to?</td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Prior complaints/returns etc? (This customer/material/issue)</td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Control Samples checked?</td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>Test printing (including template issues) checked?</td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td>Any relevant Print Job reference included?</td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td>Returns – stock item? Consider requesting sales report?</td>
                        </tr>
                        <tr>
                            <td class="text-center">10</td>
                            <td>Images sent to support reason for contact attached?</td>
                        </tr>
                        <tr>
                            <td class="text-center">11</td>
                            <td>Copy of relevant emails/live chats set out in this document?</td>
                        </tr>
                        <tr>
                            <td class="text-center">12</td>
                            <td>Copy of order details or other relevant back office info attach</td>
                        </tr>
                        <tr>
                            <td class="text-center">13</td>
                            <td>Screenshots of relevant website info attached (to include URL info)</td>
                        </tr>
                        <tr>
                            <td class="text-center">14</td>
                            <td>Links to websites used in research (e.g. printer manuals) attached</td>
                        </tr>


                        </tbody>
                    </table>

                    <ul class="dropdown-menu inner show">
                        <li>
                            <a role="option" class="dropdown-item selected" aria-disabled="false" tabindex="0" aria-selected="true"><span class=" bs-ok-default check-mark"></span><span class="text">Design Team</span></a>
                        </li>
                    </ul>

                    <div class="text-center">
                    <span class="m-t-t-10">
                        <button type="button"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 p-6-27">CLOSE</button></span>
                    </div>


                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Designer Checklist End -->

<script type="text/javascript">


    $(document).ready(function () {

        $('.js-example-basic-single').select2({
            tags: true,
            placeholder: "Select Orders",
            allowClear: true
            //tokenSeparators: [',', ' ']
        });

        //$('.dropdown ul').append("<li><option value='sd'>sadsad</option></li>");

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf']
        });

        // Responsive Datatable
        $('#responsive-datatable').DataTable();

        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });


    $('#orderNumber').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9,-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;
    });

    $('#orderNumber').change(function(){
        var vals = $(this).val();

    });

    $('#gos').click(function(){
        var vals = $('#orderNumber').val();

        if(vals){
            $('#byOrderNum').submit();
        }else{
            $('#orderNumber').focus();
            $('#orderNumber').prop('required',true);
        }

    });

    $('#searchByCustomerName').click(function(){
        //$('#byOrderNum').hide();
        //$('#byCustName').show();
        url = $(location).attr('href');
        //url = url.substr(0, url.lastIndexOf("/"));
        //url = url+'/findCustomers';
        //alert(url)
        //location(url);
        window.location.href = url+'?form=customer';
    });



    $('#email_address,#ph_no,#duration,#customer_name').change(function () {

        var name = $('#customer_name').val();
        var email_address = $('#email_address').val();
        var ph_no = $('#ph_no').val();
        var duration = $('#duration').val();
        if (name!="" && email_address != "" && ph_no != "" && duration != "") {
            getCustOrders(name,email_address, ph_no, duration);
        }
    });


    function getCustOrders(name,email_address,ph_no,duration){


        $.ajax({
            type: "post",
            async:"false",
            url: mainUrl+"tickets/addTickets/fetchOrdersBycustomer",
            cache: false,
            data:{
                name:name,
                email_address:email_address,
                ph_no:ph_no,
                duration:duration
            },
            success: function(data){
                $('#ordernumOpt').empty();
                $('#ordernumOpt').val('');
                $('#ordernumOpt').append("<option value='' disabled>Please Choose</option>");

                if(data){
                    data = $.parseJSON(data);
                    appendOrderNum(data);
                }else{
                    swal("Warning!", "Sorry, this user have no orders", "warning");
                }
            },
            error: function(){
                alert('Error while request..');
            }
        });
    }



    $('#sub_id').click(function(){

        var cn = $('#customer_name').val();
        var ea = $('#email_address').val();
        var pn = $('#ph_no').val();
        var d = $('#duration option:selected').val();
        var o = $('#ordernumOpt').val();


        if(o=="" && cn!="" && pn!="" &&  ea!="" && d!="" ){
            swal("Warning!", "Please Choose atleast one order", "warning");
            return false;
        }
    });




    function appendOrderNum(data){

        //$('.dropdown ul').append("<li><option value='sd'>sadsad</option></li>");
        data.forEach(function(item, index, array) {

            var orderNumber =  array[index]['OrderNumber'];
            $('#ordernumOpt').append("<option value="+orderNumber+">"+orderNumber+"</option>");

            //$('.dropdown ul').html("<li><a role='option' class='dropdown-item' aria-disabled='false' tabindex='0' aria-selected='false'><span class='bs-ok-default check-mark'></span><span class='text'>"+orderNumber+"</span></a></li>");
        });
    }


    /*var changed;
    $('select[multiple="multiple"]').change(function(e) {
        var select = $(this);
        var list = select.data('prevstate');
        var val = select.val();
        if (list == null) {
            list = val;
        } else if (val.length == 1) {
            val = val.pop();
            var pos = list.indexOf(val);
            if (pos == -1)
                list.push(val);
            else
                list.splice(pos, 1);
        } else {
            list = val;
        }
        select.val(list);
        select.data('prevstate', list);
        changed = true;
    }).find('option').click(function() {
        if (!changed){
            $(this).parent().change();
        }
        changed = false;
    });*/

    // $('select').selectpicker();









</script>


<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>-->



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>