<div class="modal-content blue-background">
	<div class="modal-header checklist-header">
		<div class="col-md-12">
			<h4 class="modal-title checklist-title" id="myLargeModalLabel">Quote No# <?=$quote?> Custom Dies Materials</h4>
		</div>
	</div>
	<div class="modal-body p-t-0">
		<div class="panel-body" >

			<div style="<?php if(count(@$assoc) > 9){ echo 'height:350px;';}?> overflow:auto">  
				<table class="table table-bordered taable-bordered f-14" >
					<thead>
						<tr>
							<th class="text-center">Material Code</th>
							<th class="text-center">Material</th>
							<th class="text-center">Description</th>
							<th class="text-center">Qty</th>
							<th class="text-center">Material Price</th>
							<th class="text-center">Price</th>
						</tr>
					</thead>
					<tbody>
                        
						<?php   
						$custominfo = $this->die_model->fetch_custom_die_quote($serial);
						if(count(@$assoc) > 0){
							foreach($assoc as $rowpp){ ?>
						<tr>
							<td class="text-center"><b><?=$rowpp->material?></b></td>
							<td class="text-center"><?=$this->quoteModel->get_mat_name($rowpp->material);?></td>
							<td class="text-center"  colspan="">
								<?=$rowpp->labeltype?> Labels 
								<?  if($rowpp->labeltype=="printed"){ 
								echo ' - '.$rowpp->printing.' - '.$rowpp->designs.' Designs ';
	       	
								if($custominfo['format']=="Roll"){
									echo ' <br> with label finish '.$rowpp->finish;
								}
							}
								?>

								<? if($custominfo['format']=="Roll"){
									echo ' - '.$rowpp->rolllabels.' labels - core size '.$rowpp->core.' mm - '.$rowpp->wound.'  wound';
								}?>
							</td>

							<td class="text-center"><?=$rowpp->qty?></td>
							<td class="text-center">

								<? if($rowpp->tempprice==0){?>
								<i class="fa fa-close" aria-hidden="true" style="color:red"></i>
								<? }else{?>
								<i class="fa fa-check" aria-hidden="true" style="color:green"></i>
								<? } ?>
							</td>
                    
							<td class="text-center">

								<?    if($rowpp->tempprice==0){
									if(PROCESS_DIES_USER==639057){  //639057
										if($rowpp->check==0){
											echo "Upload Data Files";
										}else{ 
											$result12 = $this->die_model->applyrollprice($custominfo['ID'],$rowpp->ID);
											echo '£'.$result12['final_price'].'<br>'; 
											echo '<a class="approvepricing" data-id="'.$rowpp->ID.'"  data-serial="'.$serial.'" data-quote="'.$quote.'" data-cus-id= "'.$custominfo['ID'].'" style="cursor:pointer;color:blue" data-price="'.$result12['final_price'].'">Approve Prices</a>';
										}
									}else{
										echo "Awaiting Price";
									}
								}else{
									$price = $rowpp->plainprice+$rowpp->printprice;
									echo '£ '.number_format($price,2,'.',''); 
								}
								?>
							</td>
						</tr>

						<?php } } else{?>
						<tr class="text-center">
							<td colspan="6">
								<p>Records not found</p>
							</td></tr>
						<?php }?>
					</tbody>
                         
				</table>
			</div>
            
			<span class="m-t-t-10 pull-right">
				<button data-dismiss="modal" type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button>
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