



<?   $assoc = $this->user_model->fetch_custom_die_association($custominfo['ID']);
foreach($assoc as $rowp){ ?>

    <tr>
        <td class="invoicetable_tabel_border"></td>
        <td class="invoicetable_tabel_border"><b><?=$rowp->material?></b></td>
        <td class="invoicetable_tabel_border">

            <?=$this->user_model->get_mat_name($rowp->material);?> - <?=$rowp->labeltype?> Labels


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
        <td class="invoicetable_tabel_border" align="center">-</td>
        <td class="invoicetable_tabel_border" align="center"><?=$rowp->qty?></td>

        <? $materialprice = $rowp->plainprice+$rowp->printprice; ?>
        <? $materialpriceinc = $materialprice*1.2; ?>
        <td class="invoicetable_tabel_border" align="center"><? echo $symbol."".(number_format($materialprice * $exchange_rate,2));?></td>
        <td class="invoicetable_tabel_border" align="center"><? echo $symbol."".(number_format($materialpriceinc * $exchange_rate,2));?></td>

    </tr>

    <?  $Excus+= $materialprice;   $Inccus+= $materialpriceinc;  ?>

<? } ?>
             
             