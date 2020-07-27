var countLine = 50000;
var cuscount = 2500;

$(document).ready(function () {
    var orders = $('#totalOrdr').val();
    var sale = $('#todaysal').val();
    var res = (sale / orders).toFixed();
    if (res == 'NaN') {
        $('#avgord').text(0);
    } else {
        $('#avgord').text(res);
    }
});


function generateInvoice(invoiceNumber) {

    $.ajax({

        type: "get",

        url: mainUrl + "order_quotation/order/printInvoice",

        data: {'invoiceNumber': invoiceNumber},

        dataType: 'html',

        success: function (data) {


        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('No Invoice..');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


function getOrderProducts(orderNumber) {
    $("#"+orderNumber).on('shown.bs.collapse', function() {
                    $(this)
                       .parent()
                       .find("#tbl_"+orderNumber)
                       .removeClass("fa-minus-circle")
                       .addClass("fa-plus-circle");
					   $("#row_"+ orderNumber).css( "display","none");
                })
                .on('hidden.bs.collapse', function() {
                    $(this)
                        .parent()
                        .find("#tbl_"+orderNumber)
                        .removeClass("fa-plus-circle")
                        .addClass("fa-minus-circle");
						$("#row_"+ orderNumber).css( "display","block");
                });


}


function getCustomerOrders(customerId, count=null, start = null) {
    $('#aa_loader').show();
    $.ajax({
        type: "get",
        url: mainUrl + "order_quotation/order/getCustomerOrders",
        data: {'customerId': customerId, 'count': count, 'start': start},
        dataType: 'html',
        success: function (data) {
            $('#aa_loader').hide();
            var msg = $.parseJSON(data);
            
            if(msg.on_hold != 'yes'){
                $('#customer').hide();

                $('#customer_orders').empty();
                $('#customer_orders').html(msg.html);
                $('#customer_orders').show();
                $('.basketPrice').show();
                $('#format').removeClass('disbaledd');
                $('#od_qt_tab').removeClass('disbaledd');
                $('#first_format_link').attr('onclick','getFormat()');
                $('#od_qt_link').attr('onclick','showcartPage()');
                if(start == null){
                    $('#li_page1').addClass('active');
                }else{
                    $('#li_page'+start).addClass('active');
                } 
            }else{
             swal('Success','Customer Is On Hold ','warning');

                $('#customer').show();
            }     
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}

function getOldArtwork() {

    var pageName = $('#mypageName').val();

    $.ajax({

        type: "post",

        url: mainUrl + "order_quotation/order/getOldArtwork",

        cache: false,

        data: {'customerId': $('#custId').val(),pageName:pageName},

        dataType: 'json',

        success: function (data) {

            $('#oldartwork').empty();
            $('#oldartwork').html(data.html);
			old_pop_tbs();
					

            $('#secondTable').show();
			$('#secondTable_wrapper').show();

            $('#hide-at-hs').show();

            $('#show-at-hs').hide();


        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


function old_pop_tbs() {

	$("#secondTable").dataTable({
		"sDom": 'l<"toolbar">frtip',
		"bProcessing": false,
		"bServerSide": false,
		"bDestroy": true,
		"bJQueryUI": true,
		"sPaginationType": "simple_numbers",
		// "lengthMenu": [[4, 10, 25, 50, -1], [4, 10, 25, 50, "All"]],
		"iDisplayStart ": 20,
		"iDisplayLength": 10,
		"aaSorting": [[0, 'desc']],
		"bFilter": false,
    "bLengthChange": false,
		//"stateSave": true,
		language: {
			paginate: {
				next: '&#8594;', // or '→'
				previous: '&#8592;' // or '←'
			}
		},
	});
}

function hideOldArtwork() {

    $('#secondTable_wrapper').hide();
	$('#secondTable').hide();
    $('#hide-at-hs').hide();
    $('#show-at-hs').show();
}


function shownewArtworkLine() {


    $('#nwatline1').show();

    $('#show-at-nw').hide();

}


function uploadMyArtwork(id, event, artworkId = null, page=null,conditon=null) {

    var page = $('#page').val();
    var rowKey = $('#rowKey').val();
    var serialNumber = $('#serialNumber').val();
    var orderNumber = $('#orderNumber').val();
    var manfactureId = $('#manfactureId').val();
    var checkoutArtwork = $('#checkoutArtwork').val();
    var brandName = $('#brand').val();
    var customerId = $('#custId').val();
    var per_shet_roll= $('#lblPerSheet').val();
	
	var is_follow=   $('#follow_art'+id).prop("checked");
	
	
	
	if(conditon !='update' && is_follow!=true ){
		
		var filess= $(event).closest('tr').find('#artworkimage'+ id).val();	
		var file = $(event).closest('tr').find('#artworkimage' + id)[0].files[0];
		
		if(filess.length==0 && is_follow!=true){
			//alert('Please upload Image First');

        swal("Please upload Image First",
                {
                    buttons: {
                        cancel: "OK",
                    },
                    icon: "warning",
                    closeOnClickOutside: false,
                }
            );
			return false;
			//break;
		}
	} 	
	
    if (validateRequest(id, event,page,conditon,serialNumber)) {

        var labels = $(event).closest('tr').find('#at_label' + id).val();

        labels = (labels == "" || labels == null ? $(event).closest('tr').find('#at_label' + id).text() : labels);

        if((page == null || page != "" || page == "") && (conditon !='update' || conditon ==null)){
			
			if(is_follow!=true){
				var file = $(event).closest('tr').find('#artworkimage' + id)[0].files[0];
				
			}else{
				 var file = "";
			}
        }else{
            var file = "";
        }
		


        var form_data = new FormData();

		form_data.append("file", file);
        form_data.append("CartID", $('#cartid' + serialNumber).val());
        form_data.append("ProductID", $('#product_id').val());
        form_data.append("name", $(event).closest('tr').find('#at_name' + id).val());
        form_data.append("labels", labels);
        form_data.append("qty", $(event).closest('tr').find('#at_roll' + id).val());
        form_data.append("status", 'confirm');
        form_data.append("source", 'backoffice');
        form_data.append("orderNumber", orderNumber);
        form_data.append("customerId", customerId);
        form_data.append("manfactureId", manfactureId);
        form_data.append("artworkID", artworkId);
        form_data.append("per_shet_roll", per_shet_roll);
        form_data.append("serialNumber", serialNumber);
        form_data.append("checkoutArtwork", checkoutArtwork);
        form_data.append("type", 'new');
        form_data.append("page", page);
        form_data.append("brandName", brandName);
        form_data.append("rowKey", rowKey);
        form_data.append("condition", conditon);
		
		$('#follow_art'+id).hide();
	
		if(file.length==0){
			if(is_follow==true){
				$('#followcheck'+id).show();
			}
		}else{
			if(is_follow==false){
				$('#followtimes'+id).show();
			}
		}
		
        uploadArtWork(form_data, artworkId,serialNumber,id,rowKey);
    }


}


function updateMyArtwork(id, event, artworkId,page=null,condition=null) {

    uploadMyArtwork(id, event, artworkId,page,condition); 

}


function uploadArtWork(record, artworkId,serialNumber,id=null,rowKey=null) {

    //console.log(record);
    $('#save'+id).prop('disabled', true);
    
    $.ajax({
        type: "post",
        url: mainUrl + "order_quotation/order/uploadArtwork",
        cache: false,
        data: record,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
			
			
			$('#save'+id).prop('disabled', false);
            var trval = $('#checkouttr').val();
            $('#artwork_count_status').text(data.count);
            $('#price').text('£ ' + data.price);
            $('#price' + serialNumber).text(data.price);
            $('#checkout_qty' + trval).val(data.statics[0].totalQuantity);
            $('#checkout_price' + trval).text('£' + data.price);
            $('#original_price').val(data.price);
            $('#save'+id).hide();
            $('#delete'+id).show();
            $('#show-at-nw').show();
            $('#updp_btn'+id).hide();
					
				
           	$('#delete'+id).attr('onclick','deleteMyArtwork('+id+','+data.latestArtworkId+','+serialNumber+')');
            $('#updp_btn'+id).attr('onclick','updateMyArtwork('+id+',this,'+data.latestArtworkId+','+'"'+''+'"'+','+'"'+'update'+'"'+')');
            $('#tpe'+id).val('update');
            $('#checkout_unit_price' + trval).text(data.price / data.statics[0].totalQuantity);
            var qty = parseInt($('#qty'+rowKey).val(),10);

            //if(data.statics[0].totalQuantity < qty){
                $('#design'+rowKey).val(data.statics[0].count);
                $('#arwtork_qty'+rowKey).val(data.statics[0].totalQuantity);
           // }
					
					
					
            //else if(data.statics[0].totalQuantity >= qty){

                $('#artwork_data'+rowKey).val(data.artwork_data);
                $('#qty'+rowKey).val(data.statics[0].totalQuantity);
                //$('#qty'+id).val(data.statics[0].totalQuantity);
                $('#myqty'+serialNumber).val(data.statics[0].totalQuantity);
                $('#arwtork_qty'+rowKey).val(data.statics[0].totalQuantity);

                $('#design'+rowKey).val(data.statics[0].count);
                //$('#design'+id).val(data.statics[0].count);
                $('#labels'+rowKey).text(data.statics[0].totalLabels );

                // $('#lbl_per_roll'+id).text(data.statics[0].totalLabels / data.statics[0].count);
                $('#lbl_per_roll'+id).text(Math.ceil($('#at_label'+id).val()/ $('#at_roll'+id).val()));

                //$('#labels'+id).text(data.statics[0].totalLabels );

                $('#totalLabels'+rowKey).val(data.statics[0].totalLabels );
                //$('#totalLabels'+id).val(data.statics[0].totalLabels );

                $('#label_for_orders'+rowKey).val(data.statics[0].totalLabels );
                //$('#label_for_orders'+id).val(data.statics[0].totalLabels );
            //}




        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}

function deleteMyArtwork(id, artworkId,artworkSerialNumber) {


    var serialNumber = $('#serialNumber').val();
    var cartId = $('#cartid' + serialNumber).val();
    var orderNumber = $('#orderNumber').val();
    var manfactureId = $('#manfactureId').val();
    var page = $('#page').val();
    var rowKey = $('#rowKey').val();
	  
	

    $.ajax({
        type: "post",
        url: mainUrl + "order_quotation/order/deleteArtwork",
        cache: false,
        data: {
          artworkId: artworkId,
          cartId: cartId,
          orderNumber: orderNumber,
          manfactureId: manfactureId,
          page:page,
          artworkSerialNumber:artworkSerialNumber,
          serialNumber : serialNumber
        },

      dataType: 'json',

      success: function (data) {
        var labelPerSheet = parseInt($('#lblPerSheet').val(), 10);
        var strings = data.count;
        var cc  = strings.charAt(0); // Returns "f"
        $('#design'+rowKey).val(cc);
        $('#tr_id' + id).remove();
        $('#artwork_count_status').text(data.count);
        //$('#price').text('£ ' + data.price);
        $('#price' + serialNumber).text(data.price);
        $('#qty'+rowKey).val(data.statics.totalQuantity);
        
        $('#label_for_orders'+rowKey).val(data.statics.totalLabels);
        $('#labels'+rowKey).html();
        $('#labels'+rowKey).html(data.statics.totalLabels);
        $('#totalLabels'+rowKey).val(data.statics.totalLabels);

      },
      
      error: function (jqXHR, exception) {
        if (jqXHR.status === 500) {
          alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
        } else {
          alert('Error While Requesting...');
        }
      }
    });
}

function deleteLineFromCart(lineId, cartId) {

    swal(
        "Are You Sure You Want To Delete This Line",




        {

            buttons: {

                cancel: "No",

                catch: {

                    text: "Yes",

                    value: "catch",

                },


            },

            icon: "warning",

            closeOnClickOutside: false,

        }
    ).then((value) => {

        switch (value) {


            case "catch":


                $.ajax({

                    type: "post",

                    url: mainUrl + "cart/cart/deleteLineFromCart",

                    cache: false,

                    data: {'cartId': cartId},

                    dataType: 'json',

                    success: function (data) {


                        $('#line' + lineId).remove();

                        $('#basketPrice').text('View Basket - £ ' + data.price[0].price);

                        $('#sub_total').text('£' + data.price[0].price);

                        $('#grand_total').text('£' + data.price[0].price);

                        checkout();
                    },

                    error: function (jqXHR, exception) {

                        if (jqXHR.status === 500) {

                            alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

                        } else {

                            alert('Error While Requesting...');

                        }

                    }

                });

                break;


        }

    });


}

function deleteLineFromMaterial(lineId, cartId) {
	
	$('#aa_loader').show();

    $.ajax({

        type: "post",
        url: mainUrl + "cart/cart/deleteLineFromMaterial",
        cache: false,
        data: {'cartId': cartId},
        dataType: 'json',
        success: function (data) {

            $('#asscomat' + cartId).remove();
            $('#assco' + cartId).remove();
            $('#basketPrice').text('View Basket - £ ' + data.price[0].price);
            $('#sub_total').text('£' + data.price[0].price);
            $('#grand_total').text('£' + data.price[0].price);
					  loadMyOwnCartPage();
					


        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}




function addToBasket() {

    var serialNumber = $('#serialNumber').val();
    var product_id = $('#product_id').val();
    var orderNumber = $('#orderNumber').val();
    var manfactureId = $('#manfactureId').val();
    var cartId = $('#cartid'+serialNumber).val();
    var per_shet_roll = $('#lblPerSheet').val();
    var price = $('#price').text().slice(2);
    var original_price = $('#original_price').val();
    var checkoutArtwork = $('#checkoutArtwork').val();
    var qty = $('#myqty' + serialNumber).val();
    
      var Custom_design = $('#nodesign2001').val();
      var Custom_labels = $('#at_label2001').val();
      var Custom_rolll = $('#at_roll2001').val();
      var no_sheet_pop = $('#no_sheet_pop').val();
      
       if($.isNumeric(Custom_design) ==false){
        Custom_design  =  $('#no_design_pop').val();
      }
      
      if($.isNumeric(no_sheet_pop) ==true){
        qty  =  $('#no_sheet_pop').val();
      }
      
      if($.isNumeric(Custom_rolll) ==true){
        qty  =  Custom_rolll;
      }


    var labels = 0;
    if($('.key_class').length > 0){
        $('.key_class').each(function(){
            if($(this).val()){
                var keys = $(this).val();
                labels += parseInt($('#at_label'+keys).val());
            }
        });
        //alert(labels);
        if(labels < 100){
            swal("","Minimum 100 labels are allowed","warning");
            return false;
        }
    }

    $.ajax({
        type: "POST",
        url: mainUrl + "cart/cart/setToCart",
        cache: false,
        data: {
            'manfactureId': manfactureId,
            'serialNumber': serialNumber,
            'productId': product_id,
            'per_shet_roll': per_shet_roll,
            'orderNumber': orderNumber,
            'qty':qty,
            'cartId': cartId,
            'price': price,
            'original_price': original_price,
            'checkoutArtwork': checkoutArtwork,
            'plain_print': 'Y',
            'cus_labl': Custom_labels,
            'cus_roll': Custom_rolll,
            'cus_design': Custom_design,
            'reor':'reor'
        },

        dataType: 'json',

        success: function (data) {

								
            $('#myModal').modal('hide');
            $('#cartid' + serialNumber).val('');
           // $('#basketPrice').text('View Basket - £ ' + data.price[0].price);
            //$('#sub_total').text('£' + data.price[0].price);
            //$('#grand_total').text('£' + data.price[0].price);
			update_topbasket();
            
			//alert(data);
			// alert(data.ProductName);
			// alert('ok');
			checoutPopUp(data.data.ProductName);
        },

        error: function (as) {

         alert('error');

        }

    });


}


	/*$('.reorder-qty').change(function(){
				alert('sdsd');
		var keysss = $(this).attr('data-reor');
		$('#reo_ups'+keysss).css('display:block');
		
	});*/


function getReoder(ksy,serial){
		$('#reo_ups_'+serial+'_'+ksy).removeClass('dff');
	}


function update_in_reorder(key,manfactureId,serialNumber,product_id,orderNumber,Printable,regmark) {
  
  var qty = $('#myqty' + serialNumber).val();
  var  brnds = $('#brnds' + serialNumber).val();

    /* var minQty = $("input[data-min_qty_integrated='+ serialNumber +']").val();
     minQty = (minQty ? minQty : 25);
     var maxQty = $("input[data-max_qty_integrated='+ serialNumber +']").val();
     maxQty = (maxQty ? maxQty : 50000);

     if (qty < minQty && brnds !== "Roll Labels") {
         swal("Minimum quantity should be " + minQty + " at least!",
             {
                 buttons: {
                     cancel: "OK",
                 },
                 icon: "warning",
                 closeOnClickOutside: false,
             }
         );
         $('#myqty' + serialNumber).val(minQty);

         return false;
     }

     if (qty > maxQty && brnds !== "Roll Labels") {
         swal("Maximum quantity cannot exceed "+ maxQty +" limit!",
             {
                 buttons: {
                     cancel: "OK",
                 },
                 icon: "warning",
                 closeOnClickOutside: false,
             }
         );
         $('#myqty' + serialNumber).val(maxQty);

         return false;
     }*/

    if(validationForAddToCart(serialNumber,brnds,manfactureId)){




  $.ajax({
    type: "POST",
    url: mainUrl + "cart/cart/setToCart",
    cache: false,
    data: {
      'manfactureId': manfactureId,
      'serialNumber': serialNumber,
      'productId': product_id,
      'orderNumber': orderNumber,
      'qty':qty,
      'plain_print': 'N',
      'reorder_type': 'reorder_type'
    },

    dataType: 'json',
    success: function (data) {
										
      $('#reo_ups_'+serialNumber+'_'+key).addClass('dff');
						$('#is_reorder'+ serialNumber).val('Y');
						$('#reorder_price'+ serialNumber).text('£' + data.data.reorder_price);
						$('#sheet'+ serialNumber).text(data.data.Quantity  +  'Sheets' + '/');
      $('#roll'+ serialNumber).text(data.data.Quantity  +  'Rolls' + '/');
      $('#labels'+ serialNumber).text(data.data.orignalQty +  'labels');
      $('#perlabel'+ serialNumber).text('£' + data.data.UnitPrice);
    },
    error: function (as) {
      alert('error');
    }
  });
    }
}

$(document).on("change", ".artwork_file", function (e) {
  var id = countLine;
  readURL(this,id);
  $('.artwork_file').hide();
  $('.rfiles').hide();
});

  function readURL(input,id) {
    if (input.files && input.files[0]) {
      var url = input.value;
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (ext == 'docx' || ext == 'doc') {
        $('#preview_po_img'+id).attr('src', '<?=Assets?>images/doc.png');
        $('#preview_po_img'+id).show();
        $('.upload-btn-wrapper').hide();
      }
      else if (ext == 'pdf') {
        $('#preview_po_img'+id).attr('src', '<?=Assets?>images/pdf.png');
        $('#preview_po_img'+id).show();
        $('.upload-btn-wrapper').hide();
      }
      else if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#preview_po_img'+id).attr('src', e.target.result);
          $('#preview_po_img'+id).show();
          $('.upload-btn-wrapper').hide();
        }
        reader.readAsDataURL(input.files[0]);
      }
      else {
        $('#preview_po_img'+id).attr('src', '<?=Assets?>images/no-image.png');
        $('#preview_po_img'+id).show();
        $('.upload-btn-wrapper').hide();
      }
    }
  }

function addToCurrentArtwork(id) {

    var serialNumber = $("#serialNumber").val();
    var orderNumber = $("#orderNumber").val();
    var manfactureId = $("#manfactureId").val();
    var rowKey = $("#rowKey").val();
    var productId = $("#pproduct"+rowKey).val();
    var brand = $("#brand").val();
    var pageName = $('#mypageName').val();
    var ordNumber = $('#order_number').val();
    var custId = $('#custId').val();
    var cartId = $('#cartid' + serialNumber).val();


    $.ajax({

        type: "post",

        url: mainUrl + "order_quotation/order/convertFromOldToNewArtwork",

        cache: false,

        data: {brand:brand,productId:productId,ordNumber:ordNumber,custId:custId,'artworkId': id, 'cartId': cartId, 'orderNumber': orderNumber, 'manfactureId': manfactureId,serialNumber:serialNumber,pageName:pageName},

        dataType: 'json',

        success: function (data) {

            if (brand === 'Roll Labels') {

                appendFromHistoryArtwork(data);

            } else {

                appendSheetToCurrentArtwork(data);

            }
					
					 
					// alert(data.statics.statics[0].totalQuantity);
					 //alert(data.statics.totalLabels);
		

            $('#preview_po_img').show();
            $('#artworkimage'+countLine).hide();
            $('#artwork_count_status').text(data.count);

            $('#qty'+rowKey).val(data.statics.totalQuantity);

            $('#design'+rowKey).val(data.statics.count);

            $('#label_for_orders'+rowKey).val(data.statics.totalLabels);



        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


function appendToCurrentArtwork(data) {


    $('#myBody').append(
        '<tr class="upload_row uploadsavesection " id="tr_id' + countLine + '" >' +

        '<td width="10%" class="text-center">\n' +

        ' <img width="20" class="img-circle" style="display:none;"\n' +

        '             title="Click here to remove this file" id="preview_po_img' + countLine + '"\n' +

        '             src="'+data.data.file+'">\n' +
		
		
		
		' <div class="upload-btn-wrapper "><button class="btn artwork_upload_cta "> <i class="fa fa-cloud-upload"></i> Browse File</button>' +

        '<input type="file" id="artworkimage' + countLine + '" name="file" class="artwork_file" style="display: none">\n' +

        '<!--        <button class=" btn btn-primary browse_btn"><i-->\n' +

        '<!--                    class="fa fa-cloud-upload"></i> Browse File-->\n' +

        '<!--        </button>-->\n' +

        '    </td>\n' +

        '    <td width="10%">\n' +

        '        <input class="form-control artwork_name" id="at_name' + countLine + '" placeholder="Enter Artwork Name" value="' + data.data.name + '" type="text">\n' +

        '    </td>\n' +

        '    <td width="10%">&nbsp;\n' +

        '        <input class="form-control labels_input allownumeric" id="at_label' + countLine + '" placeholder="Enter Label" value="' + data.data.labels + '" type="number" min="0">\n' +

        '    </td>\n' +

        '    <td width="10%">\n' +

        '        <input class="form-control labels_input allownumeric" id="at_roll' + countLine + '" placeholder="Enter Sheets" value="' + data.data.qty + '" type="number" min="0">\n' +

        '        <input id="old_roll' + countLine + '" value="0"  type="hidden">\n' +

        '    </td>\n' +

        '<td width="10%" id="lbl_per_roll' + countLine + '">' + data.data.labels / data.data.qty + '</td>' +

        '<td width="20%" align="center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">\n' +

        '            <input type="hidden" id="artwork_id' + countLine + '" value="' + data.data.ID + '">\n' +

        ' <button data-value="sheets" class=" btn btn-success  save_artwork_file" onclick="updateMyArtwork(' + countLine + ',this,' + data.data.ID + ')"> <i class="fa fa-save"></i> Update</button>' +

        '<button data-value="sheets" class=" btn btn-success  save_artwork_file" onclick="deleteMyArtwork(' + countLine + ',' + data.data.ID + ')"> <i class="fa fa-save"></i> Delete</button>' +

        '        </div>\n' +

        '    </td>\n' +

        '</tr>'
    );

    countLine++;

}
function appendFromHistoryArtwork(data) {

    $('#myBody').append(
        '<tr class="upload_row uploadsavesection " id="tr_id' + countLine + '" >' +

		/*'<td  class="text-center">\n'+
			  '<input type="checkbox" class="follow_art fart" data-countline="'+countLine+'" id="follow_art'+ countLine + '" name="follow_art" type="form-control"/>\n'+
		
		'<i class="fa fa-check fart" style="color:green" id="followcheck'+ countLine + '"></i>\n'+
		'<i class="fa fa-times" style="color:red" id="followtimes'+ countLine + '"></i>\n'+
		  '</td>\n'+*/
		
		
        '<td width="" class="text-center">'+
        '<div class="thumb-sm member-thumb m-b-10 mx-auto">'+
        '<img src="'+data.data.file+'" class="round-circle img-thumbnails" alt="image">'+

        '</div>'+
        '</td>'+

        '    <td width="">\n' +

        '        <input class="form-control artwork_name" id="at_name' + countLine + '" onchange="show_updt_btn('+ countLine +')" placeholder="Enter Artwork Name" value="' + data.data.name + '" type="text">\n' +

        '    </td>\n' +

        '    <td width="">\n' +

        '        <input class="form-control labels_input allownumeric" id="at_label' + countLine + '" onchange="show_updt_btn('+ countLine +')" placeholder="Enter Label" value="' + data.data.labels + '" type="number" min="0">\n' +

        '    </td>\n' +

        '    <td width="">\n' +

        '        <input class="form-control labels_input allownumeric" id="at_roll' + countLine + '" onchange="show_updt_btn('+ countLine +')" placeholder="Enter Sheets" value="' + data.data.qty + '" type="number" min="0">\n' +

        '        <input id="old_roll' + countLine + '" value="0"  type="hidden">\n' +

        '    </td>\n' +

        '<td width="" align="center" id="lbl_per_roll' + countLine + '">' + data.data.labels / data.data.qty + '</td>' +

        '<td width="" align="center">\n' +

        '            <input type="hidden" id="artwork_id' + countLine + '" value="' + data.data.ID + '">\n' +

        ' <button data-value="sheets" class=" btn btn-danger" id="updp_btn' + countLine + '" onclick="updateMyArtwork('+countLine+',this,'+data.data.ID+','+data.data.ID+','+"'update'"+')"  style="display:none; padding: 8px;"> <i class="fa fa-save"></i> </button>'+

        '<button data-value="sheets" class=" btn btn-success save_artwork_file" onclick="deleteMyArtwork(' + countLine + ',' + data.data.ID+')" style="padding: 8px;background-color: red; "> <i class="fa fa-trash"></i> </button>' +


        '    </td>\n' +

        '</tr>'
    );

    countLine++;

}




function newRollArtworkLine() {

    $('#show-at-nw').hide();
    $('#arworklineCounter').val(countLine);
    $('#myBody').append(
        '<tr class="upload_row uploadsavesection" id="tr_id' + countLine + '">\n' +
		
	

      '    <td class="text-center">\n' +

        '        <img width="20" class="img-circle" style="display:none;"\n' +

        '             title="Click here to remove this file" id="preview_po_img'+countLine+'" src="#">\n' +
		
		'<p style="color:green" class="fart" id="Artworkfollow'+countLine+'">Artwork to Follow</p>\n'+
		
        '<div class="upload-btn-wrapper" id="ArtworkWrapper'+countLine+'"><button class="btn artwork_upload_cta"><i class="fa fa-cloud-upload"></i> Browse File</button>' +

        '<input type="file" id="artworkimage' + countLine + '" name="file" class="artwork_file">\n' +
        '    </td>\n' +

        '    <td width="">\n' +

        '        <input class="form-control artwork_name" id="at_name' + countLine + '" onchange="show_updt_btn('+ countLine +')" placeholder="Enter Artwork Name" type="text">\n' +

        '    </td>\n' +

        '    <td width="">\n' +

        '        <input class="form-control labels_input allownumeric" id="at_label' + countLine + '" onchange="show_updt_btn('+ countLine +')" placeholder="Enter Label" value="" type="number" min="0">\n' +

        '    </td>\n' +
        '<input type="hidden" id="tpe' + countLine + '" value="insert">'+
        '    <td width="">\n' +

        '        <input class="form-control labels_input allownumeric" id="at_roll' + countLine + '" onchange="show_updt_btn('+ countLine +')" placeholder="Enter Roll" value="" type="number" min="0">\n' +

        '        <input id="old_roll' + countLine + '" value="0"  type="hidden">\n' +

        '    </td>\n' +

        '    <td align="center" width="" id="lbl_per_roll' + countLine + '">\n' +

        '\n' +

        '    </td>\n' +

        '\n' +

        '    <td width="" align="center">\n' +

        

        '            <input type="hidden" id="artwork_id' + countLine + '">\n' +
        '            <input type="hidden" class="key_class" value="'+countLine+'">\n' +

        '<button data-value="sheets" id="save'+ countLine +'" onclick="uploadMyArtwork(' + countLine + ',this)" class=" btn btn-danger" style="padding: 8px;"><i class="fa fa-save"></i></button>\n' +
      
        '<button data-value="sheets" id="updp_btn'+ countLine +'"  class=" btn btn-danger " onclick="updateMyArtwork('+countLine+')" style="display: none; padding: 8px;"><i class="fa fa-save"></i> </button>'+
        '<button data-value="sheets" id="delete'+ countLine +'"  class=" btn btn-success " onclick="RoleLinelose(' + countLine + ',this)" style=" padding: 8px;background-color: red;"><i class="fa fa-trash"></i> </button>'+
        '    </td>\n' +
		
        
		
			
       

        '</tr>'
    );

    countLine = countLine + 1;

}

function RoleLinelose(id,e){
	$(e).hide();
	$('#tr_id'+id).hide();
	$('#myBody').find('#tr_id' + id).remove();
	$('#show-at-nw').show();
}


function appendSheetToCurrentArtwork(data) {


    $('#myBody').append(
        '<tr class="upload_row uploadsavesection " id="tr_id' + countLine + '" >' +

		/*'<td  class="text-center">\n'+
			  '<input type="checkbox" class="follow_art fart" data-countline="'+countLine+'" id="follow_art'+ countLine + '" name="follow_art" type="form-control"/>\n'+
		
		'<i class="fa fa-check fart" style="color:green" id="followcheck'+ countLine + '"></i>\n'+
		'<i class="fa fa-times " style="color:red" id="followtimes'+ countLine + '"></i>\n'+
		  '</td>\n'+*/

        '<td width="" class="text-center">\n' +

        '        <img width="30" class="round-circle img-thumbnails" style=""\n' +

        '             title="Click here to remove this file" id="preview_po_img' + countLine + '"\n' +

        '             src="'+data.data.file+'">' +
		
		'        <div class="upload-btn-wrapper "><button class="btn artwork_upload_cta" style="display: none"> <i class="fa fa-cloud-upload"></i> Browse File</button>' +

        '<input type="file" id="artworkimage' + countLine + '" name="file" class="artwork_file" style="display: none">\n' +
		
		'<input type="hidden" class="chkimg" value="'+data.data.file+'" name="">\n' +
		

        '<!--        <button class=" btn btn-primary browse_btn"><i-->\n' +

        '<!--                    class="fa fa-cloud-upload"></i> Browse File-->\n' +

        '<!--        </button>-->\n' +

        '    </td>\n' +

        '    <td width="">\n' +

        '<input class="form-control artwork_name" id="at_name' + countLine + '" placeholder="Enter Artwork Name" value="' + data.data.name + '" type="text">\n' +

        '</td>\n' +

        '<td width="">' +

        '<input min="0" class="form-control labels_input allownumeric" onchange="changeSheetLbl(' + countLine + ',this)" id="at_roll' + countLine + '" placeholder="Enter Label" value="' + data.data.qty + '" type="number">\n' +

        '    </td>\n' +

        '    <td align="center" width="" id="at_label' + countLine + '">' + data.data.labels +  ' ' +

        '        <input id="old_roll' + countLine + '" value="0"  type="hidden">\n' +

        '    </td>\n' +

        '<td width="" align="center">\n' +

        '            <input type="hidden" id="artwork_id' + countLine + '" value="' + data.data.ID + '">\n' +

        ' <button data-value="sheets" id="updp_btn' + countLine + '" class="btn btn-danger  " onclick="updateMyArtwork(' + countLine + ',this,' + data.data.ID + ',' + data.data.ID + ','+"'update'"+')" style="display:none;padding: 8px; "> <i class="fa fa-save"></i> </button>' +

        '<button data-value="sheets" class=" btn btn-success  save_artwork_file" onclick="deleteMyArtwork(' + countLine + ',' + data.data.ID + ')" style="padding: 8px; background-color: red; margin-left: 5px; "> <i class="fa fa-trash"></i> </button>' +

       

        '    </td>\n' +

        '</tr>'
    );

    countLine++;

}



function newSheetArtworkLine() {

    $('#show-at-nw').hide();
    $('#arworklineCounter').val(countLine);
	
    $('#myBody').append(
        '<tr  class="upload_row uploadsavesection" style=" " id="tr_id' + countLine + '">\n' +


        '    <td class="text-center">\n' +

        '        <img width="20" class="img-circle" style="display:none;"\n' +

        '             title="Click here to remove this file" id="preview_po_img'+countLine+'" src="#">\n' +
		
		'<p style="color:green" class="fart" id="Artworkfollow'+countLine+'">Artwork to Follow</p>\n'+
		
        '<div class="upload-btn-wrapper" id="ArtworkWrapper'+countLine+'"><button class="btn artwork_upload_cta"><i class="fa fa-cloud-upload"></i> Browse File</button>' +

        '<input type="file" id="artworkimage' + countLine + '" name="file" class="artwork_file">\n' +
        '    </td>\n' +

        '<td ><input class="form-control artwork_name" id="at_name' + countLine + '" placeholder="Enter Artwork Name" type="text" value=""></td>\n' +

        '\n' +

        '<td><input min="0" class="form-control labels_input allownumeric" onchange="changeSheetLbl(' + countLine + ',this)" id="at_roll' + countLine + '" placeholder="Enter Sheets" value="" type="number"></td>\n' +

        '\n' +

    '<td align="center" style="vertical-align:middle;" class="text-center"><span id="at_label' + countLine + '"></span></td>\n' +

        '<td align="center">\n' +


        '            <input type="hidden" class="key_class" value="'+countLine+'">\n' +
        '        <input type="hidden" id="artwork_id' + countLine + '" value="">\n' +

        '<button data-value="sheets" id="save'+ countLine +'"  onclick="uploadMyArtwork(' + countLine + ',this)" class=" btn btn-danger" style="padding: 8px; margin-right: 3px;"><i class="fa fa-save"></i> </button>' +
      
        '           <button data-value="sheets" id="updp_btn'+ countLine +'"  class=" btn btn-danger " onclick="updateMyArtwork('+countLine+')" style="display: none; padding: 8px;"><i class="fa fa-save"></i> </button>'+
      
        '<button data-value="sheets" id="delete'+ countLine +'"  class=" btn btn-success " onclick="closeSheetLine(' + countLine + ',this)" style="padding: 8px;background-color: red;"><i class="fa fa-trash"></i> </button>'+
		
		 
		
		
       

        '</td>\n' +

        '</tr>'
    );

    countLine = countLine + 1;

}

function closeSheetLine(id,e){
	$(e).hide();
	$('#tr_id'+id).hide();
	$('#myBody').find('#tr_id' + id).remove();
	$('#show-at-nw').show();
}

var timer = '';
function show_popover(_this, text){
    $(_this).attr('data-content','');
    $(_this).popover('hide');

    $(_this).popover({'placement':'top'});
    $(_this).attr('data-content',text);
    $(_this).popover('show');


    clearTimeout(timer);
    timer = setTimeout(function(){
        $(_this).attr('data-content','');
        $(_this).popover('hide');
    }, 5000);
}

function validateRequest(id, event,page,conditon,serialNumber) {


  var labels = $(event).closest('tr').find('#at_label' + id).val();
  var roll = $(event).closest('tr').find('#at_roll' + id).val();
  var labelspersheets = parseFloat($(event).closest('tr').find('#lbl_per_roll' + id).text());
  var labelPerSheet = parseInt($('#lblPerSheet').val(), 10);
  labelspersheets = labelPerSheet;
  var sheet = $('#at_roll' + id).val();
  var name = $(event).closest('tr').find('#at_name' + id).val();
  
  var dieacross = min_rolls = parseInt($('#minrolls').val(), 10);
  var brand = $('#brand').val();
  var minlabels = parseInt($('#minlabels').val(), 10);
  var minlabels = 100;
  var maxRoll = parseInt($('#maxrolls').val(), 10);
  var max_labels_allowed = 1000000;
  var rolls = roll;
  var total_labels = parseInt(labels);
  var perroll = Math.ceil(parseFloat(total_labels / rolls));
    if (isFloat(perroll)) {
        perroll = Math.ceil(perroll);
    }
  var minroll = Math.ceil(100 / rolls); //34
  var per_rolls = minroll * rolls;
  var max_rolls_allowed = parseInt(maxRoll);

  var labelspersheets1 = 0;
  

  if(page == null || page == "" && conditon != 'update'){
    var file = $(event).closest('tr').find('#artworkimage' + id)[0].files[0];
  }

  if (brand === 'Roll Labels') {
        if ((file == "undefined" || file == '' || file == null) && page == null) {
            show_popover('.upload-btn-wrapper ', 'please upload file');
            return false;
        }


        if (name == '') {
            show_popover('#at_name' + id, 'please Enter roll artwork name');
            return false;
        }

        if (labels == 0 || labels == '') {
            $(event).closest('tr').find('#at_name' + id).val(1);
            show_popover('#at_label' + id, 'Minimum 1 Label Allowed');
            return false;
        }

        if (!is_numeric(labels)) {
            show_popover('#at_label' + id, 'Please enter numeric values in Lables');
            $(event).closest('tr').find('#at_label' + id).val('');
            return false;
        }

        if (roll == 0 || roll == '') {
            show_popover('#at_roll' + id, 'Please Enter Roll');
            return false;
        }

        if (!is_numeric(roll)) {
            show_popover('#at_roll' + id, 'Please enter numeric values Roll');
            $(event).closest('tr').find('#at_roll' + id).val('');
            return false;
        }
        if(rolls > max_rolls_allowed || total_labels > max_labels_allowed){

            if(rolls > max_rolls_allowed){
                rolls = max_rolls_allowed;
            }


            if((total_labels + rolls) >= max_labels_allowed){
                total_labels = max_labels_allowed;
                //alert('new total_labels = '+total_labels);
                labelspersheets1 = Math.floor(total_labels / rolls);
            }else{
                labelspersheets1 = Math.ceil(total_labels / rolls);
            }
            if(labelspersheets1 > labelspersheets){
                labelspersheets = labelspersheets;
            }else{
                labelspersheets = labelspersheets1;
            }
            //alert('1a');

            total_labels = Math.ceil(labelspersheets * rolls);
            

            show_faded_popover('#at_roll'+id, "Quantity has been amended for production as " + rolls + " Rolls.");
            $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
            $(event).closest('tr').find('#at_label' + id).val(total_labels);
            $(event).closest('tr').find('#at_roll' + id).val(rolls);
            return false;
        }



        if (!is_numeric(total_labels)) {

            var _this = $(event).closest('tr').find('#at_label' + id);
            show_faded_popover(_this, "Please enter number of labels.");
            $(event).closest('tr').find('#at_label' + id).val('');
            return false;
        } else if (total_labels == 0) {
            var _this = $(event).closest('tr').find('#at_label' + id);
            show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
            $(event).closest('tr').find('#at_label' + id).val('');
            return false;
        } else if (!is_numeric(rolls) || rolls == 0) {
            var _this = $(event).closest('tr').find('#at_roll' + id);
            show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
            $(event).closest('tr').find('#at_roll' + id).val('');
            return false;
        } else if (per_rolls < minlabels ) {

            var roll_input_display = $(event).closest('tr').find('#at_roll' + id).css('display');

            if (roll_input_display == 'block') {
                //alert('if');
                var requiredlabels = minlabels * rolls;
                var total_labels = perroll * rolls;

                var _this = $(event).closest('tr').find('#at_label' + id);


                if (total_labels < '100') {
                    var total_labels = '100';
                }
                $(event).closest('tr').find('#lbl_per_roll' + id).text(perroll);
                $(event).closest('tr').find('#at_label' + id).val(total_labels);



            } else {

                if (total_labels > labelspersheets) { //10501 > 3500

                    var expectedrolls = parseFloat(total_labels / labelspersheets);

                    if (isFloat(expectedrolls)) {
                        expectedrolls = Math.ceil(expectedrolls);
                    }
                    //alert('expectedrolls = '+expectedrolls);
                    if(expectedrolls > max_rolls_allowed){
                        if(total_labels >= max_labels_allowed){
                            total_labels = max_labels_allowed;
                            labelspersheets1 = Math.floor(total_labels / max_rolls_allowed);
                        }else{
                            labelspersheets1 = Math.ceil(total_labels / max_rolls_allowed);
                        }
                        //alert('2a');
                        if(labelspersheets1 > labelspersheets){
                            labelspersheets = labelspersheets;
                        }else{
                            labelspersheets = labelspersheets1;
                        }

                        show_faded_popover(_this, "Quantity has been amended for production as " + max_rolls_allowed + " Rolls.");
                        $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
                        $(event).closest('tr').find('#at_roll' + id).val(max_rolls_allowed);
                        //$(id).parents('.upload_row').find('.quantity_labels').text(max_rolls_allowed);
                        return false;
                    }


                    labelspersheets = parseInt(total_labels / expectedrolls);
                    //alert('labelspersheets = '+labelspersheets);
                    var _this = $(event).closest('tr').find('#at_roll' + id);
                    show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                    $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
                    $(event).closest('tr').find('#at_roll' + id).val(expectedrolls);
                    //$(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                    return false;
                } else {
                    //alert('else in else');
                    if (total_labels < minlabels) {
                        total_labels = minlabels;
                        var _this = $(event).closest('tr').find('#at_label' + id);
                        show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                    } else {
                        var _this = $(event).closest('tr').find('#at_label' + id);
                        //var _thiss = $(id).parents('.upload_row').find('.quantity_labels');

                        $(event).closest('tr').find('#at_label' + id).val(100);
                        //show_faded_popover(_thiss, "Quantity has been amended for production as 1 Roll.");
                    }
                    $(event).closest('tr').find('#lbl_per_roll' + id).text(total_labels);
                    //$(id).parents('.upload_row').find('.quantity_labels').text(1);
                    $(event).closest('tr').find('#at_roll' + id).val(1);
                    $(event).closest('tr').find('#at_label' + id).val(total_labels);
                    return false;
                }
            }
        } else if (perroll > labelspersheets) {

            var response = rolls_calculation(min_rolls, labelspersheets, total_labels, rolls);
            var total_labels = response['total_labels'];
            var expectedrolls = response['rolls'];


            if(expectedrolls > max_rolls_allowed){
                if(total_labels >= max_labels_allowed){
                    total_labels = max_labels_allowed;
                    labelspersheets1 = Math.floor(total_labels / max_rolls_allowed);
                }else{
                    labelspersheets1 = Math.ceil(total_labels / max_rolls_allowed);
                }
                if(labelspersheets1 > labelspersheets){
                    labelspersheets = labelspersheets;
                }else{
                    labelspersheets = labelspersheets1;
                }
                total_labels = labelspersheets * max_rolls_allowed;
                var infotxt = 'Quantity has been amended for production as ' + max_rolls_allowed + ' rolls and ' + total_labels + ' labels';
                show_faded_popover($(event).closest('tr').find('#at_label' + id), infotxt);

                $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
                $(event).closest('tr').find('#at_label' + id).val(total_labels);
                $(event).closest('tr').find('#at_roll' + id).val(max_rolls_allowed);
                return false;
            }



            var labelspersheets = parseInt(total_labels / expectedrolls);
            var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
            show_faded_popover($(event).closest('tr').find('#at_label' + id), infotxt);
            $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
            $(event).closest('tr').find('#at_label' + id).val(total_labels);
            $(event).closest('tr').find('#at_roll' + id).val(expectedrolls);
            return false;

        } else {

            var pr_rol_lb = 0;
            pr_rol_lb = Math.ceil(minlabels / dieacross);

            var total_labels = parseInt(perroll) * parseInt(rolls);
            if (total_labels < (pr_rol_lb * parseInt(rolls))) {
                var total_labels = (pr_rol_lb * parseInt(rolls));

            }



            if (perroll <= pr_rol_lb) {
                total_labels = pr_rol_lb * rolls;
                perroll = total_labels / rolls;
            }


            $(event).closest('tr').find('#lbl_per_roll' + id).text(perroll);
            $(event).closest('tr').find('#at_label' + id).val(total_labels);
        }




        return true;
    }
  
   if(brand == 'Integrated Labels'){
        if ((file == "undefined" || file == '' || file == null) && page == null  && conditon !='update') {
          show_popover('.upload-btn-wrapper ','please upload file');
          return false;
        }




     if (name == '') {
       show_popover('#at_name'+id,'please Enter artwork name');
       return false;
     }

     if(roll == 0 || roll == '') {
       show_popover('#at_roll'+id,'Please Enter Roll');
       return false;
     }

     if (!is_numeric(roll)) {
       show_popover('#at_roll'+id,'Please enter numeric values Roll');
       $(event).closest('tr').find('#at_roll' + id).val('');
       return false;
    }

     /*if(roll < 1000){
       show_popover('#at_roll'+id,'Minmim Roll 1000');
       $(event).closest('tr').find('#at_roll' + id).val(1000);
       return false;
     }*/
     
     var min_qty = $("[data-min_qty_integrated='"+serialNumber+"']").val();
     var max_qty = $("[data-max_qty_integrated='"+serialNumber+"']").val();
    
    var box = roll;
    var batch = min_qty;
    
    
    //alert(box);
    //alert(batch);
    
    if(box%batch != 0)
    {
      if(batch == 250)
      {
        box = Math.ceil(box/250)*250;
      }
      else
      {
        box = Math.ceil(box/1000)*1000;
      }
      //$('#no_sheet_pop').val(box);
      
      
      show_popover('#at_roll'+id,'Quantity has been round off to'+batch);
      $(event).closest('tr').find('#at_roll' + id).val(box);
      parseInt($(event).closest('tr').find('#at_label' + id).text(''));
      parseInt($(event).closest('tr').find('#at_label' + id).text(box));
       
    }
     
     
   }
  else {

    var sheetLabels = parseInt($(event).closest('tr').find('#at_label' + id).text());

    
    
    var min = $("[data-min_qty_integrated='"+serialNumber+"']").val();
    var max = $("[data-max_qty_integrated='"+serialNumber+"']").val();
    
    var integr = brand;
    var boxs = sheet;

      /* var filess= $(event).closest('tr').find('#artworkimage'+ id).val();

       if(filess.length==0 ){
           // /show_popover('#artworkimage'+id,'Please Enter artwork name');
           alert('Please upload Image First 2');
           return false;
           //break;
       }*/

    
    if (name == '') {
        show_popover('#at_name'+id,'Please Enter artwork name');
      //alert('please Enter artwork name');
      return false;
    }

    if (sheet == null || sheet == "" || sheet == 'NaN') {
      show_popover('#at_roll'+id,'Please Add sheet Quantity Here');
      return false;
    }

    if (sheet <= 0 ) {
      show_popover('#at_roll'+id,'Quantity amended '+min);
      $(event).closest('tr').find('#at_roll' + id).val(min);
      $(event).closest('tr').find('#at_label' + id).text(min * labelPerSheet);
      return false;
    }
    
    
    //if(integr!='A3 Label' && integr!='SRA3 Label'){
    
   /* if (parseInt(sheet) < parseInt(min) ) {
      show_popover('#at_roll'+id,'Minimum Quantity '+min);
      $(event).closest('tr').find('#at_roll' + id).val(min);
      $(event).closest('tr').find('#at_label' + id).text(min * labelPerSheet);
      return false;
    }*/
    
    //}
       
  
    //alert(integr+''+boxs);
    /*if(integr=='A4 Labels'){
    
    if(boxs < 25)
    {
      
      show_popover('#at_roll'+id,'Quantity has been round off to 25');
      $(event).closest('tr').find('#at_roll' + id).val(25);
      
    
    }
  }
  
  if(integr=='A3 Label'){
    if(boxs < 100)
    { 
     
      show_popover('#at_roll'+id,'Quantity has been round off to 100');
      $(event).closest('tr').find('#at_roll' + id).val(100);
      
     
    }
  }
  
  if(integr=='SRA3 Label'){
    if(boxs < 100){
      
      show_popover('#at_roll'+id,'Quantity has been round off to 100');
      $(event).closest('tr').find('#at_roll' + id).val(100);
    }
  }*/
    
    
  
   
    if (parseInt(sheet) > parseInt(max)) {
            
      show_popover('#at_roll'+id,'Maximum ' + max + ' allowed');
      $(event).closest('tr').find('#at_roll' + id).val(max);
      $(event).closest('tr').find('#at_label' + id).text(max * labelPerSheet);
      //$(event).closest('tr').find('#at_roll' + id).val(getMaxQuantiy(brand));
      //$(event).closest('tr').find('#at_label' + id).text(getMaxQuantiy(brand) * labelPerSheet);

      return false;
    }
    
    return true;
  }
  return true;

}


function rolls_calculation(die_across, max_labels, total_labels, rolls) {

    if (rolls == 0) {

        rolls = parseInt(die_across);

    }

    else {

        //rolls = parseInt(rolls) + parseInt(die_across);
        rolls = parseInt(rolls) + 1;

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


function changeSheetLbl(id, event) {
	
    var labelPerSheet = parseInt($('#lblPerSheet').val());
	var qty = $(event).val();
	
	var des = parseInt(qty) * parseInt(labelPerSheet);
	
	$('#at_label'+id).html(des);
	
	var chk = $('#save'+id).is(":visible");
	if(chk!=false){
	}else{
		$('#updp_btn'+id).show();
	}
	
    

}

$(document).on("change", ".artwork_file", function (e) {

    readURL(this);

});


function readURL(input) {


    if (input.files && input.files[0]) {

        var url = input.value;

        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

        if (ext == 'docx' || ext == 'doc') {

            $('#preview_po_img').attr('src', '<?=Assets?>images/doc.png');

            $('#preview_po_img').show();

            $('.browse_btn').hide();

        }

        else if (ext == 'pdf') {

            $('#preview_po_img').attr('src', '<?=Assets?>images/pdf.png');

            $('#preview_po_img').show();

            $('.browse_btn').hide();

        }

        else if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $('#preview_po_img').attr('src', e.target.result);

                $('#preview_po_img').show();

                $('.browse_btn').hide();

            }

            reader.readAsDataURL(input.files[0]);

        }

        else {

            $('#preview_po_img').attr('src', '<?=Assets?>images/no-image.png');

            $('#preview_po_img').show();

            $('.browse_btn').hide();

        }

    }

}


function hidenewArtworkLine() {

    $('#neewatwork').hide();

    $('#hide-at-nw').hide();

    $('#show-at-nw').show();

}


$(document).on("click", ".pagination a", function (e) {


    var page = $(this).attr("data-page"); //get page number from link


    if (typeof page != 'undefined' && page.length > 0) {

        show_paging(page);

    }

});


function show_paging(start) {


    var customer = $('#custId').val();

    var total = parseInt($('#count').val());


    getCustomerOrders(customer, total, start);

}


// Add to Cart


function addToCart(manfactureId, serialNumber, printing, productId, orderNumber, brand,page = null,rowKey=null,labelperroll=null,regmark=null) {

	if (printing == 'Y' && (regmark != 'Y' || regmark == null)) {
		addToPrintingCart(serialNumber, productId, orderNumber, manfactureId, brand,page,rowKey);
	} else {
		addToPlainCart(labelperroll,manfactureId, serialNumber, productId, orderNumber,regmark,brand);
		
	}
	
	//update_topbasket();

}

  function update_topbasket(){
    $.ajax({
        type: "get",
        url: mainUrl +"cart/cart/update_topbasket",
        data: {},
        dataType: 'html',
        success: function (data) {
            var msg = $.parseJSON(data);
            var price = (msg.price == null || msg.price == "")?0.00:msg.price;
			$('#basketPrice').html('View Basket - '+ msg.symb +' '+ price);
          },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('No Invoice..');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}




function addToPrintingCart(serialNumber, productId, orderNumber, manfactureId, brand,page,rowKey) {


	$.ajax({

		type: "get",
		url: mainUrl + "order_quotation/order/getProductsAllArtwork",
		cache: false,

		data: {

			'productId': productId,
			'serialNumber': serialNumber,
			'orderNumber': orderNumber,
			'cartId':'',
			'manfactureId': manfactureId,
			'brand': brand,
			'page':page,
			'rowKey':rowKey,
		},
		dataType: 'json',
		success: function (data) {
			
			$('#myatw').empty();
			$('#myatw').empty();
			$('#myatw').html(data.html);
		   art_pop_tbs();
			$('#myModal').modal('show');
			$('#cartid' + serialNumber).val(data.cartId);
			$('#muCartId' + serialNumber).val(data.cartId);
			$('#artwork_count_status').text(data.count);
			$('#price').text('£ ' + data.price);
			$('#price' + serialNumber).text(data.price);
			if(page !=null && page !=""){
				$('#reloadmypage').show();
				$('#addTobskt').hide();
				$('#price').hide();
			}else{
				$('#reloadmypage').hide();
				$('#addTobskt').show();
           }
			// update_topbasket();
			
        },

		error: function (jqXHR, exception) {

			if (jqXHR.status === 500) {
				
				alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
				
			} else {
							
				alert('Error While Requesting...');

			}

		}

	});
}

function art_pop_tbs() {

	$("#sbs").dataTable({
		"sDom": 'l<"toolbar">frtip',
		"bProcessing": false,
		"bServerSide": false,
		"bDestroy": true,
		"bJQueryUI": true,
		"sPaginationType": "simple_numbers",
		// "lengthMenu": [[4, 10, 25, 50, -1], [4, 10, 25, 50, "All"]],
		"iDisplayStart ": 20,
		"iDisplayLength": 10,
		"aaSorting": [[0, 'desc']],
		"bFilter": false,
    "bLengthChange": false,
		//"stateSave": true,
		language: {
			paginate: {
				next: '&#8594;', // or '→'
				previous: '&#8592;' // or '←'
			}
		},
	});
}

function tempArtPo(){
	var key  = $(checkouttr).val();
	$('.updateMe'+key).trigger('click');
}

function QuoteDetailp(){
	var key  = $(rowKey).val();
	$('#content_save'+key).trigger('click');
}

function Orderdetailp(){
	var key  = $(rowKey).val();
	$('#update_one'+key).trigger('click');
}




function getTempProductsArtworks(checkouttr, cartId, brand, manfactureId, productId) {


    $.ajax({
        type: "get",
        url: mainUrl + "order_quotation/order/getTempProductsArtworks",
        cache: false,
        data: {
            'cartId': cartId,
            'brand': brand,
            'manfactureId': manfactureId,
            'productId': productId,
            'checkouttr': checkouttr,
        },

        dataType: 'json',
        success: function (data) {
            //console.log(data.html);
            $('.myatw').empty();
            $('.myatw').html(data.html);
            $('#price').text('£' + data.cartPrice);
            $('#original_price').val(data.cartPrice);
            $('#cartid').val(data.cartId);
            $('.carter1').modal('show');

            if(page !=null && page !=""){
                $('#reloadmypage').show();
                $('#addTobskt').hide();
            }else{
                $('#reloadmypage').hide();
                $('#addTobskt').show();
            }
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}


function addToPlainCart(labelperroll,manfactureId, serialNumber, productId, orderNumber,regmark =null,brand=null) {

    var qty = $('#myqty' + serialNumber).val();

    if(validationForAddToCart(serialNumber,brand,manfactureId)){


        $.ajax({

            type: "post",

            url: mainUrl + "cart/cart/setToCart",

            cache: false,

            data: {

                'manfactureId': manfactureId,
                'serialNumber': serialNumber,
                'productId': productId,
                'orderNumber': orderNumber,
                'qty': qty,
                'labelperroll': labelperroll,
                'regmark': regmark,
                'plain_print': 'N'

            },

            dataType: 'json',

            success: function (data) {
                //$('#basketPrice').text('View Basket - £' + data.price[0].price);
				update_topbasket();
                checoutPopUp(data.data.ProductName)
            },

            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }
}

function validationForAddToCart(key,brand,manfactureId) {
    var qty = parseInt($('#myqty'+key).val());
     
    var isSpeMat= isSpecialMaterial(manfactureId);
    var min = 25;
    var max = 50000;
        
    if(isSpeMat){
        min = 5;
        max = 5000;
    }
    
    if(brand == 'Roll Labels' ){
        var min = $('[data-calulate_min_rolls=' + key + ']').attr('value');
        var max = $('[data-calulate_max_rolls=' + key + ']').attr('value');
                
        if (qty % min != 0) {
            if (qty % min != 0) {
                var multipyer = min * parseInt(parseInt(qty / min) + 1);
                if (multipyer > max) {
                    multipyer = max;
                }
                min = multipyer;
            }
            show_faded_alert('myqty'+key, "Quantity has been round off to " + min + " rolls. ");
        }
    }

    if(qty < min){
        $('#myqty'+key).val(min);
        show_faded_alert('myqty'+key,'Minimum Quantity '+min+' Allowed');
        return false;
    }
    if(qty > max){
        $('#myqty'+key).val(max);
        show_faded_alert('myqty'+key,'Maximum Quantity '+max+' Allowed');
        return false;
    }
    return true;
}

function resetData() {
    //$('#cartid').val('');
    $('#show-at-nw').show();
    $('#other-at-nw').hide();
}


function checoutPopUp(ProductName) {
  swal(
    "Added to your basket",
    ProductName,
    {
      buttons: {
        cancel: "Continue Shopping",
        catch: {
          text: "Checkout",
          value: "catch",
        },
      },
      icon: "success",
      closeOnClickOutside: false,
    }
    ).then((value) => {
    switch (value) {
      case "catch":
        //checkout();
        window.location.reload(true);
        break;
    }
    });
}


function is_numeric(mixed_var) {

    var whitespace =

        " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";

    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -

        1)) && mixed_var !== '' && !isNaN(mixed_var);

}


function getMinQuantiy(format) {


    var minqty = 0;


    if (format == 'A4 Labels') {

        minqty = 25;

    }


    else if (format == 'A3 Label') {

        minqty = 100;

    }

    else if (format == 'A5 Labels') {

        minqty = 25;

    }

    else if (format == 'SRA3 Label') {

        minqty = 100;

    }

    else if (format == 'Roll Labels') {

        minqty = 100;

    }


    return minqty


}


function getMaxQuantiy(format) {

    var maxqty = 0;


    if (format == 'A4 Labels') {

        maxqty = 50000;

    }


    else if (format == 'A3 Label') {

        maxqty = 50000;

    }

    else if (format == 'A5 Labels') {

        maxqty = 50000;

    }

    else if (format == 'SRA3 Label') {

        maxqty = 50000;

    }

    else if (format == 'Roll Labels') {

        maxqty = 50000000;

    }


    return maxqty

}


function showUpdateLink(id, minRoll, minLables, maxRoll, maxLabels, labelPerSheet, brand) {

    var sheet = $('#checkout_qty' + id).val();


    if (sheet < 0) {

        alert('minmum ' + getMinQuantiy(brand) + ' allowed');

        $('#checkout_qty' + id).val(getMinQuantiy(brand));

        $('#update' + id).show();

        return false;

    }


    if (sheet < getMinQuantiy(brand)) {

        alert('minmum ' + getMinQuantiy(brand) + ' allowed');

        $('#checkout_qty' + id).val(getMinQuantiy(brand));

        $('#update' + id).show();

        return false;

    }

    if (sheet > getMaxQuantiy(brand)) {

        alert('maxum ' + getMaxQuantiy(brand) + ' allowed');

        $('#checkout_qty' + id).val(getMaxQuantiy(brand));

        $('#update' + id).show();

        return false;

    }


    $('#update' + id).show();

    return true;


}


function updatePrice(id, cartId, printing, brand, manufactureId) {

    var qty = $('#checkout_qty' + id).val();


    $.ajax({

        type: "get",

        url: mainUrl + "order_quotation/order/getCheckoutPrice",

        cache: false,

        data: {

            'manufactureId': manufactureId,

            'brand': brand,

            'printing': printing,

            'qty': qty,

            'cartId': cartId,


        },

        dataType: 'json',

        success: function (data) {

            $('#basketPrice').text('View Basket - £ ' + data.cartPrice[0].price);

            $('#sub_total').text('£' + data.cartPrice[0].price);

            $('#grand_total').text('£' + data.cartPrice[0].price);

            $('#checkout_price' + id).text('£' + data.price);

            $('#checkout_unit_price' + id).text(data.price / qty);

            $('#update' + id).hide();

        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


function validationPass(id, brand ,printType=null,regmark = null,qty=null,labelperRoll=null,totalLabels=null,manufacture) {

	$('#artwork_section' + id).show();
	var orientation = $('#Orientation' + id).val();
    var finish = $('#finish' + id).val();
    var digital = $('#digital' + id).val();
    var print = $('#print' + id).val();
    var wound = $('#wound' + id).val();
    var arwtork_qty = parseInt($('#arwtork_qty'+ id).val(),10);
    var design = parseInt($('#design'+ id).val(),10);
    var qty = $('#qty' + id).val();
    var batch = $('#totalQty' + id).val(); 
	//alert(batch);

    if ((digital == "" || digital == null) && (printType === 'Y') && regmark != 'Y') {
        show_faded_alert('digital'+id,'Select Digital Please..');
        return false;
    }
    if(brand == 'Roll Labels' ){
		var minroll = parseInt($('#minroll'+id).val(),10);
        var maxroll = parseInt($('#maxroll'+id).val(),10);
        var minlabel = parseInt($('#minlabel'+id).val(),10);
        var maxlabel = parseInt($('#maxlabel'+id).val(),10);
        
		if(printType == 'N'){
			if(qty < minroll){
				show_faded_alert('qty'+id,'Minmin Quantity '+minroll);
                $('#qty'+id).val(minroll);
                $('#totalLabels'+id).val(labelperRoll*minroll);
				return false;
			}
			
			if(qty > maxroll){
				show_faded_alert('qty'+id,'Maximun Quantity '+maxroll);
				$('#qty'+id).val(maxroll);
                $('#totalLabels'+id).val(labelperRoll*maxroll);
                return false;
			}
			
            else if (qty % minroll != 0) {
				
				if (qty % minroll != 0) {
                    var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
                    if (multipyer > maxroll) {
                        multipyer = maxroll;
                    }
                    $('#qty'+id).val(multipyer);
                    $('#totalLabels'+id).val(labelperRoll*multipyer);
                }
				show_faded_alert('qty'+id, "Quantity has been round off to " + minroll + " rolls. ");
				return false;
			}
			return true;
		}
           
		if(printType == 'Y' && regmark != 'Y'){
			if (orientation == "" || orientation == null) {
				show_faded_alert('Orientation'+id ,'please Select Orientation..')
				return false;
			}
            if (wound == "" || wound == null ) {
                show_faded_alert('wound'+id,'Please Select wound Please..');
                return false;
			}
            if (finish == "" || finish == null ) {
                show_faded_alert('finish'+id,'Please Select finish Please..');
                return false;
			}
		}
        else if(printType == 'Y' && regmark == 'Y'){
			if(qty < minroll){
                show_faded_alert('qty'+id,'minmim Labels'+minroll);
                $('#totalLabels'+id).val(labelperRoll*minroll);
                $('#qty'+id).val(minroll);
                return false;
			}

			if(qty > maxroll){
                show_faded_alert('qty'+id,'maxmum Labels'+maxroll);
                $('#totalLabels'+id).val(labelperRoll*maxroll);
                $('#qty'+id).val(maxroll);
				return false;
			}

            else if (qty % minroll != 0) {
                if (qty % minroll != 0) {
					var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
                    if (multipyer > maxroll) {
						multipyer = maxroll;
					}
                    $('#qty'+id).val(multipyer);
                    $('#totalLabels'+id).val(labelperRoll*multipyer);
				}
                show_faded_alert('qty'+id, "Sorry! these labels are only available in sets of " + minroll + " rolls. ");
                return false;
            }
            return true;
        }
        else if(printType == 'Y' && regmark != 'Y'){
            if(qty < minroll){
                show_faded_alert('qty'+id,'minmim Labels'+minroll);
                $('#totalLabels'+id).val(labelperRoll*minroll);
                $('#qty'+id).val(minroll);
                return false;
            }

            if(qty > maxroll){
                show_faded_alert('qty'+id,'maxmum Labels'+maxroll);
                $('#totalLabels'+id).val(labelperRoll*maxroll);
                $('#qty'+id).val(maxroll);
                return false;
            }

            else if (qty % minroll != 0) {
                if (qty % minroll != 0) {
                    var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
                    if (multipyer > maxroll) {
                        multipyer = maxroll;
                    }
                    $('#qty'+id).val(multipyer);
					$('#totalLabels'+id).val(labelperRoll*multipyer);
				}
                show_faded_alert('qty'+id, "Sorry! these labels are only available in sets of " + minroll + " rolls. ");
                return false;
			}
            return true;
		}
	}

	else if(brand == 'Integrated Labels'){ 
       var  min_qty = batch;
       var max_qty = 500000;
		if(qty == NaN)
		{  
			show_faded_alert('qty'+id, "Minimum "+batch+" sheets allowed");
			$('#qty' + id).val(min_qty);
			return false;
		}
		else if(qty < min_qty)
		{
			show_faded_alert('qty'+id, "Minimum "+batch+" sheets allowed");
			$('#qty' + id).val(min_qty);
			return false;
		}
		else if(qty > max_qty)
		{
			show_faded_alert('qty'+id, "Maximum "+max_qty+" sheets allowed");
			$('#qty' + id).val(max_qty);
			
			return false;
		}
		
		if(qty%batch != 0)
		{
			if(batch == 250)
			{
				qty = Math.ceil(qty/250)*250;
			}
			else
			{
				qty = Math.ceil(qty/1000)*1000;
			}
		}
		
		
		if(qty ==0)
		{
			show_faded_alert('qty'+id, "Minimum "+batch+" sheets allowed");
			$('#qty' + id).val(min_qty);
			return false;
		}else{
			$('#qty' + id).val(qty);
			show_faded_alert('qty'+id, "Quantity has been round off to "+qty);
		}
		
		
	}

    else if(printType != 'Y' && regmark != 'Y'){
        
         var isSpeMat= isSpecialMaterial(manufacture);
         var min_qty = 25;
         var max_qty = 50000;
         
           if(isSpeMat){
              min_qty = 5;
              max_qty = 5000;
            }
    
         if(qty < min_qty){
          show_faded_alert('qty'+id,'Minimum '+min_qty+' Labels');
          $('#totalLabels'+id).val(labelperRoll*min_qty);
          $('#qty'+id).val(min_qty);
          return false;
        }
        
        if(qty > max_qty){
          show_faded_alert('qty'+id,'Maximum Quantity'+max_qty);
          $('#totalLabels'+id).val(labelperRoll*max_qty);
          $('#qty'+id).val(max_qty);
          return false;
        }
	}
	else if(printType == 'Y' && regmark != 'Y'){

		var isSpeMat= isSpecialMaterial(manufacture);
        var min_qty = 25;
        var max_qty = 50000;
        if(isSpeMat){
           min_qty = 5;
           max_qty = 5000;
        }
        
        if(qty <min_qty){
          show_faded_alert('qty'+id,'Minimum '+min_qty+' Labels');
          $('#totalLabels'+id).val(labelperRoll*min_qty);
          $('#qty'+id).val(min_qty);
          return false;
        }
        if(qty > max_qty){
          show_faded_alert('qty'+id,'Maximum Quantity'+max_qty);
          $('#totalLabels'+id).val(labelperRoll*max_qty);
          $('#qty'+id).val(max_qty);
          return false;
        }
	}

	return true

}

 function isSpecialMaterial(manufacture){
  
    var m1 = "PETC";
    var m2 = "PETH";
    var m3 = "PVUD";

    var PETC  = manufacture.indexOf(m1);
    var PETH  = manufacture.indexOf(m2);
    var PVUD  = manufacture.indexOf(m3);

    if(PETC!='-1' || PETH!='-1' || PVUD!='-1'){
      //alert('ohh');
       return true;
    }else{
      return false;
    }
}



function updateLinePrice(id, cartId, printType, brand, manufacture, productId,pressproof,customerId,regmark=null,labelPerSheet=null,totalLabels=null){

    var qty = $('#qty' + id).val();
    var orientation = $('#Orientation' + id).val();
    var finish = $('#finish' + id).val();
	
    var digital = $('#digital' + id).val();
    var wound = $('#wound' + id).val();
    var labels = $('#totalLabels' + id).val();
    var design = $('#design' + id).val();
    var pressproof = $('#pressProf'+id).val();
    
    var pressVal =  $('#pressProf'+id).is(":checked");
	PressPrf= 0;
	if(pressVal){
		PressPrf = 1;
	}
	
    
    if(printType=="Y" && design==0){
      $('#artworki_for_cart' + id).trigger('click');
      return false;
    }
    
    var labelperRoll = labels / qty;
    if (validationPass(id, brand ,printType,regmark,qty,labelperRoll,totalLabels,manufacture)) {
	
		swal( "Do You Really Want to Update?",
        {
            buttons: {
                cancel: "No",
                catch: {
                    text: "Yes",
                    value: "catch",
               },
           },
            icon: "warning",
            closeOnClickOutside: false,
        }
    ).then((value) => {
            switch (value) {
                case "catch":
            
        var qty = confirm_update();
        
        if(qty === true){
                        var quantity = $('#qty' + id).val();
                        var design = $('#design' + id).val();
                        var labels = $('#totalLabels' + id).val();
         
        $.ajax({

            type: "post",

            url: mainUrl + "order_quotation/order/changeLineToPrintOrPlain",

            cache: false,

            data: {

                'cartId': cartId,
                'printing': printType,
                'manfectureId': manufacture,
                'brand': brand,
                'productId': productId,
                'productBrand': brand,
                'Orientation': orientation,
                'finish': finish,
                'digital': digital,
                'wound': wound,
                'labels': labels,
                'qty': quantity,
                'labelperRoll':labelperRoll,
                'labelPerSheet':labelPerSheet,
                'pressproof':PressPrf,
                'design':design,
                'customerId':customerId,
                'regmark':regmark
            },

            dataType: 'json',

            success: function (data) {

               $('.carter1').modal('hide');
                // $('#delete' + id).show();
                //
                // $('#updateMe' + id).hide();
                //
                // $('#checkout_qty' + id).attr('readonly', true);
                //
                // $('#checkout_qty' + id).val(data.qty);
                //
                // $('#basketPrice').text('View Basket - £ ' + data.cartPrice[0].price);
                //
                // $('#sub_total').text('£' + data.cartPrice[0].price);
                //
                // $('#grand_total').text('£' + data.cartPrice[0].price);
                //
                // $('#checkout_price' + id).text('£' + data.price);
                //
                // $('#checkout_unit_price' + id).text(data.price / qty);

                checkout();

            },

            error: function (jqXHR, exception) {

                if (jqXHR.status === 500) {

                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

                } else {

                    alert('Error While Requesting...');

                }

            }

        });
        }
                default:
                    return false;
            }
        });
    }
}


function confirm_update() {
    var rowKey = $('#rowKey').val();

    var arrNumber = new Array();
    var artwork_details_data = '';
    var cartid = $('#cartid').val();
    var product_id = $('#product_id').val();
    var orderNumber = $('#orderNumber').val();
    //var customerId = $('#customerId').val();
    var customerId = $('#custId').val();
    var manfactureId = $('#manfactureId').val();
    var serialNumber = $('#serialNumber').val();
    var checkoutArtwork = $('#checkoutArtwork').val();
    var page = $('#page').val();
    var condition = $('#condition').val();
    var brand = $('#brand').val();





    var labels = 0;
    if($('.key_class').length > 0){
        var is_rollss = brand.search("Roll");
        $('.key_class').each(function(){
            if($(this).val()){
                var keys = $(this).val();
                //labels += parseInt($('#at_label'+keys).val());

                if(is_rollss > -1){
                    labels += parseInt($('#at_label'+keys).val());
                }else{
                    labels += parseInt($('#at_label'+keys).text());
                }
            }
        });
        //alert(labels);
        if(labels < 100){
            swal("","Minimum 100 labels are allowed","warning");
            return false;
        }
    }






    var new_qty = 0;
    $('.key_class').each(function(){
        if($(this).val()){
            var keys = $(this).val();
            //alert(keys);
            var artworkID = $('#artwork_id'+keys).val();
            var rolls_qty = $('#at_roll'+keys).val();
            //var labels = $('#at_label'+keys).val();

            var labels = 0;
            if(is_rollss > -1){
                labels += parseInt($('#at_label'+keys).val());
            }else{
                labels += parseInt($('#at_label'+keys).text());
            }
            var name = $('#at_name'+keys).val();
            var artworkimage = $('#artworkimage'+keys).val();






            if(keys >= 50000){
                var uploadfile = $('#artworkimage' + keys)[0].files[0];
            }else{
                var uploadfile = '';
            }

            var form_data = new FormData();
            form_data.append("file", uploadfile);
            form_data.append("cartid", cartid);
            form_data.append("artworkID", artworkID);
            form_data.append("qty", rolls_qty);
            form_data.append("labels", labels);
            form_data.append("name", name);
            form_data.append("artworkimage", artworkimage);
            form_data.append("product_id", product_id);
            form_data.append("status", 'confirm');
            form_data.append("source", 'backoffice');
            form_data.append("type", 'new');
            form_data.append("customerId", customerId);
            form_data.append("checkoutArtwork", checkoutArtwork);
            form_data.append("condition", condition);






            $.ajax({
                type: "post",
                url: mainUrl + "order_quotation/order/artwork_details_data",
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                enctype: 'multipart/form-data',
                data: form_data,
                dataType: 'json',
                success: function (data) {
                    //alert('new qty = '+data.statics[0].totalQuantity);
                    var trval = $('#checkouttr').val();
                    $('#checkout_qty' + trval).val(data.statics[0].totalQuantity);
                    $('#checkout_unit_price' + trval).text(data.price / data.statics[0].totalQuantity);
                    $('#design'+rowKey).val(data.statics[0].count);
                    $('#arwtork_qty'+rowKey).val(data.statics[0].totalQuantity);
                    $('#qty'+rowKey).val(data.statics[0].totalQuantity);

                    //$('#myqty'+serialNumber).val(data.statics[0].totalQuantity);
                    $('#labels'+rowKey).text(data.statics[0].totalLabels );
                    $('#totalLabels'+rowKey).val(data.statics[0].totalLabels );
                    $('#label_for_orders'+rowKey).val(data.statics[0].totalLabels );

                    //$('.updateMe'+key).trigger('click');

                    //return true;
                },
                error: function (jqXHR, exception) {
                    alert('Error While Requesting....');
                }
            });


        }

    });
    return true;
}



function confirm_update_order_artwork() {
    var rowKey = $('#rowKey').val();

    var arrNumber = new Array();
    var artwork_details_data = '';
    var cartid = $('#cartid').val();
    var product_id = $('#product_id').val();
    var orderNumber = $('#orderNumber').val();
    //var customerId = $('#customerId').val();
    var customerId = $('#custId').val();
    var manfactureId = $('#manfactureId').val();
    var serialNumber = $('#serialNumber').val();
    var checkoutArtwork = $('#checkoutArtwork').val();
    var page = $('#page').val();
    var condition = $('#condition').val();
    var brand = $('#brand').val();



    //alert(is_rollss);

    var labels = 0;
    if($('.key_class').length > 0){
        var is_rollss = brand.search("Roll");
        $('.key_class').each(function(){
            if($(this).val()){
                var keys = $(this).val();
                if(is_rollss > -1){
                    labels += parseInt($('#at_label'+keys).val());
                }else{
                    labels += parseInt($('#at_label'+keys).text());
                }

                //alert('keys = '+keys);
            }
        });
        //alert(labels);
        if(labels < 100){
            swal("","Minimum 100 labels are allowed",
                {
                    buttons: {
                        cancel: "OK",
                    },
                    icon: "warning",
                    closeOnClickOutside: false,
                }
                );
            return false;
        }
    }


    //alert('labels = '+labels);




    /*swal( "Do You Really Want to Update?",
        {
            buttons: {
                cancel: "No",
                catch: {
                    text: "Yes",
                    value: "catch",
                    closeModal: false
                }
            },
            icon: "warning",
            closeOnClickOutside: false,
        }
    )*/




    var new_qty = 0;
    $('.key_class').each(function(){

        if($(this).val()){
            var keys = $(this).val();
            //alert(keys);
            var artworkID = $('#artwork_id'+keys).val();
            var rolls_qty = $('#at_roll'+keys).val();

            var labels = 0;
            if(is_rollss > -1){
                labels += parseInt($('#at_label'+keys).val());
            }else{
                labels += parseInt($('#at_label'+keys).text());
            }






            //var labels = $('#at_label'+keys).val();
            var name = $('#at_name'+keys).val();
            var artworkimage = $('#artworkimage'+keys).val();




            //alert(labels);


            if(keys >= 50000){
                var uploadfile = $('#artworkimage' + keys)[0].files[0];
            }else{
                var uploadfile = '';
            }

            var form_data = new FormData();
            form_data.append("file", uploadfile);
            form_data.append("cartid", cartid);
            form_data.append("artworkID", artworkID);
            form_data.append("qty", rolls_qty);
            form_data.append("labels", labels);
            form_data.append("name", name);
            form_data.append("artworkimage", artworkimage);
            form_data.append("orderNumber", orderNumber);
            form_data.append("serialNumber", serialNumber);
            form_data.append("ProductID", product_id);
            form_data.append("manfactureId", manfactureId);
            form_data.append("customerId", customerId);
            form_data.append("status", 'confirm');
            //form_data.append("source", 'admin');
            form_data.append("type", 'new');
            form_data.append("checkoutArtwork", checkoutArtwork);
            form_data.append("condition", condition);




            /*$("#aa_loader").css('z-index','90000');
            $('#aa_loader').show();*/


            $.ajax({
                type: "post",
                url: mainUrl + "order_quotation/order/artwork_details_data_order_edit",
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                enctype: 'multipart/form-data',
                data: form_data,
                dataType: 'json',
                success: function (data) {
                    //alert('new qty = '+data.statics[0].totalQuantity);
                    var trval = $('#checkouttr').val();
                    $('#checkout_qty' + trval).val(data.statics[0].totalQuantity);
                    $('#checkout_unit_price' + trval).text(data.price / data.statics[0].totalQuantity);
                    $('#design'+rowKey).val(data.statics[0].count);
                    $('#arwtork_qty'+rowKey).val(data.statics[0].totalQuantity);
                    $('#qty'+rowKey).val(data.statics[0].totalQuantity);

                    //$('#myqty'+serialNumber).val(data.statics[0].totalQuantity);
                    $('#labels'+rowKey).text(data.statics[0].totalLabels );
                    $('#totalLabels'+rowKey).val(data.statics[0].totalLabels );
                    $('#label_for_orders'+rowKey).val(data.statics[0].totalLabels );
                    //alert(data.statics[0].totalLabels);

                    //$('.updateMe'+key).trigger('click');

                    //return true;
                },
                error: function (jqXHR, exception) {
                    alert('Error While Requesting....');
                }
            });


        }

    });
    return true;
}



function confirm_update_quotation_artwork() {
    var rowKey = $('#rowKey').val();

    var arrNumber = new Array();
    var artwork_details_data = '';
    var cartid = $('#cartid').val();
    var product_id = $('#product_id').val();
    var orderNumber = $('#orderNumber').val();
    //var customerId = $('#customerId').val();
    var customerId = $('#custId').val();
    var manfactureId = $('#manfactureId').val();
    var serialNumber = $('#serialNumber').val();
    var checkoutArtwork = $('#checkoutArtwork').val();
    var page = $('#page').val();
    var condition = $('#condition').val();
    var brand = $('#brand').val();




    var labels = 0;
    if($('.key_class').length > 0){
        var is_rollss = brand.search("Roll");
        $('.key_class').each(function(){
            if($(this).val()){
                var keys = $(this).val();
                //labels += parseInt($('#at_label'+keys).val());
                if(is_rollss > -1){
                    labels += parseInt($('#at_label'+keys).val());
                }else{
                    labels += parseInt($('#at_label'+keys).text());
                }
            }
        });
        //alert(labels);
        if(labels < 100){
            swal("","Minimum 100 labels are allowed",
                {
                    buttons: {
                        cancel: "OK",
                    },
                    icon: "warning",
                    closeOnClickOutside: false,
                }
            );
            return false;
        }
    }



    var new_qty = 0;
    $('.key_class').each(function(){

        if($(this).val()){
            var keys = $(this).val();
            //alert(keys);
            var artworkID = $('#artwork_id'+keys).val();
            var rolls_qty = $('#at_roll'+keys).val();
            //var labels = $('#at_label'+keys).val();
            var labels = 0;
            if(is_rollss > -1){
                labels += parseInt($('#at_label'+keys).val());
            }else{
                labels += parseInt($('#at_label'+keys).text());
            }
            var name = $('#at_name'+keys).val();
            var artworkimage = $('#artworkimage'+keys).val();






            if(keys >= 50000){
                var uploadfile = $('#artworkimage' + keys)[0].files[0];
            }else{
                var uploadfile = '';
            }

            var form_data = new FormData();
            form_data.append("file", uploadfile);
            form_data.append("cartid", cartid);
            form_data.append("artworkID", artworkID);
            form_data.append("qty", rolls_qty);
            form_data.append("labels", labels);
            form_data.append("name", name);
            form_data.append("artworkimage", artworkimage);
            form_data.append("orderNumber", orderNumber);
            form_data.append("serialNumber", serialNumber);
            form_data.append("ProductID", product_id);
            form_data.append("manfactureId", manfactureId);
            form_data.append("customerId", customerId);
            form_data.append("status", 'confirm');
            //form_data.append("source", 'admin');
            form_data.append("type", 'new');
            form_data.append("checkoutArtwork", checkoutArtwork);
            form_data.append("condition", condition);




            /*$("#aa_loader").css('z-index','90000');
            $('#aa_loader').show();*/


            $.ajax({
                type: "post",
                url: mainUrl + "order_quotation/order/artwork_details_data_quotation_edit",
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                enctype: 'multipart/form-data',
                data: form_data,
                dataType: 'json',
                success: function (data) {
                    //alert('new qty = '+data.statics[0].totalQuantity);
                    var trval = $('#checkouttr').val();
                    $('#checkout_qty' + trval).val(data.statics[0].totalQuantity);
                    $('#checkout_unit_price' + trval).text(data.price / data.statics[0].totalQuantity);
                    $('#design'+rowKey).val(data.statics[0].count);
                    $('#arwtork_qty'+rowKey).val(data.statics[0].totalQuantity);
                    $('#qty'+rowKey).val(data.statics[0].totalQuantity);

                    //$('#myqty'+serialNumber).val(data.statics[0].totalQuantity);
                    $('#labels'+rowKey).text(data.statics[0].totalLabels );
                    $('#totalLabels'+rowKey).val(data.statics[0].totalLabels );
                    $('#label_for_orders'+rowKey).val(data.statics[0].totalLabels );
                    //alert(data.statics[0].totalLabels);

                    //$('.updateMe'+key).trigger('click');

                    //return true;
                },
                error: function (jqXHR, exception) {
                    alert('Error While Requesting....');
                }
            });


        }

    });
    return true;
}


function updatePriceLineForSheet(id, cartId, printType, brand, manufacture, productId) {

    var qty = $('#checkout_qty' + id).val();

    var type = $('#print' + id).val();


    if (qty < getMinQuantiy(brand)) {

        qty = getMinQuantiy(brand);

        $('#checkout_qty' + id).val(qty);

    }

    else if (qty > getMaxQuantiy(brand)) {

        qty = getMaxQuantiy(brand);

        $('#checkout_qty' + id).val(qty);

    }


    $.ajax({

        type: "get",

        url: mainUrl + "order_quotation/order/changeLineType",

        cache: false,

        data: {

            'qty': qty,

            'cartId': cartId,

            'printing': type,

            'manufactureId': manufacture,

            'brand': brand,

            'ProductID': productId,

            'productBrand': brand,


        },

        dataType: 'json',

        success: function (data) {


            $('#artwork_section' + id).hide();

            $("#update" + id).attr("onclick", "updatePrice(" + id + "," + cartId + ",'N'," + brand + "," + manufacture + ")");

            $('#checkout_qty' + id).removeAttr('readonly');

            $('#basketPrice').text('View Basket - £ ' + data.cartPrice[0].price);

            $('#sub_total').text('£' + data.cartPrice[0].price);

            $('#grand_total').text('£' + data.cartPrice[0].price);

            $('#checkout_price' + id).text('£' + data.price);

            $('#checkout_unit_price' + id).text(data.price / qty);


        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


function updateIntegrated(id, cartId, printType, brand, manufacture, productId) {

    var qty = $('#checkout_qty' + id).val();

    var type = $('#print' + id).val();


    $.ajax({

        type: "get",

        url: mainUrl + "order_quotation/order/updateIntegrated",

        cache: false,

        data: {

            'qty': qty,

            'cartId': cartId,

            'printing': type,

            'manufactureId': manufacture,

            'brand': brand,

            'ProductID': productId,

            'productBrand': brand,


        },

        dataType: 'json',

        success: function (data) {


            $('#artwork_section' + id).hide();

            $("#update" + id).attr("onclick", "updatePrice(" + id + "," + cartId + ",'N'," + brand + "," + manufacture + ")");

            $('#checkout_qty' + id).removeAttr('readonly');

            $('#basketPrice').text('View Basket - £ ' + data.cartPrice[0].price);

            $('#sub_total').text('£' + data.cartPrice[0].price);

            $('#grand_total').text('£' + data.cartPrice[0].price);

            $('#checkout_price' + id).text('£' + data.price);

            $('#checkout_unit_price' + id).text(data.price / qty);


        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


function changeLineType(event, id, cartId, printType, brand, manufacture, productId) {

    // var qty = $('#checkout_qty' + id).val();
    //
     var type = $(event).val();
    //
    // $('#print' + id).val(type);
    //
    //
    // if (type == 'Y' && brand == 'Roll Labels') {
    //
    //     updateLinePrice(id, cartId, printType, brand, manufacture, productId);
    //
    // }
    //
    // if (type == 'N' && brand == 'Roll Labels') {
    //
    //     updateLinePrice(id, cartId, printType, brand, manufacture, productId);
    //
    // }
    //
    // if (type == 'Y' && brand != 'Roll Labels') {
    //
    //     updateLinePrice(id, cartId, printType, brand, manufacture, productId);
    //
    // }
    //
    //
    // if (type == 'N' && brand != 'Roll Labels') {
    //
    //     updatePriceLineForSheet(id, cartId, printType, brand, manufacture, productId);
    //
    // }
    //
    // if (brand == 'Integrated Labels') {
    //
    //     updateIntegrated(id, cartId, printType, brand, manufacture, productId);
    //
    // }
    $.ajax({

        type: "get",

        url: mainUrl + "order_quotation/order/changeLine",

        cache: false,

        data: {



            'cartId': cartId,

            'printing': type,




        },

        dataType: 'json',

        success: function (data) {


            checkout();


        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });

}


// function changeLineCategory(id, cartId, printType, brand, manufacture, productId) {
//
//
//     var type = $('#print' + id).val();
//
//
//     if (type == 'Y' && brand == 'Roll Labels') {
//
//         updateLinePrice(id, cartId, printType, brand, manufacture, productId);
//
//     }
//
//     if (type == 'N' && brand == 'Roll Labels') {
//
//         updateLinePrice(id, cartId, printType, brand, manufacture, productId);
//
//     }
//
//     if (type == 'Y' && brand != 'Roll Labels') {
//
//         updateLinePrice(id, cartId, printType, brand, manufacture, productId);
//
//     }
//
//
//     if (brand == 'Integrated Labels') {
//
//         updateIntegrated(id, cartId, printType, brand, manufacture, productId);
//
//     }
//
// }

function saveQuotation() {
	var customs_pro = $('#id_custom').val();
    
	if(customs_pro=='no'){
 
		swal(
			"Would you like to send this customer!",
			{
				buttons: {
					cancel: "No",
					catch: {
						text: "Yes",
						value: "catch",
					},
				},
				icon: "success",
				closeOnClickOutside: false,
			}
		).then((value) => {
//alert(value);
			switch (value) {
       
					
       
				case "catch":
					$('#basketPrice').hide();
					makeQuotation(value);
					makeQuotationAndSendMail(value);
					break;
				default:
					$('#basketPrice').hide();
					makeQuotation('cus_nos');
          	       
			}
		});
		}else{
			$('#basketPrice').hide();
			makeQuotation('cus_nos');
		}	
}

var ds='0'; 
function makeQuotationAndSendMail(chks){
	
  var QuotationNumber = $('#l_q_n').val();
  
  $.ajax({
    url: mainUrl + "order_quotation/order/sendEmail",
    data: {
      quotationNumber: QuotationNumber
    },
    cache: false,
    type: 'POST',
    //dataType: 'json',
    async:false,
    success: function (data) {
          
      //alert('another success');
      if(chks=="catch"){
        //alert('another in');
        window.location.href = mainUrl + "order_quotation/order/quotationconfirmaion/"+QuotationNumber
      }
    },
    error: function (data) {
      alert('Error While Requesting...');
    }
  });
}

function makeQuotation(chks){
  var fieldValuePairs = $('#checkout_form').serializeArray();
  var form_data = new FormData();
  var vl = '';
  $.each(fieldValuePairs, function (index, fieldValuePair) {
    form_data.append(fieldValuePair.name, fieldValuePair.value);
  });
  console.log(form_data);
	
  $.ajax({
    url: mainUrl + "order_quotation/order/saveQuotation",
    async:false,
    data: form_data,
    cache: false,
    processData: false,
    contentType: false,
    type: 'POST', 
    dataType: 'json',
    success: function (data) {
      console.log(data);
      if (data.response == 'true') {
                  
      }
					
      $('#l_q_n').val('');
      ds = 		$('#l_q_n').val(data.q_n);
      
      //alert('success');
      if(chks!="catch"){
        //alert('in');
        window.location.href = mainUrl + "order_quotation/order/quotationconfirmaion/"+data.q_n
      }
					
    },
    error: function (jqXHR, exception,data) {
      
      if (data.response != 'true') {
        alert('Error While Requesting...');
      }
    }
  });
}
function saveOrder() {
    var term  = $('#agree_term').val();
    if(term ==null || term == ""){
        show_faded_alert('agree_term','Please Agree With Term and Condition');
        return false;
    }

    var fieldValuePairs = $('#checkout_form').serializeArray();
    var form_data = new FormData();


    $.each(fieldValuePairs, function (index, fieldValuePair) {
        form_data.append(fieldValuePair.name, fieldValuePair.value);
    });
    console.log(form_data);
    $.ajax({

        url: mainUrl + "order_quotation/order/saveOrder",

        data: form_data,
        cache: false,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.response == 'true') {

                $('#ord_qu_Crf_tab').removeClass('disbaledd');
                activeTab('ord_qu_Crf_link');
                $('#customer_orders').hide();
                $('#format_page').hide();
                $('#material_page').hide();
                $('#products_list').hide();
                $('#confirm_my_order').show();

                $('#confirm_my_order').html(data.html);

            }
        },

        error: function (jqXHR, exception) {
          if (jqXHR.status === 500) {
            alert('No Invoice..');
          } else {
            alert('Error While Requesting...');
          }
        }
    });
}

function setUpCharge(condition = null) {
    $.ajax({
        type: "get",
        url: mainUrl + "order_quotation/order/setUpCharge",
        cache: false,
        data: {},
        dataType: 'json',
        async:false,
        success: function (data) {
            
            resetFields('ds');

            $('#customdiepopup').modal('show');
            $('#last_cart_id').val(data.cartId);

            if(condition == 'cancel'){
                //
            }
            $('#update_cart').hide();
            
            $('#cancal_cart').show();
            $('#add_cart').show();
            //$('#cancal_cart').show();
            
            
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
            } else {
                alert('Error While Requesting...');

            }

        }

    });
}


$(document).on('change', '.cust_die', function () {
    var format = $('#die_format').val();
    var shape = $('#die_shape').val();
    var width = $('#die_width').val();
    var height = $('#die_height').val();
    var perforate = $('#die_perforate').val();
    var ldeg = $('#die_ldeg').val();
    var cornerradious = $('#die_cornerradius').val();
    var across = $('#die_across').val();
    var around = $('#die_around').val();
    var labels = $('#die_no_of_labels').val();
     $('#die_no_of_labels').val(across*around);

    var cartId = $('#last_cart_id').val();
    var QID = $('#last_Qid').val();
    var note =   $('#die_notee').val();
    var pageName = $('#mypageName').val();

    if (requestIsValidate($(this).attr('use'))) {
        $.ajax({
            type: "get",
            url: mainUrl + "order_quotation/order/insertFlexDieRecord",
            cache: false,
            data: {
                format: format,
                shape: shape,
                width: width,
                height: height,
                perforate: perforate,
                ldeg: ldeg,
                cornerradious: cornerradious,
                across: across,
                around: around,
                labels: across *around,
                cartId: cartId,
                note: note,
                pageName:pageName,
                QID:QID
            },
            dataType: 'json',
            success: function (data) {

            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }

});

function resetFields(condition) {


    if(condition == 'die_format'){
        $('#die_shape').val('');
    }

    $('#die_width').val('');
    $('#die_height').val('');
    $('#die_perforate').val('');
    $('#die_ldeg').val('');
    $('#die_cornerradius').val('');
    $('#die_across').val('');
    $('#die_around').val('');
    $('#die_no_of_labels').val('');
    $('#die_notee').val('');

}


function requestIsValidate(condition) {
    var format = $('#die_format').val();
    var shape = $('#die_shape').val();
    var width = $('#die_width').val();
    var height = $('#die_height').val();
    var perforate = $('#die_perforate').val();
    var ldeg = $('#die_ldeg').val();
    var cornerradious = $('#die_cornerradius').val();
    var across = $('#die_across').val();
    var around = $('#die_around').val();

    var note = $('#die_note').val();

    if(condition == 'die_format' || condition == 'die_shape'){

        resetFields(condition);
    }

    if (shape == 'Circle' || shape == 'Square') {
        $('#die_height').val('');
        $('#die_height').hide();
		$('#die_height_lb').hide();
    }
    else {
		$('#die_height_lb').show();
        $('#die_height').show();
    }

    if (shape == 'Circle' || shape == 'Oval') {
        $('#die_cornerradius').val('');
        $('#die_cornerradius').hide();
		$('#die_cornerradius_lb').hide();
    }
    else {
		$('#die_cornerradius_lb').show();
        $('#die_cornerradius').show();
    }

    if (width && condition == 'die_width') {
        $('#die_across').val(acfun());

        if (shape == 'Circle' || shape == 'Square') {
            $('#die_around').val(arfun());
        }

        if (format == 'Roll') {
            $('#die_ldeg').val(width);
        }

        $('#die_no_of_labels').val(arfun() * acfun());
    }

    if (height && condition == 'die_height') {
        $('#die_around').val(arfun());
        $('#die_no_of_labels').val(arfun() * acfun());
    }

    if (format == 'Roll') {
		$('#die_ldeg_lb').show();
        $('#die_ldeg').show();
    } else {
        $('#die_ldeg').val('');
        $('#die_ldeg').hide();
		$('#die_ldeg_lb').hide();
    }

    if (condition == 'die_across' ||  condition == 'die_around') {

        if (across > acfun()) {
            alert('you can not increase more then ' + acfun());
            $('#die_across').val(acfun());
            $('#die_no_of_labels').val(arfun() * acfun());
        }

        if (around > arfun()) {
            alert('you can not increase more then ' + arfun());
            $('#die_around').val(arfun());
            $('#die_no_of_labels').val(arfun() * acfun());
        }
    }

    if(condition =="die_cornerradius"){
      if(cornerradious < 0){
            var num = parseFloat(0);
            var cleanNum = num.toFixed(2);
            $('#die_cornerradius').val(cleanNum);

        }else{
            var num = parseFloat(cornerradious);
            var cleanNum = num.toFixed(2);
            $('#die_cornerradius').val(cleanNum);
        }
    }
    return true;

}


$(document).on("click", "#vat_validator", function(e) {
    var vatnumber = $('#vatnumber').val();
    var country = $('#dcountry').val();
    var userExist = $('#isUserExist').val();

    if(userExist) {
        var email = $('#email_valid').val();
    }else{
            var email = $('#email').val();
        }



    if(vatnumber.length > 0){
        $.ajax({
            url: mainUrl+'cart/cart/validate_vat',
            type:"POST",
            async:"false",
            data: {  country: country,vatNumber: vatnumber,email:email},
            dataType: "html",
            success: function(data){
                data = $.parseJSON(data);
                if(data.status=='valid'){
                    VATNumber = 'valid';
                    $('#vat_name').html(data.vatmessage);
                    $('#ajax_order_summary').html(data.orderSummary);
                    swal("Verified",data.vatmessage,"success");
                }else{
                    $('#vat_name').html('');
                    swal("","please enter a valid VAT number","warning");
                    VATNumber = 'invalid';
                }
            }
        });
    }else{
        VATNumber = 'invalid';
        $('#vat_name').html('');
        swal("","please enter a valid VAT number","warning");
    }
});
function acfun() {

    var format = $('#die_format').val();
    var width = parseInt($('#die_width').val(), 10);

    var shapeVal = "";

    if (format == "A4") {
        shapeVal = 208;
    } else if (format == "A3") {
        shapeVal = 418;
    } else if (format == "SRA3") {
        shapeVal = 448;
    }
    else if (format == "A5") {
        shapeVal = 146;
    }
    else if (format == "Roll") {
        shapeVal = 250;
    }

    return parseInt((shapeVal / width), 10);

}

function arfun() {

    var format = $('#die_format').val();
    var height = parseInt(($('#die_height').val() == '' ? $('#die_width').val() : $('#die_height').val()), 10);

    var shaperound = "";

    if (format == "A4") {
        shaperound = 295;
    }
    else if (format == "SRA3") {
        shaperound = 318;
    }
    else if (format == "A3") {
        shaperound = 295;
    } else if (format == "A5") {
        shaperound = 208;
    }
    else if (format == "Roll") {
        shaperound = 300;
    }
    return parseInt((shaperound / height), 10);
}

function customDieValidation() {
    var format = $('#die_format').val();
    var shape = $('#die_shape').val();
    var width = $('#die_width').val();
    var height = $('#die_height').val();
    var perforate = $('#die_perforate').val();
    var ldeg = $('#die_ldeg').val();
    var cornerradious = $('#die_cornerradius').val();
    var across = $('#die_across').val();
    var around = $('#die_around').val();
    var labels = $('#die_no_of_labels').val();
    var cartId = $('#last_cart_id').val();
    var note = $('#die_note').val();

    if(format =="" || format == null){
        customDieSweetAlert('Please Select Format ...');
        return false;
    }

    if(shape =="" || shape == null){
        customDieSweetAlert('Please Select Shape ...');
        return false;
    }

    if(width =="" || width == null){
        customDieSweetAlert('Please Enter Width ...');
        return false;
    }

    if(shape != 'Circle' && shape != 'Square'){

        if(height =="" || height == null){
            customDieSweetAlert('Please Enter Height ...');
            return false;
        }
    }

    if(shape != 'Circle'  && shape != 'Oval') {
        if (cornerradious == "" || cornerradious == null) {
            customDieSweetAlert('Please Enter cornerradius ...');
            return false;
        }
    }

    if(perforate =="" || perforate == null){
        customDieSweetAlert('Please Select perforate ...');
        return false;
    }

    if(format == 'Roll'){
        if(ldeg =="" || ldeg == null){
            customDieSweetAlert('Leading Edge is Empty ...');
            return false;
        }
    }

    if(across =="" ||  across == null){
        customDieSweetAlert('Please fill the across Field..');
        return false;
    }
    if(around =="" ||  around == null){
        customDieSweetAlert('Please fill the around Field..');
        return false;
    }

    if(labels =="" ||  labels == null){
        customDieSweetAlert('labels are empaty');
        return false;
    }

    return true;

}

function customDieSweetAlert(message) {
    swal({
        title: "Validation Error",
        text: message,
        icon: "warning",
        dangerMode: true,
    })

}

function updateCustomDiePrice() {
    getCustomDiePrice('update');
}

function cancaelCartValue() {
    swal(
        "Are you Sure You Want To Cancel This Die",
        {
            buttons: {
                catch: {
                    text: "Ok",
                    value: "catch",
               },
            },
            icon: "warning",
            closeOnClickOutside: false,
        }
    ).then((value) => {

        switch (value) {


            case "catch":

              var cartId = $('#last_cart_id').val();

                $.ajax({
                    type: "post",
                    url: mainUrl + "order_quotation/quotation/cancelCart",
                    cache: false,
                    data: {cartId:cartId},
                    dataType: 'json',
                    async:false,
                    success: function (data) {
                        $('#customdiepopup').modal('hide');
                        //$('#od_qt_link').attr('onclick','showcartPage()');
                        //checkout();

                        //window.location='https://www.aalabels.com/salespanel/index.php/orderQuotationPage';
                        window.location=mainUrl+'orderQuotationPage';

                    },
                    error: function (jqXHR, exception) {
                        if (jqXHR.status === 500) {
                            alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                        } else {
                            alert('Error While Requesting...');
                        }
                    }
                });

                break;


        }

    });
}



function customhide() {
	
	 $('#customdiepopup').modal('hide');
   
}

function getCustomDiePrice(update=null) {

    var format = $('#die_format').val();
    var shape = $('#die_shape').val();
    var width = $('#die_width').val();
    var height = $('#die_height').val();
    var perforate = $('#die_perforate').val();
    var ldeg = $('#die_ldeg').val();
    var cornerradious = $('#die_cornerradius').val();
    var across = $('#die_across').val();
    var around = $('#die_around').val();
    var labels = $('#die_no_of_labels').val();
    var cartId = $('#last_cart_id').val();
    var condition = $('#condition').val();
    var note = $('#die_note').val();
    var key = $('#key').val();

    var quo = $('#quo').val();
    var serlno = $('#serlno').val();

    if(customDieValidation()){
        $.ajax({
            type: "post",
            url: mainUrl + "order_quotation/quotation/calculatePrice",
            cache: false,
            data: {note:note,'serlno':serlno,'quo':quo,'condition':condition,'across':across,'around':around,'formats':format,'shapes':shape,'widths':width,'heights':height,'labelss':labels,'sizes':width,'ID':cartId},
            dataType: 'json',
            success: function (data) {
                if(data.response == 'yes'){
                    if(quo == 'quo'){
                       window.location.reload();
                    }
                    else if(update === 'update'){
                        if(serlno !=null && serlno !=""){
                           // window.location.reload();
                        }else{
                            $('#line'+key).remove();
                        }

                    }
                    loadMyOwnCartPage();

                   // appendCustomDieRow(cartId,shape,format,width,height,perforate,ldeg,cornerradious,across,across,labels,data);
                    cuscount = cuscount+1;
                    resetCustomDieFields();
                    $('#customdiepopup').modal('hide');

                    //window.location='https://www.aacartons.com/aalabels/salespanel/index.php/orderQuotationPage';
                }
                else{
                    swal(
                        data.data.message,
                        {

                            buttons: {

                                cancel: "ok",
                             },

                            icon: "warning",

                            closeOnClickOutside: false,

                        });
                }
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }
}
function resetCustomDieFields() {


    $('#die_format').val('');
    $('#die_shape').val('');
    $('#die_width').val('');
    $('#die_height').val('');
    $('#die_perforate').val('');
    $('#die_ldeg').val('');
    $('#die_cornerradius').val('');
    $('#die_across').val('');
    $('#die_around').val('');
    $('#die_no_of_labels').val('');

}
function  appendCustomDieRow(cartId,shape,format,width,height,perforate,ldeg,cornerradious,across,around,labels,data) {
    $('#main_checkout_trs').append(
        ' <tr id="line'+cuscount+'">' +
        '<td class="text-center"><img src="../assets/images/product1.jpg" width="38" height="54" alt="Product Image"></td>' +
        '<td class="text-center">SCO1 </td>' +
        '<td><b>Shape:</b>' +shape+'| <b>Format:</b>' +format+'| <b>Size:</b>' +width+'mm * '+(height ==""?width:height)+'mm| <b>No.labels/Die:</b>' +labels+'| <b>Across:</b>' +across+'| <b>Around:</b>' +around+'| <b>Corner radius:</b>' +cornerradious+'| <b>Perforation:</b>' +perforate+'|' +
        '<br />'+
        '<br />'+
        '<button type="button" onclick="editCustomDie('+cuscount+','+cartId+')">Edit Custom Die</button>'+
        '<button id="applydis'+cuscount+'" type="button" onclick="changeDisVal('+cuscount+','+cartId+')">Check Discount</button>'+
        '<button id="deletedis'+cuscount+'" type="button" style="display: none" onclick="deleteDisVal('+cuscount+','+cartId+')">Delete Discount</button>'+
        '</td>' +
        '<td id="checkout_unit_price'+cuscount+'">£'+data.data.price.toFixed(2)+'</td>' +
        '<td><input type="text" id="1" value="1" class="form-control input-number text-center allownumeric" name="quant1"></td>' +
        '<td id="checkout_price'+cuscount+'">£'+data.data.price.toFixed(2)+'</td>' +
        '<td><span class="btn-span">' +
        '<button onclick="deleteLineFromCart('+cuscount+','+cartId+')" class="btn btn-default btn-number delete-line-btn fa-2x m-r-6" type="button"><i class="mdi mdi-delete "></i></button>' +
        '</span></td>' +
        '</tr>'
    );
    return true;
}


function changeDisVal(id,cartid,quo=null,quotationNum=null) {

    $.ajax({
        type: "get",
        url: mainUrl+"order_quotation/quotation/getTempDisVal",
        cache: false,
        data:{'id':cartid,quo:quo},
        dataType: 'json',
        success: function(data) {
            var val = (data[0].temp_dis == null || data[0].temp_dis == "" ? 0 : data[0].temp_dis);

            swal(
                'Click OK to apply '+val+'% discount',
                {

                    buttons: {

                        cancel: "No",

                        catch: {

                            text: "ok",

                            value: "catch",

                        },


                    },

                    icon: "warning",

                    closeOnClickOutside: false,

                }
            ).then((value) => {

                switch (value) {


                    case "catch":

                        applyDiscount(id,cartid,quo,quotationNum)
                        checkout();
                        break;


                }

            });


        },
        error: function(){
            alert('Error while request..');
        }
    });

}

function applyDiscount(id,cartid,quo=null,quotationNum=null) {
    $.ajax({
        type: "get",
        url: mainUrl+"order_quotation/quotation/applyDiscount",
        cache: false,
        data:{'id':cartid,quo:quo,quotationNumber:quotationNum},
        dataType: 'json',
        success: function(data){

            if(quo == 'quo'){
                window.location.href = mainUrl+'order_quotation/quotation/getQuotationDetail/'+data.number;
            }else{
                $('#checkout_unit_price'+id).text(data.price);
                $('#checkout_price'+id).text(data.price);
                $('#basketPrice').text('View Basket - £ ' + data.cartPrice[0].price);
                $('#sub_total').text('£' + data.cartPrice[0].price);
                $('#grand_total').text('£' + data.cartPrice[0].price);
                $('#applydis'+id).hide();
                $('#deletedis'+id).show();
            }

        },
        error: function(){
            alert('Error while request..');
        }
    });
}

function deleteDisVal(id,val,quo=null,quotationNumber=null){
    $.ajax({
        type: "post",
        url: mainUrl+"order_quotation/quotation/deleteDiscount/",
        data:{id:val,quo:quo,quotationNumber:quotationNumber},
        dataType: 'json',
        success: function(data){
            if(quo == 'quo'){
                window.location.href = mainUrl+'order_quotation/quotation/getQuotationDetail/'+data.number;
            }else{
                $('#checkout_unit_price'+id).text(data.price);
                $('#checkout_price'+id).text(data.price);
                $('#basketPrice').text('View Basket - £ ' + data.cartPrice[0].price);
                $('#sub_total').text('£' + data.cartPrice[0].price);
                $('#grand_total').text('£' + data.cartPrice[0].price);
                $('#applydis'+id).show();
                $('#deletedis'+id).hide();
                checkout();
            }

        },
        error: function(){
            alert('Error while request...');
        }

    });
}

function editCustomDie(id,cartID,quo=null) {
    $.ajax({
        type: "get",
        url: mainUrl+"order_quotation/order/getCustomDieRecord",
        data:{id:cartID,quo:quo},
        dataType: 'json',
        success: function(data){

             $('#die_format').val(data.data.format);
             $('#die_shape').val(data.data.shape);
             $('#die_width').val(data.data.width);

             if(data.data.shape != 'Circle' && data.data.shape != 'Square'){
                 $('#die_height').val(data.data.height);
                 $('#die_height').show();
             }else{
                 $('#die_height').val(data.data.height);
                 $('#die_height').hide();
             }

            $('#die_perforate').val(data.data.perforation);

            if(data.data.shape != 'Circle'){
                $('#die_cornerradius').val(data.data.cornerradius);
                $('#die_cornerradius').show();
            }else{
                $('#die_cornerradius').val('');
                $('#die_cornerradius').hide();
            }
             if(data.data.format == 'Roll'){
                 $('#die_ldeg').val(data.data.width);
             }else{
                 $('#die_ldeg').hide();
             }
             $('#die_across').val(data.data.across);
             $('#die_around').val(data.data.around);
             $('#die_no_of_labels').val(data.data.labels);
             $('#key').val(id);
             $('#last_cart_id').val(data.data.CartID);
             $('#last_Qid').val(data.data.QID);
             $('#condition').val('true');
             $('#die_notee').val(data.data.notes);

            $('#add_cart').hide();
            $('#cancal_cart').show();
            $('#update_cart').show();

            $('#customdiepopup').modal('show');
        },
        error: function(){
            alert('Error while request...');
        }

    });
}

function getMaterialCode(format) {
    $.ajax({
        type: "get",
        url: mainUrl+"order_quotation/order/getMaterialCode",
        data:{format:format},
        dataType: 'json',
        success: function(data){
            var optn = "";
            if(data.response == 'yes'){
                $.each(data.data, function( index, value ) {
                  optn += '<option value="'+value.material+'">'+value.material+' </option>'
                });

               $('#add_materials').append(optn);
            }

        },
        error: function(){
            alert('Error while request...');
        }

    });
}

function selectedMaterial(event,flexId,maintrId) {
    var material = $(event).val();
    var pageName = $('#mypageName').val();
    $.ajax({
        type: "post",
        url: mainUrl+"order_quotation/order/addMaterial",
        data:{material:material,tempid:flexId},
        dataType: 'json',
        success: function(data){
            if(pageName == 'quotation'){
                window.location.reload();
            }else{
                loadMyOwnCartPage();
            }


        },
        error: function(){
            alert('Error while request...');
        }

    });

}

function loadMyOwnCartPage() {

    $.ajax({
        type: "post",
        url: mainUrl+"cart/cart/checkoutFullPage",
        data:{},
        dataType: 'json',
        success: function(data){

            $('#products_list').empty();
            $('#products_list').html(data.html);
					  $('#aa_loader').hide();
        },
        error: function(){
            alert('Error while request...');
        }

    });

}

function changelabeltype(id,event,refresh=null){

      var type = $(event).val();
    $.ajax({
        type: "post",
        url: mainUrl+"cart/cart/changelabeltype",
        cache: false,
        data:{'id':id,'type':type},
        dataType: 'json',
        success: function(data){

            $('#products_list').empty();
            $('#products_list').html(data.html);
            var pageName = $('#mypageName').val();


            if(pageName !=null){
                window.location.reload();
            }else{
                if(refresh === 'refresh' ){

                    checkout();
                }
            }


        },
        error: function(){
            alert('Error while request..');
        }

    });

}

function showDetail(val) {
    $('#assco'+val).show();
    $('#mat_hide_dtl').show();
    $('#mat_show_dtl').hide();
}
function hideDetail(val) {
    $('#assco'+val).hide();
    $('#mat_hide_dtl').hide();
    $('#mat_show_dtl').show();
}

function updateMaterialPrice(mainTrId,flexId,matId,format) {

   
	var quantity = $('#matqty'+matId).val();
	var mattype = $('#prnt_dropdown_'+matId).val();
	var design = $('#designmat'+matId).val();
	var lables = $('#labelsmat'+matId).val();
	var core = $('#core_'+matId).val();
	var wound = $('#wound_'+matId).val();
	var plain_print = $('#mat_print'+matId).val();
	var finish = $('#finishdropdown_'+matId).val();
	var pageName = $('#mypageName').val();
	
	if(validationForCustomDie(format,quantity,matId,plain_print,mattype,design,core,wound,lables,finish)){
		$('#aa_loader').show();
		$.ajax({
			type: "post",
			url: mainUrl+"cart/cart/getMaterialPrice",
			cache: false,
			data:{finish:finish,'quantity':quantity,'type':mattype,format:format,flexdieid:flexId,matId:matId,design:design,core:core,wound:wound,lables:lables,plain_print:plain_print},
			dataType: 'json',
			success: function(data){
				$('#aa_loader').hide();
				if(data.response == 'yes'){
					if(pageName == 'quotation'){
						window.location.reload();
					}else{
						$('#products_list').empty();
						$('#products_list').html(data.html);
					}

				}

			},
			error: function(){
				alert('Error while request..');
			}

		});
	}
}

$('.qty_cus_die').change(function () {

	var ProductBrand = $('[data-ProductBrand=' + dataNo + ']').attr('value');
	var qty = $(this).val();
	var batch = $('[data-batch=' + dataNo + ']').attr('value');
	var ManufactureID = $('[data-ManufactureID=' + dataNo + ']').attr('value');
	var Printing = $('[data-Printing=' + dataNo + ']').attr('value');
	var dataNo = $(this).attr('data-qty');
	
	if (qty < 1) {
		$(this).val(1);
	}
	checkMinQty(ProductBrand, qty, batch, ManufactureID, Printing, dataNo);
});

function validationForCustomDie(format,qty,matid,plain_print,mattype,design,core,wound,lables,finish) {

	if(format !='Roll'){

		if(plain_print == 'plain'){

			if( (format == 'A4' || format == 'A5') && (qty <25 || qty >50000)){

				if(qty <25){
					
					show_faded_alert('matqty'+matid,'Minimum Sheet Quantity must be 25');
					$('#matqty'+matid).val(25);
				}else if(qty >50000){

					show_faded_alert('matqty'+matid,'Maximum Sheet Quantity must be 50000');
					$('#matqty'+matid).val(50000);
				}
				return false;
			}

			if((format === 'A3' || format === 'SRA3') && (qty <100 || qty >50000)){
				if(qty <100){
					show_faded_alert('matqty'+matid,'Enter Quantity must 100');
					$('#matqty'+matid).val(100);
				}else if(qty >50000){
					show_faded_alert('matqty'+matid,'Maximum Sheet Quantity must be 50000');
					$('#matqty'+matid).val(50000);
				}
				return false;
			}
			return true;
		}
		else{
			if(mattype == "" || mattype == null){
				show_faded_alert('prnt_dropdown_'+matid,'Please Select Printing');
				return false;
			}
			if(design == 0 || design == "" || design == null){
				show_faded_alert('designmat'+matid,'Please Enter Design');
				return false;
			}
			if(qty ==0 || qty =="" || qty == null){
				
				show_faded_alert('matqty'+matid,'Please Enter Quantity');
				$('#matqty'+matid).val(0);
				return false
			}
			return true;
		}

	}else{

		if(plain_print == 'plain'){
			if(core == 0 || core == "" || core == null){
				show_faded_alert('core_'+matid,'Please Select Core Size');
				return false;
			}
			if(wound == 0 || wound == "" || wound == null){
				show_faded_alert('wound_'+matid,'Please Select Wound');
				return false;
			}
			
			
			if(lables == 0 || lables == "" || lables == null){
				show_faded_alert('labelsmat'+matid,'Please Enter Labels');
				return false;
			}

			if(qty ==0 || qty =="" || qty == null){
				
				show_faded_alert('matqty'+matid,'Please Enter Quantity');
				$('#matqty'+matid).val(0);
				return false
			}
			return true;
		}else{
			if(mattype == "" || mattype == null){
				show_faded_alert('prnt_dropdown_'+matid,'Please Select Printing');
				return false;
			}
			if(finish == 0 || finish == "" || finish == null){
				show_faded_alert('finishdropdown_'+matid,'Please Select Finish');
				return false;
			}if(core == 0 || core == "" || core == null){
				show_faded_alert('core_'+matid,'Please Select Core Size');
				return false;
			}
			if(wound == 0 || wound == "" || wound == null){
				show_faded_alert('wound_'+matid,'Please Select Wound');
				return false;
			}
			if(lables == 0 || lables == "" || lables == null){
				show_faded_alert('labelsmat'+matid,'Please Enter Labels');
				return false;
			}
			if(design == 0 || design == "" || design == null){
				show_faded_alert('designmat'+matid,'Please Enter Design');
				return false;
			}
			if(qty ==0 || qty =="" || qty == null){
				
				show_faded_alert('matqty'+matid,'Please Enter Quantity');
				$('#matqty'+matid).val(0);
				return false
			}
			return true;
		}

    }



}



var timer = '';
function show_faded_alert(id, text){

    $('#'+id).attr('data-content','');
    $('#'+id).popover('hide');
    $('#'+id).popover({'placement':'top'});
    $('#'+id).attr('data-content',text);
    $('#'+id).popover('show');
    clearTimeout(timer);
    timer = setTimeout(function(){
        //$('#'+id).attr('data-content','');
        //$('#'+id).popover('hide');
        
        $('.popover').attr('data-content','');
        $('.popover').popover('hide');
    }, 5000);
}


// AA21 STARTS
$(document).on("change", "input[name=delivery_option]", function(e) {
    
    var deliveryid = $("input:radio.delivery-group:checked").val();
    var courier = $("input:radio.courier:checked").val();
    if(deliveryid){
        $.ajax({
            url: mainUrl+'cart/cart/update_delevery',
            type:"POST",
            dataType: "html",
            data: {deliveryid: deliveryid, courier: courier},
            success: function(data1){

                if(!data1 == ''){
                    data1 = $.parseJSON(data1);
                    if(data1.response=='yes'){
                        $('#ajax_delivery').html(data1.delivey);
                        $('#ajax_order_summary').html(data1.orderSummary);
                    }
                }
            }
        });
    }
});


$(document).on("change", "input[name=courier]", function (e) {
    var courier = $("input:radio.courier:checked").val();
    if (courier)
    {
        $.ajax({
            url: mainUrl+'cart/cart/update_courier',
            type: "POST",
            dataType: "html",
            data: {"courier": courier},
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    if (data.response == 'yes') {
                        
                        var deliveryid = $("input:radio.delivery-group:checked").val();
                        if(deliveryid){
                            $.ajax({
                                url: mainUrl+'cart/cart/update_delevery',
                                type:"POST",
                                dataType: "html",
                                data: {deliveryid: deliveryid, courier: courier},
                                success: function(data1){

                                    if(!data1 == ''){
                                        data1 = $.parseJSON(data1);
                                        if(data1.response=='yes'){
                                            $('#ajax_delivery').html(data1.delivey);
                                            $('#ajax_order_summary').html(data1.orderSummary);
                                        }
                                    }
                                }
                            });
                        }
                        else
                        {
                            $('#ajax_delivery').html(data.delivey);
                            $('#ajax_order_summary').html(data.orderSummary);
                        }

                    }
                }
            }
        });
    }
});
// AA21 ENDS




$(document).on("change", "#delivery_val", function(e) {

    if(this.checked) {
        $('#d_first_name').val($('#b_first_name').val());
        $('#title_d').val($('#title').val());
        $('#d_email').val($('#email_valid').val());
        $('#d_last_name').val($('#b_last_name').val());
        $('#d_phone_no').val($('#b_phone_no').val());
        $('#d_mobile_no').val($('#b_mobile').val());
        //$('#d_ResCom').val($('#b_ResCom').val());
        $('#d_pcode').val($('#b_pcode').val());
        $('#d_add1').val($('#b_add1').val());
        $('#d_add2').val($('#b_add2').val());
        $('#d_city').val($('#b_city').val());
        $('#d_organization').val($('#b_organization').val());
        $('#d_county').val($('#b_county').val());
        $('#dcountry').val($('#country').val());

    }else{
        $('#d_first_name').val('');
        $('#title_d').val('');
        $('#d_email').val('');
        $('#d_last_name').val('');
        $('#d_phone_no').val('');;
        $('#d_mobile_no').val('');
        //$('#d_ResCom').val('');
        $('#d_pcode').val('');
        $('#d_add1').val('');
        $('#d_add2').val('');
        $('#d_city').val('');
        $('#d_organization').val('');
        $('#d_county').val('');
        $('#dcountry').val('');
    }
});

/*****  Changes ***********/
$(document).on("change", "#country", function(e) {
    var billingcountry = $(this).val();
    var b_groupcountry = $("#country option:selected").attr('data-vat');
    if(billingcountry.length > 0){
        //$('#dcountry').val(billingcountry);
        if(b_groupcountry =='EUROPEAN UNION' && billingcountry!="France"){
            $('.ukvatbox').show();
            $( "input[name=unreg_vat]" ).prop( "checked", false);
        }else{
            $('.ukvatbox').hide();
            $( "input[name=unreg_vat]" ).prop( "checked", true);
        }
    }
});
$(document).on("change", "#dcountry", function(e) {
    var deliverycountry = $(this).val();
    var billingcountry = $('#country').val();

    var cc_code = $("#country option:selected").attr('data-value');
    $('#vat_cc').html(cc_code);

    var b_groupcountry = $("#country option:selected").attr('data-vat');
    var d_groupcountry = $("#dcountry option:selected").attr('data-vat');

    if(b_groupcountry =='EUROPEAN UNION' && billingcountry!="France"){
        $('.ukvatbox').show();
        $( "input[name=unreg_vat]" ).prop( "checked", false);
        $('#vat_validator').prop('disabled', true);
        $('#vatnumber').prop('disabled', true);
    }
    else{
        if(billingcountry!='United Kingdom' && deliverycountry=='United Kingdom'){
            //swal("","Because the delivery address for this order is in the UK, it does not qualify as an “export order” and is not therefore exempt from UK VAT.","warning");
        }
        else if(billingcountry=='United Kingdom' && deliverycountry!='United Kingdom'){
           // swal("","Because the billing address for this order is in the UK, it does not qualify as an “export order” and is not therefore exempt from UK VAT.","warning");
        }
        $('#vatnumber').val('');
        $('.ukvatbox').hide();
        $( "input[name=unreg_vat]" ).prop( "checked", false);
        $('#vat_validator').prop('disabled', true);
        $('#vatnumber').prop('disabled', true);

    }
});
/*****  Changes ***********/
$(document).on("change", "input[name=unreg_vat]", function(e) {
    if($(this).is(":checked")){
        $('#vatnumber').val('');
        $('#vat_name').html('');
        $('#vat_address').html('');
        $('#vat_validator').prop('disabled', false);
        $('#vatnumber').prop('disabled', false);
        if(VATNumber =='valid'){
            $.ajax({
                url: base+'ajax/reset_validate_vat',
                type:"POST",
                async:"false",
                data: {  vatvalidate: 'reset'},
                dataType: "html",
                success: function(data){
                    if(!data==''){
                        data = $.parseJSON(data);
                        $('#ajax_order_summary').html(data.orderSummary);
                        VATNumber = 'invalid';
                    }
                }
            });
        }

    }else{
        $('#vat_name').html('');
        $('#vat_address').html('');
        $('#vatnumber').val('');
        $('#vat_validator').prop('disabled', true);
        $('#vatnumber').prop('disabled', true);
    }
});

$(document).on("change", "#dcountry", function(e) {
    $('#d_pcode').val('');
    $('#d_add1').val('');
    $('#d_add2').val('');
    $('#d_city').val('');
    $('#d_organization').val('');
    $('#d_county').val('');
});

$(document).on("change", "#country", function(e) {
    $('#b_pcode').val('');
    $('#b_add1').val('');
    $('#b_add2').val('');
    $('#b_city').val('');
    $('#b_organization').val('');
    $('#b_county').val('');
});

function activeBillingTab(tabId){


    var tabsArray = ['step-1_tab','step-2_tab','step-3_tab','step-4_tab','step_5_tab','step-6_tab'];
    var a=0;
    for(a; a < tabsArray.length;a++){

        var result = (tabsArray[a].split('_'))[0];

        if(tabId == tabsArray[a]){
            $('#'+tabId).addClass('active');
            $('#'+result).show();

        }else{
            $('#'+tabsArray[a]).removeClass('active');
            $('#'+result).hide();
        }
    }
    return true;
}
   $(document).on("click", "#biling", function (e) {
        $('#tabhidden').show();
        activeBillingTab('step-1_tab');
        $('#step-1').show();
		
  });

$(document).on("click", "#activate-step-2 ,#delive", function (e) {
   $('#tabhidden').show();
    if(validateFirstStep()){
        $('ul.setup-panel li:eq(1)').removeClass('disabled');
        activeBillingTab('step-2_tab');
		
		
    }

});

$(document).on("click", "#activate-step-3,#shping", function (e) {
    $('#tabhidden').show();
    if(validatesecondStep()){
     $('ul.setup-panel li:eq(2)').removeClass('disabled');
	 activeBillingTab('step-3_tab');
	 update_review_address();
	}

});

$(document).on("click", "#activate-step-4,#rev_pay", function (e) {
        $('#tabhidden').show();
        $('ul.setup-panel li:eq(4)').removeClass('disabled');
        activeBillingTab('step-4_tab');
        update_review_address();
		//save_session_data();

});


// AA21 STARTS
$(document).on("click", "#pay", function (e) {

        $('#tabhidden').hide();
        $('ul.setup-panel li:eq(3)').removeClass('disabled');
        update_confirm_delivery_address();
        activeBillingTab('step-6_tab');
        update_review_address();
        review_cart_div();
});

$(document).on("click", "#activate-step-6", function (e) {
    
        var delivery = $('input[name=delivery_option]:checked').val();
        if (typeof delivery == "undefined") {
            alert_box("Please select Shipping Method first");
            return false;
        }

        var dcountry = $("#dcountry").val()
        var offshore = $('#offshore').val();
        var courier = $('input[name=courier]:checked').val();
        var orderstatus = $('#orderstatus').val();
        
        
       if( (offshore != true) && (dcountry == 'United Kingdom') && (orderstatus  != 'sample')  )
        {
            if (typeof courier == "undefined") {
                alert_box("Please Select Courier");
                return false;
            }
            else
            {
                $('#tabhidden').hide();
                $('ul.setup-panel li:eq(3)').removeClass('disabled');
                update_confirm_delivery_address();
                activeBillingTab('step-6_tab');
                update_review_address();
                review_cart_div();
            }
        }
        else
        {
            $('#tabhidden').hide();
            $('ul.setup-panel li:eq(3)').removeClass('disabled');
            update_confirm_delivery_address();
            activeBillingTab('step-6_tab');
            update_review_address();
            review_cart_div();
        }

});
// AA21 STARTS




 function review_cart_div(){
	 $.ajax({
		url: mainUrl+'cart/cart/review_cart_div',
		type:"POST",
		async:"false",
		dataType: "html",
		data: {},
		success: function(data){
			if(!data==''){
				data = $.parseJSON(data);
				if(data.response=='yes'){
					$('#review_cart_div').html(data.data);
				 }
			}
		}
	});
 
 
 
 
 }



function validateFirstStep() {
    var title = $('#title').val();
    var b_first_name = $('#b_first_name').val();
    var b_last_name = $('#b_last_name').val();
    var b_phone_no = $('#b_phone_no').val();
    var b_mobile = $('#b_mobile').val();
    var country = $('#country').val();
    var b_pcode = $('#b_pcode').val();
    var b_add1 = $('#b_add1').val();
    var b_add2 = $('#b_add2').val();
    var b_city = $('#b_city').val();
    var b_county = $('#b_county').val();
    var email_valid = $('#email_valid').val();
    var second_email = $('#second_email').val();


    if(title == null || title == ""){
        show_faded_alert('title','select Title');
        return false;
    }
    if(b_first_name == null || b_first_name == ""){
        show_faded_alert('b_first_name','Fist Name missing');
        return false;
    }if(b_last_name == null || b_last_name == ""){
        show_faded_alert('b_last_name','last Name missing');
        return false;
    }if(b_phone_no == null || b_phone_no == ""){
        show_faded_alert('b_phone_no','phone number missing');
        return false;
    }if(b_mobile == null || b_mobile == ""){
        show_faded_alert('b_mobile','mobile number missing');
        return false;
    }if(country == null || country == ""){
        show_faded_alert('country','select country');
        return false;
    }if(b_pcode == null || b_pcode == ""){
        show_faded_alert('b_pcode','post code missing');
        return false;
    }if(b_add1 == null || b_add1 == ""){
        show_faded_alert('b_add1','first address missing');
        return false;
    }

    if(b_add2 == null || b_add2 == ""){
        show_faded_alert('b_add2','second Address missing');
        return false;
    }if(b_city == null || b_city == ""){
        show_faded_alert('b_city','City is  missing');
        return false;
    }if(b_county == null || b_county == ""){
        show_faded_alert('b_county','Country  missing');
        return false;
    }if(email_valid == null || email_valid == ""){
        show_faded_alert('email_valid','Email missing');
        return false;
    }/*if(second_email == null || second_email == ""){
        show_faded_alert('second_email','Second Email missing');
        return false;
    }*/
    return true;
}
function validatesecondStep() {
    var title_d = $('#title_d').val();
    var d_first_name = $('#d_first_name').val();
    var d_last_name = $('#d_last_name').val();
    var d_phone_no = $('#d_phone_no').val();
    var d_mobile_no = $('#d_mobile_no').val();
    var d_email = $('#d_email').val();
    var dcountry = $('#dcountry').val();
    var d_pcode = $('#d_pcode').val();
    var d_add1 = $('#d_add1').val();
    var d_add2 = $('#d_add2').val();
    var d_city = $('#d_city').val();
    var d_county = $('#d_county').val();



    if(title_d == null || title_d == ""){
        show_faded_alert('title_d','select Title');
        return false;
    }
    if(d_first_name == null || d_first_name == ""){
        show_faded_alert('d_first_name','Fist Name missing');
        return false;
    }if(d_last_name == null || d_last_name == ""){
        show_faded_alert('d_last_name','last Name missing');
        return false;
    }if(d_phone_no == null || d_phone_no == ""){
        show_faded_alert('d_phone_no','phone number missing');
        return false;
    }if(d_mobile_no == null || d_mobile_no == ""){
        show_faded_alert('d_mobile_no','mobile number missing');
        return false;
    }if(dcountry == null || dcountry == ""){
        show_faded_alert('dcountry','select country');
        return false;
    }if(d_pcode == null || d_pcode == ""){
        show_faded_alert('d_pcode','post code missing');
        return false;
    }if(d_add1 == null || d_add1 == ""){
        show_faded_alert('d_add1','first address missing');
        return false;
    }

    if(d_add2 == null || d_add2 == ""){
        show_faded_alert('d_add2','second Address missing');
        return false;
    }if(d_city == null || d_city == ""){
        show_faded_alert('d_city','City is  missing');
        return false;
    }if(d_email == null || d_email == ""){
        show_faded_alert('d_email','Email missing');
        return false;
    }
    return true;
}

var oldpcode = '';
var oldcountry = '';
var VATNumber = 'invalid';
function update_review_address(){

    var title = $('#title').val();
    var b_first = $('#b_first_name').val();
    var b_last = $('#b_last_name').val();

    var b_address = $('#b_add1').val();
    var b_city = $('#b_city').val();
    var b_pcode = $('#b_pcode').val();
    var b_county = $('#country').val();



    var d_title = $('#title_d').val();

    var d_first = $('#d_first_name').val();
    var d_last = $('#d_last_name').val();
    var d_address = $('#d_add1').val();
    var d_city = $('#d_city').val();
    var d_pcode = $('#d_pcode').val();
    var d_county = $('#d_county').val();


    var d_pcode = $('#d_pcode').val();
    var d_county = $('#d_county').val();


    var country = $('#country').val();
    var dcountry = $('#dcountry').val();
    $('#shipping_country').html(dcountry);
    $('#shippind_postcode').html(d_pcode);

    $('#billing_name_review').html(title+' '+b_first+' '+b_last);
    $('#billing_address_review').html(b_address+', '+b_city+', '+b_pcode+', '+b_county+', '+country);

    $('#delivery_name_review').html(d_title+' '+d_first+' '+d_last);
    $('#delivery_address_review').html(d_address+', '+d_city+', '+d_pcode+', '+dcountry+', '+dcountry);

    $('#shippind_address_1').html(d_address);
    $('#shippind_city').html(d_city);
    $('#shippind_county').html(d_county);

   if(oldpcode!=d_pcode || oldcountry!=dcountry){

        var b_vatgroup = $("#country option:selected").attr('data-vat');
        var d_vatgroup = $("#dcountry option:selected").attr('data-vat');

        if(b_vatgroup == 'EUROPEAN UNION' && country!="France"){
            $('#delivertimeynote').hide();
            $('#offshoredeliverynote').hide();
            $('.ukvatbox').show();
            var cc_code = $("#country option:selected").attr('data-value');
            $('#vat_cc').html(cc_code);

        }else{
            $('#delivertimeynote').show();
            $('.ukvatbox').hide();
            $( "input[name=unreg_vat]" ).prop( "checked", false);
        }

          
        oldpcode=d_pcode;
        oldcountry=dcountry
		double_callback(oldpcode,d_pcode,b_vatgroup,d_vatgroup,dcountry);  
    }

    //

}

 function double_callback(oldpcode,d_pcode,b_vatgroup,d_vatgroup,dcountry){    
       $.ajax({
            url: mainUrl+'cart/cart/setpostcode',
            type:"POST",
            async:"false",
            dataType: "html",
            data: {postocde:oldpcode,postocde:d_pcode,bgroup:b_vatgroup,dgroup:d_vatgroup,country:dcountry},
            success: function(data){
                if(!data==''){
                    data = $.parseJSON(data);
                    if(data.response=='yes'){
                        $('#ajax_delivery').html(data.delivey);
                        $('#ajax_order_summary').html(data.orderSummary);
                     }
                }
            }
        });
 }
 
 function triple_callback(){
     var title = $('#title').val();
    var b_first = $('#b_first_name').val();
    var b_last = $('#b_last_name').val();

    var b_address = $('#b_add1').val();
    var b_city = $('#b_city').val();
    var b_pcode = $('#b_pcode').val();
    var b_county = $('#country').val();



    var d_title = $('#title_d').val();

    var d_first = $('#d_first_name').val();
    var d_last = $('#d_last_name').val();
    var d_address = $('#d_add1').val();
    var d_city = $('#d_city').val();
    var d_pcode = $('#d_pcode').val();
    var d_county = $('#d_county').val();


    var d_pcode = $('#d_pcode').val();
    var d_county = $('#d_county').val();


    var country = $('#country').val();
    var dcountry = $('#dcountry').val(); 
    
    $('#shippind_postcode').html(d_pcode);

    $('#billing_name_review').html(title+' '+b_first+' '+b_last);
    $('#billing_address_review').html(b_address+', '+b_city+', '+b_pcode+', '+b_county+', '+country);

    $('#delivery_name_review').html(d_title+' '+d_first+' '+d_last);
    $('#delivery_address_review').html(d_address+', '+d_city+', '+d_pcode+', '+dcountry+', '+dcountry);

    $('#shippind_address_1').html(d_address);
    $('#shippind_city').html(d_city);
    $('#shippind_county').html(d_county);
     $('#shipping_country').html(dcountry);
 }
 
function update_confirm_delivery_address(){

  var b_org         = $('#b_organization').val();     var d_org         = $('#d_organization').val();
  var title         = $('#title').val();              var d_title       = $('#title_d').val();
  var b_first       = $('#b_first_name').val();       var d_first       = $('#d_first_name').val();
  var b_last        = $('#b_last_name').val();        var d_last        = $('#d_last_name').val();
  var b_gp_name     = title+' '+b_first+' '+b_last;   var d_gp_name     = d_title+' '+d_first+' '+d_last;
  var b_address     = $('#b_add1').val();             var d_address     = $('#d_add1').val();
  var b_address2    = $('#b_add2').val();             var d_address2    = $('#d_add2').val();
  var b_city        = $('#b_city').val();             var d_city        = $('#d_city').val();
  var b_county      = $('#b_county').val();           var d_county      = $('#d_county').val();
  var b_country     = $('#country').val();            var dcountry      = $('#dcountry').val();
  var b_pcode       = $('#b_pcode').val();            var d_pcode       = $('#d_pcode').val();
  var b_email_valid = $('#email_valid').val();        var d_email       = $('#d_email').val();
  var b_phone_no    = $('#b_phone_no').val();         var d_phone_no    = $('#d_phone_no').val();
  var b_mobile      = $('#b_mobile').val();           var d_mobile      = $('#d_mobile_no').val();
  
 
  $('#bc_com_name').html('');   $('#dc_com_name').html('');
  $('#bc_name').html('');       $('#dc_name').html('');
  $('#bc_add1').html('');       $('#dc_add1').html('');
  $('#bc_add2').html('');       $('#dc_add2').html('');
  $('#bc_city').html('');       $('#dc_city').html('');
  $('#bc_county').html('');     $('#dc_county').html('');
  $('#bc_country').html('');    $('#dc_country').html('');
  $('#bc_pcode').html('');      $('#dc_pcode').html('');
  $('#bc_email').html('');      $('#dc_email').html('');
  $('#bc_ph').html('');         $('#dc_ph').html('');
  $('#bc_mob').html('');        $('#dc_mob').html('');

   
  $('#bc_com_name').html(b_org);        $('#dc_com_name').html(d_org);
  $('#bc_name').html(b_gp_name);        $('#dc_name').html(d_gp_name);
  $('#bc_add1').html(b_address);        $('#dc_add1').html(d_address);
  $('#bc_add2').html(b_address2);       $('#dc_add2').html(d_address2);
  $('#bc_city').html(b_city);           $('#dc_city').html(d_city);
  $('#bc_county').html(b_county);       $('#dc_county').html(d_county);
  $('#bc_country').html(b_country);     $('#dc_country').html(dcountry);
  $('#bc_pcode').html(b_pcode);         $('#dc_pcode').html(d_pcode);
  $('#bc_email').html(b_email_valid);   $('#dc_email').html(d_email);
  $('#bc_ph').html(b_phone_no);         $('#dc_ph').html(d_phone_no);
  $('#bc_mob').html(b_mobile);          $('#dc_mob').html(d_mobile);

  
} 

function category_select(cat){

    if(cat!=''){

        $.ajax({
            type: "get",
            url: mainUrl+'enquiry/Enquiry/getShape',
            cache: false,
            data:{catt_type:cat},
            dataType: 'json',
            success: function(data)
            {
                var opt = '';
                $.each(data.shapes,function (index,value) {
                   opt +='<option value="'+value.Shape_upd+'">'+value.Shape_upd+'</option>';
                })
                $('#Shape').empty();
                $('#Shape').append(
                    opt
                );
                $('#select_shape').show();

            },
            error: function(){
                alert('Error while request..');
            }
        });

        //$('#Shape').load("<?=base_url()?>home/get_shape_for_printing",{catt_type:cat});
    }

}

function status_change(qid,status){



    $.ajax({
        url: mainUrl+'enquiry/Enquiry/ChangeStatus',
        type:"POST",
        async:"false",
        data:{'QuoteNumber':qid,'RequestStatus':status},
        dataType: "html",
        success: function(data){
             window.location.reload();



            swal({
                title: "Status has been updated !!",
                text: "You clicked the button!",
                icon: "success",
                button: "ok!",
            });

        }
    });





}
function changeShape(label_shape)
{

    var cat = $('#category').val();

    if(label_shape == 'Square')
    {
        $("#heightwidth").css('display','block');
        $("#Radius").css('display','none');
    }
    else if(label_shape == 'Circular')
    {
        $("#Radius").css('display','block');
        $("#heightwidth").css('display','none');
    }
    else
    {
        $("#Radius").css('display','none');
        $("#heightwidth").css('display','block');
    }


    if(label_shape!='' && cat!='' ){
        $.ajax({
            type: "get",
            url: mainUrl+'enquiry/Enquiry/getMaterial',
            cache: false,
            data:{shape:label_shape,cat:cat},
            dataType: 'json',
            success: function(data)
            {
                var mat = '';
                $.each(data.materials,function (index,value) {
                    mat +='<option value="'+value.name+'">'+value.name+'</option>';
                })
                $('#material').empty();
                $('#material').append(
                    mat
                );
                $('#Material_sel').show();
            },
            error: function(){
                alert('Error while request..');
            }
        });

    }
}

function reloadMyPage(key) {
    $('#myModal').modal('hide');
    //window.location.reload();

}

function reloadMyPages(key) {
	alert(key);
	$('#update_one'+key).trigger('click');
	//$('#update'+key).hide();
}

function showNotePopup() {
    $('#add_note_popup').modal('show');
}

function conPlainOrPrint(val,serialNumber) {
    $.ajax({
        type: "post",
        url: mainUrl+'order_quotation/Order/changeCategory',
        cache: false,
        data:{val:val,serialNumber:serialNumber},
        dataType: 'json',
        success: function(data)
        {
            window.location.reload();
        },
        error: function(){
            alert('Error while request..');
        }
    });
}

function updateOrder(key,orderNumber,brand,manfectureId,productId,pressproof,SerialNumber,customerId=null,print=null,labelperRoll=null,regmark=null) {

    var digital = $('#digital'+key).val();
    var orientation = $('#Orientation'+key).val();
    var finish = $('#finish'+key).val();
    var labels = $('#label_for_orders'+key).val();
    var qty = parseInt($('#qty'+key).val());
    var design = $('#design'+key).val();
    var wound = $('#wound'+key).val();
    var previousQty = $('#previousQty'+key).val();
    var lbSheets = $('#maxlabel'+key).val();

      if (!digital) {
        print = 'N';
    }

   /*var minQty = $('input[data-min_qty_integrated]').val();
       minQty = (minQty ? parseInt(minQty) : 25);
   var maxQty = $('input[data-max_qty_integrated]').val();
       maxQty = (maxQty ? parseInt(maxQty) : 50000);

   if (qty < minQty && brand !== "Roll Labels") {
        swal("Minimum quantity should be " + minQty + " at least!",
            {
                buttons: {
                    cancel: "OK",
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        );
       $('#qty'+key).val(minQty);

        return false;
	}

    if (qty > maxQty && brand !== "Roll Labels") {
        swal("Maximum quantity cannot exceed "+ maxQty +" limit!",
            {
                buttons: {
                    cancel: "OK",
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        );
        $('#qty'+key).val(maxQty);

        return false;
    }*/
  
   if(brand=='Roll Labels' && print=='Y' && regmark!="Y"){
      labelperRoll = Math.ceil(labels / qty);
  }
    
    var pressProf=0;

    if ($('#pressProf'+key).is(':checked')) {
        pressProf = 1;
    }else{
        pressProf = 0;
    }

if(validationPassForOrder(key,brand,print,qty,labelperRoll,regmark,manfectureId)){
	
	
	swal( "Do You Really Want to Update?",
      {
   buttons: {
     cancel: "No",
     catch: {
       text: "Yes",
       value: "catch",
         closeModal: false
     },
   },
   icon: "warning",
   closeOnClickOutside: false,
 }
     ).then((value) => {
   switch (value) {
     case "catch":
                    
       var qty = confirm_update_order_artwork();
         //alert(qty);
         if(qty === true){
             //alert(qty);
             var qty = $('#qty'+key).val();
             var design = $('#design' + key).val();
             var labels = $('#label_for_orders' + key).val();
             labelperRoll = labels/qty;    
       $.ajax({
						type: "post",
						url: mainUrl+'order_quotation/Order/updateOrder',
						cache: false,
						data:{
							qty:qty,
							labels:labels,
							labelperRoll:labelperRoll,
							printing:print,
							customerId:customerId,
							SerialNumber:SerialNumber,
							brand:brand,
							orderNumber:orderNumber,
							digital:digital,
							Orientation:orientation,
							finish:finish,
							manfectureId:manfectureId,
							productId:productId,
							design:design,
							wound:wound,
							regmark:regmark,
							previousQty:previousQty,
							pressProf:pressProf,
							LabelsPerSheet:lbSheets
						},
						dataType: 'json',
						success: function(data)
						{
							window.location.reload();
						},
						error: function(){
							alert('Error while request..');
						}
					});
                                        }
                default:
                    return false;
            }
        });
}
}

function validationPassForOrder(key,brand,printType,qty,labelperRoll,regmark,manfectureId) {
	labelperRoll = parseInt(labelperRoll,10);
    var minroll = parseInt($('#minroll'+key).val(),10);
    var maxroll = parseInt($('#maxroll'+key).val(),10);
    var minlabel = parseInt($('#minlabel'+key).val(),10);
    var maxlabel = parseInt($('#maxlabel'+key).val(),10);
   
    var digital = $('#digital'+key).val();
    var orientation = $('#Orientation'+key).val();
    var finish = $('#finish'+key).val();
    var labels = $('#label_for_orders'+key).val();
    var qty = $('#qty'+key).val();
    var design = $('#design'+key).val();
    var wound = $('#wound'+key).val();
    var previousQty = $('#previousQty'+key).val();
    var design_number = parseInt($('#design'+key).val(),10);



    if(brand == 'Roll Labels'){
		var minroll = parseInt($('#minroll'+key).val(),10);
        var maxroll = parseInt($('#maxroll'+key).val(),10);
        var minlabel = parseInt($('#minlabel'+key).val(),10);
        var maxlabel = parseInt($('#maxlabel'+key).val(),10);
        
		if(printType == 'N'){
			if(qty < minroll){
				show_faded_alert('qty'+key,'Minmin Quantity '+minroll);
				$('#qty'+key).val(minroll);
                $('#totalLabels'+key).val(labelperRoll*minroll);
				return false;
			}
			
			if(qty > maxroll){
				show_faded_alert('qty'+key,'Maximun Quantity '+maxroll);
				$('#qty'+key).val(maxroll);
                $('#totalLabels'+key).val(labelperRoll*maxroll);
                return false;
			}
			
            else if (qty % minroll != 0) {
				
				if (qty % minroll != 0) {
					var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
					if (multipyer > maxroll) {
						multipyer = maxroll;
					}
                    $('#qty'+key).val(multipyer);
                    $('#totalLabels'+key).val(labelperRoll*multipyer);
                }
				show_faded_alert('qty'+key, "Quantity has been round off to " + minroll + " rolls. ");
				return false;
			}
			return true;
		}
           
		if(printType == 'Y' && regmark != 'Y'){
			if (orientation == "" || orientation == null) {
			show_faded_alert('Orientation'+key ,'please Select Orientation..')
			return false;
			}
            if (wound == "" || wound == null ) {
                show_faded_alert('wound'+key,'Please Select wound Please..');
                return false;
			}
            if (finish == "" || finish == null ) {
				show_faded_alert('finish'+key,'Please Select finish Please..');
                return false;
			}
		}
        else if(printType == 'Y' && regmark == 'Y'){
			if(qty < minroll){
				show_faded_alert('qty'+key,'minmim Labels'+minroll);
				$('#totalLabels'+key).val(labelperRoll*minroll);
				$('#qty'+key).val(minroll);
				return false;
			}

			if(qty > maxroll){
				show_faded_alert('qty'+key,'maxmum Labels'+maxroll);
                $('#totalLabels'+key).val(labelperRoll*maxroll);
                $('#qty'+key).val(maxroll);
				return false;
			}

            else if (qty % minroll != 0) {
				if (qty % minroll != 0) {
				var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
				if (multipyer > maxroll) {
					multipyer = maxroll;
				}
				$('#qty'+key).val(multipyer);
				$('#totalLabels'+key).val(labelperRoll*multipyer);
				}
                show_faded_alert('qty'+key, "Sorry! these labels are only available in sets of " + minroll + " rolls. ");
                return false;
            }
            return true;
        }
        else if(printType == 'Y' && regmark != 'Y'){
			if(qty < minroll){
				show_faded_alert('qty'+key,'minmim Labels'+minroll);
				$('#totalLabels'+key).val(labelperRoll*minroll);
				$('#qty'+key).val(minroll);
				return false;
			}

			if(qty > maxroll){
				show_faded_alert('qty'+key,'maxmum Labels'+maxroll);
				$('#totalLabels'+id).val(labelperRoll*maxroll);
				$('#qty'+key).val(maxroll);
				return false;
			}

			else if (qty % minroll != 0) {
			if (qty % minroll != 0) {
			var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
			if (multipyer > maxroll) {
				multipyer = maxroll;
			}
			$('#qty'+key).val(multipyer);
			$('#totalLabels'+key).val(labelperRoll*multipyer);
			}
			show_faded_alert('qty'+key, "Sorry! these labels are only available in sets of " + minroll + " rolls. ");
			return false;
			}
            return true;
		}
	}
    else{
	//alert(brand);
        if(brand != 'Roll Labels'){
			if(brand == 'A4 Labels' || brand == 'A5 Labels'){
				qty = parseInt(qty,10);
				max = 50000;
				min = 25;
				var design = $('#design'+key).val();
				var arwtork_qty = $('#arwtork_qty'+key).val();
				
				 var isSpeMat= isSpecialMaterial(manfectureId);
                 var min = 25;
                 var max = 50000;
        
        
                  if(isSpeMat){
                    min = 5;
                    max = 5000;
                  }
              

				if(qty > max){

					show_faded_alert('qty'+key,"Maximum quantity "+ max +" on Sheet");
					//$('#qty'+key).val(max);
					return false;
				}
				if(qty < min){
					show_faded_alert('qty'+key,"Minimum quantity "+min +" on Sheet");
					//$('#qty'+key).val(min);
					return false;
				}
			}

			else if(brand == 'SRA3 Label' || brand == 'A3 Label'){
				qty = parseInt(qty,10);
				max = 20000;
				min = 100;
				if(qty > max){
					
					show_faded_alert('qty'+key,"maxim quantity "+ max +" on SRA3 Label");
					$('#qty'+key).val(max);
					return false;
				}
				if(qty < min){
					show_faded_alert('qty'+key,"minmim quantity "+min +" on SRA3 Label");
					$('#qty'+key).val(min);
					return false;
				}
			}
			else if(brand == 'Application Labels'){
				qty = parseInt(qty,10);
				max = 40000;
				min = 1;
				if(qty > max){

					show_faded_alert('qty'+key,"maxim quantity "+ max +" on Application Labels");
					$('#qty'+key).val(max);
					return false;
				}
				if(qty < min){
					show_faded_alert('qty'+key,"minmim quantity "+min +" on Application Labels");
					$('#qty'+key).val(min);
					return false;
				}
			}
			
			
			else if(brand == 'Integrated Labels'){ 
				var batch = $('#totalQty' + key).val(); 
				var  min_qty = batch;
				var max_qty = 500000;
				if(qty == NaN)
				{  
					show_faded_alert('qty'+key, "Minimum "+batch+" sheets allowed");
					$('#qty' + key).val(min_qty);
					return false;
				}
				else if(qty < min_qty)
				{
					show_faded_alert('qty'+key, "Minimum "+batch+" sheets allowed");
					$('#qty' + key).val(min_qty);
					return false;
				}
				else if(qty > max_qty)
				{
					show_faded_alert('qty'+key, "Maximum "+max_qty+" sheets allowed");
					$('#qty' + key).val(max_qty);
			
					return false;
				}
		
				if(qty%batch != 0)
				{
					if(batch == 250)
					{
						qty = Math.ceil(qty/250)*250;
					}
					else
					{
						qty = Math.ceil(qty/1000)*1000;
					}
				}
		
		
				if(qty ==0)
				{
					show_faded_alert('qty'+key, "Minimum "+batch+" sheets allowed");
					$('#qty' + key).val(min_qty);
					return false;
				}else{
					$('#qty' + key).val(qty);
					show_faded_alert('qty'+key, "Quantity has been round off to "+qty);
				}
		
		
			}
			}

    }
        return true;
    }

function showQuotationNotePopup() {
    $('#add_note_popup').modal('show');
}

$('.toggler2').click(function(){
    var id = $(this).attr('data-id');
    $('#assco'+id).toggleClass("hide");

    var check = $('#assco'+id).hasClass("hide");
    if(check){
        $(this).html('Show Details');
    }else{ $(this).html('Hide Details'); }

});

function changeCat(val,serialNumber,key,brand,manfactureID,LabelsPerSheet,pressProff,customerId=null,productID=null,regmark=null) {
    $.ajax({
		async:false,
        type: "post",
        url: mainUrl+'order_quotation/quotation/updateCategory',
        cache: false,
        data:{serialNumber:serialNumber,val:val},
        dataType: 'json',
        success: function(data)
        {
			
			if(val=='N'){
			updateQuotationDetailPrice(key,serialNumber,brand,manfactureID,LabelsPerSheet,pressProff,customerId,productID,regmark);
			}else{
				window.location.reload();
			}
	    },
        error: function(){
            alert('Error while request..');
        }
    });
}

function updateDetailPrice(key,serialNumber,brand,manfactureID,LabelsPerSheet,pressProff,customerId=null) {
    var qty = $('#qty'+key).val();
    var digital = $('#digital'+key).val();
    var Orientation = $('#Orientation'+key).val();
    var finish = $('#finish'+key).val();
    var wound = $('#wound'+key).val();
    var design = $('#design'+key).val();
    var printing = $('#printer'+key).val();
    if(validateRequest(brand)){
        $.ajax({
            type: "post",
            url: mainUrl+'order_quotation/quotation/updateDetailPrice',
            cache: false,
            data:{
                customerId:customerId,
                serialNumber:serialNumber,qty:qty,digital:digital,
                Orientation:Orientation,finish:finish,wound:wound,design:design,brand:brand,
                manfactureID:manfactureID,LabelsPerSheet:LabelsPerSheet,printing:printing,pressProff:pressProff
            },
            dataType: 'json',
            success: function(data)
            {
                window.location.reload();
            },
            error: function(){
                alert('Error while request..');
            }
        });
    }

}

function updateQuotationDetailPrice(key,serialNumber,brand,manfactureID,LabelsPerSheet,pressProff,customerId=null,productID=null,regmark=null) {

   /* var qty = $('#qty' + key).val();

    var minQty = $("input[data-min_qty_integrated='+ serialNumber +']").val();
    minQty = (minQty ? minQty : 25);
    var maxQty = $("input[data-max_qty_integrated='+ serialNumber +']").val();
    maxQty = (maxQty ? maxQty : 50000);

    if (qty < minQty && brand !== "Roll Labels") {
        swal("Minimum quantity should be " + minQty + " at least!",
            {
                buttons: {
                    cancel: "OK",
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        );
        $('#qty' + key).val(minQty);

        return false;
    }

    if (qty > maxQty && brand !== "Roll Labels") {
        swal("Maximum quantity cannot exceed "+ maxQty +" limit!",
            {
                buttons: {
                    cancel: "OK",
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        );
        $('#qty' + key).val(maxQty);

        return false;
    }*/



    /*if(validateQuotationRequest(key,brand,qty,manfactureID)){

    }*/

  swal(
    "Are You Sure You Want To Continue",
    {
      buttons: {
        cancel: "No",
        catch: {
          text: "Yes",
          value: "catch",
        },
      },
      icon: "warning",
      closeOnClickOutside: false,
    }
  ).then((value) => {
    switch (value) {
      case "catch":

        $('#aa_loader').show();
	
        var qty = $('#qty'+key).val();
        var digital = $('#digital'+key).val();
        var Orientation = $('#Orientation'+key).val();
        var finish = $('#finish'+key).val();
        var wound = $('#wound'+key).val();
        var design = $('#design'+key).val();
        var printing = $('#printer'+key).val();
        var totalLabels = $('#totalLabels'+key).val();
        var Labels = totalLabels / qty;
        var presProf=0;
	

        if ($('#pressProf'+key).is(':checked')) {
          presProf = 1;
        }else{
          presProf = 0;
        }


        if(validateQuotationRequest(key,brand,qty,manfactureID)){


            var qty = confirm_update_quotation_artwork();
            //alert(qty);
            if (qty === true) {
                //alert(qty);
                var qty = $('#qty' + key).val();
                var design = $('#design' + key).val();
                var labels = $('#totalLabels' + key).val();
                labelperRoll = labels / qty;
               
                $.ajax({
            type: "post",
            url: mainUrl+'order_quotation/quotation/updateDetailPrice',
            cache: false,
            data:{
              customerId:customerId,
              serialNumber:serialNumber,
              qty:qty,
              digital:digital,
              Orientation:Orientation,
              finish:finish,
              wound:wound,
              design:design,
              brand:brand,
              labels:labels,
              labelperRoll: labelperRoll,
              LabelsPerSheet:LabelsPerSheet,
              manfactureID:manfactureID,
                
              printing:printing,
              pressProff:presProf,
              productID:productID,
              regmark:regmark
            },
            dataType: 'json',
            success: function(data)
            {
              window.location.reload();
            },
            error: function(){
              alert('Error while request..');
            }
          });
          }
        }
        
        
        $('#aa_loader').hide();
        
        
        break;
    }
  });
    }

function validateQuotationRequest(key,brand,qty,manfactureID) {

  if(brand == 'Roll Labels'){
    var minroll = parseInt($('#minroll'+key).val(),10);
    var maxroll = parseInt($('#maxroll'+key).val(),10);
    var minlabel = parseInt($('#minlabel'+key).val(),10);
    var maxlabel = parseInt($('#maxlabel'+key).val(),10);
    var printType = parseInt($('#printings'+key).val(),10);
    var regmark = parseInt($('#regmarks'+key).val(),10);
    var design_number = parseInt($('#design'+key).val(),10);
    
    if(printType==""){
      printType = 'N';
    }
    
         
    if(printType == 'N'){
      if(qty < minroll){
        show_faded_alert('qty'+key,'Minmin Quantity '+minroll);
        $('#qty'+key).val(minroll);
        $('#totalLabels'+key).val(labelperRoll*minroll);
        return false;
      }
			
      if(qty > maxroll){
        show_faded_alert('qty'+key,'Maximun Quantity '+maxroll);
        $('#qty'+key).val(maxroll);
        $('#totalLabels'+key).val(labelperRoll*maxroll);
        return false;
      }
			
      else if (qty % minroll != 0) {
			 	    
        if (qty % minroll != 0) {
          var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
          if (multipyer > maxroll) {
            multipyer = maxroll;
          }
          $('#qty'+key).val(multipyer);
          $('#totalLabels'+key).val(labelperRoll*multipyer);
        }
        show_faded_alert('qty'+key, "Quantity has been round off to " + minroll + " rolls. ");
        return false;
      }
      return true;
    }
           
    if(printType == 'Y' && regmark != 'Y'){
      if (orientation == "" || orientation == null) {
        show_faded_alert('Orientation'+key ,'please Select Orientation..')
        return false;
      }
      if (wound == "" || wound == null ) {
        show_faded_alert('wound'+key,'Please Select wound Please..');
        return false;
      }
      if (finish == "" || finish == null ) {
        show_faded_alert('finish'+key,'Please Select finish Please..');
        return false;
      }
    }
    
    else if(printType == 'Y' && regmark == 'Y'){
      if(qty < minroll){
        show_faded_alert('qty'+key,'minmim Labels'+minroll);
        $('#totalLabels'+key).val(labelperRoll*minroll);
        $('#qty'+key).val(minroll);
        return false;
      }

      if(qty > maxroll){
        show_faded_alert('qty'+key,'maxmum Labels'+maxroll);
        $('#totalLabels'+key).val(labelperRoll*maxroll);
        $('#qty'+key).val(maxroll);
        return false;
      }

      else if (qty % minroll != 0) {
        if (qty % minroll != 0) {
          var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
          if (multipyer > maxroll) {
            multipyer = maxroll;
          }
          $('#qty'+key).val(multipyer);
          $('#totalLabels'+key).val(labelperRoll*multipyer);
        }
        show_faded_alert('qty'+key, "Sorry! these labels are only available in sets of " + minroll + " rolls. ");
        return false;
      }
      return true;
    }
    
    else if(printType == 'Y' && regmark != 'Y'){
      if(qty < minroll){
        show_faded_alert('qty'+key,'minmim Labels'+minroll);
        $('#totalLabels'+key).val(labelperRoll*minroll);
        $('#qty'+key).val(minroll);
        return false;
      }
        
      if(qty > maxroll){
        show_faded_alert('qty'+key,'maxmum Labels'+maxroll);
        $('#totalLabels'+id).val(labelperRoll*maxroll);
        $('#qty'+key).val(maxroll);
        return false;
      }

      else if (qty % minroll != 0) {
        if (qty % minroll != 0) {
          var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
          if (multipyer > maxroll) {
            multipyer = maxroll;
          }
          $('#qty'+key).val(multipyer);
          $('#totalLabels'+key).val(labelperRoll*multipyer);
        }
        show_faded_alert('qty'+key, "Sorry! these labels are only available in sets of " + minroll + " rolls. ");
        return false;
      }
      return true;
    }
  }
    
   

  else if(brand == 'A4 Labels' || brand == 'A3 Label' || brand == 'A5 Labels'){
    qty = parseInt(qty,10);
    
    
  
    
    var isSpeMat= isSpecialMaterial(manfactureID);
    var min = 25;
    var max = 50000;
    
    
    if(isSpeMat){
       min = 5;
       max = 5000;
    }
    
    var design = $('#design'+key).val();
    var arwtork_qty = $('#arwtork_qty'+key).val();
        

    if(qty > max){
      
      show_faded_alert('qty'+key,"Maximum quantity "+ max +" on Sheet");
      //$('#qty'+key).val(max);
      return false;
    }
    
    if(qty < min){
      show_faded_alert('qty'+key,"Minimum quantity "+min +" on Sheet");
      //$('#qty'+key).val(min);
      return false;
    }
  }

    else if(brand == 'SRA3 Label'){
        qty = parseInt(qty,10);
        max = 20000;
        min = 100;
        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on SRA3 Label");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+min +" on SRA3 Label");
            $('#qty'+key).val(min);
            return false;
        }
    }
    else if(brand == 'Application Labels'){
        qty = parseInt(qty,10);
        max = 40000;
        min = 1;
        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on Application Labels");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+min +" on Application Labels");
            $('#qty'+key).val(min);
            return false;
        }
    }
  else if(brand == 'Integrated Labels'){ 
			
    var batch = parseInt($('#ogbatch'+key).val());
    var  min_qty = batch;
    var max_qty = 500000;
			
			
			
    if(qty == NaN)
    {  
      show_faded_alert('qty'+key, "Minimum "+batch+" sheets allowed");
      $('#qty' + key).val(min_qty);
      return false;
    }
    else if(qty < min_qty)
    {
      show_faded_alert('qty'+key, "Minimum "+batch+" sheets allowed");
      $('#qty' + key).val(min_qty);
      return false;
    }
    else if(qty > max_qty)
    {
      show_faded_alert('qty'+key, "Maximum "+max_qty+" sheets allowed");
      $('#qty' + key).val(max_qty);
			
    return false;
  }
    
    if(qty%batch != 0)
		{
    if(batch == 250)
    {
      qty = Math.ceil(qty/250)*250;
    }
    else
    {
      qty = Math.ceil(qty/1000)*1000;
    }
  }
		
		
		if(qty ==0)
		{
			show_faded_alert('qty'+key, "Minimum "+batch+" sheets allowed");
			$('#qty' + key).val(min_qty);
			return false;
		}else{
			$('#qty' + key).val(qty);
			show_faded_alert('qty'+key, "Quantity has been round off to "+qty);
		}
		
		
	}


    return true;
}






function validateQuotationRequestTemp(key,brand,qty) {

    
    
    if(brand =='Roll Labels'){
        
        var min = $('[data-calulate_min_rolls=' + key + ']').attr('value');
        var max = $('[data-calulate_max_rolls=' + key + ']').attr('value');

        qty = parseInt(qty,10);
        max = parseInt(max,10);
        min = parseInt(min,10);

        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on Roll");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+min +" on Roll");
            $('#qty'+key).val(min);
            return false;
        }


    }

    else if(brand == 'A4 Labels' || brand == 'A3 Label'){
        qty = parseInt(qty,10);
        max = 50000;
        min = 25;
        //var design = $('#design'+key).val();
        //var arwtork_qty = $('#arwtork_qty'+key).val();

        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on Sheet");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+min +" on Sheet");
            $('#qty'+key).val(min);
            return false;
        }
    }

    else if(brand == 'SRA3 Label'){
        qty = parseInt(qty,10);
        max = 20000;
        min = 100;
        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on SRA3 Label");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+min +" on SRA3 Label");
            $('#qty'+key).val(min);
            return false;
        }
    }
    else if(brand == 'Application Labels'){
        qty = parseInt(qty,10);
        max = 40000;
        min = 1;
        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on Application Labels");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+min +" on Application Labels");
            $('#qty'+key).val(min);
            return false;
        }
    }
    else if(brand == 'Integrated Labels'){
        qty = parseInt(qty,10);
        //var check = parseInt($('#totalLabels'+key).val(),10);
        var min = $('[data-min_qty_integrated=' + key + ']').attr('value');
        var max = $('[data-max_qty_integrated=' + key + ']').attr('value');
       // max = 40000;
        //min = 250;
        if(qty > max){

            show_faded_alert('qty'+key,"maxim quantity "+ max +" on Integrated Labels");
            $('#qty'+key).val(max);
            return false;
        }
        if(qty < min){
            show_faded_alert('qty'+key,"minmim quantity "+check +" on Integrated Labels");
            $('#qty'+key).val(check);
            return false;
        }
    }

    return true;
}


  function set_currency(currency,condition=null){
    $.ajax({
        type: "post",
        url: mainUrl+'order_quotation/quotation/set_currency',
        cache: false,
        data:{'currency':currency},
        dataType: 'html',
        success: function(data){
            //
            if(condition == 'quo'){
                location.reload();
            }else{
                checkout();
            }

        },
        error: function(){
            alert('Error while request..');
        }
    });

}

 function quotaion_currency(currency,quotenumber){
    $.ajax({
        type: "post",
        url: mainUrl+'order_quotation/quotation/quotaion_currency',
        cache: false,
        data:{'currency':currency,'quotenumber':quotenumber},
        dataType: 'html',
        success: function(data){
         location.reload();
         },
        error: function(){
            alert('Error while request..');
        }
    });

}



// AA21 STARTS
function update_shiping(orderNumber){

    var ship_id = $("#c1").val();
    var ordernumber = orderNumber;
    var deliveryCourier = $("#deliveryCourier option:selected").val();

    if(ship_id!=''){
        $.ajax({
            type: "post",
            url: mainUrl+'order_quotation/quotation/updateShipping',
            cache: false,
            data:{'ShippingID': ship_id,'quoteID':orderNumber, "deliveryCourier":deliveryCourier},
            dataType: 'html',
            success: function(data){
                window.location.reload();
            }
        });
    }
}
// AA21 ENDS


function printpdf(id,lang=null,price=null){
    var val = $('.hideprice:checked').length;
    if(lang !=null){
        var ver = lang;
    }else{
        var ver = $('#language').val();
    }


    //alert(ver);
    //exit();
    $('#allow').val(2);
     window.location.href=mainUrl+'order_quotation/quotation/showquotepdf/'+id+'/'+val+'/'+ver;
}

function chagestatus(val,id){
    var value = $('#allow').val();
    if(val!=23){
        
    
    if(value==1){
        swal("","Please Print Quotation first in order to change status.","warning");
        $('#status').val('37');
        return false;
     }
    }
     
     
    $.ajax({

        url: mainUrl+'order_quotation/quotation/changestatus',
        data:{
            status:val,
            id:id
        },

        datatype:'json',
        success:function(data){
            location.reload();
        }
    });
}

function chagePayment(val,id){
$('#f_err').addClass('f_err');

   $.ajax({

        url: mainUrl+'order_quotation/quotation/changestatus',
        data:{
            status:val,
            id:id
        },

        datatype:'json',
        success:function(data){
        }
    });
}

function ifnullss(){
	var payy = $('#payment').val();
	
	if(payy==""){
		$('#f_err').removeClass('f_err');
	   return false;
	   }
}

function generateorder2(id){
    var base_url = mainUrl+'order_quotation/quotation/generateorder/'+id;

    $.ajax({
        type: "post",
        url: mainUrl+'order_quotation/quotation/getsituation',
        data:{ id:id },
        dataType: 'html',
        success:function(data){
            data = $.parseJSON(data);
            if(data.result=="pass"){
                window.location.href= base_url;
            }else if(data.result=="error"){
                //alert("Please Select Atleast one line !");
                swal("Please Select Atleast one line !");
                return false;
            }
        }
    });


}

function selectorall(id,val){
    $.ajax({
        type: "post",
        url: mainUrl+'order_quotation/quotation/selectlineall',
        cache: false,
        data:{id:id,val:val},
        dataType: 'html',
        success: function(data){
            if(val=="Y"){
                $(".itemcheck").prop("checked", true);
            }else{
                $(".itemcheck").prop("checked", false);
            }
        }
    });
}

function deletenode(id,prl,man) {
    swal(
        "Are You Sure You Want To Delete This Line",




        {

            buttons: {

                cancel: "No",

                catch: {

                    text: "Yes",

                    value: "catch",

                },


            },

            icon: "warning",

            closeOnClickOutside: false,

        }
    ).then((value) => {

        switch (value) {


            case "catch":

                deleteThisLine(id,prl,man);

                break;


        }

    });
}
function deleteOrderNode(id,ordernumber) {
    swal(
        "Are You Sure You Want To Delete This Line",




        {

            buttons: {

                cancel: "No",

                catch: {

                    text: "Yes",

                    value: "catch",

                },


            },

            icon: "warning",

            closeOnClickOutside: false,

        }
    ).then((value) => {

        switch (value) {


            case "catch":

                deletePlainLine(id,ordernumber);

                break;


        }

    });
}
function deletePlainLine(id,ordernumber) {
    $.ajax({
        type: "get",
        url: mainUrl+'order_quotation/Order/deletePlainLine',
        cache: false,
        data:{id:id,ordernumber:ordernumber},
        dataType: 'json',
        success: function(data){
            window.location.reload();
        }
    });
}
function deleteThisLine(id,prl,man) {
    $.ajax({
        type: "get",
        url: mainUrl+'order_quotation/quotation/deletequoteitem',
        cache: false,
        data:{id:id,prl_id:prl,mid:man},
        dataType: 'json',
        success: function(data){
            location.reload();
        }
    });
}

function save_session_data(){
          $.ajax({
            type: "POST",
            async: false,
            url: mainUrl + 'order_quotation/order/save_checkout_session_data',
            data: $( "#checkout_form" ).serialize(),
            success: function(html) {

            }
        });


}

$(document).on("click", ".paywithexistingcardsbtn", function(e) {
    save_session_data();
    window.location.reload();
});

$(document).on("click", ".paywithnewcardbtn", function(e) {
    //$('#creditcard option[value="not-on-file"]').prop('selected', 'selected').change();
    load_worldpay_form();
});
var worldpayinitialize = 0;


$(document).on("click", ".payment_for_ord", function(e) {
    //$('#creditcard option[value="not-on-file"]').prop('selected', 'selected').change();



    make_prominent_buttons();


        if ($(this).val() == "creditCard") {

            $('#uploader_po').hide();
            $('.purchaseordertxt').hide();
            $('.paypal-extra-space').hide();
            $('.secure-ssl-seal1').show();
            $("#chequePostel_div").hide();
            $('.paypal-confirm-msg').hide();

            if (worldpayinitialize == 1) {
                $(".paymentInputs").hide();
                $("#confirmbtn").hide();
                $("#worlpaybtn").show();
                $("#paymentSection").show();

                /********* new code checkout payment section ******/
                if ($('#creditcard').length == 0) {
                    $('.paypal-extra-space').css('margin-top', '70px');
                    $('.paypal-extra-space').show();
                    $('.paywithotheroptions').show();
                }
                $(".paypal_selection_box").hide();
                $(".purchaseorder_selection_box").hide();
                $('.backs_selection_box').hide();
                /********* new code checkout payment section ******/



                var creditcard = $('#creditcard').val();
                if (typeof creditcard != 'undefined' && creditcard != '') {
                    $(".paywithexistingcards").show();
                    $('.retain_card_opt').hide();
                } else {
                    $('.retain_card_opt').show();

                }
                $(".secure-ssl-seal").hide();
            } else {

                $('#confirmbtn').html('Pay Now <i class="fa fa-arrow-circle-right"></i>');
                $('.cardsonfile').show();
                show_cvc_option();
            }
            document.getElementById('confirmbtn').disabled = null;
        }
        else if ($(this).val() == "paypal") {
            $('#confirmbtn').html('Pay Now <i class="fa fa-arrow-circle-right"></i>');
            $('#uploader_po').hide();
            $('.purchaseordertxt').hide();
            $("#chequePostel_div").hide();

            $('.cardsonfile').hide();
            $('.cardsonfile').hide();
            $('.retain_card_opt').hide();
            $('.cvcinput').hide();


            /********* new code checkout payment section ******/
            $('.paypal-extra-space').css('margin-top', '14px');
            $('.paypal-extra-space').show();
            $('.secure-ssl-seal1').hide();
            /********* new code checkout payment section ******/



            document.getElementById('confirmbtn').disabled = null;

            $(".paymentInputs").show();
            $("#paymentSection").hide();
            $("#worlpaybtn").hide();
            $("#confirmbtn").show();
            $(".paywithexistingcards").hide();
            $(".secure-ssl-seal").show();
            $('.paypal-confirm-msg').hide();

        }
        else if ($(this).val() == "chequePostel") {
            $("#chequePostel_div").show();
            $('#uploader_po').hide();
            $('.purchaseordertxt').hide();
            $(".secure-ssl-seal1").show();
            $('.cardsonfile').hide();
            $('.cardsonfile').hide();
            $('.retain_card_opt').hide();
            $('.cvcinput').hide();
            $('.paypal-extra-space').hide();
            //$('.paypal-extra-space').css('margin-top','23px');

            $('#confirmbtn').html('Confirm Order <i class="fa fa-arrow-circle-right"></i>');
            $('.cardsonfile').hide();
            $('.cvcinput').hide();

            document.getElementById('confirmbtn').disabled = null;

            $(".paymentInputs").show();
            $("#paymentSection").hide();
            $("#worlpaybtn").hide();
            $("#confirmbtn").show();
            $('.paypal-confirm-msg').hide();


        }
        else if ($(this).val() == "purchaseOrder") {
            /********* new code checkout payment section ******/
            $('.paypal-extra-space').css('margin-top', '47px');
            $('.paypal-extra-space').show();
            $('.secure-ssl-seal1').show();
            $("#chequePostel_div").hide();
            /********* new code checkout payment section ******/
            $(".paywithexistingcards").hide();
            $('.retain_card_opt').hide();
            $('#uploader_po').show();
            $('.purchaseordertxt').show();

            $('#confirmbtn').html('Confirm Order <i class="fa fa-arrow-circle-right"></i>');
            $('.cardsonfile').hide();
            $('.cvcinput').hide();
            document.getElementById('confirmbtn').disabled = null;

            $(".paymentInputs").show();
            $("#paymentSection").hide();
            $("#worlpaybtn").hide();
            $("#confirmbtn").show();
            $(".secure-ssl-seal").show();
            $('.paypal-confirm-msg').hide();


        }
        else {

            $(".paymentInputs").show();
            $("#paymentSection").hide();
            $("#worlpaybtn").hide();
            $('.secure-ssl-seal1').hide();
            $(".secure-ssl-seal").hide();
            $('.paypal-confirm-msg').hide();
            $('.purchaseordertxt').hide();
            $('#confirmbtn').html('Confirm Order <i class="fa fa-arrow-circle-right"></i>');
            $('.cardsonfile').hide();
            $('.cvcinput').hide();
            document.getElementById('confirmbtn').disabled = null;

            $("#worlpaybtn").hide();
            $("#confirmbtn").show();
        }

});


$(document).on('click','#confirmbtn',function () {
    if(validate_form()==true){
        return true;
    }else{
        return false;
    }
});
function show_cvc_option(){
    var creditcard = $('#creditcard').val();

    if(typeof creditcard != 'undefined' && creditcard != 'not-on-file' && $('#creditcard').length == 1){
        $('.cvcinput').show();
        $('.paywithnewcard').show();
        $('.retain_card_opt').hide();
        $(".secure-ssl-seal").show();

    }else{
        $('.cvcinput').hide();
        $('.paywithnewcard').show();
        $('.retain_card_opt').show();
        load_worldpay_form();
        //if(worldpayinitialize == 0){load_worldpay_form();}
    }
    $('#confirmbtn').html('Pay Now <i class="fa fa-arrow-circle-right"></i>');
    document.getElementById('confirmbtn').disabled = null;
    make_prominent_buttons();

}
function make_prominent_buttons(){
    $("#confirmbtn").css('opacity',1);
    $("#worlpaybtn").css('opacity',1);
}
function load_worldpay_form(){
    $('.retain_card_opt').show();
    $('.paywithnewcard').hide();
    $('.cvcinput').hide();
    $(".secure-ssl-seal").hide();

    /********* new code checkout payment section ******/
    $(".paywithexistingcards").show();
    $(".paypal_selection_box").hide();
    $(".purchaseorder_selection_box").hide();
    $('.backs_selection_box').hide();
    $('.paypal-extra-space').css('margin-top','58px');
    $(".paypal-extra-space").show();
    /********* new code checkout payment section ******/



    save_session_data();
    worldPay(document.getElementById('worldpay_form'));
}

/********* new code checkout payment section ******/
$(document).on("click", ".paywithotheroptionsbtn", function(e) {
    $('#worldpay').attr('checked', false);
    $('.paypal_selection_box').show();
    $('.purchaseorder_selection_box').show();
    $('.backs_selection_box').show();

    $(".paymentInputs").show();
    $("#paymentSection").hide();
    $("#worlpaybtn").hide();
    $("#confirmbtn").show();
    $(".paywithexistingcards").hide();
    $('.paywithotheroptions').hide();

    $('.paypal-extra-space').css('margin-top','27px');
    $('.paypal-extra-space').show();
    $('.secure-ssl-seal1').hide();

});
/********* new code checkout payment section ******/

function worldPay(form){
    //$("#paymentSection").find('img').show();
    make_prominent_buttons();

    Worldpay.useTemplateForm({
        'clientKey':$('#WP_Public_KEY').val(),
        'form':form,
        'saveButton':false,
        'reusable':true,
        'templateOptions': {images:{enabled:false},dimensions:{width:false,height:265,}},
        'paymentSection':'paymentSection',
        'display':'inline',  //modal inline
        'callback': function(obj) {
            if (obj && obj.token) {

                $('#creditcard').val('not-on-file');

                document.getElementById('worlpaybtn').disabled = true;
                //document.getElementById('previous_3').disabled = true;
                document.getElementById('back_to_payment').disabled = true;

                var loader_icon = $('#world_loader_icon').clone();
                $('#worlpaybtn').html(loader_icon);
                $('#worlpaybtn').append(' Please Wait....');
                $('#world_loader_icon').show();

                var _el = document.createElement('input');
                _el.value = obj.token;
                _el.type = 'hidden';
                _el.name = 'token';

                  var form = document.getElementById('checkout_form');
                  form.appendChild(_el);
                  form.submit();

            }
        },
        'beforeSubmit': function() {
            document.getElementById('worlpaybtn').disabled = true;
            $('#world_loader_icon').show();
            return true;
        },
        'validationError': function(obj) {

            $('#confirmbtn').html('Pay Now <i class="fa fa-arrow-circle-right"></i>');
            document.getElementById('confirmbtn').disabled = null;

            document.getElementById('worlpaybtn').disabled = null;
            $('#world_loader_icon').hide();
        },
    });

    //$('#previous_3').hide();
    //$('#back_to_payment').show();

    $(".cardsonfile").hide();
    $(".paymentInputs").hide();
    $("#paymentSection").show();
    $("#worlpaybtn").show();

    var creditcard = $('#creditcard').val();
    if(typeof creditcard != 'undefined' && creditcard != ''){
        $(".paywithexistingcards").show();
        $('.retain_card_opt').hide();
    }else{
        $('.retain_card_opt').show();
    }

    //document.getElementById('confirmbtn').disabled = null;
    worldpayinitialize = 1;
}

function checkPaymetnForOrder(){



            if(validate_form()==true){
                var paymentway = $('.payment_for_ord').val();
                if(paymentway=='creditCard'){

                    var creditcard =  $('#creditcard').val();
                    if( typeof creditcard!=='undefined' && creditcard != '' && creditcard != 'not-on-file'){
                        $('#worldpay_token').val(creditcard);
                        $('#worldpay_cvc').val($('#cvcnumb').val());


                        var loader_icon = $('#world_loader_icon').clone();
                        $('#confirmbtn').html(loader_icon);
                        $('#confirmbtn').append(' Please Wait....');
                        $('#world_loader_icon').show();
                        document.getElementById('confirmbtn').disabled = true;

                        $('#payment_form').submit();
                        return false;

                    }else{
                        //save_session_data();
                        worldPay(document.getElementById('worldpay_form'));
                        return false;
                    }
                }
                else if(paymentway=='paypal'){

                    if($('#PayerID').length > 0 && $('#paymentID').length > 0 ){
                        var payment_id = $('#PayerID').val();
                        var payer_id = $('#paymentID').val();
                        if(payment_id!='' && payment_id!=''){

                            var loader_icon = $('#world_loader_icon').clone();
                            $('#confirmbtn').html(loader_icon);
                            $('#confirmbtn').append(' Please Wait....');
                            $('#world_loader_icon').show();
                            document.getElementById('confirmbtn').disabled = true;

                            form.submit();
                            return true;
                            //$("#checkout_form").submit();
                        }else{
                            alert_box("Please make the payment before confirm the order! ");
                            return false;
                        }
                        //$('#paypal-confirm-btn').click();
                    }else{
                        alert_box("Please make the payment before confirm the order! ");
                        return false;
                    }
                }
                else{

                    var loader_icon = $('#world_loader_icon').clone();
                    $('#confirmbtn').html(loader_icon);
                    $('#confirmbtn').append(' Please Wait....');
                    $('#world_loader_icon').show();
                    document.getElementById('confirmbtn').disabled = true;


                    form.submit();
                    return true;
                }



            }else{
                console.log('validation error');
                return false;
            }


}

$(document).on('click','#worlpaybtn',function() {
    if(validate_form()==true){
        Worldpay.submitTemplateForm();
    }
});

function validate_form(){

    if(paymentoption=='sample'){
        $( "#pushase" ).prop( "checked", true );
    }
    var paymentway = $('input[name=paymentway]:checked').val();
    //var confirm_check = $('input[name=confirm_check]:checked').val();
    var terms = $('input[name=agree_term]:checked').val();


    if(typeof  paymentway =="undefined" ){
        alert_box("Please select one of the payment options");
        return false;
    }
    else if(typeof  terms =="undefined" ){
        alert_box("Please accept the terms and conditions");
        $('.normal_checkout').css('background','#fff2f2');
        $('.normal_checkout').css('border','1px solid #ff0000');
        return false;
    }else{
        $('.normal_checkout').css('background','#f5f5f5');
        $('.normal_checkout').css('border','1px solid #ccc');
        return true;
    }

}



function updateNewLine(cartId,id) {


    swal(
        "Are You Sure You Want To Update This Line",




        {

            buttons: {

                cancel: "No",

                catch: {

                    text: "Yes",

                    value: "catch",

                },


            },

            icon: "warning",

            closeOnClickOutside: false,

        }
    ).then((value) => {

        switch (value) {


            case "catch":

                $.ajax({

                    type: "post",

                    url: mainUrl + "cart/cart/updateNewLine",

                    cache: false,

                    data: {'cartId':cartId,'update_line_man':$('#update_line_man'+id).val(),'update_line_des':$('#update_line_des'+id).val(),
                        'update_line_price':$('#update_line_price'+id).val()
                        ,'update_line_qty':$('#update_line_qty'+id).val()

                    },

                    dataType: 'json',

                    success: function (data) {
                        checkout();
                    },

                    error: function (jqXHR, exception) {

                        if (jqXHR.status === 500) {

                            alert('There is some error in  Values...');

                        } else {

                            alert('Error While Requesting...');

                        }

                    }

                });

                break;


        }

    });


}


function addNewLine(_thiss) {
    if($('#new_line_man').val() == null || $('#new_line_man').val() ==""){
        show_faded_alert('new_line_man','Please Insert Manfecture ID');
        return false;
    }
    if($('#new_line_des').val() == null || $('#new_line_des').val() ==""){
        show_faded_alert('new_line_des','Please Insert Description');
        return false;
    }
    if($('#new_line_man').val() == null || $('#new_line_man').val() ==""){
        show_faded_alert('new_line_man','Please Insert Manfecture ID');
        return false;
    }
    if($('#new_line_qty').val() != null && $('#new_line_qty').val() != "" && !is_numeric($('#new_line_qty').val())){
        show_faded_alert('new_line_qty','Please Insert Number');
        return false;
    }
    if($('#new_line_qty').val() == null || $('#new_line_qty').val() ==""){
        show_faded_alert('new_line_qty','Please Insert Unitprice');
        return false;
    }
    if($('#new_line_price').val() == null || $('#new_line_price').val() ==""){
        show_faded_alert('new_line_price','Please Insert Quantity');
        return false;
    }
    if(!is_numeric($('#new_line_price').val()) && $('#new_line_price').val() != null){
        show_faded_alert('new_line_price','Please Insert Number');
        return false;
    }
    _thiss.onclick = function(event) {
        event.preventDefault();
  }
  
    $.ajax({

        type: "post",

        url: mainUrl + "cart/cart/addNewLne",

        cache: false,

        data: {'new_line_man':$('#new_line_man').val(),'new_line_des':$('#new_line_des').val(),'new_line_price':$('#new_line_price').val()
            ,'new_line_qty':$('#new_line_qty').val()

        },

        dataType: 'json',

        success: function (data) {
            checkout();
  },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('There is some error in  Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });
}

function quotationNewLine(quoNumber,userId,_this) {
  
    if($('#new_line_man').val() == null || $('#new_line_man').val() ==""){
        show_faded_alert('new_line_man','Please Enter ManufactureId');
        return false;
    }
    if($('#new_line_des').val() == null || $('#new_line_des').val() ==""){
        show_faded_alert('new_line_des','Please Enter Description');
        return false;
    }
    if (!is_numeric($('#new_line_unit_price').val())) {
       show_faded_alert('new_line_unit_price','Please Enter Number In UnitPrice');
        return false;
    }
    if($('#new_line_unit_price').val() == null || $('#new_line_unit_price').val() ==""){
        show_faded_alert('new_line_unit_price','Please Enter UnitPrice');
        return false;
    }
    if (!is_numeric($('#new_line_qty').val())) {
        show_faded_alert('new_line_qty','Please Enter Number In Quantity');
        return false;
    }
    if($('#new_line_qty').val() == null || $('#new_line_qty').val() ==""){
        show_faded_alert('new_line_qty','Please Enter Quantity');
        return false;
    }
 
    _this.onclick = function(event) {
        event.preventDefault();
  }
  
    $.ajax({

        type: "post",

        url: mainUrl + "order_quotation/Quotation/quotationNewLine",

        cache: false,

        data: {CustomerID:userId,quoNumber:quoNumber,'new_line_man':$('#new_line_man').val(),'new_line_des':$('#new_line_des').val(),'new_line_unit_price':$('#new_line_unit_price').val()
            ,'new_line_qty':$('#new_line_qty').val()

        },

        dataType: 'json',

        success: function (data) {
            window.location.reload();
        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('There is some error in  Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });
}


function orderNewLine(quoNumber,userId) {

    if($('#new_line_man').val() == null || $('#new_line_man').val() ==""){
        show_faded_alert('new_line_man','Please Enter ManufactureId');
        return false;
    }
    if($('#new_line_des').val() == null || $('#new_line_des').val() ==""){
        show_faded_alert('new_line_des','Please Enter Description');
        return false;
    }
    if (!is_numeric($('#new_line_unit_price').val())) {
        show_faded_alert('new_line_unit_price','Please Enter Number In UnitPrice');
        return false;
    }
    if($('#new_line_unit_price').val() == null || $('#new_line_unit_price').val() ==""){
        show_faded_alert('new_line_unit_price','Please Enter UnitPrice');
        return false;
    }
    if (!is_numeric($('#new_line_qty').val())) {
        show_faded_alert('new_line_qty','Please Enter Number In Quantity');
        return false;
    }
    if($('#new_line_qty').val() == null || $('#new_line_qty').val() ==""){
        show_faded_alert('new_line_qty','Please Enter Quantity');
        return false;
    }

    $.ajax({

        type: "post",

        url: mainUrl + "order_quotation/Order/orderNewLine",

        cache: false,

        data: {CustomerID:userId,quoNumber:quoNumber,'new_line_man':$('#new_line_man').val(),'new_line_des':$('#new_line_des').val(),'new_line_unit_price':$('#new_line_unit_price').val()
            ,'new_line_qty':$('#new_line_qty').val()

        },

        dataType: 'json',

        success: function (data) {
            window.location.reload();
        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('There is some error in  Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });
}
function updateQuotationNewLine(id,serialNumber,userId) {
    var qty = $('#update_line_qty'+id).val();
    var  brnds = $('#brnds' + serialNumber).val();

    /*var minQty = $("input[data-min_qty_integrated='+ serialNumber +']").val();
    minQty = (minQty ? minQty : 25);
    var maxQty = $("input[data-max_qty_integrated='+ serialNumber +']").val();
    maxQty = (maxQty ? maxQty : 50000);

    if (qty < minQty && brnds !== "Roll Labels") {
        swal("Minimum quantity should be " + minQty + " at least!",
            {
                buttons: {
                    cancel: "OK",
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        );
        // $('#update_line_qty'+id).val(minQty);

        return false;
    }

    if (qty > maxQty && brnds !== "Roll Labels") {
        swal("Maximum quantity cannot exceed "+ maxQty +" limit!",
            {
                buttons: {
                    cancel: "OK",
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        );
        // $('#update_line_qty'+id).val(maxQty);

        return false;
    }*/

    $.ajax({

        type: "post",

        url: mainUrl + "order_quotation/Quotation/updateQuotationNewLine",

        cache: false,

        data: {userId:userId,serialNumber:serialNumber,'update_line_man':$('#update_line_man'+id).val(),'update_line_des':$('#update_line_des'+id).val(),'update_line_unit_price':$('#update_line_unit_price'+id).val()
            ,'update_line_qty':$('#update_line_qty'+id).val()

        },

        dataType: 'json',

        success: function (data) {
            window.location.reload();
        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('There is some error in  Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });
}

function updateOrderNewLine(id,serialNumber,userId) {

    $.ajax({

        type: "post",

        url: mainUrl + "order_quotation/Order/updateOrderNewLine",

        cache: false,

        data: {userId:userId,serialNumber:serialNumber,'update_line_man':$('#update_line_man'+id).val(),'update_line_des':$('#update_line_des'+id).val(),'update_line_unit_price':$('#update_line_unit_price'+id).val()
            ,'update_line_qty':$('#update_line_qty'+id).val()

        },

        dataType: 'json',

        success: function (data) {
            window.location.reload();
        },

        error: function (jqXHR, exception) {

            if (jqXHR.status === 500) {

                alert('There is some error in  Values...');

            } else {

                alert('Error While Requesting...');

            }

        }

    });
}

function showNwLine() {
    $('#hideNwLine').show();
    $('#showNwLine').hide();
    $('#tr_for_nw_line').show();
}

function hideNwLine() {
    $('#showNwLine').show();
    $('#hideNwLine').hide();
    $('#tr_for_nw_line').hide();
}

$(document).on("click",".new_filter .dm-selector .dropdown-menu a",function(e){
    var value = $(this).data('value');
    var type = $(this).data('id');
    var unsorted = "<i class='fa fa-unsorted'></i>"
    var input_value = "";
    if(value == "reset" || value == "resetall")
    {
        $(this).parents(".new_filter").find(".color-d-down").find(".dropdown-toggle").addClass("disabled");
        if(type == "material")
        {
            value = "Sort By Material";
        }
        else
        {
            value = "Sort By Colour";
        }

        $(this).parents(".new_filter").find(".material-d-down").find(".dropdown-toggle").html("Sort By Material"+unsorted);
        $(this).parents(".new_filter").find(".color-d-down").find(".dropdown-toggle").html("Sort By Colour"+unsorted);

        $(this).parents(".new_filter").find("#material_mat").val(input_value);
        $(this).parents(".new_filter").find("#color_mat").val(input_value);

    }
    else
    {
        $(this).parents(".new_filter").find("."+type+"-d-down").find(".dropdown-toggle").html(value+unsorted);
        $(this).parents(".new_filter").find("#"+type+"_mat").val(value);
        $(this).parents(".new_filter").find(".color-d-down").find(".dropdown-toggle").removeClass("disabled");
    }
    if(type == "material")
    {
        $(this).parents(".new_filter").find(".color-d-down").find(".dropdown-toggle").html("Sort By Colour"+unsorted);
        $(this).parents(".new_filter").find("#color_mat").val('');
    }
    fetch_category_mateials();

});

function changelabels(qty,labelPerRoll,id) {
    $('#totalLabels'+id).val(qty*labelPerRoll);
}

function show_updt_btn(key) {
	
	var chk = $('#save'+key).is(":visible");
	if(chk!=false){
	}else{
		$('#updp_btn'+key).show();
	}
	
	//$('#updp_btn'+key).show();
}




function checkcart(ProductBrand, qty, batch, ManufactureID, Printing, dataNo) {
    //alert(dataNo);


    if (ProductBrand == "Integrated Labels" || ProductBrand == "Roll Labels") {


        if (ProductBrand == "Integrated Labels") {

            var minroll = $('[data-min_qty_integrated=' + dataNo + ']').attr('value');
            var maxroll = $('[data-max_qty_integrated=' + dataNo + ']').attr('value');


            minqty = parseInt(minroll);
            maxqty = parseInt(maxroll);
            qty = parseInt(qty);
            pack = parseInt(batch);


            minqty = pack;
            if (qty < minqty) {
                //alert("Please enter quantity from "+minqty);
                swal("Warning!", "Please enter quantity from " + minqty, "warning");
                $('[data-qty=' + dataNo + ']').val(minqty);
                return false;
            }
            else if (qty % minqty != 0) {
                var multipyer = minqty * parseInt(parseInt(qty / minqty) + 1);
                if (multipyer > maxqty) {
                    multipyer = maxqty;
                }

                //alert("Sorry, these labels are only available in sets of "+minqty+" sheets Pack.");
                swal("Warning!", "Sorry, these labels are only available in sets of " + minqty + " sheets Pack.", "warning");
                $('[data-qty=' + dataNo + ']').val(multipyer);
            }
        }


        if (ProductBrand == "Roll Labels") {
            if (Printing == "Y") {


                var pmin = $('[data-calulate_min_rolls=' + dataNo + ']').attr('value');
                var pmax = $('[data-calulate_max_rolls=' + dataNo + ']').attr('value');

                minqty = pmin;
                maxqty = pmax;
                if (qty < minqty || qty > maxqty) {
                    //alert("Please enter quantity from "+minqty+" to "+maxqty);
                    swal("Warning!", "Please enter quantity from " + minqty + " to " + maxqty, "warning");
                    return false;
                } else if (qty % minqty != 0) {
                    var multipyer = minqty * parseInt(parseInt(qty / minqty) + 1);
                    if (multipyer > 800) {
                        multipyer = 800;
                    }
                    //alert("Sorry, these labels are only available in sets of "+minqty+" rolls.");
                    swal("Warning!", "Sorry, these labels are only available in sets of " + minqty + " rolls.", "warning");
                    
                    $('[data-qty=' + dataNo + ']').val(multipyer);
                    //$(this).val(multipyer);
                    return false;
                }
            }
        }

    } else {


        if (ProductBrand == 'SRA3 Label') {
            minqty = 100;
            maxqty = 100000000;
            var msg = "Minimum Quantity Should be 100 !";
            var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
        }
        else if (ProductBrand == 'Application Labels') {
            minqty = 1;
            maxqty = 100000000;
            var msg = "Minimum Quantity Should be 1 !";
            var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
        }
        else if (ProductBrand == 0) {
            minqty = 1;
            maxqty = 100000000;
            var msg = "Minimum Quantity Should be 1 !";
            var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
        }
        
        else {
            maxqty = 100000000;
            minqty = 25;
            var msg = "Minimum Quantity Should be 25 !";
            var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
        }


        if (qty < parseInt(minqty)) {
            //alert(msg);
            swal("Warning!", msg, "warning");
            $('[data-qty=' + dataNo + ']').val(minqty);
            //$("#"+ID).val(minqty);
        }
        else if (qty > parseInt(maxqty)) {
            //alert(max_msg);
            swal("Warning!", max_msg, "warning");
            //$('[data-qty='+dataNo+']').val(multipyer);
        }
    } 
}


 $(document).on("click", ".save_artwork_file_oldss", function(e) {

	var _this = this;
	var cartid = $('#cartid').val();
	var prdid = $('#cartproductid').val();
	var labelpersheets = $('#labels_p_sheet').val();
	var type = 'a4';
	var cartunitqty = $('#cartunitqty').val();
	var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
	var file = $(_this).parents('.upload_row').find('.artwork_file').val();
	var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];
	var response = '';
	var img_exi = $(_this).parents('.upload_row').find('.chkimg').val();
						
	var batch = parseInt($('.tabprinted').find('.plainsheet_unit').text());
	var min_qty = batch;
	var max_qty = 500000;
	var box_inp = $(_this).parents('.upload_row').find('.labels_input');
						 
					
	
	if(isNaN(batch)){
					
		if(cartunitqty == 'Labels'){
			var labels = $(_this).parents('.upload_row').find('.labels_input').val();
			if(labels.length==0){
				var id =$(_this).parents('.upload_row').find('.labels_input');
				var popover =  $(_this).parents('.upload_row').find('.popover').length;
				if(popover == 0){
					show_faded_popover(id, "Minimum "+labelpersheets+" labels are required ");
				}
				return false;
			}
			var sheets = parseInt(labels/labelpersheets);
			var lb_txt = 'labels';
			
		}else{
							
			var mins = $('.min_qty').text();
			var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
								
			if(sheets.length==0){
				
				var id =$(_this).parents('.upload_row').find('.labels_input');
				var popover =  $(_this).parents('.upload_row').find('.popover').length;
				
				if(popover == 0){
					show_faded_popover(id, "Minimum 1 sheet requireds ");
					//return false;
				}
				return false;
			}
			var labels = parseInt(sheets*labelpersheets);
			var lb_txt = 'sheets';
		}
			
		
	} else{
							
		if(cartunitqty == 'Labels'){
			var labels = $(_this).parents('.upload_row').find('.labels_input').val();
			if(labels.length==0 || labels == 0 || labels == ''){ 
				var id =$(_this).parents('.upload_row').find('.labels_input');
				var popover =  $(_this).parents('.upload_row').find('.popover').length;
				if(popover == 0){
					show_faded_popover(id, "Minimum "+labelpersheets+" labels are required ");
				}
				return false;
			}
			var sheets = parseInt(labels/labelpersheets);
			var lb_txt = 'labels';
		}else{
			var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
			if(sheets.length==0 || sheets == 0 || sheets == ''){ 	 
				var id =$(_this).parents('.upload_row').find('.labels_input');
				var popover =  $(_this).parents('.upload_row').find('.popover').length;
				if(popover == 0){
					show_faded_popover(id, "Minimum 1 sheet required ");	
				}else{
					box_inp.val(batch);
				}
				return false;
			}
			var labels = parseInt(sheets*labelpersheets);
			var lb_txt = 'sheets';
		}
					
					
	
		if(sheets == NaN || box_inp.val() == '')
		{
			box_inp.val(batch);
			show_faded_popover(box_inp, "Minimum "+batch+" sheets allowed");
			return false;
		}
		else if(sheets < min_qty)
		{
			show_faded_popover(box_inp, "Minimum "+batch+" sheets allowed");
			box_inp.val(min_qty);
			$(".labels_input").trigger("blur");
			return false;
		}
		else if(sheets > max_qty)
		{
			box_inp.val(max_qty);
			show_faded_popover(box_inp, "Maximum "+max_qty+" sheets allowed");
			$(".labels_input").trigger("blur");
			return false;
		}
	
		if(sheets%batch != 0)
		{
		if(batch == 250)
		{
			sheets = Math.ceil(sheets/250)*250;
		}
		else
		{
			sheets = Math.ceil(sheets/1000)*1000;
		}
		$(box_inp).val(sheets);
		show_faded_popover(box_inp, "Quantity has been round off to "+sheets);
		labels = parseInt(sheets*labelpersheets);
		$(".labels_input").trigger("blur");
		return false;
		}
		
	}
   
   
    /*var integr = $('#newcategory').val();
  	var boxs = $(_this).parents('.upload_row').find('.labels_input').val();
    //alert(integr+''+boxs);
    if(integr=='A4'){
    
    if(boxs < 25)
    {
      sheets = '25';
      $(_this).parents('.upload_row').find('.labels_input').val(25);
      show_faded_popover('labels_input', "Quantity has been round off to 25");
    }
  }
  
  if(integr=='A3'){
    if(boxs < 25)
    { 
      sheets = '100';
      $(_this).parents('.upload_row').find('.labels_input').val(100);
      show_faded_popover('labels_input', "Quantity has been round off to 100");
    }
  }
  
  if(integr=='SRA3'){
    if(boxs < 100){
       sheets = '100';
      $(_this).parents('.upload_row').find('.labels_input').val(100);
      show_faded_popover('labels_input', "Quantity has been round off to 100");
    }
  }*/
   
   
   
					
	var is_follow  = $(_this).parents('.upload_row').find('.follow_arts').prop("checked");
	//var is_follow=   $('#follow_art'+id).prop("checked");
	//alert(is_follow);
	
	if(is_follow!=true ){
		if(file.length==0){
			alert_box("Please upload a file before saving. ");
		}
	}
	
	if(labels==0 || labels==''){
		alert_box("Please complete line ");
	}
	else if(artworkname.length==0){
		alert_box("please enter artwork name! ");
	}
	else{
		var form_data = new FormData();
		if(is_follow!=true ){
			form_data.append("file", uploadfile);
		} 
		form_data.append("cartid",cartid);
		form_data.append("productid",prdid);
		form_data.append("labels",labels);
		form_data.append("sheets",sheets);
		form_data.append("artworkname",artworkname);
		form_data.append("persheet",labelpersheets);
		form_data.append("type",type);
		form_data.append("unitqty",cartunitqty);
		
		if(is_follow==true ){
			type = "bypass";
		}else{
			type = uploadfile.type;
		}
		
		//alert(type);

		if(type != 'image/tiff' && type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript' && type!="bypass") {

			swal("Not Allowed","We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG","warning");
			return false;
		}else{
			upload_printing_artworks(form_data);
			$('#no_artworks_'+prdid).val(0);
		}
	}
});






$(document).on("click", ".sheet_updater_old", function(event) {
	
	var id = $(this).attr('data-id');
	var _this = this;
	var cartid = $('#cartid').val();
	var prdid = $('#cartproductid').val();
	var labelpersheets = $('#labels_p_sheet').val();
	var type = 'a4';
	//var cartunitqty = $('#cartunitqty').val();
	var cartunitqty = "Sheets";
	
	
	 
   //var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
   var file = $(_this).parents('.upload_row').find('.artwork_file').val();
   
   var response = '';
	
	
	var batch = parseInt($('.tabprinted').find('.plainsheet_unit').text());
	var min_qty = batch;
	var max_qty = 500000;
	var box_inp = $(_this).parents('.upload_row').find('.labels_input');
	
	var artwork_name = $(_this).parents(".upload_row").find(".artwork_name").val();
	var artwork_field = $(_this).parents(".upload_row").find(".artwork_name");
	
	//alert(batch);
						
						//if(batch=="NAN" || batch=="NaN"){
							if(isNaN(batch)){
							 
							//alert('if');
					
            if(cartunitqty == 'Labels'){
                var labels = $(_this).parents('.upload_row').find('.labels_input').val();
                if(labels.length==0){
                    var id =$(_this).parents('.upload_row').find('.labels_input');
                    var popover =  $(_this).parents('.upload_row').find('.popover').length;
                    if(popover == 0){
                        show_faded_popover(id, "Minimum "+labelpersheets+" labels are required ");
                    }
                    return false;
                }
                var sheets = parseInt(labels/labelpersheets);
                var lb_txt = 'labels';
            }else{
							
							var mins = $('.min_qty').text();
							var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
							
							if(sheets.length==0){

								var id =$(_this).parents('.upload_row').find('.labels_input');
								var popover =  $(_this).parents('.upload_row').find('.popover').length;

								if(popover == 0){
									show_faded_popover(id, "Minimum 1 sheet requireds ");
									      //return false;
                    }
                    return false;
								}
							  var labels = parseInt(sheets*labelpersheets);
                var lb_txt = 'sheets';
            }
							
											
							
						} else{
	

	if(artwork_name == "")
	{
		show_faded_popover(artwork_field, "Please enter artwork name");
		return false;
	}
	
	
	
	
	if(cartunitqty == 'Labels'){
		var labels = $(_this).parents('.upload_row').find('.labels_input').val();
		if(labels.length==0 || labels == 0 || labels == ''){ 
			var id =$(_this).parents('.upload_row').find('.labels_input');
			var popover =  $(_this).parents('.upload_row').find('.popover').length;
			if(popover == 0){
				show_faded_popover(id, "Minimum "+labelpersheets+" labels are required ");
			}
			return false;
		}
			var sheets = parseInt(labels/labelpersheets);
	}else{
			var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
			if(sheets.length==0 || sheets == 0 || sheets == ''){ 	 
				var id =$(_this).parents('.upload_row').find('.labels_input');
				var popover =  $(_this).parents('.upload_row').find('.popover').length;
				if(popover == 0){
					show_faded_popover(id, "Minimum 1 sheet required ");	
				}else{
					box_inp.val(batch);
				}
				return false;
			}
			var labels = parseInt(sheets*labelpersheets);
	}
	
	if(sheets == NaN || box_inp.val() == '')
	{
		box_inp.val(batch);
		show_faded_popover(box_inp, "Minimum "+batch+" sheets allowed");
		return false;
	}
	else if(sheets < min_qty)
	{
		show_faded_popover(box_inp, "Minimum "+batch+" sheets allowed");
		box_inp.val(min_qty);
		$(".labels_input").trigger("blur");
		return false;
	}
	else if(sheets > max_qty)
	{
		box_inp.val(max_qty);
		show_faded_popover(box_inp, "Maximum "+max_qty+" sheets allowed");
		$(".labels_input").trigger("blur");
		return false;
	}
	
	if(sheets%batch != 0)
	{
		if(batch == 250)
		{
			sheets = Math.ceil(sheets/250)*250;
		}
		else
		{
			sheets = Math.ceil(sheets/1000)*1000;
		}
		$(box_inp).val(sheets);
		show_faded_popover(box_inp, "Quantity has been round off to "+sheets);
		labels = parseInt(sheets*labelpersheets);
		$(".labels_input").trigger("blur");
		return false;
	}
        
        
 
	
	
						}
  
         /*var integr = $('#newcategory').val();
  	var boxs = $(_this).parents('.upload_row').find('.labels_input').val();
    //alert(integr+''+boxs);
    if(integr=='A4'){
    
    if(boxs < 25)
    {
      sheets = '25';
      $(_this).parents('.upload_row').find('.labels_input').val(25);
      show_faded_popover('labels_input', "Quantity has been round off to 25");
    }
  }
  
  if(integr=='A3'){
    if(boxs < 25)
    { 
      sheets = '100';
      $(_this).parents('.upload_row').find('.labels_input').val(100);
      show_faded_popover('labels_input', "Quantity has been round off to 100");
    }
  }
  
  if(integr=='SRA3'){
    if(boxs < 100){
       sheets = '100';
      $(_this).parents('.upload_row').find('.labels_input').val(100);
      show_faded_popover('labels_input', "Quantity has been round off to 100");
    }
  }*/
	
	$.ajax({
				url: mainUrl + 'search/Search/update_material_artworks',
				type:"POST",
				async:"false",
				dataType: "html",
				data:{
					 id:id,
					 cartid:cartid,
					 productid:prdid,
					 labels:labels,
					 sheets:sheets,
					 persheet:labelpersheets,
					 type:type,
					 unitqty:cartunitqty,
					 artwork_name:artwork_name,
				},
				success: function(data){
					data = $.parseJSON(data); 	
					if(!data==''){
						update_printed_quantity_box(data.qty, data.designs);
						$('#ajax_upload_content').html(data.content);
						intialize_progressbar();
					}
				 }  
		});
});


var old_labels_input;
var old_roll_labels_input;
var old_roll_input;

$(document).on("focus", ".labels_input", function(e) {
	old_labels_input = $(this).val();
});


$(document).on("keypress keyup blur", ".labels_input", function(e) {
		if($(this).val()!=old_labels_input){
			$(this).parents('.upload_row').find('.sheet_updater').show();
		}
});


$(document).on("click", ".remove_image_link", function(e) {
	$("#preview_po_img").trigger("click");
});

    function noteForCart(key,cart_id) {
        $('#order_note_line' + key).show();
    }
    
     function insertNoteForCart(id, cart_id) {

        var status = $('#note_for_od' + id).val();

        if (status == null || status == "") {
            show_faded_alert('note_for_od' + id, 'please insert the note first...');
            return false;
        }

        $.ajax({
            type: "post",
            url: mainUrl + "cart/cart/update_note",
            cache: false,
            data: {'Line': cart_id, 'status': status},
            dataType: 'json',
            success: function (data) {
                if (data.res == 'true') {
					 swal("Added","Production note added succesfully","success");
                    //window.location.reload();
					 //var status = $('#note_for_od' + id).val(status//);
					
                }
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    }


   function deleteNoteForCart(key,serialNumber) {
        swal(
            "Are You Sure You Want To Delete This Line",
            {
                buttons: {
                    cancel: "No",
                    catch: {
                        text: "Yes",
                        value: "catch",
                    },
                },
                icon: "warning",
                closeOnClickOutside: false,
            },
        ).then((value) => {
            switch (value) {
                case "catch":
					
					
                    $.ajax({
                        type: "post",
                        url: mainUrl + "cart/cart/update_note",
                        cache: false,
                        data: {'Line': serialNumber, 'status': 'Delete'},
                        dataType: 'json',
                        success: function (data) {
                            if (data.res == 'true') {
								 $('#note_for_od' + key).val('');
								 $('#order_note_line' + key).hide();
								swal("Added","Production note removed succesfully","success");
                                //window.location.reload();
                            }

                        },
                        error: function (jqXHR, exception) {
                            if (jqXHR.status === 500) {
                                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                            } else {
                                alert('Error While Requesting...');
                            }
                        }
                    });
                    break;
            }

        });

    }
    
    
    
    function updateMaterialPriceRolls(mainTrId,flexId,matId,format) {

   
	var quantity 	 = $('#matqty'+matId).val();
	var mattype 	 = $('#prnt_dropdown_'+matId).val();
	var design 		 = $('#designmat'+matId).val();
	var lables 		 = $('#labelsmat'+matId).val();
	var core 		 = $('#core_'+matId).val();
	var wound 		 = $('#wound_'+matId).val();
	var plain_print  = $('#mat_print'+matId).val();
	var finish 		 = $('#finishdropdown_'+matId).val();
	var pageName 	 = $('#mypageName').val();
	
	var width_die 	 = $('#width_die'+matId).val();
	var height_die 	 = $('#height_die'+matId).val();
	var shape 	 	 = $('#shape'+matId).val();
	
	var max_roll 	 = $('#max_roll'+matId).val();
	var max_lb 	 	 = $('#max_lb'+matId).val();
	var max_roll_qty = $('#max_roll_qty'+matId).val();



        /*alert(quantity);
        alert(lables);*/
    var org_labels = lables;
	/*if(plain_print=="plain" && format=="Roll"){
       lables = quantity * lables;
    }*/


	//alert(lables);
	if(validationForCustomDies(format,quantity,matId,plain_print,mattype,design,core,wound,lables,finish,max_roll,max_lb,max_roll_qty,shape)){
		$('#aa_loader').show();
		
		$.ajax({
			url: mainUrl + 'search/search/calculate_roll_price_new',
            type: "POST",
            async: "false",
			dataType: 'json',
            data: {
				roll:quantity,
				labels: lables,
                labelfinish: finish,
                printing: mattype,
                size: core,
				matId:matId,
				wound: wound,
				die_width:width_die,
				die_height:height_die,
				shape:shape,
				is_custom_Wh:true,
				formats:format,
				design: design,
                org_labels: org_labels

            
            },
			
            success: function (data) {
				
				$('#aa_loader').hide();
				
				//alert(data.response);
				
				if(data.response == 'yes'){
					
					if(pageName == 'quotation'){
						window.location.reload();
					}else{
						//alert('else');
						$('#products_list').empty();
						$('#products_list').html(data.html);
						//update_topbasket();
					}
				}
            }
        });
	}
}



function updateNewMaterialSheets(mainTrId,flexId,matId,format) {

   
	var quantity 	= $('#matqty'+matId).val();
	var lables 		= $('#max_lb'+matId).val();
	var plain_print = $('#mat_print'+matId).val();
	var pageName 	= $('#mypageName').val();
	var min_sheet	= $('#min_sheet'+matId).val();
	
	var die_code	= $('#die_code'+matId).val();
	var proID		= $('#productid'+matId).val();
	var printing 	= $('#prnt_dropdown_'+matId).val();
	var printing 	= $('#prnt_dropdown_'+matId).val();
	var designs 	= $('#designmat'+matId).val();

	$enb = "";
	if(plain_print=="plain"){
		$enb = "enabled";
	}
	
    if(parseInt(quantity) < parseInt(min_sheet)){
	
		$('#matqty'+matId).val(min_sheet);
        show_faded_alert('matqty'+matId, 'Quantity has been amended for production as '+min_sheet+' sheets.');
        return false;
    }
		
		$('#aa_loader').show();
		
		$.ajax({
			url: mainUrl + 'search/search/calculate_sheet_priceCustomDiesSheets',
            type: "POST",
            async: "false",
			dataType: 'json',
			data: {
				qty:quantity,
				menuid : die_code,
				prd_id : proID,
				labels: lables,
				labeltype : plain_print,
				matId:matId,
				printprice :$enb,
				printing  : printing,
				cart_id : "",
				designs :designs,
				formats:format

				
			},
			
            success: function (data) {
				
				$('#aa_loader').hide();
				
				//alert(data.response);
				
				if(data.response == 'yes'){
					
					if(pageName == 'quotation'){
						window.location.reload();
					}else{
						//alert('else');
						$('#products_list').empty();
						$('#products_list').html(data.html);
						update_topbasket();
					}
				}
            }
        });
	
}


function validationForCustomDies(format,qty,matid,plain_print,mattype,design,core,wound,lables,finish,max_roll,max_lb,max_rol_qty,shape) {
    
    
    lables = $('#labelsmat'+matid).val();

    alert(lables)




    /*$.ajax({
        url: mainUrl + 'search/search/calculate_max_allowed_roll',
        type: "POST",
        async: "false",
        dataType: 'json',
        data: {
            roll:quantity,
            labels: lables,
            labelfinish: finish,
            printing: mattype,
            matId:matId,



        },

        success: function (data) {

            $('#aa_loader').hide();



            if(data.response == 'yes'){

                if(pageName == 'quotation'){
                    window.location.reload();
                }else{
                    //alert('else');
                    $('#products_list').empty();
                    $('#products_list').html(data.html);
                    update_topbasket();
                }
            }
        }
    });*/




	if(format !='Roll'){

		if(plain_print == 'plain'){

			if( (format == 'A4' || format == 'A5') && (qty <25 || qty >50000)){

				if(qty <25){
					
					show_faded_alert('matqty'+matid,'Minimum Sheet Quantity must be 25');
					$('#matqty'+matid).val(25);
				}else if(qty >50000){

					show_faded_alert('matqty'+matid,'Maximum Sheet Quantity must be 50000');
					$('#matqty'+matid).val(50000);
				}
				return false;
			}

			if((format === 'A3' || format === 'SRA3') && (qty <100 || qty >50000)){
				if(qty <100){
					show_faded_alert('matqty'+matid,'Enter Quantity must 100');
					$('#matqty'+matid).val(100);
				}else if(qty >50000){
					show_faded_alert('matqty'+matid,'Maximum Sheet Quantity must be 50000');
					$('#matqty'+matid).val(50000);
				}
				return false;
			}
			return true;
		}
		else{
			if(mattype == "" || mattype == null){
				show_faded_alert('prnt_dropdown_'+matid,'Please Select Printing');
				return false;
			}
			if(design == 0 || design == "" || design == null){
				show_faded_alert('designmat'+matid,'Please Enter Design');
				return false;
			}
			if(qty ==0 || qty =="" || qty == null){
				
				show_faded_alert('matqty'+matid,'Please Enter Quantity');
				$('#matqty'+matid).val(0);
				return false
			}
			return true;
		}

	}else{
	    
	     
		if(plain_print == 'plain'){
			if(core == 0 || core == "" || core == null){
				show_faded_alert('core_'+matid,'Please Select Core Size');
				return false;
			}
			
			if(wound == 0 || wound == "" || wound == null){
				show_faded_alert('wound_'+matid,'Please Select Wound');
				return false;
			}
			
			/*if(design == 0 || design == "" || design == null){
				show_faded_alert('designmat'+matid,'Please Enter Design');
				return false;
			}*/
			
			//alert(lables);
			
			if(lables == 0 || lables == "" || lables == null){
				show_faded_alert('labelsmat'+matid,'Please Enter Labels Per Roll');
				return false;
			}

			if(qty ==0 || qty =="" || qty == null){
				
				show_faded_alert('matqty'+matid,'Please Enter Quantity');
				$('#matqty'+matid).val(0);
				return false
			}
		
	 if(shape!='Irregular'){

			if (!is_numeric(lables) || lables < 100) {
                alert('6');
				 $('#labelsmat'+matid).val(100);
				show_faded_alert('labelsmat'+matid, 'Quantity has been amended for production as 100 labels.');
				return false;
			}

			else if (!is_numeric(lables) || parseFloat(lables / qty) > parseInt(max_lb)) {
				alert('1');
				alert(max_lb);
				alert(parseFloat(lables / qty));
				var well = max_lb * qty;
				$('#labelsmat'+matid).val(well);
				
				show_faded_alert('labelsmat'+matid, 'Quantity has been amended for production as ' + well + ' labels.');
				return false;
			}

			else if (!is_numeric(qty) || qty < parseInt(max_roll)) {
                alert('2');
				$('#matqty'+matid).val(max_roll);
				show_faded_alert('matqty'+matid, 'Quantity has been amended for production as ' + max_roll + ' rolls.');
				return false;
			}

			else if (!is_numeric(qty) || qty > parseInt(max_rol_qty)) {
                alert('3');
				$('#matqty'+matid).val(max_rol_qty);
				show_faded_alert('matqty'+matid, 'Quantity has been amended for production as ' + max_rol_qty + ' rolls.');
				return false;
			}
			
			else if (qty % max_roll != 0 && max_roll!="") {
                alert('5');
				//alert(min_qty);
				if (qty % max_roll != 0) {
					
					var multipyer = max_roll * parseInt(parseInt(qty / max_roll) + 1);

					if (multipyer > max_rol_qty) {
						multipyer = max_rol_qty;
					}
					//input_roll.val(multipyer);
					$('#matqty'+matid).val(multipyer);

				}
				show_faded_alert('matqty'+matid, "Sorry! these labels are only available in sets of " + max_roll + " rolls. ");
				return false;
			}
	     }	
			return true;
		}else{
			
			if(mattype == "" || mattype == null){
				show_faded_alert('prnt_dropdown_'+matid,'Please Select Printing');
				return false;
			}
			
			if(finish == 0 || finish == "" || finish == null){
				show_faded_alert('finishdropdown_'+matid,'Please Select Finish');
				return false;
			}
			
			if(core == 0 || core == "" || core == null){
				show_faded_alert('core_'+matid,'Please Select Core Size');
				return false;
			}
			
			if(wound == 0 || wound == "" || wound == null){
				show_faded_alert('wound_'+matid,'Please Select Wound');
				return false;
			}
			
				if(design == 0 || design == "" || design == null){
				show_faded_alert('designmat'+matid,'Please Enter Design');
				return false;
			}
			
			if(lables == 0 || lables == "" || lables == null){
				show_faded_alert('labelsmat'+matid,'Please Enter Labels Per Rolls');
				return false;
			}
			
			
		
			
			if(qty ==0 || qty =="" || qty == null){
				
				show_faded_alert('matqty'+matid,'Please Enter Quantity');
				$('#matqty'+matid).val(0);
				return false
			}
			
			var shp_es = $('#shape'+matid).val();
		 
		 if(shape!='Irregular'){
		     
			if (lables < 100 && parseInt(max_lb) > 100 && shp_es !='Irregular') {
				 $('#labelsmat'+matid).val(100);
				show_faded_alert('labelsmat'+matid, 'Quantity has been amended for production as 100 labels.');
				return false;
			}

			else if ((!is_numeric(lables) || parseInt(lables / qty) > parseInt(max_lb)) && shp_es !='Irregular') {
				
				//alert(lables / qty +' ---- '+max_lb);
				
				
				var well = max_lb * qty;
				$('#labelsmat'+matid).val(well);
				show_faded_alert('labelsmat'+matid, 'Quantity has been amended for production as ' + well+ ' labels.');
				return false;
			}

			/*else if (!is_numeric(qty) || qty < parseInt(max_roll)) {
				$('#matqty'+matid).val(max_roll);
				show_faded_alert('matqty'+matid, 'Quantity has been amended for production as ' + max_roll + ' rolls.');
				return false;
			}*/

			else if (!is_numeric(qty) || qty > parseInt(max_rol_qty)) {
				$('#matqty'+matid).val(max_rol_qty);
				show_faded_alert('matqty'+matid, 'Quantity has been amended for production as ' + max_rol_qty + ' rolls.');
				return false;
			}
			
			else if (qty % max_roll != 0) {
				//alert(min_qty);
				var multipyer = max_roll * parseInt(parseInt(qty / max_roll) + 1);
				
				
				if (multipyer > parseInt(max_rol_qty)) {
				if (qty % max_roll != 0) {
					
					

					if (multipyer > max_rol_qty) {
						multipyer = max_rol_qty;
					}
					//input_roll.val(multipyer);
					$('#matqty'+matid).val(multipyer);

				}
					show_faded_alert('matqty'+matid, "Sorry! these labels are only available in sets of " + max_roll + " rolls.");
					return false;
				}
				
			}
		 }	
			
			return true;
		}

    }



}

    $(document).on("change", ".follow_art", function(event) {  
	 
	var id = $(this).attr('data-countLine');
	if(this.checked){
		$('#Artworkfollow'+id).show();
		$('#ArtworkWrapper'+id).hide();
		$('#artworkimage'+id).hide();
		$('#preview_po_img'+id).hide();
		$('#preview_po_img'+id).attr('src','');
	}else{
		$('#Artworkfollow'+id).hide();
		$('#ArtworkWrapper'+id).show();
		$('#artworkimage'+id).val('');
		$('#artworkimage'+id).show();
		$('#preview_po_img'+id).hide();
		$('#preview_po_img'+id).attr('src','');
	}
	//changeStatus(id);
});

$(document).on("change", ".follow_arts", function(event) {  
	 
	if(this.checked){
		 
		$(this).parents('.upload_row').find('.Artworkfollow').show();
		$(this).parents('.upload_row').find('.upload-btn-wrapper').hide();
		$(this).parents('.upload_row').find('.artwork_file').hide();
		
		$(this).parents('.upload_row').find('#preview_po_img').hide();
		$(this).parents('.upload_row').find('#preview_po_img').attr('src','');
		 
	}else{
		$(this).parents('.upload_row').find('.Artworkfollow').hide();
		$(this).parents('.upload_row').find('.upload-btn-wrapper').show();
		$(this).parents('.upload_row').find('.artwork_upload_cta').show();
		$(this).parents('.upload_row').find('.artwork_file').val('');
		$(this).parents('.upload_row').find('.artwork_file').show();
		$(this).parents('.upload_row').find('#preview_po_img').hide();
		$(this).parents('.upload_row').find('#preview_po_img').attr('src','');
	}
	//changeStatus(id);
});
    
function check_wtp_voucher(){
	
  var voucher = $.trim($("#voucher_code").val());
  var grand_total = $("#grand_total_voucher").val();
	
  if(voucher!=='' && voucher!==' '){
        
    $.ajax({

      url: mainUrl+'order_quotation/quotation/get_wtp_vouvher_auth',
      type:"POST",
      async:"false",
      data:{'voucher':voucher,'GrandTotal':grand_total},
      dataType: "json",
      success: function(data){
        if(data.is_error=='no'){
          checkout();
					
        }else{
          show_faded_alert('voucher_code', "Please Enter a valid voucher code");
        }
      }  
    });
  }else{
    show_faded_alert('voucher_code', "Please provide voucher code");
  }
}


function hide_wtp_voucher_box(){
	
  $.ajax({
    url: mainUrl+'order_quotation/quotation/remove_wtp_voucher_offer',
    type:"POST",
				async:"false",
				dataType: "json",
				success: function(data){
      if(data.is_error=='no'){
        checkout();
      }
    }
  });
  }




function show_no_artwork(){    
    $('#with_artwork_tbl').hide();
    $('.yes_art_btn').show();
    
    $('#no_img_artwork_tbl').show();
    $('.no_art_btn').hide();
    
    hideOldArtwork();
  }

  function show_with_artwork(){
    
    $('#with_artwork_tbl').show();
    $('.yes_art_btn').hide();
    
    $('#no_img_artwork_tbl').hide();
    $('.no_art_btn').show();  
    
    var chk = $('.add_another_art').is(":visible");
    if(chk!=false){
      $('.add_another_art').trigger('click');
    }
    
    hideOldArtwork();
  }
  
  

function addNo_design(pro_id){
  
  var _this = $("[data-value='"+pro_id+"']");
  var no_design = parseInt($('#no_design_pop').val());
  var rolls = $(_this).hasClass('roll-products');
  var no_of_roll= parseInt($('#no_of_roll_custom_art').val());  
  
  
  if(0 >= no_design || isNaN(no_design)){
    show_faded_alert('no_design_pop', "Please minimun 1 Design");
    return false;
  }



  
  
  if( no_design > no_of_roll){
    show_faded_alert('no_design_pop', "Design has been amended for Quantity as Roll "+no_of_roll+".");
    $('#no_design_pop').val(no_of_roll);
    return false;
  }
  
  if(rolls){
    var qty = parseInt($(_this).find('.printedsheet_input').val());
  }else{
    var qty = parseInt($('#no_of_sheets').val());
    if($.isNumeric(qty)==false){
      show_faded_alert('no_of_sheets', "Please Enter Sheets");
      return false;
    }
  }
  var  box = $('#no_of_sheets').val();
  var integr = $('#newcategory').val();
  //alert(integr);
  if(integr=='Integrated'){
    
    
   
    var batch = parseInt($("#tab_printed"+pro_id).find('.plainsheet_unit').text());
    
    if(box%batch != 0)
    {
      if(batch == 250)
      {
        box = Math.ceil(box/250)*250;
      }
      else
      {
        box = Math.ceil(box/1000)*1000;
      }
      
      //alert(box);
      //alert(batch);
      
      $('#no_of_sheets').val(box);
      
      
      $("#tab_printed"+pro_id).find('.box_size').val(box);
      show_faded_popover('no_of_sheets', "Quantity has been round off to "+box);
    }
    
    
    //alert(sd);
  }
  
  if(integr=='A4'){
    
    if(box < 25)
    {
      $('#no_of_sheets').val(25);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 25");
    }
  }
  
  if(integr=='A3'){
    if(box < 100)
    {
      $('#no_of_sheets').val(100);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 100");
    }
  }
  
  if(integr=='SRA3'){
    if(box < 100){
      $('#no_of_sheets').val(100);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 100");
    }
  }
  
 
  
  
  

  
  if(0 >= no_design){
    show_faded_alert('no_design_pop', "Please minimun 1 Design");
    //$('#no_design_pop').val(1);
    return false;
  }
  
  if(no_design > qty){
     show_faded_alert('no_design_pop', "Design has been amended for Quantity as "+qty+".");
     $('#no_design_pop').val(qty);
     //alert(qty);
    return false;
  }
  
  $('#del_design').show();
  $('#no_artworks_'+pro_id).val(no_design);
  $(_this).find('.printedsheet_input').val(qty);
  update_artwork_design(pro_id,no_design);
  $("[data-value='no_design_btn_up']").hide();
  delete_old_artwork(pro_id,'up');
  
  
  /*swal(
    "Are You Sure You Want To Add Design",
    {
      buttons: {
        cancel: "No",
        catch: {
          text: "Yes",
          value: "catch",
        },
      },
      icon: "warning",
      closeOnClickOutside: false,
    }
  ).then((value) => {
    switch (value) {
      case "catch":
        $('#del_design').show();
        $('#no_artworks_'+pro_id).val(no_design);
        $(_this).find('.printedsheet_input').val(qty);
        update_artwork_design(pro_id,no_design);
        $("[data-value='no_design_btn_up']").hide();
        
        delete_old_artwork(pro_id,'up');
        
        
        break;
    }

  });*/
  
  
}



function deleteNo_design(pro_id){
  
var no_design = $('#no_design_pop').val();
  
  swal(
    "Are You Sure You Want To Remove this",
    {
      buttons: {
        cancel: "No",
        catch: {
          text: "Yes",
          value: "catch",
        },
      },
      icon: "warning",
      closeOnClickOutside: false,
    }
  ).then((value) => {
    switch (value) {
      case "catch":
        $('#del_design').hide();
        $('#no_artworks_'+pro_id).val(0);
        update_artwork_design(pro_id,0); 
        
        $('#no_design_pop').val(' ');
        $('#no_of_roll_custom_art').val(' ');
        
        $('.show_labels_per_roll').html('');
        $("[data-value='no_design_btn_up']").hide();
        
        
        
        $('#no_artworks_'+pro_id).val(0);
        $('#custom_qty_roll_'+pro_id).val('');
        
        
        delete_old_artwork(pro_id,'re');
          
        break;
    }

  });
}


function delete_old_artwork(pro_id,ty) {

  $.ajax({
    type: "post",
    url: mainUrl + "search/search/remove_all_temp_artworkPro",
    data: {
      product_id: pro_id
    },
    dataType: 'html',
    success: function (data) {
      if(ty=='re'){
        //swal('Success','Removed Successfully','success');
      }
       if(ty=='up'){
         //swal('Success','Design added','success');
       }
      
      $('#uploadedartworks_'+pro_id).val(0);
      
      $('#with_artwork_tbl').find('tbody').find('.upload_row').not('.uploadsavesection').remove();
      
      $('.total_user_sheet').html('');
      $('.total_user_labels').html('');
    },
    error: function (jqXHR, exception) {
      if (jqXHR.status === 500) {
        alert('No Invoice..');
      } else {
        alert('Error While Requesting...');
      }
    }
  });
}


  function show_des_btn(_this){
    $("[data-value='no_design_btn_up']").show();
    $(".printlabels").trigger( "focus" );
    $(".printedsheet_input").trigger( "focus" );
  }


function update_artwork_design(pro_id,designs) {

  var _this = $("[data-value='"+pro_id+"']");
    
  if(designs > 0) {
    var Artwork = 'Design';
    if (designs > 1) {
      var Artwork = 'Designs';
    }

    $(_this).find('.artwork_uploader').switchClass('art-btn', 'art-btn-l');
    $(_this).find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

    var btnhtml = '<div class="row"><div class="col-md-4"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>';

    btnhtml += '<div class="col-md-8"><b>' + designs + ' ' + Artwork + ' Added </b>';
    btnhtml += '<small>Click here to Add further<br>Designs, view or edit.</small></div></div>';

    $(_this).find('.artwork_uploader').html(btnhtml);
    $(_this).find('.artwork_uploader_roll').html(btnhtml);
    $(_this).find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

  } else {

    $(_this).find('.artwork_uploader').switchClass('art-btn-l', 'art-btn');
    $(_this).find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

    var btnhtml = '<i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Click here to Add Your Artwork';

    $(_this).find('.artwork_uploader').html(btnhtml);
    $(_this).find('.artwork_uploader_roll').html(btnhtml);
    $(_this).find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

  }

}




$(document).on("click", ".save_artwork_file_roll_custom", function(e) {

  var _this = this;
  var cartid = $('#cartid').val();
  var prdid = $('#cartproductid').val();
  var labelpersheets = $('#labels_p_sheet').val();
  var type = 'rolls';
  var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
  var product_id =  $(parent_selector).parents('.productdetails').find('.product_id').val();
  var presproof = $(parent_selector).parents('.productdetails').find('#uploadedartworks_'+product_id).attr('data-presproof');
  var response = '';
  var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();

   
  
  
  
  
  response = verify_labels_or_rolls_qty(_this, 1);
  if(response==false){ return false;}
  var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
  var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();




    $('#custom_qty_roll_'+product_id).val(sheets);





  var lb_txt = 'labels';

    
	
	
  if(labels==0 || labels==''){
    alert_box("Please complete line ");
  }
  else if(artworkname==""){
    alert_box("please enter artwork name! ");
  }
  
  
  addNo_design(prdid,_this);
  
	 var _thiss = $("[data-value='"+product_id+"']");
  
  var printlabels =   $('#artwork_custom_lab').val();    
  $(_thiss).find('.printlabels').val(printlabels);
  //alert(printlabels);
  $(_thiss).find(".printlabels").trigger( "focus" );
  
  
          

});









function addNo_design_cart(rowID,pro_id,_this){
  
  var no_design = parseInt($('#design'+rowID).val());
  var qty = parseInt($('#qty'+rowID).val());
  var custom_artwork = parseInt($('#no_design_pop').val());
  var custom_sheet = parseInt($('#no_sheet_pop').val());
  
  var serialNumber = parseInt($('#serialNumber').val());
  
 
  var min_qty = $("[data-min_qty_integrated='"+serialNumber+"']").val();
  var max_qty = $("[data-max_qty_integrated='"+serialNumber+"']").val();
  
 
  
  //alert(custom_artwork);
  
  if(custom_artwork=="" || custom_artwork == 0 || isNaN(custom_artwork)){
    show_faded_alert('no_design_pop', "Please minimun 1 Design");
    //$('#no_design_pop').val(1);
    return false;
  }

    if(parseInt(custom_sheet)=="" || parseInt(custom_sheet)<=0 || isNaN(custom_sheet)==true){
        show_faded_alert('no_sheet_pop', "Please provide Sheets");
        //$('#no_design_pop').val(1);
        return false;
    }
  
   var brands = $('#brnds'+serialNumber).val(); 
  if (typeof car.brands === 'undefined') {
       brands = $('#brnds'+rowID).val(); 
  }
  
  if (typeof car.brands === 'undefined') {
       brands = $('#brand').val();
  }
 
   var box = custom_sheet;
  var integr = brands;

  var qtys = 0;
  
   if(integr!='A3 Label' && integr!='SRA3 Label'){
  if(parseInt(custom_sheet) < parseInt(min_qty)){
     show_faded_alert('no_sheet_pop', "Design has been amended for Quantity as "+min_qty+".");
     $('#no_sheet_pop').val(min_qty);
    return false;
  }
   }
  
  if(parseInt(max_qty) < parseInt(custom_sheet)){
     show_faded_alert('no_sheet_pop', "Design has been amended for Quantity as "+max_qty+".");
     $('#no_sheet_pop').val(max_qty);
    return false;
  }
  
  /*if(custom_artwork > qty){
     show_faded_alert('no_design_pop', "Design has been amended for Quantity as "+qty+".");
     $('#no_design_pop').val(qty);
    return false;
  }*/
  
  
  if(parseInt(custom_artwork) > parseInt(custom_sheet)){
    show_faded_alert('no_design_pop', "Design has been amended for Quantity as "+custom_sheet+".");
    $('#no_design_pop').val(custom_sheet);
    return false;
  }
  
 

// alert(brands);
  
  if(brands=='Integrated Labels'){integr=='SRA3 Label'
    
    
    box = $('#no_sheet_pop').val();
    var batch = min_qty;
    
    
    //alert(box);
    //alert(batch);
    
    if(box%batch != 0)
    {
      if(batch == 250)
      {
        box = Math.ceil(box/250)*250;
      }
      else
      {
        box = Math.ceil(box/1000)*1000;
      }
      $('#no_sheet_pop').val(box);
        qtys = box;
      
      
      //$("#tab_printed"+pro_id).find('.box_size').val(box);
      show_faded_popover('no_sheet_pop', "Quantity has been round off to "+box);
    }
    
    
    //alert(sd);
  }
  
  
  
 
  //alert(integr);
    if(integr=='A4 Labels'){
    
    if(box < 25)
    {
      $('#no_sheet_pop').val(25);
        qtys = '25';
      show_faded_popover('no_of_sheets', "Quantity has been round off to 25");
    }
  }
  
  if(integr=='A3 Label'){
    if(box < 100)
    {
        qtys = '100';
      $('#no_sheet_pop').val(100);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 100");
    }
  }
  
  if(integr=='SRA3 Label'){
    if(box < 100){
        qtys = '100';
      $('#no_sheet_pop').val(100);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 100");
    }
  }
  
  
  
        $('#del_design').show();
        $('#design'+rowID).val(custom_artwork);

        if(qtys > custom_sheet){
            $('#qty'+rowID).val(qtys);
        }else{
            $('#qty'+rowID).val(custom_sheet);
        }


        $(_this).hide();
        delete_old_artwork_cart_page(pro_id,'up');
  
  
  
  /*swal(
    "Are You Sure You Want To Add Design",
    {
      buttons: {
        cancel: "No",
        catch: {
          text: "Yes",
          value: "catch",
        },
      },
      icon: "warning",
      closeOnClickOutside: false,
    }
  ).then((value) => {
    switch (value) {
      case "catch":
        $('#del_design').show();
        $('#design'+rowID).val(custom_artwork);     
        $('#qty'+rowID).val(custom_sheet);     
        $(_this).hide();
        delete_old_artwork_cart_page(pro_id,'up');
        break;
    }

  });*/
}


function delete_old_artwork_cart_page(pro_id,ty) {
  
  var cartID = $('#cartid').val();
  var rowID =  $('#rowKey').val();
  var pages =  $('#page').val();
  
  var serialNumber =  $('#serialNumber').val();
  var orderNumber =  $('#orderNumber').val();

  $.ajax({
    type: "post",
    url: mainUrl + "search/search/remove_all_cart_artworkPro",
    data: {
      product_id: pro_id,
      cartID:cartID,
      pages:pages,
      serialNumber:serialNumber,
      orderNumber:orderNumber
    },
    dataType: 'html',
    success: function (data) {
      if(ty=='re'){
        
        $('#with_artwork_tbl').find('table').find('#myBody').find('.upload_row').remove();
        $('#artwork_count_status').html('');
        $('#design'+rowID).val(0);
      
        $('#del_design').hide();
        $('#no_artworks_'+pro_id).val(0);
        
        $('#no_design_pop').val(' ');
        $('#no_of_roll_custom_art').val(' ');
        
        $('.show_labels_per_roll').html('');
        $("[data-value='no_design_btn_up']").hide();
             
        $('#custom_qty_roll_'+pro_id).val('');      
      
        $('#no_img_artwork_tbl').hide();
        $('.no_art_btn').show(); 
        
        
        
        $('#totalQty'+rowID).val(0);
        $('#totalLabels'+rowID).val(0);
        $('#qty'+rowID).val(0);
    
        $('#arwtork_qty'+rowID).val(0);
        $('#design'+rowID).val(0);
        
        //swal('Success','Removed Successfully','success');
      }
       if(ty=='up'){
         
         $('#with_artwork_tbl').find('table').find('#myBody').find('.upload_row').remove();
         $('#artwork_count_status').html('');
         //swal('Success','Design added','success');
       }
      
      // $('#uploadedartworks_'+pro_id).val(0);
      
  
    
    },
    error: function (jqXHR, exception) {
      if (jqXHR.status === 500) {
        alert('No Invoice..');
      } else {
        alert('Error While Requesting...');
      }
    }
  });
}
  


function uploadCustomArtwork(id, event, rowId = null, page=null,conditon=null) {

  var page = $('#page').val();
  var rowKey = $('#rowKey').val();
  var serialNumber = $('#serialNumber').val();
  var orderNumber = $('#orderNumber').val();
  var manfactureId = $('#manfactureId').val();
  var checkoutArtwork = $('#checkoutArtwork').val();
  var brandName = $('#brand').val();
  var customerId = $('#custId').val();
  var per_shet_roll= $('#lblPerSheet').val();
  var is_follow=   $('#follow_art'+id).prop("checked");
	

 
	
  if (validateRequestCustomDesign(id, event,page,conditon,1)) {
    
     
    var labels = $(event).closest('tr').find('#at_label' + id).val();
    var roll = $(event).closest('tr').find('#at_roll' + id).val();
    var design = $(event).closest('tr').find('#nodesign' + id).val();
    var per_roll =  $(event).closest('tr').find('#lbl_per_roll' + id).text();
    var cartID = $('#cartid').val();
    
    
    $('#totalQty'+rowId).val(labels);
        $('#totalLabels'+rowId).val(labels);
        $('#qty'+rowId).val(roll);
    
        $('#arwtork_qty'+rowId).val(design);
        $('#design'+rowId).val(design);
        
        
        $('#label_for_orders'+rowId).val(labels);
        $('#arwtork_qty2'+rowId).val(design);
        
        
        
        var pro_id =  $('#product_id').val();
        delete_old_artwork_cart_page(pro_id,'up');
        
        $(event).hide();
        $('#delete2001').show();
    
    
    /*swal(
    "Are You Sure You Want To Add Design",
    {
      buttons: {
        cancel: "No",
        catch: {
          text: "Yes",
          value: "catch",
        },
      },
      icon: "warning",
      closeOnClickOutside: false,
    }
  ).then((value) => {
    switch (value) {
      case "catch":
        $('#totalQty'+rowId).val(labels);
        $('#totalLabels'+rowId).val(labels);
        $('#qty'+rowId).val(roll);
    
        $('#arwtork_qty'+rowId).val(design);
        $('#design'+rowId).val(design);
        
        
        $('#label_for_orders'+rowId).val(labels);
        $('#arwtork_qty2'+rowId).val(design);
        
        
        
        var pro_id =  $('#product_id').val();
        delete_old_artwork_cart_page(pro_id,'up');
        
        $(event).hide();
        $('#delete2001').show();
        
        break;
    }

  });*/
    
    
    
  }
}


function validateRequestCustomDesign(id, event,page,conditon, tofollow=null) {


  var labels = $(event).closest('tr').find('#at_label' + id).val();
  var roll = $(event).closest('tr').find('#at_roll' + id).val();
  var sheet = parseInt($('#at_roll' + id).val());
  var name = parseInt($(event).closest('tr').find('#nodesign' + id).val());
  var labelPerSheet = parseInt($('#lblPerSheet').val(), 10);
  var dieacross = min_rolls = parseInt($('#minrolls').val(), 10);
  var brand = $('#brand').val();
  var minlabels = parseInt($('#minlabels').val(), 10);
  var maxRoll = parseInt($('#maxrolls').val(), 10);
  
  minlabels = 100;
  
  
  
  if(page ==null || page =="" && conditon !='update'){
  }

  if (brand === 'Roll Labels') {



      labelspersheets = labelPerSheet;
      var rolls = roll;
      var total_labels = parseInt(labels);
      var perroll = Math.ceil(parseFloat(total_labels / rolls));
      if (isFloat(perroll)) {
          perroll = Math.ceil(perroll);
      }
      var minroll = Math.ceil(100 / rolls); //34
      var per_rolls = minroll * rolls;
      var max_rolls_allowed = parseInt(maxRoll);
      var max_labels_allowed = 1000000;

      var labelspersheets1 = 0;
      /*alert('max_rolls_allowed = '+max_rolls_allowed);
      alert('rolls = '+rolls);
      alert('total_labels = '+total_labels);
      alert('labelPerSheet = '+labelPerSheet);
      alert('labelspersheets = '+labelspersheets);
      alert('per_rolls = '+per_rolls);*/


      //alert(sheet);
      
      
      
      
      if (name == '') {
          show_popover('#nodesign'+id,'please Enter No of Design');
          return false;
      }
      
      if(name % 1 != 0){
          show_faded_popover('#nodesign'+id,'Number of designs cannot be in decimal');
          return false;
      }
      
      
      if(sheet % 1 != 0){
          show_faded_popover('#at_roll'+id,'Number of rolls cannot be in decimal');
          return false;
      }
      if(name > sheet){
          show_popover('#nodesign'+id,'Number of design should be equal or less than number of rolls');
          //$('#nodesign'+id).val(sheet);
          return false;
      }

      
      
      

      if (name == 0) {
          show_popover('#nodesign'+id,'please Enter No of Design');
          return false;
      }

      if (labels == 0 || labels == '') {
          $(event).closest('tr').find('#at_name' + id).val(1);
          show_popover('#at_label'+id,'Minimum 1 Label Allowed');
          return false;
      }

      if (!is_numeric(labels)) {
          show_popover('#at_label'+id,'Please enter numeric values in Lables');
          $(event).closest('tr').find('#at_label' + id).val('');
          return false;
      }

      if (roll == 0 || roll == '') {
          show_popover('#at_roll'+id,'Please Enter Roll');
          return false;
      }

      if (!is_numeric(roll)) {
          show_popover('#at_roll'+id,'Please enter numeric values Roll');
          $(event).closest('tr').find('#at_roll' + id).val('');
          return false;
      }


      if(rolls > max_rolls_allowed || total_labels > max_labels_allowed){

          if(rolls > max_rolls_allowed){
              rolls = max_rolls_allowed;
          }

          if((total_labels + rolls) >= max_labels_allowed){
              total_labels = max_labels_allowed;
              //alert('new total_labels = '+total_labels);
              labelspersheets1 = Math.floor(total_labels / rolls);
          }else{
              labelspersheets1 = Math.ceil(total_labels / rolls);
          }
          if(labelspersheets1 > labelspersheets){
              labelspersheets = labelspersheets;
          }else{
              labelspersheets = labelspersheets1;
          }
          //alert('1a');

          total_labels = Math.ceil(labelspersheets * rolls);
          /*alert('total_labels = '+total_labels);
          alert('labelspersheets = '+labelspersheets);*/

          show_faded_popover('#at_roll'+id, "Quantity has been amended for production as " + rolls + " Rolls.");
          $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
          $(event).closest('tr').find('#at_label' + id).val(total_labels);
          $(event).closest('tr').find('#at_roll' + id).val(rolls);
          return false;
      }

      if(tofollow == 1){
          if(total_labels < minlabels){
              labelspersheets = Math.ceil(minlabels / rolls);
              total_labels = labelspersheets * rolls;

              show_faded_popover('#at_label'+id, "Quantity has been amended for production as " + total_labels + " Labels.");
              $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
              $(event).closest('tr').find('#at_label' + id).val(total_labels);
              $(event).closest('tr').find('#at_roll' + id).val(rolls);
              return false;
          }
      }



      //alert('perroll > labelspersheets ' + perroll+ ' || ' +labelspersheets);

      if (!is_numeric(total_labels)) {

          var _this = $(event).closest('tr').find('#at_label' + id);
          show_faded_popover(_this, "Please enter number of labels.");
          $(event).closest('tr').find('#at_label' + id).val('');
          return false;
      } else if (total_labels == 0) {
          var _this = $(event).closest('tr').find('#at_label' + id);
          show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
          $(event).closest('tr').find('#at_label' + id).val('');
          return false;
      } else if (!is_numeric(rolls) || rolls == 0) {
          var _this = $(event).closest('tr').find('#at_roll' + id);
          show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
          $(event).closest('tr').find('#at_roll' + id).val('');
          return false;
      } else if (per_rolls < minlabels ) {

          var roll_input_display = $(event).closest('tr').find('#at_roll' + id).css('display');

          if (roll_input_display == 'block') {
              //alert('if');
              var requiredlabels = minlabels * rolls;
              var total_labels = perroll * rolls;

              var _this = $(event).closest('tr').find('#at_label' + id);


              if (total_labels < '100') {
                  var total_labels = '100';
              }
              $(event).closest('tr').find('#lbl_per_roll' + id).text(perroll);
              $(event).closest('tr').find('#at_label' + id).val(total_labels);



          } else {

              if (total_labels > labelspersheets) { //10501 > 3500

                  var expectedrolls = parseFloat(total_labels / labelspersheets);

                  if (isFloat(expectedrolls)) {
                      expectedrolls = Math.ceil(expectedrolls);
                  }
                  //alert('expectedrolls = '+expectedrolls);
                  if(expectedrolls > max_rolls_allowed){
                      if(total_labels >= max_labels_allowed){
                          total_labels = max_labels_allowed;
                          labelspersheets1 = Math.floor(total_labels / max_rolls_allowed);
                      }else{
                          labelspersheets1 = Math.ceil(total_labels / max_rolls_allowed);
                      }
                      //alert('2a');
                      if(labelspersheets1 > labelspersheets){
                          labelspersheets = labelspersheets;
                      }else{
                          labelspersheets = labelspersheets1;
                      }

                      show_faded_popover(_this, "Quantity has been amended for production as " + max_rolls_allowed + " Rolls.");
                      $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
                      $(event).closest('tr').find('#at_roll' + id).val(max_rolls_allowed);
                      //$(id).parents('.upload_row').find('.quantity_labels').text(max_rolls_allowed);
                      return false;
                  }


                  labelspersheets = parseInt(total_labels / expectedrolls);
                  //alert('labelspersheets = '+labelspersheets);
                  var _this = $(event).closest('tr').find('#at_roll' + id);
                  show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                  $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
                  $(event).closest('tr').find('#at_roll' + id).val(expectedrolls);
                  //$(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                  return false;
              } else {
                  //alert('else in else');
                  if (total_labels < minlabels) {
                      total_labels = minlabels;
                      var _this = $(event).closest('tr').find('#at_label' + id);
                      show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                  } else {
                      var _this = $(event).closest('tr').find('#at_label' + id);
                      //var _thiss = $(id).parents('.upload_row').find('.quantity_labels');

                      $(event).closest('tr').find('#at_label' + id).val(100);
                      //show_faded_popover(_thiss, "Quantity has been amended for production as 1 Roll.");
                  }
                  $(event).closest('tr').find('#lbl_per_roll' + id).text(total_labels);
                  //$(id).parents('.upload_row').find('.quantity_labels').text(1);
                  $(event).closest('tr').find('#at_roll' + id).val(1);
                  $(event).closest('tr').find('#at_label' + id).val(total_labels);
                  return false;
              }
          }
      } else if (perroll > labelspersheets) {

          /*alert('a c');
          alert('perroll = '+perroll);
          alert('dieaccross = '+min_rolls);*/
          var response = rolls_calculation(min_rolls, labelspersheets, total_labels, rolls);
          var total_labels = response['total_labels'];
          var expectedrolls = response['rolls'];

          /*alert('expectedrolls = '+expectedrolls);
          alert('max_rolls_allowed = '+max_rolls_allowed);
          alert('total_labels = '+total_labels);*/


          if(expectedrolls > max_rolls_allowed){
              if(total_labels >= max_labels_allowed){
                  total_labels = max_labels_allowed;
                  labelspersheets1 = Math.floor(total_labels / max_rolls_allowed);
              }else{
                  labelspersheets1 = Math.ceil(total_labels / max_rolls_allowed);
              }
              if(labelspersheets1 > labelspersheets){
                  labelspersheets = labelspersheets;
              }else{
                  labelspersheets = labelspersheets1;
              }
              //alert('3a');
              total_labels = labelspersheets * max_rolls_allowed;
              var infotxt = 'Quantity has been amended for production as ' + max_rolls_allowed + ' rolls and ' + total_labels + ' labels';
              show_faded_popover($(event).closest('tr').find('#at_label' + id), infotxt);

              $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
              $(event).closest('tr').find('#at_label' + id).val(total_labels);
              $(event).closest('tr').find('#at_roll' + id).val(max_rolls_allowed);
              //$(id).parents('.upload_row').find('.quantity_labels').text(max_rolls_allowed);
              return false;
          }



          var labelspersheets = parseInt(total_labels / expectedrolls);
          var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
          show_faded_popover($(event).closest('tr').find('#at_label' + id), infotxt);
          $(event).closest('tr').find('#lbl_per_roll' + id).text(labelspersheets);
          $(event).closest('tr').find('#at_label' + id).val(total_labels);
          $(event).closest('tr').find('#at_roll' + id).val(expectedrolls);
          //$(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
          return false;

      } else {

          //alert('4 A');

          var pr_rol_lb = 0;
          pr_rol_lb = Math.ceil(minlabels / dieacross);

          var total_labels = parseInt(perroll) * parseInt(rolls);
          //alert('total_labels = '+total_labels)
          if (total_labels < (pr_rol_lb * parseInt(rolls))) {
              //var total_labels = '100';
              var total_labels = (pr_rol_lb * parseInt(rolls));

              //alert('total_labels hi = '+total_labels);
          }






          /*alert(rolls); //1
          alert(perroll);//45
          alert(pr_rol_lb);//17
          alert(minlabels);//100*/


          if (perroll <= pr_rol_lb) {
              total_labels = pr_rol_lb * rolls;
              //alert(pr_rol_lb+' '+rolls+' '+total_labels);
              perroll = total_labels / rolls;
          }

          /*alert('perroll = '+perroll);
          alert('total_labels = '+total_labels);*/

          $(event).closest('tr').find('#lbl_per_roll' + id).text(perroll);
          $(event).closest('tr').find('#at_label' + id).val(total_labels);
      }
    return true;
  }
  
  if(brand === 'Integrated Labels'){
    if ((file == "undefined" || file == '' || file == null) && page == null  && conditon !='update') {
      show_popover('.upload-btn-wrapper ','please upload file');
      return false;
    }
    if (name == '') {
      show_popover('#at_name'+id,'please Enter artwork name');
      return false;
    }

    if (roll == 0 || roll == '') {
      show_popover('#at_roll'+id,'Please Enter Roll');
      return false;
    }

    if (!is_numeric(roll)) {
      show_popover('#at_roll'+id,'Please enter numeric values Roll');
      $(event).closest('tr').find('#at_roll' + id).val('');
      return false;
    }

    if(roll < 1000){
      show_popover('#at_roll'+id,'Minmim Roll 1000');
      $(event).closest('tr').find('#at_roll' + id).val(1000);
      return false;
    }
  }
  else {
    var sheetLabels = parseInt($(event).closest('tr').find('#at_label' + id).text());
    if (name == '') {
      alert('please Enter artwork name');
      return false;
    }

    if (sheet == null || sheet == "" || sheet == 'NaN') {
      show_popover('#at_roll'+id,'please Add sheet Quantity Here');
      return false;
    }
    if (sheet <= 0 ) {
      show_popover('#at_roll'+id,'please Add Quantity more then 0');
      $(event).closest('tr').find('#at_roll' + id).val(1);
      $(event).closest('tr').find('#at_label' + id).text(1 * labelPerSheet);
      return false;
    }
    if (sheet > 50000) {
      show_popover('#at_roll'+id,'maxum ' + 50000 + ' allowed');
      $(event).closest('tr').find('#at_roll' + id).val(getMaxQuantiy(brand));
      $(event).closest('tr').find('#at_label' + id).text(getMaxQuantiy(brand) * labelPerSheet);
      return false;
    }
    return true;
  }
  return true;
}

function validateRequestCustomDesignOLD(id, event,page,conditon) {


  var labels = $(event).closest('tr').find('#at_label' + id).val();
  var roll = $(event).closest('tr').find('#at_roll' + id).val();
  var sheet = $('#at_roll' + id).val();
  var name = $(event).closest('tr').find('#nodesign' + id).val();
  var labelPerSheet = parseInt($('#lblPerSheet').val(), 10);
  var dieacross = min_rolls = parseInt($('#minrolls').val(), 10);
  var brand = $('#brand').val();
  var minlabels = parseInt($('#minlabels').val(), 10);
  var maxRoll = parseInt($('#maxrolls').val(), 10);
  
  minlabels = 100;
  
  
  
  if(page ==null || page =="" && conditon !='update'){
  }

  if (brand === 'Roll Labels') {
    
  

    if (name == '') {
      show_popover('#nodesign'+id,'please Enter No of Design');
      return false;
    }

    if (labels == 0 || labels == '') {
      $(event).closest('tr').find('#at_name' + id).val(1);
      show_popover('#at_label'+id,'Minimum 1 Label Allowed');
      return false;
    }

      if (!is_numeric(labels)) {
        show_popover('#at_label'+id,'Please enter numeric values in Lables');
        $(event).closest('tr').find('#at_label' + id).val('');
        return false;
      }

    if (roll == 0 || roll == '') {
      show_popover('#at_roll'+id,'Please Enter Roll');
      return false;
    }
    
    if (!is_numeric(roll)) {
      show_popover('#at_roll'+id,'Please enter numeric values Roll');
      $(event).closest('tr').find('#at_roll' + id).val('');
      return false;
    }
    
    if (roll % dieacross != 0) {
    
      if(roll % dieacross != 0) {
        var multipyer = dieacross * parseInt(parseInt(roll / dieacross) + 1);
        
        $(event).closest('tr').find('#at_roll' + id).val(multipyer);
        
      }
      
      show_faded_popover('#at_roll'+id, "Sorry! these labels are only available in sets of " + dieacross + " rolls. ");
      return false;
    }
    
    var roll = $(event).closest('tr').find('#at_roll' + id).val();
    var name = $(event).closest('tr').find('#nodesign' + id).val();
    
    if(parseInt(name) > parseInt(roll) ){
      show_popover('#nodesign'+id,"Design has been amended for Quantity as Roll "+roll+".");
      $('#nodesign' + id).val(roll);
    }


    // condition End

    labels = parseInt(labels);
    roll = parseInt(roll);
    labelPerSheet = parseInt(labelPerSheet);

    var min_roll = Math.round(150/roll);
    var perroll = min_roll * roll;
    
    

    if (labels > labelPerSheet) {
      
      if ((labels / roll) > labelPerSheet) {
        var response = rolls_calculation(dieacross, labelPerSheet, labels, 0);
        console.log(response);
        var quantity = parseInt((labels / labelPerSheet));
        var rol = quantity % dieacross;
        console.log(labels + ' == ' + labelPerSheet + ' == ' + roll + ' == ' + quantity + ' == ' + rol);
        $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(response.per_roll));
        $(event).closest('tr').find('#at_label' + id).val(Math.ceil(response.total_labels));
        $(event).closest('tr').find('#at_roll' + id).val(Math.ceil(response.rolls));
        $(event).closest('tr').find('#old_roll' + id).val(Math.ceil(response.rolls));
        show_popover('#at_roll'+id,'Minimum ' + parseInt(Math.ceil(response.rolls)) + ' Rolls Allowed');
        return false;
      } else {
        if ((labels / roll) < minlabels) {
          //alert('2');
          $(event).closest('tr').find('#old_roll' + id).val(roll);
          $(event).closest('tr').find('#at_label' + id).val(Math.ceil(parseInt(minlabels * roll)));
          $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(minlabels));
          
          var pr_rol_lb = 0;
          pr_rol_lb = minlabels / dieacross;
          var perrolls = labels / roll;
          if(perrolls < pr_rol_lb){
        
            sd = pr_rol_lb * roll;
            perrolls = sd / roll;
            $(event).closest('tr').find('#at_label' + id).val(sd);
            
          }
          $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(parseInt(sd / roll)));
          
          
          return false
        } else {
          
          var labels = $(event).closest('tr').find('#at_label' + id).val();
          var roll = $(event).closest('tr').find('#at_roll' + id).val();
          var sd = Math.ceil(labels / roll) * roll; 
      
          var pr_rol_lb = 0;
          pr_rol_lb = minlabels / dieacross;
          $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(parseInt(sd / roll)));
         
          var perrolls = labels / roll;
          
          if(perrolls < pr_rol_lb){
            sd = pr_rol_lb * roll;
            $(event).closest('tr').find('#at_label' + id).val(sd);
            $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(parseInt(sd / roll)));
          }
          
          
          
          var oldRoll = parseInt($(event).closest('tr').find('#old_roll' + id).val());
          if (oldRoll == 0) {
            return true;
          }
          else {
            if (oldRoll != roll) {
              //alert('3');
              labels = labels + dieacross;
              $(event).closest('tr').find('#old_roll' + id).val(Math.ceil(roll));
              $(event).closest('tr').find('#at_label' + id).val(Math.ceil(labels));
              $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(parseInt(labels / roll)));
              return false;
            }
          }
          
         
            
          
        }
      }
      
      
      
      
    }

    else {
      var response = rolls_calculation(dieacross, labelPerSheet, labels, 0);
      var labels = $(event).closest('tr').find('#at_label' + id).val();
      var roll = $(event).closest('tr').find('#at_roll' + id).val();
      var sd = Math.ceil(labels / roll) * roll; 
      
      var pr_rol_lb = 0;
      pr_rol_lb = minlabels / dieacross;
      
     
      
      
      $(event).closest('tr').find('#at_label' + id).val(sd);
      $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(parseInt(sd / roll)));
      
      var perrolls = labels / roll;
      if(perrolls < pr_rol_lb){
        
        sd = pr_rol_lb * roll;
        perrolls = sd / roll;
        $(event).closest('tr').find('#at_label' + id).val(sd);
        $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(parseInt(sd / roll)));
        
      }
      
   
      if(perroll < minlabels && minlabels < labels ) {
        console.log(minlabels+' '+dieacross+' '+roll);
        $(event).closest('tr').find('#at_label' + id).val();
        $(event).closest('tr').find('#at_roll' + id).val();
        $(event).closest('tr').find('#old_roll' + id).val(dieacross);
        
        var labels = $(event).closest('tr').find('#at_label' + id).val(sd);
        var roll = $(event).closest('tr').find('#at_roll' + id).val();
        
        $(event).closest('tr').find('#lbl_per_roll' + id).text(Math.ceil(labels / roll));
        // show_popover('#at_label'+id,'Minimum ' + parseInt(minlabels * dieacross) + ' Labels Allowed');
        return false;
      }
    }
    return true;
  }
  
  if(brand === 'Integrated Labels'){
    if ((file == "undefined" || file == '' || file == null) && page == null  && conditon !='update') {
      show_popover('.upload-btn-wrapper ','please upload file');
      return false;
    }
    if (name == '') {
      show_popover('#at_name'+id,'please Enter artwork name');
      return false;
    }

    if (roll == 0 || roll == '') {
      show_popover('#at_roll'+id,'Please Enter Roll');
      return false;
    }

    if (!is_numeric(roll)) {
      show_popover('#at_roll'+id,'Please enter numeric values Roll');
      $(event).closest('tr').find('#at_roll' + id).val('');
      return false;
    }

    if(roll < 1000){
      show_popover('#at_roll'+id,'Minmim Roll 1000');
      $(event).closest('tr').find('#at_roll' + id).val(1000);
      return false;
    }
  }
  else {
    var sheetLabels = parseInt($(event).closest('tr').find('#at_label' + id).text());
    if (name == '') {
      alert('please Enter artwork name');
      return false;
    }

    if (sheet == null || sheet == "" || sheet == 'NaN') {
      show_popover('#at_roll'+id,'please Add sheet Quantity Here');
      return false;
    }
    if (sheet <= 0 ) {
      show_popover('#at_roll'+id,'please Add Quantity more then 0');
      $(event).closest('tr').find('#at_roll' + id).val(1);
      $(event).closest('tr').find('#at_label' + id).text(1 * labelPerSheet);
      return false;
    }
    if (sheet > 50000) {
      show_popover('#at_roll'+id,'maxum ' + 50000 + ' allowed');
      $(event).closest('tr').find('#at_roll' + id).val(getMaxQuantiy(brand));
      $(event).closest('tr').find('#at_label' + id).text(getMaxQuantiy(brand) * labelPerSheet);
      return false;
    }
    return true;
  }
  return true;
}

function show_custom_design_btn(key) {
		 $('#save'+key).show();
}


function insertQuotationPressProofPrice(key,serial,type,ex,QNum,UseID,pagess) {
 
  
  
  var foc = $('#qfoc'+key).val();
  var qty = $('#pressQty_'+key).val();
  var minroll= 2;
  
  
  if(foc==""){
    show_faded_alert('qfoc'+key,"Please Choose");
    $('#qfoc'+key).val();
    return false;
  }


  if(foc=='Y' || foc=='other'){
    if(qty=="" || qty==0){
      show_faded_alert('pressQty_'+key,"Choose Press Proof Qty");
      //$('#pressQty_'+key).val(minroll);
      return false;
    }
  }
  
  if (qty < 11) {
   
    if (qty % minroll != 0) {
      var multipyer = minroll * parseInt(parseInt(qty / minroll) + 1);
      $('#pressQty_'+key).val(multipyer);
      show_faded_alert('pressQty_'+key, "Sorry! Press Proof are only available in sets of 2 Qty. If Qty less then 10. ");
      return false;
    }
  }
  
  
  $('#aa_loader').show();

  $.ajax({
    type: "post",
    url: mainUrl+'order_quotation/quotation/updatePressPrice',
    cache: false,
    data:{
              
      serial:serial,
      qty:qty,
      type:type,
      foc:foc,
      ex:ex,
      QNum:QNum,
      UseID:UseID,
      pagess:pagess
              
    },
    dataType: 'json',
    success: function(data)
    {
      window.location.reload();
    },
    error: function(){
      alert('Error while request..');
    }
  });
  $('#aa_loader').hide();
}


function deletepressproof(serial,pagess) {
  
  swal(
    "Are You Sure You Want To Remove This Press Proof",
    {
      buttons: {
        cancel: "No",
        catch: {
          text: "Yes",
          value: "catch",
        },
      },
      icon: "warning",
      closeOnClickOutside: false,
    },
  ).then((value) => {
    switch (value) {
      case "catch":
					
        $.ajax({
          type: "post",
          url: mainUrl+'order_quotation/quotation/deletePressproof',
          cache: false,
          data:{
            serial:serial,
             pagess:pagess
          },
          dataType: 'json',
          success: function(data)
          {
            window.location.reload();
            },
          error: function(){
              alert('Error while request..');
          }
        });
        break;
    }
  });
 
}


  $(document).on("change", ".qfoc", function (e) {
  

  var key = $(this).attr('data-qkey');
  var foc = $(this).val();
 
  if(foc!='Y' && foc!='other'){
    var qty = $('#pressQty_'+key).val(foc);
    $('#pressQty_'+key).prop('disabled',true);
  }else{
    var qty = $('#pressQty_'+key).val('');
    $('#pressQty_'+key).prop('disabled',false);
  }
});

$(document).on("click", ".find_cust", function(e) {

    var labels = 0;
    var valss = valids();

    //alert(valss);

    if (typeof valss === 'undefined' || valss == true) {
        //alert('s');

        $('.cus_matss').each(function(i, obj) {
            $('#cut_mat_btn'+i).trigger('click');
        });
             //window.location.href =  "https://www.aalabels.com/salespanel/index.php/checkout";
             window.location.href =  mainUrl+"checkout";
    }


           /*$('.cus_matss').each(function(i, obj) {
               //test
               //alert(i);
               $('#cut_mat_btn'+i).trigger('click');
               var matqty = $('#row_id'+i).val();
               var format = $('#format'+matqty).val();
               var quantity = $('#matqty'+matqty).val();
               var mattype = $('#prnt_dropdown_'+matqty).val();
               var design = $('#designmat'+matqty).val();
               var lables = $('#labelsmat'+matqty).val();
               var core = $('#core_'+matqty).val();
               var wound = $('#wound_'+matqty).val();
               var plain_print = $('#mat_print'+matqty).val();
               var finish = $('#finishdropdown_'+matqty).val();




               if(validationForCustomDieCheckout(format,quantity,matqty,plain_print,mattype,design,core,wound,lables,finish)){
                   window.location.href =  "https://www.aacartons.com/aalabels/salespanel/index.php/checkout";
               }


              // window.location.href =  "https://www.aacartons.com/aalabels/salespanel/index.php/checkout";


           });*/
});



function validationForCustomDieCheckout(format,qty,matid,plain_print,mattype,design,core,wound,lables,finish) {

    if(format !='Roll'){

        if(plain_print == 'plain'){

            if( (format == 'A4' || format == 'A5') && (qty <25 || qty >50000)){

                if(qty <25){

                    show_faded_alert('matqty'+matid,'Minimum Sheet Quantity must be 25');
                    $('#matqty'+matid).val(25);
                }else if(qty >50000){

                    show_faded_alert('matqty'+matid,'Maximum Sheet Quantity must be 50000');
                    $('#matqty'+matid).val(50000);
                }
                return false;
            }

            if((format === 'A3' || format === 'SRA3') && (qty <100 || qty >50000)){
                if(qty <100){
                    show_faded_alert('matqty'+matid,'Enter Quantity must 100');
                    $('#matqty'+matid).val(100);
                }else if(qty >50000){
                    show_faded_alert('matqty'+matid,'Maximum Sheet Quantity must be 50000');
                    $('#matqty'+matid).val(50000);
                }
                return false;
            }
            return true;
        }
        else{
            if(mattype == "" || mattype == null){
                show_faded_alert('prnt_dropdown_'+matid,'Please Select Printing');
                return false;
            }
            if(design == 0 || design == "" || design == null){
                show_faded_alert('designmat'+matid,'Please Enter Design');
                return false;
            }
            if(qty ==0 || qty =="" || qty == null){

                show_faded_alert('matqty'+matid,'Please Enter Quantity');
                $('#matqty'+matid).val(0);
                return false
            }
            return true;
        }

    }else{

        if(plain_print == 'plain'){
            if(core == 0 || core == "" || core == null){
                show_faded_alert('core_'+matid,'Please Select Core Size');
                return false;
            }
            if(wound == 0 || wound == "" || wound == null){
                show_faded_alert('wound_'+matid,'Please Select Wound');
                return false;
            }


            if(lables == 0 || lables == "" || lables == null){
                show_faded_alert('labelsmat'+matid,'Please Enter Labels');
                return false;
            }

            if(qty ==0 || qty =="" || qty == null){

                show_faded_alert('matqty'+matid,'Please Enter Quantity');
                $('#matqty'+matid).val(0);
                return false
            }
            return true;
        }else{
            if(mattype == "" || mattype == null){
                show_faded_alert('prnt_dropdown_'+matid,'Please Select Printing');
                return false;
            }
            if(finish == 0 || finish == "" || finish == null){
                show_faded_alert('finishdropdown_'+matid,'Please Select Finish');
                return false;
            }if(core == 0 || core == "" || core == null){
                show_faded_alert('core_'+matid,'Please Select Core Size');
                return false;
            }
            if(wound == 0 || wound == "" || wound == null){
                show_faded_alert('wound_'+matid,'Please Select Wound');
                return false;
            }
            if(lables == 0 || lables == "" || lables == null){
                show_faded_alert('labelsmat'+matid,'Please Enter Labels');
                return false;
            }
            if(design == 0 || design == "" || design == null){
                show_faded_alert('designmat'+matid,'Please Enter Design');
                return false;
            }
            if(qty ==0 || qty =="" || qty == null){

                show_faded_alert('matqty'+matid,'Please Enter Quantity');
                $('#matqty'+matid).val(0);
                return false
            }

            return true;
        }

    }



}

function isFloat(n) {

    return Number(n) === n && n % 1 !== 0;

}

$(document).on("change", "#agree_term", function (e) {
    //alert(paymentoption);
    if(paymentoption=='sample'){
        if($(this).prop("checked") == true){
            //alert("Checkbox is checked.");
            make_prominent_buttons();
        }
        else if($(this).prop("checked") == false){
            //alert("Checkbox is unchecked.");
            $("#confirmbtn").css('opacity',0.5);
            $("#worlpaybtn").css('opacity',0.5);
        }
    }


});