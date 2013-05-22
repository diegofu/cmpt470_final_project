<div class="hero-unit span7">
	<div class="pull-left">
		<?  if(is_null($profile->avatar)){
				echo img('img/140x140.gif');
			}
			else{
				echo img(base_url().$profile->avatar);
			}
			
		?>
	</div>
	<div class="span5">
	<h2><?= $username ?></h2>
		</div>
	
	<? if (!$self) : ?>
		<form method="post" action="<?= site_url('/profiles/follow') ?>" class = "span1">
			<?= form_hidden('follow_id', $follow_id) ?>
			<input type="hidden" name="do" value="<? if ($Isfollowing) echo 'unfollow'; else echo "follow" ?>" >
			<input type="submit" class="btn <?= $Isfollowing ? '':'btn-primary' ?>" id="follow_btn" value="<? if ($Isfollowing) echo 'Unfollow'; else echo "Follow"; ?>"> 
		</form> 
		<a href="#" class="btn span" id = "send-message">Send Message</a>
		<a href="<?= site_url('exercises/browse_exercises/'.$follow_id) ?>" class="btn span" id = "send-message">View his/her exercises</a>
	<? else: ?>
		<div class = "span">
			<a href = "<?= site_url('profiles/followers') ?>" class = "btn btn-info">Followers</a>
			<a href = "<?= site_url('profiles/followings') ?>" class = "btn btn-info">Followings</a>
		</div>
	<? endif ?>

</div>
<div class="well span8">
<?php
?>
	<dl class="dl-horizontal">
	  <dt>First Name</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->firstname ?>" readonly="readonly">
		</div>
	  </dd>
	  <dt>Last Name</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->lastname ?>" readonly="readonly">
		</div>
	  </dd>
	  <dt>Email</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->email ?>" readonly="readonly">
		</div>
	  </dd>
	  <dt>Phone</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->phone ?>" readonly="readonly">
		</div>
	  </dd>
	  <dt>Address</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->address ?>" readonly="readonly">
		</div>
	  </dd>
	  <dt>Website</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->website ?>" readonly="readonly">
		</div>
	  </dd>
	  <dt>Company</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" placeholder="<?= $profile->company ?>" readonly="readonly">
		</div>
	  </dd>
	</dl>
	<?php if ($self):?>
	<form action = "<?=site_url('profiles/updateProfiles')?>" method = "post" class="span">
		<?= form_hidden('type', 0) ?>
		<?= form_submit(array('id'=> 'submit', 'value'=>'Edit Profile', 'class'=>'btn btn-primary span')) ?>
	</form>
	<?php  endif;   ?>
</div>


	

	







