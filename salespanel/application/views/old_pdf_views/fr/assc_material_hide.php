        
		
		
		
		
		
		
		
		
		
		<?   $assoc = $this->user_model->fetch_custom_die_association($custominfo['ID']);
	          foreach($assoc as $rowp){ ?>
            
             <tr>
                <td class="invoicetable_tabel_border"><b><?=$rowp->material?></b></td> 
                <td class="invoicetable_tabel_border"> 
                      
                    <?=$this->user_model->get_mat_name_fr($rowp->material);?> - <?=$rowp->labeltype?> etiquettes
 
 
  <?  
  ?>                
                  
                    <?  if($rowp->labeltype=="printed"){ 
					
					   if($rowp->printing=="Mono" || $rowp->printing=="Monochrome – Black Only"){
						$rowpprinting = "Monochrome - Noir seulement";
					   }else{
					     $fr_prnt_type  = $this->user_model->get_db_column('digital_printing_process', 'name_fr', 'name',$rowp->printing);
					     $rowpprinting =$this->user_model->ReplaceHtmlToString_($fr_prnt_type);
					   } 
	  
                         echo ' - '.$rowpprinting.' - '.$rowp->designs.' Conceptions ';
                           
						     if($custominfo['format']=="Roll"){
								 if($rowp->finish == "Gloss Lamination"){
									$finish_type_fr = 'Lamination Gloss';
								  }else if($rowp->finish == "Matt Lamination"){
									$finish_type_fr = 'Matt Lamination';
								  }else if($rowp->finish =="Matt Varnish"){
									$finish_type_fr = 'Vernis mat';
								  }else if($rowp->finish == "Gloss Varnish"){
									$finish_type_fr = 'Vernis brillant';
								  }else if($rowp->finish == "High Gloss Varnish"){
									$finish_type_fr = 'Vernis a haute brillance';
								  }else{
									$finish_type_fr == 'No Finish';
								  }
							   echo ' <br> avec etiquette '.$finish_type_fr;
                            }
                    }
				   ?>
                
                
			    <? if($custominfo['format']=="Roll"){
                    echo ' - '.$rowp->rolllabels.' etiquettes - taille de noyau '.$rowp->core.' mm - '.$rowp->wound.' blessure';
                  }
				 ?>
           
               </td>
              
         </tr>  	
               
       <? } ?>      
             
             