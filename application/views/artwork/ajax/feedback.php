<div class="modal fade bs-example-modal-lg customerfeedback-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"     aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content blue-background">
         <div class="modal-header checklist-header">
            <div class="col-md-12">
               <h4 class="modal-title checklist-title" id="myLargeModalLabel">Customer Feedback for Print Job  Number : PJ<?=$jobno?></h4>
            </div>
         </div>
         <div class="modal-body p-t-0">
            <div class="panel-body" style="height:600px;overflow-y:auto;">
               <? if(count($feedbackdetails)>0){?>                  
               
               <? foreach($feedbackdetails as $row){?>  
               
               <h5><? $date = new DateTime($row->Time); echo $time = $date->format('d/m/Y  H:i A'); ?></h5>
               <table class="table table-bordered taable-bordered f-14">
                  <thead>
                     <tr>
                        <th class="text-center">Sr.</th>
                        <th>Questions </th>
                        <th colspan="2" class="text-center">Options</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td class="text-center">1</td>
                        <td>Is the spelling, grammar and positioning of text correct?</td>
                        <td colspan="2"><?=($row->q1==0)?$row->q1_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                     <tr>
                        <td class="text-center">2</td>
                        <td>Is the content information correct e.g. Asset codes, bar codes, contact details, dates, ingredients, prices etc?</td>
                        <td colspan="2"><?=($row->q2==0)?$row->q2_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                     <tr>
                        <td class="text-center">3</td>
                        <td>Are the text fonts correct e.g. Pitch and style?</td>
                        <td colspan="2"><?=($row->q3==0)?$row->q3_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                     <tr>
                        <td class="text-center">4</td>
                        <td>Is the alignment and ratio of the artwork correct e.g. As supplied and/or amended and agreed?</td>
                        <td colspan="2"><?=($row->q4==0)?$row->q4_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                     <tr>
                        <td class="text-center">5</td>
                        <td>Are the colours as agreed?</td>
                        <td colspan="2"><?=($row->q5==0)?$row->q5_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                     <tr>
                        <td class="text-center">6</td>
                        <td>Have you checked and approved the roll winding?</td>
                        <td colspan="2"><?=($row->q6==0)?$row->q6_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                     <tr>
                        <td class="text-center">7</td>
                        <td>  Have you checked and approved the roll label core size?</td>
                        <td colspan="2"><?=($row->q7==0)?$row->q7_text:'<b style="color:green">Approved</b>'?></td>
                     </tr>
                  </tbody>
               </table>
               <? } ?>        <? }else{ ?>                  
               <h5 style="text-align: center;">No Feedback Posted Yet</h5>
               <? } ?>                                          
            </div>
            <span class="m-t-t-10 pull-right">   <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">Close</button>                   </span>                                                  
         </div>
      </div>
      <!-- /.modal-content -->    
   </div>
   <!-- /.modal-dialog -->
</div>