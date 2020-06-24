



       <?


       $assoc = $this->quoteModel->fetch_custom_die_association($custominfo['ID']);

	        foreach($assoc as $rowp){ ?>

             <tr>
                <td class="invoicetable_tabel_border"><b><?=$rowp->material?></b></td>
                <td class="invoicetable_tabel_border">

                    <?=$this->quoteModel->get_mat_name($rowp->material);?> - <?=$rowp->labeltype?> Labels


                    <?  if($rowp->labeltype=="printed"){
                         echo ' - '.$rowp->printing.' - '.$rowp->designs.' Designs ';

						    if($custominfo['format']=="Roll"){
                             echo ' <br> with label finish '.$rowp->finish;
                            }
                    }
				   ?>


			    <? if($custominfo['format']=="Roll"){
                    echo ' - '.$rowp->rolllabels.' labels - core size '.$rowp->core.' mm - '.$rowp->wound.' wound';
                  }
				 ?>

               </td>

         </tr>

       <? } ?>


             
             