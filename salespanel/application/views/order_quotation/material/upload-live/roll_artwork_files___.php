<style>
	.fart{
		display: none;
	}
</style>
<?php	

$files = $this->home_model->fetch_uploaded_artworks($cartid, $ProductID);
		
$ManufactureID = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $ProductID);
			
			
$total = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
$labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
$designs = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Qty', 'ID', $cartid);
$minroll = $this->home_model->min_qty_roll($ManufactureID);
$min_labels_per_roll = $this->home_model->min_labels_per_roll($minroll);
		

$upload_path = 'https://www.aalabels.com/theme/integrated_attach/';
$uploaded_designs = 0; 
?>
 
         
        <input type="hidden" value="<?=$LabelsPerSheet?>" id="labels_p_sheet"  />
        <input type="hidden" value="<?=$cartid?>" id="cartid"  />
        <input type="hidden" value="<?=$ProductID?>" id="cartproductid"  />
             
   		 <table class="table table-striped">
			 <thead class=""> 
				 <tr>
					 <th width="10%" class="text-center">Artwork to Follow</th>
					 <th width="10%" class="text-center">Artworks</th>
					 <th width="15%" class="text-center">File Name</th>
					 <th width="15%" class="text-center">No. Labels</th>
					 <th width="10%" class="text-center">Per roll</th>
					 <th width="15%" class="text-center">Rolls</th>
					 <!--<th width="10%" class="text-center">Diameter</th>-->
					 <th width="15%" class="text-center">Action</th>
				 </tr>
			 </thead>
			 <tbody>
 	                 
				 <? 
	$uploaded_designs = 0;	
			   $total_labels = 0;
			   $total_rolls = 0;
						
			 if(count($files) > 0){
				
					
					 foreach($files as $row){
						
						 $total_labels+= $row->labels;
						 $total_rolls+=$row->qty;
						 $uploaded_designs++; 
						 
						 $diamter = $this->home_model->get_auto_diameter($ManufactureID,$row->labels,$gap,$size);
			 ?>
				 <tr class="upload_row"> 
					 
					 <td width="" class="text-center"> 
						 <?php if($row->file!=""){ ?>
						 <i class="fa fa-times" style="color:red"></i>
						 <?php } ?>
																   
						 <?php if($row->file=="") { ?>
						 <i class="fa fa-check" style="color:green"></i>
						 <?php  }?>
					 </td>
			 
					 <td width="" class="text-center">
						 <img class="img-circle" src="<?=$upload_path.$row->file?>" width="30" height="">
					 </td>
					 <td width="">
						 <?=$row->name?>
					 </td>
					 <td width="">
						 <input data-toggle="popover" data-content="" class="form-control roll_labels_input allownumeric" 
                                 value="<?=$row->labels?>" placeholder="<?=$min_labels_per_roll*$minroll?>+" type="number">
					 </td>
					 <td width="" style="vertical-align:middle; text-align:center">
						 <small class="show_labels_per_roll"><?=$row->labels/$row->qty?> </small>
					 </td>
					 <td width="" class="text-center">
						 <input value="<?=$row->qty?>" class="form-control input-number text-center allownumeric  input_rolls" type="number">
					 </td>
					 <!--<td width="" style="vertical-align:middle; text-align:center">
						 <small><?=$diamter?> mm</small>
					 </td>-->
				  
					 <td width="" align="center" class="text-center">
						 <button style="display:none; padding: 8px;" data-value="roll" data-id="<?=$row->ID?>" title="Update artwork details" class="roll_updater  btn btn-success">
							 <i class="fa fa-save"></i>
						 </button>
				  				  			  
						 <button data-value="roll" id="<?=$row->ID?>" title="Delete Artwork" class="delete_artwork_file  btn btn-success"  style="padding: 8px;background-color: gray; border: 1px solid gray;">
							 <i class="fa f-10 fa-trash "></i>
						 </button>
					 </td>
				 </tr>
                    
           <? } 
			
				$remaingsheets = $labels-$total_labels;
			}
			
			//$expected_labels = $remaingsheets*$details['LabelsPerSheet'];
			//$expected_labels =($expected_labels>0)?$expected_labels:'';
			
			
			?>
            
            
            
            
				 <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
					 
					 <td width="" class="text-center">
						 <input type="checkbox" class="follow_arts" id="follow_art" name="follow_art" type="form-control"/>
					 </td>
					 
					 <td width="" class="text-center">
						 <img width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" />
						 <p style="color:green" class="fart Artworkfollow" id="Artworkfollow">Artwork to Follow</p>
						 <div class="upload-btn-wrapper">
							 <button class="btn artwork_upload_cta rfiles"> <i class="fa fa-cloud-upload"></i> Browse File</button>
							 <input type="file" name="artwork_file" class="artwork_file"  />
						 </div>
					 </td>
					 
					 <td  width="">
							  <input class="form-control artwork_name" placeholder="Artwork Name" type="text">
					 </td>
					 
					 <td  width="">
						 <input class="form-control roll_labels_input allownumeric" value="" data-toggle="popover" data-content=""  
                            placeholder="Enter labels" type="number">
					 </td>
					 
					 <td  width="" style="vertical-align:middle; text-align:center">
						 <small class="show_labels_per_roll"></small>
					 </td>
					 
					 <td width="" class="text-center">
						 <input value="<?=$minroll?>" data-toggle="popover" data-content="" 
                        style="display:none;" class="form-control input-number text-center allownumeric input_rolls" type="number">
						 <label class="quantity_labels"><?=$minroll?></label>&nbsp;
						 <a href="javascript:void(0);" class="quantity_editor"><i class="fa fa-pencil"></i> Edit </a>
					 </td>
					 
					 <!--<td width="" style="vertical-align:middle; text-align:center">
						 <small>&nbsp;</small>
					 </td>-->
					 
					 <td width="" align="center">
						 <button data-value="roll" class=" btn btn-success save_artwork_file_roll" style="padding: 8px;"> <i class="fa fa-save"></i></button>
						  
						 <button data-value="sheets" title="Delete Artwork" class="hide_another_art  btn btn-success"  style="padding: 8px;background-color: gray; border: 1px solid gray;"><i class="fa f-10 fa-trash "></i>
						 </button>

					 </td>
				 </tr>
                  
                  <tr id="upload_progress" style="display:none;">
                  	 <td colspan="6">
                  		    <div id="progressbar" class="col-md-11"></div>
                     </td>
                     <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>   
                 </tr>
                  
                  
                    
                  <? if($uploaded_designs < 15){?>    
                  <tr style=" <?=(count($files)>0)?'':'display:none;'?>" id="add_another_line">
                      <td colspan="4" class="text-center">
                            <div class="col-xs-12 col-sm-12 col-md-3  m0 p0"> 
                                <button class="btn btn-success add_another_art"> <i class="fa fa-plus"></i> Add another Line</button> 
                            </div>
                        </td>
                      <td>&nbsp;</td>
                      <td class="text-center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                    </tr>
                  <? } ?>
                  
                  <tr>
                      <td colspan="4" class="text-left" style="vertical-align:middle;">
                      </td>
                      <td colspan="3"  align="center" style="vertical-align:middle;" class="text-center">
                    		  <!--<p class="total_user_sheet"><?=$total_rolls?></p>-->
                          <? if($total_rolls > 0){?>
                              <?=$uploaded_designs?> <?=($uploaded_designs>1)?'Designs':'Design'?>, <?=number_format($total_labels)?> 
                              Labels on <?=$total_rolls?> <?=($total_rolls>1)?'Rolls':'Roll'?> 
                       	 <? } ?>
                       </td>
                       
                  </tr>
                  
                  </tbody>
                </table>
                
                
                
          
          <? if($uploaded_designs >= 15){?>


                     <div class="col-md-2">
                          <input  class="form-control additional_designs allownumeric" maxlength="5" placeholder="+1" type="number">
                          <div class="row" style="text-align:center;">
                               <a href="javascript:void(0);" style="display:none;"  class="clear_b additional_designs_updatebtn">
                                 <i class="fa fa-refresh"></i> Update 
                               </a> 
                          </div>
                     </div>
		<? } ?>
		
       <input type="hidden" id="actual_designs_qty" value="<?=$designs?>"  />
       <input type="hidden" id="actual_labels_qty" value="<?=$labels?>"  />
      
       <input type="hidden" id="upload_remaining_labels" value="<?=($labels-$total_labels)?>"  />
       <input type="hidden" id="upload_remaining_designs" value="<?=($designs-$uploaded_designs)?>"  />
       
       
       <input type="hidden" id="final_uploaded_rolls" value="<?=$total_rolls?>"  />
       <input type="hidden" id="final_uploaded_labels" value="<?=$total_labels?>"  />