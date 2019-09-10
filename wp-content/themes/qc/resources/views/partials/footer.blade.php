<footer id="footer" class="content-info">
	<section id="footer-content" class="full-width text-white gray-medium">
		<div class="row expanded">
			<div class="column small-12 large-6 margin-top-medium margin-bottom-medium">
				<div class="contact-info">
					<p class="h3 phone">858.272.3615</p>
					<p class="contact-link"><a href="mailto:info@acoustic-curtains.com">info@acoustic-curtains.com</a> | <a href="<?php echo get_site_url(null, '/contact/'); ?>">Contact</a></p>
				</div>
				<div class="address margin-top-small margin-bottom-small">
					<p>Quiet Curtains</p>
					<p>San Diego, CA 92127</p>
					<p>International Orders<br>
						001.858.272.3615</p>
				</div>
				<div>
				</div>
				<ul class="inline-list social-list">
				<li>
				      <a target="_blank" title="Facebook" href="//www.facebook.com/QuietCurtains/"><img alt="Facebook" src="@asset('images/facebook.svg')"></a>
				</li>
				<li>
				      <a target="_blank" title="Twitter" href="//twitter.com/quietcurtains"><img alt="Twitter" src="@asset('images/twitter.svg')"></a>
				</li>
				<li>
				      <a target="_blank" title="Pinterest" href="//www.pinterest.com/quietcurtains/"><img alt="Pinterest" src="@asset('images/pinterest.svg')"></a>
				</li>
				 </ul>
			</div>
			<div class="column small-12 large-1 margin-top-medium margin-bottom-medium footer-nav">
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
			<div class="column small-12 large-5 margin-top-medium margin-bottom-medium">
				<h3>Promotions and Soundproofing Tips</h3>
				<!-- Begin MailChimp Signup Form -->
				<!-- <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css"> -->
				<div id="mc_embed_signup">
				<form action="https://quietcurtains.us18.list-manage.com/subscribe/post?u=87b98df703490385e5ace7b4a&amp;id=b58b13ba67" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div id="mc_embed_signup_scroll">
				<div class="row collapse">
					<div class="column small-12 large-8 left-input">
						<div class="mc-field-group">
							<input type="email" value="" placeholder="Email Address" name="EMAIL" class="required email" id="mce-EMAIL">
						</div>
				    	<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_87b98df703490385e5ace7b4a_b58b13ba67" tabindex="-1" value=""></div>
					</div>
					<div class="column small-12 large-3 end">
				   		<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
					</div>
				</div>
					<div id="mce-responses">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
				</div>
				</form>
				</div>
				<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
				<!--End mc_embed_signup-->
			</div>
	</section>
	<section id="footer-copyright" class="full-width text-white gray-medium">
		<div class="row expanded">
			<div class="column small-12">
				<p class="margin-top-small margin-bottom-small">&copy; <?php echo date("Y"); ?> Quiet Curtains All Rights Reserved</p>
			</div>
		</div>
	</section>
</footer>
