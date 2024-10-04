<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Dashboard">

	<title>Coupon</title>

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
							<h1>Coupon List</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Coupon List
							</p>
						</div>
						<div>
							<a href="{{url('sysadmin/add-coupon')}}"><button type="button" class="btn btn-primary" > Add Coupon
						
                        </button></a>
                        <!-- data-bs-toggle="modal" data-bs-target="#addUser"	 -->
                    </div>
					</div>
					<div class="row">
						
						<div class="col-xl-12 col-lg-12">
							<div class="ec-cat-list card card-default">
								<div class="card-body">

								<form action="{{url('sysadmin/coupons')}}" method="get">
									<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="">Enter Coupon Code</label>
											<input type="text" name="coupon_code" class="form-control" placeholder="Enter Coupon Code">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group">
											<label for="">Coupon Type</label>
											<select name="coupon_type" class="form-control">
											<option value="">Select </option>	
											<option value="Fixed">Fixed</option>
												<option value="Percentage">Percentage</option>
											</select>
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group">
											<label for=""> From Date</label>
											<input type="date" name="from_date" id="from_date" class="form-control" placeholder="Enter Name">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group">
											<label for=""> To Date</label>
											<input type="date" name="to_date" id="to_date" class="form-control" placeholder="Enter Name">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group">
										<button  class="btn btn-primary" style="margin-top: 27px;"> Search
										</button>
										<a href="{{url('sysadmin/coupons')}}"><button type="button"  class="btn btn-success" style="margin-top: 27px;"> Reset
                        			</button></a>
										</div>
									</div>	
									</form>
								</div>
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
                                                    <th>S No.</th>
													<th>Coupon Code</th>
													<th>Coupon Type</th>
													<th>Discount</th>
													<th>User Type</th>
													<th>Start From</th>
													<th>Expires On</th>
													<th>Expiry Status</th>
													<th>Created Date</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>

											<tbody>
                                                <?php 
                                                $x = 1;
                                                foreach ($data as $key => $value) {
                                                    ?>
                                                <tr>
                                                    <td><?=$x?></td>
													<td><?=$value->coupon_code?></td>
													<td><?=$value->discount_type?></td>
													<td><?php 
														if($value->discount_type =='Fixed' ){
															echo 'Rs. '.$value->discount;
														}
														if($value->discount_type == 'Percentage' ){
															echo $value->discount.' % ';
														}
													?></td>
													<td><?=$value->user_type?></td>
													<td><?=$value->valid_from?></td>
													<td><?=$value->expires_on?></td>
													<td><?php
														if (strtotime(date('Y-m-d h:i:s')) >= strtotime($value->expires_on) ) {
															echo '<span class="badge badge-danger">Expired</span>';
														}													
													?></td>
													<td><?=$value->created_at?></td>
													<td><?php 
                                                        if($value->status == '1'){
                                                            echo '<span class="badge badge-success">Active</span>';
                                                        }
                                                        if($value->status == '0'){
                                                            echo '<span class="badge badge-danger">Inactive</span>';
                                                        }
                                                    ?></td>
													<td>
														<div class="btn-group">
															<button type="button"
																class="btn btn-outline-success">Action</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Action</span>
															</button>

															<div class="dropdown-menu">
																<a class="dropdown-item" href="{{url('sysadmin/edit-coupon/'.$value->id)}}">Edit</a>
																<a class="dropdown-item" href="{{url('sysadmin/delete-coupon/'.$value->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
															</div>
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
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

			@include('admin/common/footer')