<div class="mat-sep-2017">
  <? foreach ($integrate as $pro) {
                    $labelSize = preg_replace('/Label Size: /', '', $pro->specification3);
                    $labelSize = preg_replace('/width /i', '', $labelSize);
                    $labelSize = preg_replace('/height/i', '', $labelSize);

                    $sizearay = explode(',', $labelSize);

                    $labelSize = implode('<br />', $sizearay);
                    /*if(count($sizearay) > 2 ){
                          $labelSize = $sizearay[0].' , '.$sizearay[1]."<br />";
                        $labelSize .=$sizearay[2];
                    }*/

                    $batchqty = $this->home_model->integrated_batch_qty($pro->ManufactureID);
                    $image = explode(".", $pro->CategoryImage);
                    $imagename = $image[0] . "_1.png";
                    $comp = $this->home_model->grouping_compatiblity($pro->labelsCompatiblity, 'sheet');
                    ?>
  <div class="selected-product">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pr-thumb">
        <div class="imgBg text-center"><img src="<?= aalables_path . "images/categoryimages/Integrated/" . $pro->CategoryImage; ?>" id="int_<?= $pro->CategoryID ?>" alt="<?= $imagename ?>" title="<?= $pro->CategoryImage; ?>"/>
          <div style="position:absolute; left:8px; top:110px;" class="pull-left"><a
                                                id="<?= $pro->CategoryID ?>" class="btn blueBg"
                                                href="javascript:void(0);" data-original-title="Rotate Image"
                                                data-toggle="tooltip"><i class="fa fa-retweet"></i></a></div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <h1 class="pr-title">
              <?= $pro->specification1 ?>
            </h1>
            <div class="pr-detail">
              <div class="row">
                <p class="col-md-6"><b>Item Code: <span class="pr-code">
                  <?= $pro->ManufactureID ?>
                  </span></b></p>
                <p class="col-md-6"><b>Label Size:</b>
                  <?= $labelSize ?>
                </p>
              </div>
              <div class="row">
                <p class="av-comp col-md-12" style="opacity:1">
                  <? if ($comaptible) {
                  		echo " <b>Compatible with</b> ";
                  } ?>
                  <?= $comaptible ?>
                </p>
              </div>
              <div class="req-links">
                <p><a role="button" data-target=".layout" data-toggle="modal"> <i
                                                                class="fa fa-search-plus" aria-hidden="true"></i> Layout
                  Specification</a></p>
                <div class="row">
                  <div class="col-xs-12 text-left download-icons"><a rel="nofollow"
                                                                                                       data-toggle="tooltip"
                                                                                                       title=""
                                                                                                       href="<?= Assets_path . "images/categoryimages/Integrated/pdf/" . $pro->WordDoc; ?>"
                                                                                                       role="button"
                                                                                                       data-original-title="Download PDF Template"> <img src="<?= aalables_path ?>images/pdf-icon.png" alt="PDF Icon"> </a> <a data-toggle="tooltip" title="" rel="nofollw"
                                                                href="<?= Assets_path . "images/categoryimages/Integrated/word/" . $pro->WordDoc; ?>"
                                                                role="button"
                                                                data-original-title="Download Word Template"> <img
                                                                    src="<?= aalables_path ?>images/word-icon.png"
                                                                    alt="MS Word Icon"> </a></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 hidden-sm hidden-xs text-center why-seal"><img
                                                class="img-responsive" src="<?= aalables_path ?>images/30-icon.png"
                                                alt="30 Days Moneyback Guarantee">
            <div class="title m-t-10"><a href="javascript:void(0);" data-toggle="popover"
                                                                     data-trigger="hover" data-placement="top"
                                                                     data-html="true"
                                                                     data-content="<div class='col-lg-12 col-md-12 frc-banner'><div class='title'> FAST, RELIABLE &amp; COST EFFECTIVE </div><ul><li>Over 80% of orders despatched same day</li><li>Daily despatch and delivery</li><li>Add the “Next Day” option to your order</li><li>If you need labels quicker, add a PRE 10:30 or 12:00 option for even faster delivery.</li><li>1,000’s of satisfied customers.</li><li>  <img src='<?= aalables_path ?>images/iso_14001.png' alt='ISO 9001'> ISO9001 Certified</li><li><img src='<?= aalables_path ?>images/iso_9001.png' alt='ISO14001 Certified'> ISO14001 Certified</li> </ul></div>" data-original-title="" title="">Why Buy from AA
              Labels? <i class="fa fa-info-circle"></i></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<div class="panel panel-default no-border mat-may-2017">
  <div class="panel-body no-padding">
    <div class="colors_data mat-ch" id="ajax_material_sorting">
      <?php
                        $desc = $pro->Appearance;
                        $max_length = 300;
                        if (strlen($desc) > $max_length) {
                            $offset = ($max_length - 3) - strlen($desc);
                            $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
                            $short_desc .= ' <a style="cursor:pointer;" data-toggle="tooltip-product" data-placement="top" data-original-title="' . $desc . '"><i>Read More</i></a>';
                        } else {
                            $short_desc = $desc;
                        }
                        $promotion = '';
                        ?>
      <section data-mat-filters="<?= $pro->ColourMaterial ?>" data-reset="reset">
        <div class="row productdetails" data-value="<?= $pro->ProductID ?>"
                                 data-finish="<?= $pro->LabelFinish ?>"
                                 data-material="<?= $pro->ColourMaterial ?>">
          <div class="hiddenfields">
            <input type="hidden" value="" class="cart_id"/>
            <input type="hidden" value="<?= $pro->ProductID ?>" class="product_id"/>
            <input type="hidden" value="<?= $pro->ManufactureID ?>" class="manfactureid"/>
            <input type="hidden" value="<?= $pro->LabelsPerSheet ?>" class="LabelsPerSheet"/>
            <input type="hidden" value="" class="digitalprintoption"/>
            <input type="hidden" value="0" data-qty="0" id="uploadedartworks_<?= $pro->ProductID ?>"/>
            <input type="hidden" value="<?= $pro->Printable ?>" class="PrintableProduct"/>
            <input type="hidden" value="0" id="no_artworks_<?= $pro->ProductID ?>"/ style="position: absolute; z-index: 500; left: 250px;">
      
            <input type="hidden" value="<?= @$min_qty ?>"  id="custom_qty_roll_<?= $pro->ProductID ?>"/ style="position: absolute; z-index: 500; left: 440px;">
            
            <input type="hidden" id="ppproductID" value="<?= $pro->ProductID ?>">
            
          </div>
          <article class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mat-detail">
            <div class="pr-detail"><span class="group_name"> Matt White Paper </span><br/>
              <span class="product_name">Matt White Paper</span> <font
                                                class="product_description">
              <?= $short_desc ?>
              </font></div>
            <div class="clear"></div>
            <div class="row specs">
              <div class="col-lg-4 col-md-4 col-sm-2 col-xs-3"><img class="img-responsive product_material_image" src="<?= aalables_path . "images/categoryimages/Integrated/" . $pro->CategoryImage; ?>" alt="Integrated Labels"></div>
              <div class="col-lg-8 col-md-8 col-sm-10 col-xs-9">
                <div class="row">
                  <div class="col-md-6 no-padding"><a href="#" id="<?= $pro->ProductID ?>" class="technical_specs" data-target=".material" data-toggle="modal" data-original-title="Tecnial Specification">Material Specification <i class="fa fa-info-circle"></i></a></div>
                  <div class="clear10">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 comp">
                          <table class="table printer" border="0" style="border:none;">
                            <tbody>
                              <tr>
                                <td align="left" valign="center" style="font-size:12px; border:none;vertical-align: bottom;width:25%;"><small style="margin-top:10px;font-size:12px;"> Printer Compatibility </small></td>
                                <td align="left" style="font-size:12px; border:none; width:25%;"> Laser <a data-toggle="tooltip-product" data-placement="top" class="laser_printer_div" title="" data-original-title="<?= $comp['laser_text'] ?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a> <br/>
                                  <img class="laser_printer_img" width="50" src="<?= aalables_path ?>images/<?= $comp['laser_img'] ?>"/></td>
                                <td align="left" style=" font-size:12px;border:none;width:25%;"> Inkjet <a data-toggle="tooltip-product" data-placement="top" title="" class="inkjet_printer_div" data-original-title="<?= $comp['inkjet_text'] ?>" href="javascript:void(0);"><i  class="fa fa-info-circle"></i></a> <br/>
                                  <img class="inkjet_printer_img" width="50" src="<?= aalables_path ?>images/<?= $comp['inkjet_img'] ?>"/></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clear10"></div>
              </div>
            </div>
          </article>
          <article class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mat-tabs">
            <ul class="nav nav-tabs nav-justified" role="tablist" style="padding:0">
              <li class="nav-item"> <a href="#tab_plain<?= $pro->ProductID ?>" aria-controls="" role="tab" data-toggle="tab" class="nav-link active">Plain Labels</a> </li>
              <li class="nav-item"> <a href="#tab_printed<?= $pro->ProductID ?>" aria-controls="" role="tab" data-toggle="tab" class="nav-link">Printed Labels</a> </li>
              <li class="nav-item"> <a href="#tab_sample<?= $pro->ProductID ?>" aria-controls="" role="tab" data-toggle="tab" class="nav-link">Material Sample</a> </li>
            </ul>
            <div class="tab-content">
              <div id="tab_plain<?= $pro->ProductID ?>" class="tab-pane tabplain active" role="tabpanel">
                <div class="clear10"></div>
                <div class="row" style="margin-top: 5px;">
                  <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                    <div class="row labels-form" style="margin-top:20px">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center qty">
                        <div class=""> 
                          <!--<input class="form-control text-center allownumeric box_size" data-toggle="popover" data-content="" placeholder="Number of Sheets" type="text" min="100" max="200000">-->
                          <div class="input-group">
                            <input class="form-control text-center allownumeric box_size" data-toggle="popover" data-content="" placeholder="Enter Sheets" type="text">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-default dropdown-toggle plainsheet_unit" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">1000 Sheets Box <span class="caret"></span></button>
                              <ul class="dropdown-menu dropdown-menu-right plain_calculation_unit">
                                <li><a href="javascript:void(0);" data-batch="250">250 Sheet Pack </a> </li>
                                <li><a href="javascript:void(0);" data-batch="1000">1000 Sheets Box</a> </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class=""> <small class="small_plain_minqty_txt col-xs-6">Min.
                          sheets: <span class="min_qty">1000</span></small> </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 quotation">
                    <div class="plainprice_box" style="display:none">
                      <div class="clearfix" style="margin-top: 35px;"></div>
                      <div class="text-right plainprice_text quantity_text">&nbsp; </div>
                      <div class="text-right plainprice_text persheet_text">&nbsp; </div>
                      <div class="clearfix"></div>
                      <span class="pull-right final_price"><b class="priceTextOrange color_orange"> £00.00</b><span>Ex VAT</span></span>
                      <div class="clearfix"></div>
                      <span class="pull-right textOrange hide">Delivery: <span class="delivery_charges">&nbsp;</span></span>
                      <div class="clearfix"></div>
                    </div>
                    <button class="btn orangeBg pull-right integrated_plain" data-int-type="plain" id="calulate_price" type="button" style="margin-top:20px;"> Calculate Price <i class="fa fa-calculator"></i></button>
										
                    <button style="display:none;" class="btn orangeBg pull-right add_integrate" data-int-type="plain" type="button"> Add to basket  <i class="fa fa-calculator"></i></button>
                  </div>
                  <div class="col-md-12 ofq">
                    <div class="row">
                      <div class="col-md-4 main-box">
                        <div class="row">
                          <div class="col-sm-2 no-padding-right ofq-icon"><img src="<?= aalables_path ?>images/4oclock.png"/></div>
                          <div class="col-sm-10 no-padding-right ofq-text material_clock">
                            <div class="counter clock_time">Order before 16:00<br/>
                              for Next Day Delivery </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 main-box">
                        <div class="row">
                          <div class="col-sm-2 no-padding-right ofq-icon"><i class="fa fa-truck l-icon" aria-hidden="true"></i></div>
                          <div class="col-sm-10  no-padding-right ofq-text"><b>Delivery
                            from
                            <?= symbol . $this->home_model->currecy_converter(5.00, 'no'); ?>
                            </b><br/>
                            <a style="font-size:12px;" target="_blank" href="<?= base_url() ?>delivery/"><span class="glyphicon glyphicon-new-window"></span> Delivery & Shipping Options</a></div>
                        </div>
                      </div>
                      <div class="col-md-4 main-box">
                        <div class="row">
                          <div class="col-sm-2 no-padding-right ofq-icon"><i class="fa fa-check-square-o l-icon" aria-hidden="true"></i></div>
                          <div class="col-sm-10 no-padding-right ofq-text"><b>QUALITY ASSURANCE GUARANTEE <a style="font-size:12px;font-weight: 400;" target="_blank" href="<?= base_url() ?>terms-and-conditions/#qa_anchor"><span class="glyphicon glyphicon-new-window"></span> Read More</a></b></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="tab_printed<?= $pro->ProductID ?>" class="tab-pane tabprinted hide" role="tabpanel">
                <div class="clear10"></div>
                <div class="row">
                  <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6">
                    <div class="" style="margin-top:20px;">
                      <div class="text-center qty">
                        <div class="input-group">
                          <input class="form-control text-center allownumeric box_size" data-toggle="popover" data-content="" placeholder="Enter Sheets" type="text">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle plainsheet_unit" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">1000 Sheets Box <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right plain_calculation_unit">
                              <li><a href="javascript:void(0);" data-batch="250">250 Sheet Pack </a></li>
                              <li><a href="javascript:void(0);" data-batch="1000">1000 Sheets Box</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class=""> <small class="small_plain_minqty_txt text-left col-xs-6">Min. sheets: <span class="min_qty">1000</span></small></div>
                      </div>
                    </div>
                    <div class="clear"></div>
                    <input type="hidden" name="" class="print_option" value="plain"/>
                    <div style="margin-top:5px;">
                      <div class="dm-box">
                        <div class="btn-group btn-block dm-selector digital_proccess-d-down"> <a class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown">Select Digital Print Process <i class="fa fa-unsorted"></i></a>
                          <ul class="dropdown-menu btn-block">
                            <li> <a data-toggle="tooltip-digital" data-value="" data-trigger="hover" data-placement="left" title="" data-id="digital"> Select Digital Print Process </a> </li>
                            <?php
                                $a4_prints = $this->home_model->get_digital_printing_process('A4');
                                foreach($a4_prints as $row){
                                        
                                ?>
                            <li> <a data-toggle="tooltip-digital" data-trigger="hover" data-placement="right" title="<?=$row->tooltip_info?>" data-id="digital" data-value="<?=$row->name?>" style="">
                              <?=$row->name?>
                              </a> </li>
                            <? } ?>
                          </ul>
                        </div>
                      </div>
                      <a href="#" class="btn btn-primary btn-block art-btn artwork_uploader" data-target=".artworkModal1" data-toggle="modal" data-original-title="Upload Your Artwork"> <i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Click here to Upload Your Artwork</a> </div>
                  </div>
                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 quotation">
                    <div class="printedprice_box" style="display:none;margin-top:20px;">
                      <table class="price" width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr class="plainprice" >
                            <td style=" width:80%;" class="text-left">Plain</td>
                            <td style=" width:20%;" class="plaintext text-right color-orange"></td>
                          </tr>
                          <tr class="printprice" style="">
                            <td style=" width:80%;" class="text-left phead"></td>
                            <td style=" width:20%;" class="printtext text-right color-orange"></td>
                          </tr>
                          <tr class="halfprintprice" style="">
                            <td style=" width:80%;" class="text-left phead color-orange">Half Price Promotion</td>
                            <td style=" width:20%;" class="halfprinttext color-orange text-right"></td>
                          </tr>
                          <tr class="no_design" style="">
                            <td colspan="2" class="text-left phead">3 Design Free</td>
                          </tr>
                          <tr class="desgincharge" style="display:none">
                            <td style=" width:80%;" class="text-left phead"> Additional Designs
                              <? $each_design_price = symbol.$this->home_model->currecy_converter(DesignPrice, 'yes'); 
							  echo $each_design_price?>
                              each </td>
                            <td style=" width:20%;" class="desginprice text-right color-orange"><b class="pr-sm"></b></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="text-right total"  style="border:none;"><div class="text-right printedprice_text priceplain final_price">&nbsp;</div>
                              <div class="clear"></div></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="text-right"><div class="printedperlabels_text"></div></td>
                          </tr>
                        </tbody>
                      </table>
                     
                    </div>
                     <div class="clearfix"></div>
                    <button class="btn orangeBg pull-right integrated_printed" data-int-type="printed" id="calulate_printed" type="button" style="margin-top:20px;"> Calculate Price <i class="fa fa-calculator"></i> </button>
                    <button style="display:none;" class="btn orangeBg pull-right add_integrate" data-int-type="printed" type="button"> Add to basket <i class="fa fa-calculator"></i> </button>
                  </div>
                </div>
              </div>
              <div id="tab_sample<?= $pro->ProductID ?>" class="tab-pane" role="tabpanel">
                <div class="col-xs-12" style="margin-top: 20px;"> <small> All material samples are supplied on A4 sheets for the purpose
                  of assisting the choice of face-stock colour and appearance. Along
                  with assessing the print quality and application suitability of the
                  adhesive. </small>
                  <div class="clear10"></div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12"> <small class="note">Please note: The material sample supplied
                      will not be the shape and size of the label/s shown on this
                      page. </small>
                      <div class="clear5"></div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6"></div>
                    <div class="col-lg-4 col-md-4 col-sm-3 col-xs-6">
                      <button class="btn orangeBg pull-right rsample" type="button"> Add Material Sample </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
      </section>
    </div>
    <div class="volume_break_section">
      <div id="aa_loader" class="white-screen hidden-xs" style="display:none;">
        <div class="loading-gif text-center" style="top:70%;left:35%;"><img
                                        src="<?= Assets_path ?>images/loader.gif" class="image"
                                        style="width:139px; height:29px; " alt="AA Labels Loader"></div>
      </div>
      <div id="integrated_label_section" class="m-t-b-10 m-t-60">
        <div class="integrated_tabs">
          <ul class="nav nav-tabs nav" role="tablist">
                  <li role="presentation" class="active"><a href="#sheet_box" aria-controls="profile" role="tab" data-toggle="tab"><img onerror='imgError(this);' src="<?=aalables_path?>images/box_icon.png" alt="Integrated Labels Box"/> <span class="title" data-title="1000 Sheets Box" style="position: relative;top: -7px;left: -15px;">1,000 Sheet Box</span></a></li>
                  <li role="presentation"> <a aria-controls="home" role="tab" data-toggle="tab" href="#sheet_pack"> <img onerror='imgError(this);' src="<?=aalables_path?>images/sheet_icon.png" alt="Integrated Labels Pack"/> <span class="title" data-title="250 Sheets Pack" style="position: relative;top: -7px;left: -15px;">250 Sheet Dispenser Pack</span></a></li>
                </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="sheet_pack">
              <div class="table-responsive">
                <table class="table table-bordered table-hover volume_breaks">
                  <thead class="bggreyThead">
                    <tr>
                      <th>Item Code</th>
                      <th>Type</th>
                      <th>Pack</th>
                      <th>Price Per Pack</th>
                      <th>Sheets</th>
                      <th style="line-height: 12px;">Total Price</small></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                                                $integrated_prices = $this->home_model->update_integrated_table(250, $pro->ManufactureID);
                                                foreach ($integrated_prices as $prices):
                                                    if ($prices->Box == 1) {
                                                        $text = "Pack";
                                                    } else {
                                                        $text = "Packs";
                                                    }
                                                    $price = $prices->Price_250;
                                                    $per_sheet = round($price / $prices->Box, 2);
                                                    ?>
                    <tr>
                      <td><?= $prices->ManufactureID ?></td>
                      <td><?= $prices->ProductLabel ?></td>
                      <td><?= $prices->Box . " " . $text ?></td>
                      <td><?= symbol . $this->home_model->currecy_converter($per_sheet) ?></td>
                      <td><?= $prices->Sheets ?>
                        Sheets </td>
                      <td><?= symbol . $this->home_model->currecy_converter($price) ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end tab content-->
            <div role="tabpanel" class="tab-pane active" id="sheet_box">
              <div class="table-responsive">
                <table class="table table-bordered table-hover volume_breaks">
                  <thead class="bggreyThead">
                    <tr>
                      <th>Item Code</th>
                      <th>Type</th>
                      <th>Box</th>
                      <th>Price Per Box</th>
                      <th>Sheets</th>
                      <th style="line-height: 12px;">Total Price</small></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                                                $integrated_prices = $this->home_model->update_integrated_table(1000, $pro->ManufactureID);
                                                foreach ($integrated_prices as $prices):
                                                    if ($prices->Box == 1) {
                                                        $text = "Box";
                                                    } else {
                                                        $text = "Boxes";
                                                    }
                                                    $price = $prices->Price_1000;
                                                    $per_box = round($price / $prices->Box, 2);
                                                    ?>
                    <tr>
                      <td><?= $prices->ManufactureID ?></td>
                      <td><?= $prices->ProductLabel ?></td>
                      <td><?= $prices->Box . " " . $text ?></td>
                      <td><?= symbol . $this->home_model->currecy_converter($per_box) ?></td>
                      <td><?= $prices->Sheets ?>
                        Sheets </td>
                      <td><?= symbol . $this->home_model->currecy_converter($price) ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end tab content--> 
          </div>
        </div>
        <?php //include('integrated_table.php')?>
      </div>
    </div>
  </div>
</div>
<!-- Layout modal -->
<div class="modal fade layout aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content no-padding">
      <div class="panel no-margin">
        <div class="panel-heading">
          <p class="no-margin"><span>Label Layout</span></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></button>
          <div class="clear"></div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 text-center"><img src="<?=aalables_path."images/categoryimages/Integrated/" . $pro->CategoryImage; ?>" alt="<?= $pro->specification1 ?>" title="<?= $pro->specification1 ?>" class="m-b-10 design-image"> <img  src="<?= aalables_path ?>images/thumb-arrow.png" class="thumb-arrow"></div>
            <div class="col-md-9">
              <table class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <td><strong>Labels Width: </strong></td>
                    <td><?= $pro->LabelWidth ?></td>
                    <td><strong>Labels Height:</strong></td>
                    <td><?= $pro->LabelHeight ?></td>
                  </tr>
                  <tr>
                    <td><strong>Label Across:</strong></td>
                    <td><?= $pro->LabelAcross ?></td>
                    <td><strong>Label Around:</strong></td>
                    <td><?= $pro->LabelAround ?></td>
                  </tr>
                  <tr>
                    <td><strong>Top Margin:</strong></td>
                    <td><?= $pro->LabelTopMargin ?></td>
                    <td><strong>Bottom Margin:</strong></td>
                    <td><?= $pro->LabelBottomMargin ?></td>
                  </tr>
                  <tr>
                    <td><strong>Gap Across:</strong></td>
                    <td><?= $pro->LabelGapAcross ?></td>
                    <td><strong>Gap Around:</strong></td>
                    <td><?= $pro->LabelGapAround ?></td>
                  </tr>
                  <tr>
                    <td><strong>Left Margin:</strong></td>
                    <td><?= $pro->LabelLeftMargin ?></td>
                    <td><strong>Right Margin:</strong></td>
                    <td><?= $pro->LabelRightMargin ?></td>
                  </tr>
                  <tr>
                    <td><strong>Corner Radius:</strong></td>
                    <td><?= $pro->LabelCornerRadius ?></td>
                    <td>  </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Layout modal --> 
<!-- Layout modal -->
<div class="modal fade material aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
        <h4 id="myModalLabel" class="modal-title">AA Labels Technical Specification - <span id="mat_code"></span> <a href="#myModalLabel" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
      </div>
      <div class="clear">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3 text-center"> <img id="material_popup_img" src="" width="46" height="46" class="m-t-b-10 img-Sheet-material"> </div>
            <div class="col-md-9">
              <div id="specs_loader" class="white-screen hidden-xs" style="display:none;">
                <div class="loading-gif text-center" style="top:26%;left:29%;"><img src="<?= Assets_path ?>images/loader.gif" class="image" style="width:139px; height:29px; "></div>
              </div>
              <div id="ajax_tecnial_specifiacation" class="specifiacation"></div>
              <div class="bgGray p-l-r-10"> <small> This summary materials specification for this adhesive label is based on information
                obtained from the original material manufacturer and is offered in good faith in
                accordance with AA Labels terms and conditions to determine fitness for use as sheet
                labels (A4, A3 &amp; SRA3) produced by AA Labels. No guarantee is offered or implied. It
                is the user's responsibility to fully asses and/or test the label's material and
                determine its suitability for the label application intended. Measurements and test
                results on this label's material are nominal. In accordance with a policy of continuous
                improvement for label products the manufacturer and AA Labels reserves the right to
                amend the specification without notice. A <a href="<?= base_url() ?>labels-materials/">full
                material specification</a> can be found in the Label Materials section accessed via
                the Home Page <br>
                Copyright&copy; AA labels 2015 </small> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade artworkModal1 aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content no-padding">
    	<div class="modal-header">
        	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
        	<h4 id="myModalLabel" class="modal-title">Upload Artwork <a href="#myModalLabel" class="anchorjs-link"><span class="anchorjs-icon"></span></a></h4>
    	</div>
        <div class="modal-body">
        	<div id="artworks_uploads_loader" class="white-screen hidden-xs" style="display:none;">
              <div class="loading-gif text-center" style="top:26%;left:29%;"><img src="<?= Assets_path ?>images/loader.gif" class="image" style="width:139px; height:29px; "></div>
            </div>
            <div id="ajax_artwork_uploadssss" class="row"></div>
        </div>
    </div>
  </div>
</div>
<input type="hidden" id="mannfacccture" value="<?= $integrate[0]->ManufactureID ?>">

<input type="hidden" id="ppproductName" value="<?= $integrate[0]->ProductName ?>">
<script>

    /************* Label Finder **********/
    var contentbox = $('#ajax_material_sorting');
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $("[data-toggle=tooltip-product]").tooltip();
        $('[data-toggle="popover"]').popover();
        //$('.fnTop').show().slideDown( "fast" );
        //$( ".labels-filters-form" ).slideUp( "fast" );
        //change_text('View Filters');
        <? if(isset($category) and $category != ''){?>
        //filter_data('autoload', '');
        <? }?>
    });

    $(document).on("focus", ".box_size,.print_option", function (e) {
        $('.print_price').css("visibility", "hidden");
        $('.black_price').css("visibility", "hidden");
        $('.plain_price').css("visibility", "hidden");
       // $('.final_price').css("visibility", "hidden");
        $('.add_integrate').hide();
		$(".printedprice_box").hide();
        $('.integrated_plain, .integrated_printed').show();
        $(".plainprice_box").hide();
    });
    
    $(document).on("click", ".delete_artwork_file", function (event) {
        var id = $(this).attr('id');
        var cartid = $('#cartid').val();
        var productid = $('#cartproductid').val();
        var persheet = $('#labels_p_sheet').val();
        var type = 'a4';
        var unitqty = $('#cartunitqty').val();

        unitqty = $.trim(unitqty);
        swal(
            "Are You Sure You Want To Delete This Line",
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
                    $.ajax({
                        url: mainUrl + 'search/Search/delete_material_artworks',
                        type: "POST",
                        async: "false",
                        dataType: "html",
                        data: {
                            fileid: id,
                            cartid: cartid,
                            productid: productid,
                            persheet: persheet,
                            type: type,
                            unitqty: unitqty
                        },
                        success: function (data) {
                            data = $.parseJSON(data);
                            if (!data == '') {
                                update_printed_quantity_box(data.qty, data.designs);
                                $('#ajax_upload_content').html(data.content);
                                intialize_progressbar();
                            }
                        }
                    });
                    break;
            }
        });
    });

    function delete_from_folder(file) {
        var aa = file.previewElement.querySelector("[data-dz-name]");
        var image = aa.innerHTML;
        $.ajax({
			url: mainUrl + 'search/Search/delete_from_folder',
            type: "post",
            async: "false",
            dataType: "html",
            data: {file: image, productid: '<?=$pro->ProductID?>'},
            success: function (data) {
                if (data) {
                    var counter = $('#filecounter').val();
                    $('#filecounter').val(parseInt(counter) - 1);
                    console.log($('#filecounter').val());
                }
            }
        });
    }

    $('#print_option').change(function () {
        if ($(this).val() == "plain") {
            $('#uploader').hide();
        } else {
            $('#uploader').show();
        }
    });
	
	var aalables_path = '<?=aalables_path?>';

$(document).on("click", ".pull-left > a", function (e) {
	var id = $(this).attr('id');
	var curent_class = $(this).attr('class');
	if (curent_class == 'btn blueBg') {
		var src = $("#int_" + id).attr('alt');
		$(this).removeClass('btn blueBg');
		$(this).addClass('btn orangeBg');
		$("#int_" + id).attr('src', aalables_path+'images/categoryimages/Integrated/' + src);
		$(".product_material_image").attr('src', aalables_path+'images/categoryimages/Integrated/' + src);
	} else {
		var src = $("#int_" + id).attr('title');
		$(this).removeClass('btn orangeBg');
		$(this).addClass('btn blueBg');
		$("#int_" + id).attr('src',aalables_path+'images/categoryimages/Integrated/' + src);
		$(".product_material_image").attr('src', aalables_path+'images/categoryimages/Integrated/' + src);
	}
});

    function fireRemarketingTag(page) {
        <? if(SITE_MODE == 'live123'){?>
        dataLayer.push({'event': 'fireRemarketingTag', 'ecomm_pagetype': page});
        <? } ?>
    }

    $(document).on("click", ".technical_specs", function (e) {
        var id = $(this).parents('.productdetails').find('.product_id').val();
        $('#ajax_tecnial_specifiacation').html('');
        $('#mat_code').html('');
        $('#specs_loader').show();
        $.ajax({
            url: base + 'ajax/material_popup/' + id,
            type: "POST",
            async: "false",
            dataType: "html",
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    $('#material_popup_img').attr('src', data.src);
                    setTimeout(function () {
                        $('#specs_loader').hide();
                        $('#ajax_tecnial_specifiacation').html(data.html);
                        $('#mat_code').html(data.mat_code);
                    }, 500);
                }
            }
        });
    });
    $(document).on("click", ".applications", function (e) {
        var groupname = $(this).attr('id');
        $('.ajax_application_chart').html('');
        $('#app_group_name').html('');
        $('#lb_applications_loader').show();

        $.ajax({
            url: base + 'ajax/application_popup/',
            type: "POST",
            async: "false",
            dataType: "html",
            data: {'groupname': groupname, type: 'sheets'},
            success: function (data) {
                if (!data == '') {
                    data = $.parseJSON(data);
                    setTimeout(function () {
                        $('#lb_applications_loader').hide();
                        $('.ajax_application_chart').html(data.html);
                        $('#app_group_name').html(data.group_name);
                        $("b.popup-title").html(data.group_name);
                    }, 500);
                }
            }
        });
    });
    $(document).on("click", ".rsample", function (e) {
        var p_code = $(this).parents('.productdetails').find('.product_id').val();
        var menuid = $(this).parents('.productdetails').find('.manfactureid').val();
        var prd_name = $(this).parents('.productdetails').find('.product_name').text();
        var pageName = $('#mypageName').val();
        var userId = $('#useer_id').val();
        var quotationNumber = $('#order_number').val();
        var _this = $(this);
        if (menuid) {
            change_btn_state(_this, 'disable', 'sample');
            $.ajax({
                url: mainUrl + 'search/Search/add_sample_to_cart',
                type: "POST",
                async: "false",
                dataType: "html",
                data: {
                    pageName: pageName,
                    userId: userId,
                    quotationNumber: quotationNumber,
                    qty: 1,
                    menuid: menuid,
                    prd_id: p_code
                },
                success: function (data) {
                    if (!data == '') {
                        if (pageName != null && pageName != "") {
                            window.location.reload();
                        } else {
                            $(".requestsample").modal('hide');
                            data = $.parseJSON(data);
                            if (data.response == 'yes') {
                                change_btn_state(_this, 'enable', 'sample');
                                var sample_txt = "Thank you for requesting a sample, an A4 sheet of the material chosen will be sent via the post. \n\n Please note: The label size on the sample will not match the label/s on this page.";
                                swal("Material Sample Added to Basket", sample_txt, "success");
                                $('#cart').html(data.top_cart);
                            }
                            else if (data.response == 'failed') {
                                swal("Maximum limit exceeded", data.msg, "error");
                            }
                        }


                    }
                }
            });
        }
    });
    $('.artworkModal1').on('hidden.bs.modal', function (e) {
		var productid = $(".product_id").val();
		var designs = $("#uploadedartworks_"+productid).val();
		var qty = $("#uploadedartworks_"+productid).attr('data-qty');
		
		update_printed_quantity_box(qty, designs)

        /*if (designs > 0) {
            var Artwork = 'Design';
            if (designs > 1) {
                var Artwork = 'Designs';
            }
            $('.artwork_uploader').switchClass('art-btn', 'art-btn-l');
            var btnhtml = '<div class="row"><div class="col-xs-4"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>';
            btnhtml += '<div class="col-xs-8"><b>' + designs + ' ' + Artwork + ' Uploaded </b>';
            btnhtml += '<small>Click here to upload further<br>artworks, view or edit.</small></div></div>';
            $('.artwork_uploader').html(btnhtml);
        }
        else {
            $('.artwork_uploader').switchClass('art-btn-l', 'art-btn');
            var btnhtml = '<i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp; Click here to Upload Your Artwork';
            $('.artwork_uploader').html(btnhtml);
        }*/
        $('.tabprinted').find('.box_size').trigger("change");
        $('.tabprinted').find('.box_size').trigger("focus");
    });
    var timer = '';
    function show_faded_popover(_this, text) {
        $(_this).attr('data-content', '');
        $(_this).popover('hide');
        $(_this).popover({'placement': 'top'});
        $(_this).attr('data-content', text);
        $(_this).popover('show');
        clearTimeout(timer);
        timer = setTimeout(function () {
            $(_this).attr('data-content', '');
            $(_this).popover('hide');
        }, 3000);
    }

    $(document).on("click", ".plain_calculation_unit li a, .price-btn", function (e) {
        var selText = $(this).data('batch');
        var old_val = $.trim(parseInt($(this).parents('.input-group-btn').find('.dropdown-toggle').text()));

        if ($.trim(old_val) == $.trim(selText)) {
            return true;
        }

        if (selText == '250') {
            $(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText + ' Sheets Pack <span class="caret"></span>');
        }
        else {
            $(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText + ' Sheets Box <span class="caret"></span>');
        }
		
        $('.print_price').css("visibility", "hidden");
        $('.black_price').css("visibility", "hidden");
        $('.plain_price').css("visibility", "hidden");
        $('.final_price').css("visibility", "hidden");

        $('.add_integrate').hide();
        $('.integrated_plain, .integrated_printed').show();
        $(".plainprice_box").css("display", "none");
        $('.min_qty').html(selText);
        $('.box_size').val('');
        if (selText == '250') {
            $(".integrated_tabs").find("a[href='#sheet_pack']").trigger("click");
        }
        else {
            $(".integrated_tabs").find("a[href='#sheet_box']").trigger("click");
        }
        //update_prices_table(selText);
    });

    function update_prices_table(qty) {
        var manufactureid = $.trim($(".pr-detail").find(".pr-code").text());
        $("#aa_loader").show();
        $.ajax({
            url: base + 'ajax/update_integrated_table',
            type: 'POST',
            dataType: "html",
            data: {
                qty: qty,
                manufactureid: manufactureid
            },
            success: function (data) {
                data = $.parseJSON(data);
                $("#aa_loader").hide();
                $("#integrated_label_section").html(data.html);
            }
        });
    }

    $(document).on("click", ".integrated_tabs li a", function (e) {
        var qty = $(".box_size").val();
        text = $(this).find("span.title").data('title');
        min_qty = parseInt(text);
        $(".min_qty").text(min_qty);
        var type = $(this).attr("href");
        text += " <span class='caret'></span>";
        type = type.substr(1, type.length);
		$(".integrated_tabs li").removeClass("active");
		$(this).parents('li').addClass("active");
        $(".plainsheet_unit").html(text);
        if (qty != '') {
            $(".integrated_plain").trigger("click");
        }
    });
	
$(document).on("click", ".integrated_plain, .integrated_printed", function(e) {
		
		var type_ps = $(this).data('int-type');
	  var print_option = type_ps;
		var print_option = $(this).parents('.tab-pane').find('.print_option').val();
		var box_inp = $(this).parents('.tab-pane').find('.box_size');
		var box = parseInt(box_inp.val());
		var batch = parseInt($('.plainsheet_unit').text());
		var cart_id =  $(this).parents('.productdetails').find('.cart_id').val();
		var prd_id = $(this).parents('.productdetails').find('.product_id').val();
		var min_qty = batch;
		var max_qty = 500000;
		
		var artworks = parseInt($(this).parents('.productdetails').find('#uploadedartworks_'+prd_id).val());
		var upload_qty = parseInt($(this).parents('.productdetails').find('#uploadedartworks_'+prd_id).attr('data-qty'));
  var manual_design = parseInt($(this).parents('.productdetails').find('#no_artworks_'+prd_id).val());

		var persheet = '';
		var manufacture = $("#mannfacccture").val();

		var _this = $(this);
		if(box == NaN || box_inp.val() == '')
		{
			box_inp.val(min_qty);
			show_faded_popover(box_inp, "Minimum "+batch+" sheets allowed");
			return false;
		}
		else if(box < min_qty)
		{
			show_faded_popover(box_inp, "Minimum "+batch+" sheets allowed");
			box_inp.val(min_qty);
			return false;
		}
		else if(box > max_qty)
		{
			box_inp.val(max_qty);
			show_faded_popover(box_inp, "Maximum "+max_qty+" sheets allowed");
			return false;
		}
		//console.log('type: '+type_ps);
		//console.log('print_option: '+print_option);
		if(type_ps == 'printed' && ( print_option == 'plain' || print_option == '') )
		{
			swal("Please Select","Digital Printing Process","warning");
			return false;
		}
		if(box%batch != 0)
		{
			if(batch == 250)
			{
				box = Math.round(box/250)*250;
			}
			else
			{
				box = Math.round(box/1000)*1000;
			}
			$(box_inp).val(box);
			show_faded_popover(box_inp, "Quantity has been round off to "+box);
		}
		if(type_ps == 'printed' && print_option != 'plain')
		{
		
			
			if(upload_qty==0){
				$(this).parents('.productdetails').find('.artwork_uploader').click();
				alert_box("You have changed the quantity of Sheets. Minimun Quantity "+ box );
				return false;
			}
		}
		change_btn_state(_this,'disable','plain');
		$("#aa_loader").show();
		$.ajax({
				url: mainUrl+'search/search/get_box_price',
				type:"post",
				async:"false",
				dataType:"json",
				data:{manufature:manufacture,box:box,print_option:print_option,batch:batch,cart_id:cart_id,prd_id: prd_id,manual_design:manual_design},
				success: function(data){
					change_btn_state(_this,'enable','plain');
					if(print_option=="black"){
						$('.print_price').html('');
						$('.plain_price').html(' '+data.symbol+''+data.plain_price);
						$(_this).parents('.tab-pane').find('.black_price').html(' '+data.symbol+''+data.black_price);
					}
					else if(print_option=="printed"){
						$('.black_price').html('');
						$('.plain_price').html(' '+data.symbol+''+data.plain_price);
						$(_this).parents('.tab-pane').find('.print_price').html(' '+data.symbol+''+data.print_price);
					}else{
						$('.print_price').html('');
						$('.black_price').html('');
						$(_this).parents('.tab-pane').find('.plain_price').html(' '+data.symbol+''+data.plain_price);
					}
					
					if(type_ps == 'printed')
					{
						var print_text = "";
						if(data.print_option == "black")
						{
							print_text = "<span>Monochrome - Black Only</span>";
						}
						else if(data.print_option == "printed")
						{
							print_text = "<span class='color_orange'>Full Colour</span>";
						}
						$(_this).parents('.tab-pane').find('.print_type').html(print_text).show();
						if(data.print_option=='Fullcolour'){
							$(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.phead').text('Printed Full Color');
						}else if(data.print_option=='Mono'){
							$(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.phead').text('Printed Black');
						}
						$(_this).parents('.productdetails').find('.printedprice_box .price .plainprice').find('.plaintext').html('<b class="pr-sm">'+data.symbol+data.plain_price+'</b>');
		
						$(_this).parents('.productdetails').find('.printedprice_box .price .printprice').find('.printtext').html('<b class="pr-sm">'+data.symbol+data.halfprintprice+'</b>');
		
						$(_this).parents('.productdetails').find('.printedprice_box .price .halfprintprice').find('.halfprinttext').html('-<b class="pr-sm">'+data.symbol+data.printprice+'</b>');
				 		
						$(_this).parents('.productdetails').find('.printedprice_box .price .no_design').find('.phead').html(data.artworks+' Design Free');

						$(_this).parents('.productdetails').find('.printedprice_box .price .desgincharge').find('.desginprice').html('<b class="pr-sm">'+data.symbol+data.designprice+'</b>');
						$(_this).parents('.productdetails').find('.printedprice_text').html('<b class="priceTextOrange color_orange"> '+data.symbol+''+data.total+'</b><span>'+data.vatoption+' VAT</span>');
			
						$(_this).parents('.productdetails').find('.printedperlabels_text').html(box+" Sheets, " + data.symbol + "" + data.per_sheet+" Per Sheet");
						$(_this).parents('.productdetails').find('.printedprice_box').show();
					}
					else
					{
						$(_this).parents('.tab-pane').find('.plainprice_box').css("display","block");
						$(_this).parents('.tab-pane').find('.final_price').html('<b class="priceTextOrange color_orange"> '+data.symbol+''+data.total+'</b><span>'+data.vatoption+' VAT</span>');
						$(_this).parents('.tab-pane').find('.final_price').css("visibility","visible");
						$(_this).parents('.tab-pane').find('.delivery_charges').html(data.symbol+''+data.dpd);
						$(_this).parents('.tab-pane').find('.quantity_text').html(box+" Sheets");
						$(_this).parents('.tab-pane').find('.persheet_text').html(data.symbol + "" + data.per_sheet+" Per Sheet");
					}
					$(_this).hide();
					$(_this).parents('.tab-pane').find('.add_integrate').show();
					$("#aa_loader").hide();
				}  
			});
});
	
$(document).on("click", ".productdetails .dm-selector li a", function(e) {
	var selText = $(this).text();
	var value = $(this).attr('data-value');
	if(value.length > 0){
		 $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <i class="fa fa-unsorted"></i>');
		 $(this).parents('.productdetails').find('.print_option').val(value);
	}else{
		$(this).parents('.btn-group').find('.dropdown-toggle').html('Select Digital Print Process <i class="fa fa-unsorted"></i>');
		$(this).parents('.productdetails').find('.print_option').val('plain');
	}
	$(this).parents(".productdetails").find(".tabprinted").find(".box_size").trigger("focus");
});
</script>