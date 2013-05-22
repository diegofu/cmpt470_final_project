<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->helper('form');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$view = new View();
			$exercise = new Exercise();
			$user = new User();
			$user->get_by_id($this->tank_auth->get_user_id());
			$exercise->random_exercises(10, $this->tank_auth->get_user_id());
			
			$data['user_view'] = $view;
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['exercises'] = $exercise;
			$data['js'] = array('welcome.js');
			$data['view'] = 'welcome';
			$this->load->view('template/main', $data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
