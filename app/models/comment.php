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
                )
        );
}
?>
