<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>View Order</title>
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
                        <h1>Order Details</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>Order Details
                            <span><i class="mdi mdi-chevron-right"></i><a onclick="history.back()"
                                    href="javascript:void(0)">Back</a></span>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="ec-odr-dtl card card-default">
                                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                                    <h2 class="ec-odr">Order Details<br>
                                        <span class="small">Order ID: <strong> #{{$data->order_number}}</strong></span>
                                    </h2>

                                </div>
                                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                                    <h2 class="ec-odr"><br>
                                        <span class="small">Order status: <strong> <span
                                                    class="badge badge-info">{{$data->order_status}}</span></strong></span>
                                    </h2>

                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Customer:</strong></div><br>
                                                <div class="info-content">

                                                    <abbr title="Phone">Name:</abbr> {{$data->full_name}}<br>

                                                    <!-- 795 Folsom Ave, Suite 600<br>
													San Francisco, CA 94107<br> -->
                                                    <abbr title="Phone">Mobile:</abbr> {{$data->mobile}}<br>

                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Shipped To:</strong></div><br>
                                                <div class="info-content">
                                                    {{$data->house_no}}<br>
                                                    {{$data->appartment}},<br>
                                                    {{$data->city}}, {{$data->state}},{{$data->pincode}}<br>

                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-xl-4 col-lg-6">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Payment:</strong></div><br>
                                                <div class="info-content">
                                                    <strong> Mode : </strong><?php 
																if ($data->payment_mode == 'COD') {
																	?>
                                                    <span class="badge badge-warning">COD</span>
                                                    <?php
																}
																if ($data->payment_mode == 'ONLINE') {
																	?>
                                                    <span class="badge badge-success">ONLINE</span>
                                                    <?php
																}
															?>
                                                    <br>
                                                    <br>
                                                    <strong> Status : </strong><?php 
																if ($data->payment_status == 'Pending') {
																	?>
                                                    <span class="badge badge-warning">Pending</span>
                                                    <?php
																}
																if ($data->payment_status == 'Success') {
																	?>
                                                    <span class="badge badge-success">Success</span>
                                                    <?php
																}
															?>
                                                </div>
                                            </address>
                                        </div>
									
                                        <div class="col-xl-4 col-lg-6 mt-3">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Order Date:</strong></div><br>
                                                <div class="info-content">
                                                    <strong>
                                                        Date:</strong>{{$data->created_date}},{{$data->created_time}}
                                                    <br>
                                                    
                                                </div>
                                            </address>
                                        </div>
										<?php 
									if ($data->order_status == 'Canceled') {
										?>
										<div class="col-xl-4 col-lg-6 mt-3">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Order Canceled Details:</strong></div>
                                                <br>
                                                <div class="info-content">
                                                    <strong>
                                                        Canceled Date:</strong>{{$data->cancel_date}}
                                                    <br>
                                                   
                                                </div>
                                            </address>
                                        </div>
										<?php
									}
									?>
									<?php 
									if ($data->order_status == 'Returned') {
										?>
										 <div class="col-xl-4 col-lg-6 mt-3">
                                            <address class="info-grid">
                                                <div class="info-title"><strong>Order Returned Details:</strong></div>
                                                <br>
                                                <div class="info-content">
                                                    <strong>
                                                        Date:</strong>{{$data->return_date}},{{$data->return_time}}
                                                    <br>
                                                    <br>
                                                    <strong> Reason:</strong>{{$data->return_reason}} <br>
													<strong> Remark:</strong>{{$data->return_remark}} <br>
                                                </div>
                                            </address>
                                        </div>
                                        <?php
									}
									?>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="tbl-title">PRODUCT SUMMARY</h3>
                                            <div class="table-responsive">
                                                <table class="table table-striped o-tbl">
                                                    <thead>
                                                        <tr class="line">
                                                            <td><strong>#</strong></td>
                                                            <td class="text-center"><strong>IMAGE</strong></td>
                                                            <td class="text-center"><strong>PRODUCT</strong></td>
                                                            <td class="text-center"><strong>PRICE/UNIT</strong></td>
                                                            <td class="text-center"><strong>QUANTITY</strong></td>
                                                            <td class="text-right"><strong>SUBTOTAL</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $prod = ordered_product_list($data->order_number); 
                                                        $x = 1;
                                                        foreach ($prod as  $value) {
                                                            ?>
                                                            <tr>
                                                                <td class="text-center">{{$x}}</td>
                                                                <td class="text-center"><img class="product-img"
                                                                        src="{{asset(product_image($value->id))}}" alt="" />
                                                                </td>
                                                                <td class="text-center">
                                                                    <strong>{{$value->product_name}}</strong><br>
                                                                    {{$value->attribute_title}}
                                                                </td>
                                                                <td class="text-center">Rs. {{$value->price}}</td>
                                                                <td class="text-center">{{$value->qty}}</td>
                                                                <td class="text-right">Rs. {{$value->total_price}}</td>
                                                            </tr>
                                                            <?php
                                                    $x++;   
                                                    }
                                                    ?>
                                                        


                                                        <tr>
                                                            <td colspan="4">
                                                            </td>
                                                            <td class="text-right"><strong>Delivery Charges</strong>
                                                            </td>
                                                            <td class="text-right"><strong>Rs.
                                                                    {{$data->delvery_charge}}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                            </td>
                                                            <td class="text-right"><strong>Sub Total</strong></td>
                                                            <td class="text-right"><strong>Rs.
                                                                    {{$data->sub_total}}</strong></td>
                                                        </tr>
														<?php 
														if ($data->applied_coupon_code !='') {
															?>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td class="text-right"><strong>Applied Coupon  Discount</strong></td>
                                                            <td class="text-right"><strong>- Rs. {{$data->discount_amount}}</strong></td>
                                                        </tr>
                                                        <?php
														}
														
														?>
                                                        <tr>
                                                            <td colspan="4">
                                                            </td>
                                                            <td class="text-right"><strong>Grand Total</strong></td>
                                                            <td class="text-right"><strong>Rs.
                                                                    {{$data->grand_total}}</strong></td>
                                                        </tr>



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="#" method="post">
                                                @csrf
                                                <input type="hidden" name="orderid" value="{{$data->id}}" required>
                                                <input type="hidden" name="order_number" value="{{$data->order_number}}"
                                                    required>
                                                <div class="form-group">
                                                    <label>Update Status</label>
                                                    <select name="order_status" class="form-control" id="" readonly required>
                                                        <option value="">Select Status</option>
                                                        <?php 
												$status = order_status();
												foreach ($status as  $value) {
													?>
                                                        <option value="{{$value->order_status}}" <?php 
														if ($value->order_status == $data->order_status) {
															echo 'selected';
														}
													?>>{{$value->order_status}}</option>
                                                        <?php
												}
												?>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Assign Delivery Boy</label>
                                                    <select name="delivery_boy" class="form-control" id="" readonly required>
                                                        <option value="">Select One</option>
                                                        <?php 
											
												foreach ($delivery_boy as  $value) {
													?>
                                                        <option value="{{$value->id}}" <?php 
														if ($value->id == $data->delivery_boy_id) {
															echo 'selected';
														}
													?>>{{$value->unique_id}} - {{$value->name}}</option>
                                                        <?php
												}
												?>
                                                    </select>
                                                </div>
                                                <!--<div class="form-group">-->
                                                <!--    <button class="btn btn-primary">Update</button>-->
                                                <!--</div>-->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tracking Detail -->
                            <!-- <div class="card mt-4 trk-order">
								<div class="p-4 text-center text-white text-lg bg-dark rounded-top">
									<span class="text-uppercase">Tracking Order No - </span>
									<span class="text-medium">34VB5540K83</span>
								</div>
								<div
									class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Shipped
											Via:</span> UPS Ground</div>
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Status:</span>
										Checking Quality</div>
									<div class="w-100 text-center py-1 px-2"><span class="text-medium">Expected
											Date:</span> DEC 09, 2021</div>
								</div>
								<div class="card-body">
									<div
										class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-cart"></i></div>
											</div>
											<h4 class="step-title">Confirmed Order</h4>
										</div>
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-tumblr-reblog"></i></div>
											</div>
											<h4 class="step-title">Processing Order</h4>
										</div>
										<div class="step completed">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-gift"></i></div>
											</div>
											<h4 class="step-title">Product Dispatched</h4>
										</div>
										<div class="step">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-truck-delivery"></i></div>
											</div>
											<h4 class="step-title">On Delivery</h4>
										</div>
										<div class="step">
											<div class="step-icon-wrap">
												<div class="step-icon"><i class="mdi mdi-hail"></i></div>
											</div>
											<h4 class="step-title">Product Delivered</h4>
										</div>
									</div>
								</div>
							</div> -->
                        </div>
                    </div>
                </div> <!-- End Content -->
            </div> <!-- End Content Wrapper -->

            @include('admin/common/footer')