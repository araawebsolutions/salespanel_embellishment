<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class search extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('search/searchModal');
        $this->load->model('cart/cartModal');
        $this->load->model('order_quotation/quotationModal');
        $this->load->model('quoteModel');
        $this->home_model->user_login_ajax();
        //error_reporting(E_ALL);
    }

    public function getSearch($type = NULL, $shape = NULL)
    {

        $data['type'] = 'A5';
        $data['shape'] = $shape;
        $searchPage['html'] = $this->takeHtmlAndPrintData('order_quotation/format', $data);
        echo json_encode($searchPage);
    }

    function material($catid = null, $pageName = null, $regmark = null, $productid = NULL, $shape = null)
    {

        $new_code_exp = array();
        $catid = ($catid != null) ? $catid : $this->input->post('catid');
        $productid = ($productid != null) ? $productid : $this->input->post('productid');
        $regmark = ($regmark != null) ? $regmark : $this->input->post('regmark');
        $pageName = ($pageName != null) ? $pageName : $this->input->post('pageName');

        $printer_condition = '';
        $other_material_option = '';
        $data['other_materials'] = '';

        if ($regmark != "yes") {
            $regmark = "no";
        }
        /*print_r($catid); exit;
        $data['Category_ID'] = $catid;*/

        if (preg_match('/^c/i', $catid)) {
            $catid = strtoupper($catid);
            //print_r($catid); exit;
            $core = 'R1';
            $coreinURL = '';
            if (substr($catid, -2, 1) == 'R') {

                if (preg_match('/r1|r2|r3|r4|r5/is', $catid)) {
                    $new_code_exp = explode("R", $catid);
                    $catid = $new_code_exp[0];
                    $core = 'R' . $new_code_exp[1];
                    $coreinURL = $core = 'R' . $new_code_exp[1];
                }

            }
            //print_r(11); exit;

            $condition = " CategoryID ='$catid'";
            $data['details'] = $this->home_model->fetch_category_details($catid);
            /*echo '<pre>';
            print_r($data['details']);
            exit;*/
            if (isset($productid) and $productid != '') {

                $menuid = $this->home_model->getManufactureID($productid);

                $coreid = substr($menuid, -1);
                // print_r($new_code_exp);exit;
                if (isset($new_code_exp[1]) && ($new_code_exp[1] != '')) {
                    $coreinURL = $core = 'R' . $new_code_exp[1];
                } else {
                    $coreinURL = $core = 'R';
                }



                /********* New product code selection code ********/
                if (isset($new_code_exp[1]) and $new_code_exp[1] != '') {
                    $defaultcore = 'R' . $coreid;
                    if ($coreinURL != $defaultcore) {
                        $core = 'R' . $new_code_exp[1];
                        $menuid = substr($menuid, 0, -1);
                        $menuid = $menuid . $new_code_exp[1];
                        $productid = $this->home_model->get_db_column('products', 'ProductID', 'ManufactureID', $menuid);
                    }
                }
                /*************************************************/

                $data['coreid'] = $core;
            } else {
                $data['coreid'] = $core;
            }

            //print_r($coreinURL); exit;
            //$data['Category_ID'] = $catid;
            $data['rollcores'] = $this->home_model->roll_core_sizes($catid, $core);
            $catid = $catid . $core;

            $data['subcat'] = $catid;
            $data['coreinURL'] = $coreinURL;
            $data['main_content'] = 'order_quotation/material/material_roll';


            $printer = $this->input->get('printer');
            if (isset($printer) and $printer != '') {

                $data['printer_model'] = urldecode($printer);

                $query = $this->db->query("SELECT method FROM `printers_model` WHERE model LIKE '" . urldecode($printer) . "' LIMIT 1 ");
                $model_array = $query->row_array();
                $method = str_replace("/", "<br>", $model_array['method']);

                //$printer_condition = 'AND (';


                if (preg_match("/\bThermal Transfer\b/i", $method)) {
                    $printer_condition .= " SpecText7 LIKE '%Thermal Transfer%' OR";
                    $other_material_option .= " SpecText7 NOT LIKE '%Thermal Transfer%' AND";
                }
                if (preg_match("/\bInkjet\b/i", $method)) {
                    $printer_condition .= "  SpecText7 LIKE '%Inkjet%' OR";
                    $other_material_option .= " SpecText7 NOT LIKE '%Inkjet%' AND";
                }
                if (preg_match("/\bDirect Thermal\b/i", $method)) {
                    $printer_condition .= " SpecText7 LIKE '%Direct Thermal%' OR";

                    if ($other_material_option) {
                        $other_material_option .= " SpecText7 NOT LIKE '%Direct Thermal%' AND";
                    } else {
                        $other_material_option = "";
                    }
                }

                if ($printer_condition) {
                    $printer_condition = " AND ( " . substr($printer_condition, 0, -2) . " )";
                }

                if ($other_material_option) {
                    $other_material_option = " AND ( " . substr($other_material_option, 0, -3) . " )";
                    $other_material_option = " CategoryID ='$catid' " . $other_material_option;
                    //$data['other_materials'] = $this->home_model->ajax_material_sorting($other_material_option);
                    $data['othermaterials'] = $this->home_model->grouping_material_listing($other_material_option);
                }

            }


        } else {

            $data['details'] = $this->home_model->fetch_category_details($catid);
            $data['compitable'] = $this->home_model->avery_equilent($catid);
            $data['main_content'] = 'order_quotation/material/material';
        }


        if (isset($productid) and $productid != '') {
            $condition = " CategoryID ='$catid' AND ProductID <> '$productid'";
            $data['productid'] = $productid;
            $data['materials'] = $this->home_model->fetch_sheets_materials($catid, $productid);

            

            $data['othermaterials'] = $this->home_model->grouping_material_listing($condition);
            $data['filter'] = '';

            if ($data['details']['labelCategory']) {
                $brand = str_replace("Labels", "", $data['details']['labelCategory']);
                $brand = str_replace("labels", "", $brand);
                $brand = str_replace("Label", "", $brand);
                $brand = str_replace(" ", "", $brand);
                $brand = trim($brand);
                if (preg_match("/roll/is", $brand)) {
                    $brand = 'Rolls';
                }
                $newcondition = " type LIKE '%" . $brand . "%'";
                if (isset($data['materials']['ColourMaterial']) && $data['materials']['ColourMaterial']) {
                    $newcondition .= " AND material_type LIKE '" . $data['materials']['ColourMaterial'] . "'";
                }
                if (isset($data['materials']['LabelFinish']) && $data['materials']['LabelFinish']) {
                    $newcondition .= " AND finish_type LIKE '" . $data['materials']['LabelFinish'] . "'";
                }
                //if($data['materials']['LabelColor']){}
            }

            if (isset($data['details']['CategoryID']) and $data['details']['CategoryID'] != '') {
                $data['paper'] = $this->filter_model->distinct_material_paper($newcondition);
                $data['adhesive'] = $this->filter_model->distinct_material_adhisive($newcondition);
                $data['color'] = $this->filter_model->distinct_material_color($newcondition);

            }
            //$data['paper'] = $this->home_model->distinct_material_paper($condition);
            //$data['adhesive'] = $this->home_model->distinct_material_adhisive($condition);
            //$data['color'] = $this->home_model->distinct_material_color($condition);

        } else {
            $condition = " CategoryID ='$catid' " . $printer_condition;
            $data['filter'] = '';

            //$data['paper'] = $this->home_model->distinct_material_paper($condition);
            //$data['adhesive'] = $this->home_model->distinct_material_adhisive($condition);
            //$data['color'] = $this->home_model->distinct_material_color($condition);

            if ($data['details']['labelCategory']) {
                $brand = str_replace("Labels", "", $data['details']['labelCategory']);
                $brand = str_replace("labels", "", $brand);
                $brand = str_replace("Label", "", $brand);
                $brand = str_replace(" ", "", $brand);
                $brand = trim($brand);
                if (preg_match("/roll/is", $brand)) {
                    $brand = 'Rolls';
                }
                $newcondition = " type LIKE '%" . $brand . "%'";
            }

            if (isset($data['details']['CategoryID']) and $data['details']['CategoryID'] != '') {
                $data['paper'] = $this->filter_model->distinct_material_paper($newcondition);
                $data['adhesive'] = $this->filter_model->distinct_material_adhisive($newcondition);
                $data['color'] = $this->filter_model->distinct_material_color($newcondition);
                $data['materials'] = $this->home_model->grouping_material_listing($condition);
                //$data['materials'] = $this->home_model->fetch_sheets_materials($catid,);
            }
        }
        /*echo '<pre>';
        print_r($data['materials']);
        exit;*/
        $shape_in_url = $this->uri->segment(2);
        if (!isset($data['details']['CategoryID']) and $data['details']['CategoryID'] == '') {
            $this->get_nearest_category($catid, $productid, $pageName, $regmark);
        }

//        else if(isset($shape_in_url) and strtolower($data['details']['Shape'])!=strtolower($shape_in_url)){
//
//            $url = $this->uri->segment(1);
//
//            $diecode = $this->uri->segment(3);
//
//            $product = '';
//            if(isset($productid) and $productid!=''){
//                $product = '?productid='.$productid;
//            }
//
//            $link = base_url().$url.'/'.strtolower($data['details']['Shape']).'/'.$diecode.$product;
//            header("HTTP/1.1 302 Found");
//            header("Location:".$link);
//            exit();
//            //redirect($link, 'location', 302);
//        }

        $data['regmark'] = $regmark;
        $data['productid'] = $productid;
        $SID = $this->shopping_model->sessionid();
        $items_array = array('SessionID' => $SID, 'status' => 'temp');
        $this->db->delete('integrated_attachments', $items_array);
         /*echo '<pre>';
         print_r($data['coreinURL']);exit;*/
        /*print_r($coreinURL);
        print_r('<br>');
        print_r($pageName); exit;*/
        $data['pageName'] = $pageName;
        $record['html'] = $this->takeHtmlAndPrintData($data['main_content'], $data);

        //print_r($record['html']); exit;

        echo json_encode($record);
    }

    function get_nearest_category($catid, $p_id, $pageName, $regmark)
    {

        $link = '';
        $query = $this->db->query("select count(*) as total,CategoryID,Shape,CategoryName,Width from category where CategoryID = '$catid' LIMIT 1");
        $row = $query->row_array();

        if ($row['total'] == 1) {

            if (preg_match("/Roll/", $row['CategoryName'])) {
                $url = 'roll-labels';
                $condition = 'Roll';
            } else if (preg_match("/SRA3/", $row['CategoryName'])) {
                $url = 'sra3-sheets';
                $condition = 'SRA3';
            } else if (preg_match("/A5/", $row['CategoryName'])) {
                $url = 'a5-sheets';
                $condition = 'A5';
            } else if (preg_match("/A3/", $row['CategoryName'])) {
                $url = 'a3-sheets';
                $condition = 'A3';
            } else {
                $url = 'a4-sheets';
                $condition = 'A4';
            }

            $shape = $row['Shape'];
            $query = $this->db->query("select CategoryID from category WHERE Shape LIKE '" . $row['Shape'] . "' 
				AND Width > " . ($row['Width'] - 100) . " AND  Width < " . ($row['Width'] + 100) . " AND  CategoryName LIKE '%" . $condition . "%' 
				AND (CategoryActive='Y' || displayin='both' || displayin='backoffice') ORDER BY Width ASC  LIMIT 1");
            $row = $query->row_array();

            if (isset($row['CategoryID']) and $row['CategoryID'] != '') {
                // $link = base_url().$url.'/'.strtolower($shape).'/'.strtolower($row['CategoryID']).'/';

                $this->material($row['CategoryID'], $pageName, $regmark, $p_id, $shape);
            }
        }

        if ($link == '') {
            // $link = $_SERVER["PHP_SELF"];
            $type = $this->uri->segment(1);
            $shape = $this->uri->segment(2);
            if (isset($type) and $type != '' and isset($shape) and $shape != '') {
                //$link =  $type.'/'.$shape;
                $this->material('', $pageName, $regmark, $p_id, $shape);
            } else if (isset($type)) {
                //$link =  $type;
                $this->material('', $pageName, $regmark, $p_id, $shape);
            }
            //  $link = base_url().$link.'/';
            $this->material('', $pageName, $regmark, $p_id, $shape);

        }
        //redirect($link, 'location', 302);
    }

    function delete_material_artworks()
    {
        $rolls = 0;
        $json_data = array('response' => 'no');
        if ($_POST) {

            $id = $this->input->post('fileid');

            $file = $this->home_model->get_db_column('integrated_attachments', 'file', 'ID', $id);
            @unlink(PATH . '/' . $file);

            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');


            $data['cartid'] = $cartid;
            $data['ProductID'] = $productid;
            $data['LabelsPerSheet'] = $persheet;
            $data['type'] = $type;

            $this->db->delete('integrated_attachments', array('ID' => $id));

            $response = $this->home_model->get_total_uploaded_qty($cartid, $productid);
            $designs = $this->get_uploaded_number_design($cartid, $productid);

            if ($type == 'rolls') {
                $data['presproof'] = $this->input->post('presproof');
                $data['gap'] = $this->input->post('gap');
                $data['size'] = $this->input->post('size');
                $theHTMLResponse = $this->load->view('order_quotation/material/upload/roll_artwork_files', $data, true);
                $total = $response['labels'];
                $rolls = $response['sheets'];


            } else {

                $data['unitqty'] = $this->input->post('unitqty');
                if ($data['unitqty'] == 'Labels') {
                    $total = $response['labels'];
                } else {
                    $total = $response['sheets'];
                }
                $theHTMLResponse = $this->load->view('order_quotation/material/upload/a4_artwork_files', $data, true);
            }


            $json_data = array('response' => 'yes',
                'qty' => $total,
                'rolls' => $rolls,
                'designs' => $designs,
                'content' => $theHTMLResponse);


        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));

    }

    function get_category_materials_newfilter()
    {

        if ($_POST) {
            $material_sel = '';
            $adhisive_sel = '';
            $color_sel = '';
            $color_sel = '';
            $labelsgap = '';
            $adhesive_option = '';
            $printer_condition = '';
            $wholesale = trim($this->input->post('wholesale'));

            $material_sel = trim($this->input->post('material'));
            $adhesive_sel = trim($this->input->post('adhesive'));
            $color_sel = trim($this->input->post('color'));
            $catid = trim($this->input->post('catid'));
            $productid = trim($this->input->post('productid'));
            $compatability = trim($this->input->post('compatiblity'));

            if (isset($compatability) and $compatability != '') {

                if (preg_match("/\bDirect Thermal\b/i", $compatability)) {
                    $printer_condition .= " SpecText7 LIKE '%Direct Thermal%' OR";
                }
                if (preg_match("/\bThermal Transfer\b/i", $compatability)) {
                    $printer_condition .= " SpecText7 LIKE '%Thermal Transfer%' OR";
                }
                if (preg_match("/\bInkjet\b/i", $compatability)) {
                    $printer_condition .= " AND SpecText7 LIKE '%Inkjet%' OR";
                }
                if ($printer_condition) {
                    $printer_condition = " AND ( " . substr($printer_condition, 0, -2) . " )";
                }
            }

            $product_condition = " CategoryID='$catid' " . $printer_condition;

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
            if (isset($productid) and strlen($productid) > 0) {
                //$condition .=" AND ProductID <> '".$productid."' ";
            }

            $material = '';
            $adhesive = '';
            $color = '';
            $type = '';

            if (isset($material_sel) and strlen($material_sel) > 0) {
                $material = " AND filter_group LIKE '" . $material_sel . "' ";
            }
            if (isset($adhesive_sel) and strlen($adhesive_sel) > 0) {
                $adhesive = " AND adhesive LIKE '" . $adhesive_sel . "' ";
            }
            if (isset($color_sel) and strlen($color_sel) > 0) {
                $color = " AND filter_color LIKE '" . $color_sel . "' ";
            }
            if (preg_match('/^c/i', $catid)) {
                $catid = strtoupper($catid);
                if (substr($catid, -2, 1) == 'R') {
                    if (preg_match('/r1|r2|r3|r4|r5/is', $catid)) {
                        $catid = explode("R", $catid);
                        $catid = $catid[0];
                    }
                }
            }
            $categoryName = $this->home_model->get_db_column('category', 'CategoryName', 'CategoryID', $catid);
            if (preg_match('/\bA3\b/', $categoryName)) {
                $type = "A3";
            } else if (preg_match('/\bA5\b/', $categoryName)) {
                $type = "A5";
            } else if (preg_match('/\bA4\b/', $categoryName)) {
                $type = "A4";
            } else if (preg_match('/\bSRA3\b/', $categoryName)) {
                $type = "SRA3";
            } else if (preg_match('/\bRoll\b/', $categoryName)) {
                $type = "Rolls";
            }

            if ($type != '') {
                $type = " AND type LIKE '%$type%'";
            }
            $paper_list = $this->filter_model->distinct_material_paper($condition . $adhesive . $color . $type, $type);
            $color_list = $this->filter_model->distinct_material_color($condition . $adhesive . $material . $type, $type);


            $color_option = $this->home_model->make_html_option_filter($color_list, 'Color', 'Sort By Colour', $color_sel);
            $paper_option = $this->home_model->make_html_option_filter($paper_list, 'Material', 'Sort By Material', $material_sel);

            $condition = $product_condition . $adhesive;
            //	$condition = $product_condition.$material.$adhesive.$color;

            $data['printer_compatiblity'] = trim($this->input->post('compatiblity'));
            $data['catid'] = trim($this->input->post('catid'));
            $data['Labelsgap'] = trim($this->input->post('labelsgap'));
            $data['max_diameter'] = trim($this->input->post('max_diameter'));
            $data['height'] = trim($this->input->post('height'));

            if (isset($material_sel) and strlen($material_sel) > 0) {
                $material = " AND ColourMaterial LIKE '" . $material_sel . "' ";
            }
            if (isset($color_sel) and strlen($color_sel) > 0) {
                $color = " AND LabelColor LIKE '" . $color_sel . "' ";
            }
            $condition = $product_condition . $material . $adhesive . $color;


            $data['materials'] = $this->home_model->ajax_material_sorting($condition);


            //echo $this->db->last_query();exit;
            if (isset($wholesale) and $wholesale == 'enable') {
                $theHTMLResponse = $this->load->view('wholesale/material_list', $data, true);
            } else {
                $theHTMLResponse = $this->load->view('order_quotation/material/material_list', $data, true);
            }
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('html' => $theHTMLResponse, 'color' => $color_option, 'material' => $paper_option, 'adhesive' => $adhesive_option)));

            //echo json_encode(array('html'=>$html));
        }
    }

    function integrated_detail($cat = null)
    {

        $cat = $this->input->get('catid');

        $query = $this->db->query("select CategoryName as name,CategoryImage as image from category where SubCategoryID LIKE '%" . $cat . "%' 
		AND (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice') AND `specification3` = 'Integrated'  LIMIT 5");
        $result = $query->result();

        $comaptible = '';
        if (count($result) > 0) {
            foreach ($result as $row) {
                //$comaptible.='<img width="84" height="auto" src="'.Assets.'images/icons/'.$row->image.'" title="'.$row->image.'" alt="'.$row->image.'">';
                $comaptible .= '<img src="' . aalables_path . 'images/icons/' . $row->image . '" title="' . $row->image . '" alt="' . $row->image . '">';
            }
        }
        $data['compatible_list'] = $this->home_model->integrated_comaptible_list();

        $data['comaptible'] = $comaptible;

        $data['integrate'] = $this->home_model->for_integrate($cat);

        $manufactureID = $data['integrate'][0]->ManufactureID;

        $query = $this->db->query("select *,Box_1000 as Box from integrated_labels_prices where ManufactureID LIKE '" . $manufactureID . "' and Price_1000 != '0'");

        $integrated_prices = $query->result();

        $data['batch'] = 1000;

        $data['integrated_prices'] = $integrated_prices;

        $data['main_content'] = 'order_quotation/material/integrated_list';

        $record['html'] = $this->takeHtmlAndPrintData($data['main_content'], $data);

        echo json_encode($record);
    }

    function integrated($cat = NULL, $compatible = NULL)
    {
        $cat = $this->input->post('catid');
        if ($compatible == 'yes') {
            $cat = str_replace("-", " ", $cat);
            $qry = "select SubCategoryID,CategoryName,CategoryImage,CategoryID,Shape from category 
			where CategoryName LIKE '%" . $cat . "%' LIMIT 1";

        } else {
            $qry = "select SubCategoryID,CategoryName,CategoryID,CategoryImage,Shape from category where CategoryID LIKE '" . $cat . "' LIMIT 1";
            $compatible = '';

        }
        $query = $this->db->query($qry);
        $row = $query->row_array();
        //echo"<pre>";print_r($row);echo"</pre>";exit;
        if (isset($row['SubCategoryID']) and $row['SubCategoryID'] != '') {
            $releted_arr = explode(",", $row['SubCategoryID']);
            $rel_prd_string = "'" . implode("','", $releted_arr) . "'";
            $condition = " p.CategoryID IN (" . $rel_prd_string . ") AND (CategoryActive='Y' || displayin='both' || displayin='backoffice')";
            if ($cat == 'T813') {
                $condition = " p.CategoryID IN (" . $rel_prd_string . ") ";
            }
        } else {
            $condition = " p.ProductBrand LIKE 'Integrated Labels' AND (CategoryActive='Y' || displayin='both' || displayin='backoffice') AND c.Shape NOT LIKE 'Full Sheet Integrated' ";
            $condition1 = " p.ProductBrand LIKE 'Integrated Labels' AND c.Shape LIKE 'Full Sheet Integrated' ";
            $data['fullsheet'] = $this->home_model->fetch_dies_data($condition1);

        }
        $data['compatible_list'] = $this->home_model->integrated_comaptible_list();
        $data['print_sheets'] = $this->home_model->fetch_print_sheets();
        $data['compatible'] = $compatible;
        $data['catdata'] = $row;


        if ($cat == 'T813') {
            $fqry2 = $this->db->query("SELECT c.CategoryID,c.specification1,c.specification2,c.specification3,c.pdfFile,c.wordFile,
				c.CategoryName,c.CategoryImage,c.LabelWidth,c.LabelHeight,c.Shape,p.ProductName,p.ManufactureID,
				p.ProductID,p.SpecText7,p.ProductBrand FROM category c , products p 
				WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND " . $condition . " 
				GROUP BY c.CategoryID Order by LabelsPerSheet,p.ManufactureID ASC ");
            $data['integrate'] = array('num_row' => $fqry2->num_rows(), 'list' => $fqry2->result());
        } else {
            $data['integrate'] = $this->home_model->fetch_dies_data($condition);
        }


        $data['fullsheet_integrated'] = '';
        if ($cat != 'T813') {
            $wheree = " and CategoryID != 'T813'";
        }
        $other_condition = "SELECT SubCategoryID FROM `category` WHERE `CategoryDescription` LIKE 'Integrated Labels' AND CategoryID != '$cat' $wheree";
        $query = $this->db->query($other_condition);

        $subcategories = '';

        foreach ($query->result() as $res) {
            $subcategories .= $res->SubCategoryID . ",";
        }
        $releted_arr = explode(",", $subcategories);
        $rel_prd_string = "'" . implode("','", $releted_arr) . "'";
        $condition = " p.CategoryID IN (" . $rel_prd_string . ") AND (CategoryActive='Y' || displayin='both' || displayin='backoffice')";
        if ($cat == '') {
            $data['other'] = '';
        } else {
            $data['other'] = $this->home_model->fetch_dies_data($condition);
        }
        if ($cat != 'T813') {
            $fullsheet_condition = "SELECT SubCategoryID FROM `category` WHERE `CategoryDescription` LIKE 'Integrated Labels' AND CategoryID = 'T813'";
            $query = $this->db->query($fullsheet_condition);

            $subcategories = '';
            foreach ($query->result() as $res) {
                $subcategories .= $res->SubCategoryID . ",";
            }
            $releted_arr = explode(",", $subcategories);
            $rel_prd_string = "'" . implode("','", $releted_arr) . "'";
            $condition = " p.CategoryID IN (" . $rel_prd_string . ") ";
            //$data['fullsheet_integrated'] = $this->home_model->fetch_dies_data($condition);

            $fqry2 = $this->db->query("SELECT c.CategoryID,c.specification1,c.specification2,c.specification3,c.pdfFile,c.wordFile,
				c.CategoryName,c.CategoryImage,c.LabelWidth,c.LabelHeight,c.Shape,p.ProductName,p.ManufactureID,
				p.ProductID,p.SpecText7,p.ProductBrand FROM category c , products p 
				WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND " . $condition . " 
				GROUP BY c.CategoryID Order by LabelsPerSheet,p.ManufactureID ASC ");
            $data['fullsheet_integrated'] = array('num_row' => $fqry2->num_rows(), 'list' => $fqry2->result());


        }

        $data['main_content'] = 'order_quotation/material/integrated';

        $record['html'] = $this->takeHtmlAndPrintData($data['main_content'], $data);

        echo json_encode($record);
    }

    function get_box_price()
    {
        $manufatureid = $this->input->post('manufature');
        $box = $this->input->post('box');
        $batch = $this->input->post('batch');
        $print = $this->input->post('print_option');
        $cart_id = $this->input->post('cart_id');
        $productid = $this->input->post('prd_id');
        $manual_design = $this->input->post('manual_design');

        $printprice = '';
        $PrintPrice = '';
        $designprice = '';
        $BlackPrice = '';
        $design = '';
        $print_option = '';

        $free_artworks = '';

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

                    if ($manual_design != 0) {
                        $design = $manual_design;
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

                $printed_price = ((int)$PrintPrice + (int)$BlackPrice);
                $plain_price = $plain_value;
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
                    'nodesing' => ((int)$design),
                    'print_option' => $print_option,
                );
            }
        }
        echo json_encode($array);
    }


    function add_integrate_incart()
    {

        //print_r($_POST); die();
        $type = '';
        $labeltype = '';
        $quotationInsertedId = 0;
        $orderInsertedId = 0;
        $items = array();
        $productid = $this->input->post('prdid');
        $cartId = $this->input->post('cartId');
        $manufatureid = $this->input->post('manufature');
        $qty = $this->input->post('box');
        $manual_design = $this->input->post('manual_design');

        //$printed = $this->input->post('type');
        //$print_option = $labeltype = $this->input->post('type_ps');

        $printedsss = $printed = $this->input->post('type_ps');
        $printss = $print_option = $labeltype = $this->input->post('type_ps');
        $printss = $print_option = $labeltype = $this->input->post('print');


        $labeltype = $print_optiontype = $this->input->post('print_optiontype');

        $batch = $this->input->post('batch');

        if (isset($manufatureid) and isset($qty) and $qty != 0) {
            $price = $this->home_model->single_box_price($manufatureid, $qty, $batch);
            $dpd = $price['dpd'];
            if ($qty != $price['Sheets']) {
                $perbox = $price['PlainPrice'] / $price['Box'];
                $acc_boxes = $qty / $batch;
                $calculated_price = $acc_boxes * $perbox;
                $price['PlainPrice'] = $calculated_price;
            }

            $totalprice = $price['PlainPrice'];

            if (isset($labeltype)) {
                if (preg_match('/Mono/', $labeltype)) {
                    $printed = 'black';
                } else if (preg_match('/Digital/', $labeltype)) {
                    $printed = 'printed';
                } else {
                    $printed = "";
                }
            }

            if ($printed == "black") {
                $labeltype = 'Mono';
            } else {
                $labeltype = 'Fullcolour';
            }

            $A4Printing = array();
            if (isset($labeltype) and ($labeltype == 'Mono' || $labeltype == 'Fullcolour')) {
                //echo $cart_id;
                if (isset($cart_id) and $cart_id != '') {
                    $design = $this->get_uploaded_number_design($cart_id, $productid);
                } else {
                    $design = $this->get_number_design_integ($productid);
                }
                //echo $this->db->last_query();
                if ($manual_design != 0) {
                    $design = $manual_design;
                }

                //echo $labeltype; exit;
                $designprice = 0.00;
                $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, 'A4 Labels');
                //print_r($printprice); exit;
                $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $printprice = $printprice['price'];

                $printprice = $printprice + $designprice;
                if ($printedsss == "plain") {
                    $printprice = 0;
                }


                $Print_Design = '1 Design';
                if ($design > 1) {
                    $Print_Design = 'Multiple Designs';
                }

                if ($labeltype == 'Mono') {
                    $labeltype = 'Monochrome – Black Only';
                } else {
                    $labeltype = '4 Colour Digital Process';
                }

                $dsd = 'Y';
                if ($printedsss == "printed") {
                    $dsd = "Y";
                } else {
                    $dsd = "N";
                }

                $A4Printing = array(
                    'Printing' => $dsd,
                    'Print_Type' => $print_optiontype,
                    'Print_Design' => $Print_Design,
                    'Free' => $free_artworks,
                    'Print_Qty' => $design,
                    'Print_UnitPrice' => $printprice,
                    'Print_Total' => $printprice);
            }

            $unitprice = $totalprice / $qty;
            $SID = $this->shopping_model->sessionid();
            $items = array(
                'SessionID' => $SID,
                'ProductID' => $productid,
                'Quantity' => $qty,
                'orignalQty' => $batch,
                'UnitPrice' => $unitprice,
                'TotalPrice' => $totalprice,
                'LabelsPerRoll' => '1',
                'added_from'=>'backoffice'
                //'OrderTime'=>'NOW()'
            );
            $items = array_merge($items, $A4Printing);


            $userID = $this->session->userdata('userid');
            if (isset($userID) and $userID != '') {
                $items['UserID'] = $userID;
            }

            if ($this->input->post('pageName') == 'quotation' || $this->input->post('pageName') == 'order') {
                $pro = $this->getCategoryName($items['ProductID']);
                // print_r($product);exit;


                if ($this->input->post('pageName') == 'quotation') {
                    $param = array(
                        'QuotationNumber' => $this->input->post('order_number'),
                        'CustomerID' => $this->input->post('userId'),
                        'ProductID' => $items['ProductID'],
                        'ManufactureID' => $this->input->post('manufature'),
                        'ProductName' => $this->quotationModal->customize_product_name('N', $pro[0]->CategoryName,
                            ($qty / $batch), $pro[0]->LabelsPerSheet,
                            $pro[0]->ReOrderCode, $this->input->post('manufature'),
                            $pro[0]->ProductBrand, '',
                            date('Y-m-d h:m:s')),
                        'Quantity' => $items['Quantity'],
                        'orignalQty' => $items['orignalQty'],
                        'Price' => $items['TotalPrice'],
                        'ProductTotalVAT' => $items['TotalPrice'],
                        'Print_Type' => (isset($items['Print_Type'])) ? $items['Print_Type'] : '',
                        'ProductTotal' => ($items['TotalPrice'] + ((isset($items['Print_Total']) && $items['Print_Total'] != null) ? $items['Print_Total'] : 0)),
//                        /'type'=>(isset($items['Printing']) && $items['Printing'] == 'Y')?'print':'plain',
                        'Printing' => (isset($items['Printing']) && $items['Printing'] == 'Y') ? 'Y' : 'N',
                        'Print_Design' => (isset($items['Print_Design'])) ? $items['Print_Design'] : '',
                        'Print_Qty' => (isset($items['Print_Qty'])) ? $items['Print_Qty'] : '',
                        'Free' => (isset($items['Free'])) ? $items['Free'] : '',
                        'Print_UnitPrice' => (isset($items['Print_UnitPrice'])) ? $items['Print_UnitPrice'] : '',
                        'Print_Total' => (isset($items['Print_Total'])) ? $items['Print_Total'] : '',
                        'LabelsPerRoll' => '1'
                    );

                    $this->db->insert('quotationdetails', $param);
                    $error = $this->db->error();
                    //print_r( $error['message']);exit;

                    $quotationInsertedId = $this->db->insert_id();
                } else {
                    $param = array(
                        'OrderNumber' => $this->input->post('order_number'),
                        'UserID' => $this->input->post('userId'),
                        'ProductID' => $items['ProductID'],
                        'ManufactureID' => $this->input->post('manufature'),
                        'ProductName' => $this->quotationModal->customize_product_name('N', $pro[0]->CategoryName,
                            ($qty / $batch), $pro[0]->LabelsPerSheet,
                            $pro[0]->ReOrderCode, $this->input->post('manufature'),
                            $pro[0]->ProductBrand, '',
                            date('Y-m-d h:m:s')),
                        'Quantity' => $items['Quantity'],
                        'labels' => $items['orignalQty'],
                        'Price' => $items['TotalPrice'],
                        'ProductTotalVAT' => $items['TotalPrice'],
                        'Print_Type' => (isset($items['Print_Type'])) ? $items['Print_Type'] : '',
                        'ProductTotal' => ($items['TotalPrice'] + ((isset($items['Print_Total']) && $items['Print_Total'] != null) ? $items['Print_Total'] : 0)),
                        'Printing' => (isset($items['Printing']) && $items['Printing'] == 'Y') ? 'Y' : 'N',
                        'Print_Design' => (isset($items['Print_Design'])) ? $items['Print_Design'] : '',
                        'Print_Qty' => (isset($items['Print_Qty'])) ? $items['Print_Qty'] : '',
                        'Free' => (isset($items['Free'])) ? $items['Free'] : '',
                        'Print_UnitPrice' => (isset($items['Print_UnitPrice'])) ? $items['Print_UnitPrice'] : '',
                        'Print_Total' => (isset($items['Print_Total'])) ? $items['Print_Total'] : '',
                        'LabelsPerRoll' => '1',
                    );
                    //print_r($param);exit;
                    $this->db->insert('orderdetails', $param);
                    $error = $this->db->error();
                    //print_r( $error['message']);exit;

                    $orderInsertedId = $this->db->insert_id();
                }
            } else {

                //echo '<pre>';  print_r($items);exit;
                $this->db->insert('temporaryshoppingbasket', $items);
                $last_id = $this->db->insert_id();

                $sid = $this->session->userdata('session_id') . '-PRJB';
                $ips['CartID'] = $last_id;

                $this->db->where(array('ProductID' => $productid, 'SessionID' => $sid, 'CartID' => $cartId));
                $this->db->update('integrated_attachments', $ips);

                //exit;
                //$ccc = $this->db->insert_id();
            }

            if ($last_id > 0 || $quotationInsertedId > 0 || $orderInsertedId > 0) {

                if ($printed == 'printed' || $printed == 'black') {


                    $counter = $this->input->post('counter');
                    /*  if(isset($counter) and $counter > 0 ){*/
                    if ($this->input->post('pageName') == 'quotation' || $this->input->post('pageName') == 'order') {

                        $artworks = $this->db->query("select * from integrated_attachments where CartID ='" . $cartId . "' ")->result();


                        if ($this->input->post('pageName') == 'quotation') {
                            foreach ($artworks as $artwork) {
                                $artworkDetail = array(
                                    'UserID' => $this->input->post('userId'),
                                    'QuotationNumber' => $this->input->post('order_number'),
                                    'Serial' => $quotationInsertedId,
                                    'ProductID' => $productid,
                                    'diecode' => $this->input->post('manufature'),
                                    'name' => $artwork->name,
                                    'qty' => $artwork->qty,
                                    'labels' => $artwork->labels,
                                    'design_type' => (isset($items['Print_Design'])) ? $items['Print_Design'] : '',
                                    'file' => $artwork->file,
                                    'print_file' => $artwork->file,
                                    'source' => 'backoffice',
                                    'status  ' => '70',
                                    'Date  ' => date('Y-m-d h:m:s'),
                                );
                                $this->db->insert('quotation_attachments_integrated', $artworkDetail);
                            }
                        } else {

                            foreach ($artworks as $artwork) {
                                $artworkDetail = array(
                                    'UserID' => $this->input->post('userId'),
                                    'OrderNumber' => $this->input->post('order_number'),
                                    'Serial' => $orderInsertedId,
                                    'ProductID' => $productid,
                                    'diecode' => $this->input->post('manufature'),
                                    'name' => $artwork->name,
                                    'qty' => $artwork->qty,
                                    'labels' => $artwork->labels,
                                    'design_type' => (isset($items['Print_Design'])) ? $items['Print_Design'] : '',
                                    'file' => $artwork->file,
                                    'print_file' => $artwork->file,
                                    'source' => 'backoffice',
                                    'status  ' => '70',
                                    'Date  ' => date('Y-m-d h:m:s'),
                                );
                                $this->db->insert('order_attachments_integrated', $artworkDetail);
                            }
                        }
                    } else {

                        $sd = $this->db->insert_id();

                        $data = array('CartID' => $sd, 'status' => 'confirm');
                        $update = $this->db->update('integrated_attachments', $data, array('CartID' => $cartId, 'ProductID' => $productid));

                        //echo $this->db->last_query();
                    }
                    /* }*/
                }
                $charges = $this->update_integrated_delivery_charges();

                if ($this->input->post('pageName') == 'quotation' || $this->input->post('pageName') == 'order') {

                    if ($this->input->post('pageName') == 'quotation') {
                        $this->db->where('QuotationNumber', $this->input->post('order_number'));
                        $shiping = array('QuotationShippingAmount' => $charges['BasicCharges']);
                        $this->db->update('quotations', $shiping);

                        $this->output->set_output(json_encode(array('top_cart' => 'no')));
                        return true;
                    } else {
                        $this->db->where('OrderNumber', $this->input->post('order_number'));
                        $shiping = array('OrderShippingAmount' => $charges['BasicCharges']);
                        $this->db->update('orders', $shiping);

                        $this->output->set_output(json_encode(array('top_cart' => 'no')));
                        return true;
                    }


                }


                //$data = array( 'CartID' => $ccc,'status' => 'confirm');
                //$update = $this->db->update('integrated_attachments', $data, array('CartID' => $cartId, 'ProductID' => $productid));

                $topcart_data = $this->ajax_topcart_load();
                $this->output->set_output(json_encode(array('top_cart' => $topcart_data)));
            }

        }


    }

    function get_number_design_integ($productid)
    {
        $sid = $this->session->userdata('session_id') . '-PRJB';
        $query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '" . $sid . "' AND ProductID='" . $productid . "' AND type LIKE 'new' ");
        $row = $query->row_array();
        if (isset($row['total']) and $row['total']) return $row['total'];

        else return 0;
    }

    public function getCategoryName($productId)
    {

        $record = $this->db->select("p.*,c.*")
            ->join('category as c', 'p.CategoryID= c.CategoryID')
            ->from('products as p')
            ->where('p.ProductID', $productId)->get()->result();

        return $record;
    }

    function update_integrated_delivery_charges()
    {
        $intdata = array();
        $intdata['BasicCharges'] = 0;
        $integrated = $this->shopping_model->is_order_integrated();
        $dl_id = $this->session->userdata('ServiceID');
        if ($dl_id != '') {
            $qry = $this->db->query("SELECT * FROM shippingservices WHERE ServiceID  = " . $dl_id . " order by ServiceID asc");
            $res = $qry->result_array();

            $intdata['ServiceID'] = $res[0]['ServiceID'];
            $intdata['ServiceName'] = $res[0]['ServiceName'];
            $intdata['BasicCharges'] = $res[0]['BasicCharges'];
            $intdata['changeDrop'] = 1;
        }
        if ($integrated > 0) {
            $SID = $this->shopping_model->sessionid();
            $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `temporaryshoppingbasket` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and SessionID = '$SID' and t.p_name != 'Delivery Charges'")->row_array();

            $dpd = $this->home_model->get_integrated_delivery($int_sheets['qty']);
            $dpd = $dpd['dpd'];

            $productid = $int_sheets['ProductID'];

            $intdata['BasicCharges'] += $dpd * 1.2;

            if ($int_sheets['qty'] == '' || $int_sheets['ProductID'] == '') {
                $intdata['BasicCharges'] -= $dpd * 1.2;
            }
            $this->session->set_userdata($intdata);


        }

        return $intdata;
    }


    function ajax_topcart_load()
    {

        $theHTMLResponse = $this->load->view('order_quotation/material/top_cart', '', true);
        $this->output->set_content_type('application/json');
        return $theHTMLResponse;
    }

























//    public function getSearch(){
//        $type = $this->input->get('category');
//        $shape=null;
//
//        $brand = $this->home_model->make_productBrand_condtion($type);
//
//        if($shape==NULL){
//           $condition = " p.ProductBrand LIKE '".$brand."' AND CategoryActive='Y'";
//           $condition1 = " p.ProductBrand LIKE '".$brand."'";
//        }
//
//        $data['records']['records'] = $this->home_model->fetch_dies_data($condition);
//        //echo '<pre>';
//        //print_r($data['records']['records']);exit;
//
//        $data['records']['shapes'] = $this->getShape($condition);
//        $data['records']['SpecText7'] = $this->makeRecord($this->getRecords('SpecText7 as SpecText7',$condition1),$type);
//
//        $data['records']['materials'] = $this->getRecords('ColourMaterial_upd as material',$condition1);
//        $data['records']['colors'] = $this->getRecords('LabelColor_upd as color',$condition1);
//        $data['records']['finis'] = $this->getRecords('LabelFinish_upd as finish',$condition1);
//        $data['records']['adhesives'] = $this->getRecords('Adhesive as adhesive',$condition1);
//        $data['records']['width'] = $this->getWidth('pwidth', $brand);
//        $data['records']['height'] = $this->getWidth('pheight', $brand);
//
//       // echo '<pre>';
//       // print_r($data['records']['SpecText7']);exit;
//
//
//
//        $data['records']['param'] = $this->input->get();
//
//
//        $searchPage['html'] = $this->takeHtmlAndPrintData('order_quotation/format',$data);
//        echo json_encode($searchPage);
//    }

    public function getShape($condition)
    {
        return $this->searchModal->category_shapes($condition);
    }

    public function getRecords($field, $type)
    {
        return $this->searchModal->getRecords($field, $type);
    }

    public function getWidth($field, $type)
    {
        return $this->searchModal->get_min_width_height($field, $type);
    }


    public function getSearchResults()
    {


        $query = "";
        $category = $this->input->post('category');
        $shape = $this->input->post('shape');
        $finish = $this->input->post('finish');
        $material = $this->input->post('material');
        $color = $this->input->post('color');
        $adhesive = $this->input->post('adhesive');
        $printer = $this->input->post('printer');


        $brand = $this->home_model->make_productBrand_condtion($category);

        if ($category) {
            $query .= $condition = " p.ProductBrand LIKE '" . $brand . "' AND (CategoryActive='Y' || displayin='both' || displayin='backoffice')";


            $condition1 = " p.ProductBrand LIKE '" . $brand . "' ";
        }
        if ($shape) {
            $query .= $queryShape = " AND p.Shape LIKE '" . $shape . "' ";

        }
        if ($printer) {
            $query .= $printer = " AND p.SpecText7 LIKE '" . $printer . "' ";
        }
        if ($material) {
            $query .= $material = " AND p.ColourMaterial_upd LIKE '" . $material . "' ";
        }
        if ($color) {
            $query .= $color = " AND p.LabelColor_upd LIKE '%" . $color . "%' ";
        }

        if ($adhesive) {
            $query .= $adhesive = " AND p.Adhesive LIKE '" . $adhesive . "' ";
        }

        if ($finish) {
            $query .= $finish = " AND p.LabelFinish_upd LIKE '" . $finish . "' ";
        }

        //echo $query;exit;

        $meterialParams = $condition1 . $finish . $color . $material . $adhesive . $printer;
        // echo $meterialParams;exit;
        //echo $query;exit;
        $data['records']['records'] = $this->searchModal->labelfinder_data($query, '', '', '');

        //echo '<pre>';
        //print_r($data['records']['records']);exit;

        $data['records']['shapes'] = $this->getShape($condition);
        $data['records']['materials'] = $this->getRecords('ColourMaterial_upd as material', $meterialParams);
        $data['records']['SpecText7'] = $this->makeRecord($this->getRecords('SpecText7 as SpecText7', $meterialParams), $category);
        $data['records']['colors'] = $this->getRecords('LabelColor_upd as color', $meterialParams);
        $data['records']['finis'] = $this->getRecords('LabelFinish_upd as finish', $meterialParams);
        $data['records']['adhesives'] = $this->getRecords('Adhesive as adhesive', $meterialParams);
        $data['records']['width'] = $this->getWidth('pwidth', $brand);
        $data['records']['height'] = $this->getWidth('pheight', $brand);

        //echo '<pre>';
        //print_r($data['records']['SpecText7']);exit;


        $data['records']['param'] = $this->input->post();

        $searchPage['html'] = $this->takeHtmlAndPrintData('order_quotation/format', $data);
        echo json_encode($searchPage);
    }

    public function makeRecord($records, $type)
    {
        $final = [];
        foreach ($records as $record) {

            $final[$record->SpecText7] = $this->check_compatibility($record->SpecText7, $type);
        }
        return $final;
    }

    function check_compatibility($text, $band)
    {
        $array = array();
        $html = '';
        if (preg_match("/\bDirect Thermal\b/i", $text)) $array[] = 'Direct Thermal';
        if (preg_match("/\bThermal Transfer\b/i", $text)) $array[] = 'Thermal Transfer';
        if (preg_match("/Copier/i", $text)) $array[] = 'Copier';
        if (preg_match("/Laser/i", $text)) $array[] = 'Laser';
        if (preg_match("/\bInkjet\b/i", $text)) $array[] = 'Inkjet';
        if (count($array) > 0) {
            $last_key = key(array_slice($array, -1, 1, TRUE));
            $last_item = $array[$last_key];
            unset($array[$last_key]);
            $html = implode(", ", $array);
            if ($html) $html = $html . ' and ' . $last_item;
            else $html = $last_item;
        }

        return $html . ' Compatible';

    }

    function add_sample_to_cart()
    {

        $array = array('response' => 'yes');
        if ($_POST) {
            $qty = $this->input->post('qty');
            $menuid = $this->input->post('menuid');
            $prd_id = $this->input->post('prd_id');
            $pageName = $this->input->post('pageName');
            $response = $this->check_sample_requests($prd_id, $menuid, $pageName, $this->input->post('orderNumber'));
            if ($response == 'true') {
                $SID = $this->shopping_model->sessionid();
                $items = array('SessionID' => $SID,
                    'ProductID' => $prd_id,
                    'Quantity' => 1,
                    'orignalQty' => 1,
                    'UnitPrice' => 0.00,
                    'TotalPrice' => 0.00,
                    'OrderData' => 'Sample',
                    'added_from'=>'backoffice'
                    );

                if ($pageName == 'quotation' || $pageName == 'order') {

                    if ($pageName == 'quotation') {
                        $quotationDetail = array(
                            'QuotationNumber' => $this->input->post('orderNumber'),
                            'ManufactureID' => $menuid,
                            'CustomerID' => $this->input->post('userId'),
                            'ProductID' => $prd_id,
                            'Quantity' => 1,
                            'orignalQty' => 1,
                            'Price' => 0.00,
                            'ProductTotalVAT' => 0.00,
                            'ProductTotal' => 0.00,
                            'sample' => 'sample',
                        );
                        $this->db->insert('quotationdetails', $quotationDetail);
                        $array = array('response' => 'yes', 'page' => $pageName);
                        echo json_encode($array);
                        return true;
                    } else {
                        $orderDetail = array(
                            'OrderNumber' => $this->input->post('orderNumber'),
                            'UserID' => $this->input->post('userId'),
                            'ManufactureID' => $menuid,
                            'ProductID' => $prd_id,
                            'Quantity' => 1,
                            'labels' => 1,
                            'Price' => 0.00,
                            'ProductTotalVAT' => 0.00,
                            'ProductTotal' => 0.00,
                            'sample' => 'sample',

                        );
                        $this->db->insert('orderdetails', $orderDetail);

                        $array = array('response' => 'yes', 'page' => $pageName);
                        echo json_encode($array);
                        return true;
                    }


                } else {
                    $userID = $this->session->userdata('userid');
                    if (isset($userID) and $userID != '') {
                        $cart_reminder = $this->home_model->get_db_column("customers", "cart_reminder", "UserID", $userID);
                        if (isset($cart_reminder) and $cart_reminder == "Y") {
                            $items['UserID'] = $userID;
                        }
                    }


                    $this->db->insert('temporaryshoppingbasket', $items);
                    $topcart_data = $this->ajax_topcart_load();

                    $array = array('response' => 'yes', 'top_cart' => $topcart_data);
                }


            } else {
                $array = array('response' => 'failed', 'msg' => $response);
            }
        }
        echo json_encode($array);

    }

    function check_sample_requests($prd_id, $menuid, $pageName = null, $number = null)
    {

        $productBrand = $this->home_model->get_db_column('products', 'ProductBrand', 'ManufactureID', $menuid);
        if ($pageName == 'quotation' || $pageName == 'order') {
            if ($pageName == 'quotation') {
                $result = $this->db->query("select count(SerialNumber) as total from quotationdetails WHERE QuotationNumber = '" . $number . "' And sample LIKE 'sample'");
                $row = $result->row_array();

            } else {
                $result = $this->db->query("select count(SerialNumber) as total from orderdetails WHERE OrderNumber = '" . $number . "' And sample LIKE 'sample'");
                $row = $result->row_array();
            }

            if ($row['total'] > 5) {
                return 'you have reached the maximum sample order limit!';
            } else {
                return 'true';
            }

        } else {
            $SID = $this->shopping_model->sessionid();
            $result = $this->db->query("select count(ID) as total from temporaryshoppingbasket WHERE OrderData LIKE 'Sample' AND SessionID LIKE '" . $SID . "' ");
            $row = $result->row_array();
            if ($row['total'] < 5) {

                if (preg_match("/Roll Labels/i", $productBrand)) {
                    $code = $this->home_model->getmaterialcode(substr($menuid, 0, -1));
                } else {
                    $code = $this->home_model->getmaterialcode($menuid);
                }

                $query = "select count(*) as total from temporaryshoppingbasket WHERE OrderData LIKE 'Sample' AND SessionID LIKE '" . $SID . "' AND temporaryshoppingbasket.ProductID = '" . $prd_id . "'";

                /* $query = "select  count(*) as total  from temporaryshoppingbasket
					  INNER JOIN products ON products.ProductID = temporaryshoppingbasket.ProductID
					  INNER JOIN category ON products.categoryID = category.categoryID
					  WHERE OrderData LIKE 'Sample' AND SessionID LIKE '".$SID."'
					  AND REPLACE(products.ManufactureID,REPLACE(category.PDF,'.pdf',''),'') LIKE  '".$code."'"; */
                //echo $query;exit;
                $result = $this->db->query($query);

                $row = $result->row_array();
                if (isset($row['total']) and ($row['total'] > 0)) {
                    return 'You have already requested a sample of this material and we reiterate that the material samples are not size specific by label, but are providied for you to assess and evaluate the suitability of the material for your labels purpose.';
                } else {
                    return 'true';
                }
            } else {
                return 'you have reached the maximum sample order limit!';
            }
        }


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
            $manual_design = $this->input->post('manual_design');


            if (isset($cart_id) and $cart_id != '') {
                $design = $this->get_uploaded_number_design($cart_id, $productid);
            } else {
                $design = $this->get_number_design($productid);
            }
            //echo $this->db->last_query();
            //echo"<pre>";print_r($design);echo"</pre>";exit;

            if ($manual_design != 0) {
                $design = $manual_design;
            }

            $save_txt = '';
            $ProductBrand = $this->ProductBrand($menu);


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

                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];
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
                $dis_img = '';
                /*if (preg_match("/A4 Labels/is", $ProductBrand) and ( preg_match("/WPEP/i", $menu))) {
                                $wpep_discount = (($plain) * (20 / 100));
                                $wpep_discount_txt = '<small class="discount_price">'.symbol.$price.' </small>';
                                $price = number_format(($price - $wpep_discount),2,'.','');
                                $dis_img = '<img src="'.Assets.'images/discount_20.png">';
                }*/
                
                
                    
                if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);

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
                    $per_labels = $showlabels . ' Labels / ' . $qty . ' Sheets, ' . symbol . $perprice . ' per label';
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

                $this->home_model->save_logs('calculate_price', $response);  //SAVE LOG
                echo json_encode($response);
            }
        }
    }


    function get_uploaded_number_design($cartid, $productid)
    {
        $sid = $this->session->userdata('session_id') . '-PRJB';
        $query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '" . $sid . "' AND
		 ProductID=$productid AND status LIKE 'confirm' AND  CartID LIKE '" . $cartid . "'");
        $row = $query->row_array();
        if (isset($row['total']) and $row['total']) return $row['total'];
        else return 0;
    }

    function get_number_design($productid)
    {
        $SID = $this->shopping_model->sessionid();
        $query = $this->db->query("select count(*) as total from integrated_attachments WHERE SessionID LIKE '" . $SID . "' AND ProductID= productid AND status LIKE 'temp' ");
        $row = $query->row_array();
        if (isset($row['total']) and $row['total']) return $row['total'];

        else return 0;
    }

    function ProductBrand($id)
    {
        $query = $this->db->query("select  ProductBrand from products  where ManufactureID ='".$id."' ");
        $res = $query->row_array();
        return $res['ProductBrand'];
    }

    function add_to_cart()
    {

        if ($_POST) {

            $qty = $this->input->post('qty');
            $menu = $this->input->post('menuid');
            $productid = $this->input->post('prd_id');
            $type = $this->input->post('type');
            $labeltype = $this->input->post('labeltype');
            $source = $this->input->post('source');
            $batch = $this->input->post('batch');
            $design = $this->get_number_design($productid);

            $colorcode = '';
            $wound = 'N';
            $printtype = '';
            $is_custom = 'No';
            $LabelsPerRoll = '';
            $A4Printing = array();
            $regmark = $this->input->post('regmark');
            $check = $this->user_model->isProductActive($menu);
            $ProductBrand = $this->ProductBrand($menu);
//            $this->product_model->ajax_price($qty, $menu, $ProductBrand);
//            $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
            /*if ($check == 0) {

                $query = $this->db->query("SELECT Shape_upd,`CategoryID` FROM `products` Where ManufactureID='" . $menu . "'");
                $result1 = $query->row_array();

                //$roll_arr=array('R1','R2','R3','R4','R5');
                //$categoryid=str_replace($roll_arr,'',$result1['CategoryID']);
                $url = base_url() . 'roll-labels/' . strtolower($result1['Shape_upd']) . '/' . strtolower($result1['CategoryID']) . '/';
                //$url = base_url().'home/material/'.$categoryid;
                echo json_encode(array('deactive' => 'yes', 'url' => $url));
                exit();
            }*/

            if (isset($type) and $type == 'Rolls') {

                $labels = $this->input->post('labels');
                if (isset($labels) and $labels > 99) {
                    $latest_price = $this->home_model->calclateprice($menu, $qty, $labels);
                    $total = $latest_price['final_price'];
                }

                $material_code = $this->home_model->getmaterialcode(substr($menu, 0, -1));
                $material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
                if ($material_discount) {
                    $total = ($total * 1.2);
                    $wpep_discount = (($total) * ($material_discount / 100));
                    $total = $total - $wpep_discount;
                    $total = $total / 1.2;
                }


                $is_custom = 'Yes';
                $LabelsPerRoll = $labels;

                $woundoption = $this->session->userdata('wound');
                $wound_cat = $this->session->userdata('wound-cat');

                if (isset($wound_cat) and $woundoption == 'Inside') {
                    $response = $this->home_model->check_wound_option($productid, $wound_cat);
                    if ($response == true) {
                        $wound = 'Y';
                    }
                }
            } else if ($type == 'Integrated') {

                $newqty = $this->home_model->calculate_integrated_qty($menu, $qty);
                $price = $this->home_model->single_box_price($menu, $newqty, $batch);
                $total = $price['PlainPrice'];

                if ($qty != $price['Sheets']) {
                    $perbox = $price['PlainPrice'] / $price['Box'];
                    $acc_boxes = $qty / $batch;
                    $calculated_price = $acc_boxes * $perbox;
                    $price['PlainPrice'] = $calculated_price;
                    $total = $price['PlainPrice'];
                }

                $printed = $this->input->post('print_type');
                if ($printed == 'printed') {
                    $labeltype = 'Fullcolour';
                } else if ($printed == 'black') {
                    $labeltype = 'Mono';
                }
                $designprice = 0.00;
                //if(strtolower($printed) != 'plain'){
                $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
                $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $printprice = $printprice['price'];

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
                    'Print_Total' => $printprice);
                $A4Printing = array(
                    'orignalQty' => $batch
                );
                //}


            } else {
                if (substr($menu, -2, 2) == 'XS') {
                    $printtype = $this->input->post('design');
                }
                /*****************WPEP Offer************/
                $wpep_discount = 0.00;
                $data = $this->product_model->ajax_price($qty, $menu, $ProductBrand);
                $total = $data['custom_price'];

                
                    
                    
                if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);

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
                /*****************WPEP Offer************/

                /****************Printed Labels Options*************/

                if ($ProductBrand == 'Application Labels') {
                    $clrcode = $this->input->post('colour');
                    if (isset($clrcode) and $clrcode != '') {
                        $colorcode = $this->input->post('colour');
                    }
                }


                if (isset($labeltype) and ($labeltype == 'Mono' || $labeltype == 'Fullcolour')) {
                    $designprice = 0.00;

                    if ($source == 'flash') {
                        $design = 1;
                        $free_artworks = 1;
                        if ($qty < 25) {
                            $data = $this->product_model->calculate_lba_price($qty, $menu);
                            $total = $data['plainprice'];
                            $designprice = 0.00;
                            $printprice = $data['printprice'];
                            if ($labeltype == 'Mono') {
                                $printprice = $data['printprice'] - ($data['printprice'] * 0.05);   // 5% discount if Mono Printing
                            }

                        } else {
                            //$printprice = $this->home_model->calculate_printed_sheets($qty,$labeltype,1);
                            $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, 1, $ProductBrand, $menu);
                            $designprice = $printprice['desginprice'];
                            $printprice = $printprice['price'];
                            $printprice = $printprice + $designprice;
                        }

                        $Print_Design = '1 Design';

                    } else {

                        $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
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
                /****************Printed Labels Options*************/


            }

            if ($labels == null || $labels == "") {
                $pproduct = $this->getProductById($productid);
                $origQty = $pproduct['LabelsPerSheet'] * $qty;
                $LabelsPerRoll = $pproduct['LabelsPerSheet'];
            } else {
                $origQty = $labels * $qty;
            }


            if (isset($type) and $type == 'Rolls' and isset($regmark) and $regmark == "yes") {
                $origQty = $labels * $qty;
                $labeltype = 'Monochrome - Black Only';

                $lpr = $this->home_model->get_db_column("products", "LabelsPerSheet", "ManufactureID", $menu);
                $labelfinish = 'No Finish';
                //$persheets = $this->input->post('max_labels');
                $persheets = $this->input->post('labels');
                $values_array = array(
                    'labeltype' => $labeltype,
                    'labels' => $labels * $qty,
                    'design' => 1,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => 'Rolls',
                    'pressproof' => 0,
                    'finish' => $labelfinish);
                $response = $this->price_calculator($values_array);
                //$regmark_price = $this->home_model->currecy_converter($response['promotiondiscount'], 'yes');
                $regmark_price = $response['promotiondiscount'];
                $regmark_price = number_format($regmark_price, 2, '.', '');

                $price = $response['price'];
                $raw_plain = $response['plainlabelsprice'];
                $total = $regmark_price + $raw_plain;

                $A4Printing = array(
                    'Printing' => 'Y',
                    'Print_Type' => $labeltype,
                    'Print_Design' => 1,
                    'Free' => 1,
                    'Print_Qty' => 1,
                    'FinishType' => 'No Finish',
                    'wound' => 'Outside',
                    'regmark' => 'Y',
                    'orientation' => 1);
            }


            $unit_price = $total / $qty;
            $SID = $this->session->userdata('session_id');
            $items = array('SessionID' => $SID,
                'ProductID' => $productid,
                'Quantity' => $qty,
                'orignalQty' => $origQty,
                'UnitPrice' => $unit_price,
                'TotalPrice' => $total,
                'wound' => $wound,
                'OrderData' => $printtype,
                'is_custom' => $is_custom,
                'LabelsPerRoll' => $LabelsPerRoll,
                'colorcode' => $colorcode,
                'page_location' => 'Product Material',
                'added_from'=>'backoffice');
            $items = array_merge($items, $A4Printing);


            $userID = $this->session->userdata('UserID');
            if (isset($userID) and $userID != '') {
                $cart_reminder = $this->home_model->get_db_column("customers", "cart_reminder", "UserID", $userID);
                if (isset($cart_reminder) and $cart_reminder == "Y") {
                    $items['UserID'] = $userID;
                }
            }


            $this->db->insert('temporaryshoppingbasket', $items);

            if ($this->db->insert_id()) {
                if (isset($labeltype) and ($labeltype == 'Mono' || $labeltype == 'Fullcolour')) {

                    $data = array('CartID' => $this->db->insert_id(), 'status' => 'confirm');
                    $items_array = array('SessionID' => $SID, 'ProductID' => $productid, 'status' => 'temp');
                    $update = $this->db->update('integrated_attachments', $data, $items_array);
                }
            }

            $this->home_model->save_logs('add_to_cart', $items); //SAVE LOG

            $topcart_data = $this->ajax_topcart_load();
            echo json_encode(array('response' => 'yes', 'top_cart' => $topcart_data));


        }
    }

    public function getProductById($productId)
    {
        $query = $this->db->query("SELECT LabelsPerSheet from products WHERE ProductID = '$productId' ");
        $row = $query->row_array();
        return $row;
    }


    function view_artworks_content()
    {

        $rolls = 0;
        $manfactureid = $this->input->post('manfactureid');
        $product_id = $this->input->post('product_id');
        $labelspersheet = $this->input->post('labelspersheet');
        $print_type = $this->input->post('print_type');
        $initial_cartID = $cartid = $this->input->post('cart_id');
        $cartid = (isset($cartid) and $cartid != '') ? $cartid : time() . $product_id;
        $data['cartid'] = $cartid;
        $data['unitqty'] = $this->input->post('unitqty');
        $type = $this->input->post('type');
        $data['ProductID'] = $product_id;
        $data['type'] = $type;
        $data['LabelsPerSheet'] = $labelspersheet;
        $data['ManufactureID'] = $manfactureid;
        $total_price = '';
        $page = $this->input->post('page');
        if (isset($page) and $page == "reorder") {
            $actual_productID = $this->input->post('actual_productid');
            if (!$initial_cartID) {
                $sql = $this->db->query("select * from order_attachments_integrated where Serial = $product_id")->result_array();
                $qty = 0;
                foreach ($sql as $sq) {
                    $array = array('SessionID' => $this->session->userdata('session_id') . '-PRJB',
                        'ProductID' => $sq['ProductID'],
                        'file' => $sq['file'],
                        'name' => $sq['name'],
                        'Thumb' => $sq['Thumb'],
                        'labels' => $sq['labels'],
                        'qty' => $sq['qty'],
                        'source' => 'printing',
                        'type' => 'new',
                        'CartID' => $cartid,
                        'status' => 'confirm'
                    );

                    $this->db->insert('integrated_attachments', $array);
                    $qty += $sq['qty'];
                }
            }
            if (!$qty) {
                $qty = $this->input->post('qty');
            }
            $product_id = $actual_productID;
            $data['ProductID'] = $product_id;

            if ($type == "sheets") {
                $total_price = '';
                $url = base_url() . 'ajax/calculate_sheet_price';
                $ch = curl_init($url);
                $price_data = array(
                    'menuid' => $manfactureid,
                    'qty' => $qty,
                    'prd_id' => $actual_productID,
                    'labels' => $labelspersheet,
                    'labeltype' => $print_type,
                    'cart_id' => $cartid,
                );
                //echo"<Pre>";print_r($price_data);echo"</pre>";
                $payload = json_encode($price_data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $total_price = curl_exec($ch);
                //echo"<Pre>";print_r($total_price);echo"</pre>";exit;
                curl_close($ch);
            } else {

            }
        }

        $designs = $this->get_uploaded_number_design($cartid, $product_id);
        //die($this->db->last_query());
        $response = $this->home_model->get_total_uploaded_qty($cartid, $product_id);
        //die($this->db->last_query());
        if ($type == 'rolls') {
            $data['presproof'] = $this->input->post('presproof');
            $data['gap'] = $this->input->post('gap');
            $data['size'] = $this->input->post('size');
            $total = $response['labels'];
            $rolls = $response['sheets'];
        } else {
            if ($data['unitqty'] == 'Labels') {
                $total = $response['labels'];
            } else {
                $total = $response['sheets'];
            }
        }
        /*echo '<pre>';
        print_r($data); exit;*/

        $theHTMLResponse = $this->load->view('order_quotation/material/upload/upload_artwork_files', $data, true);

        echo json_encode(array('html' => $theHTMLResponse,
            'cartid' => $cartid,
            'qty' => $total,
            'rolls' => $rolls,
            'designs' => $designs,
            'total_price' => $total_price));
    }


    function upload_material_artworks()
    {
        $rolls = 0;
        //$json_data = array('response'=>'no', 'message' =>'failed to upload this file, please try again');
        //if (!empty($_FILES)) {

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


        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $response = $this->home_model->upload_images('file', '/');
        } else {
            $response = "";
        }
        //echo"<pre>";print_r($response);echo"</pre>";exit;
        //if($response!='error'){

        $sid = $this->session->userdata('session_id') . '-PRJB';
        $artowrk = array('SessionID' => $sid,
            'ProductID' => $productid,
            'CartID' => $cartid,
            'name' => $artworkname,
            'labels' => $labels,
            'qty' => $sheets,
            'file' => $response,
            'status' => 'confirm');

        $this->db->insert('integrated_attachments', $artowrk);

        $response = $this->home_model->get_total_uploaded_qty($cartid, $productid);
        $designs = $this->get_uploaded_number_design($cartid, $productid);

        if ($type == 'rolls') {
            $data['presproof'] = $this->input->post('presproof');
            $data['gap'] = $this->input->post('gap');
            $data['size'] = $this->input->post('size');
            $theHTMLResponse = $this->load->view('order_quotation/material/upload/roll_artwork_files', $data, true);
            $total = $response['labels'];
            $rolls = $response['sheets'];
        } else {

            $data['unitqty'] = $this->input->post('unitqty');
            if ($data['unitqty'] == 'Labels') {
                $total = $response['labels'];
            } else {
                $total = $response['sheets'];
            }
            $theHTMLResponse = $this->load->view('order_quotation/material/upload/a4_artwork_files', $data, true);
        }


        $json_data = array('response' => 'yes',
            'qty' => $total,
            'rolls' => $rolls,
            'designs' => $designs,
            'content' => $theHTMLResponse);
        //}
//}

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }
    
    
    
    function add_products_incart()
    {
        if ($_POST) {
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

            $manual_design = $this->input->post('manual_design');


            $design = $this->get_uploaded_number_design($cartid, $productid);
            if ($manual_design != 0) {
                $design = $manual_design;
            }

            $per_sheet = $this->input->post('labels');

            $wound = 'N';
            $printtype = '';
            $is_custom = 'No';
            $LabelsPerRoll = '';
            $A4Printing = array();

            $check = $this->user_model->isProductActive($menu);
            
            /*if ($check == 0) {

                $query = $this->db->query("SELECT `CategoryID` FROM `products` Where ManufactureID='" . $menu . "'");
                $result1 = $query->row_array();

                $roll_arr = array('R1', 'R2', 'R3', 'R4', 'R5');
                $categoryid = str_replace($roll_arr, '', $result1['CategoryID']);

                $url = base_url() . 'home/material/' . $categoryid;
                echo json_encode(array('deactive' => 'yes', 'url' => $url));
                exit();
            }*/

            if (isset($type) and $type == 'Rolls') {

                $woundoption = $this->input->post('woundoption');
                $orientation = $this->input->post('orientation');
                $cartid = $this->input->post('cartid');
                $labels = $this->input->post('labels');
                $labelfinish = $this->input->post('labelfinish');
                $persheets = $this->input->post('max_labels');
                $presproof = $this->input->post('presproof');
                $printing = $this->input->post('printing');


                $presproof = (isset($presproof) and $presproof == 1) ? 1 : 0;

                $presproof_charges = 0.00;
                if (isset($presproof) and $presproof == 1) {
                    $presproof_charges = 50.00;
                }


                $values_array = array('labeltype' => $printing,
                    'labels' => $labels,
                    'design' => 1,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => 'Rolls',
                    'pressproof' => $presproof,
                    'finish' => $labelfinish);
                    //echo"<pre>";print_r($values_array);echo"</pre>";
                    $response = $this->price_calculator($values_array);
                    //echo"<pre>";print_r($response);echo"</pre>";

                $rec = $this->home_model->get_total_uploaded_qty($cartid, $productid);
                //echo"<pre>";print_r($response);echo"</pre>";exit;
                
                
                 if ($design == 0 || $manual_design != 0) {
                     $labels = $uploaded_labels = $response['labels'];
                     $qty = $uploaded_rolls = $this->input->post('roll_qty');
                 }else{
                     $labels = $uploaded_labels = $rec['labels'];
                     $qty = $uploaded_rolls = $rec['sheets'];
                 }
                
                $LabelsPerRoll = ceil($labels / $qty);
                $is_custom = ($LabelsPerRoll == $persheets)?"No":"Yes";

                if ($uploaded_rolls > $response['rolls']) {
                    $additional_rolls = $uploaded_rolls - $response['rolls'];
                    $additional_cost = $this->home_model->additional_charges_rolls($additional_rolls);
                    $response['price'] = $response['price'] + $additional_cost;
                }

                $total = number_format($response['price'], 2, '.', '');

                if($design == 0 || $manual_design != 0) {
                    //$qty = $this->input->post('roll_qty');
                    //$LabelsPerRoll = ceil($response['labels'] / $qty);
                    
                    
                    //$is_custom = ($LabelsPerRoll == $persheets)?"No":"Yes";
                    //$labels = $response['labels'];
                }

                $Print_Design = '1 Design';
                if ($design > 1) {
                    $Print_Design = 'Multiple Designs';
                }

                $final_labels = (isset($final_labels) && $final_labels != 0) ? $final_labels : $labels;
                $A4Printing = array('Printing' => 'Y',
                    'Print_Type' => $printing,
                    'Print_Design' => $Print_Design,
                    'Free' => $response['artworks'],
                    'Print_Qty' => $design,
                    'Print_UnitPrice' => 0.00,
                    'Print_Total' => 0.00,
                    'wound' => $woundoption,
                    'is_custom' => $is_custom,
                    'LabelsPerRoll' => $LabelsPerRoll,
                    'orientation' => $orientation,
                    'pressproof' => $presproof,
                    'FinishType' => $labelfinish,
                    'orignalQty' => $final_labels,
                );


            } else {


                if (substr($menu, -2, 2) == 'XS') {
                    $printtype = $this->input->post('design');
                }
                /*****************WPEP Offer************/
                $ProductBrand = $this->ProductBrand($menu);
                $wpep_discount = 0.00;
                $data = $this->product_model->ajax_price($qty, $menu, $ProductBrand);
                $total = $data['custom_price'];

                /*if(preg_match("/A4 Labels/i",$ProductBrand) and (preg_match("/WPEP/i",$menu))){
                    $data['custom_price'] = ($data['custom_price']*1.2);
                    $wpep_discount = (($data['custom_price'])*(20/100));
                    $total = $data['custom_price']-$wpep_discount;
                    $total = $total/1.2;
                }
*/
                
                    
                    if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);

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
                /*****************WPEP Offer************/

                /****************Printed Labels Options*************/

                if ($ProductBrand == 'Application Labels') {
                    $colorcode = $this->input->post('colour');
                }


                if (isset($printing) and $printing == "Y" and $labeltype == "") {
                    $labeltype = 'Fullcolour';
                }

                if (preg_match('/Monochrome/', $labeltype)) {
                    $labeltype = 'Mono';
                }


                if (isset($labeltype) and ($labeltype == 'Mono' || $labeltype == 'Fullcolour')) {

                    $designprice = 0.00;
                    $printprice = $this->home_model->calculate_printed_sheets($qty, $labeltype, $design, $ProductBrand, $menu);
                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];

                    $printprice = $printprice + $designprice;

                    if (isset($source) and $source == "LBA") {
                        $total_labels = $per_sheet * $qty;
                        $perprice = round(($printprice / ($total_labels)), 3);
                        $printprice = $this->home_model->get_lba_uplift_price($qty, $printprice, $perprice, $total_labels);
                    }


                    $Print_Design = '1 Design';
                    if ($design > 1) {
                        $Print_Design = 'Multiple Designs';
                    }
                    if ($labeltype == 'Mono') {
                        $labeltype = 'Monochrome - Black Only';

                    } else {
                        $labeltype = '4 Colour Digital Process';
                    }
                    $A4Printing = array('Printing' => 'Y',
                        'Print_Type' => $labeltype,
                        'Print_Design' => $Print_Design,
                        'Free' => $free_artworks,
                        'Print_Qty' => $design,
                        'Print_UnitPrice' => $printprice,
                        'Print_Total' => $printprice,
                        'LabelsPerRoll' => $per_sheet);
                }
                if (isset($source) and $source == "LBA") {
                    $total_labels = $per_sheet * $qty;
                    $perprice = round(($total / ($total_labels)), 3);
                    $total = $this->home_model->get_lba_uplift_price($qty, $total, $perprice, $total_labels);
                }
                /****************Printed Labels Options*************/


            }

            $final_labels = (isset($final_labels) && $final_labels != 0) ? $final_labels : $qty;
            $unit_price = $total / $qty;
            $SID = $this->shopping_model->sessionid();

            $page_loc = "Product Material";
            if (isset($page) and $page == "reorder") {
                $page_loc = "User Reorder";
            }


            $items = array('SessionID' => $SID,
                'ProductID' => $productid,
                'Quantity' => $qty,
                'orignalQty' => $final_labels,
                'UnitPrice' => $unit_price,
                'TotalPrice' => $total,
                'source' => 'printing',
                'page_location' => $page_loc,
            );
            if ($source != NULL and $source != '') {
                $items['source'] = $source;
            }
            $items = array_merge($items, $A4Printing); 
            //echo"<pre>";print_r($items);echo"</pre>";exit;


            $userID = $this->session->userdata('userid');
            if (isset($userID) and $userID != '') {
                $cart_reminder = $this->home_model->get_db_column("customers", "cart_reminder", "UserID", $userID);
                if (isset($cart_reminder) and $cart_reminder == "Y") {
                    $items['UserID'] = $userID;
                }
            }


            $this->db->insert('temporaryshoppingbasket', $items);
            $insert_id = $this->db->insert_id();

            if ($this->db->insert_id()) {
                $design = ($source == "LBA") ? 0 : $design;
                if (isset($design) and $design > 0) {

                    $data = array('CartID' => $this->db->insert_id(), 'status' => 'confirm', 'SessionID' => $SID);
                    $items_array = array('SessionID' => $SID . '-PRJB', 'ProductID' => $productid, 'CartID' => $cartid);

                    if ($design == 1) {
                        if (isset($type) and $type == 'Rolls') {
                            $labels = $this->input->post('labels');
                        } else {
                            $labelspersheet = $this->input->post('labels');
                            $labels = $qty * $labelspersheet;
                        }
                        $data = array_merge($data, array('qty' => $qty, 'labels' => $labels));
                    }
                    $update = $this->db->update('integrated_attachments', $data, $items_array);
                } else if ($source == "LBA") {
                    //$userdesigns = $this->home_model->check_user_design($label_id);
                    $designdata = $this->home_model->get_user_lba_data($label_id);
                    $this->home_model->delete_abandon_design($label_id);
                    if (isset($type) and $type == 'Rolls') {
                        $labels = $this->input->post('labels');
                    } else {
                        $labelspersheet = $this->input->post('labels');
                        $labels = $qty * $labelspersheet;
                    }


                    $this->db->where('ID', $insert_id);
                    $this->db->update('temporaryshoppingbasket', array('user_project_id' => $designdata['ID'], 'Print_Qty' => 1));

                    $copy = FCPATH . 'Labeler/media/users/' . $designdata['Thumb'];
                    $paste = FCPATH . 'theme/integrated_attach/' . $designdata['Thumb'];
                    if (copy($copy, $paste)) {
                    } else {
                    };

                    $data = array(
                        'CartID' => $insert_id,
                        'status' => 'confirm',
                        'SessionID' => $SID,
                        'ProductID' => $productid,
                        'qty' => $qty,
                        'labels' => $final_labels,
                        'file' => $designdata['Thumb'],
                        'source' => 'web'
                    );
                    $this->db->insert('integrated_attachments', $data);
                }


            }

            $topcart_data = $this->cartModal->getCarTotalPrice();
            //$bottom_cart = "";
            //if($source == "LBA")
            // {
            //    $bottom_cart = $this->ajax_bottomcart_load();
            //}
            echo json_encode(array('response' => 'yes', 'top_cart' => $topcart_data, 'bottom_cart' => ""));


        }
    }


 


    function price_calculator($data)
    {
        //print_r($data); die();
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

        if ($producttype == 'sheet') {

            $sheets = ceil($labels / $persheets);
            //$sheets  = $labels;
            // $labels = $persheets*$labels;
            $ProductBrand = $this->ProductBrand($menu);
            $data = $this->product_model->ajax_price($sheets, $menu, $ProductBrand);

            //price_calculatorsss
            $price = $data['custom_price'];
            $printprice = 0.00;
            $designprice = 0.00;
            $free_artworks = 1;

            if ($labeltype == 'Mono' || $labeltype == 'Fullcolour') {
                $printprice = $this->home_model->calculate_printed_sheets($sheets, $labeltype, $design, 'A4 Label', $menu);
                $free_artworks = $printprice['artworks'];
                $designprice = $printprice['desginprice'];
                $printprice = $printprice['price'];
            }
        } else {
            $pressproof = $data['pressproof'];
            $rollfinish = $data['finish'];
            //$rolls = (isset($data['rolls']) and $data['rolls']!='')?$data['rolls']:'';
            $min_qty = $this->home_model->min_qty_roll($menu);

            $response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels);
            //print_r($response);
            /*echo "min_qty: $min_qty<br>";
            echo "persheets: $persheets<br>";
            echo "labels: $labels<br>";
            echo"<pre>";print_r($response);echo"</pre>";*/
            $labels = $response['total_labels'];
            $labels_per_rolls = $response['per_roll'];
            $sheets = $response['rolls'];

            $collection['labels'] = $labels;
            $collection['manufature'] = $menu;
            $collection['finish'] = $data['finish'];
            $collection['rolls'] = $sheets;
            $collection['labeltype'] = $labeltype;
            //echo"<pre>";print_r($collection);echo"</pre>";
            $price_res = $this->home_model->calculate_printing_price($collection);
            //echo"FINAL CONTROLLER PRINT <pre>";print_r($price_res);echo"</pre>";
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

        $delivery_txt = $this->shopping_model->delevery_txt();
        $ProductBrand = $this->ProductBrand($menu);
        
        
            
            if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);

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

        $plainprice = number_format($price, 2, '.', '');
        $price = $designprice + $printprice + $price + $pressproofprice;


        /*************** Roll Labels Wholesale Price *************/
        $userID = $this->session->userdata('Order_person');
        if ((isset($userID) and !empty($userID))) {
            $price = $this->quotationModal->apply_discount($userID, $menu, $price, 'roll');
        }
        /*************** Roll Labels Wholesale Price *************/


        $price = number_format($price, 2, '.', '');
        $pressproofprice = number_format($pressproofprice, 2, '.', '');
        $delivery_txt = '';
        if ($price > 25) {
            $delivery_txt = '<b> Free Delivery </b>';
        }

        if ($labels > 0) {
            $priceperlabels = number_format(($price / $labels), 3, '.', '');
        } else {
            $priceperlabels = 0.00;
        }


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
            'label_finish' => $label_finish);
        return $price_array;


    }

    function labels_price_breaks()
    {
        $mid = $this->input->post('mid');
        $data['type'] = $this->input->post('type');
        $data['mid'] = $mid;

        if (isset($data['type']) and $data['type'] == 'roll') {
            $data['breaks'] = $this->home_model->get_roll_against($mid);
            $data['LabelsPerSheet'] = $this->input->post('labels');
            $html = $this->load->view('order_quotation/material/price_breaks_roll', $data, true);

        } else if (isset($data['type']) and $data['type'] == 'application') {
            $data['breaks'] = $this->product_model->buypage($mid);
            $data['LabelsPerSheet'] = $this->input->post('labels');
            $html = $this->load->view('order_quotation/material/application_price_breaks', $data, true);
        } else {
            $data['breaks'] = $this->product_model->buypage($mid);
            $data['LabelsPerSheet'] = $this->input->post('labels');
            $html = $this->load->view('order_quotation/material/price_breaks', $data, true);
        }

        $json_data = array('response' => 'yes', 'html' => $html);
        $this->output->set_output(json_encode($json_data));
    }


    function application_popup()
    {
        $code = $groupname = $this->input->post('groupname');
        $type = $this->input->post('type');
        $groupname = str_replace(" - ", " ", $groupname);
        $groupname = str_replace("-", "_", $groupname);
        $groupname = str_replace("/", "_", $groupname);
        $groupname = str_replace("  ", " ", $groupname);
        $groupname = strtolower(str_replace(" ", "_", $groupname));
        $path = 'material_specification/applications/' . $type . '/' . $groupname;
        $theHTMLResponse = $this->load->view($path, '', true);
        //$theHTMLResponse    = $this->load->view('material/material_popup', $data, true);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('html' => $theHTMLResponse, 'group_name' => $code)));
    }

    function update_material_artworks()
    {
        $rolls = 0;
        $json_data = array('response' => 'no');
        if ($_POST) {

            $id = $this->input->post('id');
            $cartid = $this->input->post('cartid');
            $productid = $this->input->post('productid');
            $labels = $this->input->post('labels');
            $sheets = $this->input->post('sheets');
            $persheet = $this->input->post('persheet');
            $type = $this->input->post('type');


            $sid = $this->session->userdata('session_id') . '-PRJB';
            $artowrk = array('labels' => $labels,
                'qty' => $sheets,
                'status' => 'confirm');
            $this->db->update('integrated_attachments', $artowrk, array('ID' => $id));


            $data['cartid'] = $cartid;
            $data['ProductID'] = $productid;
            $data['LabelsPerSheet'] = $persheet;
            $data['type'] = $type;


            $response = $this->home_model->get_total_uploaded_qty($cartid, $productid);
            $designs = $this->get_uploaded_number_design($cartid, $productid);

            if ($type == 'rolls') {
                $data['presproof'] = $this->input->post('presproof');
                $data['gap'] = $this->input->post('gap');
                $data['size'] = $this->input->post('size');
                $theHTMLResponse = $this->load->view('order_quotation/material/upload/roll_artwork_files', $data, true);
                $total = $response['labels'];
                $rolls = $response['sheets'];


            } else {

                $data['unitqty'] = $this->input->post('unitqty');
                if ($data['unitqty'] == 'Labels') {
                    $total = $response['labels'];
                } else {
                    $total = $response['sheets'];
                }
                $theHTMLResponse = $this->load->view('order_quotation/material/upload/a4_artwork_files', $data, true);
            }

            $json_data = array('response' => 'yes',
                'qty' => $total,
                'rolls' => $rolls,
                'designs' => $designs,
                'content' => $theHTMLResponse);
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }

    function material_popup($id, $type = NULL)
    {

        if ($type == NULL) {
            $type = 'A4';
        }
        $data['id'] = $id;
        $qry = "SELECT * from products where ProductID='" . $id . "' ";
        $query = $this->db->query($qry);
        $res = $query->result();
        $data['allcats'] = $res;
        $data['type'] = $type;

        if (preg_match("/Roll Labels/is", $res[0]->ProductBrand)) {
            if ($res[0]->Material2 == 'Matt Colour Paper') {
                $code = 'mattcolours';
            } else {
                $code = $this->home_model->getmaterialcode(substr($res[0]->ManufactureID, 0, -1));
            }
            $path = 'order_quotation/material/specs/roll/' . $code;
        } else {

            if (preg_match("/Application Labels/is", $res[0]->ProductBrand)) {
                $res[0]->ManufactureID = substr($res[0]->ManufactureID, 0, -4);
            }

            if ($res[0]->Material2 == 'Matt Colour Paper') {
                $code = 'mattcolours';
            } else {
                $code = $this->home_model->getmaterialcode($res[0]->ManufactureID);
            }
            //$code =  $this->home_model->getmaterialcode($res[0]->ManufactureID);
            $path = 'order_quotation/material/specs/a4/' . $code;
        }

        //$data['material'] = (object) array('code'=>$code);
        $this->load->view('order_quotation/material/material_popup', $data);

        $res[0]->Image1 = str_replace(".gif", ".png", $res[0]->Image1);
        $img_path = aalables_path . 'images/material_images/' . $res[0]->Image1;
        $data['material'] = (object)['code' => $code];
        //echo $path;exit;
        $theHTMLResponse = $this->load->view($path, $data, true);
        //$theHTMLResponse    = $this->load->view('material/material_popup', $data, true);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('html' => $theHTMLResponse, 'mat_code' => $code, 'src' => $img_path)));


    }


    /*function grouped_product_info(){
        $image_path = '';
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
                    $image_path = Assets_path.'images/material_images/Roll/rectangle/'.$l_group.'/'.$material_code.'.png';
                }
                else
                {
                    $image_path = Assets_path.'images/material_images/Roll/'.strtolower($result['Shape'])."/".$material_code.'.png';
                }

                $thumbnail_path = $image_path;
                $img_found = "yes";
                $core = substr($categoryid,-1);
                $wound = strtolower($this->session->userdata('wound'));

                if($wound == "")
                {
                    $wound = "outside";
                }
                $roll_image = PATH."images/categoryimages/RollLabels/outside/".$result['ManufactureID'].".jpg";
                if(isset($wound) and $wound == "inside")
                {
                    $roll_image = PATH."images/categoryimages/RollLabels/inside/".$result['ManufactureID'].".jpg";
                }
                if(!getimagesize($roll_image))
                {
                    $catID = substr($result['CategoryID'],0,-2);
                    $cat_details = $this->home_model->fetch_category_details($catID);
                    $code = explode('.',$cat_details['CategoryImage']);
                    $roll_image = aalables_path."images/categoryimages/RollLabels/".$code[0].".jpg";
                    $img_found = "no";
                }
                $compatibily_type = 'roll';
            }
            else{
                $material_code = $this->home_model->getmaterialcode($result['ManufactureID']);
                $thumbnail_path = Assets_path.'images/material_images/sheets/'.$material_code.'.png';

                if(preg_match("/A4/",$result['ProductBrand'])){
                    $sheet_path = "A4Sheets";
                }

                else if(preg_match("/SRA3/",$result['ProductBrand'])){
                    $sheet_path = "SRA3Sheets";
                }

                else if(preg_match("/A3/",$result['ProductBrand'])){
                    $sheet_path = "A3Sheets";
                }
                $sheet_image = PATH."images/categoryimages/".$sheet_path."/colours/".$result['ManufactureID'].".png";
               // print_r(getimagesize($sheet_image));exit;
                if(!getimagesize($sheet_image))
                {
                    $cat_details = $this->home_model->fetch_category_details($result['CategoryID']);
                    $sheet_image = aalables_path."images/categoryimages/".$sheet_path."/".$cat_details['CategoryImage'];
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
            } /*

            if (preg_match("/A4 Labels/is", $result['ProductBrand']))
            {
                $promotional_discount = '';
                $mat_code = $this->home_model->getmaterialcode($result['ManufactureID']);
                $material_discount = $this->home_model->check_material_discount($mat_code);
                if($material_discount)
                {
                    $promotional_discount = ' <br /> <strong style="color:#fd4913"> Special Offer Save '.$material_discount.'% While Stocks Last </strong> ';
                }
            }
            $short_desc = $short_desc.' '.$promotion.' '.$promotional_discount;;

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

                'laser_img'=>aalables_path.'images/'.$comp['laser_img'],
                'inkjet_img'=>aalables_path.'images/'.$comp['inkjet_img'],
                'thermal_img'=>aalables_path.'images/'.$comp['thermal_img'],
                'd_thermal_img'=>aalables_path.'images/'.$comp['d_thermal_img'],

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
    }*/


    function grouped_product_info()
    {

        $image_path = '';
        $sheet_path = '';
        $min_labels_per_roll = 0;
        $max_labels = 0;
        $sheet_image = '';
        $roll_image = '';
        $thumbnail_path = '';
        $productid = $this->input->post('productid', true);
        $categoryid = $this->input->post('catid', true);
        $colour = $this->input->post('colour', true);
        $finish = $this->input->post('finish', true);
        $material = $this->input->post('material', true);
        $adhesive = $this->input->post('adhesive', true);
        $type = $this->input->post('type', true);
        $Lwidth = $this->input->post('width', true);
        $Lheight = $this->input->post('height', true);
        $condition = " (Activate='Y' || displayin='both' || displayin='backoffice') AND LabelFinish LIKE '" . $finish . "' AND ColourMaterial LIKE '" . $material . "' 
				AND LabelColor LIKE '" . $colour . "' AND CategoryID LIKE '" . $categoryid . "'";
        $adh_list = $this->db->query("SELECT Adhesive FROM `products` WHERE $condition 
				GROUP BY Adhesive order by ProductID asc ")->result_array();
        if (count($adh_list) > 0) {
            $prdexist = $this->db->query("Select count(*) as total from products where $condition 
					AND Adhesive LIKE '" . $adhesive . "'")->row_array();
            if ($prdexist['total'] == 0) {
                $adhesive = $adh_list[0]['Adhesive'];
            }
        }
        $cryogenic = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Cryogenic');
        $freezer = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Freezer');
        $heatrest = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Heat Resistant');
        $hightack = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'High Tack');
        $permanent = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Permanent');
        $removable = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Peelable');
        $sealable = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Resealable');
        $superperm = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Super Permanent');
        $waterres = $this->home_model->search_adhesive_in_array($adh_list, 'Adhesive', 'Water Resistant');

        $cryogenic_sel = ($adhesive == 'Cryogenic') ? 'selected="selected"' : '';
        $freezer_sel = ($adhesive == 'Freezer') ? 'selected="selected"' : '';
        $heatrest_sel = ($adhesive == 'Heat Resistant') ? 'selected="selected"' : '';
        $hightack_sel = ($adhesive == 'High Tack') ? 'selected="selected"' : '';
        $permanent_sel = ($adhesive == 'Permanent') ? 'selected="selected"' : '';
        $removable_sel = ($adhesive == 'Peelable') ? 'selected="selected"' : '';
        $sealable_sel = ($adhesive == 'Resealable') ? 'selected="selected"' : '';
        $superperm_sel = ($adhesive == 'Super Permanent') ? 'selected="selected"' : '';
        $waterres_sel = ($adhesive == 'Water Resistant') ? 'selected="selected"' : '';

        $adhesive_option = "<option value='' disabled='disabled' selected='selected'>Select Adhesive </option>";
        $adhesive_option .= "<option $cryogenic $cryogenic_sel value='Cryogenic'>Cryogenic</option>";
        $adhesive_option .= "<option  $freezer   $freezer_sel	 value='Freezer'>Freezer</option>";
        $adhesive_option .= "<option  $heatrest  $heatrest_sel  value='Heat Resistant'>Heat Resistant</option>";
        $adhesive_option .= "<option  $hightack  $hightack_sel  value='High Tack'>High Tack</option>";
        $adhesive_option .= "<option  $permanent $permanent_sel value='Permanent'>Permanent</option>";
        $adhesive_option .= "<option  $removable $removable_sel value='Peelable'>Peelable</option>";
        $adhesive_option .= "<option  $sealable  $sealable_sel  value='Resealable'>Re-sealable</option>";
        $adhesive_option .= "<option  $superperm $superperm_sel value='Super Permanent'>Super Permanent</option>";
        $adhesive_option .= "<option  $waterres  $waterres_sel  value='Water Resistant'>Water Resistant</option>";

        $condition .= " AND Adhesive LIKE '" . $adhesive . "'";
        $result = $this->db->query("Select * from products where $condition")->row_array();
        if (isset($result['ManufactureID']) and $result['ManufactureID'] != '') {
            $result['Image1'] = str_replace(".gif", ".png", $result['Image1']);
            if (preg_match("/Roll Labels/", $result['ProductBrand'])) {
                $material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'], 0, -1));
                if ($result['Shape'] == "Rectangle") {
                    $l_group = $this->home_model->get_rectangle_group($Lwidth, $Lheight);
                    $image_path = aalables_path . 'images/material_images/Roll/rectangle/' . $l_group . '/' . $material_code . '.png';
                } else {
                    $image_path = aalables_path . 'images/material_images/Roll/' . strtolower($result['Shape']) . "/" . $material_code . '.png';
                }
                $thumbnail_path = $image_path;
                $img_found = "yes";
                $core = substr($categoryid, -1);
                $wound = strtolower($this->session->userdata('wound'));

                if ($wound == "") {
                    $wound = "outside";
                }
                $roll_image = aalables_path . "images/categoryimages/RollLabels/outside/" . $result['ManufactureID'] . ".jpg";
                if (isset($wound) and $wound == "inside") {

                    $roll_image = aalables_path . "images/categoryimages/RollLabels/inside/" . $result['ManufactureID'] . ".jpg";

                }

                if (!getimagesize($roll_image)) {

                    $catID = substr($result['CategoryID'], 0, -2);

                    $cat_details = $this->home_model->fetch_category_details($catID);

                    $code = explode('.', $cat_details['CategoryImage']);

                    $roll_image = aalables_path . "images/categoryimages/RollLabels/" . $code[0] . ".jpg";

                    $img_found = "no";

                }

                $compatibily_type = 'roll';

            } else {

                $material_code = $this->home_model->getmaterialcode($result['ManufactureID']);

                $thumbnail_path = aalables_path . "images/categoryimages/" . $sheet_path . "/colours/" . $result['ManufactureID'] . ".png";


                if (preg_match("/A4/", $result['ProductBrand'])) {

                    $sheet_path = "A4Sheets";

                } else if (preg_match("/SRA3/", $result['ProductBrand'])) {

                    $sheet_path = "SRA3Sheets";

                } else if (preg_match("/A5/", $result['ProductBrand'])) {

                    $sheet_path = "A5Sheets";

                } else if (preg_match("/A5/", $result['ProductBrand'])) {

                    $sheet_path = "A3Sheets";

                }

                $sheet_image = aalables_path . "images/categoryimages/" . $sheet_path . "/colours/" . $result['ManufactureID'] . ".png";


                // print_r(getimagesize($sheet_image));exit;

                if (!getimagesize($sheet_image)) {

                    $cat_details = $this->home_model->fetch_category_details($result['CategoryID']);

                    $sheet_image = aalables_path . "images/categoryimages/" . $sheet_path . "/colours/" . $result['ManufactureID'] . ".png";

                }

                $compatibily_type = 'sheet';

            }

            $result['Material1'] = $this->home_model->get_db_column('material_tooltip_info', 'short_name', 'material_code', $material_code);

            $desc = $this->home_model->get_db_column('material_tooltip_info', 'tooltip_info', 'material_code', $material_code);


            $material_url = strtolower(str_replace(" ", "-", trim($result['Material1'])));

            $type_url = 'material-on-sheets';


            $max_length = 200;

            if (strlen($desc) > $max_length) {

                $offset = ($max_length - 3) - strlen($desc);

                $short_desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';

                $short_desc .= ' <a style="cursor:pointer;" data-toggle="tooltip-product" data-placement="top" data-original-title="' . $desc . '"><i>Read More</i></a>';

            } else {

                $short_desc = $desc;

            }


            $promotion = '';

            /*if (preg_match("/A4 Labels/is", $result['ProductBrand']) and ( preg_match("/WPEP/i", $result['ManufactureID']))) {

                  $promotion =' <br /> <strong style="color:#fd4913"> Special Offer Save 20% While Stocks Last </strong> ';

            } */


            
                
                
                
                if (preg_match("/A4 Labels/is", $result['ProductBrand']) || preg_match("/A5 Labels/is", $result['ProductBrand'])) {  //For A5 Sheet Discount
                $promotional_discount = '';
                    $mat_code = $this->home_model->getmaterialcode($result['ManufactureID']);

                    if (preg_match("/A5 Labels/is", $result['ProductBrand'])) {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A5');
                    } else {
                        $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');  
                    }

                if ($material_discount) {

                    $promotional_discount = ' <br /> <strong style="color:#fd4913"> Special Offer Save ' . $material_discount . '% While Stocks Last </strong> ';

                }

            }

            $short_desc = $short_desc . ' ' . $promotion . ' ' . $promotional_discount;;


            if (preg_match("/A3/", $result['ProductBrand'])) {

                $min_qty = '100';

                $max_qty = '50000';

            } else if (preg_match("/Roll Labels/", $result['ProductBrand'])) {

                $new_material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'], 0, -1));

                $type_url = 'material-on-rolls';


                $maxdiamter = $this->input->post('maxdiamter');

                $Labelsgap = $this->input->post('Labelsgap');

                $height = $this->input->post('height');

                if (isset($maxdiamter) and $maxdiamter != 0) {

                    $total_labels = $this->home_model->get_max_labels_printer($result['ManufactureID'], $result['LabelsPerSheet'], $maxdiamter, $Labelsgap, $height);

                    if (isset($total_labels) and $total_labels != 0 and $total_labels <= $result['LabelsPerSheet']) {

                        $result['LabelsPerSheet'] = $total_labels;

                    }

                }


                $min_qty = $this->home_model->min_qty_roll($result['ManufactureID']);

                $max_qty = $this->home_model->max_qty_roll($result['ManufactureID']);


                $min_labels_per_roll = $this->home_model->min_labels_per_roll($min_qty);

                $max_labels = $this->home_model->max_total_labels_on_rolls($result['LabelsPerSheet']);


            } else if (preg_match("/SRA3/", $result['ProductBrand'])) {

                $min_qty = '100';

                $max_qty = '20000';

            } else {

                if (preg_match("/PETC/", $result['ManufactureID']) || preg_match("/PETH/", $result['ManufactureID']) || preg_match("/PVUD/", $result['ManufactureID'])) {

                    //$min_qty = '25';

                    $min_qty = '5';

                    $max_qty = '5000';

                } else {

                    $min_qty = '25';

                    $max_qty = '50000';

                }

            }


            $comp = $this->home_model->grouping_compatiblity($result['SpecText7'], $compatibily_type);


            $url = base_url() . $type_url . '/' . $material_url . '/products/';

            $new_material_code = $this->home_model->getmaterialcode($result['ManufactureID']);

            if (preg_match("/Roll Labels/", $result['ProductBrand'])) {

                $new_material_code = $this->home_model->getmaterialcode(substr($result['ManufactureID'], 0, -1));

                if ($img_found == "no") {

                    $new_material_code = "WTP";

                }

            } else {

                $new_material_code = $this->home_model->getmaterialcode($result['ManufactureID']);

            }

            echo json_encode(array('adhesive_option' => $adhesive_option,

                'image_path' => $image_path,

                'product_name' => $result['Material1'],

                'product_description' => $short_desc,

                'product_id' => $result['ProductID'],

                'manfactureid' => $result['ManufactureID'],

                'material_code' => $new_material_code,

                'material_code_new' => $material_code,

                'Printable' => $result['Printable'],

                //'Printable'=>'N',

                'minimum' => $min_qty,

                'maximum' => $max_qty,

                'minprintedlabels' => $min_labels_per_roll,

                'max_labels' => $max_labels,


                'laser_img' => aalables_path . 'images/' . $comp['laser_img'],

                'inkjet_img' => aalables_path . 'images/' . $comp['inkjet_img'],

                'thermal_img' => aalables_path . 'images/' . $comp['thermal_img'],

                'd_thermal_img' => aalables_path . 'images/' . $comp['d_thermal_img'],


                'laser_text' => $comp['laser_text'],

                'inkjet_text' => $comp['inkjet_text'],

                'thermal_text' => $comp['thermal_text'],

                'd_thermal_text' => $comp['d_thermal_text'],


                'filter_color' => $result['LabelColor_upd'],

                'filter_finish' => $result['LabelFinish_upd'],

                'filter_material' => $result['ColourMaterial_upd'],

                'url' => $url,

                'sheet_image' => $sheet_image,

                'roll_image' => $roll_image,

                'thumbnail_path' => $thumbnail_path,

                'category_description' => $result['ProductCategoryName'],

                'EuroID' => $result['EuroID'],

            ));

        } else {

            echo json_encode(array('response' => 'notfound'));

        }


    }


    function calculate_roll_price()
    {
        if (!$_POST) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        if ($_POST) {

            $roll = $this->input->post('roll');
            $menu = $this->input->post('menuid');
            $labels = $this->input->post('labels');
            $prd_id = $this->input->post('prd_id');
            $diameter = $this->input->post('diameter');
            $printing = $this->input->post('printing');
            $printing_enabled = $this->input->post('printing_enabled');
            $manual_design = $this->input->post('manual_design');
            $roll_qty = $this->input->post('roll_qty');


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
                $values_array = array(
                    'labeltype' => $printing,
                    'labels' => $labels,
                    'design' => 1,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => 'Rolls',
                    'pressproof' => $presproof,
                    'finish' => $labelfinish);

                $response = $this->price_calculator($values_array);
                //print_r($response);exit;
                $promotiondiscount = $response['promotiondiscount'];
                $plainlabelsprice = $response['plainlabelsprice'];
                $label_finish = $response['label_finish'];

                $rec = $this->home_model->get_total_uploaded_qty($cartid, $prd_id);

                $uploaded_labels = $rec['labels'];
                $uploaded_rolls = $rec['sheets'];

                if ($roll_qty != "") {
                    $uploaded_rolls = $roll_qty;
                }

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
                $per_labels = $labels . '  Labels, ' . symbol . $per_labels . ' per label';

                echo json_encode(array('response' => 'yes',
                    'price' => $price_txt,
                    'plainPrice' => $price,
                    'printPrice' => ($printprice - $presproof_charges + $promotiondiscount),
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


            } else if (isset($labels) and $labels > 99) {
                $latest_price = $this->home_model->calclateprice($menu, $roll, $labels);

                $delivery_txt = $this->shopping_model->delevery_txt();
                $price = $latest_price['final_price'];
                //$per_labels = $latest_price['perlabel'];
                //$perprice = $latest_price['unit_prcie'];

                $price = $this->home_model->currecy_converter($price, 'yes');
                $raw_plain = symbol . number_format($price, 2, '.', '');
                if (isset($regmark) and $regmark == "yes") {


                    $labelfinish = 'No Finish';
                    // $persheets = $this->input->post('max_labels');
                    $persheets = $this->input->post('max_labels');
                    $values_array = array(
                        'labeltype' => 'Monochrome - Black Only',
                        'labels' => $labels * $roll,
                        'design' => 1,
                        'menu' => $menu,
                        'persheets' => $persheets,
                        'producttype' => 'Rolls',
                        'pressproof' => 0,
                        'finish' => $labelfinish);
                    //print_r($values_array);exit;
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
                //echo $material_discount;exit;
                if ($material_discount) {
                    $wpep_discount = (($price) * ($material_discount / 100));
                    $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                    $price = number_format(($price - $wpep_discount), 2, '.', '');
                    $dis_img = '<img src="' . aalables_path . 'images/discount_' . $material_discount . '.png">';
                }

                $price_txt = '<b class="color-orange"> ' . $wpep_discount_txt . symbol . $price . $dis_img . ' </b> <br />' . vatoption . ' VAT';
                $per_labels = round(($price / ($labels * $roll)), 3);
                $per_labels = $labels * $roll . '  Labels, ' . symbol . $per_labels . ' per label';

                $onlyprintprice = 0;
                $printprice = '0.00';
                $printprice = $this->input->post('printprice'); //enabled
                if (isset($printprice) and $printprice == 'enabled') {
                    // $persheets = $this->input->post('max_labels');
                    $persheets = $this->input->post('max_labels');
                    $totallabels = $roll * $labels;
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

                echo json_encode(array('response' => 'yes',
                    'price' => $price_txt,
                    'delivery_txt' => $delivery_txt,
                    'plainPrice' => $price,
                    'printPrice' => number_format($printprice, 2),
                    'labelprice' => $per_labels,
                    'diameter' => $diamter,
                    'printprice' => number_format($printprice, 2),
                    'onlyprintprice' => number_format($onlyprintprice, 2),
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'raw_plain' => $raw_plain,
                    'regmark_price' => $regmark_price));

            }
        }

    }


    public function getWholeSaleCustomerPrice($response)
    {
        $userID = $this->session->userdata('userid');

        $customer = $this->getCustomer($userID);

        if ($customer->wholesale == 'wholesale') {

            $response['price'] = number_format(($response['price'] - (($response['price'] * $customer->printed_discount) / 100)), 2);
            $response['plainprint'] = number_format(($response['plainprint'] - (($response['plainprint'] * $customer->printed_discount) / 100)), 2);
            $response['plainprice'] = number_format(($response['plainprice'] - (($response['plainprice'] * $customer->printed_discount) / 100)), 2);

            return $response;

        } else {
            return $response;
        }

    }

    public function getCustomer($customerId)
    {
        $results = $this->db->select("c.*")
            ->from('customers as c')
            ->where('c.UserID', $customerId)
            ->get()->row();
        return $results;
    }

    function get_printer_model()
    {
 
        $make = $this->input->post('make');
        $trigger = $this->input->post('trigger');
        $option = '<option value="" >Select Model</option>';
        $count = 0;
        if (isset($trigger) and $trigger == 'printers') {
            $option = '<option value="" >Select Manufacturer</option>';
            $htm = '<div class="row"><div class="printer m-t-10 row">';
            $printers = $this->home_model->get_printer();
            foreach ($printers as $make) {
                $option .= '<option value="' . strtolower($make->ManufacturerCode) . '" >' . $make->Name . '</option>';
                $htm .= '<div data-value="' . strtolower($make->ManufacturerCode) . '" class="col-xs-6 col-md-2 text-center manufaturer">';
                $htm .= '<span class="thumbnail"  >';
                $htm .= '<img alt="" src="' . aalables_path . 'images/printer/make/' . $make->printer_image . '">' . $make->Name . '</span></div>';
            }
            $htm .= '</div></div>';
            $count = count($printers);
        } else if ($make) {

            $model = $this->home_model->get_printer_model($make);
            $htm = '<div class="row"><div class="printer m-t-10 row">';
           
            foreach ($model as $row) {

                $row->method = str_replace("/", ",", $row->method);
                $option .= '<option value="' . urlencode(strtolower($row->model)) . '" >' . $row->Name . '</option>';
                $htm .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 " >';
                $htm .= '<div class="thumbnail">';
                $htm .= '<div class=" text-center">';
                error_reporting(0);
                if (getimagesize('' . aalables_path . 'images/printer/model/' . $row->image) !== false) {
                    $src = '' . aalables_path . 'images/printer/model/' . $row->image;
                } else {
                    $src = 'https://www.aalabels.com/images/no-image.png';
                }
                if ($row->specfication != "") {
                    $spec = substr($row->specfication, 0, 100);
                } else {
                    $spec = "";
                }
                $htm .= '<img width="185" height="155" title="' . $row->image . '" src="' . $src . '" alt="labels Image "></div>';

                $htm .= '<div class="caption3" style="margin-top: 20px !important;padding: 0 9px;">';
                $htm .= '<h2>' . $row->Name . '</h2>';
                $htm .= '<p style="font-size: 13px !important;line-height: 16px;">' . $spec . '</p>';
                $htm .= '<div class="row" style="padding: 10px;">';
                $htm .= '<p class="col-md-12" ><strong>Compatibility:</strong> ' . $row->method . '</p> ';
                $htm .= '<p class="col-md-12"><strong>Maximum Print Size:</strong> ' . $row->PrintWidth . ' mm</p></div>';
                $htm .= '<a data-value="' . urlencode(strtolower($row->model)) . '" id="' . $row->model . '" role="button" class="btn btn-outline-primary waves-light waves-effect width-select od_not_detail printer_model " >';
                $htm .= '<i class="fa fa-arrow-circle-right"></i> Select </a></div></div></div>';

            }
            $htm .= '</div></div>';

            $count = count($model);
        }
        echo json_encode(array('model_data' => $htm, 'model' => $option, 'count_format' => number_format($count, 0)));
    }


    function layout_popup($catid, $manid = NULL)
    {
        if (substr($catid, -2, 1) == 'R') {
            if (preg_match('/r1|r2|r3|r4|r5/is', $catid)) {
                $new_code_exp = explode("R", $catid);
                $catid = $new_code_exp[0];
            }
        }

        $details = $this->home_model->fetch_category_details($catid);
        if (preg_match("/Roll/", $details['CategoryName'])) {
            $img_src = aalables_path . "images/categoryimages/rollimages/" . $details['CategoryImage'];
            $height = 'auto';
            $pop_width = '200';

        } else if (preg_match("/SRA3/", $details['CategoryName'])) {
            $img_src = aalables_path . "images/categoryimages/SRA3Sheets/" . $details['CategoryImage'];
            $height = 'auto';
            $pop_width = '200';
        } else if (preg_match("/A5/", $details['CategoryName'])) {
            $img_src = aalables_path . "images/categoryimages/A5Sheets/" . $details['CategoryImage'];
            $height = 'auto';
            $pop_width = '185';
        } else if (preg_match("/A3/", $details['CategoryName'])) {
            $img_src = aalables_path . "images/categoryimages/A3Sheets/" . $details['CategoryImage'];
            $height = 'auto';
            $pop_width = '200';
        } else {

            if (isset($manid) && $manid != "") {

                $img_src = aalables_path . "images/categoryimages/A4Sheets/colours/" . $manid . '.png';
            } else {

                $img_src = aalables_path . "images/categoryimages/A4Sheets/" . $details['CategoryImage'];

            }

            $pop_width = '189';
            $height = 'auto';
        }

        $data['img_src'] = $img_src;
        $data['pop_width'] = $pop_width;
        $data['height'] = $height;
        $data['details'] = $details;
        $data['catname'] = $details['CategoryName'];
        //print_r($data['img_src']);exit;
        $theHTMLResponse = $this->load->view('order_quotation/material/layout_popup', $data, true);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('html' => $theHTMLResponse)));
    }


    function comparison_popup()
    {
        $cats = $this->input->post('cats');
        $type = $this->input->post('type');

        $catdetails = array();
        $ProductBrand = "";
        foreach ($cats as $catid) {
            $manuID = '';
            if (isset($type) and $type == 'product') {
                $manuID = $catid;
                $catid = $this->home_model->get_db_column('products', 'CategoryID', 'ManufactureID', $manuID);
                $ProductBrand = $this->home_model->get_db_column('products', 'ProductBrand', 'ManufactureID', $manuID);
                $SpecText7 = $this->home_model->get_db_column('products', 'SpecText7', 'ManufactureID', $manuID);
            }
            if (substr($catid, -2, 1) == 'R') {
                if (preg_match('/r1|r2|r3|r4|r5/is', $catid)) {
                    $new_code_exp = explode("R", $catid);
                    $catid = $new_code_exp[0];
                }
                $Roll = $this->home_model->min_qty_roll($manuID);
                $price = $this->home_model->calclateprice($manuID, $Roll, 100);
                $price = $price['final_price'];
                $data['min_labels'] = $Roll * 100;
            } else {
                if (preg_match('/A4/', $ProductBrand)) {
                    $qty_count = 25;
                } else {
                    $qty_count = 100;
                }
                $ProductBrand = $this->ProductBrand($manuID);
                $price = $this->product_model->ajax_price($qty_count, $manuID, $ProductBrand);
                $price = $price['custom_price'];
            }

            $details = $this->home_model->fetch_category_details($catid);
            $details['price'] = $price;
            $details['type'] = $type;
            if (isset($type) and $type == 'product') {
                $details['ManufactureID'] = $manuID;
                $details['SpecText7'] = $SpecText7;
            }
            $catdetails[] = $details;
        }
        $data['catdetails'] = $catdetails;
        $data['pageName'] = '';
        $data['catname'] = '';
        //echo"<pre>";print_r($catdetails);echo"</pre>";exit;
        $theHTMLResponse = $this->load->view('order_quotation/compare_popup', $data, true);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('html' => $theHTMLResponse)));
    }

    function setwoundoption()
    {
        $option = $this->input->post('option');
        $cate = $this->input->post('cate');
        $this->session->set_userdata('wound', $option);
        $this->session->set_userdata('wound-cat', $cate);

    }

    public function selectLine()
    {

        $id = $this->input->post('id', true);
        $val = $this->input->post('val', true);
        $update = array(
            'active' => $val
        );
        $this->quotationModal->updatequoteitem($id, $update);

    }


    public function getColours()
    {
        $material = explode('-', $this->input->post('material'));
        $condition = "Material1 = '" . $material[4] . "' AND LabelFinish LIKE '" . $material[1] . "' AND ColourMaterial LIKE '" . $material[2] . "' AND CategoryID LIKE '" . $material[5] . "'";
        $data['type'] = $material[0];
        $data['values'] = $this->home_model->grouping_product_material_colours($condition);
        $this->load->view('order_quotation/material/cmbColourField', $data);
    }

    public function getAdhesives()
    {
        $material = explode('-', $this->input->post('material'));
        $condition = "Material1 = '" . $material[4] . "' AND LabelFinish LIKE '" . $material[1] . "' AND ColourMaterial LIKE '" . $material[2] . "' AND CategoryID LIKE '" . $material[5] . "'";
        $data['type'] = $material[0];
        $data['values'] = $this->home_model->grouping_product_material_adhesive($condition);
        $this->load->view('order_quotation/material/cmbAdhesiveField', $data);
    }


    function view_printed_artworks_content()
    {
        $total_price = 0;
        $rolls = 0;
        $manfactureid = $this->input->post('manfactureid');
        $product_id = $this->input->post('product_id');
        $labelspersheet = $this->input->post('labelspersheet');
        $print_type = $this->input->post('print_type');
        $initial_cartID = $cartid = $this->input->post('cart_id');
        $cartid = (isset($cartid) and $cartid != '') ? $cartid : time() . $product_id;
        $data['cartid'] = $cartid;
        $data['unitqty'] = $this->input->post('unitqty');
        $type = $this->input->post('type');
        $data['ProductID'] = $product_id;
        $data['type'] = $type;
        $data['LabelsPerSheet'] = $labelspersheet;
        $data['ManufactureID'] = $manfactureid;

        $page = $this->input->post('page');
        if (isset($page) and $page == "reorder") {
            $actual_productID = $this->input->post('actual_productid');
            if (!$initial_cartID) {
                $sql = $this->db->query("select * from order_attachments_integrated where Serial = $product_id")->result_array();
                $qty = 0;
                foreach ($sql as $sq) {
                    $array = array('SessionID' => $this->session->userdata('session_id') . '-PRJB',
                        'ProductID' => $sq['ProductID'],
                        'file' => $sq['file'],
                        'name' => $sq['name'],
                        'Thumb' => $sq['Thumb'],
                        'labels' => $sq['labels'],
                        'qty' => $sq['qty'],
                        'source' => 'printing',
                        'type' => 'new',
                        'CartID' => $cartid,
                        'status' => 'confirm'
                    );

                    $this->db->insert('integrated_attachments', $array);
                    $qty += $sq['qty'];
                }
            }
            if (!$qty) {
                $qty = $this->input->post('qty');
            }
            $product_id = $actual_productID;
            $data['ProductID'] = $product_id;

            if ($type == "sheets") {
                $total_price = '';
                $url = base_url() . 'ajax/calculate_sheet_price';
                $ch = curl_init($url);
                $price_data = array(
                    'menuid' => $manfactureid,
                    'qty' => $qty,
                    'prd_id' => $actual_productID,
                    'labels' => $labelspersheet,
                    'labeltype' => $print_type,
                    'cart_id' => $cartid,
                );
                //echo"<Pre>";print_r($price_data);echo"</pre>";
                $payload = json_encode($price_data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $total_price = curl_exec($ch);
                //echo"<Pre>";print_r($total_price);echo"</pre>";exit;
                curl_close($ch);
            } else {

            }
        }

        $designs = $this->get_uploaded_number_design($cartid, $product_id);
        //die($this->db->last_query());
        $response = $this->home_model->get_total_uploaded_qty($cartid, $product_id);
        //die($this->db->last_query());
        if ($type == 'rolls') {
            $data['presproof'] = $this->input->post('presproof');
            $data['gap'] = $this->input->post('gap');
            $data['size'] = $this->input->post('size');
            $total = $response['labels'];
            $rolls = $response['sheets'];
        } else {
            if ($data['unitqty'] == 'Labels') {
                $total = $response['labels'];
            } else {
                $total = $response['sheets'];
            }
        }
        $theHTMLResponse = $this->load->view('order_quotation/material/upload/upload_printed_artwork_files', $data, true);
        echo json_encode(array('html' => $theHTMLResponse,
            'cartid' => $cartid,
            'qty' => $total,
            'rolls' => $rolls,
            'designs' => $designs,
            'total_price' => $total_price));
    }


    function calculate_max_allowed_roll(){
        $matInfo = $this->cartModal->fetchmaterinfo($this->input->post('matId'));
        $record = $this->cartModal->fetchdierecordinfo($matInfo['OID']);

        $menu = $record['die_code'] . $matInfo['material'];
        $labels = $this->input->post('labels');

        $this->home_model->calculate_max_allowed_roll($menu, $labels);
    }


    function calculate_roll_price_new()
    {

        if (!$_POST) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        if ($_POST) {


            $core = $size = $this->input->post('size');

            $matInfo = $this->cartModal->fetchmaterinfo($this->input->post('matId'));
            $record = $this->cartModal->fetchdierecordinfo($matInfo['OID']);

            $productCode = $record['die_code'] . $matInfo['material'];
            //$productCode = $record['die_code'] . $matInfo['material'] . $this->getLastCode($core);
            $cors = 1;
            if ($core != "") {
                $cors = $this->getLastCode($core);
            }

            $minqty = $this->cartModal->calulate_min_rolls($productCode . $cors);
            $minLabels = $this->cartModal->calulate_min_labels($productCode . $cors);

            $product = $this->cartModal->getProductId($productCode);

            $maxLabels = $product['LabelsPerSheet'];
            //$productCode = 'RR152102WTP1';


            $roll = $this->input->post('roll');
            $menu = $productCode . $cors;

            $labels = $this->input->post('labels');
            //print_r($labels); exit;
            $prd_id = $product['ProductID'];

            $printing = $this->input->post('printing');
            $printing_enabled = "";
            $gap = "";

            $matId = "";
            $matId = $this->input->post('matId');
            $design = $this->input->post('design');


            $array = array(
                'qty' => $roll,
                'designs'=>$design,
                'rolllabels' => $labels,
                'printing' => $printing,
                'finish' => $this->input->post('labelfinish'),
                'core' => $size,
                'wound' => $this->input->post('wound')
            );

            $this->db->where('ID', $this->input->post('matId'));
            $this->db->update('flexible_dies_mat', $array);


            $shapes = $this->input->post('shape');
            if ($shapes == 'Irregular' && $record['die_code'] == "") {
                $espo = array(

                    'TotalPrice' => '0.00',
                    'halfprintprice' => '0.00',
                    'onlyprintprice' => '0.00',
                    'plainlabelsprice' => '0.00',
                    'label_finish' => '0.00',
                    'additional_cost' => '0.00',
                    'additional_rolls' => '0.00',
                    'presproof_charges' => '0.00',
                    'labelprice' => '0.00',
                    'diameter' => '0.00',
                    'symbol' => '0.00',
                    'vatoption' => '0.00',
                    'rawprice' => '0.00'
                );

                echo json_encode(array('petoo' => $espo, 'html' => $this->LoadCheckout(), 'response' => 'yes'));
                exit;
            }


            $save_txt = '';
            $regmark_price = symbol . '0.00';
            if (isset($printing_enabled) and $printing_enabled == "Y" and $printing == "") {
                $printing = "Fullcolour";
            }


            if (isset($printing) and $printing != '') {

                $cartid = $this->input->post('matId');

                $diamter = $this->home_model->get_auto_diameter($menu, $labels, $gap, $size);
                $presproof = $this->input->post('presproof');
                $presproof = (isset($presproof) and $presproof == 1) ? 1 : 0;
                $presproof_charges = 0.00;
                if (isset($presproof) and $presproof == 1) {
                    $presproof_charges = 50.00;
                }

                $labelfinish = $this->input->post('labelfinish');
                $persheets = $maxLabels;

                //echo $labels * $roll;
                $values_array = array(
                    'labeltype' => $printing,
                    'labels' => $labels,
                    'design' => 1,
                    'menu' => $menu,
                    'persheets' => $persheets,
                    'producttype' => 'Rolls',
                    'pressproof' => $presproof,
                    'finish' => $labelfinish);

                $response = $this->price_calculator($values_array);
                //print_r($response);
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

                $per_labels = round(($price / $labels), 3);


                $espo = array(

                    'TotalPrice' => ($printprice - $presproof_charges + $promotiondiscount),
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
                    'rawprice' => $price
                );

                $all_lb = $labels * $roll;
                $unitPrice = $price / $all_lb;
                $UnitPrice = number_format(round($unitPrice, 3), 3, '.', '');

                $datas = array(
                    'Quantity' => $roll,
                    'orignalQty' => $labels,
                    'LabelsPerRoll' => $labels / $roll,
                    'UnitPrice' => $UnitPrice,
                    'source' => 'printing',
                    'is_custom' => 'Yes'
                );


                $cookie = @$_COOKIE['ci_session'];
                $cookie = stripslashes($cookie);
                $cookie = unserialize($cookie);
                $cisess_session_id = $cookie['session_id'];
                $session_id = $this->session->userdata('session_id');
                $productID = $product['ProductID'];

                $where = "(SessionID = '" . $session_id . "' OR SessionID ='" . $cisess_session_id . "' ) AND ID = '" . $matId . "' AND ProductID = '" . $productID . "' ";

                $this->db->where($where);
                $this->db->update('temporaryshoppingbasket', $datas);

                $qry = $this->db->query("select * from flexible_dies_mat where ID = $matId")->row_array();
                $this->updateQuotationDetailRecord($matId, $price);


                $qry['printprice'] = 0;
                $qry['plainprice'] = $price;
                $qry['tempprice'] = (($price) <= 0) ? '0' : '1';
                $this->db->where('ID', $matId);
                $this->db->update('flexible_dies_mat', $qry);
                echo json_encode(array('New' => $espo, 'html' => $this->LoadCheckout(), 'response' => 'yes'));


            } else if (isset($labels) and $labels > 99) {

                //echo 'else';
                $labels = ($labels / $roll);

                //print_r($labels); exit;
                $latest_price = $this->home_model->calclateprice($menu, $roll, $labels);
                $delivery_txt = $this->shopping_model->delevery_txt();
                $price = $latest_price['final_price'];


                $price = $this->home_model->currecy_converter($price, 'yes');
                $raw_plain = symbol . number_format($price, 2, '.', '');

                $diamter = $this->home_model->get_auto_diameter($menu, $labels, $gap, $size);

                $wpep_discount_txt = '';
                $dis_img = '';
                $material_code = $this->home_model->getmaterialcode(substr($menu, 0, -1));
                $material_discount = $this->home_model->check_material_discount($material_code, 'Roll');
                //echo $material_discount;exit;

                if ($material_discount) {
                    $wpep_discount = (($price) * ($material_discount / 100));
                    $wpep_discount_txt = '<small class="discount_price">' . symbol . $price . ' </small>';
                    $price = number_format(($price - $wpep_discount), 2, '.', '');
                    $dis_img = '<img src="' . aalables_path . 'images/discount_' . $material_discount . '.png">';
                }


                $per_labels = round(($price / ($labels * $roll)), 3);
                $per_labels = $labels * $roll . '  Labels, ' . symbol . $per_labels . ' per label';

                $onlyprintprice = 0;
                $printprice = '0.00';

                $printprices = '';
                if ($printing == "") {
                    $printprices = 'enabled'; //enabled
                }


                if (isset($printprice) and $printprices == 'enabled') {
                    //echo 'sds';
                    $persheets = $maxLabels;
                    $totallabels = $labels;
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
                    //print_r($response);
                    $printprice = $this->home_model->currecy_converter($response['price'], 'yes');
                    $printprice = number_format($printprice, 2, '.', '');
                }

                $onlyprintprice = $response['promotiondiscount'];

                $erop = array(
                    'plainPrice' => $price,
                    'printPrice' => number_format($printprice, 2),
                    'labelprice' => $per_labels,
                    'diameter' => $diamter,
                    'printprice' => number_format($printprice, 2),
                    'onlyprintprice' => number_format($onlyprintprice, 2),
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'raw_plain' => $raw_plain,
                    'regmark_price' => $regmark_price);


                $all_lb = $labels * $roll;
                $unitPrice = $price / $all_lb;
                $UnitPrice = number_format(round($unitPrice, 3), 3, '.', '');

                $datas = array(
                    'Quantity' => $roll,
                    'orignalQty' => $labels,
                    'LabelsPerRoll' => $labels / $roll,
                    'UnitPrice' => $UnitPrice,
                );


                $cookie = @$_COOKIE['ci_session'];
                $cookie = stripslashes($cookie);
                $cookie = unserialize($cookie);
                $cisess_session_id = $cookie['session_id'];
                $session_id = $this->session->userdata('session_id');
                $productID = $product['ProductID'];

                $where = "(SessionID = '" . $session_id . "' OR SessionID ='" . $cisess_session_id . "' ) AND ID = '" . $matId . "' AND ProductID = '" . $productID . "' ";

                $this->db->where($where);
                $this->db->update('temporaryshoppingbasket', $datas);

                $qry = $this->db->query("select * from flexible_dies_mat where ID = $matId")->row_array();
                $this->updateQuotationDetailRecord($matId, $price);
                $qry['printprice'] = 0;
                $qry['plainprice'] = $price;
                $qry['tempprice'] = (($price) <= 0) ? '0' : '1';
                $this->db->where('ID', $matId);
                $this->db->update('flexible_dies_mat', $qry);

                echo json_encode(array('new' => $erop, 'html' => $this->LoadCheckout(), 'response' => 'yes'));

            }
        }

    }


    public function updateQuotationDetailRecord($id, $price = null)
    {

        $qry = $this->db->query("select * from flexible_dies_mat where ID = $id")->row_array();
        $flxinfo = $this->db->query("select * from flexible_dies_info where ID = '" . $qry['OID'] . "'")->row_array();
        $cart = $this->db->query("select * from temporaryshoppingbasket where ID = '" . $flxinfo['CartID'] . "'")->row_array();
        $quodetail = $this->db->query("select * from quotationdetails where SerialNumber = '" . $flxinfo['QID'] . "'")->row_array();
        $quodetail['die_approve'] = 'N';
        $this->db->where('SerialNumber', $flxinfo['QID']);
        $this->db->update('quotationdetails', $quodetail);

    }

    public function LoadCheckout()
    {

        $records = $this->cartModal->getAllProducts();
        //echo '<pre>'; print_r($records); echo '</pre>';
        $data['records'] = $this->productCalculation($records);
        $data['digitalis'] = $this->cartModal->digitalPrintingProcess($records);

        //echo '<pre>'; print_r($records); echo '</pre>';
        $record = $this->takeHtmlAndPrintData('order_quotation/checkout/temp_products_lists', $data);
        return $record;
    }


    public function productCalculation($records)
    {
        $final = array();

        //echo '<pre>'; print_r($records); echo '</pre>';
        $price = 0;

        foreach ($records as $record) {

            $materialprice = 0;
            $carRes = $this->user_model->getCartData($record->ID);
            if (isset($carRes[0]) && $carRes[0]->ID != "" && $record->p_code == 'SCO1') {


                $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);

                $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);

                $materialprice = 0;
                foreach ($assoc as $rowp) {
                    //echo $rowp->printprice;
                    $materialprice += ((int)$rowp->plainprice + (int)$rowp->printprice);
                    //$materialpriceinc = $materialprice * 1.2;
                }
            }

            $price += $record->TotalPrice + $record->Print_Total + $materialprice;

            $record->total = +$price;
            $manufactureId = $this->cartModal->getProductManufactureId($record->ProductID);
            $calculations = $this->cartModal->getProductCalculation($record->ProductID, $manufactureId['ManufactureID']);
            $record->calculations = $calculations;
            $final[] = $record;
        }
        return $final;
    }


    function calculate_sheet_priceCustomDiesSheets()
    {
        if (!$_POST) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }
        if ($_POST) {

            $matid = $this->input->post('matId');
            $cart_id = '';
            $qty = $this->input->post('qty');
            $menu = $this->input->post('menuid');
            $labels = $this->input->post('labels');
            $labeltype = $this->input->post('labeltype');
            $productid = $this->input->post('prd_id');
            $requestfrom = $this->input->post('requestfrom');
            $printing = $this->input->post('printing');
            $design = $this->input->post('designs');

            $bran = $this->input->post('formats');
            $newlb = '';
            $matInfo = $this->cartModal->fetchmaterinfo($matid);
            $record = $this->cartModal->fetchdierecordinfo($matInfo['OID']);

            if ($bran == 'SRA3') {
                $newlb = 'SRA3 Label';
                $menu = 'SRDD06' . $matInfo['material'];
            }

            if ($bran == 'A4') {
                $newlb = 'A4 Label';
                $menu = 'AAA024' . $matInfo['material'];
            }

            if ($bran == 'A3') {
                $newlb = 'A3 Label';
                $menu = 'A3C048' . $matInfo['material'];
            }


            $array = array(
                'qty' => $qty,
                'designs' => $design,
                'rolllabels' => $labels,
                'printing' => $printing,

            );

            $this->db->where('ID', $matid);
            $this->db->update('flexible_dies_mat', $array);


            if (isset($cart_id) and $cart_id != '') {
                $design = $this->get_uploaded_number_design($cart_id, $productid);
            } else {
                $design = $this->get_number_design($productid);
            }

            $save_txt = '';
            $ProductBrand = $this->ProductBrand($menu);


            if (isset($printing) and $labeltype == "printed") {
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

                    $free_artworks = $printprice['artworks'];
                    $designprice = $printprice['desginprice'];
                    $printprice = $printprice['price'];
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
                $dis_img = '';

               
                    
                    if (preg_match("/A4 Labels/is", $ProductBrand) || preg_match("/A5 Labels/is", $ProductBrand)) {  //For A5 Sheet Discount
                    $mat_code = $this->home_model->getmaterialcode($menu);

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
                    $per_labels = $showlabels . ' Labels / ' . $qty . ' Sheets, ' . symbol . $perprice . ' per label';
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


                $response = array(

                    'printprice' => number_format($printprice, 2),
                    'halfprintprice' => number_format($printprice * 2, 2),
                    'onlyprintprice' => number_format($onlyprintprice, 2),
                    'designprice' => $designprice,
                    'artworks' => $free_artworks,
                    'nodesing' => $design,
                    'plain' => $plain,
                    'type' => $printoption,
                    'labelprice' => $per_labels,
                    'symbol' => symbol,
                    'vatoption' => vatoption,
                    'promotion_price_txt' => $promotion_price_txt,
                    'original_price' => $original_price,
                    'percentage_discount' => $material_discount,
                    'rawprice' => $price);


                $all_lb = $labels * $qty;
                $unitPrice = $price / $all_lb;
                $UnitPrice = number_format(round($unitPrice, 3), 3, '.', '');

                $datas = array(
                    'Quantity' => $qty,
                    'orignalQty' => $labels,
                    'LabelsPerRoll' => $labels,
                    'UnitPrice' => $UnitPrice,
                );


                $cookie = @$_COOKIE['ci_session'];
                $cookie = stripslashes($cookie);
                $cookie = unserialize($cookie);
                $cisess_session_id = $cookie['session_id'];
                $session_id = $this->session->userdata('session_id');
                $productID = $product['ProductID'];

                $where = "(SessionID = '" . $session_id . "' OR SessionID ='" . $cisess_session_id . "' ) AND ID = '" . $matId . "' AND ProductID = '" . $productID . "' ";

                $this->db->where($where);
                $this->db->update('temporaryshoppingbasket', $datas);


                $qry = $this->db->query("select * from flexible_dies_mat where ID = $matid")->row_array();

                $matInfo = $this->cartModal->fetchmaterinfo($matid);
                $recordss = $this->cartModal->fetchdierecordinfo($matInfo['OID']);

                $pr_dbl = ($price * 2);


                //print_r($qry);exit;

                if ($qry['labeltype'] == "printed") {
                    $qry['printprice'] = 0;
                    $qry['plainprice'] = $price;

                } else {
                    $qry['printprice'] = 0;
                    $qry['plainprice'] = $price;
                }


                $qry['tempprice'] = ((($qry['plainprice'] > 0) || ($qry['printprice'] > 0))) ? '1' : '0';
                //print_r($qry);exit;
                $this->db->where('ID', $matid);
                $this->db->update('flexible_dies_mat', $qry);
                $this->updateQuotationDetailRecord($matid, $qry['tempprice']);
                echo json_encode(array('New' => $response, 'html' => $this->LoadCheckout(), 'response' => 'yes'));


                //echo json_encode($response);
            }
        }
    }


    public function getLastCode($val)
    {
        if ($val == 25) {
            return 1;
        } else if ($val == 38) {
            return 2;
        } else if ($val == 44.5) {
            return 3;
        } else if ($val == 76) {
            return 4;
        }
    }


    public function remove_all_temp_artworkPro()
    {

        $pro_id = $this->input->post('product_id');
        $SID = $this->session->userdata('session_id') . '-PRJB';

        $filess = $this->get_all_temp_artPro($pro_id, $SID);

        foreach ($filess as $fil) {
            @unlink(PATH . '/' . $fil);
        }

        $this->db->delete('integrated_attachments', array("ProductID" => $pro_id, "SessionID" => $SID));
    }


    public function remove_all_cart_artworkPro()
    {

        $pro_id = $this->input->post('product_id');
        $SID = $this->session->userdata('session_id');
        $cartid = $this->input->post('cartID');

        $pages = $this->input->post('pages');
        $order_number = $this->input->post('orderNumber');
        $serial_no = $this->input->post('serialNumber');


        if ($pro_id != "" || $SID != "" || $cartid != "") {


            if ($pages == "order_detail_page") {

                $filess = $this->get_all_order_artPro($serial_no);
                foreach ($filess as $fil) {
                    @unlink(PATH . '/' . $fil);
                }

                if($serial_no!="" && $serial_no!=0 && $serial_no!='0'){
                    $this->db->delete('order_attachments_integrated', array("Serial" => $serial_no, "ProductID" => $pro_id));
                }

            } else if ($pages == "quotaton_detail") {

                $filess = $this->get_all_quotation_artPro($serial_no);
                foreach ($filess as $fil) {
                    @unlink(PATH . '/' . $fil);
                }
                if($serial_no!="") {
                    $this->db->delete('quotation_attachments_integrated', array("Serial" => $serial_no, "ProductID" => $pro_id));
                }
            } else {
                $filess = $this->get_all_temp_artPro($pro_id, $SID);
                foreach ($filess as $fil) {
                    @unlink(PATH . '/' . $fil);
                }

                if($cartid!="") {
                    $this->db->delete('integrated_attachments', array("ProductID" => $pro_id, "SessionID" => $SID, "CartID" => $cartid));
                }
            }

        }

    }


    function get_all_temp_artPro($pro_id, $SID)
    {

        $this->db->select('file');
        $this->db->from('integrated_attachments');
        $this->db->where(array("ProductID" => $pro_id, "SessionID" => $SID));
        return $this->db->get()->result_array();

    }


    function get_all_order_artPro($Serial)
    {

        $this->db->select('file');
        $this->db->from('order_attachments_integrated');
        $this->db->where(array("Serial" => $Serial));
        return $this->db->get()->result_array();

    }


    function get_all_quotation_artPro($Serial)
    {
        $this->db->select('file');
        $this->db->from('quotation_attachments_integrated');
        $this->db->where(array("Serial" => $Serial));
        return $this->db->get()->result_array();
    }


}

