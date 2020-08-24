<style>
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
		top: 0;
        opacity: 0;
	}
	.fart{
		display: none;
	}
</style>
<?php //echo '<pre>'; print_r($data['artworks']); echo '<pre>'; 
      $totalCount = count($data['artworks']);

        
?>
<input type="hidden" id="getArtworkWithPic" value="<?=$totalCount?>">


<div class="ovFl table-responsive">
  
	<div id="ajax_upload_content">
   <input type="hidden" value="<?= $data['cartId'] ?>" id="cartid<?= $data['serialNumber'] ?>">
   
   <div id="with_artwork_tbl" style=" ">
   
		
   
     <table class="table table-striped" style="width: 100%;">
       <thead class="">
         <input type="hidden" id="arworklineCounter" value="">
         <tr>
           <td width="21%" align="center">Artworks</td>
           <td width="12%" align="center">File Name</td>
           <td width="12%" align="center">No.Labels</td>
           <td width="12%" align="center">Rolls</td>
           <td width="15%" align="center">Label Per Roll</td>
           <td width="15%" align="center">Action</td>
         </tr>
       </thead>
       <tbody id="myBody">
         <?php foreach ($data['artworks'] as $key => $artwork) { ?>

         <tr class="upload_row uploadsavesection" style=" " id="tr_id<?= $key ?>"> 
					
				
					
					
           <td width="" class="text-center">
             <?php if($artwork->file!=""){?>
             <div class="thumb-sm member-thumb m-b-10 mx-auto">
               <img src="<?php echo aalables_path_material ?>integrated_attach/<?= $artwork->file ?>" class="round-circle img-thumbnails" alt="image">
               <!-- <input type="file" id="artworkimage<?/*= $key */ ?>" name="file" class="artwork_file">-->
             </div>
             <?php } else{?>
             <p style="color:green">Artwork to Follow</p>
             <?php } ?>
           </td>
					
           <td width="" class="text-center">
             <input class="form-control artwork_name" id="at_name<?= $key ?>" placeholder="Enter Artwork Name" type="text" value="<?= $artwork->name ?>">
           </td>
					
           <td width="" class=" displaysheets text-center">
             <input class="form-control artwork_name" onchange="show_updt_btn(<?= $key ?>)" id="at_label<?= $key ?>" placeholder="Enter Artwork Name" type="text" value="<?= $artwork->labels ?>">
           </td>
					
           <td width="" class="text-center">
             <input class="form-control labels_input allownumeric" onchange="show_updt_btn(<?= $key ?>)" id="at_roll<?= $key ?>" placeholder="Enter Sheets" value="<?= $artwork->qty ?>" type="number" min="0">
             <input id="old_roll<?= $key ?>" value="0" type="hidden" >
           </td>
           <td width="" class="text-center" id="lbl_per_roll<?= $key ?>"><?= ceil($artwork->labels / $artwork->qty) ?></td>

           <td width="" align="center">
             <div>
               
               <input type="hidden" class="key_class" value="<?= $key ?>">
               <input type="hidden" class="artwork_id_class" id="artwork_id<?= $key ?>" value="<?= $artwork->ID ?>">

               <button data-value="sheets" id="updp_btn<?= $key ?>" class=" btn btn-danger "
                       onclick="updateMyArtwork(<?= $key ?>,this,<?= $artwork->ID ?>,'<?= $data['page'] ?>','update')"
                       style="padding: 8px;display: none">
                 <i class="fa fa-save"></i>
               </button>

               <button data-value="sheets" class=" btn btn-success  save_artwork_file"
                       onclick="deleteMyArtwork(<?= $key ?>,<?= $artwork->ID ?>,<?= (isset($artwork->Serial)) ? $artwork->Serial : '' ?>)" style="padding: 8px;background-color: red;"><i class="fa fa-trash"></i>
               </button>
             </div>
           </td>
         </tr>


            <?php }
            $totalCount = (count($data['artworks'])) + 1; ?>

            <input type="hidden" id="product_id" value="<?=$data['productId'] ?>">
            <input type="hidden" id="serialNumber" value="<?=$data['serialNumber'] ?>">
            <input type="hidden" id="orderNumber" value="<?=$data['orderNumber'] ?>">
            <input type="hidden" id="manfactureId" value="<?=$data['manfactureId'] ?>">
            <input type="hidden" id="price<?=$data['serialNumber'] ?>">
            <input type="hidden" id="brand" value="<?=$data['brand'] ?>">
            <input type="hidden" id="minrolls" value="<?=$data['cal']['minRoll'] ?>">
            <input type="hidden" id="maxrolls" value="<?=$data['cal']['maxRoll'] ?>">
            <input type="hidden" id="minlabels" value="<?=$data['cal']['minLabels'] ?>">
            <input type="hidden" id="maxlables" value="<?=$data['cal']['maxLabels'] ?>">
            <input type="hidden" id="lblPerSheet" value="<?=$data['cal']['labelPerSheet'] ?>">
            <input type="hidden" id="checkoutArtwork" value="<?= $data['checkoutArtwork'] ?>">
            <input type="hidden" id="checkouttr" value="<?=(isset($data['checkouttr'])) ? $data['checkouttr'] : '' ?>">
            <input type="hidden" id="original_price" value="">
            <input type="hidden" id="page" value="<?=$data['page'] ?>">
            <input type="hidden" id="rowKey" value="<?=$data['rowKey'] ?>">
       </tbody>
     </table>
     <table>
       <tr>
         <td colspan="4" align="left">
           <button id="show-at-nw" class="btn btn-success add_another_art" onclick="newRollArtworkLine()"> +
             Add New Line
           </button>
           <button type="button" id="show-at-hs" onclick="getOldArtwork()"
                   class="btn btn-danger waves-light waves-effect">+ Add Artwork From History
           </button>
           <button type="button" id="hide-at-hs" onclick="hideOldArtwork()" style="display:none"
                   class="btn btn-danger waves-light waves-effect">- Hide Artwork From History
           </button>
         </td>
         <td colspan="2" align="right" id="artwork_count_status"></td>
       </tr>
     </table>
   </div>
      
   <table class="table table-striped" style="width: 100%;" id="no_img_artwork_tbl" style="<?=($totalCount > 0)?'display:none':''?>">
     <thead class="">
       <input type="hidden" id="arworklineCounter" value="2001">
       <tr>
         <td width="12%" align="center">No of Design</td>
         <td width="12%" align="center">No.Labels</td>
         <td width="12%" align="center">Rolls</td>
         <td width="15%" align="center">Label Per Roll</td>
         <th width="15%" class="text-center">Min label Per Roll</th>
         <th width="15%" class="text-center">Max label Per Roll</th>
         <td width="15%" align="center">Action</td>
       </tr>
     </thead>
     <tbody id="myBody">

       <tr class="upload_row uploadsavesection" id="tr_id2001">
  
         <td width="">
           <input class="form-control artwork_name" id="nodesign2001" onchange="show_custom_design_btn(2001)" placeholder="Enter No of  design" type="text">
         </td>
         <td width="">
           <input class="form-control labels_input allownumeric" id="at_label2001" onchange="show_custom_design_btn(2001)" placeholder="Enter Label" value="" type="number" min="0">
         </td>
         <input type="hidden" id="tpe2001" value="insert">    
         <td width="">
           <input class="form-control labels_input allownumeric" id="at_roll2001" onchange="show_custom_design_btn(2001)" placeholder="Enter Roll" value="" type="number" min="0">
           <input id="old_roll2001" value="0" type="hidden">
         </td>
         <td align="center" width="" id="lbl_per_roll2001"></td>
         <td  align="center" id ="minlabelperroll"></td>
         <td align="center" id = "maxlabelperroll"></td>

         <td width="" align="center">
    
           <input type="hidden" id="artwork_id2001">
           <button data-value="sheets" id="save2001" onclick="uploadCustomArtwork(2001,this,'<?=$data['rowKey'] ?>')" class=" btn btn-danger" style="padding: 8px;"><i class="fa fa-save"></i></button>
    
           <button data-value="sheets" id="delete2001" class=" btn btn-success " onclick="delete_old_artwork_cart_page('<?=$data['productId'] ?>','re')" style=" padding: 8px;background-color: red; display:none"><i class="fa fa-trash"></i> </button>
    
  
         </td>
       </tr>

  </tbody>


   </table>
   
   
   
    <table class="m-t-t-10">
    <tr>
      <td width="70%" colspan="6" align="left">
        <button class="btn btn-success yes_art_btn" onclick="show_with_artwork();"> <i class="fa fa-Upload"></i> Upload Artwork</button>
        <button class="btn btn-warning no_art_btn orangeBg"  onclick="show_no_artwork();">      <i class="fa fa-plus"></i>   Artwork to Follow</button>
        
       
      </td>
    </tr>
    
  </table>
   
   
   
   
</div>

  </div>



<script type="text/javascript">
  var pages = $('#page').val();
  //$(window).load(function(){
    
  
  hideOldArtwork();
  var rowKeys = $('#rowKey').val();
  var no_design = parseInt($('#design'+rowKeys).val());
  var exits_design = parseInt($('#nodesign2001').val());
  var uploadDesign = parseInt($('#getArtworkWithPic').val());
  
   if($.isNumeric(exits_design)==false || $.isNumeric(no_design)==false){
      $('#with_artwork_tbl').hide();
     $('#no_img_artwork_tbl').hide();
   }
  
  
  var total_lb = parseInt($('#totalLabels'+rowKeys).val());
  var roll = parseInt($('#qty'+rowKeys).val());
  
   var totallabel = $('#label_for_orders'+rowKeys).val();
   var minroll= $('#minrolls').val()
   var labelPerSheet = $('#lblPerSheet').val();
   $('#maxlabelperroll').text(labelPerSheet);
   if(minroll == ''){
     minroll = roll ;
   }

  if(minroll == 0  || isNaN(minroll)){
    var minlabel = 0;
  }else{ 
    var minlabel= Math.round(100/minroll);
  }
  $('#minlabelperroll').text(minlabel);
  
  
   $('#save2001').hide();
             
  if(typeof exits_design.isNaN == 'undefined' ||  $.isNumeric(exits_design) ==false ){
    exits_design = 0;
  }
  

  
  
  if(no_design > 0 && uploadDesign ==0){
     
    show_no_artwork();
    $('#delete2001').show();
    $('#nodesign2001').val(no_design);
    $('#at_label2001').val(total_lb);
    $('#at_roll2001').val(roll);
    $('#lbl_per_roll2001').html(Math.ceil(total_lb / roll));
    
    if(pages=='order_detail_page'){
     
       $('#at_label2001').val($('#label_for_orders'+rowKeys).val());
        $('#lbl_per_roll2001').html(Math.ceil(totallabel / roll));
    }
  }
        
  if((exits_design == 0) && uploadDesign > 0){
    show_with_artwork();
  }
  
  if(exits_design == 0 && uploadDesign == 0 && no_design == 0){
    
    $('#with_artwork_tbl').hide();
    $('#no_img_artwork_tbl').hide();
  }
  //});
      
</script>



