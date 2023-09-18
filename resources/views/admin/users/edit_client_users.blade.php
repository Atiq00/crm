@extends('admin.layouts.app', [ 'current_page' => 'client_user' ])

@section('content')

<style> 
</style>

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('client_users') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.users') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.users') ])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.new_user') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('edit_client_user') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>  
                            @endif

                            <div class="row">
                                
                                <div class="form-group col-md-6{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>

                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ @$user->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div> 
								<div class="form-group col-md-6">
                                    <label class="form-control-label" for="input-password-confirmation">HRMSID</label>
                                    <input type="text" name="HRMSID" id="HRMSID" class="form-control " placeholder="HRMSID" value="{{ @$user->HRMSID }}" required>
                                </div>  

                                <div class="form-group col-md-6{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('labels.email') }}</label>
                                    <input autocomplete="new-password" type="email" name="email" id="input-email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.email') }}" value="{{ @$user->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('labels.password') }}</label>
                                    <input autocomplete="new-password" type="password" name="password" id="input-password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.password') }}" value="{{ old('password') }}" >

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('labels.confirm_password') }}</label>
                                    <input autocomplete="new-password" type="password" name="password_confirmation" id="input-password-confirmation" class="form-control " placeholder="{{ __('labels.confirm_password') }}" value="" >
                                </div>
								
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <div class="form-group col-md-5">
                                    <label class="form-control-label" for="upload_image">{{ __('labels.profile_image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="upload_image" lang="en">
                                        <label class="custom-file-label text-left" for="upload_image"><i data-feather="upload" width="15"></i> {{ __('labels.select_file') }}</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-1 ">
                                    <img src="{{ asset('uploads/user/default.png') }}" width="100" id="preview-image" class="rounded-circle" alt="" />
                                </div>
                                <div class="form-group col-md-6{{ $errors->has('projects') ? ' has-danger' : '' }}">
                                    <strong class="form-control-strong" for="input-role">Projects</strong><br>
                                        @foreach($projects as $project)
                                            <label style="padding-left: 20px" class="form-check-label" for="check2">
                                                @php
                                                $checked='';
                                                    if($user->projects){
                                                        foreach($user->projects as $prj){
                                                            if ($prj->id == $project->id) { 
                                                                $checked = "checked";
                                                                break;
                                                            }else{
                                                                $checked = "";
                                                            }
                                                        }
                                                    }
                                                    
                                                @endphp
                                                <input type="checkbox" {{$checked}} class="form-check-input" name="projects[]" value="{{$project->id}}">{{$project->name}} 
                                            </label><br>
                                            @endforeach
                                        @if ($errors->has('designation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('designation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 text-right">
                                    <button type="submit" name="submit" value="client_submit" class="btn btn-info  btn-block mt-4">{{ __('labels.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection
@push('js')
<script>
    $('#upload_image').on('change', (e) => {
        preview_image(e);
    });
</script>
@endpush