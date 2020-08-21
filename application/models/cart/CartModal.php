<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cartModal extends CI_Model
{
    public function getCarTotalPrice(){
        $cookie = @$_COOKIE['ci_session'];
		$cookie = stripslashes($cookie);
		$cookie = @unserialize($cookie);
		$cisess_session_id = $cookie['session_id'];  
        $session_id = $this->session->userdata('session_id');

        $qry = $this->db->query("SELECT sum(TotalPrice+Print_Total) as price FROM temporaryshoppingbasket  WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");
        $res  = $qry->result();
        return  $res;
    }

    public function deleteLineFromCart($carId){


        $this->db->where('ID', $carId);
        $this->db->delete('temporaryshoppingbasket');


        $this->db->where('CartID', $carId);
        $this->db->delete('integrated_attachments');
		
		$this->home_model->save_logs('delete_cart',array('cartid'=>$carId));  //SAVE LOG

        return true;


    }

    public function deleteLineFromMaterial($cardId){
        $this->db->where('ID', $cardId);
        $this->db->delete('flexible_dies_mat');

        return true;
    }

    public function getTotalLabelsFromCart($cartId){
        $qry = $this->db->query("SELECT Quantity ,LabelsPerRoll ,(Quantity * LabelsPerRoll) as labels FROM temporaryshoppingbasket  WHERE ID = $cartId ");
        $res  = $qry->result();
        return  $res;
    }

    public function deleteLineArtworks($carId){


        $this->db->where('CartID', $carId);
        $this->db->delete('integrated_attachments');

        return true;


    }

    function getProductManufactureId($productId){
        $query=$this->db->query("select  ManufactureID from products  where ProductID='".$productId."'");
        return $query->row_array();
    }


    public function getProductCalculation($productId,$manfactureId){
        return  array(
            'minRoll'=>$this->home_model->min_qty_roll($manfactureId),
            'minLabels'=>$this->home_model->min_qty_labels($manfactureId),
            'maxRoll'=>$this->home_model->max_qty_roll($manfactureId),
            'maxLabels'=>$this->home_model->max_qty_labels($manfactureId),
            'labelPerSheet'=>$this->product_model->getProductById($productId)['LabelsPerSheet']
        );
    }
/*HERE*/
    public function insertIntoCart(){
        $params = array('SessionID'=>$this->session->userdata('session_id'),'UserID'=>$this->session->userdata('customer_id'),'ProductID'=>0,'p_code'=>'SCO1','p_name'=>'Set-up charge'
        ,'OrderTime'=>date('Y-m-d h:m:i'),'Quantity'=>'1','orignalQty'=>'0','LabelsPerRoll'=>'0','OrderData'=>date('Y-m-d'),'UnitPrice'=>'0.00','TotalPrice'=>'0.00','is_custom'=>'No');
        $this->db->insert('temporaryshoppingbasket',$params);
        return $this->db->insert_id();
    }

    public function getCartOrders(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');

        $qry = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID  WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");
        $res  = $qry->result();
        //print_r($res); exit;
        return $res;
    }

    public function getLatestCartOrders(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
        $qry = $this->db->query("SELECT tsb.*,prd.ProductBrand,prd.ManufactureID FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID  WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");
        $res  = $qry->result_array();
        return $res;
    }


    public function getAllProducts(){
        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');

        return  $this->db->select("temp.*,p.Image1,p.ProductCategoryName,p.ManufactureID,p.ProductBrand,p.ProductID,p.ProductName")
                ->select("(SELECT sum(TotalPrice) + sum(Print_Total)  FROM temporaryshoppingbasket  WHERE SessionID = '$session_id') as total")
                ->from('temporaryshoppingbasket as temp')
                ->join('products as p', 'temp.ProductID = p.ProductID','left')
                ->where('temp.SessionID',$session_id)
                ->or_where('temp.SessionID',$cisess_session_id)
                ->get()->result();
        }

        public function updateCart($cartId,$coloum){
            $this->db->where('ID', $cartId);
            $this->db->update('temporaryshoppingbasket', $coloum);
            return true;
        }

        public function digitalPrintingProcess(){
            return  $this->db->select("*")
                ->from('digital_printing_process')
                ->get()->result();
        }

        public function updateFlexDieRecord($params){

            $this->db->where('CartID', $params['CartID']);
            $this->db->update('flexible_dies_info', $params);
            return true;
        }

    public function updateFlexDieRecordForQuotation($params){

        $this->db->where('QID', $params['QID']);
        $this->db->update('flexible_dies_info', $params);
        return true;
    }

        public function insertFlexDieRecord($parmas){
           $this->db->insert('flexible_dies_info',$parmas);
           $id = $this->db->insert_id();
           
           $this->db->where('ID',$id);
           $this->db->update('flexible_dies_info', array('tempcode'=>'temp'.$id));
        }

        public function checkIfExist($cartId){
            if(filter_var($this->input->get('pageName'), FILTER_SANITIZE_STRING )  == 'quotation'){
                $value = filter_var($this->input->get('QID'), FILTER_VALIDATE_INT) ;
                $coloum = 'QID';
            }else{
                $value =$cartId;
                $coloum = 'CartID';
            }
            $qry = $this->db->query("select count(*) as total FROM flexible_dies_info where  $coloum = $value ");
            return $qry->result();
        }

    public function getCustomDieRecord($cartId){
        $qry = $this->db->query("select *  FROM flexible_dies_info where  CartID = $cartId ");
        return $qry->row();
    }
    public function getCustomDieRecordForQuotation($cartId){
        $qry = $this->db->query("select *  FROM flexible_dies_info where  QID = $cartId ");
        return $qry->row();
    }
    public function getRollMaterialCode(){
        $query = $this->db->query("select Code as material from material_prices order  by Code asc");
        return $query->result();
    }

    function getSheetMaterialCode($type){
        $field = 'flexible_price_'.$type;
        $table = ($type=="A3" || $type=="SRA3" || $type=="A5")?$field:'flexible_price';
        return $this->db->query("select material  from $table")->result();
    }

    public function addMaterial(){
        $material  = $this->input->post('material');
        $tempid  = $this->input->post('tempid');
        $this->db->insert('flexible_dies_mat',array('OID'=>$tempid,'material'=>$material,'labeltype'=>'plain'));
        return true;
    }

    public function fetchmaterinfo($id){
        $qry = $this->db->query("select * from flexible_dies_mat where ID = $id");
        return $qry->row_array();
    }
    public function fetchdierecordinfo($id){
        $qry = $this->db->query("select * from flexible_dies_info where ID = $id");
        return $qry->row_array();
    }
    public function fetchcartinfo($id){
        $qry = $this->db->query("select p_code, FinishTypePricePrintedLabels from temporaryshoppingbasket where ID = $id");
        return $qry->row_array();
    }

    public function updatecustomsheetprice($scorecord,$material){

        $printprice = 0;
        $price = $this->get_custom_prize($material['material'],$material['qty'],$scorecord['format']);

        if($material['labeltype']=="printed"){
            $result = $this->get_print_price_rate($material['qty']);

            if($material['printing']=="Mono"){ $type="Mono";}else{ $type="Fullcolour";}
            $unitprice = $result[$type]*$material['qty'];

            $unitprice = $this->check_price_uplift($unitprice);

            if($scorecord['format']=="A4"){$unitprice = $unitprice/2;}
            if($scorecord['format']=="roll"){$unitprice = 0;}
            if($scorecord['format']=="SRA3" || $scorecord['format']=="A3"){$unitprice = $unitprice * 1.5;}

            $freeart = $result['Free'];
            $cutdownqty = ($freeart>=$material['designs'])?0:$material['designs']-$freeart;

            $subtotal = $cutdownqty * 5.00;
            $subtotal = $this->check_price_uplift($subtotal);

            $printprice = $unitprice + $subtotal;
        }
        $array = array('printprice'=>$printprice,'plainprice'=>$price,'tempprice'=>1,'check'=>1);

        $this->db->where('ID',$material['ID']);
        $this->db->update('flexible_dies_mat',$array);
    }
    public function get_custom_prize($mat,$qty,$format){

        if($format=="A4"){
            $breaks = array(25,50,100,500,1000,2500,5000,7500,10000,15000,20000,30000,40000);
            $table = 'flexible_price';
        }else if($format=="SRA3"){
            $breaks = array(50,100,300,500,1000,2500,5000,7500,10000,15000,20000);
            $table = 'flexible_price_SRA3';
        }else if($format=="A3"){
            $breaks = array(25,50,100,500,1000,2500,5000,7500,10000,15000,20000,30000,40000);
            $table = 'flexible_price_A3';
        }else if($format=="A5"){
            $breaks = array(25,50,100,500,1000,2500,5000,7500,10000,15000,20000,30000,40000);
            $table = 'flexible_price_A5';
        }else if($format=="integrated"){
            $breaks = array(25,50,100,500,1000,2500,5000,7500,10000,15000,20000,30000,40000);
            $table = 'flexible_price_int';
        }


        $result = $this->db->query("select * from $table where material LIKE '".$mat."'")->row_array();

        foreach($breaks as $key => $row){
            $price = $field1 = $field2 = 0;
            if($qty==$row){
                $field1 = 'sheet_'.$row;
                $price = $result[$field1]*$row;
                break;
            }else if($qty>$row && $qty<$breaks[$key+1]){
                $field1 = 'sheet_'.$row;
                $field2 = 'sheet_'.$breaks[$key+1];

                $sec1   = $result[$field1]*$row;
                $remqty = $qty - $row;
                $sec2   = $result[$field2]*$remqty;
                $price = $sec1 + $sec2;
                break;
            }else{
                if($format=="SRA3" && $qty>20000){
                    $price = $result['sheet_20000']*$qty;
                }else if($qty>40000){
                    $price = $result['sheet_40000']*$qty;
                }
            }
        }
        return number_format($price,2,'.','');
    }

    function get_print_price_rate($sheets){
        if($sheets<=49){
            $condtion="49";
        }else
            if($sheets>49 && $sheets<=99){
                $condtion="99";
            }else
                if($sheets>99 && $sheets<=199 ){
                    $condtion="199";
                }else
                    if($sheets>199 && $sheets<=299){
                        $condtion="299";
                    }else
                        if($sheets>299 && $sheets<=399){
                            $condtion="399";
                        }else
                            if($sheets>399 && $sheets<=499){
                                $condtion="499";
                            }else
                                if($sheets>499 && $sheets<=999){
                                    $condtion="999";
                                }else
                                    if($sheets>999 && $sheets<=2499){
                                        $condtion="2499";
                                    }else
                                        if($sheets>2499 && $sheets<=4999){
                                            $condtion="4999";
                                        }else
                                            if($sheets>4999 && $sheets<=9999){
                                                $condtion="9999";
                                            }else
                                                if($sheets>9999 && $sheets<=14999){
                                                    $condtion="14999";
                                                }else
                                                    if($sheets>14999 && $sheets<=19999){
                                                        $condtion="19999";
                                                    }else
                                                        if($sheets>19999 && $sheets<=29999){
                                                            $condtion="29999";
                                                        }else
                                                            if($sheets>29999 && $sheets<=39999){
                                                                $condtion="39999";
                                                            }else
                                                                if($sheets>=40000){
                                                                    $condtion="40000";
                                                                }

        $query = $this->db->query("SELECT * from print_price WHERE Quantity = '$condtion' ");
        $row = $query->row_array();
        return $row;
    }
    function check_price_uplift($total_price){
        $total_price = $total_price/0.94; // 6% increment yearly march 2018
        return $total_price;
    }
    function calulate_min_rolls($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }
    function calulate_min_labels($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Labels) AS Labels FROM `tbl_batch_labels` WHERE ManufactureID LIKE '".$manufature."' AND status LIKE 'Y'");
        $roll = $roll->row_array();
        return  ($roll['Labels'] !=null)?$roll['Labels']:0;
    }
    public function getProductId($mefatureCode){
        return  $this->db->query("select ProductID,LabelsPerSheet,ProductBrand,ManufactureID from products where ManufactureID LIKE '%".$mefatureCode."%'")->row_array();

    }
    function get_roll_qty($manufature1){

        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` Where ManufactureID LIKE '".$manufature."' AND (Active LIKE 'Y' )");
        $roll = $roll->row_array();
        if(isset($roll['Rolls']) and $roll['Rolls'] > 0){
            return  $roll['Rolls'];
        }else { return 0;}


    }
    public function max_total_labels_on_rolls($perroll){
        $max_labels = ceil(500000/$perroll);
        $max_labels = $max_labels*$perroll;
        return $max_labels;
    }
// Plain Roll Price
    public function addToCart($ProductID,$ManufactureID,$Quantity,$cusLbl=null,$conidition = null)
    {

        $prodinfo = $this->getproductdetail($ProductID);
        $is_custom = 'No';
        $labelproll=0;

        if(preg_match('/Roll Labels/is',$prodinfo['ProductBrand']))
        {
            $min_qty = $this->get_roll_qty($ManufactureID);

            if( $Quantity < $min_qty)
            {
                $Quantity = $min_qty;
            }
            $is_custom = 'Yes';
            $labelproll = $prodinfo['LabelsPerSheet'];
        }
        else if(preg_match('/A3 Label/i',$prodinfo['ProductBrand']))
        {
            if($Quantity < 100)
            {
                $Quantity = 100;
            }
        }
        else if(preg_match('/Application Labels/',$prodinfo['ProductBrand']))
        {

            $colors = $this->get_color_option($prodinfo['CategoryID']);
            if($colors==1){ $colorcode = 'Black';}
            if($Quantity < 1) {
                $Quantity = 1;
            }
        }
        else if(preg_match('/SRA3 Label/',$prodinfo['ProductBrand']))
        {
            if($Quantity < 100)
            {
                $Quantity = 100;
            }
        }
        else{

            if(substr($ManufactureID,-2,2)=='XS'){
                $Quantity =  $this->special_xmass_qty($Quantity);
            }
            else{ if(substr($ManufactureID,-2,2)=='XS'){
                $Quantity =  $this->special_xmass_qty($Quantity);
            }
            else{
                if($Quantity < 25){
                    $Quantity = 25;
                }
            }
            }

        }

        $UserID = $this->session->userdata('userid');
        // echo $ManufactureID.' q='.$Quantity.' l='.$cusLbl.' qq='.$Quantity;
        /*****************WPEP Offer************/
        $custom_price = $this->getPrize($Quantity,$ManufactureID,$cusLbl,$Quantity);


        $wpep_discount = 0.00;
        $ProductBrand = $this->ProductBrand($ManufactureID);
        if(preg_match("/A4 Labels/i",$ProductBrand)){
            $mat_code = $this->quoteModel->getmaterialcode($ManufactureID);
            $material_discount = $this->quoteModel->check_material_discount($mat_code);
            if($material_discount){
                $custom_price = ($custom_price*1.2);
                $wpep_discount = (($custom_price)*($material_discount/100));
                $total = $custom_price-$wpep_discount;
                $custom_price = $total/1.2;
            }
        }


        /*****************WPEP Offer************/






        $session_id = $this->session->userdata('session_id');
        $date = date("Y-m-d h:i:s");
        $unitPrice = $custom_price/$Quantity;
        $UnitPrice = number_format(round($unitPrice,2),2,'.','');

        //$this->db->update("UPDATE `productsstats` SET AddedtoCart = AddedtoCart+".$Quantity." WHERE ProductID = '".$ProductID."'");
        //$quoteData = $this->db->query("UPDATE `productsstats` SET AddedtoCart = 'AddedtoCart+".$Quantity."' WHERE ProductID = '".$ProductID."'");
        //$this->db->where('ProductID', $ProductID);
        //$this->db->update('productsstats', $quoteData);
        if($conidition === 'true'){
            return $UnitPrice;
        }
        if($ProductID==0){
            $Quantity=0;
            $UnitPrice=0;
            $custom_price=0;
        }

        if($ProductID==0 && $ManufactureID=='sco1'){
            $Quantity=1;
        }

        $quotationData = array(
            'SessionID' => $session_id,
            'UserID' => $UserID,
            'ProductID' => $ProductID,
            'OrderTime' => $date,
            'Quantity' => $Quantity,
            'OrderData' => $date,
            'UnitPrice' => $UnitPrice,
            'TotalPrice' => $custom_price,
            'is_custom' => $is_custom,
            'LabelsPerRoll'=>$labelproll
        );

        if($ProductID==0 && $ManufactureID=='sco1'){
            $quotationData = array_merge($quotationData, array('p_code'=>'SCO1','p_name'=>'Set-up charge'));
        }
        $this->db->insert('temporaryshoppingbasket', $quotationData);

        /*$cond = array( 'ProductID' => $ProductID,'SessionID' => $session_id);
        $rs = $this->db->get_where('temporaryshoppingbasket',$cond)->result();
        echo $this->db->last_query();
        if(!empty($rs))
        {
            if( ($rs[0]->ProductID == $ProductID) && ($rs[0]->SessionID == $session_id) )
            {
                $qty = $rs[0]->Quantity + $Quantity;
                $this->UpdateItem($ProductID,$ManufactureID,$qty);
            }
            else
            {
                $this->db->insert('temporaryshoppingbasket', $quotationData);
            }

        }
        else
        {
            $this->db->insert('temporaryshoppingbasket', $quotationData);
        } */
        //$sql = $this->db->query("select * from temporaryshoppingbasket where SessionID = '".$session_id."' ");

        return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
    function get_color_option($categoryid){
        $query = $this->db->query(" Select FeaturedProducts from category WHERE CategoryID LIKE '".$categoryid."'");
        $result = $query->row_array();
        return $result['FeaturedProducts'];
    }

    public function getproductdetail($id){



        $query = $this->db->select('*')

            ->where('ProductID',$id)

            ->get('products');



        return $query->row_array();

    }
    function special_xmass_qty($Quantity){
        if($Quantity%5 != 0 and $Quantity <= 25 ){
            $Quantity = 5*(ceil($Quantity/5));
        }
        else if($Quantity%25 != 0 and $Quantity > 25 ){
            $Quantity = 25*(ceil($Quantity/25));
        }
        if($Quantity < 5){
            $Quantity = 5;
        }
        else if($Quantity > 100){
            $Quantity = 100;
        }
        return $Quantity;

    }
    function min_roll_price($manufature1,$Roll,$labels,$custLbl=null,$qty=null){
        $manufature = substr($manufature1,0,-1);
        $price = $this->calclateprice($manufature1,$Roll,$labels,$custLbl,$qty);
        return $price['final_price'];
    }
    function lba_pack_details($data){

        $quantitytype = 'Sheet';
        $packsize = 1;
        if(isset($data['ManufactureID']) and $data['ManufactureID']!=''){
            $condition = " ManufactureID LIKE '".$data['ManufactureID']."' ";
        }
        else{
            $condition = " ProductID LIKE '".$data['ProductID']."' ";
        }
        $result = $this->db->query(" SELECT specification2,specification1 FROM `products` 
		INNER JOIN category ON category.CategoryID = products.CategoryID WHERE   $condition ")->row_array();
        if(isset($result['specification2']) and $result['specification2']=='Pack'){
            $quantitytype = 'Pack';
            $packsize = trim(str_replace("Sheets","",$result['specification1']));
        }
        return array('packsize'=>$packsize,'Type'=>$quantitytype);

    }
    function calculate_lba_price($qty, $code){
        //$diecode =  substr($code, 0, -4);
        $result = $this->db->query("select price from lba_prices WHERE sheets = $qty");
        $result = $result->row_array();
        $printprice = $result['price'];
        $result = $this->db->query("select SheetPrice from tbl_product_batchprice WHERE ManufactureID = '$code' AND  BatchID = 1");
        $result = $result->row_array();
        $materialprice = $result['SheetPrice'];

        $materialprice = $this->check_price_uplift($materialprice);

        $materialprice = $materialprice*$qty;
        $postage = 0.99;
        $total =  number_format(($printprice+$materialprice+$postage),2,'.','');
        return  array('custom_price' => $total, 'printprice'=>$printprice, 'plainprice'=>($materialprice+$postage) );
    }
    public function getPrize($Quantity,$ManufactureID,$custLbl=null,$qty=null)
    {



        if(substr($ManufactureID,-2,2)=='XS'){
            $row = $this->db->query("Select count(*) as total,`Price` from xmass_prices where Qty LIKE '".$Quantity."' LIMIT 1");
            $result = $row->row_array();
            if($result['total']==1){
                $custom_price	=	 number_format($result['Price']/1.2,2,'.','');
                $custom_price	=	 number_format($custom_price,2,'.','');

            }else{
                $custom_price = 4.15;
            }
            return $custom_price;
        }


        $roll = $this->Is_ProductBrand_roll($ManufactureID);

        if($roll['Roll']=='yes'){
            $custom_price = $this->min_roll_price($ManufactureID,$Quantity,$roll['LabelsPersheet'],$custLbl,$qty);

            $custom_price	=	 number_format(round($custom_price,2),2,'.','');
            return $custom_price	=	 number_format(round($custom_price,2),2,'.','');

        }
        else if($roll['ProductBrand']=='Application Labels' ){
            $response = $this->lba_pack_details(array('ManufactureID'=>$ManufactureID));
            $Quantity = $Quantity*$response['packsize'];
            if($Quantity < 25){
                $price = $this->calculate_lba_price($Quantity, $ManufactureID);
                return $custom_price	=	 number_format(round($price['custom_price'],2),2,'.','');
            }
        }

        $qry = $this->db->query("select tbl.ManufactureID,tbl.BatchID,tbl.SetupCost,tbl.SheetPrice,batch.BatchQty from tbl_product_batchprice tbl,tbl_batch batch where
 tbl.ManufactureID='".$ManufactureID."' and tbl.BatchID= batch.BatchID ORDER BY tbl.BatchID Asc ");
        $pricearr 	= $qry->result_array();

        $j = 0;
        $arr_custom = 0;
        $arr_custom = array();


        foreach($pricearr as $pricerow1)
        {
            $arr_custom[] = $pricerow1;
        }
        $arrsize=count($arr_custom);

        $flag = 0;

        for( $traverse = 0; $traverse < $arrsize-1; $traverse++)
        {


            if ($Quantity<100) {
                $flag = 1;
                $sheetprice = $arr_custom[0]['SheetPrice'];
                $setupcost = $arr_custom[0]['SetupCost'];
                $custom_price=($sheetprice * $Quantity) + $setupcost;
            }
            if ($Quantity >= $arr_custom[$traverse]['BatchQty'] && $Quantity < $arr_custom[$traverse+1]['BatchQty']){

                $flag = 1;
                $batch=$arr_custom[$traverse]['BatchQty'];
                $setupcost = $arr_custom[$traverse+1]['SetupCost'];

                if ($Quantity == $arr_custom[$traverse]['BatchQty'])
                {
                    $sheetprice = $arr_custom[$traverse]['SheetPrice'];
                    $batch  =  $arr_custom[$traverse]['BatchQty'];
                    $custom_price=($sheetprice * $Quantity);
                    break;
                }
                else
                {
                    $sheetprice = $arr_custom[$traverse+1]['SheetPrice'];
                    $sheetprice1 = $arr_custom[$traverse]['SheetPrice'];
                    $batch=$arr_custom[$traverse]['BatchQty'];
                    $custom_price=($sheetprice * $Quantity) + $setupcost;
                    $custom_price1= $sheetprice1 * $batch;

                    if($custom_price < $custom_price1)
                    {

                        $custom_price = $custom_price1 + (($Quantity-$batch) * $sheetprice);

                    }

                    /********Price adjutemtn Formaula For SRA3****************/
                    if (substr($arr_custom[$traverse]['ManufactureID'],0,2) == "SR" || substr($arr_custom[$traverse]['ManufactureID'],0,2) == "sr")
                    {
                        $custom_price=$custom_price1 + (($Quantity-$batch) * $sheetprice);
                    }
                    /********Price adjutemtn Formaula For SRA3****************/

                    break;
                }
            }



        } // End of For LOOP


        if($flag == 0)
        {

            $sheetprice = $arr_custom[$traverse]['SheetPrice'];

            $setupcost = $arr_custom[$traverse]['SetupCost'];
            if($Quantity == $arr_custom[$traverse]['BatchQty'])
            {
                $batch	=	$arr_custom[$traverse]['BatchQty'];
                $custom_price	=	($sheetprice * $Quantity);
                //  break;
            }
            else
            {
                $batch	=	$arr_custom[$traverse]['BatchQty'];
                $custom_price = ($sheetprice * $Quantity) + $setupcost;
                //  break;
            }


        }

        if($roll['ProductBrand']=='Application Labels' ){
            $printprice = $this->calculate_printed_sheets($Quantity, 'Fullcolour', 1);
            $custom_price = $custom_price+$printprice['price'];
        }

        $custom_price = $this->check_price_uplift($custom_price);
        $custom_price = number_format(round($custom_price,2),2,'.','');


        return $custom_price;
    }






// printed Roll Price
    public function UpdateItem($ID=null,$productID=null,$ManufactureID=null,$qty=null, array $condition=null){

        $cookie = $_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');

        $query = $this->db->query(" select is_custom,LabelsPerRoll from temporaryshoppingbasket WHERE 
				(SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND ID = '".$ID."'");
        $row = $query->row_array();



        $ProductBrand = $this->ProductBrand($ManufactureID);
        $printing = $this->input->post('printing');

        if(preg_match('/Roll Labels/is',$ProductBrand) && $printing=="Y"){
            $labels = $this->input->post('labels');
            $finish = $this->input->post('finish');
            $press  = $this->input->post('press');
            $min_qty = $this->get_roll_qty($ManufactureID);

            $prid = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '".$ManufactureID."'")->row_array();

            $response = $this->rolls_calculation($min_qty,$prid['LabelsPerSheet'],$labels);
            $collection['labels'] 	= $response['total_labels'];
            $collection['manufature'] = $ManufactureID;
            $collection['finish']     = $finish;
            $collection['rolls']      = $response['rolls'];
            $collection['printing']      = $this->input->post('type');

            $price_res = $this->calculate_printing_price($collection);
            $custom_price = $price_res['final_price'];

            if($press==1){
                $custom_price = $custom_price + 50.00;
            }
            if($qty>$response['rolls']){
                $add_rolls = $qty - $response['rolls'];
                $additional_cost = $this->additional_charges_rolls($add_rolls);

                $custom_price = $custom_price + $additional_cost;
            }

            $labels = $response['total_labels'];

            if($qty<$response['rolls']){
                $qty = $response['rolls'];
            }

            if($response['total_labels'] != $response['actual_labels']){
                $labels = $response['total_labels'];
            }

            $userID = $this->session->userdata('userid');
            if((isset($userID) and !empty($userID)))
            {
                $wholesale = $this->get_db_column('customers','wholesale','UserID',$userID);
                if($wholesale == "wholesale")
                {
                    $custom_price = $this->apply_discount($userID, $collection['manufature'],$custom_price);
                }
            }

            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');

            if($condition['condition'] ==='true'){
                return $unitPrice;
            }

            $data = array(
                'Quantity' 	 => $qty,
                'orignalQty' 	 => $labels,
                'LabelsPerRoll'=> $labels/$qty,
                'UnitPrice' 	 => $UnitPrice,
                'TotalPrice'   => $custom_price,
                'source'       => 'printing',
                'is_custom'       => 'Yes',
                'orientation'  => $this->input->post('orientation'),
                'FinishType'   => $this->input->post('finish'),
                'wound'        => $this->input->post('wound'),
                'Print_Type'   => $this->input->post('type'),
                'Print_Design' => $this->input->post('design'),
                'Print_Qty'    => $this->input->post('pqty'),
                'pressproof'   => $press,
                'Free'         => $response['rolls'],
            );
            if((isset($userID) and !empty($userID)))
            {
                $domain = $this->get_db_column('customers','Domain','UserID',$userID);
                if($domain == "PLO")
                {
                    $data['page_location'] = 'Trade Print';
                }
                else
                {
                    $data['page_location'] = '';
                }
            }

        }else if(isset($row['is_custom']) and $row['is_custom']=='Yes'){
            $prid = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '".$ManufactureID."'")->row_array();

            $LabelsPerSheet  = ($row['LabelsPerRoll'] != 0)?$row['LabelsPerRoll']:$prid['LabelsPerSheet'];
            $custom_price = $this->min_roll_price($ManufactureID,$qty,$LabelsPerSheet);
            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');

            if($condition['condition'] ==='true'){
                return $unitPrice;
            }

            $data = array(
                'Quantity' 	 => $qty,
                'UnitPrice' 	 => $UnitPrice,
                'TotalPrice' => $custom_price
            );

        }else{
            if(substr($ManufactureID,-2,2)=='XS'){
                $qty =  $this->special_xmass_qty($qty);
            }
            if(substr($ManufactureID,-2,2)=='XS'){
                $qty =  $this->special_xmass_qty($qty);
            }
            /*****************WPEP Offer************/
            $wpep_discount = 0.00;
            $custom_price = $this->getPrize($qty,$ManufactureID);
            $ProductBrand = $this->ProductBrand($ManufactureID);
            if(preg_match("/A4 Labels/i",$ProductBrand)){
                $mat_code = $this->quoteModel->getmaterialcode($ManufactureID);
                $material_discount = $this->quoteModel->check_material_discount($mat_code);
                if($material_discount){
                    $custom_price = ($custom_price*1.2);
                    $wpep_discount = (($custom_price)*($material_discount/100));
                    $total = $custom_price-$wpep_discount;
                    $custom_price = $total/1.2;
                }
            }

            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');
            /*****************WPEP Offer************/

            if($condition['condition'] ==='true'){
                return $unitPrice;
            }
            $data = array(
                'Quantity' 	 => $qty,
                'UnitPrice' 	 => $UnitPrice,
                'TotalPrice' => $custom_price
            );
        }



        $session_id = $this->session->userdata('session_id');
        $where = "(SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND ID = '".$ID."' AND ProductID = '".$productID."' ";

        $this->db->where($where);
        $this->db->update('temporaryshoppingbasket', $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    function apply_discount($userID, $manufature, $final_price, $type = "login", $qty = '')
    {
        if($type == "login")
        {
            $wholesale = $this->get_db_column("customers","wholesale","UserID",$userID);
            if($wholesale == "wholesale")
            {
                $this->load->model('discount_model');
                $roll = $this->Is_ProductBrand_roll($manufature);
                if($roll['Roll'] == "yes")
                {
                    $discount_percent = $this->discount_model->check_ws_discount_rolls($userID,$manufature);
                    $discount_percent = $discount_percent['print_discount'];
                }
                else
                {
                    $discount_percent = $this->discount_model->check_ws_discount_print($userID,$manufature);
                }
                if(!empty($discount_percent))
                {
                    $discount = ($discount_percent/100)*$final_price;
                    $final_price = round($final_price - $discount,2);
                }
                else
                {
                    $global_discount = $this->discount_model->get_global_discount_print($userID);
                    $discount = ($global_discount/100)*$final_price;
                    $final_price = round($final_price - $discount,2);
                }
                $this->session->set_userdata(array('ws_applied'=>'yes'));
                return $final_price;
            }
            else
            {
                return $final_price;
            }
        }
        else if($type == "logout")
        {

            $count = $this->viewCart();
            if($count)
            {
                $ws_applied = $this->session->userdata('ws_applied');
                if($ws_applied == "yes")
                {
                    $cart_detail = $this->viewCart();
                    foreach($cart_detail as $row)
                    {
                        $prods = $this->show_product($row->ProductID);
                        $prod = array();
                        $prod[0] = $prods;

                        foreach($prod as $pr)
                        {
                            if(preg_match("/Roll/is", $pr['ProductBrand']))
                            {
                                $printing = $row->Printing;
                                if($printing == "Y")
                                {
                                    $qty = $row->Quantity;

                                    $min_qty = $this->min_qty_roll($pr['CategoryID']);
                                    $response = $this->rolls_calculation($min_qty, $pr['LabelsPerSheet'], $row->orignalQty);


                                    $labels = $response['total_labels'];
                                    $labels_per_rolls = $response['per_roll'];
                                    $sheets = $response['rolls'];

                                    $collection['labels'] 	  = $labels;
                                    $collection['manufature'] = $pr['ManufactureID'];
                                    $collection['finish']     = $row->FinishType;
                                    $collection['rolls']      = $sheets;
                                    $collection['printing']   = $row->Print_Type;

                                    $total_price = $this->calculate_printing_price($collection);

                                    $total_price = $total_price['final_price'];

                                    if($qty > $response['rolls'])
                                    {
                                        $additional_rolls = $qty-$response['rolls'];
                                        $additional_cost = $this->additional_charges_rolls($additional_rolls);

                                        $total_price = $total_price+$additional_cost;
                                    }
                                    if($row->pressproof == 1)
                                    {
                                        $pressproof_charges = $this->currecy_converter(50.00);
                                        $total_price = $total_price + $pressproof_charges;
                                    }
                                }
                                else
                                {
                                    $total_price = $this->myPriceModel->calculatePlainRollPrice($pr['ManufactureID'],$row->Quantity,$row->LabelsPerRoll);

                                    $total_price = $total_price['price'];
                                }
                                $this->update_db_column("temporaryshoppingbasket","TotalPrice",$total_price,"ID",$row->ID);
                                $this->update_db_column("temporaryshoppingbasket","UnitPrice",$total_price/$row->Quantity,"ID",$row->ID);
                            }
                            else
                            {
                                $plain_price = $this->user_model->ajax_price($row->Quantity,$pr['ManufactureID']);
                                $plain_price = $plain_price['custom_price'];
                                $this->update_db_column("temporaryshoppingbasket","TotalPrice",$plain_price,"ID",$row->ID);
                                $this->update_db_column("temporaryshoppingbasket","UnitPrice",$plain_price/$row->Quantity,"ID",$row->ID);
                                if($row->Printing == "Y")
                                {
                                    if(preg_match('/Monochrome/is',$row->Print_Type))
                                    {
                                        $labeltype = "Mono";
                                    }
                                    else
                                    {
                                        $labeltype = "Fullcolour";
                                    }
                                    $print_price = $this->calculate_printed_sheets($row->Quantity, $labeltype, $row->Print_Qty, $pr['ProductBrand'], $pr['ManufactureID']);
                                    $print_price = $print_price['price']+$print_price['desginprice'];
                                    $this->update_db_column("temporaryshoppingbasket","Print_Total",$print_price,"ID",$row->ID);
                                    $this->update_db_column("temporaryshoppingbasket","Print_UnitPrice",$print_price/$row->Quantity,"ID",$row->ID);
                                }
                            }
                        }
                    }
                }
                $this->session->unset_userdata('ws_applied');
            }
        }
    }
    function calculate_printed_sheets($qty, $type, $design=NULL, $brand=NULL){
        $qurey = $this->db->query("SELECT * FROM `print_price` ORDER BY Quantity ASC");
        $result = $qurey->result();
        $sheets='';
        $print_price ='';
        foreach($result as $key => $row){
            if($qty<=49){
                $sheets = $row->Quantity;
                if($type=='Fullcolour'){ $print_price =  $row->Fullcolour;
                }else{ $print_price =  $row->Mono; }
                $free_artwork =  $row->Free;
                break;
            }
            else if($qty == $row->Quantity){
                $sheets = $row->Quantity;
                if($type=='Fullcolour'){ $print_price =  $row->Fullcolour;
                }else{ $print_price =  $row->Mono; }
                $free_artwork =  $row->Free;
                break;
            }
            else if(($qty > $row->Quantity and isset($result[$key+1]->Quantity) and $qty < $result[$key+1]->Quantity)){
                $sheets = $result[$key+1]->Quantity;
                if($type=='Fullcolour'){ $print_price =  $result[$key+1]->Fullcolour;
                }else{ $print_price =  $result[$key+1]->Mono; }
                $free_artwork =  $result[$key+1]->Free;
            }
            else if($qty>=40000){
                $sheets = $row->Quantity;
                if($type=='Fullcolour'){ $print_price =  $row->Fullcolour;
                }else{ $print_price =  $row->Mono; }
                $free_artwork =  $row->Free;
            }
        }

        //echo "Sheets = ".$sheets.' || TYPE '.$type.' || Price '.$print_price.' || Free Artwork '.$free_artwork;

        $print_price = $qty*$print_price;
        $design_price  = 0;

        if(isset($design) and $design > $free_artwork){
            $design_price  = ($design-$free_artwork)*5;
        }

        /************* Prices Uplift by 6% Yearly ***********************************/
        $print_price = $this->check_price_uplift($print_price);
        $design_price = $this->check_price_uplift($design_price);
        /*************************************************************************/



        /********** 50% disocunt prices on printed A4 Labels ***********/
        if (isset($brand) and  preg_match("/A4 Label/is", $brand)){
            $print_price = $print_price/2;
            //	$design_price = 0.00;
            //	$free_artwork = 10;
        }
        /********** 50% disocunt prices on printed A4 Labels ***********/
        $print_price = number_format(($print_price),2,'.','');
        $design_price = number_format(($design_price),2,'.','');


        return array('price'=>$print_price,'desginprice'=>$design_price, 'artworks'=>$free_artwork);
        //return $sheets;
    }
    function update_db_column($table, $column, $data, $key, $value)
    {
        $sql = "UPDATE $table SET $column = $data WHERE $key LIKE '".$value."' LIMIT 1";
        $row = $this->db->query($sql);
    }
    function currecy_converter($price, $vat=NULL){

        $rate = $this->get_exchange_rate(currency);







        if(isset($rate) and  $rate > 0 ){
            $price = $price* $rate;
        }



        if($vat=='yes' and vatoption=='Inc'){ $price = $price*1.2; }



        return number_format(round($price,2),2,'.','');



    }
    function min_qty_roll($catid){
        $query = $this->db->query("SELECT ManufactureID FROM `products` WHERE `CategoryID` LIKE '".$catid."%' AND (Activate LIKE 'Y' OR displayin = 'backoffice') LIMIT 1");
        $query = $query->row_array();
        $manufature = substr($query['ManufactureID'],0,-1);

        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND (Active LIKE 'Y') ");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }
    function show_product($pid){
        $qry = $this->db->query("SELECT * FROM products WHERE ProductID  = ".$pid."");
        return $qry->row_array();
    }
    public function viewCart(){

        $cookie = $_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');


        $qry = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

        $res  = $qry->result();

        return $res;
    }
    function is_ProductBrand_roll($id){

        $query=$this->db->query("select  ProductBrand,LabelsPerSheet from products  where ManufactureID='".$id."'");
        $res=$query->row_array();

        if(preg_match("/Roll Labels/i",$res['ProductBrand'])){
            $roll = 'yes';
        }else{ $roll = 'No';}
        return array('Roll'=>$roll,'LabelsPersheet'=>$res['LabelsPerSheet'],'ProductBrand'=>$res['ProductBrand']);

    }
    function additional_charges_rolls($rolls){
        if($rolls <= 3){$per_roll = 1.50;}
        else if($rolls > 3   and $rolls <= 10){  $per_roll = 1.35;}
        else if($rolls > 10  and $rolls <= 25){  $per_roll = 1.20;}
        else if($rolls > 25  and $rolls <= 50){  $per_roll = 1.05;}
        else if($rolls > 50  and $rolls <= 100){ $per_roll = 0.90;}
        else if($rolls > 100 and $rolls <= 200){ $per_roll = 0.75;}
        else if($rolls > 200 ){$per_roll = 0.60;}
        $price = $per_roll*$rolls;
        /************* Prices Uplift by 6% Yearly **************/
        $price = $this->check_price_uplift($price);
        /*******************************************************/
        return $price;
    }
    function ProductBrand($id){
        $query=$this->db->query("select  ProductBrand from products  where ManufactureID LIKE '".$id."'");
        $res=$query->row_array();
        return $res['ProductBrand'];
    }
    function rolls_calculation($die_across, $max_labels,  $total_labels, $rolls=NULL){

        if($rolls!=NULL){  $rolls = $rolls+$die_across; } else{  $rolls = $die_across; }
        $per_roll = $total_labels/$rolls;
        if($per_roll > $max_labels){
            $response = $this->rolls_calculation($die_across, $max_labels, $total_labels, $rolls);
            $per_roll = $response['per_roll'];
            $rolls = $response['rolls'];
        }

        $data['per_roll'] 	    = ceil($per_roll);
        $data['total_labels']   = ceil($per_roll)*$rolls;
        $data['actual_labels']  = $total_labels;
        $data['rolls'] = $rolls;
        return $data;
    }

    function calculate_printing_price($collection = array()){
        // print_r($collection);
        $rolls  = $collection['rolls'];
        $labels = $collection['labels'];

        $manufature = $collection['manufature'];
        $finish = $collection['finish'];
        $printing = $collection['printing'];

        if(isset($labels) and  $labels > 0){

            $total_price = $this->calculate_print_material($manufature, $labels, $finish, $rolls);

            /**********************************************************************/

            $label_finish  = $total_price['label_finish'];
            $printprice    = $total_price['price'];
            if($printing == '6 Colour Digital Process + White'){
                $printprice = (1.1)*$printprice;  // - Full Colour + White Increase 10%
            }

            $labels_per_roll = $labels/$rolls;
            if($labels_per_roll < 99){ $labels_per_roll = 100;}
            $plainprice = $this->calclateprice($manufature, $rolls, $labels_per_roll);
            $plainprice = $plainprice['final_price'];
            $minus_print_price = $printprice - $plainprice;
            $discount_price = $minus_print_price/2;

            $total_price = $printprice-$discount_price+$label_finish;

            $userID = $this->session->userdata('Order_person');
            if((isset($userID) and !empty($userID)))
            {
                $wholesale = $this->get_db_column('customers','wholesale','UserID',$userID);
                if($wholesale == "wholesale")
                {
                    $total_price = $printprice+$label_finish;
                }
            }

            /**********************************************************************/



            $final_price =sprintf('%.2f', round($total_price,2));
            $unit_price  =sprintf('%.2f', round($total_price/$rolls,2));
            $perlabel = number_format(($unit_price/$labels)*100,2);
            return $data = array('perlabel'=>$perlabel,'final_price'=>$final_price,'unit_prcie'=>$unit_price,'Labels'=>$labels);

        }else{
            return $data = array('perlabel'=>0.00,'final_price'=>0.00,'unit_prcie'=>0.00,'Labels'=>0.00);
        }
    }

    function calclateprice($manufature=NULL,$rolls=NULL,$label=NULL,$custLbl=null,$qty=null){

        if(isset($rolls) and $rolls > 0 and isset($label) and $label > 99){

            $total_price = $this->calculate_material($manufature,$label,$rolls,$custLbl,$qty);
            $total_price = $total_price/0.94; // 6% increment yearly


            /******** price uplift ********************************/
            $total_price = $this->check_price_uplift($total_price);
            /********************** price uplift **************/



            $final_price =sprintf('%.2f', round($total_price,2));
            $unit_price  =sprintf('%.2f', round($total_price/$rolls,2));
            $perlabel = number_format(($unit_price/$label)*100,2);
            return $data = array('perlabel'=>$perlabel,'final_price'=>$final_price,'unit_prcie'=>$unit_price,'Labels'=>$label);

        }else{
            return $data = array('perlabel'=>0.00,'final_price'=>0.00,'unit_prcie'=>0.00,'Labels'=>0.00);
        }
    }

    function calculate_material($ManufactureID,$Labels,$Rolls,$custLbl=null,$qty=null){

        $query = $this->db->query("SELECT Width,Height FROM `products` as p INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID 
		Where ManufactureID LIKE '".$ManufactureID."' ");

        $query = $query->row_array();

        $width  = $query['Width'];
        $height = $query['Height'];

        $ManufactureID = substr($ManufactureID,0,-1);

        $info = $this->which_material($ManufactureID);
        $gruop = $this->which_group($width, $height);
        $Labels = $this->calculate_labels_sheets($ManufactureID,$Labels,$custLbl,$qty);

        $table = "tbl_por_".$gruop.$info['type'];

        $meterail_cost = $info['price'];
        $sqr_width = $width+5;
        $sqr_height = $height+5;

        $sqr_width = $sqr_width/1000;
        $sqr_height = $sqr_height/1000;


        $linear_meter = $sqr_width*$sqr_height;
        $sqr_meter = $linear_meter*$Labels;

        $per_roll_price = ($sqr_meter*$meterail_cost)+0.75;
        $per_roll_price = $per_roll_price*$Rolls;

        $roll = $this->calculate_rolls_qty($ManufactureID,$Rolls);
        $por = $this->calculate_por($ManufactureID,$table,$roll,$Labels);
        $por = (1-($por/100));

        $sale_price = $per_roll_price/$por;
        return $sale_price ;

    }

    function calculate_por($menucode, $table,$rolls,$labels){
        $field = 'Labels_'.$labels;
        $query =    $this->db->query("Select $field from tbl_batch_roll INNER JOIN $table  
						  ON tbl_batch_roll.batch_id=$table.batch_id WHERE ManufactureID LIKE '".$menucode."' AND tbl_batch_roll.Rolls = $rolls ");
        $row = $query->row_array();
        return $row[$field];
    }
    function calculate_rolls_qty($manufature,$roll){
        $qurey = $this->db->query("SELECT Rolls FROM `tbl_batch_roll` Where ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y' ORDER BY Rolls ASC");
        $result = $qurey->result();
        $Rolls='';

        foreach($result as $key => $row){
            if($roll == $row->Rolls){
                $Rolls = $row->Rolls;
            }
            else if(($roll > $row->Rolls and isset($result[$key+1]->Rolls) and $roll < $result[$key+1]->Rolls)){
                $Rolls = $row->Rolls;
            }


            if($Rolls==''){ $Rolls = $this->calulate_max_rolls($manufature."1");}
        }
        return $Rolls;
    }
    function calulate_max_rolls($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MAX(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }
    function calculate_labels_sheets($manufature,$label,$cuslbl=null,$qty=null){
        $qurey = $this->db->query("SELECT Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '".$manufature."' ORDER BY Labels ASC");
        $result = $qurey->result();
        $labelpersheet_is='';
        $label = ($cuslbl !=null)?ceil($cuslbl / $qty):$label;
        foreach($result as $key => $row){
            if($label == $row->Labels){
                $labelpersheet_is = $row->Labels;
            }
            else if(($label > $row->Labels and isset($result[$key+1]->Labels) and $label < $result[$key+1]->Labels)){
                $labelpersheet_is = $result[$key+1]->Labels;
            }
        }
        return $labelpersheet_is;
    }
    function which_group($width, $height){

        $width = $width/1000;
        $height = $height/1000;
        $liner_meter =  $width*$height;
        $table = '';
        $liner_meter = round($liner_meter,4);
        if($liner_meter >= 0.0001 and $liner_meter <= 0.0009 ){
            $table =1;
        }
        else if($liner_meter > 0.0009 and $liner_meter <= 0.0036 ){
            $table =2;
        }
        else if($liner_meter > 0.0036 and $liner_meter <= 0.0078 ){
            $table =3;
        }
        else if($liner_meter > 0.0078 and $liner_meter <= 0.0155 ){
            $table =4;
        }
        else if($liner_meter > 0.0155){
            $table =5;
        }
        return $table;
    }
    function which_material($menfactureid){

        $code = $this->getmaterialcode($menfactureid);

        $query = $this->db->query("SELECT Price FROM `material_prices` WHERE Code LIKE '".$code."' LIMIT 1");
        $row = $query->row_array();
        $price =  $row['Price'];
        if( $price >= 1.3 ){
            $type = 'b';  //high Materials
        }else{
            $type = 'a';  //Low Materials
        }
        return array('price'=>$price,'type'=>$type);

    }
    function calculate_print_material($ManufactureID, $Labels, $finish, $rolls){

        $query = $this->db->query("SELECT Width,Height,category.CategoryID,LabelsPerSheet FROM `products` as p 
		INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID Where ManufactureID LIKE '".$ManufactureID."' ");

        $query = $query->row_array();

        $width  = $query['Width'];
        $height = $query['Height'];
        $max_labels = $query['LabelsPerSheet'];

        $across = $this->get_roll_qty($ManufactureID);

        //$labour_cost = $this->home_model->labour_cost_roll($across, $Labels, $rolls, $max_labels);
        $labour_cost = $this->labour_cost_roll($across, $Labels);

        $por_discount = $this->calculate_discount($Labels, $ManufactureID);

        $discount_percentage = $por_discount['discounts'];
        $por = (100-$por_discount['por'])/100;


        $ManufactureID = substr($ManufactureID,0,-1);

        $material_sqr_cost = $this->material_sqr_cost($ManufactureID);
        $sqaure_meter = ($Labels*($width*$height)/1000000);

        //$sqaure_meter = number_format($sqaure_meter, 1, '.', '');

        $material_cost = ($material_sqr_cost)*$sqaure_meter;

        $ink_cost = $sqaure_meter*1;

        $extra_cost = 0;
        //$por = 0.25;


        $total_cost = ($material_cost+$ink_cost+$labour_cost+$extra_cost);
        $price = $total_cost/$por;
        $discount = $price*($discount_percentage/100);
        $price = $price-$discount;
        $label_finish = 0;

        if($finish == 'Gloss Lamination'){
            $label_finish = (1.04*$sqaure_meter);
            if($label_finish < 10){$label_finish = 10;}
        }
        else if($finish == 'Matt Lamination'){
            $label_finish = (1.6*$sqaure_meter);
            if($label_finish < 10){$label_finish = 10;}
        }
        else if($finish == 'Matt Varnish' || $finish == 'Gloss Varnish' || $finish == 'High Gloss Varnish'){
            $label_finish = (0.25*$sqaure_meter);
            if($label_finish < 10){$label_finish = 10;}
        }

        /******** price uplift ********************************/
        $price = $this->check_price_uplift($price);
        $label_finish = $this->check_price_uplift($label_finish);
        /********************** price uplift **************/



        return array('price'=>$price,'label_finish'=>$label_finish);


        /********************* half price promotion  ***********/
        //$discount_price = ($price*0.25)/2;
        //$price = $price-$discount_price;
        /************************************/

        //$price = $price+$label_finish;

        //return $price;

    }
    function material_sqr_cost($menfactureid){

        $code = $this->getmaterialcode($menfactureid);
        $query = $this->db->query("SELECT PrintPrice FROM `material_prices` WHERE Code LIKE '".$code."' LIMIT 1");
        $row = $query->row_array();
        return $row['PrintPrice'];

    }
    function getmaterialcode($text){

        preg_match('/(\d+)\D*$/', $text, $m);
        $lastnum = $m[1];
        $mat_code = explode($lastnum,$text);
        return strtoupper($mat_code[1]);

    }
    function calculate_discount($labels, $ManufactureID){
        $ManufactureID = substr($ManufactureID,0,-1);
        $labels = $this->labels_discount_breaks($labels);
        $labels = 'labels_'.$labels;

        $discounts = $this->get_db_column('roll_discount_table', $labels, 'manufacture_id', 'all');
        $pors = $this->get_db_column('roll_discount_table', $labels, 'manufacture_id',  $ManufactureID);
        if(empty($pors)){
            $pors = 75;
        }
        $data['por'] = $pors;
        $data['discounts'] = $discounts;
        return $data;
    }
    function get_db_column($table, $column, $key, $value){
        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '".$value."' LIMIT 1 ")->row_array();
        return (isset($row[$column]) and $row[$column]!='')?$row[$column]:'';
    }
    function labour_cost_roll($dieacross, $label){
        $roll_col = 'roll_'.$dieacross;
        $qurey = $this->db->query("SELECT Labels,$roll_col as labour_cost FROM `roll_labour_cost` ORDER BY Labels ASC");
        $result = $qurey->result();
        $labelpersheet_is='';
        $labour_cost = 0.00;
        foreach($result as $key => $row){
            if($label == $row->Labels){
                $labour_cost = $row->labour_cost;
                break;
            }
            else if(($label > $row->Labels and isset($result[$key+1]->Labels) and $label < $result[$key+1]->Labels)){
                $labour_cost = $result[$key+1]->labour_cost;
                //$labour_cost = $row->labour_cost;
                break;
            }
        }
        if(empty($labour_cost)){
            if($label > $result[$key]->Labels){
                $labour_cost = $result[$key]->labour_cost;
            }else{
                $labour_cost = $result[0]->labour_cost;
            }

        }
        return $labour_cost;
    }
    function labels_discount_breaks($labels){

        if($labels <= 100 ){
            $discount_break = 100;
        }
        else if($labels >= 100 and $labels < 150 ){
            $discount_break = 100;
        }
        else if($labels >= 150 and $labels < 200 ){
            $discount_break = 150;
        }
        else if($labels >= 200 and $labels < 250 ){
            $discount_break = 200;
        }
        else if($labels >= 250 and $labels < 300 ){
            $discount_break = 250;
        }
        else if($labels >= 300 and $labels < 350 ){
            $discount_break = 300;
        }
        else if($labels >= 350 and $labels < 400 ){
            $discount_break = 350;
        }
        else if($labels >= 400 and $labels < 450 ){
            $discount_break = 400;
        }
        else if($labels >= 450 and $labels < 500 ){
            $discount_break = 450;
        }
        else if($labels >= 500 and $labels < 1000 ){
            $discount_break = 500;
        }
        else if($labels >= 1000 and $labels < 2000 ){
            $discount_break = 	1000;
        }
        else if($labels >= 2000 and $labels < 3000 ){
            $discount_break	 = 	2000;
        }
        else if($labels >= 3000 and $labels < 4000 ){
            $discount_break  	= 	3000;
        }
        else if($labels >= 4000 and $labels < 5000 ){
            $discount_break	 = 	4000;
        }
        else if($labels >= 5000 and $labels < 7500 ){
            $discount_break	 = 	5000;
        }
        else if($labels >= 7500 and $labels < 10000 ){
            $discount_break	 = 	7500;
        }
        else if($labels >= 10000 and $labels < 15000 ){
            $discount_break	 = 	10000;
        }
        else if($labels >= 15000 and $labels < 20000 ){
            $discount_break	 = 	15000;
        }
        else if($labels >= 20000 and $labels < 30000 ){
            $discount_break	 = 	20000;
        }
        else if($labels >= 30000 and $labels < 40000 ){
            $discount_break	 = 	30000;
        }
        else if($labels >= 40000 and $labels < 50000 ){
            $discount_break  = 	40000;
        }
        else if($labels >= 50000 and $labels < 75000 ){
            $discount_break	= 	50000;
        }
        else if($labels >= 75000 and $labels < 100000 ){
            $discount_break	= 	75000;
        }
        else if($labels >= 100000 and $labels < 150000){
            $discount_break	 = 	100000;
        }
        else if($labels >= 150000 and $labels < 200000){
            $discount_break	 = 	150000;
        }
        else if($labels >= 200000 and $labels < 250000){
            $discount_break	 = 	200000;
        }
        else if($labels >= 250000 and $labels < 300000){
            $discount_break	 = 	250000;
        }
        else if($labels >= 300000 and $labels < 350000){
            $discount_break	 = 	300000;
        }
        else if($labels >= 350000 and $labels < 400000){
            $discount_break	 = 	350000;
        }
        else if($labels >= 400000 and $labels < 450000){
            $discount_break	 = 	400000;
        }
        else if($labels >= 450000 and $labels < 500000){
            $discount_break	 = 	450000;
        }
        else if($labels >= 500000){
            $discount_break	 = 	500000;
        }
        return $discount_break;
    }


    public function get_currecy_options(){
        $sql = $this->db->query("select * from exchange_rates where status LIKE 'active' Order by ID ASC ");
        $sql = $sql->result();
        return $sql;
    }

    function get_exchange_rate($code){

        $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['rate'];
    }

    public function addNewLne($record){
        $params = array('SessionID'=>$this->session->userdata('session_id'),
            'UserID'=>$this->session->userdata('customer_id'),
            'ProductID'=>0,
            'p_code'=>$record['new_line_man'],
            'p_name'=>$record['new_line_des']
            ,'OrderTime'=>date('Y-m-d h:m:i'),
            'Quantity'=>$record['new_line_qty'],
            'orignalQty'=>$record['new_line_price'] * $record['new_line_qty'],
            'LabelsPerRoll'=>'0',
            'OrderData'=>date('Y-m-d'),
            'UnitPrice'=>($record['new_line_price'] / $record['new_line_qty']),
            'TotalPrice'=>($record['new_line_price'] * $record['new_line_qty']),
            'is_custom'=>'No');
        $this->db->insert('temporaryshoppingbasket',$params);
        return $this->db->insert_id();
    }

    public function updateNewLine($record){
        $linePr = $record['update_line_price'];
        $linePr = trim($linePr, '£');
        $linePr = trim($linePr, '€');
        $linePr = trim($linePr, '$');
        $record['update_line_price'] = $linePr;
        
        
        $params = array(
            'UserID'=>$this->session->userdata('customer_id'),
            'ProductID'=>0,
            'p_code'=>$record['update_line_man'],
            'p_name'=>$record['update_line_des']
            ,'OrderTime'=>date('Y-m-d h:m:i'),
            'Quantity'=>$record['update_line_qty'],
            'orignalQty'=>$record['update_line_price'] * $record['update_line_qty'],
            'LabelsPerRoll'=>'0',
            'OrderData'=>date('Y-m-d'),
            'UnitPrice'=>($record['update_line_price'] / $record['update_line_qty']),
            'TotalPrice'=>($record['update_line_price'] * $record['update_line_qty']),
            'is_custom'=>'No');

        $this->db->where('ID',$record['cartId']);
        $this->db->update('temporaryshoppingbasket',$params);
        return ;
    }
	
	function checkwtpDiscount($amount){
    
    $disuntoffer = 0.00;
    $wtp_offer =  $this->quoteModel->check_wtp_offer_voucher();
    if($wtp_offer==true){
							 				
      $disount_applied = $this->quoteModel->check_wtp_voucher_applied($amount);
      if($disount_applied){ 
        $disuntoffer = $disount_applied['discount_offer']; 
      } 
     
    }else{
      $voucher = $this->orderModal->calculate_total_printedroll_amount();
      if($voucher > 0){
        $disuntoffer = $voucher;
      }
    } 
    $disuntoffer = number_format($disuntoffer / 1.2 , 2);
    if($disuntoffer > 0){ $disuntoffer =  $disuntoffer; }else{ $disuntoffer = 0;}
     return $disuntoffer;
  }


}