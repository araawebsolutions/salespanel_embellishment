<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class orderModal extends CI_Model
{

    public function getAllOrders($filter, $status, $duration){
        $orderBy = $_POST['sSortDir_0'];
        $where = ' 1=1 ';
        if(isset($filter) and $filter=='holdedorder'){
            $where = " orders.OrderStatus = 10 ";
        }
        else if(isset($filter) and $filter=='designer'){
            $where='(select count(*) as printlines from orderdetails where orderdetails.OrderNumber=orders.OrderNumber AND source LIKE "flash" ) > 0 ';
        }
        else if(isset($filter) and $filter=='artwork'){
            $where = " orders.OrderStatus = 55 ";
        }
        else if(isset($filter) and $filter=='offshore'){

            $where = "((orders.DeliveryCountry NOT LIKE 'United Kingdom' AND orders.DeliveryCountry NOT LIKE 'UK' AND orders.DeliveryCountry NOT LIKE '')  ) and orders.DeliveryPostcode NOT LIKE 'BT%'";

        }
        else if(isset($filter) and $filter=='xmass'){
            $where = '  (orders.PaymentMethods = "Sample order") ';
        }
        else if(isset($filter) and $filter=='printed'){
            $where='(select count(*) as printlines from orderdetails where orderdetails.OrderNumber=orders.OrderNumber AND Printing LIKE "Y" and orderdetails.ProductName LIKE "%Sheet%") > 0 ';
        }
        else if(isset($filter) and $filter=='rollprint'){
            $where='(select count(*) as printlines from orderdetails where orderdetails.OrderNumber=orders.OrderNumber AND (ManufactureID LIKE "PRL1" || orderdetails.ProductName LIKE "%Printed Labels on Rolls%")  ) > 0 ';
        }
        else if(isset($filter) and $filter=='lba'){
            $where="(select count(*) from orderdetails where orderdetails.OrderNumber=orders.OrderNumber 
			 AND  orderdetails.ProductID!=0 AND  RIGHT( ManufactureID, 4 ) REGEXP '^-?[0-9]+$' ) > 0 ";
        } else if(isset($filter) and $filter=='pko'){
            $where = '  (orders.Label = 1) ';

        }else if(isset($filter) and $filter=='Other'){
            $where = '(orders.DeliveryCountry NOT LIKE "Austria" and orders.DeliveryCountry NOT LIKE "Belgium" and
						orders.DeliveryCountry NOT LIKE "Sweden" and orders.DeliveryCountry NOT LIKE "Italy" and 
					  orders.DeliveryCountry NOT LIKE "Finland" and orders.DeliveryCountry NOT LIKE "Ireland" and 
					  orders.DeliveryCountry NOT LIKE "Denmark" and orders.DeliveryCountry NOT LIKE "Luxembourg" and 
					  orders.DeliveryCountry NOT LIKE "Germany" and orders.DeliveryCountry NOT LIKE "Holland" and 
					  orders.DeliveryCountry NOT LIKE "Spain" and orders.DeliveryCountry NOT LIKE "Portugal"and 
					  orders.DeliveryCountry NOT LIKE "France" and orders.DeliveryCountry NOT LIKE "Switzerland"and 
					  orders.DeliveryCountry NOT LIKE "Norway" and orders.DeliveryCountry NOT LIKE "United Kingdom"  and 
					  orders.DeliveryCountry NOT LIKE "Southern Ireland" and orders.DeliveryPostcode NOT LIKE "BT%" ) ';
        }
        else if(isset($filter) and $filter!='all'){
            $where = '(orders.DeliveryCountry LIKE "'.$filter.'") ';
            if($filter == "Ireland"){
                $where = " (orders.DeliveryCountry LIKE 'Southern Ireland') or (orders.DeliveryCountry LIKE '".$filter."' and orders.DeliveryPostcode NOT like 'BT%') ";
            }
        }
        if(isset($status) and $status !='all')
        {
            $where .= " AND orders.OrderStatus = $status";
        }
        if(isset($duration) and $duration !='all')
        {
            if($duration == 7)
            {
                $where .= " AND orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY )) AND UNIX_TIMESTAMP(NOW())";
            }
            else if($duration == 30)
            {
                $where .= " AND orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 MONTH )) AND UNIX_TIMESTAMP(NOW())";
            }
            else if($duration == 90)
            {
                $where .= " AND orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 MONTH )) AND UNIX_TIMESTAMP(NOW())";
            }
            else if($duration == 180)
            {
                $where .= " AND orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 6 MONTH )) AND UNIX_TIMESTAMP(NOW())";
            }
        }

        $empty = '1';
        $empty2 = '2';
        //$this->db->query("set time_zone = 'CET'");
        $this->datatables->select('orders.OrderID,orders.OrderNumber,Billingemail')

            // ->select('(orders.OrderTotal + orders.OrderShippingAmount) AS OrderTotal')
            ->select("if( orders.vat_exempt LIKE 'yes', round(((orders.OrderTotal + orders.OrderShippingAmount)/1.2),2), round((orders.OrderTotal + orders.OrderShippingAmount),2)) AS OrderTotal")
            //->select('(select sum(orderdetails.Quantity)  from orderdetails where  orderdetails.OrderNumber=orders.OrderNumber)')
            ->select('concat(orders.BillingFirstName," ",orders.BillingLastName),orders.BillingPostcode,orders.DeliveryPostcode,orders.BillingCountry,orders.Source')
            ->select('PaymentType')
            ->select('orders.OrderStatus,orders.DeliveryResCom,orders.UserID')
            ->select('(select DeliveryResCom from customers where customers.UserID=orders.UserID )')
            ->select('orders.CustomOrder,orders.PaymentMethods,"'.$this->session->userdata("UserID").'"')
            ->select('(select UserName from customers where customers.UserID=orders.Source )')
            ->select('FROM_UNIXTIME(orders.OrderDate,"%d/%m/%Y <br> %h:%i %p"),YourRef')
            ->select('(select StatusTitle from dropshipstatusmanager where dropshipstatusmanager.StatusID=orders.OrderStatus ),orders.OrderStatus as stu,DeliveryResCom as res,vat_exempt,currency,exchange_rate')
            ->select("if(orders.vat_exempt LIKE 'yes', 'Exempt', round(((orders.OrderTotal + orders.OrderShippingAmount) - ((orders.OrderTotal + orders.OrderShippingAmount)/1.2)), 2)) AS VATRate")
            ->select('if((orders.OrderStatus = 7 OR orders.OrderStatus = 8) AND orders.DispatchedDate != "", FROM_UNIXTIME(orders.DispatchedDate,"<br>%d/%m/%Y"), "") AS DespatchedDate')
            ->select('FROM_UNIXTIME(orders.expectedDispatchDate, "%d/%m/%Y")')

            ->where($where, '', false)
            ->from('orders')
            //->edit_column('orders.OrderID','<input type="checkbox" id="checkorder" name="checkorder" value="$1" class="required">', 'orders.OrderNumber,orders.OrderStatus');

        // ->edit_column('OrderTotal', '&pound $1', 'OrderTotal');
        ->order_by("orders.OrderDate $orderBy");
        echo($this->datatables->generate());
    }


    function payment_recieved($ordernumber){
        $query = $this->db->query("select SUM(payment) as total from order_payment_log where OrderNumber LIKE '".$ordernumber."' and situation LIKE 'taken' ")->row_array();
        return $query['total'];
    }
    public function getCustomerOrders($customerId,$couont,$currentPageLink)
    {

        if($currentPageLink != 0){
            $currentPageLink = ($currentPageLink-1) * 10;
        }else{
            $currentPageLink = 0;
        }

        $results = $this->db->select("OrderID,n.InvoiceNumber as invoice,o.OrderNumber,FROM_UNIXTIME(o.OrderDate, ' %d/%m/%Y') as orderDate,o.OrderTotal,PaymentMethods,st.StatusTitle,o.exchange_rate,o.currency,o.vat_exempt,o.OrderShippingAmount")
            ->from('orders as o')

            ->join('dropshipstatusmanager as st', 'st.StatusID = o.OrderStatus','left')

            ->join('invoice as n', 'CAST(n.OrderNumber AS CHAR) = CAST(o.OrderNumber AS CHAR)','left')
            ->where('o.UserID',$customerId)

            ->order_by('o.OrderID','DESC')

            ->limit(10,$currentPageLink)

            ->get()->result_array();
			      

       // print_r($results);exit;

           return $results;

    }

    public function getCustomerTotalOrders($customerId){

        $results = $this->db->select("count(o.OrderID) totalOrder")
            ->from('orders as o')
            ->where('o.UserID',$customerId)
            ->get()->result();
        return $results;
    }

    public function getOrder($orderNumber){
        $results = $this->db->select("o.*,FROM_UNIXTIME(o.OrderDate, ' %d/%m/%Y') as date,FROM_UNIXTIME(o.OrderDate, ' %h:%i:%p') as time,st.StatusTitle")
            ->from('orders as o')
            ->join('dropshipstatusmanager as st', 'st.StatusID = o.OrderStatus','left')
            ->where('o.OrderNumber',$orderNumber)
            ->get()->result();
        return $results;
    }

    public function getOrderDetail($orderNumber){
        $results = $this->db->select("od.*,p.ProductBrand,p.ProductName as pn , p.ProductCategoryName")
            ->from('orderdetails as od')
            ->join('products as p', 'od.ProductID = p.ProductID','left')
            ->where('od.OrderNumber',$orderNumber)
            ->get()->result();
        return $results;
    }

    public function getQuotationDetail($quotationNumber){
        $results = $this->db->select("qd.*,p.ProductBrand,p.ProductName as pn , p.ProductCategoryName")
            ->from('quotationdetails as qd')
            ->join('products as p', 'qd.ProductID = p.ProductID','left')
            ->where('qd.QuotationNumber',$quotationNumber)
            ->get()->result();
        return $results;
    }
    public function getOrderDetailBySerialNumber($serialNumber){
        $results = $this->db->select("od.* ,p.*")
            ->from('orderdetails as od')
            ->join('products as p', 'od.ProductID = p.ProductID','left')
            ->where('od.SerialNumber',$serialNumber)
            ->get()->result();
        return @$results[0];
    }
    public function getCartDetailByCartId($cartId){
        $results = $this->db->select("tp.*")
            ->from('temporaryshoppingbasket as tp')
            ->where('tp.ID',$cartId)
            ->get()->result();
        return $results[0];
    }
    public function getQuotationDetailBySerialNumber($serialNumber){
        $results = $this->db->select("od.* ,p.*")
            ->from('quotationdetails as od')
            ->join('products as p', 'od.ProductID = p.ProductID','left')
            ->where('od.SerialNumber',$serialNumber)
            ->get()->result();
        return $results[0];
    }

    public function countArtworkStatusFromQuotationIntegratedBYSerialNumber($serialNumber){

        //$record = $this->getIntegratedSerialNumber($id);

        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('quotation_attachments_integrated as at')
            ->where('Serial',$serialNumber)
            ->get()->result();
    }

    public function getIntegratedSerialNumber($id){
        return $this->db->select("*")
            ->from('order_attachments_integrated as at')
            ->where('ID',$id)
            ->get()->result();
    }

    public function getOrderDetailRecord($serialNumber){
        $results = $this->db->select("od.*")
            ->from('orderdetails as od')
            ->where('od.SerialNumber',$serialNumber)
            ->get()->row_array();
        return $results;
    }
    public function getQuotationDetailRecord($serialNumber){
        $results = $this->db->select("od.*")
            ->from('quotationdetails as od')
            ->where('od.SerialNumber',$serialNumber)
            ->get()->row_array();
        return $results;
    }

    public function getOrderProducts($orderNumber){
        $final = array();
            $results = $this->db->select("*,od.ManufactureID,od.ProductName,od.Product_detail,od.Price as Price")
            ->from('orderdetails as od')
            ->join('products as p', 'od.ProductID = p.ProductID','left')
            ->join('category as cat','p.CategoryID = cat.CategoryID','left')
            ->where('OrderNumber',$orderNumber)
            ->get()->result_array();
        $customerId = $this->session->userdata('customer_id');
        foreach ($results as $result){

            //$result['price'] = $this->myPriceModel->getPrice($result['OrderNumber'],$result['ManufactureID'])['price'];
            $result['artworks'] = $this->getArtwork($result['SerialNumber']);
            $final[] = $result;
        }
        //echo '<pre>';
        //print_r($final);exit;
        return $final;
    }

    public function getArtwork($serialNumber){
			return  $this->db->select("at.*")
				->from('order_attachments_integrated as at')
				->where('Serial',$serialNumber)
				->get()->result_array();
		}






    public function getArtworkById($artworkId){
        return  $this->db->select("at.*")
            ->from('order_attachments_integrated as at')
            ->where('ID',$artworkId)
            ->get()->result_array();
    }
    public function getArtworkIntegratedById($artworkId){
        return  $this->db->select("at.*")
            ->from('integrated_attachments as at')
            ->where('ID',$artworkId)
            ->get()->result();
    }

    public function insertBatch($record){
        $this->db->insert_batch('integrated_attachments', $record);
        return true;
    }

    public function getTempArtworkTable($temCartId){

        return $this->db->select("at.*")
                ->from('integrated_attachments as at')
                ->where('CartID',$temCartId)
                ->where('CartID > 0')
                ->get()->result();
    }

    public function getArtworkByOrder($serial){
        return  $this->db->select("at.*")->from('order_attachments_integrated as at')->where('Serial',$serial)->get()->result();
    }

    public function getArtworkForQuotation($serial){
        return  $this->db->select("at.*")
            ->from('quotation_attachments_integrated as at')
            ->where('Serial',$serial)
            ->get()->result();
    }

    public function getCarPrice($cartId){

        $qry = $this->db->query("SELECT TotalPrice as price FROM temporaryshoppingbasket  WHERE ID = $cartId ");
        $res  = $qry->result();
        return  $res;
    }
    public function getCartById($cartId){

        $qry = $this->db->query("SELECT * FROM temporaryshoppingbasket  WHERE ID = $cartId ");
        $res  = $qry->row();
        return  $res;
    }
    public function updateColoum($coloum,$conditon){
        $this->db->where('CartID', $conditon);
        $this->db->update('integrated_attachments', $coloum);
        return true;
    }

    public function deleteArtwork($artworkId){
        if(isset($artworkId) && $artworkId!=0){
          $this->db->where('ID', $artworkId);
          $this->db->delete('integrated_attachments');
        }  
          return true;
    }
    public function deleteArtworkByCart($artworkId){
        if(isset($artworkId) && $artworkId!=0){
         $this->db->where('CartID', $artworkId);
         $this->db->delete('integrated_attachments');
        }
        return true;
    }

    public function deleteArtworkForQuotation($artworkId){
        if(isset($artworkId) && $artworkId!=0 && $artworkId!='0' && $artworkId!=''){
        $this->db->where('ID', $artworkId);
        $this->db->delete('quotation_attachments_integrated');
      }    
        return true;
    }

    public function deleteArtworkForOrder($artworkId){
        if(isset($artworkId) && $artworkId!=0 && $artworkId!='0' && $artworkId!=''){
         $this->db->where('ID', $artworkId);
         $this->db->delete('order_attachments_integrated');
        } 
         return true;
    }

    public function countArtworkStatus($cartId){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('integrated_attachments as at')
            ->where('CartID',$cartId)
            ->get()->result();
    }

    public function countArtworkStatusFromOrderAttach($orderNumber){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('order_attachments_integrated as at')
            ->where('Serial',$orderNumber)
            ->get()->result();
    }

    public function countArtworkStatusFromOrderIntegrated($serial){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('order_attachments_integrated as at')
            ->where('Serial',$serial)
            ->get()->result();
    }
    public function countArtworkStatusFromQuotationIntegrated($serial){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('quotation_attachments_integrated as at')
            ->where('Serial',$serial)
            ->get()->result();
    }


    public function countArtworkStatusFromQuotationIntegratedBYQuotationNumber($serial){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('quotation_attachments_integrated as at')
            ->where('QuotationNumber',$serial)
            ->get()->result();
    }
    public function countArtworkStatusFromOrderAttachMentBYOrderNumber($serial){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('order_attachments_integrated as at')
            ->where('OrderNumber',$serial)
            ->get()->result();
    }

    public function countArtworkStatusFromOrderAttachMentBYSerialNumber($serial){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('order_attachments_integrated as at')
            ->where('Serial',$serial)
            ->get()->result();
    }


    public function getOldArtwork($customerId){

        return $this->db->select("*")
            ->from('order_attachments_integrated ')
            ->where('UserID',$customerId)
            ->get()->result();
    }

    public function getCustomersOrderHistory($customerId){
        return $this->db->select("o.OrderNumber,o.OrderDate as orderDate,if( o.vat_exempt LIKE 'yes', round(((o.OrderTotal + o.OrderShippingAmount)/1.2),2), round((o.OrderTotal + o.OrderShippingAmount),2)) AS OrderTotal")
            ->from('orders as o')
            ->where('o.UserID',$customerId)
            ->order_by('OrderID','DESC')
            ->limit(1)
            ->get()->result_array();

    }

    public function getCustomersSpendToDate($customerId){
        return $this->db->select("(select count(*) from orders where UserID = ".$customerId.") as total ,sum(if( o.vat_exempt LIKE 'yes', round(((o.OrderTotal + o.OrderShippingAmount)/1.2),2), round((o.OrderTotal + o.OrderShippingAmount),2))) AS totalAmount")
            ->from('orders as o')
            ->where('o.UserID',$customerId)

            ->get()->result_array();
    }

    public function getCustomerSampleOrders($customerId){
        return $this->db->select("if(p.ProductBrand like 'Roll Labels' ,count(p.ProductBrand),0) as roll,if(p.ProductBrand not like 'Roll Labels' , count(p.ProductBrand),0) as sheet")
            ->from('orders as o')
            ->join('orderdetails as od','o.OrderNumber = od.OrderNumber','left')
            ->join('products as p', 'od.ProductID = p.ProductID','left')
            ->where('o.UserID',$customerId)
            ->like('o.PaymentMethods','Sample Order')
            ->get()->result_array();
    }

    public function getCustomerQuotationConverted($customerId){
        return $this->db->select("count(*) as total,if(qn.OrderNumber is not null ,count(qn.OrderNumber),0) as conve")
            ->from('quotations as q')
            ->join('quotation_to_order as qn','q.QuotationNumber = qn.QuotationNumber','left')
            ->where('q.UserID',$customerId)
            ->get()->result_array();
    }

    public function getCustomerLifeTimeValue($customerId){
        $results = $this->db->select("sum(if( o.vat_exempt LIKE 'yes', round(((o.OrderTotal + o.OrderShippingAmount)/1.2),2), round((o.OrderTotal + o.OrderShippingAmount),2))) AS OrderTotal")
            ->from('orders as o')
            ->where('o.UserID',$customerId)
            ->get()->result_array();
        return $results;
    }





// function copied from oldbackoffice

    public function printInvoice($invoice) {

        $orderID = $this->getinvoicenumber($invoice);

        $data['Invoice']      = $invoice;
        $data['OrderDetails'] = $this->OrderDetails($orderID);
        $OrderInfo    = $this->OrderInfo($orderID);

        $site = $OrderInfo[0]->site;
        $language = ($site=="" || $site=="en")?"en":"fr";
        $page =  "Invoice/Invoice-print";


        $data['OrderInfo'] = $OrderInfo;
        //echo '<pre>';
        //print_r($data);exit;
        $this->load->library('pdf');
        $this->pdf->load_view($page, $data);

        $this->pdf->render();
        $output	= $this->pdf->output();

        $file_location ="pdf/invoice_".$invoice.".pdf";

        $filename = $file_location;
        $fp = fopen($filename, "a");
        file_put_contents($file_location,$output);
        $this->pdf->stream("Invoice No : ".$invoice.".pdf");
    }


    function getinvoicenumber($invoice){
        $sql = $this->db->query("select OrderNumber from invoice where InvoiceNumber LIKE '$invoice' and InvoiceType = 'Invoice'");
        $result = $sql->row_array();
        return $result['OrderNumber'];
    }

    public function OrderDetails($orderID){
        if(empty($orderID)){

            $orderID = end($this->uri->segments);

        }

        //$query = $this->db->get_where('orderdetails', array('OrderNumber' => $orderID));
        
        //$this->db->select('*,od.Price,od.ProductName as orderProductName');
        $this->db->select('p.*,od.*,od.Price,od.ProductName as orderProductName');
        $this->db->from('orderdetails as od');
        $this->db->join('products as p','od.ProductID=p.ProductID');
        $this->db->where('OrderNumber',$orderID);
        return $this->db->get()->result();
        //return $query->result();

    }


    public function manufactureid($domain,$id)
    {
        $ManufactureID='ManufactureID';
        $this->db->select($ManufactureID);
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->$ManufactureID;
    }
    function get_currecy_symbol($code){
        $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['symbol'];
    }

    function get_details_roll_quotation($id){
        $query = $this->db->query("SELECT * from roll_print_basket WHERE SerialNumber = '$id' ");
        $row = $query->row_array();
        return $row;
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

    function get_printed_files($serial){
        $q = $this->db->query(" select * from quotation_attachments_integrated  WHERE Serial LIKE '".$serial."'  ");
        return $q->result();
    }

    // End function copied from oldbackoffice
    function get_exchange_rate($code){

        $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '".$code."'");
        $sql = $sql->row_array();
        return $sql['rate'];
    }

    public function saveOrder(){
        //print_r($_POST);exit;
			
		
        $currency = currency;
        $exchange_rate  = $this->get_exchange_rate($currency);
        $plain_label_cust = $this->input->post('plain_label_cust');

        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        $session_id = $this->session->userdata('session_id');
        $Ordshipamount = $this->input->post('shippingCharges');
        $VATEXEMPT =  $this->session->userdata('vat_exemption');
        $Ordtotal = $this->session->userdata('Qtotal');
        //$Source = $this->session->userdata('userid');
		$Source= $this->session->userdata('UserID');


        $UserID = $this->session->userdata('userid');
        $country     = $this->input->post('country');
        $shipservice = $this->input->post('shippingCharges');
        $Ordtotal = $Ordtotal - $Ordshipamount;
        $OrdWebsite = $this->input->post('QuoteWebsite');
        $OrdNo = $this->getOrderNum();

            $user_domain = $this->session->userdata('user_domain');

            if(isset($user_domain) and $user_domain == "trade")
            {
                $OrderNo = 'AT'.$OrdNo;
            }
            else
            {
                $OrderNo = 'AA'.$OrdNo;
            }
       


        $payment = $this->input->post('paymentway');

        if($payment=='Sample Order'){
            $OrderNo = $OrderNo."-S";


        }
        $this->session->set_userdata("OrderNo",$OrderNo);

        $wtp_discount = $this->wtp_discount_applied_on_order();
        $rollvoucher = $this->calculate_total_printedroll_amount();

        if($wtp_discount){
            $discount_offer = $wtp_discount['discount_offer'];
            //$Ordtotal = $Ordtotal -$wtp_discount['discount_offer'];
            $voucherOfferd = 'Yes';
            $del = $this->db->delete('voucherofferd_temp', array('SessionID' => $session_id));
        }
        else if($rollvoucher > 0){
            $discount_offer = $rollvoucher;
            $voucherOfferd = 'Yes';

            $cisess_session_id = $this->get_website_session_id();
            $session_id = $this->session->userdata('session_id');
            $where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";
            $qry   = $this->db->query("Delete FROM voucherofferd_temp WHERE ".$where);

        }
        else{
            $discount_offer = 0.00;
            $voucherOfferd = 'No';
        }

        /* Billing Form Data */

        $UserEmail = $this->input->post('email_valid');
        $SecondaryEmail = $this->input->post('second_email');
        if(empty($UserEmail))
        {
            $UserEmail = $this->input->post('hideUserEmail');
        }

        $Bpcode 	   = strtoupper($this->input->post('b_pcode'));
        $BFirstName    = ucwords($this->input->post('b_first_name'));
        $BLastname 	   = ucwords($this->input->post('b_last_name'));
        $BAddress1 	   = ucwords($this->input->post('b_add1'));
        $BAddress2 	   = ucwords($this->input->post('b_add2'));
        $BTownCity 	   = ucwords($this->input->post('b_city'));
        $BCountryState = ucwords($this->input->post('b_county'));
        $BCompany 	   = ucwords($this->input->post('b_organization'));



        $BTitle = $this->input->post('billing_title');
        $BCountry = $this->input->post('country');
        $BTelephone = $this->input->post('b_phone_no');
        $BFax = $this->input->post('b_phone_no');
        $Bmobile = $this->input->post('b_mobile');
        $BbillingResCom = 1;

        /****************** Delivery Form Data *********************/

        $DTitle = $this->input->post('title_d');

        $Dpcode 		= strtoupper($this->input->post('d_pcode'));
        $DFirstName 	= ucwords($this->input->post('d_first_name'));
        $DLastname 		= ucwords($this->input->post('d_last_name'));
        $DAddress1 		= ucwords($this->input->post('d_add1'));
        $DAddress2 		= ucwords($this->input->post('d_add2'));
        $DTownCity 		= ucwords($this->input->post('d_city'));
        $DCompany 		= ucwords($this->input->post('d_organization'));
        $DCountryState  = ucwords($this->input->post('dcountry'));


        $DCountry = $this->input->post('d_county');



        $DTelephone = $this->input->post('d_phone_no');

        $DFax = $this->input->post('d_phone_no');



        $DbillingResCom =1;

        $qemail = $this->input->post('d_email');

        $paymentmethod = $payment;

        $BillingMobile = $this->input->post('b_mobile');

        $DMobile = $this->input->post('d_mobile_no');

        $purchaseno = $this->input->post('PurchaseOrderNumber');

        $CustomerOrder = $this->input->post('vatnumber');

        $vatonformation = $this->input->post('vatonformation');

        $vat_pass = $this->getVatNumber($this->input->post('b_pcode'),$this->input->post('d_pcode'),$this->input->post('dcountry'));

        if($vatonformation=="on" || $vat_pass=="no"){
            $CustomerOrder=0;
        }

        $Customer = array('UserEmail' => $UserEmail,

            'UserName' => $DFirstName,
            'SecondaryEmail'=>$SecondaryEmail,
            'UserPassword' => rand(10, 50),
            'RegisteredDate' => date('Y-m-d'),
            'RegisteredTime' => date('H:i:s'),
            'BillingTitle' => $BTitle,
            'BillingFirstName' => $BFirstName,
            'BillingLastName' => $BLastname,
            'BillingCompanyName' => $BCompany,
            'BillingAddress1' => $BAddress1,
            'BillingAddress2' => $BAddress2,
            'BillingTownCity' => $BTownCity,
            'BillingCountyState' => $BCountryState,
            'BillingCountry' => $BCountry,
            'BillingPostcode' => $Bpcode,
            'BillingTelephone' => $BTelephone,
            'BillingMobile' => $Bmobile,
            'BillingFax' => $BFax,
            'DeliveryTitle' => $DTitle,
            'DeliveryFirstName' => $DFirstName,
            'DeliveryLastName' => $DLastname,
            'DeliveryCompanyName' => $DCompany,
            'DeliveryAddress1' => $DAddress1,
            'DeliveryAddress2' => $DAddress2,
            'DeliveryTownCity' => $DTownCity,
            'DeliveryCountyState' => $DCountryState,
            'DeliveryCountry' => $DCountry,
            'DeliveryPostcode' => $Dpcode,
            'DeliveryTelephone' => $DTelephone,
            'DeliveryFax' => $DFax,
            'DeliveryMobile'=>$DMobile,
            'Active' =>1
        );

        $last_order = 0;
        if($UserID == "" || $UserID == null){
            $this->db->insert('customers', $Customer);
            $rs = $this->db->get_where('customers',array('UserEmail'=>$UserEmail))->result();
            $CustomerID = $rs[0]->UserID;
            $last_order ='FIRST';
        }else
        {
            $CustomerID = $UserID;
        }
        $payment =$this->input->post('paymentway');
        if($paymentmethod=='Sample Order'){
            $orderstatus = "33";
            $Ordtotal =0;
            $Ordshipamount=0;
            $shipservice=20;
        }else{
            $orderstatus = "6";
        }

        $Order = array(

            'OrderNumber' => $OrderNo,

            'SessionID' => $session_id,

            'OrderDate' => time(),

            'OrderTime' => time(),

            'UserID' => $CustomerID,

            'DeliveryStatus' => '',

            'PaymentMethods' => $paymentmethod,

            'OrderShippingAmount' => $Ordshipamount,

            'OrderTotal' => $Ordtotal,

            'PurchaseOrderNumber' => $purchaseno,

            'CustomOrder'=>$CustomerOrder,

            'BillingTitle' => $BTitle,

            'SecondaryEmail'=>$SecondaryEmail,

            'BillingFirstName' => $BFirstName,

            'BillingLastName' => $BLastname,

            'BillingCompanyName' => $BCompany,

            'Billingemail'=> $UserEmail,

            'BillingAddress1' => $BAddress1,

            'BillingAddress2' => $BAddress2,

            'BillingTownCity' => $BTownCity,

            'BillingCountyState' => $BCountryState,

            'BillingPostcode' => $Bpcode,

            'BillingCountry' => $BCountry,

            'Billingtelephone' => $BTelephone,

            'BillingMobile' => $Bmobile,

            'Billingfax' => $BFax,



            'BillingResCom' => $BbillingResCom,



            'DeliveryTitle' => $DTitle,

            'DeliveryFirstName' => $DFirstName,

            'DeliveryLastName' => $DLastname,

            'DeliveryCompanyName' => $DCompany,

            'DeliveryAddress1' => $DAddress1,

            'DeliveryAddress2' => $DAddress2,

            'DeliveryTownCity' => $DTownCity,

            'DeliveryCountyState' => $DCountryState,

            'DeliveryCountry' => $DCountry,


            'DeliveryPostcode' => $Dpcode,

            'Deliverytelephone' => $DTelephone,

            'DeliveryMobile' => $DMobile,

            'Deliveryfax' => $DFax,

            'DeliveryResCom' => $DbillingResCom,

            'Registered' => 'Yes',

            'OrderStatus' => $orderstatus,

            'ShippingServiceID' => $shipservice,

            'printPicked' => 'No',

            'Source' => $Source,

            'Domain' => $OrdWebsite,

            'prevOrder'=>$last_order,

            'vat_exempt'=>$VATEXEMPT,

            'voucherOfferd'=> $voucherOfferd,

            'voucherDiscount'=>$discount_offer,

            'currency'=>$currency,

            'exchange_rate'=>$exchange_rate,

            'Label'=>($this->input->post('plain_labels') !=null)?$this->input->post('plain_labels'):'0',
        );
        $OrderNumber = array('OrderNumber' => $OrdNo);

        $this->db->insert('orders', $Order);






        $tempcart =	$this->viewCart();

        foreach( $tempcart as $cartdata)

        {

            $print_type = '';


            if($payment=='Sample Order'){
                $ExVat =0;
                $IncVat =0;
                $cartdata->Quantity=1;
                $cartdata->Print_Type = "Sample";
            }else{
                $ExVat = round($cartdata->TotalPrice,2);
                $IncVat = round($cartdata->TotalPrice * vat_rate,2);
            }



            $prodinfo = $this->getproductdetail($cartdata->ProductID);

            $prodcompletename =  $this->customize_product_name($cartdata->is_custom,$cartdata->ProductCategoryName,$cartdata->LabelsPerRoll,$prodinfo['LabelsPerSheet'],$prodinfo['ReOrderCode'],$prodinfo['ManufactureID'],$prodinfo['ProductBrand'],$cartdata->wound,$cartdata->OrderData);
			
             $productOriginalName = $prodcompletename;
			
			
            if($cartdata->ProductID==0){

                $prodcompletename = $cartdata->p_name;

                $p_code=$cartdata->p_code;

            }else{

                $p_code=$prodinfo['ManufactureID'];

            }



            if($payment=='Sample Order'){
                $prodcompletename = $prodcompletename." - Sample ";
            }

            if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand'])){

                $extra_int_text = ($cartdata->orignalQty==250)?" - (250 Sheet Dispenser Packs)":" - (1000 Sheet Boxes)";
                $prodcompletename  = $prodcompletename.$extra_int_text;

            }



            /* if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand'])){

                    echo $print_type = $cartdata->OrderData;die;

            }else{*/
            $print_type = $cartdata->Print_Type;
            //     }



            if($p_code=="PRL1"){

                $query = $this->db->query("SELECT SerialNumber from roll_print_basket WHERE id = '$cartdata->ID' ");

                $row = $query->row_array();

                $PRL_detail =  $row['SerialNumber'];

            } else{

                $PRL_detail = "";

            }


            if($prodinfo['displayin']=='backoffice'){
                $backoffice_detect = 1;
            }else{
                $backoffice_detect = 0;
            }


            $product = $this->db->query("select * from products where ProductID = '".$cartdata->ProductID."' ")->row_array();
            $myLabels = $product['LabelsPerSheet'] * $cartdata->Quantity;


            if($cartdata->Printing=='Y' and preg_match('/Roll Labels/is',$prodinfo['ProductBrand'])){

                ///$designedlabels = $this->get_total_printed_labels($cartdata->ID, $cartdata->ProductID);
                //if($designedlabels > 0){ $designedlabels = $designedlabels.' labels, ';}else {$designedlabels = '';}
                if($cartdata->wound=='Y' || $cartdata->wound=='Inside'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}

                //if($cartdata->Print_Type == 'Fullcolour'){ $labeltype = 'Full Colour';}
                //else if($cartdata->Print_Type == 'Fullcolour+White'){ $labeltype = 'Full Colour + White';}
                //else if($cartdata->Print_Type == 'Mono'){ $labeltype = 'Black Only';}

                $labeltype = $this->get_printing_service_name($cartdata->Print_Type);

                $productname  = explode("-",$prodinfo['ProductCategoryName']);
                $productname[1] = str_replace("(","",$productname[1]);
                $productname[1] = str_replace(")","",$productname[1]);
                $productname[0] = str_replace("rolls labels","",$productname[0]);
                $productname[0] = str_replace("roll labels","",$productname[0]);
                $productname[0] = str_replace("Roll Labels","",$productname[0]);
                $productname = "Printed Labels on Rolls - ".str_replace("roll label","",$productname[0]).' - '.$productname[1];
                $completeName = ucfirst($productname).' '. $wound_opt.' - Orientation '.$cartdata->orientation.', ';
                if($cartdata->FinishType == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
                else{  $labelsfinish = ' With Label finish : '.$cartdata->FinishType; }
                $prodcompletename =$completeName.' '.$labeltype.' '.$labelsfinish;

                $myLabels = $cartdata->LabelsPerRoll*$cartdata->Quantity;
                if($cartdata->orignalQty !="" && $cartdata->orignalQty !=0){
                    $myLabels = $cartdata->orignalQty;
                }

            }

            $ProductionStatus = 1;$ProductOption ='';
            if($p_code=='AADS001'){
                $ProductionStatus = 3;
                $ProductOption = $order_serail;
            }

            if($payment=='Sample Order'){
                $ProductionStatus = 3;


                if(preg_match("/Roll Labels/i",$prodinfo['ProductBrand'])){
                    $completeName =  " Label Material  Sample ";
                    $type = 'roll';
                    $material_code = $this->getmaterialcode(substr($prodinfo['ManufactureID'],0,-1));
                }else{
                    $type = 'a4';
                    $completeName = " A4 Sheet Label Material  Sample ";
                    $material_code = $this->getmaterialcode($prodinfo['ManufactureID']);
                }

                if(isset($material_code) and $material_code!=''){
                    $res = $this->db->query("select name,adhesive from static_materials where code like '".$material_code."' limit 1");
                    $res =$res->row_array();
                    $dd = explode("-", $res['name']);
                    $name = $dd[1].' - '.$res['adhesive'];
                    $prodcompletename = $name.' '.$completeName;
                }
            }



            $OrdDetail =  array(

                'Prl_id' =>$PRL_detail,
                'OrderNumber' => $OrderNo,
                'UserID' => $CustomerID,
                'labels'=> $myLabels,
                'ProductID' => $cartdata->ProductID,
                'ManufactureID'=>$p_code,
                'Quantity' => $cartdata->Quantity,
                'LabelsPerRoll'=> $cartdata->LabelsPerRoll,
                'is_custom'=> $cartdata->is_custom,
                'ProductName' => $productOriginalName,
                'Price' => $ExVat,
                'ProductTotalVAT' => $ExVat,
                'ProductTotal' => $IncVat,
                'ProductionStatus'=>$ProductionStatus,
                'ProductOption'=>$ProductOption,
                'Printing'=> $cartdata->Printing,
                'Print_Type'=> $print_type,
                'Print_Design'=> $cartdata->Print_Design,
                'Print_Qty'=> $cartdata->Print_Qty,
                'Free'=> $cartdata->Free,
                'Print_UnitPrice'=> $cartdata->Print_UnitPrice,
                'Print_Total'=> $cartdata->Print_Total,
                'old_product'=>$backoffice_detect,
                'colorcode'=> $cartdata->colorcode,
                'Wound'=>$cartdata->wound,
                'Orientation'=>$cartdata->orientation,
                'pressproof'=>$cartdata->pressproof,
                'FinishType'=>$cartdata->FinishType,
                'Product_detail'=>$cartdata->Product_detail,
                'design_service'=>$cartdata->design_service,
                'design_service_charge'=>$cartdata->design_service_charge,
                'design_file'=>$cartdata->design_file,
							  'Source' => $Source,
                'page_location'=>$cartdata->page_location
            );

						$this->db->insert('orderdetails', $OrdDetail);
            $order_serail = $this->db->insert_id();

            if(preg_match('/Integrated Labels/is',$prodinfo['ProductBrand']) || $cartdata->Printing=='Y'){
                if($cartdata->OrderData=='Black' || $cartdata->OrderData=='Printed' || $cartdata->Printing=='Y'){

                    $query = $this->db->query("select count(*) as total from integrated_attachments 

								WHERE ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."' AND status LIKE 'confirm' ");

                    $query = $query->row_array();

                    if($query['total'] > 0){



                        $attach_q = $this->db->query("select * from integrated_attachments 

									WHERE ProductID LIKE '".$cartdata->ProductID."' AND CartID LIKE '".$cartdata->ID."'
									 AND status LIKE 'confirm' ");

                        $attach_q = $attach_q->result();

                        foreach($attach_q  as $int_row)
                        {
                            $brand = $this->make_productBrand_condtion($prodinfo['ProductBrand']);
                            $attach_array = array('OrderNumber'=>$OrderNo,
                                'Serial'=>$order_serail,
                                'ProductID'=>$int_row->ProductID,
                                'file'=>$int_row->file,
                                'diecode'=>$p_code,
                                'status'=>64,
                                'Brand'=>$brand,
                                'source'=> $Source,
                                'design_type'=>$cartdata->Print_Type,
                                'qty'=>$int_row->qty,
                                'labels'=>$int_row->labels,
                                'name'=>$int_row->name,
                                'CO' =>1,
                                'version' =>1
                            );

                            $this->db->insert('order_attachments_integrated',$attach_array);
                        }

                    }

                }

            }



        }

        ///////////////////////// Tem Cart Empty /////////////////////////////////////////////////////////////



        //mysql_query(" delete from temporaryshoppingbasket where (SessionID = '".session_id()."' OR SessionID = '".$cisess_session_id."')");

        $where = "(SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."')";

        $this->db->where($where);

        $this->db->delete('temporaryshoppingbasket');


        /*if($payment=='Sample Order'){
          $this->custom->assign_dispatch_date($OrderNo,TRUE);
        }*/

        if($this->db->affected_rows() > 0){

          $data = array('res'=>true,'orderNumber'=>$OrderNo);
          return $data;
        }else{

            return false;
        }
    }
    public function uploadArtworkInOrderIntegrated(){
        $orderDetail =  $this->getOrderDetailBySerialNumber($_POST['serialNumber']);

        $param = array(
        'UserID'=>$_POST['customerId'],
        'OrderNumber'=>$_POST['orderNumber']
        ,'Serial'=>$_POST['serialNumber']
        ,'ProductID'=>$_POST['ProductID']
        ,'diecode'=>$_POST['manfactureId']
        ,'name'=>$_POST['name']
        ,'qty'=>$_POST['qty']
        ,'labels'=>$_POST['labels']
        ,'design_type'=>$orderDetail->Print_Type
        ,'Brand'=> $this->make_productBrand_condtion($orderDetail->ProductBrand)
        ,'Date'=>date('Y-m-d h:m:s')
        ,'status'=>64
        ,'source'=>$this->session->userdata('UserName')
        ,'CO' =>1
        ,'version' =>1
        );

        return $param;
    }

    public function uploadArtworkInQuotationIntegrated(){
        $orderDetail =  $this->getQuotationDetailBySerialNumber($_POST['serialNumber']);

        $param = array('QuotationNumber'=>$_POST['orderNumber']
        ,'Serial'=>$_POST['serialNumber']
        ,'ProductID'=>$_POST['ProductID']
        ,'diecode'=>$_POST['manfactureId']
        ,'name'=>$_POST['name']
        ,'qty'=>$_POST['qty']
        ,'labels'=>$_POST['labels']
        ,'design_type'=>$orderDetail->Print_Type
        ,'Date'=>date('Y-m-d h:m:s')
        ,'status'=>64
        ,'source'=>$this->session->userdata('UserName')
        ,'labelsPerSheet'=>$orderDetail->LabelsPerSheet
        );

        return $param;
    }

    public function updateIntoOrderDetailTable($params){

        if($this->input->post('brandName') == 'Integrated Labels'){
            //$orderDetail = $this->getOrderDetailBySerialNumber($_POST['serialNumber']);

            //$labels = $orderDetail->labels;
        }else{
            //$labels = $params['statics']->totalLabels;
        }

        $orderDetail =  $this->getOrderDetailRecord($_POST['serialNumber']);
        //$orderDetail['labels'] = $labels;
        $orderDetail['Print_Qty'] = $params['statics']->count;

        $this->db->where('SerialNumber',$_POST['serialNumber']);
        $this->db->update('orderdetails',$orderDetail);
        return true;
    }

    public function updateIntoQuotatonDetailTable($params){

        $quotatonDetail =  $this->getQuotationDetailRecord($_POST['serialNumber']);

        if($this->input->post('brandName') == 'Integrated Labels'){
           // $quotatonDetail['orignalQty'] = $quotatonDetail['orignalQty'];
        }else{
           // $quotatonDetail['orignalQty'] = $params['statics']->totalLabels;
        }


        $quotatonDetail['Print_Qty'] = $params['statics']->count;

        $this->db->where('SerialNumber',$_POST['serialNumber']);
        $this->db->update('quotationdetails',$quotatonDetail);
        return true;
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
        }
        else if(preg_match("/A5/i",$type)){
            $brand = 'A5';
        }
        else{
            $brand = 'A4';
        }
        return $brand;
    }
	
    function customize_product_name($custom,$ProductCategoryName,$LabelsPerRoll,$LabelsPerSheet,$ReOrderCode,$manuid,$ProductBrand,$wound=NULL, $printed=NULL,$type=null)
    {

        if($wound=='Y'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}
        if($custom=="Y"){$custom='Yes';}

        if($custom=='Yess'){

            $productname  = explode("-",$ProductCategoryName);

            $completeName = $productname[0].$LabelsPerRoll."  label per roll, ".$wound_opt." - ".$productname[1];

            $diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerRoll);

            $completeName = $completeName." Roll Diameter ".$diamter;



        }else{

            if(preg_match('/Roll Labels/is',$ProductBrand)){

                $productname  = explode("-",$ProductCategoryName);
                if($type == 'plain'){
                  if($custom=='Yes'){    
                    $completeName = $productname[0].$LabelsPerRoll."  label per roll, ".$wound_opt." - ".$productname[1];
                    $diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerRoll);
                    $completeName = $completeName." Roll Diameter ".$diamter;
                  }else{
                    $completeName = $productname[0].$LabelsPerSheet."  label per roll, ".$wound_opt." - ".$productname[1];
                    $diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerSheet);
                    $completeName = $completeName." Roll Diameter ".$diamter;
                  }    
                }else{
                     if($custom=='Yes'){    
                      $completeName = 'Printed Labels on Rolls - '.$productname[0].$LabelsPerRoll."  label per roll, ".$wound_opt." - ".$productname[1];
                   }else{
                     $completeName = 'Printed Labels on Rolls - '.$productname[0].$LabelsPerSheet."  label per roll, ".$wound_opt." - ".$productname[1];
                  }    
                  
                }


                //$diamter =  $this->calculate_rolls_diamter($manuid,$LabelsPerSheet);

                //$completeName = $completeName." Roll Diameter ".$diamter;



            }else{

                if(preg_match('/Integrated Labels/is',$ProductBrand)){
                    $completeName = $ProductCategoryName;

                }else{
                    if(substr($manuid,-2,2)=='XS'){
                        $completeName = $ProductCategoryName.", Design: ".$printed;
                    }else{ $completeName = $ProductCategoryName;}

                    //$completeName = $ProductCategoryName;

                    /**********WPEP Voucher Offer*************/
                    if(preg_match("/A4/i",$ProductBrand) and (preg_match("/WPEP/i",$manuid))){
                        $completeName =  $completeName." <span style='color:#fd4913;'>( 20% discount) </span>";
                    }
                    /**********WPEP Voucher Offer*************/

                }

            }

        }

        if($ReOrderCode){ $completeName = $completeName." re-order code ".$ReOrderCode; }
        //if(preg_match("/HGP/i",$manuid) and preg_match('/Roll Labels/is',$ProductBrand)){
            //$completeName =  $completeName." <span style='color:#fd4913;'>( 30% discount) </span>";
        //}
        
        $mattpe =   (preg_match('/Roll Labels/is',$ProductBrand))?'Roll' : 'A4';
        $m_codes = ($mattpe == "Roll") ? substr($manuid, 0,-1):$manuid;
        $mat_code = $this->home_model->getmaterialcode($m_codes);
        $material_discount = $this->home_model->check_material_discount($mat_code, $mattpe);
        if($material_discount){
          $completeName = $completeName . " <span style='color:#fd4913;'>(" . $material_discount . "% discount) </span>";
        }
        
        
        

        return $completeName;

    }
	
    function calculate_rolls_diamter($manufature=NULL,$label=NULL){



        $query = $this->db->query("SELECT LabelGapAcross,Height FROM products 

			INNER JOIN category ON SUBSTRING_INDEX( products.CategoryID, 'R', 1 ) = category.CategoryID   WHERE ManufactureID like '".$manufature."' LIMIT 1");

        $row = $query->row_array();

        $gap =  $row['LabelGapAcross'];

        $size = $row['Height'];

        return $this->get_auto_diameter($manufature,$label,$gap,$size).' mm';



    }
    function get_auto_diameter($manufature,$labels,$gap,$size){



        $rolldiamter = 0;

        $coreid = substr($manufature,-1);

        $coreid = 'R'.$coreid;

        $gap = round(trim(str_replace("mm","",$gap)));

        $code =  $this->getmaterialcode(substr($manufature,0,-1));

        $size = $size+$gap;

        $labels_p_mtr = round(($size/1000)*$labels,2);



        $diammeter = $this->get_diameter_against_meter($code,$coreid,$labels_p_mtr);

        $rolldiamter = floor(($diammeter*0.03)+$diammeter);

        if($rolldiamter > 3){ $rolldiamter = $rolldiamter-3;}

        return $rolldiamter;



    }

    function get_diameter_against_meter($code=NULL,$coreid=NULL,$meter=NULL){

        $qurey = $this->db->query("SELECT mtr,mesure FROM `roll_diameter` Where code LIKE '".$code."' AND core LIKE '".$coreid."'  ORDER BY `roll_diameter`.`mesure` ASC");

        $result = $qurey->result();

        foreach($result as $key => $row){

            if($meter == $row->mtr){

                return  $row->mesure;

            }

            else if(($meter > $row->mtr and isset($result[$key+1]->mtr) and $meter < $result[$key+1]->mtr)){

                return  $result[$key+1]->mesure;

            }

        }

    }

    function getmaterialcode($text){

        preg_match('/(\d+)\D*$/', $text, $m);

        $lastnum = $m[1];

        $mat_code = explode($lastnum,$text);

        return strtoupper($mat_code[1]);

    }

    public function getproductdetail($id)
    {

        $query = $this->db->select('*')

            ->where('ProductID',$id)

            ->get('products');


        return $query->row_array();

    }

    public function viewCart()
    {

        $cookie = (isset($_COOKIE['ci_session']))?$_COOKIE['ci_session']:'';

        $cookie = stripslashes($cookie);

        $cookie = @unserialize($cookie);

        $cisess_session_id = $cookie['session_id'];

        $session_id = $this->session->userdata('session_id');

        $qry = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID WHERE 1=1 and (SessionID = '".$session_id."'  OR SessionID ='".$cisess_session_id."') ");

        $res  = $qry->result();

        return $res;

    }

    public function getVatNumber($billing_postcode,$delivery_postcode,$dcountry){
        $vat_exempt ="no";
        $VALIDVAT =  $this->session->userdata('vat_exemption');
        if(isset($VALIDVAT) and $VALIDVAT=='yes' and $dcountry!='United Kingdom'){
            $vatnumber = $this->input->post('vatnumber');
            $vat_exempt ='yes';
        }
        else if($billing_postcode==$delivery_postcode and (strtoupper($delivery_postcode)=='JE' || strtoupper($delivery_postcode)=='GY')){
            $vat_exempt ='yes';
        }
        $this->session->unset_userdata(array('vat_exemption'=>''));
        return ($vat_exempt == 'yes')?$vat_exempt:'no';
    }

    function get_website_session_id(){
        $cookie = $_COOKIE['ci_session'];
        $cookie = stripslashes($cookie);
        $cookie = @unserialize($cookie);
        $cisess_session_id = $cookie['session_id'];
        return 	$cisess_session_id;
    }

    function calculate_total_printedroll_amount(){
        return false;
        $cisess_session_id = $this->get_website_session_id();
        $session_id = $this->session->userdata('session_id');
        $where = "( SessionID = '".$session_id."' OR SessionID = '".$cisess_session_id."' )";

        $query = $this->db->query(" SELECT SUM(TotalPrice) AS total from products INNER JOIN temporaryshoppingbasket ON 
									products.ProductID=temporaryshoppingbasket.ProductID WHERE $where AND 
									temporaryshoppingbasket.Printing LIKE 'Y' AND  (ProductBrand LIKE 'Roll Labels')");
        $row = $query->row_array();
        if(isset($row['total']) and $row['total']!=''){
            return ($row['total']*1.2) * 0.1;

        }else{
            return false;
        }
    }

    function wtp_discount_applied_on_order(){
        $session_id = $this->session->userdata('session_id');
        $qry   = $this->db->query("SELECT * FROM voucherofferd_temp WHERE SessionID = '".$session_id."'");
        $res   = $qry->row_array();
        return $res;
    }
    public function getOrderNum() {

        $sessionid = $this->session->userdata('session_id');
        $this->db->insert('auto_ordernumber',array('session_id'=>$sessionid));
        $order_num = $this->db->insert_id();
        return $order_num;

    }

    public function statusdropdowna($in_array)

    {

        $query ="select * from dropshipstatusmanager where StatusID IN ($in_array) order by SortID asc";

        $row =$this->db->query($query);

        return $row->result();

    }
    
    
    public function statusDropDown($id,$method)
    {
		
		$userId = $this->session->userdata('UserID');
		$userTypeId = $this->session->userdata('UserTypeID');
		if($userId == '652793' || $userId == '653722' && $userTypeId == '1'){
			
			if($id == 6 || $id == 78){
				
				$in_array = "27,10";
				
			}else if($id==10){

				$in_array = "10,34";

			}

			else if($id==26){

				$in_array = "32,10,33,8,7,26,27,55,78";

			}else if($id==32){

				$in_array = "10";

			}else{

				$in_array = "32,10,33,8,7,27,55,78";

				if ($id==34) {
					$in_array = "32,34,10,33,8,7,27,55,78";
				} 

			}

			if($method=='Sample Order'){
				//$in_array = "37,32,23,55";
				$in_array = "10,27,33";
			}
			
		}else{
			if($id==6){
				$in_array = "6,32,10,33,8,7,27,55,78";
			}else if($id==10){
				$in_array = "10,34";
			}
			else if($id==26){
				$in_array = "32,10,33,8,7,26,27,55,78";
			}else if($id==32){

				if($userTypeId == '1'){
					$in_array = "10";
				}else{
					$in_array = "32,10,33,8,7,27,55,78";
				}
				
				

			}else{
				$in_array = "32,10,33,8,7,27,55,78";
				if ($id==34) {
					$in_array = "32,34,10,33,8,7,27,55,78";
				} 
			   /* else if ($id==33) {
					$in_array = "10,27,33";
				}*/
			}

			if($method=='Sample Order'){
				//$in_array = "37,32,23,55";
				$in_array = "10,27,33";
			}

			$UserName = $this->session->userdata('UserTypeID');
			if($UserName!=50){
				if($id==55){
					$in_array = "55,32";
				}else{
					$in_array = "10";
					if($UserName == 'carol' || $UserName == 'carol_home' ){ $in_array = "10,27";}
				}
			}
		
		}	
        $row = $this->statusdropdowna($in_array);
        foreach ($row  as $row){
            $option[$row->StatusID] = $row->StatusTitle;
        }
        return $option;
    }


    public function statusDropDown_old($id,$method)

    {
        if($id==6){

            $in_array = "6,32,10,33,8,7,38,27,38,55,62,78";

        }else if($id==10){



            $in_array = "10,34";

        }

        else if($id==26){



            $in_array = "2,32,10,33,8,7,26,38,27,38,55,62,78";

        }else{

            $in_array = "2,32,10,33,8,7,38,27,38,55,62,78";

        }

        if($method=='Sample Order'){
            $in_array = "37,2,32,23,55";
        }

        $UserName = $this->session->userdata('UserTypeID');
        if($UserName!=50){
            if($id==55){
                $in_array = "55,32";
            }else{
                $in_array = "10";
                if($UserName == 'carol' || $UserName == 'carol_home' ){ $in_array = "10,27";}
            }
        }
        $row = $this->statusdropdowna($in_array);



        foreach ($row  as $row){



            $option[$row->StatusID] = $row->StatusTitle;

        }

        return $option;


    }

    public function addLineIntoOrderDetail(){

        $orderNumber = $this->input->post('orderNumber');
        $qty = $this->input->post('qty');
        $menuid = $this->input->post('menuid');
        $productId = $this->input->post('productId');
        $type = $this->input->post('types');
        $digital = $this->input->post('digital');
        $plainPrice = $this->input->post('plainPrice');
        $printedPrice = $this->input->post('printedPrice');
        $designPrice = $this->input->post('designPrice');
        $per_sheet_roll = $this->input->post('per_sheet_roll');
        $useer_id = $this->input->post('useer_id');
        $Print_Design = $this->input->post('Print_Design');
        $FinishType = $this->input->post('FinishType');
        $Print_Total = $this->input->post('Print_Total');
        $wound = $this->input->post('wound');
        $pageName = $this->input->post('pageName');
        
        $labels = $this->input->post('labels');
      
        $Print_Design = $this->input->post('Print_Design');
        $manual_design = $this->input->post('manual_design');

        $brand = $this->input->post('brand');
        $brand = (isset($brand) && $brand == 'sheet')?'sheet':'Roll';
        $cart_id = $this->input->post('cart_id');

        $digital = (isset($digital) && $digital!="")?$digital:"null";
        
        $iscustom = 'No';
        $Print_qty = $this->getPrintQty($cart_id);
        if($manual_design!=0){
         $Print_qty = $manual_design;
        } 
      
        if($brand =='Roll'){
          $iscustom = ($per_sheet_roll == $labels)?'No':'Yes';
        }

        $prodinfo = $this->getproductdetail($productId);
        $prodcompletename =  $this->customize_product_name($iscustom,$prodinfo['ProductCategoryName'],$per_sheet_roll,$prodinfo['LabelsPerSheet'],$prodinfo['ReOrderCode'],$prodinfo['ManufactureID'],$prodinfo['ProductBrand'],$wound,date('Y-m-d h:m:s'));
			
        if($type != 'plain'){
            $printedPrice = $printedPrice + $designPrice;
        }
        
        $labels = (isset($brand) && $brand == 'sheet')?$qty*$prodinfo['LabelsPerSheet']:$qty*$per_sheet_roll;
			
        if($pageName == 'order'){
            $params = array(

                'OrderNumber'=>$orderNumber,
                'UserID'=>$useer_id,
                'ProductID'=>$productId,
                'labels'=>$qty * $per_sheet_roll,
                'ManufactureID'=>$menuid,
                'ProductName'=>$prodcompletename,
                'Quantity'=>$qty,
                'labels'=>$labels,
                'LabelsPerRoll'=>$per_sheet_roll,
                'is_custom'=>$iscustom,
                'Price'=>(($type == 'plain' || $type == 'printed') && $brand == 'sheet')?$plainPrice:$printedPrice,
                'ProductTotalVAT'=>$plainPrice,
                'ProductTotal'=>((int)$printedPrice + (int)$plainPrice),
                'Printing'=>($type == 'plain')?'N':'Y',
                'Print_Type'=>($digital == null)?'':$digital,
                'Print_Design'=>($Print_Design == null)?'0':$Print_Design,
                'Print_Qty'=>$Print_qty,
                'FinishType'=>($FinishType == null)?'0':$FinishType,
                'Print_Total'=>($printedPrice != null)?$printedPrice:'0.00',

            );

            $this->db->insert('orderdetails',$params);
            $orderDetailId = $this->db->insert_id();
            if($cart_id >0 && $cart_id !=null && $type != 'plain' && ($manual_design==0 || $manual_design=="")){
                $this->insertOrderArtwork($params,$orderDetailId,$cart_id);
            }
        
          
            $this->settingmodel->add_logs('line_added', '','',$this->input->post('orderNumber'),$orderDetailId);    
        }

        else{
            $params = array(
							'QuotationNumber'=>$orderNumber,
							'CustomerID'=>$useer_id,
							'ProductID'=>$productId,
							'ManufactureID'=>$menuid,
							'ProductName'=>$prodcompletename,
							'orignalQty'=>$qty * $per_sheet_roll,
							'Quantity'=>$qty,
							'LabelsPerRoll'=>$per_sheet_roll,
							'is_custom'=>$iscustom,
							'Price'=>(($type == 'plain' || $type == 'printed') && $brand == 'sheet')?$plainPrice:$printedPrice,
							'ProductTotalVAT'=>$plainPrice,
							'ProductTotal'=>((int)$printedPrice + (int)$plainPrice),
							'Printing'=>($type == 'plain')?'N':'Y',
							'Print_Type'=>$digital,
							'Print_Design'=>($Print_Design == null)?'0':$Print_Design,
							'Print_Qty'=>$Print_qty,
							'FinishType'=>($FinishType == null)?'0':$FinishType,
							'Print_Total'=>($printedPrice != null )?$printedPrice:'0.00',
						);

            $this->db->insert('quotationdetails',$params);
            $quotationDetailId = $this->db->insert_id();
            if($cart_id > 0 && $cart_id !=null && $type != 'plain' && ($manual_design==0 || $manual_design=="")){
				$this->insertOrderArtwork($params,$quotationDetailId,$cart_id);
            }

        }

        return true;
    }

    public function getPrintQty($cartId){
        $artworks = $this->db->query("select count(*) as count from integrated_attachments where CartID ='".$cartId."' ")->result();

        if($artworks[0]->count >0){
            return $artworks[0]->count;
        }else{
            return 0;
        }
    }

    public function insertOrderArtwork($param,$serialNumber,$cart_id){

        $SID  =  $this->shopping_model->sessionid();

            $artworks = $this->db->query("select * from integrated_attachments where CartID ='".$cart_id."' ")->result();
            $artworkCount = count($artworks);
            if($this->input->post('pageName') == 'quotation'){
                foreach ($artworks as $artwork){
                    $artworkDetail = array(
                        'UserID' => $param['CustomerID'],
                        'QuotationNumber' => $param['QuotationNumber'],
                        'Serial' => $serialNumber,
                        'ProductID' => $param['ProductID'],
                        'diecode' => $param['ManufactureID'],
                        'name' => $artwork->name,
                        'qty' => $artwork->qty,
                        'labels' => $artwork->labels,
                        'design_type' => $param['Print_Design'],
                        'file' => $artwork->file,
                        'print_file' => $artwork->file,
                        'source' => 'backoffice',
                        'status  ' => '70',
                        'Date  ' => date('Y-m-d h:m:s'),
                    );
                    $this->db->insert('quotation_attachments_integrated',$artworkDetail);
                }
                $quotation = array('Print_Qty'=>$artworkCount);
                $this->db->where('SerialNumber',$serialNumber);
                $this->db->update('quotationdetails',$quotation);
            }
            else{
                foreach ($artworks as $artwork){
                    $artworkDetail = array(
                        'UserID' => $param['UserID'],
                        'OrderNumber' => $param['OrderNumber'],
                        'Serial' => $serialNumber,
                        'ProductID' => $param['ProductID'],
                        'diecode' => $param['ManufactureID'],
                        'name' => $artwork->name,
                        'qty' => $artwork->qty,
                        'labels' => $artwork->labels,
                        'design_type' => $param['Print_Design'],
                        'file' => $artwork->file,
                        'print_file' => $artwork->file,
                        'source' => 'backoffice',
                        'status  ' => '70',
                        'Date  ' => date('Y-m-d h:m:s'),
                    );
                    $this->db->insert('order_attachments_integrated',$artworkDetail);
                }

                $order = array('Print_Qty'=>$artworkCount);
                $this->db->where('SerialNumber',$serialNumber);
                $this->db->update('orderdetails',$order);
            }

            return true;

        }

    public function updateOrderDetail(){

        $ord_det = $this->db->select('OrderNumber, ProductionStatus, Quantity')
            ->where('SerialNumber', $_POST['SerialNumber'])
            ->get('orderdetails')
            ->row();

        $ord_data = $this->db->select('picking_status')
            ->where('OrderNumber', $ord_det->OrderNumber)
            ->get('orders')
            ->row();

        if($ord_data->picking_status != 1){
            if($ord_det->ProductionStatus == 3 /*&& ($ord_det->Quantity != $_POST['qty'])*/){
                $this->adjust_stock_level($_POST['SerialNumber'], $ord_det->OrderNumber);
            }

            if($ord_data->machine == '' || $ord_data->machine == null){
                $this->db->where('serialNumber',$_POST['SerialNumber']);
                $this->db->set('check_stock', 0);
                $this->db->update('orderdetails');


                $this->db->where('OrderNumber',$ord_det->OrderNumber);
                $this->db->update('orders',array('picking_status'=>3));
            }
        }

        $orderDetail = $this->getOrderDetailBySerialNumber($_POST['SerialNumber']);
        $previous = $orderDetail->Quantity;

        if($this->input->post('brand') == 'Integrated Labels'){

           $labels = $orderDetail->labels;
        }else{

            $labels = $_POST['qty'] *$_POST['labelperRoll'];
        }


        if($_POST['printing'] == 'Y'){
            if($_POST['regmark'] == 'Y'){
                $param = array(
                    'Quantity'=>$_POST['qty'],
                    'labels'=>$labels ,
                    'Print_Type'=>'Monochrome - Black Only',
                    'pressproof'=>0,
                    'Print_Design'=>(isset($_POST['design']) && $_POST['design'] >1)?'Multiple Designs':'1 Designs',
                    'Print_Qty'=>1,
                    'wound'=>(isset($_POST['wound']))?$_POST['wound']:'',
                    'FinishType'=>'No Finish',
                    'Orientation'=>(isset($_POST['Orientation']))?$_POST['Orientation']:'',
                    'LabelsPerRoll'=>$_POST['labelperRoll'] ,
                    'Wound'=>(isset($_POST['wound']))?$_POST['wound']:'',
                );
            }
            else{
                $param = array(
                    'Quantity'=>$_POST['qty'],
                    'labels'=>$labels ,
                    'Print_Type'=>$_POST['digital'],
                    'Print_Design'=>($_POST['design'] >1)?'Multiple Designs':'1 Designs',
                    'Print_Qty'=>(isset($_POST['design']))?$_POST['design']:'',
                    'wound'=>(isset($_POST['wound']))?$_POST['wound']:'',
                    'FinishType'=>(isset($_POST['finish']))?$_POST['finish']:'',
                    'Orientation'=>(isset($_POST['Orientation']))?$_POST['Orientation']:'',
                    'LabelsPerRoll'=>$_POST['labelperRoll'] ,
                    'pressproof'=>$_POST['pressProf'] ,
                    'Wound'=>(isset($_POST['wound']))?$_POST['wound']:'',
                );
            }

        }else{

            $param = array(
                'Quantity'=>$_POST['qty'],
                'labels'=> $labels,
				'Printing'=> 'N',
                'LabelsPerRoll'=>$_POST['labelperRoll'],

            );
        }


        $picking_item = 0;
        if($_POST['printing'] != 'Y'){
            $is_picking_item = $this->db->select('stock_produced.ID')
                ->where('serial_no', $_POST['SerialNumber'])
                ->where('type', 'Stock')
                ->get('stock_produced')
                ->row();
            if($is_picking_item){
                $picking_item = 1;
            }
        }

        if($picking_item == 0){
            $this->db->where('serialNumber',$_POST['SerialNumber']);
            $this->db->update('orderdetails',$param);
        }



        if($ord_data->picking_status != 1) {
            $is_stock_up = $this->db->select('orderdetails.OrderNumber')
                ->where('SerialNumber', $_POST['SerialNumber'])
                ->where('is_stock', 5)
                ->get('orderdetails')
                ->row();
            if ($is_stock_up) {
                $this->db->where('serialNumber', $_POST['SerialNumber']);
                $this->db->set('is_stock', 0);
                $this->db->update('orderdetails');

                $order_number = $this->db->select('orderdetails.OrderNumber')
                    ->where('SerialNumber', $_POST['SerialNumber'])
                    ->get('orderdetails')
                    ->row();
                if ($order_number) {
                    $order_number = $order_number->OrderNumber;
                    $check_for_is_stock = $this->db->select('orderdetails.SerialNumber')
                        ->where('is_stock', 5)
                        ->where('OrderNumber', $order_number)
                        ->get('orderdetails')
                        ->row();
                    if (!$check_for_is_stock) {
                        $this->db->where('OrderNumber', $order_number);
                        $this->db->set('picking_status', 3);
                        $this->db->update('orders');
                    }
                }
            }
        }




        /*$order_number = $this->db->select('orderdetails.OrderNumber')
            ->where('SerialNumber', $_POST['SerialNumber'])
            ->get('orderdetails')
            ->row();
        if($order_number){
            $order_number = $order_number->OrderNumber;
            $check_for_is_stock = $this->db->select('orderdetails.SerialNumber')
                ->where('is_stock', 5)
                ->where('OrderNumber', $order_number)
                ->get('orderdetails')
                ->row();
        }else{
            $order_number = 0;
        }*/




        //if($this->input->post('brand')=='A4 Labels'){
//        if($_POST['qty'] < 10000 && preg_match('/WTP/is',$_POST['manfectureId'])){
//           
//          if( isset($_POST['orderNumber'] ) ){
//            
//            $order_for_voucher = $this->getOrder($_POST['orderNumber']);
//            
//            if($order_for_voucher[0]->OrderStatus =='6'){
//           
//              $discount_destroy = array(
//                'voucherOfferd'=>'',
//                'voucherDiscount'=>'0.00',
//                'OrderTotal'=> round($order_for_voucher[0]->OrderTotal + $order_for_voucher[0]->voucherDiscount,2)
//              );
//          
//           
//              $this->db->where('OrderNumber', $_POST['orderNumber']);
//              $this->db->update("orders",$discount_destroy);
//            }
//          }
//        }
//      }
	  
           return true;
    }
    public function updateCartDetail(){


        //$orderDetail = $this->getOrderDetailBySerialNumber($_POST['SerialNumber']);
        //$previous = $orderDetail->Quantity;

        if($this->input->post('brand') == 'Integrated Labels'){
             $cartDetail = $this->getCartDetailByCartId($_POST['cartId']);
               $originalQty = $cartDetail->orignalQty;

        }
        else{
            $originalQty = $_POST['qty'] * $_POST['labelperRoll'];
        }


        if($_POST['printing'] == 'Y'){

            if($_POST['regmark'] == 'Y'){

                $cartRecord = $this->getCartDetailByCartId($_POST['cartId']);

                $param = array(
                    'Quantity'=>$_POST['qty'],
                    'orignalQty'=>$originalQty,
                    'Print_Type'=>$_POST['digital'],
                    'pressproof'=>0,
                    'Print_Design'=>(isset($_POST['design']) && $_POST['design'] >1)?'Multiple Designs':'1 Design',
                    'Print_Qty'=>1,
                    'wound'=>$cartRecord->wound,
                    'FinishType'=>$cartRecord->FinishType,
                    'orientation'=>$cartRecord->orientation,
                    'LabelsPerRoll'=>$_POST['labelperRoll'] ,


                );
            }else{
                $param = array(
                    'Quantity'=>$_POST['qty'],
                    'orignalQty'=>$originalQty,
                    'Print_Type'=>(isset($_POST['digital']) && $_POST['digital'] !=null)?$_POST['digital']:'',
                    'pressproof'=>$_POST['pressproof'],
                    'Print_Design'=>(isset($_POST['design']) &&  $_POST['design'] >1)?'Multiple Designs':'1 Designs',
                    'Print_Qty'=>(isset($_POST['design']))?$_POST['design']:'',
                    'wound'=>(isset($_POST['wound']))?$_POST['wound']:'',
                    'FinishType'=>(isset($_POST['finish']))?$_POST['finish']:'',
                    'orientation'=>(isset($_POST['Orientation']))?$_POST['Orientation']:'',
                    'LabelsPerRoll'=>$_POST['labelperRoll'] ,


                );
            }

        }else{

            $param = array(
                'Quantity'=>$_POST['qty'],
                'orignalQty'=>$originalQty,
                'LabelsPerRoll'=>$_POST['labelperRoll'],

            );
        }

        //print_r($param);exit;
        $this->db->where('ID',$_POST['cartId']);
        $this->db->update('temporaryshoppingbasket',$param);
		
		$logarray = array_merge($param,array('cartid'=>$_POST['cartId'])); //SAVE LOG
		$this->home_model->save_logs('update_cart',$logarray);  //SAVE LOG

        return true;
    }

      public function addLineForRoll(){
    
    $orderNumber = $this->input->post('orderNumber');
    $qty = $this->input->post('qty');
    $menuid = $this->input->post('menuid');
    $productId = $this->input->post('productId');
    $type = $this->input->post('type');
    $digital = $this->input->post('digital');
    $prit_type = $this->input->post('printing');
    $plainPrice = $this->input->post('plainPrice');
    $printedPrice = $this->input->post('printedPrice');
    $per_sheet_roll = $this->input->post('labels');
    
    $useer_id = $this->input->post('useer_id');
    $Print_Design = $this->input->post('Print_Design');
    $FinishType = $this->input->post('FinishType');
    $woundoption = $this->input->post('woundoption');
    $cartId = $this->input->post('cartId');
    $Print_Total = $this->input->post('Print_Total');
    $wound = $this->input->post('wound');
    $pageName = $this->input->post('pageName');
    $prodinfo = $this->getproductdetail($productId);
    $iscustom = 'No';
    
    
    $per_roll = $this->input->post('per_sheet_roll');
    
    if($_POST['rolltype'] =='Roll'){
      $iscustom = ($per_sheet_roll == $per_roll)?'No':'Yes';
      
      if($type!='plain'){
       $per_sheet_roll = ceil($per_sheet_roll / $qty);
      }
    }
    
    $manual_design = $this->input->post('manual_design');

    
    $prodcompletename =  $this->customize_product_name($iscustom,$prodinfo['ProductCategoryName'],$per_sheet_roll,$prodinfo['LabelsPerSheet'],$prodinfo['ReOrderCode'],$prodinfo['ManufactureID'],$prodinfo['ProductBrand'],$wound,date('Y-m-d h:m:s'),$type);

    if($pageName == 'quotation'){
      if($type == 'plain'){
        if($_POST['regmark']  == 'yes' && $_POST['rolltype'] =='Roll'){
          $params = array(
            'QuotationNumber'=>$orderNumber,
            'CustomerID'=>$useer_id,
            'ProductID'=>$productId,
            'ManufactureID'=>$menuid,
            'ProductName'=>$prodcompletename,
            'orignalQty'=>$qty * $per_sheet_roll,
            'Quantity'=>$qty,
            'LabelsPerRoll'=>$per_sheet_roll,
            'is_custom'=>$iscustom,
            'Price'=>$plainPrice,
            'ProductTotalVAT'=>$plainPrice,
            'ProductTotal'=>$printedPrice + $plainPrice,
            'Printing'=>'Y',
            'Print_Type'=>'Monochrome - Black Only',
            'Print_Design'=>'1 Designs',
            'FinishType'=>'No Finish',
            'regmark'=>'Y',
            'Print_Total'=>($printedPrice == null)?'0':$printedPrice,
          );
        }else{
          $params = array(
            'QuotationNumber'=>$orderNumber,
            'CustomerID'=>$useer_id,
            'ProductID'=>$productId,
            'ManufactureID'=>$menuid,
            'ProductName'=>$prodcompletename,
            'orignalQty'=>$qty * $per_sheet_roll,
            'Quantity'=>$qty,
            'LabelsPerRoll'=>$per_sheet_roll,
            'is_custom'=>$iscustom,
            'Price'=>$plainPrice,
            'ProductTotalVAT'=>$plainPrice,
            'ProductTotal'=>$printedPrice + $plainPrice,
            'Printing'=>($type == 'plain')?'N':'Y',
            'Print_Type'=>($prit_type == null)?'':$prit_type,
            'Print_Design'=>($Print_Design == null)?'0':$Print_Design,
            'FinishType'=>($FinishType == null)?'0':$FinishType,
            'Print_Total'=>($printedPrice == null)?'0':$printedPrice,
            'regmark'=>'N',
          );
        }
      }
      else{
        $min_qty = $this->home_model->min_qty_roll($menuid);
        $response = $this->home_model->rolls_calculation($min_qty, $per_sheet_roll, $qty);
        //print_r($response);exit;
        $currentqty = ceil($qty / $per_sheet_roll);
        $params = array(
          'QuotationNumber'=>$orderNumber,
          'CustomerID'=>$useer_id,
          'ProductID'=>$productId,
          'ManufactureID'=>$menuid,
          'ProductName'=>$prodcompletename,
          //'orignalQty'=>$response['total_labels'],
          //'Quantity'=>$response['rolls'],
          
          'orignalQty'=>$per_sheet_roll * $qty,
          'Quantity'=>$qty,
          //'LabelsPerRoll'=>$response['total_labels']/$response['rolls'],
          'LabelsPerRoll'=>$per_sheet_roll,
          'is_custom'=>$iscustom,
          'Price'=>$plainPrice,
          'ProductTotalVAT'=>$plainPrice,
          'ProductTotal'=>$plainPrice,
          'Printing'=>($type == 'plain')?'N':'Y',
          'Print_Type'=>($this->input->post('printing') == null)?'':$this->input->post('printing'),
          'Print_Design'=>($Print_Design == null)?'0':$Print_Design,
          'FinishType'=>$this->input->post('labelfinish'),
          'Orientation'=>$this->input->post('orientation'),
          'pressproof'=>$this->input->post('presproof'),
          'Print_Qty' =>$manual_design
        );
      }
      //echo '<pre>';
      //print_r($params);exit;
      $this->db->insert('quotationdetails',$params);
      $quotationDetailId = $this->db->insert_id();
      if($cartId >0 && $cartId !=null && $type != 'plain' &&  ($manual_design==0 || $manual_design=="")){
        $this->insertOrderArtwork($params,$quotationDetailId,$cartId);
      }
    }
    else{
      if($type == 'plain'){
        if($_POST['regmark']  == 'yes' && $_POST['rolltype'] =='Roll'){
          
          $params = array(
            'OrderNumber'=>$orderNumber,
            'UserID'=>$useer_id,
            'ProductID'=>$productId,
            'ManufactureID'=>$menuid,
            'ProductName'=>$prodcompletename,
            'labels'=>$qty * $per_sheet_roll,
            'Quantity'=>$qty,
            'LabelsPerRoll'=>$per_sheet_roll,
            'is_custom'=>$iscustom,
            'Price'=>$plainPrice,
            'ProductTotalVAT'=>$plainPrice,
            'ProductTotal'=>$printedPrice + $plainPrice,
            'Printing'=>'Y',
            'Print_Type'=>'Monochrome - Black Only',
            'Print_Design'=>'1 Designs',
            'FinishType'=>'No Finish',
            'regmark'=>'Y',
            'Print_Total'=>($printedPrice == null)?'0':$printedPrice,
          );
        }else{
          $params = array(
            'OrderNumber'=>$orderNumber,
            'UserID'=>$useer_id,
            'ProductID'=>$productId,
            'ManufactureID'=>$menuid,
            'ProductName'=>$prodcompletename,
            'labels'=>$qty * $per_sheet_roll,
            'Quantity'=>$qty,
            'LabelsPerRoll'=>$per_sheet_roll,
            'is_custom'=>$iscustom,
            'Price'=>$plainPrice,
            
            'ProductTotalVAT'=>$plainPrice,
            'ProductTotal'=>$printedPrice + $plainPrice,
            'Printing'=>($type == 'plain')?'N':'Y',
            'Print_Type'=>($digital == null)?'':$digital,
            'Print_Design'=>($Print_Design == null)?'0':$Print_Design,
            'FinishType'=>($FinishType == null)?'0':$FinishType,
            'Print_Total'=>($printedPrice == null)?'0':$printedPrice,
          );
        }
      }
      else{
        $currentqty = ceil($qty / $per_sheet_roll);
        
        $params = array(
          'OrderNumber'=>$orderNumber,
          'UserID'=>$useer_id,
          'ProductID'=>$productId,
          'ManufactureID'=>$menuid,
          'ProductName'=>$prodcompletename,
          'labels'=>$per_sheet_roll * $qty,
          'Quantity'=>$qty,
          'LabelsPerRoll'=>$per_sheet_roll,
          'is_custom'=>$iscustom,
          'Price'=>$plainPrice,
          'ProductTotalVAT'=>$plainPrice,
          'Wound'=>($woundoption !=null)?$woundoption:'',
          'ProductTotal'=>$plainPrice,
          'Printing'=>($type == 'plain')?'N':'Y',
          'Print_Type'=>($this->input->post('printing') == null)?'':$this->input->post('printing'),
          'Print_Design'=>($Print_Design == null)?'0':$Print_Design,
          'FinishType'=>$this->input->post('labelfinish'),
          'Orientation'=>$this->input->post('orientation'),
          'pressproof'=>$this->input->post('presproof'),
          'Print_Qty' =>$manual_design
        );
      }
      
      
      //echo '<pre>';
    //print_r($params); exit;
      
      
      $this->db->insert('orderdetails',$params);
      $orderDetailId = $this->db->insert_id();
      
      if($cartId >0 && $cartId !=null && $type != 'plain' && ($manual_design==0 || $manual_design=="")){
        $this->insertOrderArtwork($params,$orderDetailId,$cartId);
      }
      $this->settingmodel->add_logs('line_added', '','',$orderNumber,$orderDetailId);    
    }
    return true;
  }

     public function delOrderDetailLine(){
      $serialnumber = $this->input->post('serialNumber');     
      if(isset($serialnumber) && $serialnumber!=""){
        $this->db->where('SerialNumber', $serialnumber);
        $this->db->delete('orderdetails');
      }
         $this->adjust_deleted_line_stock($serialnumber);
        return true;
    }




    public function adjust_deleted_line_stock($serial){
        $stock = $this->db->query("select * from stock_produced where serial_no = $serial")->result();
        foreach($stock as $row){
            $barcode = $this->db->query("select * from stock where barcode LIKE '".$row->barcode."'")->row_array();
            if($row->dispatch==1){
                $newqty = $barcode['qty'] + $row->qty;
                $newalloc = $barcode['allocated'] - $row->qty;
                $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
            }else{
                $newqty = $barcode['qty'] + $row->qty;
                $newalloc = $barcode['allocated'] - $row->qty;
                $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
            }
            $this->db->where('barcode',$row->barcode);
            $this->db->update('stock',$array);
        }
        $where = "serial_no = '$serial'";
        $this->db->where($where);
        $this->db->delete('stock_produced');
    }

    public function addNote(){
       $title =  $this->input->post('title');
       $note =  $this->input->post('note');
       $refNumber =  $this->input->post('orderNumber');

       $params = array('RefNumber'=>$refNumber,'noteTitle'=>$title,'noteText'=>$note,'operator_id'=>$this->session->userdata('UserName'));
        $this->db->insert('customernotes',$params);
        return true;
    }
    public function addDeclineNote(){
        $title =  $this->input->post('title');
        $note =  $this->input->post('note');
        $refNumber =  $this->input->post('orderNumber');

        $params = array('order_number'=>$refNumber,'title'=>$title,'description'=>$note);
        $this->db->insert('decline_with_note',$params);
        return true;
    }

    public function updateNote(){

        $params = array('noteTitle'=>$this->input->post('title'),'noteText'=>$this->input->post('note'),'operator_id'=>$this->session->userdata('UserName'));
        $this->db->where('noteID',$this->input->post('orderNumber'));
        $this->db->update('customernotes',$params);
        return true;
    }

    public function DeclineNote(){

        $params = array('title'=>$this->input->post('title'),'description'=>$this->input->post('note'));
        $this->db->where('ID',$this->input->post('orderNumber'));
        $this->db->update('decline_with_note',$params);
        return true;
    }



    function getOrderNotes($refrence=NULL){

        if($refrence){
            $query  = $this->db->query("select *,DATE_FORMAT(noteDate,'%d-%m-%Y %h:%i %p') as noteDate from customernotes where RefNumber LIKE '".$refrence."' ORDER BY noteID DESC");
            return $query->result();
        }

    }

    function declineNotes($refrence=NULL){

        if($refrence){
            $query  = $this->db->query("select * from decline_with_note where order_number LIKE '".$refrence."' ORDER BY ID DESC");
					
            return $query->result();
        }

    }

    function getCustomerNotes($refrence=NULL){

        if($refrence){
            $query  = $this->db->query("select *,DATE_FORMAT(noteDate,'%d-%m-%Y %h:%i %p') as noteDate from customernotes where RefNumber LIKE '".$refrence."' ORDER BY noteID DESC");
            return $query->result();
        }

    }

    public function changeCategory(){
        $this->deleteFromOrderIntegrated($this->input->post('serialNumber'));
        $params = array('Printing'=>$this->input->post('val'),'Print_Total'=>'0.00','Print_Design'=>'','Print_Qty'=>'');
        $this->db->where('SerialNumber',$this->input->post('serialNumber'));
        $this->db->update('orderdetails',$params);
        return true;
    }
	
    public function deleteFromOrderIntegrated($serialNumber){
        if($serialNumber!="" && $serialNumber!="0" && $serialNumber!=0){


        $this->db->where('Serial',$serialNumber);
        $this->db->delete('order_attachments_integrated');
        }
        return true;
    }



    public function OrderInfo($orderID) {
        if(empty($orderID)){

            $orderID = end($this->uri->segments);

        }

        $query = $this->db->get_where('orders', array('OrderNumber' => $orderID));

        return $query->result();

    }
    function menufacture($id){

        $query=$this->db->query("select  ManufactureID from products  where ProductID='".$id."'");

        $res=$query->result();

        return $res;

    }
    function calculate_total_printed_labels($serial){

        $query = $this->db->query(" SELECT SUM(labels) AS total from order_attachments_integrated WHERE Serial LIKE '".$serial."'  ");
        $row = $query->row_array();
        return $row['total'];
    }

    function order_confirmation_email($OrderNumber){
       if(MODE == 'live') {


           $third = "";

           $query = $this->db->get_where('orders', array('OrderNumber' => $OrderNumber));
           $res = $query->result_array();
           $res = $res[0];


           $FirstName = $res['BillingFirstName'];
           $EmailAddress = 'umair.aalabels@gmail.com';//$res['Billingemail'];
           $date = $res['OrderDate'];
           $time = $res['OrderTime'];
           $OrderDate = date("d/m/Y", $date);
           $OrderTime = date("g:i A", $time);
           $PaymentMethod1 = $res['PaymentMethods'];
           $puchaseorder = $res['PurchaseOrderNumber'];

           if ($puchaseorder != '') {
               $puchaseorder = "<strong>Your PO No : </strong>" . $puchaseorder;
           }

           if ($PaymentMethod1 == 'chequePostel') {
               $PaymentMethod = "Pending payment";
               $pamentOrder = 'Cheque or BACS';
           }


           if ($PaymentMethod1 == 'creditCard') {
               $pamentOrder = 'Credit card';
               $PaymentMethod = "Pending processing";
           }


           if ($PaymentMethod1 == 'purchaseOrder') {
               $pamentOrder = 'Purchase order';
               $PaymentMethod = "Pending payment";
           }


           if ($PaymentMethod1 == 'paypal') {
               $pamentOrder = 'PayPal';
               $PaymentMethod = "Completed";
           }


           if ($PaymentMethod1 == 'purchaseOrder') {
               $paymentMethod = 'Purchase Orders';
           } elseif ($PaymentMethod1 == 'chequePostel') {
               $paymentMethod = 'Cheque or BACS';
           } elseif ($PaymentMethod1 == 'creditCard') {
               $paymentMethod = 'Credit Card';
           } elseif ($PaymentMethod1 == 'paypal') {
               $paymentMethod = 'Pay pal';
           } elseif ($PaymentMethod1 == 'account') {
               $paymentMethod = 'Account';
           }

           $websiteOrders = "Backoffice";


           $BillingTitle = $res['BillingTitle'];
           $BillingFirstName = $res['BillingFirstName'];
           $BillingLastName = $res['BillingLastName'];
           $BillingCompanyName = $res['BillingCompanyName'];
           $BillingAddress1 = $res['BillingAddress1'];
           $BillingAddress2 = $res['BillingAddress2'];
           $BillingTownCity = $res['BillingTownCity'];
           $BillingCountyState = $res['BillingCountyState'];
           $BillingPostcode = $res['BillingPostcode'];
           $BillingCountry = $res['BillingCountry'];
           $Billingtelephone = $res['Billingtelephone'];
           $BillingMobile1 = $res['BillingMobile'];
           $Billingfax = $res['Billingfax'];
           $BillingResCom = $res['BillingResCom'];
           $DeliveryTitle = $res['DeliveryTitle'];
           $DeliveryFirstName = $res['DeliveryFirstName'];
           $DeliveryLastName = $res['DeliveryLastName'];
           $DeliveryCompanyName = $res['DeliveryCompanyName'];
           $DeliveryAddress1 = $res['DeliveryAddress1'];
           $DeliveryAddress2 = $res['DeliveryAddress2'];
           $DeliveryTownCity = $res['DeliveryTownCity'];
           $DeliveryCountyState = $res['DeliveryCountyState'];
           $DeliveryPostcode = $res['DeliveryPostcode'];
           $DeliveryCountry = $res['DeliveryCountry'];
           $DeliveryResCom = $res['DeliveryResCom'];
           $styleBillingCompnay = "";
           $styleDeliveryCompany = "";


           if ($BillingCompanyName != '') {
               $styleBillingCompnay = "<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>";
               $styleBillingCompnay .= $BillingCompanyName . "</td></tr>";
           }


           if ($DeliveryCompanyName != '') {
               $styleDeliveryCompany = "<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>" .
                   $styleDeliveryCompany .= $DeliveryCompanyName . "</td></tr>";
           }


           $exchange_rate = $res['exchange_rate'];
           $currencySymbol = "&pound;";
           $vatRate = "20.00";
           $DeliveryOption = "";
           $deliveryChargesExVat = number_format($res['OrderShippingAmount'] / (($vatRate + 100) / 100), 2, '.', '');


           if ($deliveryChargesExVat) {
               $DeliveryExVatCost = $deliveryChargesExVat;
           } else {
               $DeliveryExVatCost = '0.00';
           }


           if ($res['OrderShippingAmount']) {
               $DeliveryIncVatCost = number_format($res['OrderShippingAmount'], 2, '.', '');
           } else {
               $DeliveryIncVatCost = '0.00';
           }


           $OrderTotalExVAT = number_format($res['OrderTotal'] / 1.2, 2);
           $OrderTotalIncVAT = number_format($res['OrderTotal'], 2);
           $CompanyName = "AALABELS";


           $orderecords = $this->db->get_where('orderdetails', array('OrderNumber' => $OrderNumber));
           $num_row = $orderecords->num_rows();
           $info_order = $orderecords->result_array();
           $TotalQuantity = "";
           $SubTotalExVat1 = "";
           $SubTotalIncVat1 = "";
           $rows = "";
           $i = 0;
           $bgcolor = '';

           foreach ($info_order as $rec) {


               $prl = $rec['Prl_id'];
               $ProductName = $rec['ProductName'];
               $PriceExVat1 = $rec['Price'];
               $PriceExVat = $PriceExVat1;
               $UnitPrice = number_format(round(($rec['Price'] / $rec['Quantity']), 4), 4, '.', '');
               $PriceIncVat = number_format(($rec['ProductTotal']), 2, '.', '');
               $Quantity = $rec['Quantity'];
               $TotalQuantity += $Quantity;
               $ProductCode = $rec['ProductID'];


               if ($rec['ManufactureID'] == "PRL1" || $rec['ManufactureID'] == "SCO1") {
                   $ManufacturerId = $rec['ManufactureID'];
               } else {
                   $ManufacturerId = $this->menufacture($ProductCode);
                   $ManufacturerId = $ManufacturerId[0]->ManufactureID;
               }

               if ($bgcolor == '') {
                   $bgcolor = '#F5F5F5';
               } else {
                   $bgcolor = '';
               }

               if ($rec['Printing'] == "Y") {
                   $totallabelsused = $this->calculate_total_printed_labels($rec['SerialNumber']);
               } else {
                   if (isset($rec['is_custom']) and $rec['is_custom'] == 'Yes') {
                       $LabelsPerSheet = $rec['LabelsPerRoll'];
                   } else {
                       $LabelsPerSheet = $this->LabelsPerSheet($rec['ProductID']);
                   }
                   $totallabelsused = $Quantity * $LabelsPerSheet;
               }


               if ($rec['ManufactureID'] == "SCO1") {
                   $custominfo = $this->fetch_custom_die_order($rec['SerialNumber']);
                   $iseuro = ($custominfo['iseuro'] == 1) ? "Yes" : "No";

                   $ProductName = '<b>Format:</b> ' . $custominfo['format'] . '&nbsp;&nbsp;  <b>Shape:</b> ' . $custominfo['shape'] . '&nbsp;&nbsp; <b>Width:</b> ' . $custominfo['width'] . ' mm  &nbsp;&nbsp;';

                   if ($custominfo['shape'] != "Circle") {
                       $ProductName .= '<b>Height:</b> ' . $custominfo['height'] . ' mm&nbsp;&nbsp;';
                   }
                   $ProductName .= '<b>No. labels / Die:</b> ' . $custominfo['labels'];
               }


               $rows .= '<tr bgcolor="' . $bgcolor . '" height="25">

						<td valign="top">

							' . $ManufacturerId . '

						</td>

						<td valign="top" colspan="2">

							' . $ProductName . '

						</td>
					
							<td valign="top">

							

							' . $Quantity . '

						</td>
						
						<td valign="top">

							'.symbol.number_format($UnitPrice * $exchange_rate, 2) . '

						</td>
						
					
						


						

						<td valign="top">

							' . symbol . number_format($PriceExVat * $exchange_rate, 2) . '

						</td></tr>';

//////////////////////////////////////////////
               $printexvat = 0;
               $printincvat = 0;
               //if($rec['Printing']=="Y" && preg_match('/A4/is',$rec['ProductName'])){
               if ($rec['Printing'] == "Y") {
                   $path = base_url() . "aalabels/img/blue-tick.png";


                   /*if($rec['Print_Type']=="Mono"){
                          $desntype = "Monochrome (Black Only)";
                          $typeshow = "Black Text";
                   }else
                   if($rec['Print_Type']=="Fullcolour+White"){
                           $desntype = "Full colour + White";
                           $typeshow = "Full colour + White";
                   }else
                   if($rec['Print_Type']=="Fullcolour"){
                           $desntype = "Full colour";
                           $typeshow = "Full colour";
                   }*/

                   $desntype = $typeshow = $this->get_printing_service_name($rec['Print_Type']);


                   $first = '<img src="' . $path . '" width="12" height="12"/><b>' . $typeshow . '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                   $second = '<img src="' . $path . '" width="12" height="12"/><b>' . $rec['Print_Design'] . '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                   $free = $rec['Print_Qty'] - $rec['Free'];

                   if ($rec['Free'] >= $rec['Print_Qty']) {
                       $free = 0;
                   }

                   if ($rec['Print_Design'] == "1 Design") {
                       $third = '<img src="' . $path . '" width="12" height="12"/>' . '&nbsp;&nbsp;<b>' . $rec['Print_Qty'] . " Design " . $desntype . '</b>';

                   } else
                       if ($rec['Print_Design'] == "Multiple Designs") {

                           $third = '<img src="' . $path . '" width="12" height="12"/>' . '&nbsp;&nbsp;<b>' . $rec['Print_Qty'] . " Designs " . $desntype . "( " . $free . " + " . $rec['Free'] . " Free )</b>";
                       }


                   $rows .= '<tr bgcolor="' . $bgcolor . '" height="25">
					<td valign="top"></td>
<td valign="top" style="font-size:10px;color:#43a2cb"> ' . $first . '  ' . $second . '  ' . $third . '</td>
<td valign="top"></td>
<td valign="top">' .symbol.number_format($rec['Print_UnitPrice'] * $exchange_rate, 2) . '</td>
<td valign="top">' . $rec['Print_Qty'] . '</td>
<td valign="top">' . symbol.number_format($rec['Print_Total'] * $exchange_rate, 2) . '</td></tr>';


                   $printexvat = $rec['Print_Total'];
                   $printincvat = $rec['Print_Total'] * 1.2;
               }

               if ($rec['ManufactureID'] == "SCO1" && $rec['Linescompleted'] == 0) {
                   $cuspriceexvat = $custominfo['plainprice'] + $custominfo['printprice'];
                   $cuspriceincvat = $cuspriceexvat * 1.2;
                   $printexvat = $cuspriceexvat;
                   $printincvat = $cuspriceincvat;

                   $setupline = '<b>Material:</b> ' . $custominfo['material'] . '&nbsp;&nbsp;';
                   $ldrg = ($custominfo['shape'] == "Circle") ? $custominfo['width'] : $custominfo['width'];


                   if ($custominfo['format'] == "Roll") {
                       $setupline .= '<b>Leading Edge:</b> ' . $ldrg . ' mm &nbsp;&nbsp;<b>No of Rolls:</b> ' . $custominfo['qty'] . '&nbsp;&nbsp; <b>Total Labels:</b> ' . $custominfo['rolllabels'] . '&nbsp;&nbsp; <b>Core Size:</b> ' . $custominfo['core'] . '&nbsp;&nbsp; <b>Wound:</b> ' . $custominfo['wound'];
                   } else {
                       $setupline .= '<b>No of Sheets:</b> ' . $custominfo['qty'] . ' &nbsp;&nbsp;';
                   }
                   $setupline .= '&nbsp;&nbsp;<b>Corner radius:</b> ' . $custominfo['cornerradius'] . ' mm &nbsp;&nbsp;';

                   if ($custominfo['labeltype'] == "printed") {
                       $setupline .= '<b>Printing:</b> ' . $custominfo['printing'] . '&nbsp;&nbsp; <b>No. Designs:</b> ' . $custominfo['designs'];
                       if ($custominfo['format'] == "Roll") {
                           $setupline .= '&nbsp;&nbsp;<b>Finishing:</b> ' . $custominfo['finish'];
                       }
                   }


                   $rows .= '<tr bgcolor="' . $bgcolor . '" height="25">
				<td valign="top"></td>
<td valign="top" style="font-size:10px;color:#43a2cb">' . $setupline . '</td>
<td valign="top"></td>
<td valign="top"></td>
<td valign="top">' . symbol . ' ' . number_format($cuspriceexvat * $exchange_rate, 2) . '</td>
<td valign="top">' . symbol . ' ' . number_format($cuspriceexvat * $exchange_rate, 2) . '</td></tr>';

               }


               $lineexvat = $PriceExVat + $printexvat;
               $lineincvat = $PriceIncVat + $printincvat;


//////////////////////////////////////////////////


               if ($ManufacturerId == "PRL1") {

                   $result = $this->get_details_roll_quotation($prl);

                   $rows .= '<tr bgcolor="' . $bgcolor . '" height="25">

						<td valign="top"></td>	
						

						<td valign="top">

						<b>Shape:</b> ' . $result['shape'] . ' &nbsp;&nbsp;

						<b>Material:</b> ' . $result['material'] . ' &nbsp;&nbsp;

						<b>Printing:</b> ' . $result['printing'] . ' &nbsp;&nbsp;

						<b>Finishing:</b> ' . $result['finishing'] . ' &nbsp;&nbsp;

						<b>No. Designs:</b> ' . $result['no_designs'] . ' &nbsp;&nbsp;

						<b>No. Rolls:</b> ' . $result['no_rolls'] . ' &nbsp;&nbsp;

						<b>No. labels:</b> ' . $result['no_labels'] . ' &nbsp;&nbsp;

						<b>Core Size:</b> ' . $result['coresize'] . ' &nbsp;&nbsp;

						<b>Wound:</b> ' . $result['wound'] . ' &nbsp;&nbsp;

						<b>Notes:</b> ' . $result['notes'] . ' &nbsp;&nbsp;

						

						</td>	

						<td valign="top"></td>	

						<td valign="top"></td>
						<td valign="top"></td>		

						<td valign="top"></td></tr>';

               }


               $rows .= '<tr bgcolor="' . $bgcolor . '" height="25">

			

			<td valign="top"></td>	

			<td valign="top"></td>

			<td valign="top" colspan="2">Line Total:</td>

			<td valign="top"></td>

			<td valign="top">

							'.symbol.number_format($lineexvat * $exchange_rate, 2) . '

						</td></tr>';


               $SubTotalExVat1 += $lineexvat;
               $SubTotalIncVat1 += $lineincvat;


               $i++;

           }


           $SubTotalExVat = number_format($SubTotalExVat1, 2, '.', '');
           $SubTotalIncVat = number_format($SubTotalIncVat1, 2, '.', '');

           $OrderTotalExVAT1 = $DeliveryExVatCost + $SubTotalExVat;

           $OrderTotalExVAT = number_format($OrderTotalExVAT1, 2, '.', '');
           $OrderTotalIncVAT = number_format(($DeliveryIncVatCost + $SubTotalIncVat1), 2, '.', '');


           $exvatSubtotalExVat = symbol . number_format($SubTotalExVat * $exchange_rate, 2);
           $exvatSubtotalIncVat = symbol . number_format($SubTotalIncVat * $exchange_rate, 2);


           $deliveryExVat = symbol . number_format($DeliveryExVatCost * $exchange_rate, 2);
           $deliveryIncVat = symbol . number_format($DeliveryIncVatCost * $exchange_rate, 2);

           $gtotalExVat = symbol . number_format($OrderTotalExVAT * $exchange_rate, 2);
           $gtotalIncVat = symbol . number_format($OrderTotalIncVAT * $exchange_rate, 2);

           $vatTotal = number_format($OrderTotalIncVAT - $OrderTotalExVAT, 2, '.', '');


           $bill_rc = $res['BillingCompanyName'];

           $del_rc = $res['DeliveryCompanyName'];

           $email = $res['Billingemail'];


           if (isset($res['CustomOrder']) && $res['CustomOrder'] != "" && $res['CustomOrder'] != 0) {
               $mailid = 127;

           } else {
               $mailid = 3;
           }

           $sql = $this->db->get_where(Template_Table, array('MailID' => $mailid));

           $result = $sql->result_array();

           $result = $result[0];

           $mailTitle = $result['MailTitle'];

           $mailName = $result['Name'];

           $from_mail = $result['MailFrom'];

           $mailSubject = $result['MailSubject'] . ' : ' . $OrderNumber;

           //$mailText = $result['MailBody'];
				 
			 $getfile = FCPATH.'application/views/order_quotation/email/order-confirmation.html';
		      $mailText = file_get_contents($getfile);


           $strINTemplate = array("[WEBROOT]", "[FirstName]", "[OrderNumber]", "[OrderDate]", "[OrderTime]", "[PaymentMethod]",

               "[BillingTitle]", "[BillingFirstName]", "[BillingLastName]",

               "[BillingCompanyName]", "[BillingAddress1]", "[BillingAddress2]", "[BillingTownCity]", "[BillingCountyState]",

               "[BillingPostcode]", "[BillingCountry]", "[Billingtelephone]", "[BillingMobile]", "[Billingfax]", "[EmailAddress]",

               "[DeliveryTitle]", "[DeliveryFirstName]", "[DeliveryLastName]", "[DeliveryCompanyName]", "[DeliveryAddress1]",

               "[DeliveryAddress2]", "[DeliveryTownCity]", "[DeliveryCountyState]", "[DeliveryPostcode]", "[DeliveryCountry]",

               "[ProductCode]", "[ProductName]", "[Quantity]", "[PriceExVat]", "[PriceIncVat]", "[SubTotalExVat]", "[SubTotalIncVat]",

               "[OrderSubTotal]", "[DeliveryOption]", "[DeliveryExVatCost]", "[DeliveryIncVatCost]", "[OrderTotalExVAT]",

               "[OrderTotalIncVAT]", "[OrderItems]", "[Currency]", "[Packaging]", "[incvat]", "[exvat]", "[deliveryexvat]",

               "[deliveryincvat]", "[deliveryoption]", "[gtotalExvat]", "[gtotalIncvat]", "[paymentMethods]", "[styleBillingConpnay]",

               "[styleDeliveryConpnay]", "[vatprice]", "[pamentOrder]", "[weborder]", "[BillingResCom]", "[DeliveryResCom]", "[voucherDiscount]", "[VATNUMBER]", "[PONUMBER]");


           $webroot = base_url() . "theme/";

           //----------------------------------------------------------------------------------------------

//        $qry1 = "select `UserID` from `orderdetails` where `OrderNumber` = '".$OrderNumber."'";
//
//        $exe1 = mysql_query($qry1);
//
//        $res1 =  $this->getOrderDetail($OrderNumber); ;
//
//        $qry2 = "select * from `customers` where `UserID` = '".$res1['UserID']."'";
//
//        $exe2 = mysql_query($qry2);
//
//        $res2 = mysql_fetch_array($exe2);


           $res1 = $this->getOrderDetail($OrderNumber);


           $res2 = $this->db->query("select * from `customers` where `UserID` = '" . $res1[0]->UserID . "'")->result_array();
           //-----------------------------------------------------------------------------------------------


           $DeliveryExVatCost = symbol . number_format($DeliveryExVatCost * $exchange_rate, 2);


           /*--------------------------Voucher Code--------------------*/

           if ($res['voucherOfferd'] == 'Yes') {

               $voucherDiscount = $res['voucherDiscount'];

               $voucher_code = '<tr height="20px;"><td colspan="2">&nbsp;</td><td align="right" colspan="3" >Voucher Discount: </td><td align="top">&pound;' . $voucherDiscount . '</td></tr>';

           } else {

               $voucherDiscount = 0.00;

               $voucher_code = '';

           }

           $gtotalIncVat = number_format($OrderTotalIncVAT - $voucherDiscount, 2, '.', '');


           if ($res['vat_exempt'] == 'yes') {
               $gtotalIncVat = number_format($OrderTotalExVAT - $voucherDiscount, 2, '.', '');
               $vatTotal = 0.00;
           } else {
               $vatTotal = symbol . number_format($vatTotal * $exchange_rate, 2);
           }

           $gtotalIncVat = symbol . number_format($gtotalIncVat * $exchange_rate, 2);


           /*--------------------------Voucher Code--------------------*/


           $strInDB = array($webroot, $BillingFirstName, $OrderNumber, $OrderDate, $OrderTime, $PaymentMethod, $BillingTitle,

               $BillingFirstName, $BillingLastName,

               $BillingCompanyName, $BillingAddress1, $BillingAddress2, $BillingTownCity, $BillingCountyState,

               $BillingPostcode, $BillingCountry, $Billingtelephone, $BillingMobile1, $Billingfax, $EmailAddress,

               $DeliveryTitle, $DeliveryFirstName, $DeliveryLastName, $DeliveryCompanyName, $DeliveryAddress1,

               $DeliveryAddress2, $DeliveryTownCity, $DeliveryCountyState, $DeliveryPostcode, $DeliveryCountry,

               $ManufacturerId, $ProductName, $Quantity, $PriceExVat, $PriceIncVat, $SubTotalExVat, $SubTotalIncVat,

               '', $DeliveryOption, $DeliveryExVatCost, $DeliveryIncVatCost, $OrderTotalExVAT,

               $OrderTotalIncVAT, $rows, $currencySymbol, '', $exvatSubtotalIncVat, $exvatSubtotalExVat, $deliveryExVat, $deliveryIncVat, $DeliveryOption, $gtotalExVat, $gtotalIncVat, $PaymentMethod, $styleBillingCompnay, $styleDeliveryCompany, $vatTotal, $pamentOrder, $websiteOrders, $bill_rc, $del_rc, $voucher_code, $res['CustomOrder'], $puchaseorder);


           $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);

				 
           $this->load->library('email');

           $this->email->from($from_mail, 'AALABELS');

           $this->email->to($EmailAddress);

           $this->email->subject($mailSubject);

           $this->email->message($newPhrase);

           $this->email->set_mailtype("html");

           $this->email->send();
       }
    }

    public function LabelsPerSheet($id){
        $this->db->select('LabelsPerSheet');
        $this->db->where('ProductID',$id);
        $query = $this->db->get('products');
        $row = $query->result();
        return $row[0]->LabelsPerSheet;
    }


    public function orderNewLine($record){
        $price = $record['new_line_qty'] * $record['new_line_unit_price'];
        $param = array(
            'ManufactureID'=>$record['new_line_man'],
            'ProductName'=>$record['new_line_des'],
            'Quantity'=>$record['new_line_qty'],
            'labels'=>$record['new_line_qty'],
            'Price'=>$price,
            'ProductTotalVAT'=>$price,
            'ProductTotal'=>$price,
            'OrderNumber'=>$record['quoNumber'],
            'UserID'=>$record['CustomerID'],
        );
       // print_r($param);exit;
        $this->db->insert('orderdetails',$param);
        return true;

    }

    public function deletePlainLine(){
      $serialnumber = $this->input->get('id');
       if(isset($serialnumber) && $serialnumber!=""){  
        $this->db->where('SerialNumber',$serialnumber);
        $this->db->delete('orderdetails');
      }    
        return true;
    }
    public function updateOrderNewLine($record){
        $price = (float)$record['update_line_qty'] * (float)$record['update_line_unit_price'];
        $param = array(
            'ManufactureID'=>$record['update_line_man'],
            'ProductName'=>$record['update_line_des'],
            'Quantity'=>$record['update_line_qty'],
            'Price'=>$price,
            'ProductTotalVAT'=>$price,
            'ProductTotal'=>$price *vat_rate,
            'UserID'=>$record['userId'],
        );
        $this->db->where('SerialNumber',$record['serialNumber']);
        $this->db->update('orderdetails',$param);
        return true;
    }
    public function getOrderDetailByArray($orderNumber){
        $results = $this->db->select("od.*")
            ->from('orderdetails as od')
            ->where('od.OrderNumber',$orderNumber)
            ->get()->result_array();
        return $results;
    }
    public function getOrderByArray($orderNumber){
        $results = $this->db->select("o.*")
            ->from('orders as o')
            ->where('o.OrderNumber',$orderNumber)
            ->get()->row_array();
        return $results;
    }
    public function makeZeroPrice($orderNumber){
        $order = $this->getOrderByArray($orderNumber);
       // print_r($order);exit;

        $order['OrderShippingAmount'] = 0.00;
        $order['OrderTotal'] = 0.00;
        $this->db->where('OrderNumber',$orderNumber);
        $this->db->update('orders',$order);
        $ordersDetails = $this->getOrderDetailByArray($orderNumber);
        foreach ($ordersDetails as $order){
           $order['Price'] = 0.00;
           $order['ProductTotalVAT'] = 0.00;
           $order['ProductTotal '] = 0.00;
           $order['Print_UnitPrice'] = 0.00;
           $order['Print_Total'] = 0.00;

           $this->db->where('SerialNumber',$order['SerialNumber']);
           $this->db->update('orderdetails',$order);
        }

        return true;
    }

    public function insert_payment_log($type,$ordermo,$payment,$situation=NULL){
        $situation = (isset($situation) && $situation=="refund")?"refund":"taken";
        $array = array('type'=>$type,'OrderNumber'=>$ordermo,'operator'=>$this->session->userdata('UserName'),'payment'=>$payment,'situation'=>$situation,'time'=>time());
        $this->db->insert('order_payment_log',$array);
    }

    public function getstatus($orderid){

        $query = $this->db->select('OrderStatus')

            ->where('OrderID',$orderid)

            ->get('orders');

        $data = $query->row_array();

        return $data['OrderStatus'];



    }
    public function getordernumber($orderid){

        $query = $this->db->select('OrderNumber')

            ->where('OrderID',$orderid)

            ->get('orders');

        $data = $query->row_array();

        return $data['OrderNumber'];



    }

    function deallocatestock($ordernumber){
        $stock = $this->db->query("select * from stock_produced where order_no LIKE '".$ordernumber."' and type LIKE 'Stock' ")->result();
        foreach($stock as $row){
            $barcode = $this->db->query("select * from stock where barcode LIKE '".$row->barcode."'")->row_array();
            if($row->dispatch==1){
                $newqty = $barcode['qty'] + $row->qty;
                $newalloc = $barcode['allocated'] - $row->qty;
                $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
            }else{
                $newqty = $barcode['qty'] + $row->qty;
                $newalloc = $barcode['allocated'] - $row->qty;
                $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
            }
            $this->db->where('barcode',$row->barcode);
            $this->db->update('stock',$array);
        }

        $where = "order_no LIKE '".$ordernumber."' AND type LIKE 'Stock'";
        $this->db->where($where);
        $this->db->delete('stock_produced');

    }

    public function changestatus($id,$status){
        $old = $this->getstatus($id);
        $ordernumber = $this->getordernumber($id);
        $details = $this->getOrder($ordernumber);
        $paymentDate  = $details[0]->PaymentDate;
        $paymentDate = (isset($paymentDate) && $paymentDate!="")?$details[0]->PaymentDate:strtotime(date('Y-m-d h:i:s'));
		
		$userId = $this->session->userdata('UserID');
		$userTypeId = $this->session->userdata('UserTypeID');
		if($userId == '652793' || $userId == '653722' && $userTypeId == '1'){
			if($status == '34'){
				$data = $this->get_status_log($ordernumber,'1');
				$data_two = $this->get_status_log($ordernumber,'1,1');
				if($data == '6' || $data=='78' || $data_two == '6' || $data_two=='78'){
					$status = '6';
				}
			}
			
		}
		
		$update = array(
			'OrderStatus'     => $status,
			'PaymentDate'     => $paymentDate,
			'Old_OrderStatus' =>'',
            'picking_status'  => 0
		);
        $this->db->where('OrderID',$id);
        $this->db->update('orders',$update);
        $update_log = array(
            'ID'                =>  NULL,
            'OrderNumber'       =>  $ordernumber,
            'OrderStatus_new'   =>  $status,
            'OrderStatus_old'   =>  $old,
            'Oprator'           =>  $this->session->userdata('UserName')  ,
            'SALE_ID'           =>  $this->session->userdata('UserID'),
            'Date'              =>  time()
        );
        $this->db->insert('status_change_log',$update_log);
        if($status==27){
            $this->deallocatestock($ordernumber);
        }
        $this->custom->assign_dispatch_date($ordernumber,TRUE);
    }
	
	function get_status_log($OrderNumber,$limit){
		
		$query = $this->db->query("SELECT * FROM status_change_log WHERE OrderNumber = '$OrderNumber' order by ID Desc limit $limit");
		$row = $query->row_array();
		return $row['OrderStatus_old'];
	}
	
    
    function min_qty_integrated($menuid){
		$query =   $this->db->query("select MIN(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 
		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");
		$row = $query->row_array();
		return $row['qty'];
	}
	
	function max_qty_integrated($menuid){
		$query =   $this->db->query("select MAX(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 
		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");
		$row = $query->row_array();
		return $row['qty'];
	}
    
    
    function calulate_min_rolls($manufature1){
		$manufature = substr($manufature1,0,-1);
		$roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'"); 
		$roll = $roll->row_array();
		return  $roll['Rolls']; 
	}
    
	function calulate_max_rolls($manufature1){
		$manufature = substr($manufature1,0,-1);
		$roll = $this->db->query("SELECT MAX(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'"); 
		$roll = $roll->row_array();
		return  $roll['Rolls']; 
	}
	
	
	
	
	
    public function order_confirmation_new($OrderNumber,$referertype=NULL){
	   	 
    $query = $this->db->get_where('orders', array('OrderNumber' => $OrderNumber));
    ///echo '<pre>'; print_r($query);
		$res = $query->result_array();
		$res = $res[0];
		
		$FirstName 		= 	$res['BillingFirstName'];
		$EmailAddress 	=	$res['Billingemail'];	
		$date  			= 	$res['OrderDate'];
		$time			=	$res['OrderTime'];	
		$OrderDate 		= 	date("d/m/Y",$date);
		$OrderTime 		= 	date("g:i A",$time);
		$PaymentMethod1 =	$res['PaymentMethods' ];
		
		 $DeliveryText = "Delivery:";
		
		$symbol = $this->orderModal->get_currecy_symbol($res['currency']);
		
		$PaymentMethod = '';
        
		$language = ($res['site']=="" || $res['site']=="en")?"en":"fr"; 
		$viewlink = ($language=="en")?"https://www.aalabels.com/english-version/".md5($OrderNumber):"https://www.aalabels.com/version-anglaise/".md5($OrderNumber);
		
		if($language =="en"){
		  $getfile = FCPATH.'application/views/order_quotation/email/order-confirmation.html';
        }else{
		  
            $getfile = FCPATH.'application/views/order_quotation/email/order-confirmation_fr.html';
		}
		$mailText = file_get_contents($getfile);
		
		$PONUMBER ='';
		if($res['PurchaseOrderNumber']){
			$PONUMBER = "<strong>Your PO No : </strong>".$res['PurchaseOrderNumber'];
		} 
		
		
		$customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is being processed for production. Upon completion of your order you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";
	
	
	    $pamentOrder = '';
		if($PaymentMethod1 == 'chequePostel'){ $PaymentMethod = "Pending payment" ; $pamentOrder='Via Cheque';
		    $customer_message = "<p>Thank you for purchasing from AA Labels and we confirm that your order has been received and is pending payment by bank transfer. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.<br /><br /><b style='color:#006da4'>Payment Details</b><br />BACS TRANSFER<br />";
			$customer_message .= '<table style="font-size:12px; padding-bottom:10px;" width="100%" border="0" cellspacing="0" cellpadding="0"><tr>	
    		<td width="15%;">Account Name:</td><td width="70%;">Green Technologies Limited T/A AA Labels</td></tr><tr><td width="15%;">Sort Code:</td><td width="70%;">40-36-15</td></tr><tr><td width="15%;">A/C No:</td><td width="70%;">52385724</td></tr><tr><td width="15%;">IBAN:</td><td width="70%;">GB87MIDL40361552385724</td></tr><tr><td width="15%;">SWIFT/BIC:</td><td width="70%;">HBUKGB4108R</td></tr></table>';
		
		}
			
		if($PaymentMethod1 == 'creditCard'){  
    $PaymentMethod = "Pending processing";
    $pamentOrder='Credit card';
  }
    
		if($PaymentMethod1 == 'purchaseOrder'){
    
    $PaymentMethod = "Pending payment"; 
    $pamentOrder='Via Purchase order';
    $purchase_order_txt = '';
    
    if($res['PurchaseOrderNumber']){
      $purchase_order_txt = "(PO No. ".$res['PurchaseOrderNumber'].")";
    } 
        	
    $customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending approval of your purchase order ".$purchase_order_txt.". Upon acceptance of payment by PO your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";
  }
			
		if($PaymentMethod1 == 'paypal'){
    $PaymentMethod = "Completed"; 
    $pamentOrder='Via PayPal';
  }
    
		if($PaymentMethod1 == 'Sample Order'){
            $PaymentMethod = "Sample Order";
            $pamentOrder='Sample Order';
        }
    
		if($PaymentMethod1=='PayPal eCheque'){
    $PaymentMethod='Via PayPal eCheque';
    $customer_message = "Thank you for purchasing from AA Labels and we confirm that your order has been received and is currently pending confirmation of your e-cheque payment from PayPal. Upon receipt of payment your order will be processed for production and after completion you will receive a confirmation of despatch email with delivery tracking details and a downloadable PDF VAT invoice.";
		}
				
		$BillingTitle 		=	$res['BillingTitle'];	    $BillingFirstName 	=	$res['BillingFirstName'];	
		$BillingLastName 	=	$res['BillingLastName'];	$BillingCompanyName =	$res['BillingCompanyName'];		
		$BillingAddress1 	=	$res['BillingAddress1'];	$BillingAddress2 	=	$res['BillingAddress2'];	
		$BillingTownCity 	=	$res['BillingTownCity'];	$BillingCountyState =	$res['BillingCountyState'];	
		$BillingPostcode 	=	$res['BillingPostcode'];	$BillingCountry 	=	$res['BillingCountry'];		
		$Billingtelephone 	=	$res['Billingtelephone'];	$BillingMobile1 	=	$res['BillingMobile'];	
		$Billingfax 		=	$res['Billingfax'];         $BillingResCom 		=	$res['BillingResCom'];
		$DeliveryTitle 		=	$res['DeliveryTitle'];		$DeliveryFirstName 	=	$res['DeliveryFirstName'];	
		$DeliveryLastName 	=	$res['DeliveryLastName'];	$DeliveryCompanyName=	$res['DeliveryCompanyName'];	 
		$DeliveryAddress1  	=	$res['DeliveryAddress1'];	$DeliveryAddress2 	=	$res['DeliveryAddress2'];	
		$DeliveryTownCity 	=	$res['DeliveryTownCity'];	$DeliveryCountyState=	$res['DeliveryCountyState'];	 
		$DeliveryPostcode 	=	$res['DeliveryPostcode'];	$DeliveryCountry 	=	$res['DeliveryCountry'];
		$DeliveryResCom 	=	$res['DeliveryResCom'];
		
		$styleBillingCompnay = ""; $styleDeliveryCompany = ""; $styleBillingCompnay = ""; $styleDeliveryCompany = "";
		
		
		if($BillingCompanyName!=''){		
			$styleBillingCompnay="<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>";
			$styleBillingCompnay.=$BillingCompanyName."</td></tr>";
		}
		
		if($DeliveryCompanyName!=''){
			$styleDeliveryCompany="<tr><td style='PADDING-RIGHT: 0px; PADDING-LEFT: 10px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px; HEIGHT: 30px'>".
			$styleDeliveryCompany.=$DeliveryCompanyName."</td></tr>";
		}
		
		
		
		$websiteOrders  = $res['Source'];
		$vatRate 	    = "20.00";
		$DeliveryOption = "";
		   
		$deliveryChargesExVat =	number_format($res['OrderShippingAmount']/(($vatRate+100)/100),2,'.','');
		$DeliveryExVatCost    = ($deliveryChargesExVat)?$deliveryChargesExVat:'0.00';
		
		
		
    // AA21 STARTS

        if( ($language =="en") )
        {
            if($res['PaymentMethods'] != 'Sample Order')
            {
                if( $DeliveryCountry == "France" ) {

                    if( ($res['OrderDeliveryCourierCustomer'] == "DPD") )
                    {
                        $DeliveryText = "Delivery (DPD): ";
                    }
                    else if( ($res['OrderDeliveryCourierCustomer'] == "Parcelforce") )
                    {
                        $DeliveryText = "Delivery (Parcelforce): ";
                        $DeliveryExVatCost = $DeliveryExVatCost;
                    }
                    else
                    {
                        $DeliveryText = "Delivery: ";
                        $DeliveryExVatCost = $DeliveryExVatCost;
                    }

                } else {
                    if( ($res['OrderDeliveryCourierCustomer'] == "DPD") )
                    {
                        $DeliveryExVatCost = (($DeliveryExVatCost)+1);
                        $DeliveryText = "Delivery (DPD): ";
                    }
                    else if( ($res['OrderDeliveryCourierCustomer'] == "Parcelforce") )
                    {
                        $DeliveryText = "Delivery (Parcelforce): ";
                        $DeliveryExVatCost = $DeliveryExVatCost;
                    }
                    else
                    {
                        $DeliveryText = "Delivery: ";
                        $DeliveryExVatCost = $DeliveryExVatCost;
                    }
                }
            }
        }
    /*if( ($language =="en") )
    {
      if($res['PaymentMethods'] != 'Sample Order')
      {
        if( ($res['OrderDeliveryCourierCustomer'] == "DPD") )
        {
          $DeliveryExVatCost = (($DeliveryExVatCost)+1);
          $DeliveryText = "Delivery (DPD): ";
        }
        else if( ($res['OrderDeliveryCourierCustomer'] == "Parcelforce") )
        {
          $DeliveryText = "Delivery (Parcelforce): ";
          $DeliveryExVatCost = $DeliveryExVatCost;
        }
        else
        {
          $DeliveryText = "Delivery: ";
          $DeliveryExVatCost = $DeliveryExVatCost;
        }
      }
    }*/
    // AA21 ENDS

	
		$DeliveryIncVatCost   = ($res['OrderShippingAmount'])?number_format($res['OrderShippingAmount'],2,'.',''):'0.00';
			
		$OrderTotalExVAT 	=	number_format($res['OrderTotal']/1.2,2);	
		$OrderTotalIncVAT 	= 	number_format($res['OrderTotal'],2);
		$CompanyName 		= 	"AALABELS";
		
       //$orderecords = $this->db->get_where('orderdetails', array('OrderNumber' => $OrderNumber));
       
       $this->db->select('od.*,p.ProductID,p.ProductBrand');
       $this->db->from('orderdetails as od');
       $this->db->join('products as p','p.ProductID=od.ProductID');
       $this->db->where(array('OrderNumber'=>$OrderNumber));
       $orderecords =  $this->db->get();
       
       
       $num_row = $orderecords->num_rows();
       $info_order = $orderecords->result_array();
       $TotalQuantity = "";
       $SubTotalExVat1 = "";
       $SubTotalIncVat1 = "";
       $rows = "";
       $i = 0;
       $bgcolor='';
			
			//echo '<pre>'; print_r($info_order); echo '</pre>';
		
		 foreach($info_order as $rec){ //error_reporting(E_ALL);
		    $prl   =   $rec['Prl_id'];          
			
			if($language=="fr" && $rec['ProductID']!=0){
				
			 //$t->lang->load('genral');	
				
			 $prod = $this->quoteModel->show_product($rec['ProductID']);
			 $merger = array_merge($prod,$rec);
		     $ProductName = $this->quoteModel->fetch_product_name($merger);
			}else{ $ProductName  = 	$rec['ProductName']; }
			
			
			//********************************************************************//
			
			 if($rec['ManufactureID']=="SCO1" && $language=="fr"){
				 $se = $rec['SerialNumber'];
				 $custominfo = $this->quoteModel->fetch_custom_die_order($se); 
				 $ProductName.= ' pour ';
				 $ProductName.= ($custominfo['format'] == 'Roll')?$custominfo['format'].' etiquettes ':$custominfo['format'].' Feuilles ';
				 $ProductName.= $custominfo['width'];
						 
				 if($custominfo['shape']!="Circle"){
					 $ProductName.= 'x'.$custominfo['height'].' mm ';
				 }
						 
				 if($custominfo['shape'] != ''){
					 $ProductName.= ' '.$custominfo['shape'].', ';
				 }
					 
				 if($custominfo['format']=="Roll"){
					 $ProductName.= "bord d'attaque ".$custominfo['width'].' mm, ';
				 }
					 
				 $ProductName.= "Rayon d'angle ".$custominfo['cornerradius'].' mm';
			
			 }else if($rec['ManufactureID']=="SCO1"){
				 
				 //echo 'else if';
				  $se = intval($rec['SerialNumber']);
					 $custominfo = $this->quoteModel->fetch_custom_die_order($se); 
				// echo $this->db->last_query();
				// print_r($custominfo); exit();
				 
					 $ProductName.= ' for ';
					 $ProductName.= ($custominfo['format'] == 'Roll')?$custominfo['format'].' Labels ':$custominfo['format'].' Sheets ';
					 $ProductName.= $custominfo['width'];
						 
					 if($custominfo['shape']!="Circle"){
						  $ProductName.= 'x'.$custominfo['height'].' mm ';
					 }
					 
					 if($custominfo['shape'] != ''){
						 $ProductName.= ' '.$custominfo['shape'].', ';
					 }
					 
					 if($custominfo['format']=="Roll"){
						 $ProductName.= 'Leading Edge '.$custominfo['width'].' mm, ';
					 }
					 
					 $ProductName.= 'Corner radius '.$custominfo['cornerradius'].' mm';
			
			}
			
			
			//********************************************************************//
	       
	       
     if($rec['Printing']=='Y'){
       $rec['Price'] = $rec['Price']+$rec['Print_Total'];
       $rec['ProductTotal'] = $rec['ProductTotal']+($rec['Print_Total']*1.2);
				
       if($language=="fr"){	
         if($rec['Print_Type']=="Monochrome - Black Only" || $rec['Print_Type']=="Mono"){
           $A4Printing = "Service d'impression ( Monochrome - Noir seulement )";
         }else{
           $frprnttype = $this->orderModal->get_printing_service_name($rec['Print_Type']);
           $frprint = $this->orderModal->get_db_column('digital_printing_process','name_fr','name',trim($frprnttype));
           $A4Printing = "Service d'impression ( ".$frprint." )";
         }
       }else{
         $frprint = $this->orderModal->get_printing_service_name($rec['Print_Type']);
         $A4Printing = "Printing Service ( ".$frprint." )";
       }
       $ProductName = $ProductName.' - <b>'.$A4Printing.'</b>';
     }
	
			$PriceExVat1	 =   $rec['Price'];
			$PriceExVat      =   $PriceExVat1;
			
			$PriceIncVat     =   number_format(($rec['ProductTotal']),2,'.','');	
				
			$Quantity	     =   $rec['Quantity'];
			$TotalQuantity	+=   $Quantity;
			$ProductCode     =	 $rec['ProductID'];
            $exchange_rate   =   $res['exchange_rate'];  
    
     
     
         
			
		
			 $ManufacturerId = $rec['ManufactureID'];
			 $bgcolor = ($bgcolor=='')?'#F5F5F5':'';
			 
			 
			 if($rec['Printing']=='Y'){
				 $lbpr = $this->orderModal->calculate_total_printed_labels($rec['SerialNumber']);
				 $LabelsPerSheet = $lbpr / $rec['Quantity'];
			 }else{
				 $LabelsPerSheet = ($rec['is_custom'] == 'Yes')?$rec['LabelsPerRoll']:$this->LabelsPerSheet($rec['ProductID']);
			 }
     
     $se = intval($rec['SerialNumber']);
     $custominfo = $this->quoteModel->fetch_custom_die_order($se); 
     
   
    
     $orignalQty   =   $rec['labels']; 
     
     if(preg_match('/Integrated/', $rec['ProductBrand'], $match)){
       $orignalQty   =   $rec['Quantity']; 
     }
   
     if($language=="fr"){
       
       $format = 'Feuilles';
       $regex  = "/Roll/";

       if(preg_match($regex, $rec['ProductBrand'], $match)){
         $format ='Rouleaux';
       } 
       
       
       
       
        if($rec['ManufactureID']=="SCO1" || $rec['ProductID']=="0"){
         $total_labels ='';
         $pers_ltxt = '';
         $orignalQty = '';
         
       }else{
          
          if($rec['sample']=='Sample'){
           
            if(preg_match($regex, $rec['ProductBrand'], $match)){
             $orignalQty = '';
             $total_labels = '';
            }else{
              $orignalQty = $LabelsPerSheet;
              $total_labels = ($orignalQty > 0)?"Étiquettes":"Étiquette";
            }
           
           
          }else{
            $total_labels = ($orignalQty > 0)?"Étiquettes":"Étiquette";
          }
          $pers_ltxt = 'Par Étiquettes';
       }
       
       
     }else{
       
       $format = 'Sheets';
       $regex  = "/Roll/";

       if(preg_match($regex, $rec['ProductBrand'], $match)){
         $format =($Quantity > 1)?'Rolls':'Roll';
       } 
       
       if($rec['ManufactureID']=="SCO1" || $rec['ProductID']=="0"){
         $total_labels ='';
         $pers_ltxt = '';
         $orignalQty = '';
         
       }else{
         
         if($rec['sample']=='Sample'){
           
           if(preg_match($regex, $rec['ProductBrand'], $match)){
             $orignalQty = '';
             $total_labels = '';
           }else{
              $orignalQty = $LabelsPerSheet;
             $total_labels = ($orignalQty > 0)?"Labels":"Label";
           }
           
           
         }else{
           $total_labels = ($orignalQty > 0)?"Labels":"Label";
         }
         
         
         $pers_ltxt = 'Per Labels';
       }
     }
     
     if($rec['ManufactureID']=="SCO1" || $rec['ProductID']=="0"){
       $UnitPrice	     =	 number_format(round(($rec['Price']/$Quantity), 3),3,'.','');	
       $qtyss = $Quantity;
     }else{
       $UnitPrice	     =	 number_format(round(($rec['Price']/$rec['labels']), 3),3,'.','');	
       $qtyss = $Quantity.' '.$format;
     }
     
     
     
     
     
     
    

			
			 $rows .='<tr>
			 	<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$ManufacturerId.'</td>
				<td colspan="2" style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" align="left">'.$ProductName.'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$qtyss.'<br>'.$orignalQty.' '.$total_labels.'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-	top:0;">'.$symbol.number_format($UnitPrice*$exchange_rate,3).'<br>'.$pers_ltxt.'</td>
				<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.$symbol.number_format($PriceExVat*$exchange_rate,2,'.','').'</td>
				</tr>';
					 
			 if($ManufacturerId=="PRL1"){
				 $result = $this->quoteModel->get_details_roll_quotation($prl);
				 $rows .='<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" colspan="2" align="left">
							<b>Shape:</b> '.$result['shape'].' &nbsp;&nbsp;
							<b>Material:</b> '.$result['material'].' &nbsp;&nbsp;
							<b>Printing:</b> '.$result['printing'].' &nbsp;&nbsp;
							<b>Finishing:</b> '.$result['finishing'].' &nbsp;&nbsp;
							<b>No. Designs:</b> '.$result['no_designs'].' &nbsp;&nbsp;
							<b>No. Rolls:</b> '.$result['no_rolls'].' &nbsp;&nbsp;
							<b>No. labels:</b> '.$result['no_labels'].' &nbsp;&nbsp;
							<b>Core Size:</b> '.$result['coresize'].' &nbsp;&nbsp;
							<b>Wound:</b> '.$result['wound'].' &nbsp;&nbsp;
							<b>Notes:</b> '.$result['notes'].' &nbsp;&nbsp;
					    </td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;"></td>
				      </tr>';
				    }
			 
		//********************************************************************//	 
			 if($ManufacturerId=="SCO1" && $rec['Linescompleted']==0){
				 $se = intval($rec['SerialNumber']);
				 //echo $rec['SerialNumber'];
				 $custominfo = $this->quoteModel->fetch_custom_die_order($se); 
				  $assoc = $this->quoteModel->fetch_custom_die_association(intval($custominfo['ID']));
				 	 
				 
				  if($language=="fr"){
					  
					foreach($assoc as $rowp){  
					 $assmatername='';
					 $fr_printing = ($rowp->labeltype=="printed")?"imprimé":"plaine";
					 $materilaname_fr = $this->quoteModel->get_mat_name_fr($rowp->material);
					 $assmatername.= $materilaname_fr.' - '.$rowp->labeltype.' etiquettes' ;
						  
						  ///********///////********///////********///////********////
						  if($rowp->labeltype=="printed"){  
						    
							if($rowp->printing=="Monochrome - Black Only" || $rowp->printing=="Mono"){
							  $fr_prnt_type = "Monochrome - Noir seulement";
							 }else{
							  $fr_prnt_type  = $this->orderModal->get_db_column('digital_printing_process', 'name_fr', 'name',trim($rowp->printing));
							  $rowpprinting  = $this->orderModal->ReplaceHtmlToString_($fr_prnt_type);
							 }
							 
							 $assmatername.=' - '.$rowpprinting.' - '.$rowp->designs.' Conceptions ';
							   if($custominfo['format']=="Roll"){
							     if($rowp->finish == "Gloss Lamination"){
									$finish_type_fr = 'Lamination Gloss';
								  }else if($rowp->finish == "Matt Lamination"){
									$finish_type_fr = 'Matt Lamination';
								  }else if($rowp->finish =="Matt Varnish"){
									$finish_type_fr = 'Vernis mat';
								  }else if($rowp->finish == "Gloss Varnish"){
									$finish_type_fr = 'Vernis brillant';
								  }else if($rowp->finish == "High Gloss Varnish"){
									$finish_type_fr = 'Vernis a haute brillance';
								  }else{
									$finish_type_fr == 'No Finish';
								  }
								   $assmatername.='<br> with label finish '.$finish_type_fr;
						       }
						  }
       
       $dicheck = 'Sheet';
						  ///********///////********///////********///////********///////********////
       
				          if($custominfo['format']=="Roll"){
                $dicheck ='Roll';
                $assmatername.=' - '.$rowp->rolllabels.' etiquettes - taille de noyau '.$rowp->core.' mm - '.$rowp->wound.' blessure';
						  }
				
				    $cuspriceexvat = $rowp->plainprice+$rowp->printprice;
						  
       
       
       
       
       $s = '';
       if($rowp->qty > 1){ $s = 's';}
        $She_Ro =  $rowp->qty." ".ucfirst($dicheck).$s;
       $lbl = '';
       if($custominfo["format"] =='Roll'){
         $lbl = $rowp->rolllabels;
       } else {
         $lbl = ( ($custominfo['around'] * $custominfo['across']) * $rowp->qty);
         
       }
       
       $unitmaterialprice = $cuspriceexvat/$lbl;
       $typess = $She_Ro."<br>".$lbl." Etiquettes";
						  
					  $rows .='<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
						<td colspan="2" style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" align="left"><b>'.$rowp->material.'</b> - '.$assmatername.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$typess.'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$symbol.number_format($unitmaterialprice*$exchange_rate,3,'.','').'</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.$symbol.number_format($cuspriceexvat*$exchange_rate,2,'.','').'</td>
				      </tr>';
						$cuspriceincvat = $cuspriceexvat*1.2; 
						$PriceExVat+= $cuspriceexvat;
						$PriceIncVat+= $cuspriceincvat;	
					}
				  }else{
				  
						foreach($assoc as $rowp){
							$assmatername='';  
							$materilaname_en = $this->quoteModel->get_mat_name($rowp->material);
							$assmatername.= $materilaname_en.' - '.$rowp->labeltype.' labels' ;
						  
							if($rowp->labeltype=="printed"){  
								$assmatername.=' - '.$rowp->printing.' - '.$rowp->designs.' Designs ';
								if($custominfo['format']=="Roll"){
									$assmatername.='<br> with label finish '.$rowp->finish;
								}
							}
							
        $dicheck ='Sheet';
							if($custominfo['format']=="Roll"){
         $dicheck ='Roll';
								$assmatername.=' - '.$rowp->rolllabels.' labels - core size '.$rowp->core.' mm - '.$rowp->wound.' wound';
							}
				
							$cuspriceexvat = $rowp->plainprice+$rowp->printprice;
						 
        
        
        $s = '';
        if($rowp->qty > 1){ $s = 's';}
        $She_Ro =  $rowp->qty." ".ucfirst($dicheck).$s;
        $lbl = '';
        if($custominfo["format"] =='Roll'){
          $lbl = $rowp->rolllabels;
           
        } else {
           $lbl = ( ($custominfo['around'] * $custominfo['across']) * $rowp->qty);
           
        }
       
        $unitmaterialprice = number_format($cuspriceexvat/$lbl,3);
        $typess = $She_Ro."<br>".$lbl." labels";
						  
							$rows .='<tr>
							<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;"></td>
							<td colspan="2" style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" align="left"><b>'.$rowp->material.'</b> - '.$assmatername.'</td>
							<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">'.$typess.'</td>
							<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-		top:0;">'.$symbol.number_format($unitmaterialprice*$exchange_rate,3,'.','').'</td>
							<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0; color:#fd4913;">'.$symbol.number_format($cuspriceexvat*$exchange_rate,2,'.','').'</td>
							</tr>';
							$cuspriceincvat = $cuspriceexvat*1.2; 
							$PriceExVat    += $cuspriceexvat;
							$PriceIncVat   += $cuspriceincvat;	
						}
					}		
      
      
      
			 }
			
			
			//********************************************************************//
     
     
     
     //echo $rec['odp_proof'];
          if($rec['odp_proof'] == 'Y'){
     $foc_type = 0;
     if ($rec['odp_foc'] == 'Y'){ $foc_type =  'Press Proof - Foc';}
     if ($rec['odp_foc'] == 'other') {     $foc_type =  $rec['odp_foc'];}
     if ($rec['odp_foc'] != 'Y' && $rec['odp_foc'] != 'other') { 
       $foc_type =  "Up to ".$rec["odp_foc"]." Designs ";
     }
     
     $opd_pr = 0;
     if($rec['odp_price']!=0){
       $opd_pr =  $symbol.number_format(($rec["odp_price"] / $rec["odp_qty"]) * $exchange_rate,2);
    } else { 
       $opd_pr =  $symbol."0.00";
   } 
     
     $prss = ($rec["odp_price"] !="")?number_format($rec["odp_price"] * $exchange_rate,2) : "0.00";
     
    
       $rows .='<tr>  
    <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" class="text-center labels-form ">'.$foc_type.'</td>
    <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" colspan="2" align="left">Physical Press Proof, Pre-Press Approval Required</td>
    <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;" class="text-center">'.$opd_pr.'</td>
    <td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0; text-align:center">'.$rec["odp_qty"].'</td>
   
    <td style="font-size:12px; border:1px solid #b3b3b3; border-top:0;" class="text-center">'.$symbol.$prss.'</td></tr>'; 
       $PriceExVat    += $prss;
     }
      
			
					 
			   $SubTotalExVat1 += $PriceExVat;
			   $SubTotalIncVat1 += $PriceIncVat;
			   $i++;
		 
		 }
			
			   
		   $di_ver = ($language=="en")?"Discount":"Remise";
		   $em_sub = ($language=="en")?"ORDER CONFIRMATION ":"CONFIRMATION DE COMMANDE"; 
		   
			
	 /*--------------------------Voucher Code--------------------*/
       if($res['voucherOfferd']=='Yes'){
         $voucherDiscount =  $res['voucherDiscount'];
         $voucherDiscounts = number_format(($voucherDiscount / 1.2) * $exchange_rate,2);
					
         $voucher_code = '<tr><td align="right">'.$di_ver.':</td><td style="color: #006da4; padding-left:10px;"    align="right">'.$symbol.$voucherDiscounts.'</td></tr>';
       }
       else{
         $voucherDiscount = 0.00;
         $voucher_code = '';
       }
  
   /*--------------------------Voucher Code--------------------*/
			
		  
	  $SubTotalExVat	=	number_format($SubTotalExVat1,2,'.','');	
	  $SubTotalIncVat	=	number_format($SubTotalIncVat1,2,'.','');
	  
	  $OrderTotalExVAT1 = $SubTotalExVat  - round($voucherDiscount/1.2,2);
	  $OrderTotalExVAT	 =	number_format($OrderTotalExVAT1,2,'.','');	
			
			
	  $exvatSubtotalExVat=$symbol.$SubTotalExVat;
	  $exvatSubtotalIncVat=$symbol.$SubTotalIncVat;
				
	  $deliveryExVat=$symbol.$DeliveryExVatCost;
	  $deliveryIncVat=$symbol.$DeliveryIncVatCost;
				
	  $orSubTo	 =	number_format($OrderTotalExVAT +  $DeliveryExVatCost,2,'.','');	
	  $vatTotal=round(($orSubTo * 1.2  - $orSubTo ),2);	
				
	  $OrderTotalIncVAT	=	number_format(($orSubTo+$vatTotal),2,'.','');	
				
				
	  $OrderTotalExVAT = $OrderTotalExVAT + $DeliveryExVatCost;
	  
	  $gtotalExVat = $symbol.$OrderTotalExVAT;
	  $gtotalIncVat=$symbol.$OrderTotalIncVAT;
			
			
			$bill_rc=$res['BillingCompanyName'];
			$del_rc=$res['DeliveryCompanyName'];
			$email = $res['Billingemail'];
	
	  $strINTemplate   = array("[WEBROOT]","[FirstName]", "[OrderNumber]", "[OrderDate]", "[OrderTime]", "[PaymentMethod]",
	  "[BillingTitle]", "[BillingFirstName]", "[BillingLastName]",
	  "[BillingCompanyName]", "[BillingAddress1]", "[BillingAddress2]", "[BillingTownCity]", "[BillingCountyState]", 
	  "[BillingPostcode]", "[BillingCountry]", "[Billingtelephone]", "[BillingMobile]", "[Billingfax]", "[EmailAddress]", 
	  "[DeliveryTitle]", "[DeliveryFirstName]", "[DeliveryLastName]" ,"[DeliveryCompanyName]", "[DeliveryAddress1]", 
	  "[DeliveryAddress2]", "[DeliveryTownCity]", "[DeliveryCountyState]", "[DeliveryPostcode]", "[DeliveryCountry]", 
	  "[ProductCode]", "[ProductName]", "[Quantity]", "[PriceExVat]", "[PriceIncVat]", "[SubTotalExVat]", "[SubTotalIncVat]", 
	  "[OrderSubTotal]", "[DeliveryOption]", "[DeliveryExVatCost]","[DeliveryIncVatCost]", "[OrderTotalExVAT]",
	  "[OrderTotalIncVAT]", "[OrderItems]" ,"[Currency]", "[Packaging]","[incvat]","[exvat]","[deliveryexvat]",
	  "[deliveryincvat]","[deliveryoption]","[gtotalExvat]","[gtotalIncvat]","[paymentMethods]","[styleBillingConpnay]",
	  "[styleDeliveryConpnay]","[vatprice]","[pamentOrder]","[weborder]","[BillingResCom]","[DeliveryResCom]","[voucherDiscount]","[PONUMBER]","[VIEWLINK]","[customer_message]","[vatType]","[vatVals]","[DeliveryText]");
  
  		$webroot = base_url(). "theme/";
        //----------------------------------------------------------------------------------------------
                $qry1 = "select `UserID` from `orderdetails` where `OrderNumber` = '".$OrderNumber."'";
                $exe1 = $this->db->query($qry1)->row_array();
			      
                $qry2 = "select * from `customers` where `UserID` = '".$exe1['UserID']."'";
			     
                $exe2 = $this->db->query($qry2)->row_Array();
               
	  //-----------------------------------------------------------------------------------------------                

       	//
//		     	$gtotalIncVat = number_format($OrderTotalIncVAT - $voucherDiscount,2,'.','');
//		       
//			    if($res['vat_exempt']=='yes'){
//				  $gtotalIncVat  = number_format($gtotalIncVat / 1.2,2,'.','');	
//				  $vatTotal=0.00;
//				  $vatType = 'VAT Exempt';
//			    }else{
//			     $vatType = 'VAT @20%';
//			     $vatTotal =  $symbol.number_format($vatTotal*$exchange_rate,2);			
//			    }	
			     
				 $gtotalIncVat = round($OrderTotalIncVAT,2);				 
				 if($res['vat_exempt']=='yes'){
					$gtotalIncVat  = round($OrderTotalIncVAT - $vatTotal,2);	
					$vatType = 'VAT Exempt';
				  }else{
					$vatType = 'VAT @20%';
				  }	
								 
				  $vatVals = $symbol.number_format($vatTotal * $exchange_rate,2);
  
  
			     //$vatVals = $vatTotal;
			     
			     
			     
		         $DeliveryExVatCost = number_format($DeliveryExVatCost*$exchange_rate,2);
		         $gtotalExVat  = $symbol.number_format($OrderTotalExVAT*$exchange_rate,2);
		         $gtotalIncVat = $symbol.number_format($gtotalIncVat*$exchange_rate,2);
		         
		        
		
		 /*--------------------------Voucher Code--------------------*/

     
	  $strInDB  = array($webroot,$BillingFirstName, $OrderNumber, $OrderDate, $OrderTime, $PaymentMethod, $BillingTitle,
	  $BillingFirstName, $BillingLastName, 
	  $BillingCompanyName, $BillingAddress1, $BillingAddress2, $BillingTownCity, $BillingCountyState, 
	  $BillingPostcode, $BillingCountry, $Billingtelephone, $BillingMobile1, $Billingfax, $EmailAddress, 
	  $DeliveryTitle, $DeliveryFirstName, $DeliveryLastName,$exe2['DeliveryCompanyName'], $DeliveryAddress1, 
	  $DeliveryAddress2, $DeliveryTownCity, $DeliveryCountyState, $DeliveryPostcode, $DeliveryCountry, 
	  $ManufacturerId, $ProductName, $Quantity, $PriceExVat, $PriceIncVat, $SubTotalExVat, $SubTotalIncVat, 
	  '', $DeliveryOption, $symbol.$DeliveryExVatCost,$DeliveryIncVatCost, $OrderTotalExVAT, 
	  $OrderTotalIncVAT, $rows,$symbol, '',$exvatSubtotalIncVat,$exvatSubtotalExVat,$deliveryExVat,$deliveryIncVat,
	  $DeliveryOption,$gtotalExVat,$gtotalIncVat,$PaymentMethod,$styleBillingCompnay,$styleDeliveryCompany,$vatTotal,
	  $pamentOrder,$websiteOrders,$bill_rc,$del_rc,$voucher_code,$PONUMBER,$viewlink,$customer_message,$vatType,$vatVals,$DeliveryText);
	  
	  $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
   //echo '<pre>'; print_r($newPhrase); 
    
   
    
    
    $this->load->library('email');
    $this->email->initialize(array('mailtype' =>'html'));
    $this->email->subject($em_sub);
    $this->email->from('customercare@aalabels.com', 'AALABELS');
    $this->email->to($EmailAddress); 
    //$this->email->to('order.aalabels@gmail.com'); 
    //$this->email->to('umair.aalabels@gmail.com'); 
	$this->email->bcc('customercare@aalabels.com','order.aalabels@gmail.com'); 
    $this->email->message($newPhrase);
    
       if(isset($referertype) && $referertype=="direct"){}else{
         if($res['OrderStatus']== 2 || $res['OrderStatus']==32){
           $res['OrderStatus'] = $this->check_printable_order($OrderNumber, $res['OrderStatus']);
         }
       }  
       
       
         
    if($this->email->send()){
      return 'send';
    
    }else{
      return 'no_send';
    }
			
   
		
  }
	
	function check_printable_order($ordernumber, $OrderStatus=NULL){
		//$CI =& get_instance(); 
		$query = $this->db->query(" select count(*) as total from orderdetails where OrderNumber LIKE '".$ordernumber."' AND Printing LIKE 'Y' AND regmark = 'N' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels' ");	
				$row = $query->row_array();
				if($row['total'] > 0){
					$this->db->update('orders', array('OrderStatus'=>55), array('OrderNumber'=>$ordernumber));
					$OrderStatus =  55;
				}
				return $OrderStatus;
	}
	
	
	 public function fetch_order_namestatus($id) {
        $query = $this->db->get_where('dropshipstatusmanager', array('StatusID' => $id));
        return $query->result();
    }

     public function updateBilling($id)
     {  
        if($_POST){
            $BEmail = $this->input->post('BEmail');
            $BFirstName = $this->input->post('FirstName');
            $BLastname = $this->input->post('Lastname');
            $BAddress1 = $this->input->post('Address1');
            $BAddress2 = $this->input->post('Address2');
            $BState = $this->input->post('CountyState');
            $BCity = $this->input->post('TownCity');
            $BPcode = $this->input->post('pcode');
            $BCountry = $this->input->post('bill_country');
            $BTelephone = $this->input->post('Telephone');
            $BMobile = $this->input->post('Mobile');
            $company=$this->input->post('Company');
            $pur_ord=$this->input->post('pur_ord');
            $data = array( 
                'Billingemail' => $BEmail,
                'BillingFirstName' => $BFirstName,
                'BillingLastName' => $BLastname,
                'BillingAddress1' => $BAddress1,
                'BillingAddress2' => $BAddress2,
                'BillingCountyState' => $BState,
                'BillingTownCity' =>$BCity,
                'BillingCountry' => $BCountry,
                'BillingPostcode' =>$BPcode,
                'BillingTelephone' => $BTelephone,
                'BillingMobile'=> $BMobile,
                'BillingCompanyName'=>$company,
                 'PurchaseOrderNumber' => $pur_ord
            );
            
            
            
            $this->db->where('OrderID',$id);
            $this->db->update('orders', $data);
            return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
       } 
    }  

    public function updateDelivery($id)
    { 
        if($_POST){
            $DEmail = $this->input->post('DEmail');
            $DFirstName = $this->input->post('DFirstName');
            $DLastname = $this->input->post('DLastname');
            $DAddress1 = $this->input->post('DAddress1');
            $DAddress2 = $this->input->post('DAddress2');
            $DState = $this->input->post('DCountyState');
            $DCity = $this->input->post('DTownCity');
            $DPcode = $this->input->post('Dpcode');
            $DCountry = $this->input->post('Dbill_country');
            $DTelephone = $this->input->post('DTelephone');
            $DMobile = $this->input->post('DMobile');
            $Dcompany=$this->input->post('DCompany');
            $data = array( 
                'Deliveryemail' => $DEmail,
                'DeliveryFirstName' => $DFirstName,
                'DeliveryLastName' => $DLastname,
                'DeliveryAddress1' => $DAddress1,
                'DeliveryAddress2' => $DAddress2,
                'DeliveryCountyState' => $DState,
                'DeliveryTownCity' =>$DCity,
                'DeliveryCountry' => $DCountry,
                'DeliveryPostcode' =>$DPcode,
                'Deliverytelephone' => $DTelephone,
                'DeliveryMobile'=> $DMobile,
                'DeliveryCompanyName'=>$Dcompany
            );
            $this->db->where('OrderID',$id);
            $this->db->update('orders', $data);
            return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        } 
    }  
    
    function Printed_desc($wound,$Print_Type,$ProductCategoryName,$orientation,$FinishType){

        if($wound=='Y' || $wound=='Inside'){ $wound_opt ='Inside Wound';}else{ $wound_opt ='Outside Wound';}
         $labeltype = $this->home_model->get_printing_service_name($Print_Type);
          $productname1  = explode("-",$ProductCategoryName);
          $productname1[1] = str_replace("(","",$productname1[1]);
          $productname1[1] = str_replace(")","",$productname1[1]);
          $productname1[0] = str_replace("rolls labels","",$productname1[0]);
          $productname1[0] = str_replace("roll labels","",$productname1[0]);
          $productname1[0] = str_replace("Roll Labels","",$productname1[0]);
    
         $productname1  = "Printed Labels on Rolls - ".str_replace("roll label","",$productname1[0]).' - '.$productname1[1];
         $completeName = ucfirst($productname1).' '.$wound_opt.' - Orientation '.$orientation.', ';
    
          if($FinishType == 'No Finish'){ $labelsfinish = ' With Label finish: None ';}
          else{  $labelsfinish = ' With Label finish : '.$FinishType; }
          $completeName.= $labeltype.' '.$labelsfinish;
          return $completeName;
     
        
    }

   /*function get_db_column($table, $column, $key, $value){
        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '".$value."' LIMIT 1 ")->row_array();
        return (isset($row[$column]) and $row[$column]!='')?$row[$column]:'';
    }*/


    function adjust_stock_level($serial,$ordernumber){
        $stock = $this->db->query("select * from stock_produced where serial_no = $serial")->result();

        foreach($stock as $row){
            $barcode = $this->db->query("select * from stock where barcode LIKE '".$row->barcode."'")->row_array();
            if($row->dispatch==1){
                $newqty = $barcode['qty'] + $row->qty;
                $newalloc = $barcode['allocated'] - $row->qty;
                $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
            }else{
                $newqty = $barcode['qty'] + $row->qty;
                $newalloc = $barcode['allocated'] - $row->qty;
                $array = (array('qty'=>$newqty,'allocated'=>$newalloc));
            }

            $this->db->where('barcode',$row->barcode);
            $this->db->update('stock',$array);
        }
        $where = "serial_no = '$serial'";
        $this->db->where($where);
        $this->db->delete('stock_produced');

        $this->db->where('SerialNumber',$serial);
        //$this->db->update('orderdetails',array('ProductionStatus'=>1,'is_stock'=>2));
        $this->db->update('orderdetails',array('ProductionStatus'=>1,'is_stock'=>5)); //is_stock = 0; then it will be able to get in pick pack again

        $qry = $this->db->query("select count(*) as total from orderdetails where OrderNumber LIKE  '".$ordernumber."' and is_stock = 1 ")->row_array();


        $picking = ($qry['total']==0)?0:1;
        $this->db->where('OrderNumber',$ordernumber);
        $this->db->update('orders',array('OrderStatus'=>32,'picking'=>$picking,'picking_status'=>2));

        //$this->add_logs('removed_stock',$stock->manufactureid,'',$ordernumber,$serial);
        //echo 'updated';
    }

    function add_logs($case, $parameter1, $parameter2,$OrderNumber, $serail_number = NULL){
        $extra_info = '';
        $linedetails = $this->db->query("select * from orderdetails where SerialNumber = $serail_number")->row_array();
        $ManufactureID = $linedetails['ManufactureID'];

        if($case == 'diecode_changed'){
            $message = $parameter1. " Changed to ".$parameter2;
        }
        else if($case == 'quantity_changed'){
            $message = $ManufactureID."Roll Quantity Changed From <b> ".$parameter1." </b> to <b> ".$parameter2." </b>";
        }
        else if($case == 'labels_changed'){
            $message = $ManufactureID." Labels Quantity Changed From <b> ".$parameter1." </b> to <b> ".$parameter2." </b>";
        }
        else if($case == 'Delivery_changed'){
            $message = "Order Delivery Service has Changed From <b> ".$parameter1." </b> to <b> ".$parameter2." </b>";
        }
        else if($case == 'line_changed'){
            $message = $ManufactureID." Changed From <b>".$parameter1."</b> to <b>".$parameter2."</b>";
        }
        else if($case == 'print_charges'){
            $message = $ManufactureID." Changed to <b>".$parameter1."</b>";
        }
        else if($case == 'print_delete'){
            $message = $ManufactureID." changed from Printed to Plain";
        }
        else if($case == 'order_total'){
            $message = "Order Total updated to ".$parameter2;
        }
        else if($case == 'line_updated'){
            $message = "Line information updated to ".$parameter1;
            $extra_info = $parameter1;
        }
        else if($case == 'removed_stock'){
            $message = $ManufactureID." has been removed from stock and stock is adjusted, Order status Changed to Pending Production.";

        }else if($case == 'line_deleted'){
            $message = $ManufactureID." has been deleted from this order.";
        }

        $this->add_activity($message,$OrderNumber,$serail_number,$extra_info);

    }
    public function add_activity($message,$OrderNumber,$serail_number,$extra_info){
        $operator_name = $this->session->userdata('UserName');
        $time = date('Y-m-d H:i:s');
        $options = array(
            'operator_name'=>$operator_name,
            'message'=>$message,
            'datetime'=>$time,
            'order_number'=>$OrderNumber,
            'serial_number'=>$serail_number,
            'extra_info'=>$extra_info
        );
        $this->db->insert('order_edit_logs',$options);
    }


    public function updateIntoQuotatonDetailTableNew($params){
        $this->db->where('SerialNumber',$_POST['serialNumber']);
        $this->db->set('Print_Qty', $params['statics']->count);
        $this->db->set('labels', $params['statics']->totalLabels);
        $this->db->update('orderdetails');
        return true;
    }
    
     public function updateIntoOrderDetailTableNew($params){
        $this->db->where('SerialNumber',$_POST['serialNumber']);
        $this->db->set('Print_Qty', $params['statics']->count);
        $this->db->set('labels', $params['statics']->totalLabels);
        $this->db->update('orderdetails');
        return true;
    }
    
    public function countArtworkStatusNew($cartId, $artworkID){
        return $this->db->select("count(*) as count,sum(labels) as totalLabels , sum(qty) as totalQuantity")
            ->from('integrated_attachments as at')
            ->where('CartID',$cartId)
            ->get()->result();
    }




    /****************************************************/
    /***********LABEL EMBELLISHMENT TASK START***********/
    /****************************************************/

    function addPrintingPreferences($data)
    {
        if (!empty($data)) {
            $data['Domain'] = "AA";
            $count = $this->db->where('sessionID', $this->shopping_model->sessionid())->get('printing_preferences')->num_rows();
            if ($count == 0) {
                $this->db->insert('printing_preferences', $data);
            } else {

                $this->db->where('sessionID', $this->shopping_model->sessionid());
                $this->db->update('printing_preferences', $data);

            }
        }
        return true;
    }

    function get_label_embellishment_and_combinations()
    {                        //$this->db->where(array('email'=>$news['email']));


        $embellishment = array();
        $embellishment['label_embellishment'] = $this->db->get('label_embellishment')->result_array();
        $embellishment['label_embellishment_parent'] = $this->db->where('label_emb_parent_id',0)->order_by('display_priority','asc')->get('label_embellishment')->result_array();

        foreach ($embellishment['label_embellishment_parent'] as $key=> $parent){
            $child_options = $this->db->where('label_emb_parent_id',$parent['id'])->order_by('display_priority','asc')->get('label_embellishment')->result_array();
            $embellishment['label_embellishment_parent'][$key]['child_options'] = $child_options;
        }

        $embellishment['label_embellishment_cond'] = $this->db->get('label_embellishment_cond')->result_array();

        /*echo "<pre>";
        print_r($embellishment);
        die;*/

        return $embellishment;
    }

    function get_label_embellishment_details_by_id($emb_id){
        $embellishment['label_embellishment_details'] = $this->db->where('id',$emb_id)->get('label_embellishment')->row_array();
        return $embellishment;
    }


    function material_load_preferences($session_id)
    {
        $preferences = $remove = array();
        $preferences = $this->db->limit(1)
            ->where('sessionID', $session_id)
            ->where('Domain', 'AA')
            ->order_by('updated_on', 'DESC')
            ->get('printing_preferences')
            ->row_array();

        if (!empty($preferences)) {
            /*if ( (($preferences['available_in'] == "A4") || ($preferences['available_in'] == "A3")) && ($preferences['material_a4'] == '' || $preferences['material_a4'] == NULL || $preferences['color_a4'] == '' || $preferences['color_a4'] == NULL || $preferences['adhesive_a4'] == '' || $preferences['adhesive_a4'] == NULL))
            {
                $remove = array(
                    'productcode_a4' => NULL
                );

                $this->db->where('sessionID', $session_id);
                $this->db->update('printing_preferences', $remove);
                $preferences = array_merge($preferences, $remove);
            }

            if ($preferences['available_in'] == "Roll" && ($preferences['material_roll'] == '' || $preferences['material_roll'] == NULL || $preferences['color_roll'] == '' || $preferences['color_roll'] == NULL || $preferences['adhesive_roll'] == '' || $preferences['adhesive_roll'] == NULL || $preferences['finish_roll'] == '' || $preferences['finish_roll'] == NULL))
            {
                $remove = array(
                    'available_in' => $preferences['available_in']
                );

                $this->db->where('sessionID', $session_id);
                $this->db->update('printing_preferences', $remove);
                $preferences = array_merge($preferences, $remove);
            }

            if (strpos($preferences['selected_size'], ",") === false and $preferences['available_in'] != "both") {
                if ($preferences['selected_size'][0] == "c") {
                    //remove a4 options if the category is changed to only a4
                    $remove = array(
                        'labels_a4' => NULL,
                        'digital_proccess_a4' => NULL,
                        'color_a4' => NULL,
                        'adhesive_a4' => NULL,
                        'material_a4' => NULL,
                        'productcode_a4' => NULL,
                        'categorycode_a4' => NULL,
                    );

                    $this->db->where('sessionID', $session_id);
                    $this->db->update('printing_preferences', $remove);
                } else if ($preferences['selected_size'][0] == "T") {
                    //remove roll options if the category is changed to only roll
                    $remove = array(
                        'wound_roll' => NULL,
                        'labels_roll' => NULL,
                        'orientation' => NULL,
                        'coresize' => NULL,
                        'finish_roll' => NULL,
                        'digital_proccess_roll' => NULL,
                        'color_roll' => NULL,
                        'adhesive_roll' => NULL,
                        'material_roll' => NULL,
                        'productcode_roll' => NULL,
                        'categorycode_roll' => NULL,
                    );
                    $this->db->where('sessionID', $session_id);
                    $this->db->update('printing_preferences', $remove);
                }
                $preferences = array_merge($preferences, $remove);
            }*/
            //echo"<pre>";print_r($preferences);echo"</pre>";exit;
            return $preferences;
        }
        return false;
    }


    function get_db_column($table, $column, $key, $value)
    {
        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '" . $value . "' LIMIT 1 ")->row_array();
        return (isset($row[$column]) and $row[$column] != '') ? $row[$column] : '';
    }

    function getProductData($manu_id)
    {
        $query = $this->db->query("SELECT * FROM `products` WHERE ManufactureID LIKE '%$manu_id%' ");
        $result = $query->result();
        return $result;
    }

    function getCustomDieData()
    {
        $query = $this->db->query("SELECT * FROM `products` WHERE ProductID = 0 ");
        $result = $query->result();
        return $result;
    }

    function get_digital_printing_process($type)
    {
        return $this->db->query(" Select * from digital_printing_process WHERE status = 'active' AND (type LIKE '" . $type . "' OR type LIKE 'both')  order by display_priority asc")->result();
    }

    function roll_core_sizes_finder($catid, $menuid)
    {

        //$ManufactureID = substr($menuid,0,-1);
        $query = $this->db->query("Select * from categorycore INNER JOIN rollcore ON rollcore.CoreId =categorycore.CoreId 
		where categorycore.CategoryId='" . $catid . "' and categorycore.Active='Y' ");
        $result = $query->result();
        $select = '';
        foreach ($result as $row) {
            $productId = $this->getProductID($menuid . str_replace("R", "", $row->CoreId));
            $coresize = preg_replace("/Core size/", "", $row->CoreSize);
            $select .= '<option  value="' . $productId . '">' . $coresize . '</option>';
        }
        return $select;


    }

    function roll_core_sizes($catid, $coreid = NULL)
    {

        $query = $this->db->query("Select * from categorycore INNER JOIN rollcore ON rollcore.CoreId =categorycore.CoreId 
		where categorycore.CategoryId='" . $catid . "' and categorycore.Active='Y' ");
        $result = $query->result();

        $select = '';
        foreach ($result as $row) {
            $coresize = preg_replace("/Core size/", "", $row->CoreSize);
            if ($coreid == $row->CoreId) {
                $selecetd = 'selected="selected"';
            } else {
                $selecetd = '';
            }
            $select .= '<option  ' . $selecetd . ' value="' . $row->CoreId . '">' . $coresize . '</option>';
        }
        return $select;
    }

    function category_shapes($condition)
    {
        $shapes = $this->db->query("SELECT DISTINCT(c.Shape) AS Shapes from category c , products p 
		WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND " . $condition);
        return $shapes->result();
    }
    /***********label finder new changes*************/
    function genrate_shapes($list, $selected = NULL)
    {
        $category = $this->input->post('category');
        $html = '';
        foreach ($list as $row) {
            if (preg_match("/single/is", $category)) {
                $class = 'single';
            } else if (preg_match("/double/is", $category)) {
                $class = 'double';
            } else if (preg_match("/triple/is", $category)) {
                $class = 'triple';
            } else {
                $class = strtolower($row->Shapes);
            }
            $selected = ($selected == "Anti-tamper") ? "Anti-Tamper" : $selected;
            if ($selected == $row->Shapes) {
                $class = $class . ' active';
            }

            if (preg_match("/rectangle/is", $row->Shapes)) {
                $tooltip = 'RECTANGULAR LABELS';
            } else if (preg_match("/triangle/is", $row->Shapes)) {
                $tooltip = 'TRIANGULAR LABELS';
            } else if (preg_match("/tamper/is", $row->Shapes)) {
                $tooltip = 'TAMPER EVIDENT LABELS';
            } else {
                $tooltip = strtoupper($row->Shapes) . '  LABELS';
            }
            $html .= '<button type="button" class="btn_shape ' . $class . '" data-val="' . $row->Shapes . '"';
            $html .= ' data-toggle="tooltip" data-placement="top"  title="' . $tooltip . '"></button> ';
        }
        return $html;
    }

    function labelsfinder_field_list($field, $condition)
    {
        $qry = "SELECT $field from products p , category  c where SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID 
					AND  $field != '' and (p.Activate ='Y' or p.Activate ='y') AND $condition group by $field order by $field ASC";
        $query = $this->db->query($qry);
        $result = $query->result();
        return $result;
    }

    function make_option_with_tooltip($list, $field, $name, $selec = NULL)
    {

        $tooltip = '';

        if ($field == 'ColourMaterial_upd') {
            $filter = 'material';
        } else if ($field == 'Adhesive') {
            $filter = 'adhesive';
        } else {
            $filter = 'color';
        }
        $option = '';
        if (count($list) > 1) {
            $option = '<li class=""><a data-value="" data-id="' . $filter . '">' . $name . '</a></li>';
        }
        $class = '';


        if ($field == 'Material1') {
            $class = 'col-sm-6 col-xs-12';
            $option = '';
        }

        foreach ($list as $a_row) {
            $selected = '';
            if ($a_row->$field == $selec) {
                $selected = ' active ';
            }

            $option .= '<li class="' . $class . '">';
            $tooltip = $this->home_model->get_db_column('material_tooltip_info', 'tooltip_info', 'material_name', $a_row->$field);
            $option .= '<a data-id="' . $filter . '" data-value="' . $a_row->$field . '" data-toggle="tooltip-material" data-trigger="hover" data-placement="right" title="' . $tooltip . '">' . ucfirst($a_row->$field) . '</a></li>';

        }

        if ($field == 'Material1') {
            $option .= '<li class="' . $class . '"><a class="orange" data-value="" data-id="' . $filter . '">Reset colour filter</a></li>';
        }

        return $option;
    }

    function make_html_option($list, $field, $name, $selec = NULL)
    {

        $page = $this->input->post('page');
        $text = '';
        $option = '';
        $value = '';
        if ($field == 'LabelsPerSheet') {
            $text = ' Labels per sheet';
        }
        if (count($list) == 1) {
            $option = '<option value="" > ' . $name . ' </option>';
            foreach ($list as $a_row) {
                $selected = '';
                if ($a_row->$field == $selec) {
                    $selected = 'selected="selected"';
                }

                $value = $a_row->$field;
                if ($field == 'SpecText7') {
                    $category = $this->input->post('category');
                    if (preg_match("/Roll/i", $category)) {
                        $category = 'Roll Labels';
                    }
                    $compatibility = $this->check_compatibility($a_row->$field, $category);
                    $value = $compatibility . ' Compatible';
                }
                $option .= '<option  ' . $selected . '  value="' . $a_row->$field . '" >' . $value . ' ' . $text . '</option>';
            }
        } else {
            $option = '<option value="" > ' . $name . ' </option>';
            foreach ($list as $a_row) {
                $selected = '';
                if ($a_row->$field == $selec) {
                    $selected = 'selected="selected"';
                }
                $value = $a_row->$field;

                if ($field == 'SpecText7') {
                    $category = $this->input->post('category');
                    if (preg_match("/Roll/i", $category)) {
                        $category = 'Roll Labels';
                    }
                    $compatibility = $this->check_compatibility($a_row->$field, $category);
                    $value = $compatibility . ' Compatible';
                }
                $option .= '<option value="' . $a_row->$field . '" ' . $selected . '>' . ucfirst($value) . ' ' . $text . '</option>';
            }
        }
        if (isset($page) and $page != 'index') {
            $option .= '<option value="" > Reset Selection </option>';
        }
        return $option;
    }
    function insert_preferences($data)
    {
        if (!empty($data)) {
            $data['Domain'] = "AA";
            $count = $this->db->where('sessionID', $this->shopping_model->sessionid())->get('printing_preferences')->num_rows();
            if ($count == 0) {
                $this->db->insert('printing_preferences', $data);
            } else {
                //$this->db->where('sessionID',$data['sessionID']);

                if(!isset($data['orientation'] ) )
                {

                    $data['orientation'] = "orientation1";
                }

                $this->db->where('sessionID', $this->shopping_model->sessionid());
                $this->db->update('printing_preferences', $data);
            }
        }
        return true;
    }



    function calculate_printed_sheets($qty, $type, $design = NULL, $brand = NULL, $manufacture = NULL)
    {

        if (isset($brand) AND trim($brand) === 'A5 Labels') {
            $areaDifferenceSQM = 0.03267;
            $marginDifferenceCost = 0.223;
        }

        $qurey = $this->db->query("SELECT * FROM `print_price` ORDER BY Quantity ASC");
        $result = $qurey->result();
        $sheets = '';
        $print_price = '';
        foreach ($result as $key => $row) {
            if ($qty <= 49) {
                $sheets = $row->Quantity;
                if ($type == 'Fullcolour') {
                    $print_price = $row->Fullcolour;
                } else {
                    $print_price = $row->Mono;
                }
                $free_artwork = $row->Free;

                break;
            } else if ($qty == $row->Quantity) {
                $sheets = $row->Quantity;
                if ($type == 'Fullcolour') {
                    $print_price = $row->Fullcolour;
                } else {
                    $print_price = $row->Mono;
                }
                $free_artwork = $row->Free;
                break;
            } else if (($qty > $row->Quantity and isset($result[$key + 1]->Quantity) and $qty < $result[$key + 1]->Quantity)) {
                $sheets = $result[$key + 1]->Quantity;
                if ($type == 'Fullcolour') {
                    $print_price = $result[$key + 1]->Fullcolour;
                } else {
                    $print_price = $result[$key + 1]->Mono;
                }
                $free_artwork = $result[$key + 1]->Free;
            } else if ($qty >= 40000) {
                $sheets = $row->Quantity;
                if ($type == 'Fullcolour') {
                    $print_price = $row->Fullcolour;
                } else {
                    $print_price = $row->Mono;
                }
                $free_artwork = $row->Free;
            }
        }

        $totalSQM = $areaDifferenceSQM * $qty;
        $marginCost = $totalSQM * $marginDifferenceCost;
        $marginCost = 0; //Bypass a5 price
        $print_price = ($qty * $print_price) - $marginCost;

        if (isset($manufacture) and $manufacture != '') {
            $labels = $this->home_model->get_db_column('products', 'LabelsPerSheet', 'ManufactureID', $manufacture);
            $condition = "   max_labels >= " . $labels . " AND  min_labels  <= " . $labels;
            $row = $this->db->query("SELECT percentage FROM `a4_printing_discounts` where   $condition LIMIT 1")->row_array();
            if (isset($row['percentage']) and $row['percentage'] > 0) {
                //$percentage = 1+($row['percentage']/100);
                //$print_price = $print_price*$percentage;

                $percentage = (100 - $row['percentage']) / 100;
                $print_price = $print_price / $percentage;
            }
        }
        $design_price = 0;

        if (isset($design) and $design > $free_artwork) {
            $design_price = ($design - $free_artwork) * 5;
        }

        /************* Prices Uplift by 6% Yearly ***********************************/
        $print_price = $this->check_price_uplift($print_price);
        $design_price = $this->check_price_uplift($design_price);
        /**********************************    **************************************/

        /********** 50% disocunt prices on printed A4 Labels ***********/
        if (preg_match("/A3 Label/is", $brand) || preg_match("/A5 Labels/is", $brand) || preg_match("/SRA3 Label/is", $brand) || preg_match("/A4 Labels/is", $brand)) {
            $print_price = $print_price / 2;
            //Bypass a5 price
            if (preg_match("/A5 Labels/is", $brand)) {
                $print_price = $print_price / 2;
            }
        }

        /********** 50% disocunt prices on printed A4 Labels ***********/
        $print_price = number_format(($print_price), 2, '.', '');
        $design_price = number_format(($design_price), 2, '.', '');

        return array('price' => $print_price, 'desginprice' => $design_price, 'artworks' => $free_artwork);
    }





    function upload_images($field_name, $folder = NULL)
    {

        $config['upload_path'] = PATH . $folder;
        $config['allowed_types'] = 'pdf|png|jpg|jpeg|gif|eps';
        $config['max_size'] = '10000';
        $config['max_width'] = '10240';
        $config['max_height'] = '7680';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            //echo $this->upload->display_errors();die();
            return "error";
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data['upload_data']['file_name'];

        }

    }


    function additional_charges_rolls($rolls)
    {
        if ($rolls <= 3) {
            $per_roll = 1.50;
        } else if ($rolls > 3 and $rolls <= 10) {
            $per_roll = 1.35;
        } else if ($rolls > 10 and $rolls <= 25) {
            $per_roll = 1.20;
        } else if ($rolls > 25 and $rolls <= 50) {
            $per_roll = 1.05;
        } else if ($rolls > 50 and $rolls <= 100) {
            $per_roll = 0.90;
        } else if ($rolls > 100 and $rolls <= 200) {
            $per_roll = 0.75;
        } else if ($rolls > 200) {
            $per_roll = 0.60;
        }

        $price = $per_roll * $rolls;
        /************* Prices Uplift by 6% Yearly **************/
        $price = $this->check_price_uplift($price);
        /*******************************************************/
        return $price;
    }

    function check_price_uplift($total_price)
    {
        $total_price = $total_price / 0.94; // 6% increment yearly march 2018
        return $total_price;
    }

    function sessionid()
    {
        return $this->session->userdata('session_id');

        $oldsessid = $this->session->userdata('session_id');
        $newsessid = $this->session->userdata('newsession_id');

        if ($newsessid == "") {
            $newsessid = $this->session->set_userdata('newsession_id', $oldsessid);
        }
        return $newsessid;


    }

    function currecy_converter($price, $vat = NULL)
    {

        $rate = $this->get_exchange_rate(currency);

        if (isset($rate) and $rate > 0) {
            $price = $price * $rate;
        }
        if ($vat == 'yes' and vatoption == 'Inc') {
            $price = $price * 1.2;
        }
        return number_format(round($price, 2), 2, '.', '');
    }






    function insert_check($productID, $SID)
    {
        // print_r('111'); exit;
        $query = "SELECT COUNT(*) as count From browsing_history WHERE productID = '$productID' and SessionID = '$SID'";
        $result = $this->db->query($query)->row();

        if ($result->count) {
            return true;
        } else {
            return false;
        }
    }


    // NAFEES CART PAGE EDIT STARTS
        public function getCartDataAgainstId( $temp_basket_id ) {
            if( isset($temp_basket_id) && $temp_basket_id != '' ) {
                    $q = $this->db->query("SELECT * FROM temporaryshoppingbasket tsb INNER JOIN products prd on tsb.ProductID = prd.ProductID AND tsb.ID = '".$temp_basket_id."'   ");
                    return $q->result_array()[0];
            }
        }
        
        public function Get_IA_Data($cartID) {
            $uploaded_lines = $this->db->query("select * from integrated_attachments where CartID='".$cartID."'
                AND file != '' AND file != 'No File Required For Artwork To Follow' ")->result_array();
            return $uploaded_lines;
        }

        public function Get_IA_All_Data($cartID) {
            $uploaded_lines = $this->db->query("select * from integrated_attachments where CartID='".$cartID."' ")->result_array();
            return $uploaded_lines;
        }

    


    // NAFEES CART PAGE EDIT ENDS




    function update_flexible_dies_mat($data)
    {
        if (!empty($data)) {
            $data['Domain'] = "AA";
            $count = $this->db->where('sessionID', $this->shopping_model->sessionid())->get('printing_preferences')->num_rows();
            if ($count == 0) {
                $this->db->insert('printing_preferences', $data);
            } else {

                $this->db->where('sessionID', $this->shopping_model->sessionid());
                $this->db->update('printing_preferences', $data);

            }
        }
        return true;
    }


    /***************************************************/
    /***********LABEL EMBELLISHMENT TASK ENDS***********/
    /***************************************************/



}