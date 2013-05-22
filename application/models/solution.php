<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solution extends DataMapper
{
	var $table = "solution";
	var $has_one = array('user', 'exercise');
	var $validation = array(
        'body' => array(
            'label' => 'Body',
            'rules' => array('required'),
        ),
      );

	function owner() {
		$user = new User();
	    $user->get_by_id($this->author_id);
	    return $user;
	}
}