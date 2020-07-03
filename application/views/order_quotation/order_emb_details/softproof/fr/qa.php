    
    
      <table class="table table-striped labels-form " style="border:solid 2px #00aeef;">
            <thead class="theadX" >
              <tr>
                <th width="5%" align="left">Article </th>
                <th width="40%" align="left">Liste de vérification</th>
                <th width="12%" align="left">Approuvé</th>
                <th width="14%" align="left">Modification requise</th>
                <th width="34%" align="left">Description de l'amendement</th>
              </tr>
            </thead>
           <tbody>
           
           
           
             <? $max = $this->home_model->fetch_maxversion($result['ID']); 
		    if(empty($max)){ 
			   $max['ref'] = 0;
			   $max['q1'] = $max['q2'] = $max['q3'] = $max['q4'] = $max['q5'] = $max['q6'] = $max['q7'] = 0;
			 }
		    $item=0;
		 ?>  
         
         <? if($max['q1']==0){   $item++; ?>
            <tr class="checklist" valign="middle">
              <td align="left"><?=$item?></td>
              <td align="left">L'orthographe, la grammaire et le positionnement du texte sont-ils corrects?</td>
              <td><label class="checkbox">
                  <input name="feedback[q1]" class="textOrange approve" value="1"  type="radio" />
                  <i></i></label></td>
              <td><label class="checkbox">
                  <input name="feedback[q1]" class="textOrange amend" value="0" type="radio" />
                  <i></i></label></td>
              <td align="left"><textarea name="feedback[q1_text]" rows="1" class="form-control description"></textarea></td>
            </tr>
           <? }else{ ?> <input name="feedback[q1]" class="textOrange approve hide" value="1"  type="radio" checked="checked"/> <? } ?>
           
         <? if($max['q2']==0){   $item++; ?>    
            <tr class="checklist" valign="middle">
              <td align="left"><?=$item?></td>
              <td align="left">Les informations de contenu sont-elles correctes, par ex. Codes d'actifs, codes à barres, coordonnées, dates, ingrédients, prix etc.</td>
              <td><label class="checkbox">
                  <input name="feedback[q2]" class="textOrange approve" value="1"  type="radio" />
                  <i></i></label></td>
              <td><label class="checkbox">
                  <input name="feedback[q2]" class="textOrange amend" value="0" type="radio" />
                  <i></i></label></td>
              <td align="left"><textarea name="feedback[q2_text]" rows="1" class="form-control description"></textarea></td>
            </tr>
          <? }else{ ?> <input name="feedback[q2]" class="textOrange approve hide" value="1"  type="radio" checked="checked"/> <? } ?>
            
        
        
        <? if($max['q3']==0){   $item++; ?>       
           <tr class="checklist" valign="middle">
              <td align="left"><?=$item?></td>
              <td align="left">Les polices de texte sont-elles correctes, par ex. Le ton et le style?</td>
              <td><label class="checkbox">
                  <input name="feedback[q3]" class="textOrange approve" value="1"  type="radio" />
                  <i></i></label></td>
              <td><label class="checkbox">
                  <input name="feedback[q3]" class="textOrange amend" value="0" type="radio" />
                  <i></i></label></td>
              <td align="left"><textarea name="feedback[q3_text]" rows="1" class="form-control description"></textarea></td>
            </tr>
        <? }else{ ?> <input name="feedback[q3]" class="textOrange approve hide" value="1"  type="radio" checked="checked" /> <? } ?>
        
      
       <? if($max['q4']==0){   $item++; ?>       
          <tr class="checklist" valign="middle">
              <td align="left"><?=$item?></td>
              <td align="left">L'alignement et le rapport de l'œuvre est-il correct, par ex. Tel que fourni et / ou modifié et convenu?</td>
              <td><label class="checkbox">
                  <input name="feedback[q4]" class="textOrange approve" value="1"  type="radio" />
                  <i></i></label></td>
              <td><label class="checkbox">
                  <input name="feedback[q4]" class="textOrange amend" value="0" type="radio" />
                  <i></i></label></td>
              <td align="left"><textarea name="feedback[q4_text]" rows="1" class="form-control description"></textarea></td>
            </tr>
        <? }else{ ?> <input name="feedback[q4]" class="textOrange approve hide" value="1"  type="radio" checked="checked" /> <? } ?>
       
       
        <? if($max['q5']==0){   $item++; ?>  
          <tr class="checklist" valign="middle">
              <td align="left"><?=$item?></td>
              <td align="left">Les couleurs sont-elles convenues?</td>
              <td><label class="checkbox">
                  <input name="feedback[q5]" class="textOrange approve" value="1"  type="radio" />
                  <i></i></label></td>
              <td><label class="checkbox">
                  <input name="feedback[q5]" class="textOrange amend" value="0" type="radio" />
                  <i></i></label></td>
              <td align="left"><textarea name="feedback[q5_text]" rows="1" class="form-control description"></textarea></td>
            </tr>
       <? }else{ ?> <input name="feedback[q5]" class="textOrange approve hide" value="1"  type="radio" checked="checked" /> <? } ?>
       
             
        <?  if(preg_match('/roll/is',$result['ProductName'])){ ?>
           
            <? if($max['q6']==0){   $item++; ?>        
                <tr class="checklist" valign="middle">
                  <td align="left"><?=$item?></td>
                  <td align="left">Avez-vous vérifié et approuvé l'enroulement du rouleau?</td>
                  <td><label class="checkbox">
                      <input name="feedback[q6]" class="textOrange approve" value="1"  type="radio" />
                      <i></i></label></td>
                  <td><label class="checkbox">
                      <input name="feedback[q6]" class="textOrange amend" value="0" type="radio" />
                      <i></i></label></td>
                  <td align="left"><textarea name="feedback[q6_text]" rows="1" class="form-control description"></textarea></td>
                </tr>
             <? }else{ ?> <input name="feedback[q6]" class="textOrange approve hide" value="1"  type="radio" checked="checked" /> <? } ?>
             
              <? if($max['q7']==0){   $item++; ?>       
                <tr class="checklist" valign="middle">
                  <td align="left"><?=$item?></td>
                  <td align="left">Avez-vous vérifié et approuvé la taille du noyau de l'étiquette du rouleau?</td>
                  <td><label class="checkbox">
                      <input name="feedback[q7]" class="textOrange approve" value="1"  type="radio" />
                      <i></i></label></td>
                  <td><label class="checkbox">
                      <input name="feedback[q7]" class="textOrange amend" value="0"  type="radio" />
                      <i></i></label></td>
                  <td align="left"><textarea name="feedback[q7_text]" rows="1" class="form-control description"></textarea></td>
                </tr>
             <? }else{ ?> <input name="feedback[q7]" class="textOrange approve hide" value="1"  type="radio" checked="checked" /> <? } ?>
                 
          <? } ?>  
          
               <input type="hidden" name="language"  id="language" value="<?=$language?>"/>
               <input type="hidden" name="feedback[approveref]"  id="approveref" value="<?=$max['ref']+1?>"/>
               <input type="hidden" name="feedback[ref]"  id="artworkvef" value="<?=$max['ref']+1?>"/>
               
           </tbody>
         </table>
       </div>     
               