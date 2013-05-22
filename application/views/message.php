<div class="span8 messager">
	<ul class="nav nav-tabs actions">	
		<li class = "active inbox">
			<a href="#">Inbox</a>
		</li>
		<li class = "outbox">
			<a href="#">Outbox</a>
		</li>
	</ul>

	<div class = "span7" id = "inbox-body">
		<table class = "table">
			<thead>
				<tr>
					<td class = "span3">Sender</td>
					<td class = "span4">Subject</td>
					<td class = "span3">Sent at</td>
				</tr>
			</thead>
			<tbody>
				<? foreach($inbox as $o): ?>
				<tr>
					<td>
						<a href = "<?= site_url('profile/'.$o->sender()->username) ?>">
							<?= $o->sender()->username ?>
						</a>
					</td>
					<td>
						<?= $o->read ? '' :'<i class = "icon-envelope"></i>' ?>
						<span class = "<?= $o->read ? '' :'bold' ?>" id = "<?= $o->id ?>">
							<a href = "<?= site_url('messager/read/'.$o->id) ?>">
								<?= substr($o->subject, 0, 60) ?>
							</a>
						</span>
					</td>
					<td>
						<?= $o->send_time ?>
					</td>
				</tr>
				<? endforeach ?>
			</tbody>
		</table>
	</div>
	<div class = "span7 hide"  id = "outbox-body">
		<table class = "table">
			<thead>
				<tr>
					<td class = "span3">Sent To</td>
					<td class = "span4">Subject</td>
					<td class = "span3">Sent at</td>
				</tr>
			</thead>
			<tbody>
				<? foreach($outbox as $o): ?>
				<tr>
					<td>
						<a href = "<?= site_url('profile/'.$o->sender()->username) ?>">
							<?= $o->receiver()->username ?>
						</a>
					</td>
					<td>
						<span id = "<?= $o->id ?>">
							<a href = "<?= site_url('messager/read/'.$o->id) ?>">
								<?= substr($o->subject, 0, 60) ?>
							</a>
						</span>
					</td>
					<td>
						<?= $o->send_time ?>
					</td>
				</tr>
				<? endforeach ?>
			</tbody>
		</table>
	</div>
</div>