<?php
class Filter extends CI_Controller{
	function __construct()
	{	
		parent::__construct();
		$this->home_model->user_login_ajax();
	}
	
	function labelsfinderfields(){

	    if ($_POST) {
            $shape=$printer_option =$height_list=$adhesive_option=$material_option=$finish_option= $color = $finish = $material = $adhesive = $printer = $width = $height =$shape_option=$color_option='';
            $min_width = 0;
            $max_width = 0;
            $min_height = 0;
            $max_height = 0;
            $adhesive_select = '';
            $width_option = '';
            $height_option = '';
			$printer_width = '';
			$printer_desc = '';
			$model= '';
			$orderby = '';
			$labelperdie = '';
			
			$data['nearest_sizes'] = $this->input->post('nearest_sizes');
			$material_code = $this->input->post('material_code');
			$category = $this->input->post('category');
            $shape_sel = $this->input->post('shape');
			$home_request = $this->input->post('home_request');
			$pageName = $this->input->post('pageName');

			
		   
		    $color_sel = $this->input->post('color');
            $finish_sel = $this->input->post('finish');
            $material_sel = $this->input->post('material');
            $adhesive_sel = $this->input->post('adhesive');
            $printer_sel = $this->input->post('printer');
			
			$width_sel = $this->input->post('width');
            $height_sel = $this->input->post('height');
            $page = $this->input->post('page');
			$trigger = $this->input->post('trigger');
			$cornerradius = $this->input->post('cornerradius');
			$printer_width = $this->input->post('printer_width');
			$brands = $this->input->post('brands');
			$opposite = $this->input->post('opposite');
			// new code
			$div_open = $this->input->post('div_open');
			$condtion = '';
			$brands_list = '';
			$view = '';
			$opposite_width = '';
			$opposite_height = '';
			$search_code = $this->input->post('code');
			$label_per_sheet_selected = $this->input->post('label_per_sheet_selected');
			
			if($category=='thermal'){
				$category = 'Roll';
				if(isset($trigger) and $trigger=='model'){
					$model = $this->input->post('model');
					$query = $this->db->query("SELECT * FROM `printers_model` WHERE model LIKE '" .  urldecode($model) . "' ");
					$row = $query->row_array();
           			$printer_width = ($row['PrintWidth'])?$row['PrintWidth']:'';
           			$data['printer_model'] = $row;
           			$printer_desc = $this->load->view('order_quotation/model_desc', $data, true);
				}
				if(isset($printer_width) and $printer_width!=''){
					$condtion = " p.pwidth <= $printer_width AND ";
				}
			}
			
			if($category=='Integrated'){
				if($trigger=='category' || $trigger=='autoload'){
					$listbrands = $this->home_model->integrated_comaptible_list();
					$brands_list = $this->home_model->make_html_option($listbrands, 'name', ' Select Brand', $brands);
				}
				
				if(isset($brands) and $brands!=''){
					$brandq = "select SubCategoryID from category where CategoryName LIKE '%".$brands."%' LIMIT 1";
					$brandq =  $this->db->query($brandq);
					$brow = $brandq->row_array();
					if(isset($brow['SubCategoryID']) and $brow['SubCategoryID']!=''){
						$releted_arr = explode(",",$brow['SubCategoryID']);
						$rel_prd_string = "'".implode("','",$releted_arr)."'";
						$condtion .= " p.CategoryID IN (".$rel_prd_string.") AND ";
					}
				}
			}

			$brand = $this->home_model->make_productBrand_condtion($category);


			$condtion .= " p.Shape != '' AND p.ProductBrand LIKE '" . $brand . "' ";
			
			
		
			if(isset($material_code) and $material_code!=''){
				$condtion .= " AND p.ManufactureID LIKE '%" . $material_code . "%' ";	
			}
			
			if($page=='designer'){
				$condtion .= " AND p.activeFlash = 'Y' ";	
			}
			
			if(isset($cornerradius) and $cornerradius=='sharp'){ 			 //0 radius
				$condtion .= " AND (p.Corners LIKE 'No' )";	
			}
			
			if(isset($cornerradius) and $cornerradius=='rounded'){ 			 // greater than 0 radius
				$condtion .= " AND (p.Corners LIKE 'Yes')";	
			}

            $option_text = 'Label Shape';
            if ($category == 'Integrated') {
                $option_text = 'Label Bullet';
            }

            if (isset($shape_sel) and strlen($shape_sel) > 0) {
           		$shape = " AND p.Shape LIKE '" . $shape_sel . "' ";
            }

            if (isset($color_sel) and strlen($color_sel) > 0) {
            	$color = " AND p.LabelColor_upd LIKE '%" . $color_sel . "%' ";
            }

            if (isset($finish_sel) and strlen($finish_sel) > 0) {
            	$finish = " AND p.LabelFinish_upd LIKE '" . $finish_sel . "' ";
            }

            if (isset($material_sel) and strlen($material_sel) > 0) {
                $material = " AND p.ColourMaterial_upd LIKE '" . $material_sel . "' ";
            }

            if (isset($adhesive_sel) and strlen($adhesive_sel) > 0) {
                $adhesive = " AND p.Adhesive LIKE '" . $adhesive_sel . "' ";
            }

            if (isset($printer_sel) and strlen($printer_sel) > 0) {
                $printer = " AND p.SpecText7 LIKE '" . $printer_sel . "' ";
            }

            if (isset($width_sel) and strlen($width_sel) > 0) {
                
				$width = " AND p.pwidth LIKE '" . $width_sel . "' ";
				if(fmod($width_sel, 1) !== 0.00 and $page!='index'){
					$width = " AND CEIL(p.pwidth) <= " . ceil($width_sel). " ";
					$width .= " AND FLOOR(p.pwidth) >= ".floor($width_sel);
				}
            }
			
            if (isset($height_sel) and strlen($height_sel) > 0) {
                $height = " AND p.pheight LIKE '" . $height_sel . "' ";
				if(fmod($height_sel, 1) !== 0.00 and $page!='index'){
					$height = " AND CEIL(p.pwidth) <= " . ceil($height_sel). " ";
					$height .= " AND FLOOR(p.pwidth) >= ".floor($height_sel);
				}
            }
            
            if($page == 'finder' || $page == 'designer') {

                $o_height_min = $height_min = $this->input->post('height_min');
                $o_height_max = $height_max = $this->input->post('height_max');

                $o_width_min = $width_min = $this->input->post('width_min');
                $o_width_max = $width_max = $this->input->post('width_max');
				
				if (isset($width_min) and $width_min != '' and $width_min > 0) {
                   		
					if(isset($opposite) and $opposite=='true'){
						 $opposite_height = " AND FLOOR(p.pheight) >= ".floor($width_min);
					}
					$width = " AND FLOOR(p.pwidth) >= ".floor($width_min);
				
				}
                if (isset($width_max) and $width_max != '' and $width_max > 0) {
                   
				 	    $width .= " AND CEIL(p.pwidth) <= " . ceil($width_max). " ";
					    if(isset($opposite) and $opposite=='true'){
							 $opposite_height .= " AND FLOOR(p.pheight) <= ".ceil($width_max);
						}
						
						
				}

                if ($shape_sel != 'Circular' and $shape_sel != 'Square') {

                     if (isset($height_min) and $height_min != '' and $height_min > 0) {
                   
				   	    $height = " AND FLOOR(p.pheight) >= " . floor($height_min). " ";
						if(isset($opposite) and $opposite=='true'){
								$opposite_width = " AND  CEIL(p.pwidth) >= " . floor($height_min);
						}
					}
                     if (isset($height_max) and $height_max != '' and $height_max > 0) {
                    	
							$height .= " AND CEIL(p.pheight) <= " . ceil($height_max);
							if(isset($opposite) and $opposite=='true'){
									$opposite_width .= " AND  CEIL(p.pwidth) <= " . ceil($height_max);
							}
				    }
                   $heightcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $width;
                    if (isset($trigger) and $trigger == 'autoload') {
                        $heightcondtion = $heightcondtion . $height;
                    }
					if($trigger == "shape" || $trigger == "category" ||  $trigger == "model" ||  $trigger == "autoload" || $home_request == "enable")
					{
						if($home_request == "enable"){
							$heightcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer;
						}
						$height_range = $this->filter_model->get_min_width_height('p.pheight', $heightcondtion);
						$min_height = $height_range['min'];
						$max_height = $height_range['max'];
					}
                }
                $widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $height;
                if (isset($trigger) and $trigger == 'autoload') {
                    $widthcondtion = $widthcondtion . $width;
                }
				if($trigger == "shape" || $trigger == "category" ||  $trigger == "model" || $trigger == "autoload" || $home_request == "enable")
				{
					if($home_request == "enable"){
						$widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer;
					}
					
					$width_range = $this->filter_model->get_min_width_height('p.pwidth', $widthcondtion);
					$min_width = $width_range['min'];
					$max_width = $width_range['max'];
				}
            }

            else{
                if ($shape_sel == 'Circular' || $shape_sel == 'Square') {
                    if ($shape_sel == 'Circular') {
                        $option_text = 'Label Diameter';
                    } else {
                        $option_text = 'Label Width';
                    }
                    $Widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $height;
                    $width_list = $this->filter_model->labelsfinder_field_list('p.pwidth', $Widthcondtion);
                    $width_option = $this->home_model->make_size_option($width_list, 'pwidth', $option_text, $width_sel);
                    $height_option = '';
                } else {

                    $Widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $height;
                    $width_list = $this->filter_model->labelsfinder_field_list('p.pwidth', $Widthcondtion);
					
                    $width_option = $this->home_model->make_size_option($width_list, 'pwidth', 'Width mm', $width_sel);
			   
			        $heightcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $width;
			        $height_list = $this->filter_model->labelsfinder_field_list('p.pheight', $heightcondtion);
            		//echo "<pre>";
					//print_r($height_list);
					//echo "</pre>";
					$height_option = $this->home_model->make_size_option($height_list, 'pheight', 'Height mm', $height_sel);
					
                }


                $adhesive_condtion = $condtion . $shape . $color . $material . $finish . $printer . $height . $width;

                $adhesive_list = $this->filter_model->labelsfinder_field_list('p.Adhesive', $adhesive_condtion);

                $adhesive_option = $this->home_model->make_html_option($adhesive_list, 'Adhesive', ' Adhesive', $adhesive_sel);
            }

            $width_height = $height . $width;
			if(isset($opposite) and $opposite=='true'){
				   if($opposite_width!='' and $opposite_height!=''){
				  	   $width_height =   ' AND ( ( 1 = 1 '.$width. $height .' ) OR  ( 1 = 1 '.$opposite_width . $opposite_height.' ) ) '; 
				   }
				  
			}

			if(($trigger == "width" || $trigger == "height" || $trigger == "shape") and $page != "designer" and $page != "index"){
				$adhesive_list = $color_list = $finish_list = $material_list = $printer_list = '';
			}
			else
			{

				
				$active_flash = '';
				if($page=='designer'){
					$active_flash = " AND Label_Designer = 'y' ";	
				}
				
				$condtion = " p.ProductBrand LIKE '" . $brand . "' ";
				
				
				
			
			
				
				
				$adhesive_condtion = $condtion . $color . $material . $finish . $printer.$active_flash;

				$adhesive_list = $this->filter_model->newlabel_filter('p.Adhesive', $adhesive_condtion);
					
				
				$color_condtion = $condtion . $finish . $material . $adhesive . $printer.$active_flash;
				//print_r($color_condtion);exit;
				$color_list = $this->filter_model->newlabel_filter('p.LabelColor_upd', $color_condtion);
			   // $color_option = $this->home_model->make_html_option($color_list, 'LabelColor_upd', 'Label Colour', $color_sel);
	
	
				$finish_condtion = $condtion . $color . $material . $adhesive . $printer.$active_flash; 
				$finish_list = $this->filter_model->newlabel_filter('p.LabelFinish_upd', $finish_condtion);
				//$finish_option = $this->home_model->make_html_option($finish_list, 'LabelFinish_upd', 'Label Finish', $finish_sel);
	
				$material_condtion = $condtion . $color . $finish . $adhesive . $printer.$active_flash; 
				$material_list = $this->filter_model->newlabel_filter('p.ColourMaterial_upd', $material_condtion);
			   // $material_option = $this->home_model->make_html_option($material_list, 'ColourMaterial_upd', 'Label Material', $material_sel);
			   
				//$material_list = $finish_list = $color_list = $adhesive_list = array();
	
				$printer_condtion = $condtion . $color . $material . $adhesive . $finish.$active_flash;

				$printer_list = $this->filter_model->newlabel_filter('p.SpecText7', $printer_condtion);
               // print_r($printer_list);exit;
				$printer_option = $this->home_model->make_html_option($printer_list, 'SpecText7', ' Printer / Copier Type ', $printer_sel);
                //print_r($printer_option);exit;
				
				if(isset($material_code) and $material_code!=''){
					$condtion .= " AND p.ManufactureID LIKE '%" . $material_code . "%' ";	
				}
				
				
				
				
				$amendedcategory = $this->input->post('category');
				if(isset($amendedcategory) and $amendedcategory=='thermal'){
    				if(isset($printer_width) and $printer_width!=''){
    					$condtion .= " AND p.pwidth <= $printer_width ";
    				}
    			}
				
				
			}
			
			if($printer=='' and $color=='' and  $material =='' and $finish =='' and $adhesive=='' and $category != 'Integrated' and $page != "designer"){
				
			
				if($trigger == "LabelPerDie" and $category != "Integrated" and $category != "Roll")
				{
					if($label_per_sheet_selected != "")
					{
						$labelperdie = " AND c.LabelAcross*c.LabelAround = $label_per_sheet_selected";
					}
				}
			}
			else
			{
				if($label_per_sheet_selected != "")
				{
					$labelperdie = " AND p.LabelsPerSheet = $label_per_sheet_selected";
				}
			}
			
       		$final_condition = $condtion . $shape . $color . $material . $adhesive . $finish . $printer . $width_height. $labelperdie;
            //echo $final_condition;exit;

            $groupby = '';
            if ($category == 'Roll') {
                $groupby = " Group By LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ) ";
            }

           
			$theHTMLResponse = '';
			$labelpersheet_records = '';
            
			if ($page == 'finder' || $page == 'designer') {
                 $wholesale = $this->input->post('wholesale');
				$data['wholesale'] = (isset($wholesale) and $wholesale=='enable')?'enable':'';

                if($page == 'designer'){
					   $limiter = ($div_open=='slide')?'75':'12';
					   if($trigger == "search" and $search_code != "")
					   {
						   $final_condition .= " AND p.ManufactureID LIKE '%$search_code%'";
					   }
					   $data['records'] = $this->filter_model->labelfinder_data($final_condition,'','',$groupby,$limiter,$div_open);
					   $data['labelpersheet_records'] = $this->filter_model->fetch_labelpersheet_data($final_condition, 'products');
						if($div_open=='slide'){
							  $template = $this->session->userdata('template');
						    if(isset($template) && $template!=""){
						        $data['select'] = $this->home_model->get_selected_template($template);
						      }	
						  $theHTMLResponse = $this->load->view('labeldesigner/slider_category_list', $data, true);
						}else{
						
                   	 	  $theHTMLResponse = $this->load->view('labeldesigner/category_list', $data, true);
						}
						$count = $this->filter_model->labelfinder_counter($final_condition, $groupby,$div_open);
						$view =  'product';
				}
				else if($printer=='' and $color=='' and  $material =='' and $finish =='' and $adhesive=='' and $category != 'Integrated'){
					
					 $limiter = ($div_open=='slide')?'75':'12';
					
						if($trigger == "search" and $search_code != "")
						{
							$final_condition .= " AND c.CategoryImage LIKE '%$search_code%'";
						}

						$data['records'] = $this->filter_model->fetch_dies_data($final_condition, '');
					    $data['labelpersheet_records'] = $this->filter_model->fetch_labelpersheet_data($final_condition, '');
					    $datadata = $data['records'];
						$data['pageName'] = $pageName;
                   	 	$theHTMLResponse = $this->load->view('order_quotation/search_listing', $data, true);
                   		$count =  $data['records']['num_row'];
						$view =  'category';
					
						if($datadata['num_row'] == 0)
						{
							//echo "go to products table";exit;
							$final_condition = $condtion . $shape . $color . $material . $adhesive . $finish . $printer . $width_height . $labelperdie;
							$final_condition .= " AND p.ManufactureID LIKE '%$search_code%'";
							$data['results'] = $this->filter_model->labelfinder_data($final_condition,'','',$groupby,$limiter,$div_open);
					   		$data['labelpersheet_records'] = $this->filter_model->fetch_labelpersheet_data($final_condition, 'products');
					   		$theHTMLResponse = $this->load->view('order_quotation/product_listing', $data, true);
							$count = $this->filter_model->labelfinder_counter($final_condition, $groupby,$div_open);
							$view =  'category';
						}
				}
				
						
				
				
				else{
					//$limiter = ($div_open=='slide')?'75':'12';
						//echo $final_condition;die();
						$data['results'] = $this->filter_model->labelfinder_data($final_condition, '', '', $groupby);
					    $data['labelpersheet_records'] = $this->filter_model->fetch_labelpersheet_data($final_condition, 'products');
						$count = $this->filter_model->labelfinder_counter($final_condition, $groupby,$div_open);
						$theHTMLResponse = $this->load->view('order_quotation/product_listing', $data, true);
						$view =  'product';
                }
			    if ($count == 0) {
                    $theHTMLResponse = '<div class="row"><div class="thumbnail notfound_div text-center">';
                    $theHTMLResponse .='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                    $theHTMLResponse .='<h3 style="text-align:center;">Sorry, the label size you are looking is not available, Please click the below button to see the Nearest Sizes.</h3>';
					$theHTMLResponse .='<a href="javascript:void(0)" class="show_nearest_sizes btn orangeBg"><i class="fa fa-eye"></i> See the Nearest Sizes</a></div>';
                    $theHTMLResponse .='</div></div>';
                }
            }
            else{
					$count = $this->filter_model->labelfinder_counter($final_condition, $groupby,$div_open);
			}
			
			if($category == "Roll" || $category == "Integrated")
			{
				$labelpersheet_records = "";
			}
			else
			{
				//echo"<pre>";print_r($data['labelpersheet_records']);echo"</pre>";exit;
				$data['labelpersheet_records']['label_per_sheet_selected'] = $label_per_sheet_selected;
				$labelpersheet_records = $this->load->view('order_quotation/labelpersheet_records', $data['labelpersheet_records'], true);	
			}
			

			$json_data = array('response' => 'yes',
				'brands_list'=>$brands_list,
				'width' => $width_option,
                'height' => $height_option,
                'shapes' => $shape_option,
                'color' => $color_option,
                'finish' => $finish_option,
                'material' => $material_option,
                'adhesive' => $adhesive_option,
                'adhesive_selected' => $adhesive_select,
                'printer' => $printer_option,
                'count' => $count,
                'min_width' => floor($min_width),
                'max_width' => ceil($max_width),
                'min_height' => floor($min_height),
                'max_height' => ceil($max_height),
				'view' => $view,
				'printer_width'=>$printer_width,
				'printer_desc'=>$printer_desc,
			    'count_format' => number_format($count, 0),
				'material_list'=>$material_list,
			    'finish_list'=>$finish_list,
			    'color_list'=>$color_list,
				'height_list'=>$height_list,
			    'adhesive_list'=>$adhesive_list,
				'html' => $theHTMLResponse,
			    'labelpersheet_records' => $labelpersheet_records);

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }
    } 
   
	/*function loadmore_finder_products(){

        if ($_POST) {

            $shape = $color = $finish = $material = $adhesive = $printer = $width = $height = '';
            $start = '';
            $min_width = 0;
            $max_width = 0;
            $min_height = 0;
            $max_height = 0;
            $adhesive_select = '';
            
            $material_code = $this->input->post('material_code');

            $category = $this->input->post('category');
            $shape_sel = $this->input->post('shape');
            $color_sel = $this->input->post('color');
            $finish_sel = $this->input->post('finish');
            $material_sel = $this->input->post('material');
            $adhesive_sel = $this->input->post('adhesive');
            $printer_sel = $this->input->post('printer');

            $width_sel = $this->input->post('width');
            $height_sel = $this->input->post('height');
            $height_sel = $this->input->post('height');

            $start = $this->input->post('start');
            $page = $this->input->post('page');
            $cornerradius = $this->input->post('cornerradius');
			$printer_width = $this->input->post('printer_width');
	  		$opposite = $this->input->post('opposite');	
			$div_open = $this->input->post('div_open');
            $groupby = '';
			$condtion = '';
			$opposite_width = '';
			$opposite_height = '';
			
			$search_code = $this->input->post('code');
			
			if($category=='thermal'){
				$category = 'Roll';
				if(isset($printer_width) and $printer_width!=''){
					$condtion = " p.pwidth <= $printer_width AND ";
				}
			}	
			
			
            $brand = $this->home_model->make_productBrand_condtion($category);
            if ($category == 'Roll') {
                $groupby = " Group By LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ) ";
            }

            $condtion .= " p.ProductBrand LIKE '" . $brand . "' ";

            if(isset($material_code) and $material_code!=''){
					$condtion .= " AND p.ManufactureID LIKE '%" . $material_code . "%' ";	
			}

		   if($page=='designer'){
				$condtion .= "  AND p.activeFlash = 'Y' ";	
			}
			
			
			
           if(isset($cornerradius) and $cornerradius=='sharp'){ 			 //0 radius
				    $condtion .= " AND (p.Corners LIKE 'No' )";	
			}
			
			if(isset($cornerradius) and $cornerradius=='rounded'){ 			 // greater than 0 radius
				    $condtion .= " AND (p.Corners LIKE 'Yes')";	
			}
			
			

            if (isset($shape_sel) and strlen($shape_sel) > 0) {
                $shape = " AND p.shape LIKE '" . $shape_sel . "' ";
            }

            if (isset($color_sel) and strlen($color_sel) > 0) {
                $color = " AND p.LabelColor_upd LIKE '" . $color_sel . "' ";
            }

            if (isset($finish_sel) and strlen($finish_sel) > 0) {
                $finish = " AND p.LabelFinish_upd LIKE '" . $finish_sel . "' ";
            }

            if (isset($material_sel) and strlen($material_sel) > 0) {
                $material = " AND p.ColourMaterial_upd LIKE '" . $material_sel . "' ";
            }

            if (isset($adhesive_sel) and strlen($adhesive_sel) > 0) {
                $adhesive = " AND p.Adhesive LIKE '" . $adhesive_sel . "' ";
            }

            if (isset($printer_sel) and strlen($printer_sel) > 0) {
                $printer = " AND p.SpecText7 LIKE '" . $printer_sel . "' ";
            }


           if ($page == 'finder' || $page == 'designer') {

                $height_min = $this->input->post('height_min');
                $height_max = $this->input->post('height_max');

                $width_min = $this->input->post('width_min');
                $width_max = $this->input->post('width_max');

 				if (isset($width_min) and $width_min != '' and $width_min > 0) {
                   		
						if(isset($opposite) and $opposite=='true'){
							 $opposite_height = " AND FLOOR(p.pheight) >= ".floor($width_min);
						}
						$width = " AND FLOOR(p.pwidth) >= ".floor($width_min);
						
						
				
				}
                if (isset($width_max) and $width_max != '' and $width_max > 0) {
                   
				 	    $width .= " AND CEIL(p.pwidth) <= " . ceil($width_max). " ";
					    if(isset($opposite) and $opposite=='true'){
							 $opposite_height .= " AND FLOOR(p.pheight) <= ".ceil($width_max);
						}
						
						
				}
				
				if ($shape_sel != 'Circular' and $shape_sel != 'Square') {
					 if (isset($height_min) and $height_min != '' and $height_min > 0) {
                   
				   	    $height = " AND FLOOR(p.pheight) >= " . floor($height_min). " ";
						if(isset($opposite) and $opposite=='true'){
								$opposite_width = " AND  CEIL(p.pwidth) >= " . floor($height_min);
						}
					}
                    if (isset($height_max) and $height_max != '' and $height_max > 0) {
                    	
							$height .= " AND CEIL(p.pheight) <= " . ceil($height_max);
							if(isset($opposite) and $opposite=='true'){
									$opposite_width .= " AND  CEIL(p.pwidth) <= " . ceil($height_max);
							}
				    }
					
					
				}
						
  
          }

            $width_height = $height . $width;
			
			if(isset($opposite) and $opposite=='true'){
				   if($opposite_width!='' and $opposite_height!=''){
				  	   $width_height =   ' AND ( ( 1 = 1 '.$width. $height .' ) OR  ( 1 = 1 '.$opposite_width . $opposite_height.' ) ) '; 
				   }
				  
			}
		    $final_condition = $condtion . $shape . $color . $material . $adhesive . $finish . $printer . $width_height;
			if($search_code != "")
			{
			   $final_condition .= " AND p.ManufactureID LIKE '%$search_code%' ";
			}
			 $data['results'] = $this->filter_model->labelfinder_data($final_condition, '', $start, $groupby,'',$div_open);
            
            
			$wholesale = $this->input->post('wholesale');
			$data['wholesale'] = (isset($wholesale) and $wholesale=='enable')?'enable':'';
				
			 if($page == 'designer'){
			        $data['records'] = $data['results'];
					$theHTMLResponse = $this->load->view('labeldesigner/category_list', $data, true);
			 }else{
			    	$theHTMLResponse = $this->load->view('order_quotation/product_listing', $data, true);
			 }
			 

            $json_data = array('response' => 'yes', 'html' => $theHTMLResponse);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }
    }*/
	
	
		function loadmore_finder_products(){

        if ($_POST) {

            $shape = $color = $finish = $material = $adhesive = $printer = $width = $height = '';
            $start = '';
            $min_width = 0;
            $max_width = 0;
            $min_height = 0;
            $max_height = 0;
            $adhesive_select = '';
            
            $material_code = $this->input->post('material_code');

            $category = $this->input->post('category');
            $shape_sel = $this->input->post('shape');
            $color_sel = $this->input->post('color');
            $finish_sel = $this->input->post('finish');
            $material_sel = $this->input->post('material');
            $adhesive_sel = $this->input->post('adhesive');
            $printer_sel = $this->input->post('printer');

            $width_sel = $this->input->post('width');
            $height_sel = $this->input->post('height');
            $height_sel = $this->input->post('height');

            $start = $this->input->post('start');
            $page = $this->input->post('page');
            $cornerradius = $this->input->post('cornerradius');
			$printer_width = $this->input->post('printer_width');
	  		$opposite = $this->input->post('opposite');	
			$div_open = $this->input->post('div_open');
            $groupby = '';
			$condtion = '';
			$opposite_width = '';
			$opposite_height = '';
			
			$search_code = $this->input->post('code');
			$label_per_sheet_selected = $this->input->post('label_per_sheet_selected');
			
			if($category=='thermal'){
				$category = 'Roll';
				if(isset($printer_width) and $printer_width!=''){
					$condtion = " p.pwidth <= $printer_width AND ";
				}
			}	
			
			
            $brand = $this->home_model->make_productBrand_condtion($category);
            if ($category == 'Roll') {
                $groupby = " Group By LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ) ";
            }

            $condtion .= " p.ProductBrand LIKE '" . $brand . "' ";

            if(isset($material_code) and $material_code!=''){
					$condtion .= " AND p.ManufactureID LIKE '%" . $material_code . "%' ";	
			}

		   if($page=='designer'){
				$condtion .= "  AND p.activeFlash = 'Y' ";	
			}
			
			
			
           if(isset($cornerradius) and $cornerradius=='sharp'){ 			 //0 radius
				    $condtion .= " AND (p.Corners LIKE 'No' )";	
			}
			
			if(isset($cornerradius) and $cornerradius=='rounded'){ 			 // greater than 0 radius
				    $condtion .= " AND (p.Corners LIKE 'Yes')";	
			}
			
			

            if (isset($shape_sel) and strlen($shape_sel) > 0) {
                $shape = " AND p.shape LIKE '" . $shape_sel . "' ";
            }

            if (isset($color_sel) and strlen($color_sel) > 0) {
                $color = " AND p.LabelColor_upd LIKE '" . $color_sel . "' ";
            }

            if (isset($finish_sel) and strlen($finish_sel) > 0) {
                $finish = " AND p.LabelFinish_upd LIKE '" . $finish_sel . "' ";
            }

            if (isset($material_sel) and strlen($material_sel) > 0) {
                $material = " AND p.ColourMaterial_upd LIKE '" . $material_sel . "' ";
            }

            if (isset($adhesive_sel) and strlen($adhesive_sel) > 0) {
                $adhesive = " AND p.Adhesive LIKE '" . $adhesive_sel . "' ";
            }

            if (isset($printer_sel) and strlen($printer_sel) > 0) {
                $printer = " AND p.SpecText7 LIKE '" . $printer_sel . "' ";
            }


           if ($page == 'finder' || $page == 'designer') {

                $height_min = $this->input->post('height_min');
                $height_max = $this->input->post('height_max');

                $width_min = $this->input->post('width_min');
                $width_max = $this->input->post('width_max');

 				if (isset($width_min) and $width_min != '' and $width_min > 0) {
                   		
						if(isset($opposite) and $opposite=='true'){
							 $opposite_height = " AND FLOOR(p.pheight) >= ".floor($width_min);
						}
						$width = " AND FLOOR(p.pwidth) >= ".floor($width_min);
						
						
				
				}
                if (isset($width_max) and $width_max != '' and $width_max > 0) {
                   
				 	    $width .= " AND CEIL(p.pwidth) <= " . ceil($width_max). " ";
					    if(isset($opposite) and $opposite=='true'){
							 $opposite_height .= " AND FLOOR(p.pheight) <= ".ceil($width_max);
						}
						
						
				}
				
				if ($shape_sel != 'Circular' and $shape_sel != 'Square') {
					 if (isset($height_min) and $height_min != '' and $height_min > 0) {
                   
				   	    $height = " AND FLOOR(p.pheight) >= " . floor($height_min). " ";
						if(isset($opposite) and $opposite=='true'){
								$opposite_width = " AND  CEIL(p.pwidth) >= " . floor($height_min);
						}
					}
                    if (isset($height_max) and $height_max != '' and $height_max > 0) {
                    	
							$height .= " AND CEIL(p.pheight) <= " . ceil($height_max);
							if(isset($opposite) and $opposite=='true'){
									$opposite_width .= " AND  CEIL(p.pwidth) <= " . ceil($height_max);
							}
				    }
					
					
				}
						
  
          }

            $width_height = $height . $width;
			
			if(isset($opposite) and $opposite=='true'){
				   if($opposite_width!='' and $opposite_height!=''){
				  	   $width_height =   ' AND ( ( 1 = 1 '.$width. $height .' ) OR  ( 1 = 1 '.$opposite_width . $opposite_height.' ) ) '; 
				   }
			}
			
			$labelperdie = "";
			
			if($color_sel == '' and $material_sel == '')
			{
				if($label_per_sheet_selected != "")
				{
					$labelperdie = " AND c.LabelAcross*c.LabelAround = $label_per_sheet_selected";
				}
			}
			else
			{
				if($label_per_sheet_selected != "")
				{
					$labelperdie = " AND p.LabelsPerSheet = $label_per_sheet_selected";
				}
			}
		    $final_condition = $condtion . $shape . $color . $material . $adhesive . $finish . $printer . $width_height . $labelperdie;
			if($search_code != "")
			{
			   $final_condition .= " AND p.ManufactureID LIKE '%$search_code%' ";
			}
			 $data['results'] = $this->filter_model->labelfinder_data($final_condition, '', $start, $groupby,'',$div_open);
            
            
			$wholesale = $this->input->post('wholesale');
			$data['wholesale'] = (isset($wholesale) and $wholesale=='enable')?'enable':'';
				
			 if($page == 'designer'){
			        $data['records'] = $data['results'];
					$theHTMLResponse = $this->load->view('labeldesigner/category_list', $data, true);
			 }else{
			    	$theHTMLResponse = $this->load->view('order_quotation/product_listing', $data, true);
			 }
			 

            $json_data = array('response' => 'yes', 'html' => $theHTMLResponse);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }
    }
	
	
	
	
	function fetch_all_shapes(){
		$shape_list =  $this->filter_model->generate_category_shapes('no');
		echo json_encode($shape_list); 
	}
	
	function comparison_popup()
	{ 
		$cats  = $this->input->post('cats');
		$type  = $this->input->post('type');
		
		$catdetails = array();
		foreach($cats as $catid)
		{
			$manuID = '';
			if(isset($type) and $type == 'product')
			{
				$manuID = $catid;
				$catid = $this->home_model->get_db_column('products','CategoryID','ManufactureID',$manuID);
				$ProductBrand = $this->home_model->get_db_column('products','ProductBrand','ManufactureID',$manuID);
				$SpecText7 = $this->home_model->get_db_column('products','SpecText7','ManufactureID',$manuID);
			}
			if(substr($catid,-2,1)=='R')
			{
				if(preg_match('/r1|r2|r3|r4|r5/is',$catid))
				{
					$new_code_exp=explode("R",$catid);
					$catid=$new_code_exp[0];
				}
				$Roll = $this->home_model->min_qty_roll($manuID);
				$price = $this->home_model->calclateprice($manuID,$Roll,100);
				$price = $price['final_price'];
				$data['min_labels'] = $Roll*100;
			}
			else
			{
				if(preg_match('/A4/',$ProductBrand))
				{
					$qty_count = 25;
				}
				else
				{
					$qty_count = 100;
				}
				$price = $this->product_model->ajax_price($qty_count,$manuID);
				$price = $price['custom_price'];
			}
			
			$details = $this->home_model->fetch_category_details($catid);
			$details['price'] = $price;
			$details['type'] = $type;
			if(isset($type) and $type == 'product')
			{
				$details['ManufactureID'] = $manuID;
				$details['SpecText7'] = $SpecText7;
			}
			$catdetails[] = $details;
		}
		$data['catdetails'] = $catdetails;
		//echo"<pre>";print_r($catdetails);echo"</pre>";exit;
		$theHTMLResponse = $this->load->view('category/compare_popup', $data, true);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('html'=> $theHTMLResponse)));
	}
  
	
	
	
}