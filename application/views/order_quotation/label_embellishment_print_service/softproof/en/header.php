<?
$roll_material = (preg_match('/roll/is', $result['ProductName'])) ? substr($result['diecode'], 0, -1) : $result['diecode'];
$materialcode = $this->home_model->getmaterialcode($roll_material);
$die = str_replace($materialcode, "", $roll_material);
$category = $this->db->query("select LabelWidth,LabelHeight,Shape from category where CategoryImage LIKE '%" . $die . "%'")->row_array();

$materialinfo = $this->db->query("select material_name from material_tooltip_info where material_code LIKE '" . $materialcode . "' ")->row_array();
$materialidescription = $materialinfo['material_name'];

?>

<div class="thumbnail prMatDC">
  <div class="clear10"></div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="title"> <b class="col-sm-12 col-xs-6  text-center">Label and Order Details</b> </div>
    <div class="captionX m0">
      <div class="col-xs-12 col-sm-4 col-md-2">
        <p><strong>Order Number</strong> <br>
          <?= $result['OrderNumber'] ?>
        </p>
        <p><strong>Date/ Time</strong> <br>
          <?
                 $date = new DateTime($result['Date']);
                 echo $date->format('d.m.Y') . ' @ ' . $date->format('h:i A'); ?>
        </p>
        <p><strong>Customer Care Contact</strong> <br>
          <?= ($result['Operator']) ? $result['Operator'] : 'N/A' ?>
        </p>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <p><strong>Label Product Code</strong> <br>
          <?= $result['diecode'] ?>
        </p>
        <p><strong>Label Size</strong> <br>
          <? if (preg_match("/circular/is", $category['Shape'])) {
                    echo $category['LabelWidth'] . ' Diameter';
                } else { ?>
          Width
          <?= $category['LabelWidth'] ?>
          X Height
          <?= $category['LabelHeight'] ?>
          <? } ?>
        </p>
        <p><strong>Label Leading Edge</strong> <br>
          <? echo 'Width ' . $category['LabelWidth']; ?> </p>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-3">
        <p><strong>Label Face-Stock</strong> <br>
          <?= $materialidescription ?>
        </p>
        <p><strong>Finish Finish</strong> <br>
          <?= $result['FinishType'] ?>
        </p>
        <p><strong>Sequential Codes/Numbers</strong> <br>
          N/A </p>
      </div>
      <?
    $maxref = $this->home_model->fetch_maxref($result['ID']);
    $curnt_chat = $this->home_model->fetch_current_chat($result['ID'],$maxref);
  ?>
      <input type="hidden" id="maxjobid" value="<?=$maxref?>" />
      <div class="col-xs-12 col-sm-4 col-md-2">
        <? if($curnt_chat['thumb']!=''){?>
        <img onerror='imgError(this);' src="<?=AJAXURL?>/theme/site/printing/chat/thumb/<?=$curnt_chat['thumb']?>" width="150" alt="AA Labels"/>
        <? } ?>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-2">
        <div class="clear30"></div>
        <div class="clear30"></div>
        <? if($curnt_chat['pdf']!=''){?>
        <a href="<?=AJAXURL?>/theme/site/printing/chat/pdf/<?=$curnt_chat['pdf']?>" target="_blank">
        <button class="btn btn-block orangeBg" type="button"><i class="fa fa-cloud-download" aria-hidden="true" style="font-weight:bold;"></i>&nbsp;Download</button>
        </a>
        <? } ?>
      </div>
    </div>
  </div>
</div>
<?
$soft = AJAXURL . '/theme/site/printing/chat/softproof/' . $result['softproof'];
$revissoft = AJAXURL . '/theme/site/printing/chat/softproof/';
$history = $this->home_model->fetch_customer_versions($result['ID']);
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 SoftProofM">
  <div class="thumbnail prMatDC col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-left">
    <div class="title"> <b class="col-sm-12 col-xs-6 text-center">Artwork/Reprographic Soft-Proof</b> </div>
    <div class="clear10"></div>
    <div class=""> <b class="col-sm-12 col-xs-6" id="actual_softproof_title">
      <?=$result['name']?>
      (V
      <?=$history[0]->ref?>
      )</b> </div>
    <div class="scale-img"> <img onerror='imgError(this);' class="img-responsive product_material_image" src="<?=$soft?>" id="main_image_softproof" alt="AA Labels Softproof"> </div>
  </div>
  <div class="thumbnail prMatDC ol-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right OldSoftproof">
    <div class="title"> <b class="col-sm-12 col-xs-6 text-center">Revision History</b> </div>
    <div id="ReviseHistoryMain">
      <? $loop = 0;
		  foreach($history as $rowp){  $loop ++;
			$custfeed = $this->home_model->checkref($result['ID'],$rowp->ref);
			$custfeedquestion = $this->home_model->fetch_custfeed($result['ID'],$rowp->ref);
			$vtype = 'V'.$rowp->ref;
			
			if($loop==1){
			 $q1 = $q2 = $q3 = $q4 = $q5 = $q6 = $q7 = 'N/A'; 
			}else{
			 $q1 = ($custfeedquestion['q1']==0)?$custfeedquestion['q1_text']:'Yes';
			 $q2 = ($custfeedquestion['q2']==0)?$custfeedquestion['q2_text']:'Yes';
			 $q3 = ($custfeedquestion['q3']==0)?$custfeedquestion['q3_text']:'Yes';
			 $q4 = ($custfeedquestion['q4']==0)?$custfeedquestion['q4_text']:'Yes';
			 $q5 = ($custfeedquestion['q5']==0)?$custfeedquestion['q5_text']:'Yes';
			 $q6 = ($custfeedquestion['q6']==0)?$custfeedquestion['q6_text']:'Yes';
			 $q7 = ($custfeedquestion['q7']==0)?$custfeedquestion['q7_text']:'Yes';
			}
		
		?>
      <div class="RevisionHistory col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2 class="history_name">
          <?=$result['name']?>
          (
          <?=$vtype?>
          )</h2>
        <div class="ReviseSoftproofsList" data-loop="<?=$loop?>"> <img onerror='imgError(this);' class="img-responsive history_softproof " src="<?=$revissoft.$rowp->softproof?>" title="<?=$result['name']?> (<?=$vtype?>)" alt="<?=$rowp->ref?>">
          <? $livesrc = 'https://www.aalabels.com/theme/site/printing/chat/decline.png'; ?>
          <? if($loop>1){ ?>
          <img onerror='imgError(this);' class="img-responsive decline" src="<?=$livesrc?>">
          <? } ?>
        </div>
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
        <div class="spratorDark"></div>
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
        <?  if(preg_match('/roll/is',$result['ProductName'])){ ?>
        <? if($custfeed['q6']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Have you checked and approved the roll winding?</h2>
          <p> <span>A:</span>
            <?=$q6?>
          </p>
        </div>
        <div class="spratorDark"></div>
        <? } ?>
        <? if($custfeed['q7']==1){?>
        <div class="ReviseSoftProofQA text-justify">
          <h2>Q:Have you checked and approved the roll label core size?</h2>
          <p> <span>A:</span>
            <?=$q7?>
          </p>
        </div>
        <div class="spratorDark"></div>
        <? } ?>
        <? } ?>
      </div>
      <? } ?>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js" ></script> 
<script>
	$(function(){
        $('#ReviseHistoryMain').slimScroll({
            height: '560px',
            railVisible: true,
            railBorderRadius: 0
        });
    });
</script>
<style>

    .history_softproof{
	  cursor:pointer;
	 }
	.SoftProofM {
		padding-left:0 ;
		padding-right:0 ;
	}
	.RevisionHistory {

	}
	.OldSoftproof {
		width: 24%;
		 height: 621px;
	}
	.OldSoftproof h2 {
		font-size: 13px;
		font-weight: bold;
		color: #333;
		margin-bottom: 0;
		margin-top: 10px;
	}
	.OldSoftproof .title {
		margin-bottom: 0 !important;
	}
	.ReviseSoftproofsList {
		margin: 5px 0;
		border: 1px solid #dedede;
		padding: 3px;
	}
	.ReviseSoftProofQA {
		margin-top: 10px;
		font-size: 11px;
	}
	.ReviseSoftProofQA h2 {
		font-weight: bold;
	}
	.ReviseSoftProofQA p {
		margin: 8px 0;
	}
	.ReviseSoftProofQA span {
		font-weight: bold;
	}
	.spratorS {
		width: 100%;
		background: #dedede;
		height: 1px;
	}
	.spratorDark {
		width: 100%;
		background: #333;
		height: 1px;
	}
	.slimScrollRail {
		background-color: #f5f5f5!important;
		width: 5px !important;
		box-shadow: inset 0 0 6px rgba(0,0,0,0.3) !important;
		opacity: 1 !important;
	}
	.slimScrollBar {
		width: 5px !important;
		background-color: #000 !important;
		height: 200px !important;
		border-radius: 0 !important;
	}
.decline {
	position: absolute;
	z-index: 99999;
	top: 6%;
	left: 8%;
	width: 200px;
	height: auto;
	cursor:pointer;
}
@media screen and (max-width: 768px)
  {
     .OldSoftproof {
       width: 100% !important;
      }
  }        
</style>
