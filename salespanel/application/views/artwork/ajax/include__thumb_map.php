



 <div class="row m-t-5">

 

 

 

<div class="col-md-2 col-lg-2" style="display: flex;padding-right: 5px;padding-left: 5px;">
  <div class="artwork-images-card p-2" style="width: 100%;">

<div class="artwork-thumbnail text-center">

<a href="<?=ARTWORKS.'theme/integrated_attach/'.$row['file']?>" target="_blank">

  <img src="<?=ARTWORKS.'theme/integrated_attach/customer-origional.png' ?>" alt="Artwork Uploaded" class="img-fluid">

</a>

<div>

    <span class="badge badge-red artwork-thumbnail-badge">CO</span>

</div></div>
<br />

<div class="artwork-detail-btn-row text-center" style="min-height: 90px;">
<strong>Design Name:</strong>  <br>
<span style="font-size: 12px;"><?=$row['name']?></span>
<br>
<strong>Last Updated:</strong>  <br>
<span style="font-size: 12px;">
<?php if (isset($row['lastmodified']) && !empty($row['lastmodified'])){ echo date('d-m-Y | g: i a ',$row['lastmodified']); }?>
</span>
<br>
</div>   

<div class="artwork-detail-btn-row">
<span class="artwork-details-btn">
<a href="<?=ARTWORKS.'theme/integrated_attach/'.$row['file']?>" target="_blank">Download</a></span>
<? if( ($row['status'] ==64 || $row['status'] ==65) && $this->session->userdata('UserTypeID')!=88){ ?> 
<span class="artwork-detail-btn-divider"></span>
<span class="artwork-details-btn-1" onclick="$('#editaartworkdiv').show();">Edit</span>
<? } ?>
</div>


</div>
</div>


<?

if(isset($row['softproof']) && $row['softproof']!=""){
  $softproofpath = FILEPATH.'softproof/'.$row['softproof'];
 }else{
$softproofpath = ARTWORKS.'theme/integrated_attach/sooftproof.png';

	 }

?>



<div class="col-md-2 col-lg-2 " style="display: flex;padding-right: 5px;padding-left: 5px;">
<div class="artwork-images-card p-2" style="width: 100%;">
<div class="artwork-thumbnail text-center">

<a href="<?=$softproofpath?>" target="_blank">

  <img src="<?=$softproofpath?>" alt="softproof" class="img-fluid">

</a>

<div>

<span class="badge badge-red artwork-thumbnail-badge">SP</span>

</div>

</div>

<br />

<div class="artwork-detail-btn-row text-center" style="min-height: 90px;">
<strong>Design Name:</strong>  <br>
<span style="font-size: 12px;"><?=$row['name']?></span>
<br>
<strong>Last Updated:</strong>  <br>
<span style="font-size: 12px;">
<?php if (isset($row['lastmodified']) && !empty($row['lastmodified'])){ echo date('d-m-Y | g: i a ',$row['lastmodified']); }?>
</span>
<br>
</div> 


<div class="artwork-detail-btn-row">
<? if($row['softproof']!=""){
    $maxref = $this->Artwork_model->fetch_maxref($row['ID']);
    $curnt_chat = $this->Artwork_model->fetch_current_chat($row['ID'],$maxref);  
    $softproofpdfpath = ARTWORKS.'theme/site/printing/chat/pdf/'.$curnt_chat['pdf'];
 ?> <span class="artwork-details-btn" style="font-size: 11px;color: #006ca5;float: left;font-weight: bold;text-align: center;border-right: 1px solid #d0effa;margin-right: 4px;width: 45%;">
<a href="<?=$softproofpdfpath?>" target="_blank" >Download Pdf</a></span>
<span class="artwork-details-btn" style="font-size: 11px;color: #006ca5;float: left;font-weight: bold;text-align: center;width: 45%;">
<a href="<?=$softproofpath?>" target="_blank">View Softproof</a></span>

<? } ?>
<span class="artwork-details-btn artworkhistory" data-id="<?=$row['ID']?>" style="cursor:pointer">View Old Artworks</span>
 </div>

</div>
</div>


<?

if(isset($row['print_file']) && $row['print_file']!=""){

  $printfilepath = FILEPATH.'print/'.$row['print_file'];

  }else{

	 $printfilepath = ARTWORKS.'theme/integrated_attach/print-file.png';

	 }

?>





<div class="col-md-2 col-lg-2" style="display: flex;padding-right: 5px;padding-left: 5px;">
<div class=" artwork-images-card p-2" style="width: 100%;">
<div class="artwork-thumbnail text-center">

<a href="<?=$printfilepath?>" target="_blank">

  <img src="<?=ARTWORKS.'theme/integrated_attach/print-file.png'?>" alt="print file" class="img-fluid">

</a>

<div>

        <span class="badge badge-red artwork-thumbnail-badge">PF</span>

    </div>

</div>

<br />

<div class="artwork-detail-btn-row text-center" style="min-height: 90px;">
<strong>Design Name:</strong>  <br>
<span style="font-size: 12px;"><?=$row['name']?></span>
<br>
<strong>Last Updated:</strong>  <br>
<span style="font-size: 12px;">
<?php if (isset($row['lastmodified']) && !empty($row['lastmodified'])){ echo date('d-m-Y | g: i a ',$row['lastmodified']); }?>
</span>
<br>
</div> 

<div class="artwork-detail-btn-row">


<? if($row['print_file']!=""){ ?>
    <span class="artwork-details-btn">

    <a href="<?=$printfilepath?>" target="_blank">Download</a></span>
<? } ?>
   </div>

</div>
</div>




<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

<style>

.c-bar-graph {

  text-align: center;

  color: black;

  font-size: .9rem;

  width: 100%;

  border-bottom: 1px solid lightgray;

  margin-bottom: 1rem;

}

@media (min-width: 45em) {

  .c-bar-graph {

    font-size: 1.1rem;

  }

}

.c-bar-graph__footer {

  border-top: 1px solid lightgray;

}

.c-bar-graph__footer td {

  line-height: 1.3em;

  font-size: 10px;

  vertical-align: top;

  padding: .4rem 0;

  font-weight: bold;

}

.c-bar-graph__cell {

  height: 40px;

  vertical-align: bottom;

  padding-bottom: 0;

  color: white;

}

.c-bar-graph__data {

	height: 30px;

	line-height: 30px;

	font-size: 8.5px;

	display: block;

	position: relative;

	transition: height 1s ease-out;

	font-weight: bold;

}

.c-bar-graph__helper {

  font-weight: 400;

  font-size: 12px;

  line-height: 20px;

  clear: both;

  display: block;

}

@media (min-width: 45em) {

  .c-bar-graph__helper {

    display: none;

  }

}

.blue_graph{ background-color:#005b8a !important;}

.red_graph{ background-color:#d60000 !important;}

.green_graph{ background-color:#038506 !important;}

.yellow_graph{ background-color:#d7b508 !important;}

.brown_graph{ background-color:#d07345 !important;}

</style>





       <div class="col-md-6 col-lg-6" style="display: flex;padding-right: 25px;padding-left: 5px;">
<div class="artwork-images-card p-2" style="width: 100%;padding: 5px !important;">


                <table class="table table-borderless mb-0">

                    <thead class="artwork-border-bottom">

                    <tr>

                        <th>CO</th>

                        <th>SP</th>

                        <th>CA</th>

                        <th>PF</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                    

        <td><i class="<?=($row['CO']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>

        <td><i class="<?=($row['SP']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>

        <td><i class="<?=($row['CA']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>

        <td><i class="<?=($row['PF']==1)?'mdi mdi-check-circle green-tick':'fa  fa-times-circle red-cross'?>"></i></td>

        <? $map_action = $this->Artwork_model->fetch_status_action($row['status']);?>


<? if($row['checklist']==0 && $row['CO']==1){
    $bgalert = 'blue-badge-aert';  $bgdot = 'blue-artwork-pulse';
    $map_action['StatusTitle'] = 'Pending Checklist';
    $map_action['Action'] = 'Submit Checklist';
  }else if($row['action']==0){
    $bgalert = 'red-badge-aert';  $bgdot = 'red-pulse-1';
  }else  if($row['action']==1){
    $bgalert = 'green-alert';  $bgdot = 'green-pulse-1';
  } if($row['action']==2){
    $bgalert = 'yellow-badge-aert';  $bgdot = 'yellow-artwork-pulse';
  }
?>
<td>
<ul class="<?=$bgalert?> artwork-list-tab">
<li class="pull-left"><div class="sk-spinner sk-spinner-pulse <?=$bgdot?>"></div></li>
<li><?=$map_action['StatusTitle']?> V<?= $row['version'] ?></li>
</ul>
</td>

<td>
<ul class="<?=$bgalert?> artwork-list-tab">
<li class="pull-left"><div class="sk-spinner sk-spinner-pulse <?=$bgdot?>"></div></li>
<li><?=$map_action['Action']?></li>
</ul>
</td>

</tr>



</tbody>
</table>
<hr class="blue-hr">

                <div>

               

                <? $durations = $this->Artwork_model->fetch_overall_jobtime($row['ID']); 

				   $completetime = $this->Artwork_model->commplete_jobtime($row['ID'],'customer'); ?>

                  <table class="c-bar-graph">

                                 <tfoot class="c-bar-graph__footer">

                                    <tr>

                                      <td><?=$durations['checklist_set']?></td>

                                      <td><?=$durations['customercare_set']?></td>

                                      <td><?=$durations['designer_set']?></td>

                                      <td><?=$durations['customer_set']?></td>

                                      <td><?=$durations['factory_set']?></td>

                                    </tr>

                                  </tfoot>

                                  <tbody>

                                    <tr>

                                      <td class="c-bar-graph__cell" data-graph="<?=$durations['checklist']?>">

                                        <span class="c-bar-graph__data blue_graph"></span>

                                      </td>

                                      <td class="c-bar-graph__cell" data-graph="<?=$durations['customercare']?>">

                                        <span class="c-bar-graph__data red_graph"></span>

                                      </td>

                                      <td class="c-bar-graph__cell" data-graph="<?=$durations['designer']?>">

                                        <span class="c-bar-graph__data green_graph"></span>

                                      </td>

                                      <td class="c-bar-graph__cell" data-graph="<?=$durations['customer']?>">

                                        <span class="c-bar-graph__data yellow_graph"></span>

                                      </td>

                                      <td class="c-bar-graph__cell" data-graph="<?=$durations['factory']?>">

                                        <span class="c-bar-graph__data brown_graph"></span>

                                      </td>

                                    </tr>

                                  </tbody>

                              </table>

      <? $max =  max($durations['checklist'],$durations['customercare'],$durations['designer'],$durations['customer'],$durations['factory']);?>

                </div>

                <hr class="blue-hr">



                <div class="total-time-check">

                    <?=$completetime?>, total time of the PJ (Exc, customer time). <strong> <br />

                    <a class="show_timeline" data-id="<?=$row['ID']?>" data-order="<?=$row['OrderNumber']?>">See Full Timeline</a></strong>

                </div>





            </div>
             </div>

       </div>                          



<script>

$('td').each(function() {

  var max = <?=$max?>/2;

  var cell = $(this).data('graph');

  var cellHeight = (cell / max) * 100;

  $('span', this).height(cellHeight + '%');

});

</script> 

                                        

<div class="artwork-images-cards m-t-t-10" id="editaartworkdiv" style="display:none;margin-right: 15px;margin-left: -4px;">

<button type="button" class="close"  onclick="$('#editaartworkdiv').hide();"><span aria-hidden="true">×</span></button>

   <div class="row p-10">

    <form id="uploadnewco" enctype="multipart/form-data" action="<?=main_url?>Artworks/edit_artwork">

      <input type="file" name="file" id="file" value="" style="float: left;background: white;border: 1px solid #49d0fe;color: #1ea4d2;min-width: 174px;height: 35px;padding:0px;border-radius: 4px;margin-right: 20px;">

       <div class="upload-btn-wrapper">

        <input type="hidden" value="<?=$row['ID']?>" id="uploadcoid" name="uploadcoid">

        <button class="btn btnn" type="submit"> <i class="fa fa-upload"></i> Click to Update</button> </div>

    </form> 



</div>

</div>