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
					<div class="breadcrumb-wrapper breadcrumb-wrapper-2">
						<h1>Order Details</h1>
						<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Order Details
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
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
										<span class="small">Order status: <strong> <span class="badge badge-info">{{$data->order_status}}</span></strong></span>
									</h2>
                                    
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-xl-3 col-lg-6">
											<address class="info-grid">
												<div class="info-title"><strong>Customer:</strong></div><br>
												<div class="info-content">
													{{$data->full_name}}<br>
													<!-- 795 Folsom Ave, Suite 600<br>
													San Francisco, CA 94107<br> -->
													<abbr title="Phone">Mobile:</abbr> {{$data->mobile}}<br>
                                                    
												</div>
											</address>
										</div>
										<div class="col-xl-3 col-lg-6">
											<address class="info-grid">
												<div class="info-title"><strong>Shipped To:</strong></div><br>
												<div class="info-content">
													{{$data->house_no}}<br>
													{{$data->appartment}},<br>
													{{$data->city}}, {{$data->state}},{{$data->pincode}}<br>
													
												</div>
											</address>
										</div>
										<div class="col-xl-3 col-lg-6">
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
																if ($data->payment_status == 'Sucess') {
																	?>
																	<span class="badge badge-success">Sucess</span>
																	<?php
																}
															?>
												</div>
											</address>
										</div>
                                        
										<div class="col-xl-3 col-lg-6">
											<address class="info-grid">
												<div class="info-title"><strong>Order Date/Slots:</strong></div><br>
												<div class="info-content">
												<strong>	Date:</strong>{{$data->created_date}},{{$data->created_time}} <br>
                                                <br>
												<strong>	Slot:</strong>{{$data->selected_slot}} <br>
												</div>
											</address>
										</div>
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
															<td class="text-right"><strong>QUANTITY</strong></td>
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
															<td>{{$x}}</td>
															<td><img class="product-img"
																	src="{{asset(product_image($value->id))}}" alt="" /></td>
															<td><strong>{{$value->product_name}}</strong><br>
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
															<td colspan="4"></td>
															<td class="text-right"><strong>Taxes</strong></td>
															<td class="text-right"><strong>N/A</strong></td>
														</tr>
                                                        <tr>
															<td colspan="4">
															</td>
															<td class="text-right"><strong>Delivery Charges</strong></td>
															<td class="text-right"><strong>Rs. {{$data->delvery_charge}}</strong></td>
														</tr>
                                                        <tr>
															<td colspan="4">
															</td>
															<td class="text-right"><strong>Sub Total</strong></td>
															<td class="text-right"><strong>Rs. {{$data->sub_total}}</strong></td>
														</tr>
														<tr>
															<td colspan="4">
															</td>
															<td class="text-right"><strong>Total</strong></td>
															<td class="text-right"><strong>Rs.  {{$data->grand_total}}</strong></td>
														</tr>

														
														
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Tracking Detail -->
							<div class="card mt-4 trk-order">
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
							</div>
						</div>
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

            @include('admin/common/footer')
           