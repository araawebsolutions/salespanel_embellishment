<?      
$jkl=0;

if($this->session->userdata('UserTypeID') == 50){
    //echo '<pre>'; print_r($result);
}

   foreach($result as $data){
   
  
   $total_attach = $this->Artwork_model->fetch_total_attach($data->OrderNumber);
   
  
   $comments = $this->Artwork_model->fetch_order_comments_grouped($data->OrderNumber);
   $alldesigners = $this->Artwork_model->fetch_designers();	
   
   $jkl++;
   
   if($this->session->userdata('UserTypeID')==88 && $this->session->userdata('UserID')!=DESIGNER){
   if ($data->designer==DESIGNER){
       $checkattachment = count($total_attach);
	    if($checkattachment==0){
	      $jkl--;     
		  continue;
		}
    }
   }  
   ?>    
   
   
<tr class="artwork-tr" id="row<?=$data->OrderNumber?>">
   <td class="no-border">
       <b><?=$data->OrderNumber?></b> <span class="orange-text">(<?=($data->site=="" || $data->site=="en")?"en":"fr";?>)</span>
       <br />
       <span class="comment-text comments" ordernumber="<?=$data->OrderNumber?>">
       <span id="all_comments_<?=$data->OrderNumber?>"><?=$comments['total_comments']?></span> Comments</span>
       <? $commentclass = ($comments['unread_comments']>0)?"":"hide";?><i class="fa fa-bell red-bell <?=$commentclass?>" id="maked_comments_<?=$data->OrderNumber?>"> <?=$comments['unread_comments']?></i>
       </td>
       
       
   <td class="no-border">
      <p><b style="font-size:14px"><?=count($total_attach)?> PJ - </b><? if($this->session->userdata('UserTypeID') != 88){?>
      <a href="<?php echo base_url()?>index.php/Artworks/add_artwork/<?=$data->OrderNumber?>"><span class="comment-text underline">ADD ARTWORKS</span></a><br /><? } ?>
      <b>(<?=$data->format?>)</b></p>
   </td>
   
<? $designer_name = $this->Artwork_model->single_feild('UserName',array('UserID'=>$data->designer),'customers');  
   if($designer_name ==""){ $designer_name = 0; }
?>   
   <td class="no-border">
      <?=$data->name?>
      <p><b>(<?=$data->BillingCountry?>)</b></p>
   </td>
   <? if($this->session->userdata('UserTypeID') == 88 && $this->session->userdata('UserID') == DESIGNER){?> 
   <td class="no-border">
      <div class=" labels-form">
         <div class=" labels-form"> <span style="opacity: 0"><?=$designer_name?></span>
            <label class="select">
               <select name="color_mat border-color-artwork" id="select_designer" data-id="<?=$data->OrderNumber?>">
                  <option value="0" selected="selected">Select Designer</option>
                  <? 
                     foreach($alldesigners as $designerid){ ?>  
                  <option value="<?=$designerid->UserID?>" <?=($data->designer==$designerid->UserID)?'selected="selected"':''?>><?=$designerid->UserName?></option>
                  <? } ?>
                  <option value="<?=DESIGNER?>" <?=($data->designer==DESIGNER)?'selected="selected"':''?>>Split Order</option>
               </select>
               <i></i>
            </label>
         </div>
      </div>
   </td>
   <? }else{ ?>  
   <td class="no-border"><?=($data->designer==DESIGNER)?"Split Order":$this->Artwork_model->get_operator($data->designer);?></td>
   <? } ?><? if($this->session->userdata('UserTypeID') != 88){?> 
   <td class="no-border">
      <div class=" labels-form">
         <div class=" labels-form">
            <label class="select">
               <select name="color_mat border-color-artwork" id="select_operator" data-id="<?=$data->OrderNumber?>">
                  <option value="0" selected="selected">Select Operator</option>
                  <option value="642708" <?=($data->assigny==642708)?'selected="selected"':''?>>Lyide</option>
                  <option value="626284" <?=($data->assigny==626284)?'selected="selected"':''?>>Andy</option>
                  <option value="642707" <?=($data->assigny==642707)?'selected="selected"':''?>>Sheena</option>
                  <option value="642926" <?=($data->assigny==642926)?'selected="selected"':''?>>Bethany</option>
                  <option value="620044" <?=($data->assigny==620044)?'selected="selected"':''?>>Kiran</option>
                  <option value="626441" <?=($data->assigny==626441)?'selected="selected"':''?>>Ian</option>
                  <option value="620075" <?=($data->assigny==620075)?'selected="selected"':''?>>Sohail</option>
               </select>
               <i></i>
            </label>
         </div>
      </div>
   </td>
   <? }else{ ?>   
   <td class="no-border"><?=$this->Artwork_model->get_operator($data->assigny);?></td>
   <? } ?><? $slowartwork = $this->Artwork_model->fetch_slowartwork($data->OrderNumber);?>
   <td class="no-border"><i class="<?=($slowartwork['CO']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>
   <td class="no-border"><i class="<?=($slowartwork['SP']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>
   <td class="no-border"><i class="<?=($slowartwork['CA']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>
   <td class="no-border"><i class="<?=($slowartwork['PF']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>
   
<style>
.blue-badge-aert,.red-badge-aert,.yellow-badge-aert,.green-alert{
  margin: 0px !important;
}
</style>


   <? if($slowartwork['checklist']==0 && $slowartwork['CO']==1){$showstatus = '<mark class="blue-badge-aert"><div class="sk-spinner sk-spinner-pulse blue-artwork-pulse"></div>Designer Pending Checklist</mark>';	 }else if($slowartwork['status']==64){$showstatus = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>Pending Customer Original Approval</mark>';	 }else if($slowartwork['status']==65){$showstatus = '<mark class="green-alert"><div class="sk-spinner sk-spinner-pulse green-pulse"></div>Awaiting Soft-proof</mark>';} else if($slowartwork['status']==66){$showstatus = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>Pending Soft-proof approval</mark>';}else if($slowartwork['status']==67){$showstatus = '<mark class="yellow-badge-aert"><div class="sk-spinner sk-spinner-pulse yellow-artwork-pulse"></div>Awaiting Customer Approval</mark>';}else if($slowartwork['status']==68){$showstatus = '<mark class="green-alert"><div class="sk-spinner sk-spinner-pulse green-pulse"></div>Awaiting Print File</mark>';}else if($slowartwork['status']==69){$showstatus = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>Pending Print File Approval</mark>';	}else if($slowartwork['status']==70){$showstatus = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>Approved For Printing</mark>';	}else if(count($total_attach) == 0){$showstatus = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>No Artwork</mark>';}else{$showstatus = '<mark class="red-badge-aert"><div class="sk-spinner sk-spinner-pulse red-artwork-pulse"></div>Pending Customer Original Approval</mark>';  }   ?>                                   
   <td class="no-border"><?=$showstatus?><span style="opacity: 0"><?=$designer_name ?></td>
   <? if($data->OrderStatus == 63 && $this->session->userdata('UserTypeID')!=88){?>
   <td class="no-border">
      <div class="btn-group dropdown"><a class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn mover" style="color: #fff !important;" data-id="<?=$data->OrderNumber?>" id="m_t_p_<?=$data->OrderNumber?>">M.T.P</a></div>
   </td>
   <? //}else if(count($total_attach) > 0 || $this->session->userdata('UserTypeID') != 23){?>
   <? }else if( ($this->session->userdata('UserTypeID') != 23 && count($total_attach) > 0) || ($this->session->userdata('UserTypeID') == 23 && count($total_attach) > 0 )){?>
   
   <td class="no-border">
      <div class="btn-group dropdown"><a href="<?=main_url?>Artworks/attachments/<?=$data->OrderNumber?>" target="_blank" type="" class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn" style="color: #fff !important;">More...</a></div>
   </td>
 <? }else{ ?>
       <td class="no-border"></td>
 <?php  } ?>
 
   <td class="badge-td">
      <? if ($data->Label == 1){?>
           <span class="orange-badge badge badge-red">Plain</span>
      <? } ?>
      
      <? if($slowartwork['checklist']==0 && $slowartwork['CO']==1){?><span class="orange-badge badge badge-red">Submit Checklist ASAP</span><? } ?><? $productcolors = array(); $productcolors['colors'] =  $productcolors['bleed'] = '';  if(count($total_attach) > 0){    $productcolors = $this->Artwork_model->fetch_listing_tags($data->OrderNumber);  }?><? if(preg_match('/Silver/',$productcolors['colors'])){ ?>    <span class="badge badge-purple badge-blue-first">Silver</span><? } ?><? if(preg_match('/Clear/',$productcolors['colors'])){ ?>    <span class="badge badge-purple badge-blue-first">Clear</span><? } ?><? if(preg_match('/no/',$productcolors['bleed'])){ ?>   <span class="badge badge-purple badge-orange-second">Not Bleedable</span><? } ?> 
      <? if($productcolors['variable_data'] > 0){ ?>   <span class="badge badge-purple badge-orange-second" style="background: #0f0f0f">Sequential</span><? } ?> <!--<span class="orange-badge badge badge-red">Clear</span><span class="badge badge-purple badge-orange-second">Not Bleedable</span><span class="badge badge-purple badge-blue-first">Silver</span>-->
   </td>
   <td class="badge-td-left" style="display:none;"><span class="badge badge-purple badge-blue-left"><?=$start?></span></td>
</tr>
<?   } ?>


<script>$('#totallines').html(<?=$jkl?>);</script>