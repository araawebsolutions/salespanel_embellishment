<?php /*echo '<pre>'; print_r($data);exit;*/ ?>
<div class="tab-content m-t-14">
	<div class="tab-pane show active" id="home1">
		<div class="row no-margin min-500">
			<div class="col-md-2 border  m-t-r-10"><span class="address-heaidng">BILLING ADDRESS</span><br>
				<br>
				<span class="addrss-details"><?= $data['customer'][0]['BillingCompanyName'] ?>
					<?= $data['customer'][0]['BillingFirstName'] ?>. <?= $data['customer'][0]['BillingLastName'] ?>
					<?= substr($data['customer'][0]['BillingAddress1'], 0, 12) ?>
					<?= substr($data['customer'][0]['BillingAddress1'], 12, 24) ?>
					<?= substr($data['customer'][0]['BillingAddress1'], 24, 50) ?>
					<br><br>
					<span class="address-heaidng m-t-t-10" data-toggle="collapse" href="#collapseExample"
								aria-expanded="false" aria-controls="collapseExample">VIEW MORE DELIVERY ADDRESS</span>
                <div class="collapse" id="collapseExample">
									<div class="card card-body" style="padding: 6px 0 0 0;">
										<span> <?= $data['customer'][0]['BillingAddress2'] ?></span></br>
									<span> <?= $data['customer'][0]['DeliveryAddress1'] ?></span></br>
      <span> <?= $data['customer'][0]['DeliveryAddress2'] ?></span><br>
  </div>
</div>
                </span>
		
				
                 <span class="m-r-20">
                 <?php 
                     $user_id = $data['customer'][0]['UserID']; ?>
   <button type="button" class="btn btn-outline-pink waves-effect waves-light" onclick="edit_cus(<?= $user_id ?>)"style="width: 100%;margin-top: 10px;" >Edit Customer </button>
                 </span>

        <br>

        <span class="m-r-20">
                 <?php 
                     $user_id = $data['customer'][0]['UserID']; ?>
   <button type="button" class="btn btn-outline-pink waves-effect waves-light" onclick="edit_cus(<?= $user_id ?>)"style="width: 100%;margin-top: 10px;" >Convert Customer To Trade</button>
                 </span>
    <br>


<span  class="m-r-20"> 
       <button type="button" class="btn btn-outline-pink waves-effect waves-light" onclick="followup(<?= $user_id ?>);"style="width: 100%;margin-top: 10px;" >Follow Up Calls</button> 
        </span>


                   
                <p class="text-center">
                    <button type="button" onclick="getCustomer()"
                            class="btn btn-outline-pink waves-effect waves-light button-adjts-info"><i
                                class="mdi mdi-arrow-left-bold-circle"></i> Back
                    </button>
                </p>
            </div>
            <div class="col-md-8 border no-padding">
                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="table-headig">Order #</th>
                        <th class="table-headig">Date</th>
                        <th class="table-headig">Total</th>
                        <th class="table-headig">Payment Method</th>
                        <th class="table-headig">Status</th>
                        <th class="table-headig">Invoice</th>
                    </tr>
                    </thead>
                    <tbody>
											<?php $symbol = 0; //echo '<pre>'; print_r($data['results']); echo '</pre>'; ?>
                    <?php foreach ($data['results'] as $key => $result) {
	

                        $exchange_rate = $result['exchange_rate'];
                        $symbol = $this->orderModal->get_currecy_symbol($result['currency']);
                        $ordertotal = $result['OrderTotal'] + @$result['OrderShippingAmount'];
                        $ordertotal = ($result['vat_exempt'] == "yes") ? $ordertotal / 1.2 : $ordertotal;
                        
                        
                        $printcount = $this->db->query("select count(*) as total from orderdetails where OrderNumber LIKE '".$result['OrderNumber']."' and Printing LIKE 'Y' ")->row_array();
                        $trclass = ($printcount['total'] > 0)?"style='background-color:#c0e9f9  !important'":"";
                        ?>
                        
                        
                        
                        <tr class="<?php if (fmod($key, 2) == 0) { echo 'odd';} ?>" <?=$trclass?>>
                            <td>
                                
                               <!-- order_list -->
                              <a class="collapsed text-dark collapse-icon"
                                   onclick="getOrderProducts('<?= $result['OrderNumber'] ?>')" data-toggle="collapse"
                                   data-parent="#accordion" href="#<?= $result['OrderNumber'] ?>" aria-expanded="false"
                                   aria-controls="<?= $result['OrderNumber'] ?>"> <i id= "tbl_<?= $result['OrderNumber'] ?>" class="fa fa-minus-circle" aria-hidden="true"style="font-size: 13px;color: #333;"></i> <?= $result['OrderNumber'] ?>
                               </a>
                           
                           
                           </td>
                                   
                                   
                                   
                                   
                            <td><?= $result['orderDate'] ?></td>
                            <td><? echo $symbol . (number_format($ordertotal * $exchange_rate, 2, '.', '')); ?></td>
                            <td><?= $result['PaymentMethods'] ?></td>
                            <td><?= $result['StatusTitle'] ?></td>
                            <td>
                                <?php if ($result['invoice'] != null) { ?>
                                    <a href="<?= main_url ?>order_quotation/order/printInvoice?invoiceNumber=<?= $result['invoice'] ?>"
                                       class="btn btn-default btn-number pdf-download-btn fa-2x" rel="nofollow"
                                       data-toggle="tooltip" title="Download PDF Template" role="button"><i
                                                class="mdi mdi-file-pdf"></i></a>
                                <?php } ?>
                            </td>
                        </tr>

                        <tr id="<?= $result['OrderNumber'] ?>" apdtr="tr<?= $result['OrderNumber'] ?>" class="collapse"
                            aria-labelledby="<?= $result['OrderNumber'] ?>">

                        </tr>
                        <?php 
                            $prod = $this->orderModal->getOrderProducts($result['OrderNumber']);
                            include('order_product_list.php');
                        ?>
                        
                    <?php } ?>
                    </tbody>
                </table>
							
						<?php
                $CI =& get_instance();
                
                $CI->load->model('pagination');
                $count = $data['totalCount'];
                $start = $this->input->get('start');
                    
                if(isset($start) && $start!="") {
                    
                }else{
                    $start = 0;
                }
                                    
                $starts = $start * 10;
				$end;
                
                if($this->input->get('start')==""){
											
                    if($count <= 10 && $this->input->get('start')==""){
                        $start  = $count;
                    }else{
                        $start = 10;
                    }	
                    $end = 1;
					   			
                }else{
                    $start = $this->input->get('start') * 10; 
                    $start_prev = ($this->input->get('start') - 1) * 10; 
					   			
                    if($start > $count){
                        $start  = $count; 
                        $end = $start_prev + 1 ;
                    }else{
                        $end = $start - 9;
                    }	
								
                    
                }
                $totalpages = ceil($count / 10);
                ?>

                <span style="margin-left: 10px;float: left;margin-top: 17px;">
                    Showing <?php echo ($data['totalCount'] ==0)?'0':$end ?> to <?php echo $start; ?> of <?= $data['totalCount'] ?> entries
                </span>
							
                <nav class="pull-right m-t-t-10 m-r-10">
                    <?=$html = $CI->pagination->paginate_function(10, $this->input->get('start'), $count, $totalpages); ?>
                </nav>
                
							
						</div>
            <div class="col-md-2 border m-t-l-10 padding-3">
                <?php if (isset($data['orderHistory'][0])) { ?>
                    <p class="previous-order-summary">Last Order
                        : <?= date('jS F Y', $data['orderHistory'][0]['orderDate']) ?>
                        <?=$symbol ?><?= $data['orderHistory'][0]['OrderTotal'] ?></p>
                <?php } ?>
                <?php if (isset($data['spendToDate'][0])) { ?>
                    <p class="previous-order-summary">Spend To Date :
                        <?=$symbol ?><?= $data['spendToDate'][0]['totalAmount'] ?> <br> Orders: <?= $data['spendToDate'][0]['total'] ?> </p>
                <?php } ?>
                <?php if (isset($data['sampleOrders'][0])) { ?>
                    <p class="previous-order-summary">Sample Order : <?= $data['sampleOrders'][0]['sheet'] ?> *
                        Sheet <?= $data['sampleOrders'][0]['roll'] ?> * Roll </p>
                <?php } ?>
                <?php if (isset($data['quotationConverted'][0])) { ?>
                    <p class="previous-order-summary">Quotes To Data : <?= $data['quotationConverted'][0]['total'] ?>
                        Converted <?= $data['quotationConverted'][0]['conve'] ?></p>
                <?php } ?>
                <?php if (isset($data['lifeTimeValue'][0])) { ?>
                    <p class="previous-order-summary">Last Return:0</p>
                    <p class="previous-order-summary">Life Time Value :
                       <?=$symbol ?><?= $data['lifeTimeValue'][0]['OrderTotal'] ?></p>
                <?php } ?>
                <p class="text-center ">
                    <button type="button" onclick="getFormat()"
                            class="btn btn-outline-dark waves-light waves-effect button-adjts-info">
                        Proceed <i class="mdi mdi-arrow-right-bold-circle"></i></button>
                </p>
                
            


            </div>

            <input type="hidden" id="custId" value="<?= $data['customer'][0]['UserID'] ?>">
            <input type="hidden" id="count" value="<?= count($data['results']) ?>">

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel"

     aria-hidden="true">
</div>



<div class="modal fade" id="exampleModal3" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>
<div class="modal fade" id="exampleModal4" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>



<script  type="text/javascript">

    function convert_cus(id){
        $.ajax({
            type: "post",
            url: mainUrl+"order_quotation/order/convert_cus",
            cache: false,               
            data: {UserID:id},
            dataType: 'html',
            success: function(data)
            {                        
                $('#exampleModal3').html(data);
                $('#exampleModal3').modal('show');    
                
            },

            error: function(){                      
            alert('Error while request..');

        }
        });
    }

     function followup(id){
        $.ajax({
            type: "post",
            url: mainUrl+"order_quotation/order/follow_up",
            cache: false,               
            data: {UserID:id},
            dataType: 'html',
            success: function(data)
            {                        
                $('#exampleModal4').html(data);
                $('#exampleModal4').modal('show');    
                
            },

            error: function(){                      
            alert('Error while request..');

        }
        });
    }
</script>



