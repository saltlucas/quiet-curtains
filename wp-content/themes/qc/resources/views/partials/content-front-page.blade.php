<section id="home-slider-section" class="full-width hero-header row collapse">
  <?php if( have_rows('slider_fields') ): ?>
	<div id="home-slider" class="page-header-slider slider full-height column small-12">
		<?php while ( have_rows('slider_fields') ) : the_row(); ?>
		<div class="slide vertical-full blue-dark <?php if(get_sub_field('background_color')!='white') { echo 'text-white';} ?>" >
			<div class="scroll-in fade-in" style="<?php if(get_sub_field('image')) { echo 'background: url(' . get_sub_field('image') . ');';} ?>" id="hero-background"></div>
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
<section class="home-overview-section full-width padding-top-large padding-bottom-large">
	<div class="container">
		<div class="row">
			<div class="column small-12 large-offset-3 large-6 text-center">
				<h2 class="h4">Experience Peace and Quiet</h2>
        <p>We specialize in acoustic curtains of both types; Quiet Curtains&trade; that <strong>block sound</strong> (usually for windows or room dividers) and Acoustic Curtains&trade; that <strong>absorb sound</strong> (for rooms with too much echo/reverb). Depending on your noise problem we might use a combination of sound blocking and sound absorbing.  Our elegant acoustical curtains and drapes are custom made for our clients’ commercial, acoustic, and residential use.</p>
			</div>
		</div>
		<div class="row text-center icon-row margin-top-medium">
			<div class="column small-6 large-3" data-aos="fade" data-aos-offset="0" data-aos-delay="500" data-aos-once="true">
				<img src="@asset('images/soundproof.svg')" alt="">
				<h4>Soundproof</h4>
        <p>Our curtains are designed to block and absorb sound.  It reduces most noise from outside and reduces echo and noise inside.</p>
			</div>
			<div class="column small-6 large-3" data-aos="fade" data-aos-offset="0" data-aos-delay="1000" data-aos-once="true">
        <img src="@asset('images/blackout.svg')" alt="">
				<h4>Blackout</h4>
        <p>Our proprietary lining blocks out light in all our curtains.  You won't be disturbed by moonlight, street lights, or the rising sun.</p>
			</div>
			<div class="column small-6 large-3" data-aos="fade" data-aos-offset="0" data-aos-delay="1500" data-aos-once="true">
        <img src="@asset('images/thermal.svg')" alt="">
				<h4>Thermal Regulation</h4>
        <p>Our curtains help  prevent heat from entering or leaving helping to regulate the temperature.</p>
			</div>
			<div class="column small-6 large-3" data-aos="fade" data-aos-offset="0" data-aos-delay="2000" data-aos-once="true">
        <img src="@asset('images/fabric.svg')" alt="">
        <h4>Beautiful High Quaity Fabrics</h4>
        <p>We offer six different quality fabrics in over 200 color swatches.</p>
			</div>
		</div>
	</div>
</section>
<section id="home-path" class="home-cta-section full-width padding-bottom-medium">
	<div class="container">
		<div class="row">
			<div class="column small-12 large-offset-3 large-6 text-center margin-bottom-small">
				<h2 class="h4">Start by choosing your Needs</h2>
			</div>
		</div>
		<div class="row home-cta-row data-equalizer">
			<div class="column hover-column small-12 large-4 data-equalizer-watch">
				<div class="grid-vertical block text-center">
					<div class="block-wrap aspect-3-2 block-background blue-medium">
						<div style="background: url(https://www.acoustic-curtains.com/wp-content/uploads/2018/04/medium-background.jpg);" class="block-image">
						</div>
						<div class="block-content">
							<a class="cta-link" href="<?php echo esc_url(get_permalink(462)); ?>">
							<div class="va-container">
								<div class="va-middle">
									<a class="button outline-white" href="<?php echo esc_url(get_permalink(462)); ?>">Sound Blocking</a>
                  <p class="button-info"><span>(Soundproofing)</span></p>
									<div class="hover-content">
										<p>Looking for curtains for windows, room dividers, doors, loft, playroom, and more <span class="underline-text">start here</span>.</p>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="column hover-column small-12 large-4 data-equalizer-watch">
					<div class="grid-vertical block text-center">
						<div class="block-wrap aspect-3-2 block-background salmon">
							<div style="background: url(https://www.acoustic-curtains.com/wp-content/uploads/2018/04/acoustic-background.jpg)" class="block-image">
							</div>
							<div class="block-content">
								<a class="cta-link" href="<?php echo esc_url(get_permalink(924)); ?>">

								<div class="va-container">
									<div class="va-middle">
										<a class="button outline-white" href="<?php echo esc_url(get_permalink(924)); ?>">Acoustics</a>
                    <p class="button-info"><span>(Sound Absorbing)</span></p>
										<div class="hover-content">
											<p>Looking for curtains for home theater, recording studio, theatre, music room, and more <span class="underline-text">start here</span>.</p>
										</div>
									</div>
								</div>
								</a>
							</div>
						</div>
					</div>
			</div>
			<div class="column hover-column small-12 large-4 data-equalizer-watch">
				<div class="grid-vertical block text-center">
					<div class="block-wrap aspect-3-2 block-background blue-dark">
						<div style="background: url(https://www.acoustic-curtains.com/wp-content/uploads/2018/04/commercial-background.jpg)" class="block-image">
						</div>
						<div class="block-content">
							<a class="cta-link" href="<?php echo esc_url(get_permalink(985)); ?>">
							<div class="va-container">
								<div class="va-middle">
									<a class="button outline-white" href="<?php echo esc_url(get_permalink(985)); ?>">Commercial</a>
									<div class="hover-content">
										<p>Looking for curtains for hospitals, construction, hotels, event spaces, conference rooms, restaurants, and more <span class="underline-text">start here</span>.</p>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
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
					<div class="row gutter-small align-middle small-up-2 medium-up-3 large-up-6 logos" data-aos="fade" data-aos-offset="-400" data-aos-delay="1000" data-aos-once="true" data-equalizer>
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
			      			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
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
<section id="value-prop" class="full-width padding-top-medium padding-bottom-medium container">
  <div class="row">
    <div class="column small-12">
      <div class="grid-vertical block text-center">
        <div class="block-wrap large-aspect-3-1 block-background">
          <div style="background: url(@asset('images/value-curtains.jpg'));" class="block-image">
          </div>
          <div class="block-content">
            <div class="va-container">
              <div class="va-top">
                <h3 class="text-white text-center margin-top-large">What Makes Quiet Curtains&trade; Different</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row val-content-row">
    <div class="column small-12 large-6">
      <div class="val-icon text-center">
        <img src="@asset('images/award.svg')" alt="curtain lining technology">
      </div>
      <div class="val-content">
        <h4 class="text-center text-blue-medium">Quality at Affordable Price</h4>
        <p>Our products are similarly priced to custom curtains, but ours have the advantage of a privacy lining that is soundproof and blackout.  We achieve this by a long standing direct relationship with fabric mills.  We also make the curtains in house in Southern California.  Finally, we sell directly to you the customer.  All this mean you are working directly with the manufacturer, we are cutting out the middleman, and we are passing the savings up to 200% compared to a traditional curtain store onto you!</p>
      </div>
    </div>
    <div class="column small-12 large-6">
      <div class="val-icon text-center">
        <img src="@asset('images/technology.svg')" alt="curtain lining technology">
      </div>
      <div class="val-content">
        <h4 class="text-center text-blue-medium">Technology</h4>
        <p>Quiet Curtains is one of the few companies that offer a curtain with true protection from noise and sound.  We have the upper hand on our competitors with a lining that is lab tested with our fabrics to provide high sound absorption and sound blocking characteristics.  We have worked with sound scientists to create linings that are perfect for various applications.  Our curtains still behave and look like normal curtains with some added benefits.</p>
      </div>
    </div>
  </div>
</section>
<section id="letter" class="full-width padding-top-large padding-bottom-large  blue-light">
  <div class="container">
    <div class="row">
      <div class="column small-12 text-center margin-bottom-medium">
        <h3 class="text-blue-medium">See what a Senior acoustical Scientist Thinks</h3>
      </div>
    </div>
    <div class="row letter-row" data-equalizer>
      <div class="column small-12 large-5 large-push-7 quote-column" data-equalizer-watch>
        <div class="quote-content blue-dark">
          <blockquote class="text-blue-light">“Quiet Curtains have consistently outperformed all competitors by offering the best, well engineered sound blocking and sound absorbing curtain systems in the United States”</blockquote>
        </div>
      </div>
      <div class="column large-7 small-12 large-pull-5 letter-column" data-equalizer-watch>
        <div class="letter-content padding-top-large padding-bottom-large white">
          <div class="arcadis-logo">
            <img src="@asset('images/arcadis.gif')" alt="arcadis">
          </div>
          <p>Dear Scott:</p>
          <p>I have been dedicated to the field of architectural acoustics for over 25 years, where my experience has revealed that there is always a need to satisfy valuable clients with quality products and services. I am confident in saying that you and your team at Complete Soundproofing have consistently outperformed all competitors by offering the best, well engineered sound blocking and sound absorbing curtain systems in the United States.</p>

          <p>My travels take me far and wide and into the most exotic of acoustical engineering requirements. I have found that over these many years not only do you understand the complexity of acoustical curtain materials, but you have taken the painstaking diligence to test your products and correctly apply their physical properties to your remarkable sound blocking and sound curtain product line. I truly feel that this effort, on your behalf, has made my job easier by allowing me the opportunity to peruse your ever-growing product line for satisfying a variety of my client’s particular needs. Please keep up the good work and I greatly look forward to your new product releases in the near future.</p>
          <p>ARCADIS U.S., Inc. <br>
          Sincerely,</p>
          <div class="signature"><img alt="signature arcadis" src="@asset('images/signature.png')"></div>
          <p>Michael Burrill, INC<br>
            Director / Senior Acoustical Scientist</p>
        </div>
      </div>
    </div>
  </div>
</section>
@php(the_content())
