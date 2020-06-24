<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('order_quotation/orderModal');
        $this->load->model('cart/cartModal');
        $this->load->model('quoteModel');
        $this->home_model->user_login_ajax();
    }

    function test($order_no)
    {
        $d = $data['order'] = $this->orderModal->getOrder($order_no);
        $data['orderDetails'] = $this->orderModal->getOrderDetail($order_no);
        $data['main_content'] = 'order_quotation/checkout/confirm_my_order';
        $this->load->view('page', $data);
    }

    public function setToCart()
    {

        $data['checkoutArtwork'] = $this->input->post('checkoutArtwork');
        $data['manfactureId'] = $this->input->post('manfactureId');
        $data['serialNumber'] = $this->input->post('serialNumber');
        $data['productId'] = $this->input->post('productId');
        $data['orderNumber'] = $this->input->post('orderNumber');
        $data['qty'] = $this->input->post('qty');
        $data['plain_print'] = $this->input->post('plain_print');
        $remark = $this->input->post('regmark');

        $data['cartId'] = $this->input->post('cartId');
        $data['price'] = $this->input->post('price');
        $data['labelperroll'] = $this->input->post('labelperroll');

        $data['per_shet_roll'] = $this->input->post('per_shet_roll');

        $data['original_price'] = $this->input->post('original_price');
        $data['reorder_type'] = $this->input->post('reorder_type');

        $Custom_design = $this->input->post('cus_design');
        $Custom_labels = $this->input->post('cus_labl');
        $Custom_rolll = $this->input->post('cus_roll');

        if ($data['plain_print'] == 'N' || $remark == 'Y') {
            echo $this->makePlainData($this->getParams($data), $data);
        } else {
            //echo 'else';
            $record = $this->orderModal->countArtworkStatus($data['cartId']);
            //print_r($record);

            if (array_key_exists('count', $record) == false && $Custom_design != "") {
                $g = (object)['count' => $Custom_design, 'totalLabels' => $Custom_labels, 'totalQuantity' => $Custom_rolll];
                $record[0] = $g;
            }


            $data['statics'] = $record[0];
            //print_r($data['statics']);exit;
            if ($data['statics']->totalQuantity == "") {
                $data['statics']->totalQuantity = $data['qty'];
            }


            if ($data['statics']->totalLabels == "" || $data['statics']->totalLabels == 0) {
                $data['statics']->totalLabels = round($data['statics']->totalQuantity * $data['per_shet_roll'], 2);
            }
            //print_r($data['statics']); exit;

            if ($data['checkoutArtwork'] == 'yes') {
                echo $this->updateInCart($data);
            } else {
                echo $this->makePrintingData($this->getParams($data), $data);
            }
        }
    }

    public function updateInCart($record)
    {
        //print_r($record);exit;

        $data = array(
            'Quantity' => $record['statics']->totalQuantity,
            'orignalQty' => $record['statics']->totalQuantity,
            'UnitPrice' => $record['original_price'] / $record['statics']->totalQuantity,
            'TotalPrice' => $record['original_price'],
        );

        $this->db->where('ID', $record['cartId']);
        $this->db->update('temporaryshoppingbasket', $data);


        $response = json_encode(array('response' => 'true', 'price' => $this->cartModal->getCarTotalPrice()));
        return $response;
    }

    public function getCartPrice()
    {
        $response = json_encode(array('response' => 'true', 'price' => $this->cartModal->getCarTotalPrice()));
        echo $response;
    }

    public function makePlainData($records, $data)
    {

        $dataArray = '';

        try {

            if ($records->ProductBrand == 'A4 Labels' || $records->ProductBrand == 'A3 Label' || $records->ProductBrand == 'SRA3 Label' || $records->ProductBrand == 'Integrated Labels' || $records->ProductBrand == 'A5 Labels') {

                $data['price'] = $this->myPriceModel->getPrice($data['serialNumber'], $data['orderNumber'], $data['manfactureId'], $data)['totalPrice'];

                //print_r($data['price']);

                $dataArray = $this->makePlainArray($records, $data);
            } elseif ($records->ProductBrand == 'Roll Labels') {
                // print_r($this->myPriceModel->getPrice($data['orderNumber'],$data['manfactureId'],$data));exit;
                $data['price'] = $this->myPriceModel->getPrice($data['serialNumber'], $data['orderNumber'], $data['manfactureId'], $data)['totalPrice'];
                $dataArray = $this->makePlainArray($records, $data);
                $dataArray['wound'] = ($records->Wound == null) ? '' : $records->Wound;
                //$data['is_custom'] = ($records->LabelsPerRoll == $records->LabelsPerSheet) ? 'N' : 'Y';
                $dataArray['is_custom'] = ($records->LabelsPerRoll == $records->LabelsPerSheet) ? 'No' : 'Yes';

            }

            //print_r($dataArray);exit;


            $respo = '';

            if ($data['reorder_type'] == "") {
                //echo 'sds';
                $this->insertRecord($dataArray);
                $respo = $this->sendResponse($records);
            } else {
                //echo 'ele';
                $respo = $this->sendResponse($dataArray);
            }
            //print_r($respo);exit;

            return $respo;

        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

    }

    public function makePrintingData($record, $data)
    {

        try {

            $printArray = $this->makePrintedArray($record, $data);
            $data['originalCartId'] = $this->insertRecord($printArray);


            if ($this->assignCartIdIntegratedAttachment($data)) {
                return $this->sendResponse($record);
            } else {
                $response = json_encode(array('response' => 'error', 'data' => $data));
                return $response;
            }


        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }


    public function makePrintedArray($record, $data)
    {
        //print_r($record);exit;
        $calculation = $this->myPriceModel->getPrice($data['serialNumber'], $data['orderNumber'], $data['manfactureId'], $data);
        //print_r($calculation); die();

        $to_pr = 0;
        if ($calculation['totalPrice'] == "") {
            $to_pr = '0.00';
        } else {
            $to_pr = $calculation['totalPrice'];
        }

        /*if($records->ProductBrand == 'Roll Labels'){
        $labelperroll = $data['statics']->totalLabels / $data['statics']->totalQuantity;
        $totallabels =  $records->$labelperroll* $data['qty'];
        }else{
        $totallabels =  $records->LabelsPerSheet* $data['qty'];
        }*/

        if ($record->ProductBrand == 'Roll Labels') {
            $labelperroll = $data['statics']->totalLabels / $data['statics']->totalQuantity;
            $totallabels = $data['statics']->totalLabels;

            if ($totallabels == "") {
                $totallabels = $data['statics']->totalLabels;
            }
        } else {
            $totallabels = $record->LabelsPerSheet * $data['qty'];

            if ($data['statics']->totalQuantity == "") {
                $data['statics']->totalQuantity = $data['qty'];
            }
        }
        //echo $totallabels; exit;

        if ($record->ProductBrand == 'Integrated Labels') {
            $totallabels = (preg_match('/250 Sheet Dispenser Packs/is', $record->ProductName)) ? 250 : 1000;
        }

        /*else{
        $totallabels = $data['statics']->totalLabels;
        }*/

        $mattpe = ($record->ProductBrand == 'Roll Labels') ? 'Roll' : 'A4';

        if( ($mattpe =='A4') ) {

            $m_codes = ($mattpe == Roll) ? substr($record->ManufactureID, 0, -1) : $record->ManufactureID;
            $material_code = $this->home_model->getmaterialcode($m_codes);
            $material_discount = $this->home_model->check_material_discount($material_code, $mattpe);

            if ($material_discount != null) {
                $disRate = ($to_pr * $material_discount) / 100;
                $to_pr = number_format($to_pr - $disRate, 2);
            }
        }
           
           
           
        $perlabelprice = round(($to_pr / $totallabels), 3);

        $des = '';
        if ($data['statics']->count > 1) {
            $des = 'Multiple Designs';
        } else {
            $des = '1 Designs';
        }


        $printedArray = array(
            'SessionID' => $this->session->userdata('session_id'),
            'ProductID' => $data['productId'],
            'UserID' => $this->session->userdata('customer_id'),
            'OrderTime' => date('Y-m-d h:m:i'),
            'Quantity' => $data['statics']->totalQuantity,
            'orignalQty' => $totallabels,
            'UnitPrice' => $perlabelprice,
            'TotalPrice' => @($to_pr),
            'OrderData' => date('Y-m-d'),
            'LabelsPerRoll' => @($data['statics']->totalLabels / $data['statics']->totalQuantity),
            'colorcode' => $record->colorcode,
            'is_custom' => $record->is_custom,
            'wound' => $record->Wound,
            'Printing' => 'Y',
            'Print_Total' => ($calculation['printPrice'] <= 0) ? '0.00' : $calculation['printPrice'],
            'Print_Type' => $record->Print_Type,
            'FinishType' => $record->FinishType,
            'Print_Design' => $des,
            'Print_Qty' => $data['statics']->count,
            //'Free'=>(isset($calculation['record']['artworks']))?$calculation['record']['artworks']:0,
            'Free' => $record->Free,

            'source' => $record->source,
            'orientation' => $record->Orientation,
            'page_location' => 'backoffice reorder'
        );
        //echo '<pre>';
        //print_r($printedArray);exit;
        return $printedArray;
    }

    public function makePlainArray($records, $data)
    {
        //print_r($data);exit;

        if ($records->Print_Type == "") {
            $records->Print_Type = date('Y-m-d');
        }

        if ($records->Print_Type == 'Sample' || $records->sample == 'Sample') {

            $data['labelperroll'] = '1';
            $data['qty'] = '1';
            $data['price'] = '0.00';
        }

        $pr_p = $data['price'];
        if ($data['price'] == "") {
            $pr_p = '0.00';
        }

        if ($records->ProductBrand == 'Roll Labels') {
            $totallabels = $records->LabelsPerRoll * $data['qty'];
        } else {
            $totallabels = $records->LabelsPerSheet * $data['qty'];
        }

         $mattpe = ($records->ProductBrand == 'Roll Labels') ? 'Roll' : 'A4';
         if( ($mattpe =='Roll' && $records->Printing != 'Y') || ($mattpe =='A4') ) {

            $m_codes = ($mattpe == Roll) ? substr($records->ManufactureID, 0, -1) : $records->ManufactureID;
            $material_code = $this->home_model->getmaterialcode($m_codes);
            $material_discount = $this->home_model->check_material_discount($material_code, $mattpe);

            if ($material_discount != null) {
                $disRate = ($pr_p * $material_discount) / 100;
                $pr_p = number_format($pr_p - $disRate, 2);
            }
        }
        
        $perlabelprice = round(($pr_p / $totallabels), 3);

        $data = array(
            'SessionID' => $this->session->userdata('session_id'),
            'ProductID' => $data['productId'],
            'UserID' => $this->session->userdata('customer_id'),
            'OrderTime' => date('Y-m-d h:m:i'),
            'Quantity' => $data['qty'],
            'orignalQty' => $totallabels,
            'UnitPrice' => $perlabelprice,
            'TotalPrice' => $pr_p,
            'OrderData' => $records->Print_Type,
            'LabelsPerRoll' => $records->LabelsPerRoll,
            'colorcode' => $records->colorcode,
            'page_location' => 'backoffice reorder',
            'Printing' => ($this->input->post('regmark') != null && $this->input->post('regmark') == 'Y') ? 'Y' : 'N',
            'regmark' => ($this->input->post('regmark') != null && $this->input->post('regmark') == 'Y') ? 'Y' : 'N',
            'reorder_price' => $pr_p
        );
        //print_r($data);
        return $data;
    }


    public function assignCartIdIntegratedAttachment($data)
    {

        $Custom_design = $this->input->post('cus_design');

        if ($Custom_design != "" && $Custom_design != 0) {

            return true;

        } else {
            $colums = array('SessionID' => $this->session->userdata('session_id'), 'CartID' => @$data['originalCartId']);
            $record = $this->orderModal->updateColoum($colums, $data['cartId']);
            if ($record) {
                return $record;
            }
        }
    }


    public function insertRecord($data)
    {
        $data['added_from'] = 'backoffice'; 
        $this->db->insert('temporaryshoppingbasket', $data);
        return $this->db->insert_id();
    }

    public function sendResponse($data)
    {
        $data->ProductName = explode('<sp', $data->ProductName)[0];
        $response = json_encode(array('response' => 'true', 'data' => $data, 'price' => $this->cartModal->getCarTotalPrice()));
        echo $response;
    }


    public function getParams($data)
    {
        $results = $this->db->select("o.*,od.*,cat.*,p.ProductBrand,p.LabelsPerSheet")
            ->from('orders as o')
            ->join('orderdetails as od', 'o.OrderNumber = od.OrderNumber', 'left')
            ->join('products as p', 'od.ProductID = p.ProductID', 'left')
            ->join('category as cat', 'p.CategoryID = cat.CategoryID', 'left')
            ->where('o.OrderNumber', $data['orderNumber'])
            ->where('od.SerialNumber', $data['serialNumber'])
            ->like('od.ManufactureID', $data['manfactureId'])
            ->get()->row();


        return $results;
    }


    public function update_topbasket()
    {
        $symb = '';
        $currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

        $symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
        $exchange_rate = $this->cartModal->get_exchange_rate($currency);

        if ($currency == 'GBP') {
            $symb = '£';
        } elseif ($currency == 'EUR') {
            $symb = '€';
        } elseif ($currency == 'USD') {
            $symb = '$';
        }

        $records = $this->cartModal->getAllProducts();


        $cal = $this->productCalculation($records);
        //$ii = count($cal)-1;

        if (count($cal) > 0) {

            $ii = count($cal) - 1;
            $total_final = $cal[$ii]->total;

            $disuntoffer = $this->cartModal->checkwtpDiscount($total_final);
            $total_final = round($total_final - $disuntoffer, 2);

            $record['price'] = (isset($cal[0])) ? round($total_final * $exchange_rate, 2) : 0.00;
            $record['symb'] = $symb;
        } else {
            $record['price'] = '0.00';
            $record['symb'] = $symb;
        }

        //$record['price'] = (isset($cal[0]))?number_format($cal[$ii]->total*$exchange_rate,2):0.00;
        ///$record['symb'] = $symb;
        echo json_encode($record);
    }

    public function checkout()
    {

        $symb = '';
        $currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

        $symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
        $exchange_rate = $this->cartModal->get_exchange_rate($currency);

        if ($currency == 'GBP') {
            $symb = '£';
        } elseif ($currency == 'EUR') {
            $symb = '€';
        } elseif ($currency == 'USD') {
            $symb = '$';
        }


        /*************** Roll Labels Wholesale Price *************/
        $userID = $this->session->userdata('Order_person');
        if ((isset($userID) and !empty($userID))) {
            $this->load->model('order_quotation/quotationModal');
        }
        /*************** Roll Labels Wholesale Price *************/


        $records = $this->cartModal->getAllProducts();
        $cal = $this->productCalculation($records);

        if (count($cal) > 0) {
            $ii = count($cal) - 1;
            $total_final = $cal[$ii]->total;

            $disuntoffer = $this->cartModal->checkwtpDiscount($total_final);
            $total_final = round($total_final - $disuntoffer, 2);

            $data['records'] = $cal;
            $data['digitalis'] = $this->cartModal->digitalPrintingProcess($records);
            $record['html'] = $this->takeHtmlAndPrintData('order_quotation/checkout/temp_products_lists', $data);

            $record['price'] = (isset($cal[0])) ? round($total_final * $exchange_rate, 2) : 0.00;
            $record['symb'] = $symb;

        } else {
            $data['records'] = $cal;
            $record['html'] = $this->takeHtmlAndPrintData('order_quotation/checkout/temp_products_lists', $data);
            $record['price'] = '0.00';
            $record['symb'] = $symb;
        }

        //$ii = count($cal)-1;
//        $data['records'] = $cal;
//        $data['digitalis'] = $this->cartModal->digitalPrintingProcess($records);
//        $record['html'] = $this->takeHtmlAndPrintData('order_quotation/checkout/temp_products_lists',$data);
//
//        $record['price'] = (isset($cal[0]))?number_format($cal[$ii]->total*$exchange_rate,2):0.00;
        $record['symb'] = $symb;
        echo json_encode($record);
    }

    function merge_plo_cart()
    {
        $plo_sessionID = (isset($_COOKIE['ci_session_plo'])) ? $_COOKIE['ci_session_plo'] : '';
        $redirect_from = (isset($_GET['redirectfrom'])) ? $_GET['redirectfrom'] : '';

        if (isset($plo_sessionID) and $plo_sessionID != '') {
            $this->db->where('id', $plo_sessionID);
            $sess_data = $this->db->get('ci_session_plo')->row()->data;
            $sess_data = unserialize(serialize($sess_data));

            $aa_sessionID = $this->shopping_model->sessionid();

            $update_data = array();
            $update_data['SessionID'] = $aa_sessionID;

            $where = "SessionID = '$plo_sessionID'";
            $this->db->where($where);
            $this->db->update('temporaryshoppingbasket', $update_data);
            $this->db->update('integrated_attachments', $update_data);

            $plo_loggedin_user = $_COOKIE['plo_loggedin_user'];
            if (isset($plo_loggedin_user) and $plo_loggedin_user != '') {
                $username = $this->get_db_column('customers', 'BillingFirstName', 'UserID', $plo_loggedin_user);
                $newdata = array(
                    'userid' => $plo_loggedin_user,
                    'UserName' => $username,
                    'logged_in' => true,
                    'user_type' => 'trade',
                );
                $this->session->set_userdata($newdata);
            }
        }
        $redirect_from = $redirect_from;
        if (isset($redirect_from) and $redirect_from == "plo") {
            $this->session->set_userdata("redirect_from", "plo");
        }
    }

    function get_db_column($table, $column, $key, $value)
    {


        $row = $this->db->query(" Select $column FROM $table WHERE $key LIKE '" . $value . "' LIMIT 1 ")->row_array();


        return (isset($row[$column]) and $row[$column] != '') ? $row[$column] : '';


    }


    public function paymentPage()
    {

        $worldpayerror = $this->session->userdata('worldpayerror');
        if (isset($worldpayerror) and $worldpayerror != '') {
            $worldpayerror = $worldpayerror . ' <br />Unfortunately there was a problem with the 3DS authorising process and payment for your order has not been received. We apologise that this has occurred but if you contact our customer care team via the online chat facility, Tel. +44 (0)1733 588 390 during office hours (08:30 – 17:30GMT Monday – Friday), or email: customercare@aalabels.com They should be able to take payment and process your order for despatch, or alternatively provide details of other payment methods accepted.';
            $this->session->unset_userdata('worldpayerror', '');
            $data['errortype'] = 'payment';
            $data['error'] = $worldpayerror;
        }

        $payment_redirection = $this->session->userdata('payment_redirection');

        if (isset($payment_redirection) and $payment_redirection != '') {
            $this->session->set_userdata('payment_redirection', '');
            $data['errortype'] = 'payment';
        }

        if ($_POST) {
            $usrid = $this->session->userdata('userid');
            if (empty($usrid)) {
                $this->form_validation->set_rules('email', 'Billing Email', 'trim|required|xss_clean|valid_email|is_unique[customers.UserEmail]');
            }

            $this->form_validation->set_rules('b_first_name', 'Billing First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('b_last_name', 'Billing Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('b_phone_no', 'Billing Phone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('b_fax', 'Billing Fax', 'trim|xss_clean');
            $this->form_validation->set_rules('b_pcode', 'Billing Postcode', 'trim|xss_clean');
            $this->form_validation->set_rules('b_add1', 'Billing Address1', 'trim|required|xss_clean');
            $this->form_validation->set_rules('b_city', 'Billing City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('b_organization', 'Billing Company', 'trim|xss_clean');
            $this->form_validation->set_rules('b_county', 'Billing County', 'trim|required|xss_clean');

            $this->form_validation->set_rules('d_email', 'Delivery Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('d_first_name', 'Delivery First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('d_last_name', 'Delivery Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('d_phone_no', 'Delivery Phone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('d_fax', 'Delivery Fax', 'trim|xss_clean');
            $this->form_validation->set_rules('d_pcode', 'Delivery postcode', 'trim|xss_clean');

            $this->form_validation->set_rules('d_add1', 'Delivery Address1', 'trim|required|xss_clean');
            $this->form_validation->set_rules('d_city', 'Delivery City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('d_organization', 'Delivery Company', 'trim|xss_clean');
            $this->form_validation->set_rules('d_county', 'Delivery County', 'trim|required|xss_clean');

            if ($this->form_validation->run() != false) {
                $data['error'] = validation_errors();
            } else {
                $orderNum = "";
                $orderNum = $this->session->userdata('OrderNumber');
                if (isset($orderNum) and $orderNum != '') {
                    $orderNum = array('OrderNumber' => '');
                    $this->session->set_userdata($orderNum);
                    unset($orderNum);
                }

                $paymentway = $this->input->get_post('paymentway');
                $sample = $this->shopping_model->is_order_sample();
                $this->shopping_model->add_order();
                if (isset($paymentway) && $paymentway == "creditCard" and $sample != 'sample') {
                    $data['errortype'] = 'payment';
                    $this->worldPayForCart();
                } else {
                    redirect(main_url . 'cart/Cart/orderconfirmation/' . $this->session->userdata('OrderNumber'));
                }
            }
        }

        $records = $this->cartModal->getAllProducts();
        $cal = $this->productCalculation($records);

        if (count($cal) > 0) {
            $data['records'] = $cal;
            $ii = count($cal) - 1;
            $data['digitalis'] = $this->cartModal->digitalPrintingProcess($records);
            $record['html'] = $this->takeHtmlAndPrintData('order_quotation/checkout/payment_section', $data);

            $total_final = $cal[$ii]->total;
            $disuntoffer = $this->cartModal->checkwtpDiscount($total_final);
            $record['price'] = round($total_final - $disuntoffer, 2);
        } else {
            $record['price'] = '0.00';
        }

        $data['main_content'] = 'order_quotation/checkout/payment_section';
        $this->load->view('page', $data);
    }


    public function orderconfirmation($ordernumber)
    {
        $this->session->set_userdata("changeDrop", "0");
        $this->session->unset_userdata("userid");
        $this->session->unset_userdata('payment_redirection');
        $this->shopping_model->emptcart();


        $d = $data['order'] = $this->orderModal->getOrder($ordernumber);
        $data['orderDetails'] = $this->orderModal->getOrderDetail($ordernumber);
        $data['status'] = $this->orderModal->statusDropDown($d[0]->OrderStatus, $d[0]->PaymentMethods);

        if ($d[0]->PaymentMethods != "paypal") {
            $this->orderModal->order_confirmation_new($ordernumber);
        }
        $data['main_content'] = 'order_quotation/checkout/confirm_my_order';
        $this->load->view('page', $data);
    }


    public function review_cart_div()
    {
        $records = $this->cartModal->getAllProducts();
        $data['records'] = $this->productCalculation($records);
        $data['digitalis'] = $this->cartModal->digitalPrintingProcess($records);

        $html = $this->takeHtmlAndPrintData('order_quotation/checkout/review_cart', $data);
        $response = json_encode(array('response' => 'yes', 'data' => $html));
        echo $response;
    }


    public function sendEmailForPayPol($orderNumber)
    {
        $data['order'] = $this->orderModal->getOrder($orderNumber);
        $data['orderDetails'] = $this->orderModal->getOrderDetail($orderNumber);


        //$mailfrom  ='helpdesk@123-labels.co.uk'; $mailname="123-labels";
        $mailfrom = 'customercare@aalabels.com';
        $mailname = "AAlabels";
        $body = $this->load->view('order_quotation/checkout/send_paypol_email', $data, TRUE);

        $this->load->library('email');
        $this->email->initialize(array('mailtype' => 'html',));
        $this->email->subject('pay Now');
        $this->email->from($mailfrom, $mailname);
        $this->email->to($data['order'][0]->Billingemail);
        $this->email->message($body);
        $this->email->send();
    }

    public function productCalculation($records)
    {
        $final = array();

        //echo '<pre>'; print_r($records); echo '</pre>';
        $price = 0;

        foreach ($records as $record) {

            $materialprice = 0;
            $carRes = $this->user_model->getCartData($record->ID);
            if (isset($carRes[0]) && $carRes[0]->ID != "" && $record->p_code == 'SCO1') {


                $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);

                $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);

                $materialprice = 0;
                foreach ($assoc as $rowp) {
                    $materialprice += ((int)$rowp->plainprice + (int)$rowp->printprice);
                    //$materialpriceinc = $materialprice * 1.2;
                }
            }

            $price += $record->TotalPrice + $record->Print_Total + $materialprice;

            $record->total = +$price;
            $manufactureId = $this->cartModal->getProductManufactureId($record->ProductID);
            $calculations = $this->cartModal->getProductCalculation($record->ProductID, $manufactureId['ManufactureID']);
            $record->calculations = $calculations;
            $final[] = $record;
        }


        //$myArray=array_merge($myArray,$myAddArray);
        // $final['price'] = $price;exit;
        //echo '<pre>';
//     	/print_r($final);
        return $final;
    }

    public function deleteLineFromCart()
    {
        $this->cartModal->deleteLineFromCart($this->input->post('cartId'));
        echo $this->getCartPrice();
    }

    public function deleteLineFromMaterial()
    {
        $this->cartModal->deleteLineFromMaterial($this->input->post('cartId'));
        echo $this->getCartPrice();
    }


    public function changelabeltype()
    {
        $tempid = $this->input->post('id');
        $type = $this->input->post('type');
        $this->db->where('ID', $tempid);
        $this->db->update('flexible_dies_mat', array('labeltype' => $type, 'plainprice' => 0, 'printprice' => 0, 'check' => 0));
        echo $this->checkout();
    }


    public function getMaterialPrice()
    {

        $matid = $this->input->post('matId');
        $qty = $this->input->post('quantity');
        $print = $this->input->post('type');
        $finish = $this->input->post('finish');
        $design = $this->input->post('design');
        $labels = $this->input->post('lables');
        $core = $this->input->post('core');
        $wound = $this->input->post('wound');
        $type = $this->input->post('plain_print');
        $format = $this->input->post('format');

        $array = array(
            'qty' => $qty,
            'designs' => $design,
            'rolllabels' => $labels,
            'printing' => $print,
            'finish' => $finish,
            'core' => $core,
            'wound' => $wound
        );

        $this->db->where('ID', $matid);
        $this->db->update('flexible_dies_mat', $array);

        // $labels = '1800';
        if ($format != "Roll") {


            $mat = $this->cartModal->fetchmaterinfo($matid);
            $die = $this->cartModal->fetchdierecordinfo($mat['OID']);

            $this->cartModal->updatecustomsheetprice($die, $mat);


            $qry = $this->db->query("select * from flexible_dies_mat where ID = $matid")->row_array();
            //print_r($qry);exit;
            $qry['tempprice'] = ((($qry['plainprice'] > 0) || ($qry['printprice'] > 0))) ? '1' : '0';
            //print_r($qry);exit;
            $this->db->where('ID', $matid);
            $this->db->update('flexible_dies_mat', $qry);
            $this->updateQuotationDetailRecord($matid, $qry['tempprice']);
            echo json_encode(array('html' => $this->LoadCheckout(), 'response' => 'yes'));
        } else {


            $matInfo = $this->cartModal->fetchmaterinfo($matid);
            $record = $this->cartModal->fetchdierecordinfo($matInfo['OID']);
            if ($record['die_code'] == null || $record['die_code'] == "") {
                echo json_encode(array('res' => 'false', 'type' => "dienotfound", 'limit' => $labels, 'quantity' => $qty));
            } else {

                $productCode = $record['die_code'] . $matInfo['material'] . $this->getLastCode($core);

                //echo $productCode;exit;
                //$productCode = 'RR152221MWP4';
                $minqty = $this->cartModal->calulate_min_rolls($productCode);

                $minLabels = $this->cartModal->calulate_min_labels($productCode);

                //echo $labels.' '.$qty.' '.$minLabels;exit;
                $product = $this->cartModal->getProductId($productCode);

                //print_r($product);exit;
                // echo $product['LabelsPerSheet'].'=persheet';

                $min_qty_roll = $this->cartModal->get_roll_qty($productCode);
                $min_allow_labels = ($min_qty_roll == 1) ? 100 * $min_qty_roll : 50 * $min_qty_roll;
                //echo $min_qty_roll.'=min_qty';
                //$max = $this->cartModal->max_total_labels_on_rolls($product['LabelsPerSheet']);
                //echo $max;exit;
                //echo $product['LabelsPerSheet'];exit;
                //print_r(parse_ini_file());
                //exit;

//              if($qty > $max){
//                  echo json_encode(array('res' => 'true', 'type' => "over",'limit' => $labels, 'quantity' => $max));
//              }

                if (!empty($product)) {

                    if (($labels / $qty) >= $minLabels) {

//                  if(($labels / $qty) < $product['LabelsPerSheet']){
//
//                      $first = $labels / $product['LabelsPerSheet'];
//                      $val = $first /$minqty;
//                      $val2 = (fmod($val ,$minqty)!= 0)?ceil($val):$val;
//                      echo json_encode(array('limit' => $product['LabelsPerSheet'] *$qty, 'quantity' => $val2 * $minqty, 'res' => 'true', 'type' => 'qty'));
//                  }

                        //else{
                        if (($labels / $qty) > $product['LabelsPerSheet']) {

                            $first = $labels / $product['LabelsPerSheet'];
                            $val = $first / $minqty;
                            $val2 = (fmod($val, $minqty) != 0) ? ceil($val) : $val;
                            echo json_encode(array('limit' => $labels, 'quantity' => $val2 * $minqty, 'res' => 'true', 'type' => 'quantityishigh'));
                        } else {
                            //echo $qty.' '.$minqty;exit;
                            if (fmod($qty, $minqty) != 0 && $type != 'printed' && $qty > $minqty) {

                                $val = $qty / $minqty;
                                $val2 = (fmod($val, $minqty) != 0) ? ceil($val) : $val;

                                echo json_encode(array('limit' => $labels, 'quantity' => $val2 * $minqty, 'res' => 'true', 'type' => "qtylimit"));
                            } else {
                                if ($type == 'printed') {

                                    $price = $this->cartModal->UpdateItem(0, 0, $productCode, $qty, array('condition' => 'true', 'type' => 'Y', 'customDie' => 'Y'));
                                    // print_r($price);exit;
                                    $qry = $this->db->query("select * from flexible_dies_mat where ID = $matid")->row_array();
                                    $this->updateQuotationDetailRecord($matid, $price);
                                    $qry['printprice'] = $price * $qty;
                                    $qry['tempprice'] = (($price * $qty) <= 0) ? '0' : '1';
                                    $this->db->where('ID', $matid);
                                    $this->db->update('flexible_dies_mat', $qry);
                                    echo json_encode(array('html' => $this->LoadCheckout(), 'response' => 'yes'));
                                } else {

                                    $price = $this->cartModal->addToCart($product['ProductID'], $productCode, $qty, $labels, 'true');
                                    $qry = $this->db->query("select * from flexible_dies_mat where ID = $matid")->row_array();
                                    $this->updateQuotationDetailRecord($matid, $price);
                                    $qry['plainprice'] = $price * $qty;
                                    $qry['tempprice'] = (($price * $qty) <= 0) ? '0' : '1';
                                    $this->db->where('ID', $matid);
                                    $this->db->update('flexible_dies_mat', $qry);
                                    echo json_encode(array('html' => $this->LoadCheckout(), 'response' => 'yes'));
                                }
                            }
                        }

                        //}
                    } else {

                        // echo json_encode(array('limit' => ceil($labels + ($max_allow_labels +(($labels) * $qty))), 'quantity' => $qty, 'res' => 'true', 'type' => "max"));
                        $first = ($min_allow_labels * $qty) / $product['LabelsPerSheet'];
                        $val = $first / $minqty;
                        $val2 = (fmod($val, $minqty) != 0) ? ceil($val) : $val;
                        echo json_encode(array('limit' => $min_allow_labels * $qty, 'quantity' => $qty, 'response' => 'no', 'type' => "quantityisless"));
                    }
                } else {
                    echo json_encode(array('limit' => $labels, 'quantity' => $qty, 'response' => 'no', 'type' => "productnotfound"));
                }
                //print_r($this->quoteModel->addToCart($product['ProductID'],$productCode,$qty,'true'));exit;
            }
        }

        if ($labels < 0) {
            $labels = $min_allow_labels * $qty;
        }


    }

    public function getLastCode($val)
    {
        if ($val == 25) {
            return 1;
        } else if ($val == 38) {
            return 2;
        } else if ($val == 44.5) {
            return 3;
        } else if ($val == 76) {
            return 4;
        }
    }

    public function updateQuotationDetailRecord($id, $price = null)
    {

        $qry = $this->db->query("select * from flexible_dies_mat where ID = $id")->row_array();
        $flxinfo = $this->db->query("select * from flexible_dies_info where ID = '" . $qry['OID'] . "'")->row_array();
        $cart = $this->db->query("select * from temporaryshoppingbasket where ID = '" . $flxinfo['CartID'] . "'")->row_array();
        $quodetail = $this->db->query("select * from quotationdetails where SerialNumber = '" . $flxinfo['QID'] . "'")->row_array();
        $quodetail['die_approve'] = 'N';
        //print_r($quodetail);exit;
        $this->db->where('SerialNumber', $flxinfo['QID']);
        $this->db->update('quotationdetails', $quodetail);

//        $cart['click_count'] = '1';
//        $cart['TotalPrice'] = $price;
//        $this->db->where('ID', $flxinfo['CartID']);
//        $this->db->update('temporaryshoppingbasket', $cart);
        //return true;
    }


    public function LoadCheckout()
    {

        $records = $this->cartModal->getAllProducts();
        $data['records'] = $this->productCalculation($records);
        $data['digitalis'] = $this->cartModal->digitalPrintingProcess($records);
        $record = $this->takeHtmlAndPrintData('order_quotation/checkout/temp_products_lists', $data);
        return $record;
    }


    public function checkoutFullPage()
    {
        echo json_encode(array('html' => $this->LoadCheckout()));
    }

    function is_email_exist()
    {

        $msg = "false";
        if ($_GET) {
            $email = $this->input->get('email');
            if ($email == '') {
                $email = $this->input->get('email_reg');
            }

            $count = $this->user_model->email_validate($email);
            if ($count == 0) {
                $msg = "true";
            }
        }
        echo $msg;
    }

    function setpostcode()
    {

        $response = 'no';
        $array = array();

        $postcode = $this->input->post('postocde');
        $bpcode = $this->input->post('bpcode');
        $postcode = urldecode($postcode);
        $postcode = urldecode($postcode);
        $bpcode = urldecode($bpcode);
        $country = $this->input->post('country');
        $country = urldecode($country);

        $oldpostcode = '';
        $oldpostcode = $this->session->userdata('off_postcode');
        $oldcountry = $this->session->userdata('countryid');
        //country

        $bgroup = $this->input->post('bgroup');
        $dgroup = $this->input->post('dgroup');

        if (isset($postcode) and $oldpostcode != $postcode) {
            // AA21 STARTS
            $this->session->set_userdata('off_postcode', $postcode);
            $response = 'yes';
            // AA21 ENDS
        }
        if (isset($country) and $country != '' and $oldcountry != $country) {
            $this->session->set_userdata('countryid', $country);
            $this->session->set_userdata("BasicCharges", "");
            $this->session->set_userdata("ServiceID", "");
            $response = 'yes';
            $this->session->set_userdata('vat_exemption', '');
            $this->update_integrated_delivery_charges();
        }
        $bpcode = strtoupper(substr($bpcode, 0, 2));
        $postcode = strtoupper(substr($postcode, 0, 2));

        if ($country == 'United Kingdom' and $bpcode == $postcode and (strtoupper($postcode) == 'JE' || strtoupper($postcode) == 'GY')) {
            $this->session->set_userdata('vat_exemption', 'yes');
            $response = 'yes';
        } else if ($bgroup == 'ROW' and $dgroup == 'ROW') {
            $this->session->set_userdata('vat_exemption', 'yes');
            $response = 'yes';
        } else if (($oldcountry == $country) and $country == 'United Kingdom') {
            $this->session->set_userdata('vat_exemption', '');
            $response = 'yes';
        }

        if ($response == 'yes') {
            $delivery_html = $this->ajax_delivery_content();
            $order_review_summary = $this->ajax_review_summary();
            $array = array('delivey' => $delivery_html, 'orderSummary' => $order_review_summary);
        }


        //$oldpostcode = $this->session->userdata('off_postcode');
        //$oldcountry = $this->session->userdata('countryid');


        $json_data = array('response' => $response);
        $json_data = array_merge($json_data, $array);
        $this->output->set_output(json_encode($json_data));

    }

    function ajax_delivery_content()
    {
        $theHTMLResponse = $this->load->view('order_quotation/checkout/delivery_charges', '', true);
        $this->output->set_content_type('application/json');
        return $theHTMLResponse;

    }

    function update_integrated_delivery_charges()
    {
        $intdata = array();
        $intdata['BasicCharges'] = 0;
        $integrated = $this->shopping_model->is_order_integrated();
        $dl_id = $this->session->userdata('ServiceID');
        if ($dl_id != '') {
            $qry = $this->db->query("SELECT * FROM shippingservices WHERE ServiceID  = " . $dl_id . " order by ServiceID asc");
            $res = $qry->result_array();

            $intdata['ServiceID'] = $res[0]['ServiceID'];
            $intdata['ServiceName'] = $res[0]['ServiceName'];
            $intdata['BasicCharges'] = $res[0]['BasicCharges'];
            $intdata['changeDrop'] = 1;
        }
        if ($integrated > 0) {
            $SID = $this->shopping_model->sessionid();
            $int_sheets = $this->db->query("SELECT SUM(Quantity) as qty, t.ProductID FROM `temporaryshoppingbasket` t, products p where p.ProductID = t.ProductID and p.ProductBrand = 'Integrated Labels' and SessionID = '$SID' and t.p_name != 'Delivery Charges'")->row_array();

            $dpd = $this->home_model->get_integrated_delivery($int_sheets['qty']);
            $dpd = $dpd['dpd'];

            $productid = $int_sheets['ProductID'];

            $intdata['BasicCharges'] += $dpd * 1.2;

            if ($int_sheets['qty'] == '' || $int_sheets['ProductID'] == '') {
                $intdata['BasicCharges'] -= $dpd * 1.2;
            }
            $this->session->set_userdata($intdata);
        }
    }

    function ajax_review_summary()
    {
        $theHTMLResponse = $this->load->view('order_quotation/checkout/order_summary', '', true);
        $this->output->set_content_type('application/json');
        return $theHTMLResponse;

    }

    function update_delevery()
    {
        if ($_POST) {
            $dl_id = $this->input->post('deliveryid');
            $integrated = $this->shopping_model->is_order_integrated();
            $qry = $this->db->query("SELECT * FROM shippingservices WHERE ServiceID  = " . $dl_id . " order by ServiceID asc");

            $res = $qry->result_array();
//            /echo print_r($res);

            $courier = $this->input->post('courier');

            $data['ServiceID'] = $res[0]['ServiceID'];
            $data['ServiceName'] = $res[0]['ServiceName'];
            $data['BasicCharges'] = $res[0]['BasicCharges'];
            $data['changeDrop'] = 1;

            if (isset($courier) && $courier == 'DPD') {

                if ($res[0]['BasicCharges'] > 0) {
                    $data['BasicCharges'] = $res[0]['BasicCharges'] + 1;
                } else {
                    $data['BasicCharges'] = $res[0]['BasicCharges'];
                }
            }


            if ($integrated > 0) {
                $delivery_charges = $this->shopping_model->get_integrated_delivery_charges();
                if (isset($delivery_charges) and !empty($delivery_charges)) {
                    $integrated_charges = $delivery_charges * 1.2;
                }

                $data['BasicCharges'] += $integrated_charges;
               //echo $data['BasicCharges'] =2;
            }

            $this->session->set_userdata($data);
            $delivery_html = $this->ajax_delivery_content();
            $order_review_summary = $this->ajax_review_summary();

            $json_data = array('response' => 'yes', 'delivey' => $delivery_html, 'orderSummary' => $order_review_summary);
            $this->output->set_output(json_encode($json_data));
        }
    }


    // AA21 STARTS
    function update_courier()
    {
        $courier = $this->input->post('courier');
        $data['courier'] = $courier;
        $this->session->set_userdata($data);

        $delivery_html = $this->ajax_delivery_content();
        $order_review_summary = $this->ajax_review_summary();

        $json_data = array('response' => 'yes', 'delivey' => $delivery_html, 'orderSummary' => $order_review_summary);
        $this->output->set_output(json_encode($json_data));

    }

    // AA21 ENDS


    function validate_vat()
    {


        $country = $this->input->post('country');
        $vatNumber = $this->input->post('vatNumber');

        //$vatNumber="822041575";
        //$countryCode="GB";

        $vatNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatNumber));
        $data = array('status' => 'Invalid', 'message' => 'Invalid VAT Number');
        if (isset($vatNumber) and $vatNumber != '') {
            $countryCode = $this->country_code($country);
            $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");


            try {
                $response = $client->checkVat(array('countryCode' => $countryCode, 'vatNumber' => trim($vatNumber)));

                if (isset($response->valid) and $response->valid == 1) {

                    /*******************Vat Check Logger ************************/
                    $userid = $this->session->userdata('userid');
                    $email = $this->input->post('email');
                    $this->db->insert('vat_checker_log', array('vat_number' => $vatNumber, 'userid' => $userid, 'email' => $email));
                    /**************************************************************/

                    $this->session->set_userdata('vat_exemption', 'yes');
                    $order_review_summary = $this->ajax_review_summary();

                    $order_total = $this->shopping_model->total_order();
                    $vat = number_format(($order_total * 1.2) - $order_total, 2, '.', '');

                    //$message = "VAT Exemption of ".symbol."$vat has been deducted from your order total and this will be confirmed on the next page.";
                    $message = "VAT Exemption has been deducted from your order total and will be confirmed on the next page.";
                    $data = array('status' => 'valid',
                        'countryCode' => $response->countryCode,
                        'requestDate' => $response->requestDate,
                        'vatmessage' => $message,
                        'orderSummary' => $order_review_summary);
                }
            } catch (SoapFault $e) {
                $this->session->set_userdata('vat_exemption', '');
                $data = array('status' => 'Invalid', 'message' => 'Invalid VAT Number');
            }
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


    function clean($string)
    {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    }

    function worldPayForCart()
    {

        require_once(APPPATH . 'libraries/worldpay.php');
        $usrid = $this->session->userdata('userid');
        $token = $this->input->post('token');

        if (isset($token) and $token != '') {
            $invoice_no = $this->session->userdata('OrderNumber');
            $orderInfo = $this->shopping_model->order($invoice_no);

            $amount = $orderInfo['OrderTotal'] + $orderInfo['OrderShippingAmount'];
            if (isset($orderInfo['vat_exempt']) and $orderInfo['vat_exempt'] == 'yes') {
                $amount = $amount / 1.2;
            }

            $amount = $this->home_model->currecy_converter($amount, 'no');
            $amount = round($amount * 100);

            try {
                $bcountryCode = $this->country_code($orderInfo['BillingCountry']);
                $dcountryCode = $this->country_code($orderInfo['DeliveryCountry']);

                $worldpay = new Worldpay(WP_SERVICE_KEY);
                if (SITE_MODE != 'live') {
                    $worldpay->disableSSLCheck(true); //remove this line after live
                }
                
                 $billing_name = $orderInfo['BillingFirstName'].' '.$orderInfo['BillingLastName'];
                 $billing_name = $this->clean($billing_name);


                $response = $worldpay->createOrder(array(
                    'token' => $token,
                    'amount' => $amount,
                    'currencyCode' => currency,
                    'name' => $billing_name,
                    'is3DSOrder' => false,
                    'orderDescription' => 'AAlabels Products',
                    'customerOrderCode' => $invoice_no,
                    'shopperEmailAddress' => $orderInfo['Billingemail'],
                    'billingAddress' => array(
                        'address1' => $orderInfo['BillingAddress1'],
                        'address2' => $orderInfo['BillingAddress2'],
                        'postalCode' => $orderInfo['BillingPostcode'],
                        'city' => $orderInfo['BillingTownCity'],
                        'state' => $orderInfo['BillingCountyState'],
                        'countryCode' => $bcountryCode,

                    ),
                    'deliveryAddress' => array(
                        'address1' => $orderInfo['DeliveryAddress1'],
                        'address2' => $orderInfo['DeliveryAddress2'],
                        'postalCode' => $orderInfo['DeliveryPostcode'],
                        'city' => $orderInfo['DeliveryTownCity'],
                        'state' => $orderInfo['DeliveryCountyState'],
                        'countryCode' => $dcountryCode,

                    ),

                ));


                $this->save_log('worldpay', $response);
                if (isset($response['paymentStatus']) && $response['paymentStatus'] == 'SUCCESS') {

                    $orderInfo = $this->shopping_model->order($response['customerOrderCode']);
                    $amount = $orderInfo['OrderTotal'] + $orderInfo['OrderShippingAmount'];
                    if (isset($orderInfo['vat_exempt']) and $orderInfo['vat_exempt'] == 'yes') {
                        $amount = $amount / 1.2;
                    }

                    $array = array('type' => 'worldpay',
                        'OrderNumber' => $response['customerOrderCode'],
                        'payment' => $amount,
                        'operator' => $this->session->userdata('UserName'),
                        'time' => time());
                    $this->db->insert('order_payment_log', $array);

                    $ords = $response['customerOrderCode'];
                    $printing = $this->printing_lines_count($ords);
                    $OrderStatus = ($printing > 0) ? 55 : 32;


                    $this->db->where('OrderNumber', $response['customerOrderCode']);
                    $this->db->update("orders", array('OrderStatus' => $OrderStatus, 'YourRef' => $response['orderCode'], 'Payment' => 1, 'Old_OrderStatus' => 6));
                    $data['order_no'] = $response['customerOrderCode'];
                    redirect(main_url . 'cart/Cart/orderconfirmation/' . $response['customerOrderCode']);
                } else {
                    $this->save_log('worldpay_error', array('error' => $response['paymentStatusReason']));
                    $this->session->set_userdata('worldpayerror', $response['paymentStatusReason']);
                    //echo 'payment else'; exit;
                    redirect(main_url . 'cart/Cart/paymentpage/');
                }


            } catch (WorldpayException $e) {
    //echo $e->getMessage();

                $this->save_log('worldpay_error', array('error' => $e->getMessage()));
                 $this->session->set_userdata('worldpayerror', $e->getMessage());
                 //echo 'second last else'; exit;
                redirect(main_url . 'cart/Cart/paymentpage/');

            }

        } else {

            //echo 'last else'; exit;
            redirect(main_url . 'cart/Cart/paymentpage/');
        }
    }

    function save_log($type, $data)
    {
        $data['ip_address'] = $this->session->userdata('ip_address');
        $record = json_encode($data);

        $insert_data = array();
        $insert_data['SessionID'] = $this->shopping_model->sessionid();
        $insert_data['Activity'] = $type;
        $insert_data['Record'] = $record;
        $insert_data['Website'] = 'BK';
        //echo"<pre>";print_r($insert_data);echo"</pre>";exit;
        $this->db->insert('websitelog', $insert_data);
    }


    function printing_lines_count($OrderNumber)
    {
        $result = $this->db->query("select count(*) as total from orderdetails WHERE OrderNumber LIKE '" . $OrderNumber . "' AND  Printing LIKE 'Y' and regmark LIKE 'N'");
        $row = $result->row_array();
        return $row['total'];
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

    function worldpaycallback()
    {

        require_once(APPPATH . 'libraries/worldpay.php');

        if (isset($_POST['PaRes']) and $_POST['PaRes'] != '') {

            $orderCode = $this->session->userdata('orderCode');
            if (isset($orderCode) and $orderCode != '') {

                $dele['orderCode'] = "";
                $this->session->unset_userdata($dele);
                $worldpay = new Worldpay(WP_SERVICE_KEY);

                if (SITE_MODE != 'live') {
                    //$worldpay->disableSSLCheck(true); //remove this line after live
                }
                try {
                    $response = $worldpay->authorise3DSOrder($orderCode, $_POST['PaRes']);
                    if (isset($response['paymentStatus']) && $response['paymentStatus'] == 'SUCCESS') {


                        if (isset($response['customerOrderCode']) and $response['customerOrderCode'] != '') {
                            $orderInfo = $this->shopping_model->order($response['customerOrderCode']);
                            $amount = $orderInfo['OrderTotal'] + $orderInfo['OrderShippingAmount'];
                            if (isset($orderInfo['vat_exempt']) and $orderInfo['vat_exempt'] == 'yes') {
                                $amount = $amount / 1.2;
                            }

                            $array = array('type' => 'worldpay',
                                'OrderNumber' => $response['customerOrderCode'],
                                'payment' => $amount,
                                'operator' => $this->session->userdata('UserName'),
                                'time' => time());
                            $this->db->insert('order_payment_log', $array);


                            $ords = $response['customerOrderCode'];
                            $printing = $this->printing_order_count($ords);
                            $regmarkCount = $this->regmark_count($ords);

                            $OrderStatus = 32;
                            if ($regmarkCount > 0) {
                                if ($regmarkCount == 1) {
                                    $OrderStatus = 32;
                                    //$OrderStatus = ($printing > 0)?55:2;
                                } else {
                                    $OrderStatus = ($printing > 0) ? 55 : 32;
                                }
                            } else {
                                $OrderStatus = ($printing > 0) ? 55 : 32;
                            }

                            $this->db->where('OrderNumber', $response['customerOrderCode']);
                            $this->db->update("orders", array('OrderStatus' => $OrderStatus, 'YourRef' => $orderCode, 'Payment' => 1));
                        }


                        redirect(SAURL . 'shopping/orderconfirmation');

                    } else {
                        $this->session->set_userdata('worldpayerror', 'There was a problem authorising 3DS order ');
                    }
                } catch (WorldpayException $e) {
                    $this->session->set_userdata('worldpayerror', $e->getMessage());
                }
            }
        }
        echo 'ERROR';
        exit;
        redirect(SAURL . 'transactionregistration.php');

    }

    private function save_credit_card($token)
    {
        $retain_cards = $this->input->post('retain_cards');
        if (isset($retain_cards) and $retain_cards == 1) {
            return;
        }
        $count = $this->home_model->get_db_column('saved_wp_tokens', 'count(*)', 'token', $token);
        if ($count == 0) {
            $usrid = $this->session->userdata('userid');
            $count = $this->home_model->get_db_column('saved_wp_tokens', 'count(*)', 'userid', $usrid);
            $default = 1;
            if ($count > 0) {
                $default = 0;
            }
            require_once(APPPATH . 'libraries/worldpay.php');
            $worldpay = new Worldpay(WP_SERVICE_KEY);
            if (SITE_MODE != 'live') {
                $worldpay->disableSSLCheck(true);
            } //remove this line after live
            try {
                $cardDetails = $worldpay->getStoredCardDetails($token);
                $insert_array = array('userid' => $usrid,
                    'name' => $cardDetails['name'],
                    'expiryMonth' => $cardDetails['expiryMonth'],
                    'expiryYear' => $cardDetails['expiryYear'],
                    'cardIssuer' => $cardDetails['cardIssuer'],
                    'maskedCardNumber' => $cardDetails['maskedCardNumber'],
                    'cardType' => $cardDetails['cardType'],
                    'token' => $token,
                    'is_default' => $default);
                $this->db->insert('saved_wp_tokens', $insert_array);
            } catch (WorldpayException $e) {
            } catch (Exception $e) {
            }
        }
    }


    function intialize_paypal_payment()
    {

        $response = array('response' => 404);
        if ($_POST) {

            $sandbox_status = 'live'; //sandbox
            if (SITE_MODE == 'live') {
                $sandbox_status = 'live';
            }
            $credentials = array('sandbox_status' => $sandbox_status);
            $this->load->library('rest_paypal', $credentials);
            $data['clientid'] = $this->rest_paypal->getclientid();


            $userid = $this->session->userdata('userid');
            $sessionid = $this->session->userdata('session_id');
            $ServiceID = $this->session->userdata('ServiceID');

            if (isset($userid) && !empty($userid)) {
                $userid = $userid;
            } else {
                $userid = "";
            }
            if (isset($ServiceID) && !empty($ServiceID)) {
                $ServiceID = $ServiceID;
            } else {
                $ServiceID = "21";
            }
            if (isset($BasicCharges) && !empty($BasicCharges)) {
                $BasicCharges = $BasicCharges;
            } else {
                $BasicCharges = "6.00";
            }

            $amount = $this->shopping_model->total_order();
            $amount = $amount * 1.2;

            $BasicCharges = $this->session->userdata('BasicCharges');
            $voucher = '';


            $black_friday = $this->shopping_model->check_black_friday_offer($amount);
            if ($black_friday['status'] == false) {
                $wtp_discount = $this->shopping_model->wtp_discount_applied_on_order();
                if (isset($userid) and $userid != '') {
                    $voucher = $this->shopping_model->order_discount_applied();
                }
            }
            if ($black_friday['status'] == true) {
                $discount_offer = $black_friday['discount_offer'];
                $voucherOfferd = 'Yes';
            } else if ($voucher) {
                $discount_offer = $voucher['discount_offer'];
                $voucherOfferd = 'Yes';
            } else if ($wtp_discount) {
                $discount_offer = $wtp_discount['discount_offer'];
                $voucherOfferd = 'Yes';
            } else {
                $discount_offer = 0.00;
                $voucherOfferd = 'No';
            }

            $amount = $amount - $discount_offer + $BasicCharges;


            $b_pcode = strtoupper($this->input->post('b_pcode'));
            $d_pcode = strtoupper($this->input->post('d_pcode'));

            $billing_postcode = strtoupper(substr($b_pcode, 0, 2));
            $delivery_postcode = strtoupper(substr($d_pcode, 0, 2));
            $vat_exempt = '';

            $VALIDVAT = $this->session->userdata('vat_exemption');
            if (isset($VALIDVAT) and $VALIDVAT == 'yes' and $dcountry != 'United Kingdom') {
                $vat_exempt = 'yes';
            } else if ($billing_postcode == $delivery_postcode and (strtoupper($delivery_postcode) == 'JE' || strtoupper($delivery_postcode) == 'GY')) {
                $vat_exempt = 'yes';
            }

            if (isset($vat_exempt) and $vat_exempt == 'yes') {
                $amount = $amount / 1.2;
            }

            //$amount = number_format($amount,2,".","");

            $usrid = $this->session->userdata('userid');
            if (isset($usrid) && $usrid != '') {
                $b_email = $this->shopping_model->user_email();
            } else {
                $b_email = $this->input->post('email');
            }


            $amount = $this->home_model->currecy_converter($amount, 'no');
            $amount = number_format($amount, 2, ".", "");


            $data_array = array('description' => "Payment Against Customer:" . $b_email,
                'total' => $amount,
                'currency' => currency,
                'item_name' => "AA Labels Products",
                'cancel_url' => base_url(),
                'return_url' => base_url(),);
            $expressCheckoutdata = $this->rest_paypal->expressCheckoutdata($data_array);
            $access_token = $this->rest_paypal->getAccessToken();

            $this->session->set_userdata('access_token', $access_token);
            $paymentid = $this->rest_paypal->getPaymentID($access_token, $expressCheckoutdata);
            $response = array('response' => 200, 'paymentID' => $paymentid);
            //$approval_url = $this->rest_paypal->getApprovalURL($access_token , $expressCheckoutdata );
            //$response = array('response'=>200,'url'=>$approval_url);
        }
        echo json_encode($response);
    }

    function capture_paypal_payment()
    {


        if ($_POST) {
            $PayerID = $this->input->post('PayerID');
            $paymentID = $this->input->post('paymentID');
            if (isset($PayerID) and $PayerID != '' and isset($paymentID) and $paymentID != '') {
                $sandbox_status = 'live'; //sandbox
                if (SITE_MODE == 'live') {
                    $sandbox_status = 'live';
                }
                $credentials = array('sandbox_status' => $sandbox_status);
                $this->load->library('rest_paypal', $credentials);
                $result = $this->rest_paypal->doPayment($paymentID, $PayerID, NULL);

                $invoice_no = $this->session->userdata('OrderNumber');
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
                            $this->db->update('orders', array('OrderStatus' => '2',
                                'YourRef' => $txn_id,
                                'Payment' => 1));
                        } else if ($state == 'pending' and $reason_code == 'ECHECK') {

                            $this->db->where('OrderNumber', $invoice_no);
                            $this->db->update('orders', array('OrderStatus' => '6',
                                'PaymentMethods' => 'PayPal eCheque',
                                'YourRef' => $txn_id,
                                'Payment' => 1));
                        }

                        redirect(SAURL . 'shopping/orderconfirmation');

                    }
                } else {

                    $this->session->set_userdata('worldpayerror', 'There is a problem to authorising the payment ');
                }
            } else {

                $this->session->set_userdata('worldpayerror', 'There is a problem to authorising the payment ');
                redirect(SAURL . 'transactionregistration.php');
            }

        }


        redirect(SAURL . 'transactionregistration.php');


    }


    public function addNewLne()
    {
        $this->cartModal->addNewLne($_POST);
        echo true;
    }

    public function updateNewLine()
    {
        $this->cartModal->updateNewLine($_POST);
        echo true;
    }

    function update_note()
    {
        $id = $this->input->post('Line', true);
        $status = $this->input->post('status', true);
        if ($status == "Delete") {
            $value = "";
        } else {
            $value = $status;
        }
        $this->db->where('ID', $id);
        $this->db->update('temporaryshoppingbasket', array('Product_detail' => $value));
        echo json_encode(array('res' => 'true'));
    }


}
