<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Edit Profile</title>
		<!-- GOOGLE FONTS -->
		@include('restaurant/common/head')
	</head>
	<body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">
		<!--  WRAPPER  -->
		<div class="wrapper">
			
			<!-- LEFT MAIN SIDEBAR -->
			@include('restaurant/common/sidebar')
			<!--  PAGE WRAPPER -->
			<div class="ec-page-wrapper">
				<!-- Header -->
				@include('restaurant/common/header')
				<!-- CONTENT WRAPPER -->
				<div class="ec-content-wrapper">
					<div class="content">
						@if(Session::has('message'))
						<div class="col-sm-12">
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Success !</strong> {{ Session::get('message') }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						</div>
						@endif
						<div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
							<h1>Edit Profile</h1>
							<p class="breadcrumbs"><span><a href="{{url('restaurant/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Edit Profile
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('restaurant.update_profile')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Restaurant ID</label>
													<div class="col-12">
														<input id="text" name="restaurantID" value="{{$data->restaurant_id}}" readonly class="form-control here slug-title" type="text" placeholder="Enter ID" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Restaurant Name</label>
													<div class="col-12">
														<input id="text" name="restaurant_name" value="{{$data->restaurant_name}}" class="form-control here slug-title" type="text" placeholder="Enter Restaurant  Name" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Owner Name</label>
													<div class="col-12">
														<input id="text" name="owner_name" value="{{$data->owner_name}}" class="form-control here slug-title" type="text" placeholder="Enter Owner Name" required>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Mobile</label>
													<div class="col-12">
														<input id="text" name="mobile" value="{{$data->mobile}}" class="form-control here slug-title" type="text" placeholder="Enter Mobile" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Email</label>
													<div class="col-12">
														<input id="text" name="email" value="{{$data->email}}" class="form-control here slug-title" type="email" placeholder="Enter Email"  required>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Address</label>
													<div class="col-12">
														<input id="text" name="address" value="{{$data->address}}" class="form-control here slug-title" type="text" placeholder="Enter Address" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Latitude</label>
													<div class="col-12">
														<input id="text" name="latitude" value="{{$data->latitude}}" class="form-control here slug-title" type="text" placeholder="Enter Address" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Longitude</label>
													<div class="col-12">
														<input id="text" name="longitude" value="{{$data->longitude}}" class="form-control here slug-title" type="text" placeholder="Enter Longitude" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Select Profile Image</label>
													<div class="col-12">
														<input id="text" name="image"  class="form-control here slug-title" type="file" placeholder="" >
													</div>
												</div>

												     <div class="form-group row">
													<label for="text" class="col-12 col-form-label">Profile Image</label>
													<div class="col-12">
														<img src="{{asset($data->image)}}" alt="" style="width: 200px;height: 200px;">
													</div>
												</div>
												<div class="row">
													<div class="col-12">
														<button name="submit" type="submit" class="btn btn-primary">Update</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						</div> <!-- End Content -->
						</div> <!-- End Content Wrapper -->
						@include('restaurant/common/footer')
