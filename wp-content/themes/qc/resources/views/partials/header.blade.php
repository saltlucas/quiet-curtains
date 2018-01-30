<div class="sticky-container" data-sticky-container>
<header class="container sticky" data-sticky data-margin-top="0" data-stikcy-on="large" data-btm-anchor="footer:top">
    <div class="row collapse">
        <div class="columns small-6 large-2">
        <a class="brand" href="{{ home_url('/') }}"><img alt="{{ get_bloginfo('name', 'display') }}" style="max-height: 55px;" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo@2x-100.png"></a>
        </div>
        <div class="columns small-6 large-10">
            <div class="button-container hide-for-large">
                <button type="button" data-toggle="nav-primary" data-toggle="nav-primary" class="navigation-button button">
                    <div class="menu-icon"></div>    
                    <span class="button-text">Menu</span>                           
                </button>
            </div>
        </div>
        <div class="columns small-12 large-10">
            <nav id="nav-primary" class="nav-primary off-canvas in-canvas-for-large position-right" data-off-canvas>
            <button class="close-button hide-for-large" aria-label="Close menu" type="button" data-close="">
              <span aria-hidden="true">×</span>
            </button>
            @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav vertical large-horizontal menu dropdown', 'items_wrap' => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>']) !!}
            @endif
            </nav>
        </div>
    </div>
</header>
</div>