{{--
  Template Name: Product Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <div id="content-body" class="content-body show-content-navigation expand-content-menu" data-toggler="minimize-content-menu">
      <div id="page-content" class="page-content">
        @include('partials.content-product-page')
      </div>
  	</div>
  @endwhile
@endsection
