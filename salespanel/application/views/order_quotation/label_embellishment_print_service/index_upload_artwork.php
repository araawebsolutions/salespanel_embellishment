<script>

$(document).on("change", ".artwork_file", function (e) {
    readURL(this);
});

function readURL(input) {
    console.log(input);
    if (input.files && input.files[0]) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (ext == 'docx' || ext == 'doc') {
            $('#preview_po_img').attr('src', '<?=Assets?>images/doc.png');
            $('#preview_po_img').show();
            $('.browse_btn').hide();
        } else if (ext == 'pdf') {
            $('#preview_po_img').attr('src', '<?=Assets?>images/pdf.png');
            $('#preview_po_img').show();
            $('.browse_btn').hide();
        } else if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview_po_img').attr('src', e.target.result);
                $('#preview_po_img').show();
                $('.browse_btn').hide();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#preview_po_img').attr('src', '<?=Assets?>images/no-image.png');
            $('#preview_po_img').show();
            $('.browse_btn').hide();
        }
    }
}
$(document).on("click", "#preview_po_img", function (e) {
    swal({
            title: 'Are you sure you want to delete this file?',
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn orangeBg",
            confirmButtonText: "No",
            cancelButtonClass: "btn blueBg m-r-10",
            cancelButtonText: "Yes",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                console.log('cancel');
            } else {
                $('.browse_btn').show();
                $('#preview_po_img').hide();
            }
        });
});




$(document).on("click", ".save_artwork_file", function (e) {
        var _this = this;
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
        var file = $(_this).parents('.upload_row').find('.artwork_file').val();
        var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        var response = '';
        if (type == 'roll') {
            response = verify_labels_or_rolls_qty(_this);
            if (response == false) {
                return false;
            }
            var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
            var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();
            var lb_txt = 'labels';
        } else {
            if (cartunitqty == 'labels') {
                var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                if (labels.length == 0) {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum " + labelpersheets + " labels are required ");
                    }
                    return false;
                }
                var sheets = parseInt(labels / labelpersheets);
                var lb_txt = 'labels';
            } else {
                var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
                if (sheets.length == 0) {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum 1 sheet required ");
                    }
                    return false;
                }
                var labels = parseInt(sheets * labelpersheets);
                var lb_txt = 'sheets';
            }
        }
        if (file.length == 0) {
            alert_box("Please upload a file before saving. ");
        } else if (labels == 0 || labels == '') {
            alert_box("Please complete line ");
        } else if (artworkname.length == 0) {
            alert_box("please enter artwork name! ");
        } else {
            var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
            var form_data = new FormData();
            form_data.append("file", uploadfile)
            form_data.append("cartid", cartid);
            form_data.append("productid", prdid);
            form_data.append("labels", labels);
            form_data.append("sheets", sheets);
            form_data.append("artworkname", artworkname);
            form_data.append("persheet", labelpersheets);
            form_data.append("type", type);
            form_data.append("unitqty", cartunitqty);
            type = uploadfile.type;
            if (type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript') {
                swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");
                return false;
            }
            var type = $('#producttype' + prdid).val();
            var remaing = parseInt($('#upload_remaining_labels').val());
            var designs_remain = parseInt($('#upload_remaining_designs').val());
            if (designs_remain < 1) {
                form_data.append("limit_exceed_designs", 'yes');
                var msg = 'You have entered extra designs, click here to update your basket.';
            }
            if (remaing < 0) {
                form_data.append("limit_exceed_sheet", 'yes');
                var msg = 'You have entered extra ' + lb_txt + ', click here to update your basket.';
            }
            if (remaing < 0 || (designs_remain < 1 && type != 'roll')) {
                swal({
                        title: msg,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Update Basket",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            upload_printing_artworks(form_data);
                        }
                    });
            } else {
                upload_printing_artworks(form_data);
            }
        }
    });


function verify_labels_or_rolls_qty(id) {
        var prdid = $('#cartproductid').val();
        var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
        var min_qty = parseInt($('#min_qty' + prdid).val());
        var min_rolls = parseInt($('#min_rolls' + prdid).val());
        var max_qty = parseInt($('#max_qty' + prdid).val());
        var dieacross = parseInt($('#min_rolls' + prdid).val());
        var minlabels = parseInt(min_qty / dieacross);
        var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
        var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());
        var perroll = parseFloat(total_labels / rolls);
        if (isFloat(perroll)) {
            perroll = Math.ceil(perroll);
        }
        var roll_text = 'roll';
        if (rolls > 1) {
            var roll_text = 'rolls';
        }
        if (!is_numeric(total_labels)) {
            //alert_box("Please enter number of labels ");
            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
            show_faded_popover(_this, "Please enter number of labels.");
            $(id).parents('.upload_row').find('.roll_labels_input').val('');
            update_remaing_labels();
            return false;
        } else if (total_labels == 0) {
            //alert_box("Minimum Label quantity is "+minlabels+" Labels per roll.");
            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
            show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
            $(id).parents('.upload_row').find('.roll_labels_input').val('');
            update_remaing_labels();
            return false;
        } else if (!is_numeric(rolls) || rolls == 0) {
            //alert_box("Minimum roll quantity is 1 roll.");
            var _this = $(id).parents('.upload_row').find('.input_rolls');
            show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
            $(id).parents('.upload_row').find('.input_rolls').val('');
            update_remaing_labels();
            return false;
        } else if (perroll < minlabels) {
            var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');
            if (roll_input_display == 'block') {
                var requiredlabels = minlabels * rolls
                //alert_box("Minimum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Quantity has been amended for production as " + requiredlabels + " Labels.");
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(minlabels);
                $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                update_remaing_labels();
                return false;
            } else {
                if (total_labels > labelspersheets) {
                    var expectedrolls = parseFloat(total_labels / labelspersheets);
                    if (isFloat(expectedrolls)) {
                        expectedrolls = Math.ceil(expectedrolls);
                    }
                    labelspersheets = parseInt(total_labels / expectedrolls);
                    var _this = $(id).parents('.upload_row').find('.input_rolls');
                    show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                    //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
                    //alert_box(expectedrolls+" rolls are allowed on "+total_labels+" labels");
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                    $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                    update_remaing_labels();
                    return false;
                } else {
                    if (total_labels < minlabels) {
                        total_labels = minlabels;
                        var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                        show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                    } else {
                        var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                        show_faded_popover(_this, "Quantity has been amended for production as 1 Roll.");
                    }
                    // alert_box("1 roll allowed on "+total_labels+" labels");
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
                    $(id).parents('.upload_row').find('.quantity_labels').text(1);
                    $(id).parents('.upload_row').find('.input_rolls').val(1);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    update_remaing_labels();
                    return false;
                }
            }
        } else if (perroll > labelspersheets) {
            var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
            var total_labels = response['total_labels'];
            var expectedrolls = response['rolls'];
            var labelspersheets = parseInt(total_labels / expectedrolls);
            //var expectedrolls = parseFloat(total_labels/labelspersheets);
            //if(isFloat(expectedrolls)){  expectedrolls = Math.ceil(expectedrolls);}
            //total_labels = parseInt(labelspersheets*expectedrolls);
            var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
            show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
            //alert_box(total_labels+" labels are allowed on "+expectedrolls+" rolls");
            $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
            $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
            $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
            $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
            update_remaing_labels();
            return false;
            /*var requiredlabels = labelspersheets*rolls
                alert_box("Maximum "+requiredlabels+" labels are allowed on "+rolls+" "+roll_text);
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                $(id).parents('.upload_row').find('.roll_labels_input').val(requiredlabels);
                update_remaing_labels();
                return false;*/
        } else {
            var total_labels = parseInt(perroll) * parseInt(rolls);
            $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
            $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
            update_remaing_labels();
        }
        $(id).parents('.upload_row').find('.quantity_updater').hide();
}


function update_remaing_labels() {
    var actual_qty = $('#actual_labels_qty').val();
    var total_qty = 0;
    $(".roll_labels_input").each(function (index) {
        if ($(this).val()) {
            total_qty = parseInt(total_qty) + parseInt($(this).val());
        }
    });
    if (total_qty != 'NaN') {
        var prdid = $('#cartproductid').val();
        var labelspersheets = parseInt($('#labels_p_sheet' + prdid).val());
        var reaming = parseInt(actual_qty) - parseInt(total_qty);
        if (reaming < 0) {
            $('.remaing_user_sheets').html('0');
            $('.remaing_user_labels').html('0');
        } else {
            $('.remaing_user_sheets').html(reaming);
            $('.remaing_user_labels').html(reaming * labelspersheets);
        }
        $('#upload_remaining_labels').val(reaming);
        console.log('Actual: ' + actual_qty);
        console.log('Remaing: ' + reaming);
    }
}


function rolls_calculation(die_across, max_labels, total_labels, rolls) {
    if (rolls == 0) {
        rolls = parseInt(die_across);
    } else {
        rolls = parseInt(rolls) + parseInt(die_across);
    }
    var per_roll = parseFloat(parseInt(total_labels) / rolls);
    if (per_roll > parseInt(max_labels)) {
        response = rolls_calculation(die_across, max_labels, total_labels, rolls);
        per_roll = response['per_roll'];
        rolls = response['rolls'];
    }
    var data = {per_roll: Math.ceil(per_roll), total_labels: Math.ceil(per_roll) * rolls, rolls: rolls};
    return data;
}
//already copied
function show_faded_popover(_this, text) {
    $(_this).attr('data-content', '');
    $(_this).popover('hide');
    $(_this).popover('destroy');
    $(_this).popover({'placement': 'top'});
    $(_this).attr('data-content', text);
    $(_this).popover('show');
    clearTimeout(timer);
    timer = setTimeout(function () {
        $(_this).attr('data-content', '');
        $(_this).popover('hide');
        $(_this).popover('destroy');
    }, 5000);
}


function upload_printing_artworks(form_data) {
    $.ajax({
        url: base + 'ajax/material_upload_printing_artworks',
        type: "POST",
        async: "false",
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        beforeSend: function () {
            $("#upload_pecentage").html(' &nbsp;0%');
            $("#upload_progress").show();
            $('.save_artwork_file').prop('disabled', true);
        },
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progress, false);
            }
            return myXhr;
        },
        error: function (data) {
            swal('Some error occured please try again');
            intialize_progressbar();
            $("#upload_progress").hide();
            $('.save_artwork_file').prop('disabled', false);
        },
        success: function (data) {
            $('.save_artwork_file').prop('disabled', false);
            data = $.parseJSON(data);
            if (data.response == 'yes') {
                $('#ajax_upload_content').html(data.content);
                if (data.sidebar != '') {
                    $('#product_summary_overview').html(data.sidebar);
                    $('#product_summary_overview_home').html(data.sidebar);
                    // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                    // $('#design_qty_'+prdid).val(parseInt(data.design));
                    // $('#cal_btn'+prdid).click();
                }
                intialize_progressbar();
                $("#upload_progress").hide();
            } else {
                swal('upload failed', data.message, 'error');
                intialize_progressbar();
                $("#upload_progress").hide();
                $('.save_artwork_file').prop('disabled', false);
            }
        }
    });
}


$(document).on("click", ".proceed_to_checkout", function (e) {
        var prdid = $('#cartproductid').val();
        var upload_option = $('input[name=upload_option]:checked').val();
        var type = $('#producttype' + prdid).val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        if (type == 'roll') {
            var remaing = parseInt($('#upload_remaining_labels').val());
            var msg_text = 'labels';
            var uploaded_sheets = parseInt($('#final_uploaded_rolls').val());
            var uploaded_labels = parseInt($('#final_uploaded_labels').val());
            var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Rolls\n';
        } else {
            var actual_sheets = parseInt($('#actual_sheets').val());
            var uploaded_sheets = parseInt($('#uploaded_sheets').val());
            var uploaded_labels = parseInt(uploaded_sheets * labelpersheets);
            var remaing = actual_sheets - uploaded_sheets;
            var msg_text = 'sheets';
            if (cartunitqty == 'labels') {
                var msg_text = 'labels';
            }
            var lables_qty_text = uploaded_labels + ' Labels on ' + uploaded_sheets + ' Sheets\n';
        }
        var remaing_designs = parseInt($('#upload_remaining_designs').val());
        var designservice = $('input[name=print_designservice]:checked').val();
        var exceed = '';
        //var message = 'Do you want to continue without uploading artworks.?';
        var message = 'Have you uploaded all your artworks.?';
        var actual_designs = parseInt($('#actual_designs_qty').val());
        if ($('.UploadMainSelection').css('display') == 'block' && upload_option != 'email_artwork') {
            alert_box("Please click to  Proceed before checkout ");
            return false;
        } else if (upload_option == 'design_services' && typeof designservice == 'undefined') {
            alert_box("Please select no of design against design service");
            return false;
        } else if (type == 'sheet' && uploaded_sheets < 25 && upload_option == 'upload_artwork') {
            var minqty = 25;
            if (cartunitqty == 'labels') {
                var minqty = 25 * parseInt(labelpersheets);
            }
            alert_box("Minimum " + minqty + " " + cartunitqty + " required, please adjust remaining sheets in your artworks");
            return false;
        } else if (actual_designs == remaing_designs && upload_option == 'upload_artwork') {
            alert_box("Please upload your artworks before proceeding to checkout ");
            return false;
        } else if ($('.uploadsavesection').css('display') == 'table-row' && upload_option == 'upload_artwork') {
            swal({
                    title: 'Please complete  or delete the incomplete line.',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn orangeBg",
                    confirmButtonText: "Continue",
                    cancelButtonClass: "btn blueBg m-r-10",
                    cancelButtonText: "Delete",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        return false;
                    } else {
                        $('.uploadsavesection').hide();
                        $('#add_another_line').show();
                        $('.add_another_art').show();
                        return false;
                    }
                });
            //alert_box("Please complete the file upload process to continue.");
            //return false;
        } else {

            var showArtWorkMessage = true;
            if($('.upload_artwork:visible').length == 0) {
                 showArtWorkMessage = false;
            }

            if ( upload_option == 'email_artwork' || upload_option == 'design_services' ) {
                
                if( showArtWorkMessage )
                {
                    swal({
                        title: 'Do you want to continue without uploading artworks?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "No",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Yes",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            console.log('cancel');
                        } else {
                            add_to_car_product();
                        }
                    });
                } else {
                    swal({
                        title: 'Are you sure to continue with custom Design Service?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "No",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Yes",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            console.log('cancel');
                        } else {
                            add_to_car_product();
                        }
                    });
                }

                    

            } else if ((remaing > 0 || remaing_designs > 0) && upload_option == 'upload_artwork') {
                if (remaing > 0) {
                    var text = msg_text;
                } else {
                    var text = 'designs';
                }
                swal({
                        title: 'You have reduced the number of ' + text + ' please confirm to recalculate the price.',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg",
                        confirmButtonText: "Confirm",
                        cancelButtonClass: "btn blueBg m-r-10",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            update_cart_with_upload();
                        }
                    });
            } else {
                //Have you uploaded all your artworks?
                var summary_price = $('.summary_price:eq(1)').text();
                var artwork_text = actual_designs + ' Artworks uploaded\n';
                var total_price_text = "Total £" + summary_price + "\n <?=vatoption?>. VAT\n";
                var free_delivery_text = ' Free Delivery.';
                var finaltext = artwork_text + '' + lables_qty_text + '' + total_price_text + '' + free_delivery_text;
                swal({
                        title: finaltext,
                        type: "",
                        showCancelButton: true,
                        confirmButtonClass: "btn orangeBg m-t-10",
                        confirmButtonText: "Continue to Checkout",
                        cancelButtonClass: "btn blueBg m-r-10 m-t-10",
                        cancelButtonText: "Upload Further Artworks",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            add_to_car_product();
                        }
                    });
            }
        }
    });


function update_cart_with_upload() {
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        show_loader('80', '27');
        $.ajax({
            url: base + 'ajax/material_update_cart_with_upload',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                cartid: cartid,
                prdid: prdid,
                persheet: labelpersheets,
                type: type,
                unitqty: cartunitqty
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data.response == 'yes') {
                    $('#product_summary_overview').html(data.sidebar);
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                }
                $('#aa_loader').hide();
            }
        });
    }


function show_loader(top, left) {
    // $('.loading-gif').css('top', top + '%');``
    // $('.loading-gif').css('left', left + '%');
    $('#aa_loader').show();
}

var checkoutconfirm = false;
function add_to_car_product() {
    var cartid = $('#cartid').val();
    var prdid = $('#cartproductid').val();
    var labelpersheets = $('#labels_p_sheet' + prdid).val();
    var actual_qty = parseInt($('#sheet_qty_' + prdid).val());
    var coresize = $('#label_coresize').val();
    var woundoption = $('#woundoption').val();
    var orientation = $('#label_orientation').val();
    var desingsservice = $('input[name=print_designservice]:checked').val();
    var comments = $('#comments').val();
    var uploadfile = $('#desingservice_artwork_file')[0].files[0];
    var upload_option = $('input[name=upload_option]:checked').val();
    var form_data = new FormData();
    form_data.append("cartid", cartid)
    form_data.append("prdid", prdid);
    form_data.append("actual", actual_qty);
    form_data.append("coresize", coresize);
    form_data.append("woundoption", woundoption);
    form_data.append("orientation", orientation);
    form_data.append("upload_option", upload_option);
    form_data.append("persheet", labelpersheets);
    form_data.append("comments", comments);
    form_data.append("desingsservice", desingsservice);
    if (upload_option == 'design_services' && typeof uploadfile != 'undefined') {
        var filetype = uploadfile.type;
        if (filetype != 'image/png' && filetype != 'image/jpg' && filetype != 'image/gif' && filetype != 'image/jpeg' && filetype != 'application/pdf' && filetype != 'application/postscript') {
            swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");
            return false;
        }
        form_data.append("file", uploadfile);
    }
    show_loader('80', '27');
    $.ajax({
        url: base + 'ajax/add_printing_tocart',
        type: "POST",
        async: "false",
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (data) {
            data = $.parseJSON(data);
            if (data.response == 'yes') {
                ecommerce_add_to_cart();
                checkoutconfirm = true;
                window.location.href = '<?=SAURL?>transactionregistration.php';
                $('#aa_loader').hide();
            }
        }
    });
}

function ecommerce_add_to_cart() {
    <? if(SITE_MODE == 'live'){ ?>
    var prdid = $('#cartproductid').val();
    var quantity = parseInt($('#sheet_qty_' + prdid).val());
    var type = $('#producttype' + prdid).val();
    var price = parseFloat($('.summary_price').text());
    if (type == 'sheet') {
        var category = 'Printed A4 Sheets';
        var product_name = $.trim($('.a4_sheets_block').find('.title > b').text());
    } else {
        var category = 'Printed Roll Labels';
        var product_name = $.trim($('.roll_sheets_block').find('.title > b').text());
    }
    dataLayer.push({
        'event': 'addToCart',
        'ecommerce': {
            'add': {
                'products': [{
                    'name': product_name,
                    'id': prdid,
                    'price': price,
                    'brand': 'AALABELS',
                    'category': category,
                    'quantity': quantity,
                }]
            }
        }
    });
    <? } ?>
}

function intialize_progressbar() {
$("#progressbar").progressbar({
    value: 0,
    create: function (event, ui) {
        $(this).removeClass("ui-corner-all").addClass('progress').find(">:first-child").removeClass("ui-corner-left").addClass('progress-bar progress-bar-success');
    }
});
}



$(document).on("click", ".roll_updater,.sheet_updater", function (event) {
        var id = $(this).attr('data-id');
        var _this = this;
        var cartid = $('#cartid').val();
        var prdid = $('#cartproductid').val();
        var labelpersheets = $('#labels_p_sheet' + prdid).val();
        var type = $('#producttype' + prdid).val();
        var cartunitqty = $('#cartunitqty').val();
        if (type == 'roll') {
            var response = verify_labels_or_rolls_qty(_this);
            if (response == false) {
                return false;
            }
            var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
            var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();
        } else {
            if (cartunitqty == 'labels') {
                var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                if (labels.length == 0 || labels == 0 || labels == '') {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum " + labelpersheets + " labels are required ");
                    }
                    return false;
                }
                var sheets = parseInt(labels / labelpersheets);
            } else {
                var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
                if (sheets.length == 0 || sheets == 0 || sheets == '') {
                    var id = $(_this).parents('.upload_row').find('.labels_input');
                    var popover = $(_this).parents('.upload_row').find('.popover').length;
                    if (popover == 0) {
                        show_faded_popover(id, "Minimum 1 sheet required ");
                    }
                    return false;
                }
                var labels = parseInt(sheets * labelpersheets);
            }
            /*if(cartunitqty == 'labels'){
                            var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                            var sheets = parseInt(labels/labelpersheets);
                        }else{
                                var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
                                var labels = parseInt(sheets*labelpersheets);
                        }*/
        }
        var remaing = parseInt($('#upload_remaining_labels').val());
        var exceed = '';
        if (remaing < 0) {
            var exceed = 'yes';
        }
        $.ajax({
            url: base + 'ajax/material_update_printing_artworks',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                id: id,
                cartid: cartid,
                productid: prdid,
                labels: labels,
                sheets: sheets,
                persheet: labelpersheets,
                type: type,
                limit_exceed_sheet: exceed,
                updater: 'update',
                unitqty: cartunitqty,
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (!data == '') {
                    $('#ajax_upload_content').html(data.content);
                    intialize_progressbar();
                    if (data.sidebar != '') {
                        $('#product_summary_overview').html(data.sidebar);
                        $('#product_summary_overview_home').html(data.sidebar);
                        var prdid = $('#cartproductid').val();
                        // $('#sheet_qty_'+prdid).val(parseInt(data.labels));
                        // $('#design_qty_'+prdid).val(parseInt(data.design));
                        //$('#cal_btn'+prdid).click();
                    }
                }
            }
        });
    });


</script>