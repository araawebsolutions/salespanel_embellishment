<?
foreach($materials as $rec){
    if(preg_match("/Circular/i",$rec->Shape) || preg_match("/Oval/i",$rec->Shape)){
        $img_class = 'img-circle';
    }else{
        $img_class = 'img-Sheet';
    }

    $pname=explode('-',$rec->ProductName);

    if($rec->Adhesive=='Removable' || $rec->Adhesive=='Peelable'){
        $adhesive="Peelable";
    }else{
        $adhesive=$rec->Adhesive;
    }




    if(preg_match("/A3/",$rec->ProductBrand)){
        $min_qty = '100';
        $max_qty = '50000';

    }
    else if(preg_match("/Roll Labels/",$rec->ProductBrand)){

        $min_qty = $this->home_model->min_qty_roll($rec->ManufactureID);
        $max_qty = $this->home_model->max_qty_roll($rec->ManufactureID);
        $img_class = 'img-circle';

    }
    else if(preg_match("/SRA3/",$rec->ProductBrand)){
        $min_qty = '100';
        $max_qty = '20000';
    }
    else{
        if(preg_match("/PETC/",$rec->ManufactureID) || preg_match("/PETH/",$rec->ManufactureID) || preg_match("/PVUD/",$rec->ManufactureID)){
            $min_qty = '25';
            $max_qty = '5000';

        }else{
            $min_qty = '25';
            $max_qty = '50000';
        }
    }



    $words = preg_split("/[\s,]+/", $adhesive);

    $desc = $rec->ProductCategoryName.". ".$rec->Appearance;

    $comp = $this->home_model->check_compatibility($rec->SpecText7,$rec->ProductBrand);

    $rec->Image1 = str_replace(".gif",".png",$rec->Image1);

    /*
    $max_length = 130;
    if (strlen($desc) > $max_length){
         $offset = ($max_length - 3) - strlen($desc);
         $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
         $short_desc .= ' to read more place the <a style="cursor:pointer;" title="'.$desc.'"> cursor here.</a>';
    }else{
         $short_desc = $desc;
    } */


    $short_desc = $desc;

    if (preg_match("/A4 Labels/is", $rec->ProductBrand) and ( preg_match("/WPEP/i", $rec->ManufactureID))) {
        $short_desc = $short_desc.' <br /> <strong style="color:#fd4913"> Special Offer Save 20% While Stocks Last </strong> ';
    }
    else if (preg_match("/Roll Labels/",$rec->ProductBrand) and preg_match("/HGP/i", $rec->ManufactureID)) {
        $short_desc = $short_desc.' <br /> <strong style="color:#fd4913"> Special Offer Save 30% While Stocks Last </strong> ';
    }

    if (preg_match("/WASP/i", $rec->ManufactureID)) {
        $comp = 'Commercial Inkjet (UV Inks Only), many Laser, but not all (sample request and test advised before ordering) and Thermal Transfer Printers.';
    }

    ?>



    <div class="detail">
        <div class="row inner">
            <div class="col-lg-1 col-md-1 col-sm-12 samp text-center">
                <img class="<?=$img_class?>" src="<?=Assets?>images/material_images/<?=$rec->Image1?>" width="46" height="46">
            </div>
            <div class="col-lg-11 col-md-11 col-sm-12 cont">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <h4 id="prd_name<?=$rec->ProductID?>"> <?=$pname[0]?> </h4>
                    <p><?=$short_desc?></p>
                    <div class="clear5"></div>
                    <? if($comp!=''){?>
                        <small class="comp">Compatible with <?=$comp?></small><br />
                    <? } ?>
                    <br />
                    <a href="#" id="<?=$rec->ProductID?>" class="technical_specs" data-target=".material" data-toggle="modal"
                       data-original-title="Tecnial Specification">  View Material Specification </a>

                    <div class="pull-right LabelTag adhesive<?=str_replace(" ","",$adhesive)?> no-margin"><?=$adhesive?><br>
                        <small>Adhesive</small> </div>
                </div>

                <div class="col-lg-8 col-md-8 col-sm-12">

                    <? if(preg_match("/Roll Labels/",$rec->ProductBrand)){

                        if(isset($max_diameter) and $max_diameter!=0 ){
                            $total_labels = $this->home_model->get_max_labels_printer($rec->ManufactureID,$rec->LabelsPerSheet, $max_diameter, $Labelsgap, $height);
                            if(isset($total_labels) and $total_labels!=0 and $total_labels <= $rec->LabelsPerSheet){ $rec->LabelsPerSheet = $total_labels; }
                        }  ?>
                        <input type="hidden"  id="max_labels<?=$rec->ProductID?>"  value="<?=$rec->LabelsPerSheet?>"  />
                        <input type="hidden"  id="min_qty<?=$rec->ProductID?>"  value="<?=$min_qty?>"  />
                        <input type="hidden"  id="max_qty<?=$rec->ProductID?>"  value="<?=$max_qty?>"  />

                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                Enter number of labels and rolls
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <p class="cBlue pull-left"><strong>Labels Per Roll</strong>
                                            <input maxlength="4"  onfocus="show_calculate_btn(<?=$rec->ProductID?>);"  type="text"
                                                   id="labels_<?=$rec->ProductID?>"  placeholder="100+"
                                                   class="form-control allownumeric" >


                                            <small>Maximum labels per roll - <?=$rec->LabelsPerSheet?></small> </p>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <p class="cBlue pull-left"> <strong style="font-size:12px;">Number of Rolls</strong>

                                            <input maxlength="3" onfocus="show_calculate_btn(<?=$rec->ProductID?>);" type="text"
                                                   id="roll_<?=$rec->ProductID?>" placeholder="<?=$min_qty?>+"
                                                   class="form-control allownumeric" >

                                            <small>Multiples of <?=$min_qty?> only</small> </p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12">
                                        <div style="display:none;" id="diameter_<?=$rec->ProductID?>" class="rollLable_icon no-margin"></div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 del-f">
                                        <div id="delivery_txt<?=$rec->ProductID?>"></div>&nbsp;</div>



                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 text-right right-col">

                                <table id="price_box_<?=$rec->ProductID?>" style="display:none;"
                                       width="100%" cellspacing="0" cellpadding="0" border="0" class="price">
                                    <tbody>
                                    <tr  class="total">
                                        <td  style="border:none;" class="text-left">&nbsp;</td>
                                        <td  style="border:none;">	<div class="price" id="price_<?=$rec->ProductID?>">&nbsp;</div>
                                            <div class="clear"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <div class="priceText" id="priceText_<?=$rec->ProductID?>">&nbsp;</div>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>

                                <div class="clear10"></div>



                                <button id="add_btn<?=$rec->ProductID?>" onclick="add_roll_item('<?=$rec->ProductID?>','<?=$rec->ManufactureID?>');"
                                        class="btn pull-right m-t-15 orangeBg" style=" display:none;" type="button"> Add to basket <i class=" fa fa-cart-plus"></i> </button>
                                <button id="cal_btn<?=$rec->ProductID?>" onclick="calculate_roll_price('<?=$rec->ProductID?>','<?=$rec->ManufactureID?>');"
                                        class="btn pull-right blueBg"  type="button"> Calculate Price <i class="fa fa-calculator"></i> </button>

                                <div class="clear10"></div>

                                <a href="#" id="<?=$rec->ManufactureID?>" data-labels="<?=$rec->LabelsPerSheet?>" class="price_breaks"
                                   data-target=".pbreaks" data-toggle="modal" data-original-title="Volume Price Breaks">View volume price breaks</a>

                            </div>
                        </div>



                    <? }else{?>




                        <div class="row">

                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="row">

                                    <div data-value="<?=$rec->ProductID?>" class="col-lg-5 col-md-5 col-sm-12 labels-form print_option">
                                        <label class="radio">
                                            <input type="radio" name="popt_<?=$rec->ProductID?>" class="textOrange" value="plain" checked>
                                            <i></i>Plain Labels</label>
                                        <label class="radio">
                                            <input type="radio" class="print_option textOrange"  name="popt_<?=$rec->ProductID?>" value="Mono">
                                            <i></i>Printed Black Only</label>
                                        <label class="radio">
                                            <input type="radio" class="print_option textOrange"  name="popt_<?=$rec->ProductID?>" value="Fullcolour">
                                            <i></i>Printed Full Colour</label>
                                        <label class="radio">
                                            <input type="radio" class="print_option textOrange" name="popt_<?=$rec->ProductID?>" value="sample">
                                            <i></i>Order a Material Sample</label>
                                    </div>

                                    <div class="col-lg-7 col-md-7 col-sm-12">

                                        <div id="sampletext_<?=$rec->ProductID?>" class="col-lg-12 col-md-12 col-sm-12 text-justify" style=" display:none;">
                                            All material samples are supplied on A4 sheets for the purpose of assisting the choice of face-stock colour and appearance. Along with assessing the print quality and application suitability of the adhesive.
                                            <br /><small style="color:#F00;"><b>Please note:</b> The material sample supplied will not be the shape and size of the label/s shown on this page.</small>
                                        </div>


                                        <div class="row" id="calculations_box<?=$rec->ProductID?>">
                                            <div class="col-lg-8 col-md-8 col-sm-12 add"> <b>Add number of sheets</b>
                                                <div class="clear"></div>
                                                <small>Minimum order  <?=$min_qty?> sheets</small> </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <input type="text" onfocus="show_calculate_btn(<?=$rec->ProductID?>);" id="sheet_qty_<?=$rec->ProductID?>"
                                                       class="form-control allownumeric" maxlength="5" placeholder="+<?=$min_qty?>" />
                                            </div>


                                            <div class="clear"></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 del-f">
                                                <small id="save_txt<?=$rec->ProductID?>">&nbsp;</small>
                                                <div id="delivery_txt<?=$rec->ProductID?>" class="clear"></div>&nbsp;</div>
                                        </div>


                                        <input type="hidden"  id="labels_p_sheet<?=$rec->ProductID?>"  value="<?=$rec->LabelsPerSheet?>"  />
                                        <input type="hidden"  id="min_qty<?=$rec->ProductID?>"  value="<?=$min_qty?>"  />
                                        <input type="hidden"  id="max_qty<?=$rec->ProductID?>"  value="<?=$max_qty?>"  />
                                    </div>


                                    <div class="clear5"></div>
                                    <div id="uploader<?=$rec->ProductID?>" class="col-lg-12 col-md-12 col-sm-12" style="display:none;">
                                        <form action="/upload-target" class="dropzone">

                                            <input type="hidden" class="productsid" value="<?=$rec->ProductID?>"  />
                                            <input type="hidden" class="filecounter" value="0"  />
                                            <div class="dz-message">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><i class="fa fa-upload"></i></div>
                                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                    <strong>UPLOAD ARTWORK</strong><br />
                                                    <span class="note">Click here to attach your artwork with the order for printed labels.<br />
                                         	 Permissible file types: EPS; GIF; JPEG; JPG; PDF & PNG<br /><br />
                                         	 <strong>Please note: </strong>  The maximum number of file uploads is 8 per label. Additional artwork files can be attached to an email if required.
                                           </span>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="clear10"></div>
                                </div></div>


                            <div class="col-lg-4 col-md-4 col-sm-12 text-right right-col">
                                <div id="price_box_<?=$rec->ProductID?>" style="display:none;" >
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="price">
                                        <tbody>
                                        <tr id="plainprice<?=$rec->ProductID?>" style="display:none" class="">
                                            <td class="text-left">Plain</td>
                                            <td class="plaintext"><b class="pr-sm"></b></td>
                                        </tr>
                                        <tr id="printprice<?=$rec->ProductID?>" style="display:none" class="">
                                            <td style="padding:3px 0px;" class="text-left phead">Printed Black</td>
                                            <td style="padding:3px 0px;;" class="printprice"><b class="pr-sm"></b></td>
                                        </tr>
                                        <tr id="no_design<?=$rec->ProductID?>"  style="display:none" class="">
                                            <td class="text-left phead">Studio (<strong>1 Design Free</strong>)</td>
                                            <td class="desginprice"><b class="pr-sm">0.00</b></td>
                                        </tr>
                                        <tr class="total">
                                            <td  style="border:none;"  class="text-left">&nbsp;</td>
                                            <td  style="border:none;">	<div class="price" id="price_<?=$rec->ProductID?>">&nbsp;</div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right">
                                                <div class="priceText" id="priceText_<?=$rec->ProductID?>">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="clear10"></div>
                                </div>



                                <button id="add_btn<?=$rec->ProductID?>" onclick="add_item('<?=$rec->ProductID?>','<?=$rec->ManufactureID?>');"
                                        class="btn orangeBg" style="display:none;" type="button"> Add to basket  <i class="fa fa-calculator"></i> </button>

                                <button id="cal_btn<?=$rec->ProductID?>" onclick="calculate_sheet_price('<?=$rec->ProductID?>','<?=$rec->ManufactureID?>');"
                                        class="btn orangeBg" type="button"> Calculate Price <i class="fa fa-calculator"></i> </button>


                                <a id="add_sample_btn<?=$rec->ProductID?>" style="display:none;" data-pid="<?=$rec->ProductID?>"
                                   data-mid="<?=$rec->ManufactureID?>" class="btn btn-sm orangeBg rsample" type="button">MATERIAL SAMPLE ONLY </a>

                                <div class="clear10"></div>


                                <a href="#" id="<?=$rec->ManufactureID?>" data-labels="<?=$rec->LabelsPerSheet?>" class="price_breaks"
                                   data-target=".pbreaks"  data-toggle="modal" data-original-title="Volume Price Breaks">View volume price breaks</a>


                            </div>


                        </div>

                    <? } ?>

                </div>





            </div>
        </div>
    </div>

<?  }   ?>
