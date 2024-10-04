<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Add Sub Sub Category</title>
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
							<h1>Add Sub Sub Category</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Add Sub Sub Category
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('add.subsubcategory')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Category</label>
													<div class="col-12">
														<select class="form-control" name="category_id" onchange="get_sub_cat(this.value)" required>
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
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Sub Category</label>
													<div class="col-12">
														<select class="form-control" name="sub_category_id" id="showsubcat" required>
														<option value="">Select Sub Category</option>
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
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Sub Sub Category Name</label>
													<div class="col-12">
														<input id="text" name="title" class="form-control here slug-title" type="text" placeholder="Enter Sub  Sub Category Name">
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Image</label>
													<div class="col-12">
														<input type="file"  name="image" class="form-control btn-primary" id="uploadImage" onchange="PreviewImage();" required accept="image/gif, image/jpeg, image/png" />
													</div>
												</div>
												<div class="form-group">
													<img id="uploadPreview" style="width: 80px; display: none;" />
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
							function get_sub_cat(id){
								if (id !='') {
									$.ajax({
										url:"{{url('sysadmin/get_sub_cat')}}",
										type:"POST",
										data:{
											_token:"{{csrf_token()}}",
											id:id
										},
										success:function(res){
											$('#showsubcat').html(res);
										}
									})
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