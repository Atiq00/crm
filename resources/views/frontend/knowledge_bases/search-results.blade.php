@extends('frontend.layouts.app', ['body_class' => 'bg-default'])

@section('content')

<form action="{{route('search')}}" method="get" id="search_form">
<div class="section-header bg-gradient-primary shadow text-center pt-8 pb-1 mb-5">
  <div class="container d-flex text-center align-items-center">
    <div class="row w-100">
      <div class="col">
        <h2 class="text-white">{{ __('frontend.search_kb') }}</h2>

          <div class="search-header mt-4 mb-6">
            <input type="text" autocomplete="off" name="query" class="form-control search-header-input" placeholder="{{ __('frontend.search_placeholder') }}" value="{{ request()->get('query') }}" />
            <a href="#" onclick="$(this).parents('form').submit();"><span class="search-icon"></span></a>
            <p class="text-white text-left pt-3" style="font-style: italic; font-size: .9rem;">{{ __('frontend.home_popular_topics') }} @foreach( json_decode(setting('popular_categories')) as $key => $id )
                <a href="{{kb_category_url(\App\Models\KbCategory::find($id))}}">{{\App\Models\KbCategory::find($id)->name }}</a>
                @if($key < count(json_decode(setting('popular_categories')))-1)
                  ,&nbsp;
                @endif
              @endforeach
          </div>
      </div>
    </div>                

  </div>
</div>

<div class="container">

          <div class="section section-page search-page py-0" data-spy="scroll" data-target="#kb-list" data-offset="0">
            <div class="search-page-header">
              <div class="row">
                <div class="col-md-8">
                <h3 class="title" id="category-1">{{ __('frontend.search_results') }}</h3>
                <p>{{ __('frontend.found_results', [ 'ARTICLES_FOUND' => $kb_articles->count(), 'SEARCH_TERM' => $searched_terms['query'] ]) }}</p>
                <p>
                  @if(!empty($searched_terms['query']))
                    <a href="#!" onclick="$('[name=query]').val(''); $(this).parents('form').submit() "><span class="badge badge-danger badge-md"> <i class="fa fa-times"></i> &nbsp; {{ $searched_terms['query'] }}</span></a>
                  @endif
                  @if(!empty($searched_terms['category_id']))
                    <a href="#!" onclick="$('[name=category_id]').val(''); $(this).parents('form').submit() "><span class="badge badge-danger badge-md"> <i class="fa fa-times"></i> &nbsp; {{ \App\Models\KbCategory::find($searched_terms['category_id'])->name }}</span></a>
                  @endif
                  @if(!empty($searched_terms['sub_category_id']))
                    <a href="#!" onclick="$('[name=category_id]').val('{{ $searched_terms['category_id'] }}'); $(this).parents('form').submit() "><span class="badge badge-danger badge-md"> <i class="fa fa-times"></i> &nbsp; {{ \App\Models\KbSubCategory::find($searched_terms['sub_category_id'])->name }}</span></a>
                  @endif
                </p>

                </div>
                <div class="col-md-4">
                
                <div class="form-group">
                    <label class="form-control-label" for="input-category">{{ __('frontend.category') }}</label>
                    {!! html_select_kb_categories(
                                                            $kb_categories, // data
                                                            'category_id',  // name
                                                            'class="form-control" onchange="$(this).parents(\'form\').submit()"', // CustomAttr,
                                                            false, // isRequired
                                                            $searched_terms['category_id'],  // Selected Category 
                                                            $searched_terms['sub_category_id'] // Selected Sub Category 
                                                    ) !!}
                  </div>

                </div>
              </div>
              
            </div>

              @foreach($kb_articles->get() as $article)
              <div class="search-item">
                <h3><a href="{{kb_article_url($article)}}">{{$article->title}}</a></h3>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                      @if(isset($article->sub_category->name))
                      <li class="breadcrumb-item">
                        <a href="{{ kb_category_url($article->category) }}">{{$article->category->name}}</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $article->sub_category->name }}</li>
                    @else
                    <li class="breadcrumb-item active">
                      <a href="{{ kb_category_url($article->category) }}">{{$article->category->name}}</a>
                    </li>
                    @endif
                    </ol>
                  </nav>
                <p>{!! strip_tags(Str::words($article->description, 50)) !!}</p>
                <a href="{{kb_article_url($article)}}" class="text-primary">{!! __('frontend.view_article') !!}</i></a>
              </div>
              @endforeach

            
          </div>

@include('frontend.layouts.partials.block_create_ticket')
</div>
</form>

@endsection



