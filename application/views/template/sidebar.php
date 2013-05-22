<div id="navpane">
	<ul id="sidebar">
		<form action = "<?= site_url('exercises/browse_exercises/') ?>" method = "post" id = "search-exercises">
			<?= form_label('Search for exercises', 'search_fields') ?>
			<?= form_input(array('id' => 'search_fields', 'name'=>'search_fields', 'class'=>'span3')) ?>
			<?= form_label('Type of Language', 'type') ?>
			<?= form_dropdown('type', array('0'=>'Any', '1'=>'C', '2'=>'C++'), 'Any', 'class = "span3"') ?>
			<div id = "submit-sidebar">
				<?= form_submit(array('value'=>'Find Exercises', 'class'=>'btn span3')) ?>
			</div>
		</form>
	</ul>
</div>