<article>
<?php /*Flexible content section */ ?>
	@if ( have_rows('page_sections') )
		<?php while ( have_rows('page_sections') ) : the_row(); ?>
			<?php if( get_row_layout() == 'facts_section' ): ?>
				<section id="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>" data-magellan-target="<?php echo sanitize_title_with_dashes(get_sub_field('id')); ?>">
					<div class="container">
					<div class="row">
					<?php
						$count = count(get_sub_field('facts_section'));
						$counter = 1;
					?>
					<?php
			   // loop through the rows of data
					while ( have_rows('facts_section') ) : the_row();
						if ($counter % 2 == 1) {
							echo '<div class="column small-12 medium-4">';
							echo '<div class="grid-y">';
						}

			        if( get_row_layout() == 'fact' ):
			        ?>
			      		<div class="column small-6 text-white text-center block <?php the_sub_field('background_color'); ?> <?php if(get_sub_field('background_color')!='white') { echo 'text-white';} ?>">
			      			<div class="block-wrap aspect-3-2">
			      				<div class="block-content">
			      					<div class="va-container">
			      						<div class="va-middle">
							      		<?php
							        		the_sub_field('fact');
							        	?>
							        	</div>
							      	</div>
			        			</div>
			        		</div>
			        	</div>
			        <?php
			        elseif( get_row_layout() == 'image' ): 
			        ?>
								<div class="column small-6 block">
									<div class="block-wrap aspect-3-2 block-background">
										<div style="background-image: url(<?php the_sub_field("image"); ?>);" class="block-image">
										</div>
									</div>
								</div>
							<?php
			        endif;
						if ($counter % 2 == 0 || $counter==$count) //end even posts or last post
						{
							echo '</div>';
							echo '</div>';
						}	
						$counter++;				
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
				<section class="container text-center">
					<div class="row collapse">
						<div class="column small-12 medium-6 block">
							<div class="block-wrap aspect-3-2 block-background">
								<div style="background-image: url(<?php the_sub_field( 'image' ); ?> );" class="block-image">
								</div>
							</div>
						</div>
						<div class="column small-12 medium-6 block <?php the_sub_field('background_color'); ?> <?php if(get_sub_field('background_color')!='white') { echo 'text-white';} ?>">
							<div class="block-wrap aspect-3-2">
								<div class="block-content">
									<div class="va-container">
										<div class="va-middle">
											@php(the_sub_field('content'))
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

