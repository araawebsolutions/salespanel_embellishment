<div class="row m-t-5">

    <div class="col-md-2 col-lg-2 artwork-images-card p-2">
        <div class="artwork-thumbnail text-center">
            <?php
            $userType = $this->session->userdata('UserTypeID');
            $userId = $this->session->userdata('UserID');

            if ($attachmentItegrated->file != null) {
                $cs = $attachmentItegrated->file;
            } else {
                $cs = (isset($orderChats->file) && $orderChats->file != null) ? $orderChats->file : '';
            }
            ?>
            <a href="<?= cs_rejected_artwork . $cs ?>" target="_blank"><img src="<?= cs_rejected_artwork . 'gp.png' ?>"
                                                                            alt="Artwork Uploaded"
                                                                            class="img-fluid"></a>
            <div>
                <span class="badge badge-red artwork-thumbnail-badge">CP</span>
            </div>
        </div>

        <div class="artwork-detail">
            <p><b>Customer Original:</b></p>
            <p>165g Crystal clear</p>
            <p><b>Last updated:</b></p>
            <p>16-09-2018 | 06 : 59 PM</p>
        </div>

        <div class="artwork-detail-btn-row">

            <a href="<?= cs_rejected_artwork . $cs ?>" ><span class="artwork-details-btn">Donwload</span></a>
            <span class="artwork-detail-btn-divider"></span>
            <span class="artwork-details-btn-1">Edit</span>


        </div>


    </div>


    <div class="col-md-2 col-lg-2 artwork-images-card p-2">
        <div class="artwork-thumbnail text-center">
            <?php if ($attachmentItegrated->softproof != null) {
                $name =  $attachmentItegrated->softproof;
                ?>
                <img src="<?= thm_rejected_artwork . 'softproof/' .$name ?>"
                     alt="Artwork Uploaded" class="img-fluid">
            <?php } else {
                $name = (isset($orderChats->softproof) && $orderChats->softproof != null) ? $orderChats->softproof : '';
                ?>
                <img src="<?= thm_rejected_artwork . 'softproof/' . $name ?>" alt="Artwork Uploaded" class="img-fluid">
            <?php } ?>
            <div>
                <span class="badge badge-red artwork-thumbnail-badge">SP</span>
            </div>
        </div>

        <div class="artwork-detail">
            <p><b>Soft Proof name:</b></p>
            <p>165g Crystal clear</p>
            <p><b>Last updated:</b></p>
            <p>16-09-2018 | 06 : 59 PM</p>
        </div>

        <div class="artwork-detail-btn-row">

            <a href="<?= thm_rejected_artwork . 'softproof/' .$name ?>" ><span class="artwork-details-btn">Download</span></a>
            <span class="artwork-detail-btn-divider"></span>
            <span class="artwork-details-btn-1">View Old Artworks</span>


        </div>


    </div>


    <?php /*include ('artwork_map.php');*/ ?>
    <div class="col-md-2 col-lg-2 artwork-images-card p-2">
        <div class="artwork-thumbnail text-center">
            <?php if ($attachmentItegrated->print_file != null) {
                 $print_file = $attachmentItegrated->print_file;

                ?>

                <embed width="150" height="140" name="plugin"
                       src="<?= thm_rejected_artwork . 'print/' .$print_file ?>"
                       type="application/pdf">
            <?php } else {
                $print_file = (isset($orderChats->file) && $orderChats->file != null) ? $orderChats->file : '';
                ?>
                <embed width="150" height="140" name="plugin" src="<?= thm_rejected_artwork . 'print/' . $print_file ?>"
                       type="application/pdf">
            <?php } ?>
            <div>
                <span class="badge badge-red artwork-thumbnail-badge">PF</span>
            </div>
        </div>

        <div class="artwork-detail">
            <p><b>Print File name:</b></p>
            <p>165g Crystal clear</p>
            <p><b>Last updated:</b></p>
            <p>16-09-2018 | 06 : 59 PM</p>
        </div>

        <div class="artwork-detail-btn-row">

           <a href="<?= thm_rejected_artwork . 'print/' . $print_file ?>"> <span class="artwork-details-btn">Donwload</span></a>
            <span class="artwork-detail-btn-divider"></span>
            <span class="artwork-details-btn-1">View</span>


        </div>


    </div>


    <div class="col-md-5 col-lg-5 artwork-images-card p-2">

        <table class="table table-borderless mb-0">
            <thead class="artwork-border-bottom">
            <tr>
                <th>CO</th>
                <th>SP</th>
                <th>CA</th>
                <th>PF</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><i class="mdi mdi-check-circle green-tick"></i></td>
                <td><i class="fa  fa-times-circle red-cross"></i></td>
                <td><i class="fa  fa-times-circle red-cross"></i></td>
                <td><i class="fa  fa-times-circle red-cross"></i></td>
                <td>
                    <ul class="green-alert artwork-list-tab">
                        <li class="pull-left">
                            <div class="sk-spinner sk-spinner-pulse green-pulse-1"></div>
                        </li>
                        <li>Pending CO Approval</li>
                    </ul>

                </td>
                <td>
                    <ul class="green-alert artwork-list-tab">
                        <li class="pull-left">
                            <div class="sk-spinner sk-spinner-pulse green-pulse-1"></div>
                        </li>
                        <li>Pending CO Approval</li>
                    </ul>

                </td>
            </tr>

            </tbody>
        </table>
        <hr class="blue-hr">
        <div>
            <img src="../assets/images/artworks/graph.jpg" alt="Artwork Uploaded"
                 class="img-fluid">

        </div>
        <hr class="blue-hr">

        <div class="total-time-check">
            24hrs, 16 mins, total time f the PJ (Exc, customer time). <strong>See
                Full Timeline</strong>
        </div>


    </div>


</div>

<?php if($attachmentItegrated->ProductBrand == 'Roll Labels'){

$roll_material = substr($attachmentItegrated->ManufactureID,0,-1);
$materialcode = $this->Rejected_artwork_model->getmaterialcode($roll_material);
$die = str_replace($materialcode,"",$roll_material);

$val = substr($attachmentItegrated->ManufactureID,-1);
// $menu = $die.'R'.$val;
$menu = $die;

$wound = $attachmentItegrated->Wound;
$wound_path = ($attachmentItegrated->Wound=="Inside")?"RollLabels":"RollLabels";
$orientation = $attachmentItegrated->Orientation;
$woundtip = roll_rejected_artwork_path.'images/categoryimages/'.$wound_path.'/'.$menu.'.jpg';
$tooltip = roll_rejected_artwork_path.'images/categoryimages/winding/'.$attachmentItegrated->Wound.'/orientation'.$attachmentItegrated->Orientation.'.png';

?>
<div class="container artwork-images-cards p-b-10">
    <p>Printed Labels on Rolls - Luxury White Permanent adhesive - label size 65 mm
        x 65 mm 25mm core Outside Wound - Orientation 1, 6 Colour Digital Process
        With
        Label finish: None</p>

    <div class="row">

        <div class="col-md-3">
            <div class="card artworks-card fix-height">
                <div class="card-header artworks-card-text">Wound</div>
                <div class="card-body text-center no-padding">
                    <img src="<?=$woundtip?>"
                         alt="Artwork Uploaded"
                         class="img-fluid">
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card artworks-card fix-height">
                <div class="card-header artworks-card-text">Orientation</div>
                <div class="card-body text-center no-padding">
                    <img src="<?=$tooltip?>"
                         alt="Artwork Uploaded"
                         class="img-fluid">
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card artworks-card fix-height">
                <div class="card-header artworks-card-text">Finish</div>
                <div class="card-body text-center">
                    <?=$attachmentItegrated->FinishType?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card artworks-card fix-height">
                <div class="card-header artworks-card-text">Press Proof</div>
                <div class="card-body text-center">
                    <?=$attachmentItegrated->pressproof?>
                </div>
            </div>
        </div>


    </div>

</div>
<?php }?>
<?php //$userType = 89;
//$userId = 555;
?>
<div class="container artwork-images-cards m-t-t-10">
    <div class="row p-10">
        <?php if(($userType == 88 && $attachmentItegrated->action == 1 && $attachmentItegrated->is_upload_print_file == 0) || ($userId == DESIGNER) || ($userType!= 88 && $attachmentItegrated->action == 0  && $attachmentItegrated->is_upload_print_file == 0)){?>
        <span><button type="button" onclick="showCommentBox()" class="btn btn-outline-info waves-light waves-effect">Add Comments</button></span>
        <?php }?>
        <span><button type="button"
                      class="btn btn-outline-info waves-light waves-effect m-l-10">View Customer Feedback</button></span>
        <span><button type="button"
                      class="btn btn-outline-info waves-light waves-effect m-l-10">Designer’s Checklist</button></span>
        <span><button type="button" class="btn btn-outline-info waves-light waves-effect m-l-10">Check Timeline</button></span>

    </div>
</div>


<div style="display: none" id="cm_box" class="container artwork-images-cards m-t-t-10">
    <div class="row p-10">

                                            <span class="pull-left col-md-6">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a
                                                            href="#"><?= $this->Rejected_artwork_model->get_operator($assigny[0]->assigny); ?> </a></li>
                                                <li class="breadcrumb-item"><a
                                                            href="#"><?= $this->Rejected_artwork_model->get_operator($assigny[0]->designer); ?></a></li>
                                            </ol>
                                                </span>

        <span class="text-right col-md-6 p-t-6">
                                                <?= date('D'); ?>, <?= date('d'); ?> <?= date('M'); ?>
            , <?= date('Y'); ?> | <?= date('h'); ?>:<?= date('m'); ?> <?= date('A'); ?>
                                            </span>
    </div>

    <hr class="blue-hr">

    <div class="row">

        <div class="col-md-9">
            <form action="<?= main_url ?>Artworks/uploadChatForRejectedArtwork" method="post"
                  enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea class="form-control" rows="5" name="chat_detail" style="margin-top: 0px;margin-bottom: 0px;height: 140px;border-color: #d0effa;"></textarea>
                            <input type="hidden" name="orderIntegratedId" value="<?= $orderIntegratedId ?>">
                            <input type="hidden" name="orderNumber" value="<?= $orderNumber ?>">

                        </div>
                <div class="col-md-3">
                    <?php

                    if($userType == 88){ ?>

                 <?php if($attachmentItegrated->status !=65 && $attachmentItegrated->status !=68 && $attachmentItegrated->is_upload_print_file ==0){?>
                    <div class="upload-btn-wrapper">
                        <button class="btn btnn"><i class="fa fa-upload"></i> Upload Print File
                        </button>
                        <input type="file" name="pff_file"/>
                    </div>
                 <?php }elseif($attachmentItegrated->status ==65 && $attachmentItegrated->status ==68 && $attachmentItegrated->is_upload_print_file ==0){?>
                    <div class="upload-btn-wrapper">
                        <button class="btn btnn"><i class="fa fa-upload"></i> Upload design pdf
                        </button>
                        <input type="file" name="design"/>
                    </div>
                    <div class="upload-btn-wrapper">
                        <button class="btn btnn"><i class="fa fa-upload"></i> Upload soft-proof
                        </button>
                        <input type="file" name="sf_file"/>
                    </div>
                    <div class="upload-btn-wrapper">
                        <button class="btn btnn"><i class="fa fa-upload"></i> Upload Thumbnail pdf
                        </button>
                        <input type="file" name="thumnal"/>
                    </div>
                 <?php }}?>
                </div>

                        <div class="form-group m-b-0">
                            <div class="text-right">
                                <button type="submit"
                                        class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                    Submit
                                </button>
                            </div>
                        </div>


                </div>



            </form>

    </div>


</div>

<?php
foreach ($comments as $comment) {
    ?>
    <div class="container artwork-images-cards m-t-t-10 ">
        <div class="row p-10">

                                            <span class="pull-left col-md-6">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a
                                                            href="#"><?= $this->Rejected_artwork_model->get_operator($assigny[0]->assigny); ?> </a></li>
                                                <li class="breadcrumb-item"><a
                                                            href="#"><?= $this->Rejected_artwork_model->get_operator($comment->operator); ?></a></li>
                                            </ol>
                                                </span>

            <span class="text-right col-md-6 p-t-6">
                                                <?= date('D', strtotime($comment->time)); ?>
                , <?= date('d', strtotime($comment->time)); ?> <?= date('M', strtotime($comment->time)); ?>
                , <?= date('Y', strtotime($comment->time)); ?> | <?= date('h', strtotime($comment->time)); ?>
                :<?= date('m', strtotime($comment->time)); ?> <?= date('A', strtotime($comment->time)); ?>
                                            </span></div>

        <hr class="blue-hr">

        <div class="row m-b-10">

            <div class="col-md-9">
                <p class="m-h-100">
                    <?= $comment->comment ?>
                </p>

            </div>


            <div class="col-md-3">
                <?php if($comment->file !=null){?>
                <div class="upload-btn-wrapper">
                    <a href="<?=thm_rejected_artwork.'print'.'/'.$comment->file?>"  class="btn btnn"><i class="fa fa-upload"></i> Print File </a>

                </div>
                <?php }?>
                <?php if($comment->pdf !=null){?>
                <div class="upload-btn-wrapper">
                    <a target="_blank" href="<?=thm_rejected_artwork.'pdf'.'/'.$comment->pdf?>" class="btn btnn"><i class="fa fa-upload"></i>  design pdf </a>

                </div>
                <?php }?>
                <?php if($comment->softproof !=null){?>
                <div class="upload-btn-wrapper">
                    <a href="<?=thm_rejected_artwork.'softproof'.'/'.$comment->softproof?>"  class="btn btnn"><i class="fa fa-upload"></i>  soft-proof </a>

                </div>
                <?php }?>
                <?php if($comment->thumb !=null){?>
                <div class="upload-btn-wrapper">
                    <a href="<?=thm_rejected_artwork.'thumb'.'/'.$comment->thumb?>"  class="btn btnn"><i class="fa fa-upload"></i>  Thumbnail pdf </a>

                </div>
            </div>
            <?php }?>

                <?php if($attachmentItegrated->is_upload_print_file == 1 && $userId == DESIGNER && $comment->latest == 1){?>
                    <a href="<?=main_url?>Artworks/approveDecline?orderAttachId=<?=$attachmentItegrated->ID?>&orderNumber=<?=$orderNumber?>" type="submit"  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                        Approve / Decline
                    </a>

        <?php }?>


        </div>


    </div>
<?php } ?>