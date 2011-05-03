<?php
class Comment extends AppModel {
        var $name = 'Comment';
        var $displayField = 'id';
        var $belongsTo = array(
                'Topic' => array(
                        'className' => 'Topic',
                        'foreignKey' => 'topic_id',
                        'conditions' => '',
                        'fields' => 'Topic.id, Topic.body',
                        'order' => '',
                        'type' => 'INNER'
                ),
                'User' => array(
                        'className' => 'User',
                        'foreignKey' => 'user_id',
                        'conditions' => '',
                        'fields' => 'User.id, User.username, User.profile_img',
                        'order' => '',
                        'type' => 'INNER'
                )
        );
}
?>
