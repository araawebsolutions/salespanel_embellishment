<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Foreign_currency_orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->home_model->user_login_ajax();
        $this->load->library('form_validation');
    }

    
     
    function index() {
        $data['main_content'] = 'foreign_currency_orders';
        $this->load->view('page', $data); 
    }

    function getOrder() {
        $data= array();
      
        $orders = $this->foreign_currency_model->getOrder($this->input->post());
        foreach ($orders as $key => $order) {
                if(!empty($order->BalanceDate)){
                    $BalanceDate = date('d/m/Y', $order->BalanceDate);
                }
                else{
                    $BalanceDate = '';
                }
                $total = $order->coversion_rate;
                if(empty($total)){
                    $total = '0.00';
                }

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
            
            if(is_numeric($order->Source)){
                $query = $this->db->query("Select UserName from customers where customers.UserID =".$order->Source."");
                $row = $query->row_array();
                $order->Source =  $row['UserName'];
           } 

                $data['data'][$key][] = '<a href="'.main_url.'order_quotation/order/getOrderDetail/'.$order->OrderNumber.'" target="_blank">'.$order->OrderNumber.'</a>';
                $data['data'][$key][] = $date;
                $data['data'][$key][] = $order->Source;
                $data['data'][$key][] = $order->BillingFirstName.' '.$order->BillingLastName;
                $data['data'][$key][] = $order->BillingPostcode;
                $data['data'][$key][] = $order->DeliveryPostcode;
                $data['data'][$key][] = $order->BillingCountry;
                $data['data'][$key][] = $order->PaymentMethods;
                $data['data'][$key][] = $order->currency;
                $data['data'][$key][] = '<span class="conversions-span" style="float: left; width: 90px;">'.$sign.$order->OrderTotal.'</span>';
                $data['data'][$key][] = '<span class="conversions-span" style="padding: 0px !important"><label style="float:left; margin-top:0.2rem;"></label><input type="text" class="form-control p-amount remove_input_field_design" placeholder="'.$order->Balance.'"  style="display: inline;width: 85%; text-align: left;" id="amount_'.$order->OrderID.'" value="'.$order->Balance.'" onfocus="" onchange="sumTotalVal(`'.$order->OrderTotal.'`, `total_'.$order->OrderID.'`, this.value)" readonly /><input type="hidden" class="form-control p-amount remove_input_field_design" placeholder="'.$order->Balance.'"  style="display: inline;width: 85%; text-align: left;" id="amounth_'.$order->OrderID.'" value="'.$order->Balance.'" onfocus="" onchange="sumTotalVal(`'.$order->OrderTotal.'`, `total_'.$order->OrderID.'`, this.value)" readonly /></span>';
                
                $data['data'][$key][] = '<span class="conversions-span"><label class="input" style="margin-bottom: 0rem;"><i style="position: absolute; right: 14.5%;" class="fa fa-calendar-plus-o f-right adjust-calender" onfocus="showEditBtn(`edit_'.$order->OrderID.'`)"></i><input type="text" name="date_'.$order->OrderID.'" placeholder="Date" id="date_'.$order->OrderID.'" class="required remove_input_field_design" aria-required="true" onfocus="" value="'.$BalanceDate.'" style="border: none;color: #666 !important;background: transparent;"  disabled/></label></span>';
                $data['data'][$key][] = '<span class="conversions-span"><input type="text" class="form-control remove_input_field_design" placeholder="" style="display: inline;width: 100%; text-align: left;" id="total_'.$order->OrderID.'" value="'.number_format($total,5).'" readonly></span>';
                $data['data'][$key][] = '<span>
                <a style="font-weight: bold;text-decoration: underline;" class="edit editable" onclick="showEditBtn(`update_'.$order->OrderID.'`); showEditBtn(`update_'.$order->OrderID.'`, `amount_'.$order->OrderID.'`, `date_'.$order->OrderID.'`, `edit_'.$order->OrderID.'`)" id="edit_'.$order->OrderID.'" ><class="edit editable" onclick="showEditBtn(`cancel_'.$order->OrderID.'`); showEditBtn(`cancel_'.$order->OrderID.'`, `amounth_'.$order->OrderID.'`, `date_'.$order->OrderID.'`, `edit_'.$order->OrderID.'`)" id="edit_'.$order->OrderID.'" >Edit
                </a>&nbsp;
                </span>

                                        <span>
                                        <a class="edit editable" onclick="updartdata('.$order->OrderID.');" id="update_'.$order->OrderID.'" style="display:none;font-weight: bold;text-decoration: underline;" >Update
                                        </a>&nbsp;
                                        <a class="edit editable" onclick="cancel_price(`'.$order->OrderTotal.'`,'.$order->OrderID.')";" id="cancel_'.$order->OrderID.'" style="display:none;font-weight: bold;text-decoration: underline;" >Cancel
                                        </a>
                                        </span>
  <script>
    $(function() {
      $("#date_'.$order->OrderID.'").datepicker({
        autoHide: true,
        zIndex: 2000,
         format: "dd/mm/yyyy"
      });
    });
	
	function cancel_price(rate,id)
    {   
        var org = $("#amounth_" + id).val();
        var re = eval(rate) / eval(org);
        re = re.toFixed(5);
        if(re == Infinity)
            re = "0.0000"; 
         $("#total_" + id).val(re);
         $("#amount_" + id).val(org);
         $("#update_" + id).hide();
         $("#cancel_" + id).hide();
         $("#amount_" + id).addClass("remove_input_field_design").removeClass("input_field_design");
         $("#date_" + id).addClass("remove_input_field_design").removeClass("date-foreign-currency-input");
         $("#edit_" + id).show();

    
    }
  </script>';

            }
        echo json_encode($data); 
 
    }

    function updateOrder(){
        if($this->input->post('Balance') != '')
        {

            if($this->input->post('BalanceDate') != '' )
            {
                $d = explode('/', $this->input->post('BalanceDate'));
                $postdate = $d[2].'-'.$d[1].'-'.$d[0];
                $postdate = strtotime($postdate);
                $updateData = array(
                    'Balance'   => $this->input->post('Balance'),
                    'BalanceDate' => $postdate
                );
                $where =  $this->input->post('OrderID');
                if($this->foreign_currency_model->updateExchangeRate($updateData, $where)){
                   echo "Updated Successfully"; 
                }
                else
                {
                    echo "Not Updated Successfully";
                }
            }
            else
            {
                echo "Required Date Value";
            }
        }
        else
        {
            echo "Required Balance";
        }
    }

function exportExcel(){


header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=foreign_currency_orders.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");


echo '<table border="1">';
//make the column headers what you want in whatever order you want
echo '<tr>
        <th colspan="9" style="text-align:center;">Foreign Currency Orders ';
if(!empty($this->input->post('start_date')))
    echo $this->input->post('start_date');

if(!empty($this->input->post('end_date')))
    echo ' - '.$this->input->post('end_date');
echo '</th>
    </tr>';
echo '<tr>
        <th>Order No</th>
        <th>Payment Date</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Company Name</th>
        <th>Currency</th>
        <th>Order Amount</th>
        <th>Conversion Rate</th>
       <th>Order Date</th>
        
    </tr>';
//loop the query data to the table in same order as the headers
$total_order = 0;

$total_gbp = 0;

$orders = $this->foreign_currency_model->getOrder($this->input->post());
        foreach ($orders as $key => $order) {
           
            $gbp = number_format($order->Balance, 2);
            $total_order = $total_order + $order->OrderTotal;

            $total_gbp = $total_gbp + $gbp; 
            # code...
            echo '<tr>';
            echo '<td>'.@$order->OrderNumber.'</td>';
             if(!empty($order->PaymentDate))
                echo '<td>'.date('d/m/Y', $order->PaymentDate).'</td>';
             else
                echo '<td>N/A</td>';
           
            echo '<td>'.@$order->BillingFirstName.'</td>';
            echo '<td>'.@$order->BillingLastName.'</td>';
            echo '<td>'.@$order->BillingCompanyName.'</td>';
            echo '<td>'.@$order->currency.'</td>';
            echo '<td>'.number_format(@$order->OrderTotal, 2).'</td>';
            echo '<td>'.number_format(@$order->coversion_rate, 5).'</td>';
            echo '<td>'.date('d/m/Y', @$order->OrderDate).'</td>';
            echo '</tr>';
        }
echo '<tr>';
echo '<td colspan="6" style="text-align:center">Total</td>';
echo '<td>'.number_format(@$total_order, 2).'</td>';
echo '<td>&nbsp;</td>';
echo '</tr>';
echo '</table>';
}



function exportPDF(){
//load mPDF library
        $this->load->library('m_pdf');
        //load mPDF library
        $data['title']="Foreign Currency Order";
        $orders = $this->foreign_currency_model->getOrder($this->input->post());
        $data['orders']= @$orders;
        $data['start_date'] = @$this->input->post('start_date');
        $data['end_date'] = @$this->input->post('end_date');

        $html=$this->load->view('pdf/foreign_currency_orders',$data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
     
        //this the the PDF filename that user will get to download
        $pdfFilePath ="Foreign_Currency_Order-".time()."-Download.pdf";

        
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        //generate the PDF!
        $pdf->WriteHTML($html,2);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "D");
}
    
}