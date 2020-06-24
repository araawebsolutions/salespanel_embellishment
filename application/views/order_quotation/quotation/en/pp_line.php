<tr>
  <td class="invoicetable_tabel_border" >
   
    <?php if ($AccountDetail->qp_foc == 'Y')     {     echo 'Press Proof - Foc';} ?>
    <?php if ($AccountDetail->qp_foc == 'other') {     echo $AccountDetail->qp_foc;} ?>
    <?php if ($AccountDetail->qp_foc != 'Y' && $AccountDetail->qp_foc != 'other') {
     echo 'Up to '.$AccountDetail->qp_qty.' Designs';} ?>
          
  </td>
  
  
  

  <td class="invoicetable_tabel_border">Physical Press Proof, Pre-Press Approval Required</td>
  
  
  <td class="invoicetable_tabel_border"></td>
                                        
  <td class="text-center invoicetable_tabel_border" align="center">
    <?php if($AccountDetail->qp_price!=0){ ?>
    <?=$symbol?><?=number_format(($AccountDetail->qp_price / $AccountDetail->qp_qty) * $exchange_rate ,2,'.',''); ?> <br> each
    <?php } else { ?>
    <?=$symbol?><?='0.00'; ?>
    <?php } ?>
  </td>
  
  <td class="invoicetable_tabel_border" align="center">
    <?=$AccountDetail->qp_qty;?> <br>Press Proof 
  </td>
  
  <td class="text-center invoicetable_tabel_border" align="center">
    <?=$symbol?><?=($AccountDetail->qp_price !="")?number_format($AccountDetail->qp_price * $exchange_rate,2,'.','') : '0.00' ?>
  </td>

</tr>  