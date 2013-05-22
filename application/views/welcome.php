<? $last = $user_view->last_ten($this->tank_auth->get_user_id()); ?>
<? if($last->exists()): ?>
<div class="container container-box exercise_list">
	<div class = "header">
		Exercises you recently viewed:
	</div>
	<? foreach($last as $v): ?>
	<? $exercise = $v->get_exercise() ?>
		<div class = "span3 exercise">
			<div class = "span">
				<h4>
					<a href ="<?= site_url('exercises/view_exercise/'.$exercise->id) ?>"><?= $exercise->title ?></a>
				</h4>
			</div>
			<div class = "span3 align-right">
				<i class = "icon-time"></i>
				<span class = "tiny"><?= $v->created_time ?></span>
			</div>
		</div>
	<? endforeach ?>
</div>
<? endif ?>

<div class="container container-box exercise_list">
	<div class = "header">
		Popular Exercises:
	</div>
	<? $popular = $user_view->popular(); ?>
	<? foreach($popular as $v): ?>
	<? $exercise = $v->get_exercise() ?>
		<div class = "span3 exercise">
			<div class = "span">
				<h4>
					<a href ="<?= site_url('exercises/view_exercise/'.$exercise->id) ?>"><?= $exercise->title ?></a>
				</h4>
			</div>
			<div class = "span3 align-right">
				<i class = "icon-heart"></i>
				<span class = "tiny"><?= $exercise->view_count() ?></span>
			</div>
		</div>
	<? endforeach ?>
</div>

<div class="container container-box exercise_list">
	<div class = "header">
		Recently Exercises Created By Others:
	</div>
	<div class = "span" id = "random-exercises">
	<? foreach($exercises as $exercise): ?>
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
	<? endforeach ?>
	</div>
</div>
