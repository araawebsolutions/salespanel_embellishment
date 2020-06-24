<?php foreach ($data['records'] as $record) { ?>
    <tr>
        <td>PJ<?= $record->ID ?></td>
        <td class="text-center"><?= $record->OrderNumber ?><br>
            <?= substr($record->Date, 0, 11) ?></td>
        <td>Name: <?= $record->name ?><br>
            Code: <?= $record->diecode ?></td>
        <td><?= $record->labels ?></td>
        <td>
            <?php if ($record->file != null) {
            
              if(preg_match("/.pdf/is",$record->file)){
                $path = 'https://www.aalabels.com/theme/site/images/pdf.png';
              }else if(preg_match("/.doc/is",$record->file) || preg_match("/.docx/is",$record->file)){
                $path = 'https://www.aalabels.com/theme/site/images/doc.png';
              }else{
                $path = 'https://www.aalabels.com/theme/integrated_attach/'.$record->file;
              }           
            ?>
			
			<a href="https://www.aalabels.com/theme/integrated_attach/<?=$record->file?>" download>
             <img src="<?=$path?>" width="48" height="48"  alt="Artwork Thumbnail" >
            </a>
					
					<?//'https://www.aalabels.com/theme/integrated_attach/' . $record->file ?>
            <?php } else { ?>
                <img src="https://www.aalabels.com/theme/assets/images/no.jpg" width="30px" height="30px"
                     class="round-circle img-thumbnails" alt="image">
            <?php } ?>
        </td>
        <td>
            <button type="button" onclick="addToCurrentArtwork(<?= $record->ID ?>)"
                    class="btn btn-danger waves-light waves-effect">Add to Artwork
            </button>
        </td>
    </tr>
    <nav class="pull-right m-t-t-10">
        <ul class="pagination pagination-split">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#" style="font-weight: normal;">1</a></li>
            <li class="page-item active"><a class="page-link" href="#"
                                            style="background: #00b7f1;border-color: #00b7f1;">2</a>
            </li>
            <li class="page-item"><a class="page-link" href="#" style="font-weight: normal;">3</a></li>
            <li class="page-item"><a class="page-link" href="#" style="font-weight: normal;">4</a></li>
            <li class="page-item"><a class="page-link" href="#" style="font-weight: normal;">5</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>

<?php } ?>

