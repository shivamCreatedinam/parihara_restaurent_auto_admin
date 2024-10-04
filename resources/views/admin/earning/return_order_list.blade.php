<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Dashboard">

	<title>Return Orders</title>

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
                <div class="breadcrumb-wrapper breadcrumb-contacts">
						<div>
							<h1>Return Orders List</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Return Orders List
							</p>
						</div>
						<div>
							
                    </div>
					</div>
					<div class="row">
						
						<div class="col-xl-12 col-lg-12">
							<div class="ec-cat-list card card-default">
								<div class="card-body">
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
                                                    <th>S No.</th>
													<th>Order Number</th>
													<th>Name</th>
													<th>Mobile</th>
													<th>Address</th>
												
													<th>Amount</th>
													<th>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
													<th>Mode</th>
													<th>Payment</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>

											<tbody>
												<?php
												$x=1;
												foreach ($data as  $value) {
													?>
													<tr>
														<td>{{$x++}}</td>
														<td>{{$value->order_number}}</td>
														<td>{{$value->full_name}}</td>
														<td>{{$value->mobile}}</td>
														<td>{{$value->house_no}}</td>
														
														<td><strong>Rs. {{$value->grand_total}}</strong></td>
														<td>{{$value->created_date}}, {{$value->created_time}}</td>
														<td>
															<?php 
																if ($value->payment_mode == 'COD') {
																	?>
																	<span class="badge badge-warning">COD</span>
																	<?php
																}
																if ($value->payment_mode == 'ONLINE') {
																	?>
																	<span class="badge badge-success">ONLINE</span>
																	<?php
																}
															?>
															</td>
														<td><span class="badge badge-success">{{$value->payment_status}}</span></td>
														<td><span class="badge badge-primary">{{$value->order_status}}</span></td>
														<td><a href="{{url('sysadmin/view-order-details/'.$value->id)}}"><button type="button" class="btn btn-sm btn-primary">View</button></a></td>
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
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

			@include('admin/common/footer')