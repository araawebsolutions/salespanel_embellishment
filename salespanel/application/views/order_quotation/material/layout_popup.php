<div class="col-md-3 text-center">
    <img src="<?= $img_src ?>" alt="<?= $catname ?>" title="<?= $catname ?>" width="<?= $width ?>"
         height="<?= $height ?>" class="m-b-10 design-image">
    <img src="<?= aalables_path ?>images/thumb-arrow.png" class="thumb-arrow"></div>
<div class="col-md-9">
    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <td><strong>Labels Width: </strong></td>
            <td><?= $details['LabelWidth'] ?></td>
            <td><strong>Labels Height:</strong></td>
            <td><?= $details['LabelHeight'] ?></td>
        </tr>
        <? if (trim($catname) == '1 Rectangle Label per A4 sheet' and 1 == 2) { ?>
            <tr>
                <td><strong>First score line:</strong></td>
                <td>20 mm</td>
                <td><strong>Second score line:</strong></td>
                <td>42.5 mm</td>
            </tr>
            <tr>
                <td><strong>Third score line:</strong></td>
                <td>42.5 mm</td>
                <td><strong>Fourth score line:</strong></td>
                <td>42.5 mm</td>
            </tr>
            <tr>
                <td><strong>Fifth score line:</strong></td>
                <td>42.5 mm</td>
                <td><strong>Sixth score line:</strong></td>
                <td>20 mm</td>
            </tr>
        <? } else { ?>
            <tr>
                <td><strong>Label Across:</strong></td>
                <td><?= $details['LabelAcross'] ?></td>
                <td><strong>Label Around:</strong></td>
                <td><?= $details['LabelAround'] ?></td>
            </tr>
            <tr>
                <td><strong>Top Margin:</strong></td>
                <td><?= $details['LabelTopMargin'] ?></td>
                <td><strong>Bottom Margin:</strong></td>
                <td><?= $details['LabelBottomMargin'] ?></td>
            </tr>
            <tr>
                <td><strong>Gap Across:</strong></td>
                <td><?= $details['LabelGapAcross'] ?></td>
                <td><strong>Gap Around:</strong></td>
                <td><?= $details['LabelGapAround'] ?></td>
            </tr>
            <tr>
                <td><strong>Left Margin:</strong></td>
                <td><?= $details['LabelLeftMargin'] ?></td>
                <td><strong>Right Margin:</strong></td>
                <td><?= $details['LabelRightMargin'] ?></td>
            </tr>
            <tr>
                <td><strong>Corner Radius:</strong></td>
                <td><?= $details['LabelCornerRadius'] ?></td>
                <td>  </td>
                <td></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
</div>

