<?php
class User extends AppModel
{
	var $name = 'User';
	var $belongsTo = array(
		'Master_avators' => array(
			'className' => 'Master_avators',
			'foreignKey' => 'avator_num',
			'conditions' => '',
			'fields' => 'Master_avators.name, Master_avators.url24, Master_avators.url32, Master_avators.url48, Master_avators.url64, Master_avators.url96, Master_avators.url128, Master_avators.url192',
			'order' => '',
			'type' => 'INNER'
		)
	);

/*
	var $validate = array(
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'put your email',
				'last' => true
			),
			'email' => array(
				'rule' => array('email', true),
				'message' => 'put correct email address'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'this is already taken'
			)
		),
		'username' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'put something!',
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 3),
				'message' => 'username is less than 3 letters'
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'on' => 'create',
				'message' => 'Username must be only letters and numbers'
			)
		),
		'password_new' => array(
			'notEmpty' => array(
                                'rule' => 'notEmpty',
                                'message' => 'put something!',
                                'last' => true
                        ),
                        'alphaNumeric' => array(
                                'rule' => 'alphaNumeric',
                                'required' => true,
                                'on' => 'create',
                                'message' => 'Username must be only letters and numbers'
                        ),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'allowEmpty' => true,
				'message' => 'min 6 characters',
				'last' => true
			)
		),
		'password_chk' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'on' => 'create',
				'message' => 'put password again',
				'last' => true
			),
			'sameCheck' => array(
				'rule' => array('sameCheck', 'password_new'),
				'message' => 'different password'
			)
		)
	);
	var $hasMany = array('Post');
*/
}
?>
