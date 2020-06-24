


<link rel="stylesheet" type="text/css" media="all" href="<?= ASSETS ?>assets/search/daterangepicker-bs3.css" />
<script type="text/javascript" src="<?= ASSETS ?>assets/search/moment.js"></script>
<script type="text/javascript" src="<?= ASSETS ?>assets/search/daterangepicker.js"></script>
<style>
	#datatable_wrapper{
		padding: 0px 5px 21px 5px !important;
	}
</style>

<!-- End Navigation Bar-->
<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">

    <!--------------------------------------------------------------------------->

<div class="card-header no-bg">
<div class="col-md-12 col-xs-12 p-t-10-td-r m-t-t-10">
<strong style="padding-left: 14px;">Please select the options and press "SEARCH" button to get the Results.</strong>
</div>

<div class="row no-margin">
<div class="col-md-12 col-xs-12 pull-left labels-form" style="margin-left:10px;margin-top:10px;">
<form id="reporting" method="post" action="<?=main_url?>Reporting/download_courier_report">
<div class="col-md-2 col-xs-2 pull-left">
<div class="p-t-10-td-r labels-form">
<label class="select input-border-blue">
<select name="courier-form"  class="input-border-blue validation"  data-error="Select Courier Service" id="courier-form">
<option value="">Courier Service</option>
 <option value="Parcelforce">Parcelforce</option>
 <option value="DPD">DPD</option>
 <option value="Both">Both (DPD+Fedex)</option>
 <option value="all">All</option>
</select>
<i></i>
 </label>
    </div>
</div>

<div class="col-md-2 col-xs-2 pull-left">
	<div class="p-t-10-td-r labels-form">
	<label class="select input-border-blue">
		<select name="service-form"  class="input-border-blue validation"  data-error="Select Shipping Service" id="service-form">
		<option value="all">All Shipping Services</option>
			<?php
				if( (isset($shippingServices)) && ($shippingServices != '') && (count($shippingServices) > 0) )
				{	
					foreach($shippingServices as $key => $shippingService)
					{
						?> <option value="<?php echo $shippingService->ServiceID;?>"><?php echo $shippingService->ServiceName;?></option> <?php
					}
				}
			?>
		</select>
		<i></i>
	 </label>
    </div>
</div>



<div class="col-md-2 col-xs-2 pull-left">
    <div class="p-t-10-td-r">
<label class="select input-border-blue">
<div class="control-group">
<div class="controls">
 <div class="input-prepend input-group">
   <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
   <input type="text" style="width: 200px;padding: 8px;" name="reservation" id="reservation" class="form-control daterangepicker validation"
    value=""  data-error="Select Date / Time"/>
 </div>
</div>
</div>
</label>
</div></div>

</form>

<div class="col-md-2 col-xs-2 pull-left">
    <div class="p-t-10-td-r">
<a class="btn ResetButton new-button-style" onclick="validation()">SEARCH</a>
<a class="btn ResetButton new-button-style download-report" style="display:none;" onclick="downloadreport();">Download Report </a>
</div>
</div>

</div>

<div class="col-md-10 col-xs-10 pull-left">
<div class="row">
<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="totalOrders">--</h3>
<p class="text-uppercase m-b-5 number-listed-title">Total Orders</p></div></div>

<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed"  id="totalOrdersAmount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title">Total Orders Amount</p></div></div>

<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="totalDPDOrders">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Total DPD Orders</p></div></div>

<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="totalFedexOrders">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Total Parcelforce Orders</p></div></div>


</div>
</div>
</div>
</div>

         <!--------------------------------------------------------------------------->
<style>.artwork-thead{display:none;}.error-field{border:1px solid red !important;}</style>
<div class="col-xs-12 col-sm-12 m-t-t-10">
 <?php echo $this->table->generate(); ?>
</div>

</div>
</div>
</div>
</div>
</div>
<div id="popupdiv"></div>

<script>
   $(document).ready(function () {
      //fetch_top_counter();
  });
  
  function downloadreport(){
     var value = form_validation();
	 if(value==true){
	  $('.validation').removeClass('error-field');
	  $('#reporting').submit();
	 }
  }
  
 window.empty = true;
 function form_validation(){ 
    $('.validation').each(function() {
      var value = $(this).val();
	  var attr  = $(this).attr('data-error');
	   if(value==""){
	     swal('',attr,'warning');
		 $('.validation').removeClass('error-field');
		 $(this).addClass('error-field');
	      window.empty = false;
		  return window.empty;
		}else{ window.empty = true;}
	});
	
	return empty;
 }
 
 function validation(){ 
     var value = form_validation();
	 if(value==true){
	  $('.validation').removeClass('error-field');
	  search_record();
	 }
 }
 
 
 function search_record(){

	 $('.download-report').show();
	 $('.artwork-thead').show();

        var oTable = $('#datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy" : true,
            "sAjaxSource": mainUrl+'Reporting/search_records_datatable',
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
			"bFilter": false,
            "aaSorting" :[[0,'asc']],
             language: {
                paginate: {  next: '&#8594;',previous: '&#8592;' }
             },
              "aoColumns": [
               null,null,null,null,null,null,
              ],
			 
			
			 
            "fnInitComplete": function () {
             },
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({"name": "courier", "value": $("#courier-form").val()})
				aoData.push({"name": "date",     "value": $("#reservation").val()})
				aoData.push({"name": "shippingServices",     "value": $("#service-form option:selected").val()})
				
				 $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },
          });
		  
		  fetch_top_counter();
    }

    function fetch_top_counter(){
	    var courier = $("#courier-form").val();
		var date     = $("#reservation").val();
		var shippingServices     = $("#service-form").val();
				
	 $.ajax({
		type: "post",
		url: mainUrl+"Reporting/search_records",
		cache: false,
		data:{courier:courier,date:date,shippingServices:shippingServices},
		dataType: 'html',
		success: function(data)
		{

			data = $.parseJSON(data);
		   
		   if(data.total == null){
		   	$('#totalOrders').html(0);
		   }
		   else{
		   	$('#totalOrders').html(data.total);
		   }

		   if(data.TotalOrderValues == null){
		   	$('#totalOrdersAmount').html(0);
		   }
		   else{
		   	$('#totalOrdersAmount').html(data.TotalOrderValues);
		   }
		   
		   if(data.DPDTotal == null){
		   	$('#totalDPDOrders').html(0);
		   }
		   else{
		   	$('#totalDPDOrders').html(data.DPDTotal);
		   }

		   if(data.FedexTotal == null){
		   	$('#totalFedexOrders').html(0);
		   }
		   else{
		   	$('#totalFedexOrders').html(data.FedexTotal);
		   }
		},
		error: function(){
			alert('Error while request..');
		}
	});
}

$(document).ready(function() {
	  $('#reservation').daterangepicker(null, function(start, end, label) {
	  });
   });

</script>