<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		$this->load->model('dashboardModel');
		$this->load->model('customer/customerModel');
		$this->_table = "customers";
		$this->load->helper('security');
		//error_reporting(E_ALL);
	}
   
   
//------------------------------------------------STAR OF FILE----------------------------------------------------------	   

 //------------------------------------------------KAMRAN----------------------------------------------------------	   

  public function index(){


    $data['verified'] = $this->user_permsions();
    $data['verified'] = 'yes';
    $this->load->view('auth/login',$data);
  }
	
	
 public function chk_login_secretkey(){
   $response = "error";	 
   $username   = $this->input->post('username');
   $password   = $this->input->post('password');
   $result = $this->verify_userlogin($username,$password);
   if(isset($result['UserID']) && $result['UserID']!=0){
	 $newtoken =  $this->generateRandomString();
	 $this->db->update('customers', array('access_token'=>$newtoken), array('UserID'=>$result['UserID']));
     
	 
	 if(isset($result['access_email']) && $result['access_email']!=""){
	   $this->sendsecuritytoken($result['access_email'],$result['UserName'],$newtoken);
	   $response = "success";
	 }
	 
	 
    }
	 echo $response;
  }
  
  public function verify_userlogin($username,$password){
   $ip_address = $_SERVER['REMOTE_ADDR'];
   $password = md5($password);
   
   $qry = "select UserID,access_email,UserName from customers where `UserName` = '".$this->html_escape($username)."' and `UserPassword` = '".$this->html_escape($password)."' and access_ip = '".$ip_address."' and (UserTypeID = '88' || UserTypeID = '1'  || UserTypeID = '50' || UserTypeID = '23' || UserTypeID = '15' ) and `Active` = '1'  limit 1";
   return $this->db->query($qry)->row_array();
 }

  public function sendsecuritytoken($emailaddress,$username,$newtoken){
	$response = "false";   
	$html = " Hi Admin <br /><br />".$username." has requested a Secret token at ".date('d-m-Y <b> h : i  A</b>', (time()))." for Login in Backoffice,<br /><br /><b>Secret Token: </b>".$newtoken;
	$this->load->library('email', array("mailtype"=>'html'));
	$this->email->from('admin@aalabels.com','AALABELS');
	$this->email->to($emailaddress);
	$this->email->subject("Backoffice Login - Secret Token Request");
	$this->email->message($html);
	$this->email->send();
	$response = "true";  
  }
  
  
    //------------------------------------------------STAR OF FILE----------------------------------------------------------	   

    public function user_permsions(){
		$bypass = $this->input->get('bypass');
		$ip_address = $_SERVER['REMOTE_ADDR'];
		if(SERVER!='localhost'){ 
		  return 'no'; 
		}
		
		if($ip_address== UKOFFICE || $ip_address == UKHOME ) return 'yes';
		else return 'no';
	}

	public function AuthenticateUser(){
    	 
		$user_id = $this->session->userdata('UserID');
		$username = $this->session->userdata('UserName');
		$logIn = $this->input->post('login');

		$verified = $this->user_permsions();

		$http_referer = @$_SERVER['HTTP_REFERER'];
		if(isset($http_referer) and preg_match('/super_admin/i', $http_referer)){
			$verified = 'yes';
		}
        $verified = 'yes';
		if(isset($_GET['username']) and isset($_GET['password'])){
			$username = $_GET['username'];
			$password = $_GET['password'];
		}

		if ($logIn == "Login" || !empty($_GET)) {
			
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			if(isset($verified) and $verified=='no'){
				$this->form_validation->set_rules('token', 'Secret Token', 'trim|required|xss_clean');
			}

		
			if ($this->form_validation->run() == TRUE || !empty($_GET)) {
				if($this->input->post()== TRUE){
					$username = $this->input->post('username', TRUE);
					$password = $this->input->post('password', TRUE);
				}


				if(isset($verified) and $verified=='no'){
					$token = $this->input->post('token', TRUE);
					$result = $this->token_login_check($username, $password, $token);
				}else{
					$result = $this->login_check($username, $password);
				}


				if ($result != false && !empty($result) && is_array($result)) {
					
					if(isset($verified) and $verified=='no'){
						$newtoken =  $this->generateRandomString();
					  if($_SERVER['REMOTE_ADDR']!=PKOFFICE){	
						$this->db->update('access_list', array('token'=>$newtoken), array('ID'=>$result[0]->access_id));
					  }
                        $username = $result[0]->UserName;
                        $this->db->update('customers', array('access_token'=>$newtoken), array('UserID'=>$result[0]->UserID)); //newtoken_login
                      
					}

					$UserNam = $result[0]->UserName;
					$UserID = $result[0]->UserID;
					$UserTypeID = $result[0]->UserTypeID;
					
					
					$this->session->set_userdata('UserName', $UserNam);
					$this->session->set_userdata('UserID', $UserID);
					$this->session->set_userdata('OPERATOR_AA', $UserID);
					$this->session->set_userdata('SALE_ID', $UserID);
					$this->session->set_userdata('UserTypeID',$UserTypeID);
					$this->session->set_userdata('login_user_id', $UserID);
					$this->session->set_userdata('session_id', session_id());
					$this->session->set_userdata('logged_in', true);  // For Login Verifications
					$this->session->set_userdata('login_ip',$_SERVER['REMOTE_ADDR']);
					$this->add_login_activity();
					
						$this->config->set_item('sess_cookie_name','ci_session_sale');
    					if($this->session->userdata('UserTypeID') == 50){
    					  $this->config->set_item('sess_cookie_name','ci_session');
                    	}

				
                    
					
					if ($this->session->userdata('UserTypeID') == 22) { 
				        $url = main_url . 'dies';
					}else{
					    $url = main_url . 'Dashboard';
					}
					
					
					redirect($url);
				}else {
					$msg = "1";
					$this->session->set_flashdata('error_msg', 'Login is invalid. Please try again !');
					$this->session->set_userdata('msg', $msg);
				}
			}
		}
		$data['verified'] = $verified;
		$this->load->view('auth/login', $data);
	}
	
  public function add_login_activity(){
      $array = array('UserID'=>$this->session->userdata('UserID'),'UserName'=>$this->session->userdata('UserName'),'Ip_Address'=>$_SERVER['REMOTE_ADDR'],'Time'=>time());
      $this->db->insert('login_activity',$array);
  }
  
  

  public function sendEmailForToken(){
	  $em = $this->input->post('email');
      $customer = $this->customerModel->getCustomerByEmail($em);
      if(!empty($customer)){
         $token = $this->generateToken();
      }else{
         echo 'empty';
      }
  }
	

	public function generateToken(){
		$email = $this->input->post('email');
		$source = $this->input->post('source');
		$response  = "false";
		if(isset($email) and $email!=''){
			
			$query = $this->db->query("select * from access_list WHERE email LIKE '".$email."' AND status LIKE 'active' AND `type` LIKE '".$source."'  LIMIT 1");

			if($query->num_rows() > 0){

				$newtoken =  $this->generateRandomString();
				$customer = $query->row_array();
				if(isset($customer['Email']) and $customer['Email']!=''){

					$this->db->update('access_list', array('token'=>$newtoken), array('ID'=>$customer['ID']));
					$html = " Hi Admin <br /><br /> Your have request a new Secret token, this is your Secret token :".$newtoken;
					$this->load->library('email', array("mailtype"=>'html'));
					$this->email->from('admin@aalabels.com', ' AALABELS ');
					$this->email->to($email);
					$this->email->subject("Secret Token Request");
					$this->email->message($html);
					$this->email->send();
					$response = "true";
				}

			}
		}
		echo $response;
	}

  public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

  public function login_check($username, $password) {
        $password = md5($password);
        $qry = "select `UserID`,`UserTypeID`,`UserName`,`UserPassword`,`UserEmail`,`Active`,Domain from `$this->_table` where `UserName` = '"

            . $this->html_escape($username) . "' and `UserPassword` = '" .  $this->html_escape($password)

            . "' and UserTypeID != '2' and UserTypeID != '14'  and UserTypeID != '0' and UserTypeID != '16' and UserTypeID != '17' and UserTypeID != '3' and `Active` = '1'  limit 1";

        $query = $this->db->query($qry);
        return $query->result();
    }
  public function token_login_check($username, $password, $token) {

        $password = md5($password);
        $username =  $this->html_escape($username);
        $password =  $this->html_escape($password);
        $ip_address =  $_SERVER['REMOTE_ADDR'];
		
		if($ip_address == PKOFFICE){
		    $qry = "select `UserID`,`UserTypeID`,`UserName`,`UserPassword`,`UserEmail`,`Active`,Domain from customers where `UserName` = '".$this->html_escape($username)."' and `UserPassword` = '".$this->html_escape($password)."' and access_ip = '".$ip_address."' and access_token = '".$token."' and UserTypeID != '2' and UserTypeID != '14'  and UserTypeID != '0' and UserTypeID != '16' and UserTypeID != '17' and UserTypeID != '3' and `Active` = '1'  limit 1";
		   
		}else{

        $qry = "select `UserID`,`UserTypeID`,`UserName`,`UserPassword`,`UserEmail`,`Active`,Domain,
				
		  	(select access_list.ID from access_list 
						where access_list.UserName = customers.UserName AND 
						token LIKE '".$token."' AND 
						`type` = 'saleoperator' ) as access_id
		  from `customers`
		  where  `UserName` = '" . $username . "' and `UserPassword` = '" . $password . "' and  UserTypeID != '2' and `Active` = '1' AND
		 (select count(*) as total from access_list where access_list.UserName = customers.UserName AND token LIKE '".$token."' AND `type` = 'saleoperator' ) = 1
		  limit 1";
		}

        $query = $this->db->query($qry);
        return $query->result();
    }

  public function html_escape($html_escape) {
        $html_escape =  htmlspecialchars($html_escape, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $html_escape;
    }

  public function logout(){

      $this->session->unset_userdata('UserName');

      $this->session->unset_userdata('UserID');

      $this->session->unset_userdata('OPERATOR_AA');

      $this->session->unset_userdata('SALE_ID');

      $this->session->unset_userdata('UserTypeID');

      $this->session->unset_userdata('login_user_id');

      $this->index();
  }


}
