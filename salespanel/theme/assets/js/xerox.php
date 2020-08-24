

<style>
#fallr{
padding:0px !important;	
height:auto !important;
margin-left:20px;
width:900px !important;

}
#fallr-wrapper {
  height: 225px;
  left: 100px;
  position: fixed;
  top: 0;
  width: 930px;
  z-index: 101;
}

/*#fallr-overlay {
	  background: none repeat scroll 0 0 #333;
	 display:none;
	 position:fixed;
	 left:0;
	 top:0;
	 
	 height:100%;
	 width:100%;
	 -ms-filter:"alpha(opacity=50)";
	 filter:alpha(opacity=50);
	 opacity:0.5;
	 
	 }
#fallr-wrapper,#fallr-wrapper *{margin:0;padding:0;border:0;outline:0;font-family:Helvetica,Ubuntu,Arial,sans-serif;font-size:13px;font-weight:normal;line-height:19px;color:#555;text-shadow:1px 1px 1px #fff;vertical-align:baseline;-webkit-font-smoothing:antialiased}
#fallr-wrapper{position:fixed;overflow:hidden;background:#f0f0f0;border:1px solid #fff;box-shadow:0 0 5px #111;-moz-box-shadow:0 0 5px #111;-webkit-box-shadow:0 0 5px #111}
#fallr-icon{position:absolute;top:35px;left:20px;height:64px;width:64px;background-position:0 0;background-repeat:no-repeat}
#fallr{position:relative;padding:40px 20px 20px 72px}
#fallr-buttons{position:relative;bottom:0;right:0;margin:15px;clear:both;display:block;text-align:right}
#fallr-wrapper .fallr-button,#fallr button,#fallr input[type="submit"]{position:relative;overflow:visible;display:inline-block;padding:4px 15px;border:1px solid #d4d4d4;margin-left:10px;margin-top:10px;text-decoration:none;text-shadow:1px 1px 0 #fff;white-space:nowrap;cursor:pointer;background-color:#ececec;background-image:-webkit-gradient(linear,0 0,0 100%,from(#f4f4f4),to(#ececec));background-image:-moz-linear-gradient(#f4f4f4,#ececec);background-image:-o-linear-gradient(#f4f4f4,#ececec);background-image:linear-gradient(#f4f4f4,#ececec);-webkit-background-clip:padding;-moz-background-clip:padding;-o-background-clip:padding-box;border:1px solid rgba(0,0,0,.25);-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
#fallr-wrapper .fallr-button:hover,#fallr-wrapper .fallr-button:focus,#fallr button:hover,#fallr button:focus,#fallr input[type="submit"]:hover,#fallr input[type="submit"]:focus{border-color:#3072b3;border-bottom-color:#2a65a0;text-decoration:none;text-shadow:-1px -1px 0 rgba(0,0,0,0.3);color:#fff;background-color:#3c8dde;background-image:-webkit-gradient(linear,0 0,0 100%,from(#599bdc),to(#3072b3));background-image:-moz-linear-gradient(#599bdc,#3072b3);background-image:-o-linear-gradient(#599bdc,#3072b3);background-image:linear-gradient(#599bdc,#3072b3)}

#fallr-wrapper .fallr-button.fallr-button-danger {
    color: #900;
}
#fallr-wrapper .fallr-button.fallr-button-danger:hover,#fallr-wrapper .fallr-button.fallr-button-danger:focus{border-color:#b53f3a;border-bottom-color:#a0302a;color:#fff;background-color:#dc5f59;background-image:-webkit-gradient(linear,0 0,0 100%,from(#dc5f59),to(#b33630));background-image:-moz-linear-gradient(#dc5f59,#b33630);background-image:-o-linear-gradient(#dc5f59,#b33630);background-image:linear-gradient(#dc5f59,#b33630);}*/

.icon-check {
    background: url("<?=base_url()?>aalabels/img/task-complete.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.icon-error {
    background: url("<?=base_url()?>aalabels/img/acces-denied-sign.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
}

._25 {
    display: inline;
    float: left;
    margin-left: 2%;
    margin-right: 2%;
    width: 21%;
}

._50 {
    display: inline;
    float: left;
    margin-left: 2%;
    margin-right: 2%;
    width: 46%;
}
button, input[type="submit"], input[type="reset"], a.button {
  background: #417bb5 none repeat scroll 0 0;
  color: #fff;
  display: block;
  height: 35px;
  line-height: 24px;
  width: 210px;
}

.preview{
  color: red;
  cursor: pointer;
  font-weight: bold;
  margin: 10px;
}
</style>
<?
 $picklist_query = $this->db->query("select * from orderdetails where ProductionStatus = 11 and machine LIKE 'picklist'")->result();
 $picklist = count($picklist_query);
?>
<?php $user  = $this->session->userdata('UserName'); ?>
<div role=main class=container_14 id=content-wrapper> 
    <div id=main_content>
       
         <a class="button" style="font-size:16px;text-align:center;float:right;width:20%;margin:-12px 50px;line-height:32px;background:red;" href="<?php echo backoffice_url(); ?>machines/Pick_list" target="_blank">
             <b>Jobs to be Picked from Stock: <?=$picklist?></b>
         </a>
         <a class="button" style="font-size:16px;text-align:center;float:right;width:12%;margin:-12px 50px;line-height:32px;background:#4d87c1;" href="<?php echo backoffice_url(); ?>machines/canon" target="_blank">
             <b>Canon Screen (Beta)</b>
         </a>
        <h2 class=grid_14>Canon</h2> 
         <div class=grid_14>
          <div style="border:1px solid;height:15px;width:15px;background-color:yellow;float:left;margin-right:5px;"></div><b>Rejected From Qc </b>
         </div>
        <div class=clean></div> 
    </div> 
    <div class="grid_14">
        <div class="box">
            <div class="header">
                <img width="16" height="16" src="<?php echo base_url(); ?>aalabels/img/table-excel.png">
                <h3>Normal Print Jobs <?=(count($printjobs))?> </h3>
            </div>
            <div class="content">
                <div class="dataTables_wrapper">
                    <div class="top">
                    </div>
                    <table id="table-example" class="table">
                        <thead>
                            <tr>
								 <th width="10">Sr#</th>
                                 <th width="60">Print Job#</th>
                                 <th width="80">Order No</th>
                                 <th width="200">Material</th>
                                 <th width="180">Artwork Approval Date and time</th>
								 <th width="80">Item Code</th>
                                 <th width="40">Name </th>
                                 <th width="40">Print Type </th>
                                 <th width="40">Softproof </th>
                                 <th width="40">Print </th>
                                 <th width="100">Box</th>
                                 <th width="80">Bag</th>
                                 <th width="80">Bag</th>
                                 <th width="40">Total Sheets </th>
                                 <th width="30">Status</th>
                                 <th width="30" align="center">Print CSLD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$printed = '';
							$ProductName = '';
							$i=0;
							$UserTypeID  = $this->session->userdata('UserTypeID');
							
						    foreach ($printjobs as $data){
								$style = ''; $style123=''; $i++;
                                $ManufactureID = $data->diecode;
								$materialcode = $this->quoteModel->getmaterialcode($ManufactureID);
								$canvas = AJAXURL.'/theme/integrated_attach/'.$data->file;
								$canvas = AJAXURL.'/theme/integrated_attach/'.$data->file;
							//	$pdf = AJAXURL.'/theme/integrated_attach/'.$data->file;
								$pdf = AJAXURL.'/theme/site/printing/chat/print/'.$data->print_file;
								$softproof = AJAXURL.'/theme/site/printing/chat/softproof/'.$data->softproof;
								$qty = $data->qty; 
								$width = '40';
								 if(preg_match('/.pdf/is',$canvas)){
								   $canvas = AJAXURL.'/theme/site/images/pdf.png';
								 }
							   $jobnumber = $data->ID;	
							   $materailname = $this->db->query("SELECT * FROM `box_labels` WHERE `mat` LIKE '".$materialcode."'")->row_array();
							   $pro_detail = $this->db->query("select Product_detail,source,labels from `orderdetails` where `SerialNumber` = '".$data->Serial."'")->row_array();
					
					
						$orderline = $this->db->query("SELECT Label FROM `orders` WHERE `OrderNumber` LIKE '".$data->OrderNumber."'")->row_array();
		                $data->Label = $orderline['Label'];
		
		?>
							
                                   <? $bakcol = ($data->qc==1)?'yellow':''; ?>
                             
                                  <tr>
									  <td><b><?=$i?></b></td>
                                    <td style="background-color:<?=$bakcol?>">PJ<?=$data->ID?>
                                    <? if($data->qc==1){?> 
                                       <a onclick="showfeedback('<?=$data->ID?>')"><b style="cursor:pointer">Feedback</b></a> 
									<? } ?>
                                    </td>
                                    <td><b><?php echo $data->OrderNumber; ?></b>
                                    <? if($pro_detail['source']=="LBA"){ ?>
                        				    <br><b class="redish">(FLDT)</b>
                        				<? } ?>
                                    
                                    
                                    </td>
                                    <td><?=$materailname['name']?>
                                    <? $detail_view = $this->quoteModel->check_product_extra_detail($ManufactureID); 
                                       if($detail_view['prompt']=='yes'){ echo '<br /><b style="color:green;font-weight:bold;">'.$detail_view['detail'].'</b>';}
                                       if($pro_detail['Product_detail']!=""){?>
                                       <br />-<b style="color:red;font-size:10px;"><? echo "  ".$pro_detail['Product_detail']." ";?></b>
                                    <? } ?>
                                    </td>
                                  
                                    <td><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> h : i  A</b>', ($data->approve_date)); ?></td>
                                    <td><?php echo str_replace('AA','',$ManufactureID) ?></td>
									<td><?=$data->name?></td>
                                    <td><?=$data->design_type?></td>
                                    
                                    <td><a title="click to download" target="_blank" href="<?=$softproof?>" style="color:blue;cursor:pointer;text-decoration:underline;">
                                        View Softproof
                                         </a>
                                   </td>
                                    <td><a title="click to download" target="_blank" href="<?=$pdf?>" style="color:blue;cursor:pointer;text-decoration:underline;">
                                         View Print File
                                         </a>
                                    </td>
                                  
                                    
      <?
        $check_printing  = $this->db->query("select count(*) as total from printing_produced where jobid = $jobnumber ")->row_array();
		if($check_printing['total']==0){ 
		  $this->machine_model->add_labels_division($data->Serial,$jobnumber,$data->OrderNumber,$ManufactureID,$materialcode,$data->Label);
		}
	    $box_labels  = $this->db->query("select * from printing_produced where jobid = $jobnumber and type LIKE 'box' ")->row_array();
		$bag_labels  = $this->db->query("select * from printing_produced where jobid = $jobnumber and type LIKE 'bag' ")->row_array();
		$pack_labels  = $this->db->query("select * from printing_produced where jobid = $jobnumber and type LIKE 'pack' ")->row_array();
      ?>                                 
                   <td><b style="color:red"><?php echo (empty($box_labels))?"---":$box_labels['quantity']." x ".$box_labels['pack'] ?></b> <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                   <td><b style="color:red"><?php echo (empty($bag_labels))?"---":$bag_labels['quantity']." x ".$bag_labels['pack'] ?></b> <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                   <td><b style="color:red"><?php echo (empty($pack_labels))?"---":$pack_labels['quantity']." x ".$pack_labels['pack'] ?></b> <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                     <td><?php echo '<b>'.$qty.'</b>'; ?>
                       <? if($pro_detail['source']=="LBA"){ ?>
                            <br><b class="redish">(<?=$pro_detail['labels']?>)</b>
                       <? } ?>
                     
                     
                     </td>          
                               <td>
                                <?
                                if ($data->status == 7) {
                                       echo "<span style='color:#c9ab40;'><b>Completed</b></span>";  } 
                                       else{ ?>
                                       
                                     
                                     <? if($UserTypeID!=22){?>  
                                      <button onclick="javascript:complete_print_jobs('<?=$data->Serial?>','<?=$data->OrderNumber?>','<?=$data->ID?>');" style="width:120px;height:55px;">
                                      Complete Line and Print Label</button>   
                                      <? } ?>
                                      
                                      
                                    <? }?>
                                    </td>
                                    
                                        <td align="center">
                                            <a target="_blank" href="<?php echo backoffice_url(); ?>machines/printA4_csld/<?=$data->OrderNumber?>/<?=$data->ID?>"  >
                                                <button type="button" style="width:52px;height:75px">
                                                <i class="fa fa-print" aria-hidden="true"></i>Print CSLD</button> 
                                            </a>
                                        
                                       </td>
                                       
                               </tr>
                            <?php } ?>  
         
         
         
                          </tbody>
                    </table>
                </div> 
            </div>
            <div class="clear"></div>
        </div>  <!-- End of box-->
     <div class="clear"></div>
  </div>   <!-- End of grid_14-->
  
  
  
   <div class="grid_14">
        <div class="box">
            <div class="header">
                <img width="16" height="16" src="<?php echo base_url(); ?>aalabels/img/table-excel.png">
                <h3>LBA & LD Print Jobs <?=(count($printing))?> </h3>
            </div>
            <div class="content">
                <div class="dataTables_wrapper">
                    <div class="top">
                    </div>
                    <table id="table-example" class="table">
                        <thead>
                            <tr>
                                 <th width="10">Sr#</th>
                                 <th width="80">Order No</th>
                                 <th width="250">Material</th>
                                 <th width="180">Date and time</th>
								 <th width="80">Item Code</th>
                                 <th width="40">Name</th>
                                 <th width="40">Print type</th>
                                 <th width="40"> Print</th>
                                 
                                 <th width="100">Box</th>
                                 <th width="80">Bag</th>
                                 <th width="80">Bag</th>
                                 <th width="40"> Total Sheets</th>
                                 <th width="200">Status</th>
                                 <th width="30" align="center">Print CSLD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$printed = '';
							$ProductName = '';
							$i=0;
					$ab= 0;
						    foreach ($printing as $data){
								$ab++;
								$style = ''; $style123='';
								$services = $this->production_model->Get_ServiceName($data->ShippingServiceID);
                                $ManufactureID = $data->ManufactureID;	
								$ProductName = $data->ProductName;
								$materialcode = $this->quoteModel->getmaterialcode($ManufactureID);
								$btn_text = "Complete Line and Print Label";
								$window = "true";
							
							
								
				            if($data->ProductBrand == 'Application Labels'){  
								 $btn_text = "Complete Line";
								 $window = "false";
								
								 $colorcode = (isset($data->colorcode) and $data->colorcode!='')?'-'.$data->colorcode:''; 
								 $pinfo = $this->production_model->get_product_line($data->ProductID, 'aa');
								 $pdf =  Assets."images/application/printing/".$pinfo['123ManufactureID'].$colorcode.'.pdf';	
								 $designcode = substr($data->ManufactureID, -4);
								
								 $canvas =  Assets."images/application/design/".$designcode.$colorcode.'.png';
								 $ManufactureID = substr( $data->ManufactureID,0,-4).'-'.substr($data->ManufactureID,-4);
								 $style = 'style="background:#FDEBB4;border:1px dotted #bebebe;"'; 
								 $width='60';
								 $title = 'LBA';
								 $materialcode = $this->quoteModel->getmaterialcode(substr($data->ManufactureID, 0, -4));
								 $materailname = $this->db->query("SELECT * FROM `box_labels` WHERE `mat` LIKE '".$materialcode."'")->row_array();	
							 ?>
                           
                        <? $bakcol = ($data->qc_print==1)?'yellow':''; ?>      
                           <tr>
							   <td><b><?=$ab?></b></td>
                            <td style="background-color:<?=$bakcol?>">
                              <b><?php echo $data->OrderNumber; ?></b><br /> <b style="color:green;">( <?=$title?> )</b>
                              <? if($data->qc_print==1){?> 
                                  <br /><a onclick="showfeedback('<?=$data->SerialNumber?>')"><b style="cursor:pointer">Feedback</b></a> 
                              <? } ?>
                            </td>
                            <td><?=$materailname['name']?></td>
                            <td><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> H : i  </b>', ($data->OrderDate)); ?></td>
                            <td><?php echo $ManufactureID; ?></td> 
                            <td>-----</td>
                            <td>-----</td>	
                            <td>
                                <div style="float:left;width:75px">
                                <a title="click to download" target="_blank" href="<?=$pdf?>">
                                <img src="<?=$canvas?>" width="<?=$width?>" />
                                </a>
                                </div>
                            </td> 
                            						 
                            <td>---- <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>	
                            <td>---- <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>	
                            <td>---- <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                           
									 
			   <?	}else{ 
						
		   $materailname = $this->db->query("SELECT * FROM `box_labels` WHERE `mat` LIKE '".$materialcode."'")->row_array();			
		   $query  = $this->db->query("select * from order_attachments_integrated WHERE Serial LIKE '".$data->SerialNumber."' and (source = 'flash' || source = 'plain') ORDER BY ID ASC");
              $files = $query->row_array();
					 
			  $jobnumber = $files['ID'];
			  $title = 'LD'; 
			  $design_id = $data->user_project_id; 
			  $name = $files['name'];
			  if($design_id==0){$design_id = 1;}
			if($name==""){
			  $flash_project = $this->db->query("select Name from flash_user_design where ID = $design_id ")->row_array();
			  $name = $flash_project['Name'];
			  $this->db->where('ID',$jobnumber);
			  $this->db->update('order_attachments_integrated',array('name'=>$name));
			}  
			  
			  
			  		 
				
						$canvas = AJAXURL.'/designer/media/thumb/'.$files['Thumb'];
						$pdf = AJAXURL.'/theme/integrated_attach/'.$files['file'];
						$width='40'; 
					  ?>
          		
				
				<? $bakcol = ($files['qc']==1)?'yellow':''; ?>
                  <tr>
                      <td><b><?=$ab?></b></td>              
                    <td style="background-color:<?=$bakcol?>">
                     <b><?php echo $data->OrderNumber; ?></b><br /> <b style="color:green;">( <?=$title?> )</b>
                    <? if($files['qc']==1){?> 
                          <br /><a onclick="showfeedback('<?=$files['ID']?>')"><b style="cursor:pointer">Feedback</b></a> 
                      <? } ?>
                      </td>
                    <td><?=$materailname['name']?>
                     <? 
					$detail_view = $this->quoteModel->check_product_extra_detail($ManufactureID);
						if($detail_view['prompt']=='yes'){ echo '<br /><b style="color:green;font-weight:bold;">'.$detail_view['detail'].'</b>';}
						if($data->Product_detail!=""){?>
					  <br />-<b style="color:red;font-size:10px;"><? echo "  ".$data->Product_detail." ";?></b>
                    <? } ?> 
                    </td>
                    <td><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> H : i  </b>', ($data->OrderDate)); ?></td>
                    <td><?php echo str_replace('AA','',$ManufactureID) ?></td>
					<td><?=$name?></td>
                    <td><?=$data->Print_Type?></td>
                    <td>
                        <div style="float:left;width:75px">
                        <a title="click to download" target="_blank" href="<?=$pdf?>">
                        <img src="<?=$canvas?>" width="<?=$width?>" />
                        </a>
                        </div>
					</td> 
                   
                   
                   
       <?
        $check_printing  = $this->db->query("select count(*) as total from printing_produced where jobid = $jobnumber ")->row_array();
		if($check_printing['total']==0){ 
		  $this->machine_model->add_labels_division($data->SerialNumber,$jobnumber,$data->OrderNumber,$ManufactureID,$materialcode,$data->Label);
		 }
		 
	     $box_labels  = $this->db->query("select * from printing_produced where jobid = $jobnumber and type LIKE 'box' ")->row_array();
		 $bag_labels  = $this->db->query("select * from printing_produced where jobid = $jobnumber and type LIKE 'bag' ")->row_array();
		 $pack_labels  = $this->db->query("select * from printing_produced where jobid = $jobnumber and type LIKE 'pack' ")->row_array();
      ?>                                 
                   <td><b style="color:red"><?php echo (empty($box_labels))?"---":$box_labels['quantity']." x ".$box_labels['pack'] ?></b> <br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                   <td><b style="color:red"><?php echo (empty($bag_labels))?"---":$bag_labels['quantity']." x ".$bag_labels['pack'] ?></b><br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                   <td><b style="color:red"><?php echo (empty($pack_labels))?"---":$pack_labels['quantity']." x ".$pack_labels['pack'] ?></b><br> <?=$this->quoteModel->txt_for_plain_labels($data->Label);?></td>
                                     
     <? } ?>
     
     
     <td><?php echo '<b>'.$data->Quantity.'</b>'; ?></td>
                                  
                                  <td>
                                     <?
                                     if($data->PrintingStatus == 1) {
                                       echo "<span style='color:#c9ab40;'><b>Completed</b></span>";  } 
                                       else{ ?>
                                       
                                    <? if($UserTypeID!=22){?>   
                                      <button onclick="javascript:complete_print('<?=$data->SerialNumber?>','<?=$data->OrderNumber?>','<?=$files['ID']?>','<?=$window?>');">
                                    <?=$btn_text?></button>   
                                    
                                     <? } ?>
                                     
                                    <? }?>
                                    </td>
                                
                    <td align="center">
                       <? if($title=="LD"){?> 
                        <a target="_blank" href="<?php echo backoffice_url(); ?>machines/printA4_csld/<?=$data->OrderNumber?>/<?=$files['ID']?>">
                           <button type="button" ><i class="fa fa-print" aria-hidden="true"></i>Print CSLD</button> 
                        </a>
                     <?php } ?>
                    </td>
                                   
                                       
                                    
                               </tr>
                    
                            <?php } ?>  
         
         
         
                          </tbody>
                    </table>
                </div> 
            </div>
            <div class="clear"></div>
        </div>  <!-- End of box-->
     <div class="clear"></div>
  </div>
  
  
  
  
   
</div>

    
   
<script>

  function load_editor(project_id){
	  
		 $.ajax({
			url:"<?php echo backoffice_url();?>home/load_editor",
			type:"POST",
			async:"false",
			dataType: "html",
			data:{project_id:project_id},
			success: function(data){
			if(data){
			 $.fallr('show', {
				content     : data,
				width       : 1045,
			    height      : '825px',
				icon        : 'chat',
				position    : 'center',
				closeOverlay: true,
				buttons     : {
				  button1 : {text: 'Close'}    
				}
			});


	        }
		  }  
	   });
    }
	
	
	  // for ld & LBA prnting lines  // for ld & LBA prnting lines  // for ld & LBA prnting lines  // for ld & LBA prnting lines

        function complete_print(serial,OrderNumber,attach_id,windows){
					var setyes =function(){
						change_print_jobs_status(serial,OrderNumber,attach_id,windows);
						$.fallr("hide");
					};
					var setno =function(){
					  $.fallr("hide");
					};
					$.fallr("show",{buttons:{button1:{text:"Yes",onclick:setyes},button2:{text:"No",onclick: setno}},
					content:"<p>You are about to complete this Job?</p>"});
       }

     
	  
	  // for normal prnting lines // for normal prnting lines // for normal prnting lines // for normal prnting lines
	  
	   function complete_print_jobs(serial,OrderNumber,attach_id){
					var setyes =function(){
						var windows ='true'; 
						change_print_jobs_status(serial,OrderNumber,attach_id,windows);
						$.fallr("hide");
					};
					var setno =function(){
					  $.fallr("hide");
					};
					$.fallr("show",{buttons:{button1:{text:"Yes",onclick:setyes},button2:{text:"No",onclick: setno}},
					content:"<p>You are about to complete this Job?</p>"});
       }


       function change_print_jobs_status(serial,OrderNumber,attach_id,windows){
		      $.ajax({
					type: "post",
					url: "<?php echo backoffice_url();?>machines/change_print_jobs_status/"+serial+'/'+OrderNumber+'/'+attach_id,
					cache: false,               
					dataType: 'html',
					success: function(data){  
					   if(windows=="true"){
					     window.open('<?php echo backoffice_url();?>machines/print_label_sheets/'+attach_id); 
					   }                           
					  window.location.reload();
					}
		      });	
      }
	        // for normal prnting lines // for normal prnting lines // for normal prnting lines // for normal prnting lines
  
  
  function showfeedback(jobno){
	 $("#dvLoading").css('display','block');
	 $.ajax({
		type: "post",
		url: backoffice_url+"quality/fetch_comments",
		cache: false,               
		data:{jobno:jobno,type:'see'},
		dataType: 'html',
		success: function(data){
		  data = $.parseJSON(data);
		  $("#dvLoading").css('display','none');
		  $.fallr('show', {content:data.html,width:600,icon:'chat',closeOverlay:true,buttons:{button1:{text:'Close'}}});
		},
		error: function(){                      
		  alert('Error while request..'); 
		}
	 });
  }
 
</script>
