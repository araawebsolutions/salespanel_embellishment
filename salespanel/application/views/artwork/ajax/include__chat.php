    <style>
        /*.input-upload-testing-adjustment{
         border: 1px solid #49d0fe;
         border-radius: 4px;
         height: 35px;
         width: 173px;
         margin-bottom: 10px;
         margin-left: 7px;
         padding-top: 7px;
        }*/

        .input-upload-testing-adjustment{
            border: 1px solid #49d0fe;
            border-radius: 4px;
            height: 35px;
            width: 97%;
            margin-bottom: 4px;
            margin-left: 4px;
            padding: 6px;
        }

         body{
            overflow: scroll !important;

        }
        .btn_styling
        {
            margin-bottom: 0px;
            width: 98%;
            margin: 3px auto;
            transition: color 1s ease-in-out, background-color 1s ease-in-out, border-color 1s ease-in-out, box-shadow 1s ease-in-out;
        }

        p.LE_plate_name
        {
            margin: 2px;
            padding: 0;
            text-align: center;
            color: #4eb7eb;
        }
        .btn_new
        {
            
        }
    </style>     

<div class="artwork-images-cards m-t-t-10" style="display:none;margin-right: 15px;margin-left: -4px;padding: 10px;" id="comment_box">

      <div class="row p-10" style="padding: 0px !important;">

           <span class="pull-left col-md-6">

            <ol class="breadcrumb hide-phone p-0 m-0">

                <li class="breadcrumb-item"><a></a></li>

                <li class="breadcrumb-item"><a href="#"><?=$this->Artwork_model->get_operator($this->session->userdata('UserID'));?></a></li>

            </ol>

          </span>

      <span class="text-right col-md-6 p-t-6">

      <?=date('l, jS F, Y | g: ia ');?>

      </span>

    </div>



     <hr class="blue-hr">

     <div class="row">



            <div class="col-md-11">

                <div class="form-group">

                <textarea class="form-control" rows="5" name="comment"  id="comment"

                style="margin-top: 0px;margin-bottom: 0px;height: 140px;border-color: #d0effa;" required></textarea>

                </div>





                <input type="hidden" id="attach-id"  value="<?=$row['ID']?>"/>

                <input type="hidden" id="attachment" value="">

                <input type="hidden" id="softproof"  value="">

                <input type="hidden" id="thumbnail"  value="">

                <input type="hidden" id="pdfformat"  value="">

            





            </div>

            <? if($this->session->userdata('UserTypeID')==88 && $row['is_upload_print_file']==0 && ($row['status']==68 || $row['rejected']==1)){?>

            <!-- NAFEES LA WORK STARTS -->

              <!-- $orderinfo  === orders -->
              <!-- $orderDetailsAttachement  === orderdetails -->
              <!-- $row  === order_attachments_integrated -->

                <div class="col-md-2" style="padding: 10px;">
                    <form id="upload_printfile" enctype="multipart/form-data" action="<?=main_url?>Artworks/upload_printfile">
                        <input type="file" name="file_up" id="file_up" value="" class="input-upload-testing-adjustment"></br>
                        <div class="upload-btn-wrapper">
                            <button class="btn btnn print_file btn_styling"><i class="fa fa-upload"></i> Upload PDF </button>
                            <p class="LE_plate_name"> Print File </p>
                        </div>
                    </form> 
                </div>

               <?php
                
                $orderinfo;
                $orderDetailsAttachement;
                $row;
                $total_files_uploaded = 0;
                if (isset($orderDetailsAttachement['FinishTypePricePrintedLabels']) && $orderDetailsAttachement['FinishTypePricePrintedLabels'] != null ) {
                    $LB_jsonDecode = json_decode($orderDetailsAttachement['FinishTypePricePrintedLabels']);
                    if( gettype($LB_jsonDecode) == "array" ) {
                        foreach ($LB_jsonDecode as $key => $each_LE) {
                            
                            if( ($each_LE->plate_cost > 0)  ) {
                              $total_files_uploaded++;
                            ?>
                                  
                                  <div class="col-md-2" style="padding: 10px;">
                                      <form enctype="multipart/form-data" action="<?=main_url?>Artworks/upload_printfile_LE" class="each_file_form each_file_form_<?=$key?>">
                                          <input type="hidden" class="parsed_parent_title" name="parsed_parent_title" value="<?php echo $each_LE->parsed_parent_title;?>">
                                          <input type="hidden" class="parent_id" name="parent_id" value="<?php echo $each_LE->parent_id;?>">
                                          <input type="hidden" class="order_attachments_integrated_id" name="order_attachments_integrated_id" value="<?=$row['ID']?>">
                                          <input type="hidden" class="uploaded_file_name" name="uploaded_file_names[]" value="">
                                          <input type="hidden" class="db_col_name" name="db_col_name[]" value="">
                                          <input type="hidden" class="file_number" name="file_number" value="<?=$key?>">
                                          <input type="file" name="file_up_<?=$key?>" id="file_up_<?=$key?>" value="" class="input-upload-testing-adjustment"></br>
                                          <div class="upload-btn-wrapper">
                                              <button type="button" onclick="upload_printfile_LE(this, '<?=$key?>' );" class="btn btnn LE_BTN btn_styling"> <i class="fa fa-upload"></i> Upload PDF</button>
                                              <p class="LE_plate_name">
                                                <?php

                                                    if( $each_LE->parent_id == "2" ) {
                                                        echo "Hot Foil (". ucwords( str_replace("_", " ", $each_LE->finish_parsed_title)).")";
                                                    } else {
                                                        echo ucwords( str_replace("_", " ", $each_LE->parsed_parent_title));
                                                    }

                                                ?>
                                              </p>
                                          </div>
                                      </form> 
                                  </div>
                            <?php
                            }
                        }

                    }
                }
              ?>
              <input type="hidden" class="total_files" name="total_files" value="<?=$total_files_uploaded;?>">
            <!-- NAFEES LA WORK ENDS -->


           

           

        <? } ?>

            <div class="form-group m-b-0"  style="margin-left: 15px;">

                <div class="text-right">

                  <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue box_commenthide">Cancel</button>
                
                  <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1" style="margin-left: 6px !important;" onclick="save_comment();"> Submit </button>

                </div>

            </div>
     

        

        

         <? if($this->session->userdata('UserTypeID')==88 && $row['status']==65){?> 

           <div class="col-md-3">

            <form id="add_softproof" style="text-align: right;" enctype="multipart/form-data" action="<?=main_url?>Artworks/upload_softproof">

                <label style="font-size: 12px;color: #1ea4d2;">Attach softproof:</br><input style="border: 1px solid #49d0fe;border-radius: 4px;height: 30px;width: 174px;" type="file" name="soft" id="soft"/></label> 

                <label style="font-size: 12px;color: #1ea4d2;">Attach Pdf:</br><input style="border: 1px solid #49d0fe;border-radius: 4px;height: 30px;width: 174px;" type="file" name="softproofpdf"  id="softproofpdffile"/></label> 

                <label style="font-size: 12px;color: #1ea4d2;">Attach Thumbnail:<input style="border: 1px solid #49d0fe;border-radius: 4px;height: 30px;width: 174px;" type="file" name="softproofthumb"  id="softproofthumbfile"/></label> 

                <div class="upload-btn-wrapper">

                <button class="btn btnn"><i class="fa fa-upload"></i> Upload Softproof </button>

                </div>

            </form>

          </div> 

        <? } ?>

        

        

        

    </div>
 </div>

   

    

    

    <? 
    //echo $row['print_file']; 
    
    foreach($result as $rowp){

		$logiuser = $this->session->userdata('UserID');

		$logiuser = $this->session->userdata('UserTypeID');

		$convertdate = new DateTime($rowp->time);

        $time = $convertdate->format('l, jS F, Y | g: ia ');

		

		$print = FILEPATH.'print/'.$rowp->file;

	  $soft  = FILEPATH.'softproof/'.$rowp->softproof;

	  $pdfview  = FILEPATH.'pdf/'.$rowp->pdf;

		$thumb  = FILEPATH.'thumb/'.$rowp->thumb;


    $laminations_varnishes = FILEPATH.'laminations_varnishes/'.$rowp->laminations_varnishes;
    $hot_foil = FILEPATH.'hot_foil/'.$rowp->hot_foil;
    $embossing_debossing = FILEPATH.'embossing_debossing/'.$rowp->embossing_debossing;
    $silkscreen_print = FILEPATH.'silkscreen_print/'.$rowp->silkscreen_print;

    $softproof_selecter = ($row['softproof']  == $rowp->softproof)?'Y':'N';

	    $printing_selecter  = ($row['print_file'] == $rowp->file)?'Y':'N';

		

		$chatmembers = $this->Artwork_model->fetchchatmembers($rowp->operator,$row['ID'],$row['OrderNumber']);

		

		?>

                                    

    <div class="artwork-images-cards m-t-t-10 m-b-10" style="margin-right: 15px;margin-left: -4px;padding: 10px;">

       <div class="row p-10" style="padding: 0px !important;">



        <span class="pull-left col-md-6">

        <ol class="breadcrumb hide-phone p-0 m-0">

            <li class="breadcrumb-item"><a><?=ucfirst($chatmembers['sender'])?></a></li>

            <li class="breadcrumb-item"><a><?=ucfirst($chatmembers['receiver'])?></a></li>

        </ol>

       </span>

       <span class="text-right col-md-6 p-t-6"><?php echo $time?></span></div>

       <hr class="blue-hr"><div class="row"><div class="col-md-11"> <p class="m-h-100"><?=$rowp->comment?></p></div>

        

        

                    <!------------------SOFTPROOF FILE SECTION-------------------------------->

                

					 <? if(isset($rowp->softproof) && $rowp->softproof!=""){?>    

                        <div class="col-md-4" style="padding-right: 0px;">

                            <div class="upload-btn-wrapper">

                                <button class="btn btnn" onclick="window.open('<?=$soft?>');"><i class="fa fa-file-pdf-o"></i> Download

                                    Softproof

                                </button></div>

                                

                             <? if(isset($rowp->pdf) && $rowp->pdf!=""){?>         

                             <div class="upload-btn-wrapper">

                                <button class="btn btnn" onclick="window.open('<?=$pdfview?>');"><i class="fa fa-file-pdf-o"></i> Download

                                    pdf

                                </button></div>

                             <? } ?>  

                          

                             <? if(isset($rowp->thumb) && $rowp->thumb!=""){?>     

                             <div class="upload-btn-wrapper">

                                <button class="btn btnn" onclick="window.open('<?=$thumb?>');"><i class="fa fa-file-pdf-o"></i> Download

                                    Thumb

                                </button></div>    

                              <? } ?>  

                          

                       <? if($this->session->userdata('UserTypeID')!=88 && $softproof_selecter!="Y" && $row['status']==66 && $rowp->rejected==0){?>                             <div class="upload-btn-wrapper">

                                <a href="<?=main_url?>Artworks/decision/<?=$row['OrderNumber']?>/<?=$row['ID']?>/normal">

                                <button class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">

                                   Approve / Decline

                                </button></a></div>

                             <? } ?>

                           

                            	    <? if($softproof_selecter=="Y"){?>
                            	    
                            	     <? if($this->session->userdata('UserTypeID') !=88){ ?>

                                      <div class="upload-btn-wrapper">

                                       <button class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">

                                        Approved</button></div>

                                    <? } } ?> 

                                    

                                    <? if($rowp->rejected==1){?>

                                      <div class="upload-btn-wrapper">

                                       <button class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">

                                        Rejected</button></div>

                                    <? } ?>

                           </div>    

                   <? } ?>

                   

                   <!------------------SOFTPROOF FILE SECTION-------------------------------->

                   

                   

                   

                    <!------------------PRINT FILE SECTION-------------------------------->

                

					 <? if(isset($rowp->file) && $rowp->file!=""){?>    

                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-2">
                                <div class="upload-btn-wrapper"><button class="btn btnn btn_styling" onclick="window.open('<?=$print?>');"><i class="fa fa-file-pdf-o"></i> Download PDF </button></div>
                                <div class="upload-btn-wrapper"><button class="btn btnn copytoclip btn_styling" data-link="<?=$print?>"><i class="fa  fa-link"></i> Share link</button></div>
                                <p class="LE_plate_name"> Print file </p>
                            </div>
                            
                            <?php if(isset($rowp->laminations_varnishes) && $rowp->laminations_varnishes!=""){ ?>
                              <div class="col-md-2">
                                <div class="upload-btn-wrapper"><button class="btn btnn btn_styling" onclick="window.open('<?=$laminations_varnishes?>');"><i class="fa fa-file-pdf-o"></i> Download PDF </button></div>
                                <div class="upload-btn-wrapper"><button class="btn btnn copytoclip btn_styling" data-link="<?=$laminations_varnishes?>"><i class="fa  fa-link"></i> Share link</button></div>
                                <p class="LE_plate_name"> Lamination & varnishe </p>
                              </div>
                            <?php } ?>

                            <?php if(isset($rowp->hot_foil) && $rowp->hot_foil!=""){ ?>
                              <div class="col-md-2">
                                <div class="upload-btn-wrapper"><button class="btn btnn btn_styling" onclick="window.open('<?=$hot_foil?>');"><i class="fa fa-file-pdf-o"></i> Download PDF </button></div>
                                <div class="upload-btn-wrapper"><button class="btn btnn copytoclip btn_styling" data-link="<?=$hot_foil?>"><i class="fa  fa-link"></i> Share link</button></div>
                                <p class="LE_plate_name"> Hot Foil </p>
                              </div>
                            <?php } ?>

                            <?php if(isset($rowp->embossing_debossing) && $rowp->embossing_debossing!=""){ ?>
                              <div class="col-md-2">
                                <div class="upload-btn-wrapper"><button class="btn btnn btn_styling" onclick="window.open('<?=$embossing_debossing?>');"><i class="fa fa-file-pdf-o"></i> Download PDF </button></div>
                                <div class="upload-btn-wrapper"><button class="btn btnn copytoclip btn_styling" data-link="<?=$embossing_debossing?>"><i class="fa  fa-link"></i> Share link</button></div>
                                <p class="LE_plate_name"> Embossing & Debossing </p>
                              </div>
                            <?php } ?>

                            <?php if(isset($rowp->silkscreen_print) && $rowp->silkscreen_print!=""){ ?>
                              <div class="col-md-2">
                                <div class="upload-btn-wrapper"><button class="btn btnn btn_styling" onclick="window.open('<?=$silkscreen_print?>');"><i class="fa fa-file-pdf-o"></i> Download PDF </button></div>
                                <div class="upload-btn-wrapper"><button class="btn btnn copytoclip btn_styling" data-link="<?=$silkscreen_print?>"><i class="fa  fa-link"></i> Share link</button></div>
                                <p class="LE_plate_name"> Silk Screen </p>
                              </div>
                            <?php } ?>
                          </div>

                           

                     <? if($this->session->userdata('UserTypeID')!=88 && $printing_selecter!="Y" && $rowp->rejected==0 && $row['status']==69 ){?> 

                              <div class="upload-btn-wrapper">

                                <a href="<?=main_url?>Artworks/decision/<?=$row['OrderNumber']?>/<?=$row['ID']?>/normal">

                                <button class="btn btnn" style="background-color: #fd4913 !important;border-color: #fd4913 !important;color: #fff !important;"><i class="fa  fa-file-image-o"></i>

                                   Approve / Decline

                                </button></a></div>

                            <? } ?>

                            

                        

  				            <? if($this->session->userdata('UserTypeID')!=88 && $row['status']==70 && $row['is_upload_print_file']==1 && $rowp->latest==1){?> 

                        <div class="upload-btn-wrapper">

                          <a href="<?=main_url?>Artworks/decision/<?=$row['OrderNumber']?>/<?=$row['ID']?>/rejected">

                          <button class="btn btnn"><i class="fa  fa-file-image-o"></i>

                             Approve / Decline

                          </button></a></div>

                      <? } ?>

                                

                            

                       <? if($printing_selecter=="Y"){?>

                            <div class="upload-btn-wrapper">

                             <button class="btn btnn" style="background-color: #fd4913;border-color: #fd4913;color: #fff;"><i class="fa  fa-file-image-o"></i>

                              Approved</button></div>

                          <? } ?> 

                          

                           <? if($rowp->rejected==1){?>

                            <div class="upload-btn-wrapper">

                             <button class="btn btnn">

                              Rejected</button></div>

                          <? } ?>

                          

                          </div>  

                   <? } ?>

                   

                   <!------------------PRINT FILE SECTION-------------------------------->

        </div>

      </div>

	 <? } ?>

     

