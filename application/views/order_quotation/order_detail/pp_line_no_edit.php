

<tr class="<?=$clr_class?>">
  
  <td class="text-center labels-form " style="color:#333">     
    <strong>
    <?php if ($orderDetail->odp_foc == 'Y')     {     echo 'Press Proof - Foc';} ?>
    <?php if ($orderDetail->odp_foc == 'other') {     echo $orderDetail->odp_foc;} ?>
    <?php if ($orderDetail->odp_foc != 'Y' && $orderDetail->odp_foc != 'other') {
     echo 'Up to '.$orderDetail->odp_qty.' Designs ';} ?>
      </strong>
  </td>
  
  <td colspan="1">Physical Press Proof, Pre-Press Approval Required</td>
                                        
  <td class="text-center">
    <?php if($orderDetail->odp_price!=0){ ?>
    <?=$symbol?><?=number_format(($orderDetail->odp_price / $orderDetail->odp_qty) * $exchange_rate,2,'.',''); ?> <br> each
    <?php } else { ?>
    <?=$symbol?><?='0.00'; ?>
    <?php } ?>
  </td>
  
  <td class="text-center">
    <?=$orderDetail->odp_qty;?> Press Proof
  </td>
  
  <td class="text-center">
    <?=$symbol?><?=($orderDetail->odp_price !="")?number_format($orderDetail->odp_price * $exchange_rate,2,'.','') : '0.00' ?>
  </td>
  
  <?php if($this->uri->segment(3)=='getOrderDetail'){ ?>
  <td></td>
  <?php  } ?>
</tr>  