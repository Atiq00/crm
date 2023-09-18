@extends('admin.layouts.app', [ 'current_page' => 'language_settings' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.language_settings') ])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'language'])
            </div>
            <div class="col">
                <div class="card shadow">

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.language.store') }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('default_lang') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-default_lang">{{__('labels.default_language') }}</label>
                                    <select name="default_lang" id="input-default_lang" class="form-control" required>
                                        @foreach(getLanguages() as $key => $lang)
                                            <option value="{{ $lang }}" {{ old('default_lang', setting('default_lang'))==$lang ? 'selected' :'' }}>{{$lang}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('default_lang'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('default_lang') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group text-left">
                                    <button type="submit" class="btn btn-info">{{__('labels.update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-8">
                                <h3 class="mb-0">{{ __('labels.available_languages') }}</h3>
                            </div>
                            <div class="col-12 col-md-4 text-right">
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! alert_html('You can manage translations and languages. Check <strong>Documentation</strong> for more info.', 'default') !!}
                    </div>                    
                    
                    <table class="table align-items-center table-flush table-striped align-items-center w-100">
                        <thead>
                            <tr>
                                <th>Language</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(getLanguages() as $lang)
                                <tr>
                                    <td>{{ $lang }}</td>
                                    <td width="10"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>
@endsection


        @push('js')

        <script src="{{ asset('admin') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>

        <script>
            $(document).ready(() => {
                $('#basic-datatable').DataTable();
            });
            $('#upload_image').on('change', (e) => {
                preview_image(e);
            });
        </script>
        @endpush
