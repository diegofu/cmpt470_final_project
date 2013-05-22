<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User extends CI_Controller
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
			redirect('/auth/login/');
		}
	}

	// follow one person
	function follow()
	{
		if(!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		if ($this->input->post('do') == "follow") {
			$u = new User();
			$f = new User();
			$u->where('user_id', $this->tank_auth->get_user_id())->get();
			$f->where('user_id', $this->input->post('follow_id'))->get();
			if ($f->exists()) {
				$u->save_follow($f);			
			} else {

			}
		} else if ($this->input->post('do') == "unfollow") {
			$u = new User();
			$f = new User();
			$u->where('user_id', $this->tank_auth->get_user_id())->get();
			$f->where('user_id', $this->input->post('follow_id'))->get();
			if ($f->exists()) {
				$u->delete_follow($f);			
			}
		} else {
			// show errors
		}
	}
}