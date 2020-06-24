


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
            <li class="nav-item tab-li-adjst disbaledd">
             <a href="<?php echo main_url?>Reporting/sample_against_user/<?php echo $user_id; ?>" class="nav-link "> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Sample Details</a> 
            </li>
            <li class="nav-item tab-li-adjst ">
             <a href="<?php echo main_url?>Reporting/order_against_user/<?php echo $user_id; ?>" class="nav-link active show"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Order Details</a> 
            </li>
           </ul>
 <style>
 table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #efefef;
}

#count_shows {
   /* width: 600px;
    padding: 16px;
    border: 3px solid gray;
    margin: 0;
	align:right;
	margin-left:0%;
	margin-top:5px;*/
	margin-left:706px;
}	

#total_order_val {
    width: 260px;
    padding: 8px;
    border: 1px solid gray;
    margin: 0;
	margin-left:0%;
	margin-top:5px;
	display: inline-block;
	margin-right : -4px;
	margin-bottom: 10px;
}	

#total_order {
    width: 175px;
    padding: 8px;
    border: 1px solid gray;
    margin: 0;
	margin-left:0%;
	margin-top:5px;
	display: inline-block;
	margin-right : -4px;

}	

#total_sample_order {
	
	width: 194px;
    padding: 8px;
    border: 1px solid gray;
    margin: 0;
	margin-left:0%;
	margin-top:5px;
	display: inline-block;
	margin-right : -4px;
	
}

.v1{
	
	border-left: 1px solid black;
    height: 10px;
    position: relative;
    left: 2%;
    margin-left: 7px;
	margin-right: 18px;
    top: 0;
	
}

</style>         
          <div id="customer" class="tab-content m-t-14">
            
            <div class="tab-pane show active" id="home1">
       <div id="count_shows" style="display:none;">
            <div id="total_order_val">Total Order Value <span class="v1"></span> &pound;<span id="total_order_val_count">12566.56</span> </div>
            <div id="total_order">Number Of Orders  <span class="v1"></span> <span id="total_order_count">6</span></div>
      </div>
  
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
            'sAjaxSource': '<?php echo main_url?>Reporting/ajax_orders_list',
            "fnDrawCallback":function(oSettings){
					var data = oSettings.aoData;
					var i;
					var count=0;
					for (i = 0; i < data.length; i++) { 
						var order_val  = data[i]._aData[2];
						order_val  = order_val.replace("&pound;", "");
						count      += parseFloat(order_val) || 0;
					}
					
				    $('#count_shows').show();
					$('#total_order_val_count').html(count.toFixed(2));
					$('#total_order_count').html(this.fnGetNodes().length);
			}, 
			
            "aoColumns": [
                null, null, { "fnRender": function ( oObj ) { 
							
						if(oObj.aData[5] == 'Yes'){
						if(oObj.aData[7] == 'yes'){
							var order_val = parseFloat(oObj.aData[2] - (oObj.aData[6]/1.2));
						}else{
							var order_val = parseFloat(oObj.aData[2] - oObj.aData[6]);
						}
						}else{
							var order_val = parseFloat(oObj.aData[2]);
						}
					    return '&pound;'+order_val.toFixed(2);
								
					}}, null,null,
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