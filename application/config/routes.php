<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


//$route['default_controller'] = 'Dashboard';
$route['default_controller'] = 'Auth';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['getEnquiryDetail/(:any)'] = 'enquiry/Enquiry/getEnquiryDetail/$1';
$route['updateEnquiry'] = 'enquiry/Enquiry/updateEnquiry';
$route['addEnquiry'] = 'enquiry/Enquiry/addEnquiry';
$route['insertEnquiry'] = 'enquiry/Enquiry/insertEnquiry';
$route['orderQuotationPage'] = 'order_quotation/order/index';
$route['AuthenticateUser'] = 'AUTH/AuthenticateUser';
$route['uploadChatForRejectedArtwork'] = 'Artworks/uploadChatForRejectedArtwork';
$route['orderDetailList'] = 'order_quotation/Order/getOrderDetailList';
$route['orderSetting'] = 'order_quotation/Order/amendment_setings';
$route['checkout']     = 'cart/cart/paymentPage';


/* ----- Active Dies routes (Umair) */

$route['dies'] = 'dies/Dies';


/* ----- CREDIT NOTE routes (Abdul)  */
$route['credit-notes'] = 'credits/Credits';
$route['credit-notes/add'] = 'credits/Credits/addCreditNotes';
$route['credit-notes/find-orders'] = 'credits/Credits/findOrders';
$route['credit-notes/orders-list'] = 'credits/Credits/ordersList';
$route['credit-notes/create-ticket'] = 'credits/Credits/createTicket';
$route['credit-notes/detail/(:any)'] = 'credits/Credits/getTicketDetails';


/* ----- LABEL EMBELLISHMENT routes  */
$route['new_print_service'] = 'order_quotation/Order/new_print_service';
$route['order_emb_details'] = 'order_quotation/Order/order_emb_details';
$route['printed-labels'] = 'order_quotation/Order/print_service';

$route['material-printed-labels'] = 'order_quotation/Order/material_print_service';