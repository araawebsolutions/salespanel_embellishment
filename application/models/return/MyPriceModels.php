<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class myPriceModels extends CI_Model
{

// for plain roll price
	function calculatePlainRollPrice($manufature=NULL,$rolls=NULL,$label=NULL){

		if(isset($rolls) and $rolls > 0 and isset($label) and $label > 99){

			$total_price = $this->home_model->calculate_material($manufature,$label,$rolls);
			$total_price = $total_price/0.94; // 6% increment yearly
			
			/******** price uplift ********************************/
			$total_price = $this->home_model->check_price_uplift($total_price);
			/********************** price uplift **************/
			$final_price =sprintf('%.2f', round($total_price,2));
			$unit_price  =sprintf('%.2f', round($total_price/$rolls,2));
			$perlabel = number_format(($unit_price/$label)*100,2);
			return $data = array('perlabel'=>$perlabel,'price'=>$final_price,'unit_prcie'=>$unit_price,'Labels'=>$label);
		}else{
			return $data = array('perlabel'=>0.00,'price'=>0.00,'unit_prcie'=>0.00,'Labels'=>0.00);
		}
	}
	// for printed roll and  sheet price
	function calculatePrintedRollPrice($data){

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
		
		if($producttype == 'sheet'){

			$sheets = ceil($labels/$persheets);
			//$sheets  = $labels;
			// $labels = $persheets*$labels;
			$data=$this->product_model->ajax_price($sheets, $menu);

			$price = $data['custom_price'];
			$printprice = 0.00;
			$designprice = 0.00;
			$free_artworks = 1;
			
			if($labeltype=='Mono' || $labeltype=='Fullcolour'){
				$printprice = $this->home_model->calculate_printed_sheets($sheets, $labeltype, $design, $data['brand'], $menu);
				$free_artworks = $printprice['artworks'];
				$designprice = $printprice['desginprice'];
				$printprice = $printprice['price'];
				//$printprice = 0;
			}
		}
		else{
			$pressproof = $data['pressproof'];
			$rollfinish = $data['finish'];

			//$rolls = (isset($data['rolls']) and $data['rolls']!='')?$data['rolls']:'';

			$min_qty = $this->home_model->min_qty_roll($menu);
			$response = $this->home_model->rolls_calculation($min_qty, $persheets, $labels);

			$labels   = $response['total_labels'];
			$labels_per_rolls = $response['per_roll'];
			$sheets = $response['rolls'];
			$collection['labels'] 	  = $labels;
			$collection['manufature'] = $menu;
			$collection['finish']     = $data['finish'];
			$collection['rolls']      = $sheets;
			$collection['labeltype']      = $labeltype;

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
			if($pressproof == 1){
				$pressproofprice = 50.00;
			}
			/*************** Roll Labels Price *************/
		}
		//$('.nlabelfilter').trigger('mouseover');
		
		$delivery_txt = $this->shopping_model->delevery_txt();
		$plainprice = number_format($price,2,'.','');
		$price = $designprice+$printprice+$price+$pressproofprice;
		$price = number_format($price,2,'.','');
		$pressproofprice = number_format($pressproofprice,2,'.','');
		$delivery_txt = '';
		if($price > 25){
			$delivery_txt = '<b> Free Delivery </b>';
		}
		// echo $price.' = '.$labels;exit;
		$priceperlabels = number_format(($price/$labels),3,'.','');

		$price_array = array(
			// 'price'=>$price, // NOT USED
			// 'plainprint'=>($plainprice+$printprice), // NOT USED
			'price'=>0, 
			'plainprint'=>0, 
			'plainprice'=>$plainprice,   // 1st LINE
			'printprice'=>$printprice,  // 2ND LINE
			'designprice'=>$designprice,  // 2ND LINE
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
	// for plain sheet
	function calculatePlainSheetPrice($qty,$mafatureid){
		$id = $mafatureid;
		error_reporting(0);
		if(substr($id,-2,2)=='XS'){
			$row = $this->db->query("Select count(*) as total,`Price` from xmass_prices where Qty LIKE '".$qty."' LIMIT 1");
			$result = $row->row_array();
			if($result['total']==1){
				$custom_price	=	 number_format($result['Price']/1.2,2,'.','');
				$custom_price	=	 number_format($custom_price,2,'.','');
				$data =	 array('custom_price' =>$custom_price);
			}else{
				$data =	 array('custom_price' =>4.15);
			}
			return $data;
		}

		$roll = $this->product_model->Is_ProductBrand_roll($id);
		
		if($roll['Roll']=='yes'){
			$custom_price = $this->home_model->calclateprice($id,$qty,$roll['LabelsPersheet']);
			$custom_price	=	 number_format(round($custom_price['final_price'],2),2,'.','');
			$custom_price	=	 number_format(round($custom_price,2),2,'.','');
			$data 			=	 array('custom_price' => $custom_price);
			return $data;
		}

		if($roll['ProductBrand']=='Application Labels' ){
			$response = $this->Product_model->lba_pack_details(array('ManufactureID'=>$id));
			$qty = $qty*$response['packsize'];
			if($qty < 25){
				return $this->Product_model->calculate_lba_price($qty, $id);
			}
		}


		$case	=	'';
		$q 		= 	$this->db->query("select tbl.ManufactureID,tbl.BatchID,tbl.SetupCost,tbl.SheetPrice,batch.BatchQty from tbl_product_batchprice tbl,tbl_batch batch where tbl.ManufactureID='$id' and tbl.BatchID= batch.BatchID ORDER BY tbl.BatchID Asc ");
		$res 	= $q->result_array();
		$j		= 0;
		$row	= '';

		foreach($res as $row[]){
			
		}

		$arrsize=count($row);
		$flag = 0;

		$flag = 0;
		for ($traverse=0;$traverse<$arrsize-1;$traverse++)
		{

			if ($qty<100) {
				$flag = 1;
				$oppertunity_quan=$row[0]['BatchQty'];
				$oppertunity_sheet=$row[0]['SheetPrice'];
				$oppertunity_total=$oppertunity_quan*$oppertunity_sheet;
				$sheetprice = $row[0]['SheetPrice'];
				$setupcost = $row[0]['SetupCost'];
				$custom_price=($sheetprice * $qty) + $setupcost;
			}
			if ($qty >= $row[$traverse]['BatchQty'] && $qty < $row[$traverse+1]['BatchQty']){

				$flag = 1;
				$batch=$row[$traverse]['BatchQty'];

				$setupcost = $row[$traverse+1]['SetupCost'];
				if ($qty == $row[$traverse]['BatchQty'])
				{
					$sheetprice = $row[$traverse]['SheetPrice'];
					$batch=$row[$traverse]['BatchQty'];
					$custom_price=($sheetprice * $qty);
					break;
				}
				else
				{
					$sheetprice = $row[$traverse+1]['SheetPrice'];
					$sheetprice1 = $row[$traverse]['SheetPrice'];
					$batch=$row[$traverse]['BatchQty'];
					$custom_price=($sheetprice * $qty) + $setupcost;
					$custom_price1= $sheetprice1 * $batch;
					if($custom_price < $custom_price1){
						
						$custom_price=$custom_price1 + (($qty-$batch) * $sheetprice);

					}

					if (substr($row[$traverse]['ManufactureID'],0,2) == "SR" || substr($row[$traverse]['ManufactureID'],0,2) == "sr") {
						$custom_price=$custom_price1 + (($qty-$batch) * $sheetprice);
					}
					$oppertunity_quan=$row[$traverse+1]['BatchQty'];
					$oppertunity_sheet=$row[$traverse+1]['SheetPrice'];
					$oppertunity_total=$oppertunity_quan*$oppertunity_sheet;
					break;
				}
			}
		}


		if($flag == 0)
		{
			$sheetprice = $row[$traverse]['SheetPrice'];
			$setupcost = $row[$traverse]['SetupCost'];
			if ($qty == $row[$traverse]['BatchQty'])
			{
				$batch=$row[$traverse]['BatchQty'];
				$custom_price=($sheetprice * $qty);
				//  break;
			}
			else
			{
				$batch=$row[$traverse]['BatchQty'];
				$custom_price=($sheetprice * $qty) + $setupcost;
				//  break;
			}
		}


		if($roll['ProductBrand']=='Application Labels' ){
			$printprice = $this->home_model->calculate_printed_sheets($qty, 'Fullcolour', 1);
			$custom_price = $custom_price+$printprice['price'];
		}
		$custom_price = $this->home_model->check_price_uplift($custom_price);
		$custom_price=number_format(round($custom_price,2),2,'.','');
		$custom_price	=	 number_format(round($custom_price,2),2,'.','');
		$data 			=	 array('price' => $custom_price);
		return $data;
	}

	// for integrated labels
	function get_box_price($manufatureid,$box,$batch,$print){

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
				$array = array(
					'print_price' => $PrintPrice,
					'plain_price' => $PlainPrice,
					'black_price' => $BlackPrice,
					'price' => $total,
					'per_sheet' => sprintf('%.4f', round($total/$box,4)),
					'symbol' => symbol,
					'vatoption' => vatoption,
					'dpd' => number_format($dpd,2),
				);
			}
		}
		return $array;
	}


	public function getPriceForQuotation($data){
		$result = "";
		if($data['printing'] != 'Y' && $data['brand'] == 'Roll Labels'){
			$result = $this->calculatePlainRollPrice($data['manfactureId'],$data['rolls'],$data['labelsPerSheet']);
		}

		elseif($data['printing'] != 'Y' && $data['brand'] != 'Roll Labels'){
			$result = $this->calculatePlainSheetPrice($data['qty'],$data['manfactureId']);
		}
		elseif( $data['brand'] == 'Integrated Labels'){
		}
		else{
			$record = $this->calculatePrintedRollPrice($data);
			$result = $this->checkForWholeSaleCustomer($record,$data['customerId'],$data['producttype']);
		}
		return $this->sendResponse($result);
	}

	public function getPrice($orderNumber,$manufactureId,$data=null){
		
		return $this->makeParamAndGetRecord($this->getWholeRecord($orderNumber,$manufactureId),$data);
	}

	public function makeParamAndGetRecord($record,$data){
		//echo '<pre>';
		// print_r($record->ProductBrand);exit;
		//print_r($record->Printing);exit;
		if($record->ProductBrand == 'Integrated Labels'){
			$box = $this->getBox($record->ProductName);
			$result = $this->get_box_price($record->ManufactureID,$record->labels,$box,'');
		}
		elseif($record->ProductBrand == 'Roll Labels'  && $record->Printing != 'Y'){
			// if you want to count with custom price with custom data
			if(isset($data['qty']) || isset($data['statics'])){
				//data static variable use when on checkout tab use change from plain to printed or printed to plain
				$data['qty'] = (isset($data['qty']))?$data['qty']:$data['statics']->totalQuantity;
				$result = $this->calculatePlainRollPrice($record->ManufactureID,$data['qty'],$record->LabelsPerSheet);
			}else{
				$result = $this->calculatePlainRollPrice($record->ManufactureID,$record->Quantity,$record->LabelsPerSheet);
			}
		}

		elseif($record->ProductBrand != 'Roll Labels'  && $record->Printing != 'Y'){
			
			if(isset($data['qty']) || isset($data['statics'])){
				//data static variable use when on checkout tab use change from plain to printed or printed to plain
				$data['qty'] = (isset($data['qty']))?$data['qty']:$data['statics']->totalQuantity;
				$result = $this->calculatePlainSheetPrice($data['qty'],$data['manfactureId']);
			}else{
				
				$result = $this->calculatePlainSheetPrice($record->Quantity,$record->ManufactureID);
			}
		}

		else{
			//echo 'here';exit;
			// echo '<pre>';
			// print_r($data);exit;
			// print_r($record->labels);exit;
			$params = array(
				'labeltype'=>$record->Print_Type,
				'labels'=>(isset($data['statics']))?$data['statics']->totalLabels:$record->labels,
				'design'=>(isset($record->Print_Design))?$record->Print_Design:$this->getNumberOfDesign($record->SerialNumber),
				'menu'=>$record->ManufactureID,
				'persheets'=>(isset($data['statics']->per_shet_roll))?($data['per_shet_roll']):$record->LabelsPerSheet,
				'producttype'=>($record->ProductBrand == 'Roll Labels')?'Rolls':'sheet',
				'pressproof'=>$record->pressproof,
				'finish'=>$record->FinishType,
				'brand'=>$record->ProductBrand
			);
			//print_r($params);exit;
			$record = $this->calculatePrintedRollPrice($params);
			//print_r($result);exit;
			echo $customerId = '616100'; //$this->session->userdata('customer_id');
			$result = $this->checkForWholeSaleCustomer($record,$customerId,$params['producttype']);
		}
		// print_r($result);exit;
		$myPrice = $this->sendResponse($result);
		echo json_encode($myPrice);
	}
	public function checkForWholeSaleCustomer($result,$customerId,$productType){

		$customer = $this->getCustomer($customerId);

		if($customer->wholesale == 'wholesale' && $productType == 'Rolls'){

			$result['price'] =number_format( ($result['price'] -  (($result['price'] *$customer->printed_discount)/100)) ,2);
			$result['plainprint'] =number_format( ($result['plainprint'] -  (($result['plainprint'] *$customer->printed_discount)/100)) ,2);
			$result['plainprice'] =number_format( ($result['plainprice'] - (($result['plainprice'] *$customer->printed_discount)/100)),2);
			$result['printprice'] =number_format( ($result['printprice'] - (($result['printprice'] *$customer->printed_discount)/100)),2);

			return $result;

		}else{
			return $result;
		}
	}

	public function getCustomer($customerId){
		$results = $this->db->select("c.*")
			->from('customers as c')
			->where('c.UserID',$customerId)
			->get()->row();
		return $results;
	}

	public function sendResponse($result){
		
		$data = array('price'=>(isset($result['price']) && $result['price'] >0)?$result['price']:0,'record'=>$result);
		//print_r($data);exit;
		return $data;
	}

	public function getWholeRecord($orderNumber,$manufactureId){
		$results = $this->db->select("o.*,od.*,cat.*,p.ProductBrand,p.LabelsPerSheet")
			->from('orders as o')
			->join('orderdetails as od','o.OrderNumber = od.OrderNumber','left')
			->join('products as p', 'od.ProductID = p.ProductID','left')
			->join('category as cat','p.CategoryID = cat.CategoryID','left')
			->where('o.OrderNumber',$orderNumber)
			->like('od.ManufactureID',$manufactureId)
			->get()->row();
		return $results;
	}

	public function getNumberOfDesign($serialNumber){
		$results = $this->db->select("count(*)as total")
			->from('order_attachments_integrated as o')
			->where('o.Serial',$serialNumber)
			->get()->row();
		return $results->total;
	}

	public function getBox($record){
		
		$record = explode('(',$record);

		$res = 0;
		if(isset($record[1])){
			if (strpos($record[1], '1000') !== false) {
				$res = 1000;
			}elseif(strpos($record[1], '250') !== false){
				$res = 250;
			}
			return $res;
		}else{
			return 0;
		}

	}

}