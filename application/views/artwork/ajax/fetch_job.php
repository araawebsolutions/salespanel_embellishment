     <? //$row = $this->Artwork_model->fetch_one_artwork($printjob);
	    //$result = $this->Artwork_model->fetch_chat_artwork($printjob);
	 ?>
     <? include(APPPATH.'views/artwork/ajax/include__thumb_map.php'); ?> 
    
<!-- NAFEES LA WORK STARTS -->

	<!-- $orderinfo  === orders -->
    <!-- $orderDetailsAttachement  === orderdetails -->
    <!-- $row  === order_attachments_integrated -->

<?php $orderDetailsAttachement = $this->Artwork_model->check_orderdetail($row['Serial']); ?>
<!-- NAFEES LA WORK ENSD -->

    
<? if(isset($row['Brand']) && $row['Brand']=="Rolls"){
		$orderdetail = $this->Artwork_model->check_orderdetail($row['Serial']);


	
	  $roll_material = substr($orderdetail['ManufactureID'],0,-1);
	  $materialcode = $this->Artwork_model->getmaterialcode($roll_material);
	  $die = str_replace($materialcode,"",$roll_material);
	  
	  $val = substr($orderdetail['ManufactureID'],-1);
	  $menu = $die;
	
	  $wound = $orderdetail['Wound'];
	  $wound_path = ($orderdetail['Wound']=="Inside")?"RollLabels":"RollLabels";
	  $orientation = $orderdetail['Orientation'];
	  $woundtip = ARTWORKS.'theme/site/images/categoryimages/'.$wound_path.'/'.$menu.'.jpg';
	  $tooltip = ARTWORKS.'theme/site/images/categoryimages/winding/'.$orderdetail['Wound'].'/orientation'.$orderdetail['Orientation'].'.png';
	  
	?>     
<div class="artwork-images-cards p-b-10" style="margin-right: 15px;margin-left: -4px;padding: 10px;">
<p><?=$orderdetail['ProductName']?></p>
<div class="row">
<div class="col-md-3">
<div class="card artworks-card fix-height">
<div class="card-header artworks-card-text" style="background-color: #005b8a;border-bottom-color: #005b8a;color: #ffffff !important;">Wound</div>
<div class="card-body text-center no-padding">
<img src="<?=$woundtip?>"
alt="Artwork Uploaded"
class="img-fluid" style="margin: 15px;">
</div>
</div>
</div>
<div class="col-md-3">
<div class="card artworks-card fix-height">
<div class="card-header artworks-card-text" style="background-color: #005b8a;border-bottom-color: #005b8a;color: #ffffff !important;">Orientation</div>
<div class="card-body text-center no-padding">
<img src="<?=$tooltip?>"
alt="Artwork Uploaded"
class="img-fluid" style="margin: 15px;">
</div>
</div>
</div>
<div class="col-md-3">
<div class="card artworks-card fix-height">
<div class="card-header artworks-card-text" style="background-color: #005b8a;border-bottom-color: #005b8a;color: #ffffff !important;">Finish</div>
<div class="card-body text-center">
<?=$orderdetail['FinishType']?>
</div>
</div>
</div>
<div class="col-md-3">
<div class="card artworks-card fix-height">
<div class="card-header artworks-card-text" style="background-color: #005b8a;border-bottom-color: #005b8a;color: #ffffff !important;">Press Proof</div>
<div class="card-body text-center">
 <?=($orderdetail['odp_proof']=='Y')?'Yes':'No'?>
</div>
</div>
</div>
</div>
</div>
<? } ?>
<div class="artwork-images-cards m-t-t-10" style="margin-right: 15px;margin-left: -4px;">
<div class="row p-10">
<? if($row['checklist']==1 || ($row['action']==0 && $this->session->userdata('UserTypeID')!=88) || ($row['action']==1 && $this->session->userdata('UserTypeID')==88) ){?>
<span id="command"><button type="button"
class="btn btn-outline-info waves-light waves-effect box_commentshow" style="margin: 0px 15px;">Add Comments</button></span>
<? }?>
<? if($row['status']==64 && $this->session->userdata('UserTypeID')!=88 && $row['checklist']==1){?>
<span><button type="button"
class="btn btn-outline-info waves-light waves-effect m-l-10 approve_co" data-id="<?=$row['ID']?>" data-ver="<?=$row['version']?>" style="margin: 0px 15px;">Approve Customer Original</button></span>
<? } ?>
<? if($row['status']!=64){?>
<span><button type="button"
class="btn btn-outline-info waves-light waves-effect m-l-10 customerfeedback" data-id="<?=$row['ID']?>" style="margin: 0px 15px;">Veiw Customer Feedback</button></span>
<? } ?>
<? if($row['checklist']==0 && $this->session->userdata('UserTypeID')==88){?>
    <span><button type="button"
    class="btn btn-outline-info waves-light waves-effect m-l-10 chekclist" data-id="<?=$row['ID']?>" style="margin: 0px 15px;">Submit Checklist</button></span>
<? }else if($row['checklist']==1){?>
    <span><button type="button"
    class="btn btn-outline-info waves-light waves-effect m-l-10 viewchekclist" data-id="<?=$row['ID']?>" style="margin: 0px 15px;">Designer's Checklist</button></span>
<? } ?>
<span>
<button type="button" class="btn btn-outline-info waves-light waves-effect m-l-10 show_timeline" data-id="<?=$row['ID']?>" data-order="<?=$row['OrderNumber']?>" style="margin: 0px 15px;">Check Timeline</button>
</span>
<? if($orderinfo['designer']== DESIGNER && $this->session->userdata('UserID') == DESIGNER){
	 $alldesigners = $this->Artwork_model->fetch_designers(); ?>
    <span><div class=" labels-form"><div class=" labels-form">
    <label class="select">
    <select name="color_mat border-color-artwork" id="select_jobdesigner" data-id="<?=$row['ID']?>">
    <option value="0" selected="selected">Select Designer</option>
    <? foreach($alldesigners as $designerid){?>
     <option value="<?=$designerid->UserID?>" <?=($row['designer']==$designerid->UserID)?'selected="selected"':''?>><?=$designerid->UserName?></option>
    <? } ?>
    <option value="<?=DESIGNER?>" <?=($row['designer']==DESIGNER)?'selected="selected"':''?>>Split Order</option>
    </select>
    </label></div></div>
    </span>
 <? } ?>
</div>
</div>
<? include(APPPATH.'views/artwork/ajax/include__chat.php'); ?> 
<div id="popupdiv"></div>   