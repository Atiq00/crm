      <div class="container">
        <div class="row align-items-center justify-content-md-between">

          <div class="col-md-4">
            <div class="copyright text-left">
              &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="text-primary" target="_blank">{{ setting('site_title') }}</a>.
            </div>
          </div>
          <div class="col-md-4 text-lg-right btn-wrapper">
            @if( !empty($socialLink = setting('social_media_facebook')) )
            <a target="_blank" href="{{ $socialLink }}" rel="nofollow" class="btn-icon-only rounded-circle btn btn-facebook" data-toggle="tooltip" data-original-title="Like us">
              <span class="btn-inner--icon"><i class="fab fa-facebook"></i></span>
            </a>
            @endif
            @if( !empty($socialLink = setting('social_media_instagram')) )
            <a target="_blank" href="{{ $socialLink }}" rel="nofollow" class="btn btn-icon-only btn-instagram rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-instagram"></i></span>
            </a>
            @endif
            @if( !empty($socialLink = setting('social_media_twitter')) )
            <a target="_blank" href="{{ $socialLink }}" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-twitter"></i></span>
            </a>
            @endif
            @if( !empty($socialLink = setting('social_media_youtube')) )
            <a target="_blank" href="{{ $socialLink }}" rel="nofollow" class="btn btn-icon-only btn-youtube rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-youtube"></i></span>
            </a>
            @endif
            @if( !empty($socialLink = setting('social_media_pinterest')) )
            <a target="_blank" href="{{ $socialLink }}" rel="nofollow" class="btn btn-icon-only btn-pinterest rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><i class="fa fa-pinterest"></i></span>
            </a>
            @endif
            @if( !empty($socialLink = setting('social_media_envato')) )
            <a target="_blank" href="{{ $socialLink }}" rel="nofollow" class="btn btn-icon-only btn-slack rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
              <span class="btn-inner--icon"><img src="{{ asset('frontend') }}/img/envato.png" width="15" alt=""></span>
            </a>
            @endif
          </div>

        </div>
      </div>

