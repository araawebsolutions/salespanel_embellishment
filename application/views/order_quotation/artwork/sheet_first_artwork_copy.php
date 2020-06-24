<div class="ovFl table-responsive">
    <div id="ajax_upload_content">
        <input type="hidden" value="" id="cartid<?= $data['serialNumber'] ?>">
        <table class="table table-striped" style="width:100%">
            <thead class="">
            <input type="hidden" id="arworklineCounter" value="">
            <tr>
                <td width="10%">Artworks</td>
                <td width="10%">File Name</td>
                <td width="10%">Sheet</td>
                <td class="text-center" width="10%">Labels</td>
                <td align="center" width="20%">Action</td>
            </tr>
            </thead>
            <tbody id="myBody">
						
            <?php foreach ($data['artworks'] as $key => $artwork) { ?>
	
                <tr class="upload_row uploadsavesection" style=" " id="tr_id<?= $key ?>">
                    <td width="10%">
                        <div class="thumb-sm">
                            <img src="<?php echo aalables_path_material ?>integrated_attach/<?= $artwork->file ?>"
                                 class="round-circle img-thumbnails" alt="image">
                            <!--<input type="file" id="artworkimage<?/*= $key */ ?>" name="file" class="artwork_file">-->
                        </div>
                    </td>
                    <td width="30%"><input class="form-control artwork_name" id="at_name<?= $key ?>"
                                           placeholder="Enter Artwork Name" type="text" value="<?= $artwork->name ?>">
                    </td>

                    <td width="30%"><input class="form-control labels_input allownumeric"
                                           onchange="changeSheetLbl(<?= $key ?>,this)" id="at_roll<?= $key ?>"
                                           placeholder="Enter Sheets" value="<?= $artwork->qty ?>" type="text"></td>

                    <td width="10%" align="center" style="vertical-align:middle;" id="at_label<?= $key ?>"
                        class="text-center ">&nbsp<?= $artwork->labels ?></td>
                    <td width="15%" align="center">

                        <input type="hidden" id="artwork_id<?= $key ?>" value="<?= $artwork->ID ?>">
                        <button data-value="sheets" id="updp_btn<?= $key ?>" class=" btn btn-success  "
                                onclick="updateMyArtwork(<?= $key ?>,this,<?=$artwork->ID?>,'<?= $data['page'] ?>','update')"
                                style="padding: 8px;background-color: #5cb85c; border: 1px solid #4cae4c; display:none">
                            <i
                                    class="fa fa-save"></i>
                        </button>
                        <button data-value="sheets" class=" btn btn-success  save_artwork_file"
                                onclick="deleteMyArtwork(<?= $key ?>,<?=$artwork->ID ?>,<?= (isset($artwork->Serial)) ? $artwork->Serial : '' ?>)"
                                style="padding: 8px;background-color: gray;border: 1px solid gray;"><i
                                    class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php }
            $totalCount = (count($data['artworks'])) + 1; ?>

            <input type="hidden" id="product_id" value="<?= $data['productId'] ?>">
            <input type="hidden" id="serialNumber" value="<?= $data['serialNumber'] ?>">
            <input type="hidden" id="orderNumber" value="<?= $data['orderNumber'] ?>">
            <input type="hidden" id="manfactureId" value="<?= $data['manfactureId'] ?>">
            <input type="hidden" id="brand" value="<?= $data['brand'] ?>">
            <input type="hidden" id="minrolls" value="<?= $data['cal']['minRoll'] ?>">
            <input type="hidden" id="maxrolls" value="<?= $data['cal']['maxRoll'] ?>">
            <input type="hidden" id="minlabels" value="<?= $data['cal']['minLabels'] ?>">
            <input type="hidden" id="maxlables" value="<?= $data['cal']['maxLabels'] ?>">
            <input type="hidden" id="lblPerSheet" value="<?= $data['cal']['labelPerSheet'] ?>">
            <input type="hidden" id="checkoutArtwork" value="<?= $data['checkoutArtwork'] ?>">
            <input type="hidden" id="checkouttr" value="<?= (isset($data['checkouttr'])) ? $data['checkouttr'] : '' ?>">
            <input type="hidden" id="original_price" value="">
            <input type="hidden" id="page" value="<?= $data['page'] ?>">
            <input type="hidden" id="rowKey" value="<?= $data['rowKey'] ?>">

            </tbody>


        </table>

        <table class="m-t-t-10">
            <tr>
                <td width="70%" colspan="4" align="left">
                    <button id="show-at-nw" class="btn btn-success add_another_art" onclick="newSheetArtworkLine()"> +
                        Add New Line
                    </button>
                    <button type="button" id="show-at-hs" onclick="getOldArtwork()"
                            class="btn btn-danger waves-light waves-effect">+ Add Artwork From History
                    </button>
                    <button type="button" id="hide-at-hs" onclick="hideOldArtwork()" style="display:none"
                            class="btn btn-danger waves-light waves-effect">- Hide Artwork From History
                    </button>
                </td>
                <td width="25%" colspan="2" align="right" id="artwork_count_status"></td>
            </tr>

        </table>

    </div>
</div>

<!--<script>
    $(document).ready(function () {
        //alert('sds');
        art_pop_tbs();
    });


</script>
-->
