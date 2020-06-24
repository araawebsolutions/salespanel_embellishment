<?php
if(count($values) > 0){
?>
<option value="" selected="selected">Select Label Adhesive</option>
<?php
foreach ($values as $key => $value) {
	if(!empty($value['Adhesive'])){
?>
		<option value="<?=$type.'-'.$value['LabelFinish'].'-'.$value['ColourMaterial'].'-'.$value['ProductID'].'-'.$value['Material1'].'-'.$value['CategoryID'].'-'.$value['LabelColor'].'-'.$value['Adhesive']  ?>"><?php echo $value['Adhesive']; ?></option>
<?php
	}
}
}
else
{
?>

<option value="" selected="selected">Label Adhesive Not Found</option>
<?php
}
?>