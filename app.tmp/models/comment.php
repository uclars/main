<?php
//### CREATE 2010/06/20 Pyon ###
class Comment extends AppModel {

	var $name = 'Comment';
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => 'User.name',
			'order' => '',
			'type' => 'INNER'
		),
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => 'Article.user_id',
			'order' => '',
			'type' => 'INNER'
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