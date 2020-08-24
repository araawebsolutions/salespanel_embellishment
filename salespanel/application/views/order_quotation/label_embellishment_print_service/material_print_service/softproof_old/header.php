<?
$roll_material = (preg_match('/roll/is', $result['ProductName'])) ? substr($result['diecode'], 0, -1) : $result['diecode'];
$materialcode = $this->home_model->getmaterialcode($roll_material);
$die = str_replace($materialcode, "", $roll_material);
$category = $this->db->query("select LabelWidth,LabelHeight from category where CategoryImage LIKE '%" . $die . "%'")->row_array();

?>

<div class="thumbnail prMatDC">
    <div class="clear10"></div>
    <div class="col-xs-12 col-sm-12 col-md-7">
        <div class="title"><b class="col-sm-6 col-xs-6">Artwork Detail</b></div>
        <div class="captionX m0">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <p><strong>Ref / Title / Die</strong> <br>
                    <?= $result['diecode'] ?>
                </p>
                <p><strong>Operator</strong> <br>
                    <?= ($result['Operator']) ? $result['Operator'] : 'N/A' ?>
                </p>
                <p><strong>Sequential Codes</strong> <br>
                    N/A</p>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-5">
                <p><strong>Order Number</strong> <br>
                    <?= $result['OrderNumber'] ?>
                </p>
                <p><strong>Label Size</strong> <br>
                    Width <?= $category['LabelWidth'] ?> X Height <?= $category['LabelHeight'] ?>
                </p>
                <p><strong>Date/ Time</strong> <br>
                    <?
                    $date = new DateTime($result['Date']);
                    echo $date->format('D, F d, Y') . ' at ' . $date->format('h:i A'); ?>
                </p>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <p><strong>Base Substrate</strong> <br>
                    <?= $materialcode ?>
                </p>
                <p><strong>Finish Substrate</strong> <br>
                    <?= $result['FinishType'] ?>
                </p>
            </div>
        </div>
    </div>
    <?
    if (preg_match('/roll/is', $result['ProductName'])) {
        $val = substr($result['ManufactureID'], -1);
        $core = $this->db->query("select * from rollcore where ID = $val")->row_array();
        $coreimage = $core['ID'];
        $core = explode('size ', $core['CoreSize']);
        $core = $core[1];
        $coreimage = Assets . 'images/categoryimages/labelShapes/core/0' . $coreimage . '.png';

        $menu = $die . 'R' . $val;
        $orientation = $result['Orientation'];
        $tooltip = Assets . 'images/categoryimages/winding/' . $result['Wound'] . '/orientation' . $result['Orientation'] . '.png';

        if ($orientation == "01") {
            $ori_text = "Image and text printed across the roll, top of the label off first.";
        } else if ($orientation == "02") {
            $ori_text = "Image and text printed across the roll, bottom of the label off first.";
        } else if ($orientation == "03") {
            $ori_text = "Image and text printed around the roll, right-side of the label off first.";
        } else if ($orientation == "04") {
            $ori_text = "Image and text printed around the roll, left-side of the label off first.";
        }

        ?>
        <div class="col-xs-12 col-md-5 col-sm-12 ">
            <div class="title">
                <div class="col-xs-8 col-sm-8 col-md-8"><b class="">Winding: <small> <?= $result['Wound'] ?></small></b>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4"><b class="">Core Size</b></div>
            </div>
            <div class="col-xs-6 col-sm-8 col-md-8"><img onerror='imgError(this);' class="text-center m-t-b-8"
                                                         src="<?= $tooltip ?>">
                <p><strong>Orientation:</strong> <?= $orientation ?> <br/> <?= $ori_text ?> </p>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-4"><img onerror='imgError(this);' class="text-center m-t-b-8"
                                                         src="<?= $coreimage ?>">
                <p><strong>Core: </strong> <?= $core ?></p>
            </div>
        </div>
    <? } else { ?>
        <div class="col-xs-12 col-md-5 col-sm-12 ">
            <img onerror='imgError(this);' src="<?= Assets ?>images/categoryimages/labelShapes/ws-banner-new.png" alt=""
                 height="" width="400">
        </div>
    <? } ?>
</div>
<?
$soft = AJAXURL . '/theme/site/printing/chat/softproof/' . $result['softproof'];
?>
<div class="thumbnail prMatDC">
    <div class="clear10"></div>

    <div class="scale-img"><img onerror='imgError(this);' class="col-xs-12 img-responsive" src="<?= $soft ?>"></div>

</div>
  