<section id="home-slider-section" class="full-width hero-header">
  <?php if( have_rows('slider_fields') ): ?>
	<div id="home-slider" class="page-header-slider slider full-height"> 
		<?php while ( have_rows('slider_fields') ) : the_row(); ?>
		<div class="slide vertical-full blue-dark <?php if(get_sub_field('background_color')!='white') { echo 'text-white';} ?>" >
			<div class="scroll-in fade-in" style="<?php if(get_sub_field('image')) { echo 'background: url(' . get_sub_field('image') . ');';} ?>" id="hero-background"></div>
			style="background:url();"
	    	<div id="hero-content" class="va-container" role="main">
          	<section class="va-middle" itemprop="articleBody">
          		<div class="hero-slider-content-wrap">
          			<div>
          				<?php the_sub_field('description'); ?>
              		</div>
          		</div>
          	</section>
			</div>			
		</div>
		<?php endwhile; ?>
	</div>
	<?php endif; ?>  
	<div class="text-center scroll-button-container">
		<a id="scroll" class="scroll-button" href="#events-section">
		</a>
	</div>
</section>
<section>
	<?php the_content(); ?>
</section>