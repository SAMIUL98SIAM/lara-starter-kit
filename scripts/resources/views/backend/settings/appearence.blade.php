@extends('layouts.backend.app')

@push('css')
    <link rel="stylesheet" href="{{asset('backend/dropify/sass/dropify.scss')}}">
    <link rel="stylesheet" href="{{asset('backend/dropify/sass/demo.scss')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush


@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-settings icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Appearence Settings</div>
        </div>
        <div class="page-title-actions">
            <a href="{{url('app/dashboard')}}" type="button" class="btn-shadow mr-3 btn btn-primary"><i class="fas fa-backspace"></i> Back</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        @include('backend.settings.sidebar')
    </div>

    <div class="col-md-9">
        {{-- how to use callout --}}
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">How To Use:</h5>
                <p>You can get the value of each setting anywhere on your site by calling <code>setting('key')</code></p>
            </div>
        </div>
        <!-- form start -->
        <form autocomplete="off" role="form" method="POST" action="{{ route('app.settings.appearence.update') }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- general form elements -->
            <div class="main-card mb-3 card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="site_logo">Logo (Only Image are allowed) <code>{ key: site_logo }</code></label>
                        <input type="file" name="site_logo" id="site_logo"
                               class="dropify @error('site_logo') is-invalid @enderror"
                               data-default-file="{{ setting('site_logo') != null ?  Storage::url(setting('site_logo')) : '' }}">
                        @error('site_logo')
                            <span class="text-danger" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <img id="showSite_logo" src="{{!empty($user->image)?url('/uploads/user_images/'.$user->image):url('/uploads/no_image.jpg')}}" height="150px" width="130px;" alt="Card image cap"/>
                    </div> --}}


                    <div class="form-group">
                        <label for="site_favicon">Favicon (Only Image are allowed, Size: 33 X 33) <code>{ key: site_favicon }</code></label>
                        <input type="file" name="site_favicon" id="site_favicon"
                               class="dropify @error('site_favicon') is-invalid @enderror"
                               data-default-file="{{ setting('site_favicon') != null ?  Storage::url(setting('site_favicon')) : '' }}">
                        @error('site_favicon')
                            <span class="text-danger" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-circle-up"></i>
                        <span>Update</span>
                    </button>

                </div>
            </div>
            <!-- /.card -->
        </form>
    </div>
</div>
@endsection

@push('js')
    <script src="{{asset('backend/dropify/js/dropify.js')}}"></script>
    <!-- Dropify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('.dropify').dropify();
    </script>
@endpush

