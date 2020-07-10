<!-- NAFEES LA WORK STARTS -->
<?php
$loop_counter = 100;
$colorsArray = array("#00b7f1", "#000000", "#CD9B29", "#9B9A9A", "#84429C", "#2E9C46","#00b7f1", "#000000", "#CD9B29", "#9B9A9A", "#84429C", "#2E9C46","#00b7f1", "#000000", "#CD9B29", "#9B9A9A", "#84429C", "#2E9C46");

$LB_jsonDecode = json_decode($jsonData);
if( gettype($LB_jsonDecode) == "array" ) {
    foreach ($LB_jsonDecode as $key => $eachLE) {?>
        <span>
            <span class="badge badge-purple badge-blue-first" style="margin-left: -8px; z-index:<?php echo $loop_counter--;?>; background-color: <?php echo $colorsArray[$key]; ?> ">
                <?php 
                    if( $eachLE->parsed_parent_title == "hot_foil" ) {
                        echo "Hot Foil (". ucwords( str_replace("_", " ", $eachLE->finish_parsed_title)).")";
                    } else {
                        echo ucwords( str_replace("_", " ", $eachLE->finish_parsed_title));
                    }
                ?>
            </span>
        </span>
    <?php
    }
    echo "<div style='clear:both;'></div>";
} else {
    echo "Not a Json Converted Array";
}
?>
<!-- NAFEES LA WORK ENDS -->