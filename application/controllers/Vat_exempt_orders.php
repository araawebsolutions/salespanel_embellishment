<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Vat_exempt_orders extends CI_Controller {
    public function __construct() {

        parent::__construct();

        $this->load->library('Datatables');

        $this->load->library('table');

        $this->load->database();
        $this->home_model->user_login_ajax();

    }

    function index() {
        $data['main_content'] = 'vat_exempt_orders';

        $this->load->view('page', $data); 
    }

    function getOrder() {
       $data= array();

       $post= array();

       if(!empty($this->input->post('start_date'))){

            $post['start_date'] = $this->input->post('start_date');
       }

       else
       {

            $post['start_date'] = '';

       }
       if(!empty($this->input->post('end_date'))){

            $post['end_date'] = $this->input->post('end_date');

       }
       else

       {

            $post['end_date'] = '';

       }

        $orders = $this->vat_exempt_orders_model->getOrder($post);
        foreach ($orders as $key => $order) {
            if($order->currency == 'GBP' )

                $sign = '&pound;';

            elseif($order->currency == 'EUR')

                $sign = '&euro;';

            elseif($order->currency == 'USD')

                $sign = '$';
           if(!empty($order->PaymentDate))
            {
             $date = date('d/m/Y', $order->PaymentDate);
            }
            else{
                $date= 'N/A' ;
            }

        
            $data['data'][$key][] = '<a href="'.main_url.'order_quotation/order/getOrderDetail/'.$order->OrderNumber.'" target="_blank">'.$order->OrderNumber.'</a>';

            $data['data'][$key][] = date('d/m/Y', $order->OrderDate);

            $data['data'][$key][] = $date;

            $data['data'][$key][] = $order->BillingCompanyName;

            $data['data'][$key][] = $order->BillingFirstName;

            $data['data'][$key][] = $order->BillingLastName;

            $data['data'][$key][] = $order->BillingCountry;

            $data['data'][$key][] = $order->VATNumber;

            $data['data'][$key][] = $order->currency;

            $data['data'][$key][] = $sign.$order->OrderTotal;

            $data['data'][$key][] = $sign.number_format(($order->OrderTotal/1.2),2,".",",");
        }
     echo json_encode($data); 
    }

    function exportExcel(){
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=vat_exempt_orders.xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");
        echo '<table border="1">';

        //make the column headers what you want in whatever order you want
        echo '<tr><th colspan="10" style="text-align:center;"> VAT Exempt ';
        if(!empty($this->input->post('start_date')))

        echo $start_date;
        if(!empty($this->input->post('end_date')))

            echo ' - '. $end_date;
            echo ' </th></tr>';
            echo '<tr><th>Order Number</th>

                    <th>Date

                    </th>

                    <th>Payment Date</th>

                    <th>Company Name</th>

                    <th>First Name</th>

                    <th>Last Name</th>

                    <th>Country</th>

                    <th>Customer VAT No</th>

                    <th>Order Value</th>

                    <th>Vat Exempt Value</th></tr>';

        //loop the query data to the table in same order as the headers
        $orders = $this->vat_exempt_orders_model->getOrder($this->input->post());

        foreach ($orders as $key => $order) {
            # code...

            echo '<tr>';

            echo '<td>'.$order->OrderNumber.'</td>';

            echo '<td>'.date('d/m/Y', $order->OrderDate).'</td>';

            if(!empty($order->PaymentDate))

            echo '<td>'.date('d/m/Y', $order->PaymentDate).'</td>';

            else
            echo '<td>N/A</td>';

            echo '<td>'.$order->BillingCompanyName.'</td>';

            echo '<td>'.$order->BillingFirstName.'</td>';

            echo '<td>'.$order->BillingLastName.'</td>';

            echo '<td>'.$order->BillingCountry.'</td>';

            if(!empty($order->VATNumber))

            echo '<td>'.$order->VATNumber.'</td>';

            else
            echo '<td>N/A</td>';

            echo '<td>'.$order->OrderTotal.'</td>';

            echo '<td>'.number_format(($order->OrderTotal/1.2),2,".",",").'</td>';

            echo '</tr>';

        }
        echo '</table>';

    }

    function exportPDF(){
        //load mPDF library

        $this->load->library('m_pdf');

        //load mPDF library

        $data['title']="VAT Exempt";

        $orders = $this->vat_exempt_orders_model->getOrder($this->input->post());

        $data['orders']= @$orders;

        $data['start_date'] = @$this->input->post('start_date');

        $data['end_date'] = @$this->input->post('end_date');
        $html=$this->load->view('pdf/vat_exempt_orders',$data, true); 

        //load the pdf_output.php by passing our data and get all data in $html varriable.

        //this the the PDF filename that user will get to download

        $pdfFilePath ="Vat_Exempt_Order-".time()."-Download.pdf";
        //actually, you can pass mPDF parameter on this load() function

        $pdf = $this->m_pdf->load();

        //generate the PDF!

        $pdf->WriteHTML($html,2);

        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "D");
    }
}