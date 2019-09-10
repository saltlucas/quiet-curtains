<article>
<?php /*Dynamic Sections */ ?>
@if ( have_rows('sections') )
	<?php while ( have_rows('sections') ) : the_row(); ?>
		<?php if( get_row_layout() == 'one_column' ): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="<?php if(get_sub_field('class')) { the_sub_field('class'); } ?>">
				<div class="container">
					<div class="row">
						<div class="columns small-12 large-8 large-offset-2">
							<?php the_sub_field('column_content'); ?>
						</div>
					</div>
				</div>
			</section>
		<?php elseif(get_row_layout() == 'logos_section'): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="logos-section <?php if(get_sub_field('class')) { the_sub_field('class'); } ?>">
				<div class="container">
				<div class="row gutter-small align-middle small-up-2 medium-up-3 large-up-6 logos" data-equalizer>
				<?php
		   		// loop through the rows of data
				while ( have_rows('logos_content') ) : the_row();
		        if( get_row_layout() == 'logo' ):
		        ?>
      			<div class="column column-block" data-equalizer-watch>
		      		<div class="va-container">
		      			<div class="va-middle">
		      		<?php
		      		$image = get_sub_field('logo_image');
		      		if(!empty($image)): ?>
		      			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" >
		      		<?php endif; ?>
		      			</div>
		      		</div>
        		</div>
		        <?php
		        endif;		
		    	endwhile;
				?>
				</div>
				</div>
			</section>
		<?php elseif( get_row_layout() == 'solid_background' ): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="text-solid-section <?php the_sub_field('background_color'); ?> <?php if(get_sub_field('background_color')!='white') { echo 'text-white';} ?>">
				<div class="row">
					<div class="column small-12 medium-8 medium-offset-2 large-6 large-offset-3 margin-top-large margin-bottom-large">
						<?php the_sub_field('content'); ?>
					</div>
				</div>
			</section>
		<?php elseif( get_row_layout() == 'image_background' ): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="text-background-section text-white">
				<div class="block">
					<div class="block-wrap block-background aspect-2-1">
						<div class="block-image" style="background: url(<?php the_sub_field('image') ?>)">
						</div>
						<div class="block-content">
							<div class="va-container">
							<div class="va-middle">
							<div class="container">
								<div class="row">
									<div class="column small-12 medium-8 medium-offset-2 large-6 large-offset-3">
										<?php the_sub_field('content') ?>
									</div>
								</div>
							</div>
							</div>						
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php elseif( get_row_layout() == 'two_column' ): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="container background-section <?php if(get_sub_field('class')) { the_sub_field('class'); } ?>" <?php if(get_sub_field('background_image')) { ?> style="background:url(<?php the_sub_field('background_image'); ?>)" <?php } ?>>
				@if(get_sub_field('header'))
					<div class="section-header">
						<?php the_sub_field('header'); ?>
					</div>
				@endif
				<div class="row">
					<?php if( have_rows('column') ): 
 						// loop through the rows of data
    					while ( have_rows('column') ) : the_row(); ?>
						<div class="column small-12 medium-6 <?php if(get_sub_field('class')) { the_sub_field('class'); } ?> @if(get_sub_field('background_image')) block @endif ">
							@if(get_sub_field('background_image'))
							<div class="block-wrap aspect-3-2">
							@endif

							@if (get_sub_field('background_image'))
							<div style="background-image: url(<?php the_sub_field( 'background_image' ); ?> );" class="block-image">
							</div>
							@endif
							<div class="column-content <?php if(get_sub_field('background_image')) { echo "block-content"; }  ?>">
							@php(the_sub_field('column_content'))
							</div>

							@if(get_sub_field('background_image'))
							</div>
							@endif
						</div>
					<?php	    
						endwhile;
						endif;
					?>					
				</div>
			</section>
		<?php elseif( get_row_layout() == 'three_column' ): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="container <?php if(get_sub_field('class')) { the_sub_field('class'); } ?>">
				<div class="row">
					<?php if( have_rows('column') ): 
 						// loop through the rows of data
    					while ( have_rows('column') ) : the_row(); ?>
						<div class="column small-12 medium-4 @if(get_sub_field('background_image')) block @endif">
							@if(get_sub_field('background_image'))
							<div class="block-wrap aspect-3-2">
							@endif

							@if (get_sub_field('background_image'))
							<div style="background-image: url(<?php the_sub_field( 'background_image' ); ?> );" class="block-image">
							</div>
							@endif
							<div class="column-content <?php if(get_sub_field('background_image')) { echo "block-content"; }  ?>">
							@php(the_sub_field('column_content'))
							</div>

							@if(get_sub_field('background_image'))
							</div>
							@endif
						</div>
					<?php	    
						endwhile;
						endif;
					?>					
				</div>
			</section>
		<?php elseif(get_row_layout() == 'testimonials_section'): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="testimonials container padding-top-small padding-bottom-medium blue-light <?php if(get_sub_field('class')) { the_sub_field('class'); } ?>">
				<div class="row">
					<div class="columns small-12 large-10 large-offset-1">
					<div class="testimonial-slider">
					<?php while(have_rows('testimonial')): the_row(); ?>
						<div class="slide">
							@if (get_sub_field('testimonial_image'))
								<div class="testimonial-image"><img src="<?php the_sub_field('testimonial_image'); ?>"></div>
							@endif
							<p class="testimonial-name text-blue-dark">
								<?php the_sub_field('testimonial_name'); ?>
							</p>
							<div class="testimonial-content">
								<?php the_sub_field('testimonial_content'); ?>
							</div>
						</div>
					<?php endwhile; ?>
					</div>
					</div>
				</div>
			</section> 
		<?php elseif(get_row_layout() == 'product_header_section'): ?>
			<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" class="container padding-top-large padding-bottom-large product-header <?php if(get_sub_field('class')) { the_sub_field('class'); } ?>">
				<div class="row">
					<div class="columns small-12 large-7">
						<div class="product__slider-main">
						<?php 
						while(have_rows('product_images')): the_row();
							$image = get_sub_field('product_image');
							if(!empty($image)): ?>
			      			<div class="slide">
			      				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" >
			      			</div>
						<?php endif; ?>
						<?php endwhile; ?>
						</div>
						<div class="product__slider-thmb">
						<?php 
						//reset_rows();
						while(have_rows('product_images')): the_row();
							$image = get_sub_field('product_image');
							//echo '<pre>';
								//var_dump( $image );
							//echo '</pre>';
							if(!empty($image)): ?>
			      			<div class="slide">
			      				<?php echo wp_get_attachment_image( $image['id'], 'thumbnail' ); ?>
			      			</div>
							<?php endif; ?>
						<?php endwhile; ?>
						</div>
					</div>
					<div class="columns small-12 large-5">
						<h1 class="h3 text-blue-medium product-title text-center"><?php the_sub_field('product_title'); ?></h1>
						<div class="product-description">
							<?php the_sub_field('product_description'); ?>
						</div>
						<div class="row product-cta padding-top-small" data-equalizer>
							<div class="columns small-6" data-equalizer-watch>
								<div class="va-container">
									<div class="va-middle">
										<a class="button blue" href="<?php the_sub_field('button_link'); ?>"><?php the_sub_field('button_text'); ?></a>
									</div>
								</div>
							</div>
							<div class="columns small-6 text-center" data-equalizer-watch>
								<div class="va-container">
									<div class="va-middle">
										<p>or call</p>
										<a class="product-number" href="tel:8582723615">858.272.3615</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>				
		<?php else: 
			// no layouts found
		?>
		<?php endif; ?>
	<?php endwhile; ?>
@endif



@php(the_content())
</article>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
