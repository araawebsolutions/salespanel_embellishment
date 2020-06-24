
<style>
	.button-a {

		position: relative;
		overflow: visible;
		display: inline-block;
		padding: 4px 15px;
		border: 1px solid #d4d4d4;
		margin-left: 10px;
		margin-top: 10px;
		text-decoration: none;
		text-shadow: 0px 0px 0 #000000;
		white-space: nowrap;
		cursor: pointer;
		background-image: -moz-linear-gradient(#f4f4f4, #ececec);
		background-image: -o-linear-gradient(#f4f4f4, #ececec);
		background-image: linear-gradient(#f4f4f4, #ececec);
		-webkit-background-clip: padding;
		-moz-background-clip: padding;
		-o-background-clip: padding-box;
		border: 1px solid rgba(0,0,0,.25);
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;	
	}
	
	.button-success {
		background: #00b7f1  none repeat scroll 0 0;
		color: #fff;
		margin-top: 5px;
		width: 50px;
	}
	.button-dis {
		color: rgba(161, 238, 59, 0.07);
		margin-top: 5px;
		width: 50px;
		cursor:no-drop;    
	}
</style>

<div class="modal-content blue-background">
	<div class="modal-header checklist-header">
		<div class="col-md-12">
			<h4 class="modal-title checklist-title" id="myLargeModalLabel">Available Die Codes</h4>
      	     
		</div>
	</div>
	<div class="modal-body p-t-0">
		<div class="panel-body" >

			<div style="<?php if(count($data) > 9){ echo 'height:350px;';}?> overflow:auto">  
				<div class="card">
                    
					<h6 style="margin-left: 2%; text-align: center">Please Select one Code Highlighted In Blue</h6>

                                     
					<div class="card-body">
						<div class="row">
							<?php if(@$data[0]['error']){?>
							<b style="margin-left: 20%"><?=$data[0]['message'];?></b>
							<?php }else{?>
							<?php foreach($data as $record){?>
							<a disabled="disabled" onclick="showCodeOnText('<?=$record['code']?>',<?=$record['id']?>,'<?=$record['status']?>','<?=$record['format']?>')" style="margin: 0.7rem 0.5rem !important; <?= ($record['status'] === 'Active')?'':'cursor:no-drop'?>"   class="btn  waves-light waves-effect up_btn btn-sm <?= ($record['status'] === 'Active')?'btn-outline-info':'btn-outline-dark'?>"><?=$record['code']?></a>
							<?php }}  ?>
						</div>
					</div>
                    
				</div>

			</div>
           
			<span class="m-t-t-10 pull-right">
				<button data-dismiss="modal" type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10">Close</button>
			</span>          
		</div>
	</div>
</div>