// import external dependencies
import 'jquery';
import 'foundation-sites/dist/js/foundation.min';
import 'slick-carousel/slick/slick.min';
import 'seethru/dist/seeThru.min.js';
import 'aos/dist/aos.js';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import page from './routes/page';
import edgOrtho65mm from './routes/edg-ortho-65mm';
import forHealthcareProfessionals from './routes/for-healthcare-professionals';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  /** All pages, note the change from about-us to aboutUs. */  
  page,
  edgOrtho65mm,
  forHealthcareProfessionals,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
