<?php
class Ajax extends CI_Controller{
	function __construct()
	{	
		parent::__construct();
	    $this->home_model->user_login_ajax();
        $this->load->model('order_quotation/orderModal');

	}

    function missdata(){
           $result = $this->db->query(" SELECT * FROM `orderdetails` WHERE `Printing` LIKE 'Y' AND `Print_Type` = '' ")->result();
           $orderstring = '';
		   foreach($result as $row){
				$designprice = 0.00;
				$printprice = $this->home_model->calculate_printed_sheets($row->Quantity, 'Fullcolour', $row->Print_Qty,'A4 Label',$row->ManufactureID);
				$designprice = $printprice['desginprice'];
				$printprice = $printprice['price'];
				/*if(preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
					$printprice = $printprice*1.5;
				}*/
				$newprice = $printprice+$designprice;
				
				
				 //$row->Print_Total = number_format($row->Print_Total/0.94,2,'.','');
				 
				 if(round($row->Print_Total) == round($newprice)){
				  echo "<br>".$row->OrderNumber." Manufacture ID: ".$row->ManufactureID.'  -- Old Price: '.round($row->Print_Total).' - New Price = '.round($newprice);
				    
				  $orderstring .= $row->SerialNumber.',';
				 }
				
				
			}
			
		   echo "<br>".$orderstring;
    }

	function artworklink($ordernumber){
	   echo 'https://aalabels.com/artwork-approval/'.md5(strtoupper($ordernumber));
	}
	function rollimages($diecode=NULL){
		if($diecode!=NULL){
			
			$qry = "SELECT ManufactureID from products p , category  c where SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID 
					AND (p.Activate ='Y' or p.Activate ='y') AND c.CategoryID LIKE '".$diecode."'";
					$query  = $this->db->query($qry);
					$result = $query->result();
			
			$i=0;
			echo "Missing Codes Are: ";
			echo "<br>";
			foreach($result as $row){
					$i++;
					$img_src = ARTPATH."images/categoryimages/RollLabels/outside/".strtoupper($row->ManufactureID).".jpg";
					if(!getimagesize($img_src)) {
						echo "<br> $i - OUTSIDE - ".$row->ManufactureID;
					}
					$img_src = ARTPATH."images/categoryimages/RollLabels/inside/".strtoupper($row->ManufactureID).".jpg";
					if(!getimagesize($img_src)) {
						echo "<br> $i - INSIDE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  - ".$row->ManufactureID;
					}
			}		
		}
	}
	function sheetimages($diecode=NULL){
		if($diecode!=NULL){
			
			$qry = "SELECT ManufactureID,ProductBrand from products p , category  c where p.CategoryID = c.CategoryID AND (p.Activate ='Y' or p.Activate ='y') AND c.CategoryID LIKE '".$diecode."'";
			//echo $qry;exit;
			$query  = $this->db->query($qry);
			$result = $query->result();
			
			$i=0;
			echo "Missing Codes Are: ";
			echo "<br>";
			foreach($result as $row){
				if(preg_match('/^A4/',$row->ProductBrand))
				{
					$path = "A4Sheets";
				}
				else if(preg_match('/^A3/',$row->ProductBrand))
				{
					$path = "A3Sheets";
				}
				else if(preg_match('/^SRA3/',$row->ProductBrand))
				{
					$path = "SRA3Sheets";
				}
				$i++;
				$img_src = ARTPATH."images/categoryimages/".$path."/colours/".strtoupper($row->ManufactureID).".png";
				if(!getimagesize($img_src)) {
					echo "<br> $i - ".$row->ManufactureID;
				}
			}		
		}
	}
	
	
	function test_xml(){
	    
	    $dom = new DOMDocument;
		//$dom->preserveWhiteSpace = FALSE;
		$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset 
    	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    	xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
    	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
    	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <url>
                <loc>http://www.codexworld.com</loc>
                <lastmod>2016-07-04T07:46:18+00:00</lastmod>
                <changefreq>always</changefreq>
                <priority>1.00</priority>
            </url>
        </urlset>';
		$dom->loadXML($xmlString);
		if($dom->save($_SERVER['DOCUMENT_ROOT'].'/designer/media11/xml_design_files/flash_designs_123.xml')){
		  echo "file updated";  
		}else{
		     echo "issue in file saving process";  
		}
		
	    
	}
    function product_colour($type){
			
			if($type == 'rolls' || $type == 'Rolls'){
				$condition = " ProductBrand LIKE 'Roll Labels' ";
				$type = 'Rolls';
			}
			else if($type == 'a3' || $type == 'A3'){
				$condition = " ProductBrand LIKE 'A3 Label' ";
				$type = 'A3';
			}
			else if($type == 'sra3' || $type == 'SRA3'){
				$condition = " ProductBrand LIKE 'SRA3 Label' ";
				$type = 'SRA3';
			}
			else if($type == 'a4' || $type == 'A4'){
				$condition = " ProductBrand LIKE 'A4 Labels' ";
				$type = 'A4';
			}
		
		$result = $this->db->query("SELECT LabelColor as colour,ColourMaterial as material_type,LabelFinish as finish_type,
		priority,ManufactureID,Material1 
		FROM `products` WHERE $condition AND Activate='Y' AND  LabelFinish!='' AND  ColourMaterial !='' AND LabelColor !='' 
		GROUP BY CONCAT_WS('',LabelFinish,ColourMaterial,LabelColor) order by priority asc")->result();
			
			if(count($result) > 0){
		       $this->db->delete("products_colour",array('type'=>$type));
    		   $i = 1;
    		 	foreach($result as $row){
					if($type == 'rolls' || $type == 'Rolls'){
						    $material_code = $this->home_model->getmaterialcode(substr($row->ManufactureID,0,-1));
					}else{
						    $material_code = $this->home_model->getmaterialcode($row->ManufactureID);
					}
					$row->Material1 = $this->home_model->get_db_column('material_tooltip_info','short_name', 'material_code',$material_code);
    			    echo "<br>".$i."-".$row->colour." ----- ".$row->material_type." ----- ".$row->finish_type;
    				$this->db->insert("products_colour", array('colour'=>trim($row->colour),
    														   'material_type'=>trim($row->material_type),
    														   'finish_type'=>trim($row->finish_type),
															   'priority'=>$row->priority,
															   'imagecode'=>$material_code,
															   'colour_name'=>$row->Material1,
    														   'type'=>$type));
    														   $i++;
    			}
			}
	}
	function product_adhesive($type){
			
			if($type == 'rolls' || $type == 'Rolls'){
				$condition = " ProductBrand LIKE 'Roll Labels' ";
				$type = 'Rolls';
			}
			else if($type == 'a3' || $type == 'A3'){
				$condition = " ProductBrand LIKE 'A3 Label' ";
				$type = 'A3';
			}
			else if($type == 'sra3' || $type == 'SRA3'){
				$condition = " ProductBrand LIKE 'SRA3 Label' ";
				$type = 'SRA3';
			}
			else if($type == 'a4' || $type == 'A4'){
				$condition = " ProductBrand LIKE 'A4 Labels' ";
				$type = 'A4';
			}
			
			$result = $this->db->query("SELECT Adhesive as ahesive,ColourMaterial as material_type,LabelFinish as finish_type FROM `products` WHERE $condition AND Activate='Y' AND  LabelFinish!='' AND  ColourMaterial !='' AND LabelColor !='' GROUP BY CONCAT_WS('',LabelFinish,ColourMaterial,Adhesive) order by priority asc")->result();
		 if(count($result) > 0){
		      $i = 1;
			  $this->db->delete("products_adhesive",array('type'=>$type));
			foreach($result as $row){
				
			     echo "<br>".$i."-".$row->ahesive." ----- ".$row->material_type." ----- ".$row->finish_type;
				$this->db->insert("products_adhesive", array('ahesive'=>trim($row->ahesive),
														     'material_type'=>trim($row->material_type),
														     'finish_type'=>trim($row->finish_type),
														     'type'=>$type));
														      $i++;
			}
		} 
	}
	
	
	function tbl_info(){
			
			
		

           $query = $this->db->query("SELECT ProductID,ManufactureID FROM `products` ORDER BY `products`.`ProductID` DESC LIMIT 1");
		$product =$query->row_array(); 
		
		
		$query = $this->db->query("SELECT ID,ManufactureID  FROM  `tbl_product_batchprice`  ORDER BY `tbl_product_batchprice`.`ID` DESC  LIMIT 1");
		$batch =$query->row_array(); 
			
		$query =  $this->db->query("SELECT ID,diecode FROM  `stock`  ORDER BY  `stock`.`ID` DESC  LIMIT 1");
		$stock =$query->row_array(); 
		
		$query =  $this->db->query("SELECT ID,ManufactureID FROM  `tbl_batch_labels`  ORDER BY  `tbl_batch_labels`.`ID` DESC  LIMIT 1");
		$labels =$query->row_array(); 
		
		
		$query =  $this->db->query("SELECT ID,ManufactureID FROM  `tbl_batch_roll`  ORDER BY  `tbl_batch_roll`.`ID` DESC  LIMIT 1");
		$rolls =$query->row_array(); 
		
		
		
		$query =  $this->db->query("SELECT ID,code FROM  `roll_diameter`  ORDER BY  `roll_diameter`.`ID` DESC  LIMIT 1");
		$diameter =$query->row_array(); 
		
		
		
		$query =  $this->db->query("SELECT ID,CategoryId FROM  `categorycore`  ORDER BY  `categorycore`.`ID` DESC  LIMIT 1");
		$cores =$query->row_array(); 
		
		
		$query =  $this->db->query("SELECT ID,manufacture_id FROM `roll_discount_table` ORDER BY `ID` DESC  LIMIT 1");
		$roll_discount =$query->row_array(); 
		
		
		echo "<table border='1' cellpadding='10' cellspacing='0'>
					<thead>
						<th>Table</th>
						<th>Product</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$product['ProductID']."</td></tr>
						<tr><td>Last Value</td><td>".$product['ManufactureID']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>BatchPrice</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$batch['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$batch['ManufactureID']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>Stock</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$stock['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$stock['diecode']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>Labels</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$labels['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$labels['ManufactureID']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>Rolls</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$rolls['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$rolls['ManufactureID']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>Diameter</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$diameter['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$diameter['code']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>Category Cores</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$cores['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$cores['CategoryId']."</td></tr>
					</tbody>
					<thead>
						<th>Table</th>
						<th>Roll_discount_table</th>
					</thead>
					<tbody>
						<tr><td>Last ID</td><td>".$roll_discount['ID']."</td></tr>
						<tr><td>Last Value</td><td>".$roll_discount['manufacture_id']."</td></tr>
					</tbody>
					</tbody>
			</table>";
		die();
	 }
	function index(){
          // echo "loading here ";die();
			
	}
	function get_filter_category(){
		if($_POST){
			$type =  trim($this->input->post('type'));
			$shape =  trim($this->input->post('shape'));
			$labels =  	 trim($this->input->post('labels'));
			
			$page =  	 trim($this->input->post('page'));
			
			
			$orderby =  	 trim($this->input->post('orderby'));
			$brand = $this->home_model->make_productBrand_condtion($type);
			$condition = " p.ProductBrand LIKE '".$brand."' AND CategoryActive='Y'";
			
			$shape_con = '';
			$label_con = '';
			
			if(isset($shape) and strlen($shape) > 0){
				$shape_con = " AND c.Shape LIKE '".$shape."' ";
			}
			if(isset($labels) and strlen($labels) > 0){
				$label_con = " AND p.LabelsPerSheet LIKE '".$labels."' ";
			}
		
			$shape_list = $shape_list = $this->home_model->category_shapes($condition.$label_con);
			$label_list = $this->home_model->category_lables_persheet($condition.$shape_con);
			
			
			$condition = $condition.$shape_con.$label_con;
			
			if($type =='Roll'){
				  $orderby = ' c.Width '.$orderby;
			}else{
				  $orderby = ' LabelsPerSheet '.$orderby;
			}
			
			
			$data['records'] = $this->home_model->fetch_dies_data($condition,$orderby);
			
			$data['type'] = $type;
			$data['shape'] = $shape;
			
			
			
			$shape_option = $this->home_model->make_html_option($shape_list,'Shapes','Show all',$shape);
			$labels_option = $this->home_model->make_html_option($label_list,'LabelsPerSheet','Sort by Labels ',$labels);
			
			if(isset($page) and $page=='template'){
				$theHTMLResponse    = $this->load->view('category/template_list', $data, true);
			}else{
				$theHTMLResponse    = $this->load->view('category/category_list', $data, true);	
			}
			
			
			
			
		$this->output->set_content_type('application/json');
    	$this->output->set_output(json_encode(array('html'=> $theHTMLResponse,'shapes'=>$shape_option,'labels'=>$labels_option,'count'=>$data['records']['num_row'])));
	
					//echo json_encode(array('html'=>$html));
		}
	}
	
	
	
	
	
	function get_category_materials(){
		
		if($_POST){
			
					$material_sel ='';
					$adhisive_sel ='';
					$color_sel = '';
					$color_sel = '';
					$labelsgap = '';
					$printer_condition = '';
					$wholesale = trim($this->input->post('wholesale'));
					
					
					$material_sel =  trim($this->input->post('material'));
					$adhesive_sel =  trim($this->input->post('adhesive'));
					$color_sel =  trim($this->input->post('color'));
					$catid = trim($this->input->post('catid'));
					
					
				   $productid =  trim($this->input->post('productid'));
					
					$compatability =  trim($this->input->post('compatiblity'));
					
					if(isset($compatability) and $compatability!=''){
							
							if(preg_match("/\bDirect Thermal\b/i",$compatability)){
								$printer_condition .= " SpecText7 LIKE '%Direct Thermal%' OR";	
							}
							if(preg_match("/\bThermal Transfer\b/i",$compatability)){
								$printer_condition .= " SpecText7 LIKE '%Thermal Transfer%' OR";	
							}
							if(preg_match("/\bInkjet\b/i",$compatability)){
								$printer_condition .= " AND SpecText7 LIKE '%Inkjet%' OR";	
							}
							if($printer_condition){
								$printer_condition = " AND ( ".substr($printer_condition,0,-2)." )";
							}
						
					}
					
					
					$condition = " CategoryID='$catid' ".$printer_condition;
					if(isset($productid) and strlen($productid) > 0){
						$condition .=" AND ProductID <> '".$productid."' "; 
					}
						
					$material = '';
					$adhesive ='';
					$color = '';
					
					if(isset($material_sel) and strlen($material_sel) > 0){
						$material =" AND ColourMaterial LIKE '".$material_sel."' ";
						 
					}
					if(isset($adhesive_sel) and strlen($adhesive_sel) > 0){
						$adhesive =" AND Adhesive LIKE '".$adhesive_sel."' "; 
					}
					if(isset($color_sel) and strlen($color_sel) > 0){
						$color =" AND LabelColor LIKE '".$color_sel."' "; 
					}
					
					
					
					$paper_list = $this->home_model->distinct_material_paper($condition.$adhesive.$color);
					$adhisive_list = $this->home_model->distinct_material_adhisive($condition.$material.$color);
					$color_list = $this->home_model->distinct_material_color($condition.$adhesive.$material);
					
					
					
					
					
					$adhesive_option = $this->home_model->make_html_option($adhisive_list,'Adhesive','Sort by Adhesive',$adhesive_sel);
					$color_option = $this->home_model->make_html_option($color_list,'Color','Sort by Colour',$color_sel);
					$paper_option = $this->home_model->make_html_option($paper_list,'Material','Sort by Material',$material_sel);
					
					
					$condition = $condition.$material.$adhesive.$color;
					
			
			
			$data['printer_compatiblity'] =  trim($this->input->post('compatiblity'));
			$data['catid'] =  trim($this->input->post('catid'));
			$data['Labelsgap'] =  trim($this->input->post('labelsgap'));
			$data['max_diameter'] =  trim($this->input->post('max_diameter'));
			$data['height'] =  trim($this->input->post('height'));
			
							
			$data['materials'] = $this->home_model->ajax_material_sorting($condition);
					
			if(isset($wholesale) and $wholesale=='enable'){
				$theHTMLResponse    = $this->load->view('wholesale/material_list', $data, true);
			}else{
				$theHTMLResponse    = $this->load->view('material/material_list', $data, true);
			}
			$this->output->set_content_type('application/json');
    		$this->output->set_output(json_encode(array('html'=> $theHTMLResponse,'color'=> $color_option,'material'=> $paper_option,'adhesive'=>$adhesive_option)));
	
					//echo json_encode(array('html'=>$html));
		}
	}
	function get_category_materials_newfilter(){
		if($_POST){
					$material_sel ='';
					$adhisive_sel ='';
					$color_sel = '';
					$color_sel = '';
					$labelsgap = '';
					$printer_condition = '';
					$wholesale = trim($this->input->post('wholesale'));
					
					$material_sel = trim($this->input->post('material'));
					$adhesive_sel = trim($this->input->post('adhesive'));
					$color_sel =  trim($this->input->post('color'));
					$catid = trim($this->input->post('catid'));
				    $productid =  trim($this->input->post('productid'));
					$compatability =  trim($this->input->post('compatiblity'));
					
					if(isset($compatability) and $compatability!=''){
							
							if(preg_match("/\bDirect Thermal\b/i",$compatability)){
								$printer_condition .= " SpecText7 LIKE '%Direct Thermal%' OR";	
							}
							if(preg_match("/\bThermal Transfer\b/i",$compatability)){
								$printer_condition .= " SpecText7 LIKE '%Thermal Transfer%' OR";	
							}
							if(preg_match("/\bInkjet\b/i",$compatability)){
								$printer_condition .= " AND SpecText7 LIKE '%Inkjet%' OR";	
							}
							if($printer_condition){
								$printer_condition = " AND ( ".substr($printer_condition,0,-2)." )";
							}
					}
					
					$product_condition = " CategoryID='$catid' ".$printer_condition;
					
					/*$condition = " CategoryID='$catid' ".$printer_condition;
					if(isset($productid) and strlen($productid) > 0){
						$condition .=" AND ProductID <> '".$productid."' "; 
					}
						
					$material = '';
					$adhesive ='';
					$color = '';
					
					if(isset($material_sel) and strlen($material_sel) > 0){
						$material =" AND ColourMaterial LIKE '".$material_sel."' ";
						 
					}
					if(isset($adhesive_sel) and strlen($adhesive_sel) > 0){
						$adhesive =" AND Adhesive LIKE '".$adhesive_sel."' "; 
					}
					if(isset($color_sel) and strlen($color_sel) > 0){
						$color =" AND LabelColor LIKE '".$color_sel."' "; 
					}*/
					
					$condition = "1=1";
					if(isset($productid) and strlen($productid) > 0){
						//$condition .=" AND ProductID <> '".$productid."' "; 
					}
						
					$material = '';
					$adhesive ='';
					$color = '';
					$type = '';
					
					if(isset($material_sel) and strlen($material_sel) > 0){
						$material =" AND filter_group LIKE '".$material_sel."' ";
					}
					if(isset($adhesive_sel) and strlen($adhesive_sel) > 0){
						$adhesive =" AND adhesive LIKE '".$adhesive_sel."' "; 
					}
					if(isset($color_sel) and strlen($color_sel) > 0){
						$color =" AND filter_color LIKE '".$color_sel."' "; 
					}
					if(preg_match('/^c/i', $catid)){
						$catid = strtoupper($catid);
						if(substr($catid,-2,1)=='R'){
							if(preg_match('/r1|r2|r3|r4|r5/is',$catid)){	
								$catid = explode("R",$catid);
								$catid=$catid[0];
							}
						}
					}
					$categoryName = $this->home_model->get_db_column('category','CategoryName','CategoryID',$catid);
					if(preg_match('/\bA3\b/',$categoryName))
					{
						$type = "A3";
					}
					else if(preg_match('/\bA4\b/',$categoryName))
					{
						$type = "A4";
					}
					else if(preg_match('/\bSRA3\b/',$categoryName))
					{
						$type = "SRA3";
					}
					else if(preg_match('/\bRoll\b/',$categoryName))
					{
						$type = "Rolls";
					}
					
					if($type != '')
					{
						$type = " AND type LIKE '%$type%'";
					}
					$paper_list = $this->filter_model->distinct_material_paper($condition.$adhesive.$color.$type,$type);
					$color_list = $this->filter_model->distinct_material_color($condition.$adhesive.$material.$type,$type);
					
					
					
					$color_option = $this->home_model->make_html_option_filter($color_list,'Color','Sort By Colour',$color_sel);
					$paper_option = $this->home_model->make_html_option_filter($paper_list,'Material','Sort By Material',$material_sel);
				
					$condition = $product_condition.$adhesive;
					//	$condition = $product_condition.$material.$adhesive.$color;
			
			$data['printer_compatiblity'] =  trim($this->input->post('compatiblity'));
			$data['catid'] =  trim($this->input->post('catid'));
			$data['Labelsgap'] =  trim($this->input->post('labelsgap'));
			$data['max_diameter'] =  trim($this->input->post('max_diameter'));
			$data['height'] =  trim($this->input->post('height'));
			
			if(isset($material_sel) and strlen($material_sel) > 0){
				$material =" AND ColourMaterial LIKE '".$material_sel."' ";
			}
			if(isset($color_sel) and strlen($color_sel) > 0){
				$color =" AND LabelColor LIKE '".$color_sel."' "; 
			}
			$condition = $product_condition.$material.$adhesive.$color;
			
			
			$data['materials'] = $this->home_model->ajax_material_sorting($condition);
			
			
			//echo $this->db->last_query();exit;
			if(isset($wholesale) and $wholesale=='enable'){
				$theHTMLResponse = $this->load->view('wholesale/material_list', $data, true);
			}else{
				$theHTMLResponse = $this->load->view('material/material_list', $data, true);
			}
			$this->output->set_content_type('application/json');
    		$this->output->set_output(json_encode(array('html'=> $theHTMLResponse,'color'=> $color_option,'material'=> $paper_option,'adhesive'=>$adhesive_option)));
	
					//echo json_encode(array('html'=>$html));
		}
	}
	function material_popup($id,$type=NULL)
	{
		if($type==NULL){ $type ='A4';}
		$data['id']=$id;
		$qry = "SELECT * from products where ProductID='".$id."' ";
		$query=$this->db->query($qry);
		$res=$query->result();
		$data['allcats']=$res;
		$data['type']=$type;
		
		if(preg_match("/Roll Labels/is",$res[0]->ProductBrand)){
			if($res[0]->Material2=='Matt Colour Paper'){
				 $code ='mattcolours';
			}
			else{
				$code =  $this->home_model->getmaterialcode(substr($res[0]->ManufactureID,0,-1));
			}
			$path = 	'material/specs/roll/'.$code;
		}else{
			
			if(preg_match("/Application Labels/is",$res[0]->ProductBrand)){
				$res[0]->ManufactureID =substr($res[0]->ManufactureID,0,-4);
			} 
			    
			if($res[0]->Material2=='Matt Colour Paper'){
				 $code ='mattcolours';
			}
			else{
				$code =  $this->home_model->getmaterialcode($res[0]->ManufactureID);
			}
			
			if(preg_match("/Integrated Labels/is",$res[0]->ProductBrand)){
				$code = 'integrated';
			}    
                         //$code =  $this->home_model->getmaterialcode($res[0]->ManufactureID);
			$path = 	'material/specs/a4/'.$code;
		}
		//$data['material'] = (object) array('code'=>$code);
		$this->load->view('material/material_popup', $data);
		
		$res[0]->Image1 = str_replace(".gif",".png",$res[0]->Image1);
		$img_path = Assets.'images/material_images/'.$res[0]->Image1;
		
		$theHTMLResponse    = $this->load->view($path, $data, true);
		//$theHTMLResponse    = $this->load->view('material/material_popup', $data, true);
		$this->output->set_content_type('application/json');
    	$this->output->set_output(json_encode(array('html'=> $theHTMLResponse,'mat_code'=>$code,'src'=>$img_path)));
			
			
	} 
	
	function layout_popup($catid,$manid=NULL)
	{
			if(substr($catid,-2,1)=='R')
			{
				if(preg_match('/r1|r2|r3|r4|r5/is',$catid))
				{
					$new_code_exp=explode("R",$catid);
					$catid=$new_code_exp[0];
				}
			}
		
			$details = $this->home_model->fetch_category_details($catid);
			if(preg_match("/Roll/",$details['CategoryName'])){
				 $img_src = Assets."images/categoryimages/rollimages/".$details['CategoryImage'];
				 $height = 'auto';
				 $pop_width = '200';
						
			}
			else if(preg_match("/SRA3/",$details['CategoryName'])){
						$img_src = Assets."images/categoryimages/SRA3Sheets/".$details['CategoryImage'];
						$height = 'auto';
						$pop_width = '200';
			}
			else if(preg_match("/A3/",$details['CategoryName'])){
						$img_src = Assets."images/categoryimages/A3Sheets/".$details['CategoryImage'];
						$height = 'auto';
						$pop_width = '200';
			}
			else{ 
			        if(isset($manid) && $manid!=""){
		              $img_src = Assets."images/categoryimages/A4Sheets/colours/".$manid.'.png';
		            }else{
					  $img_src = Assets."images/categoryimages/A4Sheets/".$details['CategoryImage'];
					}
					
						$pop_width = '189';
						$height = 'auto';
			}
			
			$data['img_src'] = $img_src;
			$data['pop_width'] = $pop_width;
			$data['height'] =  $height;
			$data['details']  = $details;
			$data['catname'] = $details['CategoryName'];
			
			$theHTMLResponse    = $this->load->view('material/layout_popup', $data, true);
			$this->output->set_content_type('application/json');
    		$this->output->set_output(json_encode(array('html'=> $theHTMLResponse)));
	} 
	
	function calculate_sheet_price_old(){
		
	   if($_POST){
			
			$qty = $this->input->post('qty');
			$menu = $this->input->post('menuid');
			$labels = $this->input->post('labels');
			$labeltype = $this->input->post('labeltype');
			
			$productid = $this->input->post('prd_id');
			$design = $this->get_number_design($productid);
			
			
			$save_txt = '';
			
			$ProductBrand = $this->ProductBrand($menu);
		    if(isset($qty) and $qty > 0 ){
				$data=$this->product_model->ajax_price($qty,$menu);	
				$data2=$this->product_model->ajax_second_price($qty,$menu);	
					
				$price = $data['custom_price'];
				$printprice = 0.00;
				$designprice = 0.00;
				$printoption = 'plain';
				$free_artworks = 1;
				
			if($labeltype=='Mono' || $labeltype=='Fullcolour'){
					$printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
					$free_artworks = $printprice['artworks'];
					$designprice = $printprice['desginprice'];
					$printprice = $printprice['price'];
					if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
						$printprice = $printprice*1.5;
					}
					$printoption = 'printed';
			}
			
			if($ProductBrand=='Application Labels'){
				$printprice = 0.00; 
                $data2['custom_price1'] = 0.00;
			}
			 
			 
			 
			$price1  = $data2['custom_price1'];
			$delivery_txt = $this->shopping_model->delevery_txt();
			$percentage = $this->product_model->label_price_per($price1,$price);
			if(!$data2['custom_qty1']==''){	
		   		$save_txt =' Order '.$data2['custom_qty1'].' sheets/'.$data2['custom_qty1']*$labels.' labels and Save '.floor($percentage).'%'; 
			}
					
				///$perprice = round(($price/($labels*$qty))*100,2);
		
		
				$price = $this->home_model->currecy_converter($price, 'yes');
				$printprice =$this->home_model->currecy_converter($printprice, 'yes');
				$designprice =$this->home_model->currecy_converter($designprice, 'yes');
				
				$plain = number_format($price,2,'.','');
				$price = $printprice+$price+$designprice;
				$price = number_format($price,2,'.','');
		
		
		
				
				$wpep_discount_txt = '';$dis_img = '';
				if (preg_match("/A4 Labels/is", $ProductBrand) and ( preg_match("/WPEP/i", $menu))) {
								$wpep_discount = (($plain) * (20 / 100));
								$wpep_discount_txt = '<small class="discount_price">'.symbol.$price.' </small>';
								$price = number_format(($price - $wpep_discount),2,'.','');
								$dis_img = '<img src="'.Assets.'images/discount_20.png">';
				}
				
				 
				 
				$perprice = round(($price / ($labels * $qty)), 3);
				$per_labels = $labels * $qty . ' Labels, '.symbol . $perprice . ' per label';
				$price_txt = '<b class="color-orange"> ' .$wpep_discount_txt. symbol.$price.$dis_img.' </b> <br />'.vatoption.' VAT';
	    
		        $response = array('response'=>'yes',
								  'price'=>$price_txt,
								  'printprice'=>number_format($printprice,2),
								  'designprice'=>$designprice,
								  'artworks'=>$free_artworks,
								  'plain'=>$plain,
								  'type'=>$printoption,
								  'save_txt'=>$save_txt,
								  'delivery_txt'=>$delivery_txt,
								  'labelprice'=>$per_labels,
								  'symbol'=>symbol,
								  'vatoption'=>vatoption);
				echo json_encode($response);
				
				
			}
		}
		
	}
	
	
	function add_to_cart(){
		
		if($_POST){
			
				$qty = $this->input->post('qty');
				$menu = $this->input->post('menuid');
				$productid = $this->input->post('prd_id');
				$type = $this->input->post('type');
				$labeltype = $this->input->post('labeltype');
				$source = $this->input->post('source');
				$batch = $this->input->post('batch');
				$design = $this->get_number_design($productid);
				
				$colorcode = '';
				$wound ='N'; $printtype ='';$is_custom ='No';$LabelsPerRoll ='';	$A4Printing = array();
				$regmark = $this->input->post('regmark');
				$check = $this->user_model->isProductActive($menu);
				if($check==0){
					
					$query = $this->db->query("SELECT Shape_upd,`CategoryID` FROM `products` Where ManufactureID='".$menu."'");	
			  	    $result1 = $query->row_array();
					
					//$roll_arr=array('R1','R2','R3','R4','R5');
					//$categoryid=str_replace($roll_arr,'',$result1['CategoryID']);
					$url = base_url().'roll-labels/'.strtolower($result1['Shape_upd']).'/'.strtolower($result1['CategoryID']).'/';  
					//$url = base_url().'home/material/'.$categoryid;
					echo json_encode(array('deactive'=>'yes','url'=>$url));
				    exit();
				}
				
				if(isset($type) and $type=='Rolls'){
						
						$labels = $this->input->post('labels');
						if(isset($labels) and $labels > 99) {
							$latest_price = $this->home_model->calclateprice($menu,$qty,$labels);
							$total = $latest_price['final_price'];
						}
						
						
						$material_code = $this->home_model->getmaterialcode(substr($menu,0,-1));
						$material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
						if($material_discount){
							$total = ($total*1.2);
							$wpep_discount = (($total)*($material_discount/100));
							$total = $total-$wpep_discount;
							$total = $total/1.2;
						}
				
				
						$is_custom ='Yes';
						$LabelsPerRoll =$labels;
				
						$woundoption = $this->session->userdata('wound');
						$wound_cat = $this->session->userdata('wound-cat');
						
						if(isset($wound_cat) and $woundoption=='Inside'){
							$response = $this->home_model->check_wound_option($productid,$wound_cat);
							if($response==true){
									$wound ='Y';		
							 }
						}
				}
				else if($type=='Integrated'){
							
							$newqty = $this->home_model->calculate_integrated_qty($menu,$qty);
							$price = $this->home_model->single_box_price($menu,$newqty,$batch);
							$total = $price['PlainPrice'];
							
							if($qty != $price['Sheets'])
							{
								 $perbox = $price['PlainPrice']/$price['Box'];
								 $acc_boxes = $qty/$batch;
								 $calculated_price = $acc_boxes*$perbox;
								 $price['PlainPrice'] = $calculated_price;
								 $total = $price['PlainPrice'];
							}
							
							$printed = $this->input->post('print_type');
							if($printed=='printed'){ $labeltype = 'Fullcolour';}
							else if($printed=='black'){ $labeltype = 'Mono';}
							$designprice = 0.00;
							//if(strtolower($printed) != 'plain'){
								$printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design);
								$free_artworks = $printprice['artworks'];
								$designprice = $printprice['desginprice'];
								$printprice = $printprice['price'];
								
								$printprice = $printprice+$designprice;
								
								$Print_Design = '1 Design';
								if($design > 1){
									$Print_Design = 'Multiple Designs';
								}
								$A4Printing = array( 'Printing'=>'Y',
													 'Print_Type'=>$labeltype,
													 'Print_Design'=>$Print_Design,
													 'Free'=>$free_artworks,
													 'Print_Qty'=>$design,
													 'Print_UnitPrice'=>$printprice,
													 'Print_Total'=>$printprice);
								$A4Printing = array(
									'orignalQty' => $batch
								);					 
							//}
				
				
				}else {
							if(substr($menu,-2,2)=='XS'){
								$printtype = $this->input->post('design');
							}
							 	/*****************WPEP Offer************/
									$wpep_discount = 0.00;
									$data=$this->product_model->ajax_price($qty,$menu);
									$total = $data['custom_price'];
								
									$ProductBrand = $this->ProductBrand($menu);
									/*if(preg_match("/A4 Labels/i",$ProductBrand) and (preg_match("/WPEP/i",$menu))){
										$data['custom_price'] = ($data['custom_price']*1.2);
										$wpep_discount = (($data['custom_price'])*(20/100));
										$total = $data['custom_price']-$wpep_discount;
										$total = $total/1.2;
									}*/
									if(preg_match("/A4 Labels/i",$ProductBrand))
									{
										$mat_code = $this->home_model->getmaterialcode($menu);
										$material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
										if($material_discount)
										{
											$data['custom_price'] = ($data['custom_price']*1.2);
											$wpep_discount = (($data['custom_price'])*($material_discount/100));
											$total = $data['custom_price']-$wpep_discount;
											$total = $total/1.2;
										}	
									}
								/*****************WPEP Offer************/
							
							/****************Printed Labels Options*************/
							
							if($ProductBrand=='Application Labels'){ 
								$clrcode = $this->input->post('colour');
								if(isset($clrcode) and $clrcode!=''){
									$colorcode = $this->input->post('colour');
								}
							}
							               
										   
										   
							if(isset($labeltype) and ($labeltype=='Mono' || $labeltype=='Fullcolour')){
									$designprice = 0.00;
									
								 if($source=='flash'){ $design=1; $free_artworks=1;
									if($qty < 25 ){ 
									 $data = $this->product_model->calculate_lba_price($qty,$menu);
									 $total = $data['plainprice']; 
									 $designprice = 0.00;
									 $printprice = $data['printprice'];
									 if($labeltype=='Mono'){
										$printprice = $data['printprice']-($data['printprice']*0.05);   // 5% discount if Mono Printing
									 }
								
								   }else{
									 //$printprice = $this->home_model->calculate_printed_sheets($qty,$labeltype,1);
									 $printprice = $this->home_model->calculate_printed_sheets($qty,$labeltype,1, $ProductBrand, $menu);
									 $designprice = $printprice['desginprice'];
									 $printprice = $printprice['price'];
									 $printprice = $printprice+$designprice;
									}
									
									$Print_Design = '1 Design';
								
								}else{	
									
									$printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
									$free_artworks = $printprice['artworks'];
									$designprice = $printprice['desginprice'];
									$printprice = $printprice['price'];
									if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
										$printprice = $printprice*1.5;
									}
									$printprice = $printprice+$designprice;
										
									$Print_Design = '1 Design';
									if($design > 1){
										$Print_Design = 'Multiple Designs';
									}
							  }
									
														 
									 $A4Printing = array( 'Printing'=>'Y',
										 'Print_Type'=>$labeltype,
										 'Print_Design'=>$Print_Design,
										 'Free'=>$free_artworks,
										 'Print_Qty'=>$design,
										 'Print_UnitPrice'=>$printprice,
										 'Print_Total'=>$printprice,
										 'source'=>$source);
							}
							/****************Printed Labels Options*************/
								
								
				}
			
				$origQty = $labels*$qty;
				if(isset($type) and $type=='Rolls' and isset($regmark) and $regmark == "yes"){
							$origQty = $labels*$qty;
							//$total = $total + REGMARKPRICE;
							
							/*$collection['labels'] 	  = $labels; 
							$collection['manufature'] = $menu;
							$collection['finish']     = 'No Finish';
							$collection['rolls']      = $qty;
							$collection['labeltype']      = 'Monochrome - Black Only';
							$price_res = $this->home_model->calculate_printing_price($collection);
							echo"<pre>";print_r($price_res);echo"</pre>";exit;
							$regmark_price = $price_res['promotiondiscount'];
							$total = $price_res['plainlabelsprice'];
							$total = $total + $regmark_price;
							$regmark_price = symbol.number_format($regmark_price,2,'.','');*/
							
							$lpr = $this->home_model->get_db_column("products","LabelsPerSheet","ManufactureID",$menu);
							$labelfinish = 'No Finish';
							$persheets = $this->input->post('max_labels');
							$values_array = array('labeltype'=>'Monochrome - Black Only',
											  'labels'=>$labels*$qty,
											  'design'=>1,
											  'menu'=>$menu,
											  'persheets'=>$lpr,
											  'producttype'=>'Rolls',
											  'pressproof'=>0,
											  'finish'=>$labelfinish);
							$response = $this->price_calculator($values_array);
							//$regmark_price = $this->home_model->currecy_converter($response['promotiondiscount'], 'yes');
							$regmark_price = $response['promotiondiscount'];
							$regmark_price = number_format($regmark_price,2,'.','');
							//$price = $price + $regmark_price;
							$price = $response['price'];
							$raw_plain = $response['plainlabelsprice'];
							$total = $regmark_price + $raw_plain;
		
							$A4Printing = array( 'Printing'=>'Y',
												 'Print_Type'=>'Monochrome - Black Only',
												 'Print_Design'=>1,
												 'Free'=>1,
												 'Print_Qty'=>1,
												 /*'Print_UnitPrice'=>REGMARKPRICE,
												 'Print_Total'=>REGMARKPRICE,*/
												 'FinishType'=>'No Finish',
												 'wound'=>'Outside',
												 'regmark'=>'Y',
												 'orientation'=>1);
						}
				
				
						$unit_price = $total/$qty;
						$SID  =  $this->shopping_model->sessionid();
						$items = array('SessionID'=>$SID,
									   'ProductID'=>$productid,
									   'Quantity'=>$qty,
									   'orignalQty'=>$origQty,
									   'UnitPrice'=>$unit_price,
									   'TotalPrice'=>$total,
									   'wound'=>$wound,
									   'OrderData'=>$printtype,
									   'is_custom'=>$is_custom,
									   'LabelsPerRoll'=>$LabelsPerRoll,
									   'colorcode'=>$colorcode,
									   'page_location'=>'Product Material',);
						$items = array_merge($items,$A4Printing);	
						
						
						$userID = $this->session->userdata('userid');
						if(isset($userID) and $userID != '')
						{
							$cart_reminder = $this->home_model->get_db_column("customers","cart_reminder","UserID",$userID);
							if(isset($cart_reminder) and $cart_reminder == "Y")
							{
								$items['UserID'] = $userID;
							}
						}
								   
						$this->db->insert('temporaryshoppingbasket',$items);
						
					if($this->db->insert_id()){		
						if(isset($labeltype) and ($labeltype=='Mono' || $labeltype=='Fullcolour')){
							
							$data = array( 'CartID' => $this->db->insert_id(), 'status' => 'confirm');
							$items_array = array('SessionID' => $SID, 'ProductID' => $productid, 'status'=>'temp');
							$update = $this->db->update('integrated_attachments', $data, $items_array);	
						}
					}
					
					$topcart_data = $this->ajax_topcart_load();
					echo json_encode(array('response'=>'yes','top_cart'=>$topcart_data));
				
					
		}
	}
	
	function get_number_design($productid){
		$SID  =  $this->shopping_model->sessionid();
		$query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '".$SID."' AND ProductID=$productid AND status LIKE 'temp' ");	
		$row = $query->row_array();
		if(isset($row['total']) and $row['total'] ) return $row['total'];

		else return 0;
	}
	
	
	function calculate_user_price(){
		
	   if($_POST){
			
			$qty = $this->input->post('qty');
			$menu = $this->input->post('menuid');
			$labels = $this->input->post('labels');
			$type = $this->input->post('type');
			$line_type = $this->input->post('line_type');
			$batch = $this->input->post('batch');
			$regmark = $this->input->post('regmark');
			
			$save_txt = '';
				$check = $this->user_model->isProductActive($menu);
				if($check==0){
					
					$query = $this->db->query("SELECT `CategoryID`,Shape_upd FROM `products` Where ManufactureID='".$menu."'");	
			  	    $result1 = $query->row_array();
					//$roll_arr=array('R1','R2','R3','R4','R5');
					//$categoryid=str_replace($roll_arr,'',$result1['CategoryID']);
					$url = base_url().'roll-labels/'.strtolower($result1['Shape_upd']).'/'.strtolower($result1['CategoryID']).'/';  
					//$url = base_url().'home/material/'.$categoryid;
					echo json_encode(array('deactive'=>'yes','url'=>$url));
				    exit();
					
				}
				if(isset($type) and $type=='Rolls'){
					
					if($qty > 0 and $labels > 99){
							$latest_price = $this->home_model->calclateprice($menu,$qty,$labels);
							
							$latest_price['final_price'] = $this->home_model->currecy_converter($latest_price['final_price'],'yes');
							$price = $latest_price['final_price'];
							
							
							
							$labelfinish = 'No Finish';
							$persheets = $this->input->post('max_labels');
							$lpr = $this->home_model->get_db_column("products","LabelsPerSheet","ManufactureID",$menu);
							$values_array = array('labeltype'=>'Monochrome - Black Only',
												  'labels'=>$labels*$qty,
												  'design'=>1,
												  'menu'=>$menu,
												  'persheets'=>$lpr,
												  'producttype'=>'Rolls',
												  'pressproof'=>0,
												  'finish'=>$labelfinish);
							
							$response = $this->price_calculator($values_array);
							
							$price = $response['price'];
							$price = $this->home_model->currecy_converter($price, 'yes');
							
							
							$perprice = number_format(($price/($labels*$qty)),2,'.','');
							$per_labels = $perprice;
								
							echo json_encode(array('response'=>'yes',
												  'price'=>$price,
												  'total_labels'=>$labels*$qty,
												  'labelprice'=>$per_labels,
												  'symbol'=>symbol,
												  'vatoption'=>vatoption));
					}
				
				}
				else if($type=='Integrated'){
				
							$newqty = $this->home_model->calculate_integrated_qty($menu,$qty);
							$printed = $this->input->post('print_type');
							$price = $this->home_model->single_box_price($menu,$newqty,$batch);
							
							if($printed=='Printed'){
								 $printprice = $this->home_model->calculate_printed_sheets($qty, 'Fullcolour');
								// $print_price =  $this->home_model->calculate_integrated_printing($qty);
								 $totalprice =   $printprice['price']+$price['PlainPrice'];
								 $printtype ='Printed';
							}
							else if($printed=='Black'){
								// $print_price =  $this->home_model->calculate_integrated_printing($qty);
								 $printprice = $this->home_model->calculate_printed_sheets($qty, 'Mono');
								 $totalprice = $printprice['price']+$price['PlainPrice'];
								 $printtype ='Black'; 
							}
							else{
									$totalprice = $price['PlainPrice'];
									$printtype ='Plain';
							}
							
							if($qty != $price['Sheets'])
							{
								 $perbox = $price['PlainPrice']/$price['Box'];
								 $acc_boxes = $qty/$batch;
								 $calculated_price = $acc_boxes*$perbox;
								 $price['PlainPrice'] = $calculated_price;
								 $totalprice = $price['PlainPrice'];
							}

							$totalprice = $this->home_model->currecy_converter($totalprice,'yes');
							
							$unitprice = $totalprice/$qty;
							$perprice = number_format(($totalprice/($labels*$qty)),2,'.','');
							echo json_encode(array('response'=>'yes',
												   'price'=>$totalprice,
												   'total_labels'=>$labels*$qty,
												   'labelprice'=>$perprice,
												   'symbol'=>symbol,
												   'vatoption'=>vatoption));
							
				
				}else{
						//if(isset($qty) and ($qty >24 and $qty <= 50000) ){
								
								$data=$this->product_model->ajax_price($qty,$menu);	
								
								$data['custom_price'] = $this->home_model->currecy_converter($data['custom_price'],'yes');
								$ProductBrand = $this->ProductBrand($menu);
								if(preg_match("/A4 Labels/i",$ProductBrand))
								{
									$mat_code = $this->home_model->getmaterialcode($menu);
									$material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
									if($material_discount)
									{
										$data['custom_price'] = ($data['custom_price']*1.2);
										$wpep_discount = (($data['custom_price'])*($material_discount/100));
										$price = $data['custom_price']-$wpep_discount;
										$price= $price/1.2;
									}	
								}
								$price = number_format($price,2);
								$perprice = number_format(($price/($labels*$qty)),2,'.','');
								$per_labels = $perprice;
								
								
				// **---***---***---****----****----****---***---***---****----****----**
				if(isset($line_type)){
				 if($line_type=='Mono' || $line_type=='Fullcolour'){
				   $designprice = 0.00;	
				   if($qty < 25){
					   $data = $this->product_model->calculate_lba_price($qty,$menu);
					   $printprice = $data['printprice'];
                                            $price = $data['plainprice']; 
						 if($line_type=='Mono'){
							 $printprice = $data['printprice']-($data['printprice']*0.05);   // 5% discount if Mono Printing
						}
				   }else{
					   $ProductBrand = $this->ProductBrand($menu);
					   $printprice = $this->home_model->calculate_printed_sheets($qty,$line_type,1,$ProductBrand,$menu);
					   $designprice = $printprice['desginprice'];
					   $printprice = $printprice['price'];
					   if (preg_match("/A3 Labels/is", $ProductBrand) || preg_match("/SRA3 Labels/is", $ProductBrand)) {
							$printprice = $printprice*1.5;
					   }
					   $printprice = $printprice+$designprice;
				   }
				   
				 $price = number_format(($price + $printprice),2,'.','');
				}
			  }
             // **---***---***---****----****----****---***---***---****----****----**
								echo json_encode(array('response'=>'yes',
													   'price'=>$price, 
													   'total_labels'=>$labels*$qty,
													   'labelprice'=>$per_labels,
													   'symbol'=>symbol,
													   'vatoption'=>vatoption));
						//}
				 }		
				
		}
		
	}
	
	function update_cart_items(){
		
			$qty = $this->input->post('qty');
			$menuId = $this->input->post('menuid');
			$labels = $this->input->post('labels');
			$type = $this->input->post('type');
			$id = $this->input->post('id');
			$batch = $this->input->post('batch');
			$printtype ='';
			
			if($_POST){
				
					/******************Sample Order implementation***********************/
					if($type=='Sample'){
						$totalprice = 0.00; $unitprice=0.00; $printtype = $type;
					}
					/******************Sample Order implementation***********************/
			
					else if($type=='Rolls'){
					
						if($labels > 99){
							$custom_price = $this->home_model->calclateprice($menuId,$qty,$labels);
							$totalprice = $custom_price['final_price'];
							$unitprice = number_format(round($custom_price['unit_prcie'],4),4,'.','');
						}
						
						
						$material_code = $this->home_model->getmaterialcode(substr($menuId,0,-1));
						$material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
						if($material_discount){
								$totalprice = ($totalprice*1.2);
								$wpep_discount = (($totalprice)*($material_discount/100));
								$totalprice = $totalprice-$wpep_discount;
								$totalprice= $totalprice/1.2;
				   		}
					
					
					
					}
					else if($type=='Integrated'){
							$price = $this->home_model->single_box_price($menuId,$qty, $batch);
							if($qty != $price['Sheets'])
							{
								 $perbox = $price['PlainPrice']/$price['Box'];
								 $acc_boxes = $qty/$batch;
								 $calculated_price = $acc_boxes*$perbox;
								 $price['PlainPrice'] = $calculated_price;
							}
							$totalprice = $price['PlainPrice'];
							$unitprice = $totalprice/$qty;
							
							
					}
					else{
							//$cutom_price=$this->product_model->ajax_price($qty,$menuId);
							//$totalprice = $cutom_price['custom_price'];
							//$unitprice = number_format(round($cutom_price['custom_price']/$qty,4),4,'.','');
							//$unitprice=number_format($cutom_price['custom_price']/$qty,2);	
							
							/*******WPEP Offer**********/
								$cutom_price=$this->product_model->ajax_price($qty,$menuId);
								$totalprice = $cutom_price['custom_price'];
								$ProductBrand = $this->ProductBrand($menuId);
								/*if(preg_match("/A4 Labels/i",$ProductBrand) and (preg_match("/WPEP/i",$menuId))){
										$cutom_price['custom_price'] = ($cutom_price['custom_price']*1.2);
										$wpep_discount = (($cutom_price['custom_price'])*(20/100));
										$totalprice = $cutom_price['custom_price']-$wpep_discount;
										$totalprice= $totalprice/1.2;
								}*/
								if(preg_match("/A4 Labels/i",$ProductBrand))
								{
									$mat_code = $this->home_model->getmaterialcode($menuId);
									$material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
									if($material_discount)
									{
										$cutom_price['custom_price'] = ($cutom_price['custom_price']*1.2);
										$wpep_discount = (($cutom_price['custom_price'])*($material_discount/100));
										$totalprice = $cutom_price['custom_price']-$wpep_discount;
										$totalprice= $totalprice/1.2;
									}	
								}
								$unitprice=number_format($totalprice/$qty,2);	
							/*******WPEP Offer**********/
							
							
							
							
					}
					$SID  =  $this->shopping_model->sessionid();
					$data = array( 'Quantity' => $qty,'TotalPrice' => $totalprice,'UnitPrice' => $unitprice,'OrderData'=>$printtype);


                           /****************Printed Labels Options*************/


									 $a4printing = $this->db->query("select Print_Type,Printing,Print_Qty,source from temporaryshoppingbasket WHERE ID LIKE '".$id."'");
									 $a4printing = $a4printing->row_array();
									 if(isset($a4printing['Printing']) and $a4printing['Printing']=='Y'){
										 
										  if($a4printing['source'] == 'flash' and $qty < 25){
						 
												 $pricedata=$this->product_model->calculate_lba_price($qty, $menuId);
												 $totalprice = $pricedata['plainprice']; 
												 $unitprice = number_format($totalprice / $qty, 2);
												 $printprice = $pricedata['printprice'];
												 if($a4printing['Print_Type']=='Mono'){
													$printprice = $pricedata['printprice']-($pricedata['printprice']*0.05);   // 5% discount if Mono Printing
												 }
												 $A4Printing = array('Print_UnitPrice' => $printprice,
																	 'Print_Total' => $printprice,
																	 'TotalPrice' => $totalprice, 
																	 'UnitPrice' => $unitprice);
								       }else{
										 
										 $ProductBrand = $this->ProductBrand($menuId);
										 
										 $printprice = $this->home_model->calculate_printed_sheets($qty, $a4printing['Print_Type'], $a4printing['Print_Qty'], $ProductBrand, $menuId);
											$free_artworks = $printprice['artworks'];
											$designprice = $printprice['desginprice'];
											$printprice = $printprice['price'];
											
											if (preg_match("/A3 Labels/is", $ProductBrand) || preg_match("/SRA3 Labels/is", $ProductBrand)) {
													$printprice = $printprice*1.5;
											}
											$printprice = $printprice+$designprice;
											$A4Printing = array( 'Print_UnitPrice'=>$printprice,
																 'Print_Total'=>$printprice,
																 'Free'=>$free_artworks, );
										}
										
										 $this->db->update('integrated_attachments',array('qty'=>$qty), array('CartID'=>$id));
											$data = array_merge($data, $A4Printing);
									 }
						/****************Printed Labels Options*************/
 
					$update = $this->db->update('temporaryshoppingbasket', $data, array('ID' => $id, 'SessionID' => $SID));	
			
				$this->update_integrated_delivery_charges();
				$cart_data = $this->ajax_cart_load();
				$topcart_data = $this->ajax_topcart_load();
				$delivery_html = $this->ajax_delivery_content();
				$order_review_summary = $this->ajax_review_summary();
				
				
				$json_data = array('cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				$this->output->set_output(json_encode($json_data));
			}
	}
	function delete_product_cart(){
		if($_POST){
			$serial = $this->input->post('serial');
			$this->shopping_model->delete_product_cart($serial);
			$this->update_integrated_delivery_charges();
			$cart_data = $this->ajax_cart_load();
			$topcart_data = $this->ajax_topcart_load();
			
			$delivery_html = $this->ajax_delivery_content();
			$order_review_summary = $this->ajax_review_summary();
			
			$json_data = array('cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
			$this->output->set_output(json_encode($json_data));
		}
	}
	
	function update_delevery()
	{
		if($_POST){
				$dl_id = $this->input->post('deliveryid');
				$integrated = $this->shopping_model->is_order_integrated();
				$qry = $this->db->query("SELECT * FROM shippingservices WHERE ServiceID  = ".$dl_id." order by ServiceID asc");
				$res = $qry->result_array();
				
				$data['ServiceID'] = $res[0]['ServiceID'];
				$data['ServiceName'] = $res[0]['ServiceName'];
				$data['BasicCharges'] = $res[0]['BasicCharges'];
				$data['changeDrop'] = 1;
				
				if($integrated > 0)
				{
					$delivery_charges = $this->shopping_model->get_integrated_delivery_charges();
					if(isset($delivery_charges) and !empty($delivery_charges))
					{
						$integrated_charges = $delivery_charges*1.2;
					}
					
					$data['BasicCharges'] += $integrated_charges;
				}
				
				$this->session->set_userdata($data);
				$delivery_html = $this->ajax_delivery_content();
				$order_review_summary = $this->ajax_review_summary();
				
				$json_data = array('response'=>'yes','delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				$this->output->set_output(json_encode($json_data));
		}
	}
	
	function ajax_cart_load(){
		
		$data['cart_detail'] = $this->shopping_model->show_cart();
		$theHTMLResponse    = $this->load->view('shopping/cart', $data, true);
		$this->output->set_content_type('application/json');
		return $theHTMLResponse;
		
	}
	function ajax_topcart_load(){
	
		$theHTMLResponse    = $this->load->view('includes/top_cart','',true);
		$this->output->set_content_type('application/json');
		return $theHTMLResponse;
	}
	function ajax_delivery_content(){
		$theHTMLResponse    = $this->load->view('shopping/delivery_charges','',true);
		$this->output->set_content_type('application/json');
		return $theHTMLResponse;
		
	}
	
	function ajax_review_summary(){
		$theHTMLResponse    = $this->load->view('shopping/order_summary','',true);
		$this->output->set_content_type('application/json');
		return $theHTMLResponse;
		
	}


    function get_box_price()
    {
        $manufatureid = $this->input->post('manufature');
        $box = $this->input->post('box');
        $batch = $this->input->post('batch');
        $print = $this->input->post('print_option');
        $cart_id = $this->input->post('cart_id');
        $productid = $this->input->post('prd_id');
        $array = array('print_price' => 0.00, 'plain_price' => 0.00, 'black_price' => 0.00, 'total' => 0.00);
        if (isset($manufatureid) and isset($box) and $box != 0) {
            $price = $this->home_model->single_box_price($manufatureid, $box, $batch);
            //echo"<pre>";print_r($price);echo"</pre>";exit;
            if (isset($print)) {
                if (preg_match('/Mono/', $print)) {
                    $print = 'black';
                } else if (preg_match('/Digital/', $print)) {
                    $print = 'printed';
                } else {
                    $print = "";
                }
            }

            if (is_array($price)) {
                if (isset($print) and $print != '') {
                    if (isset($cart_id) and $cart_id != '') {
                        $design = $this->get_uploaded_number_design($cart_id, $productid);
                    } else {
                        $design = $this->get_number_design($productid);
                    }

                    if ($print == "black") {
                        $printprice = $this->home_model->calculate_printed_sheets($box, 'Mono', $design, 'A4 Labels');
                        $printprice['price'] = $this->home_model->currecy_converter($printprice['price'], 'yes');
                        $PrintPrice = 0.00;
                        $BlackPrice = sprintf('%.2f', round($printprice['price'], 2));
                        $print_option = "Mono";
                    } else if ($print == "printed") {
                        $printprice = $this->home_model->calculate_printed_sheets($box, 'Fullcolour', $design, 'A4 Labels');
                        $printprice['price'] = $this->home_model->currecy_converter($printprice['price'], 'yes');

                        $PrintPrice = sprintf('%.2f', round($printprice['price'], 2));
                        $BlackPrice = 0.00;
                        $print_option = "Fullcolour";
                    } else {
                        $PrintPrice = 0.00;
                        $BlackPrice = 0.00;
                    }
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $PrintPrice;
                }

                if ($box != $price['Sheets']) {
                    $perbox = $price['PlainPrice'] / $price['Box'];
                    $acc_boxes = $box / $batch;
                    $calculated_price = $acc_boxes * $perbox;
                    $price['PlainPrice'] = $calculated_price;
                }

                $plain_value = $price['PlainPrice'] = $this->home_model->currecy_converter($price['PlainPrice'], 'yes');
                $printprice = $this->home_model->currecy_converter($printprice, 'yes');
                $designprice = $this->home_model->currecy_converter($designprice, 'yes');

                $printed_price = $PrintPrice + $BlackPrice;
                $plain_price = $PlainPrice;
                $onlyprintprice = $printed_price;
                $total = $price['PlainPrice'] + $printed_price + $designprice;

                $dpd = $price['dpd'];

                $total = sprintf('%.2f', round($total, 2));
                $PlainPrice = sprintf('%.2f', round($price['PlainPrice'], 2));

                $array = array('print_price' => $printed_price,
                    'plain_price' => $PlainPrice,
                    'black_price' => $BlackPrice,
                    'total' => $total,
                    'per_sheet' => sprintf('%.4f', round($total / $box, 4)),
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'dpd' => number_format($dpd, 2),

                    'halfprintprice' => number_format($printed_price * 2, 2),
                    'printprice' => number_format($onlyprintprice, 2),
                    'designprice' => $designprice,
                    'artworks' => $free_artworks,
                    'nodesing' => $design,
                    'print_option' => $print_option,
                );
            }
        }
        echo json_encode($array);
        $this->save_browsing_history('integrated');
    }


	function get_box_price_old(){
		$manufatureid = $this->input->post('manufature');
		$box = $this->input->post('box');
		$batch = $this->input->post('batch');
		$print = $this->input->post('print_option');
		$cart_id = $this->input->post('cart_id');
		$productid = $this->input->post('prd_id');
		$array = array('print_price'=>0.00,'plain_price'=>0.00,'black_price'=>0.00,'total'=>0.00);
		if(isset($manufatureid) and isset($box) and $box!=0 ){ 
			$price = $this->home_model->single_box_price($manufatureid,$box,$batch);
			if(is_array($price)){
				 if(isset($print) and $print=='black'){
					 	 //$print_price =  $this->home_model->calculate_integrated_printing($box);
						 $printprice = $this->home_model->calculate_printed_sheets($box, 'Mono');
						 $printprice['price'] = $this->home_model->currecy_converter($printprice['price'], 'yes');
						 $PrintPrice =0.00;
						 $BlackPrice =sprintf('%.2f', round($printprice['price'],2));
					 
				 }
				 else if(isset($print)  and $print=='printed'){
						 //$print_price =  $this->home_model->calculate_integrated_printing($box);
						 $printprice = $this->home_model->calculate_printed_sheets($box, 'Fullcolour');
						 $printprice['price'] = $this->home_model->currecy_converter($printprice['price'], 'yes');
						 
						 $PrintPrice =sprintf('%.2f', round($printprice['price'],2));
						 $BlackPrice =0.00;
				 }else{
						 $PrintPrice =0.00;
					     $BlackPrice =0.00;
				 }
				 if($box != $price['Sheets'])
				 {
					 $perbox = $price['PlainPrice']/$price['Box'];
					 $acc_boxes = $box/$batch;
					 $calculated_price = $acc_boxes*$perbox;
					 $price['PlainPrice'] = $calculated_price;
				 }
				 $price['PlainPrice'] = $this->home_model->currecy_converter($price['PlainPrice'], 'yes');
				 $total = $price['PlainPrice']+ $PrintPrice+$BlackPrice;
				
				 $dpd = $price['dpd'];
				 
				 $total = sprintf('%.2f', round($total,2));
				 $PlainPrice = sprintf('%.2f', round($price['PlainPrice'],2));
				 $array = array('print_price' => $PrintPrice,
				 			    'plain_price' => $PlainPrice,
								'black_price' => $BlackPrice,
								'total' => $total,
								'per_sheet' => sprintf('%.4f', round($total/$box,4)),
								'symbol' => symbol,
								'vatoption' => vatoption,
								'dpd' => number_format($dpd,2),
								);
			}
		 }
	  	echo json_encode($array);
	}
	function add_integrate_incart(){
		
		$productid = $this->input->post('prdid');
		$manufatureid = $this->input->post('manufature');
		$qty = $this->input->post('box');
		$printed = $this->input->post('type');
		$print = $this->input->post('print_option');
		$batch = $this->input->post('batch');
		$cart_id = $this->input->post('cart_id');
		$type ='';$labeltype = '';
		if(isset($manufatureid) and isset($qty) and $qty!=0 ){ 
			$price = $this->home_model->single_box_price($manufatureid,$qty,$batch);
			$dpd = $price['dpd'];
			if($qty != $price['Sheets'])
			{
				 $perbox = $price['PlainPrice']/$price['Box'];
				 $acc_boxes = $qty/$batch;
				 $calculated_price = $acc_boxes*$perbox;
				 $price['PlainPrice'] = $calculated_price;
			}
			
			$totalprice = $price['PlainPrice'];
			if(isset($print))
			{
				if(preg_match('/Mono/',$print))
				{
					$print ='black';
				}
				else if(preg_match('/Digital/',$print))
				{
					$print ='printed';
				}
				else
				{
					$print = "";
				}
			}
			
			if($print=='printed'){ $labeltype = 'Fullcolour';}
			else if($print=='black'){ $labeltype = 'Mono';}
			
			$A4Printing = array();
			if(isset($labeltype) and ($labeltype=='Mono' || $labeltype=='Fullcolour')){
				
				if(isset($cart_id) and $cart_id!=''){
					$design = $this->get_uploaded_number_design($cart_id, $productid);
				}else{
					$design = $this->get_number_design($productid);
				}
				
				$designprice = 0.00;
				$printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design,'A4 Labels');
				$free_artworks = $printprice['artworks'];
				$designprice = $printprice['desginprice'];
				$printprice = $printprice['price'];
				
				$printprice = $printprice+$designprice;
				
				$Print_Design = '1 Design';
				if($design > 1){
					$Print_Design = 'Multiple Designs';
				}
				
				if($labeltype=='Mono'){
					$labeltype = 'Monochrome – Black Only';
				}else{
					$labeltype = '4 Colour Digital Process';
				}
				$A4Printing = array( 'Printing'=>'Y',
									 'Print_Type'=>$labeltype,
									 'Print_Design'=>$Print_Design,
									 'Free'=>$free_artworks,
									 'Print_Qty'=>$design,
									 'Print_UnitPrice'=>$printprice,
									 'Print_Total'=>$printprice);
			}
							
			$unitprice = $totalprice/$qty;
			$SID  =  $this->shopping_model->sessionid();
			
			$page_loc = "Integrated Labels";
			if(isset($page) and $page == "reorder")
			{
				$page_loc = "User Reorder";
			}
			$items = array('SessionID'=>$SID,
								 'ProductID'=>$productid,
								 'Quantity'=>$qty,
								 'orignalQty'=>$batch,
								 'UnitPrice'=>$unitprice,
								 'TotalPrice'=>$totalprice,
								 'page_location'=>$page_loc
						  );
		   $items = array_merge($items,$A4Printing);
		   $userID = $this->session->userdata('userid');
			if(isset($userID) and $userID != '')
			{
				$cart_reminder = $this->home_model->get_db_column("customers","cart_reminder","UserID",$userID);
				if(isset($cart_reminder) and $cart_reminder == "Y")
				{
					$items['UserID'] = $userID;
				}
			}
			
		   $this->db->insert('temporaryshoppingbasket',$items);
		   
		   if($this->db->insert_id()){
				if($printed=='printed' || $printed=='black'){ 
					if(isset($design) and $design > 0){
						$data = array( 'CartID' => $this->db->insert_id(),'status' => 'confirm','SessionID'=>$SID);
						$update = $this->db->update('integrated_attachments', $data, array('SessionID' => $SID.'-PRJB', 'ProductID' => $productid,'CartID'=>$cart_id));
					}
				}
				$this->update_integrated_delivery_charges();
				$topcart_data = $this->ajax_topcart_load();
				$this->output->set_output(json_encode(array('top_cart'=>$topcart_data)));
			}
		}
	}
	/**---------------------------------***/
	
	
	/******************Label Finder*************/
		function labelsfindershapes(){
		
		if($_POST){
				
				$category = $this->input->post('category');
				$page = $this->input->post('page');
				
				$brand = $this->home_model->make_productBrand_condtion($category);
				$condtion = "c.CategoryActive = 'Y' AND c.Shape != '' AND p.ProductBrand LIKE '".$brand."'";
                                if($category=='Avery'){
					$condtion .= " AND c.LabelEquivalentAvery !='' ";	
			        } 
					
					if($page=='designer'){
                     $condtion .= " AND c.FlashActive = 'Y' AND p.activeFlash = 'Y' ";		
					}                     
				$shape_list = $shape_list = $this->home_model->category_shapes($condtion);
				
				$option_text = 'Label Shape';
				if($category=='Integrated'){
					$option_text = 'Label Bullet';
				}
				
				
				$groupby ='';
				if($category=='Roll'){$groupby = " Group By LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ) "; }
				
				
				/******* New finder implemenations **********/
					if($page=='finder'){
							$shape_option = $this->home_model->genrate_shapes($shape_list);
					}
					else{
							$shape_option = $this->home_model->make_html_option($shape_list,'Shapes',$option_text);
					}
				/******* New finder implemenations **********/
				
				
				$count = $this->home_model->labelfinder_counter($condtion,$groupby);
				
				if($page=='finder'){
						$data['results'] = $this->home_model->labelfinder_data($condtion,'','',$groupby);
						$theHTMLResponse    = $this->load->view('labelfinder/product_list', $data, true);
					
				}else{
					
						$theHTMLResponse ='';
				}
				$this->output->set_content_type('application/json');
				
				$json_data = array('response'=>'yes','shapes'=>$shape_option,'count'=>$count,'count_format'=>number_format($count),'html'=>$theHTMLResponse);
				$this->output->set_output(json_encode($json_data));
			
		}
	
	}
	
	function labelsfinderfields(){
			
        if ($_POST) {

            $shape = $color = $finish = $material = $adhesive = $printer = $width = $height = '';

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
			
			
			if($category=='thermal'){
				$category = 'Roll';
				if(isset($trigger) and $trigger=='model'){
					$model = $this->input->post('model');
					$query = $this->db->query("SELECT * FROM `printers_model` WHERE model LIKE '" .  urldecode($model) . "' ");
					$row = $query->row_array();
           			$printer_width = ($row['PrintWidth'])?$row['PrintWidth']:'';
					$data['printer_model'] = $row;
           			$printer_desc = $this->load->view('roll_printer/model_desc', $data, true);
				}
				if(isset($printer_width) and $printer_width!=''){
					$condtion = " c.Width <= $printer_width AND ";
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
						$condtion .= " c.CategoryID IN (".$rel_prd_string.") AND ";
					}
				}
			}
			
			$brand = $this->home_model->make_productBrand_condtion($category);
			$condtion .= " c.CategoryActive = 'Y' AND c.Shape != '' AND p.ProductBrand LIKE '" . $brand . "' ";
			
			
			if(isset($material_code) and $material_code!=''){
					$condtion .= " AND p.ManufactureID LIKE '%" . $material_code . "%' ";	
			}
			
			if($page=='designer'){
				$condtion .= " AND c.FlashActive = 'Y' AND p.activeFlash = 'Y' ";	
			}
			
			
			
			if($category=='Avery'){
					$condtion .= " AND c.LabelEquivalentAvery !='' ";	
			}
			
			
			if(isset($cornerradius) and $cornerradius=='sharp'){ 			 //0 radius
				$condtion .= " AND (c.LabelCornerRadius LIKE '0 mm' )";	
			}
			
			if(isset($cornerradius) and $cornerradius=='rounded'){ 			 // greater than 0 radius
				$condtion .= " AND (c.LabelCornerRadius NOT LIKE '0 mm' )";	
			}
			
			
			
			
			/*$shape_list = $shape_list = $this->home_model->category_shapes($condtion);
			$shape_option = $this->home_model->genrate_shapes($shape_list);*/
			
			

            $option_text = 'Label Shape';
            if ($category == 'Integrated') {
                $option_text = 'Label Bullet';
            }


            if (isset($shape_sel) and strlen($shape_sel) > 0) {
                $shape = " AND c.Shape LIKE '" . $shape_sel . "' ";
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
                $width = " AND c.Width LIKE '" . $width_sel . "' ";
            }
            if (isset($height_sel) and strlen($height_sel) > 0) {
                $height = " AND c.Height LIKE '" . $height_sel . "' ";
            }




       $shape_list = $shape_list = $this->home_model->category_shapes($condtion);
	    if (isset($trigger) and $trigger == 'autoload' || $trigger == 'category' || $trigger == 'model' || $trigger == 'brands' and ($page == 'finder' ||$page == 'designer' )) {
			$shape_option = $this->home_model->genrate_shapes($shape_list, $shape_sel);
	   } else {
			$shape_option = $this->home_model->make_html_option($shape_list, 'Shapes', $option_text, $shape_sel);
	   }


            if ($page == 'finder' || $page == 'designer') {


                $height_min = $this->input->post('height_min');
                $height_max = $this->input->post('height_max');

                $width_min = $this->input->post('width_min');
                $width_max = $this->input->post('width_max');


                 if (isset($width_min) and $width_min != '' and $width_min > 0) {
                   		
						if(isset($opposite) and $opposite=='true'){
							 $opposite_height = " AND FLOOR(c.Height) >= ".floor($width_min);
						}
						$width = " AND FLOOR(c.Width) >= ".floor($width_min);
						
						
				
				}
                if (isset($width_max) and $width_max != '' and $width_max > 0) {
                   
				 	    $width .= " AND CEIL(c.Width) <= " . ceil($width_max). " ";
					    if(isset($opposite) and $opposite=='true'){
							 $opposite_height .= " AND FLOOR(c.Height) <= ".ceil($width_max);
						}
						
						
				}

                  if($page == 'designer') { 
                $adhesive = $adhesive_sel;
                    if (isset($adhesive_sel) and strlen($adhesive_sel) > 0 and $adhesive_sel != '') {
                      if($adhesive) {
                       $adhesive = " AND p.Adhesive LIKE '".$adhesive."' ";
                      }
                    }
			}
			else{ 
			   $adhesive = '';	
			   if (isset($adhesive_sel) and strlen($adhesive_sel) > 0 and $adhesive_sel != '') {
			   $adhesive_sel = substr($adhesive_sel, 0, -1);
               $releted_arr = explode(",", $adhesive_sel);
               $adhesive = "'" . implode("','", $releted_arr) . "'";
                if($adhesive) {
                   $adhesive = " AND p.Adhesive IN (" . $adhesive . ") ";
                 }
		      }
		 }
		 
		 

                if ($shape_sel != 'Circular' and $shape_sel != 'Square') {

                     if (isset($height_min) and $height_min != '' and $height_min > 0) {
                   
				   	    $height = " AND FLOOR(c.Height) >= " . floor($height_min). " ";
						if(isset($opposite) and $opposite=='true'){
								$opposite_width = " AND  CEIL(c.Width) >= " . floor($height_min);
						}
					}
                     if (isset($height_max) and $height_max != '' and $height_max > 0) {
                    	
							$height .= " AND CEIL(c.Height) <= " . ceil($height_max);
							if(isset($opposite) and $opposite=='true'){
									$opposite_width .= " AND  CEIL(c.Width) <= " . ceil($height_max);
							}
				    }


                   $heightcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $width;

                    if (isset($trigger) and $trigger == 'autoload') {
                        $heightcondtion = $heightcondtion . $height;
                    }

                    $height_range = $this->home_model->get_min_width_height('c.Height', $heightcondtion);
                    $min_height = $height_range['min'];
                    $max_height = $height_range['max'];
                }



                $widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $height;
                if (isset($trigger) and $trigger == 'autoload') {
                    $widthcondtion = $widthcondtion . $width;
                }
                $width_range = $this->home_model->get_min_width_height('c.Width', $widthcondtion);

                $min_width = $width_range['min'];
                $max_width = $width_range['max'];

               if($page == 'designer') { 
				$adhesive_condtion = $condtion . $shape . $color . $material . $finish . $printer . $height . $width;
                $adhesive_list = $this->home_model->labelsfinder_field_list('p.Adhesive', $adhesive_condtion);
                $adhesive_option = $this->home_model->make_html_option($adhesive_list, 'Adhesive', ' Select Adhesive', $adhesive_sel); 
			  }else{ 
			    $adhesive_condtion = $condtion . $shape . $color . $material . $finish . $printer . $height . $width;
                $adhesive_list = $this->home_model->labelsfinder_field_list('p.Adhesive', $adhesive_condtion);
                $adhesive_option = $this->home_model->genrate_adhesive_options($adhesive_list, $adhesive_sel);
				
                $adhesive_select = $adhesive_option['selected'];
                $adhesive_option = $adhesive_option['options'];  
			   }
            } else {



                if ($shape_sel == 'Circular' || $shape_sel == 'Square') {
                    if ($shape_sel == 'Circular') {
                        $option_text = 'Label Diameter';
                    } else {
                        $option_text = 'Label Width';
                    }
                    $Widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $height;
                    $width_list = $this->home_model->labelsfinder_field_list('c.Width', $Widthcondtion);
                    $width_option = $this->home_model->make_size_option($width_list, 'Width', $option_text, $width_sel);
                    $height_option = '';
                } else {

                    $Widthcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $height;
                    $width_list = $this->home_model->labelsfinder_field_list('c.Width', $Widthcondtion);
                    $width_option = $this->home_model->make_size_option($width_list, 'Width', 'Width mm', $width_sel);

                    $heightcondtion = $condtion . $shape . $finish . $material . $color . $adhesive . $printer . $width;
                    $height_list = $this->home_model->labelsfinder_field_list('c.Height', $heightcondtion);
                    $height_option = $this->home_model->make_size_option($height_list, 'Height', 'Height mm', $height_sel);
                }


                $adhesive_condtion = $condtion . $shape . $color . $material . $finish . $printer . $height . $width;
                $adhesive_list = $this->home_model->labelsfinder_field_list('p.Adhesive', $adhesive_condtion);
                $adhesive_option = $this->home_model->make_html_option($adhesive_list, 'Adhesive', ' Adhesive', $adhesive_sel);
            }




            $width_height = $height . $width;
			
			if(isset($opposite) and $opposite=='true'){
				   if($opposite_width!='' and $opposite_height!=''){
				  	   $width_height =   ' AND ( ( 1 = 1 '.$width. $height .' ) OR  ( 1 = 1 '.$opposite_width . $opposite_height.' ) ) '; 
				   }
				  
			}
			
			

            $color_condtion = $condtion . $shape . $finish . $material . $adhesive . $printer . $width_height;
            $color_list = $this->home_model->labelsfinder_field_list('p.LabelColor_upd', $color_condtion);
            $color_option = $this->home_model->make_html_option($color_list, 'LabelColor_upd', 'Label Colour', $color_sel);


            $finish_condtion = $condtion . $shape . $color . $material . $adhesive . $printer . $width_height;
            $finish_list = $this->home_model->labelsfinder_field_list('p.LabelFinish_upd', $finish_condtion);
            $finish_option = $this->home_model->make_html_option($finish_list, 'LabelFinish_upd', 'Label Finish', $finish_sel);

            $material_condtion = $condtion . $shape . $color . $finish . $adhesive . $printer . $width_height;
            $material_list = $this->home_model->labelsfinder_field_list('p.ColourMaterial_upd', $material_condtion);
            $material_option = $this->home_model->make_html_option($material_list, 'ColourMaterial_upd', 'Label Material', $material_sel);

            $printer_condtion = $condtion . $shape . $color . $material . $adhesive . $finish . $width_height;
            $printer_list = $this->home_model->labelsfinder_field_list('p.SpecText7', $printer_condtion);
            $printer_option = $this->home_model->make_html_option($printer_list, 'SpecText7', ' Printer / Copier Type ', $printer_sel);


           

            $final_condition = $condtion . $shape . $color . $material . $adhesive . $finish . $printer . $width_height;
            

            $groupby = '';
            if ($category == 'Roll') {
                $groupby = " Group By LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ) ";
            }



            $count = $this->home_model->labelfinder_counter($final_condition, $groupby,$div_open);
			$theHTMLResponse = '';
            
			if ($page == 'finder' || $page == 'designer') {
                 $wholesale = $this->input->post('wholesale');
				$data['wholesale'] = (isset($wholesale) and $wholesale=='enable')?'enable':'';

                if($page == 'designer'){
					   $limiter = ($div_open=='slide')?'75':'12';
					   $data['records'] = $this->home_model->labelfinder_data($final_condition,'','',$groupby,$limiter,$div_open);
						if($div_open=='slide'){
							  $template = $this->session->userdata('template');
						    if(isset($template) && $template!=""){
						        $data['select'] = $this->home_model->get_selected_template($template);
						      }	
						  $theHTMLResponse = $this->load->view('labeldesigner/slider_category_list', $data, true);
						}else{
                   	 	  $theHTMLResponse = $this->load->view('labeldesigner/category_list', $data, true);
						}
						$view =  'product';
				}
				else if($printer=='' and $color=='' and  $material =='' and $finish =='' and $adhesive=='' and $category != 'Integrated'){
						$data['records'] = $this->home_model->fetch_dies_data($final_condition, '');
                   	 	$theHTMLResponse = $this->load->view('category/category_list', $data, true);
                   		$count =  $data['records']['num_row'];
						$view =  'category';
					
                }else{
						$data['results'] = $this->home_model->labelfinder_data($final_condition, '', '', $groupby);
						$theHTMLResponse = $this->load->view('labelfinder/product_list', $data, true);
						$view =  'product';
                }
			
			    if ($count == 0) {
                    $theHTMLResponse = '<div class="row"><div class="thumbnail">';
                    $theHTMLResponse .='<div class="col-sm-2 col-md-2 col-lg-2 norecords"><h3><i class="fa fa-5x fa-warning"></h3></i></div>';
                    $theHTMLResponse .='<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 ">';
                    $theHTMLResponse .='<h2  style="text-align:center;">No Results  </h2>';
                    $theHTMLResponse .='<h3  style="text-align:center;">Change your criteria using the filtering options above</h3></div>';
                    $theHTMLResponse .='</div></div>';
                }
            }

        
            $json_data = array('response' => 'yes',
				'brands_list'=>$brands_list,
				'shapes' => $shape_option,
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
                'html' => $theHTMLResponse);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }
    } 
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
			
			if($category=='thermal'){
				$category = 'Roll';
				if(isset($printer_width) and $printer_width!=''){
					$condtion = " c.Width <= $printer_width AND ";
				}
			}	
			
			
            $brand = $this->home_model->make_productBrand_condtion($category);
            if ($category == 'Roll') {
                $groupby = " Group By LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ) ";
            }

            $condtion .= " c.CategoryActive = 'Y' AND p.ProductBrand LIKE '" . $brand . "' ";

           if(isset($material_code) and $material_code!=''){
					$condtion .= " AND p.ManufactureID LIKE '%" . $material_code . "%' ";	
			}

		   if($page=='designer'){
				$condtion .= " AND c.FlashActive = 'Y' AND p.activeFlash = 'Y' ";	
			}
			
			
			
            if($category=='Avery'){
					$condtion .= " AND c.LabelEquivalentAvery !='' ";	
			}
			
            if(isset($cornerradius) and $cornerradius=='sharp'){ 			 //0 radius
				$condtion .= " AND (c.LabelCornerRadius LIKE '0 mm' )";	
			}
			
			if(isset($cornerradius) and $cornerradius=='rounded'){ 			 // greater than 0 radius
				$condtion .= " AND (c.LabelCornerRadius NOT LIKE '0 mm' )";	
			}
			
			

            if (isset($shape_sel) and strlen($shape_sel) > 0) {
                $shape = " AND c.Shape LIKE '" . $shape_sel . "' ";
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
							 $opposite_height = " AND FLOOR(c.Height) >= ".floor($width_min);
						}
						$width = " AND FLOOR(c.Width) >= ".floor($width_min);
						
						
				
				}
                if (isset($width_max) and $width_max != '' and $width_max > 0) {
                   
				 	    $width .= " AND CEIL(c.Width) <= " . ceil($width_max). " ";
					    if(isset($opposite) and $opposite=='true'){
							 $opposite_height .= " AND FLOOR(c.Height) <= ".ceil($width_max);
						}
						
						
				}
				
				if ($shape_sel != 'Circular' and $shape_sel != 'Square') {
					 if (isset($height_min) and $height_min != '' and $height_min > 0) {
                   
				   	    $height = " AND FLOOR(c.Height) >= " . floor($height_min). " ";
						if(isset($opposite) and $opposite=='true'){
								$opposite_width = " AND  CEIL(c.Width) >= " . floor($height_min);
						}
					}
                    if (isset($height_max) and $height_max != '' and $height_max > 0) {
                    	
							$height .= " AND CEIL(c.Height) <= " . ceil($height_max);
							if(isset($opposite) and $opposite=='true'){
									$opposite_width .= " AND  CEIL(c.Width) <= " . ceil($height_max);
							}
				    }
					
					
				}
						

                if($page == 'designer') {
                $adhesive = $adhesive_sel;
                    if (isset($adhesive_sel) and strlen($adhesive_sel) > 0 and $adhesive_sel != '') {
                      if($adhesive) {
                       $adhesive = " AND p.Adhesive LIKE '".$adhesive."' ";
                      }
                    }
			}
			else{
			   $adhesive = '';	
			   if (isset($adhesive_sel) and strlen($adhesive_sel) > 0 and $adhesive_sel != '') {
			   $adhesive_sel = substr($adhesive_sel, 0, -1);
               $releted_arr = explode(",", $adhesive_sel);
               $adhesive = "'" . implode("','", $releted_arr) . "'";
                if($adhesive) {
                   $adhesive = " AND p.Adhesive IN (" . $adhesive . ") ";
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
			
            $data['results'] = $this->home_model->labelfinder_data($final_condition, '', $start, $groupby,'',$div_open);
            
			$wholesale = $this->input->post('wholesale');
			$data['wholesale'] = (isset($wholesale) and $wholesale=='enable')?'enable':'';
				
			 if($page == 'designer'){
				$data['records'] = $data['results'];
				$theHTMLResponse = $this->load->view('labeldesigner/category_list', $data, true);
			 }else{
			  $theHTMLResponse = $this->load->view('labelfinder/product_list', $data, true);
			 }
			 

            $json_data = array('response' => 'yes', 'html' => $theHTMLResponse);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }
    }
	

	
	function get_printer_model(){

        $make = $this->input->post('make');
		$trigger = $this->input->post('trigger');
		$option = '<option value="" >Select Model</option>';
        $count = 0;
		if(isset($trigger) and $trigger=='printers') {
			   $option = '<option value="" >Select Manufacturer</option>';
			   $htm = '<div class="row"><div class="printer m-t-10 row">';
			   $printers =  $this->home_model->get_printer();
			   foreach($printers as $make){
			  	   $option .= '<option value="' .strtolower($make->ManufacturerCode). '" >' . $make->Name . '</option>';
				   $htm .= '<div data-value="'.strtolower($make->ManufacturerCode).'" class="col-xs-6 col-md-2 text-center manufaturer">';
                   $htm .= '<span class="thumbnail"  >';
                   $htm .= '<img alt="" src="'.Assets.'images/printer/make/'.$make->printer_image.'">'.$make->Name.'</span></div>';
			   }
			   $htm .='</div></div>';  
			   $count=count($printers);   
		}	
		else if ($make) {

			$model = $this->home_model->get_printer_model($make);
            $htm = '<div class="row"><div class="printer m-t-10 row">';
            foreach ($model as $row) {

                $row->method = str_replace("/", ",", $row->method);
                $option .= '<option value="' . urlencode(strtolower($row->model)) . '" >' . $row->Name . '</option>';
                $htm .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 ">';
                $htm .= '<div class="thumbnail">';
                $htm .= '<div class=" text-center">';
                error_reporting(0);
                if (getimagesize(ARTPATH . 'images/printer/model/' . $row->image) !== false) {
                    $src = Assets . 'images/printer/model/' . $row->image;
                } else {
                    $src = Assets . 'images/no-image.png';
                }
                if ($row->specfication != "") {
                    $spec = substr($row->specfication, 0, 100);
                } else {
                    $spec = "";
                }
                $htm .= '<img width="185" height="155" title="' . $row->image . '" src="' . $src . '" alt="labels Image "></div>';

                $htm .= '<div class="caption3">';
                $htm .= '<h2>' . $row->Name . '</h2>';
                $htm .= '<p><small>' . $spec . '</small></p>';
                $htm .= '<div class="row">';
                $htm .= '<p class="col-md-12"><strong>Compatibility:</strong> ' . $row->method . '</p> ';
                $htm .= '<p class="col-md-12"><strong>Maximum Print Size:</strong> ' . $row->PrintWidth . ' mm</p></div>';
                $htm .= '<a data-value="'.urlencode(strtolower($row->model)).'" id="' . $row->model . '" role="button" class="btn-block btn orange printer_model" >';
				$htm .= '<i class="fa fa-arrow-circle-right"></i> Select </a></div></div></div>';
             
            }  
               $htm .= '</div></div>';
        	
			$count=count($model);
		}
		echo json_encode(array('model_data'=>$htm,'model'=>$option,'count_format'=>number_format($count,0)));
    }
	
	function get_roll_against_model(){
		
		$model = urldecode($this->input->post('model'));
		$shape = $this->input->post('shape');
		$width_sel = $this->input->post('width');
		$height_sel = $this->input->post('height');
		
		$query = $this->db->query("SELECT * FROM `printers_model` WHERE model LIKE '".$model."' ");
		$row  = $query ->row_array();
		$width = $row['PrintWidth'];
		
		$condition = '';
		$shape_con = '';
		$width_con = '';
		$height_con ='';
		
		$condition = " p.ProductBrand LIKE 'Roll Labels' AND c.CategoryActive='Y' AND c.Width <= $width";
		
		if(isset($shape) and strlen($shape) > 0){
				$shape_con = " AND c.Shape LIKE '".$shape."' ";
		}
	
		if(isset($width_sel) and strlen($width_sel) > 0){
				$width_con =" AND c.Width LIKE '".$width_sel."' "; 
			}
			if(isset($height_sel) and strlen($height_sel) > 0){
				$height_con =" AND c.Height LIKE '".$height_sel."' "; 
			}
			
			
			if($shape=='Circular' || $shape=='Square'){
				
				if($shape=='Circular'){
					$option_text = 'Label Diameter';
				}else{
					$option_text = 'Label Width';
				}
				
				$width_list = $this->home_model->labelsfinder_field_list('c.Width',$condition.$shape_con.$height_con);
				$width_option = $this->home_model->make_size_option($width_list,'Width',$option_text,$width_sel);
				$height_option = '';
			
			}else{
				
				 $width_list = $this->home_model->labelsfinder_field_list('c.Width',$condition.$shape_con.$height_con);
				 $width_option = $this->home_model->make_size_option($width_list,'Width','Width mm',$width_sel);
			
				 $height_list = $this->home_model->labelsfinder_field_list('c.Height',$condition.$shape_con.$width_con);
				 $height_option = $this->home_model->make_size_option($height_list,'Height','Height mm',$height_sel);
		}
				
		
		$shape_list = $shape_list = $this->home_model->category_shapes($condition.$width_con.$height_con);
	
		$option = $this->home_model->make_html_option($shape_list,'Shapes',' Select Shapes ',$shape);
		
		$condition = $condition.$shape_con.$width_con.$height_con;
		
       $theHTMLResponse  = '';$html_model ='';
	   
	   
	   if(isset($shape) and strlen($shape) > 0){
		   
		    $data['printer_model'] = $row;
			$data['records'] = $this->home_model->fetch_dies_data($condition);
			$theHTMLResponse    = $this->load->view('category/category_list', $data, true);
			$html_model    = $this->load->view('roll_printer/model_desc', $data, true);
		}
		
		
		
		$json_data = array('roll_data'=>$theHTMLResponse,'shapes'=>$option,'width'=>$width_option,'height'=>$height_option,'model_dec'=>$html_model);
		
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
		
	}
	function set_printer_model(){
			$model = $this->input->post('model');
			$catid = $this->input->post('catid');	
			if(isset($model) and $catid!=''){
				//$this->session->set_userdata('printer_model',$model);
				//$this->session->set_userdata('printer_cat',$catid);
			}
			echo "set";
			
	}
	function autocomplete_search(){
		
			
			$response = $this->home_model->auto_search();
			$results = array();
			if(count($response['results'])>0){
				foreach($response['results'] as $row){
					$url = '';
					if($response['tbl']=='product'){
							if(preg_match("/Roll/",$row->ProductBrand)){
								 $url = base_url().'roll-labels/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'?productid='.$row->ProductID;   
							}
                            else if(substr($row->ManufactureID,-2,2)=='XS'){
								$url = base_url().'christmas-labels/'; 
							}
							else if(preg_match("/SRA3/",$row->ProductBrand)){
								 $url = base_url().'sra3-sheets/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'?productid='.$row->ProductID;  
							}
							else if(preg_match("/A3/",$row->ProductBrand)){
								 $url = base_url().'a3-sheets/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'?productid='.$row->ProductID;  
							}
							else if(preg_match("/Integrated/",$row->ProductBrand)){
								 $url = base_url().'integrated-labels/'.strtolower($row->CategoryID).'/'; 
							}
							else if(preg_match("/Application Labels/",$row->ProductBrand)){
								 $url = $this->home_model->make_lba_product_url($row->CategoryID, 'product'); 
							}
                                                        
							else{
								 $url = base_url().'a4-sheets/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'?productid='.$row->ProductID;  
							}
						
						$name = $row->ProductCategoryName;
						
					}
					else if($response['tbl']=='lba-category'){
						$name = $row->name;
						$url = base_url().'labels-by-application/'.strtolower(str_replace(" ","-", $row->name)).'/';  
					}
					else{
							if(preg_match("/Roll/",$row->CategoryName)){
								 $url = base_url().'roll-labels/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'/';  
							}
							else if(preg_match("/SRA3/",$row->CategoryName)){
								 $url = base_url().'sra3-sheets/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'/';  
							}
							else if(preg_match("/A3/",$row->CategoryName)){
								 $url = base_url().'a3-sheets/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'/';
							}
							else if(preg_match("/Integrated/",$row->Shape)){
								 $url = base_url().'integrated-labels/'.strtolower($row->CategoryID).'/'; 
							}
							else if(preg_match("/Application Labels/",$row->labelCategory)){
								 $url = $this->home_model->make_lba_product_url($row->CategoryID); 
							}
							else{
								 $url = base_url().'a4-sheets/'.strtolower($row->Shape).'/'.strtolower($row->CategoryID).'/';  
							}
							
						//$url = base_url().'home/material/'.$row->CategoryID;
						$name = $row->CategoryName;
					}
					
					
					$results['mylist'][] = array('name'=>$name,'url'=>$url);
				}
			}
			else{
					$results['mylist'][] =array('resposne'=>'empty');
			}
			echo json_encode($results);
		
	}
	
	function autocomplete_search_printer(){
		
			$resilt = $this->home_model->auto_search_printer();
			$results = array();
			if(count($resilt)>0){
				foreach($resilt as $row){
					
					$url = base_url().'thermal-printer-roll-labels?make='.urlencode($row->ManufacturerCode).'&model='.urlencode($row->model);
					$results['mylist'][] = array('name'=>$row->Name,'url'=>$url);
				}
			}
			else{
					$results['mylist'][] =array('resposne'=>'empty');
			}
			echo json_encode($results);
		
	}
	
	function address_lookup(){
		
		
			$searchKey = 'PCWPV-487YX-6R27Q-HMXFT';
			$serviceURL = 'PostCoderWeb.php';
            $identifier = rawurlencode('v3 PHP JS Example');
			$lines = 3;
			$method  ='address';
			
			if(isset($_GET['search'])){ $searchterm = rawurlencode($_GET['search']); }
			
			$RestURL = 'http://ws.postcoder.com/pcw/' . $searchKey .'/' . $method . '/UK/' . $searchterm . '?identifier=' . $identifier . '&lines=' . $lines;

			$session = curl_init($RestURL); 
			curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($session, CURLOPT_HEADER, 1);
			$headers = array(
				'Content-Type: application/json'
			);
			curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($session);
			$header_size = curl_getinfo($session, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);
			curl_close($session);
			$headers = explode("\n",$header);
			foreach($headers as $h){
				header($h);
			}
			//echo $body;
			//exit();
			$headers = array(
					'http' => array(
					'method' => "GET",
					'header' => "Content-Type: application/json")
			);
			
			$context = stream_context_create($headers);
			$response = file_get_contents($RestURL, false, $context);
			
			$response = json_decode($response, true);
			
			echo $response;
		
	}
	
	
	
	 function setwoundoption(){
		$option = $this->input->post('option');
	    $cate = $this->input->post('cate');
		$this->session->set_userdata('wound',$option);
		$this->session->set_userdata('wound-cat',$cate);
		 
	 }
	 
	 
	 /*------User controller function --------*/
	 
	 function user_login(){
		  //print_r(11); exit;
		   
		  	$msg = 'error'; $url =''; $templateID='';$name = '';$userid = '';
		    $email = $this->input->post('email', true);
			$page = $this->input->post('page');
			$newsletter = $this->input->post('newsletter_val');
			
            $password 	= md5($this->input->post('password', true));
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if($this->form_validation->run() == true){
					    
						$userdata = $this->user_model->validate_login($email,$password);
						if($userdata['total'] > 0){
						    
						          $checkoutdata['checkoutdata'] = '';
								  $this->session->unset_userdata($checkoutdata);
							      
							      $userid=$userdata['UserID'];
								  $msg = 'sucess';	
								  $newdata = array(  
												'userid'  => $userdata['UserID'],
												'UserName'  => $userdata['BillingFirstName'],
												'logged_in' => true
											);
							       $this->session->set_userdata($newdata);
								 //new coding
									$userid = $this->session->userdata('userid');
									$session_id = $this->session->userdata('session_id');
									$this->db->update('flash_user_design',array('UserID'=>$userid), array('SID'=>$session_id,'UserID'=>0));
								  //new coding


								   /***** newsletter Signup  ***/
									   if(isset($newsletter) and $newsletter=='on'){
											$this->home_model->newsletter($user_email);
										}
									/***** newsletter Signup  ***/

									if(isset($page) and $page == 'checkout'){
											$this->session->set_userdata('animate','yes');
											$url = SAURL.'transactionregistration.php';		
									}
									elseif($page == 'flash')
									{
										$templateID = $this->session->userdata('template');
										$name = $userdata['BillingFirstName'];
									}elseif($page == 'lba')
									{
										$templateID = $this->session->userdata('label_id');
										$name = $userdata['BillingFirstName'];
									}
									else{
											$url = SAURL.'users/user_account';
									}
									
									
									$cart_count = $this->shopping_model->cart_count();
									if(isset($cart_count) and $cart_count > 0)
									{
										$cart_reminder = $this->home_model->get_db_column("customers","cart_reminder","UserID",$userid);
										if(isset($cart_reminder) and $cart_reminder == "Y")
										{
											$cart_data = $this->shopping_model->show_cart();
											if($cart_data)
											{
												$this->db->where('SessionID',$session_id);
												$this->db->update('temporaryshoppingbasket',array('UserID'=>$userid));
											}
										}
									}
									
									
									
						}
			
			}
			
		echo json_encode(array('response'=>$msg,'url'=>$url,'template'=>$templateID,'username'=>$name,'userid'=>$userid));
			
		 
	 } 
	 
	 function user_password_ajax(){
		
		$id=$this->session->userdata('userid');
		if($id==''){ redirect(base_url());}
			$pass =  $this->input->post('password',true);
			$re_pass = $this->input->post('cpassword',true);
			$old_pass =  $this->input->post('current_pass',true);
			
			$response =  $this->user_model->validate_userpass(md5($old_pass));
			if($response==true){
						$msg = $this->user_model->update_user_pass(md5($re_pass));
						$class ='success'; 	
			}
			else{
					  $class ='warning'; 	
					  $msg =  "Current password is Wrong!";
			}
			echo json_encode(array('class'=>$class,'msg'=>$msg));
	}
	function is_email_exist(){
		
		$msg = "false";
		if($_GET){
			$email = $this->input->get('email');
			if($email == '')
			{
				$email = $this->input->get('email_reg');
			}
			
			$count = $this->user_model->email_validate($email);
			if($count == 0){
				$msg = "true";
			}
		}	
		echo $msg; 
	 }
	 function is_valid_captcha(){
		
		$msg = "true";
		$captcha = $this->input->get('captcha');
		if (empty($_SESSION['captcha']) || trim(strtolower($captcha)) != $_SESSION['captcha']) {
			$msg = "false";
		}	
		echo $msg; 
		//return false; 
	 }
	 
	 public function ajax_update_delivery_info(){
	
	     if($_POST){
	        $customer_array = array(
					'DeliveryTitle'	=> $this->input->post('title_d', TRUE),
					'DeliveryFirstName' => $this->input->post('d_first_name', TRUE),
					'DeliveryLastName' 	=> $this->input->post('d_last_name', TRUE),
					'DeliveryCompanyName' 	=> $this->input->post('d_organization', TRUE),
					'DeliveryAddress1' 	 	=> $this->input->post('d_add1', TRUE),
					'DeliveryAddress2' 	=> $this->input->post('d_add2', TRUE),
					'DeliveryTownCity' 	=> $this->input->post('d_city', TRUE),
					'DeliveryCountyState' 	=> $this->input->post('d_county', TRUE),
					'DeliveryPostcode' 	=> $this->input->post('d_pcode', TRUE),
					'DeliveryEmail' 	=> $this->input->post('d_email', TRUE),
					'DeliveryTelephone' 	=> $this->input->post('d_phone_no', TRUE),
					'DeliveryMobile' 	=> $this->input->post('d_mobile_no', TRUE),
					'DeliveryResCom' 	=> $this->input->post('d_ResCom', TRUE),
                                        'DeliveryCountry' 	=> $this->input->post('d_country', TRUE),
					);
				   $userid=$this->session->userdata('userid');
		           $result = $this->user_model->UpdateDB('customers', $customer_array,$userid);
				  if($result){
					  $class="done";
					  $msg="Data updated";
					  }
					  else{
						 $class="error";
					  $msg="unable to update";  
						  }
                 echo json_encode(array('response'=>$class,'msg'=>$msg));
		 }
		 
			} 
	 
	 
	  public function ajax_update_billing_info(){
			
			
	     if($_POST){

	        $customer_array = array(
					'BillingTitle'	=> $this->input->post('billing_title', TRUE),
					'BillingFirstName' => $this->input->post('b_first_name', TRUE),
					'BillingLastName' 	=> $this->input->post('b_last_name', TRUE),
					'BillingCompanyName' 	=> $this->input->post('b_organization', TRUE),
					'BillingAddress1' 	 	=> $this->input->post('b_add1', TRUE),
					'BillingAddress2' 	=> $this->input->post('b_add2', TRUE),
					'BillingTownCity' 	=> $this->input->post('b_city', TRUE),
					'BillingCountry' 	=> $this->input->post('b_county', TRUE),
					'BillingPostcode' 	=> $this->input->post('b_pcode', TRUE),
					'BillingTelephone' 	=> $this->input->post('b_phone_no', TRUE),
					'BillingMobile' 	=> $this->input->post('b_mobile', TRUE),
					'BillingResCom' 	=> $this->input->post('b_ResCom', TRUE),
                                        'BillingCountry' 	=> $this->input->post('b_country', TRUE),
					);
				   $userid=$this->session->userdata('userid');
		           $result = $this->user_model->UpdateDB('customers', $customer_array,$userid);
				  if($result){
					  $class="done";
					  $msg="Data updated";
					  }
					  else{
						 $class="error";
					  $msg="unable to update";  
						  }
                 echo json_encode(array('response'=>$class,'msg'=>$msg));
		 }
		 
			} 
	 /*------User controller function --------*/
	
	function get_bussines_subtype() {
		if($_POST){	
			$ids = $this->input->post('ids');
			$id_array = explode(",", $ids);
			$subids = "'" . implode("','", $id_array) . "'";
			$query = $this->db->query("SELECT * FROM `bussines_type` Where ID IN(" . $subids . ")");
			$bussnes_type = $query->result();
	
			echo '<option value="">Select</option>';
			foreach ($bussnes_type as $row) {
				echo "<option value='" . $row->ID . "'>" . $row->Type . "</option>";
			}
			echo '<option value="other">OTHER</option>';
		}else{
					
				header("HTTP/1.1 410 Gone");	header("Location:".AURL);
		}
    }

    function get_material_subtype() {
        if($_POST){
			$id = $this->input->post('ids');
			$query = $this->db->query("SELECT * FROM `materials_type` Where ID = $id");
			$query = $query->row_array();
			
			$ids = $query['SubId'];
			$id_array = explode(",", $ids);
			$subids = "'" . implode("','", $id_array) . "'";
			$query = $this->db->query("SELECT * FROM `materials_type` Where ID IN(" . $subids . ")");
			$bussnes_type = $query->result();
			foreach ($bussnes_type as $row) {
				echo "<option value='" . $row->ID . "'>" . $row->title . "</option>";
			}
        }else{
					
					header("HTTP/1.1 410 Gone");	header("Location:".AURL);
		}	
    }
	
	/***************  VOUCHER requests  *******************/
	
	
		
	function get_vouvher_auth(){
	
	$voucher = $this->input->post('voucher',true);
	$GrandTotal = $this->input->post('GrandTotal',true);
	$voucher = trim(mysql_real_escape_string($voucher));
	$userid = $this->session->userdata('userid');
	$valid_voucher = $this->session->userdata('valid_voucher'); 
	if(isset($userid) and $userid!=''){
	     $use_q = $this->db->query("SELECT * FROM `tbl_first_order_offer` WHERE  UserID LIKE '".$userid."' ");
	     $use_r = $use_q->row_array();
	}else{
                           $data = array('is_error'=>'signin');
			   echo json_encode($data); die();
        }
	if($voucher == 'AAVCS05' and $valid_voucher=='yes' and $use_r['Used']==0){
				
		$temp_cart = $this->db->query("SELECT * FROM `voucherofferd_temp` WHERE UserID = ".$userid."");
		$temp_cart= $temp_cart->row_array();
		if($temp_cart){
						
							$time=time();
							$minus=86400; //24 housrs
							$expiry_time = $time-$minus;
						
							if($expiry_time > $temp_cart['DateLogged'] ||  $expiry_time == $temp_cart['DateLogged']){
								
								$qry = $this->db->query("DELETE FROM  `voucherofferd_temp` WHERE `ID`  = '".$temp_cart['ID']."' "); //Delete it after 24 Hours Left
								
								$discout_perct =  number_format(10/100,2);
								$DisountOff = $GrandTotal * $discout_perct;
								$New_grand = number_format(round(($GrandTotal - $DisountOff),2),2);
								
								$date = time();
								$session_id = $this->session->userdata('session_id');
								$GrandTotal = number_format($GrandTotal,2);
								
								$this->db->query("INSERT INTO `voucherofferd_temp` (`ID`, `SessionID`, `DateLogged`, `UserID`,`discount_offer`,`grandtotal`)
								VALUES (NULL, '".$session_id."', '".$date."', '".$userid."', '".$DisountOff."', '".$GrandTotal."')");
								
								
								
			$cart_data = $this->ajax_cart_load();
			$topcart_data = $this->ajax_topcart_load();
			$delivery_html = $this->ajax_delivery_content();
			$order_review_summary = $this->ajax_review_summary();
			$json_data = array('is_error'=>'no','cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
			$this->output->set_output(json_encode($json_data));
				
				
								

								
									
							}
							else{
									$data = array('is_error'=>'process');
									echo json_encode($data);
							}
								
						
					}
					else{
					
					$discout_perct =  number_format(10/100,2);
					$DisountOff = $GrandTotal * $discout_perct;
					$New_grand = number_format(round(($GrandTotal - $DisountOff),2),2);
					
					$date = time();
					$session_id = $this->session->userdata('session_id');
					$GrandTotal = number_format($GrandTotal,2);
					
					$this->db->query("INSERT INTO `voucherofferd_temp` (`ID`, `SessionID`, `DateLogged`, `UserID`,`discount_offer`,`grandtotal`)
					VALUES (NULL, '".$session_id."', '".$date."', '".$userid."', '".$DisountOff."', '".$GrandTotal."')");
					
				//	$data = array('is_error'=>'no','Discount'=>$DisountOff,'GrandTotal'=>$New_grand);
				//	echo json_encode($data);
					
				$cart_data = $this->ajax_cart_load();
				$topcart_data = $this->ajax_topcart_load();
				$delivery_html = $this->ajax_delivery_content();
				$order_review_summary = $this->ajax_review_summary();
			
				$json_data = array('is_error'=>'no','cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				$this->output->set_output(json_encode($json_data));
					
					
				}
				
				
				
				
	}
	else{
		
		if($use_r['Used']==1){
			
			$data = array('is_error'=>'used');
			echo json_encode($data);
			
		}
		else{
			$data = array('is_error'=>'Yes');
			echo json_encode($data);
		}
	}
	
}
	
	
	
	
	
	function remove_voucher_offer(){
			
			$userid = $this->session->userdata('userid');
			$session_id = $this->session->userdata('session_id');
			$qry = $this->db->query("DELETE FROM  `voucherofferd_temp` WHERE `SessionID`  = '".$session_id."' AND  UserID='".$userid."'  ");
			if($qry){
				
				$cart_data = $this->ajax_cart_load();
				$topcart_data = $this->ajax_topcart_load();
				$delivery_html = $this->ajax_delivery_content();
				$order_review_summary = $this->ajax_review_summary();
			
				$json_data = array('is_error'=>'no','cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				$this->output->set_output(json_encode($json_data));
			}
	
		
	}

/*------------------Wtp offer---------------*/		
	function get_wtp_vouvher_auth(){
	
	$voucher = $this->input->post('voucher',true);
	$GrandTotal = $this->input->post('GrandTotal',true);
	$voucher = strtolower(trim(mysql_real_escape_string($voucher)));
	$wtp_offer = $this->shopping_model->check_wtp_offer_voucher();	

	if( $wtp_offer==true and $voucher == 'wtp10'){
				
					$amount = $this->shopping_model->calculate_total_wtp_amount();	
					$discout_perct =  number_format(15/100,2);
					$DisountOff = $amount * $discout_perct;
			
					
					$date = time();
					$session_id = $this->session->userdata('session_id');
					$GrandTotal = number_format($GrandTotal,2);
					
					$this->db->query("INSERT INTO `voucherofferd_temp` (`ID`, `SessionID`, `DateLogged`,`discount_offer`,`grandtotal`)
					VALUES (NULL, '".$session_id."', '".$date."','".$DisountOff."', '".$GrandTotal."')");
					
				$cart_data = $this->ajax_cart_load();
				$topcart_data = $this->ajax_topcart_load();
				$delivery_html = $this->ajax_delivery_content();
				$order_review_summary = $this->ajax_review_summary();
			
				$json_data = array('is_error'=>'no','cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				$this->output->set_output(json_encode($json_data));
			
					
					
					
					
					
					
	}
	else{
			$data = array('is_error'=>'Yes');
			echo json_encode($data);
	}
	
}

	function remove_wtp_voucher_offer(){
			$session_id = $this->session->userdata('session_id');
			$qry = $this->db->query("DELETE FROM  `voucherofferd_temp` WHERE `SessionID`  = '".$session_id."'  AND  UserID='' ");
			if($qry){
				$cart_data = $this->ajax_cart_load();
				$topcart_data = $this->ajax_topcart_load();
				$delivery_html = $this->ajax_delivery_content();
				$order_review_summary = $this->ajax_review_summary();
			
				$json_data = array('is_error'=>'no','cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				$this->output->set_output(json_encode($json_data));
				
			}
	}
	
	function materail_for_custom(){
		echo $this->home_model->get_materail_for_custom();
	}
	/************** enquiry Form  **************/
		function ajax_quote(){
			
			if($_POST){
				$email=$this->input->post('email', TRUE);
				$phoneno=$this->input->post('Phone', TRUE);
				$username=$this->input->post('firstName', TRUE);
			
		 if($username!='' and $phoneno!='' and $email!=''){
		    $webenq = $this->product_model->addcheckoutenquiry($username,$phoneno,$email);
            if($webenq){ 
             
			 $Date = date('j<\s\u\p>S</\s\u\p> F Y');    
			 $sql = $this->db->get_where(Template_Table, array('MailID' =>'110'));
		     $result = $sql->result_array();
		     $result = $result[0];
		     $mailTitle = $result['MailTitle'];
		     $mailName = $result['Name'];
		     $from_mail = $result['MailFrom'];
		     $mailSubject = $result['MailSubject'] .' : '.$webenq;
		     $mailText = $result['MailBody'];
                
             $strINTemplate   = array("[enquiryNumer]","[date]","[Name]");
             $strInDB  = array($webenq,$Date,$username);
             $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
                         
             $this->load->library('email');
			 $this->email->from($from_mail, 'AALABELS');
			 
			 $this->email->to($email); 
			 $this->email->cc('customercare@aalabels.com'); 
			 $this->email->subject($mailSubject);
                         $this->email->message($newPhrase);
			 $this->email->set_mailtype("html");
			 $this->email->send();

               $data = array('is_error'=>'no');echo json_encode($data);
			   }
				else{
					$data = array('is_error'=>'yes');echo json_encode($data);
					}
                }else{
					 $data = array('is_error'=>'yes');echo json_encode($data);
					  }
		}else{
			$data = array('is_error'=>'yes');echo json_encode($data);
			}
		
	}
	
	
	
	public function upload_integrated_files($productid) {
		if (!empty($_FILES)) {
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$response = $this->home_model->upload_images('file','/');
				if($response!='error'){
					$sid = $this->session->userdata('session_id');
					$this->db->insert('integrated_attachments',array('SessionID'=>$sid,'ProductID'=>$productid,'file'=>$response));
					echo $response;
				}else{
					echo "error";
				}
		}
    }
	public function delete_from_folder(){
		
		if($_POST){
			$file = $this->input->post('file');
			$productid = $this->input->post('productid');
			$sid = $this->session->userdata('session_id');
			$this->db->where(array('ProductID'=>$productid,'SessionID'=>$sid,'file'=>$file));
			$query  = $this->db->delete("integrated_attachments");
			//echo $this->db->last_query();
		    if($query){
				@unlink(PATH.'/'.$file);
		   }
		   echo "deleted";
		}
	}
	
	function download($type, $file){
		$name = $file;
	
		if($type=='pdf'){
			$file = Assets."images/office/pdf/".$file;
			echo "<script>window.location.href='".$file."'</script>";
			exit();
		}
		else if($type=='catalog'){
			$file = Assets."images/catalog/".$file;
                        echo "<script>window.location.href='".$file."'</script>";
			exit();  
		}
		else if($type=='printer'){
			$file = Assets."images/printer/datasheets/".$file;
                        echo "<script>window.location.href='".$file."'</script>";
			exit();          
		}
                else if ($type == 'usermanuals') {
                         $file = Assets . "images/printer/manuals/" . $file;
                         //echo $file;die();
                         echo "<script>window.location.href='".$file."'</script>";
			 exit();                                             
                        
                }
		else if($type=='integrated'){
			echo $filePath = $_SERVER['DOCUMENT_ROOT']."/newlabels/theme/integrated_attach/".$file;
			if(file_exists($filePath)) {
				$fileSize = filesize($filePath);
				header("Cache-Control: private");
				header("Content-Type: application/stream");
				header("Content-Length: ".$fileSize);
				header("Content-Disposition: attachment; filename=".$file);
				readfile ($filePath);                   
				exit();
			}else{
				die("-------");	
			}
			
		
		
		}
		$data = file_get_contents($file); // Read the file's contents
		force_download($name, $data); 
	}
	
function set_newsletter_cookies(){
				$request = $this->input->post('request');
				if(isset($request) and $request!=''){
					$this->session->set_userdata('newsletter_no_thanks','yes');	
				}
				echo $this->session->userdata('newsletter_no_thanks');		
				
   }	

function add_search_log(){
		$keywords = $this->input->post('keywords');
		if(isset($keywords) and $keywords!=''){
			 $this->load->library('user_agent');
			 $agent = $this->agent->browser().' '.$this->agent->version();
			 $ip_add = $this->session->userdata('ip_address');
			 if($ip_add!='202.69.35.194'){
                         $this->db->insert('search_keywords_log',array('keywords'=>$keywords,'IP'=> $ip_add ,'browser'=>$agent));
              }      
		}
	}
	
	function ProductBrand($id){
		$query=$this->db->query("select  ProductBrand from products  where ManufactureID = '".$id."'");
		$res=$query->row_array();
		return $res['ProductBrand'];
	}

	function ProductBrandByProductId($id){
		$query=$this->db->query("select  ProductBrand from products  where ProductID = '".$id."'");
		$res=$query->row_array();
		return $res['ProductBrand'];
	}
 
  /******************Sample Order Implementation***********************/
 
 function labels_price_breaks(){
		
		$mid = $this->input->post('mid');
		$data['type'] = $this->input->post('type');
		$data['mid'] = $mid;
		
		if(isset($data['type']) and $data['type']=='roll'){
			$data['breaks'] = $this->home_model->get_roll_against($mid);
			$data['LabelsPerSheet'] = $this->input->post('labels');
			$html    = $this->load->view('material/price_breaks_roll', $data, true);
		
		}
		else if(isset($data['type']) and $data['type']=='application'){
				$data['breaks'] = $this->product_model->buypage($mid);
				$data['LabelsPerSheet'] = $this->input->post('labels');
				$html    = $this->load->view('applicationlabels/price_breaks', $data, true);
		}else{
			$data['breaks'] = $this->product_model->buypage($mid);
			$data['LabelsPerSheet'] = $this->input->post('labels');
			$html    = $this->load->view('material/price_breaks', $data, true);
		
		}
		
		
		
		$json_data = array('response'=>'yes','html'=>$html);
		$this->output->set_output(json_encode($json_data));
}


function add_sample_to_cart(){
			
			$array= array('response'=>'yes');
			if($_POST){
						$qty = $this->input->post('qty');
						$menuid = $this->input->post('menuid');
						$prd_id = $this->input->post('prd_id');
						$response = $this->check_sample_requests($prd_id, $menuid);
						if($response=='true'){
										$SID  =  $this->shopping_model->sessionid();
										$items = array('SessionID'=>$SID,
													   'ProductID'=>$prd_id,
													   'Quantity'=>1,
													   'orignalQty'=>1,
													   'UnitPrice'=>0.00,
													   'TotalPrice'=>0.00,
													   'OrderData'=>'Sample');
													   
									$userID = $this->session->userdata('userid');
									if(isset($userID) and $userID != '')
									{
										$cart_reminder = $this->home_model->get_db_column("customers","cart_reminder","UserID",$userID);
										if(isset($cart_reminder) and $cart_reminder == "Y")
										{
											$items['UserID'] = $userID;
										}
									}
						
										   
								    $this->db->insert('temporaryshoppingbasket',$items);
								    $topcart_data = $this->ajax_topcart_load();
								    $array = array('response'=>'yes','top_cart'=>$topcart_data);
					
						 }else{
								  $array= array('response'=>'failed', 'msg'=>$response);
						}
			}
			echo json_encode($array);

}
function check_sample_requests($prd_id, $menuid){
	
		$SID  =  $this->shopping_model->sessionid();
		$result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE OrderData LIKE 'Sample' AND SessionID LIKE '".$SID."' ");
		$row = $result->row_array();
		if($row['total'] < 5){
			
				$code = $this->home_model->getmaterialcode($menuid);
	 		 	$query = "select  count(*) as total  from temporaryshoppingbasket 
					  INNER JOIN products ON products.ProductID = temporaryshoppingbasket.ProductID
					  INNER JOIN category ON products.categoryID = category.categoryID
					  WHERE OrderData LIKE 'Sample' AND SessionID LIKE '".$SID."'
					  AND REPLACE(products.ManufactureID,REPLACE(category.PDF,'.pdf',''),'') LIKE  '".$code."'";
				$result = $this->db->query($query);
			
			$row = $result->row_array();
			if(isset($row['total']) and ($row['total'] > 0 )){
					return 'You have already requested a sample sheet of this material and we reiterate that the material samples are not size specific by label, but are providied for you to assess and evaluate the suitability of the material for your labels purpose.';
			}else{
					return 'true';	
			}
		}else{ 
					return 'you have reached the maximum sample order limit!';
		}
}

function delete_printing_cart(){
		if($_POST){
			$serial = $this->input->post('serial');
			$this->db->where('ID',$serial);
			$items = array('Printing'=>'','Print_Type'=>'','Print_Design'=>'','Print_Qty'=>'','Print_UnitPrice'=>0.00,'Print_Total'=>0.00);
			$this->db->update('temporaryshoppingbasket', $items);
			//$this->shopping_model->delete_product_cart($serial);
			$cart_data = $this->ajax_cart_load();
			$topcart_data = $this->ajax_topcart_load();
			
			$delivery_html = $this->ajax_delivery_content();
			$order_review_summary = $this->ajax_review_summary();
			
			$json_data = array('cart_data'=>$cart_data,'top_cart'=>$topcart_data,'delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
			$this->output->set_output(json_encode($json_data));
		}
	}


	public function upload_printing_files() {
		if (!empty($_FILES)) {
			

				$productid = $this->input->post('product_id');
				
				$tempFile = $_FILES['file']['tmp_name'];
				$fileName = $_FILES['file']['name'];
				$response = $this->home_model->upload_images('file','/');
				if($response!='error'){
					$sid = $this->session->userdata('session_id');
					$this->db->insert('integrated_attachments',array('SessionID'=>$sid,'ProductID'=>$productid,'file'=>$response));
					echo $response;
				}else{
					echo "error";
				}
		}
    }
   public function delete_from_printing_files(){
		
		if($_POST){
			$file = $this->input->post('file');
			$productid = $this->input->post('productid');
			$sid = $this->session->userdata('session_id');
			$this->db->where(array('ProductID'=>$productid,'SessionID'=>$sid,'file'=>$file));
			$query  = $this->db->delete("integrated_attachments");
			//echo $this->db->last_query();
		    if($query){
				@unlink(PATH.'/'.$file);
		   }
		   echo "deleted";
		}
	}
    function setpostcode(){
		
	$response = 'no'; $array = array();
	
	$postcode = $this->input->post('postocde');
    $bpcode = $this->input->post('bpcode');       
	$postcode = urldecode($postcode);
	$postcode = urldecode($postcode);
	$bpcode = urldecode($bpcode);
	$country = $this->input->post('country');
	$country = urldecode($country);
	
	$oldpostcode = '';
	$oldpostcode = $this->session->userdata('off_postcode');
	$oldcountry = $this->session->userdata('countryid');
	//country
	
	$bgroup = $this->input->post('bgroup');
	$dgroup = $this->input->post('dgroup');
	
	if(isset($postcode) and $oldpostcode!=$postcode){
		$this->session->set_userdata('off_postcode',$postcode);
		$response = 'yes';
	}
	if(isset($country) and $country!='' and $oldcountry!=$country){
		$this->session->set_userdata('countryid',$country);
		$this->session->set_userdata("BasicCharges","");
		$this->session->set_userdata("ServiceID","");
		$response = 'yes';
		$this->session->set_userdata('vat_exemption','');
		$this->update_integrated_delivery_charges();
	}
        $bpcode = strtoupper(substr($bpcode,0,2));
		 $postcode = strtoupper(substr($postcode,0,2));
		
		 if($country=='United Kingdom' and $bpcode==$postcode and (strtoupper($postcode)=='JE' || strtoupper($postcode)=='GY')){
		 	 $this->session->set_userdata('vat_exemption','yes');
		 	 $response = 'yes';	 		  
		 }
		 else if($dgroup=='ROW' || $dgroup=='EUROPE' ){
		 	  $this->session->set_userdata('vat_exemption','yes');
		 	  $response = 'yes';	 		  
		 }
		 else if(($oldcountry == $country) and $country=='United Kingdom'){
			 $this->session->set_userdata('vat_exemption','');
		 	 $response = 'yes';	  
		 }       
	
	if($response=='yes'){
		$delivery_html = $this->ajax_delivery_content();
		$order_review_summary = $this->ajax_review_summary();
		$array = array('delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
	}
	
	
	//$oldpostcode = $this->session->userdata('off_postcode');
	//$oldcountry = $this->session->userdata('countryid');
	
	
	$json_data = array('response'=>$response);
	$json_data = array_merge($json_data, $array);
	$this->output->set_output(json_encode($json_data));
	
}         
	
	function setpostcode_old() {

        $response = 'no';
        $array = array();

        $postcode = $this->input->post('postocde');
        $postcode = urldecode($postcode);

        $country = $this->input->post('country');
        $country = urldecode($country);

        $oldpostcode = '';
        $oldpostcode = $this->session->userdata('off_postcode');
        $oldcountry = $this->session->userdata('countryid');
        //country



        if (isset($postcode) and $oldpostcode != $postcode) {
            $this->session->set_userdata('off_postcode', $postcode);
            $response = 'yes';
        }
        if (isset($country) and $country != '' and $oldcountry != $country) {
            $this->session->set_userdata('countryid', $country);
			$this->session->set_userdata("BasicCharges","");
            $this->session->set_userdata("ServiceID","");
            $response = 'yes';
        }

        if ($response == 'yes') {
            $delivery_html = $this->ajax_delivery_content();
            $order_review_summary = $this->ajax_review_summary();
            $array = array('delivey' => $delivery_html, 'orderSummary' => $order_review_summary);
        }


        //$oldpostcode = $this->session->userdata('off_postcode');
        //$oldcountry = $this->session->userdata('countryid');


        $json_data = array('response' => $response);
        $json_data = array_merge($json_data, $array);
        $this->output->set_output(json_encode($json_data));
    }
               function reset_validate_vat(){
		$vatvalidate = $this->input->post('vatvalidate');
		if(isset($vatvalidate) and $vatvalidate=='reset'){
			$this->session->set_userdata('vat_exemption','');
			$data  =array('orderSummary'=>$this->ajax_review_summary());
			echo json_encode($data);
		}
	}
 	function validate_vat(){
			$country = $this->input->post('country');
			$vatNumber = $this->input->post('vatNumber');
			$vatNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatNumber));
			$data  =array('status'=>'Invalid','message'=>'Invalid VAT Number');
			if(isset($vatNumber) and $vatNumber!=''){
				$countryCode = $this->country_code($country);
				$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
				try{
					$response = $client->checkVat(array('countryCode' => $countryCode,'vatNumber' => trim($vatNumber)));
				
					if(isset($response->valid) and $response->valid==1){
					    
					    /*******************Vat Check Logger ************************/
							$userid = $this->session->userdata('userid');
							$email = $this->input->post('email');
							$this->db->insert('vat_checker_log', array('vat_number'=>$vatNumber,'userid'=>$userid,'email'=>$email));
						/**************************************************************/
						
						$this->session->set_userdata('vat_exemption','yes');
						$order_review_summary = $this->ajax_review_summary();
						
						$order_total = $this->shopping_model->total_order();
						$vat = number_format(($order_total*1.2)-$order_total,2,'.','');
						
					$message = "VAT Exemption of ".symbol."$vat has been deducted from your order total and this will be confirmed on the next page.";
					$data  =array('status'=>'valid',
								  'countryCode'=>$response->countryCode,
								  'requestDate'=>$response->requestDate,
								  'vatmessage'=>$message,
								  'orderSummary'=>$order_review_summary);
					 }
				}catch(SoapFault $e) {
						$this->session->set_userdata('vat_exemption','');
						$data = array('status'=>'Invalid','message'=>'Invalid VAT Number');
				}
			}
			echo json_encode($data);
	}
	
	function validate_vat_old(){
			$country = $this->input->post('country');
			$vatNumber = $this->input->post('vatNumber');
			$vatNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatNumber));
			$data  =array('status'=>'Invalid','message'=>'Invalid VAT Number');
			if(isset($vatNumber) and $vatNumber!=''){
				$countryCode = $this->country_code($country);
				$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
				try{
					$response = $client->checkVat(array('countryCode' => $countryCode,'vatNumber' => $vatNumber));
					if(isset($response->valid) and $response->valid==1){
						
						$data  =array('status'=>'valid',
									  'countryCode'=>$response->countryCode,
									  'requestDate'=>$response->requestDate,
									  'name'=>$response->name,
									  'address'=>$response->address);
					 }
				}catch(SoapFault $e) {
						echo json_encode(array('status'=>'Invalid','message'=>'Invalid VAT Number'));
				}
			}
			echo json_encode($data);
	}
	function country_code($country){
	    
	    return $countrucode = $this->home_model->get_db_column('shippingcountries','c_code', 'name', $country);
	    
			 $countrucode = array('Ireland'=>'IE',
								  'Belgium'=>'BE',
								  'Denmark'=>'DK',
								  'France'=>'FR',
								  'Holland'=>'NL',
								  'Germany'=>'DE',
								  'Sweden'=>'SE',
								  'Spain'=>'ES',
								  'Switzerland'=>'CH',
								  'Luxembourg'=>'LU',
								  'United Kingdom'=>'GB');
			//return 'GB';
			return $countrucode[$country];					  
	}
	
/******************Sample Order implementation***********************/
 
 	
	 function set_currency(){
			if($_POST){
				$currency = $this->input->post('currency');
				$symbol = $this->input->post('symbol');
				if(isset($currency) and $currency!=''){
						$_SESSION['currency'] = $currency;
						$_SESSION['symbol'] = $symbol;
				}else{
						$_SESSION['currency'] = 'GBP';
						$_SESSION['symbol'] = '&pound;';
				}
				
				
				
			}
    }
	function convert_cart_currencies(){
		  echo "Current: ".$currency = currency;
		  $result = $this->shopping_model->show_cart();
		  if(count($result) > 0){
			  foreach($result as $row){
					echo "<br />Cart ID:".$row->ID." Currency: ".$row->currency." Total Price:".$row->TotalPrice;
					if($currency != $row->currency){
						if($row->currency=='GBP'){
								 	$rate = $this->home_model->get_exchange_rate(currency);
									echo " converted price: ".$totalprice =  $row->TotalPrice*$rate;
						}else{
									echo $rate = $this->home_model->get_exchange_rate($row->currency);
									echo " converted price else: ".$totalprice =  $row->TotalPrice/$rate;
						}
						$unitprice = $totalprice/$row->Quantity;
						$update = array('UnitPrice'=>$unitprice,'currency'=>currency,'TotalPrice'=>$totalprice);
						$this->db->update('temporaryshoppingbasket',$update,array('ID'=>$row->ID));
					}
			  }
		  }
	} 
	function set_vatoptions(){
			if($_POST){
				$option = $this->input->post('option');
				if(isset($option) and $option!=''){
						 $_SESSION['vatoption'] = $option;
				}else{ 
						 $_SESSION['vatoption'] = 'exvat';
				}
				
			}
    }
	
	
	  
	  ////////////////////////// Flash pannel //////////////////////////////////
	  
	  
	  
	  function load_flash_panel(){
		$userID = $this->session->userdata('userid');
		$temp_id = $this->input->post('temp_id');
		$this->session->set_userdata('template',$temp_id);
		if(isset($userID) and $userID != '')
		{
			$data['temp_id'] = $temp_id;
			$theHTMLResponse = $this->load->View('labeldesigner/flash_panel', $data);
			echo $theHTMLResponse;
		}
		else
		{
			echo "login";
		}
		
	  }
	  
	  
	  function fetch_product_details(){

      $temp_id = $this->input->post('temp_id');  
	  
	  $product  = $this->home_model->fetch_product_details($temp_id);	
	  $category = $this->home_model->fetch_category_details($product['CategoryID']);	
	  
	   
	  $x=explode("-",$category['CategoryName']);
	  $H1 = $x[0];
	  $LabelSize = $x[1];
	  
	  $itemcode = $product['ManufactureID'];
	  $H2 = $product['ProductCategoryName'];
	   $type = $product['ProductBrand'];
	  
	  if(preg_match("/SRA3/i",$type)){
		$brand = 'SRA3Sheets';
		$height = '50';
	  }
	   else if(preg_match("/A3/i",$type)){
		  $brand = 'A3Sheets';
		  $height = '50';
	   }
		else{
			$brand = 'leaflet';	
			$height = '60';	
		}
		
	  //$image = '<img src="'.base_url().'theme/site/images/categoryimages/'.$brand.'/'.$category['CategoryImage'].'" height="'.$height.'"/>';
	 
	   $image = '<img src="'.Assets.'images/categoryimages/A4Sheets/colours/'.$itemcode.'.png" height="'.$height.'"/>';
	   
	   
	  $materialcode = $this->home_model->getmaterialcode($itemcode);
	  $diecode = str_replace($materialcode, "", $itemcode);
	  
	  //$diecode
	  
	   
	  $data   = array(
	              'image'=>$image,
	              'H1'=>$H1,
				  'H2'=>$H2,
				  'LabelSize'=>$LabelSize,
				  'itemcode'=>$itemcode,
				  'diecode'=>$diecode,
				  );
			  
		 echo json_encode($data); 
	
    }
	  
  function delete_user_projects(){
			$id = $this->input->post('serial');	
			$this->db->where('ID',$id);
			$this->db->delete('flash_user_design');	
			echo 'yes';	
   }
   
   
    function add_flash_cart() {

        $topcart_data = $this->load->view('includes/top_cart', '', true);
        $this->output->set_content_type('application/json');
		echo json_encode(array('response'=>'yes','top_cart'=>$topcart_data));
    }

function attachments($id){

		$query  = $this->db->query("Select file from order_attachments_integrated where MD5(ID) LIKE '".$id."'");
		$row = $query->row_array();
		$file = $row['file'];
		$filePath = PATH."/".$file;
		if(file_exists($filePath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: '.filesize($filePath));
					readfile($filePath);
					exit;
		}else{
				echo "file not found.";	
		}
	}
	

	function add_integrated_line(){
	
	$serial = $this->input->post('serial');
	
	$sql = $this->db->query("select * from order_attachments_integrated where Serial = $serial")->row_array();
	      $array = 
	       array('SessionID'=>$this->session->userdata('session_id'),
		         'ProductID'=>$sql['ProductID'],
				 'file'=>$sql['file'],
				 'qty'=>$sql['qty'],
				 'labels'=>$sql['labels'],
				 'Thumb'=>$sql['Thumb'],
				 'status'=>'temp',
				 'source'=>'flash',
				 'type'=>'new'
				);
		 $this->db->insert('integrated_attachments',$array); 
		 if($this->db->insert_id()){
		    echo json_encode(array('response'=>'yes','id'=>$this->db->insert_id()));
		 } 
	}
	
  /////////////////////////////////////////////FLASH CODE ///////////////////////////////////////////////////////////////////////////////	
	
	
  function filter_design_category(){
		$designcode = $this->input->post('designid');
		$category = $this->input->post('category');
		$data['url'] = $this->input->post('url');
		if($designcode=='all'){
			$data['subcatresults'] =  $this->home_model->fetch_child_category($category);
			$cateids = '';
			foreach($data['subcatresults'] as $row ) $cateids .= $row->SubCategoryID.', ';
		}else{
			$query = $this->db->query("Select SubCategoryID from category WHERE CategoryID = '".$designcode."'");
			$row = $query->row_array();
			$cateids = $row['SubCategoryID'];
		}
		$data['records'] =  $this->home_model->fetch_category_designs($cateids);
		$theHTMLResponse    = $this->load->view('applicationlabels/design_list',$data,true);
		$this->output->set_content_type('application/json');
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_output(json_encode($json_data));
		
   }

  function visitorinfolog(){
		
		$visitor_country = '';$visitor_ip = '';
		$ip = $this->session->userdata('ip_address');
		$visitor_country = $this->session->userdata('visitor_country');	
		$visitor_ip = 	$this->session->userdata('visitor_ip');	
		if(empty($visitor_country) || ($visitor_ip!=$ip)){
			$country = $this->home_model->ip_info($ip, "country_code");
			$name = $this->home_model->get_user_against_ip($ip);
			$this->session->set_userdata('visitor_country', $country);	
			$this->session->set_userdata('visitor_ip', $ip);
			$this->session->set_userdata('welcome_name', $name);
			$login = 'no';
			$userid = $this->session->userdata('userid');
			if(isset($userid) and $userid!=''){
				$login = 'yes';
			}
			echo json_encode(array('welcome'=>$name,'loggedin'=>$login));	
		}
		
	}
   
    function change_selection(){
	  $temp_id = $this->input->post('temp_id');
	  $this->session->set_userdata('template',$temp_id);
	  
	  $data['select'] = $this->home_model->get_selected_template($temp_id);
	  $theHTMLResponse = $this->load->View('labeldesigner/selected_panel', $data);
	  echo  $theHTMLResponse;
	 }


    /////////////////////////////////////////////FLASH CODE /////////////////////////////////////////
  	 function search_printed_dies(){
		$diecode = $this->input->post('diecode');
		if(isset($diecode)  and $diecode!=''){
			    $condtion = " CategoryActive = 'Y' AND Shape != '' AND ( labelCategory LIKE 'A4 Labels' OR labelCategory LIKE 'Roll Labels' ) ";
		   	    $final_condition = $condtion." AND CategoryImage LIKE '%".$diecode."%'";
				$count = $this->home_model->get_print_sizes_count($final_condition);
				$data['count']=$count;
				
				$data['pagination'] = 'hide';
				$data['current_page'] = 1;
				$limit = ' Limit 0,50 ';
				$data['records'] = $this->home_model->get_print_sizes($final_condition, $limit);
				$theHTMLResponse = $this->load->view('print_service/size_list', $data, true);
				$json_data = array('response' => 'yes',
								   'count' => round($count),
								   'html' => $theHTMLResponse);
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode($json_data));
		
		}
	}
  	function printingfilters(){
			
        if ($_POST) {
			$shape = $width = $height = '';$count=0;
			$theHTMLResponse = '';
            $min_width = 0;
            $max_width = 0;
            $min_height = 0;
            $max_height = 0;
            $width_option = '';
            $height_option = '';
            $shape_sel = $this->input->post('shape');
            $width_sel = $this->input->post('width');
            $height_sel = $this->input->post('height');
            $height_sel = $this->input->post('height');
            $opposite = $this->input->post('opposite');
			
			$email = $this->input->post('email');
			$count = $this->input->post('count');
			$start = $this->input->post('start');
			
			$condtion = '';
			$opposite_width = '';
			$opposite_height = '';
			
			
			$condtion .= " CategoryActive = 'Y' AND Shape != '' AND (labelCategory LIKE 'A4 Labels' OR labelCategory LIKE 'Roll Labels' ) ";

			if (isset($shape_sel) and strlen($shape_sel) > 0) {
                $shape = " AND Shape LIKE '" . $shape_sel . "' ";
            }

            if (isset($width_sel) and strlen($width_sel) > 0) {
                $width = " AND Width LIKE '" . $width_sel . "' ";
            }
            if (isset($height_sel) and strlen($height_sel) > 0) {
                $height = " AND Height LIKE '" . $height_sel . "' ";
            }
				$height_min = $this->input->post('height_min');
				$height_max = $this->input->post('height_max');
				$width_min = $this->input->post('width_min');
				$width_max = $this->input->post('width_max');
				
				
				if (isset($width_min) and $width_min != '' and $width_min > 0) {
						if(isset($opposite) and $opposite=='true'){
							 $opposite_height = " AND FLOOR(Height) >= ".floor($width_min);
						}
						$width = " AND FLOOR(Width) >= ".floor($width_min);
				}
				if (isset($width_max) and $width_max != '' and $width_max > 0) {
				   
						$width .= " AND CEIL(Width) <= " . ceil($width_max). " ";
						if(isset($opposite) and $opposite=='true'){
							 $opposite_height .= " AND FLOOR(Height) <= ".ceil($width_max);
						}
						
						
				}
				if ($shape_sel != 'Circular' and $shape_sel != 'Square') {

                    if (isset($height_min) and $height_min != '' and $height_min > 0) {
                   
				   	    $height = " AND FLOOR(Height) >= " . floor($height_min). " ";
						if(isset($opposite) and $opposite=='true'){
								$opposite_width = " AND  CEIL(Width) >= " . floor($height_min);
						}
					}
                    if (isset($height_max) and $height_max != '' and $height_max > 0) {
                    	
							$height .= " AND CEIL(Height) <= " . ceil($height_max);
							if(isset($opposite) and $opposite=='true'){
									$opposite_width .= " AND  CEIL(Width) <= " . ceil($height_max);
							}
				    }
					
                    $heightcondtion = $condtion.$shape.$width;
                    $height_range = $this->home_model->get_print_min_width_height('Height', $heightcondtion);
                    $min_height = $height_range['min'];
                    $max_height = $height_range['max'];
                }

				

                $widthcondtion = $condtion.$shape.$height;
                $width_range = $this->home_model->get_print_min_width_height('Width', $widthcondtion);
				$min_width = $width_range['min'];
                $max_width = $width_range['max'];

            
				$width_height = $height . $width;
				
				if(isset($opposite) and $opposite=='true'){
					   if($opposite_width!='' and $opposite_height!=''){
						   $width_height =   ' AND ( ( 1 = 1 '.$width. $height .' ) OR  ( 1 = 1 '.$opposite_width . $opposite_height.' ) ) '; 
					   }
					  
				}
			
           		$final_condition = $condtion.$shape.$width_height;
            	
				$start = (isset($start) and $start!='')?$start-1:0;
				
				$limit = ' Limit '.($start*8).', 8 ';
				
				if(isset($count) and $count!=''){
						$data['count']=$count;	


				}
				else{
					  	$count = $this->home_model->get_print_sizes_count($final_condition);
					 	$data['count']=$count;
				}
				$data['current_page'] = $start+1;	
					
				$data['records'] = $this->home_model->get_print_sizes($final_condition, $limit);
				$theHTMLResponse = $this->load->view('print_service/size_list', $data, true);
				
				$json_data = array('response' => 'yes',
									'width' => $width_option,
									'height' => $height_option,
									'count' => round($count),
									'min_width'  => floor($min_width),
									'max_width'  => ceil($max_width),
									'min_height' => floor($min_height),
									'max_height' => ceil($max_height),
									'html' => $theHTMLResponse);
				
				//insert into db
				if(isset($email) and $email != '')
				{
					$pref = array('email' => $email,
							  'shape' => $shape_sel,
							  'sessionID' => $this->session->userdata('session_id'),
							  'opposite' => $opposite,
							  'min_width'  => floor($min_width),
							  'max_width'  => ceil($max_width),
							  'min_height' => floor($min_height),
							  'max_height' => ceil($max_height));
							  
				$this->home_model->insert_preferences($pref);
				}
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode($json_data));
        }
    }
	
	function printingmaterials(){
			$color = $material = $finish = $adhesive = $email ='';
			$cate = $tcode = $this->input->post('category_id');
			$available = $this->input->post('available_in');
			$type = $this->input->post('type');
			$email = $this->input->post('email');
			
			if(isset($available) and $available=='both'){
				$tcode = explode(",",$tcode);
				$type = $this->input->post('type');
				if($type  == 'Roll'){ $tcode = str_replace("R1","",$tcode[1]); }
				else{ $tcode = $tcode[0]; }
				
			}
			else if(isset($available) and $available=='Roll'){
					 $tcode = str_replace("R1","",$tcode);
			
			}
			
			$material_sel = $this->input->post('material');
			$color_sel = $this->input->post('color');
			$finish_sel = $this->input->post('finish');
			$adhesive_sel = $this->input->post('adhesive');
			
			if (isset($color_sel) and strlen($color_sel) > 0) {
                $color = " AND p.Material1 LIKE '" . $color_sel . "' ";
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
					
			
			$condition = " c.CategoryID LIKE '".$tcode."' AND p.Printable LIKE 'Y' ";
			
			
			
			
			$adhesive_condtion = $condition . $color . $material . $finish;
            $adhesive_list	   = $this->home_model->labelsfinder_field_list('p.Adhesive', $adhesive_condtion);
            $adhesive_option   = $this->home_model->make_option_with_tooltip($adhesive_list, 'Adhesive', 'Select Label Adhesive', $adhesive_sel);
			
			$color_condtion    = $condition . $finish . $material . $adhesive;
            $color_list 	   = $this->home_model->labelsfinder_field_list('p.Material1', $color_condtion);
            $color_option	   = $this->home_model->make_option_with_tooltip($color_list, 'Material1', 'Select Label Colour', $color_sel);


            $finish_condtion   = $condition . $color . $material . $adhesive;
            $finish_list 	   = $this->home_model->labelsfinder_field_list('p.LabelFinish_upd', $finish_condtion);
            $finish_option 	   = $this->home_model->make_html_option($finish_list, 'LabelFinish_upd', 'Select Label Finish', $finish_sel);

            $material_condtion = $condition . $color. $finish . $adhesive;
            $material_list 	   = $this->home_model->labelsfinder_field_list('p.ColourMaterial_upd', $material_condtion);
            $material_option   = $this->home_model->make_option_with_tooltip($material_list, 'ColourMaterial_upd', 'Select Label Material', $material_sel);
			
			
			$row = $this->db->query(" Select * from category WHERE CategoryID LIKE '".$tcode."' ")->row_array();
			$categorycode = str_replace(".png","",$row['CategoryImage']);
			
			
			
			if($row['Shape_upd'] == "Circular"){
				   	$label_size = ucwords(str_replace("Label Size:","",$row['specification3']));
					$label_size = str_replace("Mm","mm",$label_size);
			}else{
					$label_size =  $row['LabelWidth']." x ".$row['LabelHeight'];
			}
				
			
			if(isset($type) and $type == 'Roll'){
					$image = explode('.',$row['CategoryImage']);
					$img_chgr= $image[0];
					$imagename = $image[0];
					//$image = Assets."images/categoryimages/RollLabels/outside/".$imagename."WTP1.jpg";
					//if(!getimagesize($image))
					//{
					//	$image = Assets."images/categoryimages/RollLabels/".$imagename.".jpg";
					//}
					
					$image = ARTPATH."images/categoryimages/RollLabels/".$imagename.".jpg";
					
					if(!getimagesize($image))
					{
						$image = Assets."images/categoryimages/roll_desc/".$imagename.'R1'.".jpg";
					}
					$image = '<img width="142" class="m-t-15 m-l-20 pull-left" src="'.$image.'" ><span style="margin-right:50px;" ></span>';
					
				
			}else{
				 	$image = Assets."images/categoryimages/A4Sheets/".$row['CategoryImage'];
					$image = '<img width="120" class="m-t-15 m-b-10" src="'.$image.'" >';
			}
			
			
			
			
			 				
			
			//$label_size = ucwords(str_replace("Label Size:","",$row['specification3']));
			//$label_size = str_replace("Mm","mm",$label_size);
			 
			 
			 
			$json_data = array('response' => 'yes',
							   'color'    => $color_option,
							   'material' => $material_option,
							   'finish'   => $finish_option,
							   'adhesive' =>$adhesive_option,
							   'categorycode' =>$categorycode,
							   'image' =>$image,
							   'labelsize'=>$label_size);
			
			//echo"<pre>";print_r($json_data);echo"</pre>";exit;
			$pref = array('email' => $email,
						  'sessionID' => $this->session->userdata('session_id'),
						  'selected_size' => $cate,
						  'available_in' => $available,
						  );
				  
			if($available == "A4")
			{
				$code_a4 = $this->home_model->get_db_column("category","CategoryImage","categoryID", $cate);
				$code = explode(".",$code_a4);
				$pref['categorycode_a4'] = $code[0];
			}
			else if($available == "Roll")
			{
				
				$code_r = explode("R",$cate);
				$code_roll = $this->home_model->get_db_column("category","CategoryImage","categoryID", $code_r[0]);
				$code = explode(".",$code_roll);
				$pref['categorycode_roll'] = $code[0]."R".$code_r[1];
				
			}
			else if($available == "both")
			{
				$cate = explode(",",$cate);
				
				$code_a4 = $this->home_model->get_db_column("category","CategoryImage","categoryID", $cate[0]);
				$code = explode(".",$code_a4);
				$pref['categorycode_a4'] = $code[0];
				
				$code_r = explode("R",$cate[1]);
				$code_roll = $this->home_model->get_db_column("category","CategoryImage","categoryID", $code_r[0]);
				$code = explode(".",$code_roll);

				$pref['categorycode_roll'] = $code[0]."R".$code_r[1];
				$pref['productcode_a4'] = isset($data['a4details']['ManufactureID'])?$data['a4details']['ManufactureID']:'';
				$pref['productcode_roll'] = isset($data['rolldetails']['ManufactureID'])?$data['rolldetails']['ManufactureID']:'';
			}			  
			$this->home_model->insert_preferences($pref);

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($json_data));
		
				
	} 
	
	function getfinalproducts(){
			 
			 
			 $rollcores = '';
			 $a4code = '';
			 $rollcode = '';
			 	
			 $material_a4 = $this->input->post('material_a4');
			 $color_a4 = $this->input->post('color_a4');
			 $adhesive_a4 = $this->input->post('adhesive_a4');
			 $digital_proccess_a4 = $this->input->post('digital_proccess_a4');
			 
			 $material_roll = $this->input->post('material_roll');
			 $color_roll = $this->input->post('color_roll');
			 $adhesive_roll = $this->input->post('adhesive_roll');
			 $digital_proccess_roll = $this->input->post('digital_proccess_roll');
			 $finish_roll = $this->input->post('finish_roll');
			 
			 $category_id = $this->input->post('category_id');
			 $available_in = $this->input->post('available_in');
			 $email = $this->input->post('email');
			 
			 
			if($available_in == 'A4' ){
				 
				 	$condition = " p.CategoryID LIKE '".$category_id."' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
			 		$condition .= " AND Adhesive LIKE '".$adhesive_a4."'";
					$condition .= " AND Material1 LIKE '".$color_a4."'";
					$condition .= " AND ColourMaterial_upd LIKE '".$material_a4."'";
					
					$query = " Select * from products p,category c WHERE $condition AND c.CategoryID=p.CategoryID ";
					$data['a4details'] = $this->db->query($query)->row_array();
					$data['a4details']['digitalprocess'] = $digital_proccess_a4;
					
			 }
			 else if($available_in == 'Roll' ){
				 	$condition = " p.CategoryID LIKE '".$category_id."' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
			 		$condition .= " AND Adhesive LIKE '".$adhesive_roll."'";
					$condition .= " AND Material1 LIKE '".$color_roll."'";
					$condition .= " AND ColourMaterial_upd LIKE '".$material_roll."'";
				   
					$query = " Select * from products p,category c WHERE $condition AND SUBSTRING_INDEX(p.CategoryID,'R',1) =c.CategoryID";
					$data['rolldetails'] = $this->db->query($query)->row_array();
					
					$data['rolldetails']['digitalprocess'] = $digital_proccess_roll;
					$data['rolldetails']['rollfinish'] = $finish_roll;
			 }
			 else if($available_in == 'both' ){
				 	
				$tcode = explode(",",$category_id);
				$category_id = $tcode[0];
					
			     if(isset($adhesive_a4) and $adhesive_a4!='' and isset($color_a4) and $color_a4!='' 
				 and isset($material_a4) and $material_a4!='' ){
						
						$condition = " p.CategoryID LIKE '".$category_id."' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
						$condition .= " AND Adhesive LIKE '".$adhesive_a4."'";
						$condition .= " AND Material1 LIKE '".$color_a4."'";
						$condition .= " AND ColourMaterial_upd LIKE '".$material_a4."'";
						
						$query = " Select * from products p,category c WHERE $condition AND c.CategoryID=p.CategoryID ";
						$data['a4details'] = $this->db->query($query)->row_array();
						$data['a4details']['digitalprocess'] = $digital_proccess_a4;
				}
					
				$category_id = $tcode[1];
				$condition = " p.CategoryID LIKE '".$category_id."' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
				
				if(isset($adhesive_roll) and $adhesive_roll!='' and isset($color_roll) and $color_roll!='' 
				and isset($material_roll) and $material_roll!='' ){
				
						$condition .= " AND Adhesive LIKE '".$adhesive_roll."'";
						$condition .= " AND Material1 LIKE '".$color_roll."'";
						$condition .= " AND ColourMaterial_upd LIKE '".$material_roll."'";
						
						$query = " Select * from products p,category c WHERE $condition AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
						$data['rolldetails'] = $this->db->query($query)->row_array();
						$data['rolldetails']['digitalprocess'] = $digital_proccess_roll;
						$data['rolldetails']['rollfinish'] = $finish_roll;
					}
			 }
			
			
			$data['type'] = $available_in;
			
			$pref = array('email' => $email,'sessionID' => $this->session->userdata('session_id'),);
						  
			if($available_in == "A4")
			{
				$pref['productcode_a4'] = isset($data['a4details']['ManufactureID'])?$data['a4details']['ManufactureID']:'';
			}
			else if($available_in == "Roll")
			{
				$pref['productcode_roll'] = isset($data['rolldetails']['ManufactureID'])?$data['rolldetails']['ManufactureID']:'';				
			}
			else if($available_in == "both")
			{
				$pref['productcode_a4'] = isset($data['a4details']['ManufactureID'])?$data['a4details']['ManufactureID']:'';
				$pref['productcode_roll'] = isset($data['rolldetails']['ManufactureID'])?$data['rolldetails']['ManufactureID']:'';
			}
			$this->home_model->insert_preferences($pref);
			
			$theHTMLResponse = $this->load->view('print_service/selected_products', $data, true);
			
			$json_data = array('content'=>$theHTMLResponse,'type'=>$available_in);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($json_data));
			
			 		
	}





	
	

	













	
	function calculate_roll_price(){
		if(!$_POST)
		{
			$_POST = json_decode(file_get_contents('php://input'), true);
		}
		
	   if($_POST){
			
			$roll = $this->input->post('roll');
			$menu = $this->input->post('menuid');
			$labels = $this->input->post('labels');
			$prd_id = $this->input->post('prd_id');
			$diameter = $this->input->post('diameter');
			$printing = $this->input->post('printing');
			$printing_enabled = $this->input->post('printing_enabled');
			
			
			$size = $this->input->post('size');
			$gap = $this->input->post('gap');
			
			$regmark = $this->input->post('regmark');
			
			$save_txt = '';
			$regmark_price = symbol.'0.00';
			if(isset($printing_enabled) and $printing_enabled == "Y" and $printing == "")
			{
				$printing = "Fullcolour";
			}
			
			
			
			if(isset($printing) and $printing!=''){
							
							$cartid = $this->input->post('cart_id');
								
							$diamter = $this->home_model->get_auto_diameter($menu,$labels,$gap,$size);
							$presproof = $this->input->post('presproof');
							
							$presproof = (isset($presproof) and $presproof==1)?1:0;
							
							$presproof_charges = 0.00;
							if(isset($presproof) and $presproof==1){
								$presproof_charges = 50.00;
							}
							
							$labelfinish = $this->input->post('labelfinish');
							$persheets = $this->input->post('max_labels');
							$values_array = array('labeltype'=>$printing,
												  'labels'=>$labels,
												  'design'=>1,
												  'menu'=>$menu,
												  'persheets'=>$persheets,
												  'producttype'=>'Rolls',
												  'pressproof'=>$presproof,
												  'finish'=>$labelfinish);
							$response = $this->price_calculator($values_array);
							
							$promotiondiscount = 	$response['promotiondiscount'];
				    	    $plainlabelsprice  = 	$response['plainlabelsprice'];
				        	$label_finish  = 	$response['label_finish'];
							
							$rec = $this->home_model->get_total_uploaded_qty($cartid, $prd_id);
							$uploaded_labels = $rec['labels'];
							$uploaded_rolls = $rec['sheets'];
							
							$additional_cost = 0.00;
							$additional_rolls = 0;
							if($uploaded_rolls > $response['rolls']){
								$additional_rolls = $uploaded_rolls-$response['rolls'];
								$additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
								$additional_cost;
							}
							
							$presproof_charges = $this->home_model->currecy_converter($presproof_charges, 'yes');
							$presproof_charges = number_format($presproof_charges,2,'.','');
							
							$additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
							$additional_cost = number_format($additional_cost,2,'.','');
							
							$printprice = $this->home_model->currecy_converter($response['price'], 'yes');
							$printprice = number_format($printprice,2,'.','');
							
							
							$label_finish = $this->home_model->currecy_converter($label_finish, 'yes');
							$label_finish = number_format($label_finish,2,'.','');
							
							$plainlabelsprice = $this->home_model->currecy_converter($plainlabelsprice, 'yes');
							$plainlabelsprice = number_format($plainlabelsprice,2,'.','');
							
							$promotiondiscount = $this->home_model->currecy_converter($promotiondiscount, 'yes');
							$promotiondiscount = number_format($promotiondiscount,2,'.','');
							
							
							$price = $this->home_model->currecy_converter($response['price']+$additional_cost, 'yes');
							$price = number_format($price,2,'.','');
							$price_txt = '<b class="color-orange"> '.symbol.$price.' </b> <br />'.vatoption.' VAT';
							$per_labels = round(($price/$labels),3);
							$per_labels = $labels.'  Labels, '.symbol.$per_labels.' per label';
							
							echo json_encode(array('response'=>'yes',
										  'price'=>$price_txt,
										  'printprice'=>($printprice-$presproof_charges+$promotiondiscount),
										  'halfprintprice'=>number_format($promotiondiscount,2,'.',''),
								  		  'onlyprintprice'=>number_format($promotiondiscount*2,2,'.',''),
										  'plainlabelsprice'=>number_format($plainlabelsprice,2,'.',''),
										  'label_finish'=>number_format($label_finish,2,'.',''),
										  'additional_cost'=>$additional_cost,
										  'additional_rolls'=>$additional_rolls,
										  'presproof_charges'=>$presproof_charges,
										  'labelprice'=>$per_labels,
										  'diameter'=>$diamter,
										  'symbol'=>symbol,
								  		  'vatoption'=>vatoption,
										  'rawprice'=>$price));
			
			}
			else if(isset($labels) and $labels > 99) {
					$latest_price = $this->home_model->calclateprice($menu,$roll,$labels);
					$delivery_txt = $this->shopping_model->delevery_txt();
					$price = $latest_price['final_price'];
					//$per_labels = $latest_price['perlabel'];
					//$perprice = $latest_price['unit_prcie'];
					
					$price = $this->home_model->currecy_converter($price, 'yes');
					$raw_plain = symbol.number_format($price,2,'.','');
					if(isset($regmark) and $regmark == "yes")
					{
						/*$collection['labels'] 	  = $labels; 
						$collection['manufature'] = $menu;
						$collection['finish']     = 'No Finish';
						$collection['rolls']      = $roll;
						$collection['labeltype'] = 'Monochrome - Black Only';
						$price_res = $this->home_model->calculate_printing_price($collection);
						$regmark_price = $price_res['promotiondiscount'];
						$price = $price + $regmark_price;
						$regmark_price = symbol.number_format($regmark_price,2,'.','');*/
						
						
						
						$labelfinish = 'No Finish';
						$persheets = $this->input->post('max_labels');
						$values_array = array('labeltype'=>'Monochrome - Black Only',
											  'labels'=>$labels*$roll,
											  'design'=>1,
											  'menu'=>$menu,
											  'persheets'=>$persheets,
											  'producttype'=>'Rolls',
											  'pressproof'=>0,
											  'finish'=>$labelfinish);
						$response = $this->price_calculator($values_array);
						//echo"<pre>";print_r($response);echo"</pre>";exit;
						$regmark_price = $this->home_model->currecy_converter($response['promotiondiscount'], 'yes');
						$regmark_price = number_format($regmark_price,2,'.','');
						//$price = $price + $regmark_price;
						$price = $response['price'];
						$price = $this->home_model->currecy_converter($price, 'yes');
						$regmark_price = symbol.number_format($regmark_price,2,'.','');
						$response['plainlabelsprice'] = $this->home_model->currecy_converter($response['plainlabelsprice'], 'yes');
						$raw_plain = symbol.number_format($response['plainlabelsprice'],2,'.','');
					}
					$diamter = $this->home_model->get_auto_diameter($menu,$labels,$gap,$size);
					
					$wpep_discount_txt = '';$dis_img = '';
				    $material_code = $this->home_model->getmaterialcode(substr($menu,0,-1));
					$material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
					if($material_discount){
								$wpep_discount = (($price) * ($material_discount / 100));
								$wpep_discount_txt = '<small class="discount_price">'.symbol.$price.' </small>';
								$price = number_format(($price - $wpep_discount),2,'.','');
								$dis_img = '<img src="'.Assets.'images/discount_'.$material_discount.'.png">';
					}
					
					$price_txt = '<b class="color-orange"> ' .$wpep_discount_txt. symbol.$price.$dis_img.' </b> <br />'.vatoption.' VAT';
					$per_labels = round(($price/($labels*$roll)),3);
					$per_labels = $labels*$roll.'  Labels, '.symbol.$per_labels.' per label';
					
					$onlyprintprice = 0;
					$printprice = '0.00';
					$printprice = $this->input->post('printprice'); //enabled
					if(isset($printprice) and $printprice=='enabled'){
						$persheets = $this->input->post('max_labels');
						$totallabels = $roll*$labels;
						$values_array = array('labeltype'=>'6 Colour Digital Process',
											  'labels'=>$totallabels,
											  'design'=>1,
											  'menu'=>$menu,
											  'persheets'=>$persheets,
											  'producttype'=>'Rolls',
											  'pressproof'=>0,
											  'finish'=>'None',
						);
						$response = $this->price_calculator($values_array);
						$printprice = $this->home_model->currecy_converter($response['price'], 'yes');
						$printprice = number_format($printprice,2,'.','');
						
					//	echo"<pre>";print_r($response);echo"</pre>";exit;
					}
				   
				    //$onlyprintprice = $printprice-$price;
				    $onlyprintprice = $response['promotiondiscount'];
				   
					echo json_encode(array('response'=>'yes',
										  'price'=>$price_txt,
										  'delivery_txt'=>$delivery_txt,
										  'labelprice'=>$per_labels,
										  'diameter'=>$diamter,
										  'printprice'=>number_format($printprice,2),
										  'onlyprintprice'=>number_format($onlyprintprice,2),
										  'symbol'=>symbol,
								  		  'vatoption'=>vatoption,
										  'raw_plain'=>$raw_plain,
										  'regmark_price'=>$regmark_price));
			}
		}
		
	}
	
	
	

	
	

	public function add_email_to_session()
	{
		if($_POST)
		{
			$this->session->set_userdata($_POST);
		}
	}
	public function reset_preferences()
	{
		if($_POST)
		{
			$email = $this->input->post('email');
			$this->home_model->reset_preferences($email);
		}
	}
	function set_core_sizes(){
		$cateid = $this->input->post('cateid');
		$manid = $this->input->post('manid');
		if(isset($cateid) and $cateid!=''){
			$html = $this->home_model->genrate_rollcore_images_finder($cateid, $manid);
			echo $html;
		}
	}
	function application_popup(){
	
		$code = $groupname = $this->input->post('groupname');	
		$type = $this->input->post('type');	
		
		$groupname = str_replace(" - "," ",$groupname); 
		$groupname = str_replace("-","_",$groupname); 
		$groupname = str_replace("/","_",$groupname); 
		$groupname = str_replace("  "," ",$groupname);
		
		$groupname = strtolower(str_replace(" ","_",$groupname));
		
		$path = 	'material_specification/applications/'.$type.'/'.$groupname;
		
		$theHTMLResponse    = $this->load->view($path, '', true);
		//$theHTMLResponse    = $this->load->view('material/material_popup', $data, true);
		$this->output->set_content_type('application/json');
    	$this->output->set_output(json_encode(array('html'=> $theHTMLResponse,'group_name'=>$code)));
	} 
	
	function save_checkout_session_data(){
		$usrid=$this->session->userdata('userid');
		if(isset($usrid) && $usrid!=''){ 	
			if($_POST){
				$b_pcode 		= strtoupper($this->input->post('b_pcode'));
				$d_pcode 		= strtoupper($this->input->post('d_pcode'));
				$b_first_name 	= ucwords($this->input->post('b_first_name'));
				$b_last_name 	= ucwords($this->input->post('b_last_name'));
				$d_first_name 	= ucwords($this->input->post('d_first_name'));
				$d_last_name 	= ucwords($this->input->post('d_last_name'));
				$b_add1 		= ucwords($this->input->post('b_add1'));
				$b_add2 		= ucwords($this->input->post('b_add2'));
				$b_city 		= ucwords($this->input->post('b_city'));
				$b_county 		= ucwords($this->input->post('b_county'));
				$d_add1 		= ucwords($this->input->post('d_add1'));
				$d_add2 		= ucwords($this->input->post('d_add2'));
				$d_city 		= ucwords($this->input->post('d_city'));
				$d_county 		= ucwords($this->input->post('d_county'));
				$b_organization = ucwords($this->input->post('b_organization'));
				$d_organization = ucwords($this->input->post('d_organization'));
				
				$billing_title = $this->input->post('billing_title');
				$b_phone_no = $this->input->post('b_phone_no');
				
				$b_mobile = $this->input->post('b_mobile');
				$d_mobile_no = $this->input->post('d_mobile_no');
				
				$delivery_title = $this->input->post('title_d');
				$d_email = $this->input->post('d_email');
				
				$d_phone_no = $this->input->post('d_phone_no');
				
				$country = $this->input->post('country');
				$dcountry = $this->input->post('dcountry');
				$second_email = $this->input->post('second_email');
				
						$data = array( 'BillingTitle' => $billing_title,
									   'BillingFirstName' => $b_first_name,
									   'BillingLastName' => $b_last_name,
									   'BillingAddress1' => $b_add1,
									   'BillingTownCity' => $b_city,
									   'BillingCountyState' => $b_county,
									   'BillingPostcode' => $b_pcode,
									   'DeliveryTitle' => $delivery_title,
									   'DeliveryFirstName' => $d_first_name,
									   'DeliveryLastName' => $d_last_name,
									   'DeliveryAddress1' => $d_add1,
									   'DeliveryTownCity' => $d_city,
									   'DeliveryCountyState' => $d_county,
									   'DeliveryPostcode' => $d_pcode,
									   'Deliveryemail' => $d_email,
									   'BillingCountry'=>$country,
									   'DeliveryCountry'=>$dcountry,
									   'DeliveryAddress2'=>$d_add2,
									   'BillingAddress2'=>$b_add2);
							
							if($b_organization){
								$data = array_merge($data,array('BillingCompanyName'=>$b_organization));	
							}
							if($b_phone_no){
								$data = array_merge($data,array('Billingtelephone'=>$b_phone_no));	
							}
							
							
							if($d_organization){
								$data = array_merge($data,array('DeliveryCompanyName'=>$d_organization));	
							}
							if($d_phone_no){
								$data = array_merge($data,array('Deliverytelephone'=>$d_phone_no));	
							}
                            if($second_email){
								$data = array_merge($data,array('SecondaryEmail' => $second_email));	
							}
							if($b_mobile){
								$data = array_merge($data,array('BillingMobile' => $b_mobile));	
							}
							if($d_mobile_no){
								$data = array_merge($data,array('DeliveryMobile' => $d_mobile_no));	
							}
							
							$this->db->where('UserID',$usrid);		   
							$this->db->update('customers', $data);
							$this->session->set_userdata('payment_redirection','occured');
		
			}
		}
	}
	
	function product_details(){
	    $core = trim($this->input->post('core'));
	    $code = trim($this->input->post('code'));
	    $core =  substr($core,1,1);
	    $code =  substr($code,0,-1).$core;
	    $shortcode = $this->home_model->get_db_column('products','ReOrderCode', 'ManufactureID',$code);
	    //$shortcode = 'AAAAAA';
	    echo json_encode(array('core'=>$core,'productcode'=>$code,'shortcode'=> $shortcode));
	}
	function update_integrated_delivery_charges()
	{
		$intdata = array();
		$intdata['BasicCharges'] = 0;
		$integrated = $this->shopping_model->is_order_integrated();
		$dl_id = $this->session->userdata('ServiceID');
		if($dl_id != '')
		{
			$qry = $this->db->query("SELECT * FROM shippingservices WHERE ServiceID  = ".$dl_id." order by ServiceID asc");
			$res = $qry->result_array();
	
			$intdata['ServiceID'] = $res[0]['ServiceID'];
			$intdata['ServiceName'] = $res[0]['ServiceName'];
			$intdata['BasicCharges'] = $res[0]['BasicCharges'];
			$intdata['changeDrop'] = 1;
		}
		if($integrated > 0)
		{
			$SID = $this->shopping_model->sessionid();
			$int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `temporaryshoppingbasket` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and SessionID = '$SID' and t.p_name != 'Delivery Charges'")->row_array();

			$dpd = $this->home_model->get_integrated_delivery($int_sheets['qty']);
			$dpd = $dpd['dpd'];
			
			$productid = $int_sheets['ProductID'];
			
			$intdata['BasicCharges'] += $dpd*1.2;
			
			if($int_sheets['qty'] == '' || $int_sheets['ProductID'] == '')
			{
				$intdata['BasicCharges'] -= $dpd*1.2;
			}
			$this->session->set_userdata($intdata);
		}
	}
	
	///////////////*******************************///////////////////////////*******************************
	
	
	function calculate_lba_prices()
	{
		$result['sheetprices'] = $result['rollprices'] = '';
		if($_POST)
		{
			$material = $this->input->post('material_adhesive');
			$qty = $this->input->post('qty');
			$labels = $this->input->post('labels');
			$labeltype = $this->input->post('labeltype');
			$manufactureID = $this->input->post('menuid');
			$categoryID = $this->input->post('categoryID');
			$available_in = $this->input->post('available_in');
			$tcode = $association = $this->input->post('association');
			
			if($available_in == "Roll" || $available_in == "both")
			{
			    
			    $roll_material = $this->home_model->get_db_column('material_printable','roll_code','sheet_code',$material);
			 
				if($available_in == "both")
				{
					$tcode = explode(",",$tcode);
					$tcode = $tcode[1];
					$tcode = explode("R1",$tcode);
					$tcode = $tcode[0];
				}
				else
				{
					$tcode = explode("R1",$tcode);
					$tcode = $tcode[0];
				}
				
				$url = base_url().'ajax/calculate_roll_price';
				$ch = curl_init($url);
				if(preg_match('/^c/',$tcode))
				{
					$categoryID = $tcode.'R4';
				}
				$size = $this->home_model->get_db_column('category','Width','CategoryID',$tcode);
				
				$qry = "SELECT ManufactureID,ProductID,LabelsPerSheet,ProductCategoryName From products where `CategoryID` LIKE '%".$categoryID."%' and ManufactureID Like '%$roll_material%' and Activate='Y' LIMIT 1";
				$resp = $this->db->query($qry)->row();
				if($resp)
				{
					$data = array(
						'labels'=>$qty,
						'menuid'=> $resp->ManufactureID,
						'max_labels'=> '500',
						'labelfinish'=> 'No Finish',
						'printing'=> '6 Colour Digital Process',
						'size'=> $size
					);
					
					$payload = json_encode($data);
					
					curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
					$min_qty = $this->home_model->min_qty_roll($resp->ManufactureID);
					$min_labels_per_roll = $this->home_model->min_labels_per_roll($min_qty);
					
					$min_qty_die = $min_qty*$min_labels_per_roll;
					
					if($qty >= $min_qty_die)
					{
						$result['rollprices'] = curl_exec($ch);
					}
					else
					{
						$result['rollprices'] = "noresult";
						$result['min_qty_die'] = $min_qty_die;
					}
					$result['ManufactureID_roll'] = $resp->ManufactureID;
					$result['ProductID_roll'] = $resp->ProductID;
					$result['MaxLabels_roll'] = $resp->LabelsPerSheet;
					$result['category_description_roll'] = $resp->ProductCategoryName;
					curl_close($ch);
				}
				
			}
			if($available_in == "A4" || $available_in == "both")
			{
				
				if($available_in == "both")
				{
					$tcode = explode(",",$association);
					$tcode = $tcode[0];
				}
				else
				{
					$tcode = $tcode;
				}
				
				$url = base_url().'ajax/calculate_sheet_price';
				$ch = curl_init($url);
				
				$qry = "SELECT ManufactureID,LabelsPerSheet,ProductID,ProductCategoryName From products where `CategoryID` LIKE '%".$tcode."%' and ManufactureID Like '%$material%' and Activate='Y' LIMIT 1";
				$resp = $this->db->query($qry)->row();
				if($resp)
				{
					$data = array(
						'menuid'=> $resp->ManufactureID,
						'qty'=> ceil($qty/$resp->LabelsPerSheet),
						'prd_id'=> $resp->ProductID,
						'labels'=> $resp->LabelsPerSheet,
						'material_adhesive'=> $material,
						'labeltype'=> 'Fullcolour',
						'requestfrom'=> 'lba',
						'lba_qty' => $this->input->post('qty')
					);
					$payload = json_encode($data);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result['sheetprices'] = curl_exec($ch);
					$result['ManufactureID_sheet'] = $resp->ManufactureID;
					$result['ProductID_sheet'] = $resp->ProductID;
					$result['MaxLabels_sheet'] = $resp->LabelsPerSheet;
					$result['category_description_sheet'] = $resp->ProductCategoryName;
					
					curl_close($ch);
				}
			}
			$result['response'] = 'yes';
			$result['symbol'] = symbol;
			$result['vatoption'] = vatoption;
			$result['available_in'] = $available_in;
			echo json_encode($result);exit;	
		}
	}
	
	function ajax_bottomcart_load(){
	
		$theHTMLResponse = $this->load->view('lba/lba_recomend','',true);
		$this->output->set_content_type('application/json');
		return $theHTMLResponse;
	}
	
function serviceform(){
	 if($_POST){ error_reporting(E_ALL);
	  $comment   = $this->input->post('comment');
	  $contact   = $this->input->post('contact');
	  $email_reg = $this->input->post('email_reg');
	  $name = $this->input->post('name');
	  $maxQuoteNumber = $this->product_model->getMax();
	  
	  $array = array('QuoteNumber'=>$maxQuoteNumber,'BillingFirstName'=>$name,'BillingTelephone'=>$contact,'NotesEnquiery'=>$comment,'Billingemail'=>$email_reg,'RequestTime'=> date('g:i:s',time()),'RequestDate'=>date("Y-m-d"),'Source'=>'LBA','RequestStatus'=> '11');
	  $this->db->insert('customlabelsquotes',$array);
	  $this->db->insert('customlabelsdetails',array('QuoteNumber' => $maxQuoteNumber,'OtherInstruction'=>$comment));
	  $image_path = '';
	  
	  if(isset($_FILES['userfile']) and $_FILES['userfile']!=''){
		   $field_name = 'userfile';
		   $file_path = PATH.'/lba/';
		   $config['upload_path']= $file_path;
		   $config['allowed_types']= 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx|tiff|tif';
		   $config['max_size'] = 200000;
		   $this->load->library('upload', $config);
		   if($this->upload->do_upload($field_name)){
		      $data = $this->upload->data();
			  $image_path = $data['full_path'];
			  $imagename  = $data['file_name'];
			  if(file_exists($image_path)){
				$img = $this->AddImages($imagename,$maxQuoteNumber);
				$status = "success";
				$msg = "File successfully uploaded";
			  }
		   }
	  }
	  
	  $this->send_lba_service($array,$image_path);
	  $result['response'] = 'yes';
	  echo json_encode($result);exit;	
	 }
	}
	
	public function AddImages($imagename,$QuoteNumber){
		$customlabelsfiles = array(
			'QuoteNumber' => $QuoteNumber,
			'UploadedFile' => $imagename
		);
	   $this->db->insert('customlabelsfiles', $customlabelsfiles);
	   $ImageID = $this->db->insert_id();	
	   return  array('ImageID' => $ImageID, 'imagename' => $imagename);
	}
	
	function send_lba_service($data,$image_path){
	
	 $getfile = FCPATH.'system/libraries/en/design_service.html';
	 $mailText = file_get_contents($getfile);
	
	 $strINTemplate   = array("[QuoteNumber]","[NAME]","[Phone]","[Email]","[Message]","[RequestDate]","[RequestTime]");
     $strInDB  = array($data['QuoteNumber'],$data['BillingFirstName'],$data['BillingTelephone'],$data['Billingemail'],$data['NotesEnquiery'],date('jS F Y'),date('h:i:s A')); 
	 
	 $EmailMessage = str_replace($strINTemplate, $strInDB, $mailText);	
	 
	$this->load->library('email');
	$this->email->from('customercare@aalabels.com', 'AALABELS');
	//$this->email->to('customercare@aalabels.com'); 
	$this->email->to('kami.ramzan77@gmail.com');
	$this->email->set_mailtype("html");                        
	$this->email->subject('Design Service - Aalabels');
	$this->email->message($EmailMessage);
	$this->email->send();
   }
   
	
/**************************************** GMB REVIEWS ******************************************/
	function gmb_unsubscribe($UserID){
		$email = $this->home_model->get_db_column('customers', 'UserEmail', 'md5(UserID)' ,$UserID);
		$UserID = $this->home_model->get_db_column('customers', 'UserID', 'md5(UserID)' ,$UserID);
		if(isset($email) and $email!=''){
				$this->db->insert('gmb_unsubscribe_list', array('email'=>$email,'userid'=>$UserID));	
				
				echo '<style>body{font:14px/20px Arial, sans-serif;margin:0;padding:75px 0 0 0;text-align:center;-webkit-text-size-adjust:none;background-color: #eeeeee;}p{padding:0 0 10px 0;}h1 img{max-width:100%;height:auto !important;vertical-align:bottom;}h2{font-size:22px;line-height:28px;margin:0 0 12px 0;}h3{margin:0 0 12px 0;}.headerBar{background:none;padding:0;border:none;}.wrapper{width:600px;margin:0 auto 10px auto;text-align:left;}#templateContainer{background-color:none;}#templateBody{background-color:#ffffff;}.bodyContent{line-height:150%;font-family:Helvetica;font-size:14px;
color:#333333;padding:20px;}a:link,a:active,a:visited,a{color:#336699;}</style><html dir="ltr"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><div class="wrapper rounded6" id="templateContainer"><div id="templateBody" class="bodyContent rounded6"><h2>Unsubscribe Successful</h2><div>You will no longer receive feedback email from this list.</div><br><a href="https://www.aalabels.com">&laquo; return to our website</a></div></div> </body></html>';
				die();
							
								
		}
	}
	function send_gmb_email($array =NULL){
	    
		$count = $this->home_model->get_db_column('gmb_unsubscribe_list', 'count(*)', 'userid' ,$array['UserID']);
		if($count == 0){
			$email  = $array['Email'];
			$userid = $array['UserID'];
		   //$name   = 'Ian Peter Axelsen';
			$name   = $array['Name'];
			
			$already_sent = $this->home_model->get_db_column('gmb_sending_list', 'count(*)', 'email', $email);
			if($already_sent > 0){ return false;}
			
			if(isset($userid) and $userid!=''){
					 $getfile = FCPATH.'system/libraries/en/gmb-invitation.html';
					 $mailText = file_get_contents($getfile);
					
					 $md5_hash = md5($userid);
					 $sec_hash = strtolower('1Qy1WSWmQnOKIOLXFehGYN5fDRX4T9nNKyA3d3CMIlU');
					 $UnsubscribeLink = base_url().'unsubcribe-from-reviews/'.$md5_hash.'/'.$sec_hash.'/'.$sec_hash.'/';
					 $mailText = str_replace(array("[Name]","[UnsubscribeLink]"),array($name, $UnsubscribeLink), $mailText);
					 
					// $email = 'ian@aalabels.com';
					 $mailSubject = 'Your opinion matters to us - AA Labels';
					 
					 $this->load->library('email');
					 $this->email->from('newsletter@aalabels.com', 'AALABELS');
					 $this->email->to($email); 
					 $this->email->bcc('php.aalabels@gmail.com'); 
					 $this->email->subject($mailSubject);
					 $this->email->message($mailText);
					 $this->email->set_mailtype("html");
					 $this->email->send();
					 $this->db->insert('gmb_sending_list', array('email'=>$email,'userid'=>$userid));	//After Live remove feedback line
			}
		}
	}
	
	function send_gmb_invites(){
	    //die();
	    $week_number = $this->get_week_number();
	    if($paypal_status_debugweek_number == 2 || $week_number == 4){
	         	$result = $this->db->query(" SELECT `OrderNumber`,`UserID`,`BillingFirstName`,`Billingemail`,FROM_UNIXTIME( `DispatchedDate` ) 
        		FROM orders WHERE ( FROM_UNIXTIME( `DispatchedDate` ) > TIMESTAMP( CURRENT_DATE - INTERVAL 7 DAY ) AND 
        		FROM_UNIXTIME( `DispatchedDate` ) < TIMESTAMP( CURRENT_DATE - INTERVAL 6 DAY ) ) AND OrderStatus =7 LIMIT 0, 100 ")->result();
        		if(count($result) > 0){
        			foreach($result as $row){
        				$this->send_gmb_email(array('UserID'=>$row->UserID,'Name'=>$row->BillingFirstName,'Email'=>$row->Billingemail));
        			}
        		    $this->db->insert('paypal_status_debug', array('PaypalStatus'=>'GMB Invites Run','OrderNumber'=>'GMB Invites Run'.count($result)));
        	 	    die();
        		}
	    }		
	    
	}
	
	function get_week_number(){
		 $date = date('Y-m-d');
		 $firstOfMonth = date("Y-m-01", strtotime($date));
    	 return intval(date("W", strtotime($date))) - intval(date("W", strtotime($firstOfMonth)));
	}
	
	
/**************************************** GMB REVIEWS ******************************************/
		
function unsave_checkout_data(){
		if($_POST){
			
				$b_title 		= $this->input->post('title');
				$d_title 		= $this->input->post('title_d');
				
				$b_email 		= $this->input->post('email');
				$d_email 		= $this->input->post('d_email');
				$second_email 		= $this->input->post('second_email');
				
				$d_mobile_no 		= $this->input->post('d_mobile_no');
				$b_mobile 		= $this->input->post('b_mobile');
				
				$b_phone_no 		= $this->input->post('b_phone_no');
				$d_phone_no 		= $this->input->post('d_phone_no');
				
				$b_pcode 		= strtoupper($this->input->post('b_pcode'));
				$d_pcode 		= strtoupper($this->input->post('d_pcode'));
				$b_first_name 	= ucwords($this->input->post('b_first_name'));
				$b_last_name 	= ucwords($this->input->post('b_last_name'));
				$d_first_name 	= ucwords($this->input->post('d_first_name'));
				$d_last_name 	= ucwords($this->input->post('d_last_name'));
				$b_add1 		= ucwords($this->input->post('b_add1'));
				$b_add2 		= ucwords($this->input->post('b_add2'));
				$b_city 		= ucwords($this->input->post('b_city'));
				
				$b_county 		= ucwords($this->input->post('b_county'));
				$d_county 		= $this->input->post('d_county');
				
				$d_add1 		= ucwords($this->input->post('d_add1'));
				$d_add2 		= ucwords($this->input->post('d_add2'));
				$d_city 		= ucwords($this->input->post('d_city'));
				$b_country 		= $this->input->post('country');
				$d_country 		= $this->input->post('country');
				
				$b_organization = ucwords($this->input->post('b_organization'));
				$d_organization = ucwords($this->input->post('d_organization'));
				
				$userdata = array( 'BillingTitle'=>$b_title,
								   'DeliveryTitle'=>$d_title,
								   'UserEmail'=>$b_email,
								   'DeliveryEmail'=>$d_email,
								   'DeliveryPostcode'=>$d_pcode,
								   'BillingPostcode'=>$b_pcode,
								   'BillingFirst'=>$b_first_name,
								   'BillingLast'=>$b_last_name,
								   'DeliveryFirst'=>$d_first_name,
								   'DeliveryLast'=>$d_last_name,
								   'BillingAddress1'=>$b_add1,
								   'BillingAddress2'=>$b_add2,
								   'DeliveryAddress1'=>$d_add1,
								   'DeliveryAddress2'=>$d_add2,
								   'BillingCity'=>$b_city,
								   'DeliveryCity'=>$d_city,
								   'BillingCounty'=>$b_county,
								   'DeliveryCountyState'=>$d_county,
								   'BillingCompany'=>$b_organization,
								   'DeliveryCompany'=>$d_organization,
								   'BillingMobile'=>$b_mobile,
								   'DeliveryMobile'=>$d_mobile_no,
								   
								   'DeliveryTelephone'=>$d_phone_no,
								   'BillingTelephone'=>$b_phone_no,
								   
								   'BillingCountry'=>$b_country,
								   'DeliveryCountry'=>$d_country,
								   'SecondaryEmail'=>$second_email
								  );
				$this->session->set_userdata('checkoutdata', $userdata);
				$data = $this->session->userdata('checkoutdata');
				
				$postdata = array();
				$postdata['dgroup'] = $this->input->post('dgroup');				
				$postdata['bgroup'] = $this->input->post('bgroup');				
				$postdata['d_pcode'] = $this->input->post('d_pcode');		
				$postdata['b_pcode'] = $this->input->post('b_pcode');		
				$postdata['country'] = $this->input->post('country');		
				$postdata['dcountry'] = $this->input->post('dcountry');		
				
				$response = $this->sessionfix($postdata);
				if($response=='yes'){
					$delivery_html = $this->ajax_delivery_content();
					$order_review_summary = $this->ajax_review_summary();
					$array = array('delivey'=>$delivery_html,'orderSummary'=>$order_review_summary);
				}
				$json_data = array('response'=>$response);
				$json_data = array_merge($json_data, $array);
				$this->output->set_output(json_encode($json_data));
		}
	}
	
	function sessionfix($postdata)
	{
		$response = 'no';
		$array = array();
		$postcode = $postdata['d_pcode'];
		$bpcode = $postdata['b_pcode'];       
		$postcode = urldecode($postcode);
		$postcode = urldecode($postcode);
		$bpcode = urldecode($bpcode);
		$country = $postdata['dcountry'];
		$country = urldecode($country);
		
		$oldpostcode = '';
		$oldpostcode = $this->session->userdata('off_postcode');
		$oldcountry = $this->session->userdata('countryid');
		
		$bgroup = $postdata['bgroup'];
		$dgroup = $postdata['dgroup'];
		
		if(isset($postcode) and $oldpostcode!=$postcode){
			$this->session->set_userdata('off_postcode',$postcode);
			$response = 'yes';
		}
		if(isset($country) and $country!='' and $oldcountry != $country){
			$this->session->set_userdata('countryid',$country);
			$this->session->set_userdata("BasicCharges","");
			$this->session->set_userdata("ServiceID","");
			$this->session->set_userdata('vat_exemption','');
			$response = 'yes';
			$this->update_integrated_delivery_charges();
		}
		$bpcode = strtoupper(substr($bpcode,0,2));
		$postcode = strtoupper(substr($postcode,0,2));
		if($country=='United Kingdom' and $bpcode==$postcode and (strtoupper($postcode)=='JE' || strtoupper($postcode)=='GY')){
			$this->session->set_userdata('vat_exemption','yes');
			$response = 'yes';	 		  
		}
		else if($dgroup=='ROW' || $dgroup=='EUROPE' ){
			$this->session->set_userdata('vat_exemption','yes');
			$response = 'yes';	 		  
		}
		else if(($oldcountry == $country) and $country=='United Kingdom'){
			$this->session->set_userdata('vat_exemption','');
			$response = 'yes';	  
		}
		return $response;
	}
	
	function get_more_sizes()
	{
		$response = "no";
		$designid = $this->input->post('designid');
		
		$more_sizes = $this->home_model->get_more_sizes($designid);
		$data['designid'] = $designid;
		$data['more_sizes'] = $more_sizes;
		
		$html = $this->load->view('lba/lba_more_sizes_popup',$data,true);
		$response = "yes";
		
		$json_data = array(
			'response' => $response,
			'html' => $html
		);
		$this->output->set_output(json_encode($json_data));
	}
	
	function select_more_design()
	{
		$response = "no";
		$designid = $this->input->post('designid');
		$brand = $this->input->post('brand');
		$category = $this->input->post('category');
		
		$data['designid'] = $designid;
		$data['category'] = $category;
		$data['brand'] = $brand;
		
		$html = $this->load->view('lba/add_cart_design',$data,true);
		$response = "yes";
		
		$json_data = array(
			'response' => $response,
			'html' => $html
		);
		$this->output->set_output(json_encode($json_data));
	}
	
	

	
	function add_to_cart_design()
	{
		$response = "no";
		$label_size =  $this->input->post('label_size');
		$label_shape =  $this->input->post('label_shape');
		$label_desc =  $this->input->post('label_desc');
		$brand =  $this->input->post('brand');
		$diecode =  $this->input->post('diecode');
		$designid =  $this->input->post('designid');
		
		$design_price = number_format(LBAPRICE,2,'.','');
		$SID  =  $this->shopping_model->sessionid();
		$design_array = array(
						   'SessionID'=>$SID,
						   'p_code'=>$designid,	
						   'p_name'=>$label_desc. " - ". $label_shape." - ".$label_size . " - ".$diecode . " - ".$brand,	
						   'ProductID'=>0,
						   'OrderTime'=>'NOW()',
						   'source'=>'LBA',
						   'Quantity'=>1,
						   'Print_Qty'=>1,
						   'UnitPrice'=>$design_price,
						   'TotalPrice'=>$design_price,
						   'page_location' => 'FLDT',
						);
		$this->db->insert('temporaryshoppingbasket',$design_array);
		$response = "yes";
		$topcart_data = $this->ajax_topcart_load();
		$json_data = array(
			'response' => $response,
			'topcart_data' => $topcart_data
		);
		$this->output->set_output(json_encode($json_data));
	}

    /****************************************************/
    /***********LABEL EMBELLISHMENT TASK START***********/
    /****************************************************/

    function addPrintingPreferences()
    {

        /*echo '<pre>';
        print_r($_POST); exit;*/
        if ($_POST) {
            $catid = $this->input->post('CategoryID');
            $details = $this->home_model->fetch_category_details($catid);
            //print_r($details); exit;
            $coresize = $this->input->post('coresize');
            //print_r($coresize); exit;
            $categorycodea4 = array($details['CategoryImage']);
            $categorycoderoll = '';
            $rollcode = '';
            $A4code = '';
            $code = explode('.', $details['CategoryImage']);
            $userData = $this->user_model->get_data();
            //$selected_size = $details['CategoryID'].$coresize;
            $selected_size = $this->input->post('selected_size');
            $email = $userData['UserEmail'];
            $material = $this->input->post('material');
            $color = $this->input->post('color');
            $adhesive = $this->input->post('adhesive');
            $shape = $details['Shape_upd'];
            $min_width = floor($details['Width']);
            $max_width = ceil($details['Width']);
            $min_height = floor($details['Height']);
            $max_height = ceil($details['Height']);
            /*$dieCode = explode(".",$details['PDF']);
            $dieCode = $dieCode[0];*/
            $dieCode = $this->input->post('dieCode');


            $type = $this->input->post('type');
            /*if ($type == 'A4' || $type == 'A3' || $type == 'SRA3' || $type == 'A5') {
                $condtion = " CategoryActive = 'Y' AND Shape != '' AND ( labelCategory LIKE 'Roll Labels' ) ";
                $final_condition = $condtion . " AND CategoryImage LIKE '%" . $diecode . "%'";
            }else{
                $condtion = " CategoryActive = 'Y' AND Shape != '' AND ( labelCategory LIKE 'Roll Labels' ) ";
                $final_condition = $condtion . " AND CategoryImage LIKE '%" . $diecode . "%'";
            }

            $data['records'] = $this->home_model->get_print_sizes($final_condition, $limit);*/


            $no_of_labels = $this->input->post('no_of_labels');

            $shape = $this->input->post('shape');
            $productcode = $this->input->post('productcode');

            $source = $this->input->post('source');
            $available_in = $this->input->post('available_in');
            $no_of_rolls = $this->input->post('no_of_rolls');

            /*
            $email = $this->input->post('email');
            */
            $woundoption = $this->input->post('woundoption');
            //$orientation = "orientation1";

            if ($woundoption == "Inside") {
                $orientation = 'orientation5';
            }

            //print_r($type); exit;
            // IN CASE OF ROLLS ENDS HERE
            //print_r('a'); exit;
            if ($type == 'A4' || $type == 'A3' || $type == 'SRA3' || $type == 'A5') {
                $pref = array(
                    'email' => $email,
                    'sessionID' => $this->session->userdata('session_id'),
                    'shape' => $shape,
                    'min_width' => $min_width,
                    'max_width' => $max_width,
                    'max_height' => $max_height,
                    'min_height' => $min_height,
                    'labels_a4' => $no_of_labels,
                    'source' => $source,
                    'opposite' => "false",
                    'selected_size' => $selected_size,
                    'available_in' => $available_in,
                    'categorycode_a4' => $dieCode,
                    'productcode_a4' => $productcode,
                    'material_a4' => $material,
                    'adhesive_a4' => $adhesive,
                    'color_a4' => $color,
                    'digital_proccess_a4' => "",
                    'finish_a4' => "",
                );
            } else if ($type == 'Rolls') {

                $pref = array(
                    'sessionID' => $this->session->userdata('session_id'),
                    'source' => $source,
                    'productcode_roll' => $productcode,
                    'shape' => '',
                    'email' => $email,

                    'min_width' => $min_width,
                    'max_width' => $max_width,
                    'max_height' => $max_height,
                    'min_height' => $min_height,

                    'labels_roll' => $no_of_labels,
                    'opposite' => "false",
                    'selected_size' => $selected_size,
                    'available_in' => $available_in,
                    'categorycode_roll' => $dieCode.$coresize,

                    'material_roll' => $material,

                    'no_of_rolls' => $no_of_rolls,

                    'digital_proccess_roll' => "",
                    'finish_roll' => "",
                    'orientation' => $orientation,

                    'adhesive_roll' => $adhesive,
                    'color_roll' => $color,
                    'coresize' => $coresize,
                    'wound_roll' => $woundoption
                );
            }


            echo $this->orderModal->addPrintingPreferences($pref);
        }
    }


    function calculate_printing_prices(){

        $labels = $this->input->post('qty');
        $persheets = $this->input->post('labelspersheets');
        $design = $this->input->post('designs');
        $labeltype = $this->input->post('labeltype');
        $menu = $this->input->post('menuid');
        $producttype = $this->input->post('producttype');
        $pressproof = $this->input->post('pressproof');
        $rollfinish = $this->input->post('rollfinish');
        $email = $this->input->post('email');
        $promotiondiscount = 0.00;

        $coresize = $this->input->post('coresize');
        $wound = $this->input->post('woundoption');
        $orientation = $this->input->post('orientation');


        //$sheets = $labels*$persheets;

        /*if($labeltype == 'Full Colour'){ $labeltype = 'Fullcolour';}
        else if($labeltype == 'Full Colour + White'){ $labeltype = 'Fullcolour+White';}
        else if($labeltype == 'Black Only'){ $labeltype = 'Mono';}*/

        //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);

        $values_array = array('labeltype'=>$labeltype,
            'labels'=>$labels,
            'design'=>$design,
            'menu'=>$menu,
            'persheets'=>$persheets,
            'producttype'=>$producttype,
            'pressproof'=>$pressproof,
            'finish'=>$rollfinish,
        );

        $response = $this->price_calculator($values_array);


        $promotiondiscount = 	$response['promotiondiscount'];
        $plainlabelsprice  = 	$response['plainlabelsprice'];
        $label_finish  = 	$response['label_finish'];

        $promotiondiscount =$this->home_model->currecy_converter($promotiondiscount, 'yes');
        $plainlabelsprice =$this->home_model->currecy_converter($plainlabelsprice, 'yes');
        $label_finish =$this->home_model->currecy_converter($label_finish, 'yes');

        $response['price'] = $this->home_model->currecy_converter($response['price'], 'yes');
        $response['printprice'] =$this->home_model->currecy_converter($response['printprice'], 'yes');
        $response['designprice'] =$this->home_model->currecy_converter($response['designprice'], 'yes');
        $response['plainprint'] =$this->home_model->currecy_converter($response['plainprint'], 'yes');

        $promoprice = number_format($response['printprice']*2,2,'.','');

        if(isset($email) and $email != '')
        {

            $pref = array('email' => $email,
                'sessionID' => $this->session->userdata('session_id'));
            if($producttype == "roll")
            {
                $pref['labels_roll'] = $labels;
                $pref['coresize'] = $coresize;
                $pref['wound_roll'] = $wound;
                $pref['orientation'] = $orientation;
            }
            else
            {
                $pref['labels_a4'] = $labels;
            }

            $this->home_model->insert_preferences($pref);
        }


        $price_array = array('response'=>'yes',
            'price'=>$response['price'],
            'plainprice'=>$response['plainprice'],
            'plainprint'=>$response['plainprint'],
            'printprice'=>$response['printprice'],
            'promo'=>$promoprice,
            'designprice'=>$response['designprice'],
            'pressproof'=>$response['pressproof'],
            'artworks'=>$response['artworks'],
            'nodesing'=>$response['nodesing'],
            'sheets'=>$response['sheets'],
            'labels'=>$response['labels'],
            'delivery_txt'=>$response['delivery_txt'],
            'priceperlabels'=>$response['priceperlabels'],
            'symbol'=>symbol,
            'vatoption'=>vatoption ,
            'halfprintprice'=>number_format($promotiondiscount,2,'.',''),
            'onlyprintprice'=>number_format($promotiondiscount*2,2,'.',''),
            'fullprintprice'=>number_format($response['price']+$promotiondiscount,2,'.',''),
            'plainlabelsprice'=>number_format($plainlabelsprice,2,'.',''),
            'label_finish'=>number_format($label_finish,2,'.',''),
        );
        echo json_encode($price_array);
    }

    //    price calculator label-embellishment start
    function price_calculator_label_embellishment($data, $accessedBy = NULL)
    {
//        print_r($data);die;

        $free_artworks = 1;
        $pressproofprice = 0.00;
        $labels_per_rolls = '';
        $promotiondiscount = 0.00;
        $plainlabelsprice = 0.00;
        $label_finish = 0.00;

        $sheet_product_quality = $data['sheet_product_quality'];
        $producttype = $data['producttype'];
        $labels = $data['labels'];
        $persheets = $data['persheets'];
        $menu = $data['menu'];
        $design = $data['design'];
        //$labeltype = $data['labeltype'];
        $labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $data['labeltype']);
        $ProductBrand = $this->ProductBrand($menu);
        $finish = $data['finish'];

        if ($producttype == 'sheet') {

            $sheets = ceil($labels / $persheets);
            //$sheets  = $labels;
            // $labels = $persheets*$labels;

            $data = $this->product_model->ajax_price($sheets, $menu, $ProductBrand);

            $price = $data['custom_price'];
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 1;
//            print_r($labeltype);die;

            if ($labeltype == 'Mono' || $labeltype == 'Fullcolour' || $labeltype == 'Fullcolour+White') {

                if (isset($sheet_product_quality) && !empty($sheet_product_quality)){
                    if($sheet_product_quality == 'premium'){
                        $printprice = $this->home_model->calculate_printed_sheets_premium_label_embellishment($sheets, $labeltype, $design, $ProductBrand, $menu, $finish);

                    }elseif($sheet_product_quality == 'standerd'){
                        $printprice = $this->home_model->calculate_printed_sheets_label_embellishment($sheets, $labeltype, $design, $ProductBrand, $menu, $finish);

                    }
                }

                $label_finish_individual_cost_array = $printprice['label_finish_individual_cost_array'];
                $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $label_finish = $printprice['label_finish'];
                $printprice = $printprice['price'];

            }
        } else {


            $pressproof = $data['pressproof'];
            $rollfinish = $data['finish'];

            //$rolls = (isset($data['rolls']) and $data['rolls']!='')?$data['rolls']:'';

            $min_qty = $this->home_model->min_qty_roll($menu);
            if ($accessedBy != '' && $accessedBy == 'material_page') {

                $response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels, "", $accessedBy);
            } else {

                $response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels);
            }
//            print_r($response);die;

            $labels = $response['total_labels'];
            $labels_per_rolls = $response['per_roll'];
            $sheets = $response['rolls'];

            $collection['labels'] = $labels;
            $collection['manufature'] = $menu;
            $collection['finish'] = $data['finish'];
            $collection['rolls'] = $sheets;
            $collection['labeltype'] = $labeltype;

            $price_res = $this->home_model->calculate_printing_price_label_embellishment($collection);
            $label_finish_individual_cost_array = $price_res['label_finish_individual_cost_array'];
            $promotiondiscount = $price_res['promotiondiscount'];
            $plainlabelsprice = $price_res['plainprice'];
            $label_finish = $price_res['label_finish'];


            //137.51*1.1 = 151.261
            $price = $plainprice = $price_res['final_price'];

            /*************** Roll Labels Price *************/
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 10;
            if ($pressproof == 1) {
                $pressproofprice = 50.00;
            }
            /*************** Roll Labels Price *************/
        }


        //$('.nlabelfilter').trigger('mouseover');

        $delivery_txt = $this->shopping_model->delevery_txt();

        $ProductBrand = $this->ProductBrand($menu);
        if (isset($sheet_product_quality) && !empty($sheet_product_quality)) {
            if ($sheet_product_quality == 'standerd') {
                if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);
                    //For A5 Sheet Discount
                    if (preg_match("/A5 Labels/is", $ProductBrand)) {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A5');
                    } else {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
                    }

                    if ($material_discount) {
                        $wpep_discount = (($price) * ($material_discount / 100));
                        $wpep_discount = number_format($wpep_discount, 2, '.', '');
                        $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                        $price = number_format(($price - $wpep_discount), 2, '.', '');
                    }
                }
            }
        }


        $plainprice = number_format($price, 2, '.', '');
        $price = $designprice + $printprice + $price + $pressproofprice;
        $price = number_format($price, 2, '.', '');

        $pressproofprice = number_format($pressproofprice, 2, '.', '');


        if (preg_match("/WPEP/i", $menu) and $producttype == 'sheet') {
            $wpep_discount = (($plain) * (20 / 100));
            $price = number_format(($price - $wpep_discount), 2, '.', '');

        }

        $delivery_txt = '';
        if ($price > 25) {
            $delivery_txt = '<b> Free Delivery </b>';
        }
        $priceperlabels = number_format(($price / $labels), 3, '.', '');

        $price_array = array('price' => $price,
            'plainprint' => ($plainprice + $printprice),
            'plainprice' => $plainprice,
            'printprice' => $printprice,
            'designprice' => $designprice,
            'pressproof' => $pressproofprice,
            'priceperlabels' => $priceperlabels,
            'artworks' => $free_artworks,
            'nodesing' => $design,
            'sheets' => $sheets,
            'rolls' => $sheets,
            'labels' => $labels,
            'labels_per_rolls' => $labels_per_rolls,
            'delivery_txt' => $delivery_txt,
            'promotiondiscount' => $promotiondiscount,
            'plainlabelsprice' => $plainlabelsprice,
            'label_finish' => $label_finish,
            'label_finish_individual_cost_array' => $label_finish_individual_cost_array);

        return $price_array;


    }


    //    price calculator label-embellishment end

    function price_calculator($data, $accessedBy = NULL){

        $free_artworks = 1;
        $pressproofprice = 0.00;
        $labels_per_rolls = '';
        $promotiondiscount = 0.00;
        $plainlabelsprice = 0.00;
        $label_finish = 0.00;

        $producttype = $data['producttype'];
        $labels = $data['labels'];
        $persheets = $data['persheets'];
        $menu = $data['menu'];
        $design = $data['design'];
        //$labeltype = $data['labeltype'];

        $labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $data['labeltype']);
        $ProductBrand = $this->ProductBrand($menu);

        if($producttype == 'sheet'){

            $sheets = ceil($labels/$persheets);
            //$sheets  = $labels;
            // $labels = $persheets*$labels;

            $data=$this->product_model->ajax_price($sheets, $menu, $ProductBrand);
            $price = $data['custom_price'];
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 1;

            if($labeltype=='Mono' || $labeltype=='Fullcolour'){
                $printprice = $this->home_model->calculate_printed_sheets($sheets, $labeltype, $design, $ProductBrand, $menu);
                $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $printprice = $printprice['price'];
            }
        }else{


            $pressproof = $data['pressproof'];
            $rollfinish = $data['finish'];

            //$rolls = (isset($data['rolls']) and $data['rolls']!='')?$data['rolls']:'';

            $min_qty = $this->home_model->min_qty_roll($menu);

            if ($accessedBy != '' && $accessedBy == 'material_page') {
                $response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels, "", $accessedBy);
            } else {
                $response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels);
            }


            $labels = $response['total_labels'];
            $labels_per_rolls = $response['per_roll'];
            $sheets = $response['rolls'];


            $collection['labels'] = $labels;
            $collection['manufature'] = $menu;
            $collection['finish'] = $data['finish'];
            $collection['rolls'] = $sheets;
            $collection['labeltype'] = $labeltype;

            $price_res = $this->home_model->calculate_printing_price($collection);
            $promotiondiscount = $price_res['promotiondiscount'];
            $plainlabelsprice = $price_res['plainprice'];
            $label_finish = $price_res['label_finish'];


            //137.51*1.1 = 151.261
            $price = $plainprice = $price_res['final_price'];

            /*************** Roll Labels Price *************/
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 10;
            if ($pressproof == 1) {
                $pressproofprice = 50.00;
            }
            /*************** Roll Labels Price *************/
        }




        //$('.nlabelfilter').trigger('mouseover');

        $delivery_txt = $this->shopping_model->delevery_txt();

        $ProductBrand = $this->ProductBrand($menu);


        if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
            $mat_code = $this->home_model->getmaterialcode($menu);
            //For A5 Sheet Discount
            if (preg_match("/A5 Labels/is", $ProductBrand)) {
                $material_discount = $this->home_model->check_material_discount($mat_code, 'A5');
            } else {
                $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
            }

            if ($material_discount) {
                $wpep_discount = (($price) * ($material_discount / 100));
                $wpep_discount = number_format($wpep_discount, 2, '.', '');
                $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                $price = number_format(($price - $wpep_discount), 2, '.', '');
            }
        }


        $plainprice = number_format($price,2,'.','');
        $price = $designprice+$printprice+$price+$pressproofprice;
        $price = number_format($price,2,'.','');

        $pressproofprice = number_format($pressproofprice,2,'.','');


        if (preg_match("/WPEP/i", $menu)  and $producttype == 'sheet') {
            $wpep_discount = (($plain) * (20 / 100));
            $price = number_format(($price - $wpep_discount),2,'.','');

        }

        $delivery_txt = '';
        if($price > 25){
            $delivery_txt = '<b> Free Delivery </b>';
        }

        $priceperlabels = number_format(($price/$labels),3,'.','');

        $price_array = array('price'=>$price,
            'plainprint'=>($plainprice+$printprice),
            'plainprice'=>$plainprice,
            'printprice'=>$printprice,
            'designprice'=>$designprice,
            'pressproof'=>$pressproofprice,
            'priceperlabels'=>$priceperlabels,
            'artworks'=>$free_artworks,
            'nodesing'=>$design,
            'sheets'=>$sheets,
            'rolls'=>$sheets,
            'labels'=>$labels,
            'labels_per_rolls'=>$labels_per_rolls,
            'delivery_txt'=>$delivery_txt,
            'promotiondiscount'=>$promotiondiscount,
            'plainlabelsprice'=>$plainlabelsprice,
            'label_finish'=>$label_finish);
        return $price_array;


    }

    function continue_with_product()
    {


        $pressproof = 0;
        $orientation = '';
        $rollfinish = '';
        $design = 1;

        $labels = $this->input->post('qty');
        $persheets = $this->input->post('labelspersheets');

        $labeltype = $this->input->post('labeltype');
        $menu = $this->input->post('menuid');
        $productid = $this->input->post('prd_id');
        $cartid = $this->input->post('cartid');

        $rollfinish = $this->input->post('rollfinish');

        $coresize = $this->input->post('coresize');
        $woundoption = $this->input->post('woundoption');
        $orientation = $this->input->post('orientation');
        $producttype = $this->input->post('producttype');
        $pressproof = $this->input->post('pressproof');
        $unitqty = $this->input->post('unitqty');


        if ($producttype == 'roll') {
            $data['coresize'] = $coresize;
            $data['woundoption'] = $woundoption;
            $data['orientation'] = $orientation;
            if (isset($pressproof) and $pressproof == 1) {
                $pressproof = 1;
            }
            $sheets = ceil($labels / $persheets);
        } else {
            $sheets = $this->input->post('qty');
            $labels = $sheets * $persheets;
        }

        $data['unitqty'] = $unitqty;
        $data['sheets'] = $sheets;
        $data['labels'] = $labels;

        $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
        $data['details'] = $this->db->query($query)->row_array();


        /*if($labeltype == 'Full Colour'){ $labeltype = 'Fullcolour'; $Print_type = 'Fullcolour';}
			else if($labeltype == 'Full Colour + White'){ $labeltype = 'Fullcolour+White'; $Print_type = 'Fullcolour+White';}
			else if($labeltype == 'Black Only'){ $labeltype = 'Mono';  $Print_type = 'Mono';}*/

        $Print_type = $labeltype;
        //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);


        $values_array = array('labeltype' => $labeltype,
            'labels' => $labels,
            'design' => $design,
            'menu' => $menu,
            'persheets' => $persheets,
            'producttype' => $producttype,
            'pressproof' => $pressproof,
            'finish' => $rollfinish
        );


        $data['prices'] = $this->price_calculator($values_array);


        /******************  Add To Cart *****************/

        $wound = '';
        $is_custom = 'No';
        $LabelsPerRoll = '';
        $printing_options = array();
        $Print_Design = '1 Design';


        if ($data['details']['labelCategory'] == 'Roll Labels') {


            $data['details']['type'] = 'Rolls';
            $printprice = $data['prices']['price'];


            $orientation = str_replace("orientation", "", $orientation);


            $printing_options = array('Printing' => 'Y',
                'Print_Type' => $Print_type,
                'Print_Design' => $Print_Design,
                'Free' => $data['prices']['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => 0.00,
                'Print_Total' => 0.00);


            $labels = $data['prices']['labels'];
            $qty = $data['prices']['sheets'];
            $total = $printprice;
            $LabelsPerRoll = $data['prices']['labels_per_rolls'];

            $wound = $woundoption;
            $is_custom = 'Yes';
            $unit_price = $total / $qty;
            $data['sheets'] = $qty;


        } else {
            $design = $data['prices']['artworks'];
            if ($design > 1) {
                $Print_Design = 'Multiple Designs';
            }

            $data['details']['type'] = 'Sheets';
            $printprice = ($data['prices']['printprice']) + ($data['prices']['designprice']);
            $printing_options = array('Printing' => 'Y',
                'Print_Type' => $Print_type,
                'Print_Design' => $Print_Design,
                'Free' => $data['prices']['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => $printprice,
                'Print_Total' => $printprice);

            $qty = $sheets;
            $total = $data['prices']['plainprice'];
            $unit_price = $total / $qty;
        }


        $SID = $this->shopping_model->sessionid() . '-PRJB';
        if (($LabelsPerRoll == 0 || $LabelsPerRoll == "") && $producttype == "sheet") {
            $LabelsPerRoll = $persheets;
        }
        $items = array('SessionID' => $SID,
            'ProductID' => $productid,
            'source' => 'printing',
            'Quantity' => $qty,
            'orignalQty' => $labels,
            'UnitPrice' => $unit_price,
            'TotalPrice' => $total,
            'wound' => $wound,
            'is_custom' => $is_custom,
            'LabelsPerRoll' => $LabelsPerRoll,
            'orientation' => $orientation,
            'pressproof' => $pressproof,
            'FinishType' => $rollfinish);

        $items = array_merge($items, $printing_options);


        $userID = $this->session->userdata('userid');
        if (isset($userID) and $userID != '') {
            $cart_reminder = $this->home_model->get_db_column("customers", "cart_reminder", "UserID", $userID);
            if (isset($cart_reminder) and $cart_reminder == "Y") {
                $items['UserID'] = $userID;
            }
        }


        if (isset($cartid) and $cartid != '') {
            $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));

        } else {
            $this->db->insert('temporaryshoppingbasket', $items);
            if ($this->db->insert_id()) {
                $cartid = $this->db->insert_id();
            }

        }


        /*************** Discard Previously uploaded artowrks**************/
        $this->db->delete("integrated_attachments", array('SessionID' => $SID));
        /*************** Discard Previously uploaded artowrks**************/

        $data['details']['cartid'] = $cartid;

        /************************************************/


        $data['prices']['price'] = $this->home_model->currecy_converter($data['prices']['price'], 'yes');
        $data['prices']['printprice'] = $this->home_model->currecy_converter($data['prices']['printprice'], 'yes');
        $data['prices']['designprice'] = $this->home_model->currecy_converter($data['prices']['designprice'], 'yes');


        $data['details']['design'] = $design;
        $data['details']['rollfinish'] = $rollfinish;
        $data['details']['digitalprocess'] = $Print_type;

        $theHTMLResponse = $this->load->view('print_service/product_summary', $data, true);

        $json_data = array('response' => 'yes', 'content' => $theHTMLResponse);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }
    function dd($data){
        echo"<pre>";
        print_r($data);die;
    }


    //using this function to calculate cart price on values update/change in cart summery section of printed-labels start
    function material_continue_with_product_printed_labels()
    {
		//        print_r($this->input->post('selected_already_plates_composite_array'));die;
        $pressproof = 0;
        $orientation = '';
        $rollfinish = '';
        $design = 1;

        $flag = $this->input->post('flag');
        $refNumber = $this->input->post('refNumber');
        $lineNumber = $this->input->post('lineNumber');
        $o_quantity = $this->input->post('o_quantity');

        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
            $data['flag'] = $flag;
            $data['refNumber'] = $refNumber;
            $data['lineNumber'] = $lineNumber;

            if ($flag == 'order_detail'){
                $line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);
                //echo "<pre>Debuging<br>-----";print_r($line_detail);die();
                $table = 'orderdetails';
                $where_column = 'SerialNumber';
                $label_column = 'labels';
                $artwork_table = 'order_attachments_integrated';
            }elseif ($flag == 'quotation_detail'){
                $line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);

                $table = 'quotationdetails';
                $where_column = 'SerialNumber';
                $label_column = 'orignalQty';
                $artwork_table = 'quotation_attachments_integrated';
            }
        }

        $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
        $label_application = $this->input->post('label_application');
        $combination_base = $this->input->post('combination_base');

        $labels = $this->input->post('qty');
        $persheets = $this->input->post('labelspersheets');
        $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
        
        $digital_process_plus_white = $this->input->post('digital_process_plus_white');
        $labeltype = $this->input->post('labeltype');
        $menu = $this->input->post('menuid');
        $productid = $this->input->post('prd_id');
        $cartid = $this->input->post('cartid');
        //        $rollfinish = $this->input->post('rollfinish');

        $coresize = $this->input->post('coresize');
        $woundoption = $this->input->post('woundoption');
        $orientation = $this->input->post('orientation');
        $producttype = $this->input->post('producttype');
        $pressproof = $this->input->post('press_proof');

        $unitqty = $this->input->post('unitqty');
        $total_emb_plate_price = $this->input->post('total_emb_plate_price');
		//        using this array for price calculation of embellishment and finishes options
		//        $laminations_and_varnishes_array = $this->input->post('laminations_and_varnishes');
		//        $laminations_and_varnishes_array = $this->input->post('laminations_and_varnishes_childs');
		//       using this array to save embellishment & finshes options in temporaryShoppingBasket table

		        //    bypass 'total_emb_plate_price' variable from $this->input->post('total_emb_plate_price') and calculate
		//            it from backend on the basis of laminations_and_varnishes_childs array passed in post param.
		//            to prevent plate price wrong total due to already purchased module
        $laminations_and_varnishes_childs_array = $this->input->post('laminations_and_varnishes_childs');
        $rollfinish = $laminations_and_varnishes_childs_array;
        $rollfinish_child_array = $laminations_and_varnishes_childs_array;
        $plate_cost = 0;
        $selected_already_plates_composite_array = $this->input->post('selected_already_plates_composite_array');
        $minus_plate_cost = array();
        $use_old_plate = array();

        $page_reload = $this->input->post('page_reload');

        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
            $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' = '.$lineNumber .' ')->row_array();
        } else {
            $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID = "' . $cartid . '"')->row_array();
        }
        if (isset($row) && !empty($row)){
            $design = $row['Print_Qty'];

        }




        foreach ($rollfinish_child_array as $finish_child){
		//            print_r($finish_child); echo '<br>';
            $this->db->where('parsed_title', $finish_child);
            $this->db->where('label_emb_parent_id !=', 0);

            $cost_result = $this->db->get('label_embellishment')->row_array();

		//            use to calculate already purchased plate cost for minus plate price purpose
            foreach ($selected_already_plates_composite_array as $selected_already_plate_composite){
                $selected_already_plate_composite = json_decode($selected_already_plate_composite);

                if ($selected_already_plate_composite->already_used_plate_id == $cost_result['id'] ){

                    $plate_cost_obj = new stdClass();
                    $plate_cost_obj->parsed_title = $cost_result['parsed_title'];
                    $plate_cost_obj->plate_cost = $cost_result['plate_cost'];
                    $minus_plate_cost[] = $plate_cost_obj;

                    $use_old_plate_obj = new stdClass();
                    $use_old_plate_obj->parsed_title = $cost_result['parsed_title'];
                    $use_old_plate_obj->plate_order_no = $selected_already_plate_composite->plate_order_no;
                    $use_old_plate[] = $use_old_plate_obj;


                }
            }
            $plate_cost+= $cost_result['plate_cost'];
        }
        $data['minus_plate_cost'] = $minus_plate_cost;

        if($total_emb_plate_price <= 0){
            $total_emb_plate_price = 0;
            $data['total_emb_plate_price'] = $total_emb_plate_price;

        }else{
            $data['total_emb_plate_price'] = $plate_cost;

        }

      $SID = $this->shopping_model->sessionid() . '-PRJB';

        /*************** Discard Previously uploaded artowrks**************/
//        discard artworks only when page reload
        $page_reload = $this->input->post('page_reload');
        if (isset($page_reload) && !empty($page_reload)){
            $this->db->delete("integrated_attachments", array('SessionID' => $SID));

        }
        /*************** Discard Previously uploaded artowrks**************/

        if ($producttype == 'roll') {
            $data['coresize'] = $coresize;
            $data['woundoption'] = $woundoption;
            $data['orientation'] = $orientation;
            if (isset($pressproof) and $pressproof == 1) {
                $pressproof = 1;
            }

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $sheets = $o_quantity;
            } else {
        		$edit_cart_flag = $this->input->post('edit_cart_flag');
				if( $edit_cart_flag ) {
					$data['edit_cart_flag'] = $edit_cart_flag;
					$temp_basket_id = $this->input->post('temp_basket_id');
					if( isset($temp_basket_id) && $temp_basket_id != '' ) {
						$product_basket_data = $this->getCartAndProductData($temp_basket_id);
						$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
						$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
						$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
						$data['cart_and_product_data'] = $product_basket_data;
					}	

					$sheets = $data['cart_and_product_data']['Quantity'];
				} else {
					$query = " Select * from printing_preferences where sessionID = '" . $this->shopping_model->sessionid() . "' LIMIT 1 ";
	                $data_preferences = $this->db->query($query)->row_array();
	                $sheets = $data_preferences['no_of_rolls'];
				}
            }
        } else {
            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $sheets = $o_quantity;
            }else{

            	$edit_cart_flag = $this->input->post('edit_cart_flag');
				if( $edit_cart_flag ) {
					$data['edit_cart_flag'] = $edit_cart_flag;
					$temp_basket_id = $this->input->post('temp_basket_id');
					if( isset($temp_basket_id) && $temp_basket_id != '' ) {
						$product_basket_data = $this->getCartAndProductData($temp_basket_id);
						$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
						$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
						$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
						$data['cart_and_product_data'] = $product_basket_data;
					}	

					$sheets = $data['cart_and_product_data']['Quantity'];
				} else {
					$sheets = $this->input->post('qty');	
				}

            }
            $labels = $sheets * $persheets;
        }




        $data['unitqty'] = $unitqty;
        $data['sheets'] = $sheets;
        $data['labels'] = $labels;
        $data['labels_total_qty'] = $labels;
        $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";

        $data['details'] = $this->db->query($query)->row_array();

        if ( $data['details']['Shape_upd'] == "Circular") {
            $label_size = ucwords(str_replace("Label Size:", "",  $data['details']['specification3']));
            $label_size = str_replace("Mm", "", $label_size);
        } else {
            $label_size =  $data['details']['LabelWidth'] . " x " .  $data['details']['LabelHeight'];
            $label_size = str_replace("mm", "", $label_size);

        }

        $data['label_size'] = $label_size;


        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
            $preferences = $this->home_model->generate_preferences_data($line_detail);
        } else {
			$edit_cart_flag = $this->input->post('edit_cart_flag');
			if( $edit_cart_flag ) {
					$data['edit_cart_flag'] = $edit_cart_flag;
					$temp_basket_id = $this->input->post('temp_basket_id');
					if( isset($temp_basket_id) && $temp_basket_id != '' ) {
						$product_basket_data = $this->getCartAndProductData($temp_basket_id);
						$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
						$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
						$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
						$data['cart_and_product_data'] = $product_basket_data;
					}	
			} else {
				$session_id = $this->shopping_model->sessionid();
				$preferences = $this->orderModal->material_load_preferences($session_id);
			}
        }


        $data['preferences'] = $preferences;
		//        print_r($preferences);
        $data['availabel_in'] = $data['preferences']['available_in'];

        /*if($labeltype == 'Full Colour'){ $labeltype = 'Fullcolour'; $Print_type = 'Fullcolour';}
            else if($labeltype == 'Full Colour + White'){ $labeltype = 'Fullcolour+White'; $Print_type = 'Fullcolour+White';}
            else if($labeltype == 'Black Only'){ $labeltype = 'Mono';  $Print_type = 'Mono';}*/

        $Print_type = $labeltype;
        //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);

        if (preg_match("/Monochrome/i", $labeltype)) {
            $labeltype = "Monochrome - Black Only";


        } elseif (preg_match("/6_Colour_Digital_Process_White/i", $labeltype)) {
            $labeltype = "6 Colour Digital Process + White";


        } elseif (preg_match("/6_Colour_Digital_Process/i", $labeltype)) {
            $labeltype = "6 Colour Digital Process";


        }elseif (preg_match("/4_Colour_Digital_Process/i", $labeltype)) {
            $labeltype = "4 Colour Digital Process";


        }elseif (preg_match("/Rich_Black/i", $labeltype)) {
            $labeltype = "Rich Black";


        }

        if (isset($digital_process_plus_white) && !empty($digital_process_plus_white) && $digital_process_plus_white == "add_white" ){
            $labeltype = "6 Colour Digital Process + White";
        }

        // echo $labeltype;

        $data['labeltype'] = $labeltype;
        $data['producttype'] = $producttype;
        $data['rollfinish'] = $rollfinish;
		//        print_r($data['producttype']);die;


        if ($producttype == 'sheet') {

            $page_reload = $this->input->post('page_reload');
            if (isset($page_reload) && empty($page_reload)){
                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' = '.$lineNumber .' ')->row_array();
                } else {
                    $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID = "' . $cartid . '"')->row_array();
                }
                if (isset($row) && !empty($row)){
                    $design = $row['Print_Qty'];

                }

            }

            $printing_process = $this->home_model->get_digital_printing_process('a4');
            $data['printing_process'] = $printing_process;

            $sheet_product_quality = $this->input->post('sheet_product_quality');
		//            print_r($values_array);die;

            if(isset($sheet_product_quality) && !empty($sheet_product_quality)){

                if ($sheet_product_quality == 'premium'){
                    $values_array = array(
                        'printing' => $labeltype,
                        'labels' => $labels,
                        'design' => $design,
                        'menu' => $menu,
                        'persheets' => $persheets,
                        'producttype' => $producttype,
                        'pressproof' => $pressproof,
                        'finish' => $rollfinish,

                        'sheet_product_quality'=>"premium"
                    );


                    $data['prices'] = $this->calculate_sheet_price_printed_emb_page($values_array);

                }elseif ($sheet_product_quality == 'standerd'){
                    $values_array = array( 'printing' => $labeltype,
                        'labels' => $labels,
                        'design' => $design,
                        'menu' => $menu,
                        'persheets' => $persheets,
                        'producttype' => $producttype,
                        'pressproof' => $pressproof,
                        'finish' => $rollfinish,
                        'sheet_product_quality'=>"standerd"

                    );
                    $data['prices'] = $this->calculate_sheet_price_printed_emb_page($values_array);

                }
		//                execute first time when user land on finish & embellishment page & show both standerd & premium prices
            }else{

                $values_array = array( 'printing' => $labeltype,
                    'labels' => $labels,
                    'design' => $design,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => $producttype,
                    'pressproof' => $pressproof,
                    'finish' => $rollfinish,
                    'sheet_product_quality'=>"premium"
                );

                $data['premium_prices'] = $this->calculate_sheet_price_printed_emb_page($values_array);


                $values_array = array( 'printing' => $labeltype,
                    'labels' => $labels,
                    'design' => $design,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => $producttype,
                    'pressproof' => $pressproof,
                    'finish' => $rollfinish,
                    'sheet_product_quality'=>"standerd"

                );
                $data['prices'] = $this->calculate_sheet_price_printed_emb_page($values_array);


			//                if ($producttype == 'sheet' && empty($sheet_product_quality)) {
			//                    $alternate_option = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/alternate_option', $data, true);
			//                    $data['alternate_option'] = $alternate_option;
			//
			//                }else{
			//                    if(isset($sheet_product_quality) && !empty($sheet_product_quality)) {
			//
			//                        if ($sheet_product_quality == 'standerd') {
                $alternate_option = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/alternate_option', $data, true);
                $data['alternate_option'] = $alternate_option;
			//                        }
			//                    }
			//                }



            }

            $old_plate_cost_total_for_minus_total_price = 0;
            foreach ($data['prices']['label_finish_individual_cost_array'] as $key=> $label_finish_individual_cost_array) {
                $data['prices']['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                if (isset($use_old_plate) && count($use_old_plate) > 0) {
                    foreach ($use_old_plate as $old_plate) {
                        if ($label_finish_individual_cost_array->finish_parsed_title == $old_plate->parsed_title) {
                            $old_plate_cost_total_for_minus_total_price+=$label_finish_individual_cost_array->plate_cost;
                            $data['prices']['label_finish_individual_cost_array'][$key]->use_old_plate = 1;
                            $data['prices']['label_finish_individual_cost_array'][$key]->used_plate_orderNumber = $old_plate->plate_order_no;
                        }

                    }
                } else {
                    $data['prices']['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                }
            }
        } else {
            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $actual_labels = $this->home_model->get_db_column($table, $label_column, $where_column, $lineNumber);
                $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
            } else {
                $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);
                $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
            }

            if ($actual_labels <= $upload_qty['labels']) {
                $limit_exceed_sheets = 'yes';
            }

            if ($limit_exceed_sheets == 'yes') {

                $labels = ($upload_qty['labels'] > $labels) ? $upload_qty['labels'] : $labels;
                $qty = $upload_qty['qty'];
            }else{
                $qty = $sheets;
//                echo $qty;die;
            }


            $values_array_roll_price = array(
                'roll' => $qty,
                'menu' => $menu,
                'prd_id' => $productid,
                'labels' => $labels,
                'printing' => $labeltype,
                'persheets'=>$persheets,
                'pressproof'=>$pressproof,
                'requestfrom' => "material_page",
                'rollfinish' => $rollfinish,
                'upload_artwork_option_radio' => $upload_artwork_option_radio
            );
			//        function that call price calculator function for label-embellishment page
            $data['prices'] = $this->calculate_roll_price_printed_emb_page($values_array_roll_price);

            /*echo "1<pre>";
            print_r($data['prices']);
            echo "</pre>";
            die();*/
            $printprice = 0;
            if ($qty > $data['prices']['rolls']) {
                $additional_rolls = $qty - $data['prices']['rolls'];
                $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                $data['prices']['additional_cost'] = number_format($additional_cost, 2, '.', '');

                $printprice = $printprice + $additional_cost;
            }

            $old_plate_cost_total_for_minus_total_price = 0;
            foreach ($data['prices']['label_finish_individual_cost_array'] as $key=> $label_finish_individual_cost_array) {
                $data['prices']['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                if (isset($use_old_plate) && count($use_old_plate) > 0) {
                    foreach ($use_old_plate as $old_plate) {
                        if ($label_finish_individual_cost_array->finish_parsed_title == $old_plate->parsed_title) {
                            $old_plate_cost_total_for_minus_total_price+=$label_finish_individual_cost_array->plate_cost;
                            $data['prices']['label_finish_individual_cost_array'][$key]->use_old_plate = 1;
                            $data['prices']['label_finish_individual_cost_array'][$key]->used_plate_orderNumber = $old_plate->plate_order_no;
                        }

                    }
                } else {
                    $data['prices']['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                }
            }


        }
        /******************  Add To Cart *****************/

        $wound = '';
        $is_custom = 'No';
        $LabelsPerRoll = '';
        $printing_options = array();
        $Print_Design = '1 Design';


        if ($data['details']['labelCategory'] == 'Roll Labels') {


            $data['details']['type'] = 'Rolls';
		//            $printprice = $data['prices']['rawprice'];
		//            $printprice += $total_emb_plate_price;

            $orientation = str_replace("orientation", "", $orientation);

            // echo "<pre>";
            // 	print_r($data['prices']);
            // echo "</pre>";
            // die();
            //$printprice += ($data['prices']['printprice']) + $data['prices']['plainlabelsprice'] + ($data['prices']['presproof_charges']) + ($data['prices']['label_finish']) ;
            $printprice += ($data['prices']['halfprintprice']) + $data['prices']['plainlabelsprice'] + ($data['prices']['presproof_charges']) + ($data['prices']['label_finish']) ;
            $plate_cost -=$old_plate_cost_total_for_minus_total_price;
            $printprice += $plate_cost;

            $total_emb_cost = $data['prices']['label_finish'] + $plate_cost;

            /*$page_reload = $this->input->post('page_reload');
            if (isset($page_reload) && empty($page_reload)){
                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' = '.$lineNumber .' ')->row_array();
                } else {
                    $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID = "' . $cartid . '"')->row_array();
                }
                if (isset($row) && !empty($row)){
                    $design = $row['Print_Qty'];

                }

            }*/

            //echo $printprice;die();

            $printing_options = array('Printing' => 'Y',
                'Print_Type' => $labeltype,
                'Print_Design' => $Print_Design,
                'Free' => $data['prices']['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => 0,
                'total_emb_cost' => $total_emb_cost,
                'Print_Total' => 0
            );

            $labels = $labels;
            $qty = $data['sheets'];
            $LabelsPerRoll = $data['prices']['labels_per_rolls'];
            $total = $printprice;
            $unit_price = $total / $qty;
            $wound = $woundoption;
            $is_custom = 'Yes';
            $data['sheets'] = $qty;
        } else {
            if (!isset($design) || empty($design)){
                $design = $data['prices']['artworks'];

            }
            if ($design > 1) {
                $Print_Design = 'Multiple Designs';
            }
            $data['details']['type'] = 'Sheets';
            $printprice = ($data['prices']['printprice']) + ($data['prices']['designprice']) + ($data['prices']['label_finish']) ;
            $plate_cost -=$old_plate_cost_total_for_minus_total_price;
            $printprice += $plate_cost;
            $total_emb_cost = $data['prices']['label_finish'] + $plate_cost;

            $printing_options = array('Printing' => 'Y',
                'Print_Type' => $labeltype,
                'Print_Design' => $Print_Design,
                'Free' => $data['prices']['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => $printprice,
                'total_emb_cost' => $total_emb_cost,
                'Print_Total' => $printprice);

            $qty = $sheets;
            $total = $data['prices']['plainprice'];
            $unit_price = $total / $qty;
        }


		if( $edit_cart_flag ) {        
			$SID = $this->shopping_model->sessionid();
		} else {
			$SID = $this->shopping_model->sessionid() . '-PRJB';
		}
        
        if (($LabelsPerRoll == 0 || $LabelsPerRoll == "") && $producttype == "sheet") {
            $LabelsPerRoll = $persheets;
        }

		/*echo '<pre>';
        print_r($this->input->post('product_preferences')); exit;*/

        $items = array(
			'SessionID' => $SID,
			'ProductID' => $productid,
            'source' => 'printing',
            'Quantity' => $qty,
            'orignalQty' => $labels,
            'UnitPrice' => $unit_price,
            'TotalPrice' => $total,
            'wound' => $wound,
            'is_custom' => $is_custom,
            'LabelsPerRoll' => $LabelsPerRoll,
            'orientation' => $orientation,
            'pressproof' => $pressproof,
            'FinishTypePrintedLabels' => json_encode($rollfinish_child_array),
            'FinishTypePricePrintedLabels' => json_encode($data['prices']['label_finish_individual_cost_array']),
            'use_old_plate' => json_encode($use_old_plate),
            'custom_roll_and_label' => $upload_artwork_option_radio,
            'label_application' => $label_application,
            'combination_base' => $combination_base
        );

        $items = array_merge($items, $printing_options);

        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {

            $updation_array = $this->home_model->emb_update_line($items,$flag,$refNumber,$lineNumber);

            $data['flag'] = $flag;
            $data['refNumber'] = $refNumber;
            $data['lineNumber'] = $lineNumber;

        } else{

            $userID = $this->session->userdata('userid');
            if (isset($userID) and $userID != '') {
                $cart_reminder = $this->home_model->get_db_column("customers", "cart_reminder", "UserID", $userID);
                if (isset($cart_reminder) and $cart_reminder == "Y") {
                    $items['UserID'] = $userID;
                }
            }

			if (isset($cartid) and $cartid != '') {
				$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid));
			} else {
				$this->db->insert('temporaryshoppingbasket', $items);
				if ($this->db->insert_id()) {
					$cartid = $this->db->insert_id();
				}

			}
			//print_r($SID);die;

			/*************** Discard Previously uploaded artowrks**************/
			if( !$edit_cart_flag ) {
				$this->db->delete("integrated_attachments", array('SessionID' => $SID));
			}
			
			$data['details']['cartid'] = $cartid;

        /*************** Discard Previously uploaded artowrks**************/

            /************************************************/

        }

        //echo "<pre>";print_r($data);die();

        $data['prices']['price'] = $this->home_model->currecy_converter($data['prices']['price'], 'yes');
        $data['prices']['printprice'] = $this->home_model->currecy_converter($data['prices']['printprice'], 'yes');
        $data['prices']['designprice'] = $this->home_model->currecy_converter($data['prices']['designprice'], 'yes');

        $data['details']['design'] = $design;
        $data['details']['rollfinish'] = $rollfinish;
        $data['details']['digitalprocess'] = $Print_type;

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();*/


        $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);
        $data['content'] = $theHTMLResponse;

        $artworkUploadHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/artwork_upload', $data, true);
        $data['artwork_upload_view'] = $artworkUploadHTMLResponse;

        $in_house_design_service = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/in_house_design_service', $data, true);
        $data['in_house_design_service'] = $in_house_design_service;

        $json_data = array('response' => 'yes', 'data' => $data);

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }

//using this function to create artwork upload table on user selected options from first popup where user defines artwork lines

    function material_populate_artwork_upload_table_printed_labels()
    {

        $flag = $this->input->post('flag');
        $refNumber = $this->input->post('refNumber');
        $lineNumber = $this->input->post('lineNumber');

        $labels = $this->input->post('qty');
        $persheets = $this->input->post('labelspersheets');

        $labeltype = $this->input->post('labeltype');
        $menu = $this->input->post('menuid');

        $producttype = $this->input->post('producttype');
        $unitqty = $this->input->post('unitqty');
        $upload_artwork_radio = $this->input->post('upload_artwork_radio');
        $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');

        $data['lines_to_populate'] = $this->input->post('lines_to_populate');
        $data['upload_artwork_option_radio'] = $upload_artwork_option_radio;
        $data['upload_artwork_radio'] = $upload_artwork_radio;
		$data['flag'] = $flag;
        $data['refNumber'] = $refNumber;
		$data['lineNumber'] = $lineNumber;
		
        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
			$data['flag'] = $flag;
			$data['refNumber'] = $refNumber;
			$data['lineNumber'] = $lineNumber;
		
			if ($flag == 'order_detail'){
				$line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);
		
				$table = 'orderdetails';
				$where_column = 'SerialNumber';
				$artwork_table = 'order_attachments_integrated';
			}elseif ($flag == 'quotation_detail'){
				$line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);
		
				$table = 'quotationdetails';
				$where_column = 'SerialNumber';
				$artwork_table = 'quotation_attachments_integrated';
			}
		}
		
		if ($producttype == 'roll') {
			if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
				$sheets = $line_detail->Quantity;
			} else {

				$edit_cart_flag = $this->input->post('edit_cart_flag');
				if( $edit_cart_flag ) {
					$data['edit_cart_flag'] = $edit_cart_flag;
					$temp_basket_id = $this->input->post('temp_basket_id');
					if( isset($temp_basket_id) && $temp_basket_id != '' ) {
						$product_basket_data = $this->getCartAndProductData($temp_basket_id);
						$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
						$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
						$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
						$data['cart_and_product_data'] = $product_basket_data;
						$sheets = $product_basket_data['Quantity'];
					}
				} else {
					$query = " Select * from printing_preferences where sessionID = '" . $this->shopping_model->sessionid() . "' LIMIT 1 ";
					$data_preferences = $this->db->query($query)->row_array();
					$sheets = $data_preferences['no_of_rolls'];
				}
			}
		} else {
			$sheets = $this->input->post('qty');
			$labels = $sheets * $persheets;
		}

        
        $data['unitqty'] = $unitqty;
        $data['sheets'] = $sheets;
        $data['labels'] = $labels;
        $data['labels_total_qty'] = $labels;
        $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
        $data['details'] = $this->db->query($query)->row_array();
        $data['details']['cartid'] = $this->input->post('cartid');

        $Print_type = $labeltype;
        
        //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);

        if (preg_match("/Monochrome/i", $labeltype)) {
            $labeltype = "Monochrome - Black Only";


        } elseif (preg_match("/6_Colour_Digital_Process_White/i", $labeltype)) {
            $labeltype = "6 Colour Digital Process + White";


        } elseif (preg_match("/6_Colour_Digital_Process/i", $labeltype)) {
            $labeltype = "6 Colour Digital Process";


        }elseif (preg_match("/4_Colour_Digital_Process/i", $labeltype)) {
            $labeltype = "4 Colour Digital Process";


        }

        $data['labeltype'] = $labeltype;
        $data['producttype'] = $producttype;

        /******************  Add To Cart *****************/




        /************************************************/



        // echo "<pre>";
        // 	print_r($data);
        // echo "</pre>";

        $artworkUploadHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/artwork_upload_modal_2', $data, true);
        $data['artwork_upload_view'] = $artworkUploadHTMLResponse;

        $json_data = array('response' => 'yes', 'data' => $data);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }


    //using this function to calculate cart price on values update/change in cart summery section of printed-labels end


    function material_continue_with_product()
    {


        $pressproof = 0;
        $orientation = '';
        $rollfinish = '';
        $design = 1;

        $labels = $this->input->post('qty');
        $persheets = $this->input->post('labelspersheets');

        $labeltype = $this->input->post('labeltype');
        $menu = $this->input->post('menuid');
        $productid = $this->input->post('prd_id');
        $cartid = $this->input->post('cartid');

        $rollfinish = $this->input->post('rollfinish');

        $coresize = $this->input->post('coresize');
        $woundoption = $this->input->post('woundoption');
        $orientation = $this->input->post('orientation');
        $producttype = $this->input->post('producttype');
        $pressproof = $this->input->post('pressproof');
        $unitqty = $this->input->post('unitqty');


        if ($producttype == 'roll') {
            $data['coresize'] = $coresize;
            $data['woundoption'] = $woundoption;
            $data['orientation'] = $orientation;
            if (isset($pressproof) and $pressproof == 1) {
                $pressproof = 1;
            }

            $query = " Select * from printing_preferences where sessionID = '" . $this->shopping_model->sessionid() . "' LIMIT 1 ";
            $data_preferences = $this->db->query($query)->row_array();
            $sheets = $data_preferences['no_of_rolls'];
            // $sheets = ceil($labels / $persheets);
        } else {
            $sheets = $this->input->post('qty');
            $labels = $sheets * $persheets;
        }

        $data['unitqty'] = $unitqty;
        $data['sheets'] = $sheets;
        $data['labels'] = $labels;

        $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
        $data['details'] = $this->db->query($query)->row_array();


        /*if($labeltype == 'Full Colour'){ $labeltype = 'Fullcolour'; $Print_type = 'Fullcolour';}
            else if($labeltype == 'Full Colour + White'){ $labeltype = 'Fullcolour+White'; $Print_type = 'Fullcolour+White';}
            else if($labeltype == 'Black Only'){ $labeltype = 'Mono';  $Print_type = 'Mono';}*/

        $Print_type = $labeltype;
        //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);


        $values_array = array('labeltype' => $labeltype,
            'labels' => $labels,
            'design' => $design,
            'menu' => $menu,
            'persheets' => $persheets,
            'producttype' => $producttype,
            'pressproof' => $pressproof,
            'finish' => $rollfinish
        );


        $data['prices'] = $this->price_calculator($values_array, "material_page");


        /******************  Add To Cart *****************/

        $wound = '';
        $is_custom = 'No';
        $LabelsPerRoll = '';
        $printing_options = array();
        $Print_Design = '1 Design';


        if ($data['details']['labelCategory'] == 'Roll Labels') {


            $data['details']['type'] = 'Rolls';
            $printprice = $data['prices']['price'];


            $orientation = str_replace("orientation", "", $orientation);


            $printing_options = array('Printing' => 'Y',
                'Print_Type' => $Print_type,
                'Print_Design' => $Print_Design,
                'Free' => $data['prices']['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => 0.00,
                'Print_Total' => 0.00);


            $labels = $data['prices']['labels'];
            $qty = $data['prices']['sheets'];
            $total = $printprice;
            $LabelsPerRoll = $data['prices']['labels_per_rolls'];

            $wound = $woundoption;
            $is_custom = 'Yes';
            $unit_price = $total / $qty;
            $data['sheets'] = $qty;


        } else {
            $design = $data['prices']['artworks'];
            if ($design > 1) {
                $Print_Design = 'Multiple Designs';
            }

            $data['details']['type'] = 'Sheets';
            $printprice = ($data['prices']['printprice']) + ($data['prices']['designprice']);
            $printing_options = array('Printing' => 'Y',
                'Print_Type' => $Print_type,
                'Print_Design' => $Print_Design,
                'Free' => $data['prices']['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => $printprice,
                'Print_Total' => $printprice);

            $qty = $sheets;
            $total = $data['prices']['plainprice'];
            $unit_price = $total / $qty;
        }


        $SID = $this->shopping_model->sessionid() . '-PRJB';
        if (($LabelsPerRoll == 0 || $LabelsPerRoll == "") && $producttype == "sheet") {
            $LabelsPerRoll = $persheets;
        }
        $items = array('SessionID' => $SID,
            'ProductID' => $productid,
            'source' => 'printing',
            'Quantity' => $qty,
            'orignalQty' => $labels,
            'UnitPrice' => $unit_price,
            'TotalPrice' => $total,
            'wound' => $wound,
            'is_custom' => $is_custom,
            'LabelsPerRoll' => $LabelsPerRoll,
            'orientation' => $orientation,
            'pressproof' => $pressproof,
            'FinishType' => $rollfinish);

        $items = array_merge($items, $printing_options);


        $userID = $this->session->userdata('userid');
        if (isset($userID) and $userID != '') {
            $cart_reminder = $this->home_model->get_db_column("customers", "cart_reminder", "UserID", $userID);
            if (isset($cart_reminder) and $cart_reminder == "Y") {
                $items['UserID'] = $userID;
            }
        }


        if (isset($cartid) and $cartid != '') {
            $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));

        } else {
            $this->db->insert('temporaryshoppingbasket', $items);
            if ($this->db->insert_id()) {
                $cartid = $this->db->insert_id();
            }

        }


        /*************** Discard Previously uploaded artowrks**************/
        $this->db->delete("integrated_attachments", array('SessionID' => $SID));
        /*************** Discard Previously uploaded artowrks**************/

        $data['details']['cartid'] = $cartid;

        /************************************************/


        $data['prices']['price'] = $this->home_model->currecy_converter($data['prices']['price'], 'yes');
        $data['prices']['printprice'] = $this->home_model->currecy_converter($data['prices']['printprice'], 'yes');
        $data['prices']['designprice'] = $this->home_model->currecy_converter($data['prices']['designprice'], 'yes');


        $data['details']['design'] = $design;
        $data['details']['rollfinish'] = $rollfinish;
        $data['details']['digitalprocess'] = $Print_type;

        $theHTMLResponse = $this->load->view('material_print_service/product_summary', $data, true);
        $theHTMLResponse_home = $this->load->view('material_print_service/home_product_summary', $data, true);


        $json_data = array('response' => 'yes', 'content' => $theHTMLResponse, 'content_home' => $theHTMLResponse_home);

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }


    function upload_printing_artworks(){

        $json_data = array('response'=>'no', 'message' =>'failed to upload this file, please try again');

        if (!empty($_FILES)) {

            $limit_exceed_sheets = '';
            $limit_exceed_designs = '';


            $design = '';
            $labels = '';
            $qty = '';
            $sidebar = '';

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $artworkname = $this->input->post('artworkname');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $data['unitqty'] = $this->input->post('unitqty');


            $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');
            $limit_exceed_designs = $this->input->post('limit_exceed_designs');

            //$persheet = 44;


            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $response = $this->home_model->upload_images('file','/');

            if($response!='error'){

                $sid = $this->session->userdata('session_id').'-PRJB';
                $artowrk = array('SessionID'=>$sid,
                    'ProductID'=>$productid,
                    'CartID'=>$cartid,
                    'name'=>$artworkname,
                    'labels'=>$labels,
                    'qty'=>$sheets,
                    'file'=>$response,
                    'status'=>'confirm',
                );
                $this->db->insert('integrated_attachments',$artowrk);


                if($type == 'roll'){

                    $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                    $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
										WHERE CartID LIKE "'.$cartid.'" AND ProductID LIKE "'.$productid.'" ')->row_array();

                    if($actual_labels <= $upload_qty){
                        $limit_exceed_sheets = 'yes';
                    }
                }


                if(!empty($limit_exceed_designs) || !empty($limit_exceed_sheets)){


                    $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "'.$cartid.'"')->row_array();
                    $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

                    $design = $row['Print_Qty'];
                    //$labels = $row['orignalQty']*$persheet;
                    $labels = $row['orignalQty'];
                    $qty = $row['Quantity'];


                    if($limit_exceed_designs == 'yes'){
                        $design = ($design+1);
                    }
                    if($limit_exceed_sheets == 'yes'){
                        $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
										WHERE CartID LIKE "'.$cartid.'" AND ProductID LIKE "'.$productid.'" ')->row_array();
                        $labels = ($quantity['labels'] > $labels)?$quantity['labels']:$labels;
                        $qty = $quantity['qty'];
                    }

                    if($type == 'roll'){ $product_type = 'roll';}
                    else{ $product_type = 'sheet';}

                    $values_array = array('labeltype'=>$row['Print_Type'],
                        'labels'=>$labels,
                        'rolls'=>$qty,
                        'design'=>$design,
                        'menu'=>$menu,
                        'persheets'=>$persheet,
                        'producttype'=>$product_type,
                        'pressproof'=>$row['pressproof'],
                        'finish'=>$row['FinishType']);
                    $prices = $this->price_calculator($values_array);

                    $printprice = ($prices['printprice'])+ ($prices['designprice']);

                    if($type == 'roll'){
                        $printprice = $prices['price'];
                        if($qty > $prices['rolls']){
                            $additional_rolls = $qty-$prices['rolls'];
                            $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                            $prices['additional_cost'] = $additional_cost;
                            $printprice = $printprice+$additional_cost;
                        }
                        $prices['price'] = $printprice;
                        $prices['plainprice'] = $printprice;
                        $printprice = 0;
                    }

                    $Print_Design = '1 Design';
                    if($design > 1){
                        $Print_Design = 'Multiple Designs';
                    }
                    $printing_items = array( 'Free'=>$prices['artworks'],
                        'Print_Qty'=>$design,
                        'Print_Design'=>$Print_Design,
                        'Print_UnitPrice'=>$printprice,
                        'Print_Total'=>$printprice);
                    $unit_price = $prices['plainprice']/$qty;

                    $items = array('Quantity'=>$qty,
                        'orignalQty'=>$labels,
                        'UnitPrice'=>$unit_price,
                        'TotalPrice'=>$prices['plainprice']);


                    $items = array_merge($items, $printing_items);

                    $SID  =  $this->shopping_model->sessionid().'-PRJB';
                    $this->db->update('temporaryshoppingbasket',$items, array('ID'=>$cartid,'SessionID'=>$SID));



                    $data['prices'] =  $prices;
                    $data['labels'] =  $labels;
                    $data['sheets'] =  $qty;
                    $data['designs'] = $design;


                    $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
							AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                    $data['details'] = $this->db->query($query)->row_array();

                    $data['details']['rollfinish'] = $row['FinishType'];

                    //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                    /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
                    else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
                    else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/
                    $data['details']['digitalprocess'] =$row['Print_Type'];

                    $data['coresize'] = "R".substr($data['details']['ManufactureID'],0,-1);


                    $data['sidebar_class'] = 'orangeBg';
                    $sidebar = $this->load->view('print_service/product_overview_sidebar', $data, true);


                }

                $data['details']['cartid'] = $cartid;
                $data['details']['ProductID'] = $productid;

                $data['details']['LabelsPerSheet'] = $persheet;

                if($type == 'roll'){
                    $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                    $theHTMLResponse = $this->load->view('print_service/upload/roll_artwork_files', $data, true);
                }else{
                    $theHTMLResponse = $this->load->view('print_service/upload/a4_artwork_files', $data, true);
                }

                $json_data = array('response'=>'yes',
                    'content'=>$theHTMLResponse,
                    'design'=>$design,
                    'labels'=>$labels,
                    'qty'=>$qty,
                    'limit_exceed_designs'=>$limit_exceed_designs,
                    'limit_exceed_sheets'=>$limit_exceed_sheets,
                    'sidebar'=>$sidebar);
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }


    //    upload file function for label emb task upload modal
    function material_upload_printing_artworks_label_emb()
    {
       /* echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        die();*/


        $json_data = array('response' => 'no', 'message' => 'failed to upload this file, please try again');

        $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
        $upload_artwork_radio = $this->input->post('upload_artwork_radio');
        $label_application = $this->input->post('label_application');
        $combination_base = $this->input->post('combination_base');
        $data['upload_artwork_radio'] = $upload_artwork_radio;
        $data['upload_artwork_option_radio'] = $upload_artwork_option_radio;
        $data['lines_to_populate'] = $this->input->post('lines_to_populate');

        $flag = $this->input->post('flag');
        $refNumber = $this->input->post('refNumber');
        $lineNumber = $this->input->post('lineNumber');

        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
            $data['flag'] = $flag;
            $data['refNumber'] = $refNumber;
            $data['lineNumber'] = $lineNumber;

            if ($flag == 'order_detail'){
                $line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);

                $table = 'orderdetails';
                $where_column = 'SerialNumber';
                $label_column = 'labels';
                $artwork_table = 'order_attachments_integrated';
            }elseif ($flag == 'quotation_detail'){
                $line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);

                $table = 'quotationdetails';
                $where_column = 'SerialNumber';
                $label_column = 'orignalQty';
                $artwork_table = 'quotation_attachments_integrated';
            }
        }

        $session_id = $this->shopping_model->sessionid();
        $preferences = $this->orderModal->material_load_preferences($session_id);

        $edit_cart_flag = $this->input->post('edit_cart_flag');



        if ($upload_artwork_radio == "upload_artwork_now") {
            if (!empty($_FILES)) {

                $limit_exceed_sheets = '';
                $limit_exceed_designs = '';


                $design = '';
                $labels = '';
                $qty = '';
                $sidebar = '';
                $digital_process_plus_white = $this->input->post('digital_process_plus_white');

                $cartid = $this->input->post('cartid');
                $productid = $this->input->post('productid');

				$product_branding = $this->ProductBrandByProductId($productid);
                $product_branding = str_replace(" Labels", "", $product_branding);
                $product_branding = str_replace(" Label", "", $product_branding);


                if (preg_match("/SRA3/i", $product_branding)) {
                    $brand = 'SRA3';
                } else if (preg_match("/A5/i", $product_branding)) {
                    $brand = 'A5';
                } else if (preg_match("/A3/i", $product_branding)) {
                    $brand = 'A3';
                } else if (preg_match("/Roll/i", $product_branding)) {
                    $brand = 'Rolls';
                } else if (preg_match("/Integrated/i", $product_branding)) {
                    $brand = 'Integrated';
                } else {
                    $brand = 'A4';
                }

                $labels = $this->input->post('labels');
                $sheets = $this->input->post('sheets');
                $artworkname = $this->input->post('artworkname');
                $persheet = $this->input->post('persheet');
                $type = $this->input->post('type');
                $data['unitqty'] = $this->input->post('unitqty');
//                $laminations_and_varnishes = $this->input->post('laminations_and_varnishes');
                $laminations_and_varnishes_childs_array = $this->input->post('laminations_and_varnishes_childs');
                $pressproof = $this->input->post('press_proof');
                $persheets = $this->input->post('persheet');

                $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');
                $limit_exceed_designs = $this->input->post('limit_exceed_designs');

//           bypass 'total_emb_plate_price' variable from $this->input->post('total_emb_plate_price') and calculate
//            it from backend on the basis of laminations_and_varnishes_childs array passed in post param.
//            to prevent plate price wrong total due to already purchased module
//                $rollfinish_child_array = $laminations_and_varnishes_childs_array;
                $plate_cost = 0;
                $minus_plate_cost = array();
                $use_old_plate = array();
                if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                    $rollfinish_child_array = explode(',',$laminations_and_varnishes_childs_array);
                    $selected_already_plates_composite_array =  json_decode($this->input->post('selected_already_plates_composite_array'));
//                        $selected_already_plates_composite_array = explode('},',$selected_already_plates_composite_array);

//                        echo"<pre>";
//                        print_r( ($selected_already_plates_composite_array));

                    foreach ($rollfinish_child_array as $finish_child){
//            print_r($finish_child); echo '<br>';
                        $this->db->where('parsed_title', $finish_child);
                        $this->db->where('label_emb_parent_id !=', 0);

                        $cost_result = $this->db->get('label_embellishment')->row_array();

//            use to calculate already purchased plate cost for minus plate price purpose
                        foreach ($selected_already_plates_composite_array as $selected_already_plate_composite){
                            $selected_already_plate_composite = json_decode($selected_already_plate_composite);
//                                print_r($selected_already_plate_composite->already_used_plate_id );

                            if ($selected_already_plate_composite->already_used_plate_id == $cost_result['id'] ){

                                $plate_cost_obj = new stdClass();
                                $plate_cost_obj->parsed_title = $cost_result['parsed_title'];
                                $plate_cost_obj->plate_cost = $cost_result['plate_cost'];
                                $minus_plate_cost[] = $plate_cost_obj;

                                $use_old_plate_obj = new stdClass();
                                $use_old_plate_obj->parsed_title = $cost_result['parsed_title'];
                                $use_old_plate_obj->plate_order_no = $selected_already_plate_composite->plate_order_no;
                                $use_old_plate[] = $use_old_plate_obj;

                            }
                        }
                        $plate_cost+= $cost_result['plate_cost'];
                    }
                    $data['minus_plate_cost'] = $minus_plate_cost;
//          echo "<pre>";  print_r($cost_result['plate_cost']);
                }
//       echo '<br>'; print_r($plate_cost);

                if($plate_cost <= 0){
                    $total_emb_plate_price = 0;
                    $data['total_emb_plate_price'] = $total_emb_plate_price;

                }else{
                    $data['total_emb_plate_price'] = $plate_cost;

                }


                //$persheet = 44;


                $tempFile = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                $response = $this->home_model->upload_images('file', '/');

                if ($response != 'error') {

                    if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {

                        $artowrk = array(
                            'UserID' => $line_detail->UserID,
                            'OrderNumber'=> $refNumber,
                            'Serial' => $lineNumber,
                            'Brand' => $brand,
                            'ProductID' => $productid,
                            'diecode' => $line_detail->ManufactureID,
                            'name' => $artworkname,
                            'labels' => $labels,
                            'qty' => $sheets,
                            'source' => "backoffice",
                            'file' => $response,
                            'status' => 64,
                        );

                        if ($flag == 'quotation_detail'){
                            $artowrk['QuotationNumber'] = $artowrk['OrderNumber'];
                            $artowrk['UserID'] = $line_detail->CustomerID;
                            unset($artowrk['OrderNumber']);
                            unset($artowrk['Brand']);
                        }

                        $this->db->insert($artwork_table, $artowrk);
                    } else {
						if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
							$sid = $this->session->userdata('session_id');
						} else {
							$sid = $this->session->userdata('session_id') . '-PRJB';
						}
						
						$artowrk = array(
							'SessionID' => $sid,
							'ProductID' => $productid,
							'CartID' => $cartid,
							'name' => $artworkname,
							'labels' => $labels,
							'qty' => $sheets,
							'file' => $response,
							'status' => 'confirm',
						);
						$this->db->insert('integrated_attachments', $artowrk);
                    }

                    if ($type == 'roll') {

                        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                            $actual_labels = $this->home_model->get_db_column($table, $label_column, $where_column, $lineNumber);

                            $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
                        } else {
                            $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                            $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                        }


                        if ($actual_labels <= $upload_qty) {
                            $limit_exceed_sheets = 'yes';
                        }
                    }

                    $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
                    $data['details'] = $this->db->query($query)->row_array();


                    if ( $data['details']['Shape_upd'] == "Circular") {
                        $label_size = ucwords(str_replace("Label Size:", "",  $data['details']['specification3']));
                        $label_size = str_replace("Mm", "", $label_size);
                    } else {
                        $label_size =  $data['details']['LabelWidth'] . " x " .  $data['details']['LabelHeight'];
                        $label_size = str_replace("mm", "", $label_size);

                    }

                    $data['label_size'] = $label_size;
                    
                    
                    
                    

                    if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                        $preferences = $this->home_model->generate_preferences_data($line_detail);
                    }else {
						$edit_cart_flag = $this->input->post('edit_cart_flag');
						if( $edit_cart_flag ) {
							$data['edit_cart_flag'] = $edit_cart_flag;
							$temp_basket_id = $this->input->post('temp_basket_id');
							if( isset($temp_basket_id) && $temp_basket_id != '' ) {
								$product_basket_data = $this->getCartAndProductData($temp_basket_id);
								$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
								$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
								$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
								$data['cart_and_product_data'] = $product_basket_data;
							}	
						} else{
							$session_id = $this->shopping_model->sessionid();
                        	$preferences = $this->orderModal->material_load_preferences($session_id);
						}
                    }

                    $data['preferences'] = $preferences;
//        print_r($preferences);

                    $data['availabel_in'] = $data['preferences']['available_in'];
                    if (!empty($limit_exceed_designs) || !empty($limit_exceed_sheets)) {

                        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                            $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();

                            $desingtotal = $this->db->query(' Select count(*) as total from '.$artwork_table.' 
                            WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();


                            $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' = '.$lineNumber .' ')->row_array();

                        } else {
                            $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                            WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();

                            $desingtotal = $this->db->query(' Select count(*) as total from integrated_attachments 
                            WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();

                            $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
                        }



                        $menu = $this->db->query("Select ManufactureID from products WHERE ProductID = $productid")->row_array();
                        $menu = $menu['ManufactureID'];
//                        $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

                        $design = $row['Print_Qty'];
                        //$labels = $row['orignalQty']*$persheet;
                        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                            $labels = $row['labels'];
                        } else {
                            $labels = $row['orignalQty'];
                        }


                        $qty = $row['Quantity'];


                        if ($limit_exceed_designs == 'yes') {
                            $design = ($design + 1);
                        }
                        if ($limit_exceed_sheets == 'yes') {
                            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                                $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
                            } else {
                                $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                            }

                            $labels = ($quantity['labels'] > $labels) ? $quantity['labels'] : $labels;
                            $qty = $quantity['qty'];

                        }

                        if ($type == 'roll') {
                            $producttype = 'roll';
                        } else {
                            $producttype = 'sheet';
                        }
                        if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                            $rollfinish = explode(',',$laminations_and_varnishes_childs_array);
                        }else{
                            $laminations_and_varnishes_array = json_decode($row['FinishTypePrintedLabels']);
                            $rollfinish = $laminations_and_varnishes_array;
                        }


                        $labeltype = $row['Print_Type'];
                        //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);



                        if (preg_match("/Monochrome/i", $labeltype)) {
                            $labeltype = "Monochrome - Black Only";


                        } elseif (preg_match("/6_Colour_Digital_Process_White/i", $labeltype)) {
                            $labeltype = "6 Colour Digital Process + White";


                        } elseif (preg_match("/6_Colour_Digital_Process/i", $labeltype)) {
                            $labeltype = "6 Colour Digital Process";


                        }elseif (preg_match("/4_Colour_Digital_Process/i", $labeltype)) {
                            $labeltype = "4 Colour Digital Process";


                        }elseif (preg_match("/Rich_Black/i", $labeltype)) {
                            $labeltype = "Rich Black";


                        }

                        if (isset($digital_process_plus_white) && !empty($digital_process_plus_white) && $digital_process_plus_white == "add_white" ){
                            $labeltype = "6 Colour Digital Process + White";

                        }

                        if ($producttype == 'sheet') {

                            $sheet_product_quality = $this->input->post('sheet_product_quality');

                            if(isset($sheet_product_quality) && !empty($sheet_product_quality)){

                                if ($sheet_product_quality == 'premium'){
                                    $values_array = array( 'printing' => $labeltype,
                                        'labels' => $labels,
                                        'qty' => $qty,
                                        'design' => $design,
                                        'menu' => $menu,
                                        'persheets' => $persheets,
                                        'producttype' => $producttype,
                                        'pressproof' => $pressproof,
                                        'finish' => $rollfinish,
                                        'sheet_product_quality'=>"premium"
                                    );


                                    $prices = $this->calculate_sheet_price_printed_emb_page($values_array);
                           //          echo "<pre>";
			                        // 	print_r($prices);
			                        // echo "</pre>";
                                }elseif ($sheet_product_quality == 'standerd'){
                                    $values_array = array( 'printing' => $labeltype,
                                        'labels' => $labels,
                                        'qty' => $qty,
                                        'design' => $design,
                                        'menu' => $menu,
                                        'persheets' => $persheets,
                                        'producttype' => $producttype,
                                        'pressproof' => $pressproof,
                                        'finish' => $rollfinish,
                                        'sheet_product_quality'=>"standerd"

                                    );
                                    $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                                }
                            }

//                            $values_array = array( 'printing' => $labeltype,
//                                'labels' => $labels,
//                                'qty' => $qty,
//                                'design' => $design,
//                                'menu' => $menu,
//                                'persheets' => $persheets,
//                                'producttype' => $producttype,
//                                'pressproof' => $pressproof,
//                                'finish' => $rollfinish
//                            );
////            print_r($values_array);die;
//
//                            $prices = $this->calculate_sheet_price_printed_emb_page($values_array);



//echo"<pre>"; print_r( $prices);die;

//            $price = $this->home_model->currecy_converter($response['price'] + $additional_cost, 'yes');
                        } else{
                            $values_array_roll_price = array('roll' => $sheets,
                                'menu' => $menu,
                                'prd_id' => $productid,
                                'labels' => $labels,
                                'printing' => $labeltype,
                                'persheets'=>$persheets,
                                'pressproof'=>$pressproof,
                                'requestfrom' => "material_page1",
                                'rollfinish' => $rollfinish,
                                'upload_artwork_option_radio' => $upload_artwork_option_radio
                            );
                            //        function that call price calculator function for label-embellishment page
                            $prices = $this->calculate_roll_price_printed_emb_page($values_array_roll_price);
//                        print_r($prices);

                        }

                        $old_plate_cost_total_for_minus_total_price = 0;
                        foreach ($prices['label_finish_individual_cost_array'] as $key=> $label_finish_individual_cost_array) {
                            $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                            if (isset($use_old_plate) && count($use_old_plate) > 0) {
                                foreach ($use_old_plate as $old_plate) {
                                    if ($label_finish_individual_cost_array->finish_parsed_title == $old_plate->parsed_title) {
                                        $old_plate_cost_total_for_minus_total_price+=$label_finish_individual_cost_array->plate_cost;
                                        $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 1;
                                        $prices['label_finish_individual_cost_array'][$key]->used_plate_orderNumber = $old_plate->plate_order_no;
                                    }

                                }
                            } else {
                                $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                            }
                        }
                        $printprice = ($prices['printprice']) + ($prices['designprice']);

                        if ($type == 'roll') {
                            $printprice = $prices['halfprintprice'];
                            if ($qty > $prices['rolls']) {
                                $additional_rolls = $qty - $prices['rolls'];
                                $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                                $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                                $prices['additional_cost'] = number_format($additional_cost, 2, '.', '');
                                $printprice = $printprice + $additional_cost;

                            }
                            $plate_cost -=$old_plate_cost_total_for_minus_total_price;

                            $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice +$prices['presproof_charges'];
//                        echo"<pre>";print_r($prices);die;
                            $total_emb_cost = $prices['label_finish'] + $plate_cost;

                            $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';

                            $prices['price'] = $price_txt;

//                               $prices['plainprice'] = $prices['plainlabelsprice'];
                            //summ all prices(emb,finish,pressproof,mb_plae_price,print_price,plain_price for roll as
                            //in case of roll it will go in TotalPrice column of tempshopbaskt and
                            // For sheet print price add sepereately in column
                            // Print_Total and plain price add in TotalPrice and shows both prices in separate line in cart and order confirmaion.
                            $total_price_all = $printprice_shopping_cart +  $prices['plainlabelsprice'];
                            $prices['plainprice'] = $total_price_all;
                            $prices['printprice'] = $printprice;
                            $printprice_shopping_cart = 0;
                            //$printprice = 0;
                        }else{
                            $plate_cost -=$old_plate_cost_total_for_minus_total_price;

                            $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice;
                            $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';

                            $total_emb_cost = $prices['label_finish'] + $plate_cost;

//                        print_r($printprice);die;
                            $prices['price'] = $price_txt;
//                        $prices['printprice'] = $printprice;
                        }

                        $Print_Design = '1 Design';
                        if ($design > 1) {
                            $Print_Design = 'Multiple Designs';
                        }

                        $printing_items = array(
                            'Print_Type' => $labeltype,
                            'Free' => $prices['artworks'],
                            'Print_Qty' => $design,
                            'Print_Design' => $Print_Design,
                            'Print_UnitPrice' => $printprice_shopping_cart,
                            'total_emb_cost' => $total_emb_cost,
                            'Print_Total' => $printprice_shopping_cart);
//                    $plain_price_and_emb_plate_sum = $prices['plainprice'] + $this->input->post('total_emb_plate_price');
                        $unit_price =  $prices['plainprice']/ $qty;


                        /*echo '<pre>';
                        print_r($preferences); exit;*/
                        $items = array('Quantity' => $qty,
                            'orignalQty' => $labels,
                            'UnitPrice' => $unit_price,
                            'TotalPrice' => $prices['plainprice'],
                            'FinishTypePrintedLabels' => json_encode($rollfinish_child_array),
                            'FinishTypePricePrintedLabels' => json_encode( $prices['label_finish_individual_cost_array']),
                            'use_old_plate' => json_encode($use_old_plate),
                            'custom_roll_and_label' => $upload_artwork_option_radio,
                            'label_application' => $label_application,
                            'combination_base' => $combination_base
                        );

                        $items = array_merge($items, $printing_items);

                        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                            $updation_array = $this->home_model->emb_update_line($items,$flag,$refNumber,$lineNumber);
                        } else {
							
							if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
								$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid));	
							} else {
								$SID = $this->shopping_model->sessionid() . '-PRJB';
								$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));	
							}
                        }


                        $data['prices'] = $prices;
//                    echo"<pre>";print_r($prices);die;
                        $data['labels'] = $labels;
                        $data['sheets'] = $qty;
                        $data['designs'] = $design;


                        $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                            AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                        $data['details'] = $this->db->query($query)->row_array();

                        $data['details']['rollfinish'] = $row['FinishType'];

                        //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                        /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
                                else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
                                else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/
                        $data['details']['digitalprocess'] = $row['Print_Type'];

                        $data['coresize'] = "R" . substr($data['details']['ManufactureID'], 0, -1);


                        $data['sidebar_class'] = 'orangeBg';
                        $data['producttype'] = $producttype;
                        $data['labeltype'] = $labeltype;
                        $data['cartid'] = $cartid;
//                        $data['total_emb_plate_price'] = $this->input->post('total_emb_plate_price');
                        $cart_summery = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);


                    }

                    $data['details']['cartid'] = $cartid;
                    $data['details']['ProductID'] = $productid;

                    $data['details']['LabelsPerSheet'] = $persheet;



                    if ($type == 'roll') {
                        $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                        $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/roll_artwork_files', $data, true);
                    } else {
                        $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/a4_artwork_files', $data, true);
                    }

                    $json_data = array('response' => 'yes',
                        'content' => $theHTMLResponse,
                        'design' => $design,
                        'labels' => $labels,
                        'qty' => $qty,
                        'limit_exceed_designs' => $limit_exceed_designs,
                        'limit_exceed_sheets' => $limit_exceed_sheets,
                        'cart_summery' => $cart_summery);
                }
            }
        }elseif($upload_artwork_radio == "artwork_to_follow"){
            if (empty($_FILES)) {

                $limit_exceed_sheets = '';
                $limit_exceed_designs = '';


                $design = '';
                $labels = '';
                $qty = '';
                $sidebar = '';
                $digital_process_plus_white = $this->input->post('digital_process_plus_white');

                $cartid = $this->input->post('cartid');
                $productid = $this->input->post('productid');
                $labels = $this->input->post('labels');
                $sheets = $this->input->post('sheets');
                $artworkname = $this->input->post('artworkname');
                $persheet = $this->input->post('persheet');
                $type = $this->input->post('type');
                $data['unitqty'] = $this->input->post('unitqty');
                $laminations_and_varnishes = $this->input->post('laminations_and_varnishes');
                $laminations_and_varnishes_childs_array = $this->input->post('laminations_and_varnishes_childs');
                $pressproof = $this->input->post('press_proof');
                $persheets = $this->input->post('persheet');

                $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');
                $limit_exceed_designs = $this->input->post('limit_exceed_designs');

                //$persheet = 44;

                $product_branding = $this->ProductBrandByProductId($productid);
                $product_branding = str_replace(" Labels", "", $product_branding);
                $product_branding = str_replace(" Label", "", $product_branding);


                if (preg_match("/SRA3/i", $product_branding)) {
                    $brand = 'SRA3';
                } else if (preg_match("/A5/i", $product_branding)) {
                    $brand = 'A5';
                } else if (preg_match("/A3/i", $product_branding)) {
                    $brand = 'A3';
                } else if (preg_match("/Roll/i", $product_branding)) {
                    $brand = 'Rolls';
                } else if (preg_match("/Integrated/i", $product_branding)) {
                    $brand = 'Integrated';
                } else {
                    $brand = 'A4';
                }


                $plate_cost = 0;
                $minus_plate_cost = array();
                $use_old_plate = array();
                if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                    $rollfinish_child_array = explode(',',$laminations_and_varnishes_childs_array);
                    $selected_already_plates_composite_array =  json_decode($this->input->post('selected_already_plates_composite_array'));
//                        $selected_already_plates_composite_array = explode('},',$selected_already_plates_composite_array);

//                        echo"<pre>";
//                        var_dump( ($selected_already_plates_composite_array));die;

                    foreach ($rollfinish_child_array as $finish_child){
//            print_r($finish_child); echo '<br>';
                        $this->db->where('parsed_title', $finish_child);
                        $this->db->where('label_emb_parent_id !=', 0);

                        $cost_result = $this->db->get('label_embellishment')->row_array();

//            use to calculate already purchased plate cost for minus plate price purpose
                        foreach ($selected_already_plates_composite_array as $selected_already_plate_composite){
                            $selected_already_plate_composite = json_decode($selected_already_plate_composite);
//                                print_r($selected_already_plates_composite_array );

                            if ($selected_already_plate_composite->already_used_plate_id == $cost_result['id'] ){

                                $plate_cost_obj = new stdClass();
                                $plate_cost_obj->parsed_title = $cost_result['parsed_title'];
                                $plate_cost_obj->plate_cost = $cost_result['plate_cost'];
                                $minus_plate_cost[] = $plate_cost_obj;
                                $use_old_plate_obj = new stdClass();
                                $use_old_plate_obj->parsed_title = $cost_result['parsed_title'];
                                $use_old_plate_obj->plate_order_no = $selected_already_plate_composite->plate_order_no;
                                $use_old_plate[] = $use_old_plate_obj;

                            }
                        }
                        $plate_cost+= $cost_result['plate_cost'];
                    }
                    $data['minus_plate_cost'] = $minus_plate_cost;
//          echo "<pre>";  print_r($cost_result['plate_cost']);
                }
//       echo '<pre>'; print_r($use_old_plate);echo"<br>";
//       echo '<pre>'; print_r($minus_plate_cost);

                if($plate_cost <= 0){
                    $total_emb_plate_price = 0;
                    $data['total_emb_plate_price'] = $total_emb_plate_price;

                }else{
                    $data['total_emb_plate_price'] = $plate_cost;

                }

                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {


                    $artowrk = array(
                        'UserID' => $line_detail->UserID,
                        'OrderNumber'=> $refNumber,
                        'Serial' => $lineNumber,
                        'Brand' => $brand,
                        'ProductID' => $productid,
                        'diecode' => $line_detail->ManufactureID,
                        'name' => $artworkname,
                        'source' => "backoffice",
                        'labels' => $labels,
                        'qty' => $sheets,
                        'file' => "No File Required For Artwork To Follow",
                        'status' => 64,
                    );

                    if ($flag == 'quotation_detail'){
                        $artowrk['QuotationNumber'] = $artowrk['OrderNumber'];
                        $artowrk['UserID'] = $line_detail->CustomerID;
                        unset($artowrk['OrderNumber']);
                        unset($artowrk['Brand']);
                    }

                    $this->db->insert($artwork_table, $artowrk);

                } else {

					if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
                    	$sid = $this->session->userdata('session_id');
                    } else {
                    	$sid = $this->session->userdata('session_id') . '-PRJB';
                    }
                	
                    $artowrk = array('SessionID' => $sid,
	                    'ProductID' => $productid,
	                    'CartID' => $cartid,
	                    'name' => $artworkname,
	                    'labels' => $labels,
	                    'qty' => $sheets,
	                    'file' => "No File Required For Artwork To Follow ",
	                    'status' => 'confirm',
	                );
					$this->db->insert('integrated_attachments', $artowrk);
					
                }

                if ($type == 'roll') {

                    if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                        $actual_labels = $this->home_model->get_db_column($table, $label_column, $where_column, $lineNumber);

                        $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
                    } else {
                        $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                        $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                    }

                    if ($actual_labels <= $upload_qty) {
                        $limit_exceed_sheets = 'yes';
                    }
                }
                $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
                $data['details'] = $this->db->query($query)->row_array();

                if ( $data['details']['Shape_upd'] == "Circular") {
                    $label_size = ucwords(str_replace("Label Size:", "",  $data['details']['specification3']));
                    $label_size = str_replace("Mm", "", $label_size);
                } else {
                    $label_size =  $data['details']['LabelWidth'] . " x " .  $data['details']['LabelHeight'];
                    $label_size = str_replace("mm", "", $label_size);

                }
                $data['label_size'] = $label_size;

                
                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $preferences = $this->home_model->generate_preferences_data($line_detail);
                } else {
					$edit_cart_flag = $this->input->post('edit_cart_flag');
					if( $edit_cart_flag ) {
						$data['edit_cart_flag'] = $edit_cart_flag;
						$temp_basket_id = $this->input->post('temp_basket_id');
						if( isset($temp_basket_id) && $temp_basket_id != '' ) {
							$product_basket_data = $this->getCartAndProductData($temp_basket_id);
							$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
							$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
							$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
							$data['cart_and_product_data'] = $product_basket_data;
						}	
					} else {
						$session_id = $this->shopping_model->sessionid();
                    	$preferences = $this->orderModal->material_load_preferences($session_id);
					}
                }

                $data['preferences'] = $preferences;
//        print_r($preferences);
                $data['availabel_in'] = $data['preferences']['available_in'];

                if (!empty($limit_exceed_designs) || !empty($limit_exceed_sheets)) {

                    if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                        $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' LIKE '.$lineNumber.' ')->row_array();
                    } else {
                        $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
                    }

                    $menu = $this->db->query("Select ManufactureID from products WHERE ProductID = $productid")->row_array();
                    $menu = $menu['ManufactureID'];
//                    $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

                    $design = $row['Print_Qty'];
                    //$labels = $row['orignalQty']*$persheet;
                    if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                        if($flag == 'quotation_detail'){
                            $labels = $row['orignalQty'];
                        } else {
                            $labels = $row['labels'];
                        }

                    } else {
                        $labels = $row['orignalQty'];
                    }

                    $qty = $row['Quantity'];


                    if ($limit_exceed_designs == 'yes') {
                        $design = ($design + 1);
                    }
                    if ($limit_exceed_sheets == 'yes') {
                        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                            $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
                        } else {
                            $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                        }

                        $labels = ($quantity['labels'] > $labels) ? $quantity['labels'] : $labels;
                        $qty = $quantity['qty'];
                    }

                    if ($type == 'roll') {
                        $producttype = 'roll';
                    } else {
                        $producttype = 'sheet';
                    }

                    if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                        $rollfinish = explode(',',$laminations_and_varnishes_childs_array);
                    }else{
                        $laminations_and_varnishes_array = json_decode($row['FinishTypePrintedLabels']);
                        $rollfinish = $laminations_and_varnishes_array;
                    }

                    $labeltype = $row['Print_Type'];
                    //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);

                    if (preg_match("/Monochrome/i", $labeltype)) {
                        $labeltype = "Monochrome - Black Only";


                    } elseif (preg_match("/6_Colour_Digital_Process_White/i", $labeltype)) {
                        $labeltype = "6 Colour Digital Process + White";


                    } elseif (preg_match("/6_Colour_Digital_Process/i", $labeltype)) {
                        $labeltype = "6 Colour Digital Process";


                    }elseif (preg_match("/4_Colour_Digital_Process/i", $labeltype)) {
                        $labeltype = "4 Colour Digital Process";


                    }elseif (preg_match("/Rich_Black/i", $labeltype)) {
                        $labeltype = "Rich Black";


                    }
                    if (isset($digital_process_plus_white) && !empty($digital_process_plus_white) && $digital_process_plus_white == "add_white" ){
                        $labeltype = "6 Colour Digital Process + White";

                    }

                    if ($producttype == 'sheet') {


                        $sheet_product_quality = $this->input->post('sheet_product_quality');

                        if(isset($sheet_product_quality) && !empty($sheet_product_quality)){

                            if ($sheet_product_quality == 'premium'){
                                $values_array = array( 'printing' => $labeltype,
                                    'labels' => $labels,
                                    'qty' => $qty,

                                    'design' => $design,
                                    'menu' => $menu,
                                    'persheets' => $persheets,
                                    'producttype' => $producttype,
                                    'pressproof' => $pressproof,
                                    'finish' => $rollfinish,
                                    'sheet_product_quality'=>"premium"
                                );


                                $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                            }elseif ($sheet_product_quality == 'standerd'){
                                $values_array = array( 'printing' => $labeltype,
                                    'labels' => $labels,
                                    'qty' => $qty,

                                    'design' => $design,
                                    'menu' => $menu,
                                    'persheets' => $persheets,
                                    'producttype' => $producttype,
                                    'pressproof' => $pressproof,
                                    'finish' => $rollfinish,
                                    'sheet_product_quality'=>"standerd"

                                );
                                $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                            }
                        }

//                        $values_array = array( 'printing' => $labeltype,
//                            'labels' => $labels,
//                            'qty' => $qty,
//
//                            'design' => $design,
//                            'menu' => $menu,
//                            'persheets' => $persheets,
//                            'producttype' => $producttype,
//                            'pressproof' => $pressproof,
//                            'finish' => $rollfinish
//                        );
////            print_r($values_array);die;
//
//                        $prices = $this->calculate_sheet_price_printed_emb_page($values_array);



//echo"<pre>"; print_r( $prices);die;

//            $price = $this->home_model->currecy_converter($response['price'] + $additional_cost, 'yes');
                    } else{
                        $values_array_roll_price = array('roll' => $sheets,
                            'menu' => $menu,
                            'prd_id' => $productid,
                            'labels' => $labels,
                            'printing' => $labeltype,
                            'persheets'=>$persheets,
                            'pressproof'=>$pressproof,
                            'requestfrom' => "material_page1",
                            'rollfinish' => $rollfinish,
                            'upload_artwork_option_radio' => $upload_artwork_option_radio


                        );
//        function that call price calculator function for label-embellishment page
                        $prices = $this->calculate_roll_price_printed_emb_page($values_array_roll_price);
//                        print_r($prices);

                    }

                    $old_plate_cost_total_for_minus_total_price = 0;
                    foreach ($prices['label_finish_individual_cost_array'] as $key=> $label_finish_individual_cost_array) {
                        $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                        if (isset($use_old_plate) && count($use_old_plate) > 0) {
                            foreach ($use_old_plate as $old_plate) {
                                if ($label_finish_individual_cost_array->finish_parsed_title == $old_plate->parsed_title) {
                                    $old_plate_cost_total_for_minus_total_price+=$label_finish_individual_cost_array->plate_cost;
                                    $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 1;
                                    $prices['label_finish_individual_cost_array'][$key]->used_plate_orderNumber = $old_plate->plate_order_no;
                                }
                            }
                        } else {
                            $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                        }
                    }


                    $printprice = ($prices['printprice']) + ($prices['designprice']);

                    if ($type == 'roll') {
                        $printprice = $prices['halfprintprice'];
                        if ($qty > $prices['rolls']) {
                            $additional_rolls = $qty - $prices['rolls'];
                            $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                            $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                            $prices['additional_cost'] = number_format($additional_cost, 2, '.', '');
                            $printprice = $printprice + $additional_cost;

                        }
                        $plate_cost -=$old_plate_cost_total_for_minus_total_price;

                        $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice +$prices['presproof_charges'];
//                        echo"<pre>";print_r($prices);die;

                        $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';
                        $total_emb_cost = $prices['label_finish'] + $plate_cost;

                        $prices['price'] = $price_txt;

//                               $prices['plainprice'] = $prices['plainlabelsprice'];
                        //sum all prices(emb,finish,pressproof,mb_plae_price,print_price,plain_price for roll as
                        //in case of roll it will go in TotalPrice column of tempshopbaskt and
                        // For sheet print price add sepereately in column
                        // Print_Total and plain price add in TotalPrice and shows both prices in separate line in cart and order confirmaion.
                        $total_price_all = $printprice_shopping_cart +  $prices['plainlabelsprice'];
                        $prices['plainprice'] = $total_price_all;
                        $prices['printprice'] = $printprice;
                        $printprice_shopping_cart = 0;
                        //$printprice = 0;
                    }else{
                        $plate_cost -=$old_plate_cost_total_for_minus_total_price;

                        $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost+ $printprice;
                        $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';
                        $total_emb_cost = $prices['label_finish'] + $plate_cost;

//                        print_r($printprice);die;
                        $prices['price'] = $price_txt;
//                        $prices['printprice'] = $printprice;
                    }

                    $Print_Design = '1 Design';
                    if ($design > 1) {
                        $Print_Design = 'Multiple Designs';
                    }

                    $printing_items = array('Free' => $prices['artworks'],
                        'Print_Type' => $labeltype,
                        'Print_Qty' => $design,
                        'Print_Design' => $Print_Design,
                        'Print_UnitPrice' => $printprice_shopping_cart,
                        'total_emb_cost' => $total_emb_cost,
                        'Print_Total' => $printprice_shopping_cart);
//                    $plain_price_and_emb_plate_sum = $prices['plainprice'] + $this->input->post('total_emb_plate_price');
                    $unit_price =  $prices['plainprice']/ $qty;


                    $items = array('Quantity' => $qty,
                        'orignalQty' => $labels,
                        'UnitPrice' => $unit_price,
                        'TotalPrice' => $prices['plainprice'],
                        'FinishTypePrintedLabels' => json_encode($rollfinish_child_array),
                        'FinishTypePricePrintedLabels' => json_encode( $prices['label_finish_individual_cost_array']),
                        'use_old_plate' => json_encode($use_old_plate),
                        'custom_roll_and_label' => $upload_artwork_option_radio,
                        'label_application' => $label_application,
                        'combination_base' => $combination_base
                        );


                    $items = array_merge($items, $printing_items);


                    if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {

                        $updation_array = $this->home_model->emb_update_line($items,$flag,$refNumber,$lineNumber);

                    } else {
						
						if( isset($edit_cart_flag) && $edit_cart_flag != '' ) {
							$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid));
						} else {
							$SID = $this->shopping_model->sessionid() . '-PRJB';
							$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));
						}
                    }


                    $data['prices'] = $prices;
//                    echo"<pre>";print_r($prices);die;
                    $data['labels'] = $labels;
                    $data['sheets'] = $qty;
                    $data['designs'] = $design;


                    $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                            AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                    $data['details'] = $this->db->query($query)->row_array();

                    $data['details']['rollfinish'] = $row['FinishType'];

                    //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                    /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
                            else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
                            else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/
                    $data['details']['digitalprocess'] = $row['Print_Type'];

                    $data['coresize'] = "R" . substr($data['details']['ManufactureID'], 0, -1);


                    $data['sidebar_class'] = 'orangeBg';
                    $data['producttype'] = $producttype;
                    $data['labeltype'] = $labeltype;
                    $data['cartid'] = $cartid;
//                    $data['total_emb_plate_price'] = $this->input->post('total_emb_plate_price');
                    $cart_summery = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);


                }

                $data['details']['cartid'] = $cartid;
                $data['details']['ProductID'] = $productid;

                $data['details']['LabelsPerSheet'] = $persheet;

                if ($type == 'roll') {
                    $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                    $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/roll_artwork_files', $data, true);
                } else {
                    $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/a4_artwork_files', $data, true);
                }

                $json_data = array('response' => 'yes',
                    'content' => $theHTMLResponse,
                    'design' => $design,
                    'labels' => $labels,
                    'qty' => $qty,
                    'limit_exceed_designs' => $limit_exceed_designs,
                    'limit_exceed_sheets' => $limit_exceed_sheets,
                    'cart_summery' => $cart_summery);
            }

        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }


    function material_upload_printing_artworks()
    {

        $json_data = array('response' => 'no', 'message' => 'failed to upload this file, please try again');

        if (!empty($_FILES)) {

            $limit_exceed_sheets = '';
            $limit_exceed_designs = '';


            $design = '';
            $labels = '';
            $qty = '';
            $sidebar = '';

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $artworkname = $this->input->post('artworkname');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $data['unitqty'] = $this->input->post('unitqty');


            $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');
            $limit_exceed_designs = $this->input->post('limit_exceed_designs');

            //$persheet = 44;


            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $response = $this->orderModal->upload_images('file', '/');

            if ($response != 'error') {

                $sid = $this->session->userdata('session_id') . '-PRJB';
                $artowrk = array('SessionID' => $sid,
                    'ProductID' => $productid,
                    'CartID' => $cartid,
                    'name' => $artworkname,
                    'labels' => $labels,
                    'qty' => $sheets,
                    'file' => $response,
                    'status' => 'confirm',
                );
                $this->db->insert('integrated_attachments', $artowrk);


                if ($type == 'roll') {

                    $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                    $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();

                    if ($actual_labels <= $upload_qty) {
                        $limit_exceed_sheets = 'yes';
                    }
                }


                if (!empty($limit_exceed_designs) || !empty($limit_exceed_sheets)) {


                    $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
                    $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

                    $design = $row['Print_Qty'];
                    //$labels = $row['orignalQty']*$persheet;
                    $labels = $row['orignalQty'];
                    $qty = $row['Quantity'];


                    if ($limit_exceed_designs == 'yes') {
                        $design = ($design + 1);
                    }
                    if ($limit_exceed_sheets == 'yes') {
                        $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                        $labels = ($quantity['labels'] > $labels) ? $quantity['labels'] : $labels;
                        $qty = $quantity['qty'];
                    }

                    if ($type == 'roll') {
                        $product_type = 'roll';
                    } else {
                        $product_type = 'sheet';
                    }

                    $values_array = array('labeltype' => $row['Print_Type'],
                        'labels' => $labels,
                        'rolls' => $qty,
                        'design' => $design,
                        'menu' => $menu,
                        'persheets' => $persheet,
                        'producttype' => $product_type,
                        'pressproof' => $row['pressproof'],
                        'finish' => $row['FinishType']);
                    $prices = $this->price_calculator($values_array);

                    $printprice = ($prices['printprice']) + ($prices['designprice']);

                    if ($type == 'roll') {
                        $printprice = $prices['price'];
                        if ($qty > $prices['rolls']) {
                            $additional_rolls = $qty - $prices['rolls'];
                            $additional_cost = $this->orderModal->additional_charges_rolls($additional_rolls);
                            $prices['additional_cost'] = $additional_cost;
                            $printprice = $printprice + $additional_cost;
                        }
                        $prices['price'] = $printprice;
                        $prices['plainprice'] = $printprice;
                        $printprice = 0;
                    }

                    $Print_Design = '1 Design';
                    if ($design > 1) {
                        $Print_Design = 'Multiple Designs';
                    }
                    $printing_items = array('Free' => $prices['artworks'],
                        'Print_Qty' => $design,
                        'Print_Design' => $Print_Design,
                        'Print_UnitPrice' => $printprice,
                        'Print_Total' => $printprice);
                    $unit_price = $prices['plainprice'] / $qty;

                    $items = array('Quantity' => $qty,
                        'orignalQty' => $labels,
                        'UnitPrice' => $unit_price,
                        'TotalPrice' => $prices['plainprice']);


                    $items = array_merge($items, $printing_items);

                    $SID = $this->shopping_model->sessionid() . '-PRJB';
                    $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));


                    $data['prices'] = $prices;
                    $data['labels'] = $labels;
                    $data['sheets'] = $qty;
                    $data['designs'] = $design;


                    $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                            AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                    $data['details'] = $this->db->query($query)->row_array();

                    $data['details']['rollfinish'] = $row['FinishType'];

                    //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                    /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
                            else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
                            else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/
                    $data['details']['digitalprocess'] = $row['Print_Type'];

                    $data['coresize'] = "R" . substr($data['details']['ManufactureID'], 0, -1);


                    $data['sidebar_class'] = 'orangeBg';
                    $sidebar = $this->load->view('material_print_service/product_overview_sidebar', $data, true);


                }

                $data['details']['cartid'] = $cartid;
                $data['details']['ProductID'] = $productid;

                $data['details']['LabelsPerSheet'] = $persheet;

                if ($type == 'roll') {
                    $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                    $theHTMLResponse = $this->load->view('material_print_service/upload/roll_artwork_files', $data, true);
                } else {
                    $theHTMLResponse = $this->load->view('material_print_service/upload/a4_artwork_files', $data, true);
                }

                $json_data = array('response' => 'yes',
                    'content' => $theHTMLResponse,
                    'design' => $design,
                    'labels' => $labels,
                    'qty' => $qty,
                    'limit_exceed_designs' => $limit_exceed_designs,
                    'limit_exceed_sheets' => $limit_exceed_sheets,
                    'sidebar' => $sidebar);
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }



    function update_printing_artworks()
    {

        $json_data = array('response' => 'no');

        if ($_POST) {


            $limit_exceed_sheets = '';
            $limit_exceed_designs = '';


            $design = '';
            $labels = '';
            $qty = '';
            $sidebar = '';

            $id = $this->input->post('id');
            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');

            $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');

            $updater = $this->input->post('updater');
            $data['unitqty'] = $this->input->post('unitqty');

            if (isset($updater) and $updater == 'clear') {
                $sid = $this->session->userdata('session_id') . '-PRJB';
                $this->db->delete('integrated_attachments', array('CartID' => $cartid, 'SessionID' => $sid));
                $limit_exceed_sheets = 'yes';

            } else {
                $sid = $this->session->userdata('session_id') . '-PRJB';
                $artowrk = array('labels' => $labels,
                    'qty' => $sheets,
                    'status' => 'confirm');
                $this->db->update('integrated_attachments', $artowrk, array('ID' => $id));
            }


            if ($type == 'roll') {

                $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
										WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();

                if ($actual_labels <= $upload_qty) {
                    $limit_exceed_sheets = 'yes';
                }
            }


            if (isset($limit_exceed_sheets) and $limit_exceed_sheets == 'yes') {


                $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
                $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

                $design = $row['Print_Qty'];

                $cart_qty = $row['Quantity'];
                $cart_labels = $row['orignalQty'];


                $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
							WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


                $qty = (isset($quantity['qty']) and $quantity['qty'] > 0) ? $quantity['qty'] : $cart_qty;
                $labels = (isset($quantity['labels']) and $quantity['labels'] > $cart_labels) ? $quantity['labels'] : $cart_labels;

                if ($type == 'roll') {
                    $product_type = 'roll';
                } else {
                    $product_type = 'sheet';
                }

                $values_array = array('labeltype' => $row['Print_Type'],
                    'labels' => $labels,
                    'rolls' => $qty,
                    'design' => $design,
                    'menu' => $menu,
                    'persheets' => $persheet,
                    'producttype' => $product_type,
                    'pressproof' => $row['pressproof'],
                    'finish' => $row['FinishType']);
                $prices = $this->price_calculator($values_array);
//               echo "<pre>";print_r($prices);die;
                $printprice = ($prices['printprice']) + ($prices['designprice']);

                if ($type == 'roll') {

                    $printprice = $prices['price'];
                    if ($qty > $prices['rolls'] and $updater != 'clear') {
                        $additional_rolls = $qty - $prices['rolls'];
                        $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                        $prices['additional_cost'] = $additional_cost;
                        $printprice = $printprice + $additional_cost;
                    }
                    $prices['price'] = $printprice;
                    $prices['plainprice'] = $printprice;

                    $printprice = 0;
                }

                $printing_items = array('Free' => $prices['artworks'],
                    'Print_Qty' => $design,
                    'Print_UnitPrice' => $printprice,
                    'Print_Total' => $printprice);
                $unit_price = $prices['plainprice'] / $qty;

                $items = array('Quantity' => $qty,
                    'orignalQty' => $labels,
                    'UnitPrice' => $unit_price,
                    'TotalPrice' => $prices['plainprice']);


                $items = array_merge($items, $printing_items);

                $SID = $this->shopping_model->sessionid() . '-PRJB';
                $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));

                $prices['price'] = $this->home_model->currecy_converter($prices['price'], 'yes');
                $prices['plainprint'] = $this->home_model->currecy_converter($prices['plainprint'], 'yes');
                $prices['plainprice'] = $this->home_model->currecy_converter($prices['plainprice'], 'yes');
                $prices['printprice'] = $this->home_model->currecy_converter($prices['printprice'], 'yes');
                $prices['designprice'] = $this->home_model->currecy_converter($prices['designprice'], 'yes');
                $prices['pressproof'] = $this->home_model->currecy_converter($prices['pressproof'], 'yes');


                $data['prices'] = $prices;
                $data['labels'] = $labels;
                $data['sheets'] = $qty;
                $data['designs'] = $design;


                $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
							AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                $data['details'] = $this->db->query($query)->row_array();

                $data['details']['rollfinish'] = $row['FinishType'];
                //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
							else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
							else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/

                $data['details']['digitalprocess'] = $row['Print_Type'];

                $data['sidebar_class'] = 'orangeBg';
                $sidebar = $this->load->view('print_service/product_overview_sidebar', $data, true);


            }

            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;

            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $theHTMLResponse = $this->load->view('print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('print_service/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'content' => $theHTMLResponse,
                'design' => $design,
                'labels' => $labels,
                'qty' => $qty,
                'limit_exceed_designs' => $limit_exceed_designs,
                'limit_exceed_sheets' => $limit_exceed_sheets,
                'sidebar' => $sidebar);
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }


    function material_update_printing_artworks_label_emb()
    {

        $json_data = array('response' => 'no');

        if ($_POST) {

        	
            $limit_exceed_sheets = '';
            $limit_exceed_designs = '';


            $design = '';
            $labels = '';
            $qty = '';
            $sidebar = '';
            $digital_process_plus_white = $this->input->post('digital_process_plus_white');
            $label_application = $this->input->post('label_application');
            $combination_base = $this->input->post('combination_base');
            $id = $this->input->post('id');
            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $pressproof = $this->input->post('press_proof');
            $edit_cart_flag = $this->input->post('edit_cart_flag');
            $persheets = $this->input->post('persheet');
            $producttype = $type;

            $data['lines_to_populate'] = $this->input->post('lines_to_populate');
            $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
            $upload_artwork_radio = $this->input->post('upload_artwork_radio');
            $data['upload_artwork_radio'] = $upload_artwork_radio;
            $data['upload_artwork_option_radio'] = $upload_artwork_option_radio;
            $data['producttype'] = $producttype;

            $flag = $this->input->post('flag');
            $refNumber = $this->input->post('refNumber');
            $lineNumber = $this->input->post('lineNumber');

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $data['flag'] = $flag;
                $data['refNumber'] = $refNumber;
                $data['lineNumber'] = $lineNumber;

                if ($flag == 'order_detail'){
                    $line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);

                    $table = 'orderdetails';
                    $where_column = 'SerialNumber';
                    $label_column = 'labels';
                    $artwork_table = 'order_attachments_integrated';
                }elseif ($flag == 'quotation_detail'){
                    $line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);

                    $table = 'quotationdetails';
                    $where_column = 'SerialNumber';
                    $label_column = 'orignalQty';
                    $artwork_table = 'quotation_attachments_integrated';
                }
            }


//          $laminations_and_varnishes = $this->input->post('laminations_and_varnishes');
            $laminations_and_varnishes_childs_array = $this->input->post('laminations_and_varnishes_childs');

//           bypass 'total_emb_plate_price' variable from $this->input->post('total_emb_plate_price') and calculate
//            it from backend on the basis of laminations_and_varnishes_childs array passed in post param.
//            to prevent plate price wrong total due to already purchased module
            //                $rollfinish_child_array = $laminations_and_varnishes_childs_array;
            $plate_cost = 0;
            if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                $selected_already_plates_composite_array = $this->input->post('selected_already_plates_composite_array');
                $minus_plate_cost = array();
                $use_old_plate = array();
                foreach ($laminations_and_varnishes_childs_array as $finish_child){
//            print_r($finish_child); echo '<br>';
                    $this->db->where('parsed_title', $finish_child);
                    $this->db->where('label_emb_parent_id !=', 0);

                    $cost_result = $this->db->get('label_embellishment')->row_array();

//            use to calculate already purchased plate cost for minus plate price purpose
                    foreach ($selected_already_plates_composite_array as $selected_already_plate_composite){
//                        print_r($selected_already_plate_composite);
                        $selected_already_plate_composite = json_decode($selected_already_plate_composite);
//                        print_r($selected_already_plate_composite);
                        if ($selected_already_plate_composite->already_used_plate_id == $cost_result['id'] ){

                            $plate_cost_obj = new stdClass();
                            $plate_cost_obj->parsed_title = $cost_result['parsed_title'];
                            $plate_cost_obj->plate_cost = $cost_result['plate_cost'];
                            $minus_plate_cost[] = $plate_cost_obj;
                            $use_old_plate_obj = new stdClass();
                            $use_old_plate_obj->parsed_title = $cost_result['parsed_title'];
                            $use_old_plate_obj->plate_order_no = $selected_already_plate_composite->plate_order_no;
                            $use_old_plate[] = $use_old_plate_obj;

                        }
                    }
                    $plate_cost+= $cost_result['plate_cost'];
                }
                $data['minus_plate_cost'] = $minus_plate_cost;
//          echo "<pre>";  print_r($cost_result['plate_cost']);
            }
//       echo '<br>'; print_r($use_old_plate);

            if($plate_cost <= 0){
                $total_emb_plate_price = 0;
                $data['total_emb_plate_price'] = $total_emb_plate_price;

            }else{
                $data['total_emb_plate_price'] = $plate_cost;

            }


            $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');

            $updater = $this->input->post('updater');
            $data['unitqty'] = $this->input->post('unitqty');

            if (isset($updater) and $updater == 'clear') {
                
                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $this->db->delete($artwork_table, array('Serial' => $lineNumber));
                } else {

					$sid = $this->session->userdata('session_id') . '-PRJB';
					if( $edit_cart_flag ) {
						$this->db->delete('integrated_attachments', array('CartID' => $cartid));	
					} else {
						$this->db->delete('integrated_attachments', array('CartID' => $cartid, 'SessionID' => $sid));	
					}
                }

                $limit_exceed_sheets = 'yes';

            } else {
                $sid = $this->session->userdata('session_id') . '-PRJB';
                $artowrk = array('labels' => $labels,
                    'qty' => $sheets
                );

                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $this->db->update($artwork_table, $artowrk, array('ID' => $id));
                } else {
                	$artowrk = array('labels' => $labels,
                    'qty' => $sheets);

                    $this->db->update('integrated_attachments', $artowrk, array('ID' => $id));
                }

            }


            if ($type == 'roll') {

                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $actual_labels = $this->home_model->get_db_column($table, $label_column, $where_column, $lineNumber);

                    $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
                } else {
                    $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                    $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                }

                if ($actual_labels <= $upload_qty) {
                    $limit_exceed_sheets = 'yes';
                }
            }

            $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
            $data['details'] = $this->db->query($query)->row_array();

            if ( $data['details']['Shape_upd'] == "Circular") {
                $label_size = ucwords(str_replace("Label Size:", "",  $data['details']['specification3']));
                $label_size = str_replace("Mm", "", $label_size);
            } else {
                $label_size =  $data['details']['LabelWidth'] . " x " .  $data['details']['LabelHeight'];
                $label_size = str_replace("mm", "", $label_size);

            }
            $data['label_size'] = $label_size;

            
            
            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $preferences = $this->home_model->generate_preferences_data($line_detail);
            } else {

				if( $edit_cart_flag ) {
					$data['edit_cart_flag'] = $edit_cart_flag;
					$temp_basket_id = $this->input->post('temp_basket_id');
					if( isset($temp_basket_id) && $temp_basket_id != '' ) {
						$product_basket_data = $this->getCartAndProductData($temp_basket_id);
						$preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
						$data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
						$data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
						$data['cart_and_product_data'] = $product_basket_data;
					}	
				} else {
					$session_id = $this->shopping_model->sessionid();
					$preferences = $this->orderModal->material_load_preferences($session_id);
				}

            }
            $data['preferences'] = $preferences;
//        print_r($preferences);
            $data['availabel_in'] = $data['preferences']['available_in'];
//print_r($limit_exceed_sheets);die;
            if (isset($limit_exceed_sheets) and $limit_exceed_sheets == 'yes') {

                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' = '.$lineNumber .' ')->row_array();
                } else {
                    $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
                }


                $menu = $this->db->query("Select ManufactureID from products WHERE ProductID = $productid")->row_array();
                $menu = $menu['ManufactureID'];


                $design = $row['Print_Qty'];
                $cart_qty = $row['Quantity'];
                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    if ($flag == 'quotation_detail'){
                        $cart_labels = $row['orignalQty'];
                    } else {
                        $cart_labels = $row['labels'];
                    }

                } else {
                    $cart_labels = $row['orignalQty'];
                }

                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                                        WHERE Serial LIKE '.$lineNumber.' AND ProductID LIKE '.$productid.' ')->row_array();
                } else {
                    $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                            WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();
                }


                $qty = (isset($quantity['qty']) and $quantity['qty'] > 0) ? $quantity['qty'] : $cart_qty;
                $labels = (isset($quantity['labels']) and $quantity['labels'] > $cart_labels) ? $quantity['labels'] : $cart_labels;
                if ($type == 'roll') {
                    $product_type = 'roll';
                } else {
                    $product_type = 'sheet';
                }

                if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                    $rollfinish = $laminations_and_varnishes_childs_array;
                }else{
                    $laminations_and_varnishes_array = json_decode($row['FinishTypePrintedLabels']);
                    $rollfinish = $laminations_and_varnishes_array;
                }


                $labeltype = $row['Print_Type'];
                //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);

                if (preg_match("/Monochrome/i", $labeltype)) {
                    $labeltype = "Monochrome - Black Only";


                } elseif (preg_match("/6_Colour_Digital_Process_White/i", $labeltype)) {
                    $labeltype = "6 Colour Digital Process + White";


                } elseif (preg_match("/6_Colour_Digital_Process/i", $labeltype)) {
                    $labeltype = "6 Colour Digital Process";


                }elseif (preg_match("/4_Colour_Digital_Process/i", $labeltype)) {
                    $labeltype = "4 Colour Digital Process";


                }elseif (preg_match("/Rich_Black/i", $labeltype)) {
                    $labeltype = "Rich Black";


                }
                if (isset($digital_process_plus_white) && !empty($digital_process_plus_white) && $digital_process_plus_white == "add_white" ){
                    $labeltype = "6 Colour Digital Process + White";

                }

                if ($type == 'sheet') {

                    $sheet_product_quality = $this->input->post('sheet_product_quality');

                    if(isset($sheet_product_quality) && !empty($sheet_product_quality)){

                        if ($sheet_product_quality == 'premium'){
                            $values_array = array( 'printing' => $labeltype,
                                'labels' => $labels,
                                'design' => $design,
                                'menu' => $menu,
                                'persheets' => $persheets,
                                'producttype' => $producttype,
                                'pressproof' => $pressproof,
                                'finish' => $rollfinish,
                                'sheet_product_quality'=>"premium"
                            );


                            $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                        }elseif ($sheet_product_quality == 'standerd'){
                            $values_array = array( 'printing' => $labeltype,
                                'labels' => $labels,
                                'design' => $design,
                                'menu' => $menu,
                                'persheets' => $persheets,
                                'producttype' => $producttype,
                                'pressproof' => $pressproof,
                                'finish' => $rollfinish,
                                'sheet_product_quality'=>"standerd"

                            );
                            $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                        }
                    }




					//                    $values_array = array( 'printing' => $labeltype,
					//                        'labels' => $labels,
					//                        'design' => $design,
					//                        'menu' => $menu,
					//                        'persheets' => $persheets,
					//                        'producttype' => $producttype,
					//                        'pressproof' => $pressproof,
					//                        'finish' => $rollfinish
					//                    );
					//
					//                    $prices = $this->calculate_sheet_price_printed_emb_page($values_array);



					//echo"<pre>"; print_r($prices);die;

					//            $price = $this->home_model->currecy_converter($response['price'] + $additional_cost, 'yes');
                } else{
                    $values_array_roll_price = array('roll' => $sheets,
                        'menu' => $menu,
                        'prd_id' => $productid,
                        'labels' => $labels,
                        'printing' => $labeltype,
                        'persheets'=>$persheet,
                        'pressproof'=>$pressproof,
                        'requestfrom' => "material_page",
                        'rollfinish' => $rollfinish,
                        'upload_artwork_option_radio' => $upload_artwork_option_radio

                    );
				//        function that call price calculator function for label-embellishment page
                    $prices = $this->calculate_roll_price_printed_emb_page($values_array_roll_price);

                }

                /*echo "11<pre>";
                print_r($prices);
                echo "</pre>";
                die();*/

                $old_plate_cost_total_for_minus_total_price = 0;
                foreach ($prices['label_finish_individual_cost_array'] as $key=> $label_finish_individual_cost_array) {
                    $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                    if (isset($use_old_plate) && count($use_old_plate) > 0) {
                        foreach ($use_old_plate as $old_plate) {
                            if ($label_finish_individual_cost_array->finish_parsed_title == $old_plate->parsed_title) {
                                $old_plate_cost_total_for_minus_total_price+=$label_finish_individual_cost_array->plate_cost;
                                $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 1;
                                $prices['label_finish_individual_cost_array'][$key]->used_plate_orderNumber = $old_plate->plate_order_no;
                            }
                        }
                    } else {
                        $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                    }
                }

                $printprice = ($prices['printprice']) + ($prices['designprice']);

                if ($type == 'roll') {
                    $printprice = $prices['halfprintprice'];
                    if ($qty > $prices['rolls']) {
                        $additional_rolls = $qty - $prices['rolls'];
                        $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                        $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                        $prices['additional_cost'] = number_format($additional_cost, 2, '.', '');

                        $printprice = $printprice + $additional_cost;

                    }
                    $plate_cost -= $old_plate_cost_total_for_minus_total_price;
                    $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice +$prices['presproof_charges'];
					//                        echo"<pre>";print_r($prices);die;

                    $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';
                    $total_emb_cost = $prices['label_finish'] + $plate_cost;


                    $prices['price'] = $price_txt;

					//                               $prices['plainprice'] = $prices['plainlabelsprice'];
                    //summ all prices(emb,finish,pressproof,mb_plae_price,print_price,plain_price for roll as
                    //in case of roll it will go in TotalPrice column of tempshopbaskt and
                    // For sheet print price add sepereately in column
                    // Print_Total and plain price add in TotalPrice and shows both prices in separate line in cart and order confirmaion.
                    $total_price_all = $printprice_shopping_cart +  $prices['plainlabelsprice'];


                    $prices['plainprice'] = $total_price_all;


                    $prices['printprice'] = $printprice;
                    $printprice_shopping_cart = 0;

                    //$printprice = 0;
                }else{
                    $plate_cost -= $old_plate_cost_total_for_minus_total_price;

                    $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice;
                    $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';
                    $total_emb_cost = $prices['label_finish'] + $plate_cost;

					//                        print_r($printprice);die;
                    $prices['price'] = $price_txt;
					//                        $prices['printprice'] = $printprice;
                }

                $Print_Design = '1 Design';
                if ($design > 1) {
                    $Print_Design = 'Multiple Designs';
                }

                $printing_items = array('Free' => $prices['artworks'],
                    'Print_Type' => $labeltype,
                    'Print_Qty' => $design,
                    'Print_Design' => $Print_Design,
                    'Print_UnitPrice' => $printprice_shopping_cart,
                    'total_emb_cost' => $total_emb_cost,
                    'Print_Total' => $printprice_shopping_cart);
				//                    $plain_price_and_emb_plate_sum = $prices['plainprice'] + $this->input->post('total_emb_plate_price');
                $unit_price =  $prices['plainprice']/ $qty;



                $items = array('Quantity' => $qty,
                    'orignalQty' => $labels,
                    'Print_Type' => $labeltype,
                    'UnitPrice' => $unit_price,
                    'TotalPrice' => $prices['plainprice'],
                    'FinishTypePrintedLabels' => json_encode($laminations_and_varnishes_childs_array),
                    'FinishTypePricePrintedLabels' => json_encode( $prices['label_finish_individual_cost_array']),
                    'use_old_plate' => json_encode($use_old_plate),
                    'custom_roll_and_label' => $upload_artwork_option_radio,
                    'label_application' => $label_application,
                    'combination_base' => $combination_base
                    );

                

                $items = array_merge($items, $printing_items);

                if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                    $updation_array = $this->home_model->emb_update_line($items,$flag,$refNumber,$lineNumber);
                } else {

					if( $edit_cart_flag ) {
						$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid));	
					} else {
						$SID = $this->shopping_model->sessionid() . '-PRJB';
						$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));	
					}

                }


                $data['prices'] = $prices;
                $data['labels'] = $labels;
                $data['sheets'] = $qty;
                $data['designs'] = $design;


                $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                            AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                $data['details'] = $this->db->query($query)->row_array();

                $data['details']['rollfinish'] = $row['FinishType'];
                //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
                            else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
                            else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/

                $data['details']['digitalprocess'] = $row['Print_Type'];

                $data['sidebar_class'] = 'orangeBg';
                $data['labeltype'] = $labeltype;
                $data['cartid'] = $cartid;
				//                $data['total_emb_plate_price'] = $this->input->post('total_emb_plate_price');
                $cart_summery = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);



            }

			

            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;

            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'content' => $theHTMLResponse,
                'design' => $design,
                'labels' => $labels,
                'qty' => $qty,
                'limit_exceed_designs' => $limit_exceed_designs,
                'limit_exceed_sheets' => $limit_exceed_sheets,
                'cart_summery' => $cart_summery);
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }


    function material_update_printing_artworks()
    {

        $json_data = array('response' => 'no');

        if ($_POST) {


            $limit_exceed_sheets = '';
            $limit_exceed_designs = '';


            $design = '';
            $labels = '';
            $qty = '';
            $sidebar = '';

            $id = $this->input->post('id');
            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');

            $limit_exceed_sheets = $this->input->post('limit_exceed_sheet');

            $updater = $this->input->post('updater');
            $data['unitqty'] = $this->input->post('unitqty');

            if (isset($updater) and $updater == 'clear') {
                $sid = $this->session->userdata('session_id') . '-PRJB';
                $this->db->delete('integrated_attachments', array('CartID' => $cartid, 'SessionID' => $sid));
                $limit_exceed_sheets = 'yes';

            } else {
                $sid = $this->session->userdata('session_id') . '-PRJB';
                $artowrk = array('labels' => $labels,
                    'qty' => $sheets,
                    'status' => 'confirm');
                $this->db->update('integrated_attachments', $artowrk, array('ID' => $id));
            }


            if ($type == 'roll') {

                $actual_labels = $this->home_model->get_db_column('temporaryshoppingbasket', 'orignalQty', 'ID', $cartid);

                $upload_qty = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                                        WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();

                if ($actual_labels <= $upload_qty) {
                    $limit_exceed_sheets = 'yes';
                }
            }


            if (isset($limit_exceed_sheets) and $limit_exceed_sheets == 'yes') {


                $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
                $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

                $design = $row['Print_Qty'];

                $cart_qty = $row['Quantity'];
                $cart_labels = $row['orignalQty'];


                $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                            WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


                $qty = (isset($quantity['qty']) and $quantity['qty'] > 0) ? $quantity['qty'] : $cart_qty;
                $labels = (isset($quantity['labels']) and $quantity['labels'] > $cart_labels) ? $quantity['labels'] : $cart_labels;

                if ($type == 'roll') {
                    $product_type = 'roll';
                } else {
                    $product_type = 'sheet';
                }

                $values_array = array('labeltype' => $row['Print_Type'],
                    'labels' => $labels,
                    'rolls' => $qty,
                    'design' => $design,
                    'menu' => $menu,
                    'persheets' => $persheet,
                    'producttype' => $product_type,
                    'pressproof' => $row['pressproof'],
                    'finish' => $row['FinishType']);
                $prices = $this->price_calculator($values_array, "material_page");

                $printprice = ($prices['printprice']) + ($prices['designprice']);

                if ($type == 'roll') {

                    $printprice = $prices['price'];
                    if ($qty > $prices['rolls'] and $updater != 'clear') {
                        $additional_rolls = $qty - $prices['rolls'];
                        $additional_cost = $this->orderModal->additional_charges_rolls($additional_rolls);
                        $prices['additional_cost'] = $additional_cost;
                        $printprice = $printprice + $additional_cost;
                    }
                    $prices['price'] = $printprice;
                    $prices['plainprice'] = $printprice;

                    $printprice = 0;
                }

                $printing_items = array('Free' => $prices['artworks'],
                    'Print_Qty' => $design,
                    'Print_UnitPrice' => $printprice,
                    'Print_Total' => $printprice);
                $unit_price = $prices['plainprice'] / $qty;

                $items = array('Quantity' => $qty,
                    'orignalQty' => $labels,
                    'UnitPrice' => $unit_price,
                    'TotalPrice' => $prices['plainprice']);


                $items = array_merge($items, $printing_items);

                $SID = $this->shopping_model->sessionid() . '-PRJB';
                $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));


                $data['prices'] = $prices;
                $data['labels'] = $labels;
                $data['sheets'] = $qty;
                $data['designs'] = $design;


                $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                            AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";
                $data['details'] = $this->db->query($query)->row_array();

                $data['details']['rollfinish'] = $row['FinishType'];
                //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
                /*if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
                            else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
                            else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}*/

                $data['details']['digitalprocess'] = $row['Print_Type'];

                $data['sidebar_class'] = 'orangeBg';
                $sidebar = $this->load->view('material_print_service/product_overview_sidebar', $data, true);


            }

            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;

            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $theHTMLResponse = $this->load->view('material_print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('material_print_service/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'content' => $theHTMLResponse,
                'design' => $design,
                'labels' => $labels,
                'qty' => $qty,
                'limit_exceed_designs' => $limit_exceed_designs,
                'limit_exceed_sheets' => $limit_exceed_sheets,
                'sidebar' => $sidebar);
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }



    function delete_printing_artworks()
    {

        $json_data = array('response' => 'no');
        if ($_POST) {

            $id = $this->input->post('fileid');

            $file = $this->home_model->get_db_column('integrated_attachments', 'file', 'ID', $id);
            @unlink(PATH . '/' . $file);

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('prdid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $data['unitqty'] = $this->input->post('unitqty');
            $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
            $upload_artwork_radio = $this->input->post('upload_artwork_radio');
            $data['upload_artwork_radio'] = $upload_artwork_radio;
            $data['upload_artwork_option_radio'] = $upload_artwork_option_radio;
            $this->db->delete('integrated_attachments', array('ID' => $id));

            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;
            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {

                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $data['details']['labelCategory'] = 'Roll Labels';


                $theHTMLResponse = $this->load->view('print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('print_service/upload/a4_artwork_files', $data, true);
            }


            $json_data = array('response' => 'yes', 'content' => $theHTMLResponse);


        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }



    function delete_printing_artworks_label_emb()
    {

        $json_data = array('response' => 'no');
        if ($_POST) {

            $id = $this->input->post('fileid');

            $file = $this->home_model->get_db_column('integrated_attachments', 'file', 'ID', $id);
            @unlink(PATH . '/' . $file);

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('prdid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');



            $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
            $upload_artwork_radio = $this->input->post('upload_artwork_radio');
            $data['upload_artwork_radio'] = $upload_artwork_radio;
            $data['upload_artwork_option_radio'] = $upload_artwork_option_radio;
//            $this->dd($data['upload_artwork_radio']);
            $data['unitqty'] = $this->input->post('unitqty');

            $flag = $this->input->post('flag');
            $refNumber = $this->input->post('refNumber');
            $lineNumber = $this->input->post('lineNumber');

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $data['flag'] = $flag;
                $data['refNumber'] = $refNumber;
                $data['lineNumber'] = $lineNumber;

                if ($flag == 'order_detail'){
                    $line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);

                    $table = 'orderdetails';
                    $where_column = 'SerialNumber';
                    $artwork_table = 'order_attachments_integrated';
                }elseif ($flag == 'quotation_detail'){
                    $line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);

                    $table = 'quotationdetails';
                    $where_column = 'SerialNumber';
                    $artwork_table = 'quotation_attachments_integrated';
                }
            }

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $this->db->delete($artwork_table, array('ID' => $id));
            } else {
                $this->db->delete('integrated_attachments', array('ID' => $id));
            }


            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;
            $data['details']['LabelsPerSheet'] = $persheet;
            $data['prices']['additional_cost'] = $this->input->post('additional_cost');


            $edit_cart_flag = $this->input->post('edit_cart_flag');
	        if( $edit_cart_flag ) {
		        $data['edit_cart_flag'] = $edit_cart_flag;
	        	$temp_basket_id = $this->input->post('temp_basket_id');
			    if( isset($temp_basket_id) && $temp_basket_id != '' ) {
			    	$product_basket_data = $this->getCartAndProductData($temp_basket_id);
			        $preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
			        $data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
			        $data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
			        $data['cart_and_product_data'] = $product_basket_data;
			    }	
	        }

            if ($type == 'roll') {
                $data['details']['labelCategory'] = 'Roll Labels';
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);


                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/a4_artwork_files', $data, true);
            }


            $json_data = array('response' => 'yes', 'content' => $theHTMLResponse);


        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }

    function update_additional_designs(){

        if ($_POST) {

            $cartid     = $this->input->post('cartid');
            $productid  = $this->input->post('prdid');
            $persheet   = $this->input->post('persheet');
            $design     = $this->input->post('designs');
            $type     = $this->input->post('type');
            $pressproof     = $this->input->post('pressproof');
            $data['unitqty'] = $this->input->post('unitqty');
            $SID  =  $this->shopping_model->sessionid().'-PRJB';



            $this->db->update('temporaryshoppingbasket', array('pressproof'=>$pressproof), array('ID'=>$cartid,'SessionID'=>$SID));

            $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "'.$cartid.'"')->row_array();
            $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

            $design = $design+$row['Print_Qty'];
            //$labels = $row['orignalQty']*$persheet;
            $labels = $row['orignalQty'];
            $qty = $row['Quantity'];


            $values_array = array('labeltype'=>$row['Print_Type'],
                'labels'=>$labels,
                'design'=>$design,
                'menu'=>$menu,
                'persheets'=>$persheet,
                'producttype'=>$type,
                'pressproof'=>$row['pressproof'],
                'finish'=>$row['FinishType']);
            $prices = $this->price_calculator($values_array);

            $printprice = ($prices['printprice'])+ ($prices['designprice']);

            if($type == 'roll'){

                $printprice = $prices['price'];

                //$min_qty = $this->home_model->min_qty_roll($menu);
                //$response = $this->home_model->rolls_calculation($min_qty, $persheet, $labels);
                if($qty > $prices['rolls']){
                    $additional_rolls = $qty-$prices['rolls'];
                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $prices['additional_cost'] = $additional_cost;
                    $printprice = $printprice+$additional_cost;
                }

                $prices['price'] = $printprice;
                $prices['plainprice'] = $printprice;
                $printprice = 0;
            }

            $printing_items = array( 'Free'=>$prices['artworks'],
                'Print_Qty'=>$design,
                'Print_UnitPrice'=>$printprice,
                'Print_Total'=>$printprice);

            $unit_price = $prices['plainprice']/$qty;

            $items = array('Quantity'=>$qty,
                'orignalQty'=>$labels,
                'UnitPrice'=>$unit_price,
                'TotalPrice'=>$prices['plainprice']);

            $items = array_merge($items, $printing_items);


            $this->db->update('temporaryshoppingbasket',$items, array('ID'=>$cartid,'SessionID'=>$SID));


            $data['prices'] =  $prices;
            $data['labels'] =  $labels;
            $data['sheets'] =  $qty;
            $data['designs'] = $design;


            $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
				AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";


            $data['details'] = $this->db->query($query)->row_array();
            $data['details']['rollfinish'] = $row['FinishType'];
            //$data['details']['digitalprocess'] = ($row['Print_Type']=='Fullcolour')?'Full Colour':'Black Only';
            //if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
            //else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
            //else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}

            $data['details']['digitalprocess'] =$row['Print_Type'];

            $data['sidebar_class'] = 'orangeBg';
            $theHTMLResponse = $this->load->view('print_service/product_overview_sidebar', $data, true);


            $json_data = array('response'=>'yes',
                'content'=>$theHTMLResponse,
                'design'=>$design);

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }



    }

    function update_cart_with_upload()
    {

        if ($_POST) {

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('prdid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $data['unitqty'] = $this->input->post('unitqty');

            $SID = $this->shopping_model->sessionid() . '-PRJB';

            $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
				WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


            $desingtotal = $this->db->query(' Select count(*) as total from integrated_attachments 
				WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


            $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
            $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

            $design = $desingtotal['total'];
            $labels = $quantity['labels'];
            $qty = $quantity['qty'];


            $values_array = array('labeltype' => $row['Print_Type'],
                'labels' => $labels,
                'design' => $design,
                'menu' => $menu,
                'persheets' => $persheet,
                'producttype' => $type,
                'pressproof' => $row['pressproof'],
                'finish' => $row['FinishType']);
            $prices = $this->price_calculator($values_array);

            $printprice = ($prices['printprice']) + ($prices['designprice']);

            if ($type == 'roll') {

                $printprice = $prices['price'];
                if ($qty > $prices['rolls']) {

                    $additional_rolls = $qty - $prices['rolls'];
                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $prices['additional_cost'] = $additional_cost;
                    $printprice = $printprice + $additional_cost;
                }

                $prices['price'] = $printprice;
                $prices['plainprice'] = $printprice;
                $printprice = 0;
            }

            $printing_items = array('Free' => $prices['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => $printprice,
                'Print_Total' => $printprice);

            $unit_price = $prices['plainprice'] / $qty;

            $items = array('Quantity' => $qty,
                'orignalQty' => $labels,
                'UnitPrice' => $unit_price,
                'TotalPrice' => $prices['plainprice']);

            $items = array_merge($items, $printing_items);


            $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));


            $prices['price'] = $this->home_model->currecy_converter($prices['price'], 'yes');
            $prices['plainprint'] = $this->home_model->currecy_converter($prices['plainprint'], 'yes');
            $prices['plainprice'] = $this->home_model->currecy_converter($prices['plainprice'], 'yes');
            $prices['printprice'] = $this->home_model->currecy_converter($prices['printprice'], 'yes');
            $prices['designprice'] = $this->home_model->currecy_converter($prices['designprice'], 'yes');
            $prices['pressproof'] = $this->home_model->currecy_converter($prices['pressproof'], 'yes');


            $data['prices'] = $prices;
            $data['labels'] = $labels;
            $data['sheets'] = $qty;
            $data['designs'] = $design;


            $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
				AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";


            $data['details'] = $this->db->query($query)->row_array();
            $data['details']['rollfinish'] = $row['FinishType'];

            //if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
            //else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
            //else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}

            $data['details']['digitalprocess'] = $row['Print_Type'];


            $data['sidebar_class'] = 'orangeBg';
            $sidebar = $this->load->view('print_service/product_overview_sidebar', $data, true);


            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;
            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $theHTMLResponse = $this->load->view('print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('print_service/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'sidebar' => $sidebar,
                'content' => $theHTMLResponse,
                'design' => $design);

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }


    }



    function material_update_cart_with_upload()
    {

        if ($_POST) {

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('prdid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $data['unitqty'] = $this->input->post('unitqty');

            $SID = $this->orderModal->sessionid() . '-PRJB';

            $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


            $desingtotal = $this->db->query(' Select count(*) as total from integrated_attachments 
                WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


            $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();
            $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);

            $design = $desingtotal['total'];
            $labels = $quantity['labels'];
            $qty = $quantity['qty'];


            $values_array = array('labeltype' => $row['Print_Type'],
                'labels' => $labels,
                'design' => $design,
                'menu' => $menu,
                'persheets' => $persheet,
                'producttype' => $type,
                'pressproof' => $row['pressproof'],
                'finish' => $row['FinishType']);
            $prices = $this->price_calculator($values_array);

            $printprice = ($prices['printprice']) + ($prices['designprice']);

            if ($type == 'roll') {

                $printprice = $prices['price'];
                if ($qty > $prices['rolls']) {

                    $additional_rolls = $qty - $prices['rolls'];
                    $additional_cost = $this->orderModal->additional_charges_rolls($additional_rolls);
                    $prices['additional_cost'] = $additional_cost;
                    $printprice = $printprice + $additional_cost;
                }

                $prices['price'] = $printprice;
                $prices['plainprice'] = $printprice;
                $printprice = 0;
            }

            $printing_items = array('Free' => $prices['artworks'],
                'Print_Qty' => $design,
                'Print_UnitPrice' => $printprice,
                'Print_Total' => $printprice);

            $unit_price = $prices['plainprice'] / $qty;

            $items = array('Quantity' => $qty,
                'orignalQty' => $labels,
                'UnitPrice' => $unit_price,
                'TotalPrice' => $prices['plainprice']);

            $items = array_merge($items, $printing_items);


            $this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));


            $data['prices'] = $prices;
            $data['labels'] = $labels;
            $data['sheets'] = $qty;
            $data['designs'] = $design;


            $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";


            $data['details'] = $this->db->query($query)->row_array();
            $data['details']['rollfinish'] = $row['FinishType'];

            //if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
            //else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
            //else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}

            $data['details']['digitalprocess'] = $row['Print_Type'];


            $data['sidebar_class'] = 'orangeBg';
            $sidebar = $this->load->view('material_print_service/product_overview_sidebar', $data, true);


            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;
            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $theHTMLResponse = $this->load->view('material_print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('material_print_service/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'sidebar' => $sidebar,
                'content' => $theHTMLResponse,
                'design' => $design);

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }


    }




    function material_update_cart_with_upload_label_emb()
    {

        if ($_POST) {
            $upload_artwork_option_radio = $this->input->post('upload_artwork_option_radio');
            $upload_artwork_radio = $this->input->post('upload_artwork_radio');
            $data['upload_artwork_radio'] = $upload_artwork_radio;
            $data['upload_artwork_option_radio'] = $upload_artwork_option_radio;
            $data['lines_to_populate'] = $this->input->post('lines_to_populate');
            $digital_process_plus_white = $this->input->post('digital_process_plus_white');
            $label_application = $this->input->post('label_application');
            $combination_base = $this->input->post('combination_base');
            $cartid = $this->input->post('cartid');
            $press_proof = $this->input->post('press_proof');
            $productid = $this->input->post('prdid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');
            $producttype = $type;
            $data['unitqty'] = $this->input->post('unitqty');
            $data['producttype'] = $producttype;
//            $laminations_and_varnishes = $this->input->post('laminations_and_varnishes');
//            $laminations_and_varnishes = $this->input->post('laminations_and_varnishes_childs');

            $flag = $this->input->post('flag');
            $refNumber = $this->input->post('refNumber');
            $lineNumber = $this->input->post('lineNumber');

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $data['flag'] = $flag;
                $data['refNumber'] = $refNumber;
                $data['lineNumber'] = $lineNumber;

                if ($flag == 'order_detail'){
                    $line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);

                    $table = 'orderdetails';
                    $where_column = 'SerialNumber';
                    $label_column = 'labels';
                    $artwork_table = 'order_attachments_integrated';
                }elseif ($flag == 'quotation_detail'){
                    $line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);

                    $table = 'quotationdetails';
                    $where_column = 'SerialNumber';
                    $label_column = 'orignalQty';
                    $artwork_table = 'quotation_attachments_integrated';
                }
            }


            $laminations_and_varnishes_childs_array = $this->input->post('laminations_and_varnishes_childs');

//           bypass 'total_emb_plate_price' variable from $this->input->post('total_emb_plate_price') and calculate
//            it from backend on the basis of laminations_and_varnishes_childs array passed in post param.
//            to prevent plate price wrong total due to already purchased module
            $plate_cost = 0;

            if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                $selected_already_plates_composite_array = $this->input->post('selected_already_plates_composite_array');
                $minus_plate_cost = array();
                $use_old_plate = array();
                foreach ($laminations_and_varnishes_childs_array as $finish_child){
//            print_r($finish_child); echo '<br>';
                    $this->db->where('parsed_title', $finish_child);
                    $this->db->where('label_emb_parent_id !=', 0);

                    $cost_result = $this->db->get('label_embellishment')->row_array();

//            use to calculate already purchased plate cost for minus plate price purpose
                    foreach ($selected_already_plates_composite_array as $selected_already_plate_composite){
//                        print_r($selected_already_plate_composite);
                        $selected_already_plate_composite = json_decode($selected_already_plate_composite);
//                        print_r($selected_already_plate_composite);
                        if ($selected_already_plate_composite->already_used_plate_id == $cost_result['id'] ){

                            $plate_cost_obj = new stdClass();
                            $plate_cost_obj->parsed_title = $cost_result['parsed_title'];
                            $plate_cost_obj->plate_cost = $cost_result['plate_cost'];
                            $minus_plate_cost[] = $plate_cost_obj;
                            $use_old_plate_obj = new stdClass();
                            $use_old_plate_obj->parsed_title = $cost_result['parsed_title'];
                            $use_old_plate_obj->plate_order_no = $selected_already_plate_composite->plate_order_no;
                            $use_old_plate[] = $use_old_plate_obj;

                        }
                    }
                    $plate_cost+= $cost_result['plate_cost'];
                }
                $data['minus_plate_cost'] = $minus_plate_cost;
//          echo "<pre>";  print_r($cost_result['plate_cost']);
            }
//       echo '<br>'; print_r($use_old_plate);
            if($plate_cost <= 0){
                $total_emb_plate_price = 0;
                $data['total_emb_plate_price'] = $total_emb_plate_price;

            }else{
                $data['total_emb_plate_price'] = $plate_cost;

            }

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {

                $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from '.$artwork_table.' 
                WHERE Serial = '.$lineNumber .' AND ProductID LIKE '.$productid.' ')->row_array();


                $desingtotal = $this->db->query(' Select count(*) as total from '.$artwork_table.' 
                WHERE Serial = '.$lineNumber .' AND ProductID LIKE '.$productid.' ')->row_array();


                $row = $this->db->query('Select * from '.$table.' WHERE '.$where_column.' = '.$lineNumber .' ')->row_array();

            } else {

                $SID = $this->shopping_model->sessionid() . '-PRJB';
                $quantity = $this->db->query(' Select SUM(labels) as labels,SUM(qty) as qty from integrated_attachments 
                WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


                $desingtotal = $this->db->query(' Select count(*) as total from integrated_attachments 
                WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $productid . '" ')->row_array();


                $row = $this->db->query('Select * from temporaryshoppingbasket WHERE ID LIKE "' . $cartid . '"')->row_array();

            }


//            $menu = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
            $menu = $this->db->query("Select ManufactureID from products WHERE ProductID = $productid")->row_array();
            $menu = $menu['ManufactureID'];
            $design = $desingtotal['total'];
            $labels = $quantity['labels'];
            $qty = $quantity['qty'];




            if (isset($laminations_and_varnishes_childs_array) && !empty($laminations_and_varnishes_childs_array)){
                $rollfinish = $laminations_and_varnishes_childs_array;
            }else{
                $laminations_and_varnishes_array = json_decode($row['FinishTypePrintedLabels']);
                $rollfinish = $laminations_and_varnishes_array;
            }


            $labeltype = $row['Print_Type'];
            //$labeltype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);

            if (preg_match("/Monochrome/i", $labeltype)) {
                $labeltype = "Monochrome - Black Only";


            } elseif (preg_match("/6_Colour_Digital_Process_White/i", $labeltype)) {
                $labeltype = "6 Colour Digital Process + White";


            } elseif (preg_match("/6_Colour_Digital_Process/i", $labeltype)) {
                $labeltype = "6 Colour Digital Process";


            }elseif (preg_match("/4_Colour_Digital_Process/i", $labeltype)) {
                $labeltype = "4 Colour Digital Process";


            }elseif (preg_match("/Rich_Black/i", $labeltype)) {
                $labeltype = "Rich Black";


            }
            if (isset($digital_process_plus_white) && !empty($digital_process_plus_white) && $digital_process_plus_white == "add_white" ){
                $labeltype = "6 Colour Digital Process + White";

            }

            $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID";
            $data['details'] = $this->db->query($query)->row_array();
            if ( $data['details']['Shape_upd'] == "Circular") {
                $label_size = ucwords(str_replace("Label Size:", "",  $data['details']['specification3']));
                $label_size = str_replace("Mm", "", $label_size);
            } else {
                $label_size =  $data['details']['LabelWidth'] . " x " .  $data['details']['LabelHeight'];
                $label_size = str_replace("mm", "", $label_size);

            }
            $data['label_size'] = $label_size;

            $edit_cart_flag = $this->input->post('edit_cart_flag');
	        if( $edit_cart_flag ) {
		        $data['edit_cart_flag'] = $edit_cart_flag;
	        	$temp_basket_id = $this->input->post('temp_basket_id');
			    if( isset($temp_basket_id) && $temp_basket_id != '' ) {
			    	$product_basket_data = $this->getCartAndProductData($temp_basket_id);
			        $preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
			        $data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
			        $data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
			        $data['cart_and_product_data'] = $product_basket_data;
			    }	
	        } else {
	        	$session_id = $this->shopping_model->sessionid();
            	$preferences = $this->orderModal->material_load_preferences($session_id);
	        }

            
            $data['preferences'] = $preferences;
//        print_r($preferences);
            $data['availabel_in'] = $data['preferences']['available_in'];
            if ($type == 'sheet') {
                $sheet_product_quality = $this->input->post('sheet_product_quality');

                if(isset($sheet_product_quality) && !empty($sheet_product_quality)){

                    if ($sheet_product_quality == 'premium'){
                        $values_array = array( 'printing' => $labeltype,
                            'labels' => $labels,
                            'design' => $design,
                            'menu' => $menu,
                            'persheets' => $persheet,
                            'producttype' => $producttype,
                            'pressproof' => $press_proof,
                            'finish' => $rollfinish,
                            'sheet_product_quality'=>"premium"
                        );


                        $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                    }elseif ($sheet_product_quality == 'standerd'){
                        $values_array = array( 'printing' => $labeltype,
                            'labels' => $labels,
                            'design' => $design,
                            'menu' => $menu,
                            'persheets' => $persheet,
                            'producttype' => $producttype,
                            'pressproof' => $press_proof,
                            'finish' => $rollfinish,
                            'sheet_product_quality'=>"standerd"

                        );
                        $prices = $this->calculate_sheet_price_printed_emb_page($values_array);

                    }
                }
//                $values_array = array( 'printing' => $labeltype,
//                    'labels' => $labels,
//                    'design' => $design,
//                    'menu' => $menu,
//                    'persheets' => $persheet,
//                    'producttype' => $producttype,
//                    'pressproof' => $press_proof,
//                    'finish' => $rollfinish
//                );
////            print_r($values_array);die;
//
//                $prices = $this->calculate_sheet_price_printed_emb_page($values_array);



//echo"<pre>"; print_r( $prices);die;

//            $price = $this->home_model->currecy_converter($response['price'] + $additional_cost, 'yes');
            } else{
                $values_array_roll_price = array('roll' => $qty,
                    'menu' => $menu,
                    'prd_id' => $productid,
                    'labels' => $labels,
                    'printing' => $labeltype,
                    'persheets'=>$persheet,
                    'pressproof'=>$press_proof,
                    'requestfrom' => "material_page1",
                    'rollfinish' => $rollfinish,
                    'upload_artwork_option_radio' => $upload_artwork_option_radio
                );
//        function that call price calculator function for label-embellishment page
                $prices = $this->calculate_roll_price_printed_emb_page($values_array_roll_price);

            }
            $old_plate_cost_total_for_minus_total_price = 0;
            foreach ($prices['label_finish_individual_cost_array'] as $key=> $label_finish_individual_cost_array) {
                $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                if (isset($use_old_plate) && count($use_old_plate) > 0) {
                    foreach ($use_old_plate as $old_plate) {
                        if ($label_finish_individual_cost_array->finish_parsed_title == $old_plate->parsed_title) {
                            $old_plate_cost_total_for_minus_total_price+=$label_finish_individual_cost_array->plate_cost;
                            $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 1;
                            $prices['label_finish_individual_cost_array'][$key]->used_plate_orderNumber = $old_plate->plate_order_no;
                        }
                    }
                } else {
                    $prices['label_finish_individual_cost_array'][$key]->use_old_plate = 0;

                }
            }

            $printprice = ($prices['printprice']) + ($prices['designprice']);

            if ($type == 'roll') {
                $printprice = $prices['halfprintprice'];
                if ($qty > $prices['rolls']) {
                    $additional_rolls = $qty - $prices['rolls'];


                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                    $prices['additional_cost'] = number_format($additional_cost, 2, '.', '');

                    $printprice = $printprice + $additional_cost;

                }
                $plate_cost -=$old_plate_cost_total_for_minus_total_price;
                $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice +$prices['presproof_charges'];
//                        echo"<pre>";print_r($prices);die;

                $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';
                $total_emb_cost = $prices['label_finish'] + $plate_cost;

                $prices['price'] = $price_txt;

//                               $prices['plainprice'] = $prices['plainlabelsprice'];
                //sum all prices(emb,finish,pressproof,mb_plae_price,print_price,plain_price for roll as
                //in case of roll it will go in TotalPrice column of tempshopbaskt and
                // For sheet print price add sepereately in column
                // Print_Total and plain price add in TotalPrice and shows both prices in separate line in cart and order confirmaion.
                $total_price_all = $printprice_shopping_cart +  $prices['plainlabelsprice'];
                $prices['plainprice'] = $total_price_all;
                $prices['printprice'] = $printprice;
                $printprice_shopping_cart = 0;

                //$printprice = 0;
            }else{
                $plate_cost -=$old_plate_cost_total_for_minus_total_price;

                $printprice_shopping_cart =  $prices['label_finish'] + $plate_cost + $printprice;
                $price_txt = '<b class="color-orange"> ' . symbol . $printprice . ' </b> <br />' . vatoption . ' VAT';
                $total_emb_cost = $prices['label_finish'] + $plate_cost;
//                        print_r($printprice);die;
                $prices['price'] = $price_txt;
//                        $prices['printprice'] = $printprice;
            }

            $Print_Design = '1 Design';
            if ($design > 1) {
                $Print_Design = 'Multiple Designs';
            }



            $printing_items = array('Free' => $prices['artworks'],
                'Print_Qty' => $design,
                'Print_Design' => $Print_Design,
                'Print_UnitPrice' => $printprice_shopping_cart,
                'total_emb_cost' => $total_emb_cost,
                'Print_Total' => $printprice_shopping_cart);
//                    $plain_price_and_emb_plate_sum = $prices['plainprice'] + $this->input->post('total_emb_plate_price');
            $unit_price =  $prices['plainprice']/ $qty;


            $items = array('Quantity' => $qty,
                'orignalQty' => $labels,
                'UnitPrice' => $unit_price,
                'TotalPrice' => $prices['plainprice'],
                'FinishTypePrintedLabels' => json_encode($laminations_and_varnishes_childs_array),
                'FinishTypePricePrintedLabels' => json_encode( $prices['label_finish_individual_cost_array']),
                'use_old_plate' => json_encode($use_old_plate),
                'custom_roll_and_label' => $upload_artwork_option_radio,
                'label_application' => $label_application,
                'combination_base' => $combination_base
                );


            $items = array_merge($items, $printing_items);

//            print_r($prices);echo"<br>";
//            print_r($items);die;
            
            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $updation_array = $this->home_model->emb_update_line($items,$flag,$refNumber,$lineNumber);
            } else {

				if( $edit_cart_flag ) {
					$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid));
				} else {
					$this->db->update('temporaryshoppingbasket', $items, array('ID' => $cartid, 'SessionID' => $SID));
				}
				
            }



            $data['prices'] = $prices;
            $data['labels'] = $labels;
            $data['sheets'] = $qty;
            $data['designs'] = $design;


            $query = " Select * from products p,category c WHERE ManufactureID LIKE '$menu' 
                AND SUBSTRING_INDEX(p.CategoryID,'R',1)=c.CategoryID ";


            $data['details'] = $this->db->query($query)->row_array();
            $data['details']['rollfinish'] = $row['FinishType'];

            //if($row['Print_Type'] == 'Fullcolour'){ $data['details']['digitalprocess'] = 'Full Colour';}
            //else if($row['Print_Type'] == 'Fullcolour+White'){ $data['details']['digitalprocess'] = 'Full Colour + White';}
            //else if($row['Print_Type'] == 'Mono'){ $data['details']['digitalprocess'] = 'Black Only';}

            $data['details']['digitalprocess'] = $row['Print_Type'];


            $data['sidebar_class'] = 'orangeBg';
            $data['labeltype'] = $labeltype;
            $data['cartid'] = $cartid;
//            $data['total_emb_plate_price'] = $this->input->post('total_emb_plate_price');
            $cart_summery = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);



            $data['details']['cartid'] = $cartid;
            $data['details']['ProductID'] = $productid;
            $data['details']['LabelsPerSheet'] = $persheet;

            if ($type == 'roll') {
                $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/roll_artwork_files', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'cart_summery' => $cart_summery,
                'content' => $theHTMLResponse,
                'design' => $design);

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }


    }

    function add_printing_tocart()
    {

        $cartid = $this->input->post('cartid');
        $prdid = $this->input->post('prdid');
        $persheet = $this->input->post('persheet');
        $actual = $this->input->post('actual');
        $coresize = $this->input->post('coresize');
        $woundoption = $this->input->post('woundoption');
        $orientation = $this->input->post('orientation');
        $upload_option = $this->input->post('upload_option');

        if ($_POST) {

            $update_array = array();
            $product_type = 'sheet';

            $query = " Select * from products WHERE ProductID LIKE '$prdid' LIMIT 1";
            $details = $this->db->query($query)->row_array();
            $orignal_productid = $details['ProductID'];

            if (preg_match("/roll labels/is", $details['ProductBrand'])) {


                $menu = substr($details['ManufactureID'], 0, -1);
                $menuid = $menu . str_replace("R", "", $coresize);
                $orignal_productid = $this->home_model->get_db_column('products', 'ProductID', 'ManufactureID', $menuid);

                $orientation = str_replace("orientation", "", $orientation);
                $update_array = array_merge(array('orientation' => $orientation,
                    'wound' => $woundoption,
                    'ProductID' => $orignal_productid), $update_array);
                $product_type = 'roll';
            }

            if ($upload_option == 'design_services') {

                /*$printprice = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Total', 'ID', $cartid);

					$desingsservice =  $this->input->post('desingsservice');
					$comments =  $this->input->post('comments');
					$desingscharge = $this->home_model->desing_service_charges($desingsservice);
					$update_array = array_merge($update_array, array('design_service'=>$desingsservice,
																	 'design_service_charge'=>$desingscharge,
																	 'Print_UnitPrice'=>($printprice+$desingscharge),
																	 'Print_Total'=>($printprice+$desingscharge)));
					if (!empty($_FILES)) {
						$response = $this->home_model->upload_images('file','/');
						if($response!='error'){
							$update_array = array_merge($update_array, array('design_file'=>$response));
						}
					}
					if(isset($comments) and $comments!=''){
							$update_array = array_merge($update_array, array('Product_detail'=>$comments));
					}*/
                $desingsservice = $this->input->post('desingsservice');
                //$comments =  $this->input->post('comments');
                $comments = $this->product_model->clean($this->input->post('comments', true));
                $desingscharge = $this->home_model->desing_service_charges($desingsservice);

                $design_file = '';
                if (!empty($_FILES)) {
                    $response = $this->home_model->upload_images('file', '/');
                    if ($response != 'error') {
                        $design_file = $response;
                    }
                }

                $desingscharge = $desingscharge / 1.2;
                $unit_price = $desingscharge / $desingsservice;
                $SID = $this->shopping_model->sessionid();
                $design_array = array('SessionID' => $SID,
                    'p_code' => $cartid,
                    'ProductID' => 125633,
                    'OrderTime' => 'NOW()',
                    'source' => 'printing',
                    'Quantity' => $desingsservice,
                    'UnitPrice' => $unit_price,
                    'TotalPrice' => $desingscharge,
                    'Product_detail' => $comments,
                    'design_file' => $design_file);
                $this->db->insert('temporaryshoppingbasket', $design_array);


            } else {


                $update_array = array_merge($update_array, array('Product_detail' => '',
                    'design_file' => '',
                    'design_service_charge' => '',
                    'design_service' => ''));
            }


            $SID = $this->shopping_model->sessionid();
            $update_array = array_merge(array('SessionID' => $SID, 'page_location' => 'Printed Labels'), $update_array);


            $row = $this->db->query('Select pressproof from temporaryshoppingbasket
					WHERE ID LIKE "' . $cartid . '" AND SessionID LIKE "' . $SID . '-PRJB"')->row_array();

            if (isset($row['pressproof']) and $row['pressproof'] == 1 and preg_match("/roll labels/is", $details['ProductBrand'])) {
                $update_array = array_merge($update_array,
                    array('Product_detail' => '***DO NOT START PRINTING ORDER UNTIL PRESS PROOF HAS BEEN APPROVED***'));
            }


            $this->db->update('temporaryshoppingbasket', $update_array, array('ID' => $cartid, 'SessionID' => $SID . '-PRJB'));
            /*echo '<pre>';
 print_r($update_array); die;*/
            if ($upload_option == 'upload_artwork') {
                $this->db->update('integrated_attachments', array('SessionID' => $SID,
                    'ProductID' => $orignal_productid),
                    array('ProductID' => $prdid,
                        'CartID' => $cartid,
                        'SessionID' => $SID . '-PRJB'));
            } else {
                $this->db->delete('integrated_attachments', array('CartID' => $cartid, 'SessionID' => $SID . '-PRJB', 'ProductID' => $prdid));
            }
        }


        $json_data = array('response' => 'yes');
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));


    }

    function upload_file_custom_design_label_emb(){
//        echo"<pre>";print_r($_FILES);die;

        $request = 1;
        if(isset($_POST['request'])){
            $request = $_POST['request'];
        }
        if($request == 1) {
            if (!empty($_FILES)) {

                $response = $this->home_model->upload_images('file', '/');
                if ($response != 'error') {
                    $design_file = $response;
                    $msg = $design_file;

                }else{
                    header("HTTP/1.0 400 Bad Request");
                    $msg = "Error while uploading";
//                $msg = $response;

                }
                echo $msg;
                exit;
            }
        }
        // Remove file
        if($request == 2){

            $filename = PATH . '/'.$_POST['name'];
//            @unlink(PATH . '/' . $file);

            unlink($filename);
            exit;
        }
//        $json_data = array('response' => 'yes','design_file'=>$design_file);
//        $this->output->set_content_type('application/json');
//        $this->output->set_output(json_encode($json_data));


    }

    function add_custom_design_to_cart_label_emb(){

//        [uploaded_file_names] => ["ad22.png","ad2.png","ad21.png"]
//        [uploaded_file_names1] => ad22.png,ad2.png,ad21.png
//        [selected_package] => custom_label
//        [additional_version] => 5
//    [design_brief] => xcvxcvx
//        [full_name] => cxvxcv
//        [email] => aalabelsusman@gmail.com
//        [phone] => 4543543
//    [cartid] => 31165
//         $uploaded_file_names_raw = $this->input->post('uploaded_file_names');


        $uploaded_file_names = json_encode($uploaded_file_names);
        $additional_version = $this->input->post('additional_version');
        $selected_package = $this->input->post('selected_package');
        $design_brief = $this->product_model->clean($this->input->post('design_brief'));
        $full_name = $this->input->post('full_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $cartid = $this->input->post('cartid');
        $additional_version_price_each = 10;
        $package_design = 0;

        $uploaded_file_names_json = array();
        $uploaded_file_names = explode(',',$this->input->post('uploaded_file_names'));
        $name_and_file_obj = new stdClass();
        $name_and_file_obj->package_name = $selected_package;
        $name_and_file_obj->full_name = $full_name;
        $name_and_file_obj->email = $email;
        $name_and_file_obj->phone = $phone;
        $name_and_file_obj->files = $uploaded_file_names;
        $uploaded_file_names_json = json_encode($name_and_file_obj);


        if ($selected_package == 'custom_label'){
            $package_design = 1;
        }elseif ($selected_package == 'enhanced_label'){
            $package_design = 2;

        }elseif ($selected_package == 'professional_label'){
            $package_design = 3;

        }

//         echo"<pre>";print_r($this->input->post());die;

//            $desingsservice = $this->input->post('desingsservice');
        //$comments =  $this->input->post('comments');
        $integrated_attachment_total_lines = $additional_version + $package_design;
        $additional_version_cost_total = $additional_version  * $additional_version_price_each;

        $desingscharge = $this->home_model->desing_service_charges_label_emb($package_design);

        $design_file = '';

//            $desingscharge = $desingscharge / 1.2;
        $total = $desingscharge+$additional_version_cost_total;
        $unit_price = $total / $integrated_attachment_total_lines;
        $SID = $this->shopping_model->sessionid();
        $design_array = array('SessionID' => $SID,
            'p_code' => $cartid,
            'ProductID' => 125633,
            'OrderTime' => date('d-m-Y H:i:s'),
            'source' => 'printing',
            'Quantity' => $integrated_attachment_total_lines,
            'UnitPrice' => $unit_price,
            'TotalPrice' => $total,
            'Product_detail' => $design_brief,
            'inhouse_package_and_design_files' => $uploaded_file_names_json
//                'design_file' => $design_file
        );
        //        print_r($design_array);die;



        $this->db->insert('temporaryshoppingbasket', $design_array);
        $cartid = $this->db->insert_id();

//        $sql = $this->db->query("select * from order_attachments_integrated where Serial = $serial")->result_array();

        for ($i=1;$i<=$integrated_attachment_total_lines;$i++) {
            $array = array('SessionID' => $this->session->userdata('session_id'),
                'ProductID' => 125633,
                'file' => 'inhouse_design',
                'Thumb' => '',
                'labels' => 1,
                'qty' => 1,
                'source' => 'web',
                'type' => 'new',
                'CartID' => $cartid,
                'status' => 'confirm'
            );
            $this->db->insert('integrated_attachments', $array);
        }
        //$topcart_data = $this->ajax_topcart_load();
        $json_data = array( 'status' => 'yes');
        $this->output->set_output(json_encode($json_data));
//        echo"success";
//
//        $array = array(
//            'attach_id'=>$jobno,
//            'operator'=>$this->session->userdata('UserID'),
//            'comment'=>$type,
//            'ref'=>$ref,
//            $filed=>$attachment
//        );
//        $this->db->insert('artwork_chat',$array);

    }

    function add_printing_tocart_label_emb()
    {

        $cartid = $this->input->post('cartid');
        $prdid = $this->input->post('prdid');
        $persheet = $this->input->post('persheet');
        $actual = $this->input->post('actual');
        $coresize = $this->input->post('coresize');
        $woundoption = $this->input->post('woundoption');
        $orientation = $this->input->post('orientation');
        $upload_option = $this->input->post('upload_option');

        $flag = $this->input->post('flag');
        $refNumber = $this->input->post('refNumber');
        $lineNumber = $this->input->post('lineNumber');
        $returnUrl = $this->input->post('returnUrl');

        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
           // Dont need here Just continue;
        } else {
            if ($_POST) {

                $update_array = array();
                $product_type = 'sheet';

                $query = " Select * from products WHERE ProductID LIKE '$prdid' LIMIT 1";
                $details = $this->db->query($query)->row_array();
                $orignal_productid = $details['ProductID'];

                if (preg_match("/roll labels/is", $details['ProductBrand'])) {


                    $menu = substr($details['ManufactureID'], 0, -1);
                    $menuid = $menu . str_replace("R", "", $coresize);
                    $orignal_productid = $this->home_model->get_db_column('products', 'ProductID', 'ManufactureID', $menuid);

                    $orientation = str_replace("orientation", "", $orientation);
                    $update_array = array_merge(array('orientation' => $orientation,
                        'wound' => $woundoption,
                        'ProductID' => $orignal_productid), $update_array);
                    $product_type = 'roll';
                }

                if ($upload_option == 'design_services') {

                    /*$printprice = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Total', 'ID', $cartid);

                        $desingsservice =  $this->input->post('desingsservice');
                        $comments =  $this->input->post('comments');
                        $desingscharge = $this->home_model->desing_service_charges($desingsservice);
                        $update_array = array_merge($update_array, array('design_service'=>$desingsservice,
                                                                         'design_service_charge'=>$desingscharge,
                                                                         'Print_UnitPrice'=>($printprice+$desingscharge),
                                                                         'Print_Total'=>($printprice+$desingscharge)));
                        if (!empty($_FILES)) {
                            $response = $this->home_model->upload_images('file','/');
                            if($response!='error'){
                                $update_array = array_merge($update_array, array('design_file'=>$response));
                            }
                        }
                        if(isset($comments) and $comments!=''){
                                $update_array = array_merge($update_array, array('Product_detail'=>$comments));
                        }*/
                    $desingsservice = $this->input->post('desingsservice');
                    //$comments =  $this->input->post('comments');
                    $comments = $this->product_model->clean($this->input->post('comments', true));
                    $desingscharge = $this->home_model->desing_service_charges($desingsservice);

                    $design_file = '';
                    if (!empty($_FILES)) {
                        $response = $this->home_model->upload_images('file', '/');
                        if ($response != 'error') {
                            $design_file = $response;
                        }
                    }

                    $desingscharge = $desingscharge / 1.2;
                    $unit_price = $desingscharge / $desingsservice;
                    $SID = $this->shopping_model->sessionid();
                    $design_array = array('SessionID' => $SID,
                        'p_code' => $cartid,
                        'ProductID' => 125633,
                        'OrderTime' => 'NOW()',
                        'source' => 'printing',
                        'Quantity' => $desingsservice,
                        'UnitPrice' => $unit_price,
                        'TotalPrice' => $desingscharge,
                        'Product_detail' => $comments,
                        'design_file' => $design_file);
                    $this->db->insert('temporaryshoppingbasket', $design_array);


                } else {


                    $update_array = array_merge($update_array, array('Product_detail' => '',
                        'design_file' => '',
                        'design_service_charge' => '',
                        'design_service' => ''));
                }


                $SID = $this->shopping_model->sessionid();
                $update_array = array_merge(array('SessionID' => $SID, 'page_location' => 'Printed Labels'), $update_array);
                $row = $this->db->query('Select pressproof from temporaryshoppingbasket
					WHERE ID LIKE "' . $cartid . '" AND SessionID LIKE "' . $SID . '-PRJB"')->row_array();

                if (isset($row['pressproof']) and $row['pressproof'] == 1 and preg_match("/roll labels/is", $details['ProductBrand'])) {
                    $update_array = array_merge($update_array,
                        array('Product_detail' => '***DO NOT START PRINTING ORDER UNTIL PRESS PROOF HAS BEEN APPROVED***'));
                }


                $this->db->update('temporaryshoppingbasket', $update_array, array('ID' => $cartid, 'SessionID' => $SID . '-PRJB'));
                /*echo '<pre>';print_r($update_array); die;*/
                if ($upload_option == 'upload_artwork' || $upload_option == 'email_artwork') {
                    $this->db->update('integrated_attachments', array('SessionID' => $SID,
                        'ProductID' => $orignal_productid),
                        array('ProductID' => $prdid,
                            'CartID' => $cartid,
                            'SessionID' => $SID . '-PRJB'));
                } else {
                    $this->db->delete('integrated_attachments', array('CartID' => $cartid, 'SessionID' => $SID . '-PRJB', 'ProductID' => $prdid));
                }
            }
        }

        /*echo '<pre>';
        print_r($update_array); die;*/
        $json_data = array('response' => 'yes');
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));


    }

    function artwork_approval(){
        if ($_POST) {
            $feedback = $this->input->post('feedback');
            //print_r($feedback); die();
            $this->db->insert('customer_artwork_feedback', $feedback);
            $jobid = $feedback['jobno'];
            $type = $feedback['type'];
            $ordernumber = $feedback['OrderNumber'];
            $language = $this->input->post('language');
            $version = $feedback['version'];

            $maxref = $feedback['ref'];
            $approveref = $feedback['approveref'];


            if ($type == "amend") {
                $version = $version + 1;
                $array = array('status' => 65, 'lastmodified' => time(), 'action' => 1, 'softproof' => '', 'version' => $version, 'CO' => 1, 'SP' => 0, 'CA' => 0, 'PF' => 0);
            } else {
                $array = array('status' => 68, 'lastmodified' => time(), 'action' => 1, 'CA' => 1, 'approve_date' => time());
                if ($maxref != $approveref) {
                    $chat = $this->home_model->fetch_current_chat($jobid, $approveref);
                    $array = array_merge($array, array('softproof' => $chat['softproof']));
                }
            }

            $this->home_model->update_order_attachment($jobid, $array);
            $this->home_model->add_to_timeline($jobid, '67', $version);

            $result = $this->home_model->get_artwork_jobs(md5($ordernumber));

            if (isset($result) and count($result) > 0) {
                $data['result'] = $result;
                $data['language'] = $language;
                $this->home_model->versionrecord($data['result']['ID']);
                $theHTMLResponse = $this->load->view('print_service/softproof/' . $language . '/header', $data, true);
                $theHTMLResponse_qa = $this->load->view('print_service/softproof/' . $language . '/qa', $data, true);
                $json_data = array('response' => 'yes', 'artworkjobno' => $result['ID'], 'version' => $result['version'], 'language' => $language, 'content' => $theHTMLResponse, 'qacontent' => $theHTMLResponse_qa);
            } else {

                $OrderStatus = $this->home_model->get_db_column('orders', 'OrderStatus', 'OrderNumber', $ordernumber);
                $alsent = '';
                $alsent = $this->session->userdata('alreadysent');
                if ($alsent != $ordernumber and $OrderStatus == 55) {
                    $this->aaemail->artwork_summary($ordernumber);
                    $this->session->set_userdata('alreadysent', $ordernumber);
                    $this->load->library('Custom');
                    $this->custom->assign_dispatch_date($ordernumber);
                    $this->home_model->addcustomernote($ordernumber);
                }
                $json_data = array('response' => 'completed');
            }

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($json_data));
        }
    }

    function purchased_plate_history_selected($data)
    {
        $theHTMLResponse = '';

        $user_id = $data['user_id'];
        $selected_already_plates = json_decode($data['selected_already_plates']) ;
        $selected_already_plates_composite_array = $data['selected_already_plates_composite_array'];
        $selected_already_plates = array_unique($selected_already_plates);

        if (!empty($user_id)) {

            $purchased_plate_history  = $this->home_model->get_db_column('customers', 'purchased_plate_history', 'UserID', $user_id);
            $purchased_plate_history = json_decode($purchased_plate_history);
            if (isset($purchased_plate_history) && !empty($purchased_plate_history)) {
                $data['purchased_plate_history'] = $purchased_plate_history;
                $data['selected_already_plates'] = $selected_already_plates;
                $data['selected_already_plates_composite_array'] = $selected_already_plates_composite_array;
                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/purchased_plate_section', $data, true);
            }
        }
        return $theHTMLResponse;
    }


    function purchased_plate_history()
    {

        $json_data = array('response' => 'no', 'message' => 'No Plate Found');
        $user_id = $this->input->post('user_id');
        $selected_already_plates = $this->input->post('selected_already_plates');
        $selected_already_plates_composite_array = $this->input->post('selected_already_plates_composite_array');
        $selected_already_plates = array_unique($selected_already_plates);

        /*echo "<pre>";
        echo $user_id."<br>-------------";
        print_r($selected_already_plates);
        echo "<br>-------------------";
        print_r($selected_already_plates_composite_array);
        echo "</pre>";
        die();*/

        //print_r($user_id); exit;
        if (!empty($user_id)) {

//            sleep(2);

            $purchased_plate_history  = $this->home_model->get_db_column('customers', 'purchased_plate_history', 'UserID', $user_id);
            $purchased_plate_history = json_decode($purchased_plate_history);
            if (isset($purchased_plate_history) && !empty($purchased_plate_history)) {
                $data['purchased_plate_history'] = $purchased_plate_history;
//                contains just plate_id of purchased plate history section
                $data['selected_already_plates'] = $selected_already_plates;
//                used to check already purchased plates with plate_id and also match order number
                $data['selected_already_plates_composite_array'] = $selected_already_plates_composite_array;
//                echo"<pre>";print_r($selected_already_plates_composite_array);
//                foreach ( $selected_already_plates_composite_array as $key => $selected_already_plate) {
//                    print_r(json_decode($selected_already_plate));
//                }

                /*echo "<pre>";
                echo $user_id."<br>-------------";
                print_r($data);
                echo "</pre>";
                die();*/

                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/purchased_plate_section', $data, true);


//                if ($type == 'roll') {
//                    $data['details']['ManufactureID'] = $this->home_model->get_db_column('products', 'ManufactureID', 'ProductID', $productid);
//                    $theHTMLResponse = $this->load->view('print_service/upload/roll_artwork_files', $data, true);
//                } else {
//                    $theHTMLResponse = $this->load->view('print_service/upload/a4_artwork_files', $data, true);
//                }

                $json_data = array('response' => 'yes',
                    'content' => $theHTMLResponse,
                );
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }




    /************* Printed Roll Labels 10% Discount Offer**************/
    function get_printedroll_vouvher_auth()
    {

        $voucher = $this->input->post('voucher', true);
        $GrandTotal = $this->input->post('GrandTotal', true);
        $voucher = strtolower(trim($voucher));
        $printedroll_offer = $this->shopping_model->check_printedroll_offer_voucher();

        if ($printedroll_offer == true and $voucher == 'print10') {

            $amount = $this->shopping_model->calculate_total_printedroll_amount();
            $discout_perct = number_format(10 / 100, 2, '.', '');
            $DisountOff = $amount * $discout_perct;


            $date = time();
            $session_id = $this->session->userdata('session_id');
            $GrandTotal = number_format($GrandTotal, 2, '.', '');


            $items_array = array('SessionID' => $session_id,
                'DateLogged' => $date,
                'discount_offer' => $DisountOff,
                'grandtotal' => $GrandTotal,
                'vc_type' => 'printedroll'
            );
            $this->db->insert('voucherofferd_temp', $items_array);


            $cart_data = $this->ajax_cart_load();
            $topcart_data = $this->ajax_topcart_load();
            $delivery_html = $this->ajax_delivery_content();
            $order_review_summary = $this->ajax_review_summary();

            $json_data = array('is_error' => 'no',
                'cart_data' => $cart_data,
                'top_cart' => $topcart_data,
                'delivey' => $delivery_html,
                'orderSummary' => $order_review_summary);
            $this->output->set_output(json_encode($json_data));

        } else {
            $data = array('is_error' => 'Yes');
            echo json_encode($data);
        }

    }

    function remove_printedroll_voucher_offer()
    {
        $session_id = $this->session->userdata('session_id');

        $qry = $this->db->delete('voucherofferd_temp', array('SessionID' => $session_id, 'vc_type' => 'printedroll'));

        if ($qry) {

            $cart_data = $this->ajax_cart_load();
            $topcart_data = $this->ajax_topcart_load();
            $delivery_html = $this->ajax_delivery_content();
            $order_review_summary = $this->ajax_review_summary();

            $json_data = array('is_error' => 'no',
                'cart_data' => $cart_data,
                'top_cart' => $topcart_data,
                'delivey' => $delivery_html,
                'orderSummary' => $order_review_summary);
            $this->output->set_output(json_encode($json_data));

        }
    }


    function subscribe_newsletter(){

        $msg = 'error'; $url ='';
        $email = $this->input->post('email', true);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        if($this->form_validation->run() == true){
            $msg = $this->home_model->newsletter($email);
            if(isset($msg) and $msg!=''){
                $msg = 'sucess';
            }
        }
        echo json_encode(array('response'=>$msg));
    }

    /*----------------------------
   NEW FUNCTION BY Jawad
   -------------------------------*/

    function add_to_cart_reorder()
    {
        $A4Printing = array();
        $serial = $this->input->post('serial');
        $menuid = $this->input->post('menuid');
        $orderNum = $this->input->post('orderNum');
        $product_info = $this->user_model->get_order_product_record_by_serial($serial);
        //echo"<pre>";print_r($product_info);echo"</pre>";exit;
        $product_info = $product_info[0];
        $source = 'printing';
        $details = $this->user_model->get_product_details($product_info->ProductID);
        $ProductBrand = $this->ProductBrand($menuid);

        $sheets = $product_info->Quantity;
        $labeltype = $product_info->Print_Type;
        $print_qty = $product_info->Print_Qty;

        $pressproof = $product_info->pressproof;
        $finish_type = $product_info->FinishType;
        $qty = $sheets;

        $design = $this->get_number_design_reorder($orderNum, $product_info->ProductID);

        if($print_qty > $design) {
            $design = $print_qty;
        }

        if(preg_match("/Integrated/i",$details['ProductBrand'])) //INTEGRATED SHEETS
        {
            $type = "sheet";
            $LabelsPerSheet = $details['LabelsPerSheet'];
            $labels = $qty*$details['LabelsPerSheet'];
            $int_price = $this->home_model->single_box_price($menuid,$qty);
            $plain_price = $int_price['PlainPrice'];

            $total = $plain_price;
            $designprice = 0.00;

            if ($product_info->Printing == "Y") {
                if ($labeltype == 'printed') {
                    $labeltype = 'Fullcolour';
                } else if ($labeltype == 'black') {
                    $labeltype = 'Mono';
                }
                $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $product_info->Print_Design, $details['ProductBrand'], $menuid);

                $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $printprice = $printprice['price'];

                $print_price = $printprice + $designprice;

                $Print_Design = '1 Design';
                if ($design > 1) {
                    $Print_Design = 'Multiple Designs';
                }


                if (preg_match("/A3 Label/is", $details['ProductBrand']) || preg_match("/SRA3 Label/is", $details['ProductBrand'])) {
                    $print_price = $printprice * 1.5;
                    $print_unit = $printprice / $print_qty;
                } else {
                    $print_price = $printprice;
                    $print_unit = $print_price / $print_qty;
                }
            }

            $unit_price = $total/$qty;

            $A4Printing = array( 'Printing'=>'Y',
                'Print_Type'=>$labeltype,
                'Print_Design'=>$Print_Design,
                'Free'=>$free_artworks,
                'Print_Qty'=>$design,
                'Print_UnitPrice'=>$print_unit,
                'Print_Total'=>$print_price);
        } else {
            if(preg_match("/Roll Labels/i",$details['ProductBrand'])) //ROLLS
            {
                $type = "roll";
                $persheet = $product_info->LabelsPerRoll;
                $labels = $sheets*$persheet;
                $orientation = $product_info->Orientation;

                if(isset($product_info->Printing) == "Y"){
                    $sql = $this->home_model->get_sum_of_designed_artworks($orderNum, $product_info->ProductID);
                    $labels = $sql['labels'];
                    if($labels == 0) {
                        $labels = $sheets*$persheet;
                    }
                }

                $values_array = array('labeltype'=>$labeltype,
                    'labels'=>$labels,
                    'rolls'=>$sheets,
                    'design'=>$print_qty,
                    'menu'=>$menuid,
                    'persheets'=>$persheet,
                    'producttype'=>$type,
                    'pressproof'=>$pressproof,
                    'finish'=>$finish_type );
                $total = '';
                $new_prices = $this->price_calculator($values_array);
                //echo"<pre>";print_r($new_prices);echo"</pre>";exit;
                $print_price = $new_prices['printprice'];
                $print_unit = $print_price / $print_qty;

                $Print_Design = '1 Design';
                $total = $new_prices['price'];
                if($design > 1){
                    $Print_Design = 'Multiple Designs';
                }
                $A4Printing = array('Printing'=>'Y',
                    'Print_Type'=>$labeltype,
                    'Print_Design'=>$Print_Design,
                    'Print_Qty'=>$design,
                    'Print_UnitPrice'=>$print_price,
                    'Print_Total'=>$print_unit,
                    'source'=>$source,
                    'FinishType' => $finish_type,
                    'orientation' => $orientation

                );
            } else // SHEEEETS
            {
                $type = "sheet";
                $persheet = $details['LabelsPerSheet'];
                $labels = $sheets * $persheet;

                $wpep_discount = 0.00;
                $data = $this->product_model->ajax_price($qty, $menuid, $ProductBrand);
                $total = $data['custom_price'];

                /*if(preg_match("/A4 Labels/i",$ProductBrand) and (preg_match("/WPEP/i",$menuid))){
					$data['custom_price'] = ($data['custom_price']*1.2);
					$wpep_discount = (($data['custom_price'])*(20/100));
					$total = $data['custom_price']-$wpep_discount;
					$total = $total/1.2;
				}*/

                if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menuid);
                    //For A5 Sheet Discount
                    if (preg_match("/A5 Labels/is", $ProductBrand)) {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A5');
                    } else {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
                    }


                    if ($material_discount) {
                        $data['custom_price'] = ($data['custom_price'] * 1.2);
                        $wpep_discount = (($data['custom_price']) * ($material_discount / 100));
                        $total = $data['custom_price'] - $wpep_discount;
                        $total = $total / 1.2;
                    }
                }

                if ($product_info->Printing == "Y") {

                    $printtype = $this->home_model->get_db_column('digital_printing_process', 'Print_Type', 'name', $labeltype);
                    if (empty($printtype)) {
                        $printtype = $labeltype;
                    }
                    $designprice = 0.00;
                    $printprice = $this->home_model->calculate_printed_sheets($qty, $printtype, $design, $ProductBrand, $menuid);
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];

                    if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
                        $printprice = $printprice * 1.5;
                    }
                    $printprice = $printprice + $designprice;

                    $Print_Design = '1 Design';

                    if ($design > 1) {
                        $Print_Design = 'Multiple Designs';
                    }

                    $A4Printing = array('Printing' => 'Y',
                        'Print_Type' => $labeltype,
                        'Print_Design' => $Print_Design,
                        'Free' => $free_artworks,
                        'Print_Qty' => $design,
                        'Print_UnitPrice' => $printprice,
                        'Print_Total' => $printprice,
                        'source' => $source);
                }
                //echo"<pre>";print_r($A4Printing);echo"</pre>";exit;
            }
            $unit_price = $total / $qty;
        }

        $SID = $this->shopping_model->sessionid();
        $items = array('SessionID' => $SID,
            'ProductID' => $product_info->ProductID,
            'OrderTime' => 'NOW()',
            'Quantity' => $sheets,
            'orignalQty' => $labels,
            'UnitPrice' => $unit_price,
            'TotalPrice' => $total,
            'wound' => ($product_info->Wound ? $product_info->Wound : 'N'),
            'OrderData' => '',
            'LabelsPerRoll' => ($product_info->LabelsPerRoll ? $product_info->LabelsPerRoll : '0'),
            'is_custom' => ($product_info->is_custom ? $product_info->is_custom : '0'),
            'colorcode' => ($product_info->colorcode ? $product_info->colorcode : '0'),
            'page_location' => 'User Reorder',
        );

        $items = array_merge($items, $A4Printing);
        //echo"<pre>";print_r($items);echo"</pre>";exit;
        $this->db->insert('temporaryshoppingbasket', $items);
        $cartID = $this->db->insert_id();

        if ($cartID) {
            if (isset($product_info->Printing) == "Y") {
                $sql = $this->db->query("select * from order_attachments_integrated where Serial = $serial")->result_array();
                foreach ($sql as $sq) {
                    $array = array('SessionID' => $this->session->userdata('session_id'),
                        'ProductID' => $sq['ProductID'],
                        'file' => $sq['file'],
                        'Thumb' => $sq['Thumb'],
                        'labels' => $sq['labels'],
                        'qty' => $sq['qty'],
                        'source' => 'web',
                        'type' => 'new',
                        'CartID' => $cartID,
                        'status' => 'confirm'
                    );
                    $this->db->insert('integrated_attachments', $array);
                }
            }
        }

        $topcart_data = $this->ajax_topcart_load();
        echo json_encode(array('response' => 'yes', 'top_cart' => $topcart_data));
    }

    function get_number_design_reorder($orderNum, $productid){
        $SID  =  $this->shopping_model->sessionid();
        $query = $this->db->query("select count(*) as total from order_attachments_integrated WHERE ProductID='$productid' AND OrderNumber = '$orderNum' AND labels > 0");
        //die($this->db->last_query());
        $row = $query->row_array();
        if(isset($row['total']) and $row['total'] ) return $row['total'];

        else return 0;
    }
    public function printOrder($orderID)
    {
        $this->load->model('accountModel');
        $data['OrderDetails'] = $this->accountModel->OrderDetails($orderID);
        $data['OrderInfo'] = $this->accountModel->OrderInfo($orderID);


        $this->load->library('pdf');
        $this->pdf->load_view('user/printInvoice_order', $data);

        //echo"<pre>";print_r($data);echo"</pre>";exit;
        $this->pdf->render();
        $output	= $this->pdf->output();
        $file_location = "pdf/orderInvoice".$orderID.".pdf";
        $filename = $file_location;
        $fp = fopen($filename, "a");
        file_put_contents($file_location, $output);
        $this->pdf->stream("Order No : " . $orderID . ".pdf");
    }


    /**************** Grouping Materials ***********************/
    function grouped_product_info(){

        $min_labels_per_roll = 0;$max_labels = 0;$sheet_image = '';$roll_image = '';$thumbnail_path='';
        $productid = $this->input->post('productid', true);
        $categoryid = $this->input->post('catid', true);
        $colour = $this->input->post('colour', true);
        $finish = $this->input->post('finish', true);
        $material = $this->input->post('material', true);
        $adhesive = $this->input->post('adhesive', true);
        $type = $this->input->post('type', true);

        $Lwidth = $this->input->post('width', true);
        $Lheight = $this->input->post('height', true);

        $condition = " Activate='Y' AND LabelFinish LIKE '".$finish."' AND ColourMaterial LIKE '".$material."' 
				AND LabelColor LIKE '".$colour."' AND CategoryID LIKE '".$categoryid."'";



        $adh_list=$this->db->query("SELECT Adhesive FROM `products` WHERE $condition 
				GROUP BY Adhesive order by ProductID asc ")->result_array();

        if(count($adh_list)  >  0){
            $prdexist = $this->db->query("Select count(*) as total from products where $condition 
					AND Adhesive LIKE '".$adhesive."'" )->row_array();
            if($prdexist['total'] == 0){
                $adhesive = $adh_list[0]['Adhesive'];
            }
        }

        $cryogenic =$this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Cryogenic');
        $freezer =$this->home_model->search_adhesive_in_array($adh_list,   'Adhesive', 'Freezer');
        $heatrest =$this->home_model->search_adhesive_in_array($adh_list,  'Adhesive', 'Heat Resistant');
        $hightack =$this->home_model->search_adhesive_in_array($adh_list,  'Adhesive', 'High Tack');
        $permanent =$this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Permanent');
        $removable =$this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Peelable');
        $sealable =$this->home_model->search_adhesive_in_array($adh_list,  'Adhesive', 'Resealable');
        $superperm =$this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Super Permanent');
        $waterres =$this->home_model->search_adhesive_in_array($adh_list,  'Adhesive', 'Water Resistant');


        $cryogenic_sel = ($adhesive=='Cryogenic')?'selected="selected"':'';
        $freezer_sel   = ($adhesive=='Freezer')?'selected="selected"':'';
        $heatrest_sel  = ($adhesive=='Heat Resistant')?'selected="selected"':'';
        $hightack_sel  = ($adhesive=='High Tack')?'selected="selected"':'';
        $permanent_sel = ($adhesive=='Permanent')?'selected="selected"':'';
        $removable_sel = ($adhesive=='Peelable')?'selected="selected"':'';
        $sealable_sel  = ($adhesive=='Resealable')?'selected="selected"':'';
        $superperm_sel = ($adhesive=='Super Permanent')?'selected="selected"':'';
        $waterres_sel  = ($adhesive=='Water Resistant')?'selected="selected"':'';

        $adhesive_option  = "<option value='' disabled='disabled' selected='selected'>Select Adhesive </option>";
        $adhesive_option .="<option $cryogenic $cryogenic_sel value='Cryogenic'>Cryogenic</option>";
        $adhesive_option.="<option  $freezer   $freezer_sel	 value='Freezer'>Freezer</option>";
        $adhesive_option.="<option  $heatrest  $heatrest_sel  value='Heat Resistant'>Heat Resistant</option>";
        $adhesive_option.="<option  $hightack  $hightack_sel  value='High Tack'>High Tack</option>";
        $adhesive_option.="<option  $permanent $permanent_sel value='Permanent'>Permanent</option>";
        $adhesive_option.="<option  $removable $removable_sel value='Peelable'>Peelable</option>";
        $adhesive_option.="<option  $sealable  $sealable_sel  value='Resealable'>Re-sealable</option>";
        $adhesive_option.="<option  $superperm $superperm_sel value='Super Permanent'>Super Permanent</option>";
        $adhesive_option.="<option  $waterres  $waterres_sel  value='Water Resistant'>Water Resistant</option>";


        $condition .= " AND Adhesive LIKE '".$adhesive."'";


        $result = $this->db->query("Select * from products where $condition")->row_array();
        if(isset($result['ManufactureID']) and $result['ManufactureID']!=''){
            $result['Image1'] = str_replace(".gif",".png", $result['Image1']);
            if(preg_match("/Roll Labels/", $result['ProductBrand'])){
                $material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'],0,-1));
                if($result['Shape'] == "Rectangle")
                {
                    $l_group = $this->home_model->get_rectangle_group($Lwidth, $Lheight);
                    $image_path = Assets.'images/material_images/Roll/rectangle/'.$l_group.'/'.$material_code.'.png';
                }
                else
                {
                    $image_path = Assets.'images/material_images/Roll/'.strtolower($result['Shape'])."/".$material_code.'.png';
                }

                $thumbnail_path = $image_path;
                $img_found = "yes";
                $core = substr($categoryid,-1);
                $wound = strtolower($this->session->userdata('wound'));

                if($wound == "")
                {
                    $wound = "outside";
                }

                $roll_image = ARTPATH."images/categoryimages/RollLabels/outside/".$result['ManufactureID'].".jpg";
                if(isset($wound) and $wound == "inside")
                {
                    $wound = 'inside';
                    $roll_image = ARTPATH."images/categoryimages/RollLabels/inside/".$result['ManufactureID'].".jpg";
                }
                if(getimagesize($roll_image)!=""){

                    $catID = substr($result['CategoryID'],0,-2);
                    $cat_details = $this->home_model->fetch_category_details($catID);
                    $code = explode('.',$cat_details['CategoryImage']);

                    //print_r($code);
                    $roll_image = Assets."images/categoryimages/RollLabels/".$wound."/".$result['ManufactureID'].".jpg";
                    $img_found = "no";
                }
                $compatibily_type = 'roll';
            }
            else{
                $material_code = $this->home_model->getmaterialcode($result['ManufactureID']);
                $thumbnail_path = Assets.'images/material_images/sheets/'.$material_code.'.png';

                if(preg_match("/A4/",$result['ProductBrand'])){
                    $sheet_path = "A4Sheets";
                }

                else if(preg_match("/SRA3/",$result['ProductBrand'])){
                    $sheet_path = "SRA3Sheets";
                }

                else if(preg_match("/A3/",$result['ProductBrand'])){
                    $sheet_path = "A3Sheets";
                }
                $sheet_image = Assets."images/categoryimages/".$sheet_path."/colours/".$result['ManufactureID'].".png";
                if(!getimagesize($sheet_image))
                {
                    $cat_details = $this->home_model->fetch_category_details($result['CategoryID']);
                    $sheet_image = Assets."images/categoryimages/".$sheet_path."/".$cat_details['CategoryImage'];
                }
                $compatibily_type = 'sheet';
            }
            $result['Material1'] = $this->home_model->get_db_column('material_tooltip_info','short_name', 'material_code',$material_code);
            $desc = $this->home_model->get_db_column('material_tooltip_info','tooltip_info', 'material_code',$material_code);

            $material_url = strtolower(str_replace(" ","-", trim($result['Material1'])));
            $type_url = 'material-on-sheets';

            $max_length = 200;
            if (strlen($desc) > $max_length){
                $offset = ($max_length - 3) - strlen($desc);
                $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
                $short_desc .= ' <a style="cursor:pointer;" data-toggle="tooltip-product" data-placement="top" data-original-title="'.$desc.'"><i>Read More</i></a>';
            }else{
                $short_desc = $desc;
            }

            $promotion = '';
            /*if (preg_match("/A4 Labels/is", $result['ProductBrand']) and ( preg_match("/WPEP/i", $result['ManufactureID']))) {
                  $promotion =' <br /> <strong style="color:#fd4913"> Special Offer Save 20% While Stocks Last </strong> ';
            } */

            if (preg_match("/A4 Labels/is", $result['ProductBrand']))
            {
                $promotional_discount = '';
                $mat_code = $this->home_model->getmaterialcode($result['ManufactureID']);
                $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
                if($material_discount)
                {
                    $promotional_discount = ' <br /> <strong style="color:#fd4913"> Special Offer Save '.$material_discount.'% While Stocks Last </strong> ';
                }
            }


            if (preg_match("/Roll Labels/is", $result['ProductBrand'])){
                $material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'],0,-1));
                $material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
                if($material_discount){
                    $promotional_discount = ' <br /> <strong style="color:#fd4913"> Special Offer Save '.$material_discount.'% While Stocks Last </strong> ';
                }
            }


            if (preg_match("/Roll Labels/is", $result['ProductBrand']) and (preg_match("/PEOP/i", $result['ManufactureID']) || preg_match("/PEWP/i", $result['ManufactureID'])))
            {
                $promotional_discount = ' <br /> <strong style="color:#fd4913">NEW MATERIAL</strong> replacing PETP on rolls, please request a sample if you have ordered previously. ';
            }



            $short_desc = $short_desc.' '.$promotion.' '.@$promotional_discount;

            if(preg_match("/A3/",$result['ProductBrand'])){
                $min_qty = '100';
                $max_qty = '50000';
            }
            else if(preg_match("/Roll Labels/",$result['ProductBrand'])){
                $new_material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'],0,-1));
                $type_url = 'material-on-rolls';


                $maxdiamter = $this->input->post('maxdiamter');
                $Labelsgap = $this->input->post('Labelsgap');
                $height = $this->input->post('height');
                if(isset($maxdiamter) and $maxdiamter!=0 ){
                    $total_labels = $this->home_model->get_max_labels_printer($result['ManufactureID'],$result['LabelsPerSheet'], $maxdiamter, $Labelsgap, $height);
                    if(isset($total_labels) and $total_labels!=0 and $total_labels <= $result['LabelsPerSheet']){
                        $result['LabelsPerSheet'] = $total_labels;
                    }
                }

                $min_qty = $this->home_model->min_qty_roll($result['ManufactureID']);
                $max_qty = $this->home_model->max_qty_roll($result['ManufactureID']);

                $min_labels_per_roll = $this->home_model->min_labels_per_roll($min_qty);
                $max_labels = $this->home_model->max_total_labels_on_rolls($result['LabelsPerSheet']);

            }
            else if(preg_match("/SRA3/",$result['ProductBrand'])){
                $min_qty = '100';
                $max_qty = '20000';
            }
            else{
                if(preg_match("/PETC/",$result['ManufactureID']) || preg_match("/PETH/",$result['ManufactureID']) || preg_match("/PVUD/",$result['ManufactureID'])){
                    //$min_qty = '25';
                    $min_qty = '5';
                    $max_qty = '5000';
                }else{
                    $min_qty = '25';
                    $max_qty = '50000';
                }
            }

            $comp = $this->home_model->grouping_compatiblity($result['SpecText7'], $compatibily_type);

            $url = base_url().$type_url.'/'.$material_url.'/products/';
            $new_material_code = $this->home_model->getmaterialcode($result['ManufactureID']);
            if(preg_match("/Roll Labels/", $result['ProductBrand'])){
                $new_material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'],0,-1));
                if($img_found == "no")
                {
                    $new_material_code = "WTP";
                }
            }
            else
            {
                $new_material_code = $this->home_model->getmaterialcode($result['ManufactureID']);
            }
            echo json_encode(array('adhesive_option'=>$adhesive_option,
                'image_path'=>$image_path,
                'product_name'=>$result['Material1'],
                'product_description'=>$short_desc,
                'product_id'=>$result['ProductID'],
                'manfactureid'=>$result['ManufactureID'],
                'material_code'=>$new_material_code,
                'material_code_new'=>$material_code,
                'Printable'=>$result['Printable'],
                //'Printable'=>'N',
                'minimum'=>$min_qty,
                'maximum'=>$max_qty,
                'minprintedlabels'=>$min_labels_per_roll,
                'max_labels'=>$max_labels,

                'laser_img'=>Assets.'images/'.$comp['laser_img'],
                'inkjet_img'=>Assets.'images/'.$comp['inkjet_img'],
                'thermal_img'=>Assets.'images/'.$comp['thermal_img'],
                'd_thermal_img'=>Assets.'images/'.$comp['d_thermal_img'],

                'laser_text'=>$comp['laser_text'],
                'inkjet_text'=>$comp['inkjet_text'],
                'thermal_text'=>$comp['thermal_text'],
                'd_thermal_text'=>$comp['d_thermal_text'],

                'filter_color'=>$result['LabelColor_upd'],
                'filter_finish'=>$result['LabelFinish_upd'],
                'filter_material'=>$result['ColourMaterial_upd'],
                'url'=>$url,
                'sheet_image' => $sheet_image,
                'roll_image' => $roll_image,
                'thumbnail_path'=>$thumbnail_path,
                'category_description'=>$result['ProductCategoryName'],
                'EuroID' => $result['EuroID'],
            ));
        }
        else{
            echo json_encode(array('response'=>'notfound'));
        }
    }
    function view_artworks_content(){

        $rolls = 0;
        $manfactureid = $this->input->post('manfactureid');
        $product_id = $this->input->post('product_id');
        $labelspersheet = $this->input->post('labelspersheet');
        $print_type = $this->input->post('print_type');
        $initial_cartID = $cartid = $this->input->post('cart_id');
        $cartid = (isset($cartid) and $cartid!='')?$cartid:time().$product_id;
        $data['cartid'] = $cartid;
        $data['unitqty'] = $this->input->post('unitqty');
        $type = $this->input->post('type');
        $data['ProductID'] = $product_id;
        $data['type'] = $type;
        $data['LabelsPerSheet'] = $labelspersheet;
        $data['ManufactureID'] = $manfactureid;

        $page = $this->input->post('page');
        if(isset($page) and $page == "reorder")
        {
            $actual_productID = $this->input->post('actual_productid');
            if(!$initial_cartID)
            {
                $sql = $this->db->query("select * from order_attachments_integrated where Serial = $product_id")->result_array();
                $qty = 0;
                foreach($sql as $sq)
                {
                    $array = array('SessionID'=>$this->session->userdata('session_id').'-PRJB',
                        'ProductID'=>$sq['ProductID'],
                        'file'=>$sq['file'],
                        'name'=>$sq['name'],
                        'Thumb'=>$sq['Thumb'],
                        'labels'=>$sq['labels'],
                        'qty'=>$sq['qty'],
                        'source'=>'printing',
                        'type'=>'new',
                        'CartID' => $cartid,
                        'status' => 'confirm'
                    );

                    $this->db->insert('integrated_attachments',$array);
                    $qty += $sq['qty'];
                }
            }
            if(!$qty)
            {
                $qty = $this->input->post('qty');
            }
            $product_id = $actual_productID;
            $data['ProductID'] = $product_id;

            if($type == "sheets")
            {
                $total_price = '';
                $url = base_url().'ajax/calculate_sheet_price';
                $ch = curl_init($url);
                $price_data = array(
                    'menuid'=>$manfactureid,
                    'qty'=> $qty,
                    'prd_id'=> $actual_productID,
                    'labels'=> $labelspersheet,
                    'labeltype'=> $print_type,
                    'cart_id'=> $cartid,
                );
                //echo"<Pre>";print_r($price_data);echo"</pre>";
                $payload = json_encode($price_data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $total_price = curl_exec($ch);
                //echo"<Pre>";print_r($total_price);echo"</pre>";exit;
                curl_close($ch);
            }
            else
            {

            }
        }

        $designs = $this->get_uploaded_number_design($cartid, $product_id);
        //die($this->db->last_query());
        $response = $this->home_model->get_total_uploaded_qty($cartid, $product_id);
        //die($this->db->last_query());
        if($type == 'rolls'){
            $data['presproof'] = $this->input->post('presproof');
            $data['gap'] = $this->input->post('gap');
            $data['size'] = $this->input->post('size');
            $total = $response['labels'];
            $rolls = $response['sheets'];
        }else{
            if($data['unitqty'] == 'Labels'){
                $total = $response['labels'];}
            else{
                $total = $response['sheets'];
            }
        }
        $theHTMLResponse = $this->load->view('material/upload/upload_artwork_files', $data, true);
        echo json_encode(array('html'=>$theHTMLResponse,
            'cartid'=>$cartid,
            'qty'=>$total,
            'rolls'=>$rolls,
            'designs'=>$designs,
            'total_price'=>$total_price));
    }


    function upload_material_artworks(){
        $rolls = 0;
        $json_data = array('response'=>'no', 'message' =>'failed to upload this file, please try again');

        if (!empty($_FILES)) {
            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $artworkname = $this->input->post('artworkname');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');

            //echo"<pre>";print_r($_POST);echo"</pre>";exit;
            $data['cartid'] = $cartid;
            $data['ProductID'] = $productid;
            $data['LabelsPerSheet'] = $persheet;
            $data['type'] = $type;


            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $response = $this->home_model->upload_images('file','/');
            //echo"<pre>";print_r($response);echo"</pre>";exit;
            if($response!='error'){

                $sid = $this->session->userdata('session_id').'-PRJB';
                $artowrk = array('SessionID'=>$sid,
                    'ProductID'=>$productid,
                    'CartID'=>$cartid,
                    'name'=>$artworkname,
                    'labels'=>$labels,
                    'qty'=>$sheets,
                    'file'=>$response,
                    'status'=>'confirm');

                $this->db->insert('integrated_attachments',$artowrk);

                $response = $this->home_model->get_total_uploaded_qty($cartid, $productid);
                $designs = $this->get_uploaded_number_design($cartid, $productid);

                if($type == 'rolls'){
                    $data['presproof'] =  $this->input->post('presproof');
                    $data['gap'] = $this->input->post('gap');
                    $data['size'] = $this->input->post('size');
                    $theHTMLResponse = $this->load->view('material/upload/roll_artwork_files', $data, true);
                    $total = $response['labels'];
                    $rolls = $response['sheets'];
                }else{

                    $data['unitqty'] = $this->input->post('unitqty');
                    if($data['unitqty'] == 'Labels'){
                        $total = $response['labels'];}
                    else{
                        $total = $response['sheets'];
                    }
                    $theHTMLResponse = $this->load->view('material/upload/a4_artwork_files', $data, true);
                }


                $json_data = array('response'=>'yes',
                    'qty'=>$total,
                    'rolls'=>$rolls,
                    'designs'=>$designs,
                    'content'=>$theHTMLResponse);
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }
    function update_artwork_details($artwork_id){
        if(isset($artwork_id) and $artwork_id!=''){
            $this->load->library('upload');
            $q = $this->upload->get_file_path($artwork_id);
            $result = $this->db->query($q)->result();
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        }
    }

    function delete_material_artworks(){
        $rolls = 0;
        $json_data = array('response'=>'no');
        if ($_POST) {

            $id = $this->input->post('fileid');

            $file = $this->home_model->get_db_column('integrated_attachments', 'file', 'ID', $id);
            @unlink(PATH.'/'.$file);

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');


            $data['cartid'] = $cartid;
            $data['ProductID'] = $productid;
            $data['LabelsPerSheet'] = $persheet;
            $data['type'] = $type;

            $this->db->delete('integrated_attachments', array('ID'=>$id));

            $response = $this->home_model->get_total_uploaded_qty($cartid, $productid);
            $designs = $this->get_uploaded_number_design($cartid, $productid);

            if($type == 'rolls'){
                $data['presproof'] =  $this->input->post('presproof');
                $data['gap'] = $this->input->post('gap');
                $data['size'] = $this->input->post('size');
                $theHTMLResponse = $this->load->view('material/upload/roll_artwork_files', $data, true);
                $total = $response['labels'];
                $rolls = $response['sheets'];


            }else{

                $data['unitqty'] = $this->input->post('unitqty');
                if($data['unitqty'] == 'Labels'){
                    $total = $response['labels'];}
                else{
                    $total = $response['sheets'];
                }
                $theHTMLResponse = $this->load->view('material/upload/a4_artwork_files', $data, true);
            }


            $json_data = array('response'=>'yes',
                'qty'=>$total,
                'rolls'=>$rolls,
                'designs'=>$designs,
                'content'=>$theHTMLResponse);


        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }

    function update_material_artworks(){
        $rolls = 0;
        $json_data = array('response'=>'no');
        if ($_POST) {

            $id = $this->input->post('id');
            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');


            $sid = $this->session->userdata('session_id').'-PRJB';
            $artowrk = array( 'labels'=>$labels,
                'qty'=>$sheets,
                'status'=>'confirm');
            $this->db->update('integrated_attachments',$artowrk, array('ID'=>$id));


            $data['cartid'] = $cartid;
            $data['ProductID'] = $productid;
            $data['LabelsPerSheet'] = $persheet;
            $data['type'] = $type;


            $response = $this->home_model->get_total_uploaded_qty($cartid, $productid);
            $designs = $this->get_uploaded_number_design($cartid, $productid);

            if($type == 'rolls'){
                $data['presproof'] =  $this->input->post('presproof');
                $data['gap'] = $this->input->post('gap');
                $data['size'] = $this->input->post('size');
                $theHTMLResponse = $this->load->view('material/upload/roll_artwork_files', $data, true);
                $total = $response['labels'];
                $rolls = $response['sheets'];



            }else{

                $data['unitqty'] = $this->input->post('unitqty');
                if($data['unitqty'] == 'Labels'){
                    $total = $response['labels'];}
                else{
                    $total = $response['sheets'];
                }
                $theHTMLResponse = $this->load->view('material/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response'=>'yes',
                'qty'=>$total,
                'rolls'=>$rolls,
                'designs'=>$designs,
                'content'=>$theHTMLResponse);
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }
    function get_uploaded_number_design($cartid, $productid){
        $sid = $this->session->userdata('session_id').'-PRJB';
        $query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '".$sid."' AND
		 ProductID=$productid AND status LIKE 'confirm' AND  CartID LIKE '".$cartid."'");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total'] ) return $row['total'];
        else return 0;
    }



    function calculate_sheet_price()
    {
        if (!$_POST) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        if ($_POST) {

            $cart_id = $this->input->post('cart_id');
            $qty = $this->input->post('qty');
            $menu = $this->input->post('menuid');
            $labels = $this->input->post('labels');
            $labeltype = $this->input->post('labeltype');
            $productid = $this->input->post('prd_id');
            $requestfrom = $this->input->post('requestfrom');
            $printing = $this->input->post('printing');

            if (isset($cart_id) and $cart_id != '') {
                $design = $this->get_uploaded_number_design($cart_id, $productid);
            } else {
                $design = $this->get_number_design($productid);
            }

            $save_txt = '';
            $ProductBrand = $this->ProductBrand($menu);
//            echo $this->db->last_query();exit;
            if (isset($printing) and $printing == "Y" and $labeltype == "") {
                $labeltype = 'Fullcolour';
            }

            //if($ProductBrand=='Application Labels'){
            if (isset($qty) and $qty > 0) {
                $data = $this->product_model->ajax_price($qty, $menu, $ProductBrand);
                $data2 = $this->product_model->ajax_second_price($qty, $menu);
                $price = $data['custom_price'];

                $printprice = 0.00;
                $designprice = 0.00;
                $printoption = 'plain';
                $free_artworks = 1;

                if ($labeltype == 'Mono' || $labeltype == 'Fullcolour') {
                    $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
                    //echo"<pre>";print_r($printprice);echo"</pre>";exit;
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];
                    if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {
                        $printprice = $printprice * 1.5;
                    }
                    $printoption = 'printed';
                }

                if ($ProductBrand == 'Application Labels') {
                    //$total_labels =  $labels*$qty;
                    $data2['custom_price1'] = 0.00;
                }

                $price1 = $data2['custom_price1'];
                $delivery_txt = $this->shopping_model->delevery_txt();
                $percentage = $this->product_model->label_price_per($price1, $price);

                if (!$data2['custom_qty1'] == '' and $percentage > 0) {
                    $save_txt = ' Order ' . $data2['custom_qty1'] . ' sheets/' . $data2['custom_qty1'] * $labels . ' labels and Save ' . floor($percentage) . '%';
                }

                $plain_value = $price = $this->home_model->currecy_converter($price, 'yes');
                $printprice = $this->home_model->currecy_converter($printprice, 'yes');
                $designprice = $this->home_model->currecy_converter($designprice, 'yes');

                $onlyprintprice = $printprice;

                $plain = number_format($price, 2, '.', '');
                $original_price = $plain;
                $price = $designprice + $printprice + $price;
                $price = number_format($price, 2, '.', '');

                $wpep_discount_txt = '';
                $wpep_discount = "";
                $dis_img = '';
                /*if (preg_match("/A4 Labels/is", $ProductBrand) and ( preg_match("/WPEP/i", $menu))) {
								$wpep_discount = (($plain) * (20 / 100));
								$wpep_discount_txt = '<small class="discount_price">'.symbol.$price.' </small>';
								$price = number_format(($price - $wpep_discount),2,'.','');
								$dis_img = '<img src="'.Assets.'images/discount_20.png">';
				}*/


                if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);
                    //For A5 Sheet Discount
                    if (preg_match("/A5 Labels/is", $ProductBrand)) {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A5');
                    } else {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
                    }



                    if ($material_discount) {
                        $wpep_discount = (($plain) * ($material_discount / 100));
                        $wpep_discount = number_format($wpep_discount, 2, '.', '');
                        $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                        $price = number_format(($price - $wpep_discount), 2, '.', '');
                        if ($material_discount == 25) {
                            $dis_img = '<img src="' . Assets . 'images/discount_25.png">';
                        } else {
                            $dis_img = '<img src="' . Assets . 'images/discount_20.png">';
                        }
                    }
                }
                $total_labels = $labels * $qty;
                $perprice = round(($price / ($labels * $qty)), 3);

                $showlabels = $labels * $qty;

                if (isset($requestfrom) and $requestfrom == 'lba') {
                    $showlabels = $this->input->post('lba_qty');
                    $price = $this->home_model->get_lba_uplift_price($qty, $price, $perprice, $total_labels);
                    $perprice = round(($price / $showlabels), 3);
                    //$per_labels = $showlabels . ' Labels / '.$qty.' Sheets, '.symbol . $perprice . ' per label';
                    $per_labels = $showlabels . ' Labels<br>' . symbol . $perprice . '<br>Pence per label';
                } else {
                    $per_labels = $showlabels . ' Labels, ' . symbol . $perprice . ' per label';
                }

                //$price_txt = '<b class="color-orange"> ' .$wpep_discount_txt. symbol.$price.$dis_img.' </b> <br />'.vatoption.' VAT';
                $price_txt = '<b class="color-orange"> ' . symbol . $price . ' </b><br />' . vatoption . ' VAT';

                $promotion_price_txt = $wpep_discount;

                $printpricepost = $this->input->post('printprice'); //enabled
                if (isset($printpricepost) and $printpricepost == 'enabled') {
                    $printprice = $this->home_model->calculate_printed_sheets($qty, 'Fullcolour', 1, $ProductBrand, $menu);
                    $printprice = $printprice['price'];
                    if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
                        $printprice = $printprice * 1.5;
                    }

                    $printprice = $this->home_model->currecy_converter($printprice, 'yes');
                    $onlyprintprice = $printprice;
                    $printprice = $printprice + $price;
                    $printprice = number_format($printprice, 2, '.', '');
                }

                if ($printoption = 'printed') {
                    if ($material_discount) {
                        $wpep_discount = (($plain) * ($material_discount / 100));
                        $plain = number_format(($plain - $wpep_discount), 2, '.', '');
                    }
                }
                $response = array('response' => 'yes',
                    'price' => $price_txt,
                    'printprice' => number_format($printprice, 2),
                    'halfprintprice' => number_format($printprice * 2, 2),
                    'onlyprintprice' => number_format($onlyprintprice, 2),
                    'designprice' => $designprice,
                    'artworks' => $free_artworks,
                    'nodesing' => $design,
                    'plain' => $plain,
                    'type' => $printoption,
                    'save_txt' => $save_txt,
                    'delivery_txt' => $delivery_txt,
                    'labelprice' => $per_labels,
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'promotion_price_txt' => $promotion_price_txt,
                    'original_price' => $original_price,
                    'percentage_discount' => $material_discount,
                    'rawprice' => $price);
                echo json_encode($response);
                $status = $this->save_browsing_history('sheet');

            }
        }
    }


    //label embellishment start
    function calculate_sheet_price_printed()
    {
        if (!$_POST) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        if ($_POST) {
            $qty_for_per_label = 0;
            $cart_id = $this->input->post('cart_id');
            $qty = $this->input->post('qty');
            $min_qty_threshold = $this->input->post('min_qty_threshold');
            $menu = $this->input->post('menuid');
            $labels = $this->input->post('labels');
            $labeltype = $this->input->post('labeltype');
            $productid = $this->input->post('prd_id');
            $requestfrom = $this->input->post('requestfrom');
            $printing = $this->input->post('printing');

            if (isset($cart_id) and $cart_id != '') {
                $design = $this->get_uploaded_number_design($cart_id, $productid);
            } else {
                $design = $this->get_number_design($productid);
            }

            $save_txt = '';
            $ProductBrand = $this->ProductBrand($menu);
//            echo $this->db->last_query();exit;
            if (isset($printing) and $printing == "Y" and $labeltype == "") {
                $labeltype = 'Fullcolour';
            }

            //if($ProductBrand=='Application Labels'){
            if (isset($qty) and $qty > 0) {
                if ($qty < $min_qty_threshold) {
                    $qty_for_per_label = $qty;
                    $qty = $min_qty_threshold;
                } else {
                    $qty_for_per_label = $qty;

                }
                $data = $this->product_model->ajax_price($qty, $menu, $ProductBrand);
                $data2 = $this->product_model->ajax_second_price($qty, $menu);
                $price = $data['custom_price'];

                $printprice = 0.00;
                $designprice = 0.00;
                $printoption = 'plain';
                $free_artworks = 1;

                if ($labeltype == 'Mono' || $labeltype == 'Fullcolour') {
                    $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
                    //echo"<pre>";print_r($printprice);echo"</pre>";exit;
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];
                    if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {
                        $printprice = $printprice * 1.5;
                    }
                    $printoption = 'printed';
                }

                if ($ProductBrand == 'Application Labels') {
                    //$total_labels =  $labels*$qty;
                    $data2['custom_price1'] = 0.00;
                }

                $price1 = $data2['custom_price1'];
                $delivery_txt = $this->shopping_model->delevery_txt();
                $percentage = $this->product_model->label_price_per($price1, $price);

                if (!$data2['custom_qty1'] == '' and $percentage > 0) {
                    $save_txt = ' Order ' . $data2['custom_qty1'] . ' sheets/' . $data2['custom_qty1'] * $labels . ' labels and Save ' . floor($percentage) . '%';
                }

                $plain_value = $price = $this->home_model->currecy_converter($price, 'yes');
                $printprice = $this->home_model->currecy_converter($printprice, 'yes');
                $designprice = $this->home_model->currecy_converter($designprice, 'yes');

                $onlyprintprice = $printprice;

                $plain = number_format($price, 2, '.', '');
                $original_price = $plain;
                $price = $designprice + $printprice + $price;
                $price = number_format($price, 2, '.', '');

                $wpep_discount_txt = '';
                $wpep_discount = "";
                $dis_img = '';
                /*if (preg_match("/A4 Labels/is", $ProductBrand) and ( preg_match("/WPEP/i", $menu))) {
								$wpep_discount = (($plain) * (20 / 100));
								$wpep_discount_txt = '<small class="discount_price">'.symbol.$price.' </small>';
								$price = number_format(($price - $wpep_discount),2,'.','');
								$dis_img = '<img src="'.Assets.'images/discount_20.png">';
				}*/

                if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);
                    //For A5 Sheet Discount
                    if (preg_match("/A5 Labels/is", $ProductBrand)) {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A5');
                    } else {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
                    }


                    if ($material_discount) {
                        $wpep_discount = (($plain) * ($material_discount / 100));
                        $wpep_discount = number_format($wpep_discount, 2, '.', '');
                        $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                        $price = number_format(($price - $wpep_discount), 2, '.', '');
                        if ($material_discount == 25) {
                            $dis_img = '<img src="' . Assets . 'images/discount_25.png">';
                        } else {
                            $dis_img = '<img src="' . Assets . 'images/discount_20.png">';
                        }
                    }
                }
                $total_labels = $labels * $qty;
//                 $perprice = round(($price / ($labels * $qty)), 3);

                $showlabels = $labels * $qty_for_per_label;

//                if (isset($requestfrom) and $requestfrom == 'lba') {
//                    $showlabels = $this->input->post('lba_qty');
//                    $price = $this->home_model->get_lba_uplift_price($qty, $price, $perprice, $total_labels);
//                    $perprice = round(($price / $showlabels), 3);
//                    //$per_labels = $showlabels . ' Labels / '.$qty.' Sheets, '.symbol . $perprice . ' per label';
//                    $per_labels = $showlabels . ' Labels<br>' . symbol . $perprice . '<br>Pence per label';
//                } else {
//                    $per_labels = $showlabels . ' Labels, ' . symbol . $perprice . ' per label';
//                }

                //$price_txt = '<b class="color-orange"> ' .$wpep_discount_txt. symbol.$price.$dis_img.' </b> <br />'.vatoption.' VAT';
                $price_txt = '<b class="color-orange"> ' . symbol . $price . ' </b><br />' . vatoption . ' VAT';

                $promotion_price_txt = $wpep_discount;

                $printpricepost = $this->input->post('printprice'); //enabled
                if (isset($printpricepost) and $printpricepost == 'enabled') {
                    $printprice = $this->home_model->calculate_printed_sheets($qty, 'Fullcolour', 1, $ProductBrand, $menu);
                    $printprice = $printprice['price'];
                    if (preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
                        $printprice = $printprice * 1.5;
                    }

                    $printprice = $this->home_model->currecy_converter($printprice, 'yes');
                    $onlyprintprice = $printprice;
                    $printprice = $printprice + $price;
                    $printprice = number_format($printprice, 2, '.', '');
                }


                $perprice = round(($onlyprintprice / ($labels * $qty_for_per_label)), 3);

                if (isset($requestfrom) and $requestfrom == 'lba') {
                    $showlabels = $this->input->post('lba_qty');
                    $price = $this->home_model->get_lba_uplift_price($qty, $price, $perprice, $total_labels);
                    $perprice = round(($price / $showlabels), 3);
                    //$per_labels = $showlabels . ' Labels / '.$qty.' Sheets, '.symbol . $perprice . ' per label';
                    $per_labels = $showlabels . ' Labels<br>' . symbol . $perprice . '<br>Pence per label';
                } else {
                    $per_labels = $showlabels . ' Labels, ' . symbol . $perprice . ' per label';
                }


                if ($printoption = 'printed') {
                    if ($material_discount) {
                        $wpep_discount = (($plain) * ($material_discount / 100));
                        $plain = number_format(($plain - $wpep_discount), 2, '.', '');
                    }
                }
                $response = array('response' => 'yes',
                    'price' => $price_txt,
                    'printprice' => number_format($printprice, 2),
                    'halfprintprice' => number_format($printprice * 2, 2),
                    'onlyprintprice' => number_format($onlyprintprice, 2),
                    'designprice' => $designprice,
                    'artworks' => $free_artworks,
                    'nodesing' => $design,
                    'plain' => $plain,
                    'type' => $printoption,
                    'save_txt' => $save_txt,
                    'delivery_txt' => $delivery_txt,
                    'labelprice' => $per_labels,
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'promotion_price_txt' => $promotion_price_txt,
                    'original_price' => $original_price,
                    'percentage_discount' => $material_discount,
                    'rawprice' => $price);
                echo json_encode($response);
                $status = $this->save_browsing_history('sheet');

            }
        }
    }

    //label embellishment end



    function calculate_roll_price_printed()
    {
        if (!$_POST) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        if ($_POST) {
            $roll = $this->input->post('roll');
            $menu = $this->input->post('menuid');
            $prd_id = $this->input->post('prd_id');
            $labels = $this->input->post('labels');
            $diameter = $this->input->post('diameter');
            $printing = $this->input->post('printing');
            $printing_enabled = $this->input->post('printing_enabled');
            $requestfrom = $this->input->post('requestfrom');

            $minimum_roll_threshold = $this->home_model->min_qty_roll($menu);
            $minimum_label_per_roll_threshold = $this->home_model->min_labels_per_roll_printed($dieacross = NULL);
            $minimum_labels_threshold = $minimum_label_per_roll_threshold * $minimum_roll_threshold;

            $size = $this->input->post('size');
            $gap = $this->input->post('gap');

            $regmark = $this->input->post('regmark');

            $save_txt = '';
            $regmark_price = symbol . '0.00';

            if (isset($printing_enabled) and $printing_enabled == "Y" and $printing == "") {
                $printing = "Fullcolour";
            }


            if (isset($printing) and $printing != '') {
                $cartid = $this->input->post('cart_id');
                $diamter = $this->home_model->get_auto_diameter($menu, $labels, $gap, $size);
                $presproof = $this->input->post('presproof');

                $presproof = (isset($presproof) and $presproof == 1) ? 1 : 0;

                $presproof_charges = 0.00;
                if (isset($presproof) and $presproof == 1) {
                    $presproof_charges = 50.00;
                }

                $labelfinish = $this->input->post('labelfinish');
                $persheets = $this->input->post('max_labels');
                $values_array = array('labeltype' => $printing,
                    'labels' => $labels,
                    'design' => 1,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => 'Rolls',
                    'pressproof' => $presproof,
                    'finish' => $labelfinish);
                $response = $this->price_calculator($values_array);

                $promotiondiscount = $response['promotiondiscount'];
                $plainlabelsprice = $response['plainlabelsprice'];
                $label_finish = $response['label_finish'];

                $rec = $this->home_model->get_total_uploaded_qty($cartid, $prd_id);
                $uploaded_labels = $rec['labels'];
                $uploaded_rolls = $rec['sheets'];

                $additional_cost = 0.00;
                $additional_rolls = 0;
                if ($uploaded_rolls > $response['rolls']) {
                    $additional_rolls = $uploaded_rolls - $response['rolls'];
                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $additional_cost;
                }

                $presproof_charges = $this->home_model->currecy_converter($presproof_charges, 'yes');
                $presproof_charges = number_format($presproof_charges, 2, '.', '');

                $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                $additional_cost = number_format($additional_cost, 2, '.', '');

                $printprice = $this->home_model->currecy_converter($response['price'], 'yes');
                $printprice = number_format($printprice, 2, '.', '');


                $label_finish = $this->home_model->currecy_converter($label_finish, 'yes');
                $label_finish = number_format($label_finish, 2, '.', '');

                $plainlabelsprice = $this->home_model->currecy_converter($plainlabelsprice, 'yes');
                $plainlabelsprice = number_format($plainlabelsprice, 2, '.', '');

                $promotiondiscount = $this->home_model->currecy_converter($promotiondiscount, 'yes');
                $promotiondiscount = number_format($promotiondiscount, 2, '.', '');


                $price = $this->home_model->currecy_converter($response['price'] + $additional_cost, 'yes');
                $price = number_format($price, 2, '.', '');
                $price_txt = '<b class="color-orange"> ' . symbol . $price . ' </b> <br />' . vatoption . ' VAT';
                $per_labels = round(($price / $labels), 3);
                //$per_labels = $labels.'  Labels, '.symbol.$per_labels.' per label';

                if (isset($requestfrom) and $requestfrom == 'lba') {
                    $per_labels = $labels . '  Labels<br>' . symbol . $per_labels . '<br>Pence per label';
                } else {
                    $per_labels = $labels . '  Labels, ' . symbol . $per_labels . ' per label';
                }

                echo json_encode(array('response' => 'yes',
                    'price' => $price_txt,
                    'printprice' => ($printprice - $presproof_charges + $promotiondiscount),
                    'halfprintprice' => number_format($promotiondiscount, 2, '.', ''),
                    'onlyprintprice' => number_format($promotiondiscount * 2, 2, '.', ''),
                    'plainlabelsprice' => number_format($plainlabelsprice, 2, '.', ''),
                    'label_finish' => number_format($label_finish, 2, '.', ''),
                    'additional_cost' => $additional_cost,
                    'additional_rolls' => $additional_rolls,
                    'presproof_charges' => $presproof_charges,
                    'labelprice' => $per_labels,
                    'diameter' => $diamter,
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'rawprice' => $price));
            } else if (isset($labels) and $labels > 0) {
                $labels_per_roll_user_selected = 0;
                $roll_user_selected = 0;
                if ($labels < $minimum_label_per_roll_threshold) {
                    $labels_per_roll_user_selected = $labels;
                    $labels = $minimum_label_per_roll_threshold;
                    $roll_user_selected = $roll;
                    $roll = $minimum_roll_threshold;
                } else {
                    $roll_user_selected = $roll;
                    $labels_per_roll_user_selected = $labels;

                }
//                 echo "<br />";
//                 echo $roll;
//                 echo "<br />";
//                 echo $labels;
//                 echo "<br />";

                $latest_price = $this->home_model->calclateprice($menu, $roll, $labels);

                // echo "<pre>";
                // print_r($latest_price);
                // die();

                $delivery_txt = $this->shopping_model->delevery_txt();
                $price = $latest_price['final_price'];
                //$per_labels = $latest_price['perlabel'];
                //$perprice = $latest_price['unit_prcie'];

                $price = $this->home_model->currecy_converter($price, 'yes');
                $raw_plain = symbol . number_format($price, 2, '.', '');
                if (isset($regmark) and $regmark == "yes") {
                    /*$collection['labels'] 	  = $labels;
						$collection['manufature'] = $menu;
						$collection['finish']     = 'No Finish';
						$collection['rolls']      = $roll;
						$collection['labeltype'] = 'Monochrome - Black Only';
						$price_res = $this->home_model->calculate_printing_price($collection);
						$regmark_price = $price_res['promotiondiscount'];
						$price = $price + $regmark_price;
						$regmark_price = symbol.number_format($regmark_price,2,'.','');*/


                    $labelfinish = 'No Finish';
                    $persheets = $this->input->post('max_labels');
                    $values_array = array('labeltype' => 'Monochrome - Black Only',
                        'labels' => $labels * $roll,
                        'design' => 1,
                        'menu' => $menu,
                        'persheets' => $persheets,
                        'producttype' => 'Rolls',
                        'pressproof' => 0,
                        'finish' => $labelfinish);

                    $response = $this->price_calculator($values_array);
                    //echo"<pre>";print_r($response);echo"</pre>";exit;
                    $regmark_price = $this->home_model->currecy_converter($response['promotiondiscount'], 'yes');
                    $regmark_price = number_format($regmark_price, 2, '.', '');
                    //$price = $price + $regmark_price;
                    $price = $response['price'];
                    $price = $this->home_model->currecy_converter($price, 'yes');
                    $regmark_price = symbol . number_format($regmark_price, 2, '.', '');
                    $response['plainlabelsprice'] = $this->home_model->currecy_converter($response['plainlabelsprice'], 'yes');
                    $raw_plain = symbol . number_format($response['plainlabelsprice'], 2, '.', '');
                }
                $diamter = $this->home_model->get_auto_diameter($menu, $labels, $gap, $size);

                $wpep_discount_txt = '';
                $dis_img = '';
                $material_code = $this->home_model->getmaterialcode(substr($menu, 0, -1));
                $material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
                if ($material_discount) {
                    $wpep_discount = (($price) * ($material_discount / 100));
                    $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                    $price = number_format(($price - $wpep_discount), 2, '.', '');
                    $dis_img = '<img src="' . Assets . 'images/discount_' . $material_discount . '.png">';
                }

                $price_txt = '<b class="color-orange"> ' . $wpep_discount_txt . symbol . $price . $dis_img . ' </b> <br />' . vatoption . ' VAT';


                $onlyprintprice = 0;
                $printprice = '0.00';
                $printprice = $this->input->post('printprice'); //enabled
                if (isset($printprice) and $printprice == 'enabled') {
                    $persheets = $this->input->post('max_labels');

                    $totallabels = $roll * $labels;

                    if ($totallabels > 1000000) {
                        $totallabels = 1000000;
                    }

                    $values_array = array('labeltype' => '6 Colour Digital Process',
                        'labels' => $totallabels,
                        'design' => 1,
                        'menu' => $menu,
                        'persheets' => $persheets,
                        'producttype' => 'Rolls',
                        'pressproof' => 0,
                        'finish' => 'None',
                    );

                    $response = $this->price_calculator($values_array);

                    $printprice = $this->home_model->currecy_converter($response['price'], 'yes');
                    $printprice = number_format($printprice, 2, '.', '');

                    //	echo"<pre>";print_r($response);echo"</pre>";exit;
                }

                //$onlyprintprice = $printprice-$price;
                $onlyprintprice = $response['promotiondiscount'];

                $per_labels = round(($onlyprintprice / ($labels_per_roll_user_selected * $roll_user_selected)), 3);
                //$per_labels = $labels*$roll.'  Labels, '.symbol.$per_labels.' per label';
                if (isset($requestfrom) and $requestfrom == 'lba') {
                    $per_labels = $labels * $roll . '  Labels<br>' . symbol . $per_labels . '<br>Pence per label';
                } else {
                    $per_labels = $labels_per_roll_user_selected * $roll_user_selected . '  Labels, ' . symbol . $per_labels . ' per label';
                }

                echo json_encode(array('response' => 'yes',
                    'price' => $price_txt,
                    'delivery_txt' => $delivery_txt,
                    'labelprice' => $per_labels,
                    'diameter' => $diamter,
                    'printprice' => number_format($printprice, 2),
                    'onlyprintprice' => number_format($onlyprintprice, 2),
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'raw_plain' => $raw_plain,
                    'regmark_price' => $regmark_price));
            }

            $this->save_browsing_history('roll');
        }

    }


    //label embellishment start emb page price function
    function calculate_roll_price_printed_emb_page($data)
    {

        if ($data) {
            $presproof =$data['pressproof'];
            $roll = $data['roll'];
            $menu = $data['menu'];
            $prd_id = $data['prd_id'];
            $labels = $data['labels'];
//            $diameter = $data['diameter'];
            $printing = $data['printing'];
            $requestfrom = $data['requestfrom'];
            $labelfinish = $data['rollfinish'];
            $minimum_roll_threshold = $this->home_model->min_qty_roll($menu);
//             print_r($minimum_label_per_roll_threshold);die;
            $minimum_label_per_roll_threshold = $this->home_model->min_labels_per_roll_printed($dieacross = NULL);
            $minimum_labels_threshold = $minimum_label_per_roll_threshold * $minimum_roll_threshold;
            if ($labels < $minimum_labels_threshold) {
                $labels_per_roll_user_selected = $labels;
                $labels = $minimum_labels_threshold;

                $roll_user_selected = $roll;
                $roll = $minimum_roll_threshold;
            } else {
                $roll_user_selected = $roll;
                $labels_per_roll_user_selected = $labels;

            }
            $size = $this->input->post('size');
            $gap = $this->input->post('gap');

            $regmark = $this->input->post('regmark');

            $save_txt = '';
            $regmark_price = symbol . '0.00';


            if (isset($printing) and $printing != '') {
                $cartid = $this->input->post('cart_id');
                $diamter = $this->home_model->get_auto_diameter($menu, $labels, $gap, $size);


                $presproof = (isset($presproof) and $presproof == 1) ? 1 : 0;

                $presproof_charges = 0.00;
                if (isset($presproof) and $presproof == 1) {
                    $presproof_charges = 50.00;
                }
//                print_r("  fdff");die;

//                $persheets = $this->input->post('max_labels');
                $persheets = $data['persheets'];
                $values_array = array('labeltype' => $printing,
                    'labels' => $labels ,
                    'design' => 1,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => 'Rolls',
                    'pressproof' => $presproof,
                    'finish' => $labelfinish);
                $response = $this->price_calculator_label_embellishment($values_array);
                //echo "<pre>";print_r($response);die();

                if ($data['upload_artwork_option_radio'] == "custom_roll_and_label"){
                    $promotiondiscount = $response['promotiondiscount'];
//                        20 pound cost add for custom labels and rolls option (this is only in roll)
                    $promotiondiscount+=20;

                }else{
                    $promotiondiscount = $response['promotiondiscount'];

                }


                $label_finish_individual_cost_array = $response['label_finish_individual_cost_array'];
                $plainlabelsprice = $response['plainlabelsprice'];
                $label_finish = $response['label_finish'];
                $rec = $this->home_model->get_total_uploaded_qty($cartid, $prd_id);

                $uploaded_labels = $rec['labels'];
                $uploaded_rolls = $rec['sheets'];

                $additional_cost = 0.00;
                $additional_rolls = 0;
                if ($uploaded_rolls > $response['rolls']) {
                    $additional_rolls = $uploaded_rolls - $response['rolls'];
                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $additional_cost;
                }
                /*echo "uploaded_rolls: ".$uploaded_rolls."<br>";
                echo "response['rolls']: ".$response['rolls']."<br>";
                echo "additional_cost: ".$additional_cost;die();*/

                $presproof_charges = $this->home_model->currecy_converter($presproof_charges, 'yes');
                $presproof_charges = number_format($presproof_charges, 2, '.', '');

                $additional_cost = $this->home_model->currecy_converter($additional_cost, 'yes');
                $additional_cost = number_format($additional_cost, 2, '.', '');

                $printprice = $this->home_model->currecy_converter($response['promotiondiscount'], 'yes');
                $printprice = number_format($printprice, 2, '.', '');


                $label_finish = $this->home_model->currecy_converter($label_finish, 'yes');
                $label_finish = number_format($label_finish, 2, '.', '');

                $plainlabelsprice = $this->home_model->currecy_converter($plainlabelsprice, 'yes');
                $plainlabelsprice = number_format($plainlabelsprice, 2, '.', '');

                $promotiondiscount = $this->home_model->currecy_converter($promotiondiscount, 'yes');
                $promotiondiscount = number_format($promotiondiscount, 2, '.', '');


                $price = $this->home_model->currecy_converter($response['price'] + $additional_cost, 'yes');
                $price = number_format($price, 2, '.', '');
                $price_txt = '<b class="color-orange"> ' . symbol . $price . ' </b> <br />' . vatoption . ' VAT';
                $per_labels = round(($price / $labels), 3);
                //$per_labels = $labels.'  Labels, '.symbol.$per_labels.' per label';

                if (isset($requestfrom) and $requestfrom == 'lba') {
                    $per_labels = $labels . '  Labels<br>' . symbol . $per_labels . '<br>Pence per label';
                } else {
                    $per_labels = $labels . '  Labels, ' . symbol . $per_labels . ' per label';
                }

                return array('response' => 'yes',
                    'price' => $price_txt,
                    'printprice' => ($printprice ),
                    'halfprintprice' => number_format($promotiondiscount, 2, '.', ''),
                    'onlyprintprice' => number_format($promotiondiscount * 2, 2, '.', ''),
                    'plainlabelsprice' => number_format($plainlabelsprice, 2, '.', ''),
                    'label_finish' => number_format($label_finish, 2, '.', ''),
                    'additional_cost' => $additional_cost,
                    'additional_rolls' => $additional_rolls,
                    'presproof_charges' => $presproof_charges,
                    'labelprice' => $per_labels,
                    'diameter' => $diamter,
                    'rolls'    =>$response['rolls'],
                    'designprice'    =>$response['designprice'],
                    'artworks'    =>$response['artworks'],
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'rawprice' => $price,
                    'label_finish_individual_cost_array' => $label_finish_individual_cost_array);
            }

            //$this->save_browsing_history('roll');
        }

    }
//label embellishment end emb page price function



    function calculate_sheet_price_printed_emb_page($data)
    {
//        print_r($data); exit;
        if ($data) {

            $menu = $data['menu'];
            $labels = $data['labels'];
            $design = $data['design'];
            $persheets = $data['persheets'];
            $producttype = $data['producttype'];
            $pressproof = $data['pressproof'];
            $finish = $data['finish'];

            $qty = $data['qty'];
            $labels = $data['labels'];
            $printing = $data['printing'];
            $requestfrom = "material_page";
            $sheet_product_quality = $data['sheet_product_quality'];
//            $minimum_sheet_threshold = $this->home_model->min_qty_labels($menu);
//            print_r($data);die;
//
//            if ($sheets < $minimum_sheet_threshold) {
//                  $sheets = $minimum_sheet_threshold;
//
//            }

            if (isset($printing) && $printing != '') {
                $cartid = $this->input->post('cart_id');

                $values_array = array('labeltype' => $printing,
                    'labels' => $labels,
                    'design' => $design,
                    'rolls' => $qty,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => $producttype,
                    'pressproof' => $pressproof,
                    'finish' => $finish,
                    'sheet_product_quality' => $sheet_product_quality

                );

                $response = $this->price_calculator_label_embellishment($values_array);
//                echo"<pre>";print_r($response);die;
                $promotiondiscount = $response['promotiondiscount'];
                $plainlabelsprice = $response['plainlabelsprice'];
                $label_finish = $response['label_finish'];
                $printprice = $response['printprice'];
                $designprice = $response['designprice'];
                $label_finish_individual_cost_array = $response['label_finish_individual_cost_array'];


                $designprice = $this->home_model->currecy_converter($response['designprice'], 'yes');
                $designprice = number_format($designprice, 2, '.', '');

                $plainprice = $this->home_model->currecy_converter($response['plainprice'], 'yes');
                $plainprice = number_format($plainprice, 2, '.', '');


                $label_finish = $this->home_model->currecy_converter($label_finish, 'yes');
                $label_finish = number_format($label_finish, 2, '.', '');

                $plainlabelsprice = $this->home_model->currecy_converter($plainlabelsprice, 'yes');
                $plainlabelsprice = number_format($plainlabelsprice, 2, '.', '');

                $promotiondiscount = $this->home_model->currecy_converter($promotiondiscount, 'yes');
                $promotiondiscount = number_format($promotiondiscount, 2, '.', '');


                $price = $this->home_model->currecy_converter($response['price'] , 'yes');
                $price = number_format($price, 2, '.', '');

                $price_txt = '<b class="color-orange"> ' . symbol . $price . ' </b> <br />' . vatoption . ' VAT';
                $per_labels = round(($price / $labels), 3);
                //$per_labels = $labels.'  Labels, '.symbol.$per_labels.' per label';

                if (isset($requestfrom) and $requestfrom == 'lba') {
                    $per_labels = $labels . '  Labels<br>' . symbol . $per_labels . '<br>Pence per label';
                } else {
                    $per_labels = $labels . '  Labels, ' . symbol . $per_labels . ' per label';
                }



                return array('response' => 'yes',
                    'price' => $price_txt,
                    'printprice' => ($printprice  ),
                    'plainprice' => number_format($plainprice, 2, '.', ''),
                    'halfprintprice' => number_format($promotiondiscount, 2, '.', ''),
                    'onlyprintprice' => number_format($promotiondiscount * 2, 2, '.', ''),
                    'plainlabelsprice' => number_format($plainlabelsprice, 2, '.', ''),
                    'label_finish' => number_format($label_finish, 2, '.', ''),
                    'additional_cost' => $additional_cost,
                    'designprice' => $designprice,
                    'nodesing'    =>$response['nodesing'],
                    'artworks'    =>$response['artworks'],
                    'additional_rolls' => $additional_rolls,
                    'presproof_charges' => $presproof_charges,
                    'labelprice' => $per_labels,
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'rawprice' => $price,
                    'label_finish_individual_cost_array' => $label_finish_individual_cost_array);
            }

            //$this->save_browsing_history('roll');

        }

    }



    function add_products_incart(){

        if($_POST){

            $colorcode = '';

            $cartid = $this->input->post('cartid');
            $qty = $this->input->post('qty');
            $menu = $this->input->post('menuid');
            $productid = $this->input->post('prd_id');
            $type = $this->input->post('type');
            $labeltype = $this->input->post('labeltype');
            $source = $this->input->post('source');
            $label_id = $this->input->post('label_id');
            $final_labels = $this->input->post('total_labels');

            $printing = $this->input->post('printing');
            $page = $this->input->post('page');


            $design = $this->get_uploaded_number_design($cartid, $productid);
            $per_sheet = $this->input->post('labels');

            $wound ='N'; $printtype ='';$is_custom ='No';$LabelsPerRoll ='';	$A4Printing = array();

            $check = $this->user_model->isProductActive($menu);
            if($check==0){

                $query = $this->db->query("SELECT `CategoryID` FROM `products` Where ManufactureID='".$menu."'");
                $result1 = $query->row_array();

                $roll_arr=array('R1','R2','R3','R4','R5');
                $categoryid=str_replace($roll_arr,'',$result1['CategoryID']);

                $url = base_url().'home/material/'.$categoryid;
                echo json_encode(array('deactive'=>'yes','url'=>$url));
                exit();
            }

            if(isset($type) and $type=='Rolls'){

                $woundoption = $this->input->post('woundoption');
                $orientation = $this->input->post('orientation');
                $cartid = $this->input->post('cartid');
                $labels = $this->input->post('labels');
                $labelfinish = $this->input->post('labelfinish');
                $persheets = $this->input->post('max_labels');
                $presproof = $this->input->post('presproof');
                $printing = $this->input->post('printing');


                $presproof = (isset($presproof) and $presproof==1)?1:0;

                $presproof_charges = 0.00;
                if(isset($presproof) and $presproof==1){
                    $presproof_charges = 50.00;
                }


                $values_array = array('labeltype'=>$printing,
                    'labels'=>$labels,
                    'design'=>1,
                    'menu'=>$menu,
                    'persheets'=>$persheets,
                    'producttype'=>'Rolls',
                    'pressproof'=>$presproof,
                    'finish'=>$labelfinish);
                //echo"<pre>";print_r($values_array);echo"</pre>";
                $response = $this->price_calculator($values_array);
                //echo"<pre>";print_r($response);echo"</pre>";exit;

                $rec = $this->home_model->get_total_uploaded_qty($cartid, $productid);
                $labels = $uploaded_labels = $rec['labels'];
                $qty = $uploaded_rolls = $rec['sheets'];

                if($uploaded_rolls > $response['rolls']){
                    $additional_rolls = $uploaded_rolls-$response['rolls'];
                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $response['price'] = $response['price']+$additional_cost;
                }
                $total = number_format($response['price'],2,'.','');


                if($design == 0){
                    $qty = $response['sheets'];
                    $LabelsPerRoll = $response['labels_per_rolls'];
                    $is_custom = 'Yes';
                    $labels =  $response['labels'];
                }

                $Print_Design = '1 Design';
                if($design > 1){
                    $Print_Design = 'Multiple Designs';
                }

                $final_labels = (isset($final_labels) && $final_labels!=0)?$final_labels:$labels;
                $A4Printing = array( 'Printing'=>'Y',
                    'Print_Type'=>$printing,
                    'Print_Design'=>$Print_Design,
                    'Free'=>$response['artworks'],
                    'Print_Qty'=>$design,
                    'Print_UnitPrice'=>0.00,
                    'Print_Total'=>0.00,
                    'wound'=>$woundoption,
                    'is_custom'=>$is_custom,
                    'LabelsPerRoll'=>$LabelsPerRoll,
                    'orientation'=>$orientation,
                    'pressproof'=>$presproof,
                    'FinishType'=>$labelfinish,
                    'orignalQty'=>$final_labels,
                );



            }
            else {


                if(substr($menu,-2,2)=='XS'){
                    $printtype = $this->input->post('design');
                }
                /*****************WPEP Offer************/
                $wpep_discount = 0.00;
                $data=$this->product_model->ajax_price($qty,$menu);
                $total = $data['custom_price'];

                $ProductBrand = $this->ProductBrand($menu);
                /*if(preg_match("/A4 Labels/i",$ProductBrand) and (preg_match("/WPEP/i",$menu))){
                    $data['custom_price'] = ($data['custom_price']*1.2);
                    $wpep_discount = (($data['custom_price'])*(20/100));
                    $total = $data['custom_price']-$wpep_discount;
                    $total = $total/1.2;
                }
*/									if(preg_match("/A4 Labels/i",$ProductBrand))
                {
                    $mat_code = $this->home_model->getmaterialcode($menu);
                    $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');
                    if($material_discount)
                    {
                        $data['custom_price'] = ($data['custom_price']*1.2);
                        $wpep_discount = (($data['custom_price'])*($material_discount/100));
                        $total = $data['custom_price']-$wpep_discount;
                        $total = $total/1.2;
                    }
                }
                /*****************WPEP Offer************/

                /****************Printed Labels Options*************/

                if($ProductBrand=='Application Labels'){
                    $colorcode = $this->input->post('colour');
                }


                if(isset($printing) and $printing == "Y" and $labeltype == "")
                {
                    $labeltype = 'Fullcolour';
                }

                if(preg_match('/Monochrome/',$labeltype))
                {
                    $labeltype = 'Mono';
                }



                if(isset($labeltype) and ($labeltype=='Mono' || $labeltype=='Fullcolour')){

                    $designprice = 0.00;
                    $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand,$menu);
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];
                    if(preg_match("/A3 Label/is", $ProductBrand) || preg_match("/SRA3 Label/is", $ProductBrand)) {
                        $printprice = $printprice*1.5;
                    }
                    $printprice = $printprice+$designprice;

                    if(isset($source) and $source == "LBA")
                    {
                        $total_labels = $per_sheet*$qty;
                        $perprice = round(($printprice / ($total_labels)), 3);
                        $printprice = $this->home_model->get_lba_uplift_price($qty,$printprice,$perprice,$total_labels);
                    }


                    $Print_Design = '1 Design';
                    if($design > 1){
                        $Print_Design = 'Multiple Designs';
                    }
                    if($labeltype=='Mono'){
                        $labeltype = 'Monochrome – Black Only';
                    }else{
                        $labeltype = '4 Colour Digital Process';
                    }
                    $A4Printing = array( 'Printing'=>'Y',
                        'Print_Type'=>$labeltype,
                        'Print_Design'=>$Print_Design,
                        'Free'=>$free_artworks,
                        'Print_Qty'=>$design,
                        'Print_UnitPrice'=>$printprice,
                        'Print_Total'=>$printprice);
                }
                if(isset($source) and $source == "LBA")
                {
                    $total_labels = $per_sheet*$qty;
                    $perprice = round(($total / ($total_labels)), 3);
                    $total = $this->home_model->get_lba_uplift_price($qty,$total,$perprice,$total_labels);
                }
                /****************Printed Labels Options*************/


            }

            $final_labels = (isset($final_labels) && $final_labels!=0)?$final_labels:$qty;
            $unit_price = $total/$qty;
            $SID  =  $this->shopping_model->sessionid();

            $page_loc = "Product Material";
            if(isset($page) and $page == "reorder")
            {
                $page_loc = "User Reorder";
            }


            $items = array('SessionID'=>$SID,
                'ProductID'=>$productid,
                'Quantity'=>$qty,
                'orignalQty'=>$final_labels,
                'UnitPrice'=>$unit_price,
                'TotalPrice'=>$total,
                'source'=>'printing',
                'page_location'=>$page_loc,
            );
            if($source != NULL and $source != '')
            {
                $items['source'] = $source;
            }
            $items = array_merge($items,$A4Printing);
            //echo"<pre>";print_r($items);echo"</pre>";exit;



            $userID = $this->session->userdata('userid');
            if(isset($userID) and $userID != '')
            {
                $cart_reminder = $this->home_model->get_db_column("customers","cart_reminder","UserID",$userID);
                if(isset($cart_reminder) and $cart_reminder == "Y")
                {
                    $items['UserID'] = $userID;
                }
            }



            $this->db->insert('temporaryshoppingbasket',$items);
            $insert_id = $this->db->insert_id();

            if($this->db->insert_id()){
                $design = ($source == "LBA")?0:$design;
                if(isset($design) and $design > 0){

                    $data = array( 'CartID' => $this->db->insert_id(), 'status' => 'confirm','SessionID'=>$SID);
                    $items_array = array('SessionID' => $SID.'-PRJB', 'ProductID' => $productid, 'CartID'=>$cartid);
                    if($design == 1){
                        if(isset($type) and $type=='Rolls'){
                            $labels = $this->input->post('labels');
                        }else{
                            $labelspersheet = $this->input->post('labels');
                            $labels = $qty*$labelspersheet;
                        }
                        $data = array_merge($data, array('qty'=>$qty,'labels'=>$labels));
                    }
                    $update = $this->db->update('integrated_attachments', $data, $items_array);
                }else if($source == "LBA"){
                    //$userdesigns = $this->home_model->check_user_design($label_id);
                    $designdata = $this->home_model->get_user_lba_data($label_id);
                    $this->home_model->delete_abandon_design($label_id);
                    if(isset($type) and $type=='Rolls'){
                        $labels = $this->input->post('labels');
                    }else{
                        $labelspersheet = $this->input->post('labels');
                        $labels = $qty*$labelspersheet;
                    }


                    $this->db->where('ID',$insert_id);
                    $this->db->update('temporaryshoppingbasket',array('user_project_id'=>$designdata['ID'],'Print_Qty'=>1));

                    $copy  =  FCPATH.'Labeler/media/users/'.$designdata['Thumb'];
                    $paste =  FCPATH.'theme/integrated_attach/'.$designdata['Thumb'];
                    if(copy($copy,$paste)){  }else{  };

                    $data = array(
                        'CartID'=>$insert_id,
                        'status'=>'confirm',
                        'SessionID'=>$SID,
                        'ProductID'=>$productid,
                        'qty'=>$qty,
                        'labels'=>$final_labels,
                        'file'=>$designdata['Thumb'],
                        'source'=>'web'
                    );
                    $this->db->insert('integrated_attachments',$data);
                }




            }

            $topcart_data = $this->ajax_topcart_load();
            $bottom_cart = "";
            if($source == "LBA")
            {
                $bottom_cart = $this->ajax_bottomcart_load();
            }
            echo json_encode(array('response'=>'yes','top_cart'=>$topcart_data,'bottom_cart' => $bottom_cart));


        }
    }

    function get_material_filter()
    {
        $material = $this->input->post('material');
        $adhesive = $this->input->post('adhesive');
        $color = $this->input->post('color');

        $data['a4_materials']['data'] = $this->product_model->get_static_material_list('a4', $material, $adhesive, $color);
        $data['a4_materials']['type'] = $material;

        $data['roll_materials']['data'] = $this->product_model->get_static_material_list('roll', $material, $adhesive, $color);
        $data['roll_materials']['type'] = $material;

        $colors_list = $this->product_model->get_material_columns('color', $material);
        $adhesive_list = $this->product_model->get_material_columns('adhesive', $material, $color);

        $colorsResponse = $this->product_model->make_material_dropdown($colors_list,'color','Sort by Colour',$color);
        $adhesiveResponse = $this->product_model->make_material_dropdown($adhesive_list,'adhesive','Sort by Adhesive',$adhesive);

        $theHTMLResponse = $this->load->view('static/material_list', $data, true);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('html'=> $theHTMLResponse,'material' =>$material,'adhesive'=>$adhesive,'color'=>$color, 'color_options'=>$colorsResponse, 'adhesive_options'=>$adhesiveResponse)));
    }


    public function update_embellishment_printing_options()
    {
        if ($_POST) {
            $email = $coresize = $wound_roll = $orientation = '';

            $email = $this->input->post('email');
            $coresize = $this->input->post('core_size');
            $wound_roll = $this->input->post('wound_option');
            $orientation = $this->input->post('label_orientation');
            $digital_process = $this->input->post('digital_process');
            //            $orientation = $this->input->post('orientation');


            $container = $this->input->post('container');

//            print_r($container);die;
            $con_type = explode("_", $container);
            $con_type = $con_type[0];

            $flag = $this->input->post('flag');
            $refNumber = $this->input->post('refNumber');
            $lineNumber = $this->input->post('lineNumber');

            if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
                $orientation = substr($orientation, -1, 1);
                if ($flag == 'order_detail'){
                    //$line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);

                    $table = 'orderdetails';
                    $where_column = 'SerialNumber';
                    $label_column = 'labels';
                    $artwork_table = 'order_attachments_integrated';

                    $pref = array(
                        'Wound' => $wound_roll,
                        'Orientation' => $orientation,
                        'Print_Type' => $digital_process,
                    );
                }elseif ($flag == 'quotation_detail'){
                    //$line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);

                    $table = 'quotationdetails';
                    $where_column = 'SerialNumber';
                    $label_column = 'orignalQty';
                    $artwork_table = 'quotation_attachments_integrated';

                    $pref = array(
                        'wound' => $wound_roll,
                        'Orientation' => $orientation,
                        'Print_Type' => $digital_process,
                    );
                }

                $this->db->where($where_column, $lineNumber);
                $this->db->update($table, $pref);
            } else {
                $pref = array('email' => $email,
                    'sessionID' => $this->session->userdata('session_id'),

                    'coresize' => $coresize,
                    'wound_roll' => $wound_roll,
                    'orientation' => $orientation,
                    'digital_proccess_' . $con_type => $digital_process,
                );
//              echo"<prE>";print_r("$pref");echo"</pre>";exit;
                $this->home_model->insert_preferences($pref);
            }
        }
    }


    public function update_printing_options()
    {
        if($_POST)
        {
            $email = $digital_process = $color = $adhesive = $finish = $material = '';

            $email = $this->input->post('email');
            $digital_proccess = $this->input->post('digital_proccess');
            $color = $this->input->post('color');
            $adhesive = $this->input->post('adhesive');
            $finish = $this->input->post('finish');
            $material = $this->input->post('material');

            $container = $this->input->post('container');
            $con_type = explode("_",$container);
            $con_type = $con_type[0];
            $pref = array('email' => $email,
                'sessionID' => $this->session->userdata('session_id'),
                'digital_proccess_'.$con_type => $digital_proccess,
                'color_'.$con_type  => $color,
                'adhesive_'.$con_type  => $adhesive,
                'finish_'.$con_type => $finish,
                'material_'.$con_type => $material);
            //echo"<prE>";print_r($pref);echo"</pre>";exit;
            $this->home_model->insert_preferences($pref);
        }
    }

    public function load_preferences()
    {
        if($_POST)
        {
            $email = $preferences = '';
            $email = $this->input->post('email');
            if($email != '')
            {
                $preferences = $this->home_model->load_preferences($email);
            }
            if(!empty($preferences))
            {
                if($preferences['available_in'] == "A4" and $preferences['categorycode_a4'] != '')
                {
                    $cat_desc = $this->home_model->get_db_column("category","CategoryDescription","CategoryID",$preferences['selected_size']);
                    $cat_desc = explode("-",$cat_desc);
                    $preferences['cat_desc_a4'] = $cat_desc[0];
                    $preferences['cat_desc_roll'] = '';
                }
                if($preferences['available_in'] == "Roll" and $preferences['categorycode_roll'] != '')
                {
                    $catID = explode("R",$preferences['selected_size']);
                    $preferences['cat_desc_a4'] = '';
                    $preferences['cat_desc_roll'] = $this->home_model->get_db_column("category","CategoryDescription","CategoryID",$catID[0]);
                }

                if($preferences['available_in'] == "both" and ($preferences['categorycode_roll'] != '' || $preferences['categorycode_a4'] != ''))
                {
                    $catID = explode(",",$preferences['selected_size']);

                    $cat_desc = $this->home_model->get_db_column("category","CategoryDescription","CategoryID",$catID[0]);
                    $cat_desc = explode("-",$cat_desc);
                    $preferences['cat_desc_a4'] = $cat_desc[0];

                    $preferences['cat_desc_roll'] = $this->home_model->get_db_column("category","CategoryDescription","CategoryID",substr($catID[1], 0, -2));
                }
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('response'=> 'yes','preferences' => $preferences)));
            }
            else
            {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('response'=> 'no')));
            }
        }
    }


    public function material_load_preferences()
    {
        $combination_array = array();
        $label_embellishments = $this->orderModal->get_label_embellishment_and_combinations();

        /*echo "<pre>";
        print_r($label_embellishments);
        die;*/
        $embellishment_plate_price = array();
        foreach ($label_embellishments['label_embellishment'] as $key1 => $label_emb) {
            $plate_price = new stdClass();
            $plate_price->id = $label_emb['id'];
            $plate_price->parsed_title = $label_emb['parsed_title'];
            $plate_price->title = $label_emb['title'];
            $plate_price->plate_cost = $label_emb['plate_cost'];
            $embellishment_plate_price[] = $plate_price;
            foreach ($label_embellishments['label_embellishment_cond'] as $key => $label_emb_cond) {

                if ($label_emb['id'] == $label_emb_cond['label_embellishment_id']) {
                    $label_embellishment_details = $this->orderModal->get_label_embellishment_details_by_id($label_emb_cond['label_embellishment_agianst_id']);

                    $data = new stdClass();
                    $data->label_embellishment_agianst_id = $label_emb_cond['label_embellishment_agianst_id'];
                    $data->label_condition = $label_emb_cond['label_condition'];
					//$data->label_embellishment_title = $label_emb['parsed_title'];
                    $data->label_embellishment_title = $label_embellishment_details['label_embellishment_details']['title'];
                    $combination_array[$label_emb['id'] . '_' . $label_emb['title']][] = $data;

                }
            }
        }


        // if ($_POST) {
        $email = $preferences = '';
        $data = array();
        $data['combination_array'] = $combination_array;
        $data['label_embellishments'] = $label_embellishments['label_embellishment_parent'];
        $data['embellishment_plate_price'] = $embellishment_plate_price;

        $session_id = $this->shopping_model->sessionid();
        if ($session_id != '') {
            $cartid = $this->home_model->get_db_column('temporaryshoppingbasket', 'id', 'SessionID', $session_id . '-PRJB');
            $data['cartid'] = $cartid;
            $preferences = $this->orderModal->material_load_preferences($session_id);
        }

        $edit_cart_flag = $this->input->post('edit_cart_flag');
        if( $edit_cart_flag ) {
	        $data['edit_cart_flag'] = $edit_cart_flag;
        	$temp_basket_id = $this->input->post('temp_basket_id');
		    if( isset($temp_basket_id) && $temp_basket_id != '' ) {
		    	$product_basket_data = $this->getCartAndProductData($temp_basket_id);
		        $preferences = $this->generate_preferences_data_edit_cart_flag($product_basket_data);
		        $data['IA_data'] = $this->orderModal->Get_IA_Data($product_basket_data['ID']);
		        $data['IA_all_data'] = $this->orderModal->Get_IA_All_Data($product_basket_data['ID']);
		        $data['cart_and_product_data'] = $product_basket_data;


		        	$history['user_id'] = $data['cart_and_product_data']['UserID'];
					$finish_PricePrintedLabel = json_decode($data['cart_and_product_data']['FinishTypePricePrintedLabels']);

					$history['selected_already_plates'] = [];
					$history['selected_already_plates_composite_array'] = [];
					$i=0;
					foreach ($finish_PricePrintedLabel as $selectedOptions){
					    if ($selectedOptions->use_old_plate == 1){
					        $selected_plate_orderNumber = $selectedOptions->used_plate_orderNumber;
					        $selecte_parsed_row = $this->home_model->label_embelishment_with_parent_title($selectedOptions->finish_parsed_title);
					        $child_id = $selecte_parsed_row[0]->id;
					        $parent_id = $selecte_parsed_row[0]->label_emb_parent_id;
					        $parsed_title = $selecte_parsed_row[0]->parsed_title;
					        array_push($history['selected_already_plates'],$child_id);

					        $purchased_plate_history  = $this->home_model->get_db_column('customers', 'purchased_plate_history', 'UserID', $history['user_id']);
					        $purchased_plate_history = json_decode($purchased_plate_history);

					        foreach ($purchased_plate_history as $purchased_plate){
					            if ($parsed_title == $purchased_plate->purchased_plate && $selected_plate_orderNumber == $purchased_plate->order_number){
					                $history['selected_already_plates_composite_array'][$i] = json_encode(array('already_used_plate_id'=>(int)$child_id,'plate_order_no'=>$selected_plate_orderNumber));
					                $i++;
					            }
					        }
					    }
					}
					$history['selected_already_plates'] = json_encode($history['selected_already_plates']);
					$hostory_plates_content = $this->purchased_plate_history_selected($history);
					$data['hostory_plates_content'] = $hostory_plates_content;
		    }	
        }

        
        if (!empty($preferences)) {


            if (($preferences['available_in'] == "A4" || $preferences['available_in'] == "A3" || $preferences['available_in'] == "SRA3" || $preferences['available_in'] == "A5") and $preferences['categorycode_a4'] != '') {
                $cat_desc = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", $preferences['selected_size']);
                $cat_desc = explode("-", $cat_desc);
                $preferences['cat_desc_a4'] = $cat_desc[0];
                $preferences['cat_desc_roll'] = '';

                $dataProdu = $this->orderModal->getProductData($preferences['productcode_a4']);
                $preferences['ProductID'] = $dataProdu[0]->ProductID;
                $preferences['ManufactureID'] = $dataProdu[0]->ManufactureID;

                $category_id = $preferences['selected_size'];


                $row = $this->db->query(" Select * from category WHERE CategoryID LIKE '" . $category_id . "' ")->row_array();

                if ($row['Shape_upd'] == "Circular") {
                    $label_size = ucwords(str_replace("Label Size:", "", $row['specification3']));
                    $label_size = str_replace("Mm", "", $label_size);
                } else {
                    $label_size = $row['LabelWidth'] . " x " . $row['LabelHeight'];
                    $label_size = str_replace("mm", "", $label_size);

                }
                $data['label_size'] = $label_size;

                $printing_process = $this->orderModal->get_digital_printing_process('a4');
                $data['printing_process'] = $printing_process;
                $data['availabel_in'] = $preferences['available_in'];
                $data['preferences'] = $preferences;

				//                $condition = " p.CategoryID LIKE '" . $preferences['selected_size'] . "' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
				//                $condition .= " AND Adhesive LIKE '" . $preferences['adhesive_a4'] . "'";
				//                $condition .= " AND Material1 LIKE '" . $preferences['color_a4'] . "'";
				//                $condition .= " AND ColourMaterial_upd LIKE '" . $preferences['material_a4'] . "'";
				//
				//                $query = " Select * from products p,category c WHERE $condition AND SUBSTRING_INDEX(p.CategoryID,'R',1) = c.CategoryID";
				//                $data['sheetdetails'] = $this->db->query($query)->row_array();
				//                $data['details'] = $this->db->query($query)->row_array();
				//                $data['sheetdetails'] = $this->db->query($query)->row_array();
                 $data['details'] = $dataProdu;

				//                echo"<pre>";print_r($data['rolldetails']);die;


                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/printing_process_sheet', $data, true);
					//                $json_data = array('content' => $theHTMLResponse);
                $data['printing_process_content'] = $theHTMLResponse;

                $finishHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/label_finish_and_embellishment', $data, true);
					//                $json_data = array('content' => $theHTMLResponse);
                $data['finish_content'] = $finishHTMLResponse;

                $cartSummeryHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);
					//                $json_data = array('content' => $theHTMLResponse);
                $data['cart_summery'] = $cartSummeryHTMLResponse;

					//                $artworkUploadHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/artwork_upload', $data, true);
					//                $json_data = array('content' => $theHTMLResponse);
					//                $data['artwork_upload_view'] = $artworkUploadHTMLResponse;
            }
            if ($preferences['available_in'] == "Roll" and $preferences['categorycode_roll'] != '') {
                $catID = explode("R", $preferences['selected_size']);
                $preferences['cat_desc_a4'] = '';
                $preferences['cat_desc_roll'] = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", $catID[0]);

                $dataProdu = $this->orderModal->getProductData($preferences['productcode_roll']);

                $preferences['ProductID'] = $dataProdu[0]->ProductID;
                $preferences['ManufactureID'] = $dataProdu[0]->ManufactureID;
                $preferences['CategoryImage'] = $dataProdu[0]->CategoryImage;
                $category_id = explode('R', $preferences['selected_size']);
                $category_id = $category_id[0];
                $rollcores = $this->orderModal->roll_core_sizes($category_id, $preferences['coresize']);
                $data['roll_cores'] = $rollcores;


				//                $condition = " p.CategoryID LIKE '" . $preferences['selected_size'] . "' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
				//                $condition .= " AND Adhesive LIKE '" . $preferences['adhesive_roll'] . "'";
				//                $condition .= " AND Material1 LIKE '" . $preferences['color_roll'] . "'";
				//                $condition .= " AND ColourMaterial_upd LIKE '" . $preferences['material_roll'] . "'";
				//
				//                $query = " Select * from products p,category c WHERE $condition AND SUBSTRING_INDEX(p.CategoryID,'R',1) = c.CategoryID";
				//                $data['rolldetails'] = $this->db->query($query)->row_array();
				//                $data['details'] = $this->db->query($query)->row_array();
                $data['details'] = $dataProdu;
                //echo"<pre>";print_r($data['details'][0]->ProductID);die;

                $row = $this->db->query(" Select * from category WHERE CategoryID LIKE '" . $category_id . "' ")->row_array();

                if ($row['Shape_upd'] == "Circular") {
                    $label_size = ucwords(str_replace("Label Size:", "", $row['specification3']));
                    $label_size = str_replace("Mm", "", $label_size);
                } else {
                    $label_size = $row['LabelWidth'] . " x " . $row['LabelHeight'];
                    $label_size = str_replace("mm", "", $label_size);

                }
                $data['label_size'] = $label_size;

                $printing_process = $this->orderModal->get_digital_printing_process('roll');
                $data['printing_process'] = $printing_process;
                $data['availabel_in'] = $preferences['available_in'];
                $data['preferences'] = $preferences;

                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/printing_process', $data, true);
				//                $json_data = array('content' => $theHTMLResponse);
                $data['printing_process_content'] = $theHTMLResponse;

                $finishHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/label_finish_and_embellishment', $data, true);
				//                $json_data = array('content' => $theHTMLResponse);
                $data['finish_content'] = $finishHTMLResponse;

                $cartSummeryHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);
				//                $json_data = array('content' => $theHTMLResponse);
                $data['cart_summery'] = $cartSummeryHTMLResponse;

				//                $artworkUploadHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/artwork_upload', $data, true);
				//                $json_data = array('content' => $theHTMLResponse);
				//                $data['artwork_upload_view'] = $artworkUploadHTMLResponse;

				//                $data['main_content'] = 'order_quotation/label_embellishment_Print_service/label_emb_page/printing_process_and_product';
				//                $this->load->View('page', $data);

            }

            if ($preferences['available_in'] == "both" and ($preferences['categorycode_roll'] != '' || $preferences['categorycode_a4'] != '')) {
                $catID = explode(",", $preferences['selected_size']);

                $cat_desc = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", $catID[0]);
                $cat_desc = explode("-", $cat_desc);
                $preferences['cat_desc_a4'] = $cat_desc[0];

                $preferences['cat_desc_roll'] = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", substr($catID[1], 0, -2));
            }

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('response' => 'yes', 'preferences' => $preferences, 'data' => $data)));
        } else {

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('response' => 'no')));
        }
        // }
    }

    function material_load_printing_preferences($email)
    {
        $preferences = '';
        $email = $email;
        if ($email != '') {
            
            $preferences = $this->orderModal->material_load_printing_preferences($email);
            return $preferences;
        } else {
            return false;
        }
    }
    function material_printingmaterials()
    {
        $color = $material = $finish = $adhesive = $email = $orientation = '';
        $cate = $tcode = $this->input->post('category_id');
        $available = $this->input->post('available_in');
        $type = $this->input->post('type');
        $email = $this->input->post('email');
        $orientation = $this->input->post('orientation');
        
        $preferences_printing = $this->material_load_printing_preferences($email);

        if (isset($available) and $available == 'both') {
            $tcode = explode(",", $tcode);
            $type = $this->input->post('type');
            if ($type == 'Roll') {
                $tcode = str_replace("R1", "", $tcode[1]);
            } else {
                $tcode = $tcode[0];
            }

        } else if (isset($available) and $available == 'Roll') {
            $tcode = str_replace("R1", "", $tcode);

        }

        $material_sel = $this->input->post('material');
        $color_sel = $this->input->post('color');
        $finish_sel = $this->input->post('finish');
        $adhesive_sel = $this->input->post('adhesive');

        if (isset($color_sel) and strlen($color_sel) > 0) {
            $color = " AND p.Material1 LIKE '" . $color_sel . "' ";
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


        $condition = " c.CategoryID LIKE '" . $tcode . "' AND p.Printable LIKE 'Y' ";


        $adhesive_condtion = $condition . $color . $material . $finish;
        $adhesive_list = $this->orderModal->labelsfinder_field_list('p.Adhesive', $adhesive_condtion);
        $adhesive_option = $this->orderModal->make_option_with_tooltip($adhesive_list, 'Adhesive', 'Select Label Adhesive', $adhesive_sel);

        $color_condtion = $condition . $finish . $material . $adhesive;
        $color_list = $this->orderModal->labelsfinder_field_list('p.Material1', $color_condtion);
        $color_option = $this->orderModal->make_option_with_tooltip($color_list, 'Material1', 'Select Label Colour', $color_sel);


        $finish_condtion = $condition . $color . $material . $adhesive;
        $finish_list = $this->orderModal->labelsfinder_field_list('p.LabelFinish_upd', $finish_condtion);
        $finish_option = $this->orderModal->make_html_option($finish_list, 'LabelFinish_upd', 'Select Label Finish', $finish_sel);

        $material_condtion = $condition . $color . $finish . $adhesive;
        $material_list = $this->orderModal->labelsfinder_field_list('p.ColourMaterial_upd', $material_condtion);
        $material_option = $this->orderModal->make_option_with_tooltip($material_list, 'ColourMaterial_upd', 'Select Label Material', $material_sel);


        $row = $this->db->query(" Select * from category WHERE CategoryID LIKE '" . $tcode . "' ")->row_array();
        $categorycode = str_replace(".png", "", $row['CategoryImage']);


        if ($row['Shape_upd'] == "Circular") {
            $label_size = ucwords(str_replace("Label Size:", "", $row['specification3']));
            $label_size = str_replace("Mm", "mm", $label_size);
        } else {
            $label_size = $row['LabelWidth'] . " x " . $row['LabelHeight'];
        }


        if (isset($type) and $type == 'Roll') {
            $image = explode('.', $row['CategoryImage']);
            $img_chgr = $image[0];
            $imagename = $image[0];

            //$image = Assets."images/categoryimages/RollLabels/outside/".$imagename."WTP1.jpg";
            //if(!getimagesize($image))
            //{
            //  $image = Assets."images/categoryimages/RollLabels/".$imagename.".jpg";
            //}


            if ((isset($preferences_printing['productcode_roll']) && $preferences_printing['productcode_roll'] != '') && (isset($preferences_printing['wound_roll']) && $preferences_printing['wound_roll'] != '')) {
                $image = Assets . "images/categoryimages/RollLabels/" . $preferences_printing['wound_roll'] . "/" . $preferences_printing['productcode_roll'] . ".jpg";
            } else {
                $image = Assets . "images/categoryimages/RollLabels/" . $imagename . ".jpg";
                if (!getimagesize($image)) {
                    $image = Assets . "images/categoryimages/roll_desc/" . $imagename . 'R1' . ".jpg";
                }
            }


            $image = '<img width="142" class="m-t-15 m-l-20 pull-left" src="' . $image . '" ><span style="margin-right:50px;" ></span>';


        } else {
            $image = Assets . "images/categoryimages/A4Sheets/" . $row['CategoryImage'];
            $image = '<img width="120" class="m-t-15 m-b-10" src="' . $image . '" >';
        }


        //$label_size = ucwords(str_replace("Label Size:","",$row['specification3']));
        //$label_size = str_replace("Mm","mm",$label_size);


        $json_data = array('response' => 'yes',
            'color' => $color_option,
            'material' => $material_option,
            'finish' => $finish_option,
            'adhesive' => $adhesive_option,
            'orientation' => $orientation,
            'categorycode' => $categorycode,
            'image' => $image,
            'labelsize' => $label_size);

        //echo"<pre>";print_r($json_data);echo"</pre>";exit;
        $pref = array('email' => $email,
            'sessionID' => $this->session->userdata('session_id'),
            'selected_size' => $cate,
            'orientation' => $orientation,
            'available_in' => $available,
        );

        if ($available == "A4" || $available == "A3" || $available == "SRA3" || $available == "A5") {
            $code_a4 = $this->home_model->get_db_column("category", "CategoryImage", "categoryID", $cate);
            $code = explode(".", $code_a4);
            $pref['categorycode_a4'] = $code[0];
        } else if ($available == "Roll") {

            $code_r = explode("R", $cate);
            $code_roll = $this->home_model->get_db_column("category", "CategoryImage", "categoryID", $code_r[0]);
            $code = explode(".", $code_roll);
            $pref['categorycode_roll'] = $code[0] . "R" . $code_r[1];

        } else if ($available == "both") {
            $cate = explode(",", $cate);

            $code_a4 = $this->home_model->get_db_column("category", "CategoryImage", "categoryID", $cate[0]);
            $code = explode(".", $code_a4);
            $pref['categorycode_a4'] = $code[0];

            $code_r = explode("R", $cate[1]);
            $code_roll = $this->home_model->get_db_column("category", "CategoryImage", "categoryID", $code_r[0]);
            $code = explode(".", $code_roll);

            $pref['categorycode_roll'] = $code[0] . "R" . $code_r[1];
            $pref['productcode_a4'] = isset($data['a4details']['ManufactureID']) ? $data['a4details']['ManufactureID'] : '';
            $pref['productcode_roll'] = isset($data['rolldetails']['ManufactureID']) ? $data['rolldetails']['ManufactureID'] : '';
        }
        $this->home_model->insert_preferences($pref);

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }




























    /**UX **/
    /*** UX ********/
    function save_browsing_history($type = '')
    {
        /*echo '<pre>';
        print_r($_POST);
        exit;*/
        //print_r($type); exit;
        if ($type != '') {
            if ($type == "roll") {
                //echo"<pre>";print_r($_POST);echo"</pre>";
                $productID = $this->input->post('prd_id');
                if(!$productID){
                    $productID = $this->input->post('productid');
                }
                //print_r($productID); exit;
                $qty = $this->input->post('roll');
                $menuid = $this->input->post('menuid');
                $labeltype = $this->input->post('printing');
                if ($labeltype == '' || $labeltype == 'plain') {
                    $labeltype = "plain";
                } else {
                    $labeltype = "printed";
                }

                $SID = $this->shopping_model->sessionid();

                $userID = $this->session->userdata('userid');
                $IPAddress = $this->session->userdata('ip_address');

                $insert_data = array();
                $insert_data['productID'] = $productID;
                $insert_data['SessionID'] = $SID;
                $insert_data['UserID'] = $userID;
                $insert_data['ManufactureID'] = $menuid;
                $insert_data['Quantity'] = $qty;
                $insert_data['labeltype'] = $labeltype;
                $insert_data['IPAddress'] = $IPAddress;
                $insert_check = $this->orderModal->insert_check($productID, $SID);
                if (!$insert_check) {
                    $this->db->insert('browsing_history', $insert_data);
                }


            } else if ($type == "sheet") {
                $productID = $this->input->post('prd_id');
                $qty = $this->input->post('qty');
                $menuid = $this->input->post('menuid');
                $labeltype = $this->input->post('labeltype');
                $SID = $this->orderModal->sessionid();

                $userID = $this->session->userdata('userid');
                $IPAddress = $this->session->userdata('ip_address');
                if ($labeltype == '' || $labeltype == 'plain') {
                    $labeltype = "plain";
                } else {
                    $labeltype = "printed";
                }
                $insert_data = array();
                $insert_data['productID'] = $productID;
                $insert_data['SessionID'] = $SID;
                $insert_data['UserID'] = $userID;
                $insert_data['ManufactureID'] = $menuid;
                $insert_data['Quantity'] = $qty;
                $insert_data['labeltype'] = $labeltype;
                $insert_data['IPAddress'] = $IPAddress;
                //echo"<pre>";print_r($insert_data);echo"</pre>";exit;
                $insert_check = $this->orderModal->insert_check($productID, $SID);
                if (!$insert_check) {
                    $this->db->insert('browsing_history', $insert_data);
                }

            } else if ($type == "integrated") {
                $productID = $this->input->post('prd_id');
                $qty = $this->input->post('box');
                $menuid = $this->input->post('manufature');
                $labeltype = $this->input->post('print_option');
                $SID = $this->orderModal->sessionid();

                $userID = $this->session->userdata('userid');
                $IPAddress = $this->session->userdata('ip_address');
                if ($labeltype == '' || $labeltype == 'plain') {
                    $labeltype = "plain";
                } else {
                    $labeltype = "printed";
                }
                $insert_data = array();
                $insert_data['productID'] = $productID;
                $insert_data['SessionID'] = $SID;
                $insert_data['UserID'] = $userID;
                $insert_data['ManufactureID'] = $menuid;
                $insert_data['Quantity'] = $qty;
                $insert_data['labeltype'] = $labeltype;
                $insert_data['IPAddress'] = $IPAddress;
                //echo"<pre>";print_r($insert_data);echo"</pre>";exit;
                $insert_check = $this->orderModal->insert_check($productID, $SID);
                if (!$insert_check) {
                    $this->db->insert('browsing_history', $insert_data);
                }
            }
        }
    }

    public function generate_emb_page()
    {

        $flag = $this->input->post('flag');
        $refNumber = $this->input->post('refNumber');
        $lineNumber = $this->input->post('lineNumber');

        $combination_array = array();
        $label_embellishments = $this->orderModal->get_label_embellishment_and_combinations();

        /*echo "<pre>";
        print_r($label_embellishments);
        die;*/

        $embellishment_plate_price = array();
        foreach ($label_embellishments['label_embellishment'] as $key1 => $label_emb) {
            $plate_price = new stdClass();
            $plate_price->id = $label_emb['id'];
            $plate_price->parsed_title = $label_emb['parsed_title'];
            $plate_price->title = $label_emb['title'];
            $plate_price->plate_cost = $label_emb['plate_cost'];
            $embellishment_plate_price[] = $plate_price;
            foreach ($label_embellishments['label_embellishment_cond'] as $key => $label_emb_cond) {

                if ($label_emb['id'] == $label_emb_cond['label_embellishment_id']) {
                    $label_embellishment_details = $this->orderModal->get_label_embellishment_details_by_id($label_emb_cond['label_embellishment_agianst_id']);

                    $data = new stdClass();
                    $data->label_embellishment_agianst_id = $label_emb_cond['label_embellishment_agianst_id'];
                    $data->label_condition = $label_emb_cond['label_condition'];
//                    $data->label_embellishment_title = $label_emb['parsed_title'];
                    $data->label_embellishment_title = $label_embellishment_details['label_embellishment_details']['title'];
                    $combination_array[$label_emb['id'] . '_' . $label_emb['title']][] = $data;

                }
            }
        }


        // if ($_POST) {
        $email = $preferences = '';
        $data = array();
        $data['combination_array'] = $combination_array;
        $data['label_embellishments'] = $label_embellishments['label_embellishment_parent'];
        $data['embellishment_plate_price'] = $embellishment_plate_price;


       /* $session_id = $this->shopping_model->sessionid();
        if ($session_id != '') {
            $cartid = $this->home_model->get_db_column('temporaryshoppingbasket', 'id', 'SessionID', $session_id . '-PRJB');
            $data['cartid'] = $cartid;

            $preferences = $this->orderModal->material_load_preferences($session_id);
        }*/

        if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail')) {
            if($flag == 'order_detail'){
                $line_detail = $this->orderModal->getOrderDetailBySerialNumber($lineNumber);
                $history['user_id'] = $line_detail->UserID;
            }
            elseif ($flag == 'quotation_detail'){
                $line_detail = $this->orderModal->getQuotationDetailBySerialNumber($lineNumber);
                $history['user_id'] = $line_detail->CustomerID;
            }
            $preferences = $this->home_model->generate_preferences_data($line_detail,$flag);
        }

       /* echo "<pre>";
        print_r($line_detail);
        echo "<br>-----------------------------";
        print_r($preferences);
        echo "<br>-----------------------------<br>";
        echo $preferences['available_in']."-sdfsfsdf";
        echo "</pre>";
        die();*/

        if (!empty($preferences)) {

            if (($preferences['available_in'] == "A4" || $preferences['available_in'] == "A3" || $preferences['available_in'] == "SRA3" || $preferences['available_in'] == "A5") and $preferences['categorycode_a4'] != '') {
                $cat_desc = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", $preferences['selected_size']);
                $cat_desc = explode("-", $cat_desc);
                $preferences['cat_desc_a4'] = $cat_desc[0];
                $preferences['cat_desc_roll'] = '';

                $dataProdu = $this->orderModal->getProductData($preferences['productcode_a4']);
                $preferences['ProductID'] = $dataProdu[0]->ProductID;
                $preferences['ManufactureID'] = $dataProdu[0]->ManufactureID;

                $category_id = $preferences['selected_size'];


                $row = $this->db->query(" Select * from category WHERE CategoryID LIKE '" . $category_id . "' ")->row_array();

                if ($row['Shape_upd'] == "Circular") {
                    $label_size = ucwords(str_replace("Label Size:", "", $row['specification3']));
                    $label_size = str_replace("Mm", "", $label_size);
                } else {
                    $label_size = $row['LabelWidth'] . " x " . $row['LabelHeight'];
                    $label_size = str_replace("mm", "", $label_size);

                }
                $data['label_size'] = $label_size;

                $printing_process = $this->orderModal->get_digital_printing_process('a4');
                $data['printing_process'] = $printing_process;
                $data['availabel_in'] = $preferences['available_in'];
                $data['preferences'] = $preferences;

//                $condition = " p.CategoryID LIKE '" . $preferences['selected_size'] . "' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
//                $condition .= " AND Adhesive LIKE '" . $preferences['adhesive_a4'] . "'";
//                $condition .= " AND Material1 LIKE '" . $preferences['color_a4'] . "'";
//                $condition .= " AND ColourMaterial_upd LIKE '" . $preferences['material_a4'] . "'";
//
//                $query = " Select * from products p,category c WHERE $condition AND SUBSTRING_INDEX(p.CategoryID,'R',1) = c.CategoryID";
//                $data['sheetdetails'] = $this->db->query($query)->row_array();
//                $data['details'] = $this->db->query($query)->row_array();
//                $data['sheetdetails'] = $this->db->query($query)->row_array();
                $data['details'] = $dataProdu;

//                echo"<pre>";print_r($data['rolldetails']);die;


                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/printing_process_sheet', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
                $data['printing_process_content'] = $theHTMLResponse;
                $finishHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/label_finish_and_embellishment', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
                $data['finish_content'] = $finishHTMLResponse;

                $cartSummeryHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
                $data['cart_summery'] = $cartSummeryHTMLResponse;

//                $artworkUploadHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/artwork_upload', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
//                $data['artwork_upload_view'] = $artworkUploadHTMLResponse;
            }
            if ($preferences['available_in'] == "Roll" and $preferences['categorycode_roll'] != '') {
                $catID = explode("R", $preferences['selected_size']);
                $preferences['cat_desc_a4'] = '';
                $preferences['cat_desc_roll'] = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", $catID[0]);

                $dataProdu = $this->orderModal->getProductData($preferences['productcode_roll']);

                $preferences['ProductID'] = $dataProdu[0]->ProductID;
                $preferences['ManufactureID'] = $dataProdu[0]->ManufactureID;
                $category_id = explode('R', $preferences['selected_size']);
                $category_id = $category_id[0];
                $rollcores = $this->orderModal->roll_core_sizes($category_id, $preferences['coresize']);
                $data['roll_cores'] = $rollcores;


//                $condition = " p.CategoryID LIKE '" . $preferences['selected_size'] . "' AND p.Activate LIKE 'Y'  AND p.Printable LIKE 'Y' ";
//                $condition .= " AND Adhesive LIKE '" . $preferences['adhesive_roll'] . "'";
//                $condition .= " AND Material1 LIKE '" . $preferences['color_roll'] . "'";
//                $condition .= " AND ColourMaterial_upd LIKE '" . $preferences['material_roll'] . "'";
//
//                $query = " Select * from products p,category c WHERE $condition AND SUBSTRING_INDEX(p.CategoryID,'R',1) = c.CategoryID";
//                $data['rolldetails'] = $this->db->query($query)->row_array();
//                $data['details'] = $this->db->query($query)->row_array();
                $data['details'] = $dataProdu;
                //echo"<pre>";print_r($data['details'][0]->ProductID);die;

                $row = $this->db->query(" Select * from category WHERE CategoryID LIKE '" . $category_id . "' ")->row_array();

                if ($row['Shape_upd'] == "Circular") {
                    $label_size = ucwords(str_replace("Label Size:", "", $row['specification3']));
                    $label_size = str_replace("Mm", "", $label_size);
                } else {
                    $label_size = $row['LabelWidth'] . " x " . $row['LabelHeight'];
                    $label_size = str_replace("mm", "", $label_size);

                }
                $data['label_size'] = $label_size;

                $printing_process = $this->orderModal->get_digital_printing_process('roll');
                $data['printing_process'] = $printing_process;
                $data['availabel_in'] = $preferences['available_in'];
                $data['preferences'] = $preferences;

                $theHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/printing_process', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
                $data['printing_process_content'] = $theHTMLResponse;

                $finishHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/label_finish_and_embellishment', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
                $data['finish_content'] = $finishHTMLResponse;

                $cartSummeryHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/cart_summery', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
                $data['cart_summery'] = $cartSummeryHTMLResponse;

//                $artworkUploadHTMLResponse = $this->load->view('order_quotation/label_embellishment_print_service/label_emb_page/artwork_upload', $data, true);
//                $json_data = array('content' => $theHTMLResponse);
//                $data['artwork_upload_view'] = $artworkUploadHTMLResponse;

//                $data['main_content'] = 'order_quotation/label_embellishment_Print_service/label_emb_page/printing_process_and_product';
//                $this->load->View('page', $data);

            }



            if ($preferences['available_in'] == "both" and ($preferences['categorycode_roll'] != '' || $preferences['categorycode_a4'] != '')) {
                $catID = explode(",", $preferences['selected_size']);

                $cat_desc = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", $catID[0]);
                $cat_desc = explode("-", $cat_desc);
                $preferences['cat_desc_a4'] = $cat_desc[0];

                $preferences['cat_desc_roll'] = $this->home_model->get_db_column("category", "CategoryDescription", "CategoryID", substr($catID[1], 0, -2));
            }





            $finish_PricePrintedLabel = json_decode($line_detail->FinishTypePricePrintedLabels);
            $history['selected_already_plates'] = [];
            $history['selected_already_plates_composite_array'] = [];
            $i=0;
            foreach ($finish_PricePrintedLabel as $selectedOptions){
                if ($selectedOptions->use_old_plate == 1){
                    $selected_plate_orderNumber = $selectedOptions->used_plate_orderNumber;
                    $selecte_parsed_row = $this->home_model->label_embelishment_with_parent_title($selectedOptions->finish_parsed_title);
                    $child_id = $selecte_parsed_row[0]->id;
                    $parent_id = $selecte_parsed_row[0]->label_emb_parent_id;
                    $parsed_title = $selecte_parsed_row[0]->parsed_title;
                    array_push($history['selected_already_plates'],$child_id);

                    $purchased_plate_history  = $this->home_model->get_db_column('customers', 'purchased_plate_history', 'UserID', $history['user_id']);
                    $purchased_plate_history = json_decode($purchased_plate_history);

                    foreach ($purchased_plate_history as $purchased_plate){
                        if ($parsed_title == $purchased_plate->purchased_plate && $selected_plate_orderNumber == $purchased_plate->order_number){
                            $history['selected_already_plates_composite_array'][$i] = json_encode(array('already_used_plate_id'=>(int)$child_id,'plate_order_no'=>$selected_plate_orderNumber));
                            $i++;
                        }
                    }
                }
            }
            $history['selected_already_plates'] = json_encode($history['selected_already_plates']);

            $hostory_plates_content = $this->purchased_plate_history_selected($history);
            $data['hostory_plates_content'] = $hostory_plates_content;


            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('response' => 'yes', 'preferences' => $preferences, 'data' => $data)));
        } else {

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('response' => 'no')));
        }
    }






    // NAFEES CART PAGE EDIT STARTS

    function addPrintingPreferences_cart_page()
    {

        /*echo '<pre>';
        print_r($_POST); exit;*/
        if ($_POST) {
            $catid = $this->input->post('CategoryID');
            $details = $this->home_model->fetch_category_details($catid);
            //print_r($details); exit;
            $coresize = $this->input->post('coresize');
            //print_r($coresize); exit;
            $categorycodea4 = array($details['CategoryImage']);
            $categorycoderoll = '';
            $rollcode = '';
            $A4code = '';
            $code = explode('.', $details['CategoryImage']);
            $userData = $this->user_model->get_data();
            //$selected_size = $details['CategoryID'].$coresize;
            $selected_size = $this->input->post('selected_size');
            $email = $userData['UserEmail'];
            $material = $this->input->post('material');
            $color = $this->input->post('color');
            $adhesive = $this->input->post('adhesive');
            $shape = $details['Shape_upd'];
            $min_width = floor($details['Width']);
            $max_width = ceil($details['Width']);
            $min_height = floor($details['Height']);
            $max_height = ceil($details['Height']);
            /*$dieCode = explode(".",$details['PDF']);
            $dieCode = $dieCode[0];*/
            $dieCode = $this->input->post('dieCode');


            $type = $this->input->post('type');
            /*if ($type == 'A4' || $type == 'A3' || $type == 'SRA3' || $type == 'A5') {
                $condtion = " CategoryActive = 'Y' AND Shape != '' AND ( labelCategory LIKE 'Roll Labels' ) ";
                $final_condition = $condtion . " AND CategoryImage LIKE '%" . $diecode . "%'";
            }else{
                $condtion = " CategoryActive = 'Y' AND Shape != '' AND ( labelCategory LIKE 'Roll Labels' ) ";
                $final_condition = $condtion . " AND CategoryImage LIKE '%" . $diecode . "%'";
            }

            $data['records'] = $this->home_model->get_print_sizes($final_condition, $limit);*/


            $no_of_labels = $this->input->post('no_of_labels');

            $shape = $this->input->post('shape');
            $productcode = $this->input->post('productcode');

            $source = $this->input->post('source');
            $available_in = $this->input->post('available_in');
            $no_of_rolls = $this->input->post('no_of_rolls');

            /*
            $email = $this->input->post('email');
            */
            $woundoption = $this->input->post('woundoption');
            //$orientation = "orientation1";

            if ($woundoption == "Inside") {
                $orientation = 'orientation5';
            }

            //print_r($type); exit;
            // IN CASE OF ROLLS ENDS HERE
            //print_r('a'); exit;
            if ($type == 'A4' || $type == 'A3' || $type == 'SRA3' || $type == 'A5') {
                $pref = array(
                    'email' => $email,
                    'sessionID' => $this->session->userdata('session_id'),
                    'shape' => $shape,
                    'min_width' => $min_width,
                    'max_width' => $max_width,
                    'max_height' => $max_height,
                    'min_height' => $min_height,
                    'labels_a4' => $no_of_labels,
                    'source' => $source,
                    'opposite' => "false",
                    'selected_size' => $selected_size,
                    'available_in' => $available_in,
                    'categorycode_a4' => $dieCode,
                    'productcode_a4' => $productcode,
                    'material_a4' => $material,
                    'adhesive_a4' => $adhesive,
                    'color_a4' => $color,
                    'digital_proccess_a4' => "",
                    'finish_a4' => "",
                );
            } else if ($type == 'Rolls') {

                $pref = array(
                    'sessionID' => $this->session->userdata('session_id'),
                    'source' => $source,
                    'productcode_roll' => $productcode,
                    'shape' => '',
                    'email' => $email,

                    'min_width' => $min_width,
                    'max_width' => $max_width,
                    'max_height' => $max_height,
                    'min_height' => $min_height,

                    'labels_roll' => $no_of_labels,
                    'opposite' => "false",
                    'selected_size' => $selected_size,
                    'available_in' => $available_in,
                    'categorycode_roll' => $dieCode,

                    'material_roll' => $material,

                    'no_of_rolls' => $no_of_rolls,

                    'digital_proccess_roll' => "",
                    'finish_roll' => "",
                    'orientation' => $orientation,

                    'adhesive_roll' => $adhesive,
                    'color_roll' => $color,
                    'coresize' => $coresize,
                    'wound_roll' => $woundoption
                );
            }


            echo $this->orderModal->addPrintingPreferences($pref);
        }
    }



    public function getCartAndProductData($temp_basket_id) {
    	
		if( isset($temp_basket_id) && $temp_basket_id != '' ) {
			$cartData = $this->orderModal->getCartDataAgainstId($temp_basket_id);
			return $cartData;
		}
    }

    function generate_preferences_data_edit_cart_flag($line_detail){
	    
	    $preferences = array();
	    $preferences['ProductID'] = $line_detail['ProductID'];
	    $preferences['ManufactureID'] = $line_detail['ManufactureID'];
	    $preferences['manuid'] = $line_detail['ManufactureID'];

	    if ($line_detail['ProductBrand'] == 'Roll Labels'){
	        $preferences['available_in'] = 'Roll';
	        $preferences['manuid'] = substr($line_detail['ManufactureID'], 0, -1);
	    } elseif ($line_detail['ProductBrand'] == 'A4 Labels'){
	        $preferences['available_in'] = 'A4';
	    }elseif ($line_detail['ProductBrand'] == 'A5 Labels'){
	        $preferences['available_in'] = 'A5';
	    }elseif ($line_detail['ProductBrand'] == 'A3 Label'){
	        $preferences['available_in'] = 'A3';
	    }elseif ($line_detail['ProductBrand'] == 'SRA3 Label'){
	        $preferences['available_in'] = 'SRA3';
	    } else{
	        $preferences['available_in'] = 'Integrated';
	    }

	    //$preferences['selected_size'] = substr($line_detail->CategoryID, 0, -2);
	    $preferences['selected_size'] = $line_detail['CategoryID'];
	    $preferences['digital_proccess_roll'] = $line_detail['Print_Type'];
	    $preferences['material_code'] = $this->home_model->getmaterialcode($preferences['manuid']);
	    $preferences['die_code'] = $this->home_model->getdiecode($preferences['manuid']);
	    $material_data = $this->home_model->get_material_data_cart_page($preferences['material_code'],$preferences['available_in']);

	    if ($preferences['available_in'] == 'Roll'){
	        $preferences['coresize'] = "R".substr($line_detail['ManufactureID'], -1, 1);
	        $preferences['productcode_roll'] = $line_detail['ManufactureID'];
	        $preferences['Orientation'] = $line_detail['orientation'];
	        $preferences['wound_roll'] = $line_detail['wound'];
	        $preferences['color_roll'] = $material_data['material_name'];
	        $preferences['material_roll'] = $line_detail['ColourMaterial_upd'];
	        $preferences['categorycode_roll'] = $preferences['die_code'].$preferences['coresize'];
	        $preferences['adhesive_roll'] = $material_data['adhesive'];
	        $preferences['labels_roll'] = $line_detail['orignalQty'];
	        $preferences['quantity'] = $line_detail['Quantity'];
	    } else {
	        $preferences['productcode_a4'] = $line_detail['ManufactureID'];
	        $preferences['color_a4'] = $material_data['material_name'];
	        $preferences['material_a4'] = $line_detail['ColourMaterial_upd'];
	        $preferences['categorycode_a4'] = $preferences['die_code'];
	        $preferences['adhesive_a4'] = $material_data['adhesive'];
	        $preferences['labels_a4'] = $line_detail['orignalQty'];
	        $preferences['quantity'] = $line_detail['Quantity'];
	    }

	    return $preferences;
	}


    // NAFEES CART PAGE EDIT ENDS






    /***************************************************/
    /***********LABEL EMBELLISHMENT TASK ENDS***********/
    /***************************************************/



}