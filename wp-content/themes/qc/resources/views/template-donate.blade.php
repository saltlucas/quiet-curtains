{{--
  Template Name: Donate Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    <div id="content-body" class="content-body show-content-navigation expand-content-menu" data-toggler="minimize-content-menu">
      <div class="row collapse">
        @if (App\display_sidebar())
          @if ( have_rows('sidebar_menu') )
          <aside id="aside-navigation" class="aside-navigation column hide-for-small-only large-2 margin-top-medium">
            @include('partials.sidebar-about')
          </aside>
          @endif        
        @endif        
        <div id="page-content" class="column small-12 page-content margin-top-medium">
          @include('partials.content-donate-page')
        </div>
      </div>
  	</div>
  @endwhile
@endsection
