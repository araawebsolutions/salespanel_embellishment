<link rel="stylesheet" href="<?= ASSETS ?>assets/css/jquery-ui.css">
<style>
.autocomplete_bg{
width: 138px;
margin-left: 25%;


}
.save_btn{
 width:150px !important;
}

.ui-autocomplete{
	top: 310.608px;
    left: 137.476px
}

.dt-responsive tbody tr td textarea{
	border: 1px solid #49d0fe;
	height: 35px;
}

.btn-update{
	
}
</style>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">

                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i> Add Products Description</span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body">
                        <table id="table-example" class="table table-bordered table-bordered dt-responsive nowrap text-center dataTable no-footer" style="margin-bottom:10px;">
						 <thead>
							<tr class="header">
							 <th width="20%">Product Code</th>
							 <th>Description</th>
							 <th width="10%">Action</th>
							</tr>
						</thead>
						 <tbody>
						 <form id="add_form">
						   <tr>
							 <td><input id="name" class="form-control autocomplete_bg die" autocomplete="on" placeholder="Product code" type="text"/></td>
							 <td><textarea id="detail" rows="2" class="form-control"></textarea></td>
							 <td><button onclick="add_detail();" type="button" class="btn btn-outline-dark waves-light waves-effect artwork-more-btn save_btn">Save</button></td>
						   </tr>
						  </form> 
						  </tbody>
					   </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
	    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">

                    <div class="card-header card-heading-text">
                        <span><i class="fa fa-dot-circle-o"></i> View Product Descriptions</span>
                        <span class="sea"></span>
                    </div>
                    <div class="card-body">
						<div class="table-responsive">
                        <table id="my_table"  class="table table-bordered table-bordered dt-responsive nowrap text-center dataTable no-footer" border="0" cellpadding="0" cellspacing="0">
							<thead>
							<tr>
							<th width=40>Sr No</th>
							<th width=100>ManufactureID</th>
							<th width=620>Description</th>
							<th width=80>Action</th></tr>
							</thead>
							</table> 
						</div>
                    </div>
                </div>

            </div>
        </div>
        <!-- en row -->
    </div>
</div>

<div class="modal" id="data_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h4>Add Description</h4>
		<textarea id="edetail" rows="10" class="form-control"></textarea>
		<input type="hidden" id="updated_id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark waves-light waves-effect artwork-more-btn save_btn"  onclick="edit_detail()">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>


$('.die').autocomplete({ 				
	source:mainUrl +'product_info/Product_Info/getdie', 
	minLength:2,
	select:function(evt, ui){  
		 $('#dis').html(ui.item.id);
		 pcode = ui.item.code;
		 mat   = ui.item.value;
		 $('#name').val(mat);
	}
});	

 function record(){        
	  var oTable = $('#my_table').dataTable( {
                 
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": mainUrl +'product_info/Product_Info/product_info_datatable',
                "bJQueryUI"  : true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ":20,
				"bDestroy":'bDestroy',
                "iDisplayLength": 25,   
                "aaSorting": [[0, "Desc"]],			 
			 "aoColumns": [

                {
                    "render": function (data, type, row) {
                    
                        return row[0];
                    }
                },
                {
                    "render": function (data, type, row) {
                        return row[1];
                    }
                },
                {
                    "render": function (data, type, row) {
                        return row[2];
                    }
                },
                {
                    "render": function (data, type, row) {
                        var link =  '<i class="fa fa-floppy-o bt-save fa-lg" onclick="show_data('+row[0]+')"> </i>&nbsp;&nbsp;<i class="fa fa-trash-o bt-delete fa-lg" onclick="delete_detail('+row[0]+')"></i><input type="hidden" id="ed'+row[0]+'" value="'+row[2]+'">';
						return  link;
                    }
                }
	  ],
                
        "fnInitComplete": function() {
                //oTable.fnAdjustColumnSizing();
         },  
                
                'fnServerData': function(sSource, aoData, fnCallback)
            {
                   
              $.ajax
              ({
                'dataType': 'json',
                'type'    : 'POST',
                'url'     : sSource,
                'data'    : aoData,
                'success' : function(json) { 
                                         
                fnCallback(json);
												
                }
                
                 
              });
            }
              
            
	});
  
 }
 
 $(document).ready(function() {
	record();
  } );


 function add_detail(){
	 
	var name = $('#name').val();
	var detail = $('#detail').val();
		
	if(name.length<1 || detail.length<1){
		if(name.length<1){
		  alert("please fill Product Name");return false;
		}
		if(detail.length<1){
		  alert("please fill Product Description"); return false;
		}
	   return false;
	 }
	 
	    $("#dvLoading").css('display','block');
		 $.ajax({
		  url: mainUrl +'product_info/Product_Info/add_product_info',
		  type:"POST",
		  data:{name:name,detail:detail},
		  datatype:'html',
		  success:function(data){
		   $('#name').val(''); $('#detail').val('');	  	  
		   record(); 
		   $("#dvLoading").css('display','none');
		 }
	  });
  }
  
  
  function delete_detail(id){
	  var check = confirm('Do You want To delete this line');
	  if(check){
		  $("#dvLoading").css('display','block'); 
	    $.ajax({
		  url: mainUrl +'product_info/Product_Info/delete_product_info',
		  type:"POST",
		  data:{id:id},
		  datatype:'html',
		  success:function(data){
		  record(); 
		  $("#dvLoading").css('display','none');
		 }
	  });
	}else{
	 return false;	
	}
  
  }
  
  
    function edit_detail(){
	  var id = $('#updated_id').val();	
		var detail = $('#edetail').val();
		if(detail.length<1){
		  alert("please fill Product Description"); return false;
	   }else{ 
		 $.ajax({
		  url: mainUrl +'product_info/Product_Info/update_product_info',
		  type:"POST",
		  data:{id:id,detail:detail},
		  datatype:'html',
		  success:function(data){
		  record();
		 }
	  });
	   $('#edetail').html('');
	   $('#updated_id').val('');
	    $('#data_modal').modal('hide');
		}
  }
  
  
  function show_data(id){
	  var manufac = $('#ed'+id).val();
	  $('#edetail').html(manufac);
	  $('#updated_id').val(id);
	  $('#data_modal').modal('show');
  }
  
</script>



