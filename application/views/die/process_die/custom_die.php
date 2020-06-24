<div class="wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                
                <div style=" margin-bottom: 6px;">
                    <a href= "<?=main_url?>dashboard/generate_pdf"  class="btn-approve  btn btn-outline-info waves-light waves-effect btn-sm"  type="button" target="_blank" >
                  Click To Generate Sheet Pdf </a>

                  <a href="<?=main_url?>dashboard/generate_pdf_roll" class="btn-approve  btn btn-outline-info waves-light waves-effect btn-sm"  type="button" target="_blank">
                  Click To Generate Roll Pdf </a>
                </div>
                

                <!----___----_____--___----__--__--__---____ Awaiting Custom Dies ----___----___--___--__--__----___---____-->
                <div class="card">
                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i>  Awaiting Custom Dies </span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body" id="custom_dies"></div>
                </div>

                <!----___---__--___----__--__--__---____ Awaiting Custom Die Oders ----___----___--___--__--__----___---____-->
                <div class="card" style="margin-top:2rem">
                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i> Awaiting Custom Die Oders </span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body" id="awaiting_orders"></div>
                </div>


                <!----___---__--___----__--__--__---____ Reorder Order ----___----___--___--__--__----___---____-->
                <div class="card" style=" margin-top:2rem">
                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i> Re-Order Dies</span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body" id="reoder_dies"></div>
                </div>


                <!----___---__--___----__--__--__---____ Awaiting Customers Approval ----___----___--___--__--__----___---____-->
                <div class="card" style="margin-top:2rem">
                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i> Awaiting Customer Approval</span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body" id="awiting_customer"></div>
                </div>

            </div>
        </div>

        <!-- en row -->
    </div>
    <!-- en container -->
</div>

<div class="modal fade bs-example-modal-lg" id="edit_info" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="max-width: 1024px !important;">
        <div class="modal-content blue-background" id="edit_info_data"></div>
    </div>
</div>


<script type="text/javascript">
    window.onbeforeunload = function () {
        $('#awaiting_die').DataTable().state.clear();
        $('#getAwaitingOrders').DataTable().state.clear();
        $('#getReorderOrders').DataTable().state.clear();
        $("#getCustomarAprovalTable").DataTable().state.clear();
    }
</script>

<script type="text/javascript">
    $("#pro_die_tab").on("click", function () {
        $('#awaiting_die').DataTable().state.clear();
        $('#getAwaitingOrders').DataTable().state.clear();
        $('#getReorderOrders').DataTable().state.clear();
        $("#getCustomarAprovalTable").DataTable().state.clear();
    });


    $(document).ready(function () {
        $('#pro_die_tab').trigger('click');
        customDies();
    });

    /* -----_____----____---___--__-_ Start Awaiting Die datatables Panel _-__--___---____----_____----- */


    function customDies() {


        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/getCustomOrdersListing",
            cache: false,
            data: {},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#custom_dies').html(data.html);
                customDiesTb();
                $('#aa_loader').hide();

                $('#awaiting_die_wrapper select, #awaiting_die_wrapper input').addClass("form-control form-control-sm");
            },
            error: function () {
                swal('warning', 'Error while request..', 'warning');
            }
        });
    }


    function customDiesTb() {

        $("#awaiting_die").dataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": false,
            "bServerSide": false,
            "bDestroy": true,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            "stateSave": true,
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            },
        });
    }


    /*-----_____----____---___--__-_ Edit Die info _-__--___---____----_____----- */

    $(document).on("click", ".editdetail", function (e) {

        $('#aa_loader').show();
        var serial = $(this).attr('data-id');
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/fetch_editdetail",
            cache: false,
            data: {serial: serial},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#edit_info_data').html(data.html);

                $('#aa_loader').hide();
                $('#edit_info').modal('show');
            },
            error: function () {
                $('#aa_loader').hide();
                swal('warning', 'Error while request..', 'warning');
            }
        });
    });

    /* -----_____----____---___--__-_ Comments section _-__--___---____----_____----- */

    $(document).on("click", ".addcomment", function (e) {
        var serial = $(this).attr('data-id');
        var quote = $(this).attr('data-q');
        //$("#dvLoading").css('display','block');
        $('#aa_loader').show();

        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/fetch_comments2",
            cache: false,
            data: {serial: serial, quote: quote},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#edit_info_data').html(data.html);
                $('#aa_loader').hide();
                $('#edit_info').modal('show');
            },
            error: function () {
                $('#aa_loader').hide();
                swal('warning', 'Error while request..', 'warning');
            }
        });
    });


    /* -----_____----____---___--__-_ pricing section _-__--___---____----_____-----*/


    $(document).on("click", ".pricing", function (e) {

        $('#aa_loader').show();
        var serial = $(this).attr('data-id');
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/fetch_pricing",
            cache: false,
            data: {serial: serial},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);

                $('#edit_info_data').html(data.html);
                $('#aa_loader').hide();
                $('#edit_info').modal('show');
            },
            error: function () {
                $('#aa_loader').hide();
                swal('warning', 'Error while request..', 'warning');
            }
        });
    });


    $(document).on("click", ".approveprice", function (e) {

        swal("Are you sure you want to continue?", {
            icon: 'warning',
            title: 'WARNING',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();

                        var serial = $(this).attr('data-id');

                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/approveprice",
                            cache: false,
                            data: {serial: serial},
                            dataType: 'html',
                            success: function (data) {
                                $('#aa_loader').hide();
                                swal('Success', 'Approved successfully', 'success');
                                customDies();
                            },
                            error: function () {
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            });

    });


    function removedie(serial) {

        swal("Are you sure you want to Remove line?", {
            icon: 'warning',
            title: 'WARNING',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Remove",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();

                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/removedie",
                            cache: false,
                            data: {serial: serial},
                            dataType: 'html',
                            success: function (data) {
                                swal('Success', 'Removed successfully', 'success');
                                $('#aa_loader').hide();
                                customDies();
                            },
                            error: function () {
                                $('#aa_loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            });
    }

    function getMaterial(id, quote, serial) {

        $('#aa_loader').show();

        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/fetch_material",
            cache: false,
            data: {id: id, quote: quote, serial: serial},
            dataType: 'html',
            success: function (data) {
                $('#aa_loader').hide();
                data = $.parseJSON(data);
                $('#edit_info_data').html(data.html);
                $('#edit_info').modal('show');
                //swal('Success','Removed successfully','success');


            },
            error: function () {
                swal('warning', 'Error while request..', 'warning');
                $('#edit_info').modal('hide');
                $('#aa_loader').hide();
            }
        });
    }


    $(document).on("click", ".approvepricing", function (e) {

        swal("Are you sure you want to Approve price?", {
            icon: 'warning',
            title: 'Warning',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Approve Prices",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":

                        var id = $(this).attr('data-id');
                        var cus_id = $(this).attr('data-cus-id');
                        var serial = $(this).attr('data-serial');
                        var price = $(this).attr('data-price');
                        var quote = $(this).attr('data-quote');


                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/applyoperator",
                            cache: false,
                            data: {serial: id, price: price},
                            dataType: 'html',
                            success: function () {
                                getMaterial(cus_id, quote, serial);
                            },
                            error: function () {
                                swal('warning', 'Error while request..', 'warning');
                                $('#edit_info').modal('hide');
                                $('#aa_loader').hide();
                            }
                        });
                        break;
                }
            });
    });


    /*=========================================END AWAITING DATATABLE PANEL=============================================*/

    /*=========================================END AWAITING ORDERS PANEL   =============================================*/


    $(window).on("load", function () {
    });

    $(document).ready(function () {
        getAwaitingOrders();
    });


    function awaitingOrderTb() {
        $("#getAwaitingOrders").DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": false,
            "bServerSide": false,
            "bDestroy": false,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            "stateSave": true,


            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }

        });
    }


    function getAwaitingOrders() {

        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/getAwaitingOrders",
            cache: false,
            data: {},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#awaiting_orders').html(data.html);
                awaitingOrderTb();

                $('#getAwaitingOrders_wrapper select, #getAwaitingOrders_wrapper input').addClass("form-control form-control-sm");

                $('#aa_loader').hide();

            },
            error: function () {
                swal('warning', 'Error while request..', 'warning');
            }
        });
    }

    $(document).on("click", ".comments", function (e) {
        var serial = $(this).attr('data-id');
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/fetch_comments",
            cache: false,
            data: {serial: serial},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#edit_info_data').html(data.html);
                $('#aa_loader').hide();
                $('#edit_info').modal('show');
            },
            error: function () {
                $('#edit_info').modal('hide');
                $('#aa_loader').hide();
                swal('warning', 'Error while request..', 'warning');
            }
        });
    });


    $(document).on("submit", ".updtfilepdf_aw_order", function (e) {

        e.preventDefault();
        var formData = new FormData(this);


        var id = $(this).attr('data-id');
        var svalue = $("#file_" + id).val();

        if (svalue == "" || svalue == " ") {
            swal('warning', 'please choose upload file', 'warning');
            return false;
        }


        swal("Are you sure Do You Wish to Continue ?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();

                        var id = $(this).attr('data-id');
                        var svalue = $("#file_" + id).val();


                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'html',
                            success: function (data) {
                                $('#aa_loader').hide();
                                swal('Success', 'File successfully updated', 'success');
                                getAwaitingOrders();
                            },
                            error: function (data) {
                                $('#aa_loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            })
    });


    function showCodeOnText(code, id, status, format) {
        if (status == 'Active') {
            //  $('#mid'+id).val((format == 'Roll'?code:'AA'+code));

            if (format == 'Roll') {
                code = code;
            } else if (format == 'A3') {
                code = 'A3' + code;
            } else if (format == 'A4') {
                code = 'AA' + code;
            } else if (format == 'SRA3') {
                code = 'SR' + code;
            }

            $('#mid' + id).val(code);

            $('#update_' + id).show();
            $('#view_code' + id).hide();
            $('#view_code' + id).removeClass('code');
            $('#edit_info').modal('hide');
        } else {
            $('#mid' + id).val('');
        }
    }


    function showCode(id, label, shape, format, width, height) {

        $('#aa_loader').show();
        $.ajax({
            type: "GET",
            url: mainUrl + "dies/dies/decideForCode",
            data: {id: id, label: label, shape: shape, format: format, width: width, height: height},
            dataType: "json",
            success: function (data) {
                $('#aa_loader').hide();
                if (data.error === 'yes') {

                    swal('Warning', data.message, 'warning');
                } else {
                    $('#aa_loader').hide();
                    $('#edit_info_data').html(data.html);
                    $('#edit_info').modal('show');
                }

            }
        });
    };


    $(document).on("click", ".update", function (e) {
        var _this = $(this);
        var id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        var value = $(this).parents('.section').find('.updaters').val();
        if (value == "") {
            alert('Field Cannot be empty');
            return false;
        }
        $('#view_code' + id).addClass('code');

        $.ajax({
            type: "POST",
            url: mainUrl + "dies/dies/updateproductsection",
            data: {id: id, value: value, type: type},
            dataType: "json",
            success: function (data) {
                if (data.response == "false") {
                    alert("Product Already Exist. Please Enter New Information");
                } else {
                    $(_this).hide();
                }
            }
        });
    });


    $(document).on("click", ".action", function (e) {

        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var serial = $(this).attr('data-serial');
        var order = $(this).attr('data-order');

        var productID = $(this).parents('tr').find("#pid").val();
        var dieCode = $(this).parents('tr').find("#mid").val();
        var option = $(this).parents('tr').find(".select_option").val();
        var image = $(this).parents('tr').find(".pdffile").val();


        if (image == '') {
            swal('Warning', 'Please Upload pdf', 'warning');
            return false;
        } else if (option == '') {
            swal('Warning', 'Please select an option.', 'warning');
            return false;
        } else if (dieCode == '' && status == 37) {
            swal('Warning', 'Please enter the New Diecode to proceed further.', 'warning');
            return false;
        }

        if (status == 73) {
            var value = prompt("Please enter Product Demo Link");

            if (!value) {
                return false;
            }
        }

        swal("Are you sure Do You Wish to Continue ?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();

                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/savedieline",
                            cache: false,
                            data: {
                                id: id,
                                option: option,
                                status: status,
                                productID: productID,
                                serial: serial,
                                value: value,
                                order: order
                            },
                            dataType: 'html',
                            success: function (data) {

                                $('#aa_loader').hide();
                                getAwaitingOrders();
                            },
                            error: function () {
                                $('#aa_loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            })
    });
</script>

<!--__------------_______-----_____Reorder Dies----_____------______-----______-->


<script>
    $(document).ready(function () {
        getReorderDie();
    });


    function reorderDieTb() {
        $("#getReorderOrders").DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": false,
            "bServerSide": false,
            "bDestroy": false,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            "stateSave": true,
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }
        });
    }

    function getReorderDie() {
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/getReorderOrdersListing",
            cache: false,
            data: {},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#reoder_dies').html(data.html);
                reorderDieTb();

                $('#getReorderOrders_wrapper select, #getReorderOrders_wrapper input').addClass("form-control form-control-sm");
                $('#aa_loader').hide();
            },
            error: function () {
                swal('warning', 'Error while request..', 'warning');
            }
        });
    }
</script>

<script>
    /*$(document).on("submit", "#edit_pdf", function(e) {
        var userfile = $("#file").val();
        var id = $('#ID').val();
        alert('custom_wala');

        if( userfile.length == 0){
            alert('Please Select File');
            $("#file").focus();
            return false;
        }
        var check = confirm(' Do You Wish to Continue ?');
        if(check){
            e.preventDefault();
            var formData = new FormData(this);
            $("#dvLoading").css('display','block');

            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(data){
                    if(data.file!=''){
                        $("#dvLoading").css('display','none');
                        var ref = "<?=base_url()?>theme/custom_dies/"+data.file;
						$('#uploaded_image').attr('src',ref);
						$('#lnkr').attr('href',ref);
						$("#file").val('');
						$('#validator'+id).val(data.file);
				  	
					}
				},
				error: function(data){
					console.log("error");
				}
			});
		}
	});*/
</script>


<script>
    $(document).on("click", ".processor2", function (e) {
        var id = $(this).attr('data-id');
        var display = $('#assmat2_' + id).css('display');
        if (display == 'table-row') {
            $('#assmat2_' + id).css('display', 'none');
        } else {
            $('#assmat2_' + id).css('display', 'table-row');
        }
    });


    function movetoproduction(diecode, serial, order, matid) {
        var check = confirm("Are you sure you want to Move line to production?");
        if (check) {
            $.ajax({
                type: "post",
                url: mainUrl + "dies/dies/movetoproduction",
                cache: false,
                data: {diecode: diecode, serial: serial, order: order, matid: matid},
                dataType: 'html',
                success: function (data) {
                    location.reload(true);
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        }
    }


    $(document).on("submit", ".updtfileform", function (e) {

        e.preventDefault();
        var formData = new FormData(this);

        var id = $(this).attr('data-id');
        var svalue = $("#file_" + id).val();

        if (file == "" || file == " ") {
            alert('please choose upload file');
            return false;
        }


        swal("Are you sure Do You Wish to Continue ?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();

                        var id = $(this).attr('data-id');
                        var svalue = $("#file_" + id).val();

                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'html',
                            success: function (data) {
                                data = $.parseJSON(data);
                                $('#aa_loader').hide();
                                $('#edit_info_data').html(data.html);
                                swal('Success', 'File successfully updated', 'success');
                            },
                            error: function (data) {
                                $('#edit_info').modal('hide');
                                $('#aa_loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            })
    });


    $('document').ready(function () {
        getCustomarAprovalView();
    });


    function getCustomarAprovalTb() {
        $("#getCustomarAprovalTable").DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": false,
            "bServerSide": false,
            "bDestroy": false,
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            "stateSave": true,
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }
        });
    }

    function getCustomarAprovalView() {
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/getCustomarAprovalView",
            cache: false,
            data: {},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#awiting_customer').html(data.html);
                getCustomarAprovalTb();

                $('#getCustomarAprovalTable_wrapper select, #getCustomarAprovalTable_wrapper input').addClass("form-control form-control-sm");
                $('#aa_loader').hide();
            },
            error: function () {
                swal('warning', 'Error while request..', 'warning');
            }
        });
    }
</script>