export default {
  init() {
    // JavaScript to be fired on all pages
    // Prevent small screen page refresh sticky bug
    $(window).on('sticky.zf.unstuckfrom:bottom', function(e) {
      if (!Foundation.MediaQuery.atLeast('large')) {
        $(e.target).removeClass('is-anchored is-at-bottom').attr('style', '');
      }
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    //Start AOS
    AOS.init();
    $('.hide-on-load').removeClass('hide-on-load');
  },
};
