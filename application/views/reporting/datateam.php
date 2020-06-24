


<link rel="stylesheet" type="text/css" media="all" href="<?= ASSETS ?>assets/search/daterangepicker-bs3.css" />
<script type="text/javascript" src="<?= ASSETS ?>assets/search/moment.js"></script>
<script type="text/javascript" src="<?= ASSETS ?>assets/search/daterangepicker.js"></script>
<style>
	#datatable_wrapper{
		padding: 0px 5px 21px 5px !important;
	}

  .inputstyle{
    padding: 6px;
    margin-top: 0px;
    border: 1px solid #d0effa;
    width: 148px;
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
<div class="col-md-12 col-xs-12 pull-left labels-form" style="margin-top:10px;">
<form id="reporting" method="post" action="<?=main_url?>Reporting/download_report">
<div class="col-md-2 col-xs-2 pull-left">
<div class="p-t-10-td-r labels-form">
<label class="select input-border-blue">
<select name="report-form"  class="input-border-blue validation"  data-error="Select Report Type" id="report-form">
<option value="0">Select Report Type</option>
<option value="1">General Sales Report</option>
<option value="2">Order with Expected Dispatch date Report</option>
<option value="3">Order status change log Report</option>
<option value="4">Moved to production Report</option>
<option value="5">Canon Machine Report</option>
<option value="6">Quotation Callback Report</option>
<option value="7">Quotation to Order Convert Report</option>
<option value="8">Weekly Volume Report</option>
<option value="9">Weekly Value Report</option>
<option value="10">Database Table</option>
<option value="11">Machine Production Report</option>
<option value="12">French Vat Report</option>
<option value="13">Sample and First Time Order Report</option>
<option value="14">Quotation Report</option>
<option value="15">Export Orders Report</option>
<option value="16">Hp Indigo Report</option>
</select>
<i></i>
 </label>
    </div>
</div>

<div class="col-md-2 col-xs-2 pull-left report1 general" style="display:none">
    <div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="Sheet-form"  class="input-border-blue validation"  data-error="Select Sheet Type" id="Sheet-form">
<option value="all">All</option>
<option value="printed">Printed</option>
<option value="plain">Plain</option>
</select>
<i></i>
</label>
</div>
</div>


<div class="col-md-2 col-xs-2 pull-left report1 general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="brand-form"  class="input-border-blue validation"  data-error="Select Brand Type"  id="brand-form">
<option value="all">All Brands</option>
<option value="Roll Labels">Roll Labels</option>
<option value="Integrated Labels">Integrated Labels</option>
<option value="A4 Labels">A4 Labels</option>
<option value="A3 Label">A3 Labels</option>
<option value="SRA3 Label">SRA3 Labels</option>
<option value="A5 Labels">A5 Labels</option>

</select>
<i></i>
</label>
</div>
</div>

<div class="col-md-2 col-xs-2 pull-left report1  general" style="display:none">
    <div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="product-form"  class="input-border-blue validation"  data-error="Select Product Type"  id="product-form">
<option value="all">All Products</option>
<option value="diecode">Diecode</option>
<option value="material">Material</option>
</select>
<i></i>
</label>
</div>
</div>

<div class="col-md-2 col-xs-2 pull-left report10  general specialfield" style="display:none">
<div class="p-t-10-td-r">
<input id="manufacturid"  class="validation inputstyle" type="text"  name="manufacturid" placeholder="Enter Code"/>
<i></i>
</label>
</div>
</div>


<? $countries = $this->Reporting_model->getcountries(); ?>

<div class="col-md-2 col-xs-2 pull-left report1  report14 report15 general" style="display:none">
    <div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="country-form"  class="input-border-blue" data-error="Select Country"  id="country-form">
<option value="all">All</option>
<? foreach($countries as $rowp){?>
 <option value="<?=$rowp->name?>"><?=$rowp->name?></option>
<? } ?>
</select>
<i></i>
</label>
</div></div>


<div class="col-md-2 col-xs-2 pull-left report8 report9 general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="year-form"  class="input-border-blue validation"  data-error="Select year"  id="year-form">
<?php $year = date("Y");
	  $diff = $year - 10;
	  for(; $diff <= $year; $diff++){
	?>
	<option value="<?=$diff;?>"><?=$diff;?></option>
<? }?>
</select>
<i></i>
</label>
</div>
</div>

<? $operators = $this->db->query("SELECT UserID, UserName FROM `customers` WHERE `UserTypeID` = 20 AND `Active` = 1")->result(); ?>
<div class="col-md-2 col-xs-2 pull-left report11  general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="operator-form"  class="input-border-blue validation"  data-error="Select Operator"  id="operator-form">
<option value="all">All Operator</option>
 <?php foreach($operators as $row){?>
       <option value="<?=$row->UserID;?>"><?=$row->UserName;?></option>
 <? }?>
</select>
<i></i>
</label>
</div>
</div>


<div class="col-md-2 col-xs-2 pull-left report11  general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="machine-form"  class="input-border-blue validation"  data-error="Select Machine Type"  id="machine-form">
<option value="all">All Machines</option>
<option value="F1">F1</option>
<option value="F2">F2</option>
<option value="ABG">ABG</option>
<option value="ABG2">ABG2</option>
<option value="GM">GM</option>
</select>
<i></i>
</label>
</div>
</div>

<div class="col-md-2 col-xs-2 pull-left report11  general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="sortby-form"  class="input-border-blue validation"  data-error="Select Sort by"  id="sortby-form">
<option value="operator">Sort by Operator</option>
<option value="machine">Sort by Machine</option>
</select>
<i></i>
</label>
</div>
</div>


<div class="col-md-2 col-xs-2 pull-left report11  general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="orderby-form"  class="input-border-blue validation"  data-error="Select Order by"  id="orderby-form">
<option value="wo_stock">Production From Orders</option>
<option value="w_stock">Production From Stock </option>
</select>
<i></i>
</label>
</div>
</div>



<div class="col-md-2 col-xs-2 pull-left report10  general" style="display:none">
<div class="p-t-10-td-r">
<label class="select input-border-blue">
<select name="table-form"  class="input-border-blue validation"  data-error="Select Table"  id="table-form">
<option value="1">Category Report</option>
<option value="2">Product Report</option>
<option value="3"> Batch Price Report</option>
<option value="4"> Batch Labels Report</option>
<option value="5">Stock Report</option>
<option value="6">Batch Roll Report</option>
<option value="7">Diameter Report</option>
<option value="8">Roll Discount Report</option>
<option value="9">Category Core Report</option>
</select>
<i></i>
</label>
</div>
</div>


<div class="col-md-2 col-xs-2 pull-left report1 report2 report3 report4 report5 report6 report7 report11 report12  report14 report15 report16 general" style="display:none">
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

</div>

<div class="col-md-12 col-xs-12 pull-left" style="margin-top:10px;">
    <div class="p-t-10-td-r">
<a class="btn ResetButton new-button-style download-report" onclick="downloadreport();" style="display:none">Download Report </a>
</div>
</div>


</div>
</div>

         <!--------------------------------------------------------------------------->
         <style>.artwork-thead{display:none;}.error-field{border:1px solid red !important;}</style>
</div>
</div>
</div>
</div>
</div>

<script>
 
  function downloadreport(){
     //var value = form_validation();
	 var value = true;
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
	 }
 }
   $(document).ready(function() {
	  $('#reservation').daterangepicker(null, function(start, end, label) {
		console.log(start.toISOString(), end.toISOString(), label);
	  });
   });
   
   
   $(document).on('change', '#report-form', function() {
       var value = $(this).val();
	   if(value==0){ 
	     $('.download-report').hide();
		 $('.general').hide();
		 return false;
	   }
	   
	  if( value==13){
		var url = '<?=main_url?>Reporting/samples_firstorder';  
	    window.location.href = url;
	  }else{
	   $('.general').hide();
	   $('.report'+value).show();
	   $('.download-report').show();
	  }
	  
  });
  
  $(document).on('change', '#product-form', function() {
       var value = $(this).val();
	   if(value!="all"){ 
	     $('.specialfield').show();
		 $('#reservation').css('margin-top','10px');
	    }
	  
  });


 
</script>