<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Text_Format
{
	function __construct()
	{
	}

	static function text_to_html($code)
	{
		$code = str_replace(" ", "&nbsp;", $code);
		$code = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $code);
		$code = nl2br($code);

		return $code;
	}
}