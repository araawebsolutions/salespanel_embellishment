<input type="hidden" id="arwork_type_on_page" value="roll">
<?

//PGCR  PGCP

//error_reporting(1);

$a4_prints = $this->home_model->get_digital_printing_process('Roll');


$compatibility = $this->filter_model->get_compatibility_text('roll');
$free_delivery_orders = symbol . $this->home_model->currecy_converter(25.00, 'no');
$each_design_price = symbol . $this->home_model->currecy_converter(DesignPrice, 'yes');
$print_compatible_array = array();
foreach ($compatibility as $com) {
    $com->print_method = str_replace(" ", "", trim($com->print_method));
    $com->type = str_replace(" ", "", trim($com->type));
    $print_compatible_array[$com->print_method][$com->type] = $com->description;
}


if ($details['Shape'] == "Rectangle") {
    $l_group = $this->home_model->get_rectangle_group($details['LabelWidth'], $details['LabelHeight']);
}
 //$materials[0]->ManufactureID; echo '<br>';
 $min_qty = $this->home_model->min_qty_roll($materials[0]->ManufactureID); 
 $max_qty = $this->home_model->max_qty_roll($materials[0]->ManufactureID);

/*echo '<pre>';
print_r($materials);
exit;*/
foreach ($materials as $rec) {


    $type = 'Rolls';
    $condition = " type LIKE '" . $type . "' AND finish_type LIKE '" . $rec->LabelFinish . "' AND material_type LIKE '" . $rec->ColourMaterial . "'";
    $colours = $this->home_model->grouping_material_colours($condition);


    $grouped_adhesive = $this->home_model->grouping_material_adhesive($condition);

    $cryogenic = $this->home_model->search_adhesive_in_array($grouped_adhesive,   'Adhesive', 'Cryogenic');
    $freezer = $this->home_model->search_adhesive_in_array($grouped_adhesive,     'Adhesive', 'Freezer');
    $heatrest = $this->home_model->search_adhesive_in_array($grouped_adhesive,    'Adhesive', 'Heat Resistant');
    $hightack = $this->home_model->search_adhesive_in_array($grouped_adhesive,    'Adhesive', 'High Tack');
    $permanent = $this->home_model->search_adhesive_in_array($grouped_adhesive,   'Adhesive', 'Permanent');
    $removable = $this->home_model->search_adhesive_in_array($grouped_adhesive,   'Adhesive', 'Peelable');
    $sealable = $this->home_model->search_adhesive_in_array($grouped_adhesive,    'Adhesive', 'Resealable');
    $superperm = $this->home_model->search_adhesive_in_array($grouped_adhesive,   'Adhesive', 'Super Permanent');
    $waterres = $this->home_model->search_adhesive_in_array($grouped_adhesive,    'Adhesive', 'Water Resistant');

    $keys = array_keys($colours);
    $last = end($keys);

    if (isset($colours[$last]->LabelColor) and $colours[$last]->LabelColor != $rec->LabelColor and count($colours) > 1 and empty($productid)) {
        $condition = " LabelFinish LIKE '" . $rec->LabelFinish . "' AND ColourMaterial LIKE '" . $rec->ColourMaterial . "' 
			AND LabelColor LIKE '" . trim($colours[$last]->LabelColor) . "' AND CategoryID LIKE '" . $rec->CategoryID . "' 
			AND Adhesive LIKE '" . $rec->Adhesive . "'";
        $result = $this->db->query("Select ProductID,ProductBrand,LabelsPerSheet,ManufactureID,SpecText7,LabelFinish,ColourMaterial,LabelColor,Adhesive,
			ProductCategoryName, Printable,ColourMaterial_upd,Material1
			from products where $condition LIMIT 1")->result();
        if (count($result) > 0) {
            $rec = $result[0];
        }
    }







    //preg_match('/^c/i', $catid)

    if(strpos($rec->CategoryID, 'R', -2) !== false){
        $Category_ID = substr($rec->CategoryID, 0, -2);
    }else{
        $Category_ID = $rec->CategoryID;
    }
    $selected_size = $Category_ID;
    //print_r($Category_ID); exit;


    /*print_r($rec->ProductID);
    print_r('<br>');
    print_r('hi');
    print_r('<br>');
    print_r($rec->CategoryID);
    print_r('hi');
    print_r('<br>');
    print_r($Category_ID);
    exit;*/



    if (preg_match("/Roll/", $rec->ProductBrand)) {
        /*$img_path = "SRA3Sheets";
        $mat_image = Assets . "images/categoryimages/" . $img_path . "/colours/" . $product->ManufactureID . ".png";
        $min_qty = '100';
        $min_qty_threshold = '100';
        $max_qty = '20000';*/
        $type = 'Rolls';
    }




    $max_labels = $this->home_model->max_total_labels_on_rolls($rec->LabelsPerSheet);
    $min_labels_per_roll = $this->home_model->min_labels_per_roll($min_qty);

    $material_code = $this->home_model->getmaterialcode(substr($rec->ManufactureID, 0, -1));
    $mat_image = aalables_path . "images/categoryimages/RollLabels/outside/" . $rec->ManufactureID . ".jpg";
    if (isset($wound_option) and $wound_option == 'Inside' and strcasecmp(substr($subcat, 0, -2), substr($wound_cate, 0, -2)) == 0) {
        $mat_image = aalables_path . "images/categoryimages/RollLabels/inside/" . $rec->ManufactureID . ".jpg";
    }


    $materialinfo = $this->db->query("Select tooltip_info,short_name,group_name, adhesive 
			from material_tooltip_info WHERE material_code LIKE '" . $material_code . "'")->row_array();

    $adhesive = (isset($materialinfo['adhesive']) and $materialinfo['adhesive'] != '') ? $materialinfo['adhesive'] : '';


    $desc = (isset($materialinfo['tooltip_info']) and $materialinfo['tooltip_info'] != '') ? $materialinfo['tooltip_info'] : '';
    $rec->Material1 = (isset($materialinfo['short_name']) and $materialinfo['short_name'] != '') ? $materialinfo['short_name'] : '';
    $group_name = (isset($materialinfo['group_name']) and $materialinfo['group_name'] != '') ? $materialinfo['group_name'] : '';

    if (preg_match("/WASP/i", $rec->ManufactureID)) {
        $comp = 'Commercial Inkjet (UV Inks Only), many  Laser (but not all, sample and test advised) and Thermal Transfer Printers.';
    }

    $max_length = 150;
    if (strlen($desc) > $max_length) {
        $offset = ($max_length - 3) - strlen($desc);
        $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
        $short_desc .= ' <a style="cursor:pointer;" data-toggle="tooltip-product" data-placement="top" data-original-title="' . $desc . '"><i>Read More</i></a>';
    } else {
        $short_desc = $desc;
    }

    $promotion = '';
    if (preg_match("/HGP/i", $rec->ManufactureID)) {
        $promotion = ' <br /> <strong style="color:#fd4913"> Special Offer Save 30% While Stocks Last </strong> ';
    }


    $promotion = ' ';


    $comp = $this->filter_model->grouping_compatiblity($rec->SpecText7, $print_compatible_array);

    if (isset($max_diameter) and $max_diameter != 0) {
        $total_labels = $this->home_model->get_max_labels_printer($rec->ManufactureID, $rec->LabelsPerSheet, $max_diameter, $Labelsgap, $height);
        if (isset($total_labels) and $total_labels != 0 and $total_labels <= $rec->LabelsPerSheet) {
            $rec->LabelsPerSheet = $total_labels;
        }
    }
    ?>
<section data-mat-filters="<?= $rec->ColourMaterial ?>" data-reset="reset">
  <div class="row productdetails roll-products mainContainer" data-value="<?= $rec->ProductID ?>"
             data-finish="<?= $rec->LabelFinish ?>"
             data-material="<?= $rec->ColourMaterial ?>">
    <div class="hiddenfields">
        <input type="hidden" value="" class="cart_id"/>
        <input type="hidden" value="<?= $rec->ProductID ?>" class="product_id"/>
        <input type="hidden" value="<?= $rec->ManufactureID ?>" class="manfactureid"/>
        <input type="hidden" value="<?= $rec->LabelsPerSheet ?>" class="LabelsPerSheet"/>
        <input type="hidden" value="" class="digitalprintoption"/>
        <input type="hidden" value="" class="labelfinish"/>
        <input type="hidden" value="<?= $min_labels_per_roll ?>" class="minimum_printed_labels"/>
        <input type="hidden" value="<?= $max_labels ?>" class="maximum_printed_labels"/>
        <input type="hidden" value="<?= $min_qty ?>" class="minimum_quantities"/>
        <input type="hidden" value="<?= $max_qty ?>" class="maximum_quantities"/>

        <input type="hidden" value="<?= $rec->Printable ?>" class="PrintableProduct"/>
        <input type="hidden" value="1" class="orientation"/>
        <input type="hidden" value="<?= $rec->ProductCategoryName ?>" class="category_description"/>

        <input type="hidden" value="0" data-qty="0" data-presproof="0" data-rolls="0" id="uploadedartworks_<?= $rec->ProductID ?>" style="position: absolute; z-index: 500;"/>

        <input type="hidden" value="0" id="no_artworks_<?= $rec->ProductID ?>"/ style="position: absolute; z-index: 500; left: 250px;">

        <input type="hidden" value="<?= $min_qty ?>"  id="custom_qty_roll_<?= $rec->ProductID ?>"/ style="position: absolute; z-index: 500; left: 440px;">
        <input type="hidden" name="type" class="type" value="<?php echo $type;?>">
        <input type="hidden" name="CategoryID" class="CategoryID" value="<?php echo $Category_ID;?>">
        <input type="hidden" name="source" class="source" value="material_page">
        <input type="hidden" name="available_in" class="available_in" value="Roll">
        <input type="hidden" name="ColourMaterial_upd" class="ColourMaterial_upd" value="<?php echo $rec->ColourMaterial_upd;?>">
        <input type="hidden" name="material" class="material" value="<?php echo $rec->ColourMaterial_upd;?>">
        <input type="hidden" name="adhesive" class="adhesive" value="<?php echo $adhesive;?>">
        <input type="hidden" name="color" class="color" value="<?php echo $rec->Material1;?>">

        <input type="hidden" value="<?php echo $min_qty * $min_labels_per_roll;?>" class="qty allownumeric plainsheet_input">

        <input type="hidden" name="dieCode" class="dieCode" value="<?= ltrim($details['DieCode'], "1-") ?>">
        <input type="hidden" name="selected_size" class="selected_size" value="<?php echo $selected_size;?>">



    </div>
    <article class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mat-detail">
      <div class="pr-detail"> <span class="group_name">
        <?= $group_name ?>
        </span><br/>
        <span class="product_name">
        <?= $rec->Material1 ?>
        </span> <font class="product_description">
        <?= $short_desc ?>
        <?= $promotion ?>
        </font></div>
      <div class="clearfix"></div>
      <div class="row specs">
        <div class="col-lg-3 col-md-3 col-sm-2 col-xs-3"><img class="img-responsive product_material_image"
                                                                          src="<?= $mat_image ?>"></div>
        <div class="col-lg-9 col-md-9 col-sm-10 col-xs-8">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5">
              <div class="labels-form">
                <label class="select no-margin">
                  <select class="product_adhesive">
                    <option value="" disabled="disabled" selected="selected">Select Adhesive </option>
                    <option <?= $cryogenic ?> <?= ($rec->Adhesive == 'Cryogenic') ? 'selected="selected"' : '' ?>
                                                    value="Cryogenic">Cryogenic </option>
                    <option <?= $freezer ?>   <?= ($rec->Adhesive == 'Freezer') ? 'selected="selected"' : '' ?>
                                                    value="Freezer">Freezer </option>
                    <option <?= $heatrest ?> <?= ($rec->Adhesive == 'Heat Resistant') ? 'selected="selected"' : '' ?>
                                                    value="Heat Resistant"> Heat Resistant </option>
                    <option <?= $hightack ?> <?= ($rec->Adhesive == 'High Tack') ? 'selected="selected"' : '' ?>
                                                    value="High Tack">High Tack </option>
                    <option <?= $permanent ?> <?= ($rec->Adhesive == 'Permanent') ? 'selected="selected"' : '' ?>
                                                    value="Permanent">Permanent </option>
                    <option <?= $removable ?> <?= ($rec->Adhesive == 'Peelable') ? 'selected="selected"' : '' ?>
                                                    value="Peelable">Peelable </option>
                    <option <?= $sealable ?> <?= ($rec->Adhesive == 'Resealable') ? 'selected="selected"' : '' ?>
                                                    value="Resealable">Re-sealable </option>
                    <option <?= $superperm ?> <?= ($rec->Adhesive == 'Super Permanent') ? 'selected="selected"' : '' ?>
                                                    value="Super Permanent">Super Permanent </option>
                    <option <?= $waterres ?> <?= ($rec->Adhesive == 'Water Resistant') ? 'selected="selected"' : '' ?>
                                                    value="Water Resistant">Water Resistant </option>
                  </select>
                  <i></i> </label>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-md-6"><a href="#" id="<?= $rec->ProductID ?>"
                                                             class="technical_specs" data-target=".material"
                                                             data-toggle="modal"
                                                             data-original-title="Tecnial Specification"> Material
                  Specification <i class="fa fa-info-circle"></i> </a></div>
                <div class="col-md-6"><a href="#" id="<?= $group_name ?>" class="applications"
                                                             data-target=".lb_applications" data-toggle="modal"
                                                             data-original-title="Tecnial Specification"> Label
                  Applications <i class="fa fa-table" aria-hidden="true"></i> </a></div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <ul class="clr-thumbs colourpicker">
            <?
                            foreach ($colours as $row) {
                                $active_colour = '';
                                $colourclass = strtolower(str_replace(" ", "_", $row->LabelColor));
                                $colourclass = strtolower(str_replace("-", "_", $colourclass));
                                if ($row->LabelColor == $rec->LabelColor) {
                                    $active_colour = 'active';
                                }

                                if ($details['Shape_upd'] == "Rectangle") {
                                    $colour_icon = aalables_path . 'images/material_images/colours/rolls/rectangle/' . $row->imagecode . '.png';
                                } else {
                                    $colour_icon = aalables_path . 'images/material_images/colours/rolls/' . strtolower($details['Shape']) . "/" . $row->imagecode . '.png';
                                }


                                ?>
            <li class="<?= $active_colour ?> data-reset-colour" data-toggle="tooltip"
                                    data-placement="bottom"
                                    data-original-title="<?= $row->colour_name ?>"
                                    data-colour-filters="<?= $row->LabelColor ?>"><a class="mat_<?= $colourclass ?>"
                                                                                     data-value="<?= $row->LabelColor ?>"
                                                                                     href="javascript:void(0);"> <img
                                                class="img-responsive" src="<?= $colour_icon ?>"
                                                alt="<?= $row->colour_name ?>"></a></li>
            <? } ?>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comp">
          <table class="table printer" border="0" style="border:none;">
            <tbody>
              <tr>
                <td align="left" valign="center"
                                    style="font-size:12px; border:none;vertical-align: middle;width:25%"><small style="margin-top:10px;font-size:12px;">Printer Compatibility</small></td>
                <td align="left" style="font-size:9px; border:none; width:25%;display:none;"> Laser <a
                                            data-toggle="tooltip-product" data-placement="top" class="laser_printer_div"
                                            title="" data-original-title="<?= $comp['laser_text'] ?>"
                                            href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                  <br/>
                  <img class="laser_printer_img" width="50"
                                         src="<?= aalables_path ?>images/<?= $comp['laser_img'] ?>"/></td>
                <td align="left" style=" font-size:9px;border:none;width:25%;"> Inkjet <a
                                            data-toggle="tooltip-product" data-placement="top" title=""
                                            class="inkjet_printer_div" data-original-title="<?= $comp['inkjet_text'] ?>"
                                            href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                  <br/>
                  <img class="inkjet_printer_img" width="50"
                                         src="<?= aalables_path ?>images/<?= $comp['inkjet_img'] ?>"/></td>
                <td align="left" style=" font-size:9px;border:none;width:25%;"> Direct<br/>
                  Thermal <a data-toggle="tooltip-product" data-placement="top" title=""
                                               class="direct_printer_div"
                                               data-original-title="<?= $comp['d_thermal_text'] ?>"
                                               href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                  <img class="direct_printer_img" width="50"
                                         src="<?= aalables_path ?>images/<?= $comp['d_thermal_img'] ?>"/></td>
                <td align="left" style=" font-size:9px;border:none;width:25%;"> Thermal<br/>
                  Transfer <a data-toggle="tooltip-product" data-placement="top" title=""
                                                class="thermal_printer_div"
                                                data-original-title="<?= $comp['thermal_text'] ?>"
                                                href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                  <img class="thermal_printer_img" width="50"
                                         src="<?= aalables_path ?>images/<?= $comp['thermal_img'] ?>"/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </article>
    <article class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mat-tabs">
      <ul class="nav nav-tabs  nav-justified" role="tablist">
        <li class="nav-item"> <a id="main_tab_plain<?= $rec->ProductID ?>" href="#tab_plain<?= $rec->ProductID ?>" aria-controls="" role="tab" data-toggle="tab"
                           class="nav-link active">Plain Labels</a> </li>
        <li class="nav-item" <?php if($rec->Printable == 'N'){?> style="display:none;" <?php }?>>
            <!--<a id="main_tab_printed<?/*= $rec->ProductID */?>" href="#tab_printed<?/*= $rec->ProductID */?>" aria-controls="" role="tab" data-toggle="tab"
                       class="nav-link">Printed Labels</a>-->

            <a href="javascript:;" class="nav-link btn btn-block addprintBtn add_plain1" onclick="printed_labels(this);"> Add Print </a>
        </li>
        <li class="nav-item"> <a id="main_tab_sample<?= $rec->ProductID ?>" href="#tab_sample<?= $rec->ProductID ?>" aria-controls="" role="tab" data-toggle="tab"
                           class="nav-link">Material Sample</a> </li>
      </ul>
      <div class="tab-content">
        <div id="tab_plain<?= $rec->ProductID ?>" class="tab-pane tabplain active " role="tabpanel">
          <div class="row p-t-10" style="margin-top:45px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                  <p><strong>Labels Per Roll</strong>
                    <input maxlength="4" type="text" placeholder="100+"
                                                   class="form-control allownumeric plainlabels" style="height: 33px;">
                    <small>Max labels per roll -
                    <?= $rec->LabelsPerSheet ?>
                    </small> </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                  <p><strong style="font-size:12px;">Number of Rolls</strong>
                    <input maxlength="3" type="text" value="<?php echo $min_qty ?>" placeholder="<?= $min_qty ?>+"
                                                   class="form-control allownumeric plainrolls" style="height: 33px;">
                    <small>Multiples of
                    <?= $min_qty ?>
                    only </small> </p>
                </div>



                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 no-padding hidden-lg hidden-md hidden-sm">
                  <div style="display:none;margin-bottom: 34px;" class="rollLable_icon no-margin diamterinfo"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 quotation" style="margin-left: -15px";>
              <div class="clearfix hidden-lg hidden-md hidden-sm"></div>
              <input type="hidden" class="heigh_roll" value="<?= $height ?>"/>
              <input type="hidden" class="gap_roll" value="<?= $Labelsgap ?>"/>
              <? if ($regmark == "yes"): ?>
              <input type="hidden" class="regmark" value="yes"/>
              <div class="plainprice_box" style="display:none">
                <table class="price" width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tr class="printprice" style="">
                    <td style=" width:80%;padding-right: 23%;" class="text-left phead ui-button- text-right"> </td>
                    <td style=" width:20%;" class="raw_plain text-right color-orange"><b
                                                            class="pr-sm">-</b></td>
                  </tr>
                  <tr class="inkprice" style="">
                    <td style=" width:100%;" class="text-left phead"><div class="registration_mark">
                        <div class="check_section">
                          <label class="check">Reverse Registration
                            <input type="checkbox" checked="checked"
                                                                       name="registration_mark_option"
                                                                       class="registration_mark_option">
                            <span class="checkmark"></span> </label>
                        </div>
                      </div></td>
                    <td style=" width:20%;" class="regmark_price text-right color-orange"><b
                                                            class="pr-sm">-</b></td>
                  </tr>
                </table>
                <div class="text-right plainprice_text priceplain" style="padding: 5px 0px;">  &nbsp;</div>
                <div class="clear="></div>
                <div class="clear"></div>
                <span class="pull-right plainperlabels_text text-right">&nbsp;</span>
                <div class="clearfix"></div>
              </div>
              <? else: ?>
              <input type="hidden" id="regmark" value="no"/>
              <div class="plainprice_box" style="display:none">
                <table class="price" width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tr class="printprice" style="">
                    <td style=" width:80%;padding-right: 23%;" class="text-left phead ui-button- text-right">  </td>
                    <td style=" width:20%;" class="plainprice_text text-right priceplain"><b class="color-orange">-</b><br>Ex VAT</td>

                  </tr>
                </table>
              </div>
                  <div class="clearfix"></div>
                  <span class="pull-right plainperlabels_text text-right">&nbsp;</span>
							     <div class="clearfix"></div>
              <? endif; ?>
              <?php if (preg_match('/WTDP/', $rec->ManufactureID)): ?>
              <button style="display:none;" class="btn orangeBg pull-right get_a_quote_plain"
                                            type="button" data-toggle="modal" data-target="#get_a_quote"
                                            data-printing="N"> Get a Quote <i class="fa fa-calculator"></i></button>
              <?php else: ?>
              <button style="display:none;" class="btn orangeBg pull-right add_plain"
                                            type="button"> Add to basket<i class="fa fa-calculator"></i></button>
              <?php endif; ?>
              <button style="display:none;" class="btn orangeBg pull-right add_plain_roll"
                                        type="button"> Add to basket <i class="fa fa-calculator"></i></button>
              <button class="btn orangeBg pull-right calculate_plain_roll" type="button"
                                        style="margin-right: 10px;"> Calculate
              Price <i class="fa fa-calculator"></i></button>
              <div class="clearfix"></div>
              <a href="#" class="price_breakss pull-right text-right" data-target=".pbreaks" data-toggle="modal" data-original-title="Volume Price Breaks">View volume price breaks</a>
              <div class="service">
                <div class="addprintingoption  pull-right" style="display:none">
                    <a href="#" onclick="printed_labels(this);" aria-controls="" role="tab" data-toggle="tab" class="apf printpriceoffer">
                        <span style="color: red;text-decoration: underline;font-size: 12px;">Add printing for only
                            <b class="printing_offer_text"> <?= symbol ?> 16.59 </b>?</span>
                    </a>
                    <a href="javascript:;" class="btn btn-block addprintBtn add_plain1" onclick="printed_labels(this);"> Add Print </a>


                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <!--<div class="service">
                                <div class="addprintingoption  pull-right" style="display:none"><a href="#" onclick="showPrintOption(<?= $rec->ProductID ?>)" aria-controls="" role="tab" data-toggle="tab" class="apf printpriceoffer"> <i class="fa fa-hand-o-right pull-left" aria-hidden="true"></i> <span>Add printing for only <b class="printing_offer_text">
                               <?= symbol ?> 16.59</b>?</span> </a>
                                </div>
                            </div>--> 
            <!--                            <div class="col-xs-12 ofq hidden-lg hidden-md">--> 
            <!--                                <div class="col-xs-4 main-box">--> 
            <!--                                    <div class="row">--> 
            <!--                                        <div class="col-xs-2 no-padding-right ofq-icon"><img--> 
            <!--                                                    src="-->
            <? //= aalables_path ?>
            <!--images/4oclock.png"/></div>--> 
            <!--                                        <!--<div class="col-xs-10  no-padding-right ofq-text"><b>Order before 16:00 for Next Day Delivery</b></div>--> 
            
            <!--                                        <div class="col-xs-10  no-padding-right ofq-text material_clock">--> 
            <!--                                            <div class="counter clock_time">Order before 16:00 for Next Day Delivery--> 
            <!--                                            </div>--> 
            <!--                                            <div class="clearfix"></div>--> 
            <!--                                            <small style="font-size:8px;">Time remaining to next day delivery</small>--> 
            <!--                                        </div>--> 
            <!--                                    </div>--> 
            <!--                                </div>--> 
            <!--                                <div class="col-xs-4 main-box">--> 
            <!--                                    <div class="row">--> 
            <!--                                        <div class="col-xs-2 no-padding-right ofq-icon"><i class="fa fa-truck l-icon"--> 
            <!--                                                                                           aria-hidden="true"></i></div>--> 
            <!--                                        <div class="col-xs-10  no-padding-right ofq-text"><b>Free Delivery on Orders--> 
            <!--                                                over--> 
            <!--                                                -->
            <? //= $free_delivery_orders ?>
            <!--                                            </b> <a style="font-size:7px;" target="_blank"--> 
            <!--                                                    href="-->
            <? //= base_url() ?>
            <!--delivery/"><span--> 
            <!--                                                        class="glyphicon glyphicon-new-window"></span> Delivery &--> 
            <!--                                                Shipping Options</a></div>--> 
            <!--                                    </div>--> 
            <!--                                </div>--> 
            <!--                                <div class="col-xs-4 main-box">--> 
            <!--                                    <div class="row">--> 
            <!--                                        <div class="col-xs-2 no-padding-right ofq-icon"><i--> 
            <!--                                                    class="fa fa-check-square-o l-icon" aria-hidden="true"></i></div>--> 
            <!--                                        <div class="col-xs-10  no-padding-right ofq-text"><b>QUALITY ASSURANCE--> 
            <!--                                                GUARANTEE</b></div>--> 
            <!--                                    </div>--> 
            <!--                                </div>--> 
            <!--                            </div>--> 
            
          </div>
          <div class="col-lg-12 ofq row" style="float: right;position: inherit;margin-right: 5px;">
            <div class="col-lg-4 main-box">
              <div class="row">
                <div class="col-lg-2 no-padding-right ofq-icon"><img
                                                src="<?= Assets ?>images/4oclock.png"/></div>
                <div class="col-lg-10  no-padding-right ofq-text material_clock">
                  <div class="counter clock_time">Order before 16:00 for Next Day Delivery </div>
                  <div class="clearfix"></div>
                  <small style="font-size:8px;">Time remaining to next day delivery</small> </div>
              </div>
            </div>
            <div class="col-lg-4 main-box">
              <div class="row">
                <div class="col-lg-2 no-padding-right ofq-icon"><i class="fa fa-truck l-icon"
                                                                                       aria-hidden="true"></i></div>
                <div class="col-lg-10  no-padding-right ofq-text"><b>Free Delivery on Orders
                  over
                  <?= $free_delivery_orders ?>
                  </b> 
                  <a style="font-size:7px;" target="_blank"
                                                     href="https://www.aalabels.com/delivery/"><span
                                                    class="glyphicon glyphicon-new-window"></span> Delivery &
                  Shipping Options</a></div>
              </div>
            </div>
            <div class="col-lg-4 main-box">
              <div class="row">
                <div class="col-lg-2 no-padding-right ofq-icon"><img
                                                src="<?= Assets ?>images/check-circle.png"
                                                class="circle-icon-small" style="height: 21px;width: 21px;"/></div>
                <div class="col-lg-10  no-padding-right ofq-text"><b>QUALITY ASSURANCE
                  GUARANTEE</b></div>
              </div>
            </div>
          </div>
        </div>
        <div id="tab_printed<?= $rec->ProductID ?>" class="tab-pane tabprinted" role="tabpanel">
          <div class="price_promise_div" style="margin-top: 10px;margin-right: 2px;">
            <div class="col-md-8 pull-right">
              <h5><a data-toggle="tooltip-product" data-placement="top" class="" title="" data-original-title="If within 7 days of buying this printed roll label product from us, you find the same product cheaper to purchase online at any other UK label website, we will refund 100% of the difference in the printing price." href="javascript:void(0);"> <img src="<?= aalables_path ?>images/check-circle.png" class="circle-icon"/>Lowest Prices<br/>
                <span>Guaranteed Online</span><i class="fa fa-info-circle"></i> </a> </h5>
            </div>
          </div>
          <div class="row" style="width: 100%;float: right;">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                    <input maxlength="7" type="text" placeholder="Enter Labels" class="form-control allownumeric printlabels" style="height: 34px;font-size: 12px;border: 1px solid #cccccc;">
                      <small>Minimum labels  100 </small>
                      </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right: 0px;padding-left: 0px;">
                      <div class="dm-box">
                        <div class="btn-group btn-block dm-selector digital_proccess-d-down"> <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" style="font-size: 12px;">Select Digital Print Process <i class="fa fa-unsorted"></i></a>
                          <ul class="dropdown-menu btn-block">
                            <li><a data-toggle="tooltip-digital" data-value="" data-trigger="hover" data-placement="left" title="" data-id="digital">Select Digital Print Process </a> </li>
                            <?php
                                                            foreach ($a4_prints as $row) {
                                                                $white_digital_style = '';
                                                                $white_digital = '6 Colour Digital Process';
                                                                if (preg_match("/PGCP/is", $rec->ManufactureID) || preg_match("/PGCR/is", $rec->ManufactureID)) {
                                                                    if ($white_digital == $row->name) {
                                                                        $white_digital_style = ' display:none; ';
                                                                    }
                                                                } ?>
                            <li style=" <?= $white_digital_style ?>"><a data-toggle="tooltip-digital" data-trigger="hover" data-placement="right" title="<?= $row->tooltip_info ?>" data-id="digital" data-value="<?= $row->name ?>">
                              <?= $row->name ?>
                              </a></li>
                            <? } ?>
                          </ul>
                        </div>
                      </div>

                  </div>

              </div>
              <div class="clear" style="height: 10px;"></div>
              <div class="row">


                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;" >
                      <div class="dm-box">
                        <div class="btn-group btn-block dm-selector"><a style="font-size: 12px;" 
                                                        class="btn btn-default btn-block dropdown-toggle orientationselector"
                                                        data-toggle="dropdown" data-value="">Orientation 01<i
                                                            class="fa fa-unsorted"></i></a>
                          <ul class="dropdown-menu btn-block">
                            <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                                      data-id="orientation1"
                                                                                      data-value="1"> Orientation 01 <img src="<?= aalables_path ?>images/loader.gif"> </a></li>
                            <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                      data-id="orientation2"
                                                                                      data-value="2"> Orientation 02 <img src="<?= aalables_path ?>images/loader.gif"></a></li>
                            <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                                      data-id="orientation3"
                                                                                      data-value="3"> Orientation 03 <img src="<?= aalables_path ?>images/loader.gif"></a></li>
                            <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                                      data-trigger="hover"
                                                                                      data-placement="right"
                                                                                      title="Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label of first."
                                                                                      data-id="orientation4"
                                                                                      data-value="4"> Orientation 04 <img src="<?= aalables_path ?>images/loader.gif"></a></li>
                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                                     data-id="orientation5"
                                                                                     data-value="5"> Orientation 05 <img
                                                                    src="<?= aalables_path ?>images/loader.gif"></a> </li>
                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                                     data-id="orientation6"
                                                                                     data-value="6"> Orientation 06 <img
                                                                    src="<?= aalables_path ?>images/loader.gif"> </a> </li>
                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first."
                                                                                     data-id="orientation7"
                                                                                     data-value="8"> Orientation 07 <img
                                                                    src="<?= aalables_path ?>images/loader.gif"> </a> </li>
                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                                     data-trigger="hover"
                                                                                     data-placement="right"
                                                                                     title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                                     data-id="orientation8"
                                                                                     data-value="8"> Orientation 08 <img
                                                                    src="<?= aalables_path ?>images/loader.gif"></a> </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 labels-form" style="padding-left: 0px; padding-right: 0px;">
                      <label class="select">
                        <select name="finish" class="labelfinish" style="font-size: 12px;border: 1px solid #cccccc;">
                          <option selected="selected" value="">Select Label Finish</option>
                          <option value="No Finish">No Finish</option>
                          <option value="Gloss Lamination">Gloss Lamination</option>
                          <option value="Matt Lamination">Matt Lamination</option>
                          <option value="Gloss Varnish">Gloss Varnish</option>
                          <option value="High Gloss Varnish">High Gloss Varnish (Not
                          Over-Printable) </option>
                          <option value="Matt Varnish">Matt Varnish</option>
                        </select>
                        <i></i> </label>

                  </div>
              </div>
                <div class ="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12" style="padding-right: 0px;
                         padding-left: 0px;">
											<a href="#" style="margin-top: 10px !important;" class="btn btn-primary art-btn btn-block artwork_uploader artwork_uploader_roll"
                                                                                           data-target=".artworkModal1"
                                                                                           data-toggle="modal"
                                                                                           data-original-title="Upload Your Artwork"> <i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;
                                                Click here to Upload Your Artwork</a></div>
              </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 quotation" style="margin-left:-15px";>
              
              <!-- <div class="clear15"></div>-->
              <div class="printedprice_box" style="display:none;">
                <table class="price" width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr class="printprice" style="">
                      <td style=" width:80%;" class="text-left phead"></td>
                      <td style=" width:20%;" class="printtext text-right color-orange"></td>
                    </tr>
                    <tr class="inkprice" style="">
                      <td style=" width:80%;" class="text-left phead">Full Colour Print Price</td>
                      <td style=" width:20%;" class="printtext text-right color-orange">0.00</td>
                    </tr>
                    <tr class="halfprintprice" style="">
                      <td style=" width:80%;" class="text-left phead color-orange">Print Price
                        Promotion </td>
                      <td style=" width:20%;" class="halfprinttext color-orange text-right">-<b
                                                        class="pr-sm">0.00</b></td>
                    </tr>
                    <tr class="labelfinishprice" style="">
                      <td style=" width:80%;" class="text-left phead ">Label Finish Price</td>
                      <td style=" width:20%;" class="labelfinishtext color-orange text-right"> 0.00 </td>
                    </tr>
                    <tr class="pressproofprice" style="">
                      <td style=" width:80%;" class="text-left phead">Press Proof Charges</td>
                      <td style=" width:20%;" class="pressprooftext text-right color-orange"></td>
                    </tr>
                    <tr class="additionalcharge" style="">
                      <td style=" width:80%;" class="text-left phead"> Additional Charges</td>
                      <td style=" width:20%;" class="desginprice text-right color-orange"><b
                                                        class="pr-sm"></b></td>
                    </tr>
                    <tr class="additionalrolls" style="">
                      <td colspan="2" class="text-left phead">3 additional rolls</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="text-right total" style="border:none;"><div class="text-right printedprice_text priceplain">&nbsp;</div>
                        <div class="clearfix"></div></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="text-right"><div class="printedperlabels_text"></div></td>
                    </tr>
                  </tbody>
                </table>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
              <button style="display:none;" class="btn orangeBg pull-right add_printed_roll"
                                        type="button"> Add to basket<i class="fa fa-calculator"></i></button>
              <button class="btn orangeBg pull-right calculate_printed_roll" type="button"> Calculate
              Price <i class="fa fa-calculator"></i></button>
              <div class="clearfix"></div>
              <!--<a href="#" class="price_breakss pull-right"
                                               data-target=".pbreaks" data-toggle="modal" data-original-title="Volume Price Breaks">View volume price breaks</a>--> 
              
            </div>
          </div>
        </div>
        <div id="tab_sample<?= $rec->ProductID ?>" class="tab-pane" role="tabpanel">
          <div class="col-md-9 float-right m-t-t-10"> <small class="sample"> All material samples are supplied on a strip of roll labels for the
            purpose of assisting the choice of face-stock colour and appearance. Along with
            assessing the print quality and application suitability of the adhesive. </small>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12"> <small class="note sample">Please note: The material sample supplied will not be the
                shape and size of the label/s shown on this page. </small>
                <div class="clearfix"></div>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6"></div>
              <div class="col-lg-4 col-md-4 col-sm-3 col-xs-6">
                <button class="btn orangeBg pull-right rsample_roll" type="button">Add Material
                Sample </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<? } ?>
<script>


    function showPrintOption(val){
        $('#main_tab_printed'+val).addClass('active');
        $('#main_tab_plain'+val).removeClass('active');
        $('#tab_plain'+val).removeClass('active show');
        $('#tab_printed'+val).addClass('active show');
    }

    function printed_labels(_this)
    {
        //$(_this).parents('.mainContainer').find('.aa_loader').show();
        var _this = $(_this);

        var no_of_labels = $(_this).parents('.mainContainer').find('.plainsheet_input').val();
        var available_in = $(_this).parents('.mainContainer').find('.available_in').val();
        var type = $(_this).parents('.mainContainer').find('.type').val();
        var email = $(_this).parents('.mainContainer').find('.email').val();
        var material = $(_this).parents('.mainContainer').find('.material').val();
        var color = $(_this).parents('.mainContainer').find('.color').val();
        var shape = $(_this).parents('.mainContainer').find('.shape').val();
        var min_width = $(_this).parents('.mainContainer').find('.min_width').val();
        var max_width = $(_this).parents('.mainContainer').find('.max_width').val();
        var min_height = $(_this).parents('.mainContainer').find('.min_height').val();
        var max_height = $(_this).parents('.mainContainer').find('.max_height').val();

        var ColourMaterial_upd = $(_this).parents('.mainContainer').find('.ColourMaterial_upd').val();
        var adhesive = $(_this).parents('.mainContainer').find('.adhesive').val();



        var no_of_rolls = $(_this).parents('.mainContainer').find('.plainrolls').val();


        if(no_of_rolls == 1)
        {
            if(no_of_labels < 150 )
            {
                no_of_labels = 150;
                var input_labels = $(_this).parents('.mainContainer').find('.plainsheet_input');
                show_faded_popover(input_labels, 'Quantity has been amended for production as '+no_of_labels+' labels.');

                $(_this).parents('.mainContainer').find('.plainsheet_input').val(no_of_labels);
                $(_this).parents('.mainContainer').find('.plainlabels').val(no_of_labels);
                return false;
            }
        }

        if(no_of_labels > 1000000)
        {
            no_of_labels = 1000000;
        }

        var selected_size = $(_this).parents('.mainContainer').find('.selected_size').val();

        var productcode = $(_this).parents('.mainContainer').find('.manfactureid').val();
        var type = $(_this).parents('.mainContainer').find('.type').val();
        //alert(productcode);
        //var productcode = $(_this)('.manfactureid').val();

        var dieCode = $(_this).parents('.mainContainer').find('.dieCode').val();
        var source = $(_this).parents('.mainContainer').find('.source').val();
        var CategoryID = $(_this).parents('.mainContainer').find('.CategoryID').val();


        //var coresize = "R"+$("#coresize").val();
        var coresize = $("#coresize").val();
        var woundoption = $("#woundoption").val();

        dieCode = dieCode+coresize;
        selected_size = selected_size;

        $.ajax({
            url: mainUrl + 'ajax/addPrintingPreferences_cart_page',
            type: "POST",
            async: "false",
            dataType: "html",
            beforeSend: function() {
                $(_this).parents('.mainContainer').find('.aa_loader').show();
            },
            data: {
                shape: shape,
                min_width: min_width,
                max_width: max_width,
                min_height: min_height,
                max_height: max_height,
                no_of_labels: no_of_labels,
                productcode: productcode,
                no_of_rolls:no_of_rolls,
                dieCode: dieCode,
                coresize:coresize,
                source: source,
                woundoption:woundoption,
                email: email,
                selected_size: selected_size,
                available_in: available_in,
                material: material,
                color: color,
                adhesive: adhesive,
                type: type,
                CategoryID: CategoryID,
                ColourMaterial_upd: ColourMaterial_upd
            },
            success: function (data) {
                if(data)
                {
                    //document.location = "<?php //echo base_url();?>//material-printed-labels/";
                    document.location = "<?php echo base_url();?>new_print_service/";
                }
                $(_this).parents('.mainContainer').find('.aa_loader').hide();
            }
        });
    }
</script>