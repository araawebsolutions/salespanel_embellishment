<style>
    .labels-form *{
        margin-bottom: 10px;
    }
</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-headset"></i> ENQUIRY DETAILS</span> <span class="pull-right">
<button type="button" onclick="window.open('mailto:<?php echo $EnquiryDetail->Billingemail; ?>','_self','');"
        class="btn btn-primary waves-light waves-effect">Email Customer</button>
</span></div>
                    <div class="card-body">
                        <div class="row" style="">
                            <div class="col-md-4" style="display: flex;">
                                <div class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">USER INFORMATION</div>
                                    <div class="card-body">
                                        <div class="col-sm-12 card-space-text">
                                            <dl class="row" style="white-space:normal;">
                                                <dt class="col-sm-5">Enquiry No :</dt>
                                                <dd class="col-sm-7"><?= $EnquiryDetail->QuoteNumber ?></dd>
                                                <dt class="col-sm-5">Name :</dt>
                                                <dd class="col-sm-7">
                                                    <p> <?php echo $EnquiryDetail->BillingTitle . ' ' . $EnquiryDetail->BillingFirstName . ' ' . $EnquiryDetail->BillingLastName; ?></p>
                                                </dd>
                                                <dt class="col-sm-5">Address :</dt>
                                                <dd class="col-sm-7"> <?php echo $EnquiryDetail->BillingAddress1 . ' ' . $EnquiryDetail->BillingAddress2; ?></dd>
                                                <dt class="col-sm-5 text-truncate">Postcode :</dt>
                                                <dd class="col-sm-7"> <?php echo $EnquiryDetail->BillingPostcode; ?></dd>
                                                <dt class="col-sm-5">Email :</dt>
                                                <dd class="col-sm-7"> <?php echo $EnquiryDetail->Billingemail; ?></dd>
                                                <dt class="col-sm-5">Phone :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->BillingTelephone; ?></dd>
                                                <dt class="col-sm-5">Fax :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->BillingFax; ?></dd>
                                                <dt class="col-sm-5">Company :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->BillingCompanyName; ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display: flex;">
                                <div class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">ENQUIRY INFORMATION
                                    </div>
                                    <div class="card-body">
                                        <div class="col-sm-12 card-space-text">
                                            <dl class="row" style="white-space:normal;">
                                                <dt class="col-sm-5">Total Quantity :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->TotalLabelsReq; ?></dd>
                                                <dt class="col-sm-5">Label Category :</dt>
                                                <dd class="col-sm-7">
                                                    <p> <?php echo $EnquiryDetail->category; ?></p>
                                                </dd>
                                                <dt class="col-sm-5">Label Shape :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->Shape; ?></dd>
                                                <?php
                                                if ($EnquiryDetail->Shape == 'Circular') {
                                                    ?>
                                                    <dt class="col-sm-5 text-truncate">Radius mm &nbsp;:</dt>
                                                    <dd class="col-sm-7"><?php echo $EnquiryDetail->RectangleWidth; ?></dd>
                                                <?php } else {
                                                    ?>
                                                    <dt class="col-sm-5 text-truncate">Label Width mm :</dt>
                                                    <dd class="col-sm-7"><?php echo $EnquiryDetail->RectangleWidth; ?></dd>
                                                    <dt class="col-sm-5">Label Height mm :</dt>
                                                    <dd class="col-sm-7"> <?php echo $EnquiryDetail->RectangleHight; ?></dd>
                                                <?php } ?>
                                                <dt class="col-sm-5">Material :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->Material; ?>
                                                </dd>
                                                <dt class="col-sm-5">Color :</dt>
                                                <dd class="col-sm-7"><?php $color = $this->user_model->getColorName($EnquiryDetail->LabelColor);
                                                    echo $color; ?>  </dd>
                                                <dt class="col-sm-5">Adhesive :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->Adhesive; ?></dd>
                                                <dt class="col-sm-5">Printing Required :</dt>
                                                <dd class="col-sm-7"><?php echo $EnquiryDetail->PrintingRequired; ?></dd>
                                                <dt class="col-sm-5">Special Instructions :</dt>
                                                <dd class="col-sm-7">
                                                    <textarea class="form-control"
                                                              rows="5"><?php echo $EnquiryDetail->OtherInstruction; ?></textarea>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                   
                                    <div class="card-footer">
                                        <!-- Button trigger modal -->
<?php if ($EnquiryDetail->RequestStatus != '13') { ?>
                                        <a href="#"
                                           class="btn btn-secondary waves-light waves-effect enquiry-save-button col-md-3 float-right"
                                           data-toggle="modal" data-target="#myModal">Edit</a>
                                           <?}?>
                                        <!-- sample modal content -->
                                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                             aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel">Edit Enquiry
                                                            Information</h4>
                                                    </div>
                                                    <?php

                                                    ?>

                                                    <div class="modal-body">
                                                        <form role="form" method="post"
                                                              action="<?= main_url ?>updateEnquiry">
                                                            <input type="hidden" name="enquiry_number"
                                                                   value="<?= $EnquiryDetail->QuoteNumber ?>">
                                                            <div class="row">
                                                                <div class="col-md-6 ">
                                                                    <span class="labels-form">
                                                                    <div class="form-group">
                                                                        <label class="select">
                                                                        <select class="form-control" name="category"
                                                                                id="category"
                                                                                onchange="category_select(this.value);">
                                                                            <option>Select Category</option>
                                                                            <option <?php if ($EnquiryDetail->category == 'Labels on A4 Sheet') {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="A4 Labels">Labels on A4 Sheet
                                                                            </option>
                                                                            <option <?php if ($EnquiryDetail->category == 'Labels on A3 Sheet') {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="A3 Label">Labels on A3 Sheet
                                                                            </option>
                                                                            <option <?php if ($EnquiryDetail->category == 'Labels on SRA3 Sheets') {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="SRA3 Label">Labels on SRA3 Sheet
                                                                            </option>
                                                                            <option <?php if ($EnquiryDetail->category == 'Integrated') {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="Integrated Labels">Integrated
                                                                                Labels
                                                                            </option>
                                                                            <option <?php if ($EnquiryDetail->category == 'Labels on Roll') {
                                                                                echo 'selected="selected"';
                                                                            } ?> value="Roll Labels">Labels on Rolls
                                                                            </option>
                                                                        </select>
                                                                            <i></i>
                                                                        </label>
                                                                    </div>



                                                                    <div class="form-group" id="select_shape">
                                                                        <label class="select">
                                                                        <select class="form-control" name="Shape"
                                                                                id="Shape"
                                                                                onchange="changeShape(this.value);">
                                                                            <option>Label Shape</option>
                                                                            <?php foreach ($shapes as $shape) { ?>
                                                                                <option <?php if ($shape->Shape_upd == $EnquiryDetail->Shape){ ?>
                                                                                        selected
                                                                                        <?php } ?>value="<?= $shape->Shape_upd ?>"><?= $shape->Shape_upd ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                            <i></i></label>
                                                                    </div>
 </span>

                                                                    <div class="form-group">
                                                                        <input type="text" name="labelQuantity"
                                                                               style="height: 35px;"
                                                                               class="form-control"
                                                                               value="<?php echo $EnquiryDetail->TotalLabelsReq; ?>"
                                                                               placeholder="Label Quantity">
                                                                    </div>
                                                                    <?php
                                                                    $style1 = '';
                                                                    $style2 = '';
                                                                    if ($EnquiryDetail->Shape == 'Circular') {
                                                                        $style2 = 'style="display:none;"';
                                                                    } else {
                                                                        $style1 = 'style="display:none;"';

                                                                    } ?>
                                                                    <div id="heightwidth" <?php echo $style2; ?>>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                   name="labelWidth"
                                                                                   value="<?php echo $EnquiryDetail->RectangleWidth; ?>"
                                                                                   placeholder="Label Width MM"
                                                                                   style="height: 35px;">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                   name="labelHeight"
                                                                                   value="<?php echo $EnquiryDetail->RectangleHight; ?>"
                                                                                   placeholder="Label Height MM"
                                                                                   style="height: 35px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group"
                                                                         id="Radius" <?php echo $style1; ?>>
                                                                        <input type="text" class="form-control"
                                                                               style="height: 35px;"
                                                                               name="labelRadius"
                                                                               value="<?php echo $EnquiryDetail->RectangleWidth; ?>"
                                                                               placeholder="Radius ">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    $selected = $EnquiryDetail->LabelColor;
                                                                    $colors = $this->user_model->getcolors();

                                                                    ?>
                                                                    <span class="labels-form">

                                                                    <div class="form-group">
                                                                        <label class="select">
                                                                        <select class="form-control" name="Color">
                                                                            <option>Select Color</option>
                                                                            <?php foreach ($colors as $color) { ?>
                                                                                <option <?php if ($color->id == $EnquiryDetail->LabelColor) { ?> selected <?php } ?>
                                                                                        value="<?= $color->id ?>"><?= $color->colorDescription ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                            <i></i>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group" id="Material_sel">
                                                                        <label class="select">
                                                                        <select class="form-control" name="Material"
                                                                                id="material">
                                                                            <option>Select Material</option>
                                                                            <?php foreach ($materials as $material) { ?>
                                                                                <option <?php if ($EnquiryDetail->Material == $material->name){ ?>
                                                                                        selected
                                                                                        <?php } ?>value="<?= $material->name ?>"><?= $material->name ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                            <i></i></label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="select">
                                                                        <select class="form-control" name="Adhesive"
                                                                                id="Adhesive">
                                                                            <option value="Permanent" <?php if ($EnquiryDetail->Adhesive == 'Permanent') {
                                                                                echo 'selected="selected"';
                                                                            } ?>>Permanent
                                                                            </option>
                                                                            <option value="Removable" <?php if ($EnquiryDetail->Adhesive == 'Removable') {
                                                                                echo 'selected="selected"';
                                                                            } ?>>Removable
                                                                            </option>
                                                                            <option value="High Tack" <?php if ($EnquiryDetail->Adhesive == 'High Tack') {
                                                                                echo 'selected="selected"';
                                                                            } ?>>High Tack
                                                                            </option>
                                                                            <option value="Other" <?php if ($EnquiryDetail->Adhesive == 'Other') {
                                                                                echo 'selected="selected"';
                                                                            } ?>>Other
                                                                            </option>
                                                                        </select>
                                                                            <i></i></label>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="select">
                                                                        <select class="form-control" name="Printed"
                                                                                id="Printed"
                                                                                onchange="show_opt(this.value);">
                                                                            <option value="No" <?php if ($EnquiryDetail->PrintingRequired == 'No') {
                                                                                echo 'selected="selected"';
                                                                            } ?>>No
                                                                            </option>
                                                                            <option value="Yes" <?php if ($EnquiryDetail->PrintingRequired == 'Yes') {
                                                                                echo 'selected="selected"';
                                                                            } ?>>Yes
                                                                            </option>

                                                                        </select>
                                                                            <i></i></label>
                                                                    </div>
                                                                        <?php
                                                                        if ($EnquiryDetail->PrintingRequired == 'Yes') {
                                                                            ?>
                                                                            <div id="first_print">
                                                                            <div class="form-group">
                                                                                <label class="select">
                                                                                <select class="form-control"
                                                                                        name="Nofcolors" id="Nofcolors"
                                                                                >
                                                                                    <option value="0" <?php if ($EnquiryDetail->NoOfColors == '0') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>0
                                                                                    </option>
                                                                                    <option value="1" <?php if ($EnquiryDetail->NoOfColors == '1') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>1
                                                                                    </option>
                                                                                    <option value="2" <?php if ($EnquiryDetail->NoOfColors == '2') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>2
                                                                                    </option>
                                                                                    <option value="3" <?php if ($EnquiryDetail->NoOfColors == '3') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>3
                                                                                    </option>
                                                                                    <option value="4" <?php if ($EnquiryDetail->NoOfColors == '4') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>4
                                                                                    </option>
                                                                                </select>
                                                                                    <i></i></label>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="select">
                                                                                <select class="form-control"
                                                                                        name="Artwork" id="Artwork"
                                                                                >
                                                                                    <option value="supply" <?php if ($EnquiryDetail->Artwork == 'supply') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>Will be Supply
                                                                                    </option>
                                                                                    <option value="request" <?php if ($EnquiryDetail->Artwork == 'request') {
                                                                                        echo 'selected="selected"';
                                                                                    } ?>>Request to Create
                                                                                    </option>

                                                                                </select>
                                                                                    <i></i></label>
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                        <div style="display: none" id="if_print">
                                                                        <div class="form-group">
                                                                            <label class="select">
                                                                            <select class="form-control"
                                                                                    name="Nofcolors" id="Nofcolors"
                                                                            >
                                                                                <option value="0" <?php if ($EnquiryDetail->NoOfColors == '0') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>0
                                                                                </option>
                                                                                <option value="1" <?php if ($EnquiryDetail->NoOfColors == '1') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>1
                                                                                </option>
                                                                                <option value="2" <?php if ($EnquiryDetail->NoOfColors == '2') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>2
                                                                                </option>
                                                                                <option value="3" <?php if ($EnquiryDetail->NoOfColors == '3') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>3
                                                                                </option>
                                                                                <option value="4" <?php if ($EnquiryDetail->NoOfColors == '4') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>4
                                                                                </option>
                                                                            </select>
                                                                                <i></i></label>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="select">
                                                                            <select class="form-control" name="Artwork"
                                                                                    id="Artwork">
                                                                                <option value="supply" <?php if ($EnquiryDetail->Artwork == 'supply') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>Will be Supply
                                                                                </option>
                                                                                <option value="request" <?php if ($EnquiryDetail->Artwork == 'request') {
                                                                                    echo 'selected="selected"';
                                                                                } ?>>Request to Create
                                                                                </option>

                                                                            </select>
                                                                                <i></i></label>
                                                                        </div>
                                                                        </span>
                                                                </div>
                                                                <div class="form-group">
                                                                        <textarea class="form-control" rows="5"
                                                                                  name="spl_instruction"
                                                                                  placeholder="Special Instructions"><?php echo $EnquiryDetail->OtherInstruction; ?></textarea>
                                                                </div>
                                                            </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer" style="margin: 0px auto;">
                                                    <button type="button" onclick="closeEdit()"
                                                            class="btn btn-pink waves-effect waves-light col-md-12">
                                                        Back
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-purple waves-effect waves-light col-md-12">
                                                        Update
                                                    </button>
                                                </div>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card enquiry-card m-b-15">
                                <div class="card-header card-heading-text-two">ACTION</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label text-right">Status :</label>
                                        <?php if ($EnquiryDetail->RequestStatus != '13') { ?>
                                            <div class="col-8">
                                                <select class="form-control" id="statuss"
                                                        onchange="status_change('<?php echo $EnquiryDetail->QuoteNumber; ?>',this.value)"
                                                        name="statuss">
                                                    <option value="11"  <?php  if ($EnquiryDetail->RequestStatus == '11'){?> selected <?php }?> style="background:#cb5959; color:#FFFFFF;">
                                                        Require Action
                                                    </option>
                                                    <option value="12"  <?php  if ($EnquiryDetail->RequestStatus == '12'){?>  selected <?php }?> style="background:#ffe68b; color:#330000">
                                                        Awaiting Reply
                                                    </option>
                                                    <option value="13"  style="background:#70a772; color:#FFFFFF;">
                                                        Completed
                                                    </option>
                                                </select>
                                            </div>
                                        <?php } else {
                                            echo "<b style='color:#70a772; padding-top: 8px;'> Completed </b>";
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card enquiry-card m-b-15">
                                <div class="card-header card-heading-text-two">ATTACHMENT</div>
                                <div class="card-body" style="margin: 0px auto;">

                                    <?php if (@$EnquiryDetail->image) { ?>
                                        <a href="<?= ASSETS ?>assets/images/enquiry/<?= $EnquiryDetail->image ?>">
                                            <img src="<?= ASSETS ?>assets/images/enquiry/<?= $EnquiryDetail->image ?>"
                                                 width="100px" height="100px">
                                        </a>
                                    <?php } ?>

                                    <div class="upload-btn-wrapper">
                                        <?php
                                        if ($EnquiryDetail->Source == "Website" || $EnquiryDetail->Source == "Website-Enquiry" || $EnquiryDetail->Source == "Label Printing" || $EnquiryDetail->Source == "Custom Label Printing" || $EnquiryDetail->Source == "Contactus" || $EnquiryDetail->Source == "Checkout" || $EnquiryDetail->Source == "") {
                                            $path = "theme/integrated_attach/";
                                        } else {
                                            $path = "aalabels/uploads/";
                                        }
                                        $images = $this->user_model->getImages($EnquiryDetail->QuoteNumber);

                                        if (count($images) > 0) {

                                            foreach ($images as $image) {
                                                ?>
                                                <a href="<?php echo base_url() . $path . $image->UploadedFile; ?>"
                                                download="">
                                                <img id="<?php echo $image->ImageID ?>"
                                                     src="<?php echo base_url() . $path . $image->UploadedFile; ?>"
                                                     width="58" height="68" border="0">
                                            <?php } ?>
                                            </a>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card enquiry-card">
                                <div class="card-header card-heading-text-two">OPERATOR NOTES</div>
                                <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Notes :</label>
                                             <div class="col-8">
                                                 <form method="post" action="<?= main_url ?>updateEnquiry">
                                                        <input type="hidden" name="enquiry_number"
                                                               value="<?= $EnquiryDetail->QuoteNumber ?>">
                                                      <textarea class="form-control" name="operatorNotes" id= "note"
                                                          rows="5"><?php echo $EnquiryDetail->operatorNotes; ?>
                                                          </textarea>
                                                          <input type="hidden" name="Notes"
                                                               id= "txt" value="<?php echo $EnquiryDetail->operatorNotes; ?>"> 
                                             </div>
<?php if ($EnquiryDetail->RequestStatus != '13') { ?>
                                             <div class="modal-footer margin-left" style="margin: 0px auto;">
                                                    <button type="button" onclick="cancel_update('<?= $EnquiryDetail->QuoteNumber ?>');"
                                                            class="btn btn-outline-primary waves-light waves-effect width-select col-md-12">
                                                       Cancel
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-pink waves-light waves-effect width-select col-md-12">
                                                        Update
                                                    </button>
                                                </div>
                                                    <?}?>    
                                             </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- en row -->
</div>
<!-- en container -->
</div>
<!-- en wrapper -->
<script>
    function closeEdit() {
        $('#myModal').modal('hide');
    }

    function cancel_update(id)
    {   
        var upd = $("#txt").val(); 
         $("#note").val(upd);
    }

    function show_opt(val) {
        if (val == 'Yes') {
            $('#if_print').show();
        } else {
            $('#if_print').hide();
            $('#first_print').hide();
        }
    }


</script>