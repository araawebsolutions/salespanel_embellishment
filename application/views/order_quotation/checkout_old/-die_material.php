<?php
$digitalCheck = ($quotationDetail->ProductBrand == 'Roll Labels') ? 'roll' : 'A4';
if ($quotationDetail->regmark != 'Y') {
    ?>
    <tr <? if ($quotationDetail->Printing != 'Y') { ?> style="display: none" <? } ?>>
        <td></td>
        <td></td>
        <td>
            <div class="btn-span "
                 id="artwork_section<?= $key ?>">

                <span class="labels-form">
                <label class="select">
                <select id="digital<?= $key ?>" class="form-control no-padding m-10" name="digital">

                    <?php foreach ($digitalis as $digital) {

                        if ($digital->type == $digitalCheck || $digital->type == 'both') { ?>
                            <option value="<?= $digital->name ?>" <?php if ($digital->name == $quotationDetail->Print_Type) {
                                echo 'selected';
                            } ?>><?= $digital->name ?></option>
                        <?php }
                    } ?>
                </select>
                    <i></i>
                    </label>
                    </span>
                <?php if ($quotationDetail->ProductBrand == 'Roll Labels') { ?>
                    <select id="Orientation<?= $key ?>" class="form-control no-padding m-10">

                        <option value="1"<?php if ($quotationDetail->Orientation == '1') {
                            echo 'selected';
                        } ?>>Orientation 01
                        </option>
                        <option value="2"<?php if ($quotationDetail->Orientation == '2') {
                            echo 'selected';
                        } ?>>Orientation 02
                        </option>
                        <option value="3"<?php if ($quotationDetail->Orientation == '3') {
                            echo 'selected';
                        } ?>>Orientation 03
                        </option>
                        <option value="4"<?php if ($quotationDetail->Orientation == '4') {
                            echo 'selected';
                        } ?>>Orientation 04
                        </option>
                    </select>

                    <select id="finish<?= $key ?>" class="form-control no-padding m-10">
                        <option value="No Finish"<?php if ($quotationDetail->FinishType == 'No Finish') {
                            echo 'selected';
                        } ?>>No Finish
                        </option>
                        <option value="Gloss Lamination"<?php if ($quotationDetail->FinishType == 'Gloss Lamination') {
                            echo 'selected';
                        } ?>>Gloss Lamination
                        </option>
                        <option value="Matt Lamination"<?php if ($quotationDetail->FinishType == 'Gloss Lamination') {
                            echo 'selected';
                        } ?>>Matt Lamination
                        </option>
                        <option value="Gloss Varnish"<?php if ($quotationDetail->FinishType == 'Gloss Varnish') {
                            echo 'selected';
                        } ?>>Gloss Varnish
                        </option>
                        <option value="High Gloss Varnish"<?php if ($quotationDetail->FinishType == 'High Gloss Varnish') {
                            echo 'selected';
                        } ?>>High Gloss Varnish (Not Over-Printable)
                        </option>
                        <option value="Matt Varnish"<?php if ($quotationDetail->FinishType == 'Matt Varnish') {
                            echo 'selected';
                        } ?>>Matt Varnish
                        </option>
                    </select>

                    <select id="wound<?= $key ?>" class="form-control no-padding m-10">
                        <option value="Outside" <? if ($quotationDetail->wound == "Outside") { ?> selected="selected"<? } ?>>
                            Outside Wound
                        </option>
                        <option value="Inside" <? if ($quotationDetail->wound == "Inside") { ?> selected="selected"<? } ?>>
                            Inside Wound
                        </option>
                    </select>

                    <span class="no-padding m-10"><input type="checkbox" id="pressProf<?= $key ?>"
                                                         <?php if ($quotationDetail->pressproof == 1){ ?>checked
                                                         <?php } ?>name="pressprof" value="1"> <p
                                style="font-size: 11px;color: #666;">Pressproof</p> </span>
                <?php } ?>
                <button id="artworki_for_quotat<?= $key ?>"
                        onclick="addToCart('<?= $quotationDetail->ManufactureID ?>',<?= $quotationDetail->SerialNumber ?>,'<?= $quotationDetail->Printing ?>',<?= $quotationDetail->ProductID ?>,'<?= $quotationDetail->QuotationNumber ?>','<?= $quotationDetail->ProductBrand ?>','quotaton_detail',<?= $key ?>)"
                        type="button"
                        class="m-10 btn btn-secondarys btn-rounded waves-light waves-effect btn-upload-artwork"
                        data-toggle="modal" data-target=".bs-example-modal-lga"><i
                            class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Upload Artwork
                </button>

            </div>
        </td>
        <td></td>
        <?php if ($quotationDetail->Printing == 'Y'){ ?>
        <td>
            <input class="form-control input-number text-center allownumeric" <?php if ($quotationDetail->Printing == 'Y') { ?> readonly="readonly" <?php } ?>
                   type="text" id="design<?= $key ?>" value="<?= $quotationDetail->Print_Qty ?>"></td>
        <!--<td><?php /*echo ($digitalCheck == 'roll')?$quotationDetail->Price:$quotationDetail->Print_Total*/ ?></td>-->
        <td class="text-center"><?= $symbol ?><?php echo number_format($quotationDetail->Print_Total * $exchange_rate, 2) ?></td>
        <td>
            <?php } ?>
        </td>
    </tr>
<?php } ?>