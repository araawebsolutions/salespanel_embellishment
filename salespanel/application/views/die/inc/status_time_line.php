<div class="modal-content blue-background">
    <div class="modal-header checklist-header">
        <div class="col-md-12">
            <h4 class="modal-title checklist-title" id="myLargeModalLabel">Die Code:# <?=@$data[0]->code?> Changed Status Logs </h4>
           
        </div>
    </div>
    <div class="modal-body p-t-0">
        <div class="panel-body" >

            <div style="<?php if(count($data) > 13){ echo 'height:500px;';}?> overflow:auto">  
                <table class="table table-bordered taable-bordered f-14" >
                    <thead>
                        <tr>
                            <!--<th class="text-center">Code</th>-->
                            <th class="text-center">Changed to</th>
                            <th class="text-center">Operator</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($data){ 
                            foreach($data as $row){
                                 
                                $operator = $this->die_model->get_operator($row->user_id);
                        ?>
                        <tr>
                            <!--<td class="text-center"><b><?=$row->code?></b></td>-->
                            <td class="text-center"><b><?if($row->converted=='Euro'){ echo 'Standard to Euro Die';} else { echo'Euro to Standard Die';}?></b></td>
                            <td class="text-center"><b><?=$operator;?></b></td>
                            <td class="text-center"><?php echo date('d/m/Y h:i:s a',strtotime($row->created_at)); ?></td>
                        </tr>
                        <?php } } else {?>
                        <tr>
                            <td colspan="4" class="text-center"><b>Records Not Found</b></td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
          
       
            <span class="m-t-t-10 pull-right"><button data-dismiss="modal" type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button></span>
            
        </div>
    </div>
    
      
</div>