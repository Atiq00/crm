@extends('frontend.layouts.app', ['body_class' => 'bg-default'])

@section('content')

<div class="section-page-header bg-gradient-primary shadow text-center pt-9 pb-6 mb-6">
  <div class="container d-flex align-items-center">
    <div class="row w-100">
      <div class="col">
        <h1 class="display-title-home text-white">{{$kb_category->name}}</h1>
      </div>
    </div>                

  </div>
</div>

<div class="container">

          <div class="row align-items-center">
            <div class="col-12 col-md">
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('frontend.home') }}</a></li>
                  <li class="breadcrumb-item"><a href="{{route('knowledge_bases')}}">{{ __('frontend.knowledge_base') }}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$kb_category->name}}</li>
                </ol>
              </nav>
            </div>
            <div class="col-12 col-md-8">
              <div class="search-header pull-right">
                <input type="text" name="search" class="form-control search-header-input" placeholder="{{ __('frontend.search_placeholder') }}" />
                <a href="#"><span class="search-icon"></span></a>
              </div>
            </div>
          </div>   


        <div class="row">
          <div class="col">

      <div class="section section-page section-kb-list py-3 pb-5" data-spy="scroll" data-target="#kb-list" data-offset="0">

        <div class="row">

          @foreach($kb_category->sub_categories as $sub_category)
          <?php $kb_articles = \App\Models\KnowledgeBase::where('sub_category_id', $sub_category->id); $total = $kb_articles->count();  ?>
            <div class="col-md-4 py-3">
              <h4 class="sub-title pt-0 mt-0"><a href="{{kb_sub_category_url($sub_category)}}"class="text-primary"><i class="fa fa-folder"></i> &nbsp; {{$sub_category->name}} &nbsp;&nbsp;({{$total}})</a></h4>
                <ul class="kb-list pl-3">
                  @foreach($kb_articles->limit(5)->get() as $article)
                    <li><a href="{{ kb_article_url($article) }}"><span><i class="fa fa-file-text-o"></i></span> {{$article->title}}</a></li>
                  @endforeach
                  @if($total>=5)
                    <li><a href="#" class="color-theme"> {{ __('frontend.see_all_articles', [ 'TOTAL' => $total ]) }} </a></li>
                  @endif
                </ul>
                  
            </div>
          @endforeach
        </div>


        <?php $kb_articles = \App\Models\KnowledgeBase::where('category_id', $kb_category->id)->whereNull('sub_category_id')->orderBy('id', 'desc'); $total = $kb_articles->count();  ?>

        @if($total > 0)
        <div class="row">
          <div class="col-md-12 mt-3">
            <h4 class="sub-title text-primary pt-0"><i class="fa fa-folder"></i> &nbsp; {{$kb_category->name}} &nbsp;&nbsp;({{$total}})</a></h4>
              <ul class="kb-list kb-list-inline pl-3">
                @foreach($kb_articles->get() as $article)
                  <li><a href="{{ kb_article_url($article) }}"><span><i class="fa fa-file-text-o"></i></span> {{$article->title}}</a></li>
                @endforeach
              </ul>
                
          </div>

        </div>

        @endif

          </div>
        </div>

      </div>
@include('frontend.layouts.partials.block_create_ticket')

</div>

@endsection


