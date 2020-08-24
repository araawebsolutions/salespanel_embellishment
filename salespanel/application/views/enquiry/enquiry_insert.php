<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-heading-text">
                        <span><i class="mdi mdi-headset"></i> ENQUIRY DETAILS</span> <span class="pull-right">

                    </span></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">USER INFORMATION</div>
                                    <div class="card-body">
                                        <div class="col-sm-12 card-space-text">
                                            <dl class="row">
                                                <dt class="col-sm-6">Enquiry No : <?= $eqno ?></dt>
                                                <dt class="col-sm-6">Source : Admin</dt>
                                            </dl>
                                            <form role="form" method="post" action="<?= main_url ?>insertEnquiry"
                                                  enctype="multipart/form-data">
                                                <input type="hidden" name="enqno" value="<?= $eqno ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <span class="labels-form">
                                                            <label class="select">
                                                            <select class="form-control" required id="title"
                                                                    name="title">
                                                                <option value="Mr">Mr</option>
                                                                <option value="Ms">Ms</option>
                                                                <option value="Mrs">Mrs</option>
                                                                <option value="Miss">Miss</option>
                                                                <option value="Dr">Doctor</option>
                                                            </select>
                                                            <i></i>
                                                        </label>
                                                        </span>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="lastname" id="exampleInputtext1"
                                                                   placeholder="Last Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="AddressA" id="exampleInputtext1"
                                                                   placeholder="Address 1">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="email" class="form-control"
                                                                   style="height: 35px" required name="Email" id="email"
                                                                   placeholder="Email">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" name="postcode" style="height: 35px"
                                                                   required class="form-control" id="exampleInputtext1"
                                                                   placeholder="Post Code">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="Country" id="exampleInputtext1"
                                                                   placeholder="Country">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="Fax" id="exampleInputtext1"
                                                                   placeholder="Fax">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="firstname" id="exampleInput1"
                                                                   placeholder="First Name">
                                                        </div>


                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="AddressB" id="exampleInputtext1"
                                                                   placeholder="Address 2">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="City" id="exampleInputtext1"
                                                                   placeholder="City / Town">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="Company" id="exampleInputtext1"
                                                                   placeholder="Company">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   required name="Telephone" id="exampleInputtext1"
                                                                   placeholder="Telephone #">
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card enquiry-card card-enquiry-height">
                                    <div class="card-header card-heading-text-two">ENQUIRY INFORMATION</div>
                                    <div class="card-body">
                                        <div class="col-sm-12 card-space-text">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <span class="labels-form">
                                                            <label class="select">
                                                        <select class="form-control" id="category" required
                                                                name="category" onchange="category_select(this.value)">
                                                            <option>Select Category</option>
                                                            <option value="A4 Labels">Labels on A4 Sheet</option>
                                                            <option value="A3 Label">Labels on A3 Sheet</option>
                                                            <option value="SRA3 Label">Labels on SRA3 Sheet</option>
                                                            <option value="Integrated Labels">Integrated Labels</option>
                                                            <option value="Roll Labels">Labels on Rolls</option>
                                                        </select>
                                                            <i></i>
                                                            </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <span class="labels-form">
                                                            <label class="select">
                                                        <select class="form-control" name="Shape" required id="Shape"
                                                                onchange="changeShape(this.value)">
                                                            <option value="">Select Shape</option>
                                                        </select>
                                                                <i></i></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <span class="labels-form">
                                                            <label class="select">
                                                        <select class="form-control" name="Material" id="material">
                                                            <option selected="selected" value="">Select Material
                                                            </option>
                                                        </select>
                                                                <i></i></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" style="height: 35px"
                                                               required name="labelQuantity" id="exampleInputtext1"
                                                               placeholder="Label Quantity">
                                                    </div>
                                                    <div id="heightwidth">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   name="labelWidth" id="exampleInputtext1"
                                                                   placeholder="Label Width MM">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" style="height: 35px"
                                                                   name="labelHeight" id="exampleInputtext1"
                                                                   placeholder="Label Height MM">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="Radius" style="display: none">
                                                        <input type="text" class="form-control" style="height: 35px"
                                                               name="CornerRadius" id="exampleInputtext1"
                                                               placeholder="Radius">
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <?php

                                                    $colors = $this->user_model->getcolors();

                                                    ?>
                                                    <div class="form-group">
                                                        <span class="labels-form">
                                                            <label class="select">
                                                        <select class="form-control" name="Color">
                                                            <option>Select Color</option>
                                                            <?php foreach ($colors as $color) { ?>
                                                                <option value="<?= $color->id ?>"><?= $color->colorDescription ?></option>
                                                            <?php } ?>
                                                        </select><i></i></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <span class="labels-form">
                                                            <label class="select">
                                                        <select class="form-control" name="Adhesive" id="Adhesive">
                                                            <option value="Permanent">Permanent</option>
                                                            <option value="Removable">Removable</option>
                                                            <option value="High Tack">High Tack</option>
                                                            <option value="Other">Other</option>
                                                        </select><i></i></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <span class="labels-form">
                                                            <label class="select">
                                                        <select class="form-control" name="Printed" id="Printed"
                                                                onclick="show_opt(this.value)">
                                                            <option>Printed ?</option>
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                                <i></i></label>
                                                    </div>
                                                   <div class="form-group">
                                                                        <textarea class="form-control" rows="5"
                                                                                  name="Instructions" id =""
                                                                                  placeholder="Special Instructions"></textarea>
                                                    </div>

                                                    <div id="if_print" style=" display: none">
                                                        <div class="form-group">
                                                            <span class="labels-form">
                                                            <label class="select">
                                                            <select class="form-control" name="Printcolors"
                                                                    id="Printcolors">
                                                                <option value="Spot">Spot</option>
                                                                <option value="Process">Process</option>
                                                            </select>
                                                                <i></i></label>
                                                        </div>
                                                        <div class="form-group">
                                                            <span class="labels-form">
                                                            <label class="select">
                                                            <select class="form-control" name="Nofcolors"
                                                                    id="Nofcolors">
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                                <i></i></label>
                                                        </div>

                                                        <div class="form-group">
                                                            <span class="labels-form">
                                                            <label class="select">
                                                            <select class="form-control" name="Artwork" id="Artwork">
                                                                <option value="supply">Will be Supply</option>
                                                                <option value="request">Request to Create</option>
                                                            </select>
                                                                <i></i></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card enquiry-card m-b-15">
                                    <div class="card-header card-heading-text-two">ATTACHMENT</div>
                                    <div class="card-body card-body-heigh-adjust">
                                        <div class="upload-btn-wrapper enquiry" style="text-align: center !important;">
                                            <button class="btn-file-enquiry">
                                                <i class="mdi mdi-cloud-upload file-icon-upload"></i></button>
                                            <input type="file" name="file" class="artwork_file"/>
                                            <input type="hidden" id="arworklineCounter" value="0">
                                            <img width="90px" height="90px" class="img-circle" style="display: none;"
                                                 title="Click here to remove this file" id="preview_po_img0" src="#">

                                        </div>
                                    </div>
                                </div>

                                <div class="card enquiry-card">
                                    <div class="card-header card-heading-text-two">OPERATOR NOTES</div>
                                    <div class="card-body card-body-heigh-adjust">
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Notes :</label>
                                            <div class="col-8">
                                                <textarea class="form-control" name="operatorNotes" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="pull-right m-t-50">
                        <button type="submit" class="btn btn-secondary waves-light waves-effect enquiry-save-button">Submit <i
                                    class="mdi mdi-arrow-right-bold-circle"></i></button>
                        </span></div>
                        </div>
                    </div>
                    </form>
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
    function show_opt(val) {
        if (val == 'Yes') {
            $('#if_print').show();
        } else {
            $('#if_print').hide();
        }
    }
</script>