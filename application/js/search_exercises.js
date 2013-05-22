$(function(){
	var base_url = $('input#base_url').val();
	$('#exercise-search-form #submit').click(function(e){
		e.preventDefault();
		submitForm();
	});

	$('#exercise-search-form select#language').change(function(){
		submitForm();
	});

	$('#exercise-search-form #search_fields').keyup(function(){
		submitForm();
	});

	function submitForm(){
		var form = $('#exercise-search-form');
		form.ajaxSubmit({
			success: function(data){
				$('#exercises-container').replaceWith(data);
			}
		});
	}

	$('#exercises.pagination li a').live('click', function(e){
		e.preventDefault();
		if($(this).parent().hasClass('active')) return;
		var input = $("<input>").attr("type", "hidden").attr("name", "page").val($(this).html());
		$('#exercise-search-form').append($(input));
		var url = base_url + 'exercises/update/' + $('input[name = "author_id"]').val();
		console.log(url);
		$('#exercise-search-form').ajaxSubmit({
			url : url,
			success: function(data){
				$('#exercises-container').replaceWith(data);
			}
		})
	});
});