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



<div class="tab-content-1 orderlines">
<div class="tab-pane active" id="v-profile">
    <div class="row m-t-5">
        <span class="artwork-history-text pull-left col-md-6">Add Roll Label Details</span>
    </div>
</div>
                                
                       
<div class="row m-t-5 artwork-history-row-adjustment">
<table class="table table-hover m-0 tickets-list table-actions-bar table-roll-details"
cellspacing="0" width="100%" id="datatable" style="position: relative;">
<thead class="artwork-thead">
<tr>
<th class="no-border">Diecode</th>
<th class="no-border">Repeat Length</th>
<th class="no-border">Labels per Frame</th>
<th class="no-border">Width + 5mm reg Mark</th>
<th class="no-border">Upload Template</th>
<th class="no-border">Action</th>
</tr>
</thead>
<tbody>

<? $i=0; foreach($dies as $die){ $i++;
    $template = $this->Artwork_model->fetchtemplate($die->SerialNumber);
	$path = (isset($template) && $template!='')?ARTWORKS."theme/integrated_attach/templates/".$template:"";
	
  ?>
                 
                 
<form id="" enctype="multipart/form-data" action="<?=main_url?>artworks/addrolldetails" class="labels-form addrolldetails">
<input type="hidden" id="order" name="order" value="<?=$order?>"/>
<input type="hidden" id="serial_line" name="serial" value="<?=$die->SerialNumber?>"/>

<tr>
<td><input type="text" name="manufactureid"  value="<?=$die->ManufactureID?>" readonly="readonly"/></td>
<td><input type="text" name="repeatlength" value="<?=$die->repeat_length?>"/></td>
<td><input type="text" name="labelsperframe" value="<?=$die->label_per_frame?>"/></td>
<td class="center"><input type="text" name="widthreg" value="<?=$die->width_reg?>"/></td>
<td class="center"><input type="file" name="template" id="template" style="width:150px;">
<? if(isset($template) && $template!=''){?> <a href="<?=$path?>" target="_blank">Download Template</a> <? } ?>
</td>
<td class="center"><button style="width:120px;" type="submit" class="next btn btn-outline-dark waves-light waves-effect btn-print1">
<i class="fa fa-floppy-o fa-lg"></i>&nbsp;&nbsp;Save</button></td>


</tr>
</form>  

<? } ?> 
</tbody>
</table>
</div>
</div>


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
 $(document).ready(function (e) {
   $('.addrolldetails').on('submit',(function(e) { 
	var id = $('#serial').val(); 
	
	    e.preventDefault();
        var formData = new FormData(this);
		$("#dvLoading").css('display','block');
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
			dataType: 'json',
			success:function(data){
             window.location.reload(true);
			
            },
            error: function(data){
              console.log("error");
            }
        });
      }));
   });
</script>
