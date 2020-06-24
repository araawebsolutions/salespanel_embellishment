<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="">


                           <!-- <style>
                                #dvLoading {
                                    margin-left: -80px;
                                }

                            </style>-->
                            <div role="main" class="container_12" id="content-wrapper">
                                <div id="main_content">
                                    <h2 class="grid_5" style="font-size: 20px;font-weight: bold;text-align: center;color: #666;"> Order Number# <?= $order_numer ?></h2>
                                    <div class="clean"></div>
                                </div>


                                <div class="grid_8 text-center">


                                    <div class="box">

                                        <div class="header">
                                            <!--<img width="16" height="16"
                                                 src="<?/*= base_url() */?>aalabels/img/table-excel.png">-->
                                            <h3 style="    font-size: 15px;font-weight: bold;color: #666;">Pay with Credit/Debit Card </h3>
                                        </div>
                                        <div class="content">


                                            <div id="orderSummaryContainer">
                                                <? if (isset($payment_error) and $payment_error != '') { ?>
                                                    <h3><?= $payment_error ?></h3>
                                                <? } ?>
                                                <table class="user_orders_view " width="25%" align="center" border="0" cellspacing="0">
                                                    <tbody>
                                                    <tr class="">
                                                        <th>Order summary
                                                            (<?= $order_numer ?>)
                                                        </th>
                                                    </tr>















                                                    <tr class="artwork-tr odd">
                                                        <td >
                                                            <p >
                                                                Subtotal</p>
                                                            <p ><?= $symbol . $total_amount ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr class="artwork-tr odd">
                                                        <td>
                                                            <p >
                                                                Total (<? echo $currency; ?>)</p>
                                                            <p ><?= $symbol . $total_amount; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div id="loader_div">
                                                                <p style="font-size: 19px;">Please wait while loading
                                                                    the Payment Page</p>
                                                            </div>
                                                            <form method="post" id="checkout_form" class="labels-form "
                                                                  action="">
                                                                <div id="paypal_div"
                                                                     style="display:none; ">
                                                                    <div id='paymentSection'></div>


                                                                    <div class="row">
                                                                        <div class="actions-right" style="text-align: center;width: 100%;">
                                                                            <img style="display:none;"
                                                                                 id="form_processing"
                                                                                 src="<?= ASSETS?>assets/images/33.gif">
																			
																			<?php $ord = $this->input->get('orderNumber'); 
																			if($ord==""){
																				$ord =  $order_numer;
																			}
																			
																			?>
																			
																			<a href="<?= main_url ?>order_quotation/order/getOrderDetail/<?php echo $ord ?>" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1"><i class="fa fa-arrow-circle-left"></i> Back
                                                                                
                                                                            </a>
																			
																			
                                                                            <button type="button" id="worlpaybtn"
                                                                                    style="display:none"
                                                                                    class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Pay
                                                                                Now
                                                                                <i class="fa fa-arrow-circle-right"></i>
                                                                            </button>
																			
																			
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>


                                                    </tbody>
                                                </table>

                                            </div>


                                        </div>
                                    </div>


                                </div>

                                <script>

                                    $(document).ready(function (e) {
                                        $("#loader_div").show();
                                        setTimeout(show_and_hide, 1000);

                                    });

                                    function show_and_hide() {
                                        $("#loader_div").hide();
                                        $("#paypal_div").show();
                                        //$(".alert-message").fadeOut('slow');

                                    }

                                    function cancel_paypal() {

                                        var a = confirm('Are you sure you want to Cancel the Order?');
                                        if (a == true) {
                                            window.location.href = base + "shopping/paypal_cancel";
                                        } else {
                                            return false;
                                        }


                                    }


                                    window.onload = function () {
                                        Worldpay.useTemplateForm({
                                            'clientKey': '<?=WP_Public_KEY?>',
                                            'form': 'checkout_form',
                                            'saveButton': false,
                                            'templateOptions': {
                                                images: {enabled: false},
                                                dimensions: {width: false, height: 265}
                                            },
                                            'paymentSection': 'paymentSection',
                                            'display': 'inline',  //modal inline
                                            'type': 'card',
                                            'callback': function (obj) {
                                                if (obj && obj.token) {

                                                    $('#worlpaybtn').hide();
                                                    $('#form_processing').show();

                                                    var _el = document.createElement('input');
                                                    _el.value = obj.token;
                                                    _el.type = 'hidden';
                                                    _el.name = 'token';
                                                    document.getElementById('checkout_form').appendChild(_el);
                                                    document.getElementById('checkout_form').submit();

                                                } else {
                                                    document.getElementById('worlpaybtn').disabled = null;
                                                }
                                            },
                                            'beforeSubmit': function () {
                                                document.getElementById('worlpaybtn').disabled = true;
                                                return true;
                                            },
                                            'validationError': function (obj) {
                                                document.getElementById('worlpaybtn').disabled = null;
                                            },
                                        });
                                        $("#paymentSection").show();
                                        $("#worlpaybtn").show();
                                    }
                                    $('#worlpaybtn').click(function () {
                                        Worldpay.submitTemplateForm();
                                    });

                                </script>
                                <script src="https://cdn.worldpay.com/v1/worldpay.js"></script>


                            </div>
                        </div>
                    </div>

                    <!-- en row -->
                </div>
            </div>
        </div>























  

