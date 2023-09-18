@extends('admin.layouts.app', [ 'current_page' => 'projects' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('projects.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> Back</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' =>  "Projects"])

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ "Edit"}}</h3>
                            </div>
                        </div>
                    </div>  
                    <div class="card-body">
                        <form method="post" action="{{ route('projects.store') }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('post')
        
                            <div class="pl-lg-4 row">
                                <div class="col-md-4 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
        
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
        
                                <div class="col-md-4 form-group{{ $errors->has('project_code') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Project Code</label>
                                    <input type="text" name="project_code" value="{{$code}}"  readonly id="project_code" class="form-control {{ $errors->has('project_code') ? ' is-invalid' : '' }}" placeholder="Project Code" value="{{ old('project_code') }}" required autofocus>
        
                                    @if ($errors->has('project_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('project_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
        
                                <div class="col-md-4 form-group{{ $errors->has('client') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-client">client</label>
                                    <select name="client_id" id="input-client" class="form-control" data-toggle="select"  required>
                                        <option value="">Select client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id')==$client->id ? 'selected' :'' }}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('client_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('client_id') }}</strong>
                                        </span>
                                    @endif
                               </div>

                               <div class="col-md-4 form-group{{ $errors->has('pro_real_name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">Project Real Name</label>
                                <input type="text" name="pro_real_name" id="pro_real_name" class="form-control {{ $errors->has('pro_real_name') ? ' is-invalid' : '' }}" placeholder="Project Real Name" value="{{ old('pro_real_name') }}" required autofocus>
    
                                @if ($errors->has('pro_real_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pro_real_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                               
        
                                <div class="col-md-4 form-group text-left">
                                    <button type="submit" class="btn btn-info mt-4 form-control">{{ __('labels.submit') }}</button>
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
    $(document).ready(() => {
        $('#basic-datatable').DataTable();
    });
</script>
<form action="#" method="post" id="FORM_DELETE">
    @csrf
    @method('DELETE')
</form>
@endpush
