
<!--  Upload Artwork Modal -->
<div class="modal fade bs-example-modal-lg carter1" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog " style=" max-width: 760px;  margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="resetData()" data-dismiss="modal" aria-hidden="true">×
				</button>
				<h4 class="modal-title" id="myLargeModalLabel">Artwork</h4>
			</div>
			<div class="modal-body" style="padding-top:10px">
				<div class="panel-body" style="padding-top:0 !important">
					<?php if($this->uri->segment(1) != 'orderQuotationPage'){  ?>
					<div class="col-md-12 no-padding"><span class="pull-right cart-total-text" id="price">£ 2487.20</span>
						<?php } ?>
						<div id="artworks_uploads_loader" class="white-screen hidden-xs" style="display: none;">
							<div class="loading-gif text-center" style="top:26%;left:29%;">
								<img src="https://www.aalabels.com/theme/site/images/loader.gif" class="image" style="width:139px; height:29px; "></div>
						</div>
						<!--               if you get any problem  then uncomment this line       <div id="ajax_artwork_uploads" class="">-->
						<div id="" class="">
							<div class="col-md-12 col-xs-12 col-sm-12 text-justify no-padding">
								<div class="clear10"></div>
								
								<!-- Upload Artwork -->
								<div id="myatw" class="col-sm-12 p0 no-padding myatw">


								</div>
								
								
								<table id="secondTable" class="table table-bordered m-t-t-10" style="display: none">
									<thead class="modal-table-th">
										<tr>
											<th class="table-headig">PJ #</th>
											<th class="table-headig">Order #</th>
											<th class="table-headig">Artwork Details</th>
											<th class="table-headig">Labels</th>
											<th class="table-headig">Artwork</th>
											<th class="table-headig">Action</th>
										</tr>
									</thead>
									<tbody id="oldartwork">
									</tbody>
								</table>
							
								<div class="col-md-12">
									<div class="clear15"></div>

									<button id="addTobskt" type="button" style="display: none;"
                                            class="btn btn-outline-dark waves-light waves-effect pull-right"
                                            onclick="addToBasket()">Continue <i
                                                class="mdi mdi-arrow-right-bold-circle"></i></button>
								
									<?php //echo '<pre>';print_r($data); echo '</pre>'; ?>
									<?php //echo '<pre>';print_r($detail); echo '</pre>'; echo $this->uri->segment(3); ?>
									
									<?php /*if($this->uri->segment(1)!= 'orderQuotationPage' && ($this->uri->segment(3)!="getOrderDetail"  || 'orderQuotationPage' || $this->uri->segment(3)!="getQuotationDetail") ){  ?>
									<button id="reloadmypage" style="display:none;" type="button"
                                            class="btn btn-outline-dark waves-light waves-effect pull-right"
                                            onclick="updateOrder('<?= @$key ?>','<?=$detail->OrderNumber ?>','<?=$detail->ProductBrand ?>','<?=$detail->ManufactureID ?>','<?=$detail->ProductID ?>','<?=$detail->pressproof ?>','<?=$detail->SerialNumber ?>','<?=$detail->UserID ?>','<?=$detail->Printing; ?>','<?=$detail->LabelsPerRoll ?>','<?=$detail->regmark ?>')" >Continue if <i
                                                class="mdi mdi-arrow-right-bold-circle"></i></button>
									<?php }*/ ?>
									<?php if($this->uri->segment(1)=='orderQuotationPage'){ ?>
									
										<button id="reloadmypage" style="display:none;" type="button"
                                            class="btn btn-outline-dark waves-light waves-effect pull-right"
                                            onclick="tempArtPo()" >Continue<i
                                                class="mdi mdi-arrow-right-bold-circle"></i></button>
									
									<?php } else if($this->uri->segment(3)=='getQuotationDetail'){ ?>
									<button id="reloadmypage" style="display:none;" type="button"
                                            class="btn btn-outline-dark waves-light waves-effect pull-right"
                                            onclick="QuoteDetailp()" >Continue<i
                                                class="mdi mdi-arrow-right-bold-circle"></i></button>
									
									<?php } else if($this->uri->segment(3)=='getOrderDetail'){?>
									<button id="reloadmypage" style="display:none;" type="button"
                                            class="btn btn-outline-dark waves-light waves-effect pull-right"
                                            onclick="Orderdetailp()" >Continue <i
                                                class="mdi mdi-arrow-right-bold-circle"></i></button>
									<?php } ?>
									
								</div>

								<!-- Upload Artwork -->
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">

</script>