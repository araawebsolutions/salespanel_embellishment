<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <title>AA Back Office | Plain and Printed Labels to Buy Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://www.aalabels.com/theme/site/images/favicon.png"/>
    <!-- Main css -->
    <link href="<?= ASSETS ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ASSETS ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="<?= ASSETS ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="<?= ASSETS ?>assets/js/jquery.min.js"></script>
    <script src="<?=ASSETS?>assets/js/bootstrap.min.js"></script>
	    <script src="<?= ASSETS ?>assets/js/sweet-alert.js"></script>


</head>
<script>
    var mainUrl = "<?php echo main_url?>";
    var symbel = "<?php echo symbol?>";
</script>
<body class="login-background">
<?php
$ipAddress = $this->input->ip_address();

?>
<div class="wrapper-page" style="position: absolute;top: 25%;bottom: 0;left: 0%;right: 0%;">

    <div class="col-md-5" style="margin: 0px auto;">
        <h2 class="text-uppercase text-center">
            <a href="<?=main_url?>" class="text-success">
                <span><img src="<?= ASSETS ?>assets/images/login-logo.png" alt=""></span>
            </a>
        </h2>
    </div>
    <div class="row">
        <div class="card col-md-4" style="margin: 0px auto;">

            <div class="card-block">


                <div class="card-box">
                    <h2 class="text-center"
                        style="text-align: center;color: #006ca5;font-size: 18px;margin-bottom: 20px;">
                        <b style="font-size: 18px;">LOGIN</b> YOUR ACCOUNT
                    </h2>


                    <form class="labels-form" action="<?=main_url?>Auth/AuthenticateUser" method="post" id="login-form">
                        <input type="hidden" value="<?=$verified?>" name="verified"  />
                        <input type="hidden" value="Login" name="login"  />
                        <div class="form-group m-b-20 row">
                            <div class="col-8" style="margin: 0px auto;">

                                <label class="input"> <i class="icon-append fa fa-phone"></i>
                                    <input style="font-size: 11px;" type="text" placeholder="Enter Username"
                                           name="username" value="" required class="required" id="username">
                                    <b class="tooltip tooltip-bottom-right">Please Enter User Name</b> </label>
                            </div>
                        </div>

                        <div class="form-group row m-b-20">
                            <div class="col-8" style="margin: 0px auto;">
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input style="font-size: 11px;" type="password" placeholder="Enter Password"
                                           name="password" value="" required class="required" id="password">
                                    <b class="tooltip tooltip-bottom-right">Please Enter Password</b> </label>
                                    <?  $error_msg = $this->session->flashdata('error_msg');
                                        echo '<span style="padding-left:10%;color: red;">'.$error_msg.'</span>';
                                    ?>        
                            </div>
                        </div>

                            <div id="dis_tkn_box" class="form-group row m-b-20" style="display:none">
                                <div class="col-8" style="margin: 0px auto;">
                                    <label class="input"> <i class="icon-append fas fa-shield"></i>
                                        <input style="font-size: 11px;" type="text" placeholder="Enter Secret Token"
                                               name="token" value="" class="required">
                                        <b class="tooltip tooltip-bottom-right">Please Enter Secure Token</b> </label>
                                </div>
                            </div>
      			
				<? $ip_address = $_SERVER['REMOTE_ADDR']; ?>

                <div class="form-group row text-center m-t-10">
                    <div class="col-12">
                        <span class="m-t-t-10">
                            <? if($verified =='yes'){ ?>
                            <button  type="submit" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save" value="Login">LOGIN</button>
                            <?php }else if($ip_address == PKOFFICE){?>
                            <button type="button" onclick="chk_login_token();" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 " id="pksecuty">VERIFY & SEND SECRET TOKEN</button>
                            <button id="lg_me_in" type="submit" style="display:none" value="Login" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save">LOGIN</button>

                            <?php }else{?>
                            
      <button id="genrt_tkn" type="button" onclick="generateToken()" aria-label="Close" data-dismiss="modal" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">GENERATE SECRET TOKEN</button>
	   <button id="lg_me_in" type="submit" style="display:none" value="Login" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1 save">LOGIN</button>
                            
                            <? } ?>
                        </span>
                    </div>
                </div>

									</form>

									
							</div>


					</div>

        </div>
    </div>
</div>
<div class="m-t-40 text-center">
    <p class="account-copyright">Copyright © <?=date('Y')?> . AA Labels.com</p>
</div>


<!-- Secure Token Generate Popup Start -->
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" id="generate_token" style="position:fixed; left: 50%; top: 53%; -ms-transform: translate(-50%,-50%); -moz-transform:translate(-50%,-50%); -webkit-transform: translate(-50%,-50%);  transform: translate(-50%,-50%); ">
    <div class="modal-dialog modal-md">
        <div class="modal-content blue-background">
            <div class="modal-header checklist-header">
                <div class="col-md-12">
                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Please Enter  Email here</h4>
                    <p class="timeline-detail text-center"></p>
                </div>
            </div>
            <div class="modal-body p-t-0">
                <div class="panel-body">


                    <style>
                        .custom-die-input {
                            width: 97%;
                            border: 1px solid #a3e8ff;
                            border-radius: 4px;
                            height: 33px;
                            color: #666666;
                            margin-bottom: 4px;
                            padding-left: 6px;
                        }

                        .blue-text-field {
                            border: 1px solid #a3e8ff !important;
                            width: 97%;
                        }

                        .m-r-3 {
                            margin-right: 3%;
                        }
                    </style>


                    <div class="col-12 no-padding">


                        <div class="divstyle" style="margin-bottom:5px;"><b class="label"></b>
						<input type="email" placeholder="Enter Email Here" class="cust_die custom-die-input" data-id="width" data-cart-id="" value="" id="gt_tok_email">
                       </div>


                    </div>


                    <span class="m-t-t-10 pull-right m-r-3">
                        <button type="button" onclick="sendEmailForToken()" class="btn btn-outline-dark waves-light waves-effect btn-countinue btn-print1">SEND EMAIL</button></span>


                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Secure Token Generate Popup Start End -->


</body>
</html>
<script>
 	
		
		function chk_login_token(){
			var username = $('#username').val();
			var password = $('#password').val();
			$.ajax({
			type: "post",
			url: mainUrl + 'Auth/chk_login_secretkey',
			cache: false,
			data: {username:username,password:password},
			dataType: 'html',
			success: function (data){
				if(data == 'error'){
				   swal("Alright!", "invalid login details", "warning");  
				 }else{
					swal('Success',"Secret token has been sent to your email address.",'success');
					$('#pksecuty').hide();
					$('#lg_me_in').show();
					$('#dis_tkn_box').show();
				 }
			},
			error: function () {
				swal('Error', 'Error while request..', 'error');
			}
		});
	 }
	 

   
	function generateToken() {
		/*  $.ajax({
		type: "post",
		url: mainUrl + 'order_quotation/quotation/updateDetailPrice',
		cache: false,
		data: {},
		dataType: 'json',
		success: function (data) {
		window.location.reload();
		},
		error: function () {
		alert('Error while request..');
		}
		});*/
		$('#generate_token').modal('show');
	}

	function sendEmailForToken() {
		$.ajax({
			type: "post",
			url: mainUrl + 'Auth/sendEmailForToken',
			cache: false,
			data: { 
				email:$('#gt_tok_email').val(),
				source: 'saleoperator'
			},
			//dataType: 'html',
			success: function (data) {
				//alert(data);
				if(data == 'true'){
					swal('Success',"Secret token has been sent to your email address.",'success');
					$('#generate_token').modal('hide');
					$('#genrt_tkn').hide();
					$('#lg_me_in').show();
					$('#dis_tkn_box').show();
					
				}else{
					swal("warning!","given email address in not authenticated","warning");
				}
			},
			error: function () {
					swal('Error', 'Error while request..', 'error');
			}
		});
	}
</script>
