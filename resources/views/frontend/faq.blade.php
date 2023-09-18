@extends('frontend.layouts.app', ['body_class' => 'bg-default'])

@section('content')

        <div class="section-page-header bg-gradient-primary shadow text-center pt-9 pb-6 mb-6">
          <div class="container d-flex align-items-center">
            <div class="row w-100">
              <div class="col">
                <h1 class="display-title-home text-white">{{ __('frontend.frequently_asked_questions') }}</h1>
              </div>
            </div>                

          </div>
        </div>
        <div class="container">

          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('home')}}">{{ setting('site_title') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ __('frontend.frequently_asked_questions') }}</li>
            </ol>
          </nav>

        <div class="row">
          <div class="col">

            @forelse($faq_categories as $i => $category)

              @if(count($category->faqs) > 0)

              <div class="section section-page">
                <h3 class="faq-title my-4" id="list-item-1">{{ $category->name }}</h3>
                <hr>

                <div class="accordion faq-accordion" id="question-category-{{$category->id}}">
  
                  @foreach($category->faqs as $faq)

                    <div class="card">
                      <div class="card-header" id="question-heading-{{$category->id.'-'.$faq->id}}">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#question-{{$category->id.'-'.$faq->id}}" aria-expanded="true" aria-controls="question-{{$category->id.'-'.$faq->id}}">
                            {{ $faq->question }}
                          </button>
                        </h5>
                      </div>

                      <div id="question-{{$category->id.'-'.$faq->id}}" class="collapse" aria-labelledby="question-heading-{{$category->id.'-'.$faq->id}}" data-parent="#question-category-{{$category->id}}">
                        <div class="card-body">
                        {{ $faq->answer }}
                        </div>
                      </div>
                    </div>

                  @endforeach

                </div><!--.accordion-->
              </div>

              @endif

            @empty

            <div class="alert alert-danger">
              {{ __('frontend.no_faq_found') }}
            </div>

            @endforelse



      </div>

</div>

@include('frontend.layouts.partials.block_create_ticket')
</div>

  @endsection
