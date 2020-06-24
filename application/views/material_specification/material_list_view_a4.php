<?    
		foreach($materials as $rec){
							
		if(preg_match("/Roll/",$rec->ProductBrand)){$type = 'Rolls';  $iconspath = 'Rolls'; }
		else{  $type = 'A4';  $iconspath = 'sheets';}
		
		$condition = " type LIKE '".$type."' AND finish_type LIKE '".$rec->LabelFinish."' AND material_type LIKE '".$rec->ColourMaterial."'";
		$colours = $this->home_model->grouping_material_colours($condition);
		$grouped_adhesive = $this->home_model->grouping_material_adhesive($condition);
		
		$cryogenic =$this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Cryogenic');
		$freezer =$this->home_model->search_adhesive_in_array($grouped_adhesive,   'Adhesive', 'Freezer');
		$heatrest =$this->home_model->search_adhesive_in_array($grouped_adhesive,  'Adhesive', 'Heat Resistant');
		$hightack =$this->home_model->search_adhesive_in_array($grouped_adhesive,  'Adhesive', 'High Tack');
		$permanent =$this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Permanent');
		$removable =$this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Peelable');
		$sealable =$this->home_model->search_adhesive_in_array($grouped_adhesive,  'Adhesive', 'Resealable');
		$superperm =$this->home_model->search_adhesive_in_array($grouped_adhesive, 'Adhesive', 'Super Permanent');	
		$waterres =$this->home_model->search_adhesive_in_array($grouped_adhesive,  'Adhesive', 'Water Resistant');
		
		$keys = array_keys($colours);
		$last = end($keys);
		if(isset($colours[$last]->LabelColor) and $colours[$last]->LabelColor != $rec->LabelColor and count($colours) > 1 and empty($productid)){
				$condition = " LabelFinish LIKE '".$rec->LabelFinish."' AND ColourMaterial LIKE '".$rec->ColourMaterial."' 
				AND LabelColor LIKE '".trim($colours[$last]->LabelColor)."' AND CategoryID LIKE '".$rec->CategoryID."' 
				AND Adhesive LIKE '".$rec->Adhesive."'";
				$result = $this->db->query("Select * from products where $condition LIMIT 1")->result();
				if(count($result) > 0){
					$rec = $result[0];
				}
		}
		if(preg_match("/Roll/",$rec->ProductBrand)){      
			$material_code = $this->home_model->getmaterialcode(substr($rec->ManufactureID,0,-1));
			$mat_image = Assets.'images/material_images/Roll/circular/'.$material_code.'.png';
			$compatibily_type = 'roll';
			$type_url = 'material-on-rolls';
		}
		else{ 
			$material_code = $this->home_model->getmaterialcode($rec->ManufactureID);
			$mat_image = Assets.'images/material_images/sheets/'.$material_code.'.png';
				$compatibily_type = 'sheet';
				$type_url = 'material-on-sheets';
		}
			$materialinfo = $this->db->query("Select * from material_tooltip_info WHERE material_code LIKE '".$material_code."'")->row_array();
			
			$desc = (isset($materialinfo['tooltip_info']) and $materialinfo['tooltip_info']!='')?$materialinfo['tooltip_info']:'';
			$rec->Material1 = (isset($materialinfo['short_name']) and $materialinfo['short_name']!='')?$materialinfo['short_name']:'';
			$group_name = (isset($materialinfo['group_name']) and $materialinfo['group_name']!='')?$materialinfo['group_name']:'';
						
			$max_length = 290;
			if (strlen($desc) > $max_length){
				 $offset = ($max_length - 3) - strlen($desc);
				 $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
				 $short_desc .= ' <a style="cursor:pointer;" data-toggle="tooltip-product" data-placement="top" data-original-title="'.$desc.'"><i>Read More</i></a>';
			}else{
				     $short_desc = $desc;
			}
			$promotion = '';
			
			$comp = $this->home_model->grouping_compatiblity($rec->SpecText7, $compatibily_type);
			
			$material_url = strtolower(str_replace(" ","-", trim($rec->Material1)));
			$url = base_url().$type_url.'/'.$material_url.'/products/';
			?>

<section data-mat-filters="<?=$rec->ColourMaterial?>" data-reset="reset" >
  <div class="row productdetails <?=($type=='Rolls')?'roll-products':''?>" data-value="<?=$rec->ProductID?>" 
        data-finish="<?=$rec->LabelFinish?>" data-material="<?=$rec->ColourMaterial?>" >
    <input type="hidden" value="<?=$rec->ProductID?>" class="product_id"  />
    <input type="hidden" value="<?=$rec->ManufactureID?>" class="manfactureid"  />
    <input type="hidden" value="<?=$material_code?>" class="material_code"  />
    <article class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mat-detail mat-tabs">
      <div class="pr-detail"> <span class="group_name">
        <?=$group_name?>
        </span><br>
      </div>
      <div class="clear"></div>
      <div class="row specs">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> <img class="img-responsive product_material_image" src="<?=$mat_image?>" alt="<?=$rec->Material1?>"> </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
          <div class="pr-detail"> <span class="product_name">
            <?=$rec->Material1?>
            </span> <font class="product_description">
            <?=$short_desc?>
            </font> </div>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 <?php if($type=="Rolls"){echo "m-t-10";}?>">
              <div class="clear10"></div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> <a href="#" id="<?=$rec->ProductID?>" class="technical_specs" data-target=".material" data-toggle="modal" data-original-title="Tecnial Specification"> Material Specification <i class="fa fa-info-circle"></i></a> </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> <a href="#" id="<?=$group_name?>" class="applications" data-target=".lb_applications" data-toggle="modal" data-original-title="Tecnial Specification"> Label Applications <i class="fa fa-table" aria-hidden="true"></i></a> </div>
              </div>
              <div class="row">
                <div class="clear5"></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <ul class="clr-thumbs colourpicker">
                    <? foreach($colours as $row){
						    $active_colour = '';
						    $colourclass = 	strtolower(str_replace(" ","_",$row->LabelColor));	
							$colourclass = 	strtolower(str_replace("-","_",$colourclass));
							if($row->LabelColor == $rec->LabelColor){
								$active_colour = 'active';
							}
							
							if(preg_match("/Roll/",$rec->ProductBrand)){
								$colour_icon = Assets.'images/material_images/colours/rolls/circular/'.$row->imagecode.'.png';
								  //if (getimagesize($colour_icon) == false) {
								 //	$colour_icon = Assets.'images/material_images/colours/rolls/white.png';
						     	//	}
							}
							else
							{
								$colour_icon = Assets.'images/material_images/colours/sheets/'.$row->imagecode.'.png';
								  //if (getimagesize($colour_icon) == false) {
								 //	$colour_icon = Assets.'images/material_images/sheets/white.png';
								//}
							}
							
						   ?>
                    <li class="<?=$active_colour?> data-reset-colour" data-toggle="tooltip" data-placement="bottom" 
                          data-original-title="<?=$row->colour_name?>" data-colour-filters="<?=$row->LabelColor?>"  > <a class="mat_<?=$colourclass?>" data-value="<?=$row->LabelColor?>" href="javascript:void(0);"> <img class="img-responsive" src="<?=$colour_icon?>" alt="<?=$row->colour_name?>"></a> </li>
                    <? } ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 m-t-10">
              <?php
				$laser_div = $thermal_div = $inkjet_div = $d_thermal_div = '';
				if(preg_match("/Roll/",$rec->ProductBrand))
				{
					$laser_div = 'display:none';
				}
				else
				{
					$thermal_div = $d_thermal_div = 'display:none';
				}
				?>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden-sm"> </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 labels-form">
                <?php
			  if(count($grouped_adhesive) == 1):?>
                <label class="select no-margin">
                  <select class="product_adhesive" >
                    <option value="" disabled="disabled" selected="selected">Select Adhesive </option>
                    <option <?=$cryogenic?> <?=($rec->Adhesive=='Cryogenic')?'selected="selected"':''?>  
                                     value="Cryogenic">Cryogenic</option>
                    <option <?=$freezer?>   <?=($rec->Adhesive=='Freezer')?'selected="selected"':''?>  
                                     value="Freezer">Freezer</option>
                    <option <?=$heatrest?> <?=($rec->Adhesive=='Heat Resistant')?'selected="selected"':''?>  
                                     value="Heat Resistant"> Heat Resistant</option>
                    <option <?=$hightack?> <?=($rec->Adhesive=='High Tack')?'selected="selected"':''?>  
                                     value="High Tack">High Tack</option>
                    <option <?=$permanent?> <?=($rec->Adhesive=='Permanent')?'selected="selected"':''?>  
                                     value="Permanent">Permanent</option>
                    <option <?=$removable?> <?=($rec->Adhesive=='Peelable')?'selected="selected"':''?>  
                                     value="Peelable">Peelable</option>
                    <option <?=$sealable?> <?=($rec->Adhesive=='Resealable')?'selected="selected"':''?>  
                                     value="Resealable">Re-sealable</option>
                    <option <?=$superperm?> <?=($rec->Adhesive=='Super Permanent')?'selected="selected"':''?>  
                                     value="Super Permanent">Super Permanent</option>
                    <option <?=$waterres?> <?=($rec->Adhesive=='Water Resistant')?'selected="selected"':''?>  
                                     value="Water Resistant">Water Resistant</option>
                  </select>
                  <i></i> </label>
                <?php else:?>
                <label class="select no-margin">
                  <input type="hidden" id="hidden_adhesive" value="<?=$rec->Adhesive?>" />
                  <select class="product_adhesive" >
                    <option value="" selected="selected">Select Adhesive </option>
                    <option <?=$cryogenic?> value="Cryogenic">Cryogenic</option>
                    <option <?=$freezer?> value="Freezer">Freezer</option>
                    <option <?=$heatrest?> value="Heat Resistant"> Heat Resistant</option>
                    <option <?=$hightack?> value="High Tack">High Tack</option>
                    <option <?=$permanent?> value="Permanent">Permanent</option>
                    <option <?=$removable?> value="Peelable">Peelable</option>
                    <option <?=$sealable?> value="Resealable">Re-sealable</option>
                    <option <?=$superperm?> value="Super Permanent">Super Permanent</option>
                    <option <?=$waterres?> value="Water Resistant">Water Resistant</option>
                  </select>
                  <i></i> </label>
                <?php endif;?>
                <a href="<?=$url?>" class="btn btn-block orangeBg pull-right product-url" >Select Label Shape &amp; Size <i class="fa fa-arrow-circle-right"></i></a> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="row">
        <div class="col-md-5" style="margin-top:5px;">
          <?php
				$laser_div = $thermal_div = $inkjet_div = $d_thermal_div = '';
				if(preg_match("/Roll/",$rec->ProductBrand))
				{
					$laser_div = 'display:none';
				}
				else
				{
					$thermal_div = $d_thermal_div = 'display:none';
				}
				?>
          <table class="table printer" border="0" style="border:none;">
            <tbody>
              <tr>
                <td align="left" valign="center" style="font-size:12px; border:none;vertical-align: middle;width:25%;"><small style="margin-top:10px;font-size:12px;">Printer<br />
                  Compatibility</small></td>
                <td  align="left" style="font-size:9px; border:none; width:25%;<?=$laser_div?>"> Laser <a data-toggle="tooltip-product" data-placement="top" class="laser_printer_div" title="" data-original-title="<?=$comp['laser_text']?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a><br />
                  <img class="laser_printer_img" width="50" src="<?=Assets?>images/<?=$comp['laser_img']?>"  /></td>
                <td  align="left" style=" font-size:9px;border:none;width:25%;<?=$inkjet_div?>"> Inkjet <a data-toggle="tooltip-product" data-placement="top" title="" class="inkjet_printer_div" data-original-title="<?=$comp['inkjet_text']?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a><br />
                  <img class="inkjet_printer_img" width="50" src="<?=Assets?>images/<?=$comp['inkjet_img']?>"  /></td>
                <?php if(preg_match("/Roll/",$rec->ProductBrand)):?>
                <td align="left" style=" font-size:9px;border:none;width:25%;<?=$d_thermal_div?>"> Direct<br />
                  Thermal <a data-toggle="tooltip-product" data-placement="top" title="" class="direct_printer_div"  data-original-title="<?=$comp['d_thermal_text']?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a><br />
                  <img class="direct_printer_img" width="50" src="<?=Assets?>images/<?=$comp['d_thermal_img']?>"  /></td>
                <td align="left" style=" font-size:9px;border:none;width:25%; <?=$thermal_div?>"> Thermal<br />
                  Transfer <a data-toggle="tooltip-product" data-placement="top" title="" class="thermal_printer_div" data-original-title="<?=$comp['thermal_text']?>" href="javascript:void(0);"><i class="fa fa-info-circle"></i></a><br />
                  <img class="thermal_printer_img" width="50" src="<?=Assets?>images/<?=$comp['thermal_img']?>"  /></td>
                <?php else:?>
                <td align="left" style=" font-size:12px;border:none;width:25%;"></td>
                <td align="left" style=" font-size:12px;border:none;width:25%;"></td>
                <?php endif?>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-7 m-t-b-8">
          <div class="col-xs-12 ofq">
            <div class="col-xs-4 main-box">
              <div class="row">
                <div class="col-xs-2 no-padding-right ofq-icon"><img src="<?=Assets?>images/4oclock.png" /></div>
                <div class="col-xs-10  no-padding-right ofq-text material_clock">
                  <div class="counter clock_time">Order before 16:00 for Next Day Delivery</div>
                  <div class="clear"></div>
                  <small style="font-size:8px;">Time remaining to next day delivery</small> </div>
              </div>
            </div>
            <div class="col-xs-4 main-box">
              <div class="row">
                <div class="col-xs-2 no-padding-right ofq-icon"><i class="fa fa-truck l-icon" aria-hidden="true"></i></div>
                <div class="col-xs-10  no-padding-right ofq-text"> <b>Free Delivery on Orders over
                  <?=symbol.$this->home_model->currecy_converter(25.00, 'no');?>
                  </b> <a style="font-size:7px;" target="_blank" href="<?=base_url()?>delivery/"><span class="glyphicon glyphicon-new-window"></span> Delivery & Shipping Options</a> </div>
              </div>
            </div>
            <div class="col-xs-4 main-box">
              <div class="row">
                <div class="col-xs-2 no-padding-right ofq-icon"><i class="fa fa-check-square-o l-icon" aria-hidden="true"></i></div>
                <div class="col-xs-10  no-padding-right ofq-text"><b>QUALITY ASSURANCE GUARANTEE</b></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<? } ?>
