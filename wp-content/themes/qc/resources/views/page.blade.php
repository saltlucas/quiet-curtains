@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')

    <div id="content-body" class="content-body">
      <div class="row collapse">    
        <div id="page-content" class="column small-12 <?php echo (have_rows('sidebar_menu')? 'large-10' : 'large-12'); ?> page-content">
          @include('partials.content-page')
        </div>
      </div>
  	</div>
  @endwhile
@endsection