<td class="invoicetable_description_loop invoicetable_tabel_border" style=" <?=(isset($print_style) and $print_style!='')?$print_style:''?>">
		
		<? 

  
  if($AccountDetail->Print_Type=="Monochrome - Black Only" || $AccountDetail->Print_Type=="Mono"){
			    $type = $typeshow = $desntype = 'Monochrome - Noir seulement';
			  }else{
				  
				
    
    $type = $typeshow = $desntype = $this->orderModal->get_printing_service_name($AccountDetail->Print_Type); 

				
			  }
			?>
			
			
		       
           			
					 <span style="margin-left:5px;"> <?=$typeshow?></span>
                    
					 <span style="margin-left:5px;"><?=($AccountDetail->Print_Design==1)?"1 Conception":"plusieurs Conception"?></span>
                    <?
						$free = $AccountDetail->Print_Qty - $AccountDetail->Free;
				    	if($AccountDetail->Free >= $AccountDetail->Print_Qty){
			 				$free = 0;
						}
			?> 
            <? if($AccountDetail->Print_Design=="1 Design"){?>
            <b style="color:red;"> <? echo '&nbsp;&nbsp;'."1"." Conception ".$desntype;?> </b>
            <? } else
		    if($AccountDetail->Print_Design=="Multiple Designs"){?>
            <b style="color:red;"> 
		<? echo  '&nbsp;&nbsp;'.$AccountDetail->Print_Qty." Conception ".$desntype." ( ". $free." + ".$AccountDetail->Free." Gratuit )";?> </b>
            <? }?>
    
     
			<? if(preg_match('/roll/is',$AccountDetail->ProductName)){
				
					if(isset($AccountDetail->wound) and @$AccountDetail->wound=='Inside'){ 
					  $wound = lang('placeholder_inside_wound');
				    }else{
					  $wound = lang('placeholder_outside_wound');
					}
				?>   
                    <br /><b>Blessure:</b> <?=$wound?>
                    &nbsp;&nbsp; <b>Orientation:</b>
                    <?=@$AccountDetail->Orientation?>
                    &nbsp;&nbsp; <b>Finition:</b>
                    
                    <? if(@$AccountDetail->FinishType == "Gloss Lamination"){
						$finish_type_fr = 'Lamination Gloss';
					   }else if(@$AccountDetail->FinishType == "Matt Lamination"){
						$finish_type_fr = 'Matt Lamination';
					   }else if(@$AccountDetail->FinishType =="Matt Varnish"){
						$finish_type_fr = 'Vernis mat';
					   }else if(@$AccountDetail->FinishType == "Gloss Varnish"){
						$finish_type_fr = 'Vernis brillant';
					   }else{
						$finish_type_fr == 'No Finish';
					   }
				    ?>
                    
					<?=$finish_type_fr?>
                    &nbsp;&nbsp; <b>Épreuve de presse:</b>
                    <?=($AccountDetail->pressproof==0)?'Non':'Oui'?>
             <? }
             
              ?>        
</td>