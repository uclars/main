<?php
class User extends AppModel
{
	var $name = 'User';
	var $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'put something!',
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 3),
				'message' => 'username is less than 3 letters'
			)
/*
			'username' => array(
				'alphaNumeric' => array(
					'rule' => 'alphaNumeric',
					'required' => true,
					'on' => 'create',
					'message' => 'Username must be only letters and numbers'
				)
			)
*/
		)
	);
	var $hasMany = array('Post');
}
?>
