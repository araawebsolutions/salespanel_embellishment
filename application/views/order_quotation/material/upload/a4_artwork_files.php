
<style>
	.fart{
		display: none;
	}
</style>
<?php

		$files = $this->home_model->fetch_uploaded_artworks($cartid, $ProductID);
		$total = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
		$designs = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Qty', 'ID', $cartid);
		
		//$upload_path = base_liveaa.'theme/integrated_attach/';
    	$upload_path = base_url().'theme/assets/images/artworks/';  

		$sheets_text  = ($unitqty=='Labels')?'Labels':'Sheets';
		$labels_text = ($unitqty=='Labels')?'Sheets':'Labels';
	
		$multiplyfactor = ($unitqty=='Labels')?$LabelsPerSheet:1;
		$dividefactor   = ($unitqty=='Labels')?1:$LabelsPerSheet;
		
?>

<input type="hidden" value="<?=$LabelsPerSheet?>" id="labels_p_sheet"  />
<input type="hidden" value="<?=$unitqty?>" id="cartunitqty"  />
<input type="hidden" value="<?=$cartid?>" id="cartid"  />
<input type="hidden" value="<?=$ProductID?>" id="cartproductid"  />




<table class="table table-striped" id="with_artwork_tbl" style=" <?=(count($files)> 0)?'display:none':''?>">
  <thead class="">
    <tr>
      <!--<th width="15%" class="text-center">Artwork to Follow</th>-->
      <th width="18%" class="text-center">Artworks sheet</th>
      <th width="15%" class="text-center">File Name</th>
      <th width="15%" class="text-center"><?=$sheets_text?></th>
      <th width="10%" class="text-center"><?=$labels_text?></th>
      <th width="15%" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?
	$remaingsheets = $total;
	   $total_labels  = '';
	   $total_sheets  = '';
	   $uploaded_designs = 0;		
	   if(count($files) > 0){
				
		   $total_labels = 0;
		   $total_sheets = 0;
		   foreach($files as $row){
							
			   $total_labels+= $row->labels;
			   $total_sheets+=$row->qty;
			   $uploaded_designs++;
							 
			   if(preg_match("/.pdf/is",$row->file)){
				   $artworkpath = aalables_path_material.'theme/site/images/pdf.png';
			   }
			   else if(preg_match("/.doc/is",$row->file) || preg_match("/.docx/is",$row->file)){
				   $artworkpath = aalables_path_material.'theme/site/images/doc.png';
			   }else{
				   $artworkpath = aalables_path_material.'integrated_attach/'.$row->file;
			   }
							 
	  ?>
	  <tr class="upload_row">
		  <!--<td width="" class="text-center"> 
			  <?php if($row->file!=""){ ?>
			  <i class="fa fa-times" style="color:red"></i>
			  <?php } ?>
																   
			  <?php if($row->file=="") { ?>
			  <i class="fa fa-check" style="color:green"></i>
			  <?php  } ?> 
		  </td>-->
		  
		  <td width="" class="text-center"><img class="img-circle" src="<?=$artworkpath?>" width="20" height=""></td>
		  <td width="" class="text-center"><?=$row->name?></td>
		  <td width="" class="text-center">
      <input type="number" data-placement="top" data-toggle="popover" data-content="" value="<?=($unitqty=='Labels')?$row->labels:$row->qty?>" 
                            class="form-control labels_input allownumeric" min="0"  /></td>
		  <td width=""  class="text-center" style="vertical-align:middle;" class="text-center displaysheets"><?=($unitqty=='Sheets')?$row->labels:$row->qty?></td>
		  <td width="" class="text-center" class="text-center" >
				
			  <button style="display:none; padding:8px;" data-id="<?=$row->ID?>" title="Update artwork details" class="sheet_updater  btn btn-danger" > <i class="fa f-10 fa-save "></i> </button>
				
			  <button data-value="sheets" id="<?=$row->ID?>" title="Delete Artwork" class="delete_artwork_file  btn btn-danger" style="padding: 8px;background-color: red;" > <i class="fa f-10 fa-trash "></i> </button></td>
	  </tr>
    <? } 
		   $remaingsheets = $total-$total_sheets;
	   }
	   $expected_labels = ((int)$remaingsheets*(int)$LabelsPerSheet);
	   $expected_labels =($expected_labels>0)?$expected_labels:'';
	  ?>
	  
	  <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
		  <!--<td width="" class="text-center">
			  <input type="checkbox" class="follow_arts" id="follow_art" name="follow_art" type="form-control"/>
		  </td>-->
		  
		  <td width="" class="text-center">
			  
			  <img width="20" class="img-circle preview_po_img"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" />
			  <p style="color:green" class="fart Artworkfollow" id="Artworkfollow">Artwork to Follow</p>
			  <div class="upload-btn-wrapper">
				  <button class="btn artwork_upload_cta "> <i class="fa fa-cloud-upload"></i> Browse File</button>
				  <input type="file" name="artwork_file" class="artwork_file"  />
			  </div>
		  </td>
		  
		  <td width=""><input class="form-control artwork_name"  placeholder="Enter Artwork Name" type="text"></td>
		  <td width=""><input class="form-control labels_input allownumeric ints"  
                            placeholder="Enter <?=$sheets_text?>" value=""  type="number" min="0"></td>
		  <td width="" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp;</td>
		  <td width="" align="center">
			  <button data-value="sheets" class=" btn btn-danger save_artwork_file" style="padding: 8px;"> <i class="fa fa-save"></i></button>
			 
			  
			  <button data-value="sheets" title="Delete Artwork" class="hide_another_art  btn btn-success"  style="padding: 8px;background-color: red;">
                        <i class="fa f-10 fa-trash "></i>
                  </button>
		  </td>
	  </tr>
	  
	  <tr id="upload_progress" style="">
		  <td colspan="4">
      <div id="progressbar" class="col-md-11"></div>
     </td>
		  <td>
      <label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label>
     </td>
	  </tr>
	  <? if($uploaded_designs < 10){?>
	 <tr style=" <?=(count($files)>0)?'':'display:none;'?>" id="add_another_line">
		  <td colspan="4" class="text-left" style="vertical-align:middle;" ><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
			  <button class="btn btn-success add_another_art"> <i class="fa fa-plus"></i> Add another Line</button>
			  </div>
		  </td>
		  <td class="text-center" style="vertical-align:middle; text-align:center;">&nbsp;</td>
		 
	  </tr>
    <?} ?>
    <tr>
      <td width="40%" colspan="2" class="text-left" style="vertical-align:middle;"></td>
      <td width="30%" class="text-center" style="vertical-align:middle; text-align:left;">
        <p class="total_user_sheet">
          <?=((int)$total_sheets*(int)$multiplyfactor)?>
        </p>
      </td>
      <td  align="center" style="vertical-align:middle;" class="text-center"><p class="total_user_labels">
          <?=((int)$total_labels/(int)$multiplyfactor)?>
        </p>
      </td>
       <td class="text-center" style="vertical-align:middle; text-align:center;">&nbsp;</td>
      
    </tr>
  </tbody>
</table>


<table class="table table-striped" id="no_img_artwork_tbl" style=" <?=(count($files)==0)?'display:none':''?>">
  <thead class="">
    <tr>
      <th width="15%" class="text-center">No Of Designs</th>
      <th width="18%" class="text-center">Artworks sheet</th>
      <!--<th width="18%" class="text-center">Labels</th>--->
      <th width="15%" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>

	  
    <tr>
      <td width="">
        <input class="form-control " min="0" id="no_design_pop" onchange="show_des_btn('this')"  placeholder="Enter No Designs" type="number">
      </td>
      <td width="">
        <input class="form-control" id="no_of_sheets" onchange="show_des_btn('this')" placeholder="Enter Sheets" value=""  type="number" min="0">
      </td>
      <!--<td width="" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp;</td>-->
      <td width="" align="center">
        <button data-value="no_design_btn_up" id="no_design_btn_up" onclick="addNo_design('<?=$ProductID?>',this);" class=" btn btn-danger" style="padding: 8px;"> <i class="fa fa-save"></i></button>
        
        <button id="del_design" title="Delete" onclick="deleteNo_design('<?=$ProductID?>',this);" class="btn btn-success"  style="padding: 8px;background-color: red; "><i class="fa f-10 fa-trash "></i></button>
      </td>
    </tr>
  </tbody>
</table>


 <tr>
   <td colspan="6" class="text-left" style="vertical-align:middle;" >
     <div class="col-xs-12 col-sm-3 col-md-3 yes_art_btn m0 p0" style="display:inline">
       <button class="btn btn-success " onclick="show_with_artwork();"> <i class="fa fa-plus"></i> Upload Artwork</button>
     </div>
		  </td>
		  <div class="col-xs-12 col-sm-3 col-md-3 no_art_btn m0 p0" style="display:inline">
       <button class="btn btn-danger " onclick="show_no_artwork();"> <i class="fa fa-plus"></i> Add Artwork to Follow</button>
     </div>
	 </tr>




<? if($uploaded_designs >= 10){?>
  <div class="col-md-2">
    <input  class="form-control additional_designs allownumeric" maxlength="5" placeholder="+1" type="number" min="0">
    <div class="row" style="text-align:center;"> <a href="javascript:void(0);" style="display:none;"  class="clear_b additional_designs_updatebtn"> <i class="fa fa-refresh"></i> Update </a> </div>

</div>
<? } ?>










<input type="hidden" id="actual_designs_qty" value="<?=$designs?>"  />
<input type="hidden" id="upload_remaining_designs" value="<?=((int)$designs-(int)$uploaded_designs)?>"  />
<input type="hidden" id="upload_remaining_labels" value="<?=((int)$remaingsheets*(int)$LabelsPerSheet)?>"  />
<input type="hidden" id="actual_sheets" value="<?=$total?>"  />
<input type="hidden" id="uploaded_sheets" value="<?=$total_sheets?>"  />

<tr style="background:none;">
  <td colspan="5">
    <p style="height:250px; margin-top:1rem">In order to upload your artwork you must complete the line e.g. File name and the number of sheets required. Upon which the file will be uploaded.</p>
  </td>
</tr>



<script type="text/javascript">
$(document).ready(function(){
  
  var pro_id = '<?=$ProductID?>';
  var no_design = $('#no_artworks_'+pro_id).val();
  var uploadDesign = $('#uploadedartworks_'+pro_id).val();
  var Sheets = $("[data-value="+pro_id+"]").find('.printedsheet_input').val();
  
  var integr = $('#newcategory').val();
  if(integr=='Integrated'){
    Sheets = $("#tab_printed"+pro_id).find('.box_size').val();
  }
  
  
  $('#no_of_sheets').val(Sheets);
  //$("[data-value='no_design_btn_up']").hide();
  
  $('#del_design').hide();
  $('#no_design_btn_up').hide();
  
  if(no_design > 0 && uploadDesign ==0){
    //alert('manual');
    $('#no_design_pop').val(no_design);
    $('#del_design').show();
    
    
    show_no_artwork();
  }
  
  if(no_design == 0 && uploadDesign > 0){
    show_with_artwork();
  }
  
  if(no_design == 0 && uploadDesign == 0){
    $('#with_artwork_tbl').hide();
    $('#no_img_artwork_tbl').hide();
  }

});
</script>