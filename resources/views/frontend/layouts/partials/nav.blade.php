<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg {{ $nav_class ?? 'navbar-transparent' }}">
  <div class="container">
    <a class="navbar-brand mr-lg-5" href="{{ route('home') }}">
      <img src="{{ asset('uploads/logo/'.setting('frontend_dark_logo')).'?'.time() }}" class="navbar-logo-dark">
      <img src="{{ asset('uploads/logo/'.setting('frontend_logo')).'?'.time() }}" class="navbar-logo-light">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbar_global">
      <div class="navbar-collapse-header">
        <div class="row">
          <div class="col-6 collapse-brand">
            <a href="index.php">
              <img src="{{ asset('uploads/logo/'.setting('frontend_dark_logo')).'?'.time() }}">
            </a>
          </div>
          <div class="col-6 collapse-close">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
      <ul class="navbar-nav align-items-lg-center ml-lg-auto">
        <li class="nav-item">
          <a href="{{route('knowledge_bases')}}" class="nav-link">
            <span class="nav-link-inner--text">{{ __('frontend.knowledge_base') }}</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('faq')}}" class="nav-link">
            <span class="nav-link-inner--text">{{ __('frontend.faq') }}</span>
          </a>
        </li>
        <li class="nav-item dropdown text-uppercase">
          <a href="#!" class="nav-link"  data-toggle="dropdown" href="#" role="button">
            <span class="nav-link-inner--text"> {{ app()->getLocale() }} </span>
          </a>
          <div class="dropdown-menu dropdown-menu-sm" >
            @foreach(getLanguages() as $lang)
              <a href="{{route('front.set_language', [$lang])}}" class="dropdown-item">
                <span class="nav-link-inner--text">{{ $lang }}</span>
              </a>
            @endforeach
          </div>
        </li>

        @if(Auth::guard('customer')->check())

        <li class="nav-item dropdown">
          <a href="#" class="nav-link profile-image-btn" data-toggle="dropdown" href="#" role="button">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle bg-white">
                <img alt="Image placeholder" src="{{ asset('uploads/customer/'.auth()->guard('customer')->user()->image) }}" class="profile-customer-image">
              </span>
              <div class="media-body  ml-2">
                <span class="mb-0 text-sm font-weight-bold"> &nbsp; {{ auth()->guard('customer')->user()->name }}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu  dropdown-menu-right ">
            <a href="{{route('customer.tickets')}}" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>{{ __('frontend.tickets') }}</span>
            </a>
            <a href="{{route('customer.ticket_new')}}" class="dropdown-item">
              <i data-feather="send" width="17"></i>
              <span>{{ __('frontend.new_ticket') }}</span>
            </a>
            <a href="{{route('customer.profile')}}" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>{{ __('frontend.edit_profile') }}</span>
            </a>
            <a href="{{route('customer.profile_update_password')}}" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>{{ __('frontend.change_password') }}</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#!" class="dropdown-item" onclick="document.getElementById('logout-form').submit()">
              <i class="ni ni-user-run"></i>
              <span>{{ __('frontend.logout') }}</span>
            </a>
          </div>
        </li>
        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
          </form>
        @else

          <li class="nav-item ml-lg-4">
            <a href="{{route('customer.register')}}" class="btn btn-register d-none d-lg-inline-block">
              <span class="btn-inner--icon">
                <i data-feather="user-plus" width="14" stroke-width="1.6"></i> &nbsp;
              </span>
              <span class="nav-link-inner--text">{{ __('frontend.signup') }}</span>
            </a>
            <a href="{{route('customer.login')}}" class="btn btn-login d-none d-lg-inline-block">
              <span class="btn-inner--icon">
                <i data-feather="lock" width="14" stroke-width="1.6"></i> &nbsp;
              </span>
              <span class="nav-link-inner--text">{{ __('frontend.login') }}</span>
            </a>
            <a href="{{route('customer.register')}}" class="nav-link d-block d-lg-none">
              <span class="nav-link-inner--text"><i data-feather="user-plus" width="14" stroke-width="1.6"></i> &nbsp; {{ __('frontend.signup') }}</span>
            </a>
            <a href="{{route('customer.login')}}" class="nav-link d-block d-lg-none">
              <span class="nav-link-inner--text"><i data-feather="lock" width="14" stroke-width="1.6"></i> &nbsp; {{ __('frontend.login') }}</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->