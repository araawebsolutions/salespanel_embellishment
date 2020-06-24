function capitalizeFirstLetter(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}
var old_flag = 0;
var default_min_h = 0;
var default_max_h = 0;
var default_min_w = 0;
var default_max_w = 0;
var request = null;
var home_request = 'disable';
var nearest_sizes = 'disable';

// intialize_width_slider();
//
// intialize_height_slider();

$( document ).ready(function() {


	$(".show-h").click(function(){
		var display = $('.labels-filters-form').css('display');
		if(display=='block'){
			$('.fnTop').show().slideDown( "slow" );
			$( ".labels-filters-form" ).slideUp( "slow" );
			change_text('VIEW FILTERS');
			//$('.show-h > span').html('<i aria-hidden="true" class="fa fa-bars"></i><div class="clear"></div>Show Filters');
		}else{
			$('.fnTop').hide().slideUp( "slow" );
			$( ".labels-filters-form" ).slideDown( "slow" );
			change_text('HIDE FILTERS');
			//$('.show-h > span').html('<i aria-hidden="true" class="fa fa-bars"></i><div class="clear"></div>Hide Filters');
		}
	});
	intialize_width_slider();
	intialize_height_slider();
	apply_hover_effect();
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="category-tooltip"]').tooltip();
	$('[data-toggle="printer-tooltip"]').tooltip();

	var newcategory = $('#newcategory').val();
	if(newcategory=='' || newcategory.length == 0){$('[data-toggle="category-tooltip"]').tooltip('show');}
});

function add_top_margins(){
	var category  = $('#newcategory').val();
	var material_code = $('#material_code').val();
	var model = $('#model').val();
	if( category == 'thermal' && $('.selected_material_box').length > 0 ){
		if(model!=''){
			$('.filter-margin').animate({ 'marginTop': '565px'}, 1000);
		}else{
			$('.filter-margin').animate({ 'marginTop': '562px'}, 1000);
		}
	}
	else if($('.selected_material_box').length > 0){
		$('.filter-margin').animate({ 'marginTop': '260px'}, 1000);
	}else{
		$('.filter-margin').animate({ 'marginTop': '390px'}, 1000);
	}
}

function add_top_margins_oldone(){
	var category  = $('#newcategory').val();
	if(category != 'thermal'){
		$('#ajax_material_sorting').animate({ 'marginTop': '310px'}, 1000);
		$('#ajax_finder_content').animate({ 'marginTop': '310px'}, 1000);
		$('#ajax_labelfilter').animate({ 'marginTop': '450px'}, 1000);
		$('#ajax_sorting_contetnt').animate({ 'marginTop': '310px'}, 1000);
		$('#ajax_model_desc').animate({ 'marginTop': '0px'}, 1000);
	}else{
		if($('#ajax_model_desc').length){
			$('#ajax_model_desc').animate({ 'marginTop': '310px'}, 1000);
		}else{
			$('#ajax_model_desc').animate({ 'marginTop': '0px'}, 1000);
		}
	}
}

function remove_top_margins(){
	$('.filter-margin').animate({ 'marginTop': '0px'}, 1000);
	$('#ajax_material_sorting').animate({ 'marginTop': '0px'}, 1000);
	$('#ajax_finder_content').animate({ 'marginTop': '0px'}, 1000);
	$('#ajax_labelfilter').animate({ 'marginTop': '0px'}, 1000);
	$('#ajax_model_desc').animate({ 'marginTop': '0px'}, 1000);
	$('#ajax_sorting_contetnt').animate({ 'marginTop': '0px'}, 1000);
}

function change_text(text){
   	 /************* New Amendments ****************/
		if( text == 'HIDE FILTERS'){
				add_top_margins();
		}else{
				remove_top_margins();
		}
	/**************************************/
	$('.show-h > span').html('<i aria-hidden="true" class="fa fa-bars"></i><div class="clea"></div> '+text);
}



$(document).on("click", ".btn_shape", function(e) {
		$('.btn_shape').removeClass('active');
		var shape = $(this).attr('data-val');
		$(this).addClass('active');
		$('#shape').val(shape);
		filter_data('shape', '');
});


function generate_shapes_html(cat){
		if(cat == 'thermal'){
			cat ='Roll';
		}
		var shapes_html = '';
		var selected = $('#shape').val();
		$.each(shape_list[cat], function( index, value ) {
				if(value.match(/single/i) || value.match(/full/i)){
					var class_name = 'single';
				}
				else if(value.match(/double/i)){
					var class_name = 'double';
				}
				else if(value.match(/triple/i)){
					var class_name = 'triple';
				}
				else if(value.match(/triple/i)){
					var class_name = 'triple';
				}
				else{
					var class_name = value.toLowerCase();
				}

				if(selected.toLowerCase() == value.toLowerCase()){
					class_name +=' active';
				}

				shapes_html += '<button type="button" class="btn_shape '+class_name+'" data-val="'+value+'" data-toggle="tooltip" data-placement="top"  title="'+value+'"></button>';

		});
		$('#shapes_box').html(shapes_html);
}



function make_html_options(list, field, name, selec){
	var option = '';
	var seleted = '';
	if(list.length > 0 ){ option = '<option value=""> ' + name + ' </option>';}
	$.each(list, function( index, value ) {
		seleted = '';
		if (value[field] == selec ) {
			seleted = 'selected="selected"';
		}
		option +='<option  '+seleted+'  value="' + value[field] + '" >' + value[field] + ' </option>';
	});
	option +='<option value="" > Reset Selection </option>';
	return option;
	//return '<option value="" > Clear Selection </option>';
}





function enable_integratedoptions(){
	$('.thermaloptions').hide();
	/*$('#categorybox').removeClass( "col-md-4");
	$('#categorybox').removeClass( "col-md-12");
	$('#categorybox').addClass("col-md-6");
	$('#categorybox').removeClass( "col-lg-12");
	$('#categorybox').removeClass( "col-lg-4");
	$('#categorybox').addClass("col-lg-6");*/

	//$('.integratedbrands').show();
	$('.integratedbrands').css('display', 'inline-block');
	$('.searchtext').hide();
}

function enable_thermaloptions()
{
	$element = $('.nlabelfilter');
	$element.prop('disabled', true);
	$element.attr('disabled', true);
	$('#home_finder').prop('disabled', true);
	disable_slider_option('disabled');
	$('#shapes_box').find('.btn_shape').prop('disabled', true);
	$('.integratedbrands').hide();
	$('.searchtext').show();
	$('.thermaloptions').show();
	$('#view').val('');
	$('#product_count').val(0);
	$('#start_limit').val(0);




}



function printer_model_data(trigger){

		var make ='';
		if(trigger!='printers'){
			make =trigger;
			trigger = '';
		}

		$('#aa_loader').show();
		show_reposition_loader();

		$.ajax({
				url: mainUrl+'search/Search/get_printer_model',
				type:"POST",
				async:"false",
				dataType: "html",
				data: { trigger:trigger,make:make},
				success: function(data){
					data = $.parseJSON(data);
					$('.registration_mark').modal('hide');
					$('#thermal').attr('checked');

					if(trigger=='printers'){
							$('#manufaturer').html(data.model);
							$('.viewtype').html(' Manufaturer ');
					}else{

							$('#model').html(data.model);
							$('.viewtype').html(' Model ');
						    $('#model').prop('disabled', false);
					}
					$('#label_counter1').html(data.count_format);
					contentbox.html(data.model_data);
					$('#aa_loader').hide();
				}
		});
}
// $(document).on("click", ".manufaturer", function(e)
// {
// 	var printer = $(this).attr('data-value');
// 	$('#ajax_model_desc').html('');
// 	if(printer.length > 0){
// 		$('#manufaturer').val(printer);
// 		printer_model_data(printer);
// 	}
// });

// $(document).on("change", "#manufaturer", function(e) {
// 			var printer = $(this).val();
// 			$('#ajax_model_desc').html('');
// 			//$('#ajax_model_desc').animate({ 'marginTop': '0px'}, 1000);
// 			if(printer.length > 0){
// 				printer_model_data(printer);
// 			}
// });

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


function toCamelCase(str) {
 	 return str.substr( 0, 1 ).toUpperCase() + str.substr( 1 );
}

function filter_data(trigger, color,pageName=""){
	
	if (trigger == "search") {
        var code = $("#filter_search_box").val();
    }
    else {
        var code = '';
    }
		
	
	
	
	$('#aa_loader').show();
	if(pageName == null){
		pageName = $('#mypageName').val();
	}
    var contentbox = $('#ajax_material_sorting');
    intialize_width_slider();
    intialize_height_slider();
	//if(typeof material_code=='undefined'){ }
	
	if(trigger=='category'){
		
		$('#material_code').val('');
		$('#color').val('');
		$('#height_min').val('');
		$('#height_max').val('');
		$('#shape').val('');

		$('#width_min').val('');
		$('#width_max').val('');
		$('#finish').val('');
		$('#material').val('');
		$('#adhesive').val('');
		$('#printer').val('');
		$('#cornerradius').val('');
		$('#brands').val('');
		
		$('#printer_width').val('');
		$('#model').val('');
		$('#ajax_model_desc').html('');

		$('#width_box_text').html(' Label Width <small>(mm)</small>');
		$('#height_box').css('visibility','');
		$('[data-toggle="category-tooltip"]').tooltip('hide');
	}

	$('[data-toggle="printer-tooltip"]').tooltip('hide');

	var material_code = '';
	var material_code = $('#material_code').val();

	var opposite = 'false';
	if ($('#opposite_dimension').is(':checked')) {
		var opposite = 'true';
	}

	var printer_width = $('#printer_width').val();
	var model = $('#model').val();
	var shape = $('#shape').val();
	shape = toCamelCase(shape);
	var category = $('#newcategory').val();
	
	if(color==''){     //if method is not autoload
		var color = $('#color').val();
	}
	
	if (category != "Roll" && category != "Integrated") {
		$(".button_column").show();
        $(".slider_column").removeClass("col-md-6")
        $(".slider_column").addClass("col-md-6")
    }
    else{
        $(".button_column").hide();
        $(".slider_column").removeClass("col-md-6")
        $(".slider_column").addClass("col-md-6")
    }
	
	if (trigger == 'category') {
		$(".btn_trigger.labels_by_size").trigger("click");
	}
  
	var finish = $('#finish').val();
	var material = $('#material').val();
	var adhesive = $('#adhesive').val();
	var printer = $('#printer').val();
	var page = $('#page_type').val();

	if(finish == 'clr'){finish = '';}
	if(material == 'clr'){material = '';}
	if(adhesive == 'clr'){adhesive = '';}
	if(printer == 'clr'){printer = '';}
	if(color == 'clr'){color = '';}
	 var label_per_sheet_selected = $('#LabelPerDie').val();
	
	if((category=='A4' || category=='A3' || category=='SRA3') &&(shape=='Rectangle' || shape=='Square')){
		$('#cornerradius_box').show();
	}else{
		$('#cornerradius_box').hide();
		$('#cornerradius').val('');
	}

	if(shape=='Circular' || shape=='Square'){
		if(shape=='Circular'){
			$('#width_box_text').html('Label Diameter <small>(mm)</small>');
		}else{
			$('#width_box_text').html('Label Width <small>(mm)</small>');
		}
		$('#height_box').css('visibility','hidden');
	}else{
		$('#height_box').css('visibility','');
		$('#width_box_text').html('Label Width <small>(mm)</small>');
	}

	var height_min = $('#height_min').val();
	var height_max = $('#height_max').val();
	var width_min = $('#width_min').val();
	var width_max = $('#width_max').val();

	if(trigger=='shape' || trigger=='brands'){
		height_min = '';
		height_max = '';
		width_min = '';
		width_max = '';
	}

	var cornerradius = $('#cornerradius').val();
	var brands = $('#brands').val();

	if(category.length < 1 ){
		alert_box('Please select label category first ');
	}else{
		$element = $('.nlabelfilter');
		$element.prop('disabled', true);
		$element.attr('disabled', true);

		$('.ThumbnailsRadio').find('input').prop("disabled",true);
		$('.ThumbnailsRadio').find('input').attr("disabled",true);

		$('#aa_loader').show();
		//show_reposition_loader();
		$('#home_finder').prop('disabled', true);
		disable_slider_option('abled');

		$('#shapes_box').find('.btn_shape').prop('disabled', true);


		if($('#wholesale').length > 0){var wholesale = $('#wholesale').val();}else {var wholesale ='';}
		if(request!=null){request.abort();}
				
		if (trigger != "search") {
			$("#filter_search_box").val('');
		}
		
		if (trigger != "LabelPerDie") {
			$("#LabelPerDie").val('');
			label_per_sheet_selected = '';
		}
		
		request = $.ajax({
			url: mainUrl+'search/filter/labelsfinderfields',
			type:"POST",
			async:"false",
			dataType: "html",
			cache: true,
			headers: {'Cache-Control':'max-age=604800, public'},
			data: {
				category: category,
				shape: shape,
				color: color,
				finish:finish,
				material:material,
				adhesive:adhesive,
				printer:printer,
				width_min:width_min,
				width_max:width_max,
				height_min:height_min,
				height_max:height_max,
				cornerradius:cornerradius,
				page:page,
				trigger:trigger,
				model:model,
				printer_width:printer_width,
				brands:brands,
				wholesale:wholesale,
				opposite:opposite,
				material_code:material_code,
				home_request:home_request,
				nearest_sizes:nearest_sizes,
				pageName:pageName,
				code:code,
				label_per_sheet_selected: label_per_sheet_selected
			},
			success: function(data){

				if(!data=='')
				{
					home_request = 'disable';
					nearest_sizes='disable';
					old_flag = 0;
					$element.prop('disabled', false);
					$element.attr('disabled', false);
					$('#shapes_box').find('.btn_shape').prop('disabled', false);

					data = $.parseJSON(data);
					console.log(data);
					if(data.response=='yes'){

						$('.sizefound').show();

						if(data.count == 0 && (trigger=='width' || trigger=='height' )){
							//swal('Label size not available','Please readjust scroll bar to find nearest sizes','warning');
							contentbox.html(data.html);
							$('.ajax_material_sorting').html(data.html);
							$('#start_limit').val(0);
							$('#label_counter').html(data.count_format);
							$('#label_counter1').html(data.count_format);
							$('#product_count').val(data.count);
							if(trigger=='width'){
								if(data.min_width && data.max_width){
									update_width_range(parseFloat(data.min_width), parseFloat(data.max_width));
									update_width_values(parseFloat(data.min_width), parseFloat(data.max_width));
								}
							}
							if(trigger=='height'){
								if(data.min_height && data.max_height){
										update_height_range(parseFloat(data.min_height), parseFloat(data.max_height));
										update_height_values(parseFloat(data.min_height), parseFloat(data.max_height));
								}
							}

							$('#home_finder').prop('disabled', false);
							//disable_slider_option('enable');
							$('#aa_loader').hide();
							return false;
						}
						$('#view').val(data.view);
						if(typeof loadproducts =='undefined'){loadproducts=false;}
						if(trigger=='autoload' && loadproducts!=true){
							//$('#view').val('category');
						}

						if(data.view=='category'){
							$('.viewtype').html(' Sizes ');
						}else{
							$('.viewtype').html(' Products ');
						}


						var is_form_display = $('.labels-filters-form').css('display')
						if(trigger!='autoload' || is_form_display=='block'){
							add_top_margins();
						}

						if(trigger=='model'){

							if(model == ''){
								$('#ajax_model_desc').html('');
							}
							else{
								$('#ajax_model_desc').html(data.printer_desc);
							}
								
							$('#ajax_finder_content').animate({ 'marginTop': '0px'}, 1000);
							$('#ajax_sorting_contetnt').animate({ 'marginTop': '0px'}, 1000);
							$('#ajax_material_sorting').animate({ 'marginTop': '0px'}, 1000);
						}

						$('#start_limit').val(0);
						$('#label_counter').html(data.count_format);
						$('#label_counter1').html(data.count_format);
						$('#product_count').val(data.count);

						var pageurl = window.location.pathname;
			
						contentbox.html(data.html);
						$('.ajax_material_sorting').html(data.html);
						
						if(trigger=='autoload' || trigger=='category' || trigger=='model' || trigger=='brands'){

						if(trigger=='autoload' || trigger=='category'){	}
							generate_shapes_html(category);
							$('#printer_width').val(data.printer_width);
						}

						if(trigger=='shape' || trigger=='category' || trigger=='autoload' || trigger=='model' || trigger=='brands' ){
							if(shape=='Circular' || shape=='Square'){
								if(trigger!='width'){
									if(data.min_width && data.max_width){
										update_width_range(parseFloat(data.min_width), parseFloat(data.max_width));
									}
									update_width_values(parseFloat(data.min_width), parseFloat(data.max_width));
								}

							}else{
								if(trigger!='width'){
									if(data.min_width && data.max_width){
										update_width_range(parseFloat(data.min_width), parseFloat(data.max_width));
									}
									update_width_values(parseFloat(data.min_width), parseFloat(data.max_width));
								}

								if(trigger!='height'){
									if(data.min_height && data.max_height){
										update_height_range(parseFloat(data.min_height), parseFloat(data.max_height));
									}
									update_height_values(parseFloat(data.min_height), parseFloat(data.max_height));
								}
							}
						}
				//disable_slider_option('enable');

				if(trigger == 'width' || trigger == 'height' || trigger == 'shape'){
				}
				else
				{
					// if(($.urlParam('width') && $.urlParam('width') != null) && trigger == "autoload")
					// {
					// 	var wid = parseFloat($.urlParam('width'));
					// 	update_width_values(Math.floor(wid), Math.ceil(wid));
					// }
					// if(($.urlParam('diameter') && $.urlParam('diameter') != null) && trigger == "autoload")
					// {
					// 	var wid = parseFloat($.urlParam('diameter'));
					// 	update_width_values(Math.floor(wid), Math.ceil(wid));
					// }
					// if(($.urlParam('height') && $.urlParam('height') != null) && trigger == "autoload")
					// {
					// 	var hei = parseFloat($.urlParam('height'));
					// 	update_height_values(Math.floor(hei), Math.ceil(hei));
					// }

					if(trigger!='color' || $('#color').val() == ''  ){
						var color_options = make_html_options(data.color_list,'LabelColor_upd','Label Colour', $('#color').val());
						$('#color').html(color_options);
						
						// if($.urlParam('color') && $.urlParam('color') != null && trigger == "autoload")
						// {
						// 	var cc = capitalizeFirstLetter($.urlParam('color'));
						// 	$('#color').val(cc);
						// }
					}
					if(trigger!='finish' || $('#finish').val() == '' ){
						var finish_options = make_html_options(data.finish_list,'LabelFinish_upd','Label Finish', $('#finish').val());
						$('#finish').html(finish_options);
					}
					if(trigger!='material' || $('#material').val() == '' ){
						var material_options = make_html_options(data.material_list,'ColourMaterial_upd','Label Material', $('#material').val());
						$('#material').html(material_options);
					}
					
					if(trigger!='printer' || $('#printer').val() == '' ){
						$('#printer').html(data.printer);
					}
					if(trigger!='adhesive' || $('#adhesive').val() == ''){
						var adhesive_options = make_html_options(data.adhesive_list,'Adhesive','Label Adhesive', $('#adhesive').val());
						$('#adhesive').html(adhesive_options);
					}
				}
						
						apply_hover_effect();
						$('[data-toggle="tooltip"]').tooltip();
						
						if (category != "Roll" && category != "Integrated" && trigger != "LabelPerDie" && data.labelpersheet_records != '') {
							$("#label_per_sheet_triggers").find(".container_of_labels").find('.datadata').html(data.labelpersheet_records);
							$('#aa_loader').hide();
							$(".container_of_labels").mCustomScrollbar({theme:"rounded"});
							$(".container_of_labels").mCustomScrollbar("scrollTo","0%");
						}		
						
						$('#aa_loader').hide();
						$('#home_finder').prop('disabled', false);
						$('.ThumbnailsRadio').find('input').prop("disabled",false);
						$('.ThumbnailsRadio').find('input').removeAttr("disabled");
					}
				}	
			}
		});
	}
}

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


function disable_slider_option(method){

	if(method=='disabled'){
			$( "#width_slider" ).slider( "option", "disabled", true);
			$( "#height_slider" ).slider( "option", "disabled", true);

			$('#width_min').prop('disabled', true);
			$('#width_max').prop('disabled', true);
			$('#height_min').prop('disabled', true);
			$('#height_max').prop('disabled', true);

	}else{
			$( "#width_slider" ).slider( "option", "disabled", false);
			$( "#height_slider" ).slider( "option", "disabled", false);

			$('#width_min').prop('disabled', false);
			$('#width_max').prop('disabled', false);
			$('#height_min').prop('disabled', false);
			$('#height_max').prop('disabled', false);
	}
}

function update_width_values ( min, max ) {
    $( "#width_slider" ).slider( "option", "values", [ min, max] );
    $(".width_lowerlimit").text(min);
    $(".width_upperlimit").text(max);
}
function update_height_values ( min, max ) {
    $( "#height_slider" ).slider( "option", "values", [ min, max] );
    $(".height_lowerlimit").text(min);
    $(".height_upperlimit").text(max);
}

function update_width_range ( min, max ) {
    $( "#width_slider" ).slider( "option", "min", min );
    $( "#width_slider" ).slider( "option", "max", max );
}
function update_height_range ( min, max ) {
    $( "#height_slider" ).slider( "option", "min", min );
    $( "#height_slider" ).slider( "option", "max", max );
}
function intialize_width_slider(){
    var width_min = document.getElementById('width_min');
    var	width_max = document.getElementById('width_max');
    $( "#width_slider" ).slider({
        range: true,
        step: 1,
        slide: function( event, ui ) {
            width_max.value = ui.values[1];
            width_min.value = ui.values[0];
        },
        change: function( event, ui ) {
            //event.currentTarget;
            width_max.value = ui.values[1];
            width_min.value = ui.values[0];
            var option = $( "#width_slider" ).slider( "option" );
            if(option.disabled==false && typeof event.currentTarget!='undefined' ){
                filter_data('width', '');
            }
        }
    });
    /********************** New Amendments **********************************/
    width_min.addEventListener('change', function(){
        $( "#width_slider" ).slider( "values", 0 , parseInt(this.value) );
        filter_data('width', '');
    });
    width_max.addEventListener('change', function(){
        $( "#width_slider" ).slider( "values", 1 , parseInt(this.value) );
        filter_data('width', '');
    });
    /******************************************************************/
}
function intialize_height_slider(){
    var height_min = document.getElementById('height_min');
    var	height_max = document.getElementById('height_max');

    $( "#height_slider" ).slider({
        range: true,
        step: 1,
        slide: function( event, ui ) {
            height_max.value = ui.values[1];
            height_min.value = ui.values[0];
        },
        change: function( event, ui ) {
            height_max.value = ui.values[1];
            height_min.value = ui.values[0];
            var option = $( "#height_slider" ).slider( "option" );
            if(option.disabled==false && typeof event.currentTarget!='undefined' ){
                filter_data('height', '');
            }
        }
    });
    /********************** New Amendments **********************************/
    height_min.addEventListener('change', function(){
        $( "#height_slider" ).slider( "values", 0 , parseInt(this.value));
        filter_data('height', '');
    });
    height_max.addEventListener('change', function(){
        $( "#height_slider" ).slider( "values", 1 , parseInt(this.value));
        filter_data('height', '');
    });
    /******************************************************************/
}

$(document).on("click", "#btn_search", function(e) {
		var category = $('#newcategory').val();
		var shape = $('#shape').val();
		if(category.length < 1 || shape.length < 1){
				alert_box('Please select label category and shape first ');
		}else{
				$('#aa_loader').show();
				show_reposition_loader();
				 setTimeout(function(){
					$('#aa_loader').hide();
				},1000);
		}
});

function apply_hover_effect(){
			$('.thumbnail').hover(
				function(){
					$(this).find('.zoom').slideDown(250); //.fadeIn(250)
				},
				function(){
					$(this).find('.zoom').slideUp(250); //.fadeOut(205)
				}
			);
}

function show_pagings(){
	var material_code = '';
	var material_code = $('#material_code').val();
	var page = $('#page_type').val();
	var shape = $('#shape').val();
	var category = $('#newcategory').val();
	var color = $('#color').val();
	var finish = $('#finish').val();
	var material = $('#material').val();
	var adhesive = $('#adhesive').val();
	var printer = $('#printer').val();
	var height_min = $('#height_min').val();
	var height_max = $('#height_max').val();
	var width_min = $('#width_min').val();
	var width_max = $('#width_max').val();
	var cornerradius = $('#cornerradius').val();
	var total = parseInt($('#product_count').val());
	var start = parseInt($('#start_limit').val());
	var view = $('#view').val();

	
	var printer_width = $('#printer_width').val();
	var model = $('#model').val();
	var opposite = 'false';
	if ($('#opposite_dimension').is(':checked')) {
		var opposite = 'true';
	}
	//alert(start+' -- '+view+'  -- '+total);
	start = start+12;
	
	if(category.length > 0 && view=='product'){

		if(start < total ){
			contentbox.find(".spinner").show();
			$('#start_limit').val(start);
			$.ajax({
				url: mainUrl+'search/Filter/loadmore_finder_products',
				type:"POST",
				async:"false",
				dataType: "html",
				data: {	
					category: category,
					shape:shape,
					color:color,
					finish:finish,
					material:material,
					adhesive:adhesive,
					printer:printer,
					width_min:width_min,
					width_max:width_max,
					height_min:height_min,
					height_max:height_max,
					cornerradius:cornerradius,
					printer_width:printer_width,
					model:model,
					page:page,
					start:start,
					material_code:material_code,
				},
				success: function(data){
					if(!data==''){
						data = $.parseJSON(data);
						if(data.response=='yes'){
							contentbox.find(".spinner").remove();
							contentbox.append(data.html);
							$('.ajax_material_sorting').append(data.html);
							apply_hover_effect();
							$('[data-toggle="tooltip"]').tooltip();
							
						}
					}
				}
			});
		}
	}
}


function onScroll() {
	
    scroll_pos = $(window).scrollTop();
    doc_height = $(document).height();
	
	dif = 2200;
	doc_height = doc_heights = parseInt(doc_height) - parseInt(dif);
//alert('Scroll='+scroll_pos+' HEight='+ doc_height+ ' doc - diff ='+ doc_heights +' old Flag='+old_flag);
      if(scroll_pos > doc_height && old_flag != doc_height) {
			var total = parseInt($('#product_count').val());
			var start = parseInt($('#start_limit').val());
		 
			if(start < total ){
				show_pagings();
				console.log(start+' : total '+total);
				old_flag = doc_height;
			}
	  }
}
$(window).scroll(onScroll);



function show_reposition_loader(_this){
		var top = $('#categorybox').offset().top;
		var left = $('#categorybox').offset().left;
		top = top+20;
		left = left+395;
		$('.loading-gif').css('top',top);
		$('.loading-gif').css('left',left);
		$('#aa_loader').show();
}


$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return 0;
    }
    else{
       return decodeURI(results[1]) || 0;
    }
}



function calculate_checks(_this,checked){
	var i = 1;
	$.each($("input[name='compare_check']:checked"),function(ind,val){
		$(this).parents('.compare_div').find('.compare_btn').text('Compare '+i+' of 4');
		i++;
	});
}
$(document).on('click','.compare_div .col-md-10',function(){
	if($(this).find('.compare_btn:disabled').length > 0)
	{
		var count = $("input[name='compare_check']:checked").length;
		if(count <= 3)
		{
			$(this).find('.compare_btn').removeAttr("disabled");
			$(this).find('.compare_btn').prop("disabled",false);
			$(this).parents(".compare_div").find("input[name='compare_check']").prop("checked",true);
			var _this = $(this);
			calculate_checks(_this,'');
			//$(this).parents(".compare_div").find(".compare_btn").text("Compare "+(count+1)+" of 4");
		}
		if(count > 3)
		{
			swal("A maximum of 4 items can compared at one time.");
			return false;
		}
	}
});




$(document).on("click",".show_nearest_sizes",adjust_sizes);

function adjust_sizes(){
	nearest_sizes='enable';
	var width_min = parseInt($("#width_min").val()) - 50;
	var width_max = parseInt($("#width_max").val()) + 50;

	var height_min = parseInt($("#height_min").val()) - 50;
	var height_max = parseInt($("#height_max").val()) + 50;

	$( "#width_slider" ).slider( "values", 0 , parseInt(width_min));
	$( "#width_slider" ).slider( "values", 1 , parseInt(width_max));

	$( "#height_slider" ).slider( "values", 0 , parseInt(height_min));
	$( "#height_slider" ).slider( "values", 1 , parseInt(height_max));

	filter_data('width', '');
}
