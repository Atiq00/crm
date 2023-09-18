@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-transparent'])

@section('content')
    
    <div class="section section-hero section-shaped section-header">
      <div class="shape shape-style-theme shape-background" style="background-image: url('{{ asset('uploads/'.setting('frontend_home_header'))}}')">
        <div class="shape-overlay bg-gradient-primary opactiy-9"></div>
      </div>
      <div class="page-header">
        <div class="container shape-container text-center py-lg">
          <div class="px-0">
            <h1 class="display-title-home">{!! __('frontend.home_title') !!}</h1>
            <p class="text-white" style="letter-spacing: 2px;">{{ __('frontend.home_subtitle') }}</p>
            
            <br>
            <form action="{{route('search')}}" method="get" id="search_form">
              <div class="search-header mt-4 mb-6">
                <input type="text" autocomplete="off" name="query" class="form-control search-header-input" placeholder="{{ __('frontend.search_placeholder') }}" />
                <a href="#" onclick="$(this).parents('form').submit();"><span class="search-icon"></span></a>
                <p class="text-white text-left pt-3" style="font-style: italic; font-size: .9rem;">{{ __('frontend.home_popular_topics') }}                  @foreach( json_decode(setting('popular_categories')) as $key => $id )
                <a href="{{kb_category_url(\App\Models\KbCategory::find($id))}}">{{\App\Models\KbCategory::find($id)->name }}</a>
                @if($key < count(json_decode(setting('popular_categories')))-1)
                  ,&nbsp;
                @endif
              @endforeach
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon style="fill: #fafafa;" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <div class="section section-blocks">
      <div class="container">
        <h3 class="text-center my-5">{!! __('frontend.home_explore_kb') !!}</h3>
        <div class="row align-items-center">
          @foreach($kb_categories as $kb_category)
          <div class="col-md-4">
            <a href="{{kb_category_url($kb_category)}}">
              <div class="block-info">
                  <div class="block-icon">
                    <img src="{{ decode_icon_url($kb_category->img) }}" alt="">
                  </div>
                  <h5 class="title">{{$kb_category->name}}</h5>
              </div>
            </a>
          </div>
          @endforeach
        </div>
        <div class="text-center pt-5">
          <a href="{{route('kb.all-categories')}}" class="btn btn-primary">{!! __('frontend.view_all') !!}</a>
        </div>
      </div>
    </div>
    <div class="section section-articles">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h3 class="title">{{ __('frontend.popular_articles') }}</h3>
              <ul class="kb-list">
                @foreach($popular_articles as $article)
                  <li><a href="{!!kb_article_url($article)!!}"><span><i class="fa fa-file-text-o"></i></span> {{$article->title}}</a></li>
                @endforeach
              </ul>
          </div>
          <div class="col-md-4">
            <h3 class="title">{{ __('frontend.recent_articles') }}</h3>
              <ul class="kb-list">
                @foreach($recent_articles as $article)
                  <li><a href="{!!kb_article_url($article)!!}"><span><i class="fa fa-file-text-o"></i></span> {{$article->title}}</a></li>
                @endforeach
              </ul>
                
          </div>
          <div class="col-md-4">
            <h3 class="title">{{ __('frontend.helpful_articles') }}</h3>
              <ul class="kb-list">
                @foreach($helpful_articles as $article)
                  <li><a href="{!!kb_article_url($article)!!}"><span><i class="fa fa-file-text-o"></i></span> {{$article->title}}</a></li>
                @endforeach
              </ul>
                
          </div>
        </div>
      </div>
    </div>

    @include('frontend.layouts.partials.block_create_ticket')

@endsection
