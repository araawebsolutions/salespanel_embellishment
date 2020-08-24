<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FollowModal extends CI_Model
{

   public function getOperator(){
        return $this->db->query("select UserID, UserName from customers where UserTypeID = 1 and Active = 1 and TaxCode LIKE 'callback' and UserName NOT LIKE 'SuperAdmin%' ORDER BY total_assigns ASC ")->result();
    }
    
    
    
    public function getFollowUpData_new($operator){
       $operator = ($operator==NULL)? $this->session->userdata("UserID"):$operator;

       if($operator == 'all'){
           $where = " OperatorID != 0 ";
       }else if($operator == SUPER_ADMIN){
           $where = " OperatorID = 626284 ";
       }else {
           $where = " OperatorID = ".$operator;
       }
		 
		
       $iStart = $this->input->post('iDisplayStart');
       $iLength = $this->input->post('iDisplayLength');
       $search = $this->input->post('sSearch');

       $col_name = $this->input->post('iSortCol_0');
       $col_sort = $this->input->post('sSortDir_0');
       $order = "";
       $quote = "";
       switch($col_name){
           
               
          case 0 : $name= " refno $col_sort ";break;
           case 1 : $name= " Date $col_sort ";break;
           case 2 : $name= " CBDates $col_sort ";break;
           case 3 : $name= " postcode $col_sort ";break;
           case 4 : $name= " country $col_sort ";break;
           //case 4 : $name= "currency $col_sort";break;
          case 5 : $name= " Name $col_sort ";break;
          //case 6 : $name= " Name $col_sort ";break;
           //case 7 : $name= " OperatorID $col_sort ";break;
           case 6 : $name= " Billingtelephone $col_sort ";break;
           case 7 : $name= " Billingemail $col_sort ";break;
           case 8 : $name= " Billingemail $col_sort ";break;
           //case 9 : $name= " callback_status $col_sort ";break;
           case 9 : $name= " CBtime $col_sort ";break;
           case 10: $name= " total $col_sort ";break;
           case 11: $name= " rDate $col_sort ";break;
       }


       if(!empty($search)){
           $userid = $this->db->query("select UserID, UserName from customers where UserTypeID = 1 and Active = 1 and UserName Like '$search' and TaxCode like 'callback' ")->row_array();
           if($search == $userid['UserName']){
               $search=$userid['UserID'];
           }
           $order =" and ( orders.OrderNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";
           $quote =" and ( QuotationNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";

       }
       $callback_status = " callback_status != 0 and callback_status!=2 and callback_status != 7 and callback_status != 4 and callback_status != 10 ";



       

      

       $query5 = "select 
						cast( QuotationNumber as char(30) ) as refno, 
						cast(FROM_UNIXTIME(QuotationDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date, 
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as CBDate, 
						 
						cast(concat(DeliveryCountry, ' <br> <b> ',BillingPostcode,'</b>') as char(250)) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
					
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( '' as char(30) ) as prevorder, 
						cast( QuotationStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( QuotationTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as ctotal3,
						cast( '' as char(30) ) as payment,
						remainder as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( QuotationNumber as char(30) ) as reference,
						cast( remainder as char(30) ) as rDate,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID,
						CallbackDate as CBDates
					from 
						quotations 
							inner join callback_comment as cc ON quotations.QuotationNumber= cc.OrderNumber
					where 
						FROM_UNIXTIME( `QuotationDate` ) < TIMESTAMP( CURRENT_DATE ) 
						and $where and callback_status = 3 and QuotationStatus !=13 and QuotationStatus !=8 and remainder!=0".$quote;

       $query2 = "select 
						cast( QuotationNumber as char(30) ) as refno, 
						cast(FROM_UNIXTIME(QuotationDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date, 
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as CBDate, 
						
						cast(concat(DeliveryCountry, ' <br> <b> ',BillingPostcode , '</b>') as char(250)) as country,  
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency,
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
					
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( '' as char(30) ) as prevorder, 
						cast( QuotationStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( QuotationTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as ctotal4,
						cast( '' as char(30) ) as payment,
						cast( '' as char(11) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( QuotationNumber as char(30) ) as reference,
						cast( '' as char(30) ) as rDate,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID,
							CallbackDate as CBDates
					from 
						quotations 
					where 
						FROM_UNIXTIME( `QuotationDate` ) < TIMESTAMP( CURRENT_DATE ) 
						and $where and ( $callback_status ) 
						and QuotationStatus !=13 and QuotationStatus !=8 ".$quote;

      
       $qry1 = " ( ".$query2." )  UNION ALL  ( ".$query5." ) ";
   

       $limit1 = " order by $name LIMIT ".$iStart.",".$iLength;

       $count=0;
       $count_row = $this->db->query($qry1);
       $rows= $count_row->result_array();
       $count+=count($rows);


       $query = $qry1." ".$limit1;
       
       $count_row = $this->db->query($query);
       $rows1= $count_row->result_array();

       $counter = count($rows1);
       $counter = $iLength-$counter;

       $iStart = ($iStart == 0)?$iStart:$this->session->userdata('counter');
       $limit2 = " order by $name LIMIT ".$iStart.",".$counter;
       
       $counter = $iStart + $counter;
       $this->session->set_userdata("counter", $counter);


     

		 //echo '<pre>'; print_r($rows); echo '</pre>';
       echo $r=  $this->datatables->getproduction($rows1, $count);

		 
       //echo json_encode($r);
       //exit;
   }

   public function getFollowUpData($operator){
       $operator = ($operator==NULL)? $this->session->userdata("UserID"):$operator;

       if($operator == 'all'){
           $where = " OperatorID != 0 ";
       }else if($operator == SUPER_ADMIN){
           $where = " OperatorID = 626284 ";
       }else {
           $where = " OperatorID = ".$operator;
       }
		 
		
       $iStart = $this->input->post('iDisplayStart');
       $iLength = $this->input->post('iDisplayLength');
       $search = $this->input->post('sSearch');

       $col_name = $this->input->post('iSortCol_0');
       $col_sort = $this->input->post('sSortDir_0');
       $order = "";
       $quote = "";
       switch($col_name){
           
               
          case 0 : $name= " refno $col_sort ";break;
           case 1 : $name= " Date $col_sort ";break;
           case 2 : $name= " CBDate $col_sort ";break;
           case 3 : $name= " postcode $col_sort ";break;
           case 4 : $name= " country $col_sort ";break;
           //case 4 : $name= "currency $col_sort";break;
          case 5 : $name= " Name $col_sort ";break;
          //case 6 : $name= " Name $col_sort ";break;
           //case 7 : $name= " OperatorID $col_sort ";break;
           case 6 : $name= " Billingtelephone $col_sort ";break;
           case 7 : $name= " Billingemail $col_sort ";break;
           case 8 : $name= " Billingemail $col_sort ";break;
           //case 9 : $name= " callback_status $col_sort ";break;
           case 9 : $name= " CBtime $col_sort ";break;
           case 10: $name= " total $col_sort ";break;
           case 11: $name= " rDate $col_sort ";break;
       }


       if(!empty($search)){
           $userid = $this->db->query("select UserID, UserName from customers where UserTypeID = 1 and Active = 1 and UserName Like '$search' and TaxCode like 'callback' ")->row_array();
           if($search == $userid['UserName']){
               $search=$userid['UserID'];
           }
           $order =" and ( orders.OrderNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";
           $quote =" and ( QuotationNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";

       }
       $callback_status = " callback_status != 0 and callback_status!=2 and callback_status != 7 and callback_status != 4 and callback_status != 10 ";



       $query3 = "select
						cast( replace(orders.OrderNumber,'A','A') as char(30) ) as refno, 
						cast(FROM_UNIXTIME(OrderDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date,
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as CBDate,
						
						cast(concat(DeliveryCountry, ' <br> <b> ',BillingPostcode, '</b>') as char(250)) as country,  
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name, 
					
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( prevOrder as char(30) ) as prevOrder, 
						cast( OrderStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( OrderTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = orders.OrderNumber) as char(10) ) as ctotal1,
						cast( PaymentMethods as char(30) ) as payment,
						cast( '' as char(11) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( orders.OrderNumber as char(30) ) as reference,
						cast( '' as char(30) ) as rDate,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID
					from 
						orders 
					where 
						$where 
						and ( $callback_status and callback_status != 3 and callback_status!=5 )".$order;

       //$callback_status = " (callback_status = 1 or callback_status=3 or callback_status = 5 or callback_status = 6 or callback_status = 8 or callback_status = 9)";

       $query4 = "select 
						cast( replace(orders.OrderNumber,'A','D') as char(30) ) as refno, 
						cast(FROM_UNIXTIME(OrderDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date,
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as CBDate,
						
						cast(concat(DeliveryCountry, ' <br> <b> ',BillingPostcode , '</b>' ) as char(250)) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
		
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( prevOrder as char(30) ) as prevorder, 
						cast( OrderStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( OrderTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbcs where cbcs.OrderNumber = orders.OrderNumber OR cbcs.OrderNumber = cc.remainder) as char(10) ) as ctotal2,
						cast( PaymentMethods as char(30) ) as payment,
						remainder as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( orders.OrderNumber as char(30) ) as reference,
						cast( remainder as char(30) ) as rDate,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID
					from 
						orders 
							inner join callback_comment as cc ON orders.OrderNumber= cc.OrderNumber
					where 
						$where and callback_status = 3 and remainder!=0".$order;

       $query5 = "select 
						cast( QuotationNumber as char(30) ) as refno, 
						cast(FROM_UNIXTIME(QuotationDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date, 
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as CBDate, 
						 
						cast(concat(DeliveryCountry, ' <br> <b> ',BillingPostcode,'</b>') as char(250)) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
					
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( '' as char(30) ) as prevorder, 
						cast( QuotationStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( QuotationTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as ctotal3,
						cast( '' as char(30) ) as payment,
						remainder as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( QuotationNumber as char(30) ) as reference,
						cast( remainder as char(30) ) as rDate,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID
					from 
						quotations 
							inner join callback_comment as cc ON quotations.QuotationNumber= cc.OrderNumber
					where 
						FROM_UNIXTIME( `QuotationDate` ) < TIMESTAMP( CURRENT_DATE ) 
						and $where and callback_status = 3 and QuotationStatus !=13 and QuotationStatus !=8 and remainder!=0".$quote;

       $query2 = "select 
						cast( QuotationNumber as char(30) ) as refno, 
						cast(FROM_UNIXTIME(QuotationDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date, 
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as CBDate, 
						
						cast(concat(DeliveryCountry, ' <br> <b> ',BillingPostcode , '</b>') as char(250)) as country,  
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency,
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
					
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( '' as char(30) ) as prevorder, 
						cast( QuotationStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( QuotationTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as ctotal4,
						cast( '' as char(30) ) as payment,
						cast( '' as char(11) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( QuotationNumber as char(30) ) as reference,
						cast( '' as char(30) ) as rDate,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID
					from 
						quotations 
					where 
						FROM_UNIXTIME( `QuotationDate` ) < TIMESTAMP( CURRENT_DATE ) 
						and $where and ( $callback_status ) 
						and callback_status !=3  and QuotationStatus !=13 and QuotationStatus !=8 ".$quote;

       $qry1 = " ( ".$query4." )  UNION ALL  ( ".$query5." ) ";
       $qry2 = " ( ".$query2." ) UNION ALL  ( ".$query3." ) ";
       
      
   

       $limit1 = " order by $name LIMIT ".$iStart.",".$iLength;

       $count=0;

       $count_row = $this->db->query($qry1);

       $rows= $count_row->result_array();

       $count+=count($rows);

       $count_row = $this->db->query($qry2);

       $rows= $count_row->result_array();

       $count+=count($rows);

       $query = $qry1." ".$limit1;
       $count_row = $this->db->query($query);
       $rows1= $count_row->result_array();

       $counter = count($rows1);
       $counter = $iLength-$counter;

       $iStart = ($iStart == 0)?$iStart:$this->session->userdata('counter');
       $limit2 = " order by $name LIMIT ".$iStart.",".$counter;
       //  $limit2 = " order by rDate,".$name." LIMIT ".$iStart.",".$counter;
       $counter = $iStart + $counter;
       $this->session->set_userdata("counter", $counter);


       $query = $qry2." ".$limit2;
      
       $count_row = $this->db->query($query);
       $rows2= $count_row->result_array();
       $rows = array_merge($rows1, $rows2);

		   //echo '<pre>'; print_r($rows); echo '</pre>';
       echo $r=  $this->datatables->getproduction($rows, $count);

		 
       //echo json_encode($r);
       //exit;
   }

   public function completedJobs($filter=NULL){

        $iStart = $this->input->post('iDisplayStart');
        $iLength = $this->input->post('iDisplayLength');
        $search = $this->input->post('sSearch');

        $col_name = $this->input->post('iSortCol_0');
        $col_sort = $this->input->post('sSortDir_0');
        $order ="";
        $quote ="";
        $enquiry = "";

        switch($col_name){
            case 0 : $name= " refno $col_sort ";break;
            case 1 : $name= " cDate $col_sort ";break;
            case 2 : $name= " postcode $col_sort ";break;
            case 3 : $name= " country $col_sort ";break;
            //case 4 : $name= "currency $col_sort";break;
            case 5 : $name= " Name $col_sort ";break;
            case 6 : $name= " OperatorID $col_sort ";break;
            case 7 : $name= " Billingtelephone $col_sort ";break;
            case 8 : $name= " Billingemail $col_sort ";break;
            case 9 : $name= " callback_status $col_sort ";break;
            case 10: $name= " total $col_sort ";break;
        }

        if($filter == "all"){
            $where = "OperatorID != 0 ";
        }else{
            $where = "OperatorID = '".$filter."' ";
        }
        if(!empty($search)){
            $userid = $this->db->query("select UserID, UserName from customers where UserTypeID = 1 and Active = 1 and UserName Like '".$search."' and TaxCode like 'callback' ")->row_array();
            if($search == $userid['UserName']){
                $search=$userid['UserID'];
            }
            $order =" and ( OrderNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";
            $quote =" and ( QuotationNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";
            $enquiry =" and ( QuoteNumber like '$search' or BillingPostcode like '$search' or DeliveryCountry like '$search' or BillingFirstName like '$search' or OperatorID like '$search' or Billingtelephone like '$search' or callback_status like '$search' ) ";
        }


        $data1 = "select cast(OrderNumber as char(30) ) as refno,
						 cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date,
						 cast(ord.BillingPostcode as char(250) ) as postcode,
						 cast(ord.DeliveryCountry as char(30) ) as country,
						 cast(concat(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' END, OrderTotal*exchange_rate) as char(10) ) as currency,
						 cast(concat(ord.BillingFirstName, ' ', ord.BillingLastName) as char(90) ) as Name,
						 cast((select UserName from  customers where UserID = OperatorID) as char(30) ) as OperatorID,
						 cast(ord.Billingtelephone as char(30) ) as Billingtelephone,
						 cast(ord.Billingemail as char(50) ) as Billingemail,
						 cast((Case WHEN callback_status = 2 THEN 'COMPLETED'
						 			WHEN callback_status = 4 THEN 'REJECTED'
									WHEN callback_status = 10 THEN 'OREDER PLACED'
									WHEN callback_status = 7 THEN 'ORDER WITH ANOTHER SUPPLIER' END) as char(30) ) as callback_status,
						 cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = ord.OrderNumber) as char(10) ) as total,
						 cast('' as char(30) ) as reference_no,
						 cast( CallbackDate as char(30) ) as cDate
						 from orders as ord where $where  and ( callback_status=4 or callback_status=5 or callback_status =2 or  callback_status = 7 ) $order";



        $data2 = "select cast(QuotationNumber as char(30) ) as refno,
						 cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b> %h : %i %p </b>') as char(30) ) as Date,
						 cast(BillingPostcode as char(250) ) as postcode,
						 cast(DeliveryCountry as char(30) ) as country,
						 cast(concat(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' END, QuotationTotal*exchange_rate ) as char(10) ) as currency,
						 cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						 cast((select UserName from  customers where UserID = OperatorID) as char(30) ) as OperatorID,
						 cast(Billingtelephone as char(30) ) as Billingtelephone,
						 cast(Billingemail as char(50) ) as Billingemail,
						 
						 cast((Case WHEN callback_status = 2 THEN 'COMPLETED'
						 			WHEN callback_status = 4 THEN 'REJECTED'
									WHEN callback_status = 10 THEN 'OREDER PLACED'
									WHEN callback_status = 7 THEN 'ORDER WITH ANOTHER SUPPLIER' END) as char(30) ) as callback_status,
						 cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as total,
						 cast(reference_no as char(30) ) as reference_no,
						 cast( CallbackDate as char(30) ) as cDate
						 from quotations where $where  and ( callback_status = 2 or callback_status = 4 or callback_status = 7 or callback_status = 10 ) $quote";

        $data3 = "select cast(QuoteNumber as char(30) ) as refno,
						 cast(FROM_UNIXTIME(unix_timestamp( concat( RequestDate, ' ', RequestTime )),'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date,
						 cast(BillingPostcode as char(250) ) as postcode,
						 cast(DeliveryCountry as char(30) ) as country,
						 cast('' as char(5) ) as currency,
						 cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						 cast((select UserName from  customers where UserID = OperatorID) as char(30) ) as OperatorID,
						 cast(BillingTelephone as char(30) ) as Billingtelephone,
						 cast(Billingemail as char(50) ) as Billingemail,
						 
						 cast((Case WHEN RequestStatus = 13 THEN 'COMPLETED' END) as char(30) ) as callback_status,
						 cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuoteNumber) as char(10) ) as total,
						 cast(refrence_no as char(30) ) as reference_no,
						 cast( CallbackDate as char(30) ) as cDate
						 
						 from customlabelsquotes where $where  and ( callback_status=4 or callback_status =2 or callback_status = 7 ) $enquiry and RequestStatus = 13";
		///////////////////////////////////////////////////////////////////////////////////

		$data_scount1 = "select cast(OrderNumber as char(30) ) as refno,
						 cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date,
						 cast(ord.BillingPostcode as char(250) ) as postcode,
						 cast(ord.DeliveryCountry as char(30) ) as country,
						 cast(concat(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' END, OrderTotal*exchange_rate) as char(10) ) as currency,
						 cast(concat(ord.BillingFirstName, ' ', ord.BillingLastName) as char(90) ) as Name,
						 cast(OperatorID as char(30) ) as OperatorID,
						 cast(ord.Billingtelephone as char(30) ) as Billingtelephone,
						 cast(ord.Billingemail as char(50) ) as Billingemail,
						 cast((Case WHEN callback_status = 2 THEN 'COMPLETED'
						 			WHEN callback_status = 4 THEN 'REJECTED'
									WHEN callback_status = 10 THEN 'OREDER PLACED'
									WHEN callback_status = 7 THEN 'ORDER WITH ANOTHER SUPPLIER' END) as char(30) ) as callback_status,
						 cast(ord.OrderNumber as char(10) ) as total,
						 cast('' as char(30) ) as reference_no,
						 cast( CallbackDate as char(30) ) as cDate
						 from orders as ord where $where  and ( callback_status=4 or callback_status=5 or callback_status =2 or  callback_status = 7 ) $order";



        $data_scount2 = "select cast(QuotationNumber as char(30) ) as refno,
						 cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <br> <b> %h : %i %p </b>') as char(30) ) as Date,
						 cast(BillingPostcode as char(250) ) as postcode,
						 cast(DeliveryCountry as char(30) ) as country,
						 cast(concat(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' END, QuotationTotal*exchange_rate ) as char(10) ) as currency,
						 cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						 cast(OperatorID as char(30) ) as OperatorID,
						 cast(Billingtelephone as char(30) ) as Billingtelephone,
						 cast(Billingemail as char(50) ) as Billingemail,
						 
						 cast((Case WHEN callback_status = 2 THEN 'COMPLETED'
						 			WHEN callback_status = 4 THEN 'REJECTED'
									WHEN callback_status = 10 THEN 'OREDER PLACED'
									WHEN callback_status = 7 THEN 'ORDER WITH ANOTHER SUPPLIER' END) as char(30) ) as callback_status,
						 cast(QuotationNumber as char(10) ) as total,
						 cast(reference_no as char(30) ) as reference_no,
						 cast( CallbackDate as char(30) ) as cDate
						 from quotations where $where  and ( callback_status = 2 or callback_status = 4 or callback_status = 7 or callback_status = 10 ) $quote";

        $data_scount3 = "select cast(QuoteNumber as char(30) ) as refno,
						 cast(FROM_UNIXTIME(unix_timestamp( concat( RequestDate, ' ', RequestTime )),'%d-%m-%Y <br> <b>%h : %i %p </b>') as char(30) ) as Date,
						 cast(BillingPostcode as char(250) ) as postcode,
						 cast(DeliveryCountry as char(30) ) as country,
						 cast('' as char(5) ) as currency,
						 cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						 cast(OperatorID as char(30) ) as OperatorID,
						 cast(BillingTelephone as char(30) ) as Billingtelephone,
						 cast(Billingemail as char(50) ) as Billingemail,
						 
						 cast((Case WHEN RequestStatus = 13 THEN 'COMPLETED' END) as char(30) ) as callback_status,
						 cast( QuoteNumber as char(10) ) as total,
						 cast(refrence_no as char(30) ) as reference_no,
						 cast( CallbackDate as char(30) ) as cDate
						 
						 from customlabelsquotes where $where  and ( callback_status=4 or callback_status =2 or callback_status = 7 ) $enquiry and RequestStatus = 13";

		/////////////////////////////////////////////////////////////////////////////////////

        //$qry = " ( ".$data1." )  UNION ALL  ( ".$data2." ) UNION ALL  ( ".$data3." ) ";
		$qry = " ( ".$data1." ) UNION ALL  ( ".$data2." ) UNION ALL  ( ".$data3." )";

		$qry_scount = " ( ".$data_scount1." ) UNION ALL  ( ".$data_scount2." ) UNION ALL  ( ".$data_scount3." )";
        //$qry = " ( ".$data1." )  UNION ALL  ( ".$data2." ) ";

        $limit = "order by ".$name." LIMIT ".$iStart.",".$iLength;

        //die($qry);

        $count_row = $this->db->query($qry_scount);
        $rows= $count_row->result_array();
        $count = count($rows);

        $query = $qry." ".$limit;
        
        $count_row = $this->db->query($query);
        $rows= $count_row->result_array();
        echo  $this->datatables->getproduction($rows, $count);
    }

   public function fetch_order_comments($table,$order){
        $qry = $this->db->query("select * from $table where OrderNumber LIKE '".$order."'  order by ID Desc ")->result();
        return $qry;
    }

   public function deleteComment($table,$commentId){
        $this->db->where('ID',$commentId);
        $this->db->delete($table);
        return true;
    }

   public function saveComment(){
        $order = $this->input->post('order');
        $comment = $this->input->post('comment');
        $table = "callback_comment";
        $this->db->insert($table,array('OrderNumber'=>$order,'comment'=>$comment,'Operator'=>$this->session->userdata('login_user_id'),'Time'=>time(),"comment_type"=>"manual"));
        return true;
    }

   public function get_remainder($orderno=NULL){
       $where = "";
       if($orderno !=null){
            $where = " where OrderNumber like '".$orderno."' and remainder !=0";
        }

        if($orderno == NULL){
            $where = " where remainder > unix_timestamp(CURDATE()) AND remainder < UNIX_TIMESTAMP(CURDATE()+1) order by remainder asc ";
        }
        return $this->db->query("select `comment`, `remainder` from callback_comment $where")->result();
   }
   
   
   
   
   public function getQuotations($user){
       //$orderBy = $_POST['sSortDir_0'];
       
       $col_name = $this->input->post('iSortCol_0');
       $col_sort = $this->input->post('sSortDir_0');
       $status = $this->input->get('status');
       $nine = " CBtime ";
        if($status=='qfu'){
                $nine = " callback_status ";
        }
        

       switch($col_name){
           case 0 : $name= " refno  ";break;
           case 1 : $name= " Date  ";break;
           case 2 : $name= " astimes  ";break;
           case 3 : $name= " country  ";break;
           case 4 : $name= " total  ";break;
           case 5 : $name= " Name  ";break;
           case 6 : $name= " Billingtelephone  ";break;
           case 7 : $name= " Billingemail  ";break;
           case 8 : $name= " Billingemail  ";break;
           case 9 : $name=   $nine;break;
           case 10: $name= " ctotal3  ";break;
           case 11: $name= " rDate  ";break;
   }
       
       
        
        if($status=='qfu'){
          
           $this->qFollowup($name,$col_sort);
        }else{
            
            
            
            $this->qCallBack($name,$col_sort);
        }
       
       
       
       
        // ->order_by("quotations.OrderDate $orderBy");
       
       
    }    
    
    
    
    
    function qCallBack($name,$col_sort){
                    
        $where = " FROM_UNIXTIME( CallbackDate ) < TIMESTAMP( NOW() ) and OperatorID !=0 and callback_status = 3 and QuotationStatus !=13 and QuotationStatus !=8 and cc.remainder!=0 ";
       
        $this->datatables->select('
        quotations.QuotationNumber as refno,
        FROM_UNIXTIME(quotations.QuotationDate,"%d-%m-%Y <br> <b>%h:%i %p</b>") as Date,
        FROM_UNIXTIME(quotations.CallbackDate,"%d-%m-%Y <br><b>%h %i %p</b>") as CBDate,
        concat(quotations.DeliveryCountry, " <br> <b>",quotations.BillingPostcode,"</b>") as country, 
        quotations.QuotationTotal  as total,
        
                                        
        concat(quotations.BillingFirstName, " ", quotations.BillingLastName) as Name,
        
        quotations.Billingtelephone, 
        quotations.Billingemail, 
		quotations.QuotationStatus as status, 
		quotations.callback_status, 
		quotations.vat_exempt, 
		quotations.exchange_rate, 
        
        (Case WHEN quotations.currency = "GBP" THEN "&pound;"
						 				WHEN quotations.currency = "USD" THEN "$"
										WHEN quotations.currency = "EUR" THEN "&euro;" 
										WHEN quotations.currency = "" THEN "" END ) as currency,
		(select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = quotations.QuotationNumber) as ctotal3,
		
		quotations.CallbackDate as astimes,
		quotations.callback_status as stat,
		quotations.QuotationNumber as reference,
        cc.remainder as CBtime,
        (select UserName from customers where UserID=quotations.OperatorID) as OperatorID')
        ->join('callback_comment as cc', 'quotations.QuotationNumber = cc.OrderNumber','inner')
        ->where($where, "", false)
        ->from('quotations')
         ->order_by("$name $col_sort");
         echo($this->datatables->generate());
    }
    
    
    
    function qFollowup($name,$col_sort){

    $callback_status = " (callback_status != 0 and callback_status!=2 and callback_status != 3 and  callback_status != 4 and   callback_status != 7  and callback_status != 10 ) or (callback_status = 15) ";
       
    $where = "FROM_UNIXTIME( `CallbackDate` ) < TIMESTAMP( NOW() ) and OperatorID != 0 and ( $callback_status ) and QuotationStatus !=13 and QuotationStatus !=8";
       
       $this->datatables->select('
        quotations.QuotationNumber as refno,
        FROM_UNIXTIME(quotations.QuotationDate,"%d-%m-%Y <br> <b>%h:%i %p</b>") as Date,
        FROM_UNIXTIME(quotations.CallbackDate,"%d-%m-%Y <br><b>%h %i %p</b>") as CBDate,
        concat(quotations.DeliveryCountry, " <br> <b>",quotations.BillingPostcode,"</b>") as country, 
        quotations.QuotationTotal  as total,
        
                                        
        concat(quotations.BillingFirstName, " ", quotations.BillingLastName) as Name,
        
        quotations.Billingtelephone, 
        quotations.Billingemail, 
		quotations.QuotationStatus as status, 
		quotations.callback_status, 
		quotations.vat_exempt, 
		quotations.exchange_rate, 
        
        
        (Case WHEN quotations.currency = "GBP" THEN "&pound;"
						 				WHEN quotations.currency = "USD" THEN "$"
										WHEN quotations.currency = "EUR" THEN "&euro;" 
										WHEN quotations.currency = "" THEN "" END ) as currency,
		(select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = quotations.QuotationNumber) as ctotal3,
		
			quotations.CallbackDate as astimes,
		quotations.callback_status as stat,
		quotations.QuotationNumber as reference,
        "0" as rDate,
        (select UserName from customers where UserID=quotations.OperatorID) as OperatorID')
        ->where($where, "", false)
        ->from('quotations')
         ->order_by("$name $col_sort");
         
         //echo $this->datatables->last_query();
        
         echo($this->datatables->generate());
    }
    
    
    
    
    
    public function getorders($user){
        
        $col_name = $this->input->post('iSortCol_0');
        $col_sort = $this->input->post('sSortDir_0');
        
        $status = $this->input->get('status');
        
        $nine = " CBtime ";
        if($status=='ofu'){
                $nine = " callback_status ";
        }
      
        switch($col_name){
            case 0 : $name= " refno ";              break;
            case 1 : $name= " Date ";               break;
            case 2 : $name= " CBDates ";            break;
            case 3 : $name= " country ";            break;
            case 4 : $name= " totalss ";              break;
            case 5 : $name= " Name ";               break;
            case 6 : $name= " Billingtelephone ";   break;
            case 7 : $name= " Billingemail ";       break;
            case 8 : $name= " Billingemail ";       break;
            case 9 : $name=  $nine ;             break;
            case 10: $name= " ctotal2 ";            break;
            case 11: $name= " rDate ";              break;
        }
       
        if($status=='ofu'){
            $this->ordFollowup($name,$col_sort);
        }else{
            $this->ordFollowupback($name,$col_sort);
        }
    }    
    
    
    
    
    function  ordFollowupback($name,$col_sort){

   
    $where = " OperatorID != 0 and callback_status = 3 and remainder!=0 ";
        
        $this->datatables->select('                 
                        replace(orders.OrderNumber,"A","D") as refno, 
						FROM_UNIXTIME(OrderDate,"%d-%m-%Y <br> <b>%h : %i %p </b>")  as Date,
						FROM_UNIXTIME(CallbackDate,"%d-%m-%Y <br> <b>%h:%i %p </b>") as CBDate,
						concat(DeliveryCountry, "<br> <b> ",BillingPostcode , "</b>" ) as country, 
							OrderTotal  as totalss,
						
                             
						concat(BillingFirstName, " ", BillingLastName) as Name,
                        Billingtelephone  as Billingtelephone, 
						Billingemail  as Billingemail, 
						prevOrder  as prevorder, 
						OrderStatus  as status, 
						callback_status  as callback_status, 
						vat_exempt  as vat_exempt, 
						exchange_rate  as exchange_rate, 
						Case WHEN currency = "GBP" THEN "&pound;"
						 	 WHEN currency = "USD" THEN "$"
							 WHEN currency = "EUR" THEN "&euro;" 
							 WHEN currency = ""    THEN "" END as currency, 
							 
					
						(select count(*) as total_comment from callback_comment as cbcs where cbcs.OrderNumber = orders.OrderNumber) as ctotal2,
						PaymentMethods  as payment,
						remainder as CBtime,
						callback_status as stat,
						orders.OrderNumber  as reference,
						CallbackDate as rDate,
						CallbackDate as CBDates,
		                (select UserName from customers where UserID=OperatorID) as OperatorID
                        
                        ')
            
                       
                      
                        ->from('orders')
                         ->join('callback_comment as cc', 'orders.OrderNumber= cc.OrderNumber','inner')
                           ->where($where, "", false)
                          ->order_by("$name $col_sort");
                          
                          
        echo($this->datatables->generate());
        
    }
    
    
        function ordFollowup($name,$col_sort){

   
    $callback_status = "  callback_status != 0 and callback_status!=2 and callback_status != 7 and callback_status != 4 and callback_status != 10 ";
    $where = " OperatorID != 0 and ( $callback_status and callback_status != 3 and callback_status!=5 )";
        
       $this->datatables->select('
        replace(orders.OrderNumber,"A","A") as refno,
        FROM_UNIXTIME(OrderDate,"%d-%m-%Y <br> <b>%h:%i %p </b>")  as Date,
        FROM_UNIXTIME(CallbackDate,"%d-%m-%Y <br> <b>%h:%i %p </b>")  as CBDate,
        concat(DeliveryCountry, " <br> <b> ",BillingPostcode, "</b>") as country, 
        	OrderTotal  as totalss,
        
        
        concat(BillingFirstName," ", BillingLastName) as Name,
        
        Billingtelephone as Billingtelephone, 
        Billingemail  as Billingemail, 
		prevOrder  as prevOrder, 
		OrderStatus  as status, 
		callback_status  as callback_status, 
		vat_exempt  as vat_exempt, 
		exchange_rate  as exchange_rate, 
	
		Case WHEN currency = "GBP" THEN "&pound;"
             WHEN currency = "USD" THEN "$"
			 WHEN currency = "EUR" THEN "&euro;" 
			 WHEN currency = "" THEN "" END  as currency, 
		(select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = orders.OrderNumber)  as ctotal2,
		PaymentMethods  as payment,
		0 as CBtime,
		callback_status  as stat,
		orders.OrderNumber  as reference,
		CallbackDate as CBDates,
		(select UserName from customers where UserID=OperatorID)  as OperatorID')
        ->where($where, "", false)
        ->from('orders')
        ->order_by("$name $col_sort");
        echo($this->datatables->generate());
        
    }
    
    
    
    
    
    
    
    
    
    
}