<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>Edit User</title>
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
                            <h1>User Profile</h1>
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
                                                <img src="{{asset($data->user_image)}}" alt="user image">
                                            </div>
                                            <div class="card-body">
                                                <h4 class="py-2 text-dark">{{$data->name}}</h4>
                                                <h4 class="py-2 text-dark">{{$data->user_id}}</h4>

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
                                                aria-controls="settings" aria-selected="false">Settings</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                                        <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="tab-widget mt-5">
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="media widget-media p-3 bg-white border">
                                                            <div class="icon rounded-circle mr-3 bg-primary">
                                                                <i class="mdi mdi-cart-outline text-white "></i>
                                                            </div>

                                                            <div class="media-body align-self-center">
                                                                <h4 class="text-primary mb-2">{{$orders_count}}</h4>
                                                                <p>Orders</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4">
                                                        <div class="media widget-media p-3 bg-white border">
                                                            <div class="icon rounded-circle bg-warning mr-3">
                                                                <i class="mdi mdi-cart-outline text-white "></i>
                                                            </div>

                                                            <div class="media-body align-self-center">
                                                                <h4 class="text-primary mb-2">{{$wishlist}}</h4>
                                                                <p>Wishlist</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4">
                                                        <div class="media widget-media p-3 bg-white border">
                                                            <div class="icon rounded-circle mr-3 bg-success">
                                                                <i class="mdi mdi-diamond-stone text-white "></i>
                                                            </div>

                                                            <div class="media-body align-self-center">
                                                                <h4 class="text-primary mb-2">{{$orders_sum}}</h4>
                                                                <p>Purchase Amount</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-12">

                                                        <!-- Notification Table -->
                                                        <div class="card card-default mb-24px">
                                                            <div class="card-header justify-content-between mb-1">
                                                                <h2>Latest Notifications</h2>
                                                                <div>
                                                                    <button class="text-black-50 mr-2 font-size-20"><i
                                                                            class="mdi mdi-cached"></i></button>
                                                                    <div
                                                                        class="dropdown show d-inline-block widget-dropdown">
                                                                        <a class="dropdown-toggle icon-burger-mini"
                                                                            href="#" role="button"
                                                                            id="dropdown-notification"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            data-display="static"></a>
                                                                        <ul class="dropdown-menu dropdown-menu-right"
                                                                            aria-labelledby="dropdown-notification">
                                                                            <li class="dropdown-item"><a
                                                                                    href="#">Action</a></li>
                                                                            <li class="dropdown-item"><a
                                                                                    href="#">Another action</a></li>
                                                                            <li class="dropdown-item"><a
                                                                                    href="#">Something else here</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="card-body compact-notifications" data-simplebar
                                                                style="height: 434px;">
                                                                <?php
                                                                if (count($logs)  > 0) {
                                                                    foreach ($logs as $value) {
                                                                       ?>
                                                                         <div
                                                                    class="media pb-3 align-items-center justify-content-between">
                                                                    <div
                                                                        class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                                                                        <i
                                                                            class="mdi mdi- font-size-15" style="font-size: 15px;"></i>
                                                                    </div>
                                                                    <div class="media-body pr-3 ">
                                                                        <a class="mt-0 mb-1 text-dark"
                                                                            href="javascript:void(0)"><strong>{{$value->titles}}</strong></a>
                                                                        <p style="font-size:12px;">{{$value->remark}}</p>
                                                                    </div>
                                                                    <span class=" font-size-12 d-inline-block"><i
                                                                            class="mdi mdi-clock-outline"></i><?php echo date('d, M Y',strtotime($value->created_date)).", ".$value->created_time;?></span>
                                                                </div>
                                                                       <?php
                                                                    }
                                                                }else{
                                                                        echo 'Notification not found.';
                                                                }
                                                                ?>
                                                              
																
                                                               
                                                            </div>
                                                            <div class="mt-3"></div>
                                                        </div>

                                                    </div>

                                                    <div class="col-12">
                                                        <!-- Recent Order Table -->
                                                        <div class="card card-default card-table-border-none ec-tbl"
                                                            id="">
                                                            <div class="card-header justify-content-between">
                                                                <h2>Orders</h2>

                                                                <div class="date-range-report">
                                                                    <span></span>
                                                                </div>
                                                            </div>

                                                            <div class="card-body pt-0 pb-0 table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.No</th>
                                                                            <th>Order Number</th>
                                                                            <th>Amount</th>
                                                                            <th>Slot</th>
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
																			<td>{{$value->selected_slot}}</td>
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

                                        <div class="tab-pane fade" id="settings" role="tabpanel"
                                            aria-labelledby="settings-tab">
                                            <div class="tab-pane-content mt-5">
                                                <form>
                                                   


                                                    <div class="form-group mb-4">
                                                        <label for="userName">User name</label>
                                                        <input type="text" class="form-control" id="userName"
                                                            value="{{$data->name}}" readonly>

                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="userName">Mobile</label>
                                                        <input type="text" class="form-control" id="userName"
                                                            value="{{$data->mobile}}" readonly>

                                                    </div>

                                                    <div class="form-group mb-4">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email"
                                                            value="{{$data->email}}" readonly>
                                                    </div>

                                                   

                                                    <div class="d-flex justify-content-end mt-5">
                                                        <!-- <button type="submit"
                                                            class="btn btn-primary mb-2 btn-pill">Update
                                                            Profile</button> -->
                                                    </div>
                                                </form>
                                            </div>
											<div class="tab-pane-content mt-5">
											<div class="card-header justify-content-between">
                                                    <h2>Address List</h2>
                                            </div>					

											<div class="card-body pt-0 pb-0 table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>S.No</th>
                                                                            <th>Name</th>
                                                                            <th>Mobile</th>
                                                                            <th>House No</th>
                                                                            <th>Appartment</th>
                                                                            <th>City</th>
                                                                            <th>State</th>
                                                                            <th>Pincode</th>
																			<th>Type</th>
																			<th>Date</th>
                                                                          
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <?php 
																		$x=1;
																		foreach ($address as $value) {
																			?>
                                                                        <tr>
                                                                            <td>{{$x++}}</td>
                                                                            <td>{{$value->full_name}}</td>
																			<td>{{$value->mobile}}</td>
																			<td>{{$value->house_no}}</td>
																			<td>{{$value->appartment}}</td>
																			<td>{{$value->city}}</td>
																			<td>{{$value->state}}</td>
                                                                            <td>{{$value->pincode}}</td>
																			<td>{{$value->address_type}}</td>
																			<td>{{$value->created_date}}</td>
                                                                           
                                                                            
                                                                            
                                                                            
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