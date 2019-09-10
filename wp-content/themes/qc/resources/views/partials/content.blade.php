@if (has_post_format('link'))
<article @php(post_class('row container margin-top-medium'))>
  <div class="column small-12 medium-6">
  	<?php if(has_post_thumbnail()): ?>
  	<a target="_blank" href="<?php the_field('link');?>"><img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="{{ get_the_title() }}"></a>
  <?php endif; ?>
	</div>
	<div class="column small-12 medium-6 padding-medium">
	  <header>
	    <h2 class="entry-title h4 hello"><a target="_blank" href="<?php the_field('link');?>">{{ get_the_title() }}</a></h2>
	    @include('partials/entry-meta')
	  </header>
	  <div class="entry-summary">
	    @php(the_excerpt())
	  </div>
	</div>
</article>
@else

<article @php(post_class('row container margin-top-medium'))>
  <div class="column small-12 medium-6">
  	 <?php if(has_post_thumbnail()): ?>
<img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="{{ get_the_title() }}">
		<?php endif; ?>
	</div>
	<div class="column small-12 medium-6 padding-medium">
	  <header>
	    <h2 class="entry-title h4 hello"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
	    @include('partials/entry-meta')
	  </header>
	  <div class="entry-summary">
	    @php(the_excerpt())
	  </div>
	</div>
</article>

@endif