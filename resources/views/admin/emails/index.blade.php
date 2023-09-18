@extends('admin.layouts.app', [ 'current_page' => 'email_templates' ])

@section('content')

<style>
    /*div.dataTables_wrapper div.dataTables_filter{
        text-align: left;
    }

    div.dataTables_length{
        text-align: right;
    }*/
</style>

    @include('admin.layouts.headers.cards', ['title' => __('labels.email_templates')])

    <!-- <a href="{{ route('settings.email.sendtestmail') }}" class="btn btn-primary">{{ __('labels.sendtestmail') }}</a> -->
    
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-12 col-md-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'email_templates'])
            </div>
            <div class="col-12 col-md-9">

                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.email_templates') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive pb-3">
                        <table class="table align-items-center table-flush" id="basic-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('labels.id') }}</th>
                                    <th scope="col">{{ __('labels.title') }}</th>
                                    <!-- <th scope="col">{{ __('labels.subject') }}</th> -->
                                    <th scope="col">{{ __('labels.last_update') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($email_templates as $email_template)
                                    
                                    <tr>
                                        <td>
                                            <a href="{{ route('settings.email_templates.edit', $email_template->id) }}">{{$email_template->code}}</a>
                                        </td>
                                        <td class="table-user">
                                            {{ $email_template->title }}
                                        </td>
                                        <td>{{$email_template->updated_at->format( setting('date_format') )}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    @can('settings.email_settings')
                                                        <a class="dropdown-item" href="{{ route('settings.email_templates.edit', $email_template->id) }}">{{ __('labels.edit') }}</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="6">
                                        {{ __('labels.no_data_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                
            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>
@endsection


        @push('js')
        
        @endpush
