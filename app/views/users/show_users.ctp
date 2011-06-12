<?php
$me_array = $this->Session->read('Auth.User');
$me = $me_array['id'];

echo $html->image($target_user['User']['profile_img']);
echo "　　".$target_user['User']['username'];

//when the target user is you, show following user list and unfollow link
//when the target user is not you, show the following link if you haven't followed yet.
if($target_user['User']['id']==$me){
	if(in_array($target_user['User']['id'],$follower_list)){
		echo "　　you are following";
	}
}
else{
	if(in_array($target_user['User']['id'],$my_follower_list)){
		echo "　　you are following";
	}
	else{
		echo "　　".$html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_user', 'id'=>$target_user['User']['id']));
	}
}
echo "<br /><BR />";

if($target_user['User']['id']===$me){
	echo "You are following:<br />";
}
else{
	echo $target_user['User']['username']." is following:<br />";
}


foreach($user_list as $ulist){
	if(in_array($ulist['User']['id'],$follower_list)){
		if($ulist['User']['id']!=$target_user['User']['id']){//don't show when user follows own
			echo $html->link($ulist['User']['username'], array('controller'=>'users', 'action'=>'show_users', 'id'=>$ulist['User']['id']))."　";
			if($ulist['User']['id']===$me_array['id']){
				echo "　it's you!";
			}
		}
		if($target_user['User']['id']===$me_array['id']){
			echo $html->link('unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_user', 'id'=>$ulist['User']['id']));
		}	
		echo"<br />";
	}
}
echo "<br />";
echo "Topics you created:<br />";
foreach($target_topics as $ttopics){
	echo $ttopics['Topic']['body']."<BR />";
}

echo "<br />";
echo "Comments you wrote:<br />";
foreach($target_comments as $tcomments){
	if($target_user['User']['id']===$me_array['id']){
		echo $tcomments['Comment']['body']." ".$html->link('delete', array(
				'controller' => 'comments',
				'action' => 'delete',
				'cid' => $tcomments['Comment']['id']
			));
		echo "  ";
		echo $html->link(h($tcomments['Topic']['body']), array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$tcomments['Topic']['id']));
		echo "<BR />";
	}
	else{
		echo $tcomments['Comment']['body'];
		echo "  ";
		echo $html->link(h($tcomments['Topic']['body']), array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$tcomments['Topic']['id']));
		echo "<BR />";
	}
}


/*
$tm = in_array(3,$follower_list);
echo "<PRE>";
var_dump($tm);
echo "</PRE>";
*/

?>

