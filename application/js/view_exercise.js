$(function(){
	var base_url = $('#base_url').val();
	$('a#vote_up').bind('click', function(e){
		e.preventDefault();
		if($(this).hasClass('disabled')) return;
		vote('vote_up', $(this));
	});

	$('a#vote_down').bind('click', function(e){
		e.preventDefault();
		if($(this).hasClass('disabled')) return;
		vote('vote_down', $(this));
	});

	$('a#add_solution').bind('click', function(e){
		e.preventDefault();
		$(this).next().toggle();
	});


	function vote(action, self) {
		var exercise_id = self.parents('.container').find('input[name="exercise_id"]').val();
		$.getJSON(base_url + 'exercises/'+action+'/'+exercise_id, function(data){
			if(data.error){
				self.qtip({
					content: data.error,
					show: {
						ready: true,
						event: false,
						solo: true,
					},
					position: {
						my: 'left center',
						at: 'right center',
					},
					style: {
						classes: 'qtip-red' // Make it red... the classic error colour!
					},
				})
			} else {
				self.find('.number').html(data.number);
				$('#exercise-detail .number').parent().addClass('disabled');
			}
		});
	};
});