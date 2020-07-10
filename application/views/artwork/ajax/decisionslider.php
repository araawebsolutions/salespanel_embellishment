     
<style>
	.newItem_LE
	{
		    width: 25% !important;
	}
	.item1 .hoverfx.newItem_LE_link{
		padding-top: 0px;
	}
	.hoverfx.newItem_LE_link:before
	{
		padding-top: 30%;
	}
	.dummyPDF {
		width: 18% !important;
	    left: 39% !important;
	    top: 37% !important;
	}
</style>
<? if(empty($row)){?>
<h1 style="text-align:center">No More Artworks to Approve</h1>  
<a  href="<?=main_url?>Artworks"><b style="text-align:center">
	<h4 style="text-align:center;text-decoration:underline">Take me to Artworks Dashboard</h4></b></a>      
            
          
<? }else{ ?>
                  
<? if($row['status'] == 66 ){
	$chatdetails = $this->Artwork_model->getchatdetails('softproof',$row['ID']);
	$softproofpath = FILEPATH.'softproof/'.$chatdetails['softproof'];
	$printfilepath = ARTWORKS.'theme/integrated_attach/print-file.png';
	$type = 'soft';
	$buttondeclinetext = "Decline Softproof"; $buttonapprovetext = "Approve Softproof";
}else if($row['status'] == 69 || $row['is_upload_print_file'] == 1){
	$chatdetails = $this->Artwork_model->getchatdetails('file',$row['ID']);
	$softproofpath = FILEPATH.'softproof/'.$row['softproof'];
	$printfilepath = FILEPATH.'print/'.$chatdetails['file'];
	$type = 'print';
	$buttondeclinetext = "Decline Print + Label Embellishments File"; $buttonapprovetext = "Approve Print + Label Embellishments File";


	$laminations_and_varnishes_flag = $chatdetails['laminations_and_varnishes'];
	$hot_foil_flag = $chatdetails['hot_foil'];
	$embossing_and_debossing_flag = $chatdetails['embossing_and_debossing'];
	$silk_screen_print_flag = $chatdetails['silk_screen_print'];

	$laminations_and_varnishes_path = FILEPATH.'laminations_varnishes/'.$chatdetails['laminations_and_varnishes'];
	$hot_foil_path = FILEPATH.'hot_foil/'.$chatdetails['hot_foil'];
	$embossing_and_debossing_path = FILEPATH.'embossing_debossing/'.$chatdetails['embossing_and_debossing'];
	$silk_screen_print_path = FILEPATH.'silkscreen_print/'.$chatdetails['silk_screen_print'];	
}


?>
                       
<input type="hidden" id="prejob" value="<?=$previous?>"/>  
<input type="hidden" id="nextjob" value="<?=$next?>"/> 
<input type="hidden" id="currentjob" value="<?=$chatdetails['ID']?>"/> 
<input type="hidden" id="typeofapproval" value="<?=$type?>"/>  

<div class="">
	<div class="item1">
		<a class="hoverfx" href="<?=ARTWORKS.'theme/integrated_attach/'.$row['file']?>" target="_blank">
			<div class="figure">
				<i class="fa fa-search-plus f-s-75"></i>
			</div>
			<div class="overlay"></div>
			<img src="<?=ARTWORKS.'theme/integrated_attach/customer-origional.png' ?>" style="width:60%; left:22%">
		</a>
		<a href="<?=ARTWORKS.'theme/integrated_attach/'.$row['file']?>" target="_blank"><h4><span>Download</span> Customer Original</h4></a>
		<span class="orange-text" onclick="getOrderComments('<?=$row['OrderNumber']?>');"><h3>View Comments</h3></span>
	</div>
                                
                                
	<div class="item1">
		<!--<img src="<?=$softproofpath?>" class="product_material_image" style="max-width:100%; margin: 6.1rem 0rem 6rem;">
		<a class="hoverfx" href="<?=$softproofpath?>"  target="_blank">
			<div class="figure" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-search-plus f-s-75"></i>
			</div>
			<div class="overlay"></div>
			
		</a>-->
		
		
		<a class="hoverfx" href="<?=$softproofpath?>"  target="_blank">
			<img src="<?=$softproofpath?>" class="product_material_image" style="top:25%">
		</a>
		<a href="<?=$softproofpath?>"  target="_blank"><h4><span>Download</span> Softproof - V<?=$row['version']?></h4></a>
		<?php 
		$res = $this->Artwork_model->fetch_customer_versions_newall($row['ID']);

		if(count($res) > 0){ ?>
		<span class="orange-text View_old" data-pj_id="<?=$row['ID']?>" ><h3>View Declined Versions</h3></span>
		<?php } else{?>
		<span><h3 style="color:#fff">&nbsp;</h3></span>
		<?php } ?>
	</div>
                                
                                                                
	<div class="item1" style=" border-right: 2px solid #ffffff;">
		<a class="hoverfx" href="<?=$printfilepath?>" target="_blank">
			<div class="figure" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-search-plus f-s-75"></i>
			</div>
			<div class="overlay"></div>
			<?php
				$ext = pathinfo( parse_url($printfilepath, PHP_URL_PATH), PATHINFO_EXTENSION );
				if( $ext == "pdf" ) {?>
					<img src="<?=ARTWORKS.'theme/site/images/pdfdummy.png';?>" class="dummyPDF">
				<?php } else {?>
					<img src="<?=$printfilepath?>" style="width:60%; left:22%">
				<?php
				}
			?>
			
		</a>
		<a href="<?=$printfilepath?>" target="_blank"><h4><span>Download</span> Print-File</h4></a>
		<span ><h3 style="color:#fff">&nbsp;</h3></span>
	</div>


	<?php if ($laminations_and_varnishes_flag && $laminations_and_varnishes_flag != '') {?>
		<div class="item1 newItem_LE">
			<a class="hoverfx newItem_LE_link" href="<?=$laminations_and_varnishes_path?>" target="_blank">
				<div class="figure" data-toggle="modal" data-target="#myModal">
					<i class="fa fa-search-plus f-s-75"></i>
				</div>
				<div class="overlay"></div>
				<?php
					$ext = pathinfo( parse_url($laminations_and_varnishes_path, PHP_URL_PATH), PATHINFO_EXTENSION );
					if( $ext == "pdf" ) {?>
						<img src="<?=ARTWORKS.'theme/site/images/pdfdummy.png';?>"  class="dummyPDF">
					<?php } else {?>
						<img src="<?=$laminations_and_varnishes_path?>" style="width:60%; left:22%">
					<?php
					}
				?>
			</a>
			<a href="<?=$laminations_and_varnishes_path?>" target="_blank"><h4><span>Download</span> Lamination & Varnishes PDF</h4></a>
			<span ><h3 style="color:#fff">&nbsp;</h3></span>
		</div>
	<?php } ?>

	<?php if ($hot_foil_flag && $hot_foil_flag != '') {?>
		<div class="item1 newItem_LE">
			<a class="hoverfx newItem_LE_link" href="<?=$hot_foil_path?>" target="_blank">
				<div class="figure" data-toggle="modal" data-target="#myModal">
					<i class="fa fa-search-plus f-s-75"></i>
				</div>
				<div class="overlay"></div>
				<?php
					$ext = pathinfo( parse_url($hot_foil_path, PHP_URL_PATH), PATHINFO_EXTENSION );
					if( $ext == "pdf" ) {?>
						<img src="<?=ARTWORKS.'theme/site/images/pdfdummy.png';?>"  class="dummyPDF">
					<?php } else {?>
						<img src="<?=$hot_foil_path?>" style="width:60%; left:22%">
					<?php
					}
				?>
			</a>
			<a href="<?=$hot_foil_path?>" target="_blank"><h4><span>Download</span> Hot Foil PDF</h4></a>
			<span ><h3 style="color:#fff">&nbsp;</h3></span>
		</div>
	<?php } ?>

	<?php if ($embossing_and_debossing_flag && $embossing_and_debossing_flag != '') {?>
		<div class="item1 newItem_LE">
			<a class="hoverfx newItem_LE_link" href="<?=$embossing_and_debossing_path?>" target="_blank">
				<div class="figure" data-toggle="modal" data-target="#myModal">
					<i class="fa fa-search-plus f-s-75"></i>
				</div>
				<div class="overlay"></div>
				<?php
					$ext = pathinfo( parse_url($embossing_and_debossing_path, PHP_URL_PATH), PATHINFO_EXTENSION );
					if( $ext == "pdf" ) {?>
						<img src="<?=ARTWORKS.'theme/site/images/pdfdummy.png';?>" class="dummyPDF">
					<?php } else {?>
						<img src="<?=$embossing_and_debossing_path?>" style="width:60%; left:22%">
					<?php
					}
				?>
			</a>
			<a href="<?=$embossing_and_debossing_path?>" target="_blank"><h4><span>Download</span> Embossing & Debossing PDF</h4></a>
			<span ><h3 style="color:#fff">&nbsp;</h3></span>
		</div>
	<?php } ?>

	<?php if ($silk_screen_print_flag && $silk_screen_print_flag != '') {?>
		<div class="item1 newItem_LE">
			<a class="hoverfx newItem_LE_link" href="<?=$silk_screen_print_path?>" target="_blank">
				<div class="figure" data-toggle="modal" data-target="#myModal">
					<i class="fa fa-search-plus f-s-75"></i>
				</div>
				<div class="overlay"></div>
				<?php
					$ext = pathinfo( parse_url($silk_screen_print_path, PHP_URL_PATH), PATHINFO_EXTENSION );
					if( $ext == "pdf" ) {?>
						<img src="<?=ARTWORKS.'theme/site/images/pdfdummy.png';?>" class="dummyPDF">
					<?php } else {?>
						<img src="<?=$silk_screen_print_path?>" style="width:60%; left:22%">
					<?php
					}
				?>
			</a>
			<a href="<?=$silk_screen_print_path?>" target="_blank"><h4><span>Download</span> Silk Screen Printing PDF</h4></a>
			<span ><h3 style="color:#fff">&nbsp;</h3></span>
		</div>
	<?php } ?>
	

</div>

<div style="clear:both"></div>
                    
                  
<div class="customNavigation">
	<? if($previous!=0){?>
	<a class="btn gray prev remote-control" data-id="<?=$previous?>"><i class="mdi mdi-menu-left"></i></a>
	<? } ?>  
	<div class="approve-decline-buttons" style="display: inline-flex;         margin: 30px 0 20px;">
		
		<div>
			<button type="button" class="btns btn-outline-dark waves-light waves-effect btn-countinue m-r-10"
                    data-toggle="modal" data-target="#declinemodal" style="border: 1px solid; border-radius: 4px;"> <?=$buttondeclinetext?> </button>

			<br>
		<span class="approve-decline-buttons-text">Order No.: <b><?=$row['OrderNumber']?></b></span>
	</div>
	<div>
		
		<button type="button" class="btns btn-outline-dark waves-light waves-effect btn-countinue btn-print1"
				data-toggle="modal" data-target="#approvemodal" style="border: 1px solid; border-radius: 4px;"><?=$buttonapprovetext?> </button>
		<br>
	<span>Print Job No.: <b>PJ<?=$row['ID']?></b></span>
</div>
</div>
                    <? if($next!=0){?>
<a class="btn gray next remote-control" data-id="<?=$next?>"><i class=" mdi mdi-menu-right"></i></a>
<? } ?> 
</div>
<? } ?>      


<style>

	.history_softproof{
	  cursor:pointer;
	 }
	.SoftProofM {
		padding-left:0 ;
		padding-right:0 ;
	}
	.RevisionHistory {

	}
	.OldSoftproof {
		/*width: 24%;
		 height: 621px;*/
	}
	.OldSoftproof h2 {
		/*font-size: 13px;
		font-weight: bold;
		color: #333;
		margin-bottom: 0;
		margin-top: 10px;*/
		
		font-size: 13px;
		font-weight: bold;
		color: #333;
		margin-bottom: 10px;
		margin-top: 10px;
		text-transform: uppercase;
	}
	
	.OldSoftproof .title {
		margin-bottom: 0 !important;
	}
	.ReviseSoftproofsList {
		margin: 5px 0;
		border: 1px solid #dedede;
		padding: 3px;
	}
	.ReviseSoftProofQA {
		margin-top: 10px;
		font-size: 11px;
	}
	.ReviseSoftProofQA h2 {
		font-weight: bold;
		line-height: 15px;
	}
	.ReviseSoftProofQA p {
		/*margin: 8px 0;*/
		
		 margin: 8px 0;
    font-size: 13px;
	}
	.ReviseSoftProofQA span {
		font-weight: bold;
	}
	.spratorS {
		width: 100%;
		background: #dedede;
		height: 1px;
	}
	.spratorDark {
		width: 100%;
		background: #333;
		height: 1px;
	}
	.slimScrollRail {
		background-color: #f5f5f5!important;
		width: 5px !important;
		box-shadow: inset 0 0 6px rgba(0,0,0,0.3) !important;
		opacity: 1 !important;
	}
	.slimScrollBar {
		width: 5px !important;
		background-color: #000 !important;
		height: 200px !important;
		border-radius: 0 !important;
	}
	
	.decline {
		position: absolute;
		z-index: 1;
		top: 15%;
		left: 25%;
		width: 200px;
		height: auto;
		cursor:pointer;
	}
	
	@media screen and (max-width: 768px)
  	{
		.OldSoftproof {
			width: 100% !important;
		}
	}    
	
	
	.item1 {
		/*margin: 0;
		border-right: 2px solid #4c4c4c;
		color: #f0f0f0;
		text-align: center;
		width: 33.3%;
		float: left;*/
		
		margin: 0;
		border-right: 3px solid #e0e0e0;
		color: #f0f0f0;
		text-align: center;
		width: 33.3%;
		float: left;
	}

	
	
	.item h4{
		margin-bottom: 0px;
		padding-bottom: 29px;
	}
	
	.item1 h4 {
		margin-top: 9.5px;
		margin-bottom: 5px;
		color: #333;
	    font-size: 13px !important;
		/*border-bottom: 2px solid #4c4c4c;*/
	}
	
	.item1 h3 {
		/*margin-top: 0px;
		color: #333;
		font-size: 13px !important;
		border-bottom: 2px solid #4c4c4c;
		line-height: unset;
		margin-bottom: 0px;
		padding-bottom: 5px;
		color: #fd4913;
		text-decoration: underline;
		cursor: pointer;*/
		
		margin-top: 0px;
		color: #333;
		font-size: 13px !important;
		border-bottom: 2px solid #e0e0e0;
		line-height: unset;
		margin-bottom: 0px;
		padding-bottom: 5px;
		color: #fd4913;
		text-decoration: underline;
		cursor: pointer;
	}
	
	.item1 h4 span{
		color: #006ca5;
		font-weight: 900;
	}
	
	.item h4 span{
		color: #006ca5;
		font-weight: 900;
	}
	
	.orange-text {
		color: #fd4913;
		font-weight: bold;
		text-decoration: underline;
	}
	
	.hides{
		display: none;
	}
	
	.thumbnail{
		
		box-shadow: unset;
		
	}
	
	.prMatDC .title {
		background: #ffffff;
		padding: 10px 5px;
		color: #000;
		/* font-size: 14px; */
		margin-bottom: 5px;
		text-align: center;
	}
	
	.item1:hover .figure,
	.item1:hover .overlay {
		opacity: 1;
	}
	
	
	.scale-img:hover .figure,
	.scale-img:hover .overlay {
		opacity: 1;	
	}

	.thumbnail a>img, .thumbnail>img {
		display: inline-block;
		max-width: 100%;
		height: auto;
	}
	
	.scale-img .hoverfx img {
		position: absolute;
		left: 0%;
		width: 100%; 
	}
	
	
	.item1 .hoverfx img {
		position: absolute;
		left: 6.5%;
		width: 85%;
	}
	
	.scale-img .hoverfx {
		position: relative;
		display: block;
		overflow: hidden;
		text-align: center;
		padding-top: 0px; 
		padding-bottom: 0px;
	}
	
	.item1 .hoverfx{
		position: relative;
		display: block;
		overflow: hidden;
		text-align: center;
		padding-top: 75px;
		padding-bottom: 0px;
	}
	
</style>

<script type="text/javascript">
		
	$('.View_old').click(function(){
			
		var pj_id = $(this).data('pj_id');
		var is_show = $('#view').hasClass('hides');
			
			
		if(is_show){
			getDVer(pj_id);
			$('#view').removeClass('hides');
			$('#top_comments').removeClass('hides');
		}else{
			$('#view').addClass('hides');
			$('#top_comments').addClass('hides');
		}
					
	});
		
		
	function getDVer(jobno){
					
		$('#aa_loader').show();
		$.ajax({
			type: "post",
			url: mainUrl+"Artworks/getDVer/",
			cache: false,               
			data:{
				jobno:jobno
			},
			dataType: 'html',
			success: function(data){
				data = $.parseJSON(data);
				$('#aa_loader').hide();
				$('#view').html(data.html);
				$('#top_comments').html(data.top_comments);
				
				$('html, body').animate({
					scrollTop: $("#view").offset().top
				}, 1000);
			},
			error: function(){                      
				alert('Error while request..'); 
			}
		});
	}
	
	 
	
	
	</script>

<script type="text/javascript">
$(".product_material_image").hover(function (e) {
	var value = $(this).aaZoom();
});
	

</script>