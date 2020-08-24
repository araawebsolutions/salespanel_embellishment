<div class="panel-body">


    <p class="message-field-title"><?= $title ?></p>
    <div class="col-12 no-padding">
        <input type="text" id="ord_no" placeholder="order number" class="form-control blue-text-field" style="margin-bottom: 10px;height: 35px;">
        <textarea class="form-control blue-text-field" id="order_place" rows="5"></textarea>
    </div>
    <span class="m-t-t-10 pull-right"><button type="button" onclick="changeStatus(<?= $status ?>,'<?= $refno ?>')"
                                              class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Confirm</button></span>
    <span class="m-t-t-10 pull-right"><button type="button" onclick="hidestatusModal()"
                                              class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button></span>


</div>