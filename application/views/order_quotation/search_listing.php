<style>
    .margin-adjust-raw{
        margin-left: -25px;
        margin-right: -25px;
    }
    .compare_div button[enable] {
        padding: 7px;
        margin-top: 6px;
        margin-left: 22px;
    }
    .m-t-10{
        margin-top:5px;
    }

</style>
<div class="row margin-adjust-raw">
    <?
    $i = 1;
    $DL_EnhancedEcomerce = '';
    foreach ($records['list'] as $pro) {
        $fixedclass = '';
        $dmclass = '';
        $code = explode('.', $pro->CategoryImage);
        if (preg_match("/Roll/", $pro->CategoryName)) {
            if ($i % 4 == 0) {
                $dmclass = 'last-child';
            }
            $Paper_size = "Labels on Rolls";
            $LabelSize = str_replace("Roll Labels", "", $pro->CategoryName);

            $LabelSize = str_replace("Circle", "Diameter", $LabelSize);

            //$img_src = Assets."images/categoryimages/rollimages/".$pro->CategoryImage;
            $img_src = aalables_path . "images/categoryimages/RollLabels/" . $code[0] . ".jpg";
            /*if(!getimagesize($img_src))
            {
                $img_src = Assets."images/categoryimages/rollimages/".$pro->CategoryImage;
            }*/
            if (preg_match("/search/", uri_string())) {
                $width = '';
                $height = '230';
                $fixedclass = 'heightFix';
            } else {
                $width = '';
                $height = '';
                $custom_class = 'roll_custom';
            }
            $catname = $pro->CategoryName;
            $url = 'roll-labels';

            $starting_ecom_price = '85.17';

        } else if (preg_match("/SRA3/", $pro->CategoryName)) {

            $pro->CategoryImage = str_replace('.png', 'WTP.png', $pro->CategoryImage);

            $Paper_size = "SRA3 Sheets";
            $img_src = aalables_path . "images/categoryimages/SRA3Sheets/colours/" . $pro->CategoryImage;
            $width = '208';
            $height = '148';

            $x = explode("-", $pro->CategoryName);
            $catname = $x[0];
            $LabelSize = $x[1];

            $url = 'sra3-sheets';
            $starting_ecom_price = '28.30';

        } else if (preg_match("/A3/", $pro->CategoryName)) {

            $pro->CategoryImage = str_replace('.png', 'WTP.png', $pro->CategoryImage);
            $Paper_size = "A3 Sheets";
            $img_src = aalables_path . "images/categoryimages/A3Sheets/colours/" . $pro->CategoryImage;
            $width = '208';
            $height = '148';

            $x = explode("-", $pro->CategoryName);
            $catname = $x[0];
            $LabelSize = $x[1];

            $url = 'a3-sheets';
            $starting_ecom_price = '28.30';
        } else if (false !== strpos($pro->CategoryName, "A5")) {
            $pro->CategoryImage = str_replace('.png', 'WTP.png', $pro->CategoryImage);
            $Paper_size = "A5 Sheets";
            $img_src = aalables_path . "images/categoryimages/A5Sheets/colours/" . $pro->CategoryImage;
            $width = '210';
            $height = '148.5';

            $x = explode("-", $pro->CategoryName);
            $catname = $x[0];
            $LabelSize = $x[1];

            $url = 'a5-sheets';
            $starting_ecom_price = '7.55';

        } else {
            $pro->CategoryImage = str_replace('.png', 'WTP.png', $pro->CategoryImage);
            $Paper_size = "A4 Sheets";
            $img_src = aalables_path . "images/categoryimages/A4Sheets/colours/" . $pro->CategoryImage;
            $width = '125';
            $height = '176';

            $x = explode("-", $pro->CategoryName);
            $catname = $x[0];
            $LabelSize = $x[1];

            $url = 'a4-sheets';
            $starting_ecom_price = '7.55';

        }

        if (preg_match("/searchResults/", uri_string())) {
            $fixedclass = 'heightFix';
        }


        $LabelSize = str_replace("mm", "", $LabelSize);
        $LabelSize = str_replace("Label Size", "", $LabelSize);
        $LabelSize = str_replace("label size", "", $LabelSize);
        $LabelSize = str_replace("/label Size/is", "", trim($LabelSize));


        if (strpos($LabelSize, '/') !== false) {
            $LabelSizeArray = explode("/", $LabelSize);
            if (isset($LabelSizeArray[0]) and $LabelSizeArray[0] != '') {
                $LabelSize = "<span title='" . $LabelSize . "'>" . $LabelSizeArray[0] . " <i title='" . $LabelSize . "' class='fa fa-info-circle textBlue'></i>  <span>";
            }
        }
        $url = base_url() . $url . '/' . strtolower($pro->Shape) . '/' . strtolower($pro->CategoryID) . '/'; ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3  dm-box <?= $dmclass ?>">
            <div class="thumbnail">
<!--                --><?// if (!preg_match("/Roll/", $pro->CategoryName) and 1 == 2) { ?>
<!--                    <div class="zoom">-->
<!--                        <p><a href="#" data-toggle="modal" data-target=".layout" class="layout_specs"-->
<!--                              id="--><?//= $pro->CategoryID ?><!--"> <i class="fa fa-search-plus zoomIcon"></i> </a></p>-->
<!--                    </div>-->
<!--                --><?// } ?>
                <div class="imgBg <?= $fixedclass ?> text-center">

                    <!--<img src="<?/*= $img_src */?>" alt="<?/*= $catname */?>" title="<?/*= $catname */?>" width="<?/*= $width */?>" height="<?/*= $height */?>">-->
                    <img src="<?=$img_src?>" alt="<?=$catname?>" title="<?=$catname?>" width="125" height="176">

                </div>

                <div class="caption">
                    <? if(!preg_match("/Roll/",$pro->CategoryName)){?>
                        <p class="label_layout"><a href="#" data-toggle="modal" data-target=".layout"  class="layout_specs" id="<?=$pro->CategoryID?>"> View Label Layout</a></p>
                    <? }?>
                    <?
                    if(!preg_match("/Roll/",$pro->CategoryName)):
                        ?>
                        <h2>
                            <?=$Paper_size;?>
                        </h2>
                    <? else:?>
                        <p><a href="#" data-toggle="modal" data-target="#myModal<?=$i?>" id="<?=$pro->CategoryID?>" class="" data-shape="<?=strtolower($pro->Shape)?>">View Registration Mark Option</a></p>
                    <? endif;?>
                    <p>
                        <?=$catname?>
                    </p>
                    <div class="row">
                        <p class="<?=(preg_match("/Roll/",$pro->CategoryName))?'col-md-8':'col-md-9'?> col-sm-8"><strong>Label Size (mm)</strong><br>
                            <?=$LabelSize?>
                            <? $tooltip_title = "";
                            if(($pro->InnerHole) || ($pro->InnerLabel)):
                                if($pro->Shape == "Circular"){$tooltip_title .= $LabelSize = str_replace(".00","",$pro->Width)." mm Diameter";} else {$tooltip_title .= $LabelSize . " mm";}
                                if($pro->InnerHole):
                                    $tooltip_title .= "<br>" . $pro->InnerHole . " Diameter (Inner Hole)";
                                endif;
                                if($pro->InnerLabel):
                                    $tooltip_title .= "<br>" . $pro->InnerLabel . " Diameter (Inner Label)";
                                    ?>
                                <? endif;?>
                                <a data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="<?=$tooltip_title?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a>
                            <? endif;?>
                        </p>
                        <p  class="<?=(preg_match("/Roll/",$pro->CategoryName))?'col-md-4':'col-md-3'?> col-sm-4"><strong>Code</strong><br>
                            <span class="diecode">
              <?=$code[0]?>
              </span> </p>
                    </div>
                    <?
                    if (preg_match("/Roll/", $pro->CategoryName)) {
                        ?>
                        <input type="hidden" name="search_view" value="category"/>
                    <? }
                    if (preg_match("/Roll/", $pro->CategoryName) and 1 == 2) { ?>
                        <input type="hidden" name="search_view" value="category"/>
                        <div class="labels-form">
                            <div class="btn-group btn-block dm-selector"><a id="coresize_<?= $pro->CategoryID ?>"
                                                                            class="btn btn-default btn-block dropdown-toggle coresize loadcoresize"
                                                                            data-cat-id="<?= $pro->CategoryID ?>"
                                                                            data-man-id="<?= $pro->CategoryID ?>"
                                                                            data-toggle="dropdown" data-value="">Core
                                    Size <i class="fa fa-unsorted"></i></a>
                                <ul class="dropdown-menu btn-block ">
                                    <li><img src="<?= aalables_path ?>images/loader.gif" class="image"
                                             alt="AA Labels Loader"></li>
                                </ul>
                            </div>
                            <div class="clear5"></div>
                        </div>
                        <div class="clear15"></div>
                        <? $wholesale_class = 'set-printer';
                        if (isset($wholesale) and $wholesale != '') {
                            $url = 'javascript:void(0);';
                            $wholesale_class = 'wholesale_class';
                        }
                        ?>
                        <a data-prd-id="roll" data-cat-id="<?= $pro->CategoryID ?>" id="<?= $pro->CategoryID ?>"
                           role="button" class="btn btn-outline-primary waves-light waves-effect width-select <?= $wholesale_class ?>"
                           href="#" onclick="getMaterialRollPage('<?= $pro->Shape ?>','<?= $pro->CategoryID ?>')">
                            <i class="fa fa-arrow-circle-right"></i> Select Material </a>
                    <? }
                    else {
                        $wholesale_class = '';
                        if (isset($wholesale) and $wholesale != '') {
                            $url = 'javascript:void(0);';
                            $wholesale_class = 'wholesale_class';
                        }


                        ?>
                        <?php if($pageName == 'quotation' || $pageName == 'order'){?>
                        <a  data-cat-id="<?= $pro->CategoryID ?>" data-prd-id="" id="<?= $pro->CategoryID ?>"
                           role="button" class="btn btn-outline-primary waves-light waves-effect width-select od_detail <?= $wholesale_class ?>" href="#"
                           onclick="getOrderDetailMaterialPage('<?= $pro->Shape ?>','<?= $pro->CategoryID ?>','<?=$pageName?>')"> <i  class="fa fa-arrow-circle-right "></i> Select Material </a>
                        <?php }else{?>

                        <a data-cat-id="<?= $pro->CategoryID ?>" data-prd-id="" id="<?= $pro->CategoryID ?>"
                           role="button" class="btn btn-outline-primary waves-light waves-effect width-select od_not_detail <?= $wholesale_class ?>" href="#"
                           onclick="getMaterialPage('<?= $pro->Shape ?>','<?= $pro->CategoryID ?>')"> <i
                                    class="fa fa-arrow-circle-right "></i> Select Material </a>
                          <?php }?>
                    <? } ?>
                    <?/* if(!preg_match("/Roll/",$pro->CategoryName)){*/
                    ?>
                    <div class="compare_div labels-form clearfix m-t-10 row"
                         style="<?= (isset($search_page) and $search_page == 'enabled') ? 'display:none' : '' ?>">
                        <div class="col-md-1 col-xs-2">
                            <label class="checkbox">
                                <input name="compare_check" class="textOrange approve"
                                       value="<?= $pro->CategoryID ?>" type="checkbox"/>
                                <i></i></label>
                        </div>

                        <div class="col-md-1 col-xs-2 no-border">
                        </div>



                        <div class="col-md-10 col-xs-9 float-right">
                            <button class="btn orangeBg btn-block compare_btn" disabled="disabled" style="padding: 7px;margin-top: 6px;">Compare</button>
                        </div>
                    </div>
                   <!-- --><?php /*}
                    */?>
                </div>
            </div>
        </div>
        



 <?     include('regmarkpop.php');   $i++;
    } ?>
</div>

