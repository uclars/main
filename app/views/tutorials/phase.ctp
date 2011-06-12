<?php
switch($phase){
	case 10:
		echo "You can follow topics you get interested.<br />";
		echo "Let's follow a topic.<br />";
		break;
	case 20:
		foreach($topics as $tpdata){
			$me_array = $this->Session->read('Auth.User');
			$me = $me_array['id'];

			echo $tpdata['Topic']['body'];
			if($tpdata['Topic']['id']==1){
				echo "　　".$html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_topic', 'id'=>$tpdata['Topic']['id']));
			}
			echo "<br />";
		}
		break;
	case 30:
		echo "now you see the timeline of \"where are you from?\" you have just followed<br />";
		echo "Let's follow the user. ";
		echo $html->link('go', array('controller'=>'tutorials', 'action'=>'phase',30, 1));
		echo "<br /><br />";

		break;
	case 40:
		echo "now, you can follow users, too.<br />";
		echo "click my name tavivit and go to my profie page <br /><br />";

		echo "<table><tr><td rowspan=4>";
		echo $this->Html->image('/img/profile/suzuki.png');
		echo "</td></tr>";
		echo "<tr><td>";
		echo $html->link('tavivit', array('controller'=>'tutorials', 'action'=>'phase',40, 1));
		echo "</td><td></td></tr>";
		echo "<tr><td colspan=2>";
		echo "click my name!";
		echo "</td></tr><tr><td colspan=2>";
		echo "tavivit comment";
		echo "</td></tr></table>";

		break;
	case 50:
		echo $html->image('/img/profile/suzuki.png');
		echo "　　tavivit";

		echo "　　".$html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_user', 'id'=>'41'));
		echo "<br /><br />";

		break;
	case 60:
		echo "now let's try putting comments<br />";
		echo "before that, we want your nickname.<br />";
		echo $this->Form->create(
			null, array('url' => 
				array('controller'=>'tutorials', 'action' => 'phase', 60, 1)
			)
		    );
		echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;'));
		echo $this->Form->end('GO');

		break;
	case 70:
		echo "you see my comment for you?<br />";
		echo "now, choose your avator.<br /><br />";
		echo $html->link('go pic my avator', array('controller'=>'tutorials', 'action'=>'phase', 70, 1));
		break;
	case 80:
		echo "Which one do you like?<br /><br />";

		echo $this->Form->create(
			null, array('url' => 
				array('controller'=>'tutorials', 'action' => 'phase', 80, 1)
			)
		    );
		echo "<table><tr><td>";
		echo $this->Form->input('avator',
					array(
						'type'=>'radio',
						'options'=>array("white","blue"),
						'legend'=>false,
						'div'=>false,
						'label'=>false,
						'separator'=>'</td><td>',
						'value'=>'0'
					)
				   );
		echo "</td></tr>";
		echo "<tr><td><img src='/img/profile/74/74.png' /></td><td><img src='/img/profile/74/74.png' /></td></tr>";
		echo "<tr><td>";
		echo $this->Form->submit('submit');
		echo $this->Form->end();
		echo "</td><td></td></tr>";
		echo "</table>";
		break;
	case 90:
		echo "Let's put your comment on this.<br /><br />";

		echo $this->Form->create('Comment', array('controller'=>'comments', 'action' => 'add'));
		echo $this->Form->hidden('topic_id',array('value'=>'1'));
		echo $this->Form->text('body', array('style' => 'width:500px; height:45px; font-size:2em; padding-top:3px;'));
		echo $this->Form->end('GO');

		break;
	case 100:
		echo "Congraturations!!<br />";
		echo "you've just completed the tutorial.<br /><br />";
		echo "now go to your home, adn enjoy this serivce!<br />";
		echo  $html->link('go to home', array('controller'=>'tutorials', 'action' => 'phase', 100, 1));;

		break;

}

//show the time line
if(!($phase == 10 or $phase == 20 or $phase == 50 or $phase == 60 or $phase == 80)){
		echo "<table>";
	foreach($datas as $topic){
			echo "<tr><td rowspan=4>";
				echo $this->Html->image(h($topic['User']['profile_img']));
			echo "</td></tr>";
			echo "<tr><td>";
				echo h($topic['User']['username']);
			echo "</td>";
			echo "<td>";
				echo $this->NiceNumber->getNiceTime(h($topic['Comment']['created']));
			echo "</td></tr>";
			echo "<tr><td colspan=2>";
				echo h($topic['Comment']['body']);
			echo "</td></tr>";
			echo "<tr><td colspan=2>";
				echo h($topic['Topic']['body']);
			echo "</td></tr>";
	}
		echo "</table>";
}
	



/*
$tm = in_array(3,$user_list);
echo "VIEW on the HOME bottom!!<BR>";
echo "<PRE>";
var_dump($user_list);
echo "</PRE>";
*/


?>

