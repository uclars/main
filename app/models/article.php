<?php
//### CREATE 2010/06/20 Pyon ###
class Article extends AppModel {

	var $name = 'Article';
	var $belongsTo = array(
		'User' => array(
			'UserName' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => 'User.name',
				'order' => '',
				'type' => 'INNER'
			),
			'PicProfile' => array(
				'className' => 'User',
                                'foreignKey' => 'user_id',
                                'conditions' => '',
                                'fields' => 'User.profile_img',
                                'order' => '',
                                'type' => 'INNER'
			)
		)
	);
	var $validate = array(
		'body' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => '本文を入力してください。',
				'last' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => '本文は255文字以内で入力してください。',
			)
		)
	);

}
?>
