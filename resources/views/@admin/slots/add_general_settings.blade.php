<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>General Setting</title>
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
                    @if(Session::has('message'))
                    <div class="col-sm-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Success !</strong> {{ Session::get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                        <h1>General Setting</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>General Setting
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="ec-cat-list card card-default mb-24px">
                                <div class="card-body">
                                    <div class="ec-cat-form">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                <h5>Cancel Order Permission</h5>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{route('update.order_status')}}" method="post">
                                                    <div class="row">
                                                        @csrf
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="order_placed"
                                                                    id="order_placed" value="yes" <?php 
																if ($order_status->order_placed == 'yes') {
																	echo 'checked';
																}
																?>> &nbsp;&nbsp; Placed
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="order_confirmed"
                                                                    id="order_confirmed" value="yes" <?php 
																if ($order_status->order_confirmed == 'yes') {
																	echo 'checked';
																}
																?>> &nbsp;&nbsp; Confirmed
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="processing" id="processing"
                                                                    value="yes" <?php 
																if ($order_status->processing == 'yes') {
																	echo 'checked';
																}
																?>> &nbsp;&nbsp; Processing
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="dispatched" id="dispatched"
                                                                    value="yes" <?php 
																if ($order_status->dispatched == 'yes') {
																	echo 'checked';
																}
																?>> &nbsp;&nbsp; Dispatched
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="delivered" id="delivered"
                                                                    value="yes" <?php 
																if ($order_status->delivered == 'yes') {
																	echo 'checked';
																}
																?>> &nbsp;&nbsp; Delivered
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button name="submit" type="submit"
                                                                    class="btn btn-success "
                                                                    style="margin-top: -10px;">Submit</button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>


                                        </div>
                                    </div>



                                    <div class="card mt-4">
                                        <div class="card-header bg-primary text-white">
                                            <h5>Common Settings</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{route('update.general_status')}}" method="post">
                                                <div class="row">
                                                    @csrf
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<label>Return products in days</label>
                                                            <input type="number" name="return_product_in_days" id="return_product_in_days"
                                                                value="{{$general->return_product_in_days}}" class="Enter Days"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
															<label>Minimum Order Value</label>
                                                            <input type="number" name="minimum_order_value" id="minimum_order_value"
                                                                value="{{$general->minimum_order_value}}" class="Enter Value Ex. 400"> 
                                                        </div>
                                                    </div>
													<div class="col-md-3">
                                                        <div class="form-group">
															<label>Estimated Delivery Km.</label>
                                                            <input type="number" name="esti_deli_in_kms" id="esti_deli_in_kms"
                                                                value="{{$general->esti_deli_in_kms}}" class="Enter value"> 
                                                        </div>
                                                    </div>
													<div class="col-md-3">
                                                        <div class="form-group">
															<label>Estimated Delivery Days</label>
                                                            <input type="number" name="esti_days" id="esti_days"
                                                                value="{{$general->esti_days}}" class="Enter value"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <button name="submit" type="submit" class="btn btn-warning "
                                                                style="margin-top: -10px;">Submit</button>
                                                        </div>
                                                    </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                              
                           
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- End Content -->
    </div> <!-- End Content Wrapper -->
    @include('admin/common/footer')
    <script type="text/javascript">
    function get_city(value) {
        if (value != '') {
            $.ajax({
                url: "{{url('sysadmin/get_city')}}",
                type: "POST",
                data: {
                    "_token": "{{csrf_token()}}",
                    stateid: value,
                },
                success: function(res) {
                    $('#showcity').html(res);
                }
            });
        }
    };
    </script>