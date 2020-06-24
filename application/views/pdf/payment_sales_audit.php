<table border="1" width="100%">
<tr>

  <th colspan="11" style="text-align:center;">Payment Sales Audit 
<?php 
 if(!empty($start_date))
        echo $start_date;

    if(!empty($end_date))
        echo ' - '.$end_date;
    ?>

</th>
 </tr>
 <tr>
    <th>Order No</th>

    <th>Payment Date</th>

    <th>Source</th>

    <th>Customer</th>

    <th>Billing </br>PCode</th>

    <th>Delivery </br>PCode</th>

    <th>Billing Country</th>

    <th>Payment Method</th>

    <th>Order Price</th>

    <th>Exchange Rate</th>

	<th>Currency</th>

</tr>

<?php

foreach ($orders as $key => $order) {
    
      if(is_numeric($order->Source)){
        $query = $this->db->query("Select UserName from customers where customers.UserID =".$order->Source."");
        $row = $query->row_array();
        $order->Source =  $row['UserName'];
      } 

?>        

<tr>

	<td><?=(empty($order->OrderNumber) ? '' : $order->OrderNumber) ?></td>

	<td><?php 
        if(!empty($order->PaymentDate))
        { 
            echo date('d/m/Y', @$order->PaymentDate);
        }
        else{

            echo 'N/A';
         } 
    ?>
             
    </td>

	<td><?=(empty($order->Source) ? '' : $order->Source) ?></td>

	<td><?=(empty($order->BillingFirstName) ? '' : $order->BillingFirstName) ?></td>

	<td><?=(empty($order->BillingPostcode) ? '' : $order->BillingPostcode) ?></td>

	<td><?=(empty($order->DeliveryPostcode) ? '' : $order->DeliveryPostcode) ?></td>

	<td><?=(empty($order->BillingCountry) ? '' : $order->BillingCountry) ?></td>

	<td><?=(empty($order->PaymentMethods) ? '' : $order->PaymentMethods) ?></td>

	<td><?=(empty($order->OrderTotal) ? '' : $order->OrderTotal) ?></td>

	<td><?=(empty($order->exchange_rate) ? '' : $order->exchange_rate) ?></td>

	<td><?=(empty($order->currency) ? '' : $order->currency) ?></td>

</tr>

<?php

}

?>

</table>