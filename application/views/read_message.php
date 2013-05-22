<div id = "read-message">
	<div class = "container-box span11">
		<div class = "header"><i class = "icon-flag"></i><?= $message->subject ?></div>
		<p>
			<small>
				<b><?= $to_name ?></b> send this to you when <?= $message->send_time ?>
			</small>
		</p>
		
	</div>
	<pre>
		<p><?= $message->content ?></p>
	</pre>
	<a href="<?= site_url('/messager/delete/'.$message->id) ?>" class="btn btn-danger" >Delete</a>
	<? if($message->from != $this->tank_auth->get_user_id()): ?>
		<a href="#" class="btn reply_message_btn" >Reply</a>
	<? endif ?>
	<?= form_hidden('from_id', $message->from) ?>
</div>	