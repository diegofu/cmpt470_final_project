<div class = "span8" id = "exercises-container">
		<? foreach($exercises as $exercise): ?>
		<div class = "span8 body">
			<div class = "span7 information">
				<div class = "span8 title">
					<h3><a href = "<?=site_url('exercises/view_exercise/'.$exercise->id) ?>"><?= $exercise->title ?></a></h3>
				</div>
				<div class="span7 tags">
					<? 	$exercise->tag->get();
						foreach ($exercise->tag as $t) {
							echo '<span class="label label-info">' . $t->name . '</span>';
						}
					?>
				</div>
				<div class = "span">
					<span class = "label">
						<?= $exercise->get_plang()->name ?>
					</span>
				</div>
				<div class = "span">
					<small>
						<i class = "icon-comment"></i>
						<span><?= $exercise->count_discussion() ?></span>
						<span>discussions</span>
					</small>
				</div>
				<? $last_discussion = $exercise->last_discussion() ?>
				<?	if($last_discussion) : ?>
					<div class = "span">
						<small>
							<i class = "icon-time"></i>
							<span>Last discussion by: </span>
							<span>
								<a href = "<?= site_url('profiles/'.$last_discussion->get_user()->username) ?>"><?= $last_discussion->get_user()->username ?></a>
							</span>
							<span>
								<?= explode_year($last_discussion->created_time) ?>
							</span>
						</small>
					</div>
					<div class = "span">
						<small>
							
						</small>
					</div>
				<? endif ?>
				<div class = "span">
					<small>
						<span>Created by</span>
						<span>
							<a href = "<?= site_url('profiles/'.$exercise->get_user()->username) ?>"><?= $exercise->get_user()->username ?></a>
						</span>
						<span>
							<?= explode_year($exercise->created_time) ?>
						</span>
					</small>
				</div>
			</div>
			<div class = "span stat-container">
				<div class = "stat-header">
					<small>Views</small>
				</div>
				<div class = "stat"><?= $exercise->view_count() ?></div>
			</div>
			<div class = "span stat-container darker">
				<div class = "stat-header">
					<small>Ups</small>
				</div>
				<div class = "stat"><?= $exercise->vote_up() ?></div>
			</div>
		</div>
	<? endforeach ?>		



	<div class="pagination pagination-centered span8" id = "exercises">
	  <ul>
	  	<? if($total_pages == 0): ?>
	  		<span class = "label label-info">Sorry, there is no matching results</span>
	  	<? else : ?>
		  	<? for($i = 1; $i <= $total_pages; $i++): ?>
		    	<li class = "<?= $page == $i ? 'active' : '' ?>"><a href="#"><?= $i ?></a></li>
			<? endfor ?>
		<? endif ?>
	  </ul>
	</div>
</div>

