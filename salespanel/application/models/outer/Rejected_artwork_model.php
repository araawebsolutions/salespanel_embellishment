<?php
class Rejected_artwork_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	


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
    function get_operator($operator){
        $qry = $this->db->query("select UserName from customers where UserID = $operator ");
        $data = $qry->row_array();
        return $data['UserName'];
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
	
	

    function attachmentItegrated($attch_id){

        return $this->db->select("oai.*,od.Wound,od.Orientation,od.FinishType,od.ManufactureID,od.pressproof,p.ProductBrand,")
            ->from('order_attachments_integrated oai')
            ->join('orderdetails od','od.SerialNumber = oai.Serial')
            ->join('products p','p.ProductID = od.ProductID')
            ->where('oai.ID',$attch_id)
            ->get()->row();


    }
    function getArtworkChat($attch_id){

        return $this->db->select("ac.*")
            ->from('artwork_chat ac')
            ->where('ac.attach_id',$attch_id)
            ->where('ac.latest',1)
            ->get()->row();


    }


    function getAttachmentItegrated($attch_id){

        return $this->db->select("oai.*")
            ->from('order_attachments_integrated oai')
            ->where('oai.ID',$attch_id)
            ->get()->row();


    }

    public function approveJob($integratedId){

        $artworkChat = (array)$this->getArtworkChat($integratedId);

        $orderAttachMent = (array)$this->getAttachmentItegrated($integratedId);

        $artworkOpratorChecklist = $this->getArtworkOperatorList();

        $artworkChat['latest'] = '0';

        $orderAttachMent['is_upload_print_file'] ='0';

        $orderAttachMent['rejected'] ='0';

        $orderAttachMent['print_file'] = $artworkChat['file'];

        $this->db->where('ID',$artworkChat['ID']);

        $this->db->update('artwork_chat',$artworkChat);

        $this->db->where('ID',$orderAttachMent['ID']);

        $this->db->update('order_attachments_integrated',$orderAttachMent);

        $this->db->insert('artwork_oprator_checklist',$artworkOpratorChecklist);

        $artworkTimeLine = array('Jobno'=>$integratedId,'operator'=>$this->session->userdata('UserID'),'Action'=>'1','Time'=>time());

        $this->db->insert('artwork_timeline',$artworkTimeLine);

        return  true;
    }

    public function  declineJob(){
	    $orderIntegratedId = $this->input->get('orderIntegratedId');
        $comment = $this->input->get('comment');

        $artworkChat = (array)$this->getArtworkChat($orderIntegratedId);

        $artworkChat['latest'] = '0';

        $this->db->where('ID',$artworkChat['ID']);

        $this->db->update('artwork_chat',$artworkChat);

        $params = array(
            'attach_id'=>$orderIntegratedId,
            'operator'=>$this->session->userdata('UserID'),
            'comment'=>$comment,
            'softproof'=>"",
            'thumb'=>"",
            'file'=>"",
            'pdf'=>"",
            'time'=>date('Y-m-d h:m:s'),
            'status'=>'N',
        );

        $this->db->insert('artwork_chat',$params);
        $artworkTimeLine = array('Jobno'=>$orderIntegratedId,'operator'=>$this->session->userdata('UserID'),'Action'=>'1','Time'=>time());

        $this->db->insert('artwork_timeline',$artworkTimeLine);

        return true;
    }

    public function getArtworkOperatorList(){
	    return array(
	        'font'=>$this->input->get('font'),
	        'Copy_content'=>$this->input->get('Copy_content'),
	        'Colours'=>$this->input->get('Colours'),
	        'label_size'=>$this->input->get('label_size'),
	        'templateid'=>$this->input->get('templateid'),
	        'material'=>$this->input->get('material'),
	        'designname'=>$this->input->get('designname'),
	        'bleed'=>$this->input->get('bleed'),
	        'safe_margin'=>$this->input->get('safe_margin'),
	        'orientation'=>$this->input->get('orientation'),
	        'whitifaplicable'=>$this->input->get('whitifaplicable'),
        );
    }

    public function getJobStatus($statusId){
        $qry = $this->db->query("select StatusTitle from dropshipstatusmanager where StatusID LIKE ".$statusId." ")->row_array();
        return $qry['StatusTitle'];
    }
    function getmaterialcode($text){

        preg_match('/(\d+)\D*$/', $text, $m);
        $lastnum = $m[1];
        $mat_code = explode($lastnum,$text);
        return strtoupper($mat_code[1]);

    }

   

    function fetch_order_comments($order){
        $qry = $this->db->query("select * from artwork_comments where OrderNumber LIKE '".$order."' ")->result();

        return $qry;

    }

    function getOrderAssigny($orderNumber){
        $qry = $this->db->query("select designer,assigny from orders  where OrderNumber LIKE '".$orderNumber."' ")->result();
        return $qry;
    }
    public function getComments($orderIntegratedId){

        $chats = $this->db->select("*")
            ->from('artwork_chat ac')
            ->where('ac.attach_id',$orderIntegratedId)
            ->get()->result();

        return $chats;
    }


    function orderAttachmentsIntegrated($orderNumber){
        $qry = $this->db->query("select * from order_attachments_integrated where OrderNumber LIKE '".$orderNumber."' and source != 'flash' ")->result();
        return $qry;
    }

    public function orderChatData($integratedId){

        $qry = $this->db->query("select * from artwork_chat where attach_id LIKE '".$integratedId."' order by 'DESC' ")->row();
        return $qry;
    }

    public function uploadChatForRejectedArtwork(){
	   return $this->makeChatArray();
    }

    public function getOrderAttachIds($orderNumber){
        $qry = $this->db->query("select ID from order_attachments_integrated where OrderNumber LIKE '".$orderNumber."'  ")->result_array();
        return $qry;
    }

    public function makeChatArray(){
	   // print_r($_FILES['pff_file']['name']);exit;
	    $params = array(
	        'attach_id'=>$this->input->post('orderIntegratedId'),
	        'operator'=>$this->session->userdata('UserID'),
	        'comment'=>$this->input->post('chat_detail'),
	        'softproof'=>(!empty($_FILES['sf_file']['name']))?$this->uploadImages('sf_file','softproof/'):'',
	        'thumb'=>(!empty($_FILES['thumnal']['name']))?$this->uploadImages('thumnal','thumb/'):'',
	        'file'=>(!empty($_FILES['pff_file']['name']))?$this->uploadImages('pff_file','print/'):'',
            'pdf'=>(!empty($_FILES['design']['name']))?$this->uploadImages('design','pdf/'):'',
	        'time'=>date('Y-m-d h:m:s'),
	        'status'=>'N',
        );
        //print_r($params);exit;
        if(!empty($_FILES['pff_file']['name'])){
            $this->db->where('ID',$this->input->post('orderIntegratedId'));
            $this->db->update('order_attachments_integrated',array('is_upload_print_file'=>'1'));

            $artworkTimeLine = array('Jobno'=>$this->input->post('orderIntegratedId'),'operator'=>$this->session->userdata('UserID'),'Action'=>'1','Time'=>time());
            $this->db->insert('artwork_timeline',$artworkTimeLine);
            $params['latest'] = '1';
        }

//        if(!empty($_FILES['sf_file']['name']) || !empty($_FILES['thumnal']['name']) || !empty($_FILES['pff_file']['name']) || !empty($_FILES['design']['name'])){
//
//        }
	    return $this->db->insert('artwork_chat',$params);

    }

    function uploadImages($field_name,$path){

        $config['upload_path']          = upload_sf_thm_des.'/'.$path;

//        print_r($config['upload_path']);

        $config['allowed_types']        = '*';
        $config['max_size']             = 1000000;
        $config['max_width']            = 1024000;
        $config['max_height']           = 7680000;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload($field_name))
        {
            print_r($this->upload->display_errors());


        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            return $data['upload_data']['file_name'];
        }
    }

    public function getFileExtention($name){
        if($name !=null){
            return substr($name, -3);
        }else{
            return '';
        }

    }

    public function getFileSrc($fileName){
	    $name = strtolower($this->getFileExtention($fileName));

	    if($name == 'pdf'){
            return "<embed width='150' height='140' name='plugin' src='".cs_rejected_artwork.$fileName."' type='application/pdf'>";
        }
        elseif($name == 'jpg' || $name == 'png'){
	        return "<img src='".cs_rejected_artwork.$fileName."'>";
        }


    }



}

