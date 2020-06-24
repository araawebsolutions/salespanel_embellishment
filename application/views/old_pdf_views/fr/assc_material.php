<?

$assoc = $this->user_model->fetch_custom_die_association($custominfo['ID']);
	        foreach($assoc as $rowp){ ?>
<? $materialprice = $rowp->plainprice+$rowp->printprice; ?>
             <tr>
                <td class="invoicetable_tabel_border"><b><?=$rowp->material?></b></td>
                <td class="invoicetable_tabel_border">

                    <?=$this->user_model->get_mat_name_fr($rowp->material);?> - <?=$rowp->labeltype?> etiquettes


  <?
  ?>

                    <?  if($rowp->labeltype=="printed"){

    if($rowp->printing=="Mono" || $rowp->printing=="Monochrome – Black Only"){
      $rowpprinting = "Monochrome - Noir seulement" ;
    }else{
      $fr_prnt_type  = $this->user_model->get_db_column('digital_printing_process', 'name_fr', 'name',$rowp->printing);
      $rowpprinting =$this->user_model->ReplaceHtmlToString_($fr_prnt_type);
    }

                         echo $rowpprinting.' - '.$rowp->designs.' Conceptions ';

						    if($custominfo['format']=="Roll"){
								 if($rowp->finish == "Gloss Lamination"){
									$finish_type_fr = 'Lamination Gloss';
								  }else if($rowp->finish == "Matt Lamination"){
									$finish_type_fr = 'Matt Lamination';
								  }else if($rowp->finish =="Matt Varnish"){
									$finish_type_fr = 'Vernis mat';
								  }else if($rowp->finish == "Gloss Varnish"){
									$finish_type_fr = 'Vernis brillant';
								  }else if($rowp->finish == "High Gloss Varnish"){
									$finish_type_fr = 'Vernis a haute brillance';
								  }else{
									$finish_type_fr == 'No Finish';
								  }
							   echo ' <br> avec etiquette '.$finish_type_fr;
                            }
                    }
				   ?>


                  <? if($custominfo['format']=="Roll"){
         echo $rowp->rolllabels.' etiquettes - taille de noyau '.$rowp->core.' mm - '.$rowp->wound.' blessure';
       }
				 ?>

               </td>
               
               <?php $sho = ''; if($custominfo['format'] =='Roll'){ $sho =  $rowp->rolllabels;} else { $sho =  ((($custominfo['across'] * $custominfo['around']) * $rowp->qty) );} ?>
                          
              
               
       
               <td class="invoicetable_tabel_border" align="center"><?=$symbol ?><?= number_format(($materialprice / $sho) * $exchange_rate,4 ) ?></td>
               
                 <td class="invoicetable_tabel_border" align="center">
                <?=$rowp->qty;?>
                 <?php if($custominfo['format']=="Roll"){
                    echo ($rowp->qty > 1)?'Rouleaux':'Rouleau';
                 }else{
                    echo ($rowp->qty > 1)?'Feuilles':'Feuille';
                  }?>
                 
                 <br>
                <?php if($custominfo['format'] =='Roll'){ echo $rowp->rolllabels.' Étiquettes';} else { echo (($custominfo['across'] * $custominfo['around'] * $rowp->qty) ).' Étiquettes';} ?>
                   
                   
                 
               </td>

            
            <? $materialpriceinc = $materialprice*1.2; ?>
            <td class="invoicetable_tabel_border" align="center"><? echo $symbol."".(number_format($materialprice * $exchange_rate,2));?></td>
         </tr>
                 <?  $print_exvat+= $materialprice;   $print_incvat+= $materialpriceinc;  ?>

 <?php if(($rowp->labeltype=="printed" && $custominfo['format'] != 'Roll') || ($custominfo['format'] == 'Roll' )){ ?>   

<?php //echo '<pre>'; print_r($assoc);  ?>

  <tr>
  <td class="invoicetable_tabel_border"></td>
  <td class="invoicetable_tabel_border">
    <i class="mdi mdi-check"></i><span>
    <?php 
                                      
    if($rowp->printing=="Mono"){ ?>
      <?php $rowp->printing = "Noir seulement"; ?>
    <?php } ?>
    
    <?= $rowp->printing ?>
    </span>
    <?php if ($rowp->designs > 0) { ?>
    <i class="mdi mdi-check"></i> <span>
    <?php $des = ($rowp->designs > 1 )?"Dessins":"Dessin"; ?>
    <?= $rowp->designs .' '. $des ?>
    </span>
    <?php } ?>
    <?php 
                      
    if ($custominfo['format'] == 'Roll') { ?>
    <span class="invoice-bold">
      <strong style="font-size:12px;">Blessure:</strong>
      <?php if(!empty($rowp->wound)) echo $rowp->wound;?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">Orientation:</strong>
      <?php if(!empty($rowp->core)) echo $rowp->core; ?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">terminer:</strong>
      <?= $rowp->finish ?>
    </span> 
   
    <?php } ?>

  </td>
               
  <td class="text-center invoicetable_tabel_border" align="center"> 
    <?php 
    if ($custominfo['format'] != 'Roll'){
    ?>
    <?=$symbol ?>5.32
    <br>
    Pour la conception
    <?php
    }
    ?>
  </td>
  <td class="text-center invoicetable_tabel_border" align="center">
    <?php 
    if($AccountDetail->regmark != 'Y' && $custominfo['format'] != 'Roll'){ 
      $des=  ($rowp->designs > 1 )?"Dessins":"Dessin";
      echo $rowp->designs.' '.$des;
                    
    ?>
               
    <?  }?>
    <br>

  </td>
          
  
    <td class="text-center invoicetable_tabel_border" align="center"><?=$symbol ?><?= number_format(($AccountDetail->Print_Total * $exchange_rate), 2) ?></td>
             
</tr>
                          <?php } ?>

<? } ?>



