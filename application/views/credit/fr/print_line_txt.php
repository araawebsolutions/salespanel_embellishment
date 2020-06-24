
<td class="invoicetable_description_loop invoicetable_tabel_border" style=" <?=(isset($print_style) and $print_style!='')?$print_style:''?>">

    <? if($AccountDetail->Print_Type=="Monochrome - Black Only" || $AccountDetail->Print_Type=="Mono"){
        $type = $typeshow = $desntype = 'Monochrome - Noir seulement';
    }else{
        $frprnttype = $this->user_model->get_printing_service_name($AccountDetail->Print_Type);
        $type = $typeshow = $desntype = $this->user_model->get_db_column('digital_printing_process','name_fr','name',trim($frprnttype));
        $type = $typeshow = $desntype =$this->user_model->ReplaceHtmlToString_($type);
    }
    ?>
    <img src="<?=ASSETS?>assets/images/blue-tick.png" width="12" height="12"/>
    <span style="margin-left:5px;"> <?=$typeshow?></span>
    <img  style="margin-left:5px;" src="<?=ASSETS?>assets/images/blue-tick.png" width="12" height="12"/>
    <span style="margin-left:5px;"><?=($AccountDetail->Print_Design==1)?"1 Conception":"plusieurs Conception"?></span>
    <?
    $free = $AccountDetail->Print_Qty - $AccountDetail->Free;
    if($AccountDetail->Free >= $AccountDetail->Print_Qty){
        $free = 0;
    }
    ?>
    <img style="margin-left:5px;" src="<?=ASSETS?>assets/images/blue-tick.png" width="12" height="12"/>&nbsp;
    <? if($AccountDetail->Print_Design=="1 Design"){?>
        <b style="color:red;"> <? echo '&nbsp;&nbsp;'."1"." Conception ".$desntype;?> </b>
    <? } else
        if($AccountDetail->Print_Design=="Multiple Designs"){?>
            <b style="color:red;">
                <? echo  '&nbsp;&nbsp;'.$AccountDetail->Print_Qty." Conception ".$desntype." ( ". $free." + ".$AccountDetail->Free." Gratuit )";?> </b>
        <? }?>


    <? if(preg_match('/roll/is',$AccountDetail->ProductName)){

        if(isset($AccountDetail->wound) and $AccountDetail->wound=='Inside'){
            $wound = $this->lang->line('placeholder_inside_wound');
        }else{
            $wound = $this->lang->line('placeholder_outside_wound');
        }
        ?>
        <br /><b>Blessure:</b> <?=$wound?>
        &nbsp;&nbsp; <b>Orientation:</b>
        <?=$AccountDetail->Orientation?>
        &nbsp;&nbsp; <b>Finition:</b>

        <? if($AccountDetail->FinishType == "Gloss Lamination"){
            $finish_type_fr = 'Lamination Gloss';
        }else if($AccountDetail->FinishType == "Matt Lamination"){
            $finish_type_fr = 'Matt Lamination';
        }else if($AccountDetail->FinishType =="Matt Varnish"){
            $finish_type_fr = 'Vernis mat';
        }else if($AccountDetail->FinishType == "Gloss Varnish"){
            $finish_type_fr = 'Vernis brillant';
        }else if($AccountDetail->FinishType == "High Gloss Varnish"){
            $finish_type_fr = 'Vernis a haute brillance';
        }else{
            $finish_type_fr == 'No Finish';
        }
        ?>

        <?=$finish_type_fr?>
        &nbsp;&nbsp; <b>Epreuve de presse:</b>
        <?=($AccountDetail->pressproof==0)?'Non':'Oui'?>
    <? }

    ?>
</td>