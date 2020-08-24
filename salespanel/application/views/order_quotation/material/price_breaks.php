<?


$double_border = 'border-bottom:1px solid #17b1e3;border-right:1px solid #17b1e3;';

$right_border = 'border-right:1px solid #17b1e3;';

$bottom_border = 'border-bottom:1px solid #17b1e3;';

$border = 'border:1px solid #17b1e3;';

$rowspan = 4;


?>

<table class="table table-striped p-5" style="    border: 1px solid #17b1e3;width: 96%;margin: 0px auto;">

    <tr class="info" height="28">

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;">PRODUCT <br/>(<?= $mid ?>
            )
        </td>

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;"
            align="center" valign="middle">NO. SHEETS
        </td>

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;"
            align="center">NO. LABELS
        </td>

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;"
            align="center">PRICE<br/> PER SHEET
        </td>

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;"
            align="center">PRICE<br/> PER LABEL
        </td>

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;"
            align="center">TOTAL<br/> ex VAT
        </td>

        <td style="background-color: #d9edf7;font-size: 13px;font-weight: bold;border: 1px solid #17b1e3;"
            align="center">TOTAL<br/> inc VAT
        </td>

    </tr>

    <? $i = 1;
    $ProductBrand = $this->home_model->get_db_column('products', 'ProductBrand', 'ManufactureID', $mid);
    $desgin_price = $this->home_model->currecy_converter(DesignPrice, 'no');

    $discount = 0;
    $totalSQM = 0;
    $marginalCost = 0;
    if (isset($ProductBrand) AND trim($ProductBrand) === 'A5 Labels') {
        $areaDifferenceSQM = 0.03267; // Area Difference is the extra area in SQM incurred in A4 Sheet
        $marginDifferenceCost = 0.223; // Margin Difference Cost is the extra cost incurred to manufacturer A4 Sheet
    }
    $j = 1;
    foreach ($breaks as $row) {
        if (isset($ProductBrand) AND trim($ProductBrand) === 'A5 Labels') {
            $discount = $this->product_model->calculate_a5_discount($row->BatchQty);
            $totalSQM = $row->BatchQty * $areaDifferenceSQM;
            $marginalCost = $totalSQM * $marginDifferenceCost;
        }

        $totalprice = $row->BatchQty * $row->SheetPrice;
        $totalprice = $this->home_model->check_price_uplift($totalprice);

        $totalprice = $totalprice - $marginalCost; // Calculation for A5
        $totalprice = $totalprice - ($totalprice * ($discount / 100)); // A5 discount

        $totalprice = $this->home_model->currecy_converter($totalprice, 'no');
        $totalprices = number_format($totalprice, 2, '.', '');
        $total_labels = $row->BatchQty * $LabelsPerSheet;
        $label_price = round((($totalprice / $total_labels)), 3);
        $sheets_price = round((($totalprice / $row->BatchQty)), 3);
        //	$Fullcolour = $this->home_model->calculate_printed_sheets($row->BatchQty, 'Fullcolour');
        $Fullcolour = $this->home_model->calculate_printed_sheets($row->BatchQty, 'Fullcolour', 1, $ProductBrand, $mid);

        if ($type != 'A4 Sheets') {
            $Fullcolour['price'] = $Fullcolour['price'] * 1.5;
        }

        $Fullcolour['price'] = $this->home_model->currecy_converter($Fullcolour['price'], 'no');

        $Fullcolour = $Fullcolour['price'] + $totalprices;

        $Fulltotalprices = number_format($Fullcolour, 2, '.', '');

        $Fulllabel_price = round((($Fulltotalprices / $total_labels)), 3);

        $Fullsheets_price = round((($Fulltotalprices / $row->BatchQty)), 3);

        //	$black = $this->home_model->calculate_printed_sheets($row->BatchQty, 'Black');

        $black = $this->home_model->calculate_printed_sheets($row->BatchQty, 'Black', 1, $ProductBrand, $mid);

        $free_artworks = $black['artworks'];

        if ($type != 'A4 Sheets') {
            $black['price'] = $black['price'] * 1.5;
        }

        $black['price'] = $this->home_model->currecy_converter($black['price'], 'no');
        $black = $black['price'] + $totalprices;
        $black = number_format($black, 2, '.', '');

        $blackabel_price = round((($black / $total_labels)), 3);
        $blacksheets_price = round((($black / $row->BatchQty)), 3);
        ?>

        <tr>
            <td style="text-align:left;<?= $right_border ?>">Plain Labels</td>
            <td rowspan=" <?= $rowspan ?>"
                style="vertical-align:middle;<?= $double_border ?>"><?= $row->BatchQty ?></td>
            <td rowspan=" <?= $rowspan ?>" style="vertical-align:middle;<?= $double_border ?>"><?= $total_labels ?></td>
            <td style=" <?= $right_border ?>" align="center"><?= symbol . $sheets_price ?></td>
            <td style=" <?= $right_border ?>" align="center"><?= symbol . $label_price ?></td>
            <td style=" <?= $right_border ?>" align="left"><?= symbol . $totalprices ?></td>
            <td align="left"><?= symbol . number_format($totalprices * 1.2, 2, '.', '') ?></td>
        </tr>

        <tr>

            <td style="text-align:left;<?= $right_border ?>">Printed Labels - Mono (Black Only)</td>

            <td style=" <?= $right_border ?>" align="center"><?= symbol . $blacksheets_price ?></td>

            <td style=" <?= $right_border ?>" align="center"><?= symbol . $blackabel_price ?></td>

            <td style=" <?= $right_border ?>" align="left"><?= symbol . $black ?></td>

            <td align="left"><?= symbol . number_format($black * 1.2, 2, '.', '') ?></td>

        </tr>


        <tr>

            <td style="text-align:left;<?= $double_border ?>">Printed Labels - Full Colour</td>

            <td style=" <?= $double_border ?>" align="center"><?= symbol . $Fullsheets_price ?></td>

            <td style=" <?= $double_border ?>" align="center"><?= symbol . $Fulllabel_price ?></td>

            <td style=" <?= $double_border ?>" align="left"><?= symbol . $Fulltotalprices ?></td>

            <td style=" <?= $bottom_border ?>"
                align="left"><?= symbol . number_format($Fulltotalprices * 1.2, 2, '.', '') ?></td>

        </tr>


        <tr>

            <td style="text-align:left;<?= $double_border ?>" colspan="1"><b><?= $free_artworks ?> Design Free</b></td>

            <td style="text-align:left;<?= $bottom_border ?>" colspan="4"> &nbsp;Additional designs charged
                at <?= symbol . $desgin_price ?> each .
            </td>

        </tr>


        <? $i++;
    } ?>

</table>

