<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>Add Coupon</title>
    <!-- GOOGLE FONTS -->
    @include('admin/common/head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <h1>Add Coupon</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>Add Coupon
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="ec-cat-list card card-default mb-24px">
                                <div class="card-body">
                                    <div class="ec-cat-form">

                                        <form action="{{route('add.coupon')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label for="text" class="col-12 col-form-label">Coupon Code</label>
                                                    <div class="col-12">
                                                        <input name="coupon_code" class="form-control here slug-title"
                                                            placeholder="Enter Coupon Code" type="text" required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="text" class="col-12 col-form-label">Coupon Type</label>
                                                    <div class="col-12">
                                                        <select name="coupon_type" class="form-control here slug-title"
                                                            type="text" required>
                                                            <option value="">Select Offer Type</option>
                                                            <option value="Fixed">Fixed</option>
                                                            <option value="Percentage">Percentage</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="text" class="col-12 col-form-label">Discount</label>
                                                    <div class="col-12">
                                                        <input name="discount" class="form-control here slug-title"
                                                            placeholder="Enter Discount" type="text" required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="text" class="col-12 col-form-label">User Type</label>
                                                    <div class="col-12">
                                                        <select name="user_type" class="form-control here slug-title"
                                                            type="text" onchange="select_user_list(this.value)"
                                                            required>
                                                            <option value="">Select Offer Type</option>
                                                            <option value="All">All</option>
                                                            <option value="Selected-User">Selected User</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group showselecteduser  col-12"
                                                    style="display:none;width: 100%;">
                                                    <label for="text" class="col-12 col-form-label">Select Users</label>
                                                    <div class="col-12">
                                                        <select name="selected_user_id[]"
                                                            class="form-control here slug-title multiple-select"
                                                            style="width: 100%;" id="unselectfor" multiple required>
                                                            <?php 
															foreach ($user as $value) {
																?>
                                                            <option value="<?=$value->id?>"><?=$value->name?></option>
                                                            <?php
															}
														?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="text" class="col-12 col-form-label">Coupon Start
                                                        From</label>
                                                    <div class="col-12">
                                                        <input name="coupon_start_from"
                                                            class="form-control here slug-title"
                                                            placeholder="Enter Coupon Start From" type="datetime-local"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="text" class="col-12 col-form-label">Coupon Expires
                                                        On</label>
                                                    <div class="col-12">
                                                        <input name="coupon_expires_on"
                                                            class="form-control here slug-title"
                                                            placeholder="Enter Coupon Expires On" type="datetime-local"
                                                            required>

                                                    </div>
                                                </div>

                                                <div class="form-group col-12">
                                                    <label for="text" class="col-12 col-form-label">Description
                                                    </label>
                                                    <div class="col-12">
                                                        <textarea name="description"
                                                            class="form-control here slug-title"
                                                            placeholder="Enter Description" required></textarea>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button name="submit" type="submit"
                                                        class="btn btn-primary">Submit</button>
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
            $('.multiple-select').select2({
                placeholder: "Select Users",
                allowClear: true
            });
            </script>

            <script>
            function select_user_list(value) {
                if (value == 'Selected-User') {
                    $('.showselecteduser').show();

                    $("#unselectfor > option").attr("selected", false);
                } else {

                    $('.showselecteduser').hide();
                    $("#unselectfor > option").attr("selected", false);
                }
            }
            </script>