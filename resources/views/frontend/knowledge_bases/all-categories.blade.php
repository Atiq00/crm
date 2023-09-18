@extends('frontend.layouts.app', ['body_class' => 'bg-default', 'nav_class' => 'navbar-transparent'])

@section('content')
    
    
<div class="section-page-header bg-gradient-primary shadow text-center pt-9 pb-6 mb-6">
  <div class="container d-flex align-items-center">
    <div class="row w-100">
      <div class="col">
        <h1 class="display-title-home text-white">{!! __('frontend.home_explore_kb') !!}</h1>
      </div>
    </div>                

  </div>
</div>


    <div class="section section-blocks">
      <div class="container">
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

      </div>
    </div>

    @include('frontend.layouts.partials.block_create_ticket')

@endsection
