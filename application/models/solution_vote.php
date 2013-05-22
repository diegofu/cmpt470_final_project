<?php 

class Exercise_vote extends DataMapper
{
	var $table = "exercise_vote";
	var $has_one = array('user', 'exercise');

	function number_of_up() {
		return $this->where(array('exercise_id'=> $this->exercise_id, 'vote'=>1))->count();
	}

	function number_of_down() {
		return $this->where(array('exercise_id'=> $this->exercise_id, 'vote'=>0))->count();
	}
}