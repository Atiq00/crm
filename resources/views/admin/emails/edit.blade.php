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
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-3">
                @include('admin.settings.partials.sidebar', ['settingSidebarActive' => 'email_templates'])
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('labels.email_templates') }}</h3>
                            </div>
                            <div class="col-4 text-right">

                                <a href="{{route('settings.email_templates')}}" class="btn btn-sm btn-icon btn-neutral"> <i data-feather="arrow-left" stroke-width="3" width="12"></i> &nbsp; {{__('labels.email_templates')}}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('settings.email_templates.update', [$template->id]) }}" id="my-form" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('subject') ? ' has-danger' : '' }}">
                                    <input type="text" name="subject" id="input-subject" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" value="{{ old('subject', $template->subject) }}">

                                    @if ($errors->has('subject'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('body') ? ' has-danger' : '' }}">
                                    <textarea name="body" id="input-body" class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" rows="5">{{ old('body', $template->body) }}</textarea>

                                    @if ($errors->has('body'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                @switch($template->code)

                                    @case("forget_password")

                                        <div class="form-group">
                                            <p class="text-muted text-sm">Shortcodes: <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{reset_link}}" ?></span></p>
                                        </div>
                                    @break

                                    @case("agent_send_ticket_auto_assigned")

                                        <div class="form-group">
                                            <p class="text-muted text-sm">Shortcodes: <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{ticket_title}}" ?></span>  <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{ticket_description}}" ?></span>   <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{ticket_agent_url}}" ?></span></p>
                                        </div>
                                    @break

                                    @case("customer_send_ticket_created")

                                        <div class="form-group">
                                            <p class="text-muted text-sm">Shortcodes: <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{ticket_title}}" ?></span>  <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{ticket_description}}" ?></span> <span class="badge badge-secondary" style="text-transform: none;"><?php echo "{{ticket_customer_url}}" ?></span>  </p>
                                        </div>
                                    @break

                                @endswitch

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{__('labels.update') }}</button>
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

        <script src="{{ asset('admin') }}/vendor/ckeditor/ckeditor.js"></script>
<script>
    $(document).ready(() => {
        CKEDITOR.replace('input-body', {
            height: 260,
            width: "100%",
            filebrowserUploadUrl: '{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod:  "form"
        });
    });
</script>
        @endpush
