<div class="thumbnail">
    <div class="row  dm-row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12  dm-box">
            <div class="thumbnail">
                <div class="clear10"></div>
                <div class="col-md-12">
                    <div class="row">
                        
                        <div class="col-md-6 col-xs-12">
                            <a href="javascript:;void(0);" class="btn-block btn blue2 gotoMaterialPage" data-value="1" role="button"> <i class="fa fa-arrow-circle-left"></i> Back to Materials </a>
                        </div>

                    </div>
                </div>
                <div class="clear10"></div>
                <div class="col-xs-12">
                    
                    <p class="text-justify">
                        Select the label material and finish required along with the adhesive type
                        for your label application. Also the material colour, if not white and once selected choose the
                        appropriate print type. If you would like advice on an appropriate material selection please
                        contact our customer care team using the “Live Chat” facility on the page during office
                        hours.
                    </p>

                    <div class="row srl  m-t-30">
                        <div id="roll_material_selection" class="col-lg-6 col-md-6 col-sm-12 sfr m-b-10 matselector" style="display:none;">
                            <div class="title col-xs-12 no-padding">
                                <div class="roll-icon pull-left"><img onerror='imgError(this);' class="" src="<?= Assets ?>images/categoryimages/labelShapes/printed_roll.png" alt="Roll Icon"></div>
                                <h4 class="pull-left no-margin">Selection for<br/> Labels on Rolls</h4>
                            </div>
                            <div class="clear"></div>
                            <div class="labels-form">
                                <input type="hidden" name="label_type" value="roll"/>
                                <input type="hidden" name="material" class="nlabelfilter" value=""/>
                                <input type="hidden" name="color" class="nlabelfilter" value=""/>
                                <input type="hidden" name="adhesive" class="nlabelfilter" value=""/>
                                <input type="hidden" name="digital" class="nlabelfilter" value=""/>

                                <div class="btn-group btn-block dm-selector material-d-down" style="display: none;">
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Label Material <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block">
                                    </ul>
                                </div>
                                
                                <div class="btn-group btn-block dm-selector color-d-down" style="display: none;">
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Label Colour <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block mega-print-dd-menu">
                                    </ul>
                                </div>
                                
                                <div class="btn-group btn-block dm-selector adhesive-d-down" style="display: none;">
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Label Adhesive <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block">
                                    </ul>
                                </div>

                                <div class="btn-group btn-block dm-selector digital_proccess-d-down">
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Digital Print Process (Rolls) <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block">
                                        <li><a data-toggle="tooltip-digital" data-trigger="hover" data-placement="left"
                                               title="" data-value="" data-id="digital"> Select Digital Print Process (Rolls) </a></li>
                                        <?php
                                        $a4_prints = $this->home_model->get_digital_printing_process('roll');
                                        foreach ($a4_prints as $row) { ?>
                                            <li><a data-toggle="tooltip-digital" data-trigger="hover"
                                                   data-placement="right" title="<?= $row->tooltip_info ?>"
                                                   data-id="digital" data-value="<?= $row->name ?>">
                                                    <?= $row->name ?>
                                                </a></li>
                                        <? } ?>
                                    </ul>
                                </div>
                                <div class="clear15"></div>
                                <label class="select">
                                    <select name="finish" class="nlabelfilter">
                                        <option selected="selected" value="">Select Label Finish</option>
                                        <option value="No Finish">No Finish</option>
                                        <option value="Gloss Lamination">Gloss Lamination</option>
                                        <option value="Matt Lamination">Matt Lamination</option>
                                        <option value="Gloss Varnish">Gloss Varnish</option>
                                        <option value="High Gloss Varnish">High Gloss Varnish (Not Over-Printable)
                                        </option>
                                        <option value="Matt Varnish">Matt Varnish</option>
                                    </select>
                                    <i></i>
                                </label>

                                    <input type="hidden" value="orientation1" id="label_orientation"/>
                                    <div class="roll_sheets_block">
                                        <div class="btn-group btn-block dm-selector">

                                            <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" data-value="orientation1" aria-expanded="false">
                                                Orientation 01
                                                <i class="fa fa-unsorted"></i>
                                            </a>
                                            
                                              <!-- AA33 STARTS -->
                                            <style>
                                                .orientationImagePosition
                                                {
                                                     left:-234px !important;
                                                     top:0px !important;
                                                }
                                            </style>
                                            <!-- AA33 ENDS -->
                                            

                                            <ul class="dropdown-menu btn-block" style="top: 100%;">
                                                
                                                <li class="outsideorientation">
                                                  <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation1" data-original-title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first."  data-value="orientation1">
                                                    Orientation 01 <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Outside/orientation1.png" class="orientationImagePosition">
                                                  </a>
                                                </li>

                                                <li class="outsideorientation">
                                                  <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation2" data-original-title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first." data-value="orientation2">
                                                    Orientation 02 <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Outside/orientation2.png" class="orientationImagePosition">
                                                  </a>
                                                </li>

                                                <li class="outsideorientation">
                                                    <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation3" data-original-title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first." data-value="orientation3"> 
                                                        Orientation 03
                                                        <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Outside/orientation3.png" class="orientationImagePosition">
                                                    </a>
                                                </li>

                                                <li class="outsideorientation">
                                                    <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation4" data-original-title="Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label of first." data-value="orientation4"> 
                                                        Orientation 04
                                                        <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Outside/orientation4.png" class="orientationImagePosition">
                                                    </a>
                                                </li>


                                                <li class="insideorientation">
                                                    <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation5" data-original-title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first."  data-value="orientation5">
                                                        Orientation 05
                                                        <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Inside/orientation5.png" class="orientationImagePosition">
                                                    </a>
                                                </li>

                                                <li class="insideorientation">
                                                    <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation6" data-original-title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first." data-value="orientation6">
                                                        Orientation 06
                                                        <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Inside/orientation6.png" class="orientationImagePosition"> 
                                                    </a>
                                                </li>

                                                <li class="insideorientation">
                                                    <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation7" data-original-title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first." data-value="orientation7">
                                                        Orientation 07
                                                        <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Inside/orientation7.png" class="orientationImagePosition">
                                                    </a>
                                                </li>

                                                <li class="insideorientation">
                                                    <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="" data-id="orientation8" data-original-title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first." data-value="orientation8">
                                                        Orientation 08
                                                        <img onerror="imgError(this);" src="<?= Assets ?>images/categoryimages/winding/Inside/orientation8.png" class="orientationImagePosition">
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <!-- 

                                    <div class="btn-group btn-block dm-selector">
                                      <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" data-value="">Orientation 01<i class="fa fa-unsorted"></i></a>
                                        <ul class="dropdown-menu btn-block">
                                            
                                            <li class="outsideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the outside of the roll. Text and image printed across the roll. Top of the label off first." data-id="orientation1" data-value="orientation1"> 
                                                Orientation 01 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>
                                            
                                            <li class="outsideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the outside of the roll. Text and image printed across the roll. Bottom of the label off first." data-id="orientation2"  data-value="orientation2">
                                                Orientation 02 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="outsideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the outside of the roll. Text and image printed around the roll. Right-hand edge of the label off first." data-id="orientation3" data-value="orientation3"> 
                                                Orientation 03 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="outsideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the outside of the roll. Text and image printed around the roll. Left-hand edge of the label of first." data-id="orientation4" data-value="orientation4">
                                                Orientation 04 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="insideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the inside of the roll. Text and image printed across the roll. Bottom of the label off first." data-id="orientation5" data-value="orientation5">
                                                Orientation 05 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="insideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the inside of the roll. Text and image printed across the roll. Top of the label off first." data-id="orientation6" data-value="orientation6">
                                                Orientation 06 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="insideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the inside of the roll. Text and image printed around the roll. Left-hand edge of the label off first." data-id="orientation7" data-value="orientation7">
                                                Orientation 07 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>

                                            <li class="insideorientation">
                                              <a data-toggle="tooltip-orintation" data-trigger="hover" data-placement="right" title="Labels on the inside of the roll. Text and image printed around the roll. Right-hand edge of the label off first." data-id="orientation8" data-value="orientation8">
                                                  Orientation 08 <img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif">
                                              </a>
                                            </li>
                                            
                                        </ul>
                                    </div> -->


                            </div>
                            <div class="clear"></div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        
                                    <div class="thumbnail lSum">
                                        <div class="clear5"></div>
                                        <div class="col-xs-12">
                                            <div class="detail">
                                                
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="sfr">
                                                            <div class="text-center f-12">
                                                                <img onerror='imgError(this);' height="115" class="windingimage" src="<?= Assets ?>images/categoryimages/winding/Outside/orientation1.png">
                                                                <div class="clear10"></div>
                                                                <P class="OrientationText" style="text-align: center;">
                                                                    This image is to show print orientation and the roll winding only. Do not refer to this image for shape and Size of your label.
                                                                </P>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <div id="a4_material_selection" class="col-lg-6 col-md-6 col-xs-12 sfl matselector" style="display:none;">
                            <div class="title col-xs-12 no-padding">
                                <div class="sheet-icon pull-left"><img onerror='imgError(this);' class=""
                                                                       src="<?= Assets ?>images/categoryimages/labelShapes/printed_sheet.png"
                                                                       alt="Sheet Icon"></div>
                                <h4 class="pull-left no-margin">Selection for<br/>
                                   Labels on <span id="brandName"> </span> Sheets</h4>
                            </div>
                            <div class="clear"></div>
                            <div class="labels-form">
                                <input type="hidden" name="label_type" value="A4"/>
                                <input type="hidden" name="material" class="nlabelfilter" value=""/>
                                <input type="hidden" name="color" class="nlabelfilter" value=""/>
                                <input type="hidden" name="adhesive" class="nlabelfilter" value=""/>
                                <input type="hidden" name="digital" class="nlabelfilter" value=""/>

                                <div class="btn-group btn-block dm-selector material-d-down"  style="display: none;" >
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Label Material <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block">
                                    </ul>
                                </div>
                                <div class="clear15"></div>

                                <div class="btn-group btn-block dm-selector color-d-down"  style="display: none;" >
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Label Colour <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block mega-print-dd-menu">
                                    </ul>
                                </div>
                                <div class="clear15"></div>

                                <div class="btn-group btn-block dm-selector adhesive-d-down" style="display: none;" >
                                    <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Label Adhesive <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block">
                                    </ul>
                                </div>
                                <div class="clear15"></div>

                                <div class="btn-group btn-block dm-selector digital_proccess-d-down"><a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Digital Print Process (Sheets) <i class="fa fa-unsorted"></i></a>
                                    <ul class="dropdown-menu btn-block">
                                        <li>
                                            <a data-toggle="tooltip-digital" data-trigger="hover" data-placement="left" title="" data-id="digital" data-value="">Select Digital Print Process (Sheets) </a></li>
                                            <?php
                                            $a4_prints = $this->home_model->get_digital_printing_process('A4');
                                            foreach($a4_prints as $row){ ?>
                                                <li>
                                                    <a data-toggle="tooltip-digital" data-trigger="hover" data-placement="right" title="<?= $row->tooltip_info ?>" data-id="digital" data-value="<?= $row->name ?>">
                                                        <?= $row->name ?>
                                                    </a>
                                                </li>
                                            <? } ?>
                                    </ul>
                                </div>
                                <div class="clear15"></div>

                                <label class="select"  style="display: none;" >
                                    <select>
                                        <option selected="selected" value="">Finish Not Available</option>
                                    </select>
                                    <i></i>
                                </label>

                            </div>
                            <div class="clear"></div>
                        </div>
                        <div id="empty_material_selection" class="col-lg-6 col-md-6 col-xs-12 sfl m-b-20">
                            <div style="margin-top:36px; ">
                                <div class="img-responsive"><img onerror='imgError(this);' class="img-responsive" src="<?= Assets ?>images/categoryimages/labelShapes/aqua.png" alt="Printed labels banner"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 col-xs-12 pull-right">
                                    <button class="btn-block btn orangeBg step-forward" data-value="3"> Proceed with printed labels on <span class="name_print_type"></span> <i class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">


            <div id="aa_loader" class="white-screen" style="display:none;position:absolute;top:43%;left:30%;">
                <div class="loading-gif text-center" style="position: absolute;"><img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif" class="image" style="width:139px; height:29px;" alt="AA Labels Loader"></div>
            </div>
            <div id="ab_loader" class="white-screen" style="display:none;position:absolute;top:43%;left:30%;">
                <div class="loading-gif text-center" style="position: absolute;"><img onerror='imgError(this);' src="<?= Assets ?>images/loader.gif" class="image" style="width:139px; height:29px;" alt="AA Labels Loader"></div>
            </div>


            <div class="clear10"></div>
            <div class="lSum">
                <div id="product_summary_overview_home" class="col-xs-12">

                </div>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="thumbnail prLbMatTabs">
            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-justified orderStep setup-panel" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_material" aria-controls="" role="tab"
                                                              data-toggle="tab">Label Material</a></li>
                    <li role="presentation"><a href="#tab_colour" aria-controls="" role="tab" data-toggle="tab">Label
                            Colour</a></li>
                    <li role="presentation"><a href="#tab_finish" aria-controls="" role="tab" data-toggle="tab">Label
                            Finish</a></li>
                    <li role="presentation"><a href="#tab_adhesive" aria-controls="" role="tab" data-toggle="tab">Adhesive</a>
                    </li>
                    <li role="presentation"><a href="#tab_printing" aria-controls="" role="tab" data-toggle="tab">Printing
                            Process</a></li>
                    <li role="presentation"><a href="#tab_delivery" aria-controls="" role="tab" data-toggle="tab">Delivery</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab_material">
                        <div class="clear10"></div>
                        <div class="col-md-12 text-justify">
                            <p>The choice of material has aesthetic and practical considerations, because not only
                                should the label look nice, but it must also be fit-for-purpose.</p>
                            <p> Therefore the label face-stock material needs to be suitable for the application. For
                                example a paper label would not be the best material choice for an industrial
                                application that requires abrasion resistance and a thicker Polyethylene material would
                                not be the best choice of material for a bottle label, but it would for an industrial
                                oil drum. </p>
                            <p> Therefore both application and life cycle requirement should be considered, in
                                association with appearance. </p>
                            <p>Typical label material face-stocks are as follows:</p>
                            <div class="title"><b>Paper</b></div>
                            <div class="clear10"></div>
                            <div class="col-sm-9">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th width="30%" scope="row">Plain</th>
                                        <td width="70%">Uncoated/Vellum</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Plain Coloured</th>
                                        <td>Fluorescent; Metallic etc.</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Coated</th>
                                        <td>e.g. semi-gloss, gloss. high gloss, thermal etc.</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Luxury</th>
                                        <td>e.g. grain, ribbed etc.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-3 text-center"><img onerror='imgError(this);' class="img-responsive"
                                                                   src="<?= Assets ?>images/categoryimages/labelShapes/material_page_img.jpg"
                                                                   alt=""></div>
                            <div class="title"><b>Film</b></div>
                            <div class="clear10"></div>
                            <div class="col-sm-9">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th width="30%" scope="row">Polyethylene</th>
                                        <td width="70%">White, clear, coated, uncoated</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Polyester</th>
                                        <td>White, clear, coated, uncoated</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Polypropylene</th>
                                        <td>White, clear, coated, uncoated</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p>In addition to the above summary there are specialist face-stock materials for
                                    temperature resistant applications (cold and heat), security and water resistant
                                    applications. For more information please refer to the materials specifications page
                                    and/or speak with our customer care team. </p>
                            </div>
                            <div class="col-sm-3 text-center"><img onerror='imgError(this);' class="img-responsive"
                                                                   src="<?= Assets ?>images/categoryimages/labelShapes/material_img.jpg"
                                                                   alt="Printed Labels"></div>
                        </div>
                    </div>
                    <!--material end -->
                    <div role="tabpanel" class="tab-pane" id="tab_colour">
                        <div class="clear10"></div>
                        <div class="col-md-12 text-justify">
                            <p>Label designs requiring a full colour bleed background will in most instances be printed
                                onto a white label face-stock. However in label designs where the label background is
                                intended to be seen e.g. wine bottle labels, the choice of colour becomes an important
                                consideration. Label face-stocks are available in a range of standard colours to help
                                create labels that work in design terms. </p>
                            <p> The range of standard colours available across different face-stocks includes:</p>
                            <div class="title"><b>Matt Colours</b></div>
                            <div class="">
                                <ol class="list-unstyled text-center">
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Red_Permanent_Adhesive.png"
                                             alt="Matt Red Permanent Adhesive">Matt Red
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Luxury_Terracotta_Permanent_Adhesive.png"
                                             alt="Matt Luxury Terracotta ">Matt Luxury Terracotta
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Orange_Polyester_Permanent_Adhesive.png"
                                             alt="Matt Polyester Orange">Matt Orange
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Luxury_Sand_Permanent_Adhesive.png"
                                             alt="Luxury Sand Permanent Adhesive">Luxury Sand
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Yellow_Removable_Adhesive.png"
                                             alt="Matt Yellow Removable Adhesive">Matt Yellow
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Pastel_Yellow_Permanent_Adhesive.png"
                                             alt="Matt Pastel Yellow Permanent Adhesive">Matt Pastel Yellow
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Green_Permanent_Adhesive.png"
                                             alt="Matt Green Permanent Adhesive">Matt Green
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Light_Green_Permanent_Adhesive.png"
                                             alt="Matt Light Green Adhesive">Matt Light Green
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Blue_Removable_Adhesive.png"
                                             alt="Matt Blue Sheet">Matt Blue
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Mid_Blue_Permanent_Adhesive.png"
                                             alt="Matt Mid-Blue">Matt Mid-Blue
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Purple_Peelable_Adhesive.png"
                                             alt="Matt Fuschia">Matt Fuschia
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Luxury_Brown_Permanent_Adhesive.png"
                                             alt="Matt Luxury Brown">Matt Luxury Brown
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Luxury_Grey_Permanent_Adhesive.png"
                                             alt="Luxury Grey">Luxury Grey
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Luxury_Cream_Permanent_Adhesive.png"
                                             alt="Luxury Cream">Luxury Cream
                                    </li>
                                </ol>
                            </div>
                            <div class="clear10"></div>
                            <div class="title"><b>Fluorescent Colours</b></div>
                            <div class="">
                                <ol class="list-unstyled text-center">
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Fluorescent_Red_Labels.png"
                                             alt="Fluorescent Red">Fluorescent Red
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Fluorescent_Yellow_Labels.png"
                                             alt="Fluorescent Yellow">Fluorescent Yellow
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Fluorescent_Orange_Labels.png"
                                             alt="Fluorescent Orange">Fluorescent Orange
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Fluorescent_Pink_Labels.png"
                                             alt="Fluorescent Pink">Fluorescent Pink
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Fluorescent_Green_Labels.png"
                                             alt="Fluorescent Green">Fluorescent Green
                                    </li>
                                </ol>
                            </div>
                            <div class="clear10"></div>
                            <div class="title"><b>Metallic Colours</b></div>
                            <div class="col-md-12 p0">
                                <div class="clear10"></div>
                                <ol class="list-unstyled text-center">
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Gold_Permanent_Adhesive.png"
                                             alt="Matt Gold">Matt Gold
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Silver_Permanent_Adhesive.png"
                                             alt="Matt Silver">Matt Silver
                                    </li>
                                    <li><img onerror='imgError(this);' class="img-responsive"
                                             src="<?= Assets ?>images/material_images/new/Matt_Silver_Polyester_Permanent_Adhesive.png"
                                             alt="Bright Silver">Bright Silver
                                    </li>
                                </ol>
                            </div>
                            <div class="clear10"></div>
                            <p> For more information please refer to the materials specifications page and/or speak with our customer care team. </p>
                        </div>
                    </div>
                    <!--color end -->
                    <div role="tabpanel" class="tab-pane " id="tab_finish">
                        <div class="col-md-12 text-justify">
                            <div class="clear10"></div>
                            <div class="title"><b>Finishing Digitally Printed Labels: What Do You Really Need?</b></div>
                            <div class="clear10"></div>
                            <p>In the world of label production, finishing or converting a label is as important as the
                                accuracy and quality of the printing process itself. The decision whether to use inline
                                or offline finishing/converting solutions depends on the make-up of incoming orders and
                                the specific market needs of our customers. </p>
                            <p>Today's labels are more than just pretty pictures. Digital production of labels requires
                                many components, such as the printing press, toners/inks, laminates, varnishes, suitable
                                substrates, appropriate software solutions as well as the right finishing equipment. The
                                best label solutions include all these components in a well thought-out fashion.
                                Self-adhesive or pressure-sensitive labels are transformed into final products only when
                                finishing has been applied. It allows the product to remain visible despite the presence
                                of laminate or varnish. The following table provides an effective overview of the use of
                                labels in various sectors and indicates the type of print finishing normally required
                                for a specific sector. While these details are based on surveys of conventional printing
                                technologies, they apply to digital printing as well, with just a few exceptions.</p>
                            <div class="clear10"></div>
                            <div class="col-md-12 col-xs-12 col-sm-12"><img onerror='imgError(this);'
                                                                            class="img-responsive"
                                                                            src="<?= Assets ?>images/printed_information_finish.png"
                                                                            alt="Printed Labels Information">
                                <p class="col-md-8 col-xs-8 col-sm-8">All of the above label finish options have been
                                    tested for thermal-transfer printer compatibility, however ribbon types and printer
                                    models can produce variable results. Therefore while this is a general guide of
                                    compatibility, it should not be considered definitive and testing is always
                                    advisable.</p>
                                <table class="table table-striped hide">
                                    <thead>
                                    <tr>
                                        <th align="left">Application/sector</th>
                                        <th align="left">Laminate</th>
                                        <th align="left">Varnish</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td align="left">Beverage labels</td>
                                        <td align="left"></td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td align="left">External labels</td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Food labels</td>
                                        <td align="left">&nbsp;</td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Health &amp; cosmetics labels</td>
                                        <td align="left">&nbsp;</td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Industrial labels</td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Pharmaceutical labels</td>
                                        <td align="left">&nbsp;</td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Wine &amp; spirit labels</td>
                                        <td align="left">&nbsp;</td>
                                        <td align="left"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="clear10"></div>
                            <div class="title"><b>Laminating</b></div>
                            <div class="clear10"></div>
                            <p>If a label is likely to be exposed to more demanding conditions of use, laminates are
                                preferred in the print finishing process. Laminates provide protection from mechanical
                                abrasion, chemical solvents and oils and also include functional barriers, such as
                                sunlight protection factors. In these cases, a self-adhesive laminate or a film
                                pre-treated with UV adhesive can also be applied directly to the label. Laminating also
                                offers a long shelf life.</p>
                            <div class="clear10"></div>
                            <div class="title"><b>Varnishing</b></div>
                            <div class="clear10"></div>
                            <p>Mainly UV liquid varnishes are used for both for protecting the product and for aesthetic
                                reasons. Anytime varnish is applied in the digital printing process – regardless of
                                whether the system uses dry or liquid toner/inks – the primary function of the varnish
                                is to provide adequate protection from wear and scratching. In inkjet printing, varnish
                                is mainly used to enhance appearance, and to provide the printed product with a shiny
                                finish of a uniform brightness. Pharmaceutical labels are normally finished with spot
                                coatings and water-based varnishes. This means it is possible to add over-printing to
                                the label later in the packaging production process. </p>
                        </div>
                    </div>
                    <!--finish end -->
                    <div role="tabpanel" class="tab-pane " id="tab_adhesive">
                        <div class="col-md-8 col-xs-12 col-sm-7  text-justify">
                            <div class="clear10"></div>
                            <p>There are two basic types of label adhesive: permanent and removable. Each type can be
                                made from a variety of materials and the choice is determined by the surface being
                                labelled, the conditions the label will have to endure, the required longevity of the
                                label and its purpose. The most popular types of label adhesive are acrylic, rubber and
                                water-based. If a label will be exposed to a very moist environment, such as a freezer,
                                refrigerator or cooler, water-based adhesives are not practical. They break down, and
                                the labels can fall off the products, regardless of the surface to which they are
                                applied. Water-based adhesives therefore should only be used in dry environments.
                                Adhesives mainly composed of rubber are preferred for their tackiness. They are prone to
                                failure when exposed to UV rays over extended periods of time. If the labels will not be
                                exposed to sunlight, this type of adhesive works fine. Acrylic-based bonding agents are
                                easy to work with during application, as they can be easily moved around. Once acrylic
                                glue dries, however, the bond is permanent. This type of label adhesive is suitable for
                                long-lasting products that need labels to withstand time and frequent handling. </p>
                            <p>Depending on the surface to be labelled and the lifespan required of the label, there are
                                6 main adhesive types commonly used: </p>
                            <ul>
                                <li> Permanent</li>
                                <li> High Tack/Super Permanent</li>
                                <li> Removable/Peelable</li>
                                <li> Re-sealable</li>
                                <li> Temperature Resistant e.g. Freezer</li>
                                <li> Static Cling</li>
                            </ul>
                            <p>All of the above adhesive categories have a range of adhesives available e.g. Frost Fix;
                                Freezer and Cryogenic adhesives are designed for increasingly lower temperature
                                applications. </p>
                            <p>Before a label adhesive is chosen, many factors must be considered. These include the
                                size of the label, the material and texture of the surface to be labelled and the
                                mobility level required; some, such as retail labels for electronic products and white
                                goods, are intended to be removed, while others, such as shipping labels, can be left
                                intact indefinitely. </p>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4"><img onerror='imgError(this);' class="img-responsive"
                                                                      src="<?= Assets ?>images/categoryimages/labelShapes/adhesive.png"
                                                                      alt="Adhesive Details"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-justify">
                            <div class="clear10"></div>
                            <p>If a label is attached with the intent of it never being removed, or if only a solvent
                                would remove it, it is called permanent. In some cases, before a label attains permanent
                                status, it has a short period where it can be moved. These labels are often referred to
                                as repositionable. A peelable label is just that: it can be peeled off a surface. The
                                surface exterior is not marred, and no adhesive residue is left behind. This type of
                                label can normally be used two or three times and not lose its stickiness. An
                                ultra-peelable label is popularly used on book jackets and glass, where no residue is
                                acceptable. These labels can only be used once before the adhesive is gone. </p>
                        </div>
                    </div>
                    <!--adhesive end -->
                    <div role="tabpanel" class="tab-pane " id="tab_printing">
                        <div class="col-md-8 col-xs-12 col-sm-7  text-justify">
                            <div class="clear10"></div>
                            <p>The digital printing process is seamless in information transfer terms and the designs
                                provided by customers in electronic file formats are assessed and checked before
                                preparing press files for final approval, before printing. This takes the form of an
                                electronic soft-proof sent to our customers via email which once approved is sent to the
                                print queue for production. </p>
                            <p>If you require a press-proof before proceeding to produce your label order this can be
                                arranged and you should contact our customer care team to discuss your
                                requirements. </p>
                            <p>Printed roll labels are produced on a 7 colour digital inkjet press, producing
                                exceptional image and print quality, along with accurate colour reproduction on a
                                variety of standard label face-stock materials e.g. semi-gloss white paper, luxury
                                papers, semi-gloss white Polypropylene, gloss clear Polypropylene and bright silver
                                Polypropylene (metallic colours). </p>
                            <p>Colours: Cyan, Magenta, Yellow, Black, Green, Orange & White
                                The inclusion of white ink for solid opaque white printing on materials such as clear
                                films and metallic substrates, facilitates the production of metallic colours and
                                finishes, white text and panels on clear labels and the printing of window
                                stickers. </p>
                            <p>The digital printing process does not require metal plates to be manufactured for colour
                                separations, as with offset litho, or solvents to clean machinery and plates, because
                                the ink used is aqueous. Making digital inkjet printing the most environmentally
                                considerate process by removing the use of chemicals and reducing the associated carbon
                                footprint.</p>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4"><img onerror='imgError(this);' class="img-responsive"
                                                                      src="<?= Assets ?>images/categoryimages/labelShapes/digital_printing.png"
                                                                      alt="Epson Label Printer"></div>
                    </div>
                    <!--printing end -->
                    <div role="tabpanel" class="tab-pane" id="tab_delivery">
                        <div class="col-md-8 col-xs-12 col-sm-7 text-justify">
                            <div class="clear10"></div>
                            <div class="title"><b>Order Fulfillment</b></div>
                            <div class="clear10"></div>
                            <p>Orders are added to the print-queue following final approval of artwork from the
                                soft-proof (or press-proof if required) provided. We commit to print, label conversion
                                and finishing within 4 working days from this point. </p>
                            <div class="clear10"></div>
                            <div class="title"><b>Despatched Deliveries</b></div>
                            <div class="clear10"></div>
                            <p>Are made the following working day in mainland UK (other than post codes considered to be
                                a 2 day service by courier companies and offshore locations). Delivery times outside of
                                the UK vary, please refer to "Delivery & Shipping" under SITE LINKS in the footer of
                                this page. </p>
                            <p>You can therefore expect to receive your printed roll labels within 5 working days within
                                the UK. Outside of the UK delivery times vary and our customer care team will advise you
                                and provide details of your delivery tracking.</p>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4"><img onerror='imgError(this);' class="img-responsive"
                                                                      src="<?= Assets ?>images/categoryimages/labelShapes/delivery.png"
                                                                      alt="AA Labels Delivery Van"></div>
                    </div>
                    <!--delivery end -->
                </div>
            </div>
        </div>
    </div>
</div>
