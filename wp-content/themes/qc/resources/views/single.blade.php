@extends('layouts.app')
@section('content')
  @while(have_posts()) @php(the_post())
    <div id="content-body" class="content-body" >
      <div class="row">      
        <div id="page-content" class="column small-12 medium-9 page-content">
    			@if (has_post_format('link'))
    				@include('partials.content-single-link')
    			@else
    				@include('partials.content-single-'.get_post_type())
    			@endif
        </div>
        @if (App\display_sidebar())
          <aside class="sidebar column small-12 large-3">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
  	</div>
  @endwhile
@endsection
