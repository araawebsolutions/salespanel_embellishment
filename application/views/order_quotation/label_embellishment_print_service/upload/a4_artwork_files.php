<style>
    .btn-primary {
        color: white !important;
    }
</style>
<?php

if (isset($flag) && ($flag == 'order_detail' || $flag == 'quotation_detail' || $flag == 'cart_detail')) {
    //$refNumber = OrderNumner,QuotationNumnber
    //$lineNumber = O_SerialNumnber,Q_SerialNumber
    //$flag = order_detail,quotation_detail

    if ($flag == 'order_detail'){
        $files = $this->home_model->getArtworkByOrder($lineNumber);
        $table = 'orderdetails';
        $where_coumn = 'SerialNumber';
    }elseif ($flag == 'quotation_detail'){
        $files = $this->home_model->getArtworkForQuotation($lineNumber);
        $table = 'quotationdetails';
        $where_coumn = 'SerialNumber';
    }

    $ProductID = $details['ProductID'];
    $total = $this->home_model->get_db_column($table, 'Quantity', $where_coumn, $lineNumber);
    $designs = $this->home_model->get_db_column($table, 'Print_Qty', $where_coumn, $lineNumber);

    $upload_path = base_url().'theme/assets/images/artworks/';

    $sheets_text  = ($unitqty=='labels')?'Labels':'Sheets';
    $labels_text = ($unitqty=='labels')?'Sheets':'Labels';

    $multiplyfactor = ($unitqty=='labels')?$details['LabelsPerSheet']:1;
    $dividefactor   = ($unitqty=='labels')?1:$details['LabelsPerSheet'];

} else {
    $cartid = $details['cartid'];
    $ProductID = $details['ProductID'];
    $files = $this->home_model->fetch_uploaded_artworks($cartid, $ProductID);

    $total = $this->home_model->get_db_column('temporaryshoppingbasket', 'Quantity', 'ID', $cartid);
    $designs = $this->home_model->get_db_column('temporaryshoppingbasket', 'Print_Qty', 'ID', $cartid);

    $upload_path = base_url().'theme/assets/images/artworks/';

    $sheets_text  = ($unitqty=='labels')?'Labels':'Sheets';
    $labels_text = ($unitqty=='labels')?'Sheets':'Labels';

    $multiplyfactor = ($unitqty=='labels')?$details['LabelsPerSheet']:1;
    $dividefactor   = ($unitqty=='labels')?1:$details['LabelsPerSheet'];

    //print_r($prices);echo"<br>";
    //print_r($labels);echo"<br>";
    //print_r($qty);echo"<br>";
    //print_r($design);die;

}
?>


<div class="clear"></div>

<table class="table table-striped">
    <thead class="">
    <tr>
        <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>
            <td>Artworks</td>

        <?php  } ?>

        <td>File Name</td>
        <td><?=$sheets_text?> </td>
        <td class="text-center"><?=$labels_text?></td>
        <td align="center">Action</td>
    </tr>
    </thead>

    <tbody>

    <?
    $remaingsheets = (isset($sheets) and $sheets!='')?$sheets:$total;
    $total_labels  =  (isset($labels) and $labels!='')?$labels:'';
    $total_sheets  =  (isset($sheets) and $sheets!='')?$sheets:'';
    $uploaded_designs = 0;
    $show_another_line_button = 0;if(count($files) > 0){
        if (count($files) >= $lines_to_populate){
            $show_another_line_button = 1;
        }
        $total_labels = 0;
        $total_sheets = 0;
        foreach($files as $row){


            $total_labels+= $row->labels;
            $total_sheets+=$row->qty;
            $uploaded_designs++;

            if(preg_match("/.pdf/is",$row->file)){
                $artworkpath = AJAXURL.'theme/site/images/pdf.png';

            }
            else if(preg_match("/.doc/is",$row->file) || preg_match("/.docx/is",$row->file)){
                $artworkpath = AJAXURL.'theme/site/images/doc.png';

            }else{
                $artworkpath = $upload_path.$row->file;

            }

            ?>

            <tr class="upload_row">
                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                    <td class="text-center">
                        <img onerror='imgError(this);' class="img-circle" src="<?=$artworkpath?>" width="20" height="" alt="<?=$row->name?>" title="<?=$row->name?>">
                    </td>
                <?php  } ?>

                <td width="30%"><?=$row->name?></td>
                <td width="16%">
                    <input type="text" data-placement="top" data-toggle="popover" data-content="" value="<?=($unitqty=='labels')?$row->labels:$row->qty?>"
                           class="form-control labels_input allownumeric"  />
                    <!--<div class="row" style="vertical-align:middle; text-align:center;">
                           <a data-id="<?=$row->ID?>" href="javascript:void(0);" style="display:none;" class="clear_b sheet_updater">
                           <i class="fa fa-refresh"></i> Update </a>
                       </div>-->
                </td>
                <td width="16%"  align="center" style="vertical-align:middle;" class="text-center displaysheets">
                    <?=($unitqty=='sheets')?$row->labels:$row->qty?>
                </td>
                <td width="45%" align="center" class="text-center" >

                    <button style="display:none;" data-id="<?=$row->ID?>" title="Update artwork details" class="sheet_updater  btn btn-success" >
                        <i class="fa f-10 fa-save "></i>
                    </button>
                    <button data-value="sheets" id="<?=$row->ID?>" title="Delete Artwork" class="delete_artwork_file  btn btn-danger" >
                        <i class="fa f-10 fa-trash "></i>
                    </button>

                </td>
            </tr>


        <? }
        if ($lines_to_populate >= 1){
            $lines_to_populate -=count($files);

        }
        for ( $i = 1; $i <= $lines_to_populate; $i++) {
            ?>
            <tr class="upload_row uploadsavesection" >
                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                    <td width="20%" class="text-center">
                        <img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" alt="<?=$row->name?>"/>
                        <input type="file" name="artwork_file" class="artwork_file"  style=" display:none;"  />
                        <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button>
                    </td>
                <?php  } ?>

                <td width="40%"><input class="form-control artwork_name"  placeholder="Enter Artwork Name" type="text"></td>
                <td width="40%">
                    <input class="form-control labels_input allownumeric"
                           placeholder="<?=$remaingsheets*$multiplyfactor?> <?=$sheets_text?>  remaining" value=""  type="text">


                    <!-- <small style="text-align:center;">Min <?=$details['LabelsPerSheet']?> Labels</small>-->
                </td>
                <td width="20%" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp; </td>
                <td width="28%" align="center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                        <button data-value="sheets" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Savess</button> </div>
                </td>
            </tr>

            <tr id="upload_progress" style="display:none;">
                <td colspan="7"><div id="progressbar" class="col-md-11"></div></td>
                <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
            </tr>

        <?php }

        $lines_to_populate = 0;
        $remaingsheets = $total-$total_sheets;

    }

    $expected_labels = $remaingsheets*$details['LabelsPerSheet'];
    $expected_labels =($expected_labels>0)?$expected_labels:'';



    if (isset($lines_to_populate) && $lines_to_populate > 0){
        for ( $i = 1; $i <= $lines_to_populate; $i++) {
            ?>
            <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
                <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                    <td width="20%" class="text-center">
                        <img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" alt="<?=$row->name?>"/>
                        <input type="file" name="artwork_file" class="artwork_file"  style=" display:none;"  />
                        <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button>
                    </td>
                <?php  } ?>

                <td width="40%"><input class="form-control artwork_name"  placeholder="Enter Artwork Name" type="text"></td>
                <td width="40%">
                    <input class="form-control labels_input allownumeric"
                           placeholder="<?=$remaingsheets*$multiplyfactor?> <?=$sheets_text?>  remaining" value=""  type="text">


                    <!-- <small style="text-align:center;">Min <?=$details['LabelsPerSheet']?> Labels</small>-->
                </td>
                <td width="20%" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp; </td>
                <td width="28%" align="center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                        <button data-value="sheets" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Savess1</button> </div>
                </td>
            </tr>

            <tr id="upload_progress" style="display:none;">
                <td colspan="4">
                    <div id="progressbar" class="col-md-11"></div>
                </td>
                <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
            </tr>

        <?php }
        $lines_to_populate = 0;
    }else{ ?>
        <tr class="upload_row uploadsavesection" style=" <?=(count($files)>0)?'display:none':''?>">
            <?php  if ($upload_artwork_radio == "upload_artwork_now"){ ?>

                <td width="20%" class="text-center">
                    <img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" alt="<?=$row->name?>"/>
                    <input type="file" name="artwork_file" class="artwork_file"  style=" display:none;"  />
                    <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button>
                </td>
            <?php  } ?>

            <td width="40%"><input class="form-control artwork_name"  placeholder="Enter Artwork Name" type="text"></td>
            <td width="40%">
                <input class="form-control labels_input allownumeric"
                       placeholder="<?=$remaingsheets*$multiplyfactor?> <?=$sheets_text?>  remaining" value=""  type="text">


                <!-- <small style="text-align:center;">Min <?=$details['LabelsPerSheet']?> Labels</small>-->
            </td>
            <td width="20%" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp; </td>
            <td width="28%" align="center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                    <button data-value="sheets" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Save</button> </div>
            </td>
        </tr>

        <tr id="upload_progress" style="display:none;">
            <td colspan="4">
                <div id="progressbar" class="col-md-11"></div>
            </td>
            <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>
        </tr>

    <?php }
    ?>









    <!--                   <tr class="upload_row uploadsavesection" style=" --><?//=(count($files)>0)?'display:none':''?><!--">-->
    <!--                       --><?php // if ($upload_artwork_radio == "upload_artwork_now"){ ?>
    <!---->
    <!--                       <td width="20%" class="text-center">-->
    <!--                     <img onerror='imgError(this);' width="20" class="img-circle"  style="display:none;" title="Click here to remove this file"  id="preview_po_img" src="#" alt="--><?//=$row->name?><!--"/>-->
    <!--					 <input type="file" name="artwork_file" class="artwork_file"  style=" display:none;"  />-->
    <!--                     <button class=" btn btn-primary browse_btn" > <i class="fa fa-cloud-upload"></i> Browse File</button>-->
    <!--                      </td>-->
    <!--                       --><?php // } ?>
    <!---->
    <!--                       <td width="40%"><input class="form-control artwork_name"  placeholder="Enter Artwork Name" type="text"></td>-->
    <!--                      <td width="40%">-->
    <!--                      		<input class="form-control labels_input allownumeric"  -->
    <!--                            placeholder="--><?//=$remaingsheets*$multiplyfactor?><!-- --><?//=$sheets_text?><!--  remaining" value=""  type="text">-->
    <!--                            -->
    <!--                       -->
    <!--                     <small style="text-align:center;">Min --><?//=$details['LabelsPerSheet']?><!-- Labels</small>-->
    <!--                      </td>-->
    <!--                      <td width="20%" align="center" style="vertical-align:middle;" class="text-center displaysheets">&nbsp; </td>-->
    <!--                      <td width="28%" align="center"><div class="col-xs-12 col-sm-12 col-md-3  m0 p0"> -->
    <!--                      		<button data-value="sheets" class=" btn btn-success save_artwork_file"> <i class="fa fa-save"></i> Save</button> </div>-->
    <!--                      </td>-->
    <!--                    </tr>-->
    <!--             -->
    <!--                    <tr id="upload_progress" style="display:none;">-->
    <!--                         <td colspan="4">-->
    <!--                                <div id="progressbar" class="col-md-11"></div>-->
    <!--                         </td>-->
    <!--                         <td><label id="upload_pecentage" class="col-md-1"> &nbsp;0%</label></td>   -->
    <!--                    </tr>-->



    <? if($uploaded_designs < 50 && $show_another_line_button == 1){ ?>

        <tr style=" <?=(count($files)>0)?'':'display:none;'?>" id="add_another_line">
            <td colspan="2" class="text-left" style="vertical-align:middle;" >
                <div class="col-xs-12 col-sm-12 col-md-3  m0 p0">
                    <button class="btn btn-success add_another_art"> <i class="fa fa-plus"></i> Add another Line</button>
                </div>
            </td>
            <td class="text-center" style="vertical-align:middle; text-align:center;">&nbsp;</td>
            <td  align="center" style="vertical-align:middle;" class="text-center">&nbsp;</td>
            <td align="center" class="text-center" >&nbsp;</td>
        </tr>
    <? } ?>

    <tr>
        <td width="40%" colspan="2" class="text-left" style="vertical-align:middle;">

            You have <b class="remaing_user_sheets">
                <?=$remaingsheets*$multiplyfactor?></b> <?=$sheets_text?> (
            <b class="remaing_user_labels"> <?=$remaingsheets*$dividefactor?> </b> <?=$labels_text?> ) remaining

        </td>
        <td width="30%" class="text-center" style="vertical-align:middle; text-align:left;">
            <p class="total_user_sheet"><?=$total_sheets*$multiplyfactor?></p>
        </td>
        <td  align="center" style="vertical-align:middle;" class="text-center">

            <p class="total_user_labels"><?=$total_labels/$multiplyfactor?></p>
        </td>
        <td align="center" class="text-center" >&nbsp;</td>
    </tr>

    <tr style="background:none;">
        <td colspan="5">
            <p>In order to upload your artwork you must complete the line e.g. File name and the number of sheets required. Upon which the file will be uploaded.</p>
        </td>
    </tr>


    </tbody>
</table>



<? if($uploaded_designs >= 50){?>
    <div class="col-md-12" style="">
        <div class="col-md-10">
            <h5><i class="fa fa-info-circle" aria-hidden="true"></i> Upload Limit Exceeded </h5>
            <p>If you have additional artworks that you would like to have printed with this order
                please enter the number and our customer care team will contact you.</p>
        </div>
        <div class="col-md-2">
            <input  class="form-control additional_designs allownumeric" maxlength="5" placeholder="+1" type="text">
            <div class="row" style="text-align:center;">
                <a href="javascript:void(0);" style="display:none;"  class="clear_b additional_designs_updatebtn">
                    <i class="fa fa-refresh"></i> Update
                </a>
            </div>
        </div>
    </div>
<? } ?>

<input type="hidden" id="actual_designs_qty" value="<?=$designs?>"  />
<input type="hidden" id="upload_remaining_designs" value="<?=($designs-$uploaded_designs)?>"  />
<input type="hidden" id="upload_remaining_labels" value="<?=($remaingsheets*$details['LabelsPerSheet'])?>"  />

<input type="hidden" id="actual_sheets" value="<?=$total?>"  />
<input type="hidden" id="uploaded_sheets" value="<?=$total_sheets?>"  />