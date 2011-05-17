<?php
foreach($topics as $tpdata){
	$me_array = $this->Session->read('Auth.User');
	$me = $me_array['id'];

	echo $tpdata['Topic']['body'];


	///when you already following the topic you are selecting, show 'unfollow', if you haven't followed yet, show 'follow'
	if(in_array($tpdata['Topic']['id'],$following_topic_list)){
		echo "　　".$html->link('unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_topic', 'id'=>$tpdata['Topic']['id']));
	}
	else{
		echo "　　".$html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$tpdata['Topic']['id']));
	}

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
