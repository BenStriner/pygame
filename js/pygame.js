
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


(function($) {
	$.fn.pygame_steps = function(data) {
		d = JSON.parse(data);
		steps=d['steps'];
		width = d['tilesize'][0];
		height = d['tilesize'][1];
		for(i=0;i<steps.length;i++){
			for(j=0;j<steps[i].length;j++){
				if(steps[i][j][0] == 'move'){
					distleft = width * steps[i][j][2];
					disttop = height * steps[i][j][3];
					$('#pygame_player_'+steps[i][j][1]).animate(
							{ left: ('+='+distleft), top:('+='+disttop)}, 1000
						);
					}
				} else if(steps[i][j][0] == 'win'){
					$('#popupwin').show();
				}
			}
		}
	;
})(jQuery);


