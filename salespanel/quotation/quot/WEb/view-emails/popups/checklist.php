
  
  <div class="modal-dialog ">
    
    <div class="modal-content blue-background">
      <span class="m-t-t-10 pull-right" style="position:relative; margin-top: 2rem;">
               <button style="right: -13px; top: -19px; color: #17b1e3; position: absolute;" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" style="font-size:2.2rem"></i></button>
      </span>
      <div class="checklist-header" style="padding:30px 70px">
        <div class="col-md-12" style="margin-bottom: 2.5rem;">
          <h3 class="modal-title  text-center" id="myLargeModalLabel" style=" border-bottom: 2px solid; margin-bottom: 10px;"><b>DECLINED QUOTATION FEEDBACK</b></h3>
          <p class="timeline-detail text-center">Please check at least one box to communicate the reason for not proceeding with this quote. Thank you.</p>
        </div>
      </div>
      
      <div class="modal-body p-t-0">
        <div class="panel-body">

          <form>
            
            <table class="table table-bordered taable-bordered f-14">
              <thead>
                <tr style="background-color:#17b1e3; color:#fff; ">
                  <th class="text-center">Sr.</th>
                  <th>Description</th>
                  <th colspan="1" class="text-center">Action</th>
                </tr>
              </thead>
              
              <tbody>
                <tr >
                  <td class="text-center">1</td>
                  <td>Purchased elsewhere/Price.</td>
                  <td id="checkboxss" class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input   type="radio" name="q" value="Purchased elsewhere/Price." class="chks">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">2</td>
                  <td>Purchased elsewhere/Product.</td>
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-3" type="radio" name="q" value="Purchased elsewhere/Product" class="chks">
                                     
                    </div>
                  </td>
                             
                </tr>
                <tr>
                  <td class="text-center">3</td>
                  <td>Purchased elsewhere/Services.</td>
                              
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-6" type="radio" name="q" value="Purchased elsewhere/Services." class="chks">
                                     
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">4</td>
                  <td>Purchased elsewhere/Technical.</td>
                              
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-8" type="radio" name="q" value="Purchased elsewhere/Technical." class="chks">
                                      
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">5</td>
                  <td>No longer required.</td>
                            
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-10" type="radio" name="q" value="No longer required." class="chks">
                                      
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">6</td>
                  <td>Requirement changed. New quote required.</td>
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-11" type="radio" name="q" value="Requirement changed. New quote required." class="chks">
                                     
                    </div>
                  </td>
                            
                </tr>
                <tr>
                  <td class="text-center">7</td>
                  <td>Requirement changed. No quote required.</td>
                             
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-14" type="radio" name="q" value="Requirement changed. No quote required." class="chks">
                                    
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">8</td>
                  <td>Other (Please enter brief details in the commentary box below)</td>
                  <td class="text-center">
                    <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                      <input id="checkbox-15" type="radio" class="chks" name="q" value="Other (Please enter brief details in the commentary box below)">
                                      
                    </div>
                  </td>
                            
                </tr>
              </tbody>
            </table>
          

            <p class="message-field-title" style="margin-top: 2rem;">If you would like to provide addtional feedback about why you will not be proceeding, please enter brief details in the commentary box below.</p>
            <div class="row" style="margin-left: 0px;width: 100%;">
              <textarea id="die_notes" class="form-control blue-text-field" rows="5" name="die_notes" style="width:100%"></textarea>
            </div>


            <div style="width:100%; text-align:center">
              
              <button type="button" id="dc_line" onclick="decline_fun();" class="btn orangeBg" style="margin-top:2rem"><span style="padding:0 5rem">SUBMIT</span></button>
            </div>
            

          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
