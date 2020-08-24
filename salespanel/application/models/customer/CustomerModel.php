<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class customerModel extends CI_Model
{
  public function getAllCustomers()
  {
      return $this->datatables->select("concat(customers.BillingFirstName,' ',customers.BillingLastName) as FullName,BillingCompanyName,BillingCountry,BillingPostcode,DeliveryPostcode,concat(customers.UserEmail,'<br><b>',customers.wholesale) as cust,BillingTelephone,Active,UserID") ->from('customers');
  }

    public function getCustomers($customerId)
    {
        return  $this->db->select("*")
            ->from('customers')
            ->where('UserID',$customerId)
            ->get()->result_array();
    }

    public function getCustomerByEmail($email){
        return  $this->db->select("*")
            ->from('customers')
            ->where('UserEmail',$email)
            ->get()->row();
    }



   public function AddContact() {
       
      
    if(!empty($_POST)){
    $UserEmail = $this->input->post('UserEmail');
    $SecondaryEmail = $this->input->post('SecondaryEmail');
    $BTitle = $this->input->post('BillingTitle');
    $BFirstName = $this->input->post('FirstName');
    $BLastname = $this->input->post('Lastname');
    $BAddress1 = $this->input->post('Address1');
    $BAddress2 = $this->input->post('Address2');
    $BTownCity = $this->input->post('TownCity');
    $BCountryState = $this->input->post('CountryState');
    $BCountry = $this->input->post('bill_country');
    $Bpcode = $this->input->post('pcode');
    $BTelephone = $this->input->post('Telephone');
    $BCompany = $this->input->post('Company');
    $Bresidence = $this->input->post('BillingResCom');
    
   
    $DTitle = $this->input->post('DTitle');
    $DFirstName = $this->input->post('DFirstName');
    $DLastname = $this->input->post('DLastname');
    $DAddress1 = $this->input->post('DAddress1');
    $DAddress2 = $this->input->post('DAddress2');
    $DTownCity = $this->input->post('DTownCity');
    $DCountryState = $this->input->post('DCountryState');
    $DCountry = $this->input->post('del_country');
    $Dpcode = $this->input->post('Dpcode');
    $DTelephone = $this->input->post('DTelephone');
    $DCompany = $this->input->post('DCompany');
    $Deresidence = $this->input->post('DeliveryResCom');
    
    $Bmobile = $this->input->post('bmobile');
    $Dmobile = $this->input->post('dmobile');
    

    $Customer = array('UserEmail' => $UserEmail,
            'DeliveryEmail' => $UserEmail,
            'UserName' => $DFirstName,
            'SecondaryEmail'=>$SecondaryEmail,
            'UserPassword' => rand(10, 50),
            'RegisteredDate' => date('Y-m-d'),
            'RegisteredTime' => date('h:i:s'),
            'BillingTitle' => $BTitle,
            'BillingFirstName' => $BFirstName,
            'BillingLastName' => $BLastname,
            'BillingAddress1' => $BAddress1,
            'BillingAddress2' => $BAddress2,
            'BillingTownCity' => $BTownCity,
            'BillingCountyState' => $BCountryState,
            'BillingPostcode' => $Bpcode,
            'BillingCountry' => $BCountry,
            'BillingTelephone' => $BTelephone,
            'BillingMobile' => $Bmobile,
            'BillingCompanyName' => $BCompany,
            'BillingResCom' => $Bresidence,
            'DeliveryTitle' => $DTitle,
            'DeliveryFirstName' => $DFirstName,
            'DeliveryLastName' => $DLastname,
            'DeliveryAddress1' => $DAddress1,
            'DeliveryAddress2' => $DAddress2,
            'DeliveryTownCity' => $DTownCity,
            'DeliveryCountyState' => $DCountryState,
            'DeliveryCountry' =>$DCountry,
            'DeliveryPostcode' => $Dpcode,
            'DeliveryTelephone' => $DTelephone,
            'DeliveryMobile' => $Dmobile,
            'DeliveryCompanyName' => $DCompany,
            'DeliveryResCom' => $Deresidence,       
            'Active' =>1
        );
   }
       
  $this->db->insert('customers', $Customer); 
 
}


function newsletter($email=NULL){
  if($email!=NULL){
      $query = $this->db->query("select count(*) AS Total from email_addresses WHERE email LIKE '".$email."'");
      $query = $query->row_array();
        if($query['Total'] == 0){
          $ip_add = $this->session->userdata('ip_address');
          $this->db->insert('email_addresses',array('IPAddress'=>$ip_add,'email'=>$email)); 
        }
    }
  }


   public function updatecustomer($id)
    {  
        if($_POST){
        $UserEmail = $this->input->post('UserEmail');
        $SecondaryEmail = $this->input->post('SecondaryEmail');
        $BTitle = $this->input->post('BillingTitle');
        $BFirstName = $this->input->post('FirstName');
      
        $BLastname = $this->input->post('Lastname');
        $BAddress1 = $this->input->post('Address1');
        $BAddress2 = $this->input->post('Address2');
        $BState = $this->input->post('CountryState');
        $BCity = $this->input->post('TownCity');
        $BPcode = $this->input->post('pcode');
        $BCountry = $this->input->post('bill_country');
        $BTelephone = $this->input->post('Telephone');
        $company=$this->input->post('Company');
        $DTitle = $this->input->post('DTitle');
        $DFirstName = $this->input->post('DFirstName');
        $DLastname = $this->input->post('DLastname');
        $DAddress1 = $this->input->post('DAddress1');
        $DAddress2 = $this->input->post('DAddress2');
        $DTownCity = $this->input->post('DTownCity');
        $DCountryState = $this->input->post('DCountryState');
        $DCountry = $this->input->post('del_country');
        $Dpcode = $this->input->post('Dpcode');
        $DTelephone = $this->input->post('DTelephone');
        $DCompany = $this->input->post('DCompany');
        
        $bmobile = $this->input->post('bmobile');
        $dmobile = $this->input->post('dmobile');

        $data = array( 
            'UserEmail' => $UserEmail,
            'SecondaryEmail' => $SecondaryEmail,
            'BillingTitle' => $BTitle,
            'BillingFirstName' => $BFirstName,
            'BillingLastName' => $BLastname,
            'BillingAddress1' => $BAddress1,
            'BillingAddress2' => $BAddress2,
            'BillingCountyState' => $BState,
            'BillingTownCity' =>$BCity,
            'BillingCountry' => $BCountry,
            'BillingPostcode' =>$BPcode,
            'BillingTelephone' => $BTelephone,
            'BillingMobile' => $bmobile,
            'DeliveryMobile' => $dmobile,
            'BillingCompanyName'=>$company,
            'DeliveryTitle' => $DTitle,
            'DeliveryFirstName' => $DFirstName,
            'DeliveryLastName' => $DLastname,
            'DeliveryCompanyName' => $DCompany,
            'DeliveryAddress1' => $DAddress1,
            'DeliveryAddress2' => $DAddress2,
            'DeliveryTownCity' => $DTownCity,
            'DeliveryCountyState' => $DCountryState,
            'DeliveryCountry' =>$DCountry,
            'DeliveryPostcode' => $Dpcode,
            'DeliveryTelephone' => $DTelephone,
            
        );
       }
       
        $this->db->where('UserID',$id);
    
        $this->db->update('customers', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }


    public function updatewholesale($id){
        if($_POST){
            $vat = $this->input->post('vat_number');
            $web = $this->input->post('website');
            $m_spend= $this->input->post('monthly_spend');
            $reg_no = $this->input->post('reg_no');
            $t_name = $this->input->post('trade_name');
            $disc = $this->input->post('price_discount');
            $comp = $this->input->post('company_type');
            $desc = $this->input->post('desc');


             $value= array(
                'VATNumber' => $vat,
                'Website' => $web,
                'MonthlySpend' => $m_spend,
                'CompanyRegistrationNo' => $reg_no,
                'TradingName' => $t_name,
                 'Printed_discount' => $disc,
                'Companytype' => $comp,
                'DescriptionBusiness' => $desc
             );
        }

        $this->db->where('UserID',$id);  
        $this->db->update('customers', $value);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }
	
	public function forgotpassword($email)
    {
        $qry = $this->db->query("SELECT * FROM customers WHERE UserEmail = '".$email."'");
        $rec = $qry->num_rows();
        if($rec!=0)
        {
            $res = $qry->result_array();
            $act_code = md5(rand(0,1000).'uniquefrasehere');
            
            $activate['UserID']                 = $res[0]['UserID'];
            $activate['TokenNumber']            = $act_code;
            $activate['UserEmail']              = $email;
            $activate['TokenTime']              = time();
        
          $str_tmp = $this->db->insert_string('forgetpasswordtoken', $activate);
          $query_tmp = $this->db->query($str_tmp);
            
            if($query_tmp)
            {
                $mail_template = $this->email_template(2);
                $mailTitle = $mail_template[0]['MailTitle'];
                $mailName = $mail_template[0]['Name'];
                $from_mail = $mail_template[0]['MailFrom'];
                $mailSubject = $mail_template[0]['MailSubject'];
                $mailText = $mail_template[0]['MailBody'];
                $url = main_url.'theme/';
                $code = base64_encode($res[0]['UserID']);
                $link = 'https://www.aalabels.com/users/changepassword?token='.$act_code.'-'.$code;
                
                $strINTemplate   = array('[WEBROOT]', "[EmailAddress]", "[password]");    
                $strInDB  = array($url,$email,$link);  
                $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);
                
                $this->load->library('email');
                $this->email->from($from_mail, 'AALABELS');
                $this->email->to($email); 
                $this->email->subject($mailSubject);
                $this->email->message($newPhrase);
                $this->email->set_mailtype("html");
                if($this->email->send())
                {
                     $msg = "<p> A link has been sent to the user email address shown under the heading Account Information. Please ask the 
                                 customer to follow the instructions in the email to continue to reset their password.</p>
                             <p> Remember to advise the customer that the email may arrive in their Junk Email folder.</p>
                             <p> If not received  please inform the Development Team who will investigate and re-send if required.</p>";
                }
                else
                {
                    $msg = "not found";
                }
            }
        }
        else
        {
            $msg = "We have not find your email address in our record. <br> Please check your email spelling if not then kindly register with us";
        }
        
        return $msg;
    }


    function email_template($mailid)
    {
        $where = "mailid = $mailid";
        $qry = $this->db->query("SELECT * FROM ".emailtemplates_new." WHERE ".$where."");
        return $qry->result_array();
    }
    
      public function getFollowup($customerId)
    {
        return  $this->db->select("*")
            ->from('tbl_followup_calls')
            ->where('cus_id',$customerId)
            ->get()->result_array();
    }
    

}