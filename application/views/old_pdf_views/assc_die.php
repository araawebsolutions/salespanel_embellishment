  for <?php if($custominfo['format'] == 'Roll'){
      echo $custominfo['format'].' Labels';
  }else
      {
          echo $custominfo['format'].' Sheets';
      }?> <?=$custominfo['width']?>

  <? if($custominfo['shape']!="Circle")
  {?>x<?=($custominfo['height'] !=null)?$custominfo['height']:$custominfo['width']?><? } ?>  mm
  <?php if($custominfo['shape'] != ''){echo $custominfo['shape'].',';}?>
  <? if($custominfo['format']=="Roll"){?>Leading Edge <?=$custominfo['width']?> mm, <? } ?>
  <?php if($custominfo['shape'] !='Circle' && $custominfo['shape'] !='Oval'){?>
  Corner radius <?=$custominfo['cornerradius']?> mm
  <?php }?>