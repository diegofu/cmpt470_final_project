<?php


class Exercises extends CI_Controller
{
	private $languages;
	private $tags;

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->library('judger');
		$this->load->library('text_format');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->languages = pLang::get_all_languages();
		$this->tags = Tag::get_tags();
	}

	function index()
	{
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in to create an exercise');
			redirect('/auth/login/');
		}
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['language'] = $this->languages;
		$data['tags'] = $this->tags;

		$data['view'] = 'upload_exercise';
		$data['style_sheets'] = array('tag-select.css', 'jquery-ui.css');
		$data['js'] = array('tag-it.js','exercise.js', 'upload_exercise.js');
		$this->load->view('template/main', $data);
	}

	function getTags()
	{
		$result = array();
		foreach ($this->tags as $key => $value) {
			if (stristr($value, $this->input->get('term')))
				$result[$key] = $value;
		}
		echo(json_encode($result));
	}

	function submit(){
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in to create an exercise');
			redirect('auth/login');
		}
		$exercise = new Exercise();
		$exercise->author_id = $this->tank_auth->get_user_id();
		$exercise->title = htmlspecialchars($this->input->post('title'));
		$exercise->solution = $this->input->post('solution');
		$exercise->expected_output = $this->judger->get_output(pLang::get_language_by_id($this->input->post('language')), $this->input->post('solution'));
		$exercise->template = $this->input->post('template');
		$exercise->instruction = htmlspecialchars($this->input->post('instruction'));
		
		$l = new pLang();
		$l->get_by_id($this->input->post('language'));

		if($exercise->save($l)) {
			$data['success'] = true;
			$data['exercise_id'] = $exercise->id;

			//save new tags upon exercise save
			$tags = $this->input->post('tags');
			if (is_array($tags)) {
				foreach ($tags as $v) {
					$tag = new Tag();

					if (in_array($v, $this->tags, TRUE)) {
						$tag->get_by_name($v);
						$exercise->save($tag);
					} else {
						$tag->name = $v;
						$tag->save();
						$exercise->save($tag);
					}
				}
			}
			$u = new User();
			$u->get_by_id($this->tank_auth->get_user_id());
			$u->follower->get();
			foreach ($u->follower as $f) {
				$im = new Message();
				$im->from = $this->tank_auth->get_user_id();
				$im->to = $f->id;	
				$im->subject = 'New exercise from ' . $f->username;
				$im->content = 'New exercise from <a href="'. site_url('profiles/' . $f->username) .'">'. $f->username.'</a> : <a href="'. site_url('exercises/view_exercise/' . $exercise->id) . '">'. $exercise->title .'</a><br /> Have a try ~~';
				$im->send_time = date('Y-m-d H:i:s', now());
				$im->save();				
			}


			$this->session->set_usermsg(1, 'Exercise created successfully');
			redirect('exercises/view_exercise/'.$exercise->id);
		} else {
			$data['sucesss'] = false;
			foreach( $exercise->error->all as $error)
				$this->session->set_usermsg(2, $error);
			redirect('exercises/');
		}
	}

	function browse_exercises($author_id = null) {
		$exercise = new Exercise();
		$conditions = array();
		if($this->input->post('language')) {
			$conditions['language'] = $this->input->post('language');
		}
		$page = 1;
		if(isset($author_id)) {
			$conditions['author_id'] = $author_id; 
			$data['username'] = User::get_username_by_id($author_id);
		}

		$exercises_per_page = 10;
		$exercise->filtered_exercises($this->input->post('search_fields'), $conditions, null, $exercises_per_page, ($page-1) * $exercises_per_page);
		
		$total_results = $exercise->count_filtered_exercises($this->input->post('search_fields'), $conditions);
		
		$data['total_pages'] = ceil($total_results/$exercises_per_page);
		$data['language'] = $this->languages;
		$data['plang_selected'] = $this->input->post('language');
		$data['search_fields'] = $this->input->post('search_fields');
		$data['exercises'] = $exercise;
		$data['js'] = array('search_exercises.js');
		$data['view'] = 'all_exercises';
		$data['page'] = $page;
		$this->load->view('template/main', $data);
	}

	function view_exercise($id) {
		if( !$this->tank_auth->is_logged_in() ) {
			$this->session->set_usermsg(2, 'Please log in to see this exercise');
			redirect('auth/login');
		}
		$exercise = new Exercise();
		$exercise->get_by_id($id);

		$discussions = new Discussion();
		$discussions->get_where(array('exercise_id'=>$id));
		if ($exercise->exists()) {
			if( !$exercise->owned_by($this->tank_auth->get_user_id()) )
				$exercise->add_view_count($this->tank_auth->get_user_id());
			$data['exercise'] = $exercise;
			$data['username']	= $this->tank_auth->get_username();
			$data['view'] = 'view_exercise';
			$data['js'] = array('view_exercise.js');
			$data['discussions'] = $discussions;	
			$data['discussion_view'] = 'view_discussion';
			$this->load->view('template/main', $data);
		} else {
			$this->session->set_usermsg(2, 'The exercise you are trying to access does not exist.');
			redirect('auth/login');
		}
	}

	function edit_exercise($id) {
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in to edit your exercises');
			redirect('/auth/login/');
		}
		$exercise = new Exercise();
		$exercise->get_by_id($id);

		if(!$exercise->exists()) {
			show_404();
		}

		if(!$exercise->owned_by($this->tank_auth->get_user_id())) {
			$this->session->set_usermsg(2, 'Sorry, but you cannot edit exercises upload by other people');
			redirect('/exercises/view_exercise/' . $exercise->id);
		}
		
		$data['username'] = $this->tank_auth->get_username();
		$data['exercise'] = $exercise;
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['language'] = $this->languages;
		$data['tags'] = $this->tags;
		$data['style_sheets'] = array('tag-select.css', 'jquery-ui.css');
		$data['js'] = array('tag-it.js','exercise.js', 'edit_exercise.js');
		$data['view'] = 'edit_exercise';
		$this->load->view('template/main', $data);
	}

	function submit_edit() {
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in...');
			redirect('/auth/login/');
		}
		
		$exercise = new Exercise();
		$exercise->get_by_id($this->input->post('exercise_id'));
		
		if(!$exercise->exists()) {
			show_404();
		}

		if(!$exercise->owned_by($this->tank_auth->get_user_id())) {
			$this->session->set_usermsg(2, 'Sorry, but you cannot edit exercises upload by other people');
			redirect('/exercises/view_exercise/' . $exercise->id);
		}

		$exercise->author_id = $this->tank_auth->get_user_id();
		$exercise->title = htmlspecialchars($this->input->post('title'));
		$exercise->solution = $this->input->post('solution');
		$exercise->expected_output = $this->judger->get_output(pLang::get_language_by_id($this->input->post('language')), $this->input->post('solution'));
		$exercise->template = $this->input->post('template');
		$exercise->instruction = htmlspecialchars($this->input->post('instruction'));
		
		$l = new pLang();
		$l->get_by_id($this->input->post('language'));

		if($exercise->save($l)) {
			$data['success'] = true;
			$data['exercise_id'] = $exercise->id;

			//save new tags upon exercise save
			$tags = $this->input->post('tags');
			$exercise->tag->delete();
			if (is_array($tags)) {
				foreach ($tags as $v) {
					$tag = new Tag();

					if (in_array($v, $this->tags, TRUE)) {
						$tag->get_by_name($v);
						$exercise->save($tag);
					} else {
						$tag->name = $v;
						$tag->save();
						$exercise->save($tag);
					}
				}
			}
			$this->session->set_usermsg(1, 'Exercise successfully edited');
			redirect('exercises/view_exercise/'.$exercise->id);
		} else {
			$data['sucesss'] = false;
			foreach( $exercise->error->all as $error)
				$this->session->set_usermsg(2, $error);
			redirect('/exercises/view_exercise/' . $exercise->id);
		}
	}

	function vote_up($exercise_id) {
		$this->vote_helper(1, $exercise_id);
	}
	function vote_down($exercise_id) {
		$this->vote_helper(0, $exercise_id);
	}

	private function vote_helper($value, $exercise_id) {
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'You can only vote after logging in.');
			redirect('/auth/login/');
		}
		$exercise = new Exercise();
		$exercise->get_by_id($exercise_id);
		
		
		if($exercise->author_id == $this->tank_auth->get_user_id()){
			$data['error'] = 'You cannot vote for your own exercise';
		} else {
			if($exercise->voted($this->tank_auth->get_user_id())) {
				$data['error'] = 'You have already voted';
			} else {
				$vote = new Exercise_vote();
				$vote->vote = $value;
				$vote->user_id = $this->tank_auth->get_user_id();
				$vote->exercise_id = $exercise->id;
				$vote->save();

				$data['number'] = $value == 1 ? $vote->number_of_up() : $vote->number_of_down();
			}
		} 
		$data['data'] = json_encode($data);
		$this->load->view('template/ajax-response', $data);
	}

	function do_exercise($id) {
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please log in...');
			redirect('/auth/login/');
		}

		$exercise = new Exercise();
		$exercise->get_by_id($id);
		$data['exercise'] = $exercise;
		$data['view'] = 'do_exercise';
		$data['js'] = array('view_exercise.js', 'do_exercise.js');
		$this->load->view('template/main', $data);
	}

	function update($author_id = null) {
		$exercise = new Exercise();
		$conditions = array();
		if($this->input->post('language') && $this->input->post('language') != 'any') {
			$conditions['language'] = $this->input->post('language');
		}
		$page = $this->input->post('page');
		$page = $page? $page : 1;
		if(isset($author_id)) {
			$conditions['author_id'] = $author_id; 
		}
		$exercises_per_page = 10;
		$exercise->filtered_exercises($this->input->post('search_fields'), $conditions, null, $exercises_per_page, ($page-1) * $exercises_per_page);
		$total_results = $exercise->count_filtered_exercises($this->input->post('search_fields'), $conditions);
		$data['total_pages'] = ceil($total_results/$exercises_per_page);
		$data['exercises'] = $exercise;
		$data['js'] = array('search_exercises.js');
		$data['page'] = $page;
		$this->load->view('exercises_table', $data);
	}

	function random_exercise() {
		$exercise = new Exercise();
		$exercise->random_exercises(1, $this->tank_auth->get_user_id());
		
		$data1['exercise'] = $exercise;
		$data['view'] = $this->load->view('random_exercise', $data1, true);
		$data['created'] = $exercise->created_time;
		$data['id'] = $exercise->id;
		$data['data'] = json_encode($data);
		$this->load->view('template/ajax-response', $data);
	}
}


