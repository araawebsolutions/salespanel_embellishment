<?php 
	$user_id = $this->session->userdata('UserTypeID');
	$date = strtotime(date('Y-m-d h:i:s'));
	$token =  md5(uniqid($date, true));
?>

<link href="<?= ASSETS ?>assets/css/dropzone.css" rel="stylesheet" type="text/css"/>
<script src="<?= ASSETS ?>assets/js/dropzone.js"></script>.

<style>
    .byCustName{
        display: none;
    }
    
    .erss{
        display: none;
        color: crimson;
    }
    
    .input{
        color: transparent !important ;
        text-shadow: 0 0 0 #817d7d;
        cursor: pointer;
    }

    .input:focus{
        outline: none;
    }
    .bs-placeholder{
        margin-top: 0px !important;
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
                            <span class="return-title-text">Please Fill This Form To Update Enquiry</span>

                        </div>
                    </div>
                    
                    <div class="card-body">
                     

                        <?php if($result['customerDetails']){ ?>
                        <div class="alert alerts-custom alert-dismissible fade show sweet-alert" role="alert">
                                   
                            <span><b>Customer Name:</b> <?php echo $result['customerDetails'][0]['Name']; ?></span> | <span><b>Address:</b> <?php echo $result['customerDetails'][0]['address']; ?></span>
                            | <span><b>Email Addresss:</b> <?php echo $result['customerDetails'][0]['Billingemail']; ?></span> | <span><b>Phone Number:</b> <?php echo $result['customerDetails'][0]['Billingtelephone']; ?></span>
                        </div>
                        <?php } ?>
                        
                        
                        <input type="" id="focu" style="opacity:0;cursor: default;height: 1px; width: 0;" readonly>
                        <table class="table table-bordered mb-0 returns-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Post Code</th>
                                    <th>Country</th>
                                    <th>Description</th>
                                    <th width="15%">Reported Fault</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                <?php //echo '<pre>'; print_r($result); echo '</pre>'; ?>
                                <?php 
                                    if($result['ticketDetails'])
                                    { 
                                        $i = 1; 
                                        foreach($result['ticketDetails'] as $res)
                                        { ?>
                                        
                                <?php   
                                            $curr = $res['currency'];
                                                                   
                                            if($curr=="GBP"){ $sym = '&pound;';}
                                            else if($curr=="EUR"){ $sym = '&euro;';}
                                            else if($curr=="USD"){ $sym = '$';}
                                    
                                ?>
                                <tr>
                                    <td><?php echo $res['OrderNumber']; ?></td>
                                    <td><?php echo $res['BillingFirstName']; ?></td>
                                    <td><?php echo $res['BillingLastName']; ?></td>
                                    <td><?php echo $res['BillingPostcode']; ?></td>
                                    <td><?php echo $res['BillingCountry']; ?></td>
                                    <td><b><?php echo $res['ManufactureID']; ?></b> - <?php echo $res['ProductName']; ?></td>
                                    <td>
                                        <div class="order-line">
                                            <select class="form-control return-input fault" id="report_<?php echo $i ?>" data-report="<?php echo $i ?>" disabled>
                                                <option value="">Please Select Fault</option>
                                                <option value="Customer Order Error" <?php if($res['reportedFault']=="Customer Order Error"){echo "selected";} ?> >Customer Order Error</option>
                                                <option value="Sales Error" <?php if($res['reportedFault']=="Sales Error"){echo "selected";} ?>>Sales Error</option>
                                                <option value="Dispatch Error" <?php if($res['reportedFault']=="Dispatch Error"){echo "selected";} ?>>Dispatch Error</option>
                                                <option value="Production Error" <?php if($res['reportedFault']=="Production Error"){echo "selected";} ?>>Production Error</option>
                                                <option value="Margin Error" <?php if($res['reportedFault']=="Margin Error"){echo "selected";} ?>>Margin Error</option>
                                                <option value="Incorrect Product" <?php if($res['reportedFault']=="Incorrect Product"){echo "selected";} ?>>Incorrect Product</option>
                                                <option value="Fault Product" <?php if($res['reportedFault']=="Fault Product"){echo "selected";} ?>>Fault Product</option>
                                                <option value="Unwanted Print Error" <?php if($res['reportedFault']=="Unwanted Print Error"){echo "selected";} ?>>Unwanted Print Error</option>
                                            </select>
                                            <i></i>
                                            <span id="report_err<?php echo $i ?>" class="erss">Please Choose</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input data-qty="<?php echo $i; ?>" type="number" class="form-control form-control-sm return-input qty" placeholder="123456" min="1" value="<?php echo $res['Quantity']; ?>" aria-controls="responsive-datatable" disabled data-qty="<?php echo $i ?>">
                                    </td>
                                    <td>
                                        <span data-price="<?php echo $i; ?>"><?php echo $sym.$res['returnUnitPrice']; ?></span><br>
                                        <input type="hidden" data-currency="<?php echo $i ?>" value="<?php echo $res['currency']; ?>" disabled>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                                    
                                <?php } else{?>
                                <tr>
                                    <td colspan="10" style="text-align:center"> <p>Record not found</p></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <br>
                        <br>
                        
                        
                        
                        <?php if($result){  ?>
                        
                        <form method="post" id="checkout_form" class="labels-form " enctype="multipart/form-data"
                              action="<?= main_url ?>tickets/updateTicket/updateTicket">
                            
							<input type="hidden" id="token" name="token" value="<?=$token?>">
                            <input id="tickStatus" type="hidden" value="<?php echo $result['ticket'][0]['ticketStatus']?>"/>
                            
                            <div class="row m-t-t-10">
                                <div class="col-md-3">
                                    <label class="select input-margin-10">
                                        <select name="contact_type" id="" class="required input-border-blue">
                                            <option value="">Type of Contact</option>
                                            <option class="Email" <?php if($result['ticket'][0]['contact_type']=="Email"){echo "selected";} ?>>Email</option>
                                            <option value="Call" <?php if($result['ticket'][0]['contact_type']=="Call"){echo "selected";} ?>>Call</option>
                                        </select>
                                        <i></i>
                                    </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-margin-10">
                                        <label class="input ">
                                            <input type="text"
                                                   placeholder="Reason for Contact and Customer's Desired Outcome"
                                                   name="contact_reason" id="b_last_name" value="<?php echo $result['ticket'][0]['contact_reason']; ?>"
                                                   class="required input-border-blue">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-margin-10">
                                          <?php if($result['ticket'][0]['ticketStatus']!=4){ ?>
                                        <button type="button"
                                                class="btn btn-outline-info waves-light waves-effect hintsbtn"
                                                data-toggle="modal" data-target=".bs-example-modal-lg">HINTS &
                                            TIPS <i class="mdi mdi-information"></i></button>
                                        <?php } ?>
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
                                                  spellcheck="false"><?php echo $result['ticket'][0]['pre_action_taken'] ?></textarea>
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
                                        <textarea class="form-control" rows="5" name="pre_investigation" style="margin-top: 0px;margin-bottom: 0px;height: 130px;border-color: #d0effa;padding: 10px;" spellcheck="false"><?php echo $result['ticket'][0]['pre_investigation'] ?></textarea>
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
                                                  spellcheck="false"><?php echo $result['ticket'][0]['pre_finding'] ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                     <div class="m-t-t-10" style="opacity:0">
                                        <span class="return-title-texts">Finding</span><br>
                                        <span class="return-title-texts-details">Please add Findings</span>
                                    </div>
                                    
                                       
                                    <div>
                                        <?php  
                                            if(count($result['ticket_images']) > 0){ 
                                                foreach($result['ticket_images'] as $im){ 
                                        ?>
                                                    <div class="return_img_div">
                                                        <a  href="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>" download><img class="return_img" src="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>"></a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        
                                        
                                            <?php if(count($result['ticketEmail']) > 0){ ?>
                                                <?php foreach($result['ticketEmail'] as $im){ ?>
                                                    <div class="return_img_div">
                                                        <a href="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>" download>
                                                        <img class="return_img" src="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>" download>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        
                                            <?php if(count($result['ticketAudio']) > 0){ ?>
                                                <?php foreach($result['ticketAudio'] as $im){ ?>
                                                    <div class="return_img_div_audio">
                                                        <a href="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>" download>
                                                        <audio controls  class="return_img" download>
                                                            <source src="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                    </div>
                                    
                                    
                                   
                                        
                                    <div class="upload-btn-wrapper upload-btn-adjst">
                                        <?php 
                                          if(count($result['ticket_images']) == 0){
                                          if($result['ticket'][0]['ticketStatus']!=4){?>
										<button type="button" class="btn btnn" data-toggle="modal" data-target="#dropz1" data-imgs="ticketImage"><i class="fa fa-upload"></i> Upload Image</button>
                                        <!--<button type="button" class="btn btnn"><i class="fa fa-upload"></i> Upload  Image</button>
                                        <input type="file" multiple="multiple" name="ticketImage[]" id="ticketImage" accept="image/*"/>
                                        <span id="ticketImageC" style="position: absolute; top: 0.6rem; left: 86%;"></span>-->
										
                                        <?php } }?>
                                    </div>       
                                        
                                    <div class="upload-btn-wrapper upload-btn-adjst">
                                        <?php 
                                          if(count($result['ticketEmail']) == 0){
                                          if($result['ticket'][0]['ticketStatus']!=4){?>
										<button type="button" class="btn btnn" data-toggle="modal" data-target="#dropz2" data-imgs="ticketEmail"><i class="fa fa-upload"></i> Upload Customer Email</button>
                                        <!--<button type="button"  class="btn btnn"><i class="fa fa-upload"></i> Upload Customer Email</button>
                                        <input type="file" multiple="multiple" name="ticketEmail[]" id="ticketEmail" accept="image/*"/>
                                        <span id="ticketEmailC" style="position: absolute; top: 0.6rem; left: 86%;"></span>-->
                                        <?php } }?>
                                    </div>   
                                       
                                     
                                    <div class="upload-btn-wrapper upload-btn-adjst">
                                        <?php 
                                          if(count($result['ticketAudio']) == 0){
                                          if($result['ticket'][0]['ticketStatus']!=4){?>

										<button type="button" class="btn btnn btn-outline-info" data-toggle="modal" data-target="#dropz3" data-imgs="ticketAudio"><i class="fa fa-upload"></i> Upload Telephony Audio File </button>
										
                                        <!--<button type="button" class="btn btnn"><i class="fa fa-upload"></i> Upload Telephone Audio File </button>
                                        <input type="file" multiple="multiple" name="ticketAudio[]" id="ticketAudio" accept="audio/*"/>
                                        <span id="ticketAudioC" style="position: absolute; top: 0.6rem; left: 86%;"></span>-->
                                        <?php } }?>
                                    </div>
                                    
                                     <div class="erss" id="vmb">
                                        <div class="upload-btn-wrapper upload-btn-adjst" >
                                            <button  type="button"  data-toggle="modal" data-target="#view_img" class="btn btnn btn-outline-info waves-light waves-effect"><i class="fa fa-eye"></i> View Upload  Images </button>
                                        </div>
                                    </div>
                                     
                                    
                                </div>
                            </div>

                            <div>
                                <span class="return-title-texts">Proposed Outcome</span><br>
                                <span class="return-title-texts-details">Please Select Proposed Outcome</span>


                                <div class=" col-md-3 m-t-t-10" style="margin-top:0px !important;">

                                    <label class="select input-margin-10">
                                        <select name="pre_outcomes" id="pre_outcome" class="required input-border-blue" <?php if($result['ticket'][0]['ac_outcome']!=""){echo 'disabled';} ?> >
                                            <option value="" >Select Proposed Outcome</option>
                                            <option value="Collect & Refund" <?php if($result['ticket'][0]['pre_outcome']=="Collect & Refund"){echo "selected";} ?> >Collect & Refund</option>
                                            <option value="Replace FOC - SWAPIT" <?php if($result['ticket'][0]['pre_outcome']=="Replace FOC - SWAPIT"){echo "selected";} ?> >Replace FOC - SWAPIT</option>
                                            <option value="No Return or Replacement" <?php if($result['ticket'][0]['pre_outcome']=="No Return or Replacement"){echo "selected";} ?> >No Return or Replacement</option>
                                            <option value="Refund Only" <?php if($result['ticket'][0]['pre_outcome']=="Refund Only"){echo "selected";} ?> >Refund Only</option>
                                            <option value="Replace FOC" <?php if($result['ticket'][0]['pre_outcome']=="Replace FOC"){echo "selected";} ?> >Replace FOC</option>
                                        </select>
                                        <i></i> 
                                    </label>
                                    
                                    <input type="hidden" name="pre_outcome" id="hpre_outcome" value="<?php echo $result['ticket'][0]['pre_outcome']; ?>">
                                </div>
                            </div>
                        
                            <input type="hidden" value="<?php echo $result['ticket'][0]['ticket_id']; ?>" name="ticket_id">
                            
                            <?php if(($this->session->userdata('UserTypeID')=='50' || $result['ticket'][0]['ac_outcome']!="") &&    $result['ticket'][0]['pre_outcome']!=""){ ?>
                            <div class="m-t-t-10">
                                <span class="return-title-texts">Acutal Outcome</span><br>
                                <span class="return-title-texts-details">Please Select Actual Outcome</span>

                                <div class="row">
                                    <div class=" col-md-3 m-t-t-10">

                                        <label class="select input-margin-10">
                                         
                                            <select name="ac_outcomes" id="ac_outcome" class="required input-border-blue" <?php if($result['ticket'][0]['ac_outcome']==""){ echo "required";} ?>  <?php if($this->session->userdata('UserTypeID')!="50"){ echo "disabled";} else if($result['ticket'][0]    ['exp_reffNo']!=""){echo 'disabled';} ?>>
                                                <option value="" >Select Proposed Outcome</option>
                                                <option value="Collect & Refund" <?php if($result['ticket'][0]['ac_outcome']=="Collect & Refund"){echo "selected";} ?> >Collect & Refund</option>
                                                <option value="Replace FOC - SWAPIT" <?php if($result['ticket'][0]['ac_outcome']=="Replace FOC - SWAPIT"){echo "selected";} ?> >Replace FOC - SWAPIT</option>
                                                <option value="No Return or Replacement" <?php if($result['ticket'][0]['ac_outcome']=="No Return or Replacement"){echo "selected";} ?> >No Return or Replacement</option>
                                                <option value="Refund Only" <?php if($result['ticket'][0]['ac_outcome']=="Refund Only"){echo "selected";} ?> >Refund Only</option>
                                                <option value="Replace FOC" <?php if($result['ticket'][0]['ac_outcome']=="Replace FOC"){echo "selected";} ?> >Replace FOC</option>
                                            </select>
                                            <i></i> </label>
                                    
                                        <input type="hidden" name="ac_outcome" id="hac_outcome" value="<?php echo $result['ticket'][0]['ac_outcome']; ?>">
                                    </div>
                                     
                                    <div class=" col-md-3 m-t-t-10">

                                        <label class="select input-margin-10">
                                       
                                            <select name="reffTo_o" id="reffTo_o" class="required input-border-blue" <?php if($result['ticket'][0]['ac_outcome']==""){ echo "required";} ?>  <?php if($this->session->userdata('UserTypeID')!="50"){ echo "disabled";} else if($result['ticket'][0]['exp_reffNo']!=""){echo 'disabled';} ?>>
                                                
                                                <option value="" >Select Refferd To</option>
                                                <?php foreach($reffers as $refe){?>
                                                    <option value="<?= $refe['UserID']?>" <?php if($result['ticket'][0]['reffTo']==$refe['UserID']){echo "selected";} ?> ><?php echo $refe['UserName'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <i></i> </label>
                                         
                                        <input type="hidden" name="reffTo" id="reffTo" value="<?php echo $result['ticket'][0]['reffTo']; ?>">
                                    </div>
                                     
                                    <div class=" col-md-3 m-t-t-10">

                                        <label class="select input-margin-10">
                                       
                                            <select name="reff_for_o" id="reff_for_o" class="required input-border-blue" <?php if($result['ticket'][0]['ac_outcome']==""){ echo "required";} ?>  <?php if($this->session->userdata('UserTypeID')!="50"){ echo "disabled";} else if($result['ticket'][0]['exp_reffNo']!=""){echo 'disabled';} ?>>
                                                <option value="" >Select the Reason for Referral</option>
                                                <option value="for Decision" <?php if($result['ticket'][0]['reff_for']=="for Decision"){echo "selected";} ?> >for Decision</option>
                                                <option value="for further investigation" <?php if($result['ticket'][0]['reff_for']=="for further investigation"){echo "selected";} ?> >for further investigation</option>
                                                <option value="for actioning" <?php if($result['ticket'][0]['reff_for']=="for actioning")  {echo "selected";} ?> >for actioning</option>
                                           
                                            </select>
                                            <i></i> </label>
                                         
                                        <input type="hidden" name="reff_for" id="reff_for" value="<?php echo $result['ticket'][0]['reff_for']; ?>">
                                    </div>
                                    
                                    
                                    <?php
                            
                            $ShipingService = $this->updateTicket_model->getShipingService($result['ticketDetails'][0]['Country_id']);
                            //echo '<pre>';  print_r($ShipingService); echo '</pre>';
                                    ?>
                                </div>
                                
                                <div class=" col-md-12 m-t-t-10">

                                    <div class="form-group input-margin-10">
                                        <textarea class="form-control" rows="5" 
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 100px;border-color: #d0effa;padding: 10px;"
                                                  spellcheck="false" name="ac_action" <?php if($result['ticket'][0]['ac_action']==""){ echo "required"; } ?> <?php if($result['ticket'][0]['ac_action']!=""){ echo "disabled";} ?>><?php echo $result['ticket'][0]['ac_action']; ?></textarea>
                                          
                                        <?php if($result['ticket'][0]['ac_action']!=""){ ?>
                                        <input type="hidden" name="ac_action" value="<?php echo $result['ticket'][0]['ac_action']; ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                         
                            <div class="m-t-t-10">
                                <span class="return-title-texts">Process Area Concerned</span><br>
                                <span class="return-title-texts-details">Please Select Process Area Concerned</span>

                                <div class="row">
                                    <div class=" col-md-3 ">
                                           <?php 
                                           $area_re = $result['ticket'][0]['areaResponsible'];
                                            $area_re = explode(',',$area_re);
                                        ?>
                                        <label class="select input-margin-10">
                                         
                                            <select name="area_resp[]" id="area_rep_pic" multiple data-live-search="false" class="required input-border-blue selectpicker" <?php if($this->session->userdata('UserTypeID')!="50"){ echo "disabled";} ?> >
                                                <option value="Design Team" <?php if(in_array('Design Team',$area_re)){echo 'selected';} ?> >Design Team</option>
                                                <option value="Data Team" <?php if(in_array('Data Team',$area_re)){echo 'selected';} ?>>Data Team</option>
                                                <option value="Developement" <?php if(in_array('Developement',$area_re)){echo 'selected';} ?>>Developement</option>
                                                <option value="Printing" <?php if(in_array('Printing',$area_re)){echo 'selected';} ?>>Printing</option>
                                                <option value="Production" <?php if(in_array('Production',$area_re)){echo 'selected';} ?>>Production</option>
                                                <option value="Despatch and QC" <?php if(in_array('Despatch and QC',$area_re)){echo 'selected';} ?>>Despatch & QC</option>
                                                <option value="Courier" <?php if(in_array('Courier',$area_re)){echo 'selected';} ?>>Courier</option>
                                            </select>
                                            <i></i> </label>
                                    </div>
                                     
                                    <div class=" col-md-12 m-t-t-10">
                                        <span class="return-title-texts-details">Please Add Process Area Concerned Comments</span>
                                        <div class="form-group input-margin-10">
                                            <textarea class="form-control" rows="5"
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 100px;border-color: #d0effa;padding: 10px;"
                                                  spellcheck="false" name="area_resp_com" <?php if($this->session->userdata('UserTypeID')!="50"){ echo "disabled";} ?> ><?php echo $result['ticket'][0]['ac_area_resp_c']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            
                                <?php } ?>
                            
                                <?php if($result['ticket'][0]['ac_outcome']=="Collect & Refund" || $result['ticket'][0]['ac_outcome']=="Replace FOC - SWAPIT" || $result['ticket'][0]['ac_outcome']=="Refund Only" || $result['ticket'][0]['ac_outcome']=="Replace FOC" ){ ?>
                                <br>
                                <div class="m-t-t-10">
                                
                                    <span class="return-title-texts">Collection and / or Replacement Order Details</span><br>

                                    <div class="row">
                                        <?php if($result['ticket'][0]['ac_outcome']!="Replace FOC - SWAPIT"){?>
                                        <div class=" col-md-3 m-t-t-10">
                                        
                                        <label class="input input-margin-10 "> <i
                                                class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" placeholder="Please Enter Refference Number" name="exp_reff_no"
                                                   id="reff_no" value="<?php echo $result['ticket'][0]['exp_reffNo']; ?>" class="required input-border-blue"
                                                   data-content="" data-original-title="" title="" required>
                                        </label>
                                    </div>


                                    <div class=" col-md-3 m-t-t-10">

                                        <label class="select input-margin-10">
                                       
                                            <select name="exp_courier" id="exp_courier" class="required input-border-blue">
                                                <option value="" >Select Courier</option>
                                                <option value="DPD" <?php if($result['ticket'][0]['exp_courier']=="DPD"){echo "selected";} ?>>DPD</option>
                                                <option value="UPS" <?php if($result['ticket'][0]['exp_courier']=="UPS"){echo "selected";} ?>>UPS</option>
                                                <option value="Parcelforce" <?php if($result['ticket'][0]['exp_courier']=="Parcelforce"){echo "selected";} ?>>Parcelforce</option>
                                                <option value="Royal" <?php if($result['ticket'][0]['exp_courier']=="Royal"){echo "selected";} ?>>Royal Mail</option>
                                            </select>
                                            <i></i> </label>
                                    </div>
                                    <?php } ?>

                                    <div class=" col-md-3 m-t-t-10">

                                        <label class="input input-margin-10"><i
                                                class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" class="input" placeholder="Please add Expected Date" data-toggle="datepicker" name="exp_collection_date"
                                                               value="<?php if($result['ticket'][0]['exp_collectionDate']!=""){echo date('d/m/Y',$result['ticket'][0]['exp_collectionDate']);}else{echo '';}  ?>" id="exp_collection_date" required onkeydown="return false" autocomplete="off" >
                                            
                                            
                                          </label>
                                    </div>


                                    <div class=" col-md-3 m-t-t-10">

                                         <label class="input input-margin-10"><i
                                                class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" class="input" placeholder="Please add Delivery Date" data-toggle="datepicker" name="exp_delivery_date"
                                                               value="<?php if($result['ticket'][0]['exp_deliveryDate']!=""){echo date('d/m/Y',$result['ticket'][0]['exp_deliveryDate']);}else{echo '';}  ?>" id="exp_delivery_date" required onkeydown="return false" autocomplete="off">
                                          </label>
                                    </div>
                                    

                                </div>

                                <div class="m-t-t-10">
                                    
                                    <span class="return-title-texts">Booking Notes</span><br>
                                    <span class="return-title-texts-details">Please add booking notes here</span>
                                    
                                    <div class=" col-md-12 m-t-t-10">

                                        <div class="form-group input-margin-10">
                                            <textarea class="form-control" rows="5"
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 100px;border-color: #d0effa;padding: 10px;"
                                                  spellcheck="false" placeholder="Enter booking notes here" name="booking_notes"><?php echo $result['ticket'][0]['exp_booking_notes']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                                                    
                                                                    
                                
                                <?php if(($result['ticket'][0]['ac_outcome']=="Collect & Refund" || $result['ticket'][0]['ac_outcome']=="Refund Only" || $result['ticket'][0]['ac_outcome']=="Replace FOC") && ($result['ticket'][0]['exp_collectionDate']!="")){ ?>
                                
                                
                                 <div class="m-t-t-10">
                                    <span class="return-title-texts">Return Receiving Confirmation</span><br>
                                    <span class="return-title-texts-details">Please Fill Information</span>
                                </div>


                                <div class="row">
                                    
                                    <div class=" col-md-2 m-t-t-10">

                                        <label class="input input-margin-10"><i class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" class="input" data-toggle="datepicker" placeholder="Please add Received Date" name="re_received_date" value="<?php if($result['ticket'][0]['re_received_date']!=""){echo date('d/m/Y',$result['ticket'][0]['re_received_date']);}else{echo '';}  ?>"   id="re_received_date" required onkeydown="return false" autocomplete="off" >
                                        </label>
                                    </div>


                                    <div class=" col-md-2 m-t-t-10">

                                        <label class="input input-margin-10"> <i
                                                class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="number" min="0" placeholder="Number of boxes" name="re_boxes"
                                                   id="re_boxes" value="<?php echo $result['ticket'][0]['re_boxes']; ?>" class="required input-border-blue"
                                                   data-content="" data-original-title="" title="">
                                        </label>
                                    </div>



                                    <div class=" col-md-2 m-t-t-10">

                                          <label class="input input-margin-10"> <i
                                                class="icon-append fa fa-user icon-appendss"></i>
                                            <input type="text" placeholder="Please add Condition of goods" name="re_condition"
                                                   id="re_boxes" value="<?php echo $result['ticket'][0]['re_condition']; ?>" class="required input-border-blue"
                                                   data-content="" data-original-title="" title="">
                                        </label>
                                    </div>

                                    <?php if(($result['ticket'][0]['ac_outcome']=="Collect & Refund" ) || ($result['ticket'][0]['ac_outcome']=="Refund Only")){ ?>
                                    
                                    <div class=" col-md-2 m-t-t-10">
                                        
                                        <label class="select input-margin-10">
                                            <select name="isShip" id="re_refund" class="required input-border-blue" required>
                                                <option value="">Please Select Shipping Charges Include</option>
                                                
                                                <option value="yes" <?php if($result['ticket'][0]['isShip']=="yes"){echo 'selected';} ?> >Yes</option>
                                                
                                                <option value="no" <?php if($result['ticket'][0]['isShip']=="no"){echo 'selected';} ?>>No</option>
                                            </select>
                                            <i></i> </label>
                                    </div>
                                    <?php } ?>


                                   
                                    <div class=" col-md-2 ">
                                        <div class="upload-btn-wrapper">
                                            <?php if(count($result['ticketReturn']) == 0){ ?>
                                        
                                            <?php foreach($result['ticketReturn'] as $im){ ?>
                                                <div class="return_img_div">
                                                    <img class="return_img" src="<?php echo getTicketImg ?>/<?php echo $im['img_name'] ?>" >
                                                </div>
                                            <?php } ?>
                                        
                                        <?php } else{ ?>
                                        
                                         <?php if($result['ticket'][0]['ticketStatus']!=4){?>
                                        
										<button type="button" data-toggle="modal" data-target="#dropz4" data-imgs="ticketReturn" class="btn btnn btn-outline-info"><i class="fa fa-upload"></i> Upload Image</button>
                                            <!--<button class="btn btnn"><i class="fa fa-upload"></i> Upload Image</button>
											<input type="file" multiple="multiple" name="ticketReturn[]" id="ticketReturn"      accept="image/*"/>
                                            <span id="ticketReturnC" style="position: absolute; top: 0.5rem; left: 80%;"></span>-->
											
                                            <?php } ?>
                                        
                                        <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <div class=" col-md-2 ">
                                        <div class="erss" id="vmbR">
                                            <div class="upload-btn-wrapper " >
                                                <button  type="button"  data-toggle="modal" data-target="#view_img" class="btn btnn"><i class="fa fa-eye"></i> View Upload  Images </button>
                                            </div>
                                        </div>
                                    </div>
                                    </div>


                                <div class=" col-md-12 m-t-t-10">

                                    <span class="return-title-texts">Return Receiving Notes</span><br>
                                    <span class="return-title-texts-details">Please add return receiving notes here</span>
                                      
                                    <div class="form-group input-margin-10">
                                        <textarea class="form-control" rows="5" name="re_notes"
                                                  style="margin-top: 0px;margin-bottom: 0px;height: 100px;border-color: #d0effa;padding: 10px;" placeholder="Enter return receiving notes here"
                                                  spellcheck="false" required><?php echo $result['ticket'][0]['re_notes']; ?></textarea>
                                    </div>
                                </div>
                                <br>
                    
                                <?php } ?>
                            </div>
                            <?php } ?>
                            
                            
                             <?php if($result['ticket'][0]['ticketStatus']!=4){ ?>
                            <br>
								<?php if($result['ticket'][0]['ticketStatus']==2 ||  $result['ticket'][0]['ticketStatus']==0){ ?>
								<div class="row float-left">
									<a href="<?= main_url ?>tickets/returns" ><button    role="button" class="btn btn-outline-primary waves-light waves-effect width-select btn-countinue  p-6-28" style="margin-left:10px;">Back</button> </a>
								</div>
								<?php }?>
                             
                            <div class="row float-right">
                                <button type="submit" id="sub"
                                        class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 p-6-28" >
                                    UPDATE TICKET
                                </button>
                            </div>
                             <?php } ?>

                        </form>
                        
                        <?php } ?>
                        <br>
                        <br>
                        
                        <?php if($result['ticket'][0]['ticketStatus']!=4){ ?>
                            
                        <?php if(($result['ticket'][0]['ac_outcome']=="Collect & Refund" && $result['ticket'][0]['isShip']!="") || ($result['ticket'][0]['ac_outcome']=="Refund Only" && $result['ticket'][0]['isShip']!="")){ ?>
                            <div>
                                <span class="return-title-texts">Final Review / Authorisation</span><br>
                                <span class="return-title-texts-details">Please Review and Authorise</span>


                                    <div class="row">
                                
                                        <?php if($result['ticket'][0]['ticketStatus']==4){ ?>
                                        <div class="col-md-1 p-10">
                                            <button type="button" class="btn btn-outline-info waves-light waves-effect p-6-27" disabled>REFUSE</button>
                                        </div>
                                        <?php } else { ?>
                                        
                                        <div class="col-md-1 p-10">
                                            <button type="button" data-hr="<?php echo main_url ?>/tickets/updateTicket/refuseTicket/<?php echo   $result['ticket'][0]['ticket_id']; ?>" class="btn btn-outline-info waves-light waves-effect p-6-27     confirmation">REFUSE</button> 
                                        </div>
                                        <?php } ?>
                                

                                <div class="col-md-2 p-10">
                                    <?php if($result['ticket'][0]['ticketStatus']==4){ ?>
                                    <button type="button"
                                            class="btn btn-outline-info waves-light waves-effect p-6-27" disabled>GENERATE
                                        CREDIT NOTE
                                    </button>
                                    <?php } else { ?>
                                        <button data-hr="<?php echo main_url ?>/tickets/updateTicket/creatCreditNote/<?php echo   $result['ticket'][0]['ticket_id']; ?>" type="button" class="btn btn-outline-info waves-light waves-effect p-6-27 " id="gen_cr_btn">GENERATE CREDIT NOTE </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } }?>
                        
                        
                     <?php if($result['ticket'][0]['ticketStatus']!=4){ ?>   
                            
                        <?php if(($result['ticket'][0]['ac_outcome']=="Replace FOC - SWAPIT" && $result['ticket'][0]['exp_collectionDate']!="") || ($result['ticket'][0]['ac_outcome']=="Replace FOC" && $result['ticket'][0]['re_received_date']!="") ){ ?>
                            
                            
                     
                        <div>
                            <span class="return-title-texts">Final Review / Authorisation</span><br>
                            <span class="return-title-texts-details">Please Review and Authorise</span>

                                 
                            <?php if($result['ticket'][0]['ticketStatus']==4){ ?>
                            <div class="row">
                                <form class="labels-form" action="#">
                                    <div class="row">
                                        <div class="col-md-5 p-10">
                                            <label class="select input-margin-10">
                                                <select  name="shipDel" class="required input-border-blue" disabled>
                                                    <option value="" >Select Shipping Delivery</option>
                                                    <?php
                                                        $basiccharges = 0.00;        
                                                        foreach ($ShipingService as $res) {
                                                            
                                                            $selected = '';
                                                            if ($res['ServiceID'] == $result['ticket'][0]['shipServiceID']) {
                                                                $basiccharges = $res['BasicCharges'];
                                                                $selected = ' selected="selected" ';
                                                            }
                                                    ?>
                                                    <option value="<?= $res['ServiceID'] ?>" <?= $selected ?> >
                                                        <?php
                                                        if ($res['BasicCharges'] == '0.00') {
                                                            echo $res['ServiceName'];
                                                        } else {
                                                            echo $res['ServiceName'] . ' &nbsp;' . $sym .       number_format($res['BasicCharges'], 2, '.', '');
                                                                        
                                                        }
                                                        ?>
                                                    </option>
                                                    <?php  } ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </div>
                                        <div class="col-md-2 p-10">
                                            <button type="button" class="btn btn-outline-info waves-light waves-effect p-6-27" disabled>REFUSE</button>
                                        </div>
                                        <div class="col-md-2 p-10">
                                            <button  type="button" class="btn btn-outline-info waves-light waves-effect p-6-27" disabled> GENERATE REPLACEMENT ORDER </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                                     
                            <?php } else { ?>
                                
                               
                            <form class="labels-form" action="<?php echo main_url ?>/tickets/updateTicket/creatReplacementOrder/<?php echo   $result['ticket'][0]['ticket_id']; ?>" method="post" id="gen_order">
                                <div class="row">
                                    <div class="col-md-3 p-10">
                                        <label class="select input-margin-10">
                                            <select  name="shipDel" class="required input-border-blue" required>
                                                <option value="" >Select Shipping Delivery</option>
                                                <?php
                                                      
                                                    $basiccharges = 0.00;
                                                    foreach ($ShipingService as $res) {
                                                ?>
                                    
                                                <option value="<?= $res['ServiceID'] ?>">
                                                    <?php
                                                    if ($res['BasicCharges'] == '0.00') {
                                                        echo $res['ServiceName'];
                                                    } else {
                                                        echo $res['ServiceName'] . ' &nbsp;' . $sym .       number_format($res['BasicCharges'], 2, '.', '');
                                                    }
                                                    ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <i></i>
                                        </label>
                                    </div>
                                        
                                    <div class="col-md-1 p-10">
                                        <button type="button" data-hr="<?php echo main_url ?>/tickets/updateTicket/refuseTicket/<?php echo   $result['ticket'][0]['ticket_id']; ?>" class="btn btn-outline-info waves-light waves-effect p-6-27 confirmation">REFUSE</button> 
                                    </div>
                                        
                                    <div class="col-md-2 p-10">
                                            <button  type="submit" id="gen_order_btn" class="btn btn-outline-info waves-light waves-effect p-6-27">GENERATE REPLACEMENT ORDER </button>
                                    </div>
                                           
                                </div>
                                           
                            </form>
                               
                            <?php } ?>
                        </div>
                              
                        <?php } ?>
                        <?php } ?>
                            
                        <?php if($result['ticket'][0]['ticketStatus']!=4){ ?>   
                        <?php if($result['ticket'][0]['ac_outcome']=="No Return or Replacement"){ ?>
                        <div>
                            <span class="return-title-texts">Final Review / Authorisation</span><br>
                            <span class="return-title-texts-details">Please Review and Authorise</span>
                            <div class="row">
                                <div class="col-md-1 p-10">
                                    <button type="button" data-hr="<?php echo main_url ?>/tickets/updateTicket/refuseTicket/<?php echo   $result['ticket'][0]['ticket_id']; ?>" class="btn btn-outline-info waves-light waves-effect p-6-27 confirmation">REFUSE</button> 
                                </div>

                                <div class="col-md-2 p-10">
                                    <button id="gen_vo_btn" type="button" class="btn btn-outline-info waves-light waves-    effect p-6-27">GENERATE VOUCHER CODE </button>
                                </div>
                            </div>
                        </div>
                            
                        <?php } ?>
                        <?php } ?>
							
							
							<?php if($result['ticket'][0]['ticketStatus']!=1 && $result['ticket'][0]['ticketStatus']!=2 &&  $result['ticket'][0]['ticketStatus']!=0){ ?>
                             <div class="row float-left">
                                <a  href="<?= main_url ?>tickets/returns"  role="button" class="btn btn-outline-primary waves-light waves-effect width-select btn-countinue  p-6-28" style="margin-left:10px;">
                                Back</a> 
                             </div>
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
                            <button type="button" data-dismiss="modal"
                                class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 p-6-27">CLOSE</button></span>
                    </div>


                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Designer Checklist End -->

    
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
                        <div class="gallery2 return_img_modal row"></div>
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
	
<!-- Modal4 -->
<div id="dropz4" class="modal fade" role="dialog">
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
																			
						<div id="phototab-dropzone4" class="dropzone">
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
	

<script type="application/javascript">
    
    jQuery(document).ready(function(){
        //alert(ready);
        var area_pi = $('#area_rep_pic').val();
      
        if(area_pi== null || area_pi==""){
            //alert('nullll');
            $('.bootstrap-select .dropdown-toggle .filter-option').text('Select Process Area Concerned');
        }
            
        
        var ticStatus = $('#tickStatus').val();
        if(ticStatus==4){
            //alert(ticStatus);
            $('#checkout_form :input').prop('disabled', true);
            $('#checkout_form :select').prop('disabled', true);
        }    
    });
    
    $('#ticketImage').change(function(){
    
        var len = this.files.length;
        var name = this.files[0].name;;
    
        if(len == 1){
            //$('#ticketImageC').text(name);
            $('#ticketImageC').text(len+' File');
        }else{
            $('#ticketImageC').text(len+' Files');
        }
        imagesPreview(this, 'div.gallery');
    });
    
    $('#ticketEmail').change(function(){
    
        var len = this.files.length;
        var name = this.files[0].name;;
    
        if(len == 1){
            //$('#ticketEmailC').text(name);
            $('#ticketEmailC').text(len+' File');
        }else{
            $('#ticketEmailC').text(len+' Files');
        }
        imagesPreview(this, 'div.gallery1');
    });    
    
    $('#ticketAudio').change(function(){
        var len = this.files.length;
        var name = this.files[0].name;
    
        if(len == 1){
            //$('#ticketAudioC').text(name);
            $('#ticketAudioC').text(len+' File');
        }else{
            $('#ticketAudioC').text(len+' Files');
        }
        
        imagesPreview(this,'div.gallery4');
    });    
    
    $('#ticketReturn').change(function(){
        var len = this.files.length;
        var name = this.files[0].name;
    
        if(len == 1){
            //$('#ticketReturnC').text(name);
            $('#ticketReturnC').text(len+' File');
        }else{
            $('#ticketReturnC').text(len+' Files');
        }
        imagesPreview(this, 'div.gallery2');
    });    
    
    
    function imagesPreview(input, placeToInsertImagePreview) {

        if (input.files) {
            if(placeToInsertImagePreview=='div.gallery') {   $(placeToInsertImagePreview).empty(); }
            if(placeToInsertImagePreview=='div.gallery1'){   $(placeToInsertImagePreview).empty(); }
            if(placeToInsertImagePreview=='div.gallery2'){   $(placeToInsertImagePreview).empty(); }
            if(placeToInsertImagePreview=='div.gallery4'){   $(placeToInsertImagePreview).empty(); }
            
            var filesAmount = input.files.length;
            
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                
                reader.onload = function(event) {
                    /*$($.parseHTML('<img class="return_img_modal_view col-md-2">')).attr('src',   event.target.result).appendTo(placeToInsertImagePreview);*/
                    
                    if(placeToInsertImagePreview == 'div.gallery1' || placeToInsertImagePreview=='div.gallery' || placeToInsertImagePreview=='div.gallery2'){
                        $($.parseHTML('<img class="return_img_modal_view col-md-2">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }
                    
                    if(placeToInsertImagePreview == 'div.gallery4'){
                         $($.parseHTML('<audio controls><source src="'+event.target.result+'"  type="audio/ogg"><source src="'+event.target.result+'" type="audio/mpeg"></audio>')).appendTo(placeToInsertImagePreview);
                    }
                    
                    
                }
                reader.readAsDataURL(input.files[i]);
            }
        
            if(placeToInsertImagePreview=='div.gallery') {   $('#vmb').removeClass('erss'); }
            if(placeToInsertImagePreview=='div.gallery1'){   $('#vmb').removeClass('erss'); }
            if(placeToInsertImagePreview=='div.gallery2'){   $('#vmbR').removeClass('erss'); }
        }
    }
    
    
    $('#pre_outcome').change(function(){
        var v = $(this).val();
        $('#hpre_outcome').val(v);
    });
    
    $('#ac_outcome').change(function(){
        var v = $(this).val();
        $('#hac_outcome').val(v);
    });
    
    
     $('#reffTo_o').change(function(){
        var v = $(this).val();
        $('#reffTo').val(v);
    });
    
     $('#reff_for_o').change(function(){
        var v = $(this).val();
        $('#reff_for').val(v);
    });
    
    
    $('.confirmation').on('click', function(){
        var linkURL = $(this).attr('data-hr');
        //alert(linkURL);
        
        swal("Are you sure you want to refuse this ticket?", {
               icon:'warning',
            title: 'Confirm',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "Refuse",
                    value: "yes",
                },
            },
        })
       .then((value) => {
            switch (value) {
                case "yes":
                    window.location.href = linkURL;      
                    break;
                default:
                    break;
            }
        });
    });
    
    $('.order_rep').on('click', function(){
        var linkURL = $(this).attr('data-hr');
        //alert(linkURL);
        
        swal("Are you sure you want to refuse this ticket?", {
            icon:'warning',
            title: 'Confirm',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "Refuse",
                    value: "yes",
                },
            },
        })
            .then((value) => {
            switch (value) {
                case "yes":
                    window.location.href = linkURL;      
                    break;
                    
                default:
                    break;
            }
        });
    });
    
    
    $('#gen_cr_btn').on('click', function(){
        var linkURL = $(this).attr('data-hr');
        //alert(linkURL);
        
        swal("Are you sure you want to CREATE CREDIT NOTE for this ticket?", {
               icon:'warning',
               title: 'Confirm',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
       .then((value) => {
            switch (value) {
                case "yes":
                    window.location.href = linkURL;      
                    break;
            }
        });
    });
    
    $('#gen_vo_btn').on('click', function(){
        var linkURL = $(this).attr('data-hr');
        //alert(linkURL);
        
        swal("Are you sure you want to GENERATE VOUCHER CODE for this ticket?", {
               icon:'warning',
               title: 'Confirm',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
       .then((value) => {
            switch (value) {
                case "yes":
                    //window.location.href = linkURL;      
                    break;
            }
        });
    });
    
</script>

<script>
    $(function() {
      $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2000,
         format: 'dd/mm/yyyy'
      });
    });
    
    
    $(document).on('click', '#gen_order_btn', function(e) {
    e.preventDefault();
        
        swal("Are you sure you want to GENERATE REPLACEMENT ORDER for this ticket?", {
            icon:'warning',
            title: 'Confirm',
            buttons: {
                cancel: "CANCEL",
                yes: {
                    text: "Continue",
                    value: "yes",
                },
            },
        })
            .then((value) => {
            switch (value) {
                case "yes":
                    $('#gen_order').submit();     
                    break;
            }
        });
    });
    
//$('select').selectpicker();
    
     
    $('#area_rep_pic').change(function(){
        //alert('sd');
    
        var area_txt = $(this).val();
         //alert(area_txt);
        if(area_txt== null || area_txt==""){
            //alert('if');
            $('.bootstrap-select .dropdown-toggle .filter-option').text('Select Process Area Concerned');
        }else{
            $('.bootstrap-select .dropdown-toggle .filter-option').text(area_txt);
            //alert('else');
            
        }
        //alert(area_txt);
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
						var removeButton = Dropzone.createElement('<div class="delete_icon btn btn-success" style="margin-left: 1.3rem;"><span>Remove</span>	</div>');
  
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
		
		
		$("#phototab-dropzone4").dropzone({
	  
			url: mainUrl + "tickets/addTickets/upload_printing_files",			
			acceptedFiles: 'image/*',
			init: function() {
	
				this.on('sending', function(file, xhr, formData){
					var token = $('#token').val();
					formData.append('token', token);
					formData.append('type','ticketReturn');
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
  

    
    
   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>