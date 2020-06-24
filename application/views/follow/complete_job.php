<style>
    #responsive-follow_info{
        font-weight: normal !important;
        font-size: 0.8125rem;
    }
    #responsive-follow_paginate{
     font-weight: normal !important;
     font-size: 0.8125rem;   
    }
    #responsive-follow_last{
            display: none;
    }
    #responsive-follow_first{
        display: none;
    }
</style>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card table-responsive">
                    <div class="card-header card-heading-text"><span><i class="mdi mdi-account"></i> Complete Job</span>
                        <input type="hidden" value="<?=$this->session->userdata('login_user_id')?>" id="hidden">

              
<span class="pull-right pull-right-datatable">
            <a href="<?= main_url ?>/follow/Followup" class="btn btn-primary waves-light waves-effect website_or_backoffice">Back to Follow Up</a>
            </span>
        </div>
                    <div class="card-body">
                        <table id="responsive-follow" class="table table-bordered table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Refno</th>
                                <th>Complete<br>Date / Time</th>
                                <th>Post Code</th>
                                <th>Country</th>
                                <th>Price</th>
                                <th>Customer Name</th>
                                <th>Operator</th>
                                <th>Phone #</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- en row -->
    </div>
    <!-- en container -->
</div>
<!-- en wrapper -->
<!-- Artwork Comment Popup Start -->
<div class="modal fade bs-example-modal-lg" id="comment_popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="comment_body">

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Artwork Comment Popup End -->
<script type="text/javascript">

    $(document).ready(function () {
        $(document).on('change', '#user_follow_up', function() {
            var UserID = $("#user_follow_up").val();
            completeJobRecords(UserID);
        });

        <?php
          $userID = $this->session->userdata('login_user_id');
          $userType = $this->session->userdata('UserTypeID');
                       
            if($userType == 50){
                $value = 'all';
            }else{
                $value = $userID;
            }
             $value = 'all';
        ?>
        
        completeJobRecords('<?=$value ?>');


    });

    function completeJobRecords(userId) {
        $('#responsive-follow').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>follow/Followup/completeJobRecords/'+userId,

            "aoColumns": [
                {
                    "render": function (data, type, row) {
                        //console.log(row[7]);
                        var firstcol = row[0];

                        if(firstcol.substr(0,1) == "E"){
                            firstcol_refno = '<a href="<?= main_url?>getEnquiryDetail/'+firstcol+'" target="_blank"><b>'+firstcol+'</b></a>';
                        }
                        else if(firstcol.substr(0,3) == "AAQ" || firstcol.substr(0,3) == "ATQ"){
                            firstcol_refno = '<a href="<?= main_url?>order_quotation/quotation/getQuotationDetail/'+firstcol+'" target="_blank"><b>'+firstcol+'</b></a>';
                        }
                        else if(firstcol.substr(0,3) == "AAE"){
                            var firstcol = firstcol.replace("AA","");
                            var firstcol_refno= "<a href='"+mainUrl+"order_quotation/order/getOrderDetail/"+firstcol+"' target='_blank'><b>"+firstcol+"</b></a>";
                        }
                        else if(firstcol.substr(0,2) == "DD"){
                            var firstcol = firstcol.replace("DD","AA");
                            var firstcol_refno = "<a href='"+mainUrl+"order_quotation/order/getOrderDetail/"+firstcol+"' target='_blank'><b>"+firstcol+"</b></a>";
                        }
                        else
                        {
                            var firstcol_refno= "<a href='"+mainUrl+"order_quotation/order/getOrderDetail/"+firstcol+"' target='_blank'><b>"+firstcol+"</b></a>";
                        }
                        return firstcol_refno;
                    }
                },
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    "render": function (data, type, row) {

                        var refno = row[0];

                        return '<a class="comments" style="cursor:pointer;" data-id="'+refno+'"> <i id="comments_'+refno+'">'+row[10]+'</i><i> Comments</i></a>';
                    }
                },
            ],
            "fnInitComplete": function () {

            },
            'fnServerData': function (sSource, aoData, fnCallback) {
                $.ajax({
                    "dataType": 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },


        });
    }
	
    $(document).on("click", ".comments", function(e) {
			$('#foollow_comments').modal('show');

			var order = $(this).attr('data-id');
			
			$("#dvLoading").css('display','block');
			var value = "callback";
			
			$.ajax({
				type: "post",
				url: mainUrl+"follow/Followup/fetchComments/",
				cache: false,
				data:{order:order, value:value},
				dataType: 'json',
				success: function(data){
					// console.log(data);
					$('#comment_body').html(data.html);
					$('#comment_popup').modal('show');
				},
				error: function(){
					alert('Error while request..');
				}
			});
		});
	
    function hideCommentModal() {
        $('#comment_popup').modal('hide');
    }
	
	function saveComment() {

		var comment = $('#new_comment').val();
		var order = $('#comment_orderno').val();

		if(comment=="" || comment==" " || comment=="  " || comment=="   " || comment=="    "){
			swal("","Enter Comment First","warning");
			return false;
		}

		$.ajax({
			type: "post",
			url: mainUrl+"follow/Followup/saveComment",
			cache: false,
			data:{comment:comment,order:order},
			dataType: 'json',
			success: function(data){
				$('#comment_body').html(data.html);
				$('#comments_'+order).text(data.count);
			},
			error: function(){
				alert('Error while request..');
			}
		});
	}
	
    function deleteComment(key,commentId,orderNumber) {
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
							url: mainUrl+"follow/Followup/deleteComment",
							data:{commentId:commentId,orderNumber:orderNumber},
							cache:false,
							dataType: 'json',
							success:function(data){
								$('#comments_'+orderNumber).text(data.count);
								$('#comment'+key).remove();
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
		}
</script>