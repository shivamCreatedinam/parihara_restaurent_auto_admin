<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Add Offer</title>
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
							<h1>Add Offer</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Add Offer</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('add.offer')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="row">
														<div class="form-group col-6">
															<label for="text" class="col-12 col-form-label">Category</label>
															<div class="col-12">
															<select name="category_id" class="form-control here slug-title" onchange="select_product(this.value)" type="text" required >
																	<option value="">Select Category</option>
																	<?php 
																	foreach ($category as $key => $value) {
																		?>
																		<option value="<?=$value->id?>"><?=$value->category_name?></option>
																		<?php
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group col-6 ">
															<label for="text" class="col-12 col-form-label">Product</label>
															<div class="col-12">
															<select name="product_id" class="form-control here showprod slug-title" type="text" >
																	<option value="">Select Product</option>
																	
																</select>
															</div>
														</div>
														<div class="form-group col-6">
															<label for="text" class="col-12 col-form-label">Offer Type</label>
															<div class="col-12">
															<select name="offer_type" class="form-control here slug-title" type="text" required >
																	<option value="">Select Offer Type</option>
																	<option value="Fixed">Fixed</option>
																	<option value="Percentage">Percentage</option>
																</select>
															</div>
														</div>
														<div class="form-group col-6">
															<label for="text" class="col-12 col-form-label">Offer </label>
															<div class="col-12">
															<input name="offer_title" class="form-control here slug-title" placeholder="Enter Offer " type="number" required >
																
															</div>
														</div>
														<div class="form-group col-6">
															<label for="text" class="col-12 col-form-label">Offer Start From</label>
															<div class="col-12">
															<input name="offer_start_from" class="form-control here slug-title" placeholder="Enter Offer Title" type="datetime-local" required >
																
															</div>
														</div>
														<div class="form-group col-6">
															<label for="text" class="col-12 col-form-label">Offer Expires On</label>
															<div class="col-12">
															<input name="offer_expires_on" class="form-control here slug-title" placeholder="Enter Offer Expires On" type="datetime-local" required >
																
															</div>
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
						<script>
						    function select_product(id){
						        if(id!=''){
						        
						            
						            $.ajax({
                                        url:"{{url('sysadmin/offer_get_product')}}",
                                        type:'POST',
                                        data:{
                                            "_token":"{{csrf_token()}}",
                                            id:id
                                        },
                                        success:function(result){
                                           $('.showprod').html(result);
                                        }
                                        });
						        }
						    }
						</script>
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