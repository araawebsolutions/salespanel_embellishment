<div class="row">
<div class="col-md-12">
	<div class="SoftProofM">
			
		<div class=" prMatDC col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left OldSoftproof" style="padding-left: 0;">
			<div class="thumbnail">
			<div class="title" style="background: #e9e9e961; color:#0000009c"> <b class="col-sm-12 col-xs-6 text-center" style="font-size:14px">INTERNAL (STAFF) COMMENTS</b> </div>
			<div class="clear10"></div>
					
			<div style="height: 250px; overflow-y: auto;">
				<?  $loop = 0;
				$i = count($getDeclineComments);
				foreach($getDeclineComments as $rowp){  
					$loop ++;
				?>
		
				<?php if($loop > 1){ ?>
				<br>
				<?php } ?>
			
				<div class="RevisionHistory col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
					<h2 class="history_name">
						<? $date = new DateTime($rowp->time);  
							echo $time = $date->format('d/m/Y  h:i A'); ?> 
					</h2>
					<div class="spratorDark"></div>

					<div class="ReviseSoftProofQA text-justify">
						<!--<h6>Serial No# : (<?=$loop?>)</h6>-->
						<p> <span>Comment:</span>
							<?=$rowp->comment?>
						</p>
					</div>
					<div class="spratorS"></div>
				</div>
					
		
				<? $i--; } ?>
			</div>
		</div>
			</div>
			
		<div class="thumbnail prMatDC col-lg-6 col-md-6 pull-right OldSoftproof">
			<div class="title" style="background: #e9e9e961; color:#0000009c"> <b class="col-sm-12 col-xs-6 text-center" style="font-size: 14px;">REVISION HISTORY & COMMENTS</b> </div>
				
				
			<div style="height: 250px; overflow-y: auto;">
				<?  
				$loop = 0;
				$i = count($top_comments);
				
				foreach($top_comments as $rowp){
					$loop ++;
								
					$custfeed = $this->Home_model->checkref($jobno,$rowp->ref);
					$custfeedquestion = $this->Home_model->fetch_custfeed($jobno,$rowp->ref);
					$vtype = 'V'.$i;
			
					$q1 = $q2 = $q3 = $q4 = $q5 = $q6 = $q7 = 'N/A'; 
					$q1 = ($custfeedquestion['q1']==0)?$custfeedquestion['q1_text']:'Yes';
					$q2 = ($custfeedquestion['q2']==0)?$custfeedquestion['q2_text']:'Yes';
					$q3 = ($custfeedquestion['q3']==0)?$custfeedquestion['q3_text']:'Yes';
					$q4 = ($custfeedquestion['q4']==0)?$custfeedquestion['q4_text']:'Yes';
					$q5 = ($custfeedquestion['q5']==0)?$custfeedquestion['q5_text']:'Yes';
					$q6 = ($custfeedquestion['q6']==0)?$custfeedquestion['q6_text']:'Yes';
					$q7 = ($custfeedquestion['q7']==0)?$custfeedquestion['q7_text']:'Yes';
		
			?>
					
				<?php if($loop > 1){ ?>
				<br><br>
				<?php } ?>
		
				<div class="RevisionHistory col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h2 class="history_name">
						<? $date = new DateTime($rowp->Time); 
							echo $time = $date->format('d/m/Y  h:i A'); ?> (<?=$vtype?>) 
					</h2>
		  		  
					<div class="spratorDark"></div>

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
					<div class="spratorDark"></div>
				</div>
				
		
				<? $i--; } ?>
			</div>
		</div>
	</div>
	</div>
</div>