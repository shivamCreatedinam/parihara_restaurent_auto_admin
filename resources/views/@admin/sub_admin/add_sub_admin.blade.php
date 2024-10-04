<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Add Sub Admin</title>
		<!-- GOOGLE FONTS -->
		@include('admin/common/head')
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
							<h1>Add Sub Admin</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Add Sub Admin
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('add.sub_admin')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Full Name</label>
													<div class="col-12">
														<input id="text" name="name" class="form-control" type="text" placeholder="Enter Full Name">
														@if($errors->has('name'))
															<div class="text-danger">{{ $errors->first('name') }}</div>
														@endif
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Mobile</label>
													<div class="col-12">
														<input  name="mobile" maxlength="10" minlength="10" class="form-control" type="text" placeholder="Enter Mobile">
														@if($errors->has('mobile'))
															<div class="text-danger">{{ $errors->first('mobile') }}</div>
														@endif
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Email</label>
													<div class="col-12">
														<input  name="email"  class="form-control" type="email" placeholder="Enter Email">
														@if($errors->has('email'))
															<div class="text-danger">{{ $errors->first('email') }}</div>
														@endif
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Password</label>
													<div class="col-12">
														<input  name="password"  class="form-control" type="password" placeholder="Enter Password">
													</div>
												</div>

												<div class="form-group showselecteduser  col-12"
                                                    style="">
                                                    <label for="text" class="col-12 col-form-label">Provide Menu Access</label>
                                                    <div class="col-12">
                                                        <select name="selected_user_id[]"
                                                            class="form-control here slug-title multiple-select"
                                                            style="width: 100%;" id="unselectfor" multiple>
                                                            <?php 
                                                            foreach($menu as $menu){
                                                               ?>
                                                                <option value="<?php echo $menu->id?>"><?php echo $menu->menu_title?></option>
                                                               <?php
                                                            }
                                                            ?>
                                                        </select>
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
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
            $('.multiple-select').select2({
                placeholder: "Select Menu",
                allowClear: true
            });
            </script>
			 <script>
            function select_user_list(value) {
                if (value == 'Selected-User') {
                    $('.showselecteduser').show();

                    $("#unselectfor > option").attr("selected", false);
                } else {

                    $('.showselecteduser').hide();
                    $("#unselectfor > option").attr("selected", false);
                }
            }
            </script>