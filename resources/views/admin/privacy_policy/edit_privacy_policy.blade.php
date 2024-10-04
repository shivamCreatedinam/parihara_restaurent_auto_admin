<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard">
    <title> Privacy Policy</title>
    <!-- GOOGLE FONTS -->
    @include('admin/common/head')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
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
                    <div class="breadcrumb-wrapper breadcrumb-wrapper-2 breadcrumb-contacts">
                        <h1> Privacy Policy</h1>
                        <p class="breadcrumbs"><span><a href="{{url('sysadmin/dashboard')}}">Home</a></span>
                            <span><i class="mdi mdi-chevron-right"></i></span> Privacy Policy
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="ec-cat-list card card-default mb-24px">
                                <div class="card-body">
                                    <div class="ec-cat-form">

                                        <form action="{{route('edit.privacy_policy')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="text" class="col-12 col-form-label">Content</label>
                                                <div class="col-12">
                                                    <textarea id="editor" name="contents"
                                                        class="form-control here slug-title" type="text"
                                                        placeholder="Enter Content">{{$data->contents}}</textarea>
                                                    @if($errors->has('contents'))
                                                    <div class="text-danger">{{ $errors->first('contents') }}</div>
                                                    @endif
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
                                                <label for="text" class="col-12 col-form-label">Updated On</label>
                                                <div class="col-12">
                                                   <input type="text" name="" value="{{$data->updated_at}}" id="" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="hidden" name="hiddenid" value="{{$data->id}}" required>
                                                    <button name="submit" type="submit"
                                                        class="btn btn-primary">Update</button>
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
            <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
            </script>