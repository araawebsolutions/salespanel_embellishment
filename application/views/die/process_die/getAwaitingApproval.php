<style>
    .green {
        color: limegreen;
    }

    .red {
        color: crimson;
    }
</style>
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive artwork-table-row-adjust return-table"
       cellspacing="0" width="100%" id="getCustomarAprovalTable">
    <thead class="artwork-thead">
    <tr>
        <th class="no-border" width="10%">Quote No</th>
        <th class="no-border" width="10%">Item Code</th>
        <th class="no-border" width="70%">Description</th>
        <th class="no-border" width="10%">Price (inc vat)</th>
    </tr>
    </thead>
    <tbody>
    <?
    foreach ($pending as $rowp2) {

        $custominfo = $this->quoteModel->fetch_custom_die_quote($rowp2->SerialNumber);
        if (@count($custominfo) > 0) { ?>

            <tr class=" artwork-tr">
                <td><?= $rowp2->QuotationNumber ?></td>
                <td><?= $custominfo['tempcode'] ?></td>
                <td>

                    <?php if ($custominfo['format'] != "") { ?>
                        <b>Format:</b>
                        <?= $custominfo['format'] ?>&nbsp;&nbsp;
                    <?php } ?>

                    <?php if ($custominfo['shape'] != "") { ?>

                        <b>Shape:</b>
                        <?= $custominfo['shape'] ?>&nbsp;&nbsp;
                    <?php } ?>

                    <?php if ($custominfo['format'] != "" || $custominfo['shape'] != "") { ?> <?php } ?>


                    <? if ($custominfo['width'] != "") { ?>
                        <b>Width:</b> <?= $custominfo['width'] ?> mm &nbsp;&nbsp;
                    <?php } ?>

                    <? if ($custominfo['shape'] != "Circle" && $custominfo['shape'] != "") { ?>
                        <b>Height:</b> <?= $custominfo['height'] ?> mm
                    <? } ?>

                    <? if ($custominfo['width'] != "" || $custominfo['height'] != "") { ?>  <? } ?>


                    <? if ($custominfo['format'] == "Roll") { ?>
                        <b>Leading
                            Edge:</b> <?= ($custominfo['shape'] == "Circle") ? $custominfo['width'] : $custominfo['width'] ?> mm
                    <? } ?>

                    <? if ($custominfo['cornerradius'] != "") { ?>
                        <b>Corner radius:</b> <?= $custominfo['cornerradius'] ?> mm
                    <? } ?>

                    <? if ($custominfo['perforation'] != "") { ?>
                        <b>Perforation:</b> <?= $custominfo['perforation'] ?>
                    <? } ?>

                    <?php if (count($custominfo) == 0) { ?>
                        <?php echo '--------'; ?>
                    <?php } ?>

                </td>

                <?
                $symbol = $this->die_model->get_currecy_symbol($rowp2->currency);
                $pricsdj = $symbol . " " . (number_format($rowp2->ProductTotal * $rowp2->exchange_rate, 2));
                ?>
                <td><?= @$pricsdj ?> </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>