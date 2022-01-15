@extends('layouts.backend.app')

@push('css')
    <!-- Select2 --->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush


@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Profile</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('app.profile.update')}}" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-md-12">
                    <div class="main-card mb-3 card">


                        <div class="card-body">
                            <h5 class="card-title">Profile Photo</h5>



                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" @isset($user) class="form-control @error('image') is-invalid @enderror" @endisset id="image">

                                @error('image')
                                <p class="p-2">
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </p>
                                @enderror
                            </div>

                            <div class="form-group" style="text-align: center;">
                                <img id="showImage" src="{{!empty(Auth::user()->image)?url('/uploads/user_images/'.Auth::user()->image):url('/uploads/no_image.jpg')}}" height="300px" width="300px;" alt="Card image cap"/>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Manage User</h5>

                            <div class="form-group">
                                <label for="name">User Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" autofocus>

                                @error('name')
                                <p class="p-2">
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" autofocus>

                                @error('email')
                                <p class="p-2">
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-arrow-circle-up"></i>
                                <span>Update</span>
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </form>
    </div>
</div>
@endsection

@push('js')

    <!-- Select 2 --->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <!-- Dropify -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e)
                {
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush

