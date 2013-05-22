<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tag extends DataMapper
{
	var $table = "tag";
	var $has_many = array(
		'exercise' => array(
			'class' => 'exercise',
			'join_table' => 'tag_ref'
		)
	);

	function __construct()
	{
		parent::__construct();
	}

	static public function get_tags()
	{
	    $tag = new Tag();
	    $tag->get();
	    $tags = array();
	    
	    foreach ($tag as $t)
	    {
	    	$tags[$t->id]=$t->name;
	    }
		return $tags;
	}
}
