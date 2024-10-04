<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Dashboard">

	<title>Trip</title>

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
							<h1>Trip List</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Trip List
							</p>
							
						</div>
						<div>
                    </div>
					</div>
					<div class="row">
						
						<div class="col-xl-12 col-lg-12">
							<div class="ec-cat-list card card-default">
								<div class="card-body">
								<form action="{{url('sysadmin/trip-list')}}" method="get">
								<div class="row">
								
								<div class="col-md-3">
									<div class="form-group">
										<label for="">Status</label>
										<select name="status" class="form-control" id="" required>
											<option value="">Select One</option>
											<option value="0">Recent Created</option>
											<option value="1">Confirmed</option>
											<option value="2">Running</option>
											<option value="3">Completed</option>
											<option value="3">Canceled</option>
										</select>
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<label for="">Cancel By</label>
										<select name="cancelBy" class="form-control" id="">
											<option value="">Select One </option>
											<option value="User">User</option>
											<option value="Driver">Driver</option>
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
									<a href="{{url('sysadmin/trip-list')}}"><button type="button"  class="btn btn-success" style="margin-top: 27px;"> Reset
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
                                                    <th>Trip ID</th>
													<th>User Name</th>
													<th>Driver Name</th>
													<th>Otp Verified</th>
													<th>From Address</th>
													<th>To Address</th>
													<th>Trip Amount</th>
													<th>Trip Type</th>
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
                                                    <td><strong>#<?=$value->id?></strong></td>
													<td><?=$value->username?></td>
													<td><?=$value->dvname?></td>
													<td><?php echo $d = $value->otp_verified == 1 ? "Verified":"Not Verified";?></td>
													<td>Rs. <?=$value->from_address?></td>
													<td><?=$value->to_address?></td>
													<td>Rs. <?=$value->price?></td>
													<td><?=$value->trip_type?></td>
													
													<td><?=$value->created_date?></td>
													<td><?php 
                                                        if($value->status == '0'){
                                                            ?>
															<span class="badge badge-info">Trip Created</span>
                                                        <?php
                                                        }
                                                        if($value->status == '1'){
															?>
															<span class="badge badge-success">Accepted By Driver</span>
                                                        <?php
                                                        }
                                                        
                                                        if($value->status == '2'){
															?>
															<span class="badge badge-primary">OTP verified</span>
                                                        <?php
                                                        }
                                                        
                                                        if($value->status == '3'){
															?>
															<span class="badge badge-success">Trip Completed</span>
                                                        <?php
                                                        }
                                                        
                                                        if($value->status == '4'){
															?>
															<span class="badge badge-danger">Trip Canceled</span>
                                                        <?php
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
															<!-- {{url('sysadmin/edit-user/'.$value->id)}} -->
															<div class="dropdown-menu">
																<a class="dropdown-item" href="{{url('sysadmin/trip-details/'.$value->id)}}">View Details</a>
																<!-- <a class="dropdown-item" href="#">Delete</a> -->
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