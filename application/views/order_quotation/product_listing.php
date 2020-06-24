<style>
    .compare_div button[enable] {
        padding: 7px;
        margin-top: 6px;
        margin-left: 22px;
    }
</style>

<div class="row dm-row margin-adjust-raw">
    



    <?php

    // echo "<pre>";
    //print_r($results);
    // echo "</pre>";
    $priceFrom = 0;
    $i = 1;
    foreach ($results as $pro) {
        $zoomeffect = 'on';
        $dmclass = '';
        $imgpath = '';
        $labelsizefont = '';
        if (preg_match("/-/", $pro->ProductName)) {

            $name = explode(" - ", $pro->ProductName);

            $productname = ucwords($name[0]) . "";
            if (isset($name[1]) and $name[1] != '') {
                $productname .= " <small>" . $name[1] . "</small>";
            }


        } else {
            $name = explode(" &#45; ", $pro->ProductName);
            // $productname = ucwords($productname[0])." <br /> <small> ".$productname[1]."</small>";
            $productname = ucwords($name[0]) . " <br />";
            if (isset($name[1]) and $name[1] != '') {
                $productname .= " <small>" . $name[1] . "</small>";
            }
        }


        if (preg_match("/Roll/", $pro->ProductBrand)) {
            if ($i % 4 == 0) {
                $dmclass = 'last-child';
            }

            $labelSize = str_replace("Roll Labels", "", $pro->CategoryName);

            $labelSize = explode("-", $pro->ProductCategoryName);
            $labelSize = end($labelSize);
            $labelSize = str_replace("label size ", "", $labelSize);
            $labelSize = explode("(", $labelSize);
            $labelSize = $labelSize[0];
            $labelSize = str_replace("Circle", "Diameter", $labelSize);
            $img_src = aalables_path . "images/categoryimages/RollLabels/outside/" . strtoupper($pro->ManufactureID) . ".jpg";
            //if(!getimagesize($img_src)) {
            //	$img_src = Assets."images/categoryimages/rollimages/".$pro->CategoryImage;
            //	}

            if (preg_match("/search/", uri_string())) {
                $width = '';
                $height = '160';
            } else {
                //$width = '200';
                //$height = '205';
                $width = '';
                $height = '';
            }

            $descrption = "Labels on Rolls - " . $pro->Shape;
            //$price = $this->home_model->get_min_labels_price($pro->ManufactureID);
            $price = 13.55;
            $price = $this->home_model->currecy_converter($price, 'yes');


            $price_text = 'From <strong class="f-20 textBlue">' . symbol . $price . '</strong> per 1 Roll';
            $pro->ManufactureID = substr($pro->ManufactureID, 0, -1);

            //$url = base_url() . 'roll-labels/' . strtolower($pro->Shape) . '/' . strtolower($pro->CategoryID) . '?productid=' . $pro->ProductID;

            $url = 'onclick=getMaterialPage('."'".strtolower($pro->Shape)."'".','."'".strtolower($pro->CategoryID)."'".','."'".strtolower($pro->ProductID)."'".')';

            $zoomeffect = '';


        }


        else if (preg_match("/SRA3/", $pro->ProductBrand)) {


            // $img_src = Assets."images/categoryimages/SRA3Sheets/".$pro->CategoryImage;
            $img_src = aalables_path . "images/categoryimages/SRA3Sheets/colours/" . $pro->ManufactureID . ".png";
            $imgpath = aalables_path . "images/categoryimages/SRA3Sheets/colours/" . $pro->ManufactureID . '.png';

            $width = '208';
            $height = '148';
            $sheet = '50';
            $descrption = "SRA3 Labels - " . $pro->LabelsPerSheet . " " . $pro->Shape;

          

            $ProductCategoryName = explode("-", $pro->ProductCategoryName);
            $cnt = count($ProductCategoryName) - 1;
            $labelSize = $ProductCategoryName[$cnt];
            unset($ProductCategoryName[$cnt]);
            $price_text = 'From <strong class="f-20 textBlue">' . symbol . $priceFrom . '</strong> per ' . $sheet . ' sheets';

         
            $url = 'onclick=getMaterialPage('."'".strtolower($pro->Shape)."'".','."'".strtolower($pro->CategoryID)."'".','."'".strtolower($pro->ProductID)."'".')';
        }


        else if (preg_match("/A3/", $pro->ProductBrand)) {


            //$img_src = Assets."images/categoryimages/A3Sheets/".$pro->CategoryImage;
            $img_src = aalables_path . "images/categoryimages/A3Sheets/colours/" . $pro->ManufactureID . ".png";
            $imgpath = aalables_path . "images/categoryimages/A3Sheets/colours/" . $pro->ManufactureID . '.png';

            $width = '208';
            $height = '148';
            $sheet = '25';
            $descrption = "A3 Sheet Labels - " . $pro->LabelsPerSheet . " " . $pro->Shape;

            //$priceFrom = $this->product_model->batchPrice25($pro->ManufactureID,$sheet);

            //$priceFrom = $this->home_model->currecy_converter($priceFrom, 'yes');


            $ProductCategoryName = explode("-", $pro->ProductCategoryName);
            $cnt = count($ProductCategoryName) - 1;
            $labelSize = $ProductCategoryName[$cnt];
            unset($ProductCategoryName[$cnt]);
            $price_text = 'From <strong class="f-20 textBlue">' . symbol . $priceFrom . '</strong> per ' . $sheet . ' sheets';

            // $url = base_url().'home/material/'.$pro->CategoryID.'/'.$pro->ProductID;
            //$url = base_url() . 'a3-sheets/' . strtolower($pro->Shape) . '/' . strtolower($pro->CategoryID) . '?productid=' . $pro->ProductID;
            $url = 'onclick=getMaterialPage('."'".strtolower($pro->Shape)."'".','."'".strtolower($pro->CategoryID)."'".','."'".strtolower($pro->ProductID)."'".')';

        }    else if (preg_match("/A5/", $pro->ProductBrand)) {


           
            $img_src = aalables_path . "images/categoryimages/A5Sheets/colours/" . $pro->ManufactureID . ".png";
            $imgpath = aalables_path . "images/categoryimages/A5Sheets/colours/" . $pro->ManufactureID . '.png';

            $width = '208';
            $height = '148';
            $sheet = '25';
            $descrption = "A5 Sheet Labels - " . $pro->LabelsPerSheet . " " . $pro->Shape;

            //$priceFrom = $this->product_model->batchPrice25($pro->ManufactureID,$sheet);

            //$priceFrom = $this->home_model->currecy_converter($priceFrom, 'yes');


            $ProductCategoryName = explode("-", $pro->ProductCategoryName);
            $cnt = count($ProductCategoryName) - 1;
            $labelSize = $ProductCategoryName[$cnt];
            unset($ProductCategoryName[$cnt]);
            $price_text = 'From <strong class="f-20 textBlue">' . symbol . $priceFrom . '</strong> per ' . $sheet . ' sheets';

            // $url = base_url().'home/material/'.$pro->CategoryID.'/'.$pro->ProductID;
            //$url = base_url() . 'a3-sheets/' . strtolower($pro->Shape) . '/' . strtolower($pro->CategoryID) . '?productid=' . $pro->ProductID;
            $url = 'onclick=getMaterialPage('."'".strtolower($pro->Shape)."'".','."'".strtolower($pro->CategoryID)."'".','."'".strtolower($pro->ProductID)."'".')';

        }

        else if (preg_match("/Integrated Labels/", $pro->ProductBrand)) {
            $image = str_replace('WTP', '.png', $pro->ManufactureID);
            $img_src = aalables_path . "images/categoryimages/Integrated/" . $image;
            $width = 'auto';
            $height = 'auto';
            $sheet = '100';
            $descrption = $pro->Shape . " Label";
            // $priceFrom = $this->product_model->batchPrice25($pro->ManufactureID,$sheet);

            //$priceFrom = $this->home_model->currecy_converter($priceFrom, 'yes');


            //$labelSize = preg_replace('/Label Size: /','',$pro->specification3);
            //$labelSize = preg_replace('/width /i','',$labelSize);
            //$labelSize = preg_replace('/height/i','',$labelSize);


            $ProductCategoryName = explode("-", $pro->ProductCategoryName);
            $cnt = count($ProductCategoryName) - 1;
            $labelSize = $ProductCategoryName[$cnt];
            unset($ProductCategoryName[$cnt]);


            $sizearay = explode(',', $labelSize);

            if (count($sizearay) > 2) {
                $labelSize = $sizearay[0] . ' , ' . $sizearay[1] . "<br />";
                $labelSize .= $sizearay[2];
            }

            $labelSize = implode("<br/>", $sizearay);

            $labelSize = (int)$pro->Width . " mm x " . (int)$pro->Height . " mm";
            //$url = $pro->CategoryID;

            $url = 'onclick=getIntegratedDetail('."'".$pro->CategoryID."'".')';
            // $price_text = 'From <strong class="f-20 textBlue">&pound;'.$priceFrom.'</strong> per '.$sheet.' Box';
            $price_text = '';
            $zoomeffect = '';

        }

        else {

            // $img_src = Assets."images/categoryimages/A4Sheets/".$pro->CategoryImage;
            $img_src = aalables_path . "images/categoryimages/A4Sheets/colours/" . $pro->ManufactureID . ".png";
            $imgpath = aalables_path . "images/categoryimages/A4Sheets/colours/" . $pro->ManufactureID . '.png';

            $width = '125';
            $height = '176';
            $sheet = '25';
            $descrption = "A4 Sheet Labels - " . $pro->LabelsPerSheet . " " . $pro->Shape;

            //$priceFrom = $this->product_model->batchPrice25($pro->ManufactureID,$sheet);

            //$priceFrom = $this->home_model->currecy_converter($priceFrom, 'yes');


            $ProductCategoryName = explode("-", $pro->ProductCategoryName);
            $cnt = count($ProductCategoryName) - 1;
            $labelSize = $ProductCategoryName[$cnt];

            $labelSize = '<small>' . $labelSize . '</small>';


            unset($ProductCategoryName[$cnt]);
            $price_text = 'From <strong class="f-20 textBlue">' . symbol . $priceFrom . '</strong> per ' . $sheet . ' sheets';
            //$url = base_url().'home/material/'.$pro->CategoryID.'/'.$pro->ProductID;

            //$url = base_url() . 'a4-sheets/' . strtolower($pro->Shape) . '/' . strtolower($pro->CategoryID) . '?productid=' . $pro->ProductID;
            $url = 'onclick=getMaterialPage('."'".strtolower($pro->Shape)."'".','."'".strtolower($pro->CategoryID)."'".','."'".strtolower($pro->ProductID)."'".')';
        }


        $labelSize = str_replace("mm", "", $labelSize);
        $labelSize = str_replace("Label Size", "", $labelSize);
        $labelSize = str_replace("label size", "", $labelSize);
        $labelSize = str_replace("/label Size/is", "", trim($labelSize));


        if (strpos($labelSize, '/') !== false) {

            $labelSize = str_replace('<small>', '', $labelSize);
            $labelSize = str_replace('</small>', '', $labelSize);

            $LabelSizeArray = explode("/", $labelSize);
            if (isset($LabelSizeArray[0]) and $LabelSizeArray[0] != '') {
                $labelSize = $LabelSizeArray[0];
            }
        }


        if (substr($pro->ManufactureID, -2, 2) == 'XS') {
            $url = base_url() . 'christmas-labels/';
        }

        $wholesale_class = '';
        $show_price_class = '';
        $get_btn_txt = 'Get Price';
        if (isset($wholesale) and $wholesale != '') {
            $url = 'javascript:void(0);';
            $wholesale_class = 'wholesale_class';
            $get_btn_txt = 'Get Quote';
            $show_price_class = 'hide';

        }

        ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3   dm-box <?= $dmclass ?>">
            <div class="thumbnail">
                <? if ($zoomeffect == 'on' and 1 == 2) { ?>
                    <div class="zoom">
                        <p><a href="#" data-toggle="modal" data-target=".layout" imgpath="<?= $imgpath ?>"
                              class="layout_specs" id="<?= $pro->CategoryID ?>"> <i
                                        class="fa fa-search-plus zoomIcon"></i> </a></p>
                    </div>
                <? } ?>
                <div class="imgBg  text-center">
                    <img width="<?= $width  ?>" height="<?= $height  ?>" alt="labels Image " src="<?= $img_src  ?>">




                </div>

                <div class="caption">
                    <? if ($zoomeffect == 'on') { ?>
                        <p class="label_layout text-center">
                            <a href="#" data-toggle="modal" data-target=".layout"  class="layout_specs" id="<?= $pro->CategoryID ?>">View Label Layout</a></p>
                    <? } ?>

                    <?
                    if(!preg_match("/Roll/",$pro->ProductBrand)):
                        ?>
                    <h2 style="font-size: 14px !important;font-weight: bold !important;color: #17b1e3;line-height: normal">
                        <?= $productname ?>
                    </h2>
                    <? else:?>
                        <p><a href="#" data-toggle="modal" data-target=".registration_mark" id="<?=$pro->CategoryID?>" class="registration_modal_link" data-shape="<?=strtolower($pro->Shape)?>" data-productid="<?=$pro->ProductID?>">View Registration Mark Option</a></p>
                    <? endif;?>
                    <p>
                        <?= $descrption ?>
                    </p>
                    <div class="row">
                        <p class="col-md-7"><strong>Label Size (mm)</strong><br>
                            <?= $labelSize ?>
                        </p>
                        <p class="col-md-5 p0"><strong>Item Code</strong><br>
                            <span class="diecode">
              <?= $pro->ManufactureID ?>
              </span></p>
                        <!--<p class="col-md-12 <?= $show_price_class ?>"> <?= $price_text ?> </p>-->
                    </div>
                    <?

                    if (preg_match("/Roll/", $pro->ProductBrand)) {
                        $get_btn_txt = 'View Prices';
                    }


                    if (preg_match("/Roll/", $pro->ProductBrand) and 1 == 2) {

                        $get_btn_txt = 'View Prices';

                        ?>
                        <div class="row">
                            <div class="labels-form  col-md-12">
                                <div class="btn-group btn-block dm-selector"><a id="coresize_<?= $pro->ProductID ?>"
                                                                                class="btn btn-default btn-block dropdown-toggle coresize loadcoresize"
                                                                                data-cat-id="<?= $pro->CategoryID ?>"
                                                                                data-man-id="<?= $pro->ManufactureID ?>"
                                                                                data-toggle="dropdown"
                                                                                data-value="">Core Size <i
                                                class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block ">
                                        <li><img src="<?= aalables_path ?>images/loader.gif" class="image"></li>
                                        <? //$this->home_model->genrate_rollcore_images_finder($pro->CategoryID, $pro->ManufactureID);
                                        ?>
                                    </ul>
                                </div>
                                <div class="clear5"></div>
                            </div>
                            <div class="col-md-12">
                                <?
                                $wholesale_class = 'roll-core';
                                if (isset($wholesale) and $wholesale != '') {

                                    $wholesale_class = 'wholesale_class';
                                } ?>

                                <a id="<?= $pro->CategoryID ?>" data-cat-id="<?= $pro->CategoryID ?>"
                                   data-attr="<?= $pro->ProductID ?>" data-prd-id="<?= $pro->ProductID ?>"
                                   href="#"  <?=$url?>class="btn orange btn-block <?= $wholesale_class ?>"
                                   role="button">
                                    <?= $get_btn_txt ?>
                                </a></div>
                        </div>
                    <? } else { ?>
                        <a href="#" <?=$url?>
                           data-cat-id="<?= $pro->CategoryID ?>"
                           data-prd-id="<?= $pro->ProductID ?>"
                           class="btn btn-outline-primary waves-light waves-effect width-select  <?= $wholesale_class ?>"
                           role="button"> <i class="fa fa-arrow-circle-right"></i>
                            <?= $get_btn_txt ?>
                        </a>
                    <? } ?>
                    <? //if(!preg_match("/Roll/",$pro->ProductBrand)){?>


                    <div class="compare_div labels-form clearfix m-t-10 row"
                         style="<?= (isset($search_page) and $search_page == 'enabled') ? 'display:none' : '' ?>">
                        <div class="col-md-1 col-xs-2">
                            <label class="checkbox">
                                <? if (preg_match("/Roll/", $pro->ProductBrand)) {
                                    $pro->ManufactureID = $pro->ManufactureID . "1";
                                }
                                ?>
                                <input name="compare_check" class="textOrange approve"
                                       value="<?= $pro->ManufactureID ?>" type="checkbox"/>
                                <i></i></label>
                        </div>
                        <div class="col-md-1 col-xs-2 no-border">
                        </div>
                        <div class="col-md-10 col-xs-9 float-right">
                            <button class="btn orangeBg btn-block compare_btn" disabled="disabled" data-type="product"
                                    style="padding: 7px;margin-top: 6px;">Compare
                            </button>
                        </div>
                    </div>







                    <? //} ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <? $i++;
    } ?>
</div>
<div class="spinner" style="display:none;text-align:center;"><img src="<?= Assets ?>images/loader-spinner.gif"
                                                                  style="width:60px;"/>
    <h3>Please Wait...</h3>
</div>
