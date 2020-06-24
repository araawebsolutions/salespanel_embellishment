<style>
    .cursor {
        margin-left: 10px;
        color: blue;
        cursor: pointer;
    }

    .matstyle {
        width: 150px;
        margin-left: 5px;
    }

    .hide {
        display: none;
    }
</style>


<?//
//$currency = currency;
//$symbol = symbol;
//$exchange_rate = $this->user_model->get_exchange_rate($currency);
//?>
<?


$scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
//print_r($scorecord);exit;

$assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
$asformat = ($scorecord['format'] == "Roll") ? "roll" : "sheet";


//echo '<pre>'; print_r($assoc); echo '</pre>';
?>


<? foreach ($assoc as $rowp) {
    $eprintoption = ($rowp->labeltype == "printed") ? "display:block" : "display:none"; 
    $eprintoptionclass = (($rowp->labeltype == "printed" && $asformat != "roll") || ($asformat == "roll")) ? "" : "display:none"; ?>


    <!-- --------------------------------------------------->  <!-- --------------------------------------------------->

        <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
        <? $materialpriceinc = $materialprice * 1.2;


    $subtotal = $subtotal +$materialprice;
        ?>

<?php $sho = ''; if($carRes[0]->format =='Roll'){ $sho =  $rowp->rolllabels;} else { $sho =  ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate);} ?>


    <tr>
      <td></td>
      <td></td>
      <td><?= $rowp->material ?>-<?= $this->user_model->get_mat_name($rowp->material); ?></td>
      <td align="center"><?=$symbol ?><?= number_format(($materialprice / $sho) * $exchange_rate,2 ) ?></td>
      <td align="center">
        <?= $rowp->qty ?>
        <?php 
          if($carRes[0]->format == 'Roll'){
            echo ($rowp->qty > 1)?"Rolls":"Roll";
          }else{
            echo ($rowp->qty > 1)?"Sheets":"Sheet";
          }
        ?>
        <br>
        <?php if($carRes[0]->format =='Roll'){ echo $rowp->rolllabels.' labels';} else { echo ((($carRes[0]->across * $carRes[0]->around) * $rowp->qty) * $exchange_rate).' labels';} ?>
         
      </td>
        <td align="center"><?=$symbol ?><?=number_format($materialprice,2)?></td>
    </tr>


<tr style="<?=$eprintoptionclass?>">
  <td></td>
  <td></td>
  <td>
    <i class="mdi mdi-check"></i><span>
    <?php 
                                      
    if($rowp->printing=="Mono"){ ?>
      <?php $rowp->printing = "Black Only"; ?>
    <?php } ?>
    
    <?= $rowp->printing ?>
    </span>
    <?php if ($rowp->designs > 0) { ?>
    <i class="mdi mdi-check"></i> <span>
    <?php $des = ($rowp->designs > 1 )?"Designs":"Design"; ?>
    <?= $rowp->designs .' '. $des ?>
    </span>
    <?php } ?>
    <?php 
                      
    if ($asformat == 'roll') { ?>
    <span class="invoice-bold">
      <strong style="font-size:12px;">Wound:</strong>
      <?php if(!empty($rowp->wound)) echo $rowp->wound;?>
    </span> 
    <span class="invoice-bold">
      <strong style="font-size:12px;">Orientation:</strong>
      <?php if(!empty($rowp->core)) echo $rowp->core; ?>
    </span> 
    
    <?php if(!empty($rowp->finish)){?>
    <span class="invoice-bold">
      <strong style="font-size:12px;">Finish:</strong>
      <?= $rowp->finish ?>
    </span> 
   <?php } ?>
    <?php } ?>

  </td>
               
  <td class="text-center"> 
    <?php 
    if ($asformat != 'roll'){
    ?>
    <?=$symbol ?>5.32
    <br>
    Per Design
    <?php
    }
    ?>
  </td>
  <td class="text-center">
    <?php 
    if($record->regmark != 'Y' && $asformat!="roll"){ 
      $des=  ($rowp->designs > 1 )?"Designs":"Design";
      echo $rowp->designs.' '.$des;
                    
    ?>
               
    <?  }?>
    <br>
    <?php
    if ($asformat != 'roll'){
      if($record->Quantity <= 99 ){
        echo "(1 Design Free)";
      }elseif ($record->Quantity <= 199){
        echo "(2 Designs Free)";
      }elseif ($record->Quantity <= 299) {
        echo "(3 Designs Free)";
      }elseif ($record->Quantity <= 399) {
        echo "(4 Designs Free)";
      }elseif ($record->Quantity <= 499) {
        echo "(5 Designs Free)";
      }elseif ($record->Quantity <= 999) {
        echo "(6 Designs Free)";
      }elseif ($record->Quantity <= 2499) {
        echo "(7 Designs Free)";
      }elseif ($record->Quantity <= 4999) {
        echo "(8 Designs Free)";
      }elseif ($record->Quantity <= 9999) {
        echo "(9 Designs Free)";
      }elseif ($record->Quantity <= 14999) {
        echo "(10 Designs Free)";
      }elseif ($record->Quantity <= 19999) {
        echo "(11 Designs Free)";
        }elseif ($record->Quantity <= 29999) {
        echo "(12 Designs Free)";
      }elseif ($record->Quantity <= 39999) {
        echo "(13 Designs Free)";
      }elseif ($record->Quantity <= 40000) {
        echo "(14 Designs Free)";    
      }
    }
    
    ?>
  </td>
          
  <td class="text-center"><?=$symbol ?><?= number_format(($record->Print_Total * $exchange_rate), 2) ?></td>
             
</tr>

<?php } ?>

 

          