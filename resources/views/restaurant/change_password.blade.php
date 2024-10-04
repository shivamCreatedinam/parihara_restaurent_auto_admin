<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Change Password</title>
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
						@if(Session::has('error'))
						<div class="col-sm-12">
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Error !</strong> {{ Session::get('error') }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						</div>
						@endif

						@if(Session::has('message'))
						<div class="col-sm-12">
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<strong>Success !</strong> {{ Session::get('message') }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						</div>
						@endif
						<div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
							<h1>Change Password</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Change Password
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('change_password')}}" method="POST" >
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Old Password</label>
													<div class="col-12">
														<input id="text" name="old_password" class="form-control here slug-title" type="password" placeholder="Enter Old Password" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">New Password</label>
													<div class="col-12">
														<input id="text" name="new_password" class="form-control here slug-title" type="password" placeholder="Enter New Password" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Confirm Password</label>
													<div class="col-12">
														<input id="text" name="new_confirm_password" class="form-control here slug-title" type="password" placeholder="Enter Confirm Password" required>
													</div>
												</div>
												
												<div class="row">
													<div class="col-12">
														<button name="submit" type="submit" class="btn btn-primary">Change Password</button>
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
						@include('admin/common/footer')
