export default {
  init() {
    // JavaScript to be fired on the about us page
  },
  finalize() {
    function activatePoints () {
      $('.product-points li').hover(function(){
        console.log('inside hover');
        if(!$(this).hasClass('active')) {
          $('.product-points li.active').removeClass('active');
          $(this).addClass('active');


          if($('#point-1').hasClass('active')) {
            if(!$('#point-1-info').hasClass('active')) {
              $('.product-points-expanded li.active').removeClass('active');
              $('#point-1-info').addClass('active');
            }
          }
          if($('#point-2').hasClass('active')) {
            if(!$('#point-2-info').hasClass('active')) {
              $('.product-points-expanded li.active').removeClass('active');
              $('#point-2-info').addClass('active');
            }
          }
          if($('#point-3').hasClass('active')) {
            if(!$('#point-3-info').hasClass('active')) {
              $('.product-points-expanded li.active').removeClass('active');
              $('#point-3-info').addClass('active');
            }
          }
          if($('#point-4').hasClass('active')) {
            if(!$('#point-4-info').hasClass('active')) {
              $('.product-points-expanded li.active').removeClass('active');
              $('#point-4-info').addClass('active');
            }
          }
          if($('#point-5').hasClass('active')) {
            if(!$('#point-5-info').hasClass('active')) {
              $('.product-points-expanded li.active').removeClass('active');
              $('#point-5-info').addClass('active');
            }
          }                                     
        }
      });
    }

    $(window).on('changed.zf.mediaquery', function(event, large, medium) {
    // newSize is the name of the now-current breakpoint, oldSize is the previous breakpoint
      activatePoints();
    });

    if (Foundation.MediaQuery.atLeast('large')) {
      activatePoints();
    }    
  },
};
