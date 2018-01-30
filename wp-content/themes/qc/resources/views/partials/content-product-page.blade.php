<article>
<section class="text-section product-header full-height <?php if(get_field('product_header_background_color')) { the_field('product_header_background_color'); } ?>">
	<?php if(get_field('product_header')): ?>
		<?php the_field('product_header'); ?>
	<?php endif; ?>
</section>
<section id="product-highlights" class="margin-top-large margin-bottom-large">
	<div class="row title-row">
		<div class="columns small-12">
			<h2 class="text-blue-dark text-center margin-bottom-medium h3">Product Highlights</h2>
		</div>
	</div>
	<div class="row large-collapse product-highlights">
		<div class="small-12 large-2 large-push-5 columns product-image-column">
			<div class="product-highlight-image-container text-center">
				<img style="width: 80px;" class="product-highlight-image" src="<?php echo site_url('wp-content/uploads/2017/10/edge-vertical.png'); ?>" alt="product-image">
			</div>
		</div>
		<div class="small-12 large-5 end large-pull-2 columns product-points-column">
			<ol class="product-points">
				<li id="point-1" class="active">
					<h3 class="h4">Optimized Hook Design<div class="point-line"></div></h3>
					<div class="small-points hide-for-large">
						<img class="hook-img" src="<?php echo site_url('wp-content/uploads/2018/01/edg-hook@2x.png'); ?>" alt="Edg Ortho Hook">
						<h4>With ~ 5x’s greater hook surface area for greater purchase</h4>
					</div>
				</li>
				<li id="point-2">
					<h3 class="h4">Easy-to-Read Digital Display<div class="point-line"></div></h3>
					<div class="small-points hide-for-large">
						<h3>Accurate and Precise</h3>
						<h4>With electronic measurement and sub-millimeter precision, no more guessing the measurement</h4>
					</div>
				</li>
				<li id="point-3">
					<h3 class="h4">Ability to HOLD Measurement<div class="point-line"></div>
					</h3>
					<div class="small-points hide-for-large">
						<h3>Drive Consistency</h3>
						<h4>Can’t see the LCD display due to blood or tissue obstruction?  No problem!</h4>
					</div>

				</li>
				<li id="point-4">
					<h3 class="h4">Single Use
					</h3>
					<div class="small-points hide-for-large">
						<h3>Mitigate Infection Risk</h3>
						<h4>- No more infection risk from dirty depth gauges</h4>
						<h4>- New Hook and Probe each use</h4>
					</div>										
				</li>						
			</ol>	
			<div id="fda-510k">
				<img width="180" height="77" src="<?php echo site_url('wp-content/uploads/2017/11/FDA_Logo-blue.gif'); ?>" alt="FDA 510(k) Cleared">
			</div>	
		</div>
		<div class="columns large-5 show-for-large">
			<ul class="product-points-expanded">
				<li id="point-1-info" class="active">
					<img class="hook-img" src="<?php echo site_url('wp-content/uploads/2018/01/edg-hook@2x.png'); ?>" alt="Edg Ortho Hook">
					<h3>Optimized Hook Design</h3>
					<h4>With ~ 5x’s greater hook surface area for greater purchase</h4>
				</li>
				<li id="point-2-info">
					<h3>Accurate and Precise</h3>
					<h4>With electronic measurement and sub-millimeter precision, no more guessing the measurement</h4>
				</li>
				<li id="point-3-info">
					<h3>Drive Consistency</h3>
					<h4>Can’t see the LCD display due to blood or tissue obstruction?  No problem!</h4>
				</li>
				<li id="point-4-info">
					<h3>Mitigate Infection Risk</h3>
					<h4>- No more infection risk from dirty depth gauges</h4>
					<h4>- New Hook and Probe each use</h4>
				</li>
			</ul>
		</div>
	</div>
</section>
<section class="product-cta blue-dark text-white">
	<div class="row">
		<div class="columns small-12 text-center margin-top-extra-large margin-bottom-extra-large">
			<h2>Give Yourself the EDGe<sup>&trade;</sup></h2>
			<a href="<?php echo site_url('order'); ?>" class="button blue">Order Today</a>
		</div>
	</div>
</section>
<section class="other-products">
	<div class="row">
		<div class="column small-12 large-4 large-offset-4 end text-center margin-top-large margin-bottom-large text-blue-dark">
			<h3>Next Generation Products</h3>
		</div>
	</div>
	<div class="row">
		<div class="column block small-12 large-4 large-offset-4 end text-center vertical-full orange text-white margin-bottom-large">
			<div class="block-wrap aspect-3-2 block-background">
				<div class="block-image" style="background-image: url(<?php echo site_url('wp-content/uploads/2017/12/edge-spine.jpg'); ?>);"></div>
				<div class="block-content">
					<div class="va-container">
						<div class="va-middle">
							<h3>EDG<sup>&reg;</sup> Spine</h3>
							<p>Coming Soon</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@php(the_content())
</article>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
