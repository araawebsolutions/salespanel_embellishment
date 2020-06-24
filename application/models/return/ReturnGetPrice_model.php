<?php
class ReturnGetPrice_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		//$this->load->model('return/GetPrice_model');
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
    
	function integrated_batch_qty($menuid){

		$query =   $this->db->query("select tbl.ManufactureID,tbl.SheetPrice,batch.BatchQty,tbl.DiscountPercent from 
					   tbl_product_batchprice tbl,tbl_batch batch where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID ORDER BY batch.BatchQty Asc ");
		return $query->result();
	}
	  
	public function UpdateItem($ID,$ProductBrand,$ManufactureID,$qty,$printing,$labels,$Print_Type,$FinishType){
		//$ProductBrand = $this->ProductBrand($ManufactureID);
		//$printing = $this->input->post('printing'); 
	  
		if(preg_match('/Roll Labels/is',$ProductBrand) && $printing=="Y"){
              
			$labels = $labels * $qty;
			$finish = $FinishType;
			$press  = 1;
			$min_qty = $this->get_roll_qty($ManufactureID);
				  
			if($press== 'true'){$press=1;}else{$press=0;}
				  
			$prid = $this->db->query("select LabelsPerSheet from products WHERE `ManufactureID` LIKE '".$ManufactureID."'")->row_array();
				  
			$response = $this->rolls_calculation($min_qty,$prid['LabelsPerSheet'],$labels,''); 
			//print_r($response); echo '<br>';
              
			$collection['labels'] 	= $response['total_labels']; 
			$collection['manufature'] = $ManufactureID;
			$collection['finish']     = $finish;
			$collection['rolls']      = $response['rolls'];
			$collection['printing']   = $Print_Type;
              
                     
			//print_r($collection); echo '<br>';
					     
			$price_res = $this->calculate_printing_price($collection);
			$custom_price = $price_res['final_price'];
						 
			if($press==1){
				$custom_price = $custom_price + 50.00;
			}
					 
			if($qty>$response['rolls']){
				$add_rolls = $qty - $response['rolls'];
				$additional_cost = $this->additional_charges_rolls($add_rolls);
				$custom_price = $custom_price + $additional_cost; //echo '<br>';
			}
					 
			$labels = $response['total_labels'];
              
			if($qty<$response['rolls']){
				$qty = $response['rolls'];
			}
						  
			if($response['total_labels'] != $response['actual_labels']){
				$labels = $response['total_labels'];
			}
						 
			$unitPrice = $custom_price/$qty;
			$UnitPrice = number_format(round($unitPrice,3),3,'.',''); //echo '<br>';
					 
			$ExVat = round($custom_price,2);
			$IncVat = round($custom_price * vat_rate,2);
			//$data['Price'] = $ExVat;
			//$data['ProductTotalVAT'] = $ExVat;
			//$data['ProductTotal'] = $IncVat;
      	                  
			$data = array('UnitPrice'=>$ExVat,'TotalPrice'=>$IncVat,'sd'=>$qty);
						
			
		}else if(preg_match('/Roll Labels/is',$ProductBrand) ){
					 
			$linedetails = $this->db->query("select * from orderdetails where SerialNumber = $ID")->row_array();
			 
			$prid = $this->db->query("select LabelsPerSheet from products WHERE `ManufactureID` LIKE '".$ManufactureID."'")->row_array();	
			$lpr = (isset($linedetails['is_custom']) && $linedetails['is_custom']=="Yes")?	$linedetails['LabelsPerRoll']:$prid['LabelsPerSheet'];
				 
			$custom_price = $this->min_roll_price($ManufactureID,$qty,$lpr);
			$unitPrice = $custom_price/$qty;
			$UnitPrice = number_format(round($unitPrice,3),3,'.','');
				 
			$ExVat  = round($custom_price,2);
			$IncVat = round($custom_price*1.2,2);
			$data = array('Price'=>$ExVat,'ProductTotalVAT'=>$ExVat,'ProductTotal'=>$IncVat,'Quantity'=>$qty,'UnitPrice'=>$ExVat,'TotalPrice'=>$IncVat);
				
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
			//$ProductBrand = $this->ProductBrand($ManufactureID);
			if(preg_match("/A4 Labels/i",$ProductBrand)){
				$mat_code = $this->getmaterialcode($ManufactureID);
				$material_discount = $this->check_material_discount($mat_code);
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
			$data = array('Price'=>$ExVat,'labels'=>$mylabels,'ProductTotalVAT'=>$ExVat,'ProductTotal'=>$IncVat,'Quantity'=>$qty,'UnitPrice'=>$ExVat,'TotalPrice'=>$IncVat);
			/*****************WPEP Offer************/
		}
		return json_encode($data);
	}
     
	function get_roll_qty($manufature1){
	   
		$manufature = substr($manufature1,0,-1);
		$roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` Where ManufactureID LIKE '".$manufature."' AND (Active LIKE 'Y' )"); 
		$roll = $roll->row_array();
		if(isset($roll['Rolls']) and $roll['Rolls'] > 0){
			return  $roll['Rolls']; 
		}else { return 0;}
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
			//print_r($total_price);
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
				
			$userID = '616100';//$this->session->userdata('Order_person');
			if((isset($userID) and !empty($userID)))
				{
				$wholesale = $this->get_db_column('customers','wholesale','UserID',$userID);
				if($wholesale == "wholesale")
				{
					echo $total_price = $printprice+$label_finish;
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
    
	public function getPrize($Quantity,$ManufactureID)
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
			$custom_price = $this->min_roll_price($ManufactureID,$Quantity,$roll['LabelsPersheet']);
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
    
    
    
	function is_ProductBrand_roll($id){
		
		$query=$this->db->query("select  ProductBrand,LabelsPerSheet from products  where ManufactureID='".$id."'");
		$res=$query->row_array();
	
			if(preg_match("/Roll Labels/i",$res['ProductBrand'])){
				$roll = 'yes'; 	
			}else{ $roll = 'No';}
		return array('Roll'=>$roll,'LabelsPersheet'=>$res['LabelsPerSheet'],'ProductBrand'=>$res['ProductBrand']);
	}	
    
    
    
	function check_price_uplift($total_price){
		$total_price = $total_price/0.94; // 6% increment yearly march 2018
		return $total_price;
	}
    
    
	function getmaterialcode($text){
			
		preg_match('/(\d+)\D*$/', $text, $m);
		$lastnum = $m[1];
		$mat_code = explode($lastnum,$text);
		return strtoupper($mat_code[1]);
	}
    
    
	function check_material_discount($material_code,$keys = false)
	{
		$discounts = array();
		
		$discounts['RDP'] = 25;
		$discounts['YWP'] = 25;
		$discounts['LGN'] = 25;
		$discounts['GNP'] = 25;
		$discounts['BEP'] = 25;
		$discounts['MBEP'] = 25;
		$discounts['MBEP'] = 25;
		$discounts['ORP'] = 25;
		$discounts['MPY'] = 25;
		$discounts['MFP'] = 25;
		$discounts['FPNP'] = 25;
		$discounts['FRDP'] = 25;
		$discounts['FYWP'] = 25;
		$discounts['FGNP'] = 25;
		$discounts['FORP'] = 25;
		$discounts['RGDP'] = 25;
		$discounts['GDP'] = 25;
		$discounts['SRP'] = 25;
		$discounts['MLT'] = 25;
		$discounts['MLB'] = 25;
		$discounts['MLS'] = 25;
		$discounts['FMC'] = 25;
		$discounts['FQP'] = 25;
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
    
	function rolls_calculation($die_across, $max_labels,  $total_labels, $rolls=NULL){
		//echo      $max_labels ; echo '<br>';
		//echo     $total_labels ; echo '<br>';
		//echo      $rolls ; echo '<br>';echo '<br>';echo '<br>';
        
        
		if($rolls!=NULL){
			$rolls = $rolls+$die_across;  
		} else{
			$rolls = $die_across; 
		}
        
		$per_roll = $total_labels/$rolls; //echo '<br>';
		if($per_roll > $max_labels){
			$response = $this->rolls_calculation($die_across, $max_labels, $total_labels, $rolls);
			$per_roll = $response['per_roll'];
			$rolls = $response['rolls'];
		}
			
		$data['per_roll'] 	    = ceil($per_roll);
		$data['total_labels']   = ceil($per_roll)*$rolls;
		$data['actual_labels']  = $total_labels;
		$data['rolls'] = $rolls;
		//echo '<pre>'; print_r($data); echo '</pre>';
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
		$result = $this->db->query("select SheetPrice from tbl_product_batchprice WHERE ManufactureID = '$code' AND  BatchID =   1");
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
    
    
	function get_db_column($table, $column, $key, $value){
		$row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '".$value."' LIMIT 1 ")->row_array();		
		return (isset($row[$column]) and $row[$column]!='')?$row[$column]:'';
	}
    
	function material_sqr_cost($menfactureid){
		
		$code = $this->getmaterialcode($menfactureid);
		$query = $this->db->query("SELECT PrintPrice FROM `material_prices` WHERE Code LIKE '".$code."' LIMIT 1");	
		$row = $query->row_array();
		return $row['PrintPrice'];		
	}
    
    
	function calclateprice($manufature=NULL,$rolls=NULL,$label=NULL){
	 
		if(isset($rolls) and $rolls > 0 and isset($label) and $label > 99){
		
			$total_price = $this->calculate_material($manufature,$label,$rolls);
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
    
    
	function calculate_material($ManufactureID,$Labels,$Rolls){
		
		$query = $this->db->query("SELECT Width,Height FROM `products` as p INNER JOIN category ON SUBSTRING_INDEX(p.CategoryID, 'R', 1) = category.CategoryID 
		Where ManufactureID LIKE '".$ManufactureID."' ");
		
		$query = $query->row_array();
		
		$width  = $query['Width'];
		$height = $query['Height'];
		
		$ManufactureID = substr($ManufactureID,0,-1);
		
		$info = $this->which_material($ManufactureID);
		$gruop = $this->which_group($width, $height);
		$Labels = $this->calculate_labels_sheets($ManufactureID,$Labels);
		
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
	
    
	function calculate_labels_sheets($manufature,$label){
		$qurey = $this->db->query("SELECT Labels FROM `tbl_batch_labels` Where ManufactureID LIKE '".$manufature."' ORDER BY Labels ASC");
		$result = $qurey->result();
		$labelpersheet_is='';
		
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
    
	function calculate_por($menucode, $table,$rolls,$labels){
		$field = 'Labels_'.$labels;
		$query =    $this->db->query("Select $field from tbl_batch_roll INNER JOIN $table  
						  ON tbl_batch_roll.batch_id=$table.batch_id WHERE ManufactureID LIKE '".$menucode."' AND tbl_batch_roll.Rolls = $rolls ");
		$row = $query->row_array();	
		return $row[$field];
	}
    
    
    
	function min_roll_price($manufature1,$Roll,$labels){
		$manufature = substr($manufature1,0,-1);
		$price = $this->calclateprice($manufature1,$Roll,$labels);
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
    
    
    
    
    
    /*  public function UpdateItems($ProductBrand,$ManufactureID,$qty,$printing,$labels,$Print_Type,$FinishType){
          
		  
		  if(preg_match('/Roll Labels/is',$ProductBrand) && $printing=="Y"){
              
		          //$labels = $this->input->post('labels');
				  $finish = $FinishType;
				  $press  = $Print_Type;
              
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
						
						$userID = '616100'; //$this->session->userdata('Order_person');
						if((isset($userID) and !empty($userID)))
						{
							echo $wholesale = $this->get_db_column('customers','wholesale','UserID',$userID);
							if($wholesale == "wholesale")
							{
								echo $custom_price = $this->apply_discount($userID, $collection['manufature'],$custom_price);
							}
						}
					  
					  $unitPrice = $custom_price/$qty;
			          $UnitPrice = number_format(round($unitPrice,3),3,'.','');
					  
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
						$wpep_discount = 0.00;
						$custom_price = $this->getPrize($qty,$ManufactureID);
						//$ProductBrand = $this->ProductBrand($ManufactureID);
						 if(preg_match("/A4 Labels/i",$ProductBrand)){
							$mat_code = $this->getmaterialcode($ManufactureID);
							$material_discount = $this->check_material_discount($mat_code);
							if($material_discount){
								$custom_price = ($custom_price*1.2);
								$wpep_discount = (($custom_price)*($material_discount/100));
								$total = $custom_price-$wpep_discount;
								$custom_price = $total/1.2;
							}	
						}
				
						$unitPrice = $custom_price/$qty;
						$UnitPrice = number_format(round($unitPrice,3),3,'.','');
              
				$data = array(
                  'Quantity' 	 => $qty,
			      'UnitPrice' 	 => $UnitPrice,
			      'TotalPrice' => $custom_price
                 );
		  }
		  
            //$arr = array('unitPrice'=>$data);
            return  json_encode($data);
		
		
	}*/
	
}




