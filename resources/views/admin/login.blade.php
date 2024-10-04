<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Admin Login">

		<title>Admin Login</title>
		
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com/">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;family=Poppins:wght@300;400;500;600;700;800;900&amp;family=Roboto:wght@400;500;700;900&amp;display=swap" rel="stylesheet">

		<link href="../../../../cdn.jsdelivr.net/npm/%40mdi/font%404.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
		
		
		<link id="ekka-css" rel="stylesheet" href="{{asset('admin/assets/css/anand.css')}}" />
		
		<!-- FAVICON -->
		<link href="{{asset('admin/assets/img/favicon.png')}}" rel="shortcut icon" />
		<style>
		#body{
			background-image:url({{asset('admin/assets/banner.jpg')}});
			width:100vw;
			height:100vh;
			background-position: center center, center top;
  			background-repeat: repeat, no-repeat;
		}
		</style>
	</head>
	
	<body class="sign-inup" id="body">
		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-10">
					<div class="card">
						<div class="card-header bg-primary">
							<div class="ec-brand">
								<a href="#" title="Anand">
									 <img class="ec-brand-icon" src="{{asset('admin/assets/img/logo/logo-login.png')}}" alt="" /> 
                                <!--<h2 style="color:white;">Anand Rajasthani</h2>-->
                                </a>
							</div>
						</div>
						<div class="card-body p-5">
							<h4 class="text-dark mb-5">Sign In</h4>
							<?php 
                                            if(session()->has('error')){
                                            ?>
                                            <p class="text-danger">{{session('error')}}</p>
                                            <?php
                                            }
                                        ?>
							<form action="{{route('admin.auth')}}" method="POST">
							@csrf	
							<div class="row">
									<div class="form-group col-md-12 mb-4">
										<input type="email" class="form-control" placeholder="example@gmail.com" title="Please enter you email" required=""  name="email">
									</div>
									
									<div class="form-group col-md-12 ">
										<input type="password" class="form-control" id="password" title="Please enter your password" placeholder="******" required=""  name="password">
									</div>
									
									<div class="col-md-12">
										<div class="d-flex my-2 justify-content-between">
											<div class="d-inline-block mr-3">
												<div class="control control-checkbox">Remember me
													<input type="checkbox" />
													<div class="control-indicator"></div>
												</div>
											</div>
											
											<p><a class="text-blue" href="#">Forgot Password?</a></p>
										</div>
										
										<button class="btn btn-primary btn-block mb-4">Sign In</button>
										
										
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Javascript -->
		<script src="{{asset('admin/assets/plugins/jquery/jquery-3.5.1.min.js')}}"></script>
		<script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('admin/assets/plugins/jquery-zoom/jquery.zoom.min.js')}}"></script>
		<script src="{{asset('admin/assets/plugins/slick/slick.min.js')}}"></script>
	
		
		<script src="{{asset('admin/assets/js/anand.js')}}"></script>
	</body>
</html>