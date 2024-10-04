<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Dashboard">
		<title>Edit Certificate</title>
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
							<h1>Edit Certificate</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span> Edit Certificate
							<span ><i class="mdi mdi-chevron-right"></i><a onclick="history.back()" href="javascript:void(0)">Back</a></span>
						</p>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<div class="ec-cat-list card card-default mb-24px">
									<div class="card-body">
										<div class="ec-cat-form">
											
											<form action="{{route('edit.certificate')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
											<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Roll Number</label>
													<div class="col-12">
														<input id="text" name="roll_number" value="{{$data->roll_number}}" class="form-control here slug-title" type="text" placeholder="Enter Roll Number">
													</div>
												</div>
													<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Date Of Birth</label>
													<div class="col-12">
														<input id="text" name="dob" value="{{$data->dob}}" class="form-control here slug-title" type="date" placeholder="Enter DOB">
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
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Image</label>
													<div class="col-12">
														<input type="file"  name="image" class="form-control btn-primary" id="uploadImage" onchange="PreviewImage();" accept="image/gif, image/jpeg, image/png" />
													</div>
												</div>
												<div class="form-group">
													<img id="uploadPreview" src="{{asset($data->image)}}" style="width: 80px;" />
												</div>
												<div class="row">
													<div class="col-12">
                                                        <input type="hidden" name="hiddenid" value="{{$data->id}}" required>
                                                        <input type="hidden" name="hiddenfile" value="{{$data->image}}" required> 
                                                        
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