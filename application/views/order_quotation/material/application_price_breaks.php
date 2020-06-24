<? $double_border = 'border-bottom:1px solid #17b1e3;border-right:1px solid #17b1e3;';
$right_border = 'border-right:1px solid #17b1e3;';
$bottom_border = 'border-bottom:1px solid #17b1e3;';
$border = 'border:1px solid #17b1e3;';
$rowspan = 1;

$response = $this->product_model->lba_pack_details(array('ManufactureID' => $mid));
?>
<table class="table table-striped p-5" style="    border: 1px solid #17b1e3;width: 96%;margin: 0px auto;">
    <tr class="info" height="28">
        <td style="text-align:left; <?= $border ?>" align="left">PRODUCT <br/>(<?= $mid ?>)</td>
        <td style=" <?= $border ?>" align="center" valign="middle">NO. <?= strtoupper($response['Type']) ?>S</td>
        <td style=" <?= $border ?>" align="center">NO. LABELS</td>
        <td style=" <?= $border ?>" align="center">PRICE<br/> PER <?= strtoupper($response['Type']) ?></td>
        <td style=" <?= $border ?>" align="center">PRICE<br/> PER LABEL</td>
        <td style=" <?= $border ?>" align="center">TOTAL<br/> ex VAT</td>
        <td style=" <?= $border ?>" align="center">TOTAL<br/> inc VAT</td>
    </tr>
    <?
    $data[] = (object)array('ManufactureID' => 'AAEDD001WTP0001', 'BatchID' => 1, 'SetupCost' => $breaks[0]->SetupCost, 'SheetPrice' => $breaks[0]->SheetPrice, 'BatchQty' => 1);
    $data[] = (object)array('ManufactureID' => 'AAEDD001WTP0001', 'BatchID' => 1, 'SetupCost' => $breaks[0]->SetupCost, 'SheetPrice' => $breaks[0]->SheetPrice, 'BatchQty' => 5);
    $data[] = (object)array('ManufactureID' => 'AAEDD001WTP0001', 'BatchID' => 1, 'SetupCost' => $breaks[0]->SetupCost, 'SheetPrice' => $breaks[0]->SheetPrice, 'BatchQty' => 10);
    $data[] = (object)array('ManufactureID' => 'AAEDD001WTP0001', 'BatchID' => 1, 'SetupCost' => $breaks[0]->SetupCost, 'SheetPrice' => $breaks[0]->SheetPrice, 'BatchQty' => 20);
    //$data[] =  (object) array('ManufactureID'=>'AAEDD001WTP0001','BatchID'=>1,'SetupCost'=>$breaks[0]->SetupCost,'SheetPrice'=>$breaks[0]->SheetPrice,'BatchQty'=>25);


    $i = 1;
    $breaks = array_merge($data, $breaks);
    foreach ($breaks as $row) {

        $qty = $row->BatchQty * $response['packsize'];
        if ($qty < 25) {
            //$totalprice = 9.29;
            $totalprice = $this->product_model->calculate_lba_price($qty, $mid);
            $totalprice = $totalprice['custom_price'];
            $Fullcolour['price'] = 0.00;
        } else {
            $Fullcolour = $this->home_model->calculate_printed_sheets($qty, 'Fullcolour');
            $Fullcolour['price'] = $this->home_model->currecy_converter($Fullcolour['price'], 'no');
            $totalprice = $qty * $row->SheetPrice;
        }


        $totalprice = $this->home_model->currecy_converter($totalprice, 'no');

        $totalprices = number_format($totalprice, 2, '.', '');
        $total_labels = $row->BatchQty * $LabelsPerSheet;
        $label_price = round((($totalprice / $total_labels)), 3);

        $sheets_price = round((($totalprice / $row->BatchQty)), 3);


        $Fullcolour = $Fullcolour['price'] + $totalprices;

        $Fulltotalprices = number_format($Fullcolour, 2, '.', '');
        $Fulllabel_price = round((($Fulltotalprices / $total_labels)), 3);
        $Fullsheets_price = round((($Fulltotalprices / $row->BatchQty)), 3);

        ?>
        <tr>
            <td style="text-align:left;<?= $double_border ?>">Printed Labels - Full Colour</td>
            <td rowspan=" <?= $rowspan ?>"
                style="vertical-align:middle;<?= $double_border ?>"><?= $row->BatchQty ?></td>
            <td rowspan=" <?= $rowspan ?>" style="vertical-align:middle;<?= $double_border ?>"><?= $total_labels ?></td>
            <td style=" <?= $double_border ?>" align="center"><?= symbol . $Fullsheets_price ?></td>
            <td style=" <?= $double_border ?>" align="center"><?= symbol . $Fulllabel_price ?></td>
            <td style=" <?= $double_border ?>" align="left"><?= symbol . $Fulltotalprices ?></td>
            <td style=" <?= $bottom_border ?>"
                align="left"><?= symbol . number_format($Fulltotalprices * 1.2, 2, '.', '') ?></td>
        </tr>


        <? $i++;
    } ?>
</table>
