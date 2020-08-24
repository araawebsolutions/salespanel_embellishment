<tr class="<?=$clr_class?>">
  <td></td>
  <td class="text-center labels-form ">      
    <label class="select" >
      <select name="qfoc" id="qfoc<?= $key ?>" data-qkey= "<?= $key ?>" class="form-control qfoc">
        <option value="">Please Choose</option>
        <option value="Y" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == 'Y') { ?> selected<? } ?>>
          Press Proof - FOC
        </option>
        <option value="2" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == '2') { ?> selected<? } ?>>
          Up to 2 designs £50.00
        </option>
        <option value="4" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == '4') { ?> selected<? } ?>>
          Up to 4 designs £80.00
        </option>
        <option value="6" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == '6') { ?> selected<? } ?>>
          Up to 6 Designs £110.00
        </option>
        <option value="8" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == '8') { ?> selected<? } ?>>
          Up to 8 Designs £136
        </option>
        <option value="10" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == '10') { ?> selected<? } ?>>
          Up to 10 Designs £155
        </option>
        <option value="other" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == 'other') { ?> selected<? } ?>>
          Others (each Press £12.90)
        </option>
        




                                               
      </select>
      <i></i>
    </label>
  </td>
  
  <td colspan="1">Physical Press Proof, Pre-Press Approval Required</td>
                                        
  <td class="text-center">
                                          
    <?php if($quotationDetail->qp_price!=0){ ?>
    <?=$symbol?><?=number_format(($quotationDetail->qp_price / $quotationDetail->qp_qty) * $exchange_rate,2,'.',''); ?> <br>each
    <?php } else { ?>
    <?=$symbol?><?='0.00'; ?>
    <?php } ?>
  </td>
  
  <td class="text-center">
    <input placeholder="Press Proof Qty" class="form-control input-number text-center allownumeric" value="<?=$quotationDetail->qp_qty;?>" id="pressQty_<?=$key?>" <?php if ($quotationDetail->qp_foc != 'Y' && $quotationDetail->qp_foc != 'other') { ?> disabled<? } ?>>
  </td>
  
  <td class="text-center">
    
    <?=$symbol?><?=($quotationDetail->qp_price !="")?number_format($quotationDetail->qp_price * $exchange_rate,2,'.','') : '0.00' ?>
  </td>
  <td  class="text-center icon-tablee">
                                            
  <?php 
    $tilte = 'Add Press Proof';
    if($quotationDetail->qp_proof =='Y'){
      $tilte = 'Update Press Proof';
  ?>
    <i class="fa fa-trash-o bt-delete" onclick="deletepressproof('<?= $quotationDetail->SerialNumber ?>','quotation_page')" title="Remove Press Proof"></i>
    <?php  } ?>
                                          
    <i class="fa fa-floppy-o bt-save" id="qfoc_icon<?= $key ?>" onclick="insertQuotationPressProofPrice(<?= $key ?>,<?=$quotationDetail->SerialNumber ?>,'insert',<?=$exchange_rate?>,'<?=$quotation->QuotationNumber;?>',<?=$quotation->UserID ?>,'quotation_detail')" title="<?=$tilte?>"></i>
  </td>
</tr>  