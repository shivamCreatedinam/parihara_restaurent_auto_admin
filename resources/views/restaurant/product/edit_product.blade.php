<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Edit Product</title>
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
							<h1>Edit Product</h1>
							<p class="breadcrumbs"><span><a href="{{url('restaurant/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>Edit Product
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('edit.product')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="row">
												<div class="form-group col-6 ">
													<label for="text" class="col-12 col-form-label">Select Category</label>
													<div class="col-12">
														<select name="category_id" class="form-control here slug-title" type="text" >
															<option value="">Select Category</option>
															<?php 
															foreach ($category as $key => $value) {
																?>
																<option value="<?=$value->id?>" <?php 
																	if($data->category_id == $value->id){
																		echo 'selected';
																	}
																?>><?=$value->category_name?></option>
																<?php
															}
															?>
														</select>
													</div>
												</div>

												<div class="form-group col-6 ">
													<label for="text" class="col-12 col-form-label">Select Attribute</label>
													<div class="col-12">
													<select name="attribute_id" class="form-control here slug-title" type="text" >
															<option value="">Select Attribute</option>
															<?php 
															foreach ($attributes as $key => $value) {
																?>
																<option value="<?=$value->id?>" <?php 
																	if($data->attribute_id == $value->id){
																		echo 'selected';
																	}
																?>><?=$value->attribute_title?></option>
																<?php
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group col-12 ">
													<label for="text" class="col-12 col-form-label">Product Name</label>
													<div class="col-12">
													<input name="product_name" class="form-control here slug-title" type="text" value="{{$data->product_name}}" placeholder="Enter Product Name" />
															
													</div>
												</div>


												<div class="form-group col-6 ">
													<label for="text" class="col-12 col-form-label">MRP</label>
													<div class="col-12">
													<input name="market_price" class="form-control here slug-title" type="text" value="{{$data->market_price}}" placeholder="Enter MRP" />
													</div>
												</div>
												<div class="form-group col-6 ">
												<label for="text" class="col-12 col-form-label">Discount %</label>
													<div class="col-12">
													<input name="discount" class="form-control here slug-title" type="text"  value="{{$data->discount}}" placeholder="Enter Discount" />
													</div>
												</div>

												<div class="form-group col-6 ">
												<label for="text" class="col-12 col-form-label">Sale Price</label>
													<div class="col-12">
													<input name="sale_price" class="form-control here slug-title" type="text" value="{{$data->sale_price}}" placeholder="Enter Sale Price" />
													</div>
												</div>

												<div class="form-group col-6 ">
												<label for="text" class="col-12 col-form-label">Quantity</label>
													<div class="col-12">
													<input name="qty" class="form-control here slug-title" type="text" value="{{$data->qty}}" placeholder="Enter Quantity" />
													</div>
												</div>
												<div class="form-group col-6">
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
												<div class="form-group col-12 ">
												<label for="text" class="col-12 col-form-label">Product Description</label>
													<div class="col-12">
													<textarea name="description" class="form-control here slug-title" type="text" placeholder="Enter Description" >{{$data->description}}</textarea>
													</div>
												</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Image</label>
													<div class="col-12">
														<input type="file"  name="Image[]" multiple class="form-control btn-primary" id="uploadImage" onchange="PreviewImage();"  accept="image/gif, image/jpeg, image/png" />
													</div>
												</div>
												<div class="row">
												<?php 
												$images = product_image_list($data->id);
											
												foreach ($images as $val) {
													?>
												<div class="col-2">
												<div class="form-group">
													<img id="" src="{{asset($val->image)}}" style="width: 80px;" />
													<a href="#">Remove</a>
												</div>
												</div>
												
													<?php
												}
												?>
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
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        oFReader.onload = function (oFREvent) {
          $('#uploadPreview').show();
            document.getElementById("uploadPreview").src = oFREvent.target.result;

        };
    };
</script>