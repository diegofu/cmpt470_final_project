$(function(){
	var base_url = $('#base_url').val();
	$('#submit-exercise').click(function(e){
		e.preventDefault();
		
		
		// $('#exercise_form').validate({
		// 	messages: {
		// 		title: 'Please provide a title to your exercise',
		// 		body: 'Please enter your exercise',
		// 		solution: 'Please provide a solution to your exercise',
		// 	},
		// 	errorPlacement: function(error, element) {
		// 		errorQtip(error,element);
		// 	},
		// 	success: $.noop, // Odd workaround for errorPlacement not firing!
		// });
		$('#exercise_form').submit();
	});	

	$('.helptip').click(function(e){
		e.preventDefault();
	})

	$('.helptip').tooltip();
});