<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg">
                    </div>
                    <div class="card-body p-7">
                        <div class="tabs-vertical-env row artwork-row-margin-adjst ">
                            <div class="tab-content-1">
                                <div class="tab-pane active" id="v-profile">
                                    <div class="row m-t-5">
                                        <span class="artwork-history-text pull-left col-md-6">Order Number : <?=$order?></span>
                                    </div>
                                </div>
                                
                        </div>
                        
                        
<? if(empty($rows)){}else{?>  

                     
<div class="tab-content-1">

                                
                       
<div class="row m-t-5 artwork-history-row-adjustment">
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap"
cellspacing="0" width="100%" id="datatable" style="position: relative;">
<thead class="artwork-thead">
<tr>
<th class="no-border">Product code</th>
<th class="no-border">Print Type</th>
<th class="no-border">Qty</th>
<th class="no-border">Designs Qty</th>
<th class="no-border">Action</th>
</tr>
</thead>
<tbody>
    <?   foreach($rows as $row){
		  $pcode = $row->ManufactureID;
		  $serial = $row->SerialNumber;
		  $pid = $row->ProductID; ?>
           
            <tr>
            <td id="<?=$serial?>_code"><?=$row->ManufactureID?></td>
            <td><?=$row->Print_Type?></td>
            <td><?=$row->Quantity?></td>
            <td><?=$row->Print_Qty?></td>
            <td>
            <button class="btn btn-outline-dark waves-light waves-effect btn-print1" style="margin-left:35px;" onclick="add_line(<?=$serial?>,<?=$pid?>)">Add Print Line</button></td>
            </tr>

      <? } ?>
 
</tbody>
</table>
</div>
</div>


<? } ?>






<div class="tab-content-1 orderlines" style="display:none">
<div class="tab-pane active" id="v-profile">
    <div class="row m-t-5">
        <span class="artwork-history-text pull-left col-md-6">Add New Artwork</span>
    </div>
</div>
                                
                       
<div class="row m-t-5 artwork-history-row-adjustment">
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap"
cellspacing="0" width="100%" id="datatable" style="position: relative;">
<thead class="artwork-thead">
<tr>
<th class="no-border">Product code</th>
<th class="no-border">Rolls/Sheets Per Design</th>
<th class="no-border">Labels Per Design</th>
<th class="no-border">File Name</th>
<th class="no-border">File</th>
<th class="no-border"></th>
</tr>
</thead>
<tbody>
<form id="add_artwork" enctype="multipart/form-data" action="<?=main_url?>Artworks/add_Artwork_form" class="labels-form">
<tr>
<td><input style="height: 35px;" type="text" id="diecode" name="diecode" readonly="readonly"/></td>
<td><input style="height: 35px;" type="text" id="sheets" name="sheets" onchange="check_quanity();" onkeypress="return isNumberKey(event)"/></td>
<td><input style="height: 35px;" type="text" id="labels" name="labels" onkeypress="return isNumberKey(event)"  onchange="verify_rolllabels();"/></td>
<td class="center"><input style="height: 35px;" type="text" id="name" name="name"/></td>
<td class="center"><div class="upload-btn-wrapper" style="text-align: left !important;">
<button class="btn btnn" style="margin-bottom: 0px;"><i class="fa fa-upload"></i> Upload Design</button><input type="file" name="file_up" id="file_up">
</div></td>
<td class="center"><button style="width:120px;" type="button" class="next btn btn-outline-dark waves-light waves-effect btn-print1" onclick="checkname();">
<i class="fa fa-floppy-o fa-lg"></i>&nbsp;&nbsp;Save</button></td>
<input type="hidden" id="serial_line" name="serial"/>
<input type="hidden" id="pro_id" name="pro_id"/>
<input type="hidden" id="order" name="order" value="<?=$order?>"/>
</tr>
</form>   
</tbody>
</table>
</div>
</div>

 <?  if(count($data)>0){ ?>


<div class="tab-content-2">
    <div class="tab-pane active" id="v-profile">
        <div class="row m-t-5">
            <span class="artwork-history-text pull-left col-md-6">Print Jobs</span>
        </div>
    </div>
    <div class="row m-t-5 artwork-history-row-adjustment">
        <table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap"
               cellspacing="0" width="100%" id="datatable" style="position: relative;">
            <thead class="artwork-thead">
            <tr>
                <th class="no-border">Print Job</th>
                <th class="no-border">Product Code</th>
                <th class="no-border">Rolls/Sheets Per Design</th>
                <th class="no-border">Labels Per Design</th>
                <th class="no-border">File Name</th>
                <th class="no-border">Action</th>
            </tr>
            </thead>
            <tbody>
            
          <?  $total_qty = $total_labels = '';
		       foreach($data as $row){
			    $total_qty+= $row->qty;
			    $total_labels+= $row->labels;
			  ?>   
                                        
    <tr style="height:12px;"></tr>
      <tr class="artwork-history-tr">
        <td class="no-border">PJ<?=$row->ID?></td>
        <td class="no-border"><?=$row->diecode?></td>
        <td class="no-border"><?=$row->qty?></td>
        <td class="no-border"><?=$row->labels?></td>
        <td class="no-border"><?=$row->name?></td>
        <td class="no-border">
            <div class="upload-btn-wrapper" style="text-align: left !important;">
                
                <a href="<?=ARTWORKS?>/theme/integrated_attach/<?=$row->file?>" target="_blank"> 
                <button class="btn btnn"> <i class="mdi mdi-download"></i>  Download </button></a> 
                </div>

             <div class="upload-btn-wrapper" style="text-align: left !important;"> 
                <button class="btn btnn" onclick="delete_line(<?=$row->ID?>)" type="button" style="border-color: #da0303 !important;color: #da0303 !important;"><i class=" mdi mdi-delete"></i> Delete
                </button></div>

        </td>
    </tr>
               
                
     <? } ?>           
      
      
<tr style="height:12px;"></tr>
<tr class="artwork-history-tr">
<td class="no-border"></td>
<td class="no-border"></td>
<td class="no-border"><b>Total Rolls/Sheets :</b> <?=$total_qty?>	</td>
<td class="no-border"><b>Total Labels :</b> <?=$total_labels?>	</td>
<td class="no-border"></td>
<td class="no-border">
</td>
</tr>          
                    </tbody>
                </table>
            </div>
        </div>


 <? } ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- en row -->
</div>
<!-- en container -->
</div>

<script>

function isNumberKey(e){
 return ( e.which!=8 && e.which!=0 && (e.which<45 || e.which>57)) ? false : true ;
}



 function add_line(serial,pro){
	$('#aa_loader').show();
	$.ajax({
		type:'POST',
		url: mainUrl+'Artworks/check_attachment_entry',
		data:{serial:serial},
		cache:false,
		dataType: 'json',
		success:function(data){
			if(data.response=='true'){
			   $('#aa_loader').hide();
			   $('.orderlines').show();		
			   var diecode = $('#'+serial+'_code').html();	
			   $('#diecode').val(diecode);
			   $('#pro_id').val(pro);
			   $('#serial_line').val(serial);
				if(data.type=="sheet"){ 
			     $('#labels').attr('readonly', 'readonly');
			  }
			   
		}else{
		  $('#aa_loader').hide();
		  swal("","Maximum Artwork Limit Reached","warning");	
		}
	  },
	  error: function(data){
	   console.log("error");
	 }
   });
  }
	
	
 function check_quanity(){
	var qty   = $('#sheets').val();
	var diecode = $('#diecode').val();
	var serial  = $('#serial_line').val();
    
	$.ajax({
		type: "post",
		url: mainUrl+"Artworks/quantity_add_artwork",
		cache: false,               
		data:{'qty':qty,'diecode':diecode,serial:serial},
		dataType: 'json',
		success: function(data){ 
		 if(data.response=='false'){
			$('#sheets').val(data.minqty);
			$('#labels').val(parseInt(data.labels));
			swal('',data.msg,'warning');
		  }else{
			 $('#labels').val(parseInt(data.labels));
		  }
		},
		error: function(){                      
		   alert('Error while request..'); 
		}
	});
 }	
	
	
	 function checkname(){ 
     	var name    = $('#name').val();
		var order   = $('#order').val();
		$('#aa_loader').show();
		$.ajax({
			type: "post",
			url: mainUrl+"Artworks/checkforname",
			cache: false,               
			data:{'name':name,'order':order},
			dataType: 'json',
			success: function(data){ 
			   $('#aa_loader').hide();
			   if(data.response=='false'){
				swal('',data.msg,'warning');
				return false;
			   }else{
				 $('#add_artwork').submit(); 
			   }
			},
		error: function(){                      
		   alert('Error while request..'); 
		}
	  });
    }
	
   function verify_rolllabels(){
        var sheets   = $('#sheets').val();
	   var labels   = $('#labels').val();
       var diecode  = $('#diecode').val();
       var serial   = $('#serial_line').val();
       
       if(sheets=='' || sheets < 1){
           alert('Enter Roll/Sheets per Design'); return false;
       }
	 
	 $.ajax({
		type: "post",
		url: mainUrl+"Artworks/verify_rolllabels",
		cache: false,               
		data:{'labels':labels,'diecode':diecode,serial:serial,sheets:sheets},
		dataType: 'json',
		success: function(data){ 
		    if(data.response=='false'){
				$('#labels').val(parseInt(data.labels));
				swal('',data.msg,'warning');
			  }else{
				 $('#labels').val(parseInt(data.labels));
			  }
		},
		error: function(){                      
		   alert('Error while request..'); 
		}
	});
 }				
				
    function delete_line(jobno){
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
			  $.ajax({
				type:'POST',
				url: mainUrl+'Artworks/delete_line',
				data:{jobno:jobno},
				cache:false,
				dataType: 'json',
				success:function(data){
				  if(data.response=='yes'){
					location.reload(true);
				  }else{
				    swal('','Request Not Accceptable.Try again Later.','warning');
				  }
				},
				error: function(data){
				  console.log("error");
				}
			 });
			  
			break;
			default:
			break;
		   }
		});
	}
	
 
   $(document).ready(function (e) {
    $('#add_artwork').on('submit',(function(e) { 
		var userfile = $("#file_up").val();
		var order   = $('#order').val();
		var diecode = $('#diecode').val();
		var sheets  = $('#sheets').val();
		var labels  = $('#labels').val();
		var name    = $('#name').val();
		
		if(order==''){
		  alert('Enter Order / Reference no'); return false;
		}
		if(diecode==''){
		 alert('Enter Product Code'); return false;
		}
		
	    if(sheets=='' || sheets < 1){
		  alert('Enter Sheets per Design'); return false;
		}
		
		if(labels=='' || labels<=0){
		  alert('Enter Labels per Design'); return false;
		}
		if(name==''){
		  alert('Enter File Name'); return false;
		}
		
		if( userfile.length == 0){
			alert('Please Select File');
			$("#file_up").focus();
			return false;
		}
		
	    e.preventDefault();
        var formData = new FormData(this);
		$('#aa_loader').show();
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
			dataType: 'json',
			success:function(data){
			  if(data.file!=''){
			   $('#aa_loader').hide();
			   window.location.reload(true);
			  }
            },
            error: function(data){
              console.log("error");
            }
         });
      }));
  });	
	
</script>
