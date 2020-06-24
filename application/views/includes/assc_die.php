

- <b>Format:</b>
<?=$custominfo['format']?>&nbsp;&nbsp;  <b>Shape:</b> <?=$custominfo['shape']?>&nbsp;&nbsp; <b>Width:</b><?=$custominfo['width']?> mm
<? if($custominfo['shape']!="Circle"){?>
    &nbsp;&nbsp; <b>Height:</b> <?=($custominfo['height']!=null)?($custominfo['height']):($custominfo['width'])?> mm&nbsp;&nbsp;
<? } ?>

<b>No. labels / Die:</b> <?=$custominfo['labels']?> <br /><!-- <b>Euro Die:</b>--><?/*=($custominfo['iseuro']==1)?"Yes":"No";*/?>

&nbsp;&nbsp; <?php if(($custominfo['shape'] != 'Circle') && ($custominfo['shape'] !='Oval')){?><b>Corner radius:</b> <?=$custominfo['cornerradius']?> mm<?php }?>
<? if($custominfo['format']=="Roll"){?>
    &nbsp;&nbsp; <b>Leading Edge:</b> <?=$custominfo['width']?> mm
<? } ?>

&nbsp;&nbsp;<b>Perforation:</b><?=$custominfo['perforation']?> &nbsp;&nbsp;
<? if($custominfo['notes']!=""){?>
    &nbsp;&nbsp;<b>Notes:</b><?=$custominfo['notes']?> &nbsp;&nbsp;
<? }?>
