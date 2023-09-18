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
                        <form method="post" action="{{ route('projects.update', $project->id) }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input  type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? 
									' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name', $project->name) }}" 
										   required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('project_code') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Product Code</label>
                                    <input type="text" disabled name="project_code" id="project_code" class="form-control 
									{{ $errors->has('project_code') ? ' is-invalid' : '' }}" placeholder="Product ID" 
								    value="{{ old('project_code',$project->project_code) }}" required autofocus>
                
                                    @if ($errors->has('project_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('project_code') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                 <!--<div class="form-group{{ $errors->has('hours') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Hours</label>
                                    <input type="text" name="hours" id="hours" class="form-control {{ $errors->has('hours') ? ' is-invalid' : '' }}" placeholder="Product ID" value="{{ old('hours',$project->hours) }}" required autofocus>
                
                                    @if ($errors->has('hours')) 
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('hours') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('seats') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Seats</label>
                                    <input type="text" name="seats" id="seats" class="form-control {{ $errors->has('seats') ? ' is-invalid' : '' }}" placeholder="Product ID" value="{{ old('seats',$project->seats) }}" required autofocus>
                
                                    @if ($errors->has('seats'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('seats') }}</strong>
                                        </span>
                                    @endif
                                </div>-->
                



                                <div class="form-group{{ $errors->has('client') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-client">Select Client</label>
                                    <select name="client_id" id="input-client" class="form-control"  >
                                        <option value=''>Select client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" 
											{{ old('client_code', $client->client_code)==$project->client->client_code ? 'selected' :'' }}>
												{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                     
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.update') }}</button>
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
