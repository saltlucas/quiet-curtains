@if ( have_rows('link') )
<section id="sub-navigation" class="gray text-white text-center">	
<ul class="inline-list align-center">
	<?php while ( have_rows('link') ) : the_row(); ?>
    <li><a href="<?php the_sub_field('page'); ?>"><?php the_sub_field('link_text'); ?></a></li>
  <?php endwhile; ?>
</ul>
</section>

@endif

@if( get_field('header_style', get_option('page_for_posts')) == 'One Column' )
<section id="page-header" class="text-center <?php the_field('background_color_header', get_option('page_for_posts')); ?>">
	<div class="block">
		<div class="block-wrap archive-header block-background">
			<div class="block-image" style="background: url(<?php the_field( 'header_image', get_option('page_for_posts')); ?>)">
			</div>
			<div class="block-content">
				<div class="va-container">
				<div class="va-middle">
				<div class="container">
					<div class="row">
						<div class="column small-12 medium-8 medium-offset-2">
								@if(get_field('page_title', get_option('page_for_posts')))
									<h1 class="text-blue-medium">@php(the_field('page_title', get_option('page_for_posts')))</h1>
								@endif							
								@php(the_field('header_introduction', get_option('page_for_posts')))
						</div>
					</div>
				</div>
				</div>						
				</div>
			</div>
		</div>
	</div>
</section>
@elseif( get_field('header_style', get_option('page_for_posts')) == 'Two Column' )
	<section id="page-header" class="container text-center <?php the_field('background_color_header'); ?> <?php if(get_field('background_color_header')!='white') { echo 'text-white';} ?>">
		<div class="row">
			<div class="column small-12 medium-6 block">
				<div class="block-wrap aspect-3-2">
					<div class="block-content">
						<div class="va-container">
							<div class="va-middle">
								@if(get_field('page_title', get_option('page_for_posts')))
									<h1 class="text-blue-medium">@php(the_field('page_title', get_option('page_for_posts')))</h1>
								@endif
								@php(the_field('header_introduction', get_option('page_for_posts')))
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="column small-12 medium-6 block">
				<div class="block-wrap aspect-3-2 block-background">
					<div style="background-image: url(<?php the_field( 'header_image', get_option('page_for_posts')); ?> );" class="block-image">
					</div>
				</div>
			</div>
		</div>
	</section>
@else
	<section class="page-header container">
   <h1>{!! App\title() !!}</h1>
  </section>
@endif  
