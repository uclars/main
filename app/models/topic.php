<?php
class Topic extends AppModel {
	var $name = 'Topic';
/* Number of comment on each Topic
	var $hasOne = array(
		'Comment_topics' => array(
			'className' => 'Comment_topics',
			'foreignKey' => 'topic_id',
			'conditions' => '',
			'fields' => 'Comment_topics.topic_id, Comment_topics.count',
			'order' => ''
		)
	);
*/
	var $hasOne = array(
		'Following_topic_numbers' => array(
			'className' => 'Following_topic_numbers',
			'foreignKey' => 'following_topic_id',
			'conditions' => '',
			'fields' => 'Following_topic_numbers.following_topic_id, Following_topic_numbers.count',
			'order' => ''
		),
		'Comment_topics' => array(
			'className' => 'Comment_topics',
			'foreignKey' => 'topic_id',
			'conditions' => '',
			'fields' => 'Comment_topics.topic_id, Comment_topics.Count',
			'order' => ''
		)
	);

	var $belongsTo = array(
		'Master_categories' => array(
			'className' => 'Master_categories',
			'foreignKey' => 'category',
			'conditions' => '',
			'fields' => 'Master_categories.name, Master_categories.url',
			'order' => '',
			'type' => 'INNER'
		)
	);

	var $validate = array(
		'title' => array(
			'rule' => array('between', 5, 100),
			'message' => 'Max 100 characters long'
		),
		'body' => array(
			'rule' => array('between', 5, 1000),
			'message' => 'Max 1000 characters long'
		)
	);

}
?>
