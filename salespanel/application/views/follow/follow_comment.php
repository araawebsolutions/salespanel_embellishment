<div class="modal-content blue-background">
    <div class="modal-header checklist-header">
        <div class="col-md-12">
            <h4 class="modal-title checklist-title" id="myLargeModalLabel">Comments for Reference Number# :
                <?=$order?></h4>
        </div>
    </div>
    <div class="modal-body p-t-0">
        <div class="panel-body">


            <table class="table table-bordered taable-bordered f-14">
                <thead>
                <tr>
                    <th class="text-center">Sr.</th>
                    <th class="text-center">Operator</th>
                    <th class="text-center">Comments</th>
                    <th class="text-center">Time</th>
                    <th class="text-center">Action</th>

                </tr>
                </thead>
                <tbody>
               <?php foreach ($comments as $key=>$comment){
                    $operatorName = $this->home_model->get_operator($comment->Operator);
                   ?>
                   <tr id="comment<?=$key?>">
                       <td class="text-center"><?=$comment->ID?></td>
                       <td class="text-center"><?=$operatorName?></td>
                       <td class="text-center"><textarea style="height:55px;" readonly><?=$comment->comment?></textarea></td>
                       <td class="text-center"><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> h : i  A</b>', ($comment->Time)); ?></td>
                       <td class="text-center red-text">
                           <?php if($comment->comment_type == 'manual'){ ?>
                           
                           <a href="#" onclick="deleteComment(<?=$key?>,<?=$comment->ID?>,'<?=$comment->OrderNumber?>')" class="deleter" style="color:#F00;cursor:pointer;">Delete</a>
                           <?php } else { ?>
                           <?php echo '---';  } ?>
                           </td>
                   </tr>
               <?php }?>


                </tbody>
            </table>
            <p class="message-field-title">Share your feedback, requirement or any other issue:</p>
            <div style="width: 103%;">
                <textarea class="form-control blue-text-field" id="new_comment" rows="5"></textarea>
                <input type="hidden" id="comment_orderno" value="<?=$order?>">
            </div>
            <span class="m-t-t-10 pull-right"><button type="button" onclick="saveComment()" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Submit</button></span>
            <span class="m-t-t-10 pull-right"><button onclick="hideCommentModal()" type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button></span>


        </div>
    </div>
</div>