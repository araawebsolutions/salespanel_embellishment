<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class searchModal extends CI_Model {


   
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   


    function category_shapes($condition){

        $shapes = $this->db->query("SELECT DISTINCT(LOWER (c.Shape)) AS Shapes from category c , products p 
        WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND ".$condition);
        return $shapes->result();
    }

    public function getRecords($field,$type){
        $material = $this->db->query("SELECT DISTINCT  $field from label_filters p WHERE $type ");
        return $material->result();
    }

    function get_min_width_height($field, $condition) {
        // print_r($condition);exit;
        $qry = "SELECT MAX($field) as `max`,MIN($field) as `min` from products 
	   where $field != '' and (Activate ='Y' or Activate ='y' || displayin='both' || displayin='backoffice' ) AND ProductBrand LIKE '$condition'";

        $query = $this->db->query($qry);
        $result = $query->row_array();
        return $result;
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
						  p.ProductID,p.ManufactureID, p.ProductName,p.ProductBrand,p.ProductCategoryName,
						  p.LabelsPerSheet,'' AS InnerHole,'' AS InnerLabel,
						  p.shape as Shape,p.pwidth as Width,p.pheight as Height,p.SpecText7 
						  FROM products p,category c
						  WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND ".$condition." AND (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice') $groupby $sort limit $start ,12";

        //die($qry);
        $query  = $this->db->query($qry);
        $data = array('num_row' => $query->num_rows(), 'list' => $query->result());
        return $data;
    }























































// copied function


    function make_productBrand_condtion($type){







        if(preg_match("/SRA3/i",$type)){



            $brand = 'SRA3 Label';



        }



        else if(preg_match("/A3/i",$type)){



            $brand = 'A3 Label';



        }



        else if(preg_match("/Roll/i",$type)){



            $brand = 'Roll Labels';



        }



        else if(preg_match("/Integrated/i",$type)){



            $brand = 'Integrated Labels';



        }



        else{



            $brand = 'A4 Labels';



        }







        return $brand;



    }


}
