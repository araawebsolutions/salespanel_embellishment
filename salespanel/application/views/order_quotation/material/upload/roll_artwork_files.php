<style>
	.fart{
		display: none;
	}
</style>
<?php
$cartid = $details['cartid'];
$ProductID = $details['ProductID'];

$files = $this->home_model->fetch_uploaded_artworks($cartid, $ProductID);
		
$ManufactureID = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $ProductID);
			
			
$total = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
$labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
$designs = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Qty', 'ID', $cartid);
$minroll = $this->home_model->min_qty_roll($ManufactureID);
$min_labels_per_roll = $this->home_model->min_labels_per_roll($minroll);

//$upload_path = ArtworkPath;
$upload_path = 'http://localhost/salespanel_new/theme/integrated_attach/';
$uploaded_designs = 0; 
?>
 
 <!--
<input type="hidden" value="<?/*=$LabelsPerSheet*/?>" id="labels_p_sheet"  />
<input type="hidden" value="<?/*=$cartid*/?>" id="cartid"  />
<input type="hidden" value="<?/*=$ProductID*/?>" id="cartproductid"  />-->
             
<table class="table table-striped" id="with_artwork_tbl" style=" <?=(count($files)> 0)?'display:none':''?>">
  <thead class=""> 
    <tr>
      <!--<th width="10%" class="text-center">Artwork to Follow</th>-->
      <th width="10%" class="text-center">Artworks</th>
      <th width="15%" class="text-center">File Name</th>
      <th width="15%" class="text-center">No. Labels</th>
      <th width="10%" class="text-center">Per roll</th>
      <th width="15%" class="text-center">Rolls</th>
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
					 
      <!--<td width="" class="text-center"> 
        <?php if($row->file!=""){ ?>
        <i class="fa fa-times" style="color:red"></i>
        <?php } ?>
																   
        <?php if($row->file=="") { ?>
        <i class="fa fa-check" style="color:green"></i>
        <?php  }?>
      </td>-->
			 
					 <td width="" class="text-center">
						 <img class="img-circle" src="<?=$upload_path.$row->file?>" width="30" height="">
					 </td>
					 <td width="">
						 <?=$row->name?>
					 </td>
					 <td width="">
						 <input data-toggle="popover" data-content="" class="form-control roll_labels_input allownumeric" 
                                 value="<?=$row->labels?>" placeholder="<?=$min_labels_per_roll*$minroll?>+" type="number" min="0">
					 </td>
					 <td width="" style="vertical-align:middle; text-align:center">
						 <small class="show_labels_per_roll"><?=$row->labels/$row->qty;?> </small>
					 </td>
					 
					
           
					 <td width="" class="text-center">
						 <input value="<?=$row->qty?>" class="form-control input-number text-center allownumeric  input_rolls" type="number" min="0">
					 </td>
					 <!--<td width="" style="vertical-align:middle; text-align:center">
						 <small><?=$diamter?> mm</small>
					 </td>-->
				  
					 <td width="" align="center" class="text-center">
						 <button style="display:none; padding: 8px;" data-value="roll" data-id="<?=$row->ID?>" title="Update artwork details" class="roll_updater  btn btn-danger">
							 <i class="fa fa-save"></i>
						 </button>
				  				  			  
						 <button data-value="roll" id="<?=$row->ID?>" title="Delete Artwork" class="delete_artwork_file  btn btn-success"  style="padding: 8px;background-color: red;">
							 <i class="fa f-10 fa-trash "></i>
						 </button>
					 </td>
				 </tr>
                    
           <? } 
			
				$remaingsheets = $labels-$total_labels;
			}
			
			?>
            
            
            
            
				 <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
					 
					 <!--<td width="" class="text-center">
						 <input type="checkbox" class="follow_arts" id="follow_art" name="follow_art" type="form-control"/>
					 </td>-->
					 
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
                            placeholder="Enter labels" type="number" min="0">
					 </td>
					 
					  
					 
					 <td  width="" style="vertical-align:middle; text-align:center">
						 <small class="show_labels_per_roll"></small>
					 </td>
					 
					 <td width="" class="text-center">
						 <input value="<?=$minroll?>" data-toggle="popover" data-content="" 
                        style="display:none;" class="form-control input-number text-center allownumeric input_rolls" type="number" min="0">
						 <label class="quantity_labels"><?=$minroll?></label>&nbsp;
						 <a href="javascript:void(0);" class="quantity_editor"><i class="fa fa-pencil"></i> Edit </a>
					 </td>
					 
					 <!--<td width="" style="vertical-align:middle; text-align:center">
						 <small>&nbsp;</small>
					 </td>-->
					 
					 <td width="" align="center">
						 <button data-value="roll" class=" btn btn-danger save_artwork_file_roll" style="padding: 8px;"> <i class="fa fa-save"></i></button>
						  
						 <button data-value="sheets" title="Delete Artwork" class="hide_another_art  btn btn-success"  style="padding: 8px;background-color: red;"><i class="fa f-10 fa-trash "></i>
						 </button>

					 </td>
				 </tr>
                  
    <tr id="upload_progress" style="display:none;">
      <td colspan="5">
        <div id="progressbar" class="col-md-11"></div>
      </td>
      <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>   
    </tr>
                  
                  
                    
    
    <tr style=" <?=(count($files)>0)?'':'display:none;'?>" id="add_another_line">
      <td colspan="4" class="text-center">
        <div class="col-xs-12 col-sm-12 col-md-3  m0 p0"> 
          <button class="btn btn-success add_another_art"> <i class="fa fa-plus"></i> Add another Line</button> 
        </div>
      </td>
      <td>&nbsp;</td>
      <td class="text-center">&nbsp;</td>
      
    </tr>
                  
    <tr>
      <td colspan="4" class="text-left" style="vertical-align:middle;"></td>
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
                          <input  class="form-control additional_designs allownumeric" maxlength="5" placeholder="+1" type="number" min="0">
                          <div class="row" style="text-align:center;">
                               <a href="javascript:void(0);" style="display:none;"  class="clear_b additional_designs_updatebtn">
                                 <i class="fa fa-refresh"></i> Update 
                               </a> 
                          </div>
                     </div>
		<? } ?>




<table class="table table-striped" id="no_img_artwork_tbl" style=" <?=(count($files)==0)?'display:none':''?>">
  <thead class="">
    <tr>
      <th width="15%" class="text-center">No of Designs</th>
      <th width="15%" class="text-center">No of Labels</th>
      
      <th width="15%" class="text-center">Per Roll</th>
      
      <th width="15%" class="text-center">Min Per Roll</th>
      <th width="15%" class="text-center">Max Per Roll</th>
      <th width="15%" class="text-center">No of Rolls</th>
      <!--<th width="18%" class="text-center">Artworks sheet</th>
      <th width="18%" class="text-center">Labels</th>--->
      <th width="15%" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>

    
    <tr class="upload_row custom_artwork" >
					 
      <td width="">
        <input class="form-control " min="0" id="no_design_pop" onchange="show_des_btn('this')"  placeholder="Enter No Designs" type="number">
      </td>
					 
					 <td  width="">
						 <input class="form-control roll_labels_input allownumeric" onchange="show_des_btn('this')" id="artwork_custom_lab" value="" data-toggle="popover" data-content=""  
                            placeholder="Enter labels" type="number" min="0">
					 </td>
					 
					 <td  width="" style="vertical-align:middle; text-align:center">
						 <small class="show_labels_per_roll"></small>
					 </td>
					 
					 <td align="center" ><span id="minrollid"></span></td>
                      <td align="center"><span id="maxrollid"></td>
                      
					 <td width="" class="text-center">
						  <input value="" id="no_of_roll_custom_art" onchange="show_des_btn('this') "; class="form-control input-number text-center allownumeric input_rolls" type="number" min="0">
					 </td>
					 
				
					 
					 <td width="" align="center">
						 <button data-value="no_design_btn_up" id="no_design_btn_up" class=" btn btn-success save_artwork_file_roll_custom" style="padding:5px;background-color: green; border: 1px solid green;"> <i class="fa fa-save"></i></button>
        
        <button id="del_design" title="Delete" onclick="deleteNo_design('<?=$ProductID?>',this);" class="btn btn-success"  style="padding: 5px;background-color: red; border: 1px solid red; "><i class="fa f-10 fa-trash "></i></button>

					 </td>
				 </tr>
	  
    <!--<tr>
      <td width="">
        <input class="form-control " id="no_design_pop" onchange="show_des_btn('this')"  placeholder="Enter No Designs" type="number">
      </td>
      
      <td width="">
        <input class="form-control " id="no_of_roll" onchange=""  placeholder="Enter No of Roll" type="number">
      </td>
     
      <td width="" align="center">
        <button data-value="no_design_btn_up" onclick="addNo_design('<?=$ProductID?>',this);" class=" btn btn-success" style="padding: 8px; display:none"> <i class="fa fa-save"></i></button>
        
        <button id="del_design" title="Delete" onclick="deleteNo_design('<?=$ProductID?>',this);" class="btn btn-success"  style="padding: 8px;background-color: gray; border: 1px solid gray; "><i class="fa f-10 fa-trash "></i></button>
      </td>
    </tr>-->
  </tbody>
</table>


<tr>
  <td colspan="6" class="text-left" style="vertical-align:middle;" >
    <div class="col-xs-12 col-sm-3 col-md-3 yes_art_btn m0 p0" style="display:inline">
      <button class="btn btn-success " onclick="show_with_artwork();"> <i class="fa fa-upload"></i> Upload Artwork</button>
    </div>
  </td>
  <div class="col-xs-12 col-sm-3 col-md-3 no_art_btn m0 p0" style="display:inline">
    <button class="btn btn-danger " onclick="show_no_artwork();"> <i class="fa fa-plus"></i> Artwork to Follow</button>
  </div>
</tr>
		
<input type="hidden" id="actual_designs_qty" value="<?=$designs?>"  />
<input type="hidden" id="actual_labels_qty" value="<?=$labels?>"  />
      
<input type="hidden" id="upload_remaining_labels" value="<?=((int)$labels-(int)$total_labels)?>"  />
<input type="hidden" id="upload_remaining_designs" value="<?=((int)$designs-(int)$uploaded_designs)?>"  />
       
       
<input type="hidden" id="final_uploaded_rolls" value="<?=$total_rolls?>"  />
<input type="hidden" id="final_uploaded_labels" value="<?=$total_labels?>"  />





<script type="text/javascript">

  
//$(document).ready(function(){
  
  var pro_id = '<?=$ProductID?>';
  var no_design = $('#no_artworks_'+pro_id).val();
  var uploadDesign = $('#uploadedartworks_'+pro_id).val();
  var num_roll = $('#custom_qty_roll_'+pro_id).val();
  
  var maxroll= $('.LabelsPerSheet').val();
  var dieacross = $('.minimum_quantities').val();
  var labels= $('#artwork_custom_lab').val();
  var no_of_roll= $('#no_of_roll_custom_art').val();
  
//});
 
  $('#with_artwork_tbl').hide();
  $('#no_img_artwork_tbl').hide();
  
  
 
  
  
  var per_roll = labels/no_of_roll;
  var tot_label= per_roll * no_of_roll;

  if(dieacross == 0 ||dieacross == ''){
    var minroll = 0;
  }else{ 
    var minroll= Math.ceil(100/dieacross);
  }
  

 
  
  $('#maxrollid').text(maxroll);
  $('#minrollid').text(minroll);
  $('#artwork_custom_lab').text(tot_label);
  
  $('#del_design').hide();
  $('#no_design_btn_up').hide();
  
  
  //alert(no_design+' '+uploadDesign);
  
  if(no_design > 0 && uploadDesign ==0){
    //alert('manual');
    $('#no_design_pop').val(no_design);
    $('#no_of_roll_custom_art').val(num_roll);
    
    $('#del_design').show();
    show_no_artwork();
    $('.show_labels_per_roll').html(per_roll);
  }
  
  if(no_design == 0 && uploadDesign > 0){
    //alert('upload art work');
    show_with_artwork();
  }
  
    if(no_design == 0 && uploadDesign == 0){
      $('#with_artwork_tbl').hide();
      $('#no_img_artwork_tbl').hide();
      //alert('else');
    }
  
    
  //alert('sds');
//});
</script>