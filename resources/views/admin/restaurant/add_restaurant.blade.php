<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Add User</title>
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
						<div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
							<h1>Add User</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Add User</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											 <form action="{{route('admin.restaurant')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Restaurant Name</label>
													<div class="col-12">
														<input id="text" name="restaurant_name" value="" class="form-control here slug-title" type="text" placeholder="Enter Restaurant  Name" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Owner Name</label>
													<div class="col-12">
														<input id="text" name="owner_name" value="" class="form-control here slug-title" type="text" placeholder="Enter Owner Name" required>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Mobile</label>
													<div class="col-12">
														<input id="text" name="mobile" value="" class="form-control here slug-title" type="text" placeholder="Enter Mobile" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Email</label>
													<div class="col-12">
														<input id="text" name="email" value="" class="form-control here slug-title" type="email" placeholder="Enter Email"  required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Password</label>
													<div class="col-12">
														<input id="password" name="password" value="" class="form-control here slug-title" type="password" placeholder="Enter Password"  required>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Address</label>
													<div class="col-12">
														<input id="text" name="address" value="" class="form-control here slug-title" type="text" placeholder="Enter Address" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Latitude</label>
													<div class="col-12">
														<input id="text" name="latitude" value="" class="form-control here slug-title" type="text" placeholder="Enter Address" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Longitude</label>
													<div class="col-12">
														<input id="text" name="longitude" value="" class="form-control here slug-title" type="text" placeholder="Enter Longitude" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Select Profile Image</label>
													<div class="col-12">
														<input id="text" name="image"  class="form-control here slug-title" type="file" placeholder="" required>
													</div>
												</div>

												<div class="row">
													<div class="col-12">
														<button name="submit" type="submit" class="btn btn-primary">Submit</button>
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
<script type="text/javascript">
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        oFReader.onload = function (oFREvent) {
          $('#uploadPreview').show();
            document.getElementById("uploadPreview").src = oFREvent.target.result;

        };
    };
</script>