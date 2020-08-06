<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_model extends CI_Model {

  public function getAllinvoice(){
    $ordby = $_POST['sSortDir_0'];
    $this->datatables->select('InvoiceNumber as invoice, InvoiceType,FROM_UNIXTIME(OrderDate,"%d/%m/%Y"),FROM_UNIXTIME(OrderDate,"%h:%i %s %p") as time')
      ->select('InvoiceTitle')
      ->select('InvoicePhone')
      ->select('InvoiceTotal')
      ->select('OrderNumber')
      ->select('InvoiceNumber as link')
      ->select('RefInvoice')
      ->select('status,currency,exchange_rate')
      ->from('invoice');
     
    echo $this->datatables->generate();
  }

  //----------------------------------------------------------------------------------
  
  function menufacture($id){
    $query=$this->db->query("select  ManufactureID from products  where ProductID='".$id."'");
    $res=$query->result();
    return $res;
  }
	
		//----------------------------------------------------------------------------------

  function getinvoicenumber($order){
    $sql = $this->db->query("select InvoiceNumber from invoice where OrderNumber LIKE '$order' and InvoiceType = 'Invoice'");
    $result = $sql->row_array();
    return $result['InvoiceNumber']; 	
  }
	
		//----------------------------------------------------------------------------------
	
    public function OrderDetails($invoice) {
      $query = $this->db->get_where('notedetails', array('InvoiceNumber' => $invoice));
      return $query->result();
    }

	//----------------------------------------------------------------------------------

    public function OrderInfo($invoice) {
      $query = $this->db->get_where('note', array('InvoiceNumber' => $invoice));
      return $query->result();
    }

      public function NoteInfo($invoice) {
        $query = $this->db->query("select * from note where InvoiceNumber = '$invoice'");
        return $query->row_array();
    }
    
    
    
    function ReplaceHtmlToString_($text ){



		$utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return $string =  preg_replace(array_keys($utf8), array_values($utf8), $text);

	}
	
		//----------------------------------------------------------------------------------
	}
?>