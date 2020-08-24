<input type="hidden" id="arwork_type_on_page" value="a4">

<?
$productid = (isset($_GET['productid']) and $_GET['productid'] != '') ? $_GET['productid'] : '';
$a4_prints = $this->home_model->get_digital_printing_process('A4');
$compatibility = $this->filter_model->get_compatibility_text('sheet');
$free_delivery_orders = symbol . $this->home_model->currecy_converter(25.00, 'no');
$each_design_price = symbol . $this->home_model->currecy_converter(DesignPrice, 'yes');
$print_compatible_array = array();

foreach ($compatibility as $com) {
    $com->print_method = str_replace(" ", "", trim($com->print_method));
    $com->type = str_replace(" ", "", trim($com->type));
    $print_compatible_array[$com->print_method][$com->type] = $com->description;
}

/*echo '<pre>';
print_r($materials); exit;*/

foreach ($materials as $rec) {
    if (preg_match("/A3/", $rec->ProductBrand)) {
        $min_qty = '100';
        $max_qty = '100000';
        $type = 'A3';
    } else if (preg_match("/SRA3/", $rec->ProductBrand)) {
        $min_qty = '100';
        $max_qty = '20000';
        $type = 'SRA3';
    } else if (preg_match("/A5/", $rec->ProductBrand)) {
        $min_qty = '25';
        $max_qty = '100000';
    } else {
        $min_qty = '25';
        $max_qty = '100000';
        $type = 'A4';
    }
    $condition = " type LIKE '" . $type . "' AND finish_type LIKE '" . $rec->LabelFinish . "' AND material_type LIKE '" . $rec->ColourMaterial . "'";
    $colours = $this->home_model->grouping_material_colours($condition);
    $grouped_adhesive = $this->home_model->grouping_material_adhesive($condition);
    $cryogenic = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Cryogenic');
    $freezer = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Freezer');
    $heatrest = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Heat Resistant');
    $hightack = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'High Tack');
    $permanent = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Permanent');
    $removable = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Peelable');
    $sealable = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Resealable');
    $superperm = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Super Permanent');
    $waterres = $this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Water Resistant');
    $keys = array_keys($colours);
    $last = end($keys);

    if (isset($colours[$last]->LabelColor) and $colours[$last]->LabelColor != $rec->LabelColor and count($colours) > 1 and empty($productid)) {
        $condition = " LabelFinish LIKE '" . $rec->LabelFinish . "' AND ColourMaterial LIKE '" . $rec->ColourMaterial . "' 
				AND LabelColor LIKE '" . trim($colours[$last]->LabelColor) . "' AND CategoryID LIKE '" . $rec->CategoryID . "' 
				AND Adhesive LIKE '" . $rec->Adhesive . "'";
        $result = $this->db->query("Select * from products where $condition LIMIT 1")->result();
        if (count($result) > 0) {
            //$rec = $result[0];
        }
    }

    if (preg_match("/PETC/", $rec->ManufactureID) || preg_match("/PETH/", $rec->ManufactureID) || preg_match("/PVUD/", $rec->ManufactureID)) {
        //$min_qty = '25';
        $min_qty = '5';
        $max_qty = '5000';
    }
    $available_in_type = '';
    if (preg_match("/SRA3/", $rec->ProductBrand)) {
        $img_path = "SRA3Sheets";
        //$mat_image = Assets."images/categoryimages/".$img_path."/".$details['CategoryImage'];
        $mat_image = aalables_path . "images/categoryimages/" . $img_path . "/colours/" . $rec->ManufactureID . ".png";
        $available_in_type = 'SRA3';
    } else if (preg_match("/A3/", $rec->ProductBrand)) {
        $img_path = "A3Sheets";
        //$mat_image = Assets."images/categoryimages/".$img_path."/".$details['CategoryImage'];
        $mat_image = aalables_path . "images/categoryimages/" . $img_path . "/colours/" . $rec->ManufactureID . ".png";
        $available_in_type = 'A3';
    } else if (preg_match("/A5/", $rec->ProductBrand)) {
        $img_path = "A5Sheets";
        $mat_image = aalables_path . "images/categoryimages/" . $img_path . "/colours/" . $rec->ManufactureID . ".png";
        $available_in_type = 'A5';
    } else {
        $img_path = "A4Sheets";
        $mat_image = aalables_path . "images/categoryimages/" . $img_path . "/colours/" . $rec->ManufactureID . ".png";
        $available_in_type = 'A4';
    }
    $material_code = $this->home_model->getmaterialcode($rec->ManufactureID);
    $diecode = $this->home_model->getdiecode($rec->ManufactureID);
    $materialinfo = $this->db->query("Select tooltip_info,short_name,group_name, adhesive
			from material_tooltip_info WHERE material_code LIKE '" . $material_code . "'")->row_array();

    $adhesive = (isset($materialinfo['adhesive']) and $materialinfo['adhesive'] != '') ? $materialinfo['adhesive'] : '';


    $desc = (isset($materialinfo['tooltip_info']) and $materialinfo['tooltip_info'] != '') ? $materialinfo['tooltip_info'] : '';
    $rec->Material1 = (isset($materialinfo['short_name']) and $materialinfo['short_name'] != '') ? $materialinfo['short_name'] : '';
    $group_name = (isset($materialinfo['group_name']) and $materialinfo['group_name'] != '') ? $materialinfo['group_name'] : '';
    $max_length = 200;
    if (strlen($desc) > $max_length) {
        $offset = ($max_length - 3) - strlen($desc);
        $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
        $short_desc .= ' <a style="cursor:pointer;" data-toggle="tooltip-product" data-placement="top" data-original-title="' . $desc . '"><i>Read More</i></a>';
    } else {
        $short_desc = $desc;
    }

    $promotion = '';
    $promotional_discount = '';
    $promotion_filter = "no";
    /*if (preg_match("/A4 Labels/is", $rec->ProductBrand) and ( preg_match("/WPEP/i", $rec->ManufactureID))) {
          $promotion =' <br /> <strong style="color:#fd4913"> Special Offer Save 20% While Stocks Last </strong> ';
          $promotion_filter = "yes";
    }*/
    $comp = $this->filter_model->grouping_compatiblity($rec->SpecText7, $print_compatible_array);
    //if (preg_match("/A4 Labels/is", $rec->ProductBrand))
    //{
    $mat_code = $this->home_model->getmaterialcode($rec->ManufactureID);
    $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
    if ($material_discount) {
        $promotional_discount = ' <br /> <strong style="color:#fd4913"> Black Friday & Cyber Monday Offer Save ' . $material_discount . '% on Plain Labels</strong> ';
        //$promotional_discount = ' <br /> <strong style="color:#fd4913"> Special Offer Save '.$material_discount.'% While Stocks Last </strong> ';
        $promotion_filter = "yes";
    }
    //}
    ?>

    <style>
        .priceplain b {
            font-size: 15px !important;
            color: #333 !important;
        }
        .orangeBg {
            margin-top: 0px;
        }
    </style>
    <section data-mat-filters="<?= $rec->ColourMaterial ?>" data-reset="reset"
             data-promotion="<?= $promotion_filter ?>">
        <div class="row productdetails mainContainer" data-value="<?= $rec->ProductID ?>" data-finish="<?= $rec->LabelFinish ?>"
             data-material="<?= $rec->ColourMaterial ?>">
            <div class="hiddenfields">
                <input type="hidden" value="" class="cart_id"/>
                <input type="hidden" value="<?= $rec->ProductID ?>" class="product_id"/>
                <input type="hidden" value="<?= $rec->ManufactureID ?>" class="manfactureid"/>
                <input type="hidden" name="dieCode" class="dieCode" value="<?= $diecode; ?>">
                <input type="hidden" value="<?= $rec->LabelsPerSheet ?>" class="LabelsPerSheet"/>
                <input type="hidden" value="" id="digital" class="digitalprintoption gets_d<?= $rec->ManufactureID ?>"/>
                <input type="hidden" value="<?= $min_qty ?>" class="minimum_quantities"/>
                <input type="hidden" value="<?= $max_qty ?>" class="maximum_quantities"/>
                <input type="hidden" value="<?= $rec->Printable ?>" class="PrintableProduct"/>
                <input type="hidden" value="<?= $rec->ProductCategoryName ?>" class="category_description"/>

                <input type="hidden" value="0" data-qty="0" id="uploadedartworks_<?= $rec->ProductID ?>"/
                style="position: absolute; z-index:500; ">

                <input type="hidden" value="0" data-qty="0" id="no_artworks_<?= $rec->ProductID ?>"/ style="position:
                absolute; z-index: 500; left: 250px;">





                <input type="hidden" name="type" class="type" value="<?php echo $available_in_type;?>">
                <input type="hidden" name="source" class="source" value="material_page">
                <input type="hidden" name="available_in" class="available_in" value="<?php echo $available_in_type; ?>">
                <input type="hidden" name="material" class="material" value="<?php echo $rec->ColourMaterial_upd;?>">
                <input type="hidden" name="adhesive" class="adhesive" value="<?php echo $adhesive;?>">
                <input type="hidden" name="color" class="color" value="<?php echo $rec->Material1;?>">
                <?php
                if(strpos($rec->CategoryID, 'R', -2) !== false){
                    $Category_ID = substr($rec->CategoryID, 0, -2);
                }else{
                    $Category_ID = $rec->CategoryID;
                }
                $selected_size = $Category_ID;
                ?>
                <input type="hidden" name="CategoryID" class="CategoryID" value="<?php echo $Category_ID;?>">
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
                        <!-- --><? /*= $promotional_discount */ ?>
                    </font></div>
                <div class="clear"></div>
                <div class="row specs">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <img class="img-responsive product_material_image" src="<?= $mat_image ?>"
                             style="cursor: crosshair;">
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-10 col-xs-9">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                <div class="labels-form">
                                    <label class="select no-margin">
                                        <select class="product_adhesive">
                                            <option value="" disabled="disabled" selected="selected">Select Adhesive
                                            </option>
                                            <option <?= $cryogenic ?>
                                                <?= ($rec->Adhesive == 'Cryogenic') ? 'selected="selected"' : '' ?>
                                                    value="Cryogenic">Cryogenic
                                            </option>
                                            <option <?= $freezer ?>
                                                <?= ($rec->Adhesive == 'Freezer') ? 'selected="selected"' : '' ?>
                                                    value="Freezer">Freezer
                                            </option>
                                            <option <?= $heatrest ?>
                                                <?= ($rec->Adhesive == 'Heat Resistant') ? 'selected="selected"' : '' ?>
                                                    value="Heat Resistant"> Heat Resistant
                                            </option>
                                            <option <?= $hightack ?>
                                                <?= ($rec->Adhesive == 'High Tack') ? 'selected="selected"' : '' ?>
                                                    value="High Tack">High Tack
                                            </option>
                                            <option <?= $permanent ?>
                                                <?= ($rec->Adhesive == 'Permanent') ? 'selected="selected"' : '' ?>
                                                    value="Permanent">Permanent
                                            </option>
                                            <option <?= $removable ?>
                                                <?= ($rec->Adhesive == 'Peelable') ? 'selected="selected"' : '' ?>
                                                    value="Peelable">Peelable
                                            </option>
                                            <option <?= $sealable ?>
                                                <?= ($rec->Adhesive == 'Resealable') ? 'selected="selected"' : '' ?>
                                                    value="Resealable">Re-sealable
                                            </option>
                                            <option <?= $superperm ?>
                                                <?= ($rec->Adhesive == 'Super Permanent') ? 'selected="selected"' : '' ?>
                                                    value="Super Permanent">Super Permanent
                                            </option>
                                            <option <?= $waterres ?>
                                                <?= ($rec->Adhesive == 'Water Resistant') ? 'selected="selected"' : '' ?>
                                                    value="Water Resistant">Water Resistant
                                            </option>
                                        </select>
                                        <i></i> </label>
                                </div>
                            </div>
                        </div>
                        <div class="clear10"></div>
                        <div class="row" style="margin-bottom:10px">

                            <div class="col-md-6"><a href="#" id="<?= $rec->ProductID ?>" class="technical_specs"
                                                     data-target=".material" data-toggle="modal"
                                                     data-original-title="Technial Specification">Material Specification
                                    <i class="fa fa-info-circle"></i></a></div>

                            <div class="col-md-6"><a href="#" id="<?= $group_name ?>" class="applications"
                                                     data-target=".lb_applications" data-toggle="modal"
                                                     data-original-title="Tecnial Specification">Label Applications <i
                                            class="fa fa-table" aria-hidden="true"></i> </a></div>
                        </div>
                        <div class="clear10"></div>
                        <ul class="clr-thumbs colourpicker">
                            <? foreach ($colours as $row) {
                                $active_colour = '';
                                $colourclass = strtolower(str_replace(" ", "_", $row->LabelColor));
                                $colourclass = strtolower(str_replace("-", "_", $colourclass));
                                if ($row->LabelColor == $rec->LabelColor) {
                                    $active_colour = 'active';
                                }
                                $colour_icon = aalables_path . 'images/material_images/colours/sheets/' . $row->imagecode . '.png';
                                ?>
                                <li class="<?= $active_colour ?> data-reset-colour" data-toggle="tooltip"
                                    data-placement="bottom"
                                    data-original-title="<?= $row->colour_name ?>"
                                    data-colour-filters="<?= $row->LabelColor ?>"><a class="mat_<?= $colourclass ?>"
                                                                                     data-value="<?= $row->LabelColor ?>"
                                                                                     href="javascript:void(0);">
                                        <img class="img-responsive" src="<?= $colour_icon ?>" alt="Matt White Paper">
                                    </a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comp">
                        <table class="table printer" border="0" style="border:none;">
                            <tbody>
                            <tr>
                                <td align="left" style="font-size:12px; border:none; width: 20%;text-align: right;">
                                </td>
                                <td align="left" style="font-size:12px; border:none; width: 20%;text-align: right;">
                                    Laser <a
                                            data-toggle="tooltip-product" data-placement="top" class="laser_printer_div"
                                            title="" data-original-title="<?= $comp['laser_text'] ?>"
                                            href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                                    <img class="laser_printer_img" width="50"
                                         src="https://www.aalabels.com/theme/site/images/<?= $comp['laser_img'] ?>">
                                </td>
                                <td align="left" style=" font-size:12px;border:none;"> Inkjet <a
                                            data-toggle="tooltip-product" data-placement="top" title=""
                                            class="inkjet_printer_div" data-original-title="<?= $comp['inkjet_text'] ?>"
                                            href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                                    <img class="inkjet_printer_img" width="50"
                                         src="https://www.aalabels.com/theme/site/images/<?= $comp['inkjet_img'] ?>">
                                </td>
                                <td align="left"
                                    style=" font-size:12px;border:none;visibility:hidden;display:none;">
                                    Direct<br/>
                                    <!--Thermal <a data-toggle="tooltip-product" data-placement="top" title="" class="direct_printer_div"  data-original-title="<?= $comp['d_thermal_text'] ?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br />
                  <img class="direct_printer_img" width="50" src="<?= Assets ?>images/<?= $comp['d_thermal_img'] ?>"  />-->
                                </td>
                                <td align="left" style=" font-size:12px;border:none;width:60%; visibility:hidden"><!--Thermal<br />
                  Transfer <a data-toggle="tooltip-product" data-placement="top" title="" class="thermal_printer_div" data-original-title="<?= $comp['thermal_text'] ?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br />
                  <img class="thermal_printer_img" width="50" src="<?= Assets ?>images/<?= $comp['thermal_img'] ?>"  />--></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>

            <article class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mat-tabs">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li class="nav-item ">
                        <a href="#tab_plain<?= $rec->ProductID ?>" id="main_tab_plain<?= $rec->ProductID ?>"
                           aria-controls="" role="tab" data-toggle="tab"
                           class="nav-link active">Plain Labels</a>
                    </li>
                    <li class="nav-item" <?php if ($rec->Printable == 'N') { ?> style="display:none;" <?php } ?>>
                        <!--<a href="#tab_printed<?/*= $rec->ProductID */?>" id="main_tab_printed<?/*= $rec->ProductID */?>"
                           aria-controls="" role="tab" data-toggle="tab"
                           class="nav-link">Printed Labels</a>-->
                        <a href="javascript:;" class="nav-link btn btn-block addprintBtn add_plain1" onclick="printed_labels(this);"> Add Print </a>
                    </li>
                    <li class="nav-item">
                        <a href="#tab_sample<?= $rec->ProductID ?>" id="main_tab_sample<?= $rec->ProductID ?>"
                           aria-controls="" role="tab" data-toggle="tab"
                           class="nav-link">Material Sample</a>
                    </li>
                </ul>

                <style>
                    .mat-may-2017 section article.mat-tabs .nav {
                        margin-bottom: 40px;
                    }
                </style>

                <div class="tab-content">
                    <div id="tab_plain<?= $rec->ProductID ?>" class="tab-pane tabplain active" role="tabpanel">
                        <?php if ($rec->EuroID): ?>
                            <div class="price_promise_div" style="padding: 23px 36px 0px 0px;">
                                <div class="col-md-8 pull-right">
                                    <h5><a data-toggle="tooltip-product" data-placement="top" class="" title=""
                                           data-original-title="If within 7 days of buying this Dry Edge product sheet from us, you find the same product cheaper to purchase online at any other UK label website, we will refund 100% of the difference."
                                           href="javascript:void(0);"> <img
                                                    src="<?= Assets ?>images/check-circle.png"
                                                    class="circle-icon"/>Lowest Prices<br/>
                                            <span>Guaranteed Online</span><i class="fa fa-info-circle"></i> </a>
                                    </h5>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                        <div class="row" style="    margin-top: 25px !important;width: 100%;margin: 0px auto;">
                            <div class="quotation"></div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center qty input-field">
                                    <div class="input-group">
                                        <input class="form-control text-center allownumeric plainsheet_input"
                                               data-toggle="popover" data-content="" placeholder="Enter Sheets"
                                               type="text">
                                        <div class="input-group-btn">
                                            <button type="button"
                                                    class="btn btn-default dropdown-toggle plainsheet_unit"
                                                    style="border-radius: 0px;height: 38px;" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">Sheets <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right plain_calculation_unit"
                                                style="padding: 10px;">
                                                <li><a href="javascript:void(0);" style="color: #666;">Sheets</a></li>
                                                <li><a href="javascript:void(0);" style="color: #666;">Labels</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="small_plain_minqty_txt col-xs-6">Minimum order
                                                <?= $min_qty ?>
                                                sheets
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="col-xs-6 text-center"><a href="#" class="price_breaks"
                                                                                   data-target=".pbreaks"
                                                                                   data-toggle="modal"
                                                                                   data-original-title="Volume Price Breaks">View
                                                    volume price breaks</a></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 quotation">
                                <!---------- Price Promise -------------->
                                <!---------- Price Promise end-------------->
                                <!--<div class="plainprice_box" style="display:none">
                                  <div class="text-right plainprice_text priceplain">&nbsp;</div>
                                  <div class="clear="></div>
                                  <div class="clear"></div>
                                  <span class="pull-right plainperlabels_text">&nbsp;</span>
                                  <div class="clear5"></div>
                                </div>-->
                                <div class="plainprice_box" style="display:none; margin-top: 0px;">
                                    <table class="price" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr class="plainprice">
                                            <td style=" width:80%;" class="text-left"></td>
                                            <td style=" width:20%;" class="original_price text-right color-orange"></td>
                                        </tr>
                                        <tr class="halfprintprice" style="">
                                            <td style=" width:80%;" class="text-right phead color-orange"><span
                                                        class="percentage_discount">25</span>% Off Promotion
                                            </td>
                                            <td style=" width:20%;"
                                                class="promotion_price color-orange text-right"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right total" style="border:none;">
                                                <div class="text-right plainprice_text priceplain">&nbsp;</div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right">
                                                <div class="plainperlabels_text"></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn orangeBg pull-right calculate_plain" type="button"> Calculate Price
                                    <i class="fa fa-calculator"></i></button>
                                <button style="display:none;" class="btn orangeBg pull-right add_plain" type="button">
                                    Add to basket <i class="fa fa-calculator"></i></button>
                            </div>
                        </div>
                        <div class="col-xs-12 service text-right addprintingoption" style="display: none">
                            <a href="#" onclick="showPrintOption(<?= $rec->ProductID ?>)" aria-controls="" role="tab"
                               data-toggle="tab" class="apf printpriceoffer"
                               style="position: relative;left: -13px;top: 5px;">
                                <!--<i class="fa fa-hand-o-right pull-left" aria-hidden="true"></i> --><span
                                        style="color:red;text-decoration:underline;font-size:12px;">Add printing for only <b
                                            class="printing_offer_text">
                                            <?= symbol ?>16.59</b>?</span> </a>
                        </div>
                        <div class="col-lg-12 ofq ofqs row">
                            <div class="col-lg-4 main-box">
                                <div class="row">
                                    <div class="col-lg-1 no-padding-right ofq-icon"><img
                                                src="<?= Assets ?>images/4oclock.png"/></div>
                                    <div class="col-lg-10  no-padding-right ofq-text material_clock">
                                        <div class="counter clock_time">Order before 16:00 for Next Day Delivery
                                        </div>
                                        <div class="clear"></div>
                                        <small style="font-size:8px;">Time remaining to next day delivery</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 main-box">
                                <div class="row">
                                    <div class="col-lg-1 no-padding-right ofq-icon"><i class="fa fa-truck l-icon"
                                                                                       aria-hidden="true"></i></div>
                                    <div class="col-lg-10  no-padding-right ofq-text"><b>Free Delivery on Orders
                                            over
                                            <?= $free_delivery_orders ?>
                                        </b> </br><a style="font-size:7px;" target="_blank"
                                                     href="https://www.aalabels.com/delivery/"><span
                                                    class="glyphicon glyphicon-new-window"></span> Delivery &
                                            Shipping Options</a></div>
                                </div>
                            </div>
                            <div class="col-lg-4 main-box">
                                <div class="row">
                                    <div class="col-lg-1 no-padding-right ofq-icon"><img
                                                src="<?= Assets ?>images/check-circle.png"
                                                class="circle-icon-small" style="height: 21px;width: 21px;"/></div>
                                    <div class="col-lg-10  no-padding-right ofq-text"><b>QUALITY ASSURANCE
                                            GUARANTEE</b></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab_printed<?= $rec->ProductID ?>" class="tab-pane tabprinted" role="tabpanel">
                        <!---------- Price Promise -------------->
                        <?php if ($rec->EuroID) {
                            $tooltip_msg = 'If within 7 days of buying this printed Dry Edge product sheet from us, you find the same product cheaper to purchase online at any other UK label website, we will refund 100% of the difference.';
                        } else {
                            $tooltip_msg = 'If within 7 days of buying this printed product sheet from us, you find the same product cheaper to purchase online at any other UK label website, we will refund 100% of the difference in the printing price.';
                        } ?>
                        <div class="price_promise_div" style="padding: 23px 36px 0px 0px;">
                            <div class="col-md-8 pull-right">
                                <h5><a data-toggle="tooltip-product" data-placement="top" class="" title=""
                                       data-original-title="<?= $tooltip_msg ?>" href="javascript:void(0);">
                                        <img src="<?= Assets ?>images/check-circle.png" class="circle-icon"/>Lowest
                                        Prices<br/>
                                        <span>Guaranteed Online</span><i class="fa fa-info-circle"></i> </a>
                                </h5>
                            </div>
                        </div>
                        <!---------- Price Promise end -------------->
                        <div class="row" style="width: 100%;float: right;">
                            <div class="col-xs-12">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center qty">
                                        <div class="input-group">
                                            <input class="form-control text-center allownumeric printedsheet_input"
                                                   data-toggle="popover" data-content="" placeholder="Enter Sheets"
                                                   type="text">
                                            <div class="input-group-btn">
                                                <button type="button"
                                                        class="btn btn-default dropdown-toggle printedsheet_unit"
                                                        style="border-radius: 0px;height: 38px;"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Sheets <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right print_calculation_unit"
                                                    style="padding: 10px;">
                                                    <li><a href="javascript:void(0);" style="color: #666;">Sheets</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" style="color: #666;">Labels</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="small_plain_minqty_txt col-xs-6">Minimum order
                                                    <?= $min_qty ?>
                                                    sheets
                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="col-xs-6 text-center"><a href="#" class="price_breaks"
                                                                                       data-target=".pbreaks"
                                                                                       data-toggle="modal"
                                                                                       data-original-title="Volume Price Breaks">View
                                                        volume price breaks</a></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-t-15">
                                        <div class="dm-box">
                                            <div class="btn-group btn-block dm-selector digital_proccess-d-down" style="margin:20px 0px;">
                                                <a class="btn btn-default btn-block dropdown-toggle"
                                                        data-toggle="dropdown">Select Digital Print Process <i
                                                            class="fa fa-unsorted"></i></a>
                                                <ul class="dropdown-menu btn-block" style="z-index: 0;padding: 10px;">
                                                    <li>
                                                        <a data-toggle="tooltip-digital" data-value=""
                                                           data-trigger="hover" data-placement="left" title=""
                                                           data-id="digital"> Select Digital Print Process </a></li>
                                                    <?php
                                                    foreach ($a4_prints as $row) { ?>
                                                        <li>
                                                            <a data-toggle="tooltip-digital" data-trigger="hover"
                                                               data-placement="right" title="<?= $row->tooltip_info ?>"
                                                               data-id="digital" data-value="<?= $row->name ?>">
                                                                <?= $row->name ?>
                                                            </a>
                                                        </li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-block art-btn artwork_uploader"
                                           style="margin-top: 0px !important;"
                                           data-target=".artworkModal1" data-toggle="modal"
                                           data-original-title="Upload Your Artwork"> <i class="fa fa-cloud-upload"
                                                                                         aria-hidden="true"></i>&nbsp;
                                            Click here to Upload Your Artwork</a></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 quotation">
                                <div class="printedprice_box"
                                     style="display:none;    margin-right: 14px;margin-bottom: 14px;">
                                    <table class="price" width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr class="plainprice">
                                            <td style=" width:80%;" class="text-left">Plain</td>
                                            <td style=" width:20%;" class="plaintext text-right color-orange"></td>
                                        </tr>
                                        <tr class="printprice" style="">
                                            <td style=" width:80%;" class="text-left phead"></td>
                                            <td style=" width:20%;" class="printtext text-right color-orange"></td>
                                        </tr>
                                        <tr class="halfprintprice" style="">
                                            <td style=" width:80%;" class="text-left phead color-orange">Full Price
                                                Print Promotion
                                            </td>
                                            <td style=" width:20%;" class="halfprinttext color-orange text-right"></td>
                                        </tr>
                                        <tr class="no_design" style="">
                                            <td colspan="2" class="text-left phead">3 Design Free</td>
                                        </tr>
                                        <tr class="desgincharge" style="">
                                            <td style=" width:80%;" class="text-left phead"> Additional Designs
                                                <?= $each_design_price ?>
                                                each
                                            </td>
                                            <td style=" width:20%;" class="desginprice text-right color-orange"><b
                                                        class="pr-sm"></b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right total" style="border:none;">
                                                <div class="text-right printedprice_text priceplain">&nbsp;</div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right">
                                                <div class="printedperlabels_text"></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="clear10"></div>
                                </div>
                                <span class="float-right">
                                <button style="display:none;margin-right: 5px;"
                                        class="btn orangeBg pull-right add_printed" type="button">
                                    Add to basket <i class="fa fa-calculator"></i></button>

                                <button class="btn orangeBg pull-right calculate_printed" type="button"
                                        style="margin-right: 5px;"> Calculate Price
                                    <i class="fa fa-calculator"></i></button>
																	</span>
                            </div>
                        </div>
                    </div>
                    <div id="tab_sample<?= $rec->ProductID ?>" class="tab-pane" role="tabpanel">
                        <div class="col-md-10 float-right ">
                            <small> All material samples are supplied on A4 sheets for the purpose of assisting the
                                choice of face-stock colour and appearance. Along with assessing the print quality and
                                application suitability of the adhesive.
                            </small>
                            <div class="clear10"></div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                    <small class="note">Please note: The material sample supplied will not be the shape
                                        and size of the label/s shown on this page.
                                    </small>
                                    <div class="clear5"></div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6"></div>
                                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-6">
                                    <button class="btn orangeBg pull-right rsample" type="button">Add Material Sample
                                    </button>
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
    $(document).ready(function () {
        $(".nav-justified-special").click(function () {
            $(".nav-justified-special").removeClass("active");
            $(this).addClass("active");
        });
    });

    function showPrintOption(val) {
        $('#main_tab_printed' + val).addClass('active');
        $('#main_tab_plain' + val).removeClass('active');
        $('#tab_plain' + val).removeClass('active show');
        $('#tab_printed' + val).addClass('active show');
    }

    function printed_labels(_this)
    {
        $(_this).parents('.mainContainer').find('.aa_loader').show();
        var _this = $(_this);

        var no_of_labels = $(_this).parents('.mainContainer').find('.plainsheet_input').val();

        var Printable = $(_this).parents('.mainContainer').find('.PrintableProduct').val();
        var id = $(_this).parents('.mainContainer').find('.product_id').val();
        var menuid = $(_this).parents('.mainContainer').find('.manfactureid').val();
        var labels = $(_this).parents('.mainContainer').find('.LabelsPerSheet').val();
        var min_qty = parseInt($(_this).parents('.mainContainer').find('.minimum_quantities').val());
        var max_qty = parseInt($(_this).parents('.mainContainer').find('.maximum_quantities').val());
        var input_id = $(_this).parents('.mainContainer').find('.plainsheet_input');
        var qty = parseInt(input_id.val());
        var unitqty = $(_this).parents('.mainContainer').find('.plainsheet_unit').text(); //Sheets Labels

        unitqty = $.trim(unitqty);
        if (unitqty == 'Labels') {
            var min_qty = parseInt(labels) * min_qty;
            var max_qty = parseInt(labels) * max_qty;
        }
        if (!is_numeric(qty) || qty == '' || qty < min_qty) {
            input_id.val(min_qty);
            if (unitqty == "Labels") {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' labels.');
            } else {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + min_qty + ' sheets.');
            }
            qty = parseInt(input_id.val());
        }

        if (qty > max_qty) {
            input_id.val(max_qty);
            if (unitqty == 'Labels') {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' labels.');
            } else {
                show_faded_popover(input_id, 'Quantity has been amended for production as ' + max_qty + ' sheets.');
            }
            qty = parseInt(input_id.val());
        }


        if (qty % labels != 0 && unitqty == 'Labels') {
            var multipyer = parseInt(labels) * parseInt(parseInt(qty / labels) + 1);
            input_id.val(multipyer);
            var qty = multipyer;
        }
        if (unitqty == 'Labels') {
            no_of_labels = parseInt(qty / labels);
        }
        else if (unitqty == 'Sheets') {
            no_of_labels = parseInt(qty);
        }

        var selected_size = $(_this).parents('.mainContainer').find('.selected_size').val();
        var available_in = $(_this).parents('.mainContainer').find('.available_in').val();
        var type = $(_this).parents('.mainContainer').find('.type').val();
        var email = $(_this).parents('.mainContainer').find('.email').val();
        var material = $(_this).parents('.mainContainer').find('.material').val();
        var color = $(_this).parents('.mainContainer').find('.color').val();
        var adhesive = $(_this).parents('.mainContainer').find('.adhesive').val();
        var shape = $(_this).parents('.mainContainer').find('.shape').val();
        var min_width = $(_this).parents('.mainContainer').find('.min_width').val();
        var max_width = $(_this).parents('.mainContainer').find('.max_width').val();
        var min_height = $(_this).parents('.mainContainer').find('.min_height').val();

        var source = $(_this).parents('.mainContainer').find('.source').val();

        var max_height = $(_this).parents('.mainContainer').find('.max_height').val();


        var productcode = $(_this).parents('.mainContainer').find('.manfactureid').val();
        //var productcode = $(_this).parents('.mainContainer').find('.productcode').val();

        var dieCode = $(_this).parents('.mainContainer').find('.dieCode').val();

        $.ajax({

            url: mainUrl + 'ajax/addPrintingPreferences',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {
                shape: shape,
                min_width: min_width,
                max_width: max_width,
                min_height: min_height,
                max_height: max_height,
                no_of_labels: no_of_labels,
                productcode: productcode,
                dieCode: dieCode,

                source: source,

                email: email,
                selected_size: selected_size,
                available_in: available_in,
                material: material,
                color: color,
                adhesive: adhesive,
                type: type
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