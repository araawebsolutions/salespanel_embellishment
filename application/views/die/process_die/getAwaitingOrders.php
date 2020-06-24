<style>
	.green{
		color: limegreen;
	}
	
	.red{
		color: crimson;
	}
</style>
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive artwork-table-row-adjust return-table" cellspacing="0" width="100%" id="getAwaitingOrders">
	<thead class="artwork-thead">
		<tr>
			<th class="no-border">Quote No</th>
			<th class="no-border">Date / Time</th>
			<th class="text-center">Item Code</th>
			<th class="no-border" width="16%">PDF</th>
			<th class="no-border">Supplier</th>
			<th class="no-border">New DieCode</th>
			<th class="no-border" width="12%">Display In</th>
			<th class="no-border">Admin Approval</th>
                                        
			<th class="no-border">Customer Approval</th>
			<th class="no-border">On Live</th>
			<th class="no-border">Status</th>
			<th class="no-border">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $j_arr  =json_encode($data); ?>
		<?php
		//echo '<pre>'; print_r($data); echo '</pre>';
		foreach($data as $row){ 
			$dieinfo = array();
			$dieinfo = $this->quoteModel->fetch_custom_die_order($row->SerialNumber);
			$comntcount = $this->die_model->fetch_comments_count($row->ID);
			$status = $this->die_model->getstatus($row->Status); 
				  
			$class1 = $class2 = $class3 = $class4 = $class5 = 'red';
			$icon1 = $icon2 = $icon3 = $icon4 = $icon5 = 'close';
			$fileshow='';
					   
			if($row->SA == 1){	$class1 = "green"; $icon1 = "check";}
			if($row->CA == 1){	$class2 = "green"; $icon2 = "check"; $fileshow="display:none;";}
			if($row->OD == 1){	$class3 = "green"; $icon3 = "check";}
			if($row->S_SA == 1){$class4 = "green"; $icon4 = "check";}
			if($row->OL == 1){	$class5 = "green"; $icon5 = "check";}
		?>
		<tr class="text-center artwork-tr"> 
			<td><a class="processor2 orange-text" onclick="awaitingOrderMaterial('<?=$row->SerialNumber?>','<?=$row->OrderNumber?>','<?=$row->manufactureid?>','<?=$row->Status?>')" data-id="<?=$dieinfo['ID']?>" style=" cursor:pointer;color: #fd4913;
font-weight: bold;"><?=$row->OrderNumber?></a></td>
                    
			<td><?php echo date('d-m-Y', ($row->Time)); ?></br>
				<?php echo date('<b> h : i  A</b>', ($row->Time)); ?>

			</td>
			<td><?=$dieinfo['tempcode']?><br>
				<a href="javascript:void(0)" class="comments orange-text" style="cursor:pointer;" data-id="<?=$row->ID?>">
					<i id="comments_<?=$row->ID?>"><?=$comntcount?></i>&nbsp;comments
				</a>
			</td>
                       
			<td>
                
				<?php $pdftext = (isset($row->file) && $row->file!="")?"Edit pdf":"Add pdf"; ?>
                
				<?php if(isset($row->file) && $row->file!=""){
			$path = '';  
			$href = custom_die_pdf_read.$row->file;
				?>
				<a href="<?=$href?>" class="btn btn-outline-dark waves-light waves-effect btn-sm" target="_blank" id="image_<?=$row->ID?>" download><i class="fa fa-download" aria-hidden="true"></i></a>
				<? } ?>
        	        
				<button title="<?=$pdftext?> File" data-id="<?=$row->ID?>" style="cursor:pointer;<?=$fileshow?>" class="btn btn-outline-dark waves-light waves-effect editpdfs btn-sm" id="edit_<?=$row->ID?>" onclick="showfile(<?=$row->ID?>)"><i class="fa fa-pencil"></i> <?=$pdftext?></button>
              
				<form class="updtfilepdf_aw_order" enctype="multipart/form-data" action="<?php echo main_url?>dies/dies/edit_pdf" style="display:none;" data-id="<?=$row->ID?>" id="updtfile_<?=$row->ID?>">
                    
                    
					<input style="width: 32%;padding: 0px !important;float: inline-end;height: 30px;margin-top: 7px !important;margin-left: 0.5rem !important;" class="waves-light waves-effect hintsbtn up_file" type="file"  id="file_<?=$row->ID?>" name="file" accept="pdf"/>
                   
					<input type="hidden" value="<?=$row->ID?>" name="ID">
					<input type="hidden" value="<?=$row->SerialNumber?>" name="serial">
                    
					<button type="submit" title="Update Pdf File" style="margin-top:0.5rem; float: inline-end;" class='btn btn-outline-dark waves-light waves-effect up_btn btn-sm' disabled>Update </button>
                                        
          	           
					<button type="button" onclick="can_btn(<?=$row->ID?>)" title="cancel" style="margin-top:0.5rem; float: inline-end; margin-right:0.5rem" class='btn btn-outline-dark waves-light waves-effect up_btn btn-sm can_id'><i class="fa fa-times"></i> </button>    
                   
				</form> 
				<input type="hidden" class="pdffile" value="<?=$row->file?>" id="validator<?=$row->ID?>"/>
			</td>
                      
			<td><?=@$this->die_model->fetchsupplier($dieinfo['QID']);?></td>        
                                        
			<td class="section text-center">
				<? if(($row->Status == 37) ||  ($row->Status == 71)){?>
                
				<div class="labels-form">
					<label class="input ">
          	                                              
						<input style= "width:100%; cursor:pointer" type="text" readonly name="txt2" class="updaters input-border-blue" placeholder="ManufactureID" value="<?=$row->manufactureid?>" data-id="<?=$row->ID;?>" id="mid<?=$row->ID?>"/>
					</label>
				</div>
                      
                
				<a id="update_<?=$row->ID;?>" data-id="<?=$row->ID;?>" data-type="manufactureid" class="update btn btn-outline-info waves-light waves-effect btn-sm" style="cursor:pointer;display:none; margin-top:0.5rem" >Update</a>

                    <?php
                    $hiig = '';
                    if($dieinfo['shape']=="Square"){
                        $hiig = $dieinfo['width'];

                    } else{
                        $hiig = $dieinfo['height'];
                    }?>
                
				<a id="view_code<?=$row->ID;?>" data-id="<?=$row->ID;?>" onClick="showCode(<?=$row->ID?>,<?=$dieinfo['labels'];?>,'<?=$dieinfo['shape'];?>','<?=$dieinfo['format'];?>','<?=$dieinfo['width'];?>','<?=$hiig;?>')" class="code btn btn-outline-dark waves-light waves-effect btn-sm" style="cursor:pointer;display:none; margin-top:0.5rem" >View Code</a>
				
				<? } else{echo '<p>'.$row->manufactureid.'</p>'; }?>
			</td>
                    
			<td>
				<? if($row->Status != 37){ echo '<p>'.$row->display_in.'</p>'; }else{?>
				<div class="labels-form">
					<label class="select ">
                                                        
						<select class="input-border-blue select_option">
							<option value="">Select Option</option>
							<option <?php if($row->display_in == 'Website'){echo 'selected="selected"';}?> value="Website">Website</option>
							<option <?php if($row->display_in == 'Backoffice'){echo 'selected="selected"';}?>   value="Backoffice">Backoffice</option>
							<option <?php if($row->display_in == 'Both'){echo 'selected="selected"';}?>     value="Both">Both</option>
						</select>
						<i></i>
					</label>
				</div>
				<? } ?> 
			</td>
			<td><span class="<?=$class1?>"><i class="fa fa-<?=$icon1?>" aria-hidden="true"></i> </span></td>
			<td><span class="<?=$class2?>"><i class="fa fa-<?=$icon2?>" aria-hidden="true"></i></span></td>
			<td><span class="<?=$class5?>"><i class="fa fa-<?=$icon5?>" aria-hidden="true"></i></span></td>
			<td><?=$status[0]->StatusTitle?><br><?php echo '<b>V'.$row->version;'.</b>'?></td>
                    
			<td>
				<?php  
			 		  
			if($row->Status == 76){
				echo "<b>Move to Production</b>"; 
			}else{
				if($row->Status != 67 && $row->Status != 7 && $row->Status != 75){?>
                
				<button class="btn-approve action btn btn-outline-info waves-light waves-effect btn-sm" data-id="<?=$row->ID?>" type="button" data-status="<?=$row->Status?>" data-serial="<?=$row->SerialNumber?>" data-order="<?=$row->OrderNumber?>">
					<?=$status[0]->Action?> </button>
                
				<? }else if(PROCESS_DIES_USER==$this->session->userdata('UserID') && $row->Status == 75){ ?>
                
				<button class="btn-approve action btn btn-outline-info waves-light waves-effect btn-sm" data-id="<?=$row->ID?>" type="button"  data-status="<?=$row->Status?>" data-serial="<?=$row->SerialNumber?>" data-order="<?=$row->OrderNumber?>"> <?=$status[0]->Action?> </button>
							
				<? }else if($status == 74 || $status == 75){ ?>
			    	<b> Waiting To Go live</b>
				<? } else if($row->Status == 76){ ?>
				    <b> On live</b>
				<? }else{ echo "<b>Awaiting upload on Demo</b>"; } ?>  
				<? } ?> 
                        
			</td>
		</tr>
    	                           
		<?php }?>
	</tbody>
</table>



<script type="text/javascript">

	function showfile(id){
        
		$('#updtfile_'+id).css("display","inline");
		$('#edit_'+id).hide();
		show_hide(id);
	}
    
	$('.up_file').change(function(){
		$('.up_btn').prop('disabled',false);
	});
    
	function can_btn(id){
  	      
		$('#updtfile_'+id).css("display","none");
		$('#edit_'+id).css("display","inline");
	}
    
    
	function show_hide(id){
		var  data = $.parseJSON(<?=$j_arr?>);
        
		for(i = 0; i < data.length; i++){
			var obj = data[i];
			var row_id = obj.ID;
            
			if(row_id==id){
				$('#updtfile_'+id).show();
				$('#edit_'+id).hide();
			}
            
			if(row_id!=id){
				$('#updtfile_'+row_id).css("display","none");
				$('#edit_'+row_id).css("display","inline");
			}
		}
	}	
    
    
    
	$(document).on("click", ".updaters", function(e) {
		$(this).parents('.section').find('.code').show();
		var id = $(this).attr('data-id');
		//alert(id);
		show_hide_aw_or(id);
		//alert(id);
	});
    
    
	function show_hide_aw_or(id){
		var  data = $.parseJSON(<?=$j_arr?>);
        
		for(i = 0; i < data.length; i++){
			var obj = data[i];
			var row_id = obj.ID;
            
			if(row_id==id){
							$('#update_'+id).hide();
				$('#view_code'+id).show();
			}
            
			if(row_id!=id){
				$('#update_'+row_id).css("display","none");
				$('#view_code'+row_id).css("display","none");
			}
		}
	}
    
    
    
	function awaitingOrderMaterial(serial,order,manufactureid,status){
  	      
		$('#aa_loader').show();
    	                    
		$.ajax({
			type: "post",
			url: mainUrl+"dies/dies/fetch_awaiting_order_material",
			cache: false,               
			data:{serial:serial,order:order,manufactureid:manufactureid,status:status},
			dataType: 'html',
			success: function(data){
				$('#aa_loader').hide();
				data = $.parseJSON(data);
				$('#edit_info_data').html(data.html);
				$('#edit_info').modal('show');
			},
			error: function(){                      
				swal('warning','Error while request..','warning'); 
				$('#edit_info').modal('hide');
				$('#aa_loader').hide();
			}
		});
	}
  </script>