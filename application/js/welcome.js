var checkExercise_start_time = new Date();
var base_url = $('#base_url').val();
setInterval(checkExercise, 2000); //every 5 secs
function checkExercise() {
	var checkExercise_end_time = new Date();
	if( (checkExercise_end_time - checkExercise_start_time) / 1000 >= 5 ){
		url = base_url + 'exercises/random_exercise/';
		$.getJSON(url, function(data){
			if(data) {
				var replace = Math.floor((Math.random()*10)+1);
				if($('#random-exercises').children('#' + data.id).length == 0) {
					$('#random-exercises').children(':nth-child('+replace+')').fadeOut('slow', function(){
						$(this).replaceWith(data.view).fadeIn('slow');})
				}
			}
		})
		checkExercise_start_time = checkExercise_end_time;
	}
		
}
		
	