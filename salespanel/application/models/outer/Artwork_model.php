<?php
class Artwork_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function fetchorders($start,$limit){
		$userid = $this->session->userdata('UserID');
	    $usertypeid = $this->session->userdata('UserTypeID');
		$designer = DESIGNER;
	 
	 $condition = "";	
	 if($usertypeid == 88 && $userid!= DESIGNER){
	   $condition = "and  (designer = $userid or designer = $designer )";
	 }
	 
	 $query = "select OrderNumber,concat(BillingFirstName,' ',BillingLastName) as name,BillingCountry,format,designer,assigny,site,OrderStatus,Label from orders where (OrderStatus = 55 or OrderStatus = 56 or OrderStatus = 63) $condition order by OrderNumber asc limit $start , $limit ";
	 return $this->db->query($query)->result();
	}
	
	 function fetchorders_all(){
        $userid = $this->session->userdata('UserID');
        $usertypeid = $this->session->userdata('UserTypeID');
        $designer = DESIGNER;

        $condition = "";
        if($usertypeid == 88 && $userid!= DESIGNER){
            $condition = "and  (designer = $userid or designer = $designer )";
        }

        $query = "select OrderNumber,concat(BillingFirstName,' ',BillingLastName) as name,BillingCountry,format,designer,assigny,site,OrderStatus,Label from orders where (OrderStatus = 55 or OrderStatus = 56 or OrderStatus = 63) $condition order by OrderNumber asc ";
        return $this->db->query($query)->result();
    }
    
	function update_order_attachment($jobno,$array){
	  $this->db->where('ID',$jobno);
	  $this->db->update('order_attachments_integrated',$array);
	  return 'updated';
	}
	
    function fetch_designers(){
	 $designer = DESIGNER;
	 return $this->db->query("select UserID,UserName from customers where UserTypeID = 88 and Active = 1 and UserID != $designer ")->result();
	}
  //------------------------------------------------STAR OF TIMELINE----------------------------------------------------------	   
	
	
	function add_to_timeline($jobno,$status,$ver,$type,$isreject){
	  $recentjob = $this->fetch_jobtimeline($jobno);
          $att_jobs =  $this->fetch_orderAttachdate($jobno);


       $time_comp = '';
    if(count($recentjob) > 0){
        $time_comp = $recentjob['Time'];
    }else{
        $time_comp = $att_jobs['lastmodified'];
    }
     /*else{
        $time_comp =   $this->fetch_order_date($att_jobs['lastmodified']);
    }*/


	  $minutes = $this->calculate_minutes($time_comp,time());
	  $minutes = ($minutes == 0)?1:$minutes;
	  
	  $array = array('Jobno'=>$jobno,'Action'=>$status,'Time'=>time(),'Version'=>$ver,'operator'=>$this->session->userdata('UserID'),'type'=>$type,'is_reject'=>$isreject,'time_taken'=>$minutes);	
	  $this->db->insert('artwork_timeline',$array);

	  //echo $this->db->last_query();
	  return 'inserted';
	}
	
	public function fetch_jobtimeline($jobno){
	  return $this->db->query("SELECT * from artwork_timeline where Jobno = $jobno order by ID desc limit 1 ")->row_array();
	}

    public function fetch_orderAttachdate($jobno){
        return $this->db->query("SELECT * from order_attachments_integrated where ID = $jobno order by ID desc limit 1 ")->row_array();
    }

    public function orderAttachmentBySerialNumber($orderNumber){
        return $this->db->query("SELECT * from order_attachments_integrated where order_attachments_integrated.Serial = $orderNumber order by ID ASC limit 1 ")->row_array();
    }


	
	function fetch_order_date($ordernumber){
	 $query = $this->db->query("select OrderDate from orders  where OrderNumber LIKE '".$ordernumber."' ")->row_array();
	 return $query['OrderDate'];
	}
	
	function calculate_minutes($fromdate,$todate){
		$todate   = date('Y-m-d H:i:s',$todate);
		$fromdate = date('Y-m-d H:i:s',$fromdate);
		
		$date1 = new DateTime($fromdate);
		$date2 = $date1->diff(new DateTime($todate));
		$minutes = ($date2->days * 24 * 60) + ($date2->h * 60) + $date2->i;
		return $minutes;
	}
	
	function calculate_min_days($mins){
		$hours = str_pad(floor($mins /60),2,"0",STR_PAD_LEFT);
		$mins  = str_pad($mins %60,2,"0",STR_PAD_LEFT);
	    $return = '';

		if((int)$hours > 24){
		 $days = str_pad(floor($hours /24),2,"0",STR_PAD_LEFT);
		 $hours = str_pad($hours %24,2,"0",STR_PAD_LEFT);
		}
		if(isset($days)) { $return = $days." days ";}
		if(isset($hours) && $hours!="00"){ $return.= $hours." hrs "; }
		
	    return $return.$mins." minutes";
    }
	
	function calculate_uptimer($previousdate){
		$todate   = date('Y-m-d H:i:s',time());
		$fromdate = date('Y-m-d H:i:s',$previousdate);
		
		$date1 = new DateTime($fromdate);
		$date2 = $date1->diff(new DateTime($todate));
		$hours = $date2->days * 24;
		$totalhours =  $hours + $date2->h;
		$minutes =  $date2->i;
		$seconds =  $date2->s;
		
		return array('hours'=>$totalhours,'minutes'=>$minutes,'seconds'=>$seconds);
	}
    
	function fetch_overall_jobtime($jobno){
		 $designer 			= $this->indivisual_timeline($jobno,"designer");
		 $designer_set   	= $this->calculate_min_days($designer);
		 
		 $customercare 		= $this->indivisual_timeline($jobno,"customercare");
		 $customercare_set   	= $this->calculate_min_days($customercare);
		 
		 
		 $customer		    = $this->indivisual_timeline($jobno,"customer");
		 $customer_set   	= $this->calculate_min_days($customer);
		 
		 $checklist 		= $this->indivisual_timeline($jobno,"checklist");
		 $checklist_set   	= $this->calculate_min_days($checklist);
		 
		 $factory		    = $this->indivisual_timeline($jobno,"factory");
		 $factory_set   	= $this->calculate_min_days($factory);
		 
		 return array(
		      'designer'           => $designer,
			  'customercare'       => $customercare,
			  'customer'           => $customer,
			  'checklist'          => $checklist,
			  'factory'            => $factory,
			  'designer_set'           => $designer_set,
			  'customercare_set'       => $customercare_set,
			  'customer_set'           => $customer_set,
			  'checklist_set'          => $checklist_set,
			  'factory_set'            => $factory_set,
			  );
 	}	

	function indivisual_timeline($jobno,$type){
	  if($type=="designer"){
	   $condition = "and type = 0 and Action != 19 and Action != 67";
	  }else if($type=="customercare"){
	   $condition = "and type = 1 and Action != 64";
	  }else if($type=="customer"){
	   $condition = "and type = 0 and Action = 67";
	  }else if($type=="checklist"){
	   $condition = "and ( Action = 19 || Action = 64)";
	  }else if($type=="factory"){
	   $condition = "and type = 2";
	  }
	  
	  $sql = $this->db->query("select SUM(time_taken) as minutes from artwork_timeline where Jobno = $jobno $condition ")->row_array();
	  //return $this->calculate_min_days($sql['minutes']);
	  return $sql['minutes'];
	}
	
	function commplete_jobtime($jobno,$type){
	 $condition = ($type=="customer")?"and Action != 67":"";
	 
	 $sql = $this->db->query("select SUM(time_taken) as minutes from artwork_timeline where Jobno = $jobno $condition ")->row_array();
	 return $this->calculate_min_days($sql['minutes']);
	}
  //------------------------------------------------STAR OF FILE----------------------------------------------------------	   
	
  function fetch_top_counter(){
	
	$query1 = $this->db->query("select count(*) as total from order_attachments_integrated INNER JOIN orders ON order_attachments_integrated.OrderNumber = orders.OrderNumber 
	where(orders.OrderStatus  = '55' OR orders.OrderStatus  = '56') AND  order_attachments_integrated.Brand LIKE 'Rolls'")->row_array();
	$rolltotal = $query1['total'];
	
	$query2 = $this->db->query("select count(*) as total from order_attachments_integrated INNER JOIN orders ON order_attachments_integrated.OrderNumber = orders.OrderNumber where(orders.OrderStatus  = '55' OR orders.OrderStatus  = '56') AND  order_attachments_integrated.Brand NOT LIKE 'Rolls'")->row_array();
	$sheettotal = $query2['total'];
	
	
	$to   = date('Y-m-d').' 00:00:00';
    $from = date('Y-m-d').' 23:59:59';
  
	 $query3 = $this->db->query("SELECT count(*) as total FROM `status_change_log` as `o` 
 inner join `order_attachments_integrated` as `od` on `o`.`OrderNumber` = `od`.`OrderNumber`
 WHERE o.OrderStatus_old = 56 AND o.OrderStatus_new = 32 AND `o`.`Date` >UNIX_TIMESTAMP('".$to."') AND `o`.`Date` <UNIX_TIMESTAMP('".$from."')")->row_array();
        $ordertotal = $query3['total'];
		
		 $total_artworks =  $this->fetchorders_all();
		 $total_lines = count($total_artworks);
		 
		 $total_artworks = $rolltotal + $sheettotal;
		 
		 $customercare_r = $this->get_brandwis_rolls(0);
		 $customercare_s = $this->get_brandwise_sheets(0);
		 
		 $desginer_r = $this->get_brandwis_rolls(1);
		 $desginer_s = $this->get_brandwise_sheets(1);
		 
		 $customer_r = $this->get_brandwis_rolls(2);
		 $customer_s = $this->get_brandwise_sheets(2);
		 
		 $checklist_r = $this->get_brandwis_checklist_roll();
		 $checklist_s = $this->get_brandwis_checklist_sheet();
		 
		 
		 
		 return array('roll_jobs'=>$rolltotal,'sheet_jobs'=>$sheettotal,'moved_jobs'=>$ordertotal,'total_jobs'=>$total_artworks,
		 'customercare_r'=>$customercare_r,'customercare_s'=>$customercare_s,'designer_r'=>$desginer_r,'designer_s'=>$desginer_s,
		 'customer_r'=>$customer_r,'customer_s'=>$customer_s,'checklist_r'=>$checklist_r,'checklist_s'=>$checklist_s,'total_lines'=>$total_lines);
	}
	
	function get_brandwis_rolls($type){
	 $query2 = $this->db->query("select count(*) as total from order_attachments_integrated INNER JOIN orders ON order_attachments_integrated.OrderNumber = orders.OrderNumber 
	where(orders.OrderStatus  = '55' OR orders.OrderStatus  = '56') AND  order_attachments_integrated.Brand LIKE 'Rolls' and order_attachments_integrated.action = $type AND  order_attachments_integrated.checklist = '1' and  order_attachments_integrated.status !=7 ");
	 $query2 = $query2->row_array();
	  return $query2['total'];
	}
	function get_brandwise_sheets($type){
	 $query2 = $this->db->query("select count(*) as total from order_attachments_integrated INNER JOIN orders ON order_attachments_integrated.OrderNumber = orders.OrderNumber 
	where(orders.OrderStatus  = '55' OR orders.OrderStatus  = '56') AND  order_attachments_integrated.Brand NOT LIKE 'Rolls' and order_attachments_integrated.action = $type AND  order_attachments_integrated.checklist = '1' and order_attachments_integrated.status !=7 " );
	 $query2 = $query2->row_array();
	 return $query2['total'];
	}
	function get_brandwis_checklist_sheet(){
	 $query2 = $this->db->query("select count(*) as total from order_attachments_integrated INNER JOIN orders ON order_attachments_integrated.OrderNumber = orders.OrderNumber 
	where(orders.OrderStatus  = '55' OR orders.OrderStatus  = '56') AND  order_attachments_integrated.checklist = '0'AND order_attachments_integrated.Brand NOT LIKE 'Rolls'
	  and order_attachments_integrated.status !=7 " );
	 $query2 = $query2->row_array();
	  return $query2['total'];
	}
	function get_brandwis_checklist_roll(){
	 $query2 = $this->db->query("select count(*) as total from order_attachments_integrated INNER JOIN orders ON order_attachments_integrated.OrderNumber = orders.OrderNumber 
	where(orders.OrderStatus  = '55' OR orders.OrderStatus  = '56') AND  order_attachments_integrated.checklist = '0' AND order_attachments_integrated.Brand LIKE 'Rolls'
	  and order_attachments_integrated.status !=7 " );
	 $query2 = $query2->row_array();
	  return $query2['total'];
	}
	
 //------------------------------------------------STAR OF FILE----------------------------------------------------------	   
	function fetch_total_attach($ordernumber,$type=NULL){
		$userid = $this->session->userdata('UserID');
	    $usertypeid = $this->session->userdata('UserTypeID');
		
	 
	     $ordersdata = $this->order_and_attachments_join($ordernumber);
		 $condition = "";	
		 if($ordersdata['designer'] == DESIGNER && $userid != DESIGNER && $usertypeid != 23 && $usertypeid != 1 && $usertypeid != 50){
		   $condition = "and  (designer = $userid )";
		 }
		 
		 if(isset($type) && $type=="rejected"){
		  $condition.= " and  rejected = 1";
		 }
	 
	 $query = "select * from order_attachments_integrated  where OrderNumber like '".$ordernumber."' $condition and source!= 'flash' ";
	 return $this->db->query($query)->result();
	}
	
		function fetch_total_attach_flash($ordernumber,$type=NULL){
		$userid = $this->session->userdata('UserID');
	    $usertypeid = $this->session->userdata('UserTypeID');
		
	 
	     $ordersdata = $this->order_and_attachments_join($ordernumber);
		 $condition = "";	
		 if($ordersdata['designer'] == DESIGNER && $userid != DESIGNER && $usertypeid != 23){
		   $condition = "and  (designer = $userid )";
		 }
		 
		 if(isset($type) && $type=="rejected"){
		  $condition.= " and  rejected = 1";
		 }
	 
	 $query = "select * from order_attachments_integrated  where OrderNumber LIKE '".$ordernumber."' $condition  ";
	 return $this->db->query($query)->result();
	}
	
	
	
	function fetch_order_print_lines($ordernumber){
	 $query = "select * from orderdetails where OrderNumber LIKE '".$ordernumber."' and Printing LIKE 'Y' and source NOT LIKE 'flash' ";
	 return $this->db->query($query)->result();
	}

	function fetch_order_print_job($serialNumber){
	 $query = "select * from orderdetails where SerialNumber LIKE '".$serialNumber."' and Printing LIKE 'Y' and source NOT LIKE 'flash' ";
	 return $this->db->query($query)->result();
	}
	
	function is_ProductBrand_roll($id){
	    $query = $this->db->query("select  ProductBrand,LabelsPerSheet from products  where ManufactureID='".$id."'");
		$res = $query->row_array();
	
		if(preg_match("/Roll Labels/i",$res['ProductBrand'])){
		  $roll = 'yes'; 	
		}else{ $roll = 'No';}
		return array('Roll'=>$roll,'LabelsPersheet'=>$res['LabelsPerSheet'],'ProductBrand'=>$res['ProductBrand']);
		
	}	

	function make_productBrand_condtion($type){
	    if(preg_match("/SRA3/i",$type)){
		  $brand = 'SRA3';
		}else if(preg_match("/A3/i",$type)){
		  $brand = 'A3';
		}else if(preg_match("/Roll/i",$type)){
		  $brand = 'Rolls';
		}else if(preg_match("/Integrated/i",$type)){
		  $brand = 'Integrated';
		}else{
		  $brand = 'A4';	
		}
		return $brand;	
	}
	
 //------------------------------------------------STAR OF FILE----------------------------------------------------------	   
  function fetch_order_comments($order){
   $qry = $this->db->query("select * from artwork_comments where OrderNumber LIKE '".$order."' order by ID Desc ")->result();
   return $qry;
	}
  function fetch_order_comments_grouped($order){
   $qry = $this->db->query("select count(*) as total from artwork_comments where OrderNumber LIKE '".$order."' ")->row_array();
   $total_comments = $qry['total'];
   $unread_comments =  $this->fetch_order_comments_unread($order);
   return array('total_comments'=>$total_comments,'unread_comments'=>$unread_comments);
  }
  function fetch_order_comments_unread($order){
   $qry = $this->db->query("select count(*) as total from artwork_comments where OrderNumber LIKE '".$order."' and marked = 0")->row_array();
   return $qry['total'];
  }
 //------------------------------------------------STAR OF FILE----------------------------------------------------------	   
	function fetch_slowartwork($order){
	 $check = $this->db->query("select * from order_attachments_integrated where OrderNumber LIKE '".$order."' and checklist = '0' order by status asc limit 1")->row_array();
	   if(empty($check)){
	   $check = $this->db->query("select * from order_attachments_integrated where OrderNumber LIKE '".$order."' order by status asc limit 1")->row_array();
	   }
	   return $check;
	}
	
	
	function fetch_group_productid($order){
	 return $this->db->query("SELECT GROUP_CONCAT( Distinct ProductID SEPARATOR ',' ) AS ProductID from orderdetails where OrderNumber LIKE '".$order."' and ProductID!=0 ")->row_array();
	}
	
	
	
	
	
	function fetch_listing_tags($order){
	 $productids = $this->fetch_group_productid($order);
	 if($productids==""){
	  return '';
	 }
	 
	   $productid = $productids['ProductID'];
	   $colors = $this->db->query("select GROUP_CONCAT( Distinct LabelColor_upd SEPARATOR ',' ) AS colors from products where ProductID IN ($productid) and ProductID!=0")->row_array();
	   
	   
	   $categorydata = $this->db->query("select LabelTopMargin,LabelBottomMargin,LabelLeftMargin,LabelRightMargin,LabelGapAcross,LabelGapAround  from category c inner join products as p where SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID  and p.ProductID IN ($productid) and p.ProductID!=0 GROUP BY c.CategoryID")->result();
	 //  echo "<pre>"; print_r($categorydata); echo "</pre>"; die();
	 
	  $variable_data = $this->db->query("select count(*) as total from order_attachments_integrated where OrderNumber LIKE '".$order."' and variable_data = 1 limit 1")->row_array();
	  
	   
	 return array('colors'=>$colors['colors'],'bleed'=>'yes','variable_data'=>$variable_data['total']);
  }

 //------------------------------------------------STAR OF FILE-------------------------------------------------------------------------	   
 
	function order_and_attachments_join($order){
	  return $this->db->query("select * from orders where OrderNumber LIKE '".$order."' ")->row_array();
	}
	
	function fetch_attachment_counter($order){
	
	$query1 = $this->db->query("select count(*) as total from order_attachments_integrated  where OrderNumber LIKE '".$order."' AND  order_attachments_integrated.Brand LIKE 'Rolls'")->row_array();
	$rolltotal = $query1['total'];
	
	$query2 = $this->db->query("select count(*) as total from order_attachments_integrated  where OrderNumber LIKE '".$order."' AND  order_attachments_integrated.Brand NOT LIKE 'Rolls'")->row_array();
	$sheettotal = $query2['total'];
        
		$total_artworks    = $sheettotal + $rolltotal;
		return array('roll_jobs'=>$rolltotal,'sheet_jobs'=>$sheettotal,'total_jobs'=>$total_artworks);
  }
	
	function get_operator($operator){
	 $qry = $this->db->query("select UserName from customers where UserID = '".$operator."' ");
	 $data = $qry->row_array();
	 return $data['UserName']; 
    }
	
	function fetch_status_action($status){
	 $qry = $this->db->query("select StatusTitle , Action from dropshipstatusmanager where StatusID = $status ")->row_array();
	 return $qry;
	}
	
	 function fetch_one_artwork($id){
		return $this->db->query("select * from order_attachments_integrated where ID = $id")->row_array();
	  }
	  
	   function check_orderdetail($order){
	    $qry = $this->db->query("select * from orderdetails where SerialNumber = '".$order."' ");
	    return $qry->row_array();
	 }
	
	 function getmaterialcode($text){
		preg_match('/(\d+)\D*$/', $text, $m);
		$lastnum = $m[1];
		$mat_code = explode($lastnum,$text);
		return strtoupper($mat_code[1]);
	}
	  function fetch_chat_artwork($id){
	    $qry = $this->db->query("select * from artwork_chat where attach_id = $id order by ID desc");
	    return $qry->result();
	 }
	 
	 function fetch_artworks_timeline($jobno){
	   $qry = $this->db->query("select * from artwork_timeline where Jobno = $jobno order by Time Desc ")->result();
	   return $qry;
	}
	
	function fetchchatmembers($operator,$jobno,$ordernumber){
	    $qry = $this->db->query("select * from customers where UserID = $operator ")->row_array();
		$sender = $qry['UserName'];
		
		if($qry['UserTypeID']==88){
		  $result = $this->db->query("select UserName from customers inner join orders on customers.UserID = orders.assigny where OrderNumber LIKE '".$ordernumber."' ")->row_array();
		  $receiver = $result['UserName'];
		}else{
		  $result = $this->db->query("select UserName from customers inner join order_attachments_integrated on customers.UserID = order_attachments_integrated.designer where order_attachments_integrated.ID = $jobno ")->row_array();
		  $receiver = $result['UserName'];
		}
		
		return array('sender'=>$sender,'receiver'=>$receiver);
	}
	
	public function view_feedback($jobno){
	  return $this->db->query("select * from customer_artwork_feedback WHERE jobno = $jobno order by ID desc")->result();
	}
	
	public function groupconcatjobs($order,$type){ 
		if(isset($type) && $type=="rejected"){
			
		 return $this->db->query("select GROUP_CONCAT( Distinct ID SEPARATOR ',' ) AS jobs from order_attachments_integrated where OrderNumber LIKE '".$order."' and  is_upload_print_file = 1 and rejected = 1 and status = 70 order by ID asc")->row_array();
		
		}else{
			
	 return $this->db->query("select GROUP_CONCAT( Distinct ID SEPARATOR ',' ) AS jobs from order_attachments_integrated where OrderNumber LIKE '".$order."' and  ( ( (softproof = '' || softproof is null)  and status = 66)  ||  status = 69 ) order by ID asc")->row_array();
		}
		
	}

    public function getchatdetails($type,$id){
	   $query = "select * from artwork_chat where attach_id = $id and $type != '' order by ID desc limit 1 ";
	   $query = $this->db->query($query);
	   return $query->row_array();	
	 }	
	 
	public function addrejectioncomment($jobno,$comment){ 
	      $array = array(
				'attach_id'=>$jobno,
				'operator'=>$this->session->userdata('UserID'),
				'comment'=>$comment
			);
	      $this->db->insert('artwork_chat',$array);
	}
	
	 public function fetchtemplate($id){
	   $query = $this->db->query("select template from order_attachments_integrated where Serial = $id")->row_array();
	   return $query['template'];	
	 }	
	
	function search_records($designer,$product,$file,$date){
	   $date1     = explode('-',$date);
	   $startdate = explode('/',$date1[0]);
	   $enddate   = explode('/',$date1[1]);
	   $From = trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00';
	   $To   = trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59';
	   
	
		$where = "ch.time > '".$From."' and ch.time < '".$To."' AND ch.operator = $designer";
		if($product=="both"){ //$where.= " AND (at.Brand LIKE 'Rolls' or at.Brand LIKE 'A4')"; 
		}else{ $where.= " AND at.Brand LIKE '".$product."'"; }
		if($file=="both"){ //$where.= " AND (ch.softproof != '' or ch.file != '' )";
		}else if($file=="softproof"){ $where.= " AND ch.softproof != ''";
		}else if($file=="print"){ $where.= " AND ch.file != ''"; }
		
		
		
	   $qry = "SELECT at.Brand as Brand,ch.softproof as softproof, ch.file as file FROM artwork_chat ch inner join order_attachments_integrated at on at.ID = ch.attach_id where $where ";
	   $orders = $this->db->query($qry)->result();
	        //echo "<pre>"; print_r($orders); echo "</pre>";
		    $rolls = $sheets = $softproof = $printfile = 0;
			foreach ($orders as $item) {
			  if ($item->Brand == 'Rolls') {
				  $rolls++;
			  }
			  if ($item->Brand != 'Rolls') {
				  $sheets++;
			  }
			  if ($item->softproof != '') {
				  $softproof++;
			  }
			  if ($item->file != '') {
				  $printfile++;
			  }
			}

       // echo $rolls.'--'.$sheets.'--'.$softproof.'--'.$printfile.'--';
		$total = $rolls + $sheets;
		//echo $total;
	   // die();
	   
	   return array('total'=>$total,
	                'rolls'=>$rolls,
					'sheets'=>$sheets,
					'softproof'=>$softproof,
		            'printfile'=>$printfile,
					//'production'=>$production
					);
	 }
	
	
	 // ------------------------------------REJECTED SECTION---------------------------------------------
	 function fetchRejectedOrders($start,$limit){
        return  $this->db->select("p.ProductBrand,o.OrderNumber,concat(o.DeliveryFirstName,' ',o.DeliveryLastName) as name,o.DeliveryCountry,o.format,o.designer,o.assigny,o.site")
            ->from('orders as o')
            ->join('order_attachments_integrated as oai', 'oai.OrderNumber = o.OrderNumber','left')
            ->join('products as p', 'p.ProductID = oai.ProductID','left')
            ->where('oai.rejected',1)
            ->group_by('o.OrderNumber')
            ->order_by('o.OrderNumber','asc')
            ->limit($limit,$start)
            ->get()->result();
    }
	
	// -------------------------------------------------------------------------------------------

   function ifapprovelneeded($order){
	$query1 = $this->db->query("select count(*) as total from order_attachments_integrated  where OrderNumber LIKE '".$order."' AND  order_attachments_integrated.status = 67 ")->row_array();
	return $query1['total'];
  }














	 function fetch_artworks(){
		$qry = $this->db->query("select * from order_attachments_integrated where source like 'web' or source like 'flash' or source like 'backoffice'");
	    return $qry->result();
	  }
	  
	
	
	  
	  function check_line_status($order){
	    $qry = $this->db->query("select * from order_attachments_integrated where OrderNumber LIKE '".$order."' and  status != 58");
	    return $qry->result();
	 }
	 
	 
	 
	 function fetch_order_status($order){
		$qry = $this->db->query("select OrderStatus from orders where OrderNumber LIKE '".$order."' ")->row_array();
	    return $qry['OrderStatus'];
	  }
	  
	  

    function fetch_order_no($val){
		
		$this->db->limit('20');

		$this->db->select('OrderNumber') 
        ->like('OrderNumber',$val);
        $row = $this->db->get('orders');

		$row = $row->result();  
        foreach($row as $row){
			$data[]= array( 
			'label' => $row->OrderNumber
          ); 
	    };

		return $data;
	}
	
	
	
	
	
	
	
	
	
	
	 function fetch_next_job($order){
	   $qry = $this->db->query("select * from order_attachments_integrated where OrderNumber LIKE '".$order."' and  ( (status = 66 and softproof ='') or (status = 69) )  limit 1");
		
		return $qry->row_array();
	}
	 
	
	 function fetch_job_checklist($jobno){
	   $qry = $this->db->query("select * from artwork_checklist where jobno LIKE '".$jobno."' order by ID Desc ")->row_array();
	   return $qry;
	}

     public function fetch_maxref($id){
		$query = $this->db->query("SELECT MAX(ref) as max from artwork_chat where attach_id = $id ")->row_array();
		return $query['max'];
	}
	 function fetch_current_chat($id,$ref){
	   $query = $this->db->query("select * from artwork_chat where attach_id = $id and ref = $ref ");
	   return $query->row_array();	
	 }

	
	
	function fetch_customer_versions_newall($id)
    {
		 $query = $this->db->query("SELECT *, (select Brand from order_attachments_integrated WHERE ID = $id) as Brand, (select MAX(ID) from artwork_chat WHERE attach_id = $id and (artwork_chat.softproof != NULL or artwork_chat.softproof != '')) as curr FROM `artwork_chat` WHERE attach_id = $id and (artwork_chat.softproof != NULL or artwork_chat.softproof != '') having ID !=curr ORDER BY `artwork_chat`.`ID` DESC");
		$res = $query->result();
		return $res;
	}
	
	
	function getTopComments($id){
		$query = $this->db->query("SELECT *, (select Brand from order_attachments_integrated WHERE ID = $id) as Brand FROM customer_artwork_feedback WHERE jobno = $id ORDER BY ID DESC");
		$res = $query->result();
		return $res;
	}
	
	function getTopCommentsDeclineComments($id)
    {
		$query = $this->db->query("SELECT * FROM `artwork_chat` WHERE attach_id = $id and (artwork_chat.softproof = NULL or artwork_chat.softproof = '') and ref = 0 ORDER BY `artwork_chat`.`ID` DESC");
		$res = $query->result();
		return $res;
	}

	   public function single_feild($select,$where,$table)
    {
         $this->db->select( $select );
        $this->db->from( $table );
        $this->db->where( $where );
        $qry = $this->db->get();
        $rr	=	$qry->row_array();

        return	$rr[$select];
    }
	
	
	
	
	// NAFEES LA WORK STARTS
		function getOrderDetailsBySerial($orderSerial = NULL){
			if( $orderSerial ) {
				$qry = $this->db->query("select * from orderdetails where SerialNumber = '".$orderSerial."' ")->row_array();
		 		return $qry;
			}
		}

		public function getDirectoryName($parent_id) {

	 		if( isset($parent_id) && $parent_id != '' ) {
	 			if( $parent_id == 1 ) {
	 				return array("laminations_varnishes/", "laminations_and_varnishes");
	 			} else if( $parent_id == 2 ) {
	 				return array("hot_foil/", "hot_foil");
	 			} else if( $parent_id == 3 ) {
	 				return array("embossing_debossing/", "embossing_and_debossing");
	 			} else if( $parent_id == 4 ) {
	 				return array("silkscreen_print/", "silk_screen_print");
	 			} else if( $parent_id == 5 ) {
	 				return array("sequential_and_variable_data/", "sequential_and_variable_data");
	 			}
	 		} else {
	 			return array("error", "error");
	 		}
	 		
	 	}

	// NAFEES LA WORK ENDS
	
	
	
	
	
	
	
	
	
	
	
	
	
}

