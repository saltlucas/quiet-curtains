<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="row">
		<div class="column small-12 medium-8">
    	<input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    </div>
    <div class="column small-12 medium-4">
    	<input type="submit" class="search-submit button"
        value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
    </div>
  </div>
</form>