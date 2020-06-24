
<div class="modal-header checklist-header">
    <div class="col-md-12">
        <h4 class="modal-title checklist-title" id="myLargeModalLabel">Ticket# : <?=$data[0]['ticketSrNo']?></h4>
    </div>
</div>
<div class="modal-body p-t-0">
    <div class="panel-body">

        <p class="message-field-title">Follow Up Comments:</p>
        <div class="col-12 no-padding">
            <textarea class="form-control blue-text-field" rows="5" id="new-comment" readonly><?php echo $data[0]['re_notes']; ?></textarea>
        </div>
       
        <span class="m-t-t-10 pull-right">
            <button type="button" aria-label="Close" data-dismiss="modal" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">Close</button></span>
    </div>
</div>  
