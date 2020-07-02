


<?
 $roll_material = (preg_match('/roll/is',$result['ProductName']))?substr($result['diecode'],0,-1):$result['diecode'];
 $materialcode = $this->home_model->getmaterialcode($roll_material);
 $die = str_replace($materialcode,"",$roll_material);
 $category = $this->db->query("select LabelWidth,LabelHeight,Shape from category where CategoryImage LIKE '%".$die."%'")->row_array();
 
 $materialinfo = $this->db->query("select material_name_fr from material_tooltip_info where material_code LIKE '".$materialcode."' ")->row_array();
 $materialidescription = $materialinfo['material_name_fr'];
 
?>

    <div class="thumbnail prMatDC">
      <div class="clear10"></div>
      <div class="col-xs-12 col-sm-12 col-md-12" >
        <div class="title"> <b class="col-sm-12 col-xs-6  text-center">Détails de l'étiquette et de la commande</b> </div>
        <div class="captionX m0">
        
        
          <div class="col-xs-12 col-sm-4 col-md-2">
             <p><strong>Numéro de commande</strong> <br>
              <?=$result['OrderNumber']?>
            </p>
             <p><strong>Date et heure</strong> <br>
              <? 
			  $date = new DateTime($result['Date']);
              echo $date->format('d.m.Y').' @ '.$date->format('h:i A');?>
            </p>
            <p><strong>Équipe Service Clients</strong> <br>
              <?=($result['Operator'])?$result['Operator']:'N/A'?>
            </p>
          </div>
          
          <div class="col-xs-12 col-sm-4 col-md-3">
            <p><strong>Code de produit d'étiquette</strong> <br>
              <?=$result['diecode']?>
            </p>
           
            <p><strong>Taille de l'étiquette</strong> <br>
              <? if(preg_match("/circular/is", $category['Shape'])){
                    echo $category['LabelWidth'].' Diamètre';
				}else{?>
                    Largeur <?=$category['LabelWidth']?> X la taille <?=$category['LabelHeight']?>
               <? } ?> 
            </p>
            <p><strong>Étiquette Avant-garde</strong> <br>
              <? echo 'Largeur '.$category['LabelWidth']; ?>
            </p>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-3">
            <p><strong>Matériau d'étiquette</strong> <br>
              <?=$materialidescription?>
            </p>
            <p><strong>Fin d'étiquette</strong> <br>
              <? if($result['FinishType']=="Matt Lamination"){
				  echo "Stratifié mat ";
				 }else if($result['FinishType']=="Gloss Lamination"){
				  echo "Stratifié brillant ";
				 }else if($result['FinishType']=="Gloss Varnish"){
				  echo "Vernis brillant ";
				 }else if($result['FinishType']=="Matt Varnish"){
				  echo "Vernis mat ";
				}else{
				 echo "Pas de finition ";
				}
			 ?>	 
            </p>
             <p><strong>Codes séquentiels et numéros</strong> <br>
              N/A
            </p>
          </div>
        </div>
     
  
  
  <?
    $maxref = $this->home_model->fetch_maxref($result['ID']);
    $curnt_chat = $this->home_model->fetch_current_chat($result['ID'],$maxref);
  ?> 
  <input type="hidden" id="maxjobid" value="<?=$maxref?>" />  
  
      <div class="col-xs-12 col-sm-4 col-md-2">
           <img onerror='imgError(this);' src="<?=AJAXURL?>/theme/site/printing/chat/thumb/<?=$curnt_chat['thumb']?>" width="150"/>
          </div>
          
          <div class="col-xs-12 col-sm-4 col-md-2">
          <div class="clear30"></div>
          <div class="clear30"></div>
            <a href="<?=AJAXURL?>/theme/site/printing/chat/pdf/<?=$curnt_chat['pdf']?>" target="_blank">
             <button class="btn btn-block orangeBg" type="button"><i class="fa fa-cloud-download" aria-hidden="true" style="font-weight:bold;"></i>&nbsp;Telecharger</button></a>
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
		<div class="title">
			<b class="col-sm-12 col-xs-6 text-center">Reprographique/Oeuvres d'art/Preuve douce</b>
		</div>
		<div class="clear10"></div>
        <div class="">
			<b class="col-sm-12 col-xs-6" id="actual_softproof_title"><?=$result['name']?> (V<?=$history[0]->ref?>)</b>
		</div>
		<div class="scale-img">
		    <img onerror='imgError(this);' class="img-responsive product_material_image" src="<?=$soft?>" id="main_image_softproof">
             
		</div>
	</div>
    
   
   <div class="thumbnail prMatDC ol-lg-3 col-md-3 col-sm-12 col-xs-12 pull-right OldSoftproof">
		<div class="title">
			<b class="col-sm-12 col-xs-6 text-center">Historique des revisions</b>
		</div>
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
			    <h2 class="history_name"><?=$result['name']?> (<?=$vtype?>)</h2>
				<div class="ReviseSoftproofsList">
					 <img onerror='imgError(this);' class="img-responsive history_softproof" src="<?=$revissoft.$rowp->softproof?>" title="<?=$result['name']?> (<?=$vtype?>)" alt="<?=$rowp->ref?>">
                     <? $livesrc = 'https://www.aalabels.com/theme/site/printing/chat/decline.png'; ?>
					  <? if($loop>1){ ?>
                      <img onerror='imgError(this);' class="img-responsive decline" src="<?=$livesrc?>">
                      <? } ?> 
				</div>
        
        
            <? if($custfeed['q1']==1){?>     
            	<div class="ReviseSoftProofQA text-justify">
					<h2>Q:L'orthographe, la grammaire et le positionnement du texte sont-ils corrects?</h2>
					<p>
						<span>A:</span>  <?=$q1?>
					</p>
				</div>
				<div class="spratorS"></div>
            <? } ?>    
                
          <? if($custfeed['q2']==1){?>         
				<div class="ReviseSoftProofQA text-justify">
					<h2>Q:Les informations de contenu sont-elles correctes, par ex. Codes d'actifs, codes à barres, coordonnées, dates, ingrédients, prix etc.</h2>
					<p>
						<span>A:</span>  <?=$q2?>
					</p>
				</div>
				<div class="spratorS"></div>
          <? } ?>    
          
          <? if($custfeed['q3']==1){?>             
				<div class="ReviseSoftProofQA text-justify">
					<h2>Q:Les polices de texte sont-elles correctes, par ex. Le ton et le style?</h2>
					<p>
						<span>A:</span>  <?=$q3?>
					</p>
				</div>
				<div class="spratorDark"></div>
            <? } ?>   
            
           
            <? if($custfeed['q4']==1){?>   
                 <div class="ReviseSoftProofQA text-justify">
					<h2>Q:L'alignement et le rapport de l'œuvre est-il correct, par ex. Tel que fourni et / ou modifié et convenu?</h2>
					<p>
						<span>A:</span>  <?=$q4?>
					</p>
				</div>
				<div class="spratorS"></div>
		   <? } ?>  	
          
             <? if($custfeed['q5']==1){?>     
            	<div class="ReviseSoftProofQA text-justify">
					<h2>Q:Les couleurs sont-elles convenues?</h2>
					<p>
						<span>A:</span>  <?=$q5?>
					</p>
				</div>
				<div class="spratorS"></div>
           <? } ?>
           
                 
      <?  if(preg_match('/roll/is',$result['ProductName'])){ ?>   
			
             <? if($custfeed['q6']==1){?>    
            	<div class="ReviseSoftProofQA text-justify">
					<h2>Q:Avez-vous vérifié et approuvé l'enroulement du rouleau?</h2>
					<p>
						<span>A:</span>  <?=$q6?>
					</p>
				</div>
				<div class="spratorDark"></div>
            <? } ?>
            
            <? if($custfeed['q7']==1){?>  
                <div class="ReviseSoftProofQA text-justify">
					<h2>Q:Avez-vous vérifié et approuvé la taille du noyau de l'étiquette du rouleau?</h2>

					<p>
						<span>A:</span>  <?=$q7?>
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
		height: 619px;
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
}</style>

  