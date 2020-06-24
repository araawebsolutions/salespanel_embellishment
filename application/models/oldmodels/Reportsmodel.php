<?php  

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reportsmodel extends CI_Model {

    public function DeliveryOrders_old() {
       
	   
	    $FromDate = $_REQUEST['from'];
        $date1 = explode('/', $FromDate);
        $ToDate = $_REQUEST['to'];
        $date2 = explode('/', $ToDate);
        $From = $date1[0] . '-' . $date1[1] . '-' . $date1[2];
        $To = $date2[0] . '-' . $date2[1] . '-' . $date2[2];
        $this->load->dbutil();
		
		echo $qry ="select 
					orders.UserID,
					concat(orders.BillingFirstName,' ', orders.BillingLastName),
					orders.BillingTelephone,
					orders.Billingemail,
					orders.BillingCompanyName,
					orders.OrderDate,
					orders.OrderShippingAmount,
					orders.OrderNumber
					from orders
					where (OrderDate BETWEEN '" . strtotime($From) . "' AND '" . strtotime($To . '23:59:59') . "') 
					and   (OrderStatus = '7')
					and   (Domain = 'AA')
					and   (OrderTotal != '0')
					order by OrderDate desc";
					
        $query = $this->db->get($qry);
die();

        if ($query->result() == NULL) {

            $data['error'] = 'No record found .';
            $data['main_content'] = 'Deliveryreports';
            $this->load->view('page', $data);
        } else {

            $csvData = $this->dbutil->csv_from_result($query);

            $mime_type = 'text/comma-separated-values';

            header('Content-Type: ' . $mime_type);

            header('Expires: ' . gmdate('D, d M Y H:i(worry)') . ' GMT');

            header('Content-Disposition: attachment; filename="' . 'Report' . '"');

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Pragma: public');

            echo $csvData;
            exit();
        }
    }
	
	public function OrderDetailreports($from,$to)
	{
		
		
		$this->load->dbutil();
		
		$query = $this->db->query("SELECT orders.UserID,
					orders.BillingFirstName,
					orders.BillingLastName,
					orders.BillingTelephone,
					orders.Billingemail,
					orders.BillingCompanyName,
					FROM_UNIXTIME(orders.OrderDate,'%d/%m/%Y'),
					orderdetails.ProductName,
					orderdetails.Quantity,
					orderdetails.Price ,
					orderdetails.ProductTotal,
					orderdetails.OrderNumber
					FROM orderdetails INNER JOIN orders on orderdetails.OrderNumber=orders.OrderNumber 
					where (DATE(FROM_UNIXTIME(OrderDate)) BETWEEN '".$from."' AND '".$to.' 23:59:59'."') 
					AND   (OrderStatus = '7')
					AND   (Domain = 'AA')
					AND   (OrderTotal != '0')
					AND   (PaymentMethods = 'specialOrders')
                    GROUP BY orderdetails.SerialNumber Order By orderdetails.OrderNumber asc");
					
					
					if ($query->result() == NULL) {

					$data['error'] = 'No record found .';
					$data['main_content'] = 'OrderDetailreports';
					$this->load->view('page', $data);
				
				} else {
					
					
					$csvData = $this->dbutil->csv_from_result($query);
					
					$filename="OrderDetailreport.csv";
					$mime_type = 'text/comma-separated-values';
					header('Content-Type: ' . $mime_type);
					header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
					header('Content-Disposition: attachment; filename="' . $filename . '"');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
				   
					echo $csvData;
					
					exit();
				
				}
	}
	
	
	 public function DeliveryOrders($from,$to)
	 {
		
		 $this->load->dbutil();
		  $query = $this->db->query("SELECT 
					orders.UserID,
					orders.BillingFirstName,
					orders.BillingLastName,
					orders.BillingTelephone,
					orders.Billingemail,
					orders.BillingCompanyName,
					FROM_UNIXTIME(orders.OrderDate,'%d/%m/%Y'),
					orders.OrderShippingAmount,
					orders.OrderNumber
					FROM orders
					WHERE (OrderDate BETWEEN '" . strtotime($from) . "' AND '" . strtotime($to.' 23:59:59') . "') 
					AND   (OrderStatus = '7')
					AND   (Domain = 'AA')
					AND   (OrderTotal != '0')
					ORDER BY OrderDate desc");
	 
	 	
		 if ($query->result() == NULL) {

            $data['error'] = 'No record found .';
            $data['main_content'] = 'Deliveryreports';
            $this->load->view('page', $data);
        
		} else {
			
			
			$csvData = $this->dbutil->csv_from_result($query);
			
			$filename="DeliveryReport.csv";
            $mime_type = 'text/comma-separated-values';
            header('Content-Type: ' . $mime_type);
            header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
           
		    echo $csvData;
			
            exit();
		
		}
	 }
	 
	 
	                  // -------------------------------------------------------------------------------------------------------
	


public function vat_export_sales($from,$to) 
	{
	
		
		$this->load->dbutil();
		
		$query = $this->db->query("SELECT distinct orders.OrderNumber,
		            FROM_UNIXTIME(orders.OrderDate,'%d/%m/%Y') as Date,
					round((orders.OrderTotal +orders.OrderShippingAmount)/1.2,2) as OrderTotal,
					orders.BillingFirstName,
					orders.BillingLastName,
					orders.BillingPostCode,
					orders.BillingCountry,
					orders.DeliveryPostCode,
					orders.DeliveryCountry,orders.CustomOrder
					FROM orders 
					where (DATE(FROM_UNIXTIME(OrderDate)) BETWEEN '".$from."' AND '".$to.' 23:59:59'."') 
					AND   (Vat_exempt = 'yes')
					Order By orders.OrderNumber asc");
					
					
					if ($query->result() == NULL) {

					$data['error'] = 'No record found .';
					$data['main_content'] = 'Vat_order_Report';
					$this->load->view('page', $data);
				
				} else {
					
					
					$csvData = $this->dbutil->csv_from_result($query);
					
					$filename="Vat_order_Report.csv";
					$mime_type = 'text/comma-separated-values';
					header('Content-Type: ' . $mime_type);
					header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
					header('Content-Disposition: attachment; filename="' . $filename . '"');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
				   
					echo $csvData;
					
					exit();
				
				}
	}
	
	
	
public function all_export_sales($from,$to) 
	{
	
		
		$this->load->dbutil();
		
		$query = $this->db->query("SELECT distinct orders.OrderNumber,
		            FROM_UNIXTIME(orders.OrderDate,'%d/%m/%Y') as Date,
					if( orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2),2), round((orders.OrderTotal + orders.OrderShippingAmount),2) ) AS OrderTotal,
					orders.BillingFirstName,
					orders.BillingLastName,
					orders.BillingPostCode,
					orders.BillingCountry,
					orders.DeliveryPostCode,
					orders.DeliveryCountry,orders.CustomOrder
					FROM orders 
					where (DATE(FROM_UNIXTIME(OrderDate)) BETWEEN '".$from."' AND '".$to.' 23:59:59'."') 
					AND ((orders.BillingCountry NOT LIKE 'United Kingdom' AND orders.BillingCountry NOT LIKE 'UK' AND orders.BillingCountry NOT LIKE '') OR (orders.DeliveryCountry NOT LIKE 'United Kingdom' AND orders.DeliveryCountry NOT LIKE 'UK' AND orders.DeliveryCountry NOT LIKE '') OR orders.DeliveryPostcode LIKE 'bt%' )
					Order By orders.OrderNumber asc");
					
					
					if ($query->result() == NULL) {

					$data['error'] = 'No record found .';
					$data['main_content'] = 'export_order_report';
					$this->load->view('page', $data);
				
				} else {
					
					
					$csvData = $this->dbutil->csv_from_result($query);
					
					$filename="all_export_sales.csv";
					$mime_type = 'text/comma-separated-values';
					header('Content-Type: ' . $mime_type);
					header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
					header('Content-Disposition: attachment; filename="' . $filename . '"');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
				   
					echo $csvData;
					
					exit();
				
				}
	}
	

	
	
	
	
	
	
	
	function get_currecy_options(){
			$sql = $this->db->query("select * from exchange_rates where status LIKE 'active' Order by ID ASC ");
			$sql = $sql->result();
			return $sql;     
	}
	
	
	
	function currecy_converter($price,$currency){
		
			 $rate = $this->get_exchange_rate($currency);
		      if(isset($rate) and  $rate >0 ){ 
			     $price = $price* $rate;
			 }
			// if($vat=='yes' and vatoption=='Inc'){ $price = $price*1.2; }
			 return number_format(round($price,2),2,'.','');  
	}
	
	
	function get_exchange_rate($code){
		
			 $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '".$code."'");
			 $sql = $sql->row_array();
			return $sql['rate'];
	}
	
	function get_currecy_symbol($code){
			 $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$code."'");
			 $sql = $sql->row_array();
			 return $sql['symbol'];
	}
	
	
/*============================================ Ali Fayyaz =================================================================================================*/
	
	function getSampleData($user_id){
		
			 $Sample_data_query = $this->db->query("SELECT OrderDate,DeliveryCountry FROM orders  WHERE paymentmethods = 'Sample Order' and orders.UserID = ".$user_id." 
order by OrderID asc limit 1")->row();
			 if(count($Sample_data_query) > 0){
				 return $Sample_data_query;
			 }else{
				 return 'empty';
			 }
	}
	
	function get1stOrderData($user_id){
		
			 $first_orderdata_query = $this->db->query("SELECT OrderDate,if( orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2)*exchange_rate,2), round((orders.OrderTotal + orders.OrderShippingAmount)*exchange_rate,2) ) AS OrderTotal FROM orders  WHERE paymentmethods != 'Sample Order' and orders.UserID = ".$user_id." 
order by OrderID asc limit 1")->row();

			 if(count($first_orderdata_query) > 0){
				 return $first_orderdata_query;
			 }else{
				 return 'empty';
			 }
	}
	
	function getTotalOrdersValue($user_id){
		
		$query_vatExempt = $this->db->query("SELECT sum(round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2)*exchange_rate,2)) AS OrderTotal FROM orders  WHERE orders.UserID = ".$user_id." and vat_exempt = 'yes'")->row();
		
		$query_vatInclude = $this->db->query("SELECT sum(round(((orders.OrderTotal + orders.OrderShippingAmount))*exchange_rate,2)) AS OrderTotal FROM orders  WHERE orders.UserID = ".$user_id." and vat_exempt = 'no'")->row();
		
		return number_format($query_vatExempt->OrderTotal +$query_vatInclude->OrderTotal,2,'.','');
	}
	
	function getTotalOrdersCount($user_id){
		
		$query_countOrder = $this->db->query("SELECT count(*) AS OrderCount FROM orders  WHERE orders.UserID = ".$user_id." and paymentmethods != 'Sample Order'")->row();
		
		return $query_countOrder->OrderCount;
	}
	
	function getUserDetail($user_id){
		
		$query_userDetail = $this->db->query("SELECT BillingFirstName, BillingLastName, BillingCompanyName, UserEmail, BillingMobile, BillingFax, BillingAddress1  FROM customers  WHERE UserID = ".$user_id."")->row();
		
		return $query_userDetail;
	}
	
	
	
	public function getReportRecord($params){
	  switch ($params['type']){
          case 1:

              if($params['manufactureId'] !=""){
                  if(strpos($params['manufactureId'],',') >0){
                      $searchParams = explode(',',$params['manufactureId']);
                       foreach ($searchParams as $key=>$param){
                               $final[] ="'".$param."'";
                       }
                      $searchParams = implode(',',$final);
                  }else{
                      $searchParams = "'".$params['manufactureId']."'";
                  }

              }else{
                  if(strpos($params['manufactureId'],',') >0){
                      $searchParams = explode(',',$params['dieId']);
                      foreach ($searchParams as $key=>$param){
                          $final[] ="'".$param."'";
                      }
                      $searchParams = implode(',',$final);
                  }else{
                      $searchParams = "'".$params['dieId']."'";
                  }
              }
             // print_r($searchParams);exit;
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`, `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date/Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`, `o`.`TrackingReferralURL`, `o`.`Registered`, `o`.`OrderComments`, `o`.`ReturnComments`, `o`.`ShippingServiceID`, `o`.`courier_id`, `o`.`ReturnTotal`, `o`.`ProcessedBy`, `o`.`printPicked`, `o`.`StockReport`,`o`.`OpenOrder`, `o`.`manifest_date`, `o`.`Payment`, `o`.`Source`, `o`.`DeliveryStatus`, `o`.`OrderDeliveryCourier`, `o`.`DeliveryTrackingNumber`, `o`.`PaymentMethods`, `o`.`DispatchedDate`, `o`.`DispatchedTime`,`o`.`HowDidYouHearAboutUs`,FROM_UNIXTIME(`o`.`PaymentDate`),Print_Type,Print_Design,Print_Qty,Free,Print_UnitPrice,Print_Total
                                FROM `orders` as `o`
                                inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                WHERE `prd`.`ManufactureID` IN(".$searchParams.")  AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','TrackingReferralURL','Registered','OrderComments','ReturnComments','ShippingServiceID','courier_id','ReturnTotal','ProcessedBy','printPicked','StockReport','OpenOrder','manifest_date','Payment','Source','DeliveryStatus','OrderDeliveryCourier','DeliveryTrackingNumber','PaymentMethods','DispatchedDate','DispatchedTime','HowDidYouHearAboutUs','PaymentDate','Print_Type','Print_Design','Print_Qty','Free','Print_UnitPrice','Print_Total'));
              break;

          case 2:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`, `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date/Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`, `o`.`ShippingServiceID`, `o`.`manifest_date`, `o`.`Payment`, `o`.`Source`, `o`.`DeliveryStatus`, `o`.`OrderDeliveryCourier`, `o`.`DeliveryTrackingNumber`, `o`.`PaymentMethods`, `o`.`DispatchedDate`, `o`.`DispatchedTime`,Print_Type,Print_Design,Print_Qty,Free,Print_UnitPrice,Print_Total
                                FROM `orders` as `o`
                                inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                WHERE (`Printing` LIKE  'Y' OR od.ProductID = 0) AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','ShippingServiceID','manifest_date','Payment','Source','DeliveryStatus','OrderDeliveryCourier','DeliveryTrackingNumber','PaymentMethods','DispatchedDate','DispatchedTime','Print_Type','Print_Design','Print_Qty','Free','Print_UnitPrice','Print_Total'));
              break;

          case 3:
              $query = $this->db->query("SELECT orders.`OrderNumber`,FROM_UNIXTIME(`OrderDate`) as 'Order Placed Date',DAYNAME(FROM_UNIXTIME(`OrderDate`)) as Day, FROM_UNIXTIME(`DispatchedDate`) as 'Dispatch Date',FROM_UNIXTIME(`expectedDispatchDate`) as 'Expected Dispatch Date',shippingservices.ServiceName,orderdetails.`ManufactureID`,orderdetails.`ProductName`,orderdetails.Product_detail,products.ProductBrand,orderdetails.Printing,
                                (select FROM_UNIXTIME(approve_date) from order_attachments_integrated where order_attachments_integrated.Serial=`orderdetails`.SerialNumber order by approve_date desc limit 1) as 'Approval Date',orders.BillingCountry,orders.PaymentMethods 
                                FROM `orders`
                                inner join `orderdetails` on `orders`.`OrderNumber`=	`orderdetails`.`OrderNumber`
                                inner join `products`  On products.ProductID = orderdetails.ProductID
                                inner join shippingservices on shippingservices.ServiceID=	orders.ShippingServiceID
                                WHERE expectedDispatchDate!='' AND expectedDispatchDate!=0 AND OrderStatus = 7 
                                AND Date(FROM_UNIXTIME(DispatchedDate,'%Y-%m-%d')) != Date(FROM_UNIXTIME(expectedDispatchDate,'%Y-%m-%d'))
                                AND `OrderDate` > UNIX_TIMESTAMP('".$params['startDate']."') 
                                AND `OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."') Order by `OrderDate` DESC");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Placed Date','Day','Dispatch Date','Expected Dispatch Date','ServiceName','ManufactureID','ProductName','Product_detail','ProductBrand','Printing'));
              break;

          case 4:
              $query = $this->db->query("SELECT *,FROM_UNIXTIME(`Date`) FROM status_change_log WHERE `OrderStatus_old` = 6 AND `Date` >UNIX_TIMESTAMP('".$params['startDate']."') AND `Date`<UNIX_TIMESTAMP('".$params['endDate']."')");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','OrderStatus_new','OrderStatus_old','Oprator','SALE_ID','Date'));
              break;


          case 5:
              $query = $this->db->query("SELECT *,FROM_UNIXTIME(`Date`) FROM status_change_log WHERE ( `OrderStatus_old` = 55 OR `OrderStatus_old` = 63 OR `OrderStatus_old` = 56) and status_change_log.OrderStatus_new =32 AND `Date` >UNIX_TIMESTAMP('".$params['startDate']."') AND `Date`<UNIX_TIMESTAMP('".$params['endDate']."')");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','OrderStatus_new','OrderStatus_old','Oprator','SALE_ID','Date'));
              break;

          case 6:
              $query = $this->db->query("SELECT * FROM `customernotes` 
                                WHERE UNIX_TIMESTAMP(`noteDate`) > UNIX_TIMESTAMP('".$params['startDate']."') 
                                AND UNIX_TIMESTAMP(`noteDate`) <UNIX_TIMESTAMP('".$params['endDate']."')");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('noteID','RefNumber','noteTitle','noteText','noteDate','action_date'));
              break;


          case 7:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date/Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`, `o`.`TrackingReferralURL`, `o`.`Registered`, `o`.`OrderComments`, `o`.`ReturnComments`, `o`.`ShippingServiceID`, `o`.`courier_id`, `o`.`ReturnTotal`, `o`.`ProcessedBy`, `o`.`printPicked`, `o`.`StockReport`,`o`.`OpenOrder`, `o`.`manifest_date`, `o`.`Payment`, `o`.`Source`, `o`.`DeliveryStatus`, `o`.`OrderDeliveryCourier`, `o`.`DeliveryTrackingNumber`, `o`.`PaymentMethods`, `o`.`DispatchedDate`, `o`.`DispatchedTime`, `o`.`HowDidYouHearAboutUs`,FROM_UNIXTIME(`o`.`PaymentDate`)
                                FROM `orders` as `o`
                                inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                WHERE ProductID = 0 AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time', 'ProductName', 'Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','BillingLastName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','TrackingReferralURL','Registered','OrderComments','ReturnComments','ShippingServiceID','courier_id','ReturnTotal','ProcessedBy','printPicked','StockReport','OpenOrder','manifest_date','Payment','Source','DeliveryStatus','OrderDeliveryCourier','DeliveryTrackingNumber','PaymentMethods','DispatchedDate','DispatchedTime','HowDidYouHearAboutUs','PaymentDate'));
              break;


          case 8:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`, `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date/Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`, `o`.`TrackingReferralURL`, `o`.`Registered`, `o`.`OrderComments`, `o`.`ReturnComments`, `o`.`ShippingServiceID`, `o`.`courier_id`, `o`.`ReturnTotal`, `o`.`ProcessedBy`, `o`.`printPicked`, `o`.`StockReport`,`o`.`OpenOrder`, `o`.`manifest_date`, `o`.`Payment`, `o`.`Source`, `o`.`DeliveryStatus`, `o`.`OrderDeliveryCourier`, `o`.`DeliveryTrackingNumber`, `o`.`PaymentMethods`, `o`.`DispatchedDate`, `o`.`DispatchedTime`, `o`.`HowDidYouHearAboutUs`,FROM_UNIXTIME(`o`.`PaymentDate`)
                                FROM `orders` as `o`
                                inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                WHERE `prd`.`ProductBrand` LIKE '".$params['brand']."' AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time', 'ProductName', 'Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','BillingLastName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','TrackingReferralURL','Registered','OrderComments','ReturnComments','ShippingServiceID','courier_id','ReturnTotal','ProcessedBy','printPicked','StockReport','OpenOrder','manifest_date','Payment','Source','DeliveryStatus','OrderDeliveryCourier','DeliveryTrackingNumber','PaymentMethods','DispatchedDate','DispatchedTime','HowDidYouHearAboutUs','PaymentDate'));
              break;


          case 9:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `od`.`ManufactureID`, `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date/Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`,`o`.`PaymentMethods`, FROM_UNIXTIME(`o`.`PaymentDate`),prd.*
                                FROM `orders` as `o`
                                inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                inner join `roll_print_basket` as `prd` On `od`.`Prl_id`=`prd`.`SerialNumber`
                                inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                WHERE `od`.`ManufactureID` LIKE 'PRL1' AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");
              //echo '<pre>';
              //print_r($query->result_array());exit;
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time', 'ProductName', 'Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','BillingLastName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','PaymentMethods','PaymentDate'));
              break;

           case 10:
              $query = $this->db->query("SELECT order_attachments_integrated.OrderNumber as OrderNumber, order_attachments_integrated.diecode as ManufactureID, CONCAT('PJ','',`job_no`) as 'PrintJob#',customers.UserName as OperatorName, machine_log.`Date` as 'ProductionDate',qty as Quantity FROM `machine_log` INNER JOIN customers ON customers.UserID=machine_log.operator INNER JOIN order_attachments_integrated ON order_attachments_integrated.ID=machine_log.job_no WHERE `machine` LIKE 'xerox' AND UNIX_TIMESTAMP(machine_log.`Date`) > UNIX_TIMESTAMP('".$params['startDate']."') AND UNIX_TIMESTAMP(machine_log.`Date`) < UNIX_TIMESTAMP('".$params['endDate']."')");
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber', 'ManufactureID', 'PrintJob','OperatorName', 'ProductionDate','Quantity'));
              break;



          case 11:
              $query = $this->db->query("SELECT `log`.ID,`log`.`operator` AS OperatorID, `cs`.`username` AS Operator,FROM_UNIXTIME( `od`.`Free` ) AS 'Stock Order Date/Time', FROM_UNIXTIME(`log`.`date` ) AS 'Production Date/Time', o.OrderNumber, FROM_UNIXTIME( o.OrderDate ) AS 'Order Date/Time', `prd`.`ManufactureID` ,`od`.`ProductName` , `od`.`Quantity` , `od`.`Price` AS 'Unit Price', `od`.`ProductTotal` , `o`.`OrderTotal` , StatusTitle AS 'Order Status',`o`.`PaymentMethods`,`log`.machine
                                         FROM `operator_production_log` AS `log` INNER JOIN `orderdetails` AS `od` ON `log`.`serial_no` = `od`.`SerialNumber`
                                         INNER JOIN `orders` AS `o` ON `log`.`order_no` = `o`.`OrderNumber` INNER JOIN `products` AS `prd` ON `od`.`ProductID` = `prd`.`ProductID`
                                         INNER JOIN `customers` AS `cs` ON `log`.`operator` = `cs`.`USERID`
                                         INNER JOIN `dropshipstatusmanager` ON `dropshipstatusmanager`.`StatusID` = `o`.`OrderStatus`
                                         WHERE `log`.`date` > UNIX_TIMESTAMP('".$params['startDate']."')
                                         AND `log`.`date` < UNIX_TIMESTAMP('".$params['endDate']."') AND `log`.order_no NOT LIKE 'StockLine'
                                         ORDER BY `log`.`date` ASC");

              return array('records'=>$query->result_array(),'header'=>array('ID','OperatorID','Operator','Stock Order Date/Time','Production Date/Time','OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity','Unit Price','ProductTotal','OrderTotal','Order Status','PaymentMethods','machine'));
              break;


          case 12:
              $query = $this->db->query("SELECT `log`.`operator` AS OperatorID, `cs`.`username` AS Operator, FROM_UNIXTIME( `log`.`date` ) AS 'Production Date/Time', log.order_no, 
                                         FROM_UNIXTIME( bs.time ) AS 'Order Date/Time', `bs`.`diecode` as 'ManufactureID' , `log`.`qty` AS 'Sheets Pack', `bs`.`pack` AS 'Total Packs',
                                         (Select ProductCategoryName from products WHERE ManufactureID = `bs`.`diecode`)  as 'Product Name',`log`.machine
                                         FROM `operator_production_log` AS `log`
                                         INNER JOIN `stock` AS `bs` ON `log`.`serial_no` = `bs`.`ID`
                                         INNER JOIN `customers` AS `cs` ON `log`.`operator` = `cs`.`USERID`
                                         WHERE `log`.`date` > UNIX_TIMESTAMP('".$params['startDate']."')
                                         AND `log`.`date` < UNIX_TIMESTAMP('".$params['endDate']."')  AND log.order_no LIKE 'StockLine'
                                         ORDER BY `log`.`date`ASC");

              return array('records'=>$query->result_array(),'header'=>array('OperatorID','Operator','Production Date/Time','order_no','Order Date/Time','ManufactureID','Sheets Pack','Total Packs','Product Name','machine'));
              break;


          case 13:
              $query = $this->db->query("select cast( QuotationNumber as char(30) ) as refno,FROM_UNIXTIME(QuotationDate) as QuotationDate,FROM_UNIXTIME(CallbackDate) as CallbackDate, 
                                         cast( BillingPostcode as char(30) ) as postcode,cast( DeliveryCountry as char(30) ) as country,currency,cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
                                         cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID,cast( Billingtelephone as char(30) ) as Billingtelephone, 
                                         cast( Billingemail as char(30) ) as Billingemail,cast( StatusTitle  as char(30) ) as QuotationStatus,cast( callback_status as char(30) ) as callback_status, 
                                         cast( vat_exempt as char(30) ) as vat_exempt,cast( exchange_rate as char(30) ) as exchange_rate,cast( QuotationTotal as char(30) ) as total,callback_status,
                                         cast( QuotationNumber as char(30) ) as reference
                                         from quotations 
                                         inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`QuotationStatus`
                                         WHERE `CallbackDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `CallbackDate`<UNIX_TIMESTAMP('".$params['endDate']."')  
                                         Order by `CallbackDate` DESC ");

              return array('records'=>$query->result_array(),'header'=>array('refno','QuotationDate','CallbackDate','postcode','country','currency','Name','OperatorID','Billingtelephone','Billingemail','QuotationStatus','callback_status','vat_exempt','exchange_rate','total,callback_status','reference'));
              break;

          case 14:
              $query = $this->db->query("select orders.OrderNumber,FROM_UNIXTIME(OrderDate) as OrderDate,FROM_UNIXTIME(CallbackDate) as CallBackDate,cast( BillingPostcode as char(30) ) as postcode,cast( DeliveryCountry as char(30) ) as country,currency, 
                                         cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID, 
                                         cast( Billingtelephone as char(30) ) as Billingtelephone,cast( Billingemail as char(30) ) as Billingemail,cast( prevOrder as char(30) ) as prevOrder,cast( StatusTitle  as char(30) ) as status, 
                                         cast( callback_status as char(30) ) as callback_status,cast( vat_exempt as char(30) ) as vat_exempt,cast( exchange_rate as char(30) ) as exchange_rate,cast( OrderTotal as char(30) ) as total,cast( PaymentMethods as char(30) ) as payment,callback_status
                                         from orders 
                                         inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`OrderStatus`
                                         WHERE `CallbackDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `CallbackDate`<UNIX_TIMESTAMP('".$params['endDate']."')  
                                         Order by `CallbackDate` DESC ");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','OrderDate','CallBackDate','postcode','country','currency','Name','OperatorID','Billingtelephone','Billingemail','prevOrder','status','callback_status','vat_exempt','exchange_rate','total','payment','callback_status'));
              break;

          case 15:
              $query = $this->db->query("SELECT o.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status',  `o`.`Source`,qt.QuotationNumber AS QuotationNumber,FROM_UNIXTIME(qt.QuotationDate) as 'Quotation Date/Time'
                                        FROM `orders` as `o`
                                        inner join `quotation_to_order`  as `qod` On `o`.`OrderNumber`=`qod`.`OrderNumber`
                                        inner join `quotations`  as `qt` On `qt`.`QuotationNumber`=`qod`.`QuotationNumber`
                                        inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                        WHERE `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','Source','QuotationNumber','Quotation Date/Time'));
              break;

          case 16:
              $query = $this->db->query("SELECT `OrderNumber`,FROM_UNIXTIME(OrderDate) as 'Order Date/Time',`PaymentMethods`,`OrderTotal`,
                                        `BillingFirstName`,`BillingLastName`,`BillingCompanyName`,`BillingAddress1`,`BillingAddress2`,`BillingTownCity`,`BillingCountyState`,`BillingPostcode`,`BillingCountry`,`DeliveryCountry`,`Billingtelephone`,`BillingMobile`,`Billingemail`,`currency`,`exchange_rate`,vat_exempt, StatusTitle as 'Order Status',`DeliveryPostcode`
                                        FROM `orders` 
                                        inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`OrderStatus`
                                        WHERE
                                        ((BillingCountry NOT LIKE 'United Kingdom' AND BillingCountry NOT LIKE 'UK' AND BillingCountry NOT LIKE '') OR (DeliveryCountry NOT LIKE 'United Kingdom' AND DeliveryCountry NOT LIKE 'UK' AND DeliveryCountry NOT LIKE '') OR DeliveryPostcode LIKE 'bt%' ) AND
                                        `OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `OrderDate` DESC");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','PaymentMethods','OrderTotal','BillingFirstName','BillingLastName','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','DeliveryCountry','Billingtelephone','BillingMobile','Billingemail','currency','exchange_rate','at_exempt','Order Status','DeliveryPostcode'));
              break;

          case 17:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`, `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date/Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`, `o`.`TrackingReferralURL`, `o`.`Registered`, `o`.`OrderComments`, `o`.`ReturnComments`, `o`.`ShippingServiceID`, `o`.`courier_id`, `o`.`ReturnTotal`, `o`.`ProcessedBy`, `o`.`printPicked`, `o`.`StockReport`,`o`.`OpenOrder`, `o`.`manifest_date`, `o`.`Payment`, `o`.`Source`, `o`.`DeliveryStatus`, `o`.`OrderDeliveryCourier`, `o`.`DeliveryTrackingNumber`, `o`.`PaymentMethods`, `o`.`DispatchedDate`, `o`.`DispatchedTime`, `o`.`HowDidYouHearAboutUs`,FROM_UNIXTIME(`o`.`PaymentDate`),Print_Type,Print_Design,Print_Qty,Free,Print_UnitPrice,Print_Total,ProductBrand,`o`.`exchange_rate`,`o`.`currency`
                                        FROM `orders` as `o`
                                        inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                        inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                        inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                        WHERE  ((o.BillingCountry NOT LIKE 'United Kingdom' AND o.BillingCountry NOT LIKE 'UK' AND o.BillingCountry NOT LIKE '') OR (o.DeliveryCountry NOT LIKE 'United Kingdom' AND o.DeliveryCountry NOT LIKE 'UK' AND o.DeliveryCountry NOT LIKE '') OR o.DeliveryPostcode LIKE 'bt%' ) AND
                                        `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."') AND `vat_exempt` LIKE 'yes'  Order by `o`.`OrderDate` DESC");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','BillingLastName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','TrackingReferralURL','Registered','OrderComments','ReturnComments','ShippingServiceID','courier_id','ReturnTotal','ProcessedBy','printPicked','StockReport','OpenOrder','manifest_date','Payment','Source','DeliveryStatus','OrderDeliveryCourier','DeliveryTrackingNumber','PaymentMethods','DispatchedDate','DispatchedTime','HowDidYouHearAboutUs','PaymentDate','Print_Type','Print_Design','Print_Qty','Free','Print_UnitPrice','Print_Total','ProductBrand','Exchange_rate','currency'));
              break;


          case 18:
              $query = $this->db->query("SELECT `OrderNumber`,FROM_UNIXTIME(OrderDate) as 'Order Date/Time',`PaymentMethods`,`OrderTotal`,
                                        `BillingFirstName`,`BillingLastName`,`BillingCompanyName`,`BillingAddress1`,`BillingAddress2`,`BillingTownCity`,`BillingCountyState`,`BillingPostcode`,`BillingCountry`,`Billingtelephone`,`BillingMobile`,`Billingemail`,`currency`,`exchange_rate`
                                        FROM `orders` WHERE (currency LIKE 'USD' OR  currency LIKE 'EUR') AND
                                        `OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','PaymentMethods','OrderTotal','BillingFirstName','BillingLastName','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingemail','currency','exchange_rate'));
              break;


          case 19:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`,`od`.`ProductName`, `od`.`Quantity`
                                        FROM `orders` as `o`
                                        inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                        inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                        inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                        WHERE `prd`.`ProductBrand` LIKE 'A4 Labels' AND `prd`.`EuroID`='' AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity'));
              break;


          case 20:
              $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`,`od`.`ProductName`, `od`.`Quantity`
                                        FROM `orders` as `o`
                                        inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                        inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                        inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                        WHERE `prd`.`ProductBrand` LIKE 'A4 Labels' AND `prd`.`EuroID` !='' AND `o`.`OrderDate` >UNIX_TIMESTAMP('".$params['startDate']."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$params['endDate']."')  Order by `o`.`OrderDate` DESC");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity'));
              break;
          case 21:
              $query = $this->db->query("SELECT order_attachments_integrated.OrderNumber as OrderNumber, order_attachments_integrated.diecode as ManufactureID, CONCAT('PJ','', order_attachments_integrated.ID) as 'PrintJob#',customers.UserName as OperatorName, DATE(machine_log.`Date`) as 'ProductionDate',qty as rolls,labels as labels FROM `machine_log` 
                                          INNER JOIN customers ON customers.UserID=machine_log.operator INNER JOIN order_attachments_integrated ON order_attachments_integrated.Serial=machine_log.job_no WHERE `machine` LIKE 'epson' AND UNIX_TIMESTAMP(machine_log.`Date`) > UNIX_TIMESTAMP('".$params['startDate']."' ) AND UNIX_TIMESTAMP(machine_log.`Date`) < UNIX_TIMESTAMP( '".$params['endDate']."' ) GROUP BY order_attachments_integrated.ID ");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber', 'ManufactureID', 'PrintJob','OperatorName','ProductionDate','rolls','labels' ));
              break;
          default:
             return  'Sorry We Do Not Have This Report Right Now...';

      }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
