<?php

class Discussion extends DataMapper
{
	var $table = 'discussion';
  var $has_one = array('user', 'exercise');

  var $validation = array(
    'content' => array(
      'label' => 'Content',
      'rules' => array('required'),
    ),
  );

  function __construct()
  {
    parent::__construct();
  }

  public function get_user() {
    $user = new User();
    $user->get_by_id($this->author_id);
    return $user;
  }

  public function avatar() {
    $profile = new Profile();
    $profile->where(array('user_id'=>$this->author_id))->get();
    return !is_null($profile->avatar) ? $profile->avatar : 'img/64x64.gif';
  }
}