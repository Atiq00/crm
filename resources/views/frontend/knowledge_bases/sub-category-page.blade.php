@extends('frontend.layouts.app', ['body_class' => 'bg-default'])

@section('content')

<div class="section-page-header bg-gradient-primary shadow text-center pt-9 pb-6 mb-6">
  <div class="container d-flex align-items-center">
    <div class="row w-100">
      <div class="col">
        <h1 class="display-title-home text-white">{{$kb_sub_category->name}}</h1>
      </div>
    </div>                

  </div>
</div>

<div class="container">

          <div class="row align-items-center">
            <div class="col-12 col-md-6">
              <!-- <h1 class="display-title-home">Knowledge Base</h1> -->
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('frontend.home') }}</a></li>
                  <li class="breadcrumb-item"><a href="{{route('knowledge_bases')}}"> {{ __('frontend.knowledge_base') }}</a></li>
                  <li class="breadcrumb-item"><a href="{{ kb_category_url($kb_category) }}">{{$kb_category->name}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$kb_sub_category->name}}</li>
                </ol>
              </nav>
            </div>
          
            <div class="col-12 col-md-6">
              <div class="search-header pull-right">
                <input type="text" name="search" class="form-control search-header-input" placeholder="{{ __('frontend.search_placeholder') }}" />
                <a href="#"><span class="search-icon"></span></a>
              </div>
            </div>
          </div>                

        <div class="row mt-4">
          <div class="col-12 col-md-3">

            <div class="list-group category-list-group">
              @foreach($kb_category->sub_categories as $sub_category)
                <a href="{{kb_sub_category_url($sub_category)}}" class="list-group-item list-group-item-action {{ $sub_category->id==$kb_sub_category->id ? 'active' : '' }}"><i class="fa fa-folder"></i> &nbsp; {{$sub_category->name}}</a>
              @endforeach
            </div>

          </div>
          <div class="col">

            <div class="card shadow-light section-kb-list ">
              <div class="card-body px-0 pt-3">
                <h5 class="py-3 px-4"><i class="fa fa-folder"></i> &nbsp; {{ $kb_sub_category->name }} <span class="text-theme"> ({{$kb_articles->count()}})</span></h5>
                <hr class="my-3">
                <ul class="kb-list px-4">
                  @foreach($kb_articles->get() as $article)
                    <li><a href="{{ kb_article_url($article) }}" class="py-2"><span><i class="fa fa-file-text-o"></i></span> {{$article->title}}</a></li>
                  @endforeach
                </ul>
              </div>
          </div>

        </div>

      </div>

@include('frontend.layouts.partials.block_create_ticket')
</div>

@endsection


