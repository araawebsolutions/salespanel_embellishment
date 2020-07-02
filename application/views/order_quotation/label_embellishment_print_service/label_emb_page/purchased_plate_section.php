<!--<pre>-->
<?php
//    print_r($purchased_plate_history);

?>
<!--</pre>-->
<style>
    .hr-style {
        border-top: 1px solid #17b1e3;

    }
</style>
<div id="purchased_plate_container">
    <?php
    foreach ($purchased_plate_history as $plate_history) {
        ?>


        <?php
        $this->db->where('parsed_title', $plate_history->purchased_plate);
        $this->db->where('label_emb_parent_id !=', 0);

        $label_embellishment_table_row = $this->db->get('label_embellishment')->row_array();
//            echo"<pre>";print_r($label_embellishment_table_row['id']);
        $this->db->where('id', $label_embellishment_table_row['label_emb_parent_id']);
        $label_embellishment_table_parent_row = $this->db->get('label_embellishment')->row_array();
//            echo"<pre>";print_r($label_embellishment_table_parent_row);


        $this->db->where('OrderNumber', $plate_history->order_number);
        $this->db->where('file', $plate_history->order_attach_file);
        $order_attachments_integrated = $this->db->get('order_attachments_integrated')->row_array(); ?>
        <div class="" style="width: 4.5%;float: left;min-height: 1px;"></div>
        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"
             class="m-l-20 col-sm-5">
        <img onerror='imgError(this);' class="img-responsive"
             src="<?= Assets ?>images/new-printed-labels/soft-proof-slice.png">
        <div class="margin-top-20">

        <h4>Order No: <b><?php echo $plate_history->order_number; ?> (en) </b></h4>
        <h4>Design Name: <b><?php echo $plate_history->order_attach_name; ?> </b></h4>
        <h4>Last Updated: <b><?php $val = explode(' ', $order_attachments_integrated['Date']);
                if (!empty($val)) {
                    echo $val[0];
                }
                ?> (en) | <?php
                echo date('h:i-A', $val[1]);

                ?>  </b></h4>
        <h4><?php echo ucfirst(str_replace('_', ' ', $plate_history->purchased_plate)); ?></h4>

        <hr class="hr-style">

        <label class="containerr left-no-margin">Select This Plate
        <?php
//        if (isset($selected_already_plates) && count($selected_already_plates) > 0) {


//                echo $selected_already_plate;
                if ($label_embellishment_table_parent_row['parsed_title'] == 'laminations_and_varnishes') {  ?>
                    <input type="checkbox"
                           data-combination_type="checkbox" <?php
                    if (isset($selected_already_plates_composite_array) && count($selected_already_plates_composite_array) > 0) {
                        foreach ($selected_already_plates_composite_array as $key => $selected_already_plate) {
                            $selected_already_plate = (json_decode($selected_already_plate));

                            if ($label_embellishment_table_row['id'] == $selected_already_plate->already_used_plate_id &&  $plate_history->order_number == $selected_already_plate->plate_order_no) {  echo "checked"; unset($selected_already_plates[$key]);   }
                        }
                    }?>

                           data-embellishment_id="<?= $label_embellishment_table_row['id'] ?>"
                           data-embellishment_selection_id="<?= $label_embellishment_table_row['id'] ?>"
                           data-plate_order_no="<?= $plate_history->order_number ?>"
                           id="uncheck_purchased_plate<?= $label_embellishment_table_row['id'] ?>"
                           data-purchased_plate="true" class="   already_plates"
                           data-embellishment_parsed_title_child="<?= $label_embellishment_table_row['parsed_title'] ?>"
                           data-embellishment_parsed_title="<?= $label_embellishment_table_row['parsed_title'] ?>"
                           data-embellishment_selected_title="<?= $label_embellishment_table_row['title'] ?>"
                           name="label_embellishment['<?= $label_embellishment_table_parent_row['parsed_title'] ?>'][]">
                    <?php
                } else { ?>
                    <input type="radio" data-combination_type="radio"
                           data-embellishment_id="<?= $label_embellishment_table_parent_row['id'] ?>"

                         <?php
                         if (isset($selected_already_plates_composite_array) && count($selected_already_plates_composite_array) > 0) {
                    foreach ($selected_already_plates_composite_array as $key => $selected_already_plate) {
                        $selected_already_plate = (json_decode($selected_already_plate));

                        if ($label_embellishment_table_row['id'] == $selected_already_plate->already_used_plate_id &&  $plate_history->order_number == $selected_already_plate->plate_order_no) {  echo "checked"; unset($selected_already_plates[$key]);   }
                    }
                    }?>


                           data-embellishment_selection_id="<?= $label_embellishment_table_row['id'] ?>"
                           data-plate_order_no="<?= $plate_history->order_number ?>"
                           id="uncheck_purchased_plate<?= $label_embellishment_table_row['id'] ?>"
                           data-purchased_plate="true" class="  already_plates"
                           data-embellishment_parsed_title_child="<?= $label_embellishment_table_row['parsed_title'] ?>"
                           data-embellishment_parsed_title="<?= $label_embellishment_table_parent_row['parsed_title'] ?>"
                           data-embellishment_selected_title="<?= $label_embellishment_table_row['title'] ?>"
                           name="label_embellishment['<?= $label_embellishment_table_parent_row['parsed_title'] ?>']">

                <?php } ?>
                <!--                    <input type="checkbox" id="purchased_plate[1]" class="emb_option "><label for="purchased_plate[1]">-->
                <!--                    <label class="containerr left-no-margin already_plates" for="uncheck--><?//= $label_embellishment_table_row['id']
                ?><!--">-->
                <!--                        <span class="labels-embelishemnt-pressproof " > Select This Plate <br></span>-->
                <span class="checkmark  "></span>
                </label>
                </div>

                </div>
                <!--            <div class="col-sm-1"></div>-->


<!--         --><?php //  }

//        } else {
//
//         if ($label_embellishment_table_parent_row['parsed_title'] == 'laminations_and_varnishes') {  ?>
<!--             <input type="checkbox"-->
<!--                    data-combination_type="checkbox"-->
<!--                    data-embellishment_id="--><?//= $label_embellishment_table_row['id'] ?><!--"-->
<!--                    data-embellishment_selection_id="--><?//= $label_embellishment_table_row['id'] ?><!--"-->
<!--                    id="uncheck_purchased_plate--><?//= $label_embellishment_table_row['id'] ?><!--"-->
<!--                    data-purchased_plate="true" class="   already_plates"-->
<!--                    data-embellishment_parsed_title_child="--><?//= $label_embellishment_table_row['parsed_title'] ?><!--"-->
<!--                    data-embellishment_parsed_title="--><?//= $label_embellishment_table_row['parsed_title'] ?><!--"-->
<!--                    data-embellishment_selected_title="--><?//= $label_embellishment_table_row['title'] ?><!--"-->
<!--                    name="label_embellishment['--><?//= $label_embellishment_table_parent_row['parsed_title'] ?><!--'][]">-->
<!--             --><?php
//         } else { ?>
<!--             <input type="checkbox" data-combination_type="radio"-->
<!--                    data-embellishment_id="--><?//= $label_embellishment_table_parent_row['id'] ?><!--"-->
<!--                    data-embellishment_selection_id="--><?//= $label_embellishment_table_row['id'] ?><!--"-->
<!--                    id="uncheck_purchased_plate--><?//= $label_embellishment_table_row['id'] ?><!--"-->
<!--                    data-purchased_plate="true" class="  already_plates"-->
<!--                    data-embellishment_parsed_title_child="--><?//= $label_embellishment_table_row['parsed_title'] ?><!--"-->
<!--                    data-embellishment_parsed_title="--><?//= $label_embellishment_table_parent_row['parsed_title'] ?><!--"-->
<!--                    data-embellishment_selected_title="--><?//= $label_embellishment_table_row['title'] ?><!--"-->
<!--                    name="label_embellishment['--><?//= $label_embellishment_table_parent_row['parsed_title'] ?><!--'][]">-->
<!---->
<!--         --><?php //} ?>
    <!--                    <input type="checkbox" id="purchased_plate[1]" class="emb_option "><label for="purchased_plate[1]">-->
    <!--                    <label class="containerr left-no-margin already_plates" for="uncheck--><?//= $label_embellishment_table_row['id']
    ?><!--">-->
    <!--                        <span class="labels-embelishemnt-pressproof " > Select This Plate <br></span>-->
<!--    <span class="checkmark  "></span>-->
<!--    </label>-->
<!--</div>-->
<!---->
<!--</div>-->

    <?php
//        }
    }
    ?>


    <!--        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"-->
    <!--             class="m-l-20 col-sm-5">-->
    <!--            <img onerror='imgError(this);' class="img-responsive"-->
    <!--                 src="--><? //= Assets ?><!--images/new-printed-labels/soft-proof-slice.png">-->
    <!--            <div class="margin-top-20">-->
    <!---->
    <!--                <h4>Order No: <b>AA2212323 (en) </b></h4>-->
    <!--                <h4>Design Name: <b>Society </b></h4>-->
    <!--                <h4>Last Updated: <b>25-04-2020 (en) |  11:00 am</b></h4>-->
    <!--                <h4>Hot Foil</h4>-->
    <!---->
    <!--                <hr class="hr-style">-->
    <!--                <input type="checkbox" id="purchased_plate[1]"><label for="purchased_plate[1]">-->
    <!--                    <span class="labels-embelishemnt-pressproof">Select This Plate <br></span>-->
    <!---->
    <!--                </label>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!--        <div class="col-sm-1"></div>-->
    <!--        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"-->
    <!--             class="col-sm-5">-->
    <!--            <img onerror='imgError(this);' class="img-responsive"-->
    <!--                 src="--><? //= Assets ?><!--images/new-printed-labels/soft-proof-slice.png">-->
    <!--            <div class="margin-top-20">-->
    <!---->
    <!--                <input type="checkbox" id="purchased_plate[2]"><label for="purchased_plate[2]">-->
    <!--                    <span class="labels-embelishemnt-pressproof">Select This Plate <br></span>-->
    <!---->
    <!--                </label>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!---->
    <!--        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"-->
    <!--             class="m-l-20 col-sm-5">-->
    <!--            <img onerror='imgError(this);' class="img-responsive"-->
    <!--                 src="--><? //= Assets ?><!--images/new-printed-labels/soft-proof-slice.png">-->
    <!--            <div class="margin-top-20">-->
    <!---->
    <!--                <input type="checkbox" id="purchased_plate[3]"><label for="purchased_plate[3]">-->
    <!--                    <span class="labels-embelishemnt-pressproof">Select This Plate <br></span>-->
    <!---->
    <!--                </label>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!--        <div class="col-sm-1"></div>-->
    <!--        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"-->
    <!--             class="col-sm-5">-->
    <!--            <img onerror='imgError(this);' class="img-responsive"-->
    <!--                 src="--><? //= Assets ?><!--images/new-printed-labels/soft-proof-slice.png">-->
    <!--            <div class="margin-top-20">-->
    <!---->
    <!--                <input type="checkbox" id="purchased_plate[4]"><label for="purchased_plate[4]">-->
    <!--                    <span class="labels-embelishemnt-pressproof">Select This Plate <br></span>-->
    <!---->
    <!--                </label>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!---->
    <!--        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"-->
    <!--             class="m-l-20 col-sm-5">-->
    <!--            <img onerror='imgError(this);' class="img-responsive"-->
    <!--                 src="--><? //= Assets ?><!--images/new-printed-labels/soft-proof-slice.png">-->
    <!--            <div class="margin-top-20">-->
    <!---->
    <!--                <input type="checkbox" id="purchased_plate[5]"><label for="purchased_plate[5]">-->
    <!--                    <span class="labels-embelishemnt-pressproof">Select This Plate <br></span>-->
    <!---->
    <!--                </label>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!--        <div class="col-sm-1"></div>-->
    <!--        <div style="background: #f5f5f5;  border: 1px solid #ececec;  border-radius: 4px; padding: 0.875rem; margin-bottom: 10px;"-->
    <!--             class="col-sm-5">-->
    <!--            <img onerror='imgError(this);' class="img-responsive"-->
    <!--                 src="--><? //= Assets ?><!--images/new-printed-labels/soft-proof-slice.png">-->
    <!--            <div class="margin-top-20">-->
    <!---->
    <!--                <input type="checkbox" id="purchased_plate[6]"><label for="purchased_plate[6]">-->
    <!--                    <span class="labels-embelishemnt-pressproof">Select This Plate <br></span>-->
    <!---->
    <!--                </label>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
</div>

