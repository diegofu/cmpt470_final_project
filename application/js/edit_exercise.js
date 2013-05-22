var lang = new Array();
lang['C++'] = 'c_cpp';
lang['Java'] = 'java';
lang['C'] = 'c_cpp';
lang['Python'] = 'python';

function reformat(text)
{
	var el = document.createElement("div");
	el.innerText = el.textContent = text;
	text = el.innerHTML;
	
	text = text.replace(" ", "&nbsp;")
	text = text.replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;")
	text = text.replace("\n", "<br />")

	return text;
}

function isNothing(text) {
	for(var j=0; j<text.length;j++)
	{
		if(text[j] != ' ' && text[j] != '\t' && text[j] != '\n' && text[j] != '\r')
			return false;
	}
	return true;
}

$(document).ready(function() {
	// add editors
	var solution_editor = ace.edit("solution");
	solution_editor.setTheme("ace/theme/eclipse");
	solution_editor.getSession().setValue("");
	var s_h = $('input[type="hidden"][name="solution"]');
	solution_editor.getSession().on('change', function(){
		s_h.val(solution_editor.getSession().getValue());
	});		
	solution_editor.setValue($("input[name='solution']").val());

	var template_editor = ace.edit("template");
	template_editor.setTheme("ace/theme/eclipse");
	var t_h = $('input[type="hidden"][name="template"]');
	template_editor.getSession().on('change', function(){
		t_h.val(template_editor.getSession().getValue());
	});
	template_editor.setValue($("input[name='template']").val());

	var instruction_editor = ace.edit("instructions");
	instruction_editor.setTheme("ace/theme/eclipse");
	instruction_editor.getSession().setMode("ace/mode/text");
	instruction_editor.getSession().setValue('');
	var i_h = $('input[type="hidden"][name="instruction"]');
	instruction_editor.getSession().on('change', function(){
		i_h.val(instruction_editor.getSession().getValue());
	});
	instruction_editor.setValue($("input[name='instruction']").val());

	$('select[name=language]').change(function(){
		var ln = $(this).children('[value=' + $(this).val() + ']');
		var l = lang[ln.html()];
		solution_editor.getSession().setMode("ace/mode/" + l);
		template_editor.getSession().setMode("ace/mode/" + l);
	})
	
	$('select[name=language]').val($("input[name='language']").val());
	$('select[name=language]').change();

	$("#tags").tagit({
		availableTags: $('#base_url').val() + 'exercises/getTags'
	});


	function submit_exercise() {
		$('#upload_exercise_form').submit();
	};

	function get_output () {
		$("#expected-output .hero-unit").empty().append("Generating your expected output, please wait a moment...");
		$('.ue-next').addClass('disabled');


		$f_code = solution_editor.getValue(),
		$url = $('#base_url').val() + "submissions/e_output";
		/* Send the data using post and put the results in a div */
		$.post( $url, { code: $f_code,  language: $('select[name=language]').val()},
			function( data ) {
					$( "#expected-output .hero-unit" ).empty().append(data);
					$('.ue-next').removeClass('disabled');
			}
		);
	}

	$('a.ue-next').click(function(event) {
		event.preventDefault();
		var active_tab = $('.nav-tabs .active');
		var active_pane = $('.tab-content .active');
		var href = $('.nav-tabs .active a').attr('href');
		var go_next = false;
		switch(href) {
			case '#title-tags':
				if($('input[name="title"]').val() != '') {
					$('.ue-back').parent().removeClass('disabled');
					destroyQtip($('input[name="title"]'));
					go_next = true;
				} else {
					errorQtip('Please provide a title', $('input[name="title"]'));
				}
				break;
			case '#sol-temp':
				go_next = true;
				get_output();
				break;
			case '#expected-output':
				go_next = true;
				$('.ue-next').empty().append('Submit');
				review();
				break;
			case '#review-submit':
				go_next = true;
				submit_exercise();
				break;
		}
		if(go_next == true) {
			active_tab.removeClass('active');
			active_pane.removeClass('active');
			active_tab.next().addClass('active');
			active_pane.next().addClass('active');
			$('.disabled.active').removeClass('disabled');
		}
	});
	$('a.ue-back').click(function(event) {
		event.preventDefault();
		var active_tab = $('.nav-tabs .active');
		var active_pane = $('.tab-content .active');
		var href = $('.nav-tabs .active a').attr('href');
		active_tab.removeClass('active');
		active_pane.removeClass('active');
		active_tab.prev().addClass('active');
		active_pane.prev().addClass('active');
		switch(href) {
			case '#title-tags':
				break;
			case '#sol-temp':
				break;
			case '#expected-output':
				break;
			case '#review-submit':
				$('.ue-next').empty().append('Next');
				break;
		}
		$('.disabled.active').removeClass('disabled');
	});
	$('a[href$="#title-tags"]').click(function(event){
		event.preventDefault();
		$('.ue-next').empty().append('Next');
		$('.disabled.active').removeClass('disabled');
		$('.ue-back').parent().addClass('disabled');
	});
	$('a[href$="#expected-output"]').click(function(event){
		event.preventDefault();
		get_output();
		next_state();
	});
	$('a[href$="#sol-temp"]').click(function(event){
		event.preventDefault();
		next_state();
	});
	$('a[href$="#review-submit"]').click(function(event){
		event.preventDefault();
		$('.ue-next').empty().append('Submit');
		$('.disabled.active').removeClass('disabled');
		$('.ue-back').parent().removeClass('disabled');
		review();
	});

	function next_state (){
		$('.ue-next').empty().append('Next');
		$('.disabled.active').removeClass('disabled');
		$('.ue-back').parent().removeClass('disabled');
	}

	function review () {
		title = $('input[name="title"]').val();

		instruction = instruction_editor.getValue();
		solution = solution_editor.getValue();
		expected_output = $( "#expected-output .hero-unit" ).html();
		template = reformat(template_editor.getValue());

		if (isNothing(title))
		{
			title = "<span class=\"label-important\">You need a title</span>";
		}

		if (isNothing(instruction))
		{
			instruction = "<span class=\"tabel label-important\">You need to write instruction</span>";
		} else {
			instruction = reformat(instruction);
		}

		if (isNothing(solution))
		{
			solution = "<span class=\"tabel label-important\">You need to write solution</span>";
		} else {
			solution = reformat(solution);
		}

		// man this looks horrible... need to make \n appear somehow
		$("#review-submit .hero-unit").empty().append("<span class=\"label label-success input-info\"><h4>Title</h4></span><br />" + title + "<br /><br />").html();
		$("#review-submit .hero-unit").append("<span class=\"label label-success input-info\"><h4>Exercise instruction</h4></span><br /> " + instruction + "<br /><br />").html();
		$("#review-submit .hero-unit").append("<span class=\"label label-success input-info\"><h4>Solution</h4></span><br /> " + solution + "<br /><br />").html();
		$("#review-submit .hero-unit").append("<span class=\"label label-success input-info\"><h4>Expected output</h4></span><br /> " + expected_output + "<br /><br />").html();
		$("#review-submit .hero-unit").append("<span class=\"label label-success input-info\"><h4>Starting template</h4></span><br /> " + template + "<br /><br />")
	}
});