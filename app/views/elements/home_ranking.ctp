<PRE>
<?php
$i=1;
foreach($topic_ranking as $ranking){
	echo $i.". ";
	echo $html->link($ranking['Topic']['title'], array('controller'=>'topics','action'=>'show_topic','topicid'=>$ranking['Topic']['id']));
	echo "<br />";
	echo "<br />";
	$i++;
}
?>
</PRE>
