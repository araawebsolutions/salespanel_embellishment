<script src="https://cdn.worldpay.com/v1/worldpay.js"></script>
<style>
    .dataTables_length {
        float: left !important;
    }

    .disbaledd {
        opacity: 0.6;
    }

    .disbaledd a {
        cursor: no-drop;
    }

    .activated {
        opacity: 2;
    }

    .activated a {
        cursor: pointer;
    }

.toolbar {
  float: right;
  margin-left: 1%;
  margin-top: -3px;
  display: inline-flex;
}
</style>


<div class="wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card-box tab-nav-padding">
          <ul class="nav nav-pills navtab-bg nav-justified pull-in tab-nav-container" id="main_nav">
            <li class="nav-item tab-li-adjst"> <a href="#home1" id="customer_link" onclick="getCustomer()" data-toggle="tab" aria-expanded="false"
                               class="nav-link  active show"> <i class="tab-li-text-adjst fi-bag mr-2"></i>Customer </a> </li>
            <li class="nav-item tab-li-adjst disbaledd" id="format"> <a href="#" id="first_format_link"
                               data-toggle="tab" aria-expanded="true" class="nav-link" data-open="close"> <i class="tab-li-text-adjst fi-columns mr-2"></i>Format Shapes & Sizes </a> </li>
            <li class="nav-item tab-li-adjst disbaledd " id="material_tab"> <a href="javascript:void(0);" id="material_tab_link"  data-toggle="tab" aria-expanded="false" class="nav-link"> <i class="tab-li-text-adjst fi-printer mr-2"></i>Material </a> </li>
            <li class="nav-item tab-li-adjst disbaledd" id="od_qt_tab"> <a href="javascript:void(0);" id="od_qt_link" data-toggle="tab"   aria-expanded="false" class="nav-link"> <i class="tab-li-text-adjst fi-clipboard mr-2"></i>Quote / Order </a> </li>
            <li class="nav-item tab-li-adjst disbaledd" id="dl_pm_tab"> <a href="#settings1" data-toggle="tab" id="dl_pm_link"  aria-expanded="false" class="nav-link"> <i class="tab-li-text-adjst fi-box mr-2"></i>Delivery Payment </a> </li>
            <li class="nav-item tab-li-adjst-last disbaledd" id="ord_qu_Crf_tab"> <a href="#settings1" data-toggle="tab" id="ord_qu_Crf_link" aria-expanded="false" class="nav-link"> <i class="tab-li-text-adjst fi-briefcase mr-2"></i>Order / Quote Confirmation </a> </li>
          </ul>
          
          <div class="view-basket-margin basketPrice" style="display: none; text-align: right" > 
           <a href="#" ><i class="mdi mdi-basket" id="basketPrice" onclick="checkout()"></i></a>
          </div>

            <input type="hidden" id="format_back" value="<?php echo $data['format'] ?>">
          
          <div id="customer" class="tab-content m-t-14">
            <div class="tab-pane show active" id="home1">

              <table id="responsive-datatable"
                                   class="table table-bordered table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">

                <thead class="text-left">
                <tr>
                <th>Customer Name</th>
                    <th>Company</th>
                <th>Country</th>
                <th>Billing Postcode</th>
                <th>Delivery Postcode</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Customer Type</th>    
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div id="customer_orders"></div>
          <div id="format_page"></div>
          <div id="material_page"></div>
          <div id="products_list"></div>
          <div id="complete_payment_for"></div>
          <div id="confirm_my_order"></div>
          <div id="confirm_my_quotation"></div>
        </div>
      </div>
    </div>
    <!-- end row --> 
    <!-- Products View Start  -->
    <div id="ajax_material_sorting" class="ajax_material_sorting"></div>
    <!-- Products View End  --> 
    
  </div>
  <!-- end container -->
  <? include('artwork/artwork_popup.php') ?>
  
  <!-- Compare Popup Start -->
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" id="compare_modal" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content blue-background">
        <div class="modal-header checklist-header">
          <div class="col-md-12">
            <h4 class="modal-title checklist-title" id="myLargeModalLabel">Compare Products</h4>
          </div>
        </div>
        <div class="modal-body p-t-0">
          <div class="panel-body">
            <div id="compare_modal_content"> </div>
          </div>
        </div>
      </div>
      <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
  </div>
  <!-- Compare Popup End --> 
  
</div>
<div class="modal fade" id="exampleModal1" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

     aria-hidden="true">

    

</div>
   
	  <script type="text/javascript">

$(document).ready(function () {
    //alert(<?php //echo $format; ?>//);
    <?  $ses_customer = $this->session->userdata('userid');
    $carttotal = $this->cartModal->getCartOrders();

    $cut = $this->session->userdata('cut_data');


    if(/*$format == 1*/ isset($ses_customer) && $ses_customer!="" && count($carttotal)==0){ ?>
        getFormat();
        $('#format').removeClass('disbaledd');
        $('#od_qt_tab').removeClass('disbaledd');
        $('#first_format_link').attr('onclick','getFormat()');
        $('#od_qt_link').attr('onclick','showcartPage()');

    <?php } else if(isset($ses_customer) && $ses_customer!="" && count($carttotal)>0){?>

        showcartPage();
        $('#format').removeClass('disbaledd');
        $('#od_qt_tab').removeClass('disbaledd');
        $('#first_format_link').attr('onclick','getFormat()');
        $('#od_qt_link').attr('onclick','showcartPage()');

    <?php } else if($cut=='cust'){?>
        showcartPage();
        $('#format').removeClass('disbaledd');
        $('#od_qt_tab').removeClass('disbaledd');
        $('#first_format_link').attr('onclick','getFormat()');
        $('#od_qt_link').attr('onclick','showcartPage()');

    <? }else{ ?>
        opencustomerdatable();
    <? } ?>
 
 });
    </script>
    

 
<script type="text/javascript">
  
  
  $('#od_qt_link').click(function(){

         <?php if(isset($ses_customer) && $ses_customer!="" && count($carttotal)>0){ ?>
                window.location='https://www.aalabels.com/salespanel/index.php/orderQuotationPage';
          <?php } else{?>
      checkout();
          <?php } ?>
  });

 function opencustomerdatable(){
     $('#responsive-datatable').DataTable({
            "sDom": 'l<"toolbar">frtip',
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "bJQueryUI": false,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "iDisplayLength": 10,
            "aaSorting": [[0, 'desc']],
            'sAjaxSource': '<?php echo main_url?>order_quotation/order/getAllCustomers',

            "aoColumns": [
                {
                    "render": function (data, type, row) {
                         if(row[7]==1){
                           return '<a href="javascript:void(0);" onclick="getCustomerOrders(' + row[8] + ')"><b>' + row[0]  + '</b></a>';
                         }else{
                           return '<a href="javascript:void(0);"><b style="color:#cecece">' + row[0]  + '</b></a>';  
                         }  
                    }
                },
               {
                    "render": function (data, type, row) {
                        return  row[1];
                    }
                },
               {
                    "render": function (data, type, row) {
                        return  row[2];
                    }
                },
                {
                    "render": function (data, type, row) {
                        return  row[3];
                    }
                },
                {
                    "render": function (data, type, row) {
                        return  row[4];
                    }
                },
               {
                    "render": function (data, type, row) {
                        return  row[5];
                    }
                },
                {
                    "render": function (data, type, row) {
                        return  row[6];
                    }
                },
                {
                    "render": function (data, type, row) {
                        if(row[7]==1){
						  var datashow = "Active Customer";
						  datashow = datashow +'<br><a href="javascript:void(0);" onclick="changecustomerstate(' + row[8] + ',0)"><b style="text-decoration:underline">De-activate</b></a>';
						}else{
						  var datashow = "In-Active Customer";
						  datashow = datashow +'<br><a href="javascript:void(0);" onclick="changecustomerstate(' + row[8] + ',1)"><b style="text-decoration:underline">Activate</b></a>';
						}
						
						return datashow;
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
               	  $('div.toolbar').html('<button type="button" class="btn btn-primary waves-light waves-effect add_customer_button" onclick="add_customer();"style="background: #00b6f0;color: #fff !important;border: none;height: 30px;padding-top: 4px;margin-top: 3px;">Add New Customer</button>'); 
            },


        });
  
  
  }


</script>






<script>


    /*$(document).ready(function () {

        var price = 0;

        $.ajax({
            type: "get",
            url: mainUrl + "cart/cart/getCartPrice",
            cache: false,
            data: {},
            dataType:'json',
            success: function (data){
                if(data.price[0].price == null){
                    price = 0;
                }else{
                    price = data.price[0].price
                }

                //$('#basketPrice').text('View Basket - £ '+price);
                	update_topbasket();
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 500) {
                    alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
                } else {
                    alert('Error While Requesting...');
                }
            }
        });
    })*/
  
  function changecustomerstate(userid,state){
	    var isConfirm = confirm('Are you sure you want to update?');
        if (isConfirm){
			 $.ajax({
				type: "post",
				url: mainUrl + "customer/customer/changecustomerstate",
				cache: false,
				data: {userid:userid,state:state},
				dataType: 'html',
				success: function (data) {
				   swal('','Customer Record Updated','success');	
				   opencustomerdatable(); 
				 },
				error: function (jqXHR, exception) {
				   alert('Error While Requesting...');
				}
			});
	   }
  }







  $(document).ready(function(){


      /*$.ajax({
          type: "post",
          url: mainUrl +"order_quotation/order/chk_customer_session",
          data: {},
          dataType: 'html',
          success: function (data) {
              data = $.parseJSON(data)

              if(data.customer_id){
                  getFormat();
              }
              /!*$('#aa_loader').hide();
              showAndHideTabs('products_list');


              $('#format').removeClass('disbaledd');
              $('#first_format_link').attr('onclick',"getFormat()");
              activeTab('first_format_link');
              $('.ajax_material_sorting').hide();*!/

          },
          error: function (jqXHR, exception) {
              if (jqXHR.status === 500) {
                  alert('No Invoice..');
              } else {
                  alert('Error While Requesting...');
              }
          }
      });*/


      //getFormat();
      /*
      var format = $('#format_back').val();

      if(format && format == 1){
          getFormat();
      }*/


      //getFormat();
      /*showAndHideTabs('products_list');
      $('#material_tab').removeClass('disbaledd');
      $('#material_tab_link').attr('onclick',"showcartPage()");
      activeTab('material_tab_link');
      $('.ajax_material_sorting').hide();*/

      /*function back_to_material_and_qty(){
          $('#aa_loader').show();




          $.ajax({
              type: "post",
              url: mainUrl +"order_quotation/order/index",
              data: {},
              dataType: 'html',
              success: function (data) {
                  alert('k');
                  $('#aa_loader').hide();
                  showAndHideTabs('products_list');


                  $('#format').removeClass('disbaledd');
                  $('#first_format_link').attr('onclick',"getFormat()");
                  activeTab('first_format_link');
                  $('.ajax_material_sorting').hide();

              },
              error: function (jqXHR, exception) {
                  if (jqXHR.status === 500) {
                      alert('No Invoice..');
                  } else {
                      alert('Error While Requesting...');
                  }
              }
          });
      }*/
  });
  
</script>