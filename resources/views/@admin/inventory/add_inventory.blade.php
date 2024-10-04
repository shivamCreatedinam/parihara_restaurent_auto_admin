<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>Add Inventory</title>
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
                        <h1>Add Inventory</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>Add Inventory
                            <span><i class="mdi mdi-chevron-right"></i><a onclick="history.back()"
                                    href="javascript:void(0)">Back</a></span>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="ec-cat-list card card-default mb-24px">
                                <div class="card-body">
                                    <div class="ec-cat-form">

                                        <form action="{{route('add.inventory')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-12 ">
                                                    <label for="text" class="col-12 col-form-label">Select
                                                        Category</label>
                                                    <div class="col-12">
                                                        <select name="category_id" class="form-control here slug-title"
                                                            type="text">
                                                            <option value="">Select Category</option>
                                                            <?php 
															foreach ($category as $key => $value) {
																?>
                                                            <option value="<?=$value->id?>"><?=$value->category_name?>
                                                            </option>
                                                            <?php
															}
															?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group col-12 ">
                                                    <label for="text" class="col-12 col-form-label">Product Name</label>
                                                    <div class="col-12">
                                                        <input name="product_name" class="form-control here slug-title"
                                                            type="text" placeholder="Enter Product Name" />

                                                    </div>
                                                </div>

                                                <div class="form-group col-6 ">
                                                    <label for="text" class="col-12 col-form-label">Quantity</label>
                                                    <div class="col-12">
                                                        <input name="qty" class="form-control here slug-title"
                                                            type="text" placeholder="Enter Quantity" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-6 ">
                                                    <label for="text" class="col-12 col-form-label">Return
                                                        Quantity</label>
                                                    <div class="col-12">
                                                        <input name="return_qty" class="form-control here slug-title"
                                                            type="text" placeholder="Enter Return Quantity" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-6 ">
                                                    <label for="text" class="col-12 col-form-label">Stolen
                                                        Product</label>
                                                    <div class="col-12">
                                                        <input name="stolen_product"
                                                            class="form-control here slug-title" type="text"
                                                            placeholder="Enter Stolen Product" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-6 ">
                                                    <label for="text" class="col-12 col-form-label">Damaged/Expired
                                                        Products</label>
                                                    <div class="col-12">
                                                        <input name="damaged_expired"
                                                            class="form-control here slug-title" type="text"
                                                            placeholder="Enter Damaged/Expired Products" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-12 ">
                                                    <label for="text" class="col-12 col-form-label">Product
                                                        Description</label>
                                                    <div class="col-12">
                                                        <textarea name="description"
                                                            class="form-control here slug-title" type="text"
                                                            placeholder="Enter Description"></textarea>
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