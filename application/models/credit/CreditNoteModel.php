<?php
class CreditNoteModel extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('return/ReturnGetPrice_model');
    }

    function fetchtickets($start,$limit){
        $query = "select * from cr_notes order by cr_note_id asc limit $start , $limit ";
        return $this->db->query($query)->result();
    }


    function if_note_already_generated($orders_ids){
        $this->db->join('cr_notes', 'cr_notes.cr_note_id = cr_note_details.cr_note_id');
        $this->db->where_in('orderNumber',$orders_ids);
        $this->db->where('cr_notes.cr_note_status !=', 2);
        $query = $this->db->get('cr_note_details');
        return $query->num_rows();
    }

    function get_orders_count($orders_ids,$for_one){
        $this->db->select('orderdetails.OrderNumber');
        $this->db->from('orderdetails');
        $this->db->join('orders', 'orders.OrderNumber = orderdetails.OrderNumber');
        $this->db->join('customers', 'customers.UserID = orders.UserID');
        $this->db->where_in('orders.OrderStatus', [7]);
        $this->db->where_in('orderdetails.OrderNumber', $orders_ids);
        $query = $this->db->get();

        return $query->num_rows();
    }

    function chk_if_sample_order($orders_ids,$for_one){
        $this->db->select('orders.OrderNumber');
        $this->db->from('orders');
        //$this->db->join('orders', 'orders.OrderNumber = orderdetails.OrderNumber');
        $this->db->where_in('orders.OrderNumber', $orders_ids);
        $this->db->where('orders.PaymentMethods', 'Sample Order');
        $query = $this->db->get();

        return $query->num_rows();
    }

    function chk_if_not_same_customer($orders_ids, $for_one){
        $error = 0;
        if(count($orders_ids) > 1){
            $this->db->select('orders.UserID');
            $this->db->from('orders');
            $this->db->where_in('orders.OrderNumber', $orders_ids);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $user_ids = $query->result();
            }
            foreach ($user_ids as $i=>$user_id){
                if($i == 0){
                    $uid = $user_id->UserID;
                }
                if($i > 0){
                    if($uid == $user_id->UserID){
                        continue;
                    }else{
                        $error = 1;
                    }
                }
            }
        }
        return $error;
    }

    function chk_if_not_same_vat($orders_ids, $for_one){
        $error = 0;
        if(count($orders_ids) > 1){
            $this->db->select('orders.vat_exempt');
            $this->db->from('orders');
            $this->db->where_in('orders.OrderNumber', $orders_ids);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $vats = $query->result();
            }
            foreach ($vats as $i=>$vat){
                if($i == 0){
                    $vat_val = $vat->vat_exempt;
                }
                if($i > 0){
                    if($vat_val == $vat->vat_exempt){
                        continue;
                    }else{
                        $error = 1;
                    }
                }
            }
        }
        return $error;
    }


    function get_orders_related_customer_info($orders_ids){
        //
        //$orders_ids = array($orders_ids);
        //print_r($orders_ids); exit;
        /*$this->db->select('orderdetails.OrderNumber');
        $this->db->from('orderdetails');
        $this->db->join('orders', 'orders.OrderNumber = orderdetails.OrderNumber');
        $this->db->where_in('orders.OrderStatus', [7,8]);
        $this->db->where_in('orderdetails.OrderNumber', $orders_ids);
        $query = $this->db->get();
        return $query->num_rows();*/

        /*print_r($orders_ids);
        print_r('hi');
        exit;*/
        $query = "SELECT cus.BillingFirstName, cus.BillingLastName, concat(cus.BillingFirstName,' ',cus.BillingLastName) as Name, cus.UserID, cus.BillingPostcode,
        cus.BillingCountry,cus.BillingTelephone,cus.UserEmail as BillingEmail,concat(cus.BillingAddress1,',', cus.BillingPostcode) as address
        FROM `orders` as o 
        inner join customers as cus on cus.UserID=o.UserID
        where (o.OrderStatus=7/* || o.OrderStatus=8*/) && o.OrderNumber IN (".$orders_ids.")
        limit 1
        ";
        $res = $this->db->query($query)
            ->row();
        return $res;
    }
    function deleteOperatorAdditionalNote($note_id){
        $get_cr_note_id = $this->db->select('cr_note_id')->where('additional_note_id', $note_id)->get('operator_additional_notes');
        if($get_cr_note_id->num_rows() > 0){
            $cr_note_id = $get_cr_note_id->row()->cr_note_id;
        }else{
            $cr_note_id = -1;
        }

        $operatorNotes = array();
        if($cr_note_id != -1){
            $this->db->set('updateStatus', 1)
                ->where('cr_note_id', $cr_note_id)
                ->update('cr_notes');


            $this->db->where('additional_note_id', $note_id);
            $this->db->delete('operator_additional_notes');

            $notes = $this->db->select('n.additional_note_id, n.operator_note, n.created_at, c.UserName')
                ->join('customers as c', 'c.UserID = n.created_by')
                ->where('n.cr_note_id', $cr_note_id)
                ->get('operator_additional_notes as n');
            $operatorNotes = $notes->result();

            $res = array(
                'operatorNotes'=>$operatorNotes,
                'status'=>1
            );
        }else{
            $res = array(
                'operatorNotes'=>$operatorNotes,
                'status'=>0
            );
        }
        return $res;

    }
    function getUserID($name ,$email, $phone){
        $this->db->select("UserID");
        $this->db->from('customers');
        $this->db->like('BillingTelephone',$phone);
        $this->db->like(array('CONCAT_WS(" ",BillingFirstName,BillingLastName)'=>$name));
        $this->db->like(array('UserEmail'=>$email));

        $res = $this->db->get();
        //echo $this->db->last_query();

        $count = $res->num_rows();
        $res = $res->result_array();
        if($count > 0){
            return $res[0]['UserID'];

        }else{
            return '002001';
        }
    }
    public function getAllOrders($name,$email, $phone, $duration){
        $where = ' 1=1 ';

        $UserId = $this->getUserID($name,$email,$phone);

        if(isset($duration) and $duration !='all') {
            if($duration == 7) {
                $where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY )) AND UNIX_TIMESTAMP(NOW())";
            }
            else if($duration == 30) {
                $where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 MONTH )) AND UNIX_TIMESTAMP(NOW())";
            }
            else if($duration == 90) {
                $where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 MONTH )) AND UNIX_TIMESTAMP(NOW())";
            }
            else if($duration == 180) {
                $where = "orders.OrderDate BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 6 MONTH )) AND UNIX_TIMESTAMP(NOW())";
            }
        }
        $wh = "(orders.OrderStatus = 7)";

        $this->db->select("orders.OrderNumber");
        $this->db->join("orderdetails", "orderdetails.OrderNumber = orders.OrderNumber");
        $this->db->from('orders');
        $this->db->group_by('orders.OrderNumber');
        $this->db->where($where);
        $this->db->where(array('orders.UserID'=>$UserId));
        $this->db->where('orders.PaymentMethods !=', 'Sample Order');
        $this->db->where($wh);

        $res = $this->db->get()->result_Array();

        // echo $this->db->last_query();echo '<br>';echo '<br>';echo '<br>';

        $r = false;
        if(count($res) > 0){
            $r = json_encode($res);
        }

        if($UserId){
            return  $r;
        }else{
            return $r;
        }

    }

    public function getCreditNoteTicketsData(){
        /*$this->datatables->select('
        (SELECT DISTINCT cr_notes.cr_note_id),
        cr_notes.ticketSrNo,
        cr_notes.updateStatus,
        (SELECT GROUP_CONCAT(DISTINCT  orderNumber) as f FROM `cr_note_details` where cr_notes.cr_note_id = 	cr_note_details.cr_note_id),
        (select concat(cr_note_details.returnCurrency,",",ROUND(sum(cr_note_details.returnUnitPrice),2)) as total_amount from cr_note_details where cr_note_details.cr_note_id=cr_notes.cr_note_id),
        (select CONCAT(customers.BillingFirstName," ", customers.BillingLastName) as Name from customers  where customers.UserId=cr_notes.UserID),
        customers.BillingTelephone,
        (select UserName from customers  where customers.UserId=cr_notes.created_by),
        concat(DATE_FORMAT(cr_notes.create_date, "%d/%m/%Y")),
        cr_notes.UserID,
        cr_notes.cr_note_status,
        ')
            ->join('cr_note_details', 'cr_note_details.cr_note_id = cr_notes.cr_note_id', 'inner')
            ->join('customers', 'customers.UserID = cr_notes.UserID')
            ->group_by('cr_note_details.cr_note_id')
            ->from('cr_notes');

        echo $this->datatables->generate();*/


        $this->datatables->select('t.cr_note_id')
            ->select('t.ticketSrNo')
            ->select('t.updateStatus')
            ->select('(SELECT GROUP_CONCAT(DISTINCT  orderNumber) as f FROM `cr_note_details` where t.cr_note_id = 	cr_note_details.cr_note_id)')
            ->select('(select concat(cr_note_details.returnCurrency,",",ROUND(sum(cr_note_details.returnUnitPrice + cr_note_details.returnPricePrint),2)) as total_amount from cr_note_details where cr_note_details.cr_note_id=t.cr_note_id  )')
            ->select('(select CONCAT(customers.BillingFirstName," ", customers.BillingLastName) as Name from customers  where customers.UserID=t.UserID  )')
            ->select('(select CONCAT(customers.BillingTelephone) as BillingTelephone from customers where customers.UserID=t.UserID)')
            ->select('(select CONCAT(customers.UserName) as UserName from customers where customers.UserID=t.created_by)')
            ->select('concat(DATE_FORMAT(t.create_date, "%d/%m/%Y %H:%i:%s"))')
            ->select('t.UserID')
            ->select('t.cr_note_status')
            ->select('(SELECT GROUP_CONCAT(DISTINCT products.ProductBrand) as f FROM `cr_note_details` inner join orderdetails on orderdetails.SerialNumber=cr_note_details.serialNumber inner join products on products.ProductID = orderdetails.ProductID where cr_note_id = t.cr_note_id and orderdetails.ProductID > 0)')
            ->select('(t.total_vat + t.total_delivery) as vat_plus_delivery')
            ->from('cr_notes as t');
            echo $this->datatables->generate();
    }

    function fetch_top_counter(){
        $query1 = $this->db->query("select count(*) as total from cr_notes")->row_array();
        $total = $query1['total'];

        $query2 = $this->db->query("select count(*) as total_pending from cr_notes where cr_note_status=0")->row_array();
        $total_pending= $query2['total_pending'];

        return array('total'=>$total,'total_pending'=>$total_pending);
    }

    function search_for_customer($email_address){
        /*$query = "concat(customers.BillingFirstName,' ',customers.BillingLastName) as Name, customers.UserID, customers.BillingPostcode,
        customers.BillingCountry,customers.BillingTelephone,customers.UserEmail,concat(customers.BillingAddress1,',', customers.BillingPostcode) as address
        ";
        $this->db->select($query);
        $this->db->where('UserEmail', $email_address);
        $user_info = $this->db->get('customers');
        */
        $this->db->select('
        CONCAT(customers.BillingFirstName," ",customers.BillingLastName) AS Name,
        customers.UserID, customers.BillingPostcode,
        customers.BillingCountry,customers.BillingTelephone,customers.UserEmail,
        CONCAT(customers.BillingAddress1,", ",customers.BillingPostcode) AS address
        ');
        $this->db->where('UserEmail', $email_address);
        $user_info = $this->db->get('customers');

       /* $user_info = $this->db->select('BillingFirstName', 'BillingLastName', '')
            ->where('UserID', $email_address)
            ->get('customers');*/
        if($user_info->num_rows() > 0){
            return $user_info->row();
        }else{
            return false;
        }
    }

    function getCustomerInfo($UserID){
        //print_r($UserID); exit;
        $user_info = $this->db->select('customers.*')
            ->where('UserID', $UserID)
            ->get('customers');
        if($user_info->num_rows() > 0){
            //print_r($user_info->num_rows()); exit;
            return $user_info->row();
        }else{
            return false;
        }

    }

    function fetchTicketDetails($id){
        $query = $this->db->select('
        cr_notes.cr_note_id as cr_note_main_id, cr_notes.ticketSrNo, cr_notes.UserID,
        cr_notes.ticketStatus, cr_notes.create_date,
        cr_notes.created_by, cr_notes.cr_note_status, cr_notes.approved_by,
        cr_notes.BillingFirstName, cr_notes.BillingLastName,
        cr_notes.BillingPostcode, cr_notes.BillingCountry, cr_notes.BillingEmail, cr_notes.BillingTelephone,
        CONCAT(cr_notes.BillingFirstName," ",cr_notes.BillingLastName) AS Name,
        CONCAT(cr_notes.BillingAddress1," ",cr_notes.BillingPostcode) AS address
        ')
            //->join('customers', 'customers.UserID = cr_notes.UserID')
            ->where('cr_notes.cr_note_id', $id)
            ->group_by('cr_notes.cr_note_id')
            ->get('cr_notes');
        $ticket_mains = $query->row_array();


        $query = $this->db->select('
        cr_note_details.*, p.ProductBrand,
        od.Wound, od.Orientation, od.FinishType, od.pressproof
        ')
            ->join('products as p', 'p.ProductID = cr_note_details.ProductID', 'left')
            ->join('orderdetails as od', 'od.SerialNumber = cr_note_details.serialNumber', 'left')
            ->where('cr_note_details.cr_note_id', $id)
            ->group_by('cr_note_details.cr_note_details_id')
            ->get('cr_note_details');
        $ticket_details = $query->result_array();
        if($ticket_mains){
            $customer = "concat(customers.BillingFirstName,' ',customers.BillingLastName) as Name, customers.UserID, customers.BillingPostcode,
        customers.BillingCountry,customers.BillingTelephone,customers.UserEmail,concat(customers.BillingAddress1,',', customers.BillingPostcode) as address
        ";
            $this->db->select($customer);
            $this->db->where('UserID', $ticket_mains['UserID']);
            $customerDetails = $this->db->get('customers')->row_array();

            $notes = $this->db->select('n.additional_note_id, n.operator_note, n.created_at, c.UserName')
                ->join('customers as c', 'c.UserID = n.created_by')
                ->where('n.cr_note_id', $id)
                ->get('operator_additional_notes as n');
            $operatorNotes = $notes->result_array();


            $logs = $this->db->select('e.LogID, e.receiver_email, e.sent_at, c.UserName')
                ->join('customers as c', 'c.UserID = e.sent_by')
                ->where('e.cr_note_id', $id)
                ->get('credit_email_logs as e');
            $email_logs = $logs->result_array();




            $delivery_charges = 0;
            $vat_exempt = 'yes';
            $proceeded_without_order = 1;

            $get_order_ids = $this->db->select('cr_note_details_id, orderNumber')
                ->where('cr_note_id', $ticket_mains['cr_note_main_id'])
                ->where('cr_note_details.orderNumber !=', '0')
                ->group_by('cr_note_details.orderNumber')
                ->get('cr_note_details')
                ->result();
            if(!empty($get_order_ids)){
                foreach ($get_order_ids as $get_order_id){
                    $orderNumber = $get_order_id->orderNumber;
                    $order_main_data = $this->db->select('orders.*')
                        ->where('orderNumber', $get_order_id->orderNumber)
                        ->get('orders')
                        ->row();

                    $delivery = 0;
                    if($order_main_data){
                            $OrderShippingAmount = ($order_main_data->OrderShippingAmount);
                            if( ($order_main_data->OrderDeliveryCourier == 'DPD') && ($order_main_data->OrderDeliveryCourierCustomer == 'Fedex') ){
                                $OrderShippingAmount = (($order_main_data->OrderShippingAmount)+1);
                            }
                            else if( ($order_main_data->OrderDeliveryCourier == 'Fedex') && ($order_main_data->OrderDeliveryCourierCustomer == 'DPD') ){
                                $OrderShippingAmount = (($order_main_data->OrderShippingAmount)-1);
                            }
                            else
                            {
                                $OrderShippingAmount = ($order_main_data->OrderShippingAmount);
                            }
                            $delivery = number_format(($OrderShippingAmount / vat_rate) * $order_main_data->exchange_rate, 2, '.', '');
                            $delivery_charges+=$delivery;

                    }
                }
                $proceeded_without_order = 0;
            }else{
                $proceeded_without_order = 1;
            }

            //print_r($proceeded_without_order); exit;


            /* NOTE :- All the orders of a ticket will have the same VAT */
            if($proceeded_without_order == 0){
                $get_vat = $this->db->select('vat_exempt')->where('orderNumber', $orderNumber)->get('orders');
                if($get_vat->num_rows() > 0){
                    $vat_exempt = $get_vat->row()->vat_exempt;
                }
            }


        }else{
            $customerDetails = array();
            $operatorNotes = array();
            $email_logs = array();

        }











        //print_r($delivery_charges); exit;






        /*echo '<pre>';
        print_r($email_logs); exit;*/
        $res = array(
            "ticketMains"=>$ticket_mains,
            "ticketDetails"=>$ticket_details,
            'customerDetails'=>$customerDetails,
            'operatorNotes'=>$operatorNotes,
            'email_logs'=>$email_logs,
            'delivery_charges'=>$delivery_charges,
            'proceeded_without_order'=>$proceeded_without_order,
            'vat_exempt' => $vat_exempt
        );
        return $res;
    }


    function fetchTicketDetailsPrint($id){

        $query = $this->db->select('
        cr_notes.cr_note_id as cr_note_main_id, cr_notes.ticketSrNo, cr_notes.UserID,
        cr_notes.ticketStatus, cr_notes.create_date,
        cr_notes.created_by, cr_notes.cr_note_status, cr_notes.approved_by,
        cr_notes.BillingCompanyName,
        cr_notes.BillingFirstName, cr_notes.BillingLastName,
        cr_notes.BillingPostcode, cr_notes.BillingCountry, cr_notes.BillingEmail, cr_notes.BillingTelephone,
        CONCAT(cr_notes.BillingFirstName," ",cr_notes.BillingLastName) AS Name,
        cr_notes.BillingAddress1, cr_notes.BillingAddress2, cr_notes.BillingTownCity,
        cr_notes.DeliveryCompanyName,
        cr_notes.DeliveryFirstName, cr_notes.DeliveryLastName,
        cr_notes.DeliveryPostcode, cr_notes.DeliveryCountry, cr_notes.Deliveryemail, cr_notes.Deliverytelephone,
        CONCAT(cr_notes.DeliveryFirstName," ",cr_notes.DeliveryLastName) AS Name,
        cr_notes.DeliveryAddress1, cr_notes.DeliveryAddress2, cr_notes.DeliveryTownCity
        ')
            //->join('customers', 'customers.UserID = cr_notes.UserID')
            ->where('cr_notes.cr_note_id', $id)
            ->group_by('cr_notes.cr_note_id')
            ->get('cr_notes');
        $ticket_mains = $query->row_array();


        $delivery_charges = 0;
        $get_order_ids = $this->db->select('cr_note_details_id, orderNumber')
            ->where('cr_note_id', $ticket_mains['cr_note_main_id'])
            ->where('cr_note_details.orderNumber !=', '0')
            ->group_by('cr_note_details.orderNumber')
            ->get('cr_note_details')
            ->result();

        $lang = 'en';
        //print_r(count($get_order_ids)); exit;

        if(!empty($get_order_ids)){
            foreach ($get_order_ids as $get_order_id){
                $orderNumber = $get_order_id->orderNumber;
                $order_main_data = $this->db->select('orders.*')
                    ->where('orderNumber', $get_order_id->orderNumber)
                    ->get('orders')
                    ->row();

                $delivery = 0;
                if($order_main_data){
                    if($order_main_data->site){
                        $lang = ($order_main_data->site=="" || $order_main_data->site=="en")?"en":"fr";
                    }else{
                        $lang = 'en';
                    }

                        $OrderShippingAmount = ($order_main_data->OrderShippingAmount);
                        if( ($order_main_data->OrderDeliveryCourier == 'DPD') && ($order_main_data->OrderDeliveryCourierCustomer == 'Fedex') ){
                            $OrderShippingAmount = (($order_main_data->OrderShippingAmount)+1);
                        }
                        else if( ($order_main_data->OrderDeliveryCourier == 'Fedex') && ($order_main_data->OrderDeliveryCourierCustomer == 'DPD') ){
                            $OrderShippingAmount = (($order_main_data->OrderShippingAmount)-1);
                        }
                        else
                        {
                            $OrderShippingAmount = ($order_main_data->OrderShippingAmount);
                        }
                        $delivery = number_format(($OrderShippingAmount / vat_rate) * $order_main_data->exchange_rate, 2, '.', '');
                        $delivery_charges+=$delivery;

                }
            }
            $proceeded_without_order = 0;
        }else{
            $proceeded_without_order = 1;
        }



        $query = $this->db->select('
        cr_note_details.cr_note_id, cr_note_details.cr_note_details_id, cr_note_details.returnQty,
        cr_note_details.returnPrice, cr_note_details.returnUnitPrice, cr_note_details.returnCurrency,
        cr_note_details.productDescription, cr_note_details.productDescriptionPrint,
        cr_note_details.returnQtyPrint, cr_note_details.returnPricePrint,
        p.ProductBrand, p.ProductCategoryName, p.Adhesive,
        od.*
        ')
            ->join('products as p', 'p.ProductID = cr_note_details.ProductID', 'left')
            ->join('orderdetails as od', 'od.SerialNumber = cr_note_details.serialNumber', 'left')
            ->where('cr_note_details.cr_note_id', $id)
            ->group_by('cr_note_details.cr_note_details_id')
            ->get('cr_note_details');
        $ticket_details = $query->result_array();



        if($ticket_mains){
            $customer = "concat(customers.BillingFirstName,' ',customers.BillingLastName) as Name, customers.UserID, customers.BillingPostcode,
        customers.BillingCountry,customers.BillingTelephone,customers.UserEmail,concat(customers.BillingAddress1,',', customers.BillingPostcode) as address
        ";
            $this->db->select($customer);
            $this->db->where('UserID', $ticket_mains['UserID']);
            $customerDetails = $this->db->get('customers')->row_array();

            $notes = $this->db->select('n.additional_note_id, n.operator_note, n.created_at, c.UserName')
                ->join('customers as c', 'c.UserID = n.created_by')
                ->where('n.cr_note_id', $id)
                ->get('operator_additional_notes as n');
            $operatorNotes = $notes->result_array();
        }else{
            $customerDetails = array();
            $operatorNotes = array();
        }

        $vat_exempt = 'yes';
        if($proceeded_without_order == 0){
            $get_vat = $this->db->select('vat_exempt')->where('orderNumber', $orderNumber)->get('orders');
            if($get_vat->num_rows() > 0){
                $vat_exempt = $get_vat->row()->vat_exempt;
            }
        }

        /*echo '<pre>';
        print_r($ticket_mains); exit;*/
        $res = array(
            "ticketMains"=>$ticket_mains,
            "ticketDetails"=>$ticket_details,
            'customerDetails'=>$customerDetails,
            'operatorNotes'=>$operatorNotes,
            'delivery_charges'=>$delivery_charges,
            'proceeded_without_order'=>$proceeded_without_order,
            'vat_exempt' => $vat_exempt,
            'language' => $lang
        );
        return $res;
    }




    function fetchTicketDetailsCsv($to,$from,$format,$status,$areaResponsible){
        //print_r($format); exit;
        $this->db->select('
        cr_notes.ticketSrNo as Credit Note No,
        (SELECT GROUP_CONCAT(DISTINCT orderNumber) as f FROM `cr_note_details` where cr_notes.cr_note_id = 	cr_note_details.cr_note_id) as Reference,
        (SELECT GROUP_CONCAT(DISTINCT products.ProductBrand) as f FROM `cr_note_details` 
            inner join orderdetails on orderdetails.SerialNumber=cr_note_details.serialNumber 
            inner join products on products.ProductID = orderdetails.ProductID 
            where cr_note_id = cr_notes.cr_note_id and orderdetails.ProductID > 0) as Format,
            
            (select concat(CAST(CONVERT((CASE 
			WHEN (cr_note_details.returnCurrency = "GBP") THEN "£" 
			WHEN (cr_note_details.returnCurrency = "EUR") THEN "€" 
			WHEN (cr_note_details.returnCurrency = "USD") THEN "$" 
			END) USING utf8) AS binary),"",
			ROUND(sum(cr_note_details.returnUnitPrice + cr_note_details.returnPricePrint) + (cr_notes.total_vat + cr_notes.total_delivery),2)) as total_amount from cr_note_details where cr_note_details.cr_note_id=cr_notes.cr_note_id
			) as Amount
			
        ,
        (select CONCAT(customers.BillingFirstName," ", customers.BillingLastName) as Name from customers  where customers.UserId=cr_notes.UserID) as Customer,
        customers.BillingTelephone as Phone,
        (select UserName from customers  where customers.UserId=cr_notes.created_by) as Operator,
        concat(DATE_FORMAT(cr_notes.create_date, "%d/%m/%Y")) as Date,
        (CASE 
			WHEN (cr_notes.cr_note_status = "0") THEN "Waiting for Approval" 
			WHEN (cr_notes.cr_note_status = "1") THEN "Approved and Credit Note Generated" 
			WHEN (cr_notes.cr_note_status = "2") THEN "Declined" 
			WHEN (cr_notes.cr_note_status = "3") THEN "Sent"
			END
        ) as Status
        ');
        $this->db->join('cr_note_details', 'cr_note_details.cr_note_id = cr_notes.cr_note_id');
        $this->db->join('customers', 'customers.UserID = cr_notes.UserID');
        if($from!=''){
            $this->db->where('DATE(cr_notes.create_date) >= "'.$from.'"');
        }
        if($to!=''){
            $this->db->where('DATE(cr_notes.create_date) <= "'.$to.'"');
        }
        if($status!=''){
            $this->db->where('cr_notes.cr_note_status', $status);
        }
        if($format!=''){
            $this->db->join('orderdetails as od','od.SerialNumber=cr_note_details.SerialNumber');
            $this->db->join('products as p','p.ManufactureID=od.ManufactureID');
            $this->db->where('p.ProductBrand',$format);
        }
        $this->db->group_by('cr_notes.cr_note_id');
        $this->db->order_by('cr_notes.cr_note_id', 'DESC');
        //$this->db->where('cr_note_details.orderNumber !=', 0);
        $this->db->from('cr_notes');
        $query = $this->db->get();

        /*echo '<pre>';
        print_r($query->result());
        exit;*/

        /*$this->db->select('
        cr_notes.ticketSrNo as Credit Note No, cr_notes.UserID,
        cr_notes.ticketStatus, cr_notes.create_date,
        cr_notes.created_by, cr_notes.cr_note_status, cr_notes.approved_by,
        cr_notes.BillingCompanyName,
        cr_notes.BillingFirstName, cr_notes.BillingLastName,
        cr_notes.BillingPostcode, cr_notes.BillingCountry, cr_notes.BillingEmail, cr_notes.BillingTelephone,
        CONCAT(cr_notes.BillingFirstName," ",cr_notes.BillingLastName) AS Name,
        cr_notes.BillingAddress1, cr_notes.BillingAddress2, cr_notes.BillingTownCity,
        cr_notes.DeliveryCompanyName,
        cr_notes.DeliveryFirstName, cr_notes.DeliveryLastName,
        cr_notes.DeliveryPostcode, cr_notes.DeliveryCountry, cr_notes.Deliveryemail, cr_notes.Deliverytelephone,
        CONCAT(cr_notes.DeliveryFirstName," ",cr_notes.DeliveryLastName) AS Name,
        cr_notes.DeliveryAddress1, cr_notes.DeliveryAddress2, cr_notes.DeliveryTownCity
        ');
        if($to!='' && $from!=''){
            $this->db->where('DATE(cr_notes.create_date) BETWEEN "'.$to.'" AND "'.$from.'"');
        }
		if($status!='' && $status != 'all'){
            $this->db->where('cr_notes.cr_note_status',$status);
        }
        $this->db->group_by('cr_notes.cr_note_id');
        $this->db->from('cr_notes');
        $query = $this->db->get();*/
        return $query;
    }
    function getCustomerDetails($id){

        $TicketDetails =  $this->getTicketDetails($id);
        $Order_Number = $TicketDetails[0]['orderNumber'];
        //print_r($Order_Number); exit;

        $Row = $this->getOrderNumberRow($Order_Number);
        return $Row;
    }

    function getCustomerDetailByID($UserID){

        $q = $this->db->select('customers.*')
            ->where('UserID', $UserID)
            ->get('customers');
        return $q->row_array();
    }
    function getTicket($id){

        $query = "select * from cr_notes as t where t.cr_note_id='".$id."'";
        return $this->db->query($query)->result_array();
    }
    /*function getTicketDetails($id){

        $query = "select sc.ID as 	Country_id,od.SerialNumber,od.Printing,od.Print_Type,od.LabelsPerRoll,od.FinishType,od.UserID,od.OrderNumber,o.BillingFirstName, o.BillingLastName, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, o.BillingPostcode, o.BillingCountry, od.ManufactureID, od.ProductName, od.Quantity,od.Price, od.ProductTotal,o.Billingtelephone,o.Billingemail,concat(o.BillingAddress1,',', o.BillingPostcode) as address,o.currency,td.* from cr_note_details as td
     inner join orders as o on  o.OrderNumber=td.orderNumber
     left join shippingcountries as sc on sc.name=o.DeliveryCountry
     inner join orderdetails as od on od.SerialNumber=td.SerialNumber
     where td.cr_note_id='".$id."'";
        return $this->db->query($query)->result_array();
    }
    function getOrderNumberRow($serialNumber){
        $query = "select o.OrderNumber,o.Billingemail,o.Billingtelephone, concat(o.BillingFirstName,' ',o.BillingLastName) as Name, concat(o.BillingAddress1,',', o.BillingPostcode) as address from orders as o inner join customers as c on c.UserID=o.UserID where o.OrderNumber='".$serialNumber."'";
        return $this->db->query($query)->result_array();
    }*/

    function addOperatorAdditionalNote($note_data, $cr_note_id){
        $this->db->set('updateStatus', 1)
            ->where('cr_note_id', $cr_note_id)
            ->update('cr_notes');

        $dat = $this->db->insert('operator_additional_notes',$note_data);
        $notes = $this->db->select('n.additional_note_id, n.operator_note, n.created_at, c.UserName, c.UserTypeID')
            ->join('customers as c', 'c.UserID = n.created_by')
            ->where('n.additional_note_id', $this->db->insert_id())
            ->get('operator_additional_notes as n');
        return $latestNote = $notes->row();
    }

    function addOperatorAdditionalNoteBeforeSave($note_data){
        $dat = $this->db->insert('operator_additional_notes',$note_data);
        $notes = $this->db->select('customers.UserName')
            ->where('customers.UserID', $this->session->userdata('UserID'))
            ->get('operator_additional_notes as n');
        return $latestNote = $notes->row();
    }
    function createTicket($order_details_data,$ticket_main_data,$operator_additional_notes_data){

        $UserID = $this->session->userdata('UserID');
        $order_details_data = json_decode($order_details_data,true);

        /*$is_exceeds = 0;
        $exceed = array();
        foreach($order_details_data as $key => $ord){
            if($ord["orderNumber"]){
                $chk_if_qty_exceeds = $this->db->select('orderdetails.SerialNumber')
                    ->where('OrderNumber', $ord["orderNumber"])
                    ->where('ManufactureID', $ord['ManufactureID'])
                    ->where('Quantity >=', $ord["qty"])
                    ->get('orderdetails');

                if($chk_if_qty_exceeds->num_rows() > 0){
                    $exceed[$key]['cr_note_details_id'] = $ord['cr_note_details_id'];
                    $exceed[$key]['exceeding'] = 0;
                }else{
                    $exceed[$key]['cr_note_details_id'] = $ord['cr_note_details_id'];
                    $exceed[$key]['exceeding'] = 1;
                    $is_exceeds = 1;
                }
            }
        }*/



        $this->db->insert('cr_notes',$ticket_main_data);
        $tick_id= $this->db->insert_id();
        $ticketSrNo = str_pad($tick_id,4,"0", STR_PAD_LEFT);

        $this->db->set('ticketSrNo', $ticketSrNo);
        $this->db->where('cr_note_id', $tick_id);
        $this->db->update('cr_notes');




        $order_details = array();
        foreach($order_details_data as $key => $ord){
            $order_details[] = array(
                'cr_note_id' => $tick_id,
                'orderNumber' => (isset($ord["orderNumber"]))?$ord["orderNumber"]:0,
                'serialNumber' => (isset($ord["SerialNumber"]))?$ord["SerialNumber"]:0,
                'returnQty' => $ord["qty"],
                'returnUnitPrice' => $ord["unitPrice"],
                'returnPrice' => $ord["TotalPrice"],
                'returnCurrency' => $ord["currency"],
                'productDescription' => $ord["productDescription"],
                'ManufactureID' => $ord["ManufactureID"],
                'ProductID' => $ord["ProductID"],
                'Printing' => (isset($ord["Printing"]))?$ord["Printing"]:'N',
                'returnQtyPrint' => (isset($ord["returnQtyPrint"]))?$ord["returnQtyPrint"]:0,
                'returnPricePrint' => (isset($ord["TotalPricePrint"]))?$ord["TotalPricePrint"]:0,
                'productDescriptionPrint' => (isset($ord["productDescriptionPrint"]))?$ord["productDescriptionPrint"]:'',
            );
        }
        $this->db->insert_batch('cr_note_details',$order_details);


        $operator_additional_notes_data = json_decode($operator_additional_notes_data,true);

        $note = array();
        foreach ($operator_additional_notes_data as $operator_additional_note){
            $note[] = array(
                'cr_note_id' => $tick_id,
                'created_by' => $UserID,
                'operator_note' => $operator_additional_note,
                'created_at' => date('Y-m-d H:i:s'),
                'is_updated' => 0
            );

        }
        if($note){
            $this->db->insert_batch('operator_additional_notes', $note);
        }
        return true;
    }


    function ticketApproveDecline($action_type, $cr_note_id){
        $this->db->set('updateStatus', 1)
            ->where('cr_note_id', $cr_note_id)
            ->update('cr_notes');

        $this->db->where('cr_note_id', $cr_note_id);
        $this->db->set('cr_note_status', $action_type);
        $this->db->update('cr_notes');
        return $this->db->affected_rows();
    }


    function updateTicket($ticket_details_data, $cr_note_id, $total_delivery, $total_vat){
        $this->db->set('updateStatus', 1)
            ->set('total_delivery', $total_delivery)
            ->set('total_vat', $total_vat)
            ->where('cr_note_id', $cr_note_id)
            ->update('cr_notes');

        $ticket_details_add = array();
        $qty_exceeds = 0;
        $exceed = array();

        foreach($ticket_details_data as $key => $ord){
            if($ord['cr_note_details_id'] == 0){
                $ticket_details_add[] = array(
                    'cr_note_id' => $cr_note_id,
                    'orderNumber' => ($ord["orderNumber"])?$ord["orderNumber"]:0,
                    'serialNumber' => ($ord["SerialNumber"])?$ord["SerialNumber"]:0,
                    'returnQty' => $ord["returnQty"],
                    'returnUnitPrice' => $ord["returnUnitPrice"],
                    'returnPrice' => $ord["returnPrice"],
                    'returnCurrency' => $ord["currency"],
                    'productDescription' => $ord["productDescription"],
                    'Printing' => (isset($ord["Printing"]))?$ord["Printing"]:'N',
                    'returnQtyPrint' => (isset($ord["returnQtyPrint"]))?$ord["returnQtyPrint"]:0,
                    'returnPricePrint' => (isset($ord["TotalPricePrint"]))?$ord["TotalPricePrint"]:0,
                    'productDescriptionPrint' => (isset($ord["productDescriptionPrint"]))?$ord["productDescriptionPrint"]:'',
                );
            }else{
                if($ord["orderNumber"]){
                    $chk_if_qty_exceeds = $this->db->select('orderdetails.SerialNumber')
                        ->where('OrderNumber', $ord["orderNumber"])
                        ->where('ManufactureID', $ord['ManufactureID'])
                        ->where('Quantity >=', $ord["returnQty"])
                        ->get('orderdetails');

                    if($chk_if_qty_exceeds->num_rows() > 0){
                        $ticket_details_update = array(
                            'returnQty' => $ord["returnQty"],
                            'returnUnitPrice' => $ord["returnUnitPrice"],
                            'returnPrice' => (isset($ord["returnPrice"]))?$ord["returnPrice"]:0,
                            'returnQtyPrint' => (isset($ord["returnQtyPrint"]))?$ord["returnQtyPrint"]:0,
                            'returnPricePrint' => (isset($ord["TotalPricePrint"]))?$ord["TotalPricePrint"]:0
                        );
                        $this->db->where('cr_note_details_id',$ord['cr_note_details_id']);
                        $this->db->update('cr_note_details',$ticket_details_update);
                    }else{
                        $exceed[$key] = $ord['cr_note_details_id'];
                        $qty_exceeds = -1;
                    }
                }else{
                    $ticket_details_update = array(
                        'returnQty' => $ord["returnQty"],
                        'returnUnitPrice' => $ord["returnUnitPrice"],
                        'returnPrice' => (isset($ord["returnPrice"]))?$ord["returnPrice"]:0
                    );
                    $this->db->where('cr_note_details_id',$ord['cr_note_details_id']);
                    $this->db->update('cr_note_details',$ticket_details_update);
                }
            }
        }
        if($ticket_details_add){
            $this->db->insert_batch('cr_note_details',$ticket_details_add);
        }

        return $exceed;
    }

    function getCreditNoteStatus($cr_note_id){
        $val = $this->db->select('cr_note_status')
            ->where('cr_note_id', $cr_note_id)
            ->get('cr_notes')
            ->row();
        if($val){
            return $val->cr_note_status;
        }else{
            return -1;
        }
    }
    function chkExceedingValues($ticket_details_data, $cr_note_id){
        $ticket_details_data = json_decode($ticket_details_data,true);
        $ticket_details_add = array();
        $is_exceeds = 0;
        $exceed = array();
        foreach($ticket_details_data as $key => $ord){
            if($ord["orderNumber"]){
                $chk_if_qty_exceeds = $this->db->select('orderdetails.SerialNumber')
                    ->where('OrderNumber', $ord["orderNumber"])
                    ->where('ManufactureID', $ord['ManufactureID'])
                    ->where('Quantity >=', $ord["returnQty"])
                    ->get('orderdetails');

                if($chk_if_qty_exceeds->num_rows() > 0){
                    $exceed[$key]['cr_note_details_id'] = $ord['cr_note_details_id'];
                    $exceed[$key]['exceeding'] = 0;
                }else{
                    $exceed[$key]['cr_note_details_id'] = $ord['cr_note_details_id'];
                    $exceed[$key]['exceeding'] = 1;
                    $is_exceeds = 1;
                }
            }
        }
        if($is_exceeds == 1){
            return $exceed;
        }else{
            return $exceed = array();
        }

    }

    function checkMaxQty($SerialNumber){
        //print_r($ManufactureID); exit;
        $order_qty = 0;
        if($SerialNumber){
            $chk_if_qty_exceeds = $this->db->select('orderdetails.Quantity, orderdetails.Print_Qty')
                ->where('SerialNumber', $SerialNumber)
                ->get('orderdetails');
            if($chk_if_qty_exceeds->num_rows() > 0){
                $order_qty = $chk_if_qty_exceeds->row();
            }
        }
        return $order_qty;
    }

    function checkMaxPrice($SerialNumber){
        $order_price = 0;
        if($SerialNumber){
            $chk_if_price_exceeds = $this->db->select('orderdetails.Price, orders.exchange_rate, orderdetails.Print_Total')
                ->join('orders', 'orders.OrderNumber = orderdetails.OrderNumber')
                ->where('orderdetails.SerialNumber', $SerialNumber)
                ->get('orderdetails');
            if($chk_if_price_exceeds->num_rows() > 0){
                $order_price = $chk_if_price_exceeds->row();
            }
        }
        return $order_price;
    }


    function calculateGTPrice($ticket_details_data, $cr_note_id){
        $ticket_details_data = json_decode($ticket_details_data,true);
        $ticket_details_add = array();
        $is_exceeds = 0;
        $exceed = array();
        foreach($ticket_details_data as $key => $ord){
            if($ord["orderNumber"]){
                /*if($ord['Printing'] == 'Y'){

                }*/
                $chk_if_qty_exceeds = $this->db->select('orderdetails.SerialNumber')
                    ->join('orders', 'orders.OrderNumber = orderdetails.OrderNumber')
                    ->where('orderdetails.OrderNumber', $ord["orderNumber"])
                    ->where('ManufactureID', $ord['ManufactureID'])
                    ->where('(Price*orders.exchange_rate) >', $ord["returnUnitPrice"])
                    ->get('orderdetails');

                if($chk_if_qty_exceeds->num_rows() > 0){
                    $exceed[$key]['cr_note_details_id'] = $ord['cr_note_details_id'];
                    $exceed[$key]['exceeding'] = 0;
                }else{
                    $exceed[$key]['cr_note_details_id'] = $ord['cr_note_details_id'];
                    $exceed[$key]['exceeding'] = 1;
                    $is_exceeds = 1;
                }
            }
        }
        if($is_exceeds == 1){
            return $exceed;
        }else{
            return $exceed = array();
        }
    }


    function getTicketNo(){
        $q = "select lpad(max(cr_note_id)+1,4,'0') as cr_note_idss from cr_notes";
        $res = $this->db->query($q)->result_array();
        return $res[0]['cr_note_idss'];
    }



    function fetch_tickets_order($cr_note_id){
        $query = "select td.*,o.currency,o.OrderNumber,o.BillingFirstName,o.BillingLastName,o.BillingCountry from 	cr_note_details as td
		inner join orders as o on td.orderNumber=o.orderNumber
		where cr_note_id = '".$cr_note_id."'";
        return $this->db->query($query)->result();
    }
    function  getAllString($orders_ids){
        $query = "SELECT od.UserID,od.OrderNumber        
		FROM `orders` as o 
     
		 inner join orderdetails as od on od.OrderNumber=o.OrderNumber
		 inner join products as p on p.ProductID=od.ProductID
		 where od.OrderNUmber IN (".$orders_ids.") group by od.OrderNumber";

        return $res = $this->db->query($query)->result_array();
    }

    function findOrders($orders_ids,$for_one,$limit,$start,$col,$dir){
        $query = "SELECT od.SerialNumber,od.Printing,od.Print_Type,od.labels,od.LabelsPerRoll,od.FinishType,od.Price,
od.Wound,od.Orientation,od.FinishType,od.pressproof,
p.ProductBrand,p.ProductID,
od.UserID,od.OrderNumber,
od.Printing,od.regmark,od.Print_Type,od.Print_Qty,od.Print_Total,
cus.BillingFirstName, cus.BillingLastName, concat(cus.BillingFirstName,' ',cus.BillingLastName) as Name, cus.BillingPostcode, cus.BillingCountry, 
od.ManufactureID, od.ProductName, od.Quantity, od.ProductTotal,cus.BillingTelephone,cus.UserEmail as BillingEmail,
concat(cus.BillingAddress1,',', cus.BillingPostcode) as address,
o.currency,o.exchange_rate,o.OrderStatus, 
        
				(select oo.UserID
        				
				
				from `orders` as oo 
        inner join orderdetails as odd on odd.OrderNumber=oo.OrderNumber 
        where (o.OrderStatus=7/* || o.OrderStatus=8*/) && odd.OrderNUmber IN (".$for_one.") limit 1 ) as first 
        
        FROM `orders` as o 
       
        inner join orderdetails as od on od.OrderNumber=o.OrderNumber
        inner join products as p on p.ProductID=od.ProductID
        inner join customers as cus on cus.UserID=o.UserID
        
        where (o.OrderStatus=7/* || o.OrderStatus=8*/) && od.OrderNUmber IN (".$orders_ids.")
        /*limit ".$start.", ".$limit."*/
        ";

        $res = $this->db->query($query)
            ->result_array();




        $delivery_charges = 0;
        $vat_exempt = 'yes';
        $proceeded_without_order = 0;





        $query = "SELECT o.OrderNumber as orderNumber
        
        FROM `orders` as o
       
        where o.OrderNUmber IN (".$orders_ids.")
        group by o.OrderNUmber
        ";

        $get_order_ids = $this->db->query($query)->result();



        if(!empty($get_order_ids)){
            foreach ($get_order_ids as $get_order_id){
                $orderNumber = $get_order_id->orderNumber;
                $order_main_data = $this->db->select('orders.*')
                    ->where('orderNumber', $get_order_id->orderNumber)
                    ->get('orders')
                    ->row();

                $delivery = 0;
                if($order_main_data){
                        $OrderShippingAmount = $order_main_data->OrderShippingAmount;

                        if( ($order_main_data->OrderDeliveryCourier == 'DPD') && ($order_main_data->OrderDeliveryCourierCustomer == 'Fedex') ){
                            $OrderShippingAmount = (($order_main_data->OrderShippingAmount)+1);
                        }
                        else if( ($order_main_data->OrderDeliveryCourier == 'Fedex') && ($order_main_data->OrderDeliveryCourierCustomer == 'DPD') ){
                            $OrderShippingAmount = (($order_main_data->OrderShippingAmount)-1);
                        }
                        else
                        {
                            $OrderShippingAmount = ($order_main_data->OrderShippingAmount);
                        }

                        $delivery = number_format(($OrderShippingAmount / vat_rate) * $order_main_data->exchange_rate, 2, '.', '');
                        $delivery_charges+=$delivery;

                }
            }
            $proceeded_without_order = 0;
        }else{
            $proceeded_without_order = 1;
        }



        /* NOTE :- All the orders of a ticket will have the same VAT */
        if($proceeded_without_order == 0){
            $get_vat = $this->db->select('vat_exempt')->where('orderNumber', $orderNumber)->get('orders');
            if($get_vat->num_rows() > 0){
                $vat_exempt = $get_vat->row()->vat_exempt;
            }
        }
        //print_r('hhh'); exit;
        //print_r($proceeded_without_order); exit;
        //print_r($vat_exempt); exit;

        return array(
            'res' => $res,
            'delivery_charges' => $delivery_charges,
            'proceeded_without_order' => $proceeded_without_order,
            'vat_exempt' => $vat_exempt
        );



        //return $res;
    }


    public function getAllTicketsData(){
        $this->datatables->select('t.cr_note_id')

            ->select('(SELECT GROUP_CONCAT(DISTINCT  orderNumber) as f FROM `cr_note_details` where t.cr_note_id = 	cr_note_details.cr_note_id)')
            ->select('(SELECT GROUP_CONCAT(DISTINCT products.ProductBrand) as f FROM `cr_note_details` inner join orderdetails on    orderdetails.SerialNumber=cr_note_details.serialNumber inner join products on products.ProductID = orderdetails.ProductID where cr_note_id = t.cr_note_id)')
            ->select('concat(DATE_FORMAT(t.create_date, "%d/%m/%Y"))')
            ->select('(select CONCAT(customers.BillingFirstName," ", customers.BillingLastName) as Name from customers  where customers.UserId=t.UserID  )')

            ->select('(select concat(orders.BillingFirstName," ",orders.BillingLastName ,"," ,orders.BillingCountry) as customer from cr_note_details  inner join orders on cr_note_details.orderNumber = orders.OrderNumber where cr_note_details.cr_note_id=t.cr_note_id group by cr_note_details.orderNumber limit 1)')

            ->select('concat(DATE_FORMAT(t.reffDate, "%d/%m/%Y"))')
            ->select('concat(DATE_FORMAT(t.followUpDate, "%d/%m/%Y"))')
            ->select('0')
            ->select('(select concat(cr_note_details.returnCurrency,",",ROUND(sum(cr_note_details.returnUnitPrice),2)) as total_amount from cr_note_details where cr_note_details.cr_note_id=t.cr_note_id  )')
            ->select('t.ticketStatus')
            ->select('t.ticketSrNo')
            ->select('t.updateStatus')
            ->select('concat(DATE_FORMAT(t.closed_date, "%d/%m/%Y"))')

            ->select('(select UserName from customers  where customers.UserId=t.reffTo  )')
            ->select('t.contact_reason')
            ->select('concat(DATE_FORMAT(FROM_UNIXTIME(t.re_received_date), "%d/%m/%Y"))')
            ->select('t.re_notes')
            ->select('t.areaResponsible')
            ->select('t.ac_area_resp_c')

            /*->select('(SELECT
            CONCAT(
            GROUP_CONCAT(
            (CASE
            WHEN (orderdetails.Printing = "Y") THEN "Printed"
            WHEN (orderdetails.Printing = "N") THEN "Plain"
            WHEN (orderdetails.Printing = "") THEN "Plain"
            END)
            )," / ",

                                                    GROUP_CONCAT(
                                                    (CASE
                                                    WHEN (products.ProductBrand = "Roll Labels") THEN "Roll"
                                                    WHEN (products.ProductBrand != "Roll Labels") THEN "Sheet"
                                                    END)
                                                    )
                                                    ) AS CHARs

                                                                        FROM `cr_note_details`
                                                                        inner join orderdetails on  orderdetails.SerialNumber=cr_note_details.SerialNumber
                                                                        inner join products on  products.ProductID=orderdetails.ProductID
                                                                        where cr_note_details.cr_note_id = t.cr_note_id

                                                            ) as "Printed/Plain & Sheet/Roll"')

                        ->select('(SELECT
                        GROUP_CONCAT(DISTINCT REPLACE(products.ManufactureID,substring_index(category.CategoryImage,".",1),"")) as 	col_3
                        FROM `cr_note_details`
                        inner join orderdetails on  orderdetails.SerialNumber=cr_note_details.SerialNumber
                        inner join products on  products.ProductID=orderdetails.ProductID
                        inner join category on  category.CategoryID=products.CategoryID
                        where cr_note_details.cr_note_id = t.cr_note_id

                                                            ) as "Material Code"')*/

            ->from('cr_notes as t');
        echo $this->datatables->generate();
    }

    public function getformats(){
        $q= $this->db->query("SELECT ProductBrand FROM `products` where ProductBrand is not NULL GROUP by ProductBrand")->result_Array();
        return $q;
    }


    public function getReturnReport($to,$from,$format,$status,$areaResponsible){


        $setvalue = 'SET @row_number = 0';
        $this->db->query($setvalue);

        $this->db->select('(@row_number:=@row_number + 1) AS "Log No"')

            ->select('t.ticketSrNo')

            ->select('(SELECT GROUP_CONCAT(DISTINCT  orderNumber) as f FROM `cr_note_details` where t.cr_note_id = cr_note_details.cr_note_id) as "Order Ref"')

            ->select('(SELECT  
			CONCAT(
			GROUP_CONCAT(
			(CASE 
			WHEN (orderdetails.Printing = "Y") THEN "Printed" 
			WHEN (orderdetails.Printing = "N") THEN "Plain" 
			WHEN (orderdetails.Printing = "") THEN "Plain" 
			END)
			)," / ",
      	                  
													GROUP_CONCAT(
													(CASE 
													WHEN (products.ProductBrand = "Roll Labels") THEN "Roll" 
													WHEN (products.ProductBrand != "Roll Labels") THEN "Sheet" 
													END)
													)
													) AS CHARs
                                    
																		FROM `cr_note_details` 
																		inner join orderdetails on  orderdetails.SerialNumber=cr_note_details.SerialNumber
																		inner join products on  products.ProductID=orderdetails.ProductID
																		where cr_note_details.cr_note_id = t.cr_note_id 
                              
															) as "Printed/Plain & Sheet/Roll"')

            ->select('concat(DATE_FORMAT(t.create_date, "%d-%m-%Y") ) as "Date of contact"')

            ->select('(select concat(CAST(CONVERT((CASE 
			WHEN (cr_note_details.returnCurrency = "GBP") THEN "£" 
			WHEN (cr_note_details.returnCurrency = "EUR") THEN "€" 
			WHEN (cr_note_details.returnCurrency = "USD") THEN "$" 
			END) USING utf8) AS binary),"",ROUND(sum(cr_note_details.returnUnitPrice),2)) as total_amount from cr_note_details where cr_note_details.cr_note_id=t.cr_note_id) as "Price (excl VAT)"')

            ->select('(select concat(orders.BillingFirstName," ",orders.BillingLastName ,"," ,orders.BillingCountry) as customer from cr_note_details  inner join orders on cr_note_details.orderNumber = orders.OrderNumber where cr_note_details.cr_note_id=t.cr_note_id group by cr_note_details.orderNumber limit 1) as "Customer Name"')

            ->select('(select orders.BillingCompanyName from cr_note_details  inner join orders on cr_note_details.orderNumber = orders.OrderNumber where cr_note_details.cr_note_id=t.cr_note_id group by cr_note_details.orderNumber limit 1) as "Company Name"')

            ->select('IF(t.contact_reason IS NULL or t.contact_reason = "", "--", t.contact_reason)  as "Reason for contact/return"')

            ->select('(SELECT  
			GROUP_CONCAT(DISTINCT REPLACE(products.ManufactureID,substring_index(category.CategoryImage,".",1),"")) as col_3
                            
                                    
																		FROM `cr_note_details` 
																		inner join orderdetails on  orderdetails.SerialNumber=cr_note_details.SerialNumber
																		inner join products on  products.ProductID=orderdetails.ProductID
																		inner join category on  SUBSTRING_INDEX(products.CategoryID, "R", 1 ) = category.CategoryID
																		where cr_note_details.cr_note_id = t.cr_note_id
                              
															) as "Material Code"')

            ->select('(CASE 
			WHEN (t.ticketStatus = "0") THEN "Open – UnderInvestigation" 
			WHEN (t.ticketStatus = "1") THEN "Open – Awaiting Info from Customer" 
			WHEN (t.ticketStatus = "2") THEN "Open – Reffered for Desicion" 
			WHEN (t.ticketStatus = "3") THEN "Open – Reffered back to Action" 
			WHEN (t.ticketStatus = "4") THEN "Closed" 
			END) as "Status"')


            ->select('IF(t.reffTo IS NULL or t.reffTo = "", "--", UserName)  as "Referred to" ')

            ->select('concat(IF(t.reffDate IS NULL or t.reffDate = "", "--", DATE_FORMAT(t.reffDate, "%d/%m/%Y"))) as "Date referred"')

            ->select('concat( IF(t.re_received_date IS NULL or t.re_received_date = "", "--", DATE_FORMAT(FROM_UNIXTIME(t.re_received_date), "%d/%m/%Y")) ) as "Follow up date"')

            ->select('IF(t.exp_booking_notes IS NULL or t.exp_booking_notes = "", "--", t.exp_booking_notes) as "Notes/Comments"')

            ->select('IF(t.re_notes IS NULL or t.re_notes = "", "--", t.re_notes) as "Outcome & Learning points"')

            ->select('concat( IF(t.closed_date IS NULL or t.closed_date = "", "--", DATE_FORMAT(t.closed_date, "%d-%m-%Y"))          ) as "Completed date"')

            ->select('IF(t.areaResponsible IS NULL or t.areaResponsible = "", "--", t.areaResponsible) as "Area Responsible"')
            ->select('IF(t.ac_area_resp_c IS NULL or t.ac_area_resp_c = "", "--", t.ac_area_resp_c) as "Area Responsible Comments"');



        $this->db->from('cr_notes as t');
        $this->db->join('cr_note_details as td','t.cr_note_id=td.cr_note_id');
        $this->db->join('orderdetails as od','od.SerialNumber=td.SerialNumber');
        $this->db->join('products as p','p.ProductID=od.ProductID');
        $this->db->join('category as c','SUBSTRING_INDEX(p.CategoryID, "R", 1 )=c.CategoryID');
        $this->db->join('customers as cust','cust.UserId=t.reffTo','left');

        if($to!='' && $from!=''){
            $this->db->where('DATE(t.create_date) BETWEEN "'.$to.'" AND "'.$from.'"');
        }

        if($format!='' && $format!='all'){
            $this->db->where('p.ProductBrand',$format);
        }

        if($status!='' && $status != 'all'){
            $this->db->where('t.ticketStatus',$status);
        }

        if($areaResponsible!='' && $areaResponsible!='all'){

            $where = "FIND_IN_SET('".$areaResponsible."', t.areaResponsible)";
            $this->db->where($where);
        }

        $this->db->group_by('t.cr_note_id');
        //$this->db->where('t.cr_note_id','123');
        //$this->db->limit(1);
        //$res= $this->db->get()->result_array();
        //echo '<pre>'; print_r($res); echo '</pre>';  exit;
        $res= $this->db->get();
        // echo $this->db->last_query();exit;
        return $res;
    }

    public function fetch_ticket_comments($tid){
        $this->db->limit(1);
        $res = $this->db->get_where('cr_notes',array('cr_note_id'=>$tid))->result_Array();
        return $res;
    }



    public function emailCreditNote($cr_note_id, $mailsubject, $mailbody){

        $query = $this->db->select('
        cr_notes.BillingEmail,
        cr_notes.BillingCountry,
        cr_notes.UserID
        ')
            ->where('cr_notes.cr_note_id', $cr_note_id)
            ->group_by('cr_notes.cr_note_id')
            ->get('cr_notes');
        $ticket_mains = $query->row_array();


        $order_main_data = $this->db->select('orders.site')
            ->join('cr_note_details', 'cr_note_details.orderNumber = orders.OrderNumber')
            ->where('cr_note_details.cr_note_id', $cr_note_id)
            ->where('cr_note_details.orderNumber !=', 0)
            ->get('orders')
            ->row();

        $language = 'en';
        if($order_main_data){
            if($order_main_data->site){
                $language = ($order_main_data->site=="" || $order_main_data->site=="en")?"en":"fr";
            }else{
                $language = 'en';
            }
        }



        /*$language = 'en';
        if($ticket_mains){
            if($ticket_mains['BillingCountry'] == 'France'){
                $language="fr";
            }
        }*/


        $output_dir = "theme/assets/pdf/credit_notes";
        $file_location = $output_dir."/credit-note_".$cr_note_id.".pdf";
        if(!file_exists($file_location)){
            //$language="en";
            $page = ($language=="en")?"credit/en/credit_note_pdf.php":"credit/fr/credit_note_pdf.php";

            $data = $this->CreditNoteModel->fetchTicketDetailsPrint($cr_note_id);
            $this->load->library('pdf');
            $this->pdf->load_view($page,$data,TRUE);
            $this->pdf->render();
            $output = $this->pdf->output();

            if (!file_exists($output_dir)) {
                mkdir($output_dir, 0777, true);
            }
            $filename = $file_location;
            fopen($filename, "a");
            file_put_contents($file_location,$output);
        }





        /*if($email_subject){
            $mailsubject = $email_subject;
        }else{
            $mailsubject = ($language=="en")?"Credit Note No  :".$cr_note_id:"Note de crédit:".$cr_note_id;
        }*/


        /*$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'your-mail@gmail.com',
            'smtp_pass' => 'your-password',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );*/

        $file_location = $output_dir."/credit-note_".$cr_note_id.".pdf";
        $mailto = $ticket_mains['BillingEmail'];
        //$mailto = 'abdulrehman8391@gmail.com';
        $this->load->library('email', array("mailtype"=>'html'));
        $this->email->set_newline("\r\n");
        //$this->email->initialize($config);
        //$this->email->initialize(array( 'mailtype' => 'html'));
        $this->email->subject($mailsubject);
        $this->email->from('customercare@aalabels.com','AALABELS');
        $this->email->to($mailto);
        $this->email->message($mailbody);
        $this->email->attach($file_location);
        if($this->email->send()){
            $this->db->where('cr_note_id', $cr_note_id);
            $this->db->set('cr_note_status', 3); // 3 for sent
            $this->db->update('cr_notes');

            $log_array = array(
                'cr_note_id' => $cr_note_id,
                'sent_by' => $this->session->userdata('UserID'),
                'sent_to' => $ticket_mains['UserID'],
                'receiver_email' => $mailto,
                'sent_at' => date("Y-m-d H:i:s")
            );
            $this->db->insert('credit_email_logs', $log_array);
            unlink($file_location);
            return true;
        }
        return false;
    }


    function min_qty_integrated($menuid){
        $query =   $this->db->query("select MIN(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 
		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");
        $row = $query->row_array();
        return $row['qty'];
    }
    function max_qty_integrated($menuid){
        $query =   $this->db->query("select MAX(batch.BatchQty) as qty from tbl_product_batchprice tbl,tbl_batch batch 
		where tbl.ManufactureID='$menuid' and tbl.BatchID= batch.BatchID");
        $row = $query->row_array();
        return $row['qty'];
    }
    function calulate_min_rolls($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MIN(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }

    function calulate_max_rolls($manufature1){
        $manufature = substr($manufature1,0,-1);
        $roll = $this->db->query("SELECT MAX(Rolls) AS Rolls FROM `tbl_batch_roll` WHERE ManufactureID LIKE '".$manufature."' AND Active LIKE 'Y'");
        $roll = $roll->row_array();
        return  $roll['Rolls'];
    }
    function calculate_integrated_qty($manufature,$qty){
        $result = $this->integrated_batch_qty($manufature);
        $sheets='';
        foreach($result as $key => $row){
            if($qty == $row->BatchQty){
                $sheets = $row->BatchQty;
            }
            else if(($qty > $row->BatchQty and isset($result[$key+1]->BatchQty) and $qty < $result[$key+1]->BatchQty)){
                //$sheets = $row->BatchQty;
                $sheets = $result[$key+1]->BatchQty;
            }
        }

        if($sheets==''){   $sheets =  $this->min_qty_integrated($manufature); }
        return $sheets;
    }
    function single_box_price($menuid,$qty,$batch = 250){

        $return = array();
        $qurey = $this->db->query("SELECT Distinct(`Sheets`) FROM `integrated_labels_prices` where ManufactureID ='$menuid'  ORDER BY sheets ASC");
        $result = $qurey->result();
        $user_qty = $qty;
        foreach($result as $key => $row){
            if($qty<=249){
                $qty = $row->Sheets;
            }
            else if($qty == $row->Sheets){
                $qty = $row->Sheets;
            }
            else if(($qty > $row->Sheets and isset($result[$key+1]->Sheets) and $qty < $result[$key+1]->Sheets)){
                $qty = $row->Sheets;
            }
            else if($qty>100000){
                $qty = 100000;
            }
        }
        $cond = '';
        $query = $this->db->query("select *,Price_$batch as PlainPrice, Box_$batch as Box from integrated_labels_prices where ManufactureID ='$menuid' and Sheets = '$qty'");

        $return = $query->row_array();
        //$delivery_charges = $this->get_integrated_delivery($qty);
        //$return = array_merge($delivery_charges,$return);
        return $return;
    }

    function get_price($Productbrand,$ManufactureID,$Quantity,$batch,$labels,$Print_Type,$FinishType,$Printing,$SerialNumber){

        if(preg_match("/Integrated Labels/i",$Productbrand)){

            $newqty = $this->calculate_integrated_qty($ManufactureID,$Quantity);
            $price = $this->single_box_price($ManufactureID,$newqty,$batch);
            $total = $price['PlainPrice'];

            if($Quantity != $price['Sheets']) {
                $perbox = $price['PlainPrice']/$price['Box'];
                $acc_boxes = $Quantity/$batch;
                $calculated_price = $acc_boxes*$perbox;
                $price['PlainPrice'] = $calculated_price;
                $total = $price['PlainPrice'];
            }

            $unitPrice = $total/$Quantity;
            $UnitPrice = number_format(round($unitPrice,2),2,'.','');

            $vat = round(($total*20)/100,2);
            $vat = $vat + $total;
            $arr = array('UnitPrice'=>$total,'TotalPrice'=>$vat);
            echo json_encode($arr);
        }
        else{
            echo  $status = $this->UpdateItem($SerialNumber,$Productbrand,$ManufactureID,$Quantity,$Printing,$labels,$Print_Type,$FinishType);
        }
    }

    public function UpdateItem($ID,$ProductBrand,$ManufactureID,$qty,$printing,$labels,$Print_Type,$FinishType){
        //$ProductBrand = $this->ProductBrand($ManufactureID);
        //$printing = $this->input->post('printing');

        if(preg_match('/Roll Labels/is',$ProductBrand) && $printing=="Y"){

            $labels = $labels * $qty;
            $finish = $FinishType;
            $press  = 1;
            $min_qty = $this->get_roll_qty($ManufactureID);

            if($press== 'true'){$press=1;}else{$press=0;}

            $prid = $this->db->query("select LabelsPerSheet from products WHERE `ManufactureID` LIKE '".$ManufactureID."'")->row_array();

            $response = $this->rolls_calculation($min_qty,$prid['LabelsPerSheet'],$labels,'');
            //print_r($response); echo '<br>';

            $collection['labels'] 	= $response['total_labels'];
            $collection['manufature'] = $ManufactureID;
            $collection['finish']     = $finish;
            $collection['rolls']      = $response['rolls'];
            $collection['printing']   = $Print_Type;


            //print_r($collection); echo '<br>';

            $price_res = $this->calculate_printing_price($collection);
            $custom_price = $price_res['final_price'];

            if($press==1){
                $custom_price = $custom_price + 50.00;
            }

            if($qty>$response['rolls']){
                $add_rolls = $qty - $response['rolls'];
                $additional_cost = $this->additional_charges_rolls($add_rolls);
                $custom_price = $custom_price + $additional_cost; //echo '<br>';
            }

            $labels = $response['total_labels'];

            if($qty<$response['rolls']){
                $qty = $response['rolls'];
            }

            if($response['total_labels'] != $response['actual_labels']){
                $labels = $response['total_labels'];
            }

            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.',''); //echo '<br>';

            $ExVat = round($custom_price,2);
            $IncVat = round($custom_price * vat_rate,2);
            //$data['Price'] = $ExVat;
            //$data['ProductTotalVAT'] = $ExVat;
            //$data['ProductTotal'] = $IncVat;

            $data = array('UnitPrice'=>$ExVat,'TotalPrice'=>$IncVat,'sd'=>$qty);


        }else if(preg_match('/Roll Labels/is',$ProductBrand) ){

            $linedetails = $this->db->query("select * from orderdetails where SerialNumber = $ID")->row_array();

            $prid = $this->db->query("select LabelsPerSheet from products WHERE `ManufactureID` LIKE '".$ManufactureID."'")->row_array();
            $lpr = (isset($linedetails['is_custom']) && $linedetails['is_custom']=="Yes")?	$linedetails['LabelsPerRoll']:$prid['LabelsPerSheet'];

            $custom_price = $this->min_roll_price($ManufactureID,$qty,$lpr);
            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');

            $ExVat  = round($custom_price,2);
            $IncVat = round($custom_price*1.2,2);
            $data = array('Price'=>$ExVat,'ProductTotalVAT'=>$ExVat,'ProductTotal'=>$IncVat,'Quantity'=>$qty,'UnitPrice'=>$ExVat,'TotalPrice'=>$IncVat);

        }else{
            if(substr($ManufactureID,-2,2)=='XS'){
                $qty =  $this->special_xmass_qty($qty);
            }
            if(substr($ManufactureID,-2,2)=='XS'){
                $qty =  $this->special_xmass_qty($qty);
            }

            /*****************WPEP Offer************/
            $wpep_discount = 0.00;
            $custom_price = $this->getPrize($qty,$ManufactureID);
            //print_r($ManufactureID); exit;
            //$ProductBrand = $this->ProductBrand($ManufactureID);
            if(preg_match("/A4 Labels/i",$ProductBrand)){
                $mat_code = $this->ReturnGetPrice_model->getmaterialcode($ManufactureID);
                $material_discount = $this->ReturnGetPrice_model->check_material_discount($mat_code);
                if($material_discount){
                    $custom_price = ($custom_price*1.2);
                    $wpep_discount = (($custom_price)*($material_discount/100));
                    $total = $custom_price-$wpep_discount;
                    $custom_price = $total/1.2;
                }
            }

            $prid = $this->db->query("select LabelsPerSheet from products WHERE 
				`ManufactureID` LIKE '".$ManufactureID."'")->row_array();
            $mylabels = $qty * $prid['LabelsPerSheet'];


            $unitPrice = $custom_price/$qty;
            $UnitPrice = number_format(round($unitPrice,3),3,'.','');
            $ExVat  = round($custom_price,2);
            $IncVat = round($custom_price*1.2,2);
            $data = array('Price'=>$ExVat,'labels'=>$mylabels,'ProductTotalVAT'=>$ExVat,'ProductTotal'=>$IncVat,'Quantity'=>$qty,'UnitPrice'=>$ExVat,'TotalPrice'=>$IncVat);
            /*****************WPEP Offer************/
        }
        return json_encode($data);
    }





}

//GROUP_CONCAT(DISTINCT  REPLACE(products.ManufactureID,substring_index(c.CategoryImage,".",1),"")) as col_3


