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
    .account-title{
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    margin-top: 0;
    line-height: normal;
    margin-left: 13px;
    }

</style>
<script>(function(n,t,i,r){var u,f;n[i]=n[i]||{},n[i].initial={accountCode:"AALAB11111",host:"AALAB11111.pcapredict.com"},n[i].on=n[i].on||function(){(n[i].onq=n[i].onq||[]).push(arguments)},u=t.createElement("script"),u.async=!0,u.src=r,f=t.getElementsByTagName("script")[0],f.parentNode.insertBefore(u,f)})(window,document,"pca","//AALAB11111.pcapredict.com/js/sensor.js")</script>

<div class="modal-dialog account-modal-dialog" role="document">
    <div class="modal-content account-modal-content">
        <div class="modal-body account-body" style="padding-top: 5px;">
            <div class="row">
                <div class="col-md-12 text-center"><h3 style="font-size: 20px;    font-weight: bold;    color: #006ca5!important;">ADD NEW CUSTOMER</h3></div>
				
				<button style="right: 8px; top: 8px;" type="button" id="" class="close cl_btn" data-dismiss="modal" aria-label="Close"><i class="fa
				fa-times-circle"></i></button>

            </div>

           <form id="validationID" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <h3 class="account-title">Billing Information</h3>
            </div>
                <div class="row">
                    <div class="col-md-4 account-details">
                        <label>
                            <div>
                                <span class="account-form-title">Email Address:</span>

                                <input type="email" name="UserEmail" id="UserEmail"  required class="form-control form-control-sm account-input" value="" placeholder="" aria-controls="responsive-datatable">
                            </div>
                        </label>

                        <label>

                            <span class="account-form-title">Secondary Email:</span>

                            <input type="email" name="SecondaryEmail" id= "SecondaryEmail" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                        <label>

                            <div style="display: inline-flex;">

                                <span class="account-form-title">Title:</span>
                                <div class=" labels-form" style="width: 200px;">
                                 <label class="select "> 
                                  <select name="BillingTitle" id="BillingTitle" > 
                                     <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                             <option value="Dr." >Dr.</option>
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

                            <input type="text" id="FirstName" required name="FirstName" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                        <label>

                            <span class="account-form-title">Last Name: </span>

                            <input type="text" id="Lastname" required name="Lastname" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                     
                    </div>

                <?php
						$restofworld_list = $this->shopping_model->grouped_country_list('ROW');
						$europeunion_list = $this->shopping_model->grouped_country_list('EUROPEAN UNION');
						$europe_list = $this->shopping_model->grouped_country_list('EUROPE');
						?>



                    <div class="col-md-4 account-details">
                        <label>
							<span class="account-form-title">Country :   </span>
							<select name="bill_country" id="bill_country" class="required form-control form-control-sm account-input" aria-controls="responsive-datatable">
								<option value="">Select Country</option>
								<optgroup label="UK">
									<option data-value="GB" value="United Kingdom">United Kingdom </option>
								</optgroup>
								<optgroup label="EUROPEAN UNION">
									
									<? foreach ($europeunion_list as $row) { ?>
									<option data-value="<?= $row->c_code ?>" data-vat="EUROPEAN UNION" value="<?= $row->name ?>"><?= $row->name ?></option>
									<? } ?>
								</optgroup>
											
								<optgroup label="EUROPE">
									<? foreach ($europe_list as $row) { ?>
									<option data-vat="EUROPE" value="<?= $row->name ?>"> <?= $row->name ?> </option>
									<? } ?>
								</optgroup>
											
								<optgroup label="ROW">
									<? foreach ($restofworld_list as $row) { ?>
									<option data-value="<?= $row->c_code ?>" data-vat="ROW" value="<?= $row->name ?>">
										<?= $row->name ?>
									</option>
									<? } ?>
								</optgroup>
											
							</select>
										
							<i></i> 
						</label>
						
                        <label>
                            <span class="account-form-title">Postcode: </span>

                            <input type="text" id="pcode"  name="pcode" required class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                        <label>
                            <span class="account-form-title">Address 1: </span>

                            <input type="text"  id="Address1" name="Address1" required class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                        <label>
                            <span class="account-form-title">Address 2: </span>

                            <input type="text" id="Address2" name="Address2" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                        <label>

                            <span class="account-form-title">Town/City: </span>

                            <input type="text" id="TownCity" name="TownCity" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                       </div>

                     <div class="col-md-4">
                         <label>
                            <span class="account-form-title">Country/State: </span>

                            <input type="text" id="CountryState" name="CountryState"  required class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                        
                        <label>

                            <span class="account-form-title">Telephone : </span>

                            <input type="text" id="Telephone" name="Telephone" required class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>

                           <label>
                              <span class="account-form-title">Mobile: </span>
                              <input type="text" id="bmobile" name="bmobile" class="form-control form-control-sm account-input"
                                     placeholder="" aria-controls="responsive-datatable">
                            </label>


                        <label>

                            <span class="account-form-title">Company Name: </span>

                            <input type="text" id="Company" name="Company" class="form-control form-control-sm account-input"

                            placeholder="" aria-controls="responsive-datatable">

                        </label>
                        <label>

                      <div style="display: inline-flex;">

                                <span class="account-form-title">Residential / Commercial:</span>

                                <div class=" labels-form" style="width: 200px;">
                                 <label class="select "> 
                                  <select name="billingResCom_User"  id="billingResCom_User"> 
                                   <option value="-1">Select</option>
                                    <option value="1">Residential</option>
                                    <option value="2">Commercial</option>
                                  </select> <i></i> 
                                </label> 
                              </div>

                            </div>

                        </label>
                               
                    </div>

                </div>

                <div class="row" style="border-top: dashed 1px #ccc;margin-top: 17px;margin-right: 5px;margin-left: 0px;">
                 <h3 class="account-title" style="margin-left: 0px;padding-top: 10px;">Delivery Information</h3>
                </div>

                    <div class="row">
                        <div class="col-md-4 account-details">
                               <label>
                                     <span class="account-form-title" style="    width: 200px;">Same as billing address ? </span>
                                        <div class="checkbox checkbox-info status-check-box spedic">
                                          <input  class="approval chBox" id="DAddressDifferent1" name="DAddressDifferent1" type="checkbox" value="0" onclick="usesame();">
                                          <label for="checkbox4"></label></div>
                                </label>


                                <label>
                                    <div style="display: inline-flex;">
                                      <span class="account-form-title">Title:</span>
                                        <div class=" labels-form" style="width:200px;"> 
                                         <label class="select "> 
                                          <select name="DTitle" id="DTitle" > 
                                            <option  value="Mr.">Mr.</option>
                                            <option  value="Mrs.">Mrs.</option>
                                            <option  value="Ms." >Ms.</option>
                                            <option  value="Dr.">Dr.</option>
                                          </select> <i></i> 
                                         </label>
                                       </div>
                                    </div>

                                </label> 
                                <label>
                                    <span class="account-form-title">First Name: </span>

                                    <input type="text" id="DFirstName" name="DFirstName" required class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Last Name: </span>

                                    <input type="text" id="DLastname" name="DLastname" required class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>
                                    <span class="account-form-title">Telephone :  </span>

                                    <input type="text" id="DTelephone" required name="DTelephone" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>
                                    <label>
                                      <span class="account-form-title">Mobile:  </span>
                                      <input type="text" id="dmobile" name="dmobile" class="form-control form-control-sm account-input"
                                             placeholder="" aria-controls="responsive-datatable">
                                    </label>
                       </div>

                       <div class="col-md-4 account-details">
                              <label>
    							<span class="account-form-title">Country :   </span>
    							<select name="del_country" id="del_country" class="required form-control form-control-sm account-input" aria-controls="responsive-datatable">
    								<option value="">Select Country</option>
    								<optgroup label="UK">
    									<option data-value="GB" value="United Kingdom">United Kingdom </option>
    								</optgroup>
    								<optgroup label="EUROPEAN UNION">
    									
    									<? foreach ($europeunion_list as $row) { ?>
    									<option data-value="<?= $row->c_code ?>"
                                                            data-vat="EUROPEAN UNION" value="<?= $row->name ?>"><?= $row->name ?></option>
    									<? } ?>
    								</optgroup>
    											
    								<optgroup label="EUROPE">
    									<? foreach ($europe_list as $row) { ?>
    									<option data-vat="EUROPE" value="<?= $row->name ?>"> <?= $row->name ?> </option>
    									<? } ?>
    								</optgroup>
    											
    								<optgroup label="ROW">
    									<? foreach ($restofworld_list as $row) { ?>
    									<option data-value="<?= $row->c_code ?>" data-vat="ROW" value="<?= $row->name ?>">
    										<?= $row->name ?>
    									</option>
    									<? } ?>
    								</optgroup>
    											
    							</select>
    										
    							<i></i> 
					   	</label>
                                <label>
                                    <span class="account-form-title">Postcode :   </span>
                                    <input type="text" id="Dpcode"  name="Dpcode" class="form-control form-control-sm account-input"
                                    placeholder="" aria-controls="responsive-datatable">

                                </label>
                                <label>
                                    <span class="account-form-title">Address 1: </span>
                                    <input type="text" id="DAddress1" required name="DAddress1" class="form-control form-control-sm account-input"
                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>
                                    <span class="account-form-title">Address 2:</span>
                                    <input type="text" id="DAddress2" name="DAddress2" class="form-control form-control-sm account-input"
                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>
                                    <span class="account-form-title">Town/City :   </span>
                                    <input type="text" id="DTownCity" name="DTownCity" class="form-control form-control-sm account-input"
                                    placeholder="" aria-controls="responsive-datatable">
                                </label>
                        </div>

                        <div class="col-md-4">
                                <label>
                                    <span class="account-form-title">Country/State :   </span>
                                    <input type="text"  id="DCountryState" name="DCountryState" class="form-control form-control-sm account-input" placeholder="" aria-controls="responsive-datatable">
                                </label>

                                <label>
                                    <span class="account-form-title">Company Name :    </span>
                                    <input type="text"  id="DCompany" name="DCompany" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>
                                  <div style="display: inline-flex;">
                                   <span class="account-form-title">Residential / Commercial:</span>
                                    <div class=" labels-form" style="width: 200px;"> <label class="select "> 
                                      <select   id="DbillingResCom_User" name="DbillingResCom_User" > 
                                        <option value="-1">Select</option>
                                        <option value="1">Residential</option>
                                        <option value="2">Commercial</option>
                                       </select> <i></i>
                                     
                                    </div>
                                   </div>
                                </label>

                                <label>
                                 <span class="account-form-title" style="    width: 200px;">Signup for Newsletter?: </span>
                                  <div class="checkbox checkbox-info status-check-box spedic"><input type="checkbox" class="approval chBox"  data-id="1-38001"><label for="checkbox4"></label>
                                  </div>
                               </label>    
                        </div>

                   </div>

                    <div class="modal-footer ac-footer">
                        <div style="margin: 0px auto;">
                            <span class=" m-r-10">
                                <button type="button"class="btn btn-outline-dark waves-light waves-effect btn-countinue cl_btn"  data-dismiss="modal" style="
                                width: 150px;">CLOSE
                                </button>
                            </span>
                            <span>
                                <button id="btnSubmits" type="button" onclick="addcus();" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1"  style="width: 150px;">SAVE
                                </button>
                            </span>
                        </div>
                    </div>
           </form>
        </div>
    </div>
</div>
<script type="text/javascript">


    $('.cl_btn').click(function(){
        window.location.reload();
    });
    
    function addcus() {


        fill_all_del();


        var btitle = $('#BillingTitle').val();
        var bemail= $('#UserEmail').val();
        var semail = $('#SecondaryEmail').val();
       
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
        var bresid = $("#billingResCom_User").val();
        
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
        var dresid = $("#DbillingResCom_User").val();
        
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

       
        if (bemail == '' || bemail == null) {
            show_popover('#UserEmail','Please Enter Email');
            return false;
        }
        if (fname == '' || fname == null) {
            show_popover('#FirstName' ,'Please Enter First Name');
            return false;
        }
        if (contry == '' || contry == null) {
            show_popover('#bill_country','Please Enter Country');
            return false;
        }
        
         if (pcode == '' || pcode == null) {
            show_popover('#pcode','Please Enter Pcode');
            return false;
        }
        if (city == '' || city == null) {
            show_popover('#TownCity','Please Enter City');
            return false;
        }
        if (state == '' || state == null) {
            show_popover('#CountryState','Please Enter State');
            return false;
        }
        
        if (telp == '' || telp == null) {
            show_popover('#Telephone','Please Enter Telephone');
            return false;
        }






        $.ajax({
            type: "post",
            url: mainUrl + "order_quotation/Order/add_contact",
            cache: false,               
            data:{
                BillingTitle:btitle,
                UserEmail:bemail,
                SecondaryEmail:semail,
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
                BillingResCom :bresid,
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
                DeliveryResCom:dresid,
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
                $('#exampleModal1').modal('hide');

            //swal('Success','Customer Added Successfully ','success');

                swal(
                    "Customer Added Successfully",
                    {
                        buttons: {
                            catch: {
                                text: "Ok",
                                value: "catch",
                            },
                        },
                        icon: "success",
                        closeOnClickOutside: false,
                    }
                ).then((value) => {

                        switch (value) {


                            case "catch":

                                window.location.reload();

                                break;


                        }

                });






            },  
            error: function(){
                window.location.reload();
                $('#exampleModal1').modal('hide');
                swal('error','Error while request..','error');                    
            }
            }); 
                   
        }



    function fill_all_del()
    {
        var items = $('.checkbox-checked').length;
        //alert(items);
        if($('#DAddressDifferent1').prop("checked") == true){

    //alert('hello');
            var valu = document.getElementById('bill_country').value;
            document.getElementById('DFirstName').value = document.getElementById('FirstName').value;
            document.getElementById('DLastname').value = document.getElementById('Lastname').value;
            document.getElementById('DAddress1').value = document.getElementById('Address1').value;
            document.getElementById('DAddress2').value = document.getElementById('Address2').value;
            document.getElementById('DTownCity').value = document.getElementById('TownCity').value;
            document.getElementById('DCountryState').value = document.getElementById('CountryState').value;
            document.getElementById('del_country').value = document.getElementById('bill_country').value;
            document.getElementById('Dpcode').value = document.getElementById('pcode').value;
            document.getElementById('DTelephone').value = document.getElementById('Telephone').value;
            //document.getElementById('DFax').value = document.getElementById('Fax').value;
            document.getElementById('DCompany').value = document.getElementById('Company').value;
            document.getElementById('DbillingResCom_User').value=document.getElementById('billingResCom_User').value;
            document.getElementById('dmobile').value = document.getElementById('bmobile').value;
            //$("#del_country_chzn").find('span').text(valu);

        }
       
  }
            
</script> 