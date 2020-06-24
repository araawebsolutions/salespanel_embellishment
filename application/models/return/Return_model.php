<?php
class Return_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function fetchtickets($start,$limit){
		$query = "select * from tickets order by ticket_id asc limit $start , $limit "; 
		return $this->db->query($query)->result();
	}
      
	function fetch_top_counter(){
		$from = date('Y-m-d');
		$query1 = $this->db->query("select count(*) as total_open from tickets where ticketStatus!=4")->row_array();
		$open = $query1['total_open'];
	
		$query2 = $this->db->query("select count(*) as total_overdue from tickets where ticketStatus=4")->row_array();
		$overdue= $query2['total_overdue'];
        
		$total_artworks =  $this->fetchtickets(0,100);
		$total_artworks = count($total_artworks);
        
		return array('open'=>$open,'overdue'=>$overdue,'total_tickets'=>$total_artworks);
	}
    
    
	function fetch_tickets_order($ticket_id){
		$query = "select td.*,o.currency,o.OrderNumber,o.BillingFirstName,o.BillingLastName,o.BillingCountry from 	ticket_details as td
		inner join orders as o on td.orderNumber=o.orderNumber
		where ticket_id = '".$ticket_id."'"; 
		return $this->db->query($query)->result();
	}
    
    
	public function getAllTicketsData(){
		$this->datatables->select('t.ticket_id')

			->select('(SELECT GROUP_CONCAT(DISTINCT  orderNumber) as f FROM `ticket_details` where t.ticket_id = 	ticket_details.ticket_id)')
			->select('(SELECT GROUP_CONCAT(DISTINCT products.ProductBrand) as f FROM `ticket_details` inner join orderdetails on    orderdetails.SerialNumber=ticket_details.serialNumber inner join products on products.ProductID = orderdetails.ProductID where ticket_id = t.ticket_id)')
			->select('concat(DATE_FORMAT(t.create_date, "%d/%m/%Y"))')
			->select('(select CONCAT(customers.BillingFirstName," ", customers.BillingLastName) as Name from customers  where customers.UserId=t.UserID  )')
            
			->select('(select concat(orders.BillingFirstName," ",orders.BillingLastName ,"," ,orders.BillingCountry) as customer from ticket_details  inner join orders on ticket_details.orderNumber = orders.OrderNumber where ticket_details.ticket_id=t.ticket_id group by ticket_details.orderNumber limit 1)')
           
			->select('concat(DATE_FORMAT(t.reffDate, "%d/%m/%Y"))')
			->select('concat(DATE_FORMAT(t.followUpDate, "%d/%m/%Y"))')
			->select('0')
			->select('(select concat(ticket_details.returnCurrency,",",ROUND(sum(ticket_details.returnUnitPrice),2)) as total_amount from ticket_details where ticket_details.ticket_id=t.ticket_id  )')
			->select('t.ticketStatus')
			->select('t.ticketSrNo')
			->select('t.updateStatus')
			->select('concat(DATE_FORMAT(t.closed_date, "%d/%m/%Y"))')
            
			->select('(select UserName from customers  where customers.UserId=t.reffTo  )')
			->select('t.contact_reason')
			->select('concat(DATE_FORMAT(FROM_UNIXTIME(t.re_received_date), "%d/%m/%Y"))')
			->select('t.re_notes')
			->select('t.areaResponsible')
			->select('t.ac_area_resp_c')
            
			/*->select('(SELECT  
			CONCAT(
			GROUP_CONCAT(
			(CASE 
			WHEN (orderdetails.Printing = "Y") THEN "Printed" 
			WHEN (orderdetails.Printing = "N") THEN "Plain" 
			WHEN (orderdetails.Printing = "") THEN "Plain" 
			END)
			)," / ",
      	                  
													GROUP_CONCAT(
													(CASE 
													WHEN (products.ProductBrand = "Roll Labels") THEN "Roll" 
													WHEN (products.ProductBrand != "Roll Labels") THEN "Sheet" 
													END)
													)
													) AS CHARs
                                    
																		FROM `ticket_details` 
																		inner join orderdetails on  orderdetails.SerialNumber=ticket_details.SerialNumber
																		inner join products on  products.ProductID=orderdetails.ProductID
																		where ticket_details.ticket_id = t.ticket_id 
                              
															) as "Printed/Plain & Sheet/Roll"')
            
						->select('(SELECT  
						GROUP_CONCAT(DISTINCT REPLACE(products.ManufactureID,substring_index(category.CategoryImage,".",1),"")) as 	col_3
						FROM `ticket_details` 
						inner join orderdetails on  orderdetails.SerialNumber=ticket_details.SerialNumber
						inner join products on  products.ProductID=orderdetails.ProductID
						inner join category on  category.CategoryID=products.CategoryID
						where ticket_details.ticket_id = t.ticket_id
                              
															) as "Material Code"')*/
           
			->from('tickets as t');
		echo $this->datatables->generate();
	}
	
	public function getformats(){
		$q= $this->db->query("SELECT ProductBrand FROM `products` where ProductBrand is not NULL GROUP by ProductBrand")->result_Array();
		return $q;
	}
    
    
	public function getReturnReport($to,$from,$format,$status,$areaResponsible){
  	         
                
		$setvalue = 'SET @row_number = 0';
		$this->db->query($setvalue);
        
		$this->db->select('(@row_number:=@row_number + 1) AS "Log No"')
           
			->select('t.ticketSrNo')    
                
			->select('(SELECT GROUP_CONCAT(DISTINCT  orderNumber) as f FROM `ticket_details` where t.ticket_id = ticket_details.ticket_id) as "Order Ref"')
       
			->select('(SELECT  
			CONCAT(
			GROUP_CONCAT(
			(CASE 
			WHEN (orderdetails.Printing = "Y") THEN "Printed" 
			WHEN (orderdetails.Printing = "N") THEN "Plain" 
			WHEN (orderdetails.Printing = "") THEN "Plain" 
			END)
			)," / ",
      	                  
													GROUP_CONCAT(
													(CASE 
													WHEN (products.ProductBrand = "Roll Labels") THEN "Roll" 
													WHEN (products.ProductBrand != "Roll Labels") THEN "Sheet" 
													END)
													)
													) AS CHARs
                                    
																		FROM `ticket_details` 
																		inner join orderdetails on  orderdetails.SerialNumber=ticket_details.SerialNumber
																		inner join products on  products.ProductID=orderdetails.ProductID
																		where ticket_details.ticket_id = t.ticket_id 
                              
															) as "Printed/Plain & Sheet/Roll"')
                    
			->select('concat(DATE_FORMAT(t.create_date, "%d-%m-%Y") ) as "Date of contact"') 
     	        
			->select('(select concat(CAST(CONVERT((CASE 
			WHEN (ticket_details.returnCurrency = "GBP") THEN "£" 
			WHEN (ticket_details.returnCurrency = "EUR") THEN "€" 
			WHEN (ticket_details.returnCurrency = "USD") THEN "$" 
			END) USING utf8) AS binary),"",ROUND(sum(ticket_details.returnUnitPrice),2)) as total_amount from ticket_details where ticket_details.ticket_id=t.ticket_id) as "Price (excl VAT)"')
            
			->select('(select concat(orders.BillingFirstName," ",orders.BillingLastName ,"," ,orders.BillingCountry) as customer from ticket_details  inner join orders on ticket_details.orderNumber = orders.OrderNumber where ticket_details.ticket_id=t.ticket_id group by ticket_details.orderNumber limit 1) as "Customer Name"')
            
			->select('(select orders.BillingCompanyName from ticket_details  inner join orders on ticket_details.orderNumber = orders.OrderNumber where ticket_details.ticket_id=t.ticket_id group by ticket_details.orderNumber limit 1) as "Company Name"')
            
			->select('IF(t.contact_reason IS NULL or t.contact_reason = "", "--", t.contact_reason)  as "Reason for contact/return"')
            
			->select('(SELECT  
			GROUP_CONCAT(DISTINCT REPLACE(products.ManufactureID,substring_index(category.CategoryImage,".",1),"")) as col_3
                            
                                    
																		FROM `ticket_details` 
																		inner join orderdetails on  orderdetails.SerialNumber=ticket_details.SerialNumber
																		inner join products on  products.ProductID=orderdetails.ProductID
																		inner join category on  SUBSTRING_INDEX(products.CategoryID, "R", 1 ) = category.CategoryID
																		where ticket_details.ticket_id = t.ticket_id
                              
															) as "Material Code"')
            
			->select('(CASE 
			WHEN (t.ticketStatus = "0") THEN "Open – UnderInvestigation" 
			WHEN (t.ticketStatus = "1") THEN "Open – Awaiting Info from Customer" 
			WHEN (t.ticketStatus = "2") THEN "Open – Reffered for Desicion" 
			WHEN (t.ticketStatus = "3") THEN "Open – Reffered back to Action" 
			WHEN (t.ticketStatus = "4") THEN "Closed" 
			END) as "Status"')
            
         
			->select('IF(t.reffTo IS NULL or t.reffTo = "", "--", UserName)  as "Referred to" ')
            
			->select('concat(IF(t.reffDate IS NULL or t.reffDate = "", "--", DATE_FORMAT(t.reffDate, "%d/%m/%Y"))) as "Date referred"') 
            
			->select('concat( IF(t.re_received_date IS NULL or t.re_received_date = "", "--", DATE_FORMAT(FROM_UNIXTIME(t.re_received_date), "%d/%m/%Y")) ) as "Follow up date"')
            
			->select('IF(t.exp_booking_notes IS NULL or t.exp_booking_notes = "", "--", t.exp_booking_notes) as "Notes/Comments"')
            
			->select('IF(t.re_notes IS NULL or t.re_notes = "", "--", t.re_notes) as "Outcome & Learning points"')
            
			->select('concat( IF(t.closed_date IS NULL or t.closed_date = "", "--", DATE_FORMAT(t.closed_date, "%d-%m-%Y"))          ) as "Completed date"') 
            
			->select('IF(t.areaResponsible IS NULL or t.areaResponsible = "", "--", t.areaResponsible) as "Area Responsible"')
			->select('IF(t.ac_area_resp_c IS NULL or t.ac_area_resp_c = "", "--", t.ac_area_resp_c) as "Area Responsible Comments"');
            
       
           
		$this->db->from('tickets as t');
		$this->db->join('ticket_details as td','t.ticket_id=td.ticket_id');
		$this->db->join('orderdetails as od','od.SerialNumber=td.SerialNumber');
		$this->db->join('products as p','p.ProductID=od.ProductID');
		$this->db->join('category as c','SUBSTRING_INDEX(p.CategoryID, "R", 1 )=c.CategoryID');
		$this->db->join('customers as cust','cust.UserId=t.reffTo','left');
        
		if($to!='' && $from!=''){
			$this->db->where('DATE(t.create_date) BETWEEN "'.$to.'" AND "'.$from.'"');
		}
        
		if($format!='' && $format!='all'){
			$this->db->where('p.ProductBrand',$format);
		}
        
		if($status!='' && $status != 'all'){
			$this->db->where('t.ticketStatus',$status);
		}
        
		if($areaResponsible!='' && $areaResponsible!='all'){
            
			$where = "FIND_IN_SET('".$areaResponsible."', t.areaResponsible)";  
			$this->db->where($where); 
		}
           
		$this->db->group_by('t.ticket_id');
		//$this->db->where('t.ticket_id','123');
		//$this->db->limit(1);
		//$res= $this->db->get()->result_array();
		//echo '<pre>'; print_r($res); echo '</pre>';  exit;
		$res= $this->db->get();
		// echo $this->db->last_query();exit;
		return $res;
	}
    
	public function fetch_ticket_comments($tid){
		$this->db->limit(1);
		$res = $this->db->get_where('tickets',array('ticket_id'=>$tid))->result_Array();
		return $res;
	}
}

	//GROUP_CONCAT(DISTINCT  REPLACE(products.ManufactureID,substring_index(c.CategoryImage,".",1),"")) as col_3


