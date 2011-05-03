<?php
foreach($topics as $tpdata){
	$me_array = $this->Session->read('Auth.User');
	$me = $me_array['id'];

	echo $tpdata['Topic']['body'];
	echo "<br /><br />";

	echo $this->Form->create('Comment', array('comments'=>'comments', 'action' => 'add'));
	echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;'));
	echo $this->Form->hidden('topic_id',array('value'=>$tpdata['Topic']['id']));
	echo $this->Form->hidden('user_id',array('value'=>$me));
	echo $this->Form->end('GO');
	echo "<br /><br />";

	foreach($comments as $comdata){
		echo $comdata['Comment']['body'];
		echo "　";
		echo $html->link('Comment', array(
			'controller'=>'comments', 
			'action' => 'add', 
			'topicid' => $tpdata['Topic']['id'], 
			'cid'=>$comdata['Comment']['id']
		));
		echo "<br />";
	}
}

/*
echo "<br />";
echo "<br />";
var_dump($comments);
*/
?>
