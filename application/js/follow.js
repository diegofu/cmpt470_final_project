$(function(){
	var base_url = $('#base_url').val();
	$('#follow_btn').click(function(e){
		e.preventDefault();

		var options = {
			success: "AjaxResponse", 
		}
		$(this).closest('form').ajaxSubmit({
			success: function (responseText, statusText, xhr, form) {
				if (responseText == '' && statusText == "success") {
					if (form.children('input[name="do"]').val() == 'unfollow') {
						form.children('input[name="do"]').val('follow');
						form.children('input[type="submit"]').val('Follow');
						form.children('input[type="submit"]').attr('class', 'btn btn-primary');
					} else {
						form.children('input[name="do"]').val('unfollow');
						form.children('input[type="submit"]').val('Unfollow');
						form.children('input[type="submit"]').attr('class', 'btn');
					}
				}
			}
		});
	});
	$('#send-message').click(function(e){
		e.preventDefault();
		var from = $('input[name="follow_id"]').val();
		var url = base_url + 'messager/fetch_page/'+from;
		var self = $(this);
		$.get(url, function(data){
			$.fancybox({content: data, closeBtn: false, autoSize: true, });
		})
	})

});