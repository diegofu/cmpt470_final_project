


<? if (is_null($discussions->content)):?>
	<pre class="span11">
		Be the first to comment on!
	</pre>
<? else: ?>
<div class = "container-box span7 discussion">
	<? foreach ($discussions as $d): ?>
		<div class="span7 body">	
			<div class = "span1">
				<img class = "media-object" height = "64" width = "64" src = "<?= site_url($d->avatar())?>">
			</div>
			<div class = "span6">
				<a href = "<?= site_url('profiles/' . $d->get_user()->username) ?>">
					<?= $d->get_user()->username ?>
				</a>
				<small>wrote at <?= $d->created_time ?>:</small>
			</div>
			<div class = "span6">
				<?= $this->text_format->text_to_html($d->content) ?>
			</div>
		</div>
	<? endforeach ?>
	</div>
<? endif ?>
	<form method="post" class="container container-box span7" action="<?= site_url('discussions/submit') ?>" id="discussion_form">

	<div class = "header">make a comment as <i class = "icon-user"></i><?= $this->tank_auth->get_username() ?>:</div>
	
	<?= form_hidden('exercise_id', $exercise->id) ?>
	<textarea id="body" name="body" class="span7" rows="5"></textarea>
	
	<?= form_submit('submit_button','Submit', 'class="btn btn-primary "') ?>
	</form>	


