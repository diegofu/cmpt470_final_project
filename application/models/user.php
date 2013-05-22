<?php

class User extends DataMapper
{
	var $table = 'users';
	
	var $has_many = array(
		'exercise' => array(
			'class' => 'exercise',
			'join_self_as' => 'author',
			'other_field' => 'author'
		),
		'submission' => array(
			'class' => 'user',
			'join_other_as' => 'author',
			'join_self_as' => 'author',
			'join_table' => 'submission',
			'other_field' => 'submission',
			),
		'follower' => array(
			'class' => 'user',
			'other_field' => 'following',
			'join_self_as' => 'follow',
			'join_other_as' => 'user',
			'join_table' => 'follow',
		),
		'following' => array(
			'class' => 'user',
			'join_self_as' => 'user',
			'join_other_as' => 'follow',		
			'other_field' => 'follower',
			'join_table' => 'follow',
		),
		'view' => array(
			'class' => 'view',
			'join_table' => 'view',
		)
	);

	function __construct()
	{
		parent::__construct();
	}

	public function get_followers()
	{
		$this->follower->get();
		return $this->follower;
	}

	public function get_followings()
	{
		$this->following->get();
		return $this->following;
	}

	public function get_exercises()
	{
		$this->exercise->get();
		return $this->exercise;
	}

	public function get_submissions()
	{
		$this->submission->get();
		return $this->submission;
	}

	public static function get_username_by_id($id)
	{
		$u = new User();
		$u->get_by_id($id);
		return $u->username;
	}

	public function recent_views() {
		$this->view->group_by('exercise_id')->get();
		return $this->view;
	}
}
