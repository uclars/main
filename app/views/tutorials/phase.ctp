<?php
switch($phase){
	case 0:
		echo "<div id=\"tutorial0\">";
		echo "<div id=\"facebook\">";
		echo $facebook->login(array('scope'=>'email, user_birthday','size' => 'xlarge'));
		echo "</div>";
		echo "</div>";
		break;
	case 10:
		foreach($topics as $tpdata){
			$me = $me_array['id'];

			echo "<div class='comment'>";
			if($tpdata['Topic']['id']==1){ //Clicable only id=1 topic for tutorial
				echo "<div class='comment_pic'>";
					echo $html->image($tpdata['Master_categories']['url']);
				echo "</div>";
				echo "<div class='topic_body'>";
					echo $html->link(h($tpdata['Topic']['title']), array('controller'=>'tutorials', 'action'=>'phase',10, 1))."&nbsp;&nbsp;&nbsp;← click the topic title!";
				echo "<div class='comment_following'>";
					echo "follower";
				echo "<span class='num'>";
					echo h($tpdata['Following_topic_numbers']['count']);
				echo "</span>";
				echo "</div>";
			}
			else{ //Unclickable
				echo "<div class='comment_pic'>";
					echo $html->image($tpdata['Master_categories']['url']);
				echo "</div>";
				echo "<div class='topic_body'>";
					echo h($tpdata['Topic']['title']);
				echo "<div class='comment_following'>";
					echo "follower";
				echo "<span class='num'>";
				///if there is number, show the number. if there is no number, show 0
				if(!empty($tpdata['Following_topic_numbers']['count'])){
					echo h($tpdata['Following_topic_numbers']['count']);
				}
				else{
					echo "0";
				}
				echo "</div>";
			}
				echo "</div>";
			echo "</div>";
			echo "<div style='clear:both'></div>";
			echo "<br />";
		}
		break;
	case 20:
		echo "<div class='topic'>";
			echo "<div class='topic_pic'>".$html->image($topics[0]['Master_categories']['url'])."</div>";
			echo "<div class='topic_content'>";
				echo "<div class='topic_title'>".h($topics[0]['Topic']['title'])."</div>";
				echo "<div class='topic_social'>";
				echo "<span style='font-weight:bold; font-size:larger;'>";
					echo $html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$topics[0]['Topic']['id']));
				echo "</span>";
				echo "</div>";
			echo "</div>";
			echo "<br /><br />";
			echo "<div class='topic_body'>";
				echo nl2br(h($topics[0]['Topic']['body']));
			echo "</div>";
		echo "</div>";
		echo "<br /><br />";

		break;
	case 30:
		echo "<div class='comment'>";
			echo "<div class='comment_pic'>";
				echo $html->image($first_topic['Master_categories']['url']);
			echo "</div>";
			echo "<div class='comment_body'>";
				echo h($first_topic['Topic']['title']);
			echo "</div>";
			echo "<div class='comment_text'>";
				echo "follower ";
				echo "<span class='num'>";
					echo h($first_topic['Following_topic_numbers']['count']);
				echo "</span>";
			echo "</div>";
		echo "</div>";

		break;
	case 60:
		echo "Input your nickname.<br /><br />";
		if(!empty($error_mssg)){
			echo "<div style='color: red;'>";
			echo $error_mssg;
			echo "</div>";
		}
		echo $this->Form->create(
			null, array('url' =>
				array('controller'=>'tutorials', 'action' => 'phase', 60, 1),
				'name' => 'f'
			)
		);
		echo $this->Form->text('body', array('value'=>'type username!', 'onfocus'=>'this.value=""','onblur'=>'if(this.value=="") this.value="type username!"','style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;'));
		echo $this->Form->end(' POST ');

		break;
	case 70:
		echo "<br /><br /><br />";
		echo "<img src='/img/basic/ribbon/ribbon_48.png' style='vertical-align:middle;'/><span style='font-size:20px;'> Welcome! $username</span><br /><br />";
		echo "Enjoy the Whisprr Life!";

		break;
	case 90:
		echo "<div class='topic'>";
			echo "<div class='topic_pic'>".$html->image($topics[0]['Master_categories']['url'])."</div>";
			echo "<div class='topic_content'>";
				echo "<div class='topic_title'>".h($topics[0]['Topic']['title'])."</div>";
			echo "</div>";
			echo "<div class='topic_body'>";
				echo nl2br(h($topics[0]['Topic']['body']));
			echo "</div>";
		echo "</div>";

		echo $this->Form->create(
			null, array('url' =>
				array('controller'=>'tutorials', 'action' => 'phase', 90, 1)
			)
		);

		echo $this->Form->hidden('topic_id',array('value'=>'1'));
		echo $this->Form->textarea('body', array('cols'=>'50', 'rows'=>'6', 'style'=>'font-size:180%; width:100%;'));
		echo $this->Form->end(' POST ');

		echo "<br /><br />";

		break;
	case 100:
		echo "<div class='topic'>";
			echo "<div class='topic_pic'>".$html->image($topics[0]['Master_categories']['url'])."</div>";
			echo "<div class='topic_content'>";
				echo "<div class='topic_title'>".h($topics[0]['Topic']['title'])."</div>";
			echo "</div>";
			echo "<div class='topic_body'>";
				echo nl2br(h($topics[0]['Topic']['body']));
			echo "</div>";
		echo "</div>";

		break;

}
		


//show the comment line
if($phase == 20 || $phase == 90 || $phase == 100){
	foreach($comments as $comdata){
		echo "<div class='comment'>";
			echo "<div class='comment_pic'>".$html->image($comdata['User']['Master_avators']['url48'])."</div>";
			echo "<div class='comment_body'>";
				echo "<div class='comment_name'>".h($comdata['User']['username'])."</div>";
				echo "<div class='comment_text'>";
					echo nl2br(h($comdata['Comment']['body']));
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div style='clear:both'></div>";
	}
}
?>

