<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">

    <title>Dashboard</title>

    <!-- GOOGLE FONTS -->
    @include('admin/common/head')

</head>

<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">

    <!--  WRAPPER  -->
    <div class="wrapper">

        <!-- LEFT MAIN SIDEBAR -->
        @include('admin/common/sidebar')

        <!--  PAGE WRAPPER -->
        <div class="ec-page-wrapper">

            <!-- Header -->
            @include('admin/common/header')

            <!-- CONTENT WRAPPER -->
            <div class="ec-content-wrapper">
                <div class="content">
                    <!-- Top Statistics -->
                    <div class="row">
                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card  card-mini dash-card card-1">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($users)) {
											echo $users;
										}
									?></h2>
                                    <p>Total Users</p>
                                    <span class="mdi mdi-account-arrow-left bg-success"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($total_order)) {
											echo $total_order;
										}
									?></h2>
                                    <p>Total Order</p>
                                    <span class="mdi mdi-package-variant bg-warning"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($complete_order)) {
											echo $complete_order;
										}
									?></h2>
                                    <p>Total Orders (Completed)</p>
                                    <span class="mdi mdi-package-variant"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($processing_order)) {
											echo $processing_order;
										}
									?></h2>
                                    <p>Total Orders (In processing)</p>
                                    <span class="mdi mdi-package-variant bg-info "></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1">
                                        <?php 
										if (isset($return_order)) {
											echo $return_order;
										}
										?>
                                    </h2>
                                    <p>Total Orders (Returned)</p>
                                    <span class="mdi mdi-package-variant bg-danger"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($categories)) {
											echo $categories;
										}
									?></h2>
                                    <p>Total Categories</p>
                                    <span class="mdi mdi-dns-outline bg-dark"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($stock_product)) {
											echo $stock_product;
										}
									?></h2>
                                    <p>Total Products (In Stock)</p>
                                    <span class="mdi mdi-dropbox bg-success"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($out_of_stock_product)) {
											echo $out_of_stock_product;
										}
									?></h2>
                                    <p>Total Products (Out of Stock)</p>
                                    <span class="mdi mdi-dropbox bg-danger"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($earning_order)) {
											echo $earning_order;
										}
									?></h2>
                                    <p>Total Earning</p>
                                    <span class="mdi mdi-currency-inr bg-danger"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                  



                    <div class="row">
                        <div class="col-12 p-b-15">
                            <!-- Recent Order Table -->
                            <div class="card card-table-border-none card-default recent-orders" id="">
                                <div class="card-header justify-content-between">
                                    <h2>Recent Orders</h2>
                                    <div class="date-range-report">
                                        <span></span>
                                    </div>
                                </div>
                                <div class="card-body pt-0 pb-5">
                                    <table class="table card-table table-responsive table-responsive-large"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Order ID</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Address</th>
                                                <th class="d-none d-lg-table-cell">Date</th>
                                                <th class="d-none d-lg-table-cell">Amount</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
											$x= 1;
											foreach ($recent_order as $value) {
												?>
                                            <tr>
                                                <td>{{$x}}</td>
                                                <td><strong>#{{$value->order_number}}</strong></td>
                                                <td>{{$value->full_name}}</td>
                                                <td>{{$value->mobile}}</td>
                                                <td>{{$value->house_no}}</td>

                                                <td class="d-none d-lg-table-cell">
                                                    {{$value->created_date}},{{$value->created_time}}</td>

                                                <td class="d-none d-lg-table-cell">Rs. {{$value->grand_total}}</td>
                                                <td>
                                                    <span class="badge badge-success">{{$value->order_status}}</span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="dropdown show d-inline-block widget-dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#"
                                                            role="button" id="dropdown-recent-order1"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" data-display="static"></a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li class="dropdown-item">
                                                                <a href="#">View</a>
                                                            </li>
                                                            <!-- <li class="dropdown-item">
																<a href="#">Remove</a>
															</li> -->
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
												$x++;
											}
											?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-5">
                            <!-- New Customers -->
                            <div class="card ec-cust-card card-table-border-none card-default">
                                <div class="card-header justify-content-between ">
                                    <h2>New Customers</h2>
                                    <div>
                                        <button class="text-black-50 mr-2 font-size-20">
                                            <i class="mdi mdi-cached"></i>
                                        </button>
                                        <div class="dropdown show d-inline-block widget-dropdown">
                                            <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                                id="dropdown-customar" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" data-display="static">
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="dropdown-item"><a href="#">Action</a></li>
                                                <li class="dropdown-item"><a href="#">Another action</a></li>
                                                <li class="dropdown-item"><a href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0 pb-15px">
                                    <table class="table ">
                                        <tbody>
                                            <?php 
											foreach ($recent_users as  $uvalue) {
												?>
                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <div class="media-image mr-3 rounded-circle">
                                                            <a href="#"><img class="profile-img rounded-circle w-45"
                                                                    src="{{asset('uploads/user_image/user.png')}}"
                                                                    alt="customer image"></a>
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <a href="#">
                                                                <h6 class="mt-0 text-dark font-weight-medium">
                                                                    {{$uvalue->name}}</h6>
                                                            </a>
                                                            <small>{{$uvalue->email}}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{$uvalue->mobile}}</td>
                                                <!-- <td class="text-dark d-none d-md-block">Rs. {{$uvalue->grand_total}}</td> -->
                                            </tr>
                                            <?php
											}
											?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-7">
                            <!-- Top Products -->
                            <div class="card card-default ec-card-top-prod">
                                <div class="card-header justify-content-between">
                                    <h2>Top 5 Selling Products</h2>
                                    <div>
                                        <button class="text-black-50 mr-2 font-size-20"><i
                                                class="mdi mdi-cached"></i></button>
                                        <div class="dropdown show d-inline-block widget-dropdown">
                                            <a class="dropdown-toggle icon-burger-mini" href="#" role="button"
                                                id="dropdown-product" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" data-display="static">
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body mt-10px mb-10px py-0">
                                    <?php 
									foreach ($best_order as $key => $value) {
										?>
                                    <div class="row media d-flex pt-15px pb-15px">
                                        <div class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
                                            <a href="#"><img src="{{asset(product_image($value->id))}}"
                                                    alt="customer image" style="width: 50%;"></a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
                                            <a href="#">
                                                <h6 class="mb-10px text-dark font-weight-medium">
                                                    {{$value->product_name}}</h6>
                                            </a>
                                            <!-- <p class="float-md-right sale"><span class="mr-2">58</span>Sales</p> -->
                                            <p class="d-none d-md-block">{{$value->attribute_title}}</p>
                                            <p class="mb-0 ec-price">
                                                <span class="text-dark">Rs. {{$value->sale_price}}</span>
                                                <del>Rs. {{$value->market_price}}</del>
                                            </p>
                                        </div>
                                    </div>
                                    <?php

									}
									?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Content -->
            </div> <!-- End Content Wrapper -->

            @include('admin/common/footer')

            <script>
            $(document).ready(function() {

                "use strict";
                /*======== 11. DOUGHNUT CHART ========*/
                var doughnut = document.getElementById("doChart");
                if (doughnut !== null) {
                    var myDoughnutChart = new Chart(doughnut, {
                        type: "doughnut",
                        data: {
                            labels: ["completed", "unpaid", "pending", "canceled", "returned",
                                "Broken"],
                            datasets: [{
                                label: ["completed", "unpaid", "pending", "canceled",
                                    "returned", "Broken"
                                ],
                                data: [4100, 2500, 1800, 2300, 400, 150],
                                backgroundColor: ["#88aaf3", "#50d7ab", "#9586cd", "#f3d676",
                                    "#ed9090", "#a4d9e5"
                                ],
                                borderWidth: 1
                                // borderColor: ['#88aaf3','#29cc97','#8061ef','#fec402']
                                // hoverBorderColor: ['#88aaf3', '#29cc97', '#8061ef', '#fec402']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false
                            },
                            cutoutPercentage: 75,
                            tooltips: {
                                callbacks: {
                                    title: function(tooltipItem, data) {
                                        return "Order : " + data["labels"][tooltipItem[0]["index"]];
                                    },
                                    label: function(tooltipItem, data) {
                                        return data["datasets"][0]["data"][tooltipItem["index"]];
                                    }
                                },
                                titleFontColor: "#888",
                                bodyFontColor: "#555",
                                titleFontSize: 12,
                                bodyFontSize: 14,
                                backgroundColor: "rgba(256,256,256,0.95)",
                                displayColors: true,
                                borderColor: "rgba(220, 220, 220, 0.9)",
                                borderWidth: 2
                            }
                        }
                    });
                }
            });
            </script>