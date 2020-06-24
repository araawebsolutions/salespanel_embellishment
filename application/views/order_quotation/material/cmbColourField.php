<?php
if(count($values) > 0){
?>
<option value="" selected="selected">Select Label Colour</option>
<?php
foreach ($values as $key => $value) {
	$colour = $value->LabelColor;
?>
<option value="<?=$type.'-'.$value->LabelFinish.'-'.$value->ColourMaterial.'-'.$value->ProductID.'-'.$value->Material1.'-'.$value->CategoryID.'-'.$colour  ?>"><?php echo $colour; ?></option>
<?php
}
}
else
{
?>

<option value="" selected="selected">Label Colour Not Found</option>
<?php
}
?>