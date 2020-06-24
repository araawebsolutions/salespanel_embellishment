<?php
/*Filter Model For aalabels - Author: Arslan Javaid - 24-04-2018 */ 
class Filter_model extends CI_Model{

	
	function __construct(){

		parent::__construct();
	}

	function generate_category_shapes($decode = NULL){
		$shapes = $this->db->query("SELECT DISTINCT(Shape) AS Shapes,`labelCategory` from category 
		WHERE CategoryActive = 'Y' AND (displayin = 'both' OR displayin= 'backoffice') AND Shape != '' ORDER BY Shape ASC ")->result();
		$shape_list = array();
		foreach($shapes as $row){
			$row->labelCategory  = str_replace(" ", "", $row->labelCategory);
			$row->labelCategory  = str_replace("Labels", "", $row->labelCategory);
			$row->labelCategory  = str_replace("Label", "", $row->labelCategory);
			$shape_list[$row->labelCategory][] = $row->Shapes;
			
		}
		if($decode == 'no'){ return $shape_list;}
		//return $shape_list;
		return json_encode($shape_list);
	}
	function get_min_width_height($field, $condition) {

       $qry = "SELECT MAX($field) as `max`,MIN($field) as `min` from products p 
	   where $field != '' AND p.Activate = 'Y'  AND (p.displayin = 'both' OR p.displayin= 'backoffice') AND $condition";
        
        $query = $this->db->query($qry);
        $result = $query->row_array();
        return $result;
    }

	function labelsfinder_field_list($field, $condition){
					$qry =  "SELECT $field from products p where $field != '' and p.Activate = 'Y'  AND ( p.displayin = 'both' OR p.displayin= 'backoffice') 
					AND $condition group by $field order by $field ASC";
					$query  = $this->db->query($qry);
					$result = $query->result();
					return $result;
	}
	function labelfinder_counter($condition,$groupby=NULL){
				
			if($groupby){
				$qry = "SELECT count(DISTINCT(LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ))) as total FROM products p 
				WHERE  ".$condition."  AND p.Activate = 'Y' AND ( p.displayin = 'both' OR p.displayin= 'backoffice')";
			}else{
				$qry = "SELECT count(*) as total FROM products p WHERE ".$condition."  AND p.Activate = 'Y' AND (p.displayin = 'both' OR p.displayin= 'backoffice')";
			}	
			$query  = $this->db->query($qry);
			$result = $query->row_array();
			return $result['total'];		  
	}

    function labelfinder_data($condition,$sort=NULL,$start =NULL,$groupby=NULL){

        if($sort!=NULL){
            $sort = ' Order by LabelsPerSheet '.$sort;
        }else{
            $sort = ' Order by LabelsPerSheet ASC';
        }
        if($start==NULL){ $start = 0;}
        /*$qry =  "SELECT p.ManufactureID,SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) as CategoryID,
        p.ProductID,p.ManufactureID, p.ProductName,p.ProductBrand,p.ProductCategoryName,p.LabelsPerSheet,
        p.shape as Shape,p.pwidth as Width,p.pheight as Height,p.SpecText7 FROM products p
        WHERE ".$condition." AND p.Activate = 'Y' $groupby $sort limit $start ,12";*/

        $qry =  "SELECT p.ManufactureID,SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) as CategoryID,
						  p.ProductID,p.ManufactureID, p.ProductName,p.ProductBrand,p.ProductCategoryName,p.LabelsPerSheet,c.CategoryName,c.InnerHole,c.InnerLabel,c.Width,
						  p.shape as Shape,p.pwidth as Width,p.pheight as Height,p.SpecText7 FROM products p,category c
						  WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND ".$condition." AND p.Activate = 'Y' AND (p.displayin = 'both' OR p.displayin= 'backoffice') $groupby $sort limit $start ,12";

        //die($qry);
        $query  = $this->db->query($qry);
		
        return $query->result();

    }
	function fetch_dies_data($condition, $sort=NULL,$limit=NULL){
				
				$sort = ' Order by (LabelAcross*LabelAround) ASC';
				
				
				$condition = str_replace('p.ProductBrand','c.labelCategory', $condition);
				$condition = str_replace('p.CategoryID','c.CategoryID', $condition);
				$condition = str_replace('p.shape','c.Shape', $condition);
				$condition = str_replace('p.Shape','c.Shape', $condition);
				$condition = str_replace('p.pwidth','c.Width', $condition);
				$condition = str_replace('p.pheight','c.Height', $condition);
				$condition = str_replace("p.Corners LIKE 'No'","c.LabelCornerRadius LIKE '0 mm' ", $condition);
				$condition = str_replace("p.Corners LIKE 'Yes'","c.LabelCornerRadius NOT LIKE '0 mm' ", $condition);
				
				$qry2 = $this->db->query("SELECT c.CategoryID,c.InnerHole,c.InnerLabel,c.specification1,c.specification2,c.specification3,c.pdfFile,
				c.wordFile, c.CategoryName, c.CategoryImage,c.Width,c.LabelWidth,c.LabelHeight,c.Shape,c.labelCategory as ProductBrand 
				FROM category c 
				WHERE ((c.CategoryActive LIKE 'Y' OR c.CategoryActive LIKE 'y') AND (displayin='both' OR displayin='backoffice')) AND ".$condition." GROUP BY c.CategoryID $sort $limit");
				
		
				
				/*$qry2 = $this->db->query("SELECT SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) as CategoryID,
				p.pwidth as LabelWidth,p.pheight as LabelHeight,p.shape as Shape,p.ProductName,p.ManufactureID,
				p.ProductID,p.SpecText7,p.ProductBrand 
				FROM products p 
				WHERE ".$condition." GROUP BY SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) $sort $limit");*/
				
				
				$data = array('num_row' => $qry2->num_rows(), 'list' => $qry2->result());
				return $data;
	}
	
	function newlabel_filter($field, $condition)
	{
		$qry =  "SELECT $field from label_filters p where $condition AND $field!='' group by $field order by $field ASC";
		$query  = $this->db->query($qry);
		$result = $query->result();
		return $result;
		
	}
	
	/**************** Material Pages ***************************/
    function distinct_material_paper($condtion,$brand = ""){
        $type = $this->input->post('type');
        $field = "priority";
        $type_cond = "";
        $group_type = " AND type LIKE '%A4%'";

        if((isset($type) and $type == "Rolls") || $brand == "Rolls")
        {
            $field = "priority_rolls";
            $group_type = $type_cond = " AND type LIKE '%Rolls%'";
        }
        else if((isset($type) and $type == "A4") || $brand == "A4")
        {
            $group_type = $type_cond = " AND type LIKE '%A4%'";
        }
        else if((isset($type) and $type == "A3") || $brand == "A3")
        {
            $group_type = $type_cond = " AND type LIKE '%A3%'";
        }
        else if((isset($type) and $type == "SRA3") || $brand == "SRA3")
        {
            $group_type = $type_cond = " AND type LIKE '%SRA3%'";
        }

        $query=$this->db->query("SELECT DISTINCT(filter_group) as Material, (SELECT COUNT(DISTINCT(filter_color)) AS count FROM `material_tooltip_info` WHERE filter_group = Material $group_type GROUP BY filter_group) AS count, SpecText7, SpecText7_rolls FROM `material_tooltip_info` WHERE $condtion $type_cond and filter_group!='' Group by filter_group order by $field asc");
        return $query->result();

    }
	function distinct_material_adhisive($condtion){
	     
		  $query=$this->db->query("SELECT DISTINCT(ahesive) AS Adhesive FROM `products_adhesive` WHERE $condtion
		  						   and ahesive!='' order by ahesive asc");
		  return $query->result();
	}
    function distinct_material_color($condtion, $brand = ""){
        $type = $this->input->post('type');
        $field = "priority";
        $type_cond = "";
        if((isset($type) and $type == "Rolls") || $brand == "Rolls")
        {
            $field = "priority_rolls";
            $type_cond = " AND type LIKE '%Rolls%'";
        }

        $query=$this->db->query("SELECT DISTINCT(filter_color) AS Color,SpecText7,SpecText7_rolls, GROUP_CONCAT(DISTINCT(adhesive) SEPARATOR ' / ') as adhesive FROM `material_tooltip_info` WHERE $condtion and filter_color!='' GROUP BY filter_color order by Color asc");

        return $query->result();
    }
	function grouping_material_listing($condtion){
		$query=$this->db->query("SELECT * FROM `products_colour` WHERE $condtion 
		GROUP BY CONCAT(finish_type,'',material_type) order by priority asc ");
		return $query->result();
	}
	
	function get_compatibility_text($product){
		return $this->db->query(" Select description,print_method,type from materials_compatibility 
		WHERE product LIKE '".$product."' ")->result();
	}
	
	function grouping_compatiblity($compatible, $data){
			if(preg_match("/\bDirect Thermal\b/i", $compatible)){
				   $d_thermal_img= 'd-thermal-check.png';
				   $d_thermal_text = $data['DirectThermal']['COMPATIBLE'];
			}
			else{
					$d_thermal_img= 'd-thermal-cross.png';
					$d_thermal_text = $data['DirectThermal']['INCOMPATIBLE'];
			}
			
			if(preg_match("/\bThermal Transfer\b/i", $compatible)){ 
					$thermal_img	= 'thermal-check.png';
					$thermal_text = $data['ThermalTransfer']['COMPATIBLE'];
			}
			else{
					$thermal_img	= 'thermal-cross.png';	
					$thermal_text = $data['ThermalTransfer']['INCOMPATIBLE'];
			}
			if(preg_match("/Laser/i", $compatible)){ 
					$laser_img= 'laser-check.png';
					$laser_text = $data['Laser']['COMPATIBLE'];
			}
			else{
					$laser_img= 'laser-cross.png';
					$laser_text = $data['Laser']['INCOMPATIBLE'];
			}
			if(preg_match("/\bInkjet\b/i", $compatible)){ 
					$inkjet_img= 'inkjet-check.png';
					$inkjet_text = $data['Inkjet']['COMPATIBLE'];
			}
			else{
					$inkjet_img= 'inkjet-cross.png';
					$inkjet_text = $data['Inkjet']['INCOMPATIBLE'];
			}
			return array('inkjet_img'=>$inkjet_img,
						 'inkjet_text'=>$inkjet_text,
						 'laser_img'=>$laser_img,
						 'laser_text'=>$laser_text,
						 'thermal_img'=>$thermal_img,
						 'thermal_text'=>$thermal_text,
						 'd_thermal_img'=>$d_thermal_img,
						 'd_thermal_text'=>$d_thermal_text,
						 );
			
	
	}
	
	
		function fetch_labelpersheet_data($condition, $type=NULL,$limit=NULL){
				if($type == "products")
				{
					$sort = ' Order by LabelPerDie ASC';
					$start = 0;
					$qry2 =  $this->db->query("SELECT p.LabelsPerSheet as LabelPerDie,COUNT(*) as count FROM products p WHERE ".$condition." AND p.Activate = 'Y' AND (p.displayin = 'both' OR p.displayin= 'backoffice') GROUP BY LabelPerDie $sort limit $start ,12");
					
					
				}
				else
				{
					$condition = str_replace('p.ProductBrand','c.labelCategory', $condition);
					$condition = str_replace('p.CategoryID','c.CategoryID', $condition);
					$condition = str_replace('p.shape','c.Shape', $condition);
					$condition = str_replace('p.Shape','c.Shape', $condition);
					$condition = str_replace('p.pwidth','c.Width', $condition);
					$condition = str_replace('p.pheight','c.Height', $condition);
					$condition = str_replace("p.Corners LIKE 'No'","c.LabelCornerRadius LIKE '0 mm' ", $condition);
					$condition = str_replace("p.Corners LIKE 'Yes'","c.LabelCornerRadius NOT LIKE '0 mm' ", $condition);
					$sort = ' Order by (LabelAcross*LabelAround) ASC';
					$qry2 = $this->db->query("SELECT c.LabelAcross*c.LabelAround as LabelPerDie, COUNT(*) as count
				FROM category c WHERE ( (c.CategoryActive LIKE 'Y' OR c.CategoryActive LIKE 'y') AND (displayin= 'both' OR displayin='backoffice')) AND "
                        .$condition." GROUP BY LabelPerDie $sort $limit");
				
				}
				//echo $this->db->last_query();exit;
				$data = array('num_row' => $qry2->num_rows(), 'list' => $qry2->result());
				return $data;
	}
	
}