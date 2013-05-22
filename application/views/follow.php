<div class = "container">
	<? if($users->exists()): ?>
	<table class = "table table-hover span7">
		<thead>
			<tr>
				<td class = "span3">Username</td>
			</tr>
		</thead>
		<tbody>
		<? foreach($users as $user) : ?>
		<tr>
			<td>
				<a href = "<?= site_url('profiles/'.$user->username) ?>">
					<?= $user->username ?>
				</a>
			</td>
			<td>
				<a href = "<?= site_url('exercises/browse_exercises/' . $user->id) ?>">
					Exercises Uploaded by <?= $user->username ?>
				</a>
			</td>
		</tr>

		<? endforeach ?>
		</tbody>
	</table>
	<? else: ?>
		<div class = "label label-info">
			You have no <?= $type ?>
	<? endif ?>
</div>