<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class QuoteModel extends CI_Model {





    public function GetcategoryLabels()
    {

        $query = $this->db->query("SELECT * FROM `category` WHERE `isParent` LIKE 'Yes' AND ( CategoryActive LIKE 'Y' OR displayin = 'backoffice' ) LIMIT 1");
        $query = $query->row_array();
        $sub = $query['SubCategoryID'];
        $sub_array = explode(",",$sub);

        foreach($sub_array as $subCategoryId)
        {
            $query = $this->db->query("SELECT CategoryID,CategoryName FROM `category` WHERE CategoryID ='".$subCategoryId."' AND (CategoryActive LIKE 'Y' OR displayin = 'backoffice' ) order by CategoryName ASC");

            $subCatInfo = $query->row_array();

            if(count($subCatInfo)>0)
            {
                $subCategories[] = array('CategoryID' => $subCatInfo["CategoryID"],'CategoryName'=>$subCatInfo["CategoryName"]);
            }

        }

        return $subCategories;
    }
    public function getProducts($catid)
    {
        $sql = $this->db->query("select SubCategoryID from category where CategoryID = '".$catid."'AND  ( CategoryActive = 'Y' OR displayin = 'backoffice' ) ORDER BY CategoryName ASC");
        $rs = $sql->row_array();

        $getCategories = explode(",",$rs['SubCategoryID']);

        $li ='';
        foreach($getCategories as $subCategoryId)
        {

            if(!empty($subCategoryId))
            {
                $qry = $this->db->query("SELECT * FROM category WHERE ( CategoryActive='Y' OR displayin = 'backoffice' ) AND CategoryID='" .$subCategoryId . "'");
                $subCatInfo = $qry->row_array();
                if(count($subCatInfo)>0)
                {
                    //$li .= '<li id="'.$subCategoryId.'" onClick="getCatproduct(this.id)">'.$subCatInfo['CategoryName'].'</li>';
                    $li .= "<li id=".$subCategoryId." onClick=getCatproduct('".$subCategoryId."','".$catid."')>".$subCatInfo['CategoryName']."</li>";

                }

            }


        }


        return  $li;
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
    public function addToCart($ProductID,$ManufactureID,$Quantity,$cusLbl=null,$conidition = null)
    {

        $prodinfo = $this->orderModal->getproductdetail($ProductID);
        $is_custom = 'No';
        $labelproll=0;

        if(preg_match('/Roll Labels/is',$prodinfo['ProductBrand']))
        {
            $min_qty = $this->quoteModal->get_roll_qty($AccountDetail->ManufactureID);

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

        $UserID = $this->session->userdata('UserID');
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
    public function getDieCode($id){
        return $this->db->query("SELECT * FROM flexible_dies_info where CartID = '".$id."'")->result();
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
 tbl.ManufactureID='".$ManufactureID."' and tbl.BatchID= batch.BatchID ORDER BY batch.BatchQty ASC ");
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
    public function getCountry(){
        $qry = $this->db->query("SELECT * FROM country order by CountryID asc");
        $res = $qry->result_array();
        return $res;
    }
    public function viewCart(){

        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');


        $qry = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

        $res  = $qry->result();

        return $res;
    }


    public function DeletItem($productID,$ID,$qty){
        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');

        $where = "(SessionID = '".$session_id."' OR SessionID='".$cisess_session_id."' ) AND ID = '".$ID."' AND ProductID = '".$productID."' AND `Quantity` = '".$qty."' ";
        $this->db->where($where);
        $this->db->delete('temporaryshoppingbasket');
        // echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function update_printing($update,$ID){

        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');


        $session_id = $this->session->userdata('session_id');
        $where = "(SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND ID = '".$ID."'";
        $this->db->where($where);
        $this->db->update('temporaryshoppingbasket', $update);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
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


    public function UpdateItem($ID=null,$productID=null,$ManufactureID=null,$qty=null, array $condition=null){

        $cookie = @$_COOKIE['ci_session'];
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

            $userID = $this->session->userdata('Order_person');
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

        }
        else if(isset($row['is_custom']) and $row['is_custom']=='Yes'){
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

        }
        else{
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

    public function UpdateWound($ID,$wound){

        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
        $where = "(SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) AND ID = '".$ID."'";
        $this->db->where($where);
        $this->db->update('temporaryshoppingbasket', array('wound' => $wound));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }





    public function getShipcharges($ServiceID,$CountryID)
    {


        $qr = $this->db->query("select * from shippingservices where ServiceID = '".$ServiceID."'");
        $qqr  = $qr->row_array();

        $qrcntry = $this->db->query("select * from country where CountryID = '".$CountryID."'");
        $qqrcntry =	$qrcntry->row_array();

        $charges1 = ($qqr['BasicCharges']+$qqrcntry['ExtraCharges']);


        $chargesDis = round($charges1, 2);
        //$charges = round($chargesDis/vat_rate,2);

        $this->session->unset_userdata('ServiceID');
        $this->session->unset_userdata('CountryID');

        //$this->session->set_userdata("ServiceID",$ServiceID);
        //$this->session->set_userdata("CountryID",$CountryID);

        return $chargesDis;
    }



    //////////////////////////////////////////////////////////////////    CheckOut Page /////////////////////////////////////////////

    public function autofillForm(){


        $searchFields = $this->input->post('searchFields');
        $searchData = $this->input->post('searchData');

        $this->session->set_userdata("searchFields",$searchFields);
        $this->session->set_userdata("searchData",$searchData);

        $this->db->like($searchFields, $searchData);
        $this->db->where('Active', '1');

        $customerInfo = $this->db->get('customers','10','0');

        //$customerInfo = $this->db->get_where('customers',array($searchFields=>$searchData));
        //echo $this->db->last_query();
        return $customerInfo->result();

    }



    public function getQuoteNum() {

        $this->db->select_max('QuotationID');
        $highValue = $this->db->get('quotations')->result();
        $highestValue = $highValue[0]->QuotationID;
        if ($highestValue) {
            $highestValue++;
            $newEntry = array('Quotation' => $highestValue);
            //$this->db->insert('customlabelsnumber', $newEntry);
        }
        return $newEntry['Quotation'];
    }





    public function SaveQuote()
    {

        $currency = currency;
        $exchange_rate  = $this->reportsmodel->get_exchange_rate($currency);
        $plain_label_cust = $this->input->post('plain_label_cust');

        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');


        $qemail = $this->input->post('quotationemail');


        $UserName = $this->session->userdata('UserName');
        $Qshipamount = $this->session->userdata('Qshipamount');
        $Qtotal = $this->session->userdata('Qtotal');
        $VATEXEMPT =  $this->session->userdata('vat_exemption');


        $UserID = $this->input->post('UserID');


        $country     = $this->input->post('country');
        $shipservice = $this->input->post('shippingcharges');
        $QuoteWebsite = $this->input->post('QuoteWebsite');
        $QNo = $this->getQuoteNum();


        if($QuoteWebsite=='123')
        {
            $QuotationNo = '123-'.$QNo;
        }
        else
        {
            $QuotationNo = 'AAQ'.$QNo;
        }

        $this->session->set_userdata("QuotationNo",$QuotationNo);





        /* Billing Form Data */
        $UserEmail = $this->input->post('UserEmail');
        $SecondaryEmail = $this->input->post('SecondaryEmail');

        if(empty($UserEmail))
        {
            $UserEmail = $this->input->post('hideUserEmail');
        }

        $BTitle = $this->input->post('BillingTitle');
        $BFirstName 	= ucfirst($this->input->post('FirstName'));
        $BLastname 		= ucfirst($this->input->post('Lastname'));
        $BAddress1 		= ucfirst($this->input->post('Address1'));
        $BAddress2 		= ucfirst($this->input->post('Address2'));
        $BTownCity 		= ucfirst($this->input->post('TownCity'));
        $BCountryState  = ucfirst($this->input->post('CountryState'));
        $BCompany 		= ucfirst($this->input->post('Company'));
        $Bpcode 		= strtoupper($this->input->post('pcode'));

        $BCountry = $this->input->post('bill_country');
        $BTelephone = $this->input->post('Telephone');
        $Bmobile = $this->input->post('mobile');
        $BFax = $this->input->post('Fax');

        $BbillingResCom = $this->input->post('billingResCom_User');

        /* Delivery Form Data */
        $DTitle 		= $this->input->post('DTitle');
        $DFirstName 	= ucfirst($this->input->post('DFirstName'));
        $DLastname 		= ucfirst($this->input->post('DLastname'));
        $DAddress1 		= ucfirst($this->input->post('DAddress1'));
        $DAddress2 		= ucfirst($this->input->post('DAddress2'));
        $DTownCity 		= ucfirst($this->input->post('DTownCity'));
        $DCountryState  = ucfirst($this->input->post('DCountryState'));
        $DCompany 		= ucfirst($this->input->post('DCompany'));
        $Dpcode 		= strtoupper($this->input->post('Dpcode'));

        $DCountry = $this->input->post('del_country');
        $DTelephone = $this->input->post('DTelephone');
        $Dmobile = $this->input->post('DMobile');
        $DFax = $this->input->post('DFax');

        $DbillingResCom = $this->input->post('DbillingResCom_User');
        $qemail = $this->input->post('quotationemail');
        $purchaseno = $this->input->post('pno');
        $CustomerOrder = $this->input->post('Vat');



        $Customer = array('UserEmail' => $UserEmail,
            'UserName' => $DFirstName,
            'SecondaryEmail'=>$SecondaryEmail,
            'UserPassword' => rand(10, 50),
            'RegisteredDate' => date('Y-m-d'),
            'RegisteredTime' => date('H:i:s'),
            'BillingTitle' => $BTitle,
            'BillingFirstName' => $BFirstName,
            'BillingLastName' => $BLastname,
            'BillingCompanyName' => $BCompany,
            'BillingAddress1' => $BAddress1,
            'BillingAddress2' => $BAddress2,
            'BillingTownCity' => $BTownCity,
            'BillingCountyState' => $BCountryState,
            'BillingPostcode' => $Bpcode,
            'BillingCountry' => $BCountry,
            'BillingTelephone' => $BTelephone,
            'BillingMobile' => $Bmobile,
            'BillingFax' => $BFax,

            'DeliveryTitle' => $DTitle,
            'DeliveryFirstName' => $DFirstName,
            'DeliveryLastName' => $DLastname,
            'DeliveryCompanyName' => $DCompany,
            'DeliveryAddress1' => $DAddress1,
            'DeliveryAddress2' => $DAddress2,
            'DeliveryTownCity' => $DTownCity,
            'DeliveryCountyState' => $DCountryState,
            'DeliveryCountry' 	   => $DCountry,
            'DeliveryPostcode' => $Dpcode,
            'DeliveryTelephone' => $DTelephone,
            'DeliveryMobile'       => $Dmobile,
            'DeliveryFax' => $DFax,
            'Active' =>1
        );



        if( empty($UserID) )
        {
            $this->db->insert('customers', $Customer);

            $rs = $this->db->get_where('customers',array('UserEmail'=>$UserEmail))->result();
            $userid = $rs[0]->UserID;
            $useremail = $rs[0]->UserEmail;
        }
        else
        {
            $userid = $UserID;
        }


        $packupstatus = "6";
        $customerID = $this->db->query("select UserID, total_assigns from customers where UserName like '".$UserName."' and TaxCode LIKE 'callback' ")->row_array();
        $operatorid = (isset($customerID['UserID']) && $customerID['UserID']!='')?$customerID['UserID']:0;

        $Quotation = array(

            'QuotationNumber' => $QuotationNo,
            'SessionID' => $session_id,
            'QuotationDate' => time(),
            'QuotationTime' => time(),
            'UserID' => $userid,
            'QuotationShippingAmount' => $Qshipamount,
            'QuotationTotal' => $Qtotal,
            'CustomOrder'=>$CustomerOrder,

            'BillingTitle' => $BTitle,
            'SecondaryEmail'=>$SecondaryEmail,
            'BillingFirstName' => $BFirstName,
            'BillingLastName' => $BLastname,
            'BillingCompanyName' => $BCompany,
            'BillingAddress1' => $BAddress1,
            'BillingAddress2' => $BAddress2,
            'BillingTownCity' => $BTownCity,
            'BillingCountyState' => $BCountryState,
            'BillingPostcode' => $Bpcode,
            'BillingCountry' => $BCountry,
            'Billingtelephone' => $BTelephone,
            'Billingfax' => $BFax,
            'Billingemail' => $UserEmail,
            'BillingResCom' => $BbillingResCom,

            'DeliveryTitle' => $DTitle,
            'DeliveryFirstName' => $DFirstName,
            'DeliveryLastName' => $DLastname,
            'DeliveryCompanyName' => $DCompany,
            'DeliveryAddress1' => $DAddress1,
            'DeliveryAddress2' => $DAddress2,
            'DeliveryTownCity' => $DTownCity,
            'DeliveryCountyState' => $DCountryState,
            'DeliveryCountry' => $DCountry,
            'DeliveryPostcode' => $Dpcode,
            'Deliverytelephone' => $DTelephone,
            'DeliveryMobile' => $Dmobile,
            'Deliveryfax' => $DFax,
            'DeliveryResCom' => $DbillingResCom,
            'Registered' => 'Yes',
            'QuotationStatus' => '37',
            'ShippingServiceID' => $shipservice,
            'ProcessedBy' => $UserName,
            'Source' => $QuoteWebsite,
            'Q2OStatus'=>$packupstatus,
            'vat_exempt'=>$VATEXEMPT,
            'currency'=>$currency,
            'exchange_rate'=>$exchange_rate,
            'Label'=>$plain_label_cust,
            //'OperatorID'=>$customerID['UserID'],
            'OperatorID'=>$operatorid,
            'CallbackDate'=>time()+86400,
            'callback_status'=>3,
            'order_person'=>$this->session->userdata('Order_person'),
            'ws_applied'=>$this->session->userdata('ws_applied'),
            'user_domain'=>$this->session->userdata('user_domain'),
            'module'=>$this->session->userdata('module')
        );

        $this->db->insert('quotations', $Quotation);

        $this->db->where('UserID', $customerID['UserID']);
        $this->db->update('customers', array('total_assigns'=>$customerID['total_assigns']+1));

        $arrCB = array("OrderNumber"=>$QuotationNo,"Operator"=>$operatorid,"comment"=>"System generated Callback to '".$BFirstName." ".$BLastname."' of reference no '".$QuotationNo."' at ".date("d.m.Y h:i A", time()+86400).".", "remainder"=>time()+86400, "Time"=>time()+86400 );
        $this->db->insert('callback_comment', $arrCB);

        //////////////////  Quotation Detail Insert /////////////////////////////////////////////
        $tempcart =	$this->viewCart();

        foreach( $tempcart as $cartdata)
        {

            $print_type = '';


            $ExVat = round($cartdata->TotalPrice,2);
            $IncVat = round($cartdata->TotalPrice * vat_rate,2);

            $prodinfo = $this->orderModal->getproductdetail($cartdata->ProductID);
            $prodcompletename =  $this->orderModal->customize_product_name($cartdata->is_custom,$cartdata->ProductCategoryName,$cartdata->LabelsPerRoll,$prodinfo['LabelsPerSheet'],$prodinfo['ReOrderCode'],$prodinfo['ManufactureID'],$prodinfo['ProductBrand'],$cartdata->wound,$cartdata->OrderData);

            if($cartdata->ProductID==0){
                $prodcompletename = $cartdata->p_name;
                $p_code=$cartdata->p_code;
            }else{
                $p_code=$prodinfo['ManufactureID'];
            }

            if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand'])){
                $print_type = $cartdata->Print_Type;
            }else{
                $print_type = $cartdata->Print_Type;
            }



            if($p_code=="PRL1"){
                $query = $this->db->query("SELECT SerialNumber from roll_print_basket WHERE id = '$cartdata->ID' ");
                $row = $query->row_array();
                $PRL_detail =  $row['SerialNumber'];
            } else{
                $PRL_detail = "";
            }




            $product = $this->db->query("select * from products where ProductID = '".$cartdata->ProductID."' ")->row_array();
            $orignalQty = $product['LabelsPerSheet'] * $cartdata->Quantity;
            if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand'])){
                $orignalQty = $cartdata->orignalQty;
            }



            if($cartdata->source=='printing' and preg_match('/Roll Labels/is',$prodinfo['ProductBrand'])){

                if($cartdata->wound=='Y' || $cartdata->wound=='Inside'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}
                $labeltype = $this->orderModal->get_printing_service_name($cartdata->Print_Type);
                $productname  = explode("-",$prodinfo['ProductCategoryName']);
                $productname[1] = str_replace("(","",$productname[1]);
                $productname[1] = str_replace(")","",$productname[1]);
                $productname[0] = str_replace("roll labels","",$productname[0]);
                $productname[0] = str_replace("Roll Labels","",$productname[0]);
                $productname = "Printed Labels on Rolls - ".str_replace("roll label","",$productname[0]).' - '.$productname[1];
                $completeName = ucfirst($productname).' '. $wound_opt.' - Orientation '.$cartdata->orientation.', ';
                if($cartdata->FinishType == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
                else{  $labelsfinish = ' With Label finish : '.$cartdata->FinishType; }
                $prodcompletename =$completeName.' '.$labeltype.' '.$labelsfinish;

                $orignalQty = $cartdata->LabelsPerRoll*$cartdata->Quantity;
                if($cartdata->orignalQty !="" && $cartdata->orignalQty !=0){
                    $orignalQty = $cartdata->orignalQty;
                }
            }

            $QDetail =  array('Prl_id' =>$PRL_detail,
                'QuotationNumber' => $QuotationNo,
                'CustomerID' => $userid,
                'ProductID' => $cartdata->ProductID,
                'ManufactureID'=>$p_code,
                'ProductName' => $prodcompletename,
                'Quantity' => $cartdata->Quantity,
                'LabelsPerRoll'=> $cartdata->LabelsPerRoll,
                'orignalQty'=>$orignalQty,
                'is_custom'=> $cartdata->is_custom,
                'Price' => $ExVat,
                'ProductTotalVAT' => $ExVat,
                'ProductTotal' => $IncVat,
                'Printing'=> $cartdata->Printing,
                'Print_Type'=> $print_type,
                'Print_Design'=> $cartdata->Print_Design,
                'Print_Qty'=> $cartdata->Print_Qty,
                'Free'=> $cartdata->Free,
                'Print_UnitPrice'=> $cartdata->Print_UnitPrice,
                'Print_Total'=> $cartdata->Print_Total,
                'colorcode'=> $cartdata->colorcode,
                'active'=>'N',


                'wound'=>$cartdata->wound,
                'Orientation'=>$cartdata->orientation,
                'pressproof'=>$cartdata->pressproof,
                'FinishType'=>$cartdata->FinishType,
                'Product_detail'=>$cartdata->Product_detail,
                'design_service'=>$cartdata->design_service,
                'design_service_charge'=>$cartdata->design_service_charge,
                'design_file'=>$cartdata->design_file
            );



            $this->db->insert('quotationdetails', $QDetail);
            $quote_serail = $this->db->insert_id();
            if($p_code=="SCO1"){
                $this->db->where('CartID',$cartdata->ID);
                $this->db->update('flexible_dies_info',array('QID'=>$quote_serail));
                //$this->customdie_alert($QuotationNo);
            }


            if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand']) || $cartdata->Printing=='Y'){
                if($cartdata->OrderData=='Black' || $cartdata->OrderData=='Printed' || $cartdata->Printing=='Y'){

                    $query = $this->db->query("select count(*) as total from integrated_attachments 
								WHERE ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."' AND status LIKE 'confirm' ");
                    $query = $query->row_array();
                    if($query['total'] > 0){
                        $attach_q = $this->db->query("select * from integrated_attachments WHERE 
									ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."' 
									AND status LIKE 'confirm' ");

                        $attach_q = $attach_q->result();

                        foreach($attach_q  as $int_row){

                            $attach_array = array('QuotationNumber'=>$QuotationNo,
                                'Serial'=>$quote_serail,
                                'ProductID'=>$int_row->ProductID,
                                'file'=>$int_row->file,
                                'diecode'=>$p_code,
                                'status'=>55,
                                'source'=>$int_row->source,
                                'design_type'=>$cartdata->Print_Type,
                                'qty'=>$int_row->qty,
                                'labels'=>$int_row->labels,
                                'name'=>$int_row->name);

                            $this->db->insert('quotation_attachments_integrated',$attach_array);

                        }
                    }
                }
            }


            if($p_code=="SCO1"){


                $this->db->where('CartID',$cartdata->ID);
                $this->db->update('flexible_dies_info',array('QID'=>$quote_serail));
                $flexDetail = $this->db->query("select * from flexible_dies_info where QID = '".$quote_serail."'")->row_array();
                //print_r($flexDetail);exit;
                $dieDetail['die_approve'] = $this->checkPrice($quote_serail);
                $dieDetail['discount'] = $flexDetail['discount'];
                $dieDetail['discount_val'] = $flexDetail['discount_val'];
                $dieDetail['temp_dis'] = $flexDetail['temp_dis'];

                $this->db->where('SerialNumber',$quote_serail);
                $this->db->update('quotationdetails',$dieDetail);
                $this->customdie_alert($QuotationNo);
            }

        }



        ///////////////////////// Tem Cart Empty /////////////////////////////////////////////////////////////
        //mysql_query(" delete from temporaryshoppingbasket where (SessionID = '".session_id()."' OR SessionID = '".$cisess_session_id."')");
        $where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";
        $this->db->where($where);
        $this->db->delete('temporaryshoppingbasket');


        $check = $this->db->query("select count(*) as total from quotationdetails where ManufactureID LIKE 'SCO1' and  QuotationNumber LIKE '".$QuotationNo."'")->row_array();
        $customdiecheck = $check['total'];
        if($customdiecheck>0){
            $this->customdie_alert($QuotationNo);
        }

        // $this->quote_added($QuotationNo);
        $rs = array('status'=>($this->db->affected_rows() > 0) ? TRUE : FALSE,'qemail'=>$qemail);

        return $rs;
    }
    public function checkPrice($serial){
        $flxDieInfo = $this->db->query("select ID,CartID,shape from flexible_dies_info where QID = '".$serial."'")->row_array();
        $tempShoping = $this->db->query("select * from temporaryshoppingbasket where ID = '".$flxDieInfo['CartID']."'")->row_array();
        $this->db->insert('flexible_pricing',array('serial'=>$serial,'Operator'=>616100,'supplier'=>'custom_die','price'=>$tempShoping['TotalPrice'],'sprice'=>$tempShoping['TotalPrice'],'status'=>'1'));
        $flxDieMats = $this->db->query("SELECT COUNT(ID) as count FROM flexible_dies_mat WHERE plainprice =0 and OID = '".$flxDieInfo['ID']."'")->result();
        $materials = $this->db->query("SELECT COUNT(ID) as material FROM flexible_dies_mat WHERE OID = '".$flxDieInfo['ID']."'")->result();
        // print_r($materials);exit;


        if($flxDieInfo['shape'] !='Irregular'){
            if($materials[0]->material >0){
                if(($flxDieMats[0]->count >0))
                {
                    return 'N';
                }
                else{
                    return 'Y';
                }
            }

            else{
                if($tempShoping['TotalPrice'] >0){
                    return 'Y';
                }else{
                    return 'N';
                }

            }
        }else{
            return 'N';
        }


    }

    function customdie_alert($Quotation){
        $body = 'A Custom Die has been added against quotation no '.$Quotation.'. Please Review Backoffice for further Instructions.';

        $this->load->library('email');
        $this->email->initialize(array('mailtype' =>'html',));
        $this->email->subject('Custom-Die');
        $this->email->from('customercare@aalabels.com','Aalabels');
        $this->email->to("data.aalabels@gmail.com,steve@aalabels.com");
        $this->email->cc("kami.ramzan77@gmail.com");
        $this->email->message($body);
        $this->email->send();
    }


    function quote_added($Quotation){
        $body = 'A quotation no '.$Quotation.'. has been placed.';

        $this->load->library('email');
        $this->email->initialize(array('mailtype' =>'html',));
        $this->email->subject('Quotation');
        $this->email->from('customercare@aalabels.com','Aalabels');
        $this->email->to("kami.ramzan77@gmail.com");
        $this->email->message($body);
        $this->email->send();
    }



    public function quoteDetails($quoteID) {

        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }

        $query = $this->db->get_where('quotationdetails', array('QuotationNumber' => $quoteID));
        return $query->result();
    }

    public function quoteInfo($quoteID) {
        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }
        $query = $this->db->get_where('quotations', array('QuotationNumber' => $quoteID));
        return $query->result();
    }


    public function changestatus($id,$update){


        $this->db->where('QuotationID',$id);
        $this->db->update('quotations',$update);

    }
    public function statusdropdowna($in_array)
    {
        $query ="select * from dropshipstatusmanager where StatusID IN ($in_array) order by SortID asc";
        $row =$this->db->query($query);
        return $row->result();

    }
    public function statusdropdown($id)
    {
        if($id==37){
            $in_array = "37,39,17,23,56,62";
        }else if($id==10){

            $in_array = "10,34";
        }else{
            $in_array = "37,39,17,23,56,62";
        }
        $row = $this->statusdropdowna($in_array);

        foreach ($row  as $row){

            $option[$row->StatusID] = $row->StatusTitle;
        }
        return $option;
    }
    public function addquotedetail($insert)
    {
        $this->db->insert('quotationdetails',$insert);
    }


    public function updatequoteitem($id,$update){

        $this->db->where('SerialNumber',$id);
        $this->db->update('quotationdetails',$update);
        $this->updatequotetotal($id);

    }
    public function updatequotetotal($id)
    {
        $quoteNo = $this->db->select('QuotationNumber')->get_where('quotationdetails', array('SerialNumber' => $id));
        $quoteNo = $quoteNo->result();
        $quoteNo = $quoteNo[0]->QuotationNumber;

        $quotetotal = $this->db->select_sum('ProductTotal')->get_where('quotationdetails', array('QuotationNumber' => $quoteNo));
        $quotetotal = $quotetotal->result();
        $quotetotal = $quotetotal[0]->ProductTotal;

        $quoteprint = $this->db->select_sum('Print_Total')->get_where('quotationdetails', array('QuotationNumber' => $quoteNo));
        $quoteprint = $quoteprint->result();
        $quoteprint = $quoteprint[0]->Print_Total;

        $quotetotal = $quotetotal + ($quoteprint * 1.2);

        $shiptotal =$this->db->select('QuotationShippingAmount,vat_exempt')->get_where('quotations', array('QuotationNumber' => $quoteNo));
        $shiptotal = $shiptotal->result();
        $shiptotal = $shiptotal[0]->QuotationShippingAmount;

        $integrated = $this->quoteModel->is_quotation_integrated($quoteNo);
        if($integrated > 0){
            $shiptotal = $this->delivery_quotation_integrated($quoteNo);
        }


        $quotetotal_amount = number_format($quotetotal + $shiptotal,'2','.','');


        $update =  array('QuotationTotal' =>$quotetotal_amount,'QuotationShippingAmount' =>$shiptotal);
        $this->db->where('QuotationNumber',$quoteNo);
        $this->db->update('quotations',$update);
    }



    //************************************//**************************************//

    //function delivery_quotation_integrated($quoteNo){
//        $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `quotationdetails` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and QuotationNumber LIKE '".$quoteNo."' ")->row_array();
//
//        $country_code = $this->quoteModel->get_db_column('quotations','DeliveryCountry', 'QuotationNumber', $quoteNo);
//        $dpd = $this->quoteModel->get_integrated_delivery($int_sheets['qty'],$country_code);
//        $dpd = $dpd['dpd'];
//        $productid = $int_sheets['ProductID'];
//        $intdata['BasicCharges'] += $dpd;
//        if($int_sheets['qty'] == '' || $int_sheets['ProductID'] == ''){
//            $intdata['BasicCharges'] -= $dpd;
//        }
//
//        $delivery_exvat  = $delivery_exvat  + $intdata['BasicCharges'];
//        $delivery_incvat = $delivery_exvat*1.2;
//        return $delivery_incvat;
//    }

      function delivery_quotation_integrated($quoteNo){
		$intdata = 0;
		$delivery_exvat = 0;
		
        $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `quotationdetails` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and QuotationNumber LIKE '".$quoteNo."' ")->row_array();

        $country_code = $this->quoteModel->get_db_column('quotations','DeliveryCountry', 'QuotationNumber', $quoteNo);
        $dpd = $this->quoteModel->get_integrated_delivery($int_sheets['qty'],$country_code);
        $dpd = $dpd['dpd'];
        $productid = $int_sheets['ProductID'];
        $intdata += $dpd;
        if($int_sheets['qty'] == '' || $int_sheets['ProductID'] == ''){
            $intdata -= $dpd;
        }

        $delivery_exvat  = $delivery_exvat  + $intdata;
        $delivery_incvat = $delivery_exvat*1.2;
        return $delivery_incvat;
    }
    
    function is_quotation_integrated($quoteNo){
        $result = $this->db->query("select COUNT(*) as total from quotationdetails temp JOIN products pro on temp.ProductID = pro.ProductID WHERE temp.QuotationNumber LIKE '".$quoteNo."' AND pro.ProductBrand = 'Integrated Labels'");
        $row = $result->row_array();
        return $row['total'];
    }

    //************************************//**************************************//




    public function deletequoteitem($id){
        $quoteNo = $this->db->select('QuotationNumber')->get_where('quotationdetails', array('SerialNumber' => $id));
        $quoteNo = $quoteNo->result();
        $quoteNo = $quoteNo[0]->QuotationNumber;

        $this->db->where('SerialNumber',$id);
        $this->db->delete('quotationdetails');

        $quotetotal = $this->db->select_sum('ProductTotal')->get_where('quotationdetails', array('QuotationNumber' => $quoteNo));
        $quotetotal = $quotetotal->result();
        $quotetotal = $quotetotal[0]->ProductTotal;
        $shiptotal =$this->db->select('QuotationShippingAmount')->get_where('quotations', array('QuotationNumber' => $quoteNo));
        $shiptotal = $shiptotal->result();
        $shiptotal = $shiptotal[0]->QuotationShippingAmount;
        $quotetotal_amount = number_format($quotetotal + $shiptotal,'2','.','');
        $update =  array('QuotationTotal' =>$quotetotal_amount);
        $this->db->where('QuotationNumber',$quoteNo);
        $this->db->update('quotations',$update);

    }


    public function saveorder($quoteID,$paymentmethod)
    {

        $order_detail = $this->quoteModel->quoteDetails111($quoteID);
        $order = $this->quoteModel->quoteInfo($quoteID);
        $OrdWebsite = $this->input->post('QuoteWebsite');

        $OrdNo = $this->orderModal->getOrderNum();
        if($OrdWebsite=='123')
        {
            $orderNo = '123-'.$OrdNo;
        }
        else
        {
            $orderNo = 'AA'.$OrdNo;
        }
        $this->session->set_userdata("OrderNo",$orderNo);
        if($order[0]->Billingmobile==NULL){$order[0]->Billingmobile='';}
        if($order[0]->Billingtelephone==NULL){$order[0]->Billingtelephone='';}
        if($order[0]->Billingfax==NULL){$order[0]->Billingfax='';}
        if($order[0]->Billingemail==NULL){$order[0]->Billingemail='';}
        if($order[0]->DeliveryTelephone==NULL){$order[0]->DeliveryTelephone='';}
        if($order[0]->DeliveryMobile==NULL){$order[0]->DeliveryMobile='';}
        if($order[0]->DeliveryFax==NULL){$order[0]->DeliveryFax='';}
        if($order[0]->Deliveryemail==NULL){$order[0]->Deliveryemail='';}
        if($order[0]->BillingAddress2==NULL){$order[0]->BillingAddress2='';}
        if($order[0]->DeliveryAddress2==NULL){$order[0]->DeliveryAddress2='';}




        $wtp_discount = $this->wtp_discount_applied_on_order();
        $rollvoucher = $this->quoteModel->calculate_total_printedroll_amount($quoteID);

        if($wtp_discount){
            $discount_offer = $wtp_discount['discount_offer'];
            $Ordtotal = $order[0]->QuotationTotal - $wtp_discount['discount_offer'];
            $voucherOfferd = 'Yes';
            $del = $this->db->delete('voucherofferd_temp', array('SessionID' => $session_id));

        }
        else if($rollvoucher > 0){
            $discount_offer = $rollvoucher;
            $Ordtotal = $order[0]->QuotationTotal-$discount_offer;
            $voucherOfferd = 'Yes';
        }
        else{

            $discount_offer = 0.00;
            $voucherOfferd = 'No';
            $Ordtotal = $order[0]->QuotationTotal;
        }

        $lastorder = $this->last_order($order[0]->UserID);
        $lastorder = (isset($lastorder) && $lastorder['OrderNumber']!='')?$lastorder['OrderNumber']:'FIRST';



        $insert = array(
            'OrderNumber'   => $orderNo,
            'SessionID'     =>$this->session->userdata('session_id'),
            'OrderDate'     =>  time(),
            'OrderTime'     =>  time(),
            'UserID'        =>  $order[0]->UserID,
            'DeliveryStatus' =>'',
            'PaymentMethods'    =>$paymentmethod,
            'OrderShippingAmount' =>$order[0]->QuotationShippingAmount,
            'OrderTotal'          =>$Ordtotal - $order[0]->QuotationShippingAmount,
            'BillingTitle'        =>$order[0]->BillingTitle,
            'BillingFirstName'    =>$order[0]->BillingFirstName,
            'BillingLastName'     =>$order[0]->BillingLastName,
            'BillingCompanyName'  =>$order[0]->BillingCompanyName,
            'BillingAddress1'     =>$order[0]->BillingAddress1,
            'BillingAddress2'     =>$order[0]->BillingAddress2,
            'BillingTownCity'     =>$order[0]->BillingTownCity,
            'BillingCountyState'  =>$order[0]->BillingCountyState,
            'BillingPostcode'    =>$order[0]->BillingPostcode,
            'BillingCountry'     =>$order[0]->BillingCountry,
            'Billingtelephone'   =>$order[0]->Billingtelephone,
            'Billingmobile'      =>$order[0]->Billingmobile,
            'Billingfax'         =>$order[0]->Billingfax,
            'SecondaryEmail'     =>$order[0]->SecondaryEmail,
            'Billingemail'       =>$order[0]->Billingemail,
            'BillingResCom'		=>$order[0]->BillingResCom,
            'DeliveryTitle'      =>$order[0]->DeliveryTitle,
            'DeliveryFirstName'      =>$order[0]->DeliveryFirstName,
            'DeliveryLastName'       =>$order[0]->DeliveryLastName,
            'DeliveryCompanyName'    =>$order[0]->DeliveryCompanyName,
            'DeliveryAddress1'           =>$order[0]->DeliveryAddress1,
            'DeliveryAddress2'   	  =>$order[0]->DeliveryAddress2,
            'DeliveryTownCity'    =>$order[0]->DeliveryTownCity,
            'DeliveryCountyState'    =>$order[0]->DeliveryCountyState,
            'DeliveryPostcode'          =>$order[0]->DeliveryPostcode,
            'DeliveryCountry'   	 =>$order[0]->DeliveryCountry,
            'Deliverytelephone'   	 =>$order[0]->Deliverytelephone,
            'DeliveryMobile'   	  =>$order[0]->DeliveryMobile,
            'Deliveryfax'   	  =>$order[0]->Deliveryfax,
            'Deliveryemail'   	 =>$order[0]->Deliveryemail,
            'DeliveryResCom'	=>$order[0]->DeliveryResCom,
            'Registered'             =>'Yes',
            'CustomOrder'        =>$order[0]->CustomOrder,
            'ShippingServiceID'  =>$order[0]->ShippingServiceID,
            'printPicked'       =>'No',
            'PurchaseOrderNumber'   =>'',
            'YourRef'   =>'',
            'PackID'    =>'',
            'Source'    =>'Q-'.$order[0]->ProcessedBy,
            'Domain'         =>$OrdWebsite,
            'vat_exempt'	 =>$order[0]->vat_exempt,
            'currency'	     =>$order[0]->currency,
            'exchange_rate'	 =>$order[0]->exchange_rate,
            'ContactPerson'  =>$order[0]->UserID,
            'OrderStatus'    =>$order[0]->Q2OStatus,
            'Label'    =>$order[0]->Label,
            'site'    =>$order[0]->site,
            'voucherOfferd'  => $voucherOfferd,
            'voucherDiscount'=>$discount_offer, );
        $this->db->insert('orders',$insert);

        foreach($order_detail as $order_detail){
            $sno = $order_detail->SerialNumber;
            $Print_Type = $order_detail->Print_Type;

            $prodinfo = $this->orderModal->getproductdetail($order_detail->ProductID);
            if(preg_match('/Integrated Labels/',$prodinfo['ProductBrand'])){
                $extra_int_text = ($order_detail->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)";
                $order_detail->ProductName.= $extra_int_text;
            }



            $insert_detail= array(
                'OrderNumber'   	 =>$orderNo,
                'UserID'   	 =>$order_detail->CustomerID,
                'labels' => $order_detail->orignalQty,
                'ProductID'   	 =>$order_detail->ProductID,
                'ManufactureID'  => $order_detail->ManufactureID,
                'ProductName'   	 =>$order_detail->ProductName,
                'Quantity'   	 =>$order_detail->Quantity,
                'LabelsPerRoll'=> $order_detail->LabelsPerRoll,
                'is_custom'=> $order_detail->is_custom,
                'Price'   	 =>$order_detail->ProductTotalVAT,
                'ProductTotalVAT' =>$order_detail->ProductTotalVAT,
                'ProductTotal'   	=>$order_detail->ProductTotal,
                'Printing'=> $order_detail->Printing,
                'Print_Type'=> $Print_Type,
                'Print_Design'=> $order_detail->Print_Design,
                'Print_Qty'=> $order_detail->Print_Qty,
                'Free'=> $order_detail->Free,
                'Print_UnitPrice'=> $order_detail->Print_UnitPrice,
                'Print_Total'=> $order_detail->Print_Total,
                'Prl_id'=>$order_detail->Prl_id,
                'old_product'=>$this->is_backoffice_product($order_detail->ProductID),
                'colorcode'=>$order_detail->colorcode,

                'Wound'=>$order_detail->wound,
                'Orientation'=>$order_detail->Orientation,
                'pressproof'=>$order_detail->pressproof,
                'FinishType'=>$order_detail->FinishType,
                'Product_detail'=>$order_detail->Product_detail,
                'design_service'=>$order_detail->design_service,
                'design_service_charge'=>$order_detail->design_service_charge,
                'design_file'=>$order_detail->design_file
            );

            if($order_detail->ManufactureID=='AADS001'){
                $insert_detail = array_merge($insert_detail, array('ProductionStatus'=>3,'ProductOption'=>$order_serail));
            }else if($order_detail->ManufactureID=='SCO1'){
                $insert_detail = array_merge($insert_detail, array('machine'=>'die'));
            }

            $this->db->insert('orderdetails',$insert_detail);
            $order_serail = $this->db->insert_id();


            //******___________*********
            $cuspriceincvat = 0;
            if($order_detail->ManufactureID == 'SCO1'){
                $custom_die = array(
                    'OrderNumber'=>$orderNo,
                    'SerialNumber'=>$order_serail,
                    'diecode'=>$order_detail->ManufactureID,
                    'Time'=>time(),
                    'Status'=>37,
                    'SA'=>0,'CA'=>0,'OD'=>0,'S_SA'=>0,'OL'=>0,'version'=>1,'type'=>'custom'
                );
                $this->db->insert('flexible_dies',$custom_die);

                $this->db->where('QID',$order_detail->SerialNumber);
                $this->db->update('flexible_dies_info',array('OID'=>$order_serail));


                $custominfo = $this->quoteModel->fetch_custom_die_order($order_serail);
                $cuspriceexvat = $this->quoteModel->calculateamountmaterils($custominfo['ID']);
                if(isset($cuspriceexvat)){
                    $cuspriceincvat = $cuspriceexvat*1.2;
                }

            }
            //******___________*********

            if( $order_detail->Printing=='Y'){
                $artowrks = $this->quoteModel->get_printed_files($order_detail->SerialNumber);
                if(count($artowrks) > 0){
                    foreach($artowrks  as $int_row){
                        $brand = $this->is_ProductBrand_roll($order_detail->ManufactureID);
                        $brand = $this->orderModal->make_productBrand_condtion($brand['ProductBrand']);

                        $attach_array = array('OrderNumber'=>$orderNo,
                            'Serial'=>$order_serail,
                            'ProductID'=>$order_detail->ProductID,
                            'diecode'=>$order_detail->ManufactureID,
                            'file'=>$int_row->file,
                            'status'=>64,
                            'Brand'=>$brand,
                            'source'=>$int_row->source,
                            'design_type'=>$int_row->design_type,
                            'qty'=>$int_row->qty,
                            'labels'=>$int_row->labels,
                            'name'=>$int_row->name,
                            'CO' =>1,
                            'version' =>1);
                        $this->db->insert('order_attachments_integrated',$attach_array);
                    }
                }
            }




            $printingtotal = $order_detail->Print_Total * 1.2;
            $ordergrandtotal = $printingtotal + $order_detail->ProductTotal + $cuspriceincvat;
            $totally +=$ordergrandtotal;
            $this->db->query("update quotationdetails set active ='c' where SerialNumber = '$sno'");
        }

        $this->db->where('OrderNumber',$orderNo)->update('orders',array('OrderTotal'=>$totally));


        $query = $this->db->query("Select count(*) as total from quotationdetails WHERE active = 'N'  AND QuotationNumber LIKE '".$quoteID."'");
        $row = $query->row_array();
        if($row['total'] == 0){
            $update_status = array(
                'QuotationStatus' => 13,
            );
        }else{
            $update_status = array(
                'QuotationStatus' => 8,
            );
        }


        $this->db->where('QuotationNumber',$quoteID)
            ->update('quotations',$update_status);

        $quoteto_order = array(
            'QuotationNumber' =>$quoteID,
            'OrderNumber' =>$orderNo
        );
        $this->db->insert('quotation_to_order',$quoteto_order);

        $check = $this->db->query("select count(*) as total from orderdetails where ManufactureID LIKE 'SCO1' and  OrderNumber LIKE '".$orderNo."'")->row_array();
        $customdiecheck = $check['total'];
        if($customdiecheck>0){
            $this->customdie_order_alert($orderNo);
        }



        return $orderNo;
    }

    function is_backoffice_product($productid){
        $row = $this->db->query("SELECT displayin FROM  `products` WHERE  ProductID LIKE '".$productid."' ")->row_array();
        return (isset($row['displayin']) and $row['displayin']=='backoffice')?1:0;
    }


    function customdie_order_alert($orderNo){
        $body = 'Order No '.$orderNo.' with custom die is generated. Please Review Backoffice for further Instructions.';
        $this->load->library('email');
        $this->email->initialize(array('mailtype' =>'html',));
        $this->email->subject('Custom-Die Order');
        $this->email->from('customercare@aalabels.com','Aalabels');
        $this->email->to("steve@aalabels.com");
        $this->email->cc("kami.ramzan77@gmail.com");
        $this->email->message($body);
        $this->email->send();
    }
    /*----------------------ROLL Price Formula Start-------------------------------*/


    function calculateamountmaterils($id){
        $query = $this->db->query("select SUM(plainprice+printprice) as price from flexible_dies_mat where OID = $id")->row_array();
        return $query['price'];
    }


    function is_ProductBrand_roll($id){

        $query=$this->db->query("select  ProductBrand,LabelsPerSheet from products  where ManufactureID='".$id."'");
        $res=$query->row_array();

        if(preg_match("/Roll Labels/i",$res['ProductBrand'])){
            $roll = 'yes';
        }else{ $roll = 'No';}
        return array('Roll'=>$roll,'LabelsPersheet'=>$res['LabelsPerSheet'],'ProductBrand'=>$res['ProductBrand']);

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





    function calculate_por($menucode, $table,$rolls,$labels){
        $field = 'Labels_'.$labels;
        $query =    $this->db->query("Select $field from tbl_batch_roll INNER JOIN $table  
						  ON tbl_batch_roll.batch_id=$table.batch_id WHERE ManufactureID LIKE '".$menucode."' AND tbl_batch_roll.Rolls = $rolls ");
        $row = $query->row_array();
        return $row[$field];
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
    function getmaterialcode($text){

        preg_match('/(\d+)\D*$/', $text, $m);
        $lastnum = $m[1];
        $mat_code = explode($lastnum,$text);
        return strtoupper($mat_code[1]);

    }



    function calculate_material($ManufactureID,$Labels,$Rolls,$custLbl=null,$qty=null){

        $query = $this->db->query("SELECT Width,Height FROM `products` as p INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID Where ManufactureID LIKE '".$ManufactureID."' ");
		//echo $this->db->last_query();
		

        $query = $query->row_array();
        
       //echo  print_r($query);

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


    function min_roll_price($manufature1,$Roll,$labels,$custLbl=null,$qty=null){
        $manufature = substr($manufature1,0,-1);
        $price = $this->calclateprice($manufature1,$Roll,$labels,$custLbl,$qty);
        return $price['final_price'];
    }

    function calulate_min_rolls($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }
    function calulate_max_rolls($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MAX(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }

    function min_qty_roll($catid){
        $query = $this->db->query("SELECT ManufactureID FROM `products` WHERE `CategoryID` LIKE '".$catid."%' AND (Activate LIKE 'Y' OR displayin = 'backoffice') LIMIT 1");
        $query = $query->row_array();
        $manufature = substr($query['ManufactureID'],0,-1);

        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND (Active LIKE 'Y') ");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }

    function get_roll_qty($manufature1){

        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` Where ManufactureID LIKE '".$manufature."' AND (Active LIKE 'Y' )");
        $roll = $roll->row_array();
        if(isset($roll['Rolls']) and $roll['Rolls'] > 0){
            return  $roll['Rolls'];
        }else { return 0;}


    }

    function get_roll_against($manufature){
        $manufature = substr($manufature,0,-1);
        $qurey = $this->db->query("SELECT Rolls FROM tbl_batch_roll WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $result = $qurey->result();
        return  $result;
    }
    function calculate_labels_sheets($manufature,$label,$cuslbl=null,$qty=null){
        $qurey = $this->db->query("SELECT Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '".$manufature."' ORDER BY Labels ASC");
        //echo $this->db->last_query();
        $result = $qurey->result();
        
        //echo '<pre>'; print_r($result);
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





    /*----------------------ROLL Price Formula End-------------------------------*/

    public function addToQuotation($ProductID,$ManufactureID,$Quantity,$quoteID,$CustomerID,$Wound,$printed=NULL)
    {
        $printtype = ''; $colors = '';

        $prodinfo = $this->orderModal->getproductdetail($ProductID);
        $iscustom = 'No';
        if(preg_match('/Roll Labels/is',$prodinfo['ProductBrand']))
        {
            $min_qty = $this->quoteModel->get_roll_qty($AccountDetail->ManufactureID);

            if( $Quantity < $min_qty)
            {
                $Quantity = $min_qty;
            }
            $iscustom = 'Yes';
        }
        else if(preg_match('/A3 Label/i',$prodinfo['ProductBrand']))
        {
            if($Quantity < 100)
            {
                $Quantity = 100;
            }
        }
        else if(preg_match('/SRA3 Label/',$prodinfo['ProductBrand']))
        {
            if($Quantity < 100)
            {
                $Quantity = 100;
            }
        }
        else if(preg_match('/Application Labels/',$prodinfo['ProductBrand'])){
            $colors = $this->get_color_option($prodinfo['CategoryID']);
            if($colors==1){ $colorcode = 'Black';}
            if($Quantity < 1) {
                $Quantity = 1;
            }
        }
        else if(preg_match("/Integrated Labels/i",$prodinfo['ProductBrand'])){

            if($Quantity < 99){ $Quantity = 100;}
        } else{


            if(substr($ManufactureID,-2,2)=='XS'){
                $Quantity =  $this->special_xmass_qty($Quantity);
            }
            else{
                if($Quantity < 25){
                    $Quantity = 25;
                }
            }
        }

        if(preg_match("/Integrated Labels/i",$prodinfo['ProductBrand'])){
            $newqty = $this->quoteModel->calculate_integrated_qty($ManufactureID,$Quantity);
            $price = $this->quoteModel->single_box_price($ManufactureID,$newqty);
            if(preg_match("/printed/is",$printed)){
                $print_price =  $this->quoteModel->calculate_integrated_printing($Quantity);
                $total =   $print_price['PrintPrice']+$price['PlainPrice'];
                $printtype ='Printed';
            }
            else if(preg_match("/black/is",$printed)){
                $print_price =  $this->quoteModel->calculate_integrated_printing($Quantity);
                $total = $print_price['BlackPrice']+$price['PlainPrice'];
                $printtype ='Black';
            }
            else{
                $total = $price['PlainPrice'];
                $printtype ='Plain';
            }
            $custom_price = $total;

        }else{
            //$custom_price = $this->getPrize($Quantity,$ManufactureID);

            /*****************WPEP Offer************/
            $wpep_discount = 0.00;
            $custom_price = $this->getPrize($Quantity,$ManufactureID);
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


        }

        $ProdName = $this->orderModal->customize_product_name('',$prodinfo['ProductCategoryName'],'',$prodinfo['LabelsPerSheet'],$prodinfo['ReOrderCode'],$ManufactureID,$prodinfo['ProductBrand'],$Wound,$printtype);


        $ExVat = round($custom_price,2).'<br>';
        $IncVat = round($custom_price * vat_rate,2);
        $quotationData = array( 'QuotationNumber' => $quoteID,
            'CustomerID'  	  => $CustomerID,
            'ProductID'  	  => $ProductID,
            'ManufactureID'   => $ManufactureID,
            'ProductName'  	  => $ProdName,
            'Quantity'  	  => $Quantity,
            'Price' 		  => $custom_price,
            'ProductTotalVAT' => $ExVat,
            'ProductTotal'	  => $IncVat,
            'Print_Type'=>$printtype,
            'colorcode'=>$colors,
            'is_custom'=>$iscustom
        );
        $this->db->insert('quotationdetails', $quotationData);



        $subTotal_XVAT = 0;
        $subTotal_IVAT = 0;
        $sql = $this->db->get_where('quotationdetails',array('QuotationNumber'=>$quoteID,'CustomerID'=>$CustomerID))->result_array();

        foreach($sql as $data)
        {
            $subTotal_XVAT += $data['ProductTotalVAT'];
            $subTotal_IVAT += ($data['ProductTotalVAT'] * vat_rate);
        }


        $rs = $this->db->get_where('quotations',array('QuotationNumber'=>$quoteID))->row_array();


        if( ($rs['ShippingServiceID'] != '20' && $subTotal_XVAT < 25.00) || ($rs['ShippingServiceID'] != '20' && $subTotal_XVAT > 25.00))
        {

            $qr = $this->db->query("select BasicCharges from shippingservices where ServiceID = '".$rs['ShippingServiceID']."'");
            $qrs  = $qr->row_array();
            $TotalIVAT = round($subTotal_IVAT + $qrs['BasicCharges'],2);
            $shipingchargs = $qrs['BasicCharges'];


        }
        else if(($rs['ShippingServiceID'] == '20' && $subTotal_XVAT < 25.00))
        {

            $shipingchargs = 6.00;
            $TotalIVAT = round($subTotal_IVAT + $shipingchargs,2);
        }
        else
        {
            $TotalIVAT = round($subTotal_IVAT,2);
            $shipingchargs = 0.00;
        }

        $quoteData=array('QuotationShippingAmount' => $shipingchargs,'QuotationTotal' => $TotalIVAT);
        $this->db->where('QuotationNumber',$quoteID);
        $this->db->update('quotations',$quoteData);


        return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    /*********** Integrated Prices start **********/
    function integrated_batch_qty($menuid){

        $query =   $this->db->query("select tbl.ManufactureID,tbl.SheetPrice,batch.BatchQty,tbl.DiscountPercent from 
					   tbl_product_batchprice tbl,tbl_batch batch where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID ORDER BY batch.BatchQty Asc ");
        return $query->result();
    }
    //function single_box_price($menuid, $qty){
//			$query =   $this->db->query("select tbl.SheetPrice as PlainPrice from
//			tbl_product_batchprice tbl,tbl_batch batch where tbl.ManufactureID='$menuid' and batch.BatchQty='$qty'  and tbl.BatchID= batch.BatchID
//			ORDER BY batch.BatchQty Asc ");
//			$row = $query->row_array();
//			$row['PlainPrice'] = $total_price = $this->check_price_uplift($row['PlainPrice']);
//			return $row;
//	}


    function single_box_price($menuid,$qty,$batch = 250){

        $return = array();
        $qurey = $this->db->query("SELECT Distinct(`Sheets`) FROM `integrated_labels_prices` where ManufactureID ='$menuid'  ORDER BY sheets ASC");
        $result = $qurey->result();
        $user_qty = $qty;
        foreach($result as $key => $row){
            if($qty<=249){
                $qty = $row->Sheets;
            }
            else if($qty == $row->Sheets){
                $qty = $row->Sheets;
            }
            else if(($qty > $row->Sheets and isset($result[$key+1]->Sheets) and $qty < $result[$key+1]->Sheets)){
                $qty = $row->Sheets;
            }
            else if($qty>100000){
                $qty = 100000;
            }
        }
        $cond = '';
        $query = $this->db->query("select *,Price_$batch as PlainPrice, Box_$batch as Box from integrated_labels_prices where ManufactureID ='$menuid' and Sheets = '$qty'");

        $return = $query->row_array();
        //$delivery_charges = $this->get_integrated_delivery($qty);
        //$return = array_merge($delivery_charges,$return);
        return $return;
    }


    function for_integrate($cat){
        $query=$this->db->query("SELECT * FROM products p inner join category c  on p.CategoryID = c.CategoryID  WHERE p.CategoryID = '$cat' and (p.Activate='Y'  OR p.displayin = 'backoffice'  ) ");
        return $query->result();
    }
    function min_qty_integrated($menuid){
        $query =   $this->db->query("select MIN(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 
		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");
        $row = $query->row_array();
        return $row['qty'];
    }
    function max_qty_integrated($menuid){
        $query =   $this->db->query("select MAX(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 
		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");
        $row = $query->row_array();
        return $row['qty'];
    }

    function calculate_integrated_printing($qty){

        $query =   $this->db->query("select * from tbl_print_prices Order by  sheets ASC ");
        $result = $query->result();
        foreach($result as $key => $row){
            if($qty == $row->sheets){

                $multiple = $row->sheets/100;
                $black_price = $row->black_price;
                $color_price = $row->color_price;
            }
            else if(($qty > $row->sheets  and isset($result[$key+1]->sheets ) and $qty < $result[$key+1]->sheets )){
                //$sheets = $row->BatchQty;
                $multiple = $result[$key+1]->sheets/100;
                $black_price = $result[$key+1]->black_price;
                $color_price = $result[$key+1]->color_price;
            }
            else if(($qty > 20000 )){
                $multiple = $qty/100;
                $black_price = $row->black_price;
                $color_price = $row->color_price;
            }
        }

        $BlackPrice = $this->check_price_uplift($black_price*$multiple);
        $PrintPrice = $this->check_price_uplift($color_price*$multiple);
        return array('BlackPrice'=>$BlackPrice,'PrintPrice'=>$PrintPrice);

    }



    function calculate_integrated_qty($manufature,$qty){
        $result = $this->integrated_batch_qty($manufature);
        $sheets='';
        foreach($result as $key => $row){
            if($qty == $row->BatchQty){
                $sheets = $row->BatchQty;
            }
            else if(($qty > $row->BatchQty and isset($result[$key+1]->BatchQty) and $qty < $result[$key+1]->BatchQty)){
                //$sheets = $row->BatchQty;
                $sheets = $result[$key+1]->BatchQty;
            }
        }

        if($sheets==''){   $sheets =  $this->min_qty_integrated($manufature); }
        return $sheets;
    }


    /*----------------------------------WTP OFFERS---------------------------------------*/

    function wtp_discount_applied_on_order(){
        $session_id = $this->session->userdata('session_id');
        $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
        $res   = $qry->row_array();
        return $res;
    }

    function check_wtp_voucher_applied($newGrandTotal){
        $session_id = $this->session->userdata('session_id');
        $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
        $res   = $qry->row_array();
        if($res){
            if($res['grandtotal']!=$newGrandTotal){

                $amount = $this->calculate_total_wtp_amount();
                $this->update_wtp_discount_voucher($amount);

            }
            $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
            $res   = $qry->row_array();
        }

        return $res;
    }


    function update_wtp_discount_voucher($GrandTotal){

        $discout_perct =  number_format(15/100,2);
        $DsountOff = $GrandTotal * $discout_perct;
        $session_id = $this->session->userdata('session_id');
        $data = array(
            'discount_offer' => $DsountOff,
            'grandtotal' => $GrandTotal,
        );
        $update = $this->db->update('voucherofferd_temp', $data, array('SessionID' => $session_id));
    }

    function check_wtp_offer_voucher(){

        $session = $this->get_voucher_condition();

        $query = $this->db->query(" SELECT count(temporaryshoppingbasket.ProductID) AS total from products INNER JOIN temporaryshoppingbasket ON 
		      						products.ProductID=temporaryshoppingbasket.ProductID WHERE ManufactureID LIKE '%WTP' AND Printing NOT LIKE 'Y' AND $session AND 
			   						temporaryshoppingbasket.Quantity >= 10000 AND  (ProductBrand NOT LIKE 'Roll Labels' AND ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label' AND ProductBrand NOT LIKE 'Integrated Labels' AND ProductBrand NOT LIKE 'A5 Labels')");
        $row = $query->row_array();
       // print_r($row);
        //echo $this->db->last_query();
        if(isset($row['total']) and $row['total'] > 0){
            return true;
        }else{
            $session_id = $this->session->userdata('session_id');
            $update = $this->db->delete('voucherofferd_temp',array('SessionID' => $session_id));
            return false;
        }
    }

    function calculate_total_wtp_amount(){

        $session = $this->get_voucher_condition();
        $query = $this->db->query(" SELECT SUM(TotalPrice) AS total from products INNER JOIN temporaryshoppingbasket ON 
		      						products.ProductID=temporaryshoppingbasket.ProductID WHERE ManufactureID LIKE '%WTP' AND Printing NOT LIKE 'Y' AND $session AND 
			   						temporaryshoppingbasket.Quantity >= 10000 AND  (ProductBrand NOT LIKE 'Roll Labels' AND ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label' AND ProductBrand NOT LIKE 'A5 Labels')");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total']!=''){
            return $row['total']*1.2;
        }else{
            return 0.00;
        }
    }
    function get_voucher_condition(){
        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
        return $where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";
    }




    /*************** For quotaion to order ***************************/
    function check_wtp_voucher_applied_quotation($QuoteNumber,$newGrandTotal){
        $session_id = $this->session->userdata('session_id');
        $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
        $res   = $qry->row_array();
        if($res){
            if($res['grandtotal']!=$newGrandTotal){

                $amount = $this->calculate_quotation_total_wtp_amount($QuoteNumber);
                $this->update_wtp_discount_voucher($amount);

            }
            $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
            $res   = $qry->row_array();
        }

        return $res;
    }



    function calculate_quotation_total_wtp_amount($quotenumber){

        $query = $this->db->query(" SELECT SUM(quotationdetails.Price) AS total from products INNER JOIN quotationdetails ON 
										products.ProductID=quotationdetails.ProductID WHERE products.ManufactureID LIKE '%WTP' AND
										QuotationNumber LIKE '".$quotenumber."'  AND quotationdetails.Quantity >= 10000 
										AND quotationdetails.active LIKE 'Y' AND  (ProductBrand NOT LIKE 'Roll Labels' 
										AND ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label')");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total']!=''){
            return $row['total']*1.2;
        }else{
            return 0.00;
        }
    }

    function check_wtp_quotation_offer_voucher($quotenumber){



        $query = $this->db->query(" SELECT count(quotationdetails.ProductID) AS total from products INNER JOIN quotationdetails ON 
										products.ProductID=quotationdetails.ProductID WHERE products.ManufactureID LIKE '%WTP' AND
										QuotationNumber LIKE '".$quotenumber."'  AND quotationdetails.Quantity >= 10000 
										AND quotationdetails.active LIKE 'Y'
										AND  (ProductBrand NOT LIKE 'Roll Labels' AND ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label' AND ProductBrand NOT LIKE 'Integrated Labels')");
        $row = $query->row_array();

        if(isset($row['total']) and $row['total'] > 0){
            return true;
        }else{
            $session_id = $this->session->userdata('session_id');
            $update = $this->db->delete('voucherofferd_temp',array('SessionID' => $session_id));
            return false;
        }
    }
    /*-----------------------------------------------------------------------*/
    function get_saleoprator_notes($refrence=NULL){

        if($refrence){
            $query  = $this->db->query("select *,DATE_FORMAT(noteDate,'%d-%m-%Y %h:%i %p') as noteDate from customernotes where RefNumber LIKE '".$refrence."' ORDER BY noteID DESC");
            return $query->result();
        }

    }
    function get_integrated_attachments($serial=NULL){
        $query  = $this->db->query("select * from order_attachments_integrated WHERE Serial LIKE '".$serial."' ORDER BY ID ASC");
        return $query->result();
    }



    function checkProduct($id){
        $query = $this->db->query("SELECT count(*) as counter from roll_print_basket WHERE id = '$id' ");
        $row = $query->row_array();
        if($row['counter'] > 0){return 1;}else{return 0;}
    }

    function Deletroll_print($id){

        $query = $this->db->query("DELETE  from roll_print_basket WHERE id = '$id' ");
    }

    function Deletroll_print_quote($id){

        $query = $this->db->query("DELETE  from roll_print_basket WHERE SerialNumber = '$id' ");
    }

    function get_details_roll($id){
        $query = $this->db->query("SELECT * from roll_print_basket WHERE id = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    function get_details_roll_quotation($id){
        $query = $this->db->query("SELECT * from roll_print_basket WHERE SerialNumber = '$id' ");
        $row = $query->row_array();
        return $row;
    }

    function checkProduct_quote($id){
        $query = $this->db->query("SELECT count(*) as counter from roll_print_basket WHERE SerialNumber = '$id' ");
        $row = $query->row_array();
        if($row['counter'] > 0){return 1;}else{return 0;}
    }
    function get_serialno(){
        $query = $this->db->query("SELECT MAX(SerialNumber) as number from roll_print_basket ");
        $row = $query->row_array();
        return $row['number'];

    }
    function roll_size($shape){
        if($shape=="Circle"){
            $field = "Diameter";
        }else{
            $field = "width,height,Diameter";
        }
        $query = $this->db->query("SELECT $field from roll_size WHERE Shape = '$shape'order by $field ASC");
        $row = $query->result();
        return $row;

    }

    function ProductBrand($id){
        $query=$this->db->query("select  ProductBrand from products  where ManufactureID LIKE '".$id."'");
        $res=$query->row_array();
        return $res['ProductBrand'];
    }
    function get_xmass_design($type){
        $qry2 = $this->db->query("SELECT * from xmass_design WHERE category LIKE '".$type."' ORDER BY SEQ ASC");
        return $result =  $qry2->result();
    }



    //////////////printing/////////////////////////
    function get_print_price($condtion){
        $query = $this->db->query("SELECT * from print_price WHERE Quantity = '$condtion' ");
        $row = $query->row_array();
        return $row;
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

    public function quoteDetails111($quoteID) {

        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }

        $query = $this->db->get_where('quotationdetails', array('QuotationNumber' => $quoteID,'active'=>"Y"));
        return $query->result();
    }


    function material_list(){
        $query = $this->db->query("select * from roll_material where active = 'Y'");
        return $query->result();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function subtotal()
    {

        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');


        $qry = $this->db->query("SELECT sum(TotalPrice) as total FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID WHERE 1=1 and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

        $res  = $qry->result();

        return $res;
    }



    /////////////////////////////////////////////////////POSTCODE TASK//////////////////////////////////////////////////////////////////////////////////


    public function charges_services($id){
        $query = $this->db->query("select * from shippingservices where ServiceID = '$id'");
        $result =  $query->row_array();
        return $result['BasicCharges'];
    }


    public function getcountries(){
        $query  =  $this->db->query("select * from shippingcountries where status = 'active'  ORDER BY name ASC ");
        $result =  $query->result();
        return $result;


    }


    public function getcountry_new($country){
        $query  =  $this->db->query("select * from shippingcountries where name = '$country'");
        $result =  $query->row_array();
        return $result;


    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getShipingService($conID){

        $sql = $this->db->query("select * from shippingservices where CountryID='".$conID."' order by ServiceID ASc ");
        $service = $sql->result_array();

        return $service;
    }


    public function getShipingService2($conID){

        $sql = $this->db->query("select * from shippingservices where ServiceID='".$conID."' ");
        $service = $sql->result_array();

        return $service;
    }


    public function getShipingServiceName($serviceID){

        $sql = $this->db->query("select * from shippingservices where ServiceID='".$serviceID."'");
        $service = $sql->row_array();

        return $service;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function get_credit_notes($refrence=NULL){

        if($refrence){
            $query  = $this->db->query("select *,DATE_FORMAT(noteDate,'%d-%m-%Y %h:%i %p') as noteDate from creditnotes where RefNumber LIKE '".$refrence."' ORDER BY noteID DESC");
            return $query->result();
        }

    }

    public function check_EuroID($PRODUCTID){

        $sql = $this->db->query("select EuroID from products where ProductID='".$PRODUCTID."'");
        $service = $sql->row_array();

        return $service['EuroID'];
    }


    public function check_product_extra_detail($ManufactureID,$ProductBrand=NULL){

        $code = 'AAAAAAAAA'; $product_info ='';
        if(isset($ProductBrand) && $ProductBrand !=""){}else{
            $ProductBrand = $this->ProductBrand($ManufactureID);
        }
        if(isset($ProductBrand) and  $ProductBrand == 'Roll Labels'){
            $ManufactureID = substr($ManufactureID,0,-1);
        }
        if(isset($ProductBrand) and  $ProductBrand != ''){
            $code = $this->getmaterialcode($ManufactureID);
        }

        if(isset($ProductBrand) and  $ProductBrand != ''){
            $pdiecode = str_replace($code,"",$ManufactureID);
        }

        $query = "select * from product_info where  ManufactureID LIKE '$ManufactureID' AND p_brand LIKE '$ProductBrand'";
        $productcode = $this->db->query($query);
        if($productcode->num_rows() == 1){
            $productcode = $productcode->row_array();
            $product_info = $productcode['Detail'];
        }

        $query = "select * from product_info where  ManufactureID LIKE '$code' AND p_brand LIKE '$ProductBrand'";
        $material = $this->db->query($query);
        if($material->num_rows() == 1){
            $material = $material->row_array();
            if($product_info){ $product_info .= ', ';}
            $product_info .= ' '.$material['Detail'];
        }

        $query = "select * from product_info where  ManufactureID LIKE '$pdiecode' AND p_brand LIKE '$ProductBrand'";
        $diecode = $this->db->query($query);
        if($diecode->num_rows() == 1){
            $diecode = $diecode->row_array();
            if($product_info){ $product_info .= ', ';}
            $product_info .= ' '.$diecode['Detail'];
        }

        $detail_view = 'no';
        if(isset($product_info) and $product_info!=''){
            $detail_view = 'yes';
        }
        $data = array('prompt'=>$detail_view,'detail'=>$product_info);
        return $data;


    }

    public function check_product_extra_detail_old($ManufactureID){
        $checker = $this->db->query("select * from product_info where ManufactureID LIKE '$ManufactureID'")->row_array();
        $detail_view = (isset($checker) && !empty($checker))?'yes':'no';
        return $data = array('prompt'=>$detail_view,'detail'=>$checker['Detail']);
    }
    public function get_total_labels($serial){
        $no_of_labels = $this->db->query("select sum(labels) as total_labels from order_attachments_integrated where Serial = $serial ")->row_array();
        return $no_of_labels['total_labels'];
    }

    function calculate_total_printed_labels($serial){

        $query = $this->db->query(" SELECT SUM(labels) AS total from quotation_attachments_integrated WHERE Serial LIKE '".$serial."'  ");
        $row = $query->row_array();
        return $row['total'];
    }

    function get_printed_files($serial){
        $q = $this->db->query(" select * from quotation_attachments_integrated  WHERE Serial LIKE '".$serial."'  ");
        return $q->result();
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


    function get_labels_and_brand_from_cart($id){
        $row = $this->db->query(" SELECT products.LabelsPerSheet FROM `temporaryshoppingbasket`
		INNER JOIN products ON products.`ProductID` = `temporaryshoppingbasket`.`ProductID` WHERE temporaryshoppingbasket.ID= $id ")->row_array();
        if(isset($row['LabelsPerSheet']) and $row['LabelsPerSheet']!=''){
            return $row['LabelsPerSheet'];
        }else{
            return 0;
        }
    }

    function get_labels_and_brand_from_quote($id){
        $row = $this->db->query(" SELECT products.LabelsPerSheet FROM `quotationdetails` 
		INNER JOIN products ON products.`ProductID` = `quotationdetails`.`ProductID` WHERE SerialNumber =$id ")->row_array();
        if(isset($row['LabelsPerSheet']) and $row['LabelsPerSheet']!=''){
            return $row['LabelsPerSheet'];
        }else{
            return 0;
        }
    }
    function get_labels_and_brand_from_order($id){
        $row = $this->db->query(" SELECT products.LabelsPerSheet FROM `orderdetails` 
		INNER JOIN products ON products.`ProductID` = `orderdetails`.`ProductID` WHERE SerialNumber =$id ")->row_array();
        if(isset($row['LabelsPerSheet']) and $row['LabelsPerSheet']!=''){
            return $row['LabelsPerSheet'];
        }else{
            return 0;
        }
    }


    /*******  Roll Printing Formula *******/

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

    function roll_labour_breaks($labels){

        if($labels <= 500 ){
            $discount_break = 500;
        }
        else if($labels > 500 and $labels <= 1000 ){
            $discount_break = 	1000;
        }
        else if($labels > 1000 and $labels <= 2000 ){
            $discount_break	 = 	2000;
        }
        else if($labels > 2000 and $labels <= 3000 ){
            $discount_break  	= 	3000;
        }
        else if($labels > 3000 and $labels <= 4000 ){
            $discount_break	 = 	4000;
        }
        else if($labels > 4000 and $labels <= 5000 ){
            $discount_break	 = 	5000;
        }
        else if($labels > 5000 and $labels <= 7500 ){
            $discount_break	 = 	7500;
        }
        else if($labels > 7500 and $labels <= 10000 ){
            $discount_break	 = 	10000;
        }
        else if($labels > 10000 and $labels <= 15000 ){
            $discount_break	 = 	15000;
        }
        else if($labels > 15000 and $labels <= 20000 ){
            $discount_break	 = 	20000;
        }
        else if($labels > 20000 and $labels <= 30000 ){
            $discount_break	 = 	30000;
        }
        else if($labels > 30000  and $labels <= 40000 ){
            $discount_break  = 	40000;
        }
        else if($labels > 40000 and $labels <= 50000 ){
            $discount_break	= 	50000;
        }
        else if($labels > 50000 and $labels <= 75000 ){
            $discount_break	= 	75000;
        }
        else if($labels > 75000 and $labels <= 100000 ){
            $discount_break	= 	100000;
        }
        else if($labels > 100000 and $labels <= 150000){
            $discount_break	 = 	150000;
        }
        else if($labels > 150000 and $labels <= 200000){
            $discount_break	 = 	200000;
        }
        else if($labels > 200000 and $labels <= 250000){
            $discount_break	 = 	220000;
        }
        else if($labels > 250000 and $labels <= 300000){
            $discount_break	 = 	300000;
        }
        else if($labels > 300000 and $labels <= 350000){
            $discount_break	 = 	350000;
        }
        else if($labels > 350000 and $labels <= 400000){
            $discount_break	 = 	400000;
        }
        else if($labels > 400000 and $labels <= 450000){
            $discount_break	 = 	450000;
        }
        else if($labels > 450000){
            $discount_break	 = 	500000;
        }
        return $discount_break;
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


    public function max_total_labels_on_rolls($perroll){
        $max_labels = ceil(500000/$perroll);
        $max_labels = $max_labels*$perroll;
        return $max_labels;
    }

    public function txt_for_plain_labels($Label){
        $plain_cust_txt = ($Label==1)?"<b style='color:blue;'> *PL* </b>":"";
        return $plain_cust_txt;
    }

    public function get_quoteno_serial($serial){
        $qry = $this->db->query("select QuotationNumber,ManufactureID,Print_Type from quotationdetails where SerialNumber = $serial ")->row_array();
        return $qry;

    }

    function get_mat_name($text){
        $query = $this->db->query("SELECT label_name from material_tooltip_info where material_code LIKE  '".$text."' ");
        $row = $query->row_array();
        return $row['label_name'];
    }
    function get_mat_name_fr($text){
        $query = $this->db->query("SELECT label_name_fr from material_tooltip_info where material_code LIKE  '".$text."' ");
        $row = $query->row_array();
        return $row['label_name_fr'];
    }

    //************************************************************//*******************************************************

    public function check_cart_sco(){

        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');
        $qry = $this->db->query("SELECT * FROM temporaryshoppingbasket WHERE p_code LIKE 'SCO1' and (SessionID = '".$session_id."' OR SessionID ='".$cisess_session_id."' ) ");

        $res  = $qry->num_rows();
        return $res;
    }

    public function custom_material_list(){
        $query = $this->db->query("select Code as material_code from material_prices order  by Code asc");
        return $query->result();
    }
    public function getDiscountFromDetail($id){
        return $this->db->query("SELECT * FROM quotationdetails where SerialNumber = '".$id."'")->result();
    }

    public function fetch_custom_die_info($id){
        $query = $this->db->query("SELECT * from flexible_dies_info WHERE CartID = '$id' ");
        $row = $query->row_array();
        return $row;
    }
    public function fetch_custom_die_quote($id){
        $query = $this->db->query("SELECT * from flexible_dies_info WHERE QID = '$id' ");
        $row = $query->row_array();
        return $row;
    }

    public function fetch_custom_die_order($id){
        //$query = $this->db->query("SELECT * from flexible_dies_info WHERE OID =$id");
			
			  $row = $this->db->get_where('flexible_dies_info',array('OID'=>$id))->row_array();
        //$row = $query->row_array();
        return $row;
    }

    public function fetch_custom_die_price($id){
        $record = $this->fetch_custom_die_info($id);
        return $this->get_prize_custom($record);
    }

    public function fetch_custom_die_quote_price($id){
        $record = $this->fetch_custom_die_quote($id);
        return $this->get_prize_custom($record);
    }

    public function get_prize_custom($record){
        $shape = $record['shape'];
        $width = $record['width'];
        $height = $record['height'];
        $euro = $record['iseuro'];
        $noflabels = $record['labels'];

        if($shape!="Irregular"){
            if($shape=="Circle"){
                $linear_meter = ($width * 3.14) * 2;
            }else{
                $linear_meter = ($width + $height) * 2;
            }
            $total_linear = $linear_meter * $noflabels;
            $initial_cost = $total_linear * 0.05;
            if(isset($euro) && $euro==1){
                $initial_cost = $initial_cost + 25;
            }
            $final_cost = $initial_cost / 0.6;
            //$final_cost = number_format($final_cost,3,'.','');
        }else{
            $final_cost = 0.00;
        }
        return number_format($final_cost,3,'.','');
    }

    function getmaterial_list($type){
        $field = 'flexible_price_'.$type;
        $table = ($type=="A3" || $type=="SRA3" || $type=="A5")?$field:'flexible_price';
        return $this->db->query("select material from $table")->result();
    }

    //******************************************************************************************************************


    public function updatecustomsheetprice($scorecord,$material){

        $printprice = 0;
        $price = $this->get_custom_prize($material['material'],$material['qty'],$scorecord['format']);

        if($material['labeltype']=="printed"){
            $result = $this->get_print_price_rate($material['qty']);

            if($material['printing']=="Mono"){ $type="Mono";}else{ $type="Fullcolour";}
            $unitprice = $result[$type]*$material['qty'];

            $unitprice = $this->quoteModel->check_price_uplift($unitprice);

            if($scorecord['format']=="A4"){$unitprice = $unitprice/2;}
            if($scorecord['format']=="roll"){$unitprice = 0;}
            if($scorecord['format']=="SRA3" || $scorecord['format']=="A3"){$unitprice = $unitprice * 1.5;}

            $freeart = $result['Free'];
            $cutdownqty = ($freeart>=$material['designs'])?0:$material['designs']-$freeart;

            $subtotal = $cutdownqty * 5.00;
            $subtotal = $this->quoteModel->check_price_uplift($subtotal);

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


    function last_order($userId){
        $qry = $this->db->query("SELECT `OrderNumber` FROM `orders` WHERE `UserID` = '".$userId."' ORDER BY `OrderDate` DESC ");
        $res = $qry->row_array();
        return $res;
    }

    public function get_remainder($orderno=NULL){
        $where = " where OrderNumber like '".$orderno."' and remainder !=0";
        if($orderno == NULL){
            $where = " where remainder > unix_timestamp(CURDATE()) AND remainder < UNIX_TIMESTAMP(CURDATE()+1) order by remainder asc ";
        }
        return $this->db->query("select `comment`, `remainder` from callback_comment $where")->result();
    }



    /*****************************************//*****************************************//*****************************************/


    function show_product($pid){
        $qry = $this->db->query("SELECT * FROM products WHERE ProductID  = ".$pid."");
        return $qry->row_array();
    }

    function get_translated_version($value){
        $translated_option = trim(strtolower(str_replace("-","_",$value)));
        $translated_option = trim(strtolower(str_replace("/","_",$translated_option)));
        $translated_option = trim(strtolower(str_replace(" - ","_",$translated_option)));
        $translated_option = trim(strtolower(str_replace(" ","_",$translated_option)));
        $translated_text = lang('labelfilter_option_'.$translated_option);

        if(isset($translated_text) and $translated_text!=''){
            $value = $translated_text;
        }
        return $value;
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
        }
        else{
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




    public function gerroll_pro_name_fr($proid){
        $row = $this->db->query("select ProductName from products where ProductID = $proid")->row_array();
        return $row['ProductName'];

    }


    public function fetch_product_name($data){
        $this->lang->load('genral');
        $type = $this->orderModal->make_productBrand_condtion($data['ProductBrand']);
        if($type=="Rolls"){
            $data['ProductName'] = $this->gerroll_pro_name_fr($data['ProductID']);
            $pname = explode('-',$data['ProductName']);
            $prodname = $this->get_translated_version(trim($pname[0]));
            $pdetails = explode(" - ", $data['ProductCategoryName']);
            $LabelSize = str_replace("label size ","",$pdetails[1]);

            $catname = lang('placeholder_roll_labels').' - '.lang('placeholder_labelsize').' '.$LabelSize;
            $catname = str_replace("mm Circle",lang('labelfilter_option_circular'), $catname);
            $Adhesive = lang('labels_material_adhesive');
            $completeName = $prodname.' '.$this->get_translated_version($data['Adhesive']).' '.$Adhesive.' '.$catname;
        }else{
            $completeName = $this->get_translated_long_desciption($data['ProductCategoryName'], $type);
        }
        $data['ProductCategoryName'] = $completeName;
        $completeName = $this->customize_product_name_fr($data);
        return $completeName;
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



        if($wound=='Y'){ $wound_opt = lang('placeholder_inside_wound');}else{ $wound_opt = lang('placeholder_outside_wound');}

        if(isset($data['Source']) and $data['Source'] == 'Y' and preg_match('/Roll Labels/is',$ProductBrand)){

            $labeltype  = $this->orderModal->get_db_column('digital_printing_process', 'name_fr', 'name', $data['Print_Type']);
            $productname  = explode("-",$ProductCategoryName);
            $productname[1] = str_replace("(","",$productname[1]);
            $productname[1] = str_replace(")","",$productname[1]);
            $productname[0] = str_replace("rolls labels","",$productname[0]);
            $productname[0] = str_replace("roll labels","",$productname[0]);
            $productname[0] = str_replace("Roll Labels","",$productname[0]);
            $productname = "Étiquettes imprimées sur rouleaux - ".str_replace("roll label","",$productname[0]).' - '.$productname[1];
            $completeName = ucfirst($productname).' '.$wound_opt.' - Orientation '.$data['Orientation'].', ';

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
            $completeName =  $productname[0].$LabelsPerRoll." ".lang('placeholder_labels_per_roll').", ".$wound_opt." - ".$productname[1];
            $diamter =  $this->orderModal->calculate_rolls_diamter($manuid,$LabelsPerRoll);
            $completeName = $completeName." ".lang('placeholder_roll_diamter').' '.$diamter;

        }else{
            if(preg_match('/Roll Labels/is',$ProductBrand)){
                $productname  = explode("-",$ProductCategoryName);

                $completeName = $productname[0].$LabelsPerSheet." ".lang('placeholder_labels_per_roll').", ".$wound_opt." - ".$productname[1];
                $diamter =  $this->orderModal->calculate_rolls_diamter($manuid,$LabelsPerSheet);
                $completeName = $completeName." ".lang('placeholder_roll_diamter').' '.$diamter;


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


    function getdelivery_style($service_id){
        $delivery_style ='';
        $result = $this->db->query("select * from shippingservices where ServiceID = $service_id")->row_array();
        if($result['Priority']=="High"){
            $delivery_style = 'style="background:#d1c0ff;border:1px dotted #fff !important; color:#5d449f;"';
        }
        return $delivery_style;

    }

    function fetch_custom_die_association($id){
        return $this->db->query("select * from flexible_dies_mat where OID = $id")->result();
    }

    function check_price_uplift($total_price){
        $total_price = $total_price/0.94; // 6% increment yearly march 2018
        return $total_price;
    }

    function is_Sample_Order($order_no){

        $check_sample_order = $this->db->query("select PaymentMethods from orders where OrderNumber like '".$order_no."'")->row();
        if(count($check_sample_order) > 0 ){
            if($check_sample_order->PaymentMethods == 'Sample Order'){
                return '&ndash;';
            }else{
                return false;
            }
        }
    }



    function integrated_sheets(){
        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $SID = $this->session->userdata('session_id');

        $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `temporaryshoppingbasket` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and (SessionID = '$SID' OR  SessionID = '$cisess_session_id') and t.p_name != 'Delivery Charges'")->row_array();
        return $int_sheets;
    }


    function is_order_integrated(){
        $cookie = @$_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $SID = $this->session->userdata('session_id');

        $result = $this->db->query("select COUNT(*) as total from temporaryshoppingbasket temp JOIN products pro on temp.ProductID = pro.ProductID WHERE (temp.SessionID LIKE '".$SID."' OR temp.SessionID = '".$cisess_session_id."') AND pro.ProductBrand = 'Integrated Labels'");
        $row = $result->row_array();
        return $row['total'];
    }

    function get_integrated_delivery($qty,$country = '')
    {
        $prices = array();
        $prices['dpd'] = '';
        $prices['batch_qty'] = '';
        $prices['pallets'] = '';
        if($country == 'United Kingdom'){
            $qry = "SELECT * FROM integrated_labels_delivery Order By batch_qty ASC";
            $query = $this->db->query($qry);
            $result = $query->result_array();
            foreach($result as $key => $row){
                if($qty<=4000){
                    $prices = $result[0];
                }
                else if($qty == $row['batch_qty']){
                    $prices = $result[$key];
                }
                else if(($qty > $row['batch_qty'] and isset($result[$key+1]['batch_qty']) and $qty < $result[$key+1]['batch_qty'])){
                    $prices = $result[$key+1];
                }
                else if($qty>100000){
                    $prices = end($result);
                }
            }
        }else{
            $box = ceil($qty/1000);
            $prices = $this->integrated_delivery_offshore($box,$country);
            if($prices['dpd'] == 0){
                $prices = $this->get_integrated_delivery($qty,'United Kingdom');
            }
        }
        return $prices;
    }


    function integrated_delivery_offshore($box,$country){

        $sql = "Select * From integrated_delivery_offshore Where country LIKE '$country'";
        $result = $this->db->query($sql)->result_array();


        $min_qty = $result[0]['box'];
        $max_qty = end($result);
        $max_qty = $max_qty['box'];

        foreach($result as $key => $row){
            if($box<=$min_qty){
                $prices = $result[0];
            }
            else if($box == $row['box']){
                $prices = $result[$key];
            }
            else if(($box > $row['box'] and isset($result[$key+1]['box']) and $box < $result[$key+1]['box'])){
                $prices = $result[$key+1];
            }
            else if($box>$max_qty){
                $prices = end($result);
            }
        }

        $prices['dpd'] = $box * $prices['perbox'];
        if($box < 50 and ($prices['dpd'] > $prices['half_pallet']))
        {
            $prices['dpd'] = $prices['half_pallet'];
        }
        if($box >= 50 and ($prices['dpd'] > $prices['full_pallet']))
        {
            $prices['dpd'] = $prices['full_pallet'];
        }
        return $prices;
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

            $count = $this->quoteModel->viewCart();
            if($count)
            {
                $ws_applied = $this->session->userdata('ws_applied');
                if($ws_applied == "yes")
                {
                    $cart_detail = $this->quoteModel->viewCart();
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

                                    $min_qty = $this->quoteModel->min_qty_roll($pr['CategoryID']);
                                    $response = $this->quoteModel->rolls_calculation($min_qty, $pr['LabelsPerSheet'], $row->orignalQty);


                                    $labels = $response['total_labels'];
                                    $labels_per_rolls = $response['per_roll'];
                                    $sheets = $response['rolls'];

                                    $collection['labels'] 	  = $labels;
                                    $collection['manufature'] = $pr['ManufactureID'];
                                    $collection['finish']     = $row->FinishType;
                                    $collection['rolls']      = $sheets;
                                    $collection['printing']   = $row->Print_Type;

                                    $total_price = $this->quoteModel->calculate_printing_price($collection);

                                    $total_price = $total_price['final_price'];

                                    if($qty > $response['rolls'])
                                    {
                                        $additional_rolls = $qty-$response['rolls'];
                                        $additional_cost = $this->additional_charges_rolls($additional_rolls);

                                        $total_price = $total_price+$additional_cost;
                                    }
                                    if($row->pressproof == 1)
                                    {
                                        $pressproof_charges = $this->home_model->currecy_converter(50.00);
                                        $total_price = $total_price + $pressproof_charges;
                                    }
                                }
                                else
                                {
                                    $total_price = $this->home_model->calclateprice($pr['ManufactureID'],$row->Quantity,$row->LabelsPerRoll);

                                    $total_price = $total_price['final_price'];
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
    function update_db_column($table, $column, $data, $key, $value)
    {
        $sql = "UPDATE $table SET $column = $data WHERE $key LIKE '".$value."' LIMIT 1";
        $row = $this->db->query($sql);
    }



    function split_trade_order($orderNum)
    {
        $user_domain = $this->session->userdata('user_domain');
        if($user_domain)
        {
            $orderDetails = $this->orderModal->OrderInfo($orderNum);
            $orderDetails = $orderDetails[0];
            $orderLines = $this->orderModal->OrderDetails($orderNum);

            $serials_array = array();

            foreach ($orderLines as $line)
            {

                if($line->page_location == "Trade Print")
                {
                }
                else
                {
                    $serials_array[] = $line->SerialNumber;
                }
            }

            if($serials_array)
            {
                $sessionid = $this->session->userdata('session_id');
                $this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
                $order_num = $this->db->insert_id();
                $OrderNumber = 'AA'.$order_num;

                $orderTotal = 0;

                foreach($serials_array as $serial)
                {
                    $orderTotal += $this->get_db_column('orderdetails','ProductTotal','SerialNumber',$serial);

                    $this->db->set('OrderNumber', $OrderNumber);
                    $this->db->where('SerialNumber', $serial);
                    $this->db->update('orderdetails');

                    $this->db->set('OrderNumber', $OrderNumber);
                    $this->db->where('Serial', $serial);
                    $this->db->update('order_attachments_integrated');
                }

                $orderDetails->OrderTotal = $orderDetails->OrderTotal - $orderTotal;

                $this->db->where('OrderNumber',$orderDetails->OrderNumber);
                $this->db->update('orders',$orderDetails);

                $AAOrder = $orderDetails;

                unset($AAOrder->OrderID);
                $AAOrder->OrderNumber = $OrderNumber;
                $AAOrder->OrderTotal = $orderTotal;
                $this->db->insert('orders',$AAOrder);

                //if order status == 2/32 then check if the line is plain, then change the status to 55.
                if(($AAOrder->OrderStatus == 2) || ($AAOrder->OrderStatus == 32))
                {
                    $this->change_order_status_confirmation($OrderNumber);
                }
            }
        }
    }

    function change_order_status_confirmation($orderNum)
    {

        $plain_query = "select count(*) as total from orderdetails where OrderNumber LIKE '".$orderNum."' AND Printing NOT LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels'";

        $printed_query = "select count(*) as total from orderdetails where OrderNumber LIKE '".$orderNum."' AND Printing LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels'";

        //$plain_order = $this->db->query($plain_query)->row()->total;
        $printed_order = $this->db->query($printed_query)->row()->total;
        if(!$printed_order)
        {
            $this->db->set('OrderStatus', 2);
            $this->db->where('OrderNumber', $orderNum);
            $this->db->update('orders');
        }
    }


    function apply_trade_discount_on_login()
    {
        $count = $this->quoteModel->viewCart();
        if($count)
        {
            $ws_applied = $this->session->userdata('ws_applied');
            if(!$ws_applied == "yes")
            {
                $cart_detail = $this->quoteModel->viewCart();
                foreach($cart_detail as $row)
                {
                    $prods = $this->quoteModel->show_product($row->ProductID);

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
                                $min_qty = $this->quoteModel->min_qty_roll($pr['CategoryID']);


                                $response = $this->quoteModel->rolls_calculation($min_qty, $pr['LabelsPerSheet'], $row->orignalQty);
                                $labels = $response['total_labels'];
                                $labels_per_rolls = $response['per_roll'];
                                $sheets = $response['rolls'];

                                $collection['labels'] 	  = $labels;
                                $collection['manufature'] = $pr['ManufactureID'];
                                $collection['finish']     = $row->FinishType;
                                $collection['rolls']      = $sheets;
                                $collection['printing']  = $row->Print_Type;

                                $total_price = $this->quoteModel->calculate_printing_price($collection);
                                $total_price = $total_price['final_price'];

                                if($qty > $response['rolls'])
                                {
                                    $additional_rolls = $qty-$response['rolls'];
                                    $additional_cost = $this->quoteModel->additional_charges_rolls($additional_rolls);
                                    $total_price = $total_price+$additional_cost;
                                }
                                if($row->pressproof == 1)
                                {
                                    $pressproof_charges = $this->home_model->currecy_converter(50.00);
                                    $total_price = $total_price + $pressproof_charges;
                                }
                                $userID = $this->session->userdata('Order_person');
                                if((isset($userID) and !empty($userID)))
                                {
                                    $wholesale = $this->quoteModel->get_db_column('customers','wholesale','UserID',$userID);
                                    if($wholesale == "wholesale")
                                    {
                                        $total_price = $this->quoteModel->apply_discount($userID, $collection['manufature'],$total_price,'login');

                                    }
                                }

                                $this->quoteModel->update_db_column("temporaryshoppingbasket","TotalPrice",$total_price,"ID",$row->ID);
                                $this->quoteModel->update_db_column("temporaryshoppingbasket","UnitPrice",$total_price/$row->Quantity,"ID",$row->ID);



                            }


                        }

                    }
                }
            }
        }
    }



    //******************************************************************************************************************************


    public function UpdateItemOrderEdit($ID,$productID,$ManufactureID,$qty){
        $ProductBrand = $this->ProductBrand($ManufactureID);
        $printing = $this->input->post('printing');

        if(preg_match('/Roll Labels/is',$ProductBrand) && $printing=="Y"){
            $labels = $this->input->post('labels');
            $finish = $this->input->post('finish');
            $press  = $this->input->post('press');
            $min_qty = $this->get_roll_qty($ManufactureID);

            if($press== 'true'){$press=1;}else{$press=0;}

            $prid = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '".$ManufactureID."'")->row_array();

            $response = $this->rolls_calculation($min_qty,$prid['LabelsPerSheet'],$labels);
            $collection['labels'] 	= $response['total_labels'];
            $collection['manufature'] = $ManufactureID;
            $collection['finish']     = $finish;
            $collection['rolls']      = $response['rolls'];
            $collection['printing']   = $this->input->post('type');

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

            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');

            $data = array(
                'Quantity' 	 => $qty,
                'LabelsPerRoll'=> $labels/$qty,
                'source'       => 'printing',
                'is_custom'    => 'Yes',
                'Orientation'  => $this->input->post('orientation'),
                'FinishType'   => $this->input->post('finish'),
                'Wound'        => $this->input->post('wound'),
                'Print_Type'   => $this->input->post('type'),
                'Print_Design' => $this->input->post('design'),
                'Print_Qty'    => $this->input->post('pqty'),
                'pressproof'   => $press,
                'Free'         => 0,
                'labels'       => $labels,
            );
            $ExVat = round($custom_price,2);
            $IncVat = round($custom_price * vat_rate,2);
            $data['Price'] = $ExVat;
            $data['ProductTotalVAT'] = $ExVat;
            $data['ProductTotal'] = $IncVat;

            $updation = array(
                'Quantity'=>$qty,'Orientation'=>$this->input->post('orientation'),
                'FinishType'=> str_replace(' ','-',$this->input->post('finish')),'Wound'=>$this->input->post('wound'),
                'Print_Type'=> str_replace(' ','-',$this->input->post('type')),'Print_Qty'=> $this->input->post('pqty'));
            $updation = http_build_query($updation,'', '&nbsp;&amp;&nbsp;');
            $this->settingmodel->add_logs('line_updated',$updation,'',$this->input->post('OrderNumber'),$ID);

        }else if(preg_match('/Roll Labels/is',$ProductBrand)){
            $wound = $this->input->post('wound');

            $linedetails = $this->db->query("select * from orderdetails where SerialNumber = $ID")->row_array();

            $prid = $this->db->query("select LabelsPerSheet from products WHERE `ManufactureID` LIKE '".$ManufactureID."'")->row_array();
            $lpr = (isset($linedetails['is_custom']) && $linedetails['is_custom']=="Yes")?$linedetails['LabelsPerRoll']:$prid['LabelsPerSheet'];

            $custom_price = $this->min_roll_price($ManufactureID,$qty,$lpr);
            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');

            $ExVat  = round($custom_price,2);
            $IncVat = round($custom_price*1.2,2);
            $data = array('Price'=>$ExVat,'ProductTotalVAT'=>$ExVat,'ProductTotal'=>$IncVat,'Quantity'=>$qty,'Wound'=>$wound);

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

            $prid = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '".$ManufactureID."'")->row_array();
            $mylabels = $qty * $prid['LabelsPerSheet'];


            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');
            $ExVat  = round($custom_price,2);
            $IncVat = round($custom_price*1.2,2);
            $data = array('Price'=>$ExVat,'labels'=>$mylabels,'ProductTotalVAT'=>$ExVat,'ProductTotal'=>$IncVat,'Quantity'=>$qty);
            /*****************WPEP Offer************/
        }

        $this->settingmodel->update_line($ID,$data);
        //$updation = http_build_query($data,'', '&amp;');
        //$this->settingmodel->add_logs('line_updated',$updation,'',$this->input->post('OrderNumber'),$ID);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }


    public function addToOrder($ProductID,$ManufactureID,$Quantity,$OrderNumber){
        $prodinfo = $this->orderModal->getproductdetail($ProductID);
        $is_custom = 'No';
        $labelproll=0;

        if(preg_match('/Roll Labels/is',$prodinfo['ProductBrand']))
        {
            $min_qty = $this->quoteModel->get_roll_qty($AccountDetail->ManufactureID);

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

        $UserID = $this->session->userdata('UserID');

        /*****************WPEP Offer************/
        $custom_price = $this->getPrize($Quantity,$ManufactureID);


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
        if($ProductID==0){
            $Quantity=0;
            $UnitPrice=0;
            $custom_price=0;
        }

        if($ProductID==0 && $ManufactureID=='SCO1'){
            $Quantity=1;
        }

        $orderData = array(
            'OrderNumber' => $OrderNumber,
            'UserID' => $UserID,
            'ProductID' => $ProductID,
            'Quantity' => $Quantity,
            'Price' => $custom_price,
            'ProductTotalVAT'=>$custom_price,
            'ProductTotal' => ($custom_price*1.2),
            'is_custom' => $is_custom,
            'LabelsPerRoll'=>$labelproll,
            'ManufactureID'=>$ManufactureID,
            'ProductName'=>$prodinfo['ProductCategoryName']
        );

        if($ProductID==0 && $ManufactureID=='sco1'){
            $orderData = array_merge($orderData, array('p_code'=>'SCO1','p_name'=>'Set-up charge'));
        }
        $this->db->insert('orderdetails', $orderData);
        return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }



    function check_material_discount($material_code,$keys = false)
    {
        $discounts = array();

        //	$discounts['RDP'] = 25;
        //	$discounts['YWP'] = 25;
        //	$discounts['LGN'] = 25;
        //	$discounts['GNP'] = 25;
        //	$discounts['BEP'] = 25;
        //	$discounts['MBEP'] = 25;
        //	$discounts['MBEP'] = 25;
        //	$discounts['ORP'] = 25;
        //	$discounts['MPY'] = 25;
        //	$discounts['MFP'] = 25;
        //	$discounts['FPNP'] = 25;
        //	$discounts['FRDP'] = 25;
        //	$discounts['FYWP'] = 25;
        //	$discounts['FGNP'] = 25;
        //	$discounts['FORP'] = 25;
        //	$discounts['RGDP'] = 25;
        //	$discounts['GDP'] = 25;
        //	$discounts['SRP'] = 25;
        //	$discounts['MLT'] = 25;
        //	$discounts['MLB'] = 25;
        //	$discounts['MLS'] = 25;
        //	$discounts['FMC'] = 25;
        //	$discounts['FQP'] = 25;
        $discounts['WPEP'] = 20;
        if($keys)
        {
            return array_keys($discounts);
        }
        if(array_key_exists($material_code,$discounts))
        {
            return $discounts[$material_code];
        }
    }



    function getprize_competitors($ManufactureID){

        $qry = $this->db->query("select tbl.ID as btpriceid,tbl.ManufactureID,tbl.BatchID,tbl.SetupCost,tbl.SheetPrice,batch.BatchQty from tbl_product_batchprice tbl,tbl_batch batch where
 tbl.ManufactureID='".$ManufactureID."' and tbl.BatchID= batch.BatchID ORDER BY batch.BatchQty Asc ");
        return $qry->result();
    }

    function getmydiecode($text){

        preg_match('/(\d+)\D*$/', $text, $m);
        $lastnum = $m[1];
        $mat_code = explode($lastnum,$text);
        $met = strtoupper($mat_code[1]);

        return explode($met,$text)[0];

    }


    public function fetch_quotationdetails($id){
        $query = $this->db->query("SELECT * from quotationdetails WHERE SerialNumber = '$id' ");
        $row = $query->row_array();
        return $row;
    }

    function calulate_min_labels($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Labels) AS Labels FROM `tbl_batch_labels` WHERE ManufactureID LIKE '".$manufature."' AND status LIKE 'Y'");
        $roll = $roll->row_array();
        return  ($roll['Labels'] !=null)?$roll['Labels']:0;
    }


}
