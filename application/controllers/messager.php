<?php


class Messager extends CI_Controller
{
	private $message_per_page = 20;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->library('tank_auth');
	}

	function index() 
	{
		$this->message_box();
	}

	public function message_box()
	{
		$in = new Message();
		$in_count = $in->where(array('to' => $this->tank_auth->get_user_id(), 'deleted_by_to' => 'FALSE'))->count();
		$in->clear();
		$in->get_where(array('to' => $this->tank_auth->get_user_id(), 'deleted_by_to' => 'FALSE'), $this->message_per_page, 0);

		$data['inbox'] = $in;
		$data['total_inbox_pages'] = ceil($in_count / $this->message_per_page);
		$data['page'] = 1;

		$out = new Message();
		$out_count = $out->where(array('from' => $this->tank_auth->get_user_id(), 'deleted_by_from' => 'FALSE'))->count();
		$out->clear();
		$out->get_where(array('from' =>$this->tank_auth->get_user_id(), 'deleted_by_from' => 'FALSE'), $this->message_per_page, 0);
		
		$u = new User();

		$data['outbox'] = $out;
		$data['total_outbox_pages'] = ceil($out_count / $this->message_per_page);
		$data['view'] = 'message';
		$data['js'] = array('message.js');
		$this->load->view('template/main', $data);
	}

	function fetch_page($user_id = null)
	{
		if (!$this->tank_auth->is_logged_in()){ 
			redirect('/auth/login/');
		}
		$data = array();
		if(isset($user_id)) {
			$user = new User();
			$user->get_by_id($user_id);
			$data['username'] = $user->username;
		}

		$this->load->view('message_table', $data);		
	}

	function send()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		$u = new User();
		$u->get_by_username($this->input->post('to'));
		$data = array();
		if($u->id == $this->tank_auth->get_user_id()) {
			$data['err'] = 'Wh do you want to send a message to yourself?';
		}else{
			if(!$u->exists()){
			$data['err'] = 'The user you are sending does not exist';
			}
			else {
				$im = new Message();
				$im->from = $this->tank_auth->get_user_id();
				$im->to = $u->id;
				$im->subject = htmlspecialchars($this->input->post('subject'));
				$im->content = htmlspecialchars($this->input->post('content'));
				$im->send_time = date('Y-m-d H:i:s', now());
				if(!$im->save()) {
					$data['err'] = 'Your message did not send properly. Please try again';
				}
			}
		}
		
		$data['data'] = json_encode($data);
		$this->load->view('template/ajax-response', $data);

	}


	function delete($id)
	{
		if (!$this->tank_auth->is_logged_in()) {	
			$this->session->set_usermsg(2, 'Please log in to delete a message');
			redirect('/auth/login/');
		}

		$m = new Message();
		$m->get_by_id($id);

		if ($m->exists()) {
			if ($m->from == $this->tank_auth->get_user_id()) {
				$m->deleted_by_from = TRUE;
			} else if ($m->to == $this->tank_auth->get_user_id()) {
				$m->deleted_by_to = TRUE;
			} else {
				$this->session->set_usermsg(2, 'The message you are trying to delete does not exist');
				redirect('/auth/login/');
			}
			$m->save();
			$this->session->set_usermsg(1, 'Your message has been deleted');
			redirect('messager/');
		} else {
			$this->session->set_usermsg(2, 'The message you are trying to delete does not exist');
			redirect('/auth/login/');
		}
	}

	function read($id)
	{
		if (!$this->tank_auth->is_logged_in()) {	
			$this->session->set_usermsg(2, 'Please log in to view your message');
			redirect('/auth/login/');
		}

		$m = new Message();
		$m->get_by_id($id);
		if($m->from != $this->tank_auth->get_user_id() and $m->to != $this->tank_auth->get_user_id()) {
			$this->session->set_usermsg(2, 'The message does not exist');
			redirect('/auth/login/');
		}
		if ($m->exists()) {
			if ($m->to == $this->tank_auth->get_user_id() && (!$m->deleted_by_to)) {
				$m->read = TRUE;
				$m->save();
				$data['box_type'] = '';
			} else if ($m->from == $this->tank_auth->get_user_id() && (!$m->deleted_by_from)){

			} else {
				$this->session->set_usermsg(2, 'The message you are trying to view does not exist');
				redirect('/auth/login/');
			}

			$u = new User();
			$u->get_by_id($m->from);

			
			$data['to_name'] = $u->username;
			$data['view'] = 'read_message';
			$data['message'] = $m;
			$data['js'] = array('message.js');
			$this->load->view('template/main', $data);
		} else {
			$this->session->set_usermsg(2, 'The message you are trying to view does not exist');
			redirect('/auth/login/');
		}
	}

	function check()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}

		$m = new Message();
		echo $m->where(array('to' => $this->tank_auth->get_user_id(), 'read' => FALSE, 'deleted_by_to' => FALSE))->count();
	}	
}
