<?php
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

?>

<meta charset="utf-8" />

<style>
body {
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
tr {
	font-size:11px;
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
td {
	font-size:11px;
	font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
}
tr.table_blue_bar {
	background-color: #edf5ff;
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
tr.table_white_bar {
	background-color: #ffffff;
	border-bottom: 1px solid #cccccc;
	width: 100%;
}
.invoicetable_PCode_loop {
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 100px;
}
.invoicetable_description_loop {
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: left;
	width: 60%;
}
.invoicetable_sml_headings_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 70px;
}
.invoicetable_Qty_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px;
	text-align: center;
	width: 35px;
}
.line_total_loop {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 11px;
	padding: 5px 0 5px 10px;
	text-align: left;
	width: 70px;
}
.invoicetable_PCode {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 100px;
	color:#fff;
}
.invoicetable_description {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: left;
	width: 60%;
	color:#fff;
}
.invoicetable_sml_headings {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 70px;
	color:#fff;
}
.invoicetable_Qty {
	background-color: #17b1e3;
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 35px;
	color:#fff;
}
.invuice_subtotal {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	padding: 5px 10px 5px 0;
	text-align: right;
}
.invuice_subtotal_price {
	border-bottom: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	color: #000000;
	font-size: 12px;
	padding: 5px 0 5px 10px;
	text-align: left;
}
</style>

<table width="750px" border="0" cellspacing="10" style="margin-left:-5px;">
  <tr>
    <?php if($OrderInfo[0]->Domain=='123'){ ?>
    <td width="30%"><img src="http://www.123-labels.co.uk/images/email_logo.png" ></td>
    <?php }else{ ?>
    <td width="30%"><img src="<?php echo base_url();?>saleoperator/images/logo_n.png" border="0" width="200" height="70" /></td>
    <?php } ?>
    <td width="30%">&nbsp;</td>
    <td width="30%" align="left" valign="middle"><h3 style="color:#999999;">
        <?php
		
		
	 //$invoice = $this->notemodel->getinvoicenumber($OrderInfo[0]->OrderNumber);
     echo '<font color="red"> Note de credit :  '.$invoice. '</font>';
    ?>
    
    
    
    
    
      </h3></td>
  </tr>
  <tr>
     
      <td align="left" valign="top" class="print_address"> AA Labels,</br>
      23 Wainman Road,</br>
      Peterborough,</br>
      PE2 7BU </td>
    <td align="right" valign="top"><table width="100%" border="0">
        <tr>
          <td align="right" class="print_address">Téléphone: </td>
        </tr>
        <tr>
         <!-- <td align="right" valign="top" class="print_address">Fax: </td>
        </tr>
        <tr>-->
          <td align="right" valign="top" class="print_address">Email: </td>
        </tr>
        <tr>
          <td align="right" valign="top" class="print_address">numéro de TVA: </td>
        </tr>
      </table></td>
    <td align="left" valign="top"><table width="100%" border="0">
        <tr>
          <td align="left" class="print_address"><span class="phone_right">01733 588 390</span></td>
        </tr>
       <!-- <tr>
          <td align="left" valign="top" class="print_address">01733 425 106 </td>
        </tr>-->
        <tr>
          <td align="left" valign="top" class="print_address"><span class="phone_right">
           <a href="mailto:customercare@aalabels.com" style="text-decoration:none; color:#000000;">customercare@aalabels.com</a>
           </span></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="print_address"><span class="phone_right">GB 945 028 620</span></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;">Informations sur la facture</h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:10px;"><table width="100%" border="0" cellspacing="3" cellpadding="0">
              
               
               <tr>
                <td class="print_address"><b>Numéro de facture:</b></td>
                <td class="print_address"><?php echo $invoice;   ?></td>
              </tr>
              
              <tr>
                <td class="print_address"><b>Numéro de commande:</b></td>
                <td class="print_address"><?php echo $OrderInfo[0]->OrderNumber;   ?></td>
              </tr>
              
              <!-- <tr>
           <td class="print_address"><b>Order:</b></td>
           <td class="print_address"><?
           if($OrderInfo[0]->PaymentMethods == "specialOrders" ){echo "Commandes speciales";}elseif($OrderInfo[0]->Source =="website"){echo "site Internet";}
	       elseif($OrderInfo[0]->PaymentMethods=="SampleOrder")
		   {
				 echo "Demander des échantillons";
		   }
           ?></td>
         </tr> -->
              
              <tr>
                <td class="print_address"><b>Date:</b></td>
                <td class="print_address"><?php echo date('jS F Y', $OrderInfo[0]->OrderDate); ?></td>
              </tr>
              <tr>
                <td class="print_address"><b>heure:</b></td>
                <td class="print_address"><?php echo date('h:i:s A', $OrderInfo[0]->OrderDate); ?></td>
              </tr>
              <tr>
                <td class="print_address"><b>Statut:</b></td>
                <td class="print_address"><?php 
                   $status= $this->accountmodel->getstatus($OrderInfo[0]->OrderStatus); 
                   echo $status[0]->StatusTitle;
                                    
           ?>
                  <? //$objOrders->getStatusTitle($OrderInfo[0]['OrderStatus']) ?></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;">Adresse de facturation</h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:10px; padding-left:5px;"><div class="print_address">
              <?=$OrderInfo[0]->BillingCompanyName?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->BillingFirstName.' '.$OrderInfo[0]->BillingLastName?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->BillingAddress1?>
            </div>
            <? 
	     if($OrderInfo[0]->BillingAddress2){?>
            <div class="print_address">
              <?=$OrderInfo[0]->BillingAddress2?>
            </div>
            <? } ?>
            <div class="print_address">
              <?=$OrderInfo[0]->BillingTownCity?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->BillingCountyState?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->BillingPostcode?>
            </div>
            
            <!--<div class="print_address">BillingCountry<? //$OrderInfo[0]['BillingCountry']?></div>-->
            
            <div class="print_address">
              <?=$OrderInfo[0]->Billingtelephone?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->Billingfax?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->Billingemail?>
            </div>
            <div class="print_address">
              <?
                if($OrderInfo[0]->BillingResCom == 1)
                {
                    echo "Residentiel";
                }
                else
                {
                    echo "Commercial";
                }
            ?>
            </div></td>
        </tr>
      </table></td>
    <td align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" style="background-color:#17b1e3; border-bottom:#CCCCCC 1px solid; line-height:5px;"><h3 style="padding-top:15px; white-space:nowrap; text-align:center;color:#fff;"><span style="white-space:nowrap;">Adresse de livraison</span></h3></td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-top:10px; padding-left:5px;"><div class="print_address">
              <?=$OrderInfo[0]->DeliveryCompanyName?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryFirstName.' '.$OrderInfo[0]->DeliveryLastName?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryAddress1?>
            </div>
            <? if($OrderInfo[0]->DeliveryAddress2){?>
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryAddress2?>
            </div>
            <? } ?>
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryTownCity?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryCountyState?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryPostcode?>
            </div>
            
            <!--<div class="print_address">BillingCountry<?=$OrderInfo[0]->BillingCountry?></div>-->
            
            <div class="print_address">
              <?=$OrderInfo[0]->DeliveryTownCity?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->Deliverytelephone?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->Deliveryfax?>
            </div>
            <div class="print_address">
              <?=$OrderInfo[0]->Billingemail?>
            </div>
            <div class="print_address">
              <?
       		if($OrderInfo[0]->DeliveryResCom == 1)
			{
				echo "Résidentiel";
			}
			else
			{
				echo "Commercial";
			}
        ?>
            </div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" style="border:#CCCCCC 1px solid; padding-bottom:10px;"><table width="730px;" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">
        <tr>
          <td class="invoicetable_PCode">Code produit</td>
          <td class="invoicetable_description">Description</td>
          <td class="invoicetable_sml_headings">Prix</td>
          <td class="invoicetable_Qty">Quantité</td>
          <td class="invoicetable_sml_headings" style="padding:5px 0 5px 10px; text-align:left;">Total de ligne</td>
        </tr>
        <?php
       		$exvat=0;
       		$incvat=0;
			$exVatPrice = 0;
			$incVatPrice = 0;
            $currencySymbol = "&pound;";
		   
		       $query = $this->db->get_where('orderdetails', array('OrderNumber' =>$OrderInfo[0]->OrderNumber));
               $sumarrary = $query->result_array();
			   
			   
	       for($i=0;$i<count($OrderDetails);$i++)
	       {
		       	if($i%2==0)
				{
					$css="class='table_blue_bar'";
				}
				else
				{
					$css="class='table_white_bar'";
				}
				
				
          //$Order->currency       = (isset($OrderInfo[0]->currency) && $OrderInfo[0]->currency!='')?$OrderInfo[0]->currency:'GBP';
          $exchange_rate         = (isset($OrderInfo[0]->exchange_rate) && $OrderInfo[0]->exchange_rate!=0)?$OrderInfo[0]->exchange_rate:1;
          $symbol                = $this->orderModal->get_currecy_symbol($OrderInfo[0]->currency);
				   
               
               
             	if($OrderDetails[$i]->ProductID == 0)
				{

					$ManufactureID=$OrderDetails[$i]->ManufactureID;
					$productName=$OrderDetails[$i]->ProductName;
					$Price=$OrderDetails[$i]->Price;
					$Quantity=$OrderDetails[$i]->Quantity;
					$Btndisplays='display:inline;';
					
				}
				else
				{

					$ManufactureID= $this->accountmodel->manufactureid("",$OrderDetails[$i]->ProductID);
					$productName=$OrderDetails[$i]->ProductName;
					$Price=$OrderDetails[$i]->Price;
					$Quantity=$OrderDetails[$i]->Quantity;
					$Btndisplays='display:none;';
					
				}

		       	if($OrderDetails[$i]->Quantity!=0)
		       	{
		       ?>
               
                  
        <tr>
          <td class="invoicetable_PCode_loop"><?=$ManufactureID?></td>
          <td class="invoicetable_description_loop">
           <?
    
           $prod = $this->quoteModel->show_product($OrderDetails[$i]->ProductID);
            $merge = array_merge($prod,$sumarrary[$i]);
            $prod_name = $this->quoteModel->fetch_product_name($merge);
            echo $this->orderModal->ReplaceHtmlToString_($prod_name);
      
            if($ManufactureID=="SCO1"){
              $custominfo = $this->quoteModel->fetch_custom_die_order($OrderDetails[$i]->SerialNumber); 
            ?>
 		   pour <?php if($custominfo['format'] == 'Roll'){echo $custominfo['format'].' Labels';}else{echo $custominfo['format'].' Sheets';}?> <?=$custominfo['width']?><? if($custominfo['shape']!="Circle"){?>x<?=$custominfo['height']?><? } ?>  mm <?php if($custominfo['shape'] != ''){echo $custominfo['shape'].',';}?>  <? if($custominfo['format']=="Roll"){?>bord d'attaque <?=$custominfo['width']?> mm, <? } ?> Rayon d'angle <?=$custominfo['cornerradius']?> mm
            
   <? } ?>
          
          
          
                     
          </td>
          <td class="invoicetable_sml_headings_loop">&pound;
            <?=round($Price/$Quantity,4)?></td>
          <td class="invoicetable_Qty_loop"><?=$Quantity?></td>
          
          <td class="line_total_loop">
                        <?php
					      if($OrderInfo[0]->PaymentMethods == 'SampleOrder'){
							   $exvat ='0.00';
						  }
                       	  else{
                       		   $exvat = $OrderDetails[$i]->Price;
                       	  }
                       	?>
                     <?  echo $symbol."".(number_format($exvat*$exchange_rate,2));?>      
          </td>
          
        </tr>
                     <?php
                     $incvat = number_format($exvat*vat_rate,'2','.','');
					   
					 $stylo = "";
					//if($OrderDetails[$i]->Printing=="Y" && preg_match('/A4/is',$OrderDetails[$i]->ProductName)){}else{
					if($OrderDetails[$i]->Printing=="Y"){}else{
						$stylo = "style='display:none;'";
					}
                    ?>
                    
                    
        <tr <?=$stylo?>>
          <td class="invoicetable_PCode_loop"></td>
          
           <?php $print_style='font-size: 8px;'; $AccountDetail = $OrderDetails[$i]; include('print_line_txt.php'); ?>
          
          <td class="invoicetable_sml_headings_loop">&pound;<? echo $price=number_format($OrderDetails[$i]->Print_UnitPrice,3,'.',''); ?></td>
          <td class="invoicetable_Qty_loop"><?php echo $OrderDetails[$i]->Print_Qty; ?></td>
          
          <td class="line_total_loop">
            <?  $print_exvat = $OrderDetails[$i]->Print_Total;
                $print_incvat = $OrderDetails[$i]->Print_Total*1.2;
			?>
            <?  echo $symbol."".(number_format($print_exvat*$exchange_rate,2));?>     
          </td>
          
          
        </tr>
                    
      <?  if($ManufactureID=="PRL1"){
		     $result = $this->quoteModel->get_details_roll_quotation($OrderDetails[$i]->Prl_id);
	  ?>              
        <tr <?=$stylo_prl?>>
          <td class="invoicetable_PCode_loop"></td>
          <td class="invoicetable_description_loop"><b>Shape:</b>
           <b>Forme:</b>
						<?=$result['shape']?>
                        &nbsp;&nbsp; <b>Taille:</b>
                        <?=$result['size']?>
                        &nbsp;&nbsp; <b>Matériel:</b>
                        <?=$result['material']?>
                        &nbsp;&nbsp; <b>Impression:</b>
                        <?=$result['printing']?>
                        &nbsp;&nbsp; <b>Finition:</b>
                        <?=$result['finishing']?>
                        &nbsp;&nbsp; <b>pas de design:</b>
                        <?=$result['no_designs']?>
                        &nbsp;&nbsp; <b>N ° Rolls:</b>
                        <?=$result['no_rolls']?>
                        &nbsp;&nbsp; <b>N ° étiquettes:</b>
                        <?=$result['no_labels']?>
                        &nbsp;&nbsp; <b>Taille du noyau:</b>
                        <?=$result['coresize']?>
                        &nbsp;&nbsp; <b>Blessure:</b>
                        <?=$result['wound']?>
                        &nbsp;&nbsp;<b>Remarques:</b>
                        <?=$result['notes']?>
                        &nbsp;&nbsp;</td>
          <td class="invoicetable_sml_headings_loop"></td>
          <td class="invoicetable_Qty_loop"></td>
          <td class="line_total_loop"></td>
        </tr>
    <? } ?>
    
    
        
        <tr style="border:1px solid;">
          <td class="invoicetable_PCode_loop"></td>
          <td class="invoicetable_description_loop"></td>
          <td class="invoicetable_sml_headings" style="padding:0px !important;" colspan="2"><div><b>Total de ligne :</b></div></td>
         <!-- <td class="invoicetable_Qty"></td>-->
          <td class="invoicetable_sml_headings" style="padding:5px 0 5px 10px; text-align:left;"><div>
          <? $linetotalexvat = $print_exvat + $exvat;
		     echo $symbol."".(number_format($linetotalexvat*$exchange_rate,2));
		  ?>
           
           </div>
           </td>
          <? $linetotalinvat = $print_incvat + $incvat;?>
        </tr>
        <?   
			         		   
                                    $exVatPrice += $linetotalexvat;
		                            $incVatPrice += $linetotalinvat;

		       	}
					//$incvat = number_format($OrderDetails[$i]->Price*$OrderDetails[$i]->Quantity,2,'.','');
		      

		        

	       }

     
 		if($OrderInfo[0]->voucherOfferd=='Yes'){
			$discount = $OrderInfo[0]->voucherDiscount;
		}else 
			if($OrderInfo[0]->DiscountInPounds != 0.00){
				$discount = $OrderInfo[0]->DiscountInPounds;
			}else{
				
				$discount = 0.00;
				}
		
		

	       $vatRate = vat_rate;

	        $exdelivery = number_format($OrderInfo[0]->OrderShippingAmount/$vatRate,2,'.','');

	       $deliveryExVatAmount = $OrderInfo[0]->OrderShippingAmount - $exdelivery;
		   
		   $ship_invat = number_format($OrderInfo[0]->OrderShippingAmount,2,'.','');
		   $gt_invat = number_format($ship_invat+$incVatPrice,2,'.','');

	       ?>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2" class="invuice_subtotal">Livraison:</td>
          <? $exdelivery = number_format($OrderInfo[0]->OrderShippingAmount/$vatRate,2,'.','');?>
          <td class="invuice_subtotal_price"><?=$symbol."".number_format($exdelivery*$exchange_rate,2,'.','');?></td>
        </tr>
        
        
        
        
        
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2"  class="invuice_subtotal">Total général (ExVAT):</td>
          <td class="invuice_subtotal_price">
            <?php
                  if($OrderInfo[0]->PaymentMethods=='SampleOrder'){
					 	   $SubTotal ='0.00';
					 	    $SubTotal ;
				  }
                  else{
            	  $SubTotal = number_format($exVatPrice+$exdelivery,2,'.','');
                 }?>
            <? echo $symbol."".number_format($SubTotal*$exchange_rate,2,'.','');?>     
          </td>
        </tr>
        



        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2"  class="invuice_subtotal">TVA a 20,00%</td>
          <td class="invuice_subtotal_price">
                <? 
				if($OrderInfo[0]->vat_exempt=='yes'){
				$vat = 0.00;
				}else{
				$vat = number_format(( $gt_invat - $SubTotal),2,'.','');
				}
			    echo $symbol."".number_format($vat*$exchange_rate,2,'.','');
				?>     
		</td>
        </tr>
      
            
            
            
            
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2" class="invuice_subtotal">Remise:</td>
          <td class="invuice_subtotal_price"><?=$symbol."".number_format($discount*$exchange_rate,2);?></td>
        </tr>
        
        
        
        <?php
           
            if($OrderInfo[0]->DiscountInPounds=='0.00'){
            $incVat = number_format($incVatPrice,2,'.','');
			$show_price_incvat = number_format(($gt_invat-$discount),2,'.','');
			}else{
			$incVat = number_format($OrderInfo[0]->DiscountedPrice,2,'.','');
			$show_price_incvat = $OrderInfo[0]->DiscountedPrice;	
			}
	  ?>
      
      <?
      if($OrderInfo[0]->vat_exempt=='yes'){
	  $show_price_incvat = $SubTotal;
	  }
	  ?>
      
       <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2" class="invuice_subtotal" style="color:red;"><b>Total du Credit Grand (IncVAT):</b></td>
          <td class="invuice_subtotal_price" style="color:red;"><b> -
          <?=$symbol."".number_format($show_price_incvat*$exchange_rate,2);?>
          </b>
          </td>
       </tr>
       
       
       
       
      </table></td>
  </tr>
</table>
<div class="adminsp_space"></div>
