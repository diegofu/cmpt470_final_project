$(function () {
	$("#password").complexify({
		minimumChars: 4,
		strengthScaleFactor: 0.5,
	}, function (valid, complexity) {
		if (!valid) {
			$('#progress').css({'width':complexity + '%'}).removeClass('progressbarValid').addClass('progressbarInvalid');
		} else {
			$('#progress').css({'width':complexity + '%'}).removeClass('progressbarInvalid').addClass('progressbarValid');
		}
		var color = '';
		if(complexity <= 25) {
			color = 'progress-danger progress progress-striped';
		} else if(complexity <= 45) {
			color = 'progress-warning progress progress-striped';
		} else {
			color = 'progress-success progress progress-striped';
		}
		$('#complexity').attr('class', color);
		$('#complexity').html('<div class = "bar" style = "width:' + complexity + '%"></div>')
	});
});
