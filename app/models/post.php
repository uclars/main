<?php
class Post extends AppModel {
	var $name = 'Post';
	var $displayField = 'id';
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => 'User.username, User.profile_img',
			'order' => '',
			'type' => 'INNER'
		)
	);
}
?>
