<style>

.chzn-container {
    display: block;
    font-size: 13px;
    position: relative;
}
.chzn-container-active .chzn-single-with-drop {
    background-color: #eee;
    background-image: -moz-linear-gradient(center bottom , white 0px, #eee 17%);
    border: 1px solid #aaa;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    box-shadow: 0 1px 0 #fff inset;
}
	
	.chzn-container-single .chzn-single {
   
    color: #444;
    display: block;
    height: 26px;
    line-height: 26px;
    overflow: hidden;
    padding: 0 0 0 8px;
    position: relative;
    text-decoration: none;
    white-space: nowrap;
}	
.chzn-container-active .chzn-single-with-drop div b {
    background-position: -18px 1px;
}
.chzn-container-single .chzn-single div b {
    display: block;
    height: 100%;
    width: 100%;
}
.chzn-container-active .chzn-single-with-drop div {
    background: none repeat scroll 0 0 transparent;
    border-left: medium none;
}

.table tbody tr.even td, .table tbody tr:nth-child(2n) td{
	background:none !important;
	
}
    
</style>


<?php 
//$action = end($this->uri->segments);
$action = $this->session->userdata("action");

$UserTypeID = $this->session->userdata('UserTypeID');


?>

<div role=main class=container_12 id=content-wrapper> 
    <fieldset class="mainField" >
        
        <?php 
        print_r($AccountInfo);
        foreach ($AccountInfo as $Order) { 
            $OrderNumber = $Order->OrderNumber;	?>
        
        <div class="enquiryFieldset" >


            <div style="margin-top: 20px;" class="grid_4">
                <div class="box">

                    <div class="header">
                        <img src="<?php echo base_url();?>/aalabels/img/ui-tab.png" height="16" width="16">
                        <h3>Credit Note Information </h3>
                    </div>

                    <div class="content" style="min-height:320px;">
                        <div class="row" style=" margin-bottom:20px; margin-top:20px;"></div>

                       
                            
                        <div class="row">
                            <div style="width:140px;color:red;" class="colm-1">
                                Credit Note  Number &nbsp;: 
                            </div>

                            <div style="width:140px;color:red;" class="colm-2">
                                <b> <?php echo $invoice; ?> </b>                       
                            </div> 
                        </div>
                            
                            
                            
                            
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Order Number &nbsp;: 
                            </div>

                            <div style="width:140px;" class="colm-2">
                                <?php echo $Order->OrderNumber; ?>                        
                            </div> 
                        </div>

                              
                            
                               
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Date &nbsp;: 
                            </div>
                            
                            <div style="width:140px;" class="colm-2">
                                <?php echo date('jS F Y', $Order->OrderDate); ?>                        
                            </div> 
                        </div>

                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                Time &nbsp;: 
                            </div>
                            
                            <div style="width:140px;" class="colm-2">
                                <?php echo date('h:i:s A', $Order->OrderDate); ?>                        
                            </div> 
                        </div>

                        <? 
                            $status = $this->db->query("select status from invoice where Invoicenumber = $invoice");
                            $status = $status->row_array();
                            $status = $status['status']; 
                        ?>
                        <? if($status==0){?>   
    
                        <div class="row">
                            <div style="width:140px;" class="colm-1">
                                <input style="width: 125px;margin-bottom:10px;margin-top:10px;" type="button" onclick="changecredit_status('<?=$invoice?>');" value="Sent to Customer">                   
                            </div>
                            
                            <div style="width:140px;" class="colm-2"></div> 
                        </div>    
          
                        <? } ?>          
              

                        
                    </div>
                </div>
            </div>


<?php
$controller =$this->router->fetch_class();
$method = $this->router->fetch_method();
$minhight = 'style="min-height:320px;"' ;?>
    
  
    
    <script>
	function changecredit_status(id){
	var check = confirm('Do You Want To Continue ?');	
	if(check){}else{return false;} 
	$.ajax({
	url: '<?=backoffice_url()?>note/change_note_status',
	data:{
	id:id
	},
	datatype:'json',
	success:function(data){
    location.reload();
	}
    });
	 
 }
	</script>
   <!--------------------------------------------- Billing Address --------------------------------------------------------------->

   
    
  <div style="margin-top: 20px; margin-bottom:20px;" class="grid_4">
                    <div class="box" id="Billinginfo">

                        <div class="header">
                            <img src="<?php echo base_url();?>aalabels/img/ui-tab.png" height="16" width="16">
                            <h3>Billing Address </h3>
                        </div>
                        <div id="billinginfo" class="content" <?php echo $minhight;?>>
                            <div class="row" style="margin-top:20px;"></div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Company Name &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingCompanyName; ?>                        
                                 </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Name &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingFirstName . ' ' . $Order->BillingLastName; ?>                        
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Address 1 &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingAddress1; ?>                        
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Address 2 &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingAddress2; ?>                        
                                 </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    City &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingTownCity; ?>                       
                                 </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Country / State &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingCountyState; ?>                        
                                </div> 
                            </div>
                            
                            
                              <div class="row"> 			
	                                <div style="width:140px;" class="colm-1"> 			
		                                    Country &nbsp;: 			
	                                </div> 			
				
	                                <div style="width:140px;" class="colm-2"> 			
	                                   <?php echo $Order->BillingCountry; ?>                         			
	                              </div> 			
	                          </div> 
                            
                            
                            
                            
                            
                            
                            

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Postcode &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->BillingPostcode; ?>                        
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Telephone &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->Billingtelephone; ?>                        
                                </div> 
                            </div>

                              
                              
                                <div class="row"> 			
		                                <div style="width:140px;" class="colm-1"> 			
		                                    Mobile &nbsp;: 			
		                                </div> 			
					
		                                <div style="width:140px;" class="colm-2"> 			
		                                    <?php echo $Order->BillingMobile; ?>                         			
		                                </div> 			
		                            </div> 
    
    
    

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Fax &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->Billingfax; ?>                        
                                </div> 
                            </div>

                             
                             <!-- --------------------New fields added Start--------------- -->      
                           
                           <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Email &nbsp;: 
                                </div>
                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->Billingemail; ?>                        
                                </div> 
                            </div>
                           <!-- --------------------New fields added End--------------- -->     
           
                        </div>
                    </div>
                    
                
                    
  </div>



<!---------------------------------------------------------  Delivery Information---------------------------------------------------------------------------->


          <div style="margin-top: 20px; margin-bottom:20px;" class="grid_4">
                    
                    <div class="box" id="Deliveryinfo">

                        <div class="header">
                            <img src="<?php echo base_url();?>aalabels/img/ui-tab.png" height="16" width="16">
                            <h3>Delivery Address </h3>
                        </div>

                        <div id="deliveryinfo" class="content" <?php echo $minhight;?>>
                            <div class="row" style="margin-top:20px;"></div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Company Name &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryCompanyName; ?>                        
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Name &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryFirstName.' '.$Order->DeliveryLastName; ?>
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery Address 1 &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryAddress1; ?>
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery Address 2 &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryAddress2; ?>                        
                                </div> 
                            </div>

                           

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery City &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryTownCity; ?>                        
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery Country / State &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryCountyState; ?>                       
                                </div> 
                            </div>
                            
                               <div class="row"> 			
		                                <div style="width:140px;" class="colm-1"> 			
		                                    Delivery Country &nbsp;: 			
		                                </div> 			
					
		                                <div style="width:140px;" class="colm-2"> 			
		                                    <?php echo $Order->DeliveryCountry; ?>                       			
		                                </div> 			
		                            </div> 
    

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery Postcode &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryPostcode; ?>                        
                                </div> 
                            </div>

                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery Phone &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->Deliverytelephone; ?>                        
                                </div> 
                            </div>
                            
                             <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Mobile Phone &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                    <?php echo $Order->DeliveryMobile; ?>                        
                                </div> 
                            </div>
                            
                            
                            
                            <div class="row">
                                <div style="width:140px;" class="colm-1">
                                    Delivery Fax &nbsp;: 
                                </div>

                                <div style="width:140px;" class="colm-2">
                                   <?php echo $Order->Deliveryfax; ?>              
                                 </div> 
                            </div>



                        </div>
                    
                 
                    </div>
                    
                    
          			           
                    
                    
                    
          </div> <!--end of delivery grid_4-->


</form> 

     </div>

            <table class="table" id="table-example">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Product </th>
                        <th>Description</th>
                       <!-- <th>Unit Price</th> -->
                        <th>Labels</th>
                        <th>Quantity</th>
                        <th>Ex. Vat</th>
                        <th>Incl. Vat</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_exvat=0;
                    $total_invat=0;
					$i=0;
                    foreach ($AccountDetails as $AccountDetail) {
                      $i++;  
					  
					  $LabelsPerSheet = 1;
					   $colorcode = (isset($AccountDetail->colorcode) and $AccountDetail->colorcode!='')?'-'.$AccountDetail->colorcode:'';
                       if($AccountDetail->ProductID == 0){
                            $ManufactureID = $AccountDetail->ManufactureID;
                        }else{
                      	  $ManufactureID= $this->accountModel->manufactureid("",$AccountDetail->ProductID);
						  $LabelsPerSheet= $this->accountModel->LabelsPerSheet($AccountDetail->ProductID);
							 if(isset($AccountDetail->is_custom) and $AccountDetail->is_custom=='Yes'){
									$LabelsPerSheet = $AccountDetail->LabelsPerRoll;
							 }
                        }
						
						 $img = $this->orderModel->getproductimg($AccountDetail->ProductID);
                        $serialNo = $AccountDetail->SerialNumber;
							
						if($i%2==0){
					$sty = 'style="background-color:#efefef;"';	
					$classes = "greyer";
						}else{
						
						$sty = 'style="background-color:#fff;"';	
						$classes = "whiter";	
						}	
                    ?>

                   <?
                   $Order->currency       = (isset($Order->currency) && $Order->currency!='')?$Order->currency:'GBP';
				   $exchange_rate         = (isset($Order->exchange_rate) && $Order->exchange_rate!=0)?$Order->exchange_rate:1;
				   $symbol                = $this->reportsmodel->get_currecy_symbol($Order->currency);
				   ?>


                   <tr <?=$sty?>>

                        <td><img src="<?php echo $img; ?>" width="30px"  border="0"/></td>
                        <td><?php echo $ManufactureID; ?></td>
                        <td>
						
						<?php echo $AccountDetail->ProductName; ?>
                         <?   $files = $this->quoteModel->get_integrated_attachments($serialNo);   
							  if(count($files) > 0){?>
                              <table>
                              	<tr>
                                <? foreach($files as $row){?>
                                    <td>
                                   <!-- <a href="<?=base_url()?>ajax/download/integrated/<?=$row->file?>">-->
                                    <a href="<?=base_url()?>theme/integrated_attach/<?=$row->file?>">
                                    <img width="30" height="" id="prod_image" src="<?=base_url()?>theme/integrated_attach/<?=$row->file?>"  /> 
                                   </a>
                                   </td>
                                <? }?> 
                    			</tr>
                       		 </table>  
                        <? } ?> 
                        
                           
                        </td>
                      <!--  <td><?php echo currency_sml.$exvat= number_format($AccountDetail->Price,2,'.',''); ?></td> -->
                      
                      <? 
					  
					 	    $total_labels = $AccountDetail->Quantity*$LabelsPerSheet;
							if($AccountDetail->Printing == 'Y'){ 
								$labels = $this->orderModel->calculate_total_printed_labels($AccountDetail->SerialNumber);
								if($labels > 0){ $total_labels =$labels;}		
							}
							
							
					  
					  ?>
                         <td><?php echo $total_labels; ?></td>
                        <td><?php echo $AccountDetail->Quantity; ?></td>
                        
                         <td><?  echo $symbol."".(number_format($exvat*$exchange_rate,2));?></td>
                           <?php $invat = number_format($exvat* vat_rate,'2','.',''); ?>
                         <td><?  echo $symbol."".(number_format($invat*$exchange_rate,2));?></td>
                        
                    </tr>
                    
           <? $detail_view = $this->quoteModel->check_product_extra_detail($ManufactureID);
     if($detail_view['prompt']=='yes'){?>
        
<tr>
<td></td>
<td><b style="color:green;font-size:12px;">Product Note</b></td>
<td><b style="color:green;font-size:12px;"><?=$detail_view['detail']?></b></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
        
<? } ?>                   
              
                  
                     
                      <?php 
				 
			          
                     $stylo = "";
					//if(preg_match('/A4/is',$AccountDetail->ProductName) && $AccountDetail->Printing=="Y"){}else{
					if($AccountDetail->Printing=="Y"){}else{
			         $stylo = "style='display:none;'";	
			         }
                    ?>
                    
                       <style>
	 .greyer{background-color:#efefef;}.whiter{background-color:#fff;}
	 </style> 
     
     <tr <?=$stylo?> class="<?=$classes?>">
          <td colspan="2"></td>
          
          <?php include('includes/print_line_txt.php'); ?>
          <?  if($AccountDetail->Print_Design=="1 Design"){
							 $qtyy = 1;
						 }else{
							  $qtyy = $AccountDetail->Print_Qty;
							}?>
           <td>&nbsp;</td>
          <td><?php echo $qtyy; ?></td>
          
          <? $print_exvat = $AccountDetail->Print_Total; ?>
          <? $print_incvat = $AccountDetail->Print_Total*1.2;?>
          
          <td><? echo $symbol."".number_format($print_exvat*$exchange_rate,2);?></td>
          <td><? echo $symbol."".number_format($print_incvat*$exchange_rate,2);?></td>
         
        </tr>
     
     
     
        
                        
                      <?        
                      $stylo_prl = "";
			         if($ManufactureID=="PRL1"){
					   $result = $this->quoteModel->get_details_roll_quotation($AccountDetail->Prl_id); 
					 }else{
					  $stylo_prl = "style='display:none;'";	
				     }
				?>
                
                
        <tr <?=$stylo_prl?>>
          <td></td>
          <td></td>
          <td>
             <b>Shape:</b>
            <?=$result['shape']?>
            &nbsp;&nbsp; <b>Size:</b>
            <?=$result['size']?>
            &nbsp;&nbsp; <b>Material:</b>
            <?=$result['material']?>
            &nbsp;&nbsp; <b>Printing:</b>
            <?=$result['printing']?>
            &nbsp;&nbsp; <b>Finishing:</b>
            <?=$result['finishing']?>
            &nbsp;&nbsp; <b>No. Designs:</b>
            <?=$result['no_designs']?>
            &nbsp;&nbsp; <b>No. Rolls:</b>
            <?=$result['no_rolls']?>
            &nbsp;&nbsp; <b>No. labels:</b>
            <?=$result['no_labels']?>
            &nbsp;&nbsp; <b>Core Size:</b>
            <?=$result['coresize']." mm"?>
            &nbsp;&nbsp; <b>Wound:</b>
            <?=$result['wound']?>
            &nbsp;&nbsp;<b>Notes:</b>
            <?=$result['notes']?>
            &nbsp;&nbsp; </td>
       
          <td></td>
           <td></td>
          <td></td>
            <td></td>
                    </tr>         
                    <?php   
                           
                        $sub_exvat =  $print_exvat +  $exvat;
                        $sul_invat =  $print_incvat + $invat;

                        $total_exvat += $sub_exvat ;
                        $total_invat += $sul_invat ;
                    } 
                    ?>
                        
                    </tbody>
        </table>
        
       <style>
	   .red{
		color:red !important;   
		  }
	   </style> 
      
                     <ul class="stats-list">
                         <li style="color:red !important;"> Sub Total: 
                          <span class="red">  <?php echo $symbol.number_format($total_invat*$exchange_rate,2); ?> </span> 
                          <span class="red">  <?php echo $symbol.number_format($total_exvat*$exchange_rate,2); ?> </span> 
                        </li>
                    </tr>
 
                    <?
                        $ship_invat = number_format($Order->OrderShippingAmount,2,'.','');
                        $ship_exvat = number_format($Order->OrderShippingAmount/vat_rate,2,'.',''); 
                    ?>                   
                        <li style="color:red !important;">Delivery Total:  
                    
                        <span class="red"> <?php echo  $symbol.number_format($ship_invat*$exchange_rate,2); ?></span>
                        <span class="red"> <?php echo  $symbol.number_format($ship_exvat*$exchange_rate,2);?> </span>
                     
                       </li>
                    
                    
                 <?php if ($Order->voucherOfferd =='Yes'){
			    		$discount_applied_in = $Order->voucherDiscount;
						$discount_applied_ex = $Order->voucherDiscount/1.2;
			           }
		   		       else{
				        $discount_applied_in = 0.00;	
						$discount_applied_ex = 0.00;	
				       }	?>
                <?
                    $discount=number_format($discount_applied_in,2,'.','');
                    $discount=number_format($discount_applied_ex,2,'.','');
                ?>                 
                <li style="color:red !important;">Discount: 
                    <span class="red"> <?php echo $symbol.number_format($discount_applied_in*$exchange_rate,2,'.',''); ?> </span>
                    <span class="red"> <?php echo $symbol.number_format($discount_applied_ex*$exchange_rate,2,'.',''); ?> </span>
                </li>
                    
   
                <?
                    $ship_invat = number_format($ship_invat+$total_invat-$discount_applied_in,2,'.',''); 
                    $ship_exvat = number_format($ship_exvat+$total_exvat-$discount_applied_ex,2,'.','');
                    $vat_exempt = number_format($ship_invat-$ship_exvat,2,'.',''); 
                
    ?>  
   
                 <? if($Order->vat_exempt =='yes'){
				   $ship_invat = $ship_exvat;	 
				 ?>
                   <li style="color:red !important;">VAT Exempt: 
                         <span></span>
                         <span style="color:red;"> - <? echo $symbol."".number_format($vat_exempt*$exchange_rate,2); ?> </span>
                    </li>
                <? } ?>
                
                

                 
                    <li style="color:red !important;">
                        Grand Total: 
                          <span class="red"> - <?php echo $symbol."".number_format($ship_invat*$exchange_rate,2); ?></span>
                          <span class="red"> - <?php echo $symbol."".number_format($ship_exvat*$exchange_rate,2); ?></span>
                   </li>
              
                      </ul>

             
    </fieldset>
 
 
    <input style="float: right;width: 125px;margin-bottom:10px;margin-top:10px;" type="button" onclick="printingorder('<?=$invoice?>');" value="Print Credit Note">
    
    <? } ?>


     <? //include('creditnotes.php')?>

</div>

                       

<script> 


function printingorder(id){

    window.location.href='<?=backoffice_url(); ?>note/printnote/'+id;
}

</script> 
  
