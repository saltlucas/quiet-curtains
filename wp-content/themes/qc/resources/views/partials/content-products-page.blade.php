<article>
<section id="products-section" class="margin-top-large">
	<div class="container">
		<div class="row">
			<div class="column small-12">
				<?php
				if( have_rows('product') ):
					$count = count(get_field('product'));
					$counter = 1;
					while ( have_rows('product') ) : the_row();							
						// Post Content here
					if ($counter % 2 == 1) {
						echo '<div class="row margin-bottom-medium">';
					}
				?>
					<div class="column small-12 medium-6 large-6">
						<?php if(get_sub_field('product_link')): ?>
							<a class="product-link" href="<?php the_sub_field('product_link') ?>">
						<?php endif; ?>
						<div class="product-image-holder square">
							<img  class="product-image" src="<?php the_sub_field('product_image'); ?>">
						</div>
						<div class="product-description">
	      					<?php the_sub_field('product_information'); ?>
						</div>
						<?php if(get_sub_field('product_link')): ?>
							</a>
						<?php endif; ?>
					</div>			
				<?php
				if ($counter % 2 == 0 || $counter==$count) //end even posts or last post
				{
					echo '</div>';
				}	
				$counter++;				
				?>
				<?php
							//
					endwhile; // end while
				endif; // end if
				?>
			</div>
		</div>	
	</div>
</section>

@php(the_content())
</article>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
