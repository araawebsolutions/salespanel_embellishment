<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive artwork-table-row-adjust return-table" cellspacing="0" width="100%" id="awaiting_die">
    <thead class="artwork-thead">
        <tr>
            <th class="no-border">Quote No</th>
			<th class="no-border">Item Code</th>
			<th class="no-border">Description</th>
			<th class="no-border">Die Info</th>
			<th class="no-border">Product Price</th>
			<th class="no-border">Die Price</th>
			<th class="no-border">Move</th>
			<th class="no-border">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($irregular as $rowp){
    	                                
			$custominfo = $this->die_model->fetch_custom_die_quote($rowp->SerialNumber);
			$comntcount2 = $this->die_model->fetch_comments_count2($custominfo['ID']);
			if(@count($custominfo) > 0){ ?>
                                        
		<tr class="artwork-tr"> 
			<td>
				<?php if($custominfo['ID']){ ?>
				<a class="processor orange-text" onclick="getMaterial('<?=$custominfo['ID']?>','<?=$rowp->QuotationNumber?>','<?=$rowp	->SerialNumber?>')" href="javascript:void(0)"><?=$rowp->QuotationNumber?></a>
				<?php 	} else{  ?>
				<a href="javascript:void(0)" style="color: #555; font-weight: bold; cursor: default !important;"><?=$rowp->QuotationNumber?></a>
				<?php } ?>
			</td>
      	                              
			<td><?=$custominfo['tempcode']?> </td>
			<td>
				
				<?php if($custominfo['format']!=""){ ?>
				<b>Format:</b>
				<?=$custominfo['format']?>&nbsp;&nbsp;<?php } ?> <?php if($custominfo['shape']!=""){ ?> <b>Shape:</b> <?=$custominfo['shape']?> <?php } ?> <?php if($custominfo['format']!="" || $custominfo['shape']!=""){ ?><br> <?php } ?>                           
        	  	  
				
				<?php if($custominfo['width']!=""){ ?>
				<b>Width:</b><?=$custominfo['width']?> mm &nbsp;&nbsp; 
				<?php } ?>
				
				<?	if($custominfo['shape']!="Circle" && $custominfo['height']!=""){?>  
					<b>Height:</b> <?=$custominfo['height']?> mm 
				<? } ?>
				
				
				<?	if($custominfo['width']!="" || $custominfo['height']!=""){?>  <br><? } ?>
				
			
				
				<? if($custominfo['format']=="Roll"){?>
				<b>Leading Edge:</b> <?=($custominfo['shape']=="Circle")?  $custominfo['width']:$custominfo['width']?> mm <br>
				<? } ?> 
 
				<?php if($custominfo['width']!=""){ ?>
				<b>Corner radius:</b> <?=$custominfo['cornerradius']?> mm  &nbsp;&nbsp; 
					<? } ?> 
				
				<?php if($custominfo['width']!=""){ ?>
				<b>Perforation:</b> <?=$custominfo['perforation']?>
					<? } ?> 
				
				
				<?php if(count($custominfo) == 0){ ?>
				<?php echo '--------'; ?>
				<?php } ?>
				
                                        
				<?php if($custominfo['notes']!=""){ ?>
				<?php $comntcount2 = $comntcount2 +1; ?>
				<?php } ?>
			</td>
            
			<td>
				<?php if($custominfo['ID']!=""){ ?>
				<a href="javascript:void(0)" class="editdetail orange-text" data-qou="<?=$rowp->QuotationNumber?>" data-id="<?=$custominfo['ID']?>">Edit Die Info</a>
				<br />
				<a href="javascript:void(0)" class="addcomment orange-text" data-id="<?=$custominfo['ID']?>" data-q="<?=$rowp->QuotationNumber?>">
					<i id="comments2_<?=$custominfo['ID']?>"><?=$comntcount2?></i>&nbsp;comments
				</a>
				<?php } else{?>
				<?php echo '----'; ?>
				<?php } ?>
			</td>


			<td> 
				<? 
					$counting = $this->die_model->fetch_pricing($rowp->SerialNumber);
					$pricecheck = $this->die_model->pricecheck($custominfo['ID']);
					$appliedprice = 0;
					$appliedprice = $this->die_model->fetch_aplied_pricing($custominfo['QID']);
				
					if(count($counting) < 2 && $custominfo['format']=="Roll") {
						/*if(PROCESS_DIES_USER ==639057){ 
							echo '<b>Upload Data Files</b>';
						}else{
							echo '<b>Awaiting Price</b>';
						}*/
						echo '<b>Awaiting Price</b>';
					}else if(  $appliedprice['sprice'] <= 0 && $custominfo['format']!="Roll" ){
					    	echo '<b>Awaiting Price</b>';
					}
					else if(($appliedprice['sprice'] > 0 )){
						echo '<b>Price Approved</b>';
					}
				?>
			</td>

       
       
			<? 
			
      	                              
			$ddtext = (count($counting)>0)?"View Price":"Add Price";
      	                              
			$appliedprice = 0;
                                    
			if(count($counting)>0){
				$appliedprice = $this->die_model->fetch_aplied_pricing($custominfo['QID']);
				$ddtext = (count($appliedprice)>0)?'&pound;'.number_format($appliedprice['sprice'],2).' <i class="orange-text fa fa-pencil"></i>':"View Price";
			}
			?>
                                    

			<td>
				<a class="pricing" style="cursor:pointer color:#fd4913;" data-qou="<?=$rowp->QuotationNumber?>"  data-id="<?=$rowp->SerialNumber?>">
					<b class="orange-text" style="cursor:pointer" id="view_add_<?=$rowp->SerialNumber?>"><?=$ddtext?></b>
				</a>
			</td>
             
			<td>
				<?   
				//echo count($counting); echo '<br>'; echo count($appliedprice);
				if(count($appliedprice)==0){
					echo "Awaiting Data to upload";
          	                                  
				}else if(count($counting) > 0 &&  $appliedprice['sprice'] > 0){
					
						echo '<a href="javascript:void(0)" class="approveprice orange-text" data-id="'.$rowp->SerialNumber.'"><i class="fa fa-check"></i> Approve </a>';
					
					
					
				}
				else if($appliedprice['sprice'] > 0){
						echo "<b>"."Awaiting Die Price Approval"."</b>"; 
					}
				?>	   
			</td>  
			<td>
				<a href="javascript:void(0)" class="orange-text" onclick="removedie(<?=$rowp->SerialNumber?>)"><i class="fa fa-times"></i> Remove</a>
			</td>  
		</tr>       
                      
		<? } //include('assc_material.php');?>
		<? }?>                         
	</tbody>
</table>

