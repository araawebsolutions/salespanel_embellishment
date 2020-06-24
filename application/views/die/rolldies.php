<style>
	#big_Table_wrapper .ui-toolbar{padding:5px;}
	#big_Table_wrapper .ui-toolbar{padding:5px;}
     
	.toolbar {
		display: inline-flex;
		float: left;
		margin-left:18%;
		margin-top: 0rem;
		width: 18%;
	}
    
	.button{
		cursor:pointer;
		width:100px;
	}	
    
	.converter{
		color: red;
		font-weight: bold;
		text-decoration: underline;
		cursor: pointer;
	}
    
	#topnav{
		/* display: none;*/
	}
       
	label {
		margin-bottom: 0rem;
	}
	
	.checkbox input[type="checkbox"] {
	top: 4px !important;
	left: 0px !important;
	height: 21px;
	width: 19px;
	}

	.status-check-box {
		float: left;
		margin-top: -40px !important;
	}
    
	.select{
		background: #fff;
		border-radius: 5px;
		border-style: solid;
		border-width: 1px;
		box-sizing: border-box;
		display: block;
		height: 27px;
		outline: 0;
		padding: 0px 10px;
		width: 100%;
		font-weight: 400 !important;
		border-color: #bababa;
		color: #817d7d;
		font-size: 11.5px;
	}
    
	.red{
		color:red;
	}
	.green{
		color:green;
	}
	.timeline{
		cursor:pointer;
	}
	#shaper{
		padding:4px;
	}
	
	.checkbox input[type="checkbox"]:checked + label::after {
		display: flex !important;        
	}
</style>

<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                
				<div class="card">
                    
					<div class="card-header card-heading-text">
						<span><i class="fa fa-dot-circle-o"></i> Active Rolls Dies</span>
						<span class="sea"></span>
					</div>
                    
					<div class="card-body">
						<div id="table-example_length" >
							<input type="hidden" id="chg" value="Roll Labels">
							<input type="hidden" id="shp">
							<?php echo $this->table->generate(); ?>  
						</div>
					</div>
				</div>
                
			</div>
		</div>
		<!-- en row -->
	</div>
	<!-- en container -->
</div>


<div class="modal fade bs-example-modal-lg comment-modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content blue-background" id="comments_modal_data"></div>
	</div>
</div>


<?  $UserTypeID = $this->session->userdata('UserTypeID'); ?>
   
<script type="text/javascript">
      
	// var UserTypeId = '88';
	var UserTypeId ='<?=$UserTypeID?>';               
	$(document).ready(function() {
		record(mainUrl+"dies/dies/rolldiestable/all/Roll Labels/all"); 
	});
	   
	   
	function record(order){
		var progress = null;
		if(order=="undefined"){
			var  order = mainUrl+"dies/dies/rolldiestable/all/Roll Labels/all";
		}
				
			      
		var oTable = $('#datatable').dataTable({ 
			"sDom": 'l<"toolbar">frtip', 
			"bProcessing": true,
			"bServerSide": true,
			"bDestroy" : true, 
			"sAjaxSource": order,
			"bJQueryUI": true,
			"sPaginationType": "simple_numbers",
			"iDisplayStart ": 20,
			"iDisplayLength": 10,
			"searching": true,
			"aaSorting" :[[0,'asc']],
            
			language: {
				paginate: {
					next: '&#8594;', // or '→'
					previous: '&#8592;' // or '←' 
				}
			},
            
			"aoColumns": [  
			      							
				{ "render" : function (data, type, row ){
					var str =   row[0];
					var code =  str.substring(2);
					   									 
					var img_exten = row[16].split('.');
					if(img_exten){
						return code + '<br><img id='+code+' src="<?=Assets?>images/categoryimages/RollLabels/'+img_exten[0]+'.jpg" height="100" />';
					}else{
						return code;
					}
				}
				},
					        										
				{ "render" : function (data, type, row){
		  						                                		 
					return '<a class="hint--top checkNearestSizes" id="'+row[18]+'" class="orange-text hint--top checkNearestSizes" href="javascript:void(0);" ><b >Nearest</b></a>';	
				}
				},
				{ "render" : function (data , type , row){
					var str =  row[17];
					var code =  str.substring(2);
					var link =  '<a href="<?=Assets?>images/categoryimages/rolltemplates/'+code+'.pdf" height="100" target="_blank"/><b  style="color: red;">Template</b></a>'; 								 
					return row[2]+'<br>'+link;
				}
				},
              
				{ "render" : function (data , type , row){	 
					return row[4]+'<br>'+row[5];
				}
				},
				{ "render" : function (data , type , row){	 
					return row[6];
				}
				},
				{ "render" : function (data , type , row ){
					if(row[7]==0){ return '-'; }	else{ return row[7]; }
				}
				},
				{ "render" : function (data , type , row ){
					if(row[8]==0 || row[8]=='N/A'){ return '-'; }else{ return row[8]; }	
				}
				},
				{ "render" : function (data , type , row ){
					var str  = row[9];
					var str  = str.replace("Round", "");
					var code = str.replace("Radius", "");
					if(code=="N/A" || code==" 0 mm "){
						return '-';
					}else{			
						return code;
					}
				}
				},
				{ "render" : function (data , type , row ){
					if(row[10]==0 || row[8]=='N/A'){ return '-'; }else{ return row[10]; }	
				}
				},
				{ "render" : function (data , type , row ){
					if(row[11]==0 || row[8]=='N/A'){ return '-'; }else{ return row[11]; }	
				}
				},
				{ "render" : function (data , type , row ){
					if(row[12]==0 || row[8]=='N/A'){ return '-'; }else{ return row[12]; }	
				}
				},
				{ "render" : function (data , type , row ){
					var approve   = row[13];
					if(approve=="1"){
						var f0 =''; var f1=''; var f2 ='';
            	            
						f1 = '<i class="fa fa-check green" aria-hidden="true"></i>';
                        
						return f1;
            	           
					}else{
              	          
						var f0 =''; var f1=''; var f2 ='';
                        
						f1 = '<i class="fa fa-close red" aria-hidden="true"></i>';
                        
						if(row[14]=="1"){var respond = 'checked';}else{ var respond = '';}
                    
			         
						return f1;
                        
					}
				}
				},
                
				{ "render" : function (data , type , row ){
					var display   = row[15];
					if(display=="both"){return  'Yes';}else{return  'No';}
				}
				},
				{ "render" : function (data , type , row ){
				    var display2   = row[15];
					if(display2=="both" || display2=="backoffice"){return  'Yes';}else{return  'No';}
				}
				},
				{ "render" : function (data , type , row ){
					var str =  row[17];
					var code =  str.substring(2);
					var code = code.replace(/[<]br[^>]*[>]/gi,"");
					    var isactive = row[19];
                        if (isactive == "N") {
                            isactive =  'In-Active';
                        } else {
                            isactive = 'Active';
                        }
                        
					return  '<p style="cursor:pointer" value="'+code+'" class="orange-text reorder_die" ><b>Reorder Die</b></p><a class="timeLines" data-id="'+row[17]+'"><b style="cursor:pointer" class="orange-text">Timeline</b></a><br><b>'+isactive+'</b>';
				}
				},	
				
				{ "render" : function (data , type , row ){
									var approve   = row[13];
					if(approve=="1"){
						var f0 =''; var f1=''; var f2 ='';
            	            
						
                        
						if(row[14]=="1"){ var respond = 'checked'; }else{ var respond = ''; }
                    
						if(UserTypeId==88){ f2 =  ''; }
						else{   
							
							f2 =   '<div class="checkbox checkbox-info status-check-box spedic"><input type="checkbox" class="approval chBox" data-id="'+row[17]+'" '+respond+'><label for="checkbox4"></label></div>';
						}	
						return f2;
            	           
					}else{
              	          
						var f0 =''; var f1=''; var f2 ='';
                        
						
                        
						if(row[14]=="1"){var respond = 'checked';}else{ var respond = '';}
                    
						if(UserTypeId==88){ f2 =  ''; }
						else{   
							
							f2 =   '<div class="checkbox checkbox-info status-check-box spedic"><input type="checkbox" class="approval chBox" data-id="'+row[17]+'" '+respond+'><label for="checkbox4"></label></div>';
						}	
                        
						return f2;
                        
					}
				}
				},
				
			],
															 
			'createdRow': function( row, data, dataIndex ) {
				$(row).removeClass('odd');
				$(row).addClass('artwork-tr');
			},		 
			"fnInitComplete": function() {
				//  oTable.fnAdjustColumnSizing();
			},
                                                    
			'fnServerData': function(sSource, aoData, fnCallback, oSettings)
			{
				$('.dataTables_wrapper select, .dataTables_wrapper input').addClass("form-control form-control-sm");
			 								
				if (progress) {
					progress.abort();
				}
				progress = $.ajax( {
  				  							
					'dataType':'json',
					'type': 'POST',
					'url': sSource,
					'data': aoData,
					'success':fnCallback  
				});
                                          
				var sha =  $('#shp').val();
				var cats =  $('#chg').val();
        	        
				var selectedshape = sha;
				var labelCategory = cats;
			
				var aller = a3 = a4 = a5 = int = sra3 = roll = '';
				if(labelCategory=="A3 Label"){
					var a3 = "selected='selected'";
				}else if(labelCategory=="A4 Labels"){
					var a4 = "selected='selected'";
				}else if(labelCategory=="A5 Labels"){
					var a5 = "selected='selected'";
				}else if(labelCategory=="Integrated Labels"){
					var int = "selected='selected'";
				}else if(labelCategory=="SRA3 Label"){
					var sra3 = "selected='selected'";
				}else if(labelCategory=="Roll Labels"){
					var roll = "selected='selected'";
				}
                
				$('span.sea').html('<span class="pull-right"><button class="btn btn-primary waves-light waves-effect website_or_backoffice" style="    margin-right: 20px;" id="website" >All Dies</button><button class="btn btn-primary waves-light waves-effect website_or_backoffice" id="backoffice">Backoffice Only</button></span>');
                
				var aller = cir = rec = ov = st = he = ir = sq = '';
				if(selectedshape=="circular"){
					var cir = "selected='selected'";
				}else if(selectedshape=="oval"){
					var ov = "selected='selected'";
				}else if(selectedshape=="rectangle"){
					var rec = "selected='selected'";
				}else if(selectedshape=="square"){
					var sq = "selected='selected'";
				}else if(selectedshape=="star"){
					var st = "selected='selected'";
				}else if(selectedshape=="heart"){
					var he = "selected='selected'";
				}else if(selectedshape=="irregular"){
					var ir = "selected='selected'";
				}
								
				$('span.sea').append('<select class="form-control" style="width:unset; display:inline;float:right; margin-right:20px; margin-left:20px" id="shaper"><option value="all" '+aller+'>Select Shape</option><option value="circular" '+cir+'>Circular</option><option value="oval" '+ov+'>Oval</option><option value="rectangle" '+rec+'>Rectangular</option><option value="square" '+sq+'>Square</option><option value="star" '+st+'>Star</option><option value="heart" '+he+'>Heart</option><option value="irregular" '+ir+'>Irregular</option>');
                
									
				if (document.getElementById('labelCategory')) {
										
					$('div.toolbar').html('<select id="labelCategory" class="form-control" style="display:inline; width:unset;  float:right;"><option value="A3 Label" '+a3+'>A3 Label</option><option value="A4 Labels" '+a4+'>A4 Labels</option><option value="A5 Labels" '+a5+'>A5 Labels</option><option value="Integrated Labels" '+int+'>Integrated Labels</option><option value="SRA3 Label" '+sra3+'>SRA3 Label</option><option value="Roll Labels" '+roll+'>Roll Labels</option>');	
                    
				} else {
                    
					$('span.sea').append('<select id="labelCategory" class="form-control" style="display:inline; width:unset;  float:right;"><option value="A3 Label" '+a3+'>A3 Labels</option><option value="A4 Labels" '+a4+'>A4 Labels</option><option value="A5 Labels" '+a5+'>A5 Labels</option><option value="Integrated Labels" '+int+'>Integrated Labels</option><option value="SRA3 Label" '+sra3+'>SRA3 Labels</option><option value="Roll Labels" '+roll+'>Roll Labels</option>');	
				}
									
             
                
			}
		});
	}    
    
    
	$(document).on("change", "#shaper", function(e) {
		var shape = $("#shaper option:selected").val();
		var labelCategory = $("#labelCategory option:selected").val();
		$('#shp').val($(this).val());
		record(mainUrl+"dies/dies/rolldiestable/"+shape+'/'+labelCategory+'/all'); 
	});
    
	$(document).on("change", "#labelCategory", function(e) {
		var shape = $("#shaper option:selected").val();
		var labelCategory = $("#labelCategory option:selected").val();
		$('#chg').val($(this).val());
		if(labelCategory == 'Roll Labels'){
			record(mainUrl+"dies/dies/rolldiestable/"+shape+'/'+labelCategory+'/all'); 
		}else{
			window.location.replace(mainUrl+"dies");	 
		}
	});
    
    
    
	$(document).on("click", ".website_or_backoffice", function(e) {
		var shape = $("#shaper option:selected").val();
		var labelCategory = $("#labelCategory option:selected").val();
		record(mainUrl+"dies/dies/rolldiestable/"+shape+'/'+labelCategory+'/'+this.id); 
	});
    
    
	$(document).on("click", ".timeLines", function(e) {
		var code = $(this).attr('data-id');
        
		$('#aa_loader').show();

		$.ajax({
			type: "post",
			url: mainUrl+"dies/dies/fetch_timeline",
			cache: false,
			data:{die:code},
			dataType: 'html',
			success: function(data){
				data = $.parseJSON(data);
				$('#comments_modal_data').html(data.html);
				$('#aa_loader').hide();
				$('.comment-modal').modal('show');
			},
			error: function(){
				$('#aa_loader').hide();
				swal("Warning!",'Error while request..','warning'); 
			}
		});
	});
    
    
	$(document).on("change", ".approval", function(e) {
        
        
		swal("Are you sure do you really want to continue?", {
			icon:'warning',
			title: 'Confirm',
			dangerMode: true,
			buttons: {
				cancel: "Cancel",
				yes: {
					text: "Continue",
					value: "yes",
				},
			},
		})
			.then((value) => {
			switch (value) {
				case "yes":
					$('#aa_loader').show();
          	          
					var die = $(this).attr('data-id');
					var checker = (this.checked)?'Y':'N'; 
         
					$.ajax({
						type: "post",
						url: mainUrl+"dies/dies/changediestatus",
						cache: false,               
						data:{checker:checker,die:die},
						dataType: 'html',
						success: function(data){
							$('#aa_loader').hide();
							var shape = $("#shaper option:selected").val();
							var labelCategory = $("#labelCategory option:selected").val();	
							record(mainUrl+"dies/dies/rolldiestable/"+shape+'/'+labelCategory+'/all'); 
                            
							swal("Success! Status Change successfully!", {
								icon: "success",
								dangerMode: true,
							});
						},
						error: function(){
							$('#aa_loader').hide();
							swal("Warning!",'Error while request..','warning'); 
							//swal("Good job!", "You clicked the button!", "success");
						}
					});
                    
					break;
				default:
					$(this).prop('checked', false);
					//alert('no');
					break;
			}
		});
	});
    
    
	$(document).on("click", ".reorder_die", function(e) {
        
		swal("Are you sure do you really want to continue?", {
			icon:'warning',
			title: 'Confirm',
			dangerMode: true,
			buttons: {
				cancel: "Cancel",
				yes: {
					text: "CONTINUE",
					value: "yes",
				},
			},
		})
			.then((value) => {
			switch (value) {
				case "yes":
                    
					$('#aa_loader').show();
					var value = $(this).val();
         
					$.ajax({
						type:"POST",
						url:mainUrl+"dies/dies/reorder_die",
						cache:false,
						data:{value:value},
						success: function(data){
							$('#aa_loader').hide();
							swal("Success! Die is added for reorder successfully!", {
								icon: "success",
							});
                            
						}, 
						error: function(){
							$('#aa_loader').hide();
							swal("Warning!",'Error while request..','warning'); 
						}
					});
					break;
			}
		});
	});
    
	$(document).on("mouseenter", ".checkNearestSizes", function(e) {
		//$('.checkNearestSizes').click(function() {
		var cat_id = $(this).attr('id');
		// alert(cat_id);
		$.ajax({
			type: "post",
			url: mainUrl+"dies/dies/fetchNearestSizes",
			cache: false,               
			data:{cat_id:cat_id},
			success: function(data){
				//alert(data);
				if(data != 'empty'){
					$('#'+cat_id).attr('data-hint', data);
				}else{
					$('#'+cat_id).attr('data-hint', 'Nothing Found');
				}
			},
			error: function(){                      
				swal("Warning!",'Error while request..','warning'); 
			}
		});
	}); 
	 
</script>


<link href="<?= ASSETS ?>assets/css/tooltip.css" rel="stylesheet" type="text/css"/>