<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' =>'input-block-level',
	'placeholder'=>'Email Address',
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<div class="login">
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td class="form-signin-heading"><h2> Forgot Password</h2></td>
	</tr>
	<tr>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?>
			<?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
	</tr>
</table>
<?php echo form_submit(array('value'=>'Get a new password','name'=>'reset', 'class'=>'btn btn-large btn-primary')); ?>
<?php echo form_close(); ?>
<div class="login">