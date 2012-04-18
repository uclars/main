<?php
class Comment extends AppModel {
        var $name = 'Comment';
	var $recursive = 2;
/*        var $displayField = 'id'; */
        var $belongsTo = array(
                'Topic' => array(
                        'className' => 'Topic',
                        'foreignKey' => 'topic_id',
                        'conditions' => '',
                        'fields' => 'Topic.id, Topic.body, Topic.title',
                        'order' => '',
                        'type' => 'INNER'
                ),
                'User' => array(
                        'className' => 'User',
                        'foreignKey' => 'user_id',
                        'conditions' => '',
                        'fields' => 'User.id, User.username, User.avator_num',
                        'order' => '',
                        'type' => 'INNER' 
		)
	);
}
?>
