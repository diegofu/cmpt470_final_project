$(function(){
	var base_url = $('input#base_url').val();
	$('#collections-search-form #submit').click(function(e){
		e.preventDefault();
		submitForm();
	});

	$('#collections-search-form #search_fields').keyup(function(){
		submitForm();
	});

	function submitForm(){
		var form = $('#collections-search-form');
		form.ajaxSubmit({
			success: function(data){
				$filtered_data = $(data).filter("#collections-container");
				$('#collections-container').replaceWith($filtered_data);
			}
		});
	}

	$('#collections.pagination li a').live('click', function(e){
		e.preventDefault();
		if($(this).parent().hasClass('active')) return;
		var input = $("<input>").attr("type", "hidden").attr("name", "page").val($(this).html());
		$('#collections-search-form').append($(input));
		var url = base_url + 'collections/update/' + $('input[name = "author_id"]').val();
		console.log(url);
		$('#collections-search-form').ajaxSubmit({
			url : url,
			success: function(data){
				$filtered_data = $(data).filter("#collections-container");
				$('#collections-container').replaceWith($filtered_data);
			}
		})
	});
});