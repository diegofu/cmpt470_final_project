<?php


class Submissions extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('file');
		$this->load->model('Submission');
		$this->load->library('judger');
		$this->load->library('text_format');
	}


	function e_output()	{
		if(!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		echo $this->text_format->text_to_html($this->judger->get_output(pLang::get_language_by_id($this->input->post('language')), $this->input->post('code')));
	}

	function submit(){
		if(!$this->tank_auth->is_logged_in()) {
			$data['redirect']= site_url('auth/login');
		}

		$exercise = new Exercise();
		$exercise->get_by_id($this->input->post('exercise_id'));
		$exercise->submission->get();
		$exercise->plang->get();

		$submission = new Submission();
		$submission->body = $this->input->post('code');
		$submission->exercise_id = $this->input->post('exercise_id');
		$submission->author_id = $this->tank_auth->get_user_id();
		$submission->created_time = date('Y-m-d H:i:s', now());
		$r = $this->judger->judge($exercise->plang->name, $this->input->post('code'), $exercise->solution);		
		if($r['correct']) {
				$submission->correctness = 1;
		} else {
				$submission->correctness = 0;
		}

		if($submission->save()) {

		}else {
			foreach( $submission->error->all as $error)
				$this->session->set_usermsg(2, $error);
		}
		$data['output'] = $r['output'];
		$data['correct'] = $r['correct'];
		$data['data'] = json_encode($data);
		
		$this->load->view('template/ajax-response', $data);
	}
}
