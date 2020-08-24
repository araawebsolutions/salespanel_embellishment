<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class Rest_paypal{
    var $SANDBOX_FLAG; // or 'true' for demo false for live systems
    var $SANDBOX_ENDPOINT; // or 'true' for demo false for live systems
    var $LIVE_ENDPOINT; // or 'true' for demo false for live systems
    var $MERCHANT_ID; // marchent Id of account
    var $SANDBOX_CLIENT_ID; // marchent Id of account
    var $SANDBOX_CLIENT_SECRET; // marchent Id of account
    var $SANDBOX_ENV; // marchent Id of account
    var $LIVE_ENV; // marchent Id of account
    var $LIVE_CLIENT_ID; // marchent Id of account
    var $LIVE_CLIENT_SECRET; // marchent Id of account
    var $SBN_CODE; // marchent Id of account
    var $_ci;

    function __construct($credentials = array()) {
        $this->_ci = & get_instance();
        $this->_ci->load->helper('url');
       
	    if (isset($credentials['sandbox_status']) and $credentials['sandbox_status']=='sandbox') {
				$this->SANDBOX_FLAG = true; 
				$this->SANDBOX_CLIENT_ID = 'AVYm5c-28XsYXQXsnFvqS5yOfj9Qu7e-BpJPSCGaaMxhEcwEIxUGE1mxU3yWNQFP_Z90D2yGYf5Ubdb5'; 
        		$this->SANDBOX_CLIENT_SECRET = 'EBbkfSxG3Ao3L_v6Z8Ve4PhecnY4ESKEZ7ZF5q9CiNx07tjg0tL4sTl2BrdjIZEt-dDU_dQEXMfPrHsx'; 
        }else{
				$this->SANDBOX_FLAG = false; 
				$this->LIVE_CLIENT_ID = 'AQ17Fbau_NLCPpon-4tfY4aeLuX-u054vsJ-0rE9hKkgKEoI6jE5EN2TkmlM7q9510y8m9uoc3tQaWlo'; 
        		$this->LIVE_CLIENT_SECRET = 'EH8W-KuNin42NlD22a6ukAtLqzNpzE7OMpq0JaUXqZpYSrEDBA5yi7D2_NnPS-BsPrT6Ga8XzFRyX57d'; 
		}
		 
        $this->SANDBOX_ENDPOINT = 'https://api.sandbox.paypal.com'; 
        $this->LIVE_ENDPOINT = 'https://api.paypal.com'; 
		$this->SANDBOX_ENV = 'sandbox'; 
        $this->LIVE_ENV = 'production'; 
		$this->SBN_CODE = ''; 
		
       // $this->MERCHANT_ID = '7WN48DQJ7H98Q';  //live
        //$this->LIVE_CLIENT_ID = 'AWNXHeQwzGMKKRrkswy0KXaZoyeOwWAJBW0JzwHZCpxiOeBJMC0RvhX3LOBWeHLzB22AVtHH2d1zlw2B'; 
        //$this->LIVE_CLIENT_SECRET = 'EEaUvOGgRiq1X9NszmL1hvIKUljnudPZaLDGvq8Lx5zPmpTr6EDlPXhs8XNTOuAkSyUpt0ZDnKtzYUIr'; 
        //$this->SBN_CODE = 'PP-DemoPortal-EC-IC-php-REST'; 
    	
   }
   function getclientid(){
	   if($this->SANDBOX_FLAG) {
        	return $this->SANDBOX_CLIENT_ID;
		} else {
			return $this->LIVE_CLIENT_ID;
		}
   		
   }
    function getmerchantid(){
   		return $this->MERCHANT_ID;
   }
   function environment(){
   		if($this->SANDBOX_FLAG) {
        	return $this->SANDBOX_ENV;
		} else {
			return $this->LIVE_ENV;
		}
   }
   
   function expressCheckoutdata($data){


               $expressCheckoutArray = '{
                                  "transactions":[
                                     {
                                        "amount":{
                                           "currency":"'.$data['currency'].'",
                                           "total":"'.$data['total'].'",
                                           "details":{
                                              "shipping":"0",
                                              "subtotal":"'.$data['total'].'",
                                              "tax":"0",
                                              "insurance":"0",
                                              "handling_fee":"0",
                                              "shipping_discount":"0"
                                           }
                                        },
                                        "description":"'.$data['description'].'",
                                        "item_list":{
                                           "items":[
                                              {
                                                 "name":"'.$data['item_name'].'",
                                                 "quantity":"1",
                                                 "price":"'.$data['total'].'",
                                                 "currency":"'.$data['currency'].'"
                                              }
                                           ]
                                        }
                                     }
                                  ],
                                  "payer":{
                                     "payment_method":"paypal"
                                  },
                                  "intent":"sale",
                                  "state": "created",
                                  "redirect_urls":{
                                     "cancel_url":"'.$data['cancel_url'].'",
                                     "return_url":"'.$data['return_url'].'"
                                  }
                               }';
        return $expressCheckoutArray;		
   }
	
	
   function getAccessToken(){
	$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
	$curlServiceUrl = $curlServiceUrl. "/v1/oauth2/token";
	$clientId = ($this->SANDBOX_FLAG ? $this->SANDBOX_CLIENT_ID : $this->LIVE_CLIENT_ID);
	$clientSecret = ($this->SANDBOX_FLAG ? $this->SANDBOX_CLIENT_SECRET : $this->LIVE_CLIENT_SECRET);
	$curlHeader = array(
		 "Content-type" => "application/json",
		 "Authorization: Basic ". base64_encode( $clientId .":". $clientSecret),
		 "PayPal-Partner-Attribution-Id" => $this->SBN_CODE
		 );
		$postData = array(
			 "grant_type" => "client_credentials"
		 );

		$curlPostData = http_build_query($postData);
		$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $curlPostData);
		$access_token = $curlResponse['json']['access_token'];
		//$access_token = $curlResponse['access_token'];
		return $access_token;
}


/*
	* Purpose: 	Gets the PayPal approval URL to redirect the user to.
	* Inputs:
	*		access_token    : The access token received from PayPal
	* Returns:              approval URL
	*/
function getApprovalURL($access_token, $postData){
	$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
	$curlServiceUrl = $curlServiceUrl. "/v1/payments/payment";
	$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".$this->SBN_CODE);
	$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $postData);
	$jsonResponse = $curlResponse['json'];
    foreach ($jsonResponse['links'] as $link) {
		if($link['rel'] == 'approval_url'){
			$approval_url = $link['href'];
           // $approval_url = str_replace('cgi-bin/webscr?cmd=_express-checkout&', 'checkoutnow?', $link['href']);
			return $approval_url;
		}
	 }

}

function getPaymentID($access_token, $postData){
	$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
	$curlServiceUrl = $curlServiceUrl. "/v1/payments/payment";
	$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".$this->SBN_CODE);

	$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $postData);
	$jsonResponse = $curlResponse['json'];
       return  $jsonResponse['id'];
	

}



/*
	* Purpose: 	Look up a payment resource, to get details about payments that have not yet been completed
	* Inputs:
	*		paymentID    : The id of the created payment
	* Returns:              the payment object
	*/
function lookUpPaymentDetails($paymentID, $access_token){
	$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
	$curlServiceUrl = $curlServiceUrl. "/v1/payments/payment/". $paymentID;
	$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".$this->SBN_CODE);

	$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, NULL);
	return $curlResponse['json'];

}


	/*
		* Purpose: 	Executes the previously created payment for a given paymentID for a specific user's payer id.
		* Inputs:
		*		paymentID    : The id of the previously created PayPal payment
		*       payerID      : The id of the user received from PayPal
		*       transactionAmountArray   : amount array if updating the payment amount
		* Returns:
		*		array["http_code"]   : the http status code   
		*		array["jason"]       : the response string
		*/
	function doPayment($paymentID, $payerID, $transactionAmountArray){
		
		$access_token =  $this->_ci->session->userdata('access_token');	
		$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
		$curlServiceUrl = $curlServiceUrl. "/v1/payments/payment/". $paymentID ."/execute";
		$curlHeader = array("Content-Type:application/json", "Authorization:Bearer ".$access_token, "PayPal-Partner-Attribution-Id:".$this->SBN_CODE);
	
		$postData = array("payer_id" => $payerID);
	
		if(!is_null($transactionAmountArray)){
			$postData ["transactions"][0] = $transactionAmountArray;
		}
	
		$curlPostData = json_encode($postData);
		$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $curlPostData);
		return $curlResponse;
	}
		
	function curlCall($curlServiceUrl, $curlHeader, $curlPostData) {

			// response container
			$resp = array(
				"http_code" => 0,
				"jason"     => ""
			);
		
			//set the cURL parameters
			$ch = curl_init($curlServiceUrl);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			//turning off the server and peer verification(TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
			curl_setopt($ch, CURLOPT_SSLVERSION , 'CURL_SSLVERSION_TLSv1_2');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $curlHeader);
		
			if(!is_null($curlPostData)) {
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPostData);
			}
			//getting response from server
			$response = curl_exec($ch);
		
			
		
			 $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
			curl_close($ch); // close cURL handler
			
			// some kind of an error happened
			if (empty($response)) {
				return $resp;
			}
			
			$resp["http_code"] = $http_code;
			$resp["json"] = json_decode($response, true);
			
			return $resp;
   }
   
    /************************************************************/
    function getRefreshToken($authorize_code){
		$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
		$curlServiceUrl = $curlServiceUrl. "/v1/oauth2/token";
		$clientId = ($this->SANDBOX_FLAG ? $this->SANDBOX_CLIENT_ID : $this->LIVE_CLIENT_ID);
		$clientSecret = ($this->SANDBOX_FLAG ? $this->SANDBOX_CLIENT_SECRET : $this->LIVE_CLIENT_SECRET);
		 $curlHeader = array(
				 "Content-type" => "application/x-www-form-urlencoded",
				 "Authorization: Basic ". base64_encode( $clientId .":". $clientSecret),
			 );
		
			$postData = array(
				 "grant_type" => "authorization_code",
				 "response_type" => "token",
				 "redirect_uri"=>"urn:ietf:wg:oauth:2.0:oob",
				 "code" => $authorize_code,
			 );
	
			$curlPostData = http_build_query($postData);
			$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $curlPostData);
			//$refresh_token = $curlResponse['json']['refresh_token'];
			//$access_token = $curlResponse['json']['access_token'];
			return $curlResponse['json'];
	}
	function getFutureAccessToken($refresh_token){
		$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
		$curlServiceUrl = $curlServiceUrl. "/v1/oauth2/token";
		$clientId = ($this->SANDBOX_FLAG ? $this->SANDBOX_CLIENT_ID : $this->LIVE_CLIENT_ID);
		$clientSecret = ($this->SANDBOX_FLAG ? $this->SANDBOX_CLIENT_SECRET : $this->LIVE_CLIENT_SECRET);
		$curlHeader = array(
				 "Content-type" => "application/x-www-form-urlencoded",
				 "Authorization: Basic ". base64_encode( $clientId .":". $clientSecret),
			 );
			$postData = array(
				 "grant_type" => "refresh_token",
				 "refresh_token" => $refresh_token,
			 );
	
			$curlPostData = http_build_query($postData);
		    $curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $curlPostData);
		    //echo "<pre>";
		    //print_r($curlResponse);
		    //echo "</pre>";
		   
		  	$access_token = $curlResponse['json']['access_token'];
			//$access_token = $curlResponse['access_token'];
			return $access_token;
	}
	
	function getPaypalUserinfo($access_token){
		$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
		$curlServiceUrl = $curlServiceUrl. "/v1/identity/openidconnect/userinfo/?schema=openid";
		$curlHeader = array(
			 "Content-type" => "application/json",
			 "Authorization:Bearer ".$access_token,
			 );
			$postData = array();
	
			$curlPostData = json_encode($postData);
			$curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $curlPostData);
	    	//echo "<pre>";
	    	//print_r($curlResponse);
			//echo "</pre>";
	    	$email = $curlResponse['json']['email'];
			return $email;
	}
	function mobilePayments($access_token, $data){
    	$curlServiceUrl = ($this->SANDBOX_FLAG ? $this->SANDBOX_ENDPOINT : $this->LIVE_ENDPOINT);
		
		$curlServiceUrl = $curlServiceUrl. "/v1/payments/payment";
		$curlHeader = array(
			 "Content-type" => "application/x-www-form-urlencoded",
			 "PayPal-Client-Metadata-Id: 4315ed5244b24f0183bbc29a34d60b2a",
			 "Authorization:Bearer ".$access_token,
			 );
		    //authorize sale
			$postData = array(
					"intent" 	   => "authorize",
					"payer"  	   => array( "payment_method"=>"paypal"),
					"transactions" => $data,
			);
	
	        $curlPostData = json_encode($postData);
	        	$curlPostData = http_build_query($postData);
	      // $curlPostData = '{"intent":"sale","payer":{"payment_method":"paypal"},"redirect_urls":{"return_url":"http://cabigate.com/PayPal-PHP-SDK//ExecutePayment.php?success=true","cancel_url":"http://cabigate.com/PayPal-PHP-SDK//ExecutePayment.php?success=false"},"transactions":[{"amount":{"currency":"USD","total":"0.17"},"description":"Payment description"}]}';
			return $curlResponse = $this->curlCall($curlServiceUrl, $curlHeader, $curlPostData);
			//return $curlResponse['json'];
	}
	//https://github.com/paypal/PayPal-Android-SDK/blob/master/docs/future_payments_server.md
	//https://github.com/paypal/PayPal-iOS-SDK/blob/master/docs/future_payments_server.md#request
	//https://developer.paypal.com/docs/api/identity/#openidconnect
	//https://github.com/paypal/PayPal-iOS-SDK/blob/master/docs/profile_sharing_server.md
	
	
    
}


