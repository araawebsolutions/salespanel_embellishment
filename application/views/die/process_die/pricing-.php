       
       
       
 <style>
 .padman{
	margin-bottom:10px;
	width:150px;
	}
 </style>      
       <div class="">
          <div class="dataTables_wrapper">
            <div class="header">
            </div><div class="top">
              <div id="table-example_length">
                <div id="my_table_wrapper" class="dataTables_wrapper" role="grid">
                  <table id="my_table" class="table dataTable" aria-describedby="my_table_info">
                    <thead>
                      <tr role="row">
                        <th width="10px;">Sr#</th>
                        <th width="120px;">Supplier</th>
                        <th width="50px;">Cost Price</th>
                        <th width="50px;">Sales Price</th>
                        <th width="50px;">File</th>
                        <th width="100px">Time</th>
                         <th width="30px">Apply</th>
                        <th width="30px">Delete</th>
                  </tr>
                    </thead>
					
                    <tbody role="alert" aria-live="polite" aria-relevant="all" style="max-height:100px;overflow:scroll;">
                    <? $i=0; foreach($result as $row){ $i++; ?>  
                      <tr class="">
                        <td><b><?=$i?></b></td>
                        <td class=""><b><?=$row->supplier?></b></td>
                        <td class=""><?=$row->price?></td>
                        <td class=""><?=$row->sprice?></td>
                        <td class="">
                        <?
                          $path = '';  $href = AJAXURL.'/theme/custom_dies/'.$row->pdf;
						  if(preg_match("/.pdf/is",$row->pdf)){
                            $path = AJAXURL.'theme/site/images/pdf.png';
                          }else if(preg_match("/.doc/is",$row->pdf) || preg_match("/.docx/is",$row->pdf)){
                            $path = AJAXURL.'theme/site/images/doc.png';
                          }
						
						?>
                        <a href="<?=$href?>" target="_blank" id="lnkr"> <img src="<?=$path?>" width="70px" id="uploaded_image"></a>
                        
                        </td>
                         <td class="">
						<?php echo date('d-m-Y', ($row->Time)); ?>
                        <br />
                        <?php echo date('<b> h : i  A</b>', ($row->Time)); ?>
                        </td>
                        <td class="">
                        <button data-id="<?=$row->ID?>" data-value="<?=$serial?>" class="applier" style="cursor:pointer;line-height:5px;font-weight:bold;">Apply</button> 
                        </td>
                        <td class="">
                        <button data-id="<?=$row->ID?>" data-value="<?=$serial?>" class="deleter" style="cursor:pointer;line-height:5px;font-weight:bold;">Delete</button>
                        </td>
                      </tr>
                    <? } ?>  
                     </tbody>
                  </table>
                </div>
              </div>
            </div>
           </div>
           
            <button id="foo" >Add Price</button><br />
         
         <form id="edit_price" enctype="multipart/form-data" action="<?php echo backoffice_url();?>home/save_price">   
            <div id="adder" style="display:none">
            <h3>Add New Price</h3>
            <b> Supplier: <input type="text" placeholder="Enter Supplier" id="supplier" name="supplier" class="padman"/></b> 
            <b> Cost Price: <input type="text" /placeholder="Enter CostPrice" id="price" name="value" class="padman" onblur="calsale();"></b>
            <b> Sales Price: <input type="text" /placeholder="Enter Sales Price" id="sprice" name="svalue" class="padman"></b>
            <input name="file" id="file" style="left: -198.05px; top: 10.7px; margin: 0px;" type="file" class="padman">
            <input type="hidden" value="<?=$serial?>" id="ID" name="serial">
            <button id="save">Save</button> <button id="show_foo" type="button">Cancel</button>
            </div>
          </form>  
          </div>
          
          
		  
<script>
$('#foo').click(function() { // the button - could be a class selector instead
$(this).hide();
$('#adder').show();
});
$('#show_foo').click(function() { // the button - could be a class selector instead
$('#adder').hide();
$('#foo').show();
});



 function calsale(){
	  var price  = $('#price').val();
	  var sprice = price/0.7;
	  sprice = sprice.toFixed(2)
	  $('#sprice').val(sprice);
	}
	
 
   $('.deleter').click(function() { // the button - could be a class selector instead
		var id = $(this).attr('data-id');
		var check = confirm('Do You want to Delete Price ?');
		if(check){
			$.ajax({
				type: "post",
				url: backoffice_url+"home/delete_price",
				cache: false,               
				data:{id:id,serial:'<?=$serial?>'},
				dataType: 'html',
				success: function(data){
					data = $.parseJSON(data);
					$('#fallr').html(data.html);
				},
				error: function(){                      
					alert('Error while request..'); 
				}
			});
		}
	});
	
	  $('.applier').click(function() { // the button - could be a class selector instead
		var id = $(this).attr('data-id');
		var check = confirm('Do You want to Update Price ?');
		if(check){
			$.ajax({
				type: "post",
				url: backoffice_url+"home/apply_price",
				cache: false,               
				data:{id:id,serial:'<?=$serial?>'},
				dataType: 'html',
				success: function(data){
					alert('Price Updated for Quotation');
				},
				error: function(){                      
					alert('Error while request..'); 
				}
			});
		}
	});  

	/*$('#save').click(function() { // the button - could be a class selector instead
		var serial = $(this).attr('data-value');
		var supplier = $('#supplier').val();
		var value = $("#price").val();
		var svalue = $("#sprice").val();
		
		if(supplier=="" || supplier==" "){
			alert('Enter Supplier Name');
			return false;
		}
		if(value=="" || value==" "){
			alert('Enter Cost Price');
			return false;
		}
		if(svalue=="" || svalue==" "){
			alert('Enter Sales Price');
			return false;
		}

		$.ajax({
			type: "post",
			url: backoffice_url+"home/save_price/",
			cache: false,               
			data:{supplier:supplier,serial:serial,value:value,svalue:svalue},
			dataType: 'html',
			success: function(data){
			data = $.parseJSON(data);
				$('#fallr').html(data.html);
			},
			error: function(){                      
				alert('Error while request..'); 
		   }
	   });
   });*/
		   
	
		  </script>