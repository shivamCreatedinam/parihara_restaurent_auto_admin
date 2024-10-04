<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Dashboard">

	<title>Earning </title>

	<!-- GOOGLE FONTS -->
    @include('admin/common/head')
	<style>
		table {
		width: 100%!important;
		}
		th{
			width: 100%!important;
		}
	</style>
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
							<h1>Earning  List</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Earning  List
							</p>
						</div>
						<div>
							
                    </div>
					</div>
					<div class="row">
						
						<div class="col-xl-12 col-lg-12">
							<div class="ec-cat-list card card-default">
								<div class="card-body">

								<form action="{{url('sysadmin/earning')}}" method="get">
									<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label for=""> Order Number</label>
											<input type="text" name="order_number" class="form-control" placeholder="Enter Order Number">
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group">
											<label for=""> Payment Status</label>
											<select name="payment_status" class="form-control">
												<option value="">Select Payment Status</option>
												<option value="Success">Success</option>
												<option value="Pending">Pending</option>
												<option value="Failed">Failed</option>
											</select>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group">
											<label for=""> Payment Mode</label>
											<select name="payment_mode" class="form-control">
												<option value="">Select Payment Mode</option>
												<option value="COD">COD</option>
												<option value="ONLINE">ONLINE</option>
											</select>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group">
											<label for=""> From Date</label>
											<input type="date" name="from_date" id="from_date" class="form-control" placeholder="Enter Name">
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group">
											<label for=""> To Date</label>
											<input type="date" name="to_date" id="to_date" class="form-control" placeholder="Enter Name">
										</div>
									</div>	
									<div class="col-md-4">
										<div class="form-group">
										<button  class="btn btn-primary" style="margin-top: 27px;"> Search
										</button>
									 <!--   <a href="{{url('sysadmin/exporter')}}">	<button type="button"  class="btn btn-success" style="margin-top: 27px;"> Export-->
										<!--</button></a>-->
										<a href="{{url('sysadmin/earning')}}"><button type="button"  class="btn btn-success" style="margin-top: 27px;"> Reset
                        			</button></a>
										</div>
									</div>	
									
									</form>
								</div>

									<div class="table-responsive">
										<table id="responsive-data-table" class="table table-hovered table-striped table-bordered">
											<thead>
												<tr>
                                                    <th>S No.</th>
													<th>Order Number</th>
													<th>Invoice No</th>
													<th>Name</th>
													<th>Customer Type</th>
													<th>Products</th>
													<th>Categories</th>
													<th>Qty</th>
													<th>Return Qty</th>
													<th>Net Amount</th>
													<th>Delivery Charge</th>
													<th>Total Amount</th>
													<th>Return Amount</th>
													<th>Margin</th>
													<th>Payment Mode</th>
													<th>Payment Status</th>
													<th>Order Status</th>
													<th>Created on</th>
													
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
														<td></td>
														<td>{{$value->full_name}}</td>
														<td>General</td>
														<td>{{$value->product_name}}</td>
														<td>{{$value->category_name}}</td>
														<td>{{$value->qty}}</td>
														<td>0</td>
														<td><strong>Rs. {{$value->price}}</strong></td>
														<td><strong>Rs. {{$value->delvery_charge}}</strong></td>
														<td><strong>Rs. <?php echo $value->total_price+$value->delvery_charge;?></strong></td>
														<td>0</td>
														<td></td>
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
														<td>{{$value->created_date}}, {{$value->created_time}}</td>
														
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