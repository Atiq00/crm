@extends('frontend.layouts.app', ['body_class' => 'bg-default'])

@section('content')

<div class="section-page-header bg-gradient-primary shadow text-center pt-9 pb-6 mb-6">
  <div class="container d-flex align-items-center">
    <div class="row w-100">
      <div class="col">
        <h1 class="display-title-home text-white">{{$knowledge_base->title}}</h1>
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
                    <li class="breadcrumb-item"><a href="{{route('knowledge_bases')}}">{{ __('frontend.knowledge_base') }}</a></li>
                    @if(isset($knowledge_base->sub_category->name))
                      <li class="breadcrumb-item">
                        <a href="{{ kb_category_url($knowledge_base->category) }}">{{$knowledge_base->category->name}}</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $knowledge_base->sub_category->name }}</li>
                    @else
                    <li class="breadcrumb-item active">
                      <a href="{{ kb_category_url($knowledge_base->category) }}">{{$knowledge_base->category->name}}</a>
                    </li>
                    @endif
                  </ol>
                </nav>
              </div>
              <div class="col-12 col-md-6">
                <div class="search-header pull-right">
        <form action="{{route('search')}}" method="get" id="search_form">
          <input type="text" autocomplete="off" name="query" class="form-control search-header-input" placeholder="{{ __('frontend.search_placeholder') }}" value="{{ request()->get('query') }}" />
                  <a href="#"><span class="search-icon"></span></a>
        </form>
                </div>
              </div>

          </div>

        <div class="row">
          <div class="col-12 col-md-8">
            

            <div class="card shadow-light pb-5 mb-9 article-page">
              <div class="card-header bg-white">
              <h3 class="title pb-3" id="category-1"><a href="#">{{$knowledge_base->title}}</a></h3>
              <!-- <p class="share-btns pull-right">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
              </p> -->

              <p><strong>{{ __('frontend.post_date') }}</strong> : <?php echo $knowledge_base->created_at->format( setting('date_format') ) ?> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>{{ __('frontend.last_update') }}</strong>  - <?php echo $knowledge_base->created_at->diffForHumans() ?> &nbsp;&nbsp;
              </p>
              </div>
              <div class="card-body">

              <div class="ck-content" id="description" style="min-height: 300px;">
                {!! $knowledge_base->description !!}
              </div>

              </div>

              <div class="card-footer bg-white">

              <div class="row">
                <div class="col-12 text-center mt-3">
                  <h4>{{ __('frontend.was_article_helpful') }} </h4>
                  <p id="kb_helpfull_wrapper" class="text-center py-3">
                    <button class="btn btn-helpful btn-helpful-ys {{ request()->cookie('helpful_marked_token') ?'disabled' : '' }}" {{ request()->cookie('helpful_marked_token') ?'disabled' : '' }} onclick="sendHelpfulRequest(this, 'yes');"> <i data-feather="thumbs-up" stroke-width="2" width="20"></i> &nbsp; {{ __('frontend.yes') }} </button>
                    <button class="btn btn-helpful btn-helpful-no {{ request()->cookie('helpful_marked_token') ?'disabled' : '' }}" {{ request()->cookie('helpful_marked_token') ?'disabled' : '' }} onclick="sendHelpfulRequest(this, 'no');"> <i data-feather="thumbs-down" stroke-width="2" width="20"></i> &nbsp; {{ __('frontend.no') }}</button>
                  </p>
                  <p> {!! __('frontend.helpful_text', [ 
                    'YES_INT' => (int) $knowledge_base->helpful_yes,
                    'NO_INT' => (int) ($knowledge_base->helpful_yes+$knowledge_base->helpful_no)
                   ] ) !!} </p>
                </div>
              </div>
              </div>

            </div>

          </div>

          <div class="col-12 col-md-4">

            @if(count($related_articles) > 0)

            <div class="list-group category-list-group  shadow-light mb-4">
              <li class="list-group-item"><h6 class="sub-title">{{ $knowledge_base->category->name }} </h6></li>
                @foreach( $related_articles as $related_article )
                  <a href="{{kb_article_url($related_article)}}"  class="list-group-item list-group-item-action"><span><i class="fa fa-file-text-o"></i></span> &nbsp;&nbsp; {{$related_article->title}}</a>
                @endforeach
            </div>

            @endif

            @if(count($related_categories) > 0)
            <div class="list-group category-list-group  shadow-light">
              <li class="list-group-item"><h6 class="sub-title">{{ __('frontend.other_categories') }} </h6></li>
                @foreach( $related_categories as $r_category )
                  <a href="{{kb_sub_category_url( $r_category )}}"  class="list-group-item list-group-item-action"><span><i class="fa fa-folder"></i></span> &nbsp; {{$r_category->name}}</a>
                @endforeach
            </div>
            @endif
            
          </div>
        </div>

      </div>
@include('frontend.layouts.partials.block_create_ticket')

</div>

@endsection

@push('js')

<script>
  window.sendHelpfulRequest = (el, val) => {
    $.post('{{route('kb.update_helpful', $knowledge_base->id)}}', {
        article:{{$knowledge_base->id}},
        update: (val=='yes'? 'yes' : 'no'),
        "_token": "{{ csrf_token() }}",
      }).done((response) => {
        
        if(response.status == true)
        {

          // <strong id="kb_helpfull_yes">
          $('#kb_helpfull_yes').text(response.yes);
          $('#kb_helpfull_total').text(response.yes + response.no);

          $('#kb_helpfull_wrapper').find('button').attr('disabled', true).addClass('disabled');

        }


      }).fail(() => {
        console.log('error while update');
      });
  };
</script>

@endpush


