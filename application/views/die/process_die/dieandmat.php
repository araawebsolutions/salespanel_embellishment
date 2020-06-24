<div class="modal-content blue-background">
	<div class="modal-header checklist-header">
		<div class="col-md-12">
			<h4 class="modal-title checklist-title" id="myLargeModalLabel">Awaiting Order No# <?=$order?> Materials</h4>
		</div>
	</div>  
	<div class="modal-body p-t-0">
		<div class="panel-body" >

			<div style="<?php if(count(@$assoc) > 9){ echo 'height:350px;';}?> overflow:auto">  
                
				<?php    $dieinfo = $this->quoteModel->fetch_custom_die_order($serial); 
				?>
				<div style="padding: 1rem 1rem; border: 4px #49d0fe double; text-align: center; margin-bottom: 0.5rem;">
					<b>Format:</b>
					<?=$dieinfo['format']?>&nbsp;&nbsp;
					&nbsp;&nbsp; <b>Shape:</b> <?=$dieinfo['shape']?>&nbsp;&nbsp; <b>Width:</b> <?=$dieinfo['width']?> mm
					<? if($dieinfo['shape']!="Circle"){?>  
                
					&nbsp;&nbsp; <b>Height:</b> <?=$dieinfo['height']?> mm
					<? } ?> 
                
					<? if($dieinfo['format']=="Roll"){?>
					&nbsp;&nbsp; <b>Leading Edge:</b> <?=($dieinfo['shape']=="Circle")?$dieinfo['width']:$dieinfo['width']?> mm
					<? } ?>
                
					&nbsp;&nbsp; <b>Corner radius:</b> <?=$dieinfo['cornerradius']?> mm
                
					<? if($dieinfo['notes']!=""){?>   
					&nbsp;&nbsp;<b>Notes:</b> <?=$dieinfo['notes']?> &nbsp;&nbsp;
					<? }?>     
				</div>
                
                
				<table class="table table-bordered taable-bordered f-14" >
					<thead>
						<tr>
							<th class="text-center">Material Code</th>
							<th class="text-center">Material</th>
							<th class="text-center">Description</th>
							<th class="text-center">Qty</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>    
						<?          
						$assoc = $this->die_model->fetch_custom_die_association($dieinfo['ID']);
						foreach($assoc as $rowpp){ ?>
                             
               			
						<tr>
							<td class="text-center"><b><?=$rowpp->material?></b></td>
							<td class="text-center"><?=$this->quoteModel->get_mat_name($rowpp->material);?></td>
							<td class="text-center">
								<?=$rowpp->labeltype?> Labels 
								<?  if($rowpp->labeltype=="printed"){ 
							echo ' - '.$rowpp->printing.' - '.$rowpp->designs.' Designs ';
	   
							if($dieinfo['format']=="Roll"){
								echo ' <br> with label finish '.$rowpp->finish;
							}
						}
								?>
								<? if($dieinfo['format']=="Roll"){
									echo ' - '.$rowpp->rolllabels.' labels - core size '.$rowpp->core.' mm - '.$rowpp->wound.' wound';
								}
								?>
							</td>



							<td class="text-center"><?=$rowpp->qty?></td>
							<?  $newproductmanufactureid = $manufactureid.$rowpp->material;
																			if($dieinfo['format']=="Roll"){
																				if($rowpp->core=="25"){ $newproductmanufactureid = $newproductmanufactureid.'1';}
																				if($rowpp->core=="38"){ $newproductmanufactureid = $newproductmanufactureid.'2';}
																				if($rowpp->core=="44.5"){ $newproductmanufactureid = $newproductmanufactureid.'3';}
																				if($rowpp->core=="76"){ $newproductmanufactureid = $newproductmanufactureid.'4';}
																			}
							?>
                                       
							<td class="text-center">
								<? if($status == 76 && $rowpp->status==0){?>
								<button type="button" onclick="movetoproduction('<?=$newproductmanufactureid?>',<?=$serial?>,'<?=$order?>',<?=$rowpp->ID?>)" class="matmover">Move to production</button>
           
								<? }else if($rowpp->status==1){?>
								<b><?=$newproductmanufactureid?></b>
								<? }else{ ?>
								<b>Awaiting Die</b>
								<? } ?>
                        
								
							</td>
						</tr>

						<? } ?>     	    
					</tbody>
				</table>
			</div>
			<span class="m-t-t-10 pull-right">
				<button data-dismiss="modal" type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button>
			</span>
		</div>
	</div>
</div>