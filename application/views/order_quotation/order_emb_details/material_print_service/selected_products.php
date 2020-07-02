<div class="thumbnail">
    <div class="row dm-row">
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 dm-box">
            <div class="thumbnail prMatDC">

                <!-- <div class="thumbnail prMatDC prMatBgHeight">-->
                <div class="clear5"></div>
                <?
                $min_height = 'height:301px;';
                if (isset($a4details) and $a4details != '' and isset($rolldetails) and $rolldetails != '') {
                    $min_height = '';
                }


                if (isset($rolldetails) and $rolldetails != '') {

                    $label_size = str_replace("Label Size:", "", $rolldetails['specification3']);
                    $label_size = ucwords($label_size);
                    $label_size = str_replace("Mm", "mm", $label_size);

                    $category_id = str_replace("R1", "", $rolldetails['CategoryID']);
                    $rollcores = $this->home_model->roll_core_sizes($category_id, 'R4');

                    //$ManufactureID = substr($rolldetails['ManufactureID'],0,-1);

                    $min_qty = $this->home_model->min_qty_roll($rolldetails['ManufactureID']);
                    $max_qty = $this->home_model->max_total_labels_on_rolls($rolldetails['LabelsPerSheet']);
                    $min_labels_per_roll = $this->home_model->min_labels_per_roll($min_qty);


                    $image = explode('.', $rolldetails['CategoryImage']);
                    $img_chgr = $image[0];
                    $imagename = $image[0];

                    $imagecode = substr($rolldetails['ManufactureID'], 0, -1);
                    //$img_src = Assets."images/categoryimages/RollLabels/outside/".$rolldetails['ManufactureID'].".jpg";
                    $img_src = Assets . "images/categoryimages/RollLabels/outside/" . $imagecode . "4.jpg";

                    if (!getimagesize($img_src)) {
                        $img_src = Assets . "images/categoryimages/RollLabels/" . $imagename . ".jpg";
                    }
                    if (!getimagesize($img_src)) {
                        $img_src = Assets . "images/categoryimages/roll_desc/" . $imagename . 'R4' . ".jpg";
                    }
                    //$pname=str_replace('-','',$rolldetails['ProductName']).' Adhesive '.' '.$label_size.' '.ucfirst($rolldetails['Shape']);
                    $pname = str_replace('-', '', $rolldetails['ProductName']) . ' Adhesive ';


                    //$digitalprocess = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $rolldetails['digitalprocess']);


                    ?>
                    <input type="hidden" id="labels_p_sheet<?= $rolldetails['ProductID'] ?>" value="<?= $rolldetails['LabelsPerSheet'] ?>"/>
                    <input type="hidden" id="min_rolls<?= $rolldetails['ProductID'] ?>" value="<?= $min_qty ?>"/>
                    <input type="hidden" id="min_qty<?= $rolldetails['ProductID'] ?>"
                           value="<?= $min_labels_per_roll ?>"/>
                    <input type="hidden" id="max_qty<?= $rolldetails['ProductID'] ?>" value="<?= $max_qty ?>"/>
                    <input type="hidden" id="digitalprocess<?= $rolldetails['ProductID'] ?>"
                           value="<?= $rolldetails['digitalprocess'] ?>"/>
                    <input type="hidden" id="rollfinish<?= $rolldetails['ProductID'] ?>"
                           value="<?= $rolldetails['rollfinish'] ?>"/>
                    <input type="hidden" id="producttype<?= $rolldetails['ProductID'] ?>" value="roll"/>
                    <input type="hidden" id="calculation_unit<?= $rolldetails['ProductID'] ?>" value="labels"/>
                    <div class="col-xs-12 roll_sheets_block">
                        <div class="title"><b class="col-sm-12 col-xs-12">Rolls -
                                <?= $pname ?>
                            </b></div>
                        <div class="row">
                            <div class="clear10"></div>
                            <!--<div class="col-lg-12 col-md-12 col-sm-12 no-margin"><h4 class="m-l-10 m-t-10"><strong>  &nbsp;</strong></h4></div>-->

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center RDthumb"><img
                                        onerror='imgError(this);' src="<?= $img_src ?>" data-core="R1"
                                        data-imagename="<?= $imagename ?>" alt="AA Labels Printed Labels"
                                        id="wound_image" class="img-responsive">
                                <div class="clear"></div>
                                <div class="text-center col-xs-12 no-padding"><b>Short code</b><br/>
                                    <span name="productcode_text">
                <?= $rolldetails['ReOrderCode']?>
                
                </span></div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                                <div class="labels-form">
                                    <label class="select">
                                        <select id="label_coresize">
                                            <?= $rollcores ?>
                                        </select>
                                        <i></i> </label>
                                        
                                    <label class="select">
                                        <select id="woundoption">
                                            <option value="Outside" <?php if($wound_roll['wound_roll'] == 'Outside'){echo "selected='selected'";}?> >Outside Wound</option>
                                            <option value="Inside" <?php if($wound_roll['wound_roll'] == 'Inside'){echo "selected='selected'";}?> >Inside Wound</option>
                                        </select>
                                        <i></i> </label>
                                    <!-- <input type="hidden" value="orientation1" id="label_orientation"/> -->
                                    <!-- <div class="btn-group btn-block dm-selector">

                                      <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" data-value="">Orientation 01<i class="fa fa-unsorted"></i></a>
                                        <ul class="dropdown-menu btn-block">
                                            
                                            <li class="outsideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first." data-id="orientation1">
                                                Orientation 01 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="outsideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first." data-id="orientation2">
                                                Orientation 02 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                              data-trigger="hover"
                                                                              data-placement="right"
                                                                              title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                              data-id="orientation3"> Orientation 03
                                                    <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif"></a>
                                            </li>
                                            <li class="outsideorientation"><a data-toggle="tooltip-orintation"
                                                                              data-trigger="hover"
                                                                              data-placement="right"
                                                                              title="Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label of first."
                                                                              data-id="orientation4"> Orientation 04
                                                    <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif"></a>
                                            </li>
                                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                             data-trigger="hover" data-placement="right"
                                                                             title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first."
                                                                             data-id="orientation5"> Orientation 05 <img
                                                            onerror='imgError(this);'
                                                            src="<?= Assets ?>images/loader.gif"></a></li>
                                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                             data-trigger="hover" data-placement="right"
                                                                             title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first."
                                                                             data-id="orientation6"> Orientation 06 <img
                                                            onerror='imgError(this);'
                                                            src="<?= Assets ?>images/loader.gif"> </a></li>
                                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                             data-trigger="hover" data-placement="right"
                                                                             title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first."
                                                                             data-id="orientation7"> Orientation 07 <img
                                                            onerror='imgError(this);'
                                                            src="<?= Assets ?>images/loader.gif"> </a></li>
                                            <li class="insideorientation"><a data-toggle="tooltip-orintation"
                                                                             data-trigger="hover" data-placement="right"
                                                                             title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first."
                                                                             data-id="orientation8"> Orientation 08 <img
                                                            onerror='imgError(this);'
                                                            src="<?= Assets ?>images/loader.gif"></a></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row">

                                    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <input class="form-control input-quantities allownumeric" maxlength="5" onfocus="show_calculate_btn(<?= $rolldetails['ProductID'] ?>);"
                        id="design_qty_<?= $rolldetails['ProductID'] ?>" placeholder="No. of Designs " type="text">
               <small class="oQty col-xs-12 text-center no-padding" style="">Add Number of Designs</small> 
            </div>-->

                                    <div class="col-xs-10 pull-right">
                                        <input class="form-control input-quantities allownumeric display_sheets"
                                               maxlength="10" data-toggle="popover" data-content=""
                                               onfocus="show_calculate_btn(<?= $rolldetails['ProductID'] ?>);"
                                               id="sheet_qty_<?= $rolldetails['ProductID'] ?>"
                                               placeholder="Minimum <?= $min_labels_per_roll ?> labels" type="text">
                                        <small class="oQty col-xs-12 text-center no-padding minimum_roll_lbs"
                                               style=""></small></div>
                                </div>
                                <div class="clear10"></div>
                                <div class="col-xs-12 no-padding">
                                    <table class="price" width="100%" id="price_box_<?= $rolldetails['ProductID'] ?>"
                                           style="display:none;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr id="fullprintprice<?= $rolldetails['ProductID'] ?>">
                                            <td class="text-left phead">Plain Labels Price</td>
                                            <td class="printprice text-right"><b class="pr-sm">0.00</b></td>
                                        </tr>
                                        <tr id="printprice<?= $rolldetails['ProductID'] ?>">
                                            <td class="text-left phead">Printed Black</td>
                                            <td class="printprice text-right"><b class="pr-sm">£12.50</b></td>
                                        </tr>
                                        <tr id="promoprice<?= $rolldetails['ProductID'] ?>">
                                            <td class="text-left phead"><strong style="color:#fd4913">Half Price
                                                    Promotion</strong></td>
                                            <td class="promoprice text-right"><b class="pr-sm">£0.00</b></td>
                                        </tr>
                                        <tr id="finishprice<?= $rolldetails['ProductID'] ?>">
                                            <td class="text-left phead">Label Finish Price</td>
                                            <td class="finishprice text-right"><b class="pr-sm">0.00</b></td>
                                        </tr>

                                        <!--<tr id="desginprice<?= $rolldetails['ProductID'] ?>">
                    <td class="numberdesign text-left phead">Studio (<strong>1 Design Free</strong>) </td>
                    <td class="desginprice text-right"><b class="pr-sm">£0.00</b></td>
                  </tr>-->

                                        <!--<tr>
                                            <td class="numberdesign text-left phead labels-form">
                                                <label class="checkbox" style="font-size:12px; text-align:justify !important;">
                                                <input id="pressproof" value="0" type="checkbox" class="textOrange"> <i></i>
                                                       <span><strong>Press Proof</strong>
                                                       <br /><small>Studio Electronic Soft-Proof (Free)</small>
                                                       </span>
                                                 </label>
                                            </td>
                                            <td class="pressproof text-right" valign="top"><b class="pr-sm">£0.00</b></td>
                                          </tr>-->

                                        <tr id="total<?= $rolldetails['ProductID'] ?>" class="total">
                                            <td class="phead" valign="middle"><strong>Line Total (Ex VAT)</strong></td>
                                            <td class="text-right">
                                                <div class="price" id="price_<?= $rolldetails['ProductID'] ?>"><b
                                                            class="color-orange"> £19.60 </b></div>
                                            </td>
                                        </tr>
                                        <tr id="penceperlabels<?= $rolldetails['ProductID'] ?>">
                                            <td colspan="2" class="text-right phead"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button id="cal_btn<?= $rolldetails['ProductID'] ?>"
                                            onclick="calculate_sheet_price('<?= $rolldetails['ProductID'] ?>','<?= $rolldetails['ManufactureID'] ?>');"
                                            class="btn orange cal_btn pull-right" type="button"> Calculate Price <i
                                                class="fa fa-calculator"></i></button>
                                    <button id="add_btn<?= $rolldetails['ProductID'] ?>" class="btn orangeBg btn-block"
                                            style="display:none;" type="button"
                                            onclick="add_item('<?= $rolldetails['ProductID'] ?>','<?= $rolldetails['ManufactureID'] ?>');">
                                        Proceed with printed labels on rolls &nbsp;&nbsp;
                                    </button>
                                    <h6 style="display:none;" class="basepricetext text-right"></h6>
                                </div>
                                <div class="col-sm-12 col-xs-12 delvStatus text-right"><b> Free Delivery </b></div>
                            </div>
                            <div class="clear10"></div>
                            <div class="col-md-12 guarantee_boxes">
                                <div class="col-md-4 first_icon_box col-sm-4">
                                    <h5><a data-toggle="tooltip-orintation" data-placement="top"
                                           class="tooltip-guarantee" title=""
                                           data-original-title="Using state-of-the-art digital press technology, reel-to-reel liquid electrophotography printing delivers the  highest image resolution and registration accuracy. Producing crisp, attractive images with a very thin ink layer and uniform gloss between ink and label substrates."><img
                                                    onerror='imgError(this);' src="<?= Assets ?>images/check-circle.png"
                                                    class="circle-icon"/> Superior Quality<br/>
                                            <span>Electrostatic Ink</span></a></h5>
                                </div>
                                <div class="col-md-4 second_icon_box col-sm-4">
                                    <h5><i class="fa fa-truck"></i> Free Delivery<br/>
                                        <span><a href="<?= base_url() ?>delivery/" target="_blank"><i
                                                        class="glyphicon glyphicon-new-window"></i> Delivery & Shipping Options</a></span>
                                    </h5>
                                </div>
                                <div class="col-md-4 third_icon_box col-sm-4">
                                    <h5><a data-toggle="tooltip-orintation" data-placement="top"
                                           class="tooltip-guarantee" title=""
                                           data-original-title="If within 7 days of buying this product from us, you find the same product cheaper at any other UK online label website, we will refund 100% of the difference."><img
                                                    onerror='imgError(this);' src="<?= Assets ?>images/check-circle.png"
                                                    class="circle-icon"/> Lowest Prices<br/>
                                            <span>Online Guaranteed</span></a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <? }

                if (isset($a4details) and $a4details != '') {

                    $label_size = str_replace("Label Size:", "", $a4details['specification3']);
                    $label_size = ucwords($label_size);
                    $label_size = str_replace("Mm", "mm", $label_size);

                    $x = explode("per A4", $a4details['CategoryName']);
                    $label_on_sheets = $x[0];
                    $img_src = Assets . "images/categoryimages/A4Sheets/colours/" . $a4details['ManufactureID'] . ".png";

                    if (preg_match("/PETC/", $a4details['ManufactureID']) || preg_match("/PETH/", $a4details['ManufactureID']) || preg_match("/PVUD/", $a4details['ManufactureID'])) {
                        $min_qty = '5';
                        $max_qty = '5000';
                    } else {
                        $min_qty = 25;
                        $max_qty = 50000;
                    }

                    //$pname=str_replace('-','',$a4details['ProductName']).' Adhesive '.' '.$label_size.' '.ucfirst($a4details['Shape']);
                    $pname = str_replace('-', '', $a4details['ProductName']) . ' Adhesive ';

                    //$digitalprocess = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $a4details['digitalprocess']);

                    ?>
                    <div class="col-xs-12 a4_sheets_block">
                        <input type="hidden" id="labels_p_sheet<?= $a4details['ProductID'] ?>" value="<?= $a4details['LabelsPerSheet'] ?>"/>
                        <input type="hidden" id="min_qty<?= $a4details['ProductID'] ?>" value="<?= $min_qty ?>"/>
                        <input type="hidden" id="max_qty<?= $a4details['ProductID'] ?>" value="<?= $max_qty ?>"/>
                        <input type="hidden" id="digitalprocess<?= $a4details['ProductID'] ?>" value="<?= $a4details['digitalprocess'] ?>"/>
                        <input type="hidden" id="producttype<?= $a4details['ProductID'] ?>" value="sheet"/>
                        <input type="hidden" id="calculation_unit<?= $a4details['ProductID'] ?>" value="sheets"/>
                        <div class="title"><b class="col-sm-12 col-xs-12">A4 Sheet -
                                <?= $pname ?>
                            </b></div>
                        <div class="row">
                            <!--<div class="col-lg-12 col-md-12 col-sm-12 no-margin"><h4 class="m-l-10 m-t-10"><strong> &nbsp;</strong></h4></div>-->
                            <div class="clear10"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center RDthumb"><img
                                        onerror='imgError(this);' src="<?= $img_src ?>" class="img-responsive">
                                <div class="clear"></div>
                                <a href="#" data-toggle="modal" data-target=".layout" imgpath="<?= $img_src ?>"
                                   id="<?= $a4details['CategoryID'] ?>"
                                   class="btn-sm btn-block btn-link text-center layout_specs"><i
                                            class="fa fa-search-plus" aria-hidden="true"></i> Layout</a></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10 caption">
                                <h2 class="no-margin no-padding">
                                    <?= $label_on_sheets ?>
                                </h2>
                                <b>Item code</b>
                                <div class="clear"></div>
                                <span name="productcode_text">
              <?= $a4details['ManufactureID'] ?>
              </span></div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="col-xs-10 pull-right no-padding">
                                    <div class="input-group">
                                        <input class="form-control input-quantities allownumeric display_sheets"
                                               maxlength="10" data-toggle="popover" data-content=""
                                               onfocus="show_calculate_btn(<?= $a4details['ProductID'] ?>);"
                                               id="sheet_qty_<?= $a4details['ProductID'] ?>"
                                               placeholder="Minimum <?= $min_qty ?>" type="text">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">Sheets <span class="caret"></span></button>
                                            <ul class="dropdown-menu dropdown-menu-right calculation_unit">
                                                <li><a href="javascript:void(0);">Sheets</a></li>
                                                <li><a href="javascript:void(0);">Labels</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <small class="oQty col-xs-12 no-padding text-center"></small></div>
                                <div class="clear10"></div>
                                <div class="col-xs-12 no-padding">
                                    <table class="price" width="100%" id="price_box_<?= $a4details['ProductID'] ?>"
                                           style="display:none;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr id="plainprice<?= $a4details['ProductID'] ?>">
                                            <td class="text-left phead">Plain Labels</td>
                                            <td class="plainprice text-right"><b class="pr-sm"></b></td>
                                        </tr>
                                        <tr id="printprice<?= $a4details['ProductID'] ?>">
                                            <td class="text-left phead">Printed Black</td>
                                            <td class="printprice text-right"><b class="pr-sm">£12.50</b></td>
                                        </tr>
                                        <tr id="promoprice<?= $a4details['ProductID'] ?>">
                                            <td class="text-left phead"><strong style="color:#fd4913">Half Price
                                                    Promotion</strong></td>
                                            <td class="promoprice text-right"><b class="pr-sm">£0.00</b></td>
                                        </tr>

                                        <!--<tr id="desginprice<?= $a4details['ProductID'] ?>">
                    <td class="numberdesign text-left phead">Studio (<strong>1 Design Free</strong>) </td>
                    <td class="desginprice text-right"><b class="pr-sm">£0.00</b></td>
                  </tr>-->

                                        <tr id="total<?= $a4details['ProductID'] ?>" class="total">
                                            <td valign="middle"><strong>Line Total (Ex VAT)</strong></td>
                                            <td class="text-right">
                                                <div class="price" id="price_<?= $a4details['ProductID'] ?>"><b
                                                            class="color-orange"> £19.60 </b></div>
                                            </td>
                                        </tr>
                                        <tr id="penceperlabels<?= $a4details['ProductID'] ?>">
                                            <td colspan="2" class="text-right phead"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button id="cal_btn<?= $a4details['ProductID'] ?>"
                                            onclick="calculate_sheet_price('<?= $a4details['ProductID'] ?>','<?= $a4details['ManufactureID'] ?>');"
                                            class="btn orange pull-right cal_btn cal_sheet" type="button"> Calculate
                                        Price <i class="fa fa-calculator"></i></button>
                                    <button id="add_btn<?= $a4details['ProductID'] ?>" class="btn orangeBg btn-block"
                                            style="display:none;" type="button"
                                            onclick="add_item('<?= $a4details['ProductID'] ?>','<?= $a4details['ManufactureID'] ?>');">
                                        Proceed with printed labels on sheets
                                    </button>
                                    <h6 style="display:none;" class="basepricetext text-right"></h6>
                                </div>
                                <div id="delivery_txt<?= $a4details['ProductID'] ?>"
                                     class="col-sm-12 col-xs-12 delvStatus text-right" style="display:none;"></div>
                            </div>
                            <div class="clear10"></div>
                            <div class="col-md-12 guarantee_boxes">
                                <div class="col-md-4 first_icon_box col-sm-4">
                                    <h5><a data-toggle="tooltip-orintation" data-placement="top"
                                           class="tooltip-guarantee" title=""
                                           data-original-title="Sheet-fed digital press technology, using electrostatic dry toner printing delivers high quality image resolution and good registration accuracy. Producing crisp, attractive, value-for-money images."><img
                                                    onerror='imgError(this);' src="<?= Assets ?>images/check-circle.png"
                                                    class="circle-icon"/> High Quality<br/>
                                            <span>Digital Print</span></a></h5>
                                </div>
                                <div class="col-md-4 second_icon_box col-sm-4">
                                    <h5><i class="fa fa-truck"></i> Free Delivery<br/>
                                        <span>on orders over
                  <?= $this->home_model->currecy_converter('25', 'yes'); ?>
                  Inc. VAT</span></h5>
                                </div>
                                <div class="col-md-4 third_icon_box col-sm-4">
                                    <h5><a data-toggle="tooltip-orintation" data-placement="top"
                                           class="tooltip-guarantee" title=""
                                           data-original-title="If within 7 days of buying this product from us, you find the same product cheaper at any other UK online label website, we will refund 100% of the difference."><img
                                                    onerror='imgError(this);' src="<?= Assets ?>images/check-circle.png"
                                                    class="circle-icon"/> Lowest Prices<br/>
                                            <span>Online Guaranteed</span></a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <? }

                if ($min_height) {
                    ?>
                    <div class="clear15"></div>
                <? } ?>

                <!-- <div class="clear30"></div>

              <div class="col-xs-12"><hr noshade="noshade" /></div>-->
                <div class="clear"></div>
                <div class="col-md-5 col-sm-12"><a href="javascript:void(0);" class="btn-block btn blue2 step-back"
                                                   data-value="2" role="button"> <i class="fa fa-arrow-circle-left"></i>
                        Back to Material & Finish</a></div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
            <!--<div class="thumbnail lSum prMatBgHeight">-->
            <div class="thumbnail lSum">
                <div class="clear5"></div>
                <div class="col-xs-12">
                    <div class="title"><b class="col-sm-12 col-xs-12">Selection Summary</b></div>
                    <div class="detail" style=" <?= ($min_height) ? '' : 'min-height:578px;' ?>">
                        <?
                        if ($min_height) {
                            $classes = "col-xs-12 col-sm-12 col-md-12";
                        } else {
                            $classes = "col-xs-6 col-sm-6 col-md-6";
                        }
                        if (isset($rolldetails) and $rolldetails != '') { ?>
                            <div class="<?= $classes ?> roll_sidebar">
                                <div class="sfr">
                                    <div class="title">
                                        <div class="roll-icon pull-left"><img onerror='imgError(this);' class=""
                                                                              src="<?= Assets ?>images/categoryimages/labelShapes/printed_roll.png">
                                        </div>
                                        <h4 class="pull-left no-margin">Selection for<br> Rolls</h4>
                                    </div>
                                    <div class="text-center f-12"><img onerror='imgError(this);' height="115" class="windingimage" src="<?= Assets ?>images/categoryimages/winding/Outside/orientation1.png">
                                        <div class="clear10"></div>
                                    </div>
                                </div>
                                <p style="padding: 5px;text-align:center;font-size:10px;">This image is to show print
                                    orientation and the roll winding only. Do not refer to this image for shape and Size
                                    of your label.</p>
                                <?= ($min_height) ? '<div class="clear10"></div>' : '' ?>
                                <p><b>Code:</b> <span name="productcode_text">
                <?= $rolldetails['ManufactureID'] ?>
                </span></p>
                                <p><b>Shape:</b> <span>
                <?= $rolldetails['Shape'] ?>
                </span></p>
                                <p><b>Label Size:</b> <span>
                <?= $label_size ?>
                </span></p>
                                <p><b>Material:</b><span name="material_text">
                <?= $rolldetails['ColourMaterial_upd'] ?>
                </span></p>
                                <p><b>Colour: </b><span name="color_text">
                <?= $rolldetails['LabelColor_upd'] ?>
                </span></p>
                                <p><b>Adhesive: </b><span name="adhesive_text">
                <?= $rolldetails['Adhesive'] ?>
                </span></p>
                                <p><b>Digital Process: </b><span name="digital_proccess_text"><br/>
                <?= $rolldetails['digitalprocess'] ?>
                </span></p>
                                <p><b>Finish: </b><span name="finish_text">
                <?= $rolldetails['rollfinish'] ?>
                </span></p>
                
                <p id="roll_orientation_text"><b>Orientation 01: </b><br>
                    <span>Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first.</span>
                </p>
                            </div>
                        <? }
                        if (isset($a4details) and $a4details != '') {
                            $img_src = Assets . "images/categoryimages/A4Sheets/colours/" . $a4details['ManufactureID'] . ".png";
                            ?>
                            <div class="<?= $classes ?>">
                                <div class="sfl">
                                    <div class="title">
                                        <div class="sheet-icon pull-left"><img onerror='imgError(this);' class=""
                                                                               src="<?= Assets ?>images/categoryimages/labelShapes/printed_sheet.png">
                                        </div>
                                        <h4 class="pull-left no-margin">Selection for<br>
                                            A4 Sheet</h4>
                                    </div>
                                    <div class="text-center"><img onerror='imgError(this);' class="" width="95"
                                                                  height="" src="<?= $img_src ?>">
                                        <div class="clear10"></div>
                                    </div>
                                </div>
                                <?= ($min_height) ? '<div class="clear10"></div>' : '<div class="clear30" style="margin-top: 20px;"></div>' ?>
                                <p><b>Code:</b> <span name="productcode_text">
                <?= $a4details['ManufactureID'] ?>
                </span></p>
                                <p><b>Shape:</b> <span>
                <?= $a4details['Shape'] ?>
                </span></p>
                                <p><b>Label Size:</b> <span>
                <?= $label_size ?>
                </span></p>
                                <p><b>Material:</b><span name="material_text">
                <?= $a4details['ColourMaterial_upd'] ?>
                </span></p>
                                <p><b>Colour: </b><span name="color_text">
                <?= $a4details['LabelColor_upd'] ?>
                </span></p>
                                <p><b>Adhesive: </b><span name="adhesive_text">
                <?= $a4details['Adhesive'] ?>
                </span></p>
                                <p><b>Digital Process: </b> <span name="digital_proccess_text"><br/>
                <?= $a4details['digitalprocess'] ?>
                </span></p>
                                <p><b>Finish: </b><span> Finish not available</span></p>
                                <!--<p style=" visibility:hidden;"><b>Finish: </b><span name="finish_text"></span></p>-->
                            </div>
                        <? } ?>
                        <? if (isset($rolldetails) and $rolldetails != '') { ?>
                            <div class="col-xs-6 col-sm-6 col-md-6 roll_sidebar"></div>
                        <? }
                        if (isset($a4details) and $a4details != '') { ?>
                            <div class="col-xs-6 col-sm-6 col-md-6"></div>
                        <? } ?>

                        <!--<div class="col-xs-12 text-justify alert-warning m-t-20"> <small>The label choices e.g. size, material, adhesive etc. selected could be available in both roll and sheet formats and if so both options will be displayed on the page here. Allowing you to select the most suitable for your application and budget.  If the label is not available in both formats you will see only one or the other displayed, not both. </small> </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
