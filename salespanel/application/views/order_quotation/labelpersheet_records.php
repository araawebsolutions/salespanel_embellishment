<?php
$addclass = "";
$i = 1;
$i2 = 1;
//echo '<pre>'; print_r($labelpersheet_records['list']); echo '</pre>';exit;
foreach ($labelpersheet_records['list'] as $rec):
 if($rec->LabelPerDie == 0){
     continue;
 }
if($rec->count > 1)
{
	$products = "Products";
}
else
{
	$products = "Product";
}
if($rec->LabelPerDie == $label_per_sheet_selected)
{
	$addclass = "active";
}
else
{
	$addclass = "";
}
?>
<?php 
if ($i%4 == 1) { 
	echo "<div class='row'>";   
}
?>

	
<div class="col-sm-3 col-xs-6" style="    text-align: center; text-align:-webkit-center">
  <div class="lps_item_box <?=$addclass?>" data-labelperdie="<?=$rec->LabelPerDie?>"> <span class="lps_number">
    <?=$rec->LabelPerDie?>
    </span>
    <p>Labels per sheet <span class="breakthrough">(<span class="lps_products">
      <?=$rec->count?>
      </span>
      <?=$products?>
      )</span></p>
  </div>
</div>
	
<?php 
	if ($i%4 == 0){
		echo "</div>";
	}
?>
<?php $i++; endforeach; if ($i%4 != 1) echo "</div>";?>


<script>
(function($){
	$(".container_of_labels").mCustomScrollbar({
		axis:'y',
		theme:'rounded-dark'
	});
})(jQuery);
</script>