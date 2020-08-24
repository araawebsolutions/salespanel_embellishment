<style>
  .view-artwork-cta-style{
  background-color: #fd4913;
    color: white;
    text-align: center;
    border-radius:4px;
    width: 100%;
    font-size: 13px;
    border: 1px solid #fd6a3e;
    padding: 7px;
 }
</style>
<input type="hidden" id="rendcartId" value="">
<td colspan="6" class="no-padding">
    <table class="table table-bordered" id="row_<?=$result['OrderNumber']?>">
        <thead>
        <tr style="background: #dff6ff">
					<th class="table-headig" width="5%">Code</th>
					<th class="table-headig" width="5%">Image</th>
					<th class="table-headig" width="55%">Description</th>
					<th class="table-headig" width="10%">QTY</th>
					<th class="table-headig" width="5%">Price</th>
                    <th class="table-headig" width="20%"></th>

					</tr>
			</thead>
			<tbody>
        
        
				<?
					$orderinfo =  $this->orderModal->OrderInfo($result['OrderNumber']);
					$exchange_rate = $orderinfo[0]->exchange_rate;
					$symbol = $this->orderModal->get_currecy_symbol($orderinfo[0]->currency);
					$ke = 0;
				?>
					      
        <?php foreach ($prod as $key=> $product) { 
    
         
    
    $vals = '';
    if (preg_match("/(1000 Sheet Boxes)/i", $product['ProductName'])) {
        $vals = '1000';
    } else {
        $vals = '250';
    }


	if ($product['ManufactureID'] == 'SCO1') {
		$linetotal = $product['Price'] + @$product['Print_Total'];
	}else{
		$linetotal = $product['Price'] + @$product['Print_Total'];
	}
  ?>
  
  <? if($product['Printing'] == 'Y'){ ?>
	<tr class="table-font" style="background: #dff6ff;"   >
<?php }else{?><tr class="table-font" >
	<? }?>
					
						<?php //echo '<pre>'; print_r($product); echo '</pre>'; ?>
						<td><?= $product['ManufactureID'] ?><br>

							<a target="_blank" class="btn btn-default btn-number pdf-download-btn fa-2x" rel="nofollow"
                       data-toggle="tooltip" title="Download PDF Template"
                       href="https://www.aalabels.com/download/pdf/<?= $product['pdfFile']; ?>" role="button"><i
                                class="mdi mdi-file-pdf"></i></a>
							<a target="_blank" class="btn btn-default btn-number word-download-btn fa-2x" rel="nofollow"
                       data-toggle="tooltip" title="Download PDF Template"
                       href="https://www.aalabels.com/theme/site/images/office/word/<?= $product['wordFile']; ?>"
                       role="button"> <i class="mdi mdi-file-word"></i></a>

						</td>
						<td>
							<div class="thumb-sm member-thumb m-b-10 mx-auto">
								<?php if ($product['Image1'] != null) { ?>
												
								<img src="<?= aalables_path_material ?>images/images_products/material_images/<?= $product['Image1'] ?>" class=" img-thumbnails" alt="image">
								<?php } else { ?>
								<img src="<?= liveaa_path ?>images/no-image.png" class="img-thumbnails" alt="image">
								<?php } ?>
							</div>
						</td>
						<td>
                    <?= $product['ProductName'] ?> <br>

                    <hr>
                    <?php  if(count($product['artworks']) > 0) { ?>
                        
                        <div style="display: inline-flex;">
                        <div style="margin-right: 10px;text-align: center;">
                         <a href="<?=main_url?>Artworks/history?order=<?=$product['OrderNumber']?>"  target="_blank" button type= "button" class="view-artwork-cta-style" style="margin-bottom: 10px;">View Artwork </a>
                            </div>  </div>    
                                                                               
                           <?php } ?>
                           
                           
                           
                           
                </td>
                <td class="text-center">
								
							<?php		if($product['Printing']=="Y" || $product['ProductID']=="0" || $product['Print_Type'] == 'Sample' || $product['sample'] == 'sample' || $product['sample'] == 'Sample'){ ?>
									
									<input type="number" id="myqty<?= $product['SerialNumber'] ?>" <?php  if($product['Print_Type'] == 'Sample' || $product['sample'] == 'sample' || $product['sample'] == 'Sample'){ ?> readonly <?php }?> class="form-control  text-center"  value="<?= $product['Quantity'] ?>" placeholder="100" readonly>
									
								<?php	}else{ ?>
									
									<input data-reor="<?= $key ?>" type="number" id="myqty<?= $product['SerialNumber'] ?>" <?php  if($product['Print_Type'] == 'Sample' || $product['sample'] == 'Sample' || $product['sample'] == 'sample'){ ?> readonly <?php }?> class="form-control  text-center "  value="<?= $product['Quantity'] ?>" placeholder="100" onchange="getReoder(<?= $key ?>,<?= $product['SerialNumber'] ?>)">
									
									
									<a class="dff" href="#" id="reo_ups_<?= $product['SerialNumber'] ?>_<?= $key ?>" data-toggle="modal" onclick="update_in_reorder(<?= $key ?>,'<?= $product['ManufactureID'] ?>','<?=$product['SerialNumber'] ?>','<?= $product['ProductID'] ?>','<?= $product['OrderNumber'] ?>','<?=$product['Printable'] ?>','<?= $product['regmark'] ?>')"> Update</a>
								<?php	} ?>
									
							
									<input type="hidden" id="brnds<?php echo $product['SerialNumber'] ?>" value="<?=$product['ProductBrand']?>">
                  <?php		if($product['ProductBrand'] == 'Integrated Labels'){
    $miso  = (preg_match('/250 Sheet Dispenser Packs/is',$product['ProductName']))?250:1000;
            
  } else{
   $miso = $this->orderModal->min_qty_integrated($product['ManufactureID']);
  }?>
									
									
									
									
									
									
                    
                    <input type="hidden" data-min_qty_integrated="<?php echo $product['SerialNumber'] ?>"
                                               value="<?php echo $this->orderModal->min_qty_integrated($product['ManufactureID']); ?>"
                                               disabled>
									<input type="hidden" data-max_qty_integrated="<?php echo $product['SerialNumber'] ?>"
                                               value="<?php echo $this->orderModal->max_qty_integrated($product['ManufactureID']); ?>"
                                               disabled>


									<input type="hidden" data-calulate_min_rolls="<?php echo $product['SerialNumber'] ?>"
                                               value="<?php echo $this->orderModal->calulate_min_rolls($product['ManufactureID']); ?>"
                                               disabled>
									<input type="hidden" data-calulate_max_rolls="<?php echo $product['SerialNumber'] ?>"
                                               value="<?php echo $this->orderModal->calulate_max_rolls($product['ManufactureID']); ?>"
                                               disabled>                  
                
                </td>

                <td class="text-center" id="mainPrice<?= $product['SerialNumber'] ?>">
									<span id="reorder_price<?= $product['SerialNumber'] ?>">
                <? echo $symbol . (number_format($linetotal * $exchange_rate, 2, '.', '')); ?></span>
                <br>
									<input name="" value="" type="hidden" id="is_reorder<?= $product['SerialNumber'] ?>">

           <? if($product['Print_Type']!="Sample"){?>  
									
			<?php if ($product['ManufactureID'] != 'SCO1') { ?>

                   <?php if($product['ProductID']!=0) {?>


                    <span class="add-to-cart-text"><i class=" mdi mdi-cart"></i>
                        <input type="hidden" value="" id="muCartId<?= $product['SerialNumber'] ?>">
                       <a href="#" data-toggle="modal"
                           onclick="addToCart('<?= $product['ManufactureID'] ?>','<?= $product['SerialNumber'] ?>','<?= $product['Printing'] ?>','<?= $product['ProductID'] ?>','<?= $product['OrderNumber'] ?>','<?= $product['ProductBrand'] ?>','','','<?=$product['LabelsPerRoll']?>','<?=$product['regmark']?>')"
                           class="layout_specsss"> Add to Cart</a>
                        </span>
											
                 <? } } }?>
                </td>
                
                <td>
             	<?php 
             	if(preg_match('/Roll Labels/is',$product['ProductBrand'])){?>
             		<span id ="roll<?= $product['SerialNumber'] ?>"> 
             		 <?php echo $product['Quantity'].' '.'Rolls'.' '.'/';?>
             		 </span>
                 	<span id ="labels<?= $product['SerialNumber'] ?>">
                 	<?php 
                      if($product['LabelsPerRoll']==0){
                      		 echo $product['labels'].' '.'Labels';
                      }else{
                 	 echo $product['Quantity'] * $product['LabelsPerRoll'] .' '.'Labels';
                      }
                 	 ?>	
                   </span>
                
          <?php }else{?>

		         	<span id ="sheet<?= $product['SerialNumber'] ?>"> 
		         		<?php echo $product['Quantity'].' '.'Sheets'.' '.'/';?>
		            </span>
                <?php 
                 if($product['labels'] == 0){
                 	?>
                 	<span id ="labels<?= $product['SerialNumber'] ?>">
                 	<?php echo $product['Quantity'].' '.'Labels';?>	
                   </span>
           <?php }else{?>
                 	<span id ="labels<?= $product['SerialNumber'] ?>">
                 	<?php echo $product['labels'].' '.'Labels';?>
                 	</span>
            <?php
                 } 
                }
                ?>
                   <? $symbol . (number_format($linetotal * $exchange_rate, 2, '.', '')); ?>
                      (cost per label
                     <?php  
                if($product['labels'] != 0){
                    	?>
                    <span id="perlabel<?= $product['SerialNumber'] ?>">
                     <?php echo  $perlabelprice= $symbol .(round(($linetotal/ $product['labels']),3));?>
                     </span>
               <? }
                    else{
                    	?>
                    <span id="perlabel<?= $product['SerialNumber'] ?>">
                    
                     <?php echo  $perlabelprice= $symbol . (round(($linetotal/ $product['Quantity']),3));?>
                     </span>
                <? }
                     ?>
                    )
             </td>

            </tr>
					
					
				
					
        <?php $ke++;  } ?>
        </tbody>
    </table>
</td>