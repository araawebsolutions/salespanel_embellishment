
<input type="hidden" id="odno" value="<?=$orderNumber?>">
<div class="owl-wrapper" style="width: 10890px; left: 0px; display: block;">
<div class="owl-item" style="width: 605px;">

    <div class="item">
        <a class="hoverfx" href="#">

            <?php
              $src = $this->Rejected_artwork_model->getFileSrc($orderIntegrated->file);
            ?>
            <?=$src?>
        </a>
        <a href="#"><h4><span>Download</span>Customer Original</h4></a>
    </div>

<div class="item">
    <a class="hoverfx" href="#">

        <img src="<?=thm_rejected_artwork?>softproof/<?=$orderIntegrated->softproof?>">
    </a>
    <a href="#"><h4><span>Download</span> SoftProof</h4></a>
</div>


<div class="item">
    <a class="hoverfx" href="#">
        <?if(!empty($artworkchat)){?>
        <embed width="150" height="140" name="plugin"
               src="<?=thm_rejected_artwork?>print/<?=$artworkchat->file?>"
               type="application/pdf">
        <?php }else{?>
        <embed width="150" height="140" name="plugin"
               src="<?=thm_rejected_artwork?>print/<?=$orderIntegrated->print_file?>"
               type="application/pdf">
        <?php }?>
    </a>
    <a href="#"><h4><span>Download</span>Print File</h4></a>
</div>

</div>
</div>