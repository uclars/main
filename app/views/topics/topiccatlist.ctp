<?php
foreach($topic_cat as $tpcdata){
echo "<div class='comment'>";
	echo "<div class='comment_pic'>";
		echo $html->image($tpcdata['Master_categories']['url']);
	echo "</div>";
	echo "<div class='commnet_body'>";
		echo  $html->link($tpcdata['Topic']['title'], array('controller'=>'topics', 'action'=>'show_topic', 'topicid'=>$tpcdata['Topic']['id']))." ";
	echo "</div>";
/*
	echo "<div class='comment_text'>";
		if(in_array($tpcdata['Topic']['id'],$following_topic_list)){
			echo $html->link('unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_topic', 'id'=>$tpcdata['Topic']['id']));
		}
		else{
			echo $html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$tpcdata['Topic']['id']));
		}
	echo "</div>";
*/
	echo "<div class='comment_text'>";
	echo " follower ";
		echo "<span class='num'>";
			///if there is number, show the nnum. if there is no number, show 0
			if(!empty($tpcdata['Following_topic_numbers']['count'])){
				echo $tpcdata['Following_topic_numbers']['count'];
			}
			else{
				echo "0";
			}
		echo "</span>";
		echo "  | comments ";
		echo "<span class='num'>";
			///if there is number, show the nnum. if there is no number, show 0
			if(!empty($tpcdata['Comment_topics']['Count'])){
				echo $tpcdata['Comment_topics']['Count'];
			}
			else{
				echo "0";
			}
		echo "</span>";
	echo "</div>";
echo "</div>";
echo "<div style='clear:both'></div>";
}

echo "<div style='clear:both'></div>";

/*
echo "<br />";
echo "<br />";
var_dump($comments);
*/
?>
