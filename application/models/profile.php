<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends DataMapper
{
	var $table = "user_profiles";
    var $has_one = array('user');
    function __construct()
  	{
    	parent::__construct();
  	}

}