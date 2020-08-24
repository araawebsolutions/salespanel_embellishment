<style>
    .padman {
        margin-bottom: 10px;
        width: 150px;
    }

    .return-title-texts {
        margin: 0px -5px;
    }
</style>
<div class="modal-content blue-background">
    <div class="modal-header checklist-header">
        <div class="col-md-12">
            <h4 class="modal-title checklist-title" id="myLargeModalLabel">Die Code# <?= @$diecode ?> Reorder Die
                Prices</h4>
        </div>
    </div>
    <div class="modal-body p-t-0">
        <div class="panel-body">

            <?php $j_arr = json_encode($result); ?>
            <div style="<?php if (count($result) > 9) {
                echo 'height:350px;';
            } ?> overflow:auto">
                <table class="table table-bordered taable-bordered f-14">
                    <thead>
                    <tr>
                        <th width="1%" class="text-center">Sr#</th>
                        <th width="15%" class="text-center">Supplier</th>
                        <th width="20%" class="text-center">Cost Price</th>
                        <th width="20%" class="text-center">Sales Price</th>
                        <th width="20%" class="text-center">File</th>
                        <th width="10%" class="text-center">Time</th>
                        <th width="5%" class="text-center">Apply</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="">
                    <?php

                    $i = 1;
                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            ?>

                            <tr>
                                <td class="text-center"><b><?= $i ?></b></td>

                                <td>
                                    <div class="labels-form">
                                        <label class="input" style="margin-bottom:0">
                                            <input type="text" id="supplier_<?= $row->ID ?>"
                                                   value="<?= $row->supplier ?>"
                                                   class="updatesupply form-control input-border-blue"
                                                   data-id="<?= $row->ID ?>">
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group" style="flex-wrap: unset; height: 2rem; ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                  style="background-color: #ffffff; border: 1px solid #d0effa;"
                                                  id="basic-addon1">£</span>
                                        </div>

                                        <input data-id="<?= $row->ID ?>" step="any" type="number"
                                               id="cost_<?= $row->ID ?>" placeholder="Enter Price"
                                               value="<?= $row->price ?>"
                                               class="form-control input-border-blue inputPrice updatesupply">
                                    </div>
                                </td>

                                <td class="">
                                    <div class="input-group" style="flex-wrap: unset; height: 2rem; ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                  style="background-color: #ffffff; border: 1px solid #d0effa;"
                                                  id="basic-addon1">£</span>
                                        </div>

                                        <input data-id="<?= $row->ID ?> " step="any" type="number"
                                               id="sale_<?= $row->ID ?>" placeholder="Enter Price"
                                               value="<?= $row->sprice ?>"
                                               class="form-control input-border-blue inputPrice updatesupply">
                                    </div>
                                </td>

                                <td>
                                    <div style="display:flex" class="text-center">
                                        <?php

                                        $path = '';
                                        $href = custom_die_pdf_read . $row->pdf;
                                        $pdftext = (isset($row->pdf) && $row->pdf != "") ? "Edit Pdf" : "Add Pdf";

                                        if (isset($row->pdf) && $row->pdf != "") {
                                            ?>
                                            <a href="<?= $href ?>" target="_blank" id="lnkr" download>
                                                <button title="Download attachment" type='button'
                                                        class='btn btn-outline-info waves-light waves-effect btn-sm'
                                                        style="margin-right:2px"><i class="fa fa-download"
                                                                                    aria-hidden="true"></i></button>
                                            </a>
                                        <? } ?>

                                        <button title="<?= $pdftext ?> File" data-id="<?= $row->ID ?>"
                                                class="btn btn-outline-info waves-light waves-effect editpdfs btn-sm"
                                                id="edit_<?= $row->ID ?>" onclick="showfile(<?= $row->ID ?>)"><i
                                                    class="fa fa-pencil"></i> <?= $pdftext ?></button>


                                        <form class="updtfileform_reorder" enctype="multipart/form-data"
                                              action="<?php echo main_url ?>dies/dies/updtfile_reorderFlexiblepricing"
                                              style="display:none" data-id="<?= $row->ID ?>"
                                              id="updtfile_<?= $row->ID ?>">

                                            <input style="width:100%"
                                                   class="btn btn-outline-info waves-light waves-effect hintsbtn up_file"
                                                   type="file" id="file_<?= $row->ID ?>" name="file" accept="pdf"/>
                                            <input type="hidden" value="<?= $row->ID ?>" name="ID">
                                            <input type="hidden" value="<?= $serial ?>" name="serial">

                                            <button title="Update Pdf File" style="margin-top:0.5rem"
                                                    class='btn btn-outline-dark waves-light waves-effect up_btn btn-sm'
                                                    disabled>Update
                                            </button>

                                            <button type="button" onclick="can_btn(<?= $row->ID ?>)" title="cancel"
                                                    style="margin-top:0.5rem"
                                                    class='btn btn-outline-dark waves-light waves-effect up_btn btn-sm can_id'>
                                                <i class="fa fa-times"></i></button>
                                        </form>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <?php echo date('d-m-Y', ($row->Time)); ?>
                                    <br/>
                                    <?php echo date('<b> h : i  A</b>', ($row->Time)); ?>
                                </td>

                                <? $counting = $this->die_model->reorder_flexiblepricing($serial); ?>
                                <? $checker = (count($counting) > 1) ? 1 : 0; ?>

                                <td class="text-center">

                                    <?php if ($row->status == '1') { ?>
                                        <button type='button'
                                                class='btn btn-outline-dark waves-light waves-effect btn-countinue'>
                                            Applied
                                        </button>

                                    <?php } ?>

                                    <?php if ($row->status == '0') { ?>
                                        <button data-id="<?= $row->ID ?>" data-value="<?= $serial ?>" type='button'
                                                class='applier btn btn-outline-info waves-light waves-effect'
                                                style="margin-right:2px" data-check="<?= $checker ?>">Apply
                                        </button>

                                    <?php } ?>

                                </td>


                                <td class="text-center">
                                    <a title="Update price" data-id="<?= $row->ID ?>" data-value="<?= $serial ?>"
                                       class="editabless btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1"
                                       style="cursor:pointer;display:none;" id="editable<?= $row->ID ?>"><i
                                                class="fa fa-floppy-o"> </i></a>


                                    <a title="remove price" data-id="<?= $row->ID ?>" data-value="<?= $serial ?>"
                                       class="deleter btn btn-outline-info waves-light waves-effect"
                                       style="cursor:pointer;" id="deleter<?= $row->ID ?>"><i class="fa fa-trash-o"></i></a>
                                </td>


                            </tr>
                            <? $i++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="8" style="text-align:center">
                                <h5>Sorry record not found</h5>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <br>
            <div id="adder" style=" display:none ">
                <div>
                    <div class="col-md-12">
                        <span class="return-title-texts">ADD PRICE</span>
                        </br>
                    </div>

                    <form id="add_reorder_flexiblepricing" enctype="multipart/form-data"
                          action="<?php echo main_url ?>dies/dies/save_reorder_flexiblepricing">

                        <div class="row">
                            <div class="col-md-3"><b>Supplier:</b>
                                <div class="labels-form">
                                    <label class="input" style="margin-bottom:0">
                                        <input type="text" placeholder="Enter Supplier" id="supplier" name="supplier"
                                               class="padman form-control input-border-blue"/>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3"><b>Cost Price:</b>
                                <div class="input-group" style="flex-wrap: unset; height: 2rem; ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                              style="background-color: #ffffff; border: 1px solid #d0effa;"
                                              id="basic-addon1">£</span>
                                    </div>

                                    <input type="number" step="any" id="price" name="value"
                                           class="form-control input-border-blue inputPrice padman"
                                           placeholder="Cost Price" value="" onblur="calsale();">
                                </div>
                            </div>

                            <div class="col-md-3"><b>Sales Price:</b>
                                <div class="input-group" style="flex-wrap: unset; height: 2rem;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                              style="background-color: #ffffff; border: 1px solid #d0effa;"
                                              id="basic-addon1">£</span>
                                    </div>

                                    <input type="number" step="any" placeholder="Sales Price" id="sprice" name="svalue"
                                           class="form-control input-border-blue inputPrice padman" value=""
                                           onblur="calsale2();">
                                </div>
                            </div>

                            <div class="col-md-3 form-group"><b style="display: block;">Upload Pdf:</b>


                                <div class="upload-btn-wrapper"></div>
                                <input style="width:100%" type="file" id="file" name="file"
                                       class="btn btn-outline-info waves-light waves-effect hintsbtn"/>
                            </div>
                        </div>

                        <input type="hidden" value="<?= $serial ?>" id="ID" name="serial">

                        <button type="submit" id="save" class="btn btn-outline-info waves-light waves-effect p-6-10">
                            Save
                        </button>

                        <button type="button" id="show_foo"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Cancel
                        </button>


                    </form>
                </div>
            </div>

            <span class="m-t-t-10 pull-right">
				<button data-dismiss="modal" type="button"
                        class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button>
			</span>
            <span class="m-t-t-10 pull-right">
				<button type="button" id="foo" class="btn btn-outline-info waves-light waves-effect p-6-10 m-r-10">Add Price </button>
			</span>
        </div>
    </div>
</div>

<script>
    $('#foo').click(function () { // the button - could be a class selector instead
        $(this).hide();
        $('#adder').show();
    });
    $('#show_foo').click(function () { // the button - could be a class selector instead
        $('#adder').hide();
        $('#foo').show();

        $('#supplier').val('');
        $('#price').val('');
        $('#sprice').val('');
        $('#file').val('');
    });


    function showfile(id) {
        $('#updtfile_' + id).show();
        $('#edit_' + id).hide();
        show_hide(id);
    }


    function show_hide(id) {
        var data = $.parseJSON('<?=$j_arr?>');

        for (i = 0; i < data.length; i++) {
            var obj = data[i];
            var row_id = obj.ID;

            if (row_id == id) {
                $('#updtfile_' + id).show();
                $('#edit_' + id).hide();
            }

            if (row_id != id) {
                $('#updtfile_' + row_id).css("display", "none");
                $('#edit_' + row_id).css("display", "inline");
            }
        }
    }


    function can_btn(id) {

        $('#updtfile_' + id).css("display", "none");
        $('#edit_' + id).css("display", "inline");
    }


    $(document).on("change", ".updatesupply", function (e) {
        var id = $(this).attr('data-id');
        var tprice = parseFloat($("#cost_" + id).val());
        value = tprice.toFixed(2)
        $("#cost_" + id).val(value);

        var sprice = value / 0.7;
        sprice = sprice.toFixed(2)
        $("#sale_" + id).val(sprice);


        var data = $.parseJSON('<?=$j_arr?>');

        for (i = 0; i < data.length; i++) {
            var obj = data[i];
            var row_id = obj.ID;

            if (row_id == id) {

                $('#editable' + id).css('display', 'inline-block');
                $('#deleter' + id).css('display', 'none');
            }

            if (row_id != id) {
                $('#editable' + row_id).css('display', 'none');
                $('#deleter' + row_id).css('display', 'inline-block');
            }
        }
    });

    function calsale() {
        var tprice = parseFloat($('#price').val());
        price = tprice.toFixed(2)
        $('#price').val(price);

        var sprice = tprice / 0.7;
        sprice = sprice.toFixed(2)
        $('#sprice').val(sprice);
    }

    function calsale2() {
        var tprice = parseFloat($('#sprice').val());
        price = tprice.toFixed(2)
        $('#sprice').val(price);
    }


    $('.deleter').click(function () { // the button - could be a class selector instead

        swal("Are you sure Do You want to Delete this line ?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Yes",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('.loader').show();

                        var id = $(this).attr('data-id');
                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/delete_reorderFlexiblepricing",
                            cache: false,
                            data: {id: id, serial: '<?=$serial?>'},
                            dataType: 'html',
                            success: function (data) {

                                data = $.parseJSON(data);
                                $('#edit_info_data').html(data.html);
                                var count_prices = data.count;
                                var count_rem_lin = 0;
                                if (count_prices == 0) {
                                    count_rem_lin = 'Add Price';
                                } else {
                                    count_rem_lin = 'View Prices';
                                }
                                getReorderDie();
                                $('.loader').hide();
                                swal('Success', 'Line Delete successfully', 'success');
                            },
                            error: function () {
                                swal('warning', 'Error while request..', 'warning');
                                $('#edit_info').modal('hide');
                                $('.loader').hide();
                            }
                        });
                        break;
                }
            });
    });

    $('.applier').click(function () { // the button - could be a class selector instead

        var checkpoint = $(this).attr('data-check');
        if (checkpoint == 0) {
            swal('Warning', 'Please add atleast two supplier quotes before applying any price.', 'warning');
            return false;
        }

        swal("Are you sure This Price will be applied to this die. Do You want to Apply Price ?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Yes",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('.loader').show();

                        var id = $(this).attr('data-id');

                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/reorder_apply_price",
                            cache: false,
                            data: {id: id, serial: '<?=$serial?>'},
                            dataType: 'html',
                            success: function (data) {
                                data = $.parseJSON(data);
                                $('#edit_info_data').html(data.html);

                                getReorderDie();
                                $('.loader').hide();
                                swal('Success', 'Price Updated for Quotation', 'success');
                            },
                            error: function () {
                                swal('warning', 'Error while request..', 'warning');
                                $('#edit_info').modal('hide');
                                $('.loader').hide();
                            }
                        });
                        break;
                }
            });
    });

    $(document).on("submit", "#add_reorder_flexiblepricing", function (e) {

        e.preventDefault();
        var formData = new FormData(this);

        var supplier = $('#supplier').val();
        var value = $("#price").val();
        var svalue = $("#sprice").val();

        if (supplier == "" || supplier == " ") {
            swal('warning', 'Please provide Supplier Name', 'warning');
            return false;
        }

        if (value == "" || value == " ") {
            swal('warning', 'Please provide Cost Price', 'warning');
            return false;
        }

        if (svalue == "" || svalue == " ") {
            swal('warning', 'Please provide Sales Price', 'warning');
            return false;
        }

        swal("Are you sure You are going to add new line?", {
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
                        $('.loader').show();

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
                                $('#edit_info_data').html(data.html);
                                var count_prices = data.count;
                                var count_rem_lin = 0;
                                if (count_prices == 0) {
                                    count_rem_lin = 'Add Price';
                                } else {
                                    count_rem_lin = 'View Prices';
                                }
                                $('#view_add_' +<?=$serial?>).text(count_rem_lin);
                                getReorderDie();
                                $('.loader').hide();
                                swal('Success', 'New line added successfully', 'success');
                            },
                            error: function (data) {
                                $('#edit_info').modal('show');
                                $('.loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            });
    });


    $(document).on("click", ".editabless", function (e) {

        var id = $(this).attr('data-id');
        var serial = $(this).attr('data-value');
        var supplier = $('#supplier_' + id).val();
        var cost = $("#cost_" + id).val();
        var svalue = $("#sale_" + id).val();

        if (supplier == "" || supplier == " ") {
            swal('Warning', 'Please provide Supplier Name', 'warning');
            return false;
        }
        if (cost == "" || cost == " ") {
            swal('Warning', 'Please provide Cost Price', 'warning');
            return false;
        }
        if (svalue == "" || svalue == " ") {
            swal('Warning', 'Please provide Sales Price', 'warning');
            return false;
        }


        swal("Are you sure You are going to update this line?", {
            icon: 'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Yes",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('.loader').show();

                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/editables_reorder",
                            cache: false,
                            data: {id: id, serial: serial, supplier: supplier, value: cost, svalue: svalue},
                            dataType: 'html',
                            success: function (data) {
                                data = $.parseJSON(data);

                                $('.loader').hide();
                                $('#edit_info_data').html(data.html);
                                swal('Success', 'Line successfully updated', 'success');
                            },
                            error: function () {
                                $('#edit_info').modal('hide');
                                $('.loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            });
    });


    $('.up_file').change(function () {
        $('.up_btn').prop('disabled', false);
    });


    $(document).on("submit", ".updtfileform_reorder", function (e) {

        e.preventDefault();
        var formData = new FormData(this);

        var id = $(this).attr('data-id');
        var svalue = $("#file_" + id).val();

        if (file == "" || file == " ") {
            swal('Warning', 'please choose upload file', 'warning');
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
                        $('.loader').show();

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
                                $('.loader').hide();
                                $('#edit_info_data').html(data.html);
                                swal('Success', 'File successfully updated', 'success');
                            },
                            error: function (data) {
                                $('#edit_info').modal('hide');
                                $('.loader').hide();
                                swal('warning', 'Error while request..', 'warning');
                            }
                        });
                        break;
                }
            })
    });


</script>