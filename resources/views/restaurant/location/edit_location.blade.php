<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Edit Location</title>
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
							<h1>Edit Location</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span> Edit Location
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('edit.location')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">State</label>
													<div class="col-12">
													<select name="state_id" class="form-control here slug-title" type="text" onchange="get_city(this.value)" >
															<option value="">Select State</option>
															<?php 
															foreach ($state as $key => $value) {
																?>
																<option value="<?=$value->id?>" <?php 
																	if($value->id == $data->state_id){
																		echo 'selected';
																	}
																?>><?=$value->name?></option>
																<?php
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">City</label>
													<div class="col-12">
													<select name="city_id" id="showcity" class="form-control here slug-title" required >
															<option value="">Select City</option>
															<?php 
															foreach ($city as $key => $value) {
																?>
																<option value="<?=$value->id?>" <?php 
																	if($value->id == $data->city_id){
																		echo 'selected';
																	}
																?>><?=$value->name?></option>
																<?php
															}
															?>
														</select>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Region Name</label>
													<div class="col-12">
														<input id="text" name="region" class="form-control here slug-title" value="{{$data->location_name}}" type="text" placeholder="Enter Region Name" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Pincode</label>
													<div class="col-12">
														<input id="text" name="pincode" class="form-control here slug-title" value="{{$data->pincode}}"  type="text" placeholder="Enter Pincode" required>
													</div>
												</div>
												
                                                <div class="form-group row">
													<label for="text" class="col-12 col-form-label">Status</label>
													<div class="col-12">
														<select class="form-control here slug-title" name="status" required>
                                                            <option value="1" <?php 
                                                            if($data->status ==1){
                                                                echo 'selected';
                                                            }
                                                            ?>>Active</option>
                                                             <option value="0" <?php 
                                                            if($data->status ==0){
                                                                echo 'selected';
                                                            }
                                                            ?>>Inactive</option>
                                                        </select>
													</div>
												</div>
												
												<div class="row">
													<div class="col-12">
                                                        <input type="hidden" name="hiddenid" value="{{$data->id}}" required>
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