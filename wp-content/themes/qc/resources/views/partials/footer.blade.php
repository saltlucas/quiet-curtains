<footer id="footer" class="content-info">
	<section id="footer-contact" class="full-width text-white blue">
		<div class="row">
			<div class="column small-12 medium-8 large-9 footer-address block vertical-full margin-top-medium margin-bottom-medium">
				<a class="brand" href="{{ home_url('/') }}"><img class="white" alt="{{ get_bloginfo('name', 'display') }}" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo@2x-100.png"></a>

				<p class="footer-links"><a class="button" title="contact" href="<?php echo get_page_link(13); ?>">Contact</a></p>

			</div>
			<div class="column small-12 medium-4 large-3 margin-top-medium">
				<h4>Follow Us</h4>
				<ul class="inline-list social-list">
				<li>
				      <a target="_blank" title="LinkedIn" href="//www.linkedin.com/company/10368714/"><img alt="LinkedIn" src="@asset('images/linkedin.svg')"></a>  
				</li>
			    <li>
				    <a target="_blank" title="You Tube" href="//www.youtube.com/channel/UCnhZDeGhjsF-b_oEjLEzNuQ/videos"><img alt="You Tube" src="@asset('images/youtube.svg')"></a> 
				  </li>
				  </ul>
				</div>
			</div>
	</section>
	<section id="footer-copyright" class="full-width text-white blue-dark">
		<div class="row">
			<div class="column">
				<div class="small-12">
					<p class="margin-top-small margin-bottom-small">&copy; 2017 Edge Surgical All Rights Reserved</p>
				</div>
			</div>
		</div>
	</section>
</footer>
