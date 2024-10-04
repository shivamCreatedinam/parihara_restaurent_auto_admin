<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">

    <title>Home Manager</title>

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
                            <h1>Home Manager List</h1>
                            <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                                <span><i class="mdi mdi-chevron-right"></i></span>Home Manager List
                            </p>
                        </div>
                        <div>




                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="ec-cat-list card card-default">
                                <div class="card-body">

                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-home" type="button" role="tab"
                                                aria-controls="pills-home" aria-selected="true">Manage Slider</button>
                                        </li>
                                        <!--<li class="nav-item" role="presentation">-->
                                        <!--    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"-->
                                        <!--        data-bs-target="#pills-profile" type="button" role="tab"-->
                                        <!--        aria-controls="pills-profile" aria-selected="false">Manage-->
                                        <!--        Banner</button>-->
                                        <!--</li>-->

                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                            aria-labelledby="pills-home-tab" tabindex="0">
                                            <a href="{{url('sysadmin/add-slider')}}"><button type="button"
                                                    class="btn btn-success"> Add Slider
                                                </button></a>
                                            <div class="table-responsive">
                                                <table id="responsive-data-table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Thumb</th>
                                                            <th>Title</th>
                                                            <th>Created Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php 
                                                foreach ($data as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><img class="cat-thumb" src="{{asset($value->image)}}"
                                                                    alt="" /></td>
                                                            <td><?=$value->title?></td>
                                                            <td><?=$value->created_at?></td>
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
                                                                        <a class="dropdown-item"
                                                                            href="{{url('sysadmin/edit-slider/'.$value->id)}}">Edit</a>
                                                                        <a class="dropdown-item"
                                                                            href="{{url('sysadmin/delete-slider/'.$value->id)}}"
                                                                            onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                }
                                                ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                            <a href="{{url('sysadmin/add-banner')}}"><button type="button"
                                                    class="btn btn-success"> Add Banner
                                                </button></a>
                                            <div class="table-responsive">
                                                <table id="responsive-data-table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Thumb</th>
                                                            <th>Title</th>
                                                            <th>Created Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php 
                                                foreach ($banner as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><img class="cat-thumb" src="{{asset($value->image)}}"
                                                                    alt="" /></td>
                                                            <td><?=$value->title?></td>
                                                            <td><?=$value->created_at?></td>
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
                                                                        <a class="dropdown-item"
                                                                            href="{{url('sysadmin/edit-banner/'.$value->id)}}">Edit</a>
                                                                        <a class="dropdown-item"
                                                                            href="{{url('sysadmin/delete-banner/'.$value->id)}}"
                                                                            onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
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
                </div> <!-- End Content -->
            </div> <!-- End Content Wrapper -->

            @include('admin/common/footer')