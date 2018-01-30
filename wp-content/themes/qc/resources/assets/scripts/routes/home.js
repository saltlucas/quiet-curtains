export default {
  init() {
    // JavaScript to be fired on the home page
    // Slick Slider
    $('.slider').slick();
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
    //Transparent Video display
    var transparentVideo = seeThru.create('#transparent-video', {end: 'loop', poster: true});  
  },
};
