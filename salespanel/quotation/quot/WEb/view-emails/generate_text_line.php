<?php
$AccountDetail = $quotationDetail;
?>
<td class="invoicetable_description_loop invoicetable_tabel_border" style=" text-align:justify; <?=(isset($print_style) and $print_style!='')?$print_style:''?>">
    <? $type = $typeshow = $desntype = $this->home_model->get_printing_service_name($AccountDetail->Print_Type); ?>

   
    <span style=""> <?=$typeshow?></span>
    - <span style=""><?=$AccountDetail->Print_Design?></span>
    <?
    $free = $AccountDetail->Print_Qty - $AccountDetail->Free;
    if($AccountDetail->Free >= $AccountDetail->Print_Qty){
        $free = 0;
    }
    ?>
    -
    <? if($AccountDetail->Print_Design=="1 Design"){?>
        <b style="color:red;"> <? echo '&nbsp;&nbsp;'."1"." Design ".$desntype;?> </b>
    <? } else
        if($AccountDetail->Print_Design=="Multiple Designs"){?>
            <b style="color:red;">
                <? //echo  '&nbsp;&nbsp;'.$AccountDetail->Print_Qty." Designs ".$desntype." ( ". $free." + ".$AccountDetail->Free." Free )";?> </b>
        <? }?>


    <? if(preg_match('/roll/is',$AccountDetail->ProductName)){
        if(isset($AccountDetail->wound) and $AccountDetail->wound!=''){ $wound = $AccountDetail->wound; }
        else{ $wound = (isset($AccountDetail->Wound))?$AccountDetail->Wound:''; }
        ?>
        <br /><b>Wound:</b> <?=$wound?>
        &nbsp;&nbsp; <b>Orientation:</b>
        <?=$AccountDetail->Orientation?>
        &nbsp;&nbsp; <b>Finish:</b>
        <?=$AccountDetail->FinishType?>
        &nbsp;&nbsp; <b>Press proof:</b>
        <?=($AccountDetail->pressproof==0)?'No':'Yes'?>
    <? }


    if(isset($showartowrks) and $showartowrks =='Yes' and $AccountDetail->Printing=='Y'){
        $artowrks = $this->home_model->get_printed_files($AccountDetail->SerialNumber); ?>
        <? if(count($artowrks) > 0){
            ?>
            <div>
            <hr />
            <? foreach($artowrks as $upload){

                if(preg_match("/.pdf/is",$upload->file)){
                    $path = AJAXURL.'theme/site/images/pdf.png';
                    $width_img = '30';
                }
                else if(preg_match("/.doc/is",$upload->file) || preg_match("/.docx/is",$upload->file)){
                    $path = AJAXURL.'theme/site/images/doc.png';
                    $width_img = '30';
                }
                else{

                    $path = base_url().'theme/integrated_attach/'.$upload->file;
                    $width_img = '50';
                }


                ?>
                <span style="float:left; margin-left:10px;">
										<img class="" src="<?=$path?>" height="" width="<?=$width_img?>">
										<p class="ellipsis"><small>Labels:</small> <small><?=$upload->labels?></small></p>
									</span>

            <? }} ?>
        </div>
    <? }  ?>
</td>