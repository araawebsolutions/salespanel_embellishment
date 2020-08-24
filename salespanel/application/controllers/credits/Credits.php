<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credits extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->library('Datatables');
        $this->load->library('Table');
        $this->load->database();
        $this->load->model('credit/CreditNoteModel');
        $this->load->model('return/addTicket_model');
        $this->load->model('return/ReturnGetPrice_model');
        $this->load->model('return/MyPriceModels');
    }

    public function index(){
        $data['start'] = 0;
        $data['formats'] = $this->CreditNoteModel->getformats();
        $data['result'] = $this->CreditNoteModel->fetchtickets($data['start'],1);
        $data['main_content'] = "credit/credit_note";
        $this->load->view('page',$data);
    }
    public function fetch_top_counter(){
        $result = $this->CreditNoteModel->fetch_top_counter();
        echo json_encode($result);
    }
    public function getCreditNoteTicketsData(){
        echo $this->CreditNoteModel->getCreditNoteTicketsData();
    }
    public function addCustomLine(){
        $UserID = $this->input->post('UserID');
        $customer_info = $this->CreditNoteModel->getCustomerInfo($UserID);
        if($customer_info){
            echo json_encode($customer_info);
        }
    }
    public function fetchOrdersBycustomer(){
        $uname = $this->input->post('name');
        $email  = $this->input->post('email_address');
        $phone = $this->input->post('ph_no');
        $duration  = $this->input->post('duration');

        echo $data['getOrderNumber'] =  $this->CreditNoteModel->getAllOrders($uname,$email,$phone,$duration);
    }
    public function ordersList(){
        if($this->input->is_ajax_request()){
            $columns = array(
                0 => 'Check',
                1 => 'OrderNumber',
                2 => 'BillingFirstName',
                3 => 'BillingLastName',
                4 => 'BillingPostcode',
                5 => 'BillingCountry',
                6 => 'Description',
                7 => 'Quantity',
                8 => 'Price',
                9 => 'Action'
            );
            $limit = $this->input->post('length');
            $start = $this->input->post('start');

            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];


            $orders_ids = $this->input->post('orderNumber');


            $arr = [];
            $arrWithOutQ = [];
            $or = explode(',',$orders_ids);
            $for_one = "'$or[0]'";
            foreach($or as $o){
                if($o){
                    $os = $o;
                    $o = "'".$o."'";
                    array_push($arr,$o);
                    array_push($arrWithOutQ,$os);
                }
            }
            $orders_ids =  implode(',',$arr);
            //print_r($orders_ids); exit;
            $responseError = 0;
            $errorMessage = '';


            $totalData = 0;
            $totalFiltered = 0;
            $orders_data = array();

            $if_exist = $this->CreditNoteModel->if_note_already_generated($or);
            if($if_exist > 0){
                $json_data = array(
                    'status' => '1',
                    'data' => $orders_data,
                    'responseError' => 1,
                    'errorMessage' => 'Credit Note for given order has already been generated'
                );
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($json_data));
            }

            $chk_if_sample = $this->CreditNoteModel->chk_if_sample_order($or,$for_one);
            if($chk_if_sample > 0){
                $json_data = array(
                    'status' => '1',
                    'data' => $orders_data,
                    'responseError' => 1,
                    'errorMessage' => 'Credit note can\'t be generated for sample order'
                );
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($json_data));
            }


            $chk_if_not_same_customer = $this->CreditNoteModel->chk_if_not_same_customer($or,$for_one);
            if($chk_if_not_same_customer == 1){
                $json_data = array(
                    'status' => '1',
                    'data' => $orders_data,
                    'responseError' => 1,
                    'errorMessage' => 'Given orders belong to different customers'
                );
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($json_data));
            }


            $chk_if_not_same_vat = $this->CreditNoteModel->chk_if_not_same_vat($or,$for_one);
            if($chk_if_not_same_vat == 1){
                $json_data = array(
                    'status' => '1',
                    'data' => $orders_data,
                    'responseError' => 1,
                    'errorMessage' => 'Given orders have different VAT values'
                );
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($json_data));
            }

            //print_r($chk_if_belong_same_customer); exit;

            /*if($if_exist < 0){
                $responseError = 1;
                $errorMessage = 'Credit Note for given order has already been generated';
            }else if($chk_if_sample > 0){
                $responseError = 1;
                $errorMessage = 'Credit note can\'t be generated for sample order';
            }else if($chk_if_not_same_customer == 1){
                $responseError = 1;
                $errorMessage = 'Given orders belong to different customers';
            }else{*/
                $totalData = $this->CreditNoteModel->get_orders_count($or,$for_one);
                $totalFiltered = $totalData;
                if($totalData < 1){

                    $hi = $this->input->post('orderNumber');
                    $if_order_num_entered = strlen($hi) ? count(explode(',', $hi)) : 0;
                    if($if_order_num_entered > 0){
                        $responseError = 1;
                        $errorMessage = 'Given order is not completed yet';
                    }
                }


                $delivery_charges = 0;
                $proceeded_without_order = '';
                $data["vat_exempt"] = '';
                $arrWithOutQ =  implode(',',$arrWithOutQ);
                $data['start'] = 0;
                $chk_out_order = false;
                if($orders_ids){
                    $allOrd =  $this->CreditNoteModel->getAllString($orders_ids);
                    $chk_out_order = $this->IsUni($allOrd);
                    if($chk_out_order==true){
                        $data = '';
                    }else{
                        $data = $this->CreditNoteModel->findOrders($orders_ids,$for_one,$limit,$start,$order,$dir);
                    }
                }else{
                    //redirect(main_url."tickets/addTickets");
                    $proceeded_without_order = 1;
                    $delivery_charges = 0;
                }


                /*echo '<pre>';
                print_r($data); exit;*/


                $initial_grand_total = 0;
                $vat_total = 0;
                $sym = '£';
                $orders_data = array();
                if(!empty($data['res'])) {
                    foreach ($data['res'] as $i=>$result) {
                        $p = 0;
                        $curr = $result['currency'];
                        if ($curr == "GBP") {
                            $sym = '£';
                        } else if ($curr == "EUR") {
                            $sym = '€';
                        } else if ($curr == "USD") {
                            $sym = '$';
                        }

                        $vals = '';
                        if (preg_match("/(1000 Sheet Boxes)/i", $result['ProductName'])) {
                            $vals = '1000';
                        } else {
                            $vals = '250';
                        }


                        if($result["ManufactureID"]!="SCO1"){
                            $nestedData['Check'] = '<div class="checkbox checkbox-info status-check-box spedic">
                                            <input id="checkbox'.$i.'" data-rowNo="'.$i.'" type="checkbox" class="chBox" onclick="chBox('.$i.')">
                                            <label for="checkbox'.$i.'"></label>
                                        </div>';
                        }else{
                            $nestedData['Check'] = '';
                        }

                        $nestedData['OrderNumber'] = $result['OrderNumber'];
                        $nestedData['BillingFirstName'] = $result['BillingFirstName'];
                        $nestedData['BillingLastName'] = $result['BillingLastName'];
                        $nestedData['BillingPostcode'] = $result['BillingPostcode'];
                        $nestedData['BillingCountry'] = $result['BillingCountry'];
                        $nestedData['Description'] = '<span id="descriptionInput'.$i.'">'.$result['ManufactureID'].' - '.$result['ProductName'].'</span>';

                        $nestedData['Quantity'] = '<input data-qty="'.$i.'" type="number"
                                                   class="qty_price_change form-control form-control-sm return-input qty" id="qtyInput'.$i.'" 
                                                   placeholder="123456" value="'.$result["Quantity"].'" min="0" max="'.$result["Quantity"].'"
                                                   aria-controls="responsive-datatable" disabled>';



                        $Price = number_format($result['Price'] * $result['exchange_rate'], 2, '.', '');

                        $nestedData['Price'] = '<div class="input-group " style="flex-wrap: unset; height: 2rem;">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                          style="background-color: #ffffff; border: 1px solid #d0effa;"
                                                          id="basic-addon'.$i.'">'.$sym.'</span>
                                                </div>

                                                <input data-inputPrice="'.$i.'" type="text" placeholder="Enter Price"
                                                       name="searchByCustomerName" id="total_price_with_vat'.$i.'" value="'.$Price.'"
                                                       class="qty_price_change form-control input-border-blue inputPrice" required disabled>
                                        </div>
                                                  
                                <input type="hidden" data-batch="'.$i.'" value="'.$vals.'">
                                <input type="hidden" data-ProductBrand="'.$i.'" value="'.$result["ProductBrand"].'">
                                <input type="hidden" data-ManufactureID="'.$i.'" value="'.$result["ManufactureID"].'">
                                <input type="hidden" id="ManufactureID'.$i.'" value="'.$result["ManufactureID"].'">
                                <input type="hidden" id="ProductID'.$i.'" value="'.$result["ProductID"].'">
                                <input type="hidden" data-labels="'.$i.'" value="'.$result["LabelsPerRoll"].'">
                                <input type="hidden" data-Print_Type="'.$i.'" value="'.$result["Print_Type"].'">
                                <input type="hidden" data-FinishType="'.$i.'" value="'.$result["FinishType"].'">
                                <input type="hidden" data-Printing="'.$i.'" value="'.$result["Printing"].'">
                                <input type="hidden" data-currency="'.$i.'" value="'.$result["currency"].'" disabled>
                                <input type="hidden" data-OrderNumber="'.$i.'" value="'.$result["OrderNumber"].'">
                                <input type="hidden" data-SerialNumber="'.$i.'" value="'.$result["SerialNumber"].'">
                                <input type="hidden" data-newUnitPrice="'.$i.'" value="'.$result["Price"].'" disabled>
                                <input type="hidden" data-newTotalPrice="'.$i.'" value="'.$Price.'" disabled>
                                <input type="hidden" id="total_price_with_vat_old'.$i.'" value="'.$Price.'" disabled>
                                
                                
                                <input type="hidden" data-min_qty_integrated="'.$i.'" value="'.$this->CreditNoteModel->min_qty_integrated($result["ManufactureID"]).'" disabled>
                                <input type="hidden" data-min_qty_integrated="'.$i.'" value="'.$this->CreditNoteModel->max_qty_integrated($result["ManufactureID"]).'" disabled>
                                <input type="hidden" data-min_qty_integrated="'.$i.'" value="'.$this->CreditNoteModel->calulate_min_rolls($result["ManufactureID"]).'" disabled>
                                <input type="hidden" data-min_qty_integrated="'.$i.'" value="'.$this->CreditNoteModel->calulate_max_rolls($result["ManufactureID"]).'" disabled>
                                ';
                        $nestedData['Action'] = '
                        <td>
                                            <button id="price_change_btn'.$i.'" onclick="price_change_func('.$i.','.$p.')" class="btn btn-outline-dark btn-sm disabledbutton">
                                                Calculate
                                            </button>
                                        </td>
                                        <input type="hidden" class="deliver_charges_val" value="'.$data["delivery_charges"].'">
                                        
                        ';

                        $orders_data[] = $nestedData;

                        //if($result['Printing'] == 'Y' && $result['ProductBrand'] != 'Roll Labels'){
                        if($result['Printing'] == 'Y'){
                            $p = 1;

                            if($result['Print_Type'] == "Fullcolour"){
                                $Print_Type = "4 Colour Digital Process";
                            }else{
                                $Print_Type = $result['Print_Type'];
                            }
                            if($result["Print_Qty"] > 0){
                                $Print_Qty = $result["Print_Qty"];
                            }else{
                                $Print_Qty = 0;
                            }
                            $Price_print = number_format($result['Print_Total'] * $result['exchange_rate'], 2, '.', '');


                            $nestedData['Check'] = '';
                            $nestedData['OrderNumber'] = '';
                            $nestedData['BillingFirstName'] = '';
                            $nestedData['BillingLastName'] = '';
                            $nestedData['BillingPostcode'] = '';
                            $nestedData['BillingCountry'] = '';

                            if($Print_Qty > 0){
                                $design_qty = ' , <span>  '.$Print_Qty.' Design</span>';
                            }else{
                                $design_qty = '';
                            }
                            if($result['ProductBrand'] != 'Roll Labels') {
                                $nestedData['Description'] = '<span id="descriptionInputPrint'.$i.'">'.$Print_Type.'</span> '.$design_qty;
                            }else{
                                $nestedData['Description'] = '<span id="descriptionInputPrint'.$i.'">'.$Print_Type.'</span> '.$design_qty.'
                                <strong style="font-size:12px;"> Wound: </strong><span>'.$result['Wound'].', </span>
                                <strong style="font-size:12px;"> Orientation: </strong><span>'.$result['Orientation'].', </span>
                                <strong style="font-size:12px;"> Finish: </strong><span>'.$result['FinishType'].', </span>
                                <strong style="font-size:12px;"> Press Proof: </strong><span>'.(($result['pressproof'] == 1)?"Yes":"No").'</span> 
                                ';
                            }

                            $nestedData['Quantity'] = '<p class="text-center">'.$Print_Qty.'</p><input data-qtyPrint="'.$i.'" type="hidden"
                                                   class="qty_price_change_print form-control form-control-sm return-input qty" id="qtyInputPrint'.$i.'"
                                                   placeholder="123456" value="'.$Print_Qty.'" min="0" max="'.$Print_Qty.'"
                                                   aria-controls="responsive-datatable" disabled>';

                            if($result['ProductBrand'] != 'Roll Labels') {
                                $nestedData['Price'] = '<p class="text-center">'.$sym.' '.number_format($Price_print, 2, '.', '').'</p><div class="input-group">
                                               
                                                <input data-inputPricePrint="' . $i . '" type="hidden" placeholder="Enter Price"
                                                       name="searchByCustomerName" id="total_price_with_vat_print' . $i . '" value="' . $Price_print . '"
                                                       class="qty_price_change_print form-control input-border-blue inputPrice" required disabled>
                                        </div>
                                        <input type="hidden" id="total_price_with_vat_print_old' . $i . '" value="' . $Price_print . '" disabled>
                                        ';
                            }else{
                                $nestedData['Price'] = '';
                            }



                            $nestedData['Action'] = '
                        <td>
                                            <button id="price_change_btn_print'.$i.'" onclick="price_change_func(' . $i . ',' . $p . ')" class="btn btn-outline-dark btn-sm disabledbutton">
                                                Calculate
                                            </button>
                                        </td>
                                        <input type="hidden" class="deliver_charges_val" value="'.$data["delivery_charges"].'">
                                        
                        ';

                            $orders_data[] = $nestedData;
                        }

                    }
                    if($data["proceeded_without_order"] == 0){
                        $delivery_charges = number_format($data["delivery_charges"], 2, '.', '');
                        $proceeded_without_order = 0;
                    }else{
                        $delivery_charges = 0.00;
                        $proceeded_without_order = 1;
                    }
                    if($data["vat_exempt"] == 'yes'){
                        $vat_total = - (($delivery_charges * vat_rate) - $delivery_charges);
                        $initial_grand_total = $delivery_charges;
                    }else{
                        $vat_total = (($delivery_charges * vat_rate) - $delivery_charges);
                        $initial_grand_total = $delivery_charges + $vat_total;
                    }

                }







            //print_r('ji');
            //print_r($proceeded_without_order); exit;


            /*}*/
            $json_data = array(
                "draw"                  => intval($this->input->post('draw')),
                "recordsTotal"          => intval($totalData),
                "recordsFiltered"       => intval($totalFiltered),
                "data"                  => $orders_data,
                'status'                => '1',
                'responseError'         => $responseError,
                'errorMessage'          => $errorMessage,
                'delivery_charges'      => $delivery_charges,
                'initial_vat_total'     => $vat_total,
                'initial_grand_total'   => $initial_grand_total,
                'deliver_charges_curr'  => $sym,
                'proceeded_without_order'  => $proceeded_without_order,
                'vat_exempt'  => $data["vat_exempt"]
            );
            echo json_encode($json_data);
        }
    }







    function printCreditNote($cr_note_id){
        $this->credit_note_pdf($cr_note_id);
    }
    function credit_note_pdf($cr_note_id){
        $data = $this->CreditNoteModel->fetchTicketDetailsPrint($cr_note_id);

        /*echo '<pre>';
        print_r($data);
        exit;
        $language="en";
        if($data){
            if($data['ticketMains']['BillingCountry'] == 'France'){
                $language="fr";
            }
        }*/
        /*print_r($data['language']);
        exit;*/

        $language = $data['language'];
        $page = ($language=="en")?"credit/en/credit_note_pdf.php":"credit/fr/credit_note_pdf.php";


        $this->load->library('pdf');
        $this->pdf->load_view($page,$data,TRUE);
        $this->pdf->render();

        $output = $this->pdf->output();
        $output_dir = "theme/assets/pdf/credit_notes";
        $file_location = $output_dir."/credit-note_".$cr_note_id.".pdf";
        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777, true);
        }

        $filename = $file_location;
        fopen($filename, "a");
        file_put_contents($file_location,$output);
        $this->pdf->stream("Credit Note: ".$cr_note_id.".pdf");
    }






    function addOperatorAdditionalNote(){
        $cr_note_id = $this->input->post('cr_note_id');
        $note_data = array(
            'cr_note_id' => $cr_note_id,
            'operator_note' => $this->input->post('operator_note'),
            'created_by' => $this->session->userdata('UserID'),
            'created_at' => date("Y-m-d H:i:s"),
            'is_updated' => 0
        );


        $data = $this->CreditNoteModel->addOperatorAdditionalNote($note_data, $cr_note_id);
        //print_r($data); exit;
        echo json_encode($data);

    }

    function addOperatorAdditionalNoteBeforeSave(){
        $sr = rand(1,999999);
        $data = array(
            'sr' => $sr,
            'operator_note' => $this->input->post('operator_note'),
            'created_by' => $this->session->userdata('UserName'),
            'created_at' => date("Y-m-d H:i:s")
        );
        echo json_encode($data);

    }
    function getTicketDetails(){
        $id = $this->uri->segment(3);
        $data['start'] = 0;
        $data['result'] = $this->CreditNoteModel->fetchTicketDetails($id);
        //echo '<pre>';
        //print_r($data['result']);
        //print_r($data['result']['ticketDetails']);
        //print_r($data['result']['proceeded_without_order']);
        //exit;
        $data['main_content'] = "credit/update_credit_note";
        $this->load->view('page',$data);
    }


    function createTicket(){
        $order_details_data = $this->input->post('orders_details');


        $operator_additional_notes_data = $this->input->post('operator_additional_notes_data');

        //$qty_exceeds = $this->CreditNoteModel->chkExceedingValues($order_details_data);

        $customer_data = $this->CreditNoteModel->getCustomerDetailByID($this->input->post('UserID'));
        /*$SrNo = $this->CreditNoteModel->getTicketNo();
        if(!$SrNo){
            $SrNo = '0001';
        }*/
        //print_r($_POST); exit;
        //print_r($this->input->post('total_delivery')); exit;
        $SrNo = 0;
        $ticket_main_data = array(
            'UserID' => $this->input->post('UserID'),
            'created_by' => $this->session->userdata('UserID'),
            'total_delivery' => $this->input->post('total_delivery'),
            'total_vat' => $this->input->post('total_vat'),
            'ticketSrNo' => $SrNo,
            'followUpDate' => date("Y-m-d"),
            'create_date' => date("Y-m-d H:i:s"),
            //'ticket_type' => 1, //1 for credit note
            'cr_note_status' => 0,
            'approved_by' => 0,
            'BillingTitle' => $customer_data['BillingTitle'],
            'BillingFirstName' => $customer_data['BillingFirstName'],
            'BillingLastName' => $customer_data['BillingLastName'],
            'BillingCompanyName' => $customer_data['BillingCompanyName'],
            'BillingAddress1' => $customer_data['BillingAddress1'],
            'BillingAddress2' => $customer_data['BillingAddress2'],
            'BillingTownCity' => $customer_data['BillingTownCity'],
            'BillingCountyState' => $customer_data['BillingCountyState'],
            'BillingPostcode' => $customer_data['BillingPostcode'],
            'BillingCountry' => $customer_data['BillingCountry'],
            'BillingTelephone' => $customer_data['BillingTelephone'],
            'BillingMobile' => $customer_data['BillingMobile'],
            'BillingFax' => $customer_data['BillingFax'],
            'BillingEmail' => $customer_data['UserEmail'],
            'BillingResCom' => $customer_data['BillingResCom'],
            'DeliveryTitle' => $customer_data['DeliveryTitle'],
            'DeliveryFirstName' => $customer_data['DeliveryFirstName'],
            'DeliveryLastName' => $customer_data['DeliveryLastName'],
            'DeliveryCompanyName' => $customer_data['DeliveryCompanyName'],
            'DeliveryAddress1' => $customer_data['DeliveryAddress1'],
            'DeliveryAddress2' => $customer_data['DeliveryAddress2'],
            'DeliveryTownCity' => $customer_data['DeliveryTownCity'],
            'DeliveryCountyState' => $customer_data['DeliveryCountyState'],
            'DeliveryPostcode' => $customer_data['DeliveryPostcode'],
            'DeliveryCountry' => $customer_data['DeliveryCountry'],
            'DeliveryTelephone' => $customer_data['DeliveryTelephone'],
            'DeliveryMobile' => $customer_data['DeliveryMobile'],
            'DeliveryFax' => $customer_data['DeliveryFax'],
            'DeliveryEmail' => $customer_data['DeliveryEmail'],
            'DeliveryResCom' => $customer_data['DeliveryResCom']
        );

        $userID = $this->session->userdata('UserID');

        if($userID){
            $success = $this->CreditNoteModel->createTicket($order_details_data,$ticket_main_data,$operator_additional_notes_data);
            //print_r($qty_exceeds); exit;

            /*if($success){
                $this->session->set_flashdata('success_msg','Ticket Generated Successfully');
            }*/
            /*if($qty_exceeds < 0){
                $this->session->set_flashdata('error_msg','Can\'t create, some item\'s return quantity is exceeding than the original order quantity');
            }else{
                $this->session->set_flashdata('success_msg','Ticket Generated Successfully');
            }*/
        }



        //redirect('index.php/tickets/returns');
        redirect(main_url."credit-notes");
    }

    function deleteOperatorAdditionalNote(){
        $note_id = $this->input->post('note_id');
        $is_deleted = $this->CreditNoteModel->deleteOperatorAdditionalNote($note_id);
        /*echo '<pre>';
        print_r($is_deleted['status']); exit;*/
        if($is_deleted['status'] == 1){
            $return = array(
                'status' => '1',
                'message' => 'Deleted successfully',
                'data' => $is_deleted['operatorNotes']
            );
        }else{
            $return = array(
                'status' => '0',
                'message' => 'An error occurred, Please refresh the page and try again',
                'data' => ''
            );
        }
        //$array = $this->cleanArray($return);
        echo json_encode($return);
    }

    function ticketActionPerformed(){
        $action_type = $this->input->post('action_type');
        $cr_note_id = $this->input->post('cr_note_id');


        //print_r($cr_note_id); exit;

        $is_updated = 0;
        if($action_type == 1 || $action_type == 2){
            $is_updated = $this->CreditNoteModel->ticketApproveDecline($action_type, $cr_note_id);
        }


        //print_r($is_updated); exit;
        if($is_updated){
            if($action_type == 1){
                $message = 'Approved and Credit Note Generated Successfully';
            }else{
                $message = 'Ticket Declined';
            }
            $return = array(
                'status' => '1',
                'message' => $message
            );
        }else{
            $return = array(
                'status' => '0',
                'message' => 'An error occurred, Please refresh the page and try again'
            );
        }
        //$array = $this->cleanArray($return);
        echo json_encode($return);
    }

    function checkMaxQty(){
        $SerialNumber = $this->input->post('SerialNumber');

        $order_qty = $this->CreditNoteModel->checkMaxQty($SerialNumber);
        echo json_encode($order_qty);
    }

    function checkMaxPrice(){
        $SerialNumber = $this->input->post('SerialNumber');

        $order_price = $this->CreditNoteModel->checkMaxPrice($SerialNumber);
        echo json_encode($order_price);
    }






    function updateTicket(){
        $ticket_details_data = $this->input->post('orders_details');
        $cr_note_id = $this->input->post('cr_note_id');
        $total_delivery = $this->input->post('total_delivery');
        $total_vat = $this->input->post('total_vat');

        $get_status = $this->CreditNoteModel->getCreditNoteStatus($cr_note_id);
        if($get_status == 1){
            $return = array(
                'status' => '0',
                'data' => '',
                'message' => 'Cant update, this credit note has been approved'
            );


            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($return));
        }

        $qty_exceeds = $this->CreditNoteModel->chkExceedingValues($ticket_details_data, $cr_note_id);


        $ticket_details_data = json_decode($ticket_details_data,true);
        foreach($ticket_details_data as $key => $ord){
            if($ord['cr_note_details_id'] == 0){
                if(!$ord["productDescription"]){
                    $response=array(
                        'status' => 0,
                        'message' => 'Product Description is required for custom line'
                    );
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode($response));
                }
                if(!$ord["returnQty"]){
                    $response=array(
                        'status' => 0,
                        'message' => 'Quantity is required for custom line'
                    );
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode($response));
                }
                if(!$ord["returnUnitPrice"]){
                    $response=array(
                        'status' => 0,
                        'message' => 'Price is required for custom line'
                    );
                    return $this->output->set_content_type('application/json')
                        ->set_output(json_encode($response));
                }
            }
        }


        $this->CreditNoteModel->updateTicket($ticket_details_data, $cr_note_id, $total_delivery, $total_vat);
        /*if(empty($qty_exceeds)){
            print_r('hi'); exit;
        }else{
            print_r($qty_exceeds); exit;
        }*/


        if(empty($qty_exceeds)){
            $return = array(
                'status' => '1',
                'data' => '',
                'message' => 'Updated Successfully'
            );
        }else{
            $return = array(
                'status' => '0',
                'data' => $qty_exceeds,
                'message' => 'Some values could not be updated because return quantity was exceeding than the original order quantity'
            );
        }
        echo json_encode($return);
    }


    function calculateGTPrice(){
        $ticket_details_data = $this->input->post('orders_details');
        $cr_note_id = $this->input->post('cr_note_id');

        /*$get_status = $this->CreditNoteModel->getCreditNoteStatus($cr_note_id);
        if($get_status == 1){
            $return = array(
                'status' => '0',
                'data' => '',
                'message' => 'Cant update, this credit note has been approved'
            );


            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($return));
        }*/

        $qty_exceeds = $this->CreditNoteModel->calculateGTPrice($ticket_details_data, $cr_note_id);


        /*echo '<pre>';
        print_r($qty_exceeds); exit;*/


        if(empty($qty_exceeds)){
            $return = array(
                'status' => '1',
                'data' => '',
                'message' => 'Updated Successfully'
            );
        }else{
            $return = array(
                'status' => '0',
                'data' => $qty_exceeds,
                'message' => 'Some values could not be updated because return quantity was exceeding than the original order quantity'
            );
        }
        echo json_encode($return);

    }



    public function getAllTicketsData(){
        echo $this->CreditNoteModel->getAllTicketsData();
    }
    function getOrderCustomerInfo(){
        $orders_ids = $this->input->post('orderNumber');
        //print_r($orders_ids); exit;
        $arr = [];
        $arrWithOutQ = [];
        $or = explode(',',$orders_ids);
        $for_one = "'$or[0]'";
        foreach($or as $o){
            if($o){
                $os = $o;
                $o = "'".$o."'";
                array_push($arr,$o);
                array_push($arrWithOutQ,$os);
            }
        }
        $orders_ids =  implode(',',$arr);
        $arrWithOutQ =  implode(',',$arrWithOutQ);

        $customer_info = $this->CreditNoteModel->get_orders_related_customer_info($orders_ids);
        //print_r($customer_info); exit;

        if($orders_ids){
            if($customer_info){
                echo json_encode($customer_info);
            }
        }else{
            //redirect(main_url."tickets/addTickets");
        }
    }
    function searchForCustomer(){
        $email_address = $this->input->post('email_address');


        $customer_info = $this->CreditNoteModel->search_for_customer($email_address);
        if($customer_info){
            echo json_encode($customer_info);
        }
    }

    public function addCreditNotes(){
        $data['main_content'] = "credit/add_credit_note";
        $this->load->view('page',$data);
    }

    function findOrders(){
        $orders_ids = $this->input->post('orderNumber');

        $arr = [];
        $arrWithOutQ = [];
        $or = explode(',',$orders_ids);


        $for_one = "'$or[0]'";

        foreach($or as $o){
            if($o){
                $os = $o;
                $o = "'".$o."'";
                array_push($arr,$o);
                array_push($arrWithOutQ,$os);
            }
        }

        $orders_ids =  implode(',',$arr);
        $arrWithOutQ =  implode(',',$arrWithOutQ);

        $data['start'] = 0;


        $chk_out_order = false;
        if($orders_ids){

            $allOrd =  $this->addTicket_model->getAllString($orders_ids);
            $chk_out_order = $this->IsUni($allOrd);
            if($chk_out_order==true){
                $data['result'] = '';
            }else{
                $data['result'] = $this->addTicket_model->findOrders($orders_ids,$for_one);
            }
        }else{
            redirect(main_url."tickets/addTickets");
        }

        $data['chk_out_order'] = $chk_out_order;
        $data['order_numbers'] = $arrWithOutQ;
        //$data['main_content'] = "return/addTicket";
        $data['main_content'] = "credit/add_credit_note";
        $this->load->view('page',$data);
    }



    function IsUni($allOrd){
        $chk_out_order =false;
        $Fid = '';
        $ar_chk = [];
        if(count($allOrd) > 0){
            $i = 0;
            foreach($allOrd as $alo){
                if($i==0){$Fid = $alo['UserID'];}
                if($Fid==$alo['UserID']){
                    array_push($ar_chk,$alo['OrderNumber']);
                }else{
                    $chk_out_order = true;
                }
                $i++;
            }
        }
        return $chk_out_order;
    }




    public function emailCreditNote(){
        if($this->input->post('cr_note_id')){
            $cr_note_id = $this->input->post('cr_note_id');
        }else{
            $cr_note_id = '';
        }

        if($this->input->post('email_subject')){
            $email_subject = $this->input->post('email_subject');
        }else{
            $email_subject = '';
        }

        if($this->input->post('email_body')){
            $email_body = $this->input->post('email_body');
        }else{
            $email_body = '';
        }

        $sent = $this->CreditNoteModel->emailCreditNote($cr_note_id, $email_subject, $email_body);

        if($sent && $sent==1){
            $json_data = array(
                'status' => '1',
                'message' => 'Email Sent'
            );
        }else{
            $json_data = array(
                'status' => '0',
                'message' => 'An error occurred, please try again later.'
            );
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json_data));

        /*$this->session->set_flashdata('success_msg','Email Sent');
        redirect(main_url."credit-notes/detail/".$cr_note_id);*/
    }
    public function make_csv(){
        $this->load->dbutil();

        $to = ''; $from = '';
        /*$to = $this->input->post('rep_to');
        $from = $this->input->post('rep_from');*/

        if($this->input->post('rep_to')){
            $to= $this->getDbFormateDate($this->input->post('rep_to'));
        }

        if($this->input->post('rep_from')){
            $from= $this->getDbFormateDate($this->input->post('rep_from'));
        }


        $format = $this->input->post('rep_format');
        $status = $this->input->post('rep_status');
        $areaResponsible = $this->input->post('rep_area');

        $res =$this->CreditNoteModel->fetchTicketDetailsCsv($to,$from,$format,$status,$areaResponsible);
        //echo '<pre>'; print_r($res); exit;

        /*if ($res->num_rows() ==0 ) {

            //$this->session->set_flashdata('msg','Record not found');
            redirect(main_url."credit-notes");

        } else {*/
            $delimiter = ",";
            $newline = "\r\n";
            $enclosure = '"';
            $csvData = $this->dbutil->csv_from_result($res,$delimiter, $newline, $enclosure);

        //$csvData = '€37.96';
        //$csvData = '&euro';
            $csvData =  mb_convert_encoding($csvData, "Windows-1252", "UTF-8");
        /*echo '<pre>';
        print_r($csvData); exit;*/
            $filename="Credit-Notes-Report.csv";
            force_download($filename,$csvData);
            redirect(main_url."credit-notes");
        /*}*/
    }

    function getDbFormateDate($date){
        $str = str_replace('/', '-', $date);
        return $newDate = date('Y-m-d',strtotime($str));
    }

    function changeUpdateStatus($cr_note_id){
        $this->db->set('updateStatus', 0)
            ->where('cr_note_id', $cr_note_id)
            ->update('cr_notes');
        redirect(main_url."credit-notes/detail/".$cr_note_id);
    }


    function getPrice(){

        $Productbrand = $this->input->post('ProductBrand');
        $mID = $this->input->post('ManufactureID');
        $qty = $this->input->post('newQty');
        $batch = $this->input->post('batch');

        $labels = $this->input->post('labels');
        $Print_Type = $this->input->post('Print_Type');
        $FinishType = $this->input->post('FinishType');
        $Printing = $this->input->post('Printing');
        $SerialNumber = $this->input->post('SerialNumber');

        $this->CreditNoteModel->get_price($Productbrand,$mID,$qty,$batch,$labels,$Print_Type,$FinishType,$Printing,$SerialNumber);
        //$this->MyPriceModel->getPrice($Productbrand,$mID,'');
    }
}