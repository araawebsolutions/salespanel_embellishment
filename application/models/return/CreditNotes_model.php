<?php
class creditNotes_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
    
	public function allCreditNotes(){
		$res =  $this->datatables->select('c.ticketID')
			//$this->datatables->select('c.ticketID')
			->select('t.ticketSrNo')
            
			->select('(SELECT GROUP_CONCAT(DISTINCT  credit_details.orderNumber) as f FROM `credit_notes`
                        inner join  `credit_details` on credit_details.ticketID=credit_notes.ticketID 
                        WHERE credit_notes.ticketID=c.ticketID)')    
            
			->select('concat(FROM_UNIXTIME(c.OrderDate, "%d/%m/%Y"))')
			->select('concat(FROM_UNIXTIME(c.OrderTime, "%r"))')
			->select('(select concat(credit_notes.BillingFirstName," ",credit_notes.BillingLastName) as customer from credit_notes  where credit_notes.cr_id=c.cr_id )')
			->select('concat(c.Billingtelephone)')
			//->select('(SELECT GROUP_CONCAT(DISTINCT products.ProductBrand) as f FROM `ticket_details` inner join orderdetails on orderdetails.SerialNumber=ticket_details.serialNumber inner join products on products.ProductID = orderdetails.ProductID where ticket_id = t.ticket_id)')
			// ->select('(SELECT concat((CASE WHEN (credit_notes.currency = "GBP") THEN "£" WHEN (credit_notes.currency = "EUR") THEN "€" WHEN (credit_notes.currency = "USD") THEN "$" END),"",sum(credit_details.ProductTotal)) as amount FROM `credit_notes` inner join  `credit_details` on credit_details.ticketID=credit_notes.ticketID WHERE credit_notes.ticketID=c.ticketID)')
            
			->from('credit_notes as c')
			->join('tickets as t','t.ticket_id=c.ticketID');
		//echo $this->db->last_query(); exit;
		return $this->datatables->generate();
	}
    
	function OrderDetails($id){
		$this->db->select('*');
		$this->db->select('(SELECT GROUP_CONCAT(DISTINCT  credit_details.orderNumber) as f FROM `credit_notes`
                        inner join  `credit_details` on credit_details.ticketID=credit_notes.ticketID 
                        WHERE credit_notes.ticketID=c.ticketID) as all_orderno')  ;  
		$this->db->from('credit_notes as c');
		$this->db->join('tickets','tickets.ticket_id=c.ticketID');
		$this->db->where(array('c.ticketID'=>$id));
		$res = $this->db->get()->result();
		return $res;
	}
    
    
	function OrderDetailsPdf($id){
		$this->db->select('*');
		$this->db->select('(SELECT GROUP_CONCAT(DISTINCT  credit_details.orderNumber) as f FROM `credit_notes`
                        inner join  `credit_details` on credit_details.ticketID=credit_notes.ticketID 
                        WHERE credit_notes.ticketID=c.ticketID) as all_orderno')  ;  
		$this->db->from('credit_notes as c');
		$this->db->join('tickets','tickets.ticket_id=c.ticketID');
		$this->db->where(array('c.cr_id'=>$id));
		$res = $this->db->get()->result();
		return $res;
	}
    
    
	function noteDetails($id){
		$this->db->select('cd.*,cn.currency');
		$this->db->select('concat((CASE 
		WHEN (cn.currency = "GBP") THEN "£" 
		WHEN (cn.currency = "EUR") THEN "€" 
		WHEN (cn.currency = "USD") THEN "$" 
		END),"",cd.price) as ExVat');
		$this->db->select('concat((CASE 
		WHEN (cn.currency = "GBP") THEN "£" 
		WHEN (cn.currency = "EUR") THEN "€" 
		WHEN (cn.currency = "USD") THEN "$" 
		END),"",cd.ProductTotal) as IsVat');
		$this->db->from('credit_details as cd');
		$this->db->join('credit_notes as cn','cn.ticketID=cd.ticketID');
		$this->db->where(array('cd.ticketID'=>$id));
		$res = $this->db->get()->result();
		//echo $this->db->last_query(); exit;
		return $res;
	}
    
    
	function noteDetailsPdf($id){
		$this->db->select('cd.*,cn.currency,cn.OrderShippingAmount,cn.DiscountInPounds,cn.PaymentMethods,cn.vat_exempt,cn.DiscountedPrice');
		$this->db->select('concat((CASE 
		WHEN (cn.currency = "GBP") THEN "£" 
		WHEN (cn.currency = "EUR") THEN "€" 
		WHEN (cn.currency = "USD") THEN "$" 
		END),"",cd.price) as ExVat');
		$this->db->select('concat((CASE 
		WHEN (cn.currency = "GBP") THEN "£" 
		WHEN (cn.currency = "EUR") THEN "€" 
		WHEN (cn.currency = "USD") THEN "$" 
		END),"",cd.ProductTotal) as IsVat');
		$this->db->from('credit_details as cd');
		$this->db->join('credit_notes as cn','cn.ticketID=cd.ticketID');
		$this->db->where(array('cn.cr_id'=>$id));
		$res = $this->db->get()->result();
		//echo $this->db->last_query(); exit;
		return $res;
	}
    
    
	public function getShipingServiceName($serviceID){
		$sql = $this->db->query("select * from shippingservices where ServiceID='".$serviceID."'");
		$service = $sql->row_array();

		return $service;
	}

	public function getShipingService($conID){
		$sql = $this->db->query("select * from shippingservices where CountryID='".$conID."' order by ServiceID ASc ");
		$service = $sql->result_array();

		return $service;
	}
    
	public function manufactureid($domain,$id)
	{
		if($domain=='123'){$ManufactureID='123ManufactureID';}else{$ManufactureID='ManufactureID';}
		$this->db->select($ManufactureID);
		$this->db->where('ProductID',$id);
		$query = $this->db->get('products');
		$row = $query->result();
		return $row[0]->$ManufactureID;
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
    
	public function fetch_custom_die_order($id){
		$query = $this->db->query("SELECT * from flexible_dies_info WHERE OID = '$id' ");
		$row = $query->row_array();	
		return $row;
	}
    
	function get_details_roll_quotation($id){
		$query = $this->db->query("SELECT * from roll_print_basket WHERE SerialNumber = '$id' ");
		$row = $query->row_array();	
		return $row;
	}
    
	function get_printing_service_name($process){
				
		if($process == 'Fullcolour'){
			$A4Printing = ' 4 Colour Digital Process ';
		}
		else if($process == 'Mono' || $process == 'Monochrome – Black Only'){
			$A4Printing = ' Monochrome &ndash; Black Only ';
		}else{
				
					
			$A4Printing = $process;
		}
		return $A4Printing;
	}

    public function getstatus($id) {

        $query = $this->db->get_where('dropshipstatusmanager', array('StatusID' => $id));
        return $query->result();
    }

    function get_currecy_symbol($code)
    {


        $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '" . $code . "'");


        $sql = $sql->row_array();


        return $sql['symbol'];


    }



 }




