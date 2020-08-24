<?php	
		$cartid = $details['cartid'];
		$ProductID = $details['ProductID'];
		
		
		$files = $this->home_model->fetch_uploaded_artworks($cartid, $ProductID);
		
		$total = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
		$labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
		
		
		$designs = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Qty', 'ID', $cartid);
		$minroll = $this->home_model->min_qty_roll($details['ManufactureID']);
		$min_labels_per_roll = $this->home_model->min_labels_per_roll($minroll);
		
		
		$upload_path = base_url().'theme/integrated_attach/';
		
		$uploaded_designs = 0; ?>

<table class="table table-striped">
  <thead class="">
    <tr>
      <td>Artworks</td>
      <td>File Name</td>
      <td>No. Labels</td>
      <td>Labels per roll</td>
      <td class="text-center">Rolls</td>
      <td align="center">Action</td>
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
						 
						  if(preg_match("/.pdf/is",$row->file)){
								  	 	  $artworkpath = AJAXURL.'theme/site/images/pdf.png';
								
								   }
								   else if(preg_match("/.doc/is",$row->file) || preg_match("/.docx/is",$row->file)){
								  	 	   $artworkpath = AJAXURL.'theme/site/images/doc.png';
									
								   }else{
								  		  $artworkpath = $upload_path.$row->file;
									
								   }
								   
			 ?>
    <tr class="upload_row">
      <td width="10%" class="text-center"><img onerror='imgError(this);' class="img-circle" src="<?=$artworkpath?>" width="20" height="" alt="<?=$row->name?>"></td>
      <td width="26%"><?=$row->name?></td>
      <td width="16%"><input data-toggle="popover" data-content="" class="form-control roll_labels_input allownumeric" 
                                 value="<?=$row->labels?>" placeholder="<?=$min_labels_per_roll*$minroll?>+" type="text"></td>
      <td width="16%" style="vertical-align:middle; text-align:center"><small class="show_labels_per_roll">
        <?=$row->labels/$row->qty?>
        </small></td>
      <td width="16%" class="text-center"><input value="<?=$row->qty?>" class="form-control input-number text-center allownumeric  input_rolls" type="text">
        
        <!-- <div class="col-xs-12 col-sm-12 col-md-12 p0">
                      	<div class="row" style="vertical-align:middle; text-align:center;"> 
                           <a data-id="<?=$row->ID?>" data-value="roll" href="javascript:void(0);" style="display:none;" 
                           class="clear_b roll_updater"><i class="fa fa-refresh"></i> Update </a>
                       </div>
                      	
                     </div>--></td>
      <td width="38%" align="center" class="text-center"><button style="display:none;" data-value="roll" data-id="<?=$row->ID?>" title="Update artwork details" class="roll_updater  btn btn-success" > <i class="fa f-10 fa-save "></i> </button>
        <button data-value="roll" id="<?=$row->ID?>" title="Delete Artwork" class="delete_artwork_file  btn btn-danger" > <i class="fa f-10 fa-trash "></i> </button></td>
    </tr>
    <? } 
			
				$remaingsheets = $labels-$total_labels;
			}
			
			//$expected_labels = $remaingsheets*$details['LabelsPerSheet'];
			//$expected_labels =($expected_labels>0)?$expected_labels:'';
			
			
			?>
    <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
      <td width="10%" class="text-center"><img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" />
        <input type="file" name="artwork_file" class="artwork_file"  style="display:none;"  />
        <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button></td>
      <td  width="30%"><input class="form-control artwork_name" placeholder="Artwork Name" type="text"></td>
      <td  width="28%"><input class="form-control roll_labels_input allownumeric" value="" data-toggle="popover" data-content=""  
                            placeholder="Enter labels" type="text">
        
        <!--<div class="row" style="vertical-align:middle; text-align:center;"> 
                          	<a href="javascript:void(0);" style="display:none;" class="quantity_updater"><i class="fa fa-refresh"></i> Update </a>
                       	  </div>--></td>
      <td  width="10%" style="vertical-align:middle; text-align:center"><small class="show_labels_per_roll"></small></td>
      <td width="28%" class="text-center"><input value="<?=$minroll?>" data-toggle="popover" data-content="" 
                        style="display:none;" class="form-control input-number text-center allownumeric input_rolls" type="text">
        <label class="quantity_labels">
          <?=$minroll?>
        </label>
        &nbsp; <a href="javascript:void(0);" class="quantity_editor"><i class="fa fa-pencil"></i> Edit </a></td>
      <td width="28%" align="center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
          <button data-value="roll" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Save</button>
        </div></td>
    </tr>
    <tr id="upload_progress" style="display:none;">
      <td colspan="5"><div id="progressbar" class="col-md-11"></div></td>
      <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
    </tr>
    <? if($uploaded_designs < 15){?>
    <tr style=" <?=(count($files)>0)?'':'display:none;'?>" id="add_another_line">
      <td colspan="3" class="text-center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
          <button class="btn btn-success add_another_art"> <i class="fa fa-plus"></i> Add another Line</button>
        </div></td>
      <td>&nbsp;</td>
      <td class="text-center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <? } ?>
    <tr>
      <td colspan="3" class="text-left" style="vertical-align:middle;"> You have <b class="remaing_user_sheets">
        <?=$labels-$total_labels?>
        </b> labels remaining </td>
      <td colspan="3"  align="center" style="vertical-align:middle;" class="text-center"><!--<p class="total_user_sheet"><?=$total_rolls?></p>-->
        
        <? if($total_rolls > 0){?>
        <?=$uploaded_designs?>
        <?=($uploaded_designs>1)?'Designs':'Design'?>
        ,
        <?=number_format($total_labels)?>
        Labels on
        <?=$total_rolls?>
        <?=($total_rolls>1)?'Rolls':'Roll'?>
        <? } ?></td>
    </tr>
    <tr style="background:none;">
      <td colspan="6"><p>In order to upload your artwork you must complete the line e.g. File name and the number of labels required. Upon which the file will be uploaded.</p></td>
    </tr>
  </tbody>
</table>
<? if($uploaded_designs >= 15){?>
<div class="col-md-12" style="">
  <div class="col-md-10">
    <h5><i class="fa fa-info-circle" aria-hidden="true"></i> Upload Limit Exceeded </h5>
    <p>If you have additional artworks that you would like to have printed with this order 
      please enter the number and our customer care team will contact you.</p>
  </div>
  <div class="col-md-2">
    <input  class="form-control additional_designs allownumeric" maxlength="5" placeholder="+1" type="text">
    <div class="row" style="text-align:center;"> <a href="javascript:void(0);" style="display:none;"  class="clear_b additional_designs_updatebtn"> <i class="fa fa-refresh"></i> Update </a> </div>
  </div>
</div>
<? } ?>
<input type="hidden" id="actual_designs_qty" value="<?=$designs?>"  />
<input type="hidden" id="actual_labels_qty" value="<?=$labels?>"  />
<input type="hidden" id="upload_remaining_labels" value="<?=($labels-$total_labels)?>"  />
<input type="hidden" id="upload_remaining_designs" value="<?=($designs-$uploaded_designs)?>"  />
<input type="hidden" id="final_uploaded_rolls" value="<?=$total_rolls?>"  />
<input type="hidden" id="final_uploaded_labels" value="<?=$total_labels?>"  />
