<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Dies extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->library('Datatables');
		$this->load->library('Table');
		$this->load->database();
		$this->load->model('dies/die_model');
		$this->load->model('quoteModel');
		$this->home_model->user_login_ajax();
		
		
	}
   
	function index(){  
		$tmpl = array('table_open' => '<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive artwork-table-row-adjust return-table" cellspacing="0" width="100%" id="datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
                 
		$this->table->set_template($tmpl);
		$this->table->set_heading('Code','Template','Shape','Label Height','Label Width','Type','Top','Bottom ','Left','Right','Website', 'Backoffice','Re-order','TimeLine' );
   
		$data['main_content'] = 'die/dies';
		$this->load->view('page', $data);
	} 
 
	function diestable($type){
		//die($this->input->post('iSortCol_0'));
		
		$shape = count($this->uri->segment_array())-1;
		$labelCategory = count($this->uri->segment_array());
        
		$selected_shape = trim($this->uri->segment($shape));
		$selected_labelCategory = trim(utf8_decode(rawurldecode($this->uri->segment($labelCategory))));
        
		if($selected_shape!="all" && $selected_labelCategory!= "all"){
			$where = "(Shape_upd LIKE '".$selected_shape."' and labelCategory LIKE '".$selected_labelCategory."') ";
		}	else if($selected_shape!="all"){
			$where = "(Shape_upd LIKE '".$selected_shape."') ";
		}else if($selected_labelCategory!= "all"){
			$where = "(labelCategory LIKE '".$selected_labelCategory."') ";
		}else{
			$where = "1=1";
		}
        
		if($type=="website"){
			$where .= " AND (CategoryActive LIKE 'Y' or displayin = 'backoffice') ";
		}	
        
		if($type=="backoffice"){
			$where .= " AND (displayin = 'backoffice') ";
		}
        
		if($selected_labelCategory=="all"){
			$where .= " AND (labelCategory LIKE 'A4 Labels' OR labelCategory LIKE 'A3 Label' OR labelCategory LIKE 'A5 Labels' OR labelCategory LIKE 'SRA3 Label' OR labelCategory LIKE 'Integrated Labels') ";
		}
      
		$this->datatables->select('DieCode,CategoryImage,Shape_upd,LabelHeight,LabelWidth,is_euro,LabelTopMargin,LabelBottomMargin,LabelLeftMargin,LabelRightMargin,displayin,123CategoryName,labelCategory,CategoryID,CategoryActive')
			->where($where,'',FALSE)
			->from('category'); 
		echo $this->datatables->generate();
	}

	function rolldies(){  
		$tmpl = array('table_open' => '<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive  artwork-table-row-adjust return-table" cellspacing="0" width="100%" id="datatable">', 'thead_open'  => '<thead class="artwork-thead">', 'thead_close' => '</thead>');
		$this->table->set_template($tmpl);
		$this->table->set_heading('Code','Sizes','Shape','Height /<br>Width','L.Edge','Gap Across','Gap Around','Radius','Tooth Size','L.Across','L.Around','Status', 'Web', 'Back','Re-order /<br>Timeline','Action');

		$data['main_content'] = 'die/rolldies';
		$this->load->view('page', $data);   
	} 
 
	function fetchNearestSizes(){
		$cat_id = $this->input->post('cat_id');
		$result = $this->db->query("SELECT GROUP_CONCAT( REPLACE( CategoryImage, '.png', '' )) as nearest_size FROM category WHERE FIND_IN_SET( '".$cat_id."', NearestSizes)")->row();
	 
		if(!empty($result)){
			if($result->nearest_size != ''){
				echo $result->nearest_size;
			}else{
				echo 'empty';
			}
		}
	}
 
	function rolldiestable($shape){
		$search = $this->input->post('sSearch');
		$shape = count($this->uri->segment_array())-2;
        
		$selected_shape = trim($this->uri->segment($shape));
       
        
		$labelCategory = count($this->uri->segment_array())-1;
		$selected_labelCategory = trim(utf8_decode(rawurldecode($this->uri->segment($labelCategory))));
      $all_dies_or_in_backoffice = $this->uri->segment(count($this->uri->segment_array()));
	
		if($selected_shape!="all" && $selected_labelCategory!= "all"){
			$where = "(Shape_upd LIKE '".$selected_shape."' and labelCategory LIKE '".$selected_labelCategory."') ";
		}else if($selected_shape!="all"){
			$where = "(Shape_upd LIKE '".$selected_shape."') ";
		}else if($selected_labelCategory!= "all"){
			$where = "(labelCategory LIKE '".$selected_labelCategory."') ";
		}else{  
			$where = "1=1";
		}
     
		if($all_dies_or_in_backoffice == 'backoffice'){
			$where.= " AND (displayin = 'backoffice') ";
		}
 
		$where.= " AND (labelCategory LIKE 'Roll Labels') ";
		$this->datatables
			->select('DieCode, Shape_upd as upd ,Shape_upd,repeatlength,LabelHeight,LabelWidth,LeadingEdge,LabelGapAcross,LabelGapAround,LabelCorner,
  				  ToothSize,LabelAcross, LabelAround,isapprove,isapprove as approve,displayin,CategoryImage,DieCode as id, CategoryID as Prim_key,CategoryActive')
			->where($where,'',FALSE)
			->from('category as cat'); 
		echo $this->datatables->generate();     
	}
	
	public function changediestatus(){
		$checker = $this->input->post('checker');
		$die = $this->input->post('die');
	  
		$action = ($checker=="Y")?'1':'0';
		$this->db->update('category', array('isapprove'=>$action), array('DieCode'=>$die));
	 
		
		$data = array(
			'diecode'  =>$die,
			'operator' =>$this->session->userdata('UserID'),
			'Action'   =>$action,
			'Time'     =>time()
		);
		$this->db->insert('rolldiestimeline',$data);
		echo $this->db->insert_id();
	}
	
	public function fetch_timeline(){
		$die = $this->input->post('die');
		 
		$data['die']  = $die;
		$data['data']  = $this->db->query('select * from rolldiestimeline where diecode LIKE "'.$die.'"')->result();
		$theHTMLResponse = $this->load->view('die/inc/rolldietimeline.php',$data,true);
		 
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
	
	//******//******//******//****** START REORDER DIE SECTION  //******//******//******//****** 
    
	public function reorder_die(){    
		$code = $this->input->post('value');
		$data = $this->die_model->fetch_info($code);
		$array = array('SerialNumber'=>$data['CategoryID'],'OrderNumber'=>$data['CategoryImage'],'file'=>$data['PDF'],       'type'=>'reorder','diecode'=>$code,'Time'=>time(),'Status'=>'37','version'=>'1','manufactureid'=>$data['labelCategory'],'display_in'=>$data['displayin']);
		$this->db->insert('flexible_dies', $array);
		$this->save_logs('Reorder_die',$array);
    }
	
	public function changestatus(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
	   	
		if($status == 37){
			$array = array('Status'=>17,'S_SA'=>1);
		}else if($status == 17){
			$array = array('Status'=>73);
		}else if($status == 73){
			$array = array('Status'=>7);
		}
		$result = $this->die_model->updatediestable($id,$array);
		
		$logs_arr = array('result'=>$result,'status'=>$array);
		$this->save_logs('Reorder_die_change_status',$logs_arr);
		
		echo $result;	
	}
	
	
	public function changeMyDieStatus(){
		$status = $this->input->post('status');
		$categoryId = $this->input->post('categoryId');
		$code = $this->input->post('code');
		
		$this->die_model->changeStatus($status,$categoryId);
		$this->die_model->getProducts($categoryId,$status);
        
		if($status == 'Y'){
			//$this->send_alert($code,$status);
		} 
        
		$this->die_model->insertLog(array('code'=>$code,'converted'=>($status ==     'Y')?'Euro':'Standard','cat_id'=>$categoryId,'user_id'=>$this->session->userdata('UserID')));
        
		//print_r(array('code'=>$code,'converted'=>($status ==     'Y')?'Euro':'Standard','cat_id'=>$categoryId,'user_id'=>$this->session->userdata('UserID')));
		
		
		
		$logs_arr = array('code'=>$code,'converted'=>($status =='Y')?'Euro':'Standard','cat_id'=>$categoryId,'user_id'=>$this->session->userdata('UserID'));
		$this->save_logs('Die_convert',$logs_arr);
        
		echo ($status == 'Y')?'N':'Y';
	}
	
	function save_logs($activity,$log_arr){
		$arr = json_encode($log_arr);
			
		$arr_ins['SessionID'] = $this->session->userdata('session_id');
		$arr_ins['Activity']  = $activity;
		$arr_ins['Record'] 	  = $arr;
		$arr_ins['Website'] 	  = 'BK';
		$this->db->insert('websitelog',$arr_ins);
	}
    
	public function send_alert($code,$status){
		$data['code'] = $code;
		$data['status'] = $status;
		$body = $this->load->view('die/inc/send_euro_alert.php',$data,true);
		$this->load->library('email');
		$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject('Die Type Changed');
		$this->email->from('customercare@aalabels.com','AAlabels Saleoperator');
		$this->email->to("kiran@aalabels.com,steve@aalabels.com,Umer@aalabels.com,data.aalabels@gmail.com"); 
		//$this->email->bcc("Web.Development@aalabels.com");
		$this->email->message($body); 
		$this->email->send();  
	}
	
	public function euro_standrad_timeline(){
		$code = $this->input->post('code');
		$data['code']  = $code;
		$data['data']  = $this->db->query('select * from euro_standrd_logs where code LIKE "'.$code.'" order by id desc')->result();
		$theHTMLResponse = $this->load->view('die/inc/status_time_line.php',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($json_data));
	}
    
	public function calculate(){
		$data['main_content'] = 'calculate';
		$this->load->view('page', $data);
	}
   
	public function process_dies(){
		//$data['irregular'] = $this->die_model->fetch_irregular();	 
		//$data['data'] = $this->die_model->fetch_standard();
		//$data['reorder'] = $this->die_model->fetch_reorderdies();	
		//$data['pending'] = $this->die_model->fetch_pending();	
		$data['main_content'] = 'die/process_die/custom_die';
		$this->load->view('page', $data);
	}
    
	public function fetch_irregular(){
		$qry = $this->db->query("
		SELECT quotationdetails.SerialNumber,quotationdetails.QuotationNumber from quotationdetails
     
	  INNER JOIN quotations ON quotations.QuotationNumber = quotationdetails.QuotationNumber 
    INNER JOIN flexible_dies_info ON quotationdetails.SerialNumber = flexible_dies_info.QID 
     
     WHERE quotations.QuotationStatus = 37  AND quotationdetails.ManufactureID LIKE 'SCO1' AND quotationdetails.die_approve LIKE 'N'")->result();
		return $qry;
	}
	
	public function test(){
		$serial = '538';
		$this->pricecontroller($serial);
		//$this->load->view('die/process_die/pricing',$data);
	}
    
	/*=================================Start AWAITING DATATABLE PANEL==============================================*/
	
	
	
	public function getCustomOrdersListing(){
		
		return $this->getCustomOrdersListingVeiw();
	}
    
    public function getCustomOrdersListingVeiw(){
		
		$data['irregular'] = $this->die_model->fetch_irregular();
		$theHTMLResponse = $this->load->view('die/process_die/custom_dies_tb',$data,true);
		//$data['quote'] = $qou;
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}

	public function getFinishPlatesListing(){
		
		$data['fetch_finish_plates'] = $this->die_model->fetch_finish_plates();
		$data['plate_suppliers'] = $this->die_model->get_suppliers_list();
		$theHTMLResponse = $this->load->view('die/process_die/finish_plates_tb',$data,true);
		//$data['quote'] = $qou;
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}

	public function fetch_editdetail(){ 
		 $serial = $this->input->post('serial');
//		 /$quote = $this->input->post('quote');
		 return $this->detailcontroller($serial);
	}
	
	public function detailcontroller($serial){
		$data['serial']  = $serial;
		$data['quote'] = $this->get_qoute_no($serial);
		$data['data']  = $this->die_model->fetchdierecordinfo($serial);
		$count = count($data['data']);
         
		$theHTMLResponse = $this->load->view('die/process_die/detail',$data,true);
		$json_data = array('html'=>$theHTMLResponse,'count'=>$count);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
    
	public function save_details(){
		$serial = $this->input->post('serial');
		$across = $this->input->post('across');
		$around = $this->input->post('around');
		$labels = $this->input->post('lpd');
		$dietype = $this->input->post('dietype');
		$perforation = $this->input->post('perforation');
		
		$this->db->where('ID',$serial);
		$this->db->update('flexible_dies_info',array('around'=>$around,'across'=>$across,'labels'=>$labels,'iseuro'=>$dietype,'perforation'=>$perforation));
		return $this->detailcontroller($serial);
	} 
    
	public function fetch_comments2(){ 
		$serial = $this->input->post('serial');
		$quote = $this->input->post('quote');
		return $this->commentcontroller2($serial,$quote);
	}
	
	public function save_comment2(){
		$serial = $this->input->post('serial');
		$comment = $this->input->post('comment');
		$quote = $this->input->post('quote');
		$this->db->insert('flexible_die_commentsdata',
		array('serial'=>$serial,'comment'=>$comment,'Operator'=>$this->session->userdata('UserID'),'Time'=>time()));
		return $this->commentcontroller2($serial,$quote);
	}
	 
	public function delete_comment2(){
		$serial = $this->input->post('serial');
	  	$id = $this->input->post('id');
		$quote = $this->input->post('quote');
		$this->db->where('ID',$id);
		$this->db->delete('flexible_die_commentsdata');
		return $this->commentcontroller2($serial,$quote);
	}
     
	public function commentcontroller2($serial,$quote){
		$data['serial']  = $serial;
		$data['quote']  = $quote;
		$data['result']  = $this->die_model->fetchdierecordinfo($serial);
		$data['data']  = $this->die_model->fetch_comments2($serial);
		$ol = $count = $this->die_model->fetch_comments2_co($serial); 
		$info = $this->die_model->fetch_custom_die_quote_counts($serial);
		if(@$info['notes']!=""){
			$count = $count + 1;
		}
         
		$theHTMLResponse = $this->load->view('die/process_die/comments2',$data,true);
		$json_data = array('html'=>$theHTMLResponse,'count'=>$count);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}

	public function fetch_pricing(){
		$serial = $this->input->post('serial');
		return $this->pricecontroller($serial);
	}
	
	
	public function pricecontroller($serial){
		$data['serial']  = $serial;
		$data['quote'] = $this->get_qoute_no($serial);
		$data['result'] = $this->die_model->fetch_pricing($serial);	
		$data['p'] = $this->get_quotePrice($serial);
		$theHTMLResponse = $this->load->view('die/process_die/pricing',$data,true);
		//print_r($theHTMLResponse);
		$json_data = array('html'=>$theHTMLResponse,'count'=>count($data['result']),'apply'=>$data['p']);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
	
	function get_qoute_no($serial){
		$q	= "SELECT QuotationNumber FROM `quotationdetails` WHERE `SerialNumber` LIKE '".$serial."' ";
		$res = $this->db->query($q)->row_array();
		return $res['QuotationNumber'];
	}
    
	public function delete_price(){
		$serial = $this->input->post('serial');
		$id = $this->input->post('id');
        
		$re = $this->get_quotePrice($serial);
        
		$price = $this->db->query("select sprice from flexible_pricing where ID = $id")->row_array();
		$price = $price['sprice'];
        
        
		if($price == $re->Price){
        
			$this->db->where('serial',$serial);
			$this->db->update('flexible_pricing',array('status'=>'0'));
        
			$this->db->where('ID',$id);
			$this->db->update('flexible_pricing',array('status'=>'0'));
	 
			$this->db->where('SerialNumber',$serial);
			$this->db->update('quotationdetails',array('Price'=>'0.00','ProductTotalVAT'=>'0.00','ProductTotal'=>'0.00'));
		}
        
		$this->db->where('ID',$id);
		$this->db->delete('flexible_pricing');  
		return $this->pricecontroller($serial);	
	}
     
	public function apply_price(){
		$serial = $this->input->post('serial');
		$id = $this->input->post('id');
	 
		$this->db->where('serial',$serial);
		$this->db->update('flexible_pricing',array('status'=>'0'));
        
		$this->db->where('ID',$id);
		$this->db->update('flexible_pricing',array('status'=>'1'));
		
		$price = $this->db->query("select sprice from flexible_pricing where ID = $id")->row_array();
		$price = $price['sprice'];
	 
		$this->db->where('SerialNumber',$serial);
		$this->db->update('quotationdetails',array('Price'=>$price,'ProductTotalVAT'=>$price,'ProductTotal'=>$price*1.2));
		// echo 'updated';
		return $this->pricecontroller($serial);	
	}
    
	function get_quotePrice($serial){
		$this->db->select('Price');
		$this->db->from('quotationdetails');
		$this->db->where('SerialNumber',$serial);
		$res = $this->db->get()->row();
		return $res;     
	}
	 
	public function editables(){
		$id = $this->input->post('id');	
		$serial = $this->input->post('serial');
		$supplier = $this->input->post('supplier');
		$price = $this->input->post('value');
		$sprice = $this->input->post('svalue');
	 
		$this->db->where('ID',$id);
		$this->db->update('flexible_pricing',array('serial'=>$serial,'sprice'=>$sprice,'price'=>$price,'supplier'=>$supplier,'Operator'=>$this->session->userdata('UserID'),'Time'=>time()));
		return $this->pricecontroller($serial);
	}
    
	public function updtfile(){ 
		$imagename = '';
		$id = $this->input->post('ID');
		$serial = $this->input->post('serial');
		$qry = $this->die_model->fetchdierecord($id);
		
		//unlink(custom_die_pdf.'/'.$qry['file']);
		$this->load->library('upload');
        
		if(isset($_FILES['file']) and $_FILES['file']!=''){
            
			$uploadPath = custom_die_pdf;
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx';
			$config['max_size']	= '20000';
            
			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
            
			$field_name = "file";
			if($this->upload->do_upload($field_name)){
				$data = array('upload_data' => $this->upload->data());
				$imagename=$data['upload_data']['file_name'];
				$this->db->where('ID',$id);
				$this->db->update('flexible_pricing',array('pdf'=>$imagename));
			}
			return $this->pricecontroller($serial);
		}
	}
     
	public function save_price(){     
		$serial = $this->input->post('serial');
		$supplier = $this->input->post('supplier');
		$price = $this->input->post('value');
		$sprice = $this->input->post('svalue');
	    
		$this->db->insert('flexible_pricing',array('serial'=>$serial,'sprice'=>$sprice,'price'=>$price,'supplier'=>$supplier,'Operator'=>$this->session->userdata('UserID'),'Time'=>time()));
        
		$insertid = $this->db->insert_id();
		$imagename = '';
    
        
		$this->load->library('upload');
		if(isset($_FILES['file']) and $_FILES['file']!=''){
            
			$uploadPath = custom_die_pdf;
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx';
            
			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
            
			if($this->upload->do_upload('file')){
				$data = array('upload_data' => $this->upload->data());
				$imagename = $data['upload_data']['file_name'];
				$this->db->where('ID',$insertid);
				$this->db->update('flexible_pricing',array('pdf'=>$imagename));
				//echo json_encode(array('file'=>$imagename));
			}else{
				$errors = $this->upload->display_errors();
			}
		}     
		return $this->pricecontroller($serial);	
	}
    
	/*================================== -_=_- END AWAITING DATATABLE PANEL -_=_- ===================================*/
   
	//*================================= -_=_- START PDF UPLOAD SECTION -_=_- =======================================*/
    
	public function pdfcontroller($serial){
		$data['data'] = $this->die_model->fetchdierecord($serial);
		$theHTMLResponse = $this->load->view('die/process_die/upload',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));	
	}
	
	public function updatepdf(){
		$serial = $this->input->post('serial');
		return $this->pdfcontroller($serial);
	}
	
	public function edit_pdf(){ 
		$imagename = '';
		$id = $this->input->post('ID');
		$qry = $this->die_model->fetchdierecord($id);
		
		//unlink(PATHD.'/'.$qry['file']);
		$this->load->library('upload');
		if(isset($_FILES['file']) and $_FILES['file']!=''){
			$config['upload_path'] = custom_die_pdf;
			$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx';
			$config['max_size']	= '20000';
             
			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
             
			$field_name = "file";
			if($this->upload->do_upload($field_name)){
				$data = array('upload_data' => $this->upload->data());
				$imagename=$data['upload_data']['file_name'];
				$array = array('file'=>$imagename,'SA'=>0,'CA'=>0,'OD'=>0,'S_SA'=>0,'OL'=>0);
				$this->die_model->updatediestable($id,$array);
				//echo json_encode(array('file'=>$imagename));
			}
			else{
				$errors = $this->upload->display_errors();
			}
		}
		//return json_encode(array('d'=>$errors));
		//$this->getAwaitingOrders();
	}
     
	public function approveprice(){

		$serial = $this->input->post('serial');
	 
		$this->db->where('SerialNumber',$serial);
		$this->db->update('quotationdetails',array('die_approve'=>'Y'));
		//$this->email_to_customercare2($serial);
		
		$logs_arr = array('die_approve'=>'Y');
		$this->save_logs('Approve_custom_die',$logs_arr);
		echo "updated";
	}
    
	public function email_to_customercare2($serial){
		$orderinfo = $this->db->query("select QuotationNumber from quotationdetails where SerialNumber = '".$serial."' ")->row_array();
		
		$body = ' Customercare,     Quotation no. '.$orderinfo['QuotationNumber'].' has now been updated with the setup costs and products costs, please check the information in this quote and send to customer for approval and payment.';
	
		$this->load->library('email');
		$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject('Price updated for Custom die');
		$this->email->from('datateam@aalabels.com','DataTeam - PK');
		$this->email->to("customercare@aalabels.com"); 
		//$this->email->cc("Web.Development@aalabels.com");
		$this->email->message($body);
		$this->email->send();  
	}
     
	function removedie(){
		$serial = $this->input->post("serial");
		$this->db->where('SerialNumber',$serial);
		$this->db->update('quotationdetails',array('die_approve'=>'Y'));
		$this->db->insert('flexible_die_removed',array('serial'=>$serial));
		echo 'yes';
	}
    
    public function fetch_material(){ 
		 $id = $this->input->post('id');
		 $quote = $this->input->post('quote');
		 $serial = $this->input->post('serial');
		 return $this->fetch_view_load($id,$quote,$serial);
	 }
    
	public function fetch_view_load($id,$quote,$serial){
		$data['id']  = $id;
		$data['quote']  = $quote;
		$data['serial']  = $serial;
		$data['assoc']  = $this->die_model->fetch_custom_die_association($id);
		$theHTMLResponse = $this->load->view('die/process_die/material_popup',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
    
	public function applyoperator(){
		$serial = $this->input->post('serial');
		$price = $this->input->post('price');
	  
		$this->db->where('ID',$serial);
		$this->db->update('flexible_dies_mat',array('plainprice'=>$price,'tempprice'=>1));
		//$this->email_to_customercare($serial);
		//echo "confirm";
	}
    
    
	public function email_to_customercare($serial){
		$result = $this->die_model->fetchdierecordinfo($serial);
		$orderinfo = $this->db->query("select QuotationNumber from quotationdetails where SerialNumber = '".$result['QID']."' ")->row_array();
		
		$body = 'The product price of Quotation Number '.$orderinfo['QuotationNumber'].' for Temporary code '.$result['tempcode'].' has been updated in the Backoffice.';
		
	 	$this->load->library('email');
	 	$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject('Price Alert for Custom die');
		$this->email->from('datateam@aalabels.com','DataTeam - PK');
		$this->email->to("steve@aalabels.com"); 
		//$this->email->cc("Web.Development@aalabels.com"); 
		$this->email->message($body);
		$this->email->send();  
	}
    
    
	/*---______------____------_______------________-----Awaiting Orders--____------____------______------_____---*/
    
   	 
	public function getAwaitingOrders(){
		return $this->getAwaitingOrders2();
	}
    
	public function getAwaitingOrders2(){
		$data['data'] = $this->die_model->fetch_standard();
		$theHTMLResponse = $this->load->view('die/process_die/getAwaitingOrders',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
     
	public function fetch_comments(){ 
		$serial = $this->input->post('serial');
		return $this->commentcontroller($serial);
	}
     
	public function save_comment(){
		$serial = $this->input->post('serial');
	 	$comment = $this->input->post('comment');
		$this->db->insert('flexible_die_comments',
		array('serial'=>$serial,'comment'=>$comment,'Operator'=>$this->session->userdata('UserID'),'Time'=>time()));
		return $this->commentcontroller($serial);
	}
	 
	public function delete_comment(){
		$serial = $this->input->post('serial');
		$id = $this->input->post('id');
		$this->db->where('ID',$id);
		$this->db->delete('flexible_die_comments');
		return $this->commentcontroller($serial);
	}
     
	public function commentcontroller($serial){
		$data['serial']  = $serial;
		$data['data']  = $this->die_model->fetch_comments($serial);
		$die = $this->db->query("select diecode from flexible_dies where ID = '".$serial."' ")->row_array();
		$data['diecode'] = $die['diecode'];
		$count = count($data['data']);
		$theHTMLResponse = $this->load->view('die/process_die/comments',$data,true);
		$json_data = array('html'=>$theHTMLResponse,'count'=>$count);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
    
	public function decideForCode(){
		$id = $this->input->get('id');
		$labels = $this->input->get('label');
		$shape = $this->input->get('shape');
		$format = $this->input->get('format');
		$width = $this->input->get('width');
		$height = $this->input->get('height');

		if($format == 'Roll'){
			$this->printHtmlForCodes($this->generateCode($id,$labels,$shape,$format,$width,$height));
		}	
		else{
			$this->printHtmlForCodes($this->generateCode($id,$labels,$shape,$format,$width,$height));
		}
	}
    
	public function printHtmlForCodes($data){
		$theHTMLResponse =  $this->load->view('die/process_die/die_codes',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($json_data));
	}
    
	public function generateCode($id,$labels,$shape,$format,$width=null,$height=null){
		$data = array();
		$values = Array ( 0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E', 5 => 'F', 6 => 'G', 7 => 'H', 8 => 'I', 9 => 'J', 10 => 'K', 11 => 'L', 12 => 'M', 13 => 'N', 14 => 'O', 15 => 'P', 16 => 'Q', 17 => 'R', 18 => 'S', 19 => 'T', 20 => 'U', 21 => 'V', 22 => 'W', 23 => 'X', 24 => 'Y', 25 => 'Z', );
		$skipIrregular =  Array ( 'A','B','C','D','E','F','G','H','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R','S','T','U','V','W','X','Y','Z');
		$skipCircle = Array ( 'A','B','D','E','F','G','H','I','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R','S','T','U','V','W','X','Y','Z');
		$skipOval = Array ( 'A','C','D','E','F','G','H','I','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R','S','T','U','W','X','Y','Z');
		$skipValues = array('C','B','O','V','S','R','I','ST','HT','ST','CA','CC');
		$skipSecond = array('O');
		if($format == 'Roll'){

			$code = $this->makeCodeForLabel($this->getSecondCode($shape,$format),$width,$height);
			$qry = $this->db->query("SELECT COUNT(*) as count  from category WHERE 	labelCategory LIKE 'Roll Labels' and CategoryActive LIKE 'Y' and Width = ".$width." and Height = ".$height."  ")->result();
			$result = $this->db->query("SELECT COUNT(*) as count  from flexible_dies WHERE manufactureid LIKE '%".$code."%' ")->result();
			// print_r($code);exit;
			if($code !='false'){
				if($qry[0]->count <=0 && $result[0]->count <=0){
					$data['data'][] = ['code'=>$code,'status'=>($qry[0]->count >0)?'DeActive':'Active','id'=>$id,'format'=>$format];
					return $data;
				}else{
					$data['data'][] = ['error'=>'yes','message'=>'Diecode with  Width "'.$width.'" and Height "'.$height.'" already exists.'];
					return $data;
				}

			}else{
				return ['error'=>'yes','message'=>'please concern with Customer Service Representative Thank you. '];
			}
		}else{
            
			if(!$this->checkCode($id,$labels,$this->getCode($shape),$format)){
				for($a=0;$a<=1;$a++){
					for($b=0;$b<=25;$b++){
						if(!in_array($values[$b],$skipSecond)){
							$code = ($a == 1)?($this->getSecondCode($shape,$format)).$values[$b]:(($shape == 'Triangle')?'TR':$values[$b]);
							//echo '<br>';
							//echo $code.' ='.$a;
							$firstCode = $this->makeCode($labels,$code);
							//echo '<pre>';
							//echo $labels;exit;
							if(!in_array($code,($shape === 'Circle')?$skipCircle:($shape === 'Oval')?$skipOval:($shape === 'Irregular')?$skipIrregular:$skipValues)){
								$qry = $this->db->query("SELECT COUNT(*) as count, (LabelAcross * LabelAround) as total from category WHERE DieCode LIKE '%".$firstCode."%' HAVING total =".$labels." ")->result();
								$result = $this->db->query("SELECT COUNT(*) as count  from flexible_dies WHERE manufactureid LIKE '%".$firstCode."%' ")->result();
								if(@$result[0]->count ==0){
									$data['data'][] = ['code'=>$firstCode,'status'=>(@$qry[0]->count >0)?'DeActive':'Active','id'=>$id,'format'=>$format];
								}
							}
						}
						if($shape == 'Triangle'){
							break;
						}
					}
					if($shape == 'Triangle'){
						break;
					}
				}
				return $data;
			}
		}
	}
	
	public function getCode($shape){
		if($shape == 'Circle'){return array('C','CA','CC','CX');}
		else if($shape =='ovals'){return array('B','V'); }
		else if($shape =='Square'){return array('S');}
		else if($shape =='Rectangle'){return array('R');}
		else if($shape =='Irregular'){return array('I');}
		else if($shape =='hearts'){return array('HT');}
		else if($shape =='stars'){return array('ST');}
		else if($shape =='Triangle'){return 'TR';}
	}
 
 
 	public function getSecondCode($shape,$format){
		if($format == 'Roll'){
			if($shape == 'Circle'){return 'RC';}
			else if($shape =='Oval'){return 'RO'; }
			else if($shape =='Square'){return 'RS';}
			else if($shape =='Rectangle'){return 'RR';}
			else if($shape =='Irregular'){return 'RI';}

		}else{
			if($shape == 'Circle'){return 'C';}
			/* else if($shape =='Oval'){$values = array('B','V');$number = rand(0,1);return $values[$number];}*/
			else if($shape =='Oval'){return 'B';}
			else if($shape =='Square'){return 'S';}
			else if($shape =='Rectangle'){return 'R';}
			else if($shape =='Irregular'){return 'I';}
			else if($shape =='hearts'){return 'HT';}
			else if($shape =='stars'){return 'ST';}
			else if($shape =='Triangle'){return 'TR';}
		}
	}
    
	public function checkCode($id,$labels,$shapes,$format){
		$data = array();
		foreach($shapes as $shape){
			$firstCode = $this->makeCode($labels,$shape);
			if(!$firstCode){
				$data['data'][] = ['error'=>'yes','message'=>'please concern with Customer Service Representative Thank You.'];
			}else{
				$qry = $this->db->query("SELECT COUNT(*) as count, (LabelAcross * LabelAround) as total from category WHERE DieCode LIKE '%".$firstCode."%' HAVING total =".$labels." ")->result();
				if(empty($qry)){
					$data['data'][] = ['code'=>$firstCode,'status'=>'Active','id'=>$id,'format'=>$format];
				}
			}
		}
		return $this->printHtmlForCodes($data);
	}
   
	public function makeCode($label,$shape){
		// echo $label;exit;
		//echo $shape;exit;
		if(strlen($label) == 1 && strlen($shape) == 1){
			return $shape.'00'.$label;
		}	
		else if(strlen($label) == 1 && strlen($shape) == 2){
			return $shape.'0'.$label;
		}
		else if(strlen($label) == 2 && strlen($shape) == 1){
			return $shape.'0'.$label;
		}
		else if(strlen($label) == 2 && strlen($shape) == 2){
			return $shape.$label;
		}
		else if(strlen($label) == 3 && strlen($shape) == 1){
			return $shape.$label;
		}
		else if(strlen($label) == 3 && strlen($shape) == 2){
			return false;
		}
	}
	
	public function makeCodeForLabel($shape,$width,$height){
		
		if(strlen($width) == 1 && strlen($height) == 1 && strlen($shape) == 2){
			return $shape.'00'.$width.'00'.$height;
		}
		else if(strlen($width) == 2 && strlen($height) == 1 && strlen($shape) == 2){
			return $shape.'0'.$width.'00'.$height;
		}
		else if(strlen($width) == 3 && strlen($height) == 1 && strlen($shape) == 2){
			return $shape.$width.'00'.$height;
		}
		else if(strlen($width) == 2 && strlen($height) == 2 && strlen($shape) == 2){
			return $shape.'0'.$width.'0'.$height;
		}
		else if(strlen($width) == 2 && strlen($height) == 3 && strlen($shape) == 2){
			return $shape.'0'.$width.$height;
		}
		else if(strlen($width) == 3 && strlen($height) == 2 && strlen($shape) == 2){
			return $shape.$width.'0'.$height;
		}
		else if(strlen($width) == 1 && strlen($height) == 3 && strlen($shape) == 2){
			return $shape.'00'.$width.$height;
		}
		else if(strlen($width) == 3 && strlen($height) == 3 && strlen($shape) == 2){
			return $shape.$width.$height;
		}else if(strlen($width) == 4 && strlen($height) == 4 && strlen($shape) == 2){
			return false;
		}
	}
     
	public function updateproductsection(){
		
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$response = 'false';
		$condition ='1=2';
	
		if($type=="manufactureid"){
			$condition = 'ManufactureID LIKE "%'.$value.'%" ';
		}
		
		$query = $this->db->query("select * from products where $condition ")->num_rows();
		if($query == 0){
			$array = array($type=>$value);
			$this->die_model->updatediestable($id,$array);
			$response = 'true';
		}			
		
		$json_data = array('response'=>$response);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
     
	public function savedieline(){
		$id      = $this->input->post("id");
		$proid   = $this->input->post("productID");
		$option  = $this->input->post("option");
		$status  = $this->input->post("status");
		$serial  = $this->input->post("serial");
		$value   = $this->input->post("value");
		$orderno = $this->input->post("order");

		if($status == 37){
			$array = array('display_in'=>$option,'SA'=>1,'Status'=>71);
		}	else if($status == 71){
			$array = array('SA'=>1,'Status'=>67); 
			$this->send_email_to_customer($serial);
		}else if($status == 67){
			$array = array('SA'=>1,'Status'=>67);
		}else if($status == 72){
			$array = array('CA'=>1,'Status'=>73);
			//$this->email_to_datateam('ordered');
		}else if($status == 73){
			$array = array('OD'=>1,'Status'=>74);
			//$this->email_to_uk($serial,$value);
		}else if($status == 74){
			$array = array('S_SA'=>1,'Status'=>75);
			//$this->email_to_datateam('approved');	
		}else if($status == 75){
			$array = array('OL'=>1,'Status'=>76);	
		}else if($status == 76){
			$array = array('Status'=>7);
			$manufactureid = $this->update_detail($proid,$serial,$orderno);	
		}
		$result = $this->die_model->updatediestable($id,$array);
		
		$logs_arr = array('saved_result'=>$result,'manufactureid'=>$manufactureid,'status'=>$array,'option'=>$option,'value'=>$value,'orderno'=>$orderno);
		
		$this->save_logs('Awaiting_Custom_Die_Oders',$logs_arr);
		echo $result;
	}
     
	public function send_email_to_customer($serial){
		
		$orderinfo = $this->db->query("select ord.OrderNumber,ord.BillingFirstName,ord.Billingemail from orders as ord inner join orderdetails on ord.OrderNumber = orderdetails.OrderNumber where orderdetails.SerialNumber = '".$serial."' ")->row_array();
							 
		$data['order']    = $orderinfo['OrderNumber'];
		$data['serial']   = $serial;
		$data['username'] = $orderinfo['BillingFirstName'];
		$data['email']    = $orderinfo['Billingemail'];
	 	$data['date']     = date("dS F Y");
	 	$data['time']     = date("g:i A");
		
	 	$body = $this->load->view('die/process_die/mailtocustomer.php',$data,TRUE);  

	 	$this->load->library('email');
	 	$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject('Die Approval');
		$this->email->from('customercare@aalabels.com','Aalabels');
		$this->email->to($orderinfo['Billingemail']); 
		$this->email->message($body);
		$this->email->send();  
		echo "confirm";
	} 
     
	public function email_to_datateam($text){
	      
		$body = 'A Die has been '.$text.'. Please Review Backoffice for further Instructions.';
		$subject = ($text=="approved")?"Die-Approved":"Die-Ordered";
		
	 	$this->load->library('email');
	 	$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject($subject);
		$this->email->from('customercare@aalabels.com','Aalabels');
		$this->email->to("data.aalabels@gmail.com"); 
		// $this->email->to("kami.ramzan77@gmail.com"); 
		$this->email->message($body);
		$this->email->send();  
		echo "confirm";	
	}
	   
    
	public function email_to_uk($serial,$value){
		$orderinfo = $this->db->query("select OrderNumber from orderdetails where SerialNumber = '".$serial."' ")->row_array();
							 
		$data['date']     = date("dS F Y");
	 	$data['time']     = date("g:i A");
		$data['value']    = $value;
		$data['order']    = $orderinfo['OrderNumber'];
		
		$body = $this->load->view('customdie/mailtouk.php',$data,TRUE); 
		
	 	$this->load->library('email');
	 	$this->email->initialize(array('mailtype' =>'html',));
	 	$this->email->subject('Product Approval - Demo');
		$this->email->from('customercare@aalabels.com','Aalabels');
	 	$this->email->to("steve@aalabels.com"); 
		//$this->email->cc("Web.Development@aalabels.com");
		$this->email->message($body);
		$this->email->send();  
		echo "confirm";	
	}
    
    
	public function fetch_awaiting_order_material(){ 
		$serial = $this->input->post('serial');
		$order = $this->input->post('order');
		$manufactureid = $this->input->post('manufactureid');
		$status = $this->input->post('status');
        
		return $this->fetch_awaiting_order_material_view($serial,$order,$manufactureid,$status);
	}
    
	public function fetch_awaiting_order_material_view($serial,$order,$manufactureid,$status){
		$data['order'] = $order;
		$data['serial']  = $serial;
		$data['manufactureid'] = $manufactureid; 
		$data['status'] = $status;
		$theHTMLResponse = $this->load->view('die/process_die/dieandmat',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));     
	}
	
	public function getReorderOrdersListing(){
		return $this->getReorderOrdersListingView();
	}	
    
	public function getReorderOrdersListingView(){
		$data['reorder'] = $this->die_model->fetch_reorderdies();	
		$theHTMLResponse = $this->load->view('die/process_die/reorder',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}





public function reorder_pricecontroller($serial = ""){
		
	$Flexible_dies_id = $this->input->post('Flexible_dies_id');
	if($Flexible_dies_id == ''){$Flexible_dies_id = $serial;}else{$serial=$Flexible_dies_id;}
	$die = $this->db->query("select diecode from flexible_dies where ID = '".$serial."' ")->row_array();
	$data['result'] = $this->die_model->reorder_flexiblepricing($serial);
	$data['serial'] = $serial;
	$data['diecode'] = $die['diecode']; 
	$theHTMLResponse = $this->load->view('die/process_die/reorder_flexiblepricing',$data,true);
	$json_data = array('html'=>$theHTMLResponse,'ser'=>$data['result']);
	$this->output->set_content_type('application/json');	
	$this->output->set_output(json_encode($json_data));
}


public function save_reorder_flexiblepricing(){
	$serial = $this->input->post('serial');
	$supplier = $this->input->post('supplier');
	$price = $this->input->post('value');
	$sprice = $this->input->post('svalue');
	 
	$this->db->insert('reorder_flexiblepricing',
										array('serial'=>$serial,'sprice'=>$sprice,'price'=>$price,'supplier'=>$supplier,'Operator'=>$this->session->userdata('UserID'),'Time'=>time()));
	$insertid = $this->db->insert_id();
	$imagename = '';
		$this->load->library('upload');
	//unlink(PATHD.'/'.$qry['file']);
	if(isset($_FILES['file']) and $_FILES['file']!=''){
		$config['upload_path'] = custom_die_pdf;
		$config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx';
		$config['max_size']	= '20000';
		
		// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
		$field_name = "file";
		if($this->upload->do_upload($field_name)){
			$data = array('upload_data' => $this->upload->data());
			$imagename = $data['upload_data']['file_name'];
			$this->db->where('ID',$insertid);
			$this->db->update('reorder_flexiblepricing',array('pdf'=>$imagename));
		}
	}
	
	$this->reorder_pricecontroller($serial);	
}


	public function delete_reorderFlexiblepricing(){
	 $serial = $this->input->post('serial');
	 $id = $this->input->post('id');
	 $this->db->where('ID',$id);
	 $this->db->delete('reorder_flexiblepricing');
	 $this->reorder_pricecontroller($serial);
	}
   

 public function updtfile_reorderFlexiblepricing(){ 
	 $imagename = '';
	 $id = $this->input->post('ID');
	 $serial = $this->input->post('serial');
	 $qry = $this->die_model->reorder_fetchdierecord($id);
	 $this->load->library('upload');
		//unlink(PATHD.'/'.$qry['file']);
	 if(isset($_FILES['file']) and $_FILES['file']!=''){
		 $config['upload_path'] = custom_die_pdf;
		 $config['allowed_types'] = 'png|doc|docx|pdf|jpg|jpeg|gif|eps|ai|xls|xlsx';
		 $config['max_size']	= '20000';
		 // Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		 $field_name = "file";
		 if($this->upload->do_upload($field_name)){
			 $data = array('upload_data' => $this->upload->data());
			 $imagename=$data['upload_data']['file_name'];
			 $this->db->where('ID',$id);
			 $this->db->update('reorder_flexiblepricing',array('pdf'=>$imagename));
			 $this->reorder_pricecontroller($serial);
		 }
	 }
 } 
	
	
	public function reorder_apply_price(){
		
	 $serial = $this->input->post('serial');
	 $id = $this->input->post('id');
	 
	 $this->db->where('serial',$serial);
	 $this->db->update('reorder_flexiblepricing',array('status'=>'0'));
	 
	 $this->db->where('ID',$id);
	 $this->db->update('reorder_flexiblepricing',array('status'=>'1'));
	 
	 $price = $this->db->query("select sprice from reorder_flexiblepricing where ID = $id")->row_array();
	 $price = $price['sprice'];
	 
	 $SerialNumber = $this->db->query("select SerialNumber from flexible_dies where ID =$serial")->row_array();
	 $SerialNumber =  $SerialNumber['SerialNumber'];
	  return $this->reorder_pricecontroller($serial);
	}
	
	
	
	public function editables_reorder(){
		$id = $this->input->post('id');	
		$serial = $this->input->post('serial');
		$supplier = $this->input->post('supplier');
		$price = $this->input->post('value');
		$sprice = $this->input->post('svalue');
	 
		$this->db->where('ID',$id);
		$this->db->update('reorder_flexiblepricing',array('serial'=>$serial,'sprice'=>$sprice,'price'=>$price,'supplier'=>$supplier,'Operator'=>$this->session->userdata('UserID'),'Time'=>time()));
		$this->reorder_pricecontroller($serial);
	}
	
	public function getCustomarAproval(){
		
		return $this->getCustomarAprovalView();
	}
    
	public function getCustomarAprovalView(){
		$data['pending'] = $this->die_model->fetch_pending();	
		$theHTMLResponse = $this->load->view('die/process_die/getAwaitingApproval',$data,true);
		$json_data = array('html'=>$theHTMLResponse);
		$this->output->set_content_type('application/json');	
		$this->output->set_output(json_encode($json_data));
	}
		
	public function updatePlateStatuses() {
		
		$selectedStatusValue = $this->input->post('selectedStatusValue');	
		$plate_id = $this->input->post('plate_id');

		$this->db->where("id",$plate_id);
      	$this->db->update("label_embellishment_finish_plates",array('status'=>$selectedStatusValue,'updated_date'=>date("Y-m-d H:i:s")));
	}

	public function updateSupplierStatuses() {
		
		$selectedSupplierValue = $this->input->post('selectedSupplierValue');	
		$plate_id = $this->input->post('plate_id');

		$this->db->where("id",$plate_id);
      	$this->db->update("label_embellishment_finish_plates",array('supplier_id'=>$selectedSupplierValue,'updated_date'=>date("Y-m-d H:i:s")));
	}

	function movetoproduction(){
        $diecode = $this->input->post("diecode");
        $serial = $this->input->post("serial");
        $orderno = $this->input->post("order");
        $matid = $this->input->post("matid");
        
        /*$diecode = 'AARC04HGP';
        $serial = '362359';
        $orderno = 'AA227595';
        $matid = '2630';*/
        
        
        
        //$diecode = 'AAS008BEP';
        $manufactureid = $this->update_detail($diecode,$serial,$orderno,$matid);
        echo $manufactureid;	
	 }

     public function update_detail($proid,$serial,$orderno,$matid){
		
      $query   = $this->db->query("select ProductID, ManufactureID, ProductCategoryName from products where ManufactureID LIKE '".$proid."' ");
      $detail  = $query->row_array();
      //echo $this->db->last_query();
      
      
        //echo '<pre>'; print_r($detail);  exit;
         
         
         
	
      $dieinfo = $this->quoteModel->fetch_custom_die_order($serial);
      $matinfo = $this->die_model->fetchmaterinfo($matid);

         // echo '<pre>';print_r($dieinfo); 
         //echo '<pre>'; print_r($matinfo); 
        //exit;
      $labelsperroll = $dieinfo['labels'];
    
      $iscustom = 'No'; $prntwound = ''; $orien = '';
      if($dieinfo['format']=="Roll"){
       $prntwound = $matinfo['wound'];
       $iscustom = 'Yes';
       $orien = ($matinfo['wound']=="Outside")?1:5;
       $labelsperroll = $matinfo['rolllabels']/$matinfo['qty'];
     }
	
     $prodname = $detail['ProductCategoryName'];
	
    if($dieinfo['format']=="Roll" && $matinfo['labeltype']=="printed"){
      $productname1  = explode("-",$detail['ProductCategoryName']);
      $productname1[1] = str_replace("(","",$productname1[1]);
      $productname1[1] = str_replace(")","",$productname1[1]);
      $productname1[0] = str_replace("rolls labels","",$productname1[0]);
      $productname1[0] = str_replace("roll labels","",$productname1[0]);
      $productname1[0] = str_replace("Roll Labels","",$productname1[0]);
	 
      $productname1  = "Printed Labels on Rolls - ".str_replace("roll label","",$productname1[0]).' - '.$productname1[1];
      $prodname = ucfirst($productname1).' '.$prntwound.' - Orientation '.$orien.', ';
	 
      if($matinfo['finish'] == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
      else{  $labelsfinish = ' With Label finish : '.$matinfo['finish']; }
      $prodname.= $matinfo['printing'].' '.$labelsfinish;
    }
	
    $OrdDetail =  array(
      'OrderNumber' => $orderno,
      'ProductID' =>$detail['ProductID'],
						'ManufactureID'=>$detail['ManufactureID'],
						'Quantity' =>$matinfo['qty'],
						'LabelsPerRoll'=>$labelsperroll,
                        'labels'=>$matinfo['qty'] * $labelsperroll,
						'is_custom'=>$iscustom,
						'ProductName' =>$prodname,
						'Price' =>$matinfo['plainprice'],
						'ProductTotalVAT' =>$matinfo['plainprice']*1.2,
						'ProductTotal' =>$matinfo['plainprice']*1.2,	
						'ProductionStatus'=>1,
                        'Wound'=>$prntwound,
						'machine'=>''
    );
					 
					
    if($matinfo['labeltype']=="printed"){
      $prntdesign = ($matinfo['designs']==1)?"1 Design":"Multiple Designs";
      $print = array(
        'Printing'=> 'Y',
        'Print_Type'=> $matinfo['printing'],
        'Print_Design'=> $prntdesign,
        'Print_Qty'=> $matinfo['designs'],
        'Free'=> 1,
        'FinishType'=>$matinfo['finish'],
        'Print_UnitPrice'=>$matinfo['printprice'],
        'Print_Total'=>$matinfo['printprice'],	
        'Orientation'=>$orien
      );
      $OrdDetail = array_merge($OrdDetail,$print);
		                    
      $this->db->where("OrderNumber",$orderno);
      $this->db->update("orders",array('OrderStatus'=>55,'Old_OrderStatus'=>''));
    }


	 //echo '<pre>'; print_r($OrdDetail);    exit;
    $this->db->insert('orderdetails', $OrdDetail); 
					
    $matarray = array('status'=>1);
    $this->db->where('ID',$matid);
    $this->db->update("flexible_dies_mat",$matarray);
					
    $countassoc = $this->die_model->statuscheck($dieinfo['ID']);
    if($countassoc==0){
      $array = array('ProductionStatus'=>3,'Linescompleted'=>1,'machine'=>'');
      $this->db->where("SerialNumber",$serial);
      $this->db->update("orderdetails",$array);
					  
      $this->db->where("SerialNumber",$serial);
      $this->db->update("flexible_dies",array('Status'=>7));
    }

    //print_r($detail['ManufactureID']);
			//exit;
    return $detail['ManufactureID'];
  }
	
	
}