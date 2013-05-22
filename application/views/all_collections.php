<div id = "collections-search" class = "span3">
	<form action = "<?=site_url('collections/update/'.$this->uri->segment(3))?>" method = "post" id = "collections-search-form">
		<?= form_label('Search for collections', 'search_fields') ?>
		<?= form_input(array('id' => 'search_fields', 'name'=>'search_fields', 'class'=>'span3', 'value'=>isset($search_fields) ? $search_fields: '')) ?>
		<?= form_submit(array('id'=> 'submit', 'value'=>'Find Collection', 'class'=>'btn span3')) ?>
		<?= form_hidden('author_id', $this->uri->segment(3)) ?>
	</form>
</div>
<div class = "span8" id = "collections-container">
	<? foreach($collections as $collection): ?>
		<div class="span8 body">
			<div class="span7 information">
				<div class="span8 title">
					<h3><a href = "<?=site_url('collections/view_collection/'.$collection->id) ?>"><?= $collection->name ?></a></h3>
				</div>
			</div>
			<div class="span">
				<small>
					<span>Created by</span>
					<span>
						<a href = "<?= site_url('profiles/'.$collection->get_user()->username) ?>"><?= $collection->get_user()->username ?></a>
					</span>
				</small>
			</div>
		</div>
	<? endforeach ?>		



	<div class="pagination pagination-centered span8" id = "collections">
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

