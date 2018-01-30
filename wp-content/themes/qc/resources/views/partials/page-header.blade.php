@if( get_field('header_style') == 'One Column' )
<section id="page-header" class="text-center <?php the_field('background_color'); ?> <?php if(get_field('background_color')!='white') { echo 'text-white';} ?>">
		<div class="row">
			<div class="column small-12 medium-8 medium-offset-2 vertical-full margin-top-medium margin-bottom-medium">
					@if(get_field('page_title'))
						<h1 style="margin-bottom:0;">@php(the_field('page_title'))</h1>
					@endif							
					@php(the_field('header_introduction'))
			</div>
		</div>
</section>
@elseif( get_field('header_style') == 'Two Column' )
	<section id="page-header" class="container <?php the_field('background_color'); ?> <?php if(get_field('background_color')!='white') { echo 'text-white';} ?> text-white text-center">
		<div class="row">
			<div class="column small-12 medium-6 block vertical-full">
				<div class="block-wrap aspect-3-2">
					<div class="block-content">
						<div class="va-container">
							<div class="va-middle">
								@if(get_field('page_title'))
									<h1>@php(the_field('page_title'))</h1>
								@endif
								@php(the_field('header_introduction'))
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="column small-12 medium-6 block">
				<div class="block-wrap aspect-3-2 block-background">
					<div style="background-image: url(<?php the_field( 'header_image'); ?> );" class="block-image">
					</div>
				</div>
			</div>
		</div>
	</section>
@elseif( get_field('header_style') == 'No Header' )


@else
	<section class="page-header container">
		<div class="row">
			<div class="small-12">
   			<h1 class="text-blue-dark"><?php echo get_the_title(); ?></h1>
   		</div>
   	</div>
  </section>
@endif  
