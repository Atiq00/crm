<div class="row align-items-center justify-content-xl-between text-center">
    <div class="col-lg-6">
        <div class="copyright text-left text-xl-left text-muted">
            &copy; {{ now()->year }} <a href="{{ url('/admin') }}" class="font-weight-bold ml-1">{{ setting('site_title') }}</a> 
        </div>
    </div>
    <div class="col-lg-6">
        <div class="copyright text-right text-xl-right text-muted">
           v{{ setting('ultimatedesk_version') }} 
        </div>
    </div>
</div>