<?php
class Reporting_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		  //error_reporting(-1);

        //ini_set('display_errors', 1);
	}

	function search_records($courier,$date, $shippingServices){
	   $courier = $courier;
	   $date = $date;
	   $shippingServices = $shippingServices;

	   if( (isset($courier) && $courier != '') && (isset($date) && $date != '') )
	   {
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

				if($shippingServices == 'all'){

				}else if($shippingServices != ''){

					$where.= " AND ShippingServiceID = '".$shippingServices."' ";
				}
				
			   $qry = "SELECT COUNT(*) as TotalOrders, SUM(OrderTotal+OrderShippingAmount) as TotalOrderValues, sum(case when OrderDeliveryCourier = 'Parcelforce' then 1 else 0 end) as FedexTotal, sum(case when OrderDeliveryCourier = 'DPD' then 1 else 0 end) as DPDTotal FROM orders where $where ";
			   $orders = $this->db->query($qry)->result();
			   

			    return array('total'=>$orders[0]->TotalOrders,
	                'TotalOrderValues'=>$orders[0]->TotalOrderValues,
					'FedexTotal'=>$orders[0]->FedexTotal,
					'DPDTotal'=>$orders[0]->DPDTotal,
				);
		}

	 }	

	function getShipping()
	{
		// $query = $this->db->get_where('shippingservices', array('Active' => 'Y'));
		$query = $this->db->get('shippingservices');
		return $query->result();
	}
		function getUserDetail($user_id){
		
		$query_userDetail = $this->db->query("SELECT BillingFirstName, BillingLastName, BillingCompanyName, UserEmail, BillingMobile, BillingFax, BillingAddress1  FROM customers  WHERE UserID = ".$user_id."")->row();
		
		return $query_userDetail;
	}
	
	 //-----------------------------------------**********************************--------------------------------------
	
	function getcountries(){
	  $query = $this->db->get('shippingcountries');
	  return $query->result();
	}
	
	public function getReportRecord(){
	   if(isset($_POST['reservation']) && $_POST['reservation']!=""){ 
	    $date = $this->input->post('reservation');
	    $date1     = explode('-',$date);
	    $startdate = explode('/',$date1[0]);
	    $enddate   = explode('/',$date1[1]);
	    $From = trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00';
	    $To   = trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59';
	   }
	   	
	  switch ($_POST['report-form']){
	   case 1:return $this->general_sales_report($From,$To);       break;
	   case 2:return $this->expected_despatch_report($From,$To);   break;
	   case 3:return $this->order_status_report($From,$To);        break;
	   case 4:return $this->movedto_production_report($From,$To);  break;
	   case 5:return $this->canon_machine_report($From,$To);       break;
	   case 6:return $this->quotation_callback_report($From,$To);  break;
	   case 7:return $this->quotationto_order_report($From,$To);   break;
	   case 8:return $this->weekly_volume_report();                break;
	   case 9:return $this->weekly_value_report();                 break;
       case 11:return $this->machine_production_report($From,$To); break;
       case 12:return $this->french_vat_report($From,$To);         break;
       case 14:return $this->quotation_report($From,$To);          break;
       case 15:return $this->export_order_report($From,$To);       break;
       case 16:return $this->hp_indigo_report($From,$To);          break;
	  
	  }
	}
	
		//-----------------------------------------**********************************--------------------------------------
function general_sales_report($From,$To){
		$condition = "1=1";
		
		if(isset($_POST['Sheet-form']) && $_POST['Sheet-form']=="plain"){
		 $condition.= " AND od.Printing NOT LIKE 'Y'";
		}else if(isset($_POST['Sheet-form']) && $_POST['Sheet-form']=="printed"){
		 $condition.= " AND od.Printing LIKE 'Y'";
		}
		
		if(isset($_POST['brand-form']) && $_POST['brand-form']!="all"){
		 $condition.= " AND prd.ProductBrand LIKE '".$_POST['brand-form']."'";
		}
		
		if(isset($_POST['product-form']) && $_POST['product-form']=="diecode"){
		 $condition.= " AND od.ManufactureID LIKE '".$_POST['manufacturid']."%'";
		}else if(isset($_POST['product-form']) && $_POST['product-form']=="material"){
		 $condition.= " AND od.ManufactureID LIKE '%".$_POST['manufacturid']."%'";
		}
		
		if(isset($_POST['country-form']) && $_POST['country-form']!="all"){
		 $condition.= " AND `o`.`DeliveryCountry` LIKE '".$_POST['country-form']."'";
		}
		
		$condition.= " AND `order_payment_log`.`time` >UNIX_TIMESTAMP('".$From."') AND `order_payment_log`.`time` < UNIX_TIMESTAMP('".$To."')";
		
	 
	  $query = $this->db->query("SELECT od.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `prd`.`ManufactureID`, `od`.`ProductName`, `od`.`Quantity`, `od`.`Price` as 'Unit Price', `od`.`ProductTotal`, `o`.`BillingTitle`, `o`.`BillingFirstName`, `o`.`BillingLastName`, FROM_UNIXTIME(`o`.`OrderDate`) as 'Order Date_Time',  `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status', `o`.`PurchaseOrderNumber`,  `o`.`BillingCompanyName`, `o`.`BillingAddress1`, `o`.`BillingAddress2`, `o`.`BillingTownCity`, `o`.`BillingCountyState`, `o`.`BillingPostcode`, `o`.`BillingCountry`, `o`.`Billingtelephone`, `o`.`BillingMobile`, `o`.`Billingfax`, `o`.`Billingemail`, `o`.`BillingResCom`, `o`.`DeliveryTitle`, `o`.`DeliveryFirstName`, `o`.`DeliveryLastName`, `o`.`DeliveryCompanyName`,`o`.`DeliveryAddress1`, `o`.`DeliveryAddress2`, `o`.`DeliveryTownCity`, `o`.`DeliveryCountyState`, `o`.`DeliveryPostcode`, `o`.`DeliveryCountry`, `o`.`Deliverytelephone`, `o`.`DeliveryMobile`, `o`.`Deliveryfax`, `o`.`Deliveryemail`, `o`.`DeliveryResCom`, `o`.`OrderTotalWeight`, `o`.`TrackingIP`, `o`.`TrackingReferralURL`, `o`.`Registered`, `o`.`OrderComments`, `o`.`ReturnComments`, `o`.`ShippingServiceID`, `o`.`courier_id`, `o`.`ReturnTotal`, `o`.`ProcessedBy`, `o`.`printPicked`, `o`.`StockReport`,`o`.`OpenOrder`, `o`.`manifest_date`, `o`.`Payment`, `o`.`Source`, `o`.`DeliveryStatus`, `o`.`OrderDeliveryCourier`, `o`.`DeliveryTrackingNumber`, `o`.`PaymentMethods`, `o`.`DispatchedDate`, `o`.`DispatchedTime`,`o`.`HowDidYouHearAboutUs`,FROM_UNIXTIME(`order_payment_log`.`time`) as PaymentDate,Print_Type,Print_Design,Print_Qty,Free,Print_UnitPrice,Print_Total,`od`.`labels`,prd.ProductBrand
                                FROM `orders` as `o`
                                inner join `orderdetails` as `od` on `o`.`OrderNumber`=	`od`.`OrderNumber`
                                inner join `products` as `prd` On `od`.`ProductID`=`prd`.`ProductID`
                                inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                inner join (SELECT time, OrderNumber FROM order_payment_log where situation = 'taken' GROUP BY OrderNumber) order_payment_log ON o.OrderNumber = order_payment_log.OrderNumber 
                                WHERE $condition ");
		
   
         
								 return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','ManufactureID','ProductName','Quantity','Unit Price','ProductTotal','BillingTitle','BillingFirstName','BillingLastName','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','PurchaseOrderNumber','BillingCompanyName','BillingAddress1','BillingAddress2','BillingTownCity','BillingCountyState','BillingPostcode','BillingCountry','Billingtelephone','BillingMobile','Billingfax','Billingemail','BillingResCom','DeliveryTitle','DeliveryFirstName','DeliveryLastName','DeliveryCompanyName','DeliveryAddress1','DeliveryAddress2','DeliveryTownCity','DeliveryCountyState','DeliveryPostcode','DeliveryCountry','Deliverytelephone','DeliveryMobile','Deliveryfax','Deliveryemail','DeliveryResCom','OrderTotalWeight','TrackingIP','TrackingReferralURL','Registered','OrderComments','ReturnComments','ShippingServiceID','courier_id','ReturnTotal','ProcessedBy','printPicked','StockReport','OpenOrder','manifest_date','Payment','Source','DeliveryStatus','OrderDeliveryCourier','DeliveryTrackingNumber','PaymentMethods','DispatchedDate','DispatchedTime','HowDidYouHearAboutUs','PaymentDate','Print_Type','Print_Design','Print_Qty','Free','Print_UnitPrice','Print_Total','is_custom','lpr','lps','labels','Brand'),'filename'=>'Sales_Report_'.date('d-M-Y').'.csv');
	 
	 }
    //-----------------------------------------**********************************--------------------------------------
    function expected_despatch_report($From,$To){
	
	$condition = " AND `orders`.`OrderDate` > UNIX_TIMESTAMP('".$From."') AND `orders`.`OrderDate` < UNIX_TIMESTAMP('".$To."')";
	
		
	$query = $this->db->query("SELECT orders.`OrderNumber`,FROM_UNIXTIME(`OrderDate`) as 'Order Placed Date',DAYNAME(FROM_UNIXTIME(`OrderDate`)) as Day, FROM_UNIXTIME(`DispatchedDate`) as 'Dispatch Date',FROM_UNIXTIME(`expectedDispatchDate`) as 'Expected Dispatch Date',shippingservices.ServiceName,orderdetails.`ManufactureID`,orderdetails.`ProductName`,orderdetails.Product_detail,products.ProductBrand,orderdetails.Printing,
                                (select FROM_UNIXTIME(approve_date) from order_attachments_integrated where order_attachments_integrated.Serial=`orderdetails`.SerialNumber order by approve_date desc limit 1) as 'Approval Date',orders.BillingCountry,orders.PaymentMethods 
                                FROM `orders`
                                inner join `orderdetails` on `orders`.`OrderNumber`=	`orderdetails`.`OrderNumber`
                                inner join `products`  On products.ProductID = orderdetails.ProductID
                                inner join shippingservices on shippingservices.ServiceID=	orders.ShippingServiceID
                                WHERE expectedDispatchDate!='' AND expectedDispatchDate!=0 AND OrderStatus = 7 
                                AND Date(FROM_UNIXTIME(DispatchedDate,'%Y-%m-%d')) != Date(FROM_UNIXTIME(expectedDispatchDate,'%Y-%m-%d'))
                                $condition Order by `OrderDate` DESC");
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Placed Date','Day','Dispatch Date','Expected Dispatch Date','ServiceName','ManufactureID','ProductName','Product_detail','ProductBrand','Printing','Artwork Approval','Billing Country','Payment Method'),'filename'=>'Expected_Despatch_Report_'.date('d-M-Y') .'.csv');
            
    }

   //-----------------------------------------**********************************--------------------------------------
    function order_status_report($From,$To){
	   $query = $this->db->query("SELECT *,FROM_UNIXTIME(`Date`) FROM status_change_log WHERE `OrderStatus_old` = 6 AND `Date` > UNIX_TIMESTAMP('".$From."') AND `Date` < UNIX_TIMESTAMP('".$To."')");
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','OrderStatus_new','OrderStatus_old','Oprator','SALE_ID','Date'),'filename'=>'Order_Status_Log_Report_'.date('d-M-Y') .'.csv');
            
	}
      //-----------------------------------------**********************************--------------------------------------
   function movedto_production_report($From,$To){
	     $query = $this->db->query("SELECT *,FROM_UNIXTIME(`Date`) FROM status_change_log WHERE ( `OrderStatus_old` = 55 OR `OrderStatus_old` = 63 OR `OrderStatus_old` = 56) and status_change_log.OrderStatus_new = 32 AND `Date` > UNIX_TIMESTAMP('".$From."') AND `Date` < UNIX_TIMESTAMP('".$To."')");
              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','OrderStatus_new','OrderStatus_old','Oprator','SALE_ID','Date'),'filename'=>'Moved_to_Production_'.date('d-M-Y') .'.csv');
   
   }
      //-----------------------------------------**********************************--------------------------------------
    function canon_machine_report($From,$To){
	 $query = $this->db->query("SELECT order_attachments_integrated.OrderNumber as OrderNumber, order_attachments_integrated.diecode as ManufactureID, CONCAT('PJ','',`job_no`) as 'PrintJob#',customers.UserName as OperatorName, machine_log.`Date` as 'ProductionDate',qty as Quantity FROM `machine_log` INNER JOIN customers ON customers.UserID=machine_log.operator INNER JOIN order_attachments_integrated ON order_attachments_integrated.ID = machine_log.job_no WHERE `machine` LIKE 'xerox' AND UNIX_TIMESTAMP(machine_log.`Date`) > UNIX_TIMESTAMP('".$From."') AND UNIX_TIMESTAMP(machine_log.`Date`) < UNIX_TIMESTAMP('".$To."')");
	 
	          return array('records'=>$query->result_array(),'header'=>array('OrderNumber', 'ManufactureID', 'PrintJob','OperatorName', 'ProductionDate','Quantity'),'filename'=>'Canon_Machine_Report_'.date('d-M-Y') .'.csv');
	
	}
        //-----------------------------------------**********************************--------------------------------------
     function quotation_callback_report($From,$To){
   $query = $this->db->query("select cast( QuotationNumber as char(30) ) as refno,FROM_UNIXTIME(QuotationDate) as QuotationDate,FROM_UNIXTIME(CallbackDate) as CallbackDate, 
                                         cast( BillingPostcode as char(30) ) as postcode,cast( DeliveryCountry as char(30) ) as country,currency,cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
                                         cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID,cast( Billingtelephone as char(30) ) as Billingtelephone, 
                                         cast( Billingemail as char(30) ) as Billingemail,cast( StatusTitle  as char(30) ) as QuotationStatus,cast( callback_status as char(30) ) as callback_status, 
                                         cast( vat_exempt as char(30) ) as vat_exempt,cast( exchange_rate as char(30) ) as exchange_rate,cast( QuotationTotal as char(30) ) as total,callback_status,
                                         cast( QuotationNumber as char(30) ) as reference,ProcessedBy
                                         from quotations 
                                         inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`QuotationStatus`
                                         WHERE `CallbackDate` > UNIX_TIMESTAMP('".$From."') AND `CallbackDate` < UNIX_TIMESTAMP('".$To."')  
                                         Order by `CallbackDate` DESC ");

              return array('records'=>$query->result_array(),'header'=>array('refno','QuotationDate','CallbackDate','postcode','country','currency','Name','OperatorID','Billingtelephone','Billingemail','QuotationStatus','callback_status','vat_exempt','exchange_rate','total,callback_status','reference','ProcessedBy'),'filename'=>'Quotation_Callback_Report_'.date('d-M-Y') .'.csv');
  
     }
     
	 //-----------------------------------------**********************************--------------------------------------
   function quotationto_order_report($From,$To){
      $query = $this->db->query("SELECT o.OrderNumber, FROM_UNIXTIME(o.OrderDate) as 'Order Date/Time', `o`.`OrderShippingAmount`, `o`.`OrderTotal`, StatusTitle as 'Order Status',  `o`.`Source`,qt.QuotationNumber AS QuotationNumber,FROM_UNIXTIME(qt.QuotationDate) as 'Quotation Date/Time',qt.QuotationStatus
                                        FROM `orders` as `o`
                                        inner join `quotation_to_order`  as `qod` On `o`.`OrderNumber`=`qod`.`OrderNumber`
                                        inner join `quotations`  as `qt` On `qt`.`QuotationNumber`=`qod`.`QuotationNumber`
                                        inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`o`.`OrderStatus`
                                        WHERE `o`.`OrderDate` >UNIX_TIMESTAMP('".$From."') AND `o`.`OrderDate`<UNIX_TIMESTAMP('".$To."')  Order by `o`.`OrderDate` DESC");

              return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Order Date/Time','OrderShippingAmount','OrderTotal','Order Status','Source','QuotationNumber','Quotation Date/Time','QuotationStatus'),'filename'=>'Quote_to_Order_Conversion_Report_'.date('d-M-Y') .'.csv');
   
   }
	//-----------------------------------------**********************************--------------------------------------
    
	function  machine_production_report($From,$To){
	   $condition = '';
	    
		$sort = 'ORDER BY `cs`.`username` ASC, `log`.`date` ASC';
	    if(isset($_POST['sortby-form']) && $_POST['sortby-form']=="machine"){
		 $sort = " ORDER BY `log`.machine ASC";
		}	
		
		if(isset($_POST['operator-form']) && $_POST['operator-form']!="all"){
		 $operator = $_POST['operator-form'];
         $condition.= " AND `log`.`operator`= $operator ";
		}
		
	   if(isset($_POST['machine-form']) && $_POST['machine-form']!="all"){
		 $machine = $_POST['machine-form'];
         $condition.= " AND `log`.machine like '".$machine."' ";
		}
		
		if(isset($_POST['orderby-form']) && $_POST['orderby-form']=="wo_stock"){
			$query = "SELECT `cs`.`username` AS Operator, FROM_UNIXTIME(`log`.`date`) AS 'Date_Time', FROM_UNIXTIME(`log`.`date`) AS 'Time',
o.OrderNumber AS OrderNumber, `prd`.`ManufactureID` as 'ManufactureID', 
`od`.`ProductName` as 'ProductName', `od`.`Quantity` as Quantity, `od`.`labels` as 'Labels',StatusTitle AS 'Order_Status', `o`.`PaymentMethods` as 'PaymentMethods', 
`log`.machine FROM `operator_production_log` AS `log`
INNER JOIN `orderdetails` AS `od` ON `log`.`serial_no` = `od`.`SerialNumber`
INNER JOIN `orders` AS `o` ON `log`.`order_no` = `o`.`OrderNumber`
INNER JOIN `products` AS `prd` ON `od`.`ProductID` = `prd`.`ProductID`
INNER JOIN `customers` AS `cs` ON `log`.`operator` = `cs`.`USERID`
INNER JOIN `dropshipstatusmanager` ON `dropshipstatusmanager`.`StatusID` = `o`.`OrderStatus`
WHERE `log`.`date` > UNIX_TIMESTAMP( '".$From."' ) AND `log`.`date` < UNIX_TIMESTAMP( '".$To."' )  AND `log`.order_no NOT LIKE 'StockLine'
$condition $sort";

 $reportname = 'Production_Order_Report_'.date('d-M-Y').'.csv';
		
		}else{
		$query = "SELECT `cs`.`username` AS Operator, FROM_UNIXTIME( `log`.`date`) AS 'Date_Time',FROM_UNIXTIME(`log`.`date`) AS 'Time',
		
log.order_no AS OrderNumber, `bs`.`diecode` as 'ManufactureID', prod.ProductCategoryName as 'ProductName',(`log`.`qty`*`bs`.`pack`) as Quantity, ''  as 'Labels', '' AS 'Order_Status', '' as 'PaymentMethods', `log`.machine 
FROM `operator_production_log` AS `log` 

INNER JOIN `stock` AS `bs` ON `log`.`serial_no` = `bs`.`ID`
INNER JOIN `customers` AS `cs` ON `log`.`operator` = `cs`.`USERID`

INNER JOIN `products` AS `prod` ON `bs`.`diecode` = `prod`.`ManufactureID`

WHERE `log`.`date` > UNIX_TIMESTAMP( '".$From."' ) AND `log`.`date` < UNIX_TIMESTAMP( '".$To."' )  AND log.order_no LIKE 'StockLine'
$condition $sort ";
	 
$reportname = 'Production_Stock_Report_'.date('d-M-Y').'.csv';	 
	    }
		
		
	    $query = $this->db->query($query);
		return array('records'=>$query->result_array(),'header'=>array('UserName','Date/Time','Time','OrderNumber','ManufactureID','ProductName','Quantity','Labels','Status','Payment Method','Machine'),'filename'=>$reportname);
		
	}

  	//-----------------------------------------**********************************--------------------------------------
   function french_vat_report($From,$To){
     $condition= " `order_payment_log`.`time` >UNIX_TIMESTAMP('".$From."') AND `order_payment_log`.`time` < UNIX_TIMESTAMP('".$To."')";
         
         
	   $query = $this->db->query("SELECT orders.`OrderNumber`,`BillingFirstName`,`BillingLastName`,
`BillingAddress1`,`BillingPostcode`,CustomOrder AS VatNumber,FROM_UNIXTIME(OrderDate) as 'Order Date/Time',FROM_UNIXTIME(DispatchedDate) as 'Despatch Date/Time',`currency`,`vat_exempt`,exchange_rate,round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2),2)AS EXVatTotal,(orders.OrderTotal + orders.OrderShippingAmount) AS VatTotal,StatusTitle,(select count(*) as printlines from orderdetails where orderdetails.OrderNumber=orders.OrderNumber AND Printing LIKE 'Y') AS Print,Billingemail,FROM_UNIXTIME(`order_payment_log`.`time`) as PaymentDate

FROM `orders` 
inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`OrderStatus`
inner join (SELECT time, order_payment_log.OrderNumber FROM order_payment_log where situation = 'taken' GROUP BY order_payment_log.OrderNumber) order_payment_log ON orders.OrderNumber = order_payment_log.OrderNumber 
 
WHERE   BillingCountry  LIKE 'France'  AND (`OrderStatus` = 7 or `OrderStatus` = 8 or `OrderStatus` = 32 or `OrderStatus` = 2 or `OrderStatus` = 55 or `OrderStatus` = 33)  AND $condition Order by PaymentDate ASC");
	 
	  return array('records'=>$query->result_array(),'header'=>array('OrderNumber','BillingFirstName','BillingLastName','BillingAddress1','BillingPostcode','VatNumber','Order Date/Time','Despatch Date/Time','Currency','Vat Exempt','Exchange Rate','EXVatTotal','VatTotal','Status','Print','Billingemail','Payment Date'),'filename'=>'France_Vat_Report_'.date('d-M-Y') .'.csv');
  
    }

 	//-----------------------------------------**********************************--------------------------------------
    function quotation_report($From,$To){
        $condition = '1=1';
    
       if(isset($_POST['country-form']) && $_POST['country-form']!="all"){
		 $condition.= " AND (BillingCountry LIKE '".$_POST['country-form']."' || DeliveryCountry LIKE '".$_POST['country-form']."') ";
		}
		
	   $query = $this->db->query("SELECT QuotationNumber, FROM_UNIXTIME(QuotationDate) as 'Quotation Date/Time',QuotationTotal,BillingFirstName,Billingemail,BillingPostcode,BillingCountry,DeliveryCountry,ProcessedBy,StatusTitle
FROM  `quotations` inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`QuotationStatus`
 WHERE $condition AND QuotationDate > UNIX_TIMESTAMP('".$From."') AND QuotationDate < UNIX_TIMESTAMP('".$To."')  Order by QuotationDate DESC");
	 
	  return array('records'=>$query->result_array(),'header'=>array('Quotation Number','Quotation Date/Time','QuotationTotal','Billing FirstName','Billing Email','BillingPostcode','BillingCountry','DeliveryCountry','Processed By','Status'),'filename'=>'quotation_report_'.date('d-M-Y') .'.csv');
  
    }
    
   	//-----------------------------------------**********************************--------------------------------------
    function export_order_report($From,$To){
      
      $condition = "((BillingCountry NOT LIKE 'United Kingdom' AND BillingCountry NOT LIKE 'UK' AND BillingCountry NOT LIKE '') OR (DeliveryCountry NOT LIKE 'United Kingdom' AND DeliveryCountry NOT LIKE 'UK' AND DeliveryCountry NOT LIKE '') OR DeliveryPostcode LIKE 'bt%' )";
      
      if(isset($_POST['country-form']) && $_POST['country-form']!="all"){
		 $condition = " (BillingCountry LIKE '".$_POST['country-form']."' || DeliveryCountry LIKE '".$_POST['country-form']."') ";
		}
		
	   $query = $this->db->query("SELECT `OrderNumber`,`BillingFirstName`,`BillingLastName`,
`BillingAddress1`,`BillingPostcode`,CustomOrder AS VatNumber,FROM_UNIXTIME(OrderDate) as 'Order Date/Time',FROM_UNIXTIME(DispatchedDate) as 'Despatch Date/Time',`currency`,`vat_exempt`,exchange_rate,round(((orders.OrderTotal)/1.2),2)AS EXVatTotal,(orders.OrderTotal + orders.OrderShippingAmount) AS VatTotal,StatusTitle,(select count(*) as printlines from orderdetails where orderdetails.OrderNumber=orders.OrderNumber AND Printing LIKE 'Y') AS Print,Billingemail,BillingCountry,DeliveryCountry,PaymentMethods,BillingCompanyName,BillingAddress2,BillingTownCity,BillingCountyState,Billingtelephone,BillingMobile,DeliveryPostcode
FROM `orders` 
inner join `dropshipstatusmanager` On `dropshipstatusmanager`.`StatusID`=`OrderStatus`
WHERE  $condition AND `OrderDate` > UNIX_TIMESTAMP('".$From."') AND `OrderDate` < UNIX_TIMESTAMP('".$To."') Order by `OrderDate` ASC");
	 
	  return array('records'=>$query->result_array(),'header'=>array('OrderNumber','BillingFirstName','BillingLastName','BillingAddress1','BillingPostcode','VatNumber','Order Date/Time','Despatch Date/Time','Currency','Vat Exempt','Exchange Rate','EXVatTotal','VatTotal','Status','Print','Billingemail','BillingCountry','DeliveryCountry','PaymentMethods','BillingCompanyName','BillingAddress2','BillingTownCity','BillingCountyState','Billingtelephone','BillingMobile','DeliveryPostcode'),'filename'=>'export_order_report_'.date('d-M-Y') .'.csv');
  
    }
 
  	//-----------------------------------------**********************************--------------------------------------
     function hp_indigo_report($From,$To){
     
      $query = $this->db->query("select `od`.`OrderNumber`,`od`.`diecode`,cs.UserName,ml.Date,`od`.`qty`,`od`.`labels` ,(select FinishType from orderdetails where SerialNumber = `od`.`Serial` limit 1)
 FROM `order_attachments_integrated` as `od`
 INNER JOIN `machine_log` AS `ml` ON `ml`.`job_no` = `od`.`Serial`
 INNER JOIN `customers` AS `cs` ON `ml`.`operator` = `cs`.`USERID`
 WHERE `ml`.`machine` = 'epson' AND `ml`.`Date` > '".$From."' AND `ml`.`Date` < '".$To."'  order by `ml`.`Date` asc");
	 
	  return array('records'=>$query->result_array(),'header'=>array('OrderNumber','Diecode','Operator','Date','Quantity','Labels','Finish'),'filename'=>'hpindigo_report_'.date('d-M-Y') .'.csv');
    }
     
    //-----------------------------------------**********************************--------------------------------------
	

	
}

