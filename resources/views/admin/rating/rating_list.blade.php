<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Dashboard">

	<title>Ratings</title>

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
							<h1>Ratings List</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Ratings List
							</p>
						</div>
						<div>
							<!-- <a href="{{url('sysadmin/add-coupon')}}"><button type="button" class="btn btn-primary" > Add Coupon
						
                        </button></a> -->
                        <!-- data-bs-toggle="modal" data-bs-target="#addUser"	 -->
                    </div>
					</div>
					<div class="row">
						
						<div class="col-xl-12 col-lg-12">
							<div class="ec-cat-list card card-default">
								<div class="card-body">
								<!-- {{url('sysadmin/product-list')}} -->
								<form action="{{url('sysadmin/ratings')}}" method="get">
									<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="">Search By Review</label>
											<input type="text" name="review" class="form-control" placeholder="Enter Review">
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group">
											<label for="">Search By Rating</label>
											<input type="text" name="rating" class="form-control" placeholder="Enter Rating">
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
										<a href="{{url('sysadmin/ratings')}}"><button type="button"  class="btn btn-success" style="margin-top: 27px;"> Reset
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
													<th>User Name</th>
													<th>Mobile</th>
													<th>Product Image</th>
													<th>Product Name</th>
													<th>Rating</th>
													<th>Review</th>
													<th>Date</th>
													<th>Status</th>
												
												</tr>
											</thead>

											<tbody>
                                               <?php 
                                                $x = 1;
                                                foreach ($data as $key => $value) {
												
                                                    ?>
                                                <tr>
                                                    <td><?=$x?></td>
													<td><?=$value->name?></td>
												
													<td><?=$value->mobile?></td>
													<td><img src="{{asset(product_image($value->prodid))}}" width="70" height="70"></td>
													<td><?=$value->product_name?></td>
												
													<td><?=$value->ratings?></td>
													<td><?=$value->reviews?></td>
														<td><?=$value->created_date?></td>
														<td><?php 
                                                        if($value->status == '1'){
                                                            ?>
															<a href="{{url('sysadmin/rating_status_change/0/'.$value->id)}}"><span class="badge badge-success">Active</span></a>
                                                        <?php
														}
                                                        if($value->status == '0'){
															?>
															<a href="{{url('sysadmin/rating_status_change/1/'.$value->id)}}"><span class="badge badge-danger">In Active</span></a>
                                                        <?php
                                                           
                                                        }
                                                    ?></td>
												
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