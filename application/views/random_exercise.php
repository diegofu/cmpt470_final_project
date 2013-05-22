<div class = "span3 exercise" id = "<?= $exercise->id ?>">
	<div class = "span">
		<h4>
			<a href ="<?= site_url('exercises/view_exercise/'.$exercise->id) ?>"><?= $exercise->title ?></a>
		</h4>
	</div>
	<div class = "span3 align-right">
		<span class = "label"><?= $exercise->get_plang()->name ?></span>
		<i class = "icon-time"></i>
		<span class = "tiny"><?= $exercise->created_time ?></span>
	</div>
</div>