


<? $scripts = array(

	'lib/jquery-1.8.2.min.js',
	'lib/jquery.form.js',
	'lib/jquery.validate.min.js',
	'lib/jquery.qtip.js',
	'qtip_helper.js',
	'lib/bootstrap.js',
	'lib/jquery.sidebar.js',
	'lib/jquery-ui.js',
	'lib/jquery.bpopup-0.7.0.min.js',
	'lib/ace/ace.js',
	'lib/ace/mode-c_cpp.js',
	'lib/ace/theme-eclipse.js',
	'jquery.fancybox.js',
	'messager.js',
	); 

	// here js should be an array of js files needs to be included
	if(isset($js))
		$scripts = array_merge($scripts, $js);

	foreach($scripts as $script)
		echo '<script type="text/javascript" src="'.site_url('application/js/'.$script).'"></script>';
?>
