<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header no-bg">
<div class="" id="decisiondiv"></div>
</div>
</div>
</div>
</div>
</div>
</div>

<style>
.item{
 width: 33.3%;
 float: left;
}
</style>

<script type="text/javascript">
 $( document ).ready(function() {
   fetchjobsnavigation(<?=$jobno?>);
});

$(document).on("click", ".remote-control", function(e) {
	 var jobno = $(this).attr('data-id');
	 fetchjobsnavigation(jobno);
});

	
	function fetchjobsnavigation(jobno){
	    $('#aa_loader').show();
		var type = '<?=$type?>';
		 $.ajax({
			type: "post",
			url: mainUrl+"Artworks/decisionslider/"+jobno+"/"+type,
			cache: false,               
			data:{jobno:jobno},
			dataType: 'html',
			success: function(data){
			  data = $.parseJSON(data);
			  $('#aa_loader').hide();
			  $('#decisiondiv').html(data.html);
			},
			error: function(){                      
			  alert('Error while request..'); 
			}
	   });
     }
	 
  $(document).on("click", ".approvefile", function(e) {
	 var amend = $('.check:checked').length;
	 var total = parseInt(amend);
	 if(total<8){
	  swal('','please check all questions','warning');
	  return false;
	 }
	  $('#approve-close').trigger('click');
	  approveordecline('approve','comment');
 }); 
 
  $(document).on("click", ".declinefile", function(e) {
	 var comment = $('#declinecoment').val();
	 if(comment==''){
	  swal('','please Enter Rejection Reason','warning');
	  return false;
	 }
	  $('#decline-close').trigger('click');
	  approveordecline('decline',comment);
  }); 
  
  function approveordecline(val,comment){
     var id = $('#currentjob').val();
	 var type = $('#typeofapproval').val();
	 var nextjob = $('#nextjob').val();
	 var prejob  = $('#prejob').val();
	 if(nextjob==0){ nextjob = prejob; }
	  
	 var decisiontype = '<?=$type?>';
	 var hurl = (decisiontype=="rejected")?"rejected_attachments":"move_to_attachments";
	  
	 $('#aa_loader').show();	
	  $.ajax({
		url:mainUrl+'Artworks/'+hurl,
		type:"POST",
		data:{id:id,type:type,val:val,nextjob:nextjob,comment:comment,decisiontype:decisiontype},
		datatype:"html",
		success :function(data){
		   $('#aa_loader').hide();	
		   $('.check').prop('checked', false);
		   $('#declinecoment').val('');
		   $('#decisiondiv').html(data.html);
		},
		error : function(){
		 alert("Error while sending Ajax Request!");
		}
	 });
  }
	 
	 
</script>








<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  id="declinemodal" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content blue-background">
<div class="modal-header checklist-header">
<div class="col-md-12"><h4 class="modal-title checklist-title" id="myLargeModalLabel">Please add your comments</h4>
</div></div>
<div class="modal-body p-t-0">
<div class="panel-body">
<div class="col-12 no-padding"><textarea class="form-control blue-text-field" rows="5" id="declinecoment"></textarea></div>

<span class="m-t-t-10 pull-right"><button type="button"
class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 declinefile">Submit </button></span>
<span class="m-t-t-10 pull-right"><button type="button" data-dismiss="modal" aria-label="Close"
class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10" id="decline-close">Close</button></span>

</div></div></div></div></div>



<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  id="approvemodal" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content blue-background">
<div class="modal-header checklist-header">
<div class="col-md-12">
<h4 class="modal-title checklist-title" id="myLargeModalLabel">I have checked</h4>
</div>
</div>
<div class="modal-body p-t-0">
<div class="panel-body">


<table class="table table-bordered taable-bordered f-14">
<thead>
<tr>
<th class="text-center">Sr.</th>
<th>Questions</th>
<th colspan="2" class="text-center">Options</th>
</tr>
</thead>
<tbody>
<tr>
<td class="text-center">1</td><td>Font / Style</td><td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-1" type="radio" class="check"><label for="checkbox-1" class="p-m-0">YES</label>
</div></td>
</tr>
<tr>
<td class="text-center">2</td>
<td>Copy / Content</td>
<td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-2" type="radio" class="check">
<label for="checkbox-2" class="p-m-0">YES</label>
</div>
</td>
</tr>
<tr>
<td class="text-center">3</td>
<td>Colours</td><td colspan="2"><div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-3" type="radio" class="check">
<label for="checkbox-3" class="p-m-0">YES</label>
</div></td>
</tr>
<tr>
<td class="text-center">4</td><td>Label Size</td><td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-4" type="radio" class="check">
<label for="checkbox-4" class="p-m-0">YES</label>
</div></td>
</tr>
<tr>
<td class="text-center">5</td><td>Template ID</td><td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-5" type="radio" class="check">
<label for="checkbox-5" class="p-m-0">YES</label>
</div></td>
</tr>
<tr>
<td class="text-center">6</td><td>Material</td><td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-6" type="radio" class="check">
<label for="checkbox-6" class="p-m-0">YES</label>
</div></td>
</tr>
<tr><td class="text-center">7</td><td>Design Name</td><td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-7" type="radio" class="check">
<label for="checkbox-7" class="p-m-0">YES</label>
</div>
</td>
</tr><tr><td class="text-center">8</td><td>Bleed</td><td colspan="2">
<div class="checkbox checkbox-pink checkbox-circle check-list-checkbox spacial">
<input id="checkbox-8" type="radio" class="check">
<label for="checkbox-8" class="p-m-0">YES</label>
</div></td></tr>
</tbody>
</table>


<span class="m-t-t-10 pull-right"><button type="button"
class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 approvefile">Submit</button></span>
<span class="m-t-t-10 pull-right"><button type="button" data-dismiss="modal" aria-label="Close"
class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10"  id="approve-close">Close</button></span>


</div>
</div>
</div>
</div>
</div>