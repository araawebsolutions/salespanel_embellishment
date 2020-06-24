<tr style="display:none;" id="assmat_<?=$custominfo['ID']?>" >
	<td colspan="8"> 
                           
                        
		<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive return-table" width="100%" cellspacing="0" >
			<thead>
				<tr class="artwork-tr-pdie">
					<th class="no-border">Material Code</th>
					<th class="no-border">Material</th>
					<th class="no-border">Description</th>
					<th class="no-border">Qty</th>
					<th class="no-border">Material Price</th>
					<th class="no-border">Price</th>
				</tr>
			</thead>
			<tbody>
				<?php   
	$assoc = $this->die_model->fetch_custom_die_association($custominfo['ID']);
    
		foreach($assoc as $rowpp){ ?>
				<tr>
					<td align="left" width="15%"><b><?=$rowpp->material?></b></td>
					<td width="20%"><?=$this->quoteModel->get_mat_name($rowpp->material);?></td>
					<td width="40%"  colspan="4">
						<?=$rowpp->labeltype?> Labels 
						<?  if($rowpp->labeltype=="printed"){ 
			echo ' - '.$rowpp->printing.' - '.$rowpp->designs.' Designs ';
	   	
			if($custominfo['format']=="Roll"){
				echo ' <br> with label finish '.$rowpp->finish;
			}
		}
						?>
                        
						<? if($custominfo['format']=="Roll"){
							echo ' - '.$rowpp->rolllabels.' labels - core size '.$rowpp->core.' mm - '.$rowpp->wound.' wound';
						}?>
					</td>



					<td width="5%"><?=$rowpp->qty?></td>
					<td width="10%">

						<? if($rowpp->tempprice==0){?>
						<i class="fa fa-close" aria-hidden="true" style="color:red"></i>
						<? }else{?>
						<i class="fa fa-check" aria-hidden="true" style="color:green"></i>
						<? } ?>
					</td>
                    
					<td width="10%">

						<?    if($rowpp->tempprice==0){
							if($this->session->userdata('UserID')==639057){  //639057
								if($rowpp->check==0){
									echo "Upload Data Files";
								}else{ 
									$result12 = $this->die_model->applyrollprice($custominfo['ID'],$rowpp->ID);
									echo '£'.$result12['final_price'].'<br>'; 
									echo '<a class="approvepricing" data-id="'.$rowpp->ID.'" style="cursor:pointer;color:blue" data-price="'.$result12['final_price'].'">Approve Prices</a>';
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

				<?php } ?>     	    
			</tbody>
		</table>
	</td>
</tr>