<?php


class Discussions extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->model('Discussion');
	}

	function view_discussion($id) {
		if($this->tank_auth->is_logged_in(FALSE)) {
			redirect('/auth/login/');
		}

		$dicussions = new Discussion();
		$dicussions->get_where(array('exercise_id'=>$id));

		$exercise = new Exercise();
		$exercise->get_by_id($id);
		$data['exercise'] = $exercise;
		$data['discussions'] = $discussions;
		$data['view'] = 'view_discussion';

		$this->load->view('template/main', $data);
	}

	function submit(){
		if($this->tank_auth->is_logged_in(FALSE)) {
			redirect('/auth/login/');
		}

		$discussion = new Discussion();
		$discussion->author_id = $this->tank_auth->get_user_id();
		$discussion->exercise_id = $this->input->post('exercise_id');
		$discussion->content = $this->input->post('body');
		$discussion->created_time = date('Y-m-d H:i:s', now());

		if($discussion->save()) {
			redirect('/exercises/view_exercise/'.$this->input->post('exercise_id'));
		}else {
			foreach( $discussion->error->all as $error)
				$this->session->set_usermsg(2, $error);
			redirect('auth/login');
		}
	}
}


