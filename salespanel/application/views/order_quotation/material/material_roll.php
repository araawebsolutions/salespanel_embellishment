<div id="aa_loader" class="white-screen hidden-xs" style="display:none;">
    <div class="loading-gif text-center" style="top:92%;"><img src="<?= aalables_path ?>images/loader.gif" class="image"
                                                               style="width:160px; height:43px; "></div>
</div>

<?

$newname = explode("(", $details['CategoryName']);

$showname = explode("-", $newname[0]);

$name = substr($showname[0], 2);


$catname = $name;

$image = explode('.', $details['CategoryImage']);

$img_chgr = $image[0];

$imagename = $image[0] . $coreid . ".jpg";

$material_code = "WTP";

$diecode = $image[0] . $material_code . preg_replace("/[^0-9]/", "", $coreid) . ".jpg";

if (isset($productid) and $productid != '') {

    $diecode = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

    $material_code = $this->home_model->getmaterialcode(substr($diecode, 0, -1));

    $diecode .= ".jpg";

}

$wound_option = $this->session->userdata('wound');

$wound_cate = $this->session->userdata('wound-cat');

$inside = '';


if (isset($wound_option) and $wound_option == 'Inside' and strcasecmp(substr($subcat, 0, -2), substr($wound_cate, 0, -2)) == 0) {

    $inside = 'selected="selected"';

}


if (isset($wound_option) and $wound_option == 'Inside' and strcasecmp(substr($subcat, 0, -2), substr($wound_cate, 0, -2)) == 0) {

    $popup_image = $img_src = aalables_path . "images/categoryimages/RollLabels/inside/" . $diecode;


} else {

    $popup_image = $img_src = aalables_path . "images/categoryimages/RollLabels/outside/" . $diecode;

}


if ($details['Shape_upd'] == "Circular") {

    $Label_size = str_replace("Label Size:", "", $details['specification3']);

} else {

    $Label_size = " Width " . $details['LabelWidth'] . "&nbsp;&nbsp; x &nbsp;Height&nbsp; " . $details['LabelHeight'];

}

//$Label_size = preg_replace("/Label Size:/","",$details['specification3']);

$height = 'auto';

$pop_width = 'auto';


if ($details['Shape_upd'] == "Oval" || $details['Shape_upd'] == "oval") {
    $LabelCorner = "N/A";
} else {
    $LabelCorner = $details['LabelCorner'];
}


//$img_src = aalables_path."images/outside_25.jpg";

//$productid = $this->home_model->get_db_column('products','ProductID', 'CategoryID',$details['CategoryID']."R1");

?>

<input type="hidden" id="dicode" value="<?=$details['CategoryID']?>">
<input type="hidden" id="myshape1" value="<?=$details['Shape_upd']?>">
<input type="hidden" id="regmark11" value="<?=$regmark?>">
<input type="hidden" id="productId11" value="<?=$productid?>">
<div class="bgGray">
    <div id="ajax_labelfilter" class="">
        <div class=" mat-sep-2017">
            <div class="selected-product">
                <div class="row">
                    <div id="prod_img" class="col-lg-2 col-md-2 col-sm-3 col-xs-3 pr-thumb"><img id="wound_image"
                                                                                                 src="<?= $img_src ?>"/>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <h1 class="pr-title">
                                    <?= $details['CategoryName'] ?>
                                </h1>
                                <div class="pr-detail">
                                    <p><b>Product Code: <span class="pr-code">
                  <input type="hidden" id="material_code_new" value="<?= $material_code ?>"/>
                                                <?= ltrim($details['DieCode'], "1-") ?>
                  </span></b></p>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                            <p><b>Label Shape:</b>
                                                <?= $details['Shape_upd'] ?>
                                            </p>
                                            <p><b>Leading Edge:</b>
                                                <?= $details['LeadingEdge'] ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                            <p><b>Label Size:</b>
                                                <?= $Label_size ?>
                                            </p>
                                            <p><b>Corner Radius:</b>
                                                <?= $LabelCorner ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row cw-filters">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 labels-form">
                                        <p><strong>Core Size </strong></p>
                                        <label class="select">
                                            <?

                                            $stylee = "";

                                            if ($coreinURL == "") {

                                                $stylee = "border:1px solid #fb3b01";

                                            }

                                            ?>
                                            <select id="coresize" name="coresize" style="<?= $stylee ?>">
                                                <option value="" <?= ($coreinURL == "") ? 'selected="selected"' : '' ?>>
                                                    Select Core Size
                                                </option>
                                                <option value="R1" <?= ($coreinURL == "R1") ? 'selected="selected"' : '' ?>>
                                                    1'' (25mm)
                                                </option>
                                                <option value="R2" <?= ($coreinURL == "R2") ? 'selected="selected"' : '' ?>>
                                                    1 ½'' (38mm)
                                                </option>
                                                <option value="R3" <?= ($coreinURL == "R3") ? 'selected="selected"' : '' ?>>
                                                    1 ¾'' (44.5mm)
                                                </option>
                                                <option value="R4" <?= ($coreinURL == "R4") ? 'selected="selected"' : '' ?>>
                                                    3'' (76mm)
                                                </option>
                                            </select>
                                            <i></i> </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 labels-form">
                                        <p><strong>Wound options </strong></p>
                                        <label class="select">
                                            <select id="woundoption" name="wound">
                                                <option value="Outside"> Outside Wound</option>
                                                <option <?= $inside ?> value="Inside"> Inside Wound</option>
                                            </select>
                                            <i></i> </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 labels-form"></div>
                                </div>

                            </div>
                            <?php

                            $max_diameter = 0;

                            $printer_compatiblity = '';

                            $Labelsgap = $details['LabelGapAcross'];

                            $height = $details['Height'];


                            $model = $this->input->get('printer');

                            if (isset($model) and $model != '') {

                                $query = $this->db->query("SELECT * FROM `printers_model` WHERE model LIKE '" . urldecode($model) . "' LIMIT 1 ");

                                $printer_model = $query->row_array();

                                $max_length = 250;

                                if (strlen($printer_model['specfication']) > $max_length) {

                                    $offset = ($max_length - 3) - strlen($printer_model['specfication']);

                                    $printer_model['specfication'] = substr($printer_model['specfication'], 0, strrpos($printer_model['specfication'], ' ', $offset)) . '...';

                                }

                                if (getimagesize(aalables_path . 'images/printer/model/' . $printer_model['image']) !== false) {

                                    $src = aalables_path . 'images/printer/model/' . $printer_model['image'];

                                } else {

                                    $src = aalables_path . 'images/no-image.png';

                                }


                                $max_diameter = $printer_model['RollDiamter'];

                                $printer_model['method'] = str_replace("/", "<br>", $printer_model['method']);

                                ?>
                                <div class="col-lg-4 col-md-4 hidden-sm hidden-xs printer-comp-detail">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4"><img class="img-responsive"
                                                                                     alt="labels Image "
                                                                                     src="<?= $src ?>" height="155"
                                                                                     width="185"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-8">
                                            <h2 class="BlueHeading no-margin">
                                                <?= $printer_model['Name'] ?>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="clear5"></div>
                                    <p><b>Maximum Print Size:</b>
                                        <?= $printer_model['PrintWidth'] ?>
                                        mm </p>
                                    <p><b>Maximum Roll Diameter:</b>
                                        <?= $printer_model['RollDiamter'] ?>
                                        mm </p>
                                    <p><b>Core Size: </b>
                                        <?= $printer_model['coresize'] ?>
                                        mm </p>
                                    <p><b>Compatibility:</b>
                                        <?= $printer_model['method'] ?>
                                    </p>
                                    <div class="btns"><a rel="nofollow" target="_blank"
                                                         href="<?= base_url() ?>download/usermanuals/<?= $printer_model['pdf'] ?>"

                                                         class="btn btn-sm orangeBg pull-left" role="button"><i
                                                    class="fa fa-file-pdf-o"></i> User Manuals </a> <a rel="nofollow"
                                                                                                       target="_blank"
                                                                                                       href="<?= base_url() ?>download/printer/<?= $printer_model['pdf'] ?>"
                                                                                                       class="btn btn-sm orangeBg pull-right"

                                                                                                       role="button"> <i
                                                    class="fa fa-file-pdf-o"></i> Product Datasheet </a></div>
                                </div>
                                <? $printer_compatiblity = $printer_model['method'];
                            } else { ?>
                                <input type="hidden" id="max_diameter" value="0"/>
                                <div class="col-lg-4 col-md-4 hidden-sm hidden-xs text-center why-seal"><img
                                            class="img-responsive" src="<?= aalables_path ?>images/30-icon.png"
                                            alt="30 Days Moneyback Guarantee">
                                    <div class="title m-t-10"><a href="javascript:void(0);" data-toggle="popover"
                                                                 data-trigger="hover" data-placement="top"
                                                                 data-html="true"

                                                                 data-content="<div class='col-lg-12 col-md-12 frc-banner'><div class='title'> FAST, RELIABLE &amp; COST EFFECTIVE </div><ul><li>Over 80% of orders despatched same day</li><li>Daily despatch and delivery</li><li>Add the “Next Day” option to your order</li><li>If you need labels quicker, add a PRE 10:30 or 12:00 option for even faster delivery.</li><li>1,000’s of satisfied customers.</li><li>  <img src='<?= aalables_path ?>images/iso_14001.png'> ISO9001 Certified</li><li><img src='<?= aalables_path ?>images/iso_9001.png'> ISO14001 Certified</li> </ul></div>">Why
                                            Buy from AA Labels? <i class="fa fa-info-circle"></i></a></div>
                                </div>
                            <? } ?>
                            <input type="hidden" name="coreid" id="coreid" value="<?= $coreid ?>"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clear"></div>
            <?php

            $class = $class2 = "";

            if (!isset($othermaterials)) {

                $class = "fetch_category_mateials";

                $class2 = "other_materials";

            }

            ?>
            <div class="<?= $class2 ?>">
                <div class="panel panel-default no-border mat-may-2017 <?= $class ?>">
                    <div class="panel-body no-padding">
                        <div class="colors_data mat-ch append_search"
                             id="<?= (isset($othermaterials) and $othermaterials != '') ? '' : 'ajax_material_sorting' ?>">
                            <? if (isset($othermaterials) and $othermaterials != '') {
                                $single_product = 'active';
                            }
                            include('material_list_view_roll.php'); ?>
                        </div>
                    </div>
                </div>
                <? if (isset($othermaterials) and $othermaterials != ''){

                $single_product = '';

                $productid = '';

                $materials = $othermaterials; ?>
                <? if ($filter != 'disabled' and !$this->agent->is_mobile()) { ?>
                    <div class="sort-filters hidden-xs filterBg p-l-r-10" style="display:none">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="hide_title">Other Materials </h4>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                        <div class="row">
                                            <div class="labels-form col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <label class="select">
                                                    <select name="material_mat" id="material_mat"
                                                            onchange="fetch_category_mateials();">
                                                        <option value="" selected="selected">Sort by Materials</option>
                                                        <? foreach ($paper as $paper_list) { ?>
                                                            <option value="<?= $paper_list->Material ?>">
                                                                <?= $paper_list->Material ?>
                                                            </option>
                                                        <? } ?>
                                                    </select>
                                                    <i></i> </label>
                                            </div>
                                            <div class=" labels-form  col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <label class="select">
                                                    <select name="color_mat" id="color_mat"
                                                            onchange="fetch_category_mateials();">
                                                        <option value="" selected="selected">Sort by Colour</option>
                                                        <? foreach ($color as $color_list) { ?>
                                                            <option value="<?= $color_list->Color ?>">
                                                                <?= $color_list->Color ?>
                                                            </option>
                                                        <? } ?>
                                                    </select>
                                                    <i></i> </label>
                                            </div>
                                            <div class=" labels-form col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <label class="select">
                                                    <select name="adhesive_mat" id="adhesive_mat"
                                                            onchange="fetch_category_mateials();">
                                                        <option value="" selected="selected">Sort by Adhesive</option>
                                                        <? foreach ($adhesive as $adhesive_list) { ?>
                                                            <option value="<?= $adhesive_list->Adhesive ?>">
                                                                <?= $adhesive_list->Adhesive ?>
                                                            </option>
                                                        <? } ?>
                                                    </select>
                                                    <i></i> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <div>
                                            <button onclick="window.location.reload();" class="btn orangeBg btn-block"
                                                    role="button"><i class="fa fa-refresh"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
                <div class="other_materials">
                    <div class="clear"></div>
                    <div class="panel panel-default no-border mat-may-2017 fetch_category_mateials">
                        <div class="panel-body no-padding">
                            <div class="mat-ch">
                                <div class="colors_data mat-ch append_search"
                                     id="<?= (isset($othermaterials) and $othermaterials != '') ? 'ajax_material_sorting' : '' ?>">
                                    <? include('material_list_view_roll.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <? } ?>
                    <div class="clear"></div>
                    <div class="panel panel-default no-border mat-may-2017 other_mats" style="display:none">
                        <div class="panel-body no-padding">
                            <div class="mat-ch">
                                <h3 class="mat-ch-title">Other Materials</h3>
                                <div class="colors_data mat-ch append_search"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout modal -->

    <div class="modal fade layout aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content no-padding">
                <div class="panel no-margin">
                    <div class="panel-heading">
                        <h3 class="pull-left no-margin"><b>Label Layout</b></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                    class="fa fa-times-circle"></i></button>
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body">
                        <div id="ajax_layout_spec"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout modal -->

    <!-- Material Detail modal -->

    <div class="modal fade material" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span
                                aria-hidden="true">×</span></button>
                    <h4 id="myModalLabel" class="modal-title">AA Labels Technical Specification - <span
                                id="mat_code"></span> <a href="#myModalLabel" class="anchorjs-link"><span
                                    class="anchorjs-icon"></span></a></h4>
                </div>
                <div class="">
                    <div>
                        <div class="col-md-3 text-center"><img id="material_popup_img" src="" alt="<?= $catname ?>"
                                                               title="<?= $catname ?>" width="46" height="46"
                                                               class="m-t-b-10 img-Sheet-material"></div>
                        <div class="col-md-9">
                            <div id="specs_loader" class="white-screen hidden-xs" style="display:none;">
                                <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                            src="<?= aalables_path ?>images/loader.gif" width="139" height="29"
                                            class="image" style="width:181px; height:181px; "></div>
                            </div>
                            <div id="ajax_tecnial_specifiacation" class="specifiacation"></div>
                            <div class="bgGray p-l-r-10">
                                <small> This summary materials specification for this adhesive label is based on
                                    information obtained from the original material manufacturer and is offered in good
                                    faith in accordance with AA Labels terms and conditions to determine fitness for use
                                    as labels on rolls produced by AA Labels. No guarantee is offered or implied. It is
                                    the user's responsibility to fully asses and/or test the label's material and
                                    determine its suitability for the label application intended. Measurements and test
                                    results on this label's material are nominal. In accordance with a policy of
                                    continuous improvement for label products the manufacturer and AA Labels reserves
                                    the right to amend the specification without notice. A <a
                                            href="<?= base_url() ?>labels-materials/">full material specification</a>
                                    can be found in the Label Materials section accessed via the Home Page <br>
                                    Copyright AA labels 2015
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Material Detail modal -->

    <div class="modal fade deactive_product" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span
                                aria-hidden="true">×</span></button>
                    <h4 id="myModalLabel" class="modal-title">Sorry this product is discontinued. <a
                                href="#myModalLabel" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
                </div>
                <div class="col-md-12">
                    <p></p>
                    <p>We have discontinued this product due to supply issues. We are sure we will have an alternative
                        product that could be suitable for your application. </p>
                    <p>Please call our customer care team on 01733 588390 or choose from over 40 different materials. <a
                                id="alter_link" href="#">Click Here</a></p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sample Order implementation -->

    <div class="modal fade pbreaks aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content no-padding">
                <div class="panel no-margin">
                    <div class="panel-heading" style="height: 50px;background-color: #006da4 !important;">
                        <h3 class="pull-left no-margin" style="font-size: 20px;font-weight: bold;padding: 0px;line-height: 15px;">VOLUME PRICE BREAKS ROLL LABELS
                            <a href="#myModalLabel"
                                                                                                  class="anchorjs-link"><span
                                        class="anchorjs-icon"></span></a></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none repeat scroll 0 0 transparent!important;border: 0;"><i
                                    class="fa fa-times-circle" style="color: #ffffff;font-size: 26px;"></i></button>
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body">
                        <div class="text-center">
                            <div id="price_loader" class="white-screen hidden-xs" style="display:none;">
                                <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                            src="<?= aalables_path ?>images/loader.gif" class="image"></div>
                            </div>
                            <div id="ajax_price_breaks"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade artworkModal1 aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content no-padding">
                <div class="panel no-margin">
                    <div class="panel-heading" style="height: 50px;background-color: #006da4 !important;">
                        <h3 class="pull-left no-margin" style="    font-size: 20px;font-weight: bold;padding: 0px;    line-height: 15px;">Upload Artwork</h3>
                        

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none repeat scroll 0 0 transparent!important;border: 0;"><i
                                    class="fa fa-times-circle" style="color: #ffffff;font-size: 26px;"></i></button>

                                    
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div id="artworks_uploads_loader" class="white-screen hidden-xs" style="display:none;">
                                <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                            src="<?= aalables_path ?>images/loader.gif" class="image"
                                            style="width:139px; height:29px; "></div>
                            </div>
                            <div id="ajax_artwork_uploads" class=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade lb_applications aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none repeat scroll 0 0 transparent!important;border: 0;"><i
                                    class="fa fa-times-circle" style="color: #ffffff;font-size: 26px;"></i></button>
                    <h4 id="myModalLabel1" class="modal-title"><span id="app_group_name"></span> - Label Applications <a
                                href="#myModalLabel1" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
                </div>
                <div>
                    <div id="lb_applications_loader" class="white-screen hidden-xs" style="display:none;">
                        <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                    src="<?= aalables_path ?>images/loader.gif" class="image"
                                    style="width:139px; height:29px; "></div>
                    </div>
                    <? include('applications.php'); ?>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sample Order implementation -->

    <div class="modal fade coresize_popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content thumb_p15">
                <div class="title">
                    <div class="col-md-12">
                        <div class="roll-icon pull-left"><img class=""
                                                              src="<?= aalables_path ?>images/categoryimages/labelShapes/printed_roll.png"
                                                              alt="Printed Labels on Rolls"></div>
                        <div class="m-t-15"></div>
                        <h4 class="pull-left no-margin" style="margin-left: 6px !important;"> Selection Core Size</h4>
                        <div class="labels-form">
                            <div class="clear15"></div>
                            <div class="dm-row popupmodel">
                                <div class="dm-box">
                                    <div class="thumbnail" style="border:none; box-shadow:none; background:none;">
                                        <div class="roll_sheets_block">
                                            <div class="btn-group btn-block dm-selector"><a
                                                        class="btn btn-default btn-block dropdown-toggle"
                                                        data-toggle="dropdown" data-value="">Select Core Size<i
                                                            class="fa fa-unsorted"></i></a>
                                                <ul class="dropdown-menu coresize_dropdownmenu btn-block">
                                                    <li class="coresize_li"><a data-toggle="tooltip-orintation_popup"
                                                                               data-trigger="hover"
                                                                               data-placement="right" title=""
                                                                               data-id="R1">1'' (25mm)<img
                                                                    src="<?= aalables_path ?>images/loader.gif"> </a>
                                                    </li>
                                                    <li class="coresize_li"><a data-toggle="tooltip-orintation_popup"
                                                                               data-trigger="hover"
                                                                               data-placement="right" title=""
                                                                               data-id="R2">1 ½'' (38mm)<img
                                                                    src="<?= aalables_path ?>images/loader.gif"> </a>
                                                    </li>
                                                    <li class="coresize_li"><a data-toggle="tooltip-orintation_popup"
                                                                               data-trigger="hover"
                                                                               data-placement="right" title=""
                                                                               data-id="R3">1 ¾'' (44.5mm)<img
                                                                    src="<?= aalables_path ?>images/loader.gif"> </a>
                                                    </li>
                                                    <li class="coresize_li"><a data-toggle="tooltip-orintation_popup"
                                                                               data-trigger="hover"
                                                                               data-placement="right" title=""
                                                                               data-id="R4">3'' (76mm)<img
                                                                    src="<?= aalables_path ?>images/loader.gif"> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12  m-t-60"><img class="img-responsive popup_coreimage"
                                                        style="width: 150px;margin-top: -40px;margin-left:auto;margin-right:auto;"
                                                        src="<?= $popup_image ?>"></div>
                </div>
                <div class="clear10"></div>
                <hr>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div style="text-align: center;" class="col-md-8"><a data-dismiss="modal"
                                                                         class="btn orangeBg btn-block confirm_coresize disabled">Confirm  <i class="fa fa-check-circle" aria-hidden="true"></i></a></div>
                </div>
            </div>
        </div>
    </div>
    <script>


        var timer = '';

        function show_faded_popover(_this, text) {

            $(_this).attr('data-content', '');

            $(_this).popover('hide');




            $(_this).popover({'placement': 'top'});

            $(_this).attr('data-content', text);

            $(_this).popover('show');

            clearTimeout(timer);

            timer = setTimeout(function () {

                $(_this).attr('data-content', '');

                $(_this).popover('hide');



            }, 2000);

        }


        $(document).on("click", ".browse_btn", function (e) {
            $(this).parents('.upload_row').find('.artwork_file').click();
        });

        $(document).on("change", ".artwork_file", function (e) {
					//alert('ch');
					readURL(this);
					$('.artwork_file').hide();
				});

        function readURL(input) {
					if (input.files && input.files[0]) {
						var url = input.value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (ext == 'docx' || ext == 'doc') {
                    $('#preview_po_img').attr('src', '<?=aalables_path?>images/doc.png');
                    $('#preview_po_img').show();
                    $('.browse_btn').hide();
                }
                else if (ext == 'pdf') {
                    $('#preview_po_img').attr('src', '<?=aalables_path?>images/pdf.png');
                    $('#preview_po_img').show();
                    $('.browse_btn').hide();
                }
                else if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview_po_img').attr('src', e.target.result);
                        $('#preview_po_img').show();
                        $('.browse_btn').hide();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    $('#preview_po_img').attr('src', '<?=aalables_path?>images/no-image.png');
                    $('#preview_po_img').show();
                    $('.browse_btn').hide();
                }
            }
        }
        $(document).on("click", "#preview_po_img", function (e) {
            swal({
							title: 'Are you sure you want to delete this file?',
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn orangeBg",
							confirmButtonText: "No",
							cancelButtonClass: "btn blueBg m-r-10",
							cancelButtonText: "Yes",
							closeOnConfirm: true,
							closeOnCancel: true
						},

								 function (isConfirm) {
							if (isConfirm) {
								console.log('cancel');
							} else {
								$('.browse_btn').show();
								$('#preview_po_img').hide();
							}
						});
        });


        $(document).on("click", ".productdetails .colourpicker li a", function (e) {

            var colour = $(this).attr('data-value');

            $(this).parents('.productdetails').attr('data-colour', colour);

            $(this).parents('.productdetails').find('.colourpicker li').removeClass('active');

            $(this).parent().addClass("active");

            $(this).blur();

            get_product_details(this);

        });

        $(document).on("change", ".product_adhesive", function (e) {

            get_product_details(this);

        });


        var old_labels_input;

        var old_roll_labels_input;

        var old_roll_input;

        $(document).on("focus", ".roll_labels_input", function (e) {

            old_roll_labels_input = $(this).val();

        });

        $(document).on("focus", ".input_rolls", function (e) {

            old_roll_input = $(this).val();

        });


        $(document).on("keypress keyup blur", ".roll_labels_input", function (e) {

            var rolls = $(this).parents('.upload_row').find('.input_rolls').val();

            if ($(this).val() != old_roll_labels_input && rolls.length > 0) {

                $(this).parents('.upload_row').find('.roll_updater').show();
                $(this).parents('.upload_row').find('.quantity_updater').show();

            }

        });

        $(document).on("keypress keyup blur", ".input_rolls", function (e) {


            var labels = $(this).parents('.upload_row').find('.roll_labels_input').val();

            if ($(this).val() != old_roll_input && labels.length > 0) {

                $(this).parents('.upload_row').find('.roll_updater').show();

                $(this).parents('.upload_row').find('.quantity_updater').show();

            }

        });


        $(document).on("click", ".add_another_art", function (e) {

            $('.upload_row').show();

            $(this).hide();

            $('#add_another_line').hide();


        });

        $(document).on("click", ".delete_artwork_file", function (event) {

            var id = $(this).attr('id');

            var cartid = $('#cartid').val();

            var productid = $('#cartproductid').val();

            var persheet = $('#labels_p_sheet').val();

            var type = 'rolls';

            var product_id = $(parent_selector).parents('.productdetails').find('.product_id').val();

            var presproof = $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-presproof');


            swal(
                "Are You Sure You Want To Delete This Line",


                {

                    buttons: {

                        cancel: "No",

                        catch: {

                            text: "Yes",

                            value: "catch",

                        },


                    },

                    icon: "warning",

                    closeOnClickOutside: false,

                },
            ).then((value) => {

                switch (value) {


                    case "catch":

                        $.ajax({

                            url: mainUrl + 'search/Search/delete_material_artworks',

                            type: "POST",

                            async: "false",

                            dataType: "html",

                            data: {

                                fileid: id,

                                cartid: cartid,

                                productid: productid,

                                persheet: persheet,

                                type: type,

                                gap: '<?=$Labelsgap?>',

                                size: '<?=$height?>',

                                presproof: presproof,

                            },

                            success: function (data) {

                                data = $.parseJSON(data);

                                if (!data == '') {

                                    update_printed_quantity_box(data.qty, data.designs, data.rolls);

                                    $('#ajax_upload_content').html(data.content);

                                    intialize_progressbar();

                                }

                            }

                        });

                        break;


                }

            });


        });


        var parent_selector = null;


 $(document).on("click", ".artwork_uploader_roll", function (e) {
          
          
          

            var cart_id = $(this).parents('.productdetails').find('.cart_id').val();

            var product_id = $(this).parents('.productdetails').find('.product_id').val();

            var manfactureid = $(this).parents('.productdetails').find('.manfactureid').val();

            var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

            var _this = this;

            parent_selector = this;

            var product_id = $(parent_selector).parents('.productdetails').find('.product_id').val();

            var presproof = $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-presproof');


            $('#ajax_artwork_uploads').html('');

            $('#artworks_uploads_loader').show();

            $.ajax({

                url: mainUrl + 'search/Search/view_artworks_content',

                type: "POST",

                async: "false",

                data: {

                    manfactureid: manfactureid,

                    product_id: product_id,

                    type: 'rolls',

                    labelspersheet: labels,

                    cart_id: cart_id,

                    gap: '<?=$Labelsgap?>',

                    size: '<?=$height?>',

                    presproof: presproof,

                },

                dataType: "html",

                success: function (data) {

                    if (!data == '') {

                        data = $.parseJSON(data);

                        update_printed_quantity_box(data.qty, data.designs, data.rolls);

                        $('#artworks_uploads_loader').hide();

                        $('#ajax_artwork_uploads').html(data.html);

                        intialize_progressbar();

                        if (cart_id.length == 0 || cart_id == '') {

                            $(_this).parents('.productdetails').find('.cart_id').val(data.cartid);

                        }
                      
                      var printlabels = parseInt($(parent_selector).parents('.productdetails').find('.printlabels').val());
                      $('#artwork_custom_lab').val(printlabels);    
                  
                      var no_roll = $('#custom_qty_roll_'+product_id).val();     
                      $('#no_of_roll_custom_art').val(no_roll);     
                  
                  
                      if(typeof printlabels != 'undefined' && printlabels.isNaN == false && printlabels!="" && printlabels!=0 && no_roll!=""  && no_roll!=0){
                        $('.show_labels_per_roll').text(Math.ceil(printlabels / no_roll));
                      }


                    }

                }

            });

        });




        $(document).on("click", ".roll_updater", function (event) {
event.preventDefault();

            var id = $(this).attr('data-id');

            var _this = this;

            var cartid = $('#cartid').val();

            var prdid = $('#cartproductid').val();

            var labelpersheets = $('#labels_p_sheet').val();

            var type = 'rolls';


            var response = verify_labels_or_rolls_qty(_this);

            if (response == false) {
                return false;
            }

            var labels = $(_this).parents('.upload_row').find('.roll_labels_input').val();

            var sheets = $(_this).parents('.upload_row').find('.input_rolls').val();

            var product_id = $(parent_selector).parents('.productdetails').find('.product_id').val();

            var presproof = $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-presproof');


            $.ajax({

                url: mainUrl + 'search/Search/update_material_artworks',

                type: "POST",

                async: "false",

                dataType: "html",

                data: {

                    id: id,

                    cartid: cartid,

                    productid: prdid,

                    labels: labels,

                    sheets: sheets,

                    persheet: labelpersheets,

                    type: type,

                    size: '<?=$height?>',

                    gap: '<?=$Labelsgap?>',

                    presproof: presproof,

                },

                success: function (data) {

                    data = $.parseJSON(data);

                    if (!data == '') {

                        update_printed_quantity_box(data.qty, data.designs, data.rolls);

                        $('#ajax_upload_content').html(data.content);

                        intialize_progressbar();

                    }

                }

            });


        });


        // function upload_printing_artworks(form_data){
        //
        //
        //
        // 			$.ajax({
        //
        // 					url: base+'ajax/upload_material_artworks',
        //
        // 					type:"POST",
        //
        // 					async:"false",
        //
        // 					dataType: "html",
        //
        // 					cache:false,
        //
        // 					contentType: false,
        //
        // 					processData: false,
        //
        // 					data:form_data,
        //
        // 					beforeSend: function() {
        //
        // 						$( "#upload_pecentage" ).html(' &nbsp;0%');
        //
        // 						$( "#upload_progress" ).show();
        //
        // 						$('.save_artwork_file').prop('disabled', true);
        //
        // 					},
        //
        // 					xhr: function() {
        //
        // 							var myXhr = $.ajaxSettings.xhr();
        //
        // 							if(myXhr.upload){
        //
        // 								myXhr.upload.addEventListener('progress',progress, false);
        //
        // 							}
        //
        // 							return myXhr;
        //
        // 					},
        //
        // 					error: function(data){
        //
        // 							swal('Some error occured please try again');
        //
        // 							intialize_progressbar();
        //
        // 							$( "#upload_progress" ).hide();
        //
        // 							$('.save_artwork_file').prop('disabled', false);
        //
        // 					},
        //
        // 					success: function(data){
        //
        // 						$('.save_artwork_file').prop('disabled', false);
        //
        // 						data = $.parseJSON(data);
        //
        // 						if(data.response=='yes'){
        //
        // 								$('#ajax_upload_content').html(data.content);
        //
        //
        //
        // 								 update_printed_quantity_box(data.qty, data.designs, data.rolls);
        //
        //
        //
        // 								intialize_progressbar();
        //
        // 								$( "#upload_progress" ).hide();
        //
        // 						}else{
        //
        // 								swal('upload failed',data.message, 'error');
        //
        // 								intialize_progressbar();
        //
        // 								$( "#upload_progress" ).hide();
        //
        // 								$('.save_artwork_file').prop('disabled', false);
        //
        // 						}
        //
        // 				 }
        //
        // 			});
        //
        // }

        function update_printed_quantity_box(qty, designs, rolls) {

            var product_id = $(parent_selector).parents('.productdetails').find('.product_id').val();

            $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).val(designs);

            $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-qty', qty);

            $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-rolls', rolls);

            var old_quantity = parseInt($(parent_selector).parents('.productdetails').find('.printlabels').val());

            if (qty > 0) {

                $(parent_selector).parents('.productdetails').find('.printlabels').val(qty);

                reset_print_input_buttons(parent_selector);

            }

           if($('#no_artworks_'+product_id).val() == 0){
                update_artwork_upload_btn(parent_selector, designs);
                } 

        }

        function update_artwork_upload_btn(_this, designs) {

            if (designs > 0) {

                var Artwork = 'Artwork';

                if (designs > 1) {

                    var Artwork = 'Artworks';

                }

                $(_this).parents('.productdetails').find('.artwork_uploader').switchClass('art-btn', 'art-btn-l');


                var btnhtml = '<div class="row"><div class="col-md-4 col-xs-4"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div><div class="col-md-8 col-xs-8"><b>&nbsp;' + designs + ' ' + Artwork + ' Uploaded </b>';

                btnhtml += '<small>Click here to upload further<br>artworks, view or edit.</small></div></div></div>';

                $(_this).parents('.productdetails').find('.artwork_uploader').html(btnhtml);

            } else {

                $(_this).parents('.productdetails').find('.artwork_uploader').switchClass('art-btn-l', 'art-btn');

                var btnhtml = '<i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Click here to Upload Your Artwork';

                $(_this).parents('.productdetails').find('.artwork_uploader').html(btnhtml);

            }

        }


        $(document).on("click", "#pressproof", function (e) {

            var product_id = $(parent_selector).parents('.productdetails').find('.product_id').val();

            if ($(this).is(':checked')) {

                $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-presproof', 1);

            } else {

                $(parent_selector).parents('.productdetails').find('#uploadedartworks_' + product_id).attr('data-presproof', 0);

            }

            reset_print_input_buttons(parent_selector);

        });


        function progress(e) {

            if (e.lengthComputable) {

                var max = e.total;

                var current = e.loaded;

                var Percentage = Math.ceil((current * 100) / max);

                $("#progressbar").progressbar("option", "value", Percentage);

                $("#upload_pecentage").html(' &nbsp;' + Percentage + '%');


                if (Percentage >= 100) {

                    $("#progressbar").progressbar("option", "value", 100);

                    $("#upload_pecentage").html(' &nbsp;100%');

                }

            }

        }


        function intialize_progressbar() {

            $("#progressbar").progressbar({

                value: 0,

                create: function (event, ui) {

                    $(this).removeClass("ui-corner-all").addClass('progress').find(">:first-child").removeClass("ui-corner-left").addClass('progress-bar progress-bar-success');

                }

            });

        }


        function get_product_details(_this) {


            if (!check_core_selected()) {

                return false;

            }


            var productid = $(_this).parents('.productdetails').attr('data-value');

            var finish = $(_this).parents('.productdetails').attr('data-finish');

            var material = $(_this).parents('.productdetails').attr('data-material');

            //var colour = $(_this).parents('.productdetails').attr('data-colour');

            var colour = $(_this).parents('.productdetails').find('.colourpicker .active a').attr('data-value');

            var adhesive = $(_this).parents('.productdetails').find('.product_adhesive').val();


            if (adhesive == '' || adhesive == null) {
                return true;
            }


            reset_plain_input_buttons(_this);

            reset_print_input_buttons(_this);


            var top = $(_this).offset().top;

            top = top - 200;


            $('.loading-gif').css('top', top);

            $('#aa_loader').show();


            /*********** Empty the Cart here ***********/


            /******************************************/


            $.ajax({

                url: mainUrl + 'search/search/grouped_product_info',
                type: "post",
                async: "false",
                dataType: "json",
                data: {
                    productid: productid,
                    colour: colour,
                    finish: finish,
                    material: material,
                    adhesive: adhesive,
                    catid: '<?=$details['CategoryID'] . $coreid?>',
                    type: 'Rolls',
                    maxdiamter: '<?=$max_diameter?>',
                    Labelsgap: '<?=$Labelsgap?>',
                    height: '<?=$details['Width']?>',
                    width: '<?=$details['Height']?>',
                },

                success: function (data) {

                    $('#aa_loader').hide();

                    if (data.response == 'notfound') {

                        alert_box('Sorry this product is out of stock this time.');

                    } else {

                        $(_this).parents('.productdetails').find('.product_adhesive').html(data.adhesive_option);
                        $(_this).parents('.productdetails').find('.product_material_image').attr('src', data.image_path);
                        $(_this).parents('.productdetails').find('.product_name').html(data.product_name);
                        $(_this).parents('.productdetails').find('.product_description').html(data.product_description);


                        $(_this).parents('.productdetails').find('.product_id').val(data.product_id);
                        $(_this).parents('.productdetails').find('.manfactureid').val(data.manfactureid);

                        $(_this).parents('.productdetails').find('#minimum_quantities').val(data.minimum);

                        $(_this).parents('.productdetails').find('#maximum_quantities').val(data.maximum);

                        $(_this).parents('.productdetails').find('.PrintableProduct').val(data.Printable);

                        $(_this).parents('.productdetails').find('.minimum_printed_labels').val(data.minprintedlabels);

                        $(_this).parents('.productdetails').find('.maximum_printed_labels').val(data.max_labels);


                        $(_this).parents('.productdetails').find('.laser_printer_img').attr('src', data.laser_img);

                        $(_this).parents('.productdetails').find('.inkjet_printer_img').attr('src', data.inkjet_img);

                        $(_this).parents('.productdetails').find('.direct_printer_img').attr('src', data.d_thermal_img);

                        $(_this).parents('.productdetails').find('.thermal_printer_img').attr('src', data.thermal_img);


                        $(_this).parents('.productdetails').find('.laser_printer_div').attr('data-original-title', data.laser_text);

                        $(_this).parents('.productdetails').find('.inkjet_printer_div').attr('data-original-title', data.inkjet_text);

                        $(_this).parents('.productdetails').find('.thermal_printer_div').attr('data-original-title', data.thermal_text);

                        $(_this).parents('.productdetails').find('.direct_printer_div').attr('data-original-title', data.d_thermal_text);

                        $(_this).parents('.productdetails').find("[data-toggle=tooltip-product]").tooltip('destroy');

                        $(_this).parents('.productdetails').find("[data-toggle=tooltip-product]").tooltip();


                        var str_manfactureid = data.manfactureid;

                        var hidevalue = "6 Colour Digital Process";

                        $(_this).parents('.productdetails').find(".digital_proccess-d-down").find("li").show();

                        if (str_manfactureid.match(/PGCP/g) || str_manfactureid.match(/PGCR/g)) {

                            $(_this).parents('.productdetails').find(".digital_proccess-d-down").find("[data-value='" + hidevalue + "']").parent("li").hide();

                        }


                        $('#material_code_new').val(data.material_code);


                        if (data.roll_image != '') {

                            $('.selected-product').find('#wound_image').attr('src', data.roll_image);

                            $(_this).parents('.productdetails').find('.product_material_image').attr('src', data.roll_image);

                        }


                        if (data.Printable == 'N') {

                            $(_this).parents('.productdetails').find('.printedoption').addClass('hide');

                            $(_this).parents('.productdetails').find('.tabprinted').removeClass('active');


                            $(_this).parents('.productdetails').find('.tabplain').removeClass('active');

                            $(_this).parents('.productdetails').find('.plainoption').removeClass('active');


                            $(_this).parents('.productdetails').find('.tabplain').addClass('active');

                            $(_this).parents('.productdetails').find('.plainoption').addClass('active');


                            $(_this).parents('.productdetails').find('.addprintingoption').addClass('hide');


                        } else {

                            $(_this).parents('.productdetails').find('.printedoption').removeClass('hide');

                            //$(_this).parents('.productdetails').find('.addprintingoption').removeClass('hide');

                        }


                        var exist = $(_this).parents('.productdetails').find('#uploadedartworks_' + data.product_id).length;

                        if (exist == 0) {

                            var _el = document.createElement('input');

                            _el.value = 0;

                            _el.type = 'hidden';

                            _el.id = 'uploadedartworks_' + data.product_id;

                            $(_this).parents('.productdetails').find('.hiddenfields').append(_el);

                            $(_this).parents('.productdetails').find('#uploadedartworks_' + data.product_id).attr('data-rolls', 0);

                            $(_this).parents('.productdetails').find('#uploadedartworks_' + data.product_id).attr('data-presproof', 0);

                        }

                        var designs = $(_this).parents('.productdetails').find('#uploadedartworks_' + data.product_id).val();

                        update_artwork_upload_btn(_this, parseInt(designs));

                    }

                }

            });

        }


        $(document).on("focus", ".plainlabels,.plainrolls", function (e) {

            if (!check_core_selected()) {

                return false;

            }

            reset_plain_input_buttons(this);

        });

        $(document).on("focus", ".printlabels", function (e) {

            if (!check_core_selected()) {

                return false;

            }

            reset_print_input_buttons(this);

        });


        function reset_plain_input_buttons(_this) {

            $(_this).parents('.productdetails').find('.plainprice_box').hide();

            $(_this).parents('.productdetails').find('.add_plain_roll').hide();

            $(_this).parents('.productdetails').find('.plain_save_txt').hide();

            $(_this).parents('.productdetails').find('.diamterinfo').hide();

            $(_this).parents('.productdetails').find('.addprintingoption').addClass('hide');


            $(_this).parents('.productdetails').find('.calculate_printed_roll').show();
            $(_this).parents('.productdetails').find('.calculate_plain_roll').show();


        }

        function reset_print_input_buttons(_this) {

            $(_this).parents('.productdetails').find('.printedprice_box').hide();

            $(_this).parents('.productdetails').find('.add_printed_roll').hide();

            $(_this).parents('.productdetails').find('.calculate_printed_roll').show();

        }

        function is_numeric(mixed_var) {

            var whitespace =

                " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";

            return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -

                1)) && mixed_var !== '' && !isNaN(mixed_var);

        }

        $(document).on("click", ".printpriceoffer", function (e) {

            $(this).parents('.productdetails').find('.plainoption').removeClass('active');

            $(this).parents('.productdetails').find('.printedoption').addClass('active');

        });


        function addLineForRollIntoOrderDetail(qty, menuid, prd_id, labels, type, method_on_page, rolltype, labelfinish = null, printing = null, presproof = null, woundoption = null, orientation = null, cartId = null, regmark = null,printoption=null) {
            var plainPrice = $('#od_dt_price').val();
            var printedPrice = $('#od_dt_printed').val();
            var orderNumber = $('#order_number').val();

            var digital = $('#digital').val();
            var per_sheet_roll = $('.LabelsPerSheet').val();
            var useer_id = $('#useer_id').val();
            
            var _thiss = $("[data-value='"+prd_id+"']");
            var manual_design = $(_thiss).find('#no_artworks_'+prd_id).val();

            $.ajax({

                url: mainUrl + 'order_quotation/Order/addLineForRoll',

                type: "POST",

                async: "false",

                dataType: "html",

                data: {
                    pageName: method_on_page,
                    useer_id: useer_id,
                    per_sheet_roll: per_sheet_roll,
                    orderNumber: orderNumber,
                    qty: qty,
                    menuid: menuid,
                    productId: prd_id,
                    labels: labels,
                    type: type,
                    digital: digital,
                    plainPrice: plainPrice,
                    printedPrice: printedPrice,
                    rolltype: rolltype,
                    labelfinish: labelfinish,
                    printing: printing,
                    presproof: presproof,
                    woundoption: woundoption,
                    orientation: orientation,
                    cartId: cartId,
                    printoption:printoption,
                    regmark: regmark,
                    manual_design:manual_design

                },

                success: function (data) {


                    data = $.parseJSON(data);

                    if (data.response == 'yes') {

                        swal(
                            "New Product  Added",
                            {

                                buttons: {

                                    catch: {

                                        text: "Ok",

                                        value: "catch",

                                    },


                                },

                                icon: "success",

                                closeOnClickOutside: false,

                            },
                        ).then((value) => {

                            switch (value) {


                                case "catch":

                                    window.location.reload();

                                    break;


                            }

                        });
                    }

                }
            });
        }

 $(document).on("change", ".labelfinish", function (e) {
          $(this).parents('.productdetails').find('.labelfinish').val($(this).val());
            reset_print_input_buttons(this);

        });


        $(document).on("mouseover", ".dropdown-menu li a", function (e) {

            var selText = $(this).text();

            var orientation = $(this).attr('data-id');

            var woundoption = $('#woundoption').val();

            if (typeof orientation != 'undefined') {

                var imagepath = '<?=aalables_path?>images/categoryimages/winding/' + woundoption + '/' + orientation + '.png';

                $(this).find('img').attr('src', imagepath);

            }


        });
        
        
        
        function verify_labels_or_rolls_qty(id, tofollow=null) {
            var prdid = $(parent_selector).parents('.productdetails').find('.product_id').val();
            var labelspersheets = $(parent_selector).parents('.productdetails').find('.LabelsPerSheet').val();
            var minlabels = parseInt($(parent_selector).parents('.productdetails').find('.minimum_printed_labels').val());
            var minlabels = 100;
            var dieacross = min_rolls = parseInt($(parent_selector).parents('.productdetails').find('.minimum_quantities').val());
            var max_rolls_allowed = parseInt($(parent_selector).parents('.productdetails').find('.maximum_quantities').val());
            var min_qty = parseInt(min_rolls * minlabels);
            var min_qty = parseInt($(parent_selector).parents('.productdetails').find('.maximum_printed_labels').val());
            var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
            var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());
            var perroll = Math.ceil(parseFloat(total_labels / rolls));
            var max_labels_allowed = 1000000;
            /*if(tofollow == 1){*/
            //alert('rolls = '+rolls);
            $('#no_of_roll_custom_art').val(parseInt(rolls));
                if(rolls % 1 != 0){
                    //show_faded_popover('#no_of_roll_custom_art', "Number of rolls cannot be in decimal");
                    $('#no_of_roll_custom_art').val(parseInt(rolls));
                    //show_faded_popover('#nodesign'+id,'Number of designs cannot be in decimal');
                    return false;
                }
                var no_design = $('#no_design_pop').val();
                if($('#no_design_pop').val() % 1 != 0){
                    //show_faded_popover('#no_design_pop', "Number of designs cannot be in decimal");
                    $('#no_design_pop').val(parseInt(no_design));
                    //show_faded_popover('#nodesign'+id,'Number of designs cannot be in decimal');
                    return false;
                }
            /*}*/
            if (isFloat(perroll)) {
                perroll = Math.ceil(perroll);
            }
            //alert('perroll = '+perroll);
            //alert('total_labels = '+total_labels);
            var minroll = Math.ceil(100 / rolls); //34
            /*alert('rolls = '+rolls);
            alert('minroll = '+minroll);*/
            var per_rolls = minroll * rolls;
            var roll_text = 'roll';
            if (rolls > 1) {
                var roll_text = 'rolls';
            }
           /*alert('labelspersheets ='+labelspersheets);
            alert('per_rolls ='+per_rolls);//102
            alert('minlabels ='+minlabels);//100*/
           var labelspersheets1 = 0;
           if(rolls > max_rolls_allowed || total_labels>max_labels_allowed){
               if(rolls > max_rolls_allowed){
                   rolls = max_rolls_allowed;
               }
               if(total_labels >= max_labels_allowed){
                   total_labels = max_labels_allowed;
                   labelspersheets1 = Math.floor(total_labels / rolls);
               }else{
                   labelspersheets1 = Math.ceil(total_labels / rolls);
               }
               if(labelspersheets1 > labelspersheets){
                   labelspersheets = labelspersheets;
               }else{
                   labelspersheets = labelspersheets1;
               }
               //alert('1a');
               total_labels = labelspersheets * rolls;
               show_faded_popover(_this, "Quantity has been amended for production as " + rolls + " Rolls.");
               $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
               $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
               $(id).parents('.upload_row').find('.input_rolls').val(rolls);
               $(id).parents('.upload_row').find('.quantity_labels').text(rolls);
               return false;
           }
           /*alert('per_rolls = ' + per_rolls);
           alert('minlabels = ' + minlabels);*/
           if(tofollow == 1){
               if(total_labels < minlabels){
                   labelspersheets = Math.ceil(minlabels / rolls);
                   total_labels = labelspersheets * rolls;
                   show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                   $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                   $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                   $(id).parents('.upload_row').find('.input_rolls').val(rolls);
                   $(id).parents('.upload_row').find('.quantity_labels').text(rolls);
                   return false;
               }
           }
            if (!is_numeric(total_labels)) {
                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Please enter number of labels.");
                $(id).parents('.upload_row').find('.roll_labels_input').val('');
                return false;
            } else if (total_labels == 0) {
                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
                $(id).parents('.upload_row').find('.roll_labels_input').val('');
                return false;
            } else if (!is_numeric(rolls) || rolls == 0) {
                var _this = $(id).parents('.upload_row').find('.input_rolls');
                show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
                $(id).parents('.upload_row').find('.input_rolls').val('');
                return false;
            } else if (per_rolls < minlabels ) {
                /*alert(per_rolls);
                alert('minlabels = '+minlabels);*/
                //alert('per roll < minlabeks');
                var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');
                if (roll_input_display == 'block') {
                    //alert('if');
                    var requiredlabels = minlabels * rolls;
                    var total_labels = perroll * rolls;
                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                    if (total_labels < '100') {
                        var total_labels = '100';
                    }
                    /*pr_rol_lb = Math.ceil(minlabels / dieacross);
                    if (total_labels  < (pr_rol_lb * parseInt(rolls))) {
                        var total_labels = (pr_rol_lb * parseInt(rolls));
                    }*/
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    //alert('rollllllsssss = '+rolls);
                    $('#custom_qty_roll_' + prdid).val(rolls);
                    /*if (rolls % dieacross != 0) {
                        if (rolls % dieacross != 0) {
                            var multipyer = dieacross * parseInt(parseInt(rolls / dieacross) + 1);
                            $(id).parents('.upload_row').find('.input_rolls').val(multipyer);
                            $('#custom_qty_roll_' + prdid).val(multipyer);
                        }
                        show_faded_popover('#no_of_roll_custom_art', "Sorry! these labels are only available in sets of " + dieacross + " rolls. ");
                        return false;
                    }*/
                    //return false;
                } else {
                    if (total_labels > labelspersheets) { //10501 > 3500
                        //alert(total_labels);
                        //alert(labelspersheets);
                        //alert('else in if');
                        var expectedrolls = parseFloat(total_labels / labelspersheets);
                        if (isFloat(expectedrolls)) {
                            expectedrolls = Math.ceil(expectedrolls);
                        }
                        //alert('expectedrolls = '+expectedrolls);
                        if(expectedrolls > max_rolls_allowed){
                            if(total_labels >= max_labels_allowed){
                                total_labels = max_labels_allowed;
                                labelspersheets1 = Math.floor(total_labels / max_rolls_allowed);
                            }else{
                                labelspersheets1 = Math.ceil(total_labels / max_rolls_allowed);
                            }
                            //alert('2a');
                            if(labelspersheets1 > labelspersheets){
                                labelspersheets = labelspersheets;
                            }else{
                                labelspersheets = labelspersheets1;
                            }
                            show_faded_popover(_this, "Quantity has been amended for production as " + max_rolls_allowed + " Rolls.");
                            $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                            $(id).parents('.upload_row').find('.input_rolls').val(max_rolls_allowed);
                            $(id).parents('.upload_row').find('.quantity_labels').text(max_rolls_allowed);
                            return false;
                        }
                        labelspersheets = parseInt(total_labels / expectedrolls);
                        //alert('labelspersheets = '+labelspersheets);
                        var _this = $(id).parents('.upload_row').find('.input_rolls');
                        show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                        $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                        $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                        return false;
                    } else {
                        //alert('else in else');
                        if (total_labels < minlabels) {
                            total_labels = minlabels;
                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                        } else {
                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            var _thiss = $(id).parents('.upload_row').find('.quantity_labels');
                            $(_this).parents('.upload_row').find('.roll_labels_input').val(100);
                            show_faded_popover(_thiss, "Quantity has been amended for production as 1 Roll.");
                        }
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
                        $(id).parents('.upload_row').find('.quantity_labels').text(1);
                        $(id).parents('.upload_row').find('.input_rolls').val(1);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                        return false;
                    }
                }
            } else if (perroll > labelspersheets) {
                //alert('perroll = '+perroll);
                //alert('per roll > persheet');
                //var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
                var response = rolls_calculation(min_rolls, labelspersheets, total_labels, rolls);
                var total_labels = response['total_labels'];
                var expectedrolls = response['rolls'];
                if(expectedrolls > max_rolls_allowed){
                    if(total_labels >= max_labels_allowed){
                        total_labels = max_labels_allowed;
                        labelspersheets1 = Math.floor(total_labels / max_rolls_allowed);
                    }else{
                        labelspersheets1 = Math.ceil(total_labels / max_rolls_allowed);
                    }
                    if(labelspersheets1 > labelspersheets){
                        labelspersheets = labelspersheets;
                    }else{
                        labelspersheets = labelspersheets1;
                    }
                    //alert('3a');
                    total_labels = labelspersheets * max_rolls_allowed;
                    var infotxt = 'Quantity has been amended for production as ' + max_rolls_allowed + ' rolls and ' + total_labels + ' labels';
                    show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                    $(id).parents('.upload_row').find('.input_rolls').val(max_rolls_allowed);
                    $(id).parents('.upload_row').find('.quantity_labels').text(max_rolls_allowed);
                    return false;
                }
                var labelspersheets = parseInt(total_labels / expectedrolls);
                var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
                show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                return false;
            } else {
                //alert('4 A');
                var pr_rol_lb = 0;
                pr_rol_lb = Math.ceil(minlabels / dieacross);
                var total_labels = parseInt(perroll) * parseInt(rolls);
                //alert('total_labels = '+total_labels)
                if (total_labels < (pr_rol_lb * parseInt(rolls))) {
                    //var total_labels = '100';
                    var total_labels = (pr_rol_lb * parseInt(rolls));
                    //alert('total_labels hi = '+total_labels);
                }
                /*alert(rolls); //1
                alert(perroll);//45
                alert(pr_rol_lb);//17
                alert(minlabels);//100*/
                if (perroll <= pr_rol_lb) {
                    total_labels = pr_rol_lb * rolls;
                    //alert(pr_rol_lb+' '+rolls+' '+total_labels);
                    perroll = total_labels / rolls;
                }
                /*if(perroll <= labelspersheets){
                }*/
                /*alert('perroll = '+perroll);
                alert('total_labels = '+total_labels);*/
                /*if (rolls % dieacross != 0) {
                    if (rolls % dieacross != 0) {
                        var multipyer = dieacross * parseInt(parseInt(rolls / dieacross) + 1);
                        /!* if (multipyer > max_qty) {
                        multipyer = max_qty;
                        }*!/
                        //$('#no_of_roll_custom_art').val(multipyer);
                        $(id).parents('.upload_row').find('.input_rolls').val(multipyer);
                        $('#custom_qty_roll_' + prdid).val(multipyer);
                    }
                    show_faded_popover('#no_of_roll_custom_art', "Sorry! these labels are only available in sets of " + dieacross + " rolls. ");
                    return false;
                }*/
                //alert(perroll);
                //alert('rollllllsssss222 = '+rolls);
                $('#custom_qty_roll_' + prdid).val(rolls);
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
            }
            $(id).parents('.upload_row').find('.quantity_updater').hide();
        }

   
   
       function verify_labels_or_rolls_qty_old_2(id) {
       
            var prdid = $(parent_selector).parents('.productdetails').find('.product_id').val();
            var labelspersheets = $(parent_selector).parents('.productdetails').find('.LabelsPerSheet').val();
            var minlabels = parseInt($(parent_selector).parents('.productdetails').find('.minimum_printed_labels').val());
            var minlabels = 150;
            var dieacross = min_rolls = parseInt($(parent_selector).parents('.productdetails').find('.minimum_quantities').val());

            var min_qty = parseInt(min_rolls * minlabels);
            var min_qty = parseInt($(parent_selector).parents('.productdetails').find('.maximum_printed_labels').val());


            var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
            var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());

            var perroll = Math.ceil(parseFloat(total_labels / rolls));
            //alert(perroll);

            if (isFloat(perroll)) {
                perroll = Math.ceil(perroll);
            }

            var minroll = Math.round(150 / rolls);
            var per_rolls = minroll * rolls;
            var roll_text = 'roll';

            if (rolls > 1) {
                var roll_text = 'rolls';
            }

            //alert('per roll'+perroll+' - perRolls'+per_rolls);


            if (!is_numeric(total_labels)) {

                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Please enter number of labels.");
                $(id).parents('.upload_row').find('.roll_labels_input').val('');
                return false;
            } else if (total_labels == 0) {
                var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
                $(id).parents('.upload_row').find('.roll_labels_input').val('');
                return false;
            } else if (!is_numeric(rolls) || rolls == 0) {
                var _this = $(id).parents('.upload_row').find('.input_rolls');
                show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
                $(id).parents('.upload_row').find('.input_rolls').val('');
                return false;
            } else if (per_rolls < minlabels) {

                //alert(per_rolls);
                //alert(minlabels);
                //alert('per roll < minlabeks');

                var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');

                if (roll_input_display == 'block') {
                    //alert('if');
                    var requiredlabels = minlabels * rolls;
                    var total_labels = perroll * rolls;

                    var _this = $(id).parents('.upload_row').find('.roll_labels_input');


                    if (total_labels < '150') {
                        var total_labels = '150';
                    }

                    $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                    $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);


                    if (rolls % dieacross != 0) {

                        if (rolls % dieacross != 0) {
                            var multipyer = dieacross * parseInt(parseInt(rolls / dieacross) + 1);

                            $(id).parents('.upload_row').find('.input_rolls').val(multipyer);
                            $('#custom_qty_roll_' + prdid).val(multipyer);
                        }

                        show_faded_popover('#no_of_roll_custom_art', "Sorry! these labels are only available in sets of " + dieacross + " rolls. ");
                        return false;
                    }


                    //return false;


                } else {

                    if (total_labels > labelspersheets) {

                        //alert(total_labels);
                        //alert(labelspersheets);
                        //alert('else in if');

                        var expectedrolls = parseFloat(total_labels / labelspersheets);

                        if (isFloat(expectedrolls)) {
                            expectedrolls = Math.ceil(expectedrolls);
                        }

                        labelspersheets = parseInt(total_labels / expectedrolls);
                        var _this = $(id).parents('.upload_row').find('.input_rolls');
                        show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                        $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                        $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                        return false;
                    } else {
                        //alert('else in else');
                        if (total_labels < minlabels) {
                            total_labels = minlabels;
                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");
                        } else {
                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            var _thiss = $(id).parents('.upload_row').find('.quantity_labels');

                            $(_this).parents('.upload_row').find('.roll_labels_input').val(150);
                            show_faded_popover(_thiss, "Quantity has been amended for production as 1 Roll.");
                        }
                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);
                        $(id).parents('.upload_row').find('.quantity_labels').text(1);
                        $(id).parents('.upload_row').find('.input_rolls').val(1);
                        $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                        return false;
                    }
                }
            } else if (perroll > labelspersheets) {

                //alert('per roll > persheet');
                var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
                var total_labels = response['total_labels'];
                var expectedrolls = response['rolls'];
                var labelspersheets = parseInt(total_labels / expectedrolls);
                var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
                show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
                $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
                $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
                $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
                $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
                return false;

            } else {

                //alert('per roll > persheet Else');

                var total_labels = parseInt(perroll) * parseInt(rolls);
                if (total_labels < '150') {
                    var total_labels = '150';
                }

                var pr_rol_lb = 0;
                pr_rol_lb = minlabels / dieacross;

                if (perroll < pr_rol_lb) {
                    total_labels = pr_rol_lb * rolls;
                    perroll = total_labels / rolls;
                }

                if (rolls % dieacross != 0) {

                    if (rolls % dieacross != 0) {
                        var multipyer = dieacross * parseInt(parseInt(rolls / dieacross) + 1);
                        /* if (multipyer > max_qty) {
                        multipyer = max_qty;
                        }*/
                        //$('#no_of_roll_custom_art').val(multipyer);
                        $(id).parents('.upload_row').find('.input_rolls').val(multipyer);
                        $('#custom_qty_roll_' + prdid).val(multipyer);
                    }

                    show_faded_popover('#no_of_roll_custom_art', "Sorry! these labels are only available in sets of " + dieacross + " rolls. ");
                    return false;
                }

                $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
                $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
            }


            $(id).parents('.upload_row').find('.quantity_updater').hide();
        }
   
   
   function verify_labels_or_rolls_qty_old(id) {


        var prdid = $(parent_selector).parents('.productdetails').find('.product_id').val();

        var labelspersheets = $(parent_selector).parents('.productdetails').find('.LabelsPerSheet').val();

        var minlabels = parseInt($(parent_selector).parents('.productdetails').find('.minimum_printed_labels').val());
        var minlabels = 150;
            
            
        var dieacross = min_rolls = parseInt($(parent_selector).parents('.productdetails').find('.minimum_quantities').val());
        //alert(dieacross);
          
        var min_qty = parseInt(min_rolls * minlabels);
        var min_qty = parseInt($(parent_selector).parents('.productdetails').find('.maximum_printed_labels').val());


        var rolls = parseInt($(id).parents('.upload_row').find('.input_rolls').val());
        var total_labels = parseInt($(id).parents('.upload_row').find('.roll_labels_input').val());

            var perroll = parseFloat(total_labels / rolls);

            if (isFloat(perroll)) {
                perroll = Math.ceil(perroll);
            }

            var minroll =  Math.round(150/rolls) ;
            var per_rolls= minroll * rolls ;
            var roll_text = 'roll';

            if (rolls > 1) {
                var roll_text = 'rolls';
            }

          
         
          

            if (!is_numeric(total_labels)) {

              var _this = $(id).parents('.upload_row').find('.roll_labels_input');
              show_faded_popover(_this, "Please enter number of labels.");
              $(id).parents('.upload_row').find('.roll_labels_input').val('');
              return false;
            }

            else if (total_labels == 0) {
              var _this = $(id).parents('.upload_row').find('.roll_labels_input');
              show_faded_popover(_this, "Minimum Label quantity is " + minlabels + " Labels per roll.");
              $(id).parents('.upload_row').find('.roll_labels_input').val('');
              return false;
            }

            else if (!is_numeric(rolls) || rolls == 0) {
              var _this = $(id).parents('.upload_row').find('.input_rolls');
              show_faded_popover(_this, "Minimum roll quantity is 1 roll.");
              $(id).parents('.upload_row').find('.input_rolls').val('');
              return false;
            } 

        else if (per_rolls < minlabels) {
          //alert('per roll < minlabeks');

          var roll_input_display = $(id).parents('.upload_row').find('.input_rolls').css('display');

          if (roll_input_display == 'block') {
            
            var requiredlabels = minlabels * rolls;
            var totallabels = perroll * rolls;
             
            var _this = $(id).parents('.upload_row').find('.roll_labels_input');


            if(total_labels < '150'){
              var total_labels = '150';
            }
                     
            $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
            $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
            return false;


                } else {

                    if (total_labels > labelspersheets) {

                        var expectedrolls = parseFloat(total_labels / labelspersheets);

                        if (isFloat(expectedrolls)) {
                            expectedrolls = Math.ceil(expectedrolls);
                        }

                        labelspersheets = parseInt(total_labels / expectedrolls);


                        var _this = $(id).parents('.upload_row').find('.input_rolls');

                        show_faded_popover(_this, "Quantity has been amended for production as " + expectedrolls + " Rolls.");

                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);

                        $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);

                        $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);

                        return false;

                    }

                    else {

                        if (total_labels < minlabels) {

                            total_labels = minlabels;

                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');

                            show_faded_popover(_this, "Quantity has been amended for production as " + total_labels + " Labels.");

                        } else {

                            var _this = $(id).parents('.upload_row').find('.roll_labels_input');
                            var _thiss=$(id).parents('.upload_row').find('.quantity_labels');
                          
                            $(_this).parents('.upload_row').find('.roll_labels_input').val(150);
                            show_faded_popover(_thiss, "Quantity has been amended for production as 1 Roll.");

                        }

                        $(id).parents('.upload_row').find('.show_labels_per_roll').text(total_labels);

                        $(id).parents('.upload_row').find('.quantity_labels').text(1);

                        $(id).parents('.upload_row').find('.input_rolls').val(1);

                        $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);

                        return false;

                    }

                }


            }

            else if (perroll > labelspersheets) {
              
              //alert('per roll > persheet');
              var response = rolls_calculation(min_rolls, labelspersheets, total_labels, 0);
              var total_labels = response['total_labels'];
              var expectedrolls = response['rolls'];
              var labelspersheets = parseInt(total_labels / expectedrolls);
              var infotxt = 'Quantity has been amended for production as ' + expectedrolls + ' rolls and ' + total_labels + ' labels';
              show_faded_popover($(id).parents('.upload_row').find('.roll_labels_input'), infotxt);
              $(id).parents('.upload_row').find('.show_labels_per_roll').text(labelspersheets);
              $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
              $(id).parents('.upload_row').find('.input_rolls').val(expectedrolls);
              $(id).parents('.upload_row').find('.quantity_labels').text(expectedrolls);
              return false;

            } else {

              //alert('per roll > persheet Else');
              
              var total_labels = parseInt(perroll) * parseInt(rolls);
              if(total_labels < '150'){
                var total_labels = '150';
              }
              
              var pr_rol_lb = 0;
              pr_rol_lb = minlabels / dieacross;
               
              if(perroll < pr_rol_lb){
                total_labels = pr_rol_lb * rolls;
                perroll = total_labels / rolls;
              }
                
              if (rolls % dieacross != 0) {
    
                if(rolls % dieacross != 0) {
                  var multipyer = dieacross * parseInt(parseInt(rolls / dieacross) + 1);
                  /* if (multipyer > max_qty) {
                  multipyer = max_qty;
                  }*/
                  //$('#no_of_roll_custom_art').val(multipyer);
                  $(id).parents('.upload_row').find('.input_rolls').val(multipyer);
                  $('#custom_qty_roll_'+prdid).val(multipyer);
                }
    
                show_faded_popover('#no_of_roll_custom_art', "Sorry! these labels are only available in sets of " + dieacross + " rolls. ");
                return false;
              }

              $(id).parents('.upload_row').find('.show_labels_per_roll').text(perroll);
              $(id).parents('.upload_row').find('.roll_labels_input').val(total_labels);
            }
        
        

          $(id).parents('.upload_row').find('.quantity_updater').hide();
        }



        function rolls_calculation(die_across, max_labels, total_labels, rolls) {

            if (rolls == 0) {
                rolls = parseInt(die_across);
            } else {
                //rolls = parseInt(rolls) + parseInt(die_across);
                rolls = parseInt(rolls) + 1;
            }

            var per_roll = parseFloat(parseInt(total_labels) / rolls);

            if (per_roll > parseInt(max_labels)) {

                response = rolls_calculation(die_across, max_labels, total_labels, rolls);

                per_roll = response['per_roll'];

                rolls = response['rolls'];

            }


            var data = {per_roll: Math.ceil(per_roll), total_labels: Math.ceil(per_roll) * rolls, rolls: rolls};

            return data;

        }


        $(document).on("click", ".quantity_updater", function (e) {

            verify_labels_or_rolls_qty(this);

            $(this).parents('.upload_row').find('.quantity_updater').hide();

        });


        $(document).on("click", ".quantity_editor", function (e) {

            $(this).hide();

            $(this).parents('.upload_row').find('.quantity_labels').hide();

            $(this).parents('.upload_row').find('.input_rolls').show();

        });


        function isFloat(n) {

            return Number(n) === n && n % 1 !== 0;

        }


        $(document).on("click", ".price_breakss", function (e) {

            var product_id = $(this).parents('.productdetails').find('.product_id').val();

            var manfactureid = $(this).parents('.productdetails').find('.manfactureid').val();

            var labels = $(this).parents('.productdetails').find('.LabelsPerSheet').val();

            $('#ajax_price_breaks').html('');

            $('#price_loader').show();

            $.ajax({

                url: mainUrl + 'search/search/labels_price_breaks',

                type: "POST",

                async: "false",

                data: {mid: manfactureid, labels: labels, type: 'roll'},

                dataType: "html",

                success: function (data) {

                    if (!data == '') {

                        data = $.parseJSON(data);

                        setTimeout(function () {

                            $('#price_loader').hide();

                            $('#ajax_price_breaks').html(data.html);

                        }, 500);

                    }

                }

            });

        });


        $(document).on("click", ".technical_specs", function (e) {

            var id = $(this).parents('.productdetails').find('.product_id').val();

            $('#ajax_tecnial_specifiacation').html('');

            $('#mat_code').html('');

            $('#specs_loader').show();

            $.ajax({

                url: base + 'ajax/material_popup/' + id,

                type: "POST",

                async: "false",

                dataType: "html",

                success: function (data) {

                    if (!data == '') {

                        data = $.parseJSON(data);

                        $('#material_popup_img').attr('src', data.src);

                        setTimeout(function () {

                            $('#specs_loader').hide();

                            $('#ajax_tecnial_specifiacation').html(data.html);

                            $('#mat_code').html(data.mat_code);


                        }, 1000);

                    }

                }

            });

        });


        $(document).on("click", ".applications", function (e) {

            var groupname = $(this).attr('id');

            $('.ajax_application_chart').html('');

            $('#app_group_name').html('');

            $('#lb_applications_loader').show();

            $.ajax({

                url: base + 'ajax/application_popup/',

                type: "POST",

                async: "false",

                dataType: "html",

                data: {'groupname': groupname, type: 'rolls'},

                success: function (data) {

                    if (!data == '') {

                        data = $.parseJSON(data);

                        setTimeout(function () {

                            $('#lb_applications_loader').hide();

                            $('.ajax_application_chart').html(data.html);

                            $('#app_group_name').html(data.group_name);

                            $("b.popup-title").html(data.group_name);

                        }, 500);

                    }

                }

            });


        });

        $(document).on("change", "#woundoption", function (e) {

            val = $(this).val();

            if (val != '') {

                if (val == 'Inside') {

                    $('.insideorientation').show();

                    $('.outsideorientation').hide();

                    $('.productdetails').find('.orientationselector').html(' Orientation 05 <i class="fa fa-unsorted"></i>');

                    $('.orientation').val(5);

                } else {

                    $('.insideorientation').hide();

                    $('.outsideorientation').show();

                    $('.productdetails').find('.orientationselector').html(' Orientation 01 <i class="fa fa-unsorted"></i>');

                    $('.orientation').val(1);

                }

                var material_code = $("#material_code_new").val() + $("#coresize").val().replace(/[^0-9]/, "");


                $('#prod_img').html('<img src="<?=aalables_path?>images/loader.gif" width="139" height="29" class="image" style="width:139px; height:29px; ">');

                request = $.ajax({

                    url: mainUrl+'search/Search/setwoundoption',

                    type: "POST",

                    async: "false",

                    dataType: "html",

                    data: {option: val, cate: '<?=$subcat?>',},

                    success: function (data) {

                        if (val == 'Inside') {

                            setTimeout(function () {

                                /*$('#prod_img').html('<img id="wound_image" src ="<?=aalables_path?>images/categoryimages/inner_roll/<?=$imagename?>">');

								$('#material_popup_img').attr("src","<?=aalables_path?>images/categoryimages/inner_roll/<?=$imagename?>");*/


                                $('#prod_img').html('<img id="wound_image" src="<?=aalables_path?>images/categoryimages/RollLabels/inside/<?=ltrim($details['DieCode'], "1-")?>' + material_code + '.jpg">');


                                $('#material_popup_img').attr("src", "<?=aalables_path?>images/categoryimages/RollLabels/inside/<?=ltrim($details['DieCode'], "1-")?>" + material_code + ".jpg");


                            }, 1000);


                        } else {

                            setTimeout(function () {

                                /*$('#prod_img').html('<img id="wound_image" src ="<?=aalables_path?>images/categoryimages/roll_desc/<?=$imagename?>">');

								$('#material_popup_img').attr("src","<?=aalables_path?>images/categoryimages/roll_desc/<?=$imagename?>");

								*/

                                $('#prod_img').html('<img id="wound_image" src ="<?=aalables_path?>images/categoryimages/RollLabels/outside/<?=ltrim($details['DieCode'], "1-")?>' + material_code + '.jpg">');


                                $('#material_popup_img').attr("src", "<?=aalables_path?>images/categoryimages/RollLabels/outside/<?=ltrim($details['DieCode'], "1-")?>" + material_code + ".jpg");


                            }, 1000);


                        }

                        update_wound_images(val);

                    }

                });

            }

        });


        /************* Label Finder **********/

        var contentbox = $('#ajax_labelfilter');


        $(document).ready(function () {

            check_core_selected();

            $('[data-toggle="popover"]').popover();

            $('[data-toggle="tooltip-digital"]').tooltip();

            $("[data-toggle=tooltip-orintation]").tooltip();

            $("[data-toggle=tooltip-product]").tooltip();

        });

        $('.coresize_popup ').on('hidden.bs.modal', function (event) {

            check_core_selected();

        });



        function fireRemarketingTag(page) {

            <? if(SITE_MODE == 'live'){?>

            dataLayer.push({'event': 'fireRemarketingTag', 'ecomm_pagetype': page});

            <? } ?>

        }

        function update_wound_images(wound_option) {

            if (wound_option == "Outside") {

                var path = "<?=aalables_path?>images/categoryimages/RollLabels/outside";

            }

            else {

                var path = "<?=aalables_path?>images/categoryimages/RollLabels/inside";

            }


            $("[data-reset='reset']").each(function (index, element) {

                var img = $(this).find(".product_material_image").attr("src");

                if (img.match('/RollLabels/')) {

                    if (wound_option == "Outside") {

                        img = img.replace('inside', 'outside');

                        console.log("outside select: " + img);

                    }

                    else if (wound_option == "Inside") {

                        img = img.replace('outside', 'inside');

                        console.log("inside select: " + img);

                    }

                    $(this).find(".product_material_image").attr("src", img);

                }

            });


        }


        $(document).ready(function () {

            //$(".product_material_image").aaZoom();

            $('[data-toggle="tooltip"]').tooltip();
            $(".product_material_image").hover(function (e) {

                var value = $(this).aaZoom();

            });

            $('.product_material_image').aaZoom();

        });


        function ecommerce_add_to_cart(_this, type) {

            <? if(SITE_MODE == 'livefffff'){ ?>



            var prdid = $(_this).parents('.productdetails').find('.product_id').val();

            //var product_name =  $(_this).parents('.productdetails').find('.product_name').text();

            var product_name = $(_this).parents('.productdetails').find('.category_description').val();

            var category = 'Roll Labels';


            if (type == 'printed') {

                var input_id = $(_this).parents('.productdetails').find('.printlabels');

                var quantity = parseInt(input_id.val());

                var price = $(_this).parents('.productdetails').find('.printedprice_text').find('.color-orange').text();

                var category = " Printed - " + category;

                var price = price.replace(/[^\d.]/g, '');


            }

            else if (type == 'sample') {

                var price = 0.00;

                var category = 'Sample Roll Labels'

                var quantity = 1

            }

            else {

                var input_roll = $(_this).parents('.productdetails').find('.plainrolls');

                var quantity = parseInt(input_roll.val());

                var price = $(_this).parents('.productdetails').find('.plainprice_text').find('.color-orange').text();

                var price = price.replace(/[^\d.]/g, '');

            }


            price = parseFloat(price);


            dataLayer.push({

                'event': 'addToCart',

                'ecommerce': {

                    'add': {

                        'products': [{

                            'name': product_name,

                            'id': prdid,

                            'price': price,

                            'brand': 'AALABELS',

                            'category': category,

                            'quantity': quantity,

                        }]

                    }

                }

            });

            <? } ?>

        }


        function check_core_selected() {

            var coresize = $("#coresize").val();

            if (coresize == '') {

                $('.popover').hide();

                setTimeout(function () {

                    $(".artworkModal1").modal('hide');

                }, 50);

                $(".coresize_popup").modal('show');

            }

            else {

                $("#coresize").css("border", "1px solid #a9a9a9");

                return true;

            }

        }


        $(document).on("mouseover", ".coresize_dropdownmenu li a", function (e) {

            e.preventDefault();

            var catid = '<?=$details['CategoryID']?>'

            var selText = $(this).text();

            var coresize = $(this).data('id');

            var imagepath = '<?=aalables_path?>images/categoryimages/RollCoreImages/' + catid + coresize + '.png';

            $(this).find('img').attr('src', imagepath);

        });

        $(document).on("click", ".coresize_dropdownmenu li a", function (e) {
            e.preventDefault();
            var selText = $(this).text();
            var coresize = $(this).data('id');
            $("#coresize").val(coresize);
            var mate_code = 'WTP';
            var die = $.trim($("span.pr-code").text());
            coresize = coresize.replace(/\D/g, '');
            die += mate_code + coresize;
            var img_src = "<?=aalables_path?>images/categoryimages/RollLabels/outside/" + die + ".jpg";
            $('.popup_coreimage').attr('src', img_src);
            $('.confirm_coresize').removeClass("disabled");
            $(this).parents('.dm-selector').find('.dropdown-toggle').html(selText + ' <i class="fa fa-unsorted"></i>');
        });

        $(document).on("click", ".productdetails .dm-selector a, select[name='finish']", function (e) {
            if (!check_core_selected()) {
                return false;
            }
        });




        $(document).on("click focus change", "#material_mat,#color_mat,#adhesive_mat,#woundoption", function (e) {

            if (!check_core_selected()) {

                return false;

            }

        });


      $(document).on("mouseenter", ".productdetails .colourpicker", function (e) {

        var colour = $(this).attr('data-value');
        $(this).parents('.productdetails').find("[data-toggle=tooltip]").tooltip();
      });

    </script>
