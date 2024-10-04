<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>Restaurant Profile</title>
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
                            <h1>Restaurant Profile</h1>
                            <p class="breadcrumbs">
                                <span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                                <span><i class="mdi mdi-chevron-right"></i></span>Restaurant Profile<span><i
                                        class="mdi mdi-chevron-right"></i><a onclick="history.back()"
                                        href="javascript:void(0)">Back</a></span>
                            </p>
                        </div>

                    </div>
                    <div class="card bg-white profile-content ec-vendor-profile">
                        <div class="row">
                            <div class="col-lg-4 col-xl-3">
                                <div class="profile-content-left profile-left-spacing">
                                    <div class="ec-disp">
                                        <div class="text-center widget-profile px-0 border-0">
                                            <div class="card-img mx-auto rounded-circle">
                                                <img src="{{asset($data->image)}}" alt="user image">
                                            </div>
                                            <div class="card-body">
                                                <h4 class="py-2 text-dark">{{$data->restaurant_name}}</h4>
                                                <h4 class="py-2 text-dark">{{$data->restaurant_id}}</h4>

                                            </div>
                                        </div>


                                    </div>
                                    <hr class="w-100">

                                    <div class="contact-info pt-4">
                                        <h5 class="text-dark">Contact Information</h5>
                                        <p class="text-dark font-weight-medium pt-24px mb-2">Email address</p>
                                        <p>{{$data->email}}</p>
                                        <p class="text-dark font-weight-medium pt-24px mb-2">Phone Number</p>
                                        <p>+ 91{{$data->mobile}}</p>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xl-9">
                                <div class="profile-content-right profile-right-spacing py-5">
                                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myProfileTab"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="true">Restaurant Profile</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                                data-bs-target="#settings" type="button" role="tab"
                                                aria-controls="settings" aria-selected="false">Manage Order</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="tab-widget mt-5">
                                                <form action="{{route('admin.update_restaurant')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Restaurant ID</label>
													<div class="col-12">
														<input id="text" name="restaurantID" value="{{$data->restaurant_id}}" readonly class="form-control here slug-title" type="text" placeholder="Enter ID" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Restaurant Name</label>
													<div class="col-12">
														<input id="text" name="restaurant_name" value="{{$data->restaurant_name}}" class="form-control here slug-title" type="text" placeholder="Enter Restaurant  Name" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Owner Name</label>
													<div class="col-12">
														<input id="text" name="owner_name" value="{{$data->owner_name}}" class="form-control here slug-title" type="text" placeholder="Enter Owner Name" required>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Mobile</label>
													<div class="col-12">
														<input id="text" name="mobile" value="{{$data->mobile}}" class="form-control here slug-title" type="text" placeholder="Enter Mobile" required>
													</div>
												</div>

												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Email</label>
													<div class="col-12">
														<input id="text" name="email" value="{{$data->email}}" class="form-control here slug-title" type="email" placeholder="Enter Email" readonly required>
													</div>
												</div>
												
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Address</label>
													<div class="col-12">
														<input id="text" name="address" value="{{$data->address}}" class="form-control here slug-title" type="text" placeholder="Enter Address" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Latitude</label>
													<div class="col-12">
														<input id="text" name="latitude" value="{{$data->latitude}}" class="form-control here slug-title" type="text" placeholder="Enter Address" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Longitude</label>
													<div class="col-12">
														<input id="text" name="longitude" value="{{$data->longitude}}" class="form-control here slug-title" type="text" placeholder="Enter Longitude" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="text" class="col-12 col-form-label">Select Profile Image</label>
													<div class="col-12">
														<input id="text" name="image"  class="form-control here slug-title" type="file" placeholder="" >
													</div>
												</div>

												     <div class="form-group row">
													<label for="text" class="col-12 col-form-label">Profile Image</label>
													<div class="col-12">
														<img src="{{asset($data->image)}}" alt="" style="width: 200px;height: 200px;">
													</div>
												</div>
												<div class="row">
													<div class="col-12">
													    <input type="hidden" name="hiddenid" value="{{$data->id}}" >
														<button name="submit" type="submit" class="btn btn-primary">Update</button>
													</div>
												</div>
											</form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="settings" role="tabpanel"
                                            aria-labelledby="settings-tab">
                                            <div class="tab-pane-content mt-5">
                                                 <div class="table-responsive">
            									 <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.No</th>
                                                                            <th>Order Number</th>
                                                                            <th>Amount</th>
                                                                            
                                                                            <th>Order Date</th>
                                                                            <th>Payment Mode</th>
                                                                            <th>Payment Status</th>
                                                                            <th>Order Status</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <?php 
																		$x=1;
																		foreach ($orders as $value) {
																			?>
                                                                        <tr>
                                                                            <td>{{$x}}</td>
                                                                            <td>{{$value->order_number}}</td>
                                                                            <td><strong>Rs.
                                                                                    {{$value->grand_total}}</strong>
                                                                            </td>
																		
                                                                            <td>{{$value->created_date}},
                                                                                {{$value->created_time}}</td>
                                                                            <td>
                                                                                <?php 
																					if ($value->payment_mode == 'COD') {
																						?>
                                                                                <span
                                                                                    class="badge badge-warning">COD</span>
                                                                                <?php
																					}
																					if ($value->payment_mode == 'ONLINE') {
																						?>
                                                                                <span
                                                                                    class="badge badge-success">ONLINE</span>
                                                                                <?php
																					}
																				?>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge-success">{{$value->payment_status}}</span>
                                                                            </td>
                                                                            <td><span
                                                                                    class="badge badge-primary">{{$value->order_status}}</span>
                                                                            </td>
                                                                            
                                                                            <td class="text-right">
                                                                                <div
                                                                                    class="dropdown show d-inline-block widget-dropdown">
                                                                                    <a class="dropdown-toggle icon-burger-mini"
                                                                                        href="#" role="button"
                                                                                        id="dropdown-recent-order1"
                                                                                        data-bs-toggle="dropdown"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false"
                                                                                        data-display="static"></a>

                                                                                    <ul class="dropdown-menu dropdown-menu-right"
                                                                                        aria-labelledby="dropdown-recent-order1">
                                                                                        <li class="dropdown-item">
                                                                                            <a href="{{url('sysadmin/view-order-details/'.$value->id)}}">View</a>
                                                                                        </li>
																					</ul>
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
                oFReader.onload = function(oFREvent) {
                    $('#uploadPreview').show();
                    document.getElementById("uploadPreview").src = oFREvent.target.result;

                };
            };
            </script>