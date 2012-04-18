<?php
echo "<div id='navigation_wrapper'>";
	echo "<div id='navigation'>";
		echo "<div class=ntitle>PROFILE</div>";
			echo "<pre><span style='font-weight:bold;'>name:</span> ".$target_user['User']['username']."</pre>";
			echo $html->image($target_user['Master_avators']['url96'], array('style'=>'vertical-align:top'));
			echo "<pre><span style='font-weight:bold;'>image: </span>".$target_user['Master_avators']['name']."</pre>";
			//echo "<pre><span style='font-weight:bold;'>about: </span>".$target_user['User']['about']."</pre>";
			echo "<div style='font-weight:bold;text-align:left;margin-left:10px;'>following topics: </div>";

$topic_array=array();
foreach($following_topics as $ftopics){
        if(!in_array($ftopics['FollowingTopics']['following_topic_id'], $topic_array)){
                array_push($topic_array, $ftopics['FollowingTopics']['following_topic_id']);
                echo "<div style='text-align:left;margin-left:10px;'>".$html->link($ftopics['Topic']['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$ftopics['FollowingTopics']['following_topic_id']))."</div>";
		echo "<div style='color:#aaa; text-align:left;margin-left:10px;'>-------</div>";	
        }
}
		echo "</div>";
	echo "</div>";
?>
