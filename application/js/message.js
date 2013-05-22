$(function(){
	var base_url = $('#base_url').val();
	$('.messager li').click(function(e){
		e.preventDefault();
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		$('#inbox-body').toggle();
		$('#outbox-body').toggle();

	})

	$('#read-message .reply_message_btn').click(function(e){
		e.preventDefault();
		var from = $('input[name="from_id"]').val();
		var url = base_url + 'messager/fetch_page/'+from;
		var self = $(this);
		$.get(url, function(data){
			$.fancybox({content: data, closeBtn: false, autoSize: true, });
		})
	})
});