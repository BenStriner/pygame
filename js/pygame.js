
(function($) {
	$.fn.ai_game_slider = function(data) {
		$ds = $('#results-div .csstable');
		$ds.hide().eq(0).show();
		setInterval(function(){
			$ds.filter(':visible').fadeOut(function(){
				var $div = $(this).next('div');
				if ( $div.length == 0 ) {
					$ds.eq(0).fadeIn();
				} else {
					$div.fadeIn();
				}
			});
		}, 800);
	};
})(jQuery);
