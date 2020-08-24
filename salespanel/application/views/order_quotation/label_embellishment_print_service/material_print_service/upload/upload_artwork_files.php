<div class="col-md-12 col-xs-12 col-sm-12 text-justify">

          <div class="clear10"></div>
       
       <!-- Upload Artwork -->
<div class="col-sm-12 p0">
         <div class="ovFl table-responsive">
          
           <div id="ajax_upload_content" style=" <?=($details['labelCategory']=='Roll Labels')?'min-height:336px;':'min-height:392px;'?>">
          <? if( ($details['labelCategory'] =='A4 Labels') || ($details['labelCategory'] =='A3 Label') || ($details['labelCategory'] =='SRA3 Label') || ($details['labelCategory'] =='A5 Labels') ){ 
					include(APPPATH.'/views/material_print_service/upload/a4_artwork_files.php');
  			 }
		     else if($details['labelCategory'] =='Roll Labels'){
				 	include(APPPATH.'/views/material_print_service/upload/roll_artwork_files.php');
		     } ?> 
                
          </div>      
                
            
              
              
          <div class="clear15"></div>
              
        
             <? if($details['labelCategory'] =='Roll Labels'){ ?>
                <div class="labels-form">
                
                <label class="checkbox pull-right" style="font-size:12px; text-align:justify !important;">
                    <input id="pressproof" value="0" type="checkbox" class="textOrange"> <i></i>   
                 </label>
                <div class="clear10"></div>
                <p> <span> Do you require a hard copy pre-production press proof? (Cost &pound;50.00)  </span>
                <small><br />you will always automatically receive an  electronic free of charge soft proof for approval before your labels are produced</small> </p>
                </div>
              <hr />
             <? } ?> 
            
             <div class="alert alert-warning labels-form">  
              <p>Please note uploaded files must be no larger than 2Mb and to achieve the best results for your finished labels you will need a professional standard of artwork. We require scaled, print-ready studio artwork, supplied in editable PDF or EPS format, with a minimum resolution of 200dpi. No original artwork e.g. hand drawn images, can be amended and if you only have image files e.g. JPEG these also cannot be easily amended and need to be print ready as explained in our <a href="#" data-toggle="modal" data-target=".artwork_help" >guidelines</a>. </p> 
              
              
              </div>
              
              
             <!-- <div class="alert alert-warning">
              <p>Please note uploaded files must be no larger than 2Mb and to achieve the best results for your finished labels you will need a professional standard of artwork. We require scaled, print-ready studio artwork, supplied in editable PDF or EPS format, with a minimum resolution of 200dpi. No original artwork e.g. hand drawn images, can be amended and if you only have image files e.g. JPEG these also cannot be easily amended and need to be print ready as explained in our guidelines. </p> </div>-->
              </div>
             
              
          
              
            </div>

 <div class="clear"></div>
 <div class="col-md-12" >
 <div class="clear15"></div>
 

</div>           

<!-- Upload Artwork --> 
       


</div>












