<?php
class User_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	public function getCustomer($userId){
        $query = $this->db->query("SELECT * FROM customers WHERE UserID = $userId ");
        return $query->row();
    }
    function validate_login($user_email, $password){
		$query = $this->db->query("SELECT *,count(UserEmail) as total FROM customers WHERE UserEmail = '$user_email' AND UserPassword = '$password'");
		return $query->row_array();
	}
	function email_validate($val){
			$qry 	= $this->db->query("SELECT count(*) as total FROM  `customers` WHERE  `UserEmail` =  '".$val."'");
			$res 	= $qry->row_array();
			return  $res['total'];
			
	}
	
	function email_template($mailid)
	{
		$where = "mailid = $mailid";
        $qry = $this->db->query("SELECT * FROM ".Template_Table." WHERE ".$where."");
		return $qry->result_array();
	}

    public function countArtworkStatusFromQuotationIntegratedBYQuotationNumber($serial){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('quotation_attachments_integrated as at')
            ->where('QuotationNumber',$serial)
            ->get()->result();
    }
    public function getOrder($orderNumber){
        $results = $this->db->select("o.*")
            ->from('orders as o')
            ->join('dropshipstatusmanager as st', 'st.StatusID = o.OrderStatus','left')
            ->where('o.OrderNumber',$orderNumber)
            ->get()->result();
        return $results;
    }
    public function getOrderNum() {

        $sessionid = $this->session->userdata('session_id');
        $this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
        $order_num = $this->db->insert_id();
        return $order_num;

    }
    function get_mat_name_fr($text){
        $query = $this->db->query("SELECT label_name_fr from material_tooltip_info where material_code LIKE  '".$text."' ");
        $row = $query->row_array();
        return $row['label_name_fr'];
    }
    function fetch_custom_die_association($id){
        return $this->db->query("select * from flexible_dies_mat where OID = $id")->result();
    }

    function get_printing_service_name($process){

        if($process == 'Fullcolour'){
            $A4Printing = ' 4 Colour Digital Process ';
        }
        else if($process == 'Mono' || $process == 'Monochrome – Black Only'){
            $A4Printing = ' Monochrome &ndash; Black Only ';
        }else{


            $A4Printing = $process;
        }
        return $A4Printing;

    }
	function get_data(){

		$qry 	= $this->db->query("SELECT * FROM  `customers` WHERE  `UserID` =  '".$this->session->userdata('userid')."'");
		$res 	= $qry->row_array();
		return $res;
	}
	function get_user_orders_status_groupd(){
		
			$qry = $this->db->query("SELECT `StatusTitle`,count(OrderStatus) AS TOTAL FROM `orders` 
									  INNER JOIN dropshipstatusmanager ON orders.OrderStatus=dropshipstatusmanager.StatusID 
								 	 WHERE `UserID` =  '".$this->session->userdata('userid')."' AND (OrderStatus=7 OR OrderStatus=33 OR OrderStatus=6 OR OrderStatus=27) 
									 Group BY StatusTitle");
			$res 	= $qry->result();
			return $res;						
		
		
	}
    public function check_EuroID($PRODUCTID){

        $sql = $this->db->query("select EuroID from products where ProductID='".$PRODUCTID."'");
        $service = $sql->row_array();

        return $service['EuroID'];
    }
    function calculate_total_printed_labels($serial){

        $query = $this->db->query(" SELECT SUM(labels) AS total from quotation_attachments_integrated WHERE Serial LIKE '".$serial."'  ");
        $row = $query->row_array();
        return $row['total'];
    }
    public function getproductimg($id, $colorcode=NULL){

        $query = $this->db->select('Image1,ProductBrand,ManufactureID')
            ->where('ProductID',$id)
            ->get('products');
        $data = $query->row_array();

        if($id==0){
            $img = "High_Gloss_Permanent_Adhesive.png";
            return base_liveaa.'theme/images/images_products/material_images/'.$img;
        }
        else if(preg_match('/Application Labels/', $data['ProductBrand'])){

            $designcode = substr( $data['ManufactureID'], -4);
            return Assets."images/application/design/".$designcode.$colorcode.'.png';
        }
        else{
            //$data['Image1'] = trim(str_replace(".gif",".png",$data['Image1']));
            $data['Image1'] = str_replace(" ","",$data['Image1']);
            return base_liveaa.'theme/images/images_products/material_images/'.$data['Image1'];
        }



    }
    public function OrderInfo($orderID) {
        if(empty($orderID)){

            $orderID = end($this->uri->segments);

        }

        $query = $this->db->get_where('orders', array('OrderNumber' => $orderID));

        return $query->result();

    }
    function orderdetial_byserial_get($orderNumber){

        //600780 records 21
        //608566 6
        $qry 	= $this->db->query("SELECT * FROM  `orderdetails` WHERE  `SerialNumber` =  '".$orderNumber."'");
        $res 	= $qry->row_array();
        return $res;

    }
    public function getproductdetail($id){



        $query = $this->db->select('*')

            ->where('ProductID',$id)

            ->get('products');



        return $query->row_array();

    }

    function ReplaceHtmlToString_($text ){




        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return $string =  preg_replace(array_keys($utf8), array_values($utf8), $text);

    }
    function get_details_roll_quotation($id){
        $query = $this->db->query("SELECT * from roll_print_basket WHERE SerialNumber = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    public function getShipingServiceName($serviceID){

        $sql = $this->db->query("select * from shippingservices where ServiceID='".$serviceID."'");
        $service = $sql->row_array();

        return $service;
    }
    function calculate_total_printedroll_amount($quotenumber){
        return false;
        $query = $this->db->query(" SELECT SUM(quotationdetails.Price) AS total from products INNER JOIN quotationdetails ON 
									products.ProductID=quotationdetails.ProductID WHERE 
									QuotationNumber LIKE '".$quotenumber."'  AND quotationdetails.Printing LIKE 'Y' 
									AND  (ProductBrand LIKE 'Roll Labels')");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total']!=''){
            return ($row['total']*1.2) * 0.1;

        }else{
            return false;
        }
    }

    public function fetch_custom_die_quote($id){
    $query = $this->db->query("SELECT * from flexible_dies_info WHERE QID = '$id' ");
    $row = $query->row_array();
    return $row;
}
    function get_currecy_symbol($code){
        $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['symbol'];
    }
    public function manufactureid($domain,$id)
    {
        if($domain=='123'){$ManufactureID='123ManufactureID';}else{$ManufactureID='ManufactureID';}
        $this->db->select($ManufactureID);
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->$ManufactureID;
    }

    public function LabelsPerSheet($id){
        $this->db->select('LabelsPerSheet');
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->LabelsPerSheet;
    }
    public function getstatus($id) {

        $query = $this->db->get_where('dropshipstatusmanager', array('StatusID' => $id));
        return $query->result();
    }
	function pending_order_groupby(){
		$query = "SELECT Month( FROM_UNIXTIME(`OrderDate`) ) AS 'Month', count( OrderStatus ) AS total FROM orders
				  INNER JOIN dropshipstatusmanager ON orders.OrderStatus = dropshipstatusmanager.StatusID
				  WHERE Year( FROM_UNIXTIME(`OrderDate`) ) = 2014
				  AND OrderStatus =6 AND `UserID` =  '".$this->session->userdata('userid')."'
				  GROUP BY Month( FROM_UNIXTIME(`OrderDate`) )";
			$qry = $this->db->query($query);
		$res 	= $qry->result();
			return $res;
	}
    function show_product($pid){
        $qry = $this->db->query("SELECT * FROM products WHERE ProductID  = ".$pid."");
        return $qry->row_array();
    }
	function completed_order_groupby(){
			$query = "SELECT Month( FROM_UNIXTIME(`OrderDate`) ) AS 'Month', count( OrderStatus ) AS total FROM orders
				      INNER JOIN dropshipstatusmanager ON orders.OrderStatus = dropshipstatusmanager.StatusID
				      WHERE Year( FROM_UNIXTIME(`OrderDate`) ) = 2014
				      AND OrderStatus =7 AND `UserID` =  '".$this->session->userdata('userid')."'
				      GROUP BY Month( FROM_UNIXTIME(`OrderDate`) )";
			
			
			$qry = $this->db->query($query);
			$res 	= $qry->result();
			return $res;
	}
    function make_productBrand_condtion($type){

        if(preg_match("/SRA3/i",$type)){
            $brand = 'SRA3';
        }else if(preg_match("/A3/i",$type)){
            $brand = 'A3';
        }else if(preg_match("/Roll/i",$type)){
            $brand = 'Rolls';
        }else if(preg_match("/Integrated/i",$type)){
            $brand = 'Integrated';
        }else{
            $brand = 'A4';
        }
        return $brand;
    }
    public function fetch_product_name($data){

        $this->lang->load('genral_lang');

        $type = $this->make_productBrand_condtion($data['ProductBrand']);
        if($type=="Rolls"){
            $data['ProductName'] = $this->gerroll_pro_name_fr($data['ProductID']);
            $pname = explode('-',$data['ProductName']);
            $prodname = $this->get_translated_version(trim($pname[0]));
            $pdetails = explode(" - ", $data['ProductCategoryName']);
            $LabelSize = str_replace("label size ","",$pdetails[1]);

            $catname = $this->lang->line('placeholder_roll_labels').' - '.$this->lang->line('placeholder_labelsize').' '.$LabelSize;
            $catname = str_replace("mm Circle",$this->lang->line('labelfilter_option_circular'), $catname);
            $Adhesive = $this->lang->line('labels_material_adhesive');
            $completeName = $prodname.' '.$this->get_translated_version($data['Adhesive']).' '.$Adhesive.' '.$catname;
        }else{
            $completeName = $this->get_translated_long_desciption($data['ProductCategoryName'], $type);
        }
        $data['ProductCategoryName'] = $completeName;
        $completeName = $this->customize_product_name_fr($data);

        return $completeName;
    }

    function get_db_column($table, $column, $key, $value){
        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '".$value."' LIMIT 1 ")->row_array();
        return (isset($row[$column]) and $row[$column]!='')?$row[$column]:'';
    }
    public function customize_product_name_fr($data){
        $custom = $data['is_custom'];
        $ProductCategoryName = $data['ProductCategoryName'];
        $LabelsPerRoll = $data['LabelsPerRoll'];
        $LabelsPerSheet = $data['LabelsPerSheet'];
        $ReOrderCode = $data['ReOrderCode'];
        $manuid = $data['ManufactureID'];
        $ProductBrand= $data['ProductBrand'];
        $wound=$data['Wound'];
        $data['Source'] = $data['Printing'];
        // $printed= $data['OrderData'];
        $printed ='';



        if($wound=='Y'){ $wound_opt = $this->lang->line('placeholder_inside_wound');}else{ $wound_opt = $this->lang->line('placeholder_outside_wound');}

        if(isset($data['Source']) and $data['Source'] == 'Y' and preg_match('/Roll Labels/is',$ProductBrand)){

            $labeltype  = $this->get_db_column('digital_printing_process', 'name_fr', 'name', $data['Print_Type']);
            $productname  = explode("-",$ProductCategoryName);
            $productname[1] = str_replace("(","",$productname[1]);
            $productname[1] = str_replace(")","",$productname[1]);
            $productname[0] = str_replace("rolls labels","",$productname[0]);
            $productname[0] = str_replace("roll labels","",$productname[0]);
            $productname[0] = str_replace("Roll Labels","",$productname[0]);
            $productname = "Étiquettes imprimées sur rouleaux - ".str_replace("roll label","",$productname[0]).' - '.$productname[1];
            $completeName = ucfirst($productname).' '.$wound_opt.' - Orientation '.$data['Orintation'].', ';

            if($data['FinishType'] == "Gloss Lamination")
            {
                $finish_type_fr = 'Lamination Gloss';
            }
            else if($data['FinishType'] == "Matt Lamination")
            {
                $finish_type_fr = 'Matt Lamination';
            }
            else if($data['FinishType'] =="Matt Varnish")
            {
                $finish_type_fr = 'Vernis mat';
            }
            else if($data['FinishType'] == "Gloss Varnish")
            {
                $finish_type_fr = 'Vernis brillant';
            } else if($data['FinishType'] == "High Gloss Varnish")
            {
                $finish_type_fr = 'Vernis a haute brillance';

            }else if($data['FinishType'] == "High Gloss Varnish")
            {
                $finish_type_fr = 'Vernis a haute brillance';
            }
            else
            {
                $finish_type_fr == 'No Finish';
            }

            if($data['FinishType'] == 'No Finish'){ $labelsfinish = ' Finition de l\'étiquette: aucune ';}
            else{ $labelsfinish = ' Finition de l\'étiquette : '.$finish_type_fr; }
            $completeName .=$labeltype.' '.$labelsfinish;

            return $completeName;

        }
        if($custom=='Yes'){
            $productname  = explode("-",$ProductCategoryName);
            $completeName =  $productname[0].$LabelsPerRoll." ".$this->lang->line('placeholder_labels_per_roll').", ".$wound_opt." - ".$productname[1];
            $diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerRoll);
            $completeName = $completeName." ".$this->lang->line('placeholder_roll_diamter').' '.$diamter;

        }else{
            if(preg_match('/Roll Labels/is',$ProductBrand)){
                $productname  = explode("-",$ProductCategoryName);

                $completeName = $productname[0].$LabelsPerSheet." ".$this->lang->line('placeholder_labels_per_roll').", ".$wound_opt." - ".$productname[1];
                $diamter =  $this->orderModel->calculate_rolls_diamter($manuid,$LabelsPerSheet);
                $completeName = $completeName." ".$this->lang->line('placeholder_roll_diamter').' '.$diamter;


            }else{
                $completeName = $ProductCategoryName;
                if(substr($manuid,-2,2)=='XS'){
                    $completeName =  $completeName.", Conception: ".$printed;
                }
                /**********WPEP Voucher Offer*************/
                if(preg_match("/A4/i",$ProductBrand) and (preg_match("/WPEP/i",$manuid))){
                    //$completeName =  $completeName." <span style='color:#fd4913;'>( 20% discount) </span>";
                }
                /**********WPEP Voucher Offer*************/
            }
        }
        if($ReOrderCode){ $completeName = $completeName." Réorganiser le code ".$ReOrderCode; }



        /******************Sample Order implementation***********************/
        if($printed=='Sample'){ $completeName = $completeName." - Échantillon ";}
        /******************Sample Order implementation***********************/

        return $completeName;

    }
    function calculate_rolls_diamter($manufature=NULL,$label=NULL){



        $query = $this->db->query("SELECT LabelGapAcross,Height FROM products 

			INNER JOIN category ON SUBSTRING_INDEX( products.CategoryID, 'R', 1 ) = category.CategoryID   WHERE ManufactureID like '".$manufature."' LIMIT 1");

        $row = $query->row_array();

        $gap =  $row['LabelGapAcross'];

        $size = $row['Height'];

        return $this->get_auto_diameter($manufature,$label,$gap,$size).' mm';



    }
    function get_auto_diameter($manufature,$labels,$gap,$size){



        $rolldiamter = 0;

        $coreid = substr($manufature,-1);

        $coreid = 'R'.$coreid;

        $gap = round(trim(str_replace("mm","",$gap)));

        $code =  $this->getmaterialcode(substr($manufature,0,-1));

        $size = $size+$gap;

        $labels_p_mtr = round(($size/1000)*$labels,2);



        $diammeter = $this->get_diameter_against_meter($code,$coreid,$labels_p_mtr);

        $rolldiamter = floor(($diammeter*0.03)+$diammeter);

        if($rolldiamter > 3){ $rolldiamter = $rolldiamter-3;}

        return $rolldiamter;



    }
    function get_diameter_against_meter($code=NULL,$coreid=NULL,$meter=NULL){



        $qurey = $this->db->query("SELECT mtr,mesure FROM `roll_diameter` Where code LIKE '".$code."' AND core LIKE '".$coreid."'  ORDER BY `roll_diameter`.`mesure` ASC");

        $result = $qurey->result();

        foreach($result as $key => $row){

            if($meter == $row->mtr){

                return  $row->mesure;

            }

            else if(($meter > $row->mtr and isset($result[$key+1]->mtr) and $meter < $result[$key+1]->mtr)){

                return  $result[$key+1]->mesure;

            }

        }

    }

    function get_translated_long_desciption($value,$type){
        if($type == 'Rolls'){
            return $value;
        }
        else if($type == 'Integrated'){
            $name = explode("-",$value);
            $adhesivetype =  explode(" ", trim($name[1]));
            $shapesize =  explode(" ", trim($name[2]));
            $material =  $this->get_translated_version($name[0]);
            $adhesive = strtolower($this->get_translated_version($adhesivetype[0]));
            $Labels =  $shapesize[0];

            $Shape =  $this->get_translated_version($adhesivetype[1].' '.$adhesivetype[2]);

            $labelSize =  $name[3];

            if($Labels > 1){ $étiquette = 'Étiquettes';}
            else {$étiquette = 'Étiquette';}
            return $étiquette.' '.strtolower($Shape).' - ' .$material.' -  '.$adhesive.'  - '.$Labels.' '.$étiquette.' par feuille A4 - '.$labelSize;
        }else{
            $name = explode("-",$value);
            $adhesivetype =  explode(" ", trim($name[1]));
            $shapesize =  explode(" ", trim($name[2]));

            $material =  $this->get_translated_version($name[0]);

            $adhesive = $this->get_translated_version($adhesivetype[0]);


            $Labels =  $shapesize[0];
            $Shape =  $this->get_translated_version($shapesize[1]);

            $labelSize =  $name[3];

            if($Labels > 1){ $étiquette = 'étiquettes';}
            else {$étiquette = 'étiquette';}

            return $material.' - '.$adhesive.' '.$Labels.' '.$étiquette.'  '.strtolower($Shape) .' par feuille '.$type.' - '.$labelSize;
        }
    }
    function get_translated_version($value){
        $translated_option = trim(strtolower(str_replace("-","_",$value)));
        $translated_option = trim(strtolower(str_replace("/","_",$translated_option)));
        $translated_option = trim(strtolower(str_replace(" - ","_",$translated_option)));
        $translated_option = trim(strtolower(str_replace(" ","_",$translated_option)));
        $translated_text = $this->lang->line('labelfilter_option_'.$translated_option);

        if(isset($translated_text) and $translated_text!=''){
            $value = $translated_text;
        }
        return $value;
    }
    public function gerroll_pro_name_fr($proid){
        $row = $this->db->query("select ProductName from products where ProductID = $proid")->row_array();
        return $row['ProductName'];

    }
	
	function get_total_order_record(){
		$qry= $this->db->query("SELECT SUM(OrderTotal) AS OrderTotal,Count(*) AS NumberOfOrders  FROM  `orders` WHERE Domain NOT LIKE '123' 
		AND `UserID` =  '".$this->session->userdata('userid')."'");
		$res 	= $qry->row_array();
		return $res;
	}
	
	function validate_userpass($password){
		$query = $this->db->query("SELECT * FROM customers WHERE UserID = '".$this->session->userdata('userid')."' AND UserPassword = '$password'");
		if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function update_user_pass($pass){
			
				$userid = $this->session->userdata('userid');
				$data = array('UserPassword' => $pass);
				$don = $this->db->update('customers', $data, array('UserID' => $userid)); 
				return  "Your password has been successfully updated...!";
				
	}
	
	function user_orders($filter = '', $sort=''){
		
		//echo "filter: ".$filter."<br>";
		//echo "sort: ".$sort."<br>";
		//exit;
		
		$userid =  $this->session->userdata('userid');
		$where = " orders.`UserID` =  '".$userid."' AND Domain NOT LIKE '123'";
		$q_sort = " ORDER BY`orders`.`OrderID` DESC";
		
		$like = '';
		$query = '';

		if($filter != '')
		{
			if($filter == "roll")
			{
				$and = " orderdetails.`ProductName` LIKE '%Roll%'";
			}
			else if($filter == "a4")
			{
				$and = " orderdetails.`ManufactureID` LIKE 'AA%' AND orderdetails.`ProductName` NOT LIKE '%integrated%'";
			}
			else if($filter == "a3")
			{
				$and = " orderdetails.`ManufactureID` LIKE 'A3%' AND orderdetails.`ProductName` LIKE '%A3%'";
			}
			else if($filter == "sra3")
			{
				$and = " orderdetails.`ManufactureID` LIKE 'SR%' AND orderdetails.`ProductName` LIKE '%SRA3%'";
			}
			else if($filter == "integrated")
			{
				$and = " orderdetails.`ManufactureID` LIKE 'AAIL%' AND orderdetails.`ProductName` LIKE '%integrated%'";
			}
			else if($filter == "printed")
			{
				//$like = " AND orderdetails.`Printing` = 'Y'";
				$and = " orderdetails.`Printing` = 'Y'";
			}
			else if($filter == "plain")
			{
				//$like = " AND orderdetails.`Printing` != 'Y'";
				$and = " orderdetails.`Printing` != 'Y'";
			}
			
			
			$like = "AND (SELECT COUNT(*) FROM orderdetails WHERE orders.orderNumber = orderdetails.orderNumber AND ".$and.") > 0";
						
			if($sort == "date_asc")
			{
				$q_sort = " ORDER BY`orders`.`OrderDate` ASC";				
			}
			else if($sort == "date_desc")
			{
				$q_sort = " ORDER BY`orders`.`OrderDate` DESC";				
			}
			
			$query = "Select * from orders INNER JOIN dropshipstatusmanager ON orders.OrderStatus = dropshipstatusmanager.StatusID WHERE ".$where.$like.$q_sort;
		}
		else
		{
			if($sort == "date_asc")
			{
				$q_sort = "ORDER BY`orders`.`OrderDate` ASC";				
			}
			else if($sort == "date_desc")
			{
				$q_sort = "ORDER BY`orders`.`OrderDate` DESC";				
			}

			$query = "Select * from orders INNER JOIN dropshipstatusmanager ON  orders.OrderStatus = dropshipstatusmanager.StatusID WHERE ".$where.$q_sort;
		}
		//echo($query);exit;
		return $query;
	}
	
	function user_orders_old(){
		
		$userid =  $this->session->userdata('userid');
		$where = " orders.`UserID` =  '".$userid."' AND Domain NOT LIKE '123'";
		$query = "Select * from orders INNER JOIN dropshipstatusmanager ON  orders.OrderStatus = dropshipstatusmanager.StatusID
								    WHERE ".$where." ORDER BY`orders`.`OrderID` DESC";
		/*$query = $this->db->query("Select * from orders INNER JOIN dropshipstatusmanager ON  orders.OrderStatus = dropshipstatusmanager.StatusID
								    WHERE ".$where." ORDER BY`orders`.`OrderID` DESC limit 5");
		$res 	= $query->result();*/
		return $query;
	}
	function isProductActive($productId){
		 	$query = $this->db->query("SELECT Count(*) as Record FROM `products` Where ManufactureID='".$productId."' AND `Activate` LIKE 'Y'");	
			$result = $query->row_array();
			return $result['Record'];
			
	}
	
	
	function get_Menu_ID($prdID){
		$query = $this->db->query("SELECT ManufactureID from products WHERE  ProductID ='".$prdID."'");
		$record = $query->result_array();
		return $record[0]['ManufactureID']; 
	}
	function get_order_product_record($orderNumber){
		$qry 	= $this->db->query("SELECT * FROM  `orderdetails` WHERE  `OrderNumber` =  '".$orderNumber."' AND ProductID !=0");
		$res 	= $qry->result();
		return $res;
	
	}
	function create_entry($data, $data_temp){
		
		$str = $this->db->insert_string('customers', $data);
		$query = $this->db->query($str);
		if($query){
				
			$act_code = md5(rand(0,1000).'uniquefrasehere');
			$temp = $this->db->query("SELECT * FROM customers WHERE UserEmail = '".$data_temp['email']."'");
			$res = $temp->result_array();
			$activate['UserID'] 				= $res[0]['UserID'];
			$activate['account_token_number'] 	= $act_code;
			$activate['account_token_email'] 	= $data_temp['email'];
			$activate['reg_time'] 				= time();
			
			$str_tmp = $this->db->insert_string('account_activation', $activate);
			$query_tmp = $this->db->query($str_tmp);
			if($query_tmp){
					
					$mail_template = $this->email_template(103);
					$mailTitle = $mail_template[0]['MailTitle'];
					$mailName = $mail_template[0]['Name'];
					$from_mail = $mail_template[0]['MailFrom'];
					$mailSubject = $mail_template[0]['MailSubject'];
					$mailText = $mail_template[0]['MailBody'];
					
					
					$getfile = FCPATH.'system/libraries/en/account-setup.html';
					$mailText = file_get_contents($getfile);
					
					$url = base_url('theme').'/';
					$code = base64_encode($res[0]['UserID']);
					$link = base_url().'users/act/'.$act_code.'-'.$code;
					
			    	$strINTemplate   = array('[WEBROOT]', "[UserName]", "[link]","[email]","[date]","[time]");    
					$strInDB  = array($url,$res[0]['BillingFirstName'],$link,$data_temp['email'],date("d/m/Y"),date("g:i A"));  
					$newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
					
					$this->load->library('email');
					$this->email->from('support@aalabels.com', 'AALABELS');
					$this->email->to($data_temp['email']); 
				//	$this->email->bcc('kami.ramzan77@gmail.com');
					$this->email->subject($mailSubject);
					$this->email->message($newPhrase);
					$this->email->set_mailtype("html");
					$this->email->send();
						
			}
		}
		
		$msg = "An Activation Email has been sent to your email address. Please follow the instructions in this email to continue."; 
		$msg .= "If you have not received this email please call us on 01733 588 390, Please also check your Junk Mail folder.";
		return $msg;			
						
		
	}
	
	function get_product_details($prdID){
		$query = $this->db->query("SELECT ProductBrand,ManufactureID,LabelsPerSheet,Image1 from products WHERE  ProductID ='".$prdID."'");
		//$query = $this->db->query("SELECT * from products WHERE  ProductID ='".$prdID."'");
		return $query->row_array();
		
	}
	   public function UpdateDB($tblName, $customer_array,$userid){
		
		$this->db->where('UserId',$userid);
		$res = $this->db->update($tblName, $customer_array);
		return $res;
	}
	
	
	
	
	function activate_account($activation){
		$result = explode('-',$activation);
		$act_code 	= $result[0];
		$userid 	= base64_decode($result[1]);
	
		$qry = $this->db->query("SELECT * FROM account_activation WHERE UserID = ".$userid." AND  account_token_number ='".$act_code."'");
		if($qry->num_rows()>0)
		{
			$data = array( 'Active' => 1 );
			$don = $this->db->update('customers', $data, array('UserID' => $userid)); 
			if($don){
				
				$del = $this->db->delete('account_activation', array('UserID' => $userid)); 
				$temp = $this->db->query("SELECT * FROM customers WHERE UserID = ".$userid."");
				$res = $temp->result_array();
							
				$mail_template = $this->email_template(1);
				$mailTitle = $mail_template[0]['MailTitle'];
				$mailName = $mail_template[0]['Name'];
				$from_mail = $mail_template[0]['MailFrom'];
				$mailSubject = $mail_template[0]['MailSubject'];
				$mailText = $mail_template[0]['MailBody'];
				
				
				$getfile = FCPATH.'system/libraries/en/register.html';
				$mailText = file_get_contents($getfile);
				
				$url = base_url('theme').'/';
				$strINTemplate   = array('[WEBROOT]', "[UserName]", "[EmailAddress]","[date]","[time]");    
				$strInDB  = array($url,$res[0]['BillingFirstName'],$res[0]['UserEmail'],date("d/m/Y"),date("g:i A") );  
				$newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
				
				
				$this->load->library('email');
				$this->email->from('customercare@aalabels.com', 'AALABELS');
				$this->email->to($res[0]['UserEmail']); 
			//	$this->email->bcc('kami.ramzan77@gmail.com');
				$this->email->subject($mailSubject);
				$this->email->message($newPhrase);
				$this->email->set_mailtype("html");
				
				if($this->email->send())
				{
					$data['class']= 'success';
					$data['msg'] = '<i class="fa fa-check-circle fa-lg"></i> Your account is successfully activated. If you have any query, please call us on 01733 588 390;';		
				}
			}
			else{
					$data['class']= 'danger';
					$data['msg'] = '<i class="fa fa-times-circle fa-lg"></i> You have already activated of your account or your activation period is expired.!';
			}

		}
		else
		{
			$data['class']= 'danger';
			$data['msg'] = '<i class="fa fa-times-circle fa-lg"></i> You have already activated of your account or your activation period is expired.!';
	  }
		
		return $data;
		
	}
	
	
	function forgotpassword($email){
		
		$msg = "We have not find your email address in our record. Please check your email spelling if not then kindly register with us";
		$class='danger';
		$qry = $this->db->query("SELECT * FROM customers WHERE UserEmail = '".$email."'");
		$rec = $qry->num_rows();
		if($rec!=0)
		{
			$res = $qry->result_array();
			$act_code = md5(rand(0,1000).'uniquefrasehere');
			
			$activate['UserID'] 				= $res[0]['UserID'];
			$username 				= $res[0]['BillingFirstName'];
			$activate['TokenNumber'] 			= $act_code;
			$activate['UserEmail'] 				= $email;
			$activate['TokenTime'] 				= time();
		
		  $str_tmp = $this->db->insert_string('forgetpasswordtoken', $activate);
		  $query_tmp = $this->db->query($str_tmp);
			
			if($query_tmp)
			{
				$mail_template = $this->email_template(2);
				$mailTitle = $mail_template[0]['MailTitle'];
				$mailName = $mail_template[0]['Name'];
				$from_mail = $mail_template[0]['MailFrom'];
				$mailSubject = $mail_template[0]['MailSubject'];
				$mailText = $mail_template[0]['MailBody'];
				$url = base_url('theme').'/';
				$code = base64_encode($res[0]['UserID']);
				$link = base_url().'users/changepassword?token='.$act_code.'-'.$code;
				
				
				$getfile = FCPATH.'system/libraries/en/forgot-password.html';
				$mailText = file_get_contents($getfile);
				$strINTemplate   = array('[WEBROOT]', "[EmailAddress]", "[password]", "[BillingFirstName]");    
				$strInDB  = array($url,$email,$link,$username);  
				$newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
				
			
				
				$this->load->library('email');
				$this->email->from($from_mail, 'AALABELS');
				$this->email->to($email); 
			//	$this->email->bcc('kami.ramzan77@gmail.com');
				$this->email->subject($mailSubject);
				$this->email->message($newPhrase);
				$this->email->set_mailtype("html");
				$this->email->send();
			        $msg = "A link has been sent to your email address.
							Please follow the instructions in this email to continue. <br>
							If you have not received this email please call us on 01733 588 390,
							Please also check your Junk Mail folder.";
							$class='success';
			 }
		}
		return array('class'=>$class,'msg'=>$msg);
	}
	
		
	function checkforgot($token, $id)
	{
		$qry = $this->db->query("SELECT * FROM forgetpasswordtoken WHERE TokenNumber = '".$token."' AND UserID = $id");
		$num_row = $qry->num_rows();
		if($num_row!=0)
		{
			$del = $this->db->delete('forgetpasswordtoken', array('TokenNumber' => $token, 'UserID' => $id)); 
			return true;
		}
		else
		{
			return false;
		}
	}	
	
	
	
	public function getMax()
	{
		$q=$this->db->query("SELECT MAX(id) as id FROM customlabelsnumber");
		$result=$q->result();
		$maxNumber=$result[0]->id+1;
		$maxNumber="E".$maxNumber;																
		$q=$this->db->query("insert into  customlabelsnumber set customLabelsNumber='".$maxNumber."'");
		return $maxNumber;
	}
	public function quote_fill($customer_array){
	    $str = $this->db->insert_string('contactus', $customer_array);
		$query = $this->db->query($str);
		return $query;	
		
	}
	
	function user_projects(){
		
		$userid =  $this->session->userdata('userid');
		$query = "Select * from flash_user_design  WHERE UserID = '$userid' and status = 'Y' and Type = 'LD' ORDER BY ID";
		return $query;
	}
	
	/***************** NEW FUNCTION 
	*******************************************/
	
	function get_order_product_record_by_serial($serial){
		$qry 	= $this->db->query("SELECT * FROM  `orderdetails` WHERE  `SerialNumber` =  '".$serial."'");
		$res 	= $qry->result();
		return $res;
	
	}
	 function get_sum_of_designed_artworks($orderNum, $ProductID)
	{
		$q = $this->db->query("select SUM(labels) AS labels from order_attachments_integrated WHERE ProductID = '".$ProductID."' AND OrderNumber = '".$orderNum."' ORDER BY ID ASC");
		
		$sql = $q->row_array();
		return $sql;
	}
	
	
	function card_already_registered($number){
	  	$userid = $this->session->userdata('userid');
	  	$query = $this->db->query(" Select count(*) as total from saved_wp_tokens WHERE userid=$userid AND maskedCardNumber LIKE '".$number."' ");
		$row = $query->row_array();
		if(isset($row['total']) and $row['total'] > 0){ return true;}
		else{ return false;}
	}
	
	function get_user_saved_cards(){
		  	$userid = $this->session->userdata('userid');
		  	$result = $this->db->query(" Select * from saved_wp_tokens WHERE userid=$userid ")->result();
			return $result;
	}


	public function getCartData($cartId){
        $record = $this->db->query("SELECT * FROM flexible_dies_info where CartID = $cartId")->result();
        return $record;
    }
    public function getCartQuotationData($qid){
        $record = $this->db->query("SELECT * FROM flexible_dies_info where QID = $qid")->result();
        return $record;
    }
	
	 public function getCartOrderData($qid){
        $record = $this->db->query("SELECT * FROM flexible_dies_info where OID = $qid")->result();
        return $record;
    }


    public function getMaterialCode(){
        $this->load->model('cart/cartModal');
        if($this->input->get('format') == 'Roll'){
            $materials = $this->cartModal->getRollMaterialCode();
        }else{
            $materials = $this->cartModal->getSheetMaterialCode($this->input->get('format'));
        }

       return $materials;
    }


    public function getCartMaterial($flexDieId){
						if($flexDieId){
							$qry = $this->db->query("select *  FROM flexible_dies_mat where  OID = $flexDieId ");
							return $qry->result();
						}else{
							return array();
						}
            
    }
    public function fetch_custom_die_info($id){
        $query = $this->db->query("SELECT * from flexible_dies_info WHERE ID = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    function get_mat_name($text){
        $query = $this->db->query("SELECT label_name from material_tooltip_info where material_code LIKE  '".$text."' ");
        $row = $query->row_array();
        return $row['label_name'];
    }

    function get_exchange_rate($code){

        $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['rate'];
    }
    public function custom_material_list(){
        $query = $this->db->query("select Code as material from material_prices order  by Code asc");
        return $query->result();
    }

    function getmaterial_list($type){
        $field = 'flexible_price_'.$type;
        $table = ($type=="A3" || $type=="SRA3" || $type=="A5")?$field:'flexible_price';
        return $this->db->query("select material from $table")->result();
    }
    public function getColorName($id){

        $this->db->select('colorDescription');
        $this->db->from('color');
        $this->db->where('id =',$id);


        $query = $this->db->get();
        $data = $query->row_array();


        return $data['colorDescription'];
    }
    public function getImages($QuoteNumber)
    {
        $this->db->select('*');
        $this->db->from('customlabelsfiles');
        $this->db->where('QuoteNumber =',$QuoteNumber);

        $query = $this->db->get();

        return $query->result();
    }
    public function getcolors(){

        $query = $this->db->select('*')
            ->order_by('id' ,'asc')
            ->get('color');

        return $query->result();
//        foreach($data as $row)
//            $color[ $row->id ]= $row->colorDescription;
//
//        return $color;
    }
    
   public function getMaterialCodeParam($types){
        $this->load->model('cart/cartModal');
		
        if($types == 'Roll'){
            $materials = $this->cartModal->getRollMaterialCode();
        }else{
            $materials = $this->cartModal->getSheetMaterialCode($types);
        }
       return $materials;
    }
    
}

