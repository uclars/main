<?php
foreach($topics as $tpdata){
	$me_array = $this->Session->read('Auth.User');
	$me = $me_array['id'];

	echo $tpdata['Topic']['body'];
	if(in_array($tpdata['Topic']['id'],$following_topic_list)){
		echo "　　".$html->link('unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_topic', 'id'=>$tpdata['Topic']['id']));
	}
	else{
		echo "　　".$html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$tpdata['Topic']['id']));
	}
	echo "<br />";

}

/*
echo "<br />";
echo "<br />";
var_dump($comments);
*/
?>
