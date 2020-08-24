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
//print_r($scorecord['format']);exit;

$assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
$asformat = ($scorecord['format'] == "Roll") ? "roll" : "sheet";


//echo '<pre>'; print_r($assoc); echo '</pre>';
?>


<? foreach ($assoc as $rowp) {
    $eprintoption = ($rowp->labeltype == "printed") ? "display:block" : "display:none"; ?>


    <!-- --------------------------------------------------->  <!-- --------------------------------------------------->

        <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
        <? $materialpriceinc = $materialprice * 1.2;


    $subtotal = $subtotal +$materialprice;
        ?>
    <tr>
      
        <td></td>
        <td><?= $rowp->material ?>-<?= $this->user_model->get_mat_name($rowp->material); ?></td>
        <td></td>
        <td><?= $rowp->qty ?><br>
         <?php 
                           if($carRes[0]->format == 'Roll'){
                          echo "Roll";
                              }else{
                          echo "Sheet";
                          }
                         ?>
         
        </td>
        <td><?=$symbol ?><?=number_format($materialprice,2)?></td>
    </tr>
<?php } ?>
