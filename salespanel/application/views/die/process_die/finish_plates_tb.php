<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive artwork-table-row-adjust return-table" cellspacing="0" width="100%" id="finish_plates_table">
    <thead class="artwork-thead">
        <tr>
            <th class="no-border">Associated Order</th>
			<th class="no-border">Date / Time</th>
			<th class="no-border">Plate Code</th>
			<th class="no-border">Finish</th>
			<th class="no-border">Plate PDF</th>
			<th class="no-border">Approved SP</th>
			<th class="no-border">Supplier</th>
			<th class="no-border">Die Code</th>
			<th class="no-border">Status</th>
			<th class="no-border">Action</th>
			<th class="no-border">Last Updated</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($fetch_finish_plates as $platesData){
			$OAI_Data = $this->die_model->get_OAI_by_ID($platesData->oai_id);
		?>
			<tr class="artwork-tr">
				<td><?php echo $platesData->OrderNumber;?></td>
				<td>
					<?php echo date("Y-m-d", strtotime($platesData->created_date));?><br />
					<strong><?php echo date("h:i:s a", strtotime($platesData->created_date));?></strong>
				</td>
				
				<td>
					<?php
						echo preg_replace('/[^0-9]/', '', $platesData->OrderNumber);
						if( $platesData->parse_title_parent == "laminations_and_varnishes" ) {
							echo "LV";
						} else if( $platesData->parse_title_parent == "hot_foil" ) {
							echo "HF";
						} else if( $platesData->parse_title_parent == "embossing_and_debossing" ) {
							echo "ED";
						} else if( $platesData->parse_title_parent == "silk_screen_print" ) {
							echo "SSP";
						}
					?>
				</td>
				
				<td>
					<?php 
						if( $platesData->parse_title_parent == "hot_foil" ) {
							$exploded_name = explode(" ",ucwords(str_replace("_", " ", $platesData->parse_title_child) ));
							echo "<strong>Hot Foil: </strong>". ucwords(str_replace("_", " ", $platesData->parse_title_child) )." (HF". $exploded_name[0][0]. $exploded_name[1][0].")" ;
						} else {
							echo ucwords(str_replace("_", " ", $platesData->parse_title_child) );
						}
					?>
				</td>
				<td>
					<?php
						if( $platesData->parse_title_parent == "laminations_and_varnishes" ) {?>
							<a href="<?=FILEPATH.'laminations_varnishes/'.$OAI_Data->laminations_varnishes?>" target="_blank">
								<i class="fa fa-download" aria-hidden="true"></i> Download
							</a>
						<?php
						} else if( $platesData->parse_title_parent == "hot_foil" ) {?>
							<a href="<?=FILEPATH.'hot_foil/'.$OAI_Data->hot_foil?>" target="_blank">
								<i class="fa fa-download" aria-hidden="true"></i> Download
							</a>
						<?php
						} else if( $platesData->parse_title_parent == "embossing_and_debossing" ) {?>
							<a href="<?=FILEPATH.'embossing_debossing/'.$OAI_Data->embossing_debossing?>" target="_blank">
								<i class="fa fa-download" aria-hidden="true"></i> Download
							</a>
						<?php
						} else if( $platesData->parse_title_parent == "silk_screen_print" ) {?>
							<a href="<?=FILEPATH.'silkscreen_print/'.$OAI_Data->silkscreen_print?>" target="_blank">
								<i class="fa fa-download" aria-hidden="true"></i> Download
							</a>
						<?php
						}
					?>
				</td>
				<td>

					<a href="<?=FILEPATH.'softproof/'.$OAI_Data->softproof?>" target="_blank">
						<i class="fa fa-download" aria-hidden="true"></i> Download
					</a>

				</td>
				<td>
					<div class="labels-form">
						<label class="select">
							<select onchange="updateSupllier(this.value, '<?php echo $platesData->id;?>');">
								<option>Select Supplier</option>
								<?php
									foreach ($plate_suppliers as $key => $supplier) {
										if( $platesData->supplier_id == $supplier->id ) {?>
											<option value="<?php echo $supplier->id;?>" selected> <?php echo $supplier->name;?> </option>
										<?php
										} else {?>
											<option value="<?php echo $supplier->id;?>"> <?php echo $supplier->name;?> </option>
									<?php
										}
									}
								?>	
							</select>
						</label>
					</div>
				</td>
				<td>
					<?php echo $OAI_Data->diecode;?>
				</td>
				<td>
					<?php
						if( $platesData->status == 0) {
							echo "No action taken yet";
						} else if( $platesData->status == 1) {
							echo "Under Manufacturing";
						} else if( $platesData->status == 2) {
							echo "Plate Received";
						} else if( $platesData->status == 3) {
							echo "Approved";
						}
					?>
				</td>
				<td>
					<div class="labels-form">
						<label class="select">
							<select onchange="updatePlateStatus(this.value, '<?php echo $platesData->id;?>');">
								<option value="0" <?php if($platesData->status == "0") { echo "selected";}?>>No Action Taken Yet</option>
								<option value="1" <?php if($platesData->status == "1") { echo "selected";}?>>Send to Manufacture</option>
								<option value="2" <?php if($platesData->status == "2") { echo "selected";}?>>Received</option>
								<option value="3" <?php if($platesData->status == "3") { echo "selected";}?>>Approved</option>
							</select>		
						</label>
					</div>
				</td>
				<td>
					<?php echo date("Y-m-d", strtotime($platesData->updated_date));?><br />
					<strong><?php echo date("h:i:s a", strtotime($platesData->updated_date));?></strong>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

