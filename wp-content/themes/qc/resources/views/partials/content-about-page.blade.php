<article>
	@if ( have_rows('facts_section') )
	<section id="fact-section" data-magellan-target="fact-section">
		<div class="container">
		<div class="row collapse">
		<?php
			$count = count(get_field('facts_section'));
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
      		<div class="grid-vertical text-white text-center block <?php the_sub_field('background_color'); ?>">
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
					<div class="grid-vertical block">
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
    wp_reset_query();
	?>
			</div>
		</div>
	</section>
	@else
		<p>no facts</p>
	@endif

<section class="text-section text-center">
	<div class="container">
		<div class="row margin-bottom-large margin-top-large">
			<div class="column small-12 medium-10 medium-offset-1 large-8 large-offset-2">
				<p>The Conservancy is led by a volunteer Board of Directors and is supported by more than 1,300 Conservancy members. It partners with the San Dieguito River Park Joint Powers Authority, other non-profit organizations, citizens, landowners, governments, and other stakeholders conserve our natural resources, educate our community, and provide recreational opportunities throughout the San Dieguito River watershed.</p>
			</div>
		</div>
	</div>
</section>
<section id="about-mission" data-magellan-target="about-mission" class="text-background-section text-center text-white">
	<div class="block">
		<div class="block-wrap block-background">
			<div class="block-image" style="background: url(//localhost/sdrvc/wp-content/uploads/2017/07/about-mission.jpg)">
			</div>
			<div class="block-content">
				<div class="va-container">
				<div class="va-middle">
				<div class="container">
					<div class="row">
						<div class="column small-12 medium-8 medium-offset-2 large-6 large-offset-3">
							<h3>Mission</h3>
							<p>The San Dieguito River Valley Conservancy preserves, protects, and shares the natural and cultural resources of the San Dieguito River Valley through collaborative efforts to acquire lands, complete trails, restore habitats, establish educational programs, create interpretive centers, encourage recreation, and mobilize public support.</p>
						</div>
					</div>
				</div>
				</div>						
				</div>
			</div>
		</div>
	</div>
</section>
<section id="about-watershed" data-magellan-target="about-watershed" class="text-solid-section green text-white text-center">
	<div class="row">
		<div class="column small-12 medium-8 medium-offset-2 large-6 large-offset-3 margin-top-large margin-bottom-large">
			<h3>THE SAN DIEGUITO WATERSHED & RIVER PARK</h3>
			<p>The San Dieguito headwaters flow from springs on Volcan Mountain north of Julian and meanders some 55 miles through conifer and oak woodlands, grasslands, and chaparral to the San Dieguito Lagoon between Del Mar and Solana Beach. It is the most intact watershed remaining in San Diego County and contains a variety of diverse ecosystems, plants, and wildlife.</p>
		</div>
	</div>
</section>
<section class="image-section green">
	<div class="block">
		<div class="block-wrap block-background">
			<div class="block-image" style="background: url(//localhost/sdrvc/wp-content/uploads/2017/07/about-break.jpg)">
			</div>
		</div>
	</div>
</section>
<section id="about-coast-crest" data-magellan-target="about-coast-crest" class="image-fade-section">
	<div class="block">
		<div class="block-wrap block-background">
			<div class="block-image" style="background: url(//localhost/sdrvc/wp-content/uploads/2017/07/about-trail.jpg)">
			</div>
			<div class="block-content text-center">
				<div class="container">
					<div class="row">
						<div class="column small-12 medium-8 medium-offset-2 large-6 large-offset-3">
							<h3>COAST TO CREST TRAIL</h3>
							<p>Since 1986, the Conservancy has been working with its partners to develop and complete the planned 70-mile Coast to Crest Trail. When complete, the Coast to Crest Trail will be a multi-use trail connecting the ocean at Del Mar to Volcan Mountain north of Julian. It will allow the public to explore the entire length of the San Dieguito Watershed and all its diverse, natural beauty. Interpretive panels and signage will provide educational opportunities along the trail.</p>
						</div>
					</div>						
				</div>
			</div>
		</div>
	</div>	
</section>
<section id="about-timeline" data-magellan-target="about-timeline" class="image-fade-section timeline-section">
	<div class="block">
		<div class="block-wrap block-background">
			<div class="block-image" style="background: url(//localhost/sdrvc/wp-content/uploads/2017/07/about-timeline.jpg)">
			</div>
			<div class="block-content text-center">
				<div class="container">
					<div class="row">
						<div class="column small-12 large-10 large-offset-1">
							<h3>Timeline</h3>
<section class="cd-horizontal-timeline">
	<div class="timeline">
		<div class="events-wrapper">
			<div class="events">
				<ol>
					<li><a href="#0" data-date="16/01/2014" class="selected">1986</a></li>
					<li><a href="#0" data-date="28/02/2014">1986</a></li>
					<li><a href="#0" data-date="20/04/2014">1989</a></li>
					<li><a href="#0" data-date="20/05/2014">1990-1996</a></li>
					<li><a href="#0" data-date="09/07/2014">1997</a></li>
					<li><a href="#0" data-date="30/08/2014">1998</a></li>
					<li><a href="#0" data-date="15/09/2014">2000</a></li>
					<li><a href="#0" data-date="01/11/2014">2002</a></li>
					<li><a href="#0" data-date="10/12/2014">2003</a></li>
					<li><a href="#0" data-date="19/01/2015">2005</a></li>
					<li><a href="#0" data-date="03/03/2015">2007</a></li>
				</ol>

				<span class="filling-line" aria-hidden="true"></span>
			</div> <!-- .events -->
		</div> <!-- .events-wrapper -->
			
		<ul class="cd-timeline-navigation">
			<li><a href="#0" class="prev inactive">Prev</a></li>
			<li><a href="#0" class="next">Next</a></li>
		</ul> <!-- .cd-timeline-navigation -->
	</div> <!-- .timeline -->

	<div class="events-content">
		<ol>
			<li class="selected" data-date="16/01/2014">
				<h2>Horizontal Timeline</h2>
				<em>January 16th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="28/02/2014">
				<h2>Event title here</h2>
				<em>February 28th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="20/04/2014">
				<h2>Event title here</h2>
				<em>March 20th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="20/05/2014">
				<h2>Event title here</h2>
				<em>May 20th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="09/07/2014">
				<h2>Event title here</h2>
				<em>July 9th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="30/08/2014">
				<h2>Event title here</h2>
				<em>August 30th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="15/09/2014">
				<h2>Event title here</h2>
				<em>September 15th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="01/11/2014">
				<h2>Event title here</h2>
				<em>November 1st, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="10/12/2014">
				<h2>Event title here</h2>
				<em>December 10th, 2014</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="19/01/2015">
				<h2>Event title here</h2>
				<em>January 19th, 2015</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>

			<li data-date="03/03/2015">
				<h2>Event title here</h2>
				<em>March 3rd, 2015</em>
				<p>	
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
				</p>
			</li>
		</ol>
	</div> <!-- .events-content -->
</section>
						</div>
					</div>						
				</div>
			</div>
		</div>
	</div>	
</section>
<section class="text-section text-center">
	<div class="container">
		<div class="row margin-bottom-large margin-top-large">
			<div class="column small-12 medium-10 medium-offset-1 large-8 large-offset-2">
				<p>The Conservancy is led by a volunteer Board of Directors and is supported by more than 1,300 Conservancy members. It partners with the San Dieguito River Park Joint Powers Authority, other non-profit organizations, citizens, landowners, governments, and other stakeholders conserve our natural resources, educate our community, and provide recreational opportunities throughout the San Dieguito River watershed.</p>
			</div>
		</div>
	</div>
</section>


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
			      			<div class="block-wrap">
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
									<div class="block-wrap block-background">
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
						<div class="block-wrap block-background">
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
			<?php else: 
				// no layouts found
			?>

			<?php endif; ?>


		<?php endwhile; ?>
	@endif

@php(the_content())
</article>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
