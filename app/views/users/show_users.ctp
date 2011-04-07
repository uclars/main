<table border='1' cellspacing='0' cellpadding='5' width='500'>
<?php
foreach($user_list as $ulist){
	echo"<tr valign='top'>\n";
	echo"<td>".$ulist['User']['id']."</td>";
	echo"<td>".$ulist['User']['username']."</td>";
	echo"<td>";
	//if users are not followed by this login user, show follow link
	if(in_array($ulist['User']['id'],$follower_list)){
		echo $html->link('unfollow', array('controller'=>'followings', 'action'=>'action', 'do'=>'unfollow_user', 'id'=>$ulist['User']['id']));
	}else{
		echo $html->link('follow', array('controller'=>'followings', 'action'=>'action', 'do'=>'follow_user', 'id'=>$ulist['User']['id']));
	}
	echo"</td>";
	echo"</tr>";
}
?>
</table>
<?php

$tm = in_array(3,$follower_list);

/*
echo "<PRE>";
var_dump($tm);
echo "</PRE>";
*/
?>

