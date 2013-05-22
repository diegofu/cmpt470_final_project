

$(function(){
	var base_url = $('#base_url').val();
	$('#message-box').click(function(e){
		e.preventDefault();
		var url = base_url + 'messager/fetch_page';
		var self = $(this);
		$.get(url, function(data){
			$.fancybox({content: data, closeBtn: false, autoSize: true, });
		})
	});

	$('#message-cancel').live('click', function(e){
		e.preventDefault();
		$.fancybox.close();
	});

	$('#message-send').live('click', function(e){
		e.preventDefault();
		$('form#message-form').ajaxSubmit({
			dataType: 'json',
			success: function(data){
				if(data.err){
					if(data.err) {
						$('input#to').qtip({
							overwrite: false,
							content: data.err,
							show: {
								ready: true,
								event: false,
							},
							position: {
								my: 'left center',
								at: 'right center',
							},
							hide: false,
							style: {
								classes: 'qtip-red' // Make it red... the classic error colour!
							}
						})
					}
				} else {
					$.fancybox.close();
				}
			}
		})
	});
	setInterval(checkMessage, 2000);
	function checkMessage() {
		url = base_url + 'messager/check';
		$.get(url, function(data){
			if (data != 0) {
				$('.usermenu i').show();
				$('.usermenu i > b').html(data);
			} else {
				$('.usermenu i').hide();
				$('.usermenu i > b').html(data);
			}
		})
	}
	
	
});