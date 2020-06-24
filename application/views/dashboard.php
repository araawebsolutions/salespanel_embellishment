
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <!--<div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group pull-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="#">Highdmin</a></li>
                                                <li class="breadcrumb-item active">Dashboard</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Dashboard</h4>
                                    </div>
                                </div>
                            </div>-->
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-chart-two widget-chart-one-background">
                    <div class="float-right"><i class="mdi mdi-headset enquiries-icon"></i></div>
                    <div class="widget-chart-two-content">
                        <h3 class="stats-number" id="total_enquiry">0</h3>
                        <p class="text-muted mb-0 mt-2 stats-title">TOTAL ENQUIRIES</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-chart-two widget-chart-two-background">
                    <div class="float-right"><i class="mdi mdi-account enquiries-icon"></i></div>
                    <div class="widget-chart-two-content">
                        <h3 class="stats-number" id="total_follow_up">0</h3>
                        <p class="text-muted mb-0 mt-2 stats-title">TOTAL FOLLOW UPS</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-chart-two widget-chart-three-background">
                    <div class="float-right"><i class="mdi mdi-book-open enquiries-icon"></i></div>
                    <div class="widget-chart-two-content">
                        <h3 class="stats-number"><?= $counts['totalQuotation'] ?></h3>
                        <p class="text-muted mb-0 mt-2 stats-title">TOTAL QUOTATIONS</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-3">
                <div class="card-box widget-chart-two widget-chart-four-background">
                    <div class="float-right"><i class="mdi mdi-cart enquiries-icon"></i></div>
                    <div class="widget-chart-two-content">
                        <h3 class="stats-number" ><?= $counts['totalOrders'] ?></h3>
                        <p class="text-muted mb-0 mt-2 stats-title">TOTAL ORDERS</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">TODAY ORDERS</h6>
                    <h2 class="m-b-20 stats-title-heading"
                        data-plugin="counterup"><?= $counts['todayOrders']['todayOrder'] ?></h2>
                    <input type="hidden" id="totalOrdr" value="<?= $counts['todayOrders']['todayOrder'] ?>">
                    <span class="badge <?php if ($counts['todayOrders']['orderAnalytics']['check'] == 'height') {
                        echo 'badge-custom';
                    } else {
                        echo 'badge-danger';
                    } ?>"> <?php if ($counts['todayOrders']['orderAnalytics']['check'] == 'height') {
                            echo '+ ' . $counts['todayOrders']['orderAnalytics']['percent'];
                        } else {
                            echo '- ' . $counts['todayOrders']['orderAnalytics']['percent'];
                        } ?>% </span> <span class="text-muted">From Yesterday</span></div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="mdi  float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">TODAY SALE</h6>
                    <h2 class="m-b-20 stats-title-heading"><span
                                data-plugin="counterup">£<?= ($counts['todayOrdersPrice']['todayOrdersPrice'] != null) ? $counts['todayOrdersPrice']['todayOrdersPrice'] : 0 ?></span>
                    </h2>
                    <input type="hidden" id="todaysal" value="<?= $counts['todayOrdersPrice']['todayOrdersPrice'] ?>">
                    <span class="badge <?php if ($counts['todayOrdersPrice']['orderAnalyticsPrice']['check'] == 'height') {
                        echo 'badge-custom';
                    } else {
                        echo 'badge-danger';
                    } ?>"> <?php if ($counts['todayOrdersPrice']['orderAnalyticsPrice']['check'] == 'height') {
                            echo '+ ' . $counts['todayOrdersPrice']['orderAnalyticsPrice']['percent'];
                        } else {
                            echo '- ' . $counts['todayOrdersPrice']['orderAnalyticsPrice']['percent'];
                        } ?>% </span> <span class="text-muted">From previous period</span>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-chart float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Average Order Value</h6>
                    <h2 class="m-b-20 stats-title-heading"><span data-plugin="counterup" id="avgord"></span></h2>
                    <span class="badge badge-custom"> 0% </span> <span class="text-muted">From previous period</span>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-rocket float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">PRODUCT SOLD THIS YEAR</h6>
                    <h2 class="m-b-20 stats-title-heading"
                        data-plugin="counterup"><?= $counts['todaySoldProducts']['thisYear'] ?></h2>
                    <span class="badge <?php if ($counts['todaySoldProducts']['lastYearProducts']['check'] == 'height') {
                        echo 'badge-custom';
                    } else {
                        echo 'badge-danger';
                    } ?>"> <?php if ($counts['todaySoldProducts']['lastYearProducts']['check'] == 'height') {
                            echo '+ ' . $counts['todaySoldProducts']['lastYearProducts']['percent'];
                        } else {
                            echo '- ' . $counts['todaySoldProducts']['lastYearProducts']['percent'];
                        } ?>% </span> <span class="text-muted">Last Year</span>

                </div>
            </div>
        </div>
        
         <!-- end row -->
        <div class="row">
            
            
             <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0"><a href="<?=main_url?>dashboard/generate_pdf"> Click To Generate Sheet Pdf</a></h6>
                </div>
            </div>
               <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0"><a href="<?=main_url?>dashboard/generate_pdf_roll"> Click To Generate Roll Pdf</a></h6>
               </div>
            </div>
              <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0"><a href="<?=main_url?>reporting">Reporting - (DPD/Parcelforce)</a></h6>
               </div>
            </div>
             <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0"><a href="<?=main_url?>reporting/datateam">System Reports</a></h6>
               </div>
               
               
             
			
			
			
            </div>
            
            
            
        </div>
        
        
       
            <div class="row">
                
                 <?php

        $UserTypeID = $this->session->userdata('UserTypeID');
        
        if ($UserTypeID == 50) { ?>

                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0"><a href="<?=Assets_path?>pdf/competitor_prices.xlsx" download> Click To Download Competitor Price</a></h6>
                    </div>
                </div>
                <?php } ?>
                
                  <!----Please Copy line 144 to 148 for live  (Zohaib 08/04/2020)------>
			
			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card-box tilebox-one"><i class="icon-layers float-right text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0"><a href="<?=main_url?>product_info">Product Info</a></h6>
               </div>
            </div>
			<!----->
			
			
            </div>

        

        
        
        
        
        
        
        
        <!-- end row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title chart-title">LAST WEEK ORDERS OVERVIEW</h4>

                    <div id="visualization" class="flot-chart mt-5" style="height: 350px;">

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title chart-title">PREVIOUS MONTHS ORDERS OVERVIEW</h4>
                    <div id="combine-chart">
                        <div id="visualization1" class="mt-5" style="height:350px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card-box">
                    <h4 class="header-title mb-4 chart-title">TOP PRODUCTS</h4>
                    <div id="piechart_3d" class="inbox-widget slimscroll" style="max-height: 370px;"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-box">
                    <h4 class="header-title mb-4 chart-title">ORDERS BY COUNTY</h4>
                    <div id="piechart_4d" class="comment-list slimscroll" style="max-height: 370px;"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-box" style="max-height:435px;overflow: auto;">
                    <h4 class="header-title mb-4 chart-title">LAST TRANSACTIONS</h4>
                    <ul class="list-unstyled transaction-list slimscroll mb-0" style="max-height: 370px;">
                        <?php foreach ($counts['lastTransactions'] as $key => $value) { ?>
                            <li>
                                <i class="<?php if (fmod($key, 2)) {
                                    echo 'dripicons-arrow-up text-danger';
                                } else {
                                    echo 'dripicons-arrow-down text-success';
                                } ?>"></i>
                                <span class="tran-text"><a href="<?php echo main_url?>order_quotation/order/getOrderDetail/<?=$value->OrderNumber?>"><?= $value->OrderNumber ?></a></span>
                                <span class="pull-right text-success tran-price"><?= (($value->currency == 'EUR') ? '€' : ($value->currency == 'GBP') ? '£' : '$') . $value->OrderPrice ?></span>
                                <span class="pull-right text-muted"><?= $value->date?></span>
                                <span class="clearfix"></span>
                            </li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!--// charts-->
<script src="<?= ASSETS ?>assets/chart/chart.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    var products = "";

    $(document).ready(function () {

       // chartValue();
        totalEnquiryCount();
        totalFollowUp();




    });

    function chartValue() {
        $("#aa_loader").show();
        $.ajax({
            type: "post",
            url: mainUrl + 'Dashboard/getToProducts',
            cache: false,
            data: {},
            dataType: 'json',
            success: function (data) {
                products = "";
                products = data;
                drawChart();
                drawChart1();
                drawVisualization();
                drawVisualization1();
                $('#aa_loader').hide();
            },
            error: function () {
                swal('please wait Dashboard is Loading Some Resources');
            }
        });
    }

    function totalFollowUp() {
        $.ajax({
            type: "post",
            url: mainUrl + 'Dashboard/getFollowUp',
            cache: false,
            data: {},
            dataType: 'json',
            success: function (data) {
                $('#total_follow_up').text(data);
            },
            error: function () {
                swal('please wait Dashboard is Loading Some Resources');
            }
        });
    }
    function totalEnquiryCount() {
        $.ajax({
            type: "post",
            url: mainUrl + 'Dashboard/getEnquiry',
            cache: false,
            data: {},
            dataType: 'json',
            success: function (data) {
               $('#total_enquiry').text(data);
            },
            error: function () {
                swal('please wait Dashboard is Loading Some Resources');
            }
        });
    }

    function drawChart() {

        var stuff = [];
        $.each(products.products, function (index, record) {
            if (index == 0) {
                stuff.push([record.name, record.count])
            } else {
                stuff.push([record.name, parseInt(record.count, 10)])
            }

        });
        console.log(stuff);
        var data = google.visualization.arrayToDataTable(stuff);

        var options = {
            title: '',
            is3D: true,
            width: 430,
            height: 350,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }

    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart1);

     function drawChart1() {
        var countires = [];

		countires.push(['Country', 'Counts']);
		
        $.each(products.countries, function (index, record) {
                countires.push([record.name, parseInt(record.count, 10)])
        });
		
		
        var data = google.visualization.arrayToDataTable(countires);

        var options = {
            title: '',
            is3D: true,
            width: 430,
            height: 350,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_4d'));
        chart.draw(data, options);
    }

    google.load('visualization', '1.1', {
        'packages': ['corechart']
    });
    google.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        var weekly = [];
        console.log(products.weeklyOrders);
        $.each(products.weeklyOrders, function (index, record) {
            if (index == 0) {

                weekly.push([record.name, record.count]);
            } else {
                weekly.push([record.name.substring(0, 3), parseInt(record.count, 10)])
            }

        });

        var data = google.visualization.arrayToDataTable(weekly);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, 1]);

        // Create and draw the visualization.
        var ac = new google.visualization.ComboChart(document.getElementById('visualization'));
        ac.draw(view, {
            title: 'Weekly Order Overview',
            width: 600,
            height: 350,
            vAxis: {title: "Point Value"},
            hAxis: {title: "Last 7 Days"},
            seriesType: "bars",
            series: {1: {type: "line"}}
        });
    }

    google.load('visualization', '1.1', {
        'packages': ['corechart']
    });
    google.setOnLoadCallback(drawVisualization1);

    function drawVisualization1() {
        var monthly = [];
        console.log(products.weeklyOrders);
        $.each(products.MonthlyOrders, function (index, record) {
            if (index == 0) {

                monthly.push([record.name, record.count]);
            } else {
                monthly.push([record.name.substring(0, 3), parseInt(record.count, 10)])
            }

        });
        var data = google.visualization.arrayToDataTable(monthly);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, 1]);

        // Create and draw the visualization.
        var ac = new google.visualization.ComboChart(document.getElementById('visualization1'));
        ac.draw(view, {
            title: 'Monthly Order OverView',
            width: 600,
            height: 350,
            vAxis: {title: "Point Value (1000)"},
            hAxis: {title: "Last 7 Month"},
            seriesType: "bars",
            series: {1: {type: "line"}}
        });
    }
</script>
