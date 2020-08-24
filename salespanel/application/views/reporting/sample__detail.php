


<div class="wrapper">
  <div class="container-fluid">
  
  <div class="row">
      <div class="col-md-12">
        <div class="card-box tab-nav-padding">
          <ul class="nav nav-pills navtab-bg nav-justified pull-in tab-nav-container" id="main_nav">
            <li class="nav-item tab-li-adjst">
             <a href="<?php echo main_url?>Reporting/sample_detail/<?php echo $user_id; ?>" class="nav-link  active show"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Customer Info</a> 
            </li>
            <li class="nav-item tab-li-adjst disbaledd">
             <a href="<?php echo main_url?>Reporting/sample_against_user/<?php echo $user_id; ?>" class="nav-link"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Sample Details</a> 
            </li>
            <li class="nav-item tab-li-adjst disbaledd">
             <a href="<?php echo main_url?>Reporting/order_against_user/<?php echo $user_id; ?>" class="nav-link"> 
             <i class="tab-li-text-adjst fi-bag mr-2"></i>Order Details</a> 
            </li>
           </ul>
          
          <div id="customer" class="tab-content m-t-14">
            <div class="tab-pane show active" id="home1">

              <table id="responsive-datatable"  class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                <thead class="text-left">
                <tr>
                <th style="font-weight: bold;">First Name</th>
                <th style="font-weight: bold;">Last Name</th>
                <th style="font-weight: bold;">Email</th>
                <th style="font-weight: bold;">Phone</th>
                <th style="font-weight: bold;">Fax</th>
                <th style="font-weight: bold;">Company</th>
                <th style="font-weight: bold;">Address</th>
                </tr>
                </thead>
                
                <tbody>
                <tr>
                <td><?php echo $user_detail->BillingFirstName ?></td>
                <td><?php echo $user_detail->BillingLastName ?></td>
                <td><?php echo $user_detail->UserEmail ?></td>
                <td><?php echo $user_detail->BillingMobile ?></td>
                <td><?php echo $user_detail->BillingFax ?></td>
                <td><?php echo $user_detail->BillingCompanyName ?></td>
                <td><?php echo $user_detail->BillingAddress1 ?></td>
                </tr>
                </tbody>
                
                
              </table>
            </div>
          </div>
         
        </div>
      </div>
    </div>