<style>
    .artwork_titleX {
        font-size: 14px;
        line-height: 20px;
    }

    .ourTeam h2 {
        color: #17b1e3 !important;
        margin: 0 0 30px;
    }

    .green-i {
        color: #5cb85c;
    }

    .red-i {
        color: #d9534f;
    }

    .orange-i {
        color: #f0ad4e;
    }

    .artwork_titleX h2 {
        font-size: 15px;
        line-height: 24px;
    }

    .pending {
        background-color: #f0ad4e;
    }
</style>

<link rel="stylesheet" href="<?= Assets ?>css/printed-labels.css">


<div>
    <div class="container m-t-b-8 ">
        <div class="col-md-8">
            <ol class="breadcrumb  m0">
                <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i></a></li>
                <li>Artwork Approval Summary</li>
            </ol>
        </div>
    </div>
</div>


<div class="ourTeam">
    <div class="container">
        <div class="clear30"></div>


        <div class=" thumbnail ">
            <div class="col-md-8 col-sm-12 ">
                <div class="clear15"></div>
                <h2 class="BlueHeading"><strong>Artwork Approval Summary</strong></h2>
                <div class="artwork_titleX">

                    <p>Thank you for responding to our request to approve the artwork soft-proof/s for your order. If
                        you have approved the design/s your order will automatically proceed to press for production of
                        your printed labels.</p>

                    <p>If you have requested an amendment to artwork, this has been returned to our studio design team
                        for re-work and upon completion you will be notified again to approve the changes made.</p>

                    <p>Please note that if you have other designs with this order that have not been approved, or for
                        which amendments are being made, the order will not proceed until these have also been
                        approved.</p>


                </div>


            </div>
            <div class="col-md-4 col-sm-12 ">
                <img onerror='imgError(this);' class="img-responsive m-t-15"
                     src="<?= Assets ?>images/header/man_doing.png">
            </div>

            <div class="col-md-11 col-sm-12">

                <table class="table table-striped p-5" style=" border:1px solid #17b1e3;">
                    <tbody>
                    <tr class="info" height="28">
                        <td style="text-align:left; border:1px solid #17b1e3;" align="center">ORDER NO.</td>
                        <td style=" border:1px solid #17b1e3;" valign="middle"
                            align="center"><?= $result[0]->OrderNumber ?></td>
                        <td style=" border:1px solid #17b1e3;" colspan="4" align="center">ARTWORK APPROVAL SUMMARY</td>
                    </tr>
                    <tr class="warning">
                        <td style="text-align:center;border-right:1px solid #17b1e3;">Design No.</td>
                        <td style=" border-right:1px solid #17b1e3;" align="center">Your Ref.</td>
                        <td style=" border-right:1px solid #17b1e3;" align="center">Print Job No.</td>
                        <td style=" border-right:1px solid #17b1e3;" align="center">NO. Labels</td>
                        <td style=" border-right:1px solid #17b1e3;" align="center">NO. Rolls/Sheets</td>
                        <td align="center">Status</td>
                    </tr>

                    <? $i = 0;
                    foreach ($result as $row) {
                        $i++;
                        if ($row->status == 55) {
                            $status_class = 'pending';
                            $status_text = ' PENDING APPROVAL ';
                        } else if ($row->status == 56) {
                            $status_class = '';
                            $status_text = ' AT STUDIO ';
                        } else if ($row->status == 58) {
                            $status_class = 'success';
                            $status_text = ' APPROVED FOR PRINTING ';
                        } else if ($row->status == 60) {
                            $status_class = 'danger';
                            $status_text = ' AMENDMENT REQUIRED  ';
                        }
                        ?>

                        <tr>
                            <td style="text-align:center;border-right:1px solid #17b1e3;"><?= sprintf("%02d", $i) ?></td>
                            <td style=" border-right:1px solid #17b1e3;" align="center"><?= $row->name ?></td>
                            <td style=" border-right:1px solid #17b1e3;" align="center"><?= 'PJ' . $row->ID ?></td>
                            <td style=" border-right:1px solid #17b1e3;" align="center"><?= $row->labels ?></td>
                            <td style=" border-right:1px solid #17b1e3;" align="center"><?= $row->qty ?></td>
                            <td class="<?= $status_class ?>"
                                style="text-align:left; background-color:"><?= $status_text ?></td>
                        </tr>


                    <? } ?>

                    </tbody>
                </table>

            </div>


        </div>

    </div>
</div>







 
