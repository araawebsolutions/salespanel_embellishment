<div class="modal-content blue-background">
	<div class="modal-header checklist-header">
		<div class="col-md-12">
			<h4 class="modal-title checklist-title" id="myLargeModalLabel">Quote No# <?=$quote?> Custom  Dies Comments</h4>
           
		</div>
	</div>
	<div class="modal-body p-t-0">
		<div class="panel-body" >

			<div style="<?php if(count($data) > 9){ echo 'height:350px;';}?> overflow:auto">  
				<table class="table table-bordered taable-bordered f-14" >
					<thead>
						<tr>
							<!--<th class="text-center">Sr#</th>-->
							<th class="text-center">Operator</th>
							<th class="text-center">Comments</th>
							<th class="text-center">Time</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
                        
						<? if(isset($result) && $result['notes']!=""){
	$qdetail = $this->db->query("select QuotationDate,ProcessedBy from quotations where QuotationNumber LIKE'".$quote."'")->row_array();
						?>
            	            
						<tr>
							<!--<td class="text-center"><b><?php echo $i; ?></b></td>-->
							<td class="text-center"><b><?=$qdetail['ProcessedBy']?></b></td>
							<td class="text-center"><?=$result['notes']?></td>
							<td class="text-center"><?php echo date('d/m/Y h:i:s a',$qdetail['QuotationDate']); ?></td>
							<td class="text-center"><b>----</b></td>
						</tr>
                        
						<?php }  ?>
                       
                       
                        
						<? if(isset($data) && count($data) > 0 ){?>
						<? foreach($data as $row){
									$operator = $this->die_model->get_operator($row->Operator);
						?>  
						<tr class="">
							<td class="text-center"><b><?=$operator?></b></td>
							<td class="text-center"><?=$row->comment?></td>
							<td class="text-center"><?php echo date('d/m/Y h:i:s a',$row->Time); ?></td>
							<td class="text-center orange-text">
								<a data-serial="<?=$row->serial?>" data-id="<?=$row->ID?>" data-q="<?=$quote?>" class="deleter orange-text" style="cursor:pointer;">Remove</a>
							</td>
						</tr>
						<?php } ?>
						<? }  ?>
                        
						<?php if(isset($data) && count($data) == 0 && $result['notes']==""){?>
						<tr>
							<td colspan="4" style="text-align:center">
								<h5>Record Not found</h5>
							</td>
						</tr>
						<?php } ?>
            	             
					</tbody>
				</table>
			</div>
			<div id="adder" style="display:none">
				<div>
					<span class="return-title-texts"><i class="fa fa-plus"></i> New Comment</span><br>
          	                      
					<div class="input-margin-10 m-t-t-10" style="margin-left: 0px !important;margin-right: 0px !important;">
						<div class="form-group">
							<textarea class="form-control" id="new-comment" rows="5" name="pre_action_taken"
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 100px;border-color: #d0effa;"
                                                  spellcheck="false" placeholder="Enter comments"></textarea>
						</div>
					</div>
                    
					<button id="save" data-serial="<?=$serial?>" class="btn btn-outline-info waves-light waves-effect p-6-10 m-r-10" data-q="<?=$quote?>" style="margin-left: 10px !important;">Save</button>
                
					<button id="show_foo" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Cancel</button>
				</div>
			</div>
          
			<span class="m-t-t-10 pull-right">
				<button data-dismiss="modal" type="button" class="btn btn-outline-dark waves-light waves-effect btn-	countinue m-r-10">Close</button>
			</span>
			<span class="m-t-t-10 pull-right">
				<button type="button" id="foo" class="btn btn-outline-info waves-light waves-effect p-6-10 m-r-10"><i class="fa fa-plus"></i> Add Comment </button>
			</span>
            
           
            
		</div>
	</div>
</div>


          
		  
<script>
	$('#foo').click(function() { // the button - could be a class selector instead
		$(this).hide();
		$('#adder').show();
	});
    
	$('#show_foo').click(function() { // the button - could be a class selector instead
		$('#adder').hide();
		$('#new-comment').val('');
		$('#foo').show();
	});
    
    
		   
	$('#save').click(function() { // the button - could be a class selector instead
		var comment = $('#new-comment').val();
		var serial = $(this).attr('data-serial');
		var quote = $(this).attr('data-q');
			   
		if(comment=="" || comment==" "){
			swal('Warning','Please Provide Comment first','warning');
			//alert('Enter Comment First');
			return false;
		}
		$('#aa_loader').show();		
		$.ajax({
			type: "post",
			url: mainUrl+"dies/dies/save_comment2",
			cache: false,               
			data:{comment:comment,serial:serial,quote:quote},
			dataType: 'html',
			success: function(data){
				data = $.parseJSON(data);
				$('#edit_info_data').html(data.html);
				$('#comments2_'+serial).html(data.count); 
				$('#aa_loader').hide();
				swal('Success','Comment is Saved Successfully','success');
			},
			error: function(){                      
				$('#edit_info').modal('hide');
				$('#aa_loader').hide();
				swal('Warning','Error while request..','warning');
			}
		});
	});
		   
	$('.deleter').click(function() { // the button - could be a class selector instead
		var id = $(this).attr('data-id');
		var serial = $(this).attr('data-serial');
		var quote = $(this).attr('data-q');
				
        
		swal("Are you sure do you want to remove this comment?", {
			icon:'warning',
			title: 'Confirm',
			dangerMode: true,
			buttons: {
				cancel: "CANCEL",
				yes: {
					text: "Continue",
					value: "yes",
				},
			},
		})
			.then((value) => {
			switch (value) {
				case "yes":
                    
					$('#aa_loader').show();
                    
					$.ajax({
						type: "post",
						url: mainUrl+"dies/dies/delete_comment2",
						cache: false,               
						data:{id:id,serial:serial,quote:quote},
						dataType: 'html',
						success: function(data){
                                                      
							data = $.parseJSON(data);
							$('#edit_info_data').html(data.html);
							$('#comments2_'+serial).html(data.count); 3
                            
							$('#aa_loader').hide();
							swal('Success','Comment is Removed Successfully','success');
						},
						error: function(){                      
							//alert('Error while request..'); 
							$('#edit_info').modal('hide');
							$('#aa_loader').hide();
							swal('Warning','Error while request..','warning');
						}
					});
                    
					break;
			}
		});         
	});
</script>