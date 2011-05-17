<?php
switch($phase){
	case 1:
		echo "You can follow topics you get interested.<br />";
		echo "Let's follow a topic.<br />";
		break;
	case 2:
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
}
	
/*
$tm = in_array(3,$follower_list);
echo "<PRE>";
var_dump($tm);
echo "</PRE>";
*/

?>

