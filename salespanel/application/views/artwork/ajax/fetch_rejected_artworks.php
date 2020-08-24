

<?   $start++;
    foreach($result as $data){
	   $comments = $this->Artwork_model->fetch_order_comments_grouped($data->OrderNumber);
	?>

        <tr class="artwork-tr">
            <td class="no-border">
                <b><?=$data->OrderNumber?></b> <span class="orange-text">(<?=($data->site=="" || $data->site=="en")?"en":"fr";?>)</span>
                <p>1 PJ - <b>(<?=($data->ProductBrand == 'Roll Labels')?'Roll':'Sheet'?>)</b></p>

            </td>
            <td class="no-border">
            <span class="comment-text comments" ordernumber="<?=$data->OrderNumber?>">
            <span id="all_comments_<?=$data->OrderNumber?>"><?=$comments['total_comments']?></span> Comments</span>
            <? $commentclass = ($comments['unread_comments']>0)?"":"hide";?>
            <i class="fa fa-bell red-bell <?=$commentclass?>" id="maked_comments_<?=$data->OrderNumber?>"> <?=$comments['unread_comments']?></i>
           </td>
           
            <td class="no-border"><?=$data->name?><p><b>( <?=$data->DeliveryCountry?> )</b></p></td>

            <td class="no-border"><?=$this->Artwork_model->get_operator($data->designer);?></td>

            <td class="no-border"><?=$this->Artwork_model->get_operator($data->assigny);?></td>

            <td class="no-border"><i class="mdi mdi-check-circle green-tick"></i></td>

            <td class="no-border"><i class="mdi mdi-check-circle green-tick"></i></td>

            <td class="no-border"><i class="mdi mdi-check-circle green-tick"></i></td>

            <td class="no-border"><i class="fa  fa-times-circle red-cross"></i></td>

            <td class="no-border">
                <mark class="green-alert">
                    <div class="sk-spinner sk-spinner-pulse green-pulse"></div>
                    Awaiting Print File
                </mark>
            </td>

            <td class="no-border">
            <div class="btn-group dropdown">
                <a href="<?=main_url?>Artworks/attachments/<?=$data->OrderNumber?>/rejected" type="button"
                        class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn" style="color: #fff !important;">
                    More ...
                </a>
                </div>
                </div>
            </td>
        </tr>
<? $start++; } ?>
