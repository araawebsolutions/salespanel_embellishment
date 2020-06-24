<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credit_accounts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->load->library('form_validation'); 
        $this->home_model->user_login_ajax();
    }

    
    
    function index() {
        $account_customers = $this->credit_account_model->getCustomerAccount();
        $data['c_account_customers'] = $account_customers;
        $data['main_content'] = 'credit_accounts';
        $this->load->view('page', $data); 
    }

    function add_new_customer(){

        $search_account_no = 'AA'.date('y');
        $account_no = $this->credit_account_model->getAccountNo($search_account_no);


        $c_account_number = $this->generate_account_number($account_no);

        $data['c_account_number']= $c_account_number;
        $this->load->view('credit_account/add_credit_account', $data);
        
    }

    function search_statement(){
        $account_customers = $this->credit_account_model->getCustomerAccount();
        $data['c_account_customers'] = $account_customers;
        $this->load->view('credit_account/search_statement', $data);
    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
      $date_aux = date_create_from_format($from_format, $date);
      return date_format($date_aux,$to_format);
    }

   function view_statement(){
        //$UserID = '64087635';
        $statement = $this->input->post('statement');
         $start_date = $this->input->post('start_date');
         $end_date = $this->input->post('end_date');
        $c=0;
            if($start_date != NULL){
            $start_date =  $this->reformatDate($start_date);
        }
        else
        {
            $start_date = NULL;
        }

        if( $end_date != NULL){
           $end_date = $this->reformatDate($end_date);
        }
        else
        {
            $end_date = NULL;
        }
           if($start_date > $end_date){
              $c = $start_date;
              $start_date = $end_date;
              $end_date = $c;
           }
      $search_by =  $this->input->post('search_by');
      $search =  $this->input->post('search');
      $this->db->select('UserID');
      $this->db->from('customers');
      if($search_by != '' && $search != '')
      {
        if($search_by == 'Id'){
          $this->db->where('customers.AccountNumber', $search);        
        }
        if($search_by == 'Name'){
          $this->db->like('customers.BillingFirstName', $search);
          //$this->db->or_like('customers.UserName', $search);
        }
        if($search_by == 'Email'){
          $this->db->where('customers.UserEmail', $search);        
        }
        if($search_by == 'Company'){
          $this->db->where('customers.BillingCompanyName', $search);        
        }
      }
      $query = $this->db->get();
      $row = $query->row_array();
      $UserID =  $row['UserID'];
     
      $month = date('m');

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $currentMonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);
      //echo  $currentMonthVal ;
      //exit();

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period1MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period2MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period3MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period4MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);
      $currentMonthVal = $currentMonthVal;
      $period1MonthVal = $period1MonthVal;
      $period2MonthVal = $period2MonthVal;
      $period3MonthVal = $period3MonthVal;
      $period4MonthVal = $period4MonthVal;
        $popup_data = '<div class="modal-dialog account-modal-dialog" role="document">
        <div class="modal-content account-modal-content">
            
            <div class="modal-body account-body">

            <div class="row">
            <div class="col-md-12 text-center"><h3 style="font-size: 20px;    font-weight: bold;    color: #006ca5!important;line-height: normal;margin-top: 0px;">Statement</h3></div>
                <button style="right: 8px; top: 8px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></button>
            </div>
                <div class="tab-content ">
                    <div class="tab-pane active" id="4" style="padding: 10px;">
                        <div class="row">
                            <table style="width:100%" id="responsive-datatable-statement" class="table table-bordereds taable-bordered payment-tables">
                                <thead>
                                <tr>
                                    <th style="border-bottom: 2px solid #49d0fe !important;">Order Reference</th>
                                    <th style="border-bottom: 2px solid #49d0fe !important;">Date</th>
                                    <th style="border-bottom: 2px solid #49d0fe !important;">Order Details</th>
                                    <th style="border-bottom: 2px solid #49d0fe !important;">Debited Amount</th>
                                    <th style="border-bottom: 2px solid #49d0fe !important;">Credit Amount</th>
                                    <th style="border-bottom: 2px solid #49d0fe !important;border-right: 2px solid rgb(73, 208, 254) !important;">Balance</th>
                                </tr>
                                </thead>
                               
                            </table>
                        </div>
                        <h2 class="statement-note row"><b>Note:</b> All values are shown in sterling pounds.</h2>
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <table class="table table-bordereds taable-bordered payment-tables-2" width="60%">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Current</th>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Period 1</th>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Period 2</th>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Period 3</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody class="payment-tables-tbody">
                                    <tr>
                                        <td> £'.$currentMonthVal.'</td>
                                        <td> £'.$period1MonthVal.'</td>
                                        <td> £'.$period2MonthVal.'</td>
                                        <td> £'.$period3MonthVal.'</td>
                                        
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-4">
                            </div>

                            <div class="col-md-2 p-0">
                                <table class="table table-bordereds taable-bordered payment-tables-3 pull-right">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Older</th>
                                    </tr>
                                    </thead>
                                    <tbody class="payment-tables-tbody">
                                    <tr>
                                        <td> £'.$period4MonthVal.'</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                          <div class="col-md-12" style="text-align: center; margin-top: 8px;">
                            <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal" onclick="location.reload(true);">CLOSE</button>
                          </div>

                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
<script type="text/javascript">
$(document).ready(function () {
var datatable = $("#responsive-datatable-statement").DataTable({
  "destroy": true,
         "processing": true,
         "serverSide": false,
          "pageLength": 25,
         "iDisplayStart ": 0,
         "iDisplayLength": 10,
         "order": [[ 0, "desc" ]],
         "ajax": {
            "url": "'.main_url.'credit_accounts/search_view_statement",
            "type": "POST",
            "data": {
                        "statement":"'.$statement.'",
                        "start_date":"'.$start_date.'",
                        "end_date":"'.$end_date.'",
                        "search_by":"'.$search_by.'",
                        "search":"'.$search.'",
                    },
           /* "success": function (data) {
               alert(data.length);

             }*/
            }, 
            "columnDefs": [{
            } ]
            
        });

$("#responsive-datatable_processing").show();
$(".dataTables_empty").hide();


});

</script>
    ';

        echo $popup_data;
    }

  function save_credit_account(){

    if($this->input->post()==TRUE){      
      $this->load->helper('email');
      $this->form_validation->set_rules('AccountNumber', 'A/C', 'trim|required|is_unique[customers.AccountNumber]');
      $this->form_validation->set_rules('Balance', 'Balance', 'trim|required');
      $this->form_validation->set_rules('BillingFirstName', 'Contact name', 'trim|required');
      $this->form_validation->set_rules('UserEmail', 'Email', 'trim|required|valid_email|is_unique[customers.UserEmail]');
      $this->form_validation->set_rules('BillingAddress1', 'Address', 'trim|required');
      $this->form_validation->set_rules('BillingTownCity', 'City', 'trim|required');
      $this->form_validation->set_rules('BillingCountyState', 'State', 'trim|required');
      $this->form_validation->set_rules('BillingCountry', 'Country', 'trim|required');
      $this->form_validation->set_rules('BillingPostcode', 'Post code', 'trim|required');
              
      if ($this->form_validation->run() == FALSE){
        $errors = validation_errors();
        // echo '<div class="alert alert-danger">'.$errors.'</div>';
        if (form_error('AccountNumber'))
        {
          echo 'AccountNumber__<div class="frmAlert">'.strip_tags(form_error('AccountNumber')).'</div>';
        }
        else
          if (form_error('Balance'))
          {
            echo 'Balance__<div class="frmAlert">'.strip_tags(form_error('Balance')).'</div>';
          }
        else
          if (form_error('BillingFirstName'))
          {
            echo 'BillingFirstName__<div class="frmAlert">'.strip_tags(form_error('BillingFirstName')).'</div>';
          }
        else
          if (form_error('UserEmail'))
          {
            echo 'UserEmail__<div class="frmAlert">'.strip_tags(form_error('UserEmail')).'</div>';
          }
        else
          if (form_error('BillingAddress1'))
          {
            echo 'BillingAddress1__<div class="frmAlert">'.strip_tags(form_error('BillingAddress1')).'</div>';
          }
        else
          if (form_error('BillingTownCity'))
          {
                  echo 'BillingTownCity__<div class="frmAlert">'.strip_tags(form_error('BillingTownCity')).'</div>';
          }
        else
          if (form_error('BillingCountyState'))
          {
            echo 'BillingCountyState__<div class="frmAlert">'.strip_tags(form_error('BillingCountyState')).'</div>';
          }
        else
          if (form_error('BillingCountry'))
          {
            echo 'BillingCountry__<div class="frmAlert">'.strip_tags(form_error('BillingCountry')).'</div>';
          }
        else
          if (form_error('BillingPostcode'))
          {
            echo 'BillingPostcode__<div class="frmAlert">'.strip_tags(form_error('BillingPostcode')).'</div>';
                }
        
      }
      else
      { 
        
               
        if(!empty( $this->input->post('on_hold'))){
          $c_account_on_hold = $this->input->post('on_hold');   
        }
        else
        {
          $c_account_on_hold = 'no';
        }
                  


        $r = $this->credit_account_model->checkCACustomer($this->input->post('AccountNumber'));
        
        if($r > 0){
          echo 'error__<div class="frmAlert"><strong>Error!</strong> Already customer has registered on this account number.</div>';
        }
        else
        {  
          
          $insert = array(

            'AccountNumber'       => $this->input->post('AccountNumber'),
            'BillingCompanyName'  => $this->input->post('BillingCompanyName'),
            'Balance'             => $this->input->post('Balance'),
            'Account_Limit'       => $this->input->post('Account_Limit'),
            'BillingFirstName'    => $this->input->post('BillingFirstName'),
            'UserName'            => $this->input->post('BillingFirstName'),
            'TradingName'         => $this->input->post('TradingName'),
            'BillingTelephone'    => $this->input->post('BillingTelephone'),
            'BillingLastName'     => $this->input->post('BillingLastName'),
            'UserEmail'           => $this->input->post('UserEmail'),
            'SecondaryEmail'      => $this->input->post('SecondaryEmail'),
            'BillingAddress1'     => $this->input->post('BillingAddress1'),
            'BillingAddress2'     => $this->input->post('BillingAddress2'),
            'BillingTownCity'     => $this->input->post('BillingTownCity'),
            'BillingCountyState'  => $this->input->post('BillingCountyState'),
            'BillingCountry'      => $this->input->post('BillingCountry'),
            'BillingPostcode'     => $this->input->post('BillingPostcode'),
            'VATNumber'           => $this->input->post('VATNumber'),
            'on_hold'             => $c_account_on_hold,
            'user_type'           => 'credit'
            
          );

          /*echo '<pre>';
          print_r($insert);
          echo '</pre>';*/
          $c_account_id = $this->credit_account_model->addCreditCustomer($insert);
          
          
          $logs_arr = array('result'=>$insert);
          $this->save_logs('create_new_customer_creadit_account',$logs_arr);
          
          if($c_account_id  >  0){
            echo 'success__<div class="frmSuccessAlert"><strong>Success!</strong> Customer has been added successfully. </div>';
          }
          else
            echo 'error__<div class="frmAlert"><strong>Error!</strong> Customer has not added successfully.</div>';
        }
      }
    }
    else
    {
      echo 'error__<div class="frmAlert"><strong>Error!</strong> Customer has not added successfully.</div>';

    }     
  }

  
  
  function save_logs($activity,$log_arr){
    $arr = json_encode($log_arr);
      
    $arr_ins['SessionID'] = $this->session->userdata('session_id');
    $arr_ins['Activity']  = $activity;
    $arr_ins['Record']    = $arr;
    $arr_ins['Website']     = 'BK';
    $this->db->insert('websitelog',$arr_ins);
  }

  function update_credit_account(){

        if($this->input->post()==TRUE){      
            $this->load->helper('email');
            $this->form_validation->set_rules('AccountNumber', 'A/C', 'trim|required');
            $this->form_validation->set_rules('Balance', 'Balance', 'trim|required');
            $this->form_validation->set_rules('BillingFirstName', 'Contact name', 'trim|required');
            $this->form_validation->set_rules('UserEmail', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('BillingAddress1', 'Address', 'trim|required');
            $this->form_validation->set_rules('BillingTownCity', 'City', 'trim|required');
            $this->form_validation->set_rules('BillingCountyState', 'State', 'trim|required');
            $this->form_validation->set_rules('BillingCountry', 'Country', 'trim|required');
            $this->form_validation->set_rules('BillingPostcode', 'Post code', 'trim|required');
            
            if ($this->form_validation->run() == FALSE){
                $errors = validation_errors();
                //echo '<div class="alert alert-danger">'.$errors.'</div>';
                if (form_error('AccountNumber'))
                {
                  echo 'AccountNumber__<div class="frmAlert">'.strip_tags(form_error('AccountNumber')).'</div>';
                }
                else
                if (form_error('Balance'))
                {
                  echo 'Balance__<div class="frmAlert">'.strip_tags(form_error('Balance')).'</div>';
                }
                else
                if (form_error('BillingFirstName'))
                {
                  echo 'BillingFirstName__<div class="frmAlert">'.strip_tags(form_error('BillingFirstName')).'</div>';
                }
                else
                if (form_error('UserEmail'))
                {
                  echo 'UserEmail__<div class="frmAlert">'.strip_tags(form_error('UserEmail')).'</div>';
                }
                else
                if (form_error('BillingAddress1'))
                {
                  echo 'BillingAddress1__<div class="frmAlert">'.strip_tags(form_error('BillingAddress1')).'</div>';
                }
                else
                if (form_error('BillingTownCity'))
                {
                  echo 'BillingTownCity__<div class="frmAlert">'.strip_tags(form_error('BillingTownCity')).'</div>';
                }
                else
                if (form_error('BillingCountyState'))
                {
                  echo 'BillingCountyState__<div class="frmAlert">'.strip_tags(form_error('BillingCountyState')).'</div>';
                }
                else
                if (form_error('BillingCountry'))
                {
                  echo 'BillingCountry__<div class="frmAlert">'.strip_tags(form_error('BillingCountry')).'</div>';
                }
                else
                if (form_error('BillingPostcode'))
                {
                  echo 'BillingPostcode__<div class="frmAlert">'.strip_tags(form_error('BillingPostcode')).'</div>';
                }

            }
            else
            { 
 
              if(!empty($this->input->post('on_hold'))){
                $c_account_on_hold = $this->input->post('on_hold');   
              }
              else
              {
                $c_account_on_hold = 'no';
              }
                
              /* $r = $this->credit_account_model->checkCACustomer($this->input->post('AccountNumber'));

                if($r > 0){
                echo '<div class="alert alert-danger"><strong>Error!</strong> Already customer has registered on this account number.</div>';

              }
              else
              { */ 

              $insert = array(
                
                'AccountNumber'       => $this->input->post('AccountNumber'),
                'BillingCompanyName'  => $this->input->post('BillingCompanyName'),
                'Balance'             => $this->input->post('Balance'),
                'Account_Limit'       => $this->input->post('Account_Limit'),
                'BillingFirstName'    => $this->input->post('BillingFirstName'),
                'UserName'            => $this->input->post('BillingFirstName'),
                'TradingName'         => $this->input->post('TradingName'),
                'BillingTelephone'    => $this->input->post('BillingTelephone'),
                'BillingLastName'     => $this->input->post('BillingLastName'),
                'UserEmail'           => $this->input->post('UserEmail'),
                'SecondaryEmail'      => $this->input->post('SecondaryEmail'),
                'BillingAddress1'     => $this->input->post('BillingAddress1'),
                'BillingAddress2'     => $this->input->post('BillingAddress2'),
                'BillingTownCity'     => $this->input->post('BillingTownCity'),
                'BillingCountyState'  => $this->input->post('BillingCountyState'),
                'BillingCountry'      => $this->input->post('BillingCountry'),
                'BillingPostcode'     => $this->input->post('BillingPostcode'),
                'VATNumber'           => $this->input->post('VATNumber'),
                'on_hold'             => $c_account_on_hold,
                'user_type'           => 'credit'
          
              );

              $where = $this->input->post('UserID');
              
              /*echo '<pre>';
              print_r($insert);
              echo '</pre>';*/
              $logs_arr = array('result'=>$insert);
              $this->save_logs('update_customer_creadit_account',$logs_arr);
              
              $c_account_id = $this->credit_account_model->updateCreditCustomer($insert, $where);
              if($c_account_id  >  0){

                echo 'success__<div class="frmSuccessAlert"><strong>Success!</strong> Customer has been updated successfully.</div>';
              }
              else
                echo 'error__<div class="frmAlert"><strong>Error!</strong> Customer has not updated successfully.</div>';
            }
          //}
        }
          else
          {
            echo 'error__<div class="frmAlert"><strong>Error!</strong> Customer has not added successfully.</div>';
          }
       
        }
    
  function search_credit_account() {
    //echo "<pre>";
    $qr = $this->input->get('qr');
    $this->credit_account_model->search_credit_account($qr);
    //echo "</pre>";
  }

    function credit_account_list(){
        //error_reporting(E_ALL);
        $data= array();
        $account_customers = $this->credit_account_model->getCustomerAccount();
        foreach ($account_customers as $key => $customer) {
            $count_order =  $this->credit_account_model->getCustomerOrderCount($customer->UserID);
           
            $data['data'][$key][] = '<a onclick="update_new_customer('.$customer->UserID.');" class="popup-link">'.$customer->BillingFirstName.'</a>';
            $data['data'][$key][] = $customer->BillingLastName;
            $data['data'][$key][] = $customer->BillingCompanyName;
            $data['data'][$key][] = $customer->BillingCountry;
            $data['data'][$key][] = $customer->BillingPostcode;
            $data['data'][$key][] = $customer->BillingTelephone;
            $data['data'][$key][] = $customer->VATNumber;
            //$data['data'][$key][] = '&pound;'.number_format($customer->Account_Limit, 2);
            $data['data'][$key][] = '&pound;'.$customer->Account_Limit;
            $data['data'][$key][] = $customer->on_hold;
            $data['data'][$key][] = $customer->sageNumber;
            if($count_order > $customer->Account_Limit)
              $data['data'][$key][] = '<span style="color: red;">'.'&pound;'.$customer->Balance."</span>";
            else
              $data['data'][$key][] = '&pound;'.$customer->Balance;
        }
        echo json_encode($data);
        /*echo '{
            "data":[
            [
                "Joan","Wells","","United Kingdom","TR3 6LU","01872 863886","","","",""
            ]
            ]
        }';    */   
    }



    function statement(){
        
        $data= array();
        $UserID = $this->input->post('UserID');
        $balance = $this->input->post('Balance');
        $Account_limit = $this->input->post('Account_limit');
        $paids = $this->credit_account_model->getPaymentBalance($UserID);
        $balance = 0;
        foreach ($paids as $key => $paid) {
            $credit = $paid->amount;
            $dabit = $paid->paidAmt;
            $payfull= $paid->PayFull;
            if($key ==  0)
            {
              $balance = $balance + $paid->customer_balance - $dabit;
            }
            else
            {
              $balance = $balance - $dabit;
            }
            $data['data'][$key][] = @$paid->OrderNumber;
            $data['data'][$key][] =  date('d/m/Y', @$paid->OrderDate);
            $data['data'][$key][] = '';
            $data['data'][$key][] = '&pound;'.$dabit;
            if($paid->show_amt == 'Y')
            {
              $data['data'][$key][] =  '&pound;'.$credit;
              $balance = $balance + $credit;

            }
            else
            {
              $data['data'][$key][] = '';
            }
            if($paid->PayFull == 'yes'){
              $data['data'][$key][] ='&pound;'.$paid->customer_balance;
            }else{
              $data['data'][$key][] = '&pound;'.$balance;
            }
            
        }
        echo json_encode($data);
    }
 
     function search_view_statement(){
        
        $data= array();
        $statement = $this->input->post('statement');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $c=0;
        if($start_date > $end_date){
              $c = $start_date;
              $start_date = $end_date;
              $end_date = $c;
           }


        $search_by = $this->input->post('search_by');
        $search = $this->input->post('search');
        $paids = $this->credit_account_model->getPaymentBalanceStatement($statement, $start_date, $end_date, $search, $search_by);
        $balance = 0;
        foreach ($paids as $key => $paid) {
            $credit = $paid->amount;
            $dabit = $paid->paidAmt;
            if($key ==  0)
            {
              $balance = $balance + $paid->customer_balance - $dabit;
            }
            else
            {
              $balance = $balance - $dabit;
            }
            $data['data'][$key][] = @$paid->OrderNumber;
            $data['data'][$key][] =  date('d/m/Y', @$paid->OrderDate);
            $data['data'][$key][] = '';
            $data['data'][$key][] = '&pound;'.$dabit;
            if($paid->show_amt == 'Y')
            {
              $data['data'][$key][] =  '&pound;'.$credit;
              $balance = $balance + $credit;

            }
            else
            {
              $data['data'][$key][] = '';
            }
            $data['data'][$key][] = '&pound;'.$balance;
        }
        if(empty($data)){
           echo json_encode('No record Found');
        }
       echo json_encode($data);
    }

    function order_list(){
        $UserID = $this->input->post('UserID');
        $balance = $this->input->post('Balance');
        $Account_limit = $this->input->post('Account_limit');
        $customer_account_balances = $this->credit_account_model->getCreditCustomerAccounBalance($UserID);
        $data= array();
        foreach ($customer_account_balances as $key => $customer_account_balance) {
          if($key == 0){
             $bal = $customer_account_balance->Balance - $customer_account_balance->paidAmt;
          }


          if($customer_account_balance->currency == 'GBP' )
                $sign = '&pound;';
            elseif($customer_account_balance->currency == 'EUR')
                $sign = '&euro;';
            elseif($customer_account_balance->currency == 'USD')
                $sign = '$';


            $data['data'][$key][] = $customer_account_balance->OrderNumber;
            $data['data'][$key][] = date('d/m/Y', $customer_account_balance->OrderDate);
            $data['data'][$key][] = $customer_account_balance->BillingCompanyName;
            $data['data'][$key][] = $customer_account_balance->InvoiceNumber;
            $data['data'][$key][] = $sign.$customer_account_balance->OrderTotal;
            $data['data'][$key][] = date('d/m/Y',$customer_account_balance->PaymentDate);
            $data['data'][$key][] = '<input type="hidden" class="form-control" name="ordertotal_'.$customer_account_balance->OrderID.'" id="ordertotal_'.$customer_account_balance->OrderID.'" value="'.$customer_account_balance->OrderTotal.'" />
            <div class=" labels-form">
                                 <label class="select "> 
            <select class="form-control payment-mthd" name="payment_'.$customer_account_balance->OrderID.'" id="payment_'.$customer_account_balance->OrderID.'">
                                                <option value="">Please Select Method</option>
                                                <option value="Bacs">Bacs</option>
                                                <option value="chequePostel">chequePostel</option>
                                            </select>
                                            <i></i>
                                            </label>
                                            </div>
                                            ';
            if($key == 0){
            $data['data'][$key][] = '<input type="text" class="form-control" name="amount_'.$customer_account_balance->OrderID.'" id="amount_'.$key.'" value="'.@$customer_account_balance->amount.'" />
            <input type="hidden" class="form-control" name="show_amount_'.$customer_account_balance->OrderID.'" id="show_amount_'.$customer_account_balance->OrderID.'" value="Y" />
            ';
            }
            else
            {
              $data['data'][$key][] = '<input type="hidden" id="amount_'.$key.'" name="amount_'.$customer_account_balance->OrderID.'" value="'.$bal.'"  class="remove_border_bg" />
              <input type="hidden" class="form-control" name="show_amount_'.$customer_account_balance->OrderID.'" id="show_amount_'.$customer_account_balance->OrderID.'" value="N" />';
            }
            if($key > 0){
              $bal = $bal - $customer_account_balance->paidAmt;
            }

            //$data['data'][$key][] = $customer_account_balance->on_hold;

            $data['data'][$key][] = '<input type="text" id="remaining_'.$key.'" name="remaining_'.$customer_account_balance->OrderID.'" value="'.$bal.'" class="remove_border_bg" style="width:100%" />';
            $data['data'][$key][] = '<input type="text" class="form-control" placeholder="" name="exchange_'.$customer_account_balance->OrderID.'" id="exchange_'.$customer_account_balance->OrderID.'" onblur="getRemaining('.$key.', this.value, '.$customer_account_balance->OrderID.');" value="'.$customer_account_balance->paidAmt.'");"><a href="#" style="text-decoration: underline;font-weight: bold;margin: 10px;" class="edit editable" onclick="pay_in_full('.$customer_account_balance->OrderID.');">Pay in Full</a>
            <a href="#" style="text-decoration: underline;font-weight: bold;margin: 10px;" class="edit editable" onclick="update('.$customer_account_balance->OrderID.');">Update</a><input type="hidden" value="'.$UserID.'" name="customer_'.$customer_account_balance->OrderID.'" id="customer_'.$customer_account_balance->OrderID.'" />';

        }
        echo json_encode($data); 
    }

    function payment_activity(){

         $UserID = $this->input->post('UserID');
        $balance = $this->input->post('Balance');
        $Account_limit = $this->input->post('Account_limit');
        $customer_account_balances = $this->credit_account_model->getPaymentBalance($UserID);
        $data= array();
        foreach ($customer_account_balances as $key => $paid) {

              $credit = $paid->amount;
              $dabit = $paid->paidAmt;

            if($paid->currency == 'GBP' )
                $sign = '&pound;';
            elseif($paid->currency == 'EUR')
                $sign = '&euro;';
            elseif($paid->currency == 'USD')
                $sign = '$';
            $data['data'][$key][] = $paid->InvoiceNumber;
            $data['data'][$key][] = $paid->order_type;
            $data['data'][$key][] = date('d/m/Y', $paid->OrderDate);
            $data['data'][$key][] = '';
            $data['data'][$key][] = $paid->OrderNumber;
            $data['data'][$key][] = $sign.$paid->exchange_rate;
            $data['data'][$key][] = '';
            $data['data'][$key][] = $sign.$paid->OrderTotal;
            $data['data'][$key][] = '';
            $data['data'][$key][] = '&pound;'.$dabit;
            $data['data'][$key][] = '&pound;'.$credit;
        }
        echo json_encode($data); 

    }

    function view_credit_account(){

      $month = date('m');

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $UserID = $this->input->post('UserID');

      $currentMonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);
   //echo $currentMonthVal;
  // exit();
      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period1MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period2MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period3MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);

      $month = $month - 1;

      if($month == 0)
      {
        $month = 12;
      }

      $fromDate = strtotime(date('Y-'.$month.'-01'));

      $toDate = strtotime(date('Y-'.$month.'-31'));

      $period4MonthVal = $this->credit_account_model->getStatementOrderCount($UserID , $fromDate, $toDate);
       
      /*$currentMonthVal->paidAmt;
       die();*/
       
      $customer_account = $this->credit_account_model->getCreditCustomerAccount($UserID);

      $balance = $customer_account->Balance;

      $currentMonthVal = $currentMonthVal;

      $period1MonthVal = $period1MonthVal;
      $period2MonthVal = $period2MonthVal;
      $period3MonthVal = $period3MonthVal;
      $period4MonthVal = $period4MonthVal;

      $futureDate = strtotime(date('Y-m-d'));

      $futureBalance = $this->credit_account_model->getCurrentCreditCustomerAccount($UserID , $futureDate, '');
if(empty($futureBalance)){
        $futureBalance = '0.00';
      }
      $currentDate = strtotime(date('Y-m-01'));
      $currentBalance = $this->credit_account_model->getCurrentCreditCustomerAccount($UserID , $currentDate, '');
 if(empty($currentBalance)){
        $currentBalance = '0.00';
      }
      $date30days = strtotime(date('Y-m-d', strtotime('-30 days')));
       if(empty($date30days)){
        $date30day = '0.00';
      }
      $balance30days = $this->credit_account_model->getCurrentCreditCustomerAccount($UserID , $date30days, '');
 if(empty($balance30days)){
        $balance30days = '0.00';
      }

      $date60days = strtotime(date('Y-m-d', strtotime('-60 days')));
      $balance60days = $this->credit_account_model->getCurrentCreditCustomerAccount($UserID , $date60days, '');
      if(empty($balance60days)){
        $balance60days = '0.00';
      }

      $date90days = strtotime(date('Y-m-d', strtotime('-90 days')));
      $balance90days = $this->credit_account_model->getCurrentCreditCustomerAccount($UserID , $date90days, '');
       if(empty($balance90days)){
        $balance90days = '0.00';
      }

      $olderDate = 0;
      $olderBalance = $this->credit_account_model->getCurrentCreditCustomerAccount($UserID , $olderDate, '');

      //$current
        
        

      $popup_data = '
<style type="text/css">
    .frmAlert{
        clear: both;
        background-color: red;
        padding: 5px;
        color: #fff !important;
        margin-top: 32px;
        border-radius: 5px;
    }
    .frmSuccessAlert{
        clear: both;
        background-color: green;
        padding: 5px;
        color: #fff !important;
        margin-top: 32px;
        border-radius: 5px;
    }
</style>
<script>(function(n,t,i,r){var u,f;n[i]=n[i]||{},n[i].initial={accountCode:"AALAB11111",host:"AALAB11111.pcapredict.com"},n[i].on=n[i].on||function(){(n[i].onq=n[i].onq||[]).push(arguments)},u=t.createElement("script"),u.async=!0,u.src=r,f=t.getElementsByTagName("script")[0],f.parentNode.insertBefore(u,f)})(window,document,"pca","//AALAB11111.pcapredict.com/js/sensor.js")</script>

      <div class="modal-dialog account-modal-dialog" role="document">
        <div class="modal-content account-modal-content">
            <div class="modal-header account-header">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#1" class="active" data-toggle="tab">Customer Record</a>
                    </li>
                    <li>
                        <a href="#2" data-toggle="tab">Payment Allocation</a>
                    </li>
                    <li>
                        <a href="#3" data-toggle="tab">Activity</a>
                    </li>
                    <li>
                        <a href="#4" data-toggle="tab">Statement</a>
                    </li>
                </ul>
            </div>
            <div class="modal-body account-body">
                <div class="tab-content ">
                    <div class="tab-pane active " id="1">
                    <form id="validationID" action="'.main_url.'credit_accounts/add_credit_account" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12" id="success"></div>
                            <div class="col-md-12" id="error"></div>
                            <div class="col-md-4 account-details">
                                <h3 class="account-title">Account Details</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">A/C *</span>
                                    <input type="text" name="c_account_number"  readonly class="form-control form-control-sm account-input" value="'.$customer_account->AccountNumber.'" placeholder="123456" aria-controls="responsive-datatable">
                                        <input type="hidden" name="c_account_id" class="form-control form-control-sm account-input" value="'.$UserID.'"  aria-controls="responsive-datatable">
                                      </div>
                                      <div id="AccountNumber">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Company Name</span>
                                    <input type="text" name="c_account_company" class="form-control form-control-sm account-input" value="'.$customer_account->BillingCompanyName.'"
                                            aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">Balance</span>
                                    <input type="text" name="c_account_balance" class="form-control form-control-sm account-input"
                                           value="'.$customer_account->Balance.'" aria-controls="responsive-datatable">
                                    </div>
                                    <div id="Balance">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Account limit</span>
                                    <input type="text" name="c_account_limit" class="form-control form-control-sm account-input"
                                            aria-controls="responsive-datatable" value="'.$customer_account->Account_Limit.'" >
                                </label>
                            </div>
                            <div class="col-md-4 contact-info">
                                <h3 class="account-title">Contact Information</h3>
                                <label>
                                  <div>
                                    <span class="account-form-title">First Name</span>
                                    <input type="text" name="c_account_contact_name" class="form-control form-control-sm account-input" value="'.$customer_account->BillingFirstName.'" 
                                           aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingFirstName">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Last Name</span>
                                    <input type="text" name="c_account_last_name" class="form-control form-control-sm account-input" value="'.$customer_account->BillingLastName.'" 
                                            aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Trade Name</span>
                                    <input type="text" name="c_account_trade_name" class="form-control form-control-sm account-input" value="'.$customer_account->TradingName.'" 
                                            aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <span class="account-form-title">Telephone</span>
                                    <input type="text" name="c_account_telephone" class="form-control form-control-sm account-input" value="'.$customer_account->BillingTelephone.'" 
                                            aria-controls="responsive-datatable">
                                </label> 
                            </div>
                            <div class="col-md-4">
                                <h3 class="account-title">Email Settings</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">Primary Email</span>
                                    <input type="email" name="c_account_primary_email" readonly class="form-control form-control-sm account-input" value="'.$customer_account->UserEmail.'" 
                                            aria-controls="responsive-datatable">
                                    </div>
                                    <div id="UserEmail">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Secondary Email</span>
                                    <input type="text" name="c_account_secondary_email" class="form-control form-control-sm account-input" value="'.$customer_account->SecondaryEmail.'" 
                                            aria-controls="responsive-datatable">
                                </label>
                            </div>
                        </div>
                        <div class="row ac-line-2">
                            <div class="col-md-4 account-details">
                                <h3 class="account-title">Address</h3>
                                <label>
                                  <div>
                                    <span class="account-form-title">Address 1</span>
                                    <input type="text" name="c_account_address1" class="form-control form-control-sm account-input" value="'.$customer_account->BillingAddress1.'" 
                                            aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingAddress1">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">Address 2</span>
                                    <input type="text" name="c_account_address2" class="form-control form-control-sm account-input" value="'.$customer_account->BillingAddress2.'" 
                                           aria-controls="responsive-datatable">
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">Town / City</span>
                                    <input type="text" name="c_account_city" class="form-control form-control-sm account-input"
                                    value="'.$customer_account->BillingTownCity.'"                                             aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingTownCity">

                                    </div>
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">County / State</span>
                                    <input type="text" name="c_account_state" class="form-control form-control-sm account-input"
                                     value="'.$customer_account->BillingCountyState.'"aria-controls="responsive-datatable">
                                     </div>
                                    <div id="BillingCountyState">

                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4 contact-info">
                                <h3 class="account-title">Contact Information</h3>
                                <label>
                                    <div>
                                    <span class="account-form-title">Country</span>
                                    <input type="text" name="c_account_country" class="form-control form-control-sm account-input" value="'.$customer_account->BillingCountry.'" 
                                            aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingCountry">

                                    </div>
                                </label>
                                <label>
                                    <div>
                                    <span class="account-form-title">Post Code</span>
                                    <input type="text" name="c_account_post_code" class="form-control form-control-sm account-input" value="'.$customer_account->BillingPostcode.'" 
                                           aria-controls="responsive-datatable">
                                    </div>
                                    <div id="BillingPostcode">

                                    </div>
                                </label>
                                <label>
                                    <span class="account-form-title">VAT No</span>
                                    <input type="text" name="c_account_vat_no" class="form-control form-control-sm account-input" value="'.$customer_account->VATNumber.'" 
                                           aria-controls="responsive-datatable">
                                </label>

                            </div>
                            <div class="col-md-4">
                                <h3 class="account-title">Account Settings</h3>
                                <label>
                                    <span class="account-form-title">Account Status</span>
                                    <div class="checkbox checkbox-info ac-status-check-box">
                                        <input id="checkbox4" name="c_account_on_hold" value="" type="checkbox"';
                                if($customer_account->on_hold == 'yes'){
                                    $popup_data .= 'checked="checked"';
                                }
                                    $popup_data .= '>
                                        <label for="checkbox4"></label>
                                        <span>On Hold</span>
                                    </div>

                                </label>
                            </div>
                        </div>
                        <div class="modal-footer ac-footer">
                <div style="margin: 0px auto;">
                    <span class=" m-r-10"><button type="button"
                                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal"  onclick="location.reload(true);" style="width: 150px;">CLOSE</button></span>
                    <span><button id="btnSubmit" type="submit"
                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="width: 150px;">UPDATE</button></span>
                </div>
            </div>
            </form>
                    </div>
                    <div class="tab-pane " id="2" style="padding: 0px 15px;">
                        <div class="row">
                            <table id="responsive-datatable-order" width="100%" class="table table-bordereds taable-bordered payment-tables" style="padding: 0px 15px;">
                                <thead>
                                <tr>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Order Number</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Date</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Company Name</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Invoice #</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Amount</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Payment Date</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Payment Method</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Amount</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Balance</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Action</th>
                                </tr>
                                </thead>
                               
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane " id="3">

<table id="responsive-datatable-payment" class="table table-bordereds taable-bordered payment-tables" style="width:100%;">
                            <thead>
                            <tr>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">No</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Type</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Date</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Due on</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Ref</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Exchange Rate</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Details</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Amount £</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">O/S £</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Debit £</th>
                                <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Credit £</th>
                            </tr>
                            </thead>';
                                $popup_data .= '
                           
                           </table>

                        <!--<div class="row">
                            <div class="col-md-4 text-left p-t-15">Showing 1 to 10 of 260 entries</div>
                            <div class="col-md-4 text-center"></div>
                            <div class="col-md-4 text-right">
                                <nav class="pull-right m-t-t-10 m-r-10">
                                    <ul class="pagination pagination-split">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">«</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#"
                                                                 style="font-weight: normal;">1</a></li>
                                        <li class="page-item active"><a class="page-link" href="#"
                                                                        style="background: #00b7f1;border-color: #00b7f1;">2</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#"
                                                                 style="font-weight: normal;">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#"
                                                                 style="font-weight: normal;">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#"
                                                                 style="font-weight: normal;">5</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">»</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>-->


                        <table class="table table-bordereds taable-bordered payment-tables" style="margin-top: 15px;">
                            <thead class="collapse-trr">
                            <tr>
                                <th style="background-color: #d8f4ff !important;font-weight: bold;vertical-align: inherit;color: #666 !important;">Future £</th>
                                <th style="background-color: #d8f4ff !important;font-weight: bold;vertical-align: inherit;color: #666 !important;">Current £</th>
                                <th style="background-color: #d8f4ff !important;font-weight: bold;vertical-align: inherit;color: #666 !important;">30 Days £</th>
                                <th style="background-color: #d8f4ff !important;font-weight: bold;vertical-align: inherit;color: #666 !important;">60 Days £</th>
                                <th style="background-color: #d8f4ff !important;font-weight: bold;vertical-align: inherit;color: #666 !important;">90 Days £</th>
                                <th style="background-color: #d8f4ff !important;font-weight: bold;vertical-align: inherit;color: #666 !important;">Older £</th>

                            </tr>
                            </thead>
                            <tbody class="payment-tables-tbody">
                            <tr>
                                <td><input type="email" class="form-control text-center" placeholder="£'.$futureBalance.'"></td>
                                <td><input type="email" class="form-control text-center" placeholder="£'.$currentBalance.'"></td>
                                <td><input type="email" class="form-control text-center" placeholder="£'.$balance30days.'"></td>
                                <td><input type="email" class="form-control text-center" placeholder="£'.$balance60days.'"></td>
                                <td><input type="email" class="form-control text-center" placeholder="£'.$balance90days.'"></td>
                                <td><input type="email" class="form-control text-center" placeholder="£'.$olderBalance.'"></td>
                            </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="tab-pane " id="4" style="padding: 0px 15px;">
                        <div class="row">
                            <table style="width:100%" id="responsive-datatable-statement" class="table table-bordereds taable-bordered payment-tables">
                                <thead>
                                <tr>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Order Reference</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Date</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Order Details</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Debited Amount</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Credit Amount</th>
                                    <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Balance</th>
                                </tr>
                                </thead>
                               
                            </table>
                        </div>
                        <h2 class="statement-note row"><b>Note:</b> All values are shown in sterling pounds.</h2>
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <table class="table table-bordereds taable-bordered payment-tables-2" width="60%">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Current</th>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Period 1</th>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Period 2</th>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Period 3</th>
                                    </tr>
                                    </thead>
                                    <tbody class="payment-tables-tbody">
                                    <tr>
                                        <td> £'.$currentMonthVal.'</td>
                                        <td> £'.$period1MonthVal.'</td>
                                        <td> £'.$period2MonthVal.'</td>
                                        <td> £'.$period3MonthVal.'</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-4">
                            </div>

                            <div class="col-md-2 p-0">
                                <table class="table table-bordereds taable-bordered payment-tables-3 pull-right">
                                    <thead>
                                    <tr>
                                        <th style="background-color: #d8f4ff;font-weight: bold;vertical-align: inherit;">Older</th>
                                    </tr>
                                    </thead>
                                    <tbody class="payment-tables-tbody">
                                    <tr>
                                        <td> £'.$period4MonthVal.'</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
<script type="text/javascript">
$(document).ready(function () {

    var datatable = $("#responsive-datatable-order").DataTable({
      "destroy": true,
         "processing": true,
         "serverSide": false,
         "ajax": {
            "url": "'.main_url.'credit_accounts/order_list",
            "type": "POST",
            "data": {
                        "UserID":"'.$UserID.'",
                        "Balance":"'.$customer_account->Balance.'",
                        "Account_limit":"'.$customer_account->Account_Limit.'"
                    }
            },
            "ordering": false,
            "columnDefs": [{
            } ]
        });

         $("#responsive-datatable-order_processing").hide();
        var datatable = $("#responsive-datatable-payment").DataTable({
          "destroy": true,
         "processing": true,
         "serverSide": false,
         "ajax": {
            "url": "'.main_url.'credit_accounts/payment_activity",
            "type": "POST",
            "data": {
                        "UserID":"'.$UserID.'",
                        "Balance":"'.$customer_account->Balance.'",
                        "Account_limit":"'.$customer_account->Account_Limit.'"
                    }
            },
            "ordering": false,
            "columnDefs": [{
 
       
 
            } ]
        });
        $("#responsive-datatable-payment_processing").hide();



var datatable = $("#responsive-datatable-statement").DataTable({
  "destroy": true,
         "processing": true,
         "serverSide": false,
         "ajax": {
            "url": "'.main_url.'credit_accounts/statement",
            "type": "POST",
            "data": {
                        "UserID":"'.$UserID.'",
                        "Balance":"'.$customer_account->Balance.'",
                        "Account_limit":"'.$customer_account->Account_Limit.'"
                    }
            },
            "ordering": false,
            "columnDefs": [{
 
       
 
            } ]
        });
    
        $("#responsive-datatable-statement_processing").hide();
        $(".dataTables_empty").hide();
    
    
        if($("input[name=c_account_on_hold]").prop("checked") == true){
    
            c_account_on_hold= `yes`;
        }
        else if($("input[name=c_account_on_hold]").prop("checked") == false){
    
            c_account_on_hold= `no`;
        }
    
  

    $("form").submit(function(event) {
      if($("input[name=c_account_on_hold]").prop("checked") == true){  
          c_account_on_hold= `yes`;
          }
          else if($("input[name=c_account_on_hold]").prop("checked") == false){
          
          c_account_on_hold= `no`;
    }
    
    
         var formData = {
            "AccountNumber"          : $("input[name=c_account_number]").val(),
            "BillingCompanyName"         : $("input[name=c_account_company]").val(),
            "Balance"         : $("input[name=c_account_balance]").val(),
            "Account_Limit"           : $("input[name=c_account_limit]").val(),
            "BillingFirstName"    : $("input[name=c_account_contact_name]").val(),
            "TradingName"      : $("input[name=c_account_trade_name]").val(),
            "BillingTelephone"       : $("input[name=c_account_telephone]").val(),
            "BillingLastName"         : $("input[name=c_account_last_name]").val(),
            "UserEmail"   : $("input[name=c_account_primary_email]").val(),
            "SecondaryEmail" : $("input[name=c_account_secondary_email]").val(),
            "BillingAddress1"        : $("input[name=c_account_address1]").val(),
            "BillingAddress2"        : $("input[name=c_account_address2]").val(),
            "BillingTownCity"            : $("input[name=c_account_city]").val(),
            "BillingCountyState"           : $("input[name=c_account_state]").val(),
            "BillingCountry"         : $("input[name=c_account_country]").val(),
            "BillingPostcode"       : $("input[name=c_account_post_code]").val(),
            "VATNumber"          : $("input[name=c_account_vat_no]").val(),
            "on_hold"          : c_account_on_hold,
            "UserID"           : $("input[name=c_account_id]").val()
        };

        $.ajax({
            type: "post",
            url: "'.main_url.'credit_accounts/update_credit_account",
            cache: false,               
            data: formData,
            dataType: "html",
            success: function(data)
            {                        
                var re=data.split("__"); 
                if(re[0] == "success")
                {
                    $("input[name=c_account_company]").val("");
                    $("input[name=c_account_balance]").val("");
                    $("input[name=c_account_limit]").val("");
                    $("input[name=c_account_contact_name]").val("");
                    $("input[name=c_account_trade_name]").val("");
                    $("input[name=c_account_telephone]").val("");
                    $("input[name=c_account_last_name]").val("");
                    $("input[name=c_account_primary_email]").val("");
                    $("input[name=c_account_secondary_email]").val("");
                    $("input[name=c_account_address1]").val("");
                    $("input[name=c_account_address2]").val("");
                    $("input[name=c_account_city]").val("");
                    $("input[name=c_account_state]").val("");
                    $("input[name=c_account_country]").val("");
                    $("input[name=c_account_post_code]").val("");
                    $("input[name=c_account_vat_no]").val("");
                    $("input[name=c_account_on_hold]").prop("checked", false);
                          
                }

                $("#"+$.trim(re[0])).html($.trim(re[1])); 
                setTimeout(function(){ 

                     $("#"+$.trim(re[0])).find(".frmAlert").hide();


                  }, 1500);

            swal("Success","Customer Updated Successfully ","success");
            $("#exampleModal").modal("hide");
           
            },

            error: function(){                      
                alert("Error while request..");
            }            
        });

        event.preventDefault();
    });

});

function pay_in_full(v){
    a = $(`input[name="amount_`+v+`"]`).val();
    ra = $(`input[name="remaining_`+v+`"]`).val();
    if($("#payment_"+v).val() == "")
    {
      show_popover("#payment_"+v, "Please Select Payment Method");
      return false;
    }
    order_val = $("#ordertotal_"+v).val();
    actionamount = $("#exchange_"+v).val();

    if(actionamount > order_val)
    {
      swal("Warning","Action amount must be equal or greater than order amount.","warning"); 
      return false;
    }

  
    $.ajax({
             type: "POST",
            url: "'.main_url.'credit_accounts/update_caccount_balance",               
            data: "OrderID="+v+"&PaymentMethods="+$("#payment_"+v).val()+"&action_amount="+$("#exchange_"+v).val()+"&UserID=" +  $("#customer_"+v).val() + "&status=yes&amount="+a+"&remaining_amount="+ra+"&show_amt="+$("#show_amount_"+v).val(),
            success: function(data)
            {                        
                swal("Success","Value Successfully Added","success");
               
            },
            error: function(){                      
               swal("Error while request..");
            }            
        });

}

function update(v){
    a = $(`input[name="amount_`+v+`"]`).val();
    ra = $(`input[name="remaining_`+v+`"]`).val();
     if(ra == Infinity)
            ra = "0.0000"; 
   if($("#payment_"+v).val() == "")
    {
      
      show_popover("#payment_"+v, "Please Select Payment Method");
      return false;
    }
    $.ajax({
            type: "POST",
            url: "'.main_url.'credit_accounts/update_caccount_balance",               
            data: "OrderID="+v+"&PaymentMethods="+$("#payment_"+v).val()+"&action_amount="+$("#exchange_"+v).val()+"&UserID=" +  $("#customer_"+v).val() + "&status=no&amount="+a+"&remaining_amount="+ra+"&show_amt="+$("#show_amount_"+v).val(),
            success: function(data)
            {                        
                swal("Success"," Value Updated Successfully ","success");
               
            },
            error: function(){                      
                swal("Error while request..");
            }            
        });


}

function getRemaining(index, v, id){
    var amt = eval($("#amount_"+index).val());
    var val = eval(v);

    var ans = amt - val;
    if(ans < 0)
    {
      $("#exchange_"+id).val("");
    }
    else
    {
      $("#remaining_"+index).val(ans);
      var nindex = eval(index) + 1;
      $("#amount_"+nindex).val(ans);
    }



}
</script>
    ';

        echo $popup_data;
    }


  function update_caccount_balance(){
        
    $updateData = array(
      'OrderID'   => $this->input->post('OrderID'),
      'PaymentMethods'   => $this->input->post('PaymentMethods'),
      'action_amount'   => $this->input->post('action_amount'),
      'UserID'   => $this->input->post('UserID'),
      'status'   => $this->input->post('status'),
      'PaymentDate'  => strtotime(date('Y-m-d h:i:s')),
      'amount'   => $this->input->post('amount'),
      'remaining_amount'   => $this->input->post('remaining_amount'),
      'show_amt' => $this->input->post('show_amt')
    );
    $where = $this->input->post('OrderID');

    if($this->credit_account_model->checkPaymentBalance($where) > 0){
      
      $this->credit_account_model->editCreditBalance($updateData, $where);
    }
    else
    {
      $this->credit_account_model->addCreditBalance($updateData);
    }
    $updateData = array(
      'PaymentMethods'   => $this->input->post('PaymentMethods'),
      'PaymentDate'  => strtotime(date('Y-m-d h:i:s')),
      'paidAmt'   => $this->input->post('action_amount'),
      'amount'   => $this->input->post('amount'),
      'remaining_amount'   => $this->input->post('remaining_amount'),
      'PayFull'   => $this->input->post('status'),
      'show_amt' => $this->input->post('show_amt')
    );

    $this->credit_account_model->editOrder($updateData, $where);
    echo 'y';
    }


    function generate_invoice_number($luck=0){
        $fiveDigitNumber = str_pad((int) $luck,10,"0",STR_PAD_LEFT);
        return $fiveDigitNumber;
    }

    function generate_account_number($luck=0){
        $month= date("y");
        $fiveDigitNumber = str_pad((int) $luck,8,"0",STR_PAD_LEFT);
        $p_no = 'AA'.$month.$fiveDigitNumber;
        return $p_no;
    }

    function search_customer(){ 
      error_reporting(E_ALL);
        $search_by = $this->input->post('search_by');
        $search = $this->input->post('search');
        $customer = $this->credit_account_model->getSearchCustomer($search, $search_by);
        echo json_encode($customer);
       
    }
}