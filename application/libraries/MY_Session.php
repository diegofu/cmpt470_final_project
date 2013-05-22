<?php

class MY_Session extends CI_Session {
	function __construct() {
		parent::__construct();
	}

	/*
	 * 0 - general information (blue)
	 * 1 - success (green)
	 * 2 - error (red)
	 *
	 */
	function set_usermsg($type, $msg){
		switch($type) {
			case 0:
			$text = 'alert-info';
			break;
			case 1:
			$text = 'alert-success';
			break;
			case 2:
			$text = 'alert-error';
			break;
		}
	    $msgs = $this->get_usermsg();
	    if (!$msgs)
	    {
	      $msgs = array();
	    }

	    // objects are not automatically serialized
	    $msgs[] = array($text, $msg);

	    $this->set_userdata('global_message', $msgs);
  	}

  	/**
  	 * get the entire stack of user messages
  	 *
  	 * @access    public
  	 * @return    array of user messages
  	 */
  	function get_usermsg(){
    	return $this->userdata('global_message');
  	}

  	 /**
	   * clear all user messages
	   *
	   * @access    public
	   * @return    void
	   */
	function clear_usermsg()
	{
		$this->unset_userdata('global_message');
	}
}