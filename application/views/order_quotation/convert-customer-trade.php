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


<!-- Customer Convert Modal Start -->
    <div class="modal-dialog modal-md">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12 text-center"><h3 style="font-size: 20px;font-weight: bold;color: #006ca5 !important;line-height: normal;margin: 0px;">Convert Cutomer to Wholesale</h3></div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
                     <form id= "edit_submit" action=""  method="post">
                               <label>
                                    <span class="account-form-title">VAT Number  :    </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="vat_number"  id ="vat_number" value= "<?php echo $customer[0]['VATNumber'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>


                                <label>

                                    <span class="account-form-title">Website  :   </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="website"  id ="website" value= "<?php echo $customer[0]['Website'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Expected Monthly Spend  :    </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="monthly_spend" id="monthly_spend" value= "<?php echo $customer[0]['MonthlySpend'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Company Reg No  :  </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="reg_no" id="reg_no" value="<?php echo $customer[0]['CompanyRegistrationNo'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Trading Name  :     </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="trade_name" id ="trade_name" value= "<?php echo $customer[0]['TradingName'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                    <span class="account-form-title">Print Discount  :     </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="price_discount" id ="price_discount" value="<?php echo $customer[0]['printed_discount'];?>" class="form-control form-control-sm account-input" placeholder="" aria-controls="responsive-datatable">

                                </label>

                                <label>

                                <div style="display: inline-flex;">

                                    <span class="account-form-title">Company Type  :  
                                    </span>

                                    <div class=" labels-form" style="width: 200px"> 
                                        <label class="select "> 
                                            <select name="company_type" id="company_type" style="margin-left: 10px;width: 235px;height: 30px;"> 
                                                <option value="Select Company Type" <? if(!empty($customer[0]['CompanyType']) && $customer[0]['CompanyType']=='Select Company Type'){ echo "Selected";}?>>Select Company Type
                                                </option> 
                                                <option value="Sole Trader" <? if(!empty($customer[0]['CompanyType']) && $customer[0]['CompanyType']=='Sole Trader'){ echo "Selected";}?>>Sole Trader
                                                </option> 
                                                <option value="Partnership" <? if(!empty($customer[0]['CompanyType']) && $customer[0]['CompanyType']=='Partnership'){ echo "Selected";}?>>Partnership
                                                </option> 
                                                <option value="Limited Company" <? if(!empty($customer[0]['CompanyType']) && $customer[0]['CompanyType']=='Limited Company'){ echo "Selected";}?>>Limited Company
                                                </option> 

                                                <option value="Public Limited Company" <? if(!empty($customer[0]['CompanyType']) && $customer[0]['CompanyType']=='Public Limited Company'){ echo "Selected";}?>>Public Limited Company
                                                </option> 
                                                <option value="Other" <? if(!empty($customer[0]['CompanyType']) && $customer[0]['CompanyType']=='Other'){ echo "Selected";}?>>Public Other
                                                </option> 
                                            </select>
                                          </label>
                                    </div>

                                </div>

                                </label>

                                <label>

                                    <span class="account-form-title">Busniess Description  :  
                                   </span>

                                    <input style="margin-left: 10px;width: 235px;" type="text" name="desc" id = "desc" value= "<?php echo $customer[0]['DescriptionBusiness'];?>" class="form-control form-control-sm account-input"

                                    placeholder="" aria-controls="responsive-datatable">

                                </label>


                                <div class="modal-footer ac-footer">

                                   <div style="margin: 0px auto;">

                                    <span class=" m-r-10"><button type="button"

                                    class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal" style="    width: 150px;">CLOSE</button></span>

                                    <span> <button id="updates" type="button" data-id="<?=$customer[0]['UserID']?>" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="width: 150px;">UPDATE</button></span>

                                  </div>

                                </div>

                            </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Customer Convert Modal End -->


<script type="text/javascript">
    $('#updates').click(function() { // the button - could be a class selector instead
        
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
                  upds(id);
                    break;

            }
        });    
    });   

    function upds(id){
       
                    var vat = $("#vat_number").val();
                    var web = $("#website").val(); 
                    var m_salary = $('#monthly_spend').val();
                    var reg_no = $("#reg_no").val();
                    var t_name = $("#trade_name").val();
                    var disc = $("#price_discount").val(); 
                    var c_type = $('#company_type').val();
                    var desc = $("#desc").val();
                 $.ajax({
                        type: "post",
                        url: mainUrl + "order_quotation/Order/update_wholesale",
                        cache: false,               
                        data:{
                             UserID : id,
                             vat_number :vat,
                             website:web,
                             monthly_spend:m_salary,
                             reg_no:reg_no,
                             trade_name:t_name,
                             price_discount:disc,
                             company_type:c_type,
                             desc:desc
                        },
                        dataType: 'html',
                        success: function(data){
                            swal('Success','Customer wholesale Successfully ','success');
                            $('#exampleModal3').modal('hide');
                        },  
                        error: function(){
                            $('#exampleModal3').modal('hide');
                            swal('error','Error while request..','error');                    
                        }
                    }); 
    }
   
</script>