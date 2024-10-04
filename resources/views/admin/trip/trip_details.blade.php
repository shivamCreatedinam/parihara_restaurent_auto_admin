<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>View Trip Details</title>
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
                    @if(Session::has('erorr'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error !</strong> {{ Session::get('erorr') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    @if(Session::has('message'))
                    <div class="col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error !</strong> {{ Session::get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <div class="breadcrumb-wrapper breadcrumb-wrapper-2">
                        <h1>Trip Details</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>Trip Details
                            <span><i class="mdi mdi-chevron-right"></i><a onclick="history.back()"
                                    href="javascript:void(0)">Back</a></span>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="ec-odr-dtl card card-default">
                                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                                    <h2 class="ec-odr">Trip Details<br>
                                        <span class="small">Trip ID: <strong> #{{$data->id}}</strong></span>
                                    </h2>

                                </div>
                                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                                    <h2 class="ec-odr">
                                        <a href="https://www.google.com/maps/dir/?api=1&origin=<?=$data->from_lat?>,%20<?=$data->from_long?>&destination=<?=$data->to_lat?>,%20<?=$data->to_long?>&travelmode=driving"  target="_blank" class="btn " style="font-size:20px;font-weight:bold;">View ON Map</a> 
                                        <span class="small">Trip status: <strong> 
                                        <?php 
                                                        if($data->status == '0'){
                                                            ?>
															<span class="badge badge-info">Trip Created</span>
                                                        <?php
                                                        }
                                                        if($data->status == '1'){
															?>
															<span class="badge badge-success">Accepted By Driver</span>
                                                        <?php
                                                        }
                                                        
                                                        if($data->status == '2'){
															?>
															<span class="badge badge-primary">OTP verified</span>
                                                        <?php
                                                        }
                                                        
                                                        if($data->status == '3'){
															?>
															<span class="badge badge-success">Trip Completed</span>
                                                        <?php
                                                        }
                                                        
                                                        if($data->status == '4'){
															?>
															<span class="badge badge-danger">Trip Canceled</span>
                                                        <?php
                                                        }
                                                    ?>
                                        </strong></span>
                                    </h2>

                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>User Details:</strong></div><br>
                                                <div class="info-content">

                                                    <abbr title="Phone">Name:</abbr> {{$data->username}}<br>
                                                    <abbr title="Phone">Mobile:</abbr> {{$data->usermobile}}<br>

                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Driver Details:</strong></div><br>
                                                <div class="info-content">
                                                    <abbr title="Phone">Name:</abbr> {{$data->dvname}}<br>
                                                    <abbr title="Phone">Mobile:</abbr> {{$data->dvmobile}}<br>

                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong> Amount/Payment Status:</strong></div><br>
                                                <div class="info-content">
                                                    <strong> Fare : </strong>
															
                                                    <span class="badge badge-warning">Rs. {{$data->price}}</span>
                                                    <br>
                                                     <strong> Trip Type : </strong>
															
                                                    <span class="badge badge-success">{{$data->trip_type}}</span>
                                                    <br>
                                                     <abbr title="Phone">Distance:</abbr> {{$data->distance}} km.<br>
                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>From Address:</strong></div><br>
                                                <div class="info-content">
                                                  <abbr title="Phone">Address:</abbr> {{$data->from_address}}<br>
                                                    <abbr title="Phone">City:</abbr> {{$data->from_city}}<br>
                                                    <abbr title="Phone">State:</abbr> {{$data->from_state}}<br>
                                                    <abbr title="Phone">Pincode:</abbr> {{$data->from_pincode}}<br>
                                                </div>
                                            </address>
                                        </div>
									
                                        <div class="col-xl-4 col-lg-6 mt-3">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>To Address:</strong></div><br>
                                                <div class="info-content">
                                                   <abbr title="Phone">Address:</abbr> {{$data->to_address}}<br>
                                                    <abbr title="Phone">City:</abbr> {{$data->to_city}}<br>
                                                    <abbr title="Phone">State:</abbr> {{$data->to_state}}<br>
                                                    <abbr title="Phone">Pincode:</abbr> {{$data->to_pincode}}<br>
                                                </div>
                                            </address>
                                        </div>
                                        
                                       <?php
                                       if($data->status == 4){
                                           ?>
                                        <div class="col-xl-4 col-lg-6 mt-3">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Trip Cancel By :</strong></div><br>
                                                <div class="info-content">
                                                   <abbr title="Phone">By:</abbr> {{$data->cancel_desc}}<br>
                                                    
                                                    <br>
                                                </div>
                                            </address>
                                        </div>   
                                           <?php
                                       }
                                       ?>
                                        
									
                                       
                                    </div>
                                  
                                </div>
                            </div>
                            <!-- Tracking Detail -->
                            
                        </div>
                    </div>
                </div> <!-- End Content -->
            </div> <!-- End Content Wrapper -->

            @include('admin/common/footer')