<?php $currency_options = $this->cartModal->get_currecy_options();
$currency = (isset($_SESSION['currency']) and $_SESSION['currency'] != '') ? $_SESSION['currency'] : 'GBP';

$symbol = (isset($_SESSION['symbol']) and $_SESSION['symbol'] != '') ? $_SESSION['symbol'] : '&pound;';
$exchange_rate = $this->cartModal->get_exchange_rate($currency);
?>

<div class="tab-content">
	<div class="tab-pane show active" id="home1">
		<div class="card-box no-padding">

			<div class="row m-t-t-10">

				<div class="col-md-6"><img src="../assets/images/logo.png" width="162" height="65" alt="Quotation Logo">
					<p class="adress-delivery">AA Labels, 23 Wainman Road, Peterborough, PE2 7BU</p>
				</div>


				<div class="col-md-6 delivery-info">
					<li><strong>Quotation #: AAQ12345</strong></li>
					<li>Phone Number: 01733 588 390</li>
						<li>Email Address: customercare@aalabels.com</li>
					<li>VAT #: GB 945 028 620</li>
				</div>
				

			</div>



			<div class="row m-t-t-10">
				<div class="col-md-4">
					<div class="card enquiry-card ">
						<div class="card-header card-heading-text-two">Invoice INFORMATION</div>
							<div class="card-body">
								<div class="col-sm-12 m-t-20 card-space-text">
									<dl class="row">
										
										<dt class="col-sm-5">Quotation Number:</dt>
										<dd class="col-sm-7"><?=$quotation[0]->QuotationNumber?></dd>
										<dt class="col-sm-5">Date:</dt>
										<dd class="col-sm-7"><?=date('jS F Y',$quotation[0]->QuotationDate)?></dd>
										<dt class="col-sm-5 text-truncate">Time:</dt>
										<dd class="col-sm-7"><?=date('h:m:s',$quotation[0]->QuotationDate)?> PM</dd>

										</div>
								</div>
						</div>
					</div>
					<div class="col-md-4">
							<div class="card enquiry-card">
								<div class="card-header card-heading-text-two">BILLING ADDRESS</div>
								<div class="card-body">
									<div class="col-sm-12 m-t-20 card-space-text">
										<dl class="row">
											
											<dt class="col-sm-5">Quotation Number:</dt>
											<dd class="col-sm-7"><?=$quotation[0]->QuotationNumber?></dd>
											<dt class="col-sm-5">Date:</dt>
											<dd class="col-sm-7"><?=date('jS F Y',$quotation[0]->QuotationDate)?></dd>
												<dt class="col-sm-5 text-truncate">Time:</dt>
											<dd class="col-sm-7"><?=date('h:m:s',$quotation[0]->QuotationDate)?> PM</dd>
											
										</dl>
									</div>
								</div>
								
						</div>
					</div>
					<div class="col-md-4">
						<div class="card enquiry-card">
							<div class="card-header card-heading-text-two">Delivery ADDRESS</div>
							<div class="card-body">
									<div class="col-sm-12 m-t-20 card-space-text">
										<dl class="row">
											<dt class="col-sm-5">Quotation Number:</dt>
											<dd class="col-sm-7"><?=$quotation[0]->QuotationNumber?></dd>
											<dt class="col-sm-5">Date:</dt>
												<dd class="col-sm-7"><?=date('jS F Y',$quotation[0]->QuotationDate)?></dd>
											<dt class="col-sm-5 text-truncate">Time:</dt>
											<dd class="col-sm-7"><?=date('h:m:s',$quotation[0]->QuotationDate)?> PM</dd>
										</dl>
								</div>
							</div>
							
						</div>
					</div>
				</div>







<?php


?>

            <div class="row m-t-t-10">
                <div class="col-12">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="card-heading-title">
                            <th class="text-center invoice-heading-text">Manufacturer ID</th>
                            <th class="text-center invoice-heading-text">Description</th>
                            <th class="text-center invoice-heading-text">Unit Price</th>
                            <th class="text-center invoice-heading-text">Quantity</th>
                            <th class="text-center invoice-heading-text">Ext.VAT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $extPrice = 0;
                        foreach ($quotationDetails as $key => $quotationDetail) {
                            $extPrice = $extPrice + ($quotationDetail->Price + $quotationDetail->Print_Total);
                            if ($quotationDetail->ManufactureID == 'SCO1') {
                                $carRes = $this->user_model->getCartQuotationData($quotationDetail->SerialNumber);
                                ?>
                                <tr>
                                    <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?></td>
                                    <td class="text-left">
                                        <b>Shape: </b><?= (isset($carRes[0])) ? $carRes[0]->shape : '' ?>|
                                        <b>Format: </b><?= (isset($carRes[0])) ? $carRes[0]->format : '' ?>|
                                        <b>Size: </b><?= (isset($carRes[0])) ? $carRes[0]->width : '' . ' mm *' ?><?= (isset($carRes[0]) && $carRes[0]->height == null) ? $carRes[0]->width . ' mm' : (isset($carRes[0])) ? $carRes[0]->height : '' . ' mm' ?>
                                        |
                                        <b>No.labels/Die: </b><?= (isset($carRes[0])) ? $carRes[0]->labels : '' ?>
                                        <b>Across: </b><?= (isset($carRes[0])) ? $carRes[0]->across : '' ?>
                                        |
                                        <b>Around: </b><?= (isset($carRes[0])) ? $carRes[0]->around : '' ?>
                                        | <b>Corner
                                            Radious: </b><?= (isset($carRes[0])) ? $carRes[0]->cornerradius : '' ?>
                                        |
                                        <b>Perforation: </b><?= (isset($carRes[0])) ? $carRes[0]->perforation : '' ?>

                                    </td>
                                    <td id="labels0">450</td>
                                    <td><?= $quotationDetail->Quantity ?></td>
                                    <td>£0.00</td>

                                </tr>
                                <?php
                                $scorecord = $this->user_model->fetch_custom_die_info($carRes[0]->ID);


                                $assoc = $this->user_model->getCartMaterial($carRes[0]->ID);
                                foreach ($assoc as $rowp){
                                    ?>
                                    <? $materialprice = $rowp->plainprice + $rowp->printprice; ?>
                                    <? $materialpriceinc = $materialprice * 1.2; ?>
                                    <tr>

                                        <td class="text-center labels-form"><?=$rowp->material?></td>
                                        <td><i class="mdi "></i><?= $this->user_model->get_mat_name($rowp->material); ?></td>
                                        <td id="labels0">-</td>
                                        <td><?= $rowp->qty ?></td>
                                        <td><?$symbol?><? echo(number_format($materialprice * $exchange_rate, 2)); ?></td>

                                    </tr>
                                <?php }?>
                            <?php }else{?>
                                <tr>
                                    <td></td>
                                    <td class="text-center labels-form"><?= $quotationDetail->ManufactureID ?></td>
                                    <td><?= $quotationDetail->ProductName ?></td>
                                    <td id="labels0"><?= $quotationDetail->Quantity * $quotationDetail->LabelsPerSheet ?></td>
                                    <td><?= $quotationDetail->Quantity ?></td>
                                    <td><?= $symbol ?><?= number_format($quotationDetail->Price * $exchange_rate, 2) ?></td>
                                    <td></td>


                                </tr>
                                <?php if($quotationDetail->Printing == 'Y'){?>
                                    <tr>
                                        <td class="text-center labels-form"></td>
                                        <td class="text-center labels-form"></td>
                                        <?php include(APPPATH . 'views/generate_text_line.php'); ?>
                                        <td id="labels0"></td>
                                        <td></td>
                                        <td></td>



                                    </tr>
                                <?php }?>
                            <?php }}?>
                        <tr>
                            <td>Delivery Service:</td>
                            <td><?= $symbol ?><?= number_format($quotation[0]->QuotationShippingAmount * $exchange_rate, 2) ?></td>
                        </tr>
                        <tr>
                            <td>Sub Total:</td>
                            <td><?= $symbol ?><?php $grandPrice = $extPrice + @$quotation[0]->QuotationShippingAmount;
                                echo number_format($grandPrice * $exchange_rate, 2) ?></td>
                        </tr>
                        <?php if ($quotation[0]->vat_exempt == 'yes') {
                            "<tr><td>VAT @ 20%:</td><td>£'. $grandPrice.'</td></tr>";
                        } else {
                            $grandPrice = $grandPrice * vat_rate;
                        }

                        ?>


                        <tr>
                            <td>Grand Total:</td>
                            <td><?= $symbol ?><?= number_format($grandPrice * $exchange_rate, 2) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-12 m-t-t-10">
                    <span class="pull-right">
                    <a href="<?=main_url?>order_quotation/order/pay_now_for_quotation/<?=$quotation[0]->QuotationNumber?>" class="btn btn-outline-dark waves-dark waves-effect btn-countinue btn-print1">PAY NOW <i class="mdi mdi-book-open"></i></a>
                    </span> </div>
</div>
    </div>
</div>

