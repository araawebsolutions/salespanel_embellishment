
 <?php  //$total_attach = $this->Return_model->fetch_top_counter(); print_r($total_attach); ?>
<?  $start++; 
    foreach($result as $data){
    //print_r($result);
    //$total_attach = $this->return_model->fetch_total_attach($data->OrderNumber);
	// $comments = $this->return_model->fetch_order_comments_grouped($data->OrderNumber);
    $total_tickets_orders = $this->Return_model->fetch_tickets_order($data->ticket_id);
        
    $ticket_status = '<b>Open</b> – Under<p>Investigation</p>'; 
    if($data->ticketStatus=='2'){
        $ticket_status = '<b>Open</b> – <p>Awaiting Info from Customer</p>'; 
    }else if($data->ticketStatus=='3'){
        $ticket_status = '<b>Open</b> – <p>Reffered for Desicion,</p>'; 
    }else if($data->ticketStatus=='4'){
        $ticket_status = '<b>Open</b> – <p>Reffered back to Action</p>'; 
    }else if($data->ticketStatus=='5'){
        $ticket_status = '<b>Closed</b>'; 
    }
        $tPrice = 0;
        $sym = "&pound;";
        $arr = [];
    
	?>

    <?php foreach($total_tickets_orders as $orderNum){
        $tPrice += $orderNum->returnPrice; 
        
        if($orderNum->currency=="GBP"){ $sym = '&pound;';}
        else if($orderNum->currency=="EUR"){ $sym = '&euro;';}
        else if($orderNum->currency=="USD"){ $sym = '$';}
        
        
        
        if (!in_array($orderNum->OrderNumber, $arr)){
            array_push($arr,$orderNum->OrderNumber);
        }
    }?>
    
<tr class="artwork-tr">
    <td class="no-border"><span class="orange-text">1010 <i class="fa fa-bell red-bell"></i></span></td>
    <td class="no-border">
        <?php foreach($arr as $orderNum){?>
        <?php echo $orderNum; echo'<br>'; ?>
        <?php }?>
    </td>
    <td class="no-border">Printed Sheet<p><b>( PETP )</b></p></td>
    <td class="no-border"><?php echo date('d/m/Y',strtotime($data->create_date)); ?><p><b>( Andy Coles )</b></p></td>
    <td class="no-border">
        <?php foreach($total_tickets_orders as $orderNum){?>
        <?php echo $orderNum->BillingFirstName.' '.$orderNum->BillingLastName ?><p><b>( <?php echo $orderNum->BillingCountry ?> )</b></p>
        
        <?php break; }?>
        
    </td>
    <td class="no-border">Carol<p><b>( <?php echo date('d/m/Y',strtotime($data->reffTo)); ?> )</b></p></td>
    <td class="no-border"><b><?php echo date('d/m/Y',strtotime($data->followUpDate)); ?> - </b><p><b class="orange-text">View Comments</b></p></td>
    <td class="no-border"><b>Customer Care</b> <p><b class="orange-text">View Notes</b></p></td>
    
    
    
    <td class="no-border"><span class="comment-text"><?php echo $sym.$tPrice ?> </span></td>
    <td class="no-border"><?php echo $ticket_status?>
        <?php if($data->ticketStatus=='5'){ ?>
        <?php echo date('d/m/Y',strtotime($data->closed_date)); ?>
        <?php }?>
        <p></p></td>
    <td class="no-border">
        <span class="orange-text" data-toggle="modal" data-target=".bs-example-modal-lg">1 Comment</span>
        <!--<div class="btn-group dropdown"><button type="button" class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn">More ...</button></div>-->
    </td>
</tr>
<tr style="height:12px;"></tr>
<? $start++; } ?>
