<?php


/*Home Model For aalabels - Author: Arslan Javaid - 6-6-2015 */


class Home_model extends CI_Model
{


    function __construct()
    {


        parent::__construct();


    }


    function user_login_ajax()
    {
        if ($this->session->userdata('login_user_id') == null || $this->session->userdata('login_user_id') == "") {
            return redirect(main_url);
        }
    }


    /*----Category functions---*/


    public function printing_order_items($ordernumber)
    {
        $row = $this->db->query("select count(*) as total from orderdetails WHERE OrderNumber LIKE '" . $ordernumber . "' and Printing LIKE 'Y'")->row_array();
        return $row['total'];
    }


    function fetch_dies_data($condition, $sort = NULL, $limit = NULL)
    {


        if ($sort != NULL) {


            $sort = ' Order by ' . $sort;


        } else {


            $sort = ' Order by LabelsPerSheet,p.ManufactureID ASC';


        }


        $qry2 = $this->db->query("SELECT c.CategoryID,c.specification1,c.specification2,c.specification3,c.pdfFile,c.InnerHole,c.InnerLabel,c.Width,



				c.wordFile, c.CategoryName, c.CategoryImage,c.LabelWidth,c.LabelHeight,c.Shape,p.ProductName,p.ManufactureID,p.ProductID,p.SpecText7,p.ProductBrand FROM category c , products p 



				WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice') and  " . $condition . " GROUP BY c.CategoryID $sort $limit");


        $data = array('num_row' => $qry2->num_rows(), 'list' => $qry2->result());


        return $data;


    }


    function category_shapes($condition)
    {
        $shapes = $this->db->query("SELECT DISTINCT(c.Shape) AS Shapes from category c , products p 
        WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND " . $condition);
        return $shapes->result();
    }


    function category_lables_persheet($condition)
    {


        $labels = $this->db->query("SELECT DISTINCT(p.LabelsPerSheet) AS LabelsPerSheet from category c , products p  



				WHERE c.CategoryID = p.CategoryID and  " . $condition . " Order by LabelsPerSheet ASC");


        return $labels->result();


    }


    function labelsfinder_field_list($field, $condition)
    {


        $qry = "SELECT $field from products p , category  c where SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID 



					AND  $field != '' and (p.Activate ='Y' or p.Activate ='y' || p.displayin='both' || p.displayin='backoffice') AND $condition group by $field order by $field ASC";


        $query = $this->db->query($qry);


        $result = $query->result();


        return $result;


    }


    function labelfinder_data($condition, $sort = NULL, $start = NULL, $groupby = NULL, $limiter = NULL, $div_open = NULL)
    {


        if ($sort != NULL) {


            $sort = ' Order by LabelsPerSheet ' . $sort;


        } else {


            $sort = ' Order by LabelsPerSheet ASC';


        }


        if ($start == NULL) {
            $start = 0;
        }


        if ($limiter == NULL) {
            $limiter = 12;
        }


        $qry = "SELECT p.ManufactureID,c.CategoryID, c.CategoryImage, c.CategoryName, c.specification3,p.ProductID,p.ManufactureID, p.ProductName,



			     		 



						  p.SpecText7,p.ProductBrand,p.ProductCategoryName,p.LabelsPerSheet,c.Shape FROM products p,category c



						   WHERE  SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND " . $condition . " AND (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice') $groupby $sort limit $start ,$limiter";


        $query = $this->db->query($qry);


        return $query->result();


    }


    function get_selected_template($template)
    {


        $qry = "SELECT p.ManufactureID,c.CategoryID, c.CategoryImage, c.CategoryName, c.specification3,p.ProductID,p.ManufactureID, p.ProductName,p.SpecText7,c.LabelWidth,c.LabelHeight,c.specification1,c.specification2,



						  p.ProductBrand,p.ProductCategoryName,p.LabelsPerSheet,c.Shape FROM products p,category c



						   WHERE  SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND p.ProductID = $template AND (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice') ";


        $query = $this->db->query($qry);


        return $query->row_array();


    }


    function labelfinder_counter($condition, $groupby = NULL)
    {


        if ($groupby) {


            $qry = "SELECT count(DISTINCT(LEFT( p.ManufactureID, CHAR_LENGTH( p.ManufactureID ) -1 ))) as total FROM products p,category c WHERE  SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND " . $condition . "  AND (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice')";


        } else {


            $qry = "SELECT count(*) as total FROM products p,category c WHERE  SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID 



				AND " . $condition . "  AND (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice')";


        }


        $query = $this->db->query($qry);


        $result = $query->row_array();


        return $result['total'];


    }


    function make_productBrand_condtion($type)
    {

        if (preg_match("/SRA3/i", $type)) {
            $brand = 'SRA3 Label';
        } else if (preg_match("/A3/i", $type)) {

            $brand = 'A3 Label';
        } else if (preg_match("/Roll/i", $type)) {
            $brand = 'Roll Labels';
        } else if (preg_match("/Integrated/i", $type)) {
            $brand = 'Integrated Labels';
        } else if (preg_match("/A5/i", $type)) {
            $brand = 'A5 Labels';
        } else {
            $brand = 'A4 Labels';
        }
        return $brand;
    }


    /***************materials Functions********/

    function ReplaceHtmlToString_($text)
    {


        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        );
        return $string = preg_replace(array_keys($utf8), array_values($utf8), $text);

    }

    function show_product($pid)
    {
        $qry = $this->db->query("SELECT * FROM products WHERE ProductID  = " . $pid . "");
        return $qry->row_array();
    }

    public function gerroll_pro_name_fr($proid)
    {
        $row = $this->db->query("select ProductName from products where ProductID = $proid")->row_array();
        return $row['ProductName'];

    }

    function get_translated_version($value)
    {
        $translated_option = trim(strtolower(str_replace("-", "_", $value)));
        $translated_option = trim(strtolower(str_replace("/", "_", $translated_option)));
        $translated_option = trim(strtolower(str_replace(" - ", "_", $translated_option)));
        $translated_option = trim(strtolower(str_replace(" ", "_", $translated_option)));
        $translated_text = $this->lang->line('labelfilter_option_' . $translated_option);

        if (isset($translated_text) and $translated_text != '') {
            $value = $translated_text;
        }
        return $value;
    }

    public function fetch_product_name($data)
    {
        $this->lang->load('genral_lang');
        $type = $this->make_productBrand_condtion($data['ProductBrand']);
        if ($type == "Rolls") {
            $data['ProductName'] = $this->gerroll_pro_name_fr($data['ProductID']);
            $pname = explode('-', $data['ProductName']);
            $prodname = $this->get_translated_version(trim($pname[0]));
            $pdetails = explode(" - ", $data['ProductCategoryName']);
            $LabelSize = str_replace("label size ", "", $pdetails[1]);

            $catname = $this->lang->line('placeholder_roll_labels') . ' - ' . $this->lang->line('placeholder_labelsize') . ' ' . $LabelSize;
            $catname = str_replace("mm Circle", $this->lang->line('labelfilter_option_circular'), $catname);
            $Adhesive = $this->lang->line('labels_material_adhesive');
            $completeName = $prodname . ' ' . $this->get_translated_version($data['Adhesive']) . ' ' . $Adhesive . ' ' . $catname;
        } else {
            $completeName = $this->get_translated_long_desciption($data['ProductCategoryName'], $type);
        }
        $data['ProductCategoryName'] = $completeName;
        $completeName = $this->customize_product_name_fr($data);
        return $completeName;
    }

    public function customize_product_name_fr($data)
    {
        $custom = $data['is_custom'];
        $ProductCategoryName = $data['ProductCategoryName'];
        $LabelsPerRoll = $data['LabelsPerRoll'];
        $LabelsPerSheet = $data['LabelsPerSheet'];
        $ReOrderCode = $data['ReOrderCode'];
        $manuid = $data['ManufactureID'];
        $ProductBrand = $data['ProductBrand'];
        $wound = $data['Wound'];
        $data['Source'] = $data['Printing'];
        // $printed= $data['OrderData'];
        $printed = '';


        if ($wound == 'Y') {
            $wound_opt = $this->lang->line('placeholder_inside_wound');
        } else {
            $wound_opt = $this->lang->line('placeholder_outside_wound');
        }

        if (isset($data['Source']) and $data['Source'] == 'Y' and preg_match('/Roll Labels/is', $ProductBrand)) {

            $labeltype = $this->get_db_column('digital_printing_process', 'name_fr', 'name', $data['Print_Type']);
            $productname = explode("-", $ProductCategoryName);
            $productname[1] = str_replace("(", "", $productname[1]);
            $productname[1] = str_replace(")", "", $productname[1]);
            $productname[0] = str_replace("rolls labels", "", $productname[0]);
            $productname[0] = str_replace("roll labels", "", $productname[0]);
            $productname[0] = str_replace("Roll Labels", "", $productname[0]);
            $productname = "Étiquettes imprimées sur rouleaux - " . str_replace("roll label", "", $productname[0]) . ' - ' . $productname[1];
            $completeName = ucfirst($productname) . ' ' . $wound_opt . ' - Orientation ' . $data['Orintation'] . ', ';

            if ($data['FinishType'] == "Gloss Lamination") {
                $finish_type_fr = 'Lamination Gloss';
            } else if ($data['FinishType'] == "Matt Lamination") {
                $finish_type_fr = 'Matt Lamination';
            } else if ($data['FinishType'] == "Matt Varnish") {
                $finish_type_fr = 'Vernis mat';
            } else if ($data['FinishType'] == "Gloss Varnish") {
                $finish_type_fr = 'Vernis brillant';
            } else if ($data['FinishType'] == "High Gloss Varnish") {
                $finish_type_fr = 'Vernis a haute brillance';

            } else if ($data['FinishType'] == "High Gloss Varnish") {
                $finish_type_fr = 'Vernis a haute brillance';
            } else {
                $finish_type_fr == 'No Finish';
            }

            if ($data['FinishType'] == 'No Finish') {
                $labelsfinish = ' Finition de l\'étiquette: aucune ';
            } else {
                $labelsfinish = ' Finition de l\'étiquette : ' . $finish_type_fr;
            }
            $completeName .= $labeltype . ' ' . $labelsfinish;

            return $completeName;

        }
        if ($custom == 'Yes') {
            $productname = explode("-", $ProductCategoryName);
            $completeName = $productname[0] . $LabelsPerRoll . " " . $this->lang->line('placeholder_labels_per_roll') . ", " . $wound_opt . " - " . $productname[1];
            $diamter = $this->calculate_rolls_diamter($manuid, $LabelsPerRoll);
            $completeName = $completeName . " " . $this->lang->line('placeholder_roll_diamter') . ' ' . $diamter;

        } else {
            if (preg_match('/Roll Labels/is', $ProductBrand)) {
                $productname = explode("-", $ProductCategoryName);

                $completeName = $productname[0] . $LabelsPerSheet . " " . $this->lang->line('placeholder_labels_per_roll') . ", " . $wound_opt . " - " . $productname[1];
                $diamter = $this->calculate_rolls_diamter($manuid, $LabelsPerSheet);
                $completeName = $completeName . " " . $this->lang->line('placeholder_roll_diamter') . ' ' . $diamter;


            } else {
                $completeName = $ProductCategoryName;
                if (substr($manuid, -2, 2) == 'XS') {
                    $completeName = $completeName . ", Conception: " . $printed;
                }
                /**********WPEP Voucher Offer*************/
                if (preg_match("/A4/i", $ProductBrand) and (preg_match("/WPEP/i", $manuid))) {
                    //$completeName =  $completeName." <span style='color:#fd4913;'>( 20% discount) </span>";
                }
                /**********WPEP Voucher Offer*************/
            }
        }
        if ($ReOrderCode) {
            $completeName = $completeName . " Réorganiser le code " . $ReOrderCode;
        }


        /******************Sample Order implementation***********************/
        if ($printed == 'Sample') {
            $completeName = $completeName . " - Échantillon ";
        }
        /******************Sample Order implementation***********************/

        return $completeName;

    }

    function get_translated_long_desciption($value, $type)
    {
        if ($type == 'Rolls') {
            return $value;
        } else if ($type == 'Integrated') {
            $name = explode("-", $value);
            $adhesivetype = explode(" ", trim($name[1]));
            $shapesize = explode(" ", trim($name[2]));
            $material = $this->get_translated_version($name[0]);
            $adhesive = strtolower($this->get_translated_version($adhesivetype[0]));
            $Labels = $shapesize[0];

            $Shape = $this->get_translated_version($adhesivetype[1] . ' ' . $adhesivetype[2]);

            $labelSize = $name[3];

            if ($Labels > 1) {
                $étiquette = 'Étiquettes';
            } else {
                $étiquette = 'Étiquette';
            }
            return $étiquette . ' ' . strtolower($Shape) . ' - ' . $material . ' -  ' . $adhesive . '  - ' . $Labels . ' ' . $étiquette . ' par feuille A4 - ' . $labelSize;
        } else {
            $name = explode("-", $value);
            $adhesivetype = explode(" ", trim($name[1]));
            $shapesize = explode(" ", trim($name[2]));

            $material = $this->get_translated_version($name[0]);

            $adhesive = $this->get_translated_version($adhesivetype[0]);


            $Labels = $shapesize[0];
            $Shape = $this->get_translated_version($shapesize[1]);

            $labelSize = $name[3];

            if ($Labels > 1) {
                $étiquette = 'étiquettes';
            } else {
                $étiquette = 'étiquette';
            }

            return $material . ' - ' . $adhesive . ' ' . $Labels . ' ' . $étiquette . '  ' . strtolower($Shape) . ' par feuille ' . $type . ' - ' . $labelSize;
        }
    }

    public function manufactureid($domain, $id)
    {
        if ($domain == '123') {
            $ManufactureID = '123ManufactureID';
        } else {
            $ManufactureID = 'ManufactureID';
        }
        $this->db->select($ManufactureID);
        $this->db->where('ProductID', $id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->$ManufactureID;
    }

    public function LabelsPerSheet($id)
    {
        $this->db->select('LabelsPerSheet');
        $this->db->where('ProductID', $id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->LabelsPerSheet;
    }

    public function get_total_labels($serial)
    {
        $no_of_labels = $this->db->query("select sum(labels) as total_labels from order_attachments_integrated where Serial = $serial ")->row_array();
        return $no_of_labels['total_labels'];
    }

    function getManufactureID($pID)
    {


        $qury = $this->db->query("Select ManufactureID FROM products WHERE ProductID LIKE '" . $pID . "' LIMIT 1");


        $row = $qury->row_array();


        return $row['ManufactureID'];


    }


    function getProductID($meunID)
    {


        $qury = $this->db->query("Select ProductID FROM products WHERE ManufactureID LIKE '" . $meunID . "' LIMIT 1");


        $row = $qury->row_array();


        return $row['ProductID'];


    }


    function roll_core_sizes_finder($catid, $menuid)
    {


        //$ManufactureID = substr($menuid,0,-1);


        $query = $this->db->query("Select * from categorycore INNER JOIN rollcore ON rollcore.CoreId =categorycore.CoreId 



		where categorycore.CategoryId='" . $catid . "' and categorycore.Active='Y' ");


        $result = $query->result();


        $select = '';


        foreach ($result as $row) {


            $productId = $this->getProductID($menuid . str_replace("R", "", $row->CoreId));


            $coresize = preg_replace("/Core size/", "", $row->CoreSize);


            $select .= '<option  value="' . $productId . '">' . $coresize . '</option>';


        }


        return $select;


    }


    function roll_core_sizes($catid, $coreid = NULL)
    {


        $query = $this->db->query("Select * from categorycore INNER JOIN rollcore ON rollcore.CoreId =categorycore.CoreId 



		where categorycore.CategoryId='" . $catid . "' and categorycore.Active='Y' ");


        $result = $query->result();


        $select = '';


        foreach ($result as $row) {


            $coresize = preg_replace("/Core size/", "", $row->CoreSize);


            if ($coreid == $row->CoreId) {


                $selecetd = 'selected="selected"';


            } else {


                $selecetd = '';


            }


            $select .= '<option  ' . $selecetd . ' value="' . $row->CoreId . '">' . $coresize . '</option>';


        }


        return $select;


    }


    function fetch_sheets_materials($catid = NULL, $productid = NULL, $other = NULL)
    {
        if ($catid != NULL) {


            if ($productid != NULL and $other != NULL) {


                $query = $this->db->query("SELECT * FROM `products` WHERE ProductID <> '$productid' AND CategoryID = '$catid' and (Activate='Y' || displayin='both' || displayin='backoffice') AND `ManufactureID` NOT LIKE '%-XS' order by sortBy asc");


                return $query->result();


            } else if ($productid != NULL) {


                $query = $this->db->query("SELECT * FROM `products` WHERE ProductID = '$productid' and (Activate='Y' || displayin='both' || displayin='backoffice') AND `ManufactureID` NOT LIKE '%-XS' order by sortBy asc");


                return $query->result();


            } else {


                $query = $this->db->query("SELECT * FROM `products` WHERE CategoryID = '$catid' and (Activate='Y' || displayin='both' || displayin='backoffice') AND `ManufactureID` NOT LIKE '%-XS' order by sortBy asc");


                return $query->result();


            }


        }


    }


    function fetch_category_details($catid = NULL)
    {

        //print_r('k'); exit;
        //print_r($catid); exit;

        if ($catid != NULL) {


            $query = $this->db->query("select * from category where CategoryID = '$catid' AND (CategoryActive='Y' || displayin='both' || displayin='backoffice') ");


            return $query->row_array();


        }


    }


    function avery_equilent($catid)
    {


        $query = $this->db->query("SELECT AveryCode FROM tbl_avery_compatible WHERE CategoryID = '" . $catid . "' and AverySizes = 'Y'");


        $row = $query->row_array();


        if (isset($row['AveryCode'])) {


            return $row['AveryCode'];


        }


    }


    function distinct_material_paper($condtion)
    {


        $query = $this->db->query("SELECT DISTINCT(ColourMaterial) AS Material FROM `products` WHERE $condtion and (Activate='Y' || displayin='both' || displayin='backoffice')



								   and ColourMaterial!='' order by ColourMaterial asc");


        return $query->result();


    }


    function distinct_material_adhisive($condtion)
    {


        $query = $this->db->query("SELECT DISTINCT(Adhesive) AS Adhesive FROM `products` WHERE $condtion and (Activate='Y' || displayin='both' || displayin='backoffice')



								   and Adhesive!='' order by Adhesive asc");


        return $query->result();


    }


    function distinct_material_color($condtion)
    {


        $query = $this->db->query("SELECT DISTINCT(LabelColor) AS Color FROM `products` WHERE $condtion and (Activate='Y' || displayin='both' || displayin='backoffice')



								        and LabelColor!='' order by LabelColor asc");


        return $query->result();


    }


    function ajax_material_sorting($condtion)
    {


        $query = $this->db->query("SELECT * FROM `products` WHERE $condtion AND (Activate='Y' || displayin='both' || displayin='backoffice') AND `ManufactureID` NOT LIKE '%-XS' order by priority_upd asc");


        return $query->result();


    }


    function make_size_option($list, $field, $name, $selec = NULL)
    {


        $option = '';


        if (count($list) == 1) {


            foreach ($list as $a_row) {


                $selected = '';


                if ($a_row->$field == $selec) {
                    $selected = 'selected="selected"';
                }


                $option .= '<option value="' . $selec . '" ' . $selected . '>' . str_replace('.00', ' ', $a_row->$field) . ' mm</option>';


            }


        } else {


            $option = '<option value="" > ' . $name . ' </option>';


            foreach ($list as $a_row) {


                $selected = '';


                if ($a_row->$field == $selec) {
                    $selected = 'selected="selected"';
                }


                $option .= '<option value="' . $a_row->$field . '" ' . $selected . '>' . str_replace('.00', ' ', $a_row->$field) . ' mm</option>';


            }


        }


        return $option;


    }


    function make_html_option($list, $field, $name, $selec = NULL)
    {


        $page = $this->input->post('page');


        $text = '';


        $option = '';


        $value = '';


        if ($field == 'LabelsPerSheet') {


            $text = ' Labels per sheet';


        }


        if (count($list) == 1) {


            $option = '<option value="" > ' . $name . ' </option>';


            foreach ($list as $a_row) {


                $selected = '';


                if ($a_row->$field == $selec) {


                    $selected = 'selected="selected"';


                }


                $value = $a_row->$field;


                if ($field == 'SpecText7') {


                    $category = $this->input->post('category');


                    if (preg_match("/Roll/i", $category)) {
                        $category = 'Roll Labels';
                    }


                    $compatibility = $this->check_compatibility($a_row->$field, $category);


                    $value = $compatibility . ' Compatible';


                }


                $option .= '<option  ' . $selected . '  value="' . $a_row->$field . '" >' . $value . ' ' . $text . '</option>';


            }


        } else {


            $option = '<option value="" > ' . $name . ' </option>';


            foreach ($list as $a_row) {


                $selected = '';


                if ($a_row->$field == $selec) {


                    $selected = 'selected="selected"';


                }


                $value = $a_row->$field;


                if ($field == 'SpecText7') {


                    $category = $this->input->post('category');


                    if (preg_match("/Roll/i", $category)) {
                        $category = 'Roll Labels';
                    }


                    $compatibility = $this->check_compatibility($a_row->$field, $category);


                    $value = $compatibility . ' Compatible';


                }


                $option .= '<option value="' . $a_row->$field . '" ' . $selected . '>' . ucfirst($value) . ' ' . $text . '</option>';


            }


        }


        if (isset($page) and $page != 'index') {
            $option .= '<option value="" > Reset Selection </option>';
        }


        return $option;


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


        return $html;


    }


    function check_compatibility_grid($text, $band)
    {


        $html = '';


        if (preg_match("/Roll Labels/i", $band)) {


            if (preg_match("/\bDirect Thermal\b/i", $text)) {


                $direct = '<i class="fa pull-right f-20 text-success fa-check"></i>';


                $html = '<div class="col-md-12 borderBottom p-t-b-5"><p class="pull-left m0 ">Direct Thermal</p>' . $direct . '</div>';


            }


            if (preg_match("/\bThermal Transfer\b/i", $text)) {


                $transfer = '<i class="fa pull-right f-20 text-success fa-check"></i>';


                $html .= '<div class="col-md-12 borderBottom p-t-b-5"><p class="pull-left m0 ">Thermal Transfer</p>' . $transfer . '</div>';


            }


            if (preg_match("/\bInkjet\b/i", $text)) {


                $Inkjet = '<i class="fa pull-right f-20 text-success fa-check"></i>';


                $html .= '<div class="col-md-12 borderBottom p-t-b-5"><p class="pull-left m0 ">Inkjet</p>' . $Inkjet . '</div>';


            }


        } else {


            if (preg_match("/Copier/i", $text)) {


                $copier = '<i class="fa pull-right f-20 text-success fa-check"></i>';


                $html = '<div class="col-md-12 borderBottom p-t-b-5"><p class="pull-left m0 ">Copier</p>' . $copier . '</div>';


            }


            if (preg_match("/Inkjet/i", $text)) {


                $Inkjet = '<i class="fa pull-right f-20 text-success fa-check"></i>';


                $html .= '<div class="col-md-12 borderBottom p-t-b-5"><p class="pull-left m0 ">Inkjet</p>' . $Inkjet . '</div>';


            }


            if (preg_match("/Laser/i", $text)) {


                $Laser = '<i class="fa pull-right f-20 text-success fa-check"></i>';


                $html .= '<div class="col-md-12 borderBottom p-t-b-5 "><p class="pull-left m0 ">Laser</p>' . $Laser . '</div>';


            }


        }


        return $html;


    }


    function auto_search($page = NULL)
    {


        $srch = $this->input->get('q');


        $tbl = '';


        $results = array();


        $condition = '';


        if ($page != '') {
            $condition = "AND Shape_upd NOT LIKE '%integrated%' ";
        }


        if (strlen($srch) > 0) {


            $sql = "SELECT  CategoryID,CategoryName,CategoryImage,Shape FROM category 



			        WHERE labelCategory !=1 and (CategoryActive='Y' || displayin='both' || displayin='backoffice')  AND category.Shape NOT LIKE '%Full Sheet%' and (



					CategoryName like '%" . trim($srch) . "%' OR



				   `LabelEquivalentAvery` like '%" . trim($srch) . "%' OR



					CategoryImage like '%" . trim($srch) . "%' OR



					Shape_upd like '%" . trim($srch) . "%' OR



					CategoryDescription like '%" . trim($srch) . "%') AND labelCategory!='Application Labels' $condition LIMIT 150";


            $query = $this->db->query($sql);


            $tbl = 'category';


            if ($query->num_rows() == 0) {


                $query = $this->db->query("SELECT ProductCategoryName,ProductID,products.CategoryID,ProductBrand,ManufactureID,LabelsPerSheet,products.Shape,



									   CategoryImage,ProductName,specification3,CategoryName,ProductBrand,Width,Height FROM products 



									   INNER JOIN category ON 	SUBSTRING_INDEX( products.CategoryID, 'R', 1 ) = category.CategoryID   



									   WHERE (Activate LIKE 'Y' || displayin='both' || displayin='backoffice' ) AND ProductBrand NOT LIKE 'Application Labels'  AND products.Shape NOT LIKE '%Full Sheet%'  



									   AND  ( 



									   ManufactureID like '%" . $srch . "%' or



									   ProductName like '%" . $srch . "%' or



									   products.Shape_upd like '%" . $srch . "%' or



									  `ReOrderCode` like '%" . trim($srch) . "%' or



									  `ProductCategoryName` like '%" . trim($srch) . "%' or



									   Adhesive like '%" . $srch . "%') LIMIT 150");


                $tbl = 'product';


            }


            if ($query->num_rows() == 0) {


                $query = $this->db->query("SELECT * FROM `application_category` WHERE `name` LIKE  '%" . trim($srch) . "%' ");


                $tbl = 'lba-category';


            }


            $results = $query->result();


        }


        return array('tbl' => $tbl, 'results' => $results);


    }


    function auto_search_printer($limit = NULL)
    {


        if ($limit == NULL) {
            $limit = '100';
        }


        $srch = $this->input->get('q');


        $sql = "SELECT  model,Name,PrintWidth,method,RollDiamter,specfication,ManufacturerCode,image FROM printers_model 



		 		WHERE 	Active LIKE 'Y' and  (model like '%" . trim($srch) . "%' OR



			   `Name` like '%" . trim($srch) . "%' OR



				specfication like '%" . trim($srch) . "%' OR



				RollDiamter like '%" . trim($srch) . "%' OR



				method like '%" . trim($srch) . "%') LIMIT $limit";


        $query = $this->db->query($sql);


        return $query->result();


    }


    function integrated_comaptible_list()
    {


        $query = $this->db->query("select CategoryName as name,CategoryImage as image from category where (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice') AND `specification3` = 'Integrated'");


        return $query->result();


    }


    /************** Roll Labels Pricing *********************/


    function calculate_por($menucode, $table, $rolls, $labels)
    {


        $field = 'Labels_' . $labels;
        //print_r($field); exit;
        $query = $this->db->query("Select $field from tbl_batch_roll INNER JOIN $table ON tbl_batch_roll.batch_id=$table.batch_id WHERE ManufactureID = '" . $menucode . "' AND tbl_batch_roll.Rolls = $rolls ");
        $row = $query->row_array();
        //print_r($row); exit;
        return $row[$field];

    }


    function which_group($width, $height)
    {

        $width = $width / 1000;
        $height = $height / 1000;
        $liner_meter = $width * $height;
        $table = '';
        $liner_meter = round($liner_meter, 4);
        if ($liner_meter >= 0.0001 and $liner_meter <= 0.0009) {
            $table = 1;
        } else if ($liner_meter > 0.0009 and $liner_meter <= 0.0036) {
            $table = 2;
        } else if ($liner_meter > 0.0036 and $liner_meter <= 0.0078) {
            $table = 3;
        } else if ($liner_meter > 0.0078 and $liner_meter <= 0.0155) {
            $table = 4;
        } else if ($liner_meter > 0.0155) {
            $table = 5;
        }
        return $table;
    }


    function which_material($menfactureid)
    {


        $code = $this->getmaterialcode($menfactureid);


        $query = $this->db->query("SELECT Price FROM `material_prices` WHERE Code LIKE '" . $code . "' LIMIT 1");


        $row = $query->row_array();


        $price = $row['Price'];


        if ($price >= 1.3) {


            $type = 'b';  //High Materials


        } else {


            $type = 'a';  //Low Materials


        }


        return array('price' => $price, 'type' => $type);


    }


    function getmaterialcode($text)
    {


        preg_match('/(\d+)\D*$/', $text, $m);


        $lastnum = $m[1];


        $mat_code = explode($lastnum, $text);


        return strtoupper($mat_code[1]);


    }

    function getdiecode($text)
    {

        $length = (strlen($text) - 1);
        $text = substr($text, 0, $length);

        preg_match('/(\d+)\D*$/', $text, $m);


        $lastnum = $m[1];


        $mat_code = explode($lastnum, $text);


        $first = strtoupper($mat_code[1]);

        return explode($first, $text)[0];


    }


    public function getProductCalculation($productId, $manfactureId)
    {
        return array(
            'minRoll' => $this->home_model->min_qty_roll($manfactureId),
            'minLabels' => $this->home_model->min_qty_labels($manfactureId),
            'maxRoll' => $this->home_model->max_qty_roll($manfactureId),
            'maxLabels' => $this->home_model->max_qty_labels($manfactureId),
            'labelPerSheet' => $this->product_model->getProductById($productId)['LabelsPerSheet']
        );
    }


    function calculate_material($ManufactureID, $Labels, $Rolls)
    {

        $query = $this->db->query("SELECT Width,Height FROM `products` as p INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID Where ManufactureID LIKE '" . $ManufactureID . "' ");
        $query = $query->row_array();

        $is_custom_width = $this->input->post('is_custom_Wh');
        if ($is_custom_width == true) {
            $width = $this->input->post('die_width') . '.00';
            $height = $this->input->post('die_height') . '.00';

            $shape = $this->input->post('shape');

            if ($shape == 'Circle') {
                $height = $width;
            } elseif ($shape == 'Square') {
                $height = $width;
            }


        } else {
            $width = $query['Width'];
            $height = $query['Height'];
        }


        $ManufactureID = substr($ManufactureID, 0, -1);
        $info = $this->which_material($ManufactureID);
        $gruop = $this->which_group($width, $height);

        $printing = $this->input->post('printing');
        /*if (isset($printing) and $printing != '') {
            $Labels = $this->calculate_labels_sheets($ManufactureID, $Labels);
        }else{
            $new_label = ($Labels/$Rolls);
            $Labels = (int)$this->calculate_labels_sheets($ManufactureID, $new_label);
        }*/

        $Labels = $this->calculate_labels_sheets($ManufactureID, $Labels);

        /*print_r($printing.' ');
        print_r($Labels.' ');
        print_r($Rolls.' ');
        print_r($new_label.'gg');
        print_r('<br> new <br>');*/
        //$Labels = $this->calculate_labels_sheets($ManufactureID, $Labels);

        $table = "tbl_por_" . $gruop . $info['type'];
        $meterail_cost = $info['price'];
        $sqr_width = $width + 5;
        $sqr_height = $height + 5;
        $sqr_width = $sqr_width / 1000;
        $sqr_height = $sqr_height / 1000;
        $linear_meter = $sqr_width * $sqr_height;
        //$Labels = 2500;

        /*print_r($linear_meter);
        print_r('<br>');
        print_r('g '.$Labels.' g');
        print_r('<br>');
        print_r('hi');*/
        //exit;
        $sqr_meter = $linear_meter * $Labels;
        //print_r($sqr_meter); exit;
        $per_roll_price = ($sqr_meter * $meterail_cost) + 0.75;
        $per_roll_price = $per_roll_price * $Rolls;
        $roll = $this->calculate_rolls_qty($ManufactureID, $Rolls);
        $por = $this->calculate_por($ManufactureID, $table, $roll, $Labels);

        $por = (1 - ($por / 100));
        $sale_price = $per_roll_price / $por;
        return $sale_price;

    }


    function get_roll_against($manufature)
    {


        $manufature = substr($manufature, 0, -1);


        $qurey = $this->db->query("SELECT Rolls FROM tbl_batch_roll WHERE ManufactureID LIKE '" . $manufature . "' AND Active LIKE 'Y'");


        $result = $qurey->result();


        return $result;


    }


    function get_labels_against($manufature)
    {


        $manufature = substr($manufature, 0, -1);


        $qurey = $this->db->query("SELECT Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '" . $manufature . "' 



		ORDER BY `tbl_batch_labels`.`Labels` ASC");


        $result = $qurey->result();


        return $result;


    }


    function min_qty_roll($manufature1)
    {
        $manufature = substr($manufature1, 0, -1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '" . $manufature . "' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return $roll['Rolls'];
    }


    function min_qty_labels($manufature1)
    {
        $manufature = substr($manufature1, 0, -1);
        $roll = $this->db->query("SELECT MIN(Labels) AS Labels FROM `tbl_batch_labels` WHERE ManufactureID LIKE '" . $manufature . "'");
        $roll = $roll->row_array();
        return $roll['Labels'];
    }


    function max_qty_roll($manufature1)
    {


        $manufature = substr($manufature1, 0, -1);


        $roll = $this->db->query("SELECT MAX(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '" . $manufature . "' AND Active LIKE 'Y'");


        $roll = $roll->row_array();


        return $roll['Rolls'];


    }

    function max_qty_labels($manufature1)
    {


        $manufature = substr($manufature1, 0, -1);


        $roll = $this->db->query("SELECT MAX(Labels) AS Labels FROM `tbl_batch_labels` WHERE ManufactureID LIKE '" . $manufature . "'");


        $roll = $roll->row_array();


        return $roll['Labels'];


    }


    function start_labels_price($manufature, $labels)
    {


        return $price = $this->min_roll_price($manufature, $labels);


    }


    function min_roll_price($manufature1, $labels)
    {


        $Roll = $this->min_qty_roll($manufature1);


        $manufature = substr($manufature1, 0, -1);

        $price = $this->calclateprice($manufature1, $Roll, $labels);


        return $price = $price['final_price'] / $Roll;


    }


    function save_percentage($actual_price, $bulk_price)
    {


        $diff_price = $actual_price - $bulk_price;


        $save_price = ($diff_price / $actual_price) * 100;


        return round($save_price);


    }


    function get_min_labels_price($manufature1)
    {


        $manufature = substr($manufature1, 0, -1);


        $labels = $this->db->query("SELECT MIN(Labels) AS Labels FROM `tbl_batch_labels` WHERE ManufactureID LIKE '" . $manufature . "'");


        $labels = $labels->row_array();


        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '" . $manufature . "' AND Active LIKE 'Y'");


        $roll = $roll->row_array();


        $Roll = $roll['Rolls'];


        $last = $this->calclateprice($manufature1, $Roll, $labels['Labels']);


        return $last['unit_prcie'];


    }


    function get_save_upto($manufature1)
    {


        $manufature = substr($manufature1, 0, -1);


        $labels = $this->db->query("SELECT MAX(Labels) AS Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '" . $manufature . "'");


        $labels = $labels->row_array();


        $roll = $this->db->query("SELECT MAX(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '" . $manufature . "' AND Active LIKE 'Y'");


        $roll = $roll->row_array();


        $Roll = $roll['Rolls'];


        $last = $this->calclateprice($manufature1, $Roll, $labels['Labels']);


        $firtt_price = $this->min_roll_price($manufature1, $labels['Labels']);


        return $save = $this->save_percentage($firtt_price, $last['unit_prcie']);


    }


    function calclateprice($manufature = NULL, $rolls = NULL, $label = NULL)
    {



        if (isset($rolls) and $rolls > 0 and isset($label) and $label > 99) {


            // echo $manufature.'------'.$label.'------'.$rolls;
            $total_price = $this->calculate_material($manufature, $label, $rolls);
            // echo  '---price---'.$total_price; die();


            $total_price = $total_price / 0.94; // 6% increment yearly


            /******** price uplift ********************************/


            $total_price = $this->check_price_uplift($total_price);


            /********************** price uplift **************/


            $final_price = sprintf('%.2f', round($total_price, 2));


            $unit_price = sprintf('%.2f', round($total_price / $rolls, 2));


            $perlabel = number_format(($unit_price / $label) * 100, 2);


            return $data = array('perlabel' => $perlabel, 'final_price' => $final_price, 'unit_prcie' => $unit_price, 'Labels' => $label);


        } else {


            return $data = array('perlabel' => 0.00, 'final_price' => 0.00, 'unit_prcie' => 0.00, 'Labels' => 0.00);


        }


    }



    function calculate_max_allowed_roll($manufature, $label){


        $qurey = $this->db->query("SELECT Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '" . $manufature . "' ORDER BY Labels ASC");
        $result = $qurey->result();
        $labelpersheet_is = '';
        foreach ($result as $key => $row) {
            if ($label == $row->Labels) {
                $labelpersheet_is = $row->Labels;
            } else if (($label > $row->Labels and isset($result[$key + 1]->Labels) and $label < $result[$key + 1]->Labels)) {
                $labelpersheet_is = $result[$key + 1]->Labels;
            }
        }
        return $labelpersheet_is;
    }


    function calculate_labels_sheets($manufature, $label)
    {
        //print_r($label); exit;

        $qurey = $this->db->query("SELECT Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '" . $manufature . "' ORDER BY Labels ASC");


        $result = $qurey->result();


        $labelpersheet_is = '';


        foreach ($result as $key => $row) {
            /*echo '<pre>';
            print_r($result[$key + 1]->Labels); exit;*/

            if ($label == $row->Labels) {


                $labelpersheet_is = $row->Labels;


            } else if (($label > $row->Labels and isset($result[$key + 1]->Labels) and $label < $result[$key + 1]->Labels)) {


                $labelpersheet_is = $result[$key + 1]->Labels;


            }


        }


        return $labelpersheet_is;


    }


    function calculate_rolls_qty($manufature, $roll)
    {


        $qurey = $this->db->query("SELECT Rolls FROM `tbl_batch_roll` Where ManufactureID LIKE '" . $manufature . "' AND Active LIKE 'Y' ORDER BY Rolls ASC");


        $result = $qurey->result();


        $Rolls = '';


        foreach ($result as $key => $row) {


            if ($roll == $row->Rolls) {


                $Rolls = $row->Rolls;


            } else if (($roll > $row->Rolls and isset($result[$key + 1]->Rolls) and $roll < $result[$key + 1]->Rolls)) {


                // $Rolls = $result[$key+1]->Rolls;


                $Rolls = $row->Rolls;


            }


        }


        if ($Rolls == '') {
            $Rolls = $this->min_qty_roll($manufature . "1");
        }


        return $Rolls;


    }


    function get_roll_diameter($manufature, $labels)
    {


        $manufature1 = substr($manufature, 0, -1);


        $labels = $this->calculate_labels_sheets($manufature1, $labels);


        $roll = $this->db->query("SELECT Diameter FROM `tbl_roll_diameter` Where ManufactureID LIKE '" . $manufature . "' AND Labels LIKE '" . $labels . "' LIMIT 1");


        $roll = $roll->row_array();


        return $roll['Diameter'];


    }


    function get_auto_diameter($manufature, $labels, $gap, $size)
    {


        $rolldiamter = 0;


        $coreid = substr($manufature, -1);


        $coreid = 'R' . $coreid;


        $gap = round(trim(str_replace("mm", "", $gap)));


        $code = $this->getmaterialcode(substr($manufature, 0, -1));


        $size = $size + $gap;


        $labels_p_mtr = round(($size / 1000) * $labels, 2);


        $diammeter = $this->get_diameter_against_meter($code, $coreid, $labels_p_mtr);


        $rolldiamter = floor(($diammeter * 0.03) + $diammeter);


        if ($rolldiamter > 3) {
            $rolldiamter = $rolldiamter - 3;
        }


        return $rolldiamter;


    }


    function get_diameter_against_meter($code = NULL, $coreid = NULL, $meter = NULL)
    {


        $qurey = $this->db->query("SELECT mtr,mesure FROM `roll_diameter` Where code LIKE '" . $code . "' AND core LIKE '" . $coreid . "'  ORDER BY `roll_diameter`.`mesure` ASC");


        $result = $qurey->result();


        foreach ($result as $key => $row) {


            if ($meter == $row->mtr) {


                return $row->mesure;


            } else if (($meter > $row->mtr and isset($result[$key + 1]->mtr) and $meter < $result[$key + 1]->mtr)) {


                return $result[$key + 1]->mesure;


            }


        }


    }


    function get_max_labels_printer($manufature, $labels, $diamter, $gap, $size)
    {


        $total_labels = 0;


        $coreid = substr($manufature, -1);


        $coreid = 'R' . $coreid;


        $gap = round(trim(str_replace("mm", "", $gap)));


        $code = $this->getmaterialcode(substr($manufature, 0, -1));


        $meter = $this->get_meter_against_diameter($code, $coreid, $diamter);


        $size = $size + $gap;


        $labels_p_mtr = round((1000 / $size), 2);


        $total_labels = floor($labels_p_mtr * $meter);


        return $total_labels;


    }


    function get_meter_against_diameter($code = NULL, $coreid = NULL, $diamter = NULL)
    {


        $qurey = $this->db->query("SELECT mtr,mesure FROM `roll_diameter` Where code LIKE '" . $code . "' AND core LIKE '" . $coreid . "'  ORDER BY `roll_diameter`.`mesure` ASC");


        $result = $qurey->result();


        foreach ($result as $key => $row) {


            if ($diamter == $row->mesure) {


                return $row->mtr;


            } else if (($diamter > $row->mesure and isset($result[$key + 1]->mesure) and $diamter < $result[$key + 1]->mesure)) {


                return $result[$key + 1]->mtr;


            }


        }


    }


    function customize_product_name($data)
    {


        $custom = $data['is_custom'];


        $ProductCategoryName = $data['ProductCategoryName'];


        $LabelsPerRoll = $data['LabelsPerRoll'];


        $LabelsPerSheet = $data['LabelsPerSheet'];


        $ReOrderCode = $data['ReOrderCode'];


        $manuid = $data['ManufactureID'];


        $ProductBrand = $data['ProductBrand'];


        $wound = $data['wound'];


        $printed = $data['OrderData'];


        $orignalQty = ($data['orignalQty'] == '250') ? "250 Sheet Dispenser Packs" : "1000 Sheet Boxes";


        if ($printed == 'Sample') {


            if (preg_match("/Roll Labels/i", $ProductBrand)) {


                $completeName = " Label Material  Sample ";


                $type = 'roll';


                $material_code = $this->home_model->getmaterialcode(substr($manuid, 0, -1));


            } else {


                $type = 'a4';


                $completeName = " A4 Sheet Label Material  Sample ";


                $material_code = $this->home_model->getmaterialcode($manuid);


            }


            if (isset($material_code) and $material_code != '') {


                $res = $this->db->query("select name,adhesive from static_materials where code like '" . $material_code . "' limit 1");


                $res = $res->row_array();


                $dd = explode("-", $res['name']);


                $name = $dd[1] . ' - ' . $res['adhesive'];


            }


            $name = $name . ' ' . $completeName;


            return $name;


        }


        if ($wound == 'Y' || $wound == 'Inside') {
            $wound_opt = 'Inside Wound';
        } else {
            $wound_opt = 'Outside Wound';
        }


        if (isset($data['Source']) and ($data['Source'] == 'printing' || $data['Source'] == 'LBA') and preg_match('/Roll Labels/is', $ProductBrand)) {


            //if($data['designedlabels'] > 0){ $designedlabels = $data['designedlabels'].' labels, ';}else {$designedlabels = '';}


            //if($data['Print_Type'] == 'Fullcolour'){ $labeltype = 'Full Colour';}


            //else if($data['Print_Type'] == 'Fullcolour+White'){ $labeltype = 'Full Colour + White';}


            //else if($data['Print_Type'] == 'Mono'){ $labeltype = 'Black Only';}


            $labeltype = $data['Print_Type'];


            $productname = explode("-", $ProductCategoryName);


            $productname[1] = str_replace("(", "", $productname[1]);


            $productname[1] = str_replace(")", "", $productname[1]);


            $productname[0] = str_replace("rolls labels", "", $productname[0]);


            $productname[0] = str_replace("roll labels", "", $productname[0]);


            $productname[0] = str_replace("Roll Labels", "", $productname[0]);


            $productname = "Printed Labels on Rolls - " . str_replace("roll label", "", $productname[0]) . ' - ' . $productname[1];


            $completeName = ucfirst($productname) . ' ' . $wound_opt . ' - Orientation ' . $data['Orintation'] . ', ';


            if ($data['FinishType'] == 'No Finish') {
                $labelsfinish = ' Label finish: None ';
            } else {
                $labelsfinish = ' Label finish : ' . $data['FinishType'];
            }


            $completeName .= $labeltype . ' ' . $labelsfinish;


            return $completeName;


        } else if ($custom == 'Yes') {


            $productname = explode("-", $ProductCategoryName);


            $completeName = $productname[0] . $LabelsPerRoll . "  label per roll, " . $wound_opt . " - " . $productname[1];


            $diamter = $this->calculate_rolls_diamter($manuid, $LabelsPerRoll);


            $completeName = $completeName . " Roll Diameter " . $diamter;


        } else {


            if (preg_match('/Roll Labels/is', $ProductBrand)) {


                $productname = explode("-", $ProductCategoryName);


                $completeName = $productname[0] . $LabelsPerSheet . "  label per roll, " . $wound_opt . " - " . $productname[1];


                $diamter = $this->calculate_rolls_diamter($manuid, $LabelsPerSheet);


                $completeName = $completeName . " Roll Diameter " . $diamter;


            } else {


                $completeName = $ProductCategoryName;


                if (substr($manuid, -2, 2) == 'XS') {


                    $completeName = $completeName . ", Design: " . $printed;


                }


                /**********WPEP Voucher Offer*************/


                /*if(preg_match("/A4/i",$ProductBrand) and (preg_match("/WPEP/i",$manuid))){



                       $completeName =  $completeName." <span style='color:#fd4913;'>( 20% discount) </span>";



                }*/


                if (preg_match("/A4/i", $ProductBrand)) {


                    $mat_code = $this->home_model->getmaterialcode($manuid);


                    $material_discount = $this->home_model->check_material_discount($mat_code, 'A4');


                    if ($material_discount) {


                        $completeName = $completeName . " <span style='color:#fd4913;'>(" . $material_discount . "% discount) </span>";


                    }


                }


                /**********WPEP Voucher Offer*************/


            }


        }


        if ($ReOrderCode) {
            $completeName = $completeName . " re-order code " . $ReOrderCode;
        }


        if ($printed != 'Sample' and preg_match('/Roll Labels/is', $ProductBrand)) {

            $material_code = $this->getmaterialcode(substr($manuid, 0, -1));
            $material_discount = $this->check_material_discount($material_code, 'Roll');
            if ($material_discount) {
                $completeName = $completeName . " <span style='color:#fd4913;'>( " . $material_discount . "% discount) </span>";
            }
        }


        /******************Sample Order implementation***********************/


        if ($printed == 'Sample') {
            $completeName = $completeName . " - Sample ";
        }


        /******************Sample Order implementation***********************/


        if (preg_match("/Integrated/i", $ProductBrand)) {


            $completeName = $completeName . " - (" . $orignalQty . ")";


        }


        return $completeName;


    }


    function calculate_rolls_diamter($manufature = NULL, $label = NULL)
    {


        $query = $this->db->query("SELECT LabelGapAcross,Height FROM products 



			INNER JOIN category ON SUBSTRING_INDEX( products.CategoryID, 'R', 1 ) = category.CategoryID   WHERE ManufactureID like '" . $manufature . "' LIMIT 1");


        $row = $query->row_array();


        $gap = $row['LabelGapAcross'];


        $size = $row['Height'];


        return $this->get_auto_diameter($manufature, $label, $gap, $size) . ' mm';


    }


    function calculate_rolls_diamter_old($manufature = NULL, $label = NULL)
    {


        $qurey = $this->db->query("SELECT Labels,Diameter FROM `tbl_roll_diameter` Where ManufactureID LIKE '" . $manufature . "' ORDER BY `tbl_roll_diameter`.`Labels` ASC");


        $result = $qurey->result();


        foreach ($result as $key => $row) {


            if ($label == $row->Labels) {


                return $row->Diameter . "mm ";


            } else if (($label > $row->Labels and isset($result[$key + 1]->Labels) and $label < $result[$key + 1]->Labels)) {


                return $result[$key + 1]->Diameter . "mm ";


            }


        }


    }


    function check_wound_option($productid, $wound_cat)
    {


        $query = $this->db->query("Select CategoryID from products WHERE  ProductID  LIKE '" . $productid . "' AND ProductBrand LIKE 'Roll Labels'");


        $query = $query->row_array();


        if (isset($query['CategoryID']) and $query['CategoryID'] != '') {


            // $roll_cat = substr($query['CategoryID'],0,-2);


            $roll_cat = $query['CategoryID'];


            if (strcasecmp($roll_cat, $wound_cat) == 0) {


                return true;


            }


        }


    }


    function newsletter($email = NULL)
    {


        if ($email != NULL) {


            $query = $this->db->query("select count(*) AS Total from email_addresses WHERE email LIKE '" . $email . "'");


            $query = $query->row_array();


            if ($query['Total'] == 0) {


                $ip_add = $this->session->userdata('ip_address');


                $this->db->insert('email_addresses', array('IPAddress' => $ip_add, 'email' => $email));


                return $this->db->insert_id();


            }


        }


    }


    function check_emailIP_for_voucher()
    {


        $return_email = '';


        $nothanks = $this->session->userdata('newsletter_no_thanks');


        if (isset($nothanks) and $nothanks != 'yes') {


            $ip_add = $this->session->userdata('ip_address');


            if (isset($ip_add) and $ip_add != '') {


                $query = $this->db->query("select count(*) as total from email_addresses WHERE IPAddress LIKE '" . $ip_add . "' AND email!=''");


                $row = $query->row_array();


                if ($row['total'] == 0) {


                    return $ip_add;


                }


            }


        }


        return $return_email;


    }


    function check_emailIP_for_voucher_oldone()
    {


        $return_email = '';


        $nothanks = $this->session->userdata('newsletter_no_thanks');


        if (isset($nothanks) and $nothanks != 'yes') {


            $ip_add = $this->session->userdata('ip_address');


            $query = $this->db->query("select Billingemail from orders WHERE TrackingIP LIKE '" . $ip_add . "' AND UserID!='' AND Billingemail!='' Order by OrderID Desc LIMIT 1");


            $query = $query->row_array();


            if (isset($query['Billingemail']) and $query['Billingemail'] != '') {


                $news = $this->db->query("select * from email_addresses WHERE email LIKE '" . $query['Billingemail'] . "'  Order by ID Desc LIMIT 1");


                $news = $news->row_array();


                if (isset($news['email']) and $news['email'] != '') {


                    $ip_add = $this->session->userdata('ip_address');


                    if ($ip_add != $news['IPAddress']) {


                        //$this->db->where(array('email'=>$news['email']));


                        //$this->db->update('email_addresses',array('IPAddress'=>$ip_add));


                        //echo $this->db->last_query();


                    }


                } else {


                    $return_email = $query['Billingemail'];


                }


            }


        }


        return $return_email;


    }


    function is_holiday_event()
    {


        $holiday = '';


        $query = $this->db->query("SELECT count(*) AS Total FROM `aa_holiday_calender` WHERE  Date  LIKE '" . date("Y-m-d") . "'");


        $count = $query->row_array();


        if ($count['Total'] > 0) {


            $holiday = 'yes';


        }


        return $holiday;


    }


    /************** Printer Model Start*********************/


    function get_printer()
    {


        $query = $this->db->query("SELECT ManufacturerCode,Name,printer_image FROM `printers`  WHERE (Activate LIKE 'Y' || displayin='both' || displayin='backoffice' ) Order by Name ASC ");


        return $query->result();


    }


    function get_printer_model($make)
    {


        $query = $this->db->query("SELECT ManufacturerCode,model,Name,PrintWidth,image,color,specfication,method FROM `printers_model`  WHERE ManufacturerCode LIKE '" . $make . "' AND Active LIKE 'Y'  Order by Name ASC ");


        return $query->result();


    }



    /*****************Printer Model End ***********************/


    /*****************function for pagination helper*************************/


    function count_records_query($query)
    {


        $row = $this->db->query($query);


        return $row->num_rows();


    }


    function fetch_records_query($limit, $start, $query)
    {


        $query .= ' limit ' . $start . ' , ' . $limit;


        $query2 = $this->db->query($query);


        if ($query2->num_rows() > 0) {


            foreach ($query2->result() as $row) {


                $data[] = $row;


            }


            return $data;


        }


        return 0;


    }


    function integrated_batch_qty($menuid)
    {


        $query = $this->db->query("select tbl.ManufactureID,tbl.SheetPrice,batch.BatchQty,tbl.DiscountPercent from 



					   tbl_product_batchprice tbl,tbl_batch batch where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID ORDER BY  batch.BatchQty asc ");


        return $query->result();


    }

    public function getproductimg($id, $colorcode = NULL)
    {
        $query = $this->db->select('Image1,ProductBrand,ManufactureID')
            ->where('ProductID', $id)
            ->get('products');
        $data = $query->row_array();

        if ($id == 0) {
            $img = "High_Gloss_Permanent_Adhesive.png";
            return base_url() . 'theme/images/images_products/material_images/' . $img;
        } else if (preg_match('/Application Labels/', $data['ProductBrand'])) {
            $designcode = substr($data['ManufactureID'], -4);
            return Assets . "images/application/design/" . $designcode . $colorcode . '.png';
        } else {
            //$data['Image1'] = trim(str_replace(".gif",".png",$data['Image1']));
            $data['Image1'] = str_replace(" ", "", $data['Image1']);
            return base_url() . 'theme/images/images_products/material_images/' . $data['Image1'];
        }


    }

    public function getstatus($id)
    {

        $query = $this->db->get_where('dropshipstatusmanager', array('StatusID' => $id));
        return $query->result();
    }

    public function getcountry_new($country)
    {
        $query = $this->db->query("select * from shippingcountries where name = '$country'");
        $result = $query->row_array();
        return $result;


    }

    function update_line($serailnumber, $update)
    {
        $this->db->where('SerialNumber', $serailnumber);
        $this->db->update('orderdetails', $update);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function single_box_price($menuid, $qty, $batch = 1000, $country = null)
    {
        $return = array();
        $qurey = $this->db->query("SELECT Distinct(`Sheets`) FROM `integrated_labels_prices` where ManufactureID ='$menuid' ORDER BY sheets ASC");
        $result = $qurey->result();
        $user_qty = $qty;
        
        

        foreach ($result as $key => $row) {
            
            if ($qty <= 249) {
                $qty = $row->Sheets;
            } else if ($qty == $row->Sheets) {
                $qty = $row->Sheets;
            } else if (($qty > $row->Sheets and isset($result[$key + 1]->Sheets) and $qty < $result[$key + 1]->Sheets)) {
            //$qty = $result[$key+1]->Sheets;
            $qty = $row->Sheets;
            } else if ($qty > 200000) {
                $qty = 200000;
            }
        }
        $cond = '';

        /*if($batch=="" || $batch==0){
			$batch = '1000';
		}*/


        $query = $this->db->query("select *, Price_$batch as PlainPrice, Box_$batch as Box from integrated_labels_prices where ManufactureID ='$menuid' and Sheets = '$qty'");


        //echo"<pre>";print_r($this->db->last_query());echo"</pre>";exit;


        //die($this->db->last_query());


        $return = $query->row_array();
        
        


        //$delivery_charges = $this->get_integrated_delivery($user_qty);


        $delivery_charges = $this->get_integrated_delivery($qty, $country);


        $return = array_merge($delivery_charges, $return);
        


        return $return;


    }


    function for_integrate($cat)
    {


        $query = $this->db->query("SELECT * FROM products p inner join category c  on p.CategoryID = c.CategoryID  WHERE p.CategoryID = '$cat' and (p.Activate='Y' || p.displayin='both' || p.displayin='backoffice') ");


        return $query->result();


    }


    function min_qty_integrated($menuid)
    {


        $query = $this->db->query("select MIN(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 



		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");


        $row = $query->row_array();


        return $row['qty'];


    }


    function max_qty_integrated($menuid)
    {


        $query = $this->db->query("select MAX(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 



		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");


        $row = $query->row_array();


        return $row['qty'];


    }


    function calculate_integrated_printing($qty)
    {


        $query = $this->db->query("select * from tbl_print_prices Order by  sheets ASC ");


        $result = $query->result();


        foreach ($result as $key => $row) {


            if ($qty == $row->sheets) {


                $multiple = $row->sheets / 100;


                $black_price = $row->black_price;


                $color_price = $row->color_price;


            } else if (($qty > $row->sheets and isset($result[$key + 1]->sheets) and $qty < $result[$key + 1]->sheets)) {


                //$sheets = $row->BatchQty;


                $multiple = $result[$key + 1]->sheets / 100;


                $black_price = $result[$key + 1]->black_price;


                $color_price = $result[$key + 1]->color_price;


            } else if (($qty > 20000)) {


                $multiple = $qty / 100;


                $black_price = $row->black_price;


                $color_price = $row->color_price;


            }


        }


        return array('BlackPrice' => $black_price * $multiple, 'PrintPrice' => $color_price * $multiple);


    }


    function calculate_integrated_qty($manufature, $qty)
    {


        $result = $this->integrated_batch_qty($manufature);


        $sheets = '';


        foreach ($result as $key => $row) {


            if ($qty == $row->BatchQty) {


                $sheets = $row->BatchQty;


            } else if (($qty > $row->BatchQty and isset($result[$key + 1]->BatchQty) and $qty < $result[$key + 1]->BatchQty)) {


                //$sheets = $row->BatchQty;


                $sheets = $result[$key + 1]->BatchQty;


            }


        }


        if ($sheets == '') {
            $sheets = $this->min_qty_integrated($manufature);
        }


        return $sheets;


    }


    function get_materail_for_custom()
    {


        $type = $this->input->post('category');


        $shape = $this->input->post('shape');


        if ($type == 'Roll') {


            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' || displayin='both' || displayin='backoffice') 



			AND ProductBrand LIKE 'Roll labels' AND Shape_upd LIKE '" . $shape . "' GROUP BY ProductName ORDER BY ProductName ASC";


        } else if ($type == 'SRA3') {


            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' || displayin='both' || displayin='backoffice') 



				   AND ProductBrand LIKE 'SRA3 Label' AND Shape_upd LIKE '" . $shape . "' GROUP BY ProductName ORDER BY ProductName ASC";


        } else if ($type == 'A3') {


            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' || displayin='both' || displayin='backoffice') 



				 AND ProductBrand LIKE 'A3 Label' AND Shape_upd LIKE '" . $shape . "' GROUP BY ProductName ORDER BY ProductName ASC";


        } else {


            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' || displayin='both' || displayin='backoffice') AND  



			   ( ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label' AND ProductBrand NOT LIKE 'Roll labels' ) 



			    AND Shape_upd LIKE '" . $shape . "' GROUP BY ProductName ORDER BY ProductName ASC";


        }


        $shape = $this->db->query($query);


        $result = $shape->result();


        $option = '<option value="" >Select Material </option>';


        foreach ($result as $row) {


            $option .= '<option value="' . str_replace("&#39;", "", $row->name) . '" >' . str_replace("&#39;", "", $row->name) . '</option>';


        }


        return $option;


    }


    function upload_images($field_name, $folder = NULL)
    {


        $config['upload_path'] = upload_artwork;
//print_r($config['upload_path']); exit;

        $config['allowed_types'] = '*';
        $config['max_size'] = 1000000;
        $config['max_width'] = 1024000;
        $config['max_height'] = 7680000;
        $config['encrypt_name'] = TRUE;


        $this->load->library('upload', $config);


        if (!$this->upload->do_upload($field_name)) {


            echo $this->upload->display_errors();
            die();


            return "error";


        } else {


            $data = array('upload_data' => $this->upload->data());


            return $data['upload_data']['file_name'];


        }


    }


    function genrate_breadcrumb($type = NULL)
    {


        $html = '<li><a href="' . base_url() . '"><i class="fa fa-home"></i></a></li>';


        $url = uri_string();


        if ($type == 'category') {


            $url = explode("/", $url);


            $first_url = $url[1];


            $html .= $this->get_category_breadcrumb($first_url);


            if (isset($url[2]) and $url[2] != '') {


                $shape = $this->get_heading($url[2]);


                if ($shape) {


                    $html .= '<li class="active">' . ucwords(strtolower($shape)) . '</li>';


                }


            }


        } else if ($type == 'material') {


            $url = explode("/", $url);


            $first_url = $url[1];


            $html .= $this->get_category_breadcrumb($first_url);


            if (isset($url[2]) and $url[2] != '') {


                $shape = $this->get_heading($url[2]);


                if ($shape) {


                    $html .= '<li><a href="' . base_url() . $first_url . '/' . $url[2] . '/">' . ucwords(strtolower($shape)) . '</a></li>';


                }


            }


        }


        return $html;


    }


    function get_category_breadcrumb($first_url)
    {


        if (preg_match("/sra3/i", $first_url)) {


            $html = '<li><a href="' . base_url() . $first_url . '/">Labels on SRA3 Sheets</a></li>';


        } else if (preg_match("/a3/i", $first_url)) {


            $html = '<li><a href="' . base_url() . $first_url . '/">Labels on A3 Sheets</a></li>';


        } else if (preg_match("/roll/i", $first_url)) {


            $html = '<li><a href="' . base_url() . $first_url . '/">Labels on Rolls</a></li>';


        } else {


            $html = '<li><a href="' . base_url() . $first_url . '/">Labels on A4 Sheets</a></li>';


        }


        return $html;


    }


    function get_shape_breadcrumb($shape)
    {


    }


    function get_heading($shape)
    {


        if (preg_match("/circular/i", $shape)) {


            $data = "CIRCULAR LABELS";


            return $data;


        } else if (preg_match("/rectangle/i", $shape)) {


            $data = "RECTANGULAR LABELS";


            return $data;


        } else if (preg_match("/oval/i", $shape)) {


            $data = "OVAL SHAPED LABELS";


            return $data;


        } else if (preg_match("/heart/i", $shape)) {


            $data = "HEART SHAPED LABELS";


            return $data;


        } else if (preg_match("/square/i", $shape)) {


            $data = "SQUARE LABELS";


            return $data;


        } else if (preg_match("/triangle/i", $shape)) {


            $data = "TRIANGULAR SHAPED LABELS";


            return $data;


        } else if (preg_match("/Star/i", $shape)) {


            $data = "STAR SHAPED LABELS";


            return $data;


        } else if (preg_match("/irregular/i", $shape)) {


            $data = "IRREGULAR SHAPED LABELS";


            return $data;


        } else if (preg_match("/perforated/i", $shape)) {


            $data = "PERFORATED LABELS";


            return $data;


        } else if (preg_match("/tamper/i", $shape)) {


            $data = " TAMPER EVIDENT LABELS ";


            return $data;


        }


    }


    function get_footer_description($type, $shape)
    {


        if ($shape == '') {
            $shape = 'all';
        };


        $query = $this->db->query("select heading,footer_text from category_shapes WHERE REPLACE(`type`,' Labels','') LIKE '" . $type . "' 



				AND shape LIKE '%" . $shape . "%'");


        $row = $query->row_array();


        return $row['footer_text'];


    }


    function get_footer_description_old($type, $shape)
    {


        if ($type == "A4") {


            if (preg_match("/circular/i", $shape)) {


                $data = "Round labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and this popular shape has almost limitless applications for educational, product branding and packaging, promotional, retail, information labels and hazard signage usage in a wide range of sizes. ";


            } else if (preg_match("/rectangle/i", $shape)) {


                $data = "Rectangular labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and this highly popular shape is the most widely used off all on everything from address labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and the list of uses is almost endless. <br /> As a consequence rectangular labels form our largest range of sizes, materials and adhesives available and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!";


            } else if (preg_match("/oval/i", $shape)) {


                $data = "Oval labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and this popular shape is widely used on product packaging and by drinks, dairy and preserve producers using glass jars and bottles, round pots and containers as the shape can add a pleasing element to the overall aesthetic appearance.";


            } else if (preg_match("/square/i", $shape)) {


                $data = "Square labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and this popular shape is commonly used for numerous label applications such as asset labels, file labels, information labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and similar to rectangular labels the list of uses is almost endless.";


            } else if (preg_match("/triangle/i", $shape)) {


                $data = "Triangular shaped labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and similar to heart and star shaped labels this fun, popular shape has many commercial, professional and personal use applications. For example it is used extensively within the education sector as a house or year group merit/award label or sticker and within the health and safety sector as hazard labels, in the retail sector as secondary product promotion or special offer labels and the shapes application for other business and commercial use include quality assurance and guarantee labels.";


            } else if (preg_match("/Heart/i", $shape)) {


                $data = "This is a great shaped label for commercial, educational, event and fun usage. For example the shape can work well as a merit/award sticker in early years education, or as wrapping seal for flowers, foodstuffs and fragrances. As a secondary product promotion label on chocolates and confectionery packaging, a gift label, or on special occasions such as valentines and mothers day and weddings, along with selective personal use printing messages on blank labels and placing them on cards, gifts, invitations, letters and packaging.";


            } else if (preg_match("/star/i", $shape)) {


                $data = "Star shaped labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and this fun, popular shape has many commercial, professional and personal use applications. For example it is used extensively within the education sector as a merit/award label or sticker and within the retail sector as secondary product promotion or special offer label and the shapes application for personal and home use is limited only by imagination! E.g. Personalised messages on envelopes, gift packaging and invitations, children's charts, etc.";


            } else {


                $data = "Labels on A4 sheets are often the most cost effective way of producing low to medium volume solutions for your labelling requirements and the choice of shapes and sizes within our standard range is considerable and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!";


            }


        } else if ($type == "A3") {


            if (preg_match("/Circular/i", $shape)) {


                $data = 'Round labels on A3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements and for customers using large format printers and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while the print output is doubled. <br /> This popular shape has almost limitless applications for educational, product branding and packaging, promotional, retail, information labels and hazard signage usage in a wide range of sizes. ';


            } else if (preg_match("/Rectangle/i", $shape)) {


                $data = 'Rectangular labels on A3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements and for customers using large format printers and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while the print output is doubled. <br/> Of all the label shapes available this highly popular shape is the most widely used off all, on everything from address labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and the list of uses is almost endless. <br /> As a consequence rectangular labels form our largest range of sizes, materials and adhesives available and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!';


            } else if (preg_match("/Oval/i", $shape)) {


                $data = 'Oval labels on A3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements and for customers using large format printers and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while the print output is doubled. <br /> This popular shape is widely used on product packaging and by drinks, dairy and preserve producers using glass jars and bottles, round pots and containers as the shape can add a pleasing element to the overall aesthetic appearance. ';


            } else if (preg_match("/Square/i", $shape)) {


                $data = 'Square labels on A3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements and for customers using large format printers and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while the print output is doubled. <br />This popular shape is commonly used for numerous label applications such as asset labels, file labels, information labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and similar to rectangular labels the list of uses is almost endless.';


            } else {


                $data = 'Labels on A3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements and for customers using large format printers and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while the print output is doubled. <br />As with labels on A4 sheets the choice of shapes and sizes within our standard range is considerable and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!';


            }


        } else if ($type == "SRA3") {


            if (preg_match("/Circular/i", $shape)) {


                $data = 'Round labels on SRA3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements for customers using large format printers and full colour process printing requiring a full edge bleed and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while the print output is doubled. <br /> This popular shape has almost limitless applications for educational, product branding and packaging, promotional, retail, information labels and hazard signage usage in a wide range of sizes.';


            } else if (preg_match("/Rectangle/i", $shape)) {


                $data = 'Rectangular labels on SRA3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements for customers using large format printers and full colour process printing requiring a full edge bleed and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while  the print output is doubled. <br/> Of all the label shapes available this highly popular shape is the most widely used off all, on everything from address labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and the list of uses is almost endless. <br /> As a consequence rectangular labels form our largest range of sizes, materials and adhesives available and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!';


            } else if (preg_match("/Oval/i", $shape)) {


                $data = 'Oval labels on SRA3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements for customers using large format printers and full colour process printing requiring a full edge bleed and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while  the print output is doubled. <br /> This popular shape is widely used on product packaging and by drinks, dairy and preserve producers using glass jars and bottles, round pots and containers as the shape can add a pleasing element to the overall aesthetic appearance. ';


            } else if (preg_match("/Square/i", $shape)) {


                $data = 'Square labels on SRA3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements for customers using large format printers and full colour process printing requiring a full edge bleed and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while  the print output is doubled. <br />This popular shape is commonly used for numerous label applications such as asset labels, file labels, information labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and similar to rectangular labels the list of uses is almost endless.';


            } else {


                $data = 'Labels on SRA3 sheets are often the most cost effective way of producing medium volume solutions for your labelling requirements for customers using large format printers and full colour process printing requiring a full edge bleed and/or on PPC printer contracts as the cost per sheet typically remains the same as A4 while  the print output is doubled.<br/> As with labels on A4 and A3 sheets the choice of shapes and sizes within our standard range is considerable and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!';


            }


        } else if ($type == "Roll") {


            if (preg_match("/Circular/i", $shape)) {


                $data = 'Round labels on rolls are the most cost effective way of producing high volume solutions for your labelling requirements in both plain and printed formats and often the correct choice in medium to low quantities where ease of handling is an important consideration e.g. Access and promotional clothing stickers, secondary product labels and on-site service engineers. <br /> This popular shape has almost limitless applications for educational, product branding and packaging, promotional, retail, information labels and hazard signage usage in a wide range of sizes. ';


            } else if (preg_match("/Rectangle/i", $shape)) {


                $data = 'Rectangular labels on rolls are the most cost effective way of producing high volume solutions for your labelling requirements in both plain and printed formats and often the correct choice in medium to low quantities where ease of handling is an important consideration e.g. Automated and semi-automated product labelling and manual handling. <br /> Of all the label shapes available this highly popular shape is the most widely used off all, on everything from address labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and the list of uses is almost endless. <br/> As a consequence rectangular labels form our largest range of sizes, materials and adhesives available and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!';


            } else if (preg_match("/Oval/i", $shape)) {


                $data = 'Oval labels on rolls are the most cost effective way of producing high volume solutions for your labelling requirements in both plain and printed formats and often the correct choice in medium to low quantities where ease of handling is an important consideration e.g. Automated and semi-automated product labelling and manual handling. <br /> This popular shape is widely used on product packaging and by drinks, dairy and preserve producers using glass jars and bottles, round pots and containers as the shape can add a pleasing element to the overall aesthetic appearance. ';


            } else if (preg_match("/Square/i", $shape)) {


                $data = 'Square labels on rolls are the most cost effective way of producing high volume solutions for your labelling requirements in both plain and printed formats and often the correct choice in medium to low quantities where ease of handling is an important consideration e.g. Automated and semi-automated product labelling and manual handling. <br /> This popular shape is commonly used for numerous label applications such as asset labels, file labels, information labels, despatch and delivery labels, shipping labels, labels for administrative purposes, labels for educational use, parking permits and tickets, information labels, product branding labels, promotional labels and similar to rectangular labels the list of uses is almost endless.';


            } else {


                $data = 'Labels on rolls are the most cost effective way of producing high volume solutions for your labelling requirements in both plain and printed formats and often the correct choice in medium to low quantities where ease of handling is an important consideration e.g. Automated and semi-automated product labelling and manual handling.<br> As with labels on A4, A3 and SRA3 sheets the choice of shapes and sizes within our standard range is considerable and we are confident that we will have a label that meets your requirement. However in the relatively rare instance where the size you require is not available from our standard range, we can probably make it for you!';


            }


        }


        return $data;


    }


    function meta_tags()
    {


        $page = uri_string();


        $method = $this->router->fetch_method();


        $class = $this->router->fetch_class();


        $title = '';
        $desc = '';


        if (preg_match('/polyester-labels/', $page)) {


            $title = "Buy custom size and shape polyester labels | AA Labels";


            $desc = "sheets of polyester labels. Strong, durable, splash-proof labels. Colours include silver &amp; clear. Custom printing available";


        } else if (preg_match('/jam-jar-labels/', $page)) {


            $title = "Buy jam jar labels for jam &amp; chutney jars | AA Labels";


            $desc = "Blank printable chutney and jam jar labels. Lots of colours, shapes, sizes. Including clear, textured and peelable labels";


        } else if (preg_match('/herb-spice-jar-labels/', $page)) {


            $title = "Buy herb and spice jar labels | AA Labels";


            $desc = "Blank printable sticky labels for herb and spice jars. Lots of colours (including clear), shapes and sizes for printing the perfect spice label";


        } else if (preg_match('/sweet-jar-labels/', $page)) {


            $title = "Buy blank and custom sweet jar labels | AA Labels";


            $desc = "Blank, printable sticky labels for sweet jars. Get creative with colours, shapes &amp; sizes &ndash; as well as peelable, clear &amp; textured labels";


        } else if (preg_match('/honey-jar-labels/', $page)) {


            $title = "Buy blank and custom honey jar labels | AA Labels";


            $desc = "Blank printable sticky labels suitable for use on honey jars. Lots of colours, shapes and sizes for printing the perfect honey label";


        } else if (preg_match('/termsConditions/', $page)) {


            $title = 'Terms &amp; conditions | AA Labels';


            $desc = "At AA Labels, we manufacture sticky labels and Inkjet Labels to suit all of your personal and business needs. If it's printer labels you need, get in touch today!";


        } else if ($class == 'home' and $method == 'category') {


            if (preg_match('/a4-sheets/is', $page)) {


                $type = 'A4';


                $title = "Buy blank custom A4 sheet labels | AA Labels";


            } else if (preg_match('/sra3-sheets/is', $page)) {


                $type = 'SRA3';


                $title = "Buy blank and custom SRA3 sheet labels | AA Labels";


            } else if (preg_match('/a3-sheets/is', $page)) {


                $type = 'A3';


                $title = "Buy blank and custom A3 sheet labels | AA Labels";


            } else if (preg_match('/roll-labels/is', $page)) {


                $type = 'Roll Labels';


            }


            $desc = "With a range of rectangle labels in many sizes our online store at AA Labels is ideal if you need rectangle labels and stickers for product packaging, promotional or retail and other applications";


            $cat_array = explode("/", $page);


            if (isset($cat_array[2]) and $cat_array[2] != '') {


                $cat_shape = $cat_array[2] . ' labels';


                $query = $this->db->query("SELECT *, count(*) as total FROM `category_shapes` WHERE shape LIKE '" . $cat_shape . "' AND type LIKE '" . $type . "' LIMIT 1  ");


                $row = $query->row_array();


                if ($row['total'] == 1) {


                    $title = $row['title'];


                    $desc = $row['description'];


                }


            }


        } else if ($class == 'home' and $method == 'material') {


            $cate_arr = explode("/", $page);


            $cat = $cate_arr[3];


            if (preg_match('/r1|r2|r3|r4|r5/is', $cat)) {


                $new_code_exp = explode("R", $cat);


                $cat = $new_code_exp[0];


            }


            $qry = $this->db->query("SELECT PageTitle,Metadescription from category where CategoryID LIKE '$cat'");


            $res = $qry->result();


            $title = $res[0]->PageTitle;


            $desc = $res[0]->Metadescription;


        } else if ($class == 'home' and $method == 'aboutus') {


            $title = "About us | AA Labels";


        } else if ($class == 'home' and $method == 'labelfinder') {


            $title = "Advanced search | AA Labels";


        } else if ($class == 'home' and $method == 'avery_size_labels') {


            $title = "Buy Avery sized labels | AA Labels";


        } else if ($class == 'home' and $method == 'contactus') {


            $title = "Contact us | AA Labels";


        } else if ($class == 'home' and $method == 'termsConditions') {


            $title = "Terms & conditions | AA Labels";


        } else if ($class == 'home' and $method == 'testimonial') {


            $title = "Customer Testimonials | AA Labels";


        } else if ($class == 'home' and $method == 'customer_care') {


            $title = "Customer care | AA Labels";


        } else if ($class == 'home' and $method == 'email_note') {


            $title = "Our core values | AA Labels";


        } else if ($class == 'home' and $method == 'customlabels') {


            $title = "Design your own custom labels | AA Labels";


        } else if ($class == 'home' and $method == 'delivery') {


            $title = "Delivery and shipping information | AA Labels";


        } else if ($class == 'home' and $method == 'questionaire') {


            $title = "Customer feedback questionnaire | AA Labels";


        } else if ($class == 'home' and $method == 'faq') {


            $title = "Frequently Asked Questions | Blog";


        } else if ($class == 'home' and $method == 'printing') {


            $title = "Custom printed label service | AA Labels";


        } else if ($class == 'home' and $method == 'promotions') {


            $title = "Current label discounts and promotions | AA Labels";


        } else if (preg_match('/labels-by-application/', $page)) {


            $title = "Buy double-integrated labels | AA Labels";


        } else if (preg_match('/single-integrated-labels/', $page)) {


            $title = "Search and order single integrated labels | AA Labels";


        } else if (preg_match('/double-integrated-labels/', $page)) {


            $title = "View and buy double integrated labels | AA Labels";


        } else if (preg_match('/triple-integrated-labels/', $page)) {


            $title = "Look for triple integrated labels | AA Labels";


        } else if (preg_match('/integrated-labels/', $page) and $method != 'integrated_detail') {


            $compatible = $this->uri->segment(2);


            $compatible = ucfirst($compatible);


            if (isset($compatible) and $compatible != '') {


                $title = "Integrated labels | " . $compatible . " compatible | AA Labels";


            } else {


                $title = "Buy blank and custom integrated labels | AA Labels";


            }


        } else if (preg_match('/integrated-labels/', $page) and $method == 'integrated_detail') {


            $cat = "";


            $category = $this->uri->segment(2);


            if ($category) {


                $qry = $this->db->query("SELECT specification3,Metadescription from category where CategoryID LIKE '$category'");


                $res = $qry->result();


                $cat = str_replace("Label Size:", "", $res[0]->specification3);


                $cat = str_replace("width ", "", $cat);


                $cat = str_replace("height ", "", $cat);


                $cat = $cat . " | ";


                $desc = $res[0]->Metadescription;


            }


            $title = $cat . "Buy blank and custom integrated labels | AA Labels";


        } else if (preg_match('/labels-materials/', $page)) {


            $title = "Explore all of our label materials | AA Labels";


        } else if (preg_match('/freetemplate/', $page)) {


            $compatible = '';


            $compatible = $this->uri->segment(2);


            $compatible = strtoupper($compatible);


            $title = "Free " . $compatible . " label templates | AA Labels";


        } else if (preg_match('/thermal-printer-roll-labels/', $page)) {


            $model_sel = urldecode($this->input->get('model'));


            if (isset($model_sel) and $model_sel != '') {


                $model_sel = ucfirst($model_sel);


                $title = "Buy thermal printer labels on rolls | " . $model_sel . " | AA Labels";


            } else {


                $title = "Buy thermal printer labels on rolls | AA Labels";


            }


        }


        //The AA Labels Blog - %%name%% - AA Labels


        //%%name%%, Author at %%sitename%% %%page%%


        if ($title == '') {


            $title = "Buy A4, A3 and SRA3 sheets of sticky labels | AA Labels";


        }


        if ($desc == '') {


            $desc = "AA Labels is your one stop shop online for labels and stickers. View our label range for many shapes and colours and to find out more about custom labels";


        }


        $meta = '<title>' . $title . '</title>';


        $meta .= '<meta name="description" content="' . $desc . '"/>';


        $meta .= '<link rel="canonical" href="http://www.aalabels.com' . $page . '" />';


        $meta .= '<meta property="og:locale" content="en_GB" />';


        $meta .= '<meta property="og:type" content="website" />';


        $meta .= '<meta property="og:title" content="' . $title . '" />';


        $meta .= '<meta property="og:description" content="' . $desc . '" />';


        $meta .= '<meta property="og:url" content="http://www.aalabels.com' . $page . '" />';


        $meta .= '<meta property="og:site_name" content="aalabels.com" />';


        echo $meta;


        //return $meta;


    }


    /**********Roll cores images task*********************/


    function genrate_rollcore_images($catid, $coreid = NULL)
    {


        $query = $this->db->query("Select * from categorycore INNER JOIN rollcore ON rollcore.CoreId =categorycore.CoreId 



		where categorycore.CategoryId='" . $catid . "' and categorycore.Active='Y' ");


        $result = $query->result();


        $select = '';


        foreach ($result as $row) {


            $coresize = preg_replace("/Core size/", "", $row->CoreSize);


            if ($coreid == $row->CoreId) {


                $selecetd = 'selected="selected"';


            } else {


                $selecetd = '';


            }


            //$select .='<option  '.$selecetd.' value="'.$row->CoreId.'">'.$coresize.'</option>';


            //


            $path = Assets . 'images/categoryimages/RollCoreImages/' . $row->Image;


            $loader = Assets . 'images/loader.gif';


            $select .= '<li><a data-core="' . strtolower($row->CoreId) . '" data-mat-code="WTP" data-id="' . strtolower($row->CoreId) . '" >' . $coresize . '<img data-src="' . $path . '" src="' . $loader . '"></a></li>';


            //$select .='<li><a href="#">'.$coresize.'<img src="'.$row->Image.'"></a></li>


        }


        return $select;


    }


    function genrate_rollcore_images_finder($catid, $menuid)
    {


        //$ManufactureID = substr($menuid,0,-1);


        $query = $this->db->query("Select * from categorycore INNER JOIN rollcore ON rollcore.CoreId =categorycore.CoreId 



		where categorycore.CategoryId='" . $catid . "' and categorycore.Active='Y' ");


        $result = $query->result();


        $select = '';


        foreach ($result as $row) {


            $productId = $this->getProductID($menuid . str_replace("R", "", $row->CoreId));


            $coresize = preg_replace("/Core size/", "", $row->CoreSize);


            //$select .='<option  value="'.$productId.'">'.$coresize.'</option>';


            $path = Assets . 'images/categoryimages/RollCoreImages/' . $row->Image;


            $loader = Assets . 'images/loader.gif';


            $select .= '<li><a data-core="' . strtolower($row->CoreId) . '" data-mat-code="" data-id="' . $productId . '" >' . $coresize . '<img data-src="' . $path . '" src="' . $loader . '"></a></li>';


        }


        return $select;


    }


    /**********  Google AdWords Remarketing Tag  *************/


    function adWords_remarketing_tag()
    {


        $page = uri_string();


        $method = $this->router->fetch_method();


        $class = $this->router->fetch_class();


        $ecomm_prodid = '';


        $ecomm_pagetype = '';


        $ecomm_totalvalue = '';


        if ($class == 'home' and $method == 'material') {


            $cate_arr = explode("/", $page);


            $cat = $cate_arr[3];


            $ecomm_prodid = "'" . $cat . "'";;


            $ecomm_pagetype = 'Product view';


            $ecomm_totalvalue = $this->adWords_remarketing_price($cat);


        } else if (preg_match('/integrated-labels/', $page) and $method == 'integrated_detail') {


            $cat = $this->uri->segment(2);


            $ecomm_prodid = "'" . $cat . "'";


            $ecomm_pagetype = 'Product view';


            $ecomm_totalvalue = $this->adWords_remarketing_price($cat);


        } else if ($class == 'shopping' and ($method == 'index' || $method == 'checkout')) {


            if ($method == 'checkout') {


                $ecomm_pagetype = 'checkout';


            } else {


                $ecomm_pagetype = 'cartModal';


            }


            $products = $this->basket_products();


            if (count($products) > 0) {


                foreach ($products as $row) {


                    $row->CategoryID;


                    $row->TotalPrice = number_format(($row->TotalPrice * 1.2), 2, '.', '');


                    $product_id .= "'" . $row->CategoryID . "',";


                    $prices .= $row->TotalPrice . ",";


                }


                $product_id = substr($product_id, 0, -1);


                $prices = substr($prices, 0, -1);


                if (count($products) > 1) {


                    $product_id = "[" . $product_id . "]";


                    $prices = "[" . $prices . "]";


                }


                $ecomm_prodid = $product_id;


                $ecomm_totalvalue = $prices;


            }


        } else if ($class == 'shopping' and $method == 'orderConfirmation') {


            $ecomm_pagetype = 'Transaction';


            $products = $this->get_order_products();


            if (count($products) > 0) {


                foreach ($products as $row) {


                    $row->CategoryID;


                    $product_id .= "'" . $row->CategoryID . "',";


                    $prices .= $row->ProductTotal . ",";


                }


                $product_id = substr($product_id, 0, -1);


                $prices = substr($prices, 0, -1);


                if (count($products) > 1) {


                    $product_id = "[" . $product_id . "]";


                    $prices = "[" . $prices . "]";


                }


                $ecomm_prodid = $product_id;


                $ecomm_totalvalue = $prices;


            }


        }


        return array('ecomm_prodid' => strtoupper($ecomm_prodid), 'ecomm_totalvalue' => $ecomm_totalvalue, 'ecomm_pagetype' => $ecomm_pagetype);


    }


    function adWords_remarketing_price($cat)
    {


        $price = '';


        $query = $this->db->query("select count(*) as total,ManufactureID,ProductBrand,LabelsPerSheet 



		   from products WHERE ColourMaterial LIKE 'Matt White' 



		   AND CategoryID LIKE '" . $cat . "' LIMIT 1 ");


        $row = $query->row_array();


        if (isset($row['total']) and $row['total'] > 0) {


            $ManufactureID = $row['ManufactureID'];


            $ProductBrand = $row['ProductBrand'];


            if (preg_match("/Roll/i", $ProductBrand)) {


                $latest_price = $this->calclateprice($ManufactureID, 1, $row['LabelsPerSheet']);


                $price = $latest_price['final_price'];


            } else if (preg_match("/integrated/i", $ProductBrand)) {


                $price = $this->home_model->single_box_price($ManufactureID, 500);


                $price = $price['PlainPrice'];


            } else if (preg_match("/A3/i", $ProductBrand) || preg_match("/SRA3/i", $ProductBrand)) {


                $data = $this->product_model->ajax_price(100, $ManufactureID);


                $price = $data['custom_price'];


            } else {


                $data = $this->product_model->ajax_price(25, $ManufactureID);


                $price = $data['custom_price'];


            }


            $price = number_format($price, 2, '.', '');


        }


        return $price;


    }


    function basket_products()
    {


        $session_id = $this->session->userdata('session_id');


        $qry = $this->db->query("SELECT (select CategoryID from products WHERE products.ProductID=temporaryshoppingbasket.ProductID) AS CategoryID,TotalPrice FROM temporaryshoppingbasket WHERE SessionID = '" . $session_id . "'");


        return $qry->result();


    }


    function get_order_products()
    {


        $session_id = $this->session->userdata('session_id');


        $order = $this->db->query("select OrderNumber from orders WHERE SessionID LIKE '" . $session_id . "' ORDER by OrderID DESC LIMIT 1");


        $order = $order->row_array();


        if (isset($order['OrderNumber']) and $order['OrderNumber'] != '') {


            $qry = $this->db->query("SELECT (select CategoryID from products WHERE products.ProductID=orderdetails.ProductID) AS CategoryID,ProductTotal FROM orderdetails WHERE OrderNumber = '" . $order['OrderNumber'] . "'");


            return $qry->result();


        }


    }















    /**********  Google AdWords Remarketing Tag  *************/


    /**************Material page ********/


    function calculate_printed_sheets($qty, $type, $design = NULL, $brand = NULL, $manufacture = NULL)
    {
        if (isset($brand) AND trim($brand) === 'A5 Labels') {
            $areaDifferenceSQM = 0.03267;
            $marginDifferenceCost = 0.223;
        }

        $qurey = $this->db->query("SELECT * FROM `print_price` ORDER BY Quantity ASC");
        $result = $qurey->result();
        $sheets = '';
        $print_price = '';

        foreach ($result as $key => $row) {

            if ($qty <= 49) {

                $sheets = $row->Quantity;

                if ($type == 'Fullcolour') {
                    $print_price = $row->Fullcolour;

                } else {
                    $print_price = $row->Mono;
                }

                $free_artwork = $row->Free;
                break;
            } else if ($qty == $row->Quantity) {

                $sheets = $row->Quantity;

                if ($type == 'Fullcolour') {
                    $print_price = $row->Fullcolour;
                } else {
                    $print_price = $row->Mono;
                }

                $free_artwork = $row->Free;
                break;


            } else if (($qty > $row->Quantity and isset($result[$key + 1]->Quantity) and $qty < $result[$key + 1]->Quantity)) {

                $sheets = $result[$key + 1]->Quantity;
                if ($type == 'Fullcolour') {
                    $print_price = $result[$key + 1]->Fullcolour;
                } else {
                    $print_price = $result[$key + 1]->Mono;
                }

                $free_artwork = $result[$key + 1]->Free;

            } else if ($qty >= 40000) {
                $sheets = $row->Quantity;
                if ($type == 'Fullcolour') {
                    $print_price = $row->Fullcolour;
                } else {
                    $print_price = $row->Mono;
                }
                $free_artwork = $row->Free;
            }
        }

        $totalSQM = $areaDifferenceSQM * $qty;
        $marginCost = $totalSQM * $marginDifferenceCost;
        $marginCost = 0;  //For a5 prices a4/2
        $print_price = ($qty * $print_price) - $marginCost;

        if (isset($manufacture) and $manufacture != '') {
            $labels = $this->home_model->get_db_column('products', 'LabelsPerSheet', 'ManufactureID', $manufacture);
            $condition = "   max_labels >= " . $labels . " AND  min_labels  <= " . $labels;
            $row = $this->db->query("SELECT percentage FROM `a4_printing_discounts` where   $condition LIMIT 1")->row_array();
            if (isset($row['percentage']) and $row['percentage'] > 0) {
                $percentage = (100 - $row['percentage']) / 100;
                $print_price = $print_price / $percentage;
            }
        }

        $design_price = 0;
        $print_price = $this->check_price_uplift($print_price);


        /********** 50% disocunt prices on printed A4 Labels ***********/
        $print_price = $print_price / 2;
        
         //For a5 prices a4/2
        if (preg_match("/A5 Labels/is", $brand)) {
            $print_price = $print_price / 2;
        }


        if (isset($design) and $design > $free_artwork) {
            $design_price = ($design - $free_artwork);
            $design_price = $design_price * 5;
        }

        /************* Prices Uplift by 6% Yearly ***********************************/

        $design_price = $this->check_price_uplift($design_price);
        /*************************************************************************/


        /********** 50% disocunt prices on printed A4 Labels ***********/

        $print_price = number_format(($print_price), 2, '.', '');
        $design_price = number_format(($design_price), 2, '.', '');
        if (preg_match("/A3 Label/is", $brand) || preg_match("/SRA3 Label/is", $brand)) {
            $print_price = $print_price * 1.5;
        }


        return array('price' => $print_price, 'desginprice' => $design_price, 'artworks' => $free_artwork);
    }

    /***********label finder new changes*************/

    function genrate_shapes($list, $selected = NULL)
    {
        $category = $this->input->post('category');
        $html = '';

        foreach ($list as $row) {
            if (preg_match("/single/is", $category)) {
                $class = 'single';
            } else if (preg_match("/double/is", $category)) {
                $class = 'double';
            } else if (preg_match("/triple/is", $category)) {

                $class = 'triple';

            } else {

                $class = strtolower($row->Shapes);

            }


            $selected = ($selected == "Anti-tamper") ? "Anti-Tamper" : $selected;
            if ($selected == $row->Shapes) {
                $class = $class . ' active';
            }

            if (preg_match("/rectangle/is", $row->Shapes)) {
                $tooltip = 'RECTANGULAR LABELS';
            } else if (preg_match("/triangle/is", $row->Shapes)) {
                $tooltip = 'TRIANGULAR LABELS';
            } else if (preg_match("/tamper/is", $row->Shapes)) {
                $tooltip = 'TAMPER EVIDENT LABELS';
            } else {
                $tooltip = strtoupper($row->Shapes) . '  LABELS';
            }
            $html .= '<button type="button" class="btn_shape ' . $class . '" data-val="' . $row->Shapes . '"';
            $html .= ' data-toggle="tooltip" data-placement="top"  title="' . $tooltip . '"></button> ';
        }
        return $html;
    }


    function genrate_adhesive_options($list, $selected = NULL)
    {


        $trigger = $this->input->post('trigger');


        $category = $this->input->post('category');


        $html = '';


        $i = 1;


        $selected_array = explode(",", $selected);


        $selected_options = '';


        foreach ($list as $row) {


            if (isset($category) and $category == 'Integrated') {


                $checked = 'checked="checked"';


                $selected_options .= $row->Adhesive . ',';


            } else if (in_array($row->Adhesive, $selected_array)) {


                $checked = 'checked="checked"';


                $selected_options .= $row->Adhesive . ',';


            } else {


                $checked = '';


            }


            $html .= '<input class="adhesive_checkbox" ' . $checked . '  data-val="' . $row->Adhesive . '" type="checkbox">';


            $html .= '<label>' . $row->Adhesive . '</label> ';


            $i++;


        }


        return array('options' => $html, 'selected' => $selected_options);


    }


    function get_min_width_height($field, $condition)
    {


        $qry = "SELECT MAX($field) as `max`,MIN($field) as `min` from products p , category  c



						  where SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID



					      AND  $field != '' and (p.Activate ='Y' or p.Activate ='y' || p.displayin='both' || p.displayin='backoffice') AND $condition";


        $query = $this->db->query($qry);


        $result = $query->row_array();


        return $result;


    }


    function fetch_print_sheets()
    {


        $sql = $this->db->query("select * from tbl_print_prices order by ID asc");


        $sql = $sql->result();


        return $sql;


    }


    /***********label finder new changes*************/


    function customer_country_info()
    {


        $ip_address = $this->session->userdata('ip_address');


        //$ip_address = '202.69.35.194';


        //$ip_address = '109.224.217.102';


        //$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip_address));


        //if(isset($query['country']) and $query['country']!='United Kingdom') {


        //		$customer_country =  $query['country'];


        //}else{


        //		$customer_country =  'United Kingdom';


        //}


        $customer_country = 'United Kingdom';


        return $customer_country;


    }


    function get_currecy_options()
    {


        $sql = $this->db->query("select * from exchange_rates where status LIKE 'active' Order by ID ASC ");


        $sql = $sql->result();


        return $sql;


    }


    function currecy_converter($price, $vat = NULL)
    {
        $rate = $this->get_exchange_rate(currency);
        if (isset($rate) and $rate > 0) {
            $price = ((float)$price * (float)$rate);
        }
        if ($vat == 'yes' and vatoption == 'Inc') {
            $price = $price * 1.2;
        }
        return number_format(round($price, 2), 2, '.', '');
    }


    function get_exchange_rate($code)
    {


        $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '" . $code . "'");


        $sql = $sql->row_array();


        return $sql['rate'];


    }


    function get_currecy_symbol($code)
    {


        $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '" . $code . "'");


        $sql = $sql->row_array();


        return $sql['symbol'];


    }


    function fetch_product_details($product)
    {


        $sql = $this->db->query("select * from products where ProductID = '$product'");


        $sql = $sql->row_array();


        return $sql;


    }


    function get_printed_attch($id)
    {


        $sql = $this->db->query("select * from integrated_attachments where CartID = '$id' and source = 'flash' ");


        $sql = $sql->row_array();


        return $sql;


    }


    function get_integrated_attachments($serial = NULL)
    {


        $query = $this->db->query("select * from order_attachments_integrated WHERE Serial LIKE '" . $serial . "' and (source = 'flash' || source = 'plain')



			 ORDER BY ID ASC");


        return $query->row_array();


    }


    function get_user_flash_project($project)
    {


        $sql = $this->db->query("select * from flash_user_design where md5(ID) = '$project'");


        $sql = $sql->row_array();


        return $sql;


    }


    function fetch_labelsby_category($level = NULL, $code = NULL)
    {


        $condition = '';


        if (isset($code) and $code != '') {
            $condition = " parent_category LIKE '" . $code . "' AND ";
        }


        $query = $this->db->query("select * from application_category WHERE $condition level = $level AND status LIKE 'active'    Order by name ASC");


        return $query->result();


    }


    function fetch_child_category($code)
    {


        $releted_arr = explode(",", $code);


        $application = "'" . implode("','", $releted_arr) . "'";


        $condition = " CategoryID IN  (" . $application . ") AND ";


        $query = $this->db->query("Select CategoryID,CategoryName,CategoryImage,SubCategoryID from category WHERE $condition (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice')");


        return $query->result();


    }


    function fetch_category_designs($code, $designid = NULL)
    {


        $releted_arr = explode(",", $code);


        $application = "'" . implode("','", $releted_arr) . "'";


        $condition = " CategoryID IN  (" . $application . ") AND ";


        if ($designid != NULL) {
            $condition .= "  SUBSTRING(CategoryID, -4)  LIKE '" . trim($designid) . "' AND ";
        }


        /*$query = $this->db->query("Select COUNT(*) as total,SUBSTRING(CategoryID, -4),CategoryImage,CategoryName,CategoryID,CategoryImage,LabelWidth,LabelHeight,Shape_upd,DieCode from category



				WHERE $condition CategoryActive LIKE 'Y'



				GROUP BY  SUBSTRING(CategoryID, -4)



				ORDER BY cast(REPLACE(123CategoryName,' Label per Sheet','') as unsigned) ASC");*/


        $query = $this->db->query("Select COUNT(*) as total,SUBSTRING(CategoryID, -4) as designcode,CategoryImage,CategoryName,CategoryID,CategoryImage 



				from category WHERE $condition (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice')



				GROUP BY  SUBSTRING(CategoryID, -4)



				ORDER BY  CategorysortID ASC");


        return $query->result();


    }


    function fetch_similar_category_designs($tcode, $code)
    {


        $row = $this->db->query("SELECT SubCategoryID FROM `category` WHERE `SubCategoryID` LIKE '%" . $tcode . "%' ")->row_array();


        if (isset($row) and $row['SubCategoryID'] != '') {
            $code = $row['SubCategoryID'];
        }


        $releted_arr = explode(",", $code);


        $application = "'" . implode("','", $releted_arr) . "'";


        $condition = " CategoryID IN  (" . $application . ") AND ";


        $query = $this->db->query("Select COUNT(*) as total,SUBSTRING(CategoryID, -4) as designcode,CategoryImage,CategoryName,CategoryID,CategoryImage 



				from category WHERE $condition (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice')



				GROUP BY  SUBSTRING(CategoryID, -4)



				ORDER BY  CategorysortID ASC");


        return $query->result();


    }


    function fetch_child_subcategory($code, $designid = NULL)
    {


        $releted_arr = explode(",", $code);


        $application = "'" . implode("','", $releted_arr) . "'";


        $condition = " CategoryID IN  (" . $application . ") AND ";


        if ($designid != NULL) {
            $condition .= "  SUBSTRING(CategoryID, -4)  LIKE '" . trim($designid) . "' AND ";
        }


        $query = $this->db->query("Select SUBSTRING(CategoryID, -4) as designcode,CategoryImage,CategoryName,CategoryID,CategoryImage,LabelWidth,LabelHeight,Shape_upd,DieCode from category



				WHERE $condition (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice')



				ORDER BY cast(REPLACE(123CategoryName,' Label per Sheet','') as unsigned) ASC");


        return $query->result();


    }


    function make_lba_product_url($catid = NULL, $type)
    {


        $sub_url = '';


        $cat_url = '';


        $url = base_url() . 'labels-by-application/';


        if ($catid) {


            if ($type == 'product') {


                $query = $this->db->query("SELECT application_category.name FROM `category` 



						 INNER JOIN application_category ON  application_category.sub_category LIKE CONCAT('%',category.CategoryID, '%')



						 WHERE category.`SubCategoryID` LIKE '%" . $catid . "%' LIMIT 1");


            } else {


                $query = $this->db->query("SELECT name FROM `application_category` WHERE `sub_category` LIKE '%" . trim($catid) . "%' 



					AND status LIKE 'active' LIMIT 1");


            }


            $row = $query->row_array();


            if (isset($row['name']) and $row['name'] != '') {


                $cat_url = str_replace(" ", "-", trim($row['name'])) . '/';


            }


            $cat_url = strtolower($cat_url) . strtolower(trim($catid)) . '/';


        }


        return $url . $cat_url;


    }


    function get_lba_breadcrumb()
    {


        $html = '';


        $url = explode("/", uri_string());


        $url = array_filter($url);


        $count = count($url);


        $base = base_url();


        foreach ($url as $key => $row) {


            $base .= $row . '/';


            if ($count == $key) {


                $html .= '<li>' . ucfirst(str_replace("-", " ", $row)) . '</li>';


            } else {


                $html .= '<li><a href="' . $base . '">' . ucfirst(str_replace("-", " ", $row)) . '</a></li>';


            }


        }


        return $html;


    }


    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {


        $output = NULL;


        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {


            $ip = $_SERVER["REMOTE_ADDR"];


            if ($deep_detect) {


                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))


                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];


                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))


                    $ip = $_SERVER['HTTP_CLIENT_IP'];


            }


        }


        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));


        $support = array("country", "countrycode", "state", "region", "city", "location", "address");


        $continents = array(


            "AF" => "Africa",


            "AN" => "Antarctica",


            "AS" => "Asia",


            "EU" => "Europe",


            "OC" => "Australia (Oceania)",


            "NA" => "North America",


            "SA" => "South America"


        );


        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {


            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));


            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {


                switch ($purpose) {


                    case "location":


                        $output = array(


                            "city" => @$ipdat->geoplugin_city,


                            "state" => @$ipdat->geoplugin_regionName,


                            "country" => @$ipdat->geoplugin_countryName,


                            "country_code" => @$ipdat->geoplugin_countryCode,


                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],


                            "continent_code" => @$ipdat->geoplugin_continentCode


                        );


                        break;


                    case "address":


                        $address = array($ipdat->geoplugin_countryName);


                        if (@strlen($ipdat->geoplugin_regionName) >= 1)


                            $address[] = $ipdat->geoplugin_regionName;


                        if (@strlen($ipdat->geoplugin_city) >= 1)


                            $address[] = $ipdat->geoplugin_city;


                        $output = implode(", ", array_reverse($address));


                        break;


                    case "city":


                        $output = @$ipdat->geoplugin_city;


                        break;


                    case "state":


                        $output = @$ipdat->geoplugin_regionName;


                        break;


                    case "region":


                        $output = @$ipdat->geoplugin_regionName;


                        break;


                    case "country":


                        $output = @$ipdat->geoplugin_countryName;


                        break;


                    case "countrycode":


                        $output = @$ipdat->geoplugin_countryCode;


                        break;


                }


            }


        }


        return $output;


    }


    function allow_countries()
    {


        return array('IE', 'BE', 'DK', 'FR', 'NL', 'DE', 'SE', 'ES', 'CH', 'LU', 'GB', 'PK');


    }


    function get_print_sizes_count($condition)
    {


        $query = "SELECT COUNT(DISTINCT(CONCAT_WS('',Width,Height,Shape))) as total FROM category WHERE " . $condition;


        $row = $this->db->query($query)->row_array();


        return $row['total'];


    }


    function get_print_sizes($condition, $limit = NULL)
    {


        $sort = ' Order By Width,Height ASC ';


        $query = "SELECT CategoryName,CategoryID,CategoryImage,Height,Width,Shape,labelCategory,LabelCornerRadius,LabelCorner,NearestSizes,



				specification3



				FROM category WHERE " . $condition . " GROUP BY CONCAT_WS('',Width,Height,Shape) $sort $limit";


        $qry2 = $this->db->query($query);


        $data = array('num_row' => $qry2->num_rows(), 'list' => $qry2->result());


        return $data;


    }


    function get_print_min_width_height($field, $condition)
    {


        $qry = "SELECT MAX($field) as `max`,MIN($field) as `min` from category where $field != ''AND $condition";


        $query = $this->db->query($qry);


        $result = $query->row_array();


        return $result;


    }


    function get_roll_product_code($code)
    {


        $code = $code . 'R1';


        $row = $this->db->query("SELECT ManufactureID FROM `products` WHERE `CategoryID` LIKE '" . $code . "'")->row_array();


        $manufature = substr($row['ManufactureID'], 0, -1);


        $code = $this->getmaterialcode($manufature);


        return str_replace($code, "", $row['ManufactureID']);


    }


    function get_printing_product()
    {


    }


    function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
    {


        $pagination = '';


        if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) { //verify total pages and current page number


            $pagination .= '<ul class="pagination">';


            $right_links = $current_page + 4;


            $previous = $current_page - 1; //previous link


            $next = $current_page + 1; //next link


            $first_link = true; //boolean var to decide our first link


            if ($current_page > 1) {


                $previous_link = ($previous == 0) ? 1 : $previous;


                $pagination .= '<li class="first"><a href="javascript:void(0);" data-page="1" title="First">&laquo;</a></li>'; //first link


                $pagination .= '<li><a href="javascript:void(0);" data-page="' . $previous_link . '" title="Previous">&lt;</a></li>'; //previous link


                for ($i = ($current_page - 2); $i < $current_page; $i++) {


                    if ($i > 0) {


                        $pagination .= '<li><a href="javascript:void(0);" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';


                    }


                }


                $first_link = false;


            }


            if ($first_link) {


                $pagination .= '<li class="first active"><a href="javascript:void(0);">' . $current_page . '</a></li>';


            } elseif ($current_page == $total_pages) {


                $pagination .= '<li class="last active"><a href="javascript:void(0);">' . $current_page . '</a></li>';


            } else {


                $pagination .= '<li class="active"><a href="javascript:void(0);">' . $current_page . '</a></li>';


            }


            for ($i = $current_page + 1; $i < $right_links; $i++) { //create right-hand side links


                if ($i <= $total_pages) {


                    $pagination .= '<li><a href="javascript:void(0);" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';


                }


            }


            if ($current_page < $total_pages) {


                $next_link = ($next < $total_pages) ? $next : $total_pages;


                $pagination .= '<li><a href="javascript:void(0);" data-page="' . $next_link . '" title="Next">&gt;</a></li>';


                $pagination .= '<li class="last"><a href="javascript:void(0);" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>';


            }


            $pagination .= '</ul>';


        }


        return $pagination;


    }


    /*******  Roll Printing Formula *******/

    function calculate_printing_price($collection = array())
    {
        $promotiondiscount = 0.00;
        $rolls = $collection['rolls'];
        $labels = $collection['labels'];
        $manufature = $collection['manufature'];
        $finish = $collection['finish'];

        if (isset($labels) and $labels > 0) {
            $total_price = $this->calculate_print_material($manufature, $labels, $finish, $rolls);
            $label_finish = $total_price['label_finish'];
            $printprice = $total_price['price'];
            $collection['labeltype'];
            if ($collection['labeltype'] == '6 Colour Digital Process + White' || $collection['labeltype'] == 'Fullcolour+White') {
                $printprice = (1.1) * $printprice;  // - Full Colour + White Increase 10%
            }

            $labels_per_roll = $labels / $rolls;
            if ($labels_per_roll < 99) {
                $labels_per_roll = 100;
            }

            $plainprice = $this->calclateprice($manufature, $rolls, $labels_per_roll);


            $plainprice = $plainprice['final_price'];

            $minus_print_price = $printprice;
            $printprice = $printprice + $plainprice;
            $discount_price = $minus_print_price / 2;

            $promotiondiscount = sprintf('%.2f', round($discount_price, 2));
            $plainprice = sprintf('%.2f', round($plainprice, 2));
            $total_price = $printprice - $discount_price + $label_finish;


            // $minus_print_price = $printprice - $plainprice;
            // $discount_price = $minus_print_price/2;
            // $promotiondiscount = sprintf('%.2f', round($discount_price,2));
            // $plainprice = sprintf('%.2f', round($plainprice,2));
            // $total_price = $printprice-$discount_price+$label_finish;


            $final_price = sprintf('%.2f', round($total_price, 2));
            $unit_price = sprintf('%.2f', round($total_price / $rolls, 2));
            $perlabel = number_format(($unit_price / $labels) * 100, 2);


            return $data = array('perlabel' => $perlabel, 'final_price' => $final_price, 'unit_prcie' => $unit_price, 'Labels' => $labels, 'promotiondiscount' => $promotiondiscount, 'plainprice' => $plainprice, 'label_finish' => $label_finish);
        } else {

            return $data = array('perlabel' => 0.00, 'final_price' => 0.00, 'unit_prcie' => 0.00, 'Labels' => 0.00, 'label_finish' => 0.00, 'plainprice' => 0.00, 'promotiondiscount' => 0.00);
        }

    }


    function calculate_print_material__old($ManufactureID, $Labels, $finish, $rolls)
    {


        $query = $this->db->query("SELECT Width,Height,category.CategoryID,LabelsPerSheet FROM `products` as p 



		INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID Where ManufactureID LIKE '" . $ManufactureID . "' ");


        $query = $query->row_array();


        $width = $query['Width'];


        $height = $query['Height'];


        $max_labels = $query['LabelsPerSheet'];


        $across = $this->min_qty_roll($ManufactureID);


        //$labour_cost = $this->home_model->labour_cost_roll($across, $Labels, $rolls, $max_labels);


        $labour_cost = $this->home_model->labour_cost_roll($across, $Labels);


        $por_discount = $this->calculate_discount($Labels, $ManufactureID);


        $discount_percentage = $por_discount['discounts'];


        $por = (100 - $por_discount['por']) / 100;


        $ManufactureID = substr($ManufactureID, 0, -1);


        $material_sqr_cost = $this->material_sqr_cost($ManufactureID);


        $sqaure_meter = ($Labels * ($width * $height) / 1000000);


        //$sqaure_meter = number_format($sqaure_meter, 1, '.', '');


        $material_cost = ($material_sqr_cost) * $sqaure_meter;


        $ink_cost = $sqaure_meter * 1;


        $extra_cost = 0;


        //$por = 0.25;


        $total_cost = ($material_cost + $ink_cost + $labour_cost + $extra_cost);


        $price = $total_cost / $por;


        $discount = $price * ($discount_percentage / 100);


        $price = $price - $discount;


        $label_finish = 0;


        /************ New ************/


        //$discount_price = ($price*0.25)/2;


        /********************************/


        //	echo $sqaure_meter;


        if ($finish == 'Gloss Lamination') {


            $label_finish = (1.04 * $sqaure_meter);


            if ($label_finish < 10) {
                $label_finish = 10;
            }


        } else if ($finish == 'Matt Lamination') {


            $label_finish = (1.6 * $sqaure_meter);


            if ($label_finish < 10) {
                $label_finish = 10;
            }


        } else if ($finish == 'Matt Varnish' || $finish == 'Gloss Varnish' || $finish == 'High Gloss Varnish') {


            $label_finish = (0.25 * $sqaure_meter);


            if ($label_finish < 10) {
                $label_finish = 10;
            }


        }


        /********************** Price Uplift ************************/


        $price = $this->home_model->check_price_uplift($price);


        $label_finish = $this->home_model->check_price_uplift($label_finish);


        /***************************************************************/


        //$price = $price+$label_finish;


        return array('price' => $price, 'label_finish' => $label_finish);


    }


    function get_roll_qty($manufature1)
    {

        $manufature = substr($manufature1, 0, -1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` Where ManufactureID LIKE '" . $manufature . "' AND (Active LIKE 'Y' )");
        $roll = $roll->row_array();
        if (isset($roll['Rolls']) and $roll['Rolls'] > 0) {
            return $roll['Rolls'];
        } else {
            return 0;
        }


    }

    function calculate_print_material($ManufactureID, $Labels, $finish, $rolls)
    {

        $query = $this->db->query("SELECT Width,Height,category.CategoryID,LabelsPerSheet FROM `products` as p 
		INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID Where ManufactureID LIKE '" . $ManufactureID . "' ");
        $query = $query->row_array();

        $is_custom_width = $this->input->post('is_custom_Wh');

        if ($is_custom_width == true) {
            $width = $this->input->post('die_width') . '.00';
            $height = $this->input->post('die_height') . '.00';

        } else {
            $width = $query['Width'];
            $height = $query['Height'];
        }


        //	$width  = $query['Width'];
        //	$height = $query['Height'];
        $max_labels = $query['LabelsPerSheet'];

        $across = $this->get_roll_qty($ManufactureID);


        $width_plus_bleed = $width; //+ 3;
        $height_plus_bleed = $height; //+ 3;

        $width_sqr = $width_plus_bleed / 1000;
        $height_sqr = $height_plus_bleed / 1000;

        $sqr_meter = $width_sqr * $height_sqr;


        //$total_sqr_meter	 = $total_sqr_meter/0.9;  // add 10% wasteage on actual sqr meter

        $constants = $this->roll_pricing_const($Labels);

        $constants = json_decode(json_encode($constants), true);

        $first_labels = $constants[0]['labels'];
        $labour = $constants[0]['labour_mac'];
        //$machine_hr_rate = $constants['machine_hr_rate'];
        $margin = $constants[0]['margin'];

        $time = $constants[0]['time'];
        $por = $constants[0]['por'];


        //$labels_per_frame 	= round((0.95/$height_sqr)*$across);

        //$cmyk_cost_per_frame 		  = 0.0688;
        //$cmyk_cost 	= ($cmyk_cost_per_frame/$labels_per_frame)*$Labels;

        $second_labels = $Labels - $first_labels;

        $total_sqr_meter = $sqr_meter * $first_labels;

        $cmyk_cost_per_label = 0.28;
        $cmyk_cost = $cmyk_cost_per_label * $total_sqr_meter;

        //$print_cmyk_cost = $cmyk_cost+$labour+$machine_hr_rate;
        $print_cmyk_cost = $cmyk_cost + $labour;

        //$netsale  		 = $print_cmyk_cost/(100-$por)*100;
        $netsale = ($print_cmyk_cost * $margin) + $print_cmyk_cost;

        $netsale = number_format($netsale, 2, '.', '');

        $total_netsale2 = 0;

        if ($second_labels > 0) {
            $labels2 = $constants[1]['labels'];
            $labour2 = $constants[1]['labour_mac'];
            $margin2 = $constants[1]['margin'];

            $time2 = $constants[1]['time'];
            $por2 = $constants[1]['por'];

            $total_sqr_meter2 = $sqr_meter * $labels2;
            //echo $sqr_meter.' * '.$labels2.' = '.$total_sqr_meter2.'<br>';
            $cmyk_cost2 = $cmyk_cost_per_label * $total_sqr_meter2;

            //echo $cmyk_cost_per_label.' * '.$total_sqr_meter2.' = '.$cmyk_cost2.'<br>';

            $print_cmyk_cost2 = $cmyk_cost2 + $labour2;

            //echo $cmyk_cost2.' + '.$labour2.' = '.$print_cmyk_cost2.'<br>';

            $netsale2 = ($print_cmyk_cost2 * $margin2) + $print_cmyk_cost2;

            //echo '('.$print_cmyk_cost2.' * '.$margin2.')'.'+'.$print_cmyk_cost2.' = '.$netsale2.'<br>';

            $netsale2 = number_format($netsale2, 2, '.', '');

            $netsale2 = abs($netsale2 - $netsale);
            $tlabels = $labels2 - $first_labels;
            $total_netsale2 = $netsale2 / $tlabels;

            $total_netsale2 = $total_netsale2 * $second_labels;


        }


        //echo 'BBBBB ===== '.$first_labels.' ================ '.$netsale.' ----------------------------- '.$second_labels.' ============== '.$netsale2.' =========== '.$total_netsale2;
        $netsale = $netsale + $total_netsale2;

        $netsale = number_format(($netsale * 2), 2, '.', '');  //Double the price for 50% promotion


        //echo "AAAAAAAAAAAAA =============== ".$netsale;


        //$sqaure_meter = ($Labels*($width*$height)/1000000);
        $label_finish = 0;
        if ($finish == 'Gloss Lamination') {
            //1.04
            //echo $sqr_meter .' ================== '.$total_sqr_meter;
            //echo '<br>111111 ==== '.$total_sqr_meter;

            $label_finish_cost = (0.225 * $total_sqr_meter);

            //echo '<br>2222 ==== '.$label_finish_cost;

            //echo '<br>33333 ==== '.$time;

            $finish_labour = $time * 0.25;

            //echo '<br>44444 ==== '.$finish_labour;

            $finish_cost = $label_finish_cost + $finish_labour;

            //echo '<br>5555 ==== '.$finish_cost;

            $tpor = (100 - $por) / 100;

            $label_finish = $finish_cost / $tpor;

            $total_finish2 = 0;

            //echo '<br>AAAAAAAA ==== '.$label_finish;

            if ($second_labels > 0) {
                $label_finish_cost2 = $total_sqr_meter2 * 0.225;

                // echo '<br>AAAAAAAAAA.1 == '.$label_finish_cost2;

                $finish_labour2 = $time2 * 0.25;

                // echo '<br>AAAAAAAAAA.2 == '.$finish_labour2;

                $finish_cost2 = $label_finish_cost2 + $finish_labour2;

                // echo '<br>AAAAAAAAAA.3 == '.$finish_cost2;

                $tpor2 = (100 - $por2) / 100;

                //echo '<br>AAAAAAAAAA.4 == '.$tpor2;

                $label_finish2 = $finish_cost2 / $tpor2;

                // echo '<br>AAAAAAAAAA.5 == '.$label_finish2;

                $label_finish2 = abs($label_finish2 - $label_finish);

                // echo '<br>AAAAAAAAAA.6 == '.$label_finish2;

                $total_finish2 = $label_finish2 / $tlabels;

                // echo '<br>AAAAAAAAAA.7 == '.$label_finish2;

                $total_finish2 = $total_finish2 * $second_labels;

                //echo '<br>AAAAAAAAAA.8 == '.$label_finish2;


            }
            //echo '<br>BBBBBBBBBBBBBB ==== '.$total_finish2;
            $label_finish = $label_finish + $total_finish2;
            //echo '<br>CCCCCCCCCCCCCCCC ==== '.$label_finish;


            //if($label_finish < 10){$label_finish = 10;}
        } else if ($finish == 'Matt Lamination') {
            //1.6
            $label_finish_cost = (0.393 * $total_sqr_meter);

            $finish_labour = $time * 0.25;

            $finish_cost = $label_finish_cost + $finish_labour;

            $tpor = (100 - $por) / 100;

            $label_finish = $finish_cost / $tpor;
            $total_finish2 = 0;

            if ($second_labels > 0) {
                $label_finish_cost2 = $total_sqr_meter2 * 0.393;

                $finish_labour2 = $time2 * 0.25;

                $finish_cost2 = $label_finish_cost2 + $finish_labour2;

                $tpor2 = (100 - $por2) / 100;

                $label_finish2 = $finish_cost2 / $tpor2;

                $label_finish2 = abs($label_finish2 - $label_finish);

                $total_finish2 = $label_finish2 / $tlabels;

                $total_finish2 = $total_finish2 * $second_labels;


            }

            $label_finish = $label_finish + $total_finish2;

            //if($label_finish < 10){$label_finish = 10;}
        } else if ($finish == 'Matt Varnish' || $finish == 'Gloss Varnish' || $finish == 'High Gloss Varnish') {
            //0.25
            $label_finish_cost = (0.05 * $total_sqr_meter);


            $finish_labour = $time * 0.25;

            $finish_cost = $label_finish_cost + $finish_labour;

            $tpor = (100 - $por) / 100;

            $label_finish = $finish_cost / $tpor;
            $total_finish2 = 0;

            if ($second_labels > 0) {
                $label_finish_cost2 = $total_sqr_meter2 * 0.05;

                $finish_labour2 = $time2 * 0.25;

                $finish_cost2 = $label_finish_cost2 + $finish_labour2;

                $tpor2 = (100 - $por2) / 100;

                $label_finish2 = $finish_cost2 / $tpor2;

                $label_finish2 = abs($label_finish2 - $label_finish);

                $total_finish2 = $label_finish2 / $tlabels;

                $total_finish2 = $total_finish2 * $second_labels;


            }


            $label_finish = $label_finish + $total_finish2;
            //if($label_finish < 10){$label_finish = 10;}
        }

        //$label_finish = $this->check_price_uplift($label_finish);

        return array('price' => $netsale, 'label_finish' => $label_finish);
    }


    function roll_pricing_const($label)
    {
        $qurey = $this->db->query(" SELECT * FROM `print_roll_pricing_const` ORDER BY labels ASC ");
        $result = $qurey->result();
        $matched_row = array();

        foreach ($result as $key => $row) {
            if ($label == $row->labels) {
                $matched_row[0] = $row;
                //echo '111111';
                break;
            } else if (($label > $row->labels and isset($result[$key + 1]->labels) and $label < $result[$key + 1]->labels)) {
                $matched_row[0] = $result[$key];
                $matched_row[1] = $result[$key + 1];
                //echo '22222';
                break;
            } else if (($label < $row->labels and isset($result[$key + 1]->labels) and $label < $result[$key + 1]->labels)) {
                $matched_row[0] = $row;
                //echo '33333';
                break;
            }
        }
        if (empty($matched_row)) {
            if ($label > $result[$key]->labels) {
                $matched_row[0] = $result[$key];
                $matched_row[1] = $result[$key + 1];
            } else {
                $matched_row[0] = $result[0];
            }
        }
        return $matched_row;
    }


    function material_sqr_cost($menfactureid)
    {


        $code = $this->getmaterialcode($menfactureid);


        $query = $this->db->query("SELECT PrintPrice FROM `material_prices` WHERE Code LIKE '" . $code . "' LIMIT 1");


        $row = $query->row_array();


        return $row['PrintPrice'];


    }


    function calculate_discount($labels, $ManufactureID)
    {


        $ManufactureID = substr($ManufactureID, 0, -1);


        $labels = $this->labels_discount_breaks($labels);


        $labels = 'labels_' . $labels;


        $discounts = $this->home_model->get_db_column('roll_discount_table', $labels, 'manufacture_id', 'all');


        $pors = $this->home_model->get_db_column('roll_discount_table', $labels, 'manufacture_id', $ManufactureID);


        if (empty($pors)) {


            $pors = 75;


        }


        $data['por'] = $pors;


        $data['discounts'] = $discounts;


        return $data;


    }


    function labels_discount_breaks($labels)
    {


        if ($labels <= 100) {


            $discount_break = 100;


        } else if ($labels >= 100 and $labels < 150) {


            $discount_break = 100;


        } else if ($labels >= 150 and $labels < 200) {


            $discount_break = 150;


        } else if ($labels >= 200 and $labels < 250) {


            $discount_break = 200;


        } else if ($labels >= 250 and $labels < 300) {


            $discount_break = 250;


        } else if ($labels >= 300 and $labels < 350) {


            $discount_break = 300;


        } else if ($labels >= 350 and $labels < 400) {


            $discount_break = 350;


        } else if ($labels >= 400 and $labels < 450) {


            $discount_break = 400;


        } else if ($labels >= 450 and $labels < 500) {


            $discount_break = 450;


        } else if ($labels >= 500 and $labels < 1000) {


            $discount_break = 500;


        } else if ($labels >= 1000 and $labels < 2000) {


            $discount_break = 1000;


        } else if ($labels >= 2000 and $labels < 3000) {


            $discount_break = 2000;


        } else if ($labels >= 3000 and $labels < 4000) {


            $discount_break = 3000;


        } else if ($labels >= 4000 and $labels < 5000) {


            $discount_break = 4000;


        } else if ($labels >= 5000 and $labels < 7500) {


            $discount_break = 5000;


        } else if ($labels >= 7500 and $labels < 10000) {


            $discount_break = 7500;


        } else if ($labels >= 10000 and $labels < 15000) {


            $discount_break = 10000;


        } else if ($labels >= 15000 and $labels < 20000) {


            $discount_break = 15000;


        } else if ($labels >= 20000 and $labels < 30000) {


            $discount_break = 20000;


        } else if ($labels >= 30000 and $labels < 40000) {


            $discount_break = 30000;


        } else if ($labels >= 40000 and $labels < 50000) {


            $discount_break = 40000;


        } else if ($labels >= 50000 and $labels < 75000) {


            $discount_break = 50000;


        } else if ($labels >= 75000 and $labels < 100000) {


            $discount_break = 75000;


        } else if ($labels >= 100000 and $labels < 150000) {


            $discount_break = 100000;


        } else if ($labels >= 150000 and $labels < 200000) {


            $discount_break = 150000;


        } else if ($labels >= 200000 and $labels < 250000) {


            $discount_break = 200000;


        } else if ($labels >= 250000 and $labels < 300000) {


            $discount_break = 250000;


        } else if ($labels >= 300000 and $labels < 350000) {


            $discount_break = 300000;


        } else if ($labels >= 350000 and $labels < 400000) {


            $discount_break = 350000;


        } else if ($labels >= 400000 and $labels < 450000) {


            $discount_break = 400000;


        } else if ($labels >= 450000 and $labels < 500000) {


            $discount_break = 450000;


        } else if ($labels >= 500000) {


            $discount_break = 500000;


        }


        return $discount_break;


    }


    function roll_labour_breaks($labels)
    {


        if ($labels <= 500) {


            $discount_break = 500;


        } else if ($labels > 500 and $labels <= 1000) {


            $discount_break = 1000;


        } else if ($labels > 1000 and $labels <= 2000) {


            $discount_break = 2000;


        } else if ($labels > 2000 and $labels <= 3000) {


            $discount_break = 3000;


        } else if ($labels > 3000 and $labels <= 4000) {


            $discount_break = 4000;


        } else if ($labels > 4000 and $labels <= 5000) {


            $discount_break = 5000;


        } else if ($labels > 5000 and $labels <= 7500) {


            $discount_break = 7500;


        } else if ($labels > 7500 and $labels <= 10000) {


            $discount_break = 10000;


        } else if ($labels > 10000 and $labels <= 15000) {


            $discount_break = 15000;


        } else if ($labels > 15000 and $labels <= 20000) {


            $discount_break = 20000;


        } else if ($labels > 20000 and $labels <= 30000) {


            $discount_break = 30000;


        } else if ($labels > 30000 and $labels <= 40000) {


            $discount_break = 40000;


        } else if ($labels > 40000 and $labels <= 50000) {


            $discount_break = 50000;


        } else if ($labels > 50000 and $labels <= 75000) {


            $discount_break = 75000;


        } else if ($labels > 75000 and $labels <= 100000) {


            $discount_break = 100000;


        } else if ($labels > 100000 and $labels <= 150000) {


            $discount_break = 150000;


        } else if ($labels > 150000 and $labels <= 200000) {


            $discount_break = 200000;


        } else if ($labels > 200000 and $labels <= 250000) {


            $discount_break = 220000;


        } else if ($labels > 250000 and $labels <= 300000) {


            $discount_break = 300000;


        } else if ($labels > 300000 and $labels <= 350000) {


            $discount_break = 350000;


        } else if ($labels > 350000 and $labels <= 400000) {


            $discount_break = 400000;


        } else if ($labels > 400000 and $labels <= 450000) {


            $discount_break = 450000;


        } else if ($labels > 450000) {


            $discount_break = 500000;


        }


        return $discount_break;


    }


    function get_db_column($table, $column, $key, $value)
    {


        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '" . $value . "' LIMIT 1 ")->row_array();


        return (isset($row[$column]) and $row[$column] != '') ? $row[$column] : '';


    }


    function labour_cost_roll($dieacross, $label)
    {


        $roll_col = 'roll_' . $dieacross;


        $qurey = $this->db->query("SELECT Labels,$roll_col as labour_cost FROM `roll_labour_cost` ORDER BY Labels ASC");


        $result = $qurey->result();


        $labelpersheet_is = '';


        $labour_cost = 0.00;


        foreach ($result as $key => $row) {


            if ($label == $row->Labels) {


                $labour_cost = $row->labour_cost;


                break;


            } else if (($label > $row->Labels and isset($result[$key + 1]->Labels) and $label < $result[$key + 1]->Labels)) {


                $labour_cost = $result[$key + 1]->labour_cost;


                //$labour_cost = $row->labour_cost;


                break;


            }


        }


        if (empty($labour_cost)) {


            if ($label > $result[$key]->Labels) {


                $labour_cost = $result[$key]->labour_cost;


            } else {


                $labour_cost = $result[0]->labour_cost;


            }


        }


        return $labour_cost;


    }


    function labour_cost_roll_old($across, $labels, $rolls, $persheet)
    {


        $upper_limit = $this->roll_labour_breaks($labels);


        $upper_limit_col = 'labels_' . $upper_limit;


        $labourcost = $this->home_model->get_db_column('roll_labour_cost', $upper_limit_col, 'die_across', $across);


        $response = $this->home_model->rolls_calculation($across, $persheet, $upper_limit);


        //if($upper_limit >  $labels){


        if ($upper_limit > $labels && $response['rolls'] != $rolls) {


            $perlabelcost = $labourcost / $upper_limit;


            $lower_limit = $this->labels_discount_breaks($labels);


            $lower_limit_col = 'labels_' . $lower_limit;


            $labourcost = $this->home_model->get_db_column('roll_labour_cost', $lower_limit_col, 'die_across', $across);


            $labourcost = ($perlabelcost * ($labels - $lower_limit)) + $labourcost;


        }


        return $labourcost;


        //echo "actual_rolls: ".$rolls;


        //$response = $this->home_model->rolls_calculation($across, $persheet, $labels);


        //$per_roll = $labourcost/$response['rolls'];


        //$labourcost = $per_roll*$rolls;


        /*$minutes = 120;



			$batch = $rolls/$across;



			$batch = $batch-1;



			$batch_minutes = $batch*4;



			$total_minutes = $minutes+$batch_minutes;



			$labour_cost = $total_minutes*0.25;



			return round($labour_cost);*/


    }


    function fetch_uploaded_artworks($cartid, $ProductID)
    {
        $sid = $this->session->userdata('session_id') . '-PRJB';
        $q = $this->db->query(" select * from integrated_attachments WHERE SessionID LIKE '" . $sid . "' AND ProductID =$ProductID AND CartID=$cartid ORDER BY ID ASC ");
        return $q->result();
    }
    function fetch_uploaded_artworks_total_qty($cartid, $ProductID)
    {
        $sid = $this->session->userdata('session_id') . '-PRJB';
        $q = $this->db->query(" select sum(qty) as total_roll from integrated_attachments WHERE SessionID LIKE '" . $sid . "' AND ProductID = '" . $ProductID. "'  AND CartID= '" .$cartid. "'");
        return $q->result();
    }

    function grouping_material_for_printed($condtion)
    {
        $query = $this->db->query("SELECT * FROM `products` WHERE $condtion AND (Activate='Y' || displayin='both' || displayin='backoffice') group by LabelColor   order by priority asc ");
        //echo "SELECT * FROM `products` WHERE $condtion AND Activate='Y' group by LabelColor   order by priority asc ";
        return $query->result();
    }


    function rolls_calculation($die_across, $max_labels, $total_labels, $rolls = NULL)
    {

        if ($rolls != NULL) {
            $rolls = $rolls + $die_across;
        } else {
            $rolls = $die_across;
        }
        $per_roll = $total_labels / $rolls;
        /*print_r($rolls);
        print_r('<br> j ');
        print_r($total_labels);
        print_r('<br> ja ');
        print_r($per_roll);
        print_r('<br> jaa ');
        print_r($max_labels);
        exit;*/
        if ($per_roll > $max_labels) {
            $response = $this->rolls_calculation($die_across, $max_labels, $total_labels, $rolls);
            //print_r($response); exit;
            $per_roll = $response['per_roll'];
            $rolls = $response['rolls'];
        }

        $data['per_roll'] = ceil($per_roll);
        //$data['total_labels']   = ceil($per_roll)*$rolls;
        $data['total_labels'] = $total_labels;
        $data['actual_labels'] = $total_labels;
        $data['rolls'] = $rolls;
        return $data;
    }


    function desing_service_charges($design)
    {


        if ($design == 1) {
            $price = 50;
        } else if ($design == 2) {
            $price = 75;
        } else if ($design == 3) {
            $price = 95;
        } else if ($design == 4) {
            $price = 110;
        } else if ($design == 5) {
            $price = 120;
        }


        return $price;


    }


    function get_printed_files($cartid, $ProductID)
    {


        $sid = $this->session->userdata('session_id');


        $q = $this->db->query(" select * from integrated_attachments WHERE SessionID LIKE '" . $sid . "' 



	  AND ProductID =$ProductID AND CartID=$cartid AND status LIKE 'confirm' ORDER BY ID ASC ");


        return $q->result();


    }


    function get_artwork_jobs($order)
    {


        $sql = $this->db->query("select * from order_attachments_integrated inner join orderdetails on orderdetails.SerialNumber = order_attachments_integrated.Serial where MD5(order_attachments_integrated.OrderNumber) LIKE '" . $order . "' and order_attachments_integrated.status = 67 order by ID desc limit 1");


        $sql = $sql->row_array();


        return $sql;


    }


    function get_all_artwork_jobs($order)
    {


        $sql = $this->db->query("select * from order_attachments_integrated inner join orderdetails on orderdetails.SerialNumber = order_attachments_integrated.Serial where MD5(order_attachments_integrated.OrderNumber) LIKE '" . $order . "'")->result();


        return $sql;


    }


    function count_artwork_jobs($order)
    {


        $sql = $this->db->query("select count(*) as total from order_attachments_integrated 



			   inner join orderdetails on orderdetails.SerialNumber = order_attachments_integrated.Serial



			   where MD5(order_attachments_integrated.OrderNumber) LIKE '" . $order . "' and order_attachments_integrated.status = 67 ")->row_array();


        return $sql['total'];


    }


    function make_option_with_tooltip($list, $field, $name, $selec = NULL)
    {


        $tooltip = '';


        if ($field == 'ColourMaterial_upd') {
            $filter = 'material';
        } else if ($field == 'Adhesive') {
            $filter = 'adhesive';
        } else {
            $filter = 'color';
        }


        $option = '';


        if (count($list) > 1) {


            $option = '<li class=""><a data-value="" data-id="' . $filter . '">' . $name . '</a></li>';


        }


        $class = '';


        if ($field == 'Material1') {
            $class = 'col-sm-6 col-xs-12';
            $option = '';
        }


        foreach ($list as $a_row) {


            $selected = '';


            if ($a_row->$field == $selec) {


                $selected = ' active ';


            }


            $option .= '<li class="' . $class . '">';


            $tooltip = $this->home_model->get_db_column('material_tooltip_info', 'tooltip_info', 'material_name', $a_row->$field);


            $option .= '<a data-id="' . $filter . '" data-value="' . $a_row->$field . '" data-toggle="tooltip-material" data-trigger="hover" data-placement="right" title="' . $tooltip . '">' . ucfirst($a_row->$field) . '</a></li>';


        }


        if ($field == 'Material1') {


            $option .= '<li class="' . $class . '"><a class="orange" data-value="" data-id="' . $filter . '">Reset colour filter</a></li>';


        }


        return $option;


    }


    function get_total_printed_labels($cartid, $ProductID)
    {


        $labels = $this->db->query(' Select SUM(labels) as labels from integrated_attachments



			WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $ProductID . '" ')->row_array();


        return $labels['labels'];


    }


    function min_labels_per_roll($dieacross)
    {


        if ($dieacross == 1) {


            return 100;


        } else {


            return 50;


        }


    }


    function max_total_labels_on_rolls_old($perroll)
    {


        $max_labels = ceil(500000 / $perroll);


        $max_labels = $max_labels * $perroll;


        return $max_labels;


    }
    
    function max_total_labels_on_rolls($perroll)
    {

        $max_labels = ceil(1000000 / $perroll);
        $max_labels = $max_labels * $perroll;
        return $max_labels;

    }


    function get_digital_printing_process($type)
    {


        return $this->db->query(" Select * from digital_printing_process WHERE type LIKE '" . $type . "' OR type LIKE 'both' ")->result();


    }


    function get_printing_service_name($process)
    {


        if ($process == 'Fullcolour') {


            $A4Printing = ' Printing Service ( Full Colour) ';


        } else if ($process == 'Mono') {


            $A4Printing = ' Printing Service ( Monochrome – Black Only ) ';


        } else {


            $A4Printing = ' Printing Service ( ' . $process . ' )';


        }


        return $A4Printing;


    }


    function update_order_attachment($jobno, $array)
    {


        $this->db->where('ID', $jobno);


        $this->db->update('order_attachments_integrated', $array);


        return 'updated';


    }


    function add_to_timeline($jobno, $status, $ver)
    {


        $array = array('Jobno' => $jobno, 'Action' => $status, 'Time' => time(), 'Version' => $ver, 'operator' => $this->session->userdata('UserID'));


        $this->db->insert('artwork_timeline', $array);


        return 'inserted';


    }











    /*************************************/


    /*



		**************************************



		GET THE ATACHED FILES FOR REORDER - JD



		**************************************



	*/


    function get_attached_atworks_for_order($orderNumber, $ProductID)
    {


        $q = $this->db->query(" select * from order_attachments_integrated WHERE ProductID = '" . $ProductID . "' AND OrderNumber = '" . $orderNumber . "' ORDER BY ID ASC");


        return $q->result();


    }


    function get_sum_of_designed_artworks($orderNum, $ProductID)


    {


        $q = $this->db->query("select SUM(labels) AS labels from order_attachments_integrated WHERE ProductID = '" . $ProductID . "' AND OrderNumber = '" . $orderNum . "' ORDER BY ID ASC");


        $sql = $q->row_array();


        return $sql;


    }


    /********New Material Listing *************/


    function grouping_material_listing($condtion)
    {


        $query = $this->db->query("SELECT * FROM `products` WHERE $condtion AND (Activate='Y' || displayin='both' || displayin='backoffice')



		GROUP BY CONCAT(LabelFinish,'',ColourMaterial) order by priority asc ");


        return $query->result();


    }


    function grouping_material_colours($condtion)
    {


        $query = $this->db->query("SELECT colour as LabelColor,imagecode,colour_name FROM `products_colour` WHERE $condtion order by priority desc");


        return $query->result();


    }


    function grouping_material_adhesive($condtion)
    {


        $query = $this->db->query("SELECT ahesive as Adhesive FROM `products_adhesive` WHERE $condtion");


        return $query->result_array();


    }


    function search_adhesive_in_array($array, $key, $val)
    {


        foreach ($array as $item)


            if (isset($item[$key]) && $item[$key] == $val)


                return true;


        return 'disabled="disabled"';


    }


    function get_total_uploaded_qty($cartid, $ProductID)
    {


        $labels = $this->db->query(' Select SUM(labels) as labels, SUM(qty) as sheets from integrated_attachments



			WHERE CartID LIKE "' . $cartid . '" AND ProductID LIKE "' . $ProductID . '" ')->row_array();


        $data['labels'] = $labels['labels'];


        $data['sheets'] = $labels['sheets'];


        return $data;


    }


    function grouping_compatiblity($compatible, $product)
    {


        if (preg_match("/\bDirect Thermal\b/i", $compatible)) {


            $d_thermal_img = 'd-thermal-check.png';


            $d_thermal_text = $this->get_compatibility_text('Direct Thermal', 'COMPATIBLE', $product);


        } else {


            $d_thermal_img = 'd-thermal-cross.png';


            $d_thermal_text = $this->get_compatibility_text('Direct Thermal', 'INCOMPATIBLE', $product);


        }


        if (preg_match("/\bThermal Transfer\b/i", $compatible)) {


            $thermal_img = 'thermal-check.png';


            $thermal_text = $this->get_compatibility_text('Thermal Transfer', 'COMPATIBLE', $product);


        } else {


            $thermal_img = 'thermal-cross.png';


            $thermal_text = $this->get_compatibility_text('Thermal Transfer', 'INCOMPATIBLE', $product);


        }


        if (preg_match("/Laser/i", $compatible)) {


            $laser_img = 'laser-check.png';


            $laser_text = $this->get_compatibility_text('Laser', 'COMPATIBLE', $product);


        } else {


            $laser_img = 'laser-cross.png';


            $laser_text = $this->get_compatibility_text('Laser', 'INCOMPATIBLE', $product);


        }


        if (preg_match("/\bInkjet\b/i", $compatible)) {


            $inkjet_img = 'inkjet-check.png';


            $inkjet_text = $this->get_compatibility_text('Inkjet', 'COMPATIBLE', $product);


        } else {


            $inkjet_img = 'inkjet-cross.png';


            $inkjet_text = $this->get_compatibility_text('Inkjet', 'INCOMPATIBLE', $product);


        }


        return array('inkjet_img' => $inkjet_img,


            'inkjet_text' => $inkjet_text,


            'laser_img' => $laser_img,


            'laser_text' => $laser_text,


            'thermal_img' => $thermal_img,


            'thermal_text' => $thermal_text,


            'd_thermal_img' => $d_thermal_img,


            'd_thermal_text' => $d_thermal_text,


        );


    }


    function get_compatibility_text($method, $type, $product)
    {


        $row = $this->db->query(" Select description from materials_compatibility WHERE print_method LIKE '" . $method . "' 



		AND type LIKE '" . $type . "' AND product LIKE '" . $product . "' ")->row_array();


        if (isset($row['description']) and $row['description'] != '') {
            return $row['description'];
        } else {
            return '';
        }


    }


    function get_user_against_ip($ip)
    {


        $row = $this->db->query(" Select UserID from orders where TrackingIP LIKE '" . $ip . "' AND source LIKE 'Website' 



		ORDER BY OrderID DESC LIMIT 1")->row_array();


        if (isset($row['UserID']) and $row['UserID']) {


            $name = $this->home_model->get_db_column('customers', 'BillingFirstName', 'UserID', $row['UserID']);


            if (empty($name)) {


                $name = $this->home_model->get_db_column('customers', 'BillingLastName', 'UserID', $row['UserID']);


            }


            return $name;


        }


    }



    /*old for salespanel, before label embellishment start*/
    function insert_preferences_old_before_embellishment($data)
    {
        if (!empty($data)) {
            $data['Domain'] = "AA";
            $count = $this->db->where('email', $data['email'])->get('printing_preferences')->num_rows();
            if ($count == 0) {
                $this->db->insert('printing_preferences', $data);
            } else {
                //$this->db->where('sessionID',$data['sessionID']);

                /*Change for Embellishment Start*/
                if(!isset($data['orientation'] ) ) {
                    $data['orientation'] = "orientation1";
                }
                /*Change for Embellishment Ends*/
                $this->db->where('email', $data['email']);
                $this->db->update('printing_preferences', $data);
            }
        }
        return true;
    }
    /*old for salespanel, before label embellishment ends*/


    function insert_preferences($data)
    {
        if (!empty($data)) {
            $data['Domain'] = "AA";
            $count = $this->db->where('sessionID', $this->shopping_model->sessionid())->get('printing_preferences')->num_rows();
            if ($count == 0) {
                $this->db->insert('printing_preferences', $data);
            } else {
                //$this->db->where('sessionID',$data['sessionID']);

                if(!isset($data['orientation'] ) )
                {

                    $data['orientation'] = "orientation1";
                }

                $this->db->where('sessionID', $this->shopping_model->sessionid());
                $this->db->update('printing_preferences', $data);
            }
        }
        return true;
    }


    function load_preferences($email)


    {


        $preferences = $remove = array();


        $preferences = $this->db->limit(1)
            ->where('email', $email)
            ->where('Domain', 'AA')
            ->order_by('updated_on', 'DESC')
            ->get('printing_preferences')
            ->row_array();


        if (!empty($preferences)) {


            if ($preferences['available_in'] == "A4" && ($preferences['material_a4'] == '' || $preferences['material_a4'] == NULL || $preferences['color_a4'] == '' || $preferences['color_a4'] == NULL || $preferences['adhesive_a4'] == '' || $preferences['adhesive_a4'] == NULL)) {


                $remove = array(


                    'productcode_a4' => NULL


                );


                $this->db->where('email', $email);


                $this->db->update('printing_preferences', $remove);


                $preferences = array_merge($preferences, $remove);


            }


            if ($preferences['available_in'] == "Roll" && ($preferences['material_roll'] == '' || $preferences['material_roll'] == NULL || $preferences['color_roll'] == '' || $preferences['color_roll'] == NULL || $preferences['adhesive_roll'] == '' || $preferences['adhesive_roll'] == NULL || $preferences['finish_roll'] == '' || $preferences['finish_roll'] == NULL)) {


                $remove = array(


                    'productcode_roll' => NULL


                );


                $this->db->where('email', $email);


                $this->db->update('printing_preferences', $remove);


                $preferences = array_merge($preferences, $remove);


            }


            if (strpos($preferences['selected_size'], ",") === false and $preferences['available_in'] != "both") {


                if ($preferences['selected_size'][0] == "c") {


                    //remove a4 options if the category is changed to only a4


                    $remove = array(


                        'labels_a4' => NULL,


                        'digital_proccess_a4' => NULL,


                        'color_a4' => NULL,


                        'adhesive_a4' => NULL,


                        'material_a4' => NULL,


                        'productcode_a4' => NULL,


                        'categorycode_a4' => NULL,


                    );


                    $this->db->where('email', $email);


                    $this->db->update('printing_preferences', $remove);


                } else if ($preferences['selected_size'][0] == "T") {


                    //remove roll options if the category is changed to only roll


                    $remove = array(


                        'wound_roll' => NULL,


                        'labels_roll' => NULL,


                        'orientation' => NULL,


                        'coresize' => NULL,


                        'finish_roll' => NULL,


                        'digital_proccess_roll' => NULL,


                        'color_roll' => NULL,


                        'adhesive_roll' => NULL,


                        'material_roll' => NULL,


                        'productcode_roll' => NULL,


                        'categorycode_roll' => NULL,


                    );


                    $this->db->where('email', $email);


                    $this->db->update('printing_preferences', $remove);


                }


                $preferences = array_merge($preferences, $remove);


            }


            //echo"<pre>";print_r($preferences);echo"</pre>";exit;


            return $preferences;


        }


        return false;


    }


    function reset_preferences($email)


    {


        $array = $this->db->get('printing_preferences')->row_array();


        $update = array();


        $exclude = array('sessionID', 'email', 'ID', 'min_width', 'max_width', 'min_height', 'max_height', 'updated_on');


        foreach ($array as $key => $value) {


            if (in_array($key, $exclude)) {


                continue;


            }


            $update[$key] = NULL;


        }


        $this->db->where('email', $email);


        $this->db->update('printing_preferences', $update);


    }


    function additional_charges_rolls($rolls)
    {


        if ($rolls <= 3) {
            $per_roll = 1.50;
        } else if ($rolls > 3 and $rolls <= 10) {
            $per_roll = 1.35;
        } else if ($rolls > 10 and $rolls <= 25) {
            $per_roll = 1.20;
        } else if ($rolls > 25 and $rolls <= 50) {
            $per_roll = 1.05;
        } else if ($rolls > 50 and $rolls <= 100) {
            $per_roll = 0.90;
        } else if ($rolls > 100 and $rolls <= 200) {
            $per_roll = 0.75;
        } else if ($rolls > 200) {
            $per_roll = 0.60;
        }


        $price = $per_roll * $rolls;


        /************* Prices Uplift by 6% Yearly **************/


        $price = $this->check_price_uplift($price);


        /*******************************************************/


        return $price;


    }


    function fetch_sheets_adhesive($adhesive = NULL, $catid = NULL, $productid = NULL, $other = NULL)
    {


        if ($catid != NULL) {


            if ($productid != NULL and $other != NULL) {


                $query = $this->db->query("SELECT * FROM `products` WHERE ProductID <> '$productid' AND CategoryID = '$catid' AND Adhesive LIKE '$adhesive' and (Activate='Y' || displayin='both' || displayin='backoffice') order by sortBy asc");


                return $query->result();


            } else if ($productid != NULL) {


                $query = $this->db->query("SELECT * FROM `products` WHERE ProductID = '$productid' AND Adhesive LIKE '$adhesive' and (Activate='Y' || displayin='both' || displayin='backoffice') order by sortBy asc");


                return $query->result();


            } else {


                $query = $this->db->query("SELECT * FROM `products` WHERE CategoryID = '$catid' AND Adhesive LIKE '$adhesive' and (Activate='Y' || displayin='both' || displayin='backoffice') GROUP BY CONCAT(LabelFinish,'',ColourMaterial) order by sortBy asc");


                return $query->result();


            }


        }


    }


    function get_shapes_count()


    {


        $sql = "SELECT shape_upd, COUNT(*) as num FROM `category` WHERE (CategoryActive LIKE 'Y' || displayin='both' || displayin='backoffice') AND `shape_upd` != ' ' AND labelCategory LIKE 'A4 Labels' Group by shape_upd ORDER BY `category`.`shape_upd` ASC";


        $data = $this->db->query($sql);


        $return = array();


        foreach ($data->result_array() as $data) {


            $return[$data['shape_upd']] = $data['num'];


        }


        return $return;


    }


    function get_rectangle_group($width, $height)


    {


        $group = 1;


        $type = 'wshvl';


        $width = (int)$width;


        $height = (int)$height;


        $h = $w = false;


        if ($width > $height) {


            $w = true;


            $group = round($width / $height);


        } else if ($height > $width) {


            $h = true;


            $group = round($height / $width);


        }


        if ($group == 1) {


            $type = "wshs";


        }


        if ($group == 2) {


            if ($w) {


                $type = "wlhs";


            } else {


                $type = "wshl";


            }


        }


        if ($group == 3) {


            if ($w) {


                $type = "wlhs";


            } else {


                $type = "wshl";


            }


        }


        if ($group >= 4) {


            if ($w) {


                $type = "wlhvs";


            } else {


                $type = "wshvl";


            }


        }


        return $type;


    }


    function check_price_uplift($total_price)
    {


        $total_price = $total_price / 0.94; // 6% increment yearly march 2018


        return $total_price;


    }


    function gethexacode($code)
    {


        $qry = $this->db->query("select code from material_tooltip_info where material_code LIKE '" . $code . "' ")->row_array();


        return $qry['code'];


    }


    function get_details_roll_quotation($id)
    {


        $query = $this->db->query("SELECT * from roll_print_basket WHERE SerialNumber = '$id' ");


        $row = $query->row_array();


        return $row;


    }


    function is_Sample_Order($order_no)
    {

        $check_sample_order = $this->db->query("select PaymentMethods from orders where OrderNumber like '" . $order_no . "'")->row();
        if (count($check_sample_order) > 0) {
            if ($check_sample_order->PaymentMethods == 'Sample Order') {
                return '&ndash;';
            } else {
                return false;
            }
        }
    }


    public function fetch_custom_die_order($id)
    {


        $query = $this->db->query("SELECT * from flexible_dies_info WHERE OID = '$id' ");


        $row = $query->row_array();


        return $row;


    }


    public function fetch_custom_die_association($id)
    {


        return $this->db->query("select * from flexible_dies_mat where OID = $id")->result();


    }


    function get_mat_name($text)
    {


        $query = $this->db->query("SELECT label_name from material_tooltip_info where material_code LIKE  '" . $text . "' ");


        $row = $query->row_array();


        return $row['label_name'];


    }


    function fetch_customer_versions($id)
    {


        $query = $this->db->query("select * from artwork_chat where attach_id = $id and ref !=0 order by ref desc ");


        return $query->result();


    }


    function fetch_custfeed($id, $ver)
    {


        $query = $this->db->query("select * from customer_artwork_feedback where jobno = $id and ref = $ver");


        return $query->row_array();


    }


    function fetch_maxversion($id)
    {


        return $this->db->query("SELECT * from customer_artwork_feedback where jobno = $id order by ref desc limit 1")->row_array();


    }


    function fetch_current_chat($id, $ref)
    {


        $query = $this->db->query("select * from artwork_chat where attach_id = $id and ref = $ref ");


        return $query->row_array();


    }


    function fetch_approve_ref($id)
    {


        $query = $this->db->query("SELECT approveref from customer_artwork_feedback where jobno = $id order by ID desc limit 1")->row_array();


        return $query['approveref'];


    }


    public function checkref($id, $maxref)
    {


        return $this->db->query("SELECT * from version_record where jobno = $id and ref = $maxref ")->row_array();


    }


    public function fetch_maxref($id)
    {


        $query = $this->db->query("SELECT MAX(ref) as max from artwork_chat where attach_id = $id ")->row_array();


        return $query['max'];


    }


    public function versionrecord($jobno)
    {


        $maxref = $this->fetch_maxref($jobno);


        $check = $this->checkref($jobno, $maxref);


        if (empty($check)) {


            if ($maxref == 1) {


                $insert = array('jobno' => $jobno, 'ref' => $maxref, 'q1' => 1, 'q2' => 1, 'q3' => 1, 'q4' => 1, 'q5' => 1, 'q6' => 1, 'q7' => 1);


            } else {


                $sndlast = $maxref - 1;


                $pre_ref = $this->fetch_custfeed($jobno, $sndlast);


                $q1 = ($pre_ref['q1'] == 0) ? 1 : 0;
                $q2 = ($pre_ref['q2'] == 0) ? 1 : 0;


                $q3 = ($pre_ref['q3'] == 0) ? 1 : 0;
                $q4 = ($pre_ref['q4'] == 0) ? 1 : 0;


                $q5 = ($pre_ref['q5'] == 0) ? 1 : 0;
                $q6 = ($pre_ref['q6'] == 0) ? 1 : 0;


                $q7 = ($pre_ref['q7'] == 0) ? 1 : 0;


                $insert = array('jobno' => $jobno, 'ref' => $maxref, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'q6' => $q6, 'q7' => $q7);


            }


            $this->db->insert('version_record', $insert);


        }


    }


    function update_integrated_table($qty = 1000, $manufactureid)


    {


        $cond = '';


        if ($qty == 1000) {


            $cond = "and Price_1000 != '0'";


        }


        $query = $this->db->query("select *, Box_$qty as Box from integrated_labels_prices where ManufactureID LIKE '" . $manufactureid . "' $cond");


        $integrated_prices = $query->result();


        return $integrated_prices;


    }

    function make_html_option_filter($list, $field, $name, $selec = NULL)
    {
        $page = $this->input->post('page');
        $type = $this->input->post('type');
        $text = '';
        $option = '';
        $value = '';
        $second_field = '';
        if ($field == 'LabelsPerSheet') {
            $text = ' Labels per sheet';
        }

        if (count($list) == 1) {
            //$option = '<option value="" > ' . $name . ' </option>';
            $option .= '<li class=""><a data-id="' . strtolower($field) . '" data-value="reset">' . $name . '</a></li>';
            foreach ($list as $a_row) {
                //echo"<pre>";print_r($a_row);echo"</pre>";exit;
                $selected = '';
                if ($a_row->$field == $selec) {
                    $selected = 'selected="selected"';
                }

                $value_disp = $value = $a_row->$field;
                if ($field == "Material" || $field == "Color") {
                    if ($field == "Material") {
                        $value_disp .= " (" . $a_row->count . ")";
                        if (isset($type) and $type == "Rolls") {
                            $second_field = $a_row->SpecText7_rolls;
                        } else {
                            $second_field = $a_row->SpecText7;
                        }

                    }
                    if ($field == "Color") {
                        if (isset($type) and $type == "Rolls") {
                            $value_disp = $value . " - <small>" . $a_row->SpecText7_rolls . "</small>";
                        } else {
                            $value_disp = $value . " - <small>" . $a_row->SpecText7 . "</small>";
                        }
                        $second_field = $a_row->adhesive;
                    }
                }
                if ($field == 'SpecText7') {
                    $category = $this->input->post('category');
                    if (preg_match("/Roll/i", $category)) {
                        $category = 'Roll Labels';
                    }
                    $compatibility = $this->check_compatibility($a_row->$field, $category);
                    $value = $compatibility . ' Compatible';
                }
                //$option .='<option  '.$selected.'  value="' . $a_row->$field . '" >' . $value . ' ' . $text . '</option>';
                $option .= '<li class=""><a data-id="' . strtolower($field) . '" data-value="' . ucfirst($value) . '">' . ucfirst($value_disp) . '<br><small>' . $second_field . '</small></a></li>';
            }
        } else {
            //$option = '<option value="" > ' . $name . ' </option>';
            $option .= '<li class=""><a data-id="' . strtolower($field) . '" data-value="reset">' . $name . '</a></li>';
            foreach ($list as $a_row) {
                //echo"<pre>";print_r($a_row);echo"</pre>";exit;
                $selected = '';
                if ($a_row->$field == $selec) {
                    $selected = 'selected="selected"';
                }

                $value_disp = $value = $a_row->$field;

                if ($field == "Material" || $field == "Color") {
                    if ($field == "Material") {
                        $value_disp .= " (" . $a_row->count . ")";
                        if (isset($type) and $type == "Rolls") {
                            $second_field = $a_row->SpecText7_rolls;
                        } else {
                            $second_field = $a_row->SpecText7;
                        }
                    }
                    if ($field == "Color") {
                        if (isset($type) and $type == "Rolls") {
                            $value_disp = $value . " - <small>" . $a_row->SpecText7_rolls . "</small>";
                        } else {
                            $value_disp = $value . " - <small>" . $a_row->SpecText7 . "</small>";
                        }
                        $second_field = $a_row->adhesive;
                    }
                }
                if ($field == 'SpecText7') {
                    $category = $this->input->post('category');
                    if (preg_match("/Roll/i", $category)) {
                        $category = 'Roll Labels';
                    }
                    $compatibility = $this->check_compatibility($a_row->$field, $category);
                    $value = $compatibility . ' Compatible';
                }

                $option .= '<li class=""><a data-id="' . strtolower($field) . '" data-value="' . ucfirst($value) . '">' . ucfirst($value_disp) . '<br><small>' . $second_field . '</small></a></li>';
            }
        }
        if (isset($page) and $page != 'index') {
            //$option .= '<option value="" > Reset Selection </option>';
            $option .= '<li class=""><a data-id="' . strtolower($field) . '" data-value="reset"> Reset All </a></li>';
        }
        return $option;
    }

    function get_integrated_delivery($qty, $fakeCountry = '', $con = null)
    {
        $prices = array();
        $prices['dpd'] = '';
        $prices['batch_qty'] = '';
        $prices['pallets'] = '';
        if ($fakeCountry != '') {
            $country = 'United Kingdom';
        } else {
            $country = 'United Kingdom';
        }
        if ($country == 'United Kingdom') {
            $qry = "SELECT * FROM integrated_labels_delivery Order By batch_qty ASC";
            $query = $this->db->query($qry);
            $result = $query->result_array();
            foreach ($result as $key => $row) {
                if ($qty <= 4000) {
                    $prices = $result[0];
                } else if ($qty == $row['batch_qty']) {
                    $prices = $result[$key];
                } else if (($qty > $row['batch_qty'] and isset($result[$key + 1]['batch_qty']) and $qty < $result[$key + 1]['batch_qty'])) {
                    $prices = $result[$key + 1];
                } else if ($qty > 200000) {
                    $prices = end($result);
                }
            }
        } else {
            $box = $this->convert_qty_to_box($qty);
            $prices = $this->integrated_delivery_offshore($box, $country);
            if ($prices['dpd'] == 0) {
                $prices = $this->get_integrated_delivery($qty, 'UK');
            }
        }
        return $prices;
    }


    function convert_qty_to_box($qty)


    {


        $box = ceil($qty / 1000);


        return $box;


    }


    function integrated_delivery_offshore($box, $country)


    {


        $sql = "Select * From integrated_delivery_offshore Where country LIKE '$country'";


        $result = $this->db->query($sql)->result_array();


        $min_qty = $result[0]['box'];


        $max_qty = end($result);


        $max_qty = $max_qty['box'];


        foreach ($result as $key => $row) {


            if ($box <= $min_qty) {


                $prices = $result[0];


            } else if ($box == $row['box']) {


                $prices = $result[$key];


            } else if (($box > $row['box'] and isset($result[$key + 1]['box']) and $box < $result[$key + 1]['box'])) {


                $prices = $result[$key + 1];


            } else if ($box > $max_qty) {


                $prices = end($result);


            }


        }


        $prices['dpd'] = $box * $prices['perbox'];


        if ($box < 50 and ($prices['dpd'] > $prices['half_pallet'])) {


            $prices['dpd'] = $prices['half_pallet'];


        }


        if ($box >= 50 and ($prices['dpd'] > $prices['full_pallet'])) {


            $prices['dpd'] = $prices['full_pallet'];


        }


        return $prices;


    }


    function get_equivalent_id($size)


    {


        $qry = "SELECT c.CategoryID,p.ProductID,p.ManufactureID FROM `category` c JOIN products p ON p.CategoryID = c.CategoryID WHERE c.CategoryName LIKE '%$size%' and c.labelCategory NOT LIKE 'Integrated Labels' and p.ManufactureID LIKE '%1WTP' and (p.Activate = 'Y' || p.displayin='both' || p.displayin='backoffice') LIMIT 1";


        $data = $this->db->query($qry)->row();


        return $data;


    }


///////////////////////********************************////////////////////////////////********************************


    function generate_category_shapes()
    {


        $shapes = $this->db->query("SELECT DISTINCT(Shape) AS Shapes,`labelCategory` from category 



		WHERE (CategoryActive = 'Y' || displayin='both' || displayin='backoffice') AND Shape != '' ORDER BY Shape ASC ")->result();


        $shape_list = array();


        foreach ($shapes as $row) {


            $row->labelCategory = str_replace(" ", "", $row->labelCategory);


            $row->labelCategory = str_replace("Labels", "", $row->labelCategory);


            $row->labelCategory = str_replace("Label", "", $row->labelCategory);


            $shape_list[$row->labelCategory][] = $row->Shapes;


        }


        return json_encode($shape_list);


    }


    function get_lba_uplift_price($sheets, $price, $perprice, $total_labels)


    {


        if ($sheets > 0 and $sheets < 4) {


            $uplift = 25;


        } else if ($sheets > 3 and $sheets < 6) {


            $uplift = 22;


        } else if ($sheets > 5 and $sheets < 8) {


            $uplift = 18;


        } else if ($sheets > 7 and $sheets < 10) {


            $uplift = 15;


        } else if ($sheets > 9 and $sheets < 12) {


            $uplift = 12;


        } else if ($sheets > 11 and $sheets < 15) {


            $uplift = 10;


        } else if ($sheets > 14 and $sheets < 18) {


            $uplift = 7;


        } else if ($sheets > 17 and $sheets < 21) {


            $uplift = 5;


        } else if ($sheets > 20 and $sheets < 24) {


            $uplift = 4;


        } else if ($sheets > 23 and $sheets < 25) {


            $uplift = 3;


        } else {


            $uplift = 0;


        }


        $price = $perprice * $total_labels;


        $price = $price + $price * ($uplift / 100);


        $price = number_format($price, 2, '.', '');


        return $price;


    }


    function check_material_discount($material_code, $type, $keys = false)
    {
        $discounts = array();
        if ($type == 'Roll') {
            $discounts['HGP'] = 30;
            $discounts['FQP'] = 25;
            $discounts['MLT'] = 25;
            $discounts['MLB'] = 25;
            $discounts['MLS'] = 25;
        } else if ($type == 'A4') {
            $discounts['MOP'] = 30;
            $discounts['MLT'] = 25;
            $discounts['MLB'] = 25;
            $discounts['WPEP'] = 20;
        } else if ($type == 'A5') { // A5 WPEP Discount
            $discounts['WPEP'] = 20;
        }


        if ($keys) {
            return array_keys($discounts);
        }
        if (array_key_exists($material_code, $discounts)) {
            return $discounts[$material_code];
        }
    }







    ///////////////////////********************************////////////////////////////////********************************

    ///////////////////////********************************////////////////////////////////********************************

    ///////////////////////********************************////////////////////////////////********************************

    ///////////////////////********************************////////////////////////////////********************************


    function get_lba_maincategories()
    {

        $this->db->where('active', 1);

        $q = $this->db->get('lba_main_cat');

        return $q->result();

    }


    function get_lba_categories_byid($catID)
    {

        $this->db->where('maincat', $catID);

        $q = $this->db->get('lba_categories');

        return $q->result();

    }


    function get_lba_categories()
    {

        $this->db->where('active', 'Y');

        $q = $this->db->get('lba_categories');

        return $q->result();

    }


    function get_lba_subcategories($catID)

    {

        $this->db->where('parent_category', $catID);

        $q = $this->db->get('lba_subcategories');

        return $q->result();

    }


    function get_lba_labels_data($designID)
    {

        $query = "SELECT * FROM `lba_sets`  WHERE Designid = '$designID' and active = 'Y'  and display = 1";

        $products = $this->db->query($query);

        return $products->result();

    }


    function get_lba_die_data($designID)
    {

        $query = "SELECT * FROM `lba_subcategories` sub JOIN `lba_categories` cat on sub.parent_category = cat.ID JOIN lba_design des on des.categoryID = sub.CID WHERE sub.parent_category = cat.ID and des.designID = '$designID' and cat.active = 'Y' and sub.active = 'Y'";

        $die = $this->db->query($query);

        return $die->row();

    }


    function get_related_designs($designID)
    {

        $query = "SELECT * FROM `lba_design`  WHERE categoryID = '$designID' and active = 'Y'";

        $products = $this->db->query($query);

        return $products->result();

    }

    function get_lba_designs($designID)
    {

        $query = "SELECT * FROM `lba_design`  WHERE designID = '$designID' and active = 'Y'";

        $products = $this->db->query($query);

        return $products->row_array();

    }


    ///////////////////////********************CART SECTION/////////////////////////********************************


    function get_user_lba_data($designid)
    {

        $query = "SELECT * FROM `lba_user_design` WHERE ID = '$designid'";

        $products = $this->db->query($query);

        return $products->row_array();

    }


    ///////////////////////********************RECOMMENDED SECTION/////////////////////////********************************


    function fetch_all_user_designs()
    {

        $userid = $this->session->userdata('userid');

        $query = "SELECT * FROM `lba_user_design` WHERE UserID = $userid order by ID asc";

        $products = $this->db->query($query)->result();

        return $products;

    }


    function fetch_recommended_labels($label_id)
    {

        $labeldata = $this->get_lba_one_labels_data($label_id);

        return $this->fetch_product_data($labeldata['category'], $labeldata['setid'], $labeldata['Designid'], $labeldata['ID']);

    }


    function get_lba_one_labels_data($labelid)
    {

        $query = "SELECT * FROM `lba_sets`  WHERE ID = '$labelid' and active = 'Y'";

        $products = $this->db->query($query);

        return $products->row_array();

    }


    function fetch_product_data($category, $setid, $designid, $labelid)
    {

        $query = "SELECT * FROM `lba_sets` WHERE category = '$category' and setid = $setid and Designid = $designid and ID != $labelid and active = 'Y' limit 4";

        $products = $this->db->query($query);

        return $products->result();

    }


    ///////////////////////********************************////////////////////////////////********************************


    function get_lba_set_data($designID)

    {

        //$query = "SELECT * FROM `lba_sets` p, `lba_subcategories` s WHERE p.category = s.CID and p.category = '$code' and p.active = 'Y' and s.active = 'Y' GROUP BY setid DESC";


        $query = "SELECT * FROM lba_sets sets JOIN lba_design des ON des.designID = sets.Designid JOIN lba_subcategories sub on sub.CID = sets.category WHERE sets.category = sub.CID and des.designID = '$designID' and sets.active = 'Y' and sub.active = 'Y' and des.active = 'Y' GROUP BY setid DESC";


        $products = $this->db->query($query);

        return $products->result();

    }

    function get_product_data($category, $setid, $designid)

    {

        $query = "SELECT * FROM `lba_sets` WHERE category = '$category' and setid = $setid and Designid = $designid and active = 'Y'";

        $products = $this->db->query($query);

        return $products->result();

    }


    function get_operator($operatorId)
    {
        $qry = $this->db->query("select UserName from customers where UserID = $operatorId ");
        $data = $qry->row_array();
        return $data['UserName'];
    }



    ///////////////////////********************************////////////////////////////////********************************

    ///////////////////////********************************////////////////////////////////********************************


    function grouping_product_material_colours($condtion)
    {


        $query = $this->db->query("SELECT * FROM `products` WHERE $condtion AND (Activate='Y' || displayin='both' || displayin='backoffice') group by LabelColor order by `priority` desc ");

        //echo '<br><br>'.($this->db->last_query());
        //die();
        return $query->result();


    }

    function grouping_product_material_adhesive($condtion)
    {

        $query = $this->db->query("SELECT * FROM `products` WHERE $condtion  AND (Activate='Y' || displayin='both' || displayin='backoffice') order by priority asc ");

        //echo '<br><br>'.($this->db->last_query());

        return $query->result_array();


    }


    function save_logs($activity, $log_arr)
    {
        $arr = json_encode($log_arr);
        //$arr_ins['SessionID'] = $this->session->userdata('session_id');
        $arr_ins['Activity'] = $activity;
        $arr_ins['Record'] = $arr;
        $arr_ins['Website'] = 'BK';
        //$arr_ins['DateTime']  = 	strtotime(date('Y-m-d h:i:s'));
        $this->db->insert('websitelog', $arr_ins);
    }
    
    
    function isOrderRollPrintLabelTrue($orderNumber)
    {

        $query = $this->db->query(" SELECT * FROM orderdetails  WHERE  OrderNumber = '$orderNumber' AND ProductName LIKE '%Roll Labels%' AND Printing = 'Y' ");
        $result = $query->result_array();

        $query1 = $this->db->query(" SELECT * FROM orderdetails  WHERE  OrderNumber = '$orderNumber' AND ProductID = 0 AND custom_design = '' ");
        $result1 = $query1->result_array();

        if (count($result1) > 0 || (count($result) > 0 && count($result1) > 0)) {
            return true;
        } else {
            return false;
        }
    }




        /****************************************************/
        /***********LABEL EMBELLISHMENT TASK START***********/
        /****************************************************/


        function calculate_printed_sheets_label_embellishment($qty, $type, $design = NULL, $brand = NULL, $manufacture = NULL,$finish = array())
        {
            if (isset($brand) AND trim($brand) === 'A5 Labels') {
                $areaDifferenceSQM = 0.03267;
                $marginDifferenceCost = 0.223;
            }

            $qurey = $this->db->query("SELECT * FROM `print_price` ORDER BY Quantity ASC");
            $result = $qurey->result();
            $sheets = '';
            $print_price = '';
            foreach ($result as $key => $row) {
                if ($qty <= 49) {
                    $sheets = $row->Quantity;
                    if ($type == 'Fullcolour') {
                        $print_price = $row->Fullcolour;
                    } else {
                        $print_price = $row->Mono;
                    }
                    $free_artwork = $row->Free;

                    break;
                } else if ($qty == $row->Quantity) {
                    $sheets = $row->Quantity;
                    if ($type == 'Fullcolour') {
                        $print_price = $row->Fullcolour;
                    } else {
                        $print_price = $row->Mono;
                    }
                    $free_artwork = $row->Free;
                    break;
                } else if (($qty > $row->Quantity and isset($result[$key + 1]->Quantity) and $qty < $result[$key + 1]->Quantity)) {
                    $sheets = $result[$key + 1]->Quantity;
                    if ($type == 'Fullcolour') {
                        $print_price = $result[$key + 1]->Fullcolour;
                    } else {
                        $print_price = $result[$key + 1]->Mono;
                    }
                    $free_artwork = $result[$key + 1]->Free;
                } else if ($qty >= 40000) {
                    $sheets = $row->Quantity;
                    if ($type == 'Fullcolour') {
                        $print_price = $row->Fullcolour;
                    } else {
                        $print_price = $row->Mono;
                    }
                    $free_artwork = $row->Free;
                }
            }

            $totalSQM = $areaDifferenceSQM * $qty;
            $marginCost = $totalSQM * $marginDifferenceCost;
            $marginCost = 0; //Bypass a5 price
            $print_price = ($qty * $print_price) - $marginCost;

            if (isset($manufacture) and $manufacture != '') {
                $labels = $this->home_model->get_db_column('products', 'LabelsPerSheet', 'ManufactureID', $manufacture);
                $condition = "   max_labels >= " . $labels . " AND  min_labels  <= " . $labels;
                $row = $this->db->query("SELECT percentage FROM `a4_printing_discounts` where   $condition LIMIT 1")->row_array();
                if (isset($row['percentage']) and $row['percentage'] > 0) {
                    //$percentage = 1+($row['percentage']/100);
                    //$print_price = $print_price*$percentage;

                    $percentage = (100 - $row['percentage']) / 100;
                    $print_price = $print_price / $percentage;
                }
            }
            $design_price = 0;

            if (isset($design) and $design > $free_artwork) {
                $design_price = ($design - $free_artwork) * 5;
            }

            /************* Prices Uplift by 6% Yearly ***********************************/
            $print_price = $this->check_price_uplift($print_price);
            $design_price = $this->check_price_uplift($design_price);
            /**********************************    **************************************/

            /********** 50% disocunt prices on printed A4 Labels ***********/
            if (preg_match("/A3 Label/is", $brand) || preg_match("/A5 Labels/is", $brand) || preg_match("/SRA3 Label/is", $brand) || preg_match("/A4 Labels/is", $brand)) {
                $print_price = $print_price / 2;
                //Bypass a5 price
                if (preg_match("/A5 Labels/is", $brand)) {
                    $print_price = $print_price / 2;
                }
            }

            /********** 50% disocunt prices on printed A4 Labels ***********/
            $print_price = number_format(($print_price), 2, '.', '');
            $design_price = number_format(($design_price), 2, '.', '');

            /********** Add Finishes and Embellishments for sheets start***********/

            $label_finish_total_all = 0;
            $label_finish2_total_all = 0;

            foreach ($finish as $finish_and_emb_val){
                $label_finish = 0;

                $label_finish_embellishment_main_id = $this->get_db_column("label_finsh_and_emb_main", "id", "parsed_name", $finish_and_emb_val);
//            $label_finish_embellishment_main_id = (int)$label_finish_embellishment_main_id;
                $finish_and_emb_constants = $this->sheet_pricing_const_label_emb($qty,$label_finish_embellishment_main_id);

                $finish_and_emb_labels1 = $finish_and_emb_constants[0]->labels;
                $finish_and_emb_labour1 = $finish_and_emb_constants[0]->labour;
                $finish_and_emb_cost1 = $finish_and_emb_constants[0]->finish_and_lamination_cost;
                $finish_and_emb_time1 = $finish_and_emb_constants[0]->time;
                $finish_and_emb_por1 = $finish_and_emb_constants[0]->por;


                $second_labels_finish = $qty - $finish_and_emb_labels1;
//                         print_r($second_labels_finish);die;

                $width_sqr = 0.210;
                $height_sqr = 0.297;
                $sqr_meter = $width_sqr * $height_sqr;

                $total_sqr_meter_finish = $sqr_meter * $finish_and_emb_labels1;
//             print_r($total_sqr_meter_finish);die;

                //1.04
                //echo $sqr_meter .' ================== '.$total_sqr_meter;
//            echo '<br>111111 ==== '.$finish_and_emb_por2;die;

                $label_finish_cost = ($finish_and_emb_cost1 * $total_sqr_meter_finish);
//             print_r($label_finish_cost);die;

                //echo '<br>2222 ==== '.$label_finish_cost;

                //echo '<br>33333 ==== '.$time;

                $finish_labour = $finish_and_emb_time1 * $finish_and_emb_labour1;
//             print_r($finish_labour);die;

                //echo '<br>44444 ==== '.$finish_labour;

                $finish_cost = $label_finish_cost + $finish_labour;
//             print_r($finish_cost);die;

                //echo '<br>5555 ==== '.$finish_cost;

                $tpor = (100 - $finish_and_emb_por1) / 100;
//             print_r($tpor);die;

                $label_finish = $finish_cost / $tpor;
//             print_r($label_finish);die;

                $total_finish2 = 0;

                //echo '<br>AAAAAAAA ==== '.$label_finish;

                if ($second_labels_finish > 0) {
                    $finish_and_emb_labels2 = $finish_and_emb_constants[1]->labels;
                    $finish_and_emb_labour2 = $finish_and_emb_constants[1]->labour;
                    $finish_and_emb_cost2 = $finish_and_emb_constants[1]->finish_and_lamination_cost;
                    $finish_and_emb_time2 = $finish_and_emb_constants[1]->time;
                    $finish_and_emb_por2 = $finish_and_emb_constants[1]->por;

                    $total_sqr_meter2 = $sqr_meter * $finish_and_emb_labels2;
//                echo '<br>AAAAAAAAAA.1 == '.$total_sqr_meter2; die;

                    $label_finish_cost2 = $total_sqr_meter2 * $finish_and_emb_cost2;

//                 echo '<br>AAAAAAAAAA.1 == '.$label_finish_cost2;

                    $finish_labour2 = $finish_and_emb_time2 * $finish_and_emb_labour2;

//                 echo '<br>AAAAAAAAAA.2 == '.$finish_labour2;

                    $finish_cost2 = $label_finish_cost2 + $finish_labour2;

//                 echo '<br>AAAAAAAAAA.3 == '.$finish_cost2;

                    $tpor2 = (100 - $finish_and_emb_por2) / 100;

                    //echo '<br>AAAAAAAAAA.4 == '.$tpor2;

                    $label_finish2 = $finish_cost2 / $tpor2;

//                 echo '<br>AAAAAAAAAA.5 == '.$label_finish2;

                    $label_finish2 = abs($label_finish2 - $label_finish);

//                 echo '<br>AAAAAAAAAA.6 == '.$label_finish2;
                    $tlabels_finish = $finish_and_emb_labels2 - $finish_and_emb_labels1;

                    $total_finish2 = $label_finish2 / $tlabels_finish;

//                 echo '<br>AAAAAAAAAA.7 == '.$total_finish2;

                    $total_finish2 = $total_finish2 * $second_labels_finish;

//                echo '<br>AAAAAAAAAA.8 == '.$total_finish2;


                }
                //echo '<br>BBBBBBBBBBBBBB ==== '.$total_finish2;
                $label_finish = $label_finish + $total_finish2;
                $label_finish_total_all += $label_finish;

//            echo '<br>CCCCCCCCCCCCCCCC ==== '.$label_finish_total_all;

                //if($label_finish < 10){$label_finish = 10;}
                //           echo"<pre>"; print_r( $finish_and_emb_constants);echo"<br>";

            }

            /********** Add Finishes and Embellishments for sheets end***********/
            $label_finish_total_all = number_format(($label_finish_total_all), 2, '.', '');
            return array('price' => $print_price,'label_finish' => $label_finish_total_all, 'desginprice' => $design_price, 'artworks' => $free_artwork);
        }
    function sheet_pricing_const_label_emb($label, $label_finsh_and_emb_main_id)
    {
        $qurey =  $this->db->where('label_finsh_and_emb_main_id',$label_finsh_and_emb_main_id)->get('sheet_label_finsh_and_emb_const')->result();
//echo"<pre>";print_r($qurey);die;
//        $qurey = $this->db->query(" SELECT * FROM `print_roll_pricing_const` ORDER BY labels ASC ");
//        $result = $qurey->result();
        $result = $qurey;
        $matched_row = array();

        foreach ($result as $key => $row) {
            if ($label == $row->labels) {
                $matched_row[0] = $row;
                //echo '111111';
                break;
            } else if (($label > $row->labels and isset($result[$key + 1]->labels) and $label < $result[$key + 1]->labels)) {
                $matched_row[0] = $result[$key];
                $matched_row[1] = $result[$key + 1];
                //echo '22222';
                break;
            } else if (($label < $row->labels and isset($result[$key + 1]->labels) and $label < $result[$key + 1]->labels)) {
                $matched_row[0] = $row;
                //echo '33333';
                break;
            }
        }
        if (empty($matched_row)) {
            if ($label > $result[$key]->labels) {
                $matched_row[0] = $result[$key];
                $matched_row[1] = $result[$key + 1];
            } else {
                $matched_row[0] = $result[0];
            }
        }
        return $matched_row;
    }

        function calculate_printing_price_label_embellishment($collection = array())
        {


            $promotiondiscount = 0.00;

            $rolls = $collection['rolls'];
            $labels = $collection['labels'];

            $manufature = $collection['manufature'];
            $finish = $collection['finish'];



            if (isset($labels) and $labels > 0) {

                $total_price = $this->calculate_PrintPrice_roll_label_embellishment($manufature, $labels, $finish, $rolls);
//print_r($total_price);die;
                /******************* Labels 50% Discounts ***********************************/
                $label_finish = $total_price['label_finish'];
                $printprice = $total_price['price'];

                if ($collection['labeltype'] == 'Fullcolour+White') {
                    $printprice = (1.1) * $printprice;  // - Full Colour + White Increase 10%
                }

                $labels_per_roll = $labels / $rolls;
                if ($labels_per_roll < 99) {
                    $labels_per_roll = 100;
                }
                $plainprice = $this->calclateprice($manufature, $rolls, $labels_per_roll);

                $plainprice = $plainprice['final_price'];

                $minus_print_price = $printprice;
                $printprice = $printprice + $plainprice;
                $discount_price = $minus_print_price / 2;
                // $minus_print_price = $printprice - $plainprice;
                // $discount_price = $minus_print_price/2;

                $promotiondiscount = sprintf('%.2f', round($discount_price, 2));
                $plainprice = sprintf('%.2f', round($plainprice, 2));

                $total_price = $printprice - $discount_price + $label_finish;

                /**************************************************************************/


                $final_price = sprintf('%.2f', round($total_price, 2));
                $unit_price = sprintf('%.2f', round($total_price / $rolls, 2));
                $perlabel = number_format(($unit_price / $labels) * 100, 2);
                return $data = array('perlabel' => $perlabel,
                    'final_price' => $final_price,
                    'unit_prcie' => $unit_price,
                    'Labels' => $labels,
                    'promotiondiscount' => $promotiondiscount,
                    'plainprice' => $plainprice,
                    'label_finish' => $label_finish);

            } else {
                return $data = array('perlabel' => 0.00, 'final_price' => 0.00, 'unit_prcie' => 0.00, 'Labels' => 0.00, 'label_finish' => 0.00, 'plainprice' => 0.00, 'promotiondiscount' => 0.00);
            }
        }

        function  calculate_PrintPrice_roll_label_embellishment($ManufactureID, $Labels, $finish, $rolls)
        {

            $query = $this->db->query("SELECT Width,Height,category.CategoryID,LabelsPerSheet FROM `products` as p 
		INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID Where ManufactureID LIKE '" . $ManufactureID . "' ");
            $query = $query->row_array();

            $width = $query['Width'];
            $height = $query['Height'];
            $max_labels = $query['LabelsPerSheet'];


            $across = $this->min_qty_roll($ManufactureID);


            $width_plus_bleed = $width; //+ 3;
            $height_plus_bleed = $height; //+ 3;

            $width_sqr = $width_plus_bleed / 1000;
            $height_sqr = $height_plus_bleed / 1000;

            $sqr_meter = $width_sqr * $height_sqr;


            //$total_sqr_meter	 = $total_sqr_meter/0.9;  // add 10% wasteage on actual sqr meter

            $constants = $this->roll_pricing_const($Labels);

            $constants = json_decode(json_encode($constants), true);

            $first_labels = $constants[0]['labels'];
            $labour = $constants[0]['labour_mac'];
            //$machine_hr_rate = $constants['machine_hr_rate'];
            $margin = $constants[0]['margin'];

            $time = $constants[0]['time'];
            $por = $constants[0]['por'];


            //$labels_per_frame 	= round((0.95/$height_sqr)*$across);

            //$cmyk_cost_per_frame 		  = 0.0688;
            //$cmyk_cost 	= ($cmyk_cost_per_frame/$labels_per_frame)*$Labels;

            $second_labels = $Labels - $first_labels;

            $total_sqr_meter = $sqr_meter * $first_labels;

            $cmyk_cost_per_label = 0.28;
            $cmyk_cost = $cmyk_cost_per_label * $total_sqr_meter;

            //$print_cmyk_cost = $cmyk_cost+$labour+$machine_hr_rate;
            $print_cmyk_cost = $cmyk_cost + $labour;

            //$netsale  		 = $print_cmyk_cost/(100-$por)*100;
            $netsale = ($print_cmyk_cost * $margin) + $print_cmyk_cost;

            $netsale = number_format($netsale, 2, '.', '');

            $total_netsale2 = 0;

            if ($second_labels > 0) {
                $labels2 = $constants[1]['labels'];
                $labour2 = $constants[1]['labour_mac'];
                $margin2 = $constants[1]['margin'];

                $time2 = $constants[1]['time'];
                $por2 = $constants[1]['por'];

                $total_sqr_meter2 = $sqr_meter * $labels2;
                //echo $sqr_meter.' * '.$labels2.' = '.$total_sqr_meter2.'<br>';
                $cmyk_cost2 = $cmyk_cost_per_label * $total_sqr_meter2;

                //echo $cmyk_cost_per_label.' * '.$total_sqr_meter2.' = '.$cmyk_cost2.'<br>';

                $print_cmyk_cost2 = $cmyk_cost2 + $labour2;

                //echo $cmyk_cost2.' + '.$labour2.' = '.$print_cmyk_cost2.'<br>';

                $netsale2 = ($print_cmyk_cost2 * $margin2) + $print_cmyk_cost2;

                //echo '('.$print_cmyk_cost2.' * '.$margin2.')'.'+'.$print_cmyk_cost2.' = '.$netsale2.'<br>';

                $netsale2 = number_format($netsale2, 2, '.', '');

                $netsale2 = abs($netsale2 - $netsale);
                $tlabels = $labels2 - $first_labels;
                $total_netsale2 = $netsale2 / $tlabels;

                $total_netsale2 = $total_netsale2 * $second_labels;


            }


            //echo 'BBBBB ===== '.$first_labels.' ================ '.$netsale.' ----------------------------- '.$second_labels.' ============== '.$netsale2.' =========== '.$total_netsale2;
            $netsale = $netsale + $total_netsale2;

            $netsale = number_format(($netsale * 2), 2, '.', '');  //Double the price for 50% promotion


            //echo "AAAAAAAAAAAAA =============== ".$netsale;


            //$sqaure_meter = ($Labels*($width*$height)/1000000);
            $label_finish_total_all = 0;
            $label_finish2_total_all = 0;
            $total_finish2 = 0;
            if(is_array($finish)){
                foreach ($finish as $finish_and_emb_val){
                    $label_finish = 0;

                    $label_finish_embellishment_main_id = $this->get_db_column("label_finsh_and_emb_main", "id", "parsed_name", $finish_and_emb_val);
    //            $label_finish_embellishment_main_id = (int)$label_finish_embellishment_main_id;
                    $finish_and_emb_constants = $this->roll_pricing_const_label_emb($Labels,$label_finish_embellishment_main_id);
    //print_r($finish_and_emb_constants);die;

                    $finish_and_emb_labels1 = $finish_and_emb_constants[0]->labels;
                    $finish_and_emb_labour1 = $finish_and_emb_constants[0]->labour;
                    $finish_and_emb_cost1 = $finish_and_emb_constants[0]->finish_and_lamination_cost;
                    $finish_and_emb_time1 = $finish_and_emb_constants[0]->time;
                    $finish_and_emb_por1 = $finish_and_emb_constants[0]->por;


                    $second_labels_finish = $Labels - $finish_and_emb_labels1;

                    $total_sqr_meter_finish = $sqr_meter * $finish_and_emb_labels1;
    //             print_r($total_sqr_meter_finish);die;

                    //1.04
                    //echo $sqr_meter .' ================== '.$total_sqr_meter;
    //            echo '<br>111111 ==== '.$finish_and_emb_por2;die;

                    $label_finish_cost = ($finish_and_emb_cost1 * $total_sqr_meter_finish);
    //             print_r($label_finish_cost);die;

                    //echo '<br>2222 ==== '.$label_finish_cost;

                    //echo '<br>33333 ==== '.$time;

                    $finish_labour = $finish_and_emb_time1 * $finish_and_emb_labour1;
    //             print_r($finish_labour);die;

                    //echo '<br>44444 ==== '.$finish_labour;

                    $finish_cost = $label_finish_cost + $finish_labour;
    //             print_r($finish_cost);die;

                    //echo '<br>5555 ==== '.$finish_cost;

                    $tpor = (100 - $finish_and_emb_por1) / 100;
    //             print_r($tpor);die;

                    $label_finish = $finish_cost / $tpor;

                    $total_finish2 = 0;

                    //echo '<br>AAAAAAAA ==== '.$label_finish;

                    if ($second_labels_finish > 0) {
                        $finish_and_emb_labels2 = $finish_and_emb_constants[1]->labels;
                        $finish_and_emb_labour2 = $finish_and_emb_constants[1]->labour;
                        $finish_and_emb_cost2 = $finish_and_emb_constants[1]->finish_and_lamination_cost;
                        $finish_and_emb_time2 = $finish_and_emb_constants[1]->time;
                        $finish_and_emb_por2 = $finish_and_emb_constants[1]->por;

                        $total_sqr_meter2 = $sqr_meter * $finish_and_emb_labels2;
                        $label_finish_cost2 = $total_sqr_meter2 * $finish_and_emb_cost2;

                        // echo '<br>AAAAAAAAAA.1 == '.$label_finish_cost2;

                        $finish_labour2 = $finish_and_emb_time2 * $finish_and_emb_labour2;

                        // echo '<br>AAAAAAAAAA.2 == '.$finish_labour2;

                        $finish_cost2 = $label_finish_cost2 + $finish_labour2;

                        // echo '<br>AAAAAAAAAA.3 == '.$finish_cost2;

                        $tpor2 = (100 - $finish_and_emb_por2) / 100;

                        //echo '<br>AAAAAAAAAA.4 == '.$tpor2;

                        $label_finish2 = $finish_cost2 / $tpor2;

                        // echo '<br>AAAAAAAAAA.5 == '.$label_finish2;

                        $label_finish2 = abs($label_finish2 - $label_finish);

    //                 echo '<br>AAAAAAAAAA.6 == '.$label_finish2;
                        $tlabels_finish = $finish_and_emb_labels2 - $finish_and_emb_labels1;

                        $total_finish2 = $label_finish2 / $tlabels_finish;

                        // echo '<br>AAAAAAAAAA.7 == '.$label_finish2;

                        $total_finish2 = $total_finish2 * $second_labels_finish;

                        //echo '<br>AAAAAAAAAA.8 == '.$label_finish2;


                    }
                    //echo '<br>BBBBBBBBBBBBBB ==== '.$total_finish2;
                    $label_finish = $label_finish + $total_finish2;
                    $label_finish_total_all += $label_finish;
                    //echo '<br>CCCCCCCCCCCCCCCC ==== '.$label_finish;

                    //if($label_finish < 10){$label_finish = 10;}
                    //           echo"<pre>"; print_r( $finish_and_emb_constants);echo"<br>";

                }
            }
//        print_r($count);die;
//        if ($finish == 'Gloss Lamination') {
//            //1.04
//            //echo $sqr_meter .' ================== '.$total_sqr_meter;
//            //echo '<br>111111 ==== '.$total_sqr_meter;
//
//            $label_finish_cost = (0.225 * $total_sqr_meter);
//
//            //echo '<br>2222 ==== '.$label_finish_cost;
//
//            //echo '<br>33333 ==== '.$time;
//
//            $finish_labour = $time * 0.25;
//
//            //echo '<br>44444 ==== '.$finish_labour;
//
//            $finish_cost = $label_finish_cost + $finish_labour;
//
//            //echo '<br>5555 ==== '.$finish_cost;
//
//            $tpor = (100 - $por) / 100;
//
//            $label_finish = $finish_cost / $tpor;
//
//            $total_finish2 = 0;
//
//            //echo '<br>AAAAAAAA ==== '.$label_finish;
//
//            if ($second_labels > 0) {
//                $label_finish_cost2 = $total_sqr_meter2 * 0.225;
//
//                // echo '<br>AAAAAAAAAA.1 == '.$label_finish_cost2;
//
//                $finish_labour2 = $time2 * 0.25;
//
//                // echo '<br>AAAAAAAAAA.2 == '.$finish_labour2;
//
//                $finish_cost2 = $label_finish_cost2 + $finish_labour2;
//
//                // echo '<br>AAAAAAAAAA.3 == '.$finish_cost2;
//
//                $tpor2 = (100 - $por2) / 100;
//
//                //echo '<br>AAAAAAAAAA.4 == '.$tpor2;
//
//                $label_finish2 = $finish_cost2 / $tpor2;
//
//                // echo '<br>AAAAAAAAAA.5 == '.$label_finish2;
//
//                $label_finish2 = abs($label_finish2 - $label_finish);
//
//                // echo '<br>AAAAAAAAAA.6 == '.$label_finish2;
//
//                $total_finish2 = $label_finish2 / $tlabels;
//
//                // echo '<br>AAAAAAAAAA.7 == '.$label_finish2;
//
//                $total_finish2 = $total_finish2 * $second_labels;
//
//                //echo '<br>AAAAAAAAAA.8 == '.$label_finish2;
//
//
//            }
//            //echo '<br>BBBBBBBBBBBBBB ==== '.$total_finish2;
//            $label_finish = $label_finish + $total_finish2;
//            //echo '<br>CCCCCCCCCCCCCCCC ==== '.$label_finish;
//
//
//            //if($label_finish < 10){$label_finish = 10;}
//        } else if ($finish == 'Matt Lamination') {
//            //1.6
//            $label_finish_cost = (0.393 * $total_sqr_meter);
//
//            $finish_labour = $time * 0.25;
//
//            $finish_cost = $label_finish_cost + $finish_labour;
//
//            $tpor = (100 - $por) / 100;
//
//            $label_finish = $finish_cost / $tpor;
//            $total_finish2 = 0;
//
//            if ($second_labels > 0) {
//                $label_finish_cost2 = $total_sqr_meter2 * 0.393;
//
//                $finish_labour2 = $time2 * 0.25;
//
//                $finish_cost2 = $label_finish_cost2 + $finish_labour2;
//
//                $tpor2 = (100 - $por2) / 100;
//
//                $label_finish2 = $finish_cost2 / $tpor2;
//
//                $label_finish2 = abs($label_finish2 - $label_finish);
//
//                $total_finish2 = $label_finish2 / $tlabels;
//
//                $total_finish2 = $total_finish2 * $second_labels;
//
//
//            }
//
//            $label_finish = $label_finish + $total_finish2;
//
//            //if($label_finish < 10){$label_finish = 10;}
//        } else if ($finish == 'Matt Varnish' || $finish == 'Gloss Varnish' || $finish == 'High Gloss Varnish') {
//            //0.25
//            $label_finish_cost = (0.05 * $total_sqr_meter);
//
//
//            $finish_labour = $time * 0.25;
//
//            $finish_cost = $label_finish_cost + $finish_labour;
//
//            $tpor = (100 - $por) / 100;
//
//            $label_finish = $finish_cost / $tpor;
//            $total_finish2 = 0;
//
//            if ($second_labels > 0) {
//                $label_finish_cost2 = $total_sqr_meter2 * 0.05;
//
//                $finish_labour2 = $time2 * 0.25;
//
//                $finish_cost2 = $label_finish_cost2 + $finish_labour2;
//
//                $tpor2 = (100 - $por2) / 100;
//
//                $label_finish2 = $finish_cost2 / $tpor2;
//
//                $label_finish2 = abs($label_finish2 - $label_finish);
//
//                $total_finish2 = $label_finish2 / $tlabels;
//
//                $total_finish2 = $total_finish2 * $second_labels;
//
//
//            }
//insert_preferences
//
//            $label_finish = $label_finish + $total_finish2;
//            //if($label_finish < 10){$label_finish = 10;}
//        }

            //$label_finish = $this->check_price_uplift($label_finish);

            return array('price' => $netsale, 'label_finish' => $label_finish_total_all,'label_finish2_total_all',$total_finish2);
        }

    function min_labels_per_roll_printed($dieacross)
    {
        /*if($dieacross == 1 ){
                return 100;
            }
            else{
    */
        return 150;
        //}
    }


    function roll_pricing_const_label_emb($label, $label_finsh_and_emb_main_id)
    {
        $qurey =  $this->db->where('label_finsh_and_emb_main_id',$label_finsh_and_emb_main_id)->get('label_finsh_and_emb_const')->result();
//echo"<pre>";print_r($qurey);die;
//        $qurey = $this->db->query(" SELECT * FROM `print_roll_pricing_const` ORDER BY labels ASC ");
//        $result = $qurey->result();
        $result = $qurey;
        $matched_row = array();

        foreach ($result as $key => $row) {
            if ($label == $row->labels) {
                $matched_row[0] = $row;
                //echo '111111';
                break;
            } else if (($label > $row->labels and isset($result[$key + 1]->labels) and $label < $result[$key + 1]->labels)) {
                $matched_row[0] = $result[$key];
                $matched_row[1] = $result[$key + 1];
                //echo '22222';
                break;
            } else if (($label < $row->labels and isset($result[$key + 1]->labels) and $label < $result[$key + 1]->labels)) {
                $matched_row[0] = $row;
                //echo '33333';
                break;
            }
        }
        if (empty($matched_row)) {
            if ($label > $result[$key]->labels) {
                $matched_row[0] = $result[$key];
                $matched_row[1] = $result[$key + 1];
            } else {
                $matched_row[0] = $result[0];
            }
        }
        return $matched_row;
    }

    function label_embelishment_with_parent_title($parsed_title=NULL){

        if ($parsed_title) {
            $sql = "SELECT a.*,b.title AS parent_title
                FROM label_embellishment a, label_embellishment b
                WHERE a.label_emb_parent_id = b.id AND a.parsed_title = '".$parsed_title."' ";
        } else {
            $sql = "SELECT a.*,b.title AS parent_title
                FROM label_embellishment a, label_embellishment b
                WHERE a.label_emb_parent_id = b.id";
        }

        $result = $this->db->query($sql)->result();
        return  $result;    
    }

        /***************************************************/
        /***********LABEL EMBELLISHMENT TASK ENDS***********/
        /***************************************************/




}