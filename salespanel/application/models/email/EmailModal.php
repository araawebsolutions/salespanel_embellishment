<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EmailModal extends CI_Model
{
    public function sendQuotationEmail($QuotationNo){

        $CI =& get_instance();
        // error_reporting(E_ALL);
        $query = $CI->db->get_where('quotations', array('QuotationNumber' => $QuotationNo));

        $res = $query->result_array();
        $res = $res[0];
        $data['OrderInfo'] = $res;
        $mailto = $res['Billingemail'];

        $language = ($res['site']=="" || $res['site']=="en")?"en":"fr";
        $getfile = base_url().'email/'.$language.'/quote-confirmation.html';
        $mailText = file_get_contents($getfile);

        $strINTemplate   = array("[FirstName]", "[quoteNumber]", "[OrderDate]", "[OrderTime]");
        $strInDB  = array($res['BillingFirstName'], $QuotationNo, date("d.m.Y",$res['QuotationDate']), date("g:i A",$res['QuotationTime']));
        $body = str_replace($strINTemplate, $strInDB, $mailText);

        //*****-----*****-----*****-----****----ATTACHMENT PDF CODE*****-----*****-----*****-----****----
        $this->quotation_pdf($QuotationNo,$language,'show');
        $file_location = "pdf/QuoteConfirmation_".$QuotationNo.".pdf";

        $mailsubject = ($language=="en")?"QUOTATION CONFIRMATION  :".$QuotationNo:"CONFIRMATION DE QUOTATION:".$QuotationNo;
        $this->load->library('email');
        $this->email->initialize(array( 'mailtype' => 'html', ));
        $this->email->subject($mailsubject);
        $this->email->from('customercare@aalabels.com','aalabels');
        $this->email->to($mailto);
        $this->email->message($body);
        $this->email->attach($file_location);
        $this->email->send();
        unlink($file_location);
        return true;
    }

    function quotation_pdf($QuotationNo,$language,$type){
        $CI =& get_instance();
        if($type=="show"){
            $page = ($language=="en")?"order_quotation/en/quoteconfirm.php":"order_quotation/fr/quoteconfirm.php"; }
        else{
            $page = ($language=="en")?"order_quotation/en/quotehide.php":"order_quotation/fr/quotehide.php";
        }

        $query = $CI->db->get_where('quotations', array('QuotationNumber' => $QuotationNo));
        $res = $query->result_array();
        $res = $res[0];
        $data['type'] = $type;
        $data['OrderInfo'] = $res;
        $data['OrderDetails'] = $this->quoteDetails($QuotationNo);
        $this->load->library('pdf');
        $this->pdf->load_view($page,$data,TRUE);
        $this->pdf->render();
        $output = $this->pdf->output();
        $file_location = "pdf/QuoteConfirmation_".$QuotationNo.".pdf";
        $filename = $file_location;
        $fp = fopen($filename, "a");
        file_put_contents($file_location,$output);
    }

    public function quoteDetails($quoteID) {

        if(empty($quoteID)){
            $quoteID = end($this->uri->segments);
        }

        $query = $this->db->get_where('quotationdetails', array('QuotationNumber' => $quoteID));
        return $query->result();
    }
    
    
    
    
    public function sendTicketEmail($TicketNo){

        $CI =& get_instance();
        // error_reporting(E_ALL);
        //$query = $CI->db->get_where('quotations', array('QuotationNumber' => $QuotationNo));
        
        $CI->db->select("t.ticket_id,od.SerialNumber,od.orderNumber,o.Billingemail,od.ManufactureID,od.ProductName,td.returnQty,td.returnUnitPrice,td.returnCurrency,o.site,t.ac_action,t.create_date,t.ticketSrNo,p.ProductBrand,t.pre_action_taken,c.CategoryImage");
        $CI->db->from("tickets as t");
        $CI->db->join("ticket_details as td","t.ticket_id=td.ticket_id");
        $CI->db->join("orderdetails as od","od.SerialNumber=td.serialNumber");
        $CI->db->join("orders as o","o.OrderNumber=td.orderNumber");
        $CI->db->join("products as p","p.ManufactureID=od.ManufactureID");
        $CI->db->join('category as c','SUBSTRING_INDEX(p.CategoryID, "R", 1 )=c.CategoryID');
        $CI->db->where("t.ticket_id",$TicketNo);
        
        $query =  $CI->db->get();
        
        $res = $query->result_array();
        //echo $CI->db->last_query();
        //echo '<pre>'; print_r($res);  echo '</pre>';
        $result = $query->result();
        $res = $res[0];
        $data['OrderInfo'] = $res;
        $mailto = $res['Billingemail'];
        

        //$language = 'fr';
        $language = ($res['site']=="" || $res['site']=="en")?"en":"fr";
        $getfile = 'https://www.aalabels.com/salespanel/email/'.$language.'/createTicket.html';
        $mailText = file_get_contents($getfile);
        
        $img_path = 'https://www.aalabels.com/theme/site/images/categoryimages/';
        //$img_path = base_url().'/theme/assets/images/categoryimages/';
        
        
	    $table=""; $i=0;
	 
        foreach($result as $row){
            $i++;
            
            
            $sym;
            if ($row->returnCurrency == "GBP"){
                $sym = '£';
            }
            else if ($row->returnCurrency == "EUR"){
                $sym = '€';
            }
            else if ($row->returnCurrency == "USD"){
                $sym = '$';
            }
            
            $syma = str_replace(' ', '', $row->returnUnitPrice);
            $deta = '<b>'.$row->ManufactureID.'</b> - '.$row->ProductName;
            
            $brand = $row->ProductBrand;
            $brand_name;
            
        
            if($brand=='A4 Labels'){
                $brand_name = 'A4Sheets';
                
            }else if($brand=='A3 Label'){
                $brand_name = 'A3Sheets';
                
            }else if($brand =='SRA3 Label'){
                $brand_name = 'SRA3Sheets';
                
            }else if($brand=='Roll Labels'){
                $brand_name = 'RollLabels';
            }
            
           
            $img_mat = '';
            if($brand_name!="RollLabels"){
				$img_mat = $img_path.$brand_name.'/'.$diecode.'.png';
			}else{
				$img_mat = $img_path.$brand_name.'/'.$diecode.'.jpg';
			}
            
			   
            $table.= '<tr>
            <td style="padding:12px 4px 12px; font-family:Arial; font-size:12px; color: #333;" align="center"><img src='.$img_mat.' style="width:60%;"></td>
            <td style="padding:12px 4px 12px; font-family:Arial; font-size:12px; color: #333;" align="left">'.$deta.'</td>
            <td style="padding:12px 4px 12px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$row->returnQty.'</td>
            <td style="padding:12px 4px 12px; font-family:Arial; font-size:12px; color: #333;" align="center">'.$sym.$syma.'</td>
            </tr>';
        }

        //$strINTemplate   = array("[FirstName]", "[quoteNumber]", "[OrderDate]", "[OrderTime]");
        //$strInDB  = array($res['BillingFirstName'], $QuotationNo, date("d.m.Y",$res['QuotationDate']), date("g:i A",$res['QuotationTime']));
        
        $strINTemplate = array("[tcket_no]","[details]","[com]","[date]");
        $strInDB       = array($res['ticketSrNo'],$table,$res['pre_action_taken'],date('d/m/Y',strtotime($res['create_date'])));
        $body          = str_replace($strINTemplate, $strInDB, $mailText);

        //*****-----*****-----*****-----****----ATTACHMENT PDF CODE*****-----*****-----*****-----****----
       
        $mailsubject = ($language=="en")?"Complaint Ticket No  :".$TicketNo:"Numéro de plainte:".$TicketNo;
        $this->load->library('email');
        $this->email->initialize(array( 'mailtype' => 'html', ));
        $this->email->subject($mailsubject);
        $this->email->from('customercare@aalabels.com','aalabels');
        $this->email->to($mailto);
       // $this->email->bcc('umair_araein@yahoo.com');
        $this->email->message($body);
        
        //print_r($body);
        //exit;
        //$this->email->send();
        
        if (!$this->email->send()){
            //echo 'Failed';echo'<br>';
            //echo $this->email->print_debugger();
        }else{      
            //echo 'Sent';
        }
        return true;
    }
}