<table class="table table-hover">
    <tbody>
    <tr>
        <td colspan="2"><h4>Labels Adhesive Material</h4></td>
    </tr>
    <tr>
        <td colspan="2"><?= $allcats[0]->ProductCategoryName ?></td>
    </tr>
    <tr>
        <td width="150"><strong>Product Name:</strong></td>
        <td><?= $allcats[0]->ProductName ?></td>
    </tr>
    <tr>
        <td><strong>Material:</strong></td>
        <td><?= $allcats[0]->Material1_upd ?></td>
    </tr>
    <tr>
        <td><strong>Appearance:</strong></td>
        <td><? echo $allcats[0]->Appearance ?></td>
    </tr>

    <? if ($allcats[0]->labelsCompatiblity != '') { ?>
        <tr>
            <td><strong>Compatibility:</strong></td>
            <td><?php echo $allcats[0]->labelsCompatiblity ?>.</td>
        </tr>
    <?php } else { ?>

        <tr>
            <td><strong>Compatibility:</strong></td>
            <td><?php echo $allcats[0]->ProductName ?></td>
        </tr>

    <? }
    if ($allcats[0]->Grammage != '') { ?>

        <tr>
            <td><strong>Grammage:</strong></td>
            <td><? echo $allcats[0]->Grammage ?></td>
        </tr>

    <?php }

    if ($type == 'roll') {

        $exploded_adhesive = explode('|', $allcats[0]->AdhesivePDF);
        $txt_up = '';
        $txt_bt = '';
        foreach ($exploded_adhesive as $e_a) {
            $e_a = str_replace('0C', '&ordm;C', $e_a);
            $e_a = str_replace('oC', '&ordm;C', $e_a);
            if (strpos($e_a, ':') === false) {
                if ($txt_up == '') {
                    $label_adhisive = $e_a;
                } else {
                    $txt_bt = $e_a;
                }
            } else {

                $exploded_factor = explode(':', $e_a);
                $label_adhisive = $exploded_factor[0] . ' ' . $exploded_factor[1];
            }
        }
        ?>

        <tr>
            <td><strong>Adhesive:</strong></td>
            <td><?= $label_adhisive . ' ' . $txt_bt ?></td>
        </tr>


    <?php } else { ?>

        <tr>
            <td><strong>Adhesive:</strong></td>
            <td><?php echo strip_tags($allcats[0]->AdhesivePDF); ?></td>
        </tr>

    <? } ?>


    <tr>
        <td><strong>Tack:</strong></td>
        <td><?php echo strip_tags($allcats[0]->Tack); ?></td>
    </tr>
    <tr>
        <td><strong>Final Adhesion:</strong></td>
        <td><?php echo strip_tags($allcats[0]->Final_Adhesion); ?></td>
    </tr>
    <tr>
        <td><strong>Shelf Life:</strong></td>
        <td><?php echo strip_tags($allcats[0]->ShefLife); ?></td>
    </tr>

    <tr>
        <td class="bgGray " colspan="2">
            <small> The above AA label's materials specification for this adhesive / sticky label is based on
                information obtained from the original manufacturer and is offered in good faith in accordance with AA
                Labels conditions to determine fitness for use on the A4 sheets of sticky labels that AA Labels
                manufacture. No guarantee is offered or implied. It is the ultimate user's responsibility to fully test
                the label's material and determine its suitability for the label application intended. Measurements and
                test results on this label's material are nominal. In accordance with a policy of continuous label
                product improvement the manufacturer and AA labels reserves the right to amend the specification without
                notice. Copyright AA labels <?= date("Y"); ?></small>
        </td>
    </tr>
    </tbody>
</table>