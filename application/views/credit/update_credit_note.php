<link href="<?php echo  ASSETS ?>assets/css/dropzone.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo  ASSETS ?>assets/js/dropzone.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>





<style>
    .byCustName {
        display: none;
    }
    .email_inputs{
        padding: 5px 10px;
    }
    .loading-gif{
        z-index: 1100 !important;
    }

    #slider-container {
        width:350px;
        margin-left:30px;
    }
    .red_color{
        border: 1px solid red !important;
    }

    .checkbox input[type="checkbox"]{
        top:0px !important;
        left: 0px !important;
        height: 21px;
        width: 19px;
    }

    #ticketImage{
        cursor: pointer;
    }
    .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
        display: block;
        height: 25px;
        width: 25px;
    }
    .dz-preview dz-processing dz-image-preview dz-success dz-complete{ width:15%;}
    .dropzone .btn { margin-top:10px; cursor:pointer;}
    .mat-ch .detail .cont .dropzone .dz-message .fa-upload {
        color: #fd4913;
        font-size: 33px;
    }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
        cursor: pointer;
    }
    .notes-table-header{
        background-color: #006da4;
        color: #FFFFff;
    }

    .btn-outline-dark:hover {
        border-color: #fd4913;
        background: transparent;
        color: #fd4913;
    }


    .disable_spinner {
        -moz-appearance: textfield !important;
    }
    .disable_spinner::-webkit-inner-spin-button {
        display: none !important;
    }
    .disable_spinner::-webkit-outer-spin-button,
    .disable_spinner::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }
    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }
</style>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header no-bg text-center">
                        <div class="col-md-6 center-page m-t-t-10">
                            <span class="returns-title">CREDIT NOTE FORM</span>
                            <hr>
                            <span class="return-title-text">Please Fill This Form To Add Enquiry</span>
                        </div>
                    </div>

                    <?php
                    $date = strtotime(date('Y-m-d h:i:s'));
                    $token =  md5(uniqid($date, true));
                    ?>

                    <div class="card-body">
                        <?/*= main_url */?><!--tickets/addTickets/findOrders"-->



                        <!--<div class="customer_info_div alert alerts-custom alert-dismissible fade show sweet-alert" role="alert" style="margin-bottom: 20px; display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div id="customer_info">

                            </div>
                        </div>-->


                        <?php if($result['ticketMains']){ ?>
                            <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert">

                                <span><b>Customer Name:</b> <?php echo $result['ticketMains']['Name']; ?></span> | <span><b>Address:</b> <?php echo $result['ticketMains']['address']; ?></span>
                                | <span><b>Email Address:</b> <?php echo $result['ticketMains']['BillingEmail']; ?></span> | <span><b>Phone Number:</b> <?php echo $result['ticketMains']['BillingTelephone']; ?></span>
                            </div>
                        <?php } ?>


                        <?php if ($this->session->flashdata('error_msg') != "") { ?>
                            <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <b style="color: red"><?php echo $this->session->flashdata('error_msg') ?></b>
                            </div>
                        <?php } ?>


                        <?php if ($this->session->flashdata('success_msg') != "") { ?>
                            <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <b style="color: #32CD32"><?php echo $this->session->flashdata('success_msg') ?></b>
                            </div>
                        <?php } ?>



                        <?php //$delivery_charges = 20; ?>




                        <table class="table table-bordered table-striped mb-0 returns-table dataTable list_data_update">
                            <thead>
                            <tr>
                                <th>Order #</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Post Code</th>
                                <th>Country</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <?php if($result['ticketMains']['cr_note_status'] == 0){ ?>
                                <th width="12%">Action</th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($result['ticketDetails'])
                            {
                                $total = 0;
                                $sub_total = 0;
                                $grand_total = 0;
                                $curr_symbol = '';
                                $vat = 0;
                                foreach($result['ticketDetails'] as $res)
                                { ?>

                                    <?php
                                    $digitalCheck = ($res['ProductBrand'] == 'Roll Labels') ? 'roll' : 'A4';

                                    $i = $res['cr_note_details_id'];
                                    $curr = $res['returnCurrency'];

                                    if($curr=="GBP"){ $sym = '&pound;';}
                                    else if($curr=="EUR"){ $sym = '&euro;';}
                                    else if($curr=="USD"){ $sym = '$';}


                                    ($res['orderNumber'])?$pr=0:$pr=-1;


                                    ?>
                                    <tr id="ticket_detail_row<?php echo $i; ?>">
                                        <td><?php echo ($res['orderNumber'])?$res['orderNumber']:'Custom Line'; ?></td>
                                        <td><?php echo $result['ticketMains']['BillingFirstName']; ?></td>
                                        <td><?php echo $result['ticketMains']['BillingLastName']; ?></td>
                                        <td><?php echo $result['ticketMains']['BillingPostcode']; ?></td>
                                        <td><?php echo $result['ticketMains']['BillingCountry']; ?></td>
                                        <td><span id="descriptionInput<?php echo $i; ?>" data-rowno="<?php echo $i; ?>" class="productDescription"><?php echo $res['productDescription']; ?></span></td>
                                        <td>
                                            <input data-qty="<?php echo $i; ?>" id="qtyInput<?php echo $i; ?>" type="number" class="qty_price_change form-control form-control-sm return-input qty" placeholder="123456" min="0" value="<?php echo $res['returnQty']; ?>" aria-controls="responsive-datatable">
                                            <input id="cr_note_details_id<?php echo $i; ?>" type="hidden" value="<?php echo $res['cr_note_details_id']; ?>" aria-controls="responsive-datatable">
                                            <input id="orderNumber<?php echo $i; ?>" type="hidden" value="<?php echo $res['orderNumber']; ?>" aria-controls="responsive-datatable">
                                            <input id="ManufactureID<?php echo $i; ?>" type="hidden" value="<?php echo $res['ManufactureID']; ?>" aria-controls="responsive-datatable">
                                        </td>

                                        <td>
                                            <div class="input-group" style="flex-wrap: unset; height: 2rem;">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background-color: #ffffff; border: 1px solid #d0effa;" id="basic-addon<?php echo $i; ?>"><?php echo $sym; ?></span>
                                                </div>
                                                <input data-inputPrice="<?php echo $i; ?>" type="text" value="<?php echo number_format($res['returnUnitPrice'], 2, '.', ''); ?>" id="total_price_with_vat<?php echo $i; ?>" placeholder="Enter Price" class="my_spinner qty_price_change form-control input-border-blue inputPrice disable_spinners" required>
                                                <input type="hidden" id="total_price_with_vat_old<?php echo $i; ?>" value="<?php echo $res['returnUnitPrice']; ?>">
                                            </div>
                                            <input type="hidden" data-currency="<?php echo $i ?>" value="<?php echo $res['returnCurrency']; ?>" disabled>
                                            <input type="hidden" data-SerialNumber="<?php echo $i ?>" value="<?php echo $res['serialNumber']; ?>">
                                        </td>
                                        <input type="hidden" data-Printing="<?php echo $i ?>" value="<?php echo $res['Printing']; ?>">
                                        <?php if($result['ticketMains']['cr_note_status'] == 0){ ?>
                                        <td>
                                            <button id="price_change_btn<?php echo $i ?>" onclick="price_change_func(<?php echo $i.','.$pr; ?>)" class="btn btn-outline-dark btn-sm disabledbutton">
                                                Calculate
                                            </button>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    //if($res['Printing'] == 'Y' && $res['ProductBrand'] != 'Roll Labels'){
                                    if($res['Printing'] == 'Y'){
                                    ?>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <?php if($res['returnQtyPrint'] > 0){
                                                    $returnQtyPrint = ' <span>'.$res["returnQtyPrint"].' Design</span> ';
                                                }else{
                                                    $returnQtyPrint = '';
                                                } ?>
                                                <?php if($res['ProductBrand'] != 'Roll Labels'){ ?>
                                                    <span id="descriptionInputPrint<?php echo $i; ?>" data-rowno="<?php echo $i; ?>" class="productDescriptionPrint">
                                                        <?php echo $res['productDescriptionPrint']; ?>,
                                                        <?php echo $returnQtyPrint; ?>
                                                    </span>
                                                <?php }else{ ?>
                                                    <span id="descriptionInputPrint<?php echo $i; ?>" data-rowno="<?php echo $i; ?>" class="productDescriptionPrint"><?php echo $res['productDescriptionPrint']; ?></span>
                                                    <?php echo $returnQtyPrint; ?>
                                                    <strong style="font-size:12px;"> Wound: </strong><span><?php echo $res['Wound']; ?></span>,
                                                    <strong style="font-size:12px;"> Orientation: </strong><span><?php echo $res['Orientation']; ?></span>,
                                                    <strong style="font-size:12px;"> Finish: </strong><span><?php echo $res['FinishType']; ?></span>,
                                                    <strong style="font-size:12px;"> Press Proof: </strong><span><?php echo ($res['pressproof']==1)?"Yes":"No"; ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $res['returnQtyPrint']; ?></p>
                                                <input data-qty="<?php echo $i; ?>" id="qtyInputPrint<?php echo $i; ?>" type="hidden" class="qty_price_change_print form-control form-control-sm return-input qty" placeholder="123456" min="0" value="<?php echo $res['returnQtyPrint']; ?>" aria-controls="responsive-datatable">
                                            </td>
                                            <td>
                                                <?php if($res['ProductBrand'] != 'Roll Labels'){ ?>
                                                    <p class="text-center"><?php echo $sym; ?> <?php echo number_format($res['returnPricePrint'], 2, '.', ''); ?></p>
                                                <div class="input-group">
                                                    <input data-inputPrice="<?php echo $i; ?>" type="hidden" value="<?php echo number_format($res['returnPricePrint'], 2, '.', ''); ?>" id="total_price_with_vat_print<?php echo $i; ?>" placeholder="Enter Price" class="qty_price_change_print form-control input-border-blue inputPrice" required>
                                                    <input type="hidden" id="total_price_with_vat_print_old<?php echo $i; ?>" value="<?php echo $res['returnPricePrint']; ?>">
                                                </div>
                                                <?php } ?>
                                            </td>
                                            <?php if($result['ticketMains']['cr_note_status'] == 0){ ?>
                                                <td>

                                                </td>
                                            <?php } ?>
                                        </tr>

                                    <?php } ?>



                                    <?php $i++;
                                    $total += ($res['returnUnitPrice'] + $res['returnPricePrint']);
                                    $curr_symbol = $sym;
                                }


                                $sub_total = $total + $result['delivery_charges'];
                                $vat = ($sub_total * vat_rate) - $sub_total;

                                if ($result['vat_exempt'] == 'yes') {
                                    $grand_total = $sub_total;
                                }else{
                                    $grand_total = $sub_total + $vat;
                                }


                                ?>

                            <?php } else{?>
                                <tr>
                                    <td colspan="10" style="text-align:center"> <p>Record not found</p></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tbody class="custom_line">
                            </tbody>
                            <tfoot>


                            <?php if($result['ticketMains']['cr_note_status'] == 0){
                                $extra_td = '<td></td>';
                            }else{
                                $extra_td = '';
                            }
                                 ?>

                            <?php if($result['proceeded_without_order'] == 0){ ?>
                                <tr class="totals">
                                    <td colspan="6"></td>
                                    <td class="invuice_subtotal"><b>Delivery: </b></td>
                                    <td align="" class="invuice_subtotal_price">
                                        <?php echo $curr_symbol ?>
                                        <span class="delivery_charges_span"><?php echo number_format($result['delivery_charges'], 2, '.', '') ?> </span>
                                    </td>
                                    <?php echo $extra_td ?>
                                </tr>
                            <?php } ?>

                            <tr class="totals">
                                <td colspan="6"></td>
                                <td class="invuice_subtotal"><b>Sub Total: </b></td>
                                <td align="" class="invuice_subtotal_price">
                                    <?php echo $curr_symbol ?>
                                    <span id="sub_total"> <?php echo number_format($sub_total, 2, '.', '');?></span>
                                </td>
                                <?php echo $extra_td ?>
                            </tr>
                            <?php if($result['proceeded_without_order'] == 0){
                                if ($result['vat_exempt'] == 'yes') {
                                    ?>
                                    <tr class="totals">
                                        <td colspan="6"></td>
                                        <td class="invuice_subtotal"><b>VAT Exempt:</b></td>
                                        <td align="" class="invuice_subtotal_price"><?php echo  "-".$curr_symbol ?>
                                            <span id="vat_total"> <?php echo number_format($vat, 2,'.', '');?></span>
                                        </td>
                                        <?php echo $extra_td ?>
                                    </tr>

                                <?php }else{ ?>

                                    <tr class="totals">
                                        <td colspan="6"></td>
                                        <td class="invuice_subtotal"><b>VAT @ (20.00)%:</b></td>
                                        <td align="" class="invuice_subtotal_price"><?php echo $curr_symbol ?>
                                            <span id="vat_total"> <?php echo number_format($vat, 2,'.', '');?></span>
                                        </td>
                                        <?php echo $extra_td ?>
                                    </tr>
                                <?php }}else{ ?>
                                <span style="display: none" id="vat_total">0</span>
                            <?php } ?>
                            <tr class="totals">
                                <td colspan="6"></td>
                                <td class="invuice_subtotal"><b>Grand Total:</b></td>
                                <td align="" class="invuice_subtotal_price">
                                    <b><?php echo $curr_symbol?>
                                        <span id="grand_total"><?php echo (number_format($grand_total, 2,'.',''));?></span>
                                    </b>
                                </td>
                                <?php echo $extra_td ?>
                            </tr>
                            </tfoot>
                        </table>



                        <br>
                        <br>

                        <div class="row">
                            <?php if($result['ticketMains']['cr_note_status'] == 0){ ?>
                                <div class="input-margin-10">
                                    <button type="button" onclick="add_custom_line()" class="btn btn-outline-info waves-light waves-effect p-6-27 " ><i class="fa fa-plus"></i> ADD CUSTOM LINE </button>
                                </div>
                            <?php } ?>

                            <?php if($result['ticketMains']['cr_note_status'] != 2){ ?>
                                <div class="input-margin-10">
                                    <button type="button" class="btn btn-outline-info waves-light waves-effect hintsbtn" data-toggle="modal" data-target=".add_new_notes_modal"><i class="fa fa-plus"></i>
                                        ADD NEW NOTES
                                    </button>
                                </div>
                            <?php } ?>



                            <?php if($result['ticketMains']['cr_note_status'] == 1 || $result['ticketMains']['cr_note_status'] == 3){ ?>
                                <div class="input-margin-10">
                                    <button type="button" class="btn btn-outline-info waves-light waves-effect hintsbtn" data-toggle="modal" data-target=".email_modal">
                                        <i class="fa fa-envelope"></i> EMAIL TO CUSTOMER
                                    </button>
                                </div>
                                <div class="input-margin-10">
                                    <button type="button" onclick="print_credit_note('<?php echo $this->uri->segment(3) ?>');" class="btn btn-outline-info waves-light waves-effect hintsbtn">
                                        <i class="fa fa-print"></i> PRINT CREDIT NOTE
                                    </button>
                                </div>
                            <?php } ?>
                        </div>



                        <form method="post" id="checkout_form" class="labels-form " enctype="multipart/form-data">

                            <input type="hidden" id="token" name="token" value="<?php echo $token?>">
                            <input type="hidden" id="order_details_data" name="orders_details">
                            <input type="hidden" id="operator_additional_notes_data" name="operator_additional_notes_data">
                            <input type="hidden" name="cr_note_id" value="<?php echo $this->uri->segment(3); ?>">

                            <br>
                            <div class="row float-right">
                                <a href="<?php echo main_url ?>credit-notes" id="back" class="btn btn-info waves-light waves-effect btn-countinue">
                                    BACK
                                </a>
                                <?php if($result['ticketMains']['cr_note_status'] == 0 && $this->session->userdata('UserTypeID') == 50){ ?>
                                    <button type="button" onclick="ticketActionPerformed(2, <?php echo $this->uri->segment(3); ?>)" id="decline" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                        DECLINE
                                    </button>
                                    <button type="button" onclick="ticketActionPerformed(1, <?php echo $this->uri->segment(3); ?>)" id="approve_generate" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                        APPROVE & GENERATE CREDIT NOTE
                                    </button>
                                <?php } ?>



                                <input type="hidden" id="gt_price_data" name="gt_price_data">

                                <?php if($result['ticketMains']['cr_note_status'] == 0){ ?>
                                    <button type="button" onclick="getAllValues()" id="sub" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                        UPDATE TICKET
                                    </button>
                                <?php } ?>

                            </div>
                            <input type="hidden" id="UserID" name="UserID" value="<?php echo $result['ticketMains']['UserID'] ?>">
                        </form>





                        <input type="hidden" id="proceeded_without_order_val" value="<?php echo $result['proceeded_without_order']?>">
                        <input type="hidden" id="vat_exempt_val" value="<?php echo $result['vat_exempt']?>">
                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>

<!-- en wrapper -->







<!-- Designer Checklist Popup Start -->

<div class="modal fade add_new_notes_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel" style="text-align: center !important;">Sale Operator Notes</h4>
                    <p class="timeline-detail text-center">Please enter your notes here</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-0 dataTable dataTable111">
                        <thead class="notes-table-header">
                        <tr>
                            <td>Sr.</td>
                            <td>Operator</td>
                            <td>Comments</td>
                            <td>Time</td>
                            <?php if($this->session->userdata('UserTypeID') == 50){ ?>
                            <td>Action</td>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $indx = 0;
                        foreach ($result['operatorNotes'] as $operatorNotes){
                            $indx+=1;
                            ?>
                            <tr id="notes_table_row<?php echo $indx ?>">
                                <td><?php echo $indx ?></td>
                                <td><?php echo $operatorNotes['UserName'] ?></td>
                                <td><?php echo $operatorNotes['operator_note'] ?></td>
                                <td><?php echo $operatorNotes['created_at'] ?></td>
                                <?php if($this->session->userdata('UserTypeID') == 50){ ?>
                                    <td>
                                        <button onclick="deleteOperatorAdditionalNote(<?php echo $operatorNotes['additional_note_id'] ?>)" class="btn btn-outline-dark btn-sm">
                                        Delete
                                        </button>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php }
                        ?>
                        </tbody>



                        <tbody id="additional_note_tbody">
                        </tbody>
                    </table>



                    <form method="post" id="add_new_notes_form" class="labels-form " enctype="multipart/form-data">
                        <input type="hidden" id="token" name="token" value="<?php echo $token?>">
                        <br>

                        <textarea class="form-control" placeholder=" Operator note here:" name="operator_note" id="operator_note"></textarea>
                        <span class="m-t-t-10 pull-right">
                            <button type="button" class="btn btn-outline-dark btn-outline-dark-close waves-light waves-effect btn-countinue btn-print1 p-6-27" data-dismiss="modal">
                                CLOSE
                            </button>
                            <button type="submit" id="add_new_notes_btn" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                SUBMIT
                            </button>
                        </span>
                        <div class="operator_note_val_div"></div>
                        <input type="hidden" name="cr_note_id" id="cr_note_id" value="<?php echo $this->uri->segment(3); ?>">
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade email_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel" style="text-align: center !important;">Email to Customer</h4>
                    <p class="timeline-detail text-center">Please enter your Subject & Message</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                    <?php if($result['email_logs']){ ?>
                    <table class="table table-bordered table-striped mb-0 dataTable">
                        <thead class="notes-table-header">
                        <tr>
                            <td>Sr.</td>
                            <td>Operator</td>
                            <td>Receiver</td>
                            <td>Email Sent At</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($result['email_logs'] as $email_logs){
                            ?>
                            <tr id="logs_table_row<?php echo $email_logs['LogID'] ?>">
                                <td><?php echo $email_logs['LogID'] ?></td>
                                <td><?php echo $email_logs['UserName'] ?></td>
                                <td><?php echo $email_logs['receiver_email'] ?></td>
                                <td><?php echo $email_logs['sent_at'] ?></td>
                            </tr>
                        <?php }
                        ?>
                        </tbody>
                    </table>
                    <?php } ?>



                    <form method="post" id="email_to_customer_form" class="labels-form " enctype="multipart/form-data">
                        <input type="hidden" id="token" name="token" value="<?php echo $token?>">
                        <div class="col-md-12">
                            <label for="email_subject" class="input">To:
                                <input type="text" class="form-control form-control-sm" value="<?php echo $result['ticketMains']['BillingEmail'] ?>" readonly>
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label for="email_subject" class="input">Subject:
                                <input type="text" class="form-control form-control-sm" placeholder="Email Subject" name="email_subject" id="email_subject">
                            </label>
                        </div>
                        <div class="col-md-12" style="height: 10px"></div>
                        <div class="col-md-12">
                            <label for="email_body" class="input">Body:
                                <textarea class="form-control form-control-sm email_inputs" placeholder="Yout Message here..." name="email_body" id="email_body"></textarea>
                            </label>
                        </div>

                        <span class="m-t-t-10 pull-right">
                            <button type="button" class="btn btn-outline-dark btn-outline-dark-close waves-light waves-effect btn-countinue btn-print1 p-6-27" data-dismiss="modal">
                                CLOSE
                            </button>
                            <button type="submit" id="email_to_customer_btn" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">
                                SEND
                            </button>
                        </span>
                        <div class="operator_note_val_div"></div>
                        <input type="hidden" name="cr_note_id" id="cr_note_id" value="<?php echo $this->uri->segment(3); ?>">
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script type="text/javascript">
    /*function price_change_func(i) {
        var rowNo = i;
        if($('#total_price_with_vat_old'+rowNo).val()){
            var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
        }else{
            var newTotalPrice_old = 0;
        }

        if($('#total_price_with_vat'+rowNo).val()){
            var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
        }else{
            var newTotalPrice = 0;
        }

        if(parseFloat($('#sub_total').text()) > 0){
            var sub_total = parseFloat($('#sub_total').text());
        }else{
            var sub_total = 0;
        }

        $('#sub_total').text((sub_total - newTotalPrice_old + newTotalPrice).toFixed(2));
        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
    }*/

    function price_change_func(i,p) {
        var rowNo = i;
        var brake = 0;

        //$('#price_change_btn'+rowNo).addClass('disabledbutton');

        if(p == 1 || p == 0){
            if(p==1){
                if($('#total_price_with_vat_print'+rowNo).val()){
                    var newTotalPrice = parseFloat($('#total_price_with_vat_print'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    $('#price_change_btn_print'+rowNo).removeClass('disabledbutton');
                    brake = 1;
                    var newTotalPrice = 0;
                }
                if($('#total_price_with_vat_print_old'+rowNo).val()){
                    var newTotalPrice_old = parseFloat($('#total_price_with_vat_print_old'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    $('#price_change_btn_print'+rowNo).removeClass('disabledbutton');
                    brake = 1;
                    var newTotalPrice_old = 0;
                }



                if($('#qtyInputPrint'+i).val()){
                    var qty = parseFloat($('#qtyInputPrint'+i).val());
                }else{
                    swal("", "Please enter quantity in numbers only", "warning");
                    $('#price_change_btn_print'+dataNo).removeClass('disabledbutton');
                    brake = 1;
                    var qty = 0;
                }
            }else{
                if($('#total_price_with_vat'+rowNo).val()){
                    var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    brake = 1;
                    $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                    var newTotalPrice = 0;
                }
                if($('#total_price_with_vat_old'+rowNo).val()){
                    var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                }else{
                    swal("", "Please enter price in numbers only", "warning");
                    brake = 1;
                    $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                    var newTotalPrice_old = 0;
                }





                if($('#qtyInput'+i).val()){
                    var qty = parseFloat($('#qtyInput'+i).val());
                }else{
                    swal("", "Please enter quantity in numbers only", "warning");
                    $('#price_change_btn'+dataNo).removeClass('disabledbutton');
                    brake = 1;
                    var qty = 0;
                }
            }





            var price = newTotalPrice;
            var dataNo = i;
            var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');
            checkMaxPrice(price, newTotalPrice_old, dataNo, SerialNumber, p, brake);
        }else{

            if(brake == 1) {
                $('#price_change_btn' + rowNo).removeClass('disabledbutton');
            }else{
                $('#price_change_btn' + rowNo).addClass('disabledbutton');
            }

            if($('#total_price_with_vat_old'+rowNo).val()){
                var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
            }else{
                swal("", "Please enter price", "warning");
                brake = 1;
                $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                var newTotalPrice_old = 0;
            }

            if($('#total_price_with_vat'+rowNo).val()){
                var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
            }else{
                swal("", "Please enter price", "warning");
                brake = 1;
                $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                var newTotalPrice = 0;
            }

            if(parseFloat($('#sub_total').text()) > 0){
                var sub_total = parseFloat($('#sub_total').text());
            }else{
                var sub_total = 0;
            }

            //$('#sub_total').text((sub_total - newTotalPrice_old + newTotalPrice).toFixed(2));



            if((sub_total - newTotalPrice_old + newTotalPrice) > 0){
                var new_sub_total = (sub_total - newTotalPrice_old + newTotalPrice);
            }else{
                var new_sub_total = 0;
            }
            $('#sub_total').text(new_sub_total.toFixed(2));


            var vat_total = 0;
            if($('#proceeded_without_order_val').val() == 0){
                if($('#vat_exempt_val').val() != 'yes'){
                    var vat_rate = '<?php echo vat_rate; ?>';
                    var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                }
            }
            $('#vat_total').text(vat_total.toFixed(2));

            var grand_total = (vat_total + new_sub_total);
            $('#grand_total').text(grand_total.toFixed(2));


            $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
        }







        if(p == 1 || p == 0){
            if(p==0){
                /*if($('#qtyInput'+i).val()){
                    var qty = parseFloat($('#qtyInput'+i).val());
                }else{
                    swal("", "Please enter numbers only", "warning");
                    $('#price_change_btn'+dataNo).removeClass('disabledbutton');
                    brake = 1;
                    var qty = 0;
                }*/
            }else{
                /*if($('#qtyInputPrint'+i).val()){
                    var qty = parseFloat($('#qtyInputPrint'+i).val());
                }else{
                    swal("", "Please enter numbers only", "warning");
                    $('#price_change_btn_print'+dataNo).removeClass('disabledbutton');
                    brake = 1;
                    var qty = 0;
                }*/
            }

            var dataNo = i;
            var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');
            var print = p;


            /*var me = $(this);
            if ( me.data('requestRunning') ) {
                return;
            }*/
            //me.data('requestRunning', true);



            $.ajax({
                type: "post",
                async: "true",
                url: mainUrl + "credits/Credits/checkMaxQty",
                cache: false,
                data: {
                    SerialNumber: SerialNumber
                },

                dataType: 'html',
                success: function (data) {
                    data = $.parseJSON(data);


                    if(print == 1){
                        order_qty = data.Print_Qty;
                        if(qty > order_qty){
                            $('#qtyInputPrint' + dataNo).val(order_qty);
                            swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                        }
                    }else{
                        order_qty = data.Quantity;
                        if(qty > parseInt(order_qty)){
                            $('#qtyInput' + dataNo).val(order_qty);
                            swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                        }
                    }
                    //me.data('requestRunning', false);

                },
                error: function () {
                    swal("Error!", "Error while request..", "error");
                    //me.data('requestRunning', false);
                }
            });
            var newQty = $('#qtyInput'+i).val();
        }else{
            if($('#qtyInput'+i).val()){
                var qty = parseFloat($('#qtyInput'+i).val());
            }else{
                swal("", "Please enter quantity", "warning");

                $('#price_change_btn'+i).removeClass('disabledbutton');
                var qty = 0;
            }

            if($('#descriptionInput'+i).val()){
                var sadadsasdsa = parseFloat($('#descriptionInput'+i).val());
            }else if($('#descriptionInput'+i).text()){
                var sadadsasdsa = parseFloat($('#descriptionInput'+i).val());
            }else{
                swal("", "Please enter description", "warning");
            }
        }

    }


    function checkMaxPrice(price, price_old, dataNo, SerialNumber, print, brake) {
        var me = $(this);
        if ( me.data('requestRunning') ) {
            return;
        }
        me.data('requestRunning', true);

        var val = 0;
        $.ajax({
            type: "post",
            async: "false",
            url: mainUrl + "credits/Credits/checkMaxPrice",
            cache: false,
            data: {
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                if(print == 1){
                    order_price = data.Print_Total * data.exchange_rate;
                    if(price > parseFloat(order_price)){
                        $('#total_price_with_vat_print' + dataNo).val(parseFloat(order_price).toFixed(2));
                        //$('#total_price_with_vat_print_old' + dataNo).val(order_price);
                        swal("", "Sorry, max price you can credit is " + order_price+"", "warning");


                        var rowNo = dataNo;
                        var newTotalPrice_old = order_price;
                        var newTotalPrice = order_price;

                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        if((sub_total - price_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - price_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }
                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));




                        $('#total_price_with_vat_print_old'+rowNo).val(newTotalPrice);
                    }else{
                        var rowNo = dataNo;

                        if(brake == 1) {
                            $('#price_change_btn_print' + rowNo).removeClass('disabledbutton');
                        }else{
                            $('#price_change_btn_print' + rowNo).addClass('disabledbutton');
                        }

                        if($('#total_price_with_vat_print_old'+rowNo).val()){
                            var newTotalPrice_old = parseFloat($('#total_price_with_vat_print_old'+rowNo).val());
                        }else{
                            var newTotalPrice_old = 0;
                        }
                        if($('#total_price_with_vat_print'+rowNo).val()){
                            var newTotalPrice = parseFloat($('#total_price_with_vat_print'+rowNo).val());
                        }else{
                            var newTotalPrice = 0;
                        }
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        if((sub_total - newTotalPrice_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - newTotalPrice_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }
                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));


                        $('#total_price_with_vat_print_old'+rowNo).val(newTotalPrice);
                    }
                    me.data('requestRunning', false);
                }else{
                    order_price = data.Price * data.exchange_rate;
                    if(price > parseFloat(order_price)){
                        $('#total_price_with_vat' + dataNo).val(parseFloat(order_price).toFixed(2));
                        //$('#total_price_with_vat_old' + dataNo).val(order_price);
                        swal("", "Sorry, max price you can credit is " + order_price+"", "warning");


                        var rowNo = dataNo;
                        var newTotalPrice_old = order_price;
                        var newTotalPrice = order_price;
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }

                        if((sub_total - price_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - price_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }
                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));



                        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                    }else{
                        var rowNo = dataNo;
                        if(brake == 1){
                            $('#price_change_btn'+rowNo).removeClass('disabledbutton');
                        }else{
                            $('#price_change_btn'+rowNo).addClass('disabledbutton');
                        }



                        if($('#total_price_with_vat_old'+rowNo).val()){
                            var newTotalPrice_old = parseFloat($('#total_price_with_vat_old'+rowNo).val());
                        }else{
                            var newTotalPrice_old = 0;
                        }
                        if($('#total_price_with_vat'+rowNo).val()){
                            var newTotalPrice = parseFloat($('#total_price_with_vat'+rowNo).val());
                        }else{
                            var newTotalPrice = 0;
                        }
                        if(parseFloat($('#sub_total').text()) > 0){
                            var sub_total = parseFloat($('#sub_total').text());
                        }else{
                            var sub_total = 0;
                        }


                        if((sub_total - newTotalPrice_old + newTotalPrice) > 0){
                            var new_sub_total = (sub_total - newTotalPrice_old + newTotalPrice);
                        }else{
                            var new_sub_total = 0;
                        }
                        $('#sub_total').text(new_sub_total.toFixed(2));


                        var vat_total = 0;
                        if($('#proceeded_without_order_val').val() == 0){
                            if($('#vat_exempt_val').val() != 'yes'){
                                var vat_rate = '<?php echo vat_rate; ?>';
                                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
                            }
                        }
                        $('#vat_total').text(vat_total.toFixed(2));

                        var grand_total = (vat_total + new_sub_total);
                        $('#grand_total').text(grand_total.toFixed(2));


                        $('#total_price_with_vat_old'+rowNo).val(newTotalPrice);
                    }
                    me.data('requestRunning', false);
                }
            },
            error: function () {
                swal("Error!", "Error while request..", "error");
                me.data('requestRunning', false);
            }
        });

    }

    function add_custom_line() {
        /*if($('#order_search_type').val() == 'pwo'){
            var UserID = $("#UserID").val();
        }else{
            var UserID = $("#UserID").val();
        }*/
        var tbody = $(".custom_line");
        if (tbody.children().length == 0) {


            var UserID = $("#UserID").val();
            if(UserID > 0){
                $.ajax({
                    "url": mainUrl + "credits/Credits/addCustomLine",
                    type: 'post',
                    dataType: "json",
                    data: 'UserID='+UserID,
                    success: function (data) {
                        //var i = 150;
                        //var i = $(".list_data_update").find("tr").length+1;
                        var i = 0;
                        var html = '';
                        html+='<tr role="row" class="odd" id="custom'+i+'">' +
                            /*'<td class="sorting_1"><div class="checkbox checkbox-info status-check-box spedic">' +
                            '<input id="checkbox'+i+'" checked data-rowno="'+i+'" type="checkbox" class="chBox" onclick="chBox('+i+')">' +
                            '<label for="checkbox'+i+'"></label>' +
                            '</div></td>' +*/
                            '<td>Custom Line</td>' +
                            '<td>'+data.BillingFirstName+'</td>' +
                            '<td>'+data.BillingLastName+'</td>' +
                            '<td>'+data.BillingPostcode+'</td>' +
                            '<td>'+data.BillingCountry+'</td>' +
                            '<td>' +
                            '<input data-description="'+i+'" data-rowno="'+i+'" type="text" class="form-control form-control-sm return-input productDescription" id="descriptionInput'+i+'" placeholder="Product Description" aria-controls="responsive-datatable">'+
                            '<input data-ManufactureID="'+i+'" type="hidden" id="ManufactureID'+i+'" value="0">'+
                            '</td>' +
                            '<td>' +
                            '<input data-qty="'+i+'" type="number" class="qty_price_change form-control form-control-sm return-input qty" id="qtyInput'+i+'" placeholder="Enter Qty" min="1" value="" aria-controls="responsive-datatable">'+
                            '</td>' +
                            '<td>' +
                            '<div class="input-group " style="flex-wrap: unset; height: 2rem;">' +
                            '<div class="input-group-prepend">' +
                            '<span class="input-group-text" style="background-color: #ffffff; border: 1px solid #d0effa;" id="basic-addon'+i+'">£</span>' +
                            '</div>' +
                            '<input data-inputPrice="'+i+'" type="text" value="0" id="total_price_with_vat'+i+'" placeholder="Enter Price" name="searchByCustomerName"' +
                            'class="qty_price_change form-control input-border-blue inputPrice" required></div>' +
                            '<input type="hidden" id="total_price_with_vat_old'+i+'" value="0">' +
                            '</td>' +
                            '<td>' +
                            '<button id="price_change_btn'+i+'" onclick="price_change_func('+i+', -1)" class="btn btn-outline-dark btn-sm">'+
                            'Calculate'+
                            '</button>'+
                            '&nbsp;&nbsp;&nbsp;<button onclick="remove_custom_line('+i+')" class="btn btn-outline-dark btn-sm"> Remove </button>'+
                            '</td>' +
                            '</tr>';

                        $('.custom_line').append(html);
                    },
                    error: function () {
                        swal("", "Please select user or an order first", "warning");
                        return false;
                    }
                });
            }else{
                swal("", "Please select a user or an order first", "warning");
                return false;
            }
        }

    }


    function remove_custom_line(i) {
        if(parseFloat($('#total_price_with_vat'+i).val()) > 0){
            var line_price = parseFloat($('#total_price_with_vat'+i).val());
        }else{
            var line_price = 0;
        }
        if(parseFloat($('#sub_total').text()) > 0){
            var sub_total = parseFloat($('#sub_total').text());
        }else{
            var sub_total = 0;
        }
        if((sub_total-line_price) > 0){
            var new_sub_total = sub_total-line_price;
        }else{
            var new_sub_total = 0;
        }
        $('#sub_total').text(new_sub_total.toFixed(2));


        var vat_total = 0;
        if($('#proceeded_without_order_val').val() == 0){
            if($('#vat_exempt_val').val() != 'yes'){
                var vat_rate = '<?php echo vat_rate; ?>';
                var vat_total = ((new_sub_total * vat_rate) - new_sub_total);
            }
        }
        $('#vat_total').text(vat_total.toFixed(2));

        var grand_total = (vat_total + new_sub_total);
        $('#grand_total').text(grand_total.toFixed(2));



        $('#total_price_with_vat'+i).val();
        $('#custom'+i).remove();
    }


    $(document).ready(function () {

        $('#add_new_notes_form').submit(function(e)
        {
            e.preventDefault();
            var operator_note = '';
            if($('#operator_note').val()){
                operator_note = $('#operator_note').val();
            }else{
                swal("", "Please enter note", "warning");
                return false;
            }

            $.ajax({
                url: mainUrl + 'credits/Credits/addOperatorAdditionalNote',
                type:"POST",
                data:  new FormData(this),
                contentType: false,
                processData:false,
                dataType: 'json',
                success: function(data){
                    if(data.UserTypeID == 50){
                        var action_td = "<td><button onclick='deleteOperatorAdditionalNote("+data.additional_note_id+")' class='btn btn-outline-dark btn-sm'>Delete </button></td>";
                    }else{
                        var action_td = "";
                    }

                    var i = $(".dataTable111").find("tr").length;
                    $('#additional_note_tbody').append(
                        "<tr id='notes_table_row"+data.additional_note_id+"'>" +
                        "<td>"+ i + "</td>" +
                        "<td>"+ data.UserName + "</td>" +
                        "<td>"+ data.operator_note + "</td>" +
                        "<td>"+ data.created_at + "</td>" +
                        action_td +
                        "</tr>"
                    );

                    var html = '';
                    html+='<input type="hidden" name="operator_note_val[]" class="operator_note_val" value="'+operator_note+'">';
                    $('.operator_note_val_div').append(html);
                    $('#operator_note').val('');
                }
            });
        });

        $('#email_to_customer_form').submit(function(e) {
            e.preventDefault();

            var email_subject = '';
            if($('#email_subject').val()){
                email_subject = $('#email_subject').val();
            }else{
                swal("", "Please enter Email Subject", "warning");
                return false;
            }

            $("#email_to_customer_btn").attr("disabled","disabled").html("Please Wait <i class='fa fa-spin fa-spinner'></i>");
            $.ajax({
                url: mainUrl + 'credits/Credits/emailCreditNote',
                type:"POST",
                data:  new FormData(this),
                contentType: false,
                processData:false,
                dataType: 'json',
                success: function(data){
                    //$('#aa_loader').hide();
                    if(data.status==1){
                        swal("Success!", data.message, "success");
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 2000);
                    }
                    if(data.status==0){
                        swal("", data.message, "warning");
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 30000);
                    }
                },
                error: function(){
                    swal("", "Error occurred, please try again later.", "warning");
                    $("#email_to_customer_btn").removeAttr("disabled").html("SEND");
                },
            });
        });


        $('.do_submit').on('click',function(e){
            if($(this).val()=='Export'){
                $('#search-form').submit( function(e) {
                    $(this).unbind('submit').submit();
                    Otable.draw();
                });
            }else{
                $('#search-form').submit(function(e) {
                    Otable.draw();
                    e.preventDefault();



                    var cn = $('#customer_name').val();
                    var ea = $('#email_address').val();
                    var pn = $('#ph_no').val();
                    var d = $('#duration option:selected').val();
                    var o = $('#ordernumOpt').val();
                    if(o=="" && cn!="" && pn!="" &&  ea!="" && d!="" ){
                        swal("", "Please Choose at-least one order", "warning");
                        return false;
                    }


                    get_order_customer_info();
                });
            }
        });




        $('.js-example-basic-single').select2({
            tags: true,
            placeholder: "Select Orders",
            allowClear: true
        });



        function get_order_customer_info() {
            if($('#order_search_type').val() == 'ord'){
                var orderNumber = $("input[name=orderNumber]").val();
            }else{
                var option_all = $(".js-example-basic-single option:selected").map(function () {
                    return $(this).text();
                }).get().join(',');
                var orderNumber = option_all;
            }

            $.ajax({
                "url": mainUrl + "credits/Credits/getOrderCustomerInfo",
                type: 'post',
                dataType: "json",
                data: 'orderNumber='+orderNumber,
                success: function (data) {
                    var html = '';
                    html += "<span><b>Customer Name:</b> " +data.Name+"</span>" +
                        " | <span><b>Address:</b> " +data.address+"</span>" +
                        " | <span><b>Email Address:</b> " +data.BillingEmail+"</span>" +
                        " | <span><b>Phone Number:</b> " +data.BillingTelephone+"</span>"
                    ;
                    $('.customer_info_div').show();
                    $('#customer_info').html('');
                    $('#customer_info').html(html);
                    $('#UserID').val(data.UserID);

                }
            });
        }


        $('#email_address,#ph_no,#duration,#customer_name').change(function () {

            var name = $('#customer_name').val();
            var email_address = $('#email_address').val();
            var ph_no = $('#ph_no').val();
            var duration = $('#duration').val();
            if (name!="" && email_address != "" && ph_no != "" && duration != "") {
                getCustOrders(name,email_address, ph_no, duration);
            }
        });

        function getCustOrders(name,email_address,ph_no,duration){


            $.ajax({
                type: "post",
                async:"false",
                url: mainUrl+"tickets/addTickets/fetchOrdersBycustomer",
                cache: false,
                data:{
                    name:name,
                    email_address:email_address,
                    ph_no:ph_no,
                    duration:duration
                },
                success: function(data){
                    $('#ordernumOpt').empty();
                    $('#ordernumOpt').val('');
                    $('#ordernumOpt').append("<option value='' disabled>Please Choose</option>");

                    if(data){
                        data = $.parseJSON(data);
                        appendOrderNum(data);
                    }else{
                        swal("", "Sorry, this user have no orders", "warning");
                    }
                },
                error: function(){
                    alert('Error while request..');
                }
            });
        }

        function appendOrderNum(data){

            //$('.dropdown ul').append("<li><option value='sd'>sadsad</option></li>");
            data.forEach(function(item, index, array) {

                var orderNumber =  array[index]['OrderNumber'];
                $('#ordernumOpt').append("<option value="+orderNumber+">"+orderNumber+"</option>");

                //$('.dropdown ul').html("<li><a role='option' class='dropdown-item' aria-disabled='false' tabindex='0' aria-selected='false'><span class='bs-ok-default check-mark'></span><span class='text'>"+orderNumber+"</span></a></li>");
            });
        }


        $('#sub_id').click(function(){

            var cn = $('#customer_name').val();
            var ea = $('#email_address').val();
            var pn = $('#ph_no').val();
            var d = $('#duration option:selected').val();
            var o = $('#ordernumOpt').val();


            if(o=="" && cn!="" && pn!="" &&  ea!="" && d!="" ){
                swal("", "Please Choose atleast one order", "warning");
                return false;
            }
        });








        /*$('#sub').click(function () {
            var chk_box_chk = $('input.chBox:checked').length;
            if (0 == chk_box_chk) {
                $(this).attr('type', 'button');
                swal("", "Please Choose at-least one order", "warning");
                $('#focu').focus();

            } else {
                $('input.chBox:checkbox:checked').each(function () {
                    var sThisVal = $(this).attr('data-rowno');
                    var reportedFault = $('[data-report=' + sThisVal + '] :selected').attr('value');

                    if (reportedFault == "") {
                        $('html, body').animate({
                            scrollTop: $('#report_' + sThisVal).offset().top - 225
                        }, 'slow', function () {
                            $('#report_' + sThisVal).focus();
                        });
                        $('#report_err' + sThisVal).show();
                        return false;
                    }
                });
            }
        });*/




    });


    /*function proceed_without_order(){
        $('.list_data').DataTable().clear();
        var cn = $('#customer_name').val();
        var ea = $('#email_address').val();
        var pn = $('#ph_no').val();
        if(ea==""){
            swal("", "Please enter customer email", "warning");
            return false;
        }


        $.ajax({
            "url": mainUrl + "credits/Credits/searchForCustomer",
            type: 'post',
            dataType: "json",
            data: '_token={{ Session::token() }}&email_address='+ea,
            success: function (data) {
                var html = '';
                html += "<span><b>Customer Name:</b> " +data.Name+"</span>" +
                    " | <span><b>Address:</b> " +data.address+"</span>" +
                    " | <span><b>Email Address:</b> " +data.UserEmail+"</span>" +
                    " | <span><b>Phone Number:</b> " +data.BillingTelephone+"</span>"
                ;
                $('.customer_info_div').show();
                $('#customer_info').html('');
                $('#customer_info').html(html);
                $('#UserID').val(data.UserID);

            }
        });
    }*/
    function search_by_customer(type){
        if(type == 'cus'){
            $('.customer_search_div').show();
            $('.order_search_div').hide();
            $('#orderNumber').prop('disabled', true);
            $('#ordernumOpt').prop('disabled', false);

            $('#order_search_type').val('cus');
        }else if (type == 'pwo'){
            $('.customer_search_div').show();
            $('.order_search_div').hide();
            $('#orderNumber').prop('disabled', true);
            $('#ordernumOpt').prop('disabled', false);

            $('#order_search_type').val('pwo');
        }else{
            $('.customer_search_div').hide();
            $('.order_search_div').show();
            $('#orderNumber').prop('disabled', false);
            $('#ordernumOpt').prop('disabled', true);

            $('#order_search_type').val('ord');
        }
        $('#search-form').trigger("reset");
    }








    function getAllValues() {
        var is_disabled = 0;
        $('.productDescription').each(function(){
            var sThisVal = $(this).attr('data-rowno');
            if($('#price_change_btn'+sThisVal).hasClass("disabledbutton") == false){
                is_disabled = 1;
                console.log($('#price_change_btn'+sThisVal).hasClass("disabledbutton"), sThisVal);
            }
            if($('#price_change_btn_print'+sThisVal).length > 0){
                if($('#price_change_btn_print'+sThisVal).hasClass("disabledbutton") == false){
                    is_disabled = 1;
                    console.log($('#price_change_btn_print'+sThisVal).hasClass("disabledbutton"), sThisVal);
                }
            }

        });
        if(is_disabled != 0){
            swal("", "Please calculate the grand total first", "warning")
        }else{
            var images = [];
            $('.productDescription').each(function(){
                var sThisVal = $(this).attr('data-rowno');

                var returnQty = $('#qtyInput'+sThisVal).val();
                if($('#cr_note_details_id'+sThisVal).val() != undefined && $('#cr_note_details_id'+sThisVal).val() > 0){
                    var cr_note_details_id = $('#cr_note_details_id'+sThisVal).val();
                }else{
                    var cr_note_details_id = 0;
                }

                var productDescription = '';
                if($('#descriptionInput'+sThisVal).val()){
                    productDescription = $('#descriptionInput'+sThisVal).val();
                }else if($('#descriptionInput'+sThisVal).text()){
                    productDescription = $('#descriptionInput'+sThisVal).text();
                }

                var ManufactureID = '';
                if($('#ManufactureID'+sThisVal).val()){
                    ManufactureID = $('#ManufactureID'+sThisVal).val();
                }else if($('#ManufactureID'+sThisVal).text()){
                    ManufactureID = $('#ManufactureID'+sThisVal).text();
                }

                var orderNumber = '';
                if($('#orderNumber'+sThisVal).val()){
                    orderNumber = $('#orderNumber'+sThisVal).val();
                }else if($('#orderNumber'+sThisVal).text()){
                    orderNumber = $('#orderNumber'+sThisVal).text();
                }

                var newUnitPrice = $('#total_price_with_vat'+sThisVal).val();

                if($('[data-newTotalPrice=' + sThisVal + ']').attr('value') != undefined){
                    var newTotalPrice = $('[data-newTotalPrice=' + sThisVal + ']').attr('value');
                }else{
                    var newTotalPrice = $('#total_price_without_vat'+sThisVal).val();
                }


                var Serialnumber = $('[data-SerialNumber=' + sThisVal + ']').attr('value');

                /*PRINT VALUES*/
                if($('[data-Printing=' + sThisVal + ']').attr('value') != undefined){
                    var Printing = $('[data-Printing=' + sThisVal + ']').attr('value');
                }else{
                    var Printing = '';
                }
                var returnQtyPrint = $('#qtyInputPrint'+sThisVal).val();
                var newUnitPricePrint = $('#total_price_with_vat_print'+sThisVal).val();
                var productDescriptionPrint = '';
                if($('#descriptionInputPrint'+sThisVal).val()){
                    productDescriptionPrint = $('#descriptionInputPrint'+sThisVal).val();
                }else if($('#descriptionInputPrint'+sThisVal).text()){
                    productDescriptionPrint = $('#descriptionInputPrint'+sThisVal).text();
                }


                images.push({
                    'SerialNumber': Serialnumber,
                    'cr_note_details_id': cr_note_details_id,
                    'returnQty': returnQty,
                    'returnUnitPrice': newUnitPrice,
                    'returnPrice': newTotalPrice,
                    'productDescription' : productDescription,
                    'orderNumber' : orderNumber,
                    'ManufactureID' : ManufactureID,
                    'Printing' : Printing,
                    'returnQtyPrint': returnQtyPrint,
                    'TotalPricePrint': newUnitPricePrint,
                    'productDescriptionPrint' : productDescriptionPrint
                });
            });

            var myJSON = JSON.stringify(images);
            $('#order_details_data').empty("");
            $('#order_details_data').val(myJSON);


            var total_delivery = $('.delivery_charges_span').text();
            var total_vat = $('#vat_total').text();


            var orders_details = $('#order_details_data').val();
            var token = $('#token').val();
            var cr_note_id = $('#cr_note_id').val();
            var UserID = $('#UserID').val();
            $.ajax({
                type: "post",
                url: mainUrl + "credits/Credits/updateTicket",
                cache: false,
                data: {'orders_details': orders_details, 'token':token, 'cr_note_id':cr_note_id, 'UserID':UserID, 'total_delivery':total_delivery, 'total_vat':total_vat},
                dataType: 'json',
                success: function (data) {
                    if(data.status == 1){
                        swal("Success!", data.message, "success");
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 2000);
                    }else{
                        var html='';
                        $.each(data['data'], function(i, ticket_row){
                            if(ticket_row.exceeding == 1){
                                $('#qtyInput'+ticket_row.cr_note_details_id).addClass('red_color');
                            }else{
                                $('#qtyInput'+ticket_row.cr_note_details_id).removeClass('red_color');
                            }

                        });
                        swal("", data.message, "warning");
                    }
                    return true;
                },
            });
        }






    }


    /*function getAllValues() {
        var images = [];
        $('.productDescription').each(function(){
            var sThisVal = $(this).attr('data-rowno');


            var returnQty = $('#qtyInput'+sThisVal).val();
            if($('#cr_note_details_id'+sThisVal).val() != undefined && $('#cr_note_details_id'+sThisVal).val() > 0){
                var cr_note_details_id = $('#cr_note_details_id'+sThisVal).val();
            }else{
                var cr_note_details_id = 0;
            }


            var productDescription = '';
            if($('#descriptionInput'+sThisVal).val()){
                productDescription = $('#descriptionInput'+sThisVal).val();
            }else if($('#descriptionInput'+sThisVal).text()){
                productDescription = $('#descriptionInput'+sThisVal).text();
            }

            var ManufactureID = '';
            if($('#ManufactureID'+sThisVal).val()){
                ManufactureID = $('#ManufactureID'+sThisVal).val();
            }else if($('#ManufactureID'+sThisVal).text()){
                ManufactureID = $('#ManufactureID'+sThisVal).text();
            }

            var orderNumber = '';
            if($('#orderNumber'+sThisVal).val()){
                orderNumber = $('#orderNumber'+sThisVal).val();
            }else if($('#orderNumber'+sThisVal).text()){
                orderNumber = $('#orderNumber'+sThisVal).text();
            }

            var newUnitPrice = $('#total_price_with_vat'+sThisVal).val();

            if($('[data-newTotalPrice=' + sThisVal + ']').attr('value') != undefined){
                var newTotalPrice = $('[data-newTotalPrice=' + sThisVal + ']').attr('value');
            }else{
                var newTotalPrice = $('#total_price_without_vat'+sThisVal).val();
            }

            images.push({
                'cr_note_details_id': cr_note_details_id,
                'returnQty': returnQty,
                'returnUnitPrice': newUnitPrice,
                'returnPrice': newTotalPrice,
                'productDescription' : productDescription,
                'orderNumber' : orderNumber,
                'ManufactureID' : ManufactureID
            });

        });

        var myJSON = JSON.stringify(images);
        $('#order_details_data').empty("");
        $('#order_details_data').val(myJSON);
    }*/

    function getTicketDetails() {
        var images = [];
        var desc_req = 0;
        var qty_req = 0;
        $('input.chBox:checkbox:checked').each(function () {

            var sThisVal = $(this).attr('data-rowno');
            var reportedFault = $('[data-report=' + sThisVal + '] :selected').attr('value');

            if (reportedFault == "") {
                var offset = $(this).attr('data-scroll-offset') * 1 || 0;
                $('html, body').animate({
                    scrollTop: $('#report_' + sThisVal).offset().top + offset
                }, 'slow', function () {
                    $('#report_' + sThisVal).focus();
                });
                $('#report_err' + sThisVal).show();
                return false;
            }
            var OrderNumber = $('[data-OrderNumber=' + sThisVal + ']').attr('value');
            var Serialnumber = $('[data-SerialNumber=' + sThisVal + ']').attr('value');
            var returnQty = $('#qtyInput'+sThisVal).val();

            var productDescription = '';
            if($('#descriptionInput'+sThisVal).val()){
                productDescription = $('#descriptionInput'+sThisVal).val();
            }else if($('#descriptionInput'+sThisVal).text()){
                productDescription = $('#descriptionInput'+sThisVal).text();
            }

            var ManufactureID = '';
            if($('#ManufactureID'+sThisVal).val()){
                ManufactureID = $('#ManufactureID'+sThisVal).val();
            }else if($('#ManufactureID'+sThisVal).text()){
                ManufactureID = $('#ManufactureID'+sThisVal).text();
            }



            //var newUnitPrice = $('[data-newUnitPrice=' + sThisVal + ']').attr('value');
            var newUnitPrice = $('#total_price_without_vat'+sThisVal).val();

            if($('[data-newTotalPrice=' + sThisVal + ']').attr('value') != undefined){
                var newTotalPrice = $('[data-newTotalPrice=' + sThisVal + ']').attr('value');
            }else{
                var newTotalPrice = $('#total_price_without_vat'+sThisVal).val();
            }

            if($('[data-currency=' + sThisVal + ']').attr('value') != undefined){
                var currency = $('[data-currency=' + sThisVal + ']').attr('value');
            }else{
                var currency = 'GBP';
            }
            if(productDescription == ''){
                swal("", "Please enter description", "warning");
                return false;
                //desc_req = 1;
            }
            if(returnQty == 0){
                swal("", "Please enter the quantity", "warning");
                return false;
                //qty_req = 1;
            }



            images.push({
                'orderNumber': OrderNumber,
                'SerialNumber': Serialnumber,
                'qty': returnQty,
                'reportedFault': reportedFault,
                'unitPrice': newUnitPrice,
                'TotalPrice': newTotalPrice,
                'currency': currency,
                'productDescription' : productDescription,
                'ManufactureID' : ManufactureID
            });
            var myJSON = JSON.stringify(images);

            $('#order_details_data').empty("");
            $('#order_details_data').val(myJSON);
        });



        /*var arrNumber = new Array();
        $('.operator_note_val').each(function(){
            arrNumber.push($(this).val());
        });
        var myJSON1 = JSON.stringify(arrNumber);
        $('#operator_additional_notes_data').empty("");
        $('#operator_additional_notes_data').val(myJSON1);*/

    }





    $(document).ready(function () {

        var $chk_out_order = $('#is_another').val();
        if($chk_out_order){
            swal("", "You have entered another customer order No#!", "warning");
        }

        var email = $('#email_address').val();
        if (email) {
            $('#byOrderNum').hide();
            $('#byCustName').removeClass('byCustName');
        }

        //Buttons examples

        /* var table = $('#datatable-buttons').DataTable({
             lengthChange: false,
             buttons: ['copy', 'excel', 'pdf']
         });

         // Responsive Datatable
         $('#responsive-datatable').DataTable();
         table.buttons().container()
             .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');*/
    });





    $('#orderNumber').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9,-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $('#orderNumber').change(function () {
        var vals = $(this).val();
    });







    function chBox(i) {
        var rowNo = i;
        console.log(rowNo);
        if ($('#checkbox'+i).is(':checked')) {
            $('[data-report=' + rowNo + ']').attr('disabled', false);
            $('[data-qty=' + rowNo + ']').attr('disabled', false);
            $('[data-inputPrice=' + rowNo + ']').attr('disabled', false);
        } else {
            $('[data-report=' + rowNo + '] :selected').prop('selected', false);
            $('[data-report=' + rowNo + ']').attr('disabled', true);
            $('[data-qty=' + rowNo + ']').attr('disabled', true);
            $('[data-inputPrice=' + rowNo + ']').attr('disabled', true);
        }
        var chk_len = $('input.chBox:checkbox:checked').length;
        var countselect = $("select.fault option[value!='']:selected").length;

        /*if (chk_len == countselect) {
            $('#sub').attr('type', 'submit');
        } else {
            $('#sub').attr('type', 'button');
        }*/
    }

    function qtyChange(i,p) {
        if(p==0){
            var qty = $('#qtyInput'+i).val();
        }else{
            var qty = $('#qtyInputPrint'+i).val();
        }
        var dataNo = i;
        var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');


        checkMaxQty(qty, dataNo, SerialNumber, p);
        var newQty = $('#qtyInput'+i).val();
    }

    function checkMaxQty(qty, dataNo, SerialNumber, print) {
        $.ajax({
            type: "post",
            async: "true",
            url: mainUrl + "credits/Credits/checkMaxQty",
            cache: false,
            data: {
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);


                if(print == 1){
                    order_qty = data.Print_Qty;
                    if(qty > order_qty){
                        $('#qtyInputPrint' + dataNo).val(order_qty);
                        swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                    }
                }else{
                    order_qty = data.Quantity;
                    if(qty > parseInt(order_qty)){
                        $('#qtyInput' + dataNo).val(order_qty);
                        swal("", "Sorry, max quantity you can credit is " + order_qty+"", "warning");
                    }
                }

            },
            error: function () {
                swal("Error!", "Error while request..", "error");
            }
        });
    }

    function getPrice(ProductBrand, ManufactureID, newQty, batch, dataNo, labels, Print_Type, FinishType, Printing, SerialNumber) {

        $.ajax({
            type: "post",
            async: "false",
            url: mainUrl + "tickets/addTickets/getPrice",
            cache: false,
            data: {
                ProductBrand: ProductBrand,
                ManufactureID: ManufactureID,
                newQty: newQty,
                batch: batch,
                labels: labels,
                Print_Type: Print_Type,
                FinishType: FinishType,
                Printing: Printing,
                SerialNumber: SerialNumber
            },

            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                //console.log(data);
                var UnitPrice = data.UnitPrice;
                var TotalPrice = data.TotalPrice;

                UnitPrice = parseFloat(UnitPrice).toFixed(2);
                TotalPrice = parseFloat(TotalPrice).toFixed(2);
                var curr = $('[data-currency=' + dataNo + ']').attr('value');
                var sym;

                if (curr == "GBP") {
                    sym = '&pound;';
                }
                else if (curr == "EUR") {
                    sym = '&euro;';
                }
                else if (curr == "USD") {
                    sym = '$';
                }

                $('[data-inputPrice=' + dataNo + ']').val(UnitPrice);
                $('[data-newUnitPrice=' + dataNo + ']').attr('value', UnitPrice);
                $('[data-newTotalPrice=' + dataNo + ']').attr('value', TotalPrice);
            },
            error: function () {
                swal("Error!", "Error while request..", "error");
            }
        });
    }





    $('.fault').change(function () {
        var dr = $(this).attr('data-report');
        $('#report_err' + dr).hide();
        var chk_len = $('input.chBox:checkbox:checked').length;
        var countselect = $("select.fault option[value!='']:selected").length;
        if (chk_len == countselect) {
            $('#sub').attr('type', 'submit');
        }
    });







    $('.inputPrice').change(function () {
        var data_id = $(this).attr('data-inputPrice');
        var newPr = $(this).val();
        var UnitPrice = parseFloat(newPr);
        UnitPrice = UnitPrice.toFixed(2);
        var TotalPrice = parseFloat(newPr) * parseFloat(1.2);
        TotalPrice = TotalPrice.toFixed(2);
        $('[data-newUnitPrice=' + data_id + ']').attr('value', UnitPrice);
        $('[data-newTotalPrice=' + data_id + ']').attr('value', TotalPrice);
    });






    function deleteOperatorAdditionalNote(note_id){
        swal(
            "Are You Sure You Want To Delete This Note",
            {
                buttons: {
                    cancel: "No",
                    catch: {
                        text: "Yes",
                        value: "catch",
                    },
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        ).then((value) => {
            switch (value) {
                case "catch":
                    $.ajax({
                        url: mainUrl + 'credits/Credits/deleteOperatorAdditionalNote',
                        type:"POST",
                        dataType:"json",
                        processData:false,
                        data: 'note_id='+note_id,
                        success: function(data){
                            //console.log(data);
                            if(data.status == 1){

                                $(".dataTable111 > tbody").html("");

                                $.each(data.data, function (i,data) {
                                    i+=1;
                                    $('#additional_note_tbody').append(
                                        "<tr id='notes_table_row"+data.additional_note_id+"'>" +
                                        "<td>"+ i + "</td>" +
                                        "<td>"+ data.UserName + "</td>" +
                                        "<td>"+ data.operator_note + "</td>" +
                                        "<td>"+ data.created_at + "</td>" +
                                        "<td><button onclick='deleteOperatorAdditionalNote("+data.additional_note_id+")' class='btn btn-outline-dark btn-sm'>Delete </button></td>" +
                                        "</tr>"
                                    );
                                });




                                swal("Success!", data.message, "success");
                                //$('#notes_table_row'+note_id).remove();
                            }else{
                                swal("", data.message, "warning");
                            }
                            return true;
                        }
                    });
            }
        });
    }



    function ticketActionPerformed(action_type, cr_note_id){
        swal(
            "Are You Sure You Want To Perform This Action",
            {
                buttons: {
                    cancel: "No",
                    catch: {
                        text: "Yes",
                        value: "catch",
                    },
                },
                icon: "warning",
                closeOnClickOutside: false,
            }
        ).then((value) => {
            switch (value) {
                case "catch":
                    $.ajax({
                        url: mainUrl + 'credits/Credits/ticketActionPerformed',
                        type:"POST",
                        dataType:"json",
                        processData:false,
                        data: 'action_type='+action_type+'&cr_note_id='+cr_note_id,
                        success: function(data){
                            if(data.status == 1){
                                swal("Success!", data.message, "success");
                                setTimeout(function(){
                                    window.location.reload(1);
                                }, 2000);
                            }else{
                                swal("", data.message, "warning");
                            }
                            return true;
                        }
                    });
            }
        });
    }


    function print_credit_note(id) {
        //var ver = $('#language').val();
        window.location.href = '<?php echo main_url ?>credits/Credits/printCreditNote/' + id;
    }


    function email_credit_note(id) {
        window.location.href = '<?php echo main_url ?>credits/Credits/emailCreditNote/' + id;
    }


    
    /*function calculateGTPrice() {
        var images = [];
        $('.productDescription').each(function(){
            var sThisVal = $(this).attr('data-rowno');

            var returnQty = $('#qtyInput'+sThisVal).val();
            if($('#cr_note_details_id'+sThisVal).val() != undefined && $('#cr_note_details_id'+sThisVal).val() > 0){
                var cr_note_details_id = $('#cr_note_details_id'+sThisVal).val();
            }else{
                var cr_note_details_id = 0;
            }



            var ManufactureID = '';
            if($('#ManufactureID'+sThisVal).val()){
                ManufactureID = $('#ManufactureID'+sThisVal).val();
            }else if($('#ManufactureID'+sThisVal).text()){
                ManufactureID = $('#ManufactureID'+sThisVal).text();
            }

            var orderNumber = '';
            if($('#orderNumber'+sThisVal).val()){
                orderNumber = $('#orderNumber'+sThisVal).val();
            }else if($('#orderNumber'+sThisVal).text()){
                orderNumber = $('#orderNumber'+sThisVal).text();
            }

            var newUnitPrice = $('#total_price_with_vat'+sThisVal).val();




            var Serialnumber = $('[data-SerialNumber=' + sThisVal + ']').attr('value');

            /!*PRINT VALUES*!/
            if($('[data-Printing=' + sThisVal + ']').attr('value') != undefined){
                var Printing = $('[data-Printing=' + sThisVal + ']').attr('value');
            }else{
                var Printing = '';
            }
            var returnQtyPrint = $('#qtyInputPrint'+sThisVal).val();
            var newUnitPricePrint = $('#total_price_with_vat_print'+sThisVal).val();



            images.push({
                'SerialNumber': Serialnumber,
                'cr_note_details_id': cr_note_details_id,
                'returnQty': returnQty,
                'returnUnitPrice': newUnitPrice,
                'orderNumber' : orderNumber,
                'ManufactureID' : ManufactureID,
                'Printing' : Printing,
                'returnQtyPrint': returnQtyPrint,
                'TotalPricePrint': newUnitPricePrint
            });
        });

        var myJSON = JSON.stringify(images);
        $('#gt_price_data').empty("");
        $('#gt_price_data').val(myJSON);


        var orders_details = $('#gt_price_data').val();
        var token = $('#token').val();
        var cr_note_id = $('#cr_note_id').val();
        var UserID = $('#UserID').val();
        $.ajax({
            type: "post",
            url: mainUrl + "credits/Credits/calculateGTPrice",
            cache: false,
            data: {'orders_details': orders_details, 'token':token, 'cr_note_id':cr_note_id, 'UserID':UserID},
            dataType: 'json',
            success: function (data) {
                if(data.status == 1){
                    $('.productDescription').each(function(){
                        var sThisVal = $(this).attr('data-rowno');
                        $('#total_price_with_vat'+sThisVal).removeClass('red_color');
                    });
                }else{
                    var html='';
                    $.each(data['data'], function(i, ticket_row){
                        if(ticket_row.exceeding == 1){
                            $('#total_price_with_vat'+ticket_row.cr_note_details_id).addClass('red_color');
                        }else{
                            $('#total_price_with_vat'+ticket_row.cr_note_details_id).removeClass('red_color');
                        }

                    });
                    swal("", data.message, "warning");
                }
                return true;
            },
        });
    }*/


    $(document).ready(function () {
        $(document).on('change', '.qty_price_change', function(e) {
        //$('.qty_price_change').on('change', function (e) {
            e.preventDefault();

            if($(this).attr('data-qty')){
                var rowNo = $(this).attr('data-qty');
            }else{
                var rowNo = $(this).attr('data-inputPrice');
            }
            $('#price_change_btn'+rowNo).removeClass('disabledbutton');

            var total_price_with_vat = $('#total_price_with_vat'+rowNo).val();
            if(total_price_with_vat > 0){
                total_price_with_vat = total_price_with_vat;
            }else{
                total_price_with_vat = 0;
            }
            $('#total_price_with_vat'+rowNo).val(Number.parseFloat(total_price_with_vat).toFixed(2));
        });

        $(document).on('change', '.qty_price_change_print', function(e) {
        //$('.qty_price_change_print').on('change', function (e) {
            e.preventDefault();

            if($(this).attr('data-qty')){
                var rowNo = $(this).attr('data-qty');
            }else{
                var rowNo = $(this).attr('data-inputPrice');
            }
            $('#price_change_btn_print'+rowNo).removeClass('disabledbutton');

            var total_price_with_vat_print = $('#total_price_with_vat_print'+rowNo).val();
            if(total_price_with_vat_print > 0){
                total_price_with_vat_print = total_price_with_vat_print;
            }else{
                total_price_with_vat_print = 0;
            }
            $('#total_price_with_vat_print'+rowNo).val(parseFloat(total_price_with_vat_print).toFixed(2));
        });


            /*var my_spinner = $( ".my_spinner" ).spinner({
                numberFormat: "n",
                min:0.00,
                step:0.01
            });*/


    });
    /*function qty_price_change(rowNo){
        $('#price_change_btn'+rowNo).removeClass('disabledbutton');
    }*/



    /*$(document).on('click', '.my_spinner', function() {
        $('#input_spinner').val(0);
        $('#input_spinner').val($(this).attr('data-inputPrice'));
    });
    $(document).keydown(function(e) {
        var rowNos = $('#input_spinner').val();
        var el = $('#total_price_with_vat'+rowNos);
        function change(amt) {
            if(parseFloat(el.val()) >=0 ){
                if((parseFloat( el.val(), 10 ) + amt) >= 0){
                    el.val( (parseFloat( el.val(), 10 ) + amt).toFixed(2) );
                }
            }else{
                el.val(amt);
            }

        }
        switch(e.which) {
            case 38:
                change( +0.01 );
                break;

            case 40:
                change( -0.01 );
                break;
            default: return;
        }
        e.preventDefault();
    });*/


</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>