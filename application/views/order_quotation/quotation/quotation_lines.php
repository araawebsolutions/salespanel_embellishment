<?php
$extPrice = 0;
foreach ($quotationDetails as $key => $quotationDetail) {
    $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
    if ($quotationDetail->ManufactureID == 'SCO1') {
        $carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);
        ?>
        <tr>
            <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?></td>
            <td class="text-left">
                <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?>|
                <b>Format: </b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?>|
                <b>Size: </b><?= (isset($carRes[0])) ? $carRes[0]->width : '' . ' mm *' ?><?= (isset($carRes[0]) && $carRes[0]->height == null) ? $carRes[0]->width . ' mm' : (isset($carRes[0])) ? $carRes[0]->height : '' . ' mm' ?>
                |
                <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?>
                <b>Across: </b><?= (isset($carRes[0])) ? $carRes[0]->across : '' ?>
                |
                <b>Around: </b><?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
                | <b>Corner
                    Radious: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
                |
                <b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>

            </td>
            <td id="labels0">450</td>
            <td><?= $quotationDetail->Quantity ?></td>
            <td>£0.00</td>

        </tr>
        <?php
        $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);


        $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
        foreach ($assoc as $rowp){
            ?>
            <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
            <? $materialpriceinc = $materialprice * 1.2; ?>
            <tr>

                <td class="text-center labels-form"><?=$rowp->material?></td>
                <td><i class="mdi "></i><?= $this->user_model->get_mat_name($rowp->material); ?></td>
                <td id="labels0">-</td>
                <td><?= $rowp->qty ?></td>
                <td><?$symbol?><? echo(number_format($materialprice * $exchange_rate, 2)); ?></td>

            </tr>
        <?php }?>
    <?php }else{?>
        <tr>
            <td></td>
            <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?></td>
            <td><?= $quotationDetail->ProductName ?></td>
            <td id="labels0"><?= $quotationDetail->Quantity * $quotationDetail->LabelsPerSheet ?></td>
            <td><?= $quotationDetail->Quantity ?></td>
            <td><?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2) ?></td>
            <td></td>


        </tr>
        <?php if($quotationDetail->Printing == 'Y' && $quotationDetail->regmark !='Y'){?>
            <tr>
                <td class="text-center labels-form"></td>
                <td class="text-center labels-form"></td>
                   <?php include(APPPATH . 'views/generate_text_line.php'); ?>
                <td id="labels0"></td>
                <td></td>
                <td></td>
            </tr>
        <?php }elseif($quotationDetail->Printing == 'Y' && $quotationDetail->regmark =='Y'){?>
            <tr>
                <td></td>
                <td></td>
                <td><b>Printing Service (Black Registration Mark on Reverse)</b></td>
                <td></td>
                <td></td>
            </tr>
            <?php }?>
    <?php }}?>