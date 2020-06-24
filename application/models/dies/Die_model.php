<?php 
	if (!defined('BASEPATH'))
    	exit('No direct script access allowed');

class die_model extends CI_Model {
	
	public function fetch_comments_count($serial){
	   $qry = $this->db->query("select count(*) as comments from flexible_die_comments where serial = '".$serial."'")->row_array();
	   return $qry['comments'];
	}
	
	public function fetch_comments($serial){
	   $qry = $this->db->query("select * from flexible_die_comments where serial = $serial order by ID asc ")->result();
	   return $qry;
	}
	
	public function fetch_comments2($serial){
	   $qry = $this->db->query("select * from flexible_die_commentsdata where serial = '".$serial."' order by ID desc")->result();
	   return $qry;
	}
    
    
    public function fetch_comments2_co($serial){
	   $qry = $this->db->query("select count(*) as com from flexible_die_commentsdata where serial = '".$serial."' ")->row_array();
	   return $qry['com'];
	}
    
    
    public function fetch_custom_die_quote_counts($id){
	   $query = $this->db->query("SELECT * from flexible_dies_info WHERE ID = '".$id."' ");
	   $row = $query->row_array();	
	   return $row;
	 }
    
    
	public function fetch_comments_count2($serial){
	   $qry = $this->db->query("select count(*) as comments from flexible_die_commentsdata where serial = '".$serial."'")->row_array();
	   return $qry['comments'];
	}
	
	public function fetch_irregular(){
	 $qry = $this->db->query("SELECT quotationdetails.SerialNumber,quotationdetails.QuotationNumber from quotationdetails INNER JOIN quotations ON quotations.QuotationNumber = quotationdetails.QuotationNumber WHERE quotations.QuotationStatus = 37  AND quotationdetails.ManufactureID LIKE 'SCO1' AND quotationdetails.die_approve LIKE 'N' ")->result();
	  return $qry;
	}
	
	public function fetch_standard(){
	// $qry = $this->db->query("select * from flexible_dies where type LIKE 'custom' and Status !=7 ")->result();
	 $qry = $this->db->query("SELECT * from flexible_dies INNER JOIN orders ON orders.OrderNumber LIKE flexible_dies.OrderNumber WHERE (orders.OrderStatus = 32 || orders.OrderStatus = 2 || orders.OrderStatus = 55 || orders.OrderStatus = 56)  AND flexible_dies.type LIKE 'custom' and flexible_dies.Status !=7 ")->result();
	  return $qry;
	}
	
	public function fetch_pending(){
	 $qry = $this->db->query("SELECT quotations.currency,quotations.exchange_rate,quotationdetails.SerialNumber,quotationdetails.QuotationNumber,quotationdetails.ProductTotal from quotationdetails INNER JOIN quotations ON quotations.QuotationNumber = quotationdetails.QuotationNumber WHERE quotations.QuotationStatus = 37  AND quotationdetails.ManufactureID LIKE 'SCO1' AND quotationdetails.die_approve LIKE 'Y' ")->result();
	  return $qry;
	}
	
	
	public function fetch_reorderdies(){
	  $qry = $this->db->query("select * from flexible_dies where type LIKE 'reorder' ")->result();
	  return $qry;
	}
	
	public function fetch_pricing($serial){
	  $qry = $this->db->query("select * from flexible_pricing where serial = '".$serial."'")->result();
	  return $qry;
	}
	
	public function fetchdierecord($id){
	  $qry = $this->db->query("select * from flexible_dies where ID = $id");
	  return $qry->row_array();
	}
	
	public function updatediestable($id,$array){
	  $this->db->where('ID',$id);
	  $this->db->update('flexible_dies',$array);
	  return 'updated';
	}
	
	public function fetch_info($code){
	  $qry = $this->db->query("SELECT * FROM category WHERE CategoryImage LIKE '%".$code."%'")->row_array();
	  return $qry;
	}
	public function fetchdierecordinfo($id){
	  $qry = $this->db->query("select * from flexible_dies_info where ID = $id");
	  return $qry->row_array();
	}
	
	public function fetchmaterinfo($id){
	  $qry = $this->db->query("select * from flexible_dies_mat where ID = $id");
	  return $qry->row_array();
	}
	
	public function fetch_aplied_pricing($serial){
	  $qry = $this->db->query("select * from flexible_pricing where serial = '$serial' and status = '1' ")->row_array();
	  return $qry;
	}
	
	public function pricecheck($id){
	  $qry = $this->db->query("select count(*) as total from flexible_dies_mat where OID = '".$id."' and tempprice = 0 ")->row_array();
	  return $qry['total'];
	}
	
	public function statuscheck($id){
	  $qry = $this->db->query("select count(*) as total from flexible_dies_mat where OID = $id and status = 0 ")->row_array();
	  return $qry['total'];
	}
	
	public function fetchsupplier($id){
		if($id){
			
	
	  $qry = $this->db->query("select * from flexible_pricing where serial = $id and status = '1' ")->row_array();
	  return $qry['supplier'];
				}else{
			return "";
		}
	}
	
	
	

	//**********************************************************************************************
	
	 public function  calculate_print_material($manufature,$Labels,$finish,$rolls,$details){
		$width  = $details['width'];
		$height = $details['height'];
		$max_labels = $details['labels'];
		
		$across = $this->quoteModel->get_roll_qty($manufature.'1');
		$labour_cost = $this->quoteModel->labour_cost_roll($across,$Labels);
		$por_discount = $this->quoteModel->calculate_discount($Labels,$manufature.'1');
		$discount_percentage = $por_discount['discounts'];
		$por = (100-$por_discount['por'])/100;
		
		$material_sqr_cost = $this->quoteModel->material_sqr_cost($manufature);
		$sqaure_meter = ($Labels*($width*$height)/1000000);
		$material_cost = ($material_sqr_cost)*$sqaure_meter;
		$ink_cost = $sqaure_meter*1;
		$extra_cost = 0;
		
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
			 	$price = $this->quoteModel->check_price_uplift($price);
				$label_finish = $this->quoteModel->check_price_uplift($label_finish);
		/********************** price uplift **************/
		
		return array('price'=>$price,'label_finish'=>$label_finish);
		//$price = $price+$label_finish;
		//return $price;
	 }
	
	 function calclateprice($manufature=NULL,$rolls=NULL,$label=NULL,$width,$height,$code){
	 
	  if(isset($rolls) and $rolls > 0 and isset($label) and $label > 99){
		
			 $total_price = $this->custom_calculate_material($manufature,$label,$rolls,$width,$height,$code);
             $total_price = $total_price/0.94; // 6% increment yearly 
             
              /******** price uplift ********************************/
			 	$total_price = $this->quoteModel->check_price_uplift($total_price);
			 /********************** price uplift **************/
			 
			 $final_price =sprintf('%.2f', round($total_price,2));
			 $unit_price  =sprintf('%.2f', round($total_price/$rolls,2));
			 $perlabel = number_format(($unit_price/$label)*100,2);
			 return $data = array('perlabel'=>$perlabel,'final_price'=>$final_price,'unit_prcie'=>$unit_price,'Labels'=>$label);
			
		  }else{
			 return $data = array('perlabel'=>0.00,'final_price'=>0.00,'unit_prcie'=>0.00,'Labels'=>0.00);
		}
    }
	
	
	 public function calculate_printing_price($collection,$details){
	      $rolls  = $collection['rolls']; 
		  $labels = $collection['labels']; 
		  $manufature = $collection['manufature'];
		  $finish = $collection['finish'];
		  $printing = $details['printing'];
		//  print_r($collection); echo "<br>";
		  if(isset($labels) and  $labels > 0){
			$total_price = $this->calculate_print_material($manufature,$labels,$finish,$rolls,$details);
			/**********************************************************************/
			 $label_finish  = $total_price['label_finish']; 
			 $printprice    = $total_price['price']; 
			 if($printing == '6 Colour Digital Process + White'){
			   $printprice = (1.1)*$printprice;  // - Full Colour + White Increase 10%  
			 }
			
			$labels_per_roll = $labels/$rolls;
			if($labels_per_roll < 99){ $labels_per_roll = 100;}
			$plainprice = $this->calclateprice($manufature, $rolls, $labels_per_roll,$details['width'],$details['height'],$details['material']);
			$plainprice = $plainprice['final_price'];
			$minus_print_price = $printprice - $plainprice;
			$discount_price = $minus_print_price/2;
			$total_price = $printprice-$discount_price+$label_finish;
		  
		  /**********************************************************************/
				  	 
			$final_price =sprintf('%.2f', round($total_price,2));
			$unit_price  =sprintf('%.2f', round($total_price/$rolls,2));
			$perlabel = number_format(($unit_price/$labels)*100,2); 
			$price_res = array('perlabel'=>$perlabel,'final_price'=>$final_price,'unit_prcie'=>$unit_price,'Labels'=>$labels);
			//print_r($price_res); echo "<br>";
		  }else{
			$price_res = array('perlabel'=>0.00,'final_price'=>0.00,'unit_prcie'=>0.00,'Labels'=>0.00);
		  }
		  return $price_res;
	  }
	   
	public function applyrollprice($id,$matid){ 
	  $dierray = $this->fetchdierecordinfo($id);
	  $mayrray = $this->fetchmaterinfo($matid);
	  $details = array_merge($dierray,$mayrray);
	  
	  $manufature = $details['tempcode'].$details['material'];
	  $label = $details['labels'];
	  $rolls = $details['qty'];
	  $width = $details['width'];
	  $height = $details['height'];
	  $code = $details['material'];
	  $rolllabels = $details['rolllabels'];
	  $finish = $details['finish'];
	  $qty = $details['qty'];
	  
	  
	     if($details['labeltype']=="printed"){
			 $min_qty = $this->quoteModel->get_roll_qty($manufature.'1');
			 $response = $this->quoteModel->rolls_calculation($min_qty,$label,$rolllabels); 
			   $collection['labels'] 	= $response['total_labels']; 
			   $collection['manufature'] = $manufature;
			   $collection['finish']     = $finish;
			   $collection['rolls']      = $response['rolls'];
			   $price_res = $this->calculate_printing_price($collection,$details);
			   $custom_price = $price_res['final_price'];
				
				 if($qty>$response['rolls']){
				  $add_rolls = $qty - $response['rolls'];
				  $additional_cost = $this->quoteModel->additional_charges_rolls($add_rolls);
				  $custom_price = $custom_price + $additional_cost;
				 }
				 
				 $labels = $response['total_labels'];
				 $unitPrice = $custom_price/$qty;
				 $custom_price =sprintf('%.2f', round($custom_price,2));
				 $UnitPrice = number_format(round($unitPrice,3),3,'.','');
			     
				 $data = array('perlabel'=>$perlabel,'final_price'=>$custom_price,'unit_prcie'=>$UnitPrice,'Labels'=>$labels);
			}else{
			   $label = $rolllabels/$qty;
			   if(isset($rolls) and $rolls > 0 and isset($label) and $label > 99){ 
			      $total_price = $this->custom_calculate_material($manufature,$label,$rolls,$width,$height,$code);
			      $total_price = $total_price/0.94; // 6% increment yearly
				
				/******** price uplift ********************************/
			 		$total_price = $this->quoteModel->check_price_uplift($total_price);
			 	/********************** price uplift **************/
			 
			 
			 
				         if((preg_match("/HGP/i",$manufature))){
							$total_price = ($total_price*1.2);
							$wpep_discount = (($total_price)*(30/100));
							$total_price = $total_price-$wpep_discount;
							$total_price = $total_price/1.2;
						}
		
				 $final_price =sprintf('%.2f', round($total_price,2));
				 $unit_price  =sprintf('%.2f', round($total_price/$rolls,2));
				 $perlabel = number_format(($unit_price/$label)*100,2);
				 $data = array('perlabel'=>$perlabel,'final_price'=>$final_price,'unit_prcie'=>$unit_price,'Labels'=>$label);
			   }else{
				 $data = array('perlabel'=>0.00,'final_price'=>0.00,'unit_prcie'=>0.00,'Labels'=>0.00);
				}
		  }
		  return $data;
	 // echo "<pre>";
//	  print_r($data);
//	  echo "</pre>";
//	  die($id);
	 }
	 
	  function custom_calculate_material($manufature,$Labels,$Rolls,$width,$height,$code){
		$info = $this->custom_which_material($code); 
		$gruop = $this->quoteModel->which_group($width,$height); 
        $Labels = $this->quoteModel->calculate_labels_sheets($manufature,$Labels);
		
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
		$roll = $this->quoteModel->calculate_rolls_qty($manufature,$Rolls);
		$por = $this->quoteModel->calculate_por($manufature,$table,$roll,$Labels);
		$por = (1-($por/100));
	
		$sale_price = $per_roll_price/$por;
		return $sale_price;
	 }
	 
	 function custom_which_material($code){
	   $query = $this->db->query("SELECT Price FROM `material_prices` WHERE Code LIKE '".$code."' LIMIT 1");	
		$row = $query->row_array();
		$price =  $row['Price'];
		if($price >= 1.3 ){
		   $type = 'b';  //high Materials		
		}else{
		   $type = 'a';  //Low Materials	
		}
		return array('price'=>$price,'type'=>$type);
	 }
	 
	public function re_orderfetch_aplied_pricing($serial){ error_reporting(E_ALL);
	  $qry = $this->db->query("select * from reorder_flexiblepricing where serial = '$serial' and status = '1' ")->row_array();
	  return $qry;
	}
	
	public function reorder_fetchdierecord($id){
	  $qry = $this->db->query("select * from reorder_flexiblepricing where ID = $id");
	  return $qry->row_array();
	}
	public function reorder_flexiblepricing($serial){
	  $qry = $this->db->query("select * from reorder_flexiblepricing where serial = '".$serial."'")->result();
	  return $qry;
	}

   public function changeStatus($status,$categoryId){
        $this->db->set(array('is_euro'=>$status));
        $this->db->where('CategoryID',$categoryId);
        return $this->db->update('category');
    }
     public function getProducts($code,$status){
	  $products = $this->db->query("select ProductID,ManufactureID,ProductCategoryName from products where CategoryID = '".$code."' ")->result();
		  foreach ($products as $product){
		 if(preg_match('/PVUD/is',$product->ManufactureID) || preg_match('/MBV/is',$product->ManufactureID) ){

		 }else{
				  $EuroID = ($status == 'Y')?'AA'.(substr($product->ManufactureID, 2)):'';
				  $ProductCategoryName = ($status == 'Y')?(str_replace("A4 Sheet","A4 Dry Edge Sheet",$product->ProductCategoryName)):(str_replace("A4 Dry Edge Sheet","A4 Sheet",$product->ProductCategoryName));
				  $this->db->where('ProductID',$product->ProductID);
				  $this->db->update('products',array('EuroID'=>$EuroID,'ProductCategoryName'=>$ProductCategoryName));
		 }
			}
		 }

	public function insertLog($record){
		$this->db->insert('euro_standrd_logs',$record);
	}
	
	function get_operator($operator){
			$qry = $this->db->query("select UserName from customers where UserID = $operator ");
			$data = $qry->row_array();
			return $data['UserName']; 
		}
    
	public function fetch_custom_die_quote($id){
		$query = $this->db->query("SELECT * from flexible_dies_info WHERE QID = '".$id."' ");
		$row = $query->row_array();	
		return $row;
	}
    
	function fetch_custom_die_association($id){
		return $this->db->query("select * from flexible_dies_mat where OID = '".$id."'")->result();
	}
	
	
	function get_currecy_symbol($code){
			 $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$code."'");
			 $sql = $sql->row_array();
			 return $sql['symbol'];
	}
	
	public function getstatus($id) {
         
        $query = $this->db->get_where('dropshipstatusmanager', array('StatusID' => $id));
        return $query->result();
    }

	
	
}
?>