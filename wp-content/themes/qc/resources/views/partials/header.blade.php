<div class="sticky-container" data-sticky-container>
<header class="container sticky" data-sticky data-margin-top="0" data-stikcy-on="large" data-btm-anchor="footer:top">
    <div class="clearfix">
        <div class="nav-logo float-left">
        <a class="brand" href="{{ home_url('/') }}"><img alt="{{ get_bloginfo('name', 'display') }}" style="max-height: 55px;" src="@asset('images/Logo.svg')"></a>
        </div>
        <div class="nav-toggle hide-for-large">
            <div class="button-container">
                <button type="button" data-toggle="nav-primary" data-toggle="nav-primary" class="navigation-button button">
                    <div class="menu-icon"></div>    
                    <span class="button-text">Menu</span>                           
                </button>
            </div>
        </div>
        <div class="nav-menu float-left">
            <nav id="nav-primary" class="nav-primary off-canvas in-canvas-for-large position-right" data-off-canvas>
            <button class="close-button hide-for-large" aria-label="Close menu" type="button" data-close="">
              <span aria-hidden="true">×</span>
            </button>
            @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav vertical large-horizontal menu dropdown', 'items_wrap' => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>']) !!}
            @endif
            </nav>
        </div>
        <div class="nav-utility show-for-large">
            <div class="header-cta-text"> Call <a href="tel:858.272.3615">858.272.3615</a></div>
        </div>
    </div>
</header>
</div>