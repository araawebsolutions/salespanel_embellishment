<style>
  .btn-print1 {
    margin-left: 0px !important;
    padding: 3px;
  }
  .no-border {
    text-align: center;
  }
</style>
<div class="wrapper">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                  <div class="card-body p-12">

                     <div class="tabs-vertical-env row artwork-row-margin-adjst ">

                            <div class="tab-content" style="width: 100%;">

                                <div class="tab-pane active" id="v-profile">

                                    <div class="row m-t-5">

                                        <span class="artwork-history-text pull-left col-md-6">Customer's Artwork History</span>

                                        <span class="artwork-history-text pull-right col-md-6">



          

                <div class="btn-group dropdown" style="width:22%;margin-left:37%;height: 35px;">

<a href="<?=main_url?>Artworks/" type="" class="btn btn-outline-dark waves-light waves-effect button-adjts-info artwork-more-btn" style="color: #fff !important;text-align: center;padding: 7px;">Back to Artworks</a>

</div>



                <div class="input-group artwork-hsitory-search-bar-div">

                <form method="get">

                <span class="twitter-typeahead">

                <input type="text" name="order" class="form-control ajax_search col-xs-12 tt-input artwork-hsitory-search-bar" placeholder="Search..." value="<?=(isset($_GET['order']) && $_GET['order']!='')?$_GET['order']:''?>">

                   

                  <button class="btn btn-default artwork-hsitory-search-bar-btn" type="submit"> <i class="fa  fa-search"></i> </button>

                 </form> 

                  </span>

                </div>

              </span>

          </div>

       </div>



                            <? if(isset($result) && count($result)>0){?>   

                            

                                <div class="row m-t-5 artwork-history-row-adjustment">



                                    <table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap"

                                           cellspacing="0" width="100%" id="datatable" style="position: relative;">

                                        <thead class="artwork-thead">

                                        <tr>

                                            <th class="no-border">Order No.</th>

                                            <th class="no-border">Print Job No.</th>
                                            
                                            <th class="no-border">CC Operator.</th>

                                            <th class="no-border">Item Code</th>

                                            <th class="no-border">Design Name</th>
                                            
                                            <th class="no-border">Designer Name</th>

                                            <th class="no-border">CO</th>

                                            <th class="no-border">SP</th>

                                            <th class="no-border">PF</th>

                                            
                                            <th class="no-border">Lamination & Varnishes</th>

                                            <th class="no-border">Hot Foil</th>

                                            <th class="no-border">Embossing & Debossing</th>

                                            <th class="no-border">Silk Screen Print</th>


                                            <th class="no-border">Sheet/Rolls</th>

                                            <th class="no-border">Labels</th>
                                            
                                            <th class="no-border">CTA</th>

                                           </tr>

                                        </thead>

                                   

                                     <tbody>

                                        

                                        <? foreach($result as $row){?>

                                        

                                            <tr class="artwork-history-tr">

                                            <td class="no-border"><?=$row->OrderNumber?></td>

                                            <td class="no-border">PJ<?=$row->ID?></td>
                                            
                                            <td class="no-border"><?=$this->Artwork_model->get_operator($orders_data['assigny']);?></td>

                                            <td class="no-border"><?=$row->diecode?></td>

                                            <td class="no-border"><?=$row->name?></td>
                                            
                                            <td class="no-border"><?=($row->designer==DESIGNER)?"Split Order":$this->Artwork_model->get_operator($orders_data['designer']);?></td>

                                            

                                            <td class="no-border">
                                                <a href="<?=ARTWORKS?>/theme/integrated_attach/<?=$row->file?>" target="_blank"> 
                                                    <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1">Download</button>
                                                </a>
                                            </td>

                                            

                                        <td class="no-border">

                                         <? if(isset($row->softproof) && $row->softproof!=""){?>  

                                         <a href="<?=FILEPATH?>softproof/<?=$row->softproof?>" target="_blank"> 

                                         <img src="<?=FILEPATH?>softproof/<?=$row->softproof?>"

                                            width="82" height="59" alt="">

                                          </a>  

                                        <? }else{?>

                                             -----

                                           <? } ?> 

                                        </td>



                                            

                                            

                                    <td class="no-border">

                                   <? if(isset($row->print_file) && $row->print_file!=""){
                                       $userid = $this->session->userdata('UserID');
                                       $usertypeid = $this->session->userdata('UserTypeID');
                                   ?>  

                                    <a href="<?=FILEPATH?>print/<?=$row->print_file?>" target="_blank"> 

                                    <button type="button"

                                    class="btn btn-outline-dark waves-light waves-effect btn-print1">Download</button>

                                    </a>
                                    
                                    <? if($userid== DESIGNER){ ?>
                                    
                                     <br><button type="button" class="btn btn-outline-dark waves-light waves-effect" onclick="$('#reuploadlines').show();$('#jobnumber').val(<?=$row->ID?>);" style="margin-left: 20px !important;margin-top: 5px;">Re-upload File</button>
                                    
                                    <? if($row->Brand=="Rolls"){
                                       $add_info_url = main_url . 'Artworks/rolldetails/' . $row->OrderNumber; ?>
                                      <br> <button type="button" class="btn btn-outline-dark waves-light waves-effect" style="position: relative;top: 5px;width: 151px;" onClick="window.open('<?= $add_info_url ?>')">Add Roll Details</button>
                                     
                                    <? } ?> 
                                    
                                    <? } ?>                   

                                   <? }else{?>

                                     -----

                                   <? } ?> 

                                    
                                    
                                    

                                    </td>





                                            <td class="no-border">
                                                <? if(isset($row->laminations_varnishes) && $row->laminations_varnishes!=""){?>  
                                                    <a href="<?=FILEPATH?>laminations_varnishes/<?=$row->laminations_varnishes?>" target="_blank"> 
                                                        <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1">Download</button>
                                                    </a>
                                                <?php } else {
                                                  echo "-----";
                                                } ?>

                                            </td>

                                            <td class="no-border">
                                                <? if(isset($row->hot_foil) && $row->hot_foil!=""){?>  
                                                    <a href="<?=FILEPATH?>hot_foil/<?=$row->hot_foil?>" target="_blank"> 
                                                        <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1">Download</button>
                                                    </a>
                                                <?php } else {
                                                  echo "-----";
                                                } ?>
                                            </td>

                                            <td class="no-border">
                                                <? if(isset($row->embossing_debossing) && $row->embossing_debossing!=""){?>  
                                                    <a href="<?=FILEPATH?>embossing_debossing/<?=$row->embossing_debossing?>" target="_blank"> 
                                                        <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1">Download</button>
                                                    </a>
                                                <?php } else {
                                                  echo "-----";
                                                } ?>
                                            </td>

                                            <td class="no-border">
                                              <? if(isset($row->silkscreen_print) && $row->silkscreen_print!=""){?>  
                                                  <a href="<?=FILEPATH?>silkscreen_print/<?=$row->silkscreen_print?>" target="_blank"> 
                                                      <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1">Download</button>
                                                  </a>
                                              <?php } else {
                                                  echo "-----";
                                                } ?>
                                            </td>


                                            

                                            <td class="no-border"><?=$row->qty?></td>

                                            

                                            <td class="no-border"><?=$row->labels?></td>
                                            
                                            <td class="no-border"> <button type="button" class="  btn btn-outline-info waves-light waves-effect m-l-10 show_timeline" data-id="<?=$row->ID?>" data-order="<?=$orders_data['OrderNumber']?>" >Check Timeline</button></td>

                                            </tr>

                                            <tr style="height:12px;"></tr>

                                      <? } ?>

                                            

                                       </tbody>

                                    </table>



                                    </div>

                               <? } ?>     

                                    


<div class="tab-content-1" style="display:none;width: 30%;float:right;" id="reuploadlines">
<div class="tab-pane active" id="v-profile">
    <div class="row m-t-5">
        <span class="artwork-history-text pull-left col-md-6" style="font-size: 20px;">Replace Artwork</span>
    </div>
</div>
                                
                       
<div class="row m-t-5 artwork-history-row-adjustment">
<table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap"
cellspacing="0" width="100%" id="datatable" style="position: relative;">
<thead class="artwork-thead">
<tr><th class="no-border">File</th><th class="no-border"></th></tr>
</thead><tbody>
<form id="reupload_artwork" enctype="multipart/form-data" action="<?=main_url?>Artworks/reupload_Artwork_form" class="labels-form">
<tr><td class="center"><div class="upload-btn-wrapper" style="text-align: left !important;">
<button class="btn btnn" style="margin-bottom: 0px;"><i class="fa fa-upload"></i> Upload Design</button><input type="file" name="file_up" id="file_up">
</div></td>
<td class="center"><button style="width:120px;" type="submit" class="next btn btn-outline-dark waves-light waves-effect btn-print1">
<i class="fa fa-floppy-o fa-lg"></i>&nbsp;&nbsp;Save</button></td>
<input type="hidden" id="jobnumber" name="jobnumber" value=""/>
</tr>
</form>   
</tbody>
</table>
</div>
</div>

                                    

                                </div>

                            </div>

                        </div>





                </div>

            </div>

        </div>

        <!-- en row -->

    </div>



    <!-- en container -->

</div>

<script>

    $(document).on("click", ".show_timeline", function(e) {
        var jobno = $(this).attr('data-id');
        var order = $(this).attr('data-order');
        $('#aa_loader').show();

        $.ajax({
            type: "post",
            url: mainUrl+"Artworks/fetch_timeline",
            cache: false,
            data:{jobno:jobno,order:order},
            dataType: 'html',
            success: function(data){
                data = $.parseJSON(data);
                $('#aa_loader').hide();
                $('#popupdiv').html(data.html);
                $('.timeline-modal').modal('show');
            },
            error: function(){
                alert('Error while request..');
            }
        });
    });

 $(document).ready(function (e) {
    $('#reupload_artwork').on('submit',(function(e) { 
		var userfile  = $("#file_up").val();
		var jobnumber = $('#jobnumber').val();
	
		if( userfile.length == 0){
			alert('Please Select File');
			$("#file_up").focus();
			return false;
		}
		
	    e.preventDefault();
        var formData = new FormData(this);
		$('#aa_loader').show();
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
			dataType: 'json',
			success:function(data){
			  if(data.file!=''){
			   $('#aa_loader').hide();
			   window.location.reload(true);
			  }
            },
            error: function(data){
              console.log("error");
            }
         });
      }));
  });	
	
	
</script>

