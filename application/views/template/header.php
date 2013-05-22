<div class="header">
	<div class="navbar navbar-inverse">
	  <div class="navbar-inner">
		<a class="brand" href="<?= site_url('/') ?>">TheTeam</a>
		<ul class="nav">
			<? 
				$home = $view == ('welcome') ? 'active' : '';
				$all_exercises = $view == ('all_exercises') ? 'active' : '';
				$create_exercise = $view == ('upload_exercise') ? 'active' : '';
				$browse_collections = $view == ('all_collections') ? 'active' : '';
				$create_collection = $view == ('upload_collection') ? 'active' : '';
				
			?>
		  <li class="<?=$home?>"><a href="<?= site_url('/') ?>">Home</a></li>
		  <li class="<?=$all_exercises?>"><a href="<?= site_url('exercises/browse_exercises') ?>">Browse Exercises</a></li>
		  <!-- Collection is a list of exercise created by a user, not yet implemented -->
		  <li class="<?=$browse_collections?>"><a href="<?= site_url('collections') ?>">Browse Collections</a></li>
		  <li class="<?=$create_exercise?>"><a href="<?= site_url('exercises/') ?>">Create Exercise</a></li>
		  <li class="<?=$create_collection?>"><a href="<?= site_url('collections/create') ?>">Create Collection</a></li>
		</ul>

		  
		  <div class="pull-right">
			<? if($this->tank_auth->is_logged_in()): ?>
			<form class="navbar-search" action = "<?=site_url('exercises/browse_exercises/') ?>" method = "post">
		  	 	<?= form_input(array( 'name'=>'search_fields','class'=>'search-query span2 ','placeholder'=>'Search...', 'value'=>isset($search_fields) ? $search_fields: '')) ?>
		  	</form>
			<ul class="nav">
				<li class="dropdown usermenu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						
							Welcome, <?= $this->tank_auth->get_username() ?>

					<b class="caret"></b>
					<i>
						<b></b>
					</i>						
					</a>		    	
					<ul class="dropdown-menu">
						<li><a href="#" id = "message-box">Messager</a></li>
						<li><a href="<?= site_url('messager/message_box')?>" id = "message-box">Message Box</a></li>
						<li><a href="<?= site_url('profiles/'. $this->tank_auth->get_username()) ?>">Profile</a></li>
						<li><a href="<?= site_url('exercises/browse_exercises/'.$this->tank_auth->get_user_id()) ?>">My Exercises</a></li>
						<li><a href="<?= site_url('auth/logout') ?>">Logout</a></li>
						
					</ul>
				</li> 
			</ul>

			<? else: ?>
				<a href="<?= site_url('auth/login') ?>" class = "btn-inverse btn">Log in</a>
			<? endif ?>
		  </div>
	  </div>
		<?
				$notifications = $this->session->get_usermsg();
				if( $notifications ) {
					foreach($notifications as $notification) {
	
						echo 
						'<div id = "alert" class = "alert ' .$notification[0].'">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$notification[1]
						.'</div>';
					}
				}

				$this->session->clear_usermsg();

			?> 
	</div>
</div>