


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
<form id="reporting" method="post" action="<?=main_url?>Artworks/download_artwork_report">
<div class="col-md-2 col-xs-2 pull-left">
<div class="p-t-10-td-r labels-form">
<label class="select input-border-blue">
<select name="designer-form"  class="input-border-blue validation"  data-error="Select Designer" id="designer-form">
<option value="">Designer</option>
<? foreach($alldesigners as $designerid){?>
 <option value="<?=$designerid->UserID?>"><?=$designerid->UserName?></option>
<? } ?>
</select>
<i></i>
 </label>
    </div>
</div>


<div class="col-md-2 col-xs-2 pull-left ">
    <div class="p-t-10-td-r">
    <label class="select input-border-blue">
<select name="product-form"  class="input-border-blue validation"  data-error="Select Product Type"  id="product-form">
<option value="">Product Type</option>
<option value="both">Both</option>
<option value="Rolls">Roll</option>
<option value="A4">Sheet</option>
</select>
<i></i>
</label>
</div>
</div>

<div class="col-md-2 col-xs-2 pull-left">
    <div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="file-form"  class="input-border-blue validation"  data-error="Select File Type"  id="file-form">
<option value="">File Type</option>
<option value="both">Both</option>
<option value="softproof">Soft proof</option>
<option value="print">Print File</option>
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

<div class="col-md-2 col-xs-2 pull-left" style="display:none">
    <div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="status-form"  class="input-border-blue" data-error="Select Status"  id="status-form">
<option value="">Status</option>
<option value="65">Awaiting Softproof</option>
<option value="66">Awaiting Softproof Approval</option>
<option value="67">Awaiting Customer Approval</option>
<option value="68">Awaiting Print file</option>
<option value="69">Awaiting Print file Approval</option>
<option value="70">Move To Production</option>
<option value="7">Completed</option>
<option value="all">All</option>
</select>
<i></i>
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
<h3 class="m-b-10 number-listed" id="artworkscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title">Total Artworks</p></div></div>

<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed"  id="rollartworkscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title">Total Roll Jobs</p></div></div>

<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="sheetartworkscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Total Sheet Jobs</p></div></div>

<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="movedsoftproofscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Total Softproofs</p></div></div>


<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="movedprintfilesscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Total Print files</p></div></div>


<div class="col-xs-2 col-sm-2 m-t-t-10" style="display:none">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="movedartworkscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Moved to Production</p></div></div></div>
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

	 var green = '<i class="mdi mdi-check-circle green-tick"></i>';
	 var red   = '<i class="fa  fa-times-circle red-cross"></i>';

	 var redmark = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>';
	 var greenmark = '<mark class="green-alert"><div class="sk-spinner sk-spinner-pulse green-pulse"></div>';
	 var yellowmark = '<mark class="yellow-badge-aert"><div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>'

	 $('.download-report').show();
	 $('.artwork-thead').show();



        var oTable = $('#datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy" : true,
            "sAjaxSource": mainUrl+'Artworks/search_records_datatable',
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

			    { "render" : function (data, type, row ){
                    var value   = row[6];
                    if(value!=""){return  green;}else{return red;}
                }
                },
					{ "render" : function (data, type, row ){
						 var value   = row[7];
						if(value!=""){return  green;}else{return red;}
					}
					},
				  null,
					{ "render" : function (data, type, row ){
						 var value   = row[9];
						 return "<button type='button' class='btn btn-outline-info waves-light waves-effect m-l-10 show_timeline' data-id='"+value+"' data-order='"+row[0]+"'>Check Timeline</button>";
					}
					},
              ],
			 
			
			 
            "fnInitComplete": function () {
             },
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({"name": "designer", "value": $("#designer-form").val()})
				aoData.push({"name": "product",  "value": $("#product-form").val()})
				aoData.push({"name": "file",     "value": $("#file-form").val()})
				aoData.push({"name": "date",     "value": $("#reservation").val()})
				aoData.push({"name": "status",   "value": $("#status-form").val()})
				
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
	    var designer = $("#designer-form").val();
		var product  = $("#product-form").val();
		var file     = $("#file-form").val();
		var date     = $("#reservation").val();
				
	 $.ajax({
		type: "post",
		url: mainUrl+"Artworks/search_records",
		cache: false,
		data:{designer:designer,product:product,file:file,date:date},
		dataType: 'html',
		success: function(data){
		data = $.parseJSON(data);
		   $('#artworkscount').html(data.total);
		   $('#rollartworkscount').html(data.rolls);
		   $('#sheetartworkscount').html(data.sheets);
		   $('#movedsoftproofscount').html(data.softproof);
		   $('#movedprintfilesscount').html(data.printfile);
		   //$('#movedartworkscount').val(data.production);
		},
		error: function(){
			alert('Error while request..');
		}
	});
}


   $(document).ready(function() {
	  $('#reservation').daterangepicker(null, function(start, end, label) {
		console.log(start.toISOString(), end.toISOString(), label);
	  });
   });
   
   $(document).on("click", ".show_timeline", function(e) {
	     var jobno = $(this).attr('data-id');
		 var order = $(this).attr('data-order');
		 $('#aa_loader').show();
		 
         $.ajax({
			type: "post",
			url: mainUrl+"Artworks/fetch_timeline",
			cache: false,               
			data:{jobno:jobno,order:order},
			dataType: 'html',
			success: function(data){
			  data = $.parseJSON(data);
			  $('#aa_loader').hide();
			  $('#popupdiv').html(data.html);
			  $('.timeline-modal').modal('show');
			},
			error: function(){                      
			  alert('Error while request..'); 
			}
  		 });
    });


</script>