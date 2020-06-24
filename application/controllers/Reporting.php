<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends CI_Controller {

	function __construct(){
		 parent::__construct();	
		 $this->load->database();
		 $this->load->model('Reporting_model');
		 $this->home_model->user_login_ajax();
	     error_reporting(E_ALL);     
    }
	 public function index(){
	        $this->load->library('Table');
		    $tmpl = array('table_open' => '<table class="table table-hover m-0 advancesearch table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
	        $this->table->set_template($tmpl);
	        
	        $this->table->set_heading('Date','Order No', 'Order Value', 'City / Town','Delivery Option','Shipping Service');

	        $data['shippingServices']   = $this->Reporting_model->getShipping();
	        $data['main_content']   = "reporting/searchReports";
	        $this->load->view('page', $data);
	 }
	 public function search_records_datatable(){  
			   
			   $courier = $this->input->post('courier');
			   $date = $this->input->post('date');
			   $shippingService = $this->input->post('shippingServices');

			   if( (isset($courier) && $courier != '') && (isset($date) && $date != '') )
			   {
					   $date1     = explode('-',$date);
					   $startdate = explode('/',$date1[0]);
					   $enddate   = explode('/',$date1[1]);
					   $From = strtotime(trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00');
					   $To   = strtotime(trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59');					   
						$where = "OrderDate >= '".$From."' AND OrderDate <= '".$To."' ";
							
						if($courier=="Both"){
							$where.= " AND (OrderDeliveryCourier = 'DPD' || OrderDeliveryCourier = 'Parcelforce') ";
						}
						else if($courier=="all"){
						}
						else{
							$where.= " AND OrderDeliveryCourier = '".$courier."' ";
						}
						
						if($shippingService == 'all'){

						}else if($shippingService != ''){

							$where.= " AND ShippingServiceID = '".$shippingService."' ";
						}
					    $this->datatables->select('FROM_UNIXTIME(OrderDate,"%d %M %Y") as OrderDate ,OrderNumber,(OrderTotal + OrderShippingAmount) AS total,DeliveryTownCity,OrderDeliveryCourier,  (SELECT ServiceName FROM shippingservices WHERE ServiceID = orders.ShippingServiceID ) as shippingServiceName ')->from('orders')->where($where);
					    echo $this->datatables->generate();
				}
	 }
	 function search_records(){
	   $courier = $this->input->post('courier');
	   $date = $this->input->post('date');
	   $shippingServices = $this->input->post('shippingServices');
	   $result = $this->Reporting_model->search_records($courier,$date, $shippingServices);
       echo json_encode($result);
	 }	

	 function download_courier_report(){
		$this->load->helper('download');
		header('Content-Type: application/csv');
		$name = 'courier_reporting.csv'; 
		header('Content-Disposition: attachment; filename="'.basename($name).'"');
		$fp = fopen('php://output', 'w');
		fputcsv($fp, array('Date',
					   'Order No',
					   'Order Value',
					   'City / Town',
					   'Delivery option',
					   'Shipping Service'
					   ));

		$courier = $this->input->post('courier-form');
	    $date = $this->input->post('reservation');
	    $shippingService = $this->input->post('service-form');
	   

		$date1     = explode('-',$date);
	   $startdate = explode('/',$date1[0]);
	   $enddate   = explode('/',$date1[1]);
	   $From = strtotime(trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00');
	   $To   = strtotime(trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59');					   
		$where = "OrderDate >= '".$From."' AND OrderDate <= '".$To."' ";
			
		if($courier=="Both")
		{
			$where.= " AND (OrderDeliveryCourier = 'DPD' || OrderDeliveryCourier = 'Parcelforce') ";
		}
		else if($courier=="all")
		{
		}
		else
		{
			$where.= " AND OrderDeliveryCourier = '".$courier."' ";
		}

		if($shippingService == 'all'){

		}else if($shippingService != ''){

			$where.= " AND ShippingServiceID = '".$shippingService."' ";
		}
		
	   $qry = "SELECT OrderDate,OrderNumber,(OrderTotal + OrderShippingAmount  ) AS total,DeliveryTownCity,OrderDeliveryCourier,  (SELECT ServiceName FROM shippingservices WHERE ServiceID = orders.ShippingServiceID) as shippingServiceName FROM orders where $where ";
	   
		$orders = $this->db->query($qry)->result();
         foreach($orders as $order){
         	  $singles = array("&ndash;", "-", "–");
			  $shippingServiceNames = str_replace($singles, " to ", $order->shippingServiceName);

			  fputcsv($fp, array( date("d F y",$order->OrderDate) ,$order->OrderNumber,$order->total,$order->DeliveryTownCity,$order->OrderDeliveryCourier, $shippingServiceNames ));
		  }
		
		$data = file_get_contents('php://output'); 
		force_download($name, $data);
		fclose($fp); 
	 }
	 
	 
	 
	 //-----------------------------------------**********************************--------------------------------------
	 
	 public function datateam(){
	  $data['main_content']   = "reporting/datateam";
	  $this->load->view('page', $data);
	 }
	 
	 public function download_report(){
	  if($_POST){
		
		if($_POST['report-form']==8){
		 return $this->volume_report();
		}else if($_POST['report-form']==9){
		 return $this->value_report();
		}else if($_POST['report-form']==10){
		 return $this->get_extra_reports($_POST['table-form'],$_POST['manufacturid']);
		}else{
		 $result = $this->Reporting_model->getReportRecord();	
		 return $this->exportCSV($result['records'],$result['header'],$result['filename']); 
		}
		
 	   }
	 }
	 
	 public function exportCSV($records,$header,$filename){   
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');
        fputcsv($file,$header); 
        foreach ($records as $key=>$line){
            fputcsv($file,$line);
        }
        fclose($file);
        exit;
    }
	
	 public function get_extra_reports($type,$manufactureId){
        $this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
        switch ($type){
	    	case 1:
			        $query = $this->db->query("SELECT * FROM category where CategoryImage LIKE '%$manufactureId%'" );
					$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
			        force_download('Category_Report.csv', $data);
			    break;
		    case 2:
			        $query = $this->db->query("SELECT * FROM products where ManufactureID LIKE '%$manufactureId%'" );
					$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
			        force_download('Product_Report.csv', $data);
		        break;
		    case 3:
		            $query = $this->db->query("SELECT * FROM tbl_product_batchprice where ManufactureID LIKE '%$manufactureId%'" );
		            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		            force_download('BatchPrice_Report.csv', $data);
		        break;
		    case 4:
                   $query = $this->db->query("SELECT * FROM tbl_batch_labels where ManufactureID LIKE '%$manufactureId%'" );
		           $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		           force_download('BatchLabel_Report.csv', $data);
		        break;
		    case 5:   
		           $query = $this->db->query("SELECT * FROM stock where diecode LIKE '%$manufactureId%'" );
		           $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		           force_download('Stock_Report.csv', $data);
		        break;
            case 6:
                   $query = $this->db->query("SELECT * FROM tbl_batch_roll where ManufactureID LIKE '%$manufactureId%'" );
		           $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		           force_download('BatchRoll_Report.csv', $data);
		        break;
		    case 7:     
		           $query = $this->db->query("SELECT * FROM tbl_roll_diameter where ManufactureID LIKE '%$manufactureId%'" );
		           $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		           force_download('RollDiameter_Report.csv', $data);  
                break;
            case 8:     
		           $query = $this->db->query("SELECT * FROM roll_discount_table where manufacture_id LIKE '%$manufactureId%'" );
		           $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		           force_download('RollDiscount_Report.csv', $data);  
                break;
             case 9:     
		           $query = $this->db->query("SELECT * FROM categorycore where CategoryId LIKE '$manufactureId'" );
		           $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		           force_download('Category_core_Report.csv', $data);  
                break;    
		     default:
             return  'false';

        }
            
	 }
	 
		 //-----------------------------------------**********************************--------------------------------------
    public function samples_firstorder(){ 
	   $this->load->library('Table');
	   $tmpl = array('table_open' => '<table class="table table-hover m-0 advancesearch table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
                 
        $this->table->set_template($tmpl);
        $this->table->set_heading('Sample Sent To','Email','Samples Number','Sample Date','Sample Country','Order Date','Order Number','Detail');
		
		$data['main_content']   = "reporting/advancesearch";
        $this->load->view('page', $data);
	  }
	  
	 function sample_records_datatable(){ 
	    $iDisplayStart  = intval($this->input->post("iDisplayStart"));
        $iDisplayLength = intval($this->input->post("iDisplayLength"));
        $sSearch        = $this->input->post("sSearch");
		$country        = $this->input->post("country_filter");
		
		/*=================================================== CONDITIONS ====================================================*/
	
		$where = '';
		if($sSearch != ''){
		 $where .= " and (orders.Billingemail like '%".$sSearch."%' or orders.OrderNumber like '%".$sSearch."%')";
		}
		if($country != '' and  $country != 'all'){
		 $where .= " and (orders.DeliveryCountry like '%".$country."%')";
		}
		
		$date_search = '';
		$From ='';$To='';
		if(isset($_POST['reservation']) && $_POST['reservation']!=""){
			$date      = $this->input->post('reservation');
			$date1     = explode('-',$date);
			$startdate = explode('/',$date1[0]);
			$enddate   = explode('/',$date1[1]);
			$From = trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00';
			$To   = trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59';
			$where .= " and (orders.OrderDate >= UNIX_TIMESTAMP('".$From."') AND orders.OrderDate <= UNIX_TIMESTAMP('".$To."'))";
		}
	
      /*===================================== CUSTOMER LIST WITH SAMPLE ORDER ====================================================*/
	$customers =  $this->db->query("select orders.UserID, CONCAT(orders.BillingFirstName, ' ', orders.BillingLastName) as username,orders.Billingemail as user_email,orders.OrderNumber,orders.OrderDate,orders.DeliveryCountry from orders where  orders.paymentmethods LIKE 'Sample Order' ".$where." group by orders.UserID order by orders.OrderNumber desc  LIMIT ".$iDisplayStart.", ".$iDisplayLength."  ")->result();
		
		$total =  $this->db->query("select orders.UserID, CONCAT(orders.BillingFirstName, ' ', orders.BillingLastName) as username,orders.Billingemail as user_email,orders.OrderNumber,orders.OrderDate,orders.DeliveryCountry from orders where  orders.paymentmethods LIKE 'Sample Order' ".$where." group by orders.UserID order by orders.OrderNumber desc ")->num_rows();
	
	/*===================================== CUSTOMER LIST WITH SAMPLE ORDER ====================================================*/
		$all_records = array();
		foreach($customers as $order){
		  $data['username']             = $order->username;
		  $data['user_email']           = $order->user_email;
		  $data['sample_order']         = $order->OrderNumber;
		  $data['sample_order_date']    = date('d-m-Y',$order->OrderDate);
		  $data['country']              = $order->DeliveryCountry;
		  
		  $orders_list = $this->get_latest_order_after_sample($order->UserID,$order->OrderDate);
		   if(empty($orders_list)){$data['order_date'] = '-' ; $data['order_number'] = '-';}else{
		   $data['order_date']   = date('d-m-Y',$orders_list['OrderDate']);
		   $data['order_number'] = $orders_list['OrderNumber'];
		  }
		  $data['link']  = "<a class='view_detail' href=".main_url.'Reporting/sample_detail/'.$order->UserID.">View</a>";
		  
		  array_push($all_records,$data);
		}
		
		  echo  $this->datatables->getproduction($all_records,$total);
	  }
	 
	 function get_latest_order_after_sample($userid,$orderdate){
		  return $this->db->query("select OrderNumber,OrderDate,OrderTotal,OrderShippingAmount,vat_exempt,currency,exchange_rate,Source,OrderStatus from orders where paymentmethods NOT LIKE 'Sample Order' and UserID = '".$userid."' and OrderDate > '".$orderdate."' order by OrderNumber asc limit 1")->row_array();
		}
	
	 function csv_from_record(){
	    
		 $country        = $this->input->post("country-form");
		 $where = '';
		 if($country != '' and  $country != 'all'){
		   $where .= " and (orders.DeliveryCountry like '%".$country."%')";
		 }
		
		$date_search = '';
		$From ='';$To='';
		if(isset($_POST['reservation']) && $_POST['reservation']!=""){
			$date      = $this->input->post('reservation');
			$date1     = explode('-',$date);
			$startdate = explode('/',$date1[0]);
			$enddate   = explode('/',$date1[1]);
			$From = trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00';
			$To   = trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59';
			$where .= " and (orders.OrderDate >= UNIX_TIMESTAMP('".$From."') AND orders.OrderDate <= UNIX_TIMESTAMP('".$To."'))";
		}
		
	$customers =  $this->db->query("select orders.UserID, CONCAT(orders.BillingFirstName, ' ', orders.BillingLastName) as username,orders.BillingPostcode,FROM_UNIXTIME(orders.OrderDate) as Orderdate,orders.Billingemail as user_email,orders.OrderNumber,orders.OrderDate,orders.DeliveryCountry,orders.Source from orders where  orders.paymentmethods LIKE 'Sample Order' ".$where." group by orders.UserID order by orders.OrderNumber desc ")->result();

       $mime_type = 'application/csv';
	   @header('Content-Type: ' . $mime_type);
	   //header('Content-Encoding: UTF-8');
       //header('Content-type: text/csv; charset=UTF-8');
	   @header('Expires: ' . gmdate('D, d M Y H:i(worry)') . ' GMT');
	   @header('Content-Disposition: attachment; filename="' . 'sample_report.csv' . '"');
	   @header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	   @header('Pragma: public');
	   
	   
	   
	   //echo $rows = "Customer,Email,PostCode,Sample_order,Sample_date,Sample_country,Order_Date,OrderNumber". "\r\n";
	   echo $rows = "Sample_order,sample_date,Customer,Email,PostCode,Sample_country,Order_Date,OrderNumber,Source,OrderValue,OrderStatus,Currency,Exchange_Rate,Vat_Exempt,QuotationNumber,QuotationTotal,Operator". "\r\n";
	   
	    $data='';
    	foreach($customers as $order){ 
		  $sample_order_date    = date('d-m-Y',$order->OrderDate);
		  $orders_list = $this->get_latest_order_after_sample($order->UserID,$order->OrderDate);
		 if(empty($orders_list)){$order_date = '' ; $order_number = ''; $ordertotal = $currency = $exchangerate = ''; $quotenumber = $quotetotal = $quote_operator = $sourcename = $statustitle = $Quotedate = $vat_exempt = '';}else{
		   $order_date   = date('d-m-Y',$orders_list['OrderDate']);
		   $order_number = $orders_list['OrderNumber'];
		   
		   $ordertotal = $orders_list['OrderTotal'] + $orders_list['OrderShippingAmount'];
		   
		   if($orders_list['vat_exempt']=='yes'){
		       $ordertotal = number_format($ordertotal / 1.2,2,'.','');
		   }
		   
		   $currency = $orders_list['currency'];
		   $exchangerate = $orders_list['exchange_rate'];
		   $vat_exempt = $orders_list['vat_exempt'];
		    
		    $sourcename  = $orders_list['Source'];
		    if(is_numeric($sourcename)){ 
		      $sourcearray = $this->Reporting_model->getUserDetail($orders_list['Source']);
		      $sourcename = $sourcearray->BillingFirstName;
		    }
		    
		    $statustitle = $this->get_order_status($orders_list['OrderStatus']);
		    $getquotation = $this->get_quote_for_order($order_number);
		    $quotenumber = $quotetotal = $quote_operator = $Quotedate = '';
		    if(!empty($getquotation)){
		      $quotenumber    =  $getquotation['QuotationNumber'];
		      $quotetotal     =  $getquotation['QuotationTotal'];
		      $quote_operator =  $getquotation['ProcessedBy'];
		      $Quotedate =  $getquotation['Quotedate'];
		    }
		    
		  }
		  
	      //$data.= $order->username.','.$order->user_email.','.$order->BillingPostcode.','.$order->OrderNumber.','.$sample_order_date.','.$order->Orderdate.','.$order->DeliveryCountry.','.$order_date.','.$order_number.','.$ordertotal.','.$currency.','.$exchangerate."\r\n";
	      
	      $data.= $order->OrderNumber.','.$sample_order_date.','.$order->username.','.$order->user_email.','.$order->BillingPostcode.','.$order->DeliveryCountry.','.$order_date.','.$order_number.','.$sourcename.','.$ordertotal.','.$statustitle.','.$currency.','.$exchangerate.','.$vat_exempt.','.$quotenumber.','.$quotetotal.','.$quote_operator.','.$Quotedate."\r\n";

    	    
    	}
    	$data = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
	   echo $data;
	   
	   exit();
   }
   
    function get_quote_for_order($order_number){
     return  $this->db->query("select *,FROM_UNIXTIME(quotations.QuotationDate) as Quotedate from `quotation_to_order` inner join quotations on quotations.QuotationNumber = quotation_to_order.QuotationNumber  WHERE quotation_to_order.`OrderNumber` LIKE '".$order_number."' ")->row_array();
    }
    
    function get_order_status($statusid){
     $query =  $this->db->query("select StatusTitle from dropshipstatusmanager where StatusID = $statusid")->row_array();    
     return $query['StatusTitle'];
    }
    
    
    function sample_detail(){
	  $data['user_detail']     = $this->Reporting_model->getUserDetail(end($this->uri->segment_array()));
	  $data['user_id']         = end($this->uri->segment_array());
	  $data['main_content']    = 'reporting/sample__detail';
	  $this->load->view('page', $data);	
	}
	
	 public function sample_against_user(){ 
	   $this->load->library('Table');
	   $tmpl = array('table_open' => '<table class="table table-hover m-0 table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="responsive-datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
                 
        $this->table->set_template($tmpl);
        $this->table->set_heading('Product Id','Product Description','Quantity','Despatch Date');
		$data['user_id']      = end($this->uri->segment_array());
		$data['main_content']   = "reporting/sample_user";
        $this->load->view('page', $data);
	  }
	  function ajax_samples_orders(){
		
		 $user_id = $this->input->post("user_id");
		 $where = "orders.UserID = '".$user_id."' and PaymentMethods = 'Sample Order'";
		 $this->datatables
  			  ->select("orders.OrderNumber, (SELECT ManufactureID FROM orderdetails WHERE orderdetails.OrderNumber = orders.OrderNumber and orderdetails.UserID = orders.UserID order by orderdetails.SerialNumber asc limit 1 ) as ManufactureID, (SELECT ProductName FROM orderdetails WHERE orderdetails.OrderNumber = orders.OrderNumber and orderdetails.UserID = orders.UserID order by orderdetails.SerialNumber asc limit 1 ) as ProductName, (SELECT sum(Quantity) FROM orderdetails WHERE orderdetails.OrderNumber = orders.OrderNumber and orderdetails.UserID = orders.UserID order by orderdetails.SerialNumber asc limit 1 ) as Quantity, FROM_UNIXTIME(orders.DispatchedDate, '%d-%M-%Y')")
 			  ->where($where,'',FALSE)
 			  ->from('orders'); 
		 		  
		 echo $this->datatables->generate();
	}
	
	 public function order_against_user(){ 
	   $this->load->library('Table');
	   $tmpl = array('table_open' => '<table class="table table-hover m-0 table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="responsive-datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
                 
        $this->table->set_template($tmpl);
        $this->table->set_heading('Order Id','Order Description','Order Value','Order Date','Order Status');
		$data['user_id']        = end($this->uri->segment_array());
		$data['main_content']   = "reporting/order_user ";
        $this->load->view('page', $data);
	  }
	  function ajax_orders_list(){
		
		 $user_id = $this->input->post("user_id");
		 $where = "orders.UserID = '".$user_id."' and PaymentMethods != 'Sample Order'";
		 $this->datatables
  			  ->select("orders.OrderNumber,(SELECT ProductName FROM orderdetails WHERE orderdetails.OrderNumber = orders.OrderNumber order by orderdetails.SerialNumber asc limit 1 ) as ProductName,if(orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2)*exchange_rate,2), round((orders.OrderTotal + orders.OrderShippingAmount)*exchange_rate,2)) AS OrderTotal, FROM_UNIXTIME(orders.OrderDate, '%d-%M-%Y'),  (SELECT dhsm.StatusTitle FROM dropshipstatusmanager as dhsm WHERE dhsm.StatusID =orders.OrderStatus) as order_status, voucherOfferd, voucherDiscount, vat_exempt")
 			  ->where($where,'',FALSE)
 			  ->from('orders'); 
		 		  
		      echo $this->datatables->generate();
	}
	  
	 
	 //-----------------------------------------**********************************--------------------------------------
    function week_index_array($query_result, $prl1_array){
	
		$a4total = 0.00;
		$a4total_print = 0.00;
		
		$a5total = 0.00;
		$a5total_print = 0.00;
				
		$a3total = 0.00;
		$a3total_print = 0.00;
		
		$sra3total = 0.00;
		$sra3total_print = 0.00;
		
		$rolltotal = 0.00;
		$rolltotal_print = 0.00;
				
		$ILtotal = 0.00;
		$ILtotal_print = 0.00;
		
		$custom_die = 0.00;
		$i=0; 
		
		foreach($prl1_array as $prl){
			$prl_array[$prl->week] = array("next_Total"=>$prl->next_Total);
		}
		
		//echo '<pre>';print_r($prl_array); echo '</pre>'; die();
		
		foreach($query_result as $row){
		 
		 	$i++;	
			$week = $row->week;
			$nextweek = $query_result[$i]->week;
		  
		   
		   	if($row->ProductBrand == 'A4 Labels' && $row->Printing == 'Y'){
				$a4total_print = $row->next_Total+$row->print_Total;
		   	}else if($row->ProductBrand == 'A4 Labels' && $row->Printing != 'Y'){
				$a4total+= $row->next_Total; 
			}
			
			/*------------------------------If-condition for A4 labels------------------------------*/	
			if($row->ProductBrand == 'A5 Labels' && $row->Printing == 'Y'){
				$a5total_print = $row->next_Total+$row->print_Total;
		   	}else if($row->ProductBrand == 'A5 Labels' && $row->Printing != 'Y'){
				$a5total+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for A3 labels------------------------------*/	
			if($row->ProductBrand == 'A3 Label' && $row->Printing == 'Y'){
				$a3total_print = $row->next_Total+$row->print_Total;
		   	}else if($row->ProductBrand == 'A3 Label' && $row->Printing != 'Y'){
				$a3total+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for SRA3 labels------------------------------*/	
			if($row->ProductBrand == 'SRA3 Label' && $row->Printing == 'Y'){
				$sra3total_print = $row->next_Total+$row->print_Total;
		   	}else if($row->ProductBrand == 'SRA3 Label' && $row->Printing != 'Y'){
				$sra3total+= $row->next_Total; 
		   	}
			
			/*------------------------------If-condition for IL labels------------------------------*/	
			if($row->ProductBrand == 'Integrated Labels' && $row->Printing == 'Y'){
				$ILtotal_print = $row->next_Total+$row->print_Total;
		   	}else if($row->ProductBrand == 'Integrated Labels' && $row->Printing != 'Y'){
				$ILtotal+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for Roll labels------------------------------*/	
			if( $row->ProductBrand == 'Roll Labels' && $row->Printing == 'Y' ){
				$rolltotal_print = $row->next_Total+$row->print_Total;
		   	}else if($row->ProductBrand == 'Roll Labels' && $row->Printing != 'Y'){
				$rolltotal+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for Custom labels------------------------------*/	
			if($row->ProductBrand == '' || $row->ProductBrand == '0'){
				$custom_die = $row->next_Total+$row->print_Total;
			}
			
			if($week!=$nextweek){ 
				 $pr = $prl_array[$week]['next_Total'];
				$weeker[$week] = array(
									   'A4'=>$a4total,
									   'A4_Print'=>$a4total_print,
									   'A5'=>$a5total,
									   'A5_Print'=>$a5total_print,
									   'A3'=>$a3total,
									   'A3_Print'=>$a3total_print,
									   'SRA3'=>$sra3total,
									   'SRA3_Print'=>$sra3total_print,
									   'Rolls'=>$rolltotal,
									   'Rolls_Print'=>$rolltotal_print + $pr,
									   'Integrated'=>$ILtotal,
									   'Integrated_Print'=>$ILtotal_print,
									   'Custom'=>$custom_die - $pr
									   );
					   
		    	
				$a4total = 0.00;
				$a4total_print = 0.00;
				
				$a5total = 0.00;
				$a5total_print = 0.00;
						
				$a3total = 0.00;
				$a3total_print = 0.00;
				
				$sra3total = 0.00;
				$sra3total_print = 0.00;
				
				$rolltotal = 0.00;
				$rolltotal_print = 0.00;
						
				$ILtotal = 0.00;
				$ILtotal_print = 0.00;
				
				$custom_die = 0.00;
				$pr = 0.00;
			} 
		}
		return $weeker;	
	}
	
	 public function getStartAndEndDate($week, $year)
	{
		$time = strtotime("1 April $year", time());
    	$day = date('w', $time);
    	$time += ((7*$week)+1-$day)*24*3600;
    	$return = date('j.n.Y', $time);
		$return = explode('.',$return);
		if($return[1] < 10){
			$return[1]='0'.$return[1];
		}
		if($return[0] < 10){
			$return[0]='0'.$return[0];
		}
		$return[2] = substr($return[2],2,2);
		$return = $return[0].'.'.$return[1].'.'.$return[2];
		return $return;
	}
	
	
	function volume_week_index_array($query_result, $prl1_array){
	
		$a4total = 0.00;
		$a4total_print = 0.00;
		
		$a5total = 0.00;
		$a5total_print = 0.00;
				
		$a3total = 0.00;
		$a3total_print = 0.00;
		
		$sra3total = 0.00;
		$sra3total_print = 0.00;
		
		$rolltotal = 0.00;
		$rolltotal_print = 0.00;
				
		$ILtotal = 0.00;
		$ILtotal_print = 0.00;
		
		$custom_die = 0.00;
		$i=0; 
		
		foreach($prl1_array as $prl){
			$prl_array[$prl->week] = array("next_Total"=>$prl->next_Total);
		}
		
		//echo '<pre>';print_r($prl_array); echo '</pre>'; die();
		
		foreach($query_result as $row){
		 
		 	$i++;	
			$week = $row->week;
			$nextweek = $query_result[$i]->week;
		  
		   
		   	if($row->ProductBrand == 'A4 Labels' && $row->Printing == 'Y'){
				$a4total_print = $row->print_Total;
		   	}else if($row->ProductBrand == 'A4 Labels' && $row->Printing != 'Y'){
				$a4total+= $row->next_Total; 
			}
			
			/*------------------------------If-condition for A4 labels------------------------------*/	
			if($row->ProductBrand == 'A5 Labels' && $row->Printing == 'Y'){
				$a5total_print = $row->print_Total;
		   	}else if($row->ProductBrand == 'A5 Labels' && $row->Printing != 'Y'){
				$a5total+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for A3 labels------------------------------*/	
			if($row->ProductBrand == 'A3 Label' && $row->Printing == 'Y'){
				$a3total_print = $row->print_Total;
		   	}else if($row->ProductBrand == 'A3 Label' && $row->Printing != 'Y'){
				$a3total+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for SRA3 labels------------------------------*/	
			if($row->ProductBrand == 'SRA3 Label' && $row->Printing == 'Y'){
				$sra3total_print = $row->print_Total;
		   	}else if($row->ProductBrand == 'SRA3 Label' && $row->Printing != 'Y'){
				$sra3total+= $row->next_Total; 
		   	}
			
			/*------------------------------If-condition for IL labels------------------------------*/	
			if($row->ProductBrand == 'Integrated Labels' && $row->Printing == 'Y'){
				$ILtotal_print = $row->print_Total;
		   	}else if($row->ProductBrand == 'Integrated Labels' && $row->Printing != 'Y'){
				$ILtotal+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for Roll labels------------------------------*/	
			if( $row->ProductBrand == 'Roll Labels' && $row->Printing == 'Y' ){
				$rolltotal_print = $row->print_Total;
		   	}else if($row->ProductBrand == 'Roll Labels' && $row->Printing != 'Y'){
				$rolltotal+= $row->next_Total; 
		   	}
			/*------------------------------If-condition for Custom labels------------------------------*/	
			if($row->ProductBrand == '' || $row->ProductBrand == '0'){
				$custom_die = $row->print_Total;
			}
			
			if($week!=$nextweek){ 
				 $pr = $prl_array[$week]['next_Total'];
				$weeker[$week] = array(
									   'A4'=>$a4total,
									   'A4_Print'=>$a4total_print,
									   'A5'=>$a5total,
									   'A5_Print'=>$a5total_print,
									   'A3'=>$a3total,
									   'A3_Print'=>$a3total_print,
									   'SRA3'=>$sra3total,
									   'SRA3_Print'=>$sra3total_print,
									   'Rolls'=>$rolltotal,
									   'Rolls_Print'=>$rolltotal_print + $pr,
									   'Integrated'=>$ILtotal,
									   'Integrated_Print'=>$ILtotal_print,
									   'Custom'=>$custom_die - $pr
									   );
					   
		    	
				$a4total = 0.00;
				$a4total_print = 0.00;
				
				$a5total = 0.00;
				$a5total_print = 0.00;
						
				$a3total = 0.00;
				$a3total_print = 0.00;
				
				$sra3total = 0.00;
				$sra3total_print = 0.00;
				
				$rolltotal = 0.00;
				$rolltotal_print = 0.00;
						
				$ILtotal = 0.00;
				$ILtotal_print = 0.00;
				
				$custom_die = 0.00;
				$pr = 0.00;
			} 
		}
		return $weeker;	
	}
	
	 function volume_report(){
	
		if(isset($_POST['report-form'])){
			$next = $this->input->post("year-form");
			
			$year = substr($next,2,2);
			$prev =$next-1;
			$next_year =$next+1;
			$year = $prev.'/'.$year;
			
			$week = 1;
			
			$function = $this->getStartAndEndDate($week,$prev);
			
			$function = explode('.',$function);
			if($week == 1 && $function[0] > 6){
				$wek=$week-1;
				$function = $this->getStartAndEndDate($wek,$prev);
				$function = explode('.',$function);
				$prev_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:01";
			}else{
				$prev_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:01";
			}
			
			$function = $this->getStartAndEndDate($week,$next);
			$function = explode('.',$function);
			if($week == 1 && $function[0] > 6){
				$wek=$week-1;
				$function = $this->getStartAndEndDate($wek,$next);
				$function = explode('.',$function);
				$next_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}else{
				$next_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}
			
			$function = $this->getStartAndEndDate($week,$next_year);
			$function = explode('.',$function);
			if($week == 1 && $function[0] > 6){
				$wek=$week-1;
				$function = $this->getStartAndEndDate($wek,$next+1);
				$function = explode('.',$function);
				$next_year = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}else{
				$next_year = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}
			
			$status_EMAIL = "AND ( 
								   `o`.`OrderStatus`=2 
								OR `o`.`OrderStatus`=7  OR `o`.`OrderStatus`=08 
								OR `o`.`OrderStatus`=32 OR `o`.`OrderStatus`=33 
								OR `o`.`OrderStatus`=38 OR `o`.`OrderStatus`=40 
								OR `o`.`OrderStatus`=55 OR `o`.`OrderStatus`=56
							)
							AND ( 
							  	    `o`.`Billingemail` NOT LIKE 'arslan.jd@gmail.com' 
							    AND `o`.`Billingemail` NOT LIKE 'sohail.sethi1@gmail.com' 
								AND `o`.`Billingemail` NOT LIKE 'kiransethi7@yahoo.com' 
								AND `o`.`Billingemail` NOT LIKE 'sohail@gtrecycling.com' 
								AND `o`.`Billingemail` NOT LIKE 'kami.ramzan77@gmail.com' 
							) ";
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, ProductBrand, Printing, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
								WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Quantity` ) AS next_Total, 
								SUM(`od`.`Quantity`) AS print_Total
						FROM orders AS `o`
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber`
							INNER JOIN `products` AS `prd` ON `od`.`ProductID` = `prd`.`ProductID`
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$prev_t' )
							AND FROM_UNIXTIME( `OrderDate` ) < ( '$next_t' )
							AND (
								   `ProductBrand` LIKE 'a4 labels'
								OR `ProductBrand` LIKE 'a3 label'
								OR `ProductBrand` LIKE 'a5 labels'
								OR `ProductBrand` LIKE 'sra3 label'
								OR `ProductBrand` LIKE 'Roll labels'
								OR `ProductBrand` LIKE 'Integrated labels'
								OR `od`.`ProductID` = 0
							) 
							$status_EMAIL
						
						GROUP BY CONCAT_WS( week, ProductBrand, Printing, '' )
						ORDER BY `OrderDate` ASC ";
			$query_result_prev = $this->db->query($query)->result();
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, ProductBrand, Printing, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
										 WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Quantity` ) AS next_Total, 
										 SUM(`od`.`Quantity`) AS print_Total
						FROM orders AS `o`
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber`
							INNER JOIN `products` AS `prd` ON `od`.`ProductID` = `prd`.`ProductID`
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$next_t' )
							AND FROM_UNIXTIME( `OrderDate` ) < ( '$next_year' )
							AND (
								   `ProductBrand` LIKE 'a4 labels'
								OR `ProductBrand` LIKE 'a3 label'
								OR `ProductBrand` LIKE 'a5 labels'
								OR `ProductBrand` LIKE 'sra3 label'
								OR `ProductBrand` LIKE 'Roll labels'
								OR `ProductBrand` LIKE 'Integrated labels'
								OR `od`.`ProductID` = 0
							) 
							$status_EMAIL
						
						GROUP BY CONCAT_WS( week, ProductBrand, Printing, '' )
						ORDER BY `OrderDate` ASC ";
	
			$query_result_next = $this->db->query($query)->result();			
			
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
										WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Quantity` ) AS next_Total, `od`.`ManufactureID` 
						FROM orders AS `o` 
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber` 
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$prev_t' ) 
							AND FROM_UNIXTIME( `OrderDate` ) < ( '$next_t' ) 
							AND `od`.`ManufactureID` LIKE 'PRL1' 
							$status_EMAIL
						GROUP BY week ORDER BY `OrderDate` ASC";
			$query_prl1_prev = $this->db->query($query)->result();
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
										WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Quantity` ) AS next_Total, `od`.`ManufactureID` 
						FROM orders AS `o` 
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber` 
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$next_t' ) 
							AND FROM_UNIXTIME( `OrderDate`  ) < ( '$next_year' ) 
							AND `od`.`ManufactureID` LIKE 'PRL1' 
								$status_EMAIL
						GROUP BY week ORDER BY `OrderDate` ASC";
			
			$query_prl1_next = $this->db->query($query)->result();
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$array_result_prev = $this->volume_week_index_array($query_result_prev, $query_prl1_prev); 
			$array_result_next = $this->volume_week_index_array($query_result_next, $query_prl1_next); 
		    $value =1;
			$row.= 'Date,'.$prev.',';
			//$row.= 'Date,'.$next.',';
			$rt=1;
			$first_key = key($array_result_next);
			
		/*--------------------intialinzing A4 array--------------------*/
			$a4_plain_curr.="A4(Plain),Actual,";
			$a4_plain_prev.=",".$year.",";
			$a4_plain_variance.=",variance,";
			
			$a4_printed_curr.="A4(Printed),Actual,";
			$a4_printed_prev.=",".$year.",";
			$a4_printed_variance.=",variance,";
			
			$a4_Total_curr.="A4(Total),Actual,";
			$a4_Total_prev.=",".$year.",";
			$a4_Total_variance.=",variance,";
		
		/*--------------------intialinzing A3 array--------------------*/
			$a3_plain_curr.="A3(Plain),Actual,";
			$a3_plain_prev.=",".$year.",";
			$a3_plain_variance.=",variance,";
			
			$a3_printed_curr.="A3(Printed),Actual,";
			$a3_printed_prev.=",".$year.",";
			$a3_printed_variance.=",variance,";
			
			$a3_Total_curr.="A3(Total),Actual,";
			$a3_Total_prev.=",".$year.",";
			$a3_Total_variance.=",variance,";
//		
		/*--------------------intialinzing A5 array--------------------*/
			$a5_plain_curr.="A5(Plain),Actual,";
			$a5_plain_prev.=",".$year.",";
			$a5_plain_variance.=",variance,";
			
			$a5_printed_curr.="A5(Printed),Actual,";
			$a5_printed_prev.=",".$year.",";
			$a5_printed_variance.=",variance,";
			
			$a5_Total_curr.="A5(Total),Actual,";
			$a5_Total_prev.=",".$year.",";
			$a5_Total_variance.=",variance,";
			
		/*--------------------intialinzing IL array--------------------*/
			$IL_plain_curr.="IL(Plain),Actual,";
			$IL_plain_prev.=",".$year.",";
			$IL_plain_variance.=",variance,";
			
			$IL_printed_curr.="IL(Printed),Actual,";
			$IL_printed_prev.=",".$year.",";
			$IL_printed_variance.=",variance,";
			
			$IL_Total_curr.="IL(Total),Actual,";
			$IL_Total_prev.=",".$year.",";
			$IL_Total_variance.=",variance,";
		
		/*--------------------intialinzing Roll array--------------------*/
			$roll_plain_curr.="Roll(Plain),Actual,";
			$roll_plain_prev.=",".$year.",";
			$roll_plain_variance.=",variance,";
			
			$roll_printed_curr.="Roll(Printed),Actual,";
			$roll_printed_prev.=",".$year.",";
			$roll_printed_variance.=",variance,";
			
			$roll_Total_curr.="Roll(Total),Actual,";
			$roll_Total_prev.=",".$year.",";
			$roll_Total_variance.=",variance,";
		
		/*--------------------intialinzing SRA3 array--------------------*/
			$sra3_plain_curr.="SRA3(Plain),Actual,";
			$sra3_plain_prev.=",".$year.",";
			$sra3_plain_variance.=",variance,";
			
			$sra3_printed_curr.="SRA3(Printed),Actual,";
			$sra3_printed_prev.=",".$year.",";
			$sra3_printed_variance.=",variance,";
			
			$sra3_Total_curr.="SRA3(Total),Actual,";
			$sra3_Total_prev.=",".$year.",";
			$sra3_Total_variance.=",variance,";

			$custom_curr.="Custom,Actual,";
			$custom_prev.=",".$year.",";
			$custom_variance.=",variance,";
		
			$b=0;
			
			$week=14;
			for($i =0;$i <= 134; $i++){
				if($i < 61){
					if($i == 13 || $i == 29 || $i == 45){
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$a4_plain_curr.=$a4_PL_curr_tt;
						$a4_plain_prev.=$a4_PL_prev_tt;
						$a4_plain_variance.=$a4_PL_variance_tt;
						
						$a4_printed_curr.=$a4_PR_curr_tt;
						$a4_printed_prev.=$a4_PR_prev_tt;
						$a4_printed_variance.=$a4_PR_variance_tt;
					
						$a4_Total_curr.=$a4_TT_curr_tt;
						$a4_Total_prev.=$a4_TT_prev_tt;
						$a4_Total_variance.=$a4_TT_variance_tt;
					/*--------------------For Row Total of A4--------------------*/	
						$a4_plain_curr_4+=$a4_PL_curr_tt;
						$a4_plain_prev_4+=$a4_PL_prev_tt;
						$a4_plain_variance_4+=$a4_PL_variance_tt;
						
						$a4_printed_curr_4+=$a4_PR_curr_tt;
						$a4_printed_prev_4+=$a4_PR_prev_tt;
						$a4_printed_variance_4+=$a4_PR_variance_tt;
					
						$a4_Total_curr_4+=$a4_TT_curr_tt;
						$a4_Total_prev_4+=$a4_TT_prev_tt;
						$a4_Total_variance_4+=$a4_TT_variance_tt;						
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$a4_PL_curr_tt = $a4_PL_prev_tt = $a4_PL_variance_tt = 0;
						$a4_PR_curr_tt = $a4_PR_prev_tt = $a4_PR_variance_tt = 0;
						$a4_TT_curr_tt = $a4_TT_prev_tt = $a4_TT_variance_tt = 0;
						
					/*--------------------intialinzing A3 array--------------------*/
						$a3_plain_curr.=$a3_PL_curr_tt;
						$a3_plain_prev.=$a3_PL_prev_tt;
						$a3_plain_variance.=$a3_PL_variance_tt;
						
						$a3_printed_curr.=$a3_PR_curr_tt;
						$a3_printed_prev.=$a3_PR_prev_tt;
						$a3_printed_variance.=$a3_PR_variance_tt;
					
						$a3_Total_curr.=$a3_TT_curr_tt;
						$a3_Total_prev.=$a3_TT_prev_tt;
						$a3_Total_variance.=$a3_TT_variance_tt;
					
					/*--------------------For Row Total of A3--------------------*/
						$a3_plain_curr_4+=$a3_PL_curr_tt;
						$a3_plain_prev_4+=$a3_PL_prev_tt;
						$a3_plain_variance_4+=$a3_PL_variance_tt;
						
						$a3_printed_curr_4+=$a3_PR_curr_tt;
						$a3_printed_prev_4+=$a3_PR_prev_tt;
						$a3_printed_variance_4+=$a3_PR_variance_tt;
					
						$a3_Total_curr_4+=$a3_TT_curr_tt;
						$a3_Total_prev_4+=$a3_TT_prev_tt;
						$a3_Total_variance_4+=$a3_TT_variance_tt;
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$a3_PL_curr_tt = $a3_PL_prev_tt = $a3_PL_variance_tt = 0;
						$a3_PR_curr_tt = $a3_PR_prev_tt = $a3_PR_variance_tt = 0;
						$a3_TT_curr_tt = $a3_TT_prev_tt = $a3_TT_variance_tt = 0;
//						
					/*--------------------intialinzing A5 array--------------------*/
						$a5_plain_curr.=$a5_PL_curr_tt;
						$a5_plain_prev.=$a5_PL_prev_tt;
						$a5_plain_variance.=$a5_PL_variance_tt;
						
						$a5_printed_curr.=$a5_PR_curr_tt;
						$a5_printed_prev.=$a5_PR_prev_tt;
						$a5_printed_variance.=$a5_PR_variance_tt;
					
						$a5_Total_curr.=$a5_TT_curr_tt;
						$a5_Total_prev.=$a5_TT_prev_tt;
						$a5_Total_variance.=$a5_TT_variance_tt;
						
					/*--------------------For Row Total of A5--------------------*/
						$a5_plain_curr_4+=$a5_PL_curr_tt;
						$a5_plain_prev_4+=$a5_PL_prev_tt;
						$a5_plain_variance_4+=$a5_PL_variance_tt;
						
						$a5_printed_curr_4+=$a5_PR_curr_tt;
						$a5_printed_prev_4+=$a5_PR_prev_tt;
						$a5_printed_variance_4+=$a5_PR_variance_tt;
					
						$a5_Total_curr_4+=$a5_TT_curr_tt;
						$a5_Total_prev_4+=$a5_TT_prev_tt;
						$a5_Total_variance_4+=$a5_TT_variance_tt;
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						$a5_PL_curr_tt = $a5_PL_prev_tt = $a5_PL_variance_tt = 0;
						$a5_PR_curr_tt = $a5_PR_prev_tt = $a5_PR_variance_tt = 0;
						$a5_TT_curr_tt = $a5_TT_prev_tt = $a5_TT_variance_tt = 0;
					
					/*--------------------intialinzing SRA3 array--------------------*/
						$sra3_plain_curr.=$sra3_PL_curr_tt;
						$sra3_plain_prev.=$sra3_PL_prev_tt;
						$sra3_plain_variance.=$sra3_PL_variance_tt;
						
						$sra3_printed_curr.=$sra3_PR_curr_tt;
						$sra3_printed_prev.=$sra3_PR_prev_tt;
						$sra3_printed_variance.=$sra3_PR_variance_tt;
					
						$sra3_Total_curr.=$sra3_TT_curr_tt;
						$sra3_Total_prev.=$sra3_TT_prev_tt;
						$sra3_Total_variance.=$sra3_TT_variance_tt;
					
					/*--------------------For Row Total of SRA3--------------------*/
						$sra3_plain_curr_4+=$sra3_PL_curr_tt;
						$sra3_plain_prev_4+=$sra3_PL_prev_tt;
						$sra3_plain_variance_4+=$sra3_PL_variance_tt;
						
						$sra3_printed_curr_4+=$sra3_PR_curr_tt;
						$sra3_printed_prev_4+=$sra3_PR_prev_tt;
						$sra3_printed_variance_4+=$sra3_PR_variance_tt;
					
						$sra3_Total_curr_4+=$sra3_TT_curr_tt;
						$sra3_Total_prev_4+=$sra3_TT_prev_tt;
						$sra3_Total_variance_4+=$sra3_TT_variance_tt;
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//
						$sra3_PL_curr_tt = $sra3_PL_prev_tt = $sra3_PL_variance_tt = 0;
						$sra3_PR_curr_tt = $sra3_PR_prev_tt = $sra3_PR_variance_tt = 0;
						$sra3_TT_curr_tt = $sra3_TT_prev_tt = $sra3_TT_variance_tt = 0;
					
					/*--------------------intialinzing Roll array--------------------*/
						$roll_plain_curr.=$roll_PL_curr_tt;
						$roll_plain_prev.=$roll_PL_prev_tt;
						$roll_plain_variance.=$roll_PL_variance_tt;
						
						$roll_printed_curr.=$roll_PR_curr_tt;
						$roll_printed_prev.=$roll_PR_prev_tt;
						$roll_printed_variance.=$roll_PR_variance_tt;
					
						$roll_Total_curr.=$roll_TT_curr_tt;
						$roll_Total_prev.=$roll_TT_prev_tt;
						$roll_Total_variance.=$roll_TT_variance_tt;
					
						/*--------------------For Row Total of ROLL--------------------*/
							$roll_plain_curr_4+=$roll_PL_curr_tt;
							$roll_plain_prev_4+=$roll_PL_prev_tt;
							$roll_plain_variance_4+=$roll_PL_variance_tt;
							
							$roll_printed_curr_4+=$roll_PR_curr_tt;
							$roll_printed_prev_4+=$roll_PR_prev_tt;
							$roll_printed_variance_4+=$roll_PR_variance_tt;
					
							$roll_Total_curr_4+=$roll_TT_curr_tt;
							$roll_Total_prev_4+=$roll_TT_prev_tt;
							$roll_Total_variance_4+=$roll_TT_variance_tt;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						$roll_PL_curr_tt = $roll_PL_prev_tt = $roll_PL_variance_tt = 0;
						$roll_PR_curr_tt = $roll_PR_prev_tt = $roll_PR_variance_tt = 0;
						$roll_TT_curr_tt = $roll_TT_prev_tt = $roll_TT_variance_tt = 0;
					
					/*--------------------intialinzing IL array--------------------*/
						$IL_plain_curr.=$IL_PL_curr_tt;
						$IL_plain_prev.=$IL_PL_prev_tt;
						$IL_plain_variance.=$IL_PL_variance_tt;
						
						$IL_printed_curr.=$IL_PR_curr_tt;
						$IL_printed_prev.=$IL_PR_prev_tt;
						$IL_printed_variance.=$IL_PR_variance_tt;
					
						$IL_Total_curr.=$IL_TT_curr_tt;
						$IL_Total_prev.=$IL_TT_prev_tt;
						$IL_Total_variance.=$IL_TT_variance_tt;
						/*--------------------For Row Total of IL--------------------*/
							$IL_plain_curr_4+=$IL_PL_curr_tt;
							$IL_plain_prev_4+=$IL_PL_prev_tt;
							$IL_plain_variance_4+=$IL_PL_variance_tt;
						
							$IL_printed_curr_4+=$IL_PR_curr_tt;
							$IL_printed_prev_4+=$IL_PR_prev_tt;
							$IL_printed_variance_4+=$IL_PR_variance_tt;
					
							$IL_Total_curr_4+=$IL_TT_curr_tt;
							$IL_Total_prev_4+=$IL_TT_prev_tt;
							$IL_Total_variance_4+=$IL_TT_variance_tt;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//	
						$IL_PL_curr_tt = $IL_PL_prev_tt = $IL_PL_variance_tt = 0;
						$IL_PR_curr_tt = $IL_PR_prev_tt = $IL_PR_variance_tt = 0;
						$IL_TT_curr_tt = $IL_TT_prev_tt = $IL_TT_variance_tt = 0;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$custom_curr.=$cus_curr_tt;
						$custom_prev.=$cus_prev_tt;
						$custom_variance.=$cus_variance_tt;
						
							$cus_curr_4+=$cus_curr_tt;
							$cus_prev_4+=$cus_prev_tt;
							$cus_variance_4+=$cus_variance_tt;
						
						$cus_curr_tt = $cus_prev_tt = $cus_variance_tt = 0;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					}
					
					
					if(($i > 12 && $i < 16) || ($i > 28 && $i < 32) || ($i > 44 && $i < 48)){
						$datee.= ",";
						$datee2.= ",";
					/*--------------------intialinzing A4 array--------------------*/	
						$a4_plain_curr.=",";
						$a4_plain_prev.=",";
						$a4_plain_variance.=",";
						
						$a4_printed_curr.=",";
						$a4_printed_prev.=",";
						$a4_printed_variance.=",";
						
						$a4_Total_curr.=",";
						$a4_Total_prev.=",";
						$a4_Total_variance.=",";
						
					/*--------------------intialinzing A3 array--------------------*/	
						$a3_plain_curr.=",";
						$a3_plain_prev.=",";
						$a3_plain_variance.=",";
						
						$a3_printed_curr.=",";
						$a3_printed_prev.=",";
						$a3_printed_variance.=",";
						
						$a3_Total_curr.=",";
						$a3_Total_prev.=",";
						$a3_Total_variance.=",";
						
					/*--------------------intialinzing A5 array--------------------*/	
						$a5_plain_curr.=",";
						$a5_plain_prev.=",";
						$a5_plain_variance.=",";
						
						$a5_printed_curr.=",";
						$a5_printed_prev.=",";
						$a5_printed_variance.=",";
						
						$a5_Total_curr.=",";
						$a5_Total_prev.=",";
						$a5_Total_variance.=",";
					
					/*--------------------intialinzing SRA3 array--------------------*/	
						$sra3_plain_curr.=",";
						$sra3_plain_prev.=",";
						$sra3_plain_variance.=",";
						
						$sra3_printed_curr.=",";
						$sra3_printed_prev.=",";
						$sra3_printed_variance.=",";
						
						$sra3_Total_curr.=",";
						$sra3_Total_prev.=",";
						$sra3_Total_variance.=",";
					
					/*--------------------intialinzing Roll array--------------------*/	
						$roll_plain_curr.=",";
						$roll_plain_prev.=",";
						$roll_plain_variance.=",";
						
						$roll_printed_curr.=",";
						$roll_printed_prev.=",";
						$roll_printed_variance.=",";
						
						$roll_Total_curr.=",";
						$roll_Total_prev.=",";
						$roll_Total_variance.=",";	
					
					/*--------------------intialinzing IL array--------------------*/	
						$IL_plain_curr.=",";
						$IL_plain_prev.=",";
						$IL_plain_variance.=",";
						
						$IL_printed_curr.=",";
						$IL_printed_prev.=",";
						$IL_printed_variance.=",";
						
						$IL_Total_curr.=",";
						$IL_Total_prev.=",";
						$IL_Total_variance.=",";
					
					/*--------------------intialinzing custom array--------------------*/	
						$custom_curr.=",";
						$custom_prev.=",";
						$custom_variance.=",";
						
					}else{
						
						//$function = $this->getStartAndEndDate($week,$prev);
						
	
						$week_start = new DateTime();
						$week_start->setISODate($next,$week);
						$function = $week_start->format('d.m.y');
						$datee2.= $function.",";
						//$result = $this->Start_End_Date_of_a_week($week,$next);
						//$datee2.= $result[1].",";
						
						$week_start = new DateTime();
						$week_start->setISODate($prev,$week);
						$function = $week_start->format('d.m.y');
						
						
						$datee.= $function.",";
						
					    //$result = $this->Start_End_Date_of_a_week($week,$prev);
					    //$datee.= $result[1].",";
						
						
						$function = explode('.',$function);
						$function = ("20".$function[2]).'-'.$function[1].'-'.$function[0];
						$date = new DateTime($function);
						$function = (int) $date->format("W");
					
						//$array_week[$week]=$function;
						//$int = 3;
						//echo '$a'.$int.'_row_curr';die();
						if($function == 1){
							$first_key = 1;
							$week =1;
							$prev=$next;
							$next= $next+1;
						}
			/*------------------------------Calling function ------------------------------*/
						$a4_PL_variance=$a4_PL_prev=$a4_PL_curr=0;
						$a4_PL_curr = $this->get_value_from_array("A4",$array_result_next,$function,$first_key);
						$a4_PL_prev = $this->get_value_from_array("A4",$array_result_prev,$function,$first_key);
						$a4_PL_variance = $a4_PL_curr-$a4_PL_prev;
						
						$a4_plain_variance.=$a4_PL_variance.",";
						$a4_plain_curr.=$a4_PL_curr.",";
						$a4_plain_prev.=$a4_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$a4_PR_variance=$a4_PR_prev=$a4_PR_curr=0;
						$a4_PR_curr = $this->get_value_from_array_printed("A4",$array_result_next,$function,$first_key);
						$a4_PR_prev = $this->get_value_from_array_printed("A4",$array_result_prev,$function,$first_key);					
						$a4_PR_variance = $a4_PR_curr-$a4_PR_prev;
						
						$a4_printed_variance.=$a4_PR_variance.",";
						$a4_printed_curr.=$a4_PR_curr.",";
						$a4_printed_prev.=$a4_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$a4_TT_curr = $a4_PL_curr+$a4_PR_curr;
						$a4_TT_prev = $a4_PL_prev+$a4_PR_prev;				
						$a4_TT_variance = $a4_TT_curr-$a4_TT_prev;
						
						$a4_Total_variance.=$a4_TT_variance.",";
						$a4_Total_curr.=$a4_TT_curr.",";
						$a4_Total_prev.=$a4_TT_prev.",";
						
						$a4_PL_curr_tt +=$a4_PL_curr;
						$a4_PL_prev_tt +=$a4_PL_prev;
						$a4_PL_variance_tt +=$a4_PL_variance;
						
						$a4_PR_prev_tt +=$a4_PR_prev;
						$a4_PR_curr_tt +=$a4_PR_curr;
						$a4_PR_variance_tt +=$a4_PR_variance;
						
						$a4_TT_prev_tt +=$a4_TT_prev;
						$a4_TT_curr_tt +=$a4_TT_curr;
						$a4_TT_variance_tt +=$a4_TT_variance;
			
			/*------------------------------Calling function A3------------------------------*/			
						$a3_PL_curr = $this->get_value_from_array("A3",$array_result_next,$function,$first_key);
						$a3_PL_prev = $this->get_value_from_array("A3",$array_result_prev,$function,$first_key);
						$a3_PL_variance = $a3_PL_curr-$a3_PL_prev;
						
						$a3_plain_variance.=$a3_PL_variance.",";
						$a3_plain_curr.=$a3_PL_curr.",";
						$a3_plain_prev.=$a3_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$a3_PR_curr = $this->get_value_from_array_printed("A3",$array_result_next,$function,$first_key);
						$a3_PR_prev = $this->get_value_from_array_printed("A3",$array_result_prev,$function,$first_key);					
						$a3_PR_variance = $a3_PR_curr-$a3_PR_prev;
						
						$a3_printed_variance.=$a3_PR_variance.",";
						$a3_printed_curr.=$a3_PR_curr.",";
						$a3_printed_prev.=$a3_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$a3_TT_curr = $a3_PL_curr+$a3_PR_curr;
						$a3_TT_prev = $a3_PL_prev+$a3_PR_prev;				
						$a3_TT_variance = $a3_TT_curr-$a3_TT_prev;
						
						$a3_Total_variance.=$a3_TT_variance.",";
						$a3_Total_curr.=$a3_TT_curr.",";
						$a3_Total_prev.=$a3_TT_prev.",";
						
						$a3_PL_curr_tt +=$a3_PL_curr;
						$a3_PL_prev_tt +=$a3_PL_prev;
						$a3_PL_variance_tt +=$a3_PL_variance;
						
						$a3_PR_prev_tt +=$a3_PR_prev;
						$a3_PR_curr_tt +=$a3_PR_curr;
						$a3_PR_variance_tt +=$a3_PR_variance;
						
						$a3_TT_prev_tt +=$a3_TT_prev;
						$a3_TT_curr_tt +=$a3_TT_curr;
						$a3_TT_variance_tt +=$a3_TT_variance;
			
			/*------------------------------Calling function A5%------------------------------*/			
						$a5_PL_curr = $this->get_value_from_array("A5",$array_result_next,$function,$first_key);
						$a5_PL_prev = $this->get_value_from_array("A5",$array_result_prev,$function,$first_key);
						$a5_PL_variance = $a5_PL_curr-$a5_PL_prev;
						
						$a5_plain_variance.=$a5_PL_variance.",";
						$a5_plain_curr.=$a5_PL_curr.",";
						$a5_plain_prev.=$a5_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$a5_PR_curr = $this->get_value_from_array_printed("A5",$array_result_next,$function,$first_key);
						$a5_PR_prev = $this->get_value_from_array_printed("A5",$array_result_prev,$function,$first_key);					
						$a5_PR_variance = $a5_PR_curr-$a5_PR_prev;
						
						$a5_printed_variance.=$a5_PR_variance.",";
						$a5_printed_curr.=$a5_PR_curr.",";
						$a5_printed_prev.=$a5_PR_prev.",";
//						
						
			/*------------------------------Calling function ------------------------------*/
						$a5_TT_curr = $a5_PL_curr+$a5_PR_curr;
						$a5_TT_prev = $a5_PL_prev+$a5_PR_prev;				
						$a5_TT_variance = $a5_TT_curr-$a5_TT_prev;
						
						$a5_Total_variance.=$a5_TT_variance.",";
						$a5_Total_curr.=$a5_TT_curr.",";
						$a5_Total_prev.=$a5_TT_prev.",";
						
						$a5_PL_curr_tt +=$a5_PL_curr;
						$a5_PL_prev_tt +=$a5_PL_prev;
						$a5_PL_variance_tt +=$a5_PL_variance;
						
						$a5_PR_prev_tt +=$a5_PR_prev;
						$a5_PR_curr_tt +=$a5_PR_curr;
						$a5_PR_variance_tt +=$a5_PR_variance;
						
						$a5_TT_prev_tt +=$a5_TT_prev;
						$a5_TT_curr_tt +=$a5_TT_curr;
						$a5_TT_variance_tt +=$a5_TT_variance;
						
			/*------------------------------Calling function SRA3------------------------------*/			
						$sra3_PL_curr = $this->get_value_from_array("SRA3",$array_result_next,$function,$first_key);
						$sra3_PL_prev = $this->get_value_from_array("SRA3",$array_result_prev,$function,$first_key);
						$sra3_PL_variance = $sra3_PL_curr-$sra3_PL_prev;
						
						$sra3_plain_variance.=$sra3_PL_variance.",";
						$sra3_plain_curr.=$sra3_PL_curr.",";
						$sra3_plain_prev.=$sra3_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$sra3_PR_curr = $this->get_value_from_array_printed("SRA3",$array_result_next,$function,$first_key);
						$sra3_PR_prev = $this->get_value_from_array_printed("SRA3",$array_result_prev,$function,$first_key);					
						$sra3_PR_variance = $sra3_PR_curr-$sra3_PR_prev;
						
						$sra3_printed_variance.=$sra3_PR_variance.",";
						$sra3_printed_curr.=$sra3_PR_curr.",";
						$sra3_printed_prev.=$sra3_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$sra3_TT_curr = $sra3_PL_curr+$sra3_PR_curr;
						$sra3_TT_prev = $sra3_PL_prev+$sra3_PR_prev;				
						$sra3_TT_variance = $sra3_TT_curr-$sra3_TT_prev;
						
						$sra3_Total_variance.=$sra3_TT_variance.",";
						$sra3_Total_curr.=$sra3_TT_curr.",";
						$sra3_Total_prev.=$sra3_TT_prev.",";
						
						$sra3_PL_curr_tt +=$sra3_PL_curr;
						$sra3_PL_prev_tt +=$sra3_PL_prev;
						$sra3_PL_variance_tt +=$sra3_PL_variance;
						
						$sra3_PR_prev_tt +=$sra3_PR_prev;
						$sra3_PR_curr_tt +=$sra3_PR_curr;
						$sra3_PR_variance_tt +=$sra3_PR_variance;
						
						$sra3_TT_prev_tt +=$sra3_TT_prev;
						$sra3_TT_curr_tt +=$sra3_TT_curr;
						$sra3_TT_variance_tt +=$sra3_TT_variance;
			
			/*------------------------------Calling function ROLL------------------------------*/			
						$roll_PL_curr = $this->get_value_from_array("Rolls",$array_result_next,$function,$first_key);
						$roll_PL_prev = $this->get_value_from_array("Rolls",$array_result_prev,$function,$first_key);
						$roll_PL_variance = $roll_PL_curr-$roll_PL_prev;
						
						$roll_plain_variance.=$roll_PL_variance.",";
						$roll_plain_curr.=$roll_PL_curr.",";
						$roll_plain_prev.=$roll_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$roll_PR_curr = $this->get_value_from_array_printed("Rolls",$array_result_next,$function,$first_key);
						$roll_PR_prev = $this->get_value_from_array_printed("Rolls",$array_result_prev,$function,$first_key);					
						$roll_PR_variance = $roll_PR_curr-$roll_PR_prev;
						
						$roll_printed_variance.=$roll_PR_variance.",";
						$roll_printed_curr.=$roll_PR_curr.",";
						$roll_printed_prev.=$roll_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$roll_TT_curr = $roll_PL_curr+$roll_PR_curr;
						$roll_TT_prev = $roll_PL_prev+$roll_PR_prev;				
						$roll_TT_variance = $roll_TT_curr-$roll_TT_prev;
						
						$roll_Total_variance.=$roll_TT_variance.",";
						$roll_Total_curr.=$roll_TT_curr.",";
						$roll_Total_prev.=$roll_TT_prev.",";
						
						$roll_PL_curr_tt +=$roll_PL_curr;
						$roll_PL_prev_tt +=$roll_PL_prev;
						$roll_PL_variance_tt +=$roll_PL_variance;
						
						$roll_PR_prev_tt +=$roll_PR_prev;
						$roll_PR_curr_tt +=$roll_PR_curr;
						$roll_PR_variance_tt +=$roll_PR_variance;
						
						$roll_TT_prev_tt +=$roll_TT_prev;
						$roll_TT_curr_tt +=$roll_TT_curr;
						$roll_TT_variance_tt +=$roll_TT_variance;			
			
			/*------------------------------Calling function Integrated------------------------------*/			
						$IL_PL_curr = $this->get_value_from_array("Integrated",$array_result_next,$function,$first_key);
						$IL_PL_prev = $this->get_value_from_array("Integrated",$array_result_prev,$function,$first_key);
						$IL_PL_variance = $IL_PL_curr-$IL_PL_prev;
						
						$IL_plain_variance.=$IL_PL_variance.",";
						$IL_plain_curr.=$IL_PL_curr.",";
						$IL_plain_prev.=$IL_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$IL_PR_curr = $this->get_value_from_array_printed("Integrated",$array_result_next,$function,$first_key);
						$IL_PR_prev = $this->get_value_from_array_printed("Integrated",$array_result_prev,$function,$first_key);					
						$IL_PR_variance = $IL_PR_curr-$IL_PR_prev;
						
						$IL_printed_variance.=$IL_PR_variance.",";
						$IL_printed_curr.=$IL_PR_curr.",";
						$IL_printed_prev.=$IL_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$IL_TT_curr = $IL_PL_curr+$IL_PR_curr;
						$IL_TT_prev = $IL_PL_prev+$IL_PR_prev;				
						$IL_TT_variance = $IL_TT_curr-$IL_TT_prev;
						
						$IL_Total_variance.=$IL_TT_variance.",";
						$IL_Total_curr.=$IL_TT_curr.",";
						$IL_Total_prev.=$IL_TT_prev.",";
						
						$IL_PL_curr_tt +=$IL_PL_curr;
						$IL_PL_prev_tt +=$IL_PL_prev;
						$IL_PL_variance_tt +=$IL_PL_variance;
						
						$IL_PR_prev_tt +=$IL_PR_prev;
						$IL_PR_curr_tt +=$IL_PR_curr;
						$IL_PR_variance_tt +=$IL_PR_variance;
						
						$IL_TT_prev_tt +=$IL_TT_prev;
						$IL_TT_curr_tt +=$IL_TT_curr;
						$IL_TT_variance_tt +=$IL_TT_variance;
			
			/*------------------------------Calling function Integrated------------------------------*/			
						$cus_curr = $this->get_value_from_array("Custom",$array_result_next,$function,$first_key);
						$cus_prev = $this->get_value_from_array("Custom",$array_result_prev,$function,$first_key);
						$cus_variance = $cus_curr-$cus_prev;
						
						$custom_variance.=$cus_variance.",";
						$custom_curr.=$cus_curr.",";
						$custom_prev.=$cus_prev.",";
						
						$cus_curr_tt+=$cus_curr;
						$cus_prev_tt+=$cus_prev;
						$cus_variance_tt+=$cus_variance;
			
						$first_key++;
						$week++;
						
						
					}
				}else if($i == 61){
					$new_row.= "\r\n".",".",";
				}else if($i > 61 && $i < 123){
					if($i == 75 || $i == 91 || $i == 107){
						$week_row.="Q".$rt++." TOTAL";
					}if(($i > 74 && $i < 78) || ($i > 90 && $i < 94) || ($i > 106 && $i < 110)){
						$week_row.=",";
					}else{
						$week_row.= "W-".++$a.",";
					}
				}
			}
			$week_row.="Q".$rt." TOTAL".",,,".$year." Total"."\r\n";
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$a4_plain_curr.=$a4_PL_curr_tt.",,,".($a4_plain_curr_4+$a4_PL_curr_tt);
				$a4_plain_prev.=$a4_PL_prev_tt.",,,".($a4_plain_prev_4+$a4_PL_prev_tt);
				$a4_plain_variance.=$a4_PL_variance_tt.",,,".($a4_plain_variance_4+$a4_PL_variance_tt);
			
				$a4_printed_curr.=$a4_PR_curr_tt.",,,".($a4_printed_curr_4+$a4_PR_curr_tt);
				$a4_printed_prev.=$a4_PR_prev_tt.",,,".($a4_printed_prev_4+$a4_PR_prev_tt);
				$a4_printed_variance.=$a4_PR_variance_tt.",,,".($a4_printed_variance_4+$a4_PR_variance_tt);
		
				$a4_Total_curr.=$a4_TT_curr_tt.",,,".($a4_Total_curr_4+$a4_TT_curr_tt);
				$a4_Total_prev.=$a4_TT_prev_tt.",,,".($a4_Total_prev_4+$a4_TT_prev_tt);
				$a4_Total_variance.=$a4_TT_variance_tt.",,,".($a4_Total_variance_4+$a4_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$a3_plain_curr.=$a3_PL_curr_tt.",,,".($a3_plain_curr_4+$a3_PL_curr_tt);
				$a3_plain_prev.=$a3_PL_prev_tt.",,,".($a3_plain_prev_4+$a3_PL_prev_tt);
				$a3_plain_variance.=$a3_PL_variance_tt.",,,".($a3_plain_variance_4+$a3_PL_variance_tt);
			
				$a3_printed_curr.=$a3_PR_curr_tt.",,,".($a3_printed_curr_4+$a3_PR_curr_tt);
				$a3_printed_prev.=$a3_PR_prev_tt.",,,".($a3_printed_prev_4+$a3_PR_prev_tt);
				$a3_printed_variance.=$a3_PR_variance_tt.",,,".($a3_printed_variance_4+$a3_PR_variance_tt);
		
				$a3_Total_curr.=$a3_TT_curr_tt.",,,".($a3_Total_curr_4+$a3_TT_curr_tt);
				$a3_Total_prev.=$a3_TT_prev_tt.",,,".($a3_Total_prev_4+$a3_TT_prev_tt);
				$a3_Total_variance.=$a3_TT_variance_tt.",,,".($a3_Total_variance_4+$a3_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$a5_plain_curr.=$a5_PL_curr_tt.",,,".($a5_plain_curr_4+$a5_PL_curr_tt);
				$a5_plain_prev.=$a5_PL_prev_tt.",,,".($a5_plain_prev_4+$a5_PL_prev_tt);
				$a5_plain_variance.=$a5_PL_variance_tt.",,,".($a5_plain_variance_4+$a5_PL_variance_tt);
			
				$a5_printed_curr.=$a5_PR_curr_tt.",,,".($a5_printed_curr_4+$a5_PR_curr_tt);
				$a5_printed_prev.=$a5_PR_prev_tt.",,,".($a5_printed_prev_4+$a5_PR_prev_tt);
				$a5_printed_variance.=$a5_PR_variance_tt.",,,".($a5_printed_variance_4+$a5_PR_variance_tt);
		
				$a5_Total_curr.=$a5_TT_curr_tt.",,,".($a5_Total_curr_4+$a5_TT_curr_tt);
				$a5_Total_prev.=$a5_TT_prev_tt.",,,".($a5_Total_prev_4+$a5_TT_prev_tt);
				$a5_Total_variance.=$a5_TT_variance_tt.",,,".($a5_Total_variance_4+$a5_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$sra3_plain_curr.=$sra3_PL_curr_tt.",,,".($sra3_plain_curr_4+$sra3_PL_curr_tt);
				$sra3_plain_prev.=$sra3_PL_prev_tt.",,,".($sra3_plain_prev_4+$sra3_PL_prev_tt);
				$sra3_plain_variance.=$sra3_PL_variance_tt.",,,".($sra3_plain_variance_4+$sra3_PL_variance_tt);
			
				$sra3_printed_curr.=$sra3_PR_curr_tt.",,,".($sra3_printed_curr_4+$sra3_PR_curr_tt);
				$sra3_printed_prev.=$sra3_PR_prev_tt.",,,".($sra3_printed_prev_4+$sra3_PR_prev_tt);
				$sra3_printed_variance.=$sra3_PR_variance_tt.",,,".($sra3_printed_variance_4+$sra3_PR_variance_tt);
		
				$sra3_Total_curr.=$sra3_TT_curr_tt.",,,".($sra3_Total_curr_4+$sra3_TT_curr_tt);
				$sra3_Total_prev.=$sra3_TT_prev_tt.",,,".($sra3_Total_prev_4+$sra3_TT_prev_tt);
				$sra3_Total_variance.=$sra3_TT_variance_tt.",,,".($sra3_Total_variance_4+$sra3_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$roll_plain_curr.=$roll_PL_curr_tt.",,,".($roll_plain_curr_4+$roll_PL_curr_tt);
				$roll_plain_prev.=$roll_PL_prev_tt.",,,".($roll_plain_prev_4+$roll_PL_prev_tt);
				$roll_plain_variance.=$roll_PL_variance_tt.",,,".($roll_plain_variance_4+$roll_PL_variance_tt);
			
				$roll_printed_curr.=$roll_PR_curr_tt.",,,".($roll_printed_curr_4+$roll_PR_curr_tt);
				$roll_printed_prev.=$roll_PR_prev_tt.",,,".($roll_printed_prev_4+$roll_PR_prev_tt);
				$roll_printed_variance.=$roll_PR_variance_tt.",,,".($roll_printed_variance_4+$roll_PR_variance_tt);
		
				$roll_Total_curr.=$roll_TT_curr_tt.",,,".($roll_Total_curr_4+$roll_TT_curr_tt);
				$roll_Total_prev.=$roll_TT_prev_tt.",,,".($roll_Total_prev_4+$roll_TT_prev_tt);
				$roll_Total_variance.=$roll_TT_variance_tt.",,,".($roll_Total_variance_4+$roll_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$IL_plain_curr.=$IL_PL_curr_tt.",,,".($IL_plain_curr_4+$IL_PL_curr_tt);
				$IL_plain_prev.=$IL_PL_prev_tt.",,,".($IL_plain_prev_4+$IL_PL_prev_tt);
				$IL_plain_variance.=$IL_PL_variance_tt.",,,".($IL_plain_variance_4+$IL_PL_variance_tt);
			
				$IL_printed_curr.=$IL_PR_curr_tt.",,,".($IL_printed_curr_4+$IL_PR_curr_tt);
				$IL_printed_prev.=$IL_PR_prev_tt.",,,".($IL_printed_prev_4+$IL_PR_prev_tt);
				$IL_printed_variance.=$IL_PR_variance_tt.",,,".($IL_printed_variance_4+$IL_PR_variance_tt);
		
				$IL_Total_curr.=$IL_TT_curr_tt.",,,".($IL_Total_curr_4+$IL_TT_curr_tt);
				$IL_Total_prev.=$IL_TT_prev_tt.",,,".($IL_Total_prev_4+$IL_TT_prev_tt);
				$IL_Total_variance.=$IL_TT_variance_tt.",,,".($IL_Total_variance_4+$IL_TT_variance_tt);
				
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$custom_curr.=$cus_curr_tt.",,,".($cus_curr_4+$cus_curr_tt);
				$custom_prev.=$cus_prev_tt.",,,".($cus_prev_4+$cus_prev_tt);
				$custom_variance.=$cus_variance_tt.",,,".($cus_variance_4+$cus_variance_tt);
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			$row.=$datee.$new_row.$datee2.$new_row.$week_row;
		/*--------------------concatenated A3-brand--------------------*/	
			$row.=$a3_plain_curr."\r\n";
			$row.=$a3_plain_prev."\r\n";
			$row.=$a3_plain_variance."\r\n"."\r\n";
			
			$row.=$a3_printed_curr."\r\n";
			$row.=$a3_printed_prev."\r\n";
			$row.=$a3_printed_variance."\r\n"."\r\n";
			
			$row.=$a3_Total_curr."\r\n";
			$row.=$a3_Total_prev."\r\n";
			$row.=$a3_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->A3-brand--------------------*/
		
		/*--------------------concatenated A4-brand--------------------*/	
			$row.=$a4_plain_curr."\r\n";
			$row.=$a4_plain_prev."\r\n";
			$row.=$a4_plain_variance."\r\n"."\r\n";
			
			$row.=$a4_printed_curr."\r\n";
			$row.=$a4_printed_prev."\r\n";
			$row.=$a4_printed_variance."\r\n"."\r\n";
			
			$row.=$a4_Total_curr."\r\n";
			$row.=$a4_Total_prev."\r\n";
			$row.=$a4_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->A4-brand--------------------*/
		
		/*--------------------concatenated A5-brand--------------------*/	
			$row.=$a5_plain_curr."\r\n";
			$row.=$a5_plain_prev."\r\n";
			$row.=$a5_plain_variance."\r\n"."\r\n";
			
			$row.=$a5_printed_curr."\r\n";
			$row.=$a5_printed_prev."\r\n";
			$row.=$a5_printed_variance."\r\n"."\r\n";
			
			$row.=$a5_Total_curr."\r\n";
			$row.=$a5_Total_prev."\r\n";
			$row.=$a5_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->A5-brand--------------------*/
		
		/*--------------------concatenated SRA3-brand--------------------*/	
			$row.=$sra3_plain_curr."\r\n";
			$row.=$sra3_plain_prev."\r\n";
			$row.=$sra3_plain_variance."\r\n"."\r\n";
			
			$row.=$sra3_printed_curr."\r\n";
			$row.=$sra3_printed_prev."\r\n";
			$row.=$sra3_printed_variance."\r\n"."\r\n";
			
			$row.=$sra3_Total_curr."\r\n";
			$row.=$sra3_Total_prev."\r\n";
			$row.=$sra3_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->SRA3-brand--------------------*/
		
		/*--------------------concatenated Roll-brand--------------------*/	
			$row.=$roll_plain_curr."\r\n";
			$row.=$roll_plain_prev."\r\n";
			$row.=$roll_plain_variance."\r\n"."\r\n";
			
			$row.=$roll_printed_curr."\r\n";
			$row.=$roll_printed_prev."\r\n";
			$row.=$roll_printed_variance."\r\n"."\r\n";
			
			$row.=$roll_Total_curr."\r\n";
			$row.=$roll_Total_prev."\r\n";
			$row.=$roll_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->Roll-brand--------------------*/
		
		/*--------------------concatenated IL-brand--------------------*/	
			$row.=$IL_plain_curr."\r\n";
			$row.=$IL_plain_prev."\r\n";
			$row.=$IL_plain_variance."\r\n"."\r\n";
			
			$row.=$IL_printed_curr."\r\n";
			$row.=$IL_printed_prev."\r\n";
			$row.=$IL_printed_variance."\r\n"."\r\n";
			
			$row.=$IL_Total_curr."\r\n";
			$row.=$IL_Total_prev."\r\n";
			$row.=$IL_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->SRA3-brand--------------------*/
			
			$row.=$custom_curr."\r\n";
			$row.=$custom_prev."\r\n";
			$row.=$custom_variance."\r\n"."\r\n";
			
		/*--------------------End of concatenated of custom brand--------------------*/
			
			$this->load->helper('download');
			header('Content-Type: application/csv');
    		$name = 'Weekly_Volume_Report_'.date('d-M-Y').'.csv'; 
   		 	header('Content-Disposition: attachment; filename="'.basename($name).'"');  
			$fp = fopen('php://output', 'w');
			force_download($name, $row);
    		fclose($fp);
		}
	}

    public function get_value_from_array($brand, $array_result, $function,$first_key){
		if(isset($array_result[$function]) and is_array($array_result[$function])){
			$a4_row_curr =$array_result[$first_key][$brand];
			if($a4_row_curr == ''){
				$a4_row_curr = 0;
			}
		}else{
			$a4_row_curr ="-";	
		}
		return $a4_row_curr;
	}
	public function get_value_from_array_printed($brand, $array_result, $function,$first_key){
		$n=0;if($brand == "A3"){ $brand= $brand."_Print";}
		else if($brand == "A4"){ $brand= $brand."_Print";}
		else if($brand == "A5"){ $brand= $brand."_Print";}
		else if($brand == "SRA3"){ $brand= $brand."_Print";}
		else if($brand == "Rolls"){ $brand= $brand."_Print";$n=1;}
		else if($brand == "Integrated"){ $brand= $brand."_Print";}
		
		if(isset($array_result[$function]) and is_array($array_result[$function])){
			$a4_row_curr =$array_result[$first_key][$brand];
			if($a4_row_curr == ''){
				$a4_row_curr = 0;
			}
		}else{
			$a4_row_curr ="-";	
		}
		return $a4_row_curr;
	}

	function value_report(){ 
	    
		
	 if(isset($_POST['report-form'])){
			$next = $this->input->post("year-form");
			
			$year = substr($next,2,2);
			$prev =$next-1;
			$next_year =$next+1;
			$year = $prev.'/'.$year;
			
			$week = 1;
			
			$function = $this->getStartAndEndDate($week,$prev);
			
			$function = explode('.',$function);
			if($week == 1 && $function[0] > 6){
				$wek=$week-1;
				$function = $this->getStartAndEndDate($wek,$prev);
				$function = explode('.',$function);
				$prev_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:01";
			}else{
				$prev_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:01";
			}
			
			$function = $this->getStartAndEndDate($week,$next);
			$function = explode('.',$function);
			if($week == 1 && $function[0] > 6){
				$wek=$week-1;
				$function = $this->getStartAndEndDate($wek,$next);
				$function = explode('.',$function);
				$next_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}else{
				$next_t = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}
			
			$function = $this->getStartAndEndDate($week,$next_year);
			$function = explode('.',$function);
			if($week == 1 && $function[0] > 6){
				$wek=$week-1;
				$function = $this->getStartAndEndDate($wek,$next+1);
				$function = explode('.',$function);
				$next_year = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}else{
				$next_year = ("20".$function[2]).'-'.$function[1].'-'.$function[0]." 00:00:00";
			}
			
			$status_EMAIL = "AND ( 
								   `o`.`OrderStatus`=2 
								OR `o`.`OrderStatus`=7  OR `o`.`OrderStatus`=08 
								OR `o`.`OrderStatus`=32 OR `o`.`OrderStatus`=33 
								OR `o`.`OrderStatus`=38 OR `o`.`OrderStatus`=40 
								OR `o`.`OrderStatus`=55 OR `o`.`OrderStatus`=56
							)
							AND ( 
							  	    `o`.`Billingemail` NOT LIKE 'arslan.jd@gmail.com' 
							    AND `o`.`Billingemail` NOT LIKE 'sohail.sethi1@gmail.com' 
								AND `o`.`Billingemail` NOT LIKE 'kiransethi7@yahoo.com' 
								AND `o`.`Billingemail` NOT LIKE 'sohail@gtrecycling.com' 
								AND `o`.`Billingemail` NOT LIKE 'kami.ramzan77@gmail.com' 
							) ";
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, ProductBrand, Printing, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
								WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Price` ) AS next_Total, 
								SUM(`od`.`Print_Total`) AS print_Total
						FROM orders AS `o`
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber`
							INNER JOIN `products` AS `prd` ON `od`.`ProductID` = `prd`.`ProductID`
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$prev_t' )
							AND FROM_UNIXTIME( `OrderDate` ) < ( '$next_t' )
							AND (
								   `ProductBrand` LIKE 'a4 labels'
								OR `ProductBrand` LIKE 'a3 label'
								OR `ProductBrand` LIKE 'a5 labels'
								OR `ProductBrand` LIKE 'sra3 label'
								OR `ProductBrand` LIKE 'Roll labels'
								OR `ProductBrand` LIKE 'Integrated labels'
								OR `od`.`ProductID` = 0
							) 
							$status_EMAIL
						
						GROUP BY CONCAT_WS( week, ProductBrand, Printing, '' )
						ORDER BY `OrderDate` ASC ";
			$query_result_prev = $this->db->query($query)->result();
			//echo $this->db->last_query(); echo '<br>';
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, ProductBrand, Printing, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
										 WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Price` ) AS next_Total, 
										 SUM(`od`.`Print_Total`) AS print_Total
						FROM orders AS `o`
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber`
							INNER JOIN `products` AS `prd` ON `od`.`ProductID` = `prd`.`ProductID`
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$next_t' )
							AND FROM_UNIXTIME( `OrderDate` ) < ( '$next_year' )
							AND (
								   `ProductBrand` LIKE 'a4 labels'
								OR `ProductBrand` LIKE 'a3 label'
								OR `ProductBrand` LIKE 'a5 labels'
								OR `ProductBrand` LIKE 'sra3 label'
								OR `ProductBrand` LIKE 'Roll labels'
								OR `ProductBrand` LIKE 'Integrated labels'
								OR `od`.`ProductID` = 0
							) 
							$status_EMAIL
						
						GROUP BY CONCAT_WS( week, ProductBrand, Printing, '' )
						ORDER BY `OrderDate` ASC ";
	
			$query_result_next = $this->db->query($query)->result();			
				//echo $this->db->last_query(); exit;
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
										WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Price` ) AS next_Total, `od`.`ManufactureID` 
						FROM orders AS `o` 
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber` 
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$prev_t' ) 
							AND FROM_UNIXTIME( `OrderDate` ) < ( '$next_t' ) 
							AND `od`.`ManufactureID` LIKE 'PRL1' 
							$status_EMAIL
						GROUP BY week ORDER BY `OrderDate` ASC";
			$query_prl1_prev = $this->db->query($query)->result();
			
			$query = "SELECT week( FROM_UNIXTIME( `OrderDate` ), 1 ) AS week, STR_TO_DATE( concat( concat( date_format( FROM_UNIXTIME( `OrderDate` ) , '%Y' ),
										WEEKOFYEAR( FROM_UNIXTIME( `OrderDate` ) ) ) , 'Monday' ) , '%X%V %W' ) AS datee, SUM( `od`.`Price` ) AS next_Total, `od`.`ManufactureID` 
						FROM orders AS `o` 
							INNER JOIN `orderdetails` AS `od` ON `od`.`OrderNumber` = `o`.`OrderNumber` 
						WHERE FROM_UNIXTIME( `OrderDate` ) > ( '$next_t' ) 
							AND FROM_UNIXTIME( `OrderDate`  ) < ( '$next_year' ) 
							AND `od`.`ManufactureID` LIKE 'PRL1' 
								$status_EMAIL
						GROUP BY week ORDER BY `OrderDate` ASC";
			
			$query_prl1_next = $this->db->query($query)->result();
			
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$array_result_prev = $this->week_index_array($query_result_prev, $query_prl1_prev); 
			$array_result_next = $this->week_index_array($query_result_next, $query_prl1_next); 
		    $value =1;
			$row.= 'Date,'.$prev.',';
			//$row.= 'Date,'.$next.',';
			$rt=1;
			$first_key = key($array_result_next);
			
		/*--------------------intialinzing A4 array--------------------*/
			$a4_plain_curr.="A4(Plain),Actual,";
			$a4_plain_prev.=",".$year.",";
			$a4_plain_variance.=",variance,";
			
			$a4_printed_curr.="A4(Printed),Actual,";
			$a4_printed_prev.=",".$year.",";
			$a4_printed_variance.=",variance,";
			
			$a4_Total_curr.="A4(Total),Actual,";
			$a4_Total_prev.=",".$year.",";
			$a4_Total_variance.=",variance,";
		
		/*--------------------intialinzing A3 array--------------------*/
			$a3_plain_curr.="A3(Plain),Actual,";
			$a3_plain_prev.=",".$year.",";
			$a3_plain_variance.=",variance,";
			
			$a3_printed_curr.="A3(Printed),Actual,";
			$a3_printed_prev.=",".$year.",";
			$a3_printed_variance.=",variance,";
			
			$a3_Total_curr.="A3(Total),Actual,";
			$a3_Total_prev.=",".$year.",";
			$a3_Total_variance.=",variance,";
//		
		/*--------------------intialinzing A5 array--------------------*/
			$a5_plain_curr.="A5(Plain),Actual,";
			$a5_plain_prev.=",".$year.",";
			$a5_plain_variance.=",variance,";
			
			$a5_printed_curr.="A5(Printed),Actual,";
			$a5_printed_prev.=",".$year.",";
			$a5_printed_variance.=",variance,";
			
			$a5_Total_curr.="A5(Total),Actual,";
			$a5_Total_prev.=",".$year.",";
			$a5_Total_variance.=",variance,";
			
		/*--------------------intialinzing IL array--------------------*/
			$IL_plain_curr.="IL(Plain),Actual,";
			$IL_plain_prev.=",".$year.",";
			$IL_plain_variance.=",variance,";
			
			$IL_printed_curr.="IL(Printed),Actual,";
			$IL_printed_prev.=",".$year.",";
			$IL_printed_variance.=",variance,";
			
			$IL_Total_curr.="IL(Total),Actual,";
			$IL_Total_prev.=",".$year.",";
			$IL_Total_variance.=",variance,";
		
		/*--------------------intialinzing Roll array--------------------*/
			$roll_plain_curr.="Roll(Plain),Actual,";
			$roll_plain_prev.=",".$year.",";
			$roll_plain_variance.=",variance,";
			
			$roll_printed_curr.="Roll(Printed),Actual,";
			$roll_printed_prev.=",".$year.",";
			$roll_printed_variance.=",variance,";
			
			$roll_Total_curr.="Roll(Total),Actual,";
			$roll_Total_prev.=",".$year.",";
			$roll_Total_variance.=",variance,";
		
		/*--------------------intialinzing SRA3 array--------------------*/
			$sra3_plain_curr.="SRA3(Plain),Actual,";
			$sra3_plain_prev.=",".$year.",";
			$sra3_plain_variance.=",variance,";
			
			$sra3_printed_curr.="SRA3(Printed),Actual,";
			$sra3_printed_prev.=",".$year.",";
			$sra3_printed_variance.=",variance,";
			
			$sra3_Total_curr.="SRA3(Total),Actual,";
			$sra3_Total_prev.=",".$year.",";
			$sra3_Total_variance.=",variance,";

			$custom_curr.="Custom,Actual,";
			$custom_prev.=",".$year.",";
			$custom_variance.=",variance,";
		
			$b=0;
			
			$week=14;
			for($i =0;$i <= 134; $i++){
				if($i < 61){
					if($i == 13 || $i == 29 || $i == 45){
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$a4_plain_curr.=$a4_PL_curr_tt;
						$a4_plain_prev.=$a4_PL_prev_tt;
						$a4_plain_variance.=$a4_PL_variance_tt;
						
						$a4_printed_curr.=$a4_PR_curr_tt;
						$a4_printed_prev.=$a4_PR_prev_tt;
						$a4_printed_variance.=$a4_PR_variance_tt;
					
						$a4_Total_curr.=$a4_TT_curr_tt;
						$a4_Total_prev.=$a4_TT_prev_tt;
						$a4_Total_variance.=$a4_TT_variance_tt;
					/*--------------------For Row Total of A4--------------------*/	
						$a4_plain_curr_4+=$a4_PL_curr_tt;
						$a4_plain_prev_4+=$a4_PL_prev_tt;
						$a4_plain_variance_4+=$a4_PL_variance_tt;
						
						$a4_printed_curr_4+=$a4_PR_curr_tt;
						$a4_printed_prev_4+=$a4_PR_prev_tt;
						$a4_printed_variance_4+=$a4_PR_variance_tt;
					
						$a4_Total_curr_4+=$a4_TT_curr_tt;
						$a4_Total_prev_4+=$a4_TT_prev_tt;
						$a4_Total_variance_4+=$a4_TT_variance_tt;						
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$a4_PL_curr_tt = $a4_PL_prev_tt = $a4_PL_variance_tt = 0;
						$a4_PR_curr_tt = $a4_PR_prev_tt = $a4_PR_variance_tt = 0;
						$a4_TT_curr_tt = $a4_TT_prev_tt = $a4_TT_variance_tt = 0;
						
					/*--------------------intialinzing A3 array--------------------*/
						$a3_plain_curr.=$a3_PL_curr_tt;
						$a3_plain_prev.=$a3_PL_prev_tt;
						$a3_plain_variance.=$a3_PL_variance_tt;
						
						$a3_printed_curr.=$a3_PR_curr_tt;
						$a3_printed_prev.=$a3_PR_prev_tt;
						$a3_printed_variance.=$a3_PR_variance_tt;
					
						$a3_Total_curr.=$a3_TT_curr_tt;
						$a3_Total_prev.=$a3_TT_prev_tt;
						$a3_Total_variance.=$a3_TT_variance_tt;
					
					/*--------------------For Row Total of A3--------------------*/
						$a3_plain_curr_4+=$a3_PL_curr_tt;
						$a3_plain_prev_4+=$a3_PL_prev_tt;
						$a3_plain_variance_4+=$a3_PL_variance_tt;
						
						$a3_printed_curr_4+=$a3_PR_curr_tt;
						$a3_printed_prev_4+=$a3_PR_prev_tt;
						$a3_printed_variance_4+=$a3_PR_variance_tt;
					
						$a3_Total_curr_4+=$a3_TT_curr_tt;
						$a3_Total_prev_4+=$a3_TT_prev_tt;
						$a3_Total_variance_4+=$a3_TT_variance_tt;
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$a3_PL_curr_tt = $a3_PL_prev_tt = $a3_PL_variance_tt = 0;
						$a3_PR_curr_tt = $a3_PR_prev_tt = $a3_PR_variance_tt = 0;
						$a3_TT_curr_tt = $a3_TT_prev_tt = $a3_TT_variance_tt = 0;
//						
					/*--------------------intialinzing A5 array--------------------*/
						$a5_plain_curr.=$a5_PL_curr_tt;
						$a5_plain_prev.=$a5_PL_prev_tt;
						$a5_plain_variance.=$a5_PL_variance_tt;
						
						$a5_printed_curr.=$a5_PR_curr_tt;
						$a5_printed_prev.=$a5_PR_prev_tt;
						$a5_printed_variance.=$a5_PR_variance_tt;
					
						$a5_Total_curr.=$a5_TT_curr_tt;
						$a5_Total_prev.=$a5_TT_prev_tt;
						$a5_Total_variance.=$a5_TT_variance_tt;
						
					/*--------------------For Row Total of A5--------------------*/
						$a5_plain_curr_4+=$a5_PL_curr_tt;
						$a5_plain_prev_4+=$a5_PL_prev_tt;
						$a5_plain_variance_4+=$a5_PL_variance_tt;
						
						$a5_printed_curr_4+=$a5_PR_curr_tt;
						$a5_printed_prev_4+=$a5_PR_prev_tt;
						$a5_printed_variance_4+=$a5_PR_variance_tt;
					
						$a5_Total_curr_4+=$a5_TT_curr_tt;
						$a5_Total_prev_4+=$a5_TT_prev_tt;
						$a5_Total_variance_4+=$a5_TT_variance_tt;
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						$a5_PL_curr_tt = $a5_PL_prev_tt = $a5_PL_variance_tt = 0;
						$a5_PR_curr_tt = $a5_PR_prev_tt = $a5_PR_variance_tt = 0;
						$a5_TT_curr_tt = $a5_TT_prev_tt = $a5_TT_variance_tt = 0;
					
					/*--------------------intialinzing SRA3 array--------------------*/
						$sra3_plain_curr.=$sra3_PL_curr_tt;
						$sra3_plain_prev.=$sra3_PL_prev_tt;
						$sra3_plain_variance.=$sra3_PL_variance_tt;
						
						$sra3_printed_curr.=$sra3_PR_curr_tt;
						$sra3_printed_prev.=$sra3_PR_prev_tt;
						$sra3_printed_variance.=$sra3_PR_variance_tt;
					
						$sra3_Total_curr.=$sra3_TT_curr_tt;
						$sra3_Total_prev.=$sra3_TT_prev_tt;
						$sra3_Total_variance.=$sra3_TT_variance_tt;
					
					/*--------------------For Row Total of SRA3--------------------*/
						$sra3_plain_curr_4+=$sra3_PL_curr_tt;
						$sra3_plain_prev_4+=$sra3_PL_prev_tt;
						$sra3_plain_variance_4+=$sra3_PL_variance_tt;
						
						$sra3_printed_curr_4+=$sra3_PR_curr_tt;
						$sra3_printed_prev_4+=$sra3_PR_prev_tt;
						$sra3_printed_variance_4+=$sra3_PR_variance_tt;
					
						$sra3_Total_curr_4+=$sra3_TT_curr_tt;
						$sra3_Total_prev_4+=$sra3_TT_prev_tt;
						$sra3_Total_variance_4+=$sra3_TT_variance_tt;
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//
						$sra3_PL_curr_tt = $sra3_PL_prev_tt = $sra3_PL_variance_tt = 0;
						$sra3_PR_curr_tt = $sra3_PR_prev_tt = $sra3_PR_variance_tt = 0;
						$sra3_TT_curr_tt = $sra3_TT_prev_tt = $sra3_TT_variance_tt = 0;
					
					/*--------------------intialinzing Roll array--------------------*/
						$roll_plain_curr.=$roll_PL_curr_tt;
						$roll_plain_prev.=$roll_PL_prev_tt;
						$roll_plain_variance.=$roll_PL_variance_tt;
						
						$roll_printed_curr.=$roll_PR_curr_tt;
						$roll_printed_prev.=$roll_PR_prev_tt;
						$roll_printed_variance.=$roll_PR_variance_tt;
					
						$roll_Total_curr.=$roll_TT_curr_tt;
						$roll_Total_prev.=$roll_TT_prev_tt;
						$roll_Total_variance.=$roll_TT_variance_tt;
					
						/*--------------------For Row Total of ROLL--------------------*/
							$roll_plain_curr_4+=$roll_PL_curr_tt;
							$roll_plain_prev_4+=$roll_PL_prev_tt;
							$roll_plain_variance_4+=$roll_PL_variance_tt;
							
							$roll_printed_curr_4+=$roll_PR_curr_tt;
							$roll_printed_prev_4+=$roll_PR_prev_tt;
							$roll_printed_variance_4+=$roll_PR_variance_tt;
					
							$roll_Total_curr_4+=$roll_TT_curr_tt;
							$roll_Total_prev_4+=$roll_TT_prev_tt;
							$roll_Total_variance_4+=$roll_TT_variance_tt;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						$roll_PL_curr_tt = $roll_PL_prev_tt = $roll_PL_variance_tt = 0;
						$roll_PR_curr_tt = $roll_PR_prev_tt = $roll_PR_variance_tt = 0;
						$roll_TT_curr_tt = $roll_TT_prev_tt = $roll_TT_variance_tt = 0;
					
					/*--------------------intialinzing IL array--------------------*/
						$IL_plain_curr.=$IL_PL_curr_tt;
						$IL_plain_prev.=$IL_PL_prev_tt;
						$IL_plain_variance.=$IL_PL_variance_tt;
						
						$IL_printed_curr.=$IL_PR_curr_tt;
						$IL_printed_prev.=$IL_PR_prev_tt;
						$IL_printed_variance.=$IL_PR_variance_tt;
					
						$IL_Total_curr.=$IL_TT_curr_tt;
						$IL_Total_prev.=$IL_TT_prev_tt;
						$IL_Total_variance.=$IL_TT_variance_tt;
						/*--------------------For Row Total of IL--------------------*/
							$IL_plain_curr_4+=$IL_PL_curr_tt;
							$IL_plain_prev_4+=$IL_PL_prev_tt;
							$IL_plain_variance_4+=$IL_PL_variance_tt;
						
							$IL_printed_curr_4+=$IL_PR_curr_tt;
							$IL_printed_prev_4+=$IL_PR_prev_tt;
							$IL_printed_variance_4+=$IL_PR_variance_tt;
					
							$IL_Total_curr_4+=$IL_TT_curr_tt;
							$IL_Total_prev_4+=$IL_TT_prev_tt;
							$IL_Total_variance_4+=$IL_TT_variance_tt;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//	
						$IL_PL_curr_tt = $IL_PL_prev_tt = $IL_PL_variance_tt = 0;
						$IL_PR_curr_tt = $IL_PR_prev_tt = $IL_PR_variance_tt = 0;
						$IL_TT_curr_tt = $IL_TT_prev_tt = $IL_TT_variance_tt = 0;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
						$custom_curr.=$cus_curr_tt;
						$custom_prev.=$cus_prev_tt;
						$custom_variance.=$cus_variance_tt;
						
							$cus_curr_4+=$cus_curr_tt;
							$cus_prev_4+=$cus_prev_tt;
							$cus_variance_4+=$cus_variance_tt;
						
						$cus_curr_tt = $cus_prev_tt = $cus_variance_tt = 0;
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					}
					
					
					if(($i > 12 && $i < 16) || ($i > 28 && $i < 32) || ($i > 44 && $i < 48)){
						$datee.= ",";
						$datee2.= ",";
					/*--------------------intialinzing A4 array--------------------*/	
						$a4_plain_curr.=",";
						$a4_plain_prev.=",";
						$a4_plain_variance.=",";
						
						$a4_printed_curr.=",";
						$a4_printed_prev.=",";
						$a4_printed_variance.=",";
						
						$a4_Total_curr.=",";
						$a4_Total_prev.=",";
						$a4_Total_variance.=",";
						
					/*--------------------intialinzing A3 array--------------------*/	
						$a3_plain_curr.=",";
						$a3_plain_prev.=",";
						$a3_plain_variance.=",";
						
						$a3_printed_curr.=",";
						$a3_printed_prev.=",";
						$a3_printed_variance.=",";
						
						$a3_Total_curr.=",";
						$a3_Total_prev.=",";
						$a3_Total_variance.=",";
						
					/*--------------------intialinzing A5 array--------------------*/	
						$a5_plain_curr.=",";
						$a5_plain_prev.=",";
						$a5_plain_variance.=",";
						
						$a5_printed_curr.=",";
						$a5_printed_prev.=",";
						$a5_printed_variance.=",";
						
						$a5_Total_curr.=",";
						$a5_Total_prev.=",";
						$a5_Total_variance.=",";
					
					/*--------------------intialinzing SRA3 array--------------------*/	
						$sra3_plain_curr.=",";
						$sra3_plain_prev.=",";
						$sra3_plain_variance.=",";
						
						$sra3_printed_curr.=",";
						$sra3_printed_prev.=",";
						$sra3_printed_variance.=",";
						
						$sra3_Total_curr.=",";
						$sra3_Total_prev.=",";
						$sra3_Total_variance.=",";
					
					/*--------------------intialinzing Roll array--------------------*/	
						$roll_plain_curr.=",";
						$roll_plain_prev.=",";
						$roll_plain_variance.=",";
						
						$roll_printed_curr.=",";
						$roll_printed_prev.=",";
						$roll_printed_variance.=",";
						
						$roll_Total_curr.=",";
						$roll_Total_prev.=",";
						$roll_Total_variance.=",";	
					
					/*--------------------intialinzing IL array--------------------*/	
						$IL_plain_curr.=",";
						$IL_plain_prev.=",";
						$IL_plain_variance.=",";
						
						$IL_printed_curr.=",";
						$IL_printed_prev.=",";
						$IL_printed_variance.=",";
						
						$IL_Total_curr.=",";
						$IL_Total_prev.=",";
						$IL_Total_variance.=",";
					
					/*--------------------intialinzing custom array--------------------*/	
						$custom_curr.=",";
						$custom_prev.=",";
						$custom_variance.=",";
						
					}else{
						
						//$function = $this->getStartAndEndDate($week,$prev);
						
						$week_start = new DateTime();
						$week_start->setISODate($next,$week);
						$function = $week_start->format('d.m.y');
						$datee2.= $function.",";
						
						//$function = (int) $date->format("W");
						
						
						
						
						
						
						
						$week_start = new DateTime();
						$week_start->setISODate($prev,$week);
						$function = $week_start->format('d.m.y');
						$datee.= $function.",";
						$function = explode('.',$function);
						$function = ("20".$function[2]).'-'.$function[1].'-'.$function[0];
						$date = new DateTime($function);
						$function = (int) $date->format("W");
					
						//$array_week[$week]=$function;
						//$int = 3;
						//echo '$a'.$int.'_row_curr';die();
						if($function == 1){
							$first_key = 1;
							$week =1;
							$prev=$next;
							$next= $next+1;
						}
						
						
			/*------------------------------Calling function ------------------------------*/
						$a4_PL_variance=$a4_PL_prev=$a4_PL_curr=0;
						$a4_PL_curr = $this->get_value_from_array("A4",$array_result_next,$function,$first_key);
						$a4_PL_prev = $this->get_value_from_array("A4",$array_result_prev,$function,$first_key);
						$a4_PL_variance = $a4_PL_curr-$a4_PL_prev;
						
						$a4_plain_variance.=$a4_PL_variance.",";
						$a4_plain_curr.=$a4_PL_curr.",";
						$a4_plain_prev.=$a4_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$a4_PR_variance=$a4_PR_prev=$a4_PR_curr=0;
						$a4_PR_curr = $this->get_value_from_array_printed("A4",$array_result_next,$function,$first_key);
						$a4_PR_prev = $this->get_value_from_array_printed("A4",$array_result_prev,$function,$first_key);					
						$a4_PR_variance = $a4_PR_curr-$a4_PR_prev;
						
						$a4_printed_variance.=$a4_PR_variance.",";
						$a4_printed_curr.=$a4_PR_curr.",";
						$a4_printed_prev.=$a4_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$a4_TT_curr = $a4_PL_curr+$a4_PR_curr;
						$a4_TT_prev = $a4_PL_prev+$a4_PR_prev;				
						$a4_TT_variance = $a4_TT_curr-$a4_TT_prev;
						
						$a4_Total_variance.=$a4_TT_variance.",";
						$a4_Total_curr.=$a4_TT_curr.",";
						$a4_Total_prev.=$a4_TT_prev.",";
						
						$a4_PL_curr_tt +=$a4_PL_curr;
						$a4_PL_prev_tt +=$a4_PL_prev;
						$a4_PL_variance_tt +=$a4_PL_variance;
						
						$a4_PR_prev_tt +=$a4_PR_prev;
						$a4_PR_curr_tt +=$a4_PR_curr;
						$a4_PR_variance_tt +=$a4_PR_variance;
						
						$a4_TT_prev_tt +=$a4_TT_prev;
						$a4_TT_curr_tt +=$a4_TT_curr;
						$a4_TT_variance_tt +=$a4_TT_variance;
			
			/*------------------------------Calling function A3------------------------------*/			
						$a3_PL_curr = $this->get_value_from_array("A3",$array_result_next,$function,$first_key);
						$a3_PL_prev = $this->get_value_from_array("A3",$array_result_prev,$function,$first_key);
						$a3_PL_variance = $a3_PL_curr-$a3_PL_prev;
						
						$a3_plain_variance.=$a3_PL_variance.",";
						$a3_plain_curr.=$a3_PL_curr.",";
						$a3_plain_prev.=$a3_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$a3_PR_curr = $this->get_value_from_array_printed("A3",$array_result_next,$function,$first_key);
						$a3_PR_prev = $this->get_value_from_array_printed("A3",$array_result_prev,$function,$first_key);					
						$a3_PR_variance = $a3_PR_curr-$a3_PR_prev;
						
						$a3_printed_variance.=$a3_PR_variance.",";
						$a3_printed_curr.=$a3_PR_curr.",";
						$a3_printed_prev.=$a3_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$a3_TT_curr = $a3_PL_curr+$a3_PR_curr;
						$a3_TT_prev = $a3_PL_prev+$a3_PR_prev;				
						$a3_TT_variance = $a3_TT_curr-$a3_TT_prev;
						
						$a3_Total_variance.=$a3_TT_variance.",";
						$a3_Total_curr.=$a3_TT_curr.",";
						$a3_Total_prev.=$a3_TT_prev.",";
						
						$a3_PL_curr_tt +=$a3_PL_curr;
						$a3_PL_prev_tt +=$a3_PL_prev;
						$a3_PL_variance_tt +=$a3_PL_variance;
						
						$a3_PR_prev_tt +=$a3_PR_prev;
						$a3_PR_curr_tt +=$a3_PR_curr;
						$a3_PR_variance_tt +=$a3_PR_variance;
						
						$a3_TT_prev_tt +=$a3_TT_prev;
						$a3_TT_curr_tt +=$a3_TT_curr;
						$a3_TT_variance_tt +=$a3_TT_variance;
			
			/*------------------------------Calling function A5%------------------------------*/			
						$a5_PL_curr = $this->get_value_from_array("A5",$array_result_next,$function,$first_key);
						$a5_PL_prev = $this->get_value_from_array("A5",$array_result_prev,$function,$first_key);
						$a5_PL_variance = $a5_PL_curr-$a5_PL_prev;
						
						$a5_plain_variance.=$a5_PL_variance.",";
						$a5_plain_curr.=$a5_PL_curr.",";
						$a5_plain_prev.=$a5_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$a5_PR_curr = $this->get_value_from_array_printed("A5",$array_result_next,$function,$first_key);
						$a5_PR_prev = $this->get_value_from_array_printed("A5",$array_result_prev,$function,$first_key);					
						$a5_PR_variance = $a5_PR_curr-$a5_PR_prev;
						
						$a5_printed_variance.=$a5_PR_variance.",";
						$a5_printed_curr.=$a5_PR_curr.",";
						$a5_printed_prev.=$a5_PR_prev.",";
//						
						
			/*------------------------------Calling function ------------------------------*/
						$a5_TT_curr = $a5_PL_curr+$a5_PR_curr;
						$a5_TT_prev = $a5_PL_prev+$a5_PR_prev;				
						$a5_TT_variance = $a5_TT_curr-$a5_TT_prev;
						
						$a5_Total_variance.=$a5_TT_variance.",";
						$a5_Total_curr.=$a5_TT_curr.",";
						$a5_Total_prev.=$a5_TT_prev.",";
						
						$a5_PL_curr_tt +=$a5_PL_curr;
						$a5_PL_prev_tt +=$a5_PL_prev;
						$a5_PL_variance_tt +=$a5_PL_variance;
						
						$a5_PR_prev_tt +=$a5_PR_prev;
						$a5_PR_curr_tt +=$a5_PR_curr;
						$a5_PR_variance_tt +=$a5_PR_variance;
						
						$a5_TT_prev_tt +=$a5_TT_prev;
						$a5_TT_curr_tt +=$a5_TT_curr;
						$a5_TT_variance_tt +=$a5_TT_variance;
						
			/*------------------------------Calling function SRA3------------------------------*/			
						$sra3_PL_curr = $this->get_value_from_array("SRA3",$array_result_next,$function,$first_key);
						$sra3_PL_prev = $this->get_value_from_array("SRA3",$array_result_prev,$function,$first_key);
						$sra3_PL_variance = $sra3_PL_curr-$sra3_PL_prev;
						
						$sra3_plain_variance.=$sra3_PL_variance.",";
						$sra3_plain_curr.=$sra3_PL_curr.",";
						$sra3_plain_prev.=$sra3_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$sra3_PR_curr = $this->get_value_from_array_printed("SRA3",$array_result_next,$function,$first_key);
						$sra3_PR_prev = $this->get_value_from_array_printed("SRA3",$array_result_prev,$function,$first_key);					
						$sra3_PR_variance = $sra3_PR_curr-$sra3_PR_prev;
						
						$sra3_printed_variance.=$sra3_PR_variance.",";
						$sra3_printed_curr.=$sra3_PR_curr.",";
						$sra3_printed_prev.=$sra3_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$sra3_TT_curr = $sra3_PL_curr+$sra3_PR_curr;
						$sra3_TT_prev = $sra3_PL_prev+$sra3_PR_prev;				
						$sra3_TT_variance = $sra3_TT_curr-$sra3_TT_prev;
						
						$sra3_Total_variance.=$sra3_TT_variance.",";
						$sra3_Total_curr.=$sra3_TT_curr.",";
						$sra3_Total_prev.=$sra3_TT_prev.",";
						
						$sra3_PL_curr_tt +=$sra3_PL_curr;
						$sra3_PL_prev_tt +=$sra3_PL_prev;
						$sra3_PL_variance_tt +=$sra3_PL_variance;
						
						$sra3_PR_prev_tt +=$sra3_PR_prev;
						$sra3_PR_curr_tt +=$sra3_PR_curr;
						$sra3_PR_variance_tt +=$sra3_PR_variance;
						
						$sra3_TT_prev_tt +=$sra3_TT_prev;
						$sra3_TT_curr_tt +=$sra3_TT_curr;
						$sra3_TT_variance_tt +=$sra3_TT_variance;
			
			/*------------------------------Calling function ROLL------------------------------*/			
						$roll_PL_curr = $this->get_value_from_array("Rolls",$array_result_next,$function,$first_key);
						$roll_PL_prev = $this->get_value_from_array("Rolls",$array_result_prev,$function,$first_key);
						$roll_PL_variance = $roll_PL_curr-$roll_PL_prev;
						
						$roll_plain_variance.=$roll_PL_variance.",";
						$roll_plain_curr.=$roll_PL_curr.",";
						$roll_plain_prev.=$roll_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$roll_PR_curr = $this->get_value_from_array_printed("Rolls",$array_result_next,$function,$first_key);
						$roll_PR_prev = $this->get_value_from_array_printed("Rolls",$array_result_prev,$function,$first_key);					
						$roll_PR_variance = $roll_PR_curr-$roll_PR_prev;
						
						$roll_printed_variance.=$roll_PR_variance.",";
						$roll_printed_curr.=$roll_PR_curr.",";
						$roll_printed_prev.=$roll_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$roll_TT_curr = $roll_PL_curr+$roll_PR_curr;
						$roll_TT_prev = $roll_PL_prev+$roll_PR_prev;				
						$roll_TT_variance = $roll_TT_curr-$roll_TT_prev;
						
						$roll_Total_variance.=$roll_TT_variance.",";
						$roll_Total_curr.=$roll_TT_curr.",";
						$roll_Total_prev.=$roll_TT_prev.",";
						
						$roll_PL_curr_tt +=$roll_PL_curr;
						$roll_PL_prev_tt +=$roll_PL_prev;
						$roll_PL_variance_tt +=$roll_PL_variance;
						
						$roll_PR_prev_tt +=$roll_PR_prev;
						$roll_PR_curr_tt +=$roll_PR_curr;
						$roll_PR_variance_tt +=$roll_PR_variance;
						
						$roll_TT_prev_tt +=$roll_TT_prev;
						$roll_TT_curr_tt +=$roll_TT_curr;
						$roll_TT_variance_tt +=$roll_TT_variance;			
			
			/*------------------------------Calling function Integrated------------------------------*/			
						$IL_PL_curr = $this->get_value_from_array("Integrated",$array_result_next,$function,$first_key);
						$IL_PL_prev = $this->get_value_from_array("Integrated",$array_result_prev,$function,$first_key);
						$IL_PL_variance = $IL_PL_curr-$IL_PL_prev;
						
						$IL_plain_variance.=$IL_PL_variance.",";
						$IL_plain_curr.=$IL_PL_curr.",";
						$IL_plain_prev.=$IL_PL_prev.",";
						
						//echo $a4_sum['curr'];die();
			/*------------------------------Calling function ------------------------------*/
						$IL_PR_curr = $this->get_value_from_array_printed("Integrated",$array_result_next,$function,$first_key);
						$IL_PR_prev = $this->get_value_from_array_printed("Integrated",$array_result_prev,$function,$first_key);					
						$IL_PR_variance = $IL_PR_curr-$IL_PR_prev;
						
						$IL_printed_variance.=$IL_PR_variance.",";
						$IL_printed_curr.=$IL_PR_curr.",";
						$IL_printed_prev.=$IL_PR_prev.",";
						
						
			/*------------------------------Calling function ------------------------------*/
						$IL_TT_curr = $IL_PL_curr+$IL_PR_curr;
						$IL_TT_prev = $IL_PL_prev+$IL_PR_prev;				
						$IL_TT_variance = $IL_TT_curr-$IL_TT_prev;
						
						$IL_Total_variance.=$IL_TT_variance.",";
						$IL_Total_curr.=$IL_TT_curr.",";
						$IL_Total_prev.=$IL_TT_prev.",";
						
						$IL_PL_curr_tt +=$IL_PL_curr;
						$IL_PL_prev_tt +=$IL_PL_prev;
						$IL_PL_variance_tt +=$IL_PL_variance;
						
						$IL_PR_prev_tt +=$IL_PR_prev;
						$IL_PR_curr_tt +=$IL_PR_curr;
						$IL_PR_variance_tt +=$IL_PR_variance;
						
						$IL_TT_prev_tt +=$IL_TT_prev;
						$IL_TT_curr_tt +=$IL_TT_curr;
						$IL_TT_variance_tt +=$IL_TT_variance;
			
			/*------------------------------Calling function Integrated------------------------------*/			
						$cus_curr = $this->get_value_from_array("Custom",$array_result_next,$function,$first_key);
						$cus_prev = $this->get_value_from_array("Custom",$array_result_prev,$function,$first_key);
						$cus_variance = $cus_curr-$cus_prev;
						
						$custom_variance.=$cus_variance.",";
						$custom_curr.=$cus_curr.",";
						$custom_prev.=$cus_prev.",";
						
						$cus_curr_tt+=$cus_curr;
						$cus_prev_tt+=$cus_prev;
						$cus_variance_tt+=$cus_variance;
			
						$first_key++;
						$week++;
						
						
					}
				}else if($i == 61){
					$new_row.= "\r\n".",".",";
				}else if($i > 61 && $i < 123){
					if($i == 75 || $i == 91 || $i == 107){
						$week_row.="Q".$rt++." TOTAL";
					}if(($i > 74 && $i < 78) || ($i > 90 && $i < 94) || ($i > 106 && $i < 110)){
						$week_row.=",";
					}else{
						$week_row.= "W-".++$a.",";
					}
				}
			}
			$week_row.="Q".$rt." TOTAL".",,,".$year." Total"."\r\n";
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$a4_plain_curr.=$a4_PL_curr_tt.",,,".($a4_plain_curr_4+$a4_PL_curr_tt);
				$a4_plain_prev.=$a4_PL_prev_tt.",,,".($a4_plain_prev_4+$a4_PL_prev_tt);
				$a4_plain_variance.=$a4_PL_variance_tt.",,,".($a4_plain_variance_4+$a4_PL_variance_tt);
			
				$a4_printed_curr.=$a4_PR_curr_tt.",,,".($a4_printed_curr_4+$a4_PR_curr_tt);
				$a4_printed_prev.=$a4_PR_prev_tt.",,,".($a4_printed_prev_4+$a4_PR_prev_tt);
				$a4_printed_variance.=$a4_PR_variance_tt.",,,".($a4_printed_variance_4+$a4_PR_variance_tt);
		
				$a4_Total_curr.=$a4_TT_curr_tt.",,,".($a4_Total_curr_4+$a4_TT_curr_tt);
				$a4_Total_prev.=$a4_TT_prev_tt.",,,".($a4_Total_prev_4+$a4_TT_prev_tt);
				$a4_Total_variance.=$a4_TT_variance_tt.",,,".($a4_Total_variance_4+$a4_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$a3_plain_curr.=$a3_PL_curr_tt.",,,".($a3_plain_curr_4+$a3_PL_curr_tt);
				$a3_plain_prev.=$a3_PL_prev_tt.",,,".($a3_plain_prev_4+$a3_PL_prev_tt);
				$a3_plain_variance.=$a3_PL_variance_tt.",,,".($a3_plain_variance_4+$a3_PL_variance_tt);
			
				$a3_printed_curr.=$a3_PR_curr_tt.",,,".($a3_printed_curr_4+$a3_PR_curr_tt);
				$a3_printed_prev.=$a3_PR_prev_tt.",,,".($a3_printed_prev_4+$a3_PR_prev_tt);
				$a3_printed_variance.=$a3_PR_variance_tt.",,,".($a3_printed_variance_4+$a3_PR_variance_tt);
		
				$a3_Total_curr.=$a3_TT_curr_tt.",,,".($a3_Total_curr_4+$a3_TT_curr_tt);
				$a3_Total_prev.=$a3_TT_prev_tt.",,,".($a3_Total_prev_4+$a3_TT_prev_tt);
				$a3_Total_variance.=$a3_TT_variance_tt.",,,".($a3_Total_variance_4+$a3_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$a5_plain_curr.=$a5_PL_curr_tt.",,,".($a5_plain_curr_4+$a5_PL_curr_tt);
				$a5_plain_prev.=$a5_PL_prev_tt.",,,".($a5_plain_prev_4+$a5_PL_prev_tt);
				$a5_plain_variance.=$a5_PL_variance_tt.",,,".($a5_plain_variance_4+$a5_PL_variance_tt);
			
				$a5_printed_curr.=$a5_PR_curr_tt.",,,".($a5_printed_curr_4+$a5_PR_curr_tt);
				$a5_printed_prev.=$a5_PR_prev_tt.",,,".($a5_printed_prev_4+$a5_PR_prev_tt);
				$a5_printed_variance.=$a5_PR_variance_tt.",,,".($a5_printed_variance_4+$a5_PR_variance_tt);
		
				$a5_Total_curr.=$a5_TT_curr_tt.",,,".($a5_Total_curr_4+$a5_TT_curr_tt);
				$a5_Total_prev.=$a5_TT_prev_tt.",,,".($a5_Total_prev_4+$a5_TT_prev_tt);
				$a5_Total_variance.=$a5_TT_variance_tt.",,,".($a5_Total_variance_4+$a5_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$sra3_plain_curr.=$sra3_PL_curr_tt.",,,".($sra3_plain_curr_4+$sra3_PL_curr_tt);
				$sra3_plain_prev.=$sra3_PL_prev_tt.",,,".($sra3_plain_prev_4+$sra3_PL_prev_tt);
				$sra3_plain_variance.=$sra3_PL_variance_tt.",,,".($sra3_plain_variance_4+$sra3_PL_variance_tt);
			
				$sra3_printed_curr.=$sra3_PR_curr_tt.",,,".($sra3_printed_curr_4+$sra3_PR_curr_tt);
				$sra3_printed_prev.=$sra3_PR_prev_tt.",,,".($sra3_printed_prev_4+$sra3_PR_prev_tt);
				$sra3_printed_variance.=$sra3_PR_variance_tt.",,,".($sra3_printed_variance_4+$sra3_PR_variance_tt);
		
				$sra3_Total_curr.=$sra3_TT_curr_tt.",,,".($sra3_Total_curr_4+$sra3_TT_curr_tt);
				$sra3_Total_prev.=$sra3_TT_prev_tt.",,,".($sra3_Total_prev_4+$sra3_TT_prev_tt);
				$sra3_Total_variance.=$sra3_TT_variance_tt.",,,".($sra3_Total_variance_4+$sra3_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$roll_plain_curr.=$roll_PL_curr_tt.",,,".($roll_plain_curr_4+$roll_PL_curr_tt);
				$roll_plain_prev.=$roll_PL_prev_tt.",,,".($roll_plain_prev_4+$roll_PL_prev_tt);
				$roll_plain_variance.=$roll_PL_variance_tt.",,,".($roll_plain_variance_4+$roll_PL_variance_tt);
			
				$roll_printed_curr.=$roll_PR_curr_tt.",,,".($roll_printed_curr_4+$roll_PR_curr_tt);
				$roll_printed_prev.=$roll_PR_prev_tt.",,,".($roll_printed_prev_4+$roll_PR_prev_tt);
				$roll_printed_variance.=$roll_PR_variance_tt.",,,".($roll_printed_variance_4+$roll_PR_variance_tt);
		
				$roll_Total_curr.=$roll_TT_curr_tt.",,,".($roll_Total_curr_4+$roll_TT_curr_tt);
				$roll_Total_prev.=$roll_TT_prev_tt.",,,".($roll_Total_prev_4+$roll_TT_prev_tt);
				$roll_Total_variance.=$roll_TT_variance_tt.",,,".($roll_Total_variance_4+$roll_TT_variance_tt);
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$IL_plain_curr.=$IL_PL_curr_tt.",,,".($IL_plain_curr_4+$IL_PL_curr_tt);
				$IL_plain_prev.=$IL_PL_prev_tt.",,,".($IL_plain_prev_4+$IL_PL_prev_tt);
				$IL_plain_variance.=$IL_PL_variance_tt.",,,".($IL_plain_variance_4+$IL_PL_variance_tt);
			
				$IL_printed_curr.=$IL_PR_curr_tt.",,,".($IL_printed_curr_4+$IL_PR_curr_tt);
				$IL_printed_prev.=$IL_PR_prev_tt.",,,".($IL_printed_prev_4+$IL_PR_prev_tt);
				$IL_printed_variance.=$IL_PR_variance_tt.",,,".($IL_printed_variance_4+$IL_PR_variance_tt);
		
				$IL_Total_curr.=$IL_TT_curr_tt.",,,".($IL_Total_curr_4+$IL_TT_curr_tt);
				$IL_Total_prev.=$IL_TT_prev_tt.",,,".($IL_Total_prev_4+$IL_TT_prev_tt);
				$IL_Total_variance.=$IL_TT_variance_tt.",,,".($IL_Total_variance_4+$IL_TT_variance_tt);
				
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$custom_curr.=$cus_curr_tt.",,,".($cus_curr_4+$cus_curr_tt);
				$custom_prev.=$cus_prev_tt.",,,".($cus_prev_4+$cus_prev_tt);
				$custom_variance.=$cus_variance_tt.",,,".($cus_variance_4+$cus_variance_tt);
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			$row.=$datee.$new_row.$datee2.$new_row.$week_row;
		/*--------------------concatenated A3-brand--------------------*/	
			$row.=$a3_plain_curr."\r\n";
			$row.=$a3_plain_prev."\r\n";
			$row.=$a3_plain_variance."\r\n"."\r\n";
			
			$row.=$a3_printed_curr."\r\n";
			$row.=$a3_printed_prev."\r\n";
			$row.=$a3_printed_variance."\r\n"."\r\n";
			
			$row.=$a3_Total_curr."\r\n";
			$row.=$a3_Total_prev."\r\n";
			$row.=$a3_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->A3-brand--------------------*/
		
		/*--------------------concatenated A4-brand--------------------*/	
			$row.=$a4_plain_curr."\r\n";
			$row.=$a4_plain_prev."\r\n";
			$row.=$a4_plain_variance."\r\n"."\r\n";
			
			$row.=$a4_printed_curr."\r\n";
			$row.=$a4_printed_prev."\r\n";
			$row.=$a4_printed_variance."\r\n"."\r\n";
			
			$row.=$a4_Total_curr."\r\n";
			$row.=$a4_Total_prev."\r\n";
			$row.=$a4_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->A4-brand--------------------*/
		
		/*--------------------concatenated A5-brand--------------------*/	
			$row.=$a5_plain_curr."\r\n";
			$row.=$a5_plain_prev."\r\n";
			$row.=$a5_plain_variance."\r\n"."\r\n";
			
			$row.=$a5_printed_curr."\r\n";
			$row.=$a5_printed_prev."\r\n";
			$row.=$a5_printed_variance."\r\n"."\r\n";
			
			$row.=$a5_Total_curr."\r\n";
			$row.=$a5_Total_prev."\r\n";
			$row.=$a5_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->A5-brand--------------------*/
		
		/*--------------------concatenated SRA3-brand--------------------*/	
			$row.=$sra3_plain_curr."\r\n";
			$row.=$sra3_plain_prev."\r\n";
			$row.=$sra3_plain_variance."\r\n"."\r\n";
			
			$row.=$sra3_printed_curr."\r\n";
			$row.=$sra3_printed_prev."\r\n";
			$row.=$sra3_printed_variance."\r\n"."\r\n";
			
			$row.=$sra3_Total_curr."\r\n";
			$row.=$sra3_Total_prev."\r\n";
			$row.=$sra3_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->SRA3-brand--------------------*/
		
		/*--------------------concatenated Roll-brand--------------------*/	
			$row.=$roll_plain_curr."\r\n";
			$row.=$roll_plain_prev."\r\n";
			$row.=$roll_plain_variance."\r\n"."\r\n";
			
			$row.=$roll_printed_curr."\r\n";
			$row.=$roll_printed_prev."\r\n";
			$row.=$roll_printed_variance."\r\n"."\r\n";
			
			$row.=$roll_Total_curr."\r\n";
			$row.=$roll_Total_prev."\r\n";
			$row.=$roll_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->Roll-brand--------------------*/
		
		/*--------------------concatenated IL-brand--------------------*/	
			$row.=$IL_plain_curr."\r\n";
			$row.=$IL_plain_prev."\r\n";
			$row.=$IL_plain_variance."\r\n"."\r\n";
			
			$row.=$IL_printed_curr."\r\n";
			$row.=$IL_printed_prev."\r\n";
			$row.=$IL_printed_variance."\r\n"."\r\n";
			
			$row.=$IL_Total_curr."\r\n";
			$row.=$IL_Total_prev."\r\n";
			$row.=$IL_Total_variance."\r\n"."\r\n";
		/*--------------------End of concatenated of -->SRA3-brand--------------------*/
			
			$row.=$custom_curr."\r\n";
			$row.=$custom_prev."\r\n";
			$row.=$custom_variance."\r\n"."\r\n";
			
		/*--------------------End of concatenated of custom brand--------------------*/
			
			$this->load->helper('download');
			header('Content-Type: application/csv');
    		$name = 'Weekly Sales Report - '.date('d-M-Y') .'.csv'; 
   		 	header('Content-Disposition: attachment; filename="'.basename($name).'"');  
			$fp = fopen('php://output', 'w');
			force_download($name, $row);
    		fclose($fp);
			

		}else{
			$data['main_content'] = 'weekly_report';
			$this->load->view('page',$data);
		}
	
	}
	
	//-----------------------------------------**********************************--------------------------------------

	 
}
