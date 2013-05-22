<?php

class Submission extends DataMapper
{
	var $table = 'submission';
  	var $has_one = array(
  		'author' => array(
  			'class' => 'user'
  		),
  		'exercise',
  	);

  	var $validation = array(
		'body' => array(
			'label' => 'Body',
			'rules' => array('required'),
		),
	);
}