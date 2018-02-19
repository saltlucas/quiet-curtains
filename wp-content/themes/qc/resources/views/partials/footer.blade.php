<footer id="footer" class="content-info">
	<section id="footer-content" class="full-width text-white gray-light">
		<div class="row expanded">
			<div class="column small-12 large-3 margin-top-medium margin-bottom-medium">
				<div class="contact-info">
					<p class="h3 phone">858.272.3615</p>
					<p class="h3 phone">866.560.6411 <span class="small">toll free</span></p>
					<p class="contact-link"><a href="mail:support@acoustic-curtains.com">support@acoustic-curtains.com</a> | <a href="<?php echo get_site_url('/contact'); ?>">Contact</a></p>
				</div>
				<div class="address margin-top-small margin-bottom-small">
					<p>Quiet Curtains</p>
					<p>San Diego, CA 92127</p>
				</div>
				<ul class="inline-list social-list">
				<li>
				      <a target="_blank" title="LinkedIn" href="//www.linkedin.com/company/10368714/"><img alt="LinkedIn" src="@asset('images/linkedin.svg')"></a>  
				</li>
			    <li>
				    <a target="_blank" title="You Tube" href="//www.youtube.com/channel/UCnhZDeGhjsF-b_oEjLEzNuQ/videos"><img alt="You Tube" src="@asset('images/youtube.svg')"></a> 
				  </li>
				 </ul>
			</div>
			<div class="column small-12 large-5 margin-top-medium margin-bottom-medium footer-nav">
				<div class="row">
					<?php if ( is_active_sidebar( 'sidebar-footer-menu-column-1' ) ) { ?>
						<div class="columns small-12 medium-6">
							<?php dynamic_sidebar( 'sidebar-footer-menu-column-1' ); ?>
						</div>
					<?php } ?>
					<?php if ( is_active_sidebar( 'sidebar-footer-menu-column-2' ) ) { ?>
						<div class="columns small-12 medium-6">					
							<?php dynamic_sidebar( 'sidebar-footer-menu-column-2' ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="column small-12 large-4 margin-top-medium margin-bottom-medium">
				<h3>Promotions and Soundproofing Tips</h3>
			</div>
	</section>
	<section id="footer-copyright" class="full-width text-white gray-light">
		<div class="row expanded">
			<div class="column small-12">
				<p class="margin-top-small margin-bottom-small">&copy; <?php echo date("Y"); ?> Quiet Curtains All Rights Reserved</p>
			</div>
		</div>
	</section>
</footer>
