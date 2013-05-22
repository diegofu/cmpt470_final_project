<?php

class Collection extends DataMapper
{
	var $table = 'collection';
	var $has_many = array(
		'exercise' => array(
			'class' => 'exercise',
			'join_table' => 'collection_exercise'
		)
	);

	var $validation = array(
		'name' => array(
			'label' => 'Name',
			'rules' => array('required'),
		),
		'description' => array(
			'label' => 'Description',
			'rules' => array('required'),
		),
	);



	public function get_user() 
	{
		$user = new User();
		$user->get_by_id($this->author_id);
		return $user;
	}

	public function filtered_collections( $search_string = null, $conditions = null, $order_by = null, $limit = null, $start = null )
	{
	 	// needs extensive tests because I have no idea how the priority of the queries are executed
	 	if(!is_array($conditions)) {
	 		$conditions = array();
	 	}

	 	$query = 'SELECT * from ' . $this->table . ' WHERE ';
	 	if( is_string($search_string) ) {
	 		$query .= ' ( (`name`) = NULL ';
	 		$string_array = explode(' ', strtoupper($search_string));
	 		foreach($string_array as $s) {
	 			$query .= 'OR UPPER(`name`) LIKE "%'.$s.'%" 
	 						OR UPPER(`description`) LIKE "%'.$s.'%"';

	 		}
	 		$query .= ')';
			if(isset($conditions)) {
		 		$query .= ' AND';
		 	}
	 	}
	 	
	 	$query .= ' TRUE';

	 	if(isset($conditions['author_id'])) {
	 		$query .= ' AND author_id = ' .$conditions['author_id'];
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

	public function count_filtered_collections($search_string = null, $conditions = null)
	{

	 	// needs extensive tests because I have no idea how the priority of the queries are executed
	 	if(!is_array($conditions)) {
	 		$conditions = array();
	 	}
	 	$query = 'SELECT COUNT(*) as numrows from ' . $this->table . ' WHERE ';
	 	if( is_string($search_string) ) {
	 		$query .= ' ( (`name`) = NULL ';
	 		$string_array = explode(' ', strtoupper($search_string));
	 		foreach($string_array as $s) {
	 			$query .= 'OR UPPER(`name`) LIKE "%'.$s.'%" 
	 						OR UPPER(`description`) LIKE "%'.$s.'%"';

	 		}
	 		$query .= ')';
			if(isset($conditions)) {
		 		$query .= ' AND';
		 	}
	 	}
	 	
	 	$query .= ' TRUE';
	 	if(isset($conditions['author_id'])) {
	 		$query .= ' AND author_id = ' .$conditions['author_id'];
	 	}
	 	
	 	$result = $this->db->query($query)->row(1);
	 	return $result->numrows;
	}

}
