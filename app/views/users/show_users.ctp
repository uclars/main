<?php
$me_array = $this->Session->read('Auth.User');
$me = $me_array['id'];

echo "<div style='font-weight:bold; font-size:150%;'>Topics you created:</div>";
echo "<div class='comment'>";
if(empty($target_topics)){
	echo "<span style='margin-left:10px;'>no topics yet</span>";
}
else{
	foreach($target_topics as $ttopics){
		echo "<div class='comment_pic'>";
			echo $html->image($ttopics['Master_categories']['url']);
		echo "</div>";
		echo "<div class='topic_body'>";
			echo $html->link($ttopics['Topic']['title'], array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$ttopics['Topic']['id']))."<BR />";
		echo "</div>";
		echo "<br />";
		echo "<br />";
	}
}
echo "</div>";
echo"<div style='clear:both'></div>";
echo "<br /><br />";
echo "<span style='font-weight:bold; font-size:150%;'>Comments you wrote:</span><br />";
foreach($target_comments as $tcomments){
	echo "<div class='comment'>";
		echo "<div class='comment_pic'>".$html->image($target_user['Master_avators']['url48'])."</div>";
	if($target_user['User']['id']===$me_array['id']){
		echo "<div class='comment_body' style='font-weight: bold;'>";
//		echo nl2br(h($tcomments['Comment']['body']))."&nbsp;&nbsp;&nbsp;&nbsp".$html->link('delete', array(
		echo nl2br(h($tcomments['Comment']['body']))."<br />".$html->link('delete', array(
				'controller' => 'comments',
				'action' => 'delete',
				'cid' => $tcomments['Comment']['id']
			));
		echo "</div>";
		echo "<div class='comment_text'>";
			echo $html->link($tcomments['Topic']['title'], array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$tcomments['Topic']['id']));
		echo "</div>";
	}
	else{
		echo "<div class='comment_body' style='font-weight: bold;'>";
			echo nl2br(h($tcomments['Comment']['body']));
		echo "</div>";
		echo "<div class='comment_text'>";
			echo $html->link($tcomments['Topic']['title'], array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$tcomments['Topic']['id']));
		echo "</div>";
	}
	echo "</div>";
	echo "<div style='clear:both'></div>";
}

echo "<br clear=all>";

/*
$tm = in_array(3,$follower_list);
echo "<PRE>";
var_dump($tm);
echo "</PRE>";
*/

/*
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
*/
?>

