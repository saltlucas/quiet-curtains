export default {
  init() {
    // JavaScript to be fired on the about us page
  },
  finalize() {
    $('.open-hover').mouseenter(function(){
        var revealId = "#";
        revealId += $(this).attr("data-hover");
        $(revealId).foundation('open');
    });

    $('.reveal').mouseleave(function(){
      $(this).foundation('close');
    });
  },
};