<table border="1" style="border: 1px solid #000; padding: 0; margin: 0;" cellpadding="0" cellspacing="0" width="100%">

<tr>

    <th colspan="9" style="text-align:center;">

    Foreign Currency Orders 

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

    <th>Order No</th>
 <th>Payment Date</th>
   

    <th>First Name</th>

    <th>Last Name</th>

    <th>Company Name</th>

    <th>Currency</th>

    <th>Order Amount</th>

    <th>Conversion Rate</th>
 <th>Order Date</th>
   

</tr>

<?php

$total_order = 0;

$total_gbp = 0;

foreach ($orders as $key => $order) {

	$gbp = $order->Balance;

    $total_order = $total_order + $order->OrderTotal;

	$total_gbp = $total_gbp + $gbp; 

?>

<tr>

    <td><?=@$order->OrderNumber ?></td>
<td><?php

    if(!empty($order->PaymentDate))
    { 
        echo date('d/m/Y', @$order->PaymentDate);
    }
    else{

        echo 'N/A';
     } ?>
         
    </td>
    

    <td><?=@$order->BillingFirstName ?></td>

    <td><?=@$order->BillingLastName ?></td>

    <td><?=@$order->BillingCompanyName ?></td>

    <td><?=@$order->currency ?></td>

    <td><?=@$order->OrderTotal ?></td>

    

    <td><?=number_format(@$order->coversion_rate, 5) ?></td>
    
<td><?php

    if(!empty($order->OrderDate))

    { 

        echo date('d/m/Y', @$order->OrderDate);

    }

    else{

        echo 'N/A';



     } ?></td>
</tr>

<?php

}

?>

<tr>

	<td colspan="6" style="text-align:center">Total</td>

	<td><?=number_format(@$total_order, 2) ?></td>

	<td>&nbsp;</td>
    <td>&nbsp;</td>

</tr>

</table>