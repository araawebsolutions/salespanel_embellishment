<style type="text/css">

    .frmAlert{

        clear: both;

        background-color: red;

        padding: 5px;

        color: #fff !important;

        margin-top: 32px;

        border-radius: 5px;

    }

    .frmSuccessAlert{

        clear: both;

        background-color: green;

        padding: 5px;

        color: #fff !important;

        margin-top: 32px;

        border-radius: 5px;



    }

    .mt-6{

        margin-top:1.5rem; 

    }

    .mb-6{

        margin-bottom:1.5rem; 

    }
    .status-check-box {
        margin-top: 0px !important;
    }
    .spedic{
        padding: 0px !important;
    }
    .account-input{
            height: 30px !important;
    }

</style>

<div class="modal-dialog account-modal-dialog" role="document">

    <div class="modal-content account-modal-content">

        <div class="modal-body account-body" style="padding-top: 5px;">

            <div class="row">


                <div class="col-md-12 text-center"><h3 style="font-size: 20px;    font-weight: bold;    color: #006ca5!important;">UPDATE CUSTOMER</h3></div>
                <button style="right: 8px; top: 8px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle"></i></button>

            </div>

            <form id= "edit_submit" action=""  method="post">

<div class="row"><h3 class="account-title" style="font-size: 13px;
font-weight: 700;
text-transform: uppercase;
margin-top: 0;
line-height: normal;
margin-left: 13px;">Billing Information</h3></div>



                <div class="row">



                    <div class="col-md-4 account-details">

  <label>

                            <div>
                                 <input type="hidden" name="UserID" id= "UserID" class="form-control form-control-sm account-input" value="<?php echo $customer[0]['UserID'];?>" placeholder="" aria-controls="responsive-datatable">
                                <span class="account-form-title">Email Address:</span>

                                <input type="text" name="UserEmail"  id= "UserEmail" class="form-control form-control-sm account-input" value="<?php echo $customer[0]['UserEmail'];?>" placeholder="" aria-controls="responsive-datatable">

                            </div>

                            <div id="AccountNumber">
                            </div>

                        </label>

                        <label>

                            <span class="account-form-title">Secondary Email:</span>

                            <input type="text" name="SecondaryEmail" id= "SecondaryEmail" class="form-control form-control-sm account-input"

                            placeholder="" value="<?php echo $customer[0]['SecondaryEmail'];?>" aria-controls="responsive-datatable">

                        </label>

                        <label>

                            <div style="display: inline-flex;">

                                <span class="account-form-title">Title:</span>
                                <div class=" labels-form" style="width: 200px;">
                                 <label class="select "> 
                                  <select name="BillingTitle" id="BillingTitle" > 
                                     <option value="Mr." <?php if(!empty($customer[0]['BillingTitle']) && $customer[0]['BillingTitle']=='Mr.'){echo "Selected";}?>>Mr.</option>
                                <option value="Mrs." <?php if(!empty($customer[0]['BillingTitle']) && $customer[0]['BillingTitle']== 'Mrs.'){echo "Selected";}?>>Mrs.</option>
                                <option value="Ms."  <?php if(!empty($customer[0]['BillingTitle']) && $customer[0]['BillingTitle']== 'Ms.'){echo "Selected";}?>>Ms.</option>
                             <option value="Dr."  <?php if(!empty($customer[0]['BillingTitle']) && $customer[0]['BillingTitle']== 'Dr.'){echo "Selected";}?>>Dr.</option>
                                  </select> 
                                  <i></i> 
                                </label> 
                              </div>
                            </div>

                            <div id="Balance">



                            </div>

                        </label>

                        <label>

                            <span class="account-form-title">First Name: </span>

                            <input type="text" name="FirstName"  id="FirstName" class="form-control form-control-sm account-input" placeholder=""  value= "<?php echo $customer[0]['BillingFirstName'];?>" aria-controls="responsive-datatable">

                        </label>





                        <label>

                            <span class="account-form-title">Last Name: </span>

                            <input type="text" id="Lastname"  name="Lastname"  value= "<?php echo $customer[0]['BillingLastName'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>



                    </div>

                    <div class="col-md-4 account-details">
                       <label>

                            <span class="account-form-title">Address 1: </span>

                            <input type="text" name="Address1"  id="Address1" value= "<?php echo $customer[0]['BillingAddress1'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                        <label>

                            <span class="account-form-title">Address 2: </span>

                            <input type="text" name="Address2" id="Address2" value= "<?php echo $customer[0]['BillingAddress2'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                        <label>

                            <span class="account-form-title">Town/City: </span>

                            <input type="text" id="TownCity" name="TownCity" value= "<?php echo $customer[0]['BillingTownCity'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                        <label>

                            <span class="account-form-title">County/State: </span>

                            <input type="text" id="CountryState" name="CountryState" value="<?php echo $customer[0]['BillingCountyState'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
 <?
	$restofworld_list = $this->shopping_model->grouped_country_list('ROW');
	$europeunion_list = $this->shopping_model->grouped_country_list('EUROPEAN UNION');
	$europe_list = $this->shopping_model->grouped_country_list('EUROPE');
						
	$country = $customer[0]['BillingCountry'];
?>                       
                        
       <label>
		<span class="account-form-title">Country: </span>
			<select name="bill_country" id="bill_country" class="required form-control form-control-sm account-input" aria-controls="responsive-datatable">
				<option value="">Select Country</option>
								
					<optgroup label="UK">
						<option data-value="GB" <?= ($country == 'United Kingdom') ? 'selected="selected"' : '' ?>
                                                	value="United Kingdom">United Kingdom </option>
					</optgroup>
					<optgroup label="EUROPEAN UNION">
									
						<? foreach ($europeunion_list as $row) { ?>
							<option data-value="<?= $row->c_code ?>"
                                                        	data-vat="EUROPEAN UNION" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                        	value="<?= $row->name ?>"> <?= $row->name ?>
							</option>
						<? } ?>
					</optgroup>
								
					<optgroup label="EUROPE">
						<? foreach ($europe_list as $row) {?>
							<option <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                        	data-vat="EUROPE" value="<?= $row->name ?>"> <?= $row->name ?>
							</option>
						<? } ?>
					</optgroup>
								
					<optgroup label="ROW">
						<? foreach ($restofworld_list as $row) { ?>
							<option data-value="<?= $row->c_code ?>"
                                                        	data-vat="ROW" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>
                                                        	value="<?= $row->name ?>"> <?= $row->name ?>
							</option>
						<? } ?>
					</optgroup>
				</select>
			<i></i> 
		</label>

                   
                        </div>

                 
                <div class="col-md-4">


                     <label>

                            <span class="account-form-title">Postcode: </span>

                            <input type="text" name="pcode" id="pcode"  value= "<?php echo $customer[0]['BillingPostcode'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                        <label>

                            <span class="account-form-title">Telephone : </span>

                            <input type="text" name="Telephone" id="Telephone" value= "<?php echo $customer[0]['BillingTelephone'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                       <label>
                         <span class="account-form-title">Mobile: </span>
                          <input type="text" name="bmobile" id="bmobile" value= "<?php echo $customer[0]['BillingMobile'];?>" class="form-control form-control-sm account-input" placeholder="" aria-controls="responsive-datatable">
                        </label>
                                      
                        <label>

                            <span class="account-form-title">Company Name: </span>

                            <input type="text" name="Company" id="Company"  value= "<?php echo $customer[0]['BillingCompanyName'];?>" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                  
                      </div>      
                        </div>


<div class="row" style="border-top: dashed 1px #ccc;margin-top: 17px;margin-right: 5px;margin-left: 0px;">
    <h3 class="account-title" style="margin-left: 0px;padding-top: 10px;">Delivery Information</h3>
</div>



                <div class="row">



                    <div class="col-md-4 account-details">
                         <div style="display: inline-flex;margin-bottom: .5rem;">

                                <span class="account-form-title">Title:</span>

                                <div class=" labels-form" style="width:200px;"> 
                                <label class="select "> 
                                  <select name="DTitle" id="DTitle" > 
                                    <option  value="Mr." <? if(!empty($customer[0]['DeliveryTitle']) && $customer[0]['DeliveryTitle']=='Mr.'){ echo "Selected";}?>>Mr.</option>
                                <option  value="Mrs." <? if(!empty($customer[0]['DeliveryTitle']) && $customer[0]['DeliveryTitle']=='Mrs.'){ echo "Selected";}?>>Mrs.</option>
                                <option  value="Ms." <? if(!empty($customer[0]['DeliveryTitle']) && $customer[0]['DeliveryTitle']=='Ms.'){ echo "Selected";}?>>Ms.</option>
                               <option  value="Dr." <? if(!empty($customer[0]['DeliveryTitle']) && $customer[0]['DeliveryTitle']=='Dr.'){ echo "Selected";}?>>Dr.</option>
                       </select> <i></i> 
                             </label> </div>

                            </div>

                                </label>

                                <label>

                                    <span class="account-form-title">First Name: </span>

                                    <input type="text" name="DFirstName" id="DFirstName" value= "<?php echo $customer[0]['DeliveryFirstName'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Last Name: </span>

                                    <input type="text" name="DLastname" id="DLastname"  value= "<?php echo $customer[0]['DeliveryLastName'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Address 1: </span>

                                    <input type="text" name="DAddress1" id="DAddress1" value= "<?php echo $customer[0]['DeliveryAddress1'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>


                                <label>

                                    <span class="account-form-title">Address 2:</span>

                                    <input type="text" name="DAddress2"  id="DAddress2" value= "<?php echo $customer[0]['DeliveryAddress2'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>
                    
                    </div>

                        <div class="col-md-4 account-details">
                    
                      <label>

                                    <span class="account-form-title">Town/City :   </span>

                                    <input type="text" name="DTownCity"  id="DTownCity" value= "<?php echo $customer[0]['DeliveryTownCity'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>
                                 <label>

                                    <span class="account-form-title">Country/State :   </span>

                                    <input type="text" name="DCountryState" id="DCountryState" value= "<?php echo $customer[0]['DeliveryCountyState'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>
<?
	$country = $customer[0]['DeliveryCountry'];
?>
                                
                                <label>
		<span class="account-form-title">Country: </span>
			<select name="del_country" id="del_country" class="required form-control form-control-sm account-input" aria-controls="responsive-datatable">
				<option value="">Select Country</option>
								
					<optgroup label="UK">
						<option data-value="GB" <?= ($country == 'United Kingdom') ? 'selected="selected"' : '' ?> value="United Kingdom">United Kingdom </option>
					</optgroup>
					<optgroup label="EUROPEAN UNION">
								
						<? foreach ($europeunion_list as $row) { ?>
							<option data-value="<?= $row->c_code ?>"  data-vat="EUROPEAN UNION" <?= ($country == $row->name) ? 'selected="selected"' : '' ?>  value="<?= $row->name ?>"> <?= $row->name ?>
							</option>
						<? } ?>
					</optgroup>
								
					<optgroup label="EUROPE">
						<? foreach ($europe_list as $row) {?>
							<option <?= ($country == $row->name) ? 'selected="selected"' : '' ?> data-vat="EUROPE" value="<?= $row->name ?>"> <?= $row->name ?>
							</option>
						<? } ?>
					</optgroup>
								
					<optgroup label="ROW">
						<? foreach ($restofworld_list as $row) { ?>
							<option data-value="<?= $row->c_code ?>" data-vat="ROW" <?= ($country == $row->name) ? 'selected="selected"' : '' ?> value="<?= $row->name ?>"> <?= $row->name ?>
							</option>									
						<? } ?>
					</optgroup>
				</select>
			<i></i> 
		</label>


                                <label>

                                    <span class="account-form-title">Postcode :   </span>

                                    <input type="text" name="Dpcode" id="Dpcode" class="form-control form-control-sm account-input"

                                    placeholder=""  value= "<?php echo $customer[0]['DeliveryPostcode'];?>" aria-controls="responsive-datatable">

                                </label>

                             <label>

                                    <span class="account-form-title">Telephone :  </span>

                                    <input type="text" name="DTelephone" id="DTelephone" value= "<?php echo $customer[0]['DeliveryTelephone'];?>"  class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>
                    </div>

                        <div class="col-md-4">

                          <label>
                              <span class="account-form-title">Mobile :  </span>
                              <input type="text" name="dmobile" id="dmobile" class="form-control form-control-sm account-input"
                                     placeholder=""  value= "<?php echo $customer[0]['DeliveryMobile'];?>" aria-controls="responsive-datatable">
                            </label>


                                <label>

                                    <span class="account-form-title">Company Name :    </span>

                                    <input type="text" name="DCompany" id="DCompany"  class="form-control form-control-sm account-input"

                                    placeholder="" value= "<?php echo $customer[0]['DeliveryCompanyName'];?>" aria-controls="responsive-datatable">

                                </label>


              <span class="m-r-20">
                        <button type="button" class="btn btn-outline-pink waves-effect waves-light" onclick="forgotpass('<?php echo $customer[0]['UserEmail'];?>');" style="background: #00b6f0;color: #fff !important;border: none;height: 30px;padding-top: 4px;margin-top: 3px;">Password Reset Email</button>
                 </span>

                 <? if($customer[0]['Active']!=1){ ?>
                     <span class="m-r-20">
                        <button type="button" class="btn btn-outline-pink waves-effect waves-light" onclick="send_activation_email('<?php echo $customer[0]['UserID'];?>');" style="background: #00b6f0;color: #fff !important;border: none;height: 30px;padding-top: 4px;margin-top: 3px;">Send Activation Email</button>
                 </span>
                <? } ?>
                    
                    </div>




                </div>

            <?php $user_id =  $customer[0]['UserID']; ?>
                        <div class="modal-footer ac-footer">

                            <div style="margin: 0px auto;">

                                <span class=" m-r-10"><button type="button"

                                  class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal" style="width: 150px;">CLOSE</button></span>
                                   
                                  <span>
                                      <button id="update" type="button" data-id="<?=$customer[0]['UserID']?>" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="width: 150px;">UPDATE</button>
                                </span>

                                  </div>

                              </div>

                          </form>

                      </div>

                  </div>

              </div>
<script type="text/javascript">
    $('#update').click(function() { // the button - could be a class selector instead
        
        swal("Are you sure you want to Update information?", {
            icon:'warning',
            title: 'Confirm',
            dangerMode: true,
            buttons: {
                cancel: "No",
                yes: {
                    text: "Yes",
                    value: "yes",
                },
            },
        })
            .then((value) => {
            switch (value) {
                case "yes":
                 var id = $(this).attr('data-id');
                  upd(id);
                    break;

            }
        });    
    });   

    function upd(id){
       
                    var bemail= $('#UserEmail').val();
                    var semail = $('#SecondaryEmail').val();
                    var btitle = $('#BillingTitle').val();
                    var fname = $("#FirstName").val();
                    var lname = $("#Lastname").val();
                    var add1 = $("#Address1").val();
                    var add2 = $("#Address2").val();
                    var city = $('#TownCity').val();
                    var state = $("#CountryState").val();
                    var contry = $("#bill_country").val();
                    var pcode = $("#pcode").val();
                    var telp = $("#Telephone").val();
                    var comp = $("#Company").val();

                    var dtitle = $("#DTitle").val();
                    var dfname = $("#DFirstName").val(); 
                    var dlname = $('#DLastname').val();
                    var dadd1 = $("#DAddress1").val();
                    var dadd2 = $("#DAddress2").val();
                    var dcity = $("#DTownCity").val(); 
                    var dstate = $('#DCountryState').val();
                    var dcontry = $("#del_country").val();
                    var dpcode = $("#Dpcode").val();
                    var dphn = $("#DTelephone").val(); 
                    var dcomp = $("#DCompany").val();

                    var vat = $("#vat_number").val();
                    var web = $("#website").val(); 
                    var m_salary = $('#monthly_spend').val();
                    var reg_no = $("#reg_no").val();
                    var t_name = $("#trade_name").val();
                    var disc = $("#price_discount").val(); 
                    var c_type = $('#company_type').val();
                    var desc = $("#desc").val();
                    
                                                    
                    var bmobile = $('#bmobile').val(); 
                    var dmobile = $('#dmobile').val();


                 $.ajax({
                        type: "post",
                        url: mainUrl + "order_quotation/Order/update_customer",
                        cache: false,               
                      data:{
                             UserID : id,
                             UserEmail:bemail,
                             SecondaryEmail:semail,
                             BillingTitle:btitle,
                             FirstName:fname,
                             Lastname:lname,
                             Address1:add1,
                             Address2:add2,
                             TownCity:city,
                             CountryState:state,
                             bill_country:contry,
                             pcode:pcode,
                             Telephone:telp,
                             Company: comp,
                             DTitle:dtitle,
                             DFirstName:dfname,
                             DLastname:dlname,
                             DAddress1:dadd1,
                             DAddress2:dadd2,
                             DTownCity:dcity,
                             DCountryState:dstate,
                             del_country:dcontry,
                             Dpcode:dpcode,
                             DTelephone:dphn,
                             DCompany:dcomp ,
                             website:vat,
                             vat_number:web,
                             monthly_spend:m_salary,
                             reg_no:reg_no,
                             trade_name:t_name,
                             price_discount:vat,
                             company_type:c_type,
                             bmobile:bmobile,
                             dmobile:dmobile,
                             desc:desc
                        },
                        dataType: 'html',
                        success: function(data){
                            swal('Success','Customer Update Successfully ','success');
                            $('#exampleModal2').modal('hide');
                        },  
                        error: function(){
                            $('#exampleModal2').modal('hide');
                            swal('error','Error while request..','error');                    
                        }
                    }); 
    }


    function block_callbacks(action){
        $.ajax({
                url: mainUrl + "order_quotation/Order/block_callbacks",
                data:{
                      action:action,
                      UserID:'<?=$customer[0]['UserID']?>'
                },
                datatype:'json',
                type:'POST',
                success:function(data){ 
                    swal('Success','Follow Up Calls Changed ','success');
                            $('#exampleModal2').modal('hide');
                },
                error: function(){
                            $('#exampleModal2').modal('hide');
                            swal('error','Error while request..','error');                    
                }
        });
}   

function forgotpass(email){
    $.ajax({
           
               url: mainUrl + "order_quotation/Order/forgotpassword",
                data:{
                      email:email,
                },
                datatype:'json',
                success:function(data){
                    swal('Success',' Link has Send To Your Email  Plz Check Your Email  ','success');
                            $('#exampleModal2').modal('hide');
                },
                error: function(){
                            $('#exampleModal2').modal('hide');
                            swal('error','Error while request..','error');                    
                }
              
              });
    
}   

function send_activation_email(userid){
           $.ajax({
             url: mainUrl + "order_quotation/Order/send_activation_email",
             data:{userid:userid},
             datatype:'json',
             success:function(data){
             alert('Account Activation Email Sent');
            }
          });
      }

</script>