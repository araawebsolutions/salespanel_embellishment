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
                <div class="col-md-12 text-center"><h3 style="font-size: 20px;font-weight: bold;color: #006ca5 !important;line-height: normal;margin: 0px;">Follow Up Calls</h3></div>


            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">
            <table class="table table-bordered taable-bordered f-14">
                <thead>
                <tr>
                    <th class="text-center" width="5%">Sr.</th>
                    <th class="text-center" width="5%">Operator</th>
                    <th class="text-center" width="20%">Comments</th>
                    <th class="text-center" width="20%">Time</th>
                </tr>
                </thead>
                <tbody>
               <?php foreach ($follow as $follows){
                     $operatorName = $this->home_model->get_operator($follows['operator']);
                   ?>
                   <tr>
                       <td class="text-center"><?=$follows['id']?></td>
                       <td class="text-center"><?= $operatorName?></td>
                       <td class="text-center"><textarea style="height:55px;" readonly><?=$follows['comment']?></textarea></td>
                       <td class="text-center"><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> h : i  A</b>', ($follows['date'])); ?></td> 
                   </tr>
               <?php }?>


                </tbody>
            </table>
                      <p class="message-field-title">Share your feedback:</p>
                                
                                <div style="width: 103%;">
                                     <textarea class="form-control blue-text-field" name="comment" id="comment" rows="4"></textarea>
                              </div>
                                <div class="modal-footer ac-footer">

                                   <div style="margin: 0px auto;">

                                    <span class=" m-r-10"><button type="button"

                                    class="btn btn-outline-dark waves-light waves-effect btn-countinue" data-dismiss="modal" style="    width: 150px;">CLOSE</button></span>

                                    <span>
                                        <? if($customer[0]['callback_ignore'] == 1){ ?>
                                       <button type="button"class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" onclick="block_callbacks(0);"  style="background: #F00;color: #fff !important;border: none;width: 150px;">No Follow Up Calls</button>
                           <?php }else{?>
                                          <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" onclick="block_callbacks(1);" style="background: #093;color: #fff !important;border: none; width: 150px;">Follow Up Calls</button>
                                            <? }?>
                                
                                </span>

                                  </div>

                                </div>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Customer Convert Modal End -->


<script type="text/javascript">

        function block_callbacks(action){
            var name = $("#name").val();
            var desc = $("#comment").val();
        $.ajax({
            url: mainUrl + "order_quotation/Order/block_callbacks",
            data:{
                action:action,
                UserID:'<?=$customer[0]['UserID']?>',
                name:name,
                comment:desc

            },
            datatype:'json',
            type:'POST',
            success:function(data){ 
                swal('Success','Follow Up Calls Changed ','success');
                $('#exampleModal4').modal('hide');
            },
            error: function(){
                $('#exampleModal4').modal('hide');
                swal('error','Error while request..','error');                    
            }
        });
    }
    
   
</script>