
<br/>
<div class="hero-unit" id ="view-exercise-hero-unit">
	<?= form_hidden('exercise_id', $exercise->id) ?>
	<h1><?= $exercise->title ?></h1>
	<p><?= $this->text_format->text_to_html($exercise->instruction) ?></p>
	
	<p>
		Tags:
		<? $exercise->tag->get();
		foreach ($exercise->tag as $t) {
			echo '<span class="label label-info tag">' . $t->name . '</span>';
		} ?>
	</p>

	<p>
		Type: 
		<span class="label"><?= $exercise->get_plang()->name ?></span>
	</p>
	<p>
	<? if($exercise->owned_by($this->tank_auth->get_user_id())): ?>
		<a href = "<?= site_url('exercises/edit_exercise/'.$exercise->id)?>" class = "btn btn-inverse btn-large">Edit Exercise</a>
	<? else: ?>
		<a href="<?=site_url('exercises/do_exercise/'.$exercise->id) ?>" class="btn btn-primary">Attempt this exercise</a>
		
		<a href = "#" class = "btn <?= $exercise->voted($this->tank_auth->get_user_id() ) ? 'disabled' :'' ?>" id = "vote_up">
			<span class = "number"><?= $exercise->vote_up() ?></span>
			<i class="icon-thumbs-up"></i>
		</a>
		<a href = "#" class = "btn  <?= $exercise->voted($this->tank_auth->get_user_id() ) ? 'disabled' :'' ?>" id = "vote_down">
			<span class = "number"><?= $exercise->vote_down() ?></span>
			<i class="icon-thumbs-down"></i>
		</a>

	<? endif ?>
  </p>
  	<div class = "span10 align-right">
  		<small>
  		Created By <a href = "<?= site_url('profiles/'.$exercise->get_user()->username) ?>">
  			<?= $exercise->get_user()->username ?>
  		</a>
  		at <?= $exercise->created_time ?>
  	</small>
	</div>
</div>

<?= $this->load->view($discussion_view) ?>
