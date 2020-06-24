

<!-- End Navigation Bar-->
<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
    
    <!--------------------------------------------------------------------------->
    
<div class="card-header no-bg m-t-t-10">
<div class="row no-margin">
<div class="col-md-12 col-xs-12 pull-left"> 

<label class="select">
<select name="color_mat border-color-artwork">
<option>Select Designer</option>
<? foreach($alldesigners as $designerid){?>
 <option value="<?=$designerid->UserID?>"><?=$designerid->UserName?></option>
<? } ?>
</select>

<label class="select">
<select name="color_mat border-color-artwork">
<option>Select Product Type</option>
<option value="both">Both</option>
<option value="rolls">Roll</option>
<option value="sheets">Sheet</option>
</select>

<label class="select">
<select name="color_mat border-color-artwork">
<option>Select File Type</option>
<option value="both">Both</option>
<option value="softproof">Soft proof</option>
<option value="print">Print File</option>
</select>

<label class="select">
<select name="color_mat border-color-artwork">
<option>Select Date</option>
</select>


<label class="select">
<select name="color_mat border-color-artwork">
<option>Select Status</option>
<option value="65">Awaiting Softproof</option>
<option value="66">Awaiting Softproof Approval</option>
<option value="67">Awaiting Customer Approval</option>
<option value="68">Awaiting Print file</option>
<option value="69">Awaiting Print file Approval</option>
<option value="70">Move To Production</option>
<option value="7">Completed</option>
<option value="all">All</option>
</select>


<div class="btn-group dropdown" style="width: 20%;margin-left: 2%;">
<a class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn" style="color: #fff !important;margin-left: 2%;">GO</a>

<a href="<?=main_url?>Artworks/downloadcsv" type="" class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn" style="color: #fff !important;margin-left: 2%;">Download CSV</a>
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


<div class="col-xs-2 col-sm-2 m-t-t-10">
<div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
<h3 class="m-b-10 number-listed" id="movedartworkscount">--</h3>
<p class="text-uppercase m-b-5 number-listed-title-1">Moved to Production</p></div></div></div>
</div>




</div>
</div>


        
<style>
.badge-blue-left{
    font-size: 12px;
    background: #00b7f1;
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    padding-left: 5px;
    padding-right: 10px;
    float: left;
    position: absolute;
    left: -2px;
    border-left-color: white;
    border-left: 2px solid;
    top: 38px;
}
.badge-td-left{
    left: -1.8%;
    
    position: absolute;
    border-bottom: none !important;
}
.underline{
  text-decoration:underline;
  cursor:pointer;
  color: #038506 !important;
}
.hide{
display:none;
}
.comments{
 cursor:pointer;
}
</style>
         <!--------------------------------------------------------------------------->

<div class="card-body">

<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="datatable" style="position: relative;">
<thead class="artwork-thead">
<tr>
<th class="no-border">Order No.</th>
<th class="no-border">Print Job</th>
<th class="no-border">Product Type</th>
<th class="no-border">Designer</th>
<th class="no-border">CC Operator</th>
<th class="no-border">CO</th>
<th class="no-border">SP</th>
<th class="no-border">CA</th>
<th class="no-border">SF</th>
<th class="no-border">Status</th>
<th class="no-border">Timeline</th>
</tr>
</thead>
<tbody id="artwork-body">
<? include('ajax/advance-search-list.php'); ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade bs-example-modal-lg comment-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content blue-background" id="comments_modal_data"></div></div></div>


<script>
$( document ).ready(function() {
  //fetch_top_counter();
});

function fetch_top_counter(){
	$.ajax({
		type: "post",
		url: mainUrl+"Artworks/search_records",
		cache: false,               
		data:{},
		dataType: 'html',
		success: function(data){
		data = $.parseJSON(data);
		  $('#rollartworkscount').html(data.roll_jobs);
		  $('#sheetartworkscount').html(data.sheet_jobs);
		  $('#movedartworkscount').html(data.moved_jobs);
		  $('#artworkscount').html(data.total_jobs);
		  $('#totalartworkslimit').val(data.total_jobs);
		  $('#totalartworkslimit').val(data.total_jobs);
		},
		error: function(){                      
			alert('Error while request..'); 
		}
	});
}
</script>