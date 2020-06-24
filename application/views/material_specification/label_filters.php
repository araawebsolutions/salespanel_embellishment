<link href="<?=Assets?>labelfinder/css/newstyles.css" rel="stylesheet">
<style>
.lablefilterslider {
	margin: 6px auto;
}
</style>
<div class="row">
  <div class="lf-pos">
    <div class="thumbnail orange-bottom no-margin no-padding-bottom" style="min-height: 73px;">
      <div class="finderNote row fnTop">
        <div class="col-md-12 text-center">
          <p class="no-margin">The label filter enables you to select and view products that closely match your search criteria through the use of search tools. Click on the “VIEW FILTERS”  button below to begin using.</p>
        </div>
      </div>
      <form id="filter-form" class="labels-form labels-filters-form  m-t-10">
        <input type="hidden" value="finder"  id="page_type"   />
        <input type="hidden" value="product"  id="view"   />
        <input type="hidden" value="<?=(isset($printer_width) and $printer_width!='')?$printer_width:''?>"  id="printer_width"   />
        <input type="hidden" id="newcategory" name="newcategory" value="<?=$category?>" class="nlabelfilter">
        <div class="clear"></div>
        <!------ NEW FILTER ------------>
        <div class="clearfix">
          <div class="col-md-7">
            <div id="categorybox"></div>
            <div class="ChooseShapesMain">
              <div class="ChooseShapes" style="width:100%;">
                <h3 class="group_name" style="font-size: 18px;color: #006da4;font-weight: bold;margin: 0 0 10px 0;">Choose a Shape</h3>
                <input type="hidden" id="shape" value="<?=($shape)?$shape:''?>" />
                <div id="shapes_box" style="margin-bottom:20px;">
                  <button type="button" disabled="disabled" class="btn_shape rectangle" data-toggle="tooltip" title="Rectangle" data-val="Rectangle"> </button>
                  <button type="button" disabled="disabled" class="btn_shape square" data-toggle="tooltip" title="Square" data-val="Square"></button>
                  <button type="button" disabled="disabled" class="btn_shape circular" data-toggle="tooltip" title="Circular" data-val="Circular"></button>
                  <button type="button" disabled="disabled" class="btn_shape oval" data-toggle="tooltip" title="Oval" data-val="Oval"></button>
                  <button type="button" disabled="disabled" class="btn_shape star" data-toggle="tooltip" title="Star" data-val="Star"></button>
                  <button type="button" disabled="disabled" class="btn_shape heart" data-toggle="tooltip" title="Heart" data-val="Heart"></button>
                  <button type="button" disabled="disabled" class="btn_shape triangle" data-toggle="tooltip" title="Triangle" data-val="Triangle"></button>
                  <button type="button" disabled="disabled" class="btn_shape perforated" data-toggle="tooltip" title="Perforated" data-val="Perforated"></button>
                  <button type="button" disabled="disabled" class="btn_shape irregular" data-toggle="tooltip" title="Irregular" data-val="Irregular"></button>
                  <button type="button" disabled="disabled" class="btn_shape anti-tamper" data-toggle="tooltip" title="Anti-Tamper" data-val="Anti-Tamper"></button>
                </div>
                <div class="LabelWidthMain" id="width_box">
                  <div class="LabelWidthHeader text-center" id="width_box_text"> LABEL WIDTH (mm) </div>
                  <div class="LabelMain">
                    <div data-role="page" class="Range">
                      <div class="">
                        <label class="input pull-left" style="width:40%">
                          <input type="text" class="control_input allowdecimal" placeholder="Min width" id="width_min" name="width_min">
                        </label>
                        <label class="input pull-right" style="width:40%">
                          <input type="text" class="control_input allowdecimal" placeholder="Max width" id="width_max" name="width_max">
                        </label>
                      </div>
                      <div class="clear"></div>
                      <div class="lablefilterslider" style="clear:left;">
                        <div id="width_slider" class="slider sliderRange sliderBlue"></div>
                      </div>
                    </div>
                    <div class="clearfix rangelimit">
                      <div class="col-xs-6 text-left"><small class="width_lowerlimit">0</small></div>
                      <div class="col-xs-6 text-right"><small class="width_upperlimit">0</small></div>
                    </div>
                  </div>
                </div>
                <div class="LabelHeightMain" id="height_box">
                  <div class="LabelWidthHeader text-center"> Label Height (mm) </div>
                  <div class="LabelMain">
                    <div data-role="page" class="Range">
                      <div class="">
                        <label class="input pull-left" style="width:40%">
                          <input type="text" class="control_input allowdecimal" placeholder="Min height" id="height_min" name="height_min">
                        </label>
                        <label class="input pull-right" style="width:40%">
                          <input type="text" class="control_input allowdecimal" placeholder="Max height" id="height_max" name="height_max">
                        </label>
                      </div>
                      <div class="clear"></div>
                      <div class="lablefilterslider" style="clear:left;">
                        <div id="height_slider" class="slider sliderRange sliderBlue"></div>
                      </div>
                    </div>
                    <div class="clearfix rangelimit">
                      <div class="col-xs-6 text-left"><small class="height_lowerlimit">0</small></div>
                      <div class="col-xs-6 text-right"><small class="height_upperlimit">0</small></div>
                    </div>
                  </div>
                </div>
                <div class="clear"></div>
                <div class="WidthHightCheckbox">
                  <label class="check">Include opposite dimensions in the search criteria e.g. Height for Width
                    <input type="checkbox" checked="checked" name="opposite_dimension" id="opposite_dimension">
                    <span class="checkmark"></span> </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="selected_material_box">
              <div class="mat-sep-2017">
                <div class="selected-product">
                  <h3 class="group_name">Your Material Selection</h3>
                  <div class="row selected-mat m-t-10" style="display:flex;">
                    <div class="col-lg-5 col-md-5 col-sm-3 col-xs-4 pr-thumb text-center">
                      <? if($category=='Roll'){
                            $imagepath = Assets.'images/material_images/roll/'.$info['material_code'].'.png';
                         }
                         else
                         {
                            $imagepath = Assets.'images/material_images/sheets/'.$info['material_code'].'.png';
                         }
                      ?>
                      <img src="<?=$imagepath?>" alt="<?=$info['short_name']?>" class="sm-th img-responsive" /> </div>
                    <div class="col-lg-7 col-md-7 col-sm-9 col-xs-8">
                      <h2 class="pr-title">
                        <?=$info['short_name']?>
                      </h2>
                      <div class="pr-detail">
                        <p>
                          <?=$info['tooltip_info']?>
                        </p>
                        <a href="#" id="<?=$productid?>" class="technical_specs_header" data-target=".material" data-toggle="modal" data-original-title="Tecnial Specification"> <i class="fa fa-info-circle"></i> View Material Specification</a>
                        <div class="clear10"></div>
                        <?php
                        $url = base_url().$this->uri->segment(1)."/".$this->uri->segment(2);
                        ?>
                        <button class="btn blue2 pull-right edit_material_option" type="button" data-url="<?=$url?>"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Back to Materials </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix">
          <div class="col-md-6"> </div>
          <div class="SectionLeft col-md-6"> </div>
        </div>
        <div class="clearfix">
          <div class="SectionThreeMain col-md-12">
            <div class="col-md-6">
              <div class="material_filter_box" style="display:none">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label class="select">
                    <select name="finish" id="finish" class="nlabelfilter">
                      <option value="<?=$LabelFinish?>">Select Labels Finish</option>
                    </select>
                    <i></i> </label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label class="select">
                    <select name="color" id="color" class="nlabelfilter">
                      <option value="<?=$LabelColor?>">Select Labels Colour </option>
                    </select>
                    <i></i> </label>
                </div>
                <div class="clear"></div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="labelF"> Label Adhesive </div>
                  <input type="hidden" id="adhesive" value="<?=$Labeladhesive?>" />
                </div>
                <div class="clear25"></div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label class="select">
                    <select name="material" id="material" class="nlabelfilter">
                      <option value="<?=$ColourMaterial?>">Select Labels Material</option>
                    </select>
                    <i></i> </label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label class="select">
                    <select name="printer" id="printer"  class="nlabelfilter">
                      <option value="">Select Printer / Copier Type</option>
                    </select>
                    <i></i> </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" value="0" id="product_count" />
        <input type="hidden" value="0" id="start_limit" />
        <!--<div class="clear"></div>
          <div class="finderNote row">
          <div class="col-md-12 text-center">
           <b>Define or expand your search further</b>
          <div class="clear"></div>
          <p class="no-margin">
          The label filter enables you to select and view products that closely match your search criteria through the use of search tools.</p>
          </div>
        </div>-->
      </form>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
      <button class="show-h"><span><i aria-hidden="true" class="fa fa-bars"></i>
      <div class="clea"></div>
      HIDE FILTERS</span></button>
    </div>
  </div>
</div>
<div id="compare_modal" class="modal fade aa-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content no-padding">
      <div class="panel no-margin">
        <div class="panel-heading">
          <h3 class="pull-left no-margin"><b>Compare Products</b></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></button>
          <div class="clear"></div>
        </div>
        <div class="panel-body">
          <div id="compare_modal_content" ></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
var shape_list = [];
<?php $shapes = $this->filter_model->generate_category_shapes();?>
shape_list = <?=$shapes?>;
</script>