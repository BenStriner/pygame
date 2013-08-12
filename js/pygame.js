
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
		$('#levelwrapper').clearQueue('pygamequeue');
		d = JSON.parse(data);
		steps=d['steps'];
		width = d['tilesize'][0];
		height = d['tilesize'][1];
		for(i=0;i<steps.length;i++){
			for(j=0;j<steps[i].length;j++){
				if(steps[i][j][0] == 'move'){
					step = steps[i][j];
					distleft = width * step[2];
					disttop = height * step[3];
					cmd = "jQuery('#pygame_player_"+steps[i][j][1]+"').animate({ left: ('+="+distleft+"'), top:('+="+disttop+
							"')}, 1000, 'swing',	function(){	jQuery('#levelwrapper').dequeue('pygamequeue');});";
					$('#levelwrapper').queue(
						'pygamequeue', 
						new Function(cmd)
					);

				}
				 else if(steps[i][j][0] == 'win'){
					$('#levelwrapper').queue('pygamequeue', function(){
						jQuery('#popupwin').show();
						jQuery('#levelwrapper').dequeue('pygamequeue');
					});
				}
				 else if(steps[i][j][0] == 'lose'){
					$('#levelwrapper').queue('pygamequeue', function(){
						jQuery('#popuplose').show();
						jQuery('#levelwrapper').dequeue('pygamequeue');
					});
				}
			}
			}
			$('#levelwrapper').dequeue('pygamequeue');
		}
	;
})(jQuery);


