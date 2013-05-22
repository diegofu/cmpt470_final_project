<?php


class Profiles extends CI_Controller
{
	//autoloading
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
	}

	function _remap($method, $param = array())
	{
		if (method_exists($this, $method))  {
			if ($method == 'index') {
				$username = $this->tank_auth->get_username();
				redirect("/$username");
			}
			if (isset($params)) {
				$this->$method($params);
			} else {
				$this->$method();
			}
		} else {
			$this->index($method);
		}
	}

	function index($username)
	{
		if (!$this->tank_auth->is_logged_in()) {	
			$this->session->set_usermsg(2, 'Please log in to view ' . $username . '\'s profile');
			redirect('/auth/login/');
		}
		$u = new User();
		$u->get_by_username($username);
		$profile = new Profile();
		if ($u->exists()) {
			$profile->where('user_id', $u->id)->get();
			if (!$profile->exists()) {
				$profile->user_id = $this->tank_auth->get_user_id();
				if (is_null($profile->save())) {
					foreach( $profile->error->all as $error) {
						echo $error;
					}
				}
				//redirect('/profiles/updateProfiles');
			}
		$data['js'] = array('follow.js');
		$data['self'] = ($u->id == $this->tank_auth->get_user_id());
		$data['follow_id'] = $u->id;
		$f = $u->follower->where(array('user_id' => $this->tank_auth->get_user_id()))->get();
		$data['Isfollowing'] = $f->exists();
		$data['view'] = 'profile/user_profile';
		$data['username'] = $username;
		$data['profile'] = $profile;
		$this->load->view('template/main', $data);	
		} else {
			show_404();
		}
	}

	//post
	//update the profile info
	function updateProfiles(){
		if(!$this->tank_auth->is_logged_in()) {	
			$this->session->set_usermsg(2, 'Please log in to update your profile');
			redirect('/auth/login/');
		}
		//data binding with form data
		$profile = new Profile();
		$profile->where('user_id',$this->tank_auth->get_user_id())->get();
		$data['username'] =  $this->tank_auth->get_username();
		//check 1, stands for edit
		//0->edit
		//1->save post
		if($this->input->post('type')==0)
		{
			$data['profile']=$profile;
			$data['view'] = 'profile/user_profile_edit';
			$this->load->view('template/main', $data);
		}
		//otherwise update
		else
		{
			//update other form data
			$profile->user_id = $this->tank_auth->get_user_id();
			$profile->firstname = htmlspecialchars($this->input->post('firstname'));
			$profile->lastname = htmlspecialchars($this->input->post('lastname'));
			$profile->email = htmlspecialchars($this->input->post('email'));
			$profile->phone = htmlspecialchars($this->input->post('phone'));
			$profile->address = htmlspecialchars($this->input->post('address'));
			$profile->website = htmlspecialchars($this->input->post('website'));
			$profile->company = htmlspecialchars($this->input->post('company'));

			if($_FILES['user_avatar']['error'] == 0){
				//upload and update the file
				
				$config['upload_path'] = APPPATH.'images/profile/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite'] = false;
				$config['remove_spaces'] = true;
				$config['max_size'] = '256';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				
				if ( ! $this->upload->do_upload('user_avatar'))
				{
					//$this->session->set_flashdata('message', $this->upload->display_errors('<p class="error">', '</p>'));
					$this->session->set_usermsg(2, 'The image upload is imcomplete.');
					//redirect('profiles');
				}	
				else
				{
					//Image Resizing
					
					$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 140;
					$config['height'] = 140;

					$this->load->library('image_lib', $config);

					if ( ! $this->image_lib->resize()){
						$this->session->set_flashdata('message', $this->image_lib->display_errors('<p class="error">', '</p>'));				
					}
					
				}
			}

			if($_FILES['user_avatar']['error'] == 0){
				
		        $relative_url = 'application/images/profile/'.$this->upload->file_name;
		        $profile->avatar = $relative_url;
		    }
			//Need to update the session information if email was changed
			//$this->session->set_userdata('email', $this->input->xss_clean($this->input->post('user_email')));
			//$this->session->set_flashdata('message', '<p class="message">Your Profile has been Updated!</p>');
			if($profile->save()) {
				$this->session->set_usermsg(1, 'Profile has been successfully updated');
				redirect('profiles/'.$data['username']);
			}else {
				foreach( $profile->error->all as $error)
					$this->session->set_usermsg(2, $error);
			}		
		}		
	}


	function follow()
	{
		if(!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
		
		$f = new User();
		$f->get_by_id($this->input->post('follow_id'));

		if ($f->exists()) {
			$u = new User();
			$u->get_by_id($this->tank_auth->get_user_id());	
			
			if ($this->input->post('do') == "follow") {
				if (!$u->save($f, 'following')){
					foreach( $u->error->all as $error)
						echo $error;					
				}
			} else if ($this->input->post('do') == "unfollow") {
				if (!$u->delete($f, 'following')) {
					foreach( $u->error->all as $error)
						echo $error;					
				}
			} else {
				// TODO: show error
				echo "error 3";
			}
		} else {
			// TODO: show error
			echo "e";
		}
	}	

	function followers() {
		$this->follow_helper('followers');
	}

	function followings() {
		$this->follow_helper('followings');
	}

	function avatar() {
		return isset($this->avatar) ? $this->avatart : 'img/140x140.gif';
	}

	private function follow_helper($type) {
		if(!$this->tank_auth->is_logged_in()) {
			$this->session->set_usermsg(2, 'Please login to see your followers');
			redirect('/auth/login/');
		}
		$user = new User();
		$user->get_by_id($this->tank_auth->get_user_id());
		switch($type) {
			case 'followers':
			$data['users'] = $user->get_followers();
			break;
			case 'followings':
			$data['users'] = $user->get_followings();
			break;
		}
		
		$data['type'] = $type;
		$data['view'] = 'follow';
		$this->load->view('template/main', $data);
	}
}
