

<!-- End Navigation Bar-->
<div class="wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<style>
.number-listed {
 font-size: 38px;
}    
</style>
    <!--------------------------------------------------------------------------->
    
<div class="card-header no-bg">
<div class="row no-margin">

<div class="col-md-5 col-xs-12 pull-left">
<div class="row" style="margin-left:0px;">
    <div style="width: 17%;margin-right: 3%;display: inline-block;"  class=" m-t-t-10">
        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
            <h3 class="m-b-10 number-listed" id="artworkscount">--</h3>
            <p class="text-uppercase m-b-5 number-listed-title" style="font-size: 11px;">Total Artworks</p></div>
    </div>
    <input type="hidden" id="totalartworkslimit"/>
    <input type="hidden" id="start_limit" value="0"/>


    <div style="width: 17%;margin-right: 3%;display: inline-block;"  class=" m-t-t-10">
        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
            <h3 class="m-b-10 number-listed" id="rollartworkscount" style="display:grid">--</h3>
            <p class="text-uppercase m-b-5 number-listed-title"style="font-size: 11px;">Total Roll Jobs</p>
        </div>
    </div>

    <div style="width: 17%;margin-right: 3%;display: inline-block;"  class=" m-t-t-10">
        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
            <h3 class="m-b-10 number-listed" id="sheetartworkscount"  style="display:grid">--</h3>
            <p class="text-uppercase m-b-5 number-listed-title-1" style="font-size: 11px;">Total Sheet Jobs</p>
        </div>
    </div>

    <div style="width: 17%;margin-right: 3%;display: inline-block;"  class=" m-t-t-10">
        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
            <h3 class="m-b-10 number-listed" id="movedartworkscount"  style="display:grid">--</h3>
            <p class="text-uppercase m-b-5 number-listed-title-1" style="font-size: 11px;">Moved to
                Production</p></div>
    </div>

    <div style="width: 17%;margin-right: 3%;display: inline-block;"  class=" m-t-t-10">
        <div class="card-box widget-flat border-custom bg-custom text-white card-padding-adjst">
            <h3 class="m-b-10 number-listed" id="totallines"  style="display:grid">--</h3>
            <p class="text-uppercase m-b-5 number-listed-title-1" style="font-size: 11px;">Total Lines</p></div>
    </div>

</div>
</div>


<div class="col-md-7 col-xs-12 pull-right">
<span class="badges-text-title">
<b>CO:</b> Customer Original Uploaded. <b>SP:</b> Soft Proof Uploaded. <b>CA:</b> Customer Approval Received. <b>PF:</b> Print Files Uploaded
</span>
<div class="m-t-20"><mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>Customer Care Team</mark>
<mark class="green-badge-aert"><div class="sk-spinner sk-spinner-pulse green-artwork-pulse"></div>Designer Team PK</mark>
<mark class="yellow-badge-aert"><div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>Customer</mark>
<mark class="blue-badge-aert"><div class="sk-spinner sk-spinner-pulse blue-artwork-pulse"></div>Designer Pending Checklist</mark>
</div>
<br><br><br><br>
<div class="m-t-20"><mark class="red-badge-aert">R = <span id="customercare_r"></span> | S = <span id="customercare_s"></span></mark>
<mark class="green-badge-aert">R = <span id="designer_r"></span> | S = <span id="designer_s"></span></mark>
<mark class="yellow-badge-aert">R =  <span id="customer_r"></span> | S =  <span id="customer_s"></span> </mark>
<mark class="blue-badge-aert">R =  <span id="checklist_r"></span> | S =  <span id="checklist_s"></span></mark>
</div>

</div>

</div>
</div>


<div class="row" style="    margin-left: 15px;margin-top: 20px;">
    <div class="col-md-2"><a href="<?=main_url?>Artworks/history" type="" class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn">Artwork History</a></div>
    <div class="col-md-2" style="    margin-left: 15px;"><a href="<?=main_url?>Artworks/advancesearch" type="" class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn" >Advance Reporting</a></div>
</div>


<?php 
	      $alert = $this->session->userdata('moved');
	      if(isset($alert) && $alert=="yes"){
		    $this->session->set_userdata('moved','no');?>
            <div class="alert alert-success">
                <strong>Success!</strong>Order Moved to Production
                </div>

        <?php } ?>
        
        
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
    
 <? $alldesigners = $this->Artwork_model->fetch_designers(); ?>    
<div class=" labels-form">
<div class=" labels-form">
<label class="select">
<select name="color_mat border-color-artwork" class="col-lg-1 form-group form-inline pull-right text-muted" id="select_designer_search" >
<option value=" " selected="selected">Select Designer</option>
<? foreach($alldesigners as $designerid){?>
  <option value="<?=$designerid->UserName?>"><?=$designerid->UserName?></option>
<? } ?>
<option value=""  >Reset Filter</option>
</select>
<i></i>
</label>
</div>
</div>    
    
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="datatable" style="position: relative;">
<thead class="artwork-thead">
<tr>
<th class="no-border">Order No.</th>
<th class="no-border">Artworks</th>
<th class="no-border">Customer / Country</th>
<th class="no-border">Designer</th>
<th class="no-border">CC Operator</th>
<th class="no-border">CO</th>
<th class="no-border">SP</th>
<th class="no-border">CA</th>
<th class="no-border">PF</th>
<th class="no-border">Status</th>
<th class="no-border">CTA</th>
<th class="no-border" style="display:none"> </th>
<th class="no-border" style="display:none"> </th>
</tr>
</thead>
<tbody id="artwork-body">
<? include('ajax/fetch_artworks.php'); ?>
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
  fetch_top_counter();
});

function fetch_top_counter(){
	$.ajax({
		type: "post",
		url: mainUrl+"Artworks/fetch_top_counter",
		cache: false,               
		data:{},
		dataType: 'html',
		success: function(data){
		data = $.parseJSON(data);
		  $('#rollartworkscount').html(data.roll_jobs);
		  $('#sheetartworkscount').html(data.sheet_jobs);
		  $('#movedartworkscount').html(data.moved_jobs);
		  $('#artworkscount').html(data.total_jobs);
		  $('#totalartworkslimit').val(data.total_lines);
		  //$('#totallines').html(data.total_lines);
		  
		  $('#customercare_r').html(data.customercare_r);
		  $('#customercare_s').html(data.customercare_s);
		  
		  $('#designer_r').html(data.designer_r);
		  $('#designer_s').html(data.designer_s);
		  
		  $('#customer_r').html(data.customer_r);
		  $('#customer_s').html(data.customer_s);
		  
		  $('#checklist_r').html(data.checklist_r);
		  $('#checklist_s').html(data.checklist_s);
		  
		  
		},
		error: function(){                      
			//alert('Error while request..'); 
		}
	});
}

var datatable_count = 1;
     // setInterval(function () {
    //     var total = parseInt($('#totalartworkslimit').val());
    //     var start = parseInt($('#start_limit').val());
    //     if (start < total) {
    //         fetch_artworks_jobs();
    //     }else{
    //         if (datatable_count === 1){
    //             $('#search_disable').hide();
    //             $(document).ready(function () {
    //                 $('#datatable').dataTable( {
    //                     "order": [ 0, 'asc' ],
    //                     "iDisplayLength"    : 10,
    //
    //                 } );
    //
    //             });
    //             datatable_count++;
    //         }
    //
    //     }
    // }, 3000);

    $('#search_disable').hide();
    $(document).ready(function () {
        $('#datatable').dataTable( {
            "columnDefs": [
                { "searchable": false, "targets": 3 }
            ],
            "order": [ 0, 'asc' ],
            "iDisplayLength"    : 25,

        } );

    });

    $(document).on("change", "#select_designer_search", function (e) {
           var designer = $(this).val();
		   $('#datatable_filter > label > input').val(designer);
		   $('#datatable_filter > label > input').trigger('keyup');
		
    });
	
	    

 function fetch_artworks_jobs(){
   var total = parseInt($('#totalartworkslimit').val());
   var start = parseInt($('#start_limit').val());
   start = start+5;
   $.ajax({
		type: "post",
		url: mainUrl+"Artworks/fetch_artworks_jobs",
		cache: false,               
		data:{start:start},
		dataType: 'html',
		success: function(data){
		data = $.parseJSON(data);
		  $('#artwork-body').append(data.html);
		  $('#start_limit').val(start);
		},
		error: function(){                      
			//alert('Error while request..'); 
		}
	});
  }
  
  
  $(document).on("click", ".comments", function(e) { 
      var order = $(this).attr('ordernumber');
	  $('#aa_loader').show();
		$.ajax({
			type: "post",
			url: mainUrl+"Artworks/fetch_comments",
			cache: false,               
			data:{order:order},
			dataType: 'html',
			success: function(data){
			  data = $.parseJSON(data);
			   $('#aa_loader').hide();
			   $('#comments_modal_data').html(data.html);
			   $('#maked_comments_'+order).hide();
			   $('.comment-modal').modal('show');
			},
			error: function(){                      
			  alert('Error while request..'); 
			}
		 });
   });
 
 
   $(document).on("change", "#select_designer", function(e) {
      var designer = $(this).val();
	  var order = $(this).attr('data-id'); 
	  if(designer==0){
	   return false;
	  }
	 
	  swal("Are you sure ?", {
			icon:'warning',
			buttons: {
			cancel: "CANCEL",
			yes: {
				text: "CONTINUE",
				value: "yes",
			  },
			},
		})
	.then((value) => {
			switch (value) {
			case "yes":
			  window.location.href= mainUrl+'Artworks/assign_to/designer/'+order+'/'+designer;
			break;
			default:
			break;
		   }
		});
	});


  $(document).on("change", "#select_operator", function(e) {
      var operator = $(this).val();
	  var order = $(this).attr('data-id'); 
	  if(operator==0){
	   return false;
	  }
	 
	  swal("Are you sure ?", {
			icon:'warning',
			buttons: {
			cancel: "CANCEL",
			yes: {
				text: "CONTINUE",
				value: "yes",
			  },		
			},
		})
	.then((value) => {
			switch (value) {
			case "yes":
			  window.location.href= mainUrl+'Artworks/assign_to/assigny/'+order+'/'+operator;
			break;
			default:
			break;
		   }
		});
	});	
	
	
  $(document).on("click", ".mover", function(e) {
      var order = $(this).attr('data-id');
	  swal("Are you sure ?", {
			icon:'warning',
			buttons: {
			cancel: "CANCEL",
			yes: {
				text: "CONTINUE",
				value: "yes",
			  },		
			},
		})
	.then((value) => {
			switch (value) {
			case "yes":
			  window.location.href= mainUrl+'Artworks/move_production/'+order;
			break;
			default:
			break;
		   }
		});
	});

</script>


 <meta http-equiv="refresh" content="300;url=<?=main_url.uri_string();?>" />
 