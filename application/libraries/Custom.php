<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Class
 *
 * Permits email to be sent using Mail, Sendmail, or SMTP.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/email.html
 */
class Custom {

	
	public function __construct($config = array()){ 
	  $CI =& get_instance();
	  $this->ci = $CI; 
	 // error_reporting(E_ALL);
	 // die('----');
	}
	
	
	
	 /*=======================================Dispatch Date Code===========================================================================*/
	
	
		
	function assign_dispatch_date($orderNumber = NULL, $check_payment_check = NULL){
	    //echo $orderNumber;exit;
		$CI =& get_instance();
        $printed_order =array();
        $custom_order=array();
        $plain_order = array();
        $printed_check = "";
		//echo $orderNumber;
		if($orderNumber != NULL){
			$orderNumber = " and orders.OrderNumber = '".$orderNumber."'";
		}else{
			$orderNumber = "";
		}
		
		// 50 limit include when upload 

		$orders_data = $CI->db->query("select orders.OrderNumber,orders.OrderDate,orders.OrderTime,orders.DeliveryCountry,orders.ShippingServiceID, shippingservices.ServiceID, shippingservices.Priority, orders.PaymentMethods  from orders inner join shippingservices on shippingservices.ServiceID = orders.ShippingServiceID where orders.expectedDispatchDate = '' ".$orderNumber."  and (orders.OrderStatus = 2 or orders.OrderStatus = 32 or orders.OrderStatus = 55)")->result_array();
		//print_r($orders_data);exit;
		//echo $CI->db->last_query();die;

       // print_r($orders_data);exit;
		foreach($orders_data as $data){
		
			$query_orderDetails =  $CI->db->query("select printing, ManufactureID from orderdetails where OrderNumber = '".$data['OrderNumber']."'")->result_array();
		//	print_r($query_orderDetails);exit;
			if(count($query_orderDetails) == 1){

				$printing_or_plain             =  $query_orderDetails[0]['printing'];
				$order_time_before_4           =  date('H', $data['OrderTime']);
				$order_no                      =  $data['OrderNumber'];
				$Shipping_sevice_id            =  $data['ShippingServiceID'];
				$order_date                    =  $data['OrderDate'];
				$Priority                      =  $data['Priority'];
				$ServiceID                     =  $data['ServiceID'];
				
				$check_custom_die = $CI->db->query("select * from flexible_dies where OrderNumber = '".$order_no."'")->row();
				// if custom die order
				if(count($check_custom_die) > 0){
					
					$check_custom_die_info = $CI->db->query("select flexible_dies_mat.labeltype as labeltype from flexible_dies_mat inner join flexible_dies_info on flexible_dies_info.ID = flexible_dies_mat.OID where flexible_dies_info.OID = '".$check_custom_die->SerialNumber."'")->row();
					if($check_custom_die_info->labeltype == 'printed'){
								return false;
					}
					
					$order_date = $check_custom_die->Time;
					$order_time_before_4  =  date('H', $order_date);
					$this->custom_die(array('OrderNumber'=>$order_no, 'OrderDate'=>$order_date, 'OrderTime'=>$order_date, 'DeliveryCountry'=>$data['DeliveryCountry'], 'ShippingServiceID'=>$Shipping_sevice_id, 'printing'=>$printing_or_plain));
					
					
				}else{
					
					// if order is plain
					if($printing_or_plain != 'Y'){
						
						/* Start Apply check for cheques & Bacs and Purchase Order */
						
						$paymentsMethod = $data['PaymentMethods'];
						
						if($paymentsMethod == 'chequePostel' || $paymentsMethod == 'purchaseOrder' || $check_payment_check == TRUE){
							$order_date = strtotime(date('Y-m-d H:i:s'));
							$this->plain_order_handling(array('DeliveryCountry'=>$data['DeliveryCountry'], 'order_no'=>$order_no, 'order_time_before_4'=>$order_time_before_4, 'order_date'=>$order_date, 'Priority'=>$data['Priority'],'ServiceID'=>$data['ServiceID']));
							return false;
						}
						
						/* End Apply check for cheques & Bacs and Purchase Order */
						
						if($data['DeliveryCountry'] != 'United Kingdom'){
	
								if(strtolower($Priority) == strtolower('High')){
										$currDay = date('l', $order_date);
										if($currDay == 'Saturday'){
											$order_date =  strtotime($this->check_dispatch_day($order_date , '+2 day'));
										}else if($currDay == 'Sunday'){
											$order_date = strtotime($this->check_dispatch_day($order_date , '+1 day'));
										}
										if($order_time_before_4 < 16){
											$expected_dispatch_date = Date('Y-m-d',$order_date);
											$expected_dispatch_date_new  = $expected_dispatch_date;
										}else{
											
											if($currDay == 'Saturday' || $currDay == 'Sunday'){
													$expected_dispatch_date = Date('Y-m-d',$order_date);
											}else{
													$expected_dispatch_date = $this->check_dispatch_day($order_date , '+1 day');
											}
											
											$check_order_date = Date('Y-m-d',$order_date);
										    $checked_expected_dispatch_date  = Date('Y-m-d',strtotime($expected_dispatch_date));
										    $expected_dispatch_date_new = '';
										    if($check_order_date != $checked_expected_dispatch_date){
											   $expected_dispatch_date_new = $this->check_holiday_between_dates($check_order_date, $checked_expected_dispatch_date,'false','false');
										    }
										    if($expected_dispatch_date_new == ''){
													$expected_dispatch_date_new = $checked_expected_dispatch_date;
										    }
										 }
										
									   $expected_dispatch_date  = $this->check_event($expected_dispatch_date_new);
									   $ordertime = Date('H:i:s', $order_date);
									   $explode_expected_dispatch_date = explode(" ",$expected_dispatch_date);
									   $data = array( 'expectedDispatchDate' => strtotime(implode(" ",array($explode_expected_dispatch_date[0], $ordertime))));
									   $CI->db->where('OrderNumber', $order_no);
									   $CI->db->update('orders', $data);
										
										
								}
									
						}else{
							
						   $check_custom_die = $CI->db->query("select * from flexible_dies where OrderNumber = '".$order_no."' and type = 'custom'")->row();
						   if(count($check_custom_die) == 0 ){
								$this->plain_order_handling(array('DeliveryCountry'=>$data['DeliveryCountry'], 'order_no'=>$order_no, 'order_time_before_4'=>$order_time_before_4, 'order_date'=>$order_date, 'Priority'=>$data['Priority'],'ServiceID'=>$data['ServiceID']));
							}
							
						}
					}
					// if order is printed
					else if($printing_or_plain == 'Y'){
						$check_artwork_approval = $CI->db->query("select approve_date, approved from order_attachments_integrated where OrderNumber = '".$order_no."'")->result_array();
						if(count($check_artwork_approval) > 0){
								$all_true = 1;
								$aapproved_date_array =array();
								foreach($check_artwork_approval as $artwork){
									if($artwork['approve_date'] != ''){
										$aapproved_date_array[] = $artwork['approve_date'];
									}else{
										$all_true = 0;
									}
								}
								
								if($all_true == 1){
									$mostRecent= 0;
									foreach($aapproved_date_array as $date){
										$curDate = Date('Y-m-d H:i:s', $date);
										if ($curDate > $mostRecent) {
											 $mostRecent = $curDate;
										}
									}
									$order_date                    =  strtotime($mostRecent);
									$order_time_before_4           =  date('H', strtotime($mostRecent));
									$this->printing_or_plain(array('DeliveryCountry'=>$data['DeliveryCountry'], 'order_no'=>$order_no, 'order_time_before_4'=>$order_time_before_4, 'order_date'=>$order_date, 'Priority'=>$data['Priority'],'ServiceID'=>$data['ServiceID']));
										
								}
						  }
					  }
				 }
			}
			else if(count($query_orderDetails) > 1){
				
				/*========================Check All artwok upload=========================*/
				    
					$query_check_all_artwork = $CI->db->query("SELECT SerialNumber FROM orderdetails WHERE OrderNumber = '".$data['OrderNumber']."' and Printing = 'Y'")->result_array();
					
					if(count($query_check_all_artwork) > 0 ){
						foreach($query_check_all_artwork as $serialNo){
							
							$query_artwok_upload_or_not = $CI->db->query("SELECT * FROM order_attachments_integrated WHERE Serial = '".$serialNo['SerialNumber']."'")->result_array();
							
							if(count($query_artwok_upload_or_not) == 0){
								return false;
							}
							
						}
					}
				
				/*========================Check All artwok upload=========================*/
				
				$plain_order = array(); $printed_order = array(); $custom_order = array();
				$all_order_data = array();
				$orders_data_multiple = $CI->db->query("select orders.OrderNumber,orders.OrderDate,orders.OrderTime,orders.DeliveryCountry,orders.ShippingServiceID,orderdetails.printing as printing, shippingservices.ServiceID, shippingservices.Priority, orderdetails.ManufactureID  from orders left join orderdetails on orderdetails.OrderNumber = orders.OrderNumber inner join shippingservices on shippingservices.ServiceID = orders.ShippingServiceID where orders.OrderNumber = '".$data['OrderNumber']."'  and (orders.OrderStatus = 2 or orders.OrderStatus = 32 or orders.OrderStatus = 55)")->result_array();
				$count = 0;
				foreach($orders_data_multiple as $data_new){
					
					if($data_new['ManufactureID'] == 'SCO1'){
						$check_custom_die = $CI->db->query("select * from flexible_dies where OrderNumber = '".$order_no."'")->row();
						if(count($check_custom_die) > 0){
							
							$check_custom_die_info = $CI->db->query("select flexible_dies_mat.labeltype as labeltype from flexible_dies_mat inner join flexible_dies_info on flexible_dies_info.ID = flexible_dies_mat.OID where flexible_dies_info.OID = '".$check_custom_die->SerialNumber."'")->row();
							if($check_custom_die_info->labeltype == 'printed'){
										continue;
							}

							$custom['true_false'] = TRUE;
							$custom['time'] = $check_custom_die->Time;
							$order_data_current[$check_custom_die->Time] =  $orders_data_multiple[$count];
							array_push($all_order_data, $order_data_current);
							
						}else{
							$custom['true_false'] = FALSE;
							$custom['time'] = '';
						}
						array_push($custom_order, $custom);
					}else{
						if($data_new['printing'] == ''){
							$plain['true_false'] = TRUE;
							$plain['time'] = $data_new['OrderDate'];
							$order_data_current[$data_new['OrderDate']] =  $orders_data_multiple[$count];
							array_push($all_order_data, $order_data_current);
							array_push($plain_order, $plain);
						}
					if($data_new['printing'] == 'Y'){
							$check_artwork_approval = $CI->db->query("select approve_date, approved from order_attachments_integrated where OrderNumber = '".$data_new['OrderNumber']."'")->result_array();
						if(count($check_artwork_approval) > 0){
							$all_true = 1;
							$aapproved_date_array =array();
							foreach($check_artwork_approval as $artwork){
								if($artwork['approve_date'] != ''){
									$printed['true_false'] = TRUE;
									$printed['time'] = $artwork['approve_date'];
									$order_data_current[$artwork['approve_date']] =  $orders_data_multiple[$count];
									array_push($all_order_data, $order_data_current);
									array_push($printed_order, $printed);
								}else{
									$printed['true_false'] = FALSE;
									$printed['time'] = '';
									array_push($printed_order, $printed);
								}
							}
						  }
						}
					  }
					  
					  $count++;
				   }
		      }
		
			  // $printed_check = TRUE; $custom_check = TRUE; $plain_check = TRUE;


			   if(in_array(FALSE, array_column($printed_order, 'true_false'))) {$printed_check = FALSE;}
		       if(in_array(FALSE, array_column($custom_order , 'true_false'))) {$custom_check = FALSE;}
		       if(in_array(FALSE, array_column($plain_order  , 'true_false'))) {$plain_check = FALSE;}
		       $all_time_array = array();
			   if($printed_check == TRUE && $custom_check == TRUE && $plain_check == TRUE){
			
					if(is_array($plain_order)){
						foreach($plain_order as $order_time){
							array_push($all_time_array, $order_time['time']);
						}
					}
			
					if(is_array($printed_order)){
						foreach($printed_order as $order_time){
							array_push($all_time_array, $order_time['time']);
						}
					}
			
					if(is_array($custom_order)){
						foreach($custom_order as $order_time){
							array_push($all_time_array, $order_time['time']);
						}
					}
			
					$mostRecent= 0;
			
					foreach($all_time_array as $date){
							$curDate = Date('Y-m-d H:i:s', $date);
							if ($curDate > $mostRecent) {
								$mostRecent = $curDate;
							}
					}
		
					$last_index_data = $all_order_data[count($all_order_data) - 1];
					$most_recent_time = strtotime($mostRecent);
					$final_data = $last_index_data[$most_recent_time];
					$final_data['OrderDate'] = $most_recent_time;
					$final_data['OrderTime'] = $most_recent_time;
					if($final_data['ManufactureID'] == 'SCO1'){
						$this->custom_die($final_data);
					}else if($final_data['printing'] == 'Y'){
						$this->printing_or_plain_forMultiple($final_data);
					}else{
						
						if($check_payment_check == TRUE){
							
							$order_date = strtotime(date('Y-m-d H:i:s'));
							$final_data['OrderDate'] = $order_date;
							$final_data['OrderTime'] = $order_date;
							$this->printing_or_plain_forMultiple($final_data);
							
						}else{
						
							$this->printing_or_plain_forMultiple($final_data);
						}
					}
				}
			}
			
		} 


	/*=======================================Dispatch Date Code===========================================================================*/ 



	
 
}
// END CI_Email class
/* End of file Email.php */
/* Location: ./system/libraries/Email.php */