<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Final Project</title>
	<? include('css.php') ?>
</head>
<body>
	<div class="wrapper">
		<input type="hidden" id="base_url" value="<?= site_url() ?>">
		<? $this->load->view('template/header.php'); ?>
		
		
		<div class="nav">
		</div>
		<div class="container">
			
			<?= $this->load->view($view) ?>
			<!-- <? $this->load->view('template/sidebar.php') ?> -->
			
		</div>
		
		<div class="footer">
		</div>
	</div>
	<? include('javascripts.php') ?>
</body>
</html>