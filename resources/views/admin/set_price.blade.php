<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Set Price</title>
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
							<h1>Set Price</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Set Price
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('update_price')}}" method="POST" >
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Kms</label>
													<div class="col-12">
														<input id="text" name="kms" class="form-control here slug-title" type="text" value="<?php 
														if(!empty($prices)){
														    echo $prices->kms;
														}
														?>" placeholder="Enter Kms" readonly>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Amount Value <span class="text-danger">*</span></label>
													<div class="col-12">
														<input id="text" name="value" class="form-control here slug-title" type="number" value="<?php 
														if(!empty($prices)){
														    echo $prices->value;
														}
														?>" placeholder="Enter Amount" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Night Shift Charge <span class="text-danger">*</span></label>
													<div class="col-12">
														<input id="text" name="night_shift" class="form-control here slug-title" type="number" value="<?php 
														if(!empty($prices)){
														    echo $prices->night_shift;
														}
														?>" placeholder="Enter Amount" required>
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
						@include('admin/common/footer')
