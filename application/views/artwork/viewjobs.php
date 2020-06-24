<style>
    dl, ol, ul {
        margin-top: 0;
        margin-bottom: 0rem !important;
    }
</style>
<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg">
                        <div class="row artwork-details-row">
                            <div class="col-md-4 artwork-details-row-col">
                                <ul class="list-none">
                                    <li>Order No.:</li>

                                    <li>Total Print Jobs:</li>

                                    <li>Designer:</li>

                                    <li>CC Operator:</li>

                                    <li>Customer/Country:</li>

                                    <li>Plain Customer Order:</li>
                                </ul>

                                <ul class="list-none-1">
                                    <li><?= $orderinfo['OrderNumber'] ?>
                                        (<?= ($orderinfo['site'] == "" || $orderinfo['site'] == "en") ? "en" : "fr"; ?>)
                                    </li>
                                    <?php
                                    $Brands = '';
                                    $Roll = 'Rolls';
                                    foreach ($printjobs as $job) {
                                        if ($job->Brand === 'Rolls') {
                                            $Roll = $job->Brand;
                                        } else {
                                            $Sheets[] = $job->Brand;
                                        }
                                    }
                                    $Sheets = array_unique($Sheets);
                                    $Sheets = implode(", ", $Sheets);
                                    ?>
                                    <li><?= $counter['roll_jobs'] . " ($Roll)"; ?>
                                        + <?= $counter['sheet_jobs'] . " ($Sheets)"; ?> </li>

                                    <li><? echo $designer = $this->Artwork_model->get_operator($orderinfo['designer']);
                                        if ($designer == "") {
                                            echo '<span style="color:#f3fbfe">.</span>';
                                        } ?></li>

                                    <li><? echo $customercare = $this->Artwork_model->get_operator($orderinfo['assigny']);
                                        if ($customercare == "") {
                                            echo '<span style="color:#f3fbfe">.</span>';
                                        } ?></li>

                                    <li><?= $orderinfo['BillingFirstName'] ?> (<?= $orderinfo['BillingCountry'] ?>)</li>

                                    <li><?= ($orderinfo['Label'] == 1) ? "YES" : "NO" ?></li>
                                </ul>

                            </div>

                            <? $add_info_url = main_url . 'Artworks/rolldetails/' . $orderinfo['OrderNumber']; ?>
                            <div class="col-md-2 artwork-details-row-col text-center">
                                <? if ($counter['roll_jobs'] > 0 && $this->session->userdata('UserTypeID') == 88) { ?>
                                    <button type="button" class="btn btn-outline-info waves-light waves-effect"
                                            style="position: relative;top: 30px;width: 151px;"
                                            onClick="window.open('<?= $add_info_url ?>')">
                                        Add Roll Details
                                    </button>
                                <? } ?>

                                <? if ($this->session->userdata('UserTypeID') != 88) { ?>
                                    <button type="button"
                                            onClick="myFunction('send','<?= $orderinfo['OrderNumber'] ?>');"
                                            class="btn btn-outline-info waves-light waves-effect"
                                            style="position: relative;top: 40px;">
                                        Send to Customer
                                    </button>
                                     <br>
                                     <button type="button" class="btn btn-outline-info waves-light waves-effect copytoclip" style="position: relative;top: 40px;" data-link="https://www.aalabels.com/artwork-approval/<?=md5($orderinfo['OrderNumber'])?>">
                                        Artwork Approval Link
                                    </button>
                                    
                                    
                                <? } ?>
                            </div>
                            <div class="col-md-3 artwork-details-row-col">
                                <? if ($this->session->userdata('UserTypeID') != 88) {
                                    $ifapprovelneeded = $this->Artwork_model->ifapprovelneeded($orderinfo['OrderNumber']);
                                    if ($ifapprovelneeded > 0) {
                                        ?>
                                        <button type="button"
                                                onClick="send_email_again('<?= $orderinfo['OrderNumber'] ?>');"
                                                class="btn btn-outline-info waves-light waves-effect"
                                                style="position: relative;top: 40px;">
                                            Send Approval Email Again
                                        </button>
                                    <? }
                                } ?>
                            </div>
                            <div class="col-md-3 artwork-details-row-col"></div>

                        </div>
                    </div>

                    <style>
                        .siderbarlist {
                            cursor: pointer;
                        }

                        .pjcheckbox {
                            position: absolute;
                            z-index: 9999999;
                            top: 0px;
                        }

                        .checkbox_container_align {
                            position: relative;
                            left: 50%;
                            top: 30px;
                        }
                    </style>

                    <div class="card-body p-7">
                        <div class="tabs-vertical-env row artwork-row-margin-adjst ">
                            <ul class="nav tabs-vertical ">
                                <? foreach ($printjobs as $job) {
                                    $status = $this->Artwork_model->fetch_status_action($job->status); ?>

                                    <? if (isset($job->softproof) && $job->softproof != "" && $this->session->userdata('UserTypeID') != 88 && $job->status == 66) { ?>
                                        <span class="checkbox_container_align">
                                                        <input type="checkbox" class="pjcheckbox" value="<?= $job->ID ?>"/>
                                        </span>
                                    <? } ?>
                                    <li class="nav-item artwork-detail-li siderbarlist openprintjob"
                                        id="active_<?= $job->ID ?>" data-id="<?= $job->ID ?>">
                                        <a aria-expanded="false" class="nav-link nav-link" id="lighter_<?= $job->ID ?>">
                                            <? if ($job->action == 0) {
                                                $light = "red-artwork-pulse";
                                            } ?>
                                            <? if ($job->action == 1) {
                                                $light = "green-artwork-pulse";
                                            } ?>
                                            <? if ($job->action == 2) {
                                                $light = "yellow-artwork-pulse";
                                            } ?>
                                            <? if ($job->checklist == 0) {
                                                $light = "blue-artwork-pulse";
                                            } ?>

                                            <div class="sk-spinner sk-spinner-pulse <?= $light ?>"></div>
                                            Print Job No.: <b>PJ<?= $job->ID ?></b>
                                            <? if ($job->variable_data == 1) { ?> <b style="color:red"> -
                                                Sequential</b> <? } ?>
                                        </a>
                                        <a><b>Name:</b> <?= $job->name ?></a>
                                        <hr>
                                        <ul class="artwork-detail-ul">
                                            <li class="artwork-sub-text-li">Product Code <p><b><?= $job->diecode ?></b>
                                                </p></li>
                                            <li class="artwork-sub-text-li-sub">Sheets/Rolls<p><b><?= $job->qty ?></b>
                                                </p></li>
                                            <li class="artwork-sub-text-li-subs">Labels<p><b><?= $job->labels ?></b></p>
                                            </li>
                                        </ul>
                                    </li>
                                <? } ?>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="printjobdata">
                                    <? include(APPPATH . 'views/artwork/ajax/fetch_job.php'); ?>
                                </div>
                            </div>
                        </div>

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
<script>
    $(document).ready(function () {
        $('.siderbarlist').removeClass('active');
        $('#active_' + <?=$printjob?>).addClass('active');
    });

    $(document).on('click', '.copytoclip', (function (e) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('data-link')).select();
        document.execCommand("copy");
        swal('', 'Artwork Link Copied to Clipboard', 'success');
        $temp.remove();
    }));

    $(document).on('click', '.box_commentshow', (function (e) {
        $('#comment_box').show();
        $('#command').html('<button type="button" class="btn btn-outline-info waves-light waves-effect box_commenthide" style="margin: 0px 15px;">Close Comments</button>');
    }));
    $(document).on('click', '.box_commenthide', (function (e) {
        $('#comment_box').hide();
        $('#command').html('<button type="button" class="btn btn-outline-info waves-light waves-effect box_commentshow" style="margin: 0px 15px;">Add Comments</button>');
    }));

    $(document).on("click", ".chekclist", function (e) {
        var jobno = $(this).attr('data-id');
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "Artworks/fetch_chekclist",
            cache: false,
            data: {jobno: jobno},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#popupdiv').html(data.html);
                $('.checklist-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });

    $(document).on("click", ".viewchekclist", function (e) {
        var jobno = $(this).attr('data-id');
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "Artworks/show_chekclist",
            cache: false,
            data: {jobno: jobno},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#popupdiv').html(data.html);
                $('.checklist-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });

    $(document).on("click", ".approve_co", function (e) {
        var jobno = $(this).attr('data-id');
        var ver = $(this).attr('data-ver');

        var check = confirm('Have you Checked the Artwork Carefully ?');
        if (check) {
            $('#aa_loader').show();
            $.ajax({
                type: "post",
                url: mainUrl + "Artworks/approve_original",
                cache: false,
                data: {jobno: jobno, ver: ver},
                dataType: 'html',
                success: function (data) {
                    data = $.parseJSON(data);
                    $('#aa_loader').hide();
                    $('#printjobdata').html(data.html);
                    $('#lighter_' + jobno).html(data.light);
                },
                error: function () {
                    alert('Error while request..');
                }
            });
        } else {
            return false;
        }
    });


    $(document).on("submit", "#add_softproof", function (e) {
        var soft = $("#soft").val();
        var softproofpdffile = $("#softproofpdffile").val();
        var softproofthumbfile = $("#softproofthumbfile").val();
        if (soft == "") {
            swal('', 'Attach Softproof', 'warning');
            return false;
        }
        if (softproofpdffile == "") {
            swal('', 'Attach Softproof pdf', 'warning');
            return false;
        }
        if (softproofthumbfile == "") {
            swal('', 'Attach Softproof Thumbnail', 'warning');
            return false;
        }
        e.preventDefault();

        var formData = new FormData(this);
        $('#aa_loader').show();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                if (data.response == 'error') {
                    $('#aa_loader').hide();
                    swal('', 'Error While uploading files', 'warning');
                } else {
                    $('#aa_loader').hide();
                    $('#softproof').val(data.softproof);
                    $('#pdfformat').val(data.softproofpdf);
                    $('#thumbnail').val(data.softproofthumb);
                    swal('', 'Softproof Attached', 'success');
                }
            },
            error: function (data) {
                console.log("error");
            }
        });
    });

    function save_comment() {
        var attachment = $('#attachment').val();
        var softproof = $('#softproof').val();
        var thumbnail = $('#thumbnail').val();
        var pdfformat = $('#pdfformat').val();
        var comment = $('#comment').val();
        var attach = $('#attach-id').val();

        if (comment == "") {
            swal('', 'Enter comments', 'warning');
            return false;
        }

        $('#aa_loader').show();
        $.ajax({
            type: 'POST',
            url: mainUrl + 'Artworks/add_artwork_comment',
            data: {
                attachment: attachment,
                comment: comment,
                attach: attach,
                softproof: softproof,
                thumbnail: thumbnail,
                pdfformat: pdfformat
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data.url != '') {
                    $('#aa_loader').hide();
                    $('#printjobdata').html(data.html);
                    $('#lighter_' + attach).html(data.light);
                }
            },
            error: function (data) {
                console.log("error");
            }
        });
    }


    $(document).on("submit", "#upload_printfile", function (e) {
        var printfile = $("#file_up").val();
        if (printfile == "") {
            swal('', 'Attach Print file', 'warning');
            return false;
        }
        e.preventDefault();

        var formData = new FormData(this);
        $('#aa_loader').show();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                if (data.response == 'error') {
                    $('#aa_loader').hide();
                    swal('', 'Error While uploading files', 'warning');
                } else {
                    $('#aa_loader').hide();
                    $('#attachment').val(data.attachment);
                    swal('', 'Print File Attached', 'success');
                }
            },
            error: function (data) {
                console.log("error");
            }
        });
    });

    $(document).on("click", ".customerfeedback", function (e) {
        var jobno = $(this).attr('data-id');
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "Artworks/customerfeedback",
            cache: false,
            data: {jobno: jobno},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#popupdiv').html(data.html);
                $('.customerfeedback-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });

    $(document).on("click", ".artworkhistory", function (e) {
        var jobno = $(this).attr('data-id');
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "Artworks/artworkhistory",
            cache: false,
            data: {jobno: jobno},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#printjobdata').html(data.html);
                $('#lighter_' + jobno).html(data.light);
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });

    $(document).on("click", ".openprintjob", function (e) {
        var jobno = $(this).attr('data-id');
        $('#aa_loader').show();
        $.ajax({
            type: "post",
            url: mainUrl + "Artworks/openprintjob",
            cache: false,
            data: {jobno: jobno},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#printjobdata').html(data.html);
                $('.siderbarlist').removeClass('active');
                $('#active_' + jobno).addClass('active');
                $('#lighter_' + jobno).html(data.light);
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });

    $(document).on("submit", "#uploadnewco", function (e) {
        var userfile = $("#file").val();
        var jobno = $('#uploadcoid').val();

        if (userfile.length == 0) {
            swal('', 'Please Select File', 'warning');
            $("#file").focus();
            return false;
        }


        var check = confirm('Uploading new artwork will reset the job completely. Do You Wish to Continue ?');
        if (check) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#aa_loader').show();

            $.ajax({
                type: 'POST',
                url: mainUrl + "Artworks/edit_artwork",
                data: formData,
                cache: false,
                dataType: 'html',
                contentType: false,
                processData: false,
                success: function (data) {
                    data = $.parseJSON(data);
                    $('#aa_loader').hide();
                    $('#printjobdata').html(data.html);
                    $('.siderbarlist').removeClass('active');
                    $('#active_' + jobno).addClass('active');
                    $('#lighter_' + jobno).html(data.light);
                },
                error: function (data) {
                    console.log("error");
                }
            });
        } else {
            return false;
        }
    });

    function myFunction(type, order) {

        var count = 0;
        inputs = document.getElementsByClassName('pjcheckbox');
        var count = 1;
        var check = 0;

        var ids = [];
        for (var count = 0; count < inputs.length; count++) {
            if (inputs[count].type.toLowerCase() == "checkbox" && inputs[count].checked == 1) {
                var id = inputs[count].value;
                ids[check] = id;
                check++;
            }
        }


        if (check == 0) {
            swal('', 'Select Atleast One Print Job', 'warning');
            return false;
        } else if (check > 0 && type == "send") {
            $.ajax({
                url: mainUrl + 'Artworks/send_email',
                type: "POST",
                data: {ids: ids, order: order},
                datatype: 'json',
                success: function (data) {
                    location.reload(true);
                }
            });
        }
    }

    $(document).on("change", "#select_jobdesigner", function (e) {
        var designer = $(this).val();
        var jobno = $(this).attr('data-id');
        if (designer == 0) {
            return false;
        }

        swal("Are you sure ?", {
            icon: 'warning',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "CONTINUE",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $.ajax({
                            type: 'POST',
                            url: mainUrl + "Artworks/assignjob_to/designer/" + jobno + "/" + designer,
                            data: {jobno: jobno},
                            cache: false,
                            dataType: 'html',
                            success: function (data) {
                                data = $.parseJSON(data);
                                $('#aa_loader').hide();
                                swal('', 'Assigned to Designer', 'success');
                            },
                            error: function (data) {
                                console.log("error");
                            }
                        });
                        break;
                    default:
                        break;
                }
            });
    });


    $(document).on("click", ".show_timeline", function (e) {
        var jobno = $(this).attr('data-id');
        var order = $(this).attr('data-order');
        $('#aa_loader').show();

        $.ajax({
            type: "post",
            url: mainUrl + "Artworks/fetch_timeline",
            cache: false,
            data: {jobno: jobno, order: order},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#popupdiv').html(data.html);
                $('.timeline-modal').modal('show');
            },
            error: function () {
                alert('Error while request..');
            }
        });
    });


    function send_email_again(order) {
        $('#aa_loader').show();
        $.ajax({
            url: mainUrl + 'Artworks/send_email_again/' + order,
            type: "POST",
            data: {order: order},
            datatype: 'json',
            success: function (data) {
                $('#aa_loader').hide();
                swal('', 'Artwork Approval Email Sent', 'success');
            }
        });
    }

</script>	
	
