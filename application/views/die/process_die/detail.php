<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header no-bg text-center">
				<div class="col-md-6 center-page m-t-t-10">
					<span class="returns-title">Update Die Information </span>
				</div>
			</div>
			<div class="card-body">
                  
				<form method="post" id="edit_submit" class="labels-form" action="">
        	                        
					<div class="row">
						<div class="col-md-4 labels-form">


								<b>Die Type:</b>
                            <label class="select input-border-blue">
								<select id="dietype" class="input-border-blue">
									<option value="">Select Die Type</option>
									<option value="0" <? if(@$data['iseuro']==0){?> selected="selected" <? } ?>>Standard Die</option>
									<option value="1" <? if(@$data['iseuro']==1){?> selected="selected" <? } ?>>Euro Die</option>
								</select>
                                <i></i>
							</label>
						</div>
                                
						<div class="col-md-4">
							<div class="input-margin-10"><b>Label Across:</b>
								<label class="input ">
									<input type="text" placeholder="Enter Label Across" id="across" value="<?=@$data['across']?>" class="required input-border-blue">
								</label>
							</div>
						</div>
                                    
						<div class="col-md-4"><b style="margin-left: 10px;">Label Around:</b>
							<div class="input-margin-10">
								<label class="input ">
									<input type="text" placeholder="Enter Label Around" id="around" value="<?=@$data['around']?>" class="required input-border-blue">
								</label>
							</div>
						</div>                
					</div>
                            
					<div class="row">
						<div class="col-md-4 labels-form">
                                <b>Perforation: </b>
                            <label class="select input-border-blue">
                            <select id="perforation" class="input-border-blue">
									<option value="">Select Status</option>
									<option value="None" <? if(@$data['perforation']=="None"){?> selected="selected" <? } ?>>None</option>
									<option value="2mm Cut 1mm Tie" <? if(@$data['perforation']=="2mm Cut 1mm Tie"){?> selected="selected" <? } ?>>2mm Cut 1mm Tie</option>
								</select>
                                <i></i>
							</label>
						</div>
						<div class="col-md-4">
							<div class="input-margin-10"> <b>Max Labels per Die:</b>
								<label class="input ">
									<input type="text" placeholder="Enter Labels per Die" id="lpd" value="<?=@$data['labels']?>" class="required input-border-blue">
								</label>
							</div>
						</div>
						<div class="col-md-1">
							<div class=""><b style="color:#fff">Perforation: </b>
								<label class="input ">
									<button type="button" id="save" data-value="<?=@$serial?>" class="btn btn-outline-info waves-light waves-effect p-6-10 ">Save </button>
								</label>
							</div>
						</div>
                        
						<div class="col-md-1">
							<div class=""><b style="color:#fff">Perforation: </b>
								<label class="input ">
									<button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10" data-dismiss="modal">CLOSE</button>
								</label>
							</div>
                           
						</div>
					</div>
				</form>
                        
                         
				
			</div>
		</div>
	</div>
</div>
          

		  
<script>
	$('#save').click(function() { // the button - could be a class selector instead
        
		swal("Are you sure you want to Update information?", {
			icon:'warning',
			title: 'Confirm',
			dangerMode: true,
			buttons: {
				cancel: "No",
				yes: {
					text: "Yes",
					value: "yes",
				},
			},
		})
			.then((value) => {
			switch (value) {
				case "yes":
					$('#aa_loader').show();
                    
					var serial = $(this).attr('data-value');
					var across = $('#across').val();
					var around = $("#around").val();
					var dietype = $("#dietype").val();
					var perforation = $("#perforation").val();
					var lpd = $("#lpd").val();
         
					$.ajax({
						type: "post",
						url: mainUrl+"dies/dies/save_details/",
						cache: false,               
						data:{across:across,serial:serial,around:around,lpd:lpd,dietype:dietype,perforation:perforation},
						dataType: 'html',
						success: function(data){
							$('#aa_loader').hide();
							data = $.parseJSON(data);
							swal('Success','Die Information Update Successfully ','success');
							$('#edit_info').modal('hide');
						},  
						error: function(){
							$('#edit_info').modal('hide');
							swal('error','Error while request..','error');  	              
						}
					});    
					break;
			}
		});    
	});	  
</script>