<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('customer/customerModel');
        $this->load->model('cart/cartModal');
        $this->load->model('myPriceModel');
        $this->load->model('order_quotation/orderModal');
        $this->load->model('email/EmailModal');
        $this->load->model('order_quotation/quotationModal');
        $this->load->model('quoteModel');
        $this->loginame = $this->session->userdata('UserName');
        $this->home_model->user_login_ajax();
        
        //error_reporting(E_ALL);
    }

//---------------------STAR OF FILE---------------------

    public function index(/*$mat = null*/)
    {

        /*if($mat && $mat = 'mat'){
            $format = 1;
        }else{
            $format = 0;
        }*/
        //$this->session->set_userdata('customer_id','');
        //$data['customers'] = $this->customerModel->getAllCustomers();
        $data['main_content'] = "order_quotation/order_quotation";
        //$data['format'] = $format;
        $this->load->view('page', $data);
    }


    public function getOrderDetailList()
    {
        $query = $this->db->query("Select count(`OrderID`) AS TotalHold from orders WHERE OrderStatus =10 ");
        $row = $query->row_array();
        $data['TotalHold'] = $row['TotalHold'];
        $query2 = $this->db->query("Select count(`OrderID`) AS pending from orders WHERE OrderStatus =55 ");
        $row2 = $query2->row_array();
        $data['pending'] = $row2['pending'];
        $data['main_content'] = "order_quotation/order_detail/order_detail_list";
        $this->load->view('page', $data);
    }

    public function getAllOrders($filter = NULL, $status = NULL, $duration = NULL)
    {
        echo $this->orderModal->getAllOrders($filter, $status, $duration);
    }

    public function getOrderDetail($orderNumber)
    {

        $data['main_content'] = "order_quotation/order_detail/order_detail_page";

        $data['order'] = $this->orderModal->getOrder($orderNumber)[0];

		//order detail update configuration changes
		$userId = $this->session->userdata('UserID');
		$userTypeId = $this->session->userdata('UserTypeID');
		if($userId == '652793' || $userId == '653722' && $userTypeId == '1'){
			if($data['order']->OrderStatus != '6' && $data['order']->OrderStatus != '78'){
				$this->update_configuration($this->settingmodel->OrderInfo($orderNumber));
			}
		}else{
			$this->update_configuration($this->settingmodel->OrderInfo($orderNumber));
		}
        //order detail 

        $data['status'] = $this->orderModal->statusDropDown($data['order']->OrderStatus, $data['order']->PaymentMethods);

        $data['orderDetails'] = $this->orderModal->getOrderDetail($orderNumber);

        $data['paymentReceived'] = $this->orderModal->payment_recieved($orderNumber);
        $data['notes'] = $this->orderModal->getOrderNotes($orderNumber);
        $data['digitalis'] = $this->cartModal->digitalPrintingProcess();

        /***************** Latest PayPal Integrations *********************/
        $sandbox_status = 'live'; //sandbox
        if (SITE_MODE == 'live') {
            $sandbox_status = 'live';
        }
        $credentials = array('sandbox_status' => $sandbox_status);
        $this->load->library('rest_paypal', $credentials);
        $data['clientid'] = $this->rest_paypal->getclientid();
        $data['environment'] = $this->rest_paypal->environment();
        /**********************************************************************/

        $this->load->view('page', $data);
    }


    function intialize_paypal_payment()
    {

        $response = array('response' => 404);
        if ($_POST) {

            $sandbox_status = 'sandbox'; //sandbox
            if (SITE_MODE == 'live') {
                $sandbox_status = 'live';
            }
            $credentials = array('sandbox_status' => $sandbox_status);
            $this->load->library('rest_paypal', $credentials);
            $data['clientid'] = $this->rest_paypal->getclientid();

            $orderNumber = $this->input->post('orderno');
            $type = "full";


            $orderinfo = $this->orderModal->getOrder($orderNumber)[0];
            $orderDetails = $this->orderModal->getOrderDetail($orderNumber);

            $userid = $orderinfo->UserID;
            $ServiceID = $orderinfo->ServiceID;
            $amount = $orderinfo->OrderTotal + $orderinfo->OrderShippingAmount;
            $BasicCharges = $orderinfo->OrderShippingAmount;
            $voucher = '';
            $vat_exempt = $orderinfo->vat_exempt;
            $b_email = $orderinfo->Billingemail;

            if (isset($vat_exempt) and $vat_exempt == 'yes') {
                $amount = $amount / 1.2;
            }

            // NEW CODE FOR ORDER EDITOR
            if ($type == "partpayment") {
                $amount_received = $this->payment_recieved($orderNumber);
                $amount = $amount - $amount_received;
                $amount = number_format($amount, 2, '.', '');
            }
            $payment_taken = $amount;
            // NEW CODE FOR ORDER EDITOR
            $amount = $this->currecy_converter($amount, $orderinfo->currency);
            $symbol = $this->get_currecy_symbol($orderinfo->currency);

            $data_array = array('description' => "Payment Against Customer:" . $b_email,
                'total' => $amount,
                'currency' => $orderinfo->currency,
                'item_name' => "AA Labels Products",
                'cancel_url' => main_url . 'order_quotation/order/getOrderDetail/' . $orderNumber,
                'return_url' => main_url . 'order_quotation/order/getOrderDetail/' . $orderNumber,);
            $expressCheckoutdata = $this->rest_paypal->expressCheckoutdata($data_array);
            $access_token = $this->rest_paypal->getAccessToken();

            $this->session->set_userdata('access_token', $access_token);
            $paymentid = $this->rest_paypal->getPaymentID($access_token, $expressCheckoutdata);
            $response = array('response' => 200, 'paymentID' => $paymentid);
        }
        echo json_encode($response);
    }


    function capture_paypal_payment()
    {
        if ($_POST) {
            $PayerID = $this->input->post('PayerID');
            $paymentID = $this->input->post('paymentID');
            $invoice_no = $this->input->post('PayerOrderNumber');


            if (isset($PayerID) and $PayerID != '' and isset($paymentID) and $paymentID != '') {
                $sandbox_status = 'live'; //sandbox
                if (SITE_MODE == 'live') {
                    $sandbox_status = 'live';
                }
                $credentials = array('sandbox_status' => $sandbox_status);
                $this->load->library('rest_paypal', $credentials);
                $result = $this->rest_paypal->doPayment($paymentID, $PayerID, NULL);


                $logdata = "<pre>\r\n" . print_r($result, true) . '</pre>';
                $paypal_array = array('OrderNumber' => $invoice_no, 'PaypalStatus' => $logdata);
                $this->db->insert('paypal_status_debug', $paypal_array);

                if ($result['http_code'] == 200 || $result['http_code'] == 201) {
                    $state = $result['json']['transactions'][0]['related_resources'][0]['sale']['state']; //completed
                    $txn_id = $result['json']['id'];

                    //$oldstatus = $this->home_model->get_db_column('orders','OrderStatus', 'OrderNumber',$invoice_no);
                    if (isset($invoice_no) and $invoice_no != '') {

                        $reason_code = $result['json']['transactions'][0]['related_resources'][0]['sale']['reason_code']; //completed

                        if ($state == 'completed') {

                            $orderInfo = $this->shopping_model->order($invoice_no);
                            $amount = $orderInfo['OrderTotal'] + $orderInfo['OrderShippingAmount'];

                            if (isset($orderInfo['vat_exempt']) and $orderInfo['vat_exempt'] == 'yes') {
                                $amount = $amount / 1.2;
                            }

                            $array = array('type' => 'paypal',
                                'OrderNumber' => $invoice_no,
                                'payment' => $amount,
                                'operator' => $this->session->userdata('UserName'),
                                'time' => time());
                            $this->db->insert('order_payment_log', $array);


                            $this->db->where('OrderNumber', $invoice_no);
                            $this->db->update('orders', array('OrderStatus' => '32',
                                'YourRef' => $txn_id,
                                'Payment' => 1));
                        } else if ($state == 'pending' and $reason_code == 'ECHECK') {

                            $this->db->where('OrderNumber', $invoice_no);
                            $this->db->update('orders', array('OrderStatus' => '6',
                                'PaymentMethods' => 'PayPal eCheque',
                                'YourRef' => $txn_id,
                                'Payment' => 1));
                        }

                        redirect(main_url . 'order_quotation/order/getOrderDetail/' . $invoice_no);

                    }
                } else {

                    $this->session->set_userdata('worldpayerror', 'There is a problem to authorising the payment ');
                }
            } else {

                $this->session->set_userdata('worldpayerror', 'There is a problem to authorising the payment ');
                redirect(main_url . 'order_quotation/order/getOrderDetail/' . $invoice_no);
            }

        }

        redirect(main_url . 'Dashboard/');
    }


    public function update_configuration($AccountInfo)
    {
        if ($AccountInfo[0]->PaymentMethods != "purchaseOrder" && $AccountInfo[0]->PaymentMethods != "PayPal eCheque" && $AccountInfo[0]->OrderStatus != 7 && $AccountInfo[0]->OrderStatus != 8 && $AccountInfo[0]->OrderStatus != 6) {
             $total_amount_paid = $this->settingmodel->payment_recieved($AccountInfo[0]->OrderNumber);
             $total_amount_paid = number_format($total_amount_paid, 2, '.', ''); 
            
            
            
             $ship_invat = number_format($AccountInfo[0]->OrderTotal + $AccountInfo[0]->OrderShippingAmount, 2, '.', ''); 
            if ($AccountInfo[0]->vat_exempt == 'yes') {
                $ship_invat = number_format(($ship_invat / 1.2), 2, '.', '');
            }


            if ($total_amount_paid < $ship_invat) {
                $payable_amount = $ship_invat - $total_amount_paid;
                if ($AccountInfo[0]->OrderStatus != 78 && $AccountInfo[0]->OrderStatus != 27) {
                    $this->db->where('OrderNumber', $AccountInfo[0]->OrderNumber);
                    $this->db->update('orders', array('OrderStatus' => 78, 'Old_OrderStatus' => $AccountInfo[0]->OrderStatus));
                }
            } else if ($total_amount_paid > $ship_invat) {
                if ($AccountInfo[0]->Old_OrderStatus != '' && $AccountInfo[0]->OrderStatus == 78) {
                    $this->db->where('OrderNumber', $AccountInfo[0]->OrderNumber);
                    $this->db->update('orders', array('OrderStatus' => $AccountInfo[0]->Old_OrderStatus));
                }
            } else {
                if ($AccountInfo[0]->Old_OrderStatus != '' && $AccountInfo[0]->Old_OrderStatus != 6 && $AccountInfo[0]->Old_OrderStatus != 27) {
                    $this->db->where('OrderNumber', $AccountInfo[0]->OrderNumber);
                    $this->db->update('orders', array('OrderStatus' => $AccountInfo[0]->Old_OrderStatus));
                }
            }
        }
    }


    public function makeName()
    {

    }

    function amendment_setings()
    {
        $data['amendment_setings'] = $this->settingmodel->getAmendmentSettings();
        $data['main_content'] = 'order_quotation/order_detail/amendment_setting';
        $this->load->view('page', $data);
    }

    function change_orderAmendment_setting()
    {
        $id = $this->input->post('info');
        $setting = $this->input->post('setting');
        $field = $this->input->post('field');
        $this->settingmodel->updateAmendmentSettings(array('setting' => $setting, 'ID' => $id, 'field' => $field));
    }


    public function getAllCustomers()
    {

        $records = $this->customerModel->getAllCustomers();
        echo $records->generate();
    }

    public function chk_customer_session(){
        if($this->session->userdata('customer_id')){
            $json_data = array(
                'customer_id' => $this->session->userdata('customer_id')
            );
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($json_data));
        }else{
            $json_data = array(
                'customer_id' => ''
            );
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($json_data));
        }
    }
    public function getCustomerOrders()
    {
       
        $count = $var = filter_var($this->input->get('count'), FILTER_VALIDATE_INT);
        $start = filter_var($this->input->get('start'), FILTER_VALIDATE_INT);
        $this->session->set_userdata('userid', filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));
        $this->session->set_userdata('Order_person', filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));
        $this->session->set_userdata('customer_id', filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));
        $this->session->set_userdata('format', 'yes');
        $logarray = array('customerid' => filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));
        $this->home_model->save_logs('select_customer', $logarray);  //SAVE LOG
        
        $this->db->query("SET names utf8");
        $this->db->query("SET character_set_client = utf8");
        $this->db->query("SET CHARACTER SET utf8");
        

        $data['data']['customer'] = $this->customerModel->getCustomers(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));
        if ($data['data']['customer'][0]['on_hold'] != 'yes') {
            $data['data']['results'] = $this->orderModal->getCustomerOrders(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT), $count, $start);
            $totalCount = $this->orderModal->getCustomerTotalOrders(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT))[0];
            $data['data']['totalCount'] = $totalCount->totalOrder;
            $data['data']['orderHistory'] = $this->orderModal->getCustomersOrderHistory(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));

            $data['data']['spendToDate'] = $this->orderModal->getCustomersSpendToDate(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));

            $data['data']['sampleOrders'] = $this->orderModal->getCustomerSampleOrders(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));

            $data['data']['quotationConverted'] = $this->orderModal->getCustomerQuotationConverted(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));

            $data['data']['lifeTimeValue'] = $this->orderModal->getCustomerLifeTimeValue(filter_var($this->input->get('customerId'), FILTER_VALIDATE_INT));

            // $this->assignLinesToNewUsers($this->input->get('customerId'));

            $theHTMLResponse = $this->load->view('order_quotation/order_list', $data, true);

            $json_data = array('html' => $theHTMLResponse);

            $this->output->set_content_type('application/json');

            $this->output->set_output(json_encode($json_data));
        } else {
            $json_data = json_encode(array('on_hold' => 'yes'));
            $this->output->set_content_type('application/json');
            $this->output->set_output($json_data);
        }
    }

    public function assignLinesToNewUsers($customerId)
    {
        $orders = $this->cartModal->getLatestCartOrders();
        // echo '<pre>';
        //print_r($orders);exit;
        $customer = $this->customerModel->getCustomers($customerId)[0];
        //print_r($customer);exit;
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $order['UserID'] = $customerId;
                if ($customer['wholesale'] == 'wholesale' && $order['ProductBrand'] == 'Roll Labels' && $order['Printing'] == 'Y') {

                    $finalPrice = $this->getPriceForNewUser($order, $customerId);
                    $order['TotalPrice'] = $finalPrice['plainPrice'];
                    $order['Print_Total'] = $finalPrice['printPrice'];
                } elseif ($customer['wholesale'] != 'wholesale' && $order['ProductBrand'] == 'Roll Labels' && $order['Printing'] == 'Y') {
                    $finalPrice = $this->getPriceForNewUser($order, $customerId, 'no');
                    $order['TotalPrice'] = $finalPrice['plainPrice'];
                    $order['Print_Total'] = $finalPrice['printPrice'];
                }
                unset($order['ProductBrand']);
                unset($order['ManufactureID']);

                $this->db->where('ID', $order['ID']);
                $this->db->update('temporaryshoppingbasket', $order);
            }
        }

        return true;
    }

    public function getPriceForNewUser($record, $customerId, $conditon = null)
    {
        $params = array(
            'labeltype' => $record['Print_Type'],
            'labels' => ($record['Quantity'] * $record['LabelsPerRoll']),
            'design' => $record['Print_Design'],
            'menu' => $record['ManufactureID'],
            'persheets' => $record['LabelsPerRoll'],
            'producttype' => ($record['ProductBrand'] == 'Roll Labels') ? 'Rolls' : 'sheet',
            'pressproof' => $record['pressproof'],
            'finish' => $record['FinishType'],
            'brand' => $record['ProductBrand']
        );
        // print_r($params);exit;
        $record = $this->myPriceModel->calculatePrintedRollPrice($params);
        //  print_r($record);exit;
        if ($conditon == 'no') {
            $finalPrice = array(
                'plainPrice' => $record['plainprice'],
                'printPrice' => 0.00,
                'totalPrice' => ($record['plainprice'] + $record['designprice'] + $record['pressproof']));
            return $finalPrice;

        } else {
            $record = array(
                'plainPrice' => $record['plainprice'],
                'printPrice' => 0.00,
                'totalPrice' => ($record['plainprice'] + $record['designprice'] + $record['pressproof']));

            return $this->myPriceModel->checkForWholeSaleCustomer($record, $customerId, $params['producttype'], 'Y');
        }


    }


    public function getOrderProducts()
    {
        $data['orderinfo'] = $this->orderModal->OrderInfo($this->input->get('orderNumber'));
        $data['data']['products'] = $this->orderModal->getOrderProducts($this->input->get('orderNumber'));
        $theHTMLResponse = $this->load->view('order_quotation/order_product_list', $data, true);
        $json_data = array('html' => $theHTMLResponse);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($json_data));
    }

    public function printInvoice()
    {
        $this->orderModal->printInvoice($this->input->get('invoiceNumber'));
    }

    public function getPrice()
    {
        $this->myPriceModel->getPrice($this->input->get('orderNumber'), 'AAIL001WTP');
    }


    public function getProductsAllArtwork()
    {

        $cartId = filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT);
        // $cartId = $this->input->get('cartId');

        if ($cartId == null || $cartId == "") {

            $cartId = (isset($cartId) and $cartId != '') ? $cartId : time() . filter_var($this->input->get('productId'), FILTER_VALIDATE_INT);
            $records = $this->orderModal->getArtwork(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT));
            if (!empty($records)) {

                $cartId = $this->convertIntegratedTable($records, filter_var($this->input->get('productId'), FILTER_VALIDATE_INT));
            }
        }


        $data['data']['cal'] = $this->getProductCalculation(filter_var($this->input->get('productId'), FILTER_VALIDATE_INT), filter_var($this->input->get('manfactureId'), FILTER_SANITIZE_STRING));


        if ($this->input->get('page') == 'order_detail_page') {

            $data['data']['artworks'] = $this->orderModal->getArtworkByOrder(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT));
            $static['statics'] = $this->orderModal->countArtworkStatusFromOrderIntegrated(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT))[0];
            $data['data']['page'] = 'order_detail_page';
            $data['data']['rowKey'] = $this->input->get('rowKey');
            $resSend['price'] = '0.00';
            $resSend['count'] = $this->countArtworkFromOrderDetailByOrderNumber(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT), filter_var($this->input->get('brand'), FILTER_SANITIZE_STRING));
        } elseif (filter_var($this->input->get('page'), FILTER_SANITIZE_STRING) == 'quotaton_detail') {

            $data['data']['artworks'] = $this->orderModal->getArtworkForQuotation($this->input->get('serialNumber'));
            //print_r($data['data']['artworks']);exit;
            $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegrated(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT))[0];
            $data['data']['page'] = 'quotaton_detail';
            $data['data']['rowKey'] = filter_var($this->input->get('rowKey'), FILTER_VALIDATE_INT);
            $resSend['price'] = '0.00';
            $resSend['count'] = $this->countArtworkStatusFromQuotationIntegratedBYSerialNumber(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT), filter_var($this->input->get('brand'), FILTER_SANITIZE_STRING));
        } else {
            // echo 'df';exit;
            $data['data']['artworks'] = $this->orderModal->getTempArtworkTable($cartId);
            $static['statics'] = $this->orderModal->countArtworkStatus($cartId)[0];
            $data['data']['page'] = '';
            $data['data']['rowKey'] = '';
            $resSend['count'] = $this->countArtwork($cartId, filter_var($this->input->get('brand'), FILTER_SANITIZE_STRING));
            $resSend['price'] = (!empty($data['data']['artworks'])) ? $this->myPriceModel->getPrice(filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT), filter_var($this->input->get('orderNumber'), FILTER_SANITIZE_STRING), filter_var($this->input->get('manfactureId'), FILTER_SANITIZE_STRING), $static)['totalPrice'] : 0.00;
        }
        //print($resSend['price']);exit;
        $static['per_shet_roll'] = $data['data']['cal']['labelPerSheet'];

        $resSend['cartId'] = $cartId;

        $data['data']['cartId'] = $cartId;

        $data['data']['productId'] = filter_var($this->input->get('productId'), FILTER_VALIDATE_INT);

        $data['data']['serialNumber'] = filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT);

        $data['data']['orderNumber'] = filter_var($this->input->get('orderNumber'), FILTER_SANITIZE_STRING);

        $data['data']['manfactureId'] = filter_var($this->input->get('manfactureId'), FILTER_SANITIZE_STRING);

        $data['data']['checkoutArtwork'] = 'no';

        $data['data']['brand'] = filter_var($this->input->get('brand'), FILTER_SANITIZE_STRING);


        $this->session->set_userdata('rendCartId', $cartId);

        if (filter_var($this->input->get('brand'), FILTER_SANITIZE_STRING) === 'Roll Labels') {

            $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/first_artwork', $data);
        } else {

            $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/sheet_first_artwork', $data);
        }

        echo json_encode($resSend);


    }

    public function artworkForOrderDetailPage($serialNumber, $productId, $manfactureId, $orderNumber)
    {
        $data['data']['artworks'] = $this->orderModal->getArtworkByOrder($orderNumber);

        $data['data']['cartId'] = '';
        $data['data']['cal'] = $this->getProductCalculation($productId, $manfactureId);

        if ($this->input->get('brand') === 'Roll Labels') {
            $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/first_artwork', $data);
        } else {
            $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/sheet_first_artwork', $data);
        }
        echo json_encode($resSend);
    }

    public function getTempProductsArtworks()
    {

        $data['data']['artworks'] = $this->orderModal->getTempArtworkTable(filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT));

        $data['data']['cal'] = $this->getProductCalculation(filter_var($this->input->get('productId'), FILTER_VALIDATE_INT), filter_var($this->input->get('manfactureId'), FILTER_SANITIZE_STRING));
        $data['data']['productId'] = filter_var($this->input->get('productId'), FILTER_VALIDATE_INT);
        $data['data']['serialNumber'] = '';
        $data['data']['orderNumber'] = '';
        $data['data']['checkoutArtwork'] = 'yes';
        $data['data']['manfactureId'] = filter_var($this->input->get('manfactureId'), FILTER_SANITIZE_STRING);
        $data['data']['checkouttr'] = filter_var($this->input->get('checkouttr'), FILTER_VALIDATE_INT);
        $data['data']['brand'] = filter_var($this->input->get('brand'), FILTER_SANITIZE_STRING);
        $data['data']['page'] = '';
        $data['data']['rowKey'] = filter_var($this->input->get('checkouttr'), FILTER_VALIDATE_INT);
        $data['data']['cartId'] = filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT);

        $resSend['cartPrice'] = $this->orderModal->getCarPrice(filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT))[0]->price;
        //echo '<pre>';
        //print_r($data);exit;

        $resSend['cartId'] = filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT);
        if ($this->input->get('brand') === 'Roll Labels') {
            $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/first_artwork', $data);
        } else {

            $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/sheet_first_artwork', $data);
        }
        echo json_encode($resSend);
    }


    public function getOldArtwork()
    {
        $data['data']['records'] = $this->orderModal->getOldArtwork($this->input->post('customerId'));
        $resSend['html'] = $this->takeHtmlAndPrintData('order_quotation/artwork/old_arworks', $data);
        echo json_encode($resSend);
    }

    public function convertIntegratedTable($records, $productId)
    {
        $final = array();
        $cartId = $this->input->get('cartId');
        $cartId = (isset($cartId) and $cartId != '') ? $cartId : time() . $productId;

        foreach ($records as $record) {
            $final[] = array(
                'SessionID' => $this->session->userdata('session_id') . '-PRJB',
                'ProductID' => $record['ProductID'],
                'file' => $record['file'],
                'name' => $record['name'],
                'Thumb' => $record['Thumb'],
                'labels' => $record['labels'],
                'qty' => $record['qty'],
                'source' => 'printing',
                'type' => 'new',
                'CartID' => $cartId,
                'status' => 'confirm'
            );
        }

        $this->orderModal->insertBatch($final);
        return $cartId;
    }
    
    
    public function uploadArtwork()
    {

        $artwork = $this->input->post();
        $orderNumber = $this->input->post('orderNumber');
        $manfactureId = $this->input->post('manfactureId');
        $per_shet_roll = $this->input->post('per_shet_roll');
        $artworkID = $this->input->post('artworkID');
        $checkoutArtwork = $this->input->post('checkoutArtwork');
        $page = $this->input->post('page');
        $rowKey = $this->input->post('rowKey');
        $serialNumber = $this->input->post('serialNumber');

        $labelss = $this->input->post('labels');
        $qtys = $this->input->post('qty');
        $per_shet_roll = $labelss / $qtys;

        $condition = $this->input->post('condition');
        // when on checkout page you are going to upload artwork this condition will work

        if ($checkoutArtwork === 'yes') {
            $this->uploadCheckoutArtwork($artwork);
            return true;
        } else {

            unset($artwork['orderNumber']);
            unset($artwork['manfactureId']);
            unset($artwork['artworkID']);
            unset($artwork['checkoutArtwork']);
            unset($artwork['per_shet_roll']);
            unset($artwork['serialNumber']);
            unset($artwork['page']);
            unset($artwork['rowKey']);
            unset($artwork['brandName']);
            unset($artwork['condition']);

            if ($page == 'order_detail_page') {
                // if artwork is uploaded from order detail page
                $params = $this->orderModal->uploadArtworkInOrderIntegrated();
              
                if ($condition == 'update') {
                    $this->db->where('ID', $artworkID);
                    $latestArtworkId = $artworkID;
                } else {

                    if ($_FILES['file']['name'] != "") {
                        $params['file'] = $this->uploadImages('file');
                    }

                    $latestArtworkId = 0;
                    $latestArtworkId = $this->db->insert_id();
                }

                $count = $this->countArtworkFromOrderDetail($_POST['serialNumber'], $this->input->post('brandName'));
                $status = $this->orderModal->countArtworkStatusFromOrderAttach($_POST['serialNumber']);
                $static['statics'] = $this->orderModal->countArtworkStatusFromOrderAttach($_POST['serialNumber'])[0];
               
                $records['totalPrice'] = 0;
            } elseif ($page == 'quotaton_detail') {

                $params = $this->orderModal->uploadArtworkInQuotationIntegrated();
                $labelsPerSheet = $params['labelsPerSheet'];
                unset($params['labelsPerSheet']);

                if ($condition == 'update' && $condition != null) {
                    $this->db->where('ID', $artworkID);
                    $latestArtworkId = $artworkID;

                } else {

                    if ($_FILES['file']['name'] != "") {
                        $params['file'] = $this->uploadImages('file');
                    }
                    $latestArtworkId = 0;
                }

                $count = $this->countArtworkFromQuotationDetail($_POST['serialNumber'], $this->input->post('brandName'));
                $status = $this->orderModal->countArtworkStatusFromQuotationIntegrated($_POST['serialNumber']);
                $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegrated($_POST['serialNumber'])[0];
                $status['labelsPerSheet'] = $labelsPerSheet;
                $records['totalPrice'] = 0;

            } else {

                if ($artworkID != 'null') {
                    // if you updating the artwork
                    $previousArtwork = $this->orderModal->getArtworkIntegratedById($artworkID);

                    @$artwork['file'] = ($_FILES['file']['name'] != "") ? $this->uploadImages('file') : $previousArtwork[0]->file;

                    $artwork['SessionID'] = $previousArtwork[0]->SessionID;
                    $this->db->where('ID', $this->input->post('artworkID'));
                    $this->db->update('integrated_attachments', $artwork);
                    $count = $this->countArtwork($artwork['CartID'], $this->input->post('brandName'));
                    $status = $this->orderModal->countArtworkStatus($artwork['CartID']);
                    $latestArtworkId = $artworkID;

                } else {
                    if (@$_FILES['file']['name'] != "" || @$_FILES['file']['name'] != null) {
                        $artwork['file'] = $this->uploadImages('file');
                    }
                    $artwork['SessionID'] = $this->session->userdata('session_id') . '-PRJB';
                    $this->db->insert('integrated_attachments', $artwork);

                    $latestArtworkId = $this->db->insert_id();
                    $count = $this->countArtwork($artwork['CartID'], $this->input->post('brandName'));
                    $status = $this->orderModal->countArtworkStatus($artwork['CartID']);
                }

                $static['statics'] = $this->orderModal->countArtworkStatus($artwork['CartID'])[0];
                $static['per_shet_roll'] = $per_shet_roll;
                $records = $this->myPriceModel->getPrice($serialNumber, $orderNumber, $manfactureId, $static);
            }

            echo json_encode(
                array('response' => 'yes',
                    'count' => $count,
                    'price' => $records['totalPrice'],
                    'statics' => $status,
                    'latestArtworkId' => $latestArtworkId,
                    'elsePrice' => $records,
                ));
        }
    }

    public function uploadArtwork_old()
    {

        $artwork = $this->input->post();
        $orderNumber = $this->input->post('orderNumber');
        $manfactureId = $this->input->post('manfactureId');
        $per_shet_roll = $this->input->post('per_shet_roll');
        $artworkID = $this->input->post('artworkID');
        $checkoutArtwork = $this->input->post('checkoutArtwork');
        $page = $this->input->post('page');
        $rowKey = $this->input->post('rowKey');
        $serialNumber = $this->input->post('serialNumber');

        $labelss = $this->input->post('labels');
        $qtys = $this->input->post('qty');
        $per_shet_roll = $labelss / $qtys;

        $condition = $this->input->post('condition');
        // when on checkout page you are going to upload artwork this condition will work


        if ($checkoutArtwork === 'yes') {
            $this->uploadCheckoutArtwork($artwork);
            return true;
        } else {

            unset($artwork['orderNumber']);
            unset($artwork['manfactureId']);
            unset($artwork['artworkID']);
            unset($artwork['checkoutArtwork']);
            unset($artwork['per_shet_roll']);
            unset($artwork['serialNumber']);
            unset($artwork['page']);
            unset($artwork['rowKey']);
            unset($artwork['brandName']);
            unset($artwork['condition']);

            if ($page == 'order_detail_page') {
                // if artwork is uploaded from order detail page
                $params = $this->orderModal->uploadArtworkInOrderIntegrated();
                if ($condition == 'update') {
                    $this->db->where('ID', $artworkID);
                    $this->db->update('order_attachments_integrated', $params);
                    $latestArtworkId = $artworkID;
                } else {

                    if ($_FILES['file']['name'] != "") {
                        $params['file'] = $this->uploadImages('file');
                    }

                    $this->db->insert('order_attachments_integrated', $params);
                    $latestArtworkId = $this->db->insert_id();
                }

                $count = $this->countArtworkFromOrderDetail($_POST['serialNumber'], $this->input->post('brandName'));
                $status = $this->orderModal->countArtworkStatusFromOrderAttach($_POST['serialNumber']);
                $static['statics'] = $this->orderModal->countArtworkStatusFromOrderAttach($_POST['serialNumber'])[0];
                //$static['per_shet_roll'] = $per_shet_roll;
                //$records = $this->myPriceModel->getPrice($orderNumber,$manfactureId,$static);
                //$static['price'] = $records['price'];
                $records['totalPrice'] = 0;
                $this->orderModal->updateIntoOrderDetailTable($static);
            } elseif ($page == 'quotaton_detail') {

                $params = $this->orderModal->uploadArtworkInQuotationIntegrated();
                $labelsPerSheet = $params['labelsPerSheet'];
                unset($params['labelsPerSheet']);

                if ($condition == 'update' && $condition != null) {
                    $this->db->where('ID', $artworkID);
                    $this->db->update('quotation_attachments_integrated', $params);
                    $latestArtworkId = $artworkID;

                } else {

                    if ($_FILES['file']['name'] != "") {
                        $params['file'] = $this->uploadImages('file');
                    }

                    $this->db->insert('quotation_attachments_integrated', $params);
                    $latestArtworkId = $this->db->insert_id();
                }

                $count = $this->countArtworkFromQuotationDetail($_POST['serialNumber'], $this->input->post('brandName'));
                $status = $this->orderModal->countArtworkStatusFromQuotationIntegrated($_POST['serialNumber']);
                $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegrated($_POST['serialNumber'])[0];
                $status['labelsPerSheet'] = $labelsPerSheet;
                $records['totalPrice'] = 0;
                $this->orderModal->updateIntoQuotatonDetailTable($static);

            } else {

                if ($artworkID != 'null') {
                    // if you updating the artwork
                    $previousArtwork = $this->orderModal->getArtworkIntegratedById($artworkID);

                    @$artwork['file'] = ($_FILES['file']['name'] != "") ? $this->uploadImages('file') : $previousArtwork[0]->file;

                    $artwork['SessionID'] = $previousArtwork[0]->SessionID;
                    $this->db->where('ID', $this->input->post('artworkID'));
                    $this->db->update('integrated_attachments', $artwork);
                    $count = $this->countArtwork($artwork['CartID'], $this->input->post('brandName'));
                    $status = $this->orderModal->countArtworkStatus($artwork['CartID']);
                    $latestArtworkId = $artworkID;

                } else {
                    //$artwork['file'] = $this->uploadImages('file');
                    if (@$_FILES['file']['name'] != "" || @$_FILES['file']['name'] != null) {
                        $artwork['file'] = $this->uploadImages('file');
                    }
                    $artwork['SessionID'] = $this->session->userdata('session_id') . '-PRJB';
                    //print_r($artwork);exit;
                    $this->db->insert('integrated_attachments', $artwork);

                    $latestArtworkId = $this->db->insert_id();
                    //print_r($latestArtworkId);exit;
                    $count = $this->countArtwork($artwork['CartID'], $this->input->post('brandName'));
                    $status = $this->orderModal->countArtworkStatus($artwork['CartID']);
                }

                $static['statics'] = $this->orderModal->countArtworkStatus($artwork['CartID'])[0];
                $static['per_shet_roll'] = $per_shet_roll;
                //print_r($latestArtworkId);exit;
                $records = $this->myPriceModel->getPrice($serialNumber, $orderNumber, $manfactureId, $static);
            }

            echo json_encode(
                array('response' => 'yes',
                    'count' => $count,
                    'price' => $records['totalPrice'],
                    'statics' => $status,
                    'latestArtworkId' => $latestArtworkId,
                    'elsePrice' => $records,
                ));
        }
    }


    public function uploadCheckoutArtwork($artwork)
    {

        $manfactureId = $this->input->post('manfactureId');
        $branName = $artwork['brandName'];
        unset($artwork['orderNumber']);
        unset($artwork['manfactureId']);
        unset($artwork['artworkID']);
        unset($artwork['checkoutArtwork']);
        unset($artwork['serialNumber']);
        unset($artwork['per_shet_roll']);
        unset($artwork['page']);
        unset($artwork['brandName']);
        unset($artwork['rowKey']);
        unset($artwork['condition']);
        unset($artwork['customerId']);
        unset($artwork['file']);


        if (!empty($_FILES['file']['name'])) {
            $artwork['file'] = $this->uploadImages('file');
        }

        $artwork['SessionID'] = $this->session->userdata('session_id');
        /*echo '<pre>';
        print_r($artwork);
        exit;*/

        if ($this->input->post('condition') == 'update') {
            $this->db->where('ID', $this->input->post('artworkID'));
            //$this->db->update('integrated_attachments', $artwork);
            $latestArtworkId = $this->input->post('artworkID');
        } else {
            //$this->db->insert('integrated_attachments', $artwork);
            //$latestArtworkId = $this->db->insert_id();
            $latestArtworkId = 0;
        }

        $artworkID1 = $this->input->post('artworkID');
        if($this->input->post('artworkID') > 0){
            $artworkID = $this->input->post('artworkID');
        }else{
            $artworkID = 0;
        }
        //print_r($artworkID); exit;
        $static['statics'] = $this->orderModal->countArtworkStatus($artwork['CartID'])[0];
        $record = $this->getRecord($this->input->post('ProductID'));
        $cartRecord = $this->orderModal->getCartById($artwork['CartID']);

        $record->Printing = $cartRecord->Printing;
        $record->Print_Type = $cartRecord->Print_Type;
        $record->Print_Design = $cartRecord->Print_Design;
        $record->pressproof = $cartRecord->pressproof;
        $record->FinishType = $cartRecord->FinishType;
        $record->ManufactureID = $manfactureId;


        $stat = $this->orderModal->countArtworkStatusNew($artwork['CartID'], $artworkID);
        $stat[0]->totalQuantity = $stat[0]->totalQuantity + $artwork['qty'];
        $stat[0]->totalLabels = $stat[0]->totalLabels + $artwork['labels'];
        $stat[0]->count = $stat[0]->count + 1;
        //print_r($record);exit;
        echo json_encode(array('response' => 'yes',
            'count' => $this->countArtwork($artwork['CartID'], $branName),
            //'price'=>$this->myPriceModel->makeParamAndGetRecord($record,$static)['price'],
            'latestArtworkId' => $latestArtworkId,
            'price' => 0.00,
            'statics' => $stat,
            'artwork_data' => $artwork
        ));

        return true;
    }


    public function uploadCheckoutArtwork_old($artwork)
    {

        $manfactureId = $this->input->post('manfactureId');
        $branName = $artwork['brandName'];
        unset($artwork['orderNumber']);
        unset($artwork['manfactureId']);
        unset($artwork['artworkID']);
        unset($artwork['checkoutArtwork']);
        unset($artwork['serialNumber']);
        unset($artwork['per_shet_roll']);
        unset($artwork['page']);
        unset($artwork['brandName']);
        unset($artwork['rowKey']);
        unset($artwork['condition']);
        unset($artwork['customerId']);
        unset($artwork['file']);


        if (!empty($_FILES['file']['name'])) {
            $artwork['file'] = $this->uploadImages('file');
        }

        $artwork['SessionID'] = $this->session->userdata('session_id');
        //echo '<pre>';
        ///print_r($artwork);
        if ($this->input->post('condition') == 'update') {
            $this->db->where('ID', $this->input->post('artworkID'));
            $this->db->update('integrated_attachments', $artwork);
            $latestArtworkId = $this->input->post('artworkID');
        } else {
            $this->db->insert('integrated_attachments', $artwork);
            $latestArtworkId = $this->db->insert_id();
            //print_r($this->db->error());exit;
        }

        $static['statics'] = $this->orderModal->countArtworkStatus($artwork['CartID'])[0];
        $record = $this->getRecord($this->input->post('ProductID'));
        $cartRecord = $this->orderModal->getCartById($artwork['CartID']);

        $record->Printing = $cartRecord->Printing;
        $record->Print_Type = $cartRecord->Print_Type;
        $record->Print_Design = $cartRecord->Print_Design;
        $record->pressproof = $cartRecord->pressproof;
        $record->FinishType = $cartRecord->FinishType;
        $record->ManufactureID = $manfactureId;
        //print_r($record);exit;
        echo json_encode(array('response' => 'yes',
            'count' => $this->countArtwork($artwork['CartID'], $branName),
            //'price'=>$this->myPriceModel->makeParamAndGetRecord($record,$static)['price'],
            'latestArtworkId' => $latestArtworkId,
            'price' => 0.00,
            'statics' => $this->orderModal->countArtworkStatus($artwork['CartID'])
        ));

        return true;
    }
    
    
    
    

//    public function changeLineType(){
//        if($this->input->get('productBrand') == 'Roll Labels' || $this->input->get('productBrand') != 'Roll Labels'  && $this->input->get('printing') =='Y' ){
//            $this->changeLineToPrintOrPlain();
//        }else{
//            $record = array('ProductBrand'=>$this->input->get('brand'),'Printing'=>$this->input->get('printing'));
//            $data = array('qty'=>$this->input->get('qty'),'manfactureId'=>$this->input->get('manufactureId'));
//            $values['price'] = $this->myPriceModel->makeParamAndGetRecord((object)$record,$data)['price'];
//            $this->cartModal->updateCart($this->input->get('cartId'),['Printing'=>$this->input->get('printing'),'Quantity'=>$data['qty'],'orignalQty'=>$data['qty'],'TotalPrice'=>$values['price'],'UnitPrice'=>($values['price']/$data['qty'])]);
//            $values['cartPrice'] = $this->cartModal->getCarTotalPrice();
//            echo json_encode($values);
//        }
//
//    }
    public function changeLine()
    {
        $cartId = filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT);
        $printing = filter_var($this->input->get('printing'), FILTER_SANITIZE_STRING);


        $array = array('Printing' => $printing);
        if ($printing == "N") {
            $array = array_merge($array, array('Print_UnitPrice' => 0, 'Print_Total' => 0));
        }

        $this->db->where('ID', $cartId);
        $this->db->update('temporaryshoppingbasket', $array);
        echo true;
    }


    public function changeLineToPrintOrPlain()
    {
        //echo '<pre>';
        //print_r($_POST);exit;
        $this->orderModal->updateCartDetail();

        $record = $this->getPriceForCart();
    }

    function getPriceForCart()
    {

        if ($_POST['printing'] == 'Y' || $_POST['printing'] == 'Yes') {

            if ($_POST['regmark'] == 'Y') {

                $params = array(
                    'labeltype' => $_POST['digital'],
                    'labels' => $_POST['qty'] * $_POST['labelperRoll'],
                    'design' => 1,
                    'menu' => $_POST['manfectureId'],
                    'persheets' => $_POST['labelPerSheet'],
                    'producttype' => ($_POST['brand'] == 'Roll Labels') ? 'Rolls' : 'sheet',
                    'pressproof' => 0,
                    'finish' => 'No Finish',
                    'brand' => $_POST['brand'],
                    'printing' => $_POST['printing'],
                    'customerId' => $_POST['customerId'],
                    'cartId' => $_POST['cartId'],
                    'qty' => $_POST['qty'],
                    'max_lbl' => $_POST['labelPerSheet']
                );
            }else{
                $params = array(
                    'labeltype' => $_POST['digital'],
                    'labels' => $_POST['qty'] * $_POST['labelperRoll'],
                    'design' => $_POST['design'],
                    'menu' => $_POST['manfectureId'],
                    'persheets' => $_POST['labelperRoll'],
                    'producttype' => ($_POST['brand'] == 'Roll Labels') ? 'Rolls' : 'sheet',
                    'pressproof' => $_POST['pressproof'],
                    'finish' => (isset($_POST['finish'])) ? $_POST['finish'] : '',
                    'brand' => $_POST['brand'],
                    'printing' => $_POST['printing'],
                    'customerId' => $_POST['customerId'],
                    'cartId' => $_POST['cartId'],
                    'qty' => $_POST['qty'],
                    'max_lbl' => $_POST['labelPerSheet']

                );


            }


        } else {
            $lpr_updated = ($_POST['brand'] == 'Roll Labels') ? $_POST['labelperRoll'] : $_POST['qty'] * $_POST['labelperRoll'];

            $params = array(
                'printing' => $_POST['printing'],
                'brand' => $_POST['brand'],
                'qty' => $_POST['qty'],
                'manfactureId' => $_POST['manfectureId'],
                'rolls' => $_POST['qty'],
                'labels' => $lpr_updated,
                'labelsPerSheet' => $_POST['labelperRoll'],
                'cartId' => $_POST['cartId'],
                'qty' => $_POST['qty']

            );
        }


        $price = $this->myPriceModel->getPriceForCart($params, $_POST['productId']);
        //print_r($price);exit;

        $priceParams = array(
            'TotalPrice' => $price['plainPrice'],
            'UnitPrice' => number_format($_POST['qty'] / $price['plainPrice'], 2),
            'Print_Total' => $price['printPrice'],
            'Print_UnitPrice' => number_format($_POST['qty'] / $price['plainPrice'], 2,'.',''),

        );
        
        $mattpe = ($_POST['brand'] == 'Roll Labels') ? 'Roll' : 'A4';
        
        if( ($mattpe =='Roll' && $_POST['printing'] != 'Y') || ($mattpe =='A4') ){

            $m_codes = ($mattpe ==Roll) ? substr($_POST['manfectureId'], 0,-1):$_POST['manfectureId'];
            $material_code = $this->home_model->getmaterialcode($m_codes);

            $material_discount = $this->home_model->check_material_discount($material_code, $mattpe);
            if ($material_discount != null) {
                $disRate = ($priceParams['TotalPrice'] * $material_discount) / 100;
                $priceParams['TotalPrice'] = number_format($priceParams['TotalPrice'] - $disRate, 2,'.','');
            }
        }
        
       
        $this->db->where('ID', $_POST['cartId']);
        $this->db->update('temporaryshoppingbasket', $priceParams);

        echo true;
    }

    public function updateIntegrated()
    {
        $product = $this->getRecord($this->input->get('ProductID'));
        $record = array('ProductName' => $product->ProductName, 'ProductBrand' => $this->input->get('brand'), 'Printing' => $this->input->get('printing'));
        $data = array('qty' => $this->input->get('qty'), 'manfactureId' => $this->input->get('manufactureId'));
        $values['price'] = $this->myPriceModel->makeParamAndGetRecord((object)$record, $data)['price'];
        $this->cartModal->updateCart($this->input->get('cartId'), ['Printing' => $this->input->get('printing'), 'Quantity' => $data['qty'], 'orignalQty' => $data['qty'], 'TotalPrice' => $values['price'], 'UnitPrice' => ($values['price'] / $data['qty'])]);
        $values['cartPrice'] = $this->cartModal->getCarTotalPrice();
        echo json_encode($values);
    }

    public function getRecord($productID)
    {
        $results = $this->db->select("p.ProductBrand,p.LabelsPerSheet,ProductName")
            ->from('products as p')
            ->where('p.ProductID', $productID)
            ->get()->row();
        return $results;
    }

    public function countArtwork($cartId, $brandName = null)
    {
        $data = $this->orderModal->countArtworkStatus($cartId);
        $brandName = ($brandName == 'Roll Labels') ? 'Roll' : 'Sheet';

        if ($data[0]->count == 0) {
            return '0 Design, 0 Labels on 0 ' . $brandName;
        } else {
            return $data[0]->count . ' Design, ' . $data[0]->totalLabels . ' Labels on ' . $data[0]->totalQuantity . ' ' . $brandName;
        }

    }

    public function countArtworkFromOrderDetail($orderNumber, $brandName)
    {
        $data = $this->orderModal->countArtworkStatusFromOrderAttach($orderNumber);
        $brandName = ($brandName == 'Roll Labels') ? 'Roll' : 'Sheet';
        if ($data[0]->count == 0) {
            return '0 Design, 0 Labels on 0 ' . $brandName;
        } else {
            return $data[0]->count . ' Design, ' . $data[0]->totalLabels . ' Labels on ' . $data[0]->totalQuantity . ' ' . $brandName;
        }

    }

    public function countArtworkFromQuotationDetail($serialNumber, $brandName)
    {
        $data = $this->orderModal->countArtworkStatusFromQuotationIntegrated($serialNumber);
        $brandName = ($brandName == 'Roll Labels') ? 'Roll' : 'Sheet';
        if ($data[0]->count == 0) {
            return '0 Design, 0 Labels on 0 ' . $brandName;
        } else {
            return $data[0]->count . ' Design, ' . $data[0]->totalLabels . ' Labels on ' . $data[0]->totalQuantity . ' ' . $brandName;
        }

    }

    public function countArtworkFromQuotationDetailByQuotationNumber($serialNumber, $brandName)
    {
        $data = $this->orderModal->countArtworkStatusFromQuotationIntegratedBYQuotationNumber($serialNumber);
        $brandName = ($brandName == 'Roll Labels') ? 'Roll' : 'Sheet';
        if ($data[0]->count == 0) {
            return '0 Design, 0 Labels on 0 ' . $brandName;
        } else {
            return $data[0]->count . ' Design, ' . $data[0]->totalLabels . ' Labels on ' . $data[0]->totalQuantity . ' ' . $brandName;
        }

    }

    public function countArtworkStatusFromQuotationIntegratedBYSerialNumber($serialNumber, $brandName)
    {
        $data = $this->orderModal->countArtworkStatusFromQuotationIntegratedBYSerialNumber($serialNumber);
        $brandName = ($brandName == 'Roll Labels') ? 'Roll' : 'Sheet';
        if ($data[0]->count == 0) {
            return '0 Design, 0 Labels on 0 ' . $brandName;
        } else {
            return $data[0]->count . ' Design, ' . $data[0]->totalLabels . ' Labels on ' . $data[0]->totalQuantity . ' ' . $brandName;
        }

    }

    public function countArtworkFromOrderDetailByOrderNumber($serialNumber, $brandName)
    {
        $data = $this->orderModal->countArtworkStatusFromOrderAttachMentBYSerialNumber($serialNumber);
        $brandName = ($brandName == 'Roll Labels') ? 'Roll' : 'Sheet';
        if ($data[0]->count == 0) {
            return '0 Design, 0 Labels on 0 ' . $brandName;
        } else {
            return $data[0]->count . ' Design, ' . $data[0]->totalLabels . ' Labels on ' . $data[0]->totalQuantity . ' ' . $brandName;
        }

    }

    public function convertFromOldToNewArtwork()
    {

        $serialNumber = $this->input->post('serialNumber');
        $artworkId = $this->input->post('artworkId');
        $productId = $this->input->post('productId');
        $orderNumber = $this->input->post('orderNumber');
        $manfactureId = $this->input->post('manfactureId');
        $cartId = $this->input->post('cartId');
        $pageName = $this->input->post('pageName');
        $ordNumber = $this->input->post('ordNumber');
        $custId = $this->input->post('custId');
        $brand = $this->input->post('brand');

        $artwork = $this->orderModal->getArtworkById($artworkId);
        //echo '<pre>'; print_r($artwork); echo '</pre>';
        $insertedData = $this->mapToTable($artwork[0], $cartId, $pageName, $ordNumber, $custId, $serialNumber);

        if ($pageName == 'order') {
            $static['statics'] = $status = $this->orderModal->countArtworkStatusFromOrderAttach($serialNumber)[0];
            $count = $this->countArtworkFromOrderDetail($serialNumber, $brand);
        } else if ($pageName == 'quotation') {
            $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegrated($serialNumber)[0];
            $count = $this->countArtworkFromQuotationDetail($serialNumber, $brand);
        } else {

            $previousArtwork = $this->orderModal->getArtworkIntegratedById($artworkId);

            $artworks['file'] = (@$_FILES['file']['name'] != "") ? $this->uploadImages('file') : $previousArtwork[0]->file;
            $artworks['SessionID'] = $previousArtwork[0]->SessionID;
            //echo '<pre>'; print_r($artwork); echo '</pre>';

            $this->db->where('ID', $this->input->post('artworkId'));
            $this->db->update('integrated_attachments', $artworks);

            $static['statics'] = $this->orderModal->countArtworkStatus($cartId)[0];
            $count = $this->countArtwork($cartId);
        }

        //print_r($insertedData);
        //print_r($count);
        //print_r($static['statics']);exit;
        echo json_encode(
            array('data' => $insertedData, 'count' => $count, 'statics' => $static['statics'], 'latestArtworkId' => $this->input->post('artworkId'))
        );

    }

    public function mapToTable($record, $cartId, $pageName, $ordNumber, $custId, $serialNumber)
    {

        $orderDetailInfo = $this->orderModal->getOrderDetailBySerialNumber($serialNumber);

        if ($pageName == 'order') {

            $record['UserID'] = $custId;
            $record['OrderNumber'] = $ordNumber;
            $record['Serial'] = $serialNumber;
            $record['ProductID'] = $this->input->post('productId');
            $record['diecode'] = $orderDetailInfo->ManufactureID;


            unset($record['ID']);
            $this->db->insert('order_attachments_integrated', $record);

            $record['page'] = "'" . 'order_detail_page' . "'";
            $record['method'] = "'" . 'update' . "'";
            $record['ID'] = $this->db->insert_id();
            $record['file'] = 'https://www.aalabels.com/theme/integrated_attach/' . $record['file'];
            return $record;


        } else if ($pageName == 'quotation') {

            $orderDetail = $this->orderModal->getQuotationDetailBySerialNumber($serialNumber);

            $params = array('QuotationNumber' => $this->input->post('orderNumber')
            , 'file' => $record['file']
            , 'Serial' => $this->input->post('serialNumber')
            , 'ProductID' => $record['ProductID']
            , 'diecode' => $this->input->post('manfactureId')
            , 'name' => $record['name']
            , 'qty' => $record['qty']
            , 'labels' => $record['labels']
            , 'design_type' => $orderDetail->Print_Type
            , 'Date' => date('Y-m-d h:m:s')
            , 'status' => 64
            , 'source' => $this->session->userdata('UserName')
            , 'labelsPerSheet' => $orderDetail->LabelsPerSheet
            );

            $labelsPerSheet = $params['labelsPerSheet'];
            unset($params['labelsPerSheet']);


            /*if($_FILES['file']['name'] !=""){
                $params['file'] = $this->uploadImages('file');
            }*/

            $this->db->insert('quotation_attachments_integrated', $params);
            $latestArtworkId = $this->db->insert_id();

            $record['page'] = "'" . 'quotation_detail' . "'";
            $record['method'] = "'" . 'update' . "'";
            $record['ID'] = $latestArtworkId;
            $record['file'] = 'https://www.aalabels.com/theme/integrated_attach/' . $record['file'];
            return $record;
        } else {
            $final = array(
                'SessionID' => $this->session->userdata('session_id'),
                'ProductID' => $record['ProductID'],
                'file' => $record['file'],
                'name' => $record['name'],
                'Thumb' => $record['Thumb'],
                'labels' => $record['labels'],
                'qty' => $record['qty'],
                'source' => 'printing',
                'type' => 'new',
                'CartID' => $cartId,
                'status' => 'confirm'
            );

            $this->db->insert('integrated_attachments', $final);

            $final['ID'] = $this->db->insert_id();
            $final['file'] = 'https://www.aalabels.com/theme/integrated_attach/' . $final['file'];
            return $final;
        }

    }
    
    
    
        public function deleteArtwork()
    {
        $cartId = $this->input->post('cartId');
        $orderNumber = $this->input->post('orderNumber');
        $artworkSerialNumber = $this->input->post('artworkSerialNumber');
        $manfactureId = $this->input->post('manfactureId');
        $page = $this->input->post('page');

        $status = $this->orderModal->countArtworkStatus($this->input->post('artworkId'));

        $orderDetail = $this->orderModal->getOrderDetail($orderNumber);
        $quotationDetail = $this->orderModal->getQuotationDetail($orderNumber);


        if ($page == "quotaton_detail") {

            $this->orderModal->deleteArtworkForQuotation($this->input->post('artworkId'));

            $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegratedBYSerialNumber($artworkSerialNumber)[0];

            echo json_encode(array(
                'response' => 'yes',
                'statics' => $static['statics'],
                'count' => $this->countArtworkStatusFromQuotationIntegratedBYSerialNumber($artworkSerialNumber, $quotationDetail[0]->ProductBrand),
                'price' => 0.00));
            return true;
        } elseif ($page == "order_detail_page") {

            $this->orderModal->deleteArtworkForOrder($this->input->post('artworkId'));
            $static['statics'] = $this->orderModal->countArtworkStatusFromOrderAttachMentBYSerialNumber($artworkSerialNumber)[0];
            $qu_pr = $this->db->last_query();

            if ($artworkSerialNumber != "") {
                /*$orderDetailsss['labels'] = $static['statics']->totalLabels;

                $this->db->where('SerialNumber',$artworkSerialNumber);
                $this->db->update('orderdetails',$orderDetailsss);*/
            }


            echo json_encode(array(
                'response' => 'yes',
                'statics' => $static['statics'],
                'count' => $this->countArtworkFromOrderDetailByOrderNumber($artworkSerialNumber, $orderDetail[0]->ProductBrand),
                'price' => 0.00,
                'query' => $qu_pr));
            return true;
        } elseif ($this->input->post('artworkId') == "" || $this->input->post('artworkId') == null) {
            $this->orderModal->deleteArtworkByCart($cartId);
        } else {

            $this->orderModal->deleteArtwork($this->input->post('artworkId'));
            $static['statics'] = $this->orderModal->countArtworkStatus($cartId)[0];
            echo json_encode(array('response' => 'yes', 'count' => $this->countArtwork($cartId),
                'price' => 0.00, 'statics' => $static['statics']));
            return true;
        }

        //print_r($status);
        $static['statics'] = $this->orderModal->countArtworkStatus($cartId)[0];
        //print_r($static['statics']);exit;
        echo json_encode(array('response' => 'yes', 'count' => $this->countArtwork($cartId),
            'price' => ($static['statics']->count > 0) ? ($this->myPriceModel->getPrice($orderNumber, $manfactureId, $static)['totalPrice']) : ('0.00')));
    }
    

    public function deleteArtwork_old()
    {
        $cartId = $this->input->post('cartId');
        $orderNumber = $this->input->post('orderNumber');
        $artworkSerialNumber = $this->input->post('artworkSerialNumber');
        $manfactureId = $this->input->post('manfactureId');
        $page = $this->input->post('page');

        $status = $this->orderModal->countArtworkStatus($this->input->post('artworkId'));

        $orderDetail = $this->orderModal->getOrderDetail($orderNumber);
        $quotationDetail = $this->orderModal->getQuotationDetail($orderNumber);


        if ($page == "quotaton_detail") {

            $this->orderModal->deleteArtworkForQuotation($this->input->post('artworkId'));

            $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegratedBYSerialNumber($artworkSerialNumber)[0];

            echo json_encode(array(
                'response' => 'yes',
                'statics' => $static['statics'],
                'count' => $this->countArtworkStatusFromQuotationIntegratedBYSerialNumber($artworkSerialNumber, $quotationDetail[0]->ProductBrand),
                'price' => 0.00));
            return true;
        } elseif ($page == "order_detail_page") {

            $this->orderModal->deleteArtworkForOrder($this->input->post('artworkId'));
            $static['statics'] = $this->orderModal->countArtworkStatusFromOrderAttachMentBYSerialNumber($artworkSerialNumber)[0];
            $qu_pr = $this->db->last_query();

            if ($artworkSerialNumber != "") {
                /*$orderDetailsss['labels'] = $static['statics']->totalLabels;

                $this->db->where('SerialNumber',$artworkSerialNumber);
                $this->db->update('orderdetails',$orderDetailsss);*/
            }


            echo json_encode(array(
                'response' => 'yes',
                'statics' => $static['statics'],
                'count' => $this->countArtworkFromOrderDetailByOrderNumber($artworkSerialNumber, $orderDetail[0]->ProductBrand),
                'price' => 0.00,
                'query' => $qu_pr));
            return true;
        } elseif ($this->input->post('artworkId') == "" || $this->input->post('artworkId') == null) {
            $this->orderModal->deleteArtworkByCart($cartId);
        } else {

            $this->orderModal->deleteArtwork($this->input->post('artworkId'));
            echo json_encode(array('response' => 'yes', 'count' => $this->countArtwork($cartId),
                'price' => 0.00));
            return true;
        }

        //print_r($status);
        $static['statics'] = $this->orderModal->countArtworkStatus($cartId)[0];
        //print_r($static['statics']);exit;
        echo json_encode(array('response' => 'yes', 'count' => $this->countArtwork($cartId),
            'price' => ($static['statics']->count > 0) ? ($this->myPriceModel->getPrice($orderNumber, $manfactureId, $static)['totalPrice']) : ('0.00')));
    }


    public function getCheckoutPrice()
    {
        $record = array('ProductBrand' => $this->input->get('brand'), 'Printing' => $this->input->get('printing'));
        $data = array('qty' => $this->input->get('qty'), 'manfactureId' => $this->input->get('manufactureId'));
        $values['price'] = $this->myPriceModel->makeParamAndGetRecord((object)$record, $data)['price'];
        $this->cartModal->updateCart($this->input->get('cartId'), ['Quantity' => $data['qty'], 'orignalQty' => $data['qty'], 'TotalPrice' => $values['price'], 'UnitPrice' => ($values['price'] / $data['qty'])]);
        $values['cartPrice'] = $this->cartModal->getCarTotalPrice();
        echo json_encode($values);

    }


    public function saveQuotation()
    {

        $quotation = $this->quotationModal->saveQuotation();

        //$data['quotation'] = $this->quotationModal->getQuotation($quotation['QuotationNumber']);
        //$data['quotationDetails'] = $this->quotationModal->getQuotationDetail($quotation['QuotationNumber']);
        $respon['q_n'] = $quotation['QuotationNumber'];

        //$respon['html']  = $this->takeHtmlAndPrintData('order_quotation/checkout/confirm_my_quotation',$data);
        $this->session->unset_userdata("userid");
        $this->session->unset_userdata('payment_redirection');
        $respon['response'] = 'true';

        echo json_encode($respon);

    }

    function quotationconfirmaion($quotenumber)
    {
        $data['quotation'] = $this->quotationModal->getQuotation($quotenumber);
        $data['quotationDetails'] = $this->quotationModal->getQuotationDetail($quotenumber);
        $data['main_content'] = 'order_quotation/checkout/confirm_my_quotation';
        $this->load->view('page', $data);
    }

    public function sendEmail()
    {
        //echo  $this->EmailModal->sendQuotationEmail($this->input->post('quotationNumber'));
        //if(MODE == 'live'){
        $q_n = $this->input->post('quotationNumber');
        $this->sendEmailForPayPol($q_n);
        //}

        //$this->orderModal->order_confirmation_new($OrderNo);
        //	  $this->orderModal->order_confirmation_email($OrderNo="AA199410");


    }

    function sendEmailForPayPol($quotationiNumber)
    {

        $currency_options = $this->cartModal->get_currecy_options();
        $currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

        $symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
        $exchange_rate = $this->cartModal->get_exchange_rate($currency);

        $quotation = $this->quotationModal->getQuotation($quotationiNumber);
        $quotationDetails = $this->quotationModal->getQuotationDetail($quotationiNumber);
        //echo $quotationiNumber;
        if ($quotationiNumber != "") {
            $param11 = array('view_count' => 0);
            $this->db->where('QuotationNumber', $quotationiNumber);
            $this->db->update('quotations', $param11);
        }


        $FirstName = $quotation[0]->BillingFirstName;
        $EmailAddress = $quotation[0]->Billingemail;
        $date = $quotation[0]->QuotationDate;
        $time = $quotation[0]->QuotationDate;
        $OrderDate = date("d/m/Y", $date);
        $OrderTime = date("H:i", $time);
        $PaymentMethod1 = $quotation[0]->PaymentMethods;

        $sql = $this->db->get_where(Template_Table, array('MailID' => '3'));
        $result = $sql->result_array();
        $result = $result[0];
        $mailTitle = $result['MailTitle'];
        $mailName = $result['Name'];
        $from_mail = $result['MailFrom'];
        $mailSubject = $result['MailSubject'] . ' : ' . $quotationiNumber;

        $mailText = $result['MailBody'];

        $getfile = FCPATH . 'application/views/order_quotation/checkout/quote-confirm.html';
        $mailText = file_get_contents($getfile);

        $extPrice = 0;
        $se = 0;
        $rows = '';
        foreach ($quotationDetails as $key => $quotationDetail) {
            $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
            if ($quotationDetail->ManufactureID == 'SCO1') {
                $carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);

                $rows .= '<tr>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $quotationDetail->ManufactureID
                    . '</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $quotationDetail->ProductName . '</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $quotationDetail->Quantity . '</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">-</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:1; border-top:0;">' . $symbol . $quotationDetail->Price . '</td>
				   </tr>';

                $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);
                $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                foreach ($assoc as $rowp) {

                    $materialprice = $rowp->plainprice + $rowp->printprice;
                    $materialpriceinc = $materialprice * 1.2;
                    $rows .= '<tr>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $rowp->material . '</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $this->user_model->get_mat_name($rowp->material) . '</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $rowp->qty . '</td>
						<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">-</td>
					
						<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0;">' . $symbol . number_format($materialprice * $exchange_rate, 2) . '</td>
						</tr>';

                    $se += $materialprice;
                }


            } else {
                $rows .= '<tr>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $quotationDetail->ManufactureID . '</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $quotationDetail->ProductName . '</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $quotationDetail->Quantity . '</td>
					<td style="font-size:12px; border:1px solid #b3b3b3; border-right:0; border-top:0;">' . $symbol . number_format($quotationDetail->Price / $quotationDetail->Quantity, 2, '.', '') . '</td>
					
					<td style="font-size:12px; border:1px solid #b3b3b3; border-top:0;">' . $symbol . number_format($quotationDetail->Price * $exchange_rate, 2, '.', '') . '</td>
				   </tr>';


                /* if($quotationDetail->Printing == 'Y'){



                     /*$rows .='<tr>
                         <td class="text-center labels-form"></td>
                         <td class="text-center labels-form"></td>';
                         //include(APPPATH."views/generate_text_line.php");
                             $rows .='<td id="labels0"></td>
                            <td></td>
                            <td></td>
             </tr>';
           }*/

            }
        }

        $Delivery = $symbol . number_format($quotation[0]->QuotationShippingAmount / vat_rate * $exchange_rate, 2);
        $grandPrice = $se + $extPrice + number_format($quotation[0]->QuotationShippingAmount / vat_rate * $exchange_rate, 2);
        $gtotalExvat = $symbol . number_format($grandPrice * $exchange_rate, 2);

        $vatType = '';

        if ($quotation[0]->vat_exempt == 'yes') {
            $vatType = 'VAT Exempt';
            $vatVals = $symbol . number_format(($grandPrice * vat_rate) - $grandPrice * $exchange_rate, 2);
        } else {
            $grandPrice = $grandPrice;
            $vatType = 'VAT @20%';
            $vatVals = $symbol . number_format((($grandPrice * vat_rate) - $grandPrice) * $exchange_rate, 2);
        }

        if ($quotation[0]->vat_exempt == 'yes') {
            $gt = $symbol . number_format($grandPrice * $exchange_rate, 2);
        } else {
            $gt = $symbol . number_format(($grandPrice * vat_rate) * $exchange_rate, 2);
        }


        $urld = 'https://www.aalabels.com/quotation-confirmation/' . md5($quotation[0]->QuotationNumber);

        $strINTemplate = array("[quotationiNumber]", "[vatNo]", "[BillingFirstName]", "[customer_message]", "[OrderDate]", "[OrderTime]", "[PaymentMethod]",
            "[BillingTitle]", "[BillingFirstName]", "[BillingLastName]",
            "[BillingCompanyName]", "[BillingAddress1]", "[BillingAddress2]", "[BillingTownCity]", "[BillingCountyState]",
            "[BillingPostcode]", "[BillingCountry]", "[Billingtelephone]", "[BillingMobile]", "[Billingfax]", "[EmailAddress]",
            "[DeliveryTitle]", "[DeliveryFirstName]", "[DeliveryLastName]", "[DeliveryCompanyName]", "[DeliveryAddress1]",
            "[DeliveryAddress2]", "[DeliveryTownCity]", "[DeliveryCountyState]", "[DeliveryPostcode]", "[DeliveryCountry]", "[OrderItems]", "[DeliveryExVatCost]", "[gtotalExvat]", "[gtotalIncvat]", "[vatType]", "[vatVals]", "[go_url]");

        $webroot = base_url() . "theme/";
        //----------------------------------------------------------------------------------------------

        $quotationNo = $quotation[0]->QuotationNumber;
        $BillingTitle = $quotation[0]->BillingTitle;
        $BillingFirstName = $quotation[0]->BillingFirstName;
        $BillingLastName = $quotation[0]->BillingLastName;
        $BillingCompanyName = $quotation[0]->BillingCompanyName;
        $BillingAddress1 = $quotation[0]->BillingAddress1;
        $BillingAddress2 = $quotation[0]->BillingAddress2;
        $BillingTownCity = $quotation[0]->BillingTownCity;
        $BillingCountyState = $quotation[0]->BillingCountyState;
        $BillingPostcode = $quotation[0]->BillingPostcode;
        $BillingCountry = $quotation[0]->BillingCountry;
        $Billingtelephone = $quotation[0]->Billingtelephone;
        $BillingMobile1 = $quotation[0]->BillingMobile;
        $Billingfax = $quotation[0]->Billingfax;
        $BillingResCom = $quotation[0]->BillingResCom;
        //$EmailAddress 		=	$res3['Billingemail'];
        $DeliveryTitle = $quotation[0]->DeliveryTitle;
        $DeliveryFirstName = $quotation[0]->DeliveryFirstName;
        $DeliveryLastName = $quotation[0]->DeliveryLastName;
        $DeliveryCompanyName = $quotation[0]->DeliveryCompanyName;
        $DeliveryAddress1 = $quotation[0]->DeliveryAddress1;
        $DeliveryAddress2 = $quotation[0]->DeliveryAddress2;
        $DeliveryTownCity = $quotation[0]->DeliveryTownCity;
        $DeliveryCountyState = $quotation[0]->DeliveryCountyState;
        $DeliveryPostcode = $quotation[0]->DeliveryPostcode;
        $DeliveryCountry = $quotation[0]->DeliveryCountry;
        $DeliveryResCom = $quotation[0]->DeliveryResCom;


        $strInDB = array($quotationNo, 'GB 945 0286 20', $quotation[0]->BillingFirstName, 'Thank you for contacting AA Labels', $OrderDate, $OrderTime, $PaymentMethod1, $BillingTitle,
            $BillingFirstName, $BillingLastName,
            $BillingCompanyName, $BillingAddress1, $BillingAddress2, $BillingTownCity, $BillingCountyState,
            $BillingPostcode, $BillingCountry, $Billingtelephone, $BillingMobile1, $Billingfax, $EmailAddress,
            $DeliveryTitle, $DeliveryFirstName, $DeliveryLastName, $DeliveryCompanyName, $DeliveryAddress1,
            $DeliveryAddress2, $DeliveryTownCity, $DeliveryCountyState, $DeliveryPostcode, $DeliveryCountry, $rows, $Delivery, $gtotalExvat, $gt, $vatType, $vatVals, $urld);

        $newPhrase = str_replace($strINTemplate, $strInDB, $mailText);

        //echo '<pre>'; print_r($newPhrase); echo '</pre>'; exit;


        $mailfrom = 'customercare@aalabels.com';
        $mailname = "AA Labels";

        $this->load->library('email');
        $this->email->initialize();
        $this->email->from($mailfrom, $mailname);
        $this->email->to($quotation[0]->Billingemail);
        $this->email->bcc('umair.aalabels@gmail.com');
        $this->email->subject('Quotation Approval');
        $this->email->message($newPhrase);
        $this->email->set_mailtype("html");
        $this->email->send();

    }


    public function setUpCharge()
    {

        echo json_encode(array('cartId' => $this->cartModal->insertIntoCart()));
    }

    public function qos()
    {
        $this->load->view('order_quotation/checkout/order-confirmation.html');
    }

    public function insertFlexDieRecord()
    {

        $cartId = filter_var($this->input->get('cartId'), FILTER_VALIDATE_INT);

        $record = $this->cartModal->checkIfExist($cartId);

        if ($record[0]->total > 0) {
            if (filter_var($this->input->get('pageName'), FILTER_SANITIZE_STRING) == 'quotation') {
                $this->cartModal->updateFlexDieRecordForQuotation($this->getFlexParamsForQuot());
            } else {
                $this->cartModal->updateFlexDieRecord($this->getFlexParams());
            }

        } else {
            $this->cartModal->insertFlexDieRecord($this->getFlexParams());
        }

        echo true;
    }

    public function getFlexParams()
    {
        return array(
            'CartID' => $this->input->get('cartId'),
            'QID' => '0',
            'OID' => '0',
            'format' => $this->input->get('format'),
            'shape' => $this->input->get('shape'),
            'width' => $this->input->get('width'),
            'height' => $this->input->get('height'),
            'labels' => $this->input->get('labels'),
            'across' => $this->input->get('across'),
            'around' => $this->input->get('around'),
            'iseuro' => 0,
            'cornerradius' => $this->input->get('cornerradious'),
            'perforation' => $this->input->get('perforate'),
            'notes' => $this->input->get('note'),
        );
    }

    public function getFlexParamsForQuot()
    {
        return array(
            'QID' => $this->input->get('QID'),
            'format' => $this->input->get('format'),
            'shape' => $this->input->get('shape'),
            'width' => $this->input->get('width'),
            'height' => $this->input->get('height'),
            'labels' => $this->input->get('labels'),
            'across' => $this->input->get('across'),
            'around' => $this->input->get('around'),
            'iseuro' => 0,
            'cornerradius' => $this->input->get('cornerradious'),
            'perforation' => $this->input->get('perforate'),
            'notes' => $this->input->get('note'),
        );
    }


    public function getCustomDieRecord()
    {
        if ($this->input->get('quo') == 'quo') {
            echo json_encode(array('data' => $this->cartModal->getCustomDieRecordForQuotation($this->input->get('id'))));
        } else {
            echo json_encode(array('data' => $this->cartModal->getCustomDieRecord($this->input->get('id'))));
        }

    }


    public function getMaterialCode()
    {

        if ($this->input->get('format') == 'Roll') {
            $materials = $this->cartModal->getRollMaterialCode();
        } else {
            $materials = $this->cartModal->getSheetMaterialCode($this->input->get('format'));
        }

        echo json_encode(array('response' => 'yes', 'data' => $materials));
    }

    public function addMaterial()
    {
        echo $this->cartModal->addMaterial();
    }

    public function saveOrder()
    {

        $order = $this->orderModal->saveOrder();

        if ($order['res']) {
            $data['order'] = $this->orderModal->getOrder($order['orderNumber']);
            $data['orderDetails'] = $this->orderModal->getOrderDetail($order['orderNumber']);

            $respon['html'] = $this->takeHtmlAndPrintData('order_quotation/checkout/confirm_my_order', $data);
            $respon['response'] = 'true';
            echo json_encode($respon);

        }
    }

    public function addLineIntoOrderDetail()
    {
        $this->orderModal->addLineIntoOrderDetail();

        $ordernumber = $this->input->post('orderNumber');
        if (isset($ordernumber) && $ordernumber != "") {
            $this->settingmodel->update_order_total($ordernumber);
        }

        echo json_encode(array('response' => 'yes'));
    }

    public function addLineForRoll()
    {
        $this->orderModal->addLineForRoll();
        $ordernumber = $this->input->post('orderNumber');
        if (isset($ordernumber) && $ordernumber != "") {
            $this->settingmodel->update_order_total($ordernumber);
        }

        echo json_encode(array('response' => 'yes'));
    }

    public function delOrderDetailLine()
    {
        $ordernumber = $this->input->post('ordernumber');
        $this->orderModal->delOrderDetailLine();
        $this->settingmodel->add_logs('line_deleted', '', '', $ordernumber, $this->input->post('serialNumber'));

        if (isset($ordernumber) && $ordernumber != "") {
            $this->settingmodel->update_order_total($ordernumber);
        }
        echo json_encode(array('response' => 'yes'));
    }

    public function addNote()
    {
        $this->orderModal->addNote();
        echo json_encode(array('response' => 'yes'));
    }

    public function addDeclineNote()
    {
        $this->orderModal->addDeclineNote();
        echo json_encode(array('response' => 'yes'));
    }

    public function updateNote()
    {
        $this->orderModal->updateNote();
        echo json_encode(array('response' => 'yes'));
    }

    public function DeclineNote()
    {
        $this->orderModal->DeclineNote();
        echo json_encode(array('response' => 'yes'));
    }

    public function changeCategory()
    {
        $this->orderModal->changeCategory();
        $par1 = ($this->input->post('val') == 'N') ? "Printed" : "plain";
        $par2 = ($this->input->post('val') == 'Y') ? "Printed" : "plain";
        $this->settingmodel->add_logs('line_changed', $par1, $par2, '', $this->input->post('serialNumber'));
        echo true;
    }


    public function insertLog()
    {


        $this->settingmodel->add_logs('print_charges', filter_var($this->input->get('value'), FILTER_SANITIZE_STRING), '', '', filter_var($this->input->get('serialNumber'), FILTER_VALIDATE_INT));
        redirect($_SERVER['REQUEST_URI'], 'refresh');
    }

    public function update_orientation_wound()
    {
        $value = $this->input->post('value');
        $serial = $this->input->post('serial');
        $type = $this->input->post('type');
        $ordernumber = $this->input->post('ordernumber');

        $array = array($type => $value);

        $this->db->where('SerialNumber', $serial);
        $this->db->update('orderdetails', $array);
        $this->settingmodel->add_logs($type, $value, '', $ordernumber, $serial);
    }


    public function updateOrder()
    {
        
        //error_reporting(E_ALL);
        //ini_set('errors_display',1);

        $serialNumber = $this->input->post('SerialNumber');
        $OrderNumber = $this->input->post('orderNumber');
        $Quantity = $this->input->post('qty');
        $previousQty = $this->input->post('previousQty');
        $LabelQuantity = $this->input->post('labels');
        $LabelPreviousQty = $this->input->post('labelpreviousQty');    

        $this->orderModal->updateOrderDetail();

        if ($Quantity != $previousQty) {
            $this->settingmodel->add_logs('quantity_changed', $previousQty, $Quantity, $OrderNumber, $serialNumber);
        }
        
        if ($LabelQuantity != $LabelPreviousQty) {
            $this->settingmodel->add_logs('labels_changed', $LabelPreviousQty, $LabelQuantity, $OrderNumber, $serialNumber);
        }


        $record = $this->getPriceForOrder();
        $this->settingmodel->update_order_total($OrderNumber);
    }

    function getPriceForOrder()
    {


        if ($_POST['printing'] == 'Y' || $_POST['printing'] == 'Yes') {

            if ($_POST['regmark'] == 'Y') {

                $params = array(
                    'labeltype' => $_POST['digital'],
                    'labels' => $_POST['qty'] * $_POST['labelperRoll'],
                    'design' => 1,
                    'menu' => $_POST['manfectureId'],
                    'persheets' => $_POST['labelperRoll'],
                    'producttype' => ($_POST['brand'] == 'Roll Labels') ? 'Rolls' : 'sheet',
                    'pressproof' => 0,
                    'finish' => 'No Finish',
                    'brand' => $_POST['brand'],
                    'printing' => $_POST['printing'],
                    'customerId' => $_POST['customerId'],
                    'serialno' => $_POST['SerialNumber'],
                    'qty' => $_POST['qty'],
                    'max_lbl' => $_POST['LabelsPerSheet']
                );
            } else {
                $params = array(
                    'labeltype' => $_POST['digital'],
                    'labels' => $_POST['qty'] * $_POST['labelperRoll'],
                    'design' => $_POST['design'],
                    'menu' => $_POST['manfectureId'],
                    'persheets' => $_POST['labelperRoll'],
                    'producttype' => ($_POST['brand'] == 'Roll Labels') ? 'Rolls' : 'sheet',
                    'pressproof' => $_POST['pressProf'],
                    'finish' => (isset($_POST['finish'])) ? $_POST['finish'] : '',
                    'brand' => $_POST['brand'],
                    'printing' => $_POST['printing'],
                    'customerId' => $_POST['customerId'],
                    'serialno' => $_POST['SerialNumber'],
                    'qty' => $_POST['qty'],
                    'max_lbl' => $_POST['LabelsPerSheet']
                );
            }

        } else {
            if ($_POST['brand'] == 'Roll Labels') {
                $to_lb = $_POST['labelperRoll'];
            } else {
                $to_lb = $_POST['qty'] * $_POST['labelperRoll'];
            }

            $params = array(
                'printing' => $_POST['printing'],
                'brand' => $_POST['brand'],
                'qty' => $_POST['qty'],
                'manfactureId' => $_POST['manfectureId'],
                'rolls' => $_POST['qty'],
                'labels' => $to_lb,
                'labelsPerSheet' => $_POST['labelperRoll'],
                'serialno' => $_POST['SerialNumber'],
            );
        }

        //print_r($params);exit;
        $price = $this->myPriceModel->getPriceForOrder($params, $_POST['productId']);
        //print_r($price);exit;

        $priceParams = array(
            'Price' => $price['plainPrice'],
            'Print_Total' => $price['printPrice'],
            'ProductTotalVAT' => $price['plainPrice'],
            'ProductTotal' => number_format($price['totalPrice'], 2,'.',''),
            'Free' => $price['Free']
        );

        $mattpe = ($_POST['brand'] == 'Roll Labels') ? 'Roll' : 'A4';
        if( ($mattpe =='Roll' && $_POST['printing'] != 'Y') || ($mattpe =='A4') ) {

            $m_codes = ($mattpe == Roll) ? substr($_POST['manfectureId'], 0, -1) : $_POST['manfectureId'];
            $material_code = $this->home_model->getmaterialcode($m_codes);
            $material_discount = $this->home_model->check_material_discount($material_code, $mattpe);

            if ($material_discount != null) {
                $disRate = ($priceParams['Price'] * $material_discount) / 100;
                $priceParams['Price'] = number_format($priceParams['Price'] - $disRate, 2,'.','');
            }
        }    
        
        
        

        if (isset($_POST['SerialNumber']) && $_POST['SerialNumber'] != "" && $_POST['SerialNumber'] != 0) {
            $this->db->where('SerialNumber', $_POST['SerialNumber']);
            $this->db->update('orderdetails', $priceParams);
        }
        echo true;
    }


    function save_checkout_session_data()
    {
        $usrid = $this->session->userdata('userid');
        if (isset($usrid) && $usrid != '') {
            if ($_POST) {
                $b_pcode = strtoupper($this->input->post('b_pcode'));
                $d_pcode = strtoupper($this->input->post('d_pcode'));
                $b_first_name = ucwords($this->input->post('b_first_name'));
                $b_last_name = ucwords($this->input->post('b_last_name'));
                $d_first_name = ucwords($this->input->post('d_first_name'));
                $d_last_name = ucwords($this->input->post('d_last_name'));
                $b_add1 = ucwords($this->input->post('b_add1'));
                $b_add2 = ucwords($this->input->post('b_add2'));
                $b_city = ucwords($this->input->post('b_city'));
                $b_county = ucwords($this->input->post('b_county'));
                $d_add1 = ucwords($this->input->post('d_add1'));
                $d_add2 = ucwords($this->input->post('d_add2'));
                $d_city = ucwords($this->input->post('d_city'));
                $d_county = ucwords($this->input->post('d_county'));
                $b_organization = ucwords($this->input->post('b_organization'));
                $d_organization = ucwords($this->input->post('d_organization'));

                $billing_title = $this->input->post('billing_title');
                $b_phone_no = $this->input->post('b_phone_no');

                $b_mobile = $this->input->post('b_mobile');
                $d_mobile_no = $this->input->post('d_mobile_no');

                $delivery_title = $this->input->post('title_d');
                $d_email = $this->input->post('d_email');

                $d_phone_no = $this->input->post('d_phone_no');

                $country = $this->input->post('country');
                $dcountry = $this->input->post('dcountry');
                $second_email = $this->input->post('second_email');

                $data = array(
                    'BillingTitle' => $billing_title,
                    'BillingFirstName' => $b_first_name,
                    'BillingLastName' => $b_last_name,
                    'BillingAddress1' => $b_add1,
                    'BillingTownCity' => $b_city,
                    'BillingCountyState' => $b_county,
                    'BillingPostcode' => $b_pcode,
                    'DeliveryTitle' => $delivery_title,
                    'DeliveryFirstName' => $d_first_name,
                    'DeliveryLastName' => $d_last_name,
                    'DeliveryAddress1' => $d_add1,
                    'DeliveryTownCity' => $d_city,
                    'DeliveryCountyState' => $d_county,
                    'DeliveryPostcode' => $d_pcode,
                    'Deliveryemail' => $d_email,
                    'BillingCountry' => $country,
                    'DeliveryCountry' => $dcountry,
                    'DeliveryAddress2' => $d_add2,
                    'BillingAddress2' => $b_add2
                );

                if ($b_organization) {
                    $data = array_merge($data, array('BillingCompanyName' => $b_organization));
                }
                if ($b_phone_no) {
                    $data = array_merge($data, array('Billingtelephone' => $b_phone_no));
                }


                if ($d_organization) {
                    $data = array_merge($data, array('DeliveryCompanyName' => $d_organization));
                }
                if ($d_phone_no) {
                    $data = array_merge($data, array('Deliverytelephone' => $d_phone_no));
                }
                if ($second_email) {
                    $data = array_merge($data, array('SecondaryEmail' => $second_email));
                }
                if ($b_mobile) {
                    $data = array_merge($data, array('BillingMobile' => $b_mobile));
                }
                if ($d_mobile_no) {
                    $data = array_merge($data, array('DeliveryMobile' => $d_mobile_no));
                }

                $this->db->where('UserID', $usrid);
                $this->db->update('customers', $data);
                $this->session->set_userdata('payment_redirection', 'occured');

            }
        }
    }

    function getOrder($order)
    {

        $query = $this->db->query("SELECT * FROM `orders` WHERE  OrderNumber LIKE '" . $order . "' ");

        $row = $query->row_array();

        return $row;

    }

    function payment_recieved($ordernumber)
    {
        $query = $this->db->query("select SUM(payment) as total from order_payment_log where OrderNumber LIKE '" . $ordernumber . "' and situation LIKE 'taken' ")->row_array();
        return $query['total'];
    }

    function get_exchange_rate($code)
    {

        $sql = $this->db->query("select rate from exchange_rates where currency_code LIKE '" . $code . "'");
        $sql = $sql->row_array();
        return $sql['rate'];
    }

    function currecy_converter($price, $currency)
    {

        $rate = $this->get_exchange_rate($currency);
        if (isset($rate) and $rate > 0) {
            $price = $price * $rate;
        }
        // if($vat=='yes' and vatoption=='Inc'){ $price = $price*1.2; }
        return number_format($price, 2, '.', '');
    }

    function get_currecy_symbol($code)
    {
        $sql = $this->db->query("select symbol from exchange_rates where currency_code LIKE '" . $code . "'");
        $sql = $sql->row_array();
        return $sql['symbol'];
    }

    function clean($string)
    {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    }

    function takeCreditCartPayment()
    {
        $orderNumber = $this->input->get('orderNumber');
        $type = $this->input->get('type');
        $this->worldpay($orderNumber, $type);
    }

    function worldpay($orderNumber = "", $type = NULL)
    {

        $billing_nam = "";
        $OrderStatus = '';
        if (isset($orderNumber) and $orderNumber != NULL) {

            $this->session->set_userdata('OrderNo', $orderNumber);

        }


        //$invoice_no = "AA58724";

        $invoice_no = $this->session->userdata('OrderNo');


        if (isset($invoice_no) and $invoice_no != '') {

          $orderInfo = $this->getOrder($invoice_no);
          $amount = $orderInfo['OrderTotal'] + $orderInfo['OrderShippingAmount'];

            if ($orderInfo['vat_exempt'] == 'yes') {
                $amount = number_format(($amount / 1.2), 2, '.', '');
            }


            // NEW CODE FOR ORDER EDITOR
            if ($type == "partpayment") {
                $r = $this->db->query("select sum(odp_price) as pressProf from orderdetails where OrderNumber ='" . $invoice_no . "' ")->row();
                $pres = $r->pressProf * 1.2;

                if ($orderInfo['vat_exempt'] == 'yes') {
                    $pres = number_format(($pres / 1.2), 2, '.', '');
                }

               $amount = $amount + $pres;

                $amount_received = $this->payment_recieved($orderNumber);
                $amount = $amount - $amount_received;
                

            }
            
            
            
            
            $payment_taken = $amount;
            // NEW CODE FOR ORDER EDITOR


            $amount = $this->currecy_converter($amount, $orderInfo['currency']);
            $symbol = $this->get_currecy_symbol($orderInfo['currency']);


            if ($_POST) {


                $token = $this->input->post('token');

                if (isset($token) and $token != '') {


                    require_once(APPPATH . 'libraries/worldpay.php');

                    $worldpay = new Worldpay(WP_SERVICE_KEY);
                    $amount = round($amount*100);
                   
                    if (SITE_MODE != 'live') {
                        $worldpay->disableSSLCheck(true); //remove this line after live
                    }


                    $billing_name = $orderInfo['BillingFirstName'].' '.$orderInfo['BillingLastName'];
                    $billing_name = $this->clean($billing_name);


                  $ff =   array(

                        'token' => $token,
                        'amount' => $amount,
                        'currencyCode' => $orderInfo['currency'],
                        'name' => $billing_name,
                        'orderDescription' => 'AAlabels Products',
                        'customerOrderCode' => $invoice_no,
                        'shopperEmailAddress' => $orderInfo['Billingemail'],
                        'billingAddress' => array(
                            'address1' => $orderInfo['BillingAddress1'],
                            'postalCode' => $orderInfo['BillingPostcode'],
                            'city' => $orderInfo['BillingTownCity'],
                            'state' => $orderInfo['BillingCountyState'],
                        ),


                    'deliveryAddress' => array(
                        'address1' => $orderInfo['DeliveryAddress1'],
                        'address2' => $orderInfo['DeliveryAddress2'],
                        'postalCode' => $orderInfo['DeliveryPostcode'],
                        'city' => $orderInfo['DeliveryTownCity'],
                        'state' => $orderInfo['DeliveryCountyState'],
                    ));

               
            
                    try {


                        $response = $worldpay->createOrder(array(

                            'token' => $token,
                            'amount' => $amount,
                            'currencyCode' => $orderInfo['currency'],
                            'name' => $billing_name,
                            'orderDescription' => 'AAlabels Products',
                            'customerOrderCode' => $invoice_no,
                            'shopperEmailAddress' => $orderInfo['Billingemail'],
                            'billingAddress' => array(
                                'address1' => $orderInfo['BillingAddress1'],
                                'postalCode' => $orderInfo['BillingPostcode'],
                                'city' => $orderInfo['BillingTownCity'],
                                'state' => $orderInfo['BillingCountyState'],
                            ),
                            'deliveryAddress' => array(
                                'address1' => $orderInfo['DeliveryAddress1'],
                                'address2' => $orderInfo['DeliveryAddress2'],
                                'postalCode' => $orderInfo['DeliveryPostcode'],
                                'city' => $orderInfo['DeliveryTownCity'],
                                'state' => $orderInfo['DeliveryCountyState'],
                            ),
                        ));


                  
               
                        if (isset($response['paymentStatus']) && ($response['paymentStatus'] == 'SUCCESS' || $response['paymentStatus'] == 'AUTHORIZED')) {


                            $printing = $this->printing_order_count($invoice_no);
                            $regmarkCount = $this->regmark_count($invoice_no);


                            if ($regmarkCount > 0) {
                                if ($regmarkCount == 1) {
                                    // $OrderStatus = 32;
                                    $OrderStatus = ($printing > 0) ? 55 : 32;
                                } else {
                                    $OrderStatus = ($printing > 0) ? 55 : 32;
                                }
                            } else {
                                $OrderStatus = ($printing > 0) ? 55 : 32;
                            }


                            $OrderStatus = (isset($orderInfo['Old_OrderStatus']) && $orderInfo['Old_OrderStatus'] == 33) ? 33 : $OrderStatus;


                            $this->db->where('OrderNumber', $invoice_no);
                            $this->db->update("orders", array('OrderStatus' => $OrderStatus,

                                'YourRef' => $response['orderCode'],

                                'PaymentMethods' => 'creditCard',

                                'Old_OrderStatus' => 6,

                                'Payment' => 1));


                            $this->insert_payment_log('worldpay', $invoice_no, $payment_taken);
                            redirect(main_url . 'order_quotation/Order/orderreview');

                            $this->orderreview($orderNumber);


                        } else {

                            $data['payment_error'] = 'Problem with authorization, please try again';

                        }


                    } catch (WorldpayException $e) {

                        $data['payment_error'] = $e->getMessage();

                    }


                }

            }


            $data['currency'] = $orderInfo['currency'];

            $data['symbol'] = $symbol;

            $data['order_numer'] = $invoice_no;

            $data['total_amount'] = $amount;

            $data['main_content'] = 'payment/worldpay_iframe';

            $this->load->view('page', $data);

        }

    }

    function printOrder($orderID, $type, $ver)
    {
        $this->order_pdf($orderID, $ver, $type);
    }

    function order_pdf($order, $language, $type)
    {

       /* echo "Order: ".$order."<br>";
        echo "Language: ".$language."<br>";
        echo "Type: ".$type."<br>";
        die();*/

        $CI =& get_instance();
        if ($type == 0) {
            $page = ($language == "en") ? "order_quotation/order_detail/en/orderconfirm.php" : "order_quotation/order_detail/fr/orderconfirm.php";
        } else {
            $page = ($language == "en") ? "order_quotation/order_detail/en/orderhide.php" : "order_quotation/order_detail/fr/orderhide.php";
        }
        //echo $page;exit;
        $query = $CI->db->get_where('orders', array('OrderNumber' => $order));
        $res = $query->result_array();
        $res = $res[0];

        $data['type'] = $type;
        $data['OrderInfo'] = $res;
        $data['OrderDetails'] = $CI->orderModal->OrderDetails($order);

        //echo $this->load->view($page, $data, TRUE); exit;

        $this->load->library('pdf');
        $this->pdf->load_view($page, $data, TRUE);

        $this->pdf->render();

        $output = $this->pdf->output();
        $file_location = "pdf/orderconfirmation_" . $order . ".pdf";
        $filename = $file_location;
        $fp = fopen($filename, "a");
        file_put_contents($file_location, $output);
        $CI->pdf->stream("Order No : " . $order . ".pdf");

    }

    function orderreview($ordernumber = null)
    {

        if ($ordernumber != null) {
            $OrderNo = $ordernumber;
        } else {
            $OrderNo = $this->session->userdata('OrderNo');
        }

        //$this->custom->assign_dispatch_date($OrderNo,TRUE);

        $d = $data['order'] = $this->orderModal->getOrder($OrderNo);
        //echo '<pre>'; print_r($d); echo '</pre>';
        $data['orderDetails'] = $this->orderModal->getOrderDetail($OrderNo);

        $data['status'] = $this->orderModal->statusDropDown($d[0]->OrderStatus, $d[0]->PaymentMethods);


        $VATEXEMPT = $data['order'][0]->vat_exempt;


        if (($data['order'][0]->PaymentMethods == 'creditCard' || $data['order'][0]->PaymentMethods == 'paypal') && $VATEXEMPT == 'no') {
            if (MODE == 'live') {
                $this->orderemail($OrderNo);
            }


            //$this->orderModal->addinvoice($OrderNo);

        } else  if ($data['order'][0]->PaymentMethods == 'Sample Order') {
                if (MODE == 'live') {
                    $this->orderemail($OrderNo);
                }
                //$this->orderModal->addinvoice($OrderNo);

            }


        $data['main_content'] = 'order_quotation/checkout/confirm_my_order';
        $this->load->view('page', $data);
        $this->split_trade_order($OrderNo);
        $this->session->unset_userdata('user_domain');
        $this->session->unset_userdata('ws_applied');

    }

    function split_trade_order($orderNum)
    {
        $user_domain = $this->session->userdata('user_domain');
        if ($user_domain) {
            $orderDetails = $this->orderModal->OrderInfo($orderNum);
            $orderDetails = $orderDetails[0];
            $orderLines = $this->orderModal->OrderDetails($orderNum);

            $serials_array = array();

            foreach ($orderLines as $line) {

                if ($line->page_location == "Trade Print") {
                } else {
                    $serials_array[] = $line->SerialNumber;
                }
            }

            if ($serials_array) {
                $sessionid = $this->session->userdata('session_id');
                $this->db->insert('auto_ordernumber', array('session_id' => $sessionid));
                $order_num = $this->db->insert_id();
                $OrderNumber = 'AA' . $order_num;

                $orderTotal = 0;

                foreach ($serials_array as $serial) {
                    $orderTotal += $this->get_db_column('orderdetails', 'ProductTotal', 'SerialNumber', $serial);

                    $this->db->set('OrderNumber', $OrderNumber);
                    $this->db->where('SerialNumber', $serial);
                    $this->db->update('orderdetails');

                    $this->db->set('OrderNumber', $OrderNumber);
                    $this->db->where('Serial', $serial);
                    $this->db->update('order_attachments_integrated');
                }

                $orderDetails->OrderTotal = $orderDetails->OrderTotal - $orderTotal;

                $this->db->where('OrderNumber', $orderDetails->OrderNumber);
                $this->db->update('orders', $orderDetails);

                $AAOrder = $orderDetails;

                unset($AAOrder->OrderID);
                $AAOrder->OrderNumber = $OrderNumber;
                $AAOrder->OrderTotal = $orderTotal;
                $this->db->insert('orders', $AAOrder);

                //if order status == 2/32 then check if the line is plain, then change the status to 55.
                if (($AAOrder->OrderStatus == 2) || ($AAOrder->OrderStatus == 32)) {
                    $this->change_order_status_confirmation($OrderNumber);
                }
            }
        }
    }

    function change_order_status_confirmation($orderNum)
    {

        $plain_query = "select count(*) as total from orderdetails where OrderNumber LIKE '" . $orderNum . "' AND Printing NOT LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels'";

        $printed_query = "select count(*) as total from orderdetails where OrderNumber LIKE '" . $orderNum . "' AND Printing LIKE 'Y' AND source NOT LIKE 'flash' AND (select ProductBrand from products WHERE products.ProductID =orderdetails.ProductID ) NOT LIKE 'Application Labels'";

        //$plain_order = $this->db->query($plain_query)->row()->total;
        $printed_order = $this->db->query($printed_query)->row()->total;
        if (!$printed_order) {
            $this->db->set('OrderStatus', 32);
            $this->db->where('OrderNumber', $orderNum);
            $this->db->update('orders');
        }
    }

    function orderemail($OrderNo, $referertype = NULL){
      $data['OrderDetail'] = $this->orderModal->OrderDetails($OrderNo);
      $data['OrderInfo'] = $this->orderModal->OrderInfo($OrderNo);

         if(MODE == 'live'){
            $this->orderModal->order_confirmation_new($OrderNo, $referertype = NULL);
         }
    }


    function payByPayPal($orderNumber)
    {

        $this->paypal($orderNumber, '');
    }


    function paypal($orderNumber = NULL, $type = NULL)
    {

        if (isset($orderNumber) and $orderNumber != NULL) {
            $this->session->set_userdata('OrderNo', $orderNumber);
        }


        $invoice_no = $this->session->userdata('OrderNo');
        if (isset($invoice_no) and $invoice_no != '') {
            $orderInfo = $this->getOrder($invoice_no);
            $amount = number_format($orderInfo['OrderTotal'] + $orderInfo['OrderShippingAmount'], 2, '.', '');
            if ($orderInfo['vat_exempt'] == 'yes') {
                $amount = number_format(($amount / 1.2), 2, '.', '');
            }

            // NEW CODE FOR ORDER EDITOR
            if ($type == "partpayment") {
                $amount_received = $this->payment_recieved($orderNumber);
                $amount = $amount - $amount_received;
                $amount = number_format($amount, 2, '.', '');
            }
            // NEW CODE FOR ORDER EDITOR


            $amount = $this->currecy_converter($amount, $orderInfo['currency']);
            $amount = number_format($amount, 2, ".", "");

            $paypal_credentials = array(
                'API_username' => API_username,
                'API_password' => API_password,
                'API_signature' => API_signature,
                'sandbox_status' => sandbox_status);

            $this->load->library('paypal_ec', $paypal_credentials);

            $to_buy = array(
                'desc' => "Payment received against OrderNumber#" . $invoice_no,
                'currency' => $orderInfo['currency'],
                'jobid' => $invoice_no,
                'email' => $orderInfo['Billingemail'],
                'type' => 'sale',
                'return_URL' => main_url . "order_quotation/Order/paypalcallback",
                'cancel_URL' => main_url . "order_quotation/Order/paypalcallback",
                'get_shipping' => false);


            $temp_product = array(
                'name' => 'Labels from AAlabels',
                'quantity' => 1,
                'amount' => $amount);

            $to_buy['products'][] = $temp_product;
            $set_ec_return = $this->paypal_ec->set_ec($to_buy);


            if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
                $this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
            } else {
                redirect(main_url . 'orderDetailList');
            }

        } else {
            redirect(main_url . 'orderDetailList');
        }
    }

    function paypalcallback()
    {
        $paypal_credentials = array(
            'API_username' => API_username,
            'API_password' => API_password,
            'API_signature' => API_signature,
            'sandbox_status' => sandbox_status);

        $this->load->library('paypal_ec', $paypal_credentials);
        $token = $_GET['token'];

        if (isset($token) and $token != '') {
            $get_ec_return = $this->paypal_ec->get_ec($token);
            if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
                $payer_id = (isset($_GET['PayerID']) and $_GET['PayerID'] != '') ? $_GET['PayerID'] : '';

                $ec_details = array(
                    'token' => $token,
                    'payer_id' => $payer_id,
                    'currency' => 'GBP',
                    'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'],
                    'type' => 'sale');

                $do_ec_return = $this->paypal_ec->do_ec($ec_details);
                $invoice_no = $this->session->userdata('OrderNo');
                $logdata = "<pre>\r\n" . print_r($do_ec_return, true) . '</pre>';
                $paypal_array = array('OrderNumber' => $invoice_no, 'PaypalStatus' => $logdata);
                $this->db->insert('paypal_status_debug', $paypal_array);

                if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
                    if (isset($invoice_no) and $invoice_no != '') {
                        $printing = $this->printing_order_count($invoice_no);
                        $OrderStatus = ($printing > 0) ? 55 : 32;
                        $this->db->where('OrderNumber', $invoice_no);
                        $this->db->update('orders', array('OrderStatus' => $OrderStatus,
                            'YourRef' => $do_ec_return['PAYMENTINFO_0_TRANSACTIONID'],
                            'PaymentMethods' => 'paypal',
                            'Old_OrderStatus' => 6,
                            'Payment' => 1));
                    }

                    $payment_taken = $get_ec_return['PAYMENTREQUEST_0_AMT'];
                    $this->insert_payment_log('paypal', $invoice_no, $payment_taken);
                    redirect(main_url . 'order_quotation/Order/orderreview');

                } else {
                    redirect(main_url . 'orderDetailList');
                }

            } else {
                redirect(main_url . 'orderDetailList');
            }

        } else {
            redirect(main_url . 'orderDetailList');
        }

    }


    function printing_order_count($OrderNumber)
    {
        $result = $this->db->query("select count(*) as total from orderdetails WHERE OrderNumber LIKE '" . $OrderNumber . "' AND  Printing LIKE 'Y'");
        $row = $result->row_array();
        return $row['total'];
    }

    function regmark_count($OrderNumber)
    {
        $result = $this->db->query("select count(*) as total from orderdetails WHERE OrderNumber LIKE '" . $OrderNumber . "' AND  regmark LIKE 'Y'");
        $row = $result->row_array();
        return $row['total'];
    }

    public function insert_payment_log($type, $ordermo, $payment, $situation = NULL)
    {
        $situation = (isset($situation) && $situation == "refund") ? "refund" : "taken";
        $array = array('type' => $type, 'OrderNumber' => $ordermo, 'operator' => $this->session->userdata('UserName'), 'payment' => $payment, 'situation' => $situation, 'time' => time());
        $this->db->insert('order_payment_log', $array);
    }

    public function pay_now($orderNumber)
    {
        $data['order'] = $this->orderModal->getOrder($orderNumber);
        $data['orderDetails'] = $this->orderModal->getOrderDetail($orderNumber);
        $data['title'] = 'Order Confirmation ' . $data['order'][0]->OrderNumber;
        $data['mainTitle'] = 'Order Detail ';
        $sandbox_status = 'live'; //sandbox
        if (SITE_MODE == 'live') {
            $sandbox_status = 'live';
        }
        $credentials = array('sandbox_status' => $sandbox_status);
        $this->load->library('rest_paypal', $credentials);
        $data['clientid'] = $this->rest_paypal->getclientid();
        $data['environment'] = $this->rest_paypal->environment();


        // $data['main_content'] = 'order_quotation/checkout/confirm_paypol_amount';
        $this->load->view('order_quotation/checkout/confirm_paypol_amount', $data);
    }

    function pay_now_for_quotation($quotationNumner)
    {
        $data['quotation'] = $this->quotationModal->getQuotation($quotationNumner);

        $data['quotationDetails'] = $this->quotationModal->getQuotationDetail($quotationNumner);
        $data['title'] = 'Quotation Confirmation ' . $data['quotation'][0]->QuotationNumber;
        $data['mainTitle'] = 'Quotation Detail ';
        $sandbox_status = 'live'; //sandbox
        if (SITE_MODE == 'live') {
            $sandbox_status = 'live';
        }
        $credentials = array('sandbox_status' => $sandbox_status);
        $this->load->library('rest_paypal', $credentials);
        $data['clientid'] = $this->rest_paypal->getclientid();
        $data['environment'] = $this->rest_paypal->environment();


        // $data['main_content'] = 'order_quotation/checkout/confirm_paypol_amount';
        $this->load->view('order_quotation/checkout/confirm_paypol_amount_for_quotation', $data);
    }


    public function editAbleCheck()
    {
        $value = $this->input->post('val');
        $orderNumber = $this->input->post('id');
        $param = array(
            'editing' => $value
        );
        $this->db->where('OrderID', $orderNumber);
        $this->db->update('orders', $param);

        $orderNum = $this->getOrderNum($orderNumber);
        $this->check_for_refund($orderNum);

        echo true;
    }

    public function getOrderNum($OrderID)
    {
        $this->db->select('OrderNumber');
        $this->db->from('orders');
        $this->db->where(array('OrderID' => $OrderID));
        $res = $this->db->get()->row_array();
        return $res['OrderNumber'];
    }


    function check_for_refund($order)
    {
        $AccountInfo = $this->orderModal->OrderInfo($order);

        $total_amount_paid = $this->settingmodel->payment_recieved($order);
        $total_amount_paid = number_format($total_amount_paid, 2, '.', '');

        $ship_invat = $AccountInfo[0]->OrderTotal + $AccountInfo[0]->OrderShippingAmount;
        if ($AccountInfo[0]->vat_exempt == 'yes') {
            $ship_invat = $ship_invat / 1.2;
        }

        $ship_invat = number_format($ship_invat, 2, '.', '');
        if ($total_amount_paid > $ship_invat) {
            $amount = number_format(($total_amount_paid - $ship_invat), 2, '.', '');
            $this->refund_email_to_kiran($order, $amount);
        }
    }

    public function refund_email_to_kiran($orderNumber, $amount)
    {
        $message = "Order number " . $orderNumber . " is due for refund for the amount of £" . $amount;
        $this->load->library('email');
        $this->email->initialize(array('mailtype' => 'html',));
        $this->email->subject('Order Editor - Refund - ' . $orderNumber);
        $this->email->from('customercare@aalabels.com', 'Aalabels');
        $this->email->to("kiran@aalabels.com");
        //$this->email->bcc("Shoaib.aalabels@gmail.com");
        $this->email->message($message);
        $this->email->send();
    }

    public function orderNewLine()
    {
        $this->orderModal->orderNewLine($_POST);
        echo true;
    }

    public function deletePlainLine()
    {
        $this->orderModal->deletePlainLine();
        $ordernumber = $this->input->get('ordernumber');
        if (isset($ordernumber) && $ordernumber != "") {
            $this->settingmodel->update_order_total($ordernumber);
        }
        echo true;
    }

    public function updateOrderNewLine()
    {
        $this->orderModal->updateOrderNewLine($_POST);
        echo true;
    }

    public function makeZeroPrice()
    {
        $this->orderModal->makeZeroPrice($this->input->post('orderNumber'));
        echo true;
    }

    function uploadPurchaseOrder()
    {

        $imagename = '';
        if (isset($_FILES['file_up']) and $_FILES['file_up'] != '') {

            $OrderNumber = $this->input->post('OrderNumber');
            $config['upload_path'] = PATH;

            $config['allowed_types'] = 'pdf|doc|PDF|Pdf|DOC|Doc';
            $config['max_size'] = 1000000;
            $config['max_width'] = 1024000;
            $config['max_height'] = 7680000;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);


            $field_name = "file_up";
            if ($this->upload->do_upload($field_name)) {
                $data = array('upload_data' => $this->upload->data());
                $imagename = $data['upload_data']['file_name'];
                $this->db->update('orders', array('po_attachment' => $imagename, 'po_value' => $this->input->post('po_value')), array('OrderNumber' => $OrderNumber));
                echo json_encode(array('file' => $imagename));
            } else {
                print_r($this->upload->display_errors());
            }

        }
    }


    function getdie()
    {
        $val = $this->input->get('term');
        $diecode = $this->input->get('diecode');
        $search = $diecode . $val;


        $qry = "select products.ManufactureID,products.ProductID,products.EuroID,ProductCategoryName,category.Shape_upd,category.LabelWidth,category.LabelHeight,category.specification3 from products 
        inner join category on (SUBSTRING_INDEX(products.CategoryID, 'R', 1 ) = category.CategoryID OR category.CategoryID=products.CategoryID ) 
        
        where products.ManufactureID LIKE '%" . $search . "%' limit 15";
        $query = $this->db->query($qry);
        $row = $query->result();

         $this->db->limit('20');
   // $this->db->select("products.ManufactureID,products.ProductID,products.EuroID,ProductCategoryName,category.Shape_upd,category.LabelWidth,category.LabelHeight,category.specification3")
  //->join("category',('category.CategoryID=products.CategoryID OR category.CategoryID=SUBSTRING_INDEX(products.CategoryID, 'R',1)),'INNER")
  //  ->like("products.ManufactureID",$val,"both");
    //$row = $this->db->get("products");
  // $row = $row->result();
   
   
        foreach ($row as $row) {
            $size = ($row->Shape_upd == 'Circular') ? $row->specification3 : "Label Size : " . $row->LabelHeight . ' x ' . $row->LabelWidth;
            $show_man = (isset($row->EuroID) && $row->EuroID != "") ? $row->EuroID : $row->ManufactureID;

            $data[] = array(
                'label' => $show_man . " " . $size,
                'value' => $row->ManufactureID,
                'id' => $row->ProductID
            );
        };

        if (empty($data)) {
            $data[] = array('label' => 'No Record Found');
        }
        echo json_encode($data);
    }

    function changediecode()
    {

    /*error_reporting('E_ALL');
    ini_set('display_errors',1);*/


        $serial_no = $this->input->post('serial_no');
        $productid = $this->input->post('productid');

        $products = $this->db->query("select * from products where ProductID = $productid ")->row_array();
        $orderdetail = $this->user_model->orderdetial_byserial_get($serial_no);
        $Quantity = $orderdetail['Quantity'];
        $ManufactureID = $products['ManufactureID'];
        $productname = $products['ProductCategoryName'];

        if (preg_match("/Integrated Labels/i", $products['ProductBrand'])) {
            $batch = (preg_match('/250 Sheet Dispenser Packs/is', $orderdetail['ProductName'])) ? 250 : 1000;
            $productname .= (preg_match('/250 Sheet Dispenser Packs/is', $orderdetail['ProductName'])) ? " - (250 Sheet Dispenser Packs)" : " - (1000 Sheet Boxes)";

            $newqty = $this->home_model->calculate_integrated_qty($ManufactureID, $Quantity);
            $price = $this->home_model->single_box_price($ManufactureID, $newqty, $batch);
            
            $total = $price['PlainPrice'];
           
            if ($Quantity != $price['Sheets']) {
                $perbox = $price['PlainPrice'] / $price['Box'];
                $acc_boxes = $Quantity / $batch;
                $calculated_price = $acc_boxes * $perbox;
                $price['PlainPrice'] = $calculated_price;
                
            }
            
            $total = $price['PlainPrice'];
            $ExVat = round($total, 2);
            $IncVat = round($total * vat_rate, 2);

            $update = array(
                'ProductID' => $products['ProductID'],
                'ManufactureID' => $products['ManufactureID'],
                'ProductName' => $productname,
                'Price' => $ExVat,
                'ProductTotalVAT' => $IncVat,
                'ProductTotal' => $IncVat
            );
            
            //echo '<pre>'; print_r($update);
            $this->settingmodel->update_line($serial_no, $update);

        } else {
            if (preg_match('/Roll Labels/is', $products['ProductBrand']) && $orderdetail['Printing'] == "Y") {
                $this->update_printed_roll($products, $orderdetail);
            } else if (preg_match('/Roll Labels/is', $products['ProductBrand'])) {
                $this->update_plain_roll($products, $orderdetail);
            } else {
                $this->update_sheets($products, $orderdetail);
            }
        }

        $this->settingmodel->update_order_total($orderdetail['OrderNumber']);

        $this->settingmodel->add_logs('diecode_changed', $orderdetail['ManufactureID'], $products['ManufactureID'], $orderdetail['OrderNumber'], $serial_no);
    }

    function update_printed_roll($products, $orderdetail)
    {

        $ProductBrand = $products['ProductBrand'];
        $printing = $orderdetail['Printing'];
        $ManufactureID = $products['ManufactureID'];
        $qty = $orderdetail['Quantity'];
        $finish = $orderdetail['FinishType'];
        $press = (isset($orderdetail['pressproof']) && $orderdetail['pressproof'] == 1) ? 1 : 0;
        $labels = $orderdetail['Quantity'] * $orderdetail['LabelsPerRoll'];
        $productname = $products['ProductCategoryName'];

        $min_qty = $this->quoteModel->get_roll_qty($ManufactureID);
        $response = $this->quoteModel->rolls_calculation($min_qty, $products['LabelsPerSheet'], $labels);
        
        //echo '<pre>'; print_r($response);

        $collection['labels'] = $response['total_labels'];
        $collection['manufature'] = $ManufactureID;
        $collection['finish'] = $finish;
        $collection['rolls'] = $response['rolls'];
        $collection['printing'] = $orderdetail['Print_Type'];
        
         //echo '<pre>'; print_r($collection);
         
         
        $price_res = $this->home_model->calculate_printing_price($collection);
        $custom_price = $price_res['final_price'];
        $custom_price = ($press == 1) ? $custom_price + 50.00 : $custom_price;
        if ($qty > $response['rolls']) {
                $add_rolls = $qty - $response['rolls'];
                $additional_cost = $this->quoteModel->additional_charges_rolls($add_rolls);
                $custom_price = $custom_price + $additional_cost;
        }

        $labels = $response['total_labels'];
        $qty = ($qty < $response['rolls']) ? $response['rolls'] : $qty;
        if ($response['total_labels'] != $response['actual_labels']) {
            $labels = $response['total_labels'];
        }

        $ExVat = round($custom_price, 2);
        $IncVat = round($custom_price * vat_rate, 2);

        $update = array(
            'ProductID' => $products['ProductID'],
            'ManufactureID' => $products['ManufactureID'],
            'ProductName' => $productname,
            'Quantity' => $qty,
            'LabelsPerRoll' => $labels / $qty,
            'labels' => $labels,
            'Price' => $ExVat,
            'ProductTotalVAT' => $IncVat,
            'ProductTotal' => $IncVat
        );
        //print_r($update); die();
        $this->settingmodel->update_line($orderdetail['SerialNumber'], $update);
        $this->update_order_artworks($orderdetail['SerialNumber'], $products['ProductID'], $products['ManufactureID']);

    }

    function update_plain_roll($products, $orderdetail)
    {
        $qty = $orderdetail['Quantity'];
       
        $LabelsPerSheet = ($orderdetail['LabelsPerRoll'] != 0) ? $orderdetail['LabelsPerRoll'] : $products['LabelsPerSheet']; 
        
        if($LabelsPerSheet > $products['LabelsPerSheet']){
            $LabelsPerSheet  = $products['LabelsPerSheet'];
        }
        $custom_price = $this->quoteModel->min_roll_price($products['ManufactureID'], $orderdetail['Quantity'], $LabelsPerSheet);
        $productname = $products['ProductCategoryName'];
        
        
         $ci =& get_instance();     
         $reordercode = $ci->shopping_model->product_reordercode($orderdetail['ProductID']);
         $reordercode = $reordercode[0]['ReOrderCode'];
         
         
         $prodName =  $this->orderModal->customize_product_name($orderdetail['is_custom'],$products['ProductCategoryName'],$orderdetail['LabelsPerRoll'],(($qty *  $LabelsPerSheet) / $orderdetail['Quantity']),$reordercode,$orderdetail['ManufactureID'],$products['ProductBrand'],$orderdetail['Wound'],$orderdetail['sample'],'plain');
        $ExVat = round($custom_price, 2);
        $IncVat = round($custom_price * vat_rate, 2);
        $update = array(
            'ProductID' => $products['ProductID'],
            'ManufactureID' => $products['ManufactureID'],
            'ProductName' => $prodName,
            'Quantity' => $qty,
            'labels'  => ($qty *  $LabelsPerSheet),
            'LabelsPerRoll'  => ($qty *  $LabelsPerSheet) / $qty ,
            'is_custom' => (($qty *  $LabelsPerSheet) / $qty == ($qty *  $LabelsPerSheet))?'No':'Yes',
            'Price' => $ExVat,
            'ProductTotalVAT' => $IncVat,
            'ProductTotal' => $IncVat
        );
        //print_r($update); die();
        $this->settingmodel->update_line($orderdetail['SerialNumber'], $update);
    }

    function update_sheets($products, $orderdetail)
    {

        $ManufactureID = "";
        $qty = $orderdetail['Quantity'];
        $qty = ($qty < 25) ? 25 : $qty;
        $productname = $products['ProductCategoryName'];

        if (substr($ManufactureID, -2, 2) == 'XS') {
            $qty = $this->special_xmass_qty($qty);
        }
        /*****************WPEP Offer************/
        $wpep_discount = 0.00;
        $custom_price = $this->quoteModel->getPrize($qty, $products['ManufactureID']);
        if (preg_match("/A4 Labels/i", $products['ProductBrand'])) {
            $mat_code = $this->quoteModel->getmaterialcode($products['ManufactureID']);
            $material_discount = $this->quoteModel->check_material_discount($mat_code);
            if ($material_discount) {
                $custom_price = ($custom_price * 1.2);
                $wpep_discount = (($custom_price) * ($material_discount / 100));
                $total = $custom_price - $wpep_discount;
                $custom_price = $total / 1.2;
            }
        }
        /*****************WPEP Offer************/
        $ExVat = round($custom_price, 2);
        $IncVat = round($custom_price * vat_rate, 2);

        $update = array(
            'ProductID' => $products['ProductID'],
            'ManufactureID' => $products['ManufactureID'],
            'ProductName' => $productname,
            'Quantity' => $qty,
            'Price' => $ExVat,
            'ProductTotalVAT' => $IncVat,
            'ProductTotal' => $IncVat
        );
        //print_r($update); die();
        $this->settingmodel->update_line($orderdetail['SerialNumber'], $update);

        if ($orderdetail['Printing'] == "Y") {
            $this->update_order_artworks($orderdetail['SerialNumber'], $products['ProductID'], $products['ManufactureID']);
            $this->update_printing($products, $orderdetail);
        }

    }

    function update_order_artworks($serial, $producid, $diecode)
    {
        $this->db->where('Serial', $serial);
        $this->db->update('order_attachments_integrated', array('ProductID' => $producid, 'diecode' => $diecode));
    }

    function update_printing($products, $orderdetail)
    {
        $sheets = $orderdetail['Quantity'];
        $labels = $products['LabelsPerSheet'];
        $type = $orderdetail['Print_Type'];
        $design = $orderdetail['Print_Design'];

        if ($sheets <= 49) {
            $condtion = "49";
        } else if ($sheets > 49 && $sheets <= 99) {
            $condtion = "99";
        } else if ($sheets > 99 && $sheets <= 199) {
            $condtion = "199";
        } else if ($sheets > 199 && $sheets <= 299) {
            $condtion = "299";
        } else if ($sheets > 299 && $sheets <= 399) {
            $condtion = "399";
        } else if ($sheets > 399 && $sheets <= 499) {
            $condtion = "499";
        } else if ($sheets > 499 && $sheets <= 999) {
            $condtion = "999";
        } else if ($sheets > 999 && $sheets <= 2499) {
            $condtion = "2499";
        } else if ($sheets > 2499 && $sheets <= 4999) {
            $condtion = "4999";
        } else if ($sheets > 4999 && $sheets <= 9999) {
            $condtion = "9999";
        } else if ($sheets > 9999 && $sheets <= 14999) {
            $condtion = "14999";
        } else if ($sheets > 14999 && $sheets <= 19999) {
            $condtion = "19999";
        } else if ($sheets > 19999 && $sheets <= 29999) {
            $condtion = "29999";
        } else if ($sheets > 29999 && $sheets <= 39999) {
            $condtion = "39999";
        } else if ($sheets > 40000) {
            $condtion = "40000";
        }
        $result = $this->quoteModel->get_print_price($condtion);
        $unitprice = $result[$type] * $sheets;
        /************* percentage rate ********************/
        $condition = "   max_labels >= " . $labels . " AND  min_labels  <= " . $labels;
        $row = $this->db->query("SELECT percentage FROM `a4_printing_discounts` where  $condition LIMIT 1")->row_array();
        if (isset($row['percentage']) and $row['percentage'] > 0) {
            $percentage = (100 - $row['percentage']) / 100;
            $unitprice = $unitprice / $percentage;
        }
        /************* percentage rate ********************/

        $unitprice = $this->quoteModel->check_price_uplift($unitprice);
        /************* 50% discount rate ********************/
        if (preg_match('/A4/is', $products['ProductBrand'])) {
            $unitprice = $unitprice / 2;
        }
        /***************************************************/
        if (!preg_match('/A4/is', $products['ProductBrand'])) {
            $unitprice = $unitprice * 1.5;
        }

        $free_art = $result['Free'];
        $qty = $discount_qty = 1;
        $total_price = $unitprice;

        if ($design == "Multiple Designs") {
            $qty = $orderdetail['Print_Qty'];
            $discount_qty = ($free_art >= $qty) ? 0 : $qty - $free_art;
            $sub_total = $discount_qty * 5.00;
            $sub_total = $this->quoteModel->check_price_uplift($sub_total);
            $total_price = $unitprice + $sub_total;
        }

        $update = array(
            'Printing' => "Y",
            'Print_Type' => $type,
            'Print_Design' => $design,
            'Print_Qty' => $qty,
            'Free' => $free_art,
            'Print_UnitPrice' => $unitprice,
            'Print_Total' => $total_price
        );
        //print_r($update); die();
        $this->settingmodel->update_line($orderdetail['SerialNumber'], $update);
    }


    function load_flash_panel()
    {
        $design_id = $this->input->post('design_id');
        $serial = $this->input->post('serial');
        $data['temp_id'] = $design_id;
        $data['serial'] = $serial;
        $theHTMLResponse = $this->load->View('order/flash_panel', $data);
        echo $theHTMLResponse;
    }


    public function refundamount($orderNumber, $refundtype, $amount)
    {

        $this->orderModal->insert_payment_log($refundtype, $orderNumber, $amount, 'refund');
        $message = " The Amount " . $amount . " is Refunded for Order Number " . $orderNumber . " through " . $refundtype . " by " . $this->loginame . ".";
        if (MODE == 'live') {
            $this->settingmodel->email_to_kiran($orderNumber, $message);
        }

        //$this->orderreview($orderNumber);
        redirect(main_url . 'order_quotation/order/getOrderDetail/' . $orderNumber);



    }


    function getShipService()
    {

        $service = $this->input->post('ship_id');
        $ordernumber = $this->input->post('ordernumber');
        $old_ship = trim($this->input->post('old_shipping'));
        $total = $this->input->post('total');

        $deliveryCourier = $this->input->post('deliveryCourier');

        $old_shipping = $this->home_model->get_db_column('shippingservices', 'ServiceName', 'ServiceID', $old_ship);
        $new_shipping = $this->home_model->get_db_column('shippingservices', 'ServiceName', 'ServiceID', $service);

        $message = "Order Delivery Service has Changed From <b> " . $old_shipping . " </b> to <b> " . $new_shipping . " </b>";
        //$this->settingmodel->add_activity($message,$ordernumber,'---','');

      // echo $ordernumber;
     //  echo "<br />";
      ///  echo $service;
       // echo "<br />";
       // echo $total;
       // echo "<br />";

        $shiptotal = $this->settingmodel->calculate_shipping($ordernumber, $service, $total);
       // echo "<br />";
       //// echo $shiptotal;
       // echo "<br />";
        
        if (isset($ordernumber) && $ordernumber != '' && $ordernumber != '0') {
            if ($service == 11 || $service == 33 || preg_match('/-S/', $ordernumber)) {
                $shiptotal = 0.00;
            }

            // AA21 STARTS
            $query = $this->db->query("Select DeliveryPostcode, DeliveryCountry from orders WHERE OrderNumber = '" . $ordernumber . "' ");
            $row = $query->row_array();
            if ((isset($row['DeliveryPostcode']) && $row['DeliveryPostcode'] != '') && (isset($row['DeliveryCountry']) && $row['DeliveryCountry'] != '') && ($deliveryCourier == 'DPD')) {
                $D_postcode = $row['DeliveryPostcode'];
                $DeliveryCountry = $row['DeliveryCountry'];
                $offshore = $this->product_model->offshore_delviery_charges_WPC($D_postcode, $DeliveryCountry);

                if (($offshore['status'] != true) && ($DeliveryCountry == 'United Kingdom') && ($shiptotal > 0)) {
                    $shiptotal = $shiptotal + 1;
                }
            }

            // $shiptotal = $shiptotal * vat_rate;
            // AA21 ENDS
           // echo "<br />";
            //echo $shiptotal;
            //die();
            $update = array('OrderShippingAmount' => $shiptotal, 'ShippingServiceID' => $service, 'expectedDispatchDate' => '', "OrderDeliveryCourier" => $deliveryCourier, 'ShippingServiceID_Old' => $old_ship);
            $this->db->where('OrderNumber', $ordernumber);
            $this->db->update('orders', $update);
            $this->custom->assign_dispatch_date($ordernumber, TRUE);
        }


        //$this->settingmodel->add_logs('Delivery_changed',$old_shipping,$new_shipping,$ordernumber,'');
    }


    function zerodowndelivery($ordernumber)
    {
        if (isset($ordernumber) && $ordernumber != "") {
            $update = array('OrderShippingAmount' => 0.00);
            $this->db->where('OrderNumber', $ordernumber);
            $this->db->update('orders', $update);
            $this->settingmodel->add_logs('zero_delivery', "", "", $ordernumber, "");
        }
    }

    function changeorderlabel($ordernumber, $value)
    {
        if (isset($ordernumber) && $ordernumber != "") {
            $update = array('Label' => $value);
            $this->db->where('OrderNumber', $ordernumber);
            $this->db->update('orders', $update);
            $this->settingmodel->add_logs('changeorderlabel', $value, "", $ordernumber, "");
        }
    }

    function update_note()
    {
        $id = filter_var($this->input->get('Line', true), FILTER_VALIDATE_INT);
        $status = filter_var($this->input->get('status', true), FILTER_SANITIZE_STRING);
        if ($status == "Delete") {
            $value = "";
        } else {
            $value = $status;
        }
        $this->db->where('SerialNumber', $id);
        $this->db->update('orderdetails', array('Product_detail' => $value));
        echo json_encode(array('res' => 'true'));
    }

    public function changeStatus()
    {
        
        $status = filter_var($this->input->get('status'), FILTER_VALIDATE_INT);
        // $status = $this->input->get('status');
        $id = filter_var($this->input->get('id'), FILTER_VALIDATE_INT);

        // $id = $this->input->get('id');
        $this->orderModal->changestatus($id, $status);
        
        if ($status==10) {
            $orderNumber = $this->orderModal->getordernumber($id);

            $message = " Dear Admin, The Order Number (" . $orderNumber . ") is given On Hold status by " . $this->loginame . ".";
            $this->settingmodel->email_to_kiran_and_umer($orderNumber, $message);
        }

    }


    function add_customer()
    {
        $this->load->view('order_quotation/add_customer');
    }

    function edit_customer()
    {
        $id = $this->input->post('UserID');

        $data['customer'] = $this->customerModel->getCustomers($id);
        $this->load->view('order_quotation/update_customer', $data);
    }

    function update_customer()
    {
        $id = $this->input->post('UserID');

        $this->customerModel->updatecustomer($id);
        //redirect(main_url.'order_quotation/Order');
    }


    public function add_contact()
    {
        if ($this->input->post() == TRUE) {
            /*----------Newsletter Subscription---------------*/

            $newsletter = $this->input->post('newsletter_val');

            if (isset($newsletter) and $newsletter == 1) {

                $UserEmail = $this->input->post('UserEmail');

                if (empty($UserEmail)) {

                    $UserEmail = $this->input->post('hideUserEmail');

                }

                $this->customerModel->newsletter($UserEmail);

            }

            /*----------Newsletter Subscription---------------*/

            $this->customerModel->AddContact();

            redirect(main_url . 'order_quotation/Order');

        } else {


            $data['main_content'] = 'order_quotation';

            $this->load->view('page', $data);

        }

    }


    public function paypalmanual($orderNumber, $type)
    {
        $orderInfo = $this->orderModal->getOrder($orderNumber);
        //echo '<pre>';	print_r($orderInfo); echo'</pre>';
        $amount = number_format($orderInfo[0]->OrderTotal + $orderInfo[0]->OrderShippingAmount, 2, '.', '');
        if ($orderInfo[0]->vat_exempt == 'yes') {
            $amount = number_format(($amount / 1.2), 2, '.', '');
        }

        // NEW CODE FOR ORDER EDITOR
        if ($type == "partpayment") {
            $amount_received = $this->settingmodel->payment_recieved($orderNumber);
            $amount = $amount - $amount_received;
            $amount = number_format($amount, 2, '.', '');
        }
        $payment_taken = $amount;
        // NEW CODE FOR ORDER EDITOR


        $message = " The Amount " . $payment_taken . " is Taken for Order Number " . $orderNumber . " through paypal by " . $this->loginame . ".";
        $this->settingmodel->email_to_kiran($orderNumber, $message);


        $this->orderModal->insert_payment_log('paypal', $orderNumber, $payment_taken, '');
        //$this->fetch_despatch_date($orderNumber);
        redirect(main_url . 'order_quotation/order/getOrderDetail/' . $orderNumber);
        //redirect(main_url.'order_quotation/getOrderDetail');
    }


    public function bacscheque($orderNumber, $type)
    {
        $orderInfo = $this->orderModal->getOrder($orderNumber);
        $amount = number_format($orderInfo[0]->OrderTotal + $orderInfo[0]->OrderShippingAmount, 2, '.', '');
        if ($orderInfo[0]->vat_exempt == 'yes') {
            $amount = number_format(($amount / 1.2), 2, '.', '');
        }

        // NEW CODE FOR ORDER EDITOR
        if ($type == "partpayment") {
            $amount_received = $this->settingmodel->payment_recieved($orderNumber);
            $amount = $amount - $amount_received;
            $amount = number_format($amount, 2, '.', '');
        }
        $payment_taken = $amount;
        // NEW CODE FOR ORDER EDITOR


        $message = " The Amount " . $payment_taken . " is Taken for Order Number " . $orderNumber . " through bacscheque by " . $this->loginame . ".";
        $this->settingmodel->email_to_kiran($orderNumber, $message);

        $this->orderModal->insert_payment_log('bacscheque', $orderNumber, $payment_taken);
        //$this->fetch_despatch_date($orderNumber);
        redirect(main_url . 'order_quotation/order/getOrderDetail/' . $orderNumber);
    }

    function fetch_despatch_date($order)
    {
        $this->custom->assign_dispatch_date($order,TRUE);
        
        echo $this->db->last_query();
    }


    public function block_callbacks()
    {

        $action = $this->input->post('action');
        $userid = $this->input->post('UserID');
        $desc = $this->input->post('comment');
        $operator = $this->session->userdata('UserID');
        $record = array('cus_id' => $userid,
            'operator' => $operator,
            'comment' => $desc,
            'date' => time()
        );
        if (isset($userid) and $userid != '') {
            $this->db->insert('tbl_followup_calls', $record);
            $this->db->insert_id();
            $this->db->where('UserID', $userid);
            $this->db->update('customers', array('callback_ignore' => $action));
            echo json_encode(array('response' => 'yes'));
        }

    }


    public function convert_cus()
    {
        $id = $this->input->post('UserID');
        $data['customer'] = $this->customerModel->getCustomers($id);
        $this->load->view('order_quotation/convert-customer-trade', $data);
    }

    public function update_wholesale()
    {
        $id = $this->input->post('UserID');
        $this->customerModel->updatewholesale($id);
    }


    public function forgotpassword()
    {
        if ($this->input->get() == TRUE) {
            $email = filter_var($this->input->get('email'), FILTER_SANITIZE_EMAIL);
            //   $email =$this->input->get('email');
            $msg = $this->customerModel->forgotpassword($email);
            echo $msg;

        }

    }

    public function follow_up()
    {
        $id = $this->input->post('UserID');
        $data['customer'] = $this->customerModel->getCustomers($id);
        $data['follow'] = $follow = $this->customerModel->getFollowup($id);

        $this->load->view('order_quotation/followup-calls', $data);
    }

    function update_billing()
    {
        $id = $this->input->post('OrderID');
        $this->orderModal->updateBilling($id);

    }

    function update_delivery()
    {
        $id = $this->input->post('OrderID');
        $this->orderModal->updateDelivery($id);

    }
    
   function applydiscount($orderno){
		  $orderno       = $this->input->post('orderno');
		  $discountvalue = $this->input->post('discountvalue');
		  $apply       = $this->input->post('apply');
		  $orderdata = $this->orderModal->getOrder($orderno)[0];
		  
		  if(isset($orderdata->OrderNumber) && $apply == "add"){ 
			   $ordertotal =  $orderdata->OrderTotal + $orderdata->voucherDiscount;
			   $discount = ($ordertotal * $discountvalue)/100;
			   $neworder_total = $ordertotal  - $discount;
			  
			   $this->db->where('OrderNumber',$orderno);
			   $this->db->update('orders',array('voucherOfferd'=>'Yes','voucherDiscount'=>$discount,'OrderTotal'=>$neworder_total));
			   
			   $message = $discountvalue."% Discount is Applied Against the Order.";
			   $this->settingmodel->add_activity($message,$orderno,'','');
			   echo $discount;
		     
		 }else if(isset($orderdata->OrderNumber) && $apply == "remove"){
		   $neworder_total = $orderdata->OrderTotal + $orderdata->voucherDiscount;
		   $this->db->where('OrderNumber',$orderno);
		   $this->db->update('orders',array('voucherOfferd'=>'No','voucherDiscount'=>'0','OrderTotal'=>$neworder_total));
		   
		   $message = "Discount is Removed Against the Order.";
		   $this->settingmodel->add_activity($message,$orderno,'','');
		   echo $discount;
		}
     }
	 
	
	 function order_vat_validate(){

	    $country     = $this->input->post('country');
        $vatNumber   = $this->input->post('vatNumber');
		$OrderNumber = $this->input->post('OrderNumber');

        $vatNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatNumber));
        $data = array('status' => 'Invalid', 'message' => 'Invalid VAT Number');
        if (isset($vatNumber) and $vatNumber != '') {
            $countryCode = $this->country_code($country);
            $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");


            try {
                $response = $client->checkVat(array('countryCode' => $countryCode, 'vatNumber' => trim($vatNumber)));
               
                if (isset($response->valid) and $response->valid == 1) {

                    /*******************Vat Check Logger ************************/
                    $userid = $this->input->post('userid');
                    $email  = $this->input->post('email');
                    $this->db->insert('vat_checker_log', array('vat_number' => $vatNumber, 'userid' => $userid, 'email' => $email));
                    /**************************************************************/
					
					$order_array = array('vat_exempt'=>'yes','CustomOrder'=>$vatNumber);
					if(isset($OrderNumber) && $OrderNumber!=""){
					  $this->db->where('OrderNumber',$OrderNumber);
                      $this->db->update("orders",$order_array);
					  $data = array('status' => 'valid', 'message' => 'valid VAT Number');
					}
				 }
            } catch (SoapFault $e) {
                $this->session->set_userdata('vat_exemption', '');
                $data = array('status' => 'Invalid', 'message' => 'Invalid VAT Number');
            }
        }
        echo json_encode($data);
	}
	
	function removevat_validator(){
	 $OrderNumber = $this->input->post('OrderNumber');
	 $data = array('status' => 'Invalid', 'message' => 'Invalid VAT Number');
	 
	 if(isset($OrderNumber) && $OrderNumber!=""){
		 $order_array = array('vat_exempt'=>'no','CustomOrder'=>0);
		 $this->db->where('OrderNumber',$OrderNumber);
		 $this->db->update("orders",$order_array);
		 $data = array('status' => 'valid', 'message' => 'valid VAT Number');
	 }
	 echo json_encode($data);
  }
  
  function country_code($country)
    {

        return $countrucode = $this->home_model->get_db_column('shippingcountries', 'c_code', 'name', $country);

        $countrucode = array('Ireland' => 'IE',
            'Belgium' => 'BE',
            'Denmark' => 'DK',
            'France' => 'FR',
            'Holland' => 'NL',
            'Germany' => 'DE',
            'Sweden' => 'SE',
            'Spain' => 'ES',
            'Switzerland' => 'CH',
            'Luxembourg' => 'LU',
            'United Kingdom' => 'GB');
        //return 'GB';
        return $countrucode[$country];
    }


    function remove_from_stock(){
        $serial = $this->input->post('serial');
        $ordernumber = $this->input->post('ordernumber');
        $this->orderModal->adjust_stock_level($serial,$ordernumber);
    }
    
    public function artwork_details_data(){
        $cartid = $this->input->post('cartid');
        $artworkID = $this->input->post('artworkID');
        $name = $this->input->post('name');
        $qty = $this->input->post('qty');
        $labels = $this->input->post('labels');
        $stat = $this->orderModal->countArtworkStatus($cartid);
        $artwork_qty = 0;
        $artwork_labels = 0;
        $artwork_count = 0;
        $artworks = json_decode($this->input->post('artwork_details_data'));


            $up = array(
                'name' => $name,
                'qty' => $qty,
                'labels' => $labels
            );
            if($artworkID && $artworkID > 0){
                $this->db->where('ID', $artworkID);
                $this->db->update('integrated_attachments', $up);
            }else{
                $product_id = $this->input->post('product_id');
                $status = $this->input->post('status');
                $source = $this->input->post('source');
                $type = $this->input->post('type');
                $file = $this->input->post('file');
                $SessionID = $this->session->userdata('session_id');



                $add = array(
                    'CartID' => $cartid,
                    'ProductID' => $product_id,
                    'status' => $status,
                    'source' => $source,
                    'type' => $type,
                    'name' => $name,
                    'qty' => $qty,
                    'labels' => $labels,
                    'SessionID' => $SessionID
                );

                if ($_FILES['file']['name'] != "") {
                    $add['file'] = $this->uploadImages('file');
                }

                $this->db->insert('integrated_attachments', $add);
            }


            $artwork_qty += $qty;
            $artwork_labels += $labels;
            $artwork_count += 1;


        $stat[0]->totalQuantity = $artwork_qty;
        $stat[0]->totalLabels = $artwork_labels;
        $stat[0]->count = $artwork_count;

        $stat = $this->orderModal->countArtworkStatus($cartid);

        $json_data = array(
            'status' => '1',
            'price' => 0.00,
            'statics' => $stat
        );
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json_data));


    }


    public function artwork_details_data_order_edit(){
        $cartid = $this->input->post('cartid');
        $artworkID = $this->input->post('artworkID');
        $name = $this->input->post('name');
        $qty = $this->input->post('qty');
        $labels = $this->input->post('labels');

        $orderNumber = $this->input->post('orderNumber');
        $manfactureId = $this->input->post('manfactureId');
        $serialNumber = $this->input->post('serialNumber');
        $per_shet_roll = $labels / $qty;
        $stat = $this->orderModal->countArtworkStatus($cartid);


        $artwork_qty = 0;
        $artwork_labels = 0;
        $artwork_count = 0;

        $filename = $_FILES['file']['name'];
       
            // if artwork is uploaded from order detail page
            $params = $this->orderModal->uploadArtworkInOrderIntegrated();
          
            if ($artworkID && $artworkID > 0) {
                $this->db->where('ID', $artworkID);
                $this->db->update('order_attachments_integrated', $params);
                $latestArtworkId = $artworkID;
            } else {

                if ($_FILES['file']['name'] != "") {
                    $params['file'] = $this->uploadImages('file');
                }
                $this->db->insert('order_attachments_integrated', $params);
                $latestArtworkId = $this->db->insert_id();
            }

            $count = $this->countArtworkFromOrderDetail($_POST['serialNumber'], $this->input->post('brandName'));
            $status = $this->orderModal->countArtworkStatusFromOrderAttach($_POST['serialNumber']);
            $static['statics'] = $this->orderModal->countArtworkStatusFromOrderAttach($_POST['serialNumber'])[0];
            $this->orderModal->updateIntoOrderDetailTableNew($static);
            $records['totalPrice'] = 0;

            $static['per_shet_roll'] = $per_shet_roll;

        echo json_encode(
            array('response' => 'yes',
                'count' => $count,
                'price' => $records['totalPrice'],
                'statics' => $status,
                'latestArtworkId' => $latestArtworkId,
                'elsePrice' => $records,
            ));

    }


    public function artwork_details_data_quotation_edit(){
        $cartid = $this->input->post('cartid');
        $artworkID = $this->input->post('artworkID');
        $name = $this->input->post('name');
        $qty = $this->input->post('qty');
        $labels = $this->input->post('labels');

        $orderNumber = $this->input->post('orderNumber');
        $manfactureId = $this->input->post('manfactureId');
        $serialNumber = $this->input->post('serialNumber');

        $per_shet_roll = $labels / $qty;
        $stat = $this->orderModal->countArtworkStatus($cartid);

        $artwork_qty = 0;
        $artwork_labels = 0;
        $artwork_count = 0;

        $filename = $_FILES['file']['name'];
    
        // if artwork is uploaded from quotation detail page

        $params = $this->orderModal->uploadArtworkInQuotationIntegrated();
        $labelsPerSheet = $params['labelsPerSheet'];
        unset($params['labelsPerSheet']);
       
        if ($artworkID && $artworkID > 0) {
            $this->db->where('ID', $artworkID);
            $this->db->update('quotation_attachments_integrated', $params);
            $latestArtworkId = $artworkID;
        } else {

            if($qty && $qty > 0 && $labels && $labels > 0 && $name){
                if ($_FILES['file']['name'] != "") {
                    $params['file'] = $this->uploadImages('file');

                    $this->db->insert('quotation_attachments_integrated', $params);
                    $latestArtworkId = $this->db->insert_id();
                }
            }
        }

        $count = $this->countArtworkFromQuotationDetail($_POST['serialNumber'], $this->input->post('brandName'));
        $status = $this->orderModal->countArtworkStatusFromQuotationIntegrated($_POST['serialNumber']);
        $static['statics'] = $this->orderModal->countArtworkStatusFromQuotationIntegrated($_POST['serialNumber'])[0];

        $this->orderModal->updateIntoQuotatonDetailTableNew($static);

        $status['labelsPerSheet'] = $labelsPerSheet;
        $records['totalPrice'] = 0;

        echo json_encode(
            array('response' => 'yes',
                'count' => $count,
                'price' => $records['totalPrice'],
                'statics' => $status,
                'latestArtworkId' => $latestArtworkId,
                'elsePrice' => $records,
            ));
    }

    /****************************************************/
    /***********LABEL EMBELLISHMENT TASK START***********/
    /****************************************************/

    function new_print_service()
    {
        $data['main_content'] = 'order_quotation/label_embellishment_print_service/label_emb_page/main';
        $this->load->View('order_quotation/label_embellishment_print_service/page', $data);
    }

    function edit_cart_main( $edit_cart_flag = NULL, $temp_basket_id = NULL )
    {
        $data['main_content'] = 'order_quotation/label_embellishment_print_service/label_emb_page/edit_cart_main';
        $data['edit_cart_flag'] = $edit_cart_flag;
        $data['temp_basket_id'] = $temp_basket_id;
        $this->load->View('order_quotation/label_embellishment_print_service/page', $data);
    }

    function print_service()
    {

        //$this->db->query("Delete from temporaryshoppingbasket");
        //$this->db->query("Delete from integrated_attachments");

        //$this->db->query("Delete from temporaryshoppingbasket WHERE SessionID LIKE '%-PRJB%' ");
        //$this->db->query("Delete from integrated_attachments WHERE SessionID  LIKE '%-PRJB%' ");

        $condtion = " c.CategoryActive = 'Y' AND c.Shape != '' AND p.ProductBrand LIKE 'A4 Labels' ";
        $shape_list = $this->orderModal->category_shapes($condtion);
        $shapes = $this->orderModal->genrate_shapes($shape_list, 'Rectangle');
        $data['shapes'] = str_replace('data-toggle="tooltip"', '', $shapes);
//                echo "<pre>";print_r($shape_list);die;

        $shapes_plain = array();
        foreach ($shape_list as $shapee) {
            $shapes_plain[] = $shapee->Shapes;
        }
        $data['shapes_plain'] = $shapes_plain;
        $data['main_content'] = 'order_quotation/label_embellishment_print_service/index';
        $this->load->View('page', $data);
    }

    function material_print_service()
    {

        $condtion = " c.CategoryActive = 'Y' AND c.Shape != '' AND p.ProductBrand LIKE 'A4 Labels' ";
        $shape_list = $this->orderModal->category_shapes($condtion);
        $shapes = $this->orderModal->genrate_shapes($shape_list, 'Rectangle');
        $data['shapes'] = str_replace('data-toggle="tooltip"', '', $shapes);
        $shapes_plain = array();
        foreach ($shape_list as $shapee) {
            $shapes_plain[] = $shapee->Shapes;
        }

        $data['shapes_plain'] = $shapes_plain;
        $data['main_content'] = 'order_quotation/label_embellishment_print_service/material_print_service/index';
        $this->load->View('page', $data);
    }

    function edit_emb_options($flag=NULL,$orderNumber=NULL,$serialNumber=NULL){

        if (isset($flag) && $flag =='order_detail'){
            $data['lineDetail'] = $this->orderModal->getOrderDetailBySerialNumber($serialNumber);
            $data['customer_id'] = $data['lineDetail']->UserID;

            $total_lines = $this->orderModal->getArtworkByOrder($serialNumber);
            $uploaded_lines = $this->db->query("select count(*) as total_files from order_attachments_integrated where Serial='".$serialNumber."'
             AND (file != '' OR file != 'No File Required For Artwork To Follow') ")->row_array()['total_files'];
            $data['artwork_total_lines'] =  count($total_lines);
            if ($uploaded_lines > 0){
                $data['upload_artwork'] = 'yes';
                $data['artwork_to_follow'] = 'no';
            } else {
                $data['artwork_to_follow'] = 'yes';
                $data['upload_artwork'] = 'no';
            }
        } elseif (isset($flag) && $flag=='quotation_detail'){
            $data['lineDetail'] = $this->orderModal->getQuotationDetailBySerialNumber($serialNumber);
            $data['customer_id'] = $data['lineDetail']->CustomerID;

            $total_lines = $this->orderModal->getArtworkForQuotation($serialNumber);
            $uploaded_lines = $this->db->query("select count(*) as total_files from quotation_attachments_integrated where Serial='".$serialNumber."'
             AND (file != '' OR file != 'No File Required For Artwork To Follow') ")->row_array()['total_files'];
            $data['artwork_total_lines'] =  count($total_lines);
            if ($uploaded_lines > 0){
                $data['upload_artwork'] = 'yes';
                $data['artwork_to_follow'] = 'no';
            } else {
                $data['artwork_to_follow'] = 'yes';
                $data['upload_artwork'] = 'no';
            }
        }

        $this->session->set_userdata('customer_id',$data['customer_id']);

        $data['refNumber'] = $orderNumber; //OrderNumber,QuotationNumber
        $data['lineNumber'] = $serialNumber; //O_SerialNumer,Q_SerialNumner
        $data['flag'] = $flag;
        $data['returnUrl'] = $_SERVER['HTTP_REFERER'];
        $data['main_content'] = 'order_quotation/label_embellishment_print_service/label_emb_page/edit_main';

        /*echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();*/

        $this->load->View('order_quotation/label_embellishment_print_service/page', $data);
    }

    /***************************************************/
    /***********LABEL EMBELLISHMENT TASK ENDS***********/
    /***************************************************/

}
