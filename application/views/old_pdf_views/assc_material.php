<?



$assoc = $this->user_model->fetch_custom_die_association($custominfo['ID']);
	        foreach($assoc as $rowp){ 

?>
<? $materialprice = $rowp->plainprice+$rowp->printprice; ?>
<? $materialpriceinc = $materialprice*1.2; ?>

             <tr>
                <td class="invoicetable_tabel_border"><b><?=$rowp->material?></b></td>
                <td class="invoicetable_tabel_border">

                    <?=$this->user_model->get_mat_name($rowp->material);?> - <?=$rowp->labeltype?> Labels


                    <?  if($rowp->labeltype=="printed"){
                         echo $rowp->printing.' - '.$rowp->designs.' Designs ';

						    if($custominfo['format']=="Roll"){
                             echo ' <br> with label finish '.$rowp->finish;
                            }
                    }
				   ?>


                  <? if($custominfo['format']=="Roll"){
         echo ' - '.$rowp->rolllabels.' labels - core size '.$rowp->core.' mm - '.$rowp->wound.' wound';
       }
				 ?>

               </td>
               <? if(isset($show_price_promise_line) && $show_price_promise_line==1){?>
                 <td class="invoicetable_tabel_border" align="center"></td>
               <? } ?>
               
               <?php $sho = ''; if($custominfo['format'] =='Roll'){ $sho =  $rowp->rolllabels;} else { $sho =  ((($custominfo['across'] * $custominfo['around']) * $rowp->qty) );} ?>
                          
              
               
               <td class="invoicetable_tabel_border" align="center"><?=$symbol ?><?= number_format(($materialprice / $sho) * $exchange_rate,4 ) ?></td>
               
               <td class="invoicetable_tabel_border" align="center">
                <?=$rowp->qty;?>
                 <?php if($custominfo['format']=="Roll"){
                    echo ($rowp->qty > 1)?'Rolls':'Roll';
                 }else{
                    echo ($rowp->qty > 1)?'Sheets':'Sheet';
                  }?>
                 <br>
                 
                 <?php if($custominfo['format'] =='Roll'){ echo $rowp->rolllabels.' labels';} else { echo (($custominfo['across'] * $custominfo['around'] * $rowp->qty) ).' labels';}  ?>
                
                
               </td>

            
            <td class="invoicetable_tabel_border" align="center"><? echo $symbol."".(number_format($materialprice * $exchange_rate,2));?></td>
         </tr>

                 <?  $print_exvat+= $materialprice;   $print_incvat+= $materialpriceinc;  ?>


<?php if(($rowp->labeltype == 'printed' && $custominfo['format'] != 'Roll') || ($custominfo['format'] == 'Roll' )){ ?>   

<?php //echo '<pre>'; print_r($assoc);  ?>

  <tr>
  <td class="invoicetable_tabel_border"></td>
  <td class="invoicetable_tabel_border">
    <i class="mdi mdi-check"></i><span>
    <?php 
                                      
    if($rowp->printing=="Mono"){ ?>
      <?php $rowp->printing = "Black Only"; ?>
    <?php } ?>
    
    <?= $rowp->printing ?>
    </span>
    <?php if ($rowp->designs > 0) { ?>
    <i class="mdi mdi-check"></i> <span>
    <?php $des = ($assoc[0]->designs > 1 )?"Designs":"Design"; ?>
    <?= $rowp->designs .' '. $des ?>
    </span>
    <?php } ?>
    <?php 
                      
    if ($custominfo['format'] == 'Roll') { ?>
    <span class="invoice-bold">
      <strong style="font-size:12px;">Wound:</strong>
      <?php if(!empty($rowp->wound)) echo $rowp->wound;?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">Orientation:</strong>
      <?php if(!empty($rowp->core)) echo $rowp->core; ?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">Finish:</strong>
      <?= $rowp->finish ?>
    </span> 
   
    <?php } ?>

  </td>
    
    
    <?php 
       $word = "AAQ";
       if(strpos($AccountDetail->QuotationNumber, $word) !== false){ ?>
    <td class="text-center invoicetable_tabel_border" ></td>
    <?php } ?>
      
  <td class="text-center invoicetable_tabel_border" align="center">
   <?php 
    if ($custominfo['format'] != 'Roll'){
    ?>
    <?=$symbol ?>5.32
    <br>
    Per Design
    <?php
    }
    ?>

  </td>
          
  <td class="text-center invoicetable_tabel_border" align="center"> <?php 
    if($AccountDetail->regmark != 'Y' && $custominfo['format'] != 'Roll'){ 
      $des=  ($rowp->designs > 1 )?"Designs":"Design";
      echo $rowp->designs.' '.$des;
                    
    ?>
               
    <?  }?></td>
    <td class="text-center invoicetable_tabel_border" align="center"><?=$symbol ?><?= number_format(($AccountDetail->Print_Total * $exchange_rate), 2) ?></td>
             
</tr>
                          <?php } ?>


       <? } ?>


 

