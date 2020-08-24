
<?
//echo '<pre>'; print_r($result); echo '</pre>';
$soft = ARTWORKS . '/theme/site/printing/chat/softproof/' . $result->softproof;
//$soft = 'https://www.aalabels.com//theme/site/printing/chat/softproof/AA206439_PJ25445_AAD024_Softproof.jpg';
$revissoft = ARTWORKS . '/theme/site/printing/chat/softproof/';
?>
<div class="SoftProofM">
  <div class="prMatDC col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-left" style="padding:0px 20px 0px 0px;">
	  <div class="thumbnail">
    <div class="title"> <b class="col-sm-12 col-xs-6 text-center" style="font-size:14px">Artwork Soft-Proof</b> </div>
    <div class="clear10"></div>
    <!--<div class=""> <b class="col-sm-12 col-xs-6" id="actual_softproof_title">
      Artwork Soft-Proof (V)</b> </div>-->
	  <div class="scale-img" style="text-align: -webkit-center;"> 
		  
		  <div style="">
			  <img onerror='imgError(this);' class="img-responsive product_material_image" src="<?=$soft?>" id="main_image_softproof" alt="AA Labels Softproof" style="cursor: crosshair; max-width:70%"> 
			  <!--<a class="hoverfx" href="<?=$soft?>" target="_blank">
				  <div class="figure" data-toggle="modal" data-target="#myModal">
					  <i class="fa fa-search-plus f-s-75"></i>
				  </div>
				  <div class="overlay">
				  </div>
				  <img onerror='imgError(this);' class="img-responsive product_material_image" src="<?=$soft?>" id="main_image_softproof" alt="AA Labels Softproof"> 
			  </a>-->
		  </div>
		  </div> 
		  </div>
  </div>
	<?php //echo '<pre>'; print_r($history); echo '</pre>'; ?>
  <div class="thumbnail prMatDC col-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right OldSoftproof">
    <div class="title"> <b class="col-sm-12 col-xs-6 text-center" style="font-size: 14px;">Revision History & Comments</b> </div>
    <div id="ReviseHistoryMain"  style="height: 661px; overflow-y: scroll;">
      <?  $loop = 0;
		   $i = count($history);
		  foreach($history as $rowp){  $loop ++;
								
			$custfeed = $this->Home_model->checkref($jobno,$rowp->ref);
			$custfeedquestion = $this->Home_model->fetch_custfeed($jobno,$rowp->ref);
			//$vtype = 'V'.$rowp->ref;
			$vtype = 'V'.$i;
			
			//if($loop==1){
			 $q1 = $q2 = $q3 = $q4 = $q5 = $q6 = $q7 = 'N/A'; 
			//}else{
			 $q1 = ($custfeedquestion['q1']==0)?$custfeedquestion['q1_text']:'Yes';
			 $q2 = ($custfeedquestion['q2']==0)?$custfeedquestion['q2_text']:'Yes';
			 $q3 = ($custfeedquestion['q3']==0)?$custfeedquestion['q3_text']:'Yes';
			 $q4 = ($custfeedquestion['q4']==0)?$custfeedquestion['q4_text']:'Yes';
			 $q5 = ($custfeedquestion['q5']==0)?$custfeedquestion['q5_text']:'Yes';
			 $q6 = ($custfeedquestion['q6']==0)?$custfeedquestion['q6_text']:'Yes';
			 $q7 = ($custfeedquestion['q7']==0)?$custfeedquestion['q7_text']:'Yes';
			//}
		
		?>
		
		<?php if($loop > 1){ ?>
		<br>
		<?php } ?>
		
      <div class="RevisionHistory col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2 class="history_name">
          Softproof (<?=$vtype?>) </h2>
		  
        <div class="ReviseSoftproofsList" data-loop="<?=$loop?>" onclick="getSrc('<?=$revissoft.$rowp->softproof?>');" style=" text-align:-webkit-center ">  
			
			<img onerror='imgError(this);'  class="img-responsive history_softproof " src="<?=$revissoft.$rowp->softproof?>" title="(<?=$vtype?>)" alt="<?=$vtype?>" style="max-width:100%">
			
          <? $livesrc = 'https://www.aalabels.com/theme/site/printing/chat/decline.png'; ?>
          <? //if($loop>1){ ?>
          <img onerror='imgError(this);' class="img-responsive decline" src="<?=$livesrc?>">
          <? //} ?>
			
        </div>
		  
		  <? if($rowp->rejected=='1'){
			$com_id = $rowp->ID + 1;
			$comss = $this->db->query('select * from artwork_chat where ID ='. $com_id)->row_array();
			
		  ?>
		  <div class="ReviseSoftProofQA text-justify">
			  <h2>Operator Decline Notes</h2>
			  <p>   <?=$comss['comment']?>  </p>
		  </div>
		  
		  <div class="spratorS"></div>
		  <? } ?>
		  
		  
        <? if($custfeed['q1']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Is the spelling, grammar and positioning of text correct?</h2>
          <p> <span>A:</span>
            <?=$q1?>
          </p>
        </div>
        <div class="spratorS"></div>
        <? } ?>
        <? if($custfeed['q2']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Is the content information correct e.g. Asset codes, bar codes, contact details, dates, ingredients, prices etc?</h2>
          <p> <span>A:</span>
            <?=$q2?>
          </p>
        </div>
        <div class="spratorS"></div>
        <? } ?>
        <? if($custfeed['q3']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Are the text fonts correct e.g. Pitch and style?</h2>
          <p> <span>A:</span>
            <?=$q3?>
          </p>
        </div>
        <div class="spratorS"></div>
        <? } ?>
        <? if($custfeed['q4']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Is the alignment and ratio of the artwork correct e.g. As supplied and/or amended and agreed?</h2>
          <p> <span>A:</span>
            <?=$q4?>
          </p>
        </div>
        <div class="spratorS"></div>
        <? } ?>
        <? if($custfeed['q5']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Are the colours as agreed?</h2>
          <p> <span>A:</span>
            <?=$q5?>
          </p>
        </div>
        <div class="spratorS"></div>
        <? } ?>
        <?  if(preg_match('/roll/is',$rowp->Brand)){ ?>
        <? if($custfeed['q6']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Have you checked and approved the roll winding?</h2>
          <p> <span>A:</span>
            <?=$q6?>
          </p>
        </div>
        <div class="spratorS"></div>
        <? } ?>
        <? if($custfeed['q7']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Have you checked and approved the roll label core size?</h2>
          <p> <span>A:</span>
            <?=$q7?>
          </p>
        </div>
       
        <? } ?>
        <? } ?>
      </div>
		 <div class="spratorDark"></div>
      <? $i--; } ?>
    </div>
  </div>
</div>

<script type="text/javascript">
$(".product_material_image").hover(function (e) {
		 var value = $(this).aaZoom();
	 });
	$('.product_material_image').aaZoom();

</script>
	