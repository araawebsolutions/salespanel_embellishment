<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class orderAttachment extends CI_Model
{
   public function getOrderAttachment($serial){
       return $this->db->query("select * from order_attachments_integrated where Serial = $serial")->row_array();
   }


}