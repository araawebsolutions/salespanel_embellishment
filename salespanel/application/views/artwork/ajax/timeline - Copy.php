<div class="modal fade bs-example-modal-lg timeline-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-lgg" style="width: 75%;">
        <div class="modal-content blue-background">
            <div class="modal-header timeline-header">

            <button type="button" class="close timeline-close-btn" data-dismiss="modal" aria-hidden="true">×
            </button>

            <div class="col-md-8">
                <h4 class="modal-title timeline-title" id="myLargeModalLabel">Time & Status Tracking</h4>
                <p class="timeline-detail">Order No.: <strong><?=$order?></strong></p>
                <span class="pull-left"><div
                        class="sk-spinner sk-spinner-pulse green-pulse"></div>Print Job No.: <b>PJ<?=$jobno?></b></span>
            </div>

            <div class="col-md-4 text-left">
                <p class="blue-text">Checklist: <strong>1hr, 26mins</strong></p>
                <p class="red-text">Customer Care: <strong>8hrs, 34mins</strong></p>
                <p class="green-text">Design Studio: <strong>14hrs, 0mins</strong></p>
                <p class="yellow-text">Customer: 6hrs, <strong>26mins</strong></p>
                <p class="orange-texts">Customer: 6hrs, <strong>26mins</strong></p>
                <p class="black-text">Total Time: 31hrs, <strong>26mins</strong></p>
           </div>

        </div>
            
            
            
<div class="modal-body">
<div class="panel-body">
<div class="row">
<div class="col-md-12">
<div class="">
<div class="timeline">
                                
                         
                 
         <!-- -------------------------------------------------------------------------------------------------------------------------- -->                <? if($data[0]->Action!=72){ ?>
                 
                  	         
                    <article class="timeline-item alt">
                        <div class="text-right">
                            <div class="time-show first">
                                <a href="#" class="btn btn-custom w-lg">Today</a>
                            </div>
                        </div>
                    </article>

                        <? 
						  $status_action = $this->Artwork_model->fetch_status_action($result['status']);
						   $staustitle = $status_action['Action'];
						   if($result['status']==70 && $result['moved'] == 1){ $staustitle = "Move to Converting"; }
						?>
                        <article class="timeline-item" style="height: 100px;">
                            <div class="timeline-desk">
                                <div class="panel red-panel panel-left">
                                    <div class="timeline-box">
                                        <span class="timeline-icon bg-custom">

                                            <div id="timer">
                                              <span id="days"></span>
                                              <span id="hours"></span>:
                                              <span id="minutes"></span>:
                                              <span id="seconds"></span>

                                            </div>

                                        </span>
                                        <span class="arrow red-arrow"></span>
                                        <p> 
                                        <div class="sk-spinner sk-spinner-pulse red-pulse"></div>
                                        <span><?=$staustitle?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>
             <? } ?>
  
      <!-- -------------------------------------------------------------------------------------------------------------------------- -->         

        
          <? $i = -1;
		        foreach($data as $row){
					$status_action = $this->Artwork_model->fetch_status_action($row->Action);
					$statustitle = $status_action['Action'];
					$operator = $this->Artwork_model->get_operator($row->operator);
					if($row->type==0){ $color = 'green-icon'; }
					if($row->type==1){ $color = 'red-icon'; }
					if($row->type==0 && $row->operator==0){ $color = 'yellow-icon'; }
					$time = date('l, jS F, Y | g: ia ',$row->Time);
					
					if($row->Action==17){ $statustitle = "Customer Artwork"; }
					if($row->Action==64){ $statustitle = "Checklist Approved"; }
					if($row->Action==65){ $statustitle = "Softproof Uploaded"; }
					if($row->Action==66){ $statustitle = "Sent To Customer"; }
					if($row->Action==66 && $row->is_reject == 1){ $statustitle = "Softproof Rejected"; }
					if($row->Action==67){ $statustitle = "Softproof Approved"; }
					if($row->Action==67 && $row->is_reject == 1){ $statustitle = "Softproof Rejected"; }
					if($row->Action==68){ $statustitle = "Print File Uploaded"; }
					if($row->Action==69){ $statustitle = "Print File Approved"; }
					if($row->Action==69 && $row->is_reject == 1){ $statustitle = "Print File Rejected"; }
					if($row->Action==70){ $statustitle = "Move to Production"; }
					if($row->Action==71){ $statustitle = "Move to Converting"; }
					if($row->Action==7){ $statustitle = "Move to Print QC"; }
					if($row->Action==72){ $statustitle = "Despatch"; }
					
					
					
				 $i++;
				 $keycount = count($data);
				 $fromd = $data[$i]->Time;
				 
				 $todate = ($i == 0)?date('Y-m-d H:i:s'):date('Y-m-d H:i:s',$data[$i-1]->Time);
				 //$todate = date('Y-m-d H:i:s',$data[$i+1]->Time);
				 $fromdate = date('Y-m-d H:i:s',$fromd);
				
			     $date1 = new DateTime($fromdate);
				 $date2 = $date1->diff(new DateTime($todate));
				  
				 $timespan = '';
				 if($date2->m >0){
				  $timespan.= $date2->m.' mt ';
				 }
				 if($date2->d >0){
				  $timespan.= $date2->d.' days ';
				 }
				 if($date2->h >0){
				  $timespan.= $date2->h.' hrs ';
				 }
				 if($date2->i >0){
				  $timespan.= $date2->i.' mins ';
				 }
		      ?>  



			   <?  if($date2->d >0){?>
                      <article class="timeline-item alt">
                        <div class="text-right">
                            <div class="time-show big-time-date">
                                <a href="#" class="btn btn-custom w-lg"><?=date('l, jS F, Y ',$row->Time);?></a>
                            </div>
                        </div>
                      </article>
                 <? } ?>


 <? if($row->type==1){?>
       <article class="timeline-item">
        <div class="timeline-desk">
            <div class="panel panel-left blue-left-panel">
                <div class="timeline-box">
                    <span class="arrow"></span>
                    <span class="timeline-icon bg-custom red-icon">
                       <?=$statustitle?>
                    </span>
                    <p class="timeline-heading-brief"><?=$timespan?> taken</p>
                    <p class="timeline-heading-name">by <?=$operator?></p>
                    <p class="timeline-heading-time"><small><?=$time?></small></p>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </article> 
      
 <? }else{?>
     <article class="timeline-item alt">
        <div class="timeline-desk p-t-30">
            <div class="panel panel-right blue-panel">
                <div class="timeline-box">
                    <span class="arrow-alt"></span>
                    <span class="timeline-icon bg-custom <?=$color?>">
                        <?=$statustitle?>
                    </span>
                    <p class="timeline-heading-brief"><?=$timespan?> taken</p>
                    <p class="timeline-heading-name">by <?=$operator?></p>
                    <p class="timeline-heading-time"><small><?=$time?></small></p>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </article>

<? } ?>   
     
     
     
     <? } ?>                             
                       
                                     
                            
       <!-- -------------------------------------------------------------------------------------------------------------------------- -->         
             <article class="timeline-item">
                <div class="timeline-desk">
                    <div class="panel panel-left blue-left-panel">
                        <div class="timeline-box">
                            <span class="arrow"></span>
                            <span class="timeline-icon bg-custom red-icon">
                               Customer Artwork
                            </span>
                            <p class="timeline-heading-name">by 
                            <?=(isset($result['Operator']) && $result['Operator']!="")?$result['Operator']:"Customer";?></p>
                            <p class="timeline-heading-time"><small><?=date('l, jS F, Y ',$orderdate);?></small></p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </article> 
    <!-- -------------------------------------------------------------------------------------------------------------------------- -->         




                              
</div>
<hr class="hr-timeline">
<!-- en timeline -->
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


<script>
var timeelm, time, days, hours, minutes, seconds;
days    = 2;
hours   = 1;
minutes = 2;
seconds = 3;
timerGo();

function timerGo() {
    seconds++;
    if (seconds == 60) {
            minutes++;
        seconds = 0;
    }
    if (minutes == 60) {
            hours++;
        minutes = 0;
    }
    if (hours == 24) {
            days++;
        hours = 0;
    }
    
    setTimeout(timerGo, 1000);
	    $("#hours").text(hours);
		$("#minutes").text(minutes);
		$("#seconds").text(seconds);
  }
</script>
