<style>
    .green {
        color: limegreen;
    }

    .red {
        color: crimson;
    }
</style>
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive artwork-table-row-adjust return-table"
       cellspacing="0" width="100%" id="getReorderOrders">
    <thead>
    <tr>
        <th width="120">Die Code</th>
        <th width="120">Template</th>
        <th width="130">Date / Time</th>
        <th width="120">Category</th>
        <th width="50">Display in</th>
        <th width="60">S&nbsp;&&nbsp;S A</th>
        <th width="50">C</th>
        <th width="50">supplier</th>
        <th width="50">Die Price</th>
        <th width="120">Status</th>
        <th width="100">Action</th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach ($reorder as $rowp) {

        $class1 = $class2 = 'red';
        $icon1 = $icon2 = 'close';

        if ($rowp->S_SA == 1) {
            $class1 = "green";
            $icon1 = "check";
        }
        if ($rowp->Status == 7) {
            $class2 = "green";
            $icon2 = "check";
        }
        $comntcount = $this->die_model->fetch_comments_count($rowp->ID);

        if ($rowp->Status == 37) {
            $action = 'Approve';
            $title = 'Pending Approval';
        } else if ($rowp->Status == 17) {
            $action = 'Order Die';
            $title = 'Approved';
        } else if ($rowp->Status == 73) {
            $action = 'Complete';
            $title = 'Die Ordered';
        } else if ($rowp->Status == 7) {
            $action = '';
            $title = 'Completed';
        }
        ?>

        <tr class="artwork-tr">
            <td><?= $rowp->diecode; ?><br>
                <a href="javascript:void(0)" class="comments orange-text" style="cursor:pointer;"
                   data-id="<?= $rowp->ID ?>">
                    <i id="comments_<?= $rowp->ID; ?>"><?= $comntcount ?></i>&nbsp;comments
                </a>
            </td>
            <td>
                <?
                if ($rowp->manufactureid == 'SRA3 Label') {
                    $image = '<img src="' . Assets . 'images/categoryimages/SRA3Sheets/' . $rowp->OrderNumber . '" height="100"/>';
                } else if ($rowp->manufactureid == 'A3 Label') {
                    $image = '<img src="' . Assets . 'images/categoryimages/A3Sheets/' . $rowp->OrderNumber . '" height="100"/>';
                } else if ($rowp->manufactureid == 'A4 Labels') {
                    $image = '<img src="' . Assets . 'images/categoryimages/A4Sheets/' . $rowp->OrderNumber . '" height="100"/>';
                }else{
                     $rowp->OrderNumber = str_replace('.png','.jpg',$rowp->OrderNumber);
                     $image = '<img src="' . Assets . 'images/categoryimages/RollLabels/' . $rowp->OrderNumber . '" height="100"/>';
                }
                $image;
                ?>
                <a id="image_<?= $rowp->ID ?>" href="<?= Assets ?>images/office/pdf/<?= $rowp->file ?>"
                   target="_blank"><?= $image ?></a>
            </td>
            <td><?php echo date('d-m-Y <b> h : i  A</b>', ($rowp->Time)); ?></td>
            <td><b><?php echo $rowp->manufactureid; ?></b></td>
            <td><?= $rowp->display_in ?></td>
            <td><span class="<?= $class1 ?>"><i class="fa fa-<?= $icon1 ?>" aria-hidden="true"></i></span></td>
            <td><span class="<?= $class2 ?>"><i class="fa fa-<?= $icon2 ?>" aria-hidden="true"></i></span></td>

            <? $counting = $this->die_model->reorder_flexiblepricing($rowp->ID);
            $ddtext = (count($counting) > 0) ? "View Price" : "Add Price";
            $appliedprice = 0;
            if (count($counting) > 0) {
                $appliedprice = $this->die_model->re_orderfetch_aplied_pricing($rowp->ID);
                $ddtext = (@count($appliedprice) > 0) ? '&pound; ' . number_format($appliedprice['sprice'], 2) : "View Price";
            }
            ?>
            <?php if ($rowp->Status != 37) { ?>
                <td><?php echo @$counting[0]->supplier; ?></td>

                <td>
                    <!--<a style="cursor:pointer"><strong><?php echo $ddtext; ?></strong></a>-->
                    <a style="cursor:pointer"><strong>---</strong></a>
                </td>
            <?php } else { ?>

                <td><?php echo '-'; ?></td>

                <td>
                    <a class="view_price" id="<?php echo $rowp->ID; ?>"
                       style="cursor:pointer"><strong><?php echo $ddtext; ?>    </strong></a>
                </td>
            <?php } ?>


            <td><?= $title ?></td>
            <td class="wrapper">
                <?php if ($rowp->Status != 7) { ?>
                    <button class="reorderdie btn btn-outline-info waves-light waves-effect btn-sm"
                            data-id="<?= $rowp->ID ?>" data-status="<?= $rowp->Status ?>"
                            type="button"> <?= $action; ?></button>
                <? } ?>
            </td>
        </tr>
    <? } ?>
    </tbody>
</table>


<script>

    $(document).on("click", ".view_price", function (e) {
        var Flexible_dies_id = this.id;
        $.ajax({
            type: "post",
            url: mainUrl + "dies/dies/reorder_pricecontroller",
            cache: false,
            data: {Flexible_dies_id: Flexible_dies_id},
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                $('#edit_info_data').html(data.html);
                $('#edit_info').modal('show');
                //$.fallr('show', {content:data.html,width:900,icon:'chat',closeOverlay:true,buttons:{button1:{text:'Close'}}});
            },
            error: function () {
                swal('warning', 'Error while request..', 'warning');
                $('#edit_info').modal('hide');
                $('#aa_loader').hide();
            }
        });
    });

    $(document).on("click", "#fallr-button-button1", function (e) {
        $('.abc').hide();
    });


    $(document).on("click", ".reorderdie", function (e) {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');


        swal("Are you sure you want to continue?", {
            icon: 'warning',
            title: 'WARNING',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
                switch (value) {
                    case "yes":
                        $('#aa_loader').show();

                        $.ajax({
                            type: "post",
                            url: mainUrl + "dies/dies/changestatus",
                            cache: false,
                            data: {id: id, status: status},
                            dataType: 'html',
                            success: function (data) {
                                getReorderDie();
                                swal('Success', 'Die Status Changed successfully', 'success');
                            },
                            error: function () {
                                swal('warning', 'Error while request..', 'warning');
                                $('#aa_loader').hide();
                            }
                        });
                        break;
                }
            });
    });

</script>
                