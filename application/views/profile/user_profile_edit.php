<form enctype="multipart/form-data" method="post" action="<?= site_url('profiles/updateProfiles') ?>" id="profile_form" >
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
	<div class="span">
	Hello,<br/>
	<h1><?= $username ?></h1>
	<?$Fdata = array('name' => 'user_avatar', 'class' => 'file');?><br/>
	<?= form_upload($Fdata);?>
	</div>
</div>
<div class="well span8">
	
		
		<dl class="dl-horizontal">
	  <dt>First Name</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text"  name ="firstname" value="<?= $profile->firstname ?>"  >
		</div>
	  </dd>
	  <dt>Last Name</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text" name ="lastname" value="<?= $profile->lastname ?>"  >
		</div>
	  </dd>
	  <dt>Email</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text"  name ="email" value="<?= $profile->email ?>"  >
		</div>
	  </dd>
	  <dt>Phone</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text"  name ="phone" value="<?= $profile->phone ?>"  >
		</div>
	  </dd>
	  <dt>Address</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text"  name ="address" value="<?= $profile->address ?>"  >
		</div>
	  </dd>
	  <dt>Website</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text"  name ="website" value="<?= $profile->website ?>"  >
		</div>
	  </dd>
	  <dt>Company</dt>
	  <dd>
	  	<div class="input-prepend">
		  <span class="add-on">@</span>
		  <input class="span2" type="text"  name ="company" value="<?= $profile->company ?>"  >
		</div>
	  </dd>
	</dl>
	<div class="span">
		<?= form_hidden('type', 1) ?>
		<?= form_submit('submit_button','Save Changes') ?>
	</div>
	
</div>
</form>
