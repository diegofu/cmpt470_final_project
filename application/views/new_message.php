
<form action="/messager/send" method="post">
	<div class="input-prepend">
		<input type="text" class="span4" name="to" placeHolder="Send to" value="<?= $to ?>">
	</div>
	<div class="input-prepend">
		<input type="text" class="span4" placeHolder="Subject" name="subject" >
	</div>
	<div class="input-prepend">
		<textarea class="span4" name="content" placeHolder="Content" rows="3"></textarea>
	</div>
	<div>
		<a class="btn btn-primary pull-right send_message_btn">Send</a>
	</div>
</form>