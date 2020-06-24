<div class="">
	<div class="container m-t-b-8 ">
		<div class="row">
			<div class="col-xs-12  col-sm-6 col-md-8 ">
				<ol class="breadcrumb  m0">
					<li><a href="https://www.aalabels.com/"><i class="fa fa-home"></i></a></li>
					<li class="active">Quotation Approval</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="bgGray">
  <div class="container">
    <div class="row">
      <div class="col-xs-12  col-sm-12 col-md-12">
        <div class="thumbnail p-l-r-10">
          <div class="row" style="background-color: #17b1e3 ;font-size: 15px;color: #fff;font-weight: bold;margin-left: 2px;margin-right: 2px;padding: 6px;text-align: center;text-transform: uppercase;"><?=$title?></div>
          
          <div class="row">
            
            <div class="col-md-9 col-xs-12" style="list-style: none; float: left; font-size: 15px; line-height: 1.7; margin-top: 6px; margin-  bottom: 6px;">
              
              <h4 class="cBlue" style="margin-bottom:2px ">Billing Address</h4>
              
              <li>
                <h4 class="cblack" style="margin-top:2px ">
                  <?=$quotation[0]->BillingFirstName.' '.$quotation[0]->BillingLastName?>
                </h4>
              </li>
              
              <p style="margin-bottom:0px; font-size:12px">
                <?=$quotation[0]->BillingCompanyName?>
              </p>
              
              <p style="margin-bottom:0px; font-size:12px">
                <?=$quotation[0]->BillingAddress1?> <?=$quotation[0]->BillingAddress2?>
              </p>
              
              <p style="margin-bottom:0px; font-size:12px">
                <?=$quotation[0]->BillingPostcode?> , <?=$quotation[0]->BillingCountyState?>.
              </p>
              
            </div>
            
            
            <div class="col-md-3 col-xs-12" style="list-style: none; float: right; line-height: 1.7; margin-top: 13px; margin-  bottom: 6px; text-align:right">
              <li><strong>VAT No:</strong> GB 945 0286 20</li>
              <li><strong>Date:</strong>  <?= date('jS F Y',$quotation[0]->QuotationDate)?></li>
              <li><strong>Time:</strong> <?=date('h:m:s A',$quotation[0]->QuotationDate)?></li>
            </div>
            
          </div>
          
          <?php //echo '<pre>'; print_r($quotation); echo '</pre>'; ?>
          <?php //echo '<pre>'; print_r($quotationDetails); echo '</pre>'; ?>
          
          <div class="m-t-10">
            <div class="table-responsive ">
              <table class="table table-bordered table-hover">
                <thead class="bgBlueHeading">
                  <tr>
                    <th class="text-center" style="border-right:1px solid #fff !important;" colspan="6" ><?=$mainTitle?></th>
                  </tr>
                </thead>
                <thead style="background-color: #e3e3e3; border: 1px solid black;">
                  <tr>
                    <th class="text-center" style="border-right:1px solid #b9b9b9 !important; width:10%;">PRODUCT</th>
                    <th class="text-center" style="border-right:1px solid #b9b9b9 !important; width:35%">DESCRIPTION</th>
                    <th class="text-center" style="border-right:1px solid #b9b9b9 !important; width:10%">UNIT PRICE</th>
                    <th class="text-center" style="border-right:1px solid #b9b9b9 !important; width:10%">QUANTITY</th>
                    
                    <th class="text-center" style="border-right:1px solid #b9b9b9 !important; width:10%">Ext.VAT</th>
                    <!--<th class="text-center" style="border-right:1px solid #b9b9b9 !important;">Action</th>-->
                  </tr>
                </thead>
                <tbody>
                  
                  <?php
                    $currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';
                    $symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
                    $exchange_rate = $this->home_model->get_exchange_rate($currency);
                  ?>
             
			 
                  <?php
                    $extPrice = 0;
                    $sc  = 0;
                    foreach ($quotationDetails as $key => $quotationDetail) {
                      $extPrice = $extPrice + $quotationDetail->Price + $quotationDetail->Print_Total;
                      
                      $format = '';
                      $regex  = "/Roll/";

                      if(preg_match($regex, $quotationDetail->ProductBrand, $match)){
                        $format ='Roll';
                      } 
                      else {
                        $format ='Sheet';
                      }
                      
                      
                      $query = $this->db->query(" SELECT SUM(labels) AS total from quotation_attachments_integrated WHERE Serial LIKE '".$quotationDetail->SerialNumber."'  ");
		                    $row = $query->row_array();	
                      $no_of_labels =  $row['total'];
                      
                     
                        
                      
                      
                      $Total_labels ='';
                      $per_print = '';
                      
                      if($quotationDetail->is_custom=="Yes"){
                          $Total_labels = $quotationDetail->LabelsPerRoll * $quotationDetail->Quantity;
                      }else{
                          $Total_labels = $quotationDetail->LabelsPerSheet * $quotationDetail->Quantity;
                      }
                      
                      
                      if($quotationDetail->Printing=="Y" && $quotationDetail->regmark!="Y"){
                        
                        $Total_labels = $no_of_labels;
                        
                        if($format=="Roll"){
                          $Total_labels = $Total_labels * $quotationDetail->Quantity;
                        }
                        
                      }
                      
                      
                      if($format=="Roll"){
                        $per_print = $Total_labels / $quotationDetail->Quantity;
                      }else{
                        $per_print = $Total_labels / $quotationDetail->Quantity;
                      }
                      
                      $lbss = '';
                      if($Total_labels > 1){
                        $lbss = 'Labels';
                      }else{
                        $lbss = 'Label';
                        
                      }
                     
                     
                      $is_roll_lb = '';
                      
                      if($format=='Roll'){  
                        $is_roll_lb = 'Rolls';
                      }else{
                        $is_roll_lb = 'Sheets';
                      }
                      
                      
                      
                      
                  ?>
                
                
                  <tr>
                    <td class="text-center labels-form"><b><?= $quotationDetail->ManufactureID ?></b></td>
                    <td class="text-align: justify;"><?= $quotationDetail->ProductName ?><br>
                      <b><?php if($quotationDetail->regmark=="Y"){echo 'Printing Service (Black Registration Mark on Reverse)';}?></b>
                    
                    </td>
                    
                    <td id="labels0" class="text-center">
                      <?=$symbol?><?= number_format($quotationDetail->Price / $quotationDetail->Quantity,2,'.','')  ?><br>
                      Per 100 Labels
                    </td>
                 
                    <?php if($quotationDetail->Printing != 'Y'){?>
                    
                    <td style="text-align:center">
                      <?= $quotationDetail->Quantity.' '.$is_roll_lb?><br>
                      <?=$Total_labels.' '.$lbss?>
                      
                      <input value="<?= $quotationDetail->Print_Type ?> " id="digital<?= $key ?>" type="hidden">
                      <input value="<?= $quotationDetail->Orientation ?>" id="Orientation<?= $key ?>" type="hidden">
                      <input value="<?= $quotationDetail->FinishType ?> " id="finish<?= $key ?>" type="hidden">
                      <input value="<?= $quotationDetail->FinishType ?> " id="wound<?= $key ?>" type="hidden">
                      <input value="<?= $quotationDetail->Print_Qty ?>  " id="design<?= $key ?>" type="hidden">
                      <input value="<?= $quotationDetail->Printing ?>   " id="printer<?= $key ?>" type="hidden">
                      <input value="<?= $quotationDetail->orignalQty ?> " id="totalLabels<?= $key ?>" type="hidden">
                    </td>
                    
                    <?php } else{?>
                    
                    <td  style="text-align:center"><?= $quotationDetail->Quantity.' '.$is_roll_lb?><br>
                                                   <?=$Total_labels.' '.$lbss?></td>
                    
                    <?php } ?>
                    <td class="text-center"><?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2,'.','') ?></td>
                  </tr>
                  
                  <?php if($quotationDetail->Printing == 'Y' && $quotationDetail->regmark != 'Y'){?>
                  <tr>
                    <td class="text-center labels-form"></td>
                    <?php include(APPPATH . 'views/emails/generate_text_line.php'); ?>
                    <td style="text-align:center">
                      
                      <?php if($format=="Sheet"){ ?>
                      <?=$symbol?><?=number_format(5.32 * $exchange_rate, 2,'.','')?><br>Per Design<?php //round($quotationDetail->Print_Total/$quotationDetail->Print_Qty,2) ?>
                     
                      <?php } else{?>
                      ----
                      <?php } ?>
                    </td>
                    
                    <?php 
                          $des_gn = '';                           
                          if($quotationDetail->Print_Qty > 1){
                            $des_gn ='Designs';
                          }else{
                            $des_gn ='Design';
                          }
                                                             
                          $des_free = '';                           
                          if($quotationDetail->Free > 1){
                            $des_free ='Designs';
                          }else{
                            $des_free ='Design';
                          }
                    ?>
                    
                    <td class="text-center"><?= $quotationDetail->Print_Qty.' '.$des_gn?> <br>
                      
                      <?php if($format=="Sheet"){ ?>
                      (<?= $quotationDetail->Free.' '.$des_free?> Free)
                      <?php } ?>
                      
                    </td>
                    <td class="text-center"><?=$symbol?><?= $quotationDetail->Print_Total ?></td>
                  </tr>
                  <?php }?>
                  
                  
                  <tr>
                    <td colspan="2"></td>
                    
                    <td colspan="3">
                      
                      <?php if(($quotationDetail->view_row_status=='d') || ($quotationDetail->view_row_status!='r') && ($quotationDetail->active!="c") ){ ?>
                      
                       <? if($quotation[0]->view_status=="Declined" && $quotationDetail->view_row_status=='d'){
                                    echo "<a class='btn orange' style='float:right'>Declined</a>";
                      } else{?>
                      
                      <button type="button" id="activate-step-1122" onclick="" class="btn orange chekclist" data-sr="<?=$quotationDetail->SerialNumber?>" data-q="<?=$quotationDetail->QuotationNumber?>">DECLINE</button>
                      
                      <?php } }?>
                      
                       <?php if(($quotationDetail->view_row_status=='r') || ($quotationDetail->view_row_status!='d') && ($quotationDetail->active!="c") ){ ?>

                      <? if($quotation[0]->view_status=="Requoted" && $quotationDetail->view_row_status=='r'){
                    
                                    echo "<a class='btn orange' style='float:right'>Requoted</a>";
                      
                      } else{?>
                      
                      <button type="button" id="activate-step-1122" onclick="" class="btn orange requoted" data-srs="<?=$quotationDetail->SerialNumber?>" data-qs="<?=$quotationDetail->QuotationNumber?>">REQUEST REQUOTE</button>
                      
                      <?php } } ?>
                      
                      
                      
                       <?php if(($quotationDetail->active=="c") || ($quotationDetail->view_row_status!='d'&& $quotationDetail->view_row_status!='r')){ ?>
                      
                      <span id="line_<?=$quotationDetail->SerialNumber?>">
                      <? if($quotationDetail->active=="c" || $quotation[0]->QuotationStatus != 37){
                            echo "<a class='btn orange' style='float:right'>Added</a>"; }else{ ?>    
                        
                      <a href="javascript:void(0);" class="btn orangeBg pull-right" onclick="SetQuotationToCart(<?=$quotationDetail->SerialNumber?>,'<?= $quotationDetail->ProductName ?>','<?= $quotationDetail->ProductID ?>','<?=$quotation[0]->UserID;?>','<?=@$tm;?>','<?= $quotationDetail->Quantity ?>','<?= $quotationDetail->orignalQty ?>','<?= $quotation[0]->QuotationTotal ?>','<?=@$dates?>','<?= $quotationDetail->LabelsPerRoll; ?>','<?= $quotationDetail->colorcode; ?>','<?= $quotationDetail->is_custom; ?>','<?= $quotationDetail->wound; ?>','<?=$quotationDetail->Printing; ?>','<?= $quotationDetail->Print_Total; ?>','<?= $quotationDetail->Print_Type; ?>','<?= $quotationDetail->FinishType; ?>','<?=$quotationDetail->Print_Design; ?>','<?= $quotationDetail->Print_Qty; ?>','<?= $quotationDetail->Free; ?>','<?= $quotation[0]->Source; ?>','<?=$quotationDetail->Orientation; ?>','<?=$quotationDetail->Price?>','<?=$quotationDetail->QuotationNumber?>','<?=$quotationDetail->regmark?>');">Add to Basket</a>
                      <? } ?>
                      </span>
                      
                      <?php } ?>
                      
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
            
            <div class="row">
              <div class="col-md-8"> 
                
                
               
              
              </div>
              <div class="col-md-4" style="">
                
                <?php
                $deliveryamount = $quotation[0]->QuotationShippingAmount /1.2;
                $subtotal = $sc + $extPrice + $deliveryamount;
                $grandfinaltotal = $subtotal * 1.2;
                $vatvalue = $grandfinaltotal - $subtotal;

                if($quotation[0]->vat_exempt == 'yes'){
                  $grandfinaltotal = $subtotal;   
                }?>
                
                
                <?php 
                $vat_ex_vat20 = '';
                $vat_ex_vat20Val = '';
                if($quotation[0]->vat_exempt == 'yes'){
                  $vat_ex_vat20 = 'VAT EXEMPT';
                  $vat_ex_vat20Val = '-'.$symbol.number_format($vatvalue * $exchange_rate, 2,'.','');
                } else {
                $vat_ex_vat20 ='VAT @ 20%:';
                $vat_ex_vat20Val = $symbol.number_format($vatvalue * $exchange_rate, 2,'.','');
                
                } ?>
                
                
                
                
                
                
                
                <div class="m-t-10">
                  <div class="table-responsive " style="border-radius: 2px;">
                    <table class="table table-bordered table-hover">
                      
                      <!--<tr>
                        <td>DELIVERY:</td>
                        <td><?= $symbol ?><?= number_format($deliveryamount * $exchange_rate, 2,'.','') ?></td>
                      </tr>-->
                      
                      <tr>
                        <td class="text-center">SUB-TOTAL:</td>
                        <td class="text-center"><?= $symbol ?><?=number_format($subtotal* $exchange_rate, 2,'.','');?></td>
                      </tr>
                      
                      <tr>
                        <td class="text-center"><?=$vat_ex_vat20?></td>
                        <td class="text-center"><?=$vat_ex_vat20Val?></td>
                      </tr>
                      
                      <tr>
                        <td class="text-center"><b>GRAND TOTAL:</b></td>
                        <td class="text-center"><b><?=$symbol?><?php  echo number_format($grandfinaltotal * $exchange_rate, 2,'.',''); ?></b></td>
                      </tr>
                      
                    </table>
                  </div>
                </div>
                
                
               <?php /* ?> <li>DELIVERY :</li>
                <li>SUB-TOTAL :</li>
                <?php if($quotation[0]->vat_exempt == 'yes'){?>
                <li>VAT EXEMPT :</li>
                <?php } else {?>
                <li>VAT @ 20% :</li>
                <?php } ?>
                <li style="color:#fd4913;">GRAND TOTAL :</li><?php */ ?>
                
              </div>
              
            <?php /* ?>  <div class="col-md- pull-right text-right" style="list-style:none;font-weight:bold;line-height: 1.7;padding-right: 32px;">
                
                <?
                $deliveryamount = $quotation[0]->QuotationShippingAmount /1.2;
                $subtotal = $sc + $extPrice + $deliveryamount;
                $grandfinaltotal = $subtotal * 1.2;
                $vatvalue = $grandfinaltotal - $subtotal;

                if($quotation[0]->vat_exempt == 'yes'){
                  $grandfinaltotal = $subtotal;   
                }
                ?>
                <li>
                  <?= $symbol ?><?= number_format($deliveryamount * $exchange_rate, 2,'.','') ?>
                </li>
                
                <li>
                  <?= $symbol ?><?=number_format($subtotal* $exchange_rate, 2,'.','');?>
                </li>
                
                <?php if($quotation[0]->vat_exempt == 'yes'){?>
                <li> -
                  <?=$symbol?><?php  echo number_format($vatvalue * $exchange_rate, 2,'.',''); ?>
                </li>
                <?php } else{?>
                <li>
                  <?=$symbol?><?php  echo number_format($vatvalue * $exchange_rate, 2,'.',''); ?>
                </li>
                <?php } ?>
                <li style="color:#fd4913;">
                  <?=$symbol?><?php  echo number_format($grandfinaltotal * $exchange_rate, 2,'.',''); ?>
                </li>
              </div><?php */ ?>
              
              
              
            </div>
            <?php if($quotation[0]->vat_exempt == 'yes'){
                  $vat = 'Y';
                }else{
                  $vat = 'N';
                }
            ?>
          
          <? /*if($quotation[0]->QuotationStatus == 37){ ?>
          
            <div class="row m-t-15">
              <div class="col-xs-3 col-sm-3 pull-right "> 
               
                <button type="button" onclick="ConvertAllQoutation('<?=$quotation[0]->QuotationNumber?>');"   class="btn orangeBg btn-block ">Add to Basket</button>
              </div>
              <div class="col-xs-3 col-sm-3 pull-right ">
                <button type="button" onclick="showDeclineNotePopUp()"  class="btn orangeBg btn-block compare_btn services-form">Decline with Notes</button>
              </div>
              <div class="col-xs-3 col-sm-3 pull-right ">
                <button type="button" id="activate-step-2" onclick="accept_pay('<?=$quotation[0]->QuotationNumber?>');" class="btn orange pull-right btn-block">Accept and Pay Later</button>
              </div>
              <!--                            <div   class="col-xs-3 col-sm-3 pull-right paypal_selection_box" id="paypal-button-checkout">--> 
              <!----> 
              <!--                            </div>--> 
              
            </div>
            
         <? } */?>   
            
            
          </div>
          <!-- /.row --> 
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-md" id="decline_with_note" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <div class="modal-content blue-background">
      <div class="modal-header checklist-header" style="    border-bottom: 0px;">
        <div class="col-md-12">
          <h4 class="modal-title checklist-title" id="myLargeModalLabel" style="text-align: center;font-size: 20px;font-weight: bold;color: #333;">Decline Notes</h4>
          <p class="timeline-detail text-center">Please enter the notes here.</p>
        </div>
      </div>
      <div class="modal-body p-t-0">
        <div class="panel-body">
          <style>
                            .custom-die-input {
                                width: 97%;
                                border: 1px solid #cccccc;
                                border-radius: 4px;
                                height: 33px;
                                color: #666666;
                                margin-bottom: 4px;
                                padding-left: 6px;
                            }

                            .blue-text-field {
                                border: 1px solid #cccccc !important;
                                width: 97%;
                            }

                            .m-r-3 {
                                margin-right: 3%;
                            }
                        </style>
          <div class="col-12 no-padding">
            <input type="" id="number" value="<?=$quotation[0]->QuotationNumber?>">
            <div class="divstyle" style="margin-bottom:5px;"><b class="label"></b>
              <input type="text" name="die_title" id="die_title" placeholder="Enter Title Here"
                                       class=" custom-die-input">
            </div>
          </div>
          <div class="col-12 no-padding" style="margin-bottom: 17px;">
            <textarea class="form-control blue-text-field" name="die_note" rows="5" id="die_note" placeholder="Enter Description Here"></textarea>
          </div>
          <div class="row"> <span>
            <button id="ad_nt" type="button" onclick="addDeclineNote()" class="btn orangeBg btn-block compare_btn services-form" style="width: 25%;margin: 0% 38%;">Submit</button>
            </span></div>
        </div>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<input id="sr_number" type="hidden">
<input id="q_number" type="hidden">


<div class="modal fade bs-example-modal-lg checklist-modal"  id="popupdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
  
</div>






<div class="modal fade bs-example-modal-lg checklist-modal-requote" id="popupdivs"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
  <!-- /.modal-dialog -->
</div>



<script>
 function showDeclineNotePopUp(){
	$('#decline_with_note').modal('show');
}
		
		
function SetQuotationToCart(SerialNumber,ProductName,ProductID,UserID,tm,Quantity,orignalQty,TotalPrice,dates,LabelsPerRoll,colorcode,is_custom,wound,Printing,Print_Total,Print_Type,FinishType,Print_Design,Print_Qty,Free,source,orientation,price,QuotationNumber,regmark) {
swal({

title: "Are You Sure You want to Add Product in Basket?",
text: "",
type: "warning",
showCancelButton: true,
confirmButtonClass: "btn orangeBg",
confirmButtonText: "Yes",
cancelButtonClass: "btn blueBg",
cancelButtonText: "Cancel",
closeOnConfirm: true,
closeOnCancel: true
},
     
function(isConfirm) {
if (isConfirm) { 
 $.ajax({
	type: "post",
	url: base + "email/quotationToCart",
	data: {
	'SerialNumber': SerialNumber,
 'QuotationNumber':QuotationNumber,
	'ProductID': ProductID,
	'UserID': UserID,
	'OrderTime': tm,
	'Quantity': Quantity,
	'orignalQty': orignalQty,
	'Price':price,
	'TotalPrice': TotalPrice,
	'OrderData': dates,
	'LabelsPerRoll': LabelsPerRoll,
	'colorcode': colorcode,
	'is_custom':is_custom,
	'wound': wound,
	'Printing': Printing,
	'Print_Total': Print_Total,
	'Print_Type': Print_Type,
	'FinishType': FinishType,
	'Print_Design': Print_Design,
	'Print_Qty': Print_Qty,
	'Free': Free,
	'source': source,
	'orientation': orientation,
 'regmark':regmark

    },
   dataType: 'html',
   success: function (data) {
     $('#line_'+SerialNumber).html('<a class="btn orange" style="float:right">Added</a>');     
     swal(ProductName,'Added to basket Successfully','success');
     
     $("[data-sr='"+SerialNumber+"']").hide();
     $("[data-srs='"+SerialNumber+"']").hide();
     
	 
   }
 });
}
   }
  );
}

        
  function addDeclineNote(){
          
    var title = $('#die_title').val();
    var note = $('#die_note').val();
    var orderNumber =  $('#number').val();

    if(title == null || title ==""){
      show_faded_popover('die_title','Please choose');
      return false;
    }
    
    if(note == null || note ==""){
      show_faded_popover('die_note','please Add Note'); 
      return false;
    }

    $.ajax({
              
      url: base+'email/addDeclineNote',
      type:"POST",
      async:"false",
      dataType: "html",
      data: {title:title,note:note,orderNumber:orderNumber},
      success: function(data){
        $('#decline_with_note').modal('hide');
				
        swal({

          title: "Quotation decline Successfully",
          text: "",
          type: "success",
          showCancelButton: true,
          confirmButtonClass: "btn orangeBg",
          confirmButtonText: "Yes"
        },
				  	
             function(isConfirm) {
          if (isConfirm) { 
            window.location = "https://www.aalabels.com/";
          }
        }	
            );
      }
    });
  }
  

  
  var timer = '';

  function show_faded_popover(_this, text){
		$(_this).attr('data-content','');
		$(_this).popover('hide');
		$(_this).popover('destroy');
		$(_this).popover({'placement':'top'});
		$(_this).attr('data-content',text);
		$(_this).popover('show');
		clearTimeout(timer);
		timer = setTimeout(function(){ 
				$(_this).attr('data-content','');
				$(_this).popover('hide');
				$(_this).popover('destroy');
		}, 5000);
}


function ConvertAllQoutation(id){
	
swal({
	title: "Are You Sure add to basket?",
	text: "",
	type: "warning",

	showCancelButton: true,
	confirmButtonClass: "btn orangeBg",
	confirmButtonText: "Yes",
	cancelButtonClass: "btn blueBg",
	cancelButtonText: "Cancel",
	closeOnConfirm: true,
	closeOnCancel: true
},

function(isConfirm) {

	if (isConfirm) {
		
		 $.ajax({
			type: "post",
			url: base + "email/ConvertAllQoutation",
			data: {
			'quotationid': id
			},
			dataType: 'html',
			success: function (data) {
			   swal({
				   title: "Success",
					text: "Add to basket Successfully.",
					type: "success",
					showCancelButton: true,
					confirmButtonClass: "btn orangeBg",
					confirmButtonText: "OK",
					},
					function(isConfirm) {
					 if(isConfirm) {
					   window.location = "https://www.aalabels.com/transactionregistration.php";
					  } 
					}
				  ); 
			 },
		  });
	   }
    }
   ); 
 }
 
 
function accept_pay(orderNumber){
			
			swal({
				title: 'Are you sure you want to Accept this Quotation?',
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn orangeBg",
				confirmButtonText: "Yes",
				
				closeOnConfirm: true,
				closeOnCancel: true
			},
				 function(isConfirm) {
				if(isConfirm){
					
					$.ajax({

						url: base+'email/accept_pay',
						type:"POST",
						async:"false",
						dataType: "html",
						data: {
								orderNumber:orderNumber
							  },

						success: function(data){
					
							swal({
								title: 'Quotation approved successfully?',
								type: "success",
								showCancelButton: true,
								confirmButtonClass: "btn orangeBg",
								confirmButtonText: "YES",
						
								closeOnConfirm: true,
								closeOnCancel: true
							},
								 function(isConfirm) {
								if (isConfirm) {
									window.location = "https://www.aalabels.com";		   
								} 
							});
						
		
						}
			
					});
				
				} 
			});
			
		}
  
  
  $(document).on("click", ".chekclist", function(e) {
    
     var sr =  $(this).data('sr');
    $('#sr_number').val(sr);
    
    var q_sr =  $(this).data('q');
    $('#q_number').val(q_sr);
    
    $('#aa_loader').show();
    $.ajax({
      type: "post",
      url: base+"email/chekclist",
      cache: false,               
      data:{},
      dataType: 'html',
      success: function(data){
        data = $.parseJSON(data);
        $('#aa_loader').hide();
        $('#popupdiv').html(data.html);
        $('.checklist-modal').modal('show');
      },
      error: function(){                      
        alert('Error while request..'); 
      }
    });
  });
  
 
  
  
  function decline_fun(){

    var title = '';
       
    if($("input:radio[name='q']").is(":checked")) {
      title = $('input[name=q]:checked').val();
    }else{
      title = '';
    }
               
    var note = $('#die_notes').val();
    var orderNumber =  $('#sr_number').val();
    var qNumber =  $('#q_number').val();
    if(title == null || title ==""){
      show_faded_popover('#checkboxss','Please Choose');
      return false;
    }

    /*if(note == null || note ==""){
      show_faded_popover('#die_notes','please Add Note'); 
      return false;
    }*/

    $.ajax({
            
      url: base+'email/addDeclineNote',
      type:"POST",
      async:"false",
      dataType: "html",
      data: {title:title,note:note,orderNumber:orderNumber,qNumber:qNumber,typ:'decline'},
      success: function(data){
        //$('#decline_with_note').modal('hide');
        
        $('.checklist-modal').modal('hide');
				
        swal({

          title: "Are you sure you want to decline this line?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn orangeBg",
          confirmButtonText: "Yes"
        },
				  	
             function(isConfirm) {
          if (isConfirm) {
            
            
            if(title!="Requirement changed. New quote required." || title!="Requirement changed. No quote required."){
              $("[data-sr='"+orderNumber+"']").removeClass('chekclist');
              $("[data-sr='"+orderNumber+"']").text('Declined');
              $("[data-sr='"+orderNumber+"']").css('float','right');
              
              $("[data-srs='"+orderNumber+"']").hide();
              $("#line_"+orderNumber).hide();
            }
            
            
            //window.location = "https://www.aalabels.com/";
          }
        }	
            );
      }
    });
       
    }
  
   $(document).on("click", ".requoted", function(e) { 
    
    var sr =  $(this).data('srs');
    $('#sr_number').val(sr);
    
    var q_sr =  $(this).data('qs');
    $('#q_number').val(q_sr);
    $('.checklist-modal-requote').modal('show');
     
     
     
     $('#aa_loader').show();
     $.ajax({
       type: "post",
       url: base+"email/requotes",
       cache: false,               
       data:{},
       dataType: 'html',
       success: function(data){
         data = $.parseJSON(data);
         $('#aa_loader').hide();
         $('#popupdivs').html(data.html);
          $('.checklist-modal-requote').modal('show');
       },
       error: function(){                      
         alert('Error while request..'); 
       }
     });

   });
  
  function requotes_fun(){

    var title = '';
       
    if($("input:radio[name='q']").is(":checked")) {
      title = $('input[name=q]:checked').val();
    }else{
      title = '';
    }
               
    var note = $('#die_notes').val();
    var orderNumber =  $('#sr_number').val();
    var qNumber =  $('#q_number').val();
    if(title == null || title ==""){
      show_faded_popover('#checkboxss','please Add Title');
      return false;
    }

    /*if(note == null || note ==""){
      show_faded_popover('#die_notes','please Add Note'); 
      return false;
    }*/

    $.ajax({
            
      url: base+'email/addDeclineNote',
      type:"POST",
      async:"false",
      dataType: "html",
      data: {
        title:title,
        note:note,
        orderNumber:orderNumber,
        qNumber:qNumber,
        typ:'requote'
      },
      
      success: function(data){
				$('.checklist-modal-requote').modal('hide');
        swal({

          title: "Are you sure you want to Requote this line?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn orangeBg",
          confirmButtonText: "Yes"
        },
				  	
             function(isConfirm) {
          if (isConfirm){
            $("[data-srs='"+orderNumber+"']").removeClass('requoted');
            $("[data-srs='"+orderNumber+"']").text('Requoted');
            $("[data-srs='"+orderNumber+"']").css('float','right');
            
            
            
            $("[data-sr='"+orderNumber+"']").hide();
            $("#line_"+orderNumber).hide();
            
            
          }
        });
        
        
      }
    });
       
    }
 
 
 
</script> 
