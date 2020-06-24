<table border="1" style="border: 1px solid #000; padding: 0; margin: 0;" cellpadding="0" cellspacing="0" width="100%">

<tr>

    <th colspan="10" style="text-align:center;">

   VAT Exempt 

    <?php

    if(!empty($start_date))
    {
    	echo $start_date;
    }

    if(!empty($end_date))
    {
    	echo ' - '.$end_date;
	}

	?>

</th>

</tr>

<tr>

	<th>Order Number</th>
    <th>Date</th>
    <th>Payment Date</th>
    <th>Company Name</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Country</th>
    <th>Customer VAT No</th>
    <th>Order Value</th>
    <th>Vat Exempt Value</th>
</tr>

<?php
foreach ($orders as $key => $order) { 
?>
<tr>
    <td><?=@$order->OrderNumber ?></td>
    <td><?php
    if(!empty($order->OrderDate))
    { 
    	echo date('d/m/Y', @$order->OrderDate);
    }
    else{
        echo 'N/A';
     } ?></td>
    <td><?php
    if(!empty($order->PaymentDate))
    { 
    	echo date('d/m/Y', @$order->PaymentDate);
    }
    else{
    	echo 'N/A';
     } ?></td>
    <td><?=@$order->BillingCompanyName ?></td>
    <td><?=@$order->BillingFirstName ?></td>
    <td><?=@$order->BillingLastName ?></td>
    <td><?=@$order->BillingCountry ?></td>
    <td><?php
    if(!empty($order->VATNumber))
    { 
	echo $order->VATNumber;
    }
    else
    {
	echo 'N/A';
    }
    ?></td>
    <td><?=@$order->OrderTotal ?></td>
    <td><?=number_format((@$order->OrderTotal/1.2),2) ?></td>
</tr>
<?php
}
?>
</table>