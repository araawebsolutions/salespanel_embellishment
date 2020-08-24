<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dashboardModel extends CI_Model
{
    public  $order = 'orders';

    public function getCounts(){

        $final = array();
        $final['totalOrders'] = $this->getOrderCount();
        $final['totalQuotation'] = $this->getQuotationCount();
        //$final['totalFollowUpCount'] = $this->getFollowUpCount();
        //$final['totalEnquiryCount'] = $this->getEnquiryCount();
        $final['todayOrders'] = $this->getTodayOrders();
        $final['todayOrdersPrice'] = $this->getTodayOrdersPrice();
        $final['todaySoldProducts'] = $this->getSoldProducts();
        $final['lastTransactions'] = $this->lastTransactions();

        return $final;
    }

    public function getOrderCount(){

        $this->db->select("count(*) as total");
        $this->db->from('orders');
        $query = $this->db->get();
        return $query->result()[0]->total;
    }

    public function getQuotationCount(){

        $this->db->select("count(*) as total");
        $this->db->from('quotations');
        $query = $this->db->get();
        return $query->result()[0]->total;
    }

    public function getFollowUpCount(){
        $operator = 'all';

        if($operator == 'all'){
            $where = " OperatorID != 0 ";
        }else if($operator == SUPER_ADMIN){
            $where = " OperatorID = 626284 ";
        }else {
            $where = " OperatorID = ".$operator;
        }

        $iStart = 0;
        $iLength = 1000;
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
            case 6 : $name= " Name $col_sort ";break;
            case 7 : $name= " OperatorID $col_sort ";break;
            case 8 : $name= " Billingtelephone $col_sort ";break;
            case 9 : $name= " Billingemail $col_sort ";break;
            case 10 : $name= " callback_status $col_sort ";break;
            case 11: $name= " total $col_sort ";break;
            case 14: $name= " rDate $col_sort ";break;
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
						cast(FROM_UNIXTIME(OrderDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as Date,
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as CBDate,
						cast( BillingPostcode as char(30) ) as postcode, 
						cast( DeliveryCountry as char(30) ) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name, 
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID, 
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( prevOrder as char(30) ) as prevOrder, 
						cast( OrderStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( OrderTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = orders.OrderNumber) as char(10) ) as ctotal,
						cast( PaymentMethods as char(30) ) as payment,
						cast( '' as char(11) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( orders.OrderNumber as char(30) ) as reference,
						cast( '' as char(30) ) as rDate
					from 
						orders 
					where 
						$where 
						and ( $callback_status and callback_status != 3 and callback_status!=5 )".$order;

        //$callback_status = " (callback_status = 1 or callback_status=3 or callback_status = 5 or callback_status = 6 or callback_status = 8 or callback_status = 9)";

        $query4 = "select 
						cast( replace(orders.OrderNumber,'A','D') as char(30) ) as refno, 
						cast(FROM_UNIXTIME(OrderDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as Date,
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as CBDate,
						cast( BillingPostcode as char(30) ) as postcode, 
						cast( DeliveryCountry as char(30) ) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID,  
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( prevOrder as char(30) ) as prevorder, 
						cast( OrderStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( OrderTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = orders.OrderNumber) as char(10) ) as ctotal,
						cast( PaymentMethods as char(30) ) as payment,
						cast( concat('CB', ' ', FROM_UNIXTIME(remainder,'%d-%m-%Y <b>%h : %i %p </b>') ) as char(30) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( orders.OrderNumber as char(30) ) as reference,
						cast( remainder as char(30) ) as rDate
					from 
						orders 
							inner join callback_comment as cc ON orders.OrderNumber= cc.OrderNumber
					where 
						$where and callback_status = 3 and remainder!=0".$order;

        $query5 = "select 
						cast( QuotationNumber as char(30) ) as refno, 
						cast(FROM_UNIXTIME(QuotationDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as Date, 
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as CBDate, 
						cast( BillingPostcode as char(30) ) as postcode, 
						cast( DeliveryCountry as char(30) ) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency, 
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID, 
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( '' as char(30) ) as prevorder, 
						cast( QuotationStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( QuotationTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as ctotal,
						cast( '' as char(30) ) as payment,
						cast( concat('CB', ' ', FROM_UNIXTIME(remainder,'%d-%m-%Y <b>%h : %i %p </b>') ) as char(30) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( QuotationNumber as char(30) ) as reference,
						cast( remainder as char(30) ) as rDate
					from 
						quotations 
							inner join callback_comment as cc ON quotations.QuotationNumber= cc.OrderNumber
					where 
						FROM_UNIXTIME( `QuotationDate` ) < TIMESTAMP( CURRENT_DATE ) 
						and $where and callback_status = 3 and QuotationStatus !=13 and QuotationStatus !=8 and remainder!=0".$quote;

        $query2 = "select 
						cast( QuotationNumber as char(30) ) as refno, 
						cast(FROM_UNIXTIME(QuotationDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as Date, 
						cast(FROM_UNIXTIME(CallbackDate,'%d-%m-%Y <b>%h : %i %p </b>') as char(30) ) as CBDate, 
						cast( BillingPostcode as char(30) ) as postcode, 
						cast( DeliveryCountry as char(30) ) as country, 
						cast(Case WHEN currency = 'GBP' THEN '&pound;'
						 				WHEN currency = 'USD' THEN '$'
										WHEN currency = 'EUR' THEN '&euro;' 
										WHEN currency = '' THEN '' END as char(10) ) as currency,
						cast(concat(BillingFirstName, ' ', BillingLastName) as char(90) ) as Name,
						cast( (select UserName from customers where UserID=OperatorID) as char(30) ) as OperatorID, 
						cast( Billingtelephone as char(30) ) as Billingtelephone, 
						cast( Billingemail as char(30) ) as Billingemail, 
						cast( '' as char(30) ) as prevorder, 
						cast( QuotationStatus as char(30) ) as status, 
						cast( callback_status as char(30) ) as callback_status, 
						cast( vat_exempt as char(30) ) as vat_exempt, 
						cast( exchange_rate as char(30) ) as exchange_rate, 
						cast( QuotationTotal as char(30) ) as total,
						cast((select count(*) as total_comment from callback_comment as cbc where cbc.OrderNumber = QuotationNumber) as char(10) ) as ctotal,
						cast( '' as char(30) ) as payment,
						cast( '' as char(11) ) as CBtime,
						cast( callback_status as char(30) ) as stat,
						cast( QuotationNumber as char(30) ) as reference,
						cast( '' as char(30) ) as rDate
					from 
						quotations 
					where 
						FROM_UNIXTIME( `QuotationDate` ) < TIMESTAMP( CURRENT_DATE ) 
						and $where and ( $callback_status and callback_status != 3) 
						and QuotationStatus !=13 and QuotationStatus !=8 ".$quote;

        $qry1 = " ( ".$query4." )  UNION ALL  ( ".$query5." ) ";



        $qry2 = " ( ".$query2." ) UNION ALL  ( ".$query3." ) ";

        $limit1 = " order by $name LIMIT ".$iStart.",".$iLength;

        $count=0;

        $count_row = $this->db->query($query4);

        $rows= $count_row->result_array();

        $count+=count($rows);

        $count_row = $this->db->query($qry2);

        $rows= $count_row->result_array();

        $count+=count($rows);
       // print_r($count);
      //  exit();

        $query = $qry1." ".$limit1;
        $count_row = $this->db->query($query);
        $rows1= $count_row->result_array();
 //print_r($rows1);
 //exit();
        $counter = count($rows1);
        //print_r($counter);
        //exit();
        $counter = $iLength-$counter;

        $iStart = ($iStart == 0)?$iStart:$this->session->userdata('counter');
        $limit2 = " LIMIT ".$iStart.",".$counter;
        //  $limit2 = " order by rDate,".$name." LIMIT ".$iStart.",".$counter;
        $counter = $iStart + $counter;
        $this->session->set_userdata("counter", $counter);


        $query = $qry2." ".$limit2;
        $count_row = $this->db->query($query);
       $rows2= $count_row->result_array();
      // print_r($rows2);
      // exit();
        $rows = array_merge($rows1, $rows2);
        //$rows = $this->datatables->getproduction($counter, $count,'','dashboard');
        return count($rows);
    }

    public function getFollowUpCountFromOrders(){

        $callback_status = " callback_status != 0 and callback_status != 3 or callback_status = 3  and callback_status != 5 and callback_status!=2 and callback_status != 7 and callback_status != 4 and callback_status != 10 ";
        $this->db->select("count(*) as total");
        $this->db->from('orders');
        $this->db->where($callback_status);
        $this->db->where('OperatorID',626284);
        $query = $this->db->get();
        return $query->result()[0]->total;

    }

    public function getEnquiryCount(){

        $count = $this->db->select('count(*) as total')
            ->from('customlabelsdetails')
            ->join('customlabelsquotes', "customlabelsdetails.QuoteNumber = customlabelsquotes.QuoteNumber AND customlabelsquotes.Source!='M2H-Website' AND customlabelsquotes.Quote=0 ", 'INNER')
            ->join('customlabelsnumber', "customlabelsdetails.QuoteNumber = customlabelsnumber.customLabelsNumber", 'INNER')
            ->where('customlabelsquotes.QuoteNumber !=""'  )->get()->result()[0]->total;

        return $count;
    }

    public function getTodayOrders(){

        $final = array();
        $firstDate = date('Y-m-d');
        $where = "`OrderDate` >UNIX_TIMESTAMP('".$firstDate." 00:00:00') AND `OrderDate`<UNIX_TIMESTAMP('".$firstDate." 23:59:59')";
        $this->db->select("count(*) as total");
        $this->db->from('orders');
        $this->db->where($where);
        $query = $this->db->get();
        $final ['todayOrder'] = $query->result()[0]->total;
        $final ['orderAnalytics'] = $this->getYesterdayOrders($final['todayOrder']);
        return $final;
    }

    public function getYesterdayOrders($today){
        $final = array();
        $firstDate = date('Y-m-d',strtotime("-7 days"));
        $where = "`OrderDate` >UNIX_TIMESTAMP('".$firstDate." 00:00:00') AND `OrderDate`<UNIX_TIMESTAMP('".$firstDate." 23:59:59')";
        $this->db->select("count(*) as total");
        $this->db->from('orders');
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->result()[0]->total;
        if($today > $result){
            $final['percent'] = ($result >0)?number_format(($result /$today)*100,2):100;
            $final['check'] = 'height';
        }else{
            $final['percent'] = ($today >0)?number_format(($today / $result)*100,2):'0.00';
            $final['check'] = 'less';
        }
        return $final;
    }

    public function getTodayOrdersPrice(){
        $final = array();
        $firstDate = date('Y-m-d');
        $where = "`OrderDate` >UNIX_TIMESTAMP('".$firstDate." 00:00:00') AND `OrderDate`<UNIX_TIMESTAMP('".$firstDate." 23:59:59')";
        $this->db->select("SUM(if( orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2),2), round((orders.OrderTotal + orders.OrderShippingAmount),2))) AS OrderPrice");
        $this->db->from('orders');
        $this->db->where($where);
        $query = $this->db->get();
        $final ['todayOrdersPrice'] =  $query->result()[0]->OrderPrice;
        $final ['orderAnalyticsPrice'] = $this->getYesterdayOrdersPrice($final['todayOrdersPrice']);
        return $final;

    }

    public function getYesterdayOrdersPrice($todayPrice){
        $final = array();
        $firstDate = $firstDate = date('Y-m-d',strtotime("-7 days"));
        $where = "`OrderDate` >UNIX_TIMESTAMP('".$firstDate." 00:00:00') AND `OrderDate`<UNIX_TIMESTAMP('".$firstDate." 23:59:59')";
        $this->db->select("SUM(if( orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2),2), round((orders.OrderTotal + orders.OrderShippingAmount),2))) AS OrderPrice");
        $this->db->from('orders');
        $this->db->where($where);
        $query = $this->db->get();
        $result =  $query->result()[0]->OrderPrice;
        if($todayPrice > $result){
            $final['percent'] = ($result >0)?number_format(($result /$todayPrice)*100,2):'100';
            $final['check'] = 'height';
        }else{
            $final['percent'] = ($todayPrice >0)?number_format(($todayPrice /$result)*100,2):'0.00';
            $final['check'] = 'less';
        }
        return $final;

    }

    public function getSoldProducts(){
        $final = array();
        $firstDate = date('Y').'-1-1';
        $secondDate = date('Y').'-12-31';
        $where = "`orders.OrderDate` >UNIX_TIMESTAMP('".$firstDate." 00:00:00') AND `orders.OrderDate`<UNIX_TIMESTAMP('".$secondDate." 23:59:59')";
        $this->db->select("count(orderdetails.ProductID) as total");

        $this->db->join('orderdetails','orders.OrderNumber = orderdetails.OrderNumber');
        $this->db->from('orders');
        $this->db->where($where);


        $query = $this->db->get();
        $final['thisYear'] = $query->result()[0]->total;
        $final['lastYearProducts'] = $this->lastYearsProducts($final['thisYear']);
        return $final;
    }
    public function lastYearsProducts($thisYear){
        $final = array();
        $firstDate = $firstDate = date('Y',strtotime("-1 year")).'-1-1';
        $secondDate = date('Y',strtotime("-1 year")).'-1-1'.'-12-31';
        $where = "`OrderDate` >UNIX_TIMESTAMP('".$firstDate." 00:00:00') AND `OrderDate`<UNIX_TIMESTAMP('".$secondDate." 23:59:59')";
        $this->db->select("count(orderdetails.ProductID) as total");

        $this->db->join('orderdetails','orders.OrderNumber= orderdetails.OrderNumber');
        $this->db->from('orders');
        $this->db->where($where);


        $query = $this->db->get();
        $lastYear = $query->result();
        if(isset($lastYear[0]) && $lastYear[0]->total > 0){
            $lastYear = $lastYear[0]->total;
        }else{
            $lastYear = 0.00;
        }
        if($thisYear > $lastYear){
            $final['percent'] = ($lastYear >0)?number_format(($lastYear /$thisYear)*100,2):'100';
            $final['check'] = 'height';
        }else{
            $final['percent'] = ($thisYear >0)?number_format(($thisYear / $lastYear)*100,2):'0.00';
            $final['check'] = 'less';
        }
        //print_r($final);exit;
        return $final;
    }

    public function lastTransactions(){
        $this->db->select("OrderNumber,currency,exchange_rate,if( orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2),2), round((orders.OrderTotal + orders.OrderShippingAmount),2)) AS OrderPrice");
        $this->db->select('FROM_UNIXTIME(orders.OrderDate,"%d/%m/%Y  %h:%i %p") as date');
        $this->db->from('orders');
        $this->db->order_by('OrderID','DESC');
        $this->db->limit(10);
        return $this->db->get()->result();


    }

    public function getToProducts(){
        $this->db->select("COUNT(orderdetails.ProductID) as COUNT ,products.ManufactureID");
        $this->db->join('products','orderdetails.ProductID = products.ProductID');
        $this->db->from('orderdetails');
        $this->db->where('orderdetails.ProductID !=0');
        $this->db->group_by('orderdetails.ProductID');
        $this->db->order_by('COUNT','DESC');
        $this->db->limit(6);
        return $this->makeData($this->db->get()->result());
    }

    public function getToCountries(){
        $this->db->select("COUNT(BillingCountyState) as COUNT,BillingCountyState as ManufactureID ");
		$this->db->group_by('BillingCountyState');
        $this->db->from('orders');
        $this->db->where('orders.BillingCountyState is NOT NULL');
		$this->db->where(array('BillingCountyState!='=>'Greater London','orders.BillingCountyState!='=>''));
        $this->db->limit(6);
		$this->db->order_by('COUNT','DESC');
        $records = $this->db->get()->result();
       
		function sort_by_name($a,$b)
		{
			return $a->ManufactureID > $b->ManufactureID;
		}
		uasort($records,"sort_by_name");
	
        $final = array();
        foreach ($records as $key=>$record){
            if($key == 0){
                //$final[] = ['name'=>'Task' ,'count'=>'Hours per Day'];
                $final[] = ['name'=>$record->ManufactureID ,'count'=>$record->COUNT];
            }else{
                $final[] = ['name'=>$record->ManufactureID ,'count'=>$record->COUNT];
            }
        }
		
		foreach ($final as $first=>$fn){
				if($fn['name'] == 'UK'){
					unset($final[$first]);
				}
				elseif($fn['name'] == "" || $fn['name'] == null){
					unset($final[$first]);
				}
		}
		return $final;
    }


    public function weeklyOrders(){
        $minvalue = date('Y-m-d').' 00:00:00';
        $maxvalue = date('Y-m-d', strtotime('-7 days')).' 00:00:00';
		
		
		$where = "OrderDate BETWEEN UNIX_TIMESTAMP('".$maxvalue."') and UNIX_TIMESTAMP('".$minvalue."')";
        $this->db->select("COUNT(OrderID) as COUNT, DAYNAME(FROM_UNIXTIME(OrderDate,'%Y-%m-%d'))  as ManufactureID ");
        $this->db->from('orders');
        $this->db->where($where);
        $this->db->group_by('ManufactureID');
        $this->db->limit(7);
		$rec = $this->db->get()->result();
		$daysOfWeek = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		
		function sortByOrder($a, $b) {
			return $a['key'] - $b['key'];
		}
		return $this->makeMyData($rec, $daysOfWeek);	
	}

    public function MonthlyOrders(){
        $minvalue = date('Y-m-d').' 00:00:00';
        $maxvalue = date('Y-m-d', strtotime('-7 month')).' 00:00:00';


        $this->db->select("COUNT(OrderID) as COUNT, MONTHNAME(FROM_UNIXTIME(OrderDate,'%Y-%m-%d'))  as ManufactureID ");
        $this->db->from('orders');
        $this->db->where("OrderDate < UNIX_TIMESTAMP('".$minvalue."')");
        $this->db->where("OrderDate > UNIX_TIMESTAMP('".$maxvalue."')");
        $this->db->group_by('ManufactureID');
        $this->db->order_by('count','DESC');
        $this->db->limit(7);

        return $this->makeMonthData($this->db->get()->result());
    }

    public function makeData($records){

        $final = array();
        foreach ($records as $key=>$record){
            if($key == 0){
                $final[] = ['name'=>'Task' ,'count'=>'Hours per Day'];
                $final[] = ['name'=>$record->ManufactureID ,'count'=>$record->COUNT];
            }else{
                $final[] = ['name'=>$record->ManufactureID ,'count'=>$record->COUNT];
            }

        }
        return $final;
    }

  public function makeMyData($records,$names){
        //print_r($records);exit;
		$daysofweek = $names;
        $first = array();
        foreach ($records as $record){
            foreach ($names as $key=>$day){
                if($record->ManufactureID == $day){
					
					$keys = array_search($record->ManufactureID, $daysofweek);
					$first[] = ['name'=>$day,'count'=>$record->COUNT,'key'=>$keys];
					unset($names[$key]);
                }
            }
        }

        foreach ($names as $firstDay){
			$keys = array_search($firstDay, $daysofweek);
            $first[] = ['name'=>$firstDay,'count'=>0,'key'=>$keys];
        }
		usort($first, 'sortByOrder');

        foreach ($first as $key=>$fir){
            if($key == 0){
                $final[] = ['name'=>'Month','count'=>''];
                $final[] = ['name'=>$fir['name'],'count'=>$fir['count']];
            }else{
                $final[] = ['name'=>$fir['name'],'count'=>$fir['count']];
            }
        }
        return $final;
    }

    public function makeMonthData($records){
        $names = $this->getMonthName();

        return $this->makeMyData($records,$names);

    }

    public function getMonthName(){
        $names = array();
        $minvalue = date('Y-m-d');
        $maxvalue = date('Y-m-d', strtotime('-7 month'));

        $period = new DatePeriod(
            new DateTime($maxvalue),
            DateInterval::createFromDateString('1 month'),
            new DateTime($minvalue)
        );

        foreach ($period as $month) {
            $names[] =  strftime('%B', $month->format('U'));


        }

        return $names;
    }
}