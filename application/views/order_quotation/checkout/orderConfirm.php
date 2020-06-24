<div class="bgGray">
  <div class="container">
    <div class="panel">
      <div class="row">
        <div class="col-xs-12  col-sm-8 col-md-7">
            <h3 style="padding-left: 13px;">Order Confirmation</h3>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-5 p-l-r-15">
          <div class="pull-right">
              
          	 		<?php
			$redirect_from = $this->session->userdata('redirect_from');
			if(isset($redirect_from) and $redirect_from == "plo"):?>
                        <a role="button" class="btn orange pull-right" href="<?=base_url()?>trade/printed-labels/">
             		<i class="fa fa-arrow-circle-left faa-horizontal animated"></i>&nbsp; Continue Shopping</a> 
                    
           <?php else:?>
            <a role="button" class="btn orange pull-right" href="<?=base_url()?>">
             		<i class="fa fa-arrow-circle-left faa-horizontal animated"></i>&nbsp; Continue Shopping</a> 
			<?php endif;?>
             		
             		
              </div>
        </div>
      </div>
    </div>
    
    <!-- Checkout -->
    
    <div class=" thumbnail">
  		  <ul class="nav orderStep setup-panel">
                <li class="active"><a>
                    <i class="fa fa-check-circle p-t-b"></i>
                    <p class="list-group-item-text">Billing</p>
                </a></li>
                <li class="active"><a>
                    <i class="fa fa-check-circle p-t-b"></i>
                    <p class="list-group-item-text">Delivery</p>
                </a></li>
                <li class="active"><a>
                    <i class="fa fa-check-circle p-t-b"></i>
                    <p class="list-group-item-text">Shipping</p>
                </a></li>
                 <li class="active"><a>
                    <i class="fa fa-check-circle p-t-b"></i>
                    <p class="list-group-item-text">Review &amp; Pay</p>
                </a></li>
                 <li class="active"><a>
                    <i class="fa fa-check-circle p-t-b"></i>
                    <p class="list-group-item-text">Confirmation</p>
                </a></li>
            </ul>
            
            
      <div class="">
        <div class="setup-content" id="step-5">
          <form novalidate action="852" method="post" enctype="text/plain" id="8524" class="">
            <div class="">
              
              <div class="col-sm-12">
              <h4 class="m-t-b-8 m-l-20 cBlue">Order Number:
                <?=$order['OrderNumber']?>
              </h4>
               
               <?  if($order['PaymentMethods']=='chequePostel'){?>
                
                <p class="m-l-20"> Thank you for purchasing from AA Labels and we confirm that your order has been received and is pending payment by bank transfer. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.</p>
              
                <p  class="m-l-20" style="font-size:12px;">
                		<strong>Account Name:</strong> Green Technologies Limited Trading as AA Labels<br />
                    	<strong>Sort Code:</strong> 40-36-15<br />
                    	<strong>A/c No:</strong> 52385724<br />
                    	<strong>IBAN:</strong> GB87MIDL40361552385724<br />
                    	<strong>SWIFT/BIC:</strong> HBUKGB4108R</p>
			   
			 <? } else if($order['PaymentMethods']=='purchaseOrder'){?>
              <p  class="m-l-20">Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending approval of your purchase order. Upon acceptance of payment by PO your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.</p>
             
              <? } else if($order['PaymentMethods']=='PayPal eCheque'){?>
              <p  class="m-l-20">Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending confirmation of your e-cheque payment from PayPal. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.</p>
             
			 <?   }else{?>
               
			   
			   <p  class="m-l-20">Thank you for purchasing from AA Labels and we confirm that your order has been received and is being processed for production. Upon completion of your order you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.</p>
                
			   <? } ?> 
               
               
                <p class="m-l-20">To manage your payment information open your account from the top of the page and select “My Account” from the drop-down menu and then “Billing Method” from the navigation bar. You can then add, delete and edit the stored card information, held on a secure server by our payment gateway provider. These details are not known to AA Labels or shared with any third-party, other than the card provider for payment verification.</p>
              </div>
              <div class="">
                <div class="col-sm-8 m-t-10">
                  <div class="table-responsive ">
                    <table class="table table-bordered table-hover">
                      <thead class="bgBlueHeading">
                        <tr>
                          <th style="width:10%;text-align:center;">Image</th>
                          <th style="width:36%;text-align:center; ">Code / Description</th>
                          <th style="width:12%;text-align:center;">Ex. Vat </th>
                          <th style="width:12%;text-align:center;">Inc. Vat</th>
                          <th  style="width:12%;text-align:center;">Qty</th>
                        </tr>
                      </thead>
                      <tbody>
					<? 
                      $ex_vat='';$inc_vat='';$store_prd=''; $ecom_productinfo = '';
                      foreach($order_detail as $pro){
							
						$gts_i_price = $pro['ProductTotal']+($pro['Print_Total']*1.2); 
						$A4Printing = '';$colorcode = '';
						if($pro['Printing']=='Y'){
							$A4Printing = $this->home_model->get_printing_service_name($pro['Print_Type']);
						 }
						
						 $image = $this->shopping_model->customize_image_name($pro['ProductID']);           
						 $image =str_replace(".gif",".png",$image[0]['Image1']);
						//new code
						 $img_class = 'img-circle'; 
						 $img_width = '25';
						 $path = Assets."images/material_images/".$image;
						 
						 $path = Assets."images/material_images/".$image;  
						 if (ctype_digit(substr($pro['ManufactureID'],-4)) and $pro['ProductID'] != 0) {
								$colorcode = (isset($pro['colorcode']) and $pro['colorcode']!='')?'-'.$pro['colorcode']:'';
                                 $desingcode = substr($pro['ManufactureID'], -4);
								$path = Assets."images/application/design/".$desingcode.$colorcode.'.png';
								$img_class = 'img-Sheet'; 
								$img_width = '60';
						 }
						 
						 
						 
						 $pro['Price'] = $this->home_model->currecy_converter($pro['Price'],'no');
						 $pro['ProductTotal'] = $this->home_model->currecy_converter($pro['ProductTotal'],'no');
						 
						 //newcode
						  $files = $this->home_model->get_integrated_attachments($pro['SerialNumber']);
                          if($files['Thumb']!=""){
							 $path = AJAXURL.'designer/media/thumb/'.$files['Thumb'];
							 $img_width = '46';
							 $img_class= '';
						  }
						  ?>
                         
                        <tr>
                          <th <?=($pro['Printing']=='Y')?'rowspan="2"':''?> class="">
                          <img class="<?=$img_class?>" src="<?=$path?>" width="<?=$img_width?>" height=""> </th>
                          <td>
                          		<h4><?=$pro['ManufactureID']?></h4>
                                <p><?=$pro['ProductName']?>
									<? //new code
									    if($files['file']!=""){ $pdf = AJAXURL.'theme/integrated_attach/'.$files['file'];?>
                                        <a href="#" data-target=".designer" data-toggle="modal" class="btn blue2 btn-sm ld_download" data-value="<?=$pdf?>"> 
                                        <i class="fa fa-download"></i> Download Artwork</a>
                                     <? } ?>
                               </p>
                          </td>
                         
                         
                          <td style="text-align:center; vertical-align:middle";>
                          		<strong><?=symbol.number_format($pro['Price'],2,'.','');?></strong>
                          </td>
                          <td style="text-align:center; vertical-align:middle";>
                          		<strong><?=symbol.number_format($pro['ProductTotal'],2,'.','');?></strong>
                          </td>
                          
                          
          
                         <td style="text-align:center; vertical-align:middle";><strong><?=$pro['Quantity']?></strong></td>
                        </tr>
                        
                         <? if($pro['Printing']=='Y'){
							$pro['Print_Total'] = $this->home_model->currecy_converter($pro['Print_Total'],'no');
                            
							$pro['Price'] = $pro['Price']+$pro['Print_Total'];
                            $pro['ProductTotal'] = $pro['ProductTotal']+($pro['Print_Total']*1.2);  ?>
                            <tr>
                                <td>
                                      <h4><?=$A4Printing?></h4>
                               </td>	
                                
                                <? if(preg_match('/Printed Labels on Rolls/is',$pro['ProductName'])){
											echo '<td colspan="2" style="text-align:center;"></td>';
								}else{?>
                                         <td style="text-align:center;">
                                     		<strong><?php echo symbol.number_format(($pro['Print_Total']), 2, '.', ''); ?></strong>
                                   		 </td>
                                    	<td>
                                        <strong><?php echo symbol.number_format(($pro['Print_Total']*1.2), 2, '.', ''); ?></strong>
                                    	</td>
                                <? } ?>
                                
                               
                                
                                
                                
                            </tr>
                  	 <? } ?> 
                   
                   
               <? 		 $ex_vat+=$pro['Price']; 
						 $inc_vat+=$pro['ProductTotal'];
						
						 $store_prd .= '<span class="gts-i-name">'.$pro['ProductName'].'</span>';
						 $store_prd .= '<span class="gts-i-price">'.$gts_i_price.'</span>';
						 $store_prd .= '<span class="gts-i-quantity">'.$pro['Quantity'].'</span>';  
						 
						 
						 
						 
						 if($pro['ProductID']!=0){
						 	 	 $ProductBrand = $this->shopping_model->GetProductBrand($pro['ProductID']);
								 $ProductBrand = $ProductBrand['ProductBrand'];
						 }else{
						 		 $ProductBrand = 'Custom Labels';
						 }
						 
						 $gts_ex_price = number_format(($gts_i_price/1.2),2,'.','');
						 
						 
						$pro['ProductName'] = str_replace("<span style='color:#fd4913;'>( 20% discount) </span>", "20% discount", $pro['ProductName']);
					    $pro['ProductName'] = str_replace("<span style='color:#fd4913;'>( 40% discount) </span>", "40% discount", $pro['ProductName']);
						$pro['ProductName'] = str_replace("'", "", $pro['ProductName']);
						 
						
						if(preg_match("/Sample/is", $pro['ProductName']) and $gts_ex_price == 0){
							 	$ProductBrand = 'Material Sample';
						}
						
						
						 
						 $ecom_productinfo .=  "{  'id': '".$pro['ProductID']."',
													'name': '".$pro['ProductName']."',
													'brand': 'AALabels',
													'category': '".$ProductBrand."',
													'price': ".$gts_ex_price.",
													'quantity': '".$pro['Quantity']."', 
												  },";
												  
												  
												  
												  
			}?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-sm-4 m-t-10">
                  <div class="bgOrangeHeading">
                    <div> <i class="fa f-20 fa-calculator "></i> Cart Summary </div>
                  </div>
                  <div class="borderPanel">
                    <div class="Lblue ">
                      <div class="row">
                        <div class="">
                          <div class="pull-left">
                            <div>Sub Total</div>
                          </div>
                          <div class="pull-right"> <i class="fa f-20 fa-cart-plus"></i> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row p-t-b-12">
                      <div class="">
                        <div class="pull-left">
                          <p>Ex. Vat</p>
                          <h2><?=symbol.number_format($ex_vat,2,'.','');?></h2>
                        </div>
                        <div class="pull-right">
                          <p>Inc. Vat</p>
                           <h2><?=symbol.number_format($inc_vat,2,'.','');?></h2>
                        </div>
                      </div>
                    </div>
                    <? $shipping = $this->home_model->currecy_converter($order['OrderShippingAmount'],'no');?>
                    <div class="Lblue ">
                      <div class="row">
                        <div class="">
                          <div class="pull-left">
                            <div>Delivery Charges</div>
                          </div>
                          <div class="pull-right"> <i class="fa f-20 fa-truck"></i> </div>
                        </div>
                      </div>
                    </div>
                    <? $result=$this->shopping_model->get_shipping($order['ShippingServiceID']);?>
                    <div class="row p-t-b-12">
                      <div class="">
                        <div class="pull-left">
                          <p>Ex. Vat</p>
                          <h2><? echo symbol.number_format($shipping/1.2,2);?></h2>
                        </div>
                        <div class="pull-right">
                          <p>Inc. Vat</p>
                          <h2><? echo symbol.number_format($shipping,2);?></h2>
                        </div>
                        <p class="text-center col-sm-12 textOrange">
                          <?=$result['ServiceName']?>
                        </p>
                      </div>
                    </div>
                    <?  $discount =0; if($order['voucherOfferd']=="Yes"){
						$discount = $this->home_model->currecy_converter($order['voucherDiscount'],'no');
					 ?>
                    
                    <!--  ------------------------------------------->
                    <div class="Lblue ">
                      <div class="row">
                        <div class="">
                          <div class="pull-left">
                            <div>Discount</div>
                          </div>
                          <div class="pull-right"> <i class="fa f-20 fa-tag"></i> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row p-t-b-12">
                      <div class="">
                        <div class="pull-left">
                          <p></p>
                          <h2><?=symbol.number_format($discount,2,'.','')?></h2>
                        </div>
                        <div class="pull-right">
                           <p></p>
                          <h2></h2>
                        </div>
                      </div>
                    </div>
                    <? }
                    $total=$inc_vat+$shipping-$discount;
					if(isset($order['vat_exempt']) and $order['vat_exempt']=="yes"){
					  $vat_exempt_charges = $total - ($total/1.2);
					  $total = $total - $vat_exempt_charges;
						  ?>
										 
							<div class="Lblue ">
							  <div class="row">
								<div class="">
								  <div class="pull-left">
									  <div>Exempt VAT Charges</div>
								   </div>
								  <div class="pull-right"> <i class="fa f-20 fa-tag"></i> </div>
								</div>
							  </div>
							</div>
							<div class="row p-t-b-12">
							  <div class="">
								<div class="pull-left">
								  <p></p>
								  <h2>-<?=symbol.number_format($vat_exempt_charges,2,'.','');?></h2>
								</div>
								<div class="pull-right">
								  <p></p>
								  <h2></h2>
								</div>
							  </div>
							</div>
				   <? } ?>  
                    <div class="Lblue ">
                      <div class="row">
                        <div class="">
                          <div class="pull-left">
                            <div>Grand Total</div>
                          </div>
                          <div class="pull-right"> <i class="fa f-20 fa-calculator"></i> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row p-t-b-12">
                      <div class="">
                        <div class="pull-left">
                          <p class="hide">Ex. Vat</p>
                          <h3 class="text-danger"><? echo symbol.number_format($total,2)?></h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 m-t-30">
                  <div class="col-sm-6">
                    <div> <strong class="textBlue">Billing Detail </strong>
                      <p><strong>
                        <?=$order['BillingTitle']." ".$order['BillingFirstName']." ".$order['BillingLastName']?>
                        </strong><br>
                        <?=$order['BillingAddress1']." ".$order['BillingAddress2']." ".$order['BillingTownCity']." ".$order['BillingCountyState']?>
                        <br>
                        <?=$order['BillingCompanyName']?>
                        <br>
                        <?=$order['BillingPostcode']?>
                        <br>
                        <?=$order['Billingtelephone']?>
                        <br>
                        <?=$order['Billingemail']?>
                      </p>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div > <strong class="textBlue">Delivery Detail </strong>
                      <p><strong>
                        <?=$order['DeliveryTitle']." ".$order['DeliveryFirstName']." ".$order['DeliveryLastName']?>
                        </strong><br>
                        <?=$order['DeliveryAddress1']." ".$order['DeliveryAddress2']." ".$order['DeliveryTownCity']." ".$order['DeliveryCountyState']?>
                        <br>
                        <?=$order['DeliveryCompanyName']?>
                        <br>
                        <?=$order['DeliveryPostcode']?>
                        <br>
                        <?=$order['Deliverytelephone']?>
                        <br>
                        <?=$order['Deliveryemail']?>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 m-t-30">
                  <div class="col-sm-6">
                    <div class="m-t-101" >
                      <p>
                        <?php  
							if($order['PaymentMethods']=='paypal'){
								echo "Pay by PayPal";
							}
							else if($order['PaymentMethods']=='purchaseOrder'){
								echo "Pay by Purchase Order (Government Offices & Educational Organisations Only)";
							}
							else if($order['PaymentMethods']=='Sample Order'){
								echo "Sample Order";
							}
							else if($order['PaymentMethods']=='chequePostel'){
								echo "Pay by Bank Transfer";
							}
							else if($order['PaymentMethods']=='PayPal eCheque'){
								echo "Pay by PayPal eCheque";
							}
							else{
								echo "Pay by ".$order['PaymentMethods'];
							}?>
                      </p>
                      
                      <div class="m-t-10"> <a onclick="window.open('<?php echo base_url() ?>shopping/print_order/<?php echo "SWSAPM".($order['OrderNumber']) . "SWSAPM"; ?>','mywindow','width=1200,height=900')" class="btn orange" role="button">Print Order Confirmation &nbsp; <i class="fa fa-print "></i></a> </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="fdb_area" > <strong class="textBlue">Customer Feedback</strong>
                      <div class="pull-right m-l-5"><i class="  fa fa-smile-o textOrange fa-10x faa-horizontal animated"></i></div>
                      <p>We continuously evaluate our product range and customer care and rely on your feedback to help with this process. Please let us know what is important to you, by completing a short survey that will only take a few minutes and will help us to improve our understanding about what our customers value.</p>
                    </div>
                    <div class="m-t-10"> 
                    
                   			<?php
                    			$redirect_from = $this->session->userdata('redirect_from');
                    			if(isset($redirect_from) and $redirect_from == "plo"):?>
                                   <a style="display:none; " id="cont_shop" class="btn orange pull-right" href="<?=base_url()?>trade/printed-labels/" role="button">
                                            <i class="fa fa-arrow-circle-left faa-horizontal animated"></i> Continue Shopping </a>
                               <?php else:?>
                                <a style="display:none; " id="cont_shop" class="btn orange pull-right" href="<?=base_url()?>" role="button">
                                            <i class="fa fa-arrow-circle-left faa-horizontal animated"></i> Continue Shopping </a>
                    			<?php endif;?>
                    
                    
                      <a role="button" id="notnow" class="btn btn-danger fdbtn">Not Now &nbsp; 
                      <i class="fa fa-times "></i></a>
                      <a role="button" class="btn btn-success fdbtn" href="<?=base_url()?>customer-feedback">Continue &nbsp; <i class="fa fa-check  "></i></a>
                      
                       </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          
        </div>
      </div>
    </div>
    
  </div>
</div>
<div class="modal fade designer" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button id="video_pause" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
<h3 class="modal-title" id="lineModalLabel">Download Message</h3>
</div>
<div class="modal-body">

<!-- content goes here -->
<div class="col-lg-12">
<div align="">  
<p class="text-justify">Permitted Use: You may freely download this artwork containing elements from AA Labels image assets subject to agreeing to the following: <br> <br>

1.	The artwork created (Licensed Work) is used to create templates for labels and stationery for the promotion of image and/or the sale of products and services provided by the originator only and is not for resale, or use by a third-party without the express permission of AA Labels.<br> <br>
2.	To be used to print on labels and stationery; provided, however that such use does not allow (or make capable) the (i) re-distribution or re-use of the content (on a standalone basis or in any reproduced or derived form other than the Licensed Work) described in paragraph 1  above, other than for the purpose of allowing access to the content under corporate+ and for reproduction of Licensed Works described herein or (ii) disassociation or separation of the content from the Licensed Works by the end-user or third party.<br> <br> 
3.	For the distribution and resale of the reproduced Licensed Work described in paragraph 1 and to be used as part of marketing, advertising or promotional materials for the purposes of the Licensed Works referred to in paragraph 1 above. <br> <br>

</p>

<div style="font-size: 14px; line-height: 1.5em;">
 <label class="radio"><input type="radio" name="ld_allow" id="agree_term" class="textOrange" value="yes" checked="checked"><i></i></label>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>I agree to the terms and conditions of use. </b>
</div>
<div style="font-size: 14px; line-height: 1.5em;">
 <label class="radio"><input type="radio" name="ld_allow" id="agree_term" class="textOrange" value="no"><i></i></label>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>I do not agree to the terms and conditions of use. </b>
</div>
<div><a class="btn  btn-primary pull-right" id="ld_continue" data-value="">Continue</a>
</div>
</div>
</div>
</div>
<div class="modal-foote ">
<div class="btn-group btn-group-justified" role="group" aria-label="group button">
<br>
</div>
</div>
</div>
</div>
</div>

<? if(SITE_MODE=='live'){
 $tax = $order['OrderTotal']-($order['OrderTotal']/1.2);	
?>


<!-- START Google Trusted Stores Order -->
<div id="gts-order" style="display:none;" translate="no">
    <!-- start order and merchant information -->
    <span id="gts-o-id"><?=$order['OrderNumber']?></span>
    <span id="gts-o-domain">www.aalabels.com</span>
    <span id="gts-o-email"><?=$order['Billingemail']?></span>
    <span id="gts-o-country">GB</span>
    <span id="gts-o-currency">GBP</span>
    <span id="gts-o-total"><?=number_format($order['OrderTotal']-$tax,2,'.','')?></span>
    <span id="gts-o-discounts"><?=$discount?></span>
    <span id="gts-o-shipping-total"><?=$order['OrderShippingAmount']?></span>
    <span id="gts-o-tax-total"><?=number_format($tax,2,'.','')?></span>
    <span id="gts-o-est-ship-date"><?=date("Y-m-d",($order['OrderTime']+(86400*3)))?></span>
    <span id="gts-o-est-delivery-date"><?=date("Y-m-d",($order['OrderTime']+(86400*6)))?></span>
    <span id="gts-o-has-preorder">N</span>
    <span id="gts-o-has-digital">N</span>
    <!-- en order and merchant information -->
    <!-- start repeated item specific information -->
    <!-- item example: this area repeated for each item in the order -->
  <span class="gts-item"><?=$store_prd?></span>
    <!-- en item 1 example -->
    <!-- en repeated item specific information -->
</div>
<!-- END Google Trusted Stores Order --><!-- START Trusted Stores Order -->



<? /*********top cashback script start**********/
 
   $total = $this->shopping_model->calculate_topcashback($order['OrderNumber']);
  // if($total > 0 ){
  if($total > 0 and ($order['OrderStatus']==2)){
	$amount = number_format($total,2,'.','');

?> 

<!-- Offer Conversion: AA Labels - Cashback Offer -->
<iframe src="https://track.topcashback.com/aff_l?offer_id=313&adv_sub=<?=$order['OrderNumber']?>&amount=<?=$amount?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
<!-- // End Offer Conversion -->

<? } /*********top cashback script en**********/  ?>


<?   } ?>

<script>


<? 

        $order['OrderTotal'] 		   = $order['OrderTotal']*$order['exchange_rate'];
		$order['OrderShippingAmount']  = $order['OrderShippingAmount']*$order['exchange_rate'];
		
		
    	$total = $order['OrderTotal'];
		$tax = number_format((($order['OrderTotal']+$order['OrderShippingAmount'])*0.2),2,'.','');
		if(isset($order['vat_exempt']) and $order['vat_exempt']=="yes"){
			 $tax = 0.00;
		}  
		$total 		=  number_format(($total/1.2),2,'.','');
		$shipping   =  number_format($order['OrderShippingAmount']/1.2,2,'.','');  
?>

//var dataLayer = window.dataLayer = window.dataLayer || [];


	dataLayer.push({
		'event': 'purchaseComplete',
		  'ecommerce': {
			'purchase': {
			  'actionField': {
				'id': '<?=$order['OrderNumber']?>',                        
				'affiliation': 'Main',
				'revenue': '<?=$total?>',                     
				'tax':'<?=$tax?>',
				'shipping': '<?=$shipping?>',
				'currency': '<?=$order['currency']?>',
				'dimension5':'<?=$order['PaymentMethods']?>'
			  },
			  'products': [<?=$ecom_productinfo?>]
			}
		  }
		});





$(document).on("click", "#notnow", function(event) {
	$('.fdb_area').css('visibility','hidden');
	$('.fdbtn').hide();$('#cont_shop').show();
	
});
 $(".ld_download").click(function() {
    var value = $(this).attr('data-value');
    $('#ld_continue').attr('data-value',value);
 });
 
 $("#ld_continue").click(function() {
   var url = $(this).attr('data-value');
   var check = $("input[name=ld_allow]:checked").val();
     if(check=='yes'){
		$('#video_pause').trigger('click');
	    window.open(url);
	  }else{
	  $('#video_pause').trigger('click');	
	  }
});
</script>
