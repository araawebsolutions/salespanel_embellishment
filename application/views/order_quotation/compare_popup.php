<style>
    .ProductNameH {
        clear: both;
    }

    .catcode {
        padding: 0;
        font-size: 12px;
    }

    .ProductPrice {
        font-size: 22px;
    }

    .compare_table tr td {
        vertical-align: middle !important;
    }

    @media (min-width: 1024px) {
        .modal-lg {
            width: 950px;
        }
    }

    .product_comparison {
        width: 100%;
    }

    .orangeBg {
        margin: 0 !important;
    }

</style>
<div>
    <?php
    $RegMark = '';
    $col_class = "col-md-12 col-sm-12";
    $prod_count = count($catdetails);
    if ($prod_count == 2) {
        $col_class = "col-md-6 col-sm-6";
    } else if ($prod_count == 3) {
        $col_class = "col-md-4 col-sm-4";
    } else if ($prod_count == 4) {
        $col_class = "col-md-3 col-sm-3";
    }

    $LWidth = $LHeight = $LAcross = $LAcross = $LAround = $LTMargin = $LBMargin = $LGAcross = $LGAround = $LLMargin = $LRMargin = $LCRadius = $LCode = $LPrice = $LImage = $LComp = $LPrint = $Button = $type = $LAdhesive = $LDescription = '';

    foreach ($catdetails as $details):
        if ($details['type'] == 'product') {
            $catcode = $details['ManufactureID'];
            $details['productID'] = $this->home_model->get_db_column("products", "ProductID", "ManufactureID", $catcode);
        } else {
            $catcode = explode(".", $details['CategoryImage']);
            $catcode = $catcode[0];
            $details['CategoryImage'] = $catcode;
        }

        if (preg_match("/Roll/", $details['CategoryName'])) {
            if ($details['type'] == 'product') {
                $img_src = Assets . "images/categoryimages/RollLabels/outside/" . $details['ManufactureID'] . ".jpg";
            } else {
                $img_src = Assets . "images/categoryimages/RollLabels/outside/" . $details['CategoryImage'] . "WTP1.jpg";
            }
            $height = 'auto';
            $pop_width = '200';
            $type = 'roll-labels';
            $cat_id = $details['CategoryID'];
            $details['CategoryID'] = $details['CategoryID'] . "R1";
        } else if (preg_match("/SRA3/", $details['CategoryName'])) {
            $img_src = Assets . "images/categoryimages/SRA3Sheets/colours/" . $details['CategoryImage'] . "WTP.png";
            $height = 'auto';
            $pop_width = '200';
            $type = 'sra3-sheets';

            if ($details['type'] == 'product') {
                $img_src = Assets . "images/categoryimages/SRA3Sheets/colours/" . $details['ManufactureID'] . ".png";
                $width = '208';
                $height = 'auto';
            }
        } else if (preg_match("/A5/", $details['CategoryName'])) {
            $img_src = Assets . "images/categoryimages/A5Sheets/colours/" . $details['CategoryImage'] . "WTP.png";
            $height = 'auto';
            $pop_width = '200';
            $type = 'a5-sheets';
            if ($details['type'] == 'product') {
                $img_src = Assets . "images/categoryimages/A5Sheets/colours/" . $details['ManufactureID'] . ".png";
                $width = '208';
                $height = 'auto';
            }
        } else if (preg_match("/A3/", $details['CategoryName'])) {
            $img_src = Assets . "images/categoryimages/A3Sheets/colours/" . $details['CategoryImage'] . "WTP.png";
            $height = 'auto';
            $pop_width = '200';
            $type = 'a3-sheets';
            if ($details['type'] == 'product') {
                $img_src = Assets . "images/categoryimages/A3Sheets/colours/" . $details['ManufactureID'] . ".png";
                $width = '208';
                $height = 'auto';
            }
        } else if (preg_match("/Integrated Labels/", $details['labelCategory'])) {
            $img_src = Assets . "images/categoryimages/Integrated/" . $details['CategoryImage'];
            $type = "integrated-labels";
        } else {
            $img_src = Assets . "images/categoryimages/A4Sheets/colours/" . $details['CategoryImage'] . "WTP.png";
            $pop_width = '189';
            $height = 'auto';
            $type = 'a4-sheets';
            if ($details['type'] == 'product') {
                $img_src = Assets . "images/categoryimages/A4Sheets/colours/" . $details['ManufactureID'] . ".png";
                $width = '125';
                $height = '176';
            }
        }
        if ($details['type'] == 'product') {
            $select_button = "Get Price";

            $url = base_url() . $type . '/' . strtolower($details['Shape']) . '/' . strtolower($details['CategoryID']) . "?productid=" . $details['productID'];

            if ($type == 'roll-labels') {
                $mat_code = $this->home_model->getmaterialcode(substr($details['ManufactureID'], 0, -1));
            } else {
                $mat_code = $this->home_model->getmaterialcode($details['ManufactureID']);
            }


            $mat_desc = $this->home_model->get_db_column('material_tooltip_info', 'tooltip_info', 'material_code', $mat_code);
            if (preg_match("/Integrated Labels/", $details['labelCategory'])) {
                $url = base_url() . $type . '/' . strtolower($details['CategoryID']);
            }
        } else {
            $select_button = "Select Material";
            $url = base_url() . $type . '/' . strtolower($details['Shape']) . '/' . strtolower($details['CategoryID']) . '/';
        }

        $regmarks = "<a href='javascript:void(0);' data-toggle='modal' data-target='.registration_mark' id='" . $cat_id . "' compare='compare' class='registration_modal_link' data-source='modal_modal' data-productid = '" . $details['productID'] . "' data-shape='" . strtolower($details['Shape']) . "'>View Option</a>";

        if ($details['Shape'] == "Oval" || $details['Shape'] == "oval") {
            $details['LabelCorner'] = "N/A";
        }

        $details['LabelCorner'] = str_replace("Round", "", $details['LabelCorner']);
        $details['LabelCorner'] = str_replace("Radius", "", $details['LabelCorner']);


        $min_qty = '';
        if (isset($details['type']) and $details['type'] == 'product'):
            $starting_price = symbol . $details['price'];
        endif;
        if (preg_match("/Roll/", $details['CategoryName'])):
            $min_qty = '<br>' . $min_labels . ' Labels';
        endif;


        $LCode .= "<td>" . $catcode . "</td>";
        $LPrice .= "<td><span class='ProductPrice'>" . $starting_price . "</span> " . vatoption . '. VAT' . $min_qty . "</td>";
        $LWidth .= "<td>" . $details['LabelWidth'] . "</td>";
        $LHeight .= "<td>" . $details['LabelHeight'] . "</td>";
        $LAcross .= "<td>" . $details['LabelAcross'] . "</td>";
        $LAround .= "<td>" . $details['LabelAround'] . "</td>";
        $LTMargin .= "<td>" . $details['LabelTopMargin'] . "</td>";
        $LBMargin .= "<td>" . $details['LabelBottomMargin'] . "</td>";
        $LGAcross .= "<td>" . $details['LabelGapAcross'] . "</td>";
        $LGAround .= "<td>" . $details['LabelGapAround'] . "</td>";
        $LLMargin .= "<td>" . $details['LabelLeftMargin'] . "</td>";
        $LRMargin .= "<td>" . $details['LabelRightMargin'] . "</td>";
        $LCRadius .= "<td>" . $details['LabelCornerRadius'] . "</td>"; //LabelCornerRadius
        $LDescription .= "<td style='text-align:justify;'>" . $mat_desc . "</td>";
        $RegMark .= "<td style='text-align:center;'>" . $regmarks . "</td>";

        $cc = '';
        $comp = explode(',', $details['SpecText7']);
        if ($details['type'] == 'product' and preg_match("/Roll/", $details['CategoryName'])) {
            if (preg_match("/\bInkjet\b/i", $details['SpecText7'])) {
                $cc .= "<i class='fa fa-fw fa-check-circle PrinterIconGreen'></i>Inkjet ";
            } else {
                $cc .= "<i class='fa fa-fw fa-times-circle PrinterIconRed'></i>Inkjet ";
            }

            if (preg_match("/\bDirect Thermal\b/i", $details['SpecText7'])) {
                $cc .= "<i class='fa fa-fw fa-check-circle PrinterIconGreen'></i>Direct Thermal ";
            } else {
                $cc .= "<i class='fa fa-fw fa-times-circle PrinterIconRed'></i>Direct Thermal ";
            }
            if (preg_match("/\bThermal Transfer\b/i", $details['SpecText7'])) {
                $cc .= "<i class='fa fa-fw fa-check-circle PrinterIconGreen'></i>Thermal Transfer ";
            } else {
                $cc .= "<i class='fa fa-fw fa-times-circle PrinterIconRed'></i>Thermal Transfer ";
            }

        } else {
            if (preg_match("/\bLaser\b/i", $details['SpecText7'])) {
                $cc .= "<i class='fa fa-fw fa-check-circle PrinterIconGreen'></i>Laser ";
            } else {
                $cc .= "<i class='fa fa-fw fa-times-circle PrinterIconRed'></i>Laser ";
            }

            if (preg_match("/\bInkjet\b/i", $details['SpecText7'])) {
                $cc .= "<i class='fa fa-fw fa-check-circle PrinterIconGreen'></i>Inkjet ";
            } else {
                $cc .= "<i class='fa fa-fw fa-times-circle PrinterIconRed'></i>Inkjet ";
            }

        }


        $LImage .= "<td><img src='" . $img_src . "' alt='" . $catname . "' title='" . $catname . "' width='" . $pop_width . "' height='" . $height . "' class='m-b-10 design-image' /></td>";
        if ($pageName == 'quotation' || $pageName == 'order') {
            $Button .= '<td><a onclick="getOrderDetailMaterialPage(' . "'" . $details['Shape'] . "'" . ',' . "'" . $details['CategoryID'] . "'" . ',' . "'" . $pageName . "'" . ')"  class="btn-block btn orangeBg" href="#"> <i class="fa fa-arrow-circle-right"></i> ' . $select_button . ' </a>	</td>';
        } else if ($type == "integrated-labels") {

            $Button .= '<td><a onclick="getIntegratedDetail(' . "'" . $details['CategoryID'] . "'" . ')"  class="btn-block btn orangeBg" href="#"> <i class="fa fa-arrow-circle-right"></i> ' . $select_button . ' </a>	</td>';
        } else {
            $Button .= '<td><button onclick="getMaterialPage(' . "'" . $details['Shape'] . "'" . ',' . "'" . $details['CategoryID'] . "'" . ');"  class="btn-block btn orangeBg compare_class_disable" > <i class="fa fa-arrow-circle-right"></i> ' . $select_button . ' </button>	</td>';
        }

        //$LPrint .= "<td><i class='fa fa-check-circle PrinterIconGreen'></i> Laser <br><i class='fa fa-times-circle PrinterIconRed'></i> Inkjet</td>";

        $LPrint .= "<td>" . $cc . "</td>";
        $cc = '';
        if ($details['type'] == "product")
            $adhes = $this->home_model->get_db_column('products', 'Adhesive', 'ManufactureID', $details['ManufactureID']);
        $LAdhesive .= "<td>" . $adhes . "</td>";

    endforeach;

    ?>
    <div class="compare_table clearfix table-responsive">
        <?php if (!preg_match("/Roll/", $details['CategoryName'])):
            $sheets_count = (preg_match("/A4/", $details['CategoryName'])) ? '25' : '100';

            ?>
            <table class="table table-striped table-hover table-bordered text-center">
                <tr>
                    <th>&nbsp;</th>
                    <?= $LImage; ?>
                </tr>
                <?php
                if (isset($details['type']) and $details['type'] == 'product'):
                    ?>
                    <tr>
                        <th><strong>Material Description: </strong></th>
                        <?= $LDescription; ?>
                    </tr>
                    <tr>
                        <th><strong>Adhesive: </strong></th>
                        <?= $LAdhesive; ?>
                    </tr>
                    <tr>
                        <th><strong>Product Code: </strong></th>
                        <?= $LCode; ?>
                    </tr>
                    <tr>
                        <th><strong>Prices From
                                <?= $sheets_count ?>
                                Sheets: </strong></th>
                        <?= $LPrice; ?>
                    </tr>
                    <tr>
                        <th><strong>Printer Compatibility: </strong></th>
                        <?= $LPrint; ?>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><strong>Labels Width: </strong></th>
                    <?= $LWidth; ?>
                </tr>
                <tr>
                    <th><strong>Labels Height: </strong></th>
                    <?= $LHeight; ?>
                </tr>
                <tr>
                    <th><strong>Labels Across: </strong></th>
                    <?= $LAcross; ?>
                </tr>
                <tr>
                    <th><strong>Labels Around: </strong></th>
                    <?= $LAround; ?>
                </tr>
                <tr>
                    <th><strong>Top Margin: </strong></th>
                    <?= $LTMargin; ?>
                </tr>
                <tr>
                    <th><strong>Bottom Margin:</strong></th>
                    <?= $LBMargin; ?>
                </tr>
                <tr>
                    <th><strong>Gap Across: </strong></th>
                    <?= $LGAcross; ?>
                </tr>
                <tr>
                    <th><strong>Gap Around: </strong></th>
                    <?= $LGAround; ?>
                </tr>
                <tr>
                    <th><strong>Left Margin: </strong></th>
                    <?= $LLMargin; ?>
                </tr>
                <tr>
                    <th><strong>Right Margin: </strong></th>
                    <?= $LRMargin; ?>
                </tr>
                <tr>
                    <th><strong>Corner Radius: </strong></th>
                    <?= $LCRadius; ?>
                </tr>
                <tr>
                    <th></th>
                    <?= $Button; ?>
                </tr>
            </table>
        <?php else: ?>
            <table class="table table-striped table-hover table-bordered text-center">
                <tr>
                    <th>&nbsp;</th>
                    <?= $LImage; ?>
                </tr>
                <?php if (isset($details['type']) and $details['type'] == 'product'): ?>
                    <tr>
                        <th><strong>Material Description: </strong></th>
                        <?= $LDescription; ?>
                    </tr>
                    <tr>
                        <th><strong>Adhesive: </strong></th>
                        <?= $LAdhesive; ?>
                    </tr>
                    <tr>
                        <th><strong>Product Code: </strong></th>
                        <?= $LCode; ?>
                    </tr>
                    <tr>
                        <th><strong>Prices From:</strong></th>
                        <?= $LPrice; ?>
                    </tr>
                    <tr>
                        <th><strong>Printer Compatibility: </strong></th>
                        <?= $LPrint; ?>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><strong>Leading Edge: </strong></th>
                    <?= $LWidth; ?>
                </tr>
                <tr>
                    <th><strong>Labels Width: </strong></th>
                    <?= $LWidth; ?>
                </tr>
                <tr>
                    <th><strong>Labels Height: </strong></th>
                    <?= $LHeight; ?>
                </tr>
                <!-- <tr>
        <th><strong>Labels Across: </strong></th>
        <?= $LAcross; ?>
      </tr>
      <tr>
        <th><strong>Labels Around: </strong></th>
        <?= $LAround; ?>
      </tr>
      <tr>
        <th><strong>Gap Across: </strong></th>
        <?= $LGAcross; ?>
      </tr>-->
                <tr>
                    <th><strong>Gap Around: </strong></th>
                    <?= $LGAround; ?>
                </tr>
                <tr>
                    <th><strong>Corner Radius: </strong></th>
                    <?= $LCRadius; ?>
                </tr>

                <? if (preg_match("/Roll/", $details['CategoryName'])): ?>
                    <tr>
                        <th><strong>Registration Mark: </strong></th>
                        <?= $RegMark; ?>
                    </tr>
                <? endif; ?>
                <tr>
                    <th></th>
                    <?= $Button; ?>
                </tr>
            </table>
        <?php endif; ?>

        <div class="row" style="
    margin-top: 20px;
">
            <button type="button" class="btn btn-default closebtn row" data-dismiss="modal" style="
    margin: 0px auto;
    text-align: center;
    ">Close
            </button>
        </div>
    </div>
</div>
<style>
    .closebtn {
        float: right;
        color: #fd4913;
        background-color: #fff;
        border: 1px solid #fd4913;
    }
</style>
