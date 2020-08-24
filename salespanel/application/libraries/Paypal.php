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

class Paypal{
    var $version; //hold the version of api
    var $environment; // or 'live' for our live systems
    var $merchantID; // marchent Id of account
    var $returnURL; //return url
    var $cancelURL; //cancel url
    var $ipn_listener; //ipn listener
    var $item_name; // hold the item name
    var $_debug; //set the debug options enum(0,1)
    //set the iframe option enum(0,1)
    //0 redirect
    //1 iframe
    var $_iframe; 
    var $template; //urlencode
    var $paymentAction; //or $paymentAction='authorization';
    //API
    var $API_UserName;  //urlencode
    var $API_Password;  //urlencode
    var $API_Signature; //urlencode
    var $API_Endpoint;  //urlencode
    //button vars
    var $btnVars = array();           // array holds the Button vars
    var $btnCode;
    var $btnType;
    var $_requestString;
    var $_ci;
	var $showHostedThankyouPage;
    /****************/
    var $_result = array();
    //Default Settings
//    var $_default = array(
//        'version'=> '94.0',//urlencode
//        'environment'=>'sandbox',
//        'merchantID'=>'',//urlencode
//        'returnURL'=>'',//urlencode
//        'cancelURL'=>'', //urlencode
//        'ipn_listener'=>'', //urlencode
//        'item_name'=>'TestButton', //urlencode
//        '_debug'=>'0', 
//        '_iframe'=>'1', 
//        'template'=>'TemplateD', 
//        'paymentAction'=>'sale', 
//        'API_UserName'=>'', //urlencode 
//        'API_Password'=>'', //urlencode
//        'API_Signature'=>'', //urlencode
//        'API_Endpoint'=>'', //urlencode
//        
//        
//        
//    );
    /*
     * Default Constructor
     */
    function __construct() {
        /****/
        $this->_ci = & get_instance();
        $this->_ci->load->helper('url');
        
        /******************/
        $this->version = urlencode("94.0");
        $this->environment = "sandbox"; // sandbox or live
        //$this->merchantID = "U32HTS65R4RNG";
    
	   $this->API_UserName = urlencode("sb-6y1lu616745_api1.business.example.com");
       $this->API_Password = urlencode("U2YW73WLVHDFHZVP");
       $this->API_Signature = urlencode("Ae0qLw3RVDTRkPgLgems1L21na5.AY.cojAG2UWuGCIFvp6BkSNM5AqR");
	   
	      
		//$this->API_UserName = urlencode("ebay_api1.aalabels.com");
//        $this->API_Password = urlencode("8KVDDPZ2ZM5VNEH4");
//        $this->API_Signature = urlencode("AiPC9BjkCyDFQXbSkoZcgqH3hpacATgn2OfyU7VL39Vl9RY1q5i9LKDh");
//		
		
        
      // $this->API_UserName = urlencode("arslan_jd2009_api1.hotmail.com");
       //$this->API_Password = urlencode("1396964161");
      // $this->API_Signature = urlencode("AFcWxV21C7fd0v3bYYYRCpSSRl31A8lE6FDFt61png6albg0N-qBxNQT");

 
         $this->API_Endpoint = "https://api-3t.paypal.com/nvp";
        if("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
            $this->API_Endpoint = "https://api-3t.$this->environment.paypal.com/nvp";
	}
        $this->btnCode = 'TOKEN';
        $this->btnType = 'PAYMENT';
        $this->paymentAction = "sale";
      
	//    $this->paymentAction = "authorization";
        //$this->item_name = "TestButton";
		
		//$this->showHostedThankyouPage = "false";
        /***************************/
        $this->_debug = 0; //or 0
        $this->_iframe = 1; //or 0
        /////////
//        $this->template = "";
        if ($this->_iframe){
	           $this->template = urlencode('TemplateD'); //template D is for iFrame implementation, the other three are for the redirect option
        }else{  //SELECT ONE OF THESE AND COMMENT THE OTHERS OUT
            $this->template = urlencode('TemplateA');
            //  OR
            //	$template=urlencode('TemplateB');
            //	//  OR
            //	$template=urlencode('TemplateC');
        }
        $this->setBtnVars("template",$this->template);   //add the template
    //    $this->setBtnVars("business",'S2WF7T8ELZZZS'); //add marchen id
        $this->setBtnVars("currency_code","GBP"); //add currency_code
		 $this->setBtnVars("lc","GB"); //add currency_code
        
		$this->setBtnVars("cbt","true"); 
        
		
        //$this->setBtnVars("return",$this->returnURL); //add returnURL
        //$this->setBtnVars("cancel_return",$this->cancelURL); //add cancel_return
       // $this->setBtnVars("notify_url",$this->ipn_listener); //add notify_url
        
		$this->setBtnVars("showHostedThankyouPage","false"); //add showHostedThankyouPage
        $this->setBtnVars("paymentaction",$this->paymentAction); //add paymentaction
        //$this->setBtnVars("item_name",$this->item_name); //add item_name
        
    }
    public function makeHttpPost($method_) {
        $nvpStr_ = $this->getRequestString();
        $httpResponse = $this->_makeCurl($method_, $nvpStr_);
	$httpResponseAr = explode("&", $httpResponse);
	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if(sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
	}
        if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            //exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
            throw new RuntimeException("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }
	return $httpParsedResponseAr;
    }
    private function _makeCurl($methodName_,$nvpStr_){
        //echo $this->API_Endpoint;
        $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$this->version&PWD=$this->API_Password&USER=$this->API_UserName&SIGNATURE=$this->API_Signature$nvpStr_";
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	// Get response from the server.
	$httpResponse = curl_exec($ch);
        if(!$httpResponse) {
		//exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
            throw new RuntimeException("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}
        return $httpResponse;
    }
//    public function setBtnVars($name_,$name1_,$value_){
//        if (isset($name_) || isset($value_) && ($name_ != '' || $value_ != "")) {
//            $this->btnVars[] = $name_ . "=" . $value_;
//        }else
//            throw new RuntimeException("Set Button Values Empty.");
//    }
    public function setBtnVars($name_,$value_){
        $this->btnVars[] = array(
                    'name'=>$name_,
                    'val'=>  urlencode($value_),
                );
    }
    public function getBtnVars(){
        return $this->btnVars;
    }
    public function _makeRequestString(){
        $this->_requestString = "&BUTTONCODE=".$this->btnCode.
                                "&BUTTONTYPE=".$this->btnType;
       if("0" != count($this->btnVars)){ 
        foreach($this->btnVars as $key => $value){
         
         $this->_requestString .="&L_BUTTONVAR".$key."=".$value['name']."=".$value['val'];   
        }
       }
    }
    public function getRequestString(){
        $this->_makeRequestString();
        return $this->_requestString;
    }
    function QueryStringToArray(){ //This function simply converts a URL query string into an array
        
	$result=trim($this->getRequestString(),"&"); //remove any possible blanks before they go into array
	$lines = explode("&", $result);
            //build an array of the data
            $responseArray = array();
            for ($i=0; $i<count($lines);$i++){
                $arra2 = explode("=", $lines[$i]);
                $numberOfstrings = count($arra2);
                $key = $arra2[0];
                switch ($numberOfstrings){
                    default: $val=''; break;
                    case 2: $val = $arra2[1]; break;
                    case 3: $val = $arra2[1]."=".$arra2[2]; break;
                    case 4: $val = $arra2[1]."=". $arra2[2]."=". $arra2[3]; break;
                }
            $responseArray[urldecode($key)] = urldecode($val);
	}
	return $responseArray;
    }
    public function showFullRequestAndResponse($responseArray){
       if($this->_debug){ 
            $requestArray = $this->QueryStringToArray();
            echo "<PRE>REQUEST STRING (WITHOUT USER CREDENTIALS:";
            print_r($requestArray);
            echo "<br>Response:";
            print_r($responseArray);
            echo "</PRE>";
       }else{
           throw new RuntimeException("Please set Debug true to use this function");
       }
    }
    private function _run($method_){
        $httpParsedResponseAr = $this->makeHttpPost($method_);
        //if Debug is set to 1, then show the full API request and response
        if ($this->_debug) {
            $this->showFullRequestAndResponse($httpParsedResponseAr);
        }
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			if ($this->_iframe){ // If iframe is set to 1, then show the iframe, otherwise show a button for redirect.
                $emaillink=urldecode($httpParsedResponseAr['EMAILLINK']);
                $this->_result['other'] = $httpParsedResponseAr;
////                $this->_result=$httpParsedResponseAr;
                $this->_result['code']="
                        <div id='theiFrame' style='height:auto;'>
                                <iframe name='hss_iframe' id='hss_iframe' style='border:none;margin-top: 10px;width:575px;min-height: 555px;' src='".$emaillink."'>
                                        <p>Your browser does not support iframes.</p>
                                </iframe>
					    </div>
                    ";
                
            }else{
		//just output the WEBSITECODE response variable, which is a hosted Button image/link with all information stored at the PayPal end.
		$this->_result['code'] = urldecode($httpParsedResponseAr['WEBSITECODE']);
            }
        }else{
            throw new RuntimeException($this->item_name.' API failed: ' . print_r($httpParsedResponseAr, true));
        }
        
    }
    public function getResult($Name,$method_){
        $this->setItemName($Name);
        $this->_run($method_);
        return $this->_result;
    }
    public function setItemName($s){
         $this->item_name = $s;   
    }
    
}


