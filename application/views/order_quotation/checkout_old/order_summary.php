<?
		   	  
			  	$texvat = $this->shopping_model->total_order();

		    	$wtp_discount = $this->shopping_model->wtp_discount_applied_on_order();
				
				$valid_voucher = $this->session->userdata('valid_voucher'); 
				
				$discount_offer = 0.00;
				
				
				if($valid_voucher=='yes'){
					$voucher = $this->shopping_model->order_discount_applied();
					if(isset($voucher['discount_offer'])){
						$discount_offer = $voucher['discount_offer'];
					}
				}
				else if($wtp_discount){
						$discount_offer = $wtp_discount['discount_offer'];
				}
				
		      
			  
			  //$ServiceName = $this->session->userdata('ServiceName');
			  $ServiceID = $this->session->userdata('ServiceID');
			  if($ServiceID=='' &&  empty($ServiceID)){
				 $ServiceID = 21;  
			  }
			  $ship_info =  $this->shopping_model->get_shipping($ServiceID);
			  $ServiceName = $ship_info['ServiceName'];
              $BasicCharges = $this->session->userdata('BasicCharges'); 
		 		
			 $texvat= $texvat*1.2;
			 $texvat = $texvat - $discount_offer;
			 
			 $texvat = $this->home_model->currecy_converter($texvat, 'no');
			 $BasicCharges = $this->home_model->currecy_converter($BasicCharges, 'no');
		 ?>


                
<?php 
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>   


<div class="panel-default fa-border " style="border: 1px solid #d0effa;margin-top: 5px;">
  <table class="table">
    <tbody>
      <tr >
        <td class="borderR0">Sub Total<br></td>
        <td class="borderR0" style="text-align:right;"><h4 class="" style="font-size: 14px;"><?php echo $symbol.number_format(($texvat*$exchange_rate),2,'.','');
                $this->session->set_userdata('Qtotal',$texvat);
        ?></h4></td>
      </tr>
      <tr>
        <td class="" ><?=$ServiceName?></td>
        <td style="text-align:right;"><h4 class="" style="font-size: 14px;">
            <? ?>
            <?=$symbol.number_format(($BasicCharges*$exchange_rate),2,'.',''); ?>
          </h4>
            <input type="hidden" name="shippingCharges" value="<?=$BasicCharges?>">
        </td>
      </tr>
      <? $vat_exemption_charges = 0.00;
							 	
								
								
								$vat_exemption = $this->session->userdata('vat_exemption');
								if(isset($vat_exemption) and $vat_exemption=='yes'){
									$vat_exemption_charges = $texvat+$BasicCharges - ($texvat+$BasicCharges)/1.2;


								?>
      <tr>
        <td class="" >Exempt VAT Charges</td>
        <td style="text-align:right;"><h3 class="" style="font-size: 14px;"> -
            <?=$symbol.number_format(($vat_exemption_charges*$exchange_rate),2,'.','');
            $this->session->set_userdata('vat_exemption_charges',$vat_exemption_charges);

            ?>
          </h3></td>
          <input type="hidden" name="vat_exemption_charges" value="<?=symbol.number_format($vat_exemption_charges,2,'.','');?>"
      </tr>
      <? } ?>
      <tr>
        <td class="textOrange" style="border-bottom: none;">Total (
          <?=$currency?>
          )</td> <? $finaltotalprice = $BasicCharges+$texvat-$vat_exemption_charges;?>
        <td style="text-align:right;border-bottom: none;"><h3 class="textOrange" style="font-size: 15px;font-weight: bold;"><?php echo $symbol.number_format(($finaltotalprice*$exchange_rate),2,'.',''); ?></h3></td>
      </tr>
    </tbody>
  </table>
</div>
