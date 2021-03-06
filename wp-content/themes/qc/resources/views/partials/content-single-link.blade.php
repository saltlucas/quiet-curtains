<article @php(post_class())>
  <header>
    <?php if(has_post_thumbnail()): ?>
      <div class="featured-image">
        <a target="_blank" href="<?php the_field('link');?>"><img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="{{ get_the_title() }}"></a>
      </div>
    <?php endif ?>
    <h1 class="entry-title h2"><a target="_blank" href="<?php the_field('link');?>">{{ get_the_title() }}</a></h1>
    @include('partials/entry-meta')
  </header>
  <div class="entry-content">
    @php(the_content())
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>
