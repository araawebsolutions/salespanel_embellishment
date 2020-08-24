<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Info extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('ProductInfoModel');
    }

//---------------------STAR OF FILE---------------------

    public function index()
    {
        $data['main_content'] = "product_info/product_info";
        $this->load->view('page', $data);
    }
	
	
	function getdie()
	{

		$val = $this->input->get('term');

		$data = $this->ProductInfoModel->getdielist($val);

		echo json_encode($data);

	}
	
	public function product_info_datatable() {
        $this->datatables->select('ID,ManufactureID,Detail,ID as edit')->from('product_info');
        echo  $this->datatables->generate();
    }
	   
	public function add_product_info() {
        $name = $this->input->post('name');
		$detail = $this->input->post('detail');
		$this->db->insert('product_info',array('ManufactureID'=>$name,'Detail'=>$detail));					
	}   
	
	public function delete_product_info() {
		$id = $this->input->post('id');
		$this->db->delete('product_info',array('ID'=>$id));
		echo 'deleted';
	   }
	   public function update_product_info() {
		$id = $this->input->post('id');
		$detail = $this->input->post('detail');
		$this->db->update('product_info',array('Detail'=>$detail),array('ID'=>$id));
		echo 'updated';
	   }
	   
}	