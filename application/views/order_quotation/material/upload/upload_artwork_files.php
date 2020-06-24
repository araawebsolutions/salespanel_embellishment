<div class="col-md-12 col-xs-12 col-sm-12 text-justify"> 
	<!-- Upload Artwork --> 
	<div class="clearfix">   
		<div class="ovFl table-responsive">  
			<div id="ajax_upload_content" style=" <?=($type=='rolls')?'min-height:300px;':'min-height:240px;'?>">   
				<? if($type =='rolls'){					include('roll_artwork_files.php');			 }	
					 else{				 	include('a4_artwork_files.php');		    
						 
						 
						 
						 
						 } ?>   
			</div>      <div class="clear15"></div> 
			<? if($type=='rolls'){ ?> 
			
			<!--<div class="labels-form">        
				<label class="checkbox pull-right" style="font-size:12px; text-align:justify !important;">
					<input id="pressproof" <?=($presproof)?'checked="checked"':''?>  value="<?=$presproof?>" type="checkbox" class="textOrange"> 
				</label>      
			</div>    -->
			
			<div class="labels-form">
                 <label class="checkbox pull-right" style="font-size:12px; text-align:justify !important;">
                  <input id="pressproof" <?=($presproof)?'checked="checked"':''?>  value="<?=$presproof?>" type="checkbox" class="textOrange"> <i></i></label>
                <p> <span> Do you require a hard copy pre-production press proof? (Cost £50.00)  </span>
                  <small><br>you will always automatically receive an  electronic free of charge soft proof for approval before your labels are produced</small> 
                </p>
            </div>
			<hr>
			
			<div class="alert alert-warning labels-form">  
              <p>Please note uploaded files must be no larger than 2Mb and to achieve the best results for your finished labels you will need a professional standard of artwork. We require scaled, print-ready studio artwork, supplied in editable PDF or EPS format, with a minimum resolution of 200dpi. No original artwork e.g. hand drawn images, can be amended and if you only have image files e.g. JPEG these also cannot be easily amended and need to be print ready.</p> 
            </div>
			
			
			<? } ?>
			
			<?php if($type!='rolls'){ ?>
			<div class="alert alert-warning labels-form">  
              <p>Please note uploaded files must be no larger than 2Mb and to achieve the best results for your finished labels you will need a professional standard of artwork. We require scaled, print-ready studio artwork, supplied in editable PDF or EPS format, with a minimum resolution of 200dpi. No original artwork e.g. hand drawn images, can be amended and if you only have image files e.g. JPEG these also cannot be easily amended and need to be print ready.</p> 
            </div>
			<?php  }?>
		</div>      
		
		<button type="button" class="btn btn-outline-dark waves-light waves-effect pull-right" data-dismiss="modal" aria-label="Close"><i class="fa fa-time" aria-hidden="true"></i>&nbsp; Continue </button>  </div>  <!-- Upload Artwork -->   </div>