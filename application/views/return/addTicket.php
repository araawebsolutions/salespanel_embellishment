<link href="<?= ASSETS ?>assets/css/dropzone.css" rel="stylesheet" type="text/css"/>
<script src="<?= ASSETS ?>assets/js/dropzone.js"></script>
<style>
	.byCustName {
		display: none;
	}

    #slider-container {
        width:350px;
        margin-left:30px;
    }
    .erss {
        display: none;
        color: crimson;
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
	</style>



<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
					
                    <div class="card-header no-bg text-center">
                        <div class="col-md-6 center-page m-t-t-10">
                            <span class="returns-title">RETURNS / COMPLAINTS ENQUIRY FORM</span>
                            <hr>
                            <span class="return-title-text">Please Fill This Form To Add Enquiry</span>
                        </div>
                    </div>
					
					<?php
						$date = strtotime(date('Y-m-d h:i:s'));
						$token =  md5(uniqid($date, true));
					?>
					


					
                    <div class="card-body">
                        <form method="post" id="byOrderNum" class="labels-form " enctype="multipart/form-data"
                              action="<?= main_url ?>tickets/addTickets/findOrders">
                            <div class="row" id="search_by_order_no" style="margin-bottom: 20px !important;">
                                <div class="col-md-3">
                                    <div class="input-margin-10">
                                        <label class="input "> <i class="icon-append mdi mdi-cart-plus icon-appendss"></i>
											<input type="text" placeholder="Search Order Numbers e.g AA00,AA11" name="orderNumber" id="orderNumber" value="<?php echo $order_numbers ?>" class="required input-border-blue" title="e.g. Order Numbers AA173536,AA173536,AA173536" multiple required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="false">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-1">
                                    <button type="submit" class="btn btn-outline-info waves-light waves-effect p-6-10 ">
                                        Search <i class="fa fa-arrow-right"></i></button>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-margin-10">
										<button type="button" id="searchByCustomerName" class="btn btn-outline-info waves-light waves-effect p-6-10 ">Search by  Customer Name </button>
                                    </div>
                                    <input type="hidden" id="is_another" value="<?php echo $chk_out_order ?>">
                                </div>
                                <?php if ($chk_out_order) { ?> <?php } ?>
                            </div>
                        </form>

						<form method="post" id="byCustName" class="labels-form byCustName"
                              enctype="multipart/form-data" action="<?= main_url ?>tickets/addTickets/findOrders"
                              onsubmit="if(submitted) return false; submitted = true; return true">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-margin-10">
                                        <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" placeholder="Customer Name" name="customer_name"
                                                   id="customer_name" value="" class="required input-border-blue"
                                                   data-content="" data-original-title="" title="" multiple>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-margin-10">
                                        <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="email" placeholder="Email Address" name="email_address"
                                                   id="email_address" value="" class="required input-border-blue"
                                                   data-content="" data-original-title="" title="">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-margin-10">
                                        <label class="input "> <i class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" placeholder="Phone Number" name="ph_no"
                                                   id="ph_no" value="" class="required input-border-blue"
                                                   data-content="" data-original-title="" title="">
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-margin-10">
                                        <label class="select">
                                            <select name="duration" id="duration" class="required input-border-blue">
                                                <option value="">Select Duration</option>
                                            </select>
                                            <i></i>
                                        </label>
									</div>                
								</div>



								<div class="col-md-2">
                                    <div class="input-margin-10">
                                        <label class="select ">
                                            <select class="required input-border-blue" id="ordernumOpt"  name="orderNumber">
                                                <option value="">Order Number</option>
                                            </select>
                                            <i></i>
										</label>
									</div>
								</div>
								
                                <div class="col-md-2">
                                    <div class="input-margin-10">
                                        <button class="btn btnn" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>



                        <?php if ($result) { ?>
                            <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert" style="margin-bottom: 0px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <span><b>Customer Name:</b> <?php echo $result[0]['Name']; ?></span> |
                                <span><b>Address:</b> <?php echo $result[0]['address']; ?></span>
                                | <span><b>Email Addresss:</b> <?php echo $result[0]['Billingemail']; ?></span> | <span><b>Phone Number:</b> <?php echo $result[0]['Billingtelephone']; ?></span>
                            </div>
                        <?php } ?>


                        <input type="" id="focu" style="opacity:0;cursor: default;height: 1px; width: 0;" readonly>
                        <table class="table table-bordered mb-0 returns-table">

                            <thead>
                            <tr>
                                <th></th>
                                <th>Order #</th>
                                <th>First Name</th>
								<th>Last Name</th>
                                <th>Post Code</th>
                                <th>Country</th>
                                <th>Description</th>
                                <th style="width:15%">Reported Fault</th>
                                <th>Quantity</th>
                                <th style="width:15%">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($result) { ?>
                                <?php $i = 1;
                                foreach ($result as $res) { ?>
                                    <?php $curr = $res['currency'];
                                    if ($curr == "GBP") {
                                        $sym = '&pound;';
                                    } else if ($curr == "EUR") {
                                        $sym = '&euro;';
                                    } else if ($curr == "USD") {
                                        $sym = '$';
                                    }
                                    ?>

                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-info status-check-box spedic">
                                              <?php if($res['ManufactureID']!='SCO1'){ ?>
                                                <input id="checkbox<?php echo $i ?>" data-rowNo="<?php echo $i ?>"
                                                       type="checkbox" class="chBox">
                                                <label for="checkbox4"></label>
                                             <? } ?>
                                            </div>
                                        </td>
                                        <td><?php echo $res['OrderNumber']; ?></td>
                                        <td><?php echo $res['BillingFirstName']; ?></td>
                                        <td><?php echo $res['BillingLastName']; ?></td>
                                        <td><?php echo $res['BillingPostcode']; ?></td>
                                        <td><?php echo $res['BillingCountry']; ?></td>
                                        <td><b><?php echo $res['ManufactureID']; ?></b>
                                            - <?php echo $res['ProductName']; ?></td>
                                        <td>
                                            <div class="order-line">
                                                <select class="form-control  fault" id="report_<?php echo $i ?>"
                                                        data-report="<?php echo $i ?>" disabled>
                                                    <option value="">Please Select Fault</option>
                                                    <option value="Customer Order Error">Customer Order Error</option>
                                                    <option value="Sales Error">Sales Error</option>
                                                    <option value="Dispatch Error">Dispatch Error</option>
                                                    <option value="Production Error">Production Error</option>
                                                    <option value="Margin Error">Margin Error</option>
                                                    <option value="Incorrect Product">Incorrect Product</option>
                                                    <option value="Fault Product">Fault Product</option>
                                                    <option value="Unwanted Print Error">Unwanted Print Error</option>
                                                </select>
                                                <i></i>
                                                <span id="report_err<?php echo $i ?>" class="erss">Please Choose</span>
                                            </div>
                                        </td>
										
                                        <td>

                                            <input data-qty="<?php echo $i; ?>" type="number"

                                                   class="form-control form-control-sm return-input qty"

                                                   placeholder="123456" min="1" value="<?php echo $res['Quantity']; ?>"

                                                   aria-controls="responsive-datatable" disabled>





                                            <?php $vals = '';

                                            if (preg_match("/(1000 Sheet Boxes)/i", $res['ProductName'])) {

                                                $vals = '1000';

                                            } else {

                                                $vals = '250';

                                            } ?>

                                            <input type="hidden" data-batch="<?php echo $i; ?>"

                                                   value="<?php echo $vals; ?>">

                                            <input type="hidden" data-ProductBrand="<?php echo $i ?>"

                                                   value="<?php echo $res['ProductBrand'] ?>">

                                            <input type="hidden" data-ManufactureID="<?php echo $i ?>"

                                                   value="<?php echo $res['ManufactureID'] ?>">



                                            <input type="hidden" data-labels="<?php echo $i ?>"

                                                   value="<?php echo $res['LabelsPerRoll'] ?>">

                                            <input type="hidden" data-Print_Type="<?php echo $i ?>"

                                                   value="<?php echo $res['Print_Type'] ?>">

                                            <input type="hidden" data-FinishType="<?php echo $i ?>"

                                                   value="<?php echo $res['FinishType'] ?>">

                                            <input type="hidden" data-Printing="<?php echo $i ?>"

                                                   value="<?php echo $res['Printing'] ?>">

                                            <input type="hidden" data-SerialNumber="<?php echo $i ?>"

                                                   value="<?php echo $res['SerialNumber'] ?>">

                                        </td>

                                        <td>

                                            <!--<span data-price="<?php echo $i; ?>"><?php echo $sym . $res['Price']; ?></span><br>-->



                                            <div class="input-group " style="flex-wrap: unset; height: 2rem;">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text"

                                                          style="background-color: #ffffff; border: 1px solid #d0effa;"

                                                          id="basic-addon1"><?php echo $sym; ?></span>

                                                </div>





                                                <input data-inputPrice="<?php echo $i; ?>" type="number" start="0.00"

                                                       min="0.00" step="0.01" placeholder="Enter Price"

                                                       name="searchByCustomerName" value="<?php echo $res['Price']; ?>"

                                                       class="form-control input-border-blue inputPrice" required

                                                       disabled>

                                            </div>





                                            <input type="hidden" data-currency="<?php echo $i ?>"

                                                   value="<?php echo $res['currency']; ?>" disabled>



                                            <input type="hidden" data-OrderNumber="<?php echo $i ?>"

                                                   value="<?php echo $res['OrderNumber'] ?>">



                                            <input type="hidden" data-SerialNumber="<?php echo $i ?>"

                                                   value="<?php echo $res['SerialNumber'] ?>">



                                            <input type="hidden" data-newUnitPrice="<?php echo $i ?>"

                                                   value="<?php echo $res['Price']; ?>" disabled>



                                            <input type="hidden" data-newTotalPrice="<?php echo $i ?>"

                                                   value="<?php echo $res['ProductTotal']; ?>" disabled>

                                        </td>



                                        <input type="hidden" data-min_qty_integrated="<?php echo $i ?>"

                                               value="<?php echo $this->ReturnGetPrice_model->min_qty_integrated($res['ManufactureID']); ?>"

                                               disabled>

                                        <input type="hidden" data-max_qty_integrated="<?php echo $i ?>"

                                               value="<?php echo $this->ReturnGetPrice_model->max_qty_integrated($res['ManufactureID']); ?>"

                                               disabled>





                                        <input type="hidden" data-calulate_min_rolls="<?php echo $i ?>"

                                               value="<?php echo $this->ReturnGetPrice_model->calulate_min_rolls($res['ManufactureID']); ?>"

                                               disabled>

                                        <input type="hidden" data-calulate_max_rolls="<?php echo $i ?>"

                                               value="<?php echo $this->ReturnGetPrice_model->calulate_max_rolls($res['ManufactureID']); ?>"

                                               disabled>

                                    </tr>

                                    <?php $i++;

                                } ?>



                            <?php } else { ?>

                                <tr>

                                    <td colspan="10" style="text-align:center">

                                        <p>Record not found</p>

                                    </td>

                                </tr>

                            <?php } ?>





                            </tbody>

                        </table>



                        <br>

                        <br>



                        <?php if ($result) { ?>

                            <form method="post" id="checkout_form" class="labels-form " enctype="multipart/form-data"
                                  action="<?= main_url ?>tickets/addTickets/createTicket"
                                  onsubmit="return getAllValues();">

								<input type="hidden" id="token" name="token" value="<?=$token?>">
                                <input type="hidden" id="order_details_data" name="orders_details">
								
                                <div class="row m-t-t-10">
                                    <div class="col-md-3">



                                        <label class="select input-margin-10">

                                            <select name="contact_type" id="country" class="required input-border-blue">

                                                <option value="">Type of Contact</option>

                                                <option class="Email">Email</option>

                                                <option value="Call">Call</option>

                                            </select>

                                            <i></i>

                                        </label>

                                    </div>

                                    <div class="col-md-5">

                                        <div class="input-margin-10">

                                            <label class="input ">

                                                <input type="text"

                                                       placeholder="Reason for Contact and Customer's Desired Outcome"

                                                       name="contact_reason" id="b_last_name" value=""

                                                       class="required input-border-blue">

                                            </label>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="input-margin-10">

                                            <button type="button"

                                                    class="btn btn-outline-info waves-light waves-effect hintsbtn"

                                                    data-toggle="modal" data-target=".bs-example-modal-lg">HINTS &

                                                TIPS <i class="mdi mdi-information"></i></button>

                                        </div>

                                    </div>

                                </div>





                                <div>



                                    <span class="return-title-texts">Action</span><br>



                                    <span class="return-title-texts-details">Please add action which is taken/to be taken</span>





                                    <div class="input-margin-10 m-t-t-10">



                                        <div class="form-group">

                                        <textarea class="form-control" rows="5" name="pre_action_taken"

                                                  style="margin-top: 0px;margin-bottom: 0px;height: 100px;border-color: #d0effa;"

                                                  spellcheck="false"></textarea>

                                        </div>

                                    </div>

                                </div>
                     



                                <div class="row m-t-t-10">
									<div class="col-md-5">
                                        <div class="m-t-t-10">
                                            <span class="return-title-texts">Investigation</span><br>
                                            <span class="return-title-texts-details">Please add Investigations</span>
                                        </div>
                                        <div class="form-group input-margin-10">
                                        <textarea class="form-control" rows="5" name="pre_investigation"
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 130px;border-color: #d0effa;padding: 10px;"
                                                  spellcheck="false"></textarea>
                                        </div>
                                    </div>

									<div class="col-md-4">
										<div class="m-t-t-10">
											  <span class="return-title-texts">Finding</span><br>
											  <span class="return-title-texts-details">Please add Findings</span>
										</div>

                                        <div class="form-group input-margin-10">
                                        <textarea class="form-control" rows="5" name="pre_finding"
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 130px;border-color: #d0effa;padding: 10px;"
                                                  spellcheck="false"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="m-t-t-10" style="opacity:0">
                                            <span class="return-title-texts">Finding</span><br>
                                            <span class="return-title-texts-details">Please add Findings</span>
                                        </div>
                                      
											<button type="button" class="btn btnn" data-toggle="modal" data-target="#dropz1" data-imgs="ticketImage"><i class="fa fa-upload"></i> Upload Image</button>
                                       <!--  <div class="upload-btn-wrapper upload-btn-adjst">
                                          <input class="btn btn-outline-info waves-light waves-effect hintsbtn" type="file" multiple="multiple" name="ticketImage[]" id="ticketImage" accept="image/*"/> 
                                            <span id="ticketImageC" style="position: absolute; top: 0.6rem; left: 86%;"></span>
                                        </div>-->


											<button type="button" data-toggle="modal" data-target="#dropz2" data-imgs="ticketEmail" class="btn btnn btn-outline-info"><i class="fa fa-upload"></i> Upload Customer Email</button>
										
                                        <!--<div class="upload-btn-wrapper upload-btn-adjst">
                                            <button class="btn btnn btn-outline-info"><i class="fa fa-upload"></i> Upload Customer Email
                                            </button>
                                            <input type="file" multiple="multiple" name="ticketEmail[]" id="ticketEmail"
                                                   accept="image/*"/>
                                            <span id="ticketEmailC" style="position: absolute; top: 0.6rem; left: 86%;"></span>
                                        </div>-->


										<button type="button" class="btn btnn btn-outline-info" data-toggle="modal" data-target="#dropz3" data-imgs="ticketAudio"><i class="fa fa-upload"></i> Upload Telephony Audio File </button>

										<div class="upload-btn-wrapper upload-btn-adjst">
                                            <input type="file" multiple="multiple" name="ticketAudio[]" id="ticketAudio"
                                                   accept="audio/*"/>
                                            <span id="ticketAudioC" style="position: absolute; top: 0.6rem; left: 86%;"></span>
                                        </div>

                                        <!--<div class="erss" id="vmb">
                                            <div class="upload-btn-wrapper upload-btn-adjst" >
                                                <button type="button" data-toggle="modal" data-target="#view_img" class="btn btnn btn-outline-info waves-light waves-effect"><i class="fa fa-eye"></i> View Upload Images </button>
                                            </div>
                                        </div>-->

                                    </div>





                                </div>

                                

                                



                                <div>



                                    <span class="return-title-texts">Proposed Outcome</span><br>



                                    <span class="return-title-texts-details">Please Select Proposed Outcome</span>





                                    <div class=" col-md-3 m-t-t-10">



                                        <label class="select input-margin-10">

                                            <select name="pre_outcome" id="country" class="required input-border-blue">

                                                <option value="">Select Proposed Outcome</option>

                                                <option value="Collect & Refund">Collect & Refund</option>

                                                <option value="Replace FOC - SWAPIT">Replace FOC - SWAPIT</option>

                                                <option value="No Return or Replacement">No Return or Replacement

                                                </option>

                                                <option value="Refund Only">Refund Only</option>

                                                <option value="Replace FOC">Replace FOC</option>

                                            </select>

                                            <i></i> </label>

                                    </div>





                                </div>
                        <br>
                            <div class="row float-left">
                                 <a  href="<?= main_url ?>tickets/returns"  role="button" class="btn btn-outline-primary waves-light waves-effect width-select btn-countinue  p-6-28" style="margin-left:10px;"> Back </a>
                            </div>

                                <div class="row float-right">

                                    <button type="button" id="sub"

                                            class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 p-6-28">

                                        SUBMIT TICKET

                                    </button>

                                </div>





                            </form>



                        <?php } ?>

                        

                        

                        

                   





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

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel" style="text-align: center !important;">HINTS & TIPS</h4>
                    <p class="timeline-detail text-center">Please check following points which can help out to further
                        investigate this case</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                    <table class="table table-bordered taable-bordered f-14">
                        <thead>
                        <tr>
                            <th class="text-center">Sr.</th>
                            <th>Questions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Order history reviewed?</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Emails reviewed?</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Live Chats reviewed?</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Phone calls checked & listened to?</td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Prior complaints/returns etc? (This customer/material/issue)</td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Control Samples checked?</td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>Test printing (including template issues) checked?</td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td>Any relevant Print Job reference included?</td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td>Returns – stock item? Consider requesting sales report?</td>
                        </tr>
                        <tr>
                            <td class="text-center">10</td>
                            <td>Images sent to support reason for contact attached?</td>
                        </tr>
                        <tr>
                            <td class="text-center">11</td>
                            <td>Copy of relevant emails/live chats set out in this document?</td>
                        </tr>
                        <tr>
                            <td class="text-center">12</td>
                            <td>Copy of order details or other relevant back office info attach</td>
                        </tr>
                        <tr>
                            <td class="text-center">13</td>
                            <td>Screenshots of relevant website info attached (to include URL info)</td>
                        </tr>
                        <tr>
                            <td class="text-center">14</td>
                            <td>Links to websites used in research (e.g. printer manuals) attached</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                    <span class="m-t-t-10">
                        <button type="button"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 p-6-27"
                                data-dismiss="modal">CLOSE</button>
                        </span>
                    </div>
                </div>
            </div>
		</div>
        <!-- /.modal-content -->
	</div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="view_img" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
	<div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Upload images</h4>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
					<div class="gallery return_img_modal row"></div>
					<div class="gallery1 return_img_modal row"></div>
					<div class="gallery4 return_img_modal row"></div>

                    <div class="text-center">
                    <span class="m-t-t-10">
                        <button type="button"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 p-6-27"
                                data-dismiss="modal">CLOSE</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
	<!-- /.modal-dialog -->
</div>



<!-- Modal1 -->
<div id="dropz1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
	  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Image</h4>
      </div>
		<div class="modal-body">
		  
			<div class="row">
				<div class="col-md-2"></div>
				<div id="phototab" class=" col-md-8 col-md-push-2">
																			
					<div id="phototab-dropzone1" class="dropzone">
						<div class="dz-default dz-message">
							<span>Drop files here to upload</span> <br />
						</div> 
					</div>
				
				</div>
			</div>
			  
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>

  </div>
</div>
<!-- Modal1 -->


<!-- Modal2 -->
<div id="dropz2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
	  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Customer Email</h4>
      </div>
		<div class="modal-body">
		  
			<div class="row">
				<div class="col-md-2"></div>
				<div id="phototab" class=" col-md-8 col-md-push-2">
																			
					<div id="phototab-dropzone2" class="dropzone">
						<div class="dz-default dz-message">
							<span>Drop files here to upload</span> <br />
						</div> 
					</div>
				
				</div>
			</div>
			  
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>

  </div>
</div>
<!-- Modal2 -->



<!-- Modal3 -->
<div id="dropz3" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
	  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Telephony Audio File </h4>
      </div>
		<div class="modal-body">
		  
			<div class="row">
				<div class="col-md-2"></div>
				<div id="phototab" class=" col-md-8 col-md-push-2">
																			
					<div id="phototab-dropzone3" class="dropzone">
						<div class="dz-default dz-message">
							<span>Drop files here to upload</span> <br/>
						</div> 
					</div>
				
				</div>
			</div>
			  
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>

  </div>
</div>
<!-- Modal3 -->








<!-- Designer Checklist End -->



<script type="text/javascript">

    $(document).ready(function () {
		
        var $chk_out_order = $('#is_another').val();
        if($chk_out_order){
           swal("Warning!", "You have entered another customer order No#!", "warning");
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


    $('#gos').click(function () {
		
        var vals = $('#orderNumber').val();
        if (vals) {
            $('#byOrderNum').submit();
        } else {
            $('#orderNumber').focus();
            $('#orderNumber').prop('required', true);
        }
    });

    $('#searchByCustomerName').click(function () {
        url = $(location).attr('href');
        url = url.substr(0, url.lastIndexOf("/"));
        window.location.href = url + '?form=customer';
    });


    $('.chBox').change(function () {
        var rowNo = $(this).attr('data-rowNo');
        console.log(rowNo);
        if ($(this).is(':checked')) {
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

        if (chk_len == countselect) {
            $('#sub').attr('type', 'submit');
        } else {
            $('#sub').attr('type', 'button');
        }
    });

    $('.qty').change(function () {

        var qty = $(this).val();
        var dataNo = $(this).attr('data-qty');

        var batch = $('[data-batch=' + dataNo + ']').attr('value');
        var ProductBrand = $('[data-ProductBrand=' + dataNo + ']').attr('value');
        var ManufactureID = $('[data-ManufactureID=' + dataNo + ']').attr('value');

        var labels = $('[data-labels=' + dataNo + ']').attr('value');
        var Print_Type = $('[data-Print_Type=' + dataNo + ']').attr('value');
        var FinishType = $('[data-FinishType=' + dataNo + ']').attr('value');
        var Printing = $('[data-Printing=' + dataNo + ']').attr('value');
        var SerialNumber = $('[data-SerialNumber=' + dataNo + ']').attr('value');

        if (qty < 1) {
            $(this).val(1);
        }

        checkMinQty(ProductBrand, qty, batch, ManufactureID, Printing, dataNo);
        var newQty = $(this).val();
        getPrice(ProductBrand, ManufactureID, newQty, batch, dataNo, labels, Print_Type, FinishType, Printing, SerialNumber);
    });

    function checkMinQty(ProductBrand, qty, batch, ManufactureID, Printing, dataNo) {

        if (ProductBrand == "Integrated Labels" || ProductBrand == "Roll Labels") {
            if (ProductBrand == "Integrated Labels") {
                var minroll = $('[data-min_qty_integrated=' + dataNo + ']').attr('value');
                var maxroll = $('[data-max_qty_integrated=' + dataNo + ']').attr('value');

                minqty = parseInt(minroll);
                maxqty = parseInt(maxroll);
                qty = parseInt(qty);
                pack = parseInt(batch);

                minqty = pack;
                if (qty < minqty) {
                    //alert("Please enter quantity from "+minqty);
                    swal("Warning!", "Please enter quantity from " + minqty, "warning");
                    $('[data-qty=' + dataNo + ']').val(minqty);
                    return false;
                }
                else if (qty % minqty != 0) {
                    var multipyer = minqty * parseInt(parseInt(qty / minqty) + 1);
                    if (multipyer > maxqty) {
                        multipyer = maxqty;
                    }
                    swal("Warning!", "Sorry, these labels are only available in sets of " + minqty + " sheets Pack.", "warning");
                    $('[data-qty=' + dataNo + ']').val(multipyer);
                }
            }

            if (ProductBrand == "Roll Labels") {
                if (Printing == "Y") {

                    var pmin = $('[data-calulate_min_rolls=' + dataNo + ']').attr('value');
                    var pmax = $('[data-calulate_max_rolls=' + dataNo + ']').attr('value');

                    minqty = pmin;
                    maxqty = pmax;
                    if (qty < minqty || qty > maxqty) {
                        swal("Warning!", "Please enter quantity from " + minqty + " to " + maxqty, "warning");
                        return false;
                    } else if (qty % minqty != 0) {
                        var multipyer = minqty * parseInt(parseInt(qty / minqty) + 1);
                        if (multipyer > 800) {
                            multipyer = 800;
                        }

                        swal("Warning!", "Sorry, these labels are only available in sets of " + minqty + " rolls.", "warning");
                        $('[data-qty=' + dataNo + ']').val(multipyer);
                        return false;
                    }
                }
            }
        } else {

            if (ProductBrand == 'SRA3 Label') {
                minqty = 100;
                maxqty = 100000000;
                var msg = "Minimum Quantity Should be 100 !";
                var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
            }

            else if (ProductBrand == 'Application Labels') {
                minqty = 1;
                maxqty = 100000000;
                var msg = "Minimum Quantity Should be 1 !";
                var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
            }

            else if (ProductBrand == 0) {
                minqty = 1;
                maxqty = 100000000;
                var msg = "Minimum Quantity Should be 1 !";
                var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
            }
            else {
                maxqty = 100000000;
                minqty = 25;
                var msg = "Minimum Quantity Should be 25 !";
                var max_msg = "Maximum Quantity Should be " + maxqty + " Sheets !";
            }

            if (qty < parseInt(minqty)) {
                swal("Warning!", msg, "warning");
                $('[data-qty=' + dataNo + ']').val(minqty);
            }
            else if (qty > parseInt(maxqty)) {
                swal("Warning!", max_msg, "warning");
            }
        }
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

    $('#sub').click(function () {
        var chk_box_chk = $('input.chBox:checked').length;
        if (0 == chk_box_chk) {
            $(this).attr('type', 'button');
            swal("Warning!", "Please Choose atleast one order", "warning");
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
    });

	function getAllValues() {

		getTicketDetails();
        var vals = $('#order_details_data').val();
        if (vals) {
            return true;
        } else {
            return false;
        }
	}

    function getTicketDetails() {
		
        var images = [];
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
            var returnQty = $('[data-qty=' + sThisVal + ']').attr('value');
            var newUnitPrice = $('[data-newUnitPrice=' + sThisVal + ']').attr('value');
            var newTotalPrice = $('[data-newTotalPrice=' + sThisVal + ']').attr('value');
            var currency = $('[data-currency=' + sThisVal + ']').attr('value');

            images.push({
                'orderNumber': OrderNumber,
                'SerialNumber': Serialnumber,
                'qty': returnQty,
                'reportedFault': reportedFault,
                'unitPrice': newUnitPrice,
                'TotalPrice': newTotalPrice,
                'currency': currency
            });
            var myJSON = JSON.stringify(images);
            $('#order_details_data').empty("");
            $('#order_details_data').val(myJSON);
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

	function imagesPreview(input, placeToInsertImagePreview) {

		if (input.files) {
			if(placeToInsertImagePreview=='div.gallery') {   $(placeToInsertImagePreview).empty(); }
            if(placeToInsertImagePreview=='div.gallery1'){   $(placeToInsertImagePreview).empty(); }
            if(placeToInsertImagePreview=='div.gallery4'){   $(placeToInsertImagePreview).empty(); }
			var filesAmount = input.files.length;

			for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
				reader.onload = function(event) {
					if(placeToInsertImagePreview == 'div.gallery1' || placeToInsertImagePreview=='div.gallery'){
                        $($.parseHTML('<img class="return_img_modal_view col-md-2">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }
                    if(placeToInsertImagePreview == 'div.gallery4'){
                         $($.parseHTML('<audio controls><source src="'+event.target.result+'"  type="audio/ogg"><source src="'+event.target.result+'" type="audio/mpeg"></audio>')).appendTo(placeToInsertImagePreview);
                    }
				}
                reader.readAsDataURL(input.files[i]);
            }
            $('#vmb').removeClass('erss');
        }
    }

	var filesArray = [];
	function ck(input,placeToInsertImagePreview){

        var filesLength = input.files.length;

        for (var i = 0; i < filesLength; i++) {
            var fileReader = new FileReader();
            var fc = 0;
			fileReader.onload = function(e) {

				$($.parseHTML('<span class="pip"><img class="imageThumb" id="cld'+fc+'"  src=""><br><span class="remove" data-del="'+fc+'">Remove image</span></span>')).appendTo(placeToInsertImagePreview);
				$('#cld'+fc).attr('src', e.target.result);
				$(".remove").click(function(){
					$(this).parent(".pip").remove();
				});
				
                fc++;
            }
			
			filesArray.push(input.files[i]);
            fileReader.readAsDataURL(input.files[i]);
		}
        $('#vmb').removeClass('erss');
    }

    function removeFile( index ){
        filesArray.splice(index, 1);
    }

	$(document).on('click', '.remove',function(e){

		var image = $(this).attr('data-del');
		//console.log(image+' Image id');
		//console.log(image.index());
		// Remove the image from the array by getting it's index.
		// NOTE: The order of the filesArray will be the same as you see it displayed, therefore
		//       you simply need to get the file's index to "know" which item from the array to delete.

		//console.log('Files:' ,filesArray);
		removeFile(image);
		//console.log('Files:' ,filesArray);
		$(this).remove();
		$('#ticketImage').val(filesArray);
	});

    
    document.getElementById("ticketImage").addEventListener("change", function () {
        var len = this.files.length;
        var name = this.files[0].name;
	
       if (len == 1) {
            $('#ticketImageC').text(len + ' File');
        } else {
            $('#ticketImageC').text(len + ' Files');
        }
        imagesPreview(this, 'div.gallery');
    });
	
    document.getElementById("ticketEmail").addEventListener("change", function () {
        var len = this.files.length;
        var name = this.files[0].name;
        if (len == 1) {
            $('#ticketEmailC').text(len + ' File');
        } else {
            $('#ticketEmailC').text(len + ' Files');
        }
        imagesPreview(this, 'div.gallery1');
    });
	
    document.getElementById("ticketAudio").addEventListener("change", function () {
        var len = this.files.length;
        var name = this.files[0].name;
        if (len == 1) {
			$('#ticketAudioC').text(len + ' File');
        } else {
            $('#ticketAudioC').text(len + ' Files');
        }
        imagesPreview(this,'div.gallery4');
    });

    function getCustOrders(name,email_address, ph_no, duration) {
        $.ajax({
            type: "post",
            async: "false",
            url: mainUrl + "tickets/addTickets/fetchOrdersBycustomer",
            cache: false,
            data: {
				name:name,
                email_address: email_address,
                ph_no: ph_no,
                duration: duration
            },
            dataType: 'html',
            success: function (data) {
                data = $.parseJSON(data);
                appendOrderNum(data);
            },
            error: function () {
                swal("Error!", "Error while request..", "error");
            }
        });
    }


    function appendOrderNum(data) {
        $('#ordernumOpt').empty();
        $('#ordernumOpt').append("<option value=''>Please Choose</option>");

        data.forEach(function (item, index, array) {
            var orderNumber = array[index]['OrderNumber']
			$('#ordernumOpt').append("<option value=" + orderNumber + ">" + orderNumber + "</option>");
        });
	}
	
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

      $('#slider-container').slider({
          range: true,
          min: 299,
          max: 1099,
          values: [299, 1099],
          create: function() {
              $("#amount").val("$299 - $1099");
          },
          slide: function (event, ui) {
              $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
              var mi = ui.values[0];
              var mx = ui.values[1];
              filterSystem(mi, mx);
		  }
      });


  function filterSystem(minPrice, maxPrice) {

      $("#computers div.system").hide().filter(function () {
          var price = parseInt($(this).data("price"), 10);
          console.log(price);
          return price >= minPrice && price <= maxPrice;
      }).show();
  }

$("#ticketImage").on("change", "input", function(event){
    $('#ticketImageC').append('<input id="ticketImage" type="file" name="ticketImage[]"/>')
});



</script>

<script>

	function delete_from_lisiting(file,token,id){
  
		var conf =confirm("You are about to delete photo?");
		if(conf){
			$.ajax({
				url: mainUrl + 'tickets/addTickets/delete_from_printing_files/',
				type:"POST",
				async:"false",
				dataType: "html",
				data: {
					file:file,
					token:token
				},
				success: function(data){
					if(id!=''){
						$('#image_box_'+id).remove();
					}
				}  
	
			});
		}
	}



 
	$("#phototab-dropzone1").dropzone({
	  
		url: mainUrl + "tickets/addTickets/upload_printing_files",
		acceptedFiles: 'image/*',
		init: function() {
			
	
			this.on('sending', function(file, xhr, formData){
				var token = $('#token').val();
				formData.append('token', token);
				formData.append('type','ticketImage');
			});
		  
		  this.on("success", function(file, responseText) {
			  
			  if(responseText!='error'){
				  var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span></div>');
  
				  var _this = this;
				  removeButton.addEventListener("click", function(e) {
					  e.preventDefault();
					  e.stopPropagation();
					  var token = $('#token').val();
					  delete_from_lisiting(responseText,token);
					  _this.removeFile(file);
				  });
				  file.previewElement.appendChild(removeButton);
			  }
		  });
	  },

	});
	
		$("#phototab-dropzone2").dropzone({
	  acceptedFiles: 'image/*',
		url: mainUrl + "tickets/addTickets/upload_printing_files",
		init: function() {
			
			
	
			this.on('sending', function(file, xhr, formData){
				var token = $('#token').val();
				formData.append('token', token);
				formData.append('type','ticketEmail');
			});
		  
		  this.on("success", function(file, responseText) {
			  
			  if(responseText!='error'){
				  var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span></div>');
  
				  var _this = this;
				  removeButton.addEventListener("click", function(e) {
					  e.preventDefault();
					  e.stopPropagation();
					  var token = $('#token').val();
					  delete_from_lisiting(responseText,token);
					  _this.removeFile(file);
				  });
				  file.previewElement.appendChild(removeButton);
			  }
		  });
	  },

	});
	
	$("#phototab-dropzone3").dropzone({
	  
		url: mainUrl + "tickets/addTickets/upload_printing_files",			
		acceptedFiles: 'audio/*',
		init: function() {
	
			this.on('sending', function(file, xhr, formData){
				var token = $('#token').val();
				formData.append('token', token);
				formData.append('type','ticketAudio');
			});
			
			
		  
			this.on("success", function(file, responseText) {
			  
				if(responseText!='error'){
					var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span></div>');
  
					var _this = this;
					removeButton.addEventListener("click", function(e) {
						e.preventDefault();
						e.stopPropagation();
						var token = $('#token').val();
						delete_from_lisiting(responseText,token);
						_this.removeFile(file);
					});
					file.previewElement.appendChild(removeButton);
				}
		  });
	  },

	});
</script> 
  




