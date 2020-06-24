<div class="modal-content blue-background">
	<div class="modal-header checklist-header">
		<div class="col-md-12">
			<h4 class="modal-title checklist-title" id="myLargeModalLabel">Comments for Order Number : # <?=$order?></h4>
		</div>
	</div>
	<div class="modal-body p-t-0">
		<div class="panel-body" >
<?php //print_r($assoc); ?>
			<div style="<?php if(count(@$assoc) > 9){ echo 'height:450px;';}?> overflow:auto">  
				<table class="table table-bordered taable-bordered f-14" >
					<thead>
						<tr>
							<th width="20%" class="text-left">Operator</th>
							<th width="80%" class="text-left">Description</th>
							
						</tr>
					</thead>
					<tbody>
                        
						<?php   
						$i = 0;
						if(count(@$assoc) > 0){
							foreach($assoc as $rowpp){ 
						    $operator = $this->Artwork_model->get_operator($rowpp->Operator);
						?>
						<tr>
							<td class="text-left"><b><?=$operator?></b></td>
							<td class="text-left"><?=$rowpp->comment;?></td>
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
