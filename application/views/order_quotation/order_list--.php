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
      <span> <?= $data['customer'][0]['DeliveryAddress2'] ?></span></br>
  </div>
</div>
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
                    <?php foreach ($data['results'] as $key => $result) { 
						   $exchange_rate = $result['exchange_rate'];
						   $symbol = $this->orderModal->get_currecy_symbol($result['currency']);
						   $ordertotal =  $result['OrderTotal'] + @$result['OrderShippingAmount'];
						   $ordertotal = ($result['vat_exempt']=="yes")?$ordertotal/1.2:$ordertotal;
					 
					 ?>
                        <tr class="<?php if (fmod($key, 2) == 0) {
                            echo 'odd';
                        } ?>">
                            <td><a class="collapsed text-dark"
                                   onclick="getOrderProducts('<?= $result['OrderNumber'] ?>')" data-toggle="collapse"
                                   data-parent="#accordion" href="#<?= $result['OrderNumber'] ?>" aria-expanded="false"
                                   aria-controls="<?= $result['OrderNumber'] ?>"> <?= $result['OrderNumber'] ?></a></td>
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
                    <?php } ?>
                    </tbody>
                </table>

                <span>
                    Showing 1 to 10 of <?=$data['totalCount']?> entries


                </span>

                <?php
                $CI =& get_instance();
                $CI->load->model('pagination');
                $count = $data['totalCount'];

                $totalpages = ceil($count / 10);

                ?>

                <nav class="pull-right m-t-t-10 m-r-10">
                    <?= $html = $CI->pagination->paginate_function(10, 1, $count, $totalpages); ?>
                </nav>


            </div>
            <div class="col-md-2 border m-t-l-10 padding-3">
                <?php if(isset($data['orderHistory'][0])){?>
                <p class="previous-order-summary">Last Order
                    : <?= date('jS F Y', $data['orderHistory'][0]['orderDate']) ?>
                    £<?= $data['orderHistory'][0]['OrderTotal'] ?></p>
                <?php }?>
                <?php if(isset($data['spendToDate'][0])){?>
                <p class="previous-order-summary">Spend To Data :
                    £<?= $data['spendToDate'][0]['totalAmount'] ?> <?= $data['spendToDate'][0]['total'] ?> </p>
                <?php }?>
                <?php if(isset($data['sampleOrders'][0])){?>
                <p class="previous-order-summary">Sample Order : <?= $data['sampleOrders'][0]['sheet'] ?> *
                    Sheet <?= $data['sampleOrders'][0]['roll'] ?> * Roll </p>
                <?php }?>
                <?php if(isset($data['quotationConverted'][0])){?>
                <p class="previous-order-summary">Quotes To Data : <?= $data['quotationConverted'][0]['total'] ?>
                    Converted <?= $data['quotationConverted'][0]['conve'] ?></p>
                <?php }?>
                <?php if(isset($data['lifeTimeValue'][0])){?>
                <p class="previous-order-summary">Last Return : NAN</p>
                <p class="previous-order-summary">Life Time Value : £<?= $data['lifeTimeValue'][0]['OrderTotal'] ?></p>
                <?php }?>
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




