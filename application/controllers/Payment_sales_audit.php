<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');
class Payment_sales_audit extends CI_Controller {
    public function __construct() {

        parent::__construct();

        $this->load->library('Datatables');

        $this->load->library('table');

        $this->load->database();
        $this->home_model->user_login_ajax();

    }
    function index() {
        $from_date = date('01/m/Y');
        $todate = date('d/m/Y');
        $data['main_content'] = 'payment_sales_audit';
        $this->load->view('page', $data); 
    }

    function ajax_page() {
        $data = array();
        $data['postType'] = $this->input->post('postType');
        $start_date = $this->input->post('start_date');
        $data['start_date'] = $start_date;
        $end_date = $this->input->post('end_date');
        $data['end_date'] = $end_date;
        if($this->input->post('postType') == 'payment'){
            $data['vatables'] =  $this->payment_vatables( $start_date, $end_date);
            $data['vatexempts'] = $this->payment_vatexempts( $start_date, $end_date);
            $data['novatables'] = $this->no_payment_vatables( $start_date, $end_date);
            $data['novatexempts'] = $this->no_payment_vatexempts( $start_date, $end_date);
        }
        elseif($this->input->post('postType') == 'sale'){
            $data['vatables'] = $this->sale_vatables( $start_date, $end_date);
            $data['vatexempts'] = $this->sale_vatexempts( $start_date, $end_date);
            $data['novatables'] = $this->no_sale_vatables( $start_date, $end_date);
            $data['novatexempts'] = $this->no_sale_vatexempts( $start_date, $end_date);
        }
        elseif($this->input->post('postType') == 'caccount'){
            $data['vatables'] = $this->caccount_vatables( $start_date, $end_date);
            $data['vatexempts'] = $this->caccount_vatexempts( $start_date, $end_date);
            $data['novatables'] = $this->no_caccount_vatables( $start_date, $end_date);
            $data['novatexempts'] = $this->no_caccount_vatexempts( $start_date, $end_date);
        }
        $this->load->view('credit_account/payment_sales_audit', $data); 
    }

    function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
      $date_aux = date_create_from_format($from_format, $date);
      return date_format($date_aux,$to_format);
    }

    function payment_vatables($start, $end){
        if($start != NULL){
            $start =  $this->reformatDate($start);
        }
        else
        {
            $start = NULL;
        }
        if( $end != NULL){
           $end = $this->reformatDate($end);
        }
        else
        {
            $end = NULL;
        }
        $c=0;
        if($start > $end){
              $c = $start;
              $start = $end;
              $end = $c;
        }
        $total = 0;
        $div= '';
        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();
       
        $div.=' <table class="audit-table" style="width:100%">';
        $old_paymentmethod = '';
        foreach ($payments as $p => $payment) {
          $paymentmethod = $payment->PaymentMethodName;
          $currency = $payment->currency_name;
          if($p == 0){
            $old_paymentmethod = $paymentmethod;
          }
          elseif( $old_paymentmethod !=  $paymentmethod)
          {
            $div .= '</table>
                    <table class="audit-table" style="width:100%">';
              $old_paymentmethod = $paymentmethod;
          }
                $status = 'not';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'n', 'all', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;
               if(empty($payment_vatable))
               {
                $payment_vatable=0;
               }

               $total = $total + $payment_vatable;
               // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);
            
              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
                $div .='<tr>
                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>
                       <td width="38%">'.$payment_vatable   .'</td>
                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/payment_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;
                    if($start != NULL)
                    {
                        $div.='/'.$start;
                    }
                    if($end != NULL)
                    {
                         $div.='/'.$end;
                    }
                  $div.='" target="_blank" >CSV</a></td>
                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/payment_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;
                    if($start != NULL)
                    {
                       $div.='/'.$start;
                    }
                    if($end != NULL)
                    {
                         $div.='/'.$end;
                    }

                  $div.='" target="_blank" >PDF</a></td>
                  </tr>';
        }
        $div .= '</table>';
        $div .= '<table class="audit-table text-bold">

                                            <tr>
                                                <td width="38%">TOTAL</td>
                                                <td width="38%"></td>
                                                <td width="12%"></td>
                                                <td width="12%">£'.$total.'</td>
                                            </tr>
                                        </table>';

        return $div;
    }

    function payment_vatexempts($start, $end){
        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');
        //$currencies = array('GBP', 'USD', 'EUR');
        if($start != NULL){
            $start =  $this->reformatDate($start);
        }
        else
        {
            $start = NULL;
        }
        if( $end != NULL){
            $end = $this->reformatDate($end);
        }
        else
        {
            $end = NULL;
        }
        $c=0;
        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }

              $status = 'not';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'y', 'all', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;
               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
                // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable   .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/payment_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/payment_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            //}

           // $div .= '</table>';

        }



        $div .= '</table>';



        $div .= '<table class="audit-table text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;

    }



    function sale_vatables($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

       

        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }


$status = 'not';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency, 'y', 'n', 'payment', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;
                // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);
              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable   .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/sale_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/sale_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            //}

           // $div .= '</table>';

        }

        $div .= '</table>';

        $div .= '<table class="audit-table text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;

    }



    function sale_vatexempts($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

           $start =  $this->reformatDate($start);


        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end =  $this->reformatDate($end);


        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }


$status = 'not';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency, 'y', 'y', 'payment', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

               // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable    .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/sale_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/sale_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }



        $div .= '</table>';



        $div .= '<table class="audit-table text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;



    }



    function caccount_vatables($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

           $end =  $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

         $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }


              
              $status = 'not';
               $res =  $this->payment_sales_audit_model->getOrder($paymentmethod, $currency, 'y', 'n', 'credit', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
              //  // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable.'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/caccount_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/caccount_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }
        $div .= '</table>';

        $div .= '<table class="audit-table text-bold">
                                            <tr>
                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>
                                        </table>';
        return $div;



    }

    function caccount_vatexempts($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

         $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }
              $status = 'not';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency, 'y', 'y', 'credit', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
                // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

                $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable   .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/caccount_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/caccount_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>
                  </tr>';

            /*}

            $div .= '</table>';*/

        }
        $div .= '</table>';
        $div .= '<table class="audit-table text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>
                                        </table>';

        return $div;
    }



    function no_payment_vatables($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table-red" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table-red" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }
              $status = 'no_pay';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'n', 'ALL', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
                // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable   .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/no_payment_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/no_payment_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }



        $div .= '</table>';



        $div .= '<table class="audit-table-red text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;





    }



    function no_payment_vatexempts($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table-red" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table-red" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }


            $status = 'no_pay'; 
             $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'y', 'ALL', $start, $end,  $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
               // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable    .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/no_payment_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/no_payment_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }



        $div .= '</table>';



        $div .= '<table class="audit-table-red text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;

    }



    function no_sale_vatables($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

         $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table-red" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table-red" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }
             $status = 'no_pay'; 
              $res =$this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'n', 'payment', $start, $end ,  $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable = 0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
               // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

                $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable.'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/no_sale_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/no_sale_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }



        $div .= '</table>';



        $div .= '<table class="audit-table-red text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;

    }



    function no_sale_vatexempts($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

        

        $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table-red" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table-red" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }
              $status = 'no_pay';
              $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'y', 'payment', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
                // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/no_sale_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/no_sale_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }



        $div .= '</table>';



        $div .= '<table class="audit-table-red text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>





                                        </table>';

        return $div;

    }



    function no_caccount_vatables($start, $end){

       //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

        

         $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table-red" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {



            $div .= '</table>

                    <table class="audit-table-red" style="width:100%">';



              $old_paymentmethod = $paymentmethod;

          }
            $status = 'no_pay';
             $res = $this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'n', 'credit', $start, $end,$status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
               // // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

                $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable   .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/no_caccount_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/no_caccount_vatables/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }



        $div .'</table>';

        $div .= '<table class="audit-table-red text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>
                                        </table>';

        return $div;

    }



    function no_caccount_vatexempts($start, $end){

        //$paymentmethods = array('Bacs', 'chequePostel', 'creditCard', 'paypal', 'purchaseOrder', 'worldpay');



        //$currencies = array('GBP', 'USD', 'EUR');

        if($start != NULL){

            $start =  $this->reformatDate($start);

        }

        else

        {

            $start = NULL;

        }

        if( $end != NULL){

            $end = $this->reformatDate($end);

        }

        else

        {

            $end = NULL;

        }

        $c=0;

        if($start > $end){

              $c = $start;

              $start = $end;

              $end = $c;

        }

        $total = 0;

        $div= '';

         $payments = $this->payment_sales_audit_model->getPaymentMethodsCurrency();

        $div.=' <table class="audit-table-red" style="width:100%">';

        $old_paymentmethod = '';

        foreach ($payments as $p => $payment) {

            

//foreach ($currencies as $c => $currency) {

          $paymentmethod = $payment->PaymentMethodName;

          $currency = $payment->currency_name;

          if($p == 0){

            $old_paymentmethod = $paymentmethod;

          }

          elseif( $old_paymentmethod !=  $paymentmethod)

          {

            $div .= '</table>

                    <table class="audit-table-red" style="width:100%">';

              $old_paymentmethod = $paymentmethod;

          }
             $status = 'no_pay';
              $res =$this->payment_sales_audit_model->getOrder($paymentmethod, $currency,'y', 'y', 'credit', $start, $end, $status);
              $payment_vatable = $res->OrderTotal;

               if(empty($payment_vatable))

               {

                $payment_vatable=0;

               }

               $total = $total + $payment_vatable;

              // echo $paymentmethod.' '.$currency.' '.$payment_vatables.'<br>';
                // = $this->payment_sales_audit_model->order_status($paymentmethod, $currency, 'y', 'n', 'all',$start, $end);

               $div .='<tr>

                       <td width="38%">'.$currency.' '.$paymentmethod.'</td>

                       <td width="38%">'.$payment_vatable   .'</td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataExcel/no_caccount_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >CSV</a></td>

                       <td width="12%"><a href="'.main_url.'payment_sales_audit/exportDataPDF/no_caccount_vatexempts/'.$paymentmethod.'/'.$currency.'/'.$status;

                    if($start != NULL)

                    {

                        $div.='/'.$start;

                    }

                    if($end != NULL)

                    {

                         $div.='/'.$end;

                    }

                  $div.='" target="_blank" >PDF</a></td>



                  </tr>';

            /*}

            $div .= '</table>';*/

        }

        $div .= '</div>';

        $div .= '<table class="audit-table-red text-bold">

                                            <tr>

                                                <td width="38%">TOTAL</td>

                                                <td width="38%"></td>

                                                <td width="12%"></td>

                                                <td width="12%">£'.$total.'</td>

                                            </tr>

                                        </table>';

        return $div;

    }
    function exportDataExcel($method, $paymentMethod, $currency,$status, $start_date=NULL, $end_date=NULL ){
        header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=payment_sales_audit.xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");

        echo '<table border="1">';
        echo '<tr>
          <th colspan="11" style="text-align:center;">Payment Sales Audit ';
            if(!empty($start_date))
                echo $start_date;
        
            if(!empty($end_date))
                echo ' - '.$end_date;
             echo '</th>
            </tr>';
        //make the column headers what you want in whatever order you want

        echo '<tr>
                 <th>Order No</th>
                <th>Payment / </br>Refund Date</th>
                <th>Source</th>
                <th>Customer</th>
                <th>Billing </br>PCode</th>
                <th>Delivery </br>PCode</th>
                <th>Billing Country</th>
                <th>Payment Method</th>
                <th>Order Price</th>
                <th>Exchange Rate</th>
                <th>Currency</th>
            </tr>';

        //loop the query data to the table in same order as the headers
        if($start_date){
            $start = $start_date;
        }
        else
        {
            $start = NULL;
        }
        if($end_date){
            $end = $end_date;
        }
        else
        {
            $end = NULL;
        }
        if($method == 'payment_vatables'){

            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'all', $start, $end,$status);
        }
        elseif($method == 'payment_vatexempts'){

            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'all', $start, $end,$status);
        }
        elseif($method == 'no_payment_vatables'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'ALL', $start, $end,$status);
        }
        elseif($method == 'no_payment_vatexempts'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'ALL', $start, $end,$status);
        }
        elseif($method == 'sale_vatables'){

            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'payment', $start, $end,$status);
        }
        elseif($method == 'sale_vatexempts'){

            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'payment', $start, $end,$status);
        }
        elseif($method == 'no_sale_vatables'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'payment', $start, $end,$status);
        }

        elseif($method == 'no_sale_vatexempts'){

            $orders  = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'payment', $start, $end,$status);
        }
        elseif($method == 'caccount_vatables'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'credit', $start, $end,$status);
        }
        elseif($method == 'caccount_vatexempts'){
            $orders  = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'credit', $start, $end,$status);
        }
        elseif($method == 'no_caccount_vatables'){

           $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'credit', $start, $end,$status);
        }
        elseif($method == 'no_caccount_vatexempts'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'credit', $start, $end,$status);
        }

        /*$orders = $this->payment_sales_audit_model->getOrderDetail('y', 'n', 'all', $start, $end);*/
            foreach ($orders as $key => $order) {
                
                 if(is_numeric($order->Source)){
                    $query = $this->db->query("Select UserName from customers where customers.UserID =".$order->Source."");
                    $row = $query->row_array();
                    $order->Source =  $row['UserName'];
                  } 
        
                echo '<tr>';
                echo '<td>'.(empty($order->OrderNumber) ? '' : $order->OrderNumber).'</td>';
                 if(!empty($order->PaymentDate)){
                   echo '<td>'.date('d/m/Y', $order->PaymentDate).'</td>';
                 }
                 else{
                  echo '<td>N/A</td>';
                }
                echo '<td>'.(empty($order->Source) ? '' : $order->Source).'</td>';

                echo '<td>'.(empty($order->BillingFirstName) ? '' : $order->BillingFirstName).' '.(empty($order->BillingLastName) ? '' : $order->BillingLastName).'</td>';

                echo '<td>'.(empty($order->BillingPostcode) ? '' : $order->BillingPostcode).'</td>';



                echo '<td>'.(empty($order->DeliveryPostcode) ? '' : $order->DeliveryPostcode).'</td>';

                echo '<td>'.(empty($order->BillingCountry) ? '' : $order->BillingCountry).'</td>';

                echo '<td>'.(empty($order->PaymentMethods) ? '' : $order->PaymentMethods).'</td>';

                echo '<td>'.(empty($order->OrderTotal) ? '' : $order->OrderTotal).'</td>';

                echo '<td>'.(empty($order->exchange_rate) ? '' : $order->exchange_rate).'</td>';

                echo '<td>'.(empty($order->currency) ? '' : $order->currency).'</td>';



                echo '</tr>';

            }
            

        echo '</table>';

    }

     function exportDataPDF($method, $paymentMethod, $currency,$status ,$start_date=NULL, $end_date=NULL){
        $this->load->library('m_pdf');
        $data['title']="Payment Sales Audit";
        echo '<table border="1">';
         echo '<tr>
  <th colspan="11" style="text-align:center;">Payment Sales Audit ';
   if(!empty($start_date))
        echo $start_date;

    if(!empty($end_date))
        echo ' - '.$end_date;
   echo '</th>
 </tr>';
        echo '<tr>
              <th>Order No</th>

                <th>Payment / </br>Refund Date</th>

                <th>Source</th>

                <th>Customer</th>

                <th>Billing </br>PCode</th>

                <th>Deliveryyyyyy </br>PCode</th>

                <th>Billing Country</th>

                <th>Payment Method</th>

                <th>Order Price</th>

                <th>Exchange Rate</th>

                <th>Currency</th>

            </tr>';

        //loop the query data to the table in same order as the headers
        if($start_date){
            $start = $start_date;
        }
        else
        {
            $start = NULL;
        }
        if($end_date){
            $end = $end_date;
        }
        else
        {
            $end = NULL;
        }
        /* payment */ 

        if($method == 'payment_vatables'){
            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'all', $start, $end,$status);
        }
        elseif($method == 'payment_vatexempts'){
            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'all', $start, $end,$status);
        }

        elseif($method == 'no_payment_vatables'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'ALL', $start, $end,$status);

        }

        elseif($method == 'no_payment_vatexempts'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'ALL', $start, $end,$status);

        }
        elseif($method == 'sale_vatables'){

            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'payment', $start, $end,$status);

        }

        elseif($method == 'sale_vatexempts'){

            $orders =$this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'payment', $start, $end,$status);

        }

        elseif($method == 'no_sale_vatables'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'payment', $start, $end,$status);

        }

        elseif($method == 'no_sale_vatexempts'){

            $orders  = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'payment', $start, $end,$status);

        }

        elseif($method == 'caccount_vatables'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'credit', $start, $end,$status);

        }

        elseif($method == 'caccount_vatexempts'){

            $orders  = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'credit', $start, $end,$status);

        }

        elseif($method == 'no_caccount_vatables'){

           $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'n', 'credit', $start, $end,$status);

        }

        elseif($method == 'no_caccount_vatexempts'){

            $orders = $this->payment_sales_audit_model->getOrderDetail($paymentMethod, $currency, 'y', 'y', 'credit', $start, $end,$status);

        }

         $data['orders']= $orders;
         $data['start_date'] = $start_date;
         $data['end_date'] = $end_date;
         $html=$this->load->view('pdf/payment_sales_audit',$data, true); 
         

      //load the pdf_output.php by passing our data and get all data in $html varriable.
     
        //this the the PDF filename that user will get to download

        $pdfFilePath ="payment_sales_audit-".time()."-Download.pdf";
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();

        //generate the PDF!
        $pdf->WriteHTML($html,2);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "D");
        /*$orders = $this->payment_sales_audit_model->getOrderDetail('y', 'n', 'all', $start, $end);*/

        foreach ($orders as $key => $order) {
            if(is_numeric($order->Source)){
                $query = $this->db->query("Select UserName from customers where customers.UserID =".$order->Source."");
                $row = $query->row_array();
                $order->Source =  $row['UserName'];
              } 
              
            echo '<tr>';
            echo '<td>'.(empty($order->OrderNumber) ? '' : $order->OrderNumber).'</td>';
            echo '<td>'.(empty($order->PaymentDate) ? '' : date('d-m-Y', $order->PaymentDate)).'</td>';
            echo '<td>'.(empty($order->Source) ? '' : $order->Source).'</td>';
            echo '<td>'.(empty($order->BillingFirstName) ? '' : $order->BillingFirstName).' '.(empty($order->BillingLastName) ? '' : $order->BillingLastName).'</td>';
            echo '<td>'.(empty($order->BillingPostcode) ? '' : $order->BillingPostcode).'</td>';
            echo '<td>'.(empty($order->DeliveryPostcode) ? '' : $order->DeliveryPostcode).'</td>';
            echo '<td>'.(empty($order->BillingCountry) ? '' : $order->BillingCountry).'</td>';
            echo '<td>'.(empty($order->PaymentMethods) ? '' : $order->PaymentMethods).'</td>';
            echo '<td>'.(empty($order->OrderTotal) ? '' : $order->OrderTotal).'</td>';
            echo '<td>'.(empty($order->exchange_rate) ? '' : $order->exchange_rate).'</td>';
            echo '<td>'.(empty($order->currency) ? '' : $order->currency).'</td>';
            echo '</tr>';
        }
        echo '</table>';

}
}