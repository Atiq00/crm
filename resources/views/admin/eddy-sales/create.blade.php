@extends('admin.layouts.app', [ 'current_page' => 'user' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('eddyusers') }}" class="btn btn-sm btn-icon btn-neutral">
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
                        <form method="post" action="{{ route('eddyuserCreate') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
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

                            <div class="  row"> 
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-md-4">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
								
								
								<div class="form-group col-md-4">
                                    <label class="form-control-label" for="input-password-confirmation">HRMSID</label>
                                    <input type="text" name="HRMSID" id="HRMSID" class="form-control " placeholder="HRMSID" value="{{ old('HRMSID') }}" required>
                                    @if ($errors->has('HRMSID'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('HRMSID') }}</strong>
                                        </span>
                                    @endif
                                </div> 
                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="input-password-confirmation">Agent ID</label>
                                    <input type="text" name="agent_name" id="agent_name" class="form-control " placeholder="Agent ID" value="{{ old('agent_name') }}" required>
                                    @if ($errors->has('agent_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('agent_name') }}</strong>
                                        </span>
                                    @endif
                                </div> 
                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="input-password-confirmation">Pesudo Name</label>
                                    <input type="text" name="psedo_name" id="psedo_name" class="form-control " placeholder="Pesudo Name" value="{{ old('psedo_name') }}" required>
                                    @if ($errors->has('psedo_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('psedo_name') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                
                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="input-password-confirmation">Type</label>
                                    <select required name="type" id="" class="form-control">
                                        <option value="">--Select--</option>
                                        <option value="InBound">In-Bound</option>
                                        <option value="OutBound">Out-Bound</option>
                                        <option value="EddyEdu">EddyEdu</option>
                                        <option value="EducationFirst">EducationFirst</option>
                                    </select>
                                     
                                </div> 
								   
                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="input-password-confirmation">&nbsp;</label>
                                    <button type="submit" name="submit" value="submit" class="btn btn-info btn-block  ">{{ __('labels.submit') }}</button>
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