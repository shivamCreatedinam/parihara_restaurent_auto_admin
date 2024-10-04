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
                                    <h2 class="mb-1">Rs. <?php 
										if (isset($totalearntrip)) {
											echo $totalearntrip;
										}
									?></h2>
                                    <p>Total Earning</p>
                                    <span class="mdi mdi-dns-outline bg-dark"></span>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card card-mini dash-card card-3">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($totaltrip)) {
											echo $totaltrip;
										}
									?></h2>
                                    <p>Total Trip</p>
                                    <span class="mdi mdi-dns-outline bg-dark"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card  card-mini dash-card card-1">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($completetrip)) {
											echo $completetrip;
										}
									?></h2>
                                    <p>Total Complete Trip</p>
                                    <span class="mdi mdi-dns-outline bg-success"></span>
                                </div>
                            </div>
                        </div>
                       <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card  card-mini dash-card card-1">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($recentcreatedtrip)) {
											echo $recentcreatedtrip;
										}
									?></h2>
                                    <p>Recent Created Trip</p>
                                    <span class="mdi mdi-dns-outline bg-info"></span>
                                </div>
                            </div>
                        </div>
                       <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card  card-mini dash-card card-1">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($runningtrip)) {
											echo $runningtrip;
										}
									?></h2>
                                    <p>Total Running Trip</p>
                                    <span class="mdi mdi-dns-outline bg-success"></span>
                                </div>
                            </div>
                        </div>
                       <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card  card-mini dash-card card-1">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($usercanceltrip)) {
											echo $usercanceltrip;
										}
									?></h2>
                                    <p>Total Cancel Trip By User</p>
                                    <span class="mdi mdi-dns-outline bg-info"></span>
                                </div>
                            </div>
                        </div>
                       <div class="col-xl-4 col-sm-6 p-b-15 lbl-card">
                            <div class="card  card-mini dash-card card-1">
                                <div class="card-body">
                                    <h2 class="mb-1"><?php 
										if (isset($drivercanceltrip)) {
											echo $drivercanceltrip;
										}
									?></h2>
                                    <p>Total Cancel Trip By Driver</p>
                                    <span class="mdi mdi-dns-outline bg-dark"></span>
                                </div>
                            </div>
                        </div>
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