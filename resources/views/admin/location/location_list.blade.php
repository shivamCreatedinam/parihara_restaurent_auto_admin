<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Dashboard">

	<title>Location</title>

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
                @if(Session::has('message'))
            <div class="col-sm-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Success !</strong> {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                       

                    </div>
            @endif
                <div class="breadcrumb-wrapper breadcrumb-contacts">
						<div>
							<h1>Location List</h1>
							<p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
								<span><i class="mdi mdi-chevron-right"></i></span>Location List
							</p>
						</div>
						<div>
							<a href="{{url('sysadmin/add-location')}}"><button type="button" class="btn btn-primary" > Add Location
                        </button></a>
                      
                    </div>
					</div>
					<div class="row">
						
						<div class="col-xl-12 col-lg-12">
							<div class="ec-cat-list card card-default">
								<div class="card-body">
								<form action="{{url('sysadmin/location')}}" method="get">
									<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label for="">State</label>
											<select name="state_id" class="form-control here slug-title" type="text" onchange="get_city(this.value)" >
															<option value="">Select State</option>
															<?php 
															foreach ($state as $key => $value) {
																?>
																<option value="<?=$value->id?>"><?=$value->name?></option>
																<?php
															}
															?>
											</select>
										</div>
									</div>	
									<div class="col-md-3">
										<div class="form-group">
											<label for="">City</label>
											<select name="city_id" id="showcity" class="form-control here slug-title"  >
															<option value="">Select City</option>
															
														</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="">City</label>
											<input type="text" name="pincode" id="to_date" class="form-control" placeholder="Enter Pincode">
										</div>
									</div>	
									
									<div class="col-md-3">
										<div class="form-group">
										<button  class="btn btn-primary" style="margin-top: 27px;"> Search
										</button>
										<a href="{{url('sysadmin/location')}}"><button type="button"  class="btn btn-success" style="margin-top: 27px;"> Reset
                        			</button></a>
										</div>
									</div>	
									</form>
								</div>
									<div class="table-responsive">
										<table id="responsive-data-table" class="table">
											<thead>
												<tr>
                                                    <th>S No.</th>
													<th>State</th>
													<th>City</th>
													<th>Region Name</th>
													<th>Pincode</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>

											<tbody>
                                                <?php 
                                                $x = 1;
                                                foreach ($data as $key => $value) {
                                                    ?>
                                                <tr>
                                                    <td><?=$x?></td>
													<td><?=$value->state?></td>
													<td><?=$value->city?></td>
													<td><?=$value->location_name?></td>
													<td><?=$value->pincode?></td>
													
													<td><?php 
                                                        if($value->status == '1'){
                                                            echo '<span class="badge badge-success">Active</span>';
                                                        }
                                                        if($value->status == '0'){
                                                            echo '<span class="badge badge-danger">Inactive</span>';
                                                        }
                                                    ?></td>
													<td>
														<div class="btn-group">
															<button type="button"
																class="btn btn-outline-success">Action</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Action</span>
															</button>

															<div class="dropdown-menu">
																<a class="dropdown-item" href="{{url('sysadmin/edit-location/'.$value->id)}}">Edit</a>
																<a class="dropdown-item" href="{{url('sysadmin/delete-location/'.$value->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
															</div>
														</div>
													</td>
												</tr>
                                                    <?php
                                                    $x++;
                                                }
                                                ?>
												
											</tbody>
										</table>
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