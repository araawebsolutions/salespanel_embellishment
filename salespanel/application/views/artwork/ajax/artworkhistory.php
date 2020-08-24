<style>
@media (max-width: 1360px){
    .hide-col-md-2-small{
        display:none !important;
    }
}



  .btn-print1 {
    margin-left: 0px !important;
    padding: 3px;
  }
  .no-border {
    text-align: center;
  }


</style>
<div class="row m-t-5">
                                        <span class="artwork-history-text pull-left col-md-6">Customer's Artwork History</span>
                                        <span class="artwork-history-text pull-left col-md-2 hide-col-md-2-small"></span>
                                        <span class="artwork-history-text pull-right col-md-4" style="display: inline-flex;float: right;text-align: right;">

              
              <span class="twitter-typeahead">
               <input type="text" name="order" id="search" class="form-control col-xs-12 tt-input artwork-hsitory-search-bar" placeholder="Search..." value="">
              <button class="btn btn-default artwork-hsitory-search-bar-btn" type="submit"> <i class="fa  fa-search"></i> </button>
              </span>
                  
              <div class="input-group artwork-hsitory-search-bar-div">
               <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1 openprintjob" data-id="<?=$jobno?>"> Back to Job Details</button>
             </div>
 </span>
</div>



                                    
           <div class="row m-t-5 artwork-history-row-adjustment"> 
                  <table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap "
                       cellspacing="0" width="100%" id="datatable" style="position: relative;">
                    <thead class="artwork-thead">
                    <tr>
                        <th class="no-border">Order No.</th>
                        <th class="no-border">Print Job No.</th>
                        <th class="no-border">Item Code</th>
                        <th class="no-border">Design Name</th>
                        <th class="no-border">CO</th>
                        <th class="no-border">SP</th>
                        <th class="no-border">PF</th>

                        <th class="no-border">Lamination & Varnishes</th>
                        <th class="no-border">Hot Foil</th>
                        <th class="no-border">Embossing & Debossing</th>
                        <th class="no-border">Silk Screen Print</th>

                        <th class="no-border">Sheet/Rolls</th>
                        <th class="no-border">Labels</th>


                    </tr>
                    </thead>

                   <tbody>
                   
                   
        <? if(count($result)>0){?>           
                   
                    <?  foreach($result as $row){ 
					      $customeroriginal = ARTWORKS.'theme/integrated_attach/'.$row->file;
						  $softproofpath = FILEPATH.'softproof/'.$row->softproof;
						  $printfilepath = FILEPATH.'print/'.$row->print_file;
					 
					?>
                            <tr class="artwork-history-tr">
                                <td class="no-border"><?=$row->OrderNumber?></td>
                                <td class="no-border">PJ<?=$row->ID?></td>
                                <td class="no-border"><?=$row->diecode?></td>
                                <td class="no-border"><?=$row->name?></td>

                                <td class="no-border">
                                    <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1" onclick="window.open('<?=$customeroriginal?>');">
                                        Download
                                    </button>
                                </td>

                                <td class="no-border">
                                <a href="<?=$softproofpath?>" target="_blank">
                                <img src="<?=$softproofpath?>" width="82" height="59" alt=""></a></td>

                                <td class="no-border">
                                    <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-print1" onclick="window.open('<?=$printfilepath?>');">
                                        Download
                                    </button>
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
                            </tr>
                            <tr style="height:12px;"></tr>
                      <? } ?>      
                            
          <? }else{ ?>
             <tr style="height:12px;">
              <td class="no-border" colspan="9">
                <h5 style="text-align:center">No History Found Against this Print Job</h5>
              </td>  
             </tr>
          <? } ?>                  
                            
                   </tbody>
                   </table>

             </div>
 
  
   <script>
    $(document).ready(function(){
      $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#datatable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>

 