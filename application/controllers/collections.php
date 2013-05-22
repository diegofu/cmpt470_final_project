<?php


class Collections extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->helper('form');
		$this->load->helper('url');
	}

	function index()
	{
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in to view your collections');
			redirect('/auth/login/');
		}
		$collection = new Collection();
		$conditions = array();
		$page = 1;
		if(isset($author_id)) {
			$conditions['author_id'] = $author_id; 
		}
		$collections_per_page = 10;
		$collection->filtered_collections($this->input->post('search_fields'), $conditions, null, $collections_per_page, ($page-1) * $collections_per_page);
		$total_results = $collection->count_filtered_collections($this->input->post('search_fields'), $conditions);
		$data['total_pages'] = ceil($total_results/$collections_per_page);
		$data['type'] = $this->input->post('type');
		$data['search_fields'] = $this->input->post('search_fields');
		$data['collections'] = $collection;
		$data['js'] = array('search_collections.js');
		$data['view'] = 'all_collections';
		$data['page'] = $page;
		$this->load->view('template/main', $data);
	}

	function view_collection($id)
	{
		$collection = new Collection();
		$collection->get_by_id($id);
		$collection->exercise->get();
		
		if ($collection->exists()) {
			$data['collection'] = $collection;
			$data['username']	= $this->tank_auth->get_username();
			$data['view'] = 'view_collection';
			$this->load->view('template/main', $data);
		} else {
			$this->session->set_usermsg(2, 'The collection you are trying to access does not exist.');
			redirect('auth/login');
		}
	}

	function find_exercises() {
		
		$this->load->view('all_exercises', $data);
	}

	function create()
	{
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in to create an collection');
			redirect('/auth/login/');
		}
		$exercise = new Exercise();
		$conditions = array();
		if($this->input->post('type')) {
			$conditions['type'] = $this->input->post('type');
		}
		$page = 1;
		if(isset($author_id)) {
			$conditions['author_id'] = $author_id; 
		}

		$exercises_per_page = 10;
		$exercise->filtered_exercises($this->input->post('search_fields'), $conditions, null, $exercises_per_page, ($page-1) * $exercises_per_page);
		$total_results = $exercise->count_filtered_exercises($this->input->post('search_fields'), $conditions);
		
		$data['total_pages'] = ceil($total_results/$exercises_per_page);
		$data['type'] = $this->input->post('type');
		$data['search_fields'] = $this->input->post('search_fields');
		$data['plang_selected'] = $this->input->post('language');
		$data['exercises'] = $exercise;
		$data['js'] = array('search_exercises.js', 'upload_collection.js');
		$data['page'] = $page;
		$data['view'] = 'upload_collection';
		$this->load->view('template/main', $data);
	}

	function submit(){
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in to create an exercise');
			redirect('auth/login');
		}
		$collection = new Collection();
		$collection->name = htmlspecialchars($this->input->post('name'));
		$collection->description = htmlspecialchars($this->input->post('description'));

		if($collection->save() && true) {
			$data['success'] = true;
			$data['collection_id'] = $collection->id;
			foreach($this->input->post('exercises') as $e){
				$ce = new Collection_exercise();
				$ce->collection_id = $collection->id;
				$ce->exercise_id = $e;
				$ce->save();
			}
		}else {
			$data['sucesss'] = false;
			foreach( $collection->error->all as $error)
				$this->session->set_usermsg(2, $error);
			// foreach( $solution->error->all as $error)
			// 	$this->session->set_usermsg(2, $error);
			redirect('auth/login');
		}
		$this->session->set_usermsg(1, 'Your collection has been successfully created');
		redirect('collections/view_collection/'.$collection->id);
	}

	function update($author_id = null) {
		$collection = new Collection();
		$conditions = array();
		$page = $this->input->post('page');
		$page = $page? $page : 1;
		if(isset($author_id)) {
			$conditions['author_id'] = $author_id; 
		}
		$collections_per_page = 10;
		$collection->filtered_collections($this->input->post('search_fields'), $conditions, null, $collections_per_page, ($page-1) * $collections_per_page);
		$total_results = $collection->count_filtered_collections($this->input->post('search_fields'), $conditions);
		$data['total_pages'] = ceil($total_results/$collections_per_page);
		$data['collections'] = $collection;
		$data['js'] = array('search_collections.js');
		$data['page'] = $page;
		$this->load->view('all_collections', $data);
	}

}


