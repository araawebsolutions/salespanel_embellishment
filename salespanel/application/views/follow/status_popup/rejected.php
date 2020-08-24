<div class="panel-body">



    <p class="message-field-title"><?=$title?></p>
    <div class="col-12 no-padding">
        <select id="option" style="margin-bottom: 10px; float:left;width: 100%;" class="form-control blue-text-field">
            <option value="">Select Status</option>
            <option value="7">Ordered With another Supplier</option>
            <option value="10">Price</option>
            <option value="11">Product no Available</option>
            <option value="12">Third Party order not received</option>
            <option value="13">No longer Required</option>
            <option value="14">Other</option>
        </select>






        <textarea class="form-control blue-text-field" style="width: 100%" id="note" rows="5"></textarea>
    </div>
    <span class="m-t-t-10 pull-right"><button type="button" onclick="changeStatus(<?=$status?>,'<?=$refno?>')" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Confirm</button></span>
    <span class="m-t-t-10 pull-right"><button type="button" onclick="hidestatusModal()" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button></span>


</div>