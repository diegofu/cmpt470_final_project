<?php

class Exercise extends DataMapper
{
	var $table = 'exercise';
	
	var $has_one = array(
		'author' => array(
			'class' => 'user',
			'join_other_as' => 'author',
			'other_field' => 'exercise'
		),
		'collection' => array(
			'class' => 'collection',
			'join_table' => 'collection_exercise'
		),
		'plang' => array(
			'join_table' => 'programming_language'
		)
	);

	var $has_many = array(
		'submission', 
		'discussion', 
		'view', 
		'exercise_vote',
		'tag' => array(
			'class' => 'tag',
			'join_table' => 'tag_ref' 
		),
	
	);

	var $created_field = 'created_time';

	var $validation = array(
		'title' => array(
			'label' => 'Title',
			'rules' => array('required'),
		),
		'instruction' => array(
			'label' => 'Instruction',
			'rules' => array('required'),
		),
		'solution' => array(
			'label' => 'Solution',
			'rules' => array('required'),
		),
		'expected_output' => array(
			'label' => 'Expected Output',
			'rules' => array('required'),
		),
	);

	function __construct()
	{
		parent::__construct();
	}

	public function get_user() 
	{
		$user = new User();
		$user->get_by_id($this->author_id);
		return $user;
	}

	public function get_submissions($user_id = null) 
	{
		if(isset($user_id)) {
			$this->submission->where('author_id', $user_id);
		}
		$this->submission->get();
		return $this->submission;
	}

	public function get_plang()
	{
		$this->plang->get();
		return $this->plang;
	}

	public function count_discussion()
	{
		return $this->discussion->count();
	}

	public function last_discussion()
	{
		$discussion = $this->discussion->order_by('created_time', 'desc')->get()->limit(1);

		return $discussion->exists() ? $discussion : false;
	}

	public function random_exercises($number, $user_id) {
		$count = $this->db->query("SELECT COUNT(*) AS `count` FROM " . $this->table. " WHERE author_id != " .$user_id)->row(1)->count;
		if($count <= $number) 
			$offset = 1;
		else {
			$offset = rand(1, $count);
			if( ($offset + $number) > $count)
				$offset -= $number;
		}
		//var_dump($offset);
		$this->limit($number)->where(array('author_id !='=>$user_id, 'id >='=>$offset))->get();
		return $this;
	}

	// a user can only add a view count in every 3 days
	// why 3 days? because Diego rocks!
	public function add_view_count($user_id)
	{
		$date = date('Y-m-d H:i:s', strtotime('-3 days'));

		if($this->view->where(array('user_id'=>$user_id, 'created_time >=' => $date))->count() == 0) {
			$this->view->user_id = $user_id;
			$this->view->exercise_id = $this->id;
			$this->view->save();
		}
	}

	public function view_count()
	{
		return $this->view->count();
	}

	public function vote_up() {
		return $this->exercise_vote->where('vote', '1')->count();
	}

	public function vote_down() {
		return $this->exercise_vote->where('vote', '0')->count();
	}


  /**
   * Return if this exercise is owned by the user
   */
	public function owned_by($id) {
		return is_numeric($this->id) && ($this->author_id == $id);
	}

	public function voted($user_id) {
		return $this->exercise_vote->where( array('exercise_id'=>$this->id, 'user_id'=>$user_id) )->count() > 0;
	}

	  /**
	   * returns a list of all assignments filtered by given parameters
	   *
	   * @param {array} $conditions : filters
	   * @param {array} $order_by : descending order of exercise created dates
	   * @param {integer} $limit :  limiting the result set
	   * @param {integer} $start :  starting row for the result set
	   *
	   * @return {array} : a list of applications satisfying giving filters
	   */
	 public function filtered_exercises( $search_string = null, $conditions = null, $order_by = null, $limit = null, $start = null )
	 {

	 	// needs extensive tests because I have no idea how the priority of the queries are executed
	 	if(!is_array($conditions)) {
	 		$conditions = array();
	 	}

	 	$query = 'SELECT DISTINCT e.* from ' . $this->table . 
	 	' e LEFT JOIN tag_ref r ON r.exercise_id = e.id LEFT JOIN tag t ON t.id = r.tag_id
	 	 WHERE ';
	 	if( is_string($search_string) ) {
	 		$query .= ' ( (`title`) = NULL ';
	 		$string_array = explode(' ', strtoupper($search_string));
	 		foreach($string_array as $s) {
	 			$query .= 'OR UPPER(`title`) LIKE "%'.$s.'%" 
	 						OR UPPER(`instruction`) LIKE "%'.$s.'%"
	 						 OR UPPER(`name`) LIKE "%' .$s . '%"';

	 		}
	 		$query .= ')';
			if(isset($conditions)) {
		 		$query .= ' AND';
		 	}
	 	}
	 	
	 	$query .= ' TRUE';
	 	if(isset($conditions['language'])) {
	 		$query .= ' AND e.plang_id = '. $conditions['language'];
	 	}

	 	if(isset($conditions['difficulty'])) {
	 		$query .= ' AND e.difficulty = '. $conditions['difficulty'];
	 	}

	 	if(isset($conditions['author_id'])) {
	 		$query .= ' AND e.author_id = ' .$conditions['author_id'];
	 	}

	 	if(isset($limit)) {
	 		$query .= ' LIMIT ' . (isset($start) ? $start : '0') . ', ' . $limit;
	 	}

	 	if(isset($order_by) ){
	 		$query .= ' ORDER BY ' + $order_by;
	 	}
	 	
	 	$this->query($query);
	 	return $this->exists() ? $this : NULL;
	 	
	 }

	 public function count_filtered_exercises($search_string = null, $conditions = null)
	 {

	 	// needs extensive tests because I have no idea how the priority of the queries are executed
	 	if(!is_array($conditions)) {
	 		$conditions = array();
	 	}
	 	$query = 'SELECT count(DISTINCT e.id) as numrows from ' . $this->table . 
	 	' e LEFT JOIN tag_ref r ON r.exercise_id = e.id LEFT JOIN tag t ON t.id = r.tag_id
	 	 WHERE ';
	 	if( is_string($search_string) ) {
	 		$query .= ' ( (`title`) = NULL ';
	 		$string_array = explode(' ', strtoupper($search_string));
	 		foreach($string_array as $s) {
	 			$query .= 'OR UPPER(`title`) LIKE "%'.$s.'%" 
	 						OR UPPER(`instruction`) LIKE "%'.$s.'%"
	 						 OR UPPER(`name`) LIKE "%' .$s . '%"';

	 		}
	 		$query .= ')';
			if(isset($conditions)) {
		 		$query .= ' AND';
		 	}
	 	}
	 	
	 	$query .= ' TRUE';
	 	if(isset($conditions['language'])) {
	 		$query .= ' AND plang_id = '. $conditions['language'];
	 	}

	 	if(isset($conditions['difficulty'])) {
	 		$query .= ' AND difficulty = '. $conditions['difficulty'];
	 	}

	 	if(isset($conditions['author_id'])) {
	 		$query .= ' AND author_id = ' .$conditions['author_id'];
	 	}
	 	
	 	$result = $this->db->query($query)->row(1);
	 	return $result->numrows;
	 }

}
