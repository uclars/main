<?php
class FollowingTopics extends AppModel
{
	var $name = 'FollowingTopics';

	 //var $belongsTo = 'Topic';
	var $belongsTo = array(
		'Topic' => array(
			'className' => 'Topic',
			'foreignKey' => 'following_topic_id',
			'conditions' => '',
			'fields' => 'Topic.title, Topic.body',
			'order' => '',
			'type' => 'INNER'
		)
	);
}

?>
