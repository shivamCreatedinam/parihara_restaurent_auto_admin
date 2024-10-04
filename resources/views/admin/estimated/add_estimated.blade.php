<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Add Estimated Delivery Days</title>
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
							<h1>Add Estimated Delivery Days</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Add Estimated Delivery Days
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('add.estimated')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Distance Range From</label>
													<div class="col-12">
														<input id="number" name="distance" class="form-control here slug-title"  type="number" placeholder="Enter Distance Range From" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Distance Range To</label>
													<div class="col-12">
														<input id="number" name="distance_to" class="form-control here slug-title"  type="number" placeholder="Enter Distance Range To" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Estimated Days</label>
													<div class="col-12">
														<input  name="days" class="form-control here slug-title"  type="number" placeholder="Enter Estimated Days" required>
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
    function get_city(value) {
       if(value !=''){
		$.ajax({
				url:"{{url('sysadmin/get_city')}}",
				type:"POST",
				data:{
					"_token":"{{csrf_token()}}",
					stateid:value,
				},
				success:function(res){
					$('#showcity').html(res);
				}
		});
	   }
    };
</script>