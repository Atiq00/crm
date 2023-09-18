@extends('admin.layouts.app', [ 'current_page' => 'roles' ])

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
          <a href="{{ route('roles.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.roles') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.manage_roles') ])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.new_role') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('roles.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
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

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('labels.name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.name') }}" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group permissions-select-wrapper">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input class="custom-control-input" id="setCheckboxPermission-SELECT-ALL" type="checkbox" onchange="selectAllPermissions(this)">
                                        <label class="custom-control-label" for="setCheckboxPermission-SELECT-ALL">{{ __('labels.select_all_permissions') }}</label>
                                      </div>
                                </div>

                                <div class="row permissions-select-wrapper">
                                    @forelse($permissions as $permission)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input class="custom-control-input permission-input-checkbox" id="setCheckboxPermission-{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->name }}">
                                                <label class="custom-control-label" for="setCheckboxPermission-{{ $permission->id }}">{{ $permission->name }}</label>
                                              </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-danger">
                                                <p>{{ __('labels.no_permissions_found') }}</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.submit') }}</button>
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

    window.selectAllPermissions = function (el) {

        $('.permission-input-checkbox').not(el).prop('checked', el.checked);
        
    }

    $('[name=role_type_type]').on('change', function() {

        if(this.value=='Custom'){
            $('.permissions-select-wrapper').show()
        }else{
            $('.permissions-select-wrapper').hide()

        }
        
    })

</script>
@endpush