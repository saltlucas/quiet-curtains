export default {
  init() {
    // JavaScript to be fired on the page

  },
  finalize() {
    // JavaScript to be fired on the page, after the init JS
    //Page Menu
		//On toggle fire size calc
		$('#content-body').on('off.zf.toggler', function() {
			$('#page-menu').foundation('_calc', true);
			var asideWidth = $('#page-header').width()*.1666667;
			$('#page-menu').css('max-width', asideWidth.toString());		
		});

		$('#aside-navigation').on('resizeme.zf.trigger', function() {
			$('#page-menu').css('width', '100%');
		});	
  },
};
