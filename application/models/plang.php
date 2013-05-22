<?php 


class pLang extends DataMapper
{
	var $table = "programming_language";

	var $has_many = array(
		'exercise' => array(
			'join_self_as' => 'plang',
			'join_table' => 'exercise'
		)
	);

	function __construct()
	{
		parent::__construct();
	}

	static public function get_all_languages()
	{
		$lang = new pLang();
		$lang->get();
		
		$langs = array();
		foreach ($lang as $t) {
			$langs[$t->id] = $t->name;
		}

		return $langs;
	}

	static public function get_language_by_id($id)
	{
		$lang = new pLang();
		$lang->get_by_id($id);

		return $lang->name;
	}
}
