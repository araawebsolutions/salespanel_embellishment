<style>
	.fart{
		display: none;
	}
</style>
<?php //echo '<pre>'; print_r($data['artworks']); echo '<pre>'; 
      $totalCount = count($data['artworks']);

        
?>
<input type="hidden" id="getArtworkWithPic" value="<?=$totalCount?>">

<div class="ovFl table-responsive">
  
   
  
  <div id="with_artwork_tbl" style=" <?=($totalCount==0)?'display:none':''?>">
  <div id="ajax_upload_content">
    <input type="hidden" value="" id="cartid<?= $data['serialNumber'] ?>">
    <table class="table table-striped" style="width:100%">
      <thead class="">
        <input type="hidden" id="arworklineCounter" value="50000">
        <tr>
         
          <td width="21%" align="center">Artworks</td>
          <td width="15%" align="center">File Name</td>
          <td width="15%" align="center">Sheet</td>
          <td width="10%" class="text-center" >Labels</td>
          <td width="20%" align="center">Action</td>
        </tr>
      </thead>
      <tbody id="myBody">
       
        
        <?php foreach ($data['artworks'] as $key => $artwork) { ?>
	
        <tr class="upload_row " style=" " id="tr_id<?= $key ?>">
					
					
          <!--<td width="" class="text-center">
						
            <?php if($artwork->file!=""){ ?>
            <i class="fa fa-times" style="color:red"></i>
            <?php } ?>
																   
            <?php if($artwork->file=="") { ?>
            <i class="fa fa-check" style="color:green"></i>
            <?php  }?>
          </td>-->
					
          <td width="" align="center">
						
            <?php if($artwork->file!=""){ ?>
            <div class="thumb-sm">
			 				<input type="hidden" class="key_class" value="<?= $key ?>">



              <img src="<?php echo aalables_path_material ?>integrated_attach/<?= $artwork->file ?>"
                                 class="round-circle img-thumbnails" alt="image">
							
							
							
              <!--<input type="file" id="artworkimage<?/*= $key */ ?>" name="file" class="artwork_file">-->
            </div>
            <?php }?>
              <?php
                $dh=0; $ca=0; $pu=0; $mt=0; $cm=0; $fc=0; $jr=0; $mr=0; $dp=0; $sh=0; $mp=0; $hp=0;
              ?>
            
						
          </td>
          <td width="" class="text-center">
            <input class="form-control artwork_name" id="at_name<?= $key ?>"
                   placeholder="Enter Artwork Name" type="text" value="<?= $artwork->name ?>">
          </td>

          <td width="" class="text-center" >
            <input class="form-control labels_input allownumeric"
                   onchange="changeSheetLbl(<?= $key ?>,this)" id="at_roll<?= $key ?>"
                   placeholder="Enter Sheets" value="<?= $artwork->qty ?>" type="number" min="0"></td>

          <td width="10%" align="center" style="vertical-align:middle;" id="at_label<?= $key ?>"
              class="text-center ">&nbsp<?= $artwork->labels ?></td>
          <td width="15%" class="text-center">
              
            <input type="hidden" id="artwork_id<?= $key ?>" value="<?= $artwork->ID ?>">
            <button data-value="sheets" id="updp_btn<?= $key ?>" class=" btn btn-danger  "
                    onclick="updateMyArtwork(<?= $key ?>,this,<?=$artwork->ID?>,'<?= $data['page'] ?>','update')"
                    style="padding: 8px; display:none">
              <i class="fa fa-save"></i>
            </button>
            <button data-value="sheets" class=" btn btn-success  save_artwork_file"
                    onclick="deleteMyArtwork(<?= $key ?>,<?=$artwork->ID ?>,<?= (isset($artwork->Serial)) ? $artwork->Serial : '' ?>)"
                    style="padding: 8px;background-color: red;"><i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
        <?php }
            ?>

        <input type="hidden" id="product_id" value="<?= $data['productId'] ?>">
        <input type="hidden" id="serialNumber" value="<?= $data['serialNumber'] ?>">
        <input type="hidden" id="orderNumber" value="<?= $data['orderNumber'] ?>">
        <input type="hidden" id="manfactureId" value="<?= $data['manfactureId'] ?>">
        <input type="hidden" id="brand" value="<?= $data['brand'] ?>">
        <input type="hidden" id="minrolls" value="<?= $data['cal']['minRoll'] ?>">
        <input type="hidden" id="maxrolls" value="<?= $data['cal']['maxRoll'] ?>">
        <input type="hidden" id="minlabels" value="<?= $data['cal']['minLabels'] ?>">
        <input type="hidden" id="maxlables" value="<?= $data['cal']['maxLabels'] ?>">
        <input type="hidden" id="lblPerSheet" value="<?= $data['cal']['labelPerSheet'] ?>">
        <input type="hidden" id="checkoutArtwork" value="<?= $data['checkoutArtwork'] ?>">
        <input type="hidden" id="checkouttr" value="<?= (isset($data['checkouttr'])) ? $data['checkouttr'] : '' ?>">
        <input type="hidden" id="original_price" value="">
        <input type="hidden" id="page" value="<?= $data['page'] ?>">
        <input type="hidden" id="rowKey" value="<?= $data['rowKey'] ?>">

      </tbody>


    </table>

    <table class="m-t-t-10">
            <tr>
                <td width="70%" colspan="4" align="left">
                    <button id="show-at-nw" class="btn btn-success add_another_art" onclick="newSheetArtworkLine()"> +
                        Add New Line
                    </button>
                    <button type="button" id="show-at-hs" onclick="getOldArtwork()"
                            class="btn btn-danger waves-light waves-effect">+ Add Artwork From History
                    </button>
                    <button type="button" id="hide-at-hs" onclick="hideOldArtwork()" style="display:none"
                            class="btn btn-danger waves-light waves-effect">- Hide Artwork From History
                    </button>
                </td>
                <td width="25%" colspan="2" align="right" id="artwork_count_status"></td>
            </tr>

        </table>

    </div>
   </div>
  
  <div id="no_img_artwork_tbl" style="<?=($totalCount > 0)?'display:none':''?>">
  
    <table class="table table-striped"  style=" ">
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
            <input class="form-control " id="no_design_pop" onchange="show_des_btn('this')"  placeholder="Enter No Designs"   type="number" min="0">
          </td>
          <td width="">
            <input class="form-control allownumeric ints" id="no_sheet_pop" onchange="show_des_btn('this')"  placeholder="Enter No Sheets" value=""  type="number" min="0">
          </td>
          <!--<td width="" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp;</td>-->
          <td width="" align="center">
            
            <button id="no_design_btn_up" data-value="no_design_btn_up" onclick="addNo_design_cart('<?= $data['rowKey'] ?>','<?=$data['productId'] ?>',this);" class=" btn btn-danger" style="padding: 8px;"> <i class="fa fa-save"></i></button>
        
            <button id="del_design" title="Delete" onclick="delete_old_artwork_cart_page('<?= $data['productId'] ?>','re');" class="btn btn-success"  style="padding: 8px;background-color: red; "><i class="fa f-10 fa-trash "></i></button>
            
          </td>
        </tr>
           
      </tbody>
    </table>
  </div>
  
  

  
  <table class="m-t-t-10">
    <tr>
      <td width="70%" colspan="6" align="left">
        <button class="btn btn-success yes_art_btn orangeBg" onclick="show_with_artwork();" style="margin-top:0">    <i class="fa fa-Upload"></i> Upload Artwork</button>
        <button class="btn btn-warning no_art_btn orangeBg"  onclick="show_no_artwork();" style="margin-top:0">      <i class="fa fa-plus"></i>   Artwork to Follow</button>        
      </td>
    </tr>
    
  </table>

  
  
  
  
</div>

<script type="text/javascript">
//$(document).ready(function(){
  hideOldArtwork();
  var rowKeys = $('#rowKey').val();
  var no_design = parseInt($('#design'+rowKeys).val());
  var exits_design = parseInt($('#no_design_pop').val());
  var uploadDesign = parseInt($('#getArtworkWithPic').val());
  var no_sheet_pop = parseInt($('#qty'+rowKeys).val());
 
  if($.isNumeric(exits_design)==false || $.isNumeric(no_design)==false){
    $('#with_artwork_tbl').hide();
    $('#no_img_artwork_tbl').hide();
  }
  $('#no_design_btn_up').hide();
           
  if(typeof exits_design.isNaN == 'undefined' ||  $.isNumeric(exits_design) ==false ){
    exits_design = 0;
  }
  
   
  if((no_design > 0 && uploadDesign ==0)){
    hideOldArtwork();
    show_no_artwork();
    $('#no_design_pop').val(no_design);
    $('#no_sheet_pop').val(no_sheet_pop);
    $('#del_design').show();
  }
        
  if(exits_design == 0 && uploadDesign > 0){
    $('#del_design').hide();
    show_with_artwork();
  }
  
  if(exits_design == 0 && uploadDesign == 0 && no_design == 0){
    $('#del_design').hide();
    $('#with_artwork_tbl').hide();
    $('#no_img_artwork_tbl').hide();
  }
//});
</script>
