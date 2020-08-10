



function getFormat(){
 
 var permission = $('#first_format_link').attr('data-open');
 
    $.ajax({
        type: "post",
        url: mainUrl + "search/search/getSearch",
        cache: false,
        data: {'category':'A4'},
        dataType: 'html',
        success: function (data) {
            var msg = $.parseJSON(data);

            showAndHideTabs('format_page');
            if(permission=="close"){  
                $('#lf-pos').empty();
                $('#format_page').html(msg.html);
                $('.ajax_material_sorting').show();
                $('#material_page').empty();
                $( ".confirm_coresize ").unbind("change");
                activeTab('first_format_link');  
               filter_data('autoload', '');
               $('#first_format_link').attr('data-open','open');
          }else{
             $('#format_page').show(); 
             $('#ajax_material_sorting').show();
             $('.ajax_material_sorting').show();
             
             $('#material_page').hide();
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
$(document).on("change", "#coresize", function (e) {

    var coreid = $(this).val();

    var coreid = coreid.toLowerCase();



    var shape = $('#myshape1').val();

    var diecode = $('#dicode').val();



    var regmark = $('#regmark11').val();

    var productid = $('#productId11').val();

    var regmk = '';

    var myproductId = '';

    if (productid != "" && regmark == "yes") {
        myproductId = productid;
        regmk = 'yes';
    }
    else if (productid == "" && regmark == "yes") {
        regmk = 'yes';
    }
    else if (productid != "" && regmark != "yes") {
        myproductId = productid;
    }

    var diename = diecode + '' + coreid;

    getMaterialPage(shape, diename, myproductId, regmk)

});
$(document).on("click", ".confirm_coresize", function (e) {
    // e.preventDefault();
    var coresize = $("#coresize").val();
    if (coresize == '') {
        $(".roll_sheets_block").find('.dropdown-toggle').css("border", "1px solid red");
    }
    else {
        $(this).html("Please Wait <i class='fa fa-spin fa-refresh'></i>");
        $(this).attr('disabled', 'disabled');
        $(this).prop('disabled', true);
        $("#coresize").trigger("change");
        $("#aa_loader").find('.loading-gif').css('top', '52%');
        $("#aa_loader").show();


    }
});

$(document).on("click",".reset_button" ,function(){
    $('[data-toggle="category-tooltip"]').tooltip('show');
    $('[data-toggle="printer-tooltip"]').tooltip('hide');


    $('#material_code').val('');
    $('#select_msg').remove();
    $('#newcategory').val('');

    $('#shape').val('');

    $('#height_min').val('');
    $('#height_max').val('');

    $('#width_min').val('');
    $('#width_max').val('');

    $('#color').html('<option value=""> Label Colour </option>');
    $('#finish').html('<option value=""> Label Finish </option>');
    $('#material').html('<option value=""> Label Material </option>');
    $('#printer').html('<option value=""> Printer / Copier Type </option>');
    $('#cornerradius').html('<option value="">Select Label Corner</option>');


    $('#adhesive').val('');
    $('#brands').val('');
    $('#printer_width').val('');
    $('#model').val('');
    $('#ajax_model_desc').html('');

    contentbox.html('');
    $('.ajax_material_sorting').html('');
    $('#ajax_material_sorting').html('');
    $('.sizefound').hide();

    $('#width_box_text').html(' Label Width <small>(mm)</small>');
    $('#height_box').css('visibility','');


    /************* New Amendments ****************/
    update_width_values(0,0);
    update_height_values(0,0);

    update_width_range(0,0);
    update_height_range(0,0);
    /**************************************/


    disable_slider_option('disabled');
    old_flag = '';

    $('#product_count').val(0);
    $('#start_limit').val(0);

    $element = $('.nlabelfilter');
    $element.prop('disabled', true);
    $element.attr('disabled', true);
    $('#home_finder').prop('disabled', true);

    $('#shapes_box').find('.btn_shape').prop('disabled', true);
    $('.thermaloptions').hide();
    $('.integratedbrands').hide();
    $('#categorybox').switchClass( "col-lg-6", "col-lg-12");
    $('#categorybox').switchClass( "col-md-6", "col-md-12");
    $('#categorybox').switchClass( "col-lg-4", "col-lg-12");
    $('#categorybox').switchClass( "col-md-4", "col-md-12");
    $('#categorybox').find('.labelF').append('<small id="select_msg" style="color:red"> Select label category</small>');
    $("input[name='category']").prop("checked",false);


    swal("Label filter has been reset.","Please start by selecting a category from the top of the filter", "warning");




});

function showFormat() {
    $('#format_page').show();
    $('#ajax_material_sorting').show();
}

function showmaterial() {
    showAndHideTabs('material_page');
    $('.ajax_material_sorting').hide();
    $('#ajax_material_sorting').hide();
    $('.ajax_material_mat').show();

}

function getCustomer() {
    showAndHideTabs('customer');
	opencustomerdatable();
}

function showMyPaymentSection(){
	
	var ck = '';
	var vale = valids();
	//alert(vale);
	if(($('#add_materials1').length && typeof vale === 'undefined') || vale==false){
		ck = false;
		//alert('if');
	}else{
		ck = true;
		//alert('else');
	}


	
	if(vale==true || ck==true){
		$('#aa_loader').show();
    $.ajax({
        type: "get",
        url: mainUrl +"cart/cart/paymentPage",
        data: {},
        dataType: 'html',
        success: function (data) {
					
					var msg = $.parseJSON(data);
					$('#complete_payment_for').html(msg.html);
					activeTab('dl_pm_link');
					showAndHideTabs('complete_payment_for');
					$('#aa_loader').hide();
				

        },
			error: function (jqXHR, exception) {
				if (jqXHR.status === 500) {
					alert('No Invoice..');
				} else {
					alert('Error While Requesting...');
				}
			}
		});
		
	}else{
		//alert('no');
	}

}

function scrolls(id) {
	$('html, body').animate({
		scrollTop: $('#'+id).offset().top +300
	}, 'slow', function() { 
		$('#'+id).focus(); 
	});
}

function hide_pop(id){
	$('#'+id).popover('hide');
}

function valids(){
	
	var to_line = $('#to_rec').val();
	to_line = parseInt(to_line);
alert('to_line = '+to_line);
	var x= 1;
	for(i=0; i < to_line; i++){
		
		var row_id = $('#row_id'+i).val();
		var mat = $('#all_mat'+i).val();
		
		if(mat==0){
		 
		 show_faded_alert('add_materials'+i,'Please select material');
		 $( "#add_materials"+i).focus();
		 
		 
    
			return false;
		 //$('#err'+i).show(); 
		}else{
			
			hide_pop('add_materials'+i);
			
			var qty  = $('#matqty'+row_id).val();
					 
			if(qty =="" || qty == 0){
				//$('#err_qty'+row_id).show();
				show_faded_alert('matqty'+row_id,'Please Choose Qty');
				return false;
			}else{
				hide_pop('matqty'+row_id);
				$('#err_qty'+row_id).hide();
			}
			
			
			var p_type = $('#label_type'+i).val();
			var format = $('#format'+i).val();
			var printing = $('#prnt_dropdown_'+row_id).val();
			var no_design = $('#designmat'+row_id).val();
			
			var labelsmat = $('#labelsmat'+row_id).val();
			var core = $('#core_'+row_id).val();
			var wound = $('#wound_'+row_id).val();
			var finish = $('#finishdropdown_'+row_id).val();
			
			
			/*alert(p_type);
			alert(format);
			alert(x);
			alert(to_line);*/
			if(p_type=='plain' && format =='sheet'){
                //$('#cut_mat_btn'+i).trigger('click');
				if(x == to_line){
	                        //alert(x+' -0- '+to_line);
					return true;
				}
			}
			
			
			if(p_type=='printed' && format =='sheet'){
				
				//alert(p_type+' -- '+format);
				if(printing==""){
					show_faded_alert('prnt_dropdown_'+row_id,'Please Select Printing');
					$( "#prnt_dropdown_"+row_id).focus();
					//$('#err_printed_sheet'+row_id).show();
					$('#assco'+row_id).removeClass('hide');
					return false;
				}else{
					hide_pop('prnt_dropdown_'+row_id);
					$('#err_printed_sheet'+row_id).hide();
				}
				
				if(no_design=="" || no_design==0){
					 //$('#err_no_designs'+row_id).show();
					 show_faded_alert('designmat'+row_id,'Please Choose no of Designs');
					 $( "#designmat"+row_id).focus();
					return false;
				}else{
					 hide_pop('designmat'+row_id);
					 $('#err_no_designs'+row_id).hide();
				}

                //$('#cut_mat_btn'+i).trigger('click');
					if(qty =="" || qty == 0){
				//$('#err_qty'+row_id).show();
				show_faded_alert('matqty'+row_id,'Please Choose Qty');
				$( "#matqty"+row_id).focus();
				return false;
			}else{
				hide_pop('matqty'+row_id);
				$('#err_qty'+row_id).hide();
			}

					alert('to_line = '+to_line);
					alert('x = '+x);
				if(x == to_line){
				    alert('true = ');
	                //alert(x+' -1- '+to_line);
					return true;
				}
	
			}
			
			
			if(format =='roll' && p_type!='printed'){
				
				$('#assco'+row_id).removeClass('hide');
				
				
				if(core==""){
					
					//$('#err_core_roll'+row_id).show(); 
					show_faded_alert('core_'+row_id,'Please provide Core');
					 $( "#core_"+row_id).focus();
					return false;
				}else{
					hide_pop('core_'+row_id);
					$('#err_core_roll'+row_id).hide();
					
				}
				
				if(wound==""){
					show_faded_alert('wound_'+row_id,'Please provide Wound');
					$( "#wound_"+row_id).focus();
					//$('#err_wound_roll'+row_id).show();
					return false;
				}else{
					hide_pop('wound_'+row_id);
					$('#err_wound_roll'+row_id).hide();
				}
				
				if(labelsmat=="" || labelsmat==0){
					show_faded_alert('labelsmat'+row_id,'Please Enter Labels per Roll');
						$( "#labelsmat"+row_id).focus();
					//$('#err_no_labels'+row_id).show();
					return false;
				}else{
					hide_pop('labelsmat'+row_id);
					$('#err_no_labels'+row_id).hide();
				}

                //$('#cut_mat_btn'+i).trigger('click');
                
                
					if(qty =="" || qty == 0){
				//$('#err_qty'+row_id).show();
				show_faded_alert('matqty'+row_id,'Please Choose Qty');
				$( "#matqty"+row_id).focus();
				return false;
			}else{
				hide_pop('matqty'+row_id);
				$('#err_qty'+row_id).hide();
				//return false;
				
			}


                // alert('roll to_line = '+to_line);
                // alert('roll x = '+x);
                if(x == to_line){
                    // alert('true = ');
	//alert(x+' -2- '+to_line);
					return true;
				}
	
				
			}
			
			
			if(p_type=='printed' && format =='roll'){
				
				$('#assco'+row_id).removeClass('hide');
				
				
				if(printing==""){
					show_faded_alert('prnt_dropdown_'+row_id,'Please Select Printing');
						$( "#prnt_dropdown_"+row_id).focus();
					//$('#err_printeds'+row_id).show();
					return false;
				}else{
					hide_pop('prnt_dropdown_'+row_id);
					$('#err_printeds'+row_id).hide();
				}
				
				if(finish==""){
					
					//$('#err_finish_roll'+row_id).show(); 
					show_faded_alert('finishdropdown_'+row_id,'Please Select Finish');
						$( "#finishdropdown_"+row_id).focus();
					return false;
				}else{
					hide_pop('finishdropdown_'+row_id);
					$('#err_finish_roll'+row_id).hide();
				}
				
				
				if(core==""){
					
					//$('#err_core_roll'+row_id).show();
					show_faded_alert('core_'+row_id,'Please provide Core');
						$( "#core_"+row_id).focus();
					return false;
				}else{
					hide_pop('core_'+row_id);
					$('#err_core_roll'+row_id).hide();
				}
				
				if(wound==""){
					show_faded_alert('wound_'+row_id,'Please provide Wound');
						$( "#wound_"+row_id).focus();
					//$('#err_wound_roll'+row_id).show();
					return false;
				}else{
					hide_pop('wound_'+row_id);
					$('#err_wound_roll'+row_id).hide();
				}
				
				if(no_design=="" || no_design==0){
					 //$('#err_no_designs'+row_id).show();
					 show_faded_alert('designmat'+row_id,'Please Choose No of Designs');
					 	$( "#designmat"+row_id).focus();
					return false;
				}else{
					 hide_pop('designmat'+row_id);
					 $('#err_no_designs'+row_id).hide();
				}
				
				if(labelsmat=="" || labelsmat==0){
					show_faded_alert('labelsmat'+row_id,'Please Choose Total Labels');
						$( "#labelsmat"+row_id).focus();
					//$('#err_no_labels'+row_id).show();
					return false;
				}else{
					hide_pop('labelsmat'+row_id);
					$('#err_no_labels'+row_id).hide();
				}
				
				if(no_design=="" || no_design==0){
					 //$('#err_no_designs'+row_id).show();
					 show_faded_alert('designmat'+row_id,'Please Choose no of Designs');
					return false;
				}else{
					 hide_pop('designmat'+row_id);
					 $('#err_no_designs'+row_id).hide();
				}
				
				

                //$('#cut_mat_btn'+i).trigger('click');
				//alert(x+' -- '+to_line);
				
					if(qty =="" || qty == 0){
				//$('#err_qty'+row_id).show();
				show_faded_alert('matqty'+row_id,'Please Choose Qty');
				$( "#matqty"+row_id).focus();
				return false;
			}else{
				hide_pop('matqty'+row_id);
				$('#err_qty'+row_id).hide();
			}
			
			
				if(x == to_line){
	//alert(x+' -3- '+to_line);
					return true;
				}
	
			}


			
	}
		
	x++; 
	}
	
	
	

}


function showcartPage() {

    checkout();
}


$(document).on("click",".compare_btn",function(e){
    var type = $(this).data('type');
    var categories = [];
    var count = $("input[name='compare_check']:checked").length;
    if(count < 2)
    {
        swal("Please select atleast 2 items");
        return false;
    }
    else
    {
        //$(this).html("Please Wait <i class='fa fa-spin fa-refresh'></i>");
        var orig_text = $(this).parents('.compare_div').find('.compare_btn').text();
        var load_text = orig_text + " <i class='fa fa-spin fa-refresh'></i>";
        $(this).parents('.compare_div').find('.compare_btn').html(load_text);

        $.each($("input[name='compare_check']:checked"),function(ind,val){
            categories.push($(this).val());
            $(this).parents('.compare_div').find('.compare_btn').addClass('disabled');
        });

        show_reposition_loader(this);
        //$("#aa_loader").show();
        //enable loader
        var _this  = $(this);
        $.ajax({
            type:"POST",
            url:mainUrl+'search/search/comparison_popup',
            data:{
                cats:categories,
                type:type
            },
            success:function(data)
            {
                if(!data == '')
                {
                    $(_this).parents('.compare_div').find('.compare_btn').html(orig_text);
                    //console.log(orig_text);
                    $.each($("input[name='compare_check']:checked"),function(ind,val){
                        $(this).parents('.compare_div').find('.compare_btn').removeClass('disabled');
                    });
                    $("#compare_modal_content").html(data.html);
                    $("#compare_modal").modal('show');
                    $("#aa_loader").hide();
                }
            }
        });
    }
});
$(document).on("change","input[name='compare_check']",function(e){
    var count = $("input[name='compare_check']:checked").length;
    var checked = $(this).prop('checked');
    var _this = $(this);

    if(checked)
    {
        if(count <= 4)
        {
            $(this).parents(".compare_div").find(".compare_btn").prop("disabled",false);
            $(this).parents(".compare_div").find(".compare_btn").removeAttr("disabled");
            //$(this).parents(".compare_div").find(".compare_btn").text("Compare "+count+" of 4");
        }
    }
    else
    {
        $(this).parents(".compare_div").find(".compare_btn").prop("disabled",true);
        $(this).parents(".compare_div").find(".compare_btn").attr("disabled","disabled");
        $(this).parents(".compare_div").find(".compare_btn").text("Compare");
    }
    calculate_checks(_this,checked);
    if(count > 4)
    {
        if(checked)
        {
            $(this).prop('checked',false);
            swal("A maximum of 4 items can compared at one time.");
            $(this).parents(".compare_div").find(".compare_btn").text("Compare");
            return false;
        }
    }
});
$(document).on("click", ".layout_specs", function(e) {
    var id = $(this).attr('id');
    var imgpath = $(this).attr('imgpath');
    $('#ajax_layout_spec').html('');

    $.ajax({
        url: mainUrl+'search/search/layout_popup/'+id,
        type:"POST",
        async:"false",
        dataType: "html",
        success: function(data){
            if(!data==''){
                data = $.parseJSON(data);

                $('#layout_up').html(data.html);
                $('#lay_pop_up').modal('show');
                if(typeof imgpath !=='undefined' && imgpath!==''){
                    $('#ajax_layout_spec').find('.design-image').attr('src',imgpath);
                }
            }
        }
    });

});

function getMaterialPage(shape,categoryId,productid=null,regmark=null){
    $('#material_tab').removeClass('disbaledd').addClass('activated')
    $('#aa_loader').show();
    
    $('.compare_class_disable').attr('disabled','disabled');
    $('.compare_class_disable').prop('disabled',true);
    
	
    $.ajax({
        type: "post",
        url: mainUrl + "search/search/material",
        cache: false,
        data: {'catid':categoryId,'shape':shape,'productid':productid,regmark:regmark},
        dataType:'html',
        success: function (data){
            $('#aa_loader').hide();
            $('.registration_mark').modal('hide');
            var msg = $.parseJSON(data);
            var pageName = $('#mypageName').val();

            if(pageName != null && pageName !="" && pageName !='undefined'){

                $('#ajax_material_sorting').hide();
                $('#placeSearch').hide();
                $('#order_detail_material').empty();
                $('.ajax_material_sorting').hide();
                $('#order_detail_material').html(msg.html);
                $('#compare_modal').modal('hide');
                /*$('html, body').animate({
                    scrollTop: $("#order_detail_material").offset().top
                }, 2000);*/
                timeForMaterial();
            }else{

                $('#material_tab').removeClass('disbaledd');
                $('#material_tab_link').attr('onclick','showmaterial()');
                activeTab('material_tab_link');
                showAndHideTabs('material_page');
                $('#compare_modal').modal('hide');
                $('#ajax_material_sorting').hide();
                $('.ajax_material_sorting').hide();
                $('#material_page').empty();
                $('#material_page').html(msg.html);
                /*$('html, body').animate({
                    scrollTop: $("#order_detail_material").offset({top:10})
                }, 2000);*/
                timeForMaterial();
            }


        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('Sorry For Wait');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}

function getOrderDetailMaterialPage(shape,categoryId, pageName =null,prodouctId=null,regmark=null){
    $.ajax({
        type: "post",
        url: mainUrl + "search/search/material",
        cache: false,
        data: {'catid':categoryId,pageName:pageName,shape:shape,prodouctId:prodouctId,regmark:regmark},
        dataType:'html',
        success: function (data){
            $('.registration_mark').modal('hide');
            var msg = $.parseJSON(data);

            $('#compare_modal').modal('hide');

            $('#ajax_material_sorting').hide();
            $('#placeSearch').hide();

            $('#order_detail_material').html(msg.html);

            /*$('html, body').animate({
                scrollTop: $("#order_detail_material").offset().top
            }, 2000);*/
            timeForMaterial();
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

function timeForMaterial() {
    var is_holiday ='no'
    var d = new Date();
    var weekday = new Array(7);
    weekday[0]=  "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";

    var n = weekday[d.getDay()];


    var now=new Date();
    var closing=new Date(now.getFullYear(),now.getMonth(),now.getDate(),16);//Set this to 04:00pm on the present day
    var diff=closing-now;//Time difference in milliseconds

    if((n=="Friday" && diff < 0 ) || n=="Saturday" || n=="Sunday" || is_holiday=='yes'){
        var html_msg=  '<i class="fa fa-3x  faa-horizontal animated fa-truck Blue2 pull-left "></i><div class="upper_div pull-right "><span style="color: #fd4913;">NEXT DAY DELIVERY</span>';
        html_msg=  html_msg+'<p class="text-left f-12">The next day delivery option is <br/>now closed. <a href="#" data-toggle="tooltip" title="Order before 16:00 (Mon to Fri) to use the next working day delivery service" data-placement="bottom"> Read more.</a></p></div>';

        $('#timer_div').html(html_msg);
        $('.material_clock').html('<b>Order before 16:00 for Next Day Delivery</b>');
    }
    else if(diff<0){

        var html_msg=  '<i class="fa fa-3x  faa-horizontal animated fa-truck Blue2 pull-left "></i><div class="upper_div pull-right "><span style="color: #fd4913;">NEXT DAY DELIVERY</span>';
        html_msg=  html_msg+'<p class="text-left f-12">The next day delivery option <br/>is now closed. <a href="#" data-toggle="tooltip" title="Order before 16:00 (Mon to Fri) to use the next working day delivery service" data-placement="bottom"> Read more.</a></p></div>';

        $('#timer_div').html(html_msg);
        $('.material_clock').html('<b>Order before 16:00 for Next Day Delivery</b>');

    }
    else{

        var hours=Math.floor(diff/(1000*60*60));
        diff=diff%(1000*60*60);
        var mins=Math.floor(diff/(1000*60));
        var minsInHousrs = parseFloat(diff/(1000*60*60)).toFixed(2);
        diff=diff%(1000*60);
        var secInHousrs = parseFloat(diff/(1000*60*60)).toFixed(3);
        var secs=Math.floor(diff/(1000));
        var time = (hours+parseFloat(minsInHousrs)+parseFloat(secInHousrs));
        var val = time * 60 * 60 * 1000;
        selectedDate = new Date().valueOf() + val;
        $('.clock_time').countdown(selectedDate.toString(),function(event) {
            $(this).html(event.strftime('%H<span>H</span>: %M<span>M</span>: %S<span>S</span>'));

        });
    }

    // $('[data-toggle="tooltip"]').tooltip();
    // $(".globe-map").aaZoom();
}

function showPaymentSection() {
    $('#dl_pm_tab').removeClass('disbaledd');
    $('#dl_pm_link').attr('onclick',"showPaymentSection()");
    activeTab('dl_pm_link');
    $('#onlypayment').hide();
    $('#payment_section').show();
}

function getIntegratedDetail(category) {
    $.ajax({
        type: "get",
        url: mainUrl + "search/search/integrated_detail",
        cache: false,
        data: {'catid':category},
        dataType:'html',
        success: function(data)
        {
            var msg = $.parseJSON(data);

            activeTab('material_tab_link');

            showAndHideTabs('material_page');

            $('#ajax_material_sorting').hide();
			$('#compare_modal').modal('hide');

            $('#placeSearch').hide();
            if($('#mypageName').val() == null){
            $('#material_page').html(msg.html);
            }else{
            $('#order_detail_material').html(msg.html);
            }

            /*$('html, body').animate({
                scrollTop: $("#order_detail_material").offset().top
            }, 2000);*/
            timeForMaterial();
        },
        error: function(){
			$('#compare_modal').modal('hide');
            alert('Error while request..');
        }
    });
}

function showAndHideTabs(tabId){

    var tabsArray = ['material_page','format_page','customer','customer_orders','complete_payment_for','products_list','confirm_my_order','confirm_my_quotation','ajax_material_sorting'];
    var a=0;
    for(a; a <= tabsArray.length;a++){
        if(tabId == tabsArray[a]){
            $('#'+tabId).show();
        }else{
            $('#'+tabsArray[a]).hide();
        }
    }
    return true;
}

function activeTab(tabId){

    var tabsArray = ['customer_link','first_format_link','material_tab_link','od_qt_link','dl_pm_link','ord_qu_Crf_link'];
    var a=0;
    for(a; a <= tabsArray.length;a++){
        if(tabId == tabsArray[a]){
            $('#'+tabId).addClass('active show');
        }else{
            $('#'+tabsArray[a]).removeClass('active show');
        }
    }
    return true;
}























$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip-digital"]').tooltip();
    $("[data-toggle=tooltip-product]").tooltip();
    $(':not([data-toggle="popover"])').popover('hide');
});


$(document).on("click", ".productdetails .dm-selector li a", function (e) {

    var selText = $(this).text();

    var value = $(this).attr('data-value');

    var type = $(this).attr('data-id');

    if (value.length > 0) {

        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText + ' <i class="fa fa-unsorted"></i>');

        if (type === 'digital') {

            $(this).parents('.productdetails').find('.digitalprintoption').val(value);

        }

        else {

            $(this).parents('.productdetails').find('.orientation').val(value);

        }


    } else {

        if (type === 'digital') {

            $(this).parents('.btn-group').find('.dropdown-toggle').html('Select Digital Print Process <i class="fa fa-unsorted"></i>');

            $(this).parents('.productdetails').find('.digitalprintoption').val('');

        } else {

            $(this).parents('.btn-group').find('.dropdown-toggle').html('Orientation 01 <i class="fa fa-unsorted"></i>');

            $(this).parents('.productdetails').find('.orientation').val(1);

        }

    }

    reset_print_input_buttons(this);

});




$(document).on("click", ".calculate_plain", function(e) {

    var Printable =  $(this).parents('.productdetails').find('.PrintableProduct').val();
    var id =  $(this).parents('.productdetails').find('.product_id').val();
    var menuid =  $(this).parents('.productdetails').find('.manfactureid').val();
    var labels =  $(this).parents('.productdetails').find('.LabelsPerSheet').val();
    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());
    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());
    var input_id = $(this).parents('.productdetails').find('.plainsheet_input');
    var qty = parseInt(input_id.val());
    var unitqty =  $(this).parents('.productdetails').find('.plainsheet_unit').text(); //Sheets Labels
    unitqty = $.trim(unitqty);
    var _this = this;
    if(unitqty =='Labels'){
        var min_qty = parseInt(labels)*min_qty;
        var max_qty = parseInt(labels)*max_qty;
    }
    if(!is_numeric(qty) || qty=='' || qty < min_qty){
        input_id.val(min_qty);
        if(unitqty == "Labels"){
            show_faded_popover(input_id, 'Quantity has been amended for production as '+min_qty+' labels.');
        }else{
            show_faded_popover(input_id, 'Quantity has been amended for production as '+min_qty+' sheets.');
        }
        return false;
    }
    else if(qty > max_qty){
        input_id.val(max_qty);
        if(unitqty =='Labels'){
            show_faded_popover(input_id, 'Quantity has been amended for production as '+max_qty+' labels.');
        }else{
            show_faded_popover(input_id, 'Quantity has been amended for production as '+max_qty+' sheets.');
        }
        return false;
    }
    else{
        if(qty%labels != 0 && unitqty == 'Labels'){
            var multipyer = parseInt(labels) * parseInt(parseInt(qty/labels)+1);
            input_id.val(multipyer);
            var qty = multipyer;
        }
        if(unitqty =='Labels'){qty = parseInt(qty/labels);}
        change_btn_state(_this,'disable','plain');
        var pageName =  $('#mypageName').val();
        $.ajax({
            url: mainUrl+'search/search/calculate_sheet_price',
            type:"POST",
            async:"false",
            dataType: "html",
            data: {  qty: qty,menuid: menuid,prd_id:id,labels:labels,labeltype:'plain',printprice:'enabled'},
            success: function(data){
                if(!data==''){
                    data = $.parseJSON(data);
                    if(data.response=='yes'){

                        var pageName =  $('#mypageName').val();
                        if(pageName == 'quotation'){
                            $('.add_plain').text('Add To Quotation');
                        }else if(pageName == 'order'){
                            $('.add_plain').text('Add To Order');
                        }

                        $('#od_dt_price').val(data.plain);
                        //$('#od_dt_printed').val(data.printprice);

                        change_btn_state(_this,'enable','plain');
                        $(_this).parents('.productdetails').find('.calculate_plain').hide();
                        $(_this).parents('.productdetails').find('.add_plain').show();
                        $(_this).parents('.productdetails').find('.addprintingoption').show();
                        $(_this).parents('.productdetails').find('.plain_save_txt').html(data.save_txt).show();
                        //$('#delivery_txt'+id).html(' <i class="cBlue  f-20 fa fa-truck"></i> '+data.delivery_txt);
                        $(_this).parents('.productdetails').find('.plainprice_text').html(data.price);
                        $(_this).parents('.productdetails').find('.original_price').html('<b class="pr-sm">'+data.symbol+data.original_price+'</b>');
                        $(_this).parents('.productdetails').find('.promotion_price').html('-<b class="pr-sm">'+data.symbol+data.promotion_price_txt+'</b>');
                        if(data.promotion_price_txt == null || data.promotion_price_txt == 0 || data.promotion_price_txt == 0.00)
                        {
                            $(_this).parents('.productdetails').find('.plainprice_box').find('tr.plainprice').hide();
                            $(_this).parents('.productdetails').find('.plainprice_box').find('tr.halfprintprice').hide();
                        }
                        else
                        {
                            $(_this).parents('.productdetails').find('.plainprice_box').find('tr.plainprice').show();
                            $(_this).parents('.productdetails').find('.plainprice_box').find('tr.halfprintprice').show();
                            $(_this).parents('.productdetails').find('.plainprice_box').find('.percentage_discount').text(data.percentage_discount);

                        }
                        $(_this).parents('.productdetails').find('.plainperlabels_text').html(data.labelprice);
                        $(_this).parents('.productdetails').find('.plainprice_box').show();
                        if(Printable=='Y'){
                            $(_this).parents('.productdetails').find('.printing_offer_text').html(data.symbol+''+data.onlyprintprice);
                            $(_this).parents('.productdetails').find('.addprintingoption').removeClass('hide');
                        }
                    }
                }
            }
        });
    }
});

$(document).on("click", ".artwork_uploader", function (e) {

    var cart_id = $(this).parents('.productdetails').find('.cart_id').val();
    var product_id = $(this).parents('.productdetails').find('.product_id').val();
    var manfactureid = $(this).parents('.productdetails').find('.manfactureid').val();
    var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();
    var unitqty = $(this).parents('.productdetails').find('.printedsheet_unit').text(); //Sheets Labels
    var paperSize = $('#papersize').val();
    unitqty = $.trim(unitqty);
    var _this = this;
    parent_selector = this;

   $('#ajax_artwork_uploads').html('');
    $('#artworks_uploads_loader').show();
	
    $.ajax({
        url: mainUrl + 'search/search/view_artworks_content',
        type: "POST",
        async: "false",
        data: {
            manfactureid: manfactureid,
            product_id: product_id,
            type: paperSize,
            labelspersheet: labels,
            cart_id: cart_id,
            unitqty: unitqty,
        },

        dataType: "html",
        success: function (data) {

            if (!data == '') {
                data = $.parseJSON(data);
                //console.log(data.html);
                update_printed_quantity_box(data.qty, data.designs);
                $('#artworks_uploads_loader').hide();
                $('#ajax_artwork_uploadssss').html(data.html);
                intialize_progressbar();
                if (cart_id.length == 0 || cart_id == '') {
                    $(_this).parents('.productdetails').find('.cart_id').val(data.cartid);
                }
            }
        }
    });
});

function update_printed_quantity_box(qty, designs) {

    var product_id = $(parent_selector).parents('.productdetails').find('.product_id').val();

    $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).val(designs);

    var unitqty = $(parent_selector).parents('.productdetails').find('.printedsheet_unit').text();

    var labels = $(parent_selector).parents('.productdetails').find('.LabelsPerSheet').val();

    unitqty = $.trim(unitqty);

    if (unitqty == 'Labels') {

        var sheets = parseInt(qty / labels);

    } else {

        var sheets = qty;

    }

    $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-qty', sheets);

    var old_quantity = parseInt($(parent_selector).parents('.productdetails').find('.printedsheet_input').val());

    if (qty > 0) {

        $(parent_selector).parents('.productdetails').find('.printedsheet_input').val(qty);

        reset_print_input_buttons(parent_selector);

    }


    if($('#no_artworks_'+product_id).val() == 0){
       update_artwork_upload_btn(parent_selector, designs);
    } 

}





function update_artwork_upload_btn(_this, designs) {

    if (designs > 0) {

        var Artwork = 'Artwork';

        if (designs > 1) {

            var Artwork = 'Artworks';

        }

        $(_this).parents('.productdetails').find('.artwork_uploader').switchClass('art-btn', 'art-btn-l');
			  $(_this).parents('.productdetails').find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

        var btnhtml = '<div class="row"><div class="col-md-4"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>';

        btnhtml += '<div class="col-md-8"><b>' + designs + ' ' + Artwork + ' Uploaded </b>';

        btnhtml += '<small>Click here to upload further<br>artworks, view or edit.</small></div></div>';

        $(_this).parents('.productdetails').find('.artwork_uploader').html(btnhtml);
			  $(_this).parents('.productdetails').find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

    } else {

        $(_this).parents('.productdetails').find('.artwork_uploader').switchClass('art-btn-l', 'art-btn');
			  $(_this).parents('.productdetails').find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

        var btnhtml = '<i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Click here to Upload Your Artwork';

        $(_this).parents('.productdetails').find('.artwork_uploader').html(btnhtml);
			  $(_this).parents('.productdetails').find('.artwork_uploader_roll').switchClass('art-btn', 'art-btn-l');

    }

}

$(document).on("click", ".browse_btn", function (e) {
//alert(222);
    $(this).parents('.upload_row').find('.artwork_file').click();

});

$(document).on("change", ".artwork_file", function (e) {
    var id = $('#arworklineCounter').val();
    readURL(this,id);

});

function readURL(input,id=null) {


    if (input.files && input.files[0]) {

        var url = input.value;

        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

        if (ext == 'docx' || ext == 'doc') {

            $('#preview_po_img'+id).attr('src', "<?=Assets?>images/doc.png");
            $('#preview_po_img').attr('src', '<?=Assets?>images/doc.png');

            $('#preview_po_img'+id).show();
            $('#preview_po_img').show();

            $('.upload-btn-wrapper').hide();
            $('.browse_btn').hide();

        }

        else if (ext == 'pdf') {

            $('#preview_po_img'+id).attr('src', '<?=Assets?>images/pdf.png');
            $('#preview_po_img').attr('src', '<?=Assets?>images/doc.png');
            $('#preview_po_img'+id).show();
            $('#preview_po_img').show();
            $('.upload-btn-wrapper').hide();
            $('.browse_btn').hide();

        }

        else if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {


            var reader = new FileReader();

            reader.onload = function (e) {

                $('#preview_po_img'+id).attr('src', e.target.result);
                $('#preview_po_img').attr('src', e.target.result);
                $('#preview_po_img'+id).show();
                $('#preview_po_img').show();

                $('.upload-btn-wrapper').hide();
                $('.enquiry').show();
                $('.browse_btn').hide();

            }

            reader.readAsDataURL(input.files[0]);

        }

        else {

            $('#preview_po_img'+id).attr('src', '<?=Assets?>images/no-image.png');
            $('#preview_po_img').attr('src', '<?=Assets?>images/doc.png');
            $('#preview_po_img'+id).show();
            $('#preview_po_img').show();
            $('.upload-btn-wrapper').hide();
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


/*$(document).on("click", ".save_artwork_file", function (e) {

    var _this = this;

    var cartid = $('#cartid').val();

    var prdid = $('#cartproductid').val();

    var labelpersheets = $('#labels_p_sheet').val();
   var type = $('#arwork_type_on_page').val();

   if(type == 'a4'){
       type = 'sheet';
   }else{
       type = 'roll';
   }
   if(type == 'roll'){

        var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();

       var file = $(_this).parents('.upload_row').find('.artwork_file').val();

     var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];

       var product_id =  $(parent_selector).parents('.productdetails').find('.product_id').val();

       var presproof = $(parent_selector).parents('.productdetails').find('#uploadedartworks_'+product_id).attr('data-presproof');



        var response = '';



       response = verify_labels_or_rolls_qty(_this);

        if(response==false){ return false;}

       var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();

        var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();

        var lb_txt = 'labels';



        if(file.length==0){

            alert_box("Please upload a file before saving. ");

        }

        else if(labels==0 || labels==''){

          alert_box("Please complete line ");

        }

        else if(artworkname.length==0){

            alert_box("please enter artwork name! ");

        }

        else{



            var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];

            var form_data = new FormData();
            form_data.append("file", uploadfile)
           form_data.append("cartid",cartid);
            form_data.append("productid",prdid);
            form_data.append("labels",labels);
            form_data.append("sheets",sheets);
            form_data.append("artworkname",artworkname);
            form_data.append("persheet",labelpersheets);
            form_data.append("type",'rolls');
            form_data.append("size",$('.heigh_roll').val());
            form_data.append("gap",$('.gap_roll').val());
            form_data.append("presproof",presproof);









            type = uploadfile.type;



            if(type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript' ) {

                swal("Not Allowed","We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG","warning");

                return false;

            }else{

                upload_printing_artworks(form_data);

            }

        }
    }

    else{

        var cartunitqty = $('#cartunitqty').val();


        var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();

        var file = $(_this).parents('.upload_row').find('.artwork_file').val();


        //  var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];


        var response = '';


        if (cartunitqty == 'Labels') {

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

            if (sheets.length > 5) {

                var id = $(_this).parents('.upload_row').find('.labels_input');

                var popover = $(_this).parents('.upload_row').find('.popover').length;

                if (popover == 0) {

                    show_faded_popover(id, "Max 50000 sheet Allowed ");
                    $(_this).val(50000);
                }

                return false;

            }

            var labels = parseInt(sheets * labelpersheets);

            var lb_txt = 'sheets';

        }


        if (file.length == 0) {

            alert_box("Please upload a file before saving. ");

        }

        else if (labels == 0 || labels == '') {

            alert_box("Please complete line ");

        }

        else if (artworkname.length == 0) {

            alert_box("please enter artwork name! ");

        }

        else {


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


           if (type != 'image/tiff' && type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript') {
              swal("Not Allowed", "We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG", "warning");

               return false;
          } else {

              upload_printing_artworks(form_data);

           }

        }
  }



});*/


function upload_printing_artworks_oldss(form_data) {
    console.log(form_data);

    $.ajax({
        url: mainUrl +'search/Search/upload_material_artworks',
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
            $('.save_artwork_file').prop('disabled', true);
            $('.save_artwork_file_roll').prop('disabled', true);
			
       },
		
      success: function (data) {
			
        //alert('success');

        $('.save_artwork_file').prop('disabled', false);
        data = $.parseJSON(data);
        if (data.response == 'yes') {
          update_printed_quantity_box(data.qty, data.designs);
          $('#ajax_upload_content').html(data.content);
                
				
                
          //alert(data.response);
          $("#upload_progress").hide();
        } else {
          //alert('alert');
          swal('upload failed', data.message, 'error');
          intialize_progressbar();
          $("#upload_progress").hide();
          $('.save_artwork_file').prop('disabled', false);
        }
      },
      error: function (data) {
		  
        swal('Some error occured please try again');
        intialize_progressbar();
        $("#upload_progress").hide();
        $('.save_artwork_file').prop('disabled', false);
      }
    });
}


$(document).on("click", ".add_another_art", function (e) {
    $('.upload_row').show();
    $(this).hide();
    $('#add_another_line').hide();
});



$(document).on("click", ".hide_another_art", function (e) {
    
	
	$('.uploadsavesection').find('.artwork_name').val('');
  $('.uploadsavesection').find('.displaysheets').text('');
  $('.uploadsavesection').find('.labels_input').val('');
	$('.uploadsavesection').find('.roll_labels_input ').val('');
	$('.uploadsavesection').find('#preview_po_img').attr('src', '');
	$('.uploadsavesection').find('#preview_po_img').hide();
	$('.uploadsavesection').find('.upload-btn-wrapper').show();
	$('.uploadsavesection').find('.artwork_upload_cta').show();
 $('.uploadsavesection').find('.fart').hide();
 
  $("#follow_art").prop("checked", false);

  
  total_upload_labels();
	 
	
	$('.uploadsavesection').find('.artwork_file').empty();
	$('#add_another_line').show();
	$('.add_another_art').show();
	$('.uploadsavesection').hide();
	
    //$(this).hide();
    
});



function alert_box(text){
    swal({
        title: "",
        text: text,
        cancelButtonColor: "#17b1e3",
        confirmButtonText: "Continue",
        type: "",
    });


    /*swal({
        title: "",
        text: text,
        icon: "warning",
        button: "ok!",
    });*/


    /*swal(text,
        {
            buttons: {
                cancel: "OK",
            },
            icon: "warning",
            closeOnClickOutside: false,
        }
    );*/
}


function intialize_progressbar(){
    $("#progressbar").progressbar({
        value: 100,
        create: function( event, ui ) {
            $(this).removeClass("ui-corner-all").addClass('progress').find(">:first-child").removeClass("ui-corner-left").addClass('progress-bar progress-bar-success');
        }
    });
}

function progress(e) {
            if (e.lengthComputable) {

                var max = e.total;

                var current = e.loaded;

                var Percentage = Math.ceil((current * 100) / max);

                $("#progressbar").progressbar("option", "value", Percentage);

                $("#upload_pecentage").html(' &nbsp;' + Percentage + '%');


                if (Percentage >= 100) {

                    $("#progressbar").progressbar("option", "value", 100);

                    $("#upload_pecentage").html(' &nbsp;100%');

                }

            }

        }



function reset_print_input_buttons(_this) {

    $(_this).parents('.productdetails').find('.printedprice_box').hide();

    $(_this).parents('.productdetails').find('.add_printed').hide();

    $(_this).parents('.productdetails').find('.calculate_printed').show();

}

$(document).on("click", ".calculate_printed", function(e) {

    var id =  $(this).parents('.productdetails').find('.product_id').val();

    var cart_id =  $(this).parents('.productdetails').find('.cart_id').val();

    var menuid =  $(this).parents('.productdetails').find('.manfactureid').val();

    var labels =  $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    var printing = $(this).parents('.productdetails').find('.digitalprintoption').val();

    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());

    var unitqty =  $(this).parents('.productdetails').find('.printedsheet_unit').text(); //Sheets Labels

    var upload_qty = parseInt($(this).parents('.productdetails').find('#uploadedartworks_'+id).attr('data-qty'));

    var artworks = parseInt($(this).parents('.productdetails').find('#uploadedartworks_'+id).val());
    
    var manual_design = parseInt($(this).parents('.productdetails').find('#no_artworks_'+id).val());
    
    



    unitqty = $.trim(unitqty);



    var input_id = $(this).parents('.productdetails').find('.printedsheet_input');

    var qty =  input_id.val();

    var _this = this;

    if(unitqty =='Labels'){

        var min_qty = parseInt(labels)*min_qty;

        var max_qty = parseInt(labels)*max_qty;

    }

    if(!is_numeric(qty) || qty=='' || qty < min_qty){

        input_id.val(min_qty);

        if(unitqty == "Labels"){

            show_faded_popover(input_id, 'Quantity has been amended for production as '+min_qty+' labels.');

        }else{

            show_faded_popover(input_id, 'Quantity has been amended for production as '+min_qty+' sheets.');

        }

    }

    else if(qty > max_qty){

        input_id.val(max_qty);

        if(unitqty =='Labels'){

            show_faded_popover(input_id, 'Quantity has been amended for production as '+max_qty+' labels.');

        }else{

            show_faded_popover(input_id, 'Quantity has been amended for production as '+max_qty+' sheets.');

        }

    }

    else if(printing == '' || printing.length == 0){

        swal({

            title: "Please Select",

            text: "Digital Print Process ",

            confirmButtonText: "Continue",

            type: "",

        });

    }

    else{

        if(printing == '4 Colour Digital Process'){var printing = 'Fullcolour'; }

        else{ var printing = 'Mono'; }





        if(qty%labels != 0 && unitqty == 'Labels'){

            var multipyer = parseInt(labels) * parseInt(parseInt(qty/labels)+1);

            input_id.val(multipyer);

            var qty = multipyer;

        }



        if(unitqty =='Labels'){

            qty = parseInt(qty/labels);

            //upload_qty = parseInt(upload_qty/labels);

        }

        if(artworks > 1 && upload_qty!= qty && upload_qty!=0){

            $(this).parents('.productdetails').find('.artwork_uploader').click();

            alert_box("You have changed the quantity of "+unitqty+" please amend quantities against each uploaded artwork.");

            return false;

        }


        if(manual_design > 1 && manual_design!= qty && manual_design!=0 && manual_design > qty){
          alert_box("Design Quantity amended " + qty);
          update_artwork_design(id,qty);
          $('#no_design_pop').val(qty);
          $('#no_artworks_'+id).val(qty);
          return false;
        }

        change_btn_state(_this,'disable','printed');

        $.ajax({

            url: mainUrl+'search/search/calculate_sheet_price',

            type:"POST",

            async:"false",

            dataType: "html",

            data: {  qty: qty,menuid: menuid,prd_id: id,labels:labels,labeltype:printing,cart_id:cart_id,manual_design: manual_design},

            success: function(data){

                if(!data==''){

                    data = $.parseJSON(data);

                    if(data.response=='yes'){

                        var pageName =  $('#mypageName').val();
                        if(pageName == 'quotation'){
                            $('.add_printed').text('Add To Quotation');
                        }else if(pageName == 'order'){
                            $('.add_printed').text('Add To Order');
                        }

                        $('#od_dt_price').val(data.plain);
                        $('#od_dt_printed').val(data.printprice);
                        $('#designPrice').val(data.designprice);

                        change_btn_state(_this,'enable','printed');

                        $(_this).parents('.productdetails').find('.calculate_printed').hide();

                        $(_this).parents('.productdetails').find('.add_printed').show();

                        if(printing=='Fullcolour'){

                            $(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.phead').text('Printed Full Color');

                        }else if(printing=='Mono'){

                            $(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.phead').text('Printed Black');

                        }



                        $(_this).parents('.productdetails').find('.printedprice_box .price .plainprice').find('.plaintext').html('<b class="pr-sm">'+data.symbol+data.plain+'</b>');

                        $(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.printtext').html('<b class="pr-sm">'+data.symbol+data.halfprintprice+'</b>');

                        $(_this).parents('.productdetails').find('.printedprice_box .price .halfprintprice').find('.halfprinttext').html('-<b class="pr-sm">'+data.symbol+data.printprice+'</b>');



                        $(_this).parents('.productdetails').find('.printedprice_box .price .no_design').find('.phead').html(data.artworks+' Design Free');

                        $(_this).parents('.productdetails').find('.printedprice_box .price .desgincharge').find('.desginprice').html('<b class="pr-sm">'+data.symbol+data.designprice+'</b>');



                        $(_this).parents('.productdetails').find('.printedprice_text').html(data.price);

                        $(_this).parents('.productdetails').find('.printedperlabels_text').html(data.labelprice);

                        $(_this).parents('.productdetails').find('.printedprice_box').show();



                    }

                }

            }

        });

    }

});
var timer = '';
function show_faded_popover(_this, text){

    $(_this).attr('data-content','');

    $(_this).popover('hide');





    $(_this).popover({'placement':'top'});

    $(_this).attr('data-content',text);

    $(_this).popover('show');



    clearTimeout(timer);

    timer = setTimeout(function(){

        $(_this).attr('data-content','');

        $(_this).popover('hide');



    }, 2000);

}

function change_btn_state(_this,state,type)
{
    var btn_text = $.trim($(_this).text());
    var btn_html = $.trim($(_this).html());
    if(state == 'disable')
    {
        if(type == 'proceed-print')
        {
            $(_this).html(btn_text);
        }
        else
        {
            $(_this).html(btn_text+' <i class="fa fa-spin fa-refresh"></i>');
        }
        $(_this).attr('disabled','disabled');
        $(_this).prop('disabled',true);
    }
    else
    {
        $(_this).removeAttr('disabled');
        $(_this).prop('disabled',false);

        if(type == 'sample')
        {
            $(_this).html(btn_text);
        }
        else if(type == 'step-forward')
        {
            $(_this).html(btn_text+' <i class="fa fa-arrow-circle-right"></i>');
        }
        else
        {
            $(_this).html(btn_text+' <i class="fa fa-calculator"></i>');
        }

    }
}

function addLineIntoOrderDetail(qty,menuid,productId,types,pageName,cart_id=null){

	
	
    var plainPrice     = $('#od_dt_price').val();
    var printedPrice   = $('#od_dt_printed').val();
    var designPrice    = $('#designPrice').val();
    var orderNumber    = $('#order_number').val();
    var digital        =$('.gets_d'+menuid).val();  //$('#digital').first().val(); 
    var per_sheet_roll = $('.LabelsPerSheet').val();
    var useer_id       = $('#useer_id').val();
    
    var uploded_Des = $('#uploadedartworks_'+productId).val();
    var manual_design = $('#no_artworks_'+productId).val();
  
    if(manual_design==""){
      manual_design = 0;
    }
    
      var _this = $("[data-value='"+productId+"']");
      var labels = $(_this).find('.'+types+'sheet_input').val();
    
      if(uploded_Des > 0 || manual_design > 0){
        var Print_Design = '1 Design';
        if(manual_design > 1){
          Print_Design = 'Multiple Designs';
        }
        
      }else{
        Print_Design = '';
      }
  
	  //alert(digital);
    $.ajax({
        url: mainUrl+'order_quotation/Order/addLineIntoOrderDetail',
        type:"POST",
        async:"false",
        dataType: "html",

        data: {pageName:pageName,useer_id:useer_id,per_sheet_roll:per_sheet_roll,orderNumber:orderNumber,qty:qty, menuid:menuid, productId:productId,types:types,digital:digital,plainPrice:plainPrice,printedPrice:printedPrice,cart_id:cart_id,designPrice:designPrice,'brand':'sheet', Print_Design:Print_Design,manual_design:manual_design,labels:labels},

        success: function(data){



            data = $.parseJSON(data);

            if(data.response=='yes'){

                swal(
                    "New Product  Added",




                    {

                        buttons: {

                            catch: {

                                text: "Ok",

                                value: "catch",

                            },


                        },

                        icon: "success",

                        closeOnClickOutside: false,

                    }
                ).then((value) => {

                    switch (value) {


                        case "catch":

                            window.location.reload();

                            break;


                    }

                });

            }

        }
    });
}

function delOrderDetail(key ,serialNumber,ordernumber){
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

                    url: mainUrl+'order_quotation/Order/delOrderDetailLine',

                    type:"POST",

                    async:"false",

                    dataType: "html",

                    data: {serialNumber:serialNumber,ordernumber:ordernumber},

                    success: function(data){

                        data = $.parseJSON(data);

                        if(data.response=='yes'){
                            window.location.reload();
                            //$('#od_dt_line'+serialNumber).remove();
                        }

                    }
                });

                break;


        }

    });

}

function addNote(){
    var title = $('#die_title').val();
    var note = $('#die_note').val();
    var orderNumber =  $('#order_number').val();

    if(title == null || title ==""){
        show_faded_alert('die_title','please Add Title');
        return false;
    }

    if(note == null || note ==""){
        show_faded_alert('die_note','please Add Note');
        return false;
    }

    $.ajax({

        url: mainUrl+'order_quotation/Order/addNote',

        type:"POST",

        async:"false",

        dataType: "html",

        data: {title:title,note:note,orderNumber:orderNumber},

        success: function(data){

            data = $.parseJSON(data);

            if(data.response=='yes'){
                window.location.reload();
            }

        }
    });
}

function updateNote(){
    var title = $('#die_title').val();
    var note = $('#die_note').val();
    var orderNumber =  $('#current_note_id').val();
    $.ajax({

        url: mainUrl+'order_quotation/Order/updateNote',

        type:"POST",

        async:"false",

        dataType: "html",

        data: {title:title,note:note,orderNumber:orderNumber},

        success: function(data){

            data = $.parseJSON(data);

            if(data.response=='yes'){
                window.location.reload();
            }

        }
    });
}

function updateDeclineNote() {
    var title = $('#dec_title').val();
    var note = $('#dec_note').val();
    var orderNumber =  $('#dec_note_id').val();
    $.ajax({

        url: mainUrl+'order_quotation/Order/DeclineNote',

        type:"POST",

        async:"false",

        dataType: "html",

        data: {title:title,note:note,orderNumber:orderNumber},

        success: function(data){

            data = $.parseJSON(data);

            if(data.response=='yes'){
                window.location.reload();
            }

        }
    });
}

function showUpdatePopup(key,noteId){
    $('#die_title').val($('#note_title'+key).val());
    $('#die_note').val($('#note_des'+key).val());
    $('#current_note_id').val(noteId);
    $('#ad_nt').hide();
    $('#up_nt').show();
    $('#add_note_popup').modal('show');
}

function showDeclinePopup(key,noteId){
    $('#dec_title').val($('#note_title'+key).val());
    $('#dec_note').val($('#note_des'+key).val());
    $('#dec_note_id').val(noteId);
    $('#decline_note_popup').modal('show');
}

$(document).on("click", ".add_printed", function (e) {

    var product_id = $(this).parents('.productdetails').find('.product_id').val();

    var prd_name = $(this).parents('.productdetails').find('.product_name').text();

    var cart_id = $(this).parents('.productdetails').find('.cart_id').val();

    var menuid = $(this).parents('.productdetails').find('.manfactureid').val();

    var category_description = $(this).parents('.productdetails').find('.category_description').val();

    var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    var printing = $(this).parents('.productdetails').find('.digitalprintoption').val();
    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());

    var unitqty = $(this).parents('.productdetails').find('.printedsheet_unit').text(); //Sheets Labels
    
     var manual_design = $(this).parents('.productdetails').find('#no_artworks_' + product_id).val();

    unitqty = $.trim(unitqty);

    var input_id = $(this).parents('.productdetails').find('.printedsheet_input');

    var qty = input_id.val();

    var _this = this;
    
   

    var method_on_page =  $('#method_on_page').val();

    if(method_on_page == 'order' || method_on_page == 'quotation'){
        var designsForOrderQuo = $(this).parents('.productdetails').find('#uploadedartworks_' + product_id).val();

        if (designsForOrderQuo == 0 && manual_design==0) {
            swal(
                "Did you forget something?",


                "You can upload your artwork by clicking on the blue “BACK & ADD ARTWORK” button and continue to place your order.\n\nAlternatively you can proceed to place your order by clicking on the orange “CONTINUE & ADD TO BASKET” button and supply your artwork via email later.",

                {

                    buttons: {
                        cancel: "BACK & ADD ARTWORK",
                        catch: {
                            text: "CONTINUE & ADD TO BASKET",
                            value: "catch",
                        },
                    },

                    icon: "success",

                    closeOnClickOutside: false,

                }
            ).then((value) => {

                switch (value) {


                    case "catch":

                        addLineIntoOrderDetail(qty,menuid,product_id,'printed',method_on_page,cart_id);

                        break;


                }

            });
        }
        else{
            addLineIntoOrderDetail(qty,menuid,product_id,'printed',method_on_page,cart_id);
        }

    }else {


        if (unitqty == 'Labels') {

            var min_qty = parseInt(labels) * min_qty;

            var max_qty = parseInt(labels) * max_qty;

        }

        if (!is_numeric(qty) || qty == '' || qty < min_qty) {

            input_id.val(min_qty);

            if (unitqty == "Labels") {

                show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' labels.');

            } else {

                show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' sheets.');

            }

            return false;

        }

        else if (qty > max_qty) {

            input_id.val(max_qty);

            if (unitqty == 'Labels') {

                show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' labels.');

            } else {

                show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' sheets.');

            }

            return false;

        }

        else if (printing == '' || printing.length == 0) {

            swal({

                title: "Please Select",

                text: "Digital Print Process ",

                confirmButtonText: "Continue",

                type: "",

            });

            return false;

        }

        else {

            if (printing == '4 Colour Digital Process') {
                var printing = 'Fullcolour';
            }

            else {
                var printing = 'Mono';
            }

            if (unitqty == 'Labels') {
                qty = parseInt(qty / labels);
            }

            var designs = $(this).parents('.productdetails').find('#uploadedartworks_' + product_id).val();

            if (designs == 0 && manual_design==0) {
                swal(
                    "Did you forget something?",


                    "You can upload your artwork by clicking on the blue “BACK & ADD ARTWORK” button and continue to place your order.\n\nAlternatively you can proceed to place your order by clicking on the orange “CONTINUE & ADD TO BASKET” button and supply your artwork via email later.",

                    {

                        buttons: {

                            cancel: "BACK & ADD ARTWORK",

                            catch: {

                                text: "CONTINUE & ADD TO BASKET",

                                value: "catch",

                            },


                        },

                        icon: "success",

                        closeOnClickOutside: false,

                    }
                ).then((value) => {

                    switch (value) {


                        case "catch":

                            change_btn_state(_this, 'disable', 'printed');

                            $.ajax({

                                url: mainUrl + 'search/search/add_products_incart',

                                type: "POST",

                                async: "false",

                                dataType: "html",

                                data: {
                                    qty: qty,
                                    menuid: menuid,
                                    prd_id: product_id,
                                    labeltype: printing,
                                    printing: printing,
                                    cartid: cart_id,
                                    labels: labels,
                                    manual_design: manual_design,
                                    total_labels: Math.ceil(labels * qty)
                                },

                                success: function (data) {

                                    if (!data == '') {

                                        data = $.parseJSON(data);

                                        if (data.response == 'yes') {

                                            change_btn_state(_this, 'enable', 'printed');

//                                        fireRemarketingTag('Add to cart');

                                            //                                      ecommerce_add_to_cart(_this, 'printed');


                                            $(_this).parents('.productdetails').find('#uploadedartworks_' + product_id).val(0);

                                            $(_this).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-qty', 0);

                                            update_artwork_upload_btn(_this, 0);


                                            //popup_messages(menuid+' - '+prd_name);

                                            checoutPopUp(category_description);

                                            $('#cart').html(data.top_cart);
											update_topbasket();
                                            //$('#basketPrice').text('View Basket - £ ' + data.top_cart[0].price);

                                        }

                                    }

                                }

                            });

                            break;


                    }

                });


            }

            else {

                change_btn_state(_this, 'disable', 'printed');

                $.ajax({

                    url: mainUrl + 'search/search/add_products_incart',

                    type: "POST",

                    async: "false",

                    dataType: "html",

                    data: {
                        qty: qty,
                        menuid: menuid,
                        prd_id: product_id,
                        labeltype: printing,
                        printing: printing,
                        cartid: cart_id,
                        labels: labels,
                        manual_design: manual_design,
                        total_labels: Math.ceil(labels * qty)
                    },

                    success: function (data) {

                        if (!data == '') {

                            data = $.parseJSON(data);

                            if (data.response == 'yes') {

                                change_btn_state(_this, 'enable', 'printed');

                                //  fireRemarketingTag('Add to cart');

                                //ecommerce_add_to_cart(_this, 'printed');


                                $(_this).parents('.productdetails').find('#uploadedartworks_' + product_id).val(0);

                                $(_this).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-qty', 0);

                                update_artwork_upload_btn(_this, 0);

                                //popup_messages(menuid+' - '+prd_name);

                                checoutPopUp(category_description);


                                $('#cart').html(data.top_cart);
								update_topbasket();
                                //$('#basketPrice').text('View Basket - £ ' + data.top_cart[0].price);

                            }

                        }

                    }

                });


            }


        }
    }

});
$(document).on("click", ".add_plain", function(e) {

    var id =  $(this).parents('.productdetails').find('.product_id').val();

    var prd_name =  $(this).parents('.productdetails').find('.product_name').text();

    var menuid =  $(this).parents('.productdetails').find('.manfactureid').val();

    var category_description =  $(this).parents('.productdetails').find('.category_description').val();

    var labels =  $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());

    var input_id = $(this).parents('.productdetails').find('.plainsheet_input');



    var qty = parseInt(input_id.val());

    var unitqty =  $(this).parents('.productdetails').find('.plainsheet_unit').text(); //Sheets Labels

    var method_on_page =  $('#method_on_page').val();

    if(method_on_page == 'order' || method_on_page == 'quotation'){

        addLineIntoOrderDetail(qty,menuid,id,'plain',method_on_page);
    }else{


        unitqty = $.trim(unitqty);

        var _this = this;

        if(unitqty =='Labels'){

            var min_qty = parseInt(labels)*min_qty;

            var max_qty = parseInt(labels)*max_qty;

        }

        if(!is_numeric(qty) || qty=='' || qty < min_qty){

            input_id.val(min_qty);

            if(unitqty == "Labels"){

                show_faded_popover(input_id, 'Quantity has been amended for production as '+min_qty+' labels.');

            }else{

                show_faded_popover(input_id, 'Quantity has been amended for production as '+min_qty+' sheets.');

            }

            return false;

        }

        else if(qty > max_qty){

            input_id.val(max_qty);

            if(unitqty =='Labels'){

                show_faded_popover(input_id, 'Quantity has been amended for production as '+max_qty+' labels.');

            }else{

                show_faded_popover(input_id, 'Quantity has been amended for production as '+max_qty+' sheets.');

            }

            return false;

        }

        else{

            if(unitqty =='Labels'){qty = parseInt(qty/labels);}

            var _this = $(this);
            change_btn_state(_this,'disable','plain');

            $.ajax({

                url: mainUrl+'search/search/add_to_cart',

                type:"POST",

                async:"false",

                dataType: "html",

                data: {qty:qty, menuid:menuid, prd_id:id,labeltype:'plain'},

                success: function(data){

                    if(!data==''){

                        data = $.parseJSON(data);

                        if(data.response=='yes'){

                            change_btn_state(_this,'enable','plain');

                            //fireRemarketingTag('Add to cart');



                            // ecommerce_add_to_cart(_this, 'plain');





                            //popup_messages(menuid+' - '+prd_name);

                            checoutPopUp(category_description);
							update_topbasket();
                            //alert(category_description);
                            //$('#basketPrice').text('View Basket - £ '+data.top_cart[0].price);

                        }

                    }

                }

            });

        }
    }



});



function popup_messages(txt){

    swal({
            title: "Added to your basket",
            text: txt,
            type: "success",
            showCancelButton: true,
            confirmButtonClass: "btn orangeBg",
            confirmButtonText: "Checkout",
            cancelButtonClass: "btn blueBg",
            cancelButtonText: "Continue Shopping",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(isConfirm) {
            if (isConfirm) {
                window.location.href=sbase+'transactionRegistration.php';
                //console.log('checkout');
            } else {
                console.log('view cart');
            }
        });
}



$(document).on("click", ".manufaturer", function(e)
{
    var printer = $(this).attr('data-value');
    $('#ajax_model_desc').html('');
    if(printer.length > 0){
        $('#manufaturer').val(printer);
        printer_model_data(printer);
    }
});

$(document).on("change", "#manufaturer", function(e) {
    var printer = $(this).val();
    $('#ajax_model_desc').html('');
    //$('#ajax_model_desc').animate({ 'marginTop': '0px'}, 1000);
    if(printer.length > 0){
        printer_model_data(printer);
    }
});

$(document).on("click", ".printer_model", function(e) {
    var model = $(this).attr('data-value');
    if(model.length > 0){
        $('#model').val(model);
        filter_data('model');
    }
});

$(document).on("change", ".nlabelfilter", function(e) {
    $('#material_code').val('');
    var trigger = $(this).attr('id');

    if($(this).val() == 'clr'){
        $(this).find('option:eq(0)').prop('selected', true);
        //$("#"+trigger+" option:first-child").attr('selected','selected');
        //console.log("#"+trigger+" option:first");
    }

    filter_data(trigger, '');


});

$(document).on("click", ".btn_shape", function(e) {
    $('.btn_shape').removeClass('active');
    var shape = $(this).attr('data-val');
    $(this).addClass('active');
    $('#shape').val(shape);
    filter_data('shape', '');
});

$(document).on("change", ".ProductThumbnail", function(e) {

    var category = $(this).find("input[type='radio']").attr("data-value");

    $('#newcategory').val(category);
    if(category=='thermal')
    {
        $('[data-toggle="category-tooltip"]').tooltip('hide');
        $('[data-toggle="printer-tooltip"]').tooltip('show');
        enable_thermaloptions();
        printer_model_data('printers');
        add_top_margins();
        return false;
    }
    if(category=='Integrated')
    {
        enable_integratedoptions();
    }
    else
    {
        $('.thermaloptions').hide();
        $('.integratedbrands').hide();

        $('#categorybox').switchClass( "col-lg-6", "col-lg-12");
        $('#categorybox').switchClass( "col-md-6", "col-md-12");
        $('#categorybox').switchClass( "col-lg-4", "col-lg-12");
        $('#categorybox').switchClass( "col-md-4", "col-md-12");

        $('#shapes_box').find('.btn_shape').prop('disabled', false);
    }
    var screen_width = $(document).width();
    if(category=='Integrated')
    {
        if(screen_width <= 750)
        {
            $("label[for='SRA3']").css({'clear':'both'})
        }
    }
    else
    {
        $("label[for='SRA3']").css({'clear':'none'})
    }

    $('[data-toggle="category-tooltip"]').tooltip('hide');
    $('[data-toggle="printer-tooltip"]').tooltip('hide');
    filter_data('category', '');
});

$(document).on("click", ".price_breaks", function (e) {

    var product_id = $(this).parents('.productdetails').find('.product_id').val();

    var manfactureid = $(this).parents('.productdetails').find('.manfactureid').val();

    var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    $('#ajax_price_breaks').html('');

    $('#price_loader').show();

    $.ajax({

        url: mainUrl + 'search/search/labels_price_breaks',

        type: "POST",

        async: "false",

        data: {mid: manfactureid, labels: labels, type: '<?=$Paper_size?>'},

        dataType: "html",

        success: function (data) {

            if (!data == '') {

                data = $.parseJSON(data);

                setTimeout(function () {

                    $('#price_loader').hide();

                    $('#ajax_price_breaks').html(data.html);

                }, 500);

            }

        }

    });

});

$(document).on("click", ".applications", function (e) {

    var groupname = $(this).attr('id');

    $('.ajax_application_chart').html('');

    $('#app_group_name').html('');

    $('#lb_applications_loader').show();


    $.ajax({

        url: mainUrl + 'search/search/application_popup/',

        type: "POST",

        async: "false",

        dataType: "html",

        data: {'groupname': groupname, type: 'sheets'},

        success: function (data) {

            if (!data == '') {

                data = $.parseJSON(data);

                setTimeout(function () {

                    $('#lb_applications_loader').hide();

                    $('.ajax_application_chart').html(data.html);

                    $('#app_group_name').html(data.group_name);

                    $("b.popup-title").html(data.group_name);

                }, 500);

            }

        }

    });


});

$(document).on("click", ".technical_specs", function (e) {

    var id = $(this).parents('.productdetails').find('.product_id').val();

    $('#ajax_tecnial_specifiacation').html('');

    $('#mat_code').html('');

    $('#specs_loader').show();

    $.ajax({

        url: mainUrl + 'search/search/material_popup/' + id,

        type: "POST",

        async: "false",

        dataType: "html",

        success: function (data) {

            if (!data == '') {

                data = $.parseJSON(data);

                $('#material_popup_img').attr('src', data.src);

                setTimeout(function () {

                    $('#specs_loader').hide();

                    $('#ajax_tecnial_specifiacation').html(data.html);

                    $('#mat_code').html(data.mat_code);

                }, 500);

            }

        }

    });


});


$(document).on("change", ".product_adhesive", function (e) {

    get_product_details(this);

});


function get_product_details(_this) {


    var productid = $(_this).parents('.productdetails').attr('data-value');

    var finish = $(_this).parents('.productdetails').attr('data-finish');

    var material = $(_this).parents('.productdetails').attr('data-material');

    //var colour = $(_this).parents('.productdetails').attr('data-colour');

    var colour = $(_this).parents('.productdetails').find('.colourpicker .active a').attr('data-value');

    var adhesive = $(_this).parents('.productdetails').find('.product_adhesive').val();


    if (adhesive == '' || adhesive == null) {
        return true;
    }

    //console.log('Adhesive option: '+adhesive);


    reset_plain_input_buttons(_this);

    reset_print_input_buttons(_this);


    //aa_loader


    var top = $(_this).offset().top;

    top = top - 200;


    $('.loading-gif').css('top', top);

    $('#aa_loader').show();


    /*********** Empty the Cart here ***********/


    /******************************************/


    $.ajax({

        url: mainUrl + 'search/search/grouped_product_info',

        type: "post",

        async: "false",

        dataType: "json",

        data: {

            productid: productid,

            colour: colour,

            finish: finish,

            material: material,

            adhesive: adhesive,

            catid: $('#hiddenCartId').val(),

            type: 'Sheets',

        },

        success: function (data) {


            $('#aa_loader').hide();

            if (data.response == 'notfound') {

                alert_box('Sorry this product is out of stock this time.');

            } else {

                var img_path = '<?=Assets?>images/categoryimages/A4Sheets/euro_edges/' + data.material_code + '.png';

                $('.euro_thumbnail').attr('src', img_path);

                $(_this).parents('.productdetails').find('.product_adhesive').html(data.adhesive_option);


                $(_this).parents('.productdetails').find('.product_material_image').attr('src', data.sheet_image);

                $(_this).parents('.productdetails').find('.product_name').html(data.product_name);

                $(_this).parents('.productdetails').find('.product_description').html(data.product_description);


                $(_this).parents('.productdetails').find('.category_description').val(data.category_description);


                $(_this).parents('.productdetails').find('.product_id').val(data.product_id);

                $(_this).parents('.productdetails').find('.manfactureid').val(data.manfactureid);


                $(_this).parents('.productdetails').find('#minimum_quantities').val(data.minimum);

                $(_this).parents('.productdetails').find('#maximum_quantities').val(data.maximum);

                $(_this).parents('.productdetails').find('.PrintableProduct').val(data.Printable);


                $(_this).parents('.productdetails').find('.laser_printer_img').attr('src', data.laser_img);

                $(_this).parents('.productdetails').find('.inkjet_printer_img').attr('src', data.inkjet_img);

                $(_this).parents('.productdetails').find('.direct_printer_img').attr('src', data.thermal_img);

                $(_this).parents('.productdetails').find('.thermal_printer_img').attr('src', data.d_thermal_img);


                $(_this).parents('.productdetails').find('.laser_printer_div').attr('data-original-title', data.laser_text);

                $(_this).parents('.productdetails').find('.inkjet_printer_div').attr('data-original-title', data.inkjet_text);

                $(_this).parents('.productdetails').find('.thermal_printer_div').attr('data-original-title', data.thermal_text);

                $(_this).parents('.productdetails').find('.direct_printer_div').attr('data-original-title', data.d_thermal_text);


                $(_this).parents('.productdetails').find("[data-toggle=tooltip-product]").tooltip();


                $('.selected-product').find('.pr-thumb').find('img').attr('src', data.sheet_image);

                $('#ajax_layout_spec').find('img.design-image').attr('src', data.sheet_image);


                if (data.EuroID) {

                    $(_this).parents('.productdetails').find('.printer_edge').removeClass('hide').addClass('show');

                }

                else {

                    $(_this).parents('.productdetails').find('.printer_edge').removeClass('show').addClass('hide');

                }


                if (data.Printable == 'N') {

                    $(_this).parents('.productdetails').find('.printedoption').removeClass('active').addClass('hide');

                    $(_this).parents('.productdetails').find('.tabprinted').removeClass('active');


                    $(_this).parents('.productdetails').find('.tabplain').removeClass('active');

                    $(_this).parents('.productdetails').find('.plainoption').removeClass('active');


                    $(_this).parents('.productdetails').find('.tabplain').addClass('active');

                    $(_this).parents('.productdetails').find('.plainoption').addClass('active');


                    $(_this).parents('.productdetails').find('.addprintingoption').addClass('hide');


                } else {

                    $(_this).parents('.productdetails').find('.printedoption').removeClass('hide');

                    //$(_this).parents('.productdetails').find('.addprintingoption').removeClass('hide');

                }


                var exist = $(_this).parents('.productdetails').find('#uploadedartworks_' + data.product_id).length;

                if (exist == 0) {

                    var _el = document.createElement('input');

                    _el.value = 0;

                    _el.type = 'hidden';

                    _el.id = 'uploadedartworks_' + data.product_id;

                    $(_this).parents('.productdetails').find('.hiddenfields').append(_el);

                }


                var designs = $(_this).parents('.productdetails').find('#uploadedartworks_' + data.product_id).val();

                update_artwork_upload_btn(_this, parseInt(designs));


            }

        }

    });

}

function reset_plain_input_buttons(_this) {

    $(_this).parents('.productdetails').find('.plainprice_box').hide();

    $(_this).parents('.productdetails').find('.add_plain').hide();

    $(_this).parents('.productdetails').find('.plain_save_txt').hide();
    $(_this).parents('.productdetails').find('.addprintingoption').hide();

    $(_this).parents('.productdetails').find('.calculate_plain').show();

}

/*
function formvalida() {

}

function step2() {

 $('ul.setup-panel li:eq(1)').removeClass('disabled');
 $('#step-2').show();
 $('#step-1').hide();
}

function step3() {

    $('ul.setup-panel li:eq(2)').removeClass('disabled');
    $('#step-3').show();
    $('#step-2').hide();
    $('#step-1').hide();
}
function step4() {

    $('ul.setup-panel li:eq(3)').removeClass('disabled');
    $('#step-4').show();
    $('#step-3').hide();
    $('#step-2').hide();
    $('#step-1').hide();
}

*/

function checkout(){
    $('#aa_loader').show();
    $.ajax({
        type: "get",
        url: mainUrl +"cart/cart/checkout",
        data: {},
        dataType: 'html',
        success: function (data) {
            $('#aa_loader').hide();
            var msg = $.parseJSON(data);
            showAndHideTabs('products_list');
            $('#products_list').html(msg.html);

            var price = (msg.price == null || msg.price == "")?0.00:msg.price;

            $('#basketPrice').html('View Basket - '+ msg.symb +' '+ price);

            $('#od_qt_tab').removeClass('disbaledd');
            $('#od_qt_link').attr('onclick',"showcartPage()");
            activeTab('od_qt_link');
            $('.ajax_material_sorting').hide();

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

function back_to_material_and_qty(){
    $('#aa_loader').show();

    showAndHideTabs('products_list');


    /*$('#material_tab').removeClass('disbaledd');
    $('#material_tab_link').attr('onclick',"showcartPage()");
    activeTab('material_tab_link');
    $('.ajax_material_sorting').hide();*/


    $.ajax({
        type: "post",
        url: mainUrl +"order_quotation/order/index",
        data: {format:'format'},
        dataType: 'html',
        success: function (data) {
            alert('k');
            $('#aa_loader').hide();
            showAndHideTabs('products_list');


            $('#format').removeClass('disbaledd');
            $('#first_format_link').attr('onclick',"getFormat()");
            activeTab('first_format_link');
            $('.ajax_material_sorting').hide();

            window.location.href = mainUrl+'order_quotation/order/index';

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
/*
function back_to_material_and_qty(){
    $('#aa_loader').show();

    /!*showAndHideTabs('products_list');


    $('#material_tab').removeClass('disbaledd');
    $('#material_tab_link').attr('onclick',"showcartPage()");
    activeTab('material_tab_link');
    $('.ajax_material_sorting').hide();*!/


    $.ajax({
        type: "post",
        url: mainUrl +"order_quotation/order/index",
        data: {},
        dataType: 'html',
        success: function (data) {
            alert('k');
            $('#aa_loader').hide();
            showAndHideTabs('products_list');


            $('#format').removeClass('disbaledd');
            $('#first_format_link').attr('onclick',"getFormat()");
            activeTab('first_format_link');
            $('.ajax_material_sorting').hide();

        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('No Invoice..');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}*/


$(document).on("click", ".calculate_plain_roll", function (e) {

    if (!check_core_selected()) {

        return false;

    }

    var Printable = $(this).parents('.productdetails').find('.PrintableProduct').val();

    var id = $(this).parents('.productdetails').find('.product_id').val();

    var menuid = $(this).parents('.productdetails').find('.manfactureid').val();

    var max_labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());


    var input_labels = $(this).parents('.productdetails').find('.plainlabels');

    var input_roll = $(this).parents('.productdetails').find('.plainrolls');

    var pageName = $('#mypageName').val();

    var labels = parseInt(input_labels.val());

    var roll = parseInt(input_roll.val());

    var _this = this;

    var regmark = $(this).parents('.productdetails').find('.regmark').val();

    var heigh_roll = $(this).parents('.productdetails').find('.heigh_roll').val();
    var gap_roll = $(this).parents('.productdetails').find('.gap_roll').val();

    if (!is_numeric(labels) || labels < 100) {

        input_labels.val(100);

        show_faded_popover(input_labels, 'Quantity has been amended for production as 100 labels.');

        return false;

    }

    else if (!is_numeric(labels) || labels > max_labels) {

        input_labels.val(max_labels);

        show_faded_popover(input_labels, 'Quantity has been amended for production as ' + max_labels + ' labels.');

        return false;

    }

    else if (!is_numeric(roll) || roll < min_qty) {

        input_roll.val(min_qty);

        show_faded_popover(input_roll, 'Quantity has been amended for production as ' + min_qty + ' rolls.');

        return false;

    }

    else if (!is_numeric(roll) || roll > max_qty) {

        input_roll.val(max_qty);

        show_faded_popover(input_roll, 'Quantity has been amended for production as ' + max_qty + ' rolls.');

        return false;

    }

    else if (roll % min_qty != 0) {
        //alert(min_qty);
        if (roll % min_qty != 0) {

            var multipyer = min_qty * parseInt(parseInt(roll / min_qty) + 1);

            if (multipyer > max_qty) {

                multipyer = max_qty;

            }

            input_roll.val(multipyer);

        }

        show_faded_popover(input_roll, "Sorry! these labels are only available in sets of " + min_qty + " rolls. ");

        return false;

    }

    else {

        change_btn_state(_this, 'disable', 'plain');

        $.ajax({

            url: mainUrl + 'search/search/calculate_roll_price',

            type: "POST",

            async: "false",

            dataType: "html",

            data: {

                roll: roll,

                menuid: menuid,

                prd_id: id,

                labels: labels,

                max_labels: max_labels,

                size: heigh_roll,

                gap: gap_roll,

                printprice: 'enabled',

                regmark:regmark

            },

            success: function (data) {

                if (!data == '') {
                    $('#'+input_labels.attr('aria-describedby')).hide();
                    $('#'+input_roll.attr('aria-describedby')).hide();
                    data = $.parseJSON(data);

                    if (data.response == 'yes') {

                        change_btn_state(_this, 'enable', 'plain');

                        $(_this).parents('.productdetails').find('.diamterinfo').html('Roll Diameter <span>' + data.diameter + ' mm</span>').show();

                        $(_this).parents('.productdetails').find('.calculate_plain_roll').hide();

                        $(_this).parents('.productdetails').find('.add_plain_roll').show();

                        $(_this).parents('.productdetails').find('.plainprice_text').html(data.price);

                        $(_this).parents('.productdetails').find('.plainperlabels_text').html(data.labelprice);

                        $(_this).parents('.productdetails').find('.plainprice_box').show();
                        $(_this).parents('.productdetails').find('.raw_plain b').html(data.raw_plain);
                        $(_this).parents('.productdetails').find('.regmark_price b').html(data.regmark_price);


                        if(pageName == 'quotation'){
                            $('.add_plain_roll').text('Add To Quotation');
                        }else if(pageName == 'order'){
                            $('.add_plain_roll').text('Add To Order');
                        }




                        $('#od_dt_price').val(data.plainPrice);


                        if (Printable == 'Y') {

                            $(_this).parents('.productdetails').find('.printing_offer_text').html(data.symbol + '' + data.onlyprintprice);

                            $(_this).parents('.productdetails').find('.addprintingoption').removeClass('hide');
                            $(_this).parents('.productdetails').find('.addprintingoption').show();

                        }

                    }

                }

            }

        });

    }

});

$(document).on("click", ".calculate_printed_roll", function (e) {


    if (!check_core_selected()) {

        return false;

    }


    var cart_id = $(this).parents('.productdetails').find('.cart_id').val();

    var id = $(this).parents('.productdetails').find('.product_id').val();

    var cart_id = $(this).parents('.productdetails').find('.cart_id').val();

    var menuid = $(this).parents('.productdetails').find('.manfactureid').val();

    var labelfinish = $(this).parents('.productdetails').find('.labelfinish').val();

    var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    var printing = $(this).parents('.productdetails').find('.digitalprintoption').val();

    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

    var presproof = $(this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-presproof');


    var upload_qty = parseInt($(this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-qty'));

    var artworks = parseInt($(this).parents('.productdetails').find('#uploadedartworks_' + id).val());

    var minlabels = parseInt($(this).parents('.productdetails').find('.minimum_printed_labels').val());

    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_printed_labels').val());
    
    var manual_design = parseInt($(this).parents('.productdetails').find('#no_artworks_'+id).val());

    //var min_qty = parseInt(min_qty * minlabels);
    var min_qty = parseInt('100');
    
    var roll_qty = $('#no_of_roll_custom_art').val();
    if(typeof roll_qty != 'undefined'){
    }else{
      roll_qty = '';
    }


    var input_id = $(this).parents('.productdetails').find('.printlabels');

    var qty = input_id.val();

    var _this = this;

    var heigh_roll = $(this).parents('.productdetails').find('.heigh_roll').val();
    var gap_roll = $(this).parents('.productdetails').find('.gap_roll').val();
    if (!is_numeric(qty) || qty == '' || qty < min_qty) {

        input_id.val(min_qty);

        show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' labels.');

    }

    else if (qty > max_qty) {

        input_id.val(max_qty);

        show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' labels.');

    }

    else if (printing == '' || printing.length == 0) {

        swal({

            title: "Please Select",

            text: "Digital Print Process ",

            confirmButtonText: "Continue",

            type: "",

        });

    }

    else if (labelfinish == '' || labelfinish.length == 0) {

        swal({

            title: "Please Select",

            text: "Product Finish  ",

            confirmButtonText: "Continue",

            type: "",

        });

    }

    else {


        if (artworks > 0 && upload_qty != qty && upload_qty != 0) {

            $(this).parents('.productdetails').find('.artwork_uploader').click();

            alert_box("You have changed the quantity of labels please amend quantities against each uploaded artwork.");

            return false;

        }

        change_btn_state(_this, 'disable', 'printed');
        var pageName = $('#mypageName').val();
        $.ajax({

            url: mainUrl + 'search/search/calculate_roll_price',

            type: "POST",

            async: "false",

            dataType: "html",

            data: {

                labels: qty,

                menuid: menuid,

                prd_id: id,

                max_labels: labels,

                labelfinish: labelfinish,

                printing: printing,

                size: heigh_roll,

                gap: gap_roll,

                presproof: presproof,

                cart_id: cart_id,
                manual_design :manual_design,
                roll_qty : roll_qty

            },

            success: function (data) {

                if (!data == '') {

                    data = $.parseJSON(data);

                    if (data.response == 'yes') {


                        if(pageName == 'quotation'){

                            $('.add_printed_roll').text('Add To Quotation');
                        }else if(pageName == 'order'){
                            $('.add_printed_roll').text('Add To Order');
                        }

                        change_btn_state(_this, 'enable', 'printed');

                        //$(_this).parents('.productdetails').find('.diamterinfo').html('Roll Diameter <span>'+data.diameter+' mm</span>').show();


                        if (printing == 'Monochrome – Black Only') {

                            printing = 'Printed Black';

                            var offertxt = 'Black Only ';

                        }

                        else if (printing == '6 Colour Digital Process + White') {

                            printing = 'Printed FullColour';

                            var offertxt = '6 Colour + White';

                        }

                        else {

                            printing = 'Printed FullColour';

                            var offertxt = '6 Colour ';

                        }


                        $(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.phead').text(" Plain Labels Price ");

                        $(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.printtext').html('<b class="pr-sm">' + data.symbol + data.plainlabelsprice + '</b>');


                        $(_this).parents('.productdetails').find('.printedprice_box .price .inkprice').find('.phead').text(offertxt);

                        $(_this).parents('.productdetails').find('.printedprice_box .price .inkprice').find('.printtext').html('<b class="pr-sm">' + data.symbol + data.onlyprintprice + '</b>');


                        $(_this).parents('.productdetails').find('.printedprice_box .price .halfprintprice').find('.halfprinttext').html('-<b class="pr-sm">' + data.symbol + data.halfprintprice + '</b>');

                        $('#od_dt_price').val(data.plainPrice);
                        $('#od_dt_printed').val(data.printPrice);


                        $(_this).parents('.productdetails').find('.printedprice_box .price .labelfinishprice').find('.phead').text(labelfinish);

                        $(_this).parents('.productdetails').find('.printedprice_box .price .labelfinishprice').find('.labelfinishtext').html('<b class="pr-sm">' + data.symbol + data.label_finish + '</b>');


                        if (presproof == 1) {

                            $(_this).parents('.productdetails').find('.printedprice_box .price .pressproofprice').find('.pressprooftext').html('<b class="pr-sm">' + data.symbol + data.presproof_charges + '</b>');

                            $(_this).parents('.productdetails').find('.printedprice_box .price .pressproofprice').show();

                        } else {

                            $(_this).parents('.productdetails').find('.printedprice_box .price .pressproofprice').hide();

                        }

                        if (data.additional_rolls > 0) {

                            $(_this).parents('.productdetails').find('.printedprice_box .price .additionalrolls').find('.phead').html('(' + data.additional_rolls + ' additional rolls)');

                            $(_this).parents('.productdetails').find('.printedprice_box .price .additionalcharge').find('.desginprice').html('<b class="pr-sm">' + data.symbol + data.additional_cost + '</b>');

                            $(_this).parents('.productdetails').find('.printedprice_box .price .additionalrolls').show();

                            $(_this).parents('.productdetails').find('.printedprice_box .price .additionalcharge').show();

                        } else {

                            $(_this).parents('.productdetails').find('.printedprice_box .price .additionalrolls').hide();

                            $(_this).parents('.productdetails').find('.printedprice_box .price .additionalcharge').hide();

                        }


                        $(_this).parents('.productdetails').find('.printedprice_text').html(data.price);

                        $(_this).parents('.productdetails').find('.printedperlabels_text').html(data.labelprice);


                        $(_this).parents('.productdetails').find('.calculate_printed_roll').hide();

                        $(_this).parents('.productdetails').find('.add_printed_roll').show();

                        $(_this).parents('.productdetails').find('.printedprice_box').show();


                    }

                }

            }

        });

    }

});

$(document).on("click", ".add_printed_roll", function (e) {

    if (!check_core_selected()) {
        return false;
    }

    var cart_id = $(this).parents('.productdetails').find('.cart_id').val();
    var prd_name = $(this).parents('.productdetails').find('.product_name').text();
    var id = $(this).parents('.productdetails').find('.product_id').val();
    var cart_id = $(this).parents('.productdetails').find('.cart_id').val();
    var menuid = $(this).parents('.productdetails').find('.manfactureid').val();
    var category_description = $(this).parents('.productdetails').find('.category_description').val();
    var labelfinish = $(this).parents('.productdetails').find('.labelfinish').val();
    var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();
    var printing = $(this).parents('.productdetails').find('.digitalprintoption').val();
    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());
    var presproof = $(this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-presproof');
    var woundoption = $('#woundoption').val();
    var orientation = $(this).parents('.productdetails').find('.orientation').val();
    var upload_qty = parseInt($(this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-qty'));
    var print_material = $(this).parents('.productdetails').find('.printedMaterial').val();
    var artworks = parseInt($(this).parents('.productdetails').find('#uploadedartworks_' + id).val());
    var minlabels = parseInt($(this).parents('.productdetails').find('.minimum_printed_labels').val());
    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_printed_labels').val());
    //var min_qty = parseInt(min_qty * minlabels);
    var min_qty = 100;
    var input_id = $(this).parents('.productdetails').find('.printlabels');
  var qty = input_id.val();
  var qty = parseInt(qty);
  
  //$('#custom_qty_roll_'+ id).val();
  var _this = this;
  var manual_design = $(this).parents('.productdetails').find('#no_artworks_' + id).val();
   //var roll_qty = $('#no_of_roll_custom_art').val();
  
   var roll_qty = $('#custom_qty_roll_'+ id).val();

    if (!is_numeric(qty) || qty == '' || qty < min_qty) {
        input_id.val(min_qty);
        show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' labels.');
    }
    else if (qty > max_qty) {
        input_id.val(max_qty);
        show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' labels.');
    }

    else if (printing == '' || printing.length == 0) {
        swal({
            title: "Please Select",
            text: "Digital Print Process ",
            confirmButtonText: "Continue",
            type: "",
        });
    }
    else if (labelfinish == '' || labelfinish.length == 0) {
        swal({
            title: "Please Select",
            text: "Product Finish  ",
            confirmButtonText: "Continue",
            type: "",
        });
    }

    else {
        var pageName = $('#mypageName').val();
        if (pageName == 'quotation' || pageName == 'order') {
            var designs = $(this).parents('.productdetails').find('#uploadedartworks_' + id).val();
            if (designs == 0 && manual_design==0) {
                swal(
                    "Did you forget something?",
                    "You can upload your artwork by clicking on the blue “BACK & ADD ARTWORK” button and continue to place your order.\n\nAlternatively you can proceed to place your order by clicking on the orange “CONTINUE & ADD TO BASKET” button and supply your artwork via email later.",
                    {
                        buttons: {
                            cancel: "BACK & ADD ARTWORK",
                            catch: {
                                text: "CONTINUE & ADD TO BASKET",
                                value: "catch",
                            },
                        },
                        icon: "warning",
                        closeOnClickOutside: false,
                    }
                ).then((value) => {
                    switch (value) {
                        case "catch":
                        
                        
                            var labels = $(this).parents('.productdetails').find('.printlabels').val();
                            addLineForRollIntoOrderDetail(roll_qty, menuid, id, labels, 'printed', pageName, 'Roll', labelfinish, printing, presproof, woundoption, orientation, cart_id);
                            break;
                    }
                });
            }else{
              
                          var labels = $(this).parents('.productdetails').find('.printlabels').val();
                          addLineForRollIntoOrderDetail(roll_qty, menuid, id, labels, 'printed', pageName, 'Roll', labelfinish, printing, presproof, woundoption, orientation, cart_id);
            }
        }

        else {
            var designs = $(this).parents('.productdetails').find('#uploadedartworks_' + id).val();

            if (designs == 0 && manual_design==0) {
				
				
               
				
				swal(
                "Did you forget something?",


                "You can upload your artwork by clicking on the blue “BACK & ADD ARTWORK” button and continue to place your order.\n\nAlternatively you can proceed to place your order by clicking on the orange “CONTINUE & ADD TO BASKET” button and supply your artwork via email later.",

                {

                    buttons: {
                        cancel: "BACK & ADD ARTWORK",
                        catch: {
                            text: "CONTINUE & ADD TO BASKET",
                            value: "catch",
                        },
                    },

                    icon: "success",

                    closeOnClickOutside: false,

                }
            )

                    .then((isConfirm) => {
                        if (isConfirm) {
                            
                            change_btn_state(_this, 'disable', 'printed');

                            $.ajax({
                                url: mainUrl + 'search/search/add_products_incart',
                                type: "POST",
                                async: "false",
                                dataType: "html",
                                data: {
                                    labels: qty,
                                    menuid: menuid,
                                    prd_id: id,
                                    max_labels: labels,
                                    labelfinish: labelfinish,
                                    printing: printing,
                                    presproof: presproof,
                                    cartid: cart_id,
                                    woundoption: woundoption,
                                    orientation: orientation,
                                    type: 'Rolls',
                                    manual_design:manual_design,
                                  roll_qty:roll_qty
                                },

                                success: function (data) {
                                    if (!data == '') {
                                        data = $.parseJSON(data);
                                        if (data.response == 'yes') {
                                            change_btn_state(_this, 'enable', 'printed');
                                            $(_this).parents('.productdetails').find('#uploadedartworks_' + id).val(0);
                                            $(_this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-qty', 0);
                                            $(_this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-rolls', 0);
                                            $(_this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-presproof', 0);
                                            update_artwork_upload_btn(_this, 0);
                                            checoutPopUp('Printed Labels on Rolls ' + category_description)
                                            $('#cart').html(data.top_cart);
											update_topbasket();
                                        }
                                    }
                                }
                            });
                        }
                    });
            }

            else {
                change_btn_state(_this, 'disable', 'printed');
                $.ajax({
                    url: mainUrl + 'search/search/add_products_incart',
                    type: "POST",
                    async: "false",
                    dataType: "html",
                    data: {
                        labels: qty,
                        menuid: menuid,
                        prd_id: id,
                        max_labels: labels,
                        labelfinish: labelfinish,
                        printing: printing,
                        presproof: presproof,
                        cartid: cart_id,
                        woundoption: woundoption,
                        orientation: orientation,
                        type: 'Rolls',
                      manual_design:manual_design,
                      roll_qty:roll_qty
                    },

                    success: function (data) {
                        if (!data == '') {
                            data = $.parseJSON(data);
                            if (data.response == 'yes') {
                                change_btn_state(_this, 'enable', 'printed');
                                $(_this).parents('.productdetails').find('#uploadedartworks_' + id).val(0);
                                $(_this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-qty', 0);
                                $(_this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-rolls', 0);
                                $(_this).parents('.productdetails').find('#uploadedartworks_' + id).attr('data-presproof', 0);
                                update_artwork_upload_btn(_this, 0);
								checoutPopUp('Printed Labels on Rolls ' + category_description);
                                $('#cart').html(data.top_cart);
								update_topbasket();
                            }
                        }
                    }
                });
			}
		}
	}
});

$(document).on("click", ".save_artwork_file_roll", function(e) {

  var _this = this;
  var cartid = $('#cartid').val();
  var prdid = $('#cartproductid').val();
  var labelpersheets = $('#labels_p_sheet').val();
  var type = 'rolls';
  var artworkname = $(_this).parents('.upload_row').find('.artwork_name').val();
  var file = $(_this).parents('.upload_row').find('.artwork_file').val();
  var uploadfile = $(_this).parents('.upload_row').find('.artwork_file')[0].files[0];
  var product_id =  $(parent_selector).parents('.productdetails').find('.product_id').val();
  var presproof = $(parent_selector).parents('.productdetails').find('#uploadedartworks_'+product_id).attr('data-presproof');
  var response = '';
  response = verify_labels_or_rolls_qty(_this);
  if(response==false){ return false;}
  var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();
  var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();
  var lb_txt = 'labels';

    
	
	 var is_follow  = $(_this).parents('.upload_row').find('.follow_arts').prop("checked");
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
    var uploadfile = $(this).parents('.upload_row').find('.artwork_file')[0].files[0];
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
    form_data.append("size",'<?=$height?>');
    form_data.append("gap",'<?=$Labelsgap?>');
    form_data.append("presproof",presproof);
    if(is_follow==true ){
      type = "bypass";
    }else{
      type = uploadfile.type;
    }

    if(type != 'image/png' && type != 'image/jpg' && type != 'image/gif' && type != 'image/jpeg' && type != 'application/pdf' && type != 'application/postscript' && type!="bypass") {
      swal("Not Allowed","We apologise, because this file type cannot be uploaded. \n\n Please retry using one of the following file formats: EPS; GIF; JPEG; JPG; PDF & PNG","warning");
            return false;
    }else{
      upload_printing_artworks_oldss(form_data);
      $('#no_artworks_'+prdid).val(0);
    }

  }
	

});

$(document).on("click", ".add_integrate", function(e) {

  counter = $('#filecounter').val();

  var type_ps = $(this).data('int-type');
	//alert(type_ps);
  var cartId  = $('.cart_id').val();
  var print_option = type_ps;//$(this).parents('.tab-pane').find('select.print_option').val();
	//alert(print_option);
  var box_inp = $(this).parents('.tab-pane').find('.box_size');
  var box = parseInt(box_inp.val());
  var persheet = '';
  var batch = parseInt($('.plainsheet_unit').text());
  var max_qty = 500000;
  var manufacture = $('#mannfacccture').val();
  var print_optiontype = $(this).parents('.tab-pane').find('.print_option').val();
  
  var _this = $(this);
  if(type_ps == 'printed' && print_option == 'plain')
  {
    swal("","Please select printing option","warning");
    return false;
  }

  if(box == 'NaN' || box_inp == '')
  {
    swal("","Please enter number of sheets first","warning");
    return false;
  }
  else if(box < batch)
  {
    swal("","Minimum "+batch+" sheets allowed","warning");
    return false;
  }
  else if(box > max_qty)
  {
    swal("","Maximum "+ max_qty +" sheets allowed","warning");
    return false;
  }

  var type_ps = print_option;
  var manufacture = $('#mannfacccture').val();
  var productid = $('#ppproductID').val();
  var ProductName = $('#ppproductName').val();
  change_btn_state(_this,'disable','plain');
  var pageName = $('#mypageName').val();
  var userId = $('#useer_id').val();
  var order_number = $('#order_number').val();
  var manual_design = parseInt($(this).parents('.productdetails').find('#no_artworks_'+productid).val());

  $.ajax({
    url: mainUrl+'search/Search/add_integrate_incart',
    type:"post",
    dataType: "html",
    data:{manufature:manufacture,box:box,type_ps:type_ps,prdid:productid,counter:counter,batch:batch,pageName:pageName,userId:userId,order_number:order_number,cartId:cartId,manual_design:manual_design,print_optiontype:print_optiontype},
    success: function(data){
      data = $.parseJSON(data);
      if(data){
        if(pageName !=null && pageName !=""){
          swal(
            "New Product  Added",
            {
              buttons: {
                catch: {
                  text: "Ok",
                  value: "catch",
                },
              },
              icon: "success",
              closeOnClickOutside: false,
            }
          ).then((value) => {
            switch (value) {
              case "catch":
                window.location.reload();
                break;
            }
          });
        }else{
          change_btn_state(_this,'enable','plain');
          //popup_messages(manufacture+' - '+ProductName);
          checoutPopUp(manufacture+' - '+ProductName);
          $('#cart').html(data.top_cart);
        }
      }
    }
  });
});




$(document).on("click", ".add_plain_roll", function (e) {

    if (!check_core_selected()) {

        return false;

    }


    var prd_name = $(this).parents('.productdetails').find('.product_name').text();

    var id = $(this).parents('.productdetails').find('.product_id').val();

    var menuid = $(this).parents('.productdetails').find('.manfactureid').val();

    var category_description = $(this).parents('.productdetails').find('.category_description').val();

    var max_labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

    var min_qty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

    var max_qty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());


    var input_labels = $(this).parents('.productdetails').find('.plainlabels');

    var input_roll = $(this).parents('.productdetails').find('.plainrolls');

    var regmark = $(this).parents('.productdetails').find('.regmark').val();

    var labels = parseInt(input_labels.val());

    var roll = parseInt(input_roll.val());

    var _this = this;

    if (!is_numeric(labels) || labels < 100) {

        input_labels.val(100);

        show_faded_popover(input_labels, 'Quantity has been amended for production as 100 labels.');

        return false;

    }

    else if (!is_numeric(labels) || labels > max_labels) {

        input_labels.val(max_labels);

        show_faded_popover(input_labels, 'Quantity has been amended for production as ' + max_labels + ' labels.');

        return false;

    }

    else if (!is_numeric(roll) || roll < min_qty) {

        input_roll.val(min_qty);

        show_faded_popover(input_roll, 'Quantity has been amended for production as ' + min_qty + ' rolls.');

        return false;

    }

    else if (!is_numeric(roll) || roll > max_qty) {

        input_roll.val(max_qty);

        show_faded_popover(input_roll, 'Quantity has been amended for production as ' + max_qty + ' rolls.');

        return false;

    }

    else if (roll % min_qty != 0) {

        if (roll % min_qty != 0) {

            var multipyer = min_qty * parseInt(parseInt(roll / min_qty) + 1);

            if (multipyer > max_qty) {

                multipyer = max_qty;

            }

            input_roll.val(multipyer);

        }

        show_faded_popover(input_roll, "Sorry! these labels are only available in sets of " + min_qty + " rolls. ");

        return false;

    }

    var method_on_page = $('#method_on_page').val();

    if (method_on_page == 'order' || method_on_page == 'quotation') {
        addLineForRollIntoOrderDetail(roll, menuid, id, labels, 'plain', method_on_page, 'Roll','','','','','','',regmark,'');
    }
    else {

        change_btn_state(_this, 'disable', 'plain');

        $.ajax({

            url: mainUrl + 'search/search/add_to_cart',

            type: "POST",

            async: "false",

            dataType: "html",

            data: {qty: roll, menuid: menuid, prd_id: id, labels: labels, type: 'Rolls',regmark:regmark},

            success: function (data) {

                if (!data == '') {

                    data = $.parseJSON(data);

                    if (data.response == 'yes') {

                        change_btn_state(_this, 'enable', 'plain');

                        //fireRemarketingTag('Add to cart');


                        // ecommerce_add_to_cart(_this, 'plain');

                        //popup_messages(menuid+' - '+prd_name);

                        checoutPopUp(category_description);
                        //alert(category_description);
						update_topbasket();
                        //$('#basketPrice').text('View Basket - £ ' + data.top_cart[0].price);

                    }

                }

            }

        });

    }

});

$(document).on("click", ".rsample_roll", function (e) {
    var p_code = $(this).parents('.productdetails').find('.product_id').val();
    var menuid = $(this).parents('.productdetails').find('.manfactureid').val();
    var prd_name = $(this).parents('.productdetails').find('.product_name').text();
    var pageName = $('#mypageName').val();
    var orderNumber = $('#order_number').val();
    var userId = $('#useer_id').val();

    var _this = $(this);

    if (menuid) {
        change_btn_state(_this, 'disable', 'sample');
        $.ajax({
            url: mainUrl + 'search/Search/add_sample_to_cart',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                qty: 1,
                menuid: menuid,
                prd_id: p_code,
                pageName: pageName,
                orderNumber: orderNumber,
                userId: userId
            },

            success: function (data) {

                if (!data == '') {

                    change_btn_state(_this, 'enable', 'sample');
                    $(".requestsample").modal('hide');
                    data = $.parseJSON(data);

                    if (data.response == 'yes') {
                        if (pageName == 'quotation' || pageName == 'order') {
                            swal(
                                "New Product  Added",
                                {
                                    buttons: {
                                        catch: {
                                            text: "Ok",
                                            value: "catch",
                                        },
                                    },
                                    icon: "success",
                                    closeOnClickOutside: false,
                                }
                            ).then((value) => {
                                switch (value) {
                                    case "catch":
                                        window.location.reload();
                                        break;
                                }
                            });
                            
                        } else {
                            var sample_txt = "Thank you for requesting a sample which has been added to your basket and upon checkout a free-of-charge roll length of the material chosen will be sent to you. \n\n Please note: This is a material and adhesive sample only and will no not therefore match the label shape and size on this page.";

                            //swal("Material Sample Added to Basket",sample_txt,"success");

                            //popup_messages(sample_txt);
                            checoutPopUp(sample_txt);
                            //popup_messages(menuid+' - '+prd_name+' - Sample ');

                            $('#cart').html(data.top_cart);
                            ecommerce_add_to_cart(_this, 'sample');
                        }
                    }

                    else if (data.response == 'failed') {
                        if (data.msg == 'you have reached the maximum sample order limit!') {
                            swal("Maximum limit exceeded", data.msg, "error");
                        } else {
                            swal("Duplicate Sample Roll", data.msg, "error");
                        }
                    }
                }
            }
        });
    }
}); 


$(document).on("click", ".rsample", function (e) {


            var p_code = $(this).parents('.productdetails').find('.product_id').val();

            var menuid = $(this).parents('.productdetails').find('.manfactureid').val();

            var prd_name = $(this).parents('.productdetails').find('.product_name').text();

            var _this = $(this);

            if (menuid) {

                change_btn_state(_this, 'disable', 'sample');
                var pageName = $('#mypageName').val();
                $.ajax({

                    url: mainUrl + 'search/Search/add_sample_to_cart',

                    type: "POST",

                    async: "false",

                    dataType: "html",

                    data: {qty: 1, menuid: menuid, prd_id: p_code, pageName: pageName,orderNumber:$('#order_number').val(),userId:$('#useer_id').val()},

                    success: function (data) {

                        if (!data == '') {

                            change_btn_state(_this, 'enable', 'sample');

                            $(".requestsample").modal('hide');

                            data = $.parseJSON(data);

                            if (data.response == 'yes') {

                                if (pageName == 'quotation' || pageName == 'order') {
                                    swal(
                                        "New Product  Added",




                                        {

                                            buttons: {

                                                catch: {

                                                    text: "Ok",

                                                    value: "catch",

                                                },


                                            },

                                            icon: "success",

                                            closeOnClickOutside: false,

                                        },
                                    ).then((value) => {

                                        switch (value) {


                                            case "catch":

                                               // window.location.reload();

                                                break;


                                        }

                                    });
                                } else {
                                    var sample_txt = "Thank you for requesting a sample which has been added to your basket and upon checkout a free-of-charge A4 sheet of the material chosen will be sent to you. \n\n Please note: This is a material and adhesive sample only and will no not therefore match the label shape and size on this page.";

                                    //swal("Material Sample Added to Basket",sample_txt,"success");

                                    checoutPopUp(sample_txt);

                                    //popup_messages(menuid+' - '+prd_name+' - Sample ');

                                    $('#cart').html(data.top_cart);


                                    ecommerce_add_to_cart(_this, 'sample');
                                }


                            }

                            else if (data.response == 'failed') {

                                if (data.msg == 'you have reached the maximum sample order limit!') {

                                    swal("Maximum limit exceeded", data.msg, "error");

                                } else {

                                    swal("Duplicate Sample Sheet", data.msg, "error");

                                }

                            }

                        }

                    }

                });

            }

        });


$(document).on("click",".proceed_reg_btn",function(e){
   
    var _this = $(this);
    change_btn_state(_this,'disable','proceed_reg_btn');
    //var diecode = $("#reg_diecode").val();
    var diecode = $(this).data('cat-id');
    var shape = $("#reg_shape").val();
    var regmark = $(this).data('regmark');
    var productID = $("#reg_productID").val();
    var source = $("#reg_source").val();
    var pageName = $('#mypageName').val();
    var myshape = '';
    var myCode = '';
    var proid = '';
    var regmart = '';
    if(diecode != '' && shape != '')
    {
        myshape = shape;
        myCode = diecode;
    }
    if(productID != 'undefined' && productID != '')
    {
        proid = productID;
    }
    if(regmark == "yes" && (productID != "undefined" && productID != ""))
    {
        regmart = 'yes';
    }
    else if(regmark == "yes" && (productID == "undefined" || productID == ""))
    {
        regmart = 'yes';
    }

    if(pageName == 'quotation' || pageName == 'order'){
        getOrderDetailMaterialPage(myshape,myCode,pageName,productID,regmart);
    }else{
        getMaterialPage(myshape,myCode,productID,regmart);
    }
});

$(document).on("change",".registration_mark_option",function(e){
    var regmark = '';
    if($(this).is(':checked'))
    {
        regmark = "yes";
    }
    else
    {
        regmark = "no";
    }
    $(this).parents('.tabplain').find('.regmark').val(regmark);
    $(this).parents('.tabplain').find('.calculate_plain_roll').trigger('click');
});

$(document).on("click",".registration_modal_link",function(e){
    $("#registration_mark_option").prop("checked",false);
    $("#registration_mark_option").trigger("change");
    return false;
    var diecode = $(this).attr('id');
    var compare = $(this).attr('compare');
    var shape = $(this).data('shape');
    var productID = $(this).data('productid');
    var source = $(this).data('source');
    if(source == "modal_modal")
    {
        $("#compare_modal").modal('hide');
    }
    loadregmarkmodal(diecode,shape,productID,source,compare);
    /* $("#reg_diecode").val(diecode);
    $("#reg_shape").val(shape);
    $("#reg_productID").val(productID);
    $("#reg_source").val(source);
    $("#compare").val(compare);*/

});

function loadregmarkmodal(diecode,shape,productID,source,compare){
    $.ajax({
        type: "post",
        url: mainUrl+ "order_quotation/Quotation/loadregmarkpopup",
        cache: false,               
        data: {diecode:diecode,shape:shape,productID:productID,source:source,compare:compare},
        dataType: 'html',
        success: function(data)
        {                        
            data = $.parseJSON(data);  
            $('#popupdiv').html('');
            $('#popupdiv').html(data.html);
            $('.modal-backdrop').remove();
            $('.registration_mark').modal('show'); 
            //$('.modal-backdrop').remove();  
            //$('body').append('<div class="modal-backdrop fade show"></div>');
        },

        error: function(){                      
            alert('Error while request..');
        }           
    });    
}

$(document).on('click','.close_reg',function (e) {
    var compare = $('#compare').val();

    if(compare == 'compare'){
        $('.registration_mark ').modal('hide');
        $('#compare_modal').modal('show');
    }
});

$(document).on("change","#registration_mark_option",function(e){
    if($(this).is(':checked')){
        $("#btn_without_reg").addClass("disabled");
        $("#btn_with_reg").removeClass("disabled");
    }
    else
    {
        $("#btn_without_reg").removeClass("disabled");
        $("#btn_with_reg").addClass("disabled");
    }
});

$(document).on("change",".registration_regmark_option",function(e){
    var id = $(this).attr('data-id');
    if($(this).is(':checked'))
    {
        $("#btn_without_reg"+id).addClass("disabled");
        $("#btn_with_reg"+id).removeClass("disabled");
    }
    else
    {
        $("#btn_without_reg"+id).removeClass("disabled");
        $("#btn_with_reg"+id).addClass("disabled");
    }
});



$(function(a){a.fn.aaZoom=function(b){var c=this;if(!c.is("img"))return void console.log("%cError: %cTarget element is not an image.","background: #FCEBB6; color: #F07818; font-size: 17px; font-weight: bold;","background: #FCEBB6; color: #F07818; font-size: 17px;");var d=c.attr("src"),g=(c.width(),c.height(),new Image);g.src=c.attr("src");var h={round:!0,width:200,height:200,background:"#FFF",shadow:"0 8px 17px 0 rgba(0, 0, 0, 0.2)",border:"6px solid #ccc",cursor:!0,zIndex:999999,scale:1},i=a.extend(h,b);c.on("dragstart",function(a){a.preventDefault()}),c.css("cursor",i.cursor?"crosshair":"none");var j=document.createElement("div");j.id="aaLens",a("body").append(j),$aaLens=a("#aaLens"),$aaLens.css({position:"absolute",display:"none","pointer-events":"none",zIndex:i.zIndex,width:i.width,height:i.height,border:i.border,background:i.background,"border-radius":i.round?"50%":"none","box-shadow":i.shadow,"background-repeat":"no-repeat"}),c.mouseenter(function(){$aaLens.css("display","block")}),c.mousemove(function(b){var e=b.pageX-i.width/2,f=b.pageY-i.height/2,h=b.pageX-a(this).offset().left,j=b.pageY-a(this).offset().top,k=-Math.floor(h/c.width()*(g.width*i.scale)-i.width/2),l=-Math.floor(j/c.height()*(g.height*i.scale)-i.height/2),m=k+"px "+l+"px",n=g.width*i.scale+"px "+g.height*i.scale+"px";$aaLens.css({left:e,top:f,"background-image":"url("+d+")","background-size":n,"background-position":m})}),c.mouseleave(function(){$aaLens.css("display","none")})}});




function add_customer(){

    $.ajax({
        type: "post",
        url: mainUrl+ "order_quotation/order/add_customer",
        cache: false,               
        data: '',
        dataType: 'html',
        success: function(data)
        {                        
            $('#exampleModal1').html(data);
            $('#exampleModal1').modal('show');    
        },
        error: function(){                      
            alert('Error while request..');
        }           
    });    
}

function edit_cus(id){
    $.ajax({
        type: "post",
        url: mainUrl+"order_quotation/order/edit_customer",
        cache: false,               
        data: {UserID:id},
        dataType: 'html',
        success: function(data)
        {                        
            $('#exampleModal2').html(data);
            $('#exampleModal2').modal('show');    
        },
        error: function(){                      
            alert('Error while request..');
        }
    });
}

function update_cus(){
    $("#validationID").submit(); 
}

function usesame()
{
  var items = $('.checkbox-checked').length;
  //alert(items);
    if($('#DAddressDifferent1').prop("checked") == true){


	  var valu = document.getElementById('bill_country').value;
	  document.getElementById('DFirstName').value = document.getElementById('FirstName').value;
	  document.getElementById('DLastname').value = document.getElementById('Lastname').value;
	  document.getElementById('DAddress1').value = document.getElementById('Address1').value;
	  document.getElementById('DAddress2').value = document.getElementById('Address2').value;
	  document.getElementById('DTownCity').value = document.getElementById('TownCity').value;
	  document.getElementById('DCountryState').value = document.getElementById('CountryState').value;
	  document.getElementById('del_country').value = document.getElementById('bill_country').value;
	  document.getElementById('Dpcode').value = document.getElementById('pcode').value;
	  document.getElementById('DTelephone').value = document.getElementById('Telephone').value;
	  //document.getElementById('DFax').value = document.getElementById('Fax').value;
	  document.getElementById('DCompany').value = document.getElementById('Company').value;
	  document.getElementById('DbillingResCom_User').value=document.getElementById('billingResCom_User').value;
	  document.getElementById('dmobile').value = document.getElementById('bmobile').value;
	  //$("#del_country_chzn").find('span').text(valu);
    
  }
  else
  {
	  document.getElementById('DFirstName').value = '';
      document.getElementById('DLastname').value = '';
	  document.getElementById('DAddress1').value = '';
	  document.getElementById('DAddress2').value ='';
	  document.getElementById('DTownCity').value = '';
	  document.getElementById('DCountryState').value = '';
	  document.getElementById('del_country').value = '';
	  document.getElementById('Dpcode').value = '';
	  document.getElementById('DTelephone').value = '';
	  //document.getElementById('DFax').value = '';
	  document.getElementById('DCompany').value = '';
	  document.getElementById('DbillingResCom_User').value= '';
	  document.getElementById('dmobile').value ='';
	  //$("#del_country_chzn").find('span').text('');
  }
	
	
	



}


function convert_cus(id){
    $.ajax({
        type: "post",
        url: mainUrl+"order_quotation/order/convert_cus",
        cache: false,
        data: {UserID:id},
        dataType: 'html',
        success: function(data)
        {
            $('#exampleModal3').html(data);
            $('#exampleModal3').modal('show');

        },

        error: function(){
            alert('Error while request..');

        }
    });
}



