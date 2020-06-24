<style>
input[type=checkbox], input[type=radio]{
    box-sizing: border-box;
    padding: 0;
    width: 19px;
    height: 19px;   
}
.check{
 margin-top: 2px;
} 
textarea.form-control{
 height: 90px;
 font-size: 15px;
} 
</style>
<div class="modal fade bs-example-modal-lg checklist-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" id="checklist-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Design Team Checklist for Print Job
                        Number : PJ<?=$jobno?></h4>
                    <p class="timeline-detail text-center">Please answer the following questions within <span
                            class="highlight-red">2 hours</span> of order appearing on your screen.</p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">

            <form id="save" action="<?=main_url?>Artworks/add_checklist">
                   <input type="hidden" name="jobno" id="printjobno" value="<?=$jobno?>">
                    <table class="table table-bordered taable-bordered f-14">
                        <thead>
                        <tr>
                            <th class="text-center">Sr.</th>
                            <th>Questions</th>
                            <th colspan="2" class="text-center">Options</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>CO file colour ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-1" type="radio" name="q1" value="1" class="check">
                                    <label for="checkbox-1" class="p-m-0">
                                        CMYK
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-2" type="radio" name="q1" value="0" class="check">
                                    <label for="checkbox-2" class="p-m-0">
                                        RGB
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>CO file is editable ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-3" type="radio" name="q2" value="1" class="check">
                                    <label for="checkbox-3" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-4" type="radio" name="q2" value="0" class="check">
                                    <label for="checkbox-4" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Artwork is compatible with label size ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-5" type="radio" name="q3" value="1" class="check">
                                    <label for="checkbox-5" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-6" type="radio" name="q3" value="0" class="check">
                                    <label for="checkbox-6" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Artwork resolution is fine ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-7" type="radio" name="q4" value="1" class="check">
                                    <label for="checkbox-7" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-8" type="radio" name="q4" value="0" class="check">
                                    <label for="checkbox-8" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Any font issue ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-9" type="radio" name="q5" value="1" class="check">
                                    <label for="checkbox-9" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-10" type="radio" name="q5" value="0" class="check">
                                    <label for="checkbox-10" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Artwork need to redo ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-11" type="radio" name="q6" value="1" class="check">
                                    <label for="checkbox-11" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-12" type="radio" name="q6" value="0" class="check">
                                    <label for="checkbox-12" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>Artwork is compatible for bleed ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-13" type="radio" name="q7" value="1" class="check">
                                    <label for="checkbox-13" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-14" type="radio" name="q7" value="0" class="check">
                                    <label for="checkbox-14" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td>Images' link in file are missing ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-15" type="radio" class="check" name="q8" value="1">
                                    <label for="checkbox-15" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-16" type="radio" class="check" name="q8" value="0">
                                    <label for="checkbox-16" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                         <tr>
                            <td class="text-center">9</td>
                            <td>Sequential / Variable Data Job ?</td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-17" type="radio" class="check" name="q9" value="1">
                                    <label for="checkbox-17" class="p-m-0">
                                        YES
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox checkbox-pink checkbox-circle check-list-checkbox">
                                    <input id="checkbox-18" type="radio" class="check" name="q9" value="0">
                                    <label for="checkbox-18" class="p-m-0">
                                        NO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>
          

                    <p class="message-field-title">Share your feedback, requirement or any other issue:</p>
                    <div class="row" style="margin-left: 0px;width: 103.1%;">
                        <textarea class="form-control blue-text-field" rows="5" name="comment"></textarea>
                    </div>


                    <span class="m-t-t-10 pull-right">
                    <button type="submit" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">Submit Checklist</button></span>
                    <span class="m-t-t-10 pull-right">
                    <button type="button" id="checklist-close" data-dismiss="modal" aria-label="Close" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">Close</button></span>

 </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



 <script>
  $(document).ready(function (e) {
     $('#save').on('submit',(function(e) {
	 
	 var amend = $('.check:checked').length;
	 var total = parseInt(amend);
	 if(total<9){
	  swal('','please check all questions','warning');
	  return false;
	 }
	 
	 var jobno = $('#printjobno').val();
	 var check = confirm('Do you want to continue ?');		
	 if(check){ 
		  e.preventDefault();
          var formData = new FormData(this);
		  $('.loader').show();
		
          $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
			dataType: 'json',
            success: function(data){
              $('.loader').hide();
			  $('#checklist-close').trigger('click');
			  $('.modal-backdrop').remove();
			  $('#popupdiv').html('');
			  $('#printjobdata').html(data.html);
			  $('#lighter_'+jobno).html(data.light);
			  $('#checklist-modal').modal('hide');
            },
            error: function(){                      
              alert('Error while request..'); 
            }
         });
	   }else{
	     return false;
     }
		
	 
    }));
  });  
  </script>