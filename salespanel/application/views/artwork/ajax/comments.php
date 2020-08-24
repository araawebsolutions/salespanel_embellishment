

        <div class="modal-header checklist-header">

            <div class="col-md-12">

                <h4 class="modal-title checklist-title" id="myLargeModalLabel">Comments for Order Number :

                    <?=$order?></h4>

            </div>

        </div>

            <div class="modal-body p-t-0">

                <div class="panel-body">





                    <table class="table table-bordered taable-bordered f-14">

                        <thead>

                        <tr>

                            <th class="text-center">Sr.</th>

                            <th class="text-center">Operator</th>

                            <th class="text-center">Comments</th>

                            <th class="text-center">Time</th>

                            <th class="text-center">Action</th>



                        </tr>

                        </thead>

                        <tbody>

                        

                        

                       <? foreach($data as $row){

						   $operator = $this->Artwork_model->get_operator($row->Operator);

					  ?>    

                        <tr>

                            <td class="text-center"><?=$row->ID?></td>

                            <td class="text-center"><?=$operator?></td>

                            <td class="text-center"><textarea style="height:55px;" readonly><?=$row->comment?></textarea></td>

                            <td class="text-center"><?php echo date('d-m-Y &\nb\sp;&\nb\sp; <b> h : i  A</b>', ($row->Time)); ?></td>

                            <td class="text-center red-text">

                            <a data-id="<?=$row->ID?>" class="deleter" style="color:#F00;cursor:pointer;">Delete</a></td>

                        </tr>

                      <? } ?>

                      

                       </tbody>

                    </table>

                    

                    <p class="message-field-title">Share your feedback, requirement or any other issue:</p>

                    <div style="width: 103%;margin-left: 0px;">

                        <textarea class="form-control blue-text-field" rows="5" id="new-comment"></textarea>

                    </div>

                 <span class="m-t-t-10 pull-right">

                  <button type="button" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save">Submit</button></span>

                  <span class="m-t-t-10 pull-right">

                  <button type="button" aria-label="Close" data-dismiss="modal" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">Close</button></span>

                </div>

            </div>

        

        

        

        

        

<script>

 

 $('.save').click(function() { // the button - could be a class selector instead

   var comment = $('#new-comment').val();

	var order = '<?=$order?>';

	

	if(comment=="" || comment==" " || comment=="  " || comment=="   " || comment=="    "){

	  swal("","Enter Comment First","warning");

	  return false;

	}

	

	$.ajax({

		type: "post",

		url: mainUrl+"Artworks/save_comment",

		cache: false,               

		data:{comment:comment,order:'<?=$order?>'},

		dataType: 'html',

		success: function(data){

		  data = $.parseJSON(data);    

		  $('#all_comments_'+order).html(data.allcount);

		  $('#maked_comments_'+order).html(data.unreadcount);

		  if(data.unreadcount==0){ $('#maked_comments_'+order).hide();}else{ $('#maked_comments_'+order).show();}

		  $('#comments_modal_data').html(data.html);

		},

		error: function(){                      

		  alert('Error while request..');

		}

	 });

});



 $('.deleter').click(function() { // the button - could be a class selector instead

   var id = $(this).attr('data-id');

   var order = '<?=$order?>';

   swal("Are you sure ?", {

			icon:'warning',

			buttons: {

			cancel: "CANCEL",

			yes: {

				text: "CONTINUE",

				value: "yes",

			  },

			},

		})

	.then((value) => {

			switch (value) {

			case "yes":

			  $.ajax({

				type:'POST',

				url: mainUrl+"Artworks/delete_comment",

				data:{id:id,order:'<?=$order?>'},

				cache:false,

				dataType: 'html',

				success:function(data){

				 data = $.parseJSON(data);

				 $('#all_comments_'+order).html(data.allcount);

				 $('#maked_comments_'+order).html(data.unreadcount);

				 if(data.unreadcount==0){ $('#maked_comments_'+order).hide();}else{ $('#maked_comments_'+order).show();}

		         $('#comments_modal_data').html(data.html);

				},

				error: function(data){

				  console.log("error");

				}

			 });

			  

			break;

			default:

			break;

		   }

		});

	});

</script>        

        

        

        