<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title>Add Product</title>
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
                        <h1>Add Product</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span>Add Product
                            <span><i class="mdi mdi-chevron-right"></i><a onclick="history.back()"
                                    href="javascript:void(0)">Back</a></span>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="ec-cat-list card card-default mb-24px">
                                <div class="card-body">
                                    <div class="ec-cat-form">

                                        <form action="{{route('add.product')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-6 ">
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

                                                <!-- <div class="form-group col-6 ">
													<label for="text" class="col-12 col-form-label">Select Attribute</label>
													<div class="col-12">
													<select name="attribute_id" class="form-control here slug-title" type="text" >
															<option value="">Select Attribute</option>
															<?php 
															foreach ($attributes as $key => $value) {
																?>
																<option value="<?=$value->id?>"><?=$value->attribute_title?></option>
																<?php
															}
															?>
														</select>
													</div>
												</div> -->
                                                <div class="form-group col-12 ">
                                                    <label for="text" class="col-12 col-form-label">Product Name</label>
                                                    <div class="col-12">
                                                        <input name="product_name" class="form-control here slug-title"
                                                            type="text" placeholder="Enter Product Name" />

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
                                            <!-- new code  -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Select Attribute</label>
                                                        <select class="form-control" style="width: 100%;"
                                                            name="size1[]">
                                                            <option> Select Attribute </option>
                                                            <?php 
															foreach ($attributes as $key => $value) {
																?>
                                                            <option value="<?=$value->id?>"><?=$value->attribute_title?>
                                                            </option>
                                                            <?php
															}
															?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>MRP</label>
                                                        <input type="text" class="form-control" name="mrp1[]"
                                                            placeholder="MRP" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
													<label>Discount %</label>
                                                        <input name="discount1[]" class="form-control here slug-title"
                                                            type="text" placeholder="Enter Discount" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Saling Price</label>
                                                        <input type="text" class="form-control" name="sp_price1[]"
                                                            placeholder="Saling Price" required="">
                                                    </div>
                                                </div>
												<div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Quantity</label>
                                                        <input name="qty1[]" class="form-control here slug-title"
                                                            type="text" placeholder="Enter Quantity" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label> </label> <br>

                                                        <a href="javascript:void(0);" class="add"><span
                                                                class="glyphicon glyphicon-plus">Add this</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="contents"> </div>
                                            <div class="form-group row">
                                                <label for="text" class="col-12 col-form-label">Image</label>
                                                <div class="col-12">
                                                    <input type="file" name="Image[]" multiple
                                                        class="form-control btn-primary" id="uploadImage"
                                                        onchange="PreviewImage();" required
                                                        accept="image/gif, image/jpeg, image/png" />
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
													<img id="uploadPreview" style="width: 80px; display: none;" />
												</div> -->
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script type="text/javascript">
            $('#contents').on('click', '.rem', function() {
                $(this).parent().prevUntil(".col-md-1").remove();
                $(this).parent().remove();
            });

            $(document).ready(function() {
                // $(".add").click(function() {
                $(document).on('click', '.add', function() {
                    var att = '';
                    att +=
                        '<div class="row"><div class="col-md-2"><div class="form-group"><label>Select Attribute</label><select class="form-control" name="size1[]" style="width: 100%;"><option value=""> Select Attribute </option>';
                    att +=
                        '<?php foreach ($attributes as $key => $value) { ?> <option value="<?=$value->id?>"><?=$value->attribute_title?></option><?php } ?>';
                    att +=
                        '</select></div></div>';
                    att +=
                        '<div class="col-md-2"><div class="form-group"><label>MRP</label><input type="text" class="form-control" name="mrp1[]"  placeholder="MRP" required="" ></div></div> <div class="col-md-2"><div class="form-group"><label>Discount %</label><input name="discount1[]" class="form-control here slug-title" type="text" placeholder="Enter Discount" /></div></div><div class="col-md-2"><div class="form-group"><label>Saling Price</label><input type="text" class="form-control" name="sp_price1[]"  placeholder="Saling Price" required="" ></div></div><div class="col-md-2"><div class="form-group"><label>Quantity</label><input name="qty1[]" class="form-control here slug-title" type="text" placeholder="Enter Quantity" /></div></div><div class="col-md-1"><span class="rem" ><a href="javascript:void(0);" >Remove</span><hr></div></div>';
                    $('#contents').append(att);
                });
            });
            </script>
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