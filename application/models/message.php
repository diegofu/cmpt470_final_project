<?php

class Message extends DataMapper
{
	var $table = 'message';
	var $has_one = array(
		'from' => array(
			'class' => 'user',
			'join_table' => 'message'
		),
		'to' => array(
			'class' => 'user',
			'join_table' => 'message'
		)
	);

	var $validation = array(
		'subject' => array(
			'label' => 'Title',
			'rules' => array('required'),
		),
		'content' => array(
			'label' => 'Body',
			'rules' => array('required'),
		),
	);

	function sender() {
		$user = new User;
		$user->get_by_id($this->from);
		return $user;
	}

	function receiver() {
		$user = new User;
		$user->get_by_id($this->to);
		return $user;
	}
}