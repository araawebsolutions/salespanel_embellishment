<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-headset"></i> Order Amendment Permisssions</span> <span
                                class="pull-right"></span></div>
                    <div class="card-body">

                        <? $num_rows = count($amendment_setings); ?>


                        <table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap artwork-table-row-adjust return-table no-footer">
                            <thead>
                            <tr class="bold-texts">
                                <th>&nbsp;</th>
                                <th>Plain Sheet Labels</th>
                                <th>Plain Roll Labels</th>
                                <th>Printed Sheet Labels</th>
                                <th>Printed Roll Labels</th>
                                <th>Custom Lines</th>
                                <th>Set-up Charge Plain Sheets</th>
                                <th>Set-up Charge Plain Rolls</th>
                                <th>Set-up Charge Printed Sheets</th>
                                <th>Set-up Charge Printed Rolls</th>

                            </tr>
                            </thead>
                            <tbody class="PermissionsBody">

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105" style="border-top: 1px transparent !important;">
                                    Delivery Upgrade
                                </td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['del_text']; ?></p></br></br>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['delivery'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting  " data-attr="delivery">
                                            <?php if ($amendment_setings[$i]['delivery'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>


                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Die Change</td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['die_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['die'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="die">
                                            <?php if ($amendment_setings[$i]['die'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Material Change</td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['mat_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['mat'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="mat">
                                            <?php if ($amendment_setings[$i]['mat'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Increase/Decrease Qty</td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['qty_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['qty'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="qty">
                                            <?php if ($amendment_setings[$i]['qty'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Add/Remove Products</td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['add_rem_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['add_rem_pro'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="add_rem_pro">
                                            <?php if ($amendment_setings[$i]['add_rem_pro'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>


                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Add/Remove Print Finishes and/or Print Type
                                </td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['add_prnt_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['add_rem_prnt'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="add_rem_prnt">
                                            <?php if ($amendment_setings[$i]['add_rem_prnt'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Add / Remove artwork or Change No. of Designs
                                </td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['add_artwork_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['add_rem_art'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="add_rem_art">
                                            <?php if ($amendment_setings[$i]['add_rem_art'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Cancel Order</td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['cancel_text']; ?></p>
                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['cancel'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="cancel">
                                            <?php if ($amendment_setings[$i]['cancel'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>

                            <!-- Delivery Upgrade -->
                            <tr class="artwork-tr odd">
                                <td class="PermissionTitle" height="105">Refund (Full and Partial)</td>
                                <? for ($i = 0; $i < $num_rows; $i++) { ?>
                                    <td class="button-amend">
                                        <p><?php echo $amendment_setings[$i]['refund_text']; ?></p>

                                        <a id="<?php echo $amendment_setings[$i]['ID']; ?>"
                                           class="<?php if ($amendment_setings[$i]['refund'] == 1) {
                                               echo 'EnableBtn';
                                           } else {
                                               echo 'DisableBtn';
                                           } ?> update_setting" data-attr="refund">
                                            <?php if ($amendment_setings[$i]['refund'] == 1) {
                                                echo 'Enable';
                                            } else {
                                                echo 'Disable';
                                            } ?>
                                        </a>
                                    </td>
                                <? } ?>

                            </tr>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>
<!-- en wrapper -->
<!-- Footer -->


<script>


        $(".update_setting").click(function () {



                swal(
                    "Are You Sure You Want Change this Setting",

                    {

                        buttons: {

                            cancel: "No",

                            catch: {

                                text: "Yes",

                                value: "catch",

                            },


                        },

                        icon: "warning",

                        closeOnClickOutside: false,

                    },
                ).then((value) => {

                    switch (value) {


                        case "catch":

                            var info = this.id;
                            var text = $(this).html();
                            var field = $(this).attr('data-attr');
                            var _this = $(this);
                            if (String($.trim(text)) == String($.trim('Enable'))) {
                                var change_setting = 0;
                                var updated_text = 'Disable';
                                var add_class = 'DisableBtn';
                                var remove_class = 'EnableBtn';
                            } else {
                                var change_setting = 1;
                                var updated_text = 'Enable';
                                var add_class = 'EnableBtn';
                                var remove_class = 'DisableBtn';
                            }
                            var form_data = {info: info, setting: change_setting, field: field};

                            $.ajax({
                                type: "post",
                                url: mainUrl + "order_quotation/Order/change_orderAmendment_setting",
                                data: form_data,
                                success: function (data) {
                                    if (data == 1) {
                                        $(_this).html(updated_text);
                                        $(_this).addClass(add_class);
                                        $(_this).removeClass(remove_class);
                                    }
                                }
                            });




                            break;


                    }

                });



    });


</script>