export default {
  init() {
    // JavaScript to be fired on the page

  },
  finalize() {
  	$("#client-list")
  .on("on.zf.toggler", function(e) {
    $('.client-toggler').toggleClass('toggler-active');
  })
  .on("off.zf.toggler", function(e) {
    $('.client-toggler').toggleClass('toggler-active');
  });
  },
};

