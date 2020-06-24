<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artworks extends CI_Controller {

	
	function __construct(){
	 parent::__construct();	
	 $this->load->database();
	 $this->load->model('Artwork_model');
	 $this->load->model('Home_model');
	 $this->home_model->user_login_ajax();
	 //$this->load->model('Rejected_artwork_model');
      //error_reporting(-1);
        //ini_set('display_errors', 1);
     //error_reporting(E_ALL);
     
	// $this->session->set_userdata('UserName','kamran');
	// $this->session->set_userdata('UserID','640847'); //640847 // 641147 
	//$this->session->set_userdata('UserTypeID','1');
     
    }
//------------------------------------------------MAIN LISTING----------------------------------------------------------	   

  public function index_old(){
	$data['start'] = 0;
	$data['result'] = $this->Artwork_model->fetchorders($data['start'],5);
	$data['main_content'] = "artwork/artworks";
	$this->load->view('page',$data);
  }
  
  public function index(){
    $data['result'] = $this->Artwork_model->fetchorders_all();

    $data['main_content'] = "artwork/artworks";
    $this->load->view('page',$data);
 }

  public function history(){
   if(isset($_GET['order']) && $_GET['order']!=""){
	 $_GET['order'] = trim($_GET['order']);
	 $data['result'] = $this->Artwork_model->fetch_total_attach_flash($_GET['order']);
	 $data['orders_data'] = $this->Artwork_model->order_and_attachments_join($_GET['order']);
	}
    $data['main_content'] = "artwork/history";
	$this->load->view('page',$data);
  }

  public function fetch_top_counter(){
   $result = $this->Artwork_model->fetch_top_counter();
   echo json_encode($result);
  }

  public function fetch_artworks_jobs(){
   $start = $this->input->post('start');
   $data['start'] = $start;
   $data['result'] = $this->Artwork_model->fetchorders($start,5);
   $theHTMLResponse = $this->load->view('artwork/ajax/fetch_artworks',$data,true);
   $json_data = array('html'=>$theHTMLResponse);
   echo json_encode($json_data);
  }

  public function attachments($orderno,$type=NULL){ 
	$data['ordertype']    = $type;
	$data['orderinfo']    = $this->Artwork_model->order_and_attachments_join($orderno);
	$data['printjobs']    = $this->Artwork_model->fetch_total_attach($orderno,$type);
	$data['counter']      = $this->Artwork_model->fetch_attachment_counter($orderno);
	$data['printjob']     = @$data['printjobs'][0]->ID;
	$data['row']     = $this->Artwork_model->fetch_one_artwork($data['printjobs'][0]->ID);
	$data['result']  = $result = $this->Artwork_model->fetch_chat_artwork($data['printjobs'][0]->ID);
	$data['main_content'] = "artwork/viewjobs";	
	$this->load->view('page',$data);	
  }

 //------------------------------------------------ADD ARTWORK SECTION ----------------------------------------------------------	   
 
  public function add_artwork($order){
	$data['order'] = $order; 
	$data['data']  = $this->Artwork_model->fetch_total_attach($order);  
	$data['rows']  = $this->Artwork_model->fetch_order_print_lines($order);
	$data['main_content'] = 'artwork/add_artwork';
	$this->load->view('page', $data);
	}
	
  public function check_attachment_entry(){
	 $serial   = $this->input->post('serial'); 
	 $type = 'sheet'; 
	 
	 $sql = $this->db->query("select Print_Qty as total,ProductName from orderdetails WHERE SerialNumber = $serial ")->row_array();
	 $qry = $this->db->query("select count(*) as total from order_attachments_integrated WHERE Serial = $serial ")->row_array();
	 $total = ($sql['total']==0)?1:$sql['total'];
	 $response = ($total == $qry['total'])?'false':'true';
	  if(preg_match('/roll/is',$sql['ProductName'])){
		$type = 'rolls';  
	   }
	echo json_encode(array('response'=>$response,'type'=>$type));
  }
  
  public function quantity_add_artwork(){
     $qty       = $this->input->post('qty'); 
	 $diecode   = $this->input->post('diecode'); 
	 $serial    = $this->input->post('serial');
	 $response  = "true"; 
	 $msg = "";
	 $type = "Rolls";
	 $minqty = $qty;
	 $labels = 0;
	 
	 $prod = $this->db->query("select LabelsPerSheet from products where ManufactureID LIKE  '".$diecode."'")->row_array();
	 $lps = $prod['LabelsPerSheet'];  
	 
	 $query1 = $this->db->query("select Quantity,ProductName from orderdetails where SerialNumber = $serial")->row_array();
	 
	 if(!preg_match('/roll/is',$query1['ProductName'])){
	   $type = "Sheets";
	 }
	
	 if($response == "true"){
		  $query2 = $this->db->query("select sum(qty) as total from order_attachments_integrated where Serial = $serial")->row_array();
		  $total_sheets = $query1['Quantity'];  $used_sheets = $query2['total'];
		  $remain_sheets =  $total_sheets - $used_sheets;
		    if($remain_sheets==0){   $msg = "Maximum ".$type." Quantity Reached. Can't Add more ".$type; $response  = "false"; $minqty = 0;}
			if($remain_sheets<$qty){ $msg = "Can Add Maximun of ".$remain_sheets." ".$type; $response  = "false"; $minqty = $remain_sheets;}
		}
		
		if(!preg_match('/roll/is',$query1['ProductName'])){
		   $labels = $lps*$minqty;  
		}
	 
	   echo json_encode(array('response'=>$response,'msg'=>$msg,'minqty'=>$minqty,'labels'=>$labels));
	}
  
  public function checkforname(){
	 $name   = $this->input->post('name'); 
	 $order  = $this->input->post('order');
	 $response  = "true"; 
	 
	  $query2 = $this->db->query("select count(*) as total from order_attachments_integrated where name = '".$name."' and OrderNumber = '".$order."' ")->row_array();
	  if($query2['total']>0){
		  $response  = "false"; 
		 }
	 echo json_encode(array('response'=>$response,'msg'=>'Artwork Name Already Taken in this Order.'));
	}

	
	
	  public function verify_rolllabels(){
		
     $labels    = $this->input->post('labels');
	 $diecode   = $this->input->post('diecode');
	 $serial    = $this->input->post('serial');
	 $sheets    = $this->input->post('sheets');
	 $response  = "true";
	 $msg = "";
	 $applabels = $labels;
	 
     $query1 = $this->db->query("select Quantity,ProductName,LabelsPerRoll,labels from orderdetails where SerialNumber = $serial")->row_array();
	 $total_labels = $query1['labels'];


      $diacross = $this->Home_model->min_qty_roll($diecode);
      $min_allowed = ceil(100/$diacross);

      if(($labels / $sheets) < $min_allowed){
          $response = "false";
          $msg = "Can Add Minimum of ".$min_allowed." Labels per roll";
          $applabels = $min_allowed * $sheets;
      }



	 if($response == "true"){
		  $query2 = $this->db->query("select sum(labels) as total from order_attachments_integrated where Serial = $serial")->row_array();
		  $used_labels = $query2['total'];
		  $remain_labels =  $total_labels - $used_labels;
		  
		    if($remain_labels==0){   $msg = "Maximum Labels Quantity Reached. Can't Add more Labels"; $response  = "false"; }
			if($remain_labels<$labels){ $msg = "Can Add Maximum of ".$remain_labels." Labels"; $response  = "false"; $applabels = $remain_labels;}
		}
		
	 echo json_encode(array('response'=>$response,'msg'=>$msg,'labels'=>$applabels));
	} 
	
	
	
   public function delete_line(){
	  if($_POST['jobno']){   
		$jobno  = $this->input->post('jobno'); 
		$qry = $this->db->query("select * from order_attachments_integrated WHERE ID = $jobno ")->row_array();
		unlink(ARTPATH.'integrated_attach/'.$qry['file']);
	  if(isset($qry['ID']) && $qry['ID']!="" && $qry['ID']!=0 && $qry['ID']!='0'){	
	 	$this->db->where('ID',$jobno);
		$this->db->delete('order_attachments_integrated');
	  }	
		echo json_encode(array('response'=>'yes'));
	  }else{
	    echo json_encode(array('response'=>'no')); 
	  }
  }
  
     
	 public function add_Artwork_form(){
		 if(isset($_FILES['file_up']) and $_FILES['file_up']!=''){
		   $order = $this->input->post('order');
		   $diecode = $this->input->post('diecode');
		   $sheets = $this->input->post('sheets');
		   $labels = $this->input->post('labels');
		   $name = $this->input->post('name');
		   $Serial = $this->input->post('serial');
		   $ProductID = $this->input->post('pro_id');


	        $config['upload_path'] = ARTPATH.'integrated_attach/';
	        $config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx|psd|tiff|tif';
		    $config['max_size']	= '200000';
			$this->load->library('upload', $config);
			$field_name = "file_up";



             /*if (file_exists(ARTPATH.'integrated_attach/'.$_FILES['file_up']['name'])) {
                 @unlink(ARTPATH.'integrated_attach/'.$_FILES['file_up']['name']);
                 print_r($_FILES['file_up']['name']); exit;
             }*/

			if($this->upload->do_upload($field_name)){
				$data = array('upload_data' => $this->upload->data());
				$imagename = $data['upload_data']['file_name'];
                //print_r($imagename); exit;
				$brand = $this->Artwork_model->is_ProductBrand_roll($diecode);
				$brand = $this->Artwork_model->make_productBrand_condtion($brand['ProductBrand']);
				
				 $insert = array(
				  'OrderNumber'=>$order,
				  'Serial'=>$Serial,
				  'ProductID'=>$ProductID,
				  'diecode'=>$diecode,
				  'qty'=>$sheets,
				  'labels'=>$labels,
				  'design_type'=>'Fullcolour',
				  'name'=>$name,
				  'status'=>64,
				  'Brand'=>$brand,
				  'source'=>'backoffice',
				  'Operator'=>$this->session->userdata('UserName'),
				  'lastmodified'=>time(),
				  'action'=>0,
				  'file'=>$imagename,
				  'CO'=>1,
				  'version'=>1
			   );
			 
			  $this->db->insert('order_attachments_integrated',$insert);
			  $id = $this->db->insert_id();
			  $return = (isset($id) && $id!='')?$id:'insertion error';
			  $this->db->where('OrderNumber',$order);
			  $this->db->update('orders',array('OrderStatus'=>55));
			  $data['datas'] =  $return; 
			  echo json_encode($data); 
		   }else{ echo json_encode(array('error'=>$this->upload->display_errors()));  }
		}	
	 }
	 
    
  //------------------------------------------------START OF THE COMMENT SECTION----------------------------------------------------------	-----   
   public function fetch_comments(){
	  $order = $this->input->post('order');
	  $this->db->where('OrderNumber',$order);
	  $this->db->update('artwork_comments',array('marked'=>1));
	  $this->comment_controller($order);
  }
  
   public function save_comment(){
	  $order = $this->input->post('order');
	  $comment = $this->input->post('comment');
	  $table = "artwork_comments";
	  $path = "artwork/ajax/comments";
	  
	  $array = array(
	        'OrderNumber'=>$order,
			'comment'=>$comment,
			'Operator'=>$this->session->userdata('UserID'),
			'Time'=>time(),
			"comment_type"=>"manual"
			);
	   $this->db->insert($table,$array);
	   $this->comment_controller($order);
	 }
  
   public function delete_comment(){
	  $order = $this->input->post('order');
	  $id = $this->input->post('id');
	   
	  $this->db->where('ID',$id);
	  $this->db->delete('artwork_comments');
	  $this->comment_controller($order);
  }
  
   public function comment_controller($order){  
      $data['order']  = $order;
	  $data['data']   = $this->Artwork_model->fetch_order_comments($order); 
	  
	  $comments = $this->Artwork_model->fetch_order_comments_grouped($order);
	  $theHTMLResponse = $this->load->view('artwork/ajax/comments',$data,true);
	  $json_data = array('html'=>$theHTMLResponse,'allcount'=>$comments['total_comments'],'unreadcount'=>$comments['unread_comments']);
	  $this->output->set_content_type('application/json');	
	  $this->output->set_output(json_encode($json_data));
   }

  //------------------------------------------------START OF THE ASSIGN SECTION----------------------------------------------------------	
	   public function move_production($order){
	       
	   /*$isOrderRollPrintLabelTrue = $this->home_model->isOrderRollPrintLabelTrue($order);
        if ($isOrderRollPrintLabelTrue) { $orderStatus = 38; } else { $orderStatus = 32;}*/

        $orderStatus = 32;

		$this->db->where('OrderNumber',$order);
		$this->db->update('orders', array('OrderStatus'=>$orderStatus,'Old_OrderStatus'=>''));
	
		$insert = array(
			  'OrderNumber'=>$order,
			  'OrderStatus_new'=>$orderStatus,
			  'OrderStatus_old'=>56,
			  'Oprator'=>$this->session->userdata('UserName'),
			  'SALE_ID'=>$this->session->userdata('UserID'),
			  'Date' => time()
			  );
		$this->db->insert('status_change_log',$insert);
		
		$this->db->where('OrderNumber',$order);
		$this->db->update('order_attachments_integrated', array('moved'=>1));
			
		$this->updatedesigner_onattachments($order,0,70,1);
	
		$this->session->set_userdata('moved','yes');
		//header('Content-Type: application/json');
        //echo json_encode('success');
		redirect(main_url."Artworks");
	  }
	  
     public function assign_to($field,$order,$value){
		//$UserID = $this->session->userdata('UserID');  
		$this->db->where('OrderNumber',$order);
		$this->db->update('orders', array($field=>$value));
		 if($field=="designer"){
			$this->db->where('OrderNumber',$order);
		    $this->db->update('order_attachments_integrated', array($field=>$value)); 
		    $this->updatedesigner_onattachments($order,$value,18,0);
		 }
		redirect(main_url."Artworks");
	  }
	  public function assignjob_to($field,$jobno,$value){ 
		$this->db->where('ID',$jobno);
		$this->db->update('order_attachments_integrated', array($field=>$value));
		//$this->printjobcontroller($jobno);
		echo "true";
	  }
	  
	    function updatedesigner_onattachments($order,$value,$status,$user){
	     $attachments = $this->Artwork_model->fetch_total_attach($order);
		 $data = array();
		  
		   foreach($attachments as $row){
			   $recentjob = array();
			   $recentjob = $this->Artwork_model->fetch_jobtimeline($row->ID);
			   if(count($recentjob)== 0){ $recentjob['Time'] = $this->Artwork_model->fetch_order_date($order); }
	           $minutes = $this->Artwork_model->calculate_minutes($recentjob['Time'],time());
	           $minutes = ($minutes == 0)?1:$minutes;
		     $data[] = array(
				    'Jobno'    => $row->ID,
				    'operator' => $this->session->userdata('UserID'),
				    'Action'   => $status,
					'Time'     => time(),
					'designer' => $value,
					'Version'  => $row->version,
					'type'     => $user,
					'time_taken' => $minutes
				  );
	          }
			  $this->db->insert_batch('artwork_timeline',$data); 
		}
		
		 public function openprintjob(){
	      $jobno = $this->input->post('jobno');
		  $this->printjobcontroller($jobno);
	    }
  //------------------------------------------------START OF THE CHECKLIST SECTION----------------------------------------------------------	
       public function fetch_chekclist(){
		 $jobno = $this->input->post('jobno');
		 $data['jobno']  = $jobno;
		 $data['data']  = $this->Artwork_model->fetch_artworks_timeline($jobno); 
		 
	     $theHTMLResponse = $this->load->view('artwork/ajax/checklist',$data,true);
		 $json_data = array('html'=>$theHTMLResponse);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	 }
	  public function add_checklist(){


	    $jobno = $this->input->post('jobno'); 
		$q1 = $this->input->post('q1'); 
		$q2 = $this->input->post('q2'); 
		$q3 = $this->input->post('q3'); 
		$q4 = $this->input->post('q4'); 
		$q5 = $this->input->post('q5');
		$q6 = $this->input->post('q6'); 
		$q7 = $this->input->post('q7'); 
		$q8 = $this->input->post('q8'); 
		$q9 = $this->input->post('q9'); 
		$comment = $this->input->post('comment'); 
		
		$jobdetail = $this->db->query("select * from order_attachments_integrated where ID = $jobno")->row_array();
		$ver = $jobdetail['version'];
		 
	    $array = array(
		        'jobno'=>$jobno,
				'Operator'=>$this->session->userdata('UserID'),
				'q1'=>$q1,
				'q2'=>$q2,
				'q3'=>$q3,
				'q4'=>$q4,
				'q5'=>$q5,
				'q6'=>$q6,
				'q7'=>$q7,
				'q8'=>$q8,
				'q9'=>$q9,
				'comment'=>$comment,
				'Time'=>time()
			 );
	  
	      $this->db->insert('artwork_checklist',$array);



	      
		  $variable_data = ($q9==1)?1:0;
		  $array = array('lastmodified'=>time(),'checklist'=>'1','variable_data'=>$variable_data);
		  $this->Artwork_model->update_order_attachment($jobno,$array);
		  //$this->Artwork_model->add_to_timeline($jobno,'19',$ver,0,0);  
		  
		  $time = $this->design_assign_time($jobno);
		  //$time = strtotime($jobdetail['Date']);
		  $time = (isset($time) && $time!="")?$time:strtotime($jobdetail['Date']);
		  $minutes = $this->Artwork_model->calculate_minutes($time,time());
		  $minutes = ($minutes == 0)?1:$minutes;
		  
		  $array = array('Jobno'=>$jobno,'Action'=>19,'Time'=>time(),'Version'=>$ver,'operator'=>$this->session->userdata('UserID'),'type'=>0,'is_reject'=>0,'time_taken'=>$minutes);	
		  $this->db->insert('artwork_timeline',$array);
	
		  
		  ////////////////////////////////////////////
		  $this->printjobcontroller($jobno); 	
	  }
	
	 public function design_assign_time($jobno){
	  $sql = $this->db->query("select Time from artwork_timeline where Jobno = $jobno order by ID desc")->row_array();
	  return $sql['Time'];
	 } 
	 
	 public function show_chekclist(){
	     $jobno = $this->input->post('jobno');
		 $data['jobno']  = $jobno;
		 $data['row']  = $this->Artwork_model->fetch_job_checklist($jobno); 
		 $theHTMLResponse = $this->load->view('artwork/ajax/viewchecklist',$data,true);
		 
		 $json_data = array('html'=>$theHTMLResponse);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	 }
	
	//------------------------------------------------START OF THE popups SECTION----------------------------------------------------------	
 
	  public function approve_original(){
	   $jobno = $this->input->post('jobno');
	   $ver = $this->input->post('ver');
	   
	   $array = array('approved'=>1,'status'=>65,'lastmodified'=>time(),'action'=>1);
	   $this->Artwork_model->update_order_attachment($jobno,$array);
	   $this->Artwork_model->add_to_timeline($jobno,'64',$ver,1,0);
	   $this->printjobcontroller($jobno); 	
	}
	
	 function printjobcontroller($jobno){
	   $data['row']     = $this->Artwork_model->fetch_one_artwork($jobno);
	   $data['result']  = $this->Artwork_model->fetch_chat_artwork($jobno);
	   $data['orderinfo'] = $this->Artwork_model->order_and_attachments_join($data['row']['OrderNumber']);
	   $theHTMLResponse = $this->load->view('artwork/ajax/fetch_job',$data,true);
	   
	    if($data['row']['action']    == 0){ $light    = "red-artwork-pulse";    } 
        if($data['row']['action']    == 1){ $light    = "green-artwork-pulse";  } 
        if($data['row']['action']    == 2){ $light    = "yellow-artwork-pulse"; } 
        if($data['row']['checklist'] == 0){ $light    = "blue-artwork-pulse";   }
		$light = '<div class="sk-spinner sk-spinner-pulse '.$light.'"></div>Print Job No.: <b>PJ'.$data['row']['ID'].'</b>';
         if($data['row']['variable_data']==1){
             $light.= '<b style="color:red"> - Sequential</b>';
         }
                       
		 $json_data = array('html'=>$theHTMLResponse,'light'=>$light);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	}
    
	 public function customerfeedback(){
	     $jobno = $this->input->post('jobno');
		 $data['jobno']  = $jobno;
		 $data['feedbackdetails']  = $this->Artwork_model->view_feedback($jobno); 
		 $theHTMLResponse = $this->load->view('artwork/ajax/feedback',$data,true);
		 
		 $json_data = array('html'=>$theHTMLResponse);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	 }
	 
	 
 //------------------------------------------------START OF THE ARTWORK HISTORY SECTION----------------------------------------------------------	
	 
	  public function artworkhistory(){
	     $jobno = $this->input->post('jobno');
		 $row = $this->Artwork_model->fetch_one_artwork($jobno);
		 
		 $orderinfo = $this->db->query("select UserID,BillingPostcode,Billingemail,DeliveryPostcode from orders where OrderNumber LIKE '".$row['OrderNumber']."' ")->row_array();
		 $die = $this->get_diecode($row['diecode'],$row['Brand']);
		 
		 $details = $this->db->query("select * from order_attachments_integrated inner join orders on order_attachments_integrated.OrderNumber = orders.OrderNumber where (orders.BillingPostcode LIKE '".$orderinfo['BillingPostcode']."' || orders.UserID = '".$orderinfo['UserID']."' || orders.Billingemail LIKE '".$orderinfo['Billingemail']."' || orders.DeliveryPostcode LIKE '".$orderinfo['DeliveryPostcode']."') and order_attachments_integrated.diecode LIKE '%".$die."%' and (order_attachments_integrated.status = 7 || order_attachments_integrated.status = 70)")->result();
		 
		 $data['jobno']  = $jobno;
		 
		 $data['result'] = $details;
		 $data['jobnodetail'] = $row;
		 $theHTMLResponse = $this->load->view('artwork/ajax/artworkhistory',$data,true);
		 
		 $json_data = array('html'=>$theHTMLResponse);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	 }
	 
	 public function get_diecode($ManufactureID,$brand){
	   if(isset($brand) and  $brand == 'Rolls'){ 
         $ManufactureID = substr($ManufactureID,0,-1);
        }
        $code = $this->Artwork_model->getmaterialcode($ManufactureID);
        return $pdiecode = str_replace($code,"",$ManufactureID);
    }
	 
 //------------------------------------------------START OF THE UPLOAD SECTION----------------------------------------------------------	
	
	public function upload_softproof(){ 
		$softproof        = $_FILES['soft'];
		$softproofpdf     = $_FILES['softproofpdf'];
		$softproofthumb   = $_FILES['softproofthumb'];
		
	  if (!empty($softproof) && !empty($softproofpdf)  && !empty($softproofthumb)) {
			$response1 = $this->upload_images('soft','softproof/');	
			$response2 = $this->upload_images('softproofpdf','pdf/'); 
			$response3 = $this->upload_images('softproofthumb','thumb/');
			//echo $response1['msg'] .'---'.$response2['msg'].'---'.$response3['msg'];
		   
		   if($response1['msg']!='error' && $response2['msg']!='error'  && $response3['msg']!='error'){
			 $json_data = array('softproof'=>$response1['file'],'softproofpdf'=>$response2['file'],'softproofthumb'=>$response3['file']);
		   }else{
			 $json_data = array('response'=>'error');
		   }
		   
		     $this->output->set_content_type('application/json');	
		     $this->output->set_output(json_encode($json_data));
	   }
   }
	
   public function upload_images($field_name,$path){ 
		$imagename = ''; 
		$config['upload_path'] = ARTPATH.'site/printing/chat/'.$path;
		$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx|tiff|tif';
		$config['max_size']	= '200000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if($this->upload->do_upload($field_name)){
			$data = array('upload_data' => $this->upload->data());
			$imagename = $data['upload_data']['file_name'];
			return array('file'=>$imagename,'msg'=>'success');
		}else{
			$message = $this->upload->display_errors();	
			return array('type'=>'error','msg'=>$message); 
		}
	 }
	
	 public function upload_printfile(){ 
	    $file_up  = $_FILES['file_up'];
	    $imagename = '';
		
		 if(isset($_FILES['file_up']) and $_FILES['file_up']!=''){
			$response = $this->upload_images('file_up','print/');	
		 }
		 
		   if($response['msg']!='error'){
			 $json_data = array('attachment'=>$response['file']);
		   }else{
			 $json_data = array('response'=>'error');
		   }
		   
		     $this->output->set_content_type('application/json');	
		     $this->output->set_output(json_encode($json_data));
	 }	  
	 
	 public function add_artwork_comment(){
	  
		$jobno = $this->input->post('attach');
		$comment = $this->input->post('comment');
		$attachment = $this->input->post('attachment');
		$thumbnail = $this->input->post('thumbnail');
		$pdfformat = $this->input->post('pdfformat');
		$softproof = $this->input->post('softproof');
	    
		$jobdetail = $this->Artwork_model->fetch_one_artwork($jobno);
		$ver = $jobdetail['version'];
		  
		$latest = (isset($attachment) && $attachment!="" && $jobdetail['status']==70 && $jobdetail['rejected']==1)?1:0;
			$array = array(
				'attach_id'=>$jobno,
				'operator'=>$this->session->userdata('UserID'),
				'comment'=>$comment,
				'file'=>$attachment,
				'thumb'=>$thumbnail,
				'pdf'=>$pdfformat,
				'softproof'=>$softproof,
				'latest'=>$latest
			);
		
		  $this->db->insert('artwork_chat',$array);
		  
		  
		   if(isset($softproof) && $softproof!="" && $jobdetail['status']==65){
			$array = array('status'=>66,'lastmodified'=>time(),'action'=>0,'SP'=>1);
			$this->Artwork_model->update_order_attachment($jobno,$array);
			$this->Artwork_model->add_to_timeline($jobno,'65',$ver,0,0);  
		   }

		   if(isset($attachment) && $attachment!="" && $jobdetail['status']==68){
			$array = array('status'=>69,'lastmodified'=>time(),'action'=>0,'PF'=>1);
			$this->Artwork_model->update_order_attachment($jobno,$array);
			$this->Artwork_model->add_to_timeline($jobno,'68',$ver,0,0); 
		   }
		   
		   // REJECTED SCENARIO
		    if(isset($attachment) && $attachment!="" && $jobdetail['status']==70 && $jobdetail['rejected']==1){
			 $array = array('is_upload_print_file'=>1,'lastmodified'=>time(),'action'=>0);
			 $this->Artwork_model->update_order_attachment($jobno,$array);
			 $this->Artwork_model->add_to_timeline($jobno,'68',$ver,0,0); 
		   }
	    
		$this->printjobcontroller($jobno); 
	 } 
 //------------------------------------------------START OF THE DECISION SECTION----------------------------------------------------------	
     
	 public function decision($ordernumber,$jobno,$type){
	  $data['jobno'] = $jobno;
	  $data['type']  = $type;
	  $data['main_content'] = "artwork/decision";	
	  $this->load->view('page',$data);	
	 }
	 
	 public function navigationpoints($jobno,$type){
		 $row  = $this->Artwork_model->fetch_one_artwork($jobno); 
		 $record =  $this->Artwork_model->groupconcatjobs($row['OrderNumber'],$type);

		 //-----------
		 if($record['jobs']==""){ return false; }
		 //-----------
		 
		 $returnarray = explode(',',$record['jobs']);
		 $value =  array_search($row['ID'],$returnarray,true);
		 
		 $pre = ($value==0)?0:$returnarray[$value-1];
		 $nxt = (end($returnarray) == $row['ID'])?0:$returnarray[$value+1];
		 
		// $last  = end($returnarray); 
		 // $first = min($returnarray);
		// print_r($returnarray); 
		// echo '<br>'.$value;
   
		// echo '<br>pre: =>'.$returnarray[$value-1];
		// echo '<br>nxt: =>'.$returnarray[$value+1];
		// unset($returnarray[$value]);
		// echo '<br>';
		// print_r(array_values($returnarray)); 
		
		//$pre = ($returnarray[$value-1]==$first)?0:$returnarray[$value-1];
		//$nxt = ($returnarray[$value+1]==$last)?0:$returnarray[$value+1];
		
		return array('pre'=>$pre,'next'=>$nxt,'row'=>$row);
	 }
	 
	 public function decisionslider($jobno,$type){ 
	     //$jobno = $this->input->post('jobno');
		 $navpoints = $this->navigationpoints($jobno,$type);
		 $data['previous'] = $navpoints['pre'];
		 $data['next']     = $navpoints['next'];
		 $data['row']      = $navpoints['row'];
		 $theHTMLResponse = $this->load->view('artwork/ajax/decisionslider',$data,true);
		 
		 $json_data = array('html'=>$theHTMLResponse);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	 }
	 
	  public function move_to_attachments(){
	   $id   = $this->input->post('id');
	   $type = $this->input->post('type');
	   $val  = $this->input->post('val');
	   $nextjob  = $this->input->post('nextjob');
	   $comment  = $this->input->post('comment');
	   
	   $sql = $this->db->query("select * from artwork_chat where ID = $id")->row_array();
	   $jobno = $sql['attach_id'];
	   
	   $jobdetail = $this->Artwork_model->fetch_one_artwork($jobno);
	   $OrderNumber = $jobdetail['OrderNumber'];
	   $ver = $jobdetail['version'];
	   
	   if($val=="approve"){
	      if($type=="print"){
			 $array = array('status'=>70,'lastmodified'=>time(),'action'=>0,'checked'=>1,'print_file'=>$sql['file']);
	         $this->Artwork_model->update_order_attachment($jobno,$array);
	         $this->Artwork_model->add_to_timeline($jobno,'69',$ver,1,0);  
		     $this->update_for_selection_to_production($OrderNumber);
		  }else if($type=="soft"){
			$this->db->update('order_attachments_integrated', array('softproof'=>$sql['softproof']), array('ID'=>$sql['attach_id']));
			$max = $this->db->query("SELECT MAX(`ref`) as max from artwork_chat where `attach_id` = '".$sql['attach_id']."' ")->row_array();
			$refno =  $max['max']+1;
			$this->db->where('ID',$id);	
	        $this->db->update("artwork_chat",array('ref'=>$refno));
		  }
	   }else if($val=="decline"){  $ver = $ver+1;
	    if($type=="print"){
			 $array = array('status'=>68,'lastmodified'=>time(),'action'=>1,'checked'=>0,'print_file'=>'','PF'=>0,'version'=>$ver);
	         $this->Artwork_model->update_order_attachment($jobno,$array);
	         $this->Artwork_model->add_to_timeline($jobno,'69',$ver,1,1);
		  }else if($type=="soft"){
			 $array = array('status'=>65,'lastmodified'=>time(),'action'=>1,'softproof'=>'','SP'=>0,'version'=>$ver);
	         $this->Artwork_model->update_order_attachment($jobno,$array);
	         $this->Artwork_model->add_to_timeline($jobno,'66',$ver,1,1);
		  }
		   $this->Artwork_model->addrejectioncomment($jobno,$comment);
		   $this->db->where('ID',$id);	
	       $this->db->update("artwork_chat",array('rejected'=>1));
	   }
	   
	   $this->decisionslider($nextjob,'normal');
	 }
	 
	 public function update_for_selection_to_production($OrderNumber){  
	  $check = $this->db->query("select * from order_attachments_integrated 
     where OrderNumber LIKE '".$OrderNumber."' and  checked = 0 ")->result();
      if(count($check)==0){
        $this->db->update('orders', array('OrderStatus'=>63,'Old_OrderStatus'=>''), array('OrderNumber'=>$OrderNumber));
      }
   }
   
   function rejected_attachments(){
       $id   = $this->input->post('id');
	   $type = $this->input->post('type');
	   $val  = $this->input->post('val');
	   $nextjob  = $this->input->post('nextjob');
	   $comment  = $this->input->post('comment');
	   
	   $sql = $this->db->query("select * from artwork_chat where ID = $id")->row_array();
	   $jobno = $sql['attach_id'];
	   
	   $jobdetail = $this->Artwork_model->fetch_one_artwork($jobno);
	   $OrderNumber = $jobdetail['OrderNumber'];
	   $ver = $jobdetail['version'];
	   
	   if($val=="approve"){
	         $array = array('status'=>70,'lastmodified'=>time(),'action'=>0,'rejected'=>0,'is_upload_print_file'=>0);
	         $this->Artwork_model->update_order_attachment($jobno,$array);
	         $this->Artwork_model->add_to_timeline($jobno,'69',$ver,1,0); 
	   }else if($val=="decline"){
	         $array = array('status'=>70,'lastmodified'=>time(),'action'=>1,'is_upload_print_file'=>0);
	         $this->Artwork_model->update_order_attachment($jobno,$array);
	         $this->Artwork_model->add_to_timeline($jobno,'69',$ver,1,1);
			 
			 $this->Artwork_model->addrejectioncomment($jobno,$comment);
		     $this->db->where('ID',$id);	
	         $this->db->update("artwork_chat",array('rejected'=>1));
	   }
	   $this->decisionslider($nextjob,'rejected');
  
  }
	
 //------------------------------------------------START OF THE EDIT CO SECTION----------------------------------------------------------	
     public function edit_artwork(){ 
	    $imagename = '';
		 if(isset($_FILES['file']) and $_FILES['file']!=''){
			$jobno = $this->input->post('uploadcoid');
			
			$config['upload_path'] = ARTPATH.'integrated_attach/';
			$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx|tiff|tif';
			$config['max_size']	= '20000';
			$this->load->library('upload', $config);
			$field_name = "file";
			if($this->upload->do_upload($field_name)){
				$data = array('upload_data' => $this->upload->data());
				$imagename = $data['upload_data']['file_name'];
				$this->reset_job($jobno,$imagename);
				$this->printjobcontroller($jobno); 
			}
	    }
	  }
	 
	public function reset_job($jobno,$imagename){
	  $jobdetail = $this->Artwork_model->fetch_one_artwork($jobno);
	  $ver = $jobdetail['version'];
	  $is_approve = $jobdetail['approved'];
	     if($is_approve==1){
	       $ver = $ver + 1;
	     }
	  $array = array('status'=>64,'lastmodified'=>time(),'action'=>0,'checked'=>0,'print_file'=>'','softproof'=>'','version'=>$ver,'approved'=>0,'file'=>$imagename,'CO'=>1,'SP'=>0,'CA'=>0,'PF'=>0,'checklist'=>'0');
	  $this->Artwork_model->update_order_attachment($jobno,$array);
	  $this->Artwork_model->add_to_timeline($jobno,'17',$ver,1,0);
	}

  //------------------------------------------------STAR OF CUSTOMER APPROVAL----------------------------------------------------------	   
	
	 public function send_email_again($order){
	   $this->artwork_approval($order);
	   echo "sent";
	 } 
	 
	public function send_email(){
     $ids = $this->input->post('ids');
     $order = $this->input->post('order');
	 
      foreach($ids as $id){
		  $jobdetail = $this->Artwork_model->fetch_one_artwork($id);
		  $array = array('status'=>67,'lastmodified'=>time(),'action'=>2);
	      $this->Artwork_model->update_order_attachment($id,$array);
	      $this->Artwork_model->add_to_timeline($id,'66',$jobdetail['version'],1,0);
		}	
		
         $this->artwork_approval($order);
	 }

     
      
	function artwork_approval($ordernumber){ 
	 
	   $res = $this->db->query("select * from orders where OrderNumber LIKE  '".$ordernumber."'")->row_array();

	  
	     $language = ($res['site']=="" || $res['site']=="en")?"en":"fr"; 
	     $subject =  ($language=="fr")?"DESIGN SOFT PROOF":"Artwork Approval"; 
		 $link = ($language=="fr")?'https://www.aalabels.com/approbation-dauvres-dart/'.md5($ordernumber):'https://www.aalabels.com/artwork-approval/'.md5($ordernumber);
	    
	    if($language =="fr"){
	      $getfile = FCPATH.'application/views/order_quotation/email/artwork-approval_fr.html';
	    }else{
	      $getfile = FCPATH.'application/views/order_quotation/email/artwork-approval.html';  
	    } 
	     
		 $mailText = file_get_contents($getfile);
		 
		 
		 $await = $this->count_await_jobs($ordernumber);
		 $all = $this->get_all_jobs($ordernumber);
		
		 if($language=="fr"){
		  $text =  'voir et approuver / amender '.$await.' de '. $all;
		 }else{
		  $text =  'View and Approve/Amend '.$await.' of '. $all;
		 }
		 
	   
         $strINTemplate   = array("[FirstName]", "[orderNumber]", "[OrderDate]", "[OrderTime]", "[link]", "[Text]");
	     $strInDB  = array($res['BillingFirstName'], $ordernumber, date("d.m.y"),date("H:i"),$link,$text);
	     $body = str_replace($strINTemplate, $strInDB, $mailText);
		
		 $this->load->library('email');
		 $this->email->initialize(array('mailtype' =>'html',));
		 $this->email->subject($subject);
		 $this->email->from('customercare@aalabels.com','Aalabels'); 
		 $this->email->to($res['Billingemail']); 
		 //$this->email->bcc('web.development@aalabels.com');
		 $this->email->message($body); 
		 $this->email->send();
	}
	 
  
	function get_all_jobs($order){
	     $sql = $this->db->query("select count(*) as total from order_attachments_integrated where OrderNumber LIKE '".$order."'")->row_array();
	     return $sql['total'];
	  }
	  
	  function count_await_jobs($order){
		 $sql = $this->db->query("select count(*) as total from order_attachments_integrated where OrderNumber LIKE '".$order."' and status = 67 ")->row_array();
		return $sql['total'];
	  }
	  
   //------------------------------------------------STAR OF ROLL LABEL DETAILS----------------------------------------------------------	   

	public function rolldetails($order){
		 
		$dies = $this->db->query("select SerialNumber,ManufactureID,repeat_length,label_per_frame,width_reg from orderdetails where OrderNumber LIKE '".$order."' and ProductName LIKE '%Printed Labels on Rolls%' ")->result();
	   
	   $data['order'] = $order;
	   $data['dies']  = $dies;
	   $data['main_content'] = 'artwork/rolldetails';
       $this->load->view('page', $data);
	 }
	 
	   public function addrolldetails(){

	   	  $order_no = $this->input->post('order');
          $manu     = $this->input->post('manufactureid'); 
		  $serial   = $this->input->post('serial');
	
		  $repeat     = $this->input->post('repeatlength');
		  $labels     = $this->input->post('labelsperframe');
		  $width      = $this->input->post('widthreg');
		 
		  $array = array(
			'repeat_length'=>$repeat,   
			'label_per_frame'=>$labels, 
			'width_reg'=>$width
		  );
		 $this->db->where('SerialNumber',$serial);	
		 $this->db->update("orderdetails",$array);	
		 //echo $this->db->last_query();
		 $imagename = '';
		 if(isset($_FILES['template']) and $_FILES['template']!=''){

			 $config['upload_path'] = ARTPATH.'integrated_attach/templates/';
			 //print_r($config['upload_path']); exit;
			$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx';
			$config['max_size']	= '20000';
			$this->load->library('upload', $config);
			$field_name = "template";
			

			$file_pointer = $config['upload_path'].$_FILES['template']['name'];
            if (file_exists($file_pointer)) {
                if($serial!=""){
                    @unlink($file_pointer);
                }
            } 


                if($this->upload->do_upload($field_name)){

                    $data = array('upload_data' => $this->upload->data());
                    $imagename = $data['upload_data']['file_name'];
                    $this->db->update('order_attachments_integrated', array('template'=>$imagename), array('Serial'=>$serial));
                    echo json_encode(array('file'=>$imagename));
                }else{
                    $errors = $this->upload->display_errors();
                    print_r($errors);
                }

	    }
	  }
	  
	//------------------------------------------------STAR OF TIMELINE----------------------------------------------------------	   
     public function fetch_timeline(){
		 $jobno = $this->input->post('jobno'); 
		 $order = $this->input->post('order');
		 $data['jobno']  = $jobno;
		 $data['order']  = $order;
		 $data['orderdate'] = $this->Artwork_model->fetch_order_date($order);
		 $data['result'] = $this->Artwork_model->fetch_one_artwork($jobno);
		 $data['data']   = $this->Artwork_model->fetch_artworks_timeline($jobno); 
		 
	     $theHTMLResponse = $this->load->view('artwork/ajax/timeline',$data,true);
		 $json_data = array('html'=>$theHTMLResponse);
		 $this->output->set_content_type('application/json');	
		 $this->output->set_output(json_encode($json_data));
	 }
	  
   //------------------------------------------------STAR OF ADVANCE SEARCH----------------------------------------------------------	   
     public function advancesearch(){ 
	   $this->load->library('Table');
	   $tmpl = array('table_open' => '<table class="table table-hover m-0 advancesearch table-actions-bar dt-responsive nowrap artwork-table-row-adjust" cellspacing="0" width="100%" id="datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
                 
        $this->table->set_template($tmpl);
        $this->table->set_heading('Order Number','Print job','Diecode','Type','Name','Designer','SP','PF','Time','Timeline');
		
		$data['alldesigners']   = $this->Artwork_model->fetch_designers();
        $data['main_content']   = "artwork/advancesearch";
        $this->load->view('page', $data);
	  }
	  
	 public function search_records_datatable(){  
	   $designer = $this->input->post('designer');
	   $product = $this->input->post('product');
	   $file = $this->input->post('file');
	   $date = $this->input->post('date');
	   $status = $this->input->post('status');
	   
	   $date1     = explode('-',$date);
	   $startdate = explode('/',$date1[0]);
	   $enddate   = explode('/',$date1[1]);
	   $From = trim($startdate[2]).'-'.trim($startdate[1]).'-'.trim($startdate[0]).' 00:00:00';
	   $To   = trim($enddate[2]).'-'.trim($enddate[1]).'-'.trim($enddate[0]).' 23:59:59';
	  
	 // SELECT at.OrderNumber,ch.attach_id,at.diecode,at.Brand,at.Name,at.operator,ch.time FROM artwork_chat ch inner join order_attachments_integrated at on at.ID = ch.attach_id where ch.time > '2017-08-01 00:00:00' and ch.time < '2019-08-01 00:00:00'
   
	
	$where = "ch.time > '".$From."' AND ch.time < '".$To."' AND ch.operator = $designer";
	
	if($product=="both"){ //$where.= " AND (at.Brand LIKE 'Rolls' or at.Brand LIKE 'A4')"; 
	}else{ $where.= " AND at.Brand LIKE '".$product."'"; }
	
	if($file=="both"){ //$where.= " AND (ch.softproof != '' or ch.file != '' )";
	}else if($file=="softproof"){ $where.= " AND ch.softproof != ''";
	}else if($file=="print"){ $where.= " AND ch.file != ''"; }
	
	   //echo $where; die();
     
	   $this->datatables
      ->select('at.OrderNumber,ch.attach_id,at.diecode,at.Brand,at.Name,(select UserName from customers where customers.UserID = ch.operator),ch.softproof,ch.file,ch.time,ch.attach_id as timeline')
	  ->from('artwork_chat as ch')
	  ->join('order_attachments_integrated as at','at.ID = ch.attach_id','inner')
	  ->where($where);
	   echo $this->datatables->generate();
	 }
	 
	 function download_artwork_report(){
		$this->load->helper('download');
		header('Content-Type: application/csv');
		$name = 'artworks_reporting.csv'; 
		header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
		$fp = fopen('php://output', 'w');
		fputcsv($fp, array('Order No',
					   'Print job',
					   'Diecode',
					   'Type',
					   'Name',
					   'Designer',
					   'Time',
					   ));
					   
       $designer = $this->input->post('designer-form');
	   $product = $this->input->post('product-form');
	   $file = $this->input->post('file-form');
	   $date = $this->input->post('reservation');
	   $status = $this->input->post('status');
	   
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
	
	 $qry = "SELECT at.OrderNumber,ch.attach_id,at.diecode,at.Brand,at.Name,(select UserName from customers where customers.UserID = ch.operator) as operator,ch.time as date_time FROM artwork_chat ch inner join order_attachments_integrated at on at.ID = ch.attach_id where $where ";
	$orders = $this->db->query($qry)->result();
      //print_r($orders); die();
         foreach($orders as $order){
			  fputcsv($fp, array($order->OrderNumber,
			   'PJ'.$order->attach_id,
			   $order->diecode,
			   $order->Brand,
			   $order->Name,
			   $order->operator,
			   $order->date_time,
			   ));	
		  }
		
		$data = file_get_contents('php://output'); 
		force_download($name, $data);
		fclose($fp); 
	 }
	 
	 function search_records(){
	   $designer = $this->input->post('designer');
	   $product = $this->input->post('product');
	   $file = $this->input->post('file');
	   $date = $this->input->post('date');	 
	   $result = $this->Artwork_model->search_records($designer,$product,$file,$date);
       echo json_encode($result);
	 } 
 //------------------------------------------------STAR OF FILE----------------------------------------------------------	   
      public function rejected(){
	    $data['start'] = 0;
		$data['result'] = $this->Artwork_model->fetchRejectedOrders($data['start'],5);
		$data['main_content'] = "artwork/rejected_artworks";
		$this->load->view('page',$data);
	 }
	  public function fetch_rejectedartworks_jobs(){
	   $start = $this->input->post('start');
	   $data['start'] = $start;
	   $data['result'] = $this->Artwork_model->fetchRejectedOrders($start,5);
	   $theHTMLResponse = $this->load->view('artwork/ajax/fetch_rejected_artworks',$data,true);
	   $json_data = array('html'=>$theHTMLResponse);
	   echo json_encode($json_data);
	  }
  
  //------------------------------------------------STAR OF FILE UMAIR ----------------------------------------------------------	   
   function getDVer(){
	
		$jobno = $this->input->post('jobno');
		//$jobno = '18922';
		$data['result']  = $this->Artwork_model->fetch_customer_versions_newall($jobno)[0];
		$data['history'] = $this->Artwork_model->fetch_customer_versions_newall($jobno);
		$data['jobno'] = $jobno;
		$theHTMLResponse = $this->load->view('artwork/ajax/softproof/header',$data,true);
		
		$datas['getDeclineComments'] = $this->Artwork_model->getTopCommentsDeclineComments($jobno); 
		$datas['top_comments'] = $this->Artwork_model->getTopComments($jobno);
		$theHTMLResponseTop = $this->load->view('artwork/ajax/softproof/top_comments.php',$datas,true);

		$json_data = array('html'=>$theHTMLResponse,'top_comments'=>$theHTMLResponseTop);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
	public function fetch_order_comments(){
		
		$order = $this->input->post('id');
		return $this->fetch_view_load($order);
	}
    
	public function fetch_view_load($order){
		$data['order']  = $order;
		$data['assoc']  = $this->Artwork_model->fetch_order_comments($order);
		$theHTMLResponse = $this->load->view('artwork/ajax/order_comments_popup',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
   
   //------------------------------------------------STAR OF FILE----------------------------------------------------------	   
   
   public function reupload_Artwork_form(){ 
	    $file_up  = $_FILES['file_up'];
	    $jobnumber = $this->input->post('jobnumber');
	    $imagename = '';
		
		if($_POST['jobnumber']){
		
		  if(isset($_FILES['file_up']) and $_FILES['file_up']!=''){
			$response = $this->upload_images('file_up','print/');	
		  }
		 
		 if($response['msg']!='error'){
		   $imagename = $response['file'];
		 }
	  
	     if($imagename!='' && $jobnumber!=""){
	      $this->db->where('ID',$jobnumber);
	      $this->db->update('order_attachments_integrated',array('print_file'=>$imagename));
	     }
		   
		$json_data = array('file'=>$imagename);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	  }
	  
	 }	  
	 
	  function is_upload_template(){
         $order = $this->input->post('order');
         $res = $this->db->query("SELECT count(ID) as total_roll_lines, (select count(ID) from order_attachments_integrated WHERE orderNumber = '$order' and
         Brand = 'Rolls' and template!='') as emp_line FROM `order_attachments_integrated` WHERE orderNumber = '$order' and Brand = 'Rolls'")->row_array();
         echo json_encode(array('t_line'=>$res['total_roll_lines'],'emp_line'=>$res['emp_line']));
     }
	 
   //------------------------------------------------STAR OF FILE----------------------------------------------------------	   

	
}
