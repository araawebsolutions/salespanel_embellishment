

<tr class="<?=@$clr_class?>">
  <?php if($this->uri->segment(3)!='generateorder'){ ?>
  <td></td>
  <?php } ?>
  
  <td class="text-center labels-form ">      
    <?php if ($quotationDetail->qp_foc == 'Y')     {     echo 'Press Proof - Foc';} ?>
    <?php if ($quotationDetail->qp_foc == 'other') {     echo $quotationDetail->qp_foc;} ?>
    <?php if ($quotationDetail->qp_foc != 'Y' && $quotationDetail->qp_foc != 'other') {
     echo 'Up to '.$quotationDetail->qp_qty.' Designs ';} ?>
  </td>
  
  <td colspan="1" align="left">Physical Press Proof, Pre-Press Approval Required</td>
                                        
  <td class="text-center">
    <?php if($quotationDetail->qp_price!=0){ ?>
    <?=$symbol?><?=number_format(($quotationDetail->qp_price / $quotationDetail->qp_qty) * $exchange_rate,2,'.',''); ?> <br>each
    <?php } else { ?>
    <?=$symbol?><?='0.00'; ?>
    <?php } ?>
  </td>
  
  <td class="text-center">
    <?=$quotationDetail->qp_qty;?> Press Proof
  </td>
  
  <td class="text-center">
    <?=$symbol?><?=($quotationDetail->qp_price !="")?number_format($quotationDetail->qp_price * $exchange_rate,2,'.','') : '0.00' ?>
  </td>
  
  <?php if($this->uri->segment(3)!='generateorder'){ ?>
  <td  class="text-center icon-tablee"></td>
  <?php } ?>
</tr>  
