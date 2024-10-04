<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>Driver Profile</title>
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
                    <div class="breadcrumb-wrapper breadcrumb-contacts">
                        <div>
                            <h1>Driver Profile</h1>
                            <p class="breadcrumbs">
                                <span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                                <span><i class="mdi mdi-chevron-right"></i></span>Profile<span><i
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
                                                <img src="{{asset($data->drv_image)}}" alt="user image">
                                            </div>
                                            <div class="card-body">
                                                <h4 class="py-2 text-dark">{{$data->name}}</h4>
                                                <h4 class="py-2 text-dark">{{$data->driver_id}}</h4>
                                                <h5 class="py-2 ">Duty: <strong><span class="text-success">{{$data->duty_status}}</span></strong></h5>
                                                <h5 class="py-2 ">Verified: <strong><span class="text-warning">{{$data->verified}}</span></strong></h5>
                                                <h5 class="py-2 ">Total Earn: <strong><span class="text-warning">Rs. {{$totalearn}}</span></strong></h5>
                                                

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
                                                aria-controls="profile" aria-selected="true">Profile</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                                data-bs-target="#settings" type="button" role="tab"
                                                aria-controls="settings" aria-selected="false">Total Trip</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="tab-widget mt-5">
                                                <form>
                                             
                                                    <div class="form-group mb-4">
                                                        <label for="userName">Driver Name</label>
                                                        <input type="text" class="form-control" id="userName"
                                                            value="{{$data->name}}" readonly>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="userName">Mobile</label>
                                                        <input type="text" class="form-control" id="userName"
                                                            value="{{$data->mobile}}" readonly>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="userName">Email</label>
                                                        <input type="text" class="form-control" id="userName"
                                                            value="{{$data->email}}" readonly>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="userName">Vehicle No.</label>
                                                        <input type="text" class="form-control" id="userName"
                                                            value="{{$data->vehicle_no}}" readonly>
                                                    </div>
                                                   <div class="form-group mb-4">
                                                        <label for="userName">Address</label>
                                                        <textarea cols="20" class="form-control" name="address" rows="4" placeholder="Enter Address" readonly>{{$data->address}}</textarea>
                                                    </div>
                                                    <hr>
                                                    <h5>Documents</h5>
                                                    <br>
                                                   <div class="form-group mb-4">
                                                        <label for="userName">Aadhar Front</label>
                                                        <br>
                                                        
                                                    <a href="{{asset($data->aadhar_front)}}" target="_blank"><img src="{{asset($data->aadhar_front)}}" style="width:200px;height:200px;"></a>
                                                    </div>
                                                   <div class="form-group mb-4">
                                                        <label for="userName">Aadhar Back</label>
                                                        <br>
                                                        
                                                    <a href="{{asset($data->aadhar_back)}}" target="_blank"><img src="{{asset($data->aadhar_back)}}" style="width:200px;height:200px;"></a>
                                                    </div>
                                                   <div class="form-group mb-4">
                                                        <label for="userName">Driving Licence</label>
                                                        <br>
                                                        
                                                    <a href="{{asset($data->drv_licence)}}" target="_blank"><img src="{{asset($data->drv_licence)}}" style="width:200px;height:200px;"></a>
                                                    </div>
                                                  @if($data->insurance_file !='')
                                                   <div class="form-group mb-4">
                                                        <label for="userName">Insurance</label>
                                                        <br>
                                                        
                                                    <a href="{{asset($data->insurance_file)}}" target="_blank"><img src="{{asset($data->insurance_file)}}" style="width:200px;height:200px;"></a>
                                                    </div>
                                                   
                                                    @endif
                                                </form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="settings" role="tabpanel"
                                            aria-labelledby="settings-tab">
                                            <div class="tab-pane-content mt-5">
                                               <div class="table-responsive">
            										<table id="responsive-data-table" class="table">
            											<thead>
            												<tr>
                                                                <th>S No.</th>
                                                                <th>Trip ID</th>
            													<th>User Name</th>
            													<th>Driver Name</th>
            													<th>Otp Verified</th>
            													<th>From Address</th>
            													<th>To Address</th>
            													<th>Trip Amount</th>
            													<th>Trip Type</th>
            													<th>Created Date</th>
            													<th>Status</th>
            													<th>Action</th>
            												</tr>
            											</thead>
            
            											<tbody>
                                                            <?php 
                                                            $x = 1;
                                                            foreach ($tripdata as $key => $value) {
                                                                ?>
                                                            <tr>
                                                                <td><?=$x?></td>
                                                                <td><strong>#<?=$value->id?></strong></td>
            													<td><?=$value->username?></td>
            													<td><?=$value->dvname?></td>
            													<td><?php echo $d = $value->otp_verified == 1 ? "Verified":"Not Verified";?></td>
            													<td>Rs. <?=$value->from_address?></td>
            													<td><?=$value->to_address?></td>
            													<td>Rs. <?=$value->price?></td>
            													<td><?=$value->trip_type?></td>
            													
            													<td><?=$value->created_date?></td>
            													<td><?php 
                                                                    if($value->status == '0'){
                                                                        ?>
            															<span class="badge badge-info">Trip Created</span>
                                                                    <?php
                                                                    }
                                                                    if($value->status == '1'){
            															?>
            															<span class="badge badge-success">Accepted By Driver</span>
                                                                    <?php
                                                                    }
                                                                    
                                                                    if($value->status == '2'){
            															?>
            															<span class="badge badge-primary">OTP verified</span>
                                                                    <?php
                                                                    }
                                                                    
                                                                    if($value->status == '3'){
            															?>
            															<span class="badge badge-success">Trip Completed</span>
                                                                    <?php
                                                                    }
                                                                    
                                                                    if($value->status == '4'){
            															?>
            															<span class="badge badge-danger">Trip Canceled</span>
                                                                    <?php
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
            															<!-- {{url('sysadmin/edit-user/'.$value->id)}} -->
            															<div class="dropdown-menu">
            																<a class="dropdown-item" href="{{url('sysadmin/trip-details/'.$value->id)}}">View Details</a>
            																<!-- <a class="dropdown-item" href="#">Delete</a> -->
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