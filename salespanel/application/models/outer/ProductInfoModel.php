<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class ProductInfoModel extends CI_Model {
	
	function __construct(){
		parent::__construct();      
	}
	
	
	//******************************************************************************************************************************
	function getdielist($val)

	{

		 

		$this->db->limit('20');

		$this->db->select('products.ManufactureID,products.EuroID,ProductCategoryName,(select code from batch_material where description=ProductName) as code,category.Shape_upd,category.LabelWidth,category.LabelHeight,category.specification3') 

		->join('category','category.CategoryID=products.CategoryID','INNER')

		->like('products.ManufactureID',$val,'both');

		$row = $this->db->get('products');

		$row = $row->result();  

		foreach($row as $row){

				if($row->Shape_upd=='Circular'){

					$size = $row->specification3;

				

				}else{

				

					$size = "Label Size : ".$row->LabelHeight.' x '.$row->LabelWidth;

				}
    if(isset($row->EuroID) && $row->EuroID!=""){
      $show_man = $row->EuroID; 
    }else{
      $show_man = $row->ManufactureID;
    }

			$data[]= array(

				'label' => $show_man." ".$size,

				'value'	=> $row->ManufactureID,

				'id'	=> $row->ProductCategoryName,

				'code'	=> $row->code

			); 

		};

		if(empty($data)){

				$data[]= array('label' => 'No Recode Found');

		}

		return $data; 

	}
	
  	//******************************************************************************************************************************

}

?>
