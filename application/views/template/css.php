<?
	$styles = array(
		'jquery.qtip.css',
		'sidebar.css',
		'bootstrap.min.css',
		'bootstrap-responsive.css',
		'jquery.fancybox.css',
		'css.css',
	);

	// style_sheets should be an array of elements
	// we should try to make all the css into one big file tho
	if(isset($style_sheets))
		$styles = array_merge($style_sheets, $styles);

	foreach($styles as $style)
		echo '<link rel="stylesheet" type="text/css" href="'.site_url('application/css/'.$style).'" media="all" />';
?>
