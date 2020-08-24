<div class="col-md-8 col-xs-8 col-sm-8 text-justify">

          <div class="clear10"></div>
       
       <!-- Upload Artwork -->
<div class="col-sm-12 p0">
         <div class="ovFl table-responsive">
          
           <div id="ajax_upload_content" style=" <?=($type=='rolls')?'min-height:336px;':'min-height:260px;'?>">
           
           <? if($type =='rolls'){ 
					include(APPPATH.'/views/order_quotation/material/upload/roll_artwork_files.php');
			 }
		     else{
				 	include(APPPATH.'/views/order_quotation/material/upload/a4_artwork_files.php');
		     } ?> 
                
          </div>      
                
            
          <div class="clear15"></div>
              
      <? if($type=='rolls'){ ?>
           <!-- <div class="labels-form">
            <label class="checkbox pull-right" style="font-size:12px; text-align:justify !important;">
               <input id="pressproof" <?=($presproof)?'checked="checked"':''?>  value="<?=$presproof?>" type="checkbox" class="textOrange"> <i></i>            </label>
            <p> <span> Do you require a hard copy pre-production press proof? (Cost &pound;50.00)  </span>
      		<small><br />you will always automatically receive an  electronic free of charge soft proof for approval before your labels are produced</small> </p></div><hr /> -->
      <? } ?> 
            
             <div class="alert alert-warning labels-form">  
              <p>Please note uploaded files must be no larger than 2Mb and to achieve the best results for your finished labels you will need a professional standard of artwork. We require scaled, print-ready studio artwork, supplied in editable PDF or EPS format, with a minimum resolution of 200dpi. No original artwork e.g. hand drawn images, can be amended and if you only have image files e.g. JPEG these also cannot be easily amended and need to be print ready.</p> 
              
              
            </div>
       </div>
  </div>


 <div class="col-md-12" >
 
 <div class="clear15"></div>
<!-- <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" aria-label="Close"><i class="fa fa-time" aria-hidden="true"></i>&nbsp; Continue </button> -->
 

</div>           

<!-- Upload Artwork --> 
       


</div>


<div class="col-md-4 col-xs-4 col-sm-4 text-justify">

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
    <div class="shopping-cart-box" style="width: 100%;">
                <div class="shopping-cart-box-small-heading"><span class="design_services_labels">0</span> Labels <!-- <span class="design_services_rolls">6</span> Rolls --></div>
          <div>
          <i class="fa-3x fa fa-shopping-cart "></i>
        <span class="shopping-cart-price">&pound;0.00</span>
      </div>
    </div>

  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
    <div class="blue_border  row" style="width: 100%; margin-left: 0;">
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="img_box">
        <img  src="" class="img_height offer_image">
      </div>
        <div class="txt_box">
          <div class="offer_manfactureid"></div>
          <div class="offer_material"></div>
          <div class="offer_digitalprintoption"></div>
          <div class="offer_category_description"></div>
          <div class="offer_labelfinish"></div>
        </div>
      </div>
      </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
    <div class="gray_border" style="width: 100%; ">
        <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-1">
           <input type="checkbox" style="float: left; display: block;" class="form-check-input nextDayDelivery" name="next_day_delivery" id="next_day_delivery" value="Y">
         </div>
           <div class="col-md-11 col-sm-11 col-xs-11" style="text-align: left;">
            My design files are ready for print and do not require my approval before print?
           </div>
      </div>
  </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
    <div class="gray_border" style="width: 100%;">
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-1">
           <input type="checkbox" style="float: left; display: block;" class="form-check-input nextDayDelivery" name="next_day_delivery" id="next_day_delivery" value="Y">
         </div>
           <div class="col-md-11 col-sm-11 col-xs-11" style="text-align: left;">
            I would like to approve my designs online before print.
           </div>
      </div>
      </div>
  </div>
<? if($type=='rolls'){ ?>
  <div class="col-md-12 col-sm-12 col-xs-12 mb-2">
    <div class="gray_border" style="width: 100%;">
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-1">
           
           <input id="pressproof" <?=($presproof)?'checked="checked"':''?> style="float: left; display: block;"  value="<?=$presproof?>" type="checkbox" class="textOrange form-check-input">
         </div>
           <div class="col-md-11 col-sm-11 col-xs-11" style="text-align: left;">
             <p> <span> Do you require a hard copy pre-production press proof? (Cost &pound;50.00)  </span>
          <br><span>you will always automatically receive an  electronic free of charge soft proof for approval before your labels are produced</span> </p>
           </div>
      </div>
      </div>
  </div>
<?php
}
?>
  </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="row">
    <div class="col-md-3 col-sm-3 col-xs-3">
      <button class="btn-block btn blue2 back_artwork" role="button"> <i class="fa fa-arrow-circle-left"></i> Back to Artwork </button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">

    </div>

    <div class="col-md-3 col-sm-3 col-xs-3">

      <button class="btn-block btn orange proceed_to_checkout">Proceed to Checkout <i class="fa fa-arrow-circle-right"></i></button>

    </div>

  </div>
</div>










