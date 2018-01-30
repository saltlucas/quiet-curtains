<div data-sticky-container>
  <div id="page-menu" class="side-menu" data-sticky data-margin-top="0" data-top-anchor="fact-section" data-btm-anchor="content-body:bottom">
  <div id="aside-collapse" data-toggle="content-body">-</div>
  <div id="aside-expand" class="vertical-text" data-toggle="content-body">+<span class="vertical">Topics</span></div>
  <div class="menu-content">
    <h4>Topics</h4>
    <ul class=" vertical menu" data-magellan data-offset="-34" data-animation-easing="swing" data-animation-duration="600">
    <?php while ( have_rows('sidebar_menu') ) : the_row(); ?>
      <li><a href="#<?php the_sub_field('url'); ?>"><?php the_sub_field('label'); ?></a></li>
    <?php endwhile; ?>
    </ul>
  </div>
  </div>
</div>