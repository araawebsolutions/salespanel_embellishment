<tr>
  <td></td>
  <td>      
    <label class="select">
      <select name="qfoc" id="qfoc<?= $key ?>" tabindex="10" class="form-control">
        <option value="">Please Choose</option>
        <option value="Y" <?php if ($quotationDetail->qp_foc != '' && $quotationDetail->qp_foc == 'Y') { ?> selected<? } ?>>
          Press Proof - FOC
        </option>
                                               
      </select>
      <i></i>
    </label>
  </td>
  
  <td colspan="1">Physical Press Proof, Pre-Press Approval Required</td>
                                        
  <td class="text-center">
                                          
    <?php if($quotationDetail->qp_price!=0){ ?>
    <?=$symbol?><?=number_format($quotationDetail->qp_price / $quotationDetail->qp_qty,2,'.',''); ?>
    <?php } else { ?>
    <?=$symbol?><?='0.00'; ?>
    <?php } ?>
  </td>
  
  <td class="text-center">
    <input placeholder="Press Proof Qty" class="form-control input-number text-center allownumeric" value="<?=$quotationDetail->qp_qty;?>" id="pressQty_<?=$key?>">
  </td>
  
  <td class="text-center">
    <?=$symbol?><?=($quotationDetail->qp_price !="")?number_format($quotationDetail->qp_price,2,'.','') : '0.00' ?>
  </td>
  <td  class="text-center icon-tablee">
                                            
  <?php 
    $tilte = 'Add Press Proof';
    if($quotationDetail->qp_proof =='Y'){
      $tilte = 'Update Press Proof';
  ?>
    <i class="fa fa-trash-o bt-delete" onclick="deletepressproof(<?= $quotationDetail->SerialNumber ?>)" title="Remove Press Proof"></i>
    <?php  } ?>
                                          
    <i class="fa fa-floppy-o bt-save" id="qfoc_icon<?= $key ?>" onclick="insertQuotationPressProofPrice(<?= $key ?>,<?=$quotationDetail->SerialNumber ?>,'insert',<?=$exchange_rate?>,'<?=$quotation->QuotationNumber;?>',<?=$quotation->UserID ?>)" title="<?=$tilte?>"></i>
  </td>
</tr>  