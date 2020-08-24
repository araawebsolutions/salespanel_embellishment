


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
<h4 style="margin-left:10px">Sample to Order Conversion Report</h4>
<strong style="padding-left: 14px;">Please select the options and press "SEARCH" button to get the Results.</strong>
</div>
<? $countries = $this->Reporting_model->getcountries(); ?>
<div class="row no-margin">
<div class="col-md-12 col-xs-12 pull-left labels-form" style="margin-left:10px;margin-top:10px;">
<form id="reporting" method="post" action="<?=main_url?>Reporting/csv_from_record">
<div class="col-md-2 col-xs-2 pull-left">
<div class="p-t-10-td-r labels-form">
<label class="select input-border-blue">
<select name="country-form"  class="input-border-blue validation"  data-error="Select Country" id="country-form">
<option value="all">All Countries</option>
<? foreach($countries as $rowp){?>
 <option value="<?=$rowp->name?>"><?=$rowp->name?></option>
<? } ?>
</select>
<i></i>
 </label>
    </div>
</div>

<input type="hidden" name="type" value="download2"/>
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

<div class="col-md-6 col-xs-6 pull-left">
    <div class="p-t-10-td-r">
<a class="btn ResetButton new-button-style" onclick="search_record()">SEARCH</a>
<a class="btn ResetButton new-button-style download-report" style="display:none;" onclick="downloadreport();">Download Report </a>
</div>
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
      search_record();
  });
  
  function downloadreport(){
    $('#reporting').submit();
  }
  
 window.empty = true;
 
 function search_record(){
	 $('.download-report').show();
	 $('.artwork-thead').show();
	 
	 var country_filter = $('#country-form').val();
	 var date = $('#reservation').val();

        var oTable = $('#datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy" : true,
            "sAjaxSource": mainUrl+'Reporting/sample_records_datatable',
            "bJQueryUI": true,
            "sPaginationType": "simple_numbers",
            "iDisplayStart ": 0,
            "iDisplayLength": 10,
			"bFilter": true,
            "aaSorting" :[[0,'asc']],
             language: {
                paginate: {  next: '&#8594;',previous: '&#8592;' }
             },
              "aoColumns": [
               null,null,null,null,null,null,null,null,
              ],
		    "fnInitComplete": function () {
             },
            'fnServerData': function (sSource, aoData, fnCallback) {
				
			  aoData.push( { "name": "reservation", "value": date } );
			  aoData.push( { "name": "country_filter", "value": country_filter } );
					 
				 $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },
          });
	
  }


   $(document).ready(function() {
	  $('#reservation').daterangepicker(null, function(start, end, label) {
		console.log(start.toISOString(), end.toISOString(), label);
	  });
   });

</script>