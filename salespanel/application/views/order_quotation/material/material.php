<?php
$filter_class = "";
$SpecText7 = "";
?>
<?

//$details['is_euro'] = 'Y';

$popup_margin = '';

$x = explode("-", $details['CategoryName']);

$catname = $x[0];

$code = explode('.', $details['CategoryImage']);


$newcatname = explode("-", $details['CategoryName']);

$heading = $newcatname[0];

if ($details['Shape_upd'] == "Circular") {

    $LabelSize = str_replace("Label Size:", "", $details['specification3']);

} else {

    if ($details['is_euro'] == 'Y') {

        $LabelSize = $details['LabelWidth'] . " x " . $details['LabelHeight'];

    } else {

        $LabelSize = " Width " . $details['LabelWidth'] . "&nbsp;&nbsp; x &nbsp;Height&nbsp; " . $details['LabelHeight'];

    }

}

if (preg_match("/SRA3/", $details['CategoryName'])) {

    $Paper_size = "SRA3 Sheets";

    $img_src = aalables_path . "images/categoryimages/SRA3Sheets/colours/" . $materials[0]->ManufactureID . ".png";

    if (!file_exists($img_src)) {

        $img_src = aalables_path . "images/categoryimages/SRA3Sheets/" . $details['CategoryImage'];

    }

    $width = '220';

    $height = 'auto';

    $pop_width = '200';

    $box_height = 'min-height:325px;';

    $popup_margin = 'margin:6px auto !important;';
    $type = "SRA3";

} else if (preg_match("/A3/", $details['CategoryName'])) {

    $Paper_size = "A3 Sheets";


    $img_src = aalables_path . "images/categoryimages/A3Sheets/colours/" . $materials[0]->ManufactureID . ".png";

    if (!file_exists($img_src)) {
        $img_src = aalables_path . "images/categoryimages/A3Sheets/" . $details['CategoryImage'];
    }


    $width = '220';

    $height = 'auto';

    $box_height = 'min-height:325px;';

    $pop_width = '200';

    $popup_margin = 'margin:6px auto !important;';
    $type = "A3";

}  else if (false !== strpos($details['CategoryName'], "A5")) {

    $Paper_size = "A5 Sheets";

    $img_src = aalables_path . "images/categoryimages/A5Sheets/colours/" . $materials[0]->ManufactureID . ".png";

    if (!file_exists($img_src)) {
        $img_src = aalables_path . "images/categoryimages/A5Sheets/" . $details['CategoryImage'];
    }


    $width = '189';

    $height = 'auto';

    $box_height = '';

    $pop_width = '220';

    $type = "A5";

 } else {

    $Paper_size = "A4 Sheets";

    $img_src = aalables_path . "images/categoryimages/A4Sheets/colours/" . $materials[0]->ManufactureID . ".png";


    if (!file_exists($img_src)) {

        $img_src = aalables_path . "images/categoryimages/A4Sheets/" . $details['CategoryImage'];

    }

    $width = '189';

    $height = '267';

    $box_height = '';

    $pop_width = '189';

    $type = "A4";

}

$productid = $this->home_model->get_db_column('products', 'ProductID', 'CategoryID', $details['CategoryID']);

?>

<input type="hidden" value="<?= $Paper_size ?>" id="papersize"/>
<input type="hidden" id="hiddenCartId" value="<?= $details['CategoryID'] ?>">
<div class="">
<div id="ajax_labelfilter">
  <div class="" style="margin: 0px -10px;">
    <div class="mat-sep-2017">
      <?php
                if ($details['is_euro'] == 'Y'):?>
      <div class="selected-product">
        <?php
                        $class1 = "col-lg-2 col-md-2 col-sm-3 col-xs-3";
                        $class2 = "col-lg-10 col-md-10 col-sm-9";
                        if ($type == "A3" || $type == "SRA3") {
                            $class1 = "col-lg-3 col-md-3 col-sm-3 col-xs-3";
                            $class2 = "col-lg-9 col-md-9 col-sm-9 col-xs-9";
                        }
                        ?>
        <div class="row">
          <div class="<?= $class1 ?> pr-thumb"> <img src="<?= $img_src ?>" alt="<?= $catname ?>"
                                     title="<?= $catname ?>"> </div>
          <div class="<?= $class2 ?>">
            <div class="row flexcontainer">
              <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h2 class="pr-title">
                  <?= $heading ?>
                </h2>
                <div class="pr-detail">
                  <table class="pr-table">
                    <tr>
                      <td><b>Product Code:
                        <?= ltrim($details['DieCode'], "1-") ?>
                        </b></td>
                      <td><b>Label Size: </b>
                        <?= $LabelSize ?></td>
                      <td><a role="button" data-target=".layout" data-toggle="modal"> View
                        Full Specification</a></td>
                    </tr>
                  </table>
                  <?php
                                            if ($type != "A3" and $type != "SRA3"):?>
                  <p class="<?= ($compitable) ? '' : 'av-comp' ?> "><b>Compatible with
                    Avery&reg; templates:</b>
                    <?= str_replace(",", ", ", $compitable) ?>
                  </p>
                  <?php endif;
                                            $matcode = $this->home_model->getmaterialcode($materials[0]->ManufactureID);
                                            $thumbnail = Assets . "images/categoryimages/A4Sheets/euro_edges/" . $matcode . ".png";
                                            ?>
                  <div class="desktop_euro_div hidden-xs"> <img src="<?= $thumbnail ?>" alt="Dry Edge" style="margin-top: -5px;"
                                                     class="euro_thumbnail pull-left"/>
                    <p class="euro_text_top">Our innovative dry-edge label sheets, have a
                      small 1mm strip of label material and adhesive removed from around
                      the edge of the sheet, <a href="javascript:void(0)" data-toggle="tooltip"
                                                       title="Our innovative dry-edge label sheets, have a small 1mm strip of label material and adhesive removed from around the edge of the sheet, exposing the release liner and backing paper, creating a dry area that prevents problems associated with adhesive deposits on printer rollers. Enabling faster, problem free printing of sheet labels.">Read
                      more</a></p>
                    <div class="req-links">
                      <div class="row">
                        <div class="col-xs-4 col-sm-3 text-left download-icons"> <a target="_blank" rel="nofollow" data-toggle="tooltip"
                                                               title="Download PDF Template"
                                                               href="<?php echo base_url(); ?>download/pdf/<?=$details['pdfFile']; ?>"
                                                               role="button"> <img src="<?php echo base_url(); ?>theme/site/images/pdf-icon.png"
                                                                     alt="PDF Icon"></a> <a target="_blank" data-toggle="tooltip" title="Download Word Template" rel="nofollw"                                        href="<?php echo base_url(); ?>theme/site/images/office/word/<?=$details['WordDoc']; ?>" role="button"> <img src="<?php echo base_url(); ?>theme/site/images/word-icon.png"
                                                                     alt="MS Word Icon"> </a>

                        </div>
                        <!--<div class="col-xs-8 col-sm-9 printer_top_div">
                                                            <?php
                                                            $spec = $this->home_model->get_db_column('products', 'SpecText7', 'ProductID', $productid);
                                                            $compatibility = $this->filter_model->get_compatibility_text('sheet');
                                                            $print_compatible_array = array();
                                                            foreach ($compatibility as $com) {
                                                                $com->print_method = str_replace(" ", "", trim($com->print_method));
                                                                $com->type = str_replace(" ", "", trim($com->type));
                                                                $print_compatible_array[$com->print_method][$com->type] = $com->description;
                                                            }
                                                            $comp = $this->filter_model->grouping_compatiblity($spec, $print_compatible_array);
                                                            ?>
                                                            <div class="comp">
                                                                <table class="table printer" border="0"
                                                                       style="border:none;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="left" valign="center"
                                                                            style="font-size:12px; border:none;vertical-align: bottom;width:25%;">
                                                                            <small style="margin-top:10px;font-size:12px;">
                                                                                Printer<br/>
                                                                                Compatibility
                                                                            </small>
                                                                        </td>
                                                                        <td align="left"
                                                                            style="font-size:12px; border:none; width:25%;">
                                                                            Laser <img class="laser_printer_img"
                                                                                       width="50"
                                                                                       src="<?= Assets ?>images/<?= $comp['laser_img'] ?>"/><a
                                                                                    data-toggle="tooltip-product"
                                                                                    data-placement="top"
                                                                                    class="laser_printer_div" title=""
                                                                                    data-original-title="<?= $comp['laser_text'] ?>"
                                                                                    href="javascript:void(0);"><i
                                                                                        class="fa fa-info-circle"></i></a>
                                                                        </td>
                                                                        <td align="left"
                                                                            style=" font-size:12px;border:none;width:25%;">
                                                                            Inkjet <img class="inkjet_printer_img"
                                                                                        width="50"
                                                                                        src="<?= Assets ?>images/<?= $comp['inkjet_img'] ?>"/><a
                                                                                    data-toggle="tooltip-product"
                                                                                    data-placement="top" title=""
                                                                                    class="inkjet_printer_div"
                                                                                    data-original-title="<?= $comp['inkjet_text'] ?>"
                                                                                    href="javascript:void(0);"><i
                                                                                        class="fa fa-info-circle"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 hidden-sm hidden-xs text-center why-seal"><img
                                                class="img-responsive" src="<?= Assets ?>images/30-icon.png"
                                                alt="30 Days Moneyback Guarantee">
                <div class="title m-t-10"><a href="javascript:void(0);" data-toggle="popover"
                                                                     data-trigger="hover" data-placement="top"
                                                                     data-html="true"
                                                                     data-content="<div class='col-lg-12 col-md-12 frc-banner'><div class='title'> FAST, RELIABLE &amp; COST EFFECTIVE </div><ul><li>Over 80% of orders despatched same day</li><li>Daily despatch and delivery</li><li>Add the “Next Day” option to your order</li><li>If you need labels quicker, add a PRE 10:30 or 12:00 option for even faster delivery.</li><li>1,000’s of satisfied customers.</li><li>  <img src='<?= Assets ?>images/iso_14001.png'> ISO9001 Certified</li><li><img src='<?= Assets ?>images/iso_9001.png'> ISO14001 Certified</li> </ul></div>">Why
                  Buy from AA Labels? <i class="fa fa-info-circle"></i></a></div>
              </div>
            </div>
          </div>
        </div>
        <? if ($filter != 'disabled' and $this->agent->is_mobile()) { ?>
        <div class="row">
          <?php
                                if ($type == "A4") {
                                    $button_class = "";
                                    $filter_class = "col-lg-11 col-md-11 col-sm-11 col-xs-12";
                                } else {
                                    $button_class = "hide";
                                    $filter_class = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                }
                                ?>

          <div class="labels-form hidden-lg hidden-md hidden-sm <?= $button_class ?>"
                                     style="margin-bottom:10px;"><a href="javascript:void(0);"
                                                                    class="btn orangeBg btn-block promotion-styles"
                                                                    onclick="fetch_special_offers();">View Special Offer <i class="fa fa-gift"></i></a> </div>
          <div class="row sort-filters hidden-lg hidden-md hidden-sm">
            <div class="<?= $filter_class ?>">
              <div class="row">
                <div class=" labels-form col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
              <div>
                <button onclick="window.location.reload();" class="btn btn-block orangeBg"
                                                    role="button"><i class="fa fa-refresh"></i></button>
              </div>
            </div>
          </div>
        </div>
        <? } ?>
        <? if ($filter != 'disabled' and !isset($othermaterials) and 1==2) { ?>
        <div class="row sort-filters hidden-xs">
          <?php
                                if ($type == "A4") {
                                    $button_class = "";
                                    $filter_class = "col-lg-9 col-md-9 col-sm-9 col-xs-12";
                                } else {
                                    $button_class = "hide";
                                    $filter_class = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                }
                                ?>
          <div class="labels-form col-lg-2 col-md-2 col-sm-3 col-xs-12 <?= $button_class ?>"><a
                                            href="javascript:void(0);" class="btn orangeBg btn-block promotion-styles"
                                            onclick="fetch_special_offers();">View Special Offer <i
                                                class="fa fa-gift"></i></a></div>
          <div class="<?= $filter_class ?>">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="row">
                <div class=" labels-form col-lg-4 col-md-4 col-sm-4 col-xs-4">
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
        <? } ?>
        <?php if ($compitable): ?>
        <div class="row">
          <div class="col-md-12">
            <p class="m-t-b-8"> <small><strong>Disclaimer: </strong>AALabels products are not made or endorsed
              by Avery®. Avery® is a trademark of CCL Industries Inc., registered in the
              UK and other countries. References to Avery® are solely used to indicate
              compatibility for label sizes and templates. </small> </p>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php else: ?>
      <div class="selected-product">
        <?php
                    $class1 = "col-lg-2 col-md-2 col-sm-3 col-xs-3";
                    $class2 = "col-lg-10 col-md-10 col-sm-9";
                    if ($type == "A3" || $type == "SRA3") {
                        $class1 = "col-lg-3 col-md-3 col-sm-3 col-xs-3";
                        $class2 = "col-lg-9 col-md-9 col-sm-9";
                    }
                    ?>
        <div class="row">
          <div class="<?= $class1 ?> pr-thumb"> <img src="<?= $img_src ?>" alt="<?= $catname ?>" title="<?= $catname ?>"> </div>
          <div class="<?= $class2 ?>">
            <div class="row flexcontainer">
              <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h2 class="pr-title">
                  <?= $heading ?>
                </h2>
                <div class="pr-detail">
                  <p><b>Product Code: <span class="pr-code">
                    <?= ltrim($details['DieCode'], "1-") ?>
                    </span></b></p>
                  <p><b>Label Size:</b>
                    <?= $LabelSize ?>
                  </p>
                  <p><a role="button" data-target=".layout" data-toggle="modal"> View Label
                    Layout</a></p>
                  <?php
                                        if ($type != "A3" and $type != "SRA3" and $compitable != ''):?>
                  <p class="<?= ($compitable) ? '' : 'av-comp' ?> "><b>Compatible with
                    Avery&reg; templates:</b>
                    <?= str_replace(",", ", ", $compitable) ?>
                  </p>
                  <?php endif; ?>
                  <div class="req-links">
                    <div class="row">
                      <div class="col-xs-12 text-left download-icons"><a rel="nofollow"
                                                                                                   target="_blank"
                                                                                                   data-toggle="tooltip"
                                                                                                   title="Download PDF Template"
                                                                                                   href="<?php echo base_liveaa; ?>download/pdf/<?=$details['pdfFile']; ?>"
                                                                                                   role="button"> <img src="<?php echo base_liveaa; ?>theme/site/images/pdf-icon.png"
                                                             alt="PDF Icon"> </a> <a
                                                            data-toggle="tooltip" target="_blank"
                                                            title="Download Word Template" rel="nofollw"
                                                            href="<?php echo base_liveaa; ?>theme/site/images/office/word/<?=$details['WordDoc']; ?>"
                                                            role="button"> <img src="<?php echo base_liveaa; ?>theme/site/images/word-icon.png"
                                                             alt="MS Word Icon"> </a>
                        <?php if (preg_match("/A4/", $details['CategoryName'])){?>

                        <?php }?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 hidden-sm hidden-xs text-center why-seal"> <img class="img-responsive"
                                         src="<?php echo base_url(); ?>theme/site/images/30-icon.png"
                                         alt="30 Days Moneyback Guarantee">
                <div class="title m-t-10"><a href="javascript:void(0);" data-toggle="popover"
                                                                 data-trigger="hover" data-placement="top"
                                                                 data-html="true"
                                                                 data-content="<div class='col-lg-12 col-md-12 frc-banner'><div class='title'> FAST, RELIABLE &amp; COST EFFECTIVE </div><ul><li>Over 80% of orders despatched same day</li><li>Daily despatch and delivery</li><li>Add the “Next Day” option to your order</li><li>If you need labels quicker, add a PRE 10:30 or 12:00 option for even faster delivery.</li><li>1,000’s of satisfied customers.</li><li>  <img src='<?= Assets ?>images/iso_14001.png'> ISO9001 Certified</li><li><img src='<?= Assets ?>images/iso_9001.png'> ISO14001 Certified</li> </ul></div>">Why
                  Buy from AA Labels? <i class="fa fa-info-circle"></i></a></div>
              </div>
            </div>
          </div>
        </div>
        <?php if ($compitable): ?>
        <div class="row">
          <div class="col-md-12">
            <p class="m-t-b-8"> <small><strong>Disclaimer: </strong>AALabels products are not made or endorsed
              by Avery®. Avery® is a trademark of CCL Industries Inc., registered in the
              UK and other countries. References to Avery® are solely used to indicate
              compatibility for label sizes and templates. </small> </p>
          </div>
        </div>
        <?php endif; ?>

        <!--  <div class="row sort-filters hidden-lg hidden-md hidden-sm">
                        <div class="<? /*= $filter_class */ ?>">
                            <div class="row new_filter">
                                <div class="new_filter_dropdown">
                                    <div class="labels-form col-lg-7 col-md-7 col-sm-6 col-xs-6">
                                        <input name="material_mat" type="hidden" id="material_mat"
                                               class="fetch_category_mateials" value=""/>
                                        <input name="color_mat" type="hidden" id="color_mat"
                                               class="fetch_category_mateials" value=""/>
                                        <input name="adhesive_mat" type="hidden" id="adhesive_mat"
                                               class="fetch_category_mateials" value=""/>
                                        <div class="btn-group btn-block dm-selector material-d-down"><a
                                                    class="btn btn-default btn-block dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="true">Sort By Material <i
                                                        class="fa fa-unsorted"></i></a>
                                            <ul class="dropdown-menu btn-block" style="top: 100%;">
                                                <li class=""><a data-value="reset" data-id="material">Sort By
                                                        Material</a></li>
                                                <? /* foreach ($paper as $paper_list) { */ ?>
                                                    <li class=""><a data-id="material"
                                                                    data-value="<? /*= $paper_list->Material */ ?>">
                                                            <? /*= $paper_list->Material */ ?>
                                                            <small>(<? /*= $paper_list->count */ ?>)</small>
                                                            <br/>
                                                            <small>
                                                                <? /*= $paper_list->SpecText7 */ ?>
                                                            </small>
                                                        </a></li>
                                                <? /* } */ ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="labels-form col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="btn-group btn-block dm-selector color-d-down"><a
                                                    class="btn btn-default btn-block dropdown-toggle disabled"
                                                    data-toggle="dropdown" aria-expanded="true">Sort By Colour <i
                                                        class="fa fa-unsorted"></i></a>
                                            <ul class="dropdown-menu btn-block" style="top: 100%;">
                                                <li class=""><a data-value="reset" data-id="color">Sort By Colour</a>
                                                </li>
                                                <? /* foreach ($color as $color_list) { */ ?>
                                                    <li class=""><a data-id="color"
                                                                    data-value="<? /*= $color_list->Color */ ?>">
                                                            <? /*= $color_list->Color */ ?>
                                                            -
                                                            <small>
                                                                <? /*= $color_list->SpecText7 */ ?>
                                                            </small>
                                                            <br/>
                                                            <small>
                                                                <? /*= $color_list->adhesive */ ?>
                                                            </small>
                                                        </a></li>
                                                <? /* } */ ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <div>
                                <button onclick="window.location.reload();" class="btn btn-block orangeBg"
                                        role="button"><i class="fa fa-refresh"></i></button>
                            </div>
                        </div>
                    </div>-->

        <?php endif; ?>
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
            <div class="colors_data mat-ch append_search ajax_material_mat"
                                 id="<?= (isset($othermaterials) and $othermaterials != '') ? '' : '/*ajax_material_sorting*/' ?>">
              <? if (isset($othermaterials) and $othermaterials != '') {
                                    $single_product = 'active';
                                }
                                include('material_list_view_a4.php'); ?>
            </div>
          </div>
        </div>
        <?

                    if (isset($othermaterials) and $othermaterials != ''){

                    $single_product = '';

                    $materials = $othermaterials;

                    ?>
        <div class="other_materials">
          <div class="sort-filters filterBg p-l-r-10">
            <div class="row">
              <div class="col-md-2">
                <h4 class="hide_title">Other Materials </h4>
              </div>
              <!--                                <div class="col-md-10 hidden-xs">-->
              <!--                                    -->
              <?// if ($filter != 'disabled' and !$this->agent->is_mobile()) { ?>
              <!--                                        <div class="row">-->
              <!--                                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">-->
              <!--                                                <div class="row">-->
              <!--                                                    -->
              <?php
//                                                    if ($type == "A4") {
//                                                        $button_class = "invisible";
//                                                        $filter_class = "col-lg-9 col-md-9 col-sm-9 col-xs-12";
//                                                    } else {
//                                                        $button_class = "invisible";
//                                                        $filter_class = "col-lg-9 col-md-9 col-sm-9 col-xs-12";
//                                                    }
//                                                    ?>
              <!--                                                    <div class="labels-form col-lg-3 col-md-3 col-sm-3 col-xs-3 -->
              <?//= $button_class ?>
              <!--">-->
              <!--                                                        <a href="javascript:void(0);"-->
              <!--                                                           class="btn orangeBg btn-block promotion-styles"-->
              <!--                                                           onclick="fetch_special_offers();">View Special Offer <i-->
              <!--                                                                    class="fa fa-gift"></i></a></div>-->
              <!--                                                    <div class="-->
              <?//= $filter_class ?>
              <!--">-->
              <!--                                                        <div class="row new_filter">-->
              <!--                                                            <div class="new_filter_dropdown">-->
              <!--                                                                <div class="labels-form col-lg-6 col-md-6 col-sm-6 col-xs-4">-->
              <!--                                                                    <input name="material_mat" type="hidden"-->
              <!--                                                                           id="material_mat"-->
              <!--                                                                           class="fetch_category_mateials" value=""/>-->
              <!--                                                                    <input name="color_mat" type="hidden" id="color_mat"-->
              <!--                                                                           class="fetch_category_mateials" value=""/>-->
              <!--                                                                    <input name="adhesive_mat" type="hidden"-->
              <!--                                                                           id="adhesive_mat"-->
              <!--                                                                           class="fetch_category_mateials" value=""/>-->
              <!--                                                                    <div class="btn-group btn-block dm-selector material-d-down">-->
              <!--                                                                        <a class="btn btn-default btn-block dropdown-toggle"-->
              <!--                                                                           data-toggle="dropdown" aria-expanded="true">Sort-->
              <!--                                                                            By Material <i-->
              <!--                                                                                    class="fa fa-unsorted"></i></a>-->
              <!--                                                                        <ul class="dropdown-menu btn-block"-->
              <!--                                                                            style="top: 100%;">-->
              <!--                                                                            <li class=""><a data-value="reset"-->
              <!--                                                                                            data-id="material">Sort By-->
              <!--                                                                                    Material</a></li>-->
              <!--                                                                            -->
              <?// foreach ($paper as $paper_list) { ?>
              <!--                                                                                <li class=""><a data-id="material"-->
              <!--                                                                                                data-value="-->
              <?//= $paper_list->Material ?>
              <!--">-->
              <!--                                                                                        -->
              <?//= $paper_list->Material ?>
              <!--                                                                                        <small>-->
              <!--                                                                                            (-->
              <?//= $paper_list->count ?>
              <!--)-->
              <!--                                                                                        </small>-->
              <!--                                                                                        <br/>-->
              <!--                                                                                        <small>-->
              <!--                                                                                            -->
              <?//= $paper_list->SpecText7 ?>
              <!--                                                                                        </small>-->
              <!--                                                                                    </a></li>-->
              <!--                                                                            -->
              <?// } ?>
              <!--                                                                        </ul>-->
              <!--                                                                    </div>-->
              <!--                                                                </div>-->
              <!--                                                                <div class="labels-form col-lg-6 col-md-6 col-sm-6 col-xs-4">-->
              <!--                                                                    <div class="btn-group btn-block dm-selector color-d-down">-->
              <!--                                                                        <a class="btn btn-default btn-block dropdown-toggle disabled"-->
              <!--                                                                           data-toggle="dropdown" aria-expanded="true">Sort-->
              <!--                                                                            By Colour <i class="fa fa-unsorted"></i></a>-->
              <!--                                                                        <ul class="dropdown-menu btn-block"-->
              <!--                                                                            style="top: 100%;">-->
              <!--                                                                            <li class=""><a data-value="reset"-->
              <!--                                                                                            data-id="color">Sort By-->
              <!--                                                                                    Colour</a></li>-->
              <!--                                                                            -->
              <?// foreach ($color as $color_list) { ?>
              <!--                                                                                <li class=""><a data-id="color"-->
              <!--                                                                                                data-value="-->
              <?//= $color_list->Color ?>
              <!--">-->
              <!--                                                                                        -->
              <?//= $color_list->Color ?>
              <!--                                                                                        --->
              <!--                                                                                        <small>-->
              <!--                                                                                            -->
              <?//= $color_list->SpecText7 ?>
              <!--                                                                                        </small>-->
              <!--                                                                                        <br/>-->
              <!--                                                                                        <small>-->
              <!--                                                                                            -->
              <?//= $color_list->adhesive ?>
              <!--                                                                                        </small>-->
              <!--                                                                                    </a></li>-->
              <!--                                                                            -->
              <?// } ?>
              <!--                                                                        </ul>-->
              <!--                                                                    </div>-->
              <!--                                                                </div>-->
              <!--                                                            </div>-->
              <!--                                                        </div>-->
              <!--                                                    </div>-->
              <!--                                                </div>-->
              <!--                                            </div>-->
              <!--                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">-->
              <!--                                                <div>-->
              <!--                                                    <button onclick="window.location.reload();"-->
              <!--                                                            class="btn orangeBg btn-block" role="button"><i-->
              <!--                                                                class="fa fa-refresh"></i></button>-->
              <!--                                                </div>-->
              <!--                                            </div>-->
              <!--                                        </div>-->
              <!--                                    -->
              <?// } ?>
              <!--                                </div>-->
            </div>
          </div>
          <div class="clear"></div>
          <div class="panel panel-default no-border mat-may-2017 mat-sep-2017 fetch_category_mateials">
            <div class="panel-body no-padding">
              <div class="mat-ch">
                <div class="colors_data mat-ch append_search ajax_material_mat"
                                         id="<?= (isset($othermaterials) and $othermaterials != '') ? '/*ajax_material_sorting*/' : '' ?>">
                  <?

                                        $productid = "";


                                        include('material_list_view_a4.php');

                                        //echo $productid;

                                        ?>
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
</div>

<!-- Upload Artwork -->

<div class="modal fade artworkModal1 aa-modal" id="integrated_model_here" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content no-padding">
      <div class="panel no-margin">
        <div class="panel-heading" style="height: 50px;background-color: #006da4 !important;"> <b style="font-size: 20px;color: #ffffff !important;">Upload Artwork</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none repeat scroll 0 0 transparent !important;
border: 0;"><i class="fa fa-times-circle" style="color: #ffffff;font-size: 26px;"></i></button>
          <div class="clear"></div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            <div id="artworks_uploads_loader" class="white-screen hidden-xs" style="display:none;">
              <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                            src="<?= Assets ?>images/loader.gif" class="image"
                                            style="width:139px; height:29px; "></div>
            </div>
            <div id="ajax_artwork_uploadssss" class=""> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Upload Artwork -->

<!-- Layout modal -->

<div class="modal fade layout aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content no-padding">
    <div class="modal-header" style="padding: 20px 0px !important;">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button" style="height: 35px;
    width: 35px;"><span aria-hidden="true" style="color: #666;">×</span></button>
        <h4 style=" padding-left: 20px;" id="myModalLabel" class="modal-title">Label Layout <a href="#myModalLabel" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
      </div>
      <div class="panel no-margin">
        <div class="panel-body">
          <div id="ajax_layout_spec" class="row">
            <? include_once('layout_popup.php') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Layout modal -->

<!-- Material Detail modal -->

<div class="modal fade material aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 0px; */">
      <div class="modal-header" style="padding: 20px 0px !important;">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button" style="height: 35px;
    width: 35px;"><span aria-hidden="true" style="color: #666;">×</span></button>
        <h4 style=" padding-left: 20px;" id="myModalLabel" class="modal-title">AA Labels Technical Specification - <span id="mat_code"></span> <a href="#myModalLabel" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
      </div>
      <div class="" style=" padding: 0px 20px;">
        <div class="row">
          <div class="col-md-3 text-center"><img style="width: 150px !important;" id="material_popup_img"
                                                               src="" alt="<?= $catname ?>"
                                                               title="<?= $catname ?>" width="46" height="46"
                                                               class="m-t-b-10 img-Sheet-material"></div>
          <div class="col-md-9">
            <div id="specs_loader" class="white-screen hidden-xs" style="display:none;">
              <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                            src="<?= Assets ?>images/loader.gif" class="image"
                                            style="width:139px; height:29px; "></div>
            </div>
            <div id="ajax_tecnial_specifiacation" class="specifiacation"></div>
            <div style="font-size: 12px;">This summary materials specification for this adhesive label is based on
              information
              obtained from the original material manufacturer and is offered in good faith in
              accordance with AA Labels terms and conditions to determine fitness for use as sheet
              labels (A4, A3 &amp; SRA3) produced by AA Labels. No guarantee is offered or
              implied. It
              is the user's responsibility to fully asses and/or test the label's material and
              determine its suitability for the label application intended. Measurements and test
              results on this label's material are nominal. In accordance with a policy of
              continuous
              improvement for label products the manufacturer and AA Labels reserves the right to
              amend the specification without notice. A <a target="_blank"
                                            href="<?php echo base_url(); ?>labels-materials/">full
              material specification</a> can be found in the Label Materials section accessed
              via
              the Home Page <br>
              Copyright&copy; AA labels 2015</div>
          </div>
        </div>
      </div>
        </div>
  </div>
</div>

<!-- Material Detail modal -->

<!-- Sample Order implementation -->

<div class="modal fade pbreaks aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content no-padding">
      <div class="panel no-margin">
        <div class="panel-heading" style="height: 50px;background-color: #006da4 !important;">
          <h3 class="pull-left no-margin" style="line-height: 13px;"><b class="pull-left" style="font-size: 20px;color: #fff !important;">VOLUME PRICE BREAKS
            <?= strtoupper($Paper_size) ?>
            </b>
            <? if (strtolower($Paper_size) == 'a4 sheets') { ?>
            <span class="label label-danger pull-left hppp-title-text" style="color: #fff !important;">(Half Price Print Promotion off prices shown below)</span>
            <? } ?>
            <a href="#myModalLabel" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none repeat scroll 0 0 transparent !important;border: 0;">
            <i class="fa fa-times-circle" style="font-size: 26px;color: #ffffff !Important;"></i></button>
          <div class="clear"></div>
        </div>
        <div class="panel-body">
          <div class="text-center">
            <div id="price_loader" class="white-screen hidden-xs" style="display:none;">
              <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                            src="<?= Assets ?>images/loader.gif" class="image"
                                            style="width:139px; height:29px; "></div>
            </div>
            <div class="table-res table-responsive" id="ajax_price_breaks"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade lb_applications aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel1"
         aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="overflow: hidden;">
      <div class="modal-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true" style="color: #666">×</span></button>
        <h4 id="myModalLabel1" class="modal-title"><span id="app_group_name"></span> - Label Applications <a
                                href="#myModalLabel1" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
      </div>
      <div>
        <div id="lb_applications_loader" class="white-screen hidden-xs" style="display:none;">
          <div class="loading-gif text-center" style="top:26%;left:29%;"><img
                                    src="<?= Assets ?>images/loader.gif" class="image"
                                    style="width:139px; height:29px; "> </div>
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

<script>

        var timer = '';

        $(document).on("change", ".product_adhesive", function(e) {

            get_product_details(this);

        });


        function get_product_details(_this){



            var productid = $(_this).parents('.productdetails').attr('data-value');

            var finish = $(_this).parents('.productdetails').attr('data-finish');

            var material = $(_this).parents('.productdetails').attr('data-material');

            //var colour = $(_this).parents('.productdetails').attr('data-colour');

            var colour = $(_this).parents('.productdetails').find('.colourpicker .active a').attr('data-value');

            var adhesive = $(_this).parents('.productdetails').find('.product_adhesive').val();



            if(adhesive=='' || adhesive== null){ return true;}

            //console.log('Adhesive option: '+adhesive);
            //var mat_code = $(_this).find("img").attr("src");

            //console.log("Finish: "+finish+" Material:"+material+" Colour:"+colour);


            var mat_code = $(_this).parents('.productdetails').find("img").attr("src");

            // console.log(mat_code);

            //if(mat_code.match(/CSC/) && material == 'Luxury Paper')
            if(finish == 'Matt' && material == 'Luxury Paper' && colour == 'Luxury White')
            {
                colour = "Luxury White";
                finish = "Matt White";
                material = "Paper";

                //console.log(' CSC Material Change');
            }

            reset_plain_input_buttons(_this);

            reset_print_input_buttons(_this);





            //aa_loader



            var top = $(_this).offset().top;

            top = top-200;



            $('.loading-gif').css('top',top);

            $('#aa_loader').show();



            /*********** Empty the Cart here ***********/



            /******************************************/





            $.ajax({

                url: mainUrl+'search/Search/grouped_product_info',

                type:"post",

                async:"false",

                dataType: "json",

                data:{

                    productid:productid,

                    colour:colour,

                    finish:finish,

                    material:material,

                    adhesive:adhesive,

                    catid:'<?=$details['CategoryID']?>',

                    type:'Sheets',

                },

                success: function(data){



                    $('#aa_loader').hide();

                    if(data.response == 'notfound'){

                        alert_box('Sorry this product is out of stock this time.');

                    }else{

                        var img_path = '<?=Assets?>images/categoryimages/A4Sheets/euro_edges/'+data.material_code+'.png';

                        $('.euro_thumbnail').attr('src',img_path);

                        $(_this).parents('.productdetails').find('.product_adhesive').html(data.adhesive_option);









                        $(_this).parents('.productdetails').find('.product_material_image').attr('src',data.sheet_image);

                        $(_this).parents('.productdetails').find('.product_name').html(data.product_name);

                        $(_this).parents('.productdetails').find('.product_description').html(data.product_description);



                        $(_this).parents('.productdetails').find('.category_description').val(data.category_description);





                        $(_this).parents('.productdetails').find('.product_id').val(data.product_id);

                        $(_this).parents('.productdetails').find('.manfactureid').val(data.manfactureid);



                        $(_this).parents('.productdetails').find('#minimum_quantities').val(data.minimum);

                        $(_this).parents('.productdetails').find('#maximum_quantities').val(data.maximum);

                        $(_this).parents('.productdetails').find('.PrintableProduct').val(data.Printable);



                        $(_this).parents('.productdetails').find('.laser_printer_img').attr('src',   data.laser_img);

                        $(_this).parents('.productdetails').find('.inkjet_printer_img').attr('src',  data.inkjet_img);

                        $(_this).parents('.productdetails').find('.direct_printer_img').attr('src',  data.thermal_img);

                        $(_this).parents('.productdetails').find('.thermal_printer_img').attr('src', data.d_thermal_img);







                        $(_this).parents('.productdetails').find('.laser_printer_div').attr('data-original-title',   data.laser_text);

                        $(_this).parents('.productdetails').find('.inkjet_printer_div').attr('data-original-title',  data.inkjet_text);

                        $(_this).parents('.productdetails').find('.thermal_printer_div').attr('data-original-title',  data.thermal_text);

                        $(_this).parents('.productdetails').find('.direct_printer_div').attr('data-original-title', data.d_thermal_text);



                        $(_this).parents('.productdetails').find("[data-toggle=tooltip-product]").tooltip();



                        $('.selected-product').find('.pr-thumb').find('img').attr('src',data.sheet_image);

                        $('#ajax_layout_spec').find('img.design-image').attr('src',data.sheet_image);





                        if(data.EuroID)

                        {

                            $(_this).parents('.productdetails').find('.printer_edge').removeClass('hide').addClass('show');

                        }

                        else

                        {

                            $(_this).parents('.productdetails').find('.printer_edge').removeClass('show').addClass('hide');

                        }







                        if(data.Printable == 'N'){

                            $(_this).parents('.productdetails').find('.printedoption').removeClass('active').addClass('hide');

                            $(_this).parents('.productdetails').find('.tabprinted').removeClass('active');



                            $(_this).parents('.productdetails').find('.tabplain').removeClass('active');

                            $(_this).parents('.productdetails').find('.plainoption').removeClass('active');



                            $(_this).parents('.productdetails').find('.tabplain').addClass('active');

                            $(_this).parents('.productdetails').find('.plainoption').addClass('active');



                            $(_this).parents('.productdetails').find('.addprintingoption').addClass('hide');



                        }else{

                            $(_this).parents('.productdetails').find('.printedoption').removeClass('hide');

                            //$(_this).parents('.productdetails').find('.addprintingoption').removeClass('hide');

                        }



                        var exist = $(_this).parents('.productdetails').find('#uploadedartworks_'+data.product_id).length;

                        if(exist==0){

                            var _el = document.createElement('input');

                            _el.value = 0;

                            _el.type = 'hidden';

                            _el.id = 'uploadedartworks_'+data.product_id;

                            $(_this).parents('.productdetails').find('.hiddenfields').append(_el);

                        }



                        var designs = $(_this).parents('.productdetails').find('#uploadedartworks_'+data.product_id).val();

                        update_artwork_upload_btn(_this, parseInt(designs));



                    }

                }

            });

        }


        function reset_plain_input_buttons(_this){

            $(_this).parents('.productdetails').find('.plainprice_box').hide();

            $(_this).parents('.productdetails').find('.add_plain').hide();

            $(_this).parents('.productdetails').find('.plain_save_txt').hide();
            $(_this).parents('.productdetails').find('.addprintingoption').hide();

            $(_this).parents('.productdetails').find('.calculate_plain').show();

        }

        function reset_print_input_buttons(_this){

            $(_this).parents('.productdetails').find('.printedprice_box').hide();

            $(_this).parents('.productdetails').find('.add_printed').hide();

            $(_this).parents('.productdetails').find('.calculate_printed').show();

        }

        $(document).on("click", ".productdetails .plain_calculation_unit li a", function (e) {


            var minqty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

            var maxqty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());


            var qty = parseInt($(this).parents('.productdetails').find('.plainsheet_input').val());

            var labelspersheet = parseInt($(this).parents('.productdetails').find('.LabelsPerSheet').val());

            var selText = $(this).text();

            var old_val = $(this).parents('.input-group-btn').find('.dropdown-toggle').text();

            if ($.trim(old_val) == $.trim(selText)) {
                return true;
            }


            if (selText == 'Labels') {

                var milabels = parseInt(labelspersheet * minqty);

                $(this).parents('.productdetails').find('.plainsheet_input').attr('placeholder', 'Minimum ' + milabels);

                $(this).parents('.productdetails').find('.small_plain_minqty_txt').text('Minimum order ' + milabels + ' labels');

                qty = parseInt(labelspersheet * qty);

                if (qty >= milabels) {

                    $(this).parents('.productdetails').find('.plainsheet_input').val(qty)

                } else {

                    $(this).parents('.productdetails').find('.plainsheet_input').val('');

                    $(this).parents('.productdetails').find('.plainsheet_input').focus();

                }

            }

            else {

                $(this).parents('.productdetails').find('.plainsheet_input').attr('placeholder', 'Minimum ' + minqty);

                $(this).parents('.productdetails').find('.small_plain_minqty_txt').text('Minimum order ' + minqty + ' sheets');

                qty = parseInt(qty / labelspersheet);

                if (qty >= minqty) {

                    $(this).parents('.productdetails').find('.plainsheet_input').val(qty)

                } else {

                    $(this).parents('.productdetails').find('.plainsheet_input').val('');

                    $(this).parents('.productdetails').find('.plainsheet_input').focus();

                }


                //$(this).parents('.productdetails').find('.calculation_unit').val('sheets');

            }

            $(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');


        });

        $(document).on("click", ".delete_artwork_file", function (event) {

            var id = $(this).attr('id');

            var cartid = $('#cartid').val();

            var productid = $('#cartproductid').val();

            var persheet = $('#labels_p_sheet').val();

            var type = 'a4';

            var unitqty = $('#cartunitqty').val();


            unitqty = $.trim(unitqty);
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

                                unitqty: unitqty

                            },

                            success: function (data) {

                                data = $.parseJSON(data);

                                if (!data == '') {

                                    update_printed_quantity_box(data.qty, data.designs);

                                    $('#ajax_upload_content').html(data.content);

                                    intialize_progressbar();

                                }

                            }

                        });

                        break;


                }

            });


        });
        $(document).on("click", ".productdetails .print_calculation_unit li a", function (e) {


            var minqty = parseInt($(this).parents('.productdetails').find('.minimum_quantities').val());

            var maxqty = parseInt($(this).parents('.productdetails').find('.maximum_quantities').val());


            var qty = parseInt($(this).parents('.productdetails').find('.printedsheet_input').val());

            var labelspersheet = parseInt($(this).parents('.productdetails').find('.LabelsPerSheet').val());

            var selText = $(this).text();

            var old_val = $(this).parents('.input-group-btn').find('.dropdown-toggle').text();

            if ($.trim(old_val) == $.trim(selText)) {
                return true;
            }

            if (selText == 'Labels') {

                var milabels = parseInt(labelspersheet * minqty);

                $(this).parents('.productdetails').find('.printedsheet_input').attr('placeholder', 'Minimum ' + milabels);

                $(this).parents('.productdetails').find('.small_print_minqty_txt').text('Minimum order ' + milabels + ' labels');

                qty = parseInt(labelspersheet * qty);

                if (qty >= milabels) {

                    $(this).parents('.productdetails').find('.printedsheet_input').val(qty)

                } else {

                    $(this).parents('.productdetails').find('.printedsheet_input').val('');

                    $(this).parents('.productdetails').find('.printedsheet_input').focus();

                }

            }

            else {

                $(this).parents('.productdetails').find('.printedsheet_input').attr('placeholder', 'Minimum ' + minqty);

                $(this).parents('.productdetails').find('.small_print_minqty_txt').text('Minimum order ' + minqty + ' sheets');

                qty = parseInt(qty / labelspersheet);

                if (qty >= minqty) {

                    $(this).parents('.productdetails').find('.printedsheet_input').val(qty)

                } else {

                    $(this).parents('.productdetails').find('.printedsheet_input').val('');

                    $(this).parents('.productdetails').find('.printedsheet_input').focus();

                }


                //$(this).parents('.productdetails').find('.calculation_unit').val('sheets');

            }

            $(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');


        });


        $(document).on("click", ".productdetails .colourpicker li a", function (e) {

            var colour = $(this).attr('data-value');

            $(this).parents('.productdetails').attr('data-colour', colour);

            $(this).parents('.productdetails').find('.colourpicker li').removeClass('active');

            $(this).parent().addClass("active");

            $(this).blur();

            get_product_details(this);

        });


        var old_labels_input;

        var old_roll_labels_input;

        var old_roll_input;

        $(document).on("focus", ".labels_input", function (e) {

            old_labels_input = $(this).val();

        });

        $(document).on("focus", ".roll_labels_input", function (e) {

            old_roll_labels_input = $(this).val();

        });

        $(document).on("focus", ".input_rolls", function (e) {

            old_roll_input = $(this).val();

        });


        $(document).on("keypress keyup blur", ".labels_input", function (e) {

            if ($(this).val() != old_labels_input) {

                $(this).parents('.upload_row').find('.sheet_updater').show();

            }

        });


        var parent_selector = null;


        $(document).on("blur", ".labels_input", function (e) {


            var min_qty = parseInt($('#labels_p_sheet').val());

            var unitqty = $('#cartunitqty').val();

            unitqty = $.trim(unitqty);

            var labels = parseInt($(this).val());


            if (!is_numeric(labels)) {

                show_faded_popover(this, "please enter only numbers ");

                $(this).val('');

                return false;

            }

            else if (labels == 0 && unitqty == 'Sheets') {

                show_faded_popover(this, "Minimum 1 sheet required ");

                $(this).val('');

                return false;

            }

            else if ((labels == 0 || labels < min_qty) && unitqty == 'Labels') {

                show_faded_popover(this, "Minimum " + min_qty + " labels are required ");

                $(this).val('');

                return false;

            }

            else if (labels % min_qty != 0 && unitqty == 'Labels') {

                var multipyer = min_qty * parseInt(parseInt(labels / min_qty) + 1);

                $(this).val(multipyer);

                total_upload_labels();

                show_faded_popover(this, "Quantity has been amended for production as " + multipyer + " Labels.");

                $(this).focus();

                return false;

            }

            else {

                total_upload_labels();

            }


        });


        function total_upload_labels() {

            var total_labels = 0;

            var total_sheets = 0;


            var min_qty = $('#labels_p_sheet').val();

            var unitqty = $('#cartunitqty').val();


            $(".labels_input").each(function (index) {

                if ($(this).val() !== '') {

                    if (unitqty == 'Labels') {

                        var labels = parseInt($(this).val());

                        var sheets = parseInt(labels / min_qty);

                        $(this).parents('.upload_row').find('.displaysheets').text(sheets);


                    } else {

                        var sheets = parseInt($(this).val());

                        var labels = parseInt(sheets * min_qty);

                        $(this).parents('.upload_row').find('.displaysheets').text(labels);

                    }


                    total_labels += labels;

                    total_sheets += sheets;

                }

            });


            if (total_sheets != 'NaN') {

                if (unitqty == 'Labels') {

                    $('.total_user_labels').html(total_sheets);

                    $('.total_user_sheet').html(total_labels);

                } else {

                    $('.total_user_labels').html(total_labels);

                    $('.total_user_sheet').html(total_sheets);

                }


                var labels = parseInt($('#acutal_labels').val());

                var acutal_qty = parseInt($('#acutal_qty').val());

                var labelspersheets = parseInt($('#labels_p_sheet').val());

                var reaming = parseInt(acutal_qty) - parseInt(total_sheets);

                if (reaming < 0) {
                    $('.remaing_user_sheets').html('0');
                    $('.remaing_user_labels').html('0');
                }

                else {

                    if (unitqty == 'Labels') {

                        $('.remaing_user_sheets').html(reaming * labelspersheets);

                        $('.remaing_user_labels').html(reaming);

                    } else {

                        $('.remaing_user_sheets').html(reaming);

                        $('.remaing_user_labels').html(reaming * labelspersheets);

                    }

                }

                $('#upload_remaining_labels').val(reaming);

            }

        }


 /* $(document).on("click", ".sheet_updater", function (event) {
    var id = $(this).attr('data-id');
    var _this = this;
    var cartid = $('#cartid').val();
    var prdid = $('#cartproductid').val();
    var labelpersheets = $('#labels_p_sheet').val();
    var type = 'a4';
    var cartunitqty = $('#cartunitqty').val();
    if (cartunitqty == 'Labels') {
      var labels = $(_this).parents('.upload_row').find('.labels_input').val();
      if (labels.length == 0 || labels == 0 || labels == '') {
        var id = $(_this).parents('.upload_row').find('.labels_input');
        var popover = $(_this).parents('.upload_row').find('.popover').length;
        if (popover == 0) {
          show_faded_popover(id, "Minimum " + labelpersheets + " labels are required ");
        }
        return false;
      }
      var sheets = parseInt(labels / labelpersheets);
    } else {
      var sheets = $(_this).parents('.upload_row').find('.labels_input').val();
      if (sheets.length == 0 || sheets == 0 || sheets == '') {
        var id = $(_this).parents('.upload_row').find('.labels_input');
        var popover = $(_this).parents('.upload_row').find('.popover').length;
        if (popover == 0) {
          show_faded_popover(id, "Minimum 1 sheet required ");
        }
        return false;
      }
      var labels = parseInt(sheets * labelpersheets);
    }

    var integr = $('#newcategory').val();
    alert(integr);
    if(integr=='A4'){

    if(sheets < 25)
    {
      $('#no_of_sheets').val(25);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 25");
    }
  }

  if(integr=='A3'){
    if(sheets < 25)
    {
      $('#no_of_sheets').val(100);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 100");
    }
  }

  if(integr=='SRA3'){
    if(sheets < 100){
      $('#no_of_sheets').val(100);
      show_faded_popover('no_of_sheets', "Quantity has been round off to 100");
    }
  }


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
        unitqty: cartunitqty,
      },
      success: function (data) {
        data = $.parseJSON(data);
        if (!data == '') {
          update_printed_quantity_box(data.qty, data.designs);
          $('#ajax_upload_content').html(data.content);
          intialize_progressbar();
        }
      }
    });
  });*/


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


        $(document).on("focus", ".plainsheet_input", function (e) {

            reset_plain_input_buttons(this);

        });

        $(document).on("focus", ".printedsheet_input", function (e) {

            reset_print_input_buttons(this);

        });


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



        var contentbox = $('#ajax_labelfilter');


        $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
            $('[data-toggle="tooltip-digital"]').tooltip();
            $("[data-toggle=tooltip-product]").tooltip();
            $(':not([data-toggle="popover"])').popover('hide');
        });


        //$('[data-filters="Polyethylene"]').hide();

        //

        function fetch_special_offers() {

            $('#aa_loader').show();

            var visible = $(".other_materials [data-promotion='yes']");

            $('.fetch_category_mateials').find('.append_search').append(visible);

            var others = $(".other_materials [data-promotion='no']");

            $(others).show();

            $('.other_mats').find('.append_search').append(others);

            $('.other_mats').show();

            $('.hide_title').text("Filtered Results");

            $('#aa_loader').hide();

        }

        function fetch_category_mateials() {

            var catid = '<?=$details['CategoryID']?>';
            var material = $('#material_mat').val();
            var adhesive = $('#adhesive_mat').val();
            var color = $('#color_mat').val();
            var top = $('#material_mat').offset().top;
            top = top + 100;
            $('.loading-gif').css('top', top);
            $('#aa_loader').show();
            <?php if(isset($_GET['productid']) and $_GET['productid'] != ''):?>
            var productid = '<?=$_GET['productid']?>';
            <?php else:?>
            var productid = '';
            <?php endif;?>
            $.ajax({
                url: mainUrl + 'search/Search/get_category_materials_newfilter/',
                type: "POST",
                async: "false",
                dataType: "html",
                data: {
                    material: material,
                    adhesive: adhesive,
                    color: color,
                    catid: catid,
                    productid: productid,
                    type: "<?=$type?>"
                },
                success: function (data) {
                    if (!data == '') {
                        data = $.parseJSON(data);
                        /*$('#material_mat').html(data.material);
                        $('#adhesive_mat').html(data.adhesive);
                        $('#color_mat').html(data.color);*/

                        //$('.new_filter .material-d-down').find('.dropdown-menu').html(data.material);
                        $('.new_filter .color-d-down').find('.dropdown-menu').html(data.color);

                        var material = $('#material_mat').val();
                        var adhesive = $('#adhesive_mat').val();
                        var color = $('#color_mat').val();
                        $('[data-reset="reset"]').show();
                        $('.data-reset-colour').show();
                        if (material != '') {
                            $('.other_materials [data-reset="reset"]').hide();
                            $('.other_materials [data-mat-filters="' + material + '"]').show();
                        }
                        if (color != '') {
                            $('.other_materials [data-reset="reset"]').hide();
                            $('.other_materials [data-reset="reset"]').each(function (index) {
                                var colourexist = '';
                                var _this = this;
                                $(this).find('.data-reset-colour').each(function (index) {
                                    var colour = $(this).attr('data-colour-filters');
                                    if (colour == color) {
                                        if (adhesive != '') {
                                            var isdisabled = $(_this).find('.product_adhesive option[value="' + adhesive + '"]').attr('disabled');
                                            if (isdisabled != 'disabled') {
                                                $(_this).find('.product_adhesive option[value="' + adhesive + '"]').attr('selected', 'selected');
                                            }
                                        }
                                        colourexist = 'match';
                                        var material_select = $(_this).attr('data-mat-filters');
                                        if (material != '' && material_select != material) {
                                            $(_this).hide();
                                        } else {
                                            $(_this).show();
                                        }
                                        if ($(_this).css('display') == 'block') {
                                            $(this).find('a').click();
                                        }
                                    }
                                });
                            });
                        }
                        if (adhesive != '') {
                            $('.other_materials [data-reset="reset"]').each(function (index) {
                                //var adhesive = $(this).find('.product_adhesive').val();
                                var _this = this;
                                var option = $(this).find('.product_adhesive').children('option[value="' + adhesive + '"]').attr('disabled');
                                //	console.log(option);
                                if (option == 'disabled') {
                                    $(_this).hide();
                                } else {
                                    //var option=$(this).find('.product_adhesive').children('option[value="' + adhesive + '"]').attr('selected', 'selected');
                                }

                            });

                        }

                        var visible = $(".other_materials [data-reset='reset']:visible");
                        $('.fetch_category_mateials').find('.append_search').append(visible);
                        var others = $(".other_materials [data-reset='reset']:hidden");
                        $(others).show();
                        $('.other_mats').find('.append_search').append(others);
                        $('.other_mats').show();
                        $('.hide_title').text("Filtered Results");
                        $('#aa_loader').hide();

                        if (material == "" && color == "") {
                            $(".other_mats").hide();
                        }
                        else {
                            $(".other_mats").show();
                        }

                    }
                }
            });
        }


        function ecommerce_add_to_cart(_this, type) {

            <? if(SITE_MODE == 'live'){ ?>



            var prdid = $(_this).parents('.productdetails').find('.product_id').val();

            //var product_name =  $(_this).parents('.productdetails').find('.product_name').text();

            var product_name = $(_this).parents('.productdetails').find('.category_description').val();

            var category = '<?=$Paper_size?>';


            if (type == 'printed') {

                var input_id = $(_this).parents('.productdetails').find('.printedsheet_input');

                var quantity = parseInt(input_id.val());

                var price = $(_this).parents('.productdetails').find('.printedprice_text').find('.color-orange').text();

                var category = " Printed - " + category;

                var price = price.replace(/[^\d.]/g, '');


            }

            else if (type == 'sample') {

                var price = 0.00;

                var category = " Sample - " + category;

                var quantity = 1

            }

            else {

                var input_id = $(_this).parents('.productdetails').find('.plainsheet_input');

                var quantity = parseInt(input_id.val());

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




        $(document).ready(function () {

            //$(".product_material_image").aaZoom();
            $('[data-toggle="tooltip"]').tooltip();
            $(".product_material_image").hover(function (e) {
                var value = $(this).aaZoom();
            });

            $('.product_material_image').aaZoom();
        });


$(document).on("mouseenter", ".productdetails .colourpicker li a", function (e) {

            var colour = $(this).attr('data-value');
            $(this).parents('.productdetails').find("[data-toggle=tooltip]").tooltip();
        });


    </script>

