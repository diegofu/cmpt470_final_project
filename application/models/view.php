<?php

class View extends DataMapper
{
	var $table = 'view';
  	var $has_one = array('exercise');
 	var $has_many = array('user');
	
	var $created_field = 'created_time';
	
	function __construct()
	{
	    parent::__construct();
	}

	function get_exercise() 
	{
		$exercise = new Exercise();
		$exercise->where('id', $this->exercise_id)->get();
		return $exercise;
	}

	function last_ten($user_id) {
		$this->where('user_id', $user_id)->group_by('exercise_id')->limit(10)->get();
		return $this;
	}

	/**
	 *
	 * retrive the most viewed exercises in the last 7 days
	 *
	 **/
	function popular() {
		$date = date('Y-m-d H:i:s', strtotime('-7 days'));
		$this->select('exercise_id, count(*) as numrows')->where('created_time >=', $date)->group_by('exercise_id')->order_by('numrows', 'desc')->limit(10)->get();
		return $this;
	}
}