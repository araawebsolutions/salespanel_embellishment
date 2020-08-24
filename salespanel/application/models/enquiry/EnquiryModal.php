<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EnquiryModal extends CI_Model
{
    public function getAllEnquires(){

       return  $this->datatables->select('customlabelsquotes.QuoteNumber')
            ->select('customlabelsnumber.id')


            ->select('
				customlabelsdetails.Adhesive,
				customlabelsdetails.TotalLabelsReq,
				customlabelsquotes.BillingFirstName,
				customlabelsquotes.BillingTelephone,
				customlabelsquotes.Billingemail')

            ->select('Case WHEN customlabelsquotes.Source = "Website"  THEN   "Website"
					WHEN customlabelsquotes.Source ="Checkout"  THEN   "Website–Checkout Page" 
					WHEN customlabelsquotes.Source ="Contactus"  THEN   "Website-Contact US "
					WHEN customlabelsquotes.Source ="Custom Label Printing"  THEN   "Website-Custom Printing "
					WHEN customlabelsquotes.Source ="Label Printing"  THEN   "Website-Label Printing "
					WHEN customlabelsquotes.Source ="Website-Enquiry"  THEN   "Back office–New enquiry "
					WHEN customlabelsquotes.Source =""  THEN   "Website "
					ELSE customlabelsquotes.Source END AS Source')


            ->select('customlabelsquotes.RequestStatus')

            ->select('concat(FROM_UNIXTIME(unix_timestamp(customlabelsquotes.RequestDate),"%d/%m/%Y")," &nbsp;&nbsp;",customlabelsquotes.RequestTime) as time')




            ->from('customlabelsdetails')
            ->order_by('customlabelsquotes.RequestDate DESC')
            ->join('customlabelsquotes', "customlabelsdetails.QuoteNumber = customlabelsquotes.QuoteNumber AND customlabelsquotes.Source!='M2H-Website' AND customlabelsquotes.Quote=0 ", 'INNER')
            ->join('customlabelsnumber', "customlabelsdetails.QuoteNumber = customlabelsnumber.customLabelsNumber", 'INNER')


            ->where('customlabelsquotes.QuoteNumber !=""'  );

    }

    public function getEnquiryDetail($quoteNumber){
        $this->db->select('*');
        $this->db->from('customlabelsquotes');
        $this->db->join('customlabelsfiles', "customlabelsquotes.QuoteNumber = customlabelsfiles.QuoteNumber",'LEFT');
        $this->db->join('customlabelsdetails', "customlabelsquotes.QuoteNumber = customlabelsdetails.QuoteNumber where customlabelsquotes.QuoteNumber='" . $quoteNumber . "' group by customlabelsquotes.QuoteNumber order by customlabelsquotes.RequestDate,customlabelsquotes.RequestTime Desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getShapes($catType){
        $type = $this->input->get('catt_type');
        $type = ($type == null)?$catType:$type;
        if($type=='Labels on Roll'){

            $query = "SELECT c.Shape_upd FROM products p, category c WHERE SUBSTRING_INDEX( p.CategoryID, 'R', 1 ) = c.CategoryID AND c.CategoryActive = 'Y' 
			AND c.Shape_upd != '' AND p.Price != '' AND p.ProductBrand LIKE 'Roll labels' GROUP BY c.Shape_upd ORDER BY c.Shape_upd ASC";

        }
        else if($type=='Labels on SRA3 Sheets'){

            $query = "SELECT c.Shape_upd FROM products p, category c WHERE c.CategoryID = p.CategoryID AND c.CategoryActive = 'Y' AND c.Shape_upd != ''
						  AND  p.Activate = 'Y'  AND p.Price != '' AND p.ProductBrand LIKE 'SRA3 Label' GROUP BY c.Shape_upd ORDER BY c.Shape_upd ASC";
        }
        else if($type=='Labels on A3 Sheet'){

            $query = "SELECT c.Shape_upd FROM products p, category c WHERE c.CategoryID = p.CategoryID AND c.CategoryActive = 'Y' AND 
						 c.Shape_upd != '' AND  p.Activate = 'Y'  AND p.Price != '' AND p.ProductBrand LIKE 'A3 Label' GROUP BY c.Shape_upd ORDER BY c.Shape_upd ASC";
        }
        else{
            $query = "SELECT c.Shape_upd FROM products p, category c WHERE c.CategoryID = p.CategoryID AND c.CategoryActive = 'Y' AND c.Shape_upd != '' 
					  AND ( p.Activate = 'Y' OR p.Activate = 'y' ) AND p.Price != '' AND ( p.ProductBrand NOT LIKE 'SRA3 Label' AND p.ProductBrand NOT LIKE 'A3 Label'
					  AND p.ProductBrand NOT LIKE 'Roll labels' ) GROUP BY c.Shape_upd ORDER BY c.Shape_upd ASC";

        }

        $shape = $this->db->query($query);
        $result = $shape->result();
        return $result;
    }
    public function getMaterial($category,$myShape){
        $type = $this->input->get('cat');
        $shape = $this->input->get('shape');
        $type = ($type==null)?$category:$type;
        $shape = ($shape == null)?$myShape:$shape;
        if($type=='Labels on Roll'){

            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' ) 
			AND ProductBrand LIKE 'Roll labels' AND Shape_upd LIKE '". $shape."' GROUP BY ProductName ORDER BY ProductName ASC";

        }
        else if($type=='Labels on SRA3 Sheets'){

            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' ) 
				   AND ProductBrand LIKE 'SRA3 Label' AND Shape_upd LIKE '". $shape."' GROUP BY ProductName ORDER BY ProductName ASC";


        }
        else if($type=='Labels on A3 Sheet'){

            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' ) 
				 AND ProductBrand LIKE 'A3 Label' AND Shape_upd LIKE '". $shape."' GROUP BY ProductName ORDER BY ProductName ASC";
        }
        else{
            $query = "SELECT DISTINCT (ProductName) AS name from products WHERE ProductName!='' AND ( Activate = 'Y' OR Activate = 'y' ) AND  
			   ( ProductBrand NOT LIKE 'SRA3 Label' AND ProductBrand NOT LIKE 'A3 Label' AND ProductBrand NOT LIKE 'Roll labels' ) 
			    AND Shape_upd LIKE '". $shape."' GROUP BY ProductName ORDER BY ProductName ASC";
        }

        $shape = $this->db->query($query);
        $result = $shape->result();
        return $result;
    }
	
    public function getQuoteNum() {

        $this->db->select_max('id');
        $highValue = $this->db->get('customlabelsnumber')->result();
        $highestValue = $highValue[0]->id;
        if ($highestValue) {
            $highestValue++;
            $newEntry = array('customLabelsNumber' => 'E' . $highestValue);
            // $this->db->insert('customlabelsnumber', $newEntry);
        }

        return $newEntry['customLabelsNumber'];
    }
	
	public function insertEnquires($values){
		$QuoteNumber = $values['enqno'];
		$maxQuoteNumber = $values['enqno'];

		$title = $values['title'];
		$firstname = $values['firstname'];
		$lastname = $values['lastname'];
		$addressA = $values['AddressA'];
		$addressB = $values['AddressB'];
		$email = $values['Email'];
		$postcode = $values['postcode'];
		$city = $values['City'];
		$country = $values['Country'];
		$company = $values['Company'];
		$telephone = $values['Telephone'];
		$fax = $values['Fax'];
		$Instructions = $values['Instructions'];
		$Notes = $values['operatorNotes'];
		$category = $values['category'];
		$labelQuantity = $values['labelQuantity'];
		$LabelShape = $values['Shape'];
		$labelWidth = $values['labelWidth'];
		$labelHeight = $values['labelHeight'];
		$CornerRadius = $values['CornerRadius'];
		$labelColor = $values['Color'];
		$Material = $values['Material'];
		$Adhesive = $values['Adhesive'];
		$Printed = $values['Printed'];
		$PrintType = $values['Printcolors'];
		$NoOfColors = $values['Nofcolors'];
		$Artwork = $values['Artwork'];
		

		$quoteData = 
			array('QuoteNumber' => $maxQuoteNumber,
						'category' => $category,
						'Shape' => $LabelShape,
						'RectangleWidth' => $labelWidth,
						'RectangleHight' => $labelHeight,
						'CornerRadius' => $CornerRadius,
						'Material' => $Material,
						'OtherInstruction' => $Instructions,
						'PrintingRequired' => $Printed,
						'NoOfColors' => $NoOfColors,
						'PrintType' => $PrintType,
						'Artwork'  => $Artwork,
						'TotalLabelsReq' => $labelQuantity,
						'LabelColor' => $labelColor,
						'Adhesive' => $Adhesive,
						'operatorNotes' => $Notes
					 );

		$img = (!empty($_FILES['file']['name']))?$this->uploadImages('file'):'';
		$quoteDataQuotes = array(
			'QuoteNumber' => $maxQuoteNumber,
			'RequestStatus' => '11',
			'TotalQuantity' => $labelQuantity,
			'NotesEnquiery' => $Notes,
			'MaterialReq' => $Material,
			'Billingemail' => $email,
			'BillingTitle' => $title,
			'BillingFirstName' => $firstname,
			'BillingLastName' => $lastname,
			'BillingCompanyName' => $company,
			'BillingAddress1' => $addressA,
			'BillingAddress2' => $addressB,
			'BillingTownCity' => $city,
			'BillingCountyState' => $country,
			'image'=>$img,
			'BillingPostcode' => $postcode,
			'BillingTelephone' => $telephone,
			'BillingFax' => $fax,
			'RequestTime' => date('g:i:s' ,time()) ,
			'Source' => 'Website-Enquiry',
			'RequestDate' => date("Y-m-d")
		);


		$this->db->insert('customlabelsdetails', $quoteData);
		
		$this->db->insert('customlabelsquotes', $quoteDataQuotes);
		//$this->db->insert('customlabelsnumber', $enqno);
		
		$newEntry = array('customLabelsNumber' => $maxQuoteNumber);
		$this->db->insert('customlabelsnumber', $newEntry);
		
		$log_arr = array('customlabelsdetails'=>$quoteData,'customlabelsquotes'=>$quoteDataQuotes,'customlabelsnumber'=>$newEntry);		
		$this->save_logs('add_enquiry',$log_arr);
		
		if($img=="error"){ $er = 'no'; } else if($_FILES['file']['name']!="") {$er = 'yes';} else if($_FILES['file']['name']=="") {$er ='no';}
		$this->save_logs('add_enquiry_images',array('file_exists'=>$er));
		
		return true;

	}
	
	
	function save_logs($activity,$log_arr){
		$arr = json_encode($log_arr);
		
		$arr_ins['SessionID'] = $this->session->userdata('session_id');
		$arr_ins['Activity']  = $activity;
		$arr_ins['Record'] 	  = $arr;
		$arr_ins['Website']   = 'BK';
		//$arr_ins['DateTime']  = 	strtotime(date('Y-m-d h:i:s')); 
		$this->db->insert('websitelog',$arr_ins);
	}
	
	
    function uploadImages($field_name){

        $config['upload_path'] = enquiry_path;

        //print_r($config['upload_path']);exit;

        $config['allowed_types']        = '*';
        $config['max_size']             = 1000000;
        $config['max_width']            = 1024000;
        $config['max_height']           = 7680000;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload($field_name))
        {
            //print_r($this->upload->display_errors());
					  return "error";
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            return $data['upload_data']['file_name'];
        }
			
			
    }
    
	public function updateEnquiry($QuoteNumber)
	{
		$labelQuantity = $QuoteNumber['labelQuantity'];
		$category = $QuoteNumber['category'];
		$LabelShape = $QuoteNumber['Shape'];
		$labelWidth = $QuoteNumber['labelWidth'];
		$labelHeight = $QuoteNumber['labelHeight'];
		$CornerRadius = $QuoteNumber['labelRadius'];
		$labelColor = $QuoteNumber['Color'];
		$Material = $QuoteNumber['Material'];
		$Adhesive = $QuoteNumber['Adhesive'];
		$Printed = $QuoteNumber['Printed'];
		$PrintType =(isset($QuoteNumber['Printcolors'])) ?$QuoteNumber['Printcolors']:'';
		$NoOfColors = (isset($QuoteNumber['Nofcolors']))?$QuoteNumber['Nofcolors']:'';
		$Artwork = (isset($QuoteNumber['Artwork']))?$QuoteNumber['Artwork']:'';
		$Instructions = (isset($QuoteNumber['spl_instruction']))?$QuoteNumber['spl_instruction']:'';
		//$Notes = (isset($QuoteNumber['operatorNotes']))?$QuoteNumber['operatorNotes']:'';

		$quoteData = array(
			'TotalLabelsReq' => $labelQuantity,
			'Shape' => $LabelShape,
			'RectangleWidth' => $labelWidth,
			'RectangleHight' => $labelHeight,
			'category' => $category,
			'CornerRadius' => $CornerRadius,
			'LabelColor' => $labelColor,
			'Material' => $Material,
			'Adhesive' => $Adhesive,
			'PrintingRequired' => $Printed,
			'PrintType' => $PrintType,
			'NoOfColors' => $NoOfColors,
			'Artwork'  => $Artwork,
			'OtherInstruction' => $Instructions,
			//  'operatorNotes' => $Notes
		);

		$this->db->where('QuoteNumber', $QuoteNumber['enquiry_number']);
		$this->db->update('customlabelsdetails', $quoteData);

		$log_arr = array('customlabelsdetails'=>$quoteData);		
		$this->save_logs('update_enquiry',$log_arr);
		
		return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
    public function updateEnquiryNotes($QuoteNumber)
    {
        $Notes = (isset($QuoteNumber['operatorNotes']))?$QuoteNumber['operatorNotes']:'';

        $quoteData = array(
            'operatorNotes' => $Notes
        );

        $this->db->where('QuoteNumber', $QuoteNumber['enquiry_number']);
        $this->db->update('customlabelsdetails', $quoteData);

        $log_arr = array('customlabelsdetails'=>$quoteData);
        $this->save_logs('update_enquiry',$log_arr);

        return  ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function ChangeStatus ($qno,$rqstatus)
    {

        $data = array('RequestStatus' => $rqstatus);

        if($rqstatus == 13){
            $operator = $this->db->query("select OperatorID from customlabelsquotes where QuoteNumber like '$qno' ")->row_array();
            $t_assigns = $this->db->query("select UserID, total_assigns from customers where UserID = '".$operator['OperatorID']."' ")->row_array();
            $this->db->where('UserID', $t_assigns['UserID']);
            $this->db->update('customers', array("total_assigns"=>($t_assigns['total_assigns']-1)));

            $data = array_merge($data,array('callback_status'=>2));
        }

        $this->db->where('QuoteNumber', $qno);
        $this->db->update('customlabelsquotes', $data);
			
			if($rqstatus == 11){$stat = "Required Action";}
			else if($rqstatus == 12){$stat = "Awaiting Reply";}
			else{$stat = "Completed";}
			
			
			$log_arr = array('Status'=>$stat);		
			$this->save_logs('ChangeStatus_enquiry',$log_arr);

        return  true;
    }

}