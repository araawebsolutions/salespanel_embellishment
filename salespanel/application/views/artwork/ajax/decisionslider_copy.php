             
             
             
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
						   $buttondeclinetext = "Decline Print File"; $buttonapprovetext = "Approve Print File";
						 }
                      ?>
                       
                            <input type="hidden" id="prejob" value="<?=$previous?>"/>  
                            <input type="hidden" id="nextjob" value="<?=$next?>"/> 
                            <input type="hidden" id="currentjob" value="<?=$chatdetails['ID']?>"/> 
                            <input type="hidden" id="typeofapproval" value="<?=$type?>"/>  
                    
                           <div class="">
                               <div class="item">
                                <a class="hoverfx" href="<?=ARTWORKS.'theme/integrated_attach/'.$row['file']?>" target="_blank">
                                <div class="figure">
                                <i class="fa fa-search-plus f-s-75"></i>
                                </div>
                                <div class="overlay">
                                </div>
                                <img src="<?=ARTWORKS.'theme/integrated_attach/customer-origional.png' ?>">
                                </a>
                                <a href="<?=ARTWORKS.'theme/integrated_attach/'.$row['file']?>" target="_blank">
                                <h4><span>Download</span> Customer Original</h4></a>
                                </div>
                                
                                
                                <div class="item">
                                <a class="hoverfx" href="<?=$softproofpath?>"  target="_blank">
                                <div class="figure" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-search-plus f-s-75"></i>
                                </div>
                                <div class="overlay">
                                </div>
                                <img src="<?=$softproofpath?>">
                                </a>
                                <a href="<?=$softproofpath?>"  target="_blank"><h4><span>Download</span> Customer Softproof</h4></a>
                                </div>
                                
                                                                
                                <div class="item">
                                <a class="hoverfx" href="<?=$printfilepath?>" target="_blank">
                                <div class="figure" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-search-plus f-s-75"></i>
                                </div>
                                <div class="overlay">
                                </div>
                                <img src="<?=ARTWORKS.'theme/integrated_attach/print-file.png'?>">
                                </a>
                                <a href="<?=$printfilepath?>" target="_blank"><h4><span>Download</span> Print File</h4></a>
                                </div>
                           </div>
                    
                  
                    <div class="customNavigation">
                    <? if($previous!=0){?>
                      <a class="btn gray prev remote-control" data-id="<?=$previous?>"><i class="mdi mdi-menu-left"></i></a>
                    <? } ?>  
                    <div class="approve-decline-buttons" style="display: inline-flex;">

                    <div>
                    <button type="button"
                    class="btns btn-outline-dark waves-light waves-effect btn-countinue m-r-10"
                    data-toggle="modal" data-target="#declinemodal">
                    <?=$buttondeclinetext?>
                    </button>

                    </br>
                    <span class="approve-decline-buttons-text">Order No.: <b><?=$row['OrderNumber']?></b></span>
                    </div>
                    <div>

                    <button type="button"
                    class="btns btn-outline-dark waves-light waves-effect btn-countinue btn-print1"
                    data-toggle="modal" data-target="#approvemodal"
                    ><?=$buttonapprovetext?>
                    </button>
                    </br>
                    <span>Print Job No.: <b>PJ<?=$row['ID']?></b></span>
                    </div>
                    </div>
                    <? if($next!=0){?>
                     <a class="btn gray next remote-control" data-id="<?=$next?>"><i class=" mdi mdi-menu-right"></i></a>
                     <? } ?> 
                    </div>
                        
         <? } ?>        