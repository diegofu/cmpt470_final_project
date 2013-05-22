<form action = "<?= site_url('messager/send') ?>" method = "post" id = "message-form">
	<div>
		<?= form_label('To', 'to') ?>
		<?= form_input(array('id'=>'to', 'name'=>'to', 'class'=>'span4 required', 'value'=> isset($username) ? $username :'')) ?>
	</div>
	<div>
		<?= form_label('Subject', 'subject') ?>
		<?= form_input(array('id'=>'subject', 'name'=>'subject', 'class'=>'span4 required')) ?>
	</div>
	<div>
		<?= form_label('message', 'content') ?>
		<?= form_textarea(array('id'=>'message', 'name'=>'content', 'class'=>'span4 required')) ?>
	</div>

	<div class = "span4 align-right">
		<a href = "#" class = "btn btn-primary" id = "message-send">Send</a>
		<a href = "#" class = "btn" id = "message-cancel">Cancel</a>
	</div>
</form>
