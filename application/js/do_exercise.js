var lang = new Array();
lang['C++'] = 'c_cpp';
lang['Java'] = 'java';
lang['C'] = 'c_cpp';
lang['Python'] = 'python';

$(document).ready(function() {
	/** AJAX for compiling code **/
	var base_url = $('#base_url').val();
	$("#run_code").click(function(event) {
		
		/* stop form from submitting normally */
		event.preventDefault(); 
		// say something so the user doesnt press run again
		// only seen if too slow, maybe add some facy loading js later
		
		
		/* get code from input: */
		var e_id = $("#exercise_id").attr("value");
		f_code = editor.getValue(),
		url = $("#code_pane form").attr("action");
		if(!f_code) {
			$('#code_pane').qtip({
				overwrite: false,
				content: 'The body of your code cannot be empty',
				show: {
					ready: true,
					event: false,
				},
				position: {
					my: 'right center',
					at: 'left center',
				},
				hide: false,
				style: {
					classes: 'qtip-red' // Make it red... the classic error colour!
				}					})
		} else{
			destroyQtip($('#code_pane'));
			$("#collapseOne").collapse('hide');
			$("#collapseTwo").collapse('show');
			$("#collapseThree").collapse('show');
			$("#run_results").empty().append("Your program is being compiled and run, please wait!");
			/* Send the data using post and put the results in a div */
			$.ajax({
				type: "POST",
				url: url,
				dataType: 'json',
				data: { exercise_id: e_id, code: f_code },
				success: function(data) {
				   if(data.redirect) {
				   		document.location.href= data.redirect;
				   }
				   $( "#run_results" ).empty().append(data.output);
				   if(data.correct) {
				   	$('#run_correctness').attr('class', 'label label-sucess').html('Congradulations!');
				   } else {
				   	$('#run_correctness').attr('class', 'label label-important').html('Sorry, please try again!');
				   }
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(xhr.responseText);
				}
			});
		}
		
		
	});

	// load the solution and template

	var l = $('input[name="language"]').val();
	var editor = ace.edit("code");
	editor.setTheme("ace/theme/eclipse");
	editor.getSession().setMode("ace/mode/" + lang[l]);
	editor.setValue($("input[name='template']").val());

	var solutioneditor = ace.edit("solutioncode");
	solutioneditor.setTheme("ace/theme/eclipse");
	solutioneditor.getSession().setMode("ace/mode/" + lang[l]);
	solutioneditor.setValue($("input[name='solution']").val());
});