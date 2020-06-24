


<div class="wrapper">
  <div class="container-fluid">
  
  <div class="row">
      <div class="col-md-12">
        <div class="card-box tab-nav-padding">
          <ul class="nav nav-pills navtab-bg nav-justified pull-in tab-nav-container" id="main_nav">
            <li class="nav-item tab-li-adjst disbaledd">
             <a href="<?php echo main_url?>Reporting/sample_detail/<?php echo $user_id; ?>" class="nav-link"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Customer Info</a> 
            </li>
            <li class="nav-item tab-li-adjst">
             <a href="<?php echo main_url?>Reporting/sample_against_user/<?php echo $user_id; ?>" class="nav-link active show"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Sample Details</a> 
            </li>
            <li class="nav-item tab-li-adjst disbaledd">
             <a href="<?php echo main_url?>Reporting/order_against_user/<?php echo $user_id; ?>" class="nav-link"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Order Details</a> 
            </li>
           </ul>
          
          <div id="customer" class="tab-content m-t-14">
            <div class="tab-pane show active" id="home1">
            <?php echo $this->table->generate(); ?>
           </div>
          </div>
         
        </div>
      </div>
    </div>
 <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />   
<script>
$(document).ready(function() {
	getData();
});


 function getData(){

    $('#responsive-datatable').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>Reporting/ajax_samples_orders',

            "aoColumns": [
                null, null, null, null,
              ],
            "fnInitComplete": function () {

            },
            'fnServerData': function (sSource, aoData, fnCallback) {
				aoData.push( { "name": "user_id", "value": $('#user_id').val()});
                $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },
       });
 }
</script>		    