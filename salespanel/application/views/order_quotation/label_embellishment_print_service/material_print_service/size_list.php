<?
foreach ($records['list'] as $pro) {

    $categorycodea4 = '';
    $categorycoderoll = '';

    $rollcode = '';
    $A4code = '';
    $code = explode('.', $pro->CategoryImage);


    if (preg_match("/Roll Labels/", $pro->labelCategory)) {
        $LabelSize = str_replace("Roll Labels", "", $pro->CategoryName);
        $rollcode = $code[0];
        $availabel = 'Roll';
        $categorycoderoll = $pro->CategoryID . 'R1';
        $corner_radius = str_replace("Round", "", $pro->LabelCorner);
        $corner_radius = trim(str_replace("Radius", "", $corner_radius));

    } else {
        $x = explode("-", $pro->CategoryName);
        //$LabelSize = $x[1];
        $LabelSize = str_replace("Label Size:", "", $pro->specification3);
        $A4code = $code[0];
        $availabel = 'A4';
        $categorycodea4 = $pro->CategoryID;
        $corner_radius = $pro->LabelCornerRadius;
    }

    if ($pro->NearestSizes) {
        if (empty($A4code)) {
            $code = $this->home_model->get_db_column('category', 'CategoryImage', 'CategoryID', $pro->NearestSizes);
            $code = explode('.', $code);
            $A4code = $code[0];
            $categorycodea4 = $pro->NearestSizes;
            //$categorycodea4 = $A4code;
        } else {
            $rollcode = $this->home_model->get_roll_product_code($pro->NearestSizes);
            $rollcode = substr($rollcode, 0, -1);
            $categorycoderoll = $pro->NearestSizes . 'R1';
        }
        $availabel = 'both';
    }


    $label_image = Assets . 'images/categoryimages/thumbnail_label/' . $pro->CategoryImage;

    if (@getimagesize($label_image) == false) {
        $label_image = Assets . 'images/categoryimages/labelShapes/180x180.png';
    }


    ?>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-20-p pr-thumb-cont">
        <div class="thumbnail">
            <div class="row">
                <div class="col-md-12 m-t-10 top-tip">
                    <div class="col-md-2 col-xs-2">
                        <h3><img onerror='imgError(this);' class=""
                                 src="<?= Assets ?>images/categoryimages/labelShapes/printed_sheet.png"
                                 alt="Sheet Icon"></h3>
                    </div>
                    <div class="<?= ($A4code) ? 'col-md-9 col-xs-9' : 'col-md-10 col-xs-10' ?>"><strong>
                            <?= ($A4code) ? 'Available on A4 Sheet' : 'Not Available on Sheets' ?>
                        </strong><br>
                        <small>
                            <?= ($A4code) ? '<strong>Code:</strong> ' . $A4code : '' ?>
                        </small></div>
                    <?= ($A4code) ? '<div class="col-md-1 col-xs-1"><i class="fa fa-check-circle"></i></div>' : '' ?>
                </div>
                <div class="clear"></div>
                <div class="col-md-12 m-t-10 top-tip-roll">
                    <div class="col-md-2 col-xs-2">
                        <h3><img onerror='imgError(this);' class=""
                                 src="<?= Assets ?>images/categoryimages/labelShapes/printed_roll.png" alt="Roll Icon">
                        </h3>
                    </div>
                    <div class="<?= ($rollcode) ? 'col-md-9 col-xs-9' : 'col-md-10 col-xs-10' ?>"><strong>
                            <?= ($rollcode) ? 'Available on Rolls' : 'Not Available on Rolls' ?>
                        </strong><br>
                        <small>
                            <?= ($rollcode) ? '<strong>Code:</strong> ' . $rollcode : '' ?>
                        </small></div>
                    <?= ($rollcode) ? '<div class="col-md-1 col-xs-1"><i class="fa fa-check-circle"></i></div>' : '' ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="imgBg text-center"><img onerror='imgError(this);' class="lbl_img_size" width="178" height="193" src="<?= $label_image ?>" alt="Printed Labels"></div>
            <div class="caption3 m0">
                <div class="row">
                    <p class="col-md-12 col-xs-12">
                        <? if (!preg_match("/circular/is", $pro->Shape) and !preg_match("/oval/is", $pro->Shape)) { ?>
                            <strong>Corner Radius </strong>
                            <?= $corner_radius ?>
                        <? } ?>
                    </p>
                </div>
                <a href="javascript:void(0);" data-a4="<?= $categorycodea4 ?>" data-roll="<?= $categorycoderoll ?>"
                   data-size="<?= $availabel ?>" class="btn-block select_size btn orange" role="button"> <i
                            class="fa fa-arrow-circle-right"></i> Select for Print</a></div>
            <div class="clear"></div>
        </div>
    </div>
<? } ?>
<?
if (empty($pagination)) {
    $totalpages = ceil($count / 8); ?>
    <div class="clear"></div>
    <div class="row">
        <div class="col-md-12 text-center">
            <nav>
                <?= $html = $this->home_model->paginate_function(8, $current_page, $count, $totalpages); ?>
            </nav>
        </div>
    </div>
<? } ?>
