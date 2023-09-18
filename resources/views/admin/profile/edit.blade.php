@extends('admin.layouts.app', ['title' => __('User Profile')])

@section('content')

    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url(../admin/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-7">
                <h1 class="display-2 text-white">{{ __('labels.hello') }} <strong> {{ ucfirst(auth()->user()->name) }} </strong> </h1>
            </div>
        </div>
    </div>
</div> 


    <style>

        .modal-upload img {
          display: block;
          max-width: 100%;
        }
        .modal-upload .preview {
          overflow: hidden;
          width: 160px; 
          height: 160px;
          margin: 10px;
          border: 1px solid #eee;
          border-radius: 50%;
          box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
        }
        .modal-upload.modal-lg{
          max-width: 1000px !important;
        }

.form-text{
    font-size: .8rem;
}
    </style>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 order-lg-2 pb-7">
                            <div class="card-profile-image">
                                <a href="#!"  onclick="$('#upload_image').trigger('click');">
                                    <img src="{{ asset('uploads/user/'.auth()->user()->image) }}" class="rounded-circle profile-user-image shadow-lg">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="text-center">
                            <h3>
                                {{ auth()->user()->name }}
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ auth()->user()->roles[0]->name }}
                            </div>
                            <h3 class=" d-none">{{ __('frontend.change_profile_image') }}</h3>
                            <form action="" id="form-upload-image">
                                <div class="custom-file d-none">
                                    <input type="file" class="custom-file-input" id="upload_image" lang="en">
                                    <label class="custom-file-label text-left" for="upload_image"><i data-feather="upload" width="15"></i> Select file</label>
                                </div>
                            </form>
                            <a href="#!" class="btn btn-info my-4" onclick="$('#upload_image').trigger('click');"> <i data-feather="upload" width="15"></i> &nbsp;&nbsp; {{ __('frontend.change_profile_image') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-white shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('frontend.edit_profile') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('labels.user_info') }}</h6>
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('labels.email') }}</label>
                                    <input type="email" readonly name="email" id="input-email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">{{ __('labels.update') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('labels.password') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('labels.current_password') }}</label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                                    
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('labels.new_password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.new_password') }}" value="" required>
                                    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('labels.confirm_new_password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control " placeholder="{{ __('labels.confirm_new_password') }}" value="" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">{{ __('labels.change_password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('admin.layouts.footers.auth')
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-upload modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">{{ __('frontend.change_profile_image') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
                <div class="row">
                    <div class="col-md-8">
                        <img id="image" src="https://via.placeholder.com/200" >
                    </div>
                    <div class="col-md-4">
                        <div class="preview"></div>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('labels.cancel') }}</button>
            <button type="button" class="btn btn-success" id="crop">{{ __('labels.update') }}</button>
          </div>
        </div>
      </div>
    </div>

    @push('js')

    <script src="{{ asset('admin') }}/vendor/cropperjs/cropper.js"></script>

    <script>  

        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        
        $("body").on("change", "#upload_image", function(e){
            var files = e.target.files;
            var done = function (url) {
            image.src = url;
            $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                done(reader.result);
                };
                reader.readAsDataURL(file);
            }
            }
        });


        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
            aspectRatio:1,
            viewMode: 2,
            preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
        });

        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob); 
                reader.onloadend = function() {
                    var base64data = reader.result; 

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "profile/upload-image",
                        data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'image': base64data},
                        success: function(data){
                            $modal.modal('hide');
                            $('.profile-user-image').attr('src' , data.url);
                            $('#form-upload-image').trigger('reset');

                        }
                    });
                }
            });
        })



     $("#my-form").parsley({
       errorClass: 'is-invalid text-danger',
       successClass: 'is-valid',
       errorsWrapper: '<span class="form-text text-danger"></span>',
       errorTemplate: '<span></span>',
       trigger: 'change'
     });
     
    </script>

    @endpush


@endsection